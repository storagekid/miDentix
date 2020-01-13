<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

class CloneController extends Controller
{
                /**
     * Clone A Model.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function cloneModel()
    {
        $quasarData = json_decode(request('quasarData'), true);
        $options = json_decode(request('options'), true);
        $model = $quasarData['nameSpace']::find(request('id'));
        dd($options);
        return response([
            'model' => $model,
        ], 200);
    }
}
