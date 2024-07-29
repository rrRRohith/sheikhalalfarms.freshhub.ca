<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="css/bootstrap.css">
    <script src="/vendors/jquery/js/jquery.min.js?v=2.1"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="{{ asset('js/jquery-2.2.4.min.js')}}"></script>
    <script type="text/javascript" src="js/jquery.printPage.js"></script>
</head>
<style>
    
</style>
<body style="background-color:#ffffff;">
    <div class="container mt-5">
        <h2 class="text-center mb-3"></h2>
        <div class="d-flex justify-content-end mb-4">
        </div>
        <div class="row">
            	<div class="col-sm-6">
    				<p>
        			   <label class="font-weight-bold">Bill To</label>
        			   <br>
        				    Mr.{{$invoice->user->firstname}} {{$invoice->user->lastname}}<br>
        				    {{$invoice->order->billing_address}}
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
		
        </div>
        <br>
        <table class="table table-bordered mb-4 table-sm" style="text-align: center;">
			<thead>
				<tr>
					<th>#</th>
					<th>PRODUCT/SERVICE</th>
					<th>DESCRIPTION</th>
					<th>QTY</th>
					<th>AMOUNT</th>
				</tr>
			</thead>
			<tbody>
			    @php $i=1;@endphp
			    @foreach($invoice->order->item as $orderitem)
				<tr style="text-align:left;">
					<td>{{$i}}</td>
					<td>{{$orderitem->product->name}}</td>
					<td>{{$orderitem->product->description}}</td>
					<td>{{$orderitem->quantity}}</td>
					<td>{{$orderitem->quantity * $orderitem->rate}}	</td>
				</tr>
				@php $i++; @endphp
			    @endforeach
			    <tr>
				    <th colspan="4" class="text-align:right;">Sub Total: </th>
				    <th>{{showPrice($invoice->sub_total)}}</th>
				</tr>
				<tr>
				    <th colspan="4" style="text-align:right;">Total: </th>
				    <th>{{$invoice->grand_total}}</th>
				</tr>
				<tr>
				    <th colspan="4" style="text-align:right;">Paid Amount: </th>
				    <th >{{$invoice->paid_amount ?? 0}}</th>
				</tr>
				<tr>
				    <th colspan="4" style="text-align:right;">Due Amount: </th>
				    <th>{{$invoice->grand_total-$invoice->paid_amount}}</th>
				</tr>
			</tbody>
		</table>
    </div>
</body>
    

</html>

