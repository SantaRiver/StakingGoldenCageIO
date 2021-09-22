<?php

namespace App\Http\Controllers\Staking;

use App\Http\Controllers\Controller;
use App\Http\Resources\InventoryResourceCollection;
use App\Models\Cards;
use App\Models\Log\UserTransactions;
use App\Models\UserInventory;
use App\Models\UserWallet;
use Carbon\Carbon;
use Carbon\Traits\Creator;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class StakingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View|Factory|Application
     */
    public function index(): View|Factory|Application
    {
        $user = Auth::user();
        $userWallet = UserWallet::query()->firstWhere('user_id', Auth::id());
        if (empty($userWallet)){
            (new UserWallet(['user_id' => Auth::id(), 'balance' => 0]))->save();
        }
        $userTransaction = UserTransactions::query()->where('user_id', Auth::id())->get();
        $totalClaim = $userTransaction->sum('value');

        $lastUserTransaction = UserTransactions::query()
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->first();
        $lastClaim = null;
        $lastClaimTomorrow = null;
        if (isset($lastUserTransaction)){
            $lastClaimTemp = new Carbon($lastUserTransaction->created_at);
            $lastClaim = new $lastClaimTemp;
            $lastClaimTomorrow = $lastClaimTemp->addDay();
        }

        $inventory = [];
        $params = [
            'collection_name' => 'goldencageio',
            'owner' => Auth::user()->getWallet(),
            'limit' => 1500,
        ];
        $assetsUrl = 'https://wax.api.atomicassets.io/atomicassets/v1/assets?'.http_build_query($params);
        $assetsResponse = Http::get($assetsUrl)->json();
        if ($assetsResponse['success']) {
            $assets = $assetsResponse['data'];

            /**
             * Сбор id карточек и их количество
             */
            $templateIds = [];
            foreach ($assets as $asset) {
                if (isset($templateIds[$asset['template']['template_id']])) {
                    $templateIds[$asset['template']['template_id']]++;
                } else {
                    $templateIds[$asset['template']['template_id']] = 1;
                }
            }

            /**
             * Обновление колличества карточек в интвентаре
             **/
            $cards = Cards::query()
                ->whereIn('template_id', array_keys($templateIds))
                ->where('active', '=', 1)
                ->join('cards_img', 'cards.id', '=', 'cards_img.card_id')
                ->join('cards_staking', 'cards.id', '=', 'cards_staking.card_id')
                ->get()
                ->each(
                    function ($card) use ($templateIds) {
                        UserInventory::query()->updateOrCreate(
                            [
                                'user_id' => Auth::id(),
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
                ->where('user_id', Auth::id())
                ->whereNotIn('card_id', $cardsId)
                ->delete();

            /**
             * Получение итогового инвентаря и перерасчет стейкинг-рейта
             */
            $userStakingRate = 0;
            $userWaxStakingRate = 0;
            $inventory = UserInventory::query()
                ->where('user_id', Auth::id())
                ->join('cards', 'users_inventory.card_id', '=', 'cards.id')
                ->join('cards_img', 'users_inventory.card_id', '=', 'cards_img.id')
                ->join('cards_staking', 'users_inventory.card_id', '=', 'cards_staking.id')
                ->get()
                ->sortBy('wax')
                ->each(
                    function ($card) use (&$userStakingRate, &$userWaxStakingRate) {
                        $userStakingRate += $card->count * $card->staking_rate;
                        $userWaxStakingRate += $card->count * $card->wax;
                    }
                );
            $userWallet->staking_rate = $userStakingRate;
            $userWallet->wax = $userWaxStakingRate;
            $userWallet->save();
        } else {
            $inventory = UserInventory::query()
                ->where('user_id', Auth::id())
                ->join('cards', 'users_inventory.card_id', '=', 'cards.id')
                ->join('cards_img', 'users_inventory.card_id', '=', 'cards_img.id')
                ->join('cards_staking', 'users_inventory.card_id', '=', 'cards_staking.id')
                ->get()
                ->sortBy('wax');
        }
        return view(
            'staking.index',
            [
                'inventory' => new InventoryResourceCollection($inventory),
                'user' => $user,
                'user_wallet' => $userWallet,
                'user_transaction' => $userTransaction,
                'total_claim' => $totalClaim,
                'claim_date' => [
                    'last_claim' => $lastClaim,
                    'last_claim_tomorrow' => $lastClaimTomorrow
                ]
            ]
        );
    }

}
