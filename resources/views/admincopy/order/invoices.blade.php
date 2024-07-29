@extends('layouts.admin')
@section('title','Invoices')
@section('page_title','Sales & Financials')
@section('page_nav')
<ul>
    <li><a href="{{admin_url('orders')}}">All Orders</a></li>
    <li class="active"><a  href="{{admin_url('invoices')}}">Invoices</a>
</ul>
@endsection
@section('contents')
<div class="content-container">
   <div class="content-area">
      <div class="row">
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-xs-padding">
            <div class="card no-margin minH">
               <div class="card-block">
                  
                  <section class="card-text">
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
                                    <table class="table table-list mt-0">
                                       <thead class="table-list-header-options">
                                          <tr>
                                             <td colspan="5">
                                                
                                             </td>
                                             <td colspan="5">

                                             <!--<button id="myBtn">Open Modal</button>-->
                                             <button id="myBtn" class="btn btn-success pull-right"><clr-icon shape="plus-circle"></clr-icon>
                                                Sales Receipt
                                                </button>
                                                <button id="myBtn1" class="btn btn-success pull-right"><clr-icon shape="plus-circle"></clr-icon>
                                                Credit Memo
                                                </button>
                                               
                                               
                                               
                                                
                                             </td>
                                          </tr>
                                       </thead>
                                       <thead>
                                          <tr>
                                             <th class="text-left">ID</th>
                                             <th class="text-left">
                                                Date
                                             </th>
                                             <th class="text-left">
                                                No
                                             </th>
                                             <th class="text-left">
                                                Customer
                                             </th>
                                             <th class="text-left">
                                                Amount
                                             </th>
                                             
                                             <th class="text-left">
                                                Due Amount
                                             </th>
                                             <th class="text-right">Actions</th>
                                          </tr>
                                        </thead>
                                        
                                        <tbody>
                                          @foreach($orders as $order)
                                          <tr>
                                             <td class="text-left">{{$order->id}}</td>
                                             <td class="text-left">
                                                {{date('d F Y',strtotime($order->order_date))}}
                                             </td>
                                             <td class="text-left">
                                                {{$order->order_id}}
                                             </td>
                                             <td class="text-left">
                                                {{$order->firstname}} {{$order->lastname}}
                                             </td>
                                             <td class="text-left">
                                               {{$order->grand_total}}
                                             </td>
                                             
                                             <td class="text-left" >
                                               {{$order->grand_total-$order->paid_amount}}
                                             </td>
                                             <td class="text-right">
                                                  <label>
                                                   @if($order->status==0)
                                                   <a target="" href="{{admin_url('orders/changestatus')}}/{{$order->id}}" data-tooltip="Confirm Order" rel="tooltip">
                                                      <clr-icon shape="check" size="22"></clr-icon>
                                                   </a>
                                                   <button class="edit_modal" value="{{$order->id}}"><clr-icon shape="pencil" size="22"></clr-icon></button>
                                                   <!--<a target="" href="{{admin_url('orders')}}/{{$order->id}}/edit" class="icon-table" rel="tooltip" data-tooltip=" Edit">-->
                                                   <!--   <clr-icon shape="pencil" size="22"></clr-icon>-->
                                                   <!--</a>-->
                                                    @else
                                                    <label>
                                                   <a target="" href="{{admin_url('orders')}}/{{$order->id}}/generateinvoice" class="icon-table" rel="tooltip" data-tooltip="View Invoice">
                                                      <clr-icon shape="list" size="22"></clr-icon>
                                                   </a>
                                                </label>
                                                   @endif
                                                </label>
                                                <label>
                                                   <a target="" href="{{admin_url('invoices')}}/{{$order->id}}/del" class="icon-table" rel="tooltip" data-tooltip=" Delete">
                                                      <clr-icon shape="trash" size="22"></clr-icon>
                                                   </a>
                                                </label>
                                             </td>
                                          </tr>
                                          @endforeach
                                       
                                       </tbody>
                                    </table>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </section>
                  </section>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<div id="myModal" class="modal" style="padding-top: 10px;padding:10px;">

  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">&times;</span>
    <div class="popupform">
		
		<div class="headertop">
			<h2>Sale Receipt No.<span id="sales_receipt_no">{{$order_no+1}}</span></h2>
			
		</div>
		<form action="" method="post" name="form1" id="form1">
		    @csrf
		     <input type="hidden" name="_method" value="POST" id="form-method" />
		    <input type="hidden" name="sales_receipt_no" value="{{$order_no+1}}" id="sales_receipt_no">
			<div class="top-section">
			<div class="col-md-6">
				<p>
				<label>Customer</label>
				<select name="user_id" id="user_id" required>
    				<option value="" disabled selected>Select a Customer</option>
    				@foreach($customers as $customer)
    				<option value="{{$customer->id}}">{{$customer->firstname}} {{$customer->lastname}}
    				    </option>
    			@endforeach
				</select>	</p>
			</div>
			<div class="col-md-6"><p>
				<label>Customer email</label>
				<input type="text" placeholder="Email" id="email" name="email" required/></p>
			</div>
			<div class="clear"></div>
			<div class="col-md-6">
				<p><label>Billing address</label>
				<textarea name="billing_address" rows="5" cols="35" id="billing_address" required></textarea></p>
				<p><label>Shipping To</label>
				<textarea name="shipping_address" rows="5" cols="35" id="shipping_address" required></textarea></p>
			</div>
			<div class="col-md-6 topsectright">
				<div class="col-md-6">
						<p><label>Sales Receipt Date</label>
						<input type="date" name="sales_receipt_date" id="sales_receipt_date" required/></p>
				</div>
				
				<div class="clear"></div>
				<div class="col-md-4">
						<p><label>Ship Via</label>
						<input type="text" name="shipping_id" id="shipping_id" required/></p>
				</div>
				<div class="col-md-4">
						<p><label>Shipping Date</label>
						<input type="date" name="shipping_date" id="shipping_date" required/>
				</div>
				<div class="col-md-4">
						<p><label>Tracking No.</label>
						<input type="text" name="tracking_code" id="tracking_code" required/></p>
				</div>
				<div class="clear"></div>
				<div class="col-md-6">
						<p><label>P.O Number</label>
						<input type="text" name="ponumber" id="ponumber"/></p>
				</div>
				<div class="col-md-6">
						<p><label>Sales Rep</label>
						<input type="text" name="salesrep" id="salesrep"/></p>
				</div>
				<div class="col-md-6">
						<p><label>Payment Method</label>
						<input type="text" name="payment_method" id="payment_method"/></p>
				</div>
				<div class="clear"></div>
		
			</div>
			<div class="clear"></div>
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
						<th>AMOUNT</th>
						<th>SALES TAX</th>
						<th></th>
					</tr>
				</thead>
				<tbody id="sr-items">
					<tr id="r-0">
						<td><button class="tickmark"></button></td>
						<td><span class="sr-item">1</span></td>
						
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
							<input type="text" name="rate[]" id="rate-0" onkeyup="getTotal(1);"/>
						</td>
						<td>
							<span id="amount-0"></span>
						</td>
						<td>
							<a href=""><button class="delete"></button></a>
						</td>
					</tr>
					<tr class="last-item-row" ></tr>
                    <tr><td colspan="8"></td></tr>
					
					
				</tbody>

			</table>
		</div>
			<div class="bottomsection">
				<div class="bottomleft">
					<div class="blfirst">
							<!--<button>Add lines</button>-->
							<button>Clear All lines</button>
							<button>Add Subtotal</button>
					</div>
					<div class="blsecond">
						<label>Message displayed on invoice</label>
							<textarea rows="6" cols="43" name="message" id="message"></textarea>
						
					</div>
				</div>
				<div class="bottomright">
					<div class="brfirst">
							<p>Sub Total<span id="subtotal">$0.00</span></p>
							<p><select name="discount_type" id="discount_type">
    								<option value="" disabled selected>Discount Percent</option>
    								<option value="5">5%</option>
    								<option value="10">10%</option>
							</select>
							
							<span id="disc">$0.00</span>
							</p>
							<p> Shipping
							<select id="shipping" name="shipping" id="shipping">
    								<option value="" disabled selected>Select shipping tax</option>
    								<option value="5%">5%</option>
    								<option value="10%">10%</option>
							</select>
							<span class="sptax"><input type="text"  name="tax1" id="taxx" value="0"/></span>
							</p>
						
					</div>
					<div class="brsecond">
						<p>Total: <span id="grand">$0.00</span></p>
						<p>Balance Due: <span id="bal">$0.00</span></p>
						
					</div>
					<input type="hidden" id="grand_total" name="grand_total" value="0">
					<input type="hidden" id="subtotal1" name="subtotal1" value="0">
					<input type="hidden" id="discount" name="discount" value="0">
					<input type="hidden" id="id" name="id" value="-1">
				</div>
				<div class="clear"></div>

			</div>
			<div class="footerform">	
				 <button type="submit" value="Submit">Save and Send</button>
			</div>
		</form>
	</div>
	</div>
	</div>
