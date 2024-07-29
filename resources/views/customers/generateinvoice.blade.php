@extends('layouts.customer')
@section('title','Invoice# '.$invoice->id)
@section('page_title','Sales & Financials')
@section('page_nav')
<ul>
    <li><a href="{{customer_url('orders')}}">All Orders</a></li>
    <li class="active"><a  href="{{customer_url('invoices')}}">Invoices</a>
    <li><a  href="{{customer_url('backorders')}}">Backorders</a></li>
    
</ul>
@endsection
@section('contents')
<div class="content-container">
   <div class="content-area">
      <div class="row">
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-xs-padding">
            <div class="card no-margin minH">
               <div class="card-block">
                  
                 <!-- @if($invoice->grand_total-$invoice->paid_amount >0)-->
                 <!-- <a class="btn btn-success pull-right" id="myBtn">-->
                 <!--                                  <clr-icon shape="amount"></clr-icon>-->
                 <!--                                  Pay Invoice                          -->
                 <!--                               </a>-->
                 <!--@endif-->
                  <a href="{{customer_url('printinvoice')}}/{{$invoice->id}}" class="btn green_button pull-right" target="_blank">
           
                                                   <i class="fa fa-print" aria-hidden="true"></i>
                                                   Print Invoice                          
                                                </a>
                   <a href="{{customer_url('generatePDF')}}/{{$invoice->id}}"
                                                   class="btn green_button pull-right" target="_blank">
                                                   <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                                                   Generate PDF                          
                                                </a>
 <div style="background:white;">
		
		<div style="padding-left:100px">
			<h2>Invoice#<span id="order_no">{{$invoice->id}}</span></h2>
			
		</div>
		
			<div class="row" style="padding-left:100px">
			<div class="col-sm-6">
				<p>
				<label><b>Bill To</b></label>
				<br>
				
				    Mr.{{$invoice->user->firstname}} {{$invoice->user->lastname}}<br>
				    @php $billing = $invoice->order->billing; @endphp
				    
				    @if($billing)
				    {{$billing->address}} <br/> {{$billing->postalcode}}
				    {{$billing->city}} {{$billing->province}}<br/>
				    
				    Phone: {{$billing->phone}}
				    
				    @endif
				</p>
			</div>
			<div class="col-sm-6"><p>
				<label><b>Invoice#: </b></label>
				{{$invoice->invoice_number}}
				<br>
				<label><b>Date: </b></label>
				{{date('F d Y',strtotime($invoice->order->order_date))}}
				<br>
				<label><b>Due Date: </b></label>
				{{date('F d Y',strtotime($invoice->due_date))}}
			</div>
			<div class="clear"></div>
			
			
			<div class="clear"></div>
		</div>
		<hr>
		<div style="padding-left:100px;padding-right:100px">
			<table border="0" style="width:100%">
				<thead>
					<tr style="background-color: aquamarine;text-align:left;">
						<th>#</th>
						<th>SKU</th>
						<th>Product</th>
						<th class="text-right">Rate</th>
						<th class="text-center">Qty</th>
						<th class="text-center">Weight</th>
						<th class="text-right">Sub Total</th>
						
					</tr>
				</thead>
				<tbody>
				    @php $i=1;@endphp
				    @foreach($invoice->order->item as $orderitem)
					<tr style="text-align:left;">
						<td>{{$i}}</td>
						<td>{{$orderitem->product_sku}}</td>
						<td>
						    {{$orderitem->product->name}}
						</td>
						<td class="text-right">
							{{showPrice($orderitem->product->rate)}}
						</td>
						<td class="text-center">
						   {{$orderitem->quantity}}
						</td>
						<td class="text-center">
						   {{$orderitem->weight.defWeight()}} 
						</td>
						<td class="text-right">
							{{showPrice($orderitem->total)}}
						</td>
						
						
					</tr>
					@php $i++; @endphp
				   @endforeach
					<tr>
					    <th colspan="6" class="text-right">Sub Total: </th>
					    <th class="text-right">{{showPrice($invoice->sub_total)}}</th>
					</tr>
					<tr>
					    <th colspan="6"  class="text-right">Discount: </th>
					    <th class="text-right">{{showPrice($invoice->discount)}}</th>
					</tr>
						<tr>
					    <th colspan="6"  class="text-right">Tax: </th>
					    <th class="text-right">{{showPrice($invoice->tax)}}</th>
					</tr>
					</tr>
						<tr>
					    <th colspan="6"  class="text-right">Grand Total: </th>
					    <th class="text-right">{{showPrice($invoice->grand_total)}}</th>
					</tr>
					<tr>
					    <th colspan="6"  class="text-right">Paid Amount: </th>
					    <th  class="text-right">{{showPrice($invoice->paid_amount)}}</th>
					</tr>
					<tr>
					    <th colspan="6"  class="text-right">Due Amount: </th>
					    <th class="text-right">{{showPrice($invoice->grand_total-$invoice->paid_amount)}}</th>
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
	<div id="myModal" class="modal" style="padding-top: 10px;padding:10px;">

  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">&times;</span>
    <div class="popupform">
		
		<div class="headertop">
			<h2>Receive Payment#{{$order->order_id}}</h2>
			
		</div>
		<form action="{{customer_url('order/makepayment')}}" method="post" name="form1" id="form1">
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