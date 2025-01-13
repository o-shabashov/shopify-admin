<?php

use App\Http\Controllers\UserController;
use App\Models\Cassie\CassieUser;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->middleware(['verify.shopify'])->name('home');

Route::controller(UserController::class)->group(function () {
    Route::get('/user/{shopId}/{shopDomain}/settings', 'showSettings');
});

// TODO remove
Route::prefix('test')->group(function () {
    Route::view('/meili-search', 'meili-search-results', CassieUser::find(1)->settings->meilisearch);
    Route::view('/type-search', 'type-search-results', CassieUser::find(1)->settings->typesense);
});
