@extends('layouts.admin')
@section('title','Compose')
@section('page_title','Messages')
@section('page_nav')
<ul>
   <li><a href="{{admin_url('messages')}}">Inbox</a> </li>
  <li><a href="{{admin_url('compose')}}">Compose</a> </li>
  <li class="active"><a href="{{admin_url('outbox')}}">Sent Items</a> </li>  
</ul>
@endsection
@section('contents')
<div class="content-container">
   <div class="content-area">
      <div class="row main_content">
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding addenew_form">
            <div class="card no-margin minH">
               <div class="card-block">
                  
                  @if (Session::has('message'))
                                 <div class="alert alert-success">
                                    <font color="red" size="4px">{{ Session::get('message') }}</font>
                                 </div>
                                 @endif
                  <section class="card-text">
                     <div class="px-lg-3 " id="addAccountForm">
                        
                          
                          <div class="card-body">
										<div class="row">
										    <div class="col-6 form-group">
											
											</div>
										
											<div class="col-12 form-group">
											    <h6 class="d-inline-block m-0">To :&nbsp;<strong> {{ !empty($message->sender) ? $message->sender->firstname : ''}}</strong>&nbsp;<
																    {{$message->recipient_email}} ></h6>
                                                  <p class="">Subject : &nbsp; {{$message->subject}}</p>
                                                    <p class="">Received at : &nbsp;{{date('d M Y h:i:a',strtotime($message->created_at))}}</p>
											</div>
											   <hr style="width:100%;text-align:left;margin-left:0;color:gray">
											
										    <br>
											<div class="col form-group">
											    <!--<label>Message</label>-->
												<!--<textarea class="form-control" placeholder="Message" name="message" required rows="10">{{$message->message}}</textarea>-->
												 <div class="email-content" style="min-height: 200px;">
                                                         {!!$message->body_text!!}
                                                 </div>
												
											</div>
											
											
										</div>
										
											            <div class="text-center">
                                                            <a href="{{admin_url('outbox')}}"  class="btn text-center" type="submit">Back</a>
                                                        </div>
										
									</div>
								</div>
                          
                          
                     </div>
                  </section>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection