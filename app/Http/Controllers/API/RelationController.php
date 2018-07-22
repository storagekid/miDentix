<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class RelationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd(request()->all());
        if (request()->has('relation') && request('relation') !== 'undefined') {
            $models = [Str::singular(request('relation')), Str::singular(request('model'))];
            sort($models);
            $model = implode('_', [ucfirst($models[0]), ucfirst($models[1])]);
        } else {
            $model = Str::singular(request('model')); 
        }

        $model = 'App\\' . $model;

        // var_dump(request('ids'));
        // var_dump($model);
        // $id = $model::orderBy('id', 'desc')->first()->id+1;
        $model = $model::make(request()->all());
        // $model->id = $id;
        return response([
            'relation' => $model,
            ],200);
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
        // dd(request()->all());
        if (request()->has('relation') && request('relation') !== 'undefined') {
            $models = [Str::singular(request('relation')), Str::singular(request('model'))];
            sort($models);
            $model = implode('_', [ucfirst($models[0]), ucfirst($models[1])]);
        } else {
            $model = Str::singular(request('model')); 
        }

        $model = 'App\\' . $model;
        // $model = $model::find($id);

        // var_dump(request('ids'));
        // var_dump($model);
        // $id = $model::orderBy('id', 'desc')->first()->id+1;
        // $model->update(request()->all());
        $model = $model::make(request()->all());
        $model->id = $id;
        // $model->id = $id;
        return response([
            'relation' => $model,
            ],200);
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
