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
    public function downloadTags (Request $request)
    {
        $ids = $request->query('profiles');
        $profiles = Profile::find($ids);
        $clinic = \App\Clinic::find($request->query('clinic'));
        $file = Profile::makeTags($profiles, $clinic);

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

            if (!$file) {
                return response()->json(
                    ['message' => 'Errrrrrroooooorrrr'], 422
                );
            }
            return response()->download($file)->deleteFileAfterSend(true);
        }
    }

    public function downloadCharts (Request $request, $profiles=null, $clinic=null, $license=false)
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
        if (request('license') != 'false') {
            $license = true;
        }
        $file = Profile::makeCharts($profiles, $clinic, $license);

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

            return response()->download($file, cleanString($job->name . '.pdf'))->deleteFileAfterSend(false);

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
