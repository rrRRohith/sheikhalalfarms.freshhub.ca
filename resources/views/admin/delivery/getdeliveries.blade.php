@extends('layouts.admin')
@section('title','Generate Runsheet')
@section('page_title','Deliveries')
@section('page_nav')
<ul>
    <ul>
    <li><a href="{{admin_url('deliveries')}}">Deliveries</a></li>
    <li class="active"><a  href="{{admin_url('generaterunsheet')}}">Assign Driver</a>
    
    
</ul>
    
    
</ul>
@endsection
@section('contents')
<div class="content-container">
   <div class="content-area">
      <div class="row main_content">
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 addnew_form">
            <div class="card no-margin minH">
               <div class="card-block" style="border:1px solid black;padding:5px;">
                           <div class="logo text-center padding-side-30">
            <img src="{{asset('img/freshhub_logo.png')}}" alt="FreshHub logo" style="width:250px;height:auto;">
        </div>
        <br>
        <h3><center>Runsheets</center></h3>
        
              
                  
                  
                  
                    
                  <section class="card-text">

                    <div class="row">
                        <div class="col-12">
                           <label class="font-weight-bold" style="font-family: 'Open Sans', sans-serif;font-size:16px;">Driver Name : {{$driver->firstname}} {{$driver->lastname}}</label>
                        </div>
                        <br>
                        <div class="col-12">
                            <label class="font-weight-bold" style="font-family: 'Open Sans', sans-serif;font-size:16px;"> Date : {{date('F d Y',strtotime(Request()->date))}}</label>
                        </div>
                        <div class="col-12">
                            <label class="font-weight-bold" style="font-family: 'Open Sans', sans-serif;font-size:16px;"> Total Deliveries : {{count($orders)}}</label>
                        </div>
                    </div>

                  </section>

                  <section class="card-text">

                     <div class="row filter-customer">
                       <div class="col-lg-12">
                          <div class="filter-customer-list">
                            @if (Session::has('message'))
                             <div class="alert alert-success">
                                <font color="red" size="4px">{{ Session::get('message') }}</font>
                             </div>
                            @endif
                               
                                <div class="table-list-responsive-md">
                                    <table class="table table-customer mt-0">
                                       <thead>
                                          <tr>
                                            <th  scope="col">#</th>
                                            <!-- <th  scope="col">PO</th>-->
                                            <th  scope="col"> Invoice No</th>
                                             <th  scope="col"> Store Name</th>
                                            <th  scope="col">Contact Name</th>
                                            <th  scope="col"> Shipping Address</th>
                                            <th  scope="col">Phone</th>
                                            <th scope="col">Cases Of Delivery</th>
                                            <th scope="col">Weight</th>
                                            <th scope="col">Invoice Amount</th>
                                            <th scope="col">Action</th> 
                                                                               
                                          
                                            
                                          </tr>
                                       </thead>
                                        <tbody>
                                           
                                            @php $id=1;$totcase=0;$totweight=0;$totamount=0; @endphp
                                            @if(isset($orders) && count($orders)>0)
                                                @foreach($orders as $order)
                                                    @php $address=" {$order->delivery->address}, {$order->delivery->city}, {$order->delivery->province}, {$order->delivery->postalcode}"; @endphp
                                                    <tr>
                                                        <td scope="row">{{$id}}</td>
                                                        <!--<td scope="row">PO{{$order->id}}</td>-->
                                                        <td scope="row">{{$order->invoice->invoice_number}}</td>
                                                        <td scope="row"> {{$order->user->business_name}}</td>
                                                        <td scope="row">{{$order->user->firstname}}  {{$order->user->lastname}}</td>
                                                        <td scope="row"> <a href="https://www.google.com/maps/place/{{$address}}"  target="_blank">
                                                                                      {{$order->delivery->address}}<br>{{$order->delivery->city}}, {{$order->delivery->province}}<br>{{$order->delivery->postalcode}}
                                                                                    </a>
                                                                                    </td>
                                                        <td scope="row">{{$order->user->phone}}</td>
                                                        <td scope="row" class="text-center">
                                                            {{$order->item->sum('quantity')}}
                                                            @php $totcase+=$order->item->sum('quantity');@endphp
                                                        </td>
                                                        <td scope="row" class="text-center">
                                                            {{getWeight($order->item->sum('weight')).' '.defWeight()}}
                                                            @php $totweight+=$order->item->sum('weight'); @endphp
                                                        </td>
                                                        <td scope="row">
                                                            {{showPrice($order->grand_total)}}
                                                            @php $totamount+=$order->grand_total; @endphp
                                                        </td>
                                                        <td scope="row">
                                                            
                                                            
                                                            @if((date('Y-m-d') <= Request()->date) && (strtotime(date("H:i:s")) <=strtotime('17:00:00'))) 
                                                                <select class="form-control" name="driver_id" id="driver_id" data-id="{{$order->id}}">
                                                                    <option value="">Assign None</option>
                                                                    @foreach($drivers as $dri)
                                                                    <option value="{{$dri->id}}" @if($dri->id == $driver->id) selected @endif>{{$dri->firstname}} {{$dri->lastname}}</option>
                                                                    @endforeach
                                                                </select>
                                                            @else
                                                                <select class="form-control" name="driver_id" id="driver_id" data-id="{{$order->id}}" disabled>
                                                                    <option value="">Assign None</option>
                                                                    @foreach($drivers as $dri)
                                                                    <option value="{{$dri->id}}" @if($dri->id == $driver->id) selected @endif>{{$dri->firstname}} {{$dri->lastname}}</option>
                                                                    @endforeach
                                                                </select>
                                                           @endif
                                                            <!--<button data-id="{{$order->id}}" class="pull-left white_button removedelivery"><i class="fa fa-trash" aria-hidden="true"></i></button>-->
                                                        </td>
                                          
                                                    </tr>
                                                    @php $id++; @endphp
                                                @endforeach
                                                <thead>
                                                    <tr>
                                                        <th colspan="6">Total</th>
                                                        <th class="text-center">{{$totcase}}</th>
                                                        <th>{{getWeight($totweight).' '.defWeight()}}</th>
                                                        <th>{{showPrice($totamount)}}</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                            @else
                                                <tr>
                                                    <th colspan="9" class="text-center">No Deliveries Found</th>
                                                </tr>
                                            @endif
                                        </tbody>
                                    
                                    </table>
                                </div>
                                 
                              
                             
                          </div>
                       </div>
                    </div>

                    </section>
                    @if(isset($orders) && count($orders)>0)
                    <a href="{{admin_url('runsheets/print/'.$order->runsheet_id)}}" target="_blank"><button class="green_button pull-right"><i class="fa fa-print"></i> Print Runsheet</button></a>&nbsp;&nbsp;&nbsp;&nbsp;
                    <a href="{{admin_url('runsheets/mail/'.$order->runsheet_id)}}"><button class="green_button pull-right" style="margin-right:10px;"><i class="fa fa-envelope" aria-hidden="true"></i> Email Runsheet</button></a>
                    @endif
                    <!--<button type="submit" class="white_button"><i class="fa fa-bolt"></i> Generate Runsheet</button>-->

                   <!--</form>-->


                    
                 
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
        $('#date').on('change',function(){
            var date1=$(this).val();
            var url="<?php echo admin_url('deliveries')?>/" +date1;
            window.location=url;
        });
        $('.removedelivery').on('click',function(){
            var id=$(this).data('id');
            var url="<?php echo admin_url('deliveries/remove')?>?id=" +id;
            $.ajax({
            type: "get",
            url: url,
            success: function(data) {
                location.reload();
            }
        });
        });
        $('#driver_id').on('change',function(){
            var id=$(this).data('id');
            var driver=$(this).val();
            var url="<?php echo admin_url('deliveries/reassign')?>?id=" +id+"&driver="+driver;
            $.ajax({
            type: "get",
            url: url,
            success: function(data) {
                location.reload();
            }
        });
            
        });
    });
</script>
@endsection