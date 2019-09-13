<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Clinic;
use App\Profile;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProfile;

class ProfileController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = Profile::withTrashed()->find($id);
        $model->getShowRelations(request()->has('view') ? request('view') : null);
        
        return response([
            'model' => $model,
            'quasarData' => Profile::getQuasarData(),
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProfile $request)
    {
        $quasarData = Profile::getQuasarData();
        $profile = Profile::create(request()->all());
        foreach ($quasarData['relations'] as $name => $relation) {
            if ($relation['type'] === 'BelongsToMany' && request()->has($name)) {
                $models = json_decode((request($name)), true);
                if (count($models)) {
                    foreach ($models as $item) {
                        $profile->$name()->attach($item['id']);
                    }
                }
            }
        }

        return response([
            'model' => $profile->attachFull(),
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreProfile $request, $id)
    {
        // dd(request()->all());
        $model = Profile::find($id);
        $model->update(request()->all());

        return response([
            'model' => $model->attachFull(),
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
            $model = Profile::find($id);
            Profile::destroy($id);
            return response([
                'message' => 'Perfil de ' . $model[$model->getKeyField()] . ' eliminado correctamente',
            ], 200);
        } catch (\Exception $e) {
            return response([
                'message' => $e->getMessage(),
            ]);
        }
    }
}
