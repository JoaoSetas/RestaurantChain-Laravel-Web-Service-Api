<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * If the menu item is not from this restaurante return exeption else return the fractal response
     *
     * @param [type] $item item to check
     * @return void
     */
    protected static function apiHandler(&$item, $transformer, $exeption = null){
        if($item->restaurante_id != config('app.restaurante_id'))
            return response()->json([
                'data' => 'Resource not found'
            ], 404);

        if($exeption)
            return fractal($item, $transformer)->respond($exeption);

        return fractal()
                ->item($item)
                ->transformWith($transformer);
    }
}
