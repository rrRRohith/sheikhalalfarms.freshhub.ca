<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use App\Http\Resources\CustomerResource;
use App\User;
use App\Invoice;
use App\Province;
use App\Account;
use App\CustomerType;
use App\PaymentTerm;
use App\PaymentMethod;
use DB;

class CustomersController extends Controller 
{
    public function index()
    {
        if (auth()->user()->cannot('Customer View')) {
            return redirect('/');
        } 

        $customertypes = CustomerType::get();
        if(Request()->status=='1')
            $submenu="Active";
        else if(Request()->status=='0')
            $submenu="Inactive";
        else
            $submenu = "All";
        
        
        $title="Customers";
        
        $province = Province::get();
        $paymentterms = PaymentTerm::get();
        $paymentmethods = PaymentMethod::get();
        $salesreps=User::where(['type'=>'staff','status'=>1,'customer_type'=>5])->get();
        $drivers=User::where(['type'=>'staff','status'=>1,'customer_type'=>3])->get();
        return view('admin.customer.customers', compact('submenu', 'customertypes','title','province','paymentterms','paymentmethods','salesreps','drivers'));
    }
    
    public function defer(Request $request){
        $customerquery=User::sortable()->with(['types','invoice'=>function($query){$query->where('status',0);}]);
        $key    = $request->get('key');
        $type   = $request->get('type');
        $status = $request->get('status');

        if($key !='')
            $customerquery->where(function($q) use ($key) {
                $q->where('city','like','%'.$key.'%')->orWhere('firstname','like','%'.$key.'%')
                                ->orWhere('lastname','like','%'.$key.'%')->orWhere('business_name','like','%'.$key.'%')
                                ->orWhere('address','like','%'.$key.'%');
            });
        if($type !='')
            $customerquery->where('customer_type',$type);
        if($status !='')
            $customerquery->where('status',$status);
        
        $customers=$customerquery->where('type', 'customer')->paginate(10); 
        // die(print_r($customers));
        return [
            'data' => CustomerResource::collection($customers),
            'links' => (string) $customers->links(),
        ];
    }

    public function create() 
    {
        if (auth()->user()->cannot('Customer Create')) {
            return redirect('/');
        }
        $submenu = "All";
        $title ="Customers";
        $province = Province::get();
        $paymentterms = PaymentTerm::get();
        $paymentmethods = PaymentMethod::get();
        $customertypes = CustomerType::get();
        $salesreps=User::where(['type'=>'staff','status'=>1,'customer_type'=>5])->get();
        $drivers=User::where(['type'=>'staff','status'=>1,'customer_type'=>3])->get();
        return view('admin.customer.customersadd', compact('submenu', 'province', 'paymentterms', 'paymentmethods', 'customertypes','title','salesreps','drivers'));
    }
    
    public function store(CustomerRequest $request)
    {
        $user = new User();
        $name=explode(" ",$request->firstname);
        $user->firstname = $name[0];
        $user->lastname = $name[1] ?? '';
        $user->username = $request->username;
        $user->password = Hash::make($request->password);
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->city = $request->city;
        $user->postalcode = $request->postalcode;
        $user->province = $request->province;
        $user->type = 'customer';
        $user->payment_term = $request->payment_term ?? 0;
        $user->payment_method = $request->payment_method;
        $user->customer_type = $request->customer_type;
        $user->description = $request->description;
        $user->business_name = $request->business_name;
        $user->sales_rep=$request->sales_rep;
        $user->driver_id=$request->driver_id;
        $user->profile_picture = $this->__uploadImage();
    
        // die(print_r($user));
        // print_r($user);
        // die;
        // if($request->hasFile('profile_picture') && $request->file('profile_picture')->isValid())
        // {
        //     $filename = str_random(40).'.'.$request->profile_picture->extension();
        //     $request->profile_picture->storeAs('media/customers',$filename);
        //     $user->profile_picture = $filename;
        // }
        try {
            $user->save();
            $account = new Account();
            $account->user_id = $user->id;
            $account->save();
            success('Customer', 'Created');
        }
        catch(\Exception $e) {
            failure('customer', 'create');
        }
        if($request->ajax()) {
            return response()->json(['status'=>'success','user'=>$user]);
        }
        return redirect(admin_url('customers'));
    }
    
    public function show($id) 
    {
        $user = User::find($id) or abort(404);
        $title = "Customers";
        $msg = "Edit";
        $submenu = "Customers";
        return view('admin.customer.customerview', compact('user', 'title', 'msg', 'submenu'));
    }
    
