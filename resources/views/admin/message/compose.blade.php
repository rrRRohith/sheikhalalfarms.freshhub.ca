@extends('layouts.admin')
@section('title','Compose')
@section('page_title','Messages')
@section('page_nav')
<ul>
   <li><a href="{{admin_url('messages')}}">Inbox</a> </li>
  <li class="active"><a href="{{admin_url('compose')}}">Compose</a> </li>
  <li><a href="{{admin_url('outbox')}}">Sent Items</a> </li>  
</ul>
@endsection
@section('contents')
<div class="content-container">
   <div class="content-area">
      <div class="row main_content">
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 addenew_form">
            <div class="card no-margin minH">
               <div class="card-block">
                      <div class="headercnt_top">
                                    <div class="innerpage_title">
                                        <h3>Compose a Message</h3>
                                    </div>
                               
                                                <div class="clearfix"></div>
                                 </div>
                  <section class="card-text">
                     <div id="addAccountForm" class="col-md-6">
                        <form class="pt-0" id="form" method="post"
                           action="{{admin_url('compose')}}">
                           
                           @csrf
                         
                           
                           
                              <div class="form-group row">
                                 <div class="col-lmd-12">
                                    <label class="text-gray-dark"
                                       for="opportunity_source_id"> To</label>
                               
                                     <select id="recipient_id" class="form-control" name="recipient_id">
                                         <option value="">Select a recipient</option>
                                         @foreach($recipient as $r)
                                         <option value="{{$r->id}}">{{$r->email}}</option>
                                         @endforeach
                                     </select>
                                    @if ($errors->has('to'))
                                    <span class="form-error">{{ $errors->first('to') }}</span>
                                    @endif
                                 </div>
                             
                                 <div class="col-md-12">
                                    <label class="text-gray-dark"
                                       for="opportunity_source_id"> Subject</label>
                               
                                    <input class="form-control" id="subject"
                                       value="{{old('subject')}}"
                                       name="subject">
                                    @if ($errors->has('subject'))
                                    <span class="form-error">{{ $errors->first('subject') }}</span>
                                    @endif
                                 </div>
                            
                                 <div class="col-md-12">
                                    <label class="text-gray-dark"
                                       for="account_address">Message</label>
                                
                                    <textarea class="form-control" id="message"
                                       name="message" rows=5>{{old('message')}}</textarea>
                                    @if ($errors->has('message'))
                                    <span class="form-error">{{ $errors->first('message') }}</span>
                                    @endif
                                 </div>
                                 
                          
                                 <div class=" col-sm-4">
                                    <button type="submit"
                                       class="btn btn-success btn-block green_button">
                                       <clr-icon
                                          shape="floppy"></clr-icon>
                                       Save                        
                                    </button>
                                 </div>
                              </div>
                          
                        </form>
                     </div>
                  </section>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection