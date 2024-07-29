<body>
<div class="container">
   <div class="content-area">
      <div class="row">
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card no-margin minH">
               <div class="card-block">
             
            <div class="invoice_view">
                <div class="vi_topsection">
                    <div class="vi_logo" style="width:100%;">
                        <h3>Orders of {{$shop->business_name}}</h3>
                    </div>
                    
                    <div class="clearfix"></div>
                </div>
	           <div class="vifourth_section">
	                <div class="table-list-responsive-md">
	                    <table class="fh_table vi_table">
				            <thead>
					            <tr>
            <th  scope="col">#</th>
            <th  scope="col"> Invoice No</th>
            <th  scope="col"> Invoice Date</th>
            <th  scope="col">Subtotal</th>
            <th scope="col">Tax</th>
            <th scope="col">Grand Total</th>
            <th scope="col">Due Date</th>
            <th scope="col">Due Amount</th>
                                               
          
            
          </tr>
				            </thead>
				        <tbody>
				            @php $id=1; @endphp
          @if(isset($orders) && count($orders)>0)
            @foreach($orders as $order)
          <tr>
            <td scope="row">{{$id}}</td>
            <td scope="row"><a class="orderview" style="cursor:pointer;" data-id="{{$order->id}}">{{$order->invoice_number}}</a></td>
             <td scope="row">{{date('M d, Y',strtotime($order->created_at))}}</td>
              <td scope="row"> {{showPrice($order->sub_total)}}</td>
            <td scope="row">{{showPrice($order->tax)}}</td>
            <td scope="row">
              {{showPrice($order->grand_total)}}
            </td>
            <td scope="row">{{date('M d, Y',strtotime($order->due_date))}}</td>
            
              <td scope="row">
                 {{showPrice($order->grand_total - $order->paid_total)}}
            </td>
            
          
          </tr>
          @php $id++; @endphp
         @endforeach
         @else
         <tr>
            <td colspan="8" class="text-center">No Orders Found</td>
         </tr>
         @endif
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
	</div>
</body>
<!--<body style="background-color:#ffffff;color:#000000;">-->
<!--    <div class="container mt-5">-->
<!--        <h2 class="text-center mb-3"></h2>-->
        

        
        
<!--        <h2 class="text-left"><label class="font-weight-bold" style="font-family: 'Open Sans', sans-serif;font-size:25px;">{{$shop->business_name}}</label></h2>-->
<!--        <table class="table table-bordered mb-5">-->
<!--          <tr>-->
<!--            <th  scope="col">#</th>-->
<!--            <th  scope="col"> Invoice No</th>-->
<!--            <th  scope="col"> Invoice Date</th>-->
<!--            <th  scope="col">Subtotal</th>-->
<!--            <th scope="col">Tax</th>-->
<!--            <th scope="col">Grand Total</th>-->
<!--            <th scope="col">Due Date</th>-->
<!--            <th scope="col">Due Amount</th>-->
                                               
          
            
<!--          </tr>-->
<!--          @php $id=1; @endphp-->
<!--          @if(isset($orders) && count($orders)>0)-->
<!--            @foreach($orders as $order)-->
<!--          <tr>-->
<!--            <td scope="row">{{$id}}</td>-->
<!--            <td scope="row"><a class="orderview" style="cursor:pointer;" data-id="{{$order->id}}">{{$order->invoice_number}}</a></td>-->
<!--             <td scope="row">{{date('M d, Y',strtotime($order->created_at))}}</td>-->
<!--              <td scope="row"> {{showPrice($order->sub_total)}}</td>-->
<!--            <td scope="row">{{showPrice($order->tax)}}</td>-->
<!--            <td scope="row">-->
<!--              {{showPrice($order->grand_total)}}-->
<!--            </td>-->
<!--            <td scope="row">{{date('M d, Y',strtotime($order->due_date))}}</td>-->
            
<!--              <td scope="row">-->
<!--                 {{showPrice($order->grand_total - $order->paid_total)}}-->
<!--            </td>-->
            
          
<!--          </tr>-->
<!--          @php $id++; @endphp-->
<!--         @endforeach-->
<!--         @else-->
<!--         <tr>-->
<!--            <td colspan="8" class="text-center">No Orders Found</td>-->
<!--         </tr>-->
<!--         @endif-->
          
<!--        </table>-->
<!--</div>-->
<!--    </body>    -->
