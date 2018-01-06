<?php

namespace App\Http\Controllers;

use App\Menu;
use Illuminate\Http\Request;
use App\Transformers\MenuTransformer;
use App\Http\Requests\StoreMenuRequest;
use App\Http\Requests\UpdateMenuRequest;
use App\Restaurante;

class MenuController extends Controller
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
        return Restaurante::findOrFail(env('DB_RESTAURANTE'))->menu->transformWith(new MenuTransformer())->toArray();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMenuRequest $request)
    {
        $request['price'] = str_replace(',', '.', $request['price']);
        $menu = Menu::create(array_merge($request->all(), ['restaurante_id' => env('DB_RESTAURANTE')]));

        return fractal($menu, new MenuTransformer())->respond(201);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function show(Menu $menu)
    {
        return Parent::apiHandler($menu, new MenuTransformer());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response  returns the item before the edit
     */
    public function update(UpdateMenuRequest $request, Menu $menu)
    {
        $fractal = Parent::apiHandler($menu, new MenuTransformer(), 200);

        if($fractal->getData()->data !== 'Resource not found')
            $menu->update($request->all());

        return $fractal;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $menu)
    {
        $fractal = Parent::apiHandler($menu, new MenuTransformer(), 200);

        if($fractal->getData()->data !== 'Resource not found')
            $menu->delete();

        return $fractal;
    }
}
