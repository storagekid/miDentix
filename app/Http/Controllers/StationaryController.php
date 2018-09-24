<?php

namespace App\Http\Controllers;

use App\Stationary;
use App\Clinic;
use App\ClinicStationary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Jobs\CompleteStationary;
use App\Printers\StationaryCustomizablePrinter;
use App\Traits\Scope;

class StationaryController extends Controller
{

    public function download(Request $request)
    {
        $id = $request->query('id');
        $item = ClinicStationary::find($id);
        return response()->download(storage_path('app/' . $item->link), $item->file);
    }

    public function downloadClinic(Request $request, Clinic $clinic)
    {
        $files = glob(storage_path('app/stationary/' . $clinic->countryName . '/clinics/' . $clinic->cleanName . '/*'));
        $route = storage_path('app/stationary/' . $clinic->cleanName . '/test.zip');
        \Zipper::make($route)->add($files)->close();
        return response()->download($route, $clinic->cleanName . '.zip')->deleteFileAfterSend(true);
    }

    public function downloadAll()
    {
        $dirs = Storage::allDirectories('stationary/España/clinics/');
        $route = storage_path('app/stationary/test.zip');
        $zip = \Zipper::make($route);
        $clinics = Clinic::get();
        foreach ($dirs as $directory) {
            $dir = storage_path('app/' . $directory);
            $zip->folder($directory)->add($dir);
        }
        $zip->close();
        return response()->download($route, 'Papelería.zip')->deleteFileAfterSend(true);
    }

    public function regen(Request $request)
    {   
        $forceMode = request('force');
        // $clinics = auth()->user()->profile->clinics;
        $clinics = Clinic::find(Scope::getScope());
        // dd($clinics);
        $stationaries = Stationary::where('customizable', true)->get();

        $params = ['stationaries' => $stationaries, 'forceMode' => $forceMode];

        $clinics->map(function ($clinic) use ($params) {
            $items = [];
            $clinicStationaries = $clinic->stationaries->pluck('id');
            foreach ($params['stationaries'] as $stationary) {
                if (!$clinicStationaries->contains($stationary->id)||$params['forceMode']) {
                    $pdf = new StationaryCustomizablePrinter($stationary, $clinic, true);
                    $pdf->jobSelector();
                    $pdf->createThumbnail();
                    $item = ['link' => $pdf->directory . '/' . $pdf->fileName, 'file' => $pdf->fileName, 'thumbnail' => $pdf->thumbnailPath];
                    if ($params['forceMode']) {
                        $items[$stationary->id] = $item;
                    } else {
                        $clinic->stationaries()->attach($stationary->id, $item);
                    }
                }
            }
            if ($params['forceMode']) {
                $clinic->stationaries()->sync($items);
            }
        });
        
        // return response([
        //     'clinics' => $clinics->load(['costCenter', 'stationaries']),
        //     ], 200
        // );
        if (count($clinics) == 1 ) {
            return response([
                'clinic_stationaries' => $clinics[0]->clinicStationaries,
                ], 200
            );
        } else {
            return response([
                'message' => 'Papelería Regenerada correctamente.',
                ], 200
            );
        }   
    }
}
