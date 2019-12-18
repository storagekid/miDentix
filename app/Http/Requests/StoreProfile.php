<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProfile extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules($model, $required, $modelName)
    {
        return [
            'name' => [$required->condition ? 'required' : '','min:3','max:64'],
            'lastname1' => [$required->condition ? 'required' : '','min:2','max:64'],
            'lastname2' => ['nullable', 'min:3','max:64'],
            'gender' => [$required->condition ? 'required' : '', Rule::in($modelName::make()->getFields('gender')['type']['array'])],
            'personal_id_number' => ['nullable', Rule::unique('profiles')->ignore($model->id),'min:3','max:16'],
            'country_id' => [$required->condition ? 'required' : ''],
            'user_id' => ['nullable'],
            'company_id' => [$required->condition ? 'required' : ''],
        ];
    }
}
