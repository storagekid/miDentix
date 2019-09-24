<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreEmail extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules($model, $required)
    {
        return [
            'email' => [$required->condition ? 'required' : '', 'email', Rule::unique('emails')->ignore($model->id), 'min:6', 'max:255'],
            'type' => [$required->condition ? 'required' : ''],
            'description' => ['nullable','min:3','max:255'],
            'main' => ['nullable'],
        ];
    }
}
