@extends('layouts.customer')

@section('title','Orders')

@section('page_title','Sales & Financials')

@section('page_nav')

<ul>

    <li class="active"><a href="{{customer_url('orders')}}">All Orders</a></li>

    <li><a  href="{{customer_url('invoices')}}">Invoices</a>

    <li><a  href="{{customer_url('backorders')}}">Backorders</a></li>

</ul>

@endsection

@section('contents')

<div class="content-container">

   <div class="content-area">

      <div class="row main_content">

         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

            <div class="card no-margin minH">

               <div class="card-block">

                <div class="card-title">

                    

                        <button id="new-order" class="green_button pull-right">

                            <clr-icon shape="plus-circle"></clr-icon> New order 

                        </button>

                    

                    <h3>All Orders</h3>

                </div>

                   

                <section class="card-text customers_outer">

                     <div class="row filter-customer">

                           <div class="col-lg-12">

                              <div class="filter-customer-list">

                                 @if (Session::has('message'))

                                 <div class="alert alert-success">

                                    <font color="red" size="4px">{{ Session::get('message') }}</font>

                                 </div>

                                 @endif

                                 

                                 <div class="row">

                                    <div class="col-sm-12">

                                        <div class="filter_form">

                                            

                                               

                                                <div class="row" id="filter_form">

                                                    <div class="col-sm-3">

                                                        <div class="form-group">

                                                            <label>Search</label>

                                                            <input type="text"  name="search" id="table-search"  value="{{Request()->search}}" class="form-control" placeholder="search by PO number,Invoice No"/>

                                                        </div>

                                                    </div>

                                                         

                                                    <div class="col-sm-3">

                                                        <div class="form-group">

                                                            <label>Status</label>

                                                            <select name="status" id="status"  class="form-control">

                                                                <option value="">Status</option>

                                                                @foreach($status as $s)

                                                                <option value="{{$s->id}}" @if(isset(Request()->status) && (Request()->status==$s->id)) selected @endif>{{$s->name}}</option>

                                                                @endforeach

                                                            </select>

                                                        </div>

                                                    </div>

                                                          

                                                    <div class="col-sm-3">

                                                        <div class="form-group">

                                                            <label>Select By Date</label>

                                                            <select name="orders"  class="form-control" id="byday">

                                                                <option value="">Order</option>

                                                                <option value="1" >Todays orders</option>

                                                                <option value="2">Yesterday orders</option>

                                                                <option value="3" >This Month</option>

                                                            </select>

                                                        </div>

                                                    </div>

                                                          

                                                    

                                                    

                                                </div>

                                            

                                        </div>    

                                    </div>                                   

                                 </div>

                                 



                                 <div class="table-list-responsive-md">
                                     
                                     <form method="post" action="{{customer_url('order/printorder')}}" target="_blank" id="print_form">
                                              @csrf

                                     <table class="table table-customer mt-0">
                                       <thead>
                                          <tr>
                                             <th class="text-left">#</th>
                                             <th class="text-left"> #PO/Invoice </th>
                                             
                                             <th class="text-center"><a class="sort" href="#order_date" data-sort="order_date" data-direction="asc">Ordering Date <i class="ml-2 fa fa-sort"></i></a></th>
                                             <th class="text-center"><a class="sort" href="#shipping_date" data-sort="shipping_date" data-direction="asc">Delivery Date <i class="ml-2 fa fa-sort"></i></a></th>
                                             <th class="text-center">Case Quantity</th>
                                             <th class="text-center">Total weight </th>
                                              <th class="text-right"> Amount </th>
                                             <th class="text-center"><a class="sort" href="#status" data-sort="status" data-direction="asc"> Status <i class="ml-2 fa fa-sort"></i></a></th>
                                             <th class="text-right">Actions</th>
                                          </tr>
                                        </thead>
                                        <tbody class="append-row">
                                            <tr><td colspan="9" class="text-center">Loading Data...</td><tr>
                                        </tbody>  
                                    </table>
                                        <div class="text-right"><button type="submit" name="submit" class="green_button" target="_blank"><i class="fa fa-print" aria-hidden="true"></i> Print</button></div>
                                    </form>
                                 </div>

                               

                              </div>

                           </div>

                        </div>

                     </section>

                     <div class="p-0 col-lg-4 mr-auto paginate d-flex" data-sort="" data-direction=""></div>

                  

               </div>

            </div>

         </div>

      </div>

   </div>

