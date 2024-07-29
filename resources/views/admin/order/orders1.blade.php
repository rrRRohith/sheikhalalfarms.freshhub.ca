@extends('layouts.admin')
@section('title','Orders')
@section('page_title','Orders')
@section('page_nav')
<ul>
    <li class="active"><a href="{{admin_url('orders')}}">All Orders</a></li>
    <li><a  href="{{admin_url('invoices')}}">Invoices</a>
    <li><a  href="{{admin_url('backorders')}}">Backorders</a></li>
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
                    @can('Order Create')
                        <button id="new-order" class="green_button pull-right">
                            <clr-icon shape="plus-circle"></clr-icon> New order 
                        </button>
                    @endcan
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
                                                <div class="row clearfix">
                                                    <div class="col-sm-4 col-lg-4">
                                                        <div class="form-group">
                                                            <label>Search</label>
                                                            <input type="text"  name="search"  value="{{Request()->search}}" class="form-control" />
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4 col-lg-3">
                                                        <div class="form-group">
                                                            <label>Status</label>
                                                            <select name="status" id="status"  class="form-control">
                                                                <option value="">All</option>
                                                                @foreach($status as $s)
                                                                <option value="{{$s->id}}" @if(isset(Request()->status) && (Request()->status==$s->id)) selected @endif>{{$s->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4 col-lg-3">
                                                        <div class="form-group">
                                                            <label>Select By Date</label>
                                                            <select name="orders"  class="form-control">
                                                                <option value="">All</option>
                                                                <option value="1" >Todays orders</option>
                                                                <option value="2">Yesterday orders</option>
                                                                <option value="3" >This Month</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-lg-2">
                                                        <div class="form-group">
                                                            
                                                            <button  class="btn white_button" type="submit">Filter</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>    
                                    </div>                                   
                                 </div>
                                 <div class="table-list-responsive-md">
                                     <form method="post" action="{{admin_url('order/printorder')}}" target="_blank" id="print_form">
                                              @csrf
                                    <table class="table table-customer mt-0">
                                       <thead>
                                          <tr>
                                             <th class="text-left">#</th>
                                             <th class="text-left"> #PO/Invoice </th>
                                             <th class="text-left">  Store Name</th>
                                             <th class="text-center">Ordering Date</th>
                                             <th class="text-center">Delivery Date</th>
                                             <th class="text-center"> Case Quantity </th>
                                             <th class="text-center">Total weight </th>
                                              <th class="text-right"> Amount </th>
                                             <th class="text-center"> Status </th>
                                             <th class="text-right">Actions</th>
                                          </tr>
                                          </thead>
                                          @if(isset($orders) && count($orders)>0)
                                          @foreach($orders as $order)
                                          <tr>
                                             <!--<td class="text-left">{{$order->id}}</td>-->
                                             <td class="text-left"><input type="checkbox" name="id[]" id="id-{{$order->id}}" value="{{$order->id}}" @if($order->status >= 4) disabled @endif class="print_check"></td>
                                             <td class="text-left">
                                                 @if($order->status > 3 && $order->invoice->id != '')
                                                 <a href="{{admin_url('orders/'.$order->invoice->id.'/generateinvoice')}}">
                                                 {{$order->invoice->invoice_number}}</a>
                                                 @else
                                                 <a href="{{admin_url('orders/orderdetails')}}/{{$order->id}}">
                                                 PO{{$order->id}}</a>
                                                 @endif
                                            </td>
                                              <td class="text-left text-bold"><a href="{{admin_url('customers')}}/{{$order->user_id}}/edit">
                                                @if($order->business_name !='')
                                                {{$order->business_name }}
                                                @else
                                                {{$order->user->firstname . ' ' . $order->user->lastname}}
                                                @endif
                                                </a>
                                             </td> 
                                             <td class="text-center">
                                                {{date('d M y h:ia',strtotime($order->order_date))}}
                                            </td>
                                            <td class="text-center">
                                                @if(strtotime($order->shipping_date) < time())
                                                    <span class="text-danger">{{date('D d M',strtotime($order->shipping_date))}}</span>
                                                @else
                                                    {{date('D d M',strtotime($order->shipping_date))}}
                                                @endif
                                            </td>
                                             <td class="text-center">
                                                {{$order->item->sum('quantity')}}
                                             </td>
                                             <td class="text-center">
                                                  @if($order->status > 3)
                                                    {{$order->item->sum('weight').defWeight()}}
                                                  @else
                                                    -
                                                  @endif
                                             </td>
                                             <td class="text-right">
                                                @if($order->status > 3)
                                                    {{showPrice($order->grand_total)}}
                                                @else
                                                    -
                                                @endif
                                             </td>
                                             <td class="text-center">
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
                                                     <ul class="fh_dropdown text-left">
                                                        @if($order->status === 1) <!-- New Order //-->
                                                            <a href="#" onClick="changeStatus({{$order->id}},2)"><li>Accept Order</li></a>
                                                            <a href="#" onClick="changeStatus({{$order->id}},-1)"><li>Cancel Order</li></a>
                                                        @elseif($order->status === 2) <!-- Accepted Order //-->
                                                            <a href="#"><li>Print Order</li></a>
                                                            <a href="#" class="process-order" data-id="{{$order->id}}"><li>Process Order</li></a>
                                                            <a href="#" onClick="changeStatus({{$order->id}},-1)"><li>Cancel Order</li></a>
                                                        @elseif($order->status === 3) <!-- Processing //-->
                                                            <a href="#" class="process-order" data-id="{{$order->id}}"><li>Process Order</li></a>
                                                            <a href="#"><li>Print Order</li></a>
                                                            <a href="#" onClick="changeStatus({{$order->id}},-1)"><li>Cancel Order</li></a>
                                                        @elseif($order->status === 4) <!-- Ready //-->
                                                            <a href="#"><li>Print Order</li></a>
                                                            <a href="#" onClick="changeStatus({{$order->id}},-1)"><li>Cancel Order</li></a>
                                                        @elseif($order->status === 5)  <!-- Dispatching //-->
                                                            <a href="#" onClick="changeStatus({{$order->id}},6)"><li>Mark Delivered</li></a>
                                                            <a href="#"><li>Print Order</li></a>
                                                            <a href="#" onClick="changeStatus({{$order->id}},-1)"><li>Cancel Order</li></a>
                                                        @elseif($order->status === 6)  <!-- Delivered //-->
                                                            <a href="#"><li>Print Order</li></a>
                                                            <a href="#" onClick="changeStatus({{$order->id}},-1)"><li>Cancel Order</li></a>
                                                        @endif
                                                        <a href="{{admin_url('orders/orderdetails')}}/{{$order->id}}"><li>View</li></a>
                                                    </ul>
                                                    <ul class="fh_dropdownwe" style="display:none;">
                                                        @if($order->status === 0)
                                                        <li><a href="#" onClick="changeStatus({{$order->id}},1)">Accept Order</a></li>
                                                        @endif
                                                        @if($order->status <= 4)
                                                            @foreach($status as $s)
                                                                @if($order->status <=1)
                                                                    @if($order->status < $s->id && $order->status+2 > $s->id)
                                                                        <li class="action" data-value="{{$s->id}}" data-id="{{$order->id}}">
                                                                            <a class="order-action process-order"  data-id="{{$order->id}}">{{$s->action}}</a>
                                                                        </li>
                                                                    @endif
                                                                    @if($order->status <=1 && $s->id ==6)
                                                                        @can('Order Delete')
                                                                            <li class="action" data-id="{{$order->id}}" data-value="{{$s->id}}"><a>{{$s->action}}</a></li>
                                                                        @endcan
                                                                    @endif
                                                                @elseif($order->status==2)
                                                                    @if($order->status < $s->id && $order->status+1 >= $s->id && $s->id !=4)
                                                                    @foreach($drivers as $driver)
                                                                        <li class="action1" data-value="{{$driver->id}}" data-id="{{$order->id}}"><a>Assign to {{$driver->firstname}} {{$driver->lastname}}</a></li>
                                                                    @endforeach
                                                                    @endif
                                                                    @if($order->status+1 < $s->id && $order->status+3 >= $s->id && $s->id !=4)
                                                                        <li class="action" data-value="{{$s->id}}" data-id="{{$order->id}}"><a>{{$s->action}}</a></li>
                                                                    @endif
                                                                @elseif($order->status==3)
                                                                    @if($order->status < $s->id && $order->status+2 >= $s->id && $s->id !=4)
                                                                        <li class="action" data-value="{{$s->id}}" data-id="{{$order->id}}"><a>{{$s->action}}</a></li>
                                                                    @endif
                                                                @elseif($order->status==4)
                                                                    @if($order->status < $s->id && $order->status+1 >= $s->id)
                                                                        <li class="action" data-value="{{$s->id}}" data-id="{{$order->id}}"><a>{{$s->action}}</a></li>
                                                                    @endif
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                        <li><a href="{{admin_url('orders/orderdetails')}}/{{$order->id}}">View</a></li>
                                                        @can('Compare Order Stock')
                                                        <li><a href="{{admin_url('orders/approveddetails')}}/{{$order->id}}">View Details</a></li>
                                                        @endcan
                                                    </ul>
                                                </div> 
                                                    @can('Compare Order Stock')
                                                    <a target="" href="{{admin_url('orders/approveddetails')}}/{{$order->id}}" class="icon-table" rel="tooltip" data-tooltip=" View">
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
                                        <div class="text-right"><button type="submit" name="submit" class="green_button" target="_blank"><i class="fa fa-print" aria-hidden="true"></i> Print</button></div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </section>
                     <div class="text-bold" style="padding:10px;"> {{$orders->links()}}Showing Page {{$orders->currentPage()}} of {{$orders->lastPage()}} </div>
               
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@include('admin.order.order-modal')
@include('admin.order.process-modal')
@include('admin.customer.customer-modal')
@include('admin.product.product-modal')
<div id="myModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <form action="{{admin_url('orders')}}" method="post" name="form1" id="form1">
        @csrf
        <div class="popupform">
		    <div class="top-section">
        		<div class="headertop">
        			<h2>Create New Order</h2>
        		</div>
        		    <input type="hidden" name="_method" value="POST" id="form-method"/>
        		    <input type="hidden" name="order_id" value="{{$order_no+1}}" id="order_id">
        		    <div class="newform_top">
    			    <div class="row clearfix">
            			<div class="col-md-6">
            				<p>
            				<label>Customer</label>
            				<input type="text" name="user_name" id="user_name" autocomplete="off">
            				<div id="result-div-user" style="display:none;"></div>
            				<input type="hidden" name="user_id" id="user_id">
            				</p>
            			</div>
            			<div class="col-md-6"><p>
            				<label>Customer email</label>
            				<input type="text" placeholder="Email" id="email" name="email" required readonly/></p>
            			</div>
            			<div class="col-md-6">
            				<p><label>Billing address</label>
            				<textarea name="billing_address" rows="5" cols="35" id="billing_address" required></textarea></p>
            				<p><label>Shipping To</label>
            				<textarea name="shipping_address" rows="5" cols="35" id="shipping_address" required></textarea></p>
            			</div>
            			<div class="col-md-3">
        					<p><label>Order Date</label>
        					<input type="date" name="order_date" id="order_date" value="{{date('d-m-Y')}}" required/></p>
            			</div>
        				<div class="col-md-3">
    						<p><label>Shipping Date</label>
    						<input type="date" name="shipping_date" id="shipping_date" required/></p>
        				</div>
	                </div>
	                </div>
		        </div>
        		<div class="middlesection">
        			<table>
        				<thead>
        					<tr>
        						<!--<th></th>-->
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
        						<!--<td><button class="tickmark"></button></td>-->
        						<td><span class="order-item">1</span></td>
        						<td>
        						    <input type="text" name="product_name[]" id="product_name-0" onkeyup="newProduct(0);" autocomplete="off" class="product_name">
        						    <input type="hidden" name="product_id[]" id="product_id-0">
        						    <div id="result-div-0" style="display:none;background: darkturquoise;"></div>
        						</td>
        						<td>
        							<input type="text" name="description[]" id="description-0"/>
        						</td>
        						<td>
        							<input type="text" name="quantity[]" id="quantity-0" onkeyup="getTotal(0);" onkeypress="return isNumber(event)" required/>
        						</td>
        						<td>
        							<input type="text" name="rate[]" id="rate-0" onkeyup="getTotal(0);" onkeypress="return isNumber(event)"/>
        						</td>
        						<td>
        							<span id="amount-0"></span>
        						</td>
        						<td>
        							<button class="delete" id="delete-0" onclick="deteteRow(0);"><i class="fa fa-trash" aria-hidden="true"></i></button>
        						</td>
        					</tr>
        					<tr class="last-item-row" ></tr>
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
        						<label>Message on invoice</label>
        						<textarea rows="3" cols="43" name="message" id="message"></textarea>
        					</div>
        				</div>
				        <div class="col-md-6">
        					<div class="brfirst">
        						<p class="sub_total"><label>Sub Total </label> <span id="subtotal">$0.00</span></p>
        						<p><label>Discount </label>
        						    <select name="discountt" id="discountt" onchange="calculateDiscount();">
        								<option value="1">Discount Percentage</option>
        								<option value="2">Discount Amount</option>
        						    </select></p>
        						    <p> <label><span class="disc_value">Discount Value</span> </label><input type="text" id="discount_type" name="discount_type" onchange="calculateDiscount();">
            						<div class="clearfix"></div>
            						<span id="disc"> $0.00</span>
        						</p>
        						<div class="clearfix"></div>
        						<p><label>Total &nbsp; &nbsp; &nbsp; &nbsp;</label><span id="grand">$0.00</span></p>
        						<p><label>Balance Due &nbsp; &nbsp; &nbsp; &nbsp; </label><span id="bal">$0.00</span></p>
        					</div>
        					<div class="clearfix"></div>
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
	        </div>
        </form>
    </div>
</div>

<div id="acceptModal" class="modal" style="padding-top: 10px;padding:10px;">
  	<div class="modal-content">
    	<span class="close acceptclose">&times;</span>
    	<div class="popupform">
    		<form action="{{admin_url('orders/backorder')}}" method="post" name="acceptform" id="acceptform">
		    @csrf
				<div class="top-section">
					<div class="headertop">
						<h2>Order No.<span id="order_no1">{{$order_no+1}}</span></h2>
					</div>
				    <input type="hidden" name="_method" value="POST" id="form-method1" />
				    <input type="hidden" name="order_id1" value="{{$order_no+1}}" id="order_id1">
					<div class="row clearfix">
						<div class="col-md-6">
							<p>
							<label>Customer</label>
							<input type="text" name="user_name1" id="user_name1" autocomplete="off" readonly>
							<div id="result-div-user" style="display:none;"></div>
							<input type="hidden" name="user_id1" id="user_id1">
							</p>
						</div>
						<div class="col-md-6"><p>
							<label>Customer email</label>
							<input type="text" placeholder="Email" id="email1" name="email1" readonly/></p>
						</div>
						<div class="col-md-6">
							<p><label>Billing address</label>
							<textarea name="billing_address1" rows="5" cols="35" id="billing_address1" required>bfvhfghgh</textarea></p>
							<p><label>Shipping To</label>
							<textarea name="shipping_address1" rows="5" cols="35" id="shipping_address1" required></textarea></p>
						</div>
						<div class="col-md-3">
							<p><label>Order Date</label>
							<input type="date" name="order_date1" id="order_date1" required/></p>
						</div>
						<div class="col-md-3">
							<p><label>Shipping Date</label>
							<input type="date" name="shipping_date1" id="shipping_date1" required/></p>
						</div>
					</div>
				</div>
				<div class="middlesection">
					<table>
						<thead>
							<tr>
								<th></th>
								<th>#</th>
								<th>ITEM</th>
								<th>REQUIRED QTY</th>
								<th>STOCK QTY</th>
								<th width="10%">QTY</th>
								<th>RATE</th>
								<th width="10%">AMOUNT</th>
							</tr>
						</thead>
						<tbody id="order-items">
							<tr id="acceptr-0">
								<td><button class="tickmark"></button></td>
								<td><span class="order-item">1</span></td>
								<td>
								    <span id="product_name1-0" ></span>
								    <input type="hidden" name="product_id1[]" id="product_id1-0">
								    <div id="result-div-0" style="display:none;background: darkturquoise;"></div>
									<!--<input type="text" name="prodservice"/>-->
								</td>
								<td>
									<span id="reqqty1-0"></span><input type="hidden" name="reqty" id="reqty-0">
								</td>
								<td>
								    <span id="stockqty1-0"></span>
								</td>
								<td>
									<input type="text" name="quantity1[]" id="quantity1-0" onkeyup="getTotal1(1);" onkeypress="return isNumber(event)" placeholder="Quantity" required />
								</td>
								<td>
									<input type="text" name="rate1[]" id="rate1-0" onkeyup="getTotal1(1);" onkeypress="return isNumber(event)" placeholder="Rate" required/>
								</td>
								<td>
									<span id="amount1-0"></span>
								</td>
							</tr>
							<tr class="last-item-row1" ></tr>
		                    <tr><td colspan="8"></td></tr>
						</tbody>
					</table>
				</div>
				<div class="bottomsection">
					<div class="bottomright" style="width:100%;">
						<div class="brfirst">
							<p class="sub_total"><span class="br_label">Sub Total &nbsp; &nbsp; </span> <span id="subtotall1">$0.00</span></p>
							<p>Discount  &nbsp; &nbsp; <select name="discountt1" id="discountt1" onchange="calculateDiscount1();">
									<option value="1">Discount Percentage</option>
									<option value="2">Discount Amount</option>
							</select>
							<span style="width:5%;"><input type="text" id="discount_type1" name="discount_type1" onchange="calculateDiscount1();"></span>
							<span id="disc1">$0.00</span>
							</p>
						</div>
						<div class="brsecond">
								<p class="sub_total"><span class="br_label">Total: &nbsp;&nbsp;</span> <span id="grand1">$0.00</span></p>
						</div>
						<input type="hidden" id="grand_total1" name="grand_total1" value="0">
						<input type="hidden" id="subtotal11" name="subtotal11" value="0">
						<input type="hidden" id="discount1" name="discount1" value="0">
						<!--<input type="hidden" id="id" name="id" value="0">-->
						<input type="hidden" id="acceptid" name="acceptid" value="0">
					</div>
					<div class="clear"></div>
				</div>
				<div style="align:center;">
					<h2>Back Order Items</h2>
				</div>
				<div class="middlesection">
					<table>
						<thead>
							<tr>
								<th>#</th>
								<th>PRODUCT</th>
								<th>Back Order Quantity</th>
								<th>Amount</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>1</td>
								<td>
								   <span id="name-0"></span><input type="hidden" name="stockprod[]" id="stockprod-0">
								</td>
								<td><input type="number" name="backqty[]" id="backqty-0"></td>
								<td><input type="text" name="backqtyamount[]" id="backqtyamount-0" placeholder="Please enter amount"></td>
							</tr>
							<tr class="last-stock-row" ></tr>
		                    <tr><td colspan="4"></td></tr>
						</tbody>
						<br>
					</table>
				</div>
				<input type="hidden" id="stockid" name="stockid" value="0">
				<input type="hidden" id="orderidd" name="orderidd" value="">
				<div class="footerform">	
					 <button type="submit" value="Submit">Accept Order</button>
				</div>
			</form>
		</div>
	</div>
</div>		
<!--<div class="modal" tabindex="-1" role="dialog" id="uploadimageModal">-->
<!--    <div class="modal-dialog" role="document" style="min-width: 700px">-->
<!--        <div class="modal-content">-->
<!--            <div class="modal-header">-->
<!--                <h5 class="modal-title">Image</h5>-->
<!--                <button type="button" class="close" data-dismiss="modal" aria-label="Close">-->
<!--                    <span aria-hidden="true">&times;</span>-->
<!--                </button>-->
<!--            </div>-->
<!--            <div class="modal-body">-->
<!--                <div class="row">-->
<!--                    <div class="col-md-12 text-center">-->
<!--                        <div id="image_demo"></div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="modal-footer">-->
<!--                <button type="button" class="btn btn-primary crop_image">Crop and Save</button>-->
<!--                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
<script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js" ></script>
<script type="text/javascript">
function isNumber(evt)
  {
     var charCode = (evt.which) ? evt.which : event.keyCode
     if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
     return true;
  }
</script>
@endsection
@section('bottom-scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.css" />

<script>
var image_crop = $('#image_demo').croppie({
    viewport: {
        width: 300,
        height: 225,
        type: 'square'
    },
    boundary: {
        width: 350,
        height: 350
    }
});
/// catching up the cover_image change event and binding the image into my croppie. Then show the modal.
$('#pictur').on('change', function() {
    var reader = new FileReader();
    reader.onload = function(event) {
        image_crop.croppie('bind', {
            url: event.target.result,
        });
    }
    reader.readAsDataURL(this.files[0]);
    $('#uploadimageModal').modal('show');
});
$('.crop_image').click(function(event) {
    image_crop.croppie('result', {
        type: 'canvas',
        format: 'png'
    }).then(function(response) {
        $("#uploaded-image").attr("src", response).css("display", "block");
        $("#picture").val(response);
    });
    $("#pictur").val("");
    $('#uploadimageModal').modal('hide');
});
</script>
<script>
var image_crop1 = $('#image_demo1').croppie({
    viewport: {
        width: 300,
        height: 225,
        type: 'square'
    },
    boundary: {
        width: 350,
        height: 350
    }
});
/// catching up the cover_image change event and binding the image into my croppie. Then show the modal.
$('#profile_pic').on('change', function() {
    var reader = new FileReader();
    reader.onload = function(event) {
        image_crop1.croppie('bind', {
            url: event.target.result,
        });
    }
    reader.readAsDataURL(this.files[0]);
    $('#uploadimageModal1').modal('show');
});
$('.crop_image1').click(function(event) {
    image_crop1.croppie('result', {
        type: 'canvas',
        format: 'png'
    }).then(function(response) {
        $("#uploaded-image1").attr("src", response).css("display", "block");
        $("#picture1").val(response);
    });
    $("#profile_pic").val("");
    $('#uploadimageModal1').modal('hide');
});
$("#print_form").submit(function(e){
    if($('.print_check:checked').length < 1) {
        e.preventDefault();
        alert('Please select atleast one order for print');
    }
})
</script>
<script src="/js/custom.js" ></script>
<script>
let searchKey    = $('input#table-search');
// let searchCategory   = $('select#category');
// let searchStatus = $('select#status');
let sortDiv = $('div.paginate');
let deferUrl = `{{ admin_url('staffs/defer')}}`;
$(document).ready(function() {

  $.getJSON(`${deferUrl}`,  function(response) {
    renderTable(response);
  });
  $('#table-search').on('keyup', function(){
    loadingRow();
    $.getJSON(`${deferUrl}?key=${searchKey.val()}`, function(response) {
      renderTable(response);
    });
  });
  // $('#category').on('change', function(){
  //   loadingRow();
  //   $.getJSON(`${deferUrl}?key=${searchKey.val()}&type=${searchCategory.val()}&status=${searchStatus.val()}`, function(response) {
  //     renderTable(response);
  //   });
  // });
  // $('#status').on('change', function(){
  //   loadingRow();
  //   $.getJSON(`${deferUrl}?key=${searchKey.val()}&type=${searchCategory.val()}&status=${searchStatus.val()}`, function(response) {
  //     renderTable(response);
  //   });
  // });
  $('a.sort').on('click',async function(e){
    e.preventDefault();
    let srtTH = $(this);
    let key = $('input#table-search').val();
    let sort = srtTH.attr('data-sort');
    let direction = srtTH.attr('data-direction');
      if(sort == null || direction == null)
        return false;
    sortDiv.attr('data-sort', sort);
    sortDiv.attr('data-direction', direction);
    loadingRow();
    await $.getJSON(`${deferUrl}?key=${searchKey.val()}&sort=${sort}&direction=${direction}`, function(response) {
      renderTable(response);
      srtTH.attr('data-direction', direction == 'asc' ? 'desc' : 'asc');
    });
  });
});
function loadingRow()
{
  $('tbody.append-row').html(`<tr><td colspan="7" class="text-center">Loading Data...</td><tr>`);
}
async function renderTable(response){
  let table = '';
  await response.data.forEach(function(row, index){
    let createdAt = new Date(row.created_at).toLocaleDateString('en-us', {year:"numeric", month:"short", day:"numeric"});
    table+=`<tr><td>
              ${row.id}
            </td>
            <td class="text-lg-left  text-md-left"data-label="Organization">
              <img src= "{{asset('images/users/${row.picture}')}}" style="width:50px;height:50px;"/>
            </td>
            <td class="text-lg-left  text-md-left"data-label="Organization">
              <label class="">${row.firstname} ${row.lastname}</label>
            </td>
            <td class="text-lg-left  text-md-left"data-label="Organization">
              <label class="">${row.email}</label>
            </td>
            <td class="text-lg-left  text-md-left"data-label="Organization">
              <label class="">${row.address}</label>
            </td>
            <td class="text-lg-left  text-md-left"data-label="Organization">
              <label class="">${row.city}</label>
            </td>
            <td class="text-lg-left  text-md-left"data-label="Organization">
              <label class="">${row.staff_type}</label>
            </td>
            <td class="text-lg-left  text-md-left"data-label="Organization">
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" ${row.status == '1' ? 'checked' : ''}                                                   onchange="changeStatus('${row.id}');"                                                    name="status">
                <label class="form-check-label" for="flexSwitchCheckChecked"></label>
              </div> 
            </td>
            <td class="text-lg-left  text-md-left"data-label="Organization">
              <label class="">${createdAt}</label>
            </td>
            <td class="text-right" >
              <div class="fh_actions pull-right">
                <a href="#" class="fh_link">Actions <i class="fa fa-caret-down"></i> </a>
                  <ul class="fh_dropdown">
                    @can('Staff Edit')
                      <a href="/admin/staffs/${row.id}/edit"><li><i class="fa fa-edit"></i> Edit</li></a>
                    @endcan
                    @can('Staff Delete')
                      <a href="/admin/staffs/${row.id}/del"><li><i class="fa fa-trash"></i> Delete</li></a>
                    @endcan
                  </ul>
              </div>
            </td>
          </tr>`;
          
  });
  $('tbody.append-row').html(table ? table : `<tr><td colspan="7" class="text-center">No data found</td><tr>`);
  $('.paginate').html(response.links);
}
</script>
@endsection