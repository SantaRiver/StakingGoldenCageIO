<?php

namespace App\Http\Controllers;

use App\Models\Log\ErrorTransaction;
use App\Models\Log\UserTransactions;
use App\Models\UserWallet;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class EOSController extends Controller
{
    public function claim()
    {
        $user = Auth::user();
        $userWallet = UserWallet::query()->firstWhere('user_id', Auth::id());
        $userTransaction = UserTransactions::query()
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->first();
        if (!empty($userTransaction)) {
            $lastClaim = new Carbon($userTransaction->created_at);
            $lastClaimTomorrow = $lastClaim->addDay();
            if ($lastClaimTomorrow > Carbon::now()) {
                (new ErrorTransaction(
                    [
                        'user_id' => Auth::id(),
                        'error' => '24 hours have not passed since the last withdrawal',
                    ]
                ))->save();
                return response()->json(
                    [
                        'status' => 'error',
                        'message' => '24 hours have not passed since the last withdrawal'
                    ]
                );
            }
        }
        if ($userWallet->balance == 0) {
            (new ErrorTransaction(
                [
                    'user_id' => Auth::id(),
                    'error' => 'Your wallet balance is zero',
                ]
            ))->save();
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Your wallet balance is zero'
                ]
            );
        }

        $url = 'https://gcstaking.ru/transfer/balance/?user='.$user->getWallet();
        $response = Http::get($url)->json();
        if ($response['status'] == 'success') {
            $userTransaction = new UserTransactions(
                [
                    'user_id' => Auth::id(),
                    'action' => 'claim',
                    'value' => $userWallet->balance
                ]
            );
            $userTransaction->save();
            $userWallet->balance = 0;
            $userWallet->save();
            return response()->json(['status' => 'success']);
        }
        (new ErrorTransaction(
            [
                'user_id' => Auth::id(),
                'error' => 'Internal server error',
            ]
        ))->save();
        return response()->json(['status' => 'error']);
    }

    public function confirm()
    {
    }
}
