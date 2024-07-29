<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRequest;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Http\Resources\CustomerResource;
use App\User;
use App\Province;
use App\UserType;


class StaffsController extends Controller
{

    public function index()
    {
        if(auth()->user()->cannot('Staff View'))
        {
        return redirect('/');
    }
        // $staffs= User::select('roles.name','users.id','users.firstname','users.lastname','users.email','users.address','users.city','users.country','users.phone','users.status','users.created_at','users.profile_picture')->join('model_has_roles','model_has_roles.model_id','=','users.id')->join('roles','roles.id','=','model_has_roles.role_id')->where('type','staff')->paginate(10);
        $title = "Staffs";
        $submenu = "Staffs";
        return view('admin.staff.staffs',compact('title','submenu'));
    }
    
    public function defer(Request $request){
        $key    = $request->get('key');
        if($key)
        $staffs= User::sortable()->select('roles.name','users.id','users.firstname','users.lastname','users.email','users.address','users.city','users.country','users.phone','users.status','users.created_at','users.profile_picture')->join('model_has_roles','model_has_roles.model_id','=','users.id')->join('roles','roles.id','=','model_has_roles.role_id')->where('type','staff')->where('city','like','%'.$key.'%')->orWhere('firstname','like','%'.$key.'%')->orWhere('lastname','like','%'.$key.'%')->orWhere('address','like','%'.$key.'%')->orWhere('email','like','%'.$key.'%')->orderBy('id','asc')->paginate(10);
       else
        $staffs= User::sortable()->select('roles.name','users.id','users.firstname','users.lastname','users.email','users.address','users.city','users.country','users.phone','users.status','users.created_at','users.profile_picture')->join('model_has_roles','model_has_roles.model_id','=','users.id')->join('roles','roles.id','=','model_has_roles.role_id')->where('type','staff')->orderBy('id','asc')->paginate(10);
        return [
            'data' => CustomerResource::collection($staffs),
            'links' => (string) $staffs->links(),
        ];
    }


    public function create()
    {
        if(auth()->user()->cannot('Staff Create'))
        {
        return redirect('/');
    }
        $provinces = Province::get();
        $roles = Role::all();
        $title = "Staffs";
        $submenu="Staffs";

        return view('admin.staff.staff-form',compact('provinces','roles','title','submenu'));
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
        $user->type          = 'staff';
        $user->customer_type=$request->role;
        $user->profile_picture = $this->__uploadImage();
        try {
            $user->save();

            $role = Role::find($request->role);
            $user->syncRoles([$role]);
           
            session()->flash('message','Successfully created the '.$user->type);
        }
        catch(\Exception $e) {
            session()->flash('message','Unable to create the staff. Please try again.'.$e->getMessage());
        }
        
        return redirect(admin_url('staffs'));
        
    }

    public function show($id)
    {
        $user=User::find($id) or abort(404);
        $title="Staffs";
        $msg="Edit";
        $submenu="Staffs";
        return view('admin.staffview',compact('user','title','msg','submenu'));
    }

    public function edit($id)
    {
        if(auth()->user()->cannot('Staff Edit'))
        {
        return redirect('/');
        }
        //$users = User::orderBy('created_at','DESC')->get();
        $user = User::find($id) or abort(404);
        $title="Staffs";
        $msg="Edit";
        $submenu="Staffs";

        $provinces = Province::get();
        $roles = Role::all();
        return view('admin.staff.staff-form',compact('user','title','msg','submenu','provinces','roles'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'firstname'   => 'bail|required|max:50',
            'lastname'    => 'bail|required|max:50',
            'address'     => 'bail|required|max:100',
            
            'phone'       => 'bail|numeric',
            'province'    => 'bail|string|max:2|min:2'
            ]);
        $user = User::find($id) or abort(404);
        
        $user->firstname     = $request->firstname;
        $user->lastname      = $request->lastname;
        // $user->username      = $request->username;
        if($request->password != '')
        $user->password      = Hash::make($request->password != '');
        
        $user->email         = $request->email;
        $user->phone         = $request->phone;
        $user->address       = $request->address;
        $user->city          = $request->city;
        $user->postalcode    = $request->postalcode;
        $user->province      = $request->province;
        $user->type          = 'staff';
        $user->customer_type=$request->role;
        if($user->profile_picture = $this->__uploadImage())
            $this->__deleteImage($user->profile_picture);
        
        
        try {
            $user->save();
            $role = Role::find($request->role);
            $user->syncRoles([$role]);
            session()->flash('message','Successfully updated the staff');
        }
        catch(\Exception $e) {
            die(print($e->getMessage()));
            session()->flash('message','Unable to update the staff. Please try again.');
        }
        
        return redirect(admin_url('staffs'));
    }
        
    public function destroy($id)
    {
        if(auth()->user()->cannot('Staff Delete'))
        {
        return redirect('/');
        }
        $user = User::find($id) or abort(404);
        @unlink('media/'.$user->profile_picture);
        $type=$user->type;
        try {
            $user->delete();
            session()->flash('message',$type.' successfully deleted');
        }
        catch(\Exception $e) {
            session()->flash('message','Unable to delete the user');
        }
        
        return redirect(admin_url('staffs'));
    }

    public function changeStatus($id)
    {
        $user=User::find($id) or abort(404);
        $user->status=!$user->status;
        $user->save();
        try {
            $user->save();
            session()->flash('message',$user->type.' status changed');
        }
        catch(\Exception $e) {
            session()->flash('message','Unable to change status');
        }
        
        return redirect(admin_url('staffs'));
    }
    public function __uploadImage($existing = '') {
        
        //print_r(request()->hasFile('profile_picture'));
        // if(request()->hasFile('profile_picture') && request()->file('profile_picture')->isValid())
        // {
            

        //     $filename = str_random(40).'.'.request()->profile_picture->extension();
            
        //     try {
                
        //         request()->profile_picture->storeAs('media/staffs',$filename);
        //     }
        //     catch(\Exception $e) {
                
        //     }
            
        //     return $filename;
        // }
        
        // return null;
        
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
    
    public function __deleteImage($existing = '') {
        if($existing != '')
            @unlink('images/users/'.$user->profile_picture);
    }
}
