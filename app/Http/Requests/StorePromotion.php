<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePromotion extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules($model, $required, $modelName)
    {
        return [
            'name' =>[$required->condition ? 'required' : '', Rule::unique('promotions')->ignore($model->id), 'max:255'],
            'description' =>[$required->condition ? 'required' : '','max:255'],
            'starts_at' =>[$required->condition ? 'required' : '', 'date'],
            'ends_at' =>['nullable', 'date'],
            'language_id' => [$required->condition ? 'required' : ''],
            'country_id' => [$required->condition ? 'required' : ''],
            'v_design_file_id' => ['nullable'],
            'h_design_file_id' => ['nullable'],
            'v_design_index_coords' => ['nullable'],
            'h_design_index_coords' => ['nullable'],
        ];
    }
}
