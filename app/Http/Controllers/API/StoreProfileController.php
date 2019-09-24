<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\QStore;
use App\StoreProfile;

class StoreProfileController extends Controller
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
        $model = StoreProfile::useSoftDeleting() ? StoreProfile::withTrashed()->find($id) : StoreProfile::find($id);

        $model->update(request()->all());

        return response([
            'model' => StoreProfile::fetch(['ids'=>[$id]])[0],
        ], 200);
    }
}
