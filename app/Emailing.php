<?php

namespace App;

use App\Traits\Fileable;

class Emailing extends Qmodel
{
    use Fileable;
    
    protected $fillable = [
        'name', 'description', 'design', 'company_id', 'campaign_id', 'user_id', 'emailing_file_id', 'mirror_file_id'
    ];

    protected $quasarFormNewLayout = [
        [
            'title' => 'Información',
            'subtitle' => 'General',
            'fields' => [
                ['name', 'description', 'company_id', 'campaign_id']
            ],
        ],
    ];
    protected $quasarFormUpdateLayout = [
        [
            'title' => 'Información',
            'subtitle' => 'General',
            'fields' => [
                ['name', 'description', 'company_id', 'campaign_id']
            ],
        ]
    ];
    protected $quasarFormFields = [
        'name' => [
            'label' =>'Nombre',
        ],
        'description' => [
            'label' =>'Descripción',
        ],
        'design' => [
            'label' =>'Descripción',
        ],
        'user_id' => [
            'label' =>'Descripción',
        ],
        'campaign_id' => [
            'label' =>'Campaña',
            'type' => [
                'name' =>'select',
                'model' => 'campaigns',
                'default' => [
                    'text' => 'Selecciona una Campaña',
                ],
            ],
        ],
        'company_id' => [
            'label' =>'Company',
            'type' => [
                'name' =>'select',
                'model' => 'companies',
                'default' => [
                    'text' => 'Selecciona una Empresa',
                ],
            ],
        ],
        'emailing_file_id' => [
            'label' =>'Emailing File',
            'type' => [
                'name' => 'file',
                'thumbnail' => true,
                'public' => false,
                'permissions' => '740'
            ],
        ],
        'mirror_file_id' => [
            'label' =>'Mirror File',
            'type' => [
                'name' => 'file',
                'thumbnail' => true,
                'public' => false,
                'permissions' => '740'
            ],
        ],
    ];

    // Tableable DATA
    protected $tableColumns = [
        'name' => [
            'label' => 'Nombre',
        ],
        'description' => [
            'label' => 'Descripción',
        ],
        'company.label' => [
            'label' => 'Empresa',
        ],
        'campaign.label' => [
            'label' => 'Campaña',
        ],
        'emailing_file_id' => [
            'label' => 'Emailing AF',
            'type' => [
                'name' => 'file'
            ],
            'onGrid' => 'footer'
        ],
        'actions' => [
            'label' => 'Actions'
        ],
        'created_at' => [
          'label' => 'Creado',
        ],
        'updated_at' => [
            'label' => 'Modificado',
        ]
    ];
    // END Table Data

    public function getFileNames($field = 'emailing_file_id') {
        switch ($field) {
            case 'emailing_file_id':
                return $this->company->label . ' ' . $this->name . ' Emailing';
                break;
            case 'emailing_file_id':
                return $this->company->label . ' ' . $this->name . ' Mirror';
                break;
            default:
                abort(301, 'Campo de archivo erróneo');
                break;
        }
    }
    public function getFilePaths($field = 'emailing_file_id') {
        switch ($field) {
            case 'emailing_file_id':
                return 'emailings';
                break;
            case 'mirror_file_id':
                return 'emailings';
                break;
            default:
                abort(301, 'Campo de archivo erróneo');
                break;
        }
    }
}
