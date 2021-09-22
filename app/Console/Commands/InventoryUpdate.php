<?php

namespace App\Console\Commands;

use App\Models\Cards;
use App\Models\Log\Schedule;
use App\Models\User;
use App\Models\UserInventory;
use App\Models\UserWallet;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class InventoryUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'inventory:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $log = [
            'command' => 'inventory:update',
            'status' => 'start',
        ];
        (new Schedule($log))->save();
        $users = User::all();
        $user = $users->first();
        while ($user != $users->last()) {
            $userWallet = UserWallet::query()->firstWhere('user_id', $user->id);
            if (empty($userWallet)){
                $userWallet = new UserWallet(['user_id' => $user->id]);
            }
            $params = [
                'collection_name' => 'goldencageio',
                'owner' => $user->wallet,
                'limit' => 1500,
            ];
            $assetsUrl = 'https://wax.api.atomicassets.io/atomicassets/v1/assets?'.http_build_query($params);
            $assetsResponse = Http::get($assetsUrl)->json();
            if ($assetsResponse['success']) {
                $assets = $assetsResponse['data'];
                $templateIds = [];
                foreach ($assets as $asset) {
                    if (isset($templateIds[$asset['template']['template_id']])) {
                        $templateIds[$asset['template']['template_id']]++;
                    } else {
                        $templateIds[$asset['template']['template_id']] = 1;
                    }
                }
                $cards = Cards::query()
                    ->whereIn('template_id', array_keys($templateIds))
                    ->where('active', '=', 1)
                    ->join('cards_img', 'cards.id', '=', 'cards_img.card_id')
                    ->join('cards_staking', 'cards.id', '=', 'cards_staking.card_id')
                    ->get()
                    ->each(
                        function ($card) use ($templateIds, $user) {
                            UserInventory::query()->updateOrCreate(
                                [
                                    'user_id' => $user->id,
                                    'card_id' => $card->id,
                                ],
                                [
                                    'count' => $templateIds[$card->template_id]
                                ]
                            );
                        }
                    );

                /**
                 * Удаление записи, если карточки больше нет
                 */
                $cardsId = [];
                foreach ($cards as $card) {
                    $cardsId[] = $card->id;
                }
                UserInventory::query()
                    ->where('user_id', $user->id)
                    ->whereNotIn('card_id', $cardsId)
                    ->delete();
                $userStakingRate = 0.0;
                $userWaxStakingRate = 0.0;
                UserInventory::query()
                    ->where('user_id', $user->id)
                    ->join('cards', 'users_inventory.card_id', '=', 'cards.id')
                    ->join('cards_img', 'users_inventory.card_id', '=', 'cards_img.id')
                    ->join('cards_staking', 'users_inventory.card_id', '=', 'cards_staking.id')
                    ->get()
                    ->each(
                        function ($card) use (&$userStakingRate, &$userWaxStakingRate) {
                            $userStakingRate += $card->count * $card->staking_rate;
                            $userWaxStakingRate += $card->count * $card->wax;
                        }
                    );
                $userWallet->staking_rate = $userStakingRate;
                $userWallet->wax = $userWaxStakingRate;
                $userWallet->save();
                $user = $users->pop();
            } elseif ($assetsResponse['message'] == 'Rate limit') {
                sleep(5);
            }
        }
        $log['status'] = 'end';
        (new Schedule($log))->save();
        return 0;
    }
}
