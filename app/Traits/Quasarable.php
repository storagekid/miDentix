<?php

namespace App\Traits;

use App\Http\Requests\QStore;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

trait Quasarable {

  protected $modelsNeeded = [];
  protected $appModels = ['clinics', 'states', 'counties'];
  private $fields;

  public static function getQuasarData () {
    // $model = static::class;
    return (new static)->quasarData();
    // return $model::make()->quasarData();
  }

  protected function getQuasarFormFields() {
    return property_exists($this, 'quasarFormFields') ? $this->quasarFormFields : [];
  }

  public function getFields($fields) {
    $fileFields = [];
    $modelFields = property_exists($this, 'quasarFormFields') ? $this->quasarFormFields : [];
    if (is_string($fields)) return $modelFields[$fields];
    foreach ($modelFields as $name => $field) {
      if (is_array($fields)) if (in_array($name, $fields)) $fileFields[$name] = $field;
    }
    return $fileFields;
  }

  protected function getQuasarNewFormLayout() {
    return property_exists($this, 'quasarFormNewLayout') ? $this->quasarFormNewLayout : [];
  }

  protected function getQuasarUpdateFormLayout() {
    return property_exists($this, 'quasarFormUpdateLayout') ? $this->quasarFormUpdateLayout : [];
  }

