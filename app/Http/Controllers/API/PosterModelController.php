<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\QStore;
use App\PosterModel;

class PosterModelController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(QStore $request, $id)
    {
        $model = PosterModel::find($id);
        $model->update(request()->all());
        $model->load(['sanitary_codes']);

        return response([
            'model' => $model,
        ], 200);
    }
}
