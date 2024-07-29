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
use App\Http\Traits\UploadPictureTrait;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\User;
use App\Province;
use App\Order;
use App\Product;
use App\Invoice;
use App\PaymentTerm;
use App\Category;
use App\Unit;
use DB;

class AdminController extends Controller
{

    public function index()
    {
        //$customer = User::where('customer','customer')->get();
        $submenu="Dashboard";
        $title ="Dashboard";
        
        $products = DB::table('products')->where('status',1)->get();
        $customers = DB::Table('users')->where('type','customer')->get();
        $orders = DB::Table('orders')->select('orders.*','users.*')->leftJoin('users','orders.user_id','=','users.id')->orderBy('orders.created_at','DESC')->get();
        $invoices = DB::Table('invoices')->leftJoin('users','invoices.customer_id','=','users.id')->orderBy('invoices.created_at','DESC')->get();
        
        $hourlyorders = DB::table('orders')->select(DB::raw('COUNT("id") AS orders,hour(created_at) AS hour'))->where('created_at','>=',date('Y-m-d 00:00:00'))
                                ->where('created_at','<=',date('Y-m-d 23:59:59'))->groupBy(DB::raw('hour(orders.created_at)'))->get();
                                
        $dailyorders = DB::table('orders')->select(DB::raw('COUNT("id") AS orders,dayname(created_at) AS day'))->where('created_at','>=',date('Y-m-d 00:00:00',time() - (60*60*24*1)))
                                ->where('created_at','<=',date('Y-m-d 23:59:59'))->groupBy(DB::raw('dayname(created_at)'))->get();
        $todaysales = Order::where('created_at','like',date('Y-m-d').'%')->get();
        $totaldelivery= Order::where('shipping_date','like',date('Y-m-d').'%')->where('status','>=',4)->get();
        $assigneddelivery=Order::where('shipping_date','like',date('Y-m-d').'%')->where('status','>=',4)->where('assign_driver',1)->get();
        $topproducts=Product::orderBy('id','DESC')->where('status',1)->get()->take(10);
        
        $todayinvoices=Invoice::with('user')->where('created_at','like',date('Y-m-d').'%')->get();
        
        $provinces  = Province::orderBy('name','ASC')->get();
        $paymentterms = PaymentTerm::get();
        $salesreps=User::where('customer_type',5)->get();
        $drivers=User::where(['type'=>'staff','status'=>1,'customer_type'=>3])->get();
        $categories = Category::where('status',1)->get();
        $units      = Unit::where('status',1)->get(); 
        
        return view('admin.dashboard',compact('submenu','title','products','customers','orders','invoices','hourlyorders','dailyorders','todaysales','topproducts','todayinvoices','totaldelivery','provinces','paymentterms','salesreps','drivers','categories','units','assigneddelivery'));
    }


    public function create()
    {
       
         $title="Customers";
         $msg="Add";
        return view('admin.customersadd',compact('title','msg'));
    }


    public function store(CustomerRequest $request)
    {
        $user = new User();
        
        $user->firstname     = $request->firstname;
        $user->lastname      = $request->lastname;
        $user->username      = $request->username;
        $user->password      = Hash::make($request->password);
        $user->email         = $request->email;
        $user->phone         = $request->phone;
        $user->address       = $request->address;
        $user->city          = $request->city;
        $user->postalcode    = $request->postalcode;
        $user->province      = $request->province;
        $user->country       = $request->country;
        $user->customer      = $request->customer;
        // print_r($user);
        // die;
        
       
        
        if($request->hasFile('profile_picture') && $request->file('profile_picture')->isValid())
        {
            $filename = str_random(40).'.'.$request->profile_picture->extension();
            $request->profile_picture->storeAs('media/customers',$filename);
            $user->profile_picture = $filename;
        }
        
        try {
            
            $user->save();
           
            session()->flash('message','Successfully created the customer');
        }
        catch(\Exception $e) {
            session()->flash('message','Unable to create the customer. Please try again.');
        }
        
        return redirect(admin_url('customers'));
        
    }

    public function show($id)
    {
       $user=User::find($id) or abort(404);
       $title="Customers";
        $msg="Edit";
        return view('admin.customerview',compact('user','title','msg'));
    }

    public function edit($id)
    {
        //$users = User::orderBy('created_at','DESC')->get();
        $user = User::find($id) or abort(404);
        $title="Customers";
        $msg="Edit";
        return view('admin.customersadd',compact('user','title','msg'));
    }

    public function update(CustomerRequest $request, $id)
    {
        $user = User::find($id) or abort(404);
        
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
        $user->country       = $request->country;
        $user->customer      = $request->customer;
        
        if($request->hasFile('profile_picture') && $request->file('profile_picture')->isValid())
        {
            
            $filename = str_random(40).'.'.$request->profile_picture->extension();
            $request->profile_picture->storeAs('media/customers',$filename);
            @unlink('media/customers/'.$user->profile_picture);
            $user->profile_picture = $filename;
        }
        
        try {
            
            $user->save();
            session()->flash('message','Successfully updated the customer');
        }
        catch(\Exception $e) {
            session()->flash('message','Unable to update the customer. Please try again.');
        }
        
        return redirect(admin_url('customers'));
    }
        
    public function destroy($id)
    {
        $user = User::find($id) or abort(404);
        @unlink('media/'.$user->profile_picture);
       
        try {
            $user->delete();
            session()->flash('message','User successfully deleted');
        }
        catch(\Exception $e) {
            session()->flash('message','Unable to delete the user');
        }
        
        return redirect(admin_url('customers'));
    }
    public function changeStatus($id,$status)
    {
        $user=User::find($id) or abort(404);
        $user->status=$status;
        $user->save();
        try {
            $user->save();
            session()->flash('message','Customer status changed');
        }
        catch(\Exception $e) {
            session()->flash('message','Unable to change status');
        }
        
        return redirect(admin_url('customers'));
    }
    public function profile()
    {
        $id=Auth::id();
        $profile=User::where('id',$id)->first();
        $provinces=Province::get();
        $submenu="Profile";
        $title="Dashboard";
        return view('admin/profile',compact('submenu','profile','provinces','title'));
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
        
        return redirect(admin_url('profile'));
    }
    public function changepassword(PasswordRequest $request)
    {
        $id=Auth::id();
        $pass=Auth::User()->password;
        $title="Dashboard";
        $submenu="Password";
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
        
        return view('admin.change-password',compact('title','submenu'));
        
      }
      else
      {
          session()->flash('message','Old password Doesnot Match');
          return redirect()->back();
      }
    }
    public function getchangepassword(){
        $title="Dashboard";
        $submenu="Password";
        return view('admin.change-password',compact('title','submenu'));
    }
    public function __uploadPicture($existing = '') {
        
        die(print_r(request()->hasFile('profile_picture')));
        if(request()->hasFile('profile_picture') && request()->file('profile_picture')->isValid())
        {
            

            $filename = str_random(40).'.'.request()->profile_picture->extension();
            
            try {
                
                request()->profile_picture->storeAs('media/customers',$filename);
            }
            catch(\Exception $e) {
                
            }
            
            return $filename;
        }
        
        return null;
    }
    public function __deleteImage($existing = '') {
        if($existing != '')
            @unlink('media/customers/'.$user->profile_picture);
    }
}
