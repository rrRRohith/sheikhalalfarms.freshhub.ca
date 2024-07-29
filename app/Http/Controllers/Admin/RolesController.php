<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\RoleRequest;
use App\User;

class RolesController extends Controller
{
    public function index()
    {
    	$roles = Role::paginate(10);
    	$title = "Settings";
    	$submenu = "Roles";
        return view('admin.role.roles',compact('roles','title','submenu'));
    }


    public function create()
    {
        $title = "Settings";
        $submenu = "Roles";
        $permissions = Permission::all();
        return view('admin.role.role-form',compact('permissions','title','submenu'));
    }


    public function store(RoleRequest $request)
    {
        try {
            $role = Role::create(['name' => $request->name ]);
            $role->syncPermissions($request->permissions);
            session()->flash('message','Successfully created the role');
        }
        catch(\Exception $e) {
            session()->flash('message','Unable to create the role. Please try again.');
        }
        
        return redirect(admin_url('roles'));
        
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
        $title = "Settings";
        $submenu = "Roles";
        $role = Role::find($id) or abort(404);
        $permissions = Permission::all();

        return view('admin.role.role-form',compact('role','permissions','title','submenu'));
    }

    public function update(RoleRequest $request, $id)
    {
        $role = Role::find($id) or abort(404);
        
        $role->name  = $request->name;
        
        try {
            $role->save();
            $role->syncPermissions($request->permissions);

            session()->flash('message','Successfully updated the role');
        }
        catch(\Exception $e) {
            session()->flash('message','Unable to update the role. Please try again.');
        }
        
        return redirect(admin_url('roles'));
    }
        
    public function destroy($id)
    {
        $role = Role::find($id);
       
        try {
            $role->delete();
            session()->flash('message','Role successfully deleted');
        }
        catch(\Exception $e) {
            session()->flash('message','Unable to delete the role');
        }
        
        return redirect(admin_url('roles'));
    }

}
