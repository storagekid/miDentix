<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClinicMailing extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules($model, $required)
    {
        return [
            'mailing_design_id' => [$required->condition ? 'required' : ''],
            'clinic_id' => [$required->condition ? 'required' : ''],
            'clinic_af_file_id' => ['nullable'],
            'printer_id' => ['nullable'],
            'printer_product_id' => ['nullable'],
            'printed_qty' => ['nullable'],
            'distributor_id' => ['nullable'],
            'distributor_service_id' => ['nullable'],
            'distributed_stand_qty' => ['nullable'],
            'distributed_doordrop_qty' => ['nullable']
        ];
    }
}
