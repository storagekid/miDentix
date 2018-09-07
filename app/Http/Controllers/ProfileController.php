<?php

namespace App\Http\Controllers;
use App\User;
use App\Profile;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;
use App\JobType;

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

    public function show(Profile $profile) {
        return view('layouts.profile.profile-show', [
            'profile' => $profile,
        ]);
    }

    public function create(User $user) {
    	return view('layouts.profile.profile-create', compact('user'));
    }
    public function update(Profile $profile) {
    	$allowed = ['name','lastname1','lastname2','email','phone','personal_id_number','license_number','license_year','university_id','tutorial_completed'];

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
        			$profile->$key = $value;
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

    public function downloadTags (Request $request)
    {
        // dd($request->query('clinic'));
        $ids = $request->query('profiles');
        $profiles = Profile::find($ids);
        $clinic = \App\Clinic::find($request->query('clinic'));
        $file = Profile::makeTags($profiles, $clinic);
        // $item = ClinicStationary::find($id);
        return response()->download($file)->deleteFileAfterSend(true);
    }

    public function downloadBusinessCard (Request $request)
    {
        if (request()->has('profiles')) {
            $profiles = Profile::find(request('profiles'));
            $clinic = \App\Clinic::find($request->query('clinic'));

            $route = storage_path('app/personal-business-cards/' . Carbon::now()->timestamp  . '.zip');
            $tempFile = \Zipper::make($route);

            foreach ($profiles as $profile) {
                $file = Profile::makeBusinessCard($profile, $clinic);
                
                $tempFile->add($file);

            }
            $tempFile->close();
            return response()->download($route, 'Tarjetas de Visita.zip')->deleteFileAfterSend(true);
            
        } else {
            $id = $request->query('profile');
            $profile = Profile::find($id);
            $clinic = \App\Clinic::find($request->query('clinic'));

            $file = Profile::makeBusinessCard($profile, $clinic);
            // $item = ClinicStationary::find($id);
            if (!$file) {
                return response()->json(
                    ['message' => 'Errrrrrroooooorrrr'], 422
                );
            }
            return response()->download($file)->deleteFileAfterSend(true);
        }
    }

    public function downloadCharts (Request $request, $profiles=null, $clinic=null)
    {
        if (!$profiles) {
            $ids = $request->query('profiles');
            $profiles = Profile::find($ids);
        } else {
            $profiles = Profile::find($profiles);
        }
        if (!$clinic) {
            $clinic = \App\Clinic::find($request->query('clinic'));
        } else {
            $clinic = \App\Clinic::find($clinic);
        }

        $file = Profile::makeCharts($profiles, $clinic);
        // $item = ClinicStationary::find($id);
        // return response()->download(storage_path('app/personal-charts/Directorio ' . $clinic->fullName . ' - ' . Carbon::now() . '.pdf'))->deleteFileAfterSend(true);
        return response()->download(storage_path($file))->deleteFileAfterSend(true);
    }

    public function downloadJobCharts (Request $request, $jobs=null)
    {
        if (!request()->has('jobs')) {
            $id = $request->query('job');
            $job = JobType::find($id);

            if (!Storage::exists('job-charts/' . $job->name . '.pdf')) {
                Profile::makeJobCharts($job);
            }
            $file = storage_path('app/job-charts/' . $job->name . '.pdf');
            // $item = ClinicStationary::find($id);
            return response()->download($file)->deleteFileAfterSend(false);

        } else {
            $jobTypes = JobType::whereIn('name',request('jobs'))->get();

            $route = storage_path('app/job-charts/' . Carbon::now()->timestamp  . '.zip');
            $tempFile = \Zipper::make($route);

            foreach ($jobTypes as $job) {
                if (!Storage::exists('job-charts/' . $job->name . '.pdf')) {
                    Profile::makeJobCharts($job);
                }
                $file = storage_path('app/job-charts/' . $job->name . '.pdf');
                
                $tempFile->add($file);

            }
            $tempFile->close();
            return response()->download($route, 'Especialidades.zip')->deleteFileAfterSend(true);
        }
    }
}
