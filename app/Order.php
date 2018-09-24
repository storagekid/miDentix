<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Tableable;
use App\Traits\Scope;

class Order extends Model
{
    use Tableable;
    use Scope;
    // Tableable DATA
    protected $tableColumns = [
        'itemName' => [
            'label' => 'Nombre'
        ], 
        'clinicName' => [
            'label' => 'Clínica',
            'filtering' => ['search']
        ], 
        'profileName' => [
            'label' => 'Personalizado para'
        ],
        'details' => [
            'label' => 'Detalles'
        ],
        'userName' => [
            'label' => 'Realizado por'
        ],
        'providerName' => [
            'label' => 'Proveedor'
        ],
        'quantity' => [
            'label' => 'Cantidad'
        ],
        'urgent' => [
            'label' => 'Urgente',
            'boolean' => ['Sí','No'],
            'sorting' => ['integer'],
            'filtering' => [
                'off',
                'boolean' => ['No','Sí']
            ],
        ],  
        'created_at' => [
            'label' => 'Fecha de Pedido',
        ], 
        'updated_at' => [
            'label' => 'Última actualización',
        ], 
    ];

    protected $tableOptions = [['show','edit','delete'], true, false];

    // END Tableable Data

    // protected $appends = ['itemName', 'providerName', 'clinicName', 'userName'];

    // protected $with = ['clinic', 'provider', 'user', 'orderable'];

    protected $appends = ['clinicName', 'providerName', 'userName', 'itemName'];

    protected $with = ['clinic', 'provider', 'user', 'orderable'];

    public function orderable()
    {
        return $this->morphTo();
    }

    public function shoppingBag()
    {
        return $this->belongsTo(ShoppingBag::class);
    }

    public function user()
    {
        return $this->belongsTo(Profile::class);
    }

    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }
    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    // Attributes Setters

    public function getClinicNameAttribute()
    {
        return $this->clinic->fullName;
    }

    public function getItemNameAttribute()
    {
        return $this->orderable->description;
    }

    public function getProviderNameAttribute()
    {
        return $this->provider->name;
    }

    public function getProfileNameAttribute()
    {
        if ($this->profile) {
            return $this->profile->fullName;
        } else {
            return '-';
        }
    }

    public function getUserNameAttribute()
    {
        return $this->user ? $this->user->name . ' ' . $this->user->lastname1 : 'Deleted';
        // return $this->user ? $this->user->profile->name . ' ' . $this->user->profile->lastname1 : 'Deleted';
    }
}
