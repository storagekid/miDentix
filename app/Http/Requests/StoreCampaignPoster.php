<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCampaignPoster extends FormRequest
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
