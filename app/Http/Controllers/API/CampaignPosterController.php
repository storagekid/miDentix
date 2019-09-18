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

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy($id)
    // {
    //     try {
    //         $model = CampaignPoster::findOrFail($id);
    //         CampaignPoster::destroy($id);
    //         return response([
    //             'message' => 'CampaignPoster ' . $model[$model->getKeyField()] . ' eliminado correctamente',
    //         ], 200);
    //     } catch (\Exception $e) {
    //         return response([
    //             'message' => $e->getMessage(),
    //         ]);
    //     }
    // }
}
