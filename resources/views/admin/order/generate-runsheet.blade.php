@extends('layouts.admin')
@section('title','Generate Runsheet')
@section('page_title','Deliveres')
@section('page_nav')
<ul>
    <li><a href="{{admin_url('runsheets')}}">Runsheets</a></li>
    <li class="active"><a href="{{admin_url('getrunsheet')}}">Generate Runsheet</a></li>
</ul>
@endsection
@section('contents')
<div class="content-container">
   <div class="content-area">
      <div class="row main_content">
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-xs-padding addnew_form">
            <div class="card no-margin minH">
               <div class="card-block">
                    <div class="card-title">
                    <a href="{{admin_url('runsheets')}}" class="pull-right white_button"> 
                      <i class="fa fa-arrow-left" aria-hidden="true"></i> All Runsheets</a>
                    <h3>Generate Runsheet</h3>
                  </div>
                  <section class="card-text">

                    <div class="row">
                        <div class="col-md-6 offset-md-3 " id="addAccountForm">

                          <form action="" method="GET" class="box">   
                            <h4>Get the orders for runsheet</h4>

                             <div class="row">
                                 <div class="col-sm-5">
                                    <label>Driver Name</label><br>
                                    <select name="driver"  class="form-control">
                                        <option value="">Select Driver</option>
                                        @foreach($drivers as $driver)
                                        <option value="{{$driver->id}}" @if(Request()->driver==$driver->id) selected @endif>{{$driver->firstname}} &nbsp;{{$driver->lastname}}</option>
                                        @endforeach
                                    </select>
                                 </div>
                                 
                                 <div class="col-sm-4">
                                    <label>Delivery Date</label><br>
                                    <input type="date" name="date" class="form-control" value="{{request()->date}}">
                                 </div>

                                 <div class="col-sm-3">
                             

                                     <button type="submit" class="white_button">Get Orders</button>
                                 </div>
                             </div>
                            
                          </form>

                            
                         </div>
                    </div>

                  </section>



                    @if(isset($orders) && count($orders)>0)

                  <section class="card-text">


                    <h4>Select the orders for Runsheet</h4>

                     <div class="row filter-customer">
                       <div class="col-lg-12">
                          <div class="filter-customer-list">
                            @if (Session::has('message'))
                             <div class="alert alert-success">
                                <font color="red" size="4px">{{ Session::get('message') }}</font>
                             </div>
                            @endif
                            
                            
                            <form action="{{admin_url('runsheets/generate/submit')}}" method="post">
                                @csrf
                                <input type="hidden" name="date" value="{{Request()->date}}">
                                <input type="hidden" name="driver" value="{{Request()->driver}}">
                                <div class="table-list-responsive-md">
                                    <table class="table table-customer mt-0">
                                       <thead>
                                          <tr>
                                             <th></th>
                                             <th>PO No.</th>
                                             <th class="text-left">Invoice No.</th>
                                             <th class="text-left">Store</th>
                                             <th>Person</th>
                                             <th class="text-left">Address</th>
                                             <th class="text-left">Phone</th>
                                             <th class="text-center">Case/Qty</th>
                                             <th class="text-left">Invoice</th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                           @foreach($orders as $order)
                                           <tr>
                                               <td>
                                                  <input type="checkbox" name="orders[]" value="{{$order->id}}">
                                               </td>
                                               <td>
                                                   {{$order->id}}
                                               </td>
                                               <td>
                                                   {{$order->invoice->id}}
                                               </td>
                                               <td>
                                                  <span style="text-transform:uppercase;">{{$order->user->business_name ?? '-'}}</span>
                                               </td>
                                               <td>
                                                 {{$order->user->firstname}} {{$order->user->lastname}}
                                               </td>
                                               <td>
                                                  <a href="https://www.google.com/maps/place/{{urlencode($order->shipping_address)}}" target="_blank"><i class="fa fa-map-marker"></i> {{$order->shipping_address}}</a>
                                               </td>
                                               <td>
                                                   <i class="fa fa-phone"></i> {{$order->user->phone}}
                                               </td>
                                               <td class="text-center">
                                                  {{$order->item->sum('quantity')}}
                                               </td>
                                               <td class="text-right">
                                                  {{'$'.number_format($order->invoice->grand_total,2)}}
                                               </td>
                                           </tr>
                                           @endforeach
                                       </tbody>
                                    
                                    </table>
                                 </div>
                                 <div class="row">
                                     <div class="col-sm-3"><input type="text" class="form-control" name="city" placeholder="Enter city" /> </div>
                                     <div class="col-sm-3"><input type="text" class="form-control" name="route" placeholder="Enter Route" /> </div>
                                     <div class="col-sm-3">
                                         <button type="submit" class="green_button"><i class="fa fa-bolt"></i> Generate Runsheet</button>
                                     </div>
                                 </div>
                              </form>
                             
                          </div>
                       </div>
                    </div>

                    </section>

                    @elseif(request()->date != '') 

                      <section class="card-text">

                        <p class="text-center text-danger"><strong>No delivery is found for this driver & date</strong></p>


                      </section>


                    @endif
                 
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

@endsection