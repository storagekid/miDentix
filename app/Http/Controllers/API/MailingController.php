<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Mailing;
use App\Http\Requests\QStore;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\MailingDataImport;

class MailingController extends Controller
{
    public function mailinigDataUploader(Mailing $mailing) {
        // dump(request()->file());
        Excel::import(new MailingDataImport($mailing), request()->file('file'));
        // dump($clinic ? $clinic->id : 'NULL');
        return response([
            'message' => 'Done!',
        ], 200);
    }
}
