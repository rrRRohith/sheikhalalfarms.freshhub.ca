<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\PermissionRequest;
use App\User;

class PermissionController extends Controller
{
    public function index()
    {
    	$permissions = Permission::all();
        return view('admin.permission.permissions',compact('permissions'));
    }


    public function create()
    {
        return view('admin.permission.permission-form');
    }


    public function store(PermissionRequest $request)
    {
        try {
            Permission::create(['name' => $request->name ]);
            session()->flash('message','Successfully created the permission');
        }
        catch(\Exception $e) {
            session()->flash('message','Unable to create the permission. Please try again.');
        }
        
        return redirect(admin_url('permissions'));
        
    }

    public function show($id)
    {
        /*
            $user=User::find($id) or abort(404);
            $title="Staffs";
            $msg="Edit";
            return view('admin.staffview',compact('user','title','msg'));
        */
    }

    public function edit($id)
    {
        $permission = Permission::find($id) or abort(404);
        return view('admin.permission.permission-form',compact('permission'));
    }

    public function update(PermissionRequest $request, $id)
    {
        $permission = Permission::find($id) or abort(404);
        
        $permission->name  = $request->name;
        
        try {
            $permission->save();
            session()->flash('message','Successfully updated the permission');
        }
        catch(\Exception $e) {
            session()->flash('message','Unable to update the permission. Please try again.');
        }
        
        return redirect(admin_url('permissions'));
    }
        
    public function destroy($id)
    {
        $permission = Permission::find($id);
       
        try {
            $permission->delete();
            session()->flash('message','Permission successfully deleted');
        }
        catch(\Exception $e) {
            session()->flash('message','Unable to delete the permission');
        }
        
        return redirect(admin_url('permissions'));
    }

}
