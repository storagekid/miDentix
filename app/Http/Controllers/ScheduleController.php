<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Schedule;
use App\Clinic_Profile;

class ScheduleController extends Controller
{
    public function index() {
    	return view('layouts.schedule.schedule-index');
    }
    public function indexApi() {
        return auth()->user()->profile->load(['schedules','clinics']);
    }
    public function create() {
    	return view('layouts.schedule.schedule-create');
    }
    public function store() {
    	$schedule = Schedule::create([
            'profile_id' => request('profile_id'),
            'clinic_id' => request('clinic_id'),
            'schedule' => request('schedule'),
       	]);
        $clinic_profile = Clinic_Profile::create([
            'profile_id' => request('profile_id'),
            'clinic_id' => request('clinic_id'),
        ]);
       	if (request()->expectsJson()) {
            return response(['status'=>'Schedule created', 200]);
        }
    }
    public function destroy(Schedule $schedule) {
        $clinic_profile = \App\Clinic_Profile::where([
            'clinic_id' => $schedule->clinic_id,
            'profile_id' => $schedule->profile_id
        ]);
        // dd($schedule);
        $clinic_profile->delete();
        $schedule->delete();

    }
}
