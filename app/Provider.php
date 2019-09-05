<?php

namespace App;

class Provider extends Qmodel
{

    protected $fillable = [
        'name', 'email', 'address', 'phone', 'CIF'
    ];

    protected $tableColumns = [
        'name' => [
            'label' => 'Nombre'
        ], 
        'email' => [
            'label' => 'Email',
            'filtering' => ['search']
        ], 
        'address' => [
            'label' => 'Dirección'
        ], 
        'phone' => [
            'label' => 'Teléfono'
        ], 
        'CIF' => [
            'label' => 'CIF',
        ],
    ];

    protected $tableOptions = [['show','edit','delete'], true, true];

    // Formable DATA

    protected $formFields = [
        'name' => [
            'label' =>'Nombre',
            'rules' =>['required','min:5','max:64'],
            ],
            'email' => [
            'label' =>'Email',
            'rules' =>['required','min:5','max:64'],
            ], 
            'address' => [
                'label' => 'Dirección',
                'rules' =>['min:5','max:255'],
            ], 
            'phone' => [
                'label' => 'Teléfono',
                'rules' =>['required','min:9','max:12'],
                'batch' => true,
            ], 
            'CIF' => [
                'label' => 'CIF',
                'rules' =>['required','min:8','max:10'],
            ],
    ];

    protected $formModels = [];

    protected $formRelations = [
    ];

    // END Formable DATA

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function products() {
        return $this->belongsToMany(Stationary::class, 'product_providers', 'provider_id', 'product_id');
    }
}
