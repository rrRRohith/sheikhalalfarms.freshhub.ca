<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Hash;
use App\Product;
use App\Category;
use App\Unit;
use App\Stock;
use App\User;
use App\Weight;
use Helper;
use DB;

class ProductsController extends Controller
{

    public function index(Request $request)
    {
        if(Auth()->user()->cannot('View Product'))
       {
           return redirect('/');
       }
        // $productquery = Product::with('category');
        // if($request->search !='')
        // {
        //     $productquery->where('name','like','%'.$request->search.'%')->orWhere('sku','like','%'.$request->search.'%')->orWhere('id',$request->search)->orWhere('description','like','%'.$request->search.'%');
        // }
        // if($request->category !='')
        // {
        //     $productquery->where('category_id',$request->category);
        // }
        // if($request->status !='')
        // {
        //     $productquery->where('status',$request->status);
        // }
        
        // $product=$productquery->paginate(10);
        $submenu="Products";
        $title = "Products";
        $salesreps=User::where('customer_type',5)->get();
         
        $categories = Category::where('status',1)->get();
        $category =Category::get();
        $units      = Unit::where('status',1)->get();
        $customers = User::where('type','customer')->get();
        return view('admin.product.products',compact('submenu','title','salesreps','categories','units','category','customers'));
    }

    public function defer(Request $request){
        /*
         * Get search key if requested.
         */
        // if(isset($request))
        // $customers=$this->searchTable($request->all());
        $productquery=Product::sortable()->with('category');
        $key    = $request->get('key');
        $type   = $request->get('type');
        $status = $request->get('status');

        if($key !='')
        $productquery->where(function($q) use ($key) {
            $q->where('name','like','%'.$key.'%')->orWhere('sku','like','%'.$key.'%')->orWhere('id',$key)->orWhere('description','like','%'.$key.'%');
        });
        if($type !='')
            $productquery->where('category_id',$type);
        if($status !='')
            $productquery->where('status',$status);
        
        $products=$productquery->paginate(10); 
        
        return [
            'data' => ProductResource::collection($products),
            'links' => (string) $products->links(),
        ];
    }


    public function create()
    {
       if(Auth()->user()->cannot('Create Product'))
       {
           return redirect('/');
       }
        $submenu="Products";
        $title = "Products";
        $category=Category::where('status',1)->get();
        $units=Unit::where('status',1)->get();
        return view('admin.product.product-form',compact('submenu','category','units','title'));
    }
    

