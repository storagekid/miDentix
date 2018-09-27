<?php

namespace App\Http\Controllers;

use App\ShoppingBag;
use App\Provider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ShoppingBagController extends Controller
{
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

        $dir = 'orders/';
        $name = $orders[0]->clinic->cleanName . '.zip';
        $path = storage_path('app/' . $dir . $name);

        if (!Storage::exists($dir)) {
            Storage::makeDirectory($dir);
        }

        $zip = \Zipper::make($path);
        foreach($files as $file) {
            $zip->add(storage_path('app/'.$file));
        }
        $zip->close();

        return response()->download($path, $name)->deleteFileAfterSend(true);
    }

}
