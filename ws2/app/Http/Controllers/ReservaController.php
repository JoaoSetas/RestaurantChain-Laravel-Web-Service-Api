<?php

namespace App\Http\Controllers;

//deves ter alguns erros depois, vai ser por nao importares cenas tipo
use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;
use App\Service;

class ReservaController extends Controller
{
    public function __construct()
    {
        //restrict acesses to change database for non authenticated users
        $this->middleware('auth:api');
    }

    //em cima adicionei o middleware porque agora a autentificação nao é fixa, tiramos a autentificação do pedido que é enviado para o ws2
    //O tipo de request pode ser generico porque o ws1 ja trata de todas a verificações,
    //o mesmo se aplica para o fractal transformer, ja vem feito do ws1


    //vê todas as reservas
    public function index(Request $request, Service $service){
        $reserva = Curl::to($service->url . 'reserva')//obtem o restaurante/serviço->objeto
                    ->withContentType('application/json')
                    ->withHeader('Accept: application/json')
                    //autorização que vem do $request fefito no ws2
                    ->withHeader('Authorization: ' . $request->header('Authorization'))
                    ->asJson(true)
                    ->get();  
        return $reserva;
    }
    //vê uma reserva
    public function show(Request $request, Service $service, $reserva_id){
        $reserva = Curl::to($service->url . 'reserva/' . $reserva_id)//obter o conteúdo
                    ->withContentType('application/json')
                    ->withHeader('Accept: application/json')
                    ->withHeader('Authorization: ' . $request->header('Authorization'))                    
                    ->asJson(true)
                    ->get();  
        return $reserva;
    }

    public function new(Request $request, Service $service){
         $reserva = Curl::to($service->url . 'reserva')
                    ->withContentType('application/json')
                    ->withHeader('Accept: application/json')
                    ->withHeader('Authorization: ' . $request->header('Authorization'))                    
                    ->withData($request->all())
                    ->asJson( true )
                    ->post();
         return response()->json($reserva, 201); 
    }

    public function destroy(Request $request, Service $service, $reserva_id){
        $reserva = Curl::to($service->url . 'reserva/' . $reserva_id)//obtem o restaurante/serviço->objeto
                    ->withContentType('application/json')
                    ->withHeader('Accept: application/json')
                    //autorização
                    ->withHeader('Authorization: ' . $request->header('Authorization'))                    
                    ->asJson(true)
                    ->delete();
        return response()->json($reserva, 200); 
    }

  
}