</div>



@include('customers.order-modal')

<!--<div id="myModal" class="modal">-->

<!--    <div class="modal-content">-->

<!--        <span class="close">&times;</span>-->

<!--        <form action="{{customer_url('orders')}}" method="post" name="form1" id="form1">-->

<!--        @csrf-->

<!--        <div class="popupform">-->

<!--		    <div class="top-section">-->

<!--        		<div class="headertop">-->

<!--        			<h2>Create New Order</h2>-->

<!--        		</div>-->

		        

<!--        		    <input type="hidden" name="_method" value="POST" id="form-method"/>-->

<!--        		    <input type="hidden" name="order_id" value="{{$order_no+1}}" id="order_id">-->

<!--        		    <div class="newform_top">-->

<!--    			    <div class="row clearfix">-->

    			        

<!--            			<div class="col-md-6">-->

<!--            				<p>-->

<!--            				<label>Customer</label>-->

<!--            				<input type="text" name="user_name" id="user_name" autocomplete="off">-->

<!--            				<div id="result-div-user" style="display:none;"></div>-->

<!--            				<input type="hidden" name="user_id" id="user_id">-->

            				

<!--            				</p>-->

<!--            			</div>-->

<!--            			<div class="col-md-6"><p>-->

<!--            				<label>Customer email</label>-->

<!--            				<input type="text" placeholder="Email" id="email" name="email" required readonly/></p>-->

<!--            			</div>-->

            		

<!--            			<div class="col-md-6">-->

<!--            				<p><label>Billing address</label>-->

<!--            				<textarea name="billing_address" rows="5" cols="35" id="billing_address" required></textarea></p>-->

<!--            				<p><label>Shipping To</label>-->

<!--            				<textarea name="shipping_address" rows="5" cols="35" id="shipping_address" required></textarea></p>-->

<!--            			</div>-->

    		

<!--            			<div class="col-md-3">-->

<!--        					<p><label>Order Date</label>-->

<!--        					<input type="date" name="order_date" id="order_date" value="{{date('d-m-Y')}}" required/></p>-->

<!--            			</div>-->

    				

<!--        				<div class="col-md-3">-->

<!--    						<p><label>Shipping Date</label>-->

<!--    						<input type="date" name="shipping_date" id="shipping_date" required/></p>-->

<!--        				</div>-->

    				

    				    

<!--	                </div>-->

<!--	                </div>-->

<!--		        </div>-->

<!--        		<div class="middlesection">-->

<!--        			<table>-->

<!--        				<thead>-->

<!--        					<tr>-->

        						<!--<th></th>-->

<!--        						<th>#</th>-->

        						

<!--        						<th>PRODUCT/SERVICE</th>-->

<!--        						<th>DESCRIPTION</th>-->

<!--        						<th>QTY</th>-->

<!--        						<th width="10%">RATE</th>-->

<!--        						<th width="10%">AMOUNT</th>-->

<!--        						<th></th>-->

<!--        					</tr>-->

<!--        				</thead>-->

<!--        				<tbody id="order-items">-->

<!--        					<tr id="r-0">-->

        						<!--<td><button class="tickmark"></button></td>-->

<!--        						<td><span class="order-item">1</span></td>-->

        						

<!--        						<td>-->

<!--        						    <input type="text" name="product_name[]" id="product_name-0" onkeyup="newProduct(0);" autocomplete="off" class="product_name">-->

