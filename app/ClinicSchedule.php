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
    protected $appends = ['key_name'];
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
            'key_name' => ['chips'],
        ],
        'main' => [
            'job_name' => ['text'],
            'job_type_name' => ['text'],
        ],
        'right' => [],
    ];
    protected $keyField = 'key_name';
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
        return $this->clinicProfile->clinic_id;
    }
    public function getClinicFullNameAttribute() {
        return $this->clinicProfile->clinic->fullName;
    }
    public function getJobNameAttribute() {
        return $this->job->name;
    }
    public function getJobTypeNameAttribute() {
        return $this->job_type->name;
    }
    public function getKeyNameAttribute() {
        return $this->clinic_profile->clinic->cleanName . ' - ' . $this->JobTypeName;
    }
}
