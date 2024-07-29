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
                                             <th class="text-left">Day</th>
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
                                          @if(isset($sales) && count($sales)>0)
                                          @php $totqty=0;$subtotal=0;$tottax=0;$totdisc=0;$grandtotal=0; @endphp
                                          @foreach($sales as $order)
                                          <tr>
                                             <!--<td class="text-left">{{$order->id}}</td>-->
                                             <td class="text-left">{{date('D d M',strtotime($order->shipping_date))}}</td>
                                             <td class="text-left">
                                                 
                                                 PO{{$order->id}}
                                                 
                                            </td>
                                              <td class="text-left">
                                                  {{$order->item->sum('quantity')}}
                                                  @php $totqty+=$order->item->sum('quantity');@endphp
                                                <!--<a href="{{admin_url('customers')}}/{{$order->user_id}}/edit">
                                                @if($order->business_name !='')
                                                {{$order->business_name }}
                                                @else
                                                {{$order->user->firstname . ' ' . $order->user->lastname}}
                                                @endif
                                                </a>-->
                                             </td> 
                                             <td class="text-center">
                                                {{showPrice($order->item->sum('total'))}}
                                                @php $subtotal+=$order->item->sum('total');@endphp
                                            </td>
                                            <td class="text-center">
                                                {{showPrice($order->tax)}}
                                                @php $tottax+=$order->tax;@endphp
                                               
                                            </td>
                                             <td class="text-center">
                                                {{showPrice($order->discount_amount)}}
                                                @php $totdisc+=$order->discount_amount;@endphp
                                             </td>
                                             <td class="text-center">
                                                  {{showPrice($order->grand_total)}}
                                                  @php $grandtotal+=$order->grand_total;@endphp
                                             </td>
                                             <!--<td class="text-right">-->
                                             <!--   @if($order->status > 3)-->
                                             <!--       {{showPrice($order->grand_total)}}-->
                                             <!--   @else-->
                                             <!--       --->
                                             <!--   @endif-->
                                             <!--</td>-->
                                             
                                             
                                          </tr>
                                          @endforeach
                                           
                                          @else
                                          <tr>
                                              <td colspan="9"><center>No Orders Found !!</center></td>
                                          </tr>
                                          @endif
                                       </thead>
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
                                       <tbody>
                                       </tbody>
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
