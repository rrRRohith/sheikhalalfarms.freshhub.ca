<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\OrderRequest;
use Illuminate\Support\Facades\Hash;
use App\Product;
use App\Category;
use App\User;
use App\Order;
use App\OrderItem;
use App\OrderPayment;
use App\OrderStatus;
use App\Account;
use App\Invoice;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class DeliveryController extends Controller
{

    public function index(Request $request)
    {
        $id=Auth::id();
        $products=Product::where('status',1)->where('qty','>',0)->get();
        $orderquery=Order::with('user')->where('user_id',$id);
        if (request()->status != "") {
            $orderquery->where('status', request()->status);
        }
        $orders=$orderquery->where('status','!=',6)->orderBy('id','DESC')->paginate(20);
        $order_no=Order::max('order_id');
        $title="Orders";
        $submenu="Products";
        $status=OrderStatus::get();
        $customer=User::where('type','customer')->where('id',$id)->first();
        
        return view('customers.order',compact('customer','products','orders','order_no','id','status','title','submenu'));
    }


    // public function create()
    // {
    //   if(Auth()->user()->cannot('Create Product'))
    //   {
    //       return redirect('/');
    //   }
    //     $title="Products";
    //     $submenu="Products";
    //     $msg="Add";
    //     $category=Category::where('status',1)->get();
    //     return view('admin.product-form',compact('title','msg','submenu','category'));
    // }


    public function store(OrderRequest $request)
    {
        // die(print_r($request->all()));
        $order = new Order();
        $uid=Auth::id();
        $order->user_id             = $uid;
        $order->order_id=$request->order_id;
        $order->email      = Auth::user()->email;
        $order->order_date     = $request->order_date;
        $order->due_date           = $request->due_date;
        $order->shipping_id            = $request->shipping_id;
        $order->tracking_code          = $request->tracking_code;
        $order->shipping_date= $request->shipping_date;
        $order->billing_address= $request->billing_address;
        $order->shipping_address= $request->shipping_address;
        $order->message= $request->message;
        $order->notes= $request->notes;
        $order->discount_amount= $request->discount;
        $order->discount_type= $request->discountt;
        $order->discount=$request->discount_type;
        $order->shipping= $request->shipping;
        $order->tax= $request->tax1;
        $order->grand_total= $request->grand_total;
        $order->sales_rep=0;
        $order->status=0;
        $order->paid_amount=0;
        if($order->save())
        {
        $id=$order->id;
        //$id1=1;
        $prod_id=$request->product_id;
        
        foreach($prod_id as $key=>$value)
        {
        $orderitem=new OrderItem();
        if($request->product_id[$key] !=null)
        {
        $orderitem->order_id=$id;
        $orderitem->product_id=$request->product_id[$key];
        $orderitem->quantity=$request->quantity[$key];
        $orderitem->rate=$request->rate[$key];
        
        $orderitem->total=$request->rate[$key]*$request->quantity[$key];
        
        $orderitem->save();
        }
        }
        session()->flash('message','Successfully created the order');
        }
        else
        {
            session()->flash('message','Unable to create the order. Please try again.');
        }
        try {
            
            session()->flash('message','Successfully created the product');
        }
        catch(\Exception $e) {
            session()->flash('message','Unable to create the product. Please try again.');
        }
        
        return redirect(customer_url('orders'));
        
    }
    public function getdetails($pid)
    {
        $details=Product::where('id',$pid)->get();
        echo json_encode($details);
    }
    public function getcustdetails($cid)
    {
        $details=User::where('id',$cid)->get();
        echo json_encode($details);
    }
    public function changeStatus($id)
    {
        $order=Order::find($id) or abort(404);
        $order->status=1;
        $order->save();
        try {
            $order->save();
            session()->flash('message','Order  confirmation successfully completed');
        }
        catch(\Exception $e) {
            session()->flash('message','Unable to confirm order');
        }
        
        return redirect(admin_url('orders'));
    }
    public function destroy($id)
    {
         
        $order = Order::find($id) or abort(404);
        $orderitems=OrderItem::where('order_id',$id);
        try {
            $order->status=6;
            $order->save();
            
            session()->flash('message','Order successfully deleted');
        }
        catch(\Exception $e) {
            session()->flash('message','Unable to delete the order');
        }
        
        return redirect(customer_url('orders'));
    }
     public function edit($id)
    {
   
        // $data['details'] = Order::find($id) or abort(404);
        // $data['proddetails']=OrderItem::where('order_id',$id)->get();
        // echo json_encode($data);
        $details = Order::where('id',$id)->get();
        $proddetails=OrderItem::where('order_id',$id)->get();
        echo json_encode($details);
       // echo json_encode(array('details'=>$details,'proddetails'=>$proddetails));
        //return view('admin.product-form',compact('category','product','title','msg','submenu'));
    }
    public function getpr($id)
    {
   
        $proddetails=OrderItem::select('order_items.product_id','products.description','products.name','order_items.rate','order_items.quantity')->join('products','products.id','=','order_items.product_id')->where('order_id',$id)->get();
        echo json_encode($proddetails);
       
    }

    // public function show($id)
    // {
    //     $user=User::find($id) or abort(404);
    //     $title="Staffs";
    //     $msg="Edit";
    //     return view('admin.staffview',compact('user','title','msg'));
    // }

   

    public function update(OrderRequest $request, $id)
    {
        // die(print_r($request->all()));
        $order = Order::find($id) or abort(404);
        
        $uid=Auth::id();
        $order->user_id             = $uid;
        $order->order_id=$request->order_id;
        $order->email      = Auth::user()->email;
        $order->order_date     = $request->order_date;
        // $order->due_date           = $request->due_date;
        // $order->shipping_id            = $request->shipping_id;
        // $order->tracking_code          = $request->tracking_code;
        $order->shipping_date= $request->shipping_date;
        $order->billing_address= $request->billing_address;
        $order->shipping_address= $request->shipping_address;
        $order->message= $request->message;
        // $order->notes= $request->notes;
        $order->discount= $request->discount;
        $order->discount_type= $request->discount_type;
        // $order->shipping= $request->shipping;
        // $order->tax= $request->tax1;
        $order->grand_total= $request->grand_total;
        // $order->status=0;
        $order->paid_amount=0;
        if($order->save())
        {
            OrderItem::where('order_id',$id)->delete();
            $prod_id=$request->product_id;
        
        foreach($prod_id as $key=>$value)
        {
        $orderitem=new OrderItem();
        if($request->product_id[$key] !=null)
        {
        $orderitem->order_id=$id;
        $orderitem->product_id=$request->product_id[$key];
        $orderitem->quantity=$request->quantity[$key];
        $orderitem->rate=$request->rate[$key];
        // $orderitem->tax=$request->tax[$key];
        $orderitem->total=$request->rate[$key]*$request->quantity[$key];
        
        $orderitem->save();
        }
        }
        session()->flash('message','Successfully updated the order');
            
        }
        else
        {
            session()->flash('message','Unable to update the order. Please try again.');
        }
        return redirect(customer_url('orders'));
    }
    public function generateinvoice($id)
    {
        $order=Order::where('id',$id)->first();
        $orderitems=OrderItem::join('products','products.id','=','order_items.product_id')->where('order_items.order_id',$id)->get();
        $customer=User::where('id',$order->user_id)->first();
       // print_r($orderitems);
        return view('customers.generateinvoice',compact('order','orderitems','customer'));
    }
    public function invoices()
    {    
         $invoices=Invoice::with(['order'=>function($query){$query->with('item');},'user'])->where('customer_id',Auth::id())->get();
        //  $orders=Order::select('orders.id','users.firstname','users.lastname','orders.order_date','orders.grand_total','orders.status','orders.order_id','orders.paid_amount')->join('users','users.id','=','orders.user_id')->where('orders.status',1)->where('orders.user_id',Auth::id())->get();
         $submenu="Invoice";
         $title="Order";
         return view('customers.invoices',compact('invoices','submenu','title'));
        
    }
    public function deleteinvoice($id)
    {
         $orders=Order::find($id) or abort(404);
         $orders->status=0;
         try
         {
         $orders->save();
          session()->flash('message','Invoice successfully deleted');
        }
        catch(\Exception $e) {
            session()->flash('message','Unable to delete the invoice');
        }
        return redirect(customer_url('invoices'));
        
    }
    public function makepayment(Request $request)
    {
        $order_id=$request->order_id;
        $user_id=$request->user_id;
        $orderpayment=new OrderPayment();
        $orderpayment->order_id=$order_id;
        $orderpayment->payment_date=$request->payment_date;
        $orderpayment->payment_method=$request->payment_method;
        $orderpayment->amount_received=$request->amount_received;
        $orderpayment->memo=$request->memo;
        
        $order=Order::find($order_id) or abort(404);
        $order->paid_amount=$order->paid_amount+$request->amount_received;
        
        $account=Account::where('user_id',$user_id)->first();
        $account->credit=$account->credit+$request->amount_received;
        try
        {
            $orderpayment->save();
            $order->save();
            $account->save();
            session()->flash('message','Payment successfully updated');
        }
        catch(\Exception $e) {
            session()->flash('message','Unable to make payment');
        }
        return redirect()->back();
    }
        
    
    // public function changeStatus($id,$status)
    // {
    //     $product=Product::find($id) or abort(404);
    //     $product->status=$status;
    //     $product->save();
    //     try {
    //         $product->save();
    //         session()->flash('message','Product  status changed');
    //     }
    //     catch(\Exception $e) {
    //         session()->flash('message','Unable to change status');
    //     }
        
    //     return redirect(admin_url('products'));
    // }
    
    // public function __uploadImage($existing = '') {
        
        
    //     if(request()->hasFile('picture') && request()->file('picture')->isValid())
    //     {

    //         $filename = str_random(40).'.'.request()->picture->extension();
            
    //         try {
                
    //             request()->picture->storeAs('media/products',$filename);
    //         }
    //         catch(\Exception $e) {
                
    //         }
            
    //         return $filename;
    //     }
        
    //     return null;
    // }
    
    // public function __deleteImage($existing = '') {
    //     if($existing != '')
    //         @unlink('media/products/'.$product->picture);
    // }
    public function backorders()
    {
        $orders=Order::with('item','user')->where(['backorder_status'=>'backorder','user_id'=>Auth::id()])->get();
        //  $orders=Order::select('orders.id','users.firstname','users.lastname','orders.order_date','orders.grand_total','orders.status','orders.order_id','orders.paid_amount')->join('users','users.id','=','orders.user_id')->where('orders.status',1)->where('orders.user_id',Auth::id())->get();
         $submenu="Invoice";
         $title="Backorder";
         return view('customers.backorders',compact('orders','submenu','title'));
    }
    public function orderDetails($id){
         $orders = Order::with('user')->where('id',$id)->get();
        $orderitems=OrderItem::join('products','products.id','=','order_items.product_id')->where('order_items.order_id',$id)->get();
        $submenu="Order";
         $title="Order";
        return view('customers.order-details',compact('orders','orderitems','submenu','title'));
    }
    
}
