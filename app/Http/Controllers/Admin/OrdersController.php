<?php



namespace App\Http\Controllers\Admin;



//use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use App\Http\Requests\ProductRequest;

use App\Http\Requests\OrderRequest;

use App\Http\Resources\OrderResource;

use App\Http\Resources\InvoiceResource;

use Illuminate\Support\Facades\Hash;

use App\Product;

use App\Setting;

use App\PaymentTerm;

use App\Category;

use App\User;

use App\Order;

use App\Runsheet;

use App\OrderStatus;

use App\OrderItem;

use App\Account;

use App\Stock;

use App\Invoice;

use App\OrderPayment;

use App\Message;

use App\Unit;

use Illuminate\Http\Request;

use Illuminate\Pagination\CursorPaginator;

use App\Province;

use App\Address;

use App\PaymentMethod;
use App\Mail\InvoiceSent;
use PDF;
use Mail;
use DB;
use App;

class OrdersController extends Controller

{





    public function index()
    {
        
        $role=Auth::user()->roles()->first()->id;

        $customers=User::where('type','customer')->where('status',1)->get();

        $products=Product::where('status',1)->where('qty','>',0)->get();

        
        $drivers=User::where(['type'=>'staff','status'=>1,'customer_type'=>3])->get();

        $order_no=Order::max('id');

        $status=OrderStatus::whereNotIn('id',[0,3])->get();

        $submenu="Order";

        $title="Order";

        $salesreps=User::where('customer_type',5)->get();

        $paymentterms = PaymentTerm::get();
        
        $categories = Category::where('status',1)->get();

        $units      = Unit::where('status',1)->get(); 

        $provinces  = Province::orderBy('name','ASC')->get();

         
        return view('admin.order.orders',compact('customers','products','order_no','status','drivers','submenu','title','salesreps','categories','units','provinces','paymentterms'));

    }
    
    public function defer(Request $request)
    {
        $role=Auth::user()->roles()->first()->id;
        $orderquery=Order::sortable()->with(['invoice','item'=>function($query){$query->with('product');}])->select('orders.id','orders.po_number','users.firstname','users.phone','users.lastname','orders.order_date','orders.shipping_date','orders.grand_total','orders.status','orders.email','users.business_name','users.customer_type','orders.user_id','users.sales_rep')->join('users','users.id','=','orders.user_id');
        $key    = $request->get('key');
        $status = $request->get('status');
        $byday  = $request->get('byday');
        if ($status != '') {

            $orderquery->where('orders.status', $status);

        }

        else

        {

            $orderquery->where('orders.status','!=', 0);

        }

        

        if($key !=''){
            $f=$key;
            $s=$key;
            $orderquery->where(function($q) use($key,$f,$s){
                $q->Where('orders.email','like', '%' .$key. '%')
                       ->orWhere('users.phone','like', '%' .$key. '%')->orWhere('users.business_name','like', '%' .$key. '%')->orWhere(DB::raw('CONCAT(users.firstname, " ", users.lastname)'),'like', '%' .$key. '%')
                       ->orWhere('orders.po_number',$f)
                       ->orWhereHas('invoice',function($query) use($s){$query->where('invoice_number','like','%' .$s. '%');});

            });

        }

        if ($byday == "1"){

            

           $orderquery->whereDate('orders.order_date',date('Y-m-d'));

          

        }

        if ($byday == "2"){

            
            $orderquery->whereDate('orders.order_date',date('Y-m-d',strtotime("-1 days")));

         

        }

        if ($byday == "3"){

            $orderquery->whereMonth('orders.order_date', date('m'));

        }

    

        if($role == 12)

        {

            $orderquery->where('orders.status',1);

        }

        else if($role==4)

        {

            $orderquery->where('orders.status',3);

        }

        

        $orderquery->orderBy('id','DESC');

        

        $orders=$orderquery->Paginate(10);
        return [
            'data' => OrderResource::collection($orders),
            'links' => (string) $orders->links(),
        ];
    }

    public function store(OrderRequest $request)
    {
        $todayorder=Order::whereDate('order_date',date('Y-m-d'))->count();
        
        // $t=str_pad($todayorder+1, 3, "0", STR_PAD_LEFT);
        $t=sprintf('%03u', $todayorder+1);
        $ponumber='PO'.date('y').date('m').date('d').$t;
        
        $order = new Order();
        
        $order->user_id             = $request->user_id;

        $order->po_number           =$ponumber;

        $order->email      = $request->email;

        $order->order_date     = $request->order_date;

        $order->due_date           = $request->due_date;

        // $order->shipping_id            = $request->shipping_id;

        // $order->tracking_code          = $request->tracking_code;

        $order->shipping_date= $request->shipping_date;

        $order->billing_address= $request->billing_address;

        $order->shipping_address= $request->shipping_address;

        $order->message= $request->message;

        $order->notes= $request->notes;

        $order->discount_amount= $request->discount;

        $order->discount_type= $request->discountt;

        $order->discount=$request->discount_type;

        // $order->shipping= $request->shipping;

        // $order->tax= $request->tax1;

        $order->sales_rep=Auth::user()->id;

        $order->grand_total= $request->grand_total;

        // $order->status=0;

        $order->paid_amount=0;

        if($order->save())

        {

        $id=$order->id;

        //$id1=1;

        $prod_id=$request->product_id;

        
        $total_quantity=0;
        foreach($prod_id as $key=>$value)

        {

        $orderitem=new OrderItem();

        if($request->product_id[$key] !=null)

        {
        
        $orderitem->order_id=$id;

        $orderitem->product_id=$request->product_id[$key];

        $orderitem->quantity=$request->quantity[$key];

        $orderitem->rate=$request->rate[$key];

        

        $orderitem->total=$request->rate[$key]*$request->quantity[$key]+$request->tax[$key];

        
        $total_quantity+=$request->quantity[$key];
        $orderitem->save();
        

        }

        }

        $order->total_quantity=$total_quantity;
        $order->save();

        session()->flash('message','Successfully created the order');

        }

        else

        {

            session()->flash('message','Unable to create the order. Please try again.');

        }

       

        

        return redirect(admin_url('orders'));

        

    }

    public function getdetails($pid)

    {

        $details=Product::where('id',$pid)->get();

        echo json_encode($details);

    }

    public function getdetails1($pid)

    {

       

        $details=Product::where('name','LIKE','%'.$pid.'%')->where('qty','>=',0)->get();

        

        // $details=Product::where('id',$pid)->get();

        echo json_encode($details);

    }

    public function getcustdetails($cid)

    {

        $details=User::where('id',$cid)->get();

        echo json_encode($details);

    }

    public function getcustdetails1($cid)

    {

        $details=User::where('firstname','LIKE','%'.$cid.'%')->where('type','customer')->get();

        echo json_encode($details);

    }

    public function changeStatus($id)

    {

        $order=Order::find($id) or abort(404);

        $order->status=1;

        try {

            $order->save();

            $account=Account::where('user_id',$order->user_id)->first();

            $account->debit=$account->debit+$order->grand_total;

            $account->save();

            session()->flash('message','Order  confirmation successfully completed');

        }

        catch(\Exception $e) {

            session()->flash('message','Unable to confirm order');

        }

        

        return redirect(admin_url('orders'));

    }



    function orderStatus(Request $request) {

        if($status = OrderStatus::find($request->status)) {

            if($order = Order::find($request->id)) {

                $order->status = $status->id;

                $order->save();



                return response()->json(['status'=>'success','message'=>'Successfully changed the order status']);

            }

        }



        return response()->json(['status'=>'fail','message'=>'Unable to change the status']);

    }





    public function updateStatus($id,$status,Request $request)

    {

        $order=Order::with(['user'=>function($query){$query->with('paymentterm');}])->find($id) or abort(404);

        $order->status=$status;

        if($status == 0){

             $message=new Message();

             $message->sender_id=Auth::id();

             $message->sender_email=Auth::User()->email;

             $message->recipient_id=$order->user_id;

             $message->recipient_email=$order->email;

             $message->subject="Order pending";

             $message->body_html="Your Order is Pending";

             $message->body_text="Your Order is Pending !..";

             $message->save();

             

       } else if($status == 1){

             $message=new Message();

             $message->sender_id=Auth::id();

             $message->sender_email=Auth::User()->email;

             $message->recipient_id=$order->user_id;

             $message->recipient_email=$order->email;

             $message->subject="Order Accepted";

             $message->body_html="Your Order Accepted";

             $message->body_text="Your Order Accepted !..";

             $message->save();

             

        }else if($status == 2){

             $message=new Message();

             $message->sender_id=Auth::id();

             $message->sender_email=Auth::User()->email;

             $message->recipient_id=$order->user_id;

             $message->recipient_email=$order->email;

             $message->subject="Order is Processing";

             $message->body_html="Your Order is Procssing";

             $message->body_text="Your Order is Procssing !..";

             $message->save();

             

        }else if($status == 3){

             $message=new Message();

             $message->sender_id=Auth::id();

             $message->sender_email=Auth::User()->email;

             $message->recipient_id=$order->user_id;

             $message->recipient_email=$order->email;

             $message->subject="Order Ready";

             $message->body_html="Your Order is Ready";

             $message->body_text="Your Order is Ready !..";

             $message->save();

            

             

        }else if($status == 4){

              $items=OrderItem::where('order_id',$id)->get();

              foreach($items as $item)

              {

                  $proqty=Product::find($item->product_id);

                  $proqty->qty=$proqty->qty-$item->quantity;

                  $proqty->save();

                //   $stock=Stock::where('product_id',$item->product_id)->first();

                //   $stock->quantity=$stock->quantity - $item->quantity;

                //   $stock->save();

              }

             $message=new Message();

             $message->sender_id=Auth::id();

             $message->sender_email=Auth::User()->email;

             $message->recipient_id=$order->user_id;

             $message->recipient_email=$order->email;

             $message->subject="Order Transit";

             $message->body_html="Your Order is Transit";

             $message->body_text="Your Order is Transit !..";

             $message->save();

             

        }else if($status == 5){

             $message=new Message();

             $message->sender_id=Auth::id();

             $message->sender_email=Auth::User()->email;

             $message->recipient_id=$order->user_id;

             $message->recipient_email=$order->email;

             $message->subject="Order Delivered";

             $message->body_html="Your Order is Delivered";

             $message->body_text="Your Order Delivered !..";

             $message->save(); 

        

        }else if($status == 6){

             $message=new Message();

             $message->sender_id=Auth::id();

             $message->sender_email=Auth::User()->email;

             $message->recipient_id=$order->user_id;

             $message->recipient_email=$order->email;

             $message->subject="Order Deleted";

             $message->body_html="Your Order is Deleted";

             $message->body_text="Your Order Deleted !..";

             $message->save();      

        }

        // if($status==4)

        // {

        //   $items=OrderItem::where('order_id',$id)->get();

        //   foreach($items as $item)

        //   {

        //       $proqty=Product::find($item->product_id);

        //       $proqty->qty=$proqty->qty-$item->quantity;

        //       $proqty->save();

        //       $stock=Stock::where('product_id',$item->product_id)->first();

        //       $stock->quantity=$stock->quantity - $item->quantity;

        //       $stock->save();

        //   }

           

        // }

        try {

            $order->save();

            session()->flash('message','Order  status successfully updated');

        }

        catch(\Exception $e) {

            session()->flash('message','Unable to change order status');

        }

        

         return redirect(admin_url('orders'));

    }

