<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStoreProfile extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules($model, $required, $modelName)
    {
        return [
            'store_id' => [$required->condition ? 'required' : ''],
            'profile_id' => [$required->condition ? 'required' : ''],
        ];
    }
}
