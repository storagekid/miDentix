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
        return auth()->user()->profile->load(['experiences','masters','courses']);
    }
    public function indexApiById(Profile $profile) {
        return $profile;
    }

    public function create(User $user) {
    	return view('layouts.profile.profile-create', compact('user'));
    }
    public function update(Profile $profile) {
    	$allowed = ['name','lastname1','lastname2','email','phone','personal_id_number','license_number','license_year','tutorial_completed'];

        // request()->validate([
        //     'email' => 'required|unique:users',
        // ]);
        
        if (request('profile')) {
            $newProfile = new Request(request('profile'));
            $newProfile->validate([
                'email' => 'required|unique:users,email,'.auth()->id(),
                'name' => 'required',
                'personal_id_number' => 'required|unique:profiles,personal_id_number,'.auth()->id(),
                'license_number' => 'required|unique:profiles,license_number,'.auth()->id(),
            ]);
        	$found = [];
        	$profileSent = request('profile');
        	foreach ($profileSent as $key => $value) {
        		if (in_array($key, $allowed)) {
        			$profile[$key] = $value;
        		}
        	};
            $user = $profile->user;
            $user->email = $profile->email;
        	$profile->save();
            $user->save();
        }
        // if (request('especialtiesToRemove')) {
        // 	$found = [];
        // 	$items = request('especialtiesToRemove');
        // 	foreach ($items as $item) {
        // 		$found[] = $item;
        // 		$profile->especialties()->detach($item);
        // 	}
        // 	$profile->updated_at = Carbon::now();
        // 	$profile->save();
        // }
        // if (request('especialtiesToSave')) {
        // 	$found = [];
        // 	$items = request('especialtiesToSave');
        // 	foreach ($items as $item) {
        // 		$found[] = $item;
        // 		$profile->especialties()->attach($item);
        // 	}
        // 	$profile->updated_at = Carbon::now();
        // 	$profile->save();
        // }
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
        if (request()->expectsJson()) {
            return response([
                'status'=>'Profile updated',
                200]);
        }
    }
}
