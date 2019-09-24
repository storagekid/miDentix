<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMenu extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules($model, $required)
    {
        return [
            'name' => [
                'required',
                Rule::unique('menus')->ignore($model->id),
                'min:3',
                'max:32'
                ]
        ];
    }
}
