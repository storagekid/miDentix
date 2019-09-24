<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClinicSchedule extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules($model, $required)
    {
        return [
            'clinic_profile_id' => [$required->condition ? 'required' : ''],
            'job_id' => [$required->condition ? 'required' : ''],
            'job_type_id' => [$required->condition ? 'required' : ''],
            'schedule' => ['nullable'],
        ];
    }
}
