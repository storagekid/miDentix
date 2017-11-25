<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\University;

class UniversityController extends Controller
{
    public function indexApi() {
       return University::all()->load(['masters']);
   }
}
