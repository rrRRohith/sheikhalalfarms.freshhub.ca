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
                        <div class="card-title-header-titr"><b>Compose Message</b></div>
                        <div class="card-title-header-between"></div>
                        <div class="card-title-header-actions">
                           
                           <a href="#"><img src="{{asset('img/help.svg')}}" alt="help"
                              class="card-title-header-img card-title-header-details"></a>
                        </div>
                     </div>
                  </div>
                  @if (Session::has('message'))
                                 <div class="alert alert-success">
                                    <font color="red" size="4px">{{ Session::get('message') }}</font>
                                 </div>
                                 @endif
                  <section class="card-text">
                     <div class="px-lg-3 " id="addAccountForm">
                        <form class="pt-0" id="form" method="post"
                           action="{{url('customer/compose')}}">
                           
                           @csrf
                           <section class="form-block">
                              <div class="separator">
                                 <label class="separator-text separator-text-success">Compose Message</label>
                              </div>
                              <div class="form-group row">
                                 <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12 text-right no-md-padding">
                                    <label class="text-gray-dark"
                                       for="opportunity_source_id"> To</label>
                                 </div>
                                 <div class="col-lg-11 col-md-11 col-sm-12">
                                     <select id="recipient_id" class="form-control" name="recipient_id">
                                         <option value="">Select a recipient</option>
                                         @foreach($recipient as $r)
                                         <option value="{{$r->id}}">{{$r->email}}</option>
                                         @endforeach
                                     </select>
                                    <!--<input class="form-control number" id="to"-->
                                    <!--   value="{{old('to')}}"-->
                                    <!--   name="to">-->
                                    @if ($errors->has('recipient_id'))
                                    <span class="form-error">{{ $errors->first('recipient_id') }}</span>
                                    @endif
                                 </div>
                                 
                              </div>
                              <div class="form-group row">
                                 <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12 text-right no-md-padding">
                                    <label class="text-gray-dark"
                                       for="opportunity_source_id"> Subject</label>
                                 </div>
                                 <div class="col-lg-11 col-md-11 col-sm-12">
                                    <input class="form-control" id="subject"
                                       value="{{old('subject')}}"
                                       name="subject">
                                    @if ($errors->has('subject'))
                                    <span class="form-error">{{ $errors->first('subject') }}</span>
                                    @endif
                                 </div>
                              </div>
                              <div class="form-group row">
                                 <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12 text-right no-md-padding">
                                    <label class="text-gray-dark"
                                       for="account_address">Message</label>
                                 </div>
                                 <div class="col-lg-11 col-md-11 col-sm-12">
                                    <textarea class="form-control" id="message"
                                       name="message" rows=5>{{old('message')}}</textarea>
                                    @if ($errors->has('message'))
                                    <span class="form-error">{{ $errors->first('message') }}</span>
                                    @endif
                                 </div>
                                 
                              </div>
                             
                             
                           </section>
                           <section>
                              <div class="form-group row">
                                 <div class="offset-lg-1 col-lg-3 col-sm-4 col-xs-6">
                                    <button type="submit"
                                       class="btn btn-success btn-block">
                                       <clr-icon
                                          shape="floppy"></clr-icon>
                                       Save                        
                                    </button>
                                 </div>
                              </div>
                           </section>
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