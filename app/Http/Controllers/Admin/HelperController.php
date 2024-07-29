<?php

namespace App\Http\Controllers\Admin;

//use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Product;
use App\OrderItem;
use App\Setting;
use App\Weight;
class HelperController extends Controller
{
    public function defWeight() {

        return response()->json(['result'=>defWeight()]);
        
    }
    public function getWeight($id) {
        
        $item=OrderItem::find($id);
        $p=Product::find($item->product_id);
        if($item->price_by=='weight')
        {
            $rate=getRate($item->rate);
        }
        else
        {
            $rate=$item->rate;
        }
        return response()->json(['result'=>getWeight($item->weight),'rate'=>$rate,'weight'=>getWeight($p->weight),'qty'=>$p->qty]);
        
    }
    public function getWeightAndPrice($id)
    {
        $cid = $_REQUEST['cid'] ?? 0;

        $product=Product::with(['customer_price'=>function($q) use ($cid) {
            $q->where('customer_id',$cid)->where('status',1)->first();
        }])->where('id',$id)->first();

        $weight=getWeight($product->weight);

        if($product->price_by=='weight')
        {
            $price=getRate($product->customer_price->count() ? $product->customer_price->first()->price:$product->price);
        }
        else
        {
            $price= $product->customer_price->count() ? $product->customer_price->first()->price:$product->price;
        }
        return response()->json(['weight'=>$weight,'price'=>$price]);
    }
    public function getTax()
    {
        return response()->json(['result'=>getTax()]);
    }
    public function getdefValue()
    {
        $defvalue=Weight::where('base',1)->first()->value;
        return response()->json(['result'=>$defvalue]);
    }
}
