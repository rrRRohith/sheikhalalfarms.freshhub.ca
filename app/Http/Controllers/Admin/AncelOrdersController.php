<?php

namespace App\Http\Controllers\Admin;

//use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\OrderRequest;
use Illuminate\Support\Facades\Hash;
use App\Product;
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
use Illuminate\Http\Request;
use Illuminate\Pagination\CursorPaginator;
use PDF;
class OrdersController extends Controller
{


    public function index(Request $request)
    {
        $role=Auth::user()->roles()->first()->id;
 
        $customers=User::where('type','customer')->where('status',1)->get();
        $products=Product::where('status',1)->where('qty','>',0)->get();
        $orderquery=Order::with(['item'=>function($query){$query->with('product');}])->select('orders.id','users.firstname','users.phone','users.lastname','orders.order_date','orders.shipping_date','orders.grand_total','orders.status','orders.email','orders.order_id','users.business_name','users.customer_type','orders.user_id','users.sales_rep')->join('users','users.id','=','orders.user_id');
        if ($request->firstname != '') {
            $orderquery->where('firstname', $request->firstname);
        }
        if ($request->status != '') {
            $orderquery->where('orders.status', $request->status);
        }
        
        if($request->search !=''){
            $orderquery->where('users.firstname', 'like', '%' .$request->search. '%')->orWhere('users.lastname','like', '%' .$request->search. '%')->orWhere('orders.email','like', '%' .$request->search. '%')
                       ->orWhere('users.phone','like', '%' .$request->search. '%')->orWhere('orders.order_id','like', '%' .$request->search. '%')->orWhere('users.business_name','like', '%' .$request->search. '%')
                       ->get();
        }
        if (request()->orders == "1"){
            
           $orderquery->where('orders.order_date',date('Y-m-d'));
          
        }
        if (request()->orders == "2"){
            
            $orderquery->where('orders.order_date',date('Y-m-d',strtotime("-1 days")));
         
        }
        if (request()->orders == "3"){
            $orderquery->where('orders.order_date', date('Y-m-d',strtotime("m")));
        }
    
        if($role == 12)
        {
            $orderquery->where('orders.status',1);
        }
        else if($role==4)
        {
            $orderquery->where('orders.status',3);
        }
        $drivers=User::where(['type'=>'staff','status'=>1,'customer_type'=>3])->get();
        $orderquery->orderBy('order_date','DESC');
        
        $orders=$orderquery->Paginate(20);
        $order_no=Order::max('order_id');
        $status=OrderStatus::get();
        $submenu="Order";
        $title="Order";
         $salesreps=User::where('customer_type',5)->get();
        return view('admin.order.orders',compact('customers','products','orders','order_no','status','drivers','submenu','title','salesreps'));
    }
    public function store(OrderRequest $request)
    {
        $order = new Order();
        
        $order->user_id             = $request->user_id;
        $order->order_id=$request->order_id;
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
        }
        }
        
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
        }
        }
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
        $invoice=Invoice::with(['order'=>function($query){$query->with(['item'=>function($q){$q->with('product');}]);},'user'])->where('id',$id)->first();
        $stocks=Stock::get();
        $submenu="Invoice";
          $title="Order";
        
        return view('admin.order.generateinvoice1',compact('stocks','order','submenu','title','invoice'));
    }
    public function invoices($id=null,Request $request)
    {
        $order_no=Order::max('order_id');
        $customers=User::where('type','customer')->where('status',1)->get();
        $products=Product::where('status',1)->where('qty','>',0)->get();
        $submenu="Invoice";
        $title="Order";
        $invquery=Invoice::with(['order'=>function($query){$query->with('item');},'user']);
        if($request->search !=''){
            $search=$request->search;
            $invquery->whereHas('user',function($q) use($search){$q->where('firstname','LIKE','%'.$search.'%');});
        }
        if($request->store !=''){
            $store=$request->store;
            $invquery->whereHas('user',function($q) use($store){$q->where('id',$store);});
        }
         if($id != null)
         {
             $invoices=$invquery->where('customer_id',$id)->get();
         }
         else
         {
             $invoices=$invquery->get();
         }
        //  $orders=Order::select('orders.id','users.firstname','users.lastname','orders.order_date','orders.grand_total','orders.status','orders.order_id','orders.paid_amount')->join('users','users.id','=','orders.user_id')->where('orders.status',2)->get();
         return view('admin.order.invoices',compact('invoices','order_no','customers','products','submenu','title'));
        
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
    public function orderDetails($id){
        
        $orders = Order::with('user')->where('id',$id)->get();
        $orderitems=OrderItem::join('products','products.id','=','order_items.product_id')->where('order_items.order_id',$id)->get();
         $submenu="Invoice";
         $title="Order";

        return view('admin.order.order-details',compact('orders','orderitems','submenu','title'));
    }
    public function assignDriver(Request $request)
    {
       $order=Order::find($request->driverorderid);
       $order->status=3;
       $order->driver_id=$request->driver_id;
       $order->shipping_date=$request->dod;
    
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
            session()->flash('message','Order  status successfully updated');
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
        $order->order_id   =$request->order_id1;
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
    public function generateRunsheet(Request $request){
        $title="Order";
        $submenu="Order";
        $drivers=User::where(['type'=>'staff','status'=>1,'customer_type'=>3])->get(); 
        if($request->has('driver') && $request->has('date'))
         {
             $orders=Order::with('user')->where(['driver_id'=>$request->driver,'shipping_date'=>$request->date,'runsheet_id'=>NULL])->get();
             if(count($orders)==0)
             {
             session()->flash('message','Sorry No Order Found for the selected date and driver');
             }
             return view('admin.order.generate-runsheet',compact('drivers','title','submenu','orders'));
         }
         else
         {
             return view('admin.order.generate-runsheet',compact('drivers','title','submenu'));
         }
    }
    public function saveRunsheet(Request $request)
    {
        $date=$request->date;
        $driver=$request->driver;
        $runsheet=new Runsheet();
        $runsheet->delivery_date=$date;
        $runsheet->driver_id=$driver;
        $runsheet->save();
        if($request->orid && count($request->orid)>0)
        {
            $orid=$request->orid;
            
            foreach($orid as $key=>$value)
            {
                $order=Order::find($value);
                $order->runsheet_id=$runsheet->id;
                $order->status=4;
                $order->save();
                $message=new Message();
             $message->sender_id=Auth::id();
             $message->sender_email=Auth::User()->email;
             $message->recipient_id=$order->user_id;
             $message->recipient_email=$order->email;
             $message->subject="Order Transit";
             $message->body_html="Your Order is Transit";
             $message->body_text="Your Order is Transit !..";
             $message->save();
            }
        }
        else
        {
            $orders=Order::with('user')->where(['driver_id'=>$driver,'shipping_date'=>$date,'runsheet_id'=>NULL])->get();
            foreach($orders as $order)
            {
                $order->runsheet_id=$runsheet->id;
                $order->status=4;
                $order->save();
                $message=new Message();
             $message->sender_id=Auth::id();
             $message->sender_email=Auth::User()->email;
             $message->recipient_id=$order->user_id;
             $message->recipient_email=$order->email;
             $message->subject="Order Transit";
             $message->body_html="Your Order is Transit";
             $message->body_text="Your Order is Transit !..";
             $message->save();
            }
        }
        
        return redirect(admin_url('runsheet/'.$runsheet->id));
        
    }
    public function runsheet($id)
    {
        $submenu="Invoice";
        $title="Order";
        $orders=Order::with('user')->where('runsheet_id',$id)->get();
        return view('admin.order.runsheet',compact('orders','submenu','title'));
    }
    public function backorder()
    {
        $submenu="Invoice";
        $title="Backorder";
        $orders=Order::with('item','user')->where(['backorder_status'=>'backorder'])->get();
        return view('admin.order.backorder',compact('orders','submenu','title'));
    }
    public function viewBackorder($id)
    {
        $submenu="Invoice";
        $title="Backorder";
        $order=Order::with(['item'=>function($query){$query->with('product');},'user'])->where(['backorder_status'=>'backorder','id'=>$id])->first();
        $customer=User::where('id',$order->user_id)->first();
        return view('admin.order.viewbackorder',compact('order','customer','submenu','title'));
    }
    public function printRunsheet($id){
        $submenu="Invoice";
        $title="Order";
        $runsheet=Runsheet::find($id);
        $runsheet->status=1;
        $runsheet->save();
        $orders=Order::with('user')->where('runsheet_id',$id)->get();
        return view('admin.order.runsheet1',compact('orders','submenu','title'));
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
    public function runsheets()
    {
        $submenu="Invoice";
        $title="Order";
        $runsheets=Runsheet::get();
        return view('admin.order.runsheets',compact('runsheets','submenu','title'));
    }
    
}
