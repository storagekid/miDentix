<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreUser extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules($model, $required, $modelName)
    {
        return [
            'name' =>[$required->condition ? 'required' : '', Rule::unique('users')->ignore($model->id),'email','max:255'],
            'password' => [$required->condition ? 'required' : '','min:8', 'max:16'],
            'password2' => [$required->condition ? 'required' : '','same:password'],
        ];
    }
}
