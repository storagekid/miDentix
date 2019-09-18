<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function getModelName()
    {
        $modelName = substr(static::class, strlen('App\Http\Controllers\API\\'));
        $modelName = '\App\\' . substr($modelName, 0, strlen($modelName) - strlen('Controller'));
        return $modelName;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $modelName = substr(static::class, strlen('App\Http\Controllers\API\\'));
        $modelName = '\App\\' . substr($modelName, 0, strlen($modelName) - strlen('Controller'));
        return response([
            'model' => $modelName::fetch(),
            'quasarData' => $modelName::getQuasarData(),
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
            // 'quasarData' => $this->getModelName()::getQuasarData(),
        ], 200);
    }
    
        /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        // dd(request()->all());
        $modelName = substr(static::class, strlen('App\Http\Controllers\API\\'));
        $modelName = '\App\\' . substr($modelName, 0, strlen($modelName) - strlen('Controller'));

        $model = $modelName::fetch(null, null, null, false, [$id])[0];
        $modelName::destroy($id);

        return response([
            'model' => array_key_exists('deleted_at', $model->toArray()) ? $model->fresh() : $model,
        ], 200);
    }
}
