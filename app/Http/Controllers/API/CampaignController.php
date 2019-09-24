<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Campaign;
use App\Http\Requests\QStore;

class CampaignController extends Controller
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
        $model = Campaign::find($id);
        $model->update(request()->all());

        return response([
            'model' => $model->fresh()->attachFull(),
        ], 200);
    }
}
