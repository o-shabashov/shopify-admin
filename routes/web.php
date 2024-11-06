<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->middleware(['verify.shopify'])->name('home');

Route::controller(UserController::class)->group(function () {
    Route::get('/user/{shopId}/{shopDomain}/settings', 'showSettings');
});
