<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSanitaryCode extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $required = Rule::requiredIf($this->isMethod('POST') || $this->isMethod('GET'));
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
