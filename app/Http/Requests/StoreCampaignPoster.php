<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCampaignPoster extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules($model, $required, $modelName)
    {
        return [
            'campaign_id' => [$required->condition ? 'required' : ''],
            'poster_id' => [$required->condition ? 'required' : ''],
            'poster_model_id' => [$required->condition ? 'required' : ''],
            'language_id' => [$required->condition ? 'required' : ''],
            'country_id' => [$required->condition ? 'required' : ''],
            'state_id' => ['nullable'],
            'county_id' => ['nullable'],
            'clinic_id' => ['nullable'],
            'type' => [$required->condition ? 'required' : ''],
            'poster_af' => ['nullable'],
        ];
    }
}
