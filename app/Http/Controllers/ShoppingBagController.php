<?php

namespace App\Http\Controllers;

use App\ShoppingBag;
use App\Provider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ShoppingBagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ShoppingBag  $shoppingBag
     * @return \Illuminate\Http\Response
     */
    public function show(ShoppingBag $shoppingBag)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ShoppingBag  $shoppingBag
     * @return \Illuminate\Http\Response
     */
    public function edit(ShoppingBag $shoppingBag)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ShoppingBag  $shoppingBag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ShoppingBag $shoppingBag)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ShoppingBag  $shoppingBag
     * @return \Illuminate\Http\Response
     */
    public function destroy(ShoppingBag $shoppingBag)
    {
        //
    }

    public function download($shoppingBag, $provider)
    {
        $orders = \App\Order::where(['provider_id' => $provider, 'shopping_bag_id' => $shoppingBag])->get();

        $files = $orders->map(function($stationary) {
            $item = \App\Stationary::find($stationary->orderable_id);
            // dd($item);
            if ($item->customizable) {
                $temp = \App\ClinicStationary::where(['stationary_id'=>$stationary->orderable_id,'clinic_id'=>$stationary->clinic_id])->pluck('link')->toArray();
                return $temp[0];
            } else if ($item->name == 'medicalChart') {
                $temp = \App\Stationary::where(['id'=>$stationary->orderable_id])->pluck('link')->toArray();
                return $temp[0]; 
            } else {
                $temp = \App\Stationary::where(['id'=>$stationary->orderable_id])->pluck('link')->toArray();
                return $temp[0]; 
            }
        });
        $files = $files->filter(function($file) {
            if ($file) return $file;
        });
        // $files = array_filter(function($file) {
        //     if ($file) return $file;
        // }, $files);
        // dd($files);
        $dir = 'orders/';
        $name = $orders[0]->clinic->cleanName . '.zip';
        $path = storage_path('app/' . $dir . $name);

        // dd($name);

        if (!Storage::exists($dir)) {
            Storage::makeDirectory($dir);
        }

        // dd($files);

        // $route = storage_path('app/stationary/test.zip');
        $zip = \Zipper::make($path);
        foreach($files as $file) {
            $zip->add(storage_path('app/'.$file));
        }
        $zip->close();

        return response()->download($path, $name)->deleteFileAfterSend(true);
    }

    public function makeOrderFile($shoppingBag, $provider, $force=false) {
        // return $path;
    }
}
