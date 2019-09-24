<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCampaignPosterPriority extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules($model, $required)
    {
        return [
            'campaign_id' => [$required->condition ? 'required' : ''],
            'poster_model_id' => [$required->condition ? 'required' : ''],
            'priority' => [$required->condition ? 'required' : ''],
        ];
    }
}
