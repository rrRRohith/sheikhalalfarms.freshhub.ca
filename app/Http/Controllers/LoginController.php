<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\User;
class LoginController extends Controller
{
    use AuthenticatesUsers;
    
    public function authenticate(Request $request)
    {

        if(Auth::guard('customer')->attempt(['username'=>$request->email, 'password'=>$request->password, 'type' => 'customer', 'status' => 1])) 
        {
            
            return redirect('customer');
            exit;
        }
        elseif(Auth::guard('admin')->attempt(['username'=>$request->email, 'password'=>$request->password, 'type' => 'staff', 'status' => 1])) 
        {
            return redirect('admin'); 
            exit;
        }
        elseif(Auth::guard('admin')->attempt(['username'=>$request->email, 'password'=>$request->password, 'type' => 'admin', 'status' => 1])) 
        {
            return redirect('admin'); 
            exit;
        }
        else
        {
            session()->flash('message','<div class="alert alert-danger">Invalid Login attempt!</div>');
            return redirect('/');
            exit;
        }

    }

    public function logout()
    {
       Auth::guard('admin')->logout();
       Auth::guard('customer')->logout();
       return redirect('/');
    }
    // public function forgotPassword()
    // {
    //     return view('forgotpassword');
    // }
    public function forgotPasswordLink(Request $request)
    {
        $request->validate([
            'email'=>'bail|required|exists:users,email'
            ]);
        $user=User::where('email',$request->email)->first();
        $id=str_random($user->id);
        $user->token_id=$id;
        $user->save();
        $link=url('/resetpassword/'.$id);
        return redirect($link);
    }
    public function resetPassword($id)
    {
       $user=User::where('token_id',$id)->first(); 
        if(isset($user))
            return view('resetpassword',compact('id'));
        else
            return redirect('/')->with('message','Invalid User');
    }
    public function resetPasswordStore(Request $request)
    {
       $request->validate([
           'password'=>'required|confirmed|min:6'
           ]);
       $user=User::where('token_id',$request->id)->first(); 
            $user->password=Hash::make($request->password);
       
       try
       {
           $user->save();
           return redirect('/')->with('message','Password Reset Successfully Completed');
       }
       catch(Exception $e)
       {
           return redirect()->back()->with('error','Error in reset password');
       }
    }
}
