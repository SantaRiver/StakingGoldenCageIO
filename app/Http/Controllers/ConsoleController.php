<?php

namespace App\Http\Controllers;

use App\Models\Cards;
use App\Models\Log\Schedule;
use App\Models\User;
use App\Models\UserInventory;
use App\Models\UserWallet;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ConsoleController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        /*User::query()->each(function ($user){
            $userWallets = UserWallet::query()->where('user_id', $user->id)->orderByDesc('wax')->get();
            if ($userWallets->count() > 1){
                $userWallets->first()->delete();
            }
        });*/
        return response()->json();
    }
}
