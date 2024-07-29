<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Runsheet extends Model
{
    public function order()
    {
        return $this->belongsTo('App\Order');
    }
    public function driver()
    {
        return $this->belongsTo('App\User','driver_id','id');
    }
    public function routes()
    {
        return $this->belongsTo('App\Route','route','id');
    }
}