<div id="myModal1" class="modal" style="padding-top: 10px;padding:10px;">

  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">&times;</span>
    <div class="popupform">
		
		<div class="headertop">
			<h2>Credit Memo No.<span id="credit_memo_no">{{$order_no+1}}</span></h2>
			
		</div>
		<form action="" method="post" name="form2" id="form2">
		    @csrf
		     <input type="hidden" name="_method" value="POST" id="form-method1" />
		    <input type="hidden" name="credit_memo_no" value="{{$order_no+1}}" id="credit_memo_no">
			<div class="top-section">
			<div class="col-md-6">
				<p>
				<label>Customer</label>
				<input type="text" name="memouser_name" id="memouser_name">
				<div id="result-div-user" style="display:none;"></div>
				<input type="hidden" name="memouser_id" id="memouser_id">
				
				<!--<select name="memouser_id" id="memouser_id" required>-->
    <!--				<option value="" disabled selected>Select a Customer</option>-->
    <!--				@foreach($customers as $customer)-->
    <!--				<option value="{{$customer->id}}">{{$customer->firstname}} {{$customer->lastname}}-->
    <!--				    </option>-->
    <!--			@endforeach-->
				<!--</select>	-->
				</p>
			</div>
			<div class="col-md-6"><p>
				<label>Customer email</label>
				<input type="text" placeholder="Email" id="memoemail" name="memoemail" required/></p>
			</div>
			<div class="clear"></div>
			<div class="col-md-6">
				<p><label>Billing address</label>
				<textarea name="memobilling_address" rows="5" cols="35" id="memobilling_address" required></textarea></p>
				
			</div>
			<div class="col-md-6 topsectright">
				<div class="col-md-6">
						<p><label>Credit Memo Date</label>
						<input type="date" name="credit_memo_date" id="credit_memo_date" required/></p>
				</div>
				
				
				<div class="clear"></div>
				<div class="col-md-6">
						<p><label>P.O Number</label>
						<input type="text" name="memoponumber" id="memoponumber"/></p>
				</div>
				<div class="col-md-6">
						<p><label>Sales Rep</label>
						<input type="text" name="memosalesrep" id="memosalesrep"/></p>
				</div>
				<div class="clear"></div>
		
			</div>
			<div class="clear"></div>
		</div>
		<div class="middlesection" width="100%">
			<table >
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
				<tbody id="invoice-items">
					<tr>
						<td><button class="tickmark"></button></td>
						<td><span class="invoice-item">1</span></td>
						
						<td>
						    <input type="text" name="memoproduct_name[]" id="memoproduct_name-0" onkeyup="newProduct(0);">
						    <input type="hidden" name="memoproduct_id[]" id="memoproduct_id-0">
						    <div id="result-div-0" style="display:none;"></div>
						    
						</td>
						<td>
							<input type="text" name="memodescription[]" id="memodescription-0"/>
							
						</td>
						<td>
							<input type="number" name="memoquantity[]" id="memoquantity-0" onkeyup="getTotal1(1);" required/>
						</td>
						<td><span id="creditrate-0" style="display:none;"></span>
							<input type="text" name="memorate[]" id="memorate-0" onkeyup="getTotal1(1);"/>
						</td>
						<td>
							<span id="memoamount-0"></span>
						</td>
						
						<td>
							<button class="delete" id="delete-0" value="0"></button>
						</td>
						
					</tr>
					
					
					<tr class="last-item-row1">
                    </tr>
                    <tr><td colspan="8"></td></tr>
					
					
				</tbody>
			</table>
		</div>
			<div class="bottomsection">
				<div class="bottomleft">
					<div class="blfirst" style="display:none;">
							<!--<button>Add lines</button>-->
							<button>Clear All lines</button>
							<button>Add Subtotal</button>
					</div>
					<div class="blsecond">
						<label>Message displayed on credit memo</label>
							<textarea rows="6" cols="43" name="message1" id="message1"></textarea>
						
					</div>
				</div>
				<div class="bottomright">
					<div class="brfirst">
							<p>Sub Total<span id="subtotal12">$0.00</span></p>
							<p>Discount<select name="discountt" id="discountt" onchange="calculateDiscount();">
    								
    								<option value="1">Discount Percentage</option>
    								<option value="2">Discount Amount</option>
    								<!--<option value="5">5%</option>-->
    								<!--<option value="10">10%</option>-->
							</select>
							<span style="width:5%;"><input type="text" id="discount_type1" name="discount_type1" onchange="calculateDiscount();"></span>
							<span id="disc1">$0.00</span>
							</p>
							<p> Shipping
							<select id="cashmemoshipping" name="cashmemoshipping">
    								<option value="" disabled selected>Select shipping tax</option>
    								<option value="0">0%</option>
    								<option value="13">HST on 13%%</option>
							</select>
							<span class="sptax" id="cashmemotax">$0.00</span><input type="hidden"  name="taxx1" id="taxx1" value="0"/>
							</p>
						
					</div>
					<div class="brsecond">
						<p>Total: <span id="grand1">$0.00</span></p>
						<p>Balance Due: <span id="bal1">$0.00</span></p>
						
					</div>
					<input type="hidden" id="grand_total1" name="grand_total1" value="0">
					<input type="hidden" id="subtotal11" name="subtotal11" value="0">
					<input type="hidden" id="discount1" name="discount1" value="0">
					<input type="hidden" id="id1" name="id1" value="0">
				</div>
				<div class="clear"></div>

			</div>
			<div class="footerform">	
				 <button type="submit" value="Submit">Save and Send</button>
			</div>
		</form>
	</div>
	</div>
	</div>
