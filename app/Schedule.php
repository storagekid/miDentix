<?php

namespace App;

class Schedule extends Qmodel
{
    // TABLE
    protected $tableColumns = [
        'fullProfileName' => [
            'label' => 'Perfil',
            'filtering' => ['search']
        ],
        'fullClinicName' => [
            'label' => 'Clínica',
            'filtering' => ['search']
        ],
        'jobName' => [
            'label' => 'Puesto',
            'filtering' => ['search']
        ],
        'jobTypeName' => [
            'label' => 'Especialidad',
            'filtering' => ['search']
        ],
        'schedule' => [
            'label' => 'Horario',
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

    protected $formModels = ['countries','counties','states','clinics','jobs','jobTypes'];

	protected $fillable = [
        'profile_id', 'clinic_id', 'job_id', 'job_type_id', 'schedule'
    ];
    protected $appends = ['fullClinicName', 'jobName', 'jobTypeName'];
    protected $with = ['clinic', 'job', 'jobType'];
    protected $table = 'clinic_profile';

    public function profile() {
    	return $this->belongsTo(Profile::class);
    }
    public function clinic() {
        return $this->belongsTo(Clinic::class)->withTrashed();
    }
    public function job() {
        return $this->belongsTo(Job::class);
    }
    public function jobType() {
        return $this->belongsTo(JobType::class);
    }
    public function getJobNameAttribute() {
        return $this->job ? $this->job->name : null;
    }
    public function getJobTypeNameAttribute() {
        return $this->jobType ? $this->jobType->name : null;
    }
    // public function getCountryNameAttribute() {
    //     return $this->clinic ? $this->clinic->countryName : null;
    // }
    // public function getStateNameAttribute() {
    //     return $this->clinic ? $this->clinic->stateName : null;
    // }
    // public function getCountyNameAttribute() {
    //     return $this->clinic ? $this->clinic->countyName : null;
    // }
    public function getFullClinicNameAttribute() {
        return $this->clinic ? $this->clinic->fullName : null;
    }
    public function getFullProfileNameAttribute() {
        return $this->profile ? $this->profile->fullName : null;
    }
}
