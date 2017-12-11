<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Schedule;
use App\Clinic_Profile;
use App\Extratime;
use App\Profile;
use Carbon\Carbon;

class ScheduleController extends Controller
{
    public function index() {
    	return view('layouts.schedule.schedule-index');
    }
    public function indexApi() {
        if (auth()->user()->role == 'admin') {
            $extratimes = Extratime::all()->load(['profile']);
            return ['extratimes'=>$extratimes];
        }
        return auth()->user()->profile->load(['schedules','clinics','extratimes']);
    }
    public function indexProfileApi(Profile $profile) {
        return $profile->load(['schedules','clinics','extratimes']);
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
        if (!request('clinic_profile')) {
            $clinic_profile = Clinic_Profile::create([
                'profile_id' => request('profile_id'),
                'clinic_id' => request('clinic_id'),
            ]);
        }
        if (request('especialtiesToRemove')) {
            $found = [];
            $items = request('especialtiesToRemove');
            foreach ($items as $item) {
                $found[] = $item;
                $schedule->especialties()->detach($item);
            }
            $schedule->updated_at = Carbon::now();
            $schedule->save();
        }
        if (request('especialtiesToSave')) {
            $found = [];
            $items = request('especialtiesToSave');
            foreach ($items as $item) {
                $found[] = $item;
                $schedule->especialties()->attach($item);
            }
            $schedule->updated_at = Carbon::now();
            $schedule->save();
        }
       	if (request()->expectsJson()) {
            return response([
                'status'=>'Schedule created',
                'schedule' => $schedule->fresh(), 
                200]);
        }
    }
    public function update(Schedule $schedule) {
        $schedule->update([
            'schedule' => request('schedule'),
        ]);
        if (request('especialtiesToRemove')) {
            $found = [];
            $items = request('especialtiesToRemove');
            foreach ($items as $item) {
                $found[] = $item;
                $schedule->especialties()->detach($item);
            }
            $schedule->updated_at = Carbon::now();
            $schedule->save();
        }
        if (request('especialtiesToSave')) {
            $found = [];
            $items = request('especialtiesToSave');
            foreach ($items as $item) {
                $found[] = $item;
                $schedule->especialties()->attach($item);
            }
            $schedule->updated_at = Carbon::now();
            $schedule->save();
        }
        if (request()->expectsJson()) {
            return response([
                'status'=>'Schedule updated',
                'schedule' => $schedule->fresh(), 
                200]);
        }
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
