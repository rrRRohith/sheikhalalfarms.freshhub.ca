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
      <div class="row  main_content">
         <div class="col-md-12">
            <div class="card">
               <div class="card-block">
                  <div class="card-title">
                      <a href="/admin/customertype" class="pull-right white_button"><i class="fa fa-arrow-left"></i> All Types</a>
                    <h3>@isset($customertype) Edit Customer Type @else New Customer Type @endisset</h3>
                  </div>
                  <section class="card-text">
                      
                    <div class="row">
                        <div class="col-md-4 offset-md-4 " id="addAccountForm">
                            <form class="pt-0" id="form" method="post" class="fh_form" 
                               action="@if(isset($customertype)){{admin_url('customertype/'.$customertype->id)}} @else {{admin_url('customertype')}} @endif">
                               @if(isset($customertype))
                               @method('PUT')
                               @endif
                               @csrf
                               <div class="box">
                               <input type="hidden" id="id" name="id" value="@if(isset($customertype)) {{$customertype->id}} @endif">
                               <section class="form-block">
                                 
                                  <div class="form-group">

                                        <label class="control-label" for="name">Type Name</label>
                                        <input class="form-control number" id="name"
                                           value="{{old('name',isset($customertype)?$customertype->name:'')}}"
                                           name="name">
                                        @if ($errors->has('name'))
                                        <span class="form-error">{{$errors->first('name')}}</span>
                                        @endif
                                  </div>
                                  <div class="form-group">
                                      <button type="submit" class="green_button">
                                           <i class="fa fa-check"></i> Save                        
                                        </button>
                                  </div>
    
                               </section>
                              </div>
                            </form>
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