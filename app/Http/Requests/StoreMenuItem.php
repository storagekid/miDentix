<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMenuItem extends FormRequest
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
            'name' => [
                'required',
                Rule::unique('menu_items')->ignore($this->id),
                'min:3',
                'max:32'
            ],
            'to' => ['nullable','min:3','max:64'],
            'icon' => [$required->condition ? 'required' : ''],
            'order' => ['nullable', 'integer', 'min:1', 'max:255'],
            'menu_id' => [$required->condition ? 'required' : ''],
            'parent_id' => ['nullable'],
        ];
    }
}
