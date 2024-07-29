<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRequest;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Province;
use App\Account;
use App\CustomerType;
use App\PaymentTerm;
use App\PaymentMethod;

class CustomerTypeController extends Controller
{

    public function index()
    {
        $customertypes=CustomerType::with(['customer'=>function($q){$q->where('type','customer');
            }])->paginate(10);
        // die(print_r($customertypes));
        $submenu = "Customertype";
        $title = "Customers";
        return view('admin.customertype.list',compact('submenu','customertypes','title'));
    }
    public function create()
    {
        $submenu="customertype";
        $title = "Customers";
        return view('admin.customertype.add',compact('submenu','title'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name'   => 'bail|required'
            ]);
        $customertype=new CustomerType();
        $customertype->name=$request->name;
        try
        {
            $customertype->save();
            return redirect('admin/customertype')->with('message',"Customer Type Added Successfully");
        }
        catch(Exception $e)
        {
            return redirect()->back();
        }
    }
    public function edit($id)
    {
        $submenu="customertype";
        $title = "Customers";
        $customertype=CustomerType::find($id);
        return view('admin.customertype.add',compact('submenu','customertype','title'));
    }
    public function update(Request $request,$id)
    {
        $request->validate([
            'name'   => 'bail|required'
            ]);
        $customertype=CustomerType::find($request->id);  
        $customertype->name=$request->name;
        try
        {
            $customertype->save();
            return redirect('admin/customertype')->with('message',"Customer Type Updated Successfully");
        }
        catch(Exception $e)
        {
            return redirect()->back();
        }
    }
    public function destroy($id)
    {
        $customertype=CustomerType::find($id);
        try
        {
            $user=User::where('customer_type',$id);
            $user->customer_type = 0;
            $user->save();
            $customertype->delete();
            return redirect('admin/customertype')->with('message',"Customer Type Deleted Successfully");
        }
        catch(Exception $e)
        {
            return redirect()->back();
        }
    }
    public function getCustomers($id)
    {
        $submenu = "Customertype";
        $title = "Customers";
        $customers=User::where(['type'=>'customer','customer_type'=>$id])->get();
        $type=CustomerType::find($id)->name;
        return view('admin.customertype.customers',compact('submenu','customers','title','type'));
        // die(print_r($customers));
    }
}
