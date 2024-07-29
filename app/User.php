<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Kyslik\ColumnSortable\Sortable;
class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;
    use Sortable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $sortable = [
        'id',
        'firstname',
        'lastname',
        'business_name',
        'address',
        'email',
        'city',
        'status',
        'created_at',
    ];

    protected $fillable = [
        'username', 'email', 'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
     public function types(){
        return $this->belongsTo('App\CustomerType','customer_type');
    }
    public function paymentterm()
    {
        return $this->belongsTo('App\PaymentTerm','payment_term','id');
    }
    public function order(){
        return $this->hasMany('App\Order','user_id');
    }
    public function driverorder()
    {
        return $this->hasMany('App\Order','driver_id');
    }
    public function invoice(){
        return $this->hasMany('App\Invoice','customer_id');
    }
     public function paymentmethod()
    {
        return $this->belongsTo('App\PaymentMethod','payment_method','id');
    }
   
}
