<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClinicSibling extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules($model, $required, $modelName)
    {
        return [
            'clinic_id' => [$required->condition ? 'required' : ''],
            'sibling_id' => [$required->condition ? 'required' : ''],
            'starts_at' =>[$required->condition ? 'required' : '', 'date'],
            'ends_at' =>['nullable', 'date'],
            'type' => [$required->condition ? 'required' : '']
        ];
    }
}
