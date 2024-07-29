<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Purchase order #{{$order->po_number}}</title>
</head>
<body style="background-color:#ffffff;color:#000000;font-family:Arial,Tahoma,sans-serif;line-height:150%;font-size: 1.2em;">
    <div style="width: 800px;margin:50px auto;">
        <header style="text-align:center;">
            <h1><img src="{{asset('img/freshhub_logo.png')}}" alt="FreshHub logo" style="max-height:70px; width:auto;"></h1>
            <h4 style="text-decoration:underline;">Purchase Order</h4>
        </header>
        
        <main>
            
            <section>
                <table width="100%">
                    <tr>
                        <td align="left">
                            <h4>Billed to</h4>
                            <p>
                                {{$order->user->firstname.' '.$order->user->lastname}}<br/>
                                <i class="fa fa-phone"></i> {{$order->user->address}}<br/>
                                {{$order->user->postalcode.' '.$order->user->city.' '.$order->user->province}}<br/>
                                {{$order->user->phone}}<br/>
                            </p>
                        </td>
                        <td align="right">
                            PO Number: #{{$order->po_number}}<br/>
                            Order Date: {{date('d M Y',strtotime($order->order_date))}}<br/>
                            Delivery On: {{date('d M Y',strtotime($order->shipping_date))}}<br/>
                            Status: {{$order->status}}<br/>
                        </td>
                    </tr>
                </table>
            </section>
            
            <section>
                <table cellpadding="10" width="100%" style="border: 1px solid #DDD; border-collapse:collapse;">
                    <tr  style="border: 1px solid #DDD; background: #EEE;">
                        <th style="text-align:left">#</th>
                        <th style="text-align:left">SKU</th>
                        <th style="text-align:left">Name</th>
                        <th style="text-align:center">Quantity</th>
                    </tr>
                    @php $count = 0; @endphp
                    
                    @foreach($order->item as $item)
                    <tr>
                        <td style="border: 1px solid #DDD; text-align:left">{{++$count}}</td>
                        <td style="border: 1px solid #DDD; text-align:left">{{$item->product_sku}}</td>
                        <td style="border: 1px solid #DDD; text-align:left">{{$item->product_name}}</td>
                        <td style="border: 1px solid #DDD; text-align:center">{{$item->quantity}}</td>
                    </tr>       
                    @endforeach  
                </table>
            </section>
        
        
        </main>
        
        <footer>
            
        </footer>
    </div>
    
  <!--  <div class="container mt-5">-->
  <!--      <h2 class="text-center mb-3"></h2>-->
      
  <!--      <div class="logo text-center padding-side-30">-->
            
  <!--      </div>-->
  <!--      <h5 class="text-center"></h5>-->
  <!--      <br><br>      -->
  <!--      <div class="row">-->
  <!--          	<div class="col-sm-12">-->
  <!--  				<p class="" style="font-family: 'Open Sans', sans-serif;font-size:20px;">-->
  <!--      			   <label style="color:#000000;font-weight:600;">Bill To</label>-->
  <!--      			   <br>-->
  <!--      				    Mr.{{$order->user->firstname}} {{$order->user->lastname}}<br>-->
  <!--      				    {{$order->billing->address}} , -->
  <!--      				    {{$order->billing->postalcode}}<br>-->
  <!--      				    {{$order->billing->city}} , -->
  <!--      				    {{$order->billing->province}}-->
  <!--  				</p>-->
  <!--  				<p class="" style="font-family: 'Open Sans', sans-serif;font-size:20px;">-->
  <!--      			   <label style="color:#000000;font-weight:600;">Ship To</label>-->
  <!--      			   <br>-->
        				    
  <!--      				    {{$order->delivery->address}} , -->
  <!--      				    {{$order->delivery->postalcode}}<br>-->
  <!--      				    {{$order->delivery->city}} , -->
  <!--      				    {{$order->delivery->province}}-->
  <!--  				</p>-->
		<!--    	</div>-->
  <!--          	<div class="col-sm-12 text-right"><p style="font-family: 'Open Sans', sans-serif;font-size:20px;">-->
    				<!--<label><b>Invoice#: </b></label>-->
  <!--  				<b>PO#: </b>-->
  <!--  			    	PO{{$order->id}}-->
  <!--  				<br>-->
    				<!--<label><b>Date: </b></label>-->
  <!--  				<b>Date: </b>-->
  <!--  				    {{date('d M Y',strtotime($order->order_date))}}-->
  <!--  				<br>-->
    				<!--<label><b>Due Date: </b></label>-->
  <!--  				<b>Due Date: </b>-->
  <!--  			    	{{date('d M Y',strtotime($order->shipping_date))}}-->
		<!--	    </div>-->
		
  <!--      </div>-->
  <!--      <br>-->
  <!--      <table class="table table-bordered mb-4 table-sm" style="text-align: center;">-->
		<!--	<thead>-->
		<!--		<tr class="font-weight-bold"style="font-size:18px;">-->
		<!--			<th>#</th>-->
		<!--			<th>CODE</th>-->
		<!--			<th>PRODUCT/SERVICE</th>-->
		<!--			<th>DESCRIPTION</th>-->
		<!--			<th class="text-center">QTY/CASES</th>-->
					<!--<th class="text-right">AMOUNT</th>-->
		<!--		</tr>-->
		<!--	</thead>-->
		<!--	<tbody style="font-size:15px;">-->
		<!--	    @php $i=1;@endphp-->
		<!--	    @foreach($order->item as $orderitem)-->
		<!--		<tr  class="font-weight-normal" style="text-align:left;">-->
		<!--			<td>{{$i}}</td>-->
		<!--			<td>{{$orderitem->product->sku}}</td>-->
		<!--			<td>{{$orderitem->product->name}}</td>-->
		<!--			<td>{{$orderitem->product->description}}</td>-->
		<!--			<td  class="text-center">{{$orderitem->quantity}}</td>-->
					<!--<td  class="text-right"> ${{$orderitem->quantity * $orderitem->rate}}</td>-->
		<!--		</tr>-->
		<!--		@php $i++; @endphp-->
		<!--	    @endforeach-->
			
		<!--	</tbody>-->
		<!--</table>-->
  <!--  </div>-->
</body>
<script type="text/javascript">
    $(document).ready(function(){
    window.print();
    });
</script>
</html>

