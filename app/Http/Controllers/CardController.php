<?php

namespace App\Http\Controllers;

use App\Http\Resources\CardsResource;
use App\Http\Resources\CardsResourceCollection;
use App\Models\Cards;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $cardsResourceCollection = new CardsResourceCollection(
            Cards::query()
                ->join('cards_img', 'cards.id', '=', 'cards_img.card_id')
                ->join('cards_staking', 'cards.id', '=', 'cards_staking.card_id')
                ->get()
        );
        return response()->json(['status' => 'success', 'response' => $cardsResourceCollection]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $cardsResource = new CardsResource(
            Cards::query()
                ->join('cards_img', 'cards.id', '=', 'cards_img.card_id')
                ->join('cards_staking', 'cards.id', '=', 'cards_staking.card_id')
                ->find($id)
        );
        return response()->json(['status' => 'success', 'response' => $cardsResource]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
