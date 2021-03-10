<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClinicStationary extends FormRequest
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
            'product_id' => [$required->condition ? 'required' : ''],
            'af_file_id' => ['nullable'],
        ];
    }
}
