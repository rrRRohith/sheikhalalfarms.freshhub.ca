@extends('layouts.admin')
@section('page_title','Configuration')
@section('page_nav')
<ul>
    <li class="active"><a href="{{url('admin/configuration')}}">Settings</a> </li>
    <li><a href="{{url('admin/roles')}}">Roles & Permissions</a> </li>
    <!--<li><a href="{{url('admin/emails')}}">Emails</a> </li>-->
    <li><a href="{{url('admin/unittype')}}">Unit Type</a> </li>
    <li><a href="{{url('admin/weight')}}">Weight</a></li>
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
                            <h3>Settings</h3>
                        </div>
                               <div class="clearfix"></div>
                     </div>
                     @if (Session::has('message'))
                                        <div class="alert alert-success">
                                            {{ Session::get('message') }}
                                        </div>
                                        @endif
                  <section class="card-text">
                     <div id="addAccountForm">
                        <form class="pt-0" id="form" method="post" action="{{admin_url('configuration')}}">
                          
                           @csrf
                           <section class="form-block">
                          
                              <div class="form-group row">
                                 <div class="col-md-6">
                                    <label class="text-gray-dark"
                                       for="opportunity_source_id">Organization Name</label>
                                       <input class="form-control number" id="organization_name"
                                       value="{{old('organization_name',isset($setting)?$setting->organization_name:'')}}"
                                       name="organization_name" required>
                                    @if ($errors->has('organization_name'))
                                    <span class="form-error">{{ $errors->first('organization_name') }}</span>
                                    @endif
                                 </div>
               
                                 <div class="col-md-6">
                                    <label class="text-gray-dark"
                                       for="opportunity_source_id"> Organization Description</label>
                                    <input class="form-control number" id="organization_description"
                                       value="{{old('organization_description',isset($setting)?$setting->organization_description:'')}}"
                                       name="organization_description" type="text" required>
                                    @if ($errors->has('organization_description'))
                                    <span class="form-error">{{ $errors->first('organization_description') }}</span>
                                    @endif
                                 </div>

                              </div>
                              <div class="form-group row">
                                 <div class="col-md-6">
                                    <label class="text-gray-dark"
                                       for="account_name">Website</label>
                                                <input class="form-control" id="website"
                                       value="{{old('website',isset($setting)?$setting->website:'')}}"
                                       name="website" required>
                                    @if ($errors->has('website'))
                                    <span class="form-error">{{ $errors->first('website') }}</span>
                                    @endif

                                 </div>

                                 <div class="col-md-6">
                                    <label class="text-gray-dark"
                                       for="company_brand">Phone</label>
                                                   <input class="form-control" id="phone"
                                       value="{{old('phone',isset($setting)?$setting->phone:'')}}"
                                       name="phone" required>
                                    @if ($errors->has('phone'))
                                   <span class="form-error">{{ $errors->first('phone') }}</span>
                                    @endif
                                 </div>
 
                              </div>
                              <div class="form-group row">
                                 <div class="col-md-6">
                                    <label class="text-gray-dark"
                                       for="account_address">Sale Email</label>
                                    <input class="form-control" id="sale_email" type="email"
                                       value="{{old('sale_email',isset($setting)?$setting->sale_email:'')}}"
                                       name="sale_email" required>
                                    @if ($errors->has('sale_email'))
                                    <span class="form-error">{{ $errors->first('sale_email') }}</span>
                                    @endif
                                 </div>

                                 <div class="col-md-6">
                                    <label class="text-gray-dark"
                                       for="account_city">Support Email</label>
                                                                          <input type="email" class="form-control" name="support_email"
                                       value="{{old('support_email',isset($setting)?$setting->support_email:'')}}"
                                       id="support_email" required>
                                 </div>
                              </div> 
                              <div class="form-group row">
                                 <div class="col-md-6">
                                    <label class="text-gray-dark"
                                       for="account_economic_identifier">SMS API ID</label>
                                     <input class="form-control" id="sms_api_id"
                                       value="{{old('sms_api_id',isset($setting)?$setting->sms_api_id:'')}}"
                                       name="sms_api_id">
                                 </div>
                                 <div class="col-md-6">
                                    <label class="text-gray-dark"
                                       for="account_email">Tax</label>
                                     <input class="form-control" name="tax"
                                       value="{{old('tax',isset($setting)?$setting->tax:'')}}"
                                       id="tax" required>
                                    @if ($errors->has('tax'))
                                    <span class="form-error">{{ $errors->first('tax') }}</span>
                                    @endif
                                 </div>
                              </div>
                           </section>
                           <section>
                              <div class="form-group row">
                                 <div class="col-lg-3 col-sm-4 col-xs-6">
                                    <input type="submit"
                                       class="btn btn-success btn-block green_button" value="save">
                                                             
                                    
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
@section('bottom-scripts')
<script>
$("#phone").inputmask({"mask": "(999) 999-9999"});
</script>
@endsection