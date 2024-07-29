@extends('layouts.admin')
@section('title','Inbox')
@section('page_title','Messages')
@section('page_nav')
<ul>
   <li class="active"><a href="{{admin_url('messages')}}">Inbox</a> </li>
  <li><a href="{{admin_url('compose')}}">Compose</a> </li>
  <li><a href="{{admin_url('outbox')}}">Sent Items</a> </li>  
</ul>
@endsection
@section('contents')
<div class="content-container">
   <div class="content-area">
      <div class="row main_content">
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card no-margin minH">
               <div class="card-block">
                      <div class="headercnt_top">
                                    <div class="innerpage_title">
                                        <h3>Inbox</h3>
                                    </div>
                           
                                                <div class="clearfix"></div>
                                 </div>
                   <section class="card-text customers_outer">
                     <div class="row filter-customer">
                           <div class="col-lg-12">
                              <div class="filter-customer-list">
                                 @if (Session::has('message'))
                                 <div class="alert alert-success">
                                    {{ Session::get('message') }}
                                 </div>
                                 @endif
                              
                                    <div class="table-list-responsive-md">
                                       <table class="table table-customer mt-0 inboxtable">
                                      
                                           <thead>
                                             <tr>
                                                <th class="text-left"> ID </th>
                                                <th class="text-left">Sender</th>
                                                <th class="text-left">Subject</th>
                                                <th class="text-left">Date</th>
                                                <th class="text-left">Action</th>
                                             </tr>
                                             </thead>
                                             @if(isset($email) && count($email)>0)
                                             @foreach($email as $e)
                                             <tr @if($e->read_at =='')
                                            
                                                     @endif >
                                                 <td class="text-left">
                                                   {{$e->id}}
                                                </td>
                                                <td class="text-left">
                                                   {{$e->sender_email}}
                                                </td>
                                                <td class="text-left">
                                                   {{$e->subject}}
                                                </td>
                                                <td class="text-left">
                                                   {{date('d M Y  h:i:a',strtotime($e->created_at))}}
                                                </td>
                                                <td class="text-left">
                                                   <!-- <label>-->
                                                   <!--     @if($e->read_at=='')-->
                                                   <!--         <a target="" href="{{admin_url('message/markasread')}}/{{$e->id}}" class="icon-table"  data-tooltip="Mark as read" rel="tooltip">-->
                                                   <!--             <clr-icon shape="check" size="22"></clr-icon>-->
                                                   <!--         </a>-->
                                                        
                                                   <!--     @endif-->
                                                   <!-- </label>-->
                                                   <!--<label>-->
                                                   <!--     <a target="" href="{{url('customer/message')}}/{{$e->id}}/del/1" class="icon-table" rel="tooltip" data-tooltip=" Delete">-->
                                                   <!--     <clr-icon shape="trash" size="22"></clr-icon>-->
                                                   <!--     </a>-->
                                                   <!-- </label>-->
                                                          <div class="fh_actions">
                                                            <a href="#" class="fh_link">Actions <i class="fa fa-caret-down"></i> </a>
                                                            <ul class="fh_dropdown">
                                                                <a href="{{admin_url('message/markasread')}}/{{$e->id}}"><li><i class="fa fa-check" aria-hidden="true"></i> Mark as read</li></a>
                                                                <a href="{{admin_url('viewmessage')}}/{{$e->id}}"><li><i class="fa fa-eye" aria-hidden="true"></i> View</li></a>
                                                                <a href="{{admin_url('message')}}/{{$e->id}}/del/1"><li><i class="fa fa-trash" aria-hidden="true"></i> Delete</li></a>
                                                            </ul>
                                                    </div> 
                                                   
                                                     <!-- <select  class="form-control" onchange="location=this.options[this.selectedIndex].value;">-->
                                                     <!--       <option></option>-->
                                                     <!--        @if($e->read_at=='')-->
                                                     <!--       <option value="{{admin_url('message/markasread')}}/{{$e->id}}">Mark as read<a href="{{admin_url('message/markasread')}}/{{$e->id}}"></a></option>-->
                                                     <!--       @endif-->
                                                            <!--<option value="{{admin_url('message')}}/{{$e->id}}/del/1">Delete<a href="{{admin_url('message')}}/{{$e->id}}/del/1"></a></option> -->
                                                     <!--        <option value="{{admin_url('viewmessage')}}/{{$e->id}}">view<a href="{{admin_url('viewmessage')}}/{{$e->id}}/del/1"></a></option> -->
                                                     <!--</select> -->
                                                </td>
                                             </tr>
                                             @endforeach
                                             @else
                                             <tr>
                                                <td colspan="5">
                                                   <center>No Messages Found</center>
                                                </td>
                                             </tr>
                                             @endif
                                          </thead>
                                         
                                          <tfoot>
                                             <tr>
                                             </tr>
                                          </tfoot>
                                     </table>
                            </div>
                            <br>
                      </div>
                   </div>
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