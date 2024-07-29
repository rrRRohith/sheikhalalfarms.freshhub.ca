@extends('layouts.admin')
@section('contents')
<div class="content-container">
   <div class="content-area">
      <div class="row">
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-xs-padding">
            <div class="card no-margin minH">
               <div class="card-block">
                  <div class="card-title">
                     <div class="card-title-header">
                        <div class="card-title-header-titr"><b> Customers Details </b></div>
                        <div class="card-title-header-between"></div>
                        <div class="card-title-header-actions">
                           <a href="{{admin_url('customers')}}/{{$user->id}}/edit"
                              class="btn btn-success-outline-x btn-icon card-title-header-details" rel="tooltip"
                              data-tooltip="Edit">
                              <clr-icon shape="pencil" class="is-solid"></clr-icon>
                           </a>
                           <a href="{{admin_url('customers')}}"
                              class="btn btn-success-outline-x btn-icon card-title-header-details" rel="tooltip"
                              data-tooltip="Back">
                              <clr-icon shape="undo" class="is-solid"></clr-icon>
                           </a>
                           <a href="#"><img src="http://test.freshhub.ca/img/help.svg" alt="help"
                              class="card-title-header-img card-title-header-details"></a>
                        </div>
                     </div>
                  </div>
                  <section class="card-text">
                     <div class="px-lg-3">
                        <div class="form-group row">
                           <div class="col-lg-1 col-md-1 col-sm-3 col-xs-12 text-right no-sm-padding">
                              <label class="text-gray-dark">Name</label>
                           </div>
                           <div class="col-lg-3 col-md-3 col-sm-9">
                              <label class="text-success">{{$user->firstname}} {{$user->lastname}}</label>
                           </div>
                           <div class="col-lg-1 col-md-1 col-sm-3 col-xs-12 text-right no-sm-padding">
                              <label class="text-gray-dark">Email</label>
                           </div>
                           <div class="col-lg-3 col-md-3 col-sm-9">
                              <label class="text-success">{{$user->email}}</label>
                           </div>
                           <div class="col-lg-1 col-md-1 col-sm-3 col-xs-12 text-right no-sm-padding">
                              <label class="text-gray-dark">Phone</label>
                              <popover class-name="popover-md">
                                 In all of the appliaction you can click to call phone number feature                        
                              </popover>
                           </div>
                           <div class="col-lg-3 col-md-3 col-sm-9">
                              <phone class-name="text-success" phone-range="{{$user->phone}}" type-num="phone"></phone>
                           </div>
                        </div>
                        <div class="form-group row">
                           <div class="col-lg-1 col-md-1 col-sm-3 col-xs-12 text-right no-sm-padding">
                              <label class="text-gray-dark">Address</label>
                           </div>
                           <div class="col-lg-3 col-md-3 col-sm-9">
                              <label class="text-success number">{{$user->address}}</label>
                           </div>
                           <div class="col-lg-1 col-md-1 col-sm-3 col-xs-12 text-right no-sm-padding">
                              <label class="text-gray-dark">City</label>
                           </div>
                           <div class="col-lg-3 col-md-3 col-sm-9">
                              <label class="text-success number">{{$user->city}}</label>
                           </div>
                           <div class="col-lg-1 col-md-1 col-sm-3 col-xs-12 text-right no-sm-padding">
                              <label class="text-gray-dark">Postal Code</label>
                           </div>
                           <div class="col-lg-3 col-md-3 col-sm-9">
                              <label class="text-success number">{{$user->postalcode}}</label>
                           </div>
                        </div>
                        <div class="form-group row">
                           <div class="col-lg-1 col-md-1 col-sm-3 col-xs-12 text-right no-sm-padding">
                              <label class="text-gray-dark">Province</label>
                           </div>
                           <div class="col-lg-3 col-md-3 col-sm-9">
                              <label class="text-success">{{$user->province}}</label>
                           </div>
                           <div class="col-lg-1 col-md-1 col-sm-3 col-xs-12 text-right no-sm-padding">
                              <label class="text-gray-dark">Country</label>
                           </div>
                           <div class="col-lg-3 col-md-3 col-sm-9">
                              <label class="text-success">{{$user->country}}</label>
                           </div>
                           <div class="col-lg-1 col-md-1 col-sm-3 col-xs-12 text-right no-sm-padding">
                              <label class="text-gray-dark">Status</label>
                           </div>
                           <div class="col-lg-3 col-md-3 col-sm-9">
                              <label class="text-success">@if($user->status==0) Inactive @else Active @endif</label>
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