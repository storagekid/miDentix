<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShoppingBag extends Model
{
    protected $appends = ['itemQuantity'];

    public function orders() 
    {
        return $this->hasMany(Order::class);
    }
    public function getItemQuantityAttribute() {
        $qt = count($this->orders);
        return $qt;
    }
}
