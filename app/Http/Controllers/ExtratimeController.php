<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExtratimeController extends Controller
{
    public function create() {
    	return view('layouts.schedule.schedule-extraTime-create');
    }
}
