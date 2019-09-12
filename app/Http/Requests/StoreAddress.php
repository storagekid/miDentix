<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAddress extends FormRequest
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
        // $class = '\App\\' . substr(static::class, strlen("App\Http\Requests\Store"));
        // dump(strpos(static::class, strlen("App\Http\Requests\Store")));
        // dd((new $class)::authorize());
        $required = Rule::requiredIf($this->isMethod('POST') || $this->isMethod('GET'));
        return [
            'address_line_1' => [$required->condition ? 'required' : '', 'min:3', 'max:255'],
            'address_line_2' => ['nullable', 'min:3', 'max:255'],
            'type' => [$required->condition ? 'required' : ''],
            'description' => ['nullable','min:3','max:255'],
            'main' => ['nullable'],
        ];
    }
}
