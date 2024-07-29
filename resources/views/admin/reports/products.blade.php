@extends('layouts.admin')
@section('title','Products Report')
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
                                                 @php $total=getWeight($w->weight)*getRate($w->price);@endphp
                                                @else
                                                 @php $total=$w->quantity*$w->price;@endphp
                                                @endif 
                                                    <tr>
                                                        <td class="text-left">{{$w->id}}</td>
                                                        <td>
                                                            {{$w->sku}}
                                                           
                                                        </td>
                                                        <td  class="text-left" data-label="Organization"><label>{{$w->name}}</label></td>
                                                        
                                                        <td class="text-left" data-label="Organization"><label>{{showPrice(getRate($w->price))}}</label></td>
                                                        <td>{{$w->quantity}} @php $totqty+=$w->quantity; @endphp</td>
                                                        <td class="text-left" data-label="Organization"><label>{{getWeight($w->weight).defWeight()}} @php $totweight+=getWeight($w->weight); @endphp</label></td>
                                                        <td class="text-left" data-label="Organization" class="text-right"><label class="">{{showPrice($total)}} @php $tot+=$total; @endphp</label></td>
                                                        
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