<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
header('Access-Control-Allow-Origin:  *');
header('Access-Control-Allow-Methods:  POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers:  Content-Type, X-Auth-Token, Origin, Authorization, lang');

Route::group(array('namespace' => 'api'), function () {
	Route::post('addOrders',['uses' => 'BurgerController@index']);
	Route::get('getOrderDetails',['uses' => 'BurgerController@getOrderDetails']);
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
