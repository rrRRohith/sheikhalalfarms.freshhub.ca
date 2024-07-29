@extends('layouts.admin')
@section('title','Profile')
@section('page_title','Dashboard')
@section('page_nav')
<ul>
    <li><a href="{{admin_url('')}}">Dashboard</a></li>
    <li class="active"><a href="{{admin_url('profile')}}">Profile</a></li>  
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
                     @if (Session::has('message'))
                     <div class="alert alert-success">
                        <div class="alert-items">
                           <div class="alert-item static">
                              <div class="alert-icon-wrapper">
                                 <clr-icon class="alert-icon"
                                    shape="check-circle"></clr-icon>
                              </div>
                              <span class="alert-text">
                              {{ Session::get('message') }}                       <br>
                              </span>
                           </div>
                        </div>
                        <button type="button" class="close" aria-label="Close">
                           <clr-icon aria-hidden="true" shape="close"></clr-icon>
                        </button>
                     </div>
                     @endif
                     <section class="card-text">
                        <div class="nav-vertically mb-1">
                           <ul class="nav nav-md nav-vertically-side" role="tablist">
                              <li role="presentation" class="nav-item nav-vertically-side-user-avatar">
                                 <my-dropzone id="drop-upload"
                                    class-name="no-padding dropzone-single"
                                    value=""
                                    max-file-size="10"
                                    accepted-files='[{"mime_type":"image/jpeg"},{"mime_type":"image/png"},{"mime_type":"image/gif"}]'
                                    max-files="1"
                                    :params="{ type : 'avatar'}"
                                    file-base-url="http://admin.freshhub.ca/avatars"
                                    upload-url="http://admin.freshhub.ca/profile/uploadavatar"
                                    delete-url="http://admin.freshhub.ca/profile/avatarupload/delete">
                                    <clr-icon shape="user" class="is-solid" size="90"></clr-icon>
                                    <br>
                                    <span class="">Upload Avatar </span>
                                 </my-dropzone>
                              </li>
                              <li role="presentation" class="nav-item">
                                 <button id="tab1"
                                    class="btn btn-link nav-link nav-link-success active"
                                    aria-controls="panel1"
                                    aria-selected="true" type="button">Personal Info                    </button>
                              </li>
                              <li role="presentation" class="nav-item">
                                 <button id="tab2"
                                    class="btn btn-link nav-link nav-link-success   "
                                    aria-controls="panel2"
                                    aria-selected="false" type="button">Change Password                    </button>
                              </li>
                           </ul>
                           <section id="panel1" role="tabpanel"
                              aria-labelledby="tab1" >
                              <div class="content-area">
                                 <form method="POST" action="{{admin_url('profile')}}" class="pt-0">
                                    @csrf
                                    <div class="form-group row">
                                       <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 text-right no-md-padding">
                                          <label class="text-gray-dark">First Name*</label>
                                       </div>
                                       <div class="col-lg-4 col-md-4 col-sm-12">
                                          <input id="firstname" name="firstname" value="{{$profile->firstname}}"
                                             class="form-control">
                                          @if ($errors->has('firstname'))
                                          <strong>{{ $errors->first('firstname') }}</strong>
                                          @endif
                                       </div>
                                       <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 text-right no-md-padding">
                                          <label class="text-gray-dark">Last Name*</label>
                                       </div>
                                       <div class="col-lg-4 col-md-4 col-sm-12">
                                          <input id="lastname" name="lastname" value="{{$profile->lastname}}"
                                             class="form-control">
                                          @if ($errors->has('lastname'))
                                          <strong>{{ $errors->first('lastname') }}</strong>
                                          @endif
                                       </div>
                                    </div>
                                    <div class="form-group row">
                                       <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 text-right no-md-padding">
                                          <label class="text-gray-dark">Mobile</label>
                                       </div>
                                       <div class="col-lg-4 col-md-4 col-sm-12">
                                          <phone-input-mask name="phone" id="phone" value="{{$profile->phone}}"></phone-input-mask>
                                          @if ($errors->has('phone'))
                                          <strong>{{ $errors->first('phone') }}</strong>
                                          @endif
                                       </div>
                                       <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 text-right no-md-padding">
                                          <label class="text-gray-dark">Email</label>
                                       </div>
                                       <div class="col-lg-4 col-md-4 col-sm-12">
                                          <input id="email" name="email" value="{{$profile->email}}"
                                             class="form-control number" readonly>
                                          @if ($errors->has('email'))
                                          <strong>{{ $errors->first('email') }}</strong>
                                          @endif
                                       </div>
                                    </div>
                                    <div class="form-group row">
                                       <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 text-right no-md-padding">
                                          <label class="text-gray-dark">Address</label>
                                       </div>
                                       <div class="col-lg-4 col-md-4 col-sm-12">
                                          <input id="address" name="address"
                                             value="{{$profile->address}}" class="form-control">
                                          @if ($errors->has('address'))
                                          <strong>{{ $errors->first('address') }}</strong>
                                          @endif
                                       </div>
                                       <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 text-right no-md-padding">
                                          <label class="text-gray-dark">City</label>
                                       </div>
                                       <div class="col-lg-4 col-md-4 col-sm-12">
                                          <input id="city" name="city"
                                             value="{{$profile->city}}"
                                             class="form-control">
                                          @if ($errors->has('city'))
                                          <strong>{{ $errors->first('city') }}</strong>
                                          @endif
                                       </div>
                                    </div>
                                    <div class="form-group row">
                                       <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 text-right no-md-padding">
                                          <label class="text-gray-dark">Province</label>
                                       </div>
                                       <div class="col-lg-4 col-md-4 col-sm-12">
                                           <select class="form-control" name="province" id="province">
                                               @foreach($provinces as $province)
                                               <option value="{{$province->shortcode}}" @if($profile->province==$province->shortcode) selected @endif>{{$province->name}}</option>
                                               @endforeach
                                           </select>
                                          <!--<input id="province" name="province"-->
                                          <!--   value="{{$profile->province}}" class="form-control number">-->
                                          @if ($errors->has('province'))
                                          <strong>{{ $errors->first('province') }}</strong>
                                          @endif
                                       </div>
                                       <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 text-right no-md-padding">
                                          <label class="text-gray-dark">Pincode</label>
                                       </div>
                                       <div class="col-lg-4 col-md-4 col-sm-12">
                                          <input id="postalcode" name="postalcode"
                                             value="{{$profile->postalcode}}" class="form-control">
                                          @if ($errors->has('postalcode'))
                                          <strong>{{ $errors->first('postalcode') }}</strong>
                                          @endif
                                       </div>
                                    </div>
                                    <div class="form-group row">
                                       <div class="col-lg-3 offset-lg-2 offset-md-2 col-md-5 col-sm-8">
                                          <button class="btn btn-success btn-block">
                                             <clr-icon shape="floppy"></clr-icon>
                                             Save                                
                                          </button>
                                       </div>
                                    </div>
                                 </form>
                              </div>
                           </section>
                           <section id="panel2" role="tabpanel"
                              aria-labelledby="tab2" aria-hidden=true >
                              <div class="content-area">
                                 <form method="POST" action="{{admin_url('changepassword')}}" class="pt-0">
                                    @csrf
                                    <div class="row form-group">
                                       <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 text-right no-md-padding">
                                          <label class="text-gray-dark">Old Password*</label>
                                       </div>
                                       <div class="col-lg-4 col-md-4 col-sm-12">
                                          <input type="password" name="oldpassword" class="form-control u-security-pass">
                                          @if ($errors->has('oldpassword'))
                                          <strong>{{ $errors->first('oldpassword') }}</strong>
                                          @endif
                                       </div>
                                    </div>
                                    <div class="row form-group">
                                       <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 text-right no-md-padding">
                                          <label class="text-gray-dark">New Password*</label>
                                       </div>
                                       <div class="col-lg-4 col-md-4 col-sm-12">
                                          <input type="password" name="password" class="form-control u-security-pass">
                                          @if ($errors->has('password'))
                                          <strong>{{ $errors->first('password') }}</strong>
                                          @endif
                                       </div>
                                    </div>
                                    <div class="row form-group">
                                       <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 text-right no-md-padding">
                                          <label class="text-gray-dark">Confirm Password                                    *</label>
                                       </div>
                                       <div class="col-lg-4 col-md-4 col-sm-12">
                                          <input type="password" name="password_confirmation"
                                             class="form-control u-security-pass">
                                       </div>
                                    </div>
                                    <div class="form-group row">
                                       <div class="offset-lg-2 col-lg-3 offset-md-3 col-md-5 col-sm-8">
                                          <!-- changed -->
                                          <button class="btn btn-success btn-block">
                                             <clr-icon shape="floppy"></clr-icon>
                                             Save                                
                                          </button>
                                       </div>
                                    </div>
                                 </form>
                              </div>
                           </section>
                        </div>
                     </section>
                  </section>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection