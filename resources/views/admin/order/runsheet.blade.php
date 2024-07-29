@extends('layouts.admin')
@section('title','Generate Runsheet')
@section('page_title','Runsheet')
@section('page_nav')
<ul>
   
    <li><a href="{{admin_url('deliveries')}}">Generate Runsheet</a></li>
    <li  class="active"><a  href="{{admin_url('runsheets')}}">Runsheets</a>
</ul>
@endsection
@section('contents')
<div class="content-container">
   <div class="content-area">
        <div class="row main_content">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 addnew_form">
                <div class="card no-margin minH">
                    <div class="card-block">
                        <div class="title">
                            <div class="innerpage_title">
                                <h3>Runsheet</h3>
                            </div>
                            <div class="d-flex justify-content-end mb-4">
                                <!--<a class="btn btn-primary btnprn" href="{{admin_url('printrunsheet')}}/{{$orders[0]->runsheet_id}}" target="_blank"></a>-->
                                <a href="{{admin_url('runsheets/print/'.$runsheet->id)}}" target="_blank" class="pull-right green_button btnprn"><i class="fa fa-print"></i> Print</a>
                                <div class="clearfix"></div>
                            </div>
                            <section class="card-text customers_outer">
                                <div class="row filter-customer">
                                    <div class="col-lg-12">
                                        <div class="filter-customer-list">
                                            @if (Session::has('message'))
                                                <div class="alert alert-success">
                                                    <font color="red" size="4px">{{ Session::get('message') }}</font>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <label class="font-weight-bold">Driver Name : {{$orders[0]->driver->firstname}} {{$orders[0]->driver->lastname}}</label><br/>
                                                <label class="font-weight-bold"> Date : {{date('F d Y',strtotime($orders[0]->shipping_date))}}</label>
                                            </div>
                                            <div class="col-6">
                                                <label class="font-weight-bold">City : {{$runsheet->city}}</label><br/>
                                                <label class="font-weight-bold">Route : {{$runsheet->routes->name ?? ''}}</label>
                                            </div>

                                 
                                @if(isset($orders) && count($orders)>0)
                                <div class="table-list-responsive-md">
                                    <table class="table table-customer mt-0">
                                        <thead>
                                            <tr>
                                                <th>PO No</th> 
                                                <th>Invoice No</th>
                                                <th>Store Name</th>
                                                <th>Customer Name</th>
                                                <th>Delivery Address</th>

                                                <th>Phone</th>
                                                <th>Cases Of Delivery</th>
                                                <th>Total Amount</th>
                                                <th>Payment Method</th>
                                             
                                             <!--<th>-->
                                             <!-- #-->
                                             <!--</th>-->
                                             <!--<th class="text-left">-->
                                             <!--   Order No-->
                                             <!--</th>-->
                                             
                                             <!--<th class="text-left">Customer</th>-->
                                             <!--<th class="text-left">-->
                                             <!--   Address-->
                                             <!--</th>-->
                                             <!--<th class="text-left">Phone</th>-->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $id=1; @endphp
                                            @foreach($orders as $order)
                                            <tr>
                                                <td>
                                                    PO{{$order->id}}
                                                </td>
                                                <td>
                                                    {{$order->id}}
                                                </td>
                                                <td>
                                                    {{$order->user->business_name}}
                                                </td>
                                                <td>
                                                    {{$order->user->firstname}}  {{$order->user->lastname}}
                                                </td>
                                                <td>
                                                  
                                                    <a href="https://www.google.com/maps/place/{{$order->shipping_address}}"  target="_blank">
                                                      {{$order->shipping_address}}
                                                    </a>
                                                </td>
                                                <td>
                                                    {{$order->user->phone}}
                                                </td>
                                                <td class="text-center">
                                                    {{$order->item->sum('quantity')}}
                                                </td>
                                                  <td>
                                                     ${{$order->grand_total}}
                                                </td>
                                                  <td>
                                                      {{$order->user->paymentmethod->name}}
                                                </td>
                                                   </tr>  
                                            @php $id++; @endphp
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @endif
                              </div>
                           </div>
                        </div>
                     </section>
                  </section>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

@endsection
@section('bottom-scripts')
<script src="http://maps.google.com/maps/api/js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gmaps.js/0.4.24/gmaps.js"></script>
<script type="text/javascript">
$(document).ready(function(){
$('.btnprn').printPage();
});
</script>

@endsection