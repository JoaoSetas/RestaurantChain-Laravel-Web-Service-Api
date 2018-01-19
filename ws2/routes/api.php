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
//reserva nao pode ser fora de horas
//reserva number
Route::post('register', 'RegisterController@register');

Route::apiResource('service', 'ServiceController');

Route::apiResource('service.route', 'RouteController');

//TODO comment the controller
Route::match(array('GET', 'POST'), 'search/{service?}', 'SearchController@search');