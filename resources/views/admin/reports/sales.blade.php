@extends('layouts.admin')
@section('title','Sales Report')
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
                                                 
                                                 @if(Request()->reporttype==4)
                                                 Invoice Number
                                                 @elseif(Request()->reporttype==2)
                                                 Week
                                                 @elseif(Request()->reporttype==3)
                                                 Month
                                                 @else
                                                 Date
                                                 @endif
                                                 
                                             </th>
                                             <th class="text-left"> Orders </th>
                                             <th class="text-left">  Qty Sold</th>
                                             <th class="text-center">Subtotal</th>
                                             <th class="text-center">Tax</th>
                                             <th class="text-center"> Discount </th>
                                             <th class="text-center">Total </th>
                                             <!-- <th class="text-right"> Amount </th>-->
                                             <!--<th class="text-center"> Status </th>-->
                                             <!--<th class="text-right">Actions</th>-->
                                          </tr>
                                          </thead>
                                          <tbody>
                                          @php $totqty=0;$subtotal=0;$tottax=0;$totdisc=0;$grandtotal=0; @endphp
                                          @if(isset($sales) && count($sales)>0)
                                          
                                          @foreach($sales as $order)
                                          
                                          <tr>
                                             
                                             <td class="text-left">
                                                 @if(Request()->reporttype==4)
                                                 {{$order->invno}}
                                                 @elseif(Request()->reporttype==2)
                                                  @php
                                                  $dto = new DateTime();
                                                  $dto->setISODate(date('Y'), $order->week);
                                                  $ret['week_start'] = $dto->format('Y-m-d');
                                                  $dto->modify('+6 days');
                                                  $ret['week_end'] = $dto->format('Y-m-d');
                                                  @endphp
                                                  {{date('d M Y',strtotime($ret['week_start']))}} - {{date('d M Y',strtotime($ret['week_end']))}}
                                                 @elseif(Request()->reporttype==3)
                                                 {{date('F', mktime(0, 0, 0, $order->month, 10)) }}
                                                 @else
                                                 {{date('D d M',strtotime($order->invoice_date))}}
                                                 @endif
                                             </td>
                                             <td class="text-left">
                                                 
                                                 {{$order->orders}}
                                                 
                                            </td>
                                              <td class="text-left">
                                                  {{$order->items}}
                                                  @php $totqty+=$order->items;@endphp
                                                
                                             </td> 
                                             <td class="text-center">
                                                {{showPrice($order->sub_total)}}
                                                @php $subtotal+=$order->sub_total;@endphp
                                            </td>
                                            <td class="text-center">
                                                {{showPrice($order->tax)}}
                                                @php $tottax+=$order->tax;@endphp
                                               
                                            </td>
                                             <td class="text-center">
                                                {{showPrice($order->discount)}}
                                                @php $totdisc+=$order->discount;@endphp
                                             </td>
                                             <td class="text-center">
                                                  {{showPrice($order->grand_total)}}
                                                  @php $grandtotal+=$order->grand_total;@endphp
                                             </td>
                                             
                                             
                                             
                                          </tr>
                                          @endforeach
                                           
                                          @else
                                          <tr>
                                              <td colspan="9"><center>No Orders Found !!</center></td>
                                          </tr>
                                          @endif
                                       </tbody>
                                       <tfoot>
                                           <tr>
                                               <th>Total</th>
                                               <th></th>
                                               <th>{{$totqty}}</th>
                                               <th class="text-center">{{showPrice($subtotal)}}</th>
                                               <th class="text-center">{{showPrice($tottax)}}</th>
                                               <th class="text-center">{{showPrice($totdisc)}}</th>
                                               <th class="text-center">{{showPrice($grandtotal)}}</th>
                                           </tr>
                                       </tfoot>
                                       
                                    </table>
                                        <!--<div class="text-right"><button type="submit" name="submit" class="green_button" target="_blank"><i class="fa fa-print" aria-hidden="true"></i> Print</button></div>-->
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
