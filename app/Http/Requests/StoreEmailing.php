<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreEmailing extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules($model, $required, $modelName)
    {
        return [
            'name' => [$required->condition ? 'required' : '', Rule::unique('emailings')->ignore($model->id), 'min:6', 'max:255'],
            'description' => ['nullable','min:3','max:255'],
            'company_id' => ['nullable'],
            'campaign_id' => ['nullable'],
            'design' => [$required->condition ? 'required' : ''],
            'user_id' => [$required->condition ? 'required' : ''],
            'emailing_file_id' => ['nullable'],
            'mirror_file_id' => ['nullable'],
        ];
    }
}
