<?php

namespace App\Transformers;

use App\User;

/**
 * Transforma os dados da base de dados para uma Predefinição json para todas as aplicações que usam esta API
 */
class UserTransformer extends \League\Fractal\TransformerAbstract{

    public function transform(User $user){

        return [
            'username' => $user->username,
            'avatar' => $user->avatar(),
        ];
    }
}