<?php

namespace App;

class ShoppingBag extends Qmodel
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
