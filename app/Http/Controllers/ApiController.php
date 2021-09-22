<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserWallet;
use Illuminate\Http\JsonResponse;

class ApiController extends Controller
{
    /**
     * @param $user
     * @return JsonResponse
     */
    public function getBalance($userName): JsonResponse
    {
        $user = User::query()->firstWhere('wallet', $userName);
        if (empty($user)){
            return response()->json(['status' => 'error', 'message' => "user $userName not found"]);
        }
        $userWallet = UserWallet::query()->firstWhere('user_id', $user->id);
        return response()->json(['status' => 'success', 'balance' => $userWallet->balance]);
    }
}
