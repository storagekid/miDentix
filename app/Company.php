<?php

namespace App;


class Company extends Qmodel
{

    public static function boot()
  {
    parent::boot();
      Company::saving(function () {
        Cache::forget('companies');
      });
      Company::saved(function () {
        Cache::forget('companies');
      });
      Company::creating(function () {
        Cache::forget('companies');
      });
      Company::created(function () {
        Cache::forget('companies');
      });
      Company::updated(function () {
        Cache::forget('companies');
      });
      Company::updating(function () {
        Cache::forget('companies');
      });
      Company::deleted(function () {
        Cache::forget('companies');
      });
      Company::deleting(function () {
        Cache::forget('companies');
      });
  }

    protected $with = ['stores'];

    // Quasar DATA

    protected $quasarFormNewLayout = [
        [
            'title' => 'Información',
            'subtitle' => 'General',
            'fields' => [
                ['name','type','description','CIF']
            ],
        ],
    ];
    protected $quasarFormFields = [
        'name' => [
            'label' =>'Nombre',
        ],
        'type' => [
            'label' =>'Tipo',
            'type' => [
                'name' =>'array',
                'array' => ['Matrix', 'Sister', 'Subsidiary', 'Provider', 'Client'],
                'default' => [
                    'value' => null,
                    'text' => 'Selecciona un Tipo',
                    'disabled' => true,
                ],
            ],
        ],
        'description' => [
            'label' =>'Descripción',
        ],
        'CIF' => [
          'label' =>'CIF',
        ],
    ];
    protected $listFields = [
        'left' => [],
        'main' => [
            'name' => ['text'],
        ],
        'right' => [
            'description' => ['text'],
        ],
    ];
    protected $keyField = 'name';
    // END Quasar DATA

    public function stores() {
        return $this->hasMany(Store::class);
    }
}
