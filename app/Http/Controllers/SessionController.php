<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SessionController extends Controller
{
     public function indexApi() {
        if (request()->expectsJson()) {
            if (auth()->check()) {
                return response(['Session Abierta'], 200);
            } else {
                return response(['Session Cerrada'], 401);
            }
        }
    }
}
