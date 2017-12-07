<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Extratime;
use App\Request as RequestModel;
use App\Profile;

class MenuController extends Controller
{
    public function indexApi() {
        if (auth()->user()->role == 'admin') {
            $requests = RequestModel::all();
            $extratimes = Extratime::all();
            $profiles = Profile::all()->load(['user' => function($query) {
            	$query->select('id','last_access')->where('role','user');
            }]);
            return ['requests'=>$requests,'profiles'=>$profiles, 'extratimes'=>$extratimes];
        }
        if (auth()->user()->role == 'user') {
        	$requests = auth()->user()->profile->requests;
            $extratimes = auth()->user()->profile->extratimes;
        	return ['requests'=>$requests, 'extratimes'=>$extratimes];
        }
    }
}
