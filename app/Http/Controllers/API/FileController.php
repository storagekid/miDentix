<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\QStore;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use ZipArchive;

class FileController extends Controller
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Qstore $request)
    {
        $modelNameSpace = request('nameSpace');
        $model = $modelNameSpace::find(request('modelId'));
        if ($model[request('fieldName')]) {
            \App\File::destroy($model[request('fieldName')]);
        }
        $file = $modelNameSpace::storeFile(
            request()->file('file'),
            request('fileDir'),
            request('fileName'),
            request('thumbnail'),
            auth()->user()->id,
            5,
            false);
        $model[request('fieldName')] = $file->id;
        $model->save();
        $model->files()->save($file);

        return response([
            'message' => 'File saved'
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
        $file = \App\File::find($id);
        $url = $file->url;
        if ($file->is_public) $url = 'public/' . $url;
        return response()->download(storage_path('app/' . $url), $file->name);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
    public function update(QStore $request, $id)
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
        $file = \App\File::find($id);
        $fileable = $file->fileable;
        if ($fileable) {
            $columns = Schema::getColumnListing($fileable->getTable());
            $fileColumns = [];
            foreach ($columns as $column) {
                if (strpos($column, '_file_id')) $fileColumns[] = $column;
            }
            foreach ($fileColumns as $column) {
                if ($fileable[$column] == $id) {
                    $fileable[$column] = null;
                    $fileable->save();
                }
            }
        }
        $file->delete();
        return response([
            'message' => 'File Deleted Successfully',
        ], 200);
    }

    public function downloads()
    {
        $files = \App\File::find(request('ids'));
        // dump($files->cowunt());
        if ($files->count() === 1) {
            $url = $files[0]->url;
            if ($files[0]->is_public) $url = 'public/' . $url;
            return response()->download(storage_path('app/' . $url), $files[0]->name);
        } else {
            $name = 'Denitx-Q-' . Carbon::now() . '.zip';
            $zip = new ZipArchive();
            $filename = storage_path('app/temp/' . $name);
            if ($zip->open($filename, ZipArchive::CREATE)===TRUE) {
                foreach ($files as $file) {
                    $url = $file->url;
                    if ($file->is_public) $url = 'public/' . $url;
                    // dump(file_exists(storage_path('app/' . $url)));
                    $zip->addFile(storage_path('app/' . $url), $file->name);
                }
            }
            $zip->close();
            return response()->download($filename, $name)->deleteFileAfterSend(true);
        }
    }
}
