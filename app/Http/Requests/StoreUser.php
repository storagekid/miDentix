<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUser extends FormRequest
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
            'name' =>[$required->condition ? 'required' : '','unique:users','email','max:255'],
            'password' => [$required->condition ? 'required' : '','min:8', 'max:16'],
            'password2' => [$required->condition ? 'required' : '','same:password'],
        ];
    }
}
