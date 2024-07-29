@extends('layouts.admin')
@section('title','Assign Drivers')
@section('page_title','Assign Drivers')
@section('page_nav')
<ul>
    <li><a href="{{admin_url('deliveries')}}">Deliveries</a></li>
    <li class="active"><a  href="{{admin_url('generaterunsheet')}}">Assign Drivers</a>
    
    
</ul>
@endsection
@section('contents')
<div class="content-container">
   <div class="content-area">
      <div class="row main_content">
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 addnew_form">
            <div class="card no-margin minH">
                <div class="diverselector">
                    @foreach($drivers as $driver)
                    <div class="driverdiv" data-id="{{$driver->id}}" data-count="{{count($driver->driverorder)}}">
                        <button class="driverselector_button white_button">{{$driver->firstname}} <span>{{count($driver->driverorder)}}</span></button>
                    
                    </div>
                    @endforeach
                </div>
               <div class="card-block" style="padding:5px;">
                  <!--  <div class="card-title">-->
                  <!--  <a href="{{admin_url('runsheets')}}" class="pull-right white_button"> -->
                  <!--    <i class="fa fa-arrow-left" aria-hidden="true"></i> All Runsheets</a>-->
                  <!--  <h3>Deliveries</h3>-->
                  <!--</div>-->
                  
                  @php $case=0;@endphp
                  @if(isset($orders) && count($orders)>0)
                  @foreach($orders as $order)
                  @foreach($order->item as $item)
                  @php $case+=$item->quantity;@endphp
                  @endforeach
                  @endforeach
                  @endif
                  <section class="card-text">

                    <div class="row">
                        <div class="col-md-12" id="addAccountForm">
                             <div class="row">
                                 <div class="col-sm-6">
                                    <label style="font-size:16px;"><strong>Total Deliveries</strong></label> : <span style="font-size:16px;">{{$totorders}}</span><br>
                                     <label style="font-size:16px;"><strong>Unassigned Deliveries</strong></label> : <span style="font-size:16px;">@if(isset($orders) && count($orders)>0) {{$orders->where('assign_driver',0)->count()}} @else 0 @endif</span>
                                 </div>
                                 <!--<div class="col-sm-3">-->
                                 <!--   <label>Search</label><br>-->
                                 <!--   <input type="text" class="form-control" name="search" id="search1" value="{{Request()->search}}" placeholder="Search by storename, phone number or invoice number">-->
                                 <!--   <br>-->
                                    
                                 <!--</div>-->
                                 <div class="col-sm-6">
                                    <label>Delivery Date</label><br>
                                    <input type="date" class="form-control" name="date" id="date" value="{{Request()->date ?? date('Y-m-d')}}">
                                    <br>
                                    
                                 </div>
                             </div>
                          

                            
                         </div>
                         
                    </div>

                  </section>



                    @if(isset($orders))
                  <section class="card-text">

                     <div class="row filter-customer">
                       <div class="col-lg-12">
                          <div class="filter-customer-list">
                            @if (Session::has('message'))
                             <div class="alert alert-success">
                                <font color="red" size="4px">{{ Session::get('message') }}</font>
                             </div>
                            @endif
                               <!--<form action="{{admin_url('assigndriver')}}" method="post" class="assigndelivery_form">-->
                               <!--                        @csrf-->
                                <div class="table-list-responsive-md">
                                    <table class="table table-customer mt-0">
                                       <thead>
                                          <tr>
                                             <th>Delivery Date</th>
                                             <th>Invoice Number</th>
                                             <th>Store Name</th>
                                             <th>Contact Person</th>
                                             <th>Address</th>
                                             <th class="text-center">Case/Qty</th>
                                             <th>Invoice Amount</th>
                                             <!--<th class="text-center">Weight</th>-->
                                             <!--<th class="text-center">Assign Route</th>-->
                                             <th class="text-left">Assign Driver</th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                           
                                           @if(count($orders)>0)
                                            
                                           @foreach($orders as $order)
                                           @php $address=" {$order->delivery->address}, {$order->delivery->city}, {$order->delivery->province}, {$order->delivery->postalcode}"; @endphp
                                           <tr>
                                               <td>
                                                   {{date('d M Y',strtotime($order->shipping_date))}}
                                               </td>
                                               <td>
                                                   {{$order->invoice->invoice_number}}
                                               </td>
                                               <td>{{$order->user->business_name}}</td>
                                               <td>
                                                   <input type="hidden" name="orderid[]" value="{{$order->id}}">
                                                   
                                                   
                                                  {{$order->user->firstname}} {{$order->user->lastname}}
                                               </td>
                                               
                                               <td>
                                                   <a href="https://www.google.com/maps/place/{{urlencode($address)}}" target="_blank"><i class="fa fa-map-marker"></i> {{$address}}</a>
                                               </td>
                                               <td>
                                                   {{$order->item->sum('quantity')}}
                                               </td>
                                               <td>
                                                  {{showPrice($order->grand_total)}}
                                               </td>
                                               <td>
                                                @if(Request()->has('date'))
                                                @php $d=Request()->date;@endphp
                                                @else
                                                @php $d=$order->shipping_date;@endphp
                                                @endif
                                                            @if((date('Y-m-d') <= $d) && (strtotime(date("H:i:s")) <= strtotime('17:00:00'))) 
                                                                <select class="form-control driver_select" name="driver" id="driver" data-id="{{$order->id}}">
                                                                   <option value="">Select Driver</option>
                                                                   @foreach($drivers as $driver)
                                                                   <option value="{{$driver->id}}" @if($order->driver_id==$driver->id) selected @endif>{{$driver->firstname}} {{$driver->lastname}}</option>
                                                                   @endforeach
                                                                </select>
                                                            @else
                                                                <select class="form-control driver_select" name="driver" id="driver" data-id="{{$order->id}}" disabled>
                                                                   <option value="">Select Driver</option>
                                                                   @foreach($drivers as $driver)
                                                                   <option value="{{$driver->id}}" @if($order->driver_id==$driver->id) selected @endif>{{$driver->firstname}} {{$driver->lastname}}</option>
                                                                   @endforeach
                                                                </select>
                                                           @endif     
                                                   
                                                   
                                                   <!--<button type="submit" class="white_button"><i class="fa fa-check" aria-hidden="true" ></i>Assign</button>-->
                                                    
                                                  
                                                  
                                               </td>
                                               
                                           </tr>
                                           @endforeach
                                           <!--</form>-->
                                           @else
                                           <tr>
                                               <th colspan="7"><center>No Deliveries Found for this date</center></th>
                                           </tr>
                                           @endif
                                       </tbody>
                                    
                                    </table>
                                 </div>
                                 @if(isset($orders) && count($orders)>0)
                                    <!--<div style="text-align:right;padding:7px;"><button type="submit" class="green_button"><i class="fa fa-bolt"></i> Generate Runsheet</button></div>-->
                                 @endif
                              
                             
                          </div>
                       </div>
                    </div>

                    </section>
                    
                   


                    @endif
                 
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

