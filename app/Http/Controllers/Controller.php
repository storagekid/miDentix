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

    public $requestName, $requestBaseName, $requestModelName;

    public function __construct()
    {
        $this->requestBaseName = $this->getbaseRequestModelName();
        $this->requestName = $this->getRequestModelName();
        $this->requestModelName = $this->getModelName();
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
        if (request()->has('quasarData')) {
            $quasarData =  json_decode(request('quasarData'), true);
            if (array_key_exists('relatedId', $quasarData)) $id = $this->storeRelation($quasarData);
            else if (array_key_exists('relatedToID', $quasarData)) return $this->storeBelongsToManyRelation($quasarData);
        }
        else $id = $this->getModelName()::create(request()->all())->id;
        $model = $this->getModelName()::fetch(['ids'=>[$id], 'where' => []])[0];

        if (request()->has('files')) {
            // dump('HERE');
            $modelName = $this->getModelName();
            $this->saveFiles($modelName, $model);
        }

        if (request()->has('options')) {
            $options = json_decode(request('options'), true);
            if (array_key_exists('relationsToClone', $options)) {
                $model = $this->cloneRelations($model, $options['relationsToClone'], $this->getModelName()::with($options['relationsToClone'])->find($options['sourceModel']), 2);
            }
        }

        return response([
            'model' => $model = $this->getModelName()::fetch(['ids'=>[$id], 'where' => []])[0],
        ], 200);
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
        $modelName = $this->getModelName();
        $model = $modelName::useSoftDeleting() ? $modelName::withTrashed()->find($id) : $modelName::find($id);
        $model->update(request()->all());

        if (request()->has('files')) {
            $this->saveFiles($modelName, $model);
        }

        $model = $this->getModelName()::fetch(['ids'=>[$id], 'where' => []])[0];

        return response([
            'model' => $model
        ], 200);
    }

            /**
     * Store Files from Request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function saveFiles($modelName, $model) {
        if ($modelName::useFileable()) {
            $columns = $modelName::getFileColumns();
            $formFields = $model->getFileFields();
            // dd($formFields);
            foreach (request('files') as $field => $file) {
                if (in_array($field, $columns) && array_key_exists($field, $formFields)) {
                    try {
                        $name = $model->getFileNames($field);
                        $path = $model->getFilePaths($field);
                        $thumbnail = $formFields[$field]['type']['thumbnail'];
                        $public = $formFields[$field]['type']['public'];
                        $permissions = $formFields[$field]['type']['permissions'];
                    } catch (\Exception $e) {
                        abort(301, 'Incomplete File Data.');
                    }
                    // $name = $model->clean_name . '-avatar';
                    $file = $modelName::storeFile($file, $path, $name, $thumbnail, auth()->user()->id, auth()->user()->group_users()->first()->group_id, $public, false, $permissions);
                    if ($model[$field]) {
                        $model->$field()->first()->delete();
                    }
                    $model[$field] = $file->id;
                    $model->save();
                    $model->files()->save($file);
                }
            }
        }
    }

        /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeRelation($quasarData)
    {
        $parent = $quasarData['parentNameSpace']::useSoftDeleting() ? $quasarData['parentNameSpace']::withTrashed()->find($quasarData['relatedId']) : $quasarData['parentNameSpace']::find($quasarData['relatedId']);
        $relation = $quasarData['relation'];
        $id = $parent->$relation()->create(request()->all())->id;
        return $id;
    }

            /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeBelongsToManyRelation($quasarData)
    {
        // dump('storeBelongsToManyRelation');
        $parent = $quasarData['parentNameSpace']::find($quasarData['parentID']);
        $relation = $quasarData['relation'];
        $model = $quasarData['relatedTo']::find($quasarData['relatedToID']);
        $parent->$relation()->attach($model);
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
        $model = $name::fetch(['ids'=>[$id]])[0];

        if (isset($name::$cascade) && !$name::useSoftDeleting()) $this->cascadeDeletions($name, $model);

        $name::destroy($id);
        return response([
            'model' => array_key_exists('deleted_at', $model->toArray()) ? $model->fresh() : $model,
        ], 200);
    }

    public function cascadeDeletions ($name, $model) {
        $relations = $model->getRelations();
        foreach ($name::$cascade as $relation) {
            if (in_array($relations[$relation]['type'], ['HasMany', 'MorphMany'])) {
                foreach ($model->$relation as $relatedModel) {
                    $subRelations = $relatedModel->getRelations();
                    foreach ($subRelations as $subRelationName => $values) {
                        if ($values['type'] === 'BelongsToMany') {
                            $relatedModel->{$subRelationName}()->detach();
                        }
                    }
                    $relatedModel->delete();
                }
            }
            else if ($relations[$relation]['type'] === 'BelongsToMany') $model->{$relation}()->detach();
        }
    }

    public function cloneRelations($model, $relations, $oldModel, $levels = null) {
        set_time_limit(120);
        if (isset($this->cloneLevels) && $levels === null) $levels = $this->cloneLevels;
        if (!$levels) return $model;
        $levels--;
        foreach ($oldModel->getRelations() as $relationName => $values) {
            $go = false;
            if ($relations === '*') {
                $relations = collect($oldModel->getRelations())->keys()->toArray();
                $go = true;
            }
            else if (is_array($relations)) if (in_array($relationName, $relations)) $go = true;
            if ($go) {
                switch (true) {
                    case in_array($values['type'], ['HasMany', 'MorphMany']):
                        foreach ($oldModel[$relationName] as $relatedModel) {
                            $newRelation = $model->{$relationName}()->create($relatedModel->toArray());
                            if ($levels) {
                                $newSubelation = $this->cloneRelations($newRelation, '*', $relatedModel, $levels);
                            }
                            if ($values['nameSpace']::useFileable()) {
                                foreach ($relatedModel->files as $file) {
                                    $fieldFields = $relatedModel->getFileFields();
                                    foreach ($fieldFields as $field => $data) {
                                        $newRelatedModel = $model->{$relationName}()->where($field, $relatedModel[$field])->get()[0];

                                        try {
                                            $name = $newRelatedModel->getFileNames($field);
                                            $path = $newRelatedModel->getFilePaths($field);
                                            $thumbnail = $fieldFields[$field]['type']['thumbnail'];
                                            $public = $fieldFields[$field]['type']['public'];
                                            $permissions = $fieldFields[$field]['type']['permissions'];
                                        } catch (\Exception $e) {
                                            abort(301, 'Incomplete File Data.');
                                        }

                                        $file = $values['nameSpace']::storeFile($file->url, $path, $name, $thumbnail, auth()->user()->id, auth()->user()->group_users()->first()->group_id, $public, false, $permissions);

                                        $newRelatedModel[$field] = $file->id;
                                        $newRelatedModel->save();
                                        $newRelatedModel->files()->save($file);
                                    }
                                }
                            }
                            $newRelation->fixRelationUniqueFields($model);
                        }
                        break;
                    case 'BelongsToMany':
                        $model->{$relationName}()->sync($oldModel[$relationName]->map(function($i) { return $i->id; }));
                        break;
                }
            }
        }
        // $model->load($relations);
        return $model;
    }
}
