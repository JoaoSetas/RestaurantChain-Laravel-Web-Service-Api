<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Route;

class RouteTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Route $route)
    {
        return [
            'id' => $route->id,
            'route'=> $route->route
        ];
    }
}