    public function edit($id)
    {
        if (auth()->user()->cannot('Customer Edit')) {
            return redirect('/');
        }
        //$users = User::orderBy('created_at','DESC')->get();
        $user = User::find($id) or abort(404);
        $submenu = "Customers";
        $province = Province::get();
        $paymentterms = PaymentTerm::get();
        $paymentmethods = PaymentMethod::get();
        $customertypes = CustomerType::get();
        $title="Customers";
        $drivers=User::where(['type'=>'staff','status'=>1,'customer_type'=>3])->get();
        $salesreps=User::where(['type'=>'staff','status'=>1,'customer_type'=>5])->get();
        return view('admin.customer.customersadd', compact('user', 'submenu', 'province', 'paymentterms', 'paymentmethods', 'customertypes','title','salesreps','drivers'));
    }
    
    public function update(Request $request, $id)
    {
        $rules = ['firstname' => 'bail|required|max:50', 'address' => 'bail|required|max:100', 'email' => 'bail|unique:users,email,' . $id, 'phone' => 'bail', 'province' => 'bail|string|max:2|min:2'];
        
        if($request->email == '') {
            $rules['email'] = '';
        }
        
        $request->validate($rules);
        $user = User::find($id) or abort(404);
        $name=explode(" ",$request->firstname);
        $user->firstname = $name[0];
        $user->lastname = $name[1] ?? '';
        //$user->username      = $request->username;
        //$user->password      = Hash::make($request->password);
        $user->email = $request->email;

        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->city = $request->city;
        $user->postalcode = $request->postalcode;
        $user->province = $request->province;
        $user->payment_term = $request->payment_term;
        $user->payment_method = $request->payment_method;
        $user->customer_type = $request->customer_type;
        $user->description = $request->description;
        $user->business_name = $request->business_name;
        $user->driver_id=$request->driver_id;
        if (!empty(request()->input('profile_picture')))
        {
        if ($user->profile_picture = $this->__uploadImage()) 
            $this->__deleteImage($user->profile_picture);
        }
        try {
            $user->save();
            success('Customer', 'Updated');
        }
        catch(\Exception $e) {
            failure('customer', 'update');
        }
        if($request->ajax()) {
            return response()->json(['status'=>'success','user'=>$user]);
        }
        return redirect(admin_url('customers'));
    }
    
    public function destroy($id) 
    {
        if (auth()->user()->cannot('Customer Delete')) {
            return redirect('/');
        }

        $user = User::find($id) or abort(404);
        // @unlink('media/' . $user->profile_picture);
        try {
            $this->__deleteImage($user->profile_picture);
            $user->delete();
            success('Customer', 'Deleted');
        }
        catch(\Exception $e) {
            failure('customer', 'delete');
        }
        return redirect(admin_url('customers'));
    }
    
    public function changeStatus($id)
    {
        $user = User::find($id) or abort(404);
        $user->status = !$user->status;
        try {
            $user->save();
            //     print_r($user);
            // //print($status);
            // die;
            success('Status', 'Updated');
        }
        catch(\Exception $e) {
            failure('status', 'change');
        }
        return redirect(admin_url('customers'));
    }
    
    public function type($type = null)
    {
        if (auth()->user()->cannot('Customer View')) {
            return redirect('/');
        }
        if ($type != null) {
            $customer = CustomerType::with('type')->select('users.id', 'accounts.debit', 'accounts.credit', 'users.firstname', 'users.lastname', 'users.email', 'users.address', 'users.city', 'users.country', 'users.phone', 'users.status', 'users.customer_type', 'users.created_at')->where('type', 'customer')->join('accounts', 'accounts.user_id', '=', 'users.id')->get();
        } else {
            //$customer = User::with('account')->where('type','customer')->get();
            $customer = User::select('users.id', 'accounts.debit', 'accounts.credit', 'users.firstname', 'users.lastname', 'users.email', 'users.address', 'users.city', 'users.country', 'users.phone', 'users.status', 'users.customer_type', 'users.created_at')->where('type', 'customer')->join('accounts', 'accounts.user_id', '=', 'users.id')->get();
            $submenu = "All";
        }
        
        $customertypes = CustomerType::get();
        // $title="Customers";
        return view('admin.customer.customers', compact('customer', 'submenu', 'customertypes'));
    }
    

