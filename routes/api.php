<?php

use Illuminate\Http\Request;
use App\Produto;

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
Route::group(['middleware' => 'auth:api'], function() {

    Route::get('user', function (Request $request) {
        return $request->user();
    });

    Route::patch('restaurante', 'RestauranteController@update');

});

Route::post('register', 'RegisterController@register');

Route::apiResource('produto', 'ProdutoController',  
    ['only' => ['index', 'show']]);

Route::get('restaurante', 'RestauranteController@index');

Route::apiResource('restaurante/menu', 'MenuController');

//TODO finish resources
Route::apiResource('restaurante/reserva', 'ReservaController');

