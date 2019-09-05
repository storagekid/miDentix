<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreClinicPosterPriority;
use App\ClinicPosterPriority;

class ClinicPosterPriorityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $model = ClinicPosterPriority::fetch();

        return response([
            'model' => $model,
            'quasarData' => ClinicPosterPriority::getQuasarData(),
            ], 200
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreClinicPosterPriority $request)
    {
        $model = ClinicPosterPriority::create(request()->all());

        return response([
            'model' => $model->attachFull(),
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
    public function update(StoreClinicPosterPriority $request, $id)
    {
        // dd('Updating PP');
        $model = ClinicPosterPriority::find($id);
        $model->update(request()->all());

        return response([
            'model' => $model->fresh()->attachFull(),
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
            $model = ClinicPosterPriority::find($id);
            ClinicPosterPriority::destroy($id);
            return response([
                'message' => 'Clinic Poster Priority ' . $model[$model->getKeyField()] . ' eliminado correctamente',
            ], 200);
        } catch (\Exception $e) {
            return response([
                'message' => $e->getMessage(),
            ]);
        }
    }
}
