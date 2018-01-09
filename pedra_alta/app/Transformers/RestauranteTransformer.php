<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Restaurante;

class RestauranteTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Restaurante $restaurante)
    {
        return [
            'id' => $restaurante->id,
            'name' => $restaurante->name,
            'capacity' => $restaurante->capacity,
            'type' => $restaurante->type,
            'open' => $restaurante->open,
            'close' => $restaurante->close,
            'location' => $restaurante->location,
        ];
    }
}
