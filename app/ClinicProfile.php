<?php

namespace App;

use App\ClinicSchedule;

class ClinicProfile extends Qmodel
{
    // TABLE
    protected $tableColumns = [
        'fullName' => [
            'label' => 'Clínica',
            'filtering' => ['search']
        ],
        'countyName' => [
            'label' => 'Provincia',
            'filtering' => ['search']
        ],
        'stateName' => [
            'label' => 'CCAA',
            'filtering' => ['search']
        ],
        'countryName' => [
            'label' => 'País',
            'filtering' => ['search']
        ],
    ];

    protected $tableOptions = [['show','edit','delete'], true, true];  

    // Quasar DATA

    protected $quasarFormNewLayout = [
        [
            'title' => 'Información',
            'subtitle' => 'General',
            'fields' => [
                ['clinic_id', 'profile_id']
            ],
        ],
    ];
    protected $quasarFormFields = [
        'clinic_id' => [
            'label' =>'Clínica',
            'type' => [
              'name' =>'select',
              'model' => 'clinics',
              'text' =>  'name',
              'value' => 'id',
              'filterKey' => 'clinic_id',
              'default' => [
                'text' => 'Selecciona una Clínica',
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

    protected $fillable = [
        'profile_id', 'clinic_id'
    ];
    protected $with = ['clinic'];
    protected $appends = ['fullName', 'label', 'value'];
    protected $table = 'clinic_profiles';

    public function profile() {
    	return $this->belongsTo(Profile::class, 'profile_id');
    }
    public function clinic() {
        return $this->belongsTo(Clinic::class)->withTrashed();
    }
    public function schedules() {
    	return $this->hasMany(ClinicSchedule::class);
    }
    public function getCountryNameAttribute() {
        return $this->clinic ? $this->clinic->countryName : null;
    }
    public function getStateNameAttribute() {
        return $this->clinic ? $this->clinic->stateName : null;
    }
    public function getCountyNameAttribute() {
        return $this->clinic ? $this->clinic->countyName : null;
    }
    public function getFullNameAttribute() {
        return $this->clinic ? $this->clinic->fullName : null;
    }
}
