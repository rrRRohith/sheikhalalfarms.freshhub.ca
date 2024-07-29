@extends('layouts.admin')
@section('page_title','Configuration')
@section('page_nav')
<ul>
    <li class="active"><a href="{{url('admin/settings')}}">Settings</a> </li>
    <li><a href="{{url('admin/roles')}}">Roles & Permissions</a> </li>
    <li><a href="{{url('admin/emails')}}">Emails</a> </li>
</ul>
@endsection
@section('contents')
<div class="content-container">
   <div class="content-area">
      <div class="row">
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-xs-padding">
            <div class="card no-margin minH">
               <div class="card-block">
                 
                  <section class="card-text">
                     <div class="px-lg-3 " id="addAccountForm">
                        <form class="pt-0" id="form" method="post"
                           action="">
                          
                           @csrf
                           <section class="form-block">
                              <div class="separator">
                                 <label class="separator-text separator-text-success">Details</label>
                              </div>
                              <div class="form-group row">
                                 <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12 text-right no-md-padding">
                                    <label class="text-gray-dark"
                                       for="opportunity_source_id">Organization Name</label>
                                 </div>
                                 <div class="col-lg-5 col-md-5 col-sm-12">
                                    <input class="form-control number" id="organization-name"
                                       value="{{old('username',isset($user)?$user->username:'')}}"
                                       name="organization-name">
                                    @if ($errors->has('organization-name'))
                                    <span class="form-error">{{ $errors->first('organization-name') }}</span>
                                    @endif
                                 </div>
                                 <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12 text-right no-md-padding">
                                    <label class="text-gray-dark"
                                       for="opportunity_source_id"> Organization Description</label>
                                 </div>
                                 <div class="col-lg-5 col-md-5 col-sm-12">
                                    <input class="form-control number" id="organaization-description"
                                       value="{{old('organaization-description')}}"
                                       name="organaization-description" type="text">
                                    @if ($errors->has('organaization-description'))
                                    <span class="form-error">{{ $errors->first('organaization-description') }}</span>
                                    @endif
                                 </div>
                              </div>
                              <div class="form-group row">
                                 <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12 text-right no-md-padding">
                                    <label class="text-gray-dark"
                                       for="account_name">Website</label>
                                 </div>
                                 <div class="col-lg-5 col-md-3 col-sm-12">
                                    <input class="form-control" id="website"
                                       value="{{old('website')}}"
                                       name="website">
                                    @if ($errors->has('website'))
                                    <span class="form-error">{{ $errors->first('website') }}</span>
                                    @endif
                                 </div>
                                 <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12 text-right no-md-padding">
                                    <label class="text-gray-dark"
                                       for="company_brand">Phone</label>
                                 </div>
                                 <div class="col-lg-5 col-md-3 col-sm-12">
                                    <input class="form-control" id="phone"
                                       value="{{old('phone')}}"
                                       name="phone">
                                    @if ($errors->has('phone'))
                                   <span class="form-error">{{ $errors->first('phone') }}</span>
                                    @endif
                                 </div>
                              </div>
                              <div class="form-group row">
                                 <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12 text-right no-md-padding">
                                    <label class="text-gray-dark"
                                       for="account_address">Sale Email</label>
                                 </div>
                                 <div class="col-lg-5 col-md-7 col-sm-12">
                                    <input class="form-control" id="sale-email"
                                       value="{{old('sale-email')}}"
                                       name="sale-email">
                                    @if ($errors->has('sale-email'))
                                    <span class="form-error">{{ $errors->first('sale-email') }}</span>
                                    @endif
                                 </div>
                                 <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12 text-right no-md-padding">
                                    <label class="text-gray-dark"
                                       for="account_city">Support Email</label>
                                 </div>
                                 <div class="col-lg-5 col-md-3 col-sm-12">
                                    <input class="form-control" name="support-email"
                                       value="{{old('support-email')}}"
                                       id="support-email">
                                 </div>
                              </div>
                              <div class="form-group row">
                                 <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12 text-right no-md-padding">
                                    <label class="text-gray-dark"
                                       for="account_economic_identifier">SMS API ID</label>
                                 </div>
                                 <div class="col-lg-5 col-md-5 col-sm-12">
                                    <input class="form-control" id="sms-api-id"
                                       value="{{old('sms-api-id')}}"
                                       name="sms-api-id">
                                 </div>
                              </div>
                              <div class="form-group row">
                                 <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12 text-right no-md-padding">
                                    <label class="text-gray-dark"
                                       for="account_phone">Currency</label>
                                    <!--<popover class-name="popover-lg">-->
                                    <!--   Enter all phone number that staff places in your regin or province without any zero code,<br> But enter phone number that staffs places outside of your regin or province with zero code.<br> Enter phone numbers without dash (-) sign and just use this to set range of phone numbers like ex:33225566-9 or ex:33225568-72 or ex:02833225568-72                        -->
                                    <!--</popover>-->
                                 </div>
                                 <div class="col-lg-3 col-md-3 col-sm-12">
                                    <input class="form-control" id="currency"
                                       value="{{old('currency')}}"
                                       name="currency">
                                    @if ($errors->has('currency'))
                                    <span class="form-error">{{ $errors->first('currency') }}</span>
                                    @endif
                                 </div>
                                 <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12 text-right no-md-padding">
                                    <label class="text-gray-dark"
                                       for="account_email">Tax</label>
                                 </div>
                                 <div class="col-lg-3 col-md-3 col-sm-12">
                                    <input class="form-control" name="taz"
                                       value="{{old('tax')}}"
                                       id="tax">
                                    @if ($errors->has('tax'))
                                    <span class="form-error">{{ $errors->first('tax') }}</span>
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