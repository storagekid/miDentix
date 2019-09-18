<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ImageController extends Controller
{
    /**
     * Fetch Thumbnail from Storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function fetchThumbnail()
    {
        if (file_exists(storage_path('app/' . request('image')))) {
            $base64 = 'data:image/jpeg;base64,';
            $thumbnail = storage_path('app/' . request('image'));
            $blob = file_get_contents($thumbnail);
            // $blob = $thumbnail->getImageBlob();
            return $base64 . base64_encode($blob);
        }
        return '';
    }

    public function fetchThumbnails()
    {
        var_dump(request('images'));
        $images = [];
        // foreach (request('images') as $index => $image) {
        //     $images[$index] = 
        // }
        foreach (request('images') as $index => $file) {
            if (file_exists(storage_path('app/' . $file))) {
                $base64 = 'data:image/jpeg;base64,';
                $thumbnail = storage_path('app/' . $file);
                $blob = file_get_contents($thumbnail);
                $images[$index] = $blob;
            } else {
                $images[$index] = null;
            }
        }
        return  $images;
    }
}
