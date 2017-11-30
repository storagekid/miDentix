<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Profile;

class TutorialController extends Controller
{
    public function index() {
    	if (!auth()->user()->profile->tutorial_completed) {
    		return redirect()->route('home');
    	}
    	return view('layouts.tutorial.tutorial-index');
    }
    public function update(Profile $profile) {
    	$profile->tutorial_completed = request('tutorial_completed');
    	$profile->save();
    	if (request()->expectsJson()) {
            return response(['Paso terminado.'], 200);
        }
    }
}
