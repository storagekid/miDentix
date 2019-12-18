<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Routing\Route;
use Illuminate\Validation\Rule;

class QStore extends FormRequest
{
    protected $name, $modelName;

    public function __construct($model = null)
    {
        // dump($model);
        parent::__construct();
        if ($model) $this->name = '\App\Http\Requests\Store' . $model;
        // dump($this->name);
    }
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
    public function rules(Route $route)
    {
        $name = $this->name ?: $route->getController()->requestName;
        $this->modelName = $route->getController()->requestModelName;
        if (class_exists($name)) {
            $request = new $name;
            return $request->rules($this, $this->getRequiredFromMethod(), $this->modelName);
        } else return [];
    }

    public function getChildRules($modelName) {
        if ($this->name) {
            if (class_exists($this->name)) {
                $request = new $this->name;
                return $request->rules($this, $this->getRequiredFromMethod(), $modelName);
            } else return [];
        } else return [];
    }

    public function getRequiredFromMethod() {
        return Rule::requiredIf(request()->isMethod('POST') || request()->isMethod('GET'));
    }
}
