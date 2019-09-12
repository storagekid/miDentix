<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QStore extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        dd(request()->all());
        // return true;
        // dump($this->toArray());
        $class = '\App\\' . substr(static::class, strlen("App\Http\Requests\Store"));
        // dd(static::class);
        return (new $class)::authorize('create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
