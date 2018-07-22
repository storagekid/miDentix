<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Tableable;
use App\Traits\Formable;

class Provider extends Model
{

    use Tableable;
    use Formable;

    protected $fillable = [
        'name', 'email', 'address', 'phone', 'CIF'
    ];

    protected $tableColumns = [
        'name' => [
            'label' => 'Nombre'
        ], 
        'email' => [
            'label' => 'Email',
            'filtering' => ['search']
        ], 
        'address' => [
            'label' => 'Dirección'
        ], 
        'phone' => [
            'label' => 'Teléfono'
        ], 
        'CIF' => [
            'label' => 'CIF',
        ],
    ];

    protected $tableOptions = ['providers', ['show','edit','delete'], true, true];

        // Formable DATA

        protected $formFields = [
            'name' => [
                'label' =>'Nombre',
                'rules' =>['required','min:5','max:64'],
              ],
              'email' => [
                'label' =>'Email',
                'rules' =>['required','min:5','max:64'],
              ],
        ];
    
        protected $formModels = [];
    
        protected $formRelations = [
        ];
    
        // END Formable DATA

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function products() {
        return $this->belongsToMany(Stationary::class, 'product_providers', 'provider_id', 'product_id');
    }
}
