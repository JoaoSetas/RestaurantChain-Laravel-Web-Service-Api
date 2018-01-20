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

});
//TODO unit test
//TODO adicionar outro typo de ws1

Route::post('register', 'RegisterController@register');

Route::apiResource('produto', 'ProdutoController',  
    ['only' => ['index', 'show']]);

Route::apiResource('service', 'ServiceController');

Route::apiResource('service.route', 'RouteController');

//TODO comment the controller
Route::match(array('GET', 'POST'), 'search/{service?}', 'SearchController@index');

//Route::get('reserva/{service}', 'ReservaController@teste');
Route::get('reserva/{service}', 'ReservaController@index');

Route::get('reserva/{service}/{reserva_id}', 'ReservaController@show');