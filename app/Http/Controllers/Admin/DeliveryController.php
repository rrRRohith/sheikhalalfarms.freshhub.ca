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
use App\Unit;
use App\Route;
use Illuminate\Http\Request;
use Illuminate\Pagination\CursorPaginator;
use App\Mail\RunsheetSent;
use PDF;
use DB;
use App;
use Mail;
use App\Http\Resources\DeliveryResource;

class DeliveryController extends Controller
{

    public function runsheets(Request $request)
    {
        $submenu="Runsheet";
        $title="Deliveries";
   
        $runsheetqry    =   Runsheet::with('driver','routes');
        $drivers=User::where(['type'=>'staff','status'=>1,'customer_type'=>3])->get(); 
        $routes=Route::get();
        if($request->search !=''){
            $search=$request->search;
            $runsheetqry->whereHas('driver',function($q) use($search) {
                        $q->where('firstname','LIKE','%'.$search.'%');
                        $q->orWhere(DB::raw('CONCAT(users.firstname, " ", users.lastname)'),'like', '%' .$search. '%');
                        $q->orWhere('lastname','LIKE','%'.$search.'%');
                        $q->orWhere('city','LIKE','%'.$search.'%');
                    });
            
        }
        if($request->driver !='')
        {
            $driver=$request->driver;
            $runsheetqry->where('driver_id',$driver);
        }
        if($request->date !=''){
            $date=$request->date;
            $runsheetqry->where('delivery_date',$date);
        }
        if($request->route !=''){
            $route=$request->route;
            $runsheetqry->where('route',$route);
        }
        if($request->city !=''){
            $city=$request->city;
            $runsheetqry->where('city','like','%'.$city.'%');
        }
             
        $runsheetqry->orderBy('delivery_date','DESC');
        $runsheets = $runsheetqry->paginate(20);
             
        return view('admin.order.runsheets',compact('runsheets','submenu','title','drivers','routes')); 
         
    }

