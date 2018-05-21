<?php

namespace App\Http\Controllers;

use App\Stationary;
use App\Clinic;
use App\ClinicStationary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

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
        $stationary->makeA4('C/ Deseos, 1','28560', 'Mozodealmacen', '911728833');
    }

    public function download(Request $request) {
        $id = $request->query('id');
        $item = ClinicStationary::find($id);
        return response()->download(storage_path('app/'.$item->link), $item->file);
    }

    public function downloadClinic(Request $request, Clinic $clinic) {
        $files = glob(storage_path('app/stationary/' . $clinic->fullName . '/*'));
        $route = storage_path('app/stationary/' . $clinic->fullName . '/test.zip');
        \Zipper::make($route)->add($files)->close();
        return response()->download($route, $clinic->fullName . '.zip')->deleteFileAfterSend(true);
    }

    public function downloadAll() {
        $dirs = Storage::allDirectories('stationary/');
        $route = storage_path('app/stationary/test.zip');
        $zip = \Zipper::make($route);
        $clinics = Clinic::get();
        foreach($dirs as $directory) {
            $dir = storage_path('app/' . $directory);
            $zip->folder($directory)->add($dir);
        }
        $zip->close();
        return response()->download($route, 'Papelería.zip')->deleteFileAfterSend(true);
    }

    public function regen(Request $request)
    {
        Storage::deleteDirectory('stationary');
        $clinics = Clinic::get();
        $clinics->map(function($clinic) {
            $dir = 'stationary/';
            $fullName = $clinic->getFullNameAttribute();
            $stationaries = Stationary::get();
            $items = [];
            foreach ($stationaries as $stationary) {
                $file = $stationary->description . ' ' . $fullName . '.pdf';
                $link = $dir . $fullName .'/' . $file;
                $stationary->makePdf($stationary, $clinic->address_real_1,$clinic->postal_code, $clinic->city, $clinic->phone_real, true);
                $items[$stationary->id] = ['link' => $link, 'file' => $file];
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