<!--        						    <input type="hidden" name="product_id[]" id="product_id-0">-->

<!--        						    <div id="result-div-0" style="display:none;background: darkturquoise;"></div>-->

<!--        						</td>-->

<!--        						<td>-->

<!--        							<input type="text" name="description[]" id="description-0"/>-->

<!--        						</td>-->

<!--        						<td>-->

<!--        							<input type="text" name="quantity[]" id="quantity-0" onkeyup="getTotal(0);" onkeypress="return isNumber(event)" required/>-->

<!--        						</td>-->

<!--        						<td>-->

<!--        							<input type="text" name="rate[]" id="rate-0" onkeyup="getTotal(0);" onkeypress="return isNumber(event)"/>-->

<!--        						</td>-->

<!--        						<td>-->

<!--        							<span id="amount-0"></span>-->

<!--        						</td>-->

<!--        						<td>-->

<!--        							<button class="delete" id="delete-0" onclick="deteteRow(0);"><i class="fa fa-trash" aria-hidden="true"></i></button>-->

<!--        						</td>-->

<!--        					</tr>-->

<!--        					<tr class="last-item-row" ></tr>-->

        					

        					

<!--        				</tbody>-->

<!--        			</table>-->

<!--        		</div>-->

<!--			    <div class="bottomsection">-->

<!--                    <div class="row">-->

<!--                        <div class="col-md-6">-->

<!--        					<div class="blfirst" style="display:none">-->

<!--    							<button type="button">Add lines</button>-->

<!--    							<button>Clear All lines</button>-->

<!--    							<button>Add Subtotal</button>-->

<!--        					</div>-->

<!--        					<div class="blsecond">-->

<!--        						<label>Message on invoice</label>-->

<!--        						<textarea rows="3" cols="43" name="message" id="message"></textarea>-->

        						

<!--        					</div>-->

<!--        				</div>-->

<!--				        <div class="col-md-6">-->

<!--        					<div class="brfirst">-->

<!--        						<p class="sub_total"><label>Sub Total </label> <span id="subtotal">$0.00</span></p>-->

<!--        						<p><label>Discount </label>-->

<!--        						    <select name="discountt" id="discountt" onchange="calculateDiscount();">-->

<!--        								<option value="1">Discount Percentage</option>-->

<!--        								<option value="2">Discount Amount</option>-->

        								

<!--        						    </select></p>-->

<!--        						    <p> <label><span class="disc_value">Discount Value</span> </label><input type="text" id="discount_type" name="discount_type" onchange="calculateDiscount();">-->

<!--            						<div class="clearfix"></div>-->

<!--            						<span id="disc"> $0.00</span>-->

<!--        						</p>-->

<!--        						<div class="clearfix"></div>-->

    					  

<!--        						<p><label>Total &nbsp; &nbsp; &nbsp; &nbsp;</label><span id="grand">$0.00</span></p>-->

<!--        						<p><label>Balance Due &nbsp; &nbsp; &nbsp; &nbsp; </label><span id="bal">$0.00</span></p>-->

<!--        					</div>-->

<!--        					<div class="clearfix"></div>-->

<!--        					<input type="hidden" id="grand_total" name="grand_total" value="0">-->

<!--        					<input type="hidden" id="subtotal1" name="subtotal1" value="0">-->

<!--        					<input type="hidden" id="discount" name="discount" value="0">-->

<!--        					<input type="hidden" id="id" name="id" value="0">-->

<!--				        </div>-->

<!--				    </div>-->

<!--			    </div>-->

<!--    			<div class="footerform">	-->

<!--				    <button type="submit" value="Submit">Save and Send</button>-->

<!--    			</div>-->

<!--	        </div>-->

<!--        </form>-->

<!--    </div>-->

<!--</div>-->





<!--<div class="modal" tabindex="-1" role="dialog" id="uploadimageModal">-->

<!--    <div class="modal-dialog" role="document" style="min-width: 700px">-->

