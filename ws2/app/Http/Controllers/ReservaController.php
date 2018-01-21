<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;
use App\Service;

class ReservaController extends Controller
{
    public function __construct()
    {
        //autenticação para todos
        $this->middleware('auth:api');
    }

    //vê todas as reservas
    public function index(Request $request, Service $service){
        $reserva = Curl::to($service->url . 'reserva')//obtem o restaurante/serviço->objeto
                    ->withContentType('application/json')
                    ->withHeader('Accept: application/json')
                    //autorização que vem do $request feito no ws2
                    ->withHeader('Authorization: ' . $request->header('Authorization'))
                    ->asJson(true)
                    ->get();  
        return $reserva;
    }
    //vê uma reserva
    public function show(Request $request, Service $service, $reserva_id){
        $reserva = Curl::to($service->url . 'reserva/' . $reserva_id)
                    ->withContentType('application/json')
                    ->withHeader('Accept: application/json')
                    ->withHeader('Authorization: ' . $request->header('Authorization'))                    
                    ->asJson(true)
                    ->get();  
        return $reserva;//retorna a reserva porque o fractal transformer já vem do ws1
    }
    //cria uma reserva
    public function new(Request $request, Service $service){
         $reserva = Curl::to($service->url . 'reserva')
                    ->withContentType('application/json')
                    ->withHeader('Accept: application/json')
                    ->withHeader('Authorization: ' . $request->header('Authorization'))                    
                    ->withData($request->all())
                    ->asJson( true )
                    ->post();

         return response()->json($reserva, 201); //retorna a reserva em json
    }
    //destrói uma reserva
    public function destroy(Request $request, Service $service, $reserva_id){
        $reserva = Curl::to($service->url . 'reserva/' . $reserva_id)
                    ->withContentType('application/json')
                    ->withHeader('Accept: application/json')
                    //autorização
                    ->withHeader('Authorization: ' . $request->header('Authorization'))                    
                    ->asJson(true)
                    ->delete();
        return response()->json($reserva, 200); 
    }

  
}
