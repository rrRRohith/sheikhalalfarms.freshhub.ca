@extends('layouts.admin')
@section('title','Invoices')
@section('page_title','Sales & Financials')
@section('page_nav')
<ul>
     @can('Order View')<li><a href="{{admin_url('orders')}}">All Orders</a></li>@endcan
     @can('Purchase Order View')<li><a  href="{{admin_url('purchaseorders')}}">Purchase Orders</a></li>@endcan
     @can('Invoices View')<li class="active"><a  href="{{admin_url('invoices')}}">Invoices</a></li>@endcan
     @can('Backorder View')<li><a  href="{{admin_url('backorders')}}">Backorders</a></li>@endcan
    
</ul>
@endsection
@section('contents')
<div class="content-container">
    <div class="content-area">
        <div class="row main_content">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 addnew_form">
                <div class="card no-margin minH">
                    <div class="card-block">
                        <!--<div class="headercnt_top">-->
                            <div class="card_title">
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
                                <h3>Invoices</h3>
                            </div>
                        <!--    <div class="clearfix"></div>-->
                        <!--</div> -->
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
                                                <div class="row" id="filter_form">
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label>Search</label>
                                                            <input type="text"  name="search" id="table-search"  value="{{Request()->search}}" class="form-control" placeholder="Search with Store Name,Invoice number,PO number" />
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label>Store</label>
                                                            <select name="store" id="store"  class="form-control">
                                                                <option value="">Select Store Name</option>
                                                                @foreach($customers as $customer)
                                                                <option value="{{$customer->id}}" @if(Request()->store==$customer->id) selected @endif>{{$customer->business_name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="table-list-responsive-md">
                                            <form method="post" action="{{admin_url('printinvoice')}}" id="print_form" target="_blank">
                                              @csrf
                                              <input type="checkbox" name="selectall" id="selectall"> Select All
                                            <table class="table table-customer mt-0">
                                                <thead>
                                                    <tr>
                                                        <!--<th class="text-left">Id</th>-->
                                                        <th class="text-left">#</th>
                                                        <th class="text-center"><a class="sort" href="#invoice_number" data-sort="invoice_number" data-direction="desc">Invoice No <i class="ml-2 fa fa-sort"></i></a></th>
                                                        <th class="text-left">Store Name</th>
                                                        <th class="text-center"><a class="sort" href="#created_at" data-sort="created_at" data-direction="desc">Invoice Date <i class="ml-2 fa fa-sort"></i></a></th>
                                                        <th class="text-center"><a class="sort" href="#order_id" data-sort="order_id" data-direction="desc">PO Number <i class="ml-2 fa fa-sort"></i></a></th>
                                                        

                                                        <th class="text-right"><a class="sort" href="#sub_total" data-sort="sub_total" data-direction="asc">Sub Total <i class="ml-2 fa fa-sort"></i></a></th>
                                                        <th class="text-right"><a class="sort" href="#tax" data-sort="tax" data-direction="asc">Tax <i class="ml-2 fa fa-sort"></i></a></th>
                                                        <th class="text-right"><a class="sort" href="#grand_total" data-sort="grand_total" data-direction="asc">Grand Total <i class="ml-2 fa fa-sort"></i></a></th>
                                                        <th class="text-center"><a class="sort" href="#due_date" data-sort="due_date" data-direction="asc">Due Date <i class="ml-2 fa fa-sort"></i></a></th>
                                                        <th class="text-right">Due Amount</th>
                                                        <th class="text-center"><a class="sort" href="#status" data-sort="status" data-direction="asc">Status <i class="ml-2 fa fa-sort"></i></a></th>
                                                        <th class="text-right">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="append-row">
                                                    <tr><td colspan="11" class="text-center">Loading Data...</td><tr>
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
@include('admin.product.product-modal')
@include('admin.customer.customer-error')
@include('admin.product.addstock')
@include('admin.customer.duelist')
@include('admin.order.payment-modal')
@include('admin.order.sent-invoice-modal')
<div id="invoice-modal" style="display: none;">
    
    <div class="invoice-wrapper">
        <div class="invoice-close"><a style="font-size:35px;font-weight:normal; line-height:100%;cursor:pointer;"> X</a></div>
        
        <iframe src="" title="Invoice Details" id="invoice-details" style="width:100%;"></iframe>
        <div id="invoice-buttons">
            <div class="container">
                <a href="#" class="btn green_button" target="_blank" id="print-invoice">
                                                    <i class="fa fa-print" aria-hidden="true"></i>  Print Invoice</a> &nbsp; 
                <a href="#"  class="btn green_button" target="_blank" id="pdf-invoice">
                                                <i class="fa fa-file-pdf-o" aria-hidden="true"></i> Generate PDF</a> 
                                           
            </div>                                    
      </div>  
    </div>
    
</div>
<div id="stock_modal" style="display: none;">
    <div class="modal_box">
        <div class="modal_title">
            <a class="pull-right close"><i class="fa fa-close"></i></a>
            <h3><span id="mhead">Cancel Invoice</span></h3>
        </div>
        <div class="modal_body">
            <div class="px-lg-3 no-padding fh_form" id="addAccountForm">
                <form class="pt-0" id="stock_form" method="post" action="{{admin_url('invoices/cancel')}}">
                    @csrf
                    <input type="hidden" name="id" id="id1">
                    <section class="form-block">
                        <div class="row">
                            <div class="col-md-12">  
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <label class="text-gray-dark" for="opportunity_source_id"> Invoice Number : <span id="prname"></span></label>
                                        
                                        
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


<!--@include('admin.customer.customer-error')-->
@endsection
@section('bottom-scripts')
<script>
    $('body').delegate('.cancelinvoice','click',function(e){
        e.preventDefault();
        $('#id1').val($(this).data('id'));
        $('#prname').html($(this).data('name'));
           $('#stock_modal').fadeIn('slow');
    });
    $("#stock_modal .close").click(function(e){
		e.preventDefault();
		$("#stock_modal").fadeOut(50);
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
<!--<script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>-->
<!--<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js" ></script>-->
 <script>
 $('body').delegate('.viewinv','click',function(){
     var id=$(this).data('id');   
     var url="{{admin_url('orders')}}/"+id+"/generateinvoice";
     var printurl="{{admin_url('printinvoice')}}/"+id;
     var pdfurl="{{admin_url('generatePDF')}}/"+id;
     $('#invoice-modal').fadeIn('slow');
     $('#invoice-details').attr('src', url);
     $('#print-invoice').attr('href',printurl);
     $('#pdf-invoice').attr('href',pdfurl);
 });

 

 $('#invoice-modal .invoice-close').click(function(e){
		e.preventDefault();
		$("#invoice-modal").fadeOut(50);
 });
 
 $('body').delegate('.makepayment','click',function(){
     var id=$(this).data('id');
     $.ajax({
         url:"{{admin_url('invoices/getcustdetails')}}/"+id,
                type:"GET",
                dataType:"json",
                success:function(data)
                {
                    $.each(data,function(key,value)
                    {
                        $('#customer1').val(value.firstname+ " "+value.lastname);
                        $('#customer_id1').val(value.id);
                        $('#email1').val(value.email);
                        $('#paymentmethod').val(value.payment_method);
                       
                    });
                }
         
     });
     $.ajax({
         url:"{{admin_url('invoices/getdetails')}}/"+id,
                type:"GET",
                dataType:"json",
                success:function(data)
                {
                    $('#items-table tbody').empty();
                    var tot=0;
                    $.each(data,function(key,value){
                        addrow(key);
                        $('#invid-'+key).val(value.id);
                        
                        if(id == value.id) {
                            $('#invid-'+key).prop('checked', true);
                            $('#payamount-'+key).val(value.grand_total-value.paid_total);
                            tot+=value.grand_total-value.paid_total;
                        }
                        
                        $('#description-'+key).html(value.invoice_number);
                        $('#due_date-'+key).html(value.due_date);
                        $('#original_amount-'+key).html("$"+value.grand_total);
                        $('#balance-'+key).html("$"+(value.grand_total-value.paid_total));
                        $('#balamount-'+key).val(value.grand_total-value.paid_total);
                        // $('#payamount-'+key).val(value.grand_total-value.paid_total);
                        $('#payamount-'+key).attr("name","payamount["+value.id+"]");
                        
                    });
                    $('#amountreceived').html("$"+tot.toFixed(2));
                    $('#amountapply').html("$"+tot.toFixed(2));
                    $('#amountcredit').html("$0.00");
                    
                }
     });
     $('#payment_modal').fadeIn('slow');
 });
$('#payment_modal .close').click(function(e){
		e.preventDefault();
		$("#payment_modal").fadeOut(50);
	});
	$('body').delegate('.paidamount','keyup',function(){
	    var count=$("#items-table1 tbody tr").length;
	    var total=0;
	    for(var i=0;i<count;i++)
	    {
	    var amount=$('#balamount-'+i).val();
	    var pay=$('#payamount-'+i).val();
	    if($('#invid-'+i).prop('checked') == true)
	        {
	    if(Number(pay) > Number(amount))
	    {
	        $('#payamount-'+i).val(amount);
	        alert("Please check the payment amount.");
	        total+=Number(amount.toFixed(2));
	    }
	    else
	    {
	        total+=Number($('#payamount-'+i).val());
	    }
	    }
	    }
	   // else
	   // {
	    $('#amountreceived').html("$"+total.toFixed(2));
        $('#amountapply').html("$"+total.toFixed(2));
	   // }
	});
	$('body').delegate('.checked','change',function(){
	    var count=$("#items-table1 tbody tr").length;
	    var total=0;
	    for(var i=0;i<count;i++)
	    {
	        if($('#invid-'+i).prop('checked') == true)
	        {
	            total +=Number($('#balamount-'+i).val());
	            $('#payamount-'+i).val($('#balamount-'+i).val());
	        }
	        else
	        {
	            $('#payamount-'+i).val('');
	        }
	    }
	    $('#amountreceived').html("$"+total.toFixed(2));
        $('#amountapply').html("$"+total.toFixed(2));
	});
	function addrow($key)
	{
	    $("#items-table1 tbody").append(`<tr id="row0" class="product_row">
                        <td class="text-center number_column" valign="middle"><span class="row-id" style="display:none">0</span><input type="checkbox" name="invid[]" id="invid-`+$key+`" class="checked"></td>
                        <td class="text-left">
                            <span id="description-`+$key+`"></span>
                        </td>
                        <td class="text-left" ><span id="due_date-`+$key+`"></span></td>
                        <td class="text-right"><span id="original_amount-`+$key+`"></span></div></td>
                        <td class="text-right"><input type="hidden" name="balamount[]" id="balamount-`+$key+`"><span id="balance-`+$key+`"></span></td>
                        <td class="text-right"><input type="text" name="payamount[]" id="payamount-`+$key+`"  class="form-control paidamount" style="text-align:right;"/></td>
                        
                    </tr>`);
	}
$("#print_form").submit(function(e){
    if($('.printed_checked:checked').length < 1) {
        e.preventDefault();
        alert('Please select atleast one invoice for print');
    }
})
 </script>
 <script src="/js/custom.js" ></script>
<script>
let searchKey    = $('input#table-search');
let searchBystore   = $('select#store');
let sortDiv = $('div.paginate');
let deferUrl = `{{ admin_url('invoices/defer')}}`;
$(document).ready(function() {

  $.getJSON(`${deferUrl}`,  function(response) {
    renderTable(response);
  });
  $('#table-search').on('keyup', function(){
    loadingRow();
    tableSearch();
  });
  $('#store').on('change', function(){
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
    await $.getJSON(`${deferUrl}?key=${searchKey.val()}&store=${searchBystore.val()}&sort=${sort}&direction=${direction}`, function(response) {
      renderTable(response);
      srtTH.attr('data-direction', direction == 'asc' ? 'desc' : 'asc');
    });
  });
});
function loadingRow()
{
  $('tbody.append-row').html(`<tr><td colspan="11" class="text-center">Loading Data...</td><tr>`);
}
function tableSearch()
{
    $.getJSON(`${deferUrl}?key=${searchKey.val()}&store=${searchBystore.val()}`, function(response) {
       renderTable(response);
     });
}
async function renderTable(response){
  let table = '';
  await response.data.forEach(function(row, index){
    let invoiceDate = new Date(row.created_at).toLocaleDateString('en-us', {year:"numeric", month:"short", day:"numeric"});
    let dueDate = new Date(row.due_date).toLocaleDateString('en-us', {year:"numeric", month:"short", day:"numeric"});
    var due="";
    var payment='';
    var cancel='';
    var duedate=new Date(row.due_date);
    var date=new Date();
    date.setHours(0,0,0,0);
    
    if(duedate < date)
    {
        if((row.grandtotal - row.paidtotal) >0)
        due='class="text-danger"';
    }
    if(row.status==0)
    {
        payment='@can("Make Payment")<a style="cursor: pointer;" ><li class="makepayment" data-id="'+row.id+'">Make Payment</li></a>@endcan';
    }
    if(row.paidtotal==0)
    {
        cancel='@can("Invoices Delete")<a class="cancelinvoice" data-id="'+row.id+'" data-name="'+row.invoice_no+'"><li>Cancel Invoice</li></a>@endcan';
    }
    
    table+=`<tr>
                <td><input type="checkbox" name="id[]" id="id-${row.id}" value="${row.id}"  class="printed_checked"></td>
                <td class="text-center">${row.invoice_no}</td>
                <td class="text-left">${row.shopname}</td>
                <td class="text-center">${invoiceDate}</td>
                <td class="text-center">${row.orderid}</td>
                
                <td class="text-right">${row.subtotal}</td>
                <td class="text-right">${row.tax}</td>
                <td class="text-right">${row.grand_total}</td>
                <td class="text-center"><span `+due+`>${dueDate}</span></td>
                <td class="text-right" style="text-align: right;">
                	<span `+due+`>
                		${row.due_amount}
                	</span>
                </td>
                <td class="text-center">${row.status==0 ? '<span class="text-danger"> Unpaid </span>' : ((row.status==1) ? '<span class="text-success">Paid</span>' : '<span class="text-primary">Cancelled</span>')}</td>
                <td class="text-right">
               
                    <div class="fh_actions">
                        <a href="#" class="fh_link">Actions <i class="fa fa-caret-down"></i> </a>
                        <ul class="fh_dropdown">
                            <a style="cursor: pointer;"><li class="viewinv" data-id="${row.id}" >View Invoice</li></a>
                            <a style="cursor: pointer;"><li class="editinv" data-id="${row.id}" >Edit Invoice</li></a>`+payment+``+cancel+`
                            
                            
                        </ul>
                    </div> 
                </td>
            </tr>`;
    // href="invoices/cancel/${row.id}"
          
          
          
          
  });
  $('tbody.append-row').html(table ? table : `<tr><td colspan="11" class="text-center">No data found</td><tr>`);
  $('.paginate').html(response.links);
//<a href="{{admin_url('invoices')}}/${row.id}/del"><li>Delete</li></a>   
}
</script>
<script  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA2pKP9bGJRpU-35sWLBgirftfBgLhc03c&callback=initAutocomplete&libraries=places&v=weekly"  async ></script>
@endsection