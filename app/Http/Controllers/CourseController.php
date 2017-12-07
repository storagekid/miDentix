<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course;
use Carbon\Carbon;

class CourseController extends Controller
{
    public function destroy(Course $course) {
    	$course->delete();
    	$profile = auth()->user()->profile;
    	$profile->updated_at = Carbon::now();
    	$profile->save();
    	if (request()->expectsJson()) {
            return response([
                'status'=>'Course deleted',
                200]);
        }
    }
}
