@extends('layouts.customer.header')
@section('contents')
<div class="content-container">
<div class="content-area">
<div class="row">
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-xs-padding">
<div class="card no-margin minH">
<div class="card-block">
<div class="card-title">
   <div class="card-title-header">
      <div class="card-title-header-titr"><b>Outbox</b></div>
      <div class="card-title-header-between"></div>
      <div class="card-title-header-actions">
         <a href="#"><img src="{{asset('img/help.svg')}}" alt="help"
            class="card-title-header-img card-title-header-details"></a>
      </div>
   </div>
</div>
<section class="card-text">
    @if (Session::has('message'))
                                 <div class="alert alert-success">
                                    <font color="red" size="4px">{{ Session::get('message') }}</font>
                                 </div>
                                 @endif
<div class="table-list-responsive-md">
   <table class="table table-list mt-0 jsScrollTable">
      <thead class="table-list-header-options">
      </thead>
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
               <label>
                    <a target="" href="{{url('customer/message')}}/{{$e->id}}/del/0" class="icon-table" rel="tooltip" data-tooltip=" Delete">
                    <clr-icon shape="trash" size="22"></clr-icon>
                    </a>
                </label>
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
      </thead>
      <tbody>
      </tbody>
      <tfoot>
         <tr>
         </tr>
      </tfoot>
   </table>
</div>
<br>
@endsection