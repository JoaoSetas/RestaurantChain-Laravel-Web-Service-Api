<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Route;
use App\Service;
use Ixudra\Curl\Facades\Curl;
use Illuminate\Support\Facades\Cache;

class SearchController extends Controller
{
    public function search(Request $request){
        $routeData = Cache::remember('WSData', 1, function () {
                            return $this->allRoutesData();
                        });

        $data = $this->findPropertyRoutes($request, $routeData);
        return $data ? $data : response()->json([
                                    'data' => 'Resource not found'
                                ], 404);;
    }

    private function findPropertyRoutes($request, $routeData){
        $found = [];
        foreach(array_dot($routeData) as $key=>$item){
            $dotKeysArray = explode('.', $key);
 
            foreach($request->all() as $RequestKey=>$field)
                if(in_array($RequestKey, $dotKeysArray))
                    if(array_get($routeData, $key) == $field)
                        array_push($found, array_get($routeData, implode('.', array_slice($dotKeysArray, 0, array_search($RequestKey, $dotKeysArray)))));
                
        }

        return $found;
    }

    public function allRoutesData(){
        $array = [];
        foreach(Service::all() as $service)
            foreach($service->routes as $route)
                array_push($array, Curl::to($service->url . $route->route)
                    ->withContentType('application/json')
                    ->withHeader('Accept: application/json')
                    ->asJson( true )
                    ->get()['data']);
        return $array;
    }
}
