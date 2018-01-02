<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Menu;

class MenuTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Menu $menu)
    {
        return [
            'id' => $menu->id,
            'item' => $menu->item,
            'description' => $menu->description,
            'type' => $menu->type,
            'price' => $menu->price,            
        ];
    }
}
