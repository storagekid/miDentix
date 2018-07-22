<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
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
