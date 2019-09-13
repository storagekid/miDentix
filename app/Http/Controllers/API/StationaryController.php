<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Stationary;
use function GuzzleHttp\json_encode;
use Illuminate\Support\Facades\Storage;

class StationaryController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $stationary = Stationary::create(request()->all());

        if (request()->hasFile('file')) {
            $file = request()->file('file')->getClientOriginalName();
            $link = request()->file('file')->storeAs('stationary/España/generic', request()->file('file')->getClientOriginalName());
            $stationary->file = $file;
            $stationary->link = $link;
            $stationary->save();            
        } 

        foreach ($stationary->getRelations() as $key => $value) {
            if (request()->has($key)) {
                $relation = request($key);
                if (is_string($relation)) {
                    $relation = json_decode($relation, true);
                }
                $nRelation = count($relation); 
                if ($nRelation > 0) {
                    $stationary->providers()->delete();
                    foreach($relation as $model) {
                        $temp = $stationary->providers()->make($model);
                        $stationary->providers()->save($temp);
                    } 
                }
            }
        }        
        return response([
            'newmodel' => $stationary,
            ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $stationary = Stationary::find($id);

        $stationary->update(request()->all());

        if (request()->hasFile('file')) {
            $file = request()->file('file')->getClientOriginalName();
            $link = request()->file('file')->storeAs('stationary/España/generic', request()->file('file')->getClientOriginalName());
            $stationary->file = $file;
            $stationary->link = $link;
            $stationary->save();            
        } else if (!request('file')) {
            $stationary->link = null;
            $stationary->save(); 
        }

        foreach ($stationary->getRelations() as $key => $value) {
            if (request()->has($key)) {
                $relation = request($key);
                if (is_string($relation)) {
                    $relation = json_decode($relation, true);
                }
                $nRelation = count($relation);
                $stationary->providers()->delete();
                if ($nRelation > 0) {
                    foreach($relation as $model) {
                        $temp = $stationary->providers()->make($model);
                        $stationary->providers()->save($temp);
                    } 
                }
            }
        }

        return response([
            'model' => $stationary->fresh(),
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
        $stationary = Stationary::find($id);
        $stationary->providers()->delete();
        if ($stationary->link) {
            Storage::delete($stationary->link);
        }
        if ($stationary->customizable) {
            foreach($stationary->clinics as $custom) {
                Storage::delete($custom->pivot->link);
            }
            $stationary->clinics()->detach();
        }
        Stationary::destroy($id);
    }
}