  public function quasarData() {
    $this->fields = $this->getDBColumns();
    $relations = $this->getRelations();
    $relationOptions = $this->getRelationOptions();
    $formFields = $this->getFormFields();
    $rules = $this->formRules();
    $listFields = $this->getListFields();
    $this->layoutComposer($formFields);
    return [
      'nameSpace' => '\\' . get_class($this),
      'fields' => $this->fields,
      'relations' => $relations,
      'relationOptions' => $relationOptions,
      'formFields' => $formFields,
      'listFields' => $listFields,
      'rules' => $rules,
      'keyField' => $this->getKeyField(),
      'modelsNeeded' => $this->modelsNeeded,
      'newLayout' => $this->getQuasarNewFormLayout(),
      'updateLayout' => $this->getQuasarUpdateFormLayout(),
      'onRelationMode' => $this->onRelationMode ? $this->onRelationMode : []
    ];
  }
  public function getDBColumns () {
    return Schema::getColumnListing($this->getTable());
  }
  public function getListFields () {
    $fields = $this->listFields ? $this->listFields : [
        'mode' => 'list',
        'draggable' => false,
        'left' => [],
        'main' => [
          $this->getKeyField() => ['text']
        ],
        'right' => [],
    ];
    if (!array_key_exists('mode', $fields)) $fields['mode'] = 'list';
    return $fields;
  }
  public function getFormFields () {
    $formFields = [];
    foreach ($this->getDBColumns() as $key => $field) {
      if ($field === 'id') continue;
      if (array_key_exists($field, $this->getQuasarFormFields())) {
        $key = $field;
        $field = $this->quasarFormFields[$field];
      } else continue;
      $options = [];
      $type = [];
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
      // $temp['rules'] = array_key_exists('rules', $options) ? $options['rules'] : [];
      $temp['value'] = array_key_exists('value', $options) ? $options['value'] : null;
      $temp['batch'] = array_key_exists('batch', $options) ? $options['batch'] : false;
      $temp['colClasses'] = array_key_exists('colClasses', $options) ? $options['colClasses'] : 'fx-b-50';
      $temp['onObject'] = array_key_exists('onObject', $options) ? $options['onObject'] : null;
      $temp['dontRecord'] = array_key_exists('dontRecord', $options) ? $options['dontRecord'] : false;
      $temp['dependsOn'] = array_key_exists('dependsOn', $options) ? $options['dependsOn'] : null;
      $temp['affects'] = array_key_exists('affects', $options) ? $options['affects'] : null;
      $temp['show'] = array_key_exists('show', $options) ? $options['show'] : true;
      $temp['type'] = $this->formTypeBuilder($type, $name);

      $formFields[$name] = $temp;
    }
    // Compose UNREAL (NON PERSISTABLE) FIELDS
    foreach ($this->getQuasarFormFields() as $key => $field) {
      if (!array_key_exists('unreal', $field)) continue;
      if (!$field['unreal']) continue;
      $options = [];
      $type = [];
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
      // $temp['rules'] = array_key_exists('rules', $options) ? $options['rules'] : [];
      $temp['value'] = array_key_exists('value', $options) ? $options['value'] : null;
      $temp['batch'] = array_key_exists('batch', $options) ? $options['batch'] : false;
      $temp['colClasses'] = array_key_exists('colClasses', $options) ? $options['colClasses'] : 'fx-b-50';
      $temp['dontRecord'] = array_key_exists('dontRecord', $options) ? $options['dontRecord'] : false;
      $temp['dependsOn'] = array_key_exists('dependsOn', $options) ? $options['dependsOn'] : null;
      $temp['affects'] = array_key_exists('affects', $options) ? $options['affects'] : null;
      $temp['show'] = array_key_exists('show', $options) ? $options['show'] : true;
      $temp['type'] = $this->formTypeBuilder($type, $name);

      $formFields[$name] = $temp;
    }
    // Compose GHOST FIELDS (NOT PRESENT IN TABLE) FIELDS
    foreach ($this->getQuasarFormFields() as $key => $field) {
      if (!array_key_exists('ignoreTable', $field)) continue;
      if (!$field['ignoreTable']) continue;
      $options = [];
      $type = [];
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
      // $temp['rules'] = array_key_exists('rules', $options) ? $options['rules'] : [];
      $temp['value'] = array_key_exists('value', $options) ? $options['value'] : null;
      $temp['batch'] = array_key_exists('batch', $options) ? $options['batch'] : false;
      $temp['colClasses'] = array_key_exists('colClasses', $options) ? $options['colClasses'] : 'fx-b-50';
      $temp['dontRecord'] = array_key_exists('dontRecord', $options) ? $options['dontRecord'] : false;
      $temp['dependsOn'] = array_key_exists('dependsOn', $options) ? $options['dependsOn'] : null;
      $temp['affects'] = array_key_exists('affects', $options) ? $options['affects'] : null;
      $temp['show'] = array_key_exists('show', $options) ? $options['show'] : true;
      $temp['type'] = $this->formTypeBuilder($type, $name);

      $formFields[$name] = $temp;
      $this->fields[] = $name;
    }
    // var_dump($formFields);
    return $formFields;
  }
  public function getRelations () {
    if (!$this->relatedTo) return [];
    $relatedTo = [];
    $relationsWithRequiredModels = ['BelongsToMany'];
    foreach ($this->relatedTo as $relation) {
      $model = new static;
      if (gettype($relation) !== 'string') {
        dump($relation);
        dd(gettype($relation));
      }
      $rel = $model->{$relation}();
      $nameSpace = '\\' . get_class($rel->getRelated());
      $model = $nameSpace::make();
      $type = $this->get_short_class($this->{$relation}());
      if (in_array($type, $relationsWithRequiredModels) && !in_array($relation, $this->appModels)) {
        $this->modelsNeeded[$relation] = [
          'scoped' => false,
          'refresh' => false,
          'cache' => false,
          'where' => false
        ];
      }
      $relatedTo[$relation] = [
        'name' => $relation,
        'nameSpace' => $nameSpace,
        'fields' => Schema::getColumnListing($model->getTable()),
        'quasarData' => $nameSpace::getQuasarData(),
        'type' => $type
      ];
      if ($type === 'HasManyThrough') {
        $middleModel = $this->$relation()->getQualifiedParentKeyName();
        $middleClass = '\\' . get_class($this->$relation()->getParent());
        $relatedTo[$relation]['middleModel'] = substr($middleModel, 0, strpos($middleModel, '.'));
        $relatedTo[$relation]['middleClass'] = $middleClass;
      }
      if ($type === 'HasMany') {
        $middleModel = $this->$relation()->getQualifiedParentKeyName();
        $middleClass = '\\' . get_class($this->$relation()->getParent());
        $related = '\\' . get_class($this->$relation()->getRelated());
        $parentKey = $this->$relation()->getParentKey();
        $getForeignKeyName = $this->$relation()->getForeignKeyName();
        $getQualifiedForeignKeyName = $this->$relation()->getQualifiedForeignKeyName();
        // $getLocalKeyName = $this->$relation()->getLocalKeyName();
        $relatedTo[$relation]['middleModel'] = substr($middleModel, 0, strpos($middleModel, '.'));
        $relatedTo[$relation]['middleClass'] = $middleClass;
        $relatedTo[$relation]['related'] = $related;
        $relatedTo[$relation]['parentKey'] = $parentKey;
        $relatedTo[$relation]['getForeignKeyName'] = $getForeignKeyName;
        $relatedTo[$relation]['getQualifiedForeignKeyName'] = $getQualifiedForeignKeyName;
        // $relatedTo[$relation]['getLocalKeyName'] = $getLocalKeyName;
        foreach ($relatedTo[$relation]['quasarData']['newLayout'] as $i => $step) {
          foreach ($step['fields'] as $o => $row) {
            if ($row[$getForeignKeyName]) {
              unset($relatedTo[$relation]['quasarData']['newLayout'][$i]['fields'][$o][$getForeignKeyName]);
            }
          }
        }
        // dd($relatedTo);
      }
      if (count($relatedTo[$relation]['quasarData']['modelsNeeded'])) {
        foreach ($relatedTo[$relation]['quasarData']['modelsNeeded'] as $modelNeeded => $data) {
          if (!array_key_exists($modelNeeded, $this->modelsNeeded)) {
            $this->modelsNeeded[$modelNeeded] = $data;
          }
        }
      }
    }
    return $relatedTo;
  }
  public function getRelationOptions() {
    if (isset($this->relationOptions)) return $this->relationOptions;
    return [];
  }
  public function getKeyField () {
    if ($this->keyField) return $this->keyField;
    // else if ($this->fullName) return 'name';
    else if ($this->name) return 'name';
    // else if ($this->description) return 'description';
    else return 'id';
  }
  // Quasar Option Fields
  public function getLabelAttribute() {
    $field = $this->getKeyField();
    return $this->$field;
  }
  public function getValueAttribute() {
      return $this->id;
  }
  public function formRules() {
    $modelName = '\\' . get_class($this);
    $model = new QStore($this->get_short_class(get_class($this)));
    return $model->getChildRules($modelName);
  }