    public function generateRunsheet(Request $request) {

        $title="Deliveries";
        $submenu="Deliveries";
        $drivers=User::where(['type'=>'staff','status'=>1,'customer_type'=>3])->get(); 

        if($request->has('driver') && $request->has('date'))
        {
             $orders = Order::with('user','invoice','item')
                                     ->where(['driver_id'=>$request->driver,'shipping_date'=>$request->date,'runsheet_id'=>NULL])->get();
             if(!$orders)
                session()->flash('message','Sorry No Order Found for the selected date and driver');
    
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
        $id=$request->id;
        $ids=array();
        // $drivers=User::where(['type'=>'staff','status'=>1,'customer_type'=>3])->get();
        // foreach($drivers as $driver)
        // {
            foreach($id as $key=>$value)
            {
                if($request->driver[$key] != '')
                {
                    $driverid=$request->driver[$key];
                    $orderid=$request->id[$key];
                    $rout=$request->route[$key];
                    $runsheet=Runsheet::where(['delivery_date'=>$date,'driver_id'=>$driverid,'status'=>0])->first();
                    if(isset($runsheet))
                    {
                        $order=Order::find($orderid);
                        $order->driver_id=$driverid;
                        $order->runsheet_id=$runsheet->id;
                        $order->status=5;
                        $order->save();
                    }
                    else
                    {
                        $runsheet = new Runsheet();
                        $runsheet->delivery_date    = $date;
                        $runsheet->driver_id        = $driverid;
                        $runsheet->route            = $request->route[$key];
                        $runsheet->save();
                        $order=Order::find($orderid);
                        $order->driver_id=$driverid;
                        $order->runsheet_id=$runsheet->id;
                        $order->status=5;
                        $order->save();
                        $ids[]=$runsheet->id;
                    }
                }
            }
        // }
        // die(print_r($request->all()));
        // if($request->driver != '' && $request->date != '' && count($request->orders)) {

        //     $orders = Order::whereIn('id',$request->orders)->where('driver_id',$request->driver)
        //                                                     ->where('shipping_date',$request->date)
        //                                                     ->where('status',3)->get();

        //     if($orders) {
        //         $runsheet = new Runsheet();
        //         $runsheet->delivery_date    = $request->date;
        //         $runsheet->driver_id        = $request->driver;
        //         $runsheet->city             = $request->city;
        //         $runsheet->route            = $request->route;
        //         $runsheet->save();

        //         foreach($orders as $order) {
        //             $order->status = 4;
        //             $order->runsheet_id = $runsheet->id;
        //             $order->save();

        //             sendNotificationTransit($order);
        //         }

        //         return redirect(admin_url('runsheets/view/'.$runsheet->id));
        //         exit;

        //     }

        // }
        $submenu = "Runsheet";
        $title = "Deliveres";
        if(count($ids)>0)
        {
            $runsheets=Runsheet::with('driver','routes')->whereIn('id',$ids)->paginate(20);
            return view('admin.order.runsheetlist',compact('runsheets','submenu','title'));
        }
        else
        {
            return redirect()->back();
        }
        // exit;
        
    }

    public function viewRunsheet($id) {
        $submenu = "Runsheet";
        $title = "Deliveries";

        $runsheet = Runsheet::with('routes')->find($id) or abort(404);
        $orders=Order::with(['user'=>function($query){$query->with('paymentmethod');},'item'])->where('orders.runsheet_id',$id)->get();
        return view('admin.order.runsheet',compact('orders','submenu','title','runsheet'));
    }

    public function printRunsheet($id) {
        $submenu = "Deliveres";
        $title = "Deliveres";

        $runsheet = Runsheet::find($id) or abort(404);
        $runsheet->status = 1;
        $runsheet->save();

        $orders = Order::with('user')->where('runsheet_id',$id)->where('status','>=',0)->get();

        return view('admin.order.runsheet1',compact('orders','submenu','title'));
    }
    public function generaterunsheet1()
    {   
        $submenu = "Runsheet";
        $title = "Deliveries";
        $date=Request()->date ? Request()->date :date('Y-m-d');
        $sort=Request()->sort ? Request()->sort : 'asc';
        // $date=$date1 ? $date1 :date('Y-m-d');
        
        // if(Request()->date != null)
        // {
            $orders = Order::with('user','invoice','item','delivery')
                 ->where(['shipping_date'=>$date,'runsheet_id'=>NULL,'status'=>4])->orderBy('shipping_date',$sort)->get();
             $totorders=Order::whereDate('shipping_date',$date)->where('status','>=',4)->count();
            $drivers=User::with(['driverorder'=>function($q) use($date){$q->where(['status'=>5]);$q->whereDate('shipping_date',$date);}])->where(['type'=>'staff','status'=>1,'customer_type'=>3])->get();
        // }
        // else
        // {
        // $orders = Order::with('user','invoice','item','delivery')
        //                              ->where(['assign_driver'=>0,'status'=>4])->whereDate('shipping_date','>=',$date)->orderBy('shipping_date',$sort)->get();
        //  $totorders=Order::whereDate('shipping_date','>=',$date)->where('status','>=',4)->count();
        // $drivers=User::with(['driverorder'=>function($q) use($date){$q->where('status','>=',5);$q->whereDate('shipping_date','>=',$date);$q->where('assign_driver',1);}])->where(['type'=>'staff','status'=>1,'customer_type'=>3])->get();
        // }
        if(Request()->all=='yes')
        {
        $orders=Order::with('user','invoice','item','delivery')
                 ->where('shipping_date',$date)->where('status','>=',4)->orderBy('shipping_date',$sort)->get();
        }
        if(Request()->search != '')
        {
            
        }
        
        $routes=Route::get();
        // die(print_r($drivers));
        return view('admin.delivery.generaterunsheet',compact('drivers','submenu','title','orders','date','routes','totorders'));
    }
    
    public function deliveries()
    {   
        $submenu = "Delivery";
        $title = "Deliveries";
        $date=Request()->date ? Request()->date :date('Y-m-d');
        $sort=Request()->sort ? Request()->sort : 'asc';
        
        $drivers=User::with(['driverorder'=>function($q) use($date){$q->where(['status'=>5]);$q->whereDate('shipping_date',$date);}])->where(['type'=>'staff','status'=>1,'customer_type'=>3])->get();
        
        $routes=Route::get();
        // die(print_r($drivers));
        return view('admin.delivery.deliveries',compact('drivers','submenu','title','date','routes'));
    }
    
    public function defer(Request $request)
    {
       $deliveryquery=Order::sortable()->with('user','invoice','item','delivery','driver'); 
        $key    = $request->get('key');
        $date  = $request->get('date') ?? date('Y-m-d');
        $status = $request->get('status');
        $driver=$request->get('driver');
        if($key !='')
        {
            $deliveryquery->where(function($q) use($key){
                $q->whereHas('user',function($query) use($key){
                    $query->where('business_name','like','%'.$key.'%');
                    $query->orWhere('phone','like','%'.$key.'%');
                });
                $q->orWhereHas('invoice',function($query) use($key){
                    $query->where('invoice_number','like','%'.$key.'%');
                });
            });
        }
        if($status !='')
        {
            $deliveryquery->whereHas('invoice',function($q) use($status){
                $q->where('assign_driver',$status);
            });
        }
        if($driver !='')
        {
            $deliveryquery->where('driver_id',$driver);
        }
        $orders=$deliveryquery->whereDate('shipping_date',$date)->where('status','>=',4)->paginate(10);
        // die(print_r($orders));
        return [
            'data' => DeliveryResource::collection($orders),
            'links' => (string) $orders->links(),
        ];
    }
    
    public function deliverylist(Request $request)
    {
        die(print_r($request->all()));
    }
    
    public function assignDriver()
    {
        $id=Request()->id;
        $driver=Request()->driver;
        
        $driver_id=$driver;
        if($driver_id !='')
        {
        $order=Order::find($id);
        $runsheet=Runsheet::where(['delivery_date'=>$order->shipping_date,'driver_id'=>$driver_id,'status'=>0])->first();
        if(isset($runsheet))
        {
            $order->driver_id=$driver_id;
            $order->runsheet_id=$runsheet->id;
            $order->status=5;
            $order->assign_driver=1;
            
        }
        else
        {
            $runsheet = new Runsheet();
            $runsheet->delivery_date    = $order->shipping_date;
            $runsheet->driver_id        = $driver_id;
            // $runsheet->route            = $request->route[$key];
            $runsheet->save();
            $order->driver_id=$driver_id;
            $order->runsheet_id=$runsheet->id;
            $order->status=5;
            $order->assign_driver=1;
        }
        $order->save();
        }
        session()->flash('message','Driver Assigned');
        return redirect()->back();
        
    }
    
    // public function assignDriver(Request $request)
    // {
    //     $id=$request->orderid;
    //     foreach($id as $key=>$value)
    //     {
    //     $driver_id=$request->driver[$key];
    //     if($driver_id !='')
    //     {
    //     $order=Order::find($id[$key]);
    //     $runsheet=Runsheet::where(['delivery_date'=>$order->shipping_date,'driver_id'=>$driver_id,'status'=>0])->first();
    //     if(isset($runsheet))
    //     {
    //         $order->driver_id=$driver_id;
    //         $order->runsheet_id=$runsheet->id;
    //         $order->status=5;
    //         $order->assign_driver=1;
            
    //     }
    //     else
    //     {
    //         $runsheet = new Runsheet();
    //         $runsheet->delivery_date    = $order->shipping_date;
    //         $runsheet->driver_id        = $driver_id;
    //         // $runsheet->route            = $request->route[$key];
    //         $runsheet->save();
    //         $order->driver_id=$driver_id;
    //         $order->runsheet_id=$runsheet->id;
    //         $order->status=5;
    //         $order->assign_driver=1;
    //     }
    //     $order->save();
    //     }
    //     }
    //     session()->flash('message','Driver Assigned');
    //     return redirect()->back();
        
    // }
    public function getOrders()
    {
        $submenu = "Deliveres";
        $title = "Deliveres";
        $driverid=Request()->driver;
        $deldate=Request()->date;
        $driver= User::find($driverid);
        $drivers=User::where(['type'=>'staff','status'=>1,'customer_type'=>3])->get();
        $orders=Order::with('user')->where(['driver_id'=>$driverid,'assign_driver'=>1])->whereDate('shipping_date',$deldate)->where('status','>=',0)->get();
        return view('admin.delivery.getdeliveries',compact('orders','submenu','title','driver','drivers'));
    }
    public function mailRunsheet($id)
    {
        $orders = Order::with('user','driver')->where('runsheet_id',$id)->get();
        $message=new Message();

        $message->sender_id=Auth::id();

        $message->sender_email=Auth::User()->email;

        $message->recipient_id=$orders[0]->driver_id;

        $message->recipient_email=$orders[0]->driver->email;

        $message->subject="Runsheet for ".date('d m Y',strtotime($orders[0]->shipping_date));

        $message->body_html="Runsheet for ".date('d m Y',strtotime($orders[0]->shipping_date));

        $message->body_text="<a href='admin_url('runsheets/mail')/'".$id.">Get Runsheet</a>";
            try
            {
                $message->save();
                session()->flash('message','Email has been sent' );
                Mail::to($orders[0]->driver->email)->send(new RunsheetSent($orders));
            }
            catch(Exception $e)
            {
                session()->flash('message','Unable to send email. Please try again.' );
                
            }
            return redirect()->back();
    }
    public function remove()
    {
        $id=Request()->id;
        $order=Order::find($id);
        $order->runsheet_id=NULL;
        $order->assign_driver=0;
        $order->status=4;
        $order->save();
        return json_encode(['status'=>"success",'data'=>$order]);
    }
    public function deliveryView($id)
    {
        
    }
    public function reassign()
    {
        $id=Request()->id;
        $driver=Request()->driver;
        $order=Order::find($id);
        if($driver=='')
        {
            $order->driver_id=NULL;
            $order->runsheet_id=NULL;
            $order->assign_driver=0;
            $order->status=4;
            
        }
        else
        {
            $runsheet=Runsheet::where(['delivery_date'=>$order->shipping_date,'driver_id'=>$driver,'status'=>0])->first();
                    if(isset($runsheet))
                    {
                        $order->driver_id=$driver;
                        $order->runsheet_id=$runsheet->id;
                        $order->status=5;
                        $order->assign_driver=1;
                        
                    }
                    else
                    {
                        $runsheet = new Runsheet();
                        $runsheet->delivery_date    = $order->shipping_date;
                        $runsheet->driver_id        = $driver;
                        // $runsheet->route            = $request->route[$key];
                        $runsheet->save();
                        $order->driver_id=$driver;
                        $order->runsheet_id=$runsheet->id;
                        $order->status=5;
                        $order->assign_driver=1;
                    }
        }
        $order->save();
        return json_encode(['status'=>"success",'data'=>$order]);
    }
    
}
