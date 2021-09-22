<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\ChangeLocaleController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\ConsoleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EOSController;
use App\Http\Controllers\HoldersController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\Parse\ParseCollectionController;
use App\Http\Controllers\Staking\StakingController;
use App\Http\Controllers\UpdateCardController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index'])
    ->middleware('web')
    ->name('home');

Route::get('/collection', [CollectionController::class, 'index'])
    ->middleware('web')
    ->name('collection');

Route::get('/holders', HoldersController::class)
    ->middleware('web')
    ->name('holders');

Route::get('/staking', [StakingController::class, 'index'])
    ->middleware('auth')
    ->name('staking');

Route::get('/staking/claim', [EOSController::class, 'claim'])
    ->middleware('auth')
    ->name('claim');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('admin')
    ->name('dashboard');

Route::get('/dashboard/update/staking_rate', [DashboardController::class, 'updateStakingRate'])
    ->middleware('admin');

Route::get('/dashboard/update/users_inventory', [DashboardController::class, 'updateUsersInventory'])
    ->middleware('admin');

Route::post('/dashboard/update/card', [UpdateCardController::class, 'edit'])
    ->middleware('admin')
    ->name('update.card');

Route::post('/dashboard/update/cards', [UpdateCardController::class, 'update'])
    ->middleware('admin')
    ->name('update.cards');

Route::get('/console', ConsoleController::class)
    ->middleware('admin')
    ->name('console');

Route::get('/api/get_balance/{userName}', [ApiController::class, 'getBalance']);

Route::get('/parse/collection', ParseCollectionController::class)->middleware('admin');

Route::apiResource('cards', CardController::class);

Route::get('lang/{lang}', [LanguageController::class ,'switchLang'])->name('lang.switch');

/*Auth::routes();*/

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

require __DIR__.'/auth.php';
