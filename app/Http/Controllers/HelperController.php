<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\OrderItem;
use App\Product;

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
        return response()->json(['result'=>getWeight($item->weight),'rate'=>$rate,'weight'=>getWeight($p->weight)]);
        
    }
    public function getWeightAndPrice($id)
    {
        $product=Product::find($id);
        $weight=getWeight($product->weight);
        if($product->price_by=='weight')
        {
            $price=getRate($product->price);
        }
        else
        {
            $price=$product->price;
        }
        return response()->json(['weight'=>$weight,'price'=>$price]);
    }
}
