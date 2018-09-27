<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class TableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->has('relation') && request('relation') !== 'undefined') {
            $models = [Str::singular(request('relation')), Str::singular(request('model'))];
            sort($models);
            $model = implode('_', [ucfirst($models[0]), ucfirst($models[1])]);
        } else {
            $model = Str::singular(request('model')); 
        }

        $model = 'App\\' . $model;

        $model = $model::make();
        return response([
            'table' => $model->getTableInfo(),
            ],200);
    }

}
