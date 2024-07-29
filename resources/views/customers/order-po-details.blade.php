@extends('layouts.customer')
@section('title','Orders')
@section('page_title','Order Details #'.$order->po_number)
@section('page_nav')
<ul>
    <li class="active"><a href="{{customer_url('orders')}}">All Orders</a></li>
    <li><a  href="{{customer_url('invoices')}}">Invoices</a>
    <li><a href="{{customer_url('backorders')}}">Backorders</a></li>
</ul>
@endsection
@section('contents')
<div class="content-container">
   <div class="content-area">
      <div class="row main_content">
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding">
            <div class="card no-margin minH">
               <div class="card-block">
                  
                  <a href="{{customer_url('order/printorder')}}/{{$order->id}}" class="green_button pull-right" target="_blank"> <i class="fa fa-print"></i> Print Order</a>
                 
                  <div class="orderdetail_content">
                      
                  <div class="row">
                      
                      <div class="col-sm-6">
                            <section>
                              <h5>Customer Information</h5>
                              <p>Name : {{$order->user->firstname}}</p>
                              <p>  Email : {{$order->email}} </p>
                              <p> Shipping Address : {{$order->delivery->address ?? ''}} </p>
                              <p> Billing Address : {{$order->billing->address ?? ''}} </p>
                           </section>
                      </div>
                      <div class="col-sm-6">
                          <section>
                             <h5> Order details: {{$order->po_number}}</h5>
                              <div>
                                 <p>Sales Representive : {{$order->salesrep->firstname}} {{$order->salesrep->lastname}}</p>
                                 <p>Order Date:{{date('F d Y',strtotime($order->order_date))}} </p>
                                 <p>Delivery Date:{{date('F d Y',strtotime($order->shipping_date))}} </p>
                                 <p>Driver: {{$order->driver->firstname??''}}</p>
                              </div>
                          </section>
                      </div>
                      
                  </div>
                  <hr/>
                   <div class="row">
                      
                      <div class="col-sm-12"> 

                          <section>
                              <h5>Order Items</h5>
                        			<table style="width:100%" class="orderdetails_table">
                        				<thead>
                        					<tr>
                        						<th>#</th>
                        						<th>SKU</th>
                        						<th>Product</th>
                        						<th>Description</th>
                        						<th class="text-center">Qty</th>
                        					</tr>
                        				</thead>
                        				<tbody>
                        				    @php $i=1;@endphp
                        				    @foreach($orderitems as $orderitem)
                        					<tr style="text-align:left;">
                        						<td>{{$i}}</td>
                        						<td>
                        						    {{$orderitem->product_sku}}
                        						</td>
                        						<td>
                        						    {{$orderitem->product_name}}
                        						</td>
                        						<td>
                        							{{$orderitem->product_description}}
                        						</td>
                        						<td class="text-center">
                        						   {{$orderitem->quantity}}
                        						</td>
        	
                        					</tr>
                        				
                        					@php $i++; @endphp
                        				   @endforeach
                        					
                        					
                        				</tbody>
                        			</table>
                        		</section>
                        	</div>
                        </div><!-- end of row //-->
                  
                  </div> 
                </div>  
            </div>
          </div>
       </div>
    </div>
</div>    

@endsection