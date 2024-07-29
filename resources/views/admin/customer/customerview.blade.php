@extends('layouts.admin')
@section('page_title','Customer Details')
@section('page_nav')

<ul>
  <li @if($submenu=="All") class="active" @else class=""  @endif><a  href="{{url('admin/customers')}}">All Customers</a></li>
  <li @if($submenu=="Active") class="active" @else class="" @endif><a  href="{{url('admin/customers/getcust/1')}}">Active Customers</a></li>
  <li @if($submenu=="Inactive") class="active" @else class="" @endif ><a   href="{{url('admin/customers/getcust/0')}}">Inactive Customers</a></li>
  <li @if($submenu=="Customertype") class="active" @else class=""  @endif><a  href="{{url('admin/customertype')}}">Customer Types</a> </li>
</ul>   
@endsection
@section('contents')
<div class="content-container">
   <div class="content-area">
      <div class="row">
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card no-margin minH">
               <div class="card-block">
                  <div class="card-title">
                     <div class="card-title-header">
                        <h3>Customers Details</h3>
                        <div class="card-title-header-between"></div>
                        <div class="card-title-header-actions">
                           <a href="{{admin_url('customers')}}/{{$user->id}}/edit"
                              class="btn btn-icon green_button" rel="tooltip"
                              data-tooltip="Edit">
                              Edit
                           </a>
                           <a href="{{admin_url('customers')}}"
                              class="btn btn-icon green_button" rel="tooltip"
                              data-tooltip="Back">
                              Back
                           </a>
                        
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