<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreGroup extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules($model, $required, $modelName)
    {
        return [
            'name' =>[$required->condition ? 'required' : '', Rule::unique('groups')->ignore($model->id),'max:255'],
        ];
    }
}
