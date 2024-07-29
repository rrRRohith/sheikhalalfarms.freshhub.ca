<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css')}}">
    <script src="{{ asset('vendors/jquery/js/jquery.min.js?v=2.1')}}"></script>
    <script type="text/javascript" src="{{ asset('js/bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery-2.2.4.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/jquery.printPage.js')}}"></script>
</head>
<style>

.table {
  font-family: 'Open Sans', sans-serif
}  
</style>
<body style="background-color:#ffffff;color:#000000;">
    <div class="container mt-5">
        <h2 class="text-center mb-3"></h2>
      
        <div class="logo text-center padding-side-30">
            <img src="{{asset('img/freshhub_logo.png')}}" alt="FreshHub logo" style="width:250px;height:auto;">
        </div>
        <h2 class="text-center"><label class="font-weight-bold" style="font-family: 'Open Sans', sans-serif;font-size:25px;">Invoice</label></h2>
        <div class="row">
            	<div class="col-sm-6">
    				<p class="" style="font-family: 'Open Sans', sans-serif;font-size:20px;">
        			   <label style="color:#000000;font-weight:600;">Bill To</label>
        			   <br>
        				    Mr.{{$invoice->user->firstname}} {{$invoice->user->lastname}}<br>
        				    {{$invoice->order->billing->address}}, <br>
        				    {{$invoice->order->billing->city}},{{$invoice->order->billing->province}},<br>
        				    {{$invoice->order->billing->postalcode}}
    				</p>
		    	</div>
		    	<div class="col-sm-6 text-right">
    				<p class="" style="font-family: 'Open Sans', sans-serif;font-size:20px;">
        			   <label style="color:#000000;font-weight:600;">Ship To</label>
        			   <br>
        				    Mr.{{$invoice->user->firstname}} {{$invoice->user->lastname}}<br>
        				    {{$invoice->order->delivery->address}}, <br>
        				    {{$invoice->order->delivery->city}},{{$invoice->order->delivery->province}},<br>
        				    {{$invoice->order->delivery->postalcode}}
    				</p>
		    	</div>
		    	<br>
            	<div class="col-sm-12 text-right"><p style="font-family: 'Open Sans', sans-serif;font-size:20px;">
    				<!--<label><b>Invoice#: </b></label>-->
    				<b>Invoice#: </b>
    			    	{{$invoice->invoice_number}}
    				<br>
    				<!--<label><b>Date: </b></label>-->
    				<b>Date: </b>
    				    {{date('d M Y',strtotime($invoice->order->order_date))}}
    				<br>
    				<!--<label><b>Due Date: </b></label>-->
    				<b>Due Date: </b>
    			    	{{date('d M Y',strtotime($invoice->due_date))}}
			    </div>
		
        </div>
        <br>
        <table class="table table-bordered mb-4 table-sm" style="text-align: center;">
			<thead>
				<tr class="font-weight-bold"style="font-size:18px;">
					<th>#</th>
					<th>PRODUCT/SERVICE</th>
					<th>DESCRIPTION</th>
					<th class="text-center">QUANTITY</th>
					<th>WEIGHT</th>
					<th class="text-right">AMOUNT</th>
				</tr>
			</thead>
			<tbody style="font-size:15px;">
			    @php $i=1;@endphp
			    @foreach($invoice->order->item as $orderitem)
				<tr  class="font-weight-normal" style="text-align:center;">
					<td>{{$i}}</td>
					<td>{{$orderitem->product->name}}</td>
					<td>{{$orderitem->product->description}}</td>
					<td  class="text-center">{{$orderitem->quantity}}</td>
					<td>{{getWeight($orderitem->weight).defWeight()}}</td>
					<td  class="text-right"> {{showPrice($orderitem->total)}}</td>
				</tr>
				@php $i++; @endphp
			    @endforeach
			    <tr class="font-weight-normal">
				    <th colspan="5" style="text-align:right;">Sub Total</th>
				    <th class="text-right">{{showPrice($invoice->sub_total)}}</th>
				</tr>
				<tr class="font-weight-normal">
				    <th colspan="5" style="text-align:right;">Discount </th>
				    <th class="text-right">{{showPrice($invoice->discount)}}</th>
				</tr>
				<tr class="font-weight-normal">
				    <th colspan="5" style="text-align:right;">Tax </th>
				    <th class="text-right">{{showPrice($invoice->tax)}}</th>
				</tr>
				<tr  class="font-weight-normal">
				    <th colspan="5" style="text-align:right;">Grand Total </th>
				    <th class="text-right">{{showPrice($invoice->grand_total)}}</th>
				</tr>
				<tr class="font-weight-normal">
				    <th colspan="5" style="text-align:right;">Paid Amount </th>
				    <th  class="text-right" >{{showPrice($invoice->paid_total) ?? 0}}</th>
				</tr>
				<tr class="font-weight-normal">
				    <th colspan="5" style="text-align:right;">Due Amount</th>
				    <th  class="text-right">{{showPrice($invoice->grand_total-$invoice->paid_total)}}</th>
				</tr>
			</tbody>
		</table>
    </div>
</body>
    
<script type="text/javascript">
    $(document).ready(function(){
    window.print();
    });
</script>
</html>

