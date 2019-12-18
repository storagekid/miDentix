<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductProvider extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules($model, $required, $modelName)
    {
        return [
            'product_id' => [$required->condition ? 'required' : ''],
            'provider_id' => [$required->condition ? 'required' : ''],
            'country_id' => [$required->condition ? 'required' : ''],
            'description' => [$required->condition ? 'required' : ''],
            'price' => [$required->condition ? 'required' : '', 'numeric'],
            'starts_at' =>[$required->condition ? 'required' : '', 'date'],
            'ends_at' =>['nullable', 'date'],
            'details' => ['nullable'],
            'state_id' => ['nullable'],
            'county_id' => ['nullable'],
            'clinic_id' => ['nullable'],
            'store_id' => ['nullable']
        ];
    }
}
