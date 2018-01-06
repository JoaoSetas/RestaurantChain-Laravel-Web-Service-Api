<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRestauranteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'string|max:100',
            'capacity' => 'integer|max:10',
            'type' => 'string|max:100',
            'open' => 'date_format:H:i:s',
            'close' => 'date_format:H:i:s|after:open',
            'location' => 'string'
        ];
    }
}
