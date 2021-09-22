<?php

namespace App\Console\Commands;

use App\Models\CardsStaking;
use App\Models\Log\Schedule;
use App\Models\RewardPool;
use App\Models\UserInventory;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class StakingRecalculation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'staking:recalculation';

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
            'command' => 'staking:recalculation',
            'status' => 'start',
        ];
        (new Schedule($log))->save();
        $systemStakingRate = 0;
        UserInventory::query()
            ->join('cards_staking', 'users_inventory.card_id', '=', 'cards_staking.card_id')
            ->each(
                function ($inventory) use (&$systemStakingRate) {
                    $systemStakingRate += $inventory->count * $inventory->staking_rate;
                }
            );

        $urlPool = 'https://gcstaking.ru/account/?resource=balance';
        $responsePool = Http::get($urlPool)->json();
        if ($responsePool['status'] == 'error'){
            $log['status'] = 'error';
            $log['message'] = 'Remote Server Error';
            (new Schedule($log))->save();
            return 0;
        }
        $rewardPool = $responsePool['balance'];
        CardsStaking::all()->each(
            function ($cardStaking) use ($rewardPool, $systemStakingRate) {
                /**
                 * Рассчет wax/h:
                 * Берется размер призового пула, делится на 7 дней, затем на 24 часа, затем на общий стейкинг рейт.
                 * Таким образом получаем, сколько приносить 1 поинт стейкинг рейта в час.
                 * Следовательно, что бы высчитать стейкинг рейт в ваксах для карточки умножаем на стейкинг рейт
                 */
                $cardStaking->wax = round(
                    ($rewardPool / (168 * $systemStakingRate)) * $cardStaking->staking_rate,
                    6
                );
                $cardStaking->save();
            }
        );
        $log['status'] = 'end';
        (new Schedule($log))->save();
        return 0;
    }
}
