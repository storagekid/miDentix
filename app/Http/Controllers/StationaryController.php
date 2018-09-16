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

class StationaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('layouts.stationary.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Stationary $stationary)
    {
        //
    }

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

    public function completeBackup(Request $request)
    {
        Log::info("Request cycle without Queues started");
        // $this->dispatch(new CompleteStationary());
        $clinics = Clinic::get();
        $clinics->map(function ($clinic) {
            $country = $clinic->countryName;
            $dir = 'stationary/' . $country . '/clinics/';
            $fullName = $clinic->cleanName;
            $stationaries = Stationary::get();
            $clinicStationaries = $clinic->stationaries->pluck('id');
            $items = [];
            foreach ($stationaries as $stationary) {
                if ($stationary->customizable && !$clinicStationaries->contains($stationary->id)) {
                    $file = $stationary->description . ' ' . $fullName . '.pdf';
                    $link = $dir . $fullName . '/' . $file;
                    $stationary->makePdf($dir, $stationary, $clinic, true);
                    // Thumbnails
                    // create Imagick object
                    $imagick = new \Imagick();
                    // Reads image from PDF
                    $imagick->readImage(storage_path('app/' . $link.'[0]'));
                    $jpgFile = $stationary->description . ' ' . $fullName . '.jpg';
                    $jpgLink = $dir . $fullName . '/' . $jpgFile;
                    $jpgPath = Storage::url($jpgFile);
                    // Writes an image
                    $imagick->writeImages(storage_path('app/public/' . $jpgFile), true);

                    $item = ['link' => $link, 'file' => $file, 'thumbnail' => $jpgPath];
                    $clinic->stationaries()->attach($stationary->id, $item);
                }
            }
        });
        Log::info("Request cycle without Queues finished");
    }

    public function complete(Request $request)
    {
        // Log::info("Request cycle without Queues started");
        // $this->dispatch(new CompleteStationary());
        $clinics = Clinic::get();
        $clinics->map(function ($clinic) {
            $country = $clinic->countryName;
            $dir = 'stationary/' . $country . '/clinics/';
            $fullName = $clinic->cleanName;
            $stationaries = Stationary::get();
            $clinicStationaries = $clinic->stationaries->pluck('id');
            $items = [];
            foreach ($stationaries as $stationary) {
                if ($stationary->customizable && !$clinicStationaries->contains($stationary->id)) {
                    $pdf = new StationaryCustomizablePrinter($stationary, $clinic, true);
                    $pdf->jobSelector();
                    // dd($pdf);
                    // Thumbnails
                    // create Imagick object
                    $imagick = new \Imagick();
                    // Reads image from PDF
                    $imagick->readImage($pdf->pathToFile.'[0]');
                    $jpgFile = $stationary->description . ' ' . $fullName . '.jpg';
                    $jpgLink = $pdf->directory. '/' . $jpgFile;
                    $jpgPath = Storage::url($jpgFile);
                    // Writes an image
                    $imagick->writeImages(storage_path('app/public/' . $jpgFile), true);

                    $item = ['link' => $pdf->directory . '/' . $pdf->fileName, 'file' => $pdf->fileName, 'thumbnail' => $jpgPath];
                    $clinic->stationaries()->attach($stationary->id, $item);
                }
            }
        });
        // Log::info("Request cycle without Queues finished");
    }

    public function regen(Request $request)
    {   
        $forceMode = request('force');
        if ($forceMode) {
            Storage::deleteDirectory('stationary/España/clinics');
        }
        $clinics = Clinic::get();
        $clinics->map(function ($clinic) use ($forceMode) {
            $country = $clinic->countryName;
            $dir = 'stationary/' . $country . '/clinics/';
            $fullName = $clinic->cleanName;
            $stationaries = Stationary::get();
            $items = [];
            foreach ($stationaries as $stationary) {
                if ($stationary->customizable) {
                    $file = $stationary->description . ' ' . $fullName . '.pdf';
                    $link = $dir . $fullName . '/' . $file;
                    $stationary->makePdf($dir, $stationary, $clinic, $forceMode);
                    // Thumbnails
                    // create Imagick object
                    $imagick = new \Imagick();
                    // Reads image from PDF
                    $imagick->readImage(storage_path('app/' . $link));
                    $jpgFile = $stationary->description . ' ' . $fullName . '.jpg';
                    $jpgLink = $dir . $fullName . '/' . $jpgFile;
                    $jpgPath = Storage::url($jpgFile);
                    // Writes an image
                    $imagick->writeImages(storage_path('app/public/' . $jpgFile), true);

                    $items[$stationary->id] = ['link' => $link, 'file' => $file, 'thumbnail' => $jpgPath];
                }
            }
            $clinic->stationaries()->sync($items);
        });
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Stationary  $stationary
     * @return \Illuminate\Http\Response
     */
    public function show(Stationary $stationary)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Stationary  $stationary
     * @return \Illuminate\Http\Response
     */
    public function edit(Stationary $stationary)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Stationary  $stationary
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Stationary $stationary)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Stationary  $stationary
     * @return \Illuminate\Http\Response
     */
    public function destroy(Stationary $stationary)
    {
        //
    }
}
