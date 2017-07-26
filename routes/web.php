<?php

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

Route::get('/', array('uses' => 'coin@index'));
Route::get('/active', array('uses' => 'coin@active'));
Route::get('/active/{coin}', array('uses' => 'coin@activeCoin'));
Route::get('/soon', array('uses' => 'coin@soon'));
Route::get('/soon/{coin}', array('uses' => 'coin@soonCoin'));
Route::get('/donate', array('uses' => 'coin@donate'));
Route::get('/donate/{coin}', array('uses' => 'coin@donateCoin'));
Route::get('/callCoinAPIS', array('uses' => 'coin@callCoinAPIS'));
Route::get('/CallCoinMarketCap', array('uses' => 'coin@CallCoinMarketCap'));
Route::get('/getPrice/{coin}', array('uses' => 'coin@GetPrice'));