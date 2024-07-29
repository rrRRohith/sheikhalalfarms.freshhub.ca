<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    public function stock()
    {
        return $this->hasOne('App\Stock','product_id','product_id');
    }
    public function product()
    {
        return $this->belongsTo('App\Product');
    }
    public function order(){
        return $this->belongsTo('App\Order');
    }
    public function invoice(){
        return $this->belongsTo('App\Invoice','order_id','order_id');
    }
    
}
