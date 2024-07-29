@extends('layouts.admin')
@section('title',isset($user) ? 'Edit Customer' :'Add Customer')
@section('page_title','Customers')
@section('page_nav')
<ul>
  <li @if($submenu=='All') class="active" @else class="" @endif><a  href="{{url('admin/customers')}}">All Customers</a></li>
  <li @if($submenu=='Active') class="active" @else class="" @endif><a  href="{{url('admin/customers/getcust/1')}}">Active Customers</a></li>
  <li @if($submenu=='Inactive') class="active" @else class="" @endif><a  href="{{url('admin/customers/getcust/0')}}">Inactive Customers</a></li>
  <li @if($submenu=='customertype') class="active" @else class="" @endif ><a href="{{url('admin/customertype')}}">Customer Types</a> </li>
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
                     <!--  <div class="form-group row">
                        <div class="toggle-switch toggle-switch-two-way">
                            <input value='0' name="contact_status" type="checkbox"
                                  checked   id="switchCustomerFormMode">
                            <label for="switchCustomerFormMode">Contact</label>
                            <label for="switchCustomerFormMode">Account</label>
                        </div>
                        </div> -->
                     <div class="px-lg-3 " id="addAccountForm">
                        <form class="pt-0" id="form" method="post"
                           action="@if(isset($user)){{admin_url('customers/'.$user->id)}}@else{{admin_url('customers')}}@endif">
                           @if(isset($user))
                           @method('PUT')
                           @endif
                           @csrf
                           <section class="form-block">
                              <div class="separator">
                                 <label class="separator-text separator-text-success">Customer Details</label>
                              </div>
                            <div class="row">
                              <div class="col-sm-9">  
                                  <div class="form-group row">
                                     <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12 text-right no-md-padding">
                                        <label class="text-gray-dark"
                                           for="opportunity_source_id"> User Name</label>
                                     </div>
                                     <div class="col-lg-5 col-md-5 col-sm-12">
                                        <input class="form-control number" id="username"
                                           value="{{old('username',isset($user)?$user->username:'')}}"
                                           name="username">
                                        @if ($errors->has('username'))
                                        <span class="form-error">{{$errors->first('username')}}</span>
                                        @endif
                                     </div>
                                     <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12 text-right no-md-padding">
                                        <label class="text-gray-dark"
                                           for="opportunity_source_id"> Password</label>
                                     </div>
                                     <div class="col-lg-5 col-md-5 col-sm-12">
                                        <input class="form-control number" id="password" name="password" type="password"><i class="fa fa-eye" aria-hidden="true"></i>
                                        @if ($errors->has('password'))
                                        <span class="form-error">{{ $errors->first('password') }}</span>
                                        @endif
                                     </div>
                                  </div>
                             <div class="form-group row">
                                 <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12 text-right no-md-padding">
                                    <label class="text-gray-dark"
                                       for="opportunity_source_id"> Business Name</label>
                                 </div>
                                 <div class="col-lg-5 col-md-5 col-sm-12">
                                    <input class="form-control number" id="business_name"
                                       value="{{old('business_name',isset($user)?$user->business_name:'')}}"
                                       name="business_name">
                                    @if ($errors->has('business_name'))
                                    <span class="form-error">{{$errors->first('business_name')}}</span>
                                    @endif
                                 </div>
                                 
                                 <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12 text-right no-md-padding">
                                    <label class="text-gray-dark"
                                       for="opportunity_source_id"> Customer Type</label>
                                 </div>
                                 <div class="col-lg-5 col-md-5 col-sm-12">
                                     <select name="customer_type" id="customer_type" class="form-control" required>
                                            <option value="">Select Customer Type</option>
                                            @foreach($customertypes as $customertype)
                                            <option value="{{$customertype->id}}" <?php if(isset($user)){if(($user->customer_type)==($customertype->id)){?> selected <?php }}?>>{{$customertype->name}}</option>
                                            @endforeach
                                     </select>
                                 </div>     
                              </div>
                              
                              <div class="form-group row">
                                 <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12 text-right no-md-padding">
                                    <label class="text-gray-dark"
                                       for="account_name">First Name*</label>
                                 </div>
                                 <div class="col-lg-5 col-md-3 col-sm-12">
                                    <input class="form-control" id="firstname"
                                       value="{{old('firstname',isset($user)?$user->firstname:'')}}"
                                       name="firstname">
                                    @if ($errors->has('firstname'))
                                    <span class="form-error">{{ $errors->first('firstname') }}</span>
                                    @endif
                                 </div>
                                 <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12 text-right no-md-padding">
                                    <label class="text-gray-dark"
                                       for="company_brand">Last Name</label>
                                 </div>
                                 <div class="col-lg-5 col-md-3 col-sm-12">
                                    <input class="form-control" id="lastname"
                                       value="{{old('lastname',isset($user)?$user->lastname:'')}}"
                                       name="lastname">
                                    @if ($errors->has('lastname'))
                                    <span class="form-error">{{ $errors->first('lastname') }}</span>
                                    @endif
                                 </div>
                              </div>
                              <div class="form-group row">
                                 <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12 text-right no-md-padding">
                                    <label class="text-gray-dark"
                                       for="account_address">Address</label>
                                 </div>
                                 <div class="col-lg-5 col-md-7 col-sm-12">
                                    <input class="form-control" id="address"
                                       value="{{old('address',isset($user)?$user->address:'')}}"
                                       name="address">
                                    @if ($errors->has('address'))
                                    <span class="form-error">{{ $errors->first('address') }}</span>
                                    @endif
                                 </div>
                                 <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12 text-right no-md-padding">
                                    <label class="text-gray-dark"
                                       for="account_city">City</label>
                                 </div>
                                 <div class="col-lg-5 col-md-3 col-sm-12">
                                    <input class="form-control" name="city"
                                       value="{{old('city',isset($user)?$user->city:'')}}"
                                       id="city">
                                 </div>
                              </div>
                              <div class="form-group row">
                                 <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12 text-right no-md-padding">
                                    <label class="text-gray-dark"
                                       for="account_province">Province</label>
                                 </div>
                                 <div class="col-lg-5 col-md-5 col-sm-12">
                                    <select name="province" id="province" class="form-control">
                                       @foreach($province as $p)
                                       <option value="{{$p->shortcode}}" <?php if(isset($user)){if(($user->province)==($p->shortcode)){?> selected <?php }}?> >{{$p->name}}</option>
                                       @endforeach
                                    </select>
                                    @if ($errors->has('province'))
                                    <span class="form-error">{{ $errors->first('province') }}</span>
                                    @endif 
                                 </div>
                                 <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12 text-right no-md-padding">
                                    <label class="text-gray-dark"
                                       for="account_economic_identifier">Postal Code</label>
                                 </div>
                                 <div class="col-lg-5 col-md-5 col-sm-12">
                                    <input class="form-control number" id="postalcode"
                                       value="{{old('postalcode',isset($user)?$user->postalcode:'')}}"
                                       name="postalcode">
                                 </div>
                              </div>
                              <div class="form-group row">
                                 <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12 text-right no-md-padding">
                                    <label class="text-gray-dark"
                                       for="account_phone">Phone</label>
                                    
                                 </div>
                                 <div class="col-lg-5 col-md-5 col-sm-12">
                                    <phone-input-mask id="phone" name="phone"
                                       value="{{old('phone',isset($user)?$user->phone:'')}}">
                                    </phone-input-mask>
                                    @if ($errors->has('phone'))
                                    <span class="form-error">{{ $errors->first('phone') }}</span>
                                    @endif
                                 </div>
                                 <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12 text-right no-md-padding">
                                    <label class="text-gray-dark"
                                       for="account_email">Email</label>
                                 </div>
                                 <div class="col-lg-5 col-md-5 col-sm-12">
                                    <input class="form-control" name="email"
                                       value="{{old('email',isset($user)?$user->email:'')}}"
                                       id="email">
                                    @if ($errors->has('email'))
                                    <span class="form-error">{{ $errors->first('email') }}</span>
                                    @endif
                                 </div>
                                 <!--<div class="col-lg-1 col-md-1 col-sm-12 col-xs-12 text-right no-md-padding">-->
                                 <!--   <label class="text-gray-dark"-->
                                 <!--      for="opportunity_source_id"> Profile Picture</label>-->
                                 <!--</div>-->
                                 <!--<div class="col-lg-3 col-md-3 col-sm-12">-->
                                 <!--   <input type="file" class="form-control" id="profile_picture" name="profile_picture">-->
                                 <!--   <input type="hidden" name="id" value="{{old('id',isset($user)?$user->id:'')}}" />-->
                                 <!--</div>-->
                                 
                              </div>
                              <div class="form-group row">
                                 <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12 text-right no-md-padding">
                                    <label class="text-gray-dark"
                                       for="opportunity_source_id"> Payment Terms</label>
                                 </div>
                                 <div class="col-lg-5 col-md-5 col-sm-12">
                                    <select name="payment_term" id="payment_term" class="form-control" required>
                                        <option value="">Select Payment Term</option>
                                        @foreach($paymentterms as $paymentterm)
                                        <option value="{{$paymentterm->id}}" <?php if(isset($user)){if(($user->payment_term)==($paymentterm->id)){?> selected <?php }}?>>{{$paymentterm->name}}</option>
                                        @endforeach
                                    </select>
                                   
                                 </div>
                                 <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12 text-right no-md-padding">
                                    <label class="text-gray-dark"
                                       for="opportunity_source_id"> Payment Method</label>
                                 </div>
                                <div class="col-lg-5 col-md-5 col-sm-12">
                                    <select name="payment_method" id="payment_method" class="form-control" required>
                                        <option value="">Select Payment Method</option>
                                        @foreach($paymentmethods as $paymentmethod)
                                        <option value="{{$paymentmethod->id}}" <?php if(isset($user)){if(($user->payment_method)==($paymentmethod->id)){?> selected <?php }}?>>{{$paymentmethod->name}}</option>
                                        @endforeach
                                    </select>
                                    
                                 </div>
                                 <!--<div class="col-lg-1 col-md-1 col-sm-12 col-xs-12 text-right no-md-padding">-->
                                 <!--   <label class="text-gray-dark"-->
                                 <!--      for="opportunity_source_id"> Customer Type</label>-->
                                 <!--</div>-->
                                 <!--<div class="col-lg-3 col-md-3 col-sm-12">-->
                                 <!--   <select name="customer_type" id="customer_type" class="form-control" required>-->
                                 <!--       <option value="">Select Customer Type</option>-->
                                 <!--       @foreach($customertypes as $customertype)-->
                                 <!--       <option value="{{$customertype->id}}" <!--?php if(isset($user)){if(($user->customer_type)==($customertype->id)){?> selected <!--?php }}?>>{{$customertype->name}}</option>-->
                                 <!--       @endforeach-->
                                 <!--   </select>-->
                                    
                                 <!--</div>-->
                                 
                              </div>
                              <div class="form-group row"> 
                                   <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12 text-right no-md-padding">
                                       <label class="text-gray-dark"
                                       for="opportunity_source_id">Description</label>
                                    </div>
                                 
                                    <div class="col-lg-5 col-md-5 col-sm-12">
                                             <textarea rows="5" name="description" id="description" class="form-control">{{old('description',isset($user)?$user->description:'')}}</textarea>
                                            
                                            @if ($errors->has('description'))
                                            <span class="form-error">{{ $errors->first('description') }}</span>
                                            @endif
                                         </div>
                                    </div>
                                    
                                    </div>
                                       <div class="col-sm-3">
                                    
                                    <div class="row" style="margin-left:6px;">
                                      @if(isset($user))
                                        <div class="col-sm-12">
                                          
                                         <center><img src="{!!$user->profile_picture !=''  ? asset('/media/customers/'.$user->profile_picture):asset('/media/customers/dummyuser.jpg')!!}"
                                                  style="width:75%;height:auto;"></center>
                                        </div>
                                     @endif
                                        <br>
                                        <input type="file" class="form-control" id="profile_picture" name="profile_picture">
                                    </div>
                                    
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