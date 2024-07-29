<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    public function warehouse()
    {
        return $this->belongsTo('App\Warehouse');
    }
    public function product()
    {
        return $this->hasMany('App\InventoryProduct');
    }
}
