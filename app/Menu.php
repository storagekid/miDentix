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
        ],
        'menu_items_count' => [
            'label' => 'Items',
        ]
    ];
    // END Table Data
    protected $appends = ['shorted_items', 'label', 'value'];
    protected static $full = ['menu_items'];

    public function menu_items() {
        return $this->hasMany(MenuItem::class);
    }
    public function getShortedItemsAttribute() {
        return $this->menu_items()->where('parent_id', null)->with('groups')->orderBy('order')->get()->each->append('children');
    }
}
