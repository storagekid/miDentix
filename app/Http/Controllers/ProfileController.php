<?php

namespace App\Http\Controllers;
use App\User;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index() {
    	return view('layouts.profile.profile-index2');
    }

    public function create(User $user) {
    	return view('layouts.profile.profile-create', compact('user'));
    }
}
