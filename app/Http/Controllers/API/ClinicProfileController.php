<?php

namespace App\Http\Controllers\API;

use App\ClinicProfile;
use App\Http\Controllers\Controller;
use App\Http\Requests\QStore;

class ClinicProfileController extends Controller
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
        $model = ClinicProfile::useSoftDeleting() ? ClinicProfile::withTrashed()->find($id) : ClinicProfile::find($id);

        $model->update(request()->all());

        return response([
            'model' => ClinicProfile::fetch(['ids'=>[$id]])[0],
        ], 200);
    }
}
