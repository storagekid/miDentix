<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreEmail extends FormRequest
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
            'email' => [$required->condition ? 'required' : '', 'email', Rule::unique('emails')->ignore($this->id), 'min:6', 'max:255'],
            'type' => [$required->condition ? 'required' : ''],
            'description' => ['nullable','min:3','max:255'],
            'main' => ['nullable'],
        ];
    }
}
