@extends('layouts.admin')
@section('title',isset($customertype) ? 'Edit Customer Type' :'Add Customer Type')
@section('page_title','Customers')
@section('page_nav')
<ul>
  <li><a  href="{{url('admin/customers')}}">All Customers</a></li>
  <li><a href="{{url('admin/customers/getcust/1')}}">Active Customers</a></li>
  <li><a  href="{{url('admin/customers/getcust/0')}}">Inactive Customers</a></li>
  <li class="active"><a  href="{{url('admin/customertype')}}">Customer Types</a> </li>
</ul>  
@endsection
@section('contents')
<div class="content-container">
   <div class="content-area">
      <div class="row">
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-xs-padding">
            <div class="card no-margin minH">
               <div class="card-block">
                  <div class="card-title">
                    
                  </div>
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
                           action="@if(isset($customertype)){{admin_url('customertype/'.$customertype->id)}} @else {{admin_url('customertype')}} @endif">
                           @if(isset($customertype))
                           @method('PUT')
                           @endif
                           @csrf
                           <input type="hidden" id="id" name="id" value="@if(isset($customertype)) {{$customertype->id}} @endif">
                           <section class="form-block">
                              <div class="separator">
                                 <label class="separator-text separator-text-success">Customer Type Details</label>
                              </div>
                              <div class="form-group row">
                                 <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12 text-right no-md-padding">
                                    <label class="text-gray-dark"
                                       for="opportunity_source_id">Type Name</label>
                                 </div>
                                 <div class="col-lg-5 col-md-5 col-sm-12">
                                    <input class="form-control number" id="name"
                                       value="{{old('name',isset($customertype)?$customertype->name:'')}}"
                                       name="name">
                                    @if ($errors->has('name'))
                                    <span class="form-error">{{$errors->first('name')}}</span>
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