<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePhone extends FormRequest
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
            'number' => [$required->condition ? 'required' : '', 'min:9', 'max:15'],
            'type' => [$required->condition ? 'required' : ''],
            'description' => ['nullable','min:3','max:255'],
            'main' => ['nullable'],
        ];
    }
}
