<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\QStore;
use App\MenuItem;

class MenuItemController extends Controller
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
        $model = MenuItem::find($id);
        $model->update(request()->all());

        return response([
            'model' => $model->attachFull(),
        ], 200);
    }
}
