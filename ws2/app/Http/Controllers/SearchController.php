<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Route;
use App\Service;
use Ixudra\Curl\Facades\Curl;

class SearchController extends Controller
{
    public function search(Request $request){
        Route::all();
        $response = [];
        foreach(Service::all() as $service)
            foreach($service->routes as $route)
                array_push($response, Curl::to($service->url . $route->route)
                    ->withContentType('application/json')
                    ->withHeader('Accept: application/json')
                    ->asJson( true )
                    ->get()['data']);

        return array_get($response, '0.0');
    }

    private function findPropertyRoutes($request, $array){
        array_dot($array);
        /*
        foreach($array as $property->$item)
            foreach($request as $key->$string)
        */

    }

    public function allRoutes(){
        $response = [];
        foreach(Service::all() as $service)
            foreach($service->routes as $route)
                array_push($response, Curl::to($service->url . $route->route)
                    ->withContentType('application/json')
                    ->withHeader('Accept: application/json')
                    ->asJson( true )
                    ->get()['data']);
                
        return $response;
    }
}
