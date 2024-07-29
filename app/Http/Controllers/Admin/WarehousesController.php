<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\WarehouseRequest;
use Illuminate\Support\Facades\Hash;
use App\Warehouse;

class WarehousesController extends Controller
{

    public function index()
    {
        $warehouse = Warehouse::get();
        $submenu="Warehouses";
        $title = "Inventories";
        return view('admin.warehouse.warehouses',compact('warehouse','submenu','title'));
    }


    public function create()
    {
        $submenu="Warehouses";
         $title = "Inventories";
        return view('admin.warehouse.warehousesadd',compact('submenu','title'));
    }


    public function store(WarehouseRequest $request)
    {
        $warehouse = new Warehouse();
        
        $warehouse->name     = $request->name;
        $warehouse->status      = $request->has('status');
        
        // print_r($user);
        // die;
        
       
        
        
        
        try {
            
            $warehouse->save();
           
            session()->flash('message','Successfully created the warehouse');
        }
        catch(\Exception $e) {
            session()->flash('message','Unable to create the warehouse. Please try again.');
        }
        
        return redirect(admin_url('warehouses'));
        
    }

    public function edit($id)
    {
        //$users = User::orderBy('created_at','DESC')->get();
        $warehouse = Warehouse::find($id) or abort(404);
         $submenu="Warehouses";
          $title = "Inventories";
        return view('admin.warehouse.warehousesadd',compact('warehouse','submenu','title'));
    }

    public function update(WarehouseRequest $request, $id)
    {
        $request->validate([ 'name'   => 'bail|required|max:50',]);
        $warehouse = Warehouse::find($id) or abort(404);
        
        $warehouse->name     = $request->name;
        $warehouse->status      = $request->has('status');
        
        
        
        try {
            $warehouse->save();
            session()->flash('message','Successfully updated the warehouse');
        }
        catch(\Exception $e) {
            session()->flash('message','Unable to update the warehouse. Please try again.');
        }
        
        return redirect(admin_url('warehouses'));
    }
        
    public function destroy($id)
    {
        $warehouse = Warehouse::find($id) or abort(404);
       
        try {
            $warehouse->delete();
            session()->flash('message','Warehouse successfully deleted');
        }
        catch(\Exception $e) {
            session()->flash('message','Unable to delete the warehouse');
        }
        
        return redirect(admin_url('warehouses'));
    }
    public function changeStatus($id)
    {
        $warehouse=Warehouse::find($id) or abort(404);
        $warehouse->status= !$warehouse->status;
        $warehouse->save();
        try {
            $warehouse->save();
            session()->flash('message','Warehouse  status changed');
        }
        catch(\Exception $e) {
            session()->flash('message','Unable to change status');
        }
        
        return redirect(admin_url('warehouses'));
    }
    
    
}
