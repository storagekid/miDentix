<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCompany extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules($model, $required, $modelName)
    {
        return [
            'name' =>[$required->condition ? 'required' : '', Rule::unique('countries')->ignore($model->id), 'max:255'],
            'description' =>['nullable'],
            'type' =>[$required->condition ? 'required' : ''],
            'CIF' => [$required->condition ? 'required' : ''],
        ];
    }
}
