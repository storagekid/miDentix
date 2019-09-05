<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreClinicPosterPriority extends FormRequest
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
            'campaign_id' => ['nullable'],
            'clinic_poster_id' => [$required->condition ? 'required' : ''],
            'priority' => [$required->condition ? 'required' : ''],
            'starts_at' => [$required->condition ? 'required' : ''],
            'ends_at' => ['nullable']
        ];
    }
}
