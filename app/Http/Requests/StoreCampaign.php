<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCampaign extends FormRequest
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
            'name' =>[$required->condition ? 'required' : '', Rule::unique('campaigns')->ignore($this->id), 'max:255'],
            'description' =>[$required->condition ? 'required' : '','max:255'],
            'parent_id' => ['nullable'],
            'starts_at' =>[$required->condition ? 'required' : '', 'date'],
            'ends_at' =>['nullable', 'date'],
            'poster_starts_at' =>['nullable', 'date'],
            'poster_ends_at' =>['nullable', 'date'],
        ];
    }
}
