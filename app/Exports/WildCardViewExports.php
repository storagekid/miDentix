<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class WildCardViewExports implements FromView
{
    protected $model;
    public function __construct($model)
    {
        $this->model = $model;
    }

    public function view(): View
    {
        $tempModel = $this->model::make();
        $columns = collect($tempModel->getColumns())->pluck('name')->all();
        // dd($columns);
        $badColumns = [];
        foreach ($columns as $column) {
            if (strpos($column, '.') > 0) {
                $badColumns[] = $column;
            }
        }
        if (in_array('actions', $columns)) array_splice($columns, array_search('actions', $columns));
        // dd($columns);
        $with = [];
        if (request()->has('modelOptions')) {
            if (request('modelOptions')['full']) $models = $this->model::with($this->model::getFullModels());
            else if (request('modelOptions')['with']) $models = $this->model::with(request('modelOptions')['with']);
            if (request('modelOptions')['withCount']) $models = $models->withCount(request('modelOptions')['withCount']);
        }
        // dump(request('modelOptions')['withCount']);
        // $models = $this->model::with($this->model::getFullModels());
        if (count(request('ids')) > 0) $models = $models->find(request('ids'));
        else $models = $models->get();
        $models = $models->toArray();
        foreach ($models as $key => $model) {
            if (count($badColumns) > 0) {
                foreach ($badColumns as $column) {
                    // dump($column);
                    $words = explode('.', $column);
                    $item = $model[$words[0]];
                    $counter = 1;
                    while ($counter < count($words)) {
                        $item = $item[$words[$counter]];
                        $counter++;
                    }
                    // dump($item);
                    $models[$key][$column] = $item;
                }
            }
            foreach ($model as $o => $field) {
                if (!in_array($o, $columns)) {
                    unset($models[$key][$o]);
                }
                if (is_array($field) && in_array($o, $columns)) {
                    $string = implode(", ", collect($field)->pluck('label')->all());
                    $models[$key][$o] = $string;
                }
            }
        }
        // dd($models[0]);
        return view('exports.wildCardExcel', [
            'columns' => $columns,
            'models' => $models
        ]);
    }
}
