<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Extratime;
use Carbon\Carbon;

class ExtratimeController extends Controller
{
    public function index() {
        return view('layouts.extratime.extratime-index');
    }
    public function create() {
    	return view('layouts.schedule.schedule-extraTime-create');
    }
    public function store() {
    		$extratime = Extratime::create([
    	        'profile_id' => request('profile_id'),
    	        'clinic_id' => request('clinic_id'),
    	        'state_id' => request('state_id'),
    	        'provincia_id' => request('provincia_id'),
    	        'schedule' => request('schedule'),
    	   	]);
            if (request('especialtiesToSave')) {
                $found = [];
                $items = request('especialtiesToSave');
                foreach ($items as $item) {
                    $found[] = $item;
                    $extratime->especialties()->attach($item);
                }
                $extratime->updated_at = Carbon::now();
                $extratime->save();
            }
    	   	if (request()->expectsJson()) {
                return response([
                    'status'=>'Extratime created',
                    'extratime' => $extratime->fresh(), 
                    200]);
            }
    }
    public function update(Extratime $extratime) {
        $extratime->state = request()->get('state');
        $extratime->save();
        if (request()->expectsJson()) {
                return response([
                    'status'=>'Extratime closed',
                    200]);
            }
    }
    public function destroy(Extratime $extratime) {
        $extratime->delete();
    }
}
