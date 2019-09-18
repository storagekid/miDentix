<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreClinic extends FormRequest
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
            'city' => [$required->condition ? 'required' : ''],
            'district' => ['nullable'],
            'nickname' => ['nullable'],
            'postal_code' => [$required->condition ? 'required' : ''],
            'email_ext' => ['nullable'],
            'sanitary_code' => ['nullable'],
            'county_id' => [$required->condition ? 'required' : ''],
            'language_id' => [$required->condition ? 'required' : ''],
            'clinic_manager_id' => ['nullable'],
            'area_manager_id' => ['nullable'],
            'cost_center_id' => ['nullable'],
            'starts_at' =>[$required->condition ? 'required' : '', 'date'],
            'ends_at' =>['nullable', 'date'],
        ];
    }
}
