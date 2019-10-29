<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreLegal extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules($model, $required)
    {
        return [
            'name' =>[$required->condition ? 'required' : '', Rule::unique('legals')->ignore($model->id), 'max:255'],
            'description' =>['nullable'],
            'text' =>[$required->condition ? 'required' : '','max:2048'],
            'language_id' => [$required->condition ? 'required' : ''],
            'country_id' => [$required->condition ? 'required' : ''],
            'state_id' => ['nullable'],
            'county_id' => ['nullable'],
            'clinic_id' => ['nullable'],
            'starts_at' =>[$required->condition ? 'required' : '', 'date'],
            'ends_at' =>['nullable', 'date']
        ];
    }
}
