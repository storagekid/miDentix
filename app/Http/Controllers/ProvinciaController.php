<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Provincia;

class ProvinciaController extends Controller
{
     public function indexApi() {
        return Provincia::all();
    }
}
