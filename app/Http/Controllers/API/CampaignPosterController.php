<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\CampaignPoster;
use App\Http\Requests\StoreCampaignPoster;
use App\Campaign;

class CampaignPosterController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCampaignPoster $request, Campaign $campaign)
    {
        $model = $campaign->campaign_posters()->create([
            'campaign_id' => request('campaign_id'),
            'poster_id' => request('poster_id'),
            'poster_model_id' => request('poster_model_id'),
            'language_id' => request('language_id'),
            'country_id' => request('country_id'),
            'state_id' => request('state_id'),
            'county_id' => request('county_id'),
            'clinic_id' => request('clinic_id'),
            'type' => request('type'),
        ]);
        
        $name = $model->getFileName();

        $file = CampaignPoster::storeFile(request()->file('file'), 'campaigns/' . $campaign->id . '/posters', $name, true, auth()->user()->id, 5, false);

        $model->poster_af_file_id = $file->id;
        $model->save();
        $model->files()->save($file);

        return response([
            'model' => $model->fresh(),
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreCampaignPoster $request, $id)
    {
        $model = CampaignPoster::find($id);

        $model->update([
            'poster_id' => request('poster_id'),
            'poster_model_id' => request('poster_model_id'),
            'language_id' => request('language_id'),
            'country_id' => request('country_id'),
            'state_id' => request('state_id'),
            'county_id' => request('county_id'),
            'clinic_id' => request('clinic_id'),
            'type' => request('type'),
        ]);

        if (request('file')) {
            $poster_af = $model->poster_af()->first()->delete();

            $name = $model->getFileName();
            $file = CampaignPoster::storeFile(request()->file('file'), 'campaigns/' . $model->campaign->id . '/posters', $name, true, auth()->user()->id, 5, false);

            $model->poster_af_file_id = $file->id;
            $model->save();
            $model->files()->save($file);
        }

        return response([
            'model' => $model->fresh(),
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $model = CampaignPoster::findOrFail($id);
            CampaignPoster::destroy($id);
            return response([
                'message' => 'CampaignPoster ' . $model[$model->getKeyField()] . ' eliminado correctamente',
            ], 200);
        } catch (\Exception $e) {
            return response([
                'message' => $e->getMessage(),
            ]);
        }
    }

    // public function download(Request $request, CampaignPoster $campaignposter)
    // {
    //     return response()->download(storage_path('app/' . $campaignposter->link), $campaignposter->file);
    // }

    // public function storeFile ($file, $campaign, $request) {
    //     $name = $file->getClientOriginalName();
    //     // Name Constructor
    //     $model = \App\PosterModel::find($request['poster_model_id'])->name;
    //     $size = \App\Poster::find($request['poster_id'])->name;
    //     $country = \App\Country::find($request['country_id'])->code;
    //     $lang = strtoupper(\App\Language::find($request['language_id'])['639-1']);

    //     $name = $campaign->name . ' ' . $model . ' ' . $size . ' ' . $request['type'] . ' ' . $country;
    //     if ($request['state_id']) {
    //         $state = \App\state::find($request['state_id'])->name;
    //         $pos = strpos($state, ',');
    //         if ($pos) $state = substr($state, 0, $pos);
    //         $name .= '-' . $state;
    //     }
    //     // $request['state_id'] ? $name .= '-' . \App\state::find($request['state_id'])->name : '';
    //     $request['county_id'] ? $name .= '-' . \App\County::find($request['county_id'])->name : '';
    //     $request['clinic_id'] ? $name .= '-' . \App\Clinic::find($request['clinic_id'])->cleanName : '';
    //     $name .=  ' ' . $lang;
    //     $name .=  '.pdf';
    //     // END Name Constructor
    //     $link = $file->storeAs('campaigns/' . $campaign->id . '/posters', $name);

    //     // Create Thumbnail
    //     $imagick = new \Imagick();
    //     // Reads image from PDF
    //     $imagick->readImage(storage_path('app/'.$link));
    //     // $imagick->transformImageColorspace(\Imagick::COLORSPACE_CMYK);

    //     $thumbnailFile = str_replace('.pdf', '.jpg', $name);
    //     $thumbnailDirectory = 'campaigns/' . $campaign->id . '/posters';
    //     $thumbnailPath = 'campaigns/' . $campaign->id . '/posters//' . $thumbnailFile;
    //     if (!Storage::exists('public/' . $thumbnailDirectory)) {
    //         Storage::makeDirectory('public/' . $thumbnailDirectory);
    //     }
    //     // Resize Image
    //     $imagick->resizeImage (400, 400 , \Imagick::FILTER_CATROM , 1, true);
    //     // Writes an image
    //     $imagick->writeImage(storage_path('app/public/' . $thumbnailDirectory . '/' . $thumbnailFile));

    //     return [
    //         'file' => $name,
    //         'link' => $link,
    //         'thumbnail' => $thumbnailPath,
    //         // 'thumbnail16' => $contenido,
    //     ];
    // }
}
