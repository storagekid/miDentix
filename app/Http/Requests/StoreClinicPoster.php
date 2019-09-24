<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClinicPoster extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules($model, $required)
    {
        return [
            'poster_id' => [$required->condition ? 'required' : ''],
            'clinic_id' => ['nullable'],
            'type' => [$required->condition ? 'required' : ''],
            'starts_at' =>[$required->condition ? 'required' : '', 'date'],
            'ends_at' =>['nullable', 'date'],
        ];
    }
}
