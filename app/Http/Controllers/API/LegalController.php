<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\QStore;
use Illuminate\Support\Facades\Storage;

class LegalController extends Controller
{
    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(QStore $request, $id)
    // {
    //     $model = \App\Legal::find($id);
    //     $model->update(request()->all());

    //     return response([
    //         'model' => $model->fresh(),
    //     ], 200);
    // }

    public function downloadCSV() {
        $campaign = \App\Campaign::find(request('campaign_id'));
        $language = \App\Language::find(request('language_id'));
        $file = $campaign->legalsCSVFileBuilder($language);
        return response()->download(storage_path('app/temp/'.$file))->deleteFileAfterSend(true);
    }
}
