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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response([
            'model' => Profile::fetch('profile', 'name'),
            'quasarData' => Profile::getQuasarData(),
            // 'model' => Profile::with('clinics.schedules')->get(),
            ], 200
        );
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

    // public function downloadTags (Request $request)
    // {
    //     $ids = $request->query('profiles');
    //     $profiles = Profile::find($ids);
    //     $clinic = \App\Clinic::find($request->query('clinic'));
    //     $file = Profile::makeTags($profiles, $clinic);

    //     $headers = [
    //         'Content-Type' => 'application/pdf',
    //         'Content-Disposition' => 'attachment; filename="myfile.txt"',
    //     ];
    //     // return response()->file(public_path('img/logo_mi.png'));
    //     return response()->download($file, 'patata.pdf', $headers)->deleteFileAfterSend(true);
    //     return response()->download($file)->deleteFileAfterSend(true);
    // }
}
