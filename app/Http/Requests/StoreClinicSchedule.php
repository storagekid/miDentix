<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreClinicSchedule extends FormRequest
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
            'clinic_profile_id' => [$required->condition ? 'required' : ''],
            'job_id' => [$required->condition ? 'required' : ''],
            'job_type_id' => [$required->condition ? 'required' : ''],
            'schedule' => ['nullable'],
        ];
    }
}
