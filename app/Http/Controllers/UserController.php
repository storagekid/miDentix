<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Rules\StrongPassword;
use App\User;

class UserController extends Controller
{
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
        $user->password = Hash::make(request('Nueva Contraseñ'));
        $user->save();
    	if (request()->expectsJson()) {
            return response(['Contraseña actualizada.'], 200);
        }
    }
}
