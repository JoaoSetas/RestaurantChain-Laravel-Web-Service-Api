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
    /**
     * Handles and caches the searchs requests
     *
     * @param Request $request
     * @param Service $service
     * @return ObjectArray found data
     */
    public function search(Request $request, Service $service){
        $routeData = Cache::remember($service->exists ? $service->id : 'WSData', 1, function () use ($service) {
            return $this->routeData($service);
        });

        $data = $this->findPropertyRoutes($request, $routeData);

        return $data ? $data : response()->json([
                                    'data' => 'Resource not found'
                                ], 404);;
    }
    /**
     * Converts de data into dot annotation and find the field and value from the request
     *
     * @param [type] $request
     * @param [type] $routeData
     * @return objectArray fields found
     */
    private function findPropertyRoutes($request, $routeData){
        $found = [];
        foreach(array_dot($routeData) as $key=>$item){
            $dotKeysArray = explode('.', $key);
 
            foreach($request->all() as $RequestKey=>$field)
                if(in_array($RequestKey, $dotKeysArray))
                    if($field == '*' || strpos(strtolower(array_get($routeData, $key)), strtolower($field)) !==  false)
                        array_push($found, array_get($routeData, implode('.', array_slice($dotKeysArray, 0, array_search($RequestKey, $dotKeysArray)))));
        }

        return empty($found) ? $routeData : $found;
    }
    /**
     * Return all data from a service or all services
     *
     * @param Service $service Service to get data from or null to get data from all services
     * @return JsonObject service data
     */
    private function routeData(Service $service){
        if($service->exists)
            return $this->curlRouteData($service);

        $data = [];
        foreach(Service::all() as $item)
                array_push($data, $this->curlRouteData($item));

        return $data;
    }
    /**
     * Performe the curl request to get all data from a service routes
     *
     * @param [type] $service the service to request
     * @return JsonObject return the json response as object
     */
    private function curlRouteData($service){
        $data = [];

        foreach($service->routes as $route){
            $routeData = Curl::to($service->url . $route->route)
                ->withContentType('application/json')
                ->withHeader('Accept: application/json')
                ->asJson(true)
                ->get()['data'];

            array_push($data, data_fill($routeData, array_has(array_dot($routeData), '0.item') ? '*.service' : 'service', [
                            'service_id' => $service->id,
                            'service_name' => $service->name,
                            'service_route' => $route->route
                            ]
            ));
        }

        
        return $data;
    }
}
