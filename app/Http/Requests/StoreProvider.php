<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProvider extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules($model, $required)
    {
        return [
            'name' =>[$required->condition ? 'required' : '', Rule::unique('promotions')->ignore($model->id), 'max:255'],
            'description' =>[$required->condition ? 'required' : '','max:255'],
            'legal_name' =>['nullable'],
            'CNAE' =>['nullable'],
            'user_id' =>['nullable'],
            'CIF' => [$required->condition ? 'required' : ''],
        ];
    }
}
