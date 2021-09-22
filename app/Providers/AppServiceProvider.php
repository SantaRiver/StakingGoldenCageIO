<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;

use function session;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $locale = App::getLocale();
        if (Auth::check()){
            $user = User::query()->find(Auth::id());
            $locale = $user->locale;
            App::setLocale($locale);
            dd(App::getLocale());
        }
        View::share(['locale' => $locale]);
    }
}
