<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Request as RequestModel;
use App\Profile;

class MenuController extends Controller
{
    public function indexApi() {
        if (auth()->user()->role == 'admin') {
            $requests = RequestModel::all();
            $profiles = Profile::all()->load(['user' => function($query) {
            	$query->select('id','last_access');
            }]);
            return ['requests'=>$requests,'profiles'=>$profiles];
        }
    }
}
