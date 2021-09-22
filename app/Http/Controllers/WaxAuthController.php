<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class WaxAuthController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  CreateUserRequest  $request
     * @return JsonResponse
     */
    public function __invoke(CreateUserRequest $request): JsonResponse
    {
        if (!Auth::check()){
            $user = User::query()->firstWhere('wallet', $request->wallet);
            if (!$user) {
                $user = new User($request->validated());
                $user->save();
            }
            Auth::login($user, true);
        }

        return response()->json(['status' => 'success']);
    }
}
