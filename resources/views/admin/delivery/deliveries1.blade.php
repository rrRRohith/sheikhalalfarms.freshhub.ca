@extends('layouts.admin')
@section('title','Generate Runsheet')
@section('page_title','Deliveries')
@section('page_nav')
<ul>
    <li class="active"><a href="{{admin_url('deliveries')}}">Generate Runsheet</a></li>
    <li><a  href="{{admin_url('runsheets')}}">Runsheets</a>
    
    
</ul>
@endsection
@section('contents')
<div class="content-container">
   <div class="content-area">
      <div class="row main_content">
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 addnew_form">
            <div class="card no-margin minH">
               <div class="card-block" style="border:1px solid black;padding:5px;">
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
                  <form action="{{admin_url('runsheets/generate/submit')}}" method="post">
                    @csrf
                    <input type="hidden" name="date" value="{{$date}}">
                  <section class="card-text">

                    <div class="row">
                        <div class="col-md-12" id="addAccountForm">
                             <div class="row">
                                 <div class="col-sm-6">
                                     <label>Drivers</label> : <span>{{count($drivers)}}</span>
                                     <br>
                                     <label>Total Deliveries</label> : <span>@if(isset($orders) && count($orders)>0) {{count($orders)}} @else 0 @endif</span>
                                     <br>
                                     <label>Total Cases</label> : <span>@if(isset($orders) && count($orders)>0) {{$case}} @else 0 @endif</span>
                                 </div>
                                 <div class="col-sm-6">
                                    <label>Delivery Date</label><br>
                                    <input type="date" class="form-control" name="date" id="date" value="{{$date}}">
                                    <br>
                                    @if(isset($orders) && count($orders)>0)<button type="submit" class="white_button"><i class="fa fa-bolt"></i> Generate Runsheet</button>@endif
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
                               
                                <div class="table-list-responsive-md">
                                    <table class="table table-customer mt-0">
                                       <thead>
                                          <tr>
                                             <th>Customer</th>
                                             <th>Address</th>
                                             <th class="text-center">Case/Qty</th>
                                             <th class="text-center">Weight</th>
                                             <th class="text-center">Assign Route</th>
                                             <th class="text-center">Assign Driver</th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                           
                                           @if(count($orders)>0)
                                           @foreach($orders as $order)
                                           <tr>
                                               <td>
                                                   <input type="hidden" name="id[]" value="{{$order->id}}">
                                                   
                                                   
                                                  {{$order->user->firstname}} {{$order->user->lastname}}
                                               </td>
                                               <td>
                                                   <a href="https://www.google.com/maps/place/{{urlencode($order->shipping_address)}}" target="_blank"><i class="fa fa-map-marker"></i> {{$order->shipping_address}}</a>
                                               </td>
                                               <td>
                                                   {{$order->item->sum('quantity')}}
                                               </td>
                                               <td>
                                                  {{$order->item->sum('weight') ?? 0.00}}
                                               </td>
                                               <td>
                                                   <select class="form-control" name="route[]" id="route">
                                                       <option value="">Select Route</option>
                                                       @foreach($routes as $route)
                                                       <option value="{{$route->id}}">{{$route->name}}</option>
                                                       @endforeach
                                                   </select>
                                               </td>
                                               <td>
                                                   <select class="form-control" name="driver[]" id="driver">
                                                       <option value="">Select Driver</option>
                                                       @foreach($drivers as $driver)
                                                       <option value="{{$driver->id}}" @if($order->driver_id==$driver->id) selected @endif>{{$driver->firstname}} {{$driver->lastname}}</option>
                                                       @endforeach
                                                   </select>
                                               </td>
                                               
                                           </tr>
                                           @endforeach
                                           @else
                                           <tr>
                                               <th colspan="5"><center>No Deliveries Found for this date</center></th>
                                           </tr>
                                           @endif
                                       </tbody>
                                    
                                    </table>
                                 </div>
                                 
                              
                             
                          </div>
                       </div>
                    </div>

                    </section>

                   </form>


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
        $('#date').on('change',function(){
            var date1=$(this).val();
            var url="<?php echo admin_url('deliveries')?>/" +date1;
            window.location=url;
        });
    });
</script>
@endsection