<?php

namespace App\Http\Controllers;

use App\Reserva;
use Illuminate\Http\Request;
use App\Transformers\ReservaTransformer;
use App\Http\Requests\StoreReservaRequest;
use App\Http\Requests\UpdateReservaRequest;
use Carbon\Carbon;
use App\Restaurante;

class ReservaController extends Controller
{
    /**
     * Instantiate a new MenuController instance.
     *
     * @return void
     */
    public function __construct()
    {
        //restrict acesses to change database for non authenticated users
        $this->middleware('auth:api', ['only' => ['store', 'update', 'destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Restaurante::findOrFail(env('DB_RESTAURANTE'))->reserva->transformWith(new ReservaTransformer())->toArray();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreReservaRequest $request)
    {
        $checked = $this->checkCapacity($request->number);

        if($checked )
            return $checked;

        $reserva = Reserva::create(array_merge($request->all(), ['restaurante_id' => env('DB_RESTAURANTE')]));

        return fractal($reserva, new ReservaTransformer())->respond(201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Reserva  $reserva
     * @return \Illuminate\Http\Response
     */
    public function show(Reserva $reserva)
    {
        return Parent::apiHandler($reserva, new ReservaTransformer());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Reserva  $reserva
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateReservaRequest $request, Reserva $reserva)
    {
        if(isset($request->number)){
            $checked = $this->checkCapacity($request->number - $reserva->number);

            if($checked)
                return $checked;
        }

        $fractal = Parent::apiHandler($reserva, new ReservaTransformer(), 200);

        if($fractal->getData()->data !== 'Resource not found')
            $reserva->update($request->all());

        return $fractal;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Reserva  $reserva
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reserva $reserva)
    {
        $fractal = Parent::apiHandler($reserva, new ReservaTransformer(), 200);

        if($fractal->getData()->data !== 'Resource not found')
            $reserva->delete();

        return $fractal;
    }
    /**
     * Checks if the reservation can be done
     *
     * @param integer $newReserva
     * @return null if the reservation can be added
     */
    public function checkCapacity($newReserva = 0){
        $reservas = Restaurante::findOrFail(env('DB_RESTAURANTE'))->reserva
                                ->where('date', '>=' , Carbon::now()->subHours(2))
                                ->where('date', '<=' , Carbon::now()->addHours(2));
        
        $sum = $newReserva;

        foreach($reservas as $item)
            $sum += $item->number;

        if($sum > Restaurante::findOrFail(env('DB_RESTAURANTE'))->capacity)
            return response()->json([
                'data' => 'Reservation number exeeded the restaurante capacity'
            ], 404); 
    }
}
