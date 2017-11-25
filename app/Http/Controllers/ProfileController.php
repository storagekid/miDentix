<?php

namespace App\Http\Controllers;
use App\User;
use App\Profile;
use Carbon\Carbon;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index() {
    	return view('layouts.profile.profile-index2');
    }

    public function indexApi() {
        return auth()->user()->profile->load(['experiences','especialties','masters']);
    }

    public function create(User $user) {
    	return view('layouts.profile.profile-create', compact('user'));
    }
    public function update(Profile $profile) {
    	$allowed = ['name','lastname1','lastname2','email','phone','personal_id_number','license_number','license_year'];
        // $this->authorize('update',$reply);
        // request()->validate(['body'=> 'required|spamfree']);
        // if (request()->expectsJson()) {
        //     return response([
        //         'status'=>'Profile updated',
        //         'profile' => request('profile'),
        //         'especialtiesToRemove' => request('especialtiesToRemove'),
        //         'especialtiesToSave' => request('especialtiesToSave'),
        //         'experiencesToRemove' => request('experiencesToRemove'),
        //         'experiencesToSave' => request('experiencesToSave'),
        //         200]);
        // }
        if (request('profile')) {
        	$found = [];
        	$profileSent = request('profile');
        	foreach ($profileSent as $key => $value) {
        		if (in_array($key, $allowed)) {
        			$profile[$key] = $value;
        		}
        	};
        	$profile->save();
        }
        if (request('especialtiesToRemove')) {
        	$found = [];
        	$items = request('especialtiesToRemove');
        	foreach ($items as $item) {
        		$found[] = $item;
        		$profile->especialties()->detach($item);
        	}
        	$profile->updated_at = Carbon::now();
        	$profile->save();
        }
        if (request('especialtiesToSave')) {
        	$found = [];
        	$items = request('especialtiesToSave');
        	foreach ($items as $item) {
        		$found[] = $item;
        		$profile->especialties()->attach($item);
        	}
        	$profile->updated_at = Carbon::now();
        	$profile->save();
        }
        if (request('experiencesToRemove')) {
        	$found = [];
        	$items = request('experiencesToRemove');
        	foreach ($items as $item) {
        		$found[] = $item;
        		$profile->experiences()->detach($item);
        	}
        	$profile->updated_at = Carbon::now();
        	$profile->save();
        }
        if (request('experiencesToSave')) {
        	$found = [];
        	$items = request('experiencesToSave');
        	foreach ($items as $item) {
        		$found[] = $item;
        		$profile->experiences()->attach($item);
        	}
        	$profile->updated_at = Carbon::now();
        	$profile->save();
        }
    }
}
