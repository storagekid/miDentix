<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function orderable()
    {
        return $this->morphTo();
    }

    public function shoppingBag()
    {
        return $this->belongsTo(ShoppingBag::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }

    public function makeOrderFile($shoppingBag, $provider, $force=false) {
        $orders = $shoppingBag::where('provider_id', $provider->id);
        $items = \App\ClinicStationary::get();
        $files = $orders->map(function($stationary) {
            return \App\ClinicStationary::where(['stationary_id'=>$stationary->orderable_id,'clinic_id'=>$stationary->clinic_id])->pluck('link');
        });
        $dir = 'orders/';
        $file = $clinic->fullName . '.zip';
        $path = storage_path('app/' . $dir . $file);

        if (!Storage::exists($dir)) {
            Storage::makeDirectory($dir);
        }

        // $route = storage_path('app/stationary/test.zip');
        $zip = \Zipper::make($path);
        foreach($files as $file) {
            $zip->add($file);
        }
        $zip->close();
    }
}
