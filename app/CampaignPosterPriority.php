<?php

namespace App;

class CampaignPosterPriority extends Qmodel
{

    protected $fillable = ['campaign_id', 'poster_model_id', 'priority'];
    protected $appends = ['poster_model_name'];
    protected $with = ['poster'];

    // Quasar DATA
    protected $onRelationMode = ['table'];
    
    protected $quasarFormNewLayout = [
        [
            'title' => 'Información',
            'subtitle' => 'General',
            'fields' => [
                ['campaign_id', 'poster_model_id', 'priority']
            ],
        ],
    ];
    protected $quasarFormUpdateLayout = [
        [
            'title' => 'Información',
            'subtitle' => 'General',
            'fields' => [
                ['campaign_id', 'poster_model_id', 'priority']
            ],
        ]
    ];

    protected $quasarFormFields = [
        'campaign_id' => [
            'label' =>'Campaign',
            'type' => [
                'name' =>'select',
                'model' => 'campaigns',
                'default' => [
                    'text' => 'Selecciona una Campaña',
                ],
            ],
        ],
        'poster_model_id' => [
            'label' =>'Poster Model',
            'type' => [
                'name' =>'select',
                'model' => 'poster_models',
                'default' => [
                    'text' => 'Selecciona un Modelo',
                ],
            ],
        ],
        'priority' => [
            'label' =>'Priority',
            'type' => [
                'name' =>'arrayUnique',
                'array' => [1,2,3,4,5,6,7,8],
                'default' => [
                    'text' => 'Selecciona una Prioridad',
                ],
            ],
        ],
    ];
    protected $listFields = [
        'mode' => 'list',
        'draggable' => 'priority',
        'left' => [
            'priority' => ['chips']
        ],
        'main' => [
            'poster_model_name' => ['text'],
        ],
        'right' => [],
    ];
    protected $keyField = 'poster_model_name';
    // END Quasar DATA

    public function poster () {
        return $this->belongsTo(PosterModel::class, 'poster_model_id');
    }
    public function getPosterModelNameAttribute() {
        return $this->poster->name;
    }
}
