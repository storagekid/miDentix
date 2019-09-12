<?php

namespace App;

class StoreProfile extends Qmodel
{
    protected $fillable = [
        'profile_id', 'store_id'
    ];
    protected $with = ['store'];
    protected $appends = ['fullName', 'label', 'value'];
    protected $table = 'store_profiles';
    protected static $permissions = [
        'view' => [
            'Marketing' => ['*'],
        ]
    ];
    // Quasar DATA
    protected $quasarFormNewLayout = [
        [
            'title' => 'Información',
            'subtitle' => 'General',
            'fields' => [
                ['store_id', 'profile_id']
            ],
        ],
    ];
    protected $quasarFormFields = [
        'store_id' => [
            'label' =>'Store',
            'type' => [
                'name' =>'select',
                'model' => 'stores',
                'text' =>  'name',
                'value' => 'id',
                'filterKey' => 'store_id',
                'default' => [
                'text' => 'Selecciona una de tus Oficinas',
                ],
            ],
            ],
            'profile_id' => [
            'label' =>'Profile',
            'type' => [
                'name' =>'select',
                'model' => 'profiles',
                'text' =>  'name',
                'value' => 'id',
                'filterKey' => 'profile_id',
                'default' => [
                'text' => 'Selecciona un Perfil',
                ],
            ],
        ]
    ];
    protected $listFields = [
        'left' => [],
        'main' => [
            'fullName' => ['text']
        ],
        'right' => [],
    ];
    protected $keyField = 'fullName';
    // END Quasar DATA

    public function profile() {
    	return $this->belongsTo(Profile::class, 'profile_id');
    }
    public function store() {
        return $this->belongsTo(Store::class);
    }
    public function schedules() {
    	return $this->hasMany(StoreSchedule::class);
    }
    public function getCountryNameAttribute() {
        return $this->store ? $this->store->countryName : null;
    }
    public function getFullNameAttribute() {
        return $this->store ? $this->store->name : null;
    }
}
