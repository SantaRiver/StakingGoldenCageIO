<?php

namespace App\Http\Controllers;

use App\Http\Resources\CardsResourceCollection;
use App\Models\Cards;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): View|Factory|Application
    {
        $cards = new CardsResourceCollection(
            Cards::query()
                ->join('cards_img', 'cards.id', '=', 'cards_img.card_id')
                ->join('cards_staking', 'cards.id', '=', 'cards_staking.card_id')
                ->get()
                ->sortBy('create_date')
        );
        $urlPool = 'https://gcstaking.ru/account/';
        $responsePool = Http::get($urlPool)->json();
        if ($responsePool['status'] == 'success') {
            \view()->share('resources', $responsePool['resources']);
        }
        return view('dashboard', ['cards' => $cards]);
    }


    public function updateStakingRate()
    {
        Artisan::call('staking:recalculation');
    }

    public function updateUsersInventory()
    {
        Artisan::call('inventory:update');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
