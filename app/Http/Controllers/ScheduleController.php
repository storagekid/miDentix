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
    public function update(Schedule $schedule) {
        $schedule->update([
            'schedule' => request('schedule'),
        ]);
    }
    public function destroy(Schedule $schedule) {
        try {
            $clinic_profile = \App\Clinic_Profile::where([
                'clinic_id' => $schedule->clinic_id,
                'profile_id' => $schedule->profile_id
            ]);
            // dd($clinic_profile->get());
            $clinic_profile->delete();
        } catch (\Exception $e) {
            dd($e);
            return response('Sorry, Validation failed', 422);
        }
        // dd($schedule);
        $schedule->delete();
    }
}
