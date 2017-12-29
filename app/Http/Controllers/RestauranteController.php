<?php

namespace App\Http\Controllers;

use App\Restaurante;
use Illuminate\Http\Request;
use App\Transformers\RestauranteTransformer;

class RestauranteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return fractal()
            ->item(Restaurante::findOrFail(env('DB_RESTAURANTE')))
            ->transformWith(new RestauranteTransformer())
            ->toArray();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Restaurante  $restaurante
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Restaurante $restaurante)
    {
        //
    }
}
