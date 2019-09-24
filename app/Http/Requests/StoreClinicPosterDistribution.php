<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClinicPosterDistribution extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules($model, $required)
    {
        return [
            'clinic_id' => [$required->condition ? 'required' : ''],
            'address_id' => [$required->condition ? 'required' : ''],
            'starts_at' => [$required->condition ? 'required' : '', 'date'],
            'ends_at' => ['nullable', 'date'],
            'facade' => ['nullable'],
            'distributions' => [$required->condition ? 'required' : ''],
        ];
    }
}
