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
hr { 
  display: block;
  margin-top: 0.5em;
  margin-bottom: 0.5em;
  margin-left: auto;
  margin-right: auto;
  border-style: inset;
  border-width: 1px;
} 
.weight-column{
    border: 1px solid black;
    height: 30px;
    width: auto;
}
.green_button {
    background: transparent;
    background-color: #2ca01c !important;
    border: 1px solid #2ca01c !important;
    color: #fff;
    padding: 10px 15px !important;
    line-height: 100%;
    font-size: 110%;
    font-weight: 400;
    border-radius: 25px;
    cursor: pointer;
}
.green_button:hover {
    background-color: transparent !important;
    color: #2ca01c;
}
.table-bordered {
    border: 8px solid black;
}
.psheet_top .col-md-4.print_button {
    text-align: right;
    align-items:center;
    display:flex;
    justify-content:right;
}
.psheet_top .col-md-4.picksheet-title{
   text-align:center; 
   display:flex;
   align-items:center;
   justify-content: center;
}
.psheet_top .col-md-4.picksheet-title h2{
    font-size: 30px;
text-transform: uppercase;
}
.psheet_top .delivery_details p{
    font-size: 20px;
    margin-bottom:4px;
}
.psheet_top{
    padding-top:20px;
    padding-bottom:10px;
    border-bottom:2px solid #000;
}
.col-md-12.delivery_details{
    margin-top:20px;
}
.psheet_customerdetails p{
    font-size: 20px;
    margin-bottom:4px; 
}
.psheet_customerdetails{
   padding-top:20px;
   padding-bottom:10px;  
}
.picksheet_table{
    border:2px solid #000;
    margin-top:10px;
    margin-bottom:10px;
}
.picksheet_table td,.picksheet_table th{
    padding:20px 15px;
    border-right:2px solid #000;
   
}


.picksheet_table thead tr th{
    border-bottom:2px solid #000;
    padding:10px;
    border-right:2px solid #000;
}
.picksheet_table tbody tr td{
    border-top:1px solid #000;
    padding:10px;
    border-right:2px solid #000;
}
.picksheet-tabletwo tbody tr th{
    border-bottom:none;
    border-top:none;
}
.table.picksheet-tabletwo{
    margin-top:20px;
}
.title_label {
    margin-top: 30px;
    text-transform: capitalize;
    font-size: 20px;
}
.picksheet-outer{
    padding-bottom:30px;
}






</style>

<body style="background-color:#ffffff;color:#000000;">
    <div class="container picksheet-outer">
        <h2></h2>
        <div class="psheet_top">
            <div class="row clearfix">
                <div class="psheet_logo col-md-4">
                    <img src="{{asset('img/freshhub_logo.png')}}" alt="FreshHub logo" style="width:250px;height:auto;">
                </div>
                <div class="col-md-4 picksheet-title">
                    <h2><label>Pick Sheet</label></h2>
                </div>
                <div class="col-md-4 print_button">
                    <a href="{{admin_url('order/printpicksheet/'.$order->id)}}"><button class="green_button">Print Pick Sheet</button> </a>
                </div>
                <div class="col-md-12 delivery_details">
    				<p>
        			   <label>Delivery Date</label>: {{$order->shipping_date}}
    				</p>
    				<p>
        			   <label>Picked By</label>: 
        			</p>
				</div>
            </div>
        </div>
        <div class="psheet_customerdetails">
            <div class="row">
            	<div class="col-md-12">
    				<p>
        			   <label>Customer</label> : {{$order->user->firstname}} {{$order->user->lastname}}
        			</p>
    				<p>
        			   <label>Invoice</label> : {{$order->po_number}}
        			</p>
    				<p>
        			   <label>Total Cases</label>: 
        			</p>
				</div>
            </div>
        </div>
       
     
       
        <table class="table picksheet_table">
			<thead>
				<tr class="font-weight-bold"style="font-size:18px;">
					<th class="text-left">Product</th>
					<th class="text-left">Ordered</th>
					<th class="text-left">Picked</th>
					<th class="text-left">Short</th>
					<th class="text-left">Weight</th>
				</tr>
			</thead>
			<tbody style="font-size:15px;">
			    @php $i=1;@endphp
			    @foreach($order->item as $orderitem)
				<tr  class="font-weight-normal" style="text-align: center;">
					<td class="text-left">
					    {{$orderitem->product_name}}
					</td>
					<td class="text-left">
						{{$orderitem->quantity}} @if($orderitem->quantity >1) Cases @else Case @endif
					</td>
					<td class="text-left">
					
					</td>
					<td class="text-left">
					   
					</td>
					<td class="text-left">
					    
					    
					</td>
					
				</tr>
				@php $i++; @endphp
			    @endforeach
			</tbody>
		</table>
		<table class="table picksheet-tabletwo">
		    @foreach($order->item as $orderitem)
		    @php 
		        $r=$orderitem->quantity; 
		        $m=ceil($orderitem->quantity/7);
		    @endphp
    		    <tr class="font-weight-bold"style="font-size:18px;">
    		        <th rowspan={{$m}} width="20%"><label class="title_label">{{$orderitem->product_name}}</label></th>
    		        <th class="text-center">@if($r >=1)1<div class="weight-column"></div>@endif</th>
    		        <th class="text-center">@if($r >=2)2<div class="weight-column"></div>@endif</th>
    		        <th class="text-center">@if($r >=3)3<div class="weight-column"></div>@endif</th>
    		        <th class="text-center">@if($r >=4)4<div class="weight-column"></div>@endif</th>
    		        <th class="text-center">@if($r >=5)5<div class="weight-column"></div>@endif</th>
    		        <th class="text-center">@if($r >=6)6<div class="weight-column"></div>@endif</th>
    		        <th class="text-center">@if($r >=7)7<div class="weight-column"></div>@endif</th>
    		            <!--<th class="text-center">@if($r >=1)<span>1</span><br><div class="weight-column"></div>@endif</th>-->
    		            <!--<th class="text-center">@if($r >=2)<span>2</span><br><div class="weight-column"></div>@endif</th>-->
    		            <!--<th class="text-center">@if($r >=3)<span>3</span><br><div class="weight-column"></div>@endif</th>-->
    		            <!--<th class="text-center">@if($r >=4)<span>4</span><br><div class="weight-column"></div>@endif</th>-->
    		            <!--<th class="text-center">@if($r >=5)<span>5</span><br><div class="weight-column"></div>@endif</th>-->
		            @if($m >1)
		            
		            </tr>
		            @php $i=7;@endphp
		            @for($j=2;$j<=$m;$j++)
		            <tr class="font-weight-bold"style="font-size:18px;">
		                @for($k=1;$k<=7;$k++)
		                <th class="text-center">@if($r >=$i+$k){{$i+$k}}<div class="weight-column"></div>@endif</th>
		                @endfor
		            </tr>
		            @php $i=$i+$k-1; @endphp
		            @endfor
		            @else
    		    </tr>
    		    @endif
		    @endforeach
		</table>
    </div>
    
</body>

<!--<script type="text/javascript">-->
<!--    $(document).ready(function(){-->
<!--    window.print();-->
<!--    });-->
<!--</script>-->
</html>

