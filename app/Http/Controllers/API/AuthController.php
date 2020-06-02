<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function login(Request $request) {
        $credentials = $request->validate([
            'name' => 'required|max:255',
            'password' => 'required',
        ]);
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken($user->name . '-token')->accessToken;

            $user->loginApi();

            $mainMenu = $user->buildMainMenu();
            $menus = $mainMenu[0];
            $routes = $mainMenu[1];

            return response()->json(['access_token' => $token, 'user' => $user, 'menus' => $menus, 'routes' => $routes], 200);

        } else {
            return response('Usuario o contraseña incorrectos', 403);
        }
    }
}
