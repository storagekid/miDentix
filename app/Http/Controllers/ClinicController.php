<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Clinic;
use App\County;

class ClinicController extends Controller
{
    public function index() {
    	$clinics = Clinic::all();
    	$counties = County::all();
    	return view('layouts.clinics.index',compact('clinics','counties'));
    }

    public function update(Clinic $clinic) {

        // $this->authorize('update',$reply);

        // $this->validateReply();
        // dd(request());
        // if (request()->expectsJson()) {
        //     return response(['status'=>'Reply deleted']);
        //     return response(request()->updateData);
        // }
        foreach (request()->updateData as $key => $value) {
        	$clinic->$key = $value;
        }
        $clinic->save();
        // $clinic->update([

        //     'body' => request('body'),
        // ]);

    }
    public function destroyApi() {
        // return Clinic::all()->load('costCenter');
        return response([
                'Clinics Removed!!!',
                ],200);
    }
}
