<?php

namespace App\Traits;

trait Tableable {

    public function getTableInfo() {
        return [
            'columns' => $this->getColumns(),
            'options' => $this->getOptions()
        ];
    }

    public function getColumns() {
        return $this->columnBuilder();
    }

    public function getOptions() {
        return $this->optionsBuilder($this->tableOptions);
    }

    public function columnBuilder($options=[]) {
        $columns = $this->tableColumns;
        if (request()->has('tableView')) {
            if ($this->tableViews) {
                if (array_key_exists(request('tableView'), $this->tableViews)) $columns = $this->tableViews[request('tableView')];
            }
        }
        $defColumns = [];

        foreach ($columns as $key => $column) {
            $options = [];
            $sorting = [];
            $filtering = [];
            if (is_array($column)) {
                $options = $column;
                if (array_key_exists('sorting', $options)) {
                    $sorting = $options['sorting'];
                }
                if (array_key_exists('filtering', $options)) {
                    $filtering = $options['filtering'];
                }
                $name = $key;
            } else {
                $name = $column;
            }
            
            $temp = [];
            $temp['label'] = array_key_exists('label', $options) ? $options['label'] : ucfirst($name);
            $temp['field'] = array_key_exists('field', $options) ? $options['field'] : $name;
            $temp['name'] = $name;
            $temp['show'] = array_key_exists('show', $options) ? $options['show'] : true;
            $temp['linebreak'] = array_key_exists('linebreak', $options) ? $options['linebreak'] : false;
            $temp['boolean'] = array_key_exists('boolean', $options) ? $options['boolean'] : false;
            $temp['parse'] = array_key_exists('parse', $options) ? true : false;
            $temp['multiEdit'] = array_key_exists('multiEdit', $options) ? true : false;
            $temp['model'] = array_key_exists('model', $options) ? $options['model'] : false;
            $temp['append'] = array_key_exists('append', $options) ? $options['append'] : false;
            $temp['width'] = "";
            $temp['onGrid'] = array_key_exists('onGrid', $options) ? $options['onGrid'] : 'line';
            $temp['align'] = array_key_exists('align', $options) ? $options['align'] : 'left';
            $temp['sortable'] = array_key_exists('sortable', $options) ? $options['sortable'] : true;
            $temp['sorting'] = $this->sortingBuilder($sorting);
            $temp['filtering'] = $this->filteringBuilder($name, $filtering);
            $defColumns[] = $temp;
        };

        return $defColumns;
    }

    public function sortingBuilder($options=[]) {
        return [
            'active' => in_array('off', $options) ? false : true,
            'options' => [
                'object' => in_array('object', $options) ? true : false,
                'date' => in_array('date', $options) ? true : false,
                'integer' => in_array('integer', $options) ? true : false,
                'order' => in_array('order', $options) ? true : false
            ]
        ];
    }

    public function filteringBuilder($name, $options=[]) {
        return [
            'active' => in_array('off', $options) ? false : true,
            'key' => $name,
            'options' => [
                'noOptions' => in_array('noOptions', $options) ? true : false,
                'select' => array_key_exists('select', $options) ? $options['select'] : false,
                'search' => in_array('search', $options) ? [$name] : false,
                'integer' => in_array('integer', $options) ? true : false,
                'numeric' => in_array('numeric', $options) ? true : false,
                'number' => in_array('number', $options) ? true : false,
                'date' => in_array('date', $options) ? true : false,
                'nullName' => in_array('nullName', $options) ? $options['nullName'] : false,
                'boolean' => array_key_exists('boolean', $options) ? $options['boolean'] : false,
            ]
        ];
    }

    public function optionsBuilder($options) {
        // dump(static::class);
        // dump(self::class);
        return [
                'actions' => [
                    'view' => (self::class === 'App\Qmodel' ? static::authorize('view') : auth()->guard('api')->user()->isRoot()) ? true : false,
                    'create' => (self::class === 'App\Qmodel' ? static::authorize('create') : auth()->guard('api')->user()->isRoot()) ? true : false,
                    'update' => (self::class === 'App\Qmodel' ? static::authorize('update') : auth()->guard('api')->user()->isRoot()) ? true : false,
                    'destroy' => (self::class === 'App\Qmodel' ? static::authorize('destroy') : auth()->guard('api')->user()->isRoot()) ? true : false
                ],
                'exports' => [
                    'excel' => $this->getExcelBlueprints()
                ],
                'counterColumn' => $options[1],
                'showNew' => $options[2],
        ];
    }
    public function getExcelBlueprints() {
        $shortClass = substr(static::class, stripos(static::class, '\\')+1);
        // dump($shortClass);
        $className = '\App\Exports\\' . $shortClass . 'Exports';
        // dump($className);
        $blueprints = [];
        $authorized = (self::class === 'App\Qmodel' ? static::authorize('view') : auth()->guard('api')->user()->isRoot()) ? true : false;
        if ($authorized) $blueprints[] = 'Wildcard';
        if (class_exists($className)) $blueprints = array_merge($blueprints, (new $className)::$blueprints);
        return $blueprints;
    }
}