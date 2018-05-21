<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    protected $fillable = [
        'name', 'email', 'address', 'phone', 'CIF'
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
