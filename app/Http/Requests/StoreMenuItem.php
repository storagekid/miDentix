<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMenuItem extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules($model, $required, $modelName)
    {
        return [
            'name' => [
                'required',
                Rule::unique('menu_items')->ignore($model->id),
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
