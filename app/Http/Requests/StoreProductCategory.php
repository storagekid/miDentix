<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductCategory extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules($model, $required, $modelName)
    {
        return [
            'name' =>[$required->condition ? 'required' : '', Rule::unique('product_categories')->ignore($model->id),'max:64'],
            'description' => ['nullable','min:3','max:255'],
        ];
    }
}
