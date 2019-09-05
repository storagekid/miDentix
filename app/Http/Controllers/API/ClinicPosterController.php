<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ClinicPoster;
use App\Http\Requests\StoreClinicPoster;
use App\ClinicPosterPriority;

class ClinicPosterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->has('fake')) {
            $model = \App\ClinicPosterPriority::with(['clinic_poster' => function ($q) { return $q->with(['clinic' => function ($q) { return $q->with('county'); }, 'poster']); }])->get();
        } else $model = ClinicPoster::fetch();

        return response([
            'model' => $model,
            'quasarData' => ClinicPoster::getQuasarData(),
            ], 200
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreClinicPoster $request)
    {
        $model = ClinicPoster::create(request()->all());

        $found = false;
        if (request()->has('clinic_poster_priorities')) {
            $priorities = json_decode(request('clinic_poster_priorities'));
            if (count($priorities)) {
                $found = true;
            }
        }
        $priority = \App\ClinicPosterPriority::create([
            'campaign_id' => null,
            'priority' => $found ? $priorities[0]->priority : 1,
            'clinic_poster_id' => $model->id,
            'starts_at' => $model->starts_at,
            'ends_at' => $model->ends_at
            ]);

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
        $model = ClinicPoster::with(ClinicPoster::$full)->find($id);
        
        return response([
            'model' => $model,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $model = ClinicPoster::find($id);

        $model->update(request()->all());

        return response([
            'model' => $model->attachFull(),
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
            $model = ClinicPoster::find($id);
            $model->clinic_poster_priorities()->delete();

            $model->delete();

            return response([
                'message' => 'Perfil de ' . $model[$model->getKeyField()] . ' eliminado correctamente',
            ], 200);
        } catch (\Exception $e) {
            return response([
                'message' => $e->getMessage(),
            ]);
        }
    }
}
