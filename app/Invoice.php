<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
class Invoice extends Model
{
    use Sortable;
    public $sortable = [
        'id',
        'invoice_number',
        'status',
        'created_at',
        'order_id',
        'sub_total',
        'tax',
        'grand_total',
        'due_date'
    ];
    public function order()
    {
        return $this->belongsTo('App\Order','order_id','id');
    }
    public function user()
    {
        return $this->belongsTo('App\User','customer_id','id');
    }
    public function item()
    {
        return $this->hasMany('App\OrderItem','order_id','order_id');
    }
}