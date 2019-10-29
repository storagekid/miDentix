<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreState extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules($model, $required)
    {
        return [
            'name' =>[$required->condition ? 'required' : '', Rule::unique('states')->ignore($model->id), 'max:255'],
            'country_id' => [$required->condition ? 'required' : ''],
        ];
    }
}
