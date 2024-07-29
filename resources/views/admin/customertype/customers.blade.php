@extends('layouts.admin')
@section('title',$submenu .'Customers')
@section('page_title','Customers')
@section('page_nav')

<ul>
  <li @if($submenu=="All") class="active" @else class=""  @endif><a  href="{{url('admin/customers')}}">All Customers</a></li>
  <li @if($submenu=="Active") class="active" @else class="" @endif><a  href="{{url('admin/customers?status=1')}}">Active Customers</a></li>
  <li @if($submenu=="Inactive") class="active" @else class="" @endif ><a   href="{{url('admin/customers?status=0')}}">Inactive Customers</a></li>
  <li @if($submenu=="Customertype") class="active" @else class=""  @endif><a  href="{{url('admin/customertype')}}">Customer Types</a> </li>
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
                           <a class="pull-right green_button" href="{{url('admin/customertype')}}"><i class="fa fa-new"></i> Back</a>
                            <h3>Customer Type-{{$type}}</h3>
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

                                                        <th class="text-left"> ID </th>
                                                        <th class="text-left">Store Name</th>
                                                        <th class="text-left">Address</th>
                                                        <th class="text-left">Phone</th>
                                                        <th class="text-left">Status</th>
                                                    </tr>
                                                </thead>
                                            <tbody>
                                                @foreach($customers as $key=>$customer)
                                                    <tr>
                                                        <td class="text-left">
                                                            {{$key+1}}
                                                        </td>
                                                        <td class="text-left">
                                                            {{$customer->business_name}}
                                                        </td>
                                                        <td class="text-left">
                                                            {{$customer->address}}, 
                                                            
                                                            {{$customer->city}},{{$customer->province}}, 
                                                            
                                                            {{$customer->postalcode}}
                                                        </td>
                                                        <td>
                                                            {{$customer->phone}}
                                                        </td>
                                                        <td class="text-left">
                                                            @if($customer->status==1)
                                                                <font color="green">Active</font>
                                                            @else
                                                                <font color="red">Inactive</font>
                                                            @endif
                                                        </td>
                                                        
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            
                                        </table>
                                        
                                        
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!--<div class="p-0 col-lg-4 mr-auto paginate d-flex" data-sort="" data-direction=""></div>-->
                </div>
            </div>
        </div>
      </div>
    </div>
</div>

@endsection
@section('bottom-scripts')
@endsection
