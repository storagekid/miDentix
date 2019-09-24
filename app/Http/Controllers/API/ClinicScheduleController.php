<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ClinicSchedule;
use App\Http\Requests\QStore;
use App\Printers\PersonalTagsPrinter;

class ClinicScheduleController extends Controller
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
        $model = ClinicSchedule::find($id);
        $model->update(request()->all());

        return response([
            'model' => $model->fresh(),
        ], 200);
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