    public function __uploadImage($existing = '') 
    {
         if (!empty(request()->input('profile_picture')) && strlen(request()->input('profile_picture')) > 6) {
            $picture = request()->input('profile_picture');
            if (preg_match('/data:image/', $picture)) {
                list($type, $picture) = explode(';', $picture);
                list($i, $picture) = explode(',', $picture);
                $picture = base64_decode($picture);
                $image_name = Str::random(30) . '.png';
                Storage::put('images/users/' . $image_name, $picture);
                // $user->profile_picture = $image_name;
                return $image_name;
            }
        }
        return null;
    }
    
    public function __deleteImage($existing = '')
    {
        if ($existing != '')
          @unlink('images/users/' . $user->profile_picture);
    }
    public function getDetails($id)
    {
        $customer=User::where('id',$id)->get();
        return json_encode($customer);
    }

    public function search(Request $request) {
        if($request->keyword != '') {
            $keyword = $request->keyword;
// $q->where('due_date','>',date('Y-m-d'));
            $users = User::with(['paymentterm','paymentmethod','invoice'=>function($q){
                    $q->where('status','>=',0);
                }])->where('type','customer')->where(function($query) use ($keyword) {

                $query->where('firstname','LIKE','%'.$keyword.'%')
                        ->orWhere('lastname','LIKE','%'.$keyword.'%')
                        ->orWhere('email','LIKE','%'.$keyword.'%')
                        ->orWhere('business_name','LIKE','%'.$keyword.'%')
                        ->orWhere('phone','LIKE','%'.$keyword.'%');

            })->orderBy('firstname','ASC')->get();
            
            
            
            $customers = array();
            
            foreach($users as $user) {
                
                $due = $user->invoice->sum('grand_total') - $user->invoice->sum('paid_total');
                $user->payment_days = trim($user->paymentterm->value??0);
                $user->due = $due;
                $customers[] = $user;
            }

            return response()->json($customers);
        }

    }
    public function searchTable($keys)
    {

        $customerquery=User::sortable()->with(['types','invoice'=>function($query){$query->where('status',0);}]);
        if(isset($keys) && $keys !='')
        {
        if ($keys->get('search') != '') {
            $customerquery->where('city','like','%'.$keys['search'].'%')->orWhere('firstname','like','%'.$keys['search'].'%')->orWhere('lastname','like','%'.$keys['search'].'%')->orWhere('business_name','like','%'.$keys['search'].'%')->orWhere('address','like','%'.$keys['search'].'%');
        }
        if ($keys->customer_type != '') {
            $customerquery->where('customer_type', $keys->customer_type);
        }
        if (request()->status == "1") {
            $customerquery->where('status', '1');
        }
        if (request()->status == "0") {
            $customerquery->where('status', '0');
        }
         }   
        $customer=$customerquery->where('type', 'customer')->paginate(10);
    }
    public function getDues($id)
    {
         $dues = Invoice::where('status','>=',0)->where('customer_id',$id)->get();
         return response()->json($dues);
    }


    public function priceList($id) {

        $title = 'Price List';
        $submenu = '';

        $products = DB::select("SELECT *,p.id AS id,p.price AS price, cp.price AS special_price 
                                FROM products p LEFT JOIN customer_price cp ON p.id=cp.product_id AND cp.status=1 AND cp.customer_id={$id}");

        return view('admin/customer/customer-prices',compact('products','title','submenu'));

    }

    public function updatePriceList($id, Request $request) {
        
        foreach($request->price as $key=>$val) {
            if($val != '') {
                DB::table('customer_price')->where(['product_id'=>$key,'price'=>$val,'customer_id'=>$id])->delete();
                DB::table('customer_price')->insert(['product_id'=>$key,'price'=>$val,'customer_id'=>$id,
                            'status'=>1,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
            }
        }

        return redirect('admin/customers');
        exit;
    }

    function updateRate(Request $request) {

        $customer_id = $request->rate_customer;

        foreach($request->product as $key=>$val) {
            if($request->rate_customer != '' && $key != '' && is_numeric($val)) {
                DB::table('customer_price')->where(['customer_id'=>$customer_id, 'product_id'=>$key])->delete();
                DB::table('customer_price')->insert(['product_id'=>$key, 'price'=>$val, 'status'=>1, 'customer_id'=>$request->rate_customer,
                                                    'created_at'=>date('Y-m-d H:i:s'), 'updated_at'=>date('Y-m-d H:i:s')]);
            }
        }

        return response()->json(['request'=>$request->all(),'status'=>'success']);
    }
    
}
