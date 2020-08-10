<?php

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get("/", function() {
    return view("index");
});

// Promocionar Página
// Campaña
Route::resource("campaign", "PromotePage\CampaignController");
// At Set
Route::resource("ad-set", "PromotePage\AdSetController");
// At Creative
Route::resource("ad-creative", "PromotePage\AdCreativeController");
// Ad
Route::resource("ad", "PromotePage\AdController");

