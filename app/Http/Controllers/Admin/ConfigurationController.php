<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Hash;
use App\Email;
use App\Message;
use App\User;
use App\Store;
use App\UnitType;
use App\Setting;
use App\Http\Requests\MailRequest;


class ConfigurationController extends Controller
{
    
    public function index()
    {
        // $category = Category::get();
        $title="Configuration";
        $title="Settings";
        $submenu = "Configuration";
        $setting=Setting::first();
        return view('admin.configuration',compact('title','submenu','title','setting'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'tax'=>'required|numeric'
            ]);
        $setting=Setting::first();
        if(!isset($setting))
         $setting=new Setting();
        $setting->organization_name=$request->organization_name;
        $setting->organization_description=$request->organization_description;
        $setting->website=$request->website;
        $setting->phone=$request->phone;
        $setting->sale_email=$request->sale_email;
        $setting->support_email=$request->support_email;
        $setting->sms_api_id=$request->sms_api_id;
        $setting->tax=$request->tax;
        try {
            
            $setting->save();
           
          success('Setting','Added');
           //Mail::to($recmail->email)->bcc('cintafc96@gmail.com')->send(new EmailSent($message));
          return redirect(admin_url('configuration'));
           
        }
        catch(\Exception $e) {
            die(print($e->getMessage()));
            failure('Setting','Added');
            return redirect()->back();
            
        }
    }
    public function viewemail()
    {
        $submenu="Emails";
        $email=Email::get();
        $title = "Configuration";
        return view('admin.message.email',compact('submenu','email','title'));
    }
    public function inbox()
    {
        $id=Auth::id();
        $submenu="Inbox";
        $title="Message";
      $email=Message::where('recipient_id',$id)->where('status_recipient',0)->paginate(10);
        return view('admin.message.inbox',compact('submenu','email','title'));
    }
    public function compose()
    {
        $recipient=User::where('type','!=','admin')->get();
        $submenu="Compose";
        $title="Message";
       // $email=Email::get();
       
        return view('admin.message.compose',compact('submenu','recipient','title'));
    }
    public function outbox()
    {
        $id=Auth::id();
        $submenu="Outbox";
       // $email=Email::get();
       $title="Message";
       $email=Message::where('sender_id',$id)->where('status_sender',0)->paginate(10);
        return view('admin.message.outbox',compact('submenu','email','title'));
    }
    public function sendmail(MailRequest $request)
    {
        $recmail=User::where('id',$request->recipient_id)->first();
        $message=new Message();
        $message->sender_id=Auth::id();
        $message->sender_email=Auth::User()->email;
        $message->recipient_id=$request->recipient_id;
        $message->recipient_email=$recmail->email;
        $message->subject=$request->subject;
        $message->body_html=$request->message;
        $message->body_text=$request->message;
        // print_r($message);
        // die;
        try {
            
            $message->save();
           
          success('Email','Sent');
           //Mail::to($recmail->email)->bcc('cintafc96@gmail.com')->send(new EmailSent($message));
          return redirect(admin_url('outbox'));
           
        }
        catch(\Exception $e) {
            failure('message','send');
            return redirect()->back();
            
        }
        

    }
    public function markasread($id)
    {
        $mark=Message::find($id) or abort(404);
        $mark->read_at=date('Y-m-d');
         try {
        $mark->save();
        success('Message','updated.');
           //Mail::to($recmail->email)->bcc('cintafc96@gmail.com')->send(new EmailSent($message));
          return redirect(admin_url('messages'));
         }
         catch(\Exception $e) {
            failure('message','update');
            return redirect()->back();
            
        }
         
    }
      public function viewSentMessage($id){
        
        $title="Messages";
        $submenu="Outbox";
         $message = Message::find($id);
        return view('admin.message.view-sentMessages',compact('title','submenu','message'));
        
    }
     public function viewMessage($id){
        
        $title="Messages";
        $submenu="Inbox";
         $message = Message::find($id);
        return view('admin.message.view-messages',compact('title','submenu','message'));
        
    }
    public function unitType()
    {
        $title="Unit Type";
        $submenu="Unit Type";
        $unittypes=UnitType::get();
        return view('admin.unittype.index',compact('title','submenu','unittypes'));
    }
    public function deleteemail($id,$type)
    {
        $msg=Message::find($id) or abort(404);
        if($type==0)
        {
            $msg->status_sender=1;
        }
        else
        {
            $msg->status_recipient=1;
        }
        try {
            
            $msg->save();
          success('Email','Delete');
          //return redirect(customer('outbox'));
            return redirect()->back();
           
        }
        catch(\Exception $e) {
            failure('message','send');
          //   return redirect(customer('outbox'));
            return redirect()->back();
            
        }
        
        
    }



    
}
