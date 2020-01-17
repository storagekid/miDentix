<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMailingDesign extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules($model, $required, $modelName)
    {
        return [
            'name' =>[$required->condition ? 'required' : '', Rule::unique('mailing_designs')->ignore($model->id), 'max:255'],
            'description' =>[$required->condition ? 'required' : '','max:255'],
            'mailing_id' => [$required->condition ? 'required' : ''],
            'language_id' => [$required->condition ? 'required' : ''],
            'country_id' => [$required->condition ? 'required' : ''],
            'state_id' => ['nullable'],
            'county_id' => ['nullable'],
            'clinic_id' => ['nullable'],
            'type' => [$required->condition ? 'required' : ''],
            'base_af_file_id' => ['nullable'],
        ];
    }
}
