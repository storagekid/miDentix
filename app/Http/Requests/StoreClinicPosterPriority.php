<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClinicPosterPriority extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules($model, $required, $modelName)
    {
        return [
            'campaign_id' => ['nullable'],
            'clinic_poster_id' => [$required->condition ? 'required' : ''],
            'priority' => [$required->condition ? 'required' : ''],
            'starts_at' => [$required->condition ? 'required' : ''],
            'ends_at' => ['nullable']
        ];
    }
}
