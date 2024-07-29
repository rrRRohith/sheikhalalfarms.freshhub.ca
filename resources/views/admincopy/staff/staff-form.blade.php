@extends('layouts.admin')
@section('title',isset($user) ? 'Edit Staff' :'Add Staff')
@section('page_title','Staffs')
@section('page_nav')
<ul>
    <li class="active"><a href="{{admin_url('staffs')}}">Staffs</a></li>
    
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
                           action="@if(isset($user)){{url('admin/staffs/'.$user->id)}}@else{{url('admin/staffs')}}@endif">
                           @if(isset($user))
                           @method('PUT')
                           @endif
                           @csrf
                           <section class="form-block">
                              <div class="separator">
                                 <label class="separator-text separator-text-success"> Details</label>
                              </div>
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
                                    <span class="form-error">{{ $errors->first('username') }}</span>
                                    @endif
                                 </div>
                                 <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12 text-right no-md-padding">
                                    <label class="text-gray-dark"
                                       for="opportunity_source_id"> Password</label>
                                 </div>
                                 <div class="col-lg-5 col-md-5 col-sm-12">
                                    <input class="form-control number" id="password"
                                       value=""
                                       name="password" type="password">
                                    @if ($errors->has('password'))
                                    <span class="form-error">{{ $errors->first('password') }}</span>
                                    @endif
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
                                       @foreach($provinces as $p)
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
                                 <div class="col-lg-3 col-md-3 col-sm-12">
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
                                 <div class="col-lg-3 col-md-3 col-sm-12">
                                    <input class="form-control" name="email"
                                       value="{{old('email',isset($user)?$user->email:'')}}"
                                       id="email">
                                    @if ($errors->has('email'))
                                    <span class="form-error">{{ $errors->first('email') }}</span>
                                    @endif
                                 </div>
                                 <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12 text-right no-md-padding">
                                    <label class="text-gray-dark"
                                       for="opportunity_source_id"> Profile Picture</label>
                                 </div>
                                 <div class="col-lg-3 col-md-3 col-sm-12">
                                    <input type="file" class="form-control" id="profile_picture" name="profile_picture">
                                 </div>
                              </div>
                              <div class="form-group row">
                                 <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12 text-right no-md-padding">
                                    <label class="text-gray-dark"
                                       for="opportunity_source_id"> Staff Role</label>
                                 </div>
                                 <div class="col-lg-3 col-md-3 col-sm-12">
                                    <select class="form-control" name="role"  id="role">
                                       @foreach($roles as $role)
                                          <option value="{{$role->id}}" @if(isset($user) && $user->hasRole($role->name)) selected="selected" @endif>{{$role->name}}</option>
                                       @endforeach
                                    </select>
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