<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;

class ExportController extends Controller
{
    public function exportExcel() 
    {
        if (!request()->has('blueprint')) abort(403, 'A blueprint is needed');
        if (!request('blueprint')) abort(403, 'A blueprint is needed');
        $blueprint = is_array(request('blueprint')) ? request('blueprint')['value'] : request('blueprint');
        if (strpos(request('model'), '_')) {
            $array = explode('_', request('model'));
            $array[count($array) - 1] = Str::singular($array[count($array) - 1]);
            foreach ($array as $key => $name) {
                $array[$key] = ucfirst($name);
            }
            $name = implode('', $array);
        } else {
            $name = ucfirst(Str::singular(request('model')));
        }
        if ($blueprint === 'Wildcard') {
            $modelClass = '\App\\' . $name;
            if (request('storeExcel')) return Excel::store(new \App\Exports\WildCardViewExports($modelClass), '\temp\\' . $name . '.xlsx');
            return Excel::download(new \App\Exports\WildCardViewExports($modelClass), $name . '.xlsx');
        }
        $exportClass = '\App\Exports\\' . $name . 'Exports';
        if (!class_exists($exportClass)) abort(403, 'This Model is not exportable.');
        if (!in_array($blueprint, (new $exportClass)::$blueprints)) abort(403, 'Blueprint doesn\'t exists.');
        if ($blueprint === 'TPA (Janire)') {
            // dump('Writing to: ');
            // dump(storage_path('app/temp/') . $name);
            set_time_limit(120);
            return Excel::store(new $exportClass, '/temp//' . $name . '.xlsx');
        }
        return Excel::download(new $exportClass, $name . '.xlsx');
    }
}
