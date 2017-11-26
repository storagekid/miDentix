<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Master_University;
use App\Profile;
use Carbon\Carbon;

class MasterUniversityController extends Controller
{
    public function store(Profile $profile) {
    	$masterUniversity = Master_University::where([
            'master_id' => request('master_id'),
            'university_id' => request('university_id'),
       	])->get();
        // if (!request('clinic_profile')) {
        //     $clinic_profile = Clinic_Profile::create([
        //         'profile_id' => request('profile_id'),
        //         'clinic_id' => request('clinic_id'),
        //     ]);
        // }
        $profile->masters()->attach($masterUniversity);
        $profile->updated_at = Carbon::now();
        $profile->save();
       	if (request()->expectsJson()) {
            return response([
                'status'=>'Schedule created',
                200]);
        }
    }
    public function destroy(Master_University $master_university) {
    	$profile = auth()->user()->profile;
    	$profile->masters()->detach($master_university);
    	$profile->updated_at = Carbon::now();
    	$profile->save();
    	if (request()->expectsJson()) {
            return response([
                'status'=>'Master deleted',
                200]);
        }
    }
}