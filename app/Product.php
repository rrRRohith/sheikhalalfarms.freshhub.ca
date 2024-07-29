<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Helper;

class Product extends Model
{
    use Sortable;
    public $sortable = [
        'id',
        'name',
        'sku',
        'weight',
        'price',
        'description',
        'status',
        'created_at',
    ];
    public function category()
    {
        return $this->belongsTo('App\Category');
    }
    public function inventory()
    {
        return $this->belongsTo('App\Inventory');
    }
    public function unit()
    {
        return $this->belongsTo('App\Unit','unit');
    }
    public function units()
    {
        return $this->belongsTo('App\Unit','unit');
    }
    
    public function orderitem()
    {
        return $this->hasMany('App\OrderItem','product_id','id');
    }
    public function getRateAttribute()
    {
        if($this->price_by=='quantity')
            return $this->price;
        else
            return Helper::defaultWeight() * $this->price;
    }

    public function customer_price() {
        return $this->hasMany('App\CustomerPrice','product_id');
    }
}
