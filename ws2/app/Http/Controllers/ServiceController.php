<?php

namespace App\Http\Controllers;

use App\Service;
use Illuminate\Http\Request;
use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Transformers\ServiceTransformer;

class ServiceController extends Controller
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
        return Service::all()->transformWith(new ServiceTransformer())->toArray();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreServiceRequest $request)
    {
        $service = Service::create($request->all());

        return fractal($service, new ServiceTransformer())->respond(201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function show(Service $service)
    {
        return fractal()
            ->item($service)
            ->transformWith(new ServiceTransformer())
            ->toArray();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateServiceRequest $request, Service $service)
    {
        $service->update($request->all());

        return fractal($service, new ServiceTransformer())->respond(200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service)
    {
        $service->delete();

        return fractal($service, new ServiceTransformer())->respond(200);
    }
}