<script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js" ></script>
<script>
$(document).ready(function() {
   $('#addrecieptproduct').on('click', function () {
       var id=parseInt($('#id').val())+1;
       $('#id').val(id);
       var i=Number(id)+1;
       var data ='<tr><td><button class="tickmark"></button></td><td>'+i+'</td><td><select name="product_id[]" id="product_id-'+id+'" required><option value="" disabled selected>Select a Product</option>@foreach($products as $product)<option value="{{$product->id}}">{{$product->name}}</option>@endforeach</select></td><td><input type="text" name="description[]" id="description-'+id+'"/></td><td><input type="number" name="quantity[]" id="quantity-'+id+'" onkeyup="getTotal(1);" required/></td><td><input type="text" name="rate[]" id="rate-'+id+'" onkeyup="getTotal(1);"/></td><td><input type="number" name="tax[]" id="tax-'+id+'" onkeyup="getTotal(1);"/></td><td><button class="delete"></button></td></tr>';
       $('tr.last-item-row').before(data);
        $('#product_id-'+id).change(function(){
        var prodid=$(this).val();
        if(prodid)
        {
            $.ajax({
                url:"{{admin_url('orders/getdetails')}}/"+prodid,
                type:"GET",
                dataType:"json",
                success:function(data)
                {
                    //alert(data);
                    $.each(data,function(key,value)
                    {
                        var rate=value.price;
                        
                        $('#rate-'+id).val(rate);
                        $('#description-'+id).val(value.description);
                       
                    });
                }
            });
        }
    });
    
   });
    $('#user_id').change(function(){
        var custid=$(this).val();
        
        if(custid)
        {
            $.ajax({
                url:"{{admin_url('orders/getcustdetails')}}/"+custid,
                type:"GET",
                dataType:"json",
                success:function(data)
                {
                    //alert(data);
                    $.each(data,function(key,value)
                    {
                        var email=value.email;
                        $('#email').val(email);
                        $('#billing_address').val(value.address);
                      
                    });
                }
            });
        }
        //alert(custid);
    });
    $('#memouser_name').on('keyup',function(){
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
        //alert(custid);
    });
   
    $('#product_id-0').change(function(){
        var prodid=$(this).val();
        if(prodid)
        {
            $.ajax({
                url:"{{admin_url('orders/getdetails')}}/"+prodid,
                type:"GET",
                dataType:"json",
                success:function(data)
                {
                    //alert(data);
                    $.each(data,function(key,value)
                    {
                        var rate=value.price;
                        
                        $('#rate-0').val(rate);
                        $('#description-0').val(value.description);
                        
                    });
                }
            });
        }
    });
    $('#product_id-m').click(function(){
       
            var id=parseInt($('#id').val())+1;
            $('#id').val(id);
            var i=Number(id)+1;
            var data ='<tr><td><button class="tickmark"></button></td><td>'+i+'</td><td><select name="product_id[]" id="product_id-'+id+'" required><option value="" disabled selected>Select a Product</option>@foreach($products as $product)<option value="{{$product->id}}">{{$product->name}}</option>@endforeach</select></td><td><input type="text" name="description[]" id="description-'+id+'"/></td><td><input type="number" name="quantity[]" id="quantity-'+id+'" onkeyup="getTotal(1);" required/></td><td><input type="text" name="rate[]" id="rate-'+id+'" onkeyup="getTotal(1);"/></td><td><input type="number" name="tax[]" id="tax-'+id+'" onkeyup="getTotal(1);"/></td><td><button class="delete"></button></td></tr>';
       $('tr.last-item-row').before(data);
        $('#product_id-'+id).change(function(){
        var prodid=$(this).val();
        if(prodid)
        {
            $.ajax({
                url:"{{admin_url('orders/getdetails')}}/"+prodid,
                type:"GET",
                dataType:"json",
                success:function(data)
                {
                    //alert(data);
                    $.each(data,function(key,value)
                    {
                        var rate=value.price;
                        
                        $('#rate-'+id).val(rate);
                        $('#description-'+id).val(value.description);
                        
                       
                    });
                    
                }
            });
        }
    });
    $('#product_id-'+id).focus();
        });
    
    
        
    
    
    
     $('#discount_type').change(function(){
        var discid=$(this).val();
        var subtotal=$('#subtotal1').val();
        if(discid)
        {
           var discount=subtotal*(discid/100);
           $('#disc').html(discount.toFixed(2));
           $('#discount').val(discount.toFixed(2));
           var tax=$('#taxx').val();
  
   var dis=$('#discount').val();
   
   var g=Number(subtotal)+Number(tax)-Number(dis);
   
   $('#grand').html(g.toFixed(2));
   $('#grand_total').val(g.toFixed(2));
   $('#bal').html(g.toFixed(2));
        }
        
        
    });
//     $('#discount_type1').change(function(){
//         var disctype=$('#discountt').val();
//         var discid=$(this).val();
//         var subtotal=$('#subtotal11').val();
//         if(disctype)
//         {
//             if(disctype==1)
//             {
//              var discount=subtotal*(discid/100);
//              $('#disc1').html(discount.toFixed(2));
//              $('#discount1').val(discount.toFixed(2));
//             }
//             else
//             {
//              var discount=discid;
//              $('#disc1').html(discount);
//              $('#discount1').val(discount);
//             }
//           var tax=$('#taxx1').val();
  
//   var dis=$('#discount1').val();
   
//   var g=Number(subtotal)+Number(tax)-Number(dis);
   
//   $('#grand1').html(g.toFixed(2));
//   $('#grand_total1').val(g.toFixed(2));
//   $('#bal1').html(g.toFixed(2));
//         }
        
        
//     });
    
//     $('#discountt').change(function(){
//         var discid=$('#discount_type1').val();
//         var disctype=$(this).val();
//         var subtotal=$('#subtotal11').val();
//         if(discid !='')
//         {
//             if(disctype==1)
//             {
//              var discount=subtotal*(discid/100);
//              $('#disc1').html(discount.toFixed(2));
//              $('#discount1').val(discount.toFixed(2));
//             }
//             else
//             {
//              var discount=discid;
//              $('#disc1').html(discount);
//              $('#discount1').val(discount);
//             }
            
//           var tax=$('#taxx1').val();
  
//   var dis=$('#discount1').val();
   
//   var g=Number(subtotal)+Number(tax)-Number(dis);
   
//   $('#grand1').html(g.toFixed(2));
//   $('#grand_total1').val(g.toFixed(2));
//   $('#bal1').html(g.toFixed(2));
//         }
        
        
//     });
    $('#cashmemoshipping').change(function(){
        var shippingtax=$(this).val();
        var discount=$('#discount1').val();
        var subtotal=$('#subtotal11').val();
        var disctotal=Number(subtotal)-Number(discount);
        var taxvalue=Number(disctotal)*(Number(shippingtax)/100);
        var taxamount=Number(disctotal)+Number(taxvalue);
        $('#taxx1').val(taxvalue.toFixed(2));
        $('#cashmemotax').html(taxvalue.toFixed(2));
        getTotal1();

        
        
    }); 
   
   
//   $('#delete-0').on('click',function(){
//       var id=$(this).val();
      
//       $('#r-'+id).remove(); 
//   });
    $('#myBtn').click(function(){
                    
   $('#myModal').css('display', 'block');
});
$('.close').click(function(){
   $('#myModal').css('display', 'none');
});
 $('#myBtn1').click(function(){
                   
   $('#myModal1').css('display', 'block');
});
$('.close').click(function(){
   $('#myModal1').css('display', 'none');
});
});
function getTotal(j)
{
    var s=0;
    var t=0;
    var id=parseInt($('#id').val());
    for(var i=0;i<=id;i++)
    {
    var rate=$('#rate-'+i).val();
    var tax=$('#tax-'+i).val();
    var quantity=$('#quantity-'+i).val();
    var subtotal=Number(rate*quantity);
    var s= s+subtotal;
    var ta=subtotal*(Number(tax)/100);
    t=t+ta;
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
   
   var tax=$('#taxx').val();
  
   var dis=$('#discount').val();
   
   var g=Number(sub)+Number(tax)-Number(dis);
   
   $('#grand').html(g.toFixed(2));
   $('#grand_total').val(g.toFixed(2));
   $('#bal').html(g.toFixed(2));
}
function getTotal1(j)
{
    
    var s=0;
    var t=0;
    var id=parseInt($('#id1').val());
  
    for(var i=0;i<id;i++)
    {
      if($('#memoproduct_id-'+i).val() !=null)
      {
    var rate=$("#memorate-"+i).val();
    var quantity=$("#memoquantity-"+i).val();
    
    var subtotal=Number(rate*quantity);
    var s= s+subtotal;
    $('#memoamount-'+i).html(subtotal.toFixed(2));
      }
    
    }
    
    $("#subtotal11").val(s.toFixed(2));
   $("#subtotal12").html(s.toFixed(2));
   var sub=$('#subtotal11').val();
  if($('#discount_type1').val() !=null)
  {
  var d=sub*(($('#discount_type1').val())/100);
  $('#disc1').html(d.toFixed(2));
  $('#discount1').val(d.toFixed(2));
  }
  
 
  

  var dis=$('#discount1').val();
  if($('#cashmemoshipping').val() !=null)
  {
      var discvalue=sub-dis;
  var taxvalue=Number(discvalue)*(Number($('#cashmemoshipping').val())/100);
        $('#taxx1').val(taxvalue.toFixed(2));
        $('#cashmemotax').html(taxvalue.toFixed(2));
  }
 var tax=$('#taxx1').val();
  var g=Number(sub)+Number(tax)-Number(dis);
 
  $('#grand1').html(g.toFixed(2));
  $('#grand_total1').val(g.toFixed(2));
  $('#bal1').html(g.toFixed(2));
}
function newProduct(i)
{
     var prodid=$('#memoproduct_name-'+i).val();
        
        
             
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
    
                        dropdown+= '<li><a href="#" class="productRow" data-id="'+value.id+'" data-name="'+value.name+'" data-description="'+value.description+'" data-price="'+value.price+'" data-rowid="'+id+'">'+value.name+'</a><li>';
                       
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
    var id=parseInt($('#id1').val())+1;
     
    if(id < Number(i)+2)
    {
        $('#id1').val(id);
        var i=Number(id)+1;
        var data ='<tr id="r-'+id+'"><td><button class="tickmark"></button></td><td><span class="invoice-item">'+i+'</span></td><td><input type="text" name="memoproduct_name[]" id="memoproduct_name-'+id+'" onkeyup="newProduct('+id+');"><input type="hidden" name="memoproduct_id[]" id="memoproduct_id-'+id+'"><div id="result-div-'+id+'" style="display:none;"></div></td><td><input type="text" name="memodescription[]" id="memodescription-'+id+'"/></td><td><input type="number" name="memoquantity[]" id="memoquantity-'+id+'" onkeyup="getTotal1(1);" required/></td><td><span id="creditrate-'+id+'"></span><input type="hidden" name="memorate[]" id="memorate-'+id+'" onkeyup="getTotal1(1);"/></td><td><span id="memoamount-'+id+'"></span></td><td><button class="delete" id="delete-'+id+'" onclick="deteteRow('+id+');"></button></td></tr>';
       $('tr.last-item-row1').before(data);
    }
    
    regenerateRows();
}

$("body").delegate(".productRow","click",function(){
    var i=$(this).attr("data-rowid");
    $("#memoproduct_name-"+i).val($(this).attr("data-name"));
    $("#memoproduct_id-"+i).val($(this).attr("data-id"));
    $("#memorate-"+i).val($(this).attr("data-price"));
    $("#memoquantity-"+i).val(1);
    $("#memodescription-"+i).val($(this).attr("data-description"));
    $("#creditrate-"+i).html($(this).attr("data-price"));
    $("#memoamount-"+i).html($(this).attr("data-price"));
    $("#result-div-"+i).css("display","none");
    
    addBlankRow(i);
    getTotal1();
})
$("body").delegate(".UserRow","click",function(){
    $('#memoemail').val($(this).attr("data-email"));
    $('#memobilling_address').val($(this).attr("data-address"));
    $('#memouser_name').val($(this).attr("data-name"));
    $('#memouser_id').val($(this).attr("data-id"));
    $("#result-div-user").css("display","none");
})
function deteteRow(i)
{
      $('#r-'+i).remove(); 
      regenerateRows();
      getTotal1();

}
function regenerateRows(){
       var rowCounter = 1;
       $("#invoice-items tr").each(function() {
            $(this).find("span.invoice-item").text(rowCounter);
            rowCounter++;
       });
   }
function calculateDiscount()
    {
        var disctype=$('#discountt').val();
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
           var tax=$('#taxx1').val();
  
   var dis=$('#discount1').val();
   
   var g=Number(subtotal)+Number(tax)-Number(dis);
   
   $('#grand1').html(g.toFixed(2));
   $('#grand_total1').val(g.toFixed(2));
   $('#bal1').html(g.toFixed(2));
        }
    }
</script>
@endsection