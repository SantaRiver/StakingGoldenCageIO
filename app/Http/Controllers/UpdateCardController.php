<?php

namespace App\Http\Controllers;

use App\Models\Cards;
use App\Models\CardsStaking;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

class UpdateCardController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function edit(Request $request): JsonResponse
    {
        $cardId = $request->get('id');
        $card = Cards::query()->find($cardId);
        $card->active = $request->get('active', 'off') == 'on';
        $card->save();
        $card_staking = CardsStaking::query()->firstWhere('card_id', $cardId);
        $card_staking->update(['staking_rate' => $request->get('staking_rate')]);
        return response()->json(['status' => 'success']);
    }

    public function update(Request $request): JsonResponse
    {
        $cards = $request->get('cards');
        if ($cards){
            foreach ($cards as $card){
                $cardDb = Cards::query()
                    ->firstWhere('id', $card['id']);
                $cardDb->active = $card['active'] == 'true';
                $cardDb->save();
                CardsStaking::query()
                    ->firstWhere('card_id', $card['id'])
                    ->update(['staking_rate' => $card['staking_rate']]);
            }
            return response()->json(['status' => 'success', 'cards' => $cards]);
        }
        return response()->json(['status' => 'error', 'message' => 'nothing to update']);
    }
}
