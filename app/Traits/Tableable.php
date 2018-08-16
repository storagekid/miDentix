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
        return $this->columnBuilder($this->tableColumns);
    }

    public function getOptions() {
        return $this->optionsBuilder($this->tableOptions);
    }

    public function columnBuilder($columns, $options=[]) {
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
            $temp['label'] = array_key_exists('label', $options) ? $options['label'] : ucfirst($name);;
            $temp['name'] = $name;
            $temp['show'] = true;
            $temp['linebreak'] = array_key_exists('linebreak', $options) ? $options['linebreak'] : false;
            $temp['boolean'] = array_key_exists('boolean', $options) ? $options['boolean'] : false;
            $temp['parse'] = array_key_exists('parse', $options) ? true : false;
            $temp['width'] = "";
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
        return [
                'actions' => $options[0],
                'counterColumn' => $options[1],
                'showNew' => $options[2],
        ];
    }
}