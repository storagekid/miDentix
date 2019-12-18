<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreService extends FormRequest
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
                Rule::unique('services')->ignore($model->id),
                'min:3',
                'max:32'
            ],
            'description' => ['nullable','min:3','max:255'],
            'category' => [$required->condition ? 'required' : ''],
            'parent_id' => ['nullable'],
        ];
    }
}
