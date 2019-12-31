<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\QStore;
use Illuminate\Support\Facades\Storage;

class LegalController extends Controller
{
    public function downloadCSV() {
        $campaign = \App\Campaign::find(request('campaign_id'));
        $language = \App\Language::find(request('language_id'));
        $file = $campaign->legalsCSVFileBuilder($language);
        return response()->download(storage_path('app/temp/'.$file))->deleteFileAfterSend(true);
    }
}
