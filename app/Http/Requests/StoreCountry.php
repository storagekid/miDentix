<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCountry extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules($model, $required)
    {
        return [
            'name' =>[$required->condition ? 'required' : '', Rule::unique('countries')->ignore($model->id), 'max:255'],
            'code_a2' =>[$required->condition ? 'required' : '','max:2'],
            'code_a3' =>['nullable','max:3'],
            'code_un' =>['nullable','max:3'],
            'currency' =>['nullable'],
            'currency_id' =>[$required->condition ? 'required' : ''],
            'language_id' => [$required->condition ? 'required' : ''],
        ];
    }
}
