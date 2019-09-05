<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ClinicSchedule;
use App\Http\Requests\StoreClinicSchedule;
use App\Printers\PersonalTagsPrinter;

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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreClinicSchedule $request)
    {
        $model = ClinicSchedule::create(request()->all());

        return response([
            'model' => $model->fresh(),
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
        $model = ClinicSchedule::find($id);
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
        //
    }

    /**
     * Send Personal Tags For Downloading.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function downloadTags (Request $request)
    {
        $clinic_schedules = ClinicSchedule::find(request('clinic_schedules'));
        $file = new PersonalTagsPrinter($clinic_schedules);
        $file->makePdf();

        return response()->download($file->pathToFile)->deleteFileAfterSend(true);
    }
}
