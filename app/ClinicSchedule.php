<?php

namespace App;

use App\Printers\PersonalTagsPrinter;

class ClinicSchedule extends Qmodel
{
    protected $fillable = [
        'clinic_profile_id', 'job_id', 'job_type_id', 'schedule'
    ];
    protected $casts = [
        'schedule' => 'array',
    ];
    // protected $appends = ['clinic_id', 'clinicFullName', 'job_name', 'job_type_name'];
    // protected $with = ['clinic_profile', 'job', 'job_type'];
    protected static $permissions = [
        'view' => [
          'Marketing' => ['*'],
        ]
    ];
    // Quasar DATA
    protected $quasarFormNewLayout = [
        [
            'title' => 'Horarios',
            'fields' => [
              ['clinic_profile_id', 'job_id', 'job_type_id', 'schedule']
            ],
        ],
    ];
    protected $quasarFormFields = [
        'clinic_profile_id' => [
            'label' =>'Clínica',
            'type' => [
                'name' =>'selectFromModel',
                'model' => 'clinic_profiles',
                'text' =>  'name',
                'value' => 'id',
                'default' => [
                'text' => 'Selecciona una de tus Clínicas',
                ],
            ],
        ],
        'job_id' => [
            'label' =>'Puesto',
            'type' => [
                'name' =>'select',
                'model' => 'jobs',
                'text' =>  'name',
                'value' => 'id',
                'default' => [
                    'text' => 'Selecciona un Puesto',
                ],
            ],
        ],
        'job_type_id' => [
            'label' =>'Especialidad',
            'type' => [
                'name' =>'select',
                'model' => 'job_types',
                'text' =>  'name',
                'value' => 'id',
                'default' => [
                    'text' => 'Selecciona una especialidad',
                ],
            ],
        ],
        'schedule' => [
        'label' =>'Horario',
        ]
    ];
    protected $listFields = [
        'left' => [
            'clinicFullName' => ['chips'],
        ],
        'main' => [
            'job_name' => ['text'],
            'job_type_name' => ['text'],
        ],
        'right' => [],
    ];
    protected $keyField = 'job_type_name';
    // END Quasar DATA

    public function clinic_profile() {
        return $this->belongsTo(ClinicProfile::class);
    }
    public function job() {
        return $this->belongsTo(Job::class);
    }
    public function job_type() {
        return $this->belongsTo(JobType::class);
    }
    public function getClinicIdAttribute() {
        // return $this->job ? $this->job->name : 'undefined';
        return $this->clinicProfile->clinic_id;
    }
    public function getClinicFullNameAttribute() {
        return $this->clinicProfile->clinic->fullName;
    }
    public function getJobNameAttribute() {
        // return $this->job ? $this->job->name : 'undefined';
        return $this->job->name;
    }
    public function getJobTypeNameAttribute() {
        // return $this->job_type ? $this->job_type->name : 'undefined';
        return $this->job_type->name;
    }
}
