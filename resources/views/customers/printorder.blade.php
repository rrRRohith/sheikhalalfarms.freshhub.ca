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
@foreach($orders as $order)
<body style="background-color:#ffffff;color:#000000;">
    <div class="container mt-5">
        <h2 class="text-center mb-3"></h2>
      
        <div class="logo text-center padding-side-30">
            <img src="{{asset('img/freshhub_logo.png')}}" alt="FreshHub logo">
        </div>
        <br><br>      
        <div class="row">
            	<div class="col-sm-12">
    				<p class="" style="font-family: 'Open Sans', sans-serif;font-size:20px;">
        			   <label style="color:#000000;font-weight:600;">Bill To</label>
        			   <br>
        				    Mr.{{$order->user->firstname}} {{$order->user->lastname}}<br>
        				    {{$order->billing->address}}
    				</p>
    				<p class="" style="font-family: 'Open Sans', sans-serif;font-size:20px;">
        			   <label style="color:#000000;font-weight:600;">Ship To</label>
        			   <br>
        				    
        				    {{$order->delivery->address}}
    				</p>
		    	</div>
            	<div class="col-sm-12 text-right"><p style="font-family: 'Open Sans', sans-serif;font-size:20px;">
    				<!--<label><b>Invoice#: </b></label>-->
    				<b>PO#: </b>
    			    	PO{{$order->id}}
    				<br>
    				<!--<label><b>Date: </b></label>-->
    				<b>Date: </b>
    				    {{date('d M Y',strtotime($order->order_date))}}
    				<br>
    				<!--<label><b>Due Date: </b></label>-->
    				<b>Due Date: </b>
    			    	{{date('d M Y',strtotime($order->shipping_date))}}
			    </div>
		
        </div>
        <br>
        <table class="table table-bordered mb-4 table-sm" style="text-align: center;">
			<thead>
				<tr class="font-weight-bold"style="font-size:18px;">
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
			<tbody style="font-size:15px;">
			    @php $i=1;@endphp
			    @foreach($order->item as $orderitem)
				<tr  class="font-weight-normal" style="text-align: center;">
					<td>{{$i}}</td>
					<td>
					    {{$orderitem->product_sku}}
					</td>
					<td>
					    {{$orderitem->product_name}}
					</td>
					<td>
						{{$orderitem->product_description}}
					</td>
					<td class="text-right">
						{{showPrice($orderitem->rate)}}
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
			<tfoot>
			    <tr>
				    <th colspan="7"  class="text-right">
				        
				        Discount:<br/>
				        Tax: <br/>
				        Grand Total:<br/>
				        
				   </th>
				   <th class="text-right">
                        
					    {{showPrice($order->discount_amount)}}<br/>
					    {{showPrice($order->tax)}}<br/>
					    {{showPrice($order->grand_total)}}<br/>
				    </th>
				</tr>
			</tfoot>
		</table>
    </div>
</body>
@endforeach    
<script type="text/javascript">
    $(document).ready(function(){
    window.print();
    });
</script>
</html>

