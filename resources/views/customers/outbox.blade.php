@extends('layouts.customer')
@section('title','Outbox')
@section('page_title','Messages')
@section('page_nav')
<ul>
    <li><a href="{{customer_url('messages')}}">Inbox</a> </li>
    <li><a href="{{customer_url('compose')}}">Compose</a> </li>
    <li class="active"><a href="{{customer_url('outbox')}}">Sent Items</a> </li>  
</ul>
@endsection
@section('contents')
<div class="content-container">
<div class="content-area">
<div class="row main_content">
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
<div class="card no-margin minH">
<div class="card-block">
<h3>Sent Items</h3>
<section class="card-text">
    @if (Session::has('message'))
                                 <div class="alert alert-success">
                                    <font color="red" size="4px">{{ Session::get('message') }}</font>
                                 </div>
                                 @endif
<div class="table-list-responsive-md">
    <table class="table table-list mt-0 jsScrollTable">
        <thead>
         <tr>
            <th class="text-left">
                ID
            </th>
            <th class="text-left">Recipient</th>
            <th class="text-left">Subject</th>
            
            <th class="text-left">Date</th>
            <th class="text-left">Action</th>
         </tr>
         </thead>
      <tbody>
          @if(isset($email) && count($email)>0)
         @foreach($email as $e)
         <tr>
            <td class="text-left">
             {{$e->id}}
            </td>
            <td class="text-left">
               {{$e->recipient_email}}
            </td>
            <td class="text-left">
               {{$e->subject}}
            </td>
            <td class="text-left">
               {{$e->created_at}}
            </td>
            <td class="text-left">
                <div class="fh_actions">
                    <a href="#" class="fh_link">Actions <i class="fa fa-caret-down"></i> </a>
                    <ul class="fh_dropdown text-left">
                        <!--<li><a href="{{customer_url('message/markasread')}}/{{$e->id}}">Mark As Read</a></li>-->
                        <a href="{{customer_url('message')}}/{{$e->id}}/del/0"><li><i class="fa fa-trash" aria-hidden="true"></i> Delete</li></a>
                        <a href="{{customer_url('viewmessage')}}/{{$e->id}}"><li><i class="fa fa-eye" aria-hidden="true"></i> View</li></a>
                    </ul>
                </div>
               
            </td>
         </tr>
         @endforeach
         @else
         <tr>
            <td colspan="4">
               <center>No Messages Found</center>
            </td>
         </tr>
         @endif
      </tbody>
      
   </table>
</div>
</section>
<div class="text-bold" style="padding:10px;"> {{$email->links()}}Showing Page {{$email->currentPage()}} of {{$email->lastPage()}} </div>
</div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection