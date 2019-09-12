<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PosterModel;
use App\Http\Requests\StorePosterModel;

class PosterModelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response([
            'model' => PosterModel::fetch(),
            'quasarData' => PosterModel::getQuasarData(),
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePosterModel $request)
    {
        // PosterModel::authorize('create');

        $model = PosterModel::create(request()->all());
        $model->load(['sanitary_codes']);

        return response([
            'model' => $model,
        ], 200);
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
    public function update(StorePosterModel $request, $id)
    {
        // dd(request()->all());
        $model = PosterModel::find($id);
        $model->update(request()->all());
        $model->load(['sanitary_codes']);

        return response([
            'model' => $model,
        ], 200);
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