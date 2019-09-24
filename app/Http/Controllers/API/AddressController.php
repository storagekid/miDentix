<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Address;
use App\Http\Requests\QStore;

class AddressController extends Controller
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
        $model = Address::find($id);
        $model->update(request()->all());

        return response([
            'model' => $model->fresh(),
        ], 200);
    }
}
