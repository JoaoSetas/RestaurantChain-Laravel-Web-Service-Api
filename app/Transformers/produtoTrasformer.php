<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Produto;

class produtoTrasformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Produto $produto)
    {
        return [
            'id' => $produto->id,
            'nome' => $produto->produto,
            'forma' => $produto->forma,
            'embalagem' => $produto->embalagem
        ];
    }
}
