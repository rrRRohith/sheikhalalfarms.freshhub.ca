@extends('layouts.customer.header')
@section('contents')
<div class="content-container">
   <div class="content-area">
      <div class="row">
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-xs-padding">
            <div class="card no-margin minH">
               <div class="card-block">
                  <div class="card-title">
                     <div class="card-title-header">
                        <div class="card-title-header-titr"><b> Orders </b></div>
                        <div class="card-title-header-between"></div>
                        <div class="card-title-header-actions">
                           <a href="#"><img src="{{asset('img/help.svg')}}" alt="help"
                              class="card-title-header-img card-title-header-details"></a>
                        </div>
                     </div>
                  </div>
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
                                                New order  
                                                </button>
                                                <!--<a href=""-->
                                                <!--   class="btn btn-success pull-right">-->
                                                <!--   <clr-icon shape="plus-circle"></clr-icon>-->
                                                <!--   New order                           -->
                                                <!--</a>-->
                                               
                                               
                                                
                                             </td>
                                          </tr>
                                       </thead>
                                       <thead>
                                          <tr>
                                             
                                             <th >
                                                Date
                                             </th>
                                             <th>
                                                No
                                             </th>
                                             <th>
                                                Customer
                                             </th>
                                             <th>
                                                Amount
                                             </th>
                                             
                                             <th>
                                                Status
                                             </th>
                                             <th class="text-right">Actions</th>
                                          </tr>
                                          @foreach($orders as $order)
                                          <tr>
                                             
                                             <td>
                                                {{date('d F Y',strtotime($order->order_date))}}
                                             </td>
                                             <td>
                                                {{$order->order_id}}
                                             </td>
                                             <td>
                                                {{$order->firstname}} {{$order->lastname}}
                                             </td>
                                             <td>
                                               {{$order->grand_total}}
                                             </td>
                                             
                                             <td >
                                                @if($order->status==0)
                                                Pending
                                                @else
                                                Accepted
                                                @endif
                                             </td>
                                             <td class="text-right">
                                                  <label>
                                                   @if($order->status==0)
                                                   
                                                   <button class="edit_modal" value="{{$order->id}}"><clr-icon shape="pencil" size="22"></clr-icon></button>
                                                   @else
                                                    <label>
                                                   <a target="" href="{{customer_url('orders')}}/{{$order->id}}/generateinvoice" class="icon-table" rel="tooltip" data-tooltip="Generate Invoice">
                                                      <clr-icon shape="list" size="22"></clr-icon>
                                                   </a>
                                                </label>
                                                   @endif
                                                </label>
                                                <label>
                                                   <a target="" href="{{customer_url('orders')}}/{{$order->id}}/del" class="icon-table" rel="tooltip" data-tooltip=" Delete">
                                                      <clr-icon shape="trash" size="22"></clr-icon>
                                                   </a>
                                                </label>
                                             </td>
                                          </tr>
                                          @endforeach
                                       </thead>
                                       <tbody>
                                         
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
<div id="myModal" class="modal" style="padding-top: 10px;padding:10px;
">

  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">&times;</span>
    <div class="popupform">
		
		<div class="headertop">
			<h2>Order No.<span id="order_no">{{$order_no+1}}</span></h2>
		
		</div>
		<form action="{{url('customer/orders')}}" method="POST" name="form1" id="form1">
		    @csrf
		     <input type="hidden" name="_method" value="POST" id="form-method" />
		    <input type="hidden" name="order_id" value="{{$order_no+1}}" id="order_id">
			<div class="top-section">
			
			<div class="clear"></div>
			<div class="col-md-6">
				<p><label>Billing address</label>
				<textarea name="billing_address" rows="5" cols="35" id="billing_address" required></textarea></p>
				<p><label>Shipping To</label>
				<textarea name="shipping_address" rows="5" cols="35" id="shipping_address" required></textarea></p>
			</div>
			<div class="col-md-6 topsectright">
				<div class="col-md-6">
						<p><label>Order Date</label>
						<input type="date" name="order_date" id="order_date"  required/></p>
				</div>
				<div class="col-md-6">
						<p><label>Due Date</label>
						<input type="date" name="due_date" id="due_date" required/></p>
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
				<tbody>
					<tr>
						<td><button class="tickmark"></button></td>
						<td>1</td>
						
						<td>
						    <select name="product_id[]" id="product_id1" required>
    				        <option value="" disabled selected>Select a Product</option>
    				        @foreach($products as $product)
    				        <option value="{{$product->id}}">{{$product->name}}</option>
    			            @endforeach
				            </select>
				
							<!--<input type="text" name="prodservice"/>-->
						</td>
						<td>
							<input type="text" name="description[]" id="description1"/>
						</td>
						<td>
							<input type="number" name="quantity[]" id="quantity1" onkeyup="getTotal(1);" required/>
						</td>
						<td>
							<input type="text" name="rate[]" id="rate1" onkeyup="getTotal(1);"/>
						</td>
						<td>
							<input type="number" name="tax[]" id="tax1" onkeyup="getTotal(1);"/>
						</td>
						<td>
							<button class="delete"></button>
						</td>
					</tr>
					<tr>
						<td><button class="tickmark"></button></td>
						<td>2</td>
						
						<td>
						    <select name="product_id[]" id="product_id2">
    				        <option value="" disabled selected>Select a Product</option>
    				        @foreach($products as $product)
    				        <option value="{{$product->id}}">{{$product->name}}</option>
    			            @endforeach
				            </select>
				
							<!--<input type="text" name="prodservice"/>-->
						</td>
						<td>
							<input type="text" name="description2" id="description2"/>
						</td>
						<td>
							<input type="number" name="quantity[]" id="quantity2" onkeyup="getTotal(2);"/>
						</td>
						<td>
							<input type="text" name="rate[]" id="rate2" onkeyup="getTotal(2);"/>
						</td>
						<td>
							<input type="number" name="tax[]" id="tax2" onkeyup="getTotal(2);"/>
						</td>
						<td>
							<button class="delete"></button>
						</td>
					</tr>
					<tr>
						<td><button class="tickmark"></button></td>
						<td>3</td>
						
						<td>
						    <select name="product_id[]" id="product_id3">
    				        <option value="" disabled selected>Select a Product</option>
    				        @foreach($products as $product)
    				        <option value="{{$product->id}}">{{$product->name}}</option>
    			            @endforeach
				            </select>
				
							<!--<input type="text" name="prodservice"/>-->
						</td>
						<td>
							<input type="text" name="description[]" id="description3"/>
						</td>
						<td>
							<input type="number" name="quantity[]" id="quantity3" onkeyup="getTotal(3);"/>
						</td>
						<td>
							<input type="text" name="rate[]" id="rate3" onkeyup="getTotal(3);"/>
						</td>
						<td>
							<input type="number" name="tax[]" id="tax3" onkeyup="getTotal(3);"/>
						</td>
						<td>
							<button class="delete"></button>
						</td>
					</tr>
				
				</tbody>
			</table>
		</div>
			<div class="bottomsection">
				<div class="bottomleft">
					<div class="blfirst">
							<button>Add lines</button>
							<button>Clear All lines</button>
							<button>Add Subtotal</button>
					</div>
					<div class="blsecond">
						<label>Message on invoice</label>
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
   
    $('#product_id1').change(function(){
        var prodid=$(this).val();
        if(prodid)
        {
            $.ajax({
                url:"{{customer_url('orders/getdetails')}}/"+prodid,
                type:"GET",
                dataType:"json",
                success:function(data)
                {
                    //alert(data);
                    $.each(data,function(key,value)
                    {
                        var rate=value.price;
                        
                        $('#rate1').val(rate);
                        $('#description1').val(value.description);
                        //$('#quantity').max(value.qty);
                    });
                }
            });
        }
        //alert(prodid);
    });
    $('#product_id2').change(function(){
        var prodid=$(this).val();
        if(prodid)
        {
            $.ajax({
                url:"{{customer_url('orders/getdetails')}}/"+prodid,
                type:"GET",
                dataType:"json",
                success:function(data)
                {
                    //alert(data);
                    $.each(data,function(key,value)
                    {
                        var rate=value.price;
                        
                        $('#rate2').val(rate);
                        $('#description2').val(value.description);
                        //$('#quantity').max(value.qty);
                    });
                }
            });
        }
        //alert(prodid);
    });
     $('#product_id3').change(function(){
        var prodid=$(this).val();
        if(prodid)
        {
            $.ajax({
                url:"{{customer_url('orders/getdetails')}}/"+prodid,
                type:"GET",
                dataType:"json",
                success:function(data)
                {
                    //alert(data);
                    $.each(data,function(key,value)
                    {
                        var rate=value.price;
                        
                        $('#rate3').val(rate);
                        $('#description3').val(value.description);
                        //$('#quantity').max(value.qty);
                    });
                }
            });
        }
        //alert(prodid);
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
     $('.edit_modal').click(function(){
        var tour_id= $(this).val();
        var url="{{customer_url('orders')}}/"+tour_id+"/edit";
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
                        $('#discount_type').val(value.discount_type);
                         $('#discount').val(value.discount);
                        $('#disc').html(value.discount);
                        $('#shipping').val(value.shipping);
                        $('#taxx').val(value.tax);
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
                        // alert(value.due_date);
                        $('#myModal').css('display', 'block');
                   
                
                    });
                }
            });
            var url1="{{customer_url('orders')}}/"+tour_id+"/getpr";
          $.ajax({
                url:url1,
                type:"GET",
                dataType:"json",
                success:function(data)
                {
                    console.log(data);
                    var i=1;
                    var subt=0;
                    $.each(data,function(key,value)
                    {
                        //alert(value.product_id)
                       $('#product_id'+i).val(value.product_id);
                       $('#quantity'+i).val(value.quantity);
                       $('#rate'+i).val(value.rate);
                       $('#tax'+i).val(value.tax);
                       $('#description'+i).val(value.description);
                       subt=subt+(Number(value.quantity)*Number(value.rate))+Number(value.tax);
                       i++;
                    });
                    $('#subtotal1').val(subt.toFixed(2));
                    $('#subtotal').html(subt.toFixed(2));
                    
                }
            });
            var url2="{{customer_url('orders')}}/"+tour_id;
            
            $('#form1').attr('action', url2); //this fails silently
            $("#form-method").val('PUT');
        
        
    });
   
    $('#myBtn').click(function(){
                        $('#email').val("");
                        $('#user_id').val("");
                        $('#billing_address').val("{{$customer->address}}");
                        $('#shipping_address').val("{{$customer->address}}");
                       
                        
                        $('#shipping_id').val("");
                        $('#tracking_code').val("");
                        $('#message').val("");
                        $('#grand_total').val(0);
                        $('#grand').html("$0.00");
                        $('#bal').html("$0.00");
                        $('#discount_type').val("");
                         $('#discount').val("");
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
                        for(var i=1;i<=3;i++)
                        {
                       $('#product_id'+i).val("");
                       $('#quantity'+i).val("");
                       $('#rate'+i).val("");
                       $('#tax'+i).val("");
                       $('#description'+i).val("");
                        }
                        $('#subtotal1').val(0);
                    $('#subtotal').html("$0.00");
                    var url2="{{customer_url('orders')}}";
                    $('#form1').attr('action', url2); //this fails silently
            $("#form-method").val('post');
   $('#myModal').css('display', 'block');
});
$('.close').click(function(){
   $('#myModal').css('display', 'none');
});
});
function getTotal(j)
{
    var s=0;
    var t=0;
    for(var i=1;i<=3;i++)
    {
    var rate=$('#rate'+i).val();
    var tax=$('#tax'+i).val();
    var quantity=$('#quantity'+i).val();
    var subtotal=Number(rate*quantity);
    var s= s+subtotal;
    var ta=subtotal*(Number(tax)/100);
    var t=t+ta;
    }
    //alert(t);
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
</script>
@endsection