    public function getStock($id)

    {

            $orderitem=OrderItem::with('stock','product')->where('order_id',$id)->get();

            $pid=array();

            foreach($orderitem as $oi)

            {

                $st=Product::where('id',$oi->product_id)->first();

                

                // if($st->qty < $oi->quantity)

                // {

                    $pid[]=$oi->product_id;

                // }

            }

            $prod=array();

            // foreach($orderitem as $oi)

            // {

                

            //     $prod[]=Product::join('order_items','order_items.product_id','products.id')->where('products.id',$oi->product_id)->first();

            // }

            

            foreach($pid as $p)

            {

                $prod[]=Product::join('order_items','order_items.product_id','products.id')->where('products.id',$p)->where('order_items.order_id',$id)->first();

            }

            echo json_encode($orderitem);

           

    }

    public function destroy($id)

    {

         

        $order = Order::find($id) or abort(404);

        $orderitems=OrderItem::where('order_id',$id);

        try {

            $orderitems->delete();

            $order->delete();

            

            session()->flash('message','Order successfully deleted');

        }

        catch(\Exception $e) {

            session()->flash('message','Unable to delete the order');

        }

        

        return redirect(admin_url('orders'));

    }

    public function edit($id)

    {

   

        // $data['details'] = Order::find($id) or abort(404);

        // $data['proddetails']=OrderItem::where('order_id',$id)->get();

        // echo json_encode($data);

        $details = Order::with('user')->where('id',$id)->get();

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



   



    public function update(OrderRequest $request, $id)

    {

        $order = Order::find($id) or abort(404);

        

        $order->user_id = $request->user_id;

        $order->order_id   =$request->order_id;

        $order->email      = $request->email;

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

        $order->status=0;

        $order->paid_amount=0;

        if($order->save())

        {

            OrderItem::where('order_id',$id)->delete();

            $prod_id=$request->product_id;

        
        $total_quantity=0;
        foreach($prod_id as $key=>$value)

        {

        $orderitem=new OrderItem();

        if($request->product_id[$key] !=null)

        {

        $orderitem->order_id=$id;

        $orderitem->product_id=$request->product_id[$key];

        $orderitem->quantity=$request->quantity[$key];

        $orderitem->rate=$request->rate[$key];

        $orderitem->total=$request->rate[$key]*$request->quantity[$key]+$request->tax[$key];

        

        $orderitem->save();
        $total_quantity+=$request->quantity[$key];
        }

        }
        $order->total_quantity=$total_quantity;
        $order->save();
        session()->flash('message','Successfully updated the order');

            

        }

        else

        {

            session()->flash('message','Unable to update the order. Please try again.');

        }

        return redirect(admin_url('orders'));

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

    public function invoices(Request $request,$id=null)

    {

        $order_no=Order::max('id');

        $customers=User::where('type','customer')->where('status',1)->get();

        $products=Product::where('status',1)->where('qty','>',0)->get();

        $submenu="Invoice";

        $title="Order";
        
        $paymentmethods=PaymentMethod::where('status',1)->get();
        
        $salesreps=User::where('customer_type',5)->get();

        $paymentterms = PaymentTerm::get();
        
        $drivers=User::where(['type'=>'staff','status'=>1,'customer_type'=>3])->get(); 
        
        $categories = Category::where('status',1)->get();
        
        $units      = Unit::where('status',1)->get(); 


        //  $orders=Order::select('orders.id','users.firstname','users.lastname','orders.order_date','orders.grand_total','orders.status','orders.order_id','orders.paid_amount')->join('users','users.id','=','orders.user_id')->where('orders.status',2)->get();

         return view('admin.order.invoices',compact('order_no','customers','products','submenu','title','paymentmethods','paymentterms','salesreps','drivers','categories','units'));

        

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
                $query->whereHas('user',function($q) use($search){$q->where('firstname','LIKE','%'.$search.'%');$q->orWhere('lastname','LIKE','%'.$search.'%');$q->orWhere('business_name','LIKE','%'.$search.'%');})
                ->orWhereHas('order',function($q) use($f){$q->where('po_number',$f);})
                ->orWhere('invoice_number',$search); 
            });
            

        }

        if($store !=''){

            $invquery->where('customer_id',$store);

        }

         

             $invoices=$invquery->orderBy('id','desc')->paginate(10);

        
        
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

