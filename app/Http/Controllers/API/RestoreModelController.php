<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RestoreModelController extends Controller
{
    /**
     * Restore the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore(Request $request, $id)
    {
        // dump('Restoring');
        $model = request('nameSpace')::onlyTrashed()->find($id);
        $model->restore();
        // dd($model);
        return response([
            'model' => $model->fresh(),
        ], 200);
    }

    /**
     * Permanently deletes the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!auth()->user()->isRoot()) abort(403);
        $name = request('nameSpace');
        $model = $name::onlyTrashed()->findOrFail($id);
        if (isset($name::$cascade)) {
            foreach ($name::$cascade as $relation) $model->$relation()->delete();
        }
        $model->forceDelete($id);

        return response([
            'model' => $model,
        ], 200);
    }
}
