<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAddress extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules($model, $required)
    {
        return [
            'address_line_1' => [$required->condition ? 'required' : '', 'min:3', 'max:255'],
            'address_line_2' => ['nullable', 'min:3', 'max:255'],
            'type' => [$required->condition ? 'required' : ''],
            'description' => ['nullable','min:3','max:255'],
            'main' => ['nullable'],
        ];
    }
}
