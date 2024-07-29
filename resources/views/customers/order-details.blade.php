@extends('layouts.customer')
@section('title','Orders')
@section('page_title','Order Details')
@section('page_nav')

<ul>

    <li class="active"><a href="{{customer_url('orders')}}">All Orders</a></li>

    <li><a  href="{{customer_url('invoices')}}">Invoices</a>

    <li><a  href="{{customer_url('backorders')}}">Backorders</a></li>

</ul>

@endsection
@section('contents')
<div class="content-container">
   <div class="content-area">
      <div class="row main_content">
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card no-margin minH">
               <div class="card-block">
                  
                  @if($order->status < 4)
                  <a href="{{customer_url('order/printorder')}}/{{$order->id}}" class="green_button pull-right" target="_blank">
           
                                                   <i class="fa fa-print" aria-hidden="true"></i>
                                                   Print Order                          
                                                </a>
                   @endif
                  
		
                   <div class="orderdetail_content">

                  <div class="orderdet_salesrep">
                     <h3>
                          Order &nbsp;{{$order->po_number}}
                      </h3>
                      <div>
                         <p> <b> Sales Representive : </b> {{$order->salesrep->firstname}} {{$order->salesrep->lastname}}</p>
                        
                         <p>  Order Date : {{date('F d Y',strtotime($order->order_date))}} </p>
                      </div>
                  </div>
                  
                  <div class="orderdet_buyerinfo">
                      <h3>
                          Buyer Information
                     </h3>
                      <p>
                          Customer Name : {{$order->user->firstname}}</p>
                         
                        <p>  Email : {{$order->email}} </p>
                         
                         <p> Shipping Address : {{$order->delivery->address}} </p>
                         
                         <p> Billing Address : {{$order->billing->address}} </p>
                      </div>
                  
               
                      
                      <div class="orderdetailtable_wrapper">
                          <h3>Product</h3>
                			<table style="width:100%" class="orderdetails_table fh_table">
                				<thead>
                					<tr>
                						<th>#</th>
                						<th>SKU</th>
                						<th>Product</th>
                						<th>Description</th>
                						<th class="text-right">Rate</th>
                						<th class="text-center">Qty</th>
                						<th class="text-center">Weight</th>
                						<th class="text-right">Subtotal</th>
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
                						<td class="text-left">
                							{{$orderitem->product_description}}
                						</td>
                						<td class="text-right">
                							@if($orderitem->price_by=='weight')
                						        {{showPrice(getRate($orderitem->rate))}}
            						        @else
                							    {{showPrice($orderitem->rate)}}
            							    @endif
                						</td>
                						<td class="text-center">
                						   {{$orderitem->quantity}}
                						</td>
                						<td class="text-center">
                						    {{getWeight($orderitem->weight).defWeight()}}
                						    
                						</td>
                						<td class="text-right">
                						    {{showPrice($orderitem->total)}}
                						</td>
                					</tr>
                				   @php $i++; @endphp
                				   @endforeach
   

                				</tbody>
                			</table>
                			 <div class="orderdetail_totaltable">
                			<table class="ordertotaltable" style="width:100%">
                			      <tbody>
                			        <tr>
                			         <th>Subtotal : </th>
                			         <td>{{showPrice($orderitems->sum('total'))}}</td>
                			         </tr>
                			          <tr>
                			         <th>Discount : </th>
                			         <td>{{showPrice($order->discount_amount)}}</td>
                			         </tr>
                			          <tr>
                			         <th> Tax : </th>
                			         <td>{{showPrice($order->tax)}}</td>
                			         </tr>
                			         <tr>
                			         <th> Grand Total : </th>
                			         <td> {{showPrice($order->grand_total)}}</td>
                			         </tr>
                			         
                			  
                					</tbody>
                			</table>
                			</div>
                			
                			
                			
                			
                			
                			
                			
                			
                			
                		</div>
		
                      </div>
                      

                  
                  </div> 
                </div>  
            </div>
          </div>
       </div>
    </div> 

@endsection