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
        $fullColumns = collect($tempModel->getColumns());
        $columnsWith = [];
        $columnsAppends = [];
        foreach ($fullColumns as $fullColumn) {
            if ($fullColumn['model'] && !in_array($fullColumn['model'], $columnsWith)) $columnsWith[] = $fullColumn['model'];
            if ($fullColumn['append'] && !in_array($fullColumn['append'], $columnsAppends)) $columnsAppends[] = $fullColumn['append'];
        }
        // dd(request('options'));
        $columns = $fullColumns->pluck('name')->all();
        // dd($columnsWith);
        $badColumns = [];
        foreach ($columns as $column) {
            if (strpos($column, '.') > 0) {
                $badColumns[] = $column;
            }
        }
        if (in_array('actions', $columns)) array_splice($columns, array_search('actions', $columns));
        // dd($columns);
        // dump(request('modelOptions')['withCount']);
        // $models = $this->model::with($this->model::getFullModels());
        // if (count(request('ids')) > 0) $models = $models->find(request('ids'));
        if (count(request('ids')) > 0) $models = $this->model::fetch(['ids'=>request('ids'), 'with'=>$columnsWith, 'appends'=>$columnsAppends]);
        else $models = $this->model::get();
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
