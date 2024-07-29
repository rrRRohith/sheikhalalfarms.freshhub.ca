<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
class Order extends Model
{
    use Sortable;
    public $sortable = [
        'id',
        'status',
        'created_at',
        'order_date',
        'total_quantity',
        'shipping_date'
    ];
    public function item()
    {
        return $this->hasMany('App\OrderItem');
    }
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function driver()
    {
        return $this->belongsTo('App\User','driver_id','id');
    }
    public function salesrep()
    {
        return $this->belongsTo('App\User','sales_rep','id');
    }
    
    public function billing() {
        return $this->belongsTo('App\Address','billing_id');
    }
    
    public function delivery() {
        return $this->belongsTo('App\Address','delivery_id');
    }

    public function invoice() {
        return $this->hasOne('App\Invoice');
    }
    public function orderstatus(){
        return $this->belongsTo('App\OrderStatus');
        
    }
   
}
