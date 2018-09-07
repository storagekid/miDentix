<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Clinic;
use App\Profile;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response([
            'model' => Profile::scoped('profile'),
            ], 200
        );
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
        // dd(request()->all());
        $profile = Profile::create(request()->all());
        // dd($profile);
        foreach ($profile->getRelations() as $key => $value) {
            if (request()->has($key)) {
                $relation = request($key);
                if (is_string($relation)) {
                    $relation = json_decode($relation, true);
                    // $relation = json_decode(json_encode($relation), true);
                }
                $nRelation = count($relation); 
                if ($nRelation > 0) {
                    $profile->clinicProfiles()->delete();
                    foreach($relation as $model) {
                        // dd($model);
                        $temp = $profile->clinicProfiles()->make($model);
                        $profile->clinicProfiles()->save($temp);
                    } 
                }
            }
        }

        return response([
            'newmodel' => $profile,
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
    public function update(Request $request, $id)
    {
        // dd(request()->all());
        $profile = Profile::find($id);
        $profile->update(request()->all());
        // dd($profile);
        foreach ($profile->getRelations() as $key => $value) {
            if (request()->has($key)) {
                $relation = request($key);
                if (is_string($relation)) {
                    $relation = json_decode($relation, true);
                    // $relation = json_decode(json_encode($relation), true);
                }
                $nRelation = count($relation); 
                if ($nRelation > 0) {
                    $profile->clinicProfiles()->delete();
                    foreach($relation as $model) {
                        // dd($model);
                        $temp = $profile->clinicProfiles()->make($model['pivot']);
                        $profile->clinicProfiles()->save($temp);
                    } 
                }
            }
        }

        return response([
            'updatedModel' => $profile,
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
            $name = Profile::find($id)->fullName;
            Profile::destroy($id);
            return response([
                'message' => 'Perfil de ' . $name . ' eliminado correctamente',
            ], 200);
        } catch (\Exception $e) {
            return response([
                'message' => $e->getMessage(),
            ]);
        }
    }
}
