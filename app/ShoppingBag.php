<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShoppingBag extends Model
{
    public function orders() 
    {
        return $this->hasMany(Order::class);
    }
}
