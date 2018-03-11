<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Profile;
use App\Rules\StrongPassword;
use App\User;

class UserController extends Controller
{
    public function index() {
        return view('layouts.users.users-index');
    }
    public function indexApi() {
        $users = Profile::all()->load(['user' => function($query) {
            $query->select('id','last_access')->where('role','user');
        },'schedules','masters','courses','clinics']);
        $filtered_collection = $users->filter(function ($item) {
            if ($item->user) {
                return $item;
            }
        })->values();

        if (request()->expectsJson()) {
            return response([
                'users'=>$filtered_collection,
                ],200);
        }
    }
    public function getRouteKeyName() {
        return 'personal_id_number';
    }
    public function resetPassApi() {
    	$pass = Hash::check(request('Contraseña Actual'), auth()->user()->password);
    	if (!$pass) {
    		return response([
    			'message'=>'La contraseña actual no es correcta'],400);
    	}
    	request()->validate([
    	    'Nueva Contraseña' => ['required','min:8','confirmed',new StrongPassword,'different:Contraseña Actual'],
    	]);
        $user = auth()->user();
        $user->password = Hash::make(request('Nueva Contraseña'));
        $user->save();
    	if (request()->expectsJson()) {
            return response(['Contraseña actualizada.'], 200);
        }
    }
}
