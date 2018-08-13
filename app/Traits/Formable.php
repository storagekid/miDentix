<?php

namespace App\Traits;

trait Formable {

    public function getFormInfo() {
        return [
            'fields' => $this->getFields(),
            'models' => $this->formModels,
            'relations' => $this->formRelations ? $this->formRelations : [],
            'relationsItems' => $this->fetchRelations()
        ];
    }

    public function getFields() {
        if ($this->formFields) {
            return $this->fieldBuilder($this->formFields);            
        } else {
            return $this->fieldBuilder($this->fillable);
        }
    }

    public function getRelations() {
        return $this->formRelations;
    }

    public function fieldBuilder($fields, $options=[]) {
        $defFields = [];

        foreach ($fields as $key => $field) {
            $options = [];
            $type = [];
            // $filtering = [];
            if (is_array($field)) {
                $options = $field;
                if (array_key_exists('type', $options)) {
                    $type = $options['type'];
                }
                $name = $key;
            } else {
                $name = $field;
            }

            $temp = [];
            $temp['label'] = array_key_exists('label', $options) ? $options['label'] : ucfirst($name);
            $temp['name'] = $name;
            $temp['rules'] = array_key_exists('rules', $options) ? $options['rules'] : [];
            $temp['value'] = array_key_exists('value', $options) ? $options['value'] : null;
            $temp['colClasses'] = array_key_exists('colClasses', $options) ? $options['colClasses'] : 'fx-b-50';
            $temp['dontRecord'] = array_key_exists('dontRecord', $options) ? $options['dontRecord'] : false;
            $temp['dependsOn'] = array_key_exists('dependsOn', $options) ? $options['dependsOn'] : null;
            $temp['affects'] = array_key_exists('affects', $options) ? $options['affects'] : null;
            $temp['type'] = $this->formTypeBuilder($type);

            $defFields[$key] = $temp;
        };

        return $defFields;
    }

    public function formTypeBuilder($type, $default=[]) {
        // var_dump($type);
        if (array_key_exists('default', $type)) {
            $default = $type['default'];
        }
        return [
            'name' => array_key_exists('name', $type) ? $type['name'] : 'inputText',
            'model' => array_key_exists('model', $type) ? $type['model'] : null,
            'text' => array_key_exists('text', $type) ? $type['text'] : null,
            'value' => array_key_exists('value', $type) ? $type['value'] : null,
            'default' => [
                'value' => array_key_exists('value', $default) ? $default['value'] : null,
                'text' => array_key_exists('text', $default) ? $default['text'] : 'Seleccione',
                'disabled' => array_key_exists('disabled', $default) ? $default['disabled'] : false,
            ],
        ];
    }

    public function fetchRelations() {
        if ($this->formRelations) {
            foreach ($this->formRelations as $key => $relation) {
                return $this->$key;
            }
        } else {
            return [];
        }
    }
}