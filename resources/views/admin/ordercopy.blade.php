@extends('layouts.admin')
@section('title','Orders')
@section('page_title','Orders')
@section('page_nav')
<ul>
    <li class="active"><a href="{{admin_url('orders')}}">All Orders</a></li>
    <li><a  href="{{admin_url('invoices')}}">Invoices</a>
    <li><a  href="{{admin_url('backorders')}}">Backorders</a></li>
    <li><a href="{{admin_url('getrunsheet')}}">Generate Runsheet</a></li>
</ul>
@endsection
@section('contents')
<div class="content-container">
   <div class="content-area">
      <div class="row main_content">
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding">
            <div class="card no-margin minH">
               <div class="card-block">
            
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
                                    <div class="col-sm-6">
                                        <div class="filter_form">
                                            <form action="" method="get">
                                                 @csrf
                                               
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label>Search</label>
                                                            <input type="text"  name="search"  value="{{Request()->search}}" class="form-control" />
                                                        </div>
                                                    </div>
                                                         
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
                                                            <label>Select By</label>
                                                            <select name="orders"  class="form-control">
                                                                <option value="">Status</option>
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
                                    <div class="col-sm-6">
                                        @can('Order Create')
                                                <button id="myBtn" class="btn btn-success pull-right main_button"><clr-icon shape="plus-circle"></clr-icon>
                                                    New order  
                                                </button>
                                        @endcan
                                    </div>
                                 </div>
                                 
                                 
                                 
                                 <div class="table-list-responsive-md">
                                    <table class="table table-customer mt-0">
                                       
                                       <thead>
                                          <tr>
                                             <th class="text-left">ID</th>
                                              <th class="text-left">
                                                 Name
                                             </th>
                                             <th class="text-left">
                                                Email
                                             </th>

                                             <th class="text-left">
                                                PO
                                             </th>
                                              <th class="text-left">
                                               Quantity
                                              </th>
                                             <th class="text-left">
                                                Amount
                                             </th>
                                             <th class="text-left">
                                                Date
                                             </th>
                                             <th class="text-left">
                                                Status
                                             </th>
                                             <th class="text-right">Actions</th>
                                          </tr>
                                          </thead>
                                          @php $i=1;
                                          @endphp
                                          @if(isset($orders) && count($orders)>0)
                                          @foreach($orders as $order)
                                          <tr>
                                             <td class="text-left">{{$i}}</td>
                                              <td class="text-left">
                                                {{$order->firstname}} {{$order->lastname}}
                                             </td>
                                             <td class="text-left">
                                                {{$order->email}}
                                             </td>
                                             
                                          
                                             <td class="text-left">
                                                {{$order->order_id}}
                                             </td>
                                             <td class="text-left">
                                                {{$order->item->sum('quantity')}}
                                             </td>
                                             
                                           
                                             <td class="text-left">
                                               {{$order->grand_total}}
                                             </td>
                                             <td class="text-left">
                                                {{date('d F Y',strtotime($order->order_date))}}
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
                                                 @can('Order Edit')
                                                 @if($order->status <= 4)
                                                 <select class="action" data-id="{{$order->id}}">
                                                        <option value="">Actions</option>
                                                        @foreach($status as $s)
                                                             @if($order->status <=1)
                                                             @if($order->status < $s->id && $order->status+2 > $s->id)
                                                             <option value="{{$s->id}}">{{$s->action}}</option>
                                                             @endif
                                                             @if($order->status <=1 && $s->id ==6)
                                                             @can('Order Delete')
                                                             <option value="{{$s->id}}">{{$s->action}}</option>
                                                             @endcan
                                                             @endif
                                                             @elseif($order->status==2)
                                                             @if($order->status < $s->id && $order->status+3 >= $s->id && $s->id !=4)
                                                             <option value="{{$s->id}}">{{$s->action}}</option>
                                                             @endif
                                                             @elseif($order->status==3)
                                                             @if($order->status < $s->id && $order->status+2 >= $s->id && $s->id !=4)
                                                             <option value="{{$s->id}}">{{$s->action}}</option>
                                                             @endif
                                                             @elseif($order->status==4)
                                                             @if($order->status < $s->id && $order->status+1 >= $s->id)
                                                             <option value="{{$s->id}}">{{$s->action}}</option>
                                                             @endif
                                                             @endif
                                                         @endforeach
                                                        
                                                    </select>
                                                    @endif
                                                    @endcan
                                                    @can('Order View')
                                                    <a target="" href="{{admin_url('orders/orderdetails')}}/{{$order->id}}" class="icon-table" rel="tooltip" data-tooltip=" View">
                                                      view
                                                    </a>
                                                    @endcan
                                                    @can('Compare Order Stock')
                                                    <a target="" href="{{admin_url('orders/approveddetails')}}/{{$order->id}}" class="icon-table" rel="tooltip" data-tooltip=" View">
                                                      View Details
                                                    </a>
                                                    @endcan
                                                    
                                                    
                                                
                                             </td>
                                             
                                          </tr>
                                          @php $i++; @endphp
                                          @endforeach
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
                     <div class="text-bold" style="padding:10px;">
                                 {{$orders->links()}}
                                    <!-- <ul class="pagination">-->
                                    <!--    <li class="page-item paginate_button"    style=" box-sizing: border-box;"><a href="{{$orders->previousPageUrl()}}" class="page-link"><i class="fa fa-angle-left"></i> <span>Previous</span></a></li>-->
                                           
                                    <!--     <li class="page-item paginate_button"></li> <a href="{{$orders->perPage()}}"><span>{{$orders->perPage()}}</span></a></li>-->
                                        
                                    <!--    <li class="page-item paginate_button" ><a href="{{$orders->nextPageUrl()}}" class="page-link"><span>Next</span> <i class="fa fa-angle-right"></i></a></li>-->
                                    <!--</ul> -->
                                
                     </div>
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
        <form action="{{admin_url('orders')}}" method="post" name="form1" id="form1">
        @csrf
        <div class="popupform">
		    <div class="top-section">
        		<div class="headertop">
        			<h2>Create New Order</h2>
        		</div>
		        
        		    <input type="hidden" name="_method" value="POST" id="form-method"/>
        		    <input type="hidden" name="order_id" value="{{$order_no+1}}" id="order_id">
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
    				
    				    <div class="clear"></div>
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
        						    <input type="text" name="product_name[]" id="product_name-0" onkeyup="newProduct(0);" autocomplete="off">
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
        						<textarea rows="6" cols="43" name="message" id="message"></textarea>
        						
        					</div>
        				</div>
				        <div class="col-md-6">
        					<div class="brfirst">
        						<p class="sub_total ">Sub Total &nbsp; &nbsp;  <span id="subtotal">$0.00</span></p>
        						<p>Discount &nbsp; &nbsp; 
        						    <select name="discountt" id="discountt" onchange="calculateDiscount();">
        								<option value="1">Discount Percentage</option>
        								<option value="2">Discount Amount</option>
        								
        						    </select>
            						<span class="orderform_text"><input type="text" id="discount_type" name="discount_type" onchange="calculateDiscount();"></span>
            						<span id="disc">$0.00</span>
        						</p>
    					    </div>
        					<div class="brsecond">
        						<p>Total: &nbsp; &nbsp; <span id="grand">$0.00</span></p>
        						<p>Balance Due: &nbsp; &nbsp;  <span id="bal">$0.00</span></p>
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
<div id="driverModal" class="modal" style="padding-top: 10px;padding:10px;">
    <div class="modal-content" style="width: 1000px;">
    <span class="close driverclose">&times;</span>
    <div class="popupform" style="width: 1000px;">
		<div style="align:center;">
			<h2>Assign Driver</h2>
		</div>
		<form action="{{admin_url('orders/assigndriver')}}" method="post" name="form" id="form">
		    @csrf
		    <input type="hidden" name="driverorderid"  id="driverorderid">
			<div class="middlesection">
			    <div class="row">
    			<div class="col-md-6">
    				<label>Driver</label>
    				<select id="driver_id" name="driver_id" class="form-control" required>
    				    <option value="">Select Driver</option>
    				    @foreach($drivers as $driver)
    				    <option value={{$driver->id}}>{{$driver->firstname}} {{$driver->lastname}}</option>
    				    @endforeach
    				</select>
    			</div>	
    			<div class="col-md-6">
    				<label>Date of delivery</label>
    				<input name="dod" id="dod" type="date" class="form-control" required>
    				    
    			</div>
    			</div>
    		 </div>
			
			<div class="footerform">	
				 <button type="submit" value="Submit">Assign Driver</button>
			</div>
		</form>
	</div>
	</div>
