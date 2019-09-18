<?php
namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
class QuasarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pos = strpos(request('model'), '_');
        if ($pos) {
            $models = explode('_', request('model'));
            foreach ($models as $i => $model) {
                $models[$i] = ucfirst(Str::singular($models[$i]));
            }
            $model = implode('', $models);
        } else $model = Str::singular(request('model'));
        $model = 'App\\' . $model;
        return response([
            'quasarData' => $model::getQuasarData(),
        ],200);
    }
}