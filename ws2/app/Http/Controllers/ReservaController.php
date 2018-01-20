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
        //$this->middleware('auth:api', ['only' => ['show', 'new', 'destroy']]);
    }

    //vê todas as reservas
    public function index(Service $service){
        $reserva = Curl::to($service->url . 'reserva')//obtem o restaurante/serviço->objeto
                    ->withContentType('application/json')
                    ->withHeader('Accept: application/json')
                    //autorização
                    ->withHeader('Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjhhMTVjMzUzNjU1MTA0NGFhZjMyNmFmMjY0NmQxNWRiODU2MTU2OGRiM2MxNzYzNjU4YTY4ZWM5ZDA0NTYwNjNkOWZkNzNjZTllN2MxZmVjIn0.eyJhdWQiOiIyIiwianRpIjoiOGExNWMzNTM2NTUxMDQ0YWFmMzI2YWYyNjQ2ZDE1ZGI4NTYxNTY4ZGIzYzE3NjM2NThhNjhlYzlkMDQ1NjA2M2Q5ZmQ3M2NlOWU3YzFmZWMiLCJpYXQiOjE1MTQ1NzE1MDIsIm5iZiI6MTUxNDU3MTUwMiwiZXhwIjoxNTQ2MTA3NTAyLCJzdWIiOiIxIiwic2NvcGVzIjpbIioiXX0.QDM5vBR87zmhfpSuRw1XOvJxswi6wDA79W7-2zji-dQa-EuEr9wj7OB4mGv-U6o6xz-Z02tPc5l4ErmwLjMLlMgRRK2rzvYw9JmZAcGxAeC4mlhL5f-mg4OQEewD9efjKxfWljj0k8_AvWpX_0hOLq-RtZYzIB5OxKTA5uET24u1P2Q_SenPvgY50Iq6Oz355LOGpFhknx_UhoX4IwhrNlnnfuOZBsC6yVOACOPOXVdlFPT6Je_GVBT-Y2xFcr8vNb12gIBHDBTy4HBPZ9VnR0l2FTuRwd8r1a8uF0hCB44l92hQ0EtZ_ctLtD-GocRJNAcATXIb2gHpHE12fuhPiUB5oPB_94toRG-Z_nvqpXGwh3t9-TjvOMwU1HXvBcCDPhzdNOANIkft5r90lcVe9nNQXYytCq4xFy-QuCL513O42b7U5zPsj4sw3OeSqeEKJsao1c5movxZc0DP3NUfu6Tn0IXzEsZOvPjAdpYALntS1Xy2s_eK8no8Ti3UGezFgCoWVprcg8PYJtRd21wsAmRZgMrJrlNUL9fghCfaDHYv6WcAzFGdKG38sstfNMwGpQr0weo-Px3N_ma0YQ92h5H5bGec56NVXdhSNBYHNVe7USzr9MJQGoKirBFtaiOHNnZZQeuZUP7VCiicUiudtpi16kvtUvaSTHshESQrYNs')
                    ->asJson(true)
                    ->get();  
        return fractal ($reserva,new ReservaTransformer())->respond(201); //retorna a reserva da maneira que queremos
    }
    //vê uma reserva
    public function show(Service $service, $reserva_id){
        $reserva = Curl::to($service->url . 'reserva/' . $reserva_id)//obter o conteúdo
                    ->withContentType('application/json')
                    ->withHeader('Accept: application/json')
                    ->withHeader('Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjhhMTVjMzUzNjU1MTA0NGFhZjMyNmFmMjY0NmQxNWRiODU2MTU2OGRiM2MxNzYzNjU4YTY4ZWM5ZDA0NTYwNjNkOWZkNzNjZTllN2MxZmVjIn0.eyJhdWQiOiIyIiwianRpIjoiOGExNWMzNTM2NTUxMDQ0YWFmMzI2YWYyNjQ2ZDE1ZGI4NTYxNTY4ZGIzYzE3NjM2NThhNjhlYzlkMDQ1NjA2M2Q5ZmQ3M2NlOWU3YzFmZWMiLCJpYXQiOjE1MTQ1NzE1MDIsIm5iZiI6MTUxNDU3MTUwMiwiZXhwIjoxNTQ2MTA3NTAyLCJzdWIiOiIxIiwic2NvcGVzIjpbIioiXX0.QDM5vBR87zmhfpSuRw1XOvJxswi6wDA79W7-2zji-dQa-EuEr9wj7OB4mGv-U6o6xz-Z02tPc5l4ErmwLjMLlMgRRK2rzvYw9JmZAcGxAeC4mlhL5f-mg4OQEewD9efjKxfWljj0k8_AvWpX_0hOLq-RtZYzIB5OxKTA5uET24u1P2Q_SenPvgY50Iq6Oz355LOGpFhknx_UhoX4IwhrNlnnfuOZBsC6yVOACOPOXVdlFPT6Je_GVBT-Y2xFcr8vNb12gIBHDBTy4HBPZ9VnR0l2FTuRwd8r1a8uF0hCB44l92hQ0EtZ_ctLtD-GocRJNAcATXIb2gHpHE12fuhPiUB5oPB_94toRG-Z_nvqpXGwh3t9-TjvOMwU1HXvBcCDPhzdNOANIkft5r90lcVe9nNQXYytCq4xFy-QuCL513O42b7U5zPsj4sw3OeSqeEKJsao1c5movxZc0DP3NUfu6Tn0IXzEsZOvPjAdpYALntS1Xy2s_eK8no8Ti3UGezFgCoWVprcg8PYJtRd21wsAmRZgMrJrlNUL9fghCfaDHYv6WcAzFGdKG38sstfNMwGpQr0weo-Px3N_ma0YQ92h5H5bGec56NVXdhSNBYHNVe7USzr9MJQGoKirBFtaiOHNnZZQeuZUP7VCiicUiudtpi16kvtUvaSTHshESQrYNs')
                    ->asJson(true)
                    ->get();  
        return fractal ($reserva,new ReservaTransformer())->respond(202);
    }
    //o unico que não precisa de autorização, pk?
    public function new(Request $request,Service $service){
         $resposta = Curl::to($service->url . '/reserva')
                    ->withContentType('application/json')
                    ->withHeader('Accept: application/json')
                    ->withData($request->all())
                    ->asJson( true )
                    ->post()['data'];
         return fractal ($resposta,new ReservaTransformer())->respond(203); 
    }

    public function destroy(Service $service,Reserva $reserva){
        $reserva = Curl::to($service->url . 'reserva'.$reserva_id)//obtem o restaurante/serviço->objeto
                    ->withContentType('application/json')
                    ->withHeader('Accept: application/json')
                    //autorização
                    ->withHeader('Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjhhMTVjMzUzNjU1MTA0NGFhZjMyNmFmMjY0NmQxNWRiODU2MTU2OGRiM2MxNzYzNjU4YTY4ZWM5ZDA0NTYwNjNkOWZkNzNjZTllN2MxZmVjIn0.eyJhdWQiOiIyIiwianRpIjoiOGExNWMzNTM2NTUxMDQ0YWFmMzI2YWYyNjQ2ZDE1ZGI4NTYxNTY4ZGIzYzE3NjM2NThhNjhlYzlkMDQ1NjA2M2Q5ZmQ3M2NlOWU3YzFmZWMiLCJpYXQiOjE1MTQ1NzE1MDIsIm5iZiI6MTUxNDU3MTUwMiwiZXhwIjoxNTQ2MTA3NTAyLCJzdWIiOiIxIiwic2NvcGVzIjpbIioiXX0.QDM5vBR87zmhfpSuRw1XOvJxswi6wDA79W7-2zji-dQa-EuEr9wj7OB4mGv-U6o6xz-Z02tPc5l4ErmwLjMLlMgRRK2rzvYw9JmZAcGxAeC4mlhL5f-mg4OQEewD9efjKxfWljj0k8_AvWpX_0hOLq-RtZYzIB5OxKTA5uET24u1P2Q_SenPvgY50Iq6Oz355LOGpFhknx_UhoX4IwhrNlnnfuOZBsC6yVOACOPOXVdlFPT6Je_GVBT-Y2xFcr8vNb12gIBHDBTy4HBPZ9VnR0l2FTuRwd8r1a8uF0hCB44l92hQ0EtZ_ctLtD-GocRJNAcATXIb2gHpHE12fuhPiUB5oPB_94toRG-Z_nvqpXGwh3t9-TjvOMwU1HXvBcCDPhzdNOANIkft5r90lcVe9nNQXYytCq4xFy-QuCL513O42b7U5zPsj4sw3OeSqeEKJsao1c5movxZc0DP3NUfu6Tn0IXzEsZOvPjAdpYALntS1Xy2s_eK8no8Ti3UGezFgCoWVprcg8PYJtRd21wsAmRZgMrJrlNUL9fghCfaDHYv6WcAzFGdKG38sstfNMwGpQr0weo-Px3N_ma0YQ92h5H5bGec56NVXdhSNBYHNVe7USzr9MJQGoKirBFtaiOHNnZZQeuZUP7VCiicUiudtpi16kvtUvaSTHshESQrYNs')
                     ->asJson(true)
                     -> delete();
        return fractal ($reserva,new ReservaTransformer())->respond(204);
    }

  
}
