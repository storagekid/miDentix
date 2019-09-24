<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMenuItemGroup extends FormRequest
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
            'menu_item_id' => [$required->condition ? 'required' : ''],
        ];
    }
}
