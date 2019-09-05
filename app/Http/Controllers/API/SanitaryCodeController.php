<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSanitaryCode;
use App\SanitaryCode;

class SanitaryCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response([
            'model' => SanitaryCode::fetch(),
            'quasarData' => SanitaryCode::getQuasarData(),
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSanitaryCode $request)
    {
        $parent = request('nameSpace')::find(request('relatedId'));
        $model = $parent->sanitary_codes()->create(request()->all());

        return response([
            'model' => $model->fresh(),
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreSanitaryCode $request, $id)
    {
        $model = SanitaryCode::find($id);
        $model->update(request()->all());

        return response([
            'model' => $model->fresh(),
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
        try {
            $text = SanitaryCode::find($id)->label;
            SanitaryCode::destroy($id);
            return response([
                'message' => 'CS ' . $text . ' eliminado correctamente',
            ], 200);
        } catch (\Exception $e) {
            return response([
                'message' => $e->getMessage(),
            ]);
        }
    }
}
