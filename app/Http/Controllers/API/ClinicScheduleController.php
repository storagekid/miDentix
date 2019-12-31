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
