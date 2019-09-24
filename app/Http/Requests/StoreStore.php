<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStore extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules($model, $required)
    {
        return [
            'name' => [$required->condition ? 'required' : '', 'min:9', 'max:255'],
            'description' => ['nullable', 'min:3','max:255'],
        ];
    }
}