</div>


	
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
<script>
$(document).ready(function() {
    $('#user_name').on('keyup',function(){
        var custname=$(this).val();
        
        if(custname)
        {
            $.ajax({
                url:"{{admin_url('orders/getcustdetails1')}}/"+custname,
                type:"GET",
                dataType:"json",
                success:function(data)
                {
                    var dropdown = '<ul id="users-list">';
                    $.each(data,function(key,value)
                    {
    
                        dropdown+= '<li><a href="#" class="UserRow" data-id="'+value.id+'" data-name="'+value.firstname+' '+value.lastname+'" data-address="'+value.address+'" data-email="'+value.email+'">'+value.firstname+' '+value.lastname+'</a><li>';
                       
                    });
                    
                    dropdown+= '</ul>';
                    $("#result-div-user").html(dropdown);
                    $("#result-div-user").css("display","block");
                    
                }
            });
        }
        
        
    });
    
    
    

    $('#shipping').change(function(){
        var shippingtax=$(this).val();
        var discount=$('#discount').val();
        var subtotal=$('#subtotal1').val();
        var disctotal=Number(subtotal)-Number(discount);
        var taxvalue=Number(disctotal)*(Number(shippingtax)/100);
        var taxamount=Number(disctotal)+Number(taxvalue);
        $('#taxx').val(taxvalue.toFixed(2));
        $('#tax').html(taxvalue.toFixed(2));
        getTotal();

        
        
    }); 
     $('.edit_modal').click(function(){
        var tour_id= $(this).val();
        var url="{{admin_url('orders')}}/"+tour_id+"/edit";
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
                        $('#discount_type').val(value.discount);
                        $('#discount').val(value.discount_amount);
                        $('#disc').html(value.discount_amount);
                        $('#discountt').val(value.discount_type);
                        $('#shipping').val(value.shipping);
                        $('#taxx').val(value.tax);
                        $('#tax').html(value.tax);
                        $('#order_no').html(value.order_id);
                        $('#order_id').val(value.order_id);
                        var isoFormatDateString = value.order_date;
                        var isoFormatDateString1 = value.due_date;
                        var isoFormatDateString2 = value.shipping_date;
                        var dateParts = isoFormatDateString.split(" ");
                        var dateParts1 = isoFormatDateString1.split(" ");
                        var dateParts2 = isoFormatDateString2.split(" ");
                        $('#order_date').val(dateParts[0]);
                        $('#due_date').val(dateParts1[0]);
                        $('#shipping_date').val(dateParts2[0]);
                        var id=$('#id').val();
                        for(var i=1;i<=id;i++)
                        {
                            deleteRow(i);
                        }
                        $('#id').val(0);
                        // alert(value.due_date);
                        $('#myModal').css('display', 'block');
                   
                
                    });
                }
            });
            var url1="{{admin_url('orders')}}/"+tour_id+"/getpr";
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
                      $('#rate-'+i).val(value.rate);
                      $('#description-'+i).val(value.description);
                      $('#creditrate-'+i).html(value.rate)
                      $('#amount-'+i).html((Number(value.quantity)*Number(value.rate)).toFixed(2));
                      subt=subt+(Number(value.quantity)*Number(value.rate));
                      i++;
                    });
                    
                    $('#subtotal1').val(subt.toFixed(2));
                    $('#subtotal').html(subt.toFixed(2));
                    
                }
            });
            var url2="{{admin_url('orders')}}/"+tour_id;
            
            $('#form1').attr('action', url2); //this fails silently
            $("#form-method").val('PUT');
        
        
    });
    $('.accept_modal').click(function(){
        var tour_id= $(this).val();
        var url="{{admin_url('orders')}}/"+tour_id+"/edit";
          $.ajax({
                url:url,
                type:"GET",
                dataType:"json",
                success:function(data)
                {
                    $.each(data,function(key,value)
                    {
                        $('#email1').val(value.email);
                        $('#user_id1').val(value.user_id);
                        $('#billing_address1').val(value.billing_address);
                        $('#shipping_address1').val(value.shipping_address);
                        //$('#shipping_address').val(value.shipping_address);
                        //$('#order_date').val(value.order_date);
                        
                        $('#shipping_id').val(value.shipping_id);
                        $('#tracking_code').val(value.tracking_code);
                        $('#message1').val(value.message);
                        $('#grand_total').val(value.grand_total);
                        $('#grand').html(value.grand_total);
                        $('#bal').html(value.grand_total-value.paid_amount);
                        $('#discount_type').val(value.discount);
                        $('#discount').val(value.discount_amount);
                        $('#disc').html(value.discount_amount);
                        $('#discountt').val(value.discount_type);
                        $('#shipping').val(value.shipping);
                        $('#taxx').val(value.tax);
                        $('#tax').html(value.tax);
                        $('#order_no').html(value.order_id);
                        $('#order_id').val(value.order_id);
                        var isoFormatDateString = value.order_date;
                        var isoFormatDateString1 = value.due_date;
                        var isoFormatDateString2 = value.shipping_date;
                        var dateParts = isoFormatDateString.split(" ");
                        var dateParts1 = isoFormatDateString1.split(" ");
                        var dateParts2 = isoFormatDateString2.split(" ");
                        $('#order_date').val(dateParts[0]);
                        $('#due_date').val(dateParts1[0]);
                        $('#shipping_date').val(dateParts2[0]);
                        
                        $('#acceptid').val(0);
                        // alert(value.due_date);
                        $('#acceptModal').css('display', 'block');
                   
                
                    });
                }
            });
            var url1="{{admin_url('orders/getstock')}}/"+tour_id;
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
                        
                        for(var j=0;j<len-1;j++)
                        {
                            addBlankRowAccept(j);
                        }
                    }
                    else
                    {
                         addBlankRowAccept(0);
                    }
                    $.each(data,function(key,value)
                    {
                        // $('#name-'+key).html(value.name);
                        // $('#orqty-'+key).html(value.quantity);
                        // $('#avqty-'+key).html(value.qty);
                      $('#product_name1-'+i).html(value.name);
                      $('#product_id1-'+i).val(value.product_id);
                      $('#reqqty1-'+i).html(value.quantity);
                    //   var qty=(value.qty != '') : value.qty ? 0;
                    //   alert(qty);
                      $('#stockqty1-'+i).html(qty);
                    //   $('#amount1-'+i).html(value.qty);
                    //   $('#rate1-'+i).val(value.rate);
                    //   $('#description1-'+i).val(value.description);
                    //   $('#creditrate1-'+i).html(value.rate)
                    //   $('#amount1-'+i).html((Number(value.quantity)*Number(value.rate)).toFixed(2));
                    //   subt=subt+(Number(value.quantity)*Number(value.rate));
                      i++;
                    });
                    
                    
                    // $('#subtotal1').val(subt.toFixed(2));
                    // $('#subtotal').html(subt.toFixed(2));
                    
                }
            });
            var url2="{{admin_url('backorders')}}/"+tour_id;
            
            $('#acceptform').attr('action', url2); //this fails silently
            $("#form-method1").val('PUT');
        
        
    });
   
    $('#myBtn').click(function(){
                        $('#email').val("");
                        $('#user_id').val("");
                        $('#billing_address').val("");
                        $('#shipping_address').val("");
                       
                        
                        $('#shipping_id').val("");
                        $('#tracking_code').val("");
                        $('#message').val("");
                        $('#grand_total').val(0);
                        $('#grand').html("$0.00");
                        $('#bal').html("$0.00");
                        $('#discount_type').val("");
                         $('#discount').val("");
                         $('#discountt').val("");
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
                        var id=$('#id').val();
                        for(var j=1;j<=id;j++)
                        {
                            deleteRow(j);
                        }
                       $('#product_name-0').val("");
                      $('#product_id-0').val("");
                      $('#quantity-0').val("");
                      $('#rate-0').val("");
                      $('#description-0').val("");
                      $('#creditrate-0').html("")
                      $('#amount-0').html("");
                     $('#subtotal1').val(0);
                    $('#subtotal').html("$0.00");
                     $('#id').val(0);
   $('#myModal').css('display', 'block');
});
$('.close').click(function(){
   $('#myModal').css('display', 'none');
   
});
$('.acceptclose').click(function(){
   $('#acceptModal').css('display', 'none');
   
});
$('.driverclose').click(function(){
   $('#driverModal').css('display', 'none');
   
});
$('.action').change(function(){
    var status=$(this).val();
    var id=$(this).data('id');
    if(status==2)
    {
        var tour_id=id;
        var url="{{admin_url('orders')}}/"+tour_id+"/edit";
          $.ajax({
                url:url,
                type:"GET",
                dataType:"json",
                success:function(data)
                {
                    $.each(data,function(key,value)
                    {
                        $('#user_name1').val(value.user.firstname+' '+value.user.lastname)
                        $('#email1').val(value.email);
                        $('#user_id1').val(value.user_id);
                        $('#billing_address1').val(value.billing_address);
                        $('#shipping_address1').val(value.shipping_address);
                        //$('#shipping_address').val(value.shipping_address);
                        //$('#order_date').val(value.order_date);
                        
                        $('#shipping_id').val(value.shipping_id);
                        $('#tracking_code').val(value.tracking_code);
                        $('#message1').val(value.message);
                        $('#grand_total1').val(value.grand_total);
                        $('#grand1').html(value.grand_total);
                        $('#bal').html(value.grand_total-value.paid_amount);
                        $('#discount_type1').val(value.discount);
                        $('#discount1').val(value.discount_amount);
                        $('#disc1').html(value.discount_amount);
                        $('#discountt1').val(value.discount_type);
                        $('#shipping').val(value.shipping);
                        $('#taxx').val(value.tax);
                        $('#tax').html(value.tax);
                        $('#order_no1').html(value.order_id);
                        $('#order_id1').val(value.order_id);
                        var isoFormatDateString = value.order_date;
                        // var isoFormatDateString1 = value.due_date;
                        var isoFormatDateString2 = value.shipping_date;
                        var dateParts = isoFormatDateString.split(" ");
                        // var dateParts1 = isoFormatDateString1.split(" ");
                        var dateParts2 = isoFormatDateString2.split(" ");
                        $('#order_date1').val(dateParts[0]);
                        // $('#due_date').val(dateParts1[0]);
                        $('#shipping_date1').val(dateParts2[0]);
                        
                        $('#acceptid').val(0);
                        // alert(value.due_date);
                        $('#acceptModal').css('display', 'block');
                   
                
                    });
                }
            });
            var url1="{{admin_url('orders/getstock')}}/"+tour_id;
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
                        
                        for(var j=0;j<len-1;j++)
                        {
                            addBlankRowAccept(j);
                        }
                    }
                    // else
                    // {
                    //      addBlankRowAccept(0);
                    // }
                    $.each(data,function(key,value)
                    {
                        
                        // $('#name-'+key).html(value.name);
                        // $('#orqty-'+key).html(value.quantity);
                        // $('#avqty-'+key).html(value.qty);
                      $('#product_name1-'+i).html(value.product.name);
                      $('#product_id1-'+i).val(value.product_id);
                      $('#reqqty1-'+i).html(value.quantity);
                      $('#reqty-'+i).val(value.quantity);
                      $('#stockqty1-'+i).html(value.stock.quantity);
                      if(value.quantity > value.stock.quantity)
                      {
                          $('#quantity1-'+i).val(value.stock.quantity);
                          var q=value.stock.quantity;
                      }
                      else
                      {
                          $('#quantity1-'+i).val(value.quantity);
                          var q=value.quantity;
                      }
                      $('#amount1-'+i).html((q * value.rate).toFixed(2));
                      $('#rate1-'+i).val(value.rate);
                    //   $('#description1-'+i).val(value.description);
                    //   $('#creditrate1-'+i).html(value.rate)
                    //   $('#amount1-'+i).html((Number(value.quantity)*Number(value.rate)).toFixed(2));
                      subt=subt+(Number(q)*Number(value.rate));
                      i++;
                    });
                    if(len >1)
                    {
                        for(var j=1;j<len;j++)
                        {
                            addStockRow();
                        }
                    }
                    $.each(data,function(key,value)
                    {
                        $('#name-'+key).html(value.product.name);
                        $('#stockprod-'+key).val(value.product_id);
                        
                        if((value.quantity-value.stock.quantity)>0)
                        {
                        $('#backqty-'+key).val(value.quantity-value.stock.quantity)
                        }
                        else
                        {
                        $('#backqty-'+key).val(0)
                        }
                        $('#backqtyamount-'+key).val(value.rate);
                        $('#orderidd').val(value.order_id);
                       
                    });
                    
                    $('#subtotal11').val(subt.toFixed(2));
                    $('#subtotall1').html(subt.toFixed(2));
                    $('#grand1').html(subt.toFixed(2));
                    
                }
            });
            // var url2="{{admin_url('backorders')}}/"+tour_id;
            
            // $('#acceptform').attr('action', url2); //this fails silently
            // $("#form-method1").val('PUT');
    }
    else if(status==3)
    {
        $('#driverorderid').val(id);
        var tour_id=id;
        var url="{{admin_url('orders')}}/"+tour_id+"/edit";
          $.ajax({
                url:url,
                type:"GET",
                dataType:"json",
                success:function(data)
                {
                    $.each(data,function(key,value)
                    {
                        var isoFormatDateString = value.shipping_date;
                        var dateParts = isoFormatDateString.split(" ");
                        $('#dod').val(dateParts[0]);
                    });
                }
          });
        $('#driverModal').css('display', 'block');
    }
    else
    {
    var url="{{admin_url('orders/updatestatus')}}/"+id+"/"+status;
    
    window.location.href=url;
    }
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
//   var taxvalue=Number(discvalue)*(Number($('#shipping').val())/100);
//         $('#taxx').val(taxvalue.toFixed(2));
//         $('#tax').html(taxvalue.toFixed(2));
  }
   
   var g=Number(sub)+Number(tax)-Number(dis);
   
   $('#grand').html(g.toFixed(2));
   $('#grand_total').val(g.toFixed(2));
   $('#bal').html(g.toFixed(2));
}
function getTotal1(j)
{
    var s=0;
    var t=0;
    var id=parseInt($('#acceptid').val());
     
    for(var i=0;i<=id;i++)
    {
     if($('#product_id1-'+i).val() !=null)
      {
    var rate=$('#rate1-'+i).val();
    var quantity=$('#quantity1-'+i).val();
    var subtotal=Number(rate*quantity);
    var s= s+subtotal;
    var reqty=$('#reqty-'+i).val()-$('#quantity1-'+i).val();
    $('#backqty-'+i).val(reqty);
    $('#amount1-'+i).html(subtotal.toFixed(2));
      }
    }
    $('#subtotal11').val(s.toFixed(2));
   $('#subtotall1').html(s.toFixed(2));
   var sub=$('#subtotal11').val();
   if($('#discount_type1').val() !=null)
   {
   var d=sub*(($('#discount_type1').val())/100);
   $('#disc1').html(d.toFixed(2));
   $('#discount1').val(d.toFixed(2));
   }
   var sub=$('#subtotal11').val();
   
//   var tax=$('#taxx').val();
     var tax=0;
   var dis=$('#discount1').val();
   if($('#shipping').val() !=null)
  {
      var discvalue=sub-dis;
//   var taxvalue=Number(discvalue)*(Number($('#shipping').val())/100);
//         $('#taxx').val(taxvalue.toFixed(2));
//         $('#tax').html(taxvalue.toFixed(2));
  }
   
   var g=Number(sub)+Number(tax)-Number(dis);
   
   $('#grand1').html(g.toFixed(2));
   $('#grand_total1').val(g.toFixed(2));
   $('#bal1').html(g.toFixed(2));
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
        var data ='<tr id="r-'+id+'"><td><span class="order-item">'+i+'</span></td><td><input type="text" name="product_name[]" id="product_name-'+id+'" onkeyup="newProduct('+id+');"><input type="hidden" name="product_id[]" id="product_id-'+id+'"><div id="result-div-'+id+'" style="display:none;background: darkturquoise;"></div></td><td><input type="text" name="description[]" id="description-'+id+'"/></td><td><input type="text" name="quantity[]" id="quantity-'+id+'" onkeyup="getTotal('+id+');" onkeypress="return isNumber(event)"/></td><td><span id="creditrate-'+id+'"></span><input type="hidden" name="rate[]" id="rate-'+id+'" onkeyup="getTotal(1);"/></td><td><span id="amount-'+id+'"></span></td><td><button class="delete" id="delete-0" onclick="deteteRow('+id+');"><i class="fa fa-trash" aria-hidden="true"></i></button></td></tr>';
       
       $('tr.last-item-row').before(data);
    }
    
}
function addBlankRowAccept(i)
{
    var id=parseInt($('#acceptid').val())+1;
    if(id < Number(i)+2)
    {
        $('#acceptid').val(id);
        var i=Number(id)+1;
        var data ='<tr id="acceptr-'+id+'"><td><button class="tickmark"></button></td><td><span class="order-item">'+i+'</span></td><td><span id="product_name1-'+id+'"></span><input type="hidden" name="product_id1[]" id="product_id1-'+id+'"><div id="result-div-'+id+'" style="display:none;background: darkturquoise;"></div></td><td><span id="reqqty1-'+id+'"></span></td><td><span id="stockqty1-'+id+'"></span><input type="hidden" name="reqty" id="reqty-'+id+'"></td><td><input type="text" name="quantity1[]" id="quantity1-'+id+'" placeholder="Quantity" onkeyup="getTotal1('+id+');" onkeypress="return isNumber(event)" required/></td><td><input type="text" name="rate1[]" id="rate1-'+id+'" onkeyup="getTotal1('+id+');" placeholder="Rate" onkeypress="return isNumber(event)"/></td><td><span id="amount1-'+id+'"></span></td></tr>';
       
       $('tr.last-item-row1').before(data);
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
$("body").delegate(".UserRow","click",function(){
    $('#email').val($(this).attr("data-email"));
    $('#billing_address').val($(this).attr("data-address"));
    $('#shipping_address').val($(this).attr("data-address"));
    $('#user_name').val($(this).attr("data-name"));
    $('#user_id').val($(this).attr("data-id"));
    $("#result-div-user").css("display","none");
})

function calculateDiscount()
    {
        var disctype=$('#discountt').val();
        var discid=$('#discount_type').val();
        var subtotal=$('#subtotal1').val();
        if(discid !='' && disctype !='')
        {
            if(disctype==1)
            {
             var discount=subtotal*(discid/100);
             $('#disc').html(discount.toFixed(2));
             $('#discount').val(discount.toFixed(2));
            }
            else if(disctype==2)
            {
                
                 var discount=discid;
                if(Number(discount) <= Number(subtotal))
                {
                 $('#disc').html(discount);
                 $('#discount').val(discount);
                }
                else
                {
                    alert("Please Check Discount Value");
                    $('#discount_type').val('');
                    $('#disc').html('0.00');
                    $('#discount_type').focus();
                }
            }
            
        //   var tax=$('#taxx').val();
  var tax=0;
   var dis=$('#discount').val();
   
   var g=Number(subtotal)+Number(tax)-Number(dis);
   
   $('#grand').html(g.toFixed(2));
   $('#grand_total').val(g.toFixed(2));
   $('#bal').html(g.toFixed(2));
        }
    }
function calculateDiscount1()
    {
        var disctype=$('#discountt1').val();
        var discid=$('#discount_type1').val();
        var subtotal=$('#subtotal11').val();
        if(discid !='' && disctype !='')
        {
            if(disctype==1)
                {
                     var discount=subtotal*(discid/100);
                     $('#disc1').html(discount.toFixed(2));
                     $('#discount1').val(discount.toFixed(2));
                }
            else if(disctype==2)
                {
                    
                     var discount=discid;
                    if(Number(discount) <= Number(subtotal))
                    {
                         $('#disc1').html(discount);
                         $('#discount1').val(discount);
                    }
                    else
                    {
                        alert("Please Check Discount Value");
                        $('#discount_type1').val('');
                        $('#disc1').html('0.00');
                        $('#discount_type1').focus();
                    }
                }
            
            //   var tax=$('#taxx').val();
           var tax=0;
           var dis=$('#discount1').val();
           
           var g=Number(subtotal)+Number(tax)-Number(dis);
           
           $('#grand1').html(g.toFixed(2));
           $('#grand_total1').val(g.toFixed(2));
           $('#bal1').html(g.toFixed(2));
        }
    }
function deleteRow(i)
{
    $('#r-'+i).remove();
}
function updatestatus(i,id){
    var status=$(this).val();
    
    if(status==2)
    {
     $.ajax({
                url:"{{admin_url('orders/getstock')}}/"+id,
                type:"GET",
                dataType:"json",
                success:function(data)
                {
                    
                    var len=data.length;
                    if(len >1)
                    {
                        for(var j=1;j<len;j++)
                        {
                            addStockRow();
                        }
                    }
                    $.each(data,function(key,value)
                    {
                        $('#name-'+key).html(value.name);
                        $('#orqty-'+key).html(value.quantity);
                        $('#avqty-'+key).html(value.qty);
                        if((value.quantity-value.qty)>0)
                        {
                        $('#backqty-'+key).html(value.quantity-value.qty)
                        }
                        else
                        {
                        $('#backqty-'+key).html(0)
                        }
                        $('#orderidd').val(value.order_id);
                       
                    });
                    
                   
                    
                    
                     $("#stockModal").css("display","block");
                    
                    
                    
                }
            });
    }
    else
    {
      var url="{{admin_url('orders/updatestatus')}}/"+id+"/"+status;
      
      window.location.href=url;
    }
       
    
        
        
}

// function addStockRow()
// {
//     var id=parseInt($('#stockid').val())+1;
   
//         $('#stockid').val(id);
//         var i=Number(id)+1;
//         var data ='<tr><td>'+i+'</td><td><span id="name-'+id+'"></span></td><td><span id="orqty-'+id+'"></span></td><td><span id="avqty-'+id+'"></span></td><td><span id="backqty-'+id+'"></span></td></tr>';
       
//       $('tr.last-stock-row').before(data);
   
    
// }
function addStockRow()
{
    var id=parseInt($('#stockid').val())+1;
   
        $('#stockid').val(id);
        var i=Number(id)+1;
        var data ='<tr><td>'+i+'</td><td><span id="name-'+id+'"></span><input type="hidden" name="stockprod[]" id="stockprod-'+id+'"></td><td><input type="number" id="backqty-'+id+'" name="backqty[]" class="form-control"></td><td><input type="text" id="backqtyamount-'+id+'" name="backqtyamount[]" class="form-control" placeholder="Please enter amount" onkeypress="return isNumber(event)"></td></tr>';
       
       $('tr.last-stock-row').before(data);
   
    
}
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