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
                                        
                                        @include('admin.reports.filters')
                                        
                                        <div class="table-list-responsive-md">
                                            
                                            <table class="table table-customer">

                                                <thead>
                                                    <tr>
                                                        <!--<th class="text-left">ID</th>-->
                                                        <th class="text-left">Customer Name - Store Name</th>
                                                        <th class="text-left">Purchase Qty</th>
                                                        <th class="text-left">Invoice Total</th>
                                                        <th class="text-left">Paid Total</th>
                                                        <th class="text-center">Due Amount</th>
                                                        <th class="text-center">Overdue Amount</th>
                                                        <!--<th class="text-left">Status</th>-->
                                                        <!--<th class="text-right">Actions</th>-->
                                                    </tr>
                                                </thead>
                                            <tbody>
                                                @php $i=1;@endphp
                                                @php $grandtotal=0;$paidamount=0;$totqty=0;$totdue=0;$totoverdue=0;@endphp
                                                @if(isset($customers) && count($customers)>0)
                                                
                                                @foreach($customers as $c)
                                                @php $qty=0;$dueamount=0;$overdue=0;@endphp
                                                  @foreach($c->order as $o)
                                                  
                                                  @if($o->due_date > date('Y-m-d'))
                                                    @php $dueamount+=$o->grand_total-$o->paid_amount;@endphp
                                                  @else
                                                    @php $overdue+=$o->grand_total-$o->paid_amount;@endphp
                                                  @endif
                                                  @endforeach
                                                    <tr>
                                                        
                                                        <!--<td data-label="" class="text-left">{{$c->id}}</td>-->
                                                        <td class="text-lg-left  text-md-left"data-label="Organization"><label class=""><a target='' href="{{admin_url('customers')}}/{{$c->id}}">{{$c->firstname}} {{$c->lastname}} - {{$c->business_name}}</a></label></td>
                                                        <td data-label="City" class="text-left">{{$c->order->sum('total_quantity')}}@php $totqty+=$c->order->sum('total_quantity'); @endphp</td>
                                                        <td data-label="Customer type" class="text-left">{{showPrice($c->order->sum('grand_total'))}} @php $grandtotal+=$c->order->sum('grand_total'); @endphp</td>
                                                        <td>{{showPrice($c->order->sum('paid_amount'))}} @php $paidamount+=$c->order->sum('paid_amount'); @endphp</td>
                                                        <td class="text-center">{{showPrice($dueamount)}} @php $totdue+=$dueamount; @endphp</td>
                                                        <td class="text-center">{{showPrice($overdue)}} @php $totoverdue+=$overdue;@endphp</td>
                                                        
                                                    </tr>
                                                    @php $i++;@endphp
                                                @endforeach
                                                @else
                                                <tr>
                                                    <td colspan="9" class="text-center">No Customers Found</td>
                                                </tr>
                                            @endif
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>Total</th>
                                                    <th>{{$totqty}}</th>
                                                    <th>{{showPrice($grandtotal)}}</th>
                                                    <th>{{showPrice($paidamount)}}</th>
                                                    <th class="text-center">{{showPrice($totdue)}}</th>
                                                    <th class="text-center">{{showPrice($totoverdue)}}</th>
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
