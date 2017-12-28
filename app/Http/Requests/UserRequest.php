<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;//mudamos de false para true
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() //validação especifica do utilizador, com os dados que utilizador coloca 
    {
        return [
            //do
            'name'=>'required|max:30',
            'email'=>'required|email|max:255|unique:users',//unico para a tabela de utilizadores
            'password'=>'required|min:6'
        ];
    }
}
