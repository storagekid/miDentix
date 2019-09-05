<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUser;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $user = request()->user()->load('profiles');

        // return response([
        //     'model' => 'Clinic::fetch()',
        //     'quasarData' => 'Clinic::getQuasarData()',
        //     ], 200
        // );
        $user = request()->user()->load('profiles');
        $user->append('permissions');
        if (count($user->profiles) === 1) {
            $user['profile'] = \App\Profile::with('clinics', 'stores')->find($user->profiles[0]->id)->append('clinicScope', 'storeScope');
        }
        return $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexAll()
    {
        return response([
            'model' => User::fetch(),
            'quasarData' => User::getQuasarData(),
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
    public function store(StoreUser $request)
    {
        $request['password'] = Hash::make($request['password']);
        $user = User::create($request->toArray());

        if (request()->has('groups')) {
            $groups = json_decode(request('groups'), true);
            $user->group()->sync($groups);
        }
        return response([
            'model' => $user->fresh(),
            ], 200
        );
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
        $user = User::find($id);

        $validatedData = $request->validate([
            'email' => 'required|email|max:255',
            'role' => 'required',
            'groups' => 'required',
        ]);
        // $validatedData['password'] = Hash::make($validatedData['password']);
        $user->email = $validatedData['email'];
        $user->role = $validatedData['role'];

        $user->save();

        if (request()->has('groups')) {
            $groups = json_decode(request('groups'), true);
            $user->group()->sync($groups);
        }

        if (request()->has('profiles')) {
            $profiles = json_decode(request('profiles'), true);
            $user->profiles()->sync($profiles);
        }

        return response([
            'model' => $user->fresh(),
            ], 200
        );
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
            $model = User::find($id);
            User::destroy($id);
            return response([
                'message' => 'User ' . $model[$model->getKeyField()] . ' eliminado correctamente',
            ], 200);
        } catch (\Exception $e) {
            return response([
                'message' => $e->getMessage(),
            ]);
        }
    }
}
