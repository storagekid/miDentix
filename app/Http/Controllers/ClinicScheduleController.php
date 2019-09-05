<?php

namespace App\Http\Controllers;

use App\ClinicSchedule;
use Illuminate\Http\Request;
use App\Http\Requests\StoreClinicSchedule;

class ClinicScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreClinicSchedule $request)
    {
        $model = ClinicSchedule::create(request()->all());

        return response([
            'model' => $model,
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ClinicSchedule  $clinicSchedule
     * @return \Illuminate\Http\Response
     */
    public function show(ClinicSchedule $clinicSchedule)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ClinicSchedule  $clinicSchedule
     * @return \Illuminate\Http\Response
     */
    public function edit(ClinicSchedule $clinicSchedule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ClinicSchedule  $clinicSchedule
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ClinicSchedule $clinicSchedule)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ClinicSchedule  $clinicSchedule
     * @return \Illuminate\Http\Response
     */
    public function destroy(ClinicSchedule $clinicSchedule)
    {
        //
    }
}
