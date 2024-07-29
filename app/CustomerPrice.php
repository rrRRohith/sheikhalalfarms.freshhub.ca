<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerPrice extends Model
{
    protected $table = 'customer_price';
    
     public function customer()
     {
         return $this->hasMany('App\User','customer_type');
     }
}
