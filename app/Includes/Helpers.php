<?php
use Illuminate\Support\Facades\Auth;
use App\Message;
use App\Order;
use App\Weight;
use App\Setting;

if(!function_exists('admin_url')) {
    function admin_url($url) {
        return url('admin/'.$url);
    }
}

if(!function_exists('customer_url')) {
    function customer_url($url) {
        return url('customer/'.$url);
    }
}
if(!function_exists('success')) {
    function success($msg,$action) {
        return session()->flash('message',$msg.' Successfully '.$action);
    }
}
if(!function_exists('failure')) {
    function failure($msg,$action) {
        return session()->flash('message','Unable to '.$action.' the '.$msg);
    }
}

function sendNotificationTransit(Order $order) {
    $message                    = new Message();
    $message->sender_id         = auth()->id();
    $message->sender_email      = auth()->user()->email;
    $message->recipient_id      = $order->user_id;
    $message->recipient_email   = $order->email;
    $message->subject           = "Order Ready to ship";
    $message->body_html         = "Your order is ready to ship and will be delivered on ".date('d M Y',strtotime($order->shipping_date));
    $message->body_text         = "Your order is ready to ship and will be delivered on ".date('d M Y',strtotime($order->shipping_date));
    $message->save();
}
function storeQuantity($qty)
{
    $weight=Weight::where('base',1)->first();
    $storeqty=$qty*$weight->value;
    return($storeqty); 
}
function getQuantity($qty)
{
    $weight=Weight::where('base',1)->first();
    $getqty=$qty/$weight->value;
    return(round($getqty,2)); 
}

function defaultWeight()
{
    if($weight=Weight::where('base',1)->first())
        return($weight->value);
        
    return false;
}
function getWeight($qty)
    {
        $weight=Weight::where('base',1)->first();
        $getqty=$qty/$weight->value;
        return(round($getqty,2)); 
    }
function defWeight()
{
    if($weight=Weight::where('base',1)->first())
        return($weight->code);
        
    return false;
}
function storeRate($rate)
{
    $weight=Weight::where('base',1)->first();
    $storerate=$rate/$weight->value;
    return($storerate);
}
function getRate($rate)
{
    $weight=Weight::where('base',1)->first();
    $getrate=$rate*$weight->value;
    return(round($getrate,2));
}

function getCustomerTypes() {
    return DB::table('customer_types')->orderBy('name','ASC')->get();
}

function getProvinces() {
    return DB::table('provinces')->orderBy('name','ASC')->get();
}

function getPaymentTerms() {
    return DB::Table('payment_terms')->get();
}

function getPaymentMethods() {
    return DB::table('payment_methods')->get();
}

function showPrice($price) {
    return '$'.number_format($price,2);
}
function getTax()
{
    $tax=Setting::first()->tax;
    return($tax);
}