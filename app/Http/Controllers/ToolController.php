<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ToolController extends Controller
{
    public function index() {
    	return view('layouts.tools.tools-index');
    }
    public function meta4Upload() {
    	dd(request()->all());
    }
}
