<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Route;

class RoutesController extends Controller
{
    /**
     * Show the profile for a given user.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $submenu="Routes";
        $title="Routes";
        $routes=Route::get();
        return view('admin.routes.index',compact('submenu','title','routes'));
    }
    public function create()
    {
        $submenu="Routes";
        $title="Routes";
        
        return view('admin.routes.form',compact('submenu','title'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'city'=>'required',
            'places'=>'required'
            ]);
        $route=new Route();
        $route->name=$request->name;
        $route->city=$request->city;
        $route->places=$request->places;
        try
        {
            $route->save();
            return redirect('admin/routes')->with('message',"Successfully Added");
        }
        catch(Exception $e)
        {
            
        }
    }
    public function edit($id)
    {
        $submenu="Routes";
        $title="Routes";
        $route=Route::find($id);
        return view('admin.routes.form',compact('submenu','title','route'));
    }
    public function update(Request $request, $id)
    {
       $request->validate([
            'name'=>'required',
            'city'=>'required',
            'places'=>'required'
            ]);
        $route=Route::find($id);
        $route->name=$request->name;
        $route->city=$request->city;
        $route->places=$request->places;
        try
        {
            $route->save();
            return redirect('admin/routes')->with('message',"Successfully Updated");
        }
        catch(Exception $e)
        {
            
        } 
    }
    public function delete($id)
    {
        $route=Route::find($id);
        try
        {
            $route->delete();
            return redirect('admin/routes')->with('message',"Successfully Deleted");
        }
        catch(Exception $e)
        {
            
        } 
    }
}