<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreClaim extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules($model, $required, $modelName)
    {
        return [
            'name' =>[$required->condition ? 'required' : '', Rule::unique('claims')->ignore($model->id), 'max:255'],
            'description' =>[$required->condition ? 'required' : '','max:255'],
            'starts_at' =>[$required->condition ? 'required' : '', 'date'],
            'ends_at' =>['nullable', 'date'],
            'language_id' => [$required->condition ? 'required' : ''],
            'country_id' => [$required->condition ? 'required' : '']
        ];
    }
}
