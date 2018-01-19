<?php

namespace App\Http\Controllers;

use App\Route;
use App\Service;
use Illuminate\Http\Request;
use App\Http\Requests\StoreRouteRequest;
use App\Http\Requests\UpdateRouteRequest;
use App\Transformers\RouteTransformer;

class RouteController extends Controller
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
    public function index(Service $service)
    {
        return $service->routes->transformWith(new RouteTransformer())->toArray();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\StoreRouteRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRouteRequest $request, Service $service)
    {
        $route = Route::create(array_merge($request->all(), ['service_id' => $service->id]));

        return fractal($route, new RouteTransformer())->respond(201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Route  $route
     * @return \Illuminate\Http\Response
     */
    public function show(Service $service, Route $route)
    {
        return fractal()
            ->item($route)
            ->transformWith(new RouteTransformer())
            ->toArray();
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Route  $route
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRouteRequest $request,Service $service, Route $route)
    {
        $route->update($request->all());

        return fractal($route, new RouteTransformer())->respond(200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Route  $route
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service, Route $route)
    {
        $route->delete();

        return fractal($route, new RouteTransformer())->respond(200);
    }
}
