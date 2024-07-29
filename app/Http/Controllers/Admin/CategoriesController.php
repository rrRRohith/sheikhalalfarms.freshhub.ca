<?php

namespace App\Http\Controllers\Admin;

//use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests\CategoryRequest;
use Illuminate\Support\Facades\Hash;
use App\Product;
use App\Category;

class CategoriesController extends Controller
{

    public function index()
    {
        $categories = Category::orderBy('name','ASC')->paginate(10);
        $title = "Products";
        $submenu = "Category";
        return view('admin.category.categories',compact('categories','title','submenu'));
    }


    public function create()
    {
        $title = "Products";
         $submenu = "Category";
        $categories = Category::where('parent_id',null)->orderBy('name','ASC')->get();
        return view('admin.category.category-form',compact('categories','title','submenu'));
    }


    public function store(CategoryRequest $request)
    {
        $category = new Category();
        
        $category->name           = $request->name;
        $category->description    = $request->description;
        $category->parent_id      = $request->parent_id;
        $category->status         = $request->has('status');
        
        try {
            $category->save();
            session()->flash('message','Successfully created the category');
        }
        catch(\Exception $e) {
            session()->flash('message','Unable to create the category. Please try again.');
        }
        
        return redirect(admin_url('categories'));
        
    }

    public function edit($id)
    {
        $title = "Products";
         $submenu = "Category";
        $category = Category::find($id) or abort(404);
        $categories = Category::where('id','!=',$id)->where('parent_id',null)->orderBy('name','ASC')->get();
        return view('admin.category.category-form',compact('category','categories','title','submenu'));
    }

    public function update(CategoryRequest $request, $id)
    {
        $category = Category::find($id) or abort(404);
        
        
        $category->name            = $request->name;
        $category->description     = $request->description;
        $category->parent_id       = $request->parent_id;
        $category->status          = $request->has('status');

        try {
            $category->save();
            session()->flash('message','Successfully updated the category');
        }
        catch(\Exception $e) {
            session()->flash('message','Unable to update the category. Please try again.');
        }
        
        return redirect(admin_url('categories'));
    }
        
    public function destroy($id)
    {
        $category = Category::find($id) or abort(404);
        
        try {
            $category->delete();
            session()->flash('message','Category successfully deleted');
        }
        catch(\Exception $e) {
            session()->flash('message','Unable to delete the category');
        }
        
        return redirect(admin_url('categories'));
    }


    public function changeStatus($id)
    {
        $category = Category::find($id) or abort(404);
        $category->status = !$category->status;
        $category->save();
        
        try {
            $category->save();
            $product=Product::where('category_id',$id)->update(['status'=>$category->status]);
            $product->save();
            session()->flash('message','Category status changed');
        }
        catch(\Exception $e) {
            session()->flash('message','Unable to change the status');
        }
        // if($request->ajax()) {
        //     return response()->json(['status'=>'success','category'=>$category]);
        // }
        return redirect(admin_url('categories'));
    }
    
}
