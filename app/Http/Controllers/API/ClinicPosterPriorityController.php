<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\ClinicPosterPriority;
use App\Http\Requests\QStore;

class ClinicPosterPriorityController extends Controller
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
        // dd('Updating PP');
        $model = ClinicPosterPriority::find($id);
        $model->update(request()->all());

        return response([
            'model' => $model->fresh()->attachFull(),
        ], 200);
    }
}
