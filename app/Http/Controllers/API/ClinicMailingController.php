<?php

namespace App\Http\Controllers\API;

use App\ClinicMailing;
use App\Http\Controllers\Controller;
use App\Http\Requests\QStore;

class ClinicMailingController extends Controller
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
        $model = ClinicMailing::find($id);

        $model->update(request()->all());

        if (request('file')) {
            $clinic_af = $model->clinic_af()->first();
            if ($clinic_af) $clinic_af->delete();

            $name = $model->getFileName();
            $file = ClinicMailing::storeFile(request()->file('file'), 'clinics/' . $model->clinic->id . '/mailing', $name, 'multi', auth()->user()->id, 5, false);

            $model->clinic_af_file_id = $file->id;
            $model->save();
            $model->files()->save($file);
        }
        $model = $this->getModelName()::fetch(['ids'=>[$id]])[0];

        return response([
            'model' => $model,
        ], 200);
    }
    public function saveAF(ClinicMailing $clinic_mailing)
    {
        $model = $clinic_mailing;
        // dump(request()->all());
        // dump(request()->file());
        // $model->update(request()->all());

        if (request('file')) {
            $clinic_af = $model->clinic_af()->first();
            if ($clinic_af) $clinic_af->delete();

            $name = $model->getFileName();
            $file = ClinicMailing::storeFile(request()->file('file'), 'clinics/' . $model->clinic->id . '/mailing', $name, 'multi', auth()->user()->id, 5, false);

            $model->clinic_af_file_id = $file->id;
            $model->save();
            $model->files()->save($file);

            $model = $this->getModelName()::fetch(['ids'=>[$clinic_mailing->id]])[0];
        }

        return response([
            'model' => $model,
        ], 200);
    }
}
