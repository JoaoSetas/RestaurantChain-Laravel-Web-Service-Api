<?php

namespace App\Http\Controllers;

use App\Restaurante;
use Illuminate\Http\Request;
use App\Transformers\RestauranteTransformer;
use App\Http\Requests\UpdateRestauranteRequest;

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
    public function update(UpdateRestauranteRequest $request)
    {
        $restaurante = Restaurante::findOrFail(env('DB_RESTAURANTE'));

        $restaurante->update($request->all());

        return response()->json($restaurante, 200);
    }
}
