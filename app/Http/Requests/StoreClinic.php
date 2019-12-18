<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClinic extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules($model, $required, $modelName)
    {
        return [
            'city' => [$required->condition ? 'required' : ''],
            'district' => ['nullable'],
            'nickname' => ['nullable'],
            'postal_code' => [$required->condition ? 'required' : ''],
            'email_ext' => ['nullable'],
            'sanitary_code' => ['nullable'],
            'county_id' => [$required->condition ? 'required' : ''],
            'language_id' => [$required->condition ? 'required' : ''],
            'parent_id' => ['nullable'],
            'clinic_cloud_id' => ['nullable'],
            'oracle_id' => ['nullable'],
            'clinic_manager_id' => ['nullable'],
            'area_manager_id' => ['nullable'],
            'cost_center_id' => ['nullable'],
            'starts_at' =>[$required->condition ? 'required' : '', 'date'],
            'ends_at' =>['nullable', 'date'],
        ];
    }
}