<!--        <div class="modal-content">-->

<!--            <div class="modal-header">-->

<!--                <h5 class="modal-title">Image</h5>-->

<!--                <button type="button" class="close" data-dismiss="modal" aria-label="Close">-->

<!--                    <span aria-hidden="true">&times;</span>-->

<!--                </button>-->

<!--            </div>-->

<!--            <div class="modal-body">-->

<!--                <div class="row">-->

<!--                    <div class="col-md-12 text-center">-->

<!--                        <div id="image_demo"></div>-->

<!--                    </div>-->

<!--                </div>-->

<!--            </div>-->

<!--            <div class="modal-footer">-->

<!--                <button type="button" class="btn btn-primary crop_image">Crop and Save</button>-->

<!--                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>-->

<!--            </div>-->

<!--        </div>-->

<!--    </div>-->

<!--</div>-->







	

<script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>

<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js" ></script>

<script type="text/javascript">

function isNumber(evt)

  {

     var charCode = (evt.which) ? evt.which : event.keyCode

     if (charCode > 31 && (charCode < 48 || charCode > 57))

        return false;



     return true;

  }

</script>



@endsection

@section('bottom-scripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.css" />



<script>

var image_crop = $('#image_demo').croppie({

    viewport: {

        width: 300,

        height: 225,

        type: 'square'

    },

    boundary: {

        width: 350,

        height: 350

    }

});

/// catching up the cover_image change event and binding the image into my croppie. Then show the modal.

$('#pictur').on('change', function() {

    var reader = new FileReader();

    reader.onload = function(event) {

        image_crop.croppie('bind', {

            url: event.target.result,

        });

    }

    reader.readAsDataURL(this.files[0]);

    $('#uploadimageModal').modal('show');

});

$('.crop_image').click(function(event) {

    image_crop.croppie('result', {

        type: 'canvas',

        format: 'png'

    }).then(function(response) {

        $("#uploaded-image").attr("src", response).css("display", "block");

        $("#picture").val(response);

    });

    $("#pictur").val("");

    $('#uploadimageModal').modal('hide');

});

</script>

<script>

var image_crop1 = $('#image_demo1').croppie({

    viewport: {

        width: 300,

        height: 225,

        type: 'square'

    },

    boundary: {

        width: 350,

        height: 350

    }

});

/// catching up the cover_image change event and binding the image into my croppie. Then show the modal.

$('#profile_pic').on('change', function() {

    var reader = new FileReader();

    reader.onload = function(event) {

        image_crop1.croppie('bind', {

            url: event.target.result,

        });

    }

    reader.readAsDataURL(this.files[0]);
    $('#uploadimageModal1').modal('show');

});

$('.crop_image1').click(function(event) {

    image_crop1.croppie('result', {

        type: 'canvas',

        format: 'png'

    }).then(function(response) {

        $("#uploaded-image1").attr("src", response).css("display", "block");

        $("#picture1").val(response);

    });

    $("#profile_pic").val("");

    $('#uploadimageModal1').modal('hide');

});

$("#print_form").submit(function(e){
    if($('.print_check:checked').length < 1) {
        e.preventDefault();
        alert('Please select atleast one order for print');
    }
})

</script>

<script src="/js/customcust.js" ></script>
<script>
let searchKey    = $('input#table-search');
let searchByday   = $('select#byday');
let searchStatus = $('select#status');
let sortDiv = $('div.paginate');
let deferUrl = `{{ customer_url('orders/defer')}}`;
$(document).ready(function() {

  $.getJSON(`${deferUrl}`,  function(response) {
    renderTable(response);
  });
  $('#table-search').on('keyup', function(){
    loadingRow();
    tableSearch();
  });
  $('#byday').on('change', function(){
    loadingRow();
    tableSearch();
  });
   $('#status').on('change', function(){
     loadingRow();
     tableSearch();
   });
  $('a.sort').on('click',async function(e){
    e.preventDefault();
    let srtTH = $(this);
    let key = $('input#table-search').val();
    let sort = srtTH.attr('data-sort');
    let direction = srtTH.attr('data-direction');
      if(sort == null || direction == null)
        return false;
    sortDiv.attr('data-sort', sort);
    sortDiv.attr('data-direction', direction);
    loadingRow();
    await $.getJSON(`${deferUrl}?key=${searchKey.val()}&status=${searchStatus.val()}&byday=${searchByday.val()}&sort=${sort}&direction=${direction}`, function(response) {
      renderTable(response);
      srtTH.attr('data-direction', direction == 'asc' ? 'desc' : 'asc');
    });
  });
});
function loadingRow()
{
  $('tbody.append-row').html(`<tr><td colspan="7" class="text-center">Loading Data...</td><tr>`);
}
function tableSearch()
{
    $.getJSON(`${deferUrl}?key=${searchKey.val()}&status=${searchStatus.val()}&byday=${searchByday.val()}`, function(response) {
       renderTable(response);
     });
}
async function renderTable(response){
  let table = '';
  await response.data.forEach(function(row, index){
    let createdAt = new Date(row.created_at).toLocaleDateString('en-us', {year:"numeric", month:"short", day:"numeric"});
    let orderDate = new Date(row.order_date).toLocaleDateString('en-us', {year:"numeric", month:"short", day:"numeric"});
    let shippingDate = new Date(row.shipping_date).toLocaleDateString('en-us', {year:"numeric", month:"short", day:"numeric"});
    var text="";
    if(row.status==1)
    {
        text='<a href="#" class="edit-order" data-id="'+row.id+'"><li>Edit Order</li></a>';
    }                
    table+=`<tr><td>
              <input type="checkbox" name="id[]" id="id-${row.id}" value="${row.id}" ${row.status >=4 ? 'disabled' :''} class="print_check">
            </td>
            <td class="text-lg-left  text-md-left" data-label="Organization">
              ${row.invoice_no}
            </td>
            
            <td class="text-center" data-label="Organization">
              <label class="">${orderDate}</label>
            </td>
            <td class="text-center" data-label="Organization">
              <label class="">${shippingDate}</label>
            </td>
            <td class="text-center" data-label="Organization">
              <label class="">${row.quantity}</label>
            </td>
            <td class="text-center" data-label="Organization">
              <label class="">${row.weight}</label>
            </td>
            <td class="text-center" data-label="Organization">
              <label class="">${row.grand_total}</label>
            </td>
            <td class="text-lg-left  text-md-left"data-label="Organization">
              ${row.status==1 ? '<span class="badge bg-primary">New Order</span>' : (row.status==2 ? '<span class="badge bg-dark"> Accepted</span>':(row.status==3 ? '<span class="badge bg-info"> Processing</span>':(row.status==4 ? '<span class="badge bg-warning"> Ready</span>':(row.status==5 ? '<span class="badge bg-success"> Dispatching</span>':(row.status==6 ? '<span class="badge bg-danger"> Delivered</span>':'<span class="badge bg-light"> Cancelled </span>'))))) } 
            </td>
            
            <td class="text-right" >
              <div class="fh_actions pull-right">
                <a href="#" class="fh_link">Actions <i class="fa fa-caret-down"></i> </a>
                  <ul class="fh_dropdown">
                    <a href="{{customer_url('orders/orderdetails')}}/${row.id}"><li>View</li></a>`+text+`
                  </ul>
              </div>
            </td>
          </tr>`;
          
          
          
  });
  $('tbody.append-row').html(table ? table : `<tr><td colspan="7" class="text-center">No data found</td><tr>`);
  $('.paginate').html(response.links);
}
</script>
<script  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA2pKP9bGJRpU-35sWLBgirftfBgLhc03c&callback=initAutocomplete&libraries=places&v=weekly"  async ></script>
@endsection