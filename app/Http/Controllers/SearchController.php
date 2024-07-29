<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Customer;
use App\Category;
use App\Product;
use App\CustomerType;
class SearchController extends Controller
{
    public function search()
    {
        $title ="";
        $submenu = "";
        $search=request()->keyword;
        if($search !='')
        {
          $customers = User::where('firstname', 'like', '%' .$search. '%')->orWhere('lastname', 'like', '%' .$search. '%')->orWhere('address', 'like', '%' .$search. '%')->get();
          $categories = Category::where('name','like','%' .$search. '%')->get();
          $products = Product::where('name','like','%' .$search. '%')->get();
          $customertypes = CustomerType::get();
        	return view('customers.search',compact('customers','categories','products','search','customertypes','title','submenu')); 
        }
        else
        
        {
            return redirect()->back();
        }
    }
}