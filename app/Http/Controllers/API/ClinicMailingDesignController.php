<?php

namespace App\Http\Controllers\API;

use App\ClinicMailing;
use App\Http\Controllers\Controller;
use App\Http\Requests\QStore;

class ClinicMailingDesignController extends Controller
{
        /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(QStore $request)
    {
        $mailingDesign = \App\MailingDesign::find(request('mailing_design_id'));
        $model = $mailingDesign->clinic_mailing_designs()->create([
            'clinic_id' => request('clinic_id'),
        ]);

        $name = $model->getFileName();

        $file = ClinicMailing::storeFile(request()->file('file'), 'clinics/' . $model->clinic->cleanName . '/mailings', $name, 'multi', auth()->user()->id, 5, false);

        $model->clinic_af_file_id = $file->id;
        $model->save();
        $model->files()->save($file);

        return response([
            'model' => $model->fresh(),
        ], 200);
    }
}
