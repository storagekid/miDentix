<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Profile;

class DentistController extends Controller
{
    public function index() {
        return view('layouts.users.dentists-index');
    }
    public function indexApi() {
        $users = Profile::all()->load(['user' => function($query) {
            $query->select('id','last_access')->where('role','user');
        },'schedules','masters','courses','clinics']);
        $filtered_collection = $users->filter(function ($item) {
            if ($item->user) {
                $groups = $item->user->group()->pluck('name')->toArray();
                if (in_array('Dentists', $groups)) {
                    return $item;
                }
            }
        })->values();

        if (request()->expectsJson()) {
            return response([
                'users'=>$filtered_collection,
                ],200);
        }
    }
}
