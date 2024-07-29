@extends('layouts.admin')
@section('title','Orders')
@section('page_title','Orders')
@section('page_nav')
<ul>
    @can('Order View')<li class="active"><a href="{{admin_url('orders')}}">All Orders</a></li>@endcan
    @can('Purchase Order View')<li><a  href="{{admin_url('purchaseorders')}}">Purchase Orders</a></li>@endcan
    @can('Invoices View')<li><a  href="{{admin_url('invoices')}}">Invoices</a></li>@endcan
    @can('Backorder View')<li><a  href="{{admin_url('backorders')}}">Backorders</a></li>@endcan
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
                    @can('Order Create')
                    <div class="order_options pull-right">
                        <button id="neworder_button" class="green_button">
                             New order <span class="ordermenu_icon"><i class="fa fa-angle-down"></i></span> 
                        </button>
                        <div class="orderoption_window" style="display:none;">
                             <ul>
                                 <li><a id="new-order" style="cursor:pointer;">Create PO</a></li>
                                 @can('Invoices Create')<li><a id="new-invoice" style="cursor:pointer;">Create Invoice</a></li>@endcan
                                 <!--<li><a href="#">Option Three</a></li>-->
                             </ul> 
                          </div>
                    </div>
                    @endcan
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
                                            
                                                <div class="row clearfix" id="filter_form">
                                                    <div class="col-sm-4 col-lg-4">
                                                        <div class="form-group">
                                                            <label>Search by Keyword</label>
                                                            <input type="text"  name="search" id="table-search"  value="{{Request()->search}}" class="form-control" placeholder="search by PO number,Invoice No,Store name,email,"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4 col-lg-3">
                                                        <div class="form-group">
                                                            <label>Status</label>
                                                            <select name="status" id="status"  class="form-control">
                                                                <option value="">All</option>
                                                                @foreach($status as $s)
                                                                <option value="{{$s->id}}" @if(isset(Request()->status) && (Request()->status==$s->id)) selected @endif>{{$s->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4 col-lg-3">
                                                        <div class="form-group">
                                                            <label>Select By Date</label>
                                                            <select name="orders" id="byday"  class="form-control">
                                                                <option value="">All</option>
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
                                    <form method="post" action="{{admin_url('order/printorder')}}" id="print_form">
                                      @csrf
                                      <input type="checkbox" name="selectall" id="selectall"> Select All
                                    <table class="table table-customer mt-0">
                                       <thead>
                                          <tr>
                                             <th class="text-left">#</th>
                                             <th class="text-left"> #PO/Invoice </th>
                                             <th class="text-left">  Store Name</th>
                                             <th class="text-center"><a class="sort" href="#order_date" data-sort="order_date" data-direction="asc">Ordering Date <i class="ml-2 fa fa-sort"></i></a></th>
                                             <th class="text-center"><a class="sort" href="#shipping_date" data-sort="shipping_date" data-direction="asc">Delivery Date <i class="ml-2 fa fa-sort"></i></a></th>
                                             <th class="text-center"><a class="sort" href="#total_quantity" data-sort="total_quantity" data-direction="asc"> Case Quantity <i class="ml-2 fa fa-sort"></i></a></th>
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
                                        <div class="text-right" style="padding:5px;"><button type="submit" name="submit" class="green_button" value="print"><i class="fa fa-print" aria-hidden="true"></i> Print</button></div>
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
@include('admin.order.order-modal')
@include('admin.order.process-modal')
@include('admin.customer.customer-modal')
@include('admin.customer.customer-error')
@include('admin.product.product-modal')
@include('admin.product.addstock')
@include('admin.customer.duelist')
@include('admin.order.sent-invoice-modal')
<div id="stock_modal" style="display: none;">
    <div class="modal_box">
        <div class="modal_title">
            <a class="pull-right close"><i class="fa fa-close"></i></a>
            <h3><span id="mhead">Cancel Order</span></h3>
        </div>
        <div class="modal_body">
            <div class="px-lg-3 no-padding fh_form" id="addAccountForm">
                <form class="pt-0" id="stock_form" method="post" action="{{admin_url('orders/cancel')}}">
                    @csrf
                    <input type="hidden" name="id" id="id1">
                    <section class="form-block">
                        <div class="row">
                            <div class="col-md-12">  
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <label class="text-gray-dark" for="opportunity_source_id"> PO Number : <span id="pr1name"></span></label>
                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <label class="text-gray-dark" for="opportunity_source_id"> Remarks</label>
                                        <textarea class="form-control" id="stock" name="remarks" type="text" placeholder="Reason for cancelling" required ></textarea>
                                        
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-success btn-block green_button">
                                    <clr-icon shape="floppy"></clr-icon>
                                   Save                        
                                </button>
                           
                            </div>
                               
                    </div>
                         
                   </section>
                 
                   

                      
                 
                </form>
             </div>
        </div>
        <div class="modal_footer">

        </div>
    </div>
</div>

<div id="rate_change_modal" style="display: none;">
    <div class="modal_box">
        <div class="modal_title">
            <a class="pull-right close"><i class="fa fa-close"></i></a>
            <h3><span id="mhead">Save new rates for later use?</span></h3>
        </div>
        <div class="modal_body">
            <form action="#" id="rate-confirm" method="POST">
                <div class="px-lg-3 no-padding fh_form" id="addAccountForm">
                    Rates for some items has changed. Do you want to set it permanent for this customer?
                </div>
                <hr/>
                <div id="update_rates">

                </div>
                <hr/>
                <div class="px-lg-3 no-padding fh_form">
                    @csrf
                    <input type="hidden" name="rate_customer" value="" id="rate_customer" />
                    <button type="submit" id="changeRate" class="green_button">Confirm rate change</button>
                    <button type="button" id="noChangeRate" class="white_button">Continue without rate change</button>
                    <br/>
                </div>
            </form>
        </div>
        <div class="modal_footer">

        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
<script src="https://code.jquery.com/ui/1.10.2/jquery-ui.js" ></script>
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
  

    $('body').delegate('.cancelorder','click',function(e){
        e.preventDefault();
        $('#id1').val($(this).data('id'));
        $('#pr1name').html($(this).data('name'));
           $('#stock_modal').fadeIn('slow');
    });
    $("#stock_modal .close").click(function(e){
		e.preventDefault();
		$("#stock_modal").fadeOut(50);
	});

    $("#rate_change_modal .close").click(function(e){
        e.preventDefault();
		$("#rate_change_modal").fadeOut(50);
    });

  $('#neworder_button').click(function() {
	$(this).next('.orderoption_window').slideToggle(0);
}); 
$('#selectall').on('change',function(){
    var s=$('#selectall').prop("checked");
    if(s==true)
    {
        $('.printed_checked').prop("checked",true);
    }
    else
    {
        $('.printed_checked').prop("checked",false);
    }
});
</script>
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
<script src="/js/custom.js" ></script>
<script>
let searchKey    = $('input#table-search');
let searchByday   = $('select#byday');
let searchStatus = $('select#status');
let sortDiv = $('div.paginate');
let deferUrl = `{{ admin_url('orders/defer')}}`;
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
  $('tbody.append-row').html(`<tr><td colspan="10" class="text-center">Loading Data...</td><tr>`);
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
    let status=row.status;
    var text="";
    if(row.status==1)
    {
        text='<a href="#" onClick="changeStatus('+row.id+',2)"><li>Accept Order</li></a>@can("Order Edit")<a href="#" class="edit-order" data-id="'+row.id+'"><li>Edit Order</li></a>@endcan';
    }
    else if(row.status==2)
    {
        text='<a href="order/printorder/'+row.id+'" target="_blank"><li>Print Order</li></a><a href="#" class="process-order" data-id="'+row.id+'"><li>Process Order</li></a>@can("Order Edit")<a href="#" class="edit-order" data-id="'+row.id+'"><li>Edit Order</li></a>@endcan<a href="order/picksheet/'+row.id+'" target="_blank"><li>Pick Sheet</li></a>';
    }
    else if(row.status==3)
    {
        text='<a href="#" class="process-order" data-id="'+row.id+'"><li>Process Order</li></a><a href="order/printorder/'+row.id+'" target="_blank"><li>Print Order</li></a>@can("Order Edit")<a href="#" class="edit-order" data-id="'+row.id+'"><li>Edit Order</li></a>@endcan';
    }
    else if(row.status == 4) 
    {
        text='<a href="order/printorder/'+row.id+'" target="_blank"><li>Print Order</li></a>';
    }
    else if(row.status == 5)
    {
        text='<a href="#" onClick="changeStatus('+row.id+',6)"><li>Mark Delivered</li></a><a href="order/printorder/'+row.id+'" target="_blank"><li>Print Order</li></a>';
    }
    else if(row.status == 6)  <!-- Delivered //-->
    {
        text='<a href="order/printorder/'+row.id+'" target="_blank"><li>Print Order</li></a>';
    }
    if(row.paidtotal == 0)
    {
        text+='@can("Order Delete")<a data-id="'+row.id+'" data-name="'+row.po_number+'" class="cancelorder"><li>Cancel Order</li></a>@endcan';
    }
    
    table+=`<tr><td>
              <input type="checkbox" name="id[]" id="id-${row.id}" value="${row.id}" ${row.status >=4 ? 'disabled' :''} class="print_check ${row.status < 4 ? 'printed_checked' :''}">
            </td>
            <td class="text-lg-left  text-md-left" data-label="Organization">
              <a href="{{admin_url('orders/orderdetails')}}/${row.id}">${row.invoice_no}</a>
            </td>
            <td class="text-lg-left  text-md-left" data-label="Organization">
              <label class="">${row.shopname}</label>
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
            <td class="text-lg-center  text-md-center" data-label="Organization" style="font-size:16px;">
              ${row.status==1 ? '<span class="badge bg-warning">New Order</span>' : (row.status==2 ? '<span class="badge bg-success"> Accepted</span>':(row.status==3 ? '<span class="badge bg-dark"> Processing</span>':(row.status==4 ? '<span class="badge bg-primary"> Ready</span>':(row.status==5 ? '<span class="badge bg-info"> Dispatching</span>':(row.status==6 ? '<span class="badge bg-danger"> Delivered</span>':(row.status==0 ? '<span class="badge bg-danger"> Backorder</span>':'<span class="badge bg-secondary"> Cancelled </span>')))))) } 
            </td>
            
            <td class="text-right" >
              <div class="fh_actions pull-right">
                <a href="#" class="fh_link">Actions <i class="fa fa-caret-down"></i> </a>
                  <ul class="fh_dropdown">
                  `+text+`
                    <a href="{{admin_url('orders/orderdetails')}}/${row.id}"><li>View</li></a>
                    
                  </ul>
              </div>
            </td>
          </tr>`;
          
          
          
  });
  $('tbody.append-row').html(table ? table : `<tr><td colspan="10" class="text-center">No data found</td><tr>`);
  $('.paginate').html(response.links);
}
</script>
<script  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA2pKP9bGJRpU-35sWLBgirftfBgLhc03c&callback=initAutocomplete&libraries=places&v=weekly"  async ></script>
@endsection