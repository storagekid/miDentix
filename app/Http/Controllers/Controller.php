<?php

namespace App\Http\Controllers;

use App\Http\Requests\QStore;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $requestName, $requestBaseName;

    public function __construct()
    {
        $this->requestBaseName = $this->getbaseRequestModelName();
        $this->requestName = $this->getRequestModelName();
    }

    protected function getBaseModelName()
    {
        $baseName = substr(static::class, strlen('App\Http\Controllers\API\\'));
        $baseName = substr($baseName, 0, strlen($baseName) - strlen('Controller'));
        return $baseName;
    }

    protected function getModelName()
    {
        return '\App\\' . $this->getBaseModelName();
    }

    protected function getBaseRequestModelName()
    {
        return 'Store' . $this->getBaseModelName();
    }

    protected function getRequestModelName()
    {
        return '\App\Http\Requests\Store' . $this->getBaseModelName();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd($this->requestName);
        return response([
            'model' => $this->getModelName()::fetch(),
            'quasarData' => $this->getModelName()::getQuasarData(),
        ], 200);
    }

        /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = $this->getModelName()::useSoftDeleting() ? $this->getModelName()::withTrashed()->find($id) : $this->getModelName()::find($id);
        $model->getView(request()->has('view') ? request('view') : null);
        return response([
            'model' => $model
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(QStore $request)
    {
        // $requestName = $this->getRequestModelName();
        // $rules = (new $requestName)->rules();
        // $validated = request()->validate($rules);

        // $id = $this->getModelName()::create($validated)->id;
        $id = $this->getModelName()::create(request()->all())->id;
        $model = $this->getModelName()::fetch(null, null, null, false, [$id])[0];

        return response([
            'model' => $model,
        ], 200);
    }
    
        /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $name = $this->getModelName();

        $model = $name::fetch(null, null, null, false, [$id])[0];
        if (isset($name::$cascade)) {
            foreach ($name::$cascade as $relation) $model->$relation()->delete();
        }
        $name::destroy($id);

        return response([
            'model' => array_key_exists('deleted_at', $model->toArray()) ? $model->fresh() : $model,
        ], 200);
    }
}
