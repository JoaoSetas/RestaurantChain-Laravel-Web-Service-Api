<?php

namespace App\Http\Controllers;

//deves ter alguns erros depois, vai ser por nao importares cenas tipo
use Illuminate\Http\Request;
use App\Http\Requests\StoreReservaRequest; //deve ser assim
use Ixudra\Curl\Facades\Curl;
use App\Service;

class ReservaController extends Controller
{
    public function __construct()
    {
        //restrict acesses to change database for non authenticated users
        $this->middleware('auth:api', ['only' => ['show', 'new', 'destroy']]);
    }
 
     public function show(Request $request, Service $service){
        Curl::to($service->url . $route->route)//obter o conteúdo
                    ->withContentType('application/json')
                    ->withHeader('Accept: application/json')
                    ->asJson(true)
                    ->get()['data'];
     }

     
     public function new(StoreReservaRequest $request, Service $service){
        $resposta = Curl::to($service->url . '/reserva')
            ->withContentType('application/json')
            ->withHeader('Accept: application/json')
            ->withData($request->all())
            ->asJson( true )
            ->post()['data'];

        return $resposta; 
    }


    //tanto faz espera ai
    public function destroy(Request $request, Service $service){

    }
}
