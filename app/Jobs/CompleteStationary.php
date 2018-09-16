<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Clinic;
use App\Stationary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CompleteStationary implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
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
    }
}
