<?php

namespace App;


class Group extends Qmodel
{
    protected static $permissions = [
        'view' => ['*']
    ];
    // Quasar DATA

    protected $quasarFormNewLayout = [
        [
            'title' => 'Información',
            'subtitle' => 'General',
            'fields' => [
                ['name']
            ],
        ],
    ];
    protected $quasarFormUpdateLayout = [
        [
            'title' => 'Información',
            'subtitle' => 'General',
            'fields' => [
                ['name']
            ],
        ]
    ];
    protected $quasarFormFields = [
        'name' => [
            'label' => 'Nombre',
        ],
    ];
    protected $listFields = [
        'left' => [],
        'main' => [
            'name' => ['text'],
        ],
        'right' => [],
    ];
    protected $keyField = 'name';
    // END Quasar DATA

    // Tableable DATA
    protected $tableColumns = [
        'name' => [
            'label' => 'Nombre'
        ],
        'users_count' => [
            'label' => 'Nº Usuarios'
        ]
    ];
    // END Tableable Data

    public function user() {
    	return $this->hasMany(User::class);
    }
    public function users() {
    	return $this->belongsToMany(User::class, 'group_users');
    }
    public function menu_items() {
    	return $this->belongsToMany(MenuItem::class, 'menu_item_groups');
    }
}