@endsection
@section('bottom-scripts')
<script>
    $(document).ready(function(){
        var today = new Date().toISOString().split('T')[0];
document.getElementsByName("date")[0].setAttribute('min', today);
        $('#date').on('change',function(){
            var date1=$(this).val();
            var url="<?php echo admin_url('generaterunsheet')?>?date=" +date1;
            window.location=url;
        });
        $('#search1').on('keyup',function(){
            var term=$(this).val();
            var url="<?php echo admin_url('deliveries')?>?search=" +term;
            window.location=url;
        });
        $('.driverdiv').on('click',function(){
            var driverid=$(this).data('id');
            var date=$('#date').val();
            var cou=$(this).data('count');
            if(date !='')
            {
                if(cou >0)
                {
                var url="<?php echo admin_url('getorders')?>?driver="+driverid+"&date="+date;
                window.location=url;
                }
                else
                {
                    alert("No pending delivery found for the selected driver");
                }
            }
            else
            {
                alert('Please select a date first');
                $('#date').focus();
            }
        });
    $('#driver').change(function(){
        var id=$(this).data('id');
        var driver=$(this).val();
        if(driver != '')
        {
        var url="<?php echo admin_url('assigndriver')?>?id="+id+"&driver="+driver;
        window.location=url;
        }
    });
    
    $('#all').change(function(){
        var date=$('#date').val();
       if($("#all").prop('checked') == true)
       {
           var url="<?php echo admin_url('deliveries')?>?date="+date+"&all=yes";
       }
       else
       {
           var url="<?php echo admin_url('deliveries')?>?date="+date;
       }
       window.location=url;
    });
    });
</script>

@endsection