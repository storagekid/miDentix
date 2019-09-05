<?php

namespace App;

class Clinic_Profile extends Qmodel
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

    // FORM

    protected $formFields = [
        'country_id' => [
            'label' => 'País',
            'name' => 'country_id',
            'value' => null,
            'dontRecord' => true,
            'affects' => 'state_id',
            'type' => [
              'name' => 'select',
              'model' => 'countries',
              'text' => 'name',
              'value' => 'id',
              'default' => [
                'value' => null,
                'text' => 'Selecciona un País',
                'disabled' => true,
              ],
            ],
            'batch' => true,
          ],
          'state_id' => [
            'label' => 'CCAA',
            'rules' => [],
            'name' => 'state_id',
            'value' => null,
            'dontRecord' => true,
            'dependsOn' => 'country_id',
            'affects' => 'county_id',
            'type' => [
              'name' => 'select',
              'model' => 'states',
              'text' => 'name',
              'value' => 'id',
              'default' => [
                'value' => null,
                'text' => 'Selecciona una CCAA',
                'disabled' => true,
              ],
            ],
            'batch' => true,
          ],
          'county_id' => [
            'label' => 'Provincia',
            'rules' => [],
            'name' => 'county_id',
            'value' => null,
            'dependsOn' => 'state_id',
            'affects' => 'clinic_id',
            'dontRecord' => true,
            'type' => [
              'name' => 'select',
              'model' => 'counties',
              'text' => 'name',
              'value' => 'id',
              'default' => [
                'value' => null,
                'text' => 'Selecciona una Provincia',
                'disabled' => true,
              ],
            ],
            'batch' => true,
          ],
          'clinic_id' => [
            'label' => 'Clínica',
            'rules' => [],
            'name' => 'clinic_id',
            'value' => null,
            'dontRecord' => false,
            'dependsOn' => 'county_id',
            'type' => [
              'name' => 'select',
              'model' => 'clinics',
              'text' => 'fullName',
              'value' => 'id',
              'default' => [
                'value' => null,
                'text' => 'Selecciona una Clínica',
                'disabled' => true,
              ],
            ],
            'batch' => true,
          ],
    ];

    // protected $formModels = ['countries','counties','states','clinics'];

	protected $fillable = [
        'profile_id', 'clinic_id'
    ];
    protected $appends = ['fullName', 'countyName', 'stateName', 'countryName'];
    protected $table = 'clinic_profiles';

    public function profile() {
    	return $this->belongsTo(Profile::class);
    }
    public function clinic() {
        return $this->belongsTo(Clinic::class)->withTrashed();
    }
    public function schedule() {
    	return \App\Schedule::where([
            'profile_id' => $this->profile_id,
            'clinic_id' => $this->clinic_id
        ])->get();
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
