<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSanitaryCode extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules($model, $required, $modelName)
    {
        return [
            'code' => [$required->condition ? 'required' : '','min:3','max:255'],
            'description' => ['nullable', 'min:3','max:255'],
            'clinic_id' => ['nullable'],
            'county_id' => ['nullable'],
            'state_id' => ['nullable'],
            'country_id' => ['nullable'],
            'campaign_id' => ['nullable'],
        ];
    }
}
