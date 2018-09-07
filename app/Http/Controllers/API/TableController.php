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
        // dd($model);
        // var_dump(request('ids'));
        // var_dump($model);
        $model = $model::make();
        return response([
            'table' => $model->getTableInfo(),
            ],200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
