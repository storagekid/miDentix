<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProfile extends FormRequest
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
    public function rules($model)
    {
        $required = Rule::requiredIf($this->isMethod('POST') || $this->isMethod('GET'));
        return [
            'name' => [$required->condition ? 'required' : '','min:3','max:64'],
            'lastname1' => [$required->condition ? 'required' : '','min:2','max:64'],
            'lastname2' => ['nullable', 'min:3','max:64'],
            'gender' => [$required->condition ? 'required' : ''],
            'personal_id_number' => ['nullable', Rule::unique('profiles')->ignore($model->id),'min:3','max:16'],
            'country_id' => [$required->condition ? 'required' : ''],
            'user_id' => ['nullable'],
            'company_id' => [$required->condition ? 'required' : ''],
        ];
    }
}
