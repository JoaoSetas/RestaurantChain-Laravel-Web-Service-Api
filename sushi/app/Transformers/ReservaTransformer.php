<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Reserva;

class ReservaTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Reserva $reserva)
    {
        return [
            'id' => $reserva->id,
            'name' => $reserva->name,
            'number' => $reserva->number,
            'date' => $reserva->date
        ];
    }
}
