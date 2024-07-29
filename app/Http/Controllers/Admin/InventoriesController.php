<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\InventoryRequest;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Hash;
use App\Inventory;
use App\Product;
use App\Warehouse;
use App\InventoryProduct;
use App\Stock;
use App\User;
use DB;

class InventoriesController extends Controller
{

    public function index()
    {
        if(auth()->user()->cannot('Inventory View'))
        {
            return redirect('/');
        }
        
        $products = Product::get();
    
        $title="Inventories";
        $submenu = "Inventory";
        return view('admin.inventory.inventories',compact('submenu','products','title'));
    }
    
    public function defer(Request $request)
    {
        $key=$request->get('key');
        if($key !='')
        {
            $products=Product::where('name','like','%'.$key.'%')->orWhere('sku','like','%'.$key.'%')->get();
        }
        else
        {
            $products=Product::get();
        }
        return [
            'data' => ProductResource::collection($products),
        ];
    }
    
    public function create()
    {
        if(auth()->user()->cannot('Inventory Create'))
        {
        return redirect('/');
        }
       $product=Product::where('status',1)->get();
       $warehouses =Warehouse::where('status',1)->get();
        $submenu="Inventories";
          $title = "Inventories";
        return view('admin.inventory.Inventoriesadd',compact('submenu','product','warehouses','title'));
    }


    public function store(InventoryRequest $request)
    {
        
        $inventory = new Inventory();
        $inventory->warehouse_id      = $request->warehouse_id;
        $inventory->entered_by=auth()->user()->id;
        $inventory->reference_number=$request->reference_number;
        $inventory->from_details=$request->from_details;
        try {
            $inventory->save();
            $tot=0;
            foreach($request->product_id as $key=>$value)
            {
                $product=new InventoryProduct();
                $product->inventory_id=$inventory->id;
                $product->product_id=$request->product_id[$key];
                $product->quantity=$request->stock_qty[$key];
                $product->amount=$request->amount[$key];
                $product->save();
                $stock=Stock::where(['product_id'=>$request->product_id[$key],'warehouse_id'=>$request->warehouse_id])->first();
                if(isset($stock))
                {
                    $stock->quantity=$stock->quantity+$request->stock_qty[$key];
                }
                else
                {
                    $stock=new Stock();
                    $stock->product_id=$request->product_id[$key];
                    $stock->warehouse_id=$request->warehouse_id;
                    $stock->quantity=$request->stock_qty[$key];
                }
                $stock->save();
                $tot+=$request->stock_qty[$key];
                $products=Product::find($request->product_id[$key]);
                $products->qty+=$request->stock_qty[$key];
                $products->save();
            }
            $inventory->quantity=$tot;
            $inventory->save();
            session()->flash('message','Successfully created the inventory');
        }
        catch(\Exception $e) {
            session()->flash('message','Unable to create the inventory. Please try again.'.$e->getMessage());
        }
        
        return redirect(admin_url('inventories'));
        
    }

    public function show($id)
    {
        $user=User::find($id) or abort(404);
        return view('admin.staff.staffview',compact('user'));
    }

    public function edit($id)
    {
        if(auth()->user()->cannot('Inventory Edit'))
        {
        return redirect('/');
    }
        $product=Product::where('status',1)->get();
        $warehouses=Warehouse::where('status',1)->get();
        //$users = User::orderBy('created_at','DESC')->get();
        $inventory = Inventory::with('product')->find($id) or abort(404);
        $title="Inventories";
        $msg="Edit";
        $submenu="Inventories";
        return view('admin.inventory.Inventoriesadd',compact('inventory','product','warehouses','title','msg','submenu'));
    }

    public function update(InventoryRequest $request, $id)
    {
        $inventory = Inventory::find($id) or abort(404);
        
        $inventory->warehouse_id      = $request->warehouse_id;
        $inventory->entered_by=auth()->user()->id;
        $inventory->reference_number=$request->reference_number;
        $inventory->from_details=$request->from_details;
        
        try {
            
        $inventory->save();
        $product=InventoryProduct::where('inventory_id',$id)->get();
        foreach($product as $p)
        {
            $stock=Stock::where(['product_id'=>$p->product_id,'warehouse_id'=>$inventory->warehouse_id])->first();
            if(isset($stock))
            {
                $stock->quantity=$stock->quantity-$p->quantity;
            }
            $p->delete();
        }
        
        $tot=0;
            foreach($request->product_id as $key=>$value)
            {
                $product=new InventoryProduct();
                $product->inventory_id=$inventory->id;
                $product->product_id=$request->product_id[$key];
                $product->quantity=$request->stock_qty[$key];
                $product->amount=$request->amount[$key];
                $product->save();
                $stock=Stock::where(['product_id'=>$request->product_id[$key],'warehouse_id'=>$request->warehouse_id])->first();
                if(isset($stock))
                {
                    $stock->quantity=$stock->quantity+$request->stock_qty[$key];
                }
                else
                {
                    $stock=new Stock();
                    $stock->product_id=$request->product_id[$key];
                    $stock->warehouse_id=$request->warehouse_id;
                    $stock->quantity=$request->stock_qty[$key];
                }
                $stock->save();
                $tot+=$request->stock_qty[$key];
            }
            $inventory->quantity=$tot;
            $inventory->save();
        session()->flash('message','Successfully updated the inventory');
        }
        catch(\Exception $e) {
            session()->flash('message','Unable to update the inventory. Please try again.'.$e->getMessage());
        }
        
        return redirect(admin_url('inventories'));
    }
        
    public function destroy($id)
    {
        if(auth()->user()->cannot('Inventory Delete'))
        {
        return redirect('/');
        }
        $inventory = Inventory::find($id) or abort(404);
       
       
        try {
            $inventory->delete();
            session()->flash('message','Inventory successfully deleted');
        }
        catch(\Exception $e) {
            session()->flash('message','Unable to delete the inventory');
        }
        
        return redirect(admin_url('inventories'));
    }
    
    public function stock() {
        
        $inventory=Inventory::with('warehouse','product')->get();
        $submenu="Stock";
        $title = "Inventories";

        
        $stock = Stock::with(['product'=>function($query){$query->with('units');},'warehouse'])->get();
        // die(print_r($stock));
        return view('admin.stock',compact('stock','inventory','submenu','title'));
    }
    public function getProducts()
    {
        $product=Product::where('status',1)->get();
        echo json_encode($product);
        
    }
    public function updateStock(Request $request)
    {
        $product=Product::find($request->id);
        $product->qty+=$request->stock;
        $product->save();
        $stock=new Stock();
        $stock->product_id=$request->id;
        $stock->quantity=$request->stock;
        $stock->save();
        
        // foreach($request->product_id as $key=>$value)
        // {
        //     $product=Product::find($request->product_id[$key]);
        //     $product->qty=$request->stock[$key];
        //     $product->save();
        //     $stock=Stock::where('product_id',$request->product_id[$key])->first();
        //     $stock->quantity=$request->stock[$key];
        //     $stock->save();
        // }
        if($request->ajax()) {
            return response()->json(['status'=>'success','product'=>$product]);
        }
        session()->flash('message','Stock Updated Successfully');
        return redirect(admin_url('inventories/current-stock'));
    }
    
}

