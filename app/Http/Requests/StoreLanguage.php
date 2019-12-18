<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreLanguage extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules($model, $required, $modelName)
    {
        return [
            'iso_name' =>[$required->condition ? 'required' : '', Rule::unique('languages')->ignore($model->id), 'max:32'],
            'native_name' =>[$required->condition ? 'required' : '','max:32'],
            '639-1' =>['nullable','max:2'],
            '639-2/T' =>['nullable','max:3'],
            '639-2/B' =>['nullable','max:3'],
            '639-3' =>['nullable','max:6'],
            'notes' =>['nullable','max:255'],
        ];
    }
}
