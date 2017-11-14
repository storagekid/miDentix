<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RequestController extends Controller
{
    public function index() {
    	return view('layouts.requests.requests-index');
    }
    public function show(Request $request) {
    	return view('layouts.requests.requests-show');
    }
    public function create() {
    	return view('layouts.requests.requests-create');
    }
}
