<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Campaign;
use App\Http\Requests\StoreCampaign;
use App\Notifications\CampaignCreated;

class CampaignController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCampaign $request)
    {
        $models = Campaign::create(request()->all());

        return response([
            'model' => $models->fresh()->attachFull(),
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
        $model = Campaign::find($id);
        $model->attachFull();
        
        return response([
            'model' => $model,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreCampaign $request, $id)
    {
        $model = Campaign::find($id);
        $model->update(request()->all());

        return response([
            'model' => $model->fresh()->attachFull(),
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
        $model = Campaign::find($id);
        Campaign::destroy($id);
        return response([
            'model' => $model->fresh()->attachFull(),
            'message' => 'Campaign ' . $model[$model->getKeyField()] . ' eliminado correctamente',
        ], 200);
    }
}