        return redirect(admin_url('invoices'));

        

    }
    public function cancelInvoice(Request $request)
    {
        $invoice=Invoice::find($request->id);
        $invoice->status=-1;
        $invoice->remarks=$request->remarks;
        $order=Order::find($invoice->order_id);
        $order->status=-1;
        $order->remarks=$request->remarks;
        try

         {
         
            $order->save();
            $invoice->save();
            $items=OrderItem::where('order_id',$invoice->order_id)->get();
            foreach($items as $item)
            {
                $product=Product::find($item->product_id);
                $product->qty+=$item->quantity;
                $product->save();
                $stock=Stock::where('product_id',$item->product_id)->first();
                $stock->quantity+=$item->quantity;
                $stock->save();
            }

          session()->flash('message','Invoice successfully cancelled');

        }

        catch(\Exception $e) {

            session()->flash('message','Unable to cancel the invoice');

        }
        return redirect()->back();
    }

    public function makepayment(Request $request)

    {
        die(print_r($request->all()));
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

        $invoice=Invoice::where('order_id',$order_id)->first();

        $invoice->paid_total=$invoice->paid_total+$request->amount_received;

        // $account=Account::where('user_id',$user_id)->first();

        // $account->credit=$account->credit+$request->amount_received;

        try

        {

            $orderpayment->save();

            $order->save();

            // $account->save();

            $invoice->save();

            session()->flash('message','Payment successfully updated');

        }

        catch(\Exception $e) {

            session()->flash('message','Unable to make payment');

        }

        return redirect()->back();

    }
    
    
    // Latest

    public function viewPO($id){

        $orders = Order::with('user')->where('id',$id)->get();
        $orderitems=OrderItem::join('products','products.id','=','order_items.product_id')->where('order_items.order_id',$id)->get();
        $submenu="Invoice";
        $title="Order";

        return view('admin.order.order-details',compact('orders','orderitems','submenu','title'));

    }


    

    public function orderDetails($id){

        $order         = Order::with('user','billing','delivery','item','driver','salesrep')->where('id',$id)->first() or abort(404);
        $orderitems     = $order->item;
        $submenu        = "Order";

        $title          = "Order";
        // die(print_r($orderitems));
        // if($order->status < 4)
        //     return view('admin.order.order-po-details',compact('order','orderitems','submenu','title'));
        // else
            return view('admin.order.order-details',compact('order','orderitems','submenu','title'));

    }

    public function assignDriver($id,$driverid)

    {

       $order=Order::find($id);

       $order->status=3;

       $order->driver_id=$driverid;

    

         $message=new Message();

         $message->sender_id=Auth::id();

         $message->sender_email=Auth::User()->email;

         $message->recipient_id=$order->user_id;

         $message->recipient_email=$order->email;

         $message->subject="Order Ready";

         $message->body_html="Your Order is Ready";

         $message->body_text="Your Order is Ready !..";

         $message->save();

       try {

        

            $order->save();

            session()->flash('message','Driver Assigned Successfully');

        }

        catch(\Exception $e) {

            session()->flash('message','Unable to change order status');

        }

        

         return redirect(admin_url('orders'));

    }

    public function saveBackOrder(Request $request)

    {

        $id=$request->orderidd;

        $order = Order::find($id) or abort(404);

        

        $order->user_id = $request->user_id1;

        // $order->order_id   =$request->order_id1;

        $order->email      = $request->email1;

        $order->order_date     = $request->order_date1;

        

        $order->shipping_date= $request->shipping_date1;

        $order->billing_address= $request->billing_address1;

        $order->shipping_address= $request->shipping_address1;

        $order->message= $request->message1;

        $order->discount_amount= $request->discount1;

        $order->discount_type= $request->discountt1;

        $order->discount=$request->discount_type1;

        

        $order->grand_total= $request->grand_total1;

        if($order->save())

        {

        OrderItem::where('order_id',$id)->delete();

        $prod_id=$request->product_id1;

        $stockprod=$request->stockprod;

        $subt=0;

        foreach($prod_id as $key=>$value)

        {

        $orderitem=new OrderItem();

        if($request->product_id1[$key] !=null)

        {

        $orderitem->order_id=$id;

        $orderitem->product_id=$request->product_id1[$key];

        $orderitem->quantity=$request->quantity1[$key];

        $orderitem->rate=$request->rate1[$key];

        $orderitem->total=$request->rate1[$key]*$request->quantity1[$key];

        $orderitem->save();

        $subt+=$request->rate1[$key]*$request->quantity1[$key];

        }

        }

        $fd=0;

        foreach($stockprod as $key=>$value)

        {

        if($request->backqty[$key] !=0 )

        {

        $fd=1;

        $orditem=OrderItem::where('order_id',$id)->where('product_id',$request->stockprod[$key])->first();

        $orditem->backqty=$request->backqty[$key];

        $orditem->backamount=$request->backqtyamount[$key];

        $orditem->save();

        }

        }

        if($fd==1)

        {

            $order->backorder_status='backorder';

            

        }

        $order->grand_total=$subt-$request->discount1;

        $order->status=2;

        $order->save();

        $items=OrderItem::where('order_id',$id)->get();

           foreach($items as $item)

           {

               $proqty=Product::find($item->product_id);

               $proqty->qty=$proqty->qty-$item->quantity;

               $proqty->save();

               $stock=Stock::where('product_id',$item->product_id)->first();

               $stock->quantity=$stock->quantity - $item->quantity;

               $stock->save();

           }

             $or=Order::with(['user'=>function($query){$query->with('paymentterm');}])->where('id',$order->id)->first();

             $da=date('Y-m-d');

             $invid=Invoice::max('invoice_number');

             $invoice=new Invoice();

             $invoice->invoice_number=$invid+1  ?? 10000;

             $invoice->order_id=$order->id;

             $invoice->due_date=date('Y-m-d', strtotime($da. ' + '.$or->user->paymentterm->value.' days'));

             $invoice->customer_id=$order->user_id;

             $invoice->status=0;

             $invoice->discount=$order->discount_amount;

             $invoice->grand_total=$order->grand_total;

             $invoice->paid_total=0;

             $invoice->save();

             

        session()->flash('message','Successfully updated the status');

         $message=new Message();

         $message->sender_id=Auth::id();

         $message->sender_email=Auth::User()->email;

         $message->recipient_id=$order->user_id;

         $message->recipient_email=$order->email;

         $message->subject="Order is Processing";

         $message->body_html="Your Order is Procssing";

         $message->body_text="Your Order is Procssing !..";

         $message->save();

         $items=OrderItem::where('order_id',$order->order_id)->get();

          foreach($items as $item)

          {

              $proqty=Product::find($item->product_id);

              $proqty->qty=$proqty->qty-$item->quantity;

              $proqty->save();

              $stock=Stock::where('product_id',$item->product_id)->first();

              $stock->quantity=$stock->quantity - $item->quantity;

              $stock->save();

          }

         

        }

        return redirect(admin_url('orders'));

        

    }

    public function orderApprovedDetails($id){

        $title="Order";

        $submenu="Order";

        $orders = Order::with('user')->where('id',$id)->get();

        $orderitems = OrderItem::with('stock')->join('products','products.id','=','order_items.product_id')->where('order_items.order_id',$id)->get();

        return view('admin.order.approved-order-details',compact('title','submenu','orders','orderitems'));

    }


    public function backorder()
    {
        $submenu    =   "Backorder";
        $title      =   "Backorder";
        $orders     =   Order::with('item','user')->where('status',0)->get();
        $salesreps=User::where('customer_type',5)->get();

        $paymentterms = PaymentTerm::get();
        
        $drivers=User::where(['type'=>'staff','status'=>1,'customer_type'=>3])->get(); 
        
        $categories = Category::where('status',1)->get();
        
        $units      = Unit::where('status',1)->get();
        return view('admin.order.backorder',compact('orders','submenu','title','salesreps','paymentterms','drivers','categories','units'));
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
                $query->whereHas('user',function($q) use($search){$q->where('firstname','LIKE','%'.$search.'%');$q->orWhere('lastname','LIKE','%'.$search.'%');$q->orWhere('business_name','LIKE','%'.$search.'%');})
                ->orWhere('po_number',$f);
            });
            

        }

         

             $orders=$ordquery->where('status',0)->paginate(10);

        
        
         return [
            'data' => OrderResource::collection($orders),
            'links' => (string) $orders->links(),
        ];
    }

    public function viewBackorder($id)
    {
        $submenu="Invoice";
        $title="Backorder";
        
        $order      = Order::with(['item'=> function($query){$query->with('product');},'user','billing'])
                                                            ->where(['status'=>0,'id'=>$id])->first() or abort(404);
        $customer = $order->user;
        
        return view('admin.order.viewbackorder',compact('order','customer','submenu','title'));
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

    

    public function generatePDF1()

    {

        $data = [

            'title' => 'Welcome to ItSolutionStuff.com',

            'date' => date('m/d/Y')

        ];

        //  die(print_r($data));

        $pdf = PDF::loadView('admin.order.testpdf', $data);

    

        return $pdf->download('itsolutionstuff.pdf');

    }



    public function createPO(Request $request) {

        // die(print_r($request->all()));

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
                
                $order->po_number   = $ponumber;

                $order->user_id     = $user->id;

                $order->email       = $user->email;

                $order->order_date  = date('Y-m-d');

                $order->due_date    = $request->due_date;

                $order->sales_rep   = $request->sales_rep;

                $order->status      = 1;

                $order->driver_id   = $request->driver_id;
                
                if($request->driver_id !='')
                {
                    $order->assign_driver   = 1;
                }

                $order->shipping_date = $request->delivery_date;

                $order->message     = $request->message;

                $order->notes       = $request->notes;

                $order->billing_id  = $billing->id;

                $order->delivery_id = $delivery->id;
                
                $order->discount_amount = $request->discount;
                
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
            $tax = getTax();
            $discount=0;
            $total_quantity=0;
                foreach($request->product_names as $key=>$val) {

                    if($order && !empty($request->product_ids[$key]) && !empty($request->quantities[$key])) {

                        $cid = $request->customer_id;

                        if($product = Product::with(['customer_price'=>function($q) use ($cid) {
                            $q->where('customer_id',$cid)->where('status',1)->first();
                        }])->where('id',$request->product_ids[$key])->first()) {

                            $price = $product->customer_price->count() ? $product->customer_price->first()->price:$product->price;
                            
                            if($product->price_by == 'weight') 
                            {
                                $itemtotal = ($request->quantities[$key]*$product->weight) * $price;
                            }
                            elseif($product->price_by == 'quantity') 
                            {
                                $itemtotal = ($request->quantities[$key] * $price);
                            }
                            else
                            {
                                $itemtotal = 0;
                            }

                            $item = new OrderItem();

                            $item->order_id         = $order->id;

                            $item->product_id       = $product->id;

                            $item->product_name     = $request->product_names[$key];

                            $item->product_sku      = $product->sku;
                            
                            $item->product_description = $request->product_description[$key];

                            $item->rate             = $price;

                            $item->price_by         = $product->price_by;
                            
                            $item->weight           = $request->quantities[$key]*$product->weight;

                            $item->quantity         = $request->quantities[$key];
                            
                            $item->total            = $itemtotal;
                            
                            $item->tax              = ($tax*$itemtotal)/100;
                            
                            $item->original_rate    =$product->price;


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

                $order->tax         = ($grand_total+$shipping-$discount) * ($tax / 100);
                $order->grand_total = $grand_total + $shipping + $order->tax - $discount;
                $order->total_quantity=$total_quantity;
                $order->save();

                return response()->json(['status'=>'success','data'=>$order, 'message'=>'Order successfully created!']);

            }



            

        }



        return response()->json(['status'=>'fail','data'=> $request->all(), 

                                                    'message'=>'Failed to create the order, Please contact support!']);



    }
    
    
    
    public function createInvoice(Request $request) {



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
                
                $order->po_number   = $ponumber;

                $order->user_id     = $user->id;

                $order->email       = $user->email;

                $order->order_date  = date('Y-m-d');

                $order->due_date    = $request->due_date;

                $order->sales_rep   = $request->sales_rep;

                $order->status      = 4;

                $order->driver_id   = $request->driver_id;

                $order->shipping_date = $request->delivery_date;

                $order->message     = $request->message;

                $order->notes       = $request->notes;

                $order->billing_id  = $billing->id;

                $order->delivery_id = $delivery->id;
                
                $order->discount_amount = $request->discount;
                
                $order->terms = $request->terms;
                
                $order->shipping=$shipping;
                
                if($request->driver_id !='')
                {
                    $runsheet=Runsheet::where(['delivery_date'=>$request->delivery_date,'driver_id'=>$request->driver_id,'status'=>0])->first();
                    if(isset($runsheet))
                    {
                        $order->driver_id=$request->driver_id;
                        $order->runsheet_id=$runsheet->id;
                        $order->status=5;
                        $order->assign_driver=1;
                        
                    }
                    else
                    {
                        $runsheet = new Runsheet();
                        $runsheet->delivery_date    = $request->delivery_date;
                        $runsheet->driver_id        = $request->driver_id;
                        // $runsheet->route            = $request->route[$key];
                        $runsheet->save();
                        $order->driver_id=$driver_id;
                        $order->runsheet_id=$runsheet->id;
                        $order->status=5;
                        $order->assign_driver=1;
                    }
                }
            

                $itemcount = 0;



                try {

                    $order->save();

                }

                catch(\Exception $e) {



                    return response()->json(['status'=>'fail','data'=>$e->getMessage(), 

                                                 'message'=>'Failed to create the order, Please contact support!']);

                }


            $grand_total = 0;
            $tax = getTax();
            $total_quantity=0;
                foreach($request->product_names as $key=>$val) {

                    if($order && !empty($request->product_ids[$key]) && !empty($request->quantities[$key])) {

                        if($product = Product::find($request->product_ids[$key])) {
                            
                            if($product->price_by == 'weight' && isset($request->weights[$key])) 
                            {
                                $itemtotal = (storeQuantity($request->weights[$key]) * storeRate($request->rates[$key]));
                            }
                            elseif($product->price_by == 'quantity' && isset($request->quantities[$key])) 
                            {
                                $itemtotal = ($request->quantities[$key] * storeRate($request->rates[$key]));
                            }
                            else
                            {
                                $itemtotal = 0;
                            }

                            $item = new OrderItem();

                            $item->order_id         = $order->id;

                            $item->product_id       = $product->id;

                            $item->product_name     = $request->product_names[$key];

                            $item->product_sku      = $product->sku;
                            
                            $item->product_description = $request->product_description[$key];

                            $item->rate             = storeRate($request->rates[$key]);

                            $item->price_by         = $product->price_by;
                            
                            $item->weight           = storeQuantity($request->weights[$key]);

                            $item->quantity         = $request->quantities[$key];
                            
                            $item->total            = $itemtotal;
                            
                            $item->original_rate    =$product->price;
                            
                            $item->tax              = ($tax*$itemtotal)/100;


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

                $order->tax         = ($grand_total+$shipping-$request->discount) * ($tax / 100);
                $order->grand_total = $grand_total + $shipping + $order->tax - $request->discount;
                $order->total_quantity=$total_quantity;
                $order->save();
                
            $todayinvoice=Invoice::whereDate('created_at',date('Y-m-d'))->count();
                
            $t=sprintf('%03u', $todayinvoice+1);
            
            $invnumber=date('y').date('m').date('d').$t;

            $invoice = new Invoice();

            $invoice->invoice_number = $invnumber;
            $invoice->order_id       = $order->id;
            $invoice->due_date       = $order->due_date;
            $invoice->customer_id    = $order->user_id;
            $invoice->status         = 0;
            $invoice->payment_method = 'cash';
            $invoice->reference_number = Null;
            $invoice->transaction_id = Null;
            $invoice->sub_total      = $grand_total;
            $invoice->tax            = $order->tax;
            $invoice->discount       = $order->discount_amount;
            $invoice->shipping       = 0;
            $invoice->grand_total    = $order->grand_total;
            $invoice->paid_total     = 0;

            $invoice->save();
            
            $orders=Order::with('invoice','user','item')->find($order->id);

                return response()->json(['status'=>'success','data1'=>$orders, 'message'=>'Invoice successfully created!']);

            }



            

        }



        return response()->json(['status'=>'fail','data'=> $request->all(), 

                                                    'message'=>'Failed to create the order, Please contact support!']);



    }
    
    
     public function saveSendInv(Request $request) {



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
                
                $order->po_number   = $ponumber;

                $order->user_id     = $user->id;

                $order->email       = $user->email;

                $order->order_date  = date('Y-m-d');

                $order->due_date    = $request->due_date;

                $order->sales_rep   = $request->sales_rep;

                $order->status      = 4;

                $order->driver_id   = $request->driver_id;

                $order->shipping_date = $request->delivery_date;

                $order->message     = $request->message;

                $order->notes       = $request->notes;

                $order->billing_id  = $billing->id;

                $order->delivery_id = $delivery->id;
                
                $order->discount_amount = $request->discount;
                
                $order->terms = $request->terms;
                
                $order->shipping=$shipping;
                
                if($request->driver_id !='')
                {
                    $runsheet=Runsheet::where(['delivery_date'=>$request->delivery_date,'driver_id'=>$request->driver_id,'status'=>0])->first();
                    if(isset($runsheet))
                    {
                        $order->driver_id=$request->driver_id;
                        $order->runsheet_id=$runsheet->id;
                        $order->status=5;
                        $order->assign_driver=1;
                        
                    }
                    else
                    {
                        $runsheet = new Runsheet();
                        $runsheet->delivery_date    = $request->delivery_date;
                        $runsheet->driver_id        = $request->driver_id;
                        // $runsheet->route            = $request->route[$key];
                        $runsheet->save();
                        $order->driver_id=$driver_id;
                        $order->runsheet_id=$runsheet->id;
                        $order->status=5;
                        $order->assign_driver=1;
                    }
                }
            

                $itemcount = 0;



                try {

                    $order->save();

                }

                catch(\Exception $e) {



                    return response()->json(['status'=>'fail','data'=>$e->getMessage(), 

                                                 'message'=>'Failed to create the order, Please contact support!']);

                }


            $grand_total = 0;
            $tax = getTax();
            $total_quantity=0;
                foreach($request->product_names as $key=>$val) {

                    if($order && !empty($request->product_ids[$key]) && !empty($request->quantities[$key])) {

                        if($product = Product::find($request->product_ids[$key])) {
                            
                            if($product->price_by == 'weight' && isset($request->weights[$key])) 
                            {
                                $itemtotal = (storeQuantity($request->weights[$key]) * storeRate($request->rates[$key]));
                            }
                            elseif($product->price_by == 'quantity' && isset($request->quantities[$key])) 
                            {
                                $itemtotal = ($request->quantities[$key] * storeRate($request->rates[$key]));
                            }
                            else
                            {
                                $itemtotal = 0;
                            }

                            $item = new OrderItem();

                            $item->order_id         = $order->id;

                            $item->product_id       = $product->id;

                            $item->product_name     = $request->product_names[$key];

                            $item->product_sku      = $product->sku;
                            
                            $item->product_description = $request->product_description[$key];

                            $item->rate             = storeRate($request->rates[$key]);

                            $item->price_by         = $product->price_by;
                            
                            $item->weight           = storeQuantity($request->weights[$key]);

                            $item->quantity         = $request->quantities[$key];
                            
                            $item->total            = $itemtotal;
                            
                            $item->original_rate    =$product->price;
                            
                            $item->tax              = ($tax*$itemtotal)/100;


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

                $order->tax         = ($grand_total+$shipping-$request->discount) * ($tax / 100);
                $order->grand_total = $grand_total + $shipping + $order->tax - $request->discount;
                $order->total_quantity=$total_quantity;
                $order->save();
                
            $todayinvoice=Invoice::whereDate('created_at',date('Y-m-d'))->count();
                
            $t=sprintf('%03u', $todayinvoice+1);
            
            $invnumber=date('y').date('m').date('d').$t;

            $invoice = new Invoice();

            $invoice->invoice_number = $invnumber;
            $invoice->order_id       = $order->id;
            $invoice->due_date       = $order->due_date;
            $invoice->customer_id    = $order->user_id;
            $invoice->status         = 0;
            $invoice->payment_method = 'cash';
            $invoice->reference_number = Null;
            $invoice->transaction_id = Null;
            $invoice->sub_total      = $grand_total;
            $invoice->tax            = $order->tax;
            $invoice->discount       = $order->discount_amount;
            $invoice->shipping       = 0;
            $invoice->grand_total    = $order->grand_total;
            $invoice->paid_total     = 0;

            $invoice->save();

                return response()->json(['status'=>'success','data'=>$order, 'message'=>'Invoice successfully created!']);

            }



            

        }



        return response()->json(['status'=>'fail','data'=> $request->all(), 

                                                    'message'=>'Failed to create the order, Please contact support!']);



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
            $order->driver_id       = $request->driver_id;
            $order->shipping_date   = $request->delivery_date;
            $order->message         = $request->message;
            $order->discount_amount = $request->discount;
            $order->notes           = $request->notes;
            $order->billing_id      = $billing->id;
            $order->delivery_id     = $delivery->id;
            if($request->driver_id !='')
            {
               $order->assign_driver=1;
            }
            else
            {
                $order->assign_driver=0;
            }

            try 
            {
                $order->save();
            }
            catch(\Exception $e) {
                return response()->json(['status'=>'fail','data'=>$e->getMessage(), 
                                 'message'=>'Error While processing the order #100, Please contact support!']);
            } 

            OrderItem::where('order_id',$order->id)->delete();

            $grand_total = 0;
            $tax = getTax();
            $discount=0;
            $total_quantity=0;
            $shipping=0;
            foreach($request->product_names as $key=>$val) {
                if(!empty($request->product_ids[$key]) && !empty($request->quantities[$key]) && $request->quantities[$key]>0) {
                    if($product = Product::find($request->product_ids[$key])) {

                        if($product->price_by == 'weight') 
                            $itemtotal = ($request->quantities[$key]*$product->weight) * $product->price;
                        elseif($product->price_by == 'quantity' && isset($request->quantities[$key])) 
                            $itemtotal = $request->quantities[$key] * $product->price;
                        else
                            $itemtotal = 0;

                        $item = new OrderItem();
                        $item->order_id            = $order->id;
                        $item->product_id          = $product->id;
                        $item->product_name        = $request->product_names[$key];
                        $item->product_sku         = $product->sku;
                        $item->rate                = $product->price;
                        $item->price_by            = $product->price_by;
                        $item->product_description = $request->product_description[$key];
                        $item->quantity            = $request->quantities[$key];
                        $item->weight              = $request->quantities[$key]*$product->weight;
                        $item->total               = $itemtotal;
                        $item->tax              = ($tax*$itemtotal)/100;
                        $item->original_rate    =$product->price;

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
            $order->tax         = ($grand_total+$shipping-$discount) * ($tax / 100);
            $order->grand_total = $grand_total + $shipping + $order->tax - $discount;
            $order->total_quantity=$total_quantity;
            $order->save();
            
            

            

            return response()->json(['status'=>'success','data'=> $order, 
                                                         'message'=>'Successfully updated the order!']);
        }

        return response()->json(['status'=>'fail','data'=> $request->all(), 
                                                    'message'=>'Failed to update the order #106, Please contact support!']);
    }


    public function editInvoice(Request $request) {

        //return response()->json($request->all());

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
            $order->driver_id       = $request->driver_id;
            $order->shipping_date   = $request->delivery_date;
            $order->message         = $request->message;
            $order->discount_amount = $request->discount;
            $order->notes           = $request->notes;
            $order->billing_id      = $billing->id;
            $order->delivery_id     = $delivery->id;
            if($request->driver_id !='')
            {
               $order->assign_driver=1;
            }
            else
            {
                $order->assign_driver=0;
            }

            try 
            {
                $order->save();
            }
            catch(\Exception $e) {
                return response()->json(['status'=>'fail','data'=>$e->getMessage(), 
                                 'message'=>'Error While processing the order #100, Please contact support!']);
            } 

            OrderItem::where('order_id',$order->id)->delete();

            $grand_total = 0;
            $tax = getTax();
            $discount=0;
            $total_quantity=0;
            $shipping=0;
            foreach($request->product_names as $key=>$val) {
                if(!empty($request->product_ids[$key]) && !empty($request->quantities[$key]) && $request->quantities[$key]>0) {
                    if($product = Product::find($request->product_ids[$key])) {

                        if($product->price_by == 'weight') 
                            $itemtotal = ($request->quantities[$key]*$product->weight) * $product->price;
                        elseif($product->price_by == 'quantity' && isset($request->quantities[$key])) 
                            $itemtotal = $request->quantities[$key] * $product->price;
                        else
                            $itemtotal = 0;

                        $item = new OrderItem();
                        $item->order_id            = $order->id;
                        $item->product_id          = $product->id;
                        $item->product_name        = $request->product_names[$key];
                        $item->product_sku         = $product->sku;
                        $item->rate                = $product->price;
                        $item->price_by            = $product->price_by;
                        $item->product_description = $request->product_description[$key];
                        $item->quantity            = $request->quantities[$key];
                        $item->weight              = $request->quantities[$key]*$product->weight;
                        $item->total               = $itemtotal;
                        $item->tax              = ($tax*$itemtotal)/100;
                        $item->original_rate    =$product->price;

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
            $order->tax         = ($grand_total+$shipping-$discount) * ($tax / 100);
            $order->grand_total = $grand_total + $shipping + $order->tax - $discount;
            $order->total_quantity=$total_quantity;
            $order->save();

            $invoice = Invoice::where('order_id',$order->id)->first();

            $invoice->due_date       = $order->due_date;
            $invoice->customer_id    = $order->user_id;
            $invoice->status         = 0;
            $invoice->payment_method = 'cash';
            $invoice->reference_number = Null;
            $invoice->transaction_id = Null;
            $invoice->sub_total      = $grand_total;
            $invoice->tax            = $order->tax;
            $invoice->discount       = $order->discount_amount;
            $invoice->shipping       = 0;
            $invoice->grand_total    = $order->grand_total;
            $invoice->paid_total     = 0;

            $invoice->save();

            return response()->json(['status'=>'success','data'=> $order, 
                                                         'message'=>'Successfully updated the invoice!']);
        }

        return response()->json(['status'=>'fail','data'=> $request->all(), 
                                                    'message'=>'Failed to update the invoice, Please contact support!']);
    }
    
    public function processPO(Request $request) {

        if($order = Order::whereIn('status',[1,2,3])->where('id',$request->order_id)->where('user_id',$request->customer_id)->first()) {
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
                
            $order->order_date      = $request->order_date;
            $order->due_date        = $request->due_date;
            $order->sales_rep       = $request->sales_rep;
            $order->status          = 4;
            $order->driver_id       = $request->driver_id;
            $order->shipping_date   = $request->delivery_date;
            $order->message         = $request->message;
            $order->discount_amount = $request->discount;
            $order->notes           = $request->notes;
            $order->billing_id      = $billing->id;
            $order->delivery_id     = $delivery->id;
            if($request->driver_id !='')
                {
                    $runsheet=Runsheet::where(['delivery_date'=>$request->delivery_date,'driver_id'=>$request->driver_id,'status'=>0])->first();
                    if(isset($runsheet))
                    {
                        $order->driver_id=$request->driver_id;
                        $order->runsheet_id=$runsheet->id;
                        $order->status=5;
                        $order->assign_driver=1;
                        
                    }
                    else
                    {
                        $runsheet = new Runsheet();
                        $runsheet->delivery_date    = $request->delivery_date;
                        $runsheet->driver_id        = $request->driver_id;
                        // $runsheet->route            = $request->route[$key];
                        $runsheet->save();
                        $order->driver_id=$driver_id ?? 0;
                        $order->runsheet_id=$runsheet->id;
                        $order->status=5;
                        $order->assign_driver=1;
                    }
                }
                else
                {
                    $order->driver_id=NULL;
                    $order->assign_driver=0;
                    $order->runsheet_id=NULL;
                }

            try {
                $order->save();
            }
            catch(\Exception $e) {
                return response()->json(['status'=>'fail','data'=>$e->getMessage(), 
                                 'message'=>'Error While processing the order #100, Please contact support!']);
            } 

            OrderItem::where('order_id',$order->id)->delete();

            $backorderqty = 0;
            $grand_total = 0;
            $tax = getTax();
            $total_quantity=0;
            $shipping=0;
            foreach($request->product_names as $key=>$val) {
                if(!empty($request->product_ids[$key]) && !empty($request->quantities[$key]) && $request->quantities[$key]>0) {
                    if($product = Product::find($request->product_ids[$key])) {

                        if($product->price_by == 'weight' && isset($request->weights[$key])) 
                            $itemtotal = (storeQuantity($request->weights[$key]) * storeRate($request->rates[$key]));
                        elseif($product->price_by == 'quantity' && isset($request->quantities[$key])) 
                            $itemtotal = ($request->quantities[$key] * storeRate($request->rates[$key]));
                        else
                            $itemtotal = 0;

                        $item = new OrderItem();
                        $item->order_id         = $order->id;
                        $item->product_id       = $product->id;
                        $item->product_name     = $request->product_names[$key];
                        $item->product_sku      = $product->sku;
                        $item->rate             = storeRate($request->rates[$key]);
                        $item->price_by         = $product->price_by;
                        $item->product_description = $request->product_names[$key];
                        $item->quantity         = $request->quantities[$key];
                        $item->weight           = storeQuantity($request->weights[$key]);
                        $item->total            = $itemtotal;
                        $item->tax              = ($tax*$itemtotal)/100;
                        $item->original_rate    =$product->price;

                        try {
                            $item->save();
                            $product->qty-=$request->quantities[$key];
                            $product->save();
                            $stock=Stock::where('product_id',$product->id)->first();
                            $stock->quantity-=$request->quantities[$key];
                            $stock->save();
                            $total_quantity+=$request->quantities[$key];
                            $grand_total += $itemtotal;
                        }
                        catch(\Exception $e) {
                            return response()->json(['status'=>'fail','data'=>$e->getMessage(), 
                                             'message'=>'Failed to process the order #101, Please contact support!']);
                        } 
                    }
                }

                if($request->backorderquantities[$key] != '' && $request->backorderquantities[$key] > 0) {
                    $backorderqty++;
                }
            }

           
            $order->shipping=$shipping;
            $order->tax         = ($grand_total+$shipping-$request->discount) * ($tax / 100);
            $order->grand_total = $grand_total + $shipping + $order->tax - $request->discount;
            $order->total_quantity=$total_quantity;
            $order->save();
            
            $todayinvoice=Invoice::whereDate('created_at',date('Y-m-d'))->count();
                
            $t=sprintf('%03u', $todayinvoice+1);
            
            $invnumber=date('y').date('m').date('d').$t;

            $invoice = new Invoice();

            $invoice->invoice_number = $invnumber;
            $invoice->order_id       = $order->id;
            $invoice->due_date       = $order->due_date;
            $invoice->customer_id    = $order->user_id;
            $invoice->status         = 0;
            $invoice->payment_method = 'cash';
            $invoice->reference_number = Null;
            $invoice->transaction_id = Null;
            $invoice->sub_total      = $grand_total;
            $invoice->tax            = $order->tax;
            $invoice->discount       = $order->discount_amount;
            $invoice->shipping       = 0;
            $invoice->grand_total    = $order->grand_total;
            $invoice->paid_total     = 0;

            $invoice->save();

            // $invoice->invoice_number = 'FH'.sprintf("%06d",$invoice->id);
            // $invoice->save();


            if($backorderqty > 0) {
                $backorder = new Order();
                $backorder->user_id     = $order->user_id;
                $backorder->email       = $order->email;
                $backorder->order_date  = date('Y-m-d');
                $backorder->due_date    = $order->due_date;
                $backorder->sales_rep   = $order->sales_rep;
                $backorder->status      = 0;
                $backorder->driver_id   = $order->driver_id;
                $backorder->shipping_date = $order->shipping_date;
                $backorder->message     = $order->message;
                $backorder->notes       = $order->notes;
                $backorder->billing_id  = $order->billing_id;
                $backorder->delivery_id = $order->delivery_id;
                $backorder->terms       = $order->terms;

                try {
                    $backorder->save();
                }
                catch(\Exception $e) {
                    return response()->json(['status'=>'fail','data'=>$e->getMessage(), 
                                             'message'=>'Failed to create the backorder #102, Please contact support!']);
                }

                foreach($request->product_names as $key=>$val) {
                    if(!empty($request->product_ids[$key]) && !empty($request->backorderquantities[$key]) 
                                                                        && $request->backorderquantities[$key]>0) {

                        if($product = Product::find($request->product_ids[$key])) {

                            $item = new OrderItem();
                            $item->order_id         = $backorder->id;
                            $item->product_id       = $product->id;
                            $item->product_name     = $product->name;
                            $item->product_sku      = $product->sku;
                            $item->rate             = $product->price;
                            $item->price_by         = $product->price_by;
                            $item->quantity         = $request->backorderquantities[$key];

                            try {
                                $item->save();
                            }
                            catch(\Exception $e) {
                                $backorder->delete();
                                return response()->json(['status'=>'fail','data'=>$e->getMessage(), 
                                                         'message'=>'Failed to create the backorder item #104, Please contact support!']);
                            }
                        }
                    }
                }
            }
           $orders=Order::with('invoice','user','item')->find($order->id);

            return response()->json(['status'=>'success','data1'=> $orders, 
                                                         'message'=>'Successfully processed the order!']);
        }

        return response()->json(['status'=>'fail','data'=> $request->all(), 
                                                    'message'=>'Failed to create the order #106, Please contact support!']);
    }
    public function saveSendPO(Request $request) {

        if($order = Order::whereIn('status',[1,2,3])->where('id',$request->order_id)->where('user_id',$request->customer_id)->first()) {
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
                
            $order->order_date      = $request->order_date;
            $order->due_date        = $request->due_date;
            $order->sales_rep       = $request->sales_rep;
            $order->status          = 4;
            $order->driver_id       = $request->driver_id;
            $order->shipping_date   = $request->delivery_date;
            $order->message         = $request->message;
            $order->discount_amount = $request->discount;
            $order->notes           = $request->notes;
            $order->billing_id      = $billing->id;
            $order->delivery_id     = $delivery->id;
            if($request->driver_id !='')
                {
                    $runsheet=Runsheet::where(['delivery_date'=>$request->delivery_date,'driver_id'=>$request->driver_id,'status'=>0])->first();
                    if(isset($runsheet))
                    {
                        $order->driver_id=$request->driver_id;
                        $order->runsheet_id=$runsheet->id;
                        $order->status=5;
                        $order->assign_driver=1;
                        
                    }
                    else
                    {
                        $runsheet = new Runsheet();
                        $runsheet->delivery_date    = $request->delivery_date;
                        $runsheet->driver_id        = $request->driver_id;
                        // $runsheet->route            = $request->route[$key];
                        $runsheet->save();
                        $order->driver_id=$driver_id;
                        $order->runsheet_id=$runsheet->id;
                        $order->status=5;
                        $order->assign_driver=1;
                    }
                }
                else
                {
                    $order->driver_id=NULL;
                    $order->assign_driver=0;
                    $order->runsheet_id=NULL;
                }

            try {
                $order->save();
            }
            catch(\Exception $e) {
                return response()->json(['status'=>'fail','data'=>$e->getMessage(), 
                                 'message'=>'Error While processing the order #100, Please contact support!']);
            } 

            OrderItem::where('order_id',$order->id)->delete();

            $backorderqty = 0;
            $grand_total = 0;
            $tax = getTax();
            $total_quantity=0;
            $shipping=0;
            foreach($request->product_names as $key=>$val) {
                if(!empty($request->product_ids[$key]) && !empty($request->quantities[$key]) && $request->quantities[$key]>0) {
                    if($product = Product::find($request->product_ids[$key])) {

                        if($product->price_by == 'weight' && isset($request->weights[$key])) 
                            $itemtotal = (storeQuantity($request->weights[$key]) * storeRate($request->rates[$key]));
                        elseif($product->price_by == 'quantity' && isset($request->quantities[$key])) 
                            $itemtotal = ($request->quantities[$key] * storeRate($request->rates[$key]));
                        else
                            $itemtotal = 0;

                        $item = new OrderItem();
                        $item->order_id         = $order->id;
                        $item->product_id       = $product->id;
                        $item->product_name     = $request->product_names[$key];
                        $item->product_sku      = $product->sku;
                        $item->rate             = storeRate($request->rates[$key]);
                        $item->price_by         = $product->price_by;
                        $item->product_description = $request->product_description[$key];
                        $item->quantity         = $request->quantities[$key];
                        $item->weight           = storeQuantity($request->weights[$key]);
                        $item->total            = $itemtotal;
                        $item->tax              = ($tax*$itemtotal)/100;
                        $item->original_rate    =$product->price;

                        try {
                            $item->save();
                            $product->qty-=$request->quantities[$key];
                            $product->save();
                            $stock=Stock::where('product_id',$product->id)->first();
                            $stock->quantity-=$request->quantities[$key];
                            $stock->save();
                            $total_quantity+=$request->quantities[$key];
                            $grand_total += $itemtotal;
                        }
                        catch(\Exception $e) {
                            return response()->json(['status'=>'fail','data'=>$e->getMessage(), 
                                             'message'=>'Failed to process the order #101, Please contact support!']);
                        } 
                    }
                }

                if($request->backorderquantities[$key] != '' && $request->backorderquantities[$key] > 0) {
                    $backorderqty++;
                }
            }

           
            $order->shipping=$shipping;
            $order->tax         = ($grand_total+$shipping-$request->discount) * ($tax / 100);
            $order->grand_total = $grand_total + $shipping + $order->tax - $request->discount;
            $order->total_quantity=$total_quantity;
            $order->save();
            
            $todayinvoice=Invoice::whereDate('created_at',date('Y-m-d'))->count();
                
            $t=sprintf('%03u', $todayinvoice+1);
            
            $invnumber=date('y').date('m').date('d').$t;

            $invoice = new Invoice();

            $invoice->invoice_number = $invnumber;
            $invoice->order_id       = $order->id;
            $invoice->due_date       = $order->due_date;
            $invoice->customer_id    = $order->user_id;
            $invoice->status         = 0;
            $invoice->payment_method = 'cash';
            $invoice->reference_number = Null;
            $invoice->transaction_id = Null;
            $invoice->sub_total      = $grand_total;
            $invoice->tax            = $order->tax;
            $invoice->discount       = $order->discount_amount;
            $invoice->shipping       = 0;
            $invoice->grand_total    = $order->grand_total;
            $invoice->paid_total     = 0;

            $invoice->save();

            // $invoice->invoice_number = 'FH'.sprintf("%06d",$invoice->id);
            // $invoice->save();


            if($backorderqty > 0) {
                $backorder = new Order();
                $backorder->user_id     = $order->user_id;
                $backorder->email       = $order->email;
                $backorder->order_date  = date('Y-m-d');
                $backorder->due_date    = $order->due_date;
                $backorder->sales_rep   = $order->sales_rep;
                $backorder->status      = 0;
                $backorder->driver_id   = $order->driver_id;
                $backorder->shipping_date = $order->shipping_date;
                $backorder->message     = $order->message;
                $backorder->notes       = $order->notes;
                $backorder->billing_id  = $order->billing_id;
                $backorder->delivery_id = $order->delivery_id;
                $backorder->terms       = $order->terms;

                try {
                    $backorder->save();
                }
                catch(\Exception $e) {
                    return response()->json(['status'=>'fail','data'=>$e->getMessage(), 
                                             'message'=>'Failed to create the backorder #102, Please contact support!']);
                }

                foreach($request->product_names as $key=>$val) {
                    if(!empty($request->product_ids[$key]) && !empty($request->backorderquantities[$key]) 
                                                                        && $request->backorderquantities[$key]>0) {

                        if($product = Product::find($request->product_ids[$key])) {

                            $item = new OrderItem();
                            $item->order_id         = $backorder->id;
                            $item->product_id       = $product->id;
                            $item->product_name     = $product->name;
                            $item->product_sku      = $product->sku;
                            $item->rate             = $product->price;
                            $item->price_by         = $product->price_by;
                            $item->quantity         = $request->backorderquantities[$key];

                            try {
                                $item->save();
                            }
                            catch(\Exception $e) {
                                $backorder->delete();
                                return response()->json(['status'=>'fail','data'=>$e->getMessage(), 
                                                         'message'=>'Failed to create the backorder item #104, Please contact support!']);
                            }
                        }
                    }
                }
            }

            try {
                if($request->email != '') {
                    Mail::to($request->email)->send(new InvoiceSent($order));
                }
            }
            catch(\Exception $e) {

            }
             
            return response()->json(['status'=>'success','data'=> $order, 
                                                         'message'=>'Successfully processed the order!']);
        }

        return response()->json(['status'=>'fail','data'=> $request->all(), 
                                                    'message'=>'Failed to create the order #106, Please contact support!']);
    }
    
    
    // public function savePO(Request $request) {

    //     if($order = Order::whereIn('status',[1,2,3])->where('id',$request->order_id)->where('user_id',$request->customer_id)->first()) {
    //         $billing = Address::where('id',$order->billing_id)->first();
    //         $delivery= Address::where('id',$order->delivery_id)->first();
            

    //             $billing->address       = $request->address1;

    //             $billing->postalcode    = $request->postalcode;

    //             $billing->city          = $request->city;

    //             $billing->province      = $request->province;

                
                
    //             $billing->save();



                

    //             $delivery->type          = 'delivery';

    //             $delivery->address       = $request->delivery_address1;

    //             $delivery->postalcode    = $request->delivery_postalcode;

    //             $delivery->city          = $request->delivery_city;

    //             $delivery->province      = $request->delivery_province;

                
                
    //             $delivery->save();
                
    //         $order->order_date      = $request->order_date;
    //         $order->due_date        = $request->due_date;
    //         $order->sales_rep       = $request->sales_rep;
    //         $order->status          = 2;
    //         $order->driver_id       = $request->driver_id;
    //         $order->shipping_date   = $request->delivery_date;
    //         $order->message         = $request->message;
    //         $order->discount_amount = $request->discount;
    //         $order->notes           = $request->notes;
    //         $order->billing_id      = $billing->id;
    //         $order->delivery_id     = $delivery->id;
            

    //         try {
    //             $order->save();
    //         }
    //         catch(\Exception $e) {
    //             return response()->json(['status'=>'fail','data'=>$e->getMessage(), 
    //                              'message'=>'Error While processing the order #100, Please contact support!']);
    //         } 

    //         OrderItem::where('order_id',$order->id)->delete();

    //         $backorderqty = 0;
    //         $grand_total = 0;
    //         $tax = getTax();
    //         $total_quantity=0;
    //         $shipping=0;
    //         foreach($request->product_names as $key=>$val) {
    //             if(!empty($request->product_ids[$key]) && !empty($request->quantities[$key]) && $request->quantities[$key]>0) {
    //                 if($product = Product::find($request->product_ids[$key])) {

    //                     if($product->price_by == 'weight' && isset($request->weights[$key])) 
    //                         $itemtotal = (storeQuantity($request->weights[$key]) * storeRate($request->rates[$key]));
    //                     elseif($product->price_by == 'quantity' && isset($request->quantities[$key])) 
    //                         $itemtotal = ($request->quantities[$key] * storeRate($request->rates[$key]));
    //                     else
    //                         $itemtotal = 0;

    //                     $item = new OrderItem();
    //                     $item->order_id         = $order->id;
    //                     $item->product_id       = $product->id;
    //                     $item->product_name     = $product->name;
    //                     $item->product_sku      = $product->sku;
    //                     $item->rate             = storeRate($request->rates[$key]);
    //                     $item->price_by         = $product->price_by;
    //                     $item->product_description = $product->description;
    //                     $item->quantity         = $request->quantities[$key];
    //                     $item->weight           = storeQuantity($request->weights[$key]);
    //                     $item->total            = $itemtotal;
    //                     $item->tax              = ($tax*$itemtotal)/100;
    //                     $item->original_rate    =$product->price;

    //                     try {
    //                         $item->save();
    //                         $total_quantity+=$request->quantities[$key];
    //                         $grand_total += $itemtotal;
    //                     }
    //                     catch(\Exception $e) {
    //                         return response()->json(['status'=>'fail','data'=>$e->getMessage(), 
    //                                          'message'=>'Failed to process the order #101, Please contact support!']);
    //                     } 
    //                 }
    //             }
    //             if($request->backorderquantities[$key] != '' && $request->backorderquantities[$key] > 0) {
    //                 $backorderqty++;
    //             }

                
    //         }

           
    //         $order->shipping=$shipping;
    //         $order->tax         = ($grand_total+$shipping-$request->discount) * ($tax / 100);
    //         $order->grand_total = $grand_total + $shipping + $order->tax - $request->discount;
    //         $order->total_quantity=$total_quantity;
    //         $order->saved=1;
    //         $order->save();
    //         if($backorderqty > 0) {
    //             $backorder = new Order();
    //             $backorder->user_id     = $order->user_id;
    //             $backorder->email       = $order->email;
    //             $backorder->order_date  = date('Y-m-d');
    //             $backorder->due_date    = $order->due_date;
    //             $backorder->sales_rep   = $order->sales_rep;
    //             $backorder->status      = 0;
    //             $backorder->driver_id   = $order->driver_id;
    //             $backorder->shipping_date = $order->shipping_date;
    //             $backorder->message     = $order->message;
    //             $backorder->notes       = $order->notes;
    //             $backorder->billing_id  = $order->billing_id;
    //             $backorder->delivery_id = $order->delivery_id;
    //             $backorder->terms       = $order->terms;

    //             try {
    //                 $backorder->save();
    //             }
    //             catch(\Exception $e) {
    //                 return response()->json(['status'=>'fail','data'=>$e->getMessage(), 
    //                                          'message'=>'Failed to create the backorder #102, Please contact support!']);
    //             }

    //             foreach($request->product_names as $key=>$val) {
    //                 if(!empty($request->product_ids[$key]) && !empty($request->backorderquantities[$key]) 
    //                                                                     && $request->backorderquantities[$key]>0) {

    //                     if($product = Product::find($request->product_ids[$key])) {

    //                         $item = new OrderItem();
    //                         $item->order_id         = $backorder->id;
    //                         $item->product_id       = $product->id;
    //                         $item->product_name     = $product->name;
    //                         $item->product_sku      = $product->sku;
    //                         $item->rate             = $product->price;
    //                         $item->price_by         = $product->price_by;
    //                         $item->quantity         = $request->backorderquantities[$key];

    //                         try {
    //                             $item->save();
    //                         }
    //                         catch(\Exception $e) {
    //                             $backorder->delete();
    //                             return response()->json(['status'=>'fail','data'=>$e->getMessage(), 
    //                                                      'message'=>'Failed to create the backorder item #104, Please contact support!']);
    //                         }
    //                     }
    //                 }
    //             }
    //         }
            

    //         // $invoice->invoice_number = 'FH'.sprintf("%06d",$invoice->id);
    //         // $invoice->save();


            

    //         return response()->json(['status'=>'success','data'=> $order, 
    //                                                      'message'=>'Successfully saved the order!']);
    //     }

    //     return response()->json(['status'=>'fail','data'=> $request->all(), 
    //                                                 'message'=>'Failed to save the order #106, Please contact support!']);
    // }


    function getOrder($id, Request $request) {

        

        $order = Order::with(['item','user'=>function($q){$q->with(['invoice'=>function($query){$query->where('status','>=',0);}]);},'billing','delivery'])->whereId($id)->first();



        if($order) {

            return response()->json(['status'=>'success','order'=>$order,'message'=>'Successfully fetched the order details']);

        }



        return response()->json(['status'=>'fail','order'=>[],'message'=>'Unable to find the order']);



    }


    function getInvoice($id, Request $request) {

        $invoice = Invoice::find($id);
        $order = Order::with(['item','user'=>function($q){$q->with(['invoice'=>function($query){$query->where('status','>=',0);}]);},'billing','delivery'])->whereId($invoice->order_id)->first();

        if($order) {
            return response()->json(['status'=>'success','order'=>$order,'message'=>'Successfully fetched the order details']);
        }

        return response()->json(['status'=>'fail','order'=>[],'message'=>'Unable to find the order']);
    }

    function convertBackorder($id)
    {
        $order              =   Order::where('id',$id)->where('status',0)->first();
        
        $todayorder=Order::whereDate('order_date',date('Y-m-d'))->count();
        $t=sprintf('%03u', $todayorder+1);
        $ponumber='PO'.date('y').date('m').date('d').$t;
        
        $order->order_date  =   date('Y-m-d');
        $order->po_number   = $ponumber;
        $order->status      =   2;

        $order->save();

        session()->flash('message','Backorder Successfully accepted and available in orders section');

        return redirect(admin_url('backorders'));

    }
    public function printOrder(Request $request)
    {
        $action=$request->submit;
        if($action=='print')
        {
            $orders =   Order::with(['item'=>function($query){$query->with('product');},'user','billing','delivery'])->whereIn('id',$request->id)->get();
            
            
        }
        else
        {
            $orders =   Order::with(['item'=>function($query){$query->with('product');},'user','billing','delivery'])->whereIn('id',$request->id)->where(['saved'=>1,'status'=>2])->get();
            foreach($orders as $order)
            {
                if($order->driver_id !='')
                {
                    $runsheet=Runsheet::where(['delivery_date'=>$order->shipping_date,'driver_id'=>$order->driver_id,'status'=>0])->first();
                    if(isset($runsheet))
                    {
                        $order->driver_id=$order->driver_id;
                        $order->runsheet_id=$runsheet->id;
                        $order->status=5;
                        $order->assign_driver=1;
                        
                    }
                    else
                    {
                        $runsheet = new Runsheet();
                        $runsheet->delivery_date    = $order->shipping_date;
                        $runsheet->driver_id        = $order->driver_id;
                        // $runsheet->route            = $request->route[$key];
                        $runsheet->save();
                        $order->driver_id=$order->driver_id;
                        $order->runsheet_id=$runsheet->id;
                        $order->status=5;
                        $order->assign_driver=1;
                    }
                }
                else
                {
                    $order->driver_id=NULL;
                    $order->assign_driver=0;
                    $order->status=4;
                    $order->runsheet_id=NULL;
                }
                $order->save();
                $todayinvoice=Invoice::whereDate('created_at',date('Y-m-d'))->count();
                
                $t=sprintf('%03u', $todayinvoice+1);
                
                $invnumber=date('y').date('m').date('d').$t;
    
                $invoice = new Invoice();
    
                $invoice->invoice_number = $invnumber;
                $invoice->order_id       = $order->id;
                $invoice->due_date       = $order->due_date;
                $invoice->customer_id    = $order->user_id;
                $invoice->status         = 0;
                $invoice->payment_method = 'cash';
                $invoice->reference_number = Null;
                $invoice->transaction_id = Null;
                $invoice->sub_total      = $order->grand_total-$order->tax-$order->shipping+$order->discount_amount;
                $invoice->tax            = $order->tax;
                $invoice->discount       = $order->discount_amount;
                $invoice->shipping       = 0;
                $invoice->grand_total    = $order->grand_total;
                $invoice->paid_total     = 0;
    
                $invoice->save();
                foreach($order->item as $item)
                {
                    $product=Product::where('id',$item->product_id)->first();
                    $product->qty-=$item->quantity;
                    $product->save();
                    $stock=Stock::where('product_id',$item->product_id)->first();
                    $stock->quantity-=$item->quantity;
                    $stock->save();
                }
            }
            
        }
        if(count($orders)>0)
            return view('admin.order.printorder',compact('orders'));
        else
        {
            session()->flash('message','Please select saved orders for print and process');
            return redirect()->back();
        }

    }
    
    public function printOrder2(Request $request)
    {
        $order =   Order::with(['item'=>function($query){$query->with('product');},'user','billing','delivery'])->where('id',$request->id)->first();
        if(isset($order))
        {
            $order->printed_at=date('Y-m-d H:i:s');
            $order->save();
        }
        // if($order->status < 4) 
        //     return view('admin.order.print-po',compact('order'));
        // else
            return view('admin.order.print-order',compact('order'));
    }    
    
    
    public function printIndOrder($id)
    {
        
        $order=Order::where('id',$id)->where('printed_at','!=',null)->first();
        if(isset($order))
        {
            $order->printed_at=date('Y-m-d H:i:s');
            $order->save();
        }
        $orders=Order::with(['item'=>function($query){$query->with('product');},'user','billing','delivery'])->where('id',$id)->get();
        return view('admin.order.printorder',compact('orders'));
        // $result = view('admin.order.printorder', compact('orders'))->render();
         
        // $pdf = App::make('dompdf.wrapper');
        // $pdf->loadHTML($result);
        // return $pdf->stream();
    }
    public function getInvDetails($id)
    {
        $invoice = Invoice::where('id',$id)->where('status','>=',0)->first();
        $inv=Invoice::where('customer_id',$invoice->customer_id)->where('status',0)->get();
        // paid_total<grand_total
        return response()->json($inv);
    }
    public function getCustInvDetails($id)
    {
        $invoice=Invoice::with('user','order')->find($id);
        $customer=User::where('id',$invoice->customer_id)->get();
        return response()->json($customer);
    }
    public function makepayment1(Request $request)
    {
        // die(print_r($request->all()));
        $payment_date=$request->payment_date;
        $payment_method=$request->paymentmethod;
        $id=$request->invid;
        $refid=date('y').date('m').date('d').date('H').date('i').date('s');
        foreach($id as $key=>$value)
        {
            if($request->payamount[$value] !='')
            {
            $invid=$request->invid[$key];
            $payamount=$request->payamount[$value];
            $orderpayment=new OrderPayment();
            $orderpayment->reference_id=$refid;
            $orderpayment->order_id=$invid;
            $orderpayment->payment_date=$payment_date;
            $orderpayment->payment_method=$payment_method;
            $orderpayment->amount_received=$payamount;
            $orderpayment->memo=$request->notes;
            $orderpayment->save();
            $invoice=Invoice::find($invid);
            $invoice->paid_total+=$payamount;
            $invoice->save();
            $order=Order::find($invoice->order_id);
            $order->paid_amount+=$payamount;
            $order->save();
            if($invoice->grand_total==$invoice->paid_total)
            {
                $invoice->status=1;
                $order->paid_status=1;
                $invoice->save();
                $order->save();
            }
            }
            
        }
        session()->flash('message','Invoice Payment Successfully completed');

        return redirect()->back();
    }
    public function cancelOrder(Request $request)
    {
        
        $order=Order::find($request->id);
        $order->status=-1;
        $order->remarks=$request->remarks;
        try

         {
         
            $order->save();
            $items=OrderItem::where('order_id',$request->id)->get();
            foreach($items as $item)
            {
                $product=Product::find($item->product_id);
                $product->qty+=$item->quantity;
                $product->save();
                $stock=Stock::where('product_id',$item->product_id)->first();
                $stock->quantity+=$item->quantity;
                $stock->save();
            }
            
            $invoice=Invoice::where('order_id',$request->id)->first();
            if(isset($invoice))
            {
            $invoice->status=-1;
            $invoice->remarks=$request->remarks;
            $invoice->save();
            }

          session()->flash('message','Order successfully cancelled');

        }

        catch(\Exception $e) {

            session()->flash('message','Unable to cancel the order');

        }
        return redirect()->back();
    }
    
    public function purchseOrders()
    {
        
        $role=Auth::user()->roles()->first()->id;

        $customers=User::where('type','customer')->where('status',1)->get();

        $products=Product::where('status',1)->where('qty','>',0)->get();

        
        $drivers=User::where(['type'=>'staff','status'=>1,'customer_type'=>3])->get();

        $order_no=Order::max('id');

        $status=OrderStatus::whereNotIn('id',[0,3])->get();

        $submenu="Purchase";

        $title="Order";

        $salesreps=User::where('customer_type',5)->get();

        $paymentterms = PaymentTerm::get();
        
        $categories = Category::where('status',1)->get();

        $units      = Unit::where('status',1)->get(); 

        $provinces  = Province::orderBy('name','ASC')->get();

         
        return view('admin.order.purchaseorders',compact('customers','products','order_no','status','drivers','submenu','title','salesreps','categories','units','provinces','paymentterms'));

    }
    
    public function deferPurchaseOrders(Request $request)
    {
        $role=Auth::user()->roles()->first()->id;
        $orderquery=Order::sortable()->with(['invoice','item'=>function($query){$query->with('product');}])->select('orders.id','orders.po_number','users.firstname','users.phone','users.lastname','orders.order_date','orders.shipping_date','orders.grand_total','orders.status','orders.email','users.business_name','users.customer_type','orders.user_id','users.sales_rep')->join('users','users.id','=','orders.user_id');
        $key    = $request->get('key');
        $status = $request->get('status');
        $byday  = $request->get('byday');
        if ($status != '') {

            $orderquery->where('orders.status', $status);

        }

        else

        {

            $orderquery->where('orders.status',2);

        }

        

        if($key !=''){
            $f=$key;
            $s=$key;
            $orderquery->where(function($q) use($key,$f,$s){
                $q->Where('orders.email','like', '%' .$key. '%')
                       ->orWhere('users.phone','like', '%' .$key. '%')->orWhere('users.business_name','like', '%' .$key. '%')->orWhere(DB::raw('CONCAT(users.firstname, " ", users.lastname)'),'like', '%' .$key. '%')
                       ->orWhere('orders.po_number',$f)
                       ->orWhereHas('invoice',function($query) use($s){$query->where('invoice_number','like','%' .$s. '%');});

            });

        }

        if ($byday == "1"){

            

           $orderquery->whereDate('orders.order_date',date('Y-m-d'));

          

        }

        if ($byday == "2"){

            
            $orderquery->whereDate('orders.order_date',date('Y-m-d',strtotime("-1 days")));

         

        }

        if ($byday == "3"){

            $orderquery->whereMonth('orders.order_date', date('m'));

        }

    

        if($role == 12)

        {

            $orderquery->where('orders.status',1);

        }

        else if($role==4)

        {

            $orderquery->where('orders.status',3);

        }

        

        $orderquery->orderBy('id','DESC');

        

        $orders=$orderquery->Paginate(10);
        return [
            'data' => OrderResource::collection($orders),
            'links' => (string) $orders->links(),
        ];
    }
    public function pickSheet($id)
    {
        $order =   Order::with(['item'=>function($query){$query->with('product');},'user','billing','delivery'])->where('id',$id)->first();
        return view('admin.order.picksheet',compact('order'));
    }
    public function PrintPickSheet($id)
    {
        $order =   Order::with(['item'=>function($query){$query->with('product');},'user','billing','delivery'])->where('id',$id)->first();
        return view('admin.order.picksheet1',compact('order'));
    }
    public function checkmailinvoice(Request $request)
    {
        $order=Order::with('invoice','user','item')->find(60);
        return response()->json(['status'=>'success','data1'=> $order, 
                                                         'message'=>'Successfully save the order!']);
    }
    public function sendInvoice(Request $request)
    {
        $action=$request->submit;
        $id=$request->orderid;
        $subject=$request->modalsubject;
        $body=$request->modalbody;
        $order=Order::with('invoice','user','item')->find($id);
        if($action=='print')
        {
            return view('admin.order.invoice-print',compact('order','body','subject'));
        }
        else
        {
            // $order->email
            if($order->email != '') {
                Mail::to($order->email)->send(new InvoiceSent($order,$body,$subject));
            }
            
            session()->flash('message','Invoice Successfully mailed to the customer account');
            return redirect()->back();
        }
    }
    
   

}

