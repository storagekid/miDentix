<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCurrency extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules($model, $required, $modelName)
    {
        return [
            'name' =>[$required->condition ? 'required' : '', Rule::unique('currencies')->ignore($model->id), 'max:255'],
            'code_alpha' =>['nullable','max:3'],
            'code_num' =>['nullable','max:3'],
            'decimals' =>['nullable','max:1'],
            'notes' =>['nullable','max:255'],
        ];
    }
}
