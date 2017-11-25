<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Master;

class MasterController extends Controller
{
    public function indexApi() {
       return Master::all();
   }
}
