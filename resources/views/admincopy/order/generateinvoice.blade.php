@extends('layouts.admin')
@section('title','Order# '.$order->order_id)
@section('page_title','Sales & Financials')
@section('page_nav')
<ul>
    <li><a href="{{admin_url('orders')}}">All Orders</a></li>
    <li class="active"><a  href="{{admin_url('invoices')}}">Invoices</a>
</ul>
@endsection
<style>
    .tickmark {
    background-image: url(../../../img/tick.png);
    width: 25px;
    height: 25px;
    background-repeat: no-repeat;
    background-color: transparent;
    border: none;
}
.delete {
    background-image: url(../../../img/delete.png);
    width: 25px;
    height: 25px;
    background-repeat: no-repeat;
    background-color: transparent;
    border: none;
}
</style>
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
                                                 <div class="row">
                                                     <div class="col-sm-5">
                                                        <button type="submit" class="btn"  placeholder="Billing">Billing</button>
                                                     </div>
                                                   
                                                     <div class="col-sm-3">
                                                            <button type="submit" class="btn"  placeholder="Billing">Order Details</button>
                                                      </div>
                                                        
                                                 </div>
                                             
                                             </td>
                                             
                                          </tr>
                                       </thead>
                                       
                                       </thead>
                                       <tbody>
                                  
                                    </table>
                                 </div>
                  
                  
               
 <div style="background:white;">
		
		<div style="padding-left:100px">
			<h2>Order<span id="order_no"></span></h2>
			
		</div>
	
			<div class="row" style="padding-left:100px">
			<div class="col-sm-6">
				<p>
				<label><b>Bill To</b></label>
				<br>
				    Mr.{{$customer->firstname}} {{$customer->lastname}}<br>
				    {{$order->billing_address}}
				</p>
			</div>
			<div class="col-sm-6"><p>
				<label><b>Order#: </b></label>
				{{$order->order_id}}
				<br>
				<label><b>Date: </b></label>
				{{date('F d Y',strtotime($order->order_date))}}
				<br>
				<label><b>Due Date: </b></label>
				{{date('F d Y',strtotime($order->due_date))}}
			</div>
			<div class="clear"></div>
			
			
			<div class="clear"></div>
		</div>
		<hr>
		<div style="padding-left:100px;padding-right:100px">
			<table border="0" style="width:100%">
				<thead>
					<tr>
						
						<th>#</th>
						
						<th>PRODUCT/SERVICE</th>
						
						<th>REQ QTY</th>
						<th>STOCK</th>
						<th>QTY</th>
						<th>AMOUNT</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
				    @php $i=1;@endphp
				    @foreach($orderitems as $orderitem)
					<!--<tr style="text-align:left;">-->
					<!--	<td>{{$i}}</td>-->
						
					<!--	<td>-->
					<!--	    {{$orderitem->name}}-->
					<!--	</td>-->
					<!--	<td>-->
					<!--		{{$orderitem->description}}-->
					<!--	</td>-->
					<!--	<td>-->
					<!--	   {{$orderitem->quantity}}-->
					<!--	</td>-->
					<!--	<td>-->
					<!--		{{$orderitem->rate}}-->
					<!--	</td>-->
						
						
					<!--</tr>-->
					<tr id="r-{{$i}}">
						
						<td class="text-center"><span class="order-item">{{$i}}</span></td>
						
						<td class="text-center">
						    <span>{{$orderitem->name}}</span>
						    <input type="hidden" name="product_id[]" id="product_id-{{$i}}" value="{{$orderitem->product_id}}">
						    <div id="result-div-{{$i}}" style="display:none;background: darkturquoise;"></div>
				
							<!--<input type="text" name="prodservice"/>-->
						</td>
						
						<td class="text-center">
						    <span>{{$orderitem->quantity}}</span>
							
						</td>
						<td class="text-center">
						    @php 
						    $stock=$stocks->where('product_id',$orderitem->product_id)->first();
						    $s=isset($stock->quantity) ? $stock->quantity : 0;
						    @endphp
						    <span>{{$s}}</span>
							
						</td>
						<td class="text-center">
							<input type="number" name="rate[]" id="rate-0" value="@if($orderitem->quantity > $s){{$s}}@else{{$orderitem->quantity}}@endif" onkeyup="getTotal(1);" max="@if($orderitem->quantity > $s) {{$s}} @else {{$orderitem->quantity}} @endif"/>
						</td>
						<td class="text-center">
							<input type="text" name="rate[]" id="rate-0" value="@if($orderitem->quantity > $s){{$s * $orderitem->rate}}@else{{$orderitem->quantity * $orderitem->rate}}@endif" onkeyup="getTotal(1);"/>
						</td>
						
					</tr>
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
			<h2>Receive Payment#{{$order->order_id}}</h2>
			
		</div>
		<form action="{{admin_url('order/makepayment')}}" method="post" name="form1" id="form1">
		    @csrf
		     <input type="hidden" name="_method" value="POST" id="form-method" />
		    <input type="hidden" name="order_id" value="{{$order->id}}" id="order_id">
		    <input type="hidden" name="user_id" value="{{$order->user_id}}" id="user_id">
			<div class="top-section">
			<div class="col-md-6">
				<p>
				<label>Customer</label>
				{{$customer->firstname}} {{$customer->lastname}}
				</p>
			</div>
			<div class="col-md-6"><p>
				<label>Customer email</label>
				{{$customer->email}}</p>
			</div>
			<div class="clear"></div>
			<div class="col-md-6">
				<p><label>Memo</label>
				<textarea name="memo" rows="5" cols="35" id="memo"></textarea></p>
				
			</div>
			<div class="col-md-6 topsectright">
				<div class="col-md-6">
						<p><label>Payment Date</label>
						<input type="date" name="payment_date" id="payment_date" required/></p>
				</div>
				<div class="col-md-6">
						<p><label>Payment Method</label>
						<select name="payment_method" id="payment_method" required>
							<option value="" disabled selected>Select Method</option>
							<option value="1">Credit Card</option>
							<option value="2">Debit Card</option>
							<option value="3">Cheque</option>
							<option value="4">Cash</option>
						</select>
					</p>
				</div>
				<div class="clear"></div>
				<div class="col-md-4">
						<p><label>Balance Due</label>
						{{$order->grand_total-$order->paid_amount}}
						<input type="hidden" name="am" id="am" value="{{$order->grand_total-$order->paid_amount}}">
					</p>
				</div>
				<div class="col-md-4">
						<p><label>Amount Received</label>
						<input type="text" name="amount_received" id="amount_received" required/>
				</div>
				
				<div class="clear"></div>
		
			</div>
			<div class="clear"></div>
		</div>
		
			
			<div class="footerform">	
				 <button type="submit" value="Submit">Save</button>
			</div>
		</form>
	</div>
	</div>
	</div>
	<script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js" ></script>
<script>
$(document).ready(function() {
	 $('#myBtn').click(function(){
                        
   $('#myModal').css('display', 'block');
});
$('.close').click(function(){
   $('#myModal').css('display', 'none');
});
$('#amount_received').change(function(){
    var amount=$(this).val();
    var tot=$('#am').val();
    if(Number(tot) < Number(amount))
    {
        alert("Please check the amount");
        $('#amount_received').val("");
        $('#amount_received').focus();
    }
    });
});
</script>
@endsection