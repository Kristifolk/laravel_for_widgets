<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\UserSettingApiController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Services\ApiRequest;

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
Route::get('client/{client}/pet/create', [PetController::class, 'create'])->name('pet.create');
Route::get('client/{client}/petType', [ApiRequest::class, 'petType'])->name('petType');
Route::get('client/{client}/breedByType/{selectedTypeId}', [ApiRequest::class, 'breedByType'])->name('breedByType');
Route::post('client/{client}/pet/store', [PetController::class, 'store'])->name('pet.store');
