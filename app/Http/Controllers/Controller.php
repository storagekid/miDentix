<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $modelName = substr(static::class, strlen('App\Http\Controllers\API\\'));
        $modelName = '\App\\' . substr($modelName, 0, strlen($modelName) - strlen('Controller'));
        return response([
            'model' => $modelName::fetch(),
            'quasarData' => $modelName::getQuasarData(),
        ], 200);
    }
}
