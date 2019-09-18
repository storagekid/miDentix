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
}
