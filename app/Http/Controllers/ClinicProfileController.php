<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Clinic;
use App\Profile;

class ClinicProfileController extends Controller
{
    public function destroy(Clinic $clinic, Profile $profile) {
    	$clinic_profile = \App\Clinic_Profile::where([
    	    'clinic_id' => $clinic->id,
    	    'profile_id' => $profile->id
    	]);
    	$schedule = \App\Schedule::where([
    		'clinic_id' => $clinic->id,
    		'profile_id' => $profile->id
    	]);
    	$schedule->delete();
        $clinic_profile->delete();
    }
}
