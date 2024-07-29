<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    public function warehouse()
    {
        return $this->belongsTo('App\Warehouse');
    }
    public function product()
    {
        return $this->belongsTo('App\Product');
    } 
}
