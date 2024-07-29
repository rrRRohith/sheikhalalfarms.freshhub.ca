@extends('layouts.admin')
@section('title','Orders')

@section('contents')
<div class="content-container">
   <div class="content-area">
      <div class="row">
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-xs-padding">
            <div class="card no-margin minH">
               <div class="card-block">
                  <div class="card-title">
                     <div class="card-title-header">
                        <div class="card-title-header-titr"><b> Order Details </b></div>
                        <div class="card-title-header-between"></div>
                        <div class="card-title-header-actions">
                           <a href="#"><img src="{{asset('img/help.svg')}}" alt="help"
                              class="card-title-header-img card-title-header-details"></a>
                        </div>
                     </div>
                  </div>
                  @if(isset($orders) && count($orders)>0)
                  @foreach($orders as $order)
                  <div>
                      <div class="text-bold">
                          order &nbsp;{{$order->order_id}}
                      </div>
                      <div>
                          Sales Representive :
                          <br>
                          Order Date :{{date('F d Y',strtotime($order->order_date))}}
                      </div>
                  </div>
                    <br>
                  <div>
                      <div class="text-bold">
                          Buyer Information
                      </div>
                      <div>
                          Customer Name:{{$order->user->firstname}}
                          <br>
                          Email :{{$order->email}}
                          <br>
                          Shipping Address:{{$order->shipping_address}}
                          <br>
                          Billing Address :{{$order->billing_address}}
                      </div>
                  </div>
                  <br>
                  <div>
                      <div class="text-bold">Product</div>
                  </div>
                  <div>
                      
                      <div style="padding-left:100px;padding-right:100px">
                			<table border="0" style="width:100%">
                				<thead>
                					<tr>
                						<th>#</th>
                						<th>PRODUCT/SERVICE</th>
                						<th>Description</th>
                						<!--<th>STOCK</th>-->
                						<th>QTY</th>
                						<th>Rate</th>
                						<th>AMOUNT</th>
                						<th></th>
                					</tr>
                				</thead>
                				<tbody>
                				    @php $i=1;@endphp
                				    @foreach($orderitems as $orderitem)
                					<tr style="text-align:left;">
                						<td>{{$i}}</td>
                						
                						<td>
                						    {{$orderitem->name}}
                						</td>
                						<td>
                							{{$orderitem->description}}
                						</td>
                						<td>
                						   {{$orderitem->quantity}}
                						</td>
                						<td>
                							{{$orderitem->rate}}
                						</td>
                						<td>
                						    {{$orderitem->total}}
                						</td>
                						
                						
                					</tr>
                					<tr class=text-left>
                					    <th>
                    					    Subtotal: &nbsp;{{$orderitem->total}}<br>
                    					    Discount:&nbsp;{{$order->discount}}<br>
                    					    Shipping Tax: &nbsp;{{$order->shipping}}<br>
                    					    Total: &nbsp;{{$order->grand_total}}<br>
                					    </th>
                					</tr>
                					<!--<tr id="r-{{$i}}">-->
                						
                					<!--	<td class="text-center"><span class="order-item">{{$i}}</span></td>-->
                						
                					<!--	<td class="text-center">-->
                					<!--	    <span>{{$orderitem->name}}</span>-->
                						    
                				
                							<!--<input type="text" name="prodservice"/>-->
                					<!--	</td>-->
                						
                					<!--	<td class="text-center">-->
                					<!--	    <span>{{$orderitem->quantity}}</span>-->
                							
                					<!--	</td>-->
                					
                						
                						
                					<!--</tr>-->
                					@php $i++; @endphp
                				   @endforeach
                					<!--<tr>-->
                					<!--    <th colspan="4" style="text-align:right;">Total</th>-->
                					<!--    <th>{{$order->grand_total}}</th>-->
                					<!--</tr>-->
                					<!--<tr>-->
                					<!--    <th colspan="4" style="text-align:right;">Paid Amount</th>-->
                					<!--    <th >{{$order->paid_amount}}</th>-->
                					<!--</tr>-->
                					<!--<tr>-->
                					<!--    <th colspan="4" style="text-align:right;">Due Amount</th>-->
                					<!--    <th>{{$order->grand_total-$order->paid_amount}}</th>-->
                					<!--</tr>-->
                					<!--<tr id="r-0">-->
                					<!--	<td><button class="tickmark"></button></td>-->
                					<!--	<td><span class="order-item">1</span></td>-->
                						
                					<!--	<td>-->
                					<!--	    <input type="text" name="product_name[]" id="product_name-0" onkeyup="newProduct(0);" autocomplete="off">-->
                					<!--	    <input type="hidden" name="product_id[]" id="product_id-0">-->
                					<!--	    <div id="result-div-0" style="display:none;background: darkturquoise;"></div>-->
                				
                							<!--<input type="text" name="prodservice"/>-->
                					<!--	</td>-->
                					<!--	<td>-->
                					<!--		<input type="text" name="description[]" id="description-0"/>-->
                					<!--	</td>-->
                					<!--	<td>-->
                					<!--		<input type="number" name="quantity[]" id="quantity-0" onkeyup="getTotal(1);" required/>-->
                					<!--	</td>-->
                					<!--	<td>-->
                					<!--		<input type="text" name="rate[]" id="rate-0" onkeyup="getTotal(1);"/>-->
                					<!--	</td>-->
                					<!--	<td>-->
                					<!--		<span id="amount-0"></span>-->
                					<!--	</td>-->
                					<!--	<td>-->
                					<!--		<a href=""><button class="delete"></button></a>-->
                					<!--	</td>-->
                					<!--</tr>-->
                					<tr class="last-item-row" ></tr>
                                    <tr><td colspan="8"></td></tr>
                				</tbody>
                			</table>
                		</div>
		
                      
                      
                  </div>
                  @endforeach
                  @endif
                  
                  
                  
                  
                </div>  
            </div>
          </div>
       </div>
    </div>
</div>    

@endsection