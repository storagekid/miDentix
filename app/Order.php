<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Tableable;

class Order extends Model
{
    use Tableable;

    // Tableable DATA
    protected $tableColumns = [
        'itemName' => [
            'label' => 'Nombre'
        ], 
        'clinicName' => [
            'label' => 'Clínica',
            'filtering' => ['search']
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

    protected $tableOptions = [['show','edit','delete'], true, true];

    // END Tableable Data

    protected $appends = ['itemName', 'providerName', 'clinicName', 'userName'];

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
        return $this->belongsTo(User::class);
    }

    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }

    public function provider()
    {
        return $this->belongsTo(Provider::class);
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

    public function getUserNameAttribute()
    {
        return $this->user->profile->name . ' ' . $this->user->profile->lastname1;
    }
}