  // HELPERS
  public function get_short_class($obj){
    return (new \ReflectionClass($obj))->getShortName();
  }
  public function layoutComposer($formFields){
    foreach ($this->getQuasarNewFormLayout() as $stepKey => $step) {
      foreach ($step['fields'] as $rowKey => $row) {
        foreach ($row as $fieldKey => $field) {
          // dd($step['fields'][$row][$field]);
          // dd($this->quasarFormNewLayout[$step]['fields'][$row][$field]);
          if (array_key_exists($field,$this->quasarFormFields)) {
            $this->quasarFormNewLayout[$stepKey]['fields'][$rowKey][$field] = $formFields[$field];
          }
          unset($this->quasarFormNewLayout[$stepKey]['fields'][$rowKey][$fieldKey]);
        }
      }
    }
    if (count($this->getQuasarUpdateFormLayout())) {
      foreach ($this->quasarFormUpdateLayout as $stepKey => $step) {
        foreach ($step['fields'] as $rowKey => $row) {
          foreach ($row as $fieldKey => $field) {
            // dd($step['fields'][$row][$field]);
            // dd($this->quasarFormNewLayout[$step]['fields'][$row][$field]);
            if (array_key_exists($field,$this->quasarFormFields)) {
              $this->quasarFormUpdateLayout[$stepKey]['fields'][$rowKey][$field] = $formFields[$field];
            }
            unset($this->quasarFormUpdateLayout[$stepKey]['fields'][$rowKey][$fieldKey]);
          }
        }
      }
    }
  }
  public function formTypeBuilder($type, $field=null) {
    if (array_key_exists('default', $type)) {
        $default = $type['default'];
    } else {
      $default=[];
    }
    $scoped = array_key_exists('scope', $type);
    if (array_key_exists('name', $type)) {
      if ($type['name'] === 'select') {
        if (!in_array($type['model'], $this->appModels)) {
          $this->modelsNeeded[$type['model']] = [
            'scoped' => $scoped,
            'refresh' => false,
            'cache' => false,
            'where' => false
          ];
        }
      } else if ($type['name'] === 'enum') {
        $type['array'] = $this->getPossibleEnumValues($field);
        $quasarArray = [];
        foreach ($type['array'] as $value) {
          $temp = ['value' => $value, 'label' => (string) $value];
          $quasarArray[] = $temp;
        }
        $type['array'] = $quasarArray;
      } else if ($type['name'] === 'array') {
        $quasarArray = [];
        foreach ($type['array'] as $value) {
          $temp = ['value' => $value, 'label' => (string) $value];
          $quasarArray[] = $temp;
        }
        $type['array'] = $quasarArray;
      }
    }
    $return = [
        'name' => array_key_exists('name', $type) ? $type['name'] : 'inputText',
        'thumbnail' => array_key_exists('thumbnail', $type) ? $type['thumbnail'] : false,
        'array' => array_key_exists('array', $type) ? $type['array'] : null,
        // 'array' => array_key_exists('array', $type) ? $quasarArray : null,
        'filterKey' => array_key_exists('filterKey', $type) ? $type['filterKey'] : null,
        'hasFamily' => array_key_exists('hasFamily', $type) ? $type['hasFamily'] : false,
        'model' => array_key_exists('model', $type) ? $type['model'] : null,
        'text' => array_key_exists('text', $type) ? $type['text'] : null,
        'value' => array_key_exists('value', $type) ? $type['value'] : null,
        'default' => [
            'value' => array_key_exists('value', $default) ? $default['value'] : null,
            'text' => array_key_exists('text', $default) ? $default['text'] : 'Seleccione',
            'disabled' => array_key_exists('disabled', $default) ? $default['disabled'] : false,
        ],
    ];
    // if ($return['name'] === 'file') {
    //   $return['public'] = array_key_exists('public', $type) ? $type['public'] : false;
    //   $return['permissions'] = array_key_exists('permissions', $type) ? $type['permissions'] : '740';
    // }
    return $return;
  }
  public function getPossibleEnumValues($name){
    // $instance = new static; // create an instance of the model to be able to get the table name
    $type = DB::select( DB::raw('SHOW COLUMNS FROM '.$this->getTable().' WHERE Field = "'.$name.'"') )[0]->Type;
    preg_match('/^enum\((.*)\)$/', $type, $matches);
    $enum = array();
    foreach(explode(',', $matches[1]) as $value){
        $v = trim( $value, "'" );
        $enum[] = $v;
    }
    return $enum;
  }
}