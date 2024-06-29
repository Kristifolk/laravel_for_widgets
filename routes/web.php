<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\UserSettingApiController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes();

Route::middleware(['check.api.settings'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
});

Route::resource('settingsApi', UserSettingApiController::class);
Route::resource('client', ClientController::class);
Route::get('search',[ClientController::class,'search'])->name('search');
Route::resource('pet', PetController::class);



//Route::resource('clients', ClientController::class);
//Route::resource('pets', PetController::class);

//Route::resource([
//    'clients' => ClientController::class,
//    'pets' => PetController::class,
//    ]);
