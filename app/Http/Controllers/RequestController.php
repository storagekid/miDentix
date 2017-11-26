<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Request as RequestModel;
use App\Laboratory;
use App\Profile;

class RequestController extends Controller
{
    public function index() {
    	return view('layouts.requests.requests-index');
    }
    public function indexApi() {
    	$request = new RequestModel();
    	$labs = Laboratory::all();
    	$types = $request->types;
    	$typesDetail1 = $request->type_details1[0];
    	$profile = auth()->user()->profile->load(['requests','clinics']);
    	return ['types'=>$types,'details'=>$typesDetail1,'profile'=>$profile,'labs'=>$labs];
    }
    public function show(Request $request) {
    	return view('layouts.requests.requests-show');
    }
    public function create() {
    	return view('layouts.requests.requests-create');
    }
    public function store(Profile $profile) {
    	request()->validate([
    		'profile_id' => 'required',
    		'clinic_id' => 'required',
    		'type' => 'string|required',
    		'type_detail1' => 'string|nullable',
    		'description' => 'string|min:5|max:500'
    	]);
    	$requestAdded = $profile->requests()->create([
    		'profile_id' => request('profile_id'),
    		'clinic_id' => request('clinic_id'),
    		'type' => request('type'),
    		'type_detail1' => request('type_detail1'),
    		'description' => request('description'),
    	]);

       	if (request()->expectsJson()) {
            return response([
                'status'=>'Request created',
                'request'=>$requestAdded,
                200]);
        }
    }
}
