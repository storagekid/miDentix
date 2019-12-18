<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePosterModel extends FormRequest
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
                $required->condition ? $required->condition ? 'required' : '' : '',
                Rule::unique('poster_models')->ignore($model->id),
                'min:3',
                'max:255'
            ],
            'description' => ['required','min:3','max:255'],
        ];
    }
}
