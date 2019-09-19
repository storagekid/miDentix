<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Campaign;
use App\CampaignPosterPriority;
use App\Http\Requests\QStore;

class CampaignPosterPriorityController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(QStore $request, Campaign $campaign)
    {
        $model = $campaign->campaign_poster_priorities()->create(request()->all());

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
    public function update(QStore $request, $id)
    {
        $model = CampaignPosterPriority::find($id);
        $model->update(request()->all());

        return response([
            'model' => $model->fresh(),
        ], 200);
    }
}
