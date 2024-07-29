<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\OrderRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\OrderResource;
use App\Http\Resources\InvoiceResource;
use App\Product;
use App\Category;
use App\User;
use App\Order;
use App\Province;
use App\OrderItem;
use App\OrderPayment;
use App\PaymentMethod;
use App\PaymentTerm;
use App\OrderStatus;
use App\Address;
use App\Account;
use App\Invoice;
use App\Stock;
use PDF;
use DB;
use App;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class OrdersController extends Controller
{

    public function index(Request $request)
    {
        $id=Auth::id();
        $products=Product::where('status',1)->where('qty','>',0)->get();
        
        $order_no=Order::max('id');
        $title="Orders";
        $submenu="Products";
        $salesreps=User::where(['type'=>'staff','status'=>1,'customer_type'=>5])->get();
        $status=OrderStatus::whereNotIn('id',[0,-1])->get();
        // $customer=User::where('type','customer','invoice')->where('id',$id)->first();
        $customer=User::with(['invoice'=>function($q){$q->where('status','>=',0);}])->where('id',$id)->first();
        $drivers=User::where(['type'=>'staff','status'=>1,'customer_type'=>3])->get();
        $provinces  = Province::orderBy('name','ASC')->get();
        $paymentterms = PaymentTerm::get();
        return view('customers.order',compact('customer','products','order_no','id','status','title','submenu','salesreps','drivers','provinces','paymentterms'));
    }
    
    public function defer(Request $request)
    {
        $id=Auth::id();
        $orderquery=Order::sortable()->with(['invoice','user','item'=>function($query){$query->with('product');}]);
        $key    = $request->get('key');
        $status = $request->get('status');
        $byday  = $request->get('byday');
        if ($status != '') {

            $orderquery->where('status', $status);

        }

        else

        {

            $orderquery->where('status','>', 0);

        }

        

        if($key !=''){
            $f=$key;
            $s=$key;
            $orderquery->where(function($q) use($key,$f,$s){
                $q->Where('email','like', '%' .$key. '%')
                       ->orWhere('po_number',$f)
                       ->orWhereHas('invoice',function($query) use($s){$query->where('invoice_number','like','%' .$s. '%');});

            });

        }

        if ($byday == "1"){

            

           $orderquery->whereDate('order_date',date('Y-m-d'));

          

        }

        if ($byday == "2"){

            
            $orderquery->whereDate('order_date',date('Y-m-d',strtotime("-1 days")));

         

        }

        if ($byday == "3"){

            $orderquery->whereMonth('order_date', date('m'));

        }

    

        

        

        $orderquery->orderBy('id','DESC');

        

        $orders=$orderquery->where('user_id',$id)->Paginate(10);
        return [
            'data' => OrderResource::collection($orders),
            'links' => (string) $orders->links(),
        ];
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
    
    
    public function createPO(Request $request) {

        json_encode($request->all());

        if($user = User::where('id',$request->customer_id)->first()) {



            if($request->has('product_names') && count($request->product_names)) {



                $billing = new Address();

                $billing->address       = $request->address1;

                $billing->postalcode    = $request->postalcode;

                $billing->city          = $request->city;

                $billing->province      = $request->province;

                $billing->phone         = $user->phone;

                $billing->email         = $request->email;



                $delivery = new Address();

                $delivery->type          = 'delivery';

                $delivery->address       = $request->delivery_address1;

                $delivery->postalcode    = $request->delivery_postalcode;

                $delivery->city          = $request->delivery_city;

                $delivery->province      = $request->delivery_province;

                $delivery->phone         = $user->phone;

                $delivery->email         = $request->email;

                

                try {

                    $billing->save();

                    $delivery->save();

                }

                catch(\Exception $e) {

                    //Address::where('id',$billing->id ?? NULL)->delete();

                    //Address::where('id',$delivery->id ?? NULL)->delete();

                    return response()->json(['status'=>'fail','data'=>$e->getMessage(), 

                                                 'message'=>'Failed to create the order, Please contact support!']);

                }


                $todayorder=Order::whereDate('order_date',date('Y-m-d'))->count();
                
                $t=sprintf('%03u', $todayorder+1);
                
                $ponumber='PO'.date('y').date('m').date('d').$t;
                
                $shipping=0;
                
                $order = new Order();
                
                $order->po_number = $ponumber;

                $order->user_id     = $user->id;

                $order->email       = $user->email;

                $order->order_date  = date('Y-m-d');

                $order->due_date    = $request->due_date;

                $order->sales_rep   = $request->sales_rep;

                $order->status      = 1;

                $order->driver_id   = $request->driver_id;

                $order->shipping_date = $request->delivery_date;

                $order->message     = $request->message;

                $order->notes       = $request->notes;

                $order->billing_id  = $billing->id;

                $order->delivery_id = $delivery->id;
                
                $order->terms = $request->terms;
                
                $order->shipping=$shipping;
                
                
            

                $itemcount = 0;



                try {

                    $order->save();

                }

                catch(\Exception $e) {



                    return response()->json(['status'=>'fail','data'=>$e->getMessage(), 

                                                 'message'=>'Failed to create the order, Please contact support!']);

                }


                $grand_total = 0;
                $tax = 3;
                $total_quantity=0;
            
                foreach($request->product_names as $key=>$val) {

                    if($order && !empty($request->product_ids[$key]) && !empty($request->quantities[$key])) {

                        //if($product = Product::find($request->product_ids[$key])) {

                        

                        $cid = $user->id;

                    
                        if($product = Product::with(['customer_price'=>function($q) use ($cid) {
                                                        $q->where('customer_id',$cid)->where('status',1)->first();
                                                    }])->where('id',$request->product_ids[$key])->first()) {



                            $price = $product->customer_price->count() ? $product->customer_price->first()->price:$product->price;
                            
                            if($product->price_by == 'weight') 
                                $itemtotal = (($request->quantities[$key]*$product->weight) * $price);
                            elseif($product->price_by == 'quantity') 
                                $itemtotal = ($request->quantities[$key] * $price);
                            else
                                $itemtotal = 0;
                            
                            $item = new OrderItem();

                            $item->order_id         = $order->id;

                            $item->product_id       = $product->id;

                            $item->product_name     = $product->name;
                            
                            $item->product_description = $product->description;

                            $item->product_sku      = $product->sku;

                            $item->rate             = $product->price;

                            $item->price_by         = $product->price_by;

                            $item->quantity         = $request->quantities[$key];
                            
                            $item->weight           = $request->quantities[$key]*$product->weight;
                            
                            $item->total            = $itemtotal;



                            try {

                                $item->save();

                                $itemcount++;
                                
                                $total_quantity+=$request->quantities[$key];
                                
                                $grand_total += $itemtotal;

                            }

                            catch(\Exception $e) {

                                OrderItem::where('order_id',$order->id)->delete();

                                $order->delete();



                                return response()->json(['status'=>'fail','data'=>$e->getMessage(), 

                                                 'message'=>'Failed to create the order, Please contact support!']);

                            } 

                        }

                    }

                }



                if($order && $itemcount < 0) {

                    $order->delete();

                }
                
                $order->tax         = ($grand_total+$shipping) * ($tax / 100);
                $order->grand_total = $grand_total + $shipping + $order->tax;
                $order->total_quantity=$total_quantity;
                $order->save();



                return response()->json(['status'=>'success','data'=>$order, 'message'=>'Order successfully created!']);

            }



            

        }



        return response()->json(['status'=>'fail','data'=> $request->all(), 

                                                    'message'=>'Failed to create the order, Please contact support!']);



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

        //$customer=User::where('id',$order->user_id)->first() or abort(404);

        $orderitems=OrderItem::join('products','products.id','=','order_items.product_id')->where('order_items.order_id',$id)->get();

        $invoice=Invoice::with(['order'=>function($query){$query->with(['billing','delivery','item'=>function($q){$q->with('product');}]);},'user'])->where('id',$id)->first();

        $stocks=Stock::get();

        $submenu="Invoice";

          $title="Order";

        

        return view('admin.order.generateinvoice1',compact('stocks','order','submenu','title','invoice'));

    }
    public function invoices()
    {    
        $id=Auth::id();
         $customers=User::where('type','customer')->where('status',1)->get();
         $invoices=Invoice::with(['order'=>function($query){$query->with('item');},'user'])->where('customer_id',Auth::id())->paginate(10);
        //  $orders=Order::select('orders.id','users.firstname','users.lastname','orders.order_date','orders.grand_total','orders.status','orders.order_id','orders.paid_amount')->join('users','users.id','=','orders.user_id')->where('orders.status',1)->where('orders.user_id',Auth::id())->get();
         $submenu="Invoice";
         $title="Order";
         $paymentmethods=PaymentMethod::where('status',1)->get();
         
        $customer=User::with(['invoice'=>function($q){$q->where('status','>=',0);}])->where('id',$id)->first();
        $drivers=User::where(['type'=>'staff','status'=>1,'customer_type'=>3])->get();
        $provinces  = Province::orderBy('name','ASC')->get();
        $paymentterms = PaymentTerm::get();
        $salesreps=User::where('customer_type',5)->get(); 
         return view('customers.invoices',compact('invoices','submenu','title','customers','paymentmethods','customer','drivers','provinces','paymentterms','salesreps'));
        
    }
    public function deferinvoice(Request $request)
    {
        $invquery=Invoice::sortable()->with(['order'=>function($query){$query->with('item');},'user']);
        $key    = $request->get('key');
        $store    = $request->get('store');

        if($key !=''){
            $f=$key;
            $search=$key;

            $invquery->where(function($query) use($key,$search,$f){
                $query->orWhereHas('order',function($q) use($f){$q->where('po_number',$f);})
                ->orWhere('invoice_number',$search); 
            });
            

        }

        

         

             $invoices=$invquery->where('customer_id',Auth::id())->where('status','>=',0)->paginate(10);

        
        
         return [
            'data' => InvoiceResource::collection($invoices),
            'links' => (string) $invoices->links(),
        ];
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
        $id=Auth::id();
        $orders=Order::with('item','user')->where(['status'=>0,'user_id'=>Auth::id()])->paginate(10);
        //  $orders=Order::select('orders.id','users.firstname','users.lastname','orders.order_date','orders.grand_total','orders.status','orders.order_id','orders.paid_amount')->join('users','users.id','=','orders.user_id')->where('orders.status',1)->where('orders.user_id',Auth::id())->get();
         $submenu="Invoice";
         $title="Backorder";
        $customer=User::with(['invoice'=>function($q){$q->where('status','>=',0);}])->where('id',$id)->first();
        $drivers=User::where(['type'=>'staff','status'=>1,'customer_type'=>3])->get();
        $provinces  = Province::orderBy('name','ASC')->get();
        $paymentterms = PaymentTerm::get();
        $salesreps=User::where('customer_type',5)->get(); 
         return view('customers.backorders',compact('orders','submenu','title','customer','drivers','provinces','paymentterms','salesreps'));
    }
    public function backorderDefer(Request $request)
    {
        $ordquery=Order::sortable()->with('item','user');
        $key    = $request->get('key');
        $store    = $request->get('store');

        if($key !=''){
            $f=$key;
            $search=$key;

            $ordquery->where(function($query) use($key,$search,$f){
                $query->orWhere('po_number',$f);
            });
            

        }

         

             $orders=$ordquery->where(['status'=>0,'user_id'=>Auth::id()])->paginate(10);

        
        
         return [
            'data' => OrderResource::collection($orders),
            'links' => (string) $orders->links(),
        ];
    }
    public function viewBackorder($id)
    {
        $submenu="Invoice";
        $title="Backorder";
        $order=Order::with(['item'=>function($query){$query->with('product');},'user'])->where(['status'=>0,'id'=>$id])->first();
        $customer=User::where('id',$order->user_id)->first();
        return view('customers.viewbackorder',compact('order','customer','submenu','title'));
    }
    public function orderDetails($id){
         $order         = Order::with('user','billing','delivery','item','driver','salesrep')->where('id',$id)->first() or abort(404);
        $orderitems     = $order->item;
        $submenu        = "Order";

        $title          = "Order";
        // die(print_r($orderitems));
        // if($order->status < 4)
        //     return view('customers.order-po-details',compact('order','orderitems','submenu','title'));
        // else
            return view('customers.order-details',compact('order','orderitems','submenu','title'));
        // return view('customers.order-details',compact('orders','orderitems','submenu','title'));
    }
    public function printOrder(Request $request)
    {
        
        $orders=Order::with(['item'=>function($query){$query->with('product');},'user','billing','delivery'])->whereIn('id',$request->id)->get();
        
        return view('customers.printorder',compact('orders'));
        // $result = view('customers.print-order', compact('orders'))->render();
         
        // $pdf = App::make('dompdf.wrapper');
        // $pdf->loadHTML($result);
        // return $pdf->stream();
    }
    public function printIndOrder($id)
    {
        $order =   Order::with(['item'=>function($query){$query->with('product');},'user','billing','delivery'])->where('id',$id)->first();
        if(isset($order))
        {
            $order->printed_at=date('Y-m-d H:i:s');
            $order->save();
        }
        // $order=Order::where('id',$id)->where('printed_at','!=',null)->first();
        // if(isset($order))
        // {
        //     $order->printed_at=date('Y-m-d H:i:s');
        //     $order->save();
        // }
        // $orders=Order::with(['item'=>function($query){$query->with('product');},'user','billing','delivery'])->where('id',$id)->get();
        return view('customers.print-order',compact('order'));
        // $result = view('customers.printorder', compact('orders'))->render();
         
        // $pdf = App::make('dompdf.wrapper');
        // $pdf->loadHTML($result);
        // return $pdf->stream();
    }
    function covertBackorder($id)

    {

        $order=Order::find($id);

        $order->order_date=date('Y-m-d');

        $order->status=1;

        $order->save();

        session()->flash('message','Backorder Successfully Updated to Pending Order');

        return redirect(customer_url('backorders'));

    }
    public function search(Request $request) {

        $keyword = $request->keyword;

        $products = Product::where(function($q) use ($keyword) {
                        $q->where('name','LIKE','%'.$keyword.'%')
                            ->orWhere('sku','LIKE','%'.$keyword.'%');
                    })->where('status',1)->get();

        return response()->json($products);

    }
    
    function getOrder($id, Request $request) {

        

        $order = Order::with('item','user','billing','delivery')->whereId($id)->first();



        if($order) {

            return response()->json(['status'=>'success','order'=>$order,'message'=>'Successfully fetched the order details']);

        }



        return response()->json(['status'=>'fail','order'=>[],'message'=>'Unable to find the order']);



    }
    
    public function editPO(Request $request) {

        if($order = Order::where('id',$request->order_id)->where('user_id',$request->customer_id)->first()) {
            $billing = Address::where('id',$order->billing_id)->first();
            $delivery= Address::where('id',$order->delivery_id)->first();
            

                $billing->address       = $request->address1;

                $billing->postalcode    = $request->postalcode;

                $billing->city          = $request->city;

                $billing->province      = $request->province;

                
                
                $billing->save();



                

                $delivery->type          = 'delivery';

                $delivery->address       = $request->delivery_address1;

                $delivery->postalcode    = $request->delivery_postalcode;

                $delivery->city          = $request->delivery_city;

                $delivery->province      = $request->delivery_province;

                
                
                $delivery->save();
                
            $order->order_date      = date('Y-m-d');
            $order->due_date        = $request->due_date;
            $order->sales_rep       = $request->sales_rep;
            // $order->status          = 4;
            $order->driver_id       = $request->driver_id;
            $order->shipping_date   = $request->delivery_date;
            $order->message         = $request->message;
            $order->discount_amount = $request->discount;
            $order->notes           = $request->notes;
            $order->billing_id      = $billing->id;
            $order->delivery_id     = $delivery->id;

            try {
                $order->save();
            }
            catch(\Exception $e) {
                return response()->json(['status'=>'fail','data'=>$e->getMessage(), 
                                 'message'=>'Error While processing the order #100, Please contact support!']);
            } 

            OrderItem::where('order_id',$order->id)->delete();

            $grand_total = 0;
            $tax = 3;
            $total_quantity=0;
            $shipping=0;
            foreach($request->product_names as $key=>$val) {
                if(!empty($request->product_ids[$key]) && !empty($request->quantities[$key]) && $request->quantities[$key]>0) {
                    if($product = Product::find($request->product_ids[$key])) {

                        if($product->price_by == 'weight') 
                            $itemtotal = ($request->quantities[$key]*$product->weight) * $product->price;
                        elseif($product->price_by == 'quantity') 
                            $itemtotal = ($request->quantities[$key] * $product->price);
                        else
                            $itemtotal = 0;

                        $item = new OrderItem();
                        $item->order_id         = $order->id;
                        $item->product_id       = $product->id;
                        $item->product_name     = $product->name;
                        $item->product_sku      = $product->sku;
                        $item->rate             = $product->price;
                        $item->price_by         = $product->price_by;
                        $item->product_description = $product->description;
                        $item->quantity         = $request->quantities[$key];
                        $item->weight           = $request->quantities[$key]*$product->weight;
                        $item->total            = $itemtotal;

                        try {
                            $item->save();
                            $total_quantity+=$request->quantities[$key];
                            $grand_total += $itemtotal;
                        }
                        catch(\Exception $e) {
                            return response()->json(['status'=>'fail','data'=>$e->getMessage(), 
                                             'message'=>'Failed to process the order #101, Please contact support!']);
                        } 
                    }
                }

                
            }

           
            $order->shipping=$shipping;
            $order->tax         = ($grand_total+$shipping) * ($tax / 100);
            $order->grand_total = $grand_total + $shipping + $order->tax;
            $order->total_quantity=$total_quantity;
            $order->save();
            
            

            

            return response()->json(['status'=>'success','data'=> $order, 
                                                         'message'=>'Successfully updated the order!']);
        }

        return response()->json(['status'=>'fail','data'=> $request->all(), 
                                                    'message'=>'Failed to update the order #106, Please contact support!']);
    }
    
}
