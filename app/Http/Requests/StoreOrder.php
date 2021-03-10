<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreOrder extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules($model, $required, $modelName)
    {
        return [
            'shopping_bag_id' => [$required->condition ? 'required' : ''],
            'user_id' => [$required->condition ? 'required' : ''],
            'clinic_id' => ['nullable'],
            'store_id' => ['nullable'],
            'product_provider_id' => [$required->condition ? 'required' : ''],
            'profile_id' => ['nullable'],
            'details' => ['nullable','min:3','max:255'],
            'orderable_id' => [$required->condition ? 'required' : ''],
            'orderable_type' => [$required->condition ? 'required' : ''],
            'quantity' => [$required->condition ? 'required' : ''],
            'priority' => [$required->condition ? 'required' : ''],
            'state' => [$required->condition ? 'required' : ''],
        ];
    }
}
