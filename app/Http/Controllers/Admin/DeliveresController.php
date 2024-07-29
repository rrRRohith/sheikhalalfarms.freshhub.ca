<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Customer;
use App\OrderItem;
use App\Invoice;
use App\Stock;
use App\Order;
use PDF;
class PrintController extends Controller
{
    public function printInvoice($id){
        $order=Order::where('id',$id)->first();
        $customer=User::where('id',$order->user_id)->first() or abort(404);
        $orderitems=OrderItem::join('products','products.id','=','order_items.product_id')->where('order_items.order_id',$id)->get();
        $invoice=Invoice::with(['order'=>function($query){$query->with(['item'=>function($q){$q->with('product');}]);},'user'])->where('id',$id)->first();
        $stocks=Stock::get();
        $submenu="Invoice";
        $title="Order";
        return view('admin.order.printinvoice', compact('order','orderitems','customer','stocks','submenu','title','invoice'));
       
    }
       public function generatePDF($id){
        
        $order=Order::where('id',$id)->first();
        $customer=User::where('id',$order->user_id)->first() or abort(404);
        $orderitems=OrderItem::join('products','products.id','=','order_items.product_id')->where('order_items.order_id',$id)->get();
        $invoice=Invoice::with(['order'=>function($query){$query->with(['item'=>function($q){$q->with('product');}]);},'user'])->where('id',$id)->first();
        $stocks=Stock::get();
        $submenu="Invoice";
        $title="Order";
        $pdf = PDF::loadView('admin.order.generateInvoicePDF', compact('order','orderitems','customer','stocks','submenu','title','invoice'));
        return $pdf->download('pdf_file.pdf');

    }
}