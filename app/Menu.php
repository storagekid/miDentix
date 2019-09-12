<?php

namespace App;

class Menu extends Qmodel
{
    protected $fillable = ['name'];
    protected static $permissions = [
        'view' => ['*']
    ];
    
    // Quasar DATA
    protected $relatedTo = ['menu_items'];
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
        ],
        [
            'title' => 'Items',
            'icon' => 'photo_album',
            'fields' => [],
            'relations' => ['menu_items']
        ]
    ];
    protected $quasarFormFields = [
        'name' => [
            'label' =>'Nombre',
        ]
    ];
    protected $listFields = [
        'left' => [],
        'main' => [
            'name' => ['text'],
        ]
    ];
    protected $keyField = 'name';
    // END Quasar DATA

    // Tableable DATA
    protected $tableColumns = [
        'name' => [
            'label' => 'Nombre',
            'filtering' => ['search'],
        ],
        'menu_items_count' => [
            'label' => 'Items',
            'filtering' => ['select' => 'clinics'],
        ]
    ];
    protected $tableOptions = [['show', 'edit', 'clone', 'delete'], true, true];
    // END Table Data
    protected $appends = ['shorted_items'];
    protected static $full = ['menu_items'];

    public function menu_items() {
        return $this->hasMany(MenuItem::class);
    }
    public function getShortedItemsAttribute() {
        return $this->menu_items()->where('parent_id', null)->orderBy('order')->get();
    }
}
