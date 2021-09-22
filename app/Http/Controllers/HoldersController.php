<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResourceCollection;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class HoldersController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  Request  $request
     * @return Application|Factory|View
     */
    public function __invoke(Request $request): View|Factory|Application
    {
        $users = User::query()
            ->where('active', '=', 1)
            ->join('users_wallet', 'users.id', '=', 'users_wallet.user_id')
            ->orderByDesc('wax')
            ->take(20)
            ->get();

        return view('holders.index', ['users' => new UserResourceCollection($users)]);
    }
}
