<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\QStore;

class BelongsToManyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    // /**
    //  * Store a newly created resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */
    // public function store(QStore $request)
    // {
    //     // dd(request()->all());
    //     $parent = request('parentNameSpace')::find(request('parentId'));
    //     $relation = request('relation');
    //     $model = request('relatedTo')::find(request('relatedToID'));
    //     $parent->$relation()->attach($model);

    //     return response([
    //         'model' => $model,
    //     ], 200);
    // }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Qstore $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // dd(request()->all());
        $parent = request('sourceModel')::find(request('sourceModelId'));
        $relation = request('relation');
        // $model = request('relatedTo')::find(request('relatedToID'));
        $parent->$relation()->detach(request('id'));

        return response([
            'message' => 'Relation Removed Successfully',
        ], 200);
    }
}
