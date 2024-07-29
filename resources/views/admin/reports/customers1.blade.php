@extends('layouts.admin')
@section('title','Customers Report')
@section('page_title','Report')
@section('page_nav')

<ul>
  <li @if($submenu=='ReportByCustomer') class="active" @else class=""  @endif><a  href="{{admin_url('report/customer')}}">Customers</a></li>
  <li @if($submenu=="ReportBySale") class="active" @else class="" @endif><a  href="{{admin_url('report/sale')}}">Sales</a></li>
  <li @if($submenu=="ReportByProduct") class="active" @else class="" @endif ><a   href="{{admin_url('report/product')}}">Products</a></li>
  
</ul>   
@endsection
@section('contents')
<div class="content-container">
    <div class="content-area">
        <div class="row main_content">
            <div class="col-md-12">
                <div class="card no-margin minH">
                    <div class="card-block">
                        
                        <section class="card-text customers_outer">
                            <div class="row filter-customer">
                                <div class="col-lg-12">
                                    <div class="filter-customer-list">
                                        @if (Session::has('message'))
                                        <div class="alert alert-success">
                                            {{ Session::get('message') }}
                                        </div>
                                        @endif
                                        
                                        <form action="" method="get" id="filter_form">
                                            @csrf
                                            <div class="row">
                                                
                                                <div class="col-sm-3">
                                                    <label class="control-label">Duration</label>
                                                    <select name="duration" id="duration" class="form-control">
                                                        <option value="">All</option>
                                                        <option value="0">Day</option>
                                                        <option value="1">Week</option>
                                                        <option value="2">Custom</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-3">
                                                 <label class="control-label">Category</label>
                                                    <select name="category" id="category" class="form-control">
                                                        <option value="">All</option>
                                                        <option value="0">Day</option>
                                                        <option value="1">Week</option>
                                                        <option value="2">Custom</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-2">
                                                    <label class="control-label">Status</label>
                                                    <select name="status"  class="form-control">
                                                        <option value="2" @if(isset(Request()->status) && (Request()->status==2)) selected @endif>All</option>
                                                        <option value="1" @if(isset(Request()->status) && (Request()->status==1)) selected @endif>Active</option>
                                                        <option value="0" @if(isset(Request()->status) && (Request()->status==0)) selected @endif>Inactive</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-2">
                                                    <label class="control-label">&nbsp;</label><br/>
                                                    <button  class="white_button" type="submit">Filter Customers</button>
                                                </div>
                                            </div>
                                        </form>
                                        
                                        <div class="table-list-responsive-md">
                                            
                                            <table class="table table-customer mt-0">

                                                <thead>
                                                    <tr>
                                                        <th class="text-left">ID</th>
                                                        <th class="text-left">Name</th>
                                                        <th class="text-left">Store Name</th>
                                                        <th class="text-left">Type</th>
                                                        <th class="text-left">Addr.</th>
                                                        <th class="text-left">Unpaid Inv.</th>
                                                        <th class="text-left">Total Due</th>
                                                        <!--<th class="text-left">Status</th>-->
                                                        <!--<th class="text-right">Actions</th>-->
                                                    </tr>
                                                </thead>
                                            <tbody>
                                                @php $i=1;@endphp
                                                @if(isset($customers) && count($customers)>0)
                                                
                                                @foreach($customers as $c)
                                                
                                                    <tr>
                                                        <td data-label="" class="text-left">{{$c->id}}</td>
                                                        <td class="text-lg-left  text-md-left"data-label="Organization"><label class=""><a target='' href="{{admin_url('customers')}}/{{$c->id}}">{{$c->firstname}} {{$c->lastname}}</a></label></td>
                                                        <td data-label="City" class="text-left"><label class="">{{$c->business_name}}</label></td>
                                                        <td data-label="Customer type" class="text-left">{{$c->types->name ?? ''}}</td>
                                                        <td>{{$c->address}}</td>
                                                        <td class="text-center">{{count($c->invoice)}}</td>
                                                        <td class="text-right" align="right"><a href="{{admin_url('invoices')}}/{{$c->id}}">{{'$'.number_format($c->invoice->sum('grand_total'),2)}}</a></td>
                                                        <!--<td class="text-center">-->
                                                        <!--    <div class="form-check form-switch">-->
                                                        <!--       <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" <?php if(isset($c)){ if($c->status==1){ ?> checked <?php } } ?> onchange="changeStatus('{{$c->id}}');" name="status">-->
                                                        <!--       <label class="form-check-label" for="flexSwitchCheckChecked"></label>-->
                                                        <!--    </div>-->
                                                        <!--</td>-->
                                                        <!--<td class="text-right">-->
                                                        <!--    <div class="fh_actions">-->
                                                        <!--        <a href="#" class="fh_link">Actions <i class="fa fa-caret-down"></i> </a>-->
                                                        <!--        <ul class="fh_dropdown">-->
                                                                    <!--<li><a href="{{admin_url('customers')}}/{{$c->id}}/edit">Edit</a></li>-->
                                                        <!--             <a class="editcustomer" data-id="{{$c->id}}"><li>Edit</li></a>-->
                                                        <!--            <a href="{{admin_url('customers')}}/{{$c->id}}/del"><li>Delete</li></a>-->
                                                        <!--        </ul>-->
                                                        <!--    </div> -->
                                                        <!--</td>-->
                                                    </tr>
                                                    @php $i++;@endphp
                                                @endforeach
                                                @else
                                                <tr>
                                                    <td colspan="9" class="text-center">No Customers Found</td>
                                                </tr>
                                            @endif
                                            </tbody>
                                            
                                        </table>
                                        
                                        
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <div class="text-bold" style="padding:10px;"> {{$customers->links()}}Showing Page {{$customers->currentPage()}} of {{$customers->lastPage()}} </div>
                </div>
            </div>
        </div>
      </div>
    </div>
</div>


@endsection
