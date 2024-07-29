<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerType extends Model
{
     public function customer()
     {
         return $this->hasMany('App\User','customer_type');
     }
}
