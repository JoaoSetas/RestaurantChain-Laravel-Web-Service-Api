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

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

});

Route::get('/produtos', 'ProdutoController@index')->name('produtos');

Route::get('/produto/{produto}', 'ProdutoController@show');

Route::post('/register', 'RegisterController@register');

