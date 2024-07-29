<?php
use Illuminate\Support\Facades\Auth;
use App\Message;
use App\Order;

function admin($url)
{
    return url('admin/'.$url);
}


function storeWeight($qty)
{
    $weight=Weight::where('base',1)->first();
    $storeqty=$qty*$weight->value;
    return($storeqty); 
}

function getWeight($qty)
{
    $weight=Weight::where('base',1)->first();
    $getqty=$qty/$weight->value;
    return(round($getqty,2)); 
}

function defaultWeight()
{
    if($weight=Weight::where('base',1)->first())
        return($weight->value);
    else
        return false;
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

?>