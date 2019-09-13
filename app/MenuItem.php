<?php

namespace App;


class MenuItem extends Qmodel
{
    protected $fillable = ['name', 'to', 'icon', 'order', 'parent_id', 'menu_id'];
    protected $with = ['groups'];
    protected $appends = ['children', 'label', 'value'];
    protected static $full = ['menu', 'parent', 'children'];
    protected static $permissions = [
        'view' => ['*']
    ];
    // Quasar DATA
    protected $relatedTo = ['groups'];
    protected $quasarFormNewLayout = [
        [
            'title' => 'Información',
            'subtitle' => 'General',
            'fields' => [
                ['name', 'to', 'icon', 'order', 'menu_id', 'parent_id']
            ],
        ],
    ];
    protected $quasarFormUpdateLayout = [
        [
            'title' => 'Información',
            'subtitle' => 'General',
            'fields' => [
                ['name', 'to', 'icon', 'order', 'parent_id', 'menu_id']
            ],
        ],
        [
            'title' => 'Permisos',
            'subtitle' => 'General',
            'fields' => [],
            'relations' => ['groups']
        ]
    ];
    protected $quasarFormFields = [
        'name' => [
            'label' =>'Nombre',
        ],
        'to' => [
            'label' =>'Ruta',
        ],
        'icon' => [
            'label' =>'Icono (Material)',
        ],
        'order' => [
            'label' =>'Posición',
        ],
        'parent_id' => [
            'label' =>'Menu Superior',
            'type' => [
                'name' =>'select',
                'model' => 'menu_items',
                'hasFamily' => true,
                'text' =>  'name',
                'value' => 'id',
                'default' => [
                    'text' => 'Selecciona un Item Padre',
                ],
            ],
        ],
        'menu_id' => [
            'label' =>'Menu Superior',
            'type' => [
                'name' =>'select',
                'model' => 'menus',
                'text' =>  'name',
                'value' => 'id',
                'default' => [
                    'text' => 'Selecciona un Menu',
                ],
            ],
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
        'order' => [
            'label' => 'Posición',
        ],
        'to' => [
            'label' => 'Ruta',
        ],
        'icon' => [
            'label' => 'Icono (Material)',
        ],
        'parent.name' => [
            'label' => 'Padre',
        ],
        'children' => [
            'label' => 'Hijos',
        ],
        'menu.name' => [
            'label' => 'Menu',
        ],
        'groups' => [
            'label' => 'Permisos',
        ]
    ];
    protected $tableOptions = [['show', 'edit', 'clone', 'delete'], true, true];
    // END Table Data

    public function menu() {
        return $this->belongsTo(Menu::class);
    }
    public function parent() {
        return $this->belongsTo(MenuItem::class, 'parent_id');
    }
    public function children() {
        return $this->hasMany(MenuItem::class, 'parent_id');
    }
    public function groups() {
        return $this->belongsToMany(Group::class, 'menu_item_groups');
    }
    public static function getSortedMenu () {
        $model = static::where('parent_id', null)->with('children')->orderBy('order')->get();
        // foreach ($model as $menuItem) {
        //     if (!$menuItem['parent']) {
        //         $level = 1;
        //     } else {
        //         $level = 2;
        //         $item = $menuItem['parent'];
        //         while ($item !== null) {
        //             $level++;
        //             $item = $item['parent'];
        //         }
        //     }
        //     $menuItem['level'] = $level;
        // }
        // $sortedMenu = $model->sortByDesc(['level', 'order']);
        // $groupedMenu = $sortedMenu->groupBy(['level', 'order']);
        return $model;
    }
    public function getChildrenAttribute() {
        if (auth()->user()->isRoot()) return $this->children()->get();
        $userGroups = collect(auth()->user()->groupsInfo)->keys()->toArray();
        $children = $this->children()->get();
        $defChildren = [];
        foreach ($children as $child) {
            $childGroups = $child->groups->pluck('name')->all();
            foreach ($childGroups as $group) if (in_array($group, $userGroups)) $defChildren[] = $child;
        }
        return $defChildren;
    }
}
