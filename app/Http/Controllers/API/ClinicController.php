<?php

namespace App\Http\Controllers\API;

use App\Clinic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClinicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clinics = Clinic::all()->load(['costCenter', 'stationaries']);
        $clinics->map(function ($clinic) {
            return $clinic->getStationaryFilesUrl();
        });
        return response([
                'model' => $clinics,
                ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $clinic = Clinic::create(request()->except(['state_id', 'country_id']))->load(['costCenter', 'stationaries']);

        return response([
            'newmodel' => $clinic,
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Clinic::destroy($id);
    }

    public function table()
    {
        $clinic = Clinic::first();
        $columns = $clinic->tableColumns();
        return response([
            'columns' => $columns,
            ], 200);
    }
}
