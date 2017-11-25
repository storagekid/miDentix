<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Especialty;

class EspecialtyController extends Controller
{
	public function indexApi() {
	    return Especialty::all();
	}
}
