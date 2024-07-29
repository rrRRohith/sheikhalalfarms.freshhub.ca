@extends('layouts.customer')
@section('title','Products Report')
@section('page_title','Report')
@section('page_nav')

<ul>
  <li @if($submenu=="ReportBySale") class="active" @else class="" @endif><a  href="{{customer_url('report/sale')}}">Sales</a></li>
  <li @if($submenu=="ReportByProduct") class="active" @else class="" @endif ><a   href="{{customer_url('report/product')}}">Products</a></li>
  
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
                                        
                                         @include('admin.reports.filters')
                                        
                                        <div class="table-list-responsive-md">
                                        <table class="table table-customer mt-0">
                                            <thead>
                                                <tr>
                                                    <th class="text-left">
                                                        Product ID
                                                    </th>
                                                   
                                                    <th class="text-left">
                                                        SKU
                                                    </th>
                                                    <th class="text-left">
                                                        Product Name
                                                    </th>
                                                    <th class="text-left">
                                                        Rate
                                                    </th>
                                                    <th class="text-left">
                                                        Qty Sold
                                                    </th>
                                                    <th>
                                                        Weight Sold
                                                    </th>
                                                    <th>Total</th>
                                                    
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $totqty=0;$totweight=0;$tot=0;@endphp
                                                @if(isset($products) && count($products)>0)
                                                @foreach($products as $w)
                                                @if($w->price_by=='weight')
                                                 @php $total=Helper::getWeight($w->orderitem->sum('weight'))*$w->price;@endphp
                                                @else
                                                 @php $total=$w->orderitem->sum('quantity')*$w->price;@endphp
                                                @endif 
                                                    <tr>
                                                        <td class="text-left">{{$w->id}}</td>
                                                        <td>
                                                            {{$w->sku}}
                                                            <!--<img src= "{!!$w->picture !='' ? '/images/products/'.$w->picture : '/media/products/dummy.jpg' !!}" style="width:50px;height:50px;"/>-->
                                                        </td>
                                                        <td  class="text-left" data-label="Organization"><label>{{$w->name}}</label></td>
                                                        <!--<td  data-label="Organization"><label>{{$w->description}}</label></td>-->
                                                        <td class="text-left" data-label="Organization"><label>{{showPrice($w->price)}}</label></td>
                                                        <td>{{$w->orderitem->sum('quantity')}} @php $totqty+=$w->orderitem->sum('quantity'); @endphp</td>
                                                        <td class="text-left" data-label="Organization"><label>{{Helper::getWeight($w->orderitem->sum('weight')).defWeight()}} @php $totweight+=Helper::getWeight($w->orderitem->sum('weight')); @endphp</label></td>
                                                        <td class="text-left" data-label="Organization" class="text-right"><label class="">{{showPrice($total)}} @php $tot+=$total; @endphp</label></td>
                                                        <!--<td>-->
                                                        <!--    <div class="form-check form-switch">-->
                                                        <!--        <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" <?php if(isset($w)){ if($w->status==1){ ?> checked <?php } } ?> onchange="changeStatus('{{$w->id}}');" name="status">-->
                                                        <!--        <label class="form-check-label" for="flexSwitchCheckChecked"></label>-->
                                                        <!--    </div>-->
                                                        <!--</td>-->
                                                        <!--<td data-label="Created on" class="text-left">{{date('d M Y',strtotime($w->created_at))}} </td>-->
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
                                                @else
                                                <tr>
                                                    <th colspan="7"><center>No Products Found</center></th>
                                                </tr>
                                                @endif
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th colspan="4">Total</th>
                                                    <th>{{$totqty}}</th>
                                                    <th>{{$totweight.defWeight()}}</th>
                                                    <th>{{showPrice($tot)}}</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
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
@section('bottom-scripts')
@include('admin.reports.footer')
@endsection