<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\PasswordRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Requests\MailRequest;
use App\Mail\EmailSent;
use App\User;
use App\Inventory;
use App\Province;
use App\Product;
use App\Message;
use Mail;
use DB;
use App\Order;
use App\Invoice;
use App\OrderItem;

class CustomerController extends Controller
{

    public function index()
    {
        //$customer = User::where('customer','customer')->get();
        
        // $title="Dashboard";
        // $submenu="Dashboard";
         
        // $id=Auth::id();
        // $products = DB::table('products')->get();
        // $customers = DB::Table('users')->where('type','customer')->get();
        // $orders = Order::with('user')->where('user_id',$id)->get();
        // $invoices = Invoice::with(['order'=>function($query){$query->with('item');},'user'])->where('customer_id',Auth::id())->get();
        
       // $products = OrderItem::with(['order'=>function($query){
                                     // $query->with('user')->where('user_id',Auth::id()); },'product'])->get();
        $id=Auth::id();
        $submenu="Dashboard";
        $title ="Dashboard";
        
        $products = DB::table('products')->get();
        $customers = DB::Table('users')->where('type','customer')->get();
        $orders = DB::Table('orders')->select('orders.*','users.*')->leftJoin('users','orders.user_id','=','users.id')->where('orders.user_id','=',$id)->orderBy('orders.created_at','DESC')->get();
        $invoices = DB::Table('invoices')->leftJoin('users','invoices.customer_id','=','users.id')->orderBy('invoices.created_at','DESC')->get();
        
        $hourlyorders = DB::table('orders')->select(DB::raw('COUNT("id") AS orders,hour(created_at) AS hour'))->where('created_at','>=',date('Y-m-d 00:00:00'))
                                ->where('created_at','<=',date('Y-m-d 23:59:59'))->groupBy(DB::raw('hour(orders.created_at)'))->get();
                                
        $dailyorders = DB::table('orders')->select(DB::raw('COUNT("id") AS orders,dayname(created_at) AS day'))->where('created_at','>=',date('Y-m-d 00:00:00',time() - (60*60*24*1)))
                                ->where('created_at','<=',date('Y-m-d 23:59:59'))->where('user_id','=',$id)->groupBy(DB::raw('dayname(created_at)'))->get();
        $todaysales = Order::whereMonth('created_at',date('m'))->where('user_id','=',$id)->where('status','>',0)->get();
        $todaydelivery= Order::where('shipping_date','like',date('Y-m-d').'%')->where('user_id','=',$id)->get();
        $topproducts=Product::orderBy('id','DESC')->where('status',1)->get()->take(10);
        // $topproducts=OrderItem::with('product')->get()->distinct('product_id');
        // die(print_r($topproducts));
        
        $todayinvoices=Invoice::with('user')->where('created_at','like',date('Y-m-d').'%')->where('customer_id','=',$id)->get();
        return view('customers.dashboard',compact('submenu','title','products','customers','orders','invoices','hourlyorders','dailyorders','todaysales','topproducts','todayinvoices','todaydelivery'));
            
        // return view('customers.dashboard',compact('title','submenu','products','customers','orders','invoices'));
    }


    
    public function profile()
    {
        $id=Auth::id();
        $profile=User::where('id',$id)->first();
        $provinces=Province::get();
        $title="Dashboard";
        $submenu="Profile";
        return view('customers.profile',compact('title','submenu','profile','provinces'));
    }
      public function changepassword(PasswordRequest $request)
    {
        $id=Auth::id();
        $pass=Auth::User()->password;
       
      if(Hash::check($request->oldpassword, $pass))
      {
          $user=User::find($id);
          $user->password=Hash::make($request->password);
          try {
            
            $user->save();
            session()->flash('message','Successfully updated the password');
        }
        catch(\Exception $e) {
            session()->flash('message','Unable to update the password. Please try again.');
        }
        
        // return redirect('/customer/changepassword');
        
      }
      else
      {
          session()->flash('message','Old password Doesnot Match');
          
      }
      return redirect()->back();
    }
    public function updateprofile(ProfileRequest $request)
    {
     $id=Auth::id();
       $user=User::find($id) or abort(404);
       $user->firstname     = $request->firstname;
        $user->lastname      = $request->lastname;
        //$user->username      = $request->username;
        //$user->password      = Hash::make($request->password);
        $user->email         = $request->email;
        $user->phone         = $request->phone;
        $user->address       = $request->address;
        $user->city          = $request->city;
        $user->postalcode    = $request->postalcode;
        $user->province      = $request->province;
        
        try {
            
           // $user->save();
           if (!empty(request()->input('profile_picture')) && strlen(request()->input('profile_picture')) > 6) {
            $picture = request()->input('profile_picture');
            if (preg_match('/data:image/', $picture)) {
                list($type, $picture) = explode(';', $picture);
                list($i, $picture) = explode(',', $picture);
                $picture = base64_decode($picture);
                $image_name = Str::random(30) . '.png';
                Storage::put('images/users/' . $image_name, $picture);
                @unlink('images/users/' . $user->profile_picture);
                $user->profile_picture = $image_name;
            }
        }
           
        //   if($user->profile_picture = $this->__uploadPicture())
        //      $this->__deleteImage($user->profile_picture);
             
            $user->save();
            session()->flash('message','Successfully updated the profile');
        }
        catch(\Exception $e) {
            session()->flash('message','Unable to update the profile. Please try again.'.$e->getMessage());
        }
        
        return redirect('/customer/profile');
    }
    public function inventories()
    {
        $inventory=Product::with('category')->where('qty','>',0)->get();
         $title="Inventories";
        $submenu="Shop";
        return view('customers.inventories',compact('title','submenu','inventory'));

        
    }
     public function inbox()
    {
        $id=Auth::id();
        $title="Messages";
        $submenu="Inbox";
        $email=Message::where('recipient_id',$id)->where('status_recipient',0)->paginate(10);
        return view('customers.inbox',compact('title','submenu','email'));
    }
    public function compose()
    {
        $recipient=User::where('type','!=','customer')->get();
        $title="Messages";
        $submenu="Compose";
       // $email=Email::get();
        return view('customers.compose',compact('title','submenu','recipient'));
    }
    public function sendmail(MailRequest $request)
    {
        $recmail=User::where('id',$request->recipient_id)->first();
        $message=new Message();
        $message->sender_id=Auth::id();
        $message->sender_email=Auth::User()->email;
        $message->recipient_id=$request->recipient_id;
        $message->recipient_email=$recmail->email;
        $message->subject=$request->subject;
        $message->body_html=$request->message;
        $message->body_text=$request->message;
        // print_r($message);
        // die;
        try {
            
            $message->save();
           
          success('Email','Send');
           //Mail::to($recmail->email)->bcc('cintafc96@gmail.com')->send(new EmailSent($message));
          return redirect('customer/outbox');
           
        }
        catch(\Exception $e) {
            failure('message','send');
            return redirect()->back();
            
        }
        
        // return redirect(admin('customers'));
    }
    public function outbox()
    {
        $id=Auth::id();
        $title="Messages";
        $submenu="Outbox";
        $email=Message::where('sender_id',$id)->where('status_sender',0)->paginate(10);
        return view('customers.outbox',compact('title','submenu','email'));
    }
    public function deleteemail($id,$type)
    {
        $msg=Message::find($id) or abort(404);
        if($type==0)
        {
            $msg->status_sender=1;
        }
        else
        {
            $msg->status_recipient=1;
        }
        try {
            
            $msg->save();
          success('Email','Delete');
          //return redirect(customer('outbox'));
            return redirect()->back();
           
        }
        catch(\Exception $e) {
            failure('message','send');
          //   return redirect(customer('outbox'));
            return redirect()->back();
            
        }
        
        
    }
    public function markasread($id)
    {
        $mark=Message::find($id) or abort(404);
        $mark->read_at=date('Y-m-d');
         try {
        $mark->save();
        success('Message','updated.');
           //Mail::to($recmail->email)->bcc('cintafc96@gmail.com')->send(new EmailSent($message));
         // return redirect(customer('messages'));
          return redirect()->back();
         }
         catch(\Exception $e) {
            failure('message','update');
            return redirect()->back();
            
        }
         
    }
    
    public function getchangepassword(){
        $title="Dashboard";
        $submenu="Password";
        return view('customers.change-password',compact('title','submenu'));
    }
    public function viewMessage($id){
        
        $title="Messages";
        $submenu="Inbox";
         $message = Message::find($id);
        return view('customers.view-messages',compact('title','submenu','message'));
        
    }
       
    public function viewSentMessage($id){
        
        $title="Messages";
        $submenu="Inbox";
         $message = Message::find($id);
        return view('customers.view-sentMessages',compact('title','submenu','message'));
        
    }

    
   
    
   
}
