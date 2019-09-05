<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;

class ExportController extends Controller
{
    public function export() 
    {
        if (strpos(request('model'), '_')) {
            $array = explode('_', request('model'));
            $array[count($array) - 1] = Str::singular($array[count($array) - 1]);
            foreach ($array as $key => $name) {
                $array[$key] = ucfirst($name);
            }
            $name = implode('', $array);
        }
        $class = '\App\Exports\\' . $name . 'Exports';
        return Excel::download(new $class, $name . '.xlsx');
    }
}
