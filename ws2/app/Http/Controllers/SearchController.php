<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Route;
use App\Service;
use Ixudra\Curl\Facades\Curl;
use Illuminate\Support\Facades\Cache;
use phpDocumentor\Reflection\Types\Integer;

class SearchController extends Controller
{
    public function search(Request $request){
        $routeData = Cache::remember($request->has('service') ? 'Service'.$request->input('service') : 'WSData', 1, function () use ($request) {
            return $this->routeData($request->input('service'));
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
                    if($field == '*' || strpos(strtolower(array_get($routeData, $key)), strtolower($field)) !==  false)
                        array_push($found, array_get($routeData, implode('.', array_slice($dotKeysArray, 0, array_search($RequestKey, $dotKeysArray)))));
                
        }

        return $found;
    }

    private function routeData($id){
        if($id != null)
            return $this->getRouteData(Service::findOrFail($id));

        $data = [];
        foreach(Service::all() as $service)
                array_push($data, $this->getRouteData($service));

        return $data;
    }
    private function getRouteData($service){
        $data = [];
        foreach($service->routes as $route)
            array_push($data, Curl::to($service->url . $route->route)
                ->withContentType('application/json')
                ->withHeader('Accept: application/json')
                ->asJson( true )
                ->get()['data']);
        return $data;
    }
}
