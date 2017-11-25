<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Experience;

class ExperienceController extends Controller
{
   public function indexApi() {
       return Experience::all();
   }
}