    public function store(ProductRequest $request)
    {
        // $weight=Weight::where('base',1)->first();
        

        $product = new Product();
        
        $product->name             = $request->name;
        $product->description      = $request->description;
        $product->category_id      = $request->category_id;
        $product->weight           = storeQuantity($request->weight);
        if($request->price_by=='weight')
            $product->price            = storeRate($request->price);
        else
            $product->price            = $request->price;
        $product->unit             = $request->unit;
        $product->unittype         = $request->unittype;
        $product->sku              = $request->sku;
        $product->picture          = $this->__uploadImage();
        $product->qty              = $request->stock;
        $product->price_by         = $request->price_by;
        
        if (!empty(request()->input('picture')) && strlen(request()->input('picture')) > 6) {
         $picture = request()->input('picture');
         if (preg_match('/data:image/', $picture)) {
            list($type, $picture) = explode(';', $picture);
            list($i, $picture) = explode(',', $picture);
            $picture = base64_decode($picture);
            $image_name = Str::random(30) . '.png';
            Storage::put('/images/products/' . $image_name, $picture);
            $product->picture = $image_name;
         }
       }
            
        try {
            $product->save();
            $stock=new Stock();
            $stock->product_id=$product->id;
            $stock->warehouse_id=1;
            $stock->quantity= $request->stock != '' ? $request->stock:0;
            $stock->save();
            
            /*$stock=new Stock();
            $stock->product_id=$request->product_id;
            $stock->warehouse_id=2;
            $stock->quantity=0;
            $stock->save();*/
            
            session()->flash('message','Successfully created the product');
        }
        catch(\Exception $e) {
            die(print($e->getMessage()));
            session()->flash('message','Unable to create the product. Please try again.' );
        }

        if(isset($product->id)) {
            foreach($request->customer as $key=>$val) {
                if($val != '' && is_numeric($val)) {
                    DB::table('customer_price')->insert(['product_id'=>$product->id,'customer_id'=>$key,
                                    'status'=>1,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
                }
            }
        }
        
        
        if($request->ajax()) {
            return response()->json(['status'=>'success','product'=>$product]);
        }
        
        return redirect(admin_url('products'));
        
    }
    
    public function updateStock(Request $request)
    {
        if($request->has('pro_id') && $request->pro_id !='')
        {
            $product=Product::find($request->pro_id);
            $product->qty+=$request->stock;
            $product->save();
            $stock=Stock::where('product_id',$request->pro_id)->first();
            $stock->quantity= $product->qty;
            $stock->save();
        }
        if($request->ajax()) {
            return response()->json(['status'=>'success','product'=>$product]);
        }
    }

    public function edit($id)
    {
        if(Auth()->user()->cannot('Edit Product'))
       {
           return redirect('/');
       }
        $product = Product::find($id) or abort(404);
        $category=Category::where('status',1)->get();
        $units=Unit::where('status',1)->get();
        $submenu="Products";
        $title = "Products";
        return view('admin.product.product-form',compact('category','product','submenu','units','title'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'   => 'bail|required|max:50',
            'category_id'     => 'bail|required',
            'weight'    => 'bail|required',
            'price'    => 'bail|required',
            'unit'     => 'bail|required',
            'unittype' => 'bail|required',
            'sku'      => 'bail|required|unique:products,sku,'.$id
            ]);
        $product = Product::find($id) or abort(404);
        
        $product->name             = $request->name;
        $product->description      = $request->description;
        $product->category_id      = $request->category_id;
        $product->weight           = storeQuantity($request->weight);
        if($request->price_by=='weight')
            $product->price            = storeRate($request->price);
        else
            $product->price            = $request->price;
        $product->unit             = $request->unit;
        $product->unittype         = $request->unittype;
        $product->sku              = $request->sku;
        $product->price_by         = $request->price_by;
        if (!empty(request()->input('picture')) && strlen(request()->input('picture')) > 6) {
            if($product->picture !='')
            $this->__deleteImage($product->picture);
            
            $product->picture = $this->__uploadImage();
        }   
        
        try {
            $product->save();
            $stock=Stock::where('product_id',$id)->first();
            $stock->product_id=$product->id;
            $stock->warehouse_id=1;
            $stock->quantity= $request->stock != '' ? $request->stock:0;
            $stock->save();
           
            session()->flash('message','Successfully updated the product');
        }
        catch(\Exception $e) {
            session()->flash('message','Unable to update the product. Please try again.');
        }

        if(isset($product->id)) {
            foreach($request->customer as $key=>$val) {
                DB::table('customer_price')->where(['customer_id'=>$key, 'product_id'=>$product->id])->delete();
                if($val != '' && is_numeric($val)) {
                    DB::table('customer_price')->insert(['product_id'=>$product->id,'customer_id'=>$key, 'price'=>$val, 
                                    'status'=>1,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
                }
            }
        }

        if($request->ajax()) {
            return response()->json(['status'=>'success','product'=>$product]);
        }
        return redirect(admin_url('products'));
    }
        
    public function destroy($id)
    {
         if(Auth()->user()->cannot('Delete Product'))
       {
           return redirect('/');
       }
        $product = Product::find($id) or abort(404);
       
        try {
            $this->__deleteImage($product->picture);
            $product->delete();
            $stock=Stock::where('product_id',$id)->delete();
            session()->flash('message','Product successfully deleted');
        }
        catch(\Exception $e) {
            session()->flash('message','Unable to delete the product');
        }
        
        return redirect(admin_url('products'));
    }
    public function changeStatus($id)
    {
        $product=Product::find($id) or abort(404);
        $product->status=!$product->status;
        $product->save();
        try {
            $product->save();
            session()->flash('message','Product  status changed');
        }
        catch(\Exception $e) {
            session()->flash('message','Unable to change status');
        }
        
        return redirect(admin_url('products'));
    }
    
    public function __uploadImage($existing = '') {
         if (!empty(request()->input('picture')) && strlen(request()->input('picture')) > 6) {
            $picture = request()->input('picture');
            if (preg_match('/data:image/', $picture)) {
                list($type, $picture) = explode(';', $picture);
                list($i, $picture) = explode(',', $picture);
                $picture = base64_decode($picture);
                $image_name = Str::random(30) . '.png';
                Storage::put('images/products/' . $image_name, $picture);
                return $image_name;
            }
        }
        return null;
    }
    
    public function __deleteImage($existing = '') {
        if($existing != '')
            @unlink('images/products/'.$product->picture);
    }
    public function getDetails($id)
    {
        $product=Product::where('id',$id)->get();
        return json_encode($product);
    }

    public function getCustomerPrices($proid) 
    {
        $customers = DB::select("SELECT u.id AS customer_id, u.business_name, u.firstname, u.lastname, 
                                    cp.price AS custom_price, cp.product_id AS product FROM users u 
                                    LEFT JOIN customer_price cp ON u.id=cp.customer_id AND cp.product_id={$proid} 
                                    WHERE u.type='customer' GROUP BY u.id");

        return json_encode($customers);
    }
    
    public function search(Request $request,$type="") {

        $keyword = $request->keyword;
        $cid = $request->cid ?? 0;

        if($type==1)
        {
            $products = Product::with(['customer_price'=>function($q) use ($cid) {
                $q->where('customer_id',$cid)->where('status',1)->first();
            }])->where(function($q) use ($keyword) {
                        $q->where('sku','LIKE','%'.$keyword.'%');
                    })->where('status',1)->get();
        }
        else
        {

            $products = Product::with(['customer_price'=>function($q) use ($cid) {
                $q->where('customer_id',$cid)->where('status',1)->first();
            }])->where(function($q) use ($keyword) {
                        $q->where('name','LIKE','%'.$keyword.'%')
                            ->orWhere('sku','LIKE','%'.$keyword.'%');
                    })->where('status',1)->get();
        }

        return response()->json($products);

    }
    
}
