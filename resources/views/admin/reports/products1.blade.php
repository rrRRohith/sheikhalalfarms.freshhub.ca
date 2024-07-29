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
                                                    <th class="text-left">
                                                        ID
                                                    </th>
                                                    <th>
                                                    </th>
                                                    <th class="text-left">
                                                        Name
                                                    </th>
                                                    <th class="text-left">
                                                        Category
                                                    </th>
                                                    <th class="text-left">
                                                        Weight
                                                    </th>
                                                    <th class="text-left">
                                                        Price
                                                    </th>
                                                    <!--<th class="text-left">-->
                                                    <!--    Status-->
                                                    <!--</th>-->
                                                    <th class="text-left">
                                                        Created On
                                                    </th>
                                                    <!--<th class="text-right">Actions</th>-->
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($products as $w)
                                                    <tr>
                                                        <td class="text-left">{{$w->id}}</td>
                                                        <td>
                                                            <img src= "{!!$w->picture !='' ? '/images/products/'.$w->picture : '/media/products/dummy.jpg' !!}" style="width:50px;height:50px;"/>
                                                        </td>
                                                        <td  class="text-left" data-label="Organization"><label>{{$w->name}}</label></td>
                                                        <!--<td  data-label="Organization"><label>{{$w->description}}</label></td>-->
                                                        <td class="text-left" data-label="Organization"><label>{{$w->category['name']}}</label></td>
                                                        <td class="text-left" data-label="Organization"><label>{{Helper::getWeight($w->weight)}}</label></td>
                                                        <td class="text-left" data-label="Organization" class="text-right"><label class="">{{$w->price}}</label></td>
                                                        <!--<td>-->
                                                        <!--    <div class="form-check form-switch">-->
                                                        <!--        <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" <?php if(isset($w)){ if($w->status==1){ ?> checked <?php } } ?> onchange="changeStatus('{{$w->id}}');" name="status">-->
                                                        <!--        <label class="form-check-label" for="flexSwitchCheckChecked"></label>-->
                                                        <!--    </div>-->
                                                        <!--</td>-->
                                                        <td data-label="Created on" class="text-left">{{date('d M Y',strtotime($w->created_at))}} </td>
                                                        <!--<td class="text-right">-->
                                                        <!--    <div class="fh_actions">-->
                                                        <!--        <a href="#" class="fh_link">Actions <i class="fa fa-caret-down"></i> </a>-->
                                                        <!--        <ul class="fh_dropdown">-->
                                                        <!--            <a class="editproduct" data-id="{{$w->id}}"><li>Edit</li></a>-->
                                                        <!--            <a href="{{admin_url('products')}}/{{$w->id}}/del"><li>Delete</li></a>-->
                                                        <!--        </ul>-->
                                                        <!--    </div> -->
                                                        <!--</td>-->
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <div class="text-bold" style="padding:10px;"> {{$products->links()}}Showing Page {{$products->currentPage()}} of {{$products->lastPage()}} </div>
                </div>
            </div>
        </div>
      </div>
    </div>
</div>


@endsection
