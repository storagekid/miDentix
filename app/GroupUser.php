<?php

namespace App;

class GroupUser extends Qmodel
{
    protected $fillable = [
        'user_id', 'group_id', 'role'
    ];
    protected $appends = ['groupName'];

    // Quasar DATA

    protected $quasarFormNewLayout = [
        [
            'title' => 'Información',
            'subtitle' => 'General',
            'fields' => [
                ['group_id', 'user_id', 'role']
            ],
        ],
    ];
    protected $quasarFormFields = [
        'group_id' => [
            'label' =>'Group',
            'type' => [
                'name' =>'select',
                'model' => 'groups',
                'text' =>  'name',
                'value' => 'id',
                'filterKey' => 'group_id',
                'default' => [
                    'text' => 'Selecciona un Grupo',
                ],
            ],
        ],
        'user_id' => [
            'label' =>'User',
            'type' => [
                'name' =>'select',
                'model' => 'users',
                'text' =>  'name',
                'value' => 'id',
                'filterKey' => 'user_id',
                'default' => [
                'text' => 'Selecciona un Usuario',
                ],
            ],
        ],
        'role' => [
            'label' =>'Role',
            'type' => [
                'name' =>'array',
                'array' => ['guest', 'user', 'editor', 'administrator', 'overseeker', 'root'],
                'default' => [
                    'text' => 'Selecciona un Role',
                ],
            ],
        ]
    ];
    protected $listFields = [
        'left' => [
            'groupName' => ['chips'],
        ],
        'main' => [
            'role' => ['text']
        ],
        'right' => [],
    ];
    protected $keyField = 'role';
    // END Quasar DATA

    public function user() {
    	return $this->belongsTo(User::class, 'user_id');
    }
    public function group() {
    	return $this->belongsTo(Group::class, 'group_id');
    }
    public function getUserNameAttribute() {
        return $this->user ? $this->user->name : null;
    }
    public function getGroupNameAttribute() {
        return $this->group ? $this->group->name : null;
    }
}
