@extends('layouts.customer')
@section('title','Orders')
@section('page_title','Orders')
@section('page_nav')
<ul>
    <li class="active"><a href="{{customer_url('orders')}}">All Orders</a></li>
    <li><a  href="{{customer_url('invoices')}}">Invoices</a></li>
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
                   <div class="card-title">
                            <button id="myBtn" class="btn btn-success pull-right main_button"><clr-icon shape="plus-circle"></clr-icon>
                                New order  
                            </button>
                                        
                            <h3>All Orders</h3>
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
                                 
                                 <div class="row">
                                    <div class="col-sm-12">
                                        <div class="filter_form">
                                            <form action="" method="get" id="filter_form">
                                                 @csrf
                                               
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label>Status</label>
                                                            <select name="status" id="status"  class="form-control">
                                                                <option value="">Status</option>
                                                                @foreach($status as $s)
                                                                <option value="{{$s->id}}" @if(isset(Request()->status) && (Request()->status==$s->id)) selected @endif>{{$s->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                          
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label>Select By Date</label>
                                                            <select name="orders"  class="form-control">
                                                                <option value="">All Date</option>
                                                                <option value="1" >Todays orders</option>
                                                                <option value="2">Yesterday orders</option>
                                                                <option value="3" >This Month</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                          
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label>&nbsp;</label><br/>
                                                            <button  class="btn btn-default" type="submit">Filter</button>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                            </form>
                                        </div>
                                        
                                    </div>
                                    
                                 </div>
                                 
                                 
                                 
                                 <div class="table-list-responsive-md">
                                    <table class="table table-customer mt-0">
                                       <form method="post" action="{{customer_url('order/printorder')}}" target="_blank">
                                              @csrf
                                              <thead>
                                              <tr>
                                                  <td colspan="10" style="text-align:right;"><button type="submit" name="submit" class="btn btn-success" value="Print Orders" target="_blank"><i class="fa fa-print" aria-hidden="true"></i> Print Orders</button></td>
                                              </tr>
                                          </thead>
                                       <thead>
                                          <tr>
                                           
                                             <!--<th class="text-left">ID</th>-->
                                             <th class="text-left">#</th>
                                             <th class="text-left"> PO  </th>
                                             <th class="text-left">  Store Name</th>
                                              
                                             <th class="text-center">Ordering Date</th>
                                             <th class="text-center">Delivery Date</th>
                                             <th class="text-right"> Amount </th>
                                             <th class="text-center"> Case Quantity </th>
                                             <th class="text-center">Total weight </th>
                                             <th class="text-left"> Status </th>
                                             <th class="text-right">Actions</th>
                                          </tr>
                                          </thead>
                                         
                                          @if(isset($orders) && count($orders)>0)
                                          
                                          @foreach($orders as $order)
                                          <tr>
                                           
                                             <!--<td class="text-left">{{$order->id}}</td>-->
                                             <td class="text-left"><input type="checkbox" name="id[]" id="id" value="{{$order->id}}"></td>
                                             <td class="text-left"><a href="{{customer_url('orders/orderdetails')}}/{{$order->id}}">PO{{$order->id}}</a></td>
                                              <td class="text-left text-bold"><a href="{{customer_url('customers')}}/{{$order->user_id}}/edit">
                                              
                                                @if($order->business_name !='')
                                                {{$order->business_name }}
                                                @else
                                                {{$order->user->firstname}} {{$order->user->lastname}}
                                                @endif
                                                </a>
                                             </td>
                                              
                                          
                                             <td class="text-center">
                                                {{date('d M y h:ia',strtotime($order->order_date))}}
                                             </td>
                                            <td class="text-center">
                                              {{date('D d M',strtotime($order->shipping_date))}}
                                             </td>
                                              <td class="text-right">
                                               ${{$order->grand_total}}
                                             </td>
                                             
                                             <td class="text-center">
                                                
                                                {{$order->item->sum('quantity')}}
                                             </td>
                                             <td class="text-center">
                                                 @php $total = 0 @endphp
                                                  @foreach($order->item as $itm)
                                                    @php   $total += $itm->product->weight @endphp
                                                 @endforeach
                                                  {{$total}}Lb
                                                 </td>
                                             <td class="text-left">
                                                @foreach($status as $s)
                                                    

                                                    @if($order->status==$s->id)
                                                        @if($order->status == '0')
                                                            <span class="badge bg-secondary">
                                                        @elseif($order->status == '1')
                                                            <span class="badge bg-primary">
                                                        @elseif($order->status == '2')
                                                            <span class="badge bg-dark">
                                                        @elseif($order->status == '3')
                                                            <span class="badge bg-info">
                                                        @elseif($order->status == '4')
                                                            <span class="badge bg-warning">
                                                        @elseif($order->status == '5')
                                                            <span class="badge bg-success">
                                                        @elseif($order->status == '6')
                                                            <span class="badge bg-danger">
                                                        @else
                                                            <span class="badge bg-light">
                                                        @endif
                                                        
                                                        {{$s->name}}
                                                        
                                                        </span>
                                                    @endif
                                                @endforeach
                                             </td>
                                           
                                         
                                             <td class="text-right">
                                                 <div class="fh_actions">
                                                    <a href="#" class="fh_link">Actions <i class="fa fa-caret-down"></i> </a>
                                                    <ul class="fh_dropdown">
                                                        
                                                        <li><a href="{{customer_url('orders/orderdetails')}}/{{$order->id}}">View</a></li>
                                                        
                                                    </ul>
                                                </div> 
                                                 <!--@can('Order Edit')-->
                                                 <!--@if($order->status <= 4)-->
                                                 <!--<select class="action" data-id="{{$order->id}}">-->
                                                 <!--       <option value="">Actions</option>-->
                                                 <!--       @foreach($status as $s)-->
                                                 <!--            @if($order->status <=1)-->
                                                 <!--            @if($order->status < $s->id && $order->status+2 > $s->id)-->
                                                 <!--            <option value="{{$s->id}}">{{$s->action}}</option>-->
                                                 <!--            @endif-->
                                                 <!--            @if($order->status <=1 && $s->id ==6)-->
                                                 <!--            @can('Order Delete')-->
                                                 <!--            <option value="{{$s->id}}">{{$s->action}}</option>-->
                                                 <!--            @endcan-->
                                                 <!--            @endif-->
                                                 <!--            @elseif($order->status==2)-->
                                                 <!--            @if($order->status < $s->id && $order->status+3 >= $s->id && $s->id !=4)-->
                                                 <!--            <option value="{{$s->id}}">{{$s->action}}</option>-->
                                                 <!--            @endif-->
                                                 <!--            @elseif($order->status==3)-->
                                                 <!--            @if($order->status < $s->id && $order->status+2 >= $s->id && $s->id !=4)-->
                                                 <!--            <option value="{{$s->id}}">{{$s->action}}</option>-->
                                                 <!--            @endif-->
                                                 <!--            @elseif($order->status==4)-->
                                                 <!--            @if($order->status < $s->id && $order->status+1 >= $s->id)-->
                                                 <!--            <option value="{{$s->id}}">{{$s->action}}</option>-->
                                                 <!--            @endif-->
                                                 <!--            @endif-->
                                                 <!--        @endforeach-->
                                                        
                                                 <!--   </select>-->
                                                 <!--   @endif-->
                                                 <!--   @endcan-->
                                                 <!--   @can('Order View')-->
                                                 <!--   <a target="" href="{{admin_url('orders/orderdetails')}}/{{$order->id}}" class="icon-table" rel="tooltip" data-tooltip=" View">-->
                                                 <!--     view-->
                                                 <!--   </a>-->
                                                 <!--   @endcan-->
                                                    @can('Compare Order Stock')
                                                    <a target="" href="{{customer_url('orders/approveddetails')}}/{{$order->id}}" class="icon-table" rel="tooltip" data-tooltip=" View">
                                                      View Details
                                                    </a>
                                                    @endcan
                                                    
                                                    
                                                
                                             </td>
                                             
                                          </tr>

                                          @endforeach
                                          
                                          </form>
                                          @else
                                          <tr>
                                              <td colspan="9"><center>No Orders Found !!</center></td>
                                          </tr>
                                          @endif
                                       </thead>
                                       <tbody>
                                         
                                       </tbody>
                                    </table>
                                 </div>
                               
                              </div>
                           </div>
                        </div>
                     </section>
                     <div class="text-bold" style="padding:10px;"> {{$orders->links()}}Showing Page {{$orders->currentPage()}} of {{$orders->lastPage()}} </div>
                  </section>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<div id="myModal" class="modal">
 	<div class="modal-content">
	    <span class="close">&times;</span>
	    <div class="popupform">
	    	<form action="{{customer_url('orders')}}" method="post" name="form1" id="form1">
		    @csrf
				<div class="top-section">
					<div class="headertop">
						<h2>Order No.<span id="order_no">{{$order_no+1}}</span></h2>
						
					</div>
				    <input type="hidden" name="_method" value="POST" id="form-method" />
				    <input type="hidden" name="order_id" value="{{$order_no+1}}" id="order_id">
					<div class="row clearfix">
						<div class="col-md-6">
							<p><label>Billing address</label>
							<textarea name="billing_address" rows="5" cols="35" id="billing_address" required></textarea></p>
						</div>
						<div class="col-md-6">
							<p><label>Shipping To</label>
							<textarea name="shipping_address" rows="5" cols="35" id="shipping_address" required></textarea></p>
						</div>
		
						<div class="col-md-6">
							<p><label>Order Date</label>
							<input type="date" name="order_date" id="order_date" value="{{date('d-m-Y')}}" required/></p>
						</div>
						<div class="col-md-6">
								<p><label>Shipping Date</label>
								<input type="date" name="shipping_date" id="shipping_date" required/></p>
						</div>
					</div>
		
				</div>
				<div class="middlesection">
					<table>
						<thead>
							<tr>
								<th></th>
								<th>#</th>
								
								<th>PRODUCT/SERVICE</th>
								<th>DESCRIPTION</th>
								<th>QTY</th>
								<th width="10%">RATE</th>
								<th width="10%">AMOUNT</th>
								<th></th>
							</tr>
						</thead>
						<tbody id="order-items">
							<tr id="r-0">
								<td><button class="tickmark"></button></td>
								<td><span class="order-item">1</span></td>
								
								<td>
								    <input type="text" name="product_name[]" id="product_name-0" onkeyup="newProduct(0);" autocomplete="off">
								    <input type="hidden" name="product_id[]" id="product_id-0">
								    <div id="result-div-0" style="display:none;background: darkturquoise;"></div>
						
									<!--<input type="text" name="prodservice"/>-->
								</td>
								<td>
									<input type="text" name="description[]" id="description-0"/>
								</td>
								<td>
									<input type="number" name="quantity[]" id="quantity-0" onkeyup="getTotal(1);" required/>
								</td>
								<td>
								    <span id="creditrate-0"></span>
									<input type="hidden" name="rate[]" id="rate-0" onkeyup="getTotal(1);"/>
								</td>
								<td>
									<span id="amount-0"></span>
								</td>
								<td>
									<a href=""><button class="delete" id="delete-0" onclick="deteteRow(0);"></button></a>
								</td>
							</tr>
							<tr class="last-item-row" ></tr>
		                    <tr><td colspan="8"></td></tr>
							
							
						</tbody>
					</table>
				</div>
				<div class="bottomsection">
			    	<div class="row">
						<div class="col-md-6">
							<div class="blfirst" style="display:none">
									<button type="button">Add lines</button>
									<button>Clear All lines</button>
									<button>Add Subtotal</button>
							</div>
							<div class="blsecond">
								<label class="blmsg_label">Message on invoice</label>
									<textarea rows="6" cols="43" name="message" id="message"></textarea>
								
							</div>
						</div>
						<div class="col-md-6">
							<div class="brfirst">
									<p>Sub Total  &nbsp; &nbsp; <span id="subtotal">$0.00</span></p>
									<p>Discount  &nbsp; &nbsp; <select name="discountt" id="discountt" onchange="calculateDiscount();">
		    								<option value="1">Discount Percentage</option>
		    								<option value="2">Discount Amount</option>
		    								
									</select>
									</p>	<p>
									<span style="width:5%;"><input type="text" id="discount_type" name="discount_type" onchange="calculateDiscount();"></span>
									<span id="disc">$0.00</span>
									</p>
									
								
							</div>
							<div class="brsecond">
								<p>Total : <span id="grand">$0.00</span></p>
								<p>Balance Due : <span id="bal">$0.00</span></p>
								
							</div>
							<input type="hidden" id="grand_total" name="grand_total" value="0">
							<input type="hidden" id="subtotal1" name="subtotal1" value="0">
							<input type="hidden" id="discount" name="discount" value="0">
							<input type="hidden" id="id" name="id" value="0">
						</div>
            		</div>
				</div>
				<div class="footerform">	
					 <button type="submit" value="Submit">Save and Send</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!--<div id="myModal" class="modal" style="padding-top: 10px;padding:10px;-->
<!--">-->

  <!-- Modal content -->
<!--  <div class="modal-content">-->
<!--    <span class="close">&times;</span>-->
<!--    <div class="popupform">-->
		
<!--		<div class="headertop">-->
<!--			<h2>Order No.<span id="order_no">{{$order_no+1}}</span></h2>-->
		
<!--		</div>-->
<!--		<form action="{{url('customer/orders')}}" method="POST" name="form1" id="form1">-->
<!--		    @csrf-->
<!--		     <input type="hidden" name="_method" value="POST" id="form-method" />-->
<!--		    <input type="hidden" name="order_id" value="{{$order_no+1}}" id="order_id">-->
<!--			<div class="top-section">-->
			
<!--			<div class="clear"></div>-->
<!--			<div class="col-md-6">-->
<!--				<p><label>Billing address</label>-->
<!--				<textarea name="billing_address" rows="5" cols="35" id="billing_address" required></textarea></p>-->
<!--				<p><label>Shipping To</label>-->
<!--				<textarea name="shipping_address" rows="5" cols="35" id="shipping_address" required></textarea></p>-->
<!--			</div>-->
<!--			<div class="col-md-6 topsectright">-->
<!--				<div class="col-md-6">-->
<!--						<p><label>Order Date</label>-->
<!--						<input type="date" name="order_date" id="order_date"  required/></p>-->
<!--				</div>-->
<!--				<div class="col-md-6">-->
<!--						<p><label>Due Date</label>-->
<!--						<input type="date" name="due_date" id="due_date" required/></p>-->
<!--				</div>-->
<!--				<div class="clear"></div>-->
<!--				<div class="col-md-4">-->
<!--						<p><label>Ship Via</label>-->
<!--						<input type="text" name="shipping_id" id="shipping_id" required/></p>-->
<!--				</div>-->
<!--				<div class="col-md-4">-->
<!--						<p><label>Shipping Date</label>-->
<!--						<input type="date" name="shipping_date" id="shipping_date" required/>-->
<!--				</div>-->
<!--				<div class="col-md-4">-->
<!--						<p><label>Tracking No.</label>-->
<!--						<input type="text" name="tracking_code" id="tracking_code" required/></p>-->
<!--				</div>-->
<!--				<div class="clear"></div>-->
<!--				<div class="col-md-6">-->
<!--						<p><label>P.O Number</label>-->
<!--						<input type="text" name="ponumber" id="ponumber"/></p>-->
<!--				</div>-->
<!--				<div class="col-md-6">-->
<!--						<p><label>Sales Rep</label>-->
<!--						<input type="text" name="salesrep" id="salesrep"/></p>-->
<!--				</div>-->
<!--				<div class="clear"></div>-->
		
<!--			</div>-->
<!--			<div class="clear"></div>-->
<!--		</div>-->
<!--		<div class="middlesection">-->
<!--			<table>-->
<!--				<thead>-->
<!--					<tr>-->
<!--						<th></th>-->
<!--						<th>#</th>-->
						
<!--						<th>PRODUCT/SERVICE</th>-->
<!--						<th>DESCRIPTION</th>-->
<!--						<th>QTY</th>-->
<!--						<th>AMOUNT</th>-->
<!--						<th>SALES TAX</th>-->
<!--						<th></th>-->
<!--					</tr>-->
<!--				</thead>-->
<!--				<tbody>-->
<!--					<tr>-->
<!--						<td><button class="tickmark"></button></td>-->
<!--						<td>1</td>-->
						
<!--						<td>-->
<!--						    <select name="product_id[]" id="product_id1" required>-->
<!--    				        <option value="" disabled selected>Select a Product</option>-->
<!--    				        @foreach($products as $product)-->
<!--    				        <option value="{{$product->id}}">{{$product->name}}</option>-->
<!--    			            @endforeach-->
<!--				            </select>-->
				
							<!--<input type="text" name="prodservice"/>-->
<!--						</td>-->
<!--						<td>-->
<!--							<input type="text" name="description[]" id="description1"/>-->
<!--						</td>-->
<!--						<td>-->
<!--							<input type="number" name="quantity[]" id="quantity1" onkeyup="getTotal(1);" required/>-->
<!--						</td>-->
<!--						<td>-->
<!--							<input type="text" name="rate[]" id="rate1" onkeyup="getTotal(1);"/>-->
<!--						</td>-->
<!--						<td>-->
<!--							<input type="number" name="tax[]" id="tax1" onkeyup="getTotal(1);"/>-->
<!--						</td>-->
<!--						<td>-->
<!--							<button class="delete"></button>-->
<!--						</td>-->
<!--					</tr>-->
<!--					<tr>-->
<!--						<td><button class="tickmark"></button></td>-->
<!--						<td>2</td>-->
						
<!--						<td>-->
<!--						    <select name="product_id[]" id="product_id2">-->
<!--    				        <option value="" disabled selected>Select a Product</option>-->
<!--    				        @foreach($products as $product)-->
<!--    				        <option value="{{$product->id}}">{{$product->name}}</option>-->
<!--    			            @endforeach-->
<!--				            </select>-->
				
							<!--<input type="text" name="prodservice"/>-->
<!--						</td>-->
<!--						<td>-->
<!--							<input type="text" name="description2" id="description2"/>-->
<!--						</td>-->
<!--						<td>-->
<!--							<input type="number" name="quantity[]" id="quantity2" onkeyup="getTotal(2);"/>-->
<!--						</td>-->
<!--						<td>-->
<!--							<input type="text" name="rate[]" id="rate2" onkeyup="getTotal(2);"/>-->
<!--						</td>-->
<!--						<td>-->
<!--							<input type="number" name="tax[]" id="tax2" onkeyup="getTotal(2);"/>-->
<!--						</td>-->
<!--						<td>-->
<!--							<button class="delete"></button>-->
<!--						</td>-->
<!--					</tr>-->
<!--					<tr>-->
<!--						<td><button class="tickmark"></button></td>-->
<!--						<td>3</td>-->
						
<!--						<td>-->
<!--						    <select name="product_id[]" id="product_id3">-->
<!--    				        <option value="" disabled selected>Select a Product</option>-->
<!--    				        @foreach($products as $product)-->
<!--    				        <option value="{{$product->id}}">{{$product->name}}</option>-->
<!--    			            @endforeach-->
<!--				            </select>-->
				
							<!--<input type="text" name="prodservice"/>-->
<!--						</td>-->
<!--						<td>-->
<!--							<input type="text" name="description[]" id="description3"/>-->
<!--						</td>-->
<!--						<td>-->
<!--							<input type="number" name="quantity[]" id="quantity3" onkeyup="getTotal(3);"/>-->
<!--						</td>-->
<!--						<td>-->
<!--							<input type="text" name="rate[]" id="rate3" onkeyup="getTotal(3);"/>-->
<!--						</td>-->
<!--						<td>-->
<!--							<input type="number" name="tax[]" id="tax3" onkeyup="getTotal(3);"/>-->
<!--						</td>-->
<!--						<td>-->
<!--							<button class="delete"></button>-->
<!--						</td>-->
<!--					</tr>-->
				
<!--				</tbody>-->
<!--			</table>-->
<!--		</div>-->
<!--			<div class="bottomsection">-->
<!--				<div class="bottomleft">-->
<!--					<div class="blfirst">-->
<!--							<button>Add lines</button>-->
<!--							<button>Clear All lines</button>-->
<!--							<button>Add Subtotal</button>-->
<!--					</div>-->
<!--					<div class="blsecond">-->
<!--						<label>Message on invoice</label>-->
<!--							<textarea rows="6" cols="43" name="message" id="message"></textarea>-->
						
<!--					</div>-->
<!--				</div>-->
<!--				<div class="bottomright">-->
<!--					<div class="brfirst">-->
<!--							<p>Sub Total<span id="subtotal">$0.00</span></p>-->
<!--							<p><select name="discount_type" id="discount_type">-->
<!--    								<option value="" disabled selected>Discount Percent</option>-->
<!--    								<option value="5">5%</option>-->
<!--    								<option value="10">10%</option>-->
<!--							</select>-->
							
<!--							<span id="disc">$0.00</span>-->
<!--							</p>-->
<!--							<p> Shipping-->
<!--							<select id="shipping" name="shipping" id="shipping">-->
<!--    								<option value="" disabled selected>Select shipping tax</option>-->
<!--    								<option value="5%">5%</option>-->
<!--    								<option value="10%">10%</option>-->
<!--							</select>-->
<!--							<span class="sptax"><input type="text"  name="tax1" id="taxx" value="0"/></span>-->
<!--							</p>-->
						
<!--					</div>-->
<!--					<div class="brsecond">-->
<!--						<p>Total: <span id="grand">$0.00</span></p>-->
<!--						<p>Balance Due: <span id="bal">$0.00</span></p>-->
						
<!--					</div>-->
<!--					<input type="hidden" id="grand_total" name="grand_total" value="0">-->
<!--					<input type="hidden" id="subtotal1" name="subtotal1" value="0">-->
<!--					<input type="hidden" id="discount" name="discount" value="0">-->
<!--				</div>-->
<!--				<div class="clear"></div>-->

<!--			</div>-->
<!--			<div class="footerform">	-->
<!--				 <button type="submit" value="Submit">Save and Send</button>-->
<!--			</div>-->
<!--		</form>-->
<!--	</div>-->
<!--	</div>-->
<!--	</div>-->
<script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js" ></script>
<script>
$(document).ready(function() {
   
    // $('#product_id1').change(function(){
    //     var prodid=$(this).val();
    //     if(prodid)
    //     {
    //         $.ajax({
    //             url:"{{customer_url('orders/getdetails')}}/"+prodid,
    //             type:"GET",
    //             dataType:"json",
    //             success:function(data)
    //             {
    //                 $.each(data,function(key,value)
    //                 {
    //                     var rate=value.price;
                        
    //                     $('#rate1').val(rate);
    //                     $('#description1').val(value.description);
    //                 });
    //             }
    //         });
    //     }
    // });
    // $('#product_id2').change(function(){
    //     var prodid=$(this).val();
    //     if(prodid)
    //     {
    //         $.ajax({
    //             url:"{{customer_url('orders/getdetails')}}/"+prodid,
    //             type:"GET",
    //             dataType:"json",
    //             success:function(data)
    //             {
    //                 //alert(data);
    //                 $.each(data,function(key,value)
    //                 {
    //                     var rate=value.price;
                        
    //                     $('#rate2').val(rate);
    //                     $('#description2').val(value.description);
    //                     //$('#quantity').max(value.qty);
    //                 });
    //             }
    //         });
    //     }
    //     //alert(prodid);
    // });
    //  $('#product_id3').change(function(){
    //     var prodid=$(this).val();
    //     if(prodid)
    //     {
    //         $.ajax({
    //             url:"{{customer_url('orders/getdetails')}}/"+prodid,
    //             type:"GET",
    //             dataType:"json",
    //             success:function(data)
    //             {
    //                 //alert(data);
    //                 $.each(data,function(key,value)
    //                 {
    //                     var rate=value.price;
                        
    //                     $('#rate3').val(rate);
    //                     $('#description3').val(value.description);
    //                     //$('#quantity').max(value.qty);
    //                 });
    //             }
    //         });
    //     }
    //     //alert(prodid);
    // });
    
     $('#discount_type').change(function(){
        var discid=$(this).val();
        alert(discid);
        var subtotal=$('#subtotal1').val();
        if(discid)
        {
           var discount=subtotal*(discid/100);
           $('#disc').html(discount.toFixed(2));
           $('#discount').val(discount.toFixed(2));
           var tax=$('#taxx').val() ?? 0;
   var dis=$('#discount').val();
   
   var g=Number(subtotal)+Number(tax)-Number(dis);
   
   $('#grand').html(g.toFixed(2));
   $('#grand_total').val(g.toFixed(2));
   $('#bal').html(g.toFixed(2));
        }
        
        
    });
     $('.edit_modal').click(function(){
        var tour_id= $(this).val();
        var url="{{customer_url('orders')}}/"+tour_id+"/edit";
          $.ajax({
                url:url,
                type:"GET",
                dataType:"json",
                success:function(data)
                {
                    $.each(data,function(key,value)
                    {
                        $('#email').val(value.email);
                        $('#user_id').val(value.user_id);
                        $('#billing_address').val(value.billing_address);
                        $('#shipping_address').val(value.shipping_address);
                        //$('#shipping_address').val(value.shipping_address);
                        //$('#order_date').val(value.order_date);
                        
                        $('#shipping_id').val(value.shipping_id);
                        $('#tracking_code').val(value.tracking_code);
                        $('#message').val(value.message);
                        $('#grand_total').val(value.grand_total);
                        $('#grand').html(value.grand_total);
                        $('#bal').html(value.grand_total-value.paid_amount);
                        $('#discount_type').val(value.discount_type);
                         $('#discount').val(value.discount);
                        $('#disc').html(value.discount);
                        $('#shipping').val(value.shipping);
                        $('#taxx').val(value.tax);
                        $('#order_no').html(value.order_id);
                        $('#order_id').val(value.order_id);
                        var isoFormatDateString = value.order_date;
                        // var isoFormatDateString1 = value.due_date;
                        var isoFormatDateString2 = value.shipping_date;
                        var dateParts = isoFormatDateString.split(" ");
                        // var dateParts1 = isoFormatDateString1.split(" ");
                        var dateParts2 = isoFormatDateString2.split(" ");
                        $('#order_date').val(dateParts[0]);
                        // $('#due_date').val(dateParts1[0]);
                        $('#shipping_date').val(dateParts2[0]);
                        // alert(value.due_date);
                        var id=$('#id').val();
                        for(var i=1;i<=id;i++)
                        {
                            deteteRow(i);
                        }
                        $('#id').val(0);
                        $('#myModal').css('display', 'block');
                   
                
                    });
                }
            });
            var url1="{{customer_url('orders')}}/"+tour_id+"/getpr";
          $.ajax({
                url:url1,
                type:"GET",
                dataType:"json",
                success:function(data)
                {
                    console.log(data);
                    var i=0;
                    var subt=0;
                    var len=data.length;
                    
                    if(Number(len)>1)
                    {
                        
                        for(var j=0;j<len;j++)
                        {
                            addBlankRow(j);
                        }
                    }
                    else
                    {
                         addBlankRow(0);
                    }
                    $.each(data,function(key,value)
                    {
                        
                       $('#product_name-'+i).val(value.name);    
                       $('#product_id-'+i).val(value.product_id);
                       $('#quantity-'+i).val(value.quantity);
                       $('#creditrate-'+i).html(value.rate);
                       $('#rate-'+i).val(value.rate);
                       $('#tax-'+i).val(value.tax);
                       $('#description-'+i).val(value.description);
                       $('#amount-'+i).html((Number(value.quantity)*Number(value.rate)).toFixed(2));
                       subt=subt+(Number(value.quantity)*Number(value.rate));
                       i++;
                    });
                    $('#subtotal1').val(subt.toFixed(2));
                    $('#subtotal').html(subt.toFixed(2));
                    
                }
            });
            var url2="{{customer_url('orders')}}/"+tour_id;
            
            $('#form1').attr('action', url2); //this fails silently
            $("#form-method").val('PUT');
        
        
    });
   
    $('#myBtn').click(function(){
                        $('#email').val("");
                        $('#user_id').val("");
                        $('#billing_address').val("{{$customer->address}}");
                        $('#shipping_address').val("{{$customer->address}}");
                       
                        
                        $('#shipping_id').val("");
                        $('#tracking_code').val("");
                        $('#message').val("");
                        $('#grand_total').val(0);
                        $('#grand').html("$0.00");
                        $('#bal').html("$0.00");
                        $('#discount_type').val("");
                         $('#discount').val("");
                        $('#disc').html("$0.00");
                        $('#shipping').val("");
                        $('#taxx').val("");
                        $('#order_no').html({{$order_no+1}});
                        $('#order_id').val({{$order_no+1}});
                        
                        var dateParts = new Date();
                        var dateParts1 = new Date();
                        var dateParts2 = new Date();
                        $('#order_date').val(dateParts);
                        $('#due_date').val(dateParts1);
                        $('#shipping_date').val(dateParts2);
                        for(var i=1;i<=3;i++)
                        {
                       $('#product_id'+i).val("");
                       $('#quantity'+i).val("");
                       $('#rate'+i).val("");
                       $('#tax'+i).val("");
                       $('#description'+i).val("");
                        }
                        $('#subtotal1').val(0);
                    $('#subtotal').html("$0.00");
                    var url2="{{customer_url('orders')}}";
                    $('#form1').attr('action', url2); //this fails silently
            $("#form-method").val('post');
   $('#myModal').css('display', 'block');
});
$('.close').click(function(){
   $('#myModal').css('display', 'none');
});
});
function getTotal(j)
{
    var s=0;
    var t=0;
    var id=parseInt($('#id').val());
    for(var i=0;i<id;i++)
    {
     if($('#product_id-'+i).val() !=null)
      {
        var rate=$('#rate-'+i).val();
        var quantity=$('#quantity-'+i).val();
        var subtotal=Number(rate*quantity);
        var s= s+subtotal;
        $('#amount-'+i).html(subtotal.toFixed(2));
      }
    }
   $('#subtotal1').val(s.toFixed(2));
   $('#subtotal').html(s.toFixed(2));
   var sub=$('#subtotal1').val();
   if($('#discount_type').val() !=null)
   {
   var d=sub*(($('#discount_type').val())/100);
   $('#disc').html(d.toFixed(2));
   $('#discount').val(d.toFixed(2));
   }
   var sub=$('#subtotal1').val();
   
//   var tax=$('#taxx').val();
     var tax=0;
   var dis=$('#discount').val();
   if($('#shipping').val() !=null)
  {
      var discvalue=sub-dis;
  }
   
   var g=Number(sub)+Number(tax)-Number(dis);
   
   $('#grand').html(g.toFixed(2));
   $('#grand_total').val(g.toFixed(2));
   $('#bal').html(g.toFixed(2));
}
function newProduct(i)
{
     var prodid=$('#product_name-'+i).val();
     searchProduct(prodid,i);
}
function searchProduct(i,id)
{
    $.ajax({
                url:"{{admin_url('orders/getdetails1')}}/"+i,
                type:"GET",
                dataType:"json",
                success:function(data)
                {
                    
                    var dropdown = '<ul id="products-list">';
                    $.each(data,function(key,value)
                    {
                        
                        // dropdown+= '<li onclick="selectproduct('+value.id+','+id+');">'+value.name+'<li>';
                        dropdown+= '<li><a href="#" class="productRow" data-id="'+value.id+'" data-name="'+value.name+'" data-description="'+value.description+'" data-price="'+value.price+'" data-rowid="'+id+'">'+value.name+'</a><li>';
                        // var rate=value.price;
                        
                        // $('#rate-0').val(rate);
                        // $('#description-0').val(value.description);
                       
                    });
                    
                    dropdown+= '</ul>';
                    
                    $("#result-div-"+id).html(dropdown);
                    $("#result-div-"+id).css("display","block");
                    
                    
                    
                },
                error:function()
                {
                $("#result-div-"+id).css("display","none");
                }
            });
}
function addBlankRow(i)
{
    var id=parseInt($('#id').val())+1;
    if(id < Number(i)+2)
    {
        $('#id').val(id);
        var i=Number(id)+1;
        var data ='<tr id="r-'+id+'"><td><button class="tickmark"></button></td><td><span class="order-item">'+i+'</span></td><td><input type="text" name="product_name[]" id="product_name-'+id+'" onkeyup="newProduct('+id+');"><input type="hidden" name="product_id[]" id="product_id-'+id+'"><div id="result-div-'+id+'" style="display:none;background: darkturquoise;"></div></td><td><input type="text" name="description[]" id="description-'+id+'"/></td><td><input type="number" name="quantity[]" id="quantity-'+id+'" onkeyup="getTotal(1);"/></td><td><span id="creditrate-'+id+'"></span><input type="hidden" name="rate[]" id="rate-'+id+'" onkeyup="getTotal(1);"/></td><td><span id="amount-'+id+'"></span></td><td><button class="delete" id="delete-'+id+'" onclick="deteteRow('+id+');"></button></td></tr>';
       
       $('tr.last-item-row').before(data);
    }
    
}
$("body").delegate(".productRow","click",function(){
    var i=$(this).attr("data-rowid");
    $("#product_name-"+i).val($(this).attr("data-name"));
    $("#product_id-"+i).val($(this).attr("data-id"));
    $("#rate-"+i).val($(this).attr("data-price"));
    $("#quantity-"+i).val(1);
    $("#description-"+i).val($(this).attr("data-description"));
    $("#creditrate-"+i).html($(this).attr("data-price"));
    $("#amount-"+i).html($(this).attr("data-price"));
    $("#result-div-"+i).css("display","none");
    
    addBlankRow(i);
    getTotal();
})
function deteteRow(i)
{
      $('#r-'+i).remove(); 
      regenerateRows();
      getTotal();

}
function regenerateRows(){
       var rowCounter = 1;
       $("#order-items tr").each(function() {
            $(this).find("span.order-item").text(rowCounter);
            rowCounter++;
       });
   }
</script>
@endsection