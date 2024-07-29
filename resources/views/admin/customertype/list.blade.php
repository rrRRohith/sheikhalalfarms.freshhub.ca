@extends('layouts.admin')
@section('title', 'Customer Type')
@section('page_title','Customers')
@section('page_nav')
<ul>
  <li><a  href="{{url('admin/customers')}}">All Customers</a></li>
  <li><a  href="{{url('admin/customers/getcust/1')}}">Active Customers</a></li>
  <li><a  href="{{url('admin/customers/getcust/0')}}">Inactive Customers</a></li>
  <li class="active"><a  href="{{url('admin/customertype')}}">Customer Types</a> </li>
</ul>  
@endsection
@section('contents')
<div class="content-container">
   <div class="content-area">
      <div class="row main_content">
         <div class="col-md-12">
            <div class="card no-margin minH">
               <div class="card-block">
                   <div class="card-title">
                       <a href="{{admin_url('customertype/create')}}"  class="pull-right green_button">
                                                   <i class="fa fa-new"></i> New Customer Type </a>
                    <h3>Customer types</h3>
                  </div>
                   <section class="card-text customers_outer">
                     <div class="row filter-customer">
                           <div class="col-lg-12">
                              <div class="filter-customer-list">
                                 @if (Session::has('message'))
                                 <div class="alert alert-success">
                                    {{ Session::get('message') }}
                                 </div>
                                 @endif
                                 <div class="table-list-responsive-md">
                                     
                                    <table class="table table-customer mt-0">
                                       
                                       <thead>
                                          <tr>
                                             <th>
                                              ID
                                             </th>
                                             <th class="text-left">
                                                Name
                                             </th>
                                             <th class="text-left">
                                                 Customers
                                             </th>
                                           <th class="text-right">Actions</th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                       @if(isset($customertypes) && count($customertypes)>0)
                                          @foreach($customertypes as $t)
                                          <tr  >
                                             <td width="5">
                                               {{$t->id}}
                                             </td>
                                             <td class="text-lg-left  text-md-left"data-label="Organization"><label class="">@if(count($t->customer) >0)<a target='' href="{{admin_url('customers')}}/type/{{$t->id}}">{{$t->name}}</a>@else{{$t->name}}@endif</label></td>
                                             <td class="text-lg-left  text-md-left">
                                                 {{count($t->customer)}}
                                             </td>
                                             <td class="text-right" >
                                                <div class="fh_actions pull-right">
                                                    <a href="#" class="fh_link">Actions <i class="fa fa-caret-down"></i> </a>
                                                    <ul class="fh_dropdown">
                                                        @can('Customer Edit')
                                                        <a href="{{admin_url('customertype')}}/{{$t->id}}/edit"><li><i class="fa fa-edit"></i> Edit</li></a>
                                                        @endcan
                                                        @can('Customer Delete')
                                                        <a href="{{admin_url('customertype')}}/{{$t->id}}/del"><li><i class="fa fa-trash"></i> Delete</li></a>
                                                        @endcan
                                                    </ul>
                                                </div>
                                             </td>
                                          </tr>
                                          @endforeach
                                       @else
                                        <tr>
                                            <td colspan="3" class="text-center">No Customer Types Found</td>
                                        </tr>
                                    @endif
                                       </tbody>

                                    </table>
                                    <!--<div class="result_summary text-center">Showing result {{count($customertypes)}} of total {{count($customertypes)}}</div>-->
                                    
                                 </div>
                              </div>
                           </div>
                        </div>
                     </section>
               <div class="text-bold" style="padding:10px;"> {{$customertypes->links()}}Showing Page {{$customertypes->currentPage()}} of {{$customertypes->lastPage()}} </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection