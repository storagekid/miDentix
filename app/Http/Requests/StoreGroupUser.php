<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGroupUser extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules($model, $required)
    {
        return [
            'group_id' => [$required->condition ? 'required' : ''],
            'user_id' => [$required->condition ? 'required' : ''],
            'role' => [$required->condition ? 'required' : ''],
        ];
    }
}
