<?php

namespace App\Http\Controllers;

use App\Http\Resources\CardsResourceCollection;
use App\Models\Cards;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class CollectionController extends Controller
{
    public function index(): Factory|View|Application
    {
        $cards = new CardsResourceCollection(
            Cards::query()
                ->where('active', '=', 1)
                ->join('cards_img', 'cards.id', '=', 'cards_img.card_id')
                ->join('cards_staking', 'cards.id', '=', 'cards_staking.card_id')
                ->get()
                ->sortBy('wax')
        );
        return view('collection.index', ['cards' => $cards]);
    }


}
