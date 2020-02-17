<?php

namespace App;


class MenuItemGroup extends Qmodel
{
    protected $fillable = ['menu_item_id', 'group_id'];
    protected $with = ['group', 'menu_item'];
    protected $appends = ['full_name'];
    protected static $full = ['group', 'menu_item'];
    protected static $permissions = [
        'view' => ['*']
    ];
    // Quasar DATA
    protected $quasarFormNewLayout = [
        [
            'title' => 'Información',
            'subtitle' => 'General',
            'fields' => [
                ['menu_item_id', 'group_id']
            ],
        ],
    ];
    protected $quasarFormUpdateLayout = [
        [
            'title' => 'Información',
            'subtitle' => 'General',
            'fields' => [
                ['menu_item_id', 'group_id']
            ],
        ]
    ];
    protected $quasarFormFields = [
        'group_id' => [
            'label' =>'Grupo',
            'type' => [
                'name' =>'select',
                'model' => 'groups',
                'text' =>  'name',
                'value' => 'id',
                'default' => [
                    'text' => 'Selecciona un Grupo',
                ],
            ],
        ],
        'menu_item_id' => [
            'label' =>'Menu Item',
            'type' => [
                'name' =>'select',
                'model' => 'menu_items',
                'text' =>  'name',
                'value' => 'id',
                'default' => [
                    'text' => 'Selecciona un Item de Menú',
                ],
            ],
        ],
    ];
    protected $listFields = [
        'left' => [],
        'main' => [
            'full_name' => ['text'],
        ]
    ];
    protected $keyField = 'full_name';
    // END Quasar DATA

    // Tableable DATA
    protected $tableColumns = [
        'group.name' => [
            'label' => 'Grupo',
        ],
        'menu_item.name' => [
            'label' => 'Item de Menú',
        ],
    ];
    // END Table Data

    public function group() {
        return $this->belongsTo(Group::class);
    }
    public function menu_item() {
        return $this->belongsTo(MenuItem::class);
    }
    public function getGroupNameAttribute() {
        return $this->group->name;
    }
    public function getMenuItemNameAttribute() {
        return $this->menu_item->name;
    }
    public function getFullNameAttribute () {
        return $this->group_name . '-' . $this->menu_item_name;
    }
}
