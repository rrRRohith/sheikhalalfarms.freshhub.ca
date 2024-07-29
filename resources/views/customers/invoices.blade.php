@extends('layouts.customer')
@section('title','Invoices')
@section('page_title','Sales & Financials')
@section('page_nav')
<ul>
    <li><a href="{{customer_url('orders')}}">All Orders</a></li>
    <li class="active"><a  href="{{customer_url('invoices')}}">Invoices</a>
    <li><a  href="{{customer_url('backorders')}}">Backorders</a></li>
</ul>
@endsection
@section('contents')
<div class="content-container">
   <div class="content-area">
      <div class="row main_content">
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding">
            <div class="card no-margin minH">
               <div class="card-block">
                   <button id="new-order" class="green_button pull-right">

                            <clr-icon shape="plus-circle"></clr-icon> New order 

                        </button>
                  <h3>Invoices</h3>
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
                                 <div class="row">
                                            <div class="col-sm-12">
                                                <div class="row" id="filter_form">
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label>Search</label>
                                                            <input type="text"  name="search" id="table-search"  value="{{Request()->search}}" class="form-control" placeholder="Search with Invoice number,PO number" />
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                 <div class="table-list-responsive-md">
                                    <table class="table table-customer mt-0">
                                                <thead>
                                                    <tr>
                                                        <!--<th class="text-left">Id</th>-->
                                                        <th class="text-center"><a class="sort" href="#invoice_number" data-sort="invoice_number" data-direction="desc">Invoice No <i class="ml-2 fa fa-sort"></i></a></th>
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
                                 </div>
                              </div>
                           </div>
                        </div>
                     </section>
                     <div class="p-0 col-lg-4 mr-auto paginate d-flex" data-sort="" data-direction=""></div>
                  </section>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@include('customers.order-modal')
<div id="invoice-modal" style="display: none;">
	    
	    <div class="invoice-wrapper">
	        <div class="invoice-close"><a style="font-size:35px;font-weight:normal; line-height:100%;cursor:pointer;"> X</a><!--<i class="fa fa-close"></i>--></div>
	        <iframe src="" title="Invoice Details" id="invoice-details" style="width:100%;"></iframe>
	        <div id="invoice-buttons">
	            <a href="#" class="btn green_button pull-right" target="_blank" id="print-invoice">
                                                   <i class="fa fa-print" aria-hidden="true"></i>  Print Invoice</a> &nbsp; 
                   <a href="#"  class="btn green_button pull-right" target="_blank" id="pdf-invoice">
                                                   <i class="fa fa-file-pdf-o" aria-hidden="true"></i> Generate PDF</a> 
	        </div>
	    </div>
	    
	</div>
	@include('admin.order.payment-modal')
@endsection
@section('bottom-scripts')
<script>
    $('body').delegate('.viewinv','click',function(){
     var id=$(this).data('id');   
     var url="{{customer_url('invoices')}}/"+id+"/generateinvoice";
     var printurl="{{customer_url('printinvoice')}}/"+id;
     var pdfurl="{{customer_url('generatePDF')}}/"+id;
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
                        $('#customer').val(value.firstname+ " "+value.lastname);
                        $('#customer_id').val(value.id);
                        $('#email').val(value.email);
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
                        
                    });
                    $('#amountreceived').html("$"+tot);
                    $('#amountapply').html("$"+tot);
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
	    var count=$("#items-table tbody tr").length;
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
	        total+=Number(amount);
	    }
	    else
	    {
	        total+=Number($('#payamount-'+i).val());
	    }
	    }
	    }
	   // else
	   // {
	    $('#amountreceived').html("$"+total);
        $('#amountapply').html("$"+total);
	   // }
	});
	$('body').delegate('.checked','change',function(){
	    var count=$("#items-table tbody tr").length;
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
	    $('#amountreceived').html("$"+total);
        $('#amountapply').html("$"+total);
	});
	function addrow($key)
	{
	    $("#items-table tbody").append(`<tr id="row0" class="product_row">
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
</script>
<script>
let searchKey    = $('input#table-search');
let sortDiv = $('div.paginate');
let deferUrl = `{{ customer_url('invoices/defer')}}`;
$(document).ready(function() {

  $.getJSON(`${deferUrl}`,  function(response) {
    renderTable(response);
  });
  $('#table-search').on('keyup', function(){
    loadingRow();
    tableSearch();
  });
  
//   $('#status').on('change', function(){
//      loadingRow();
//      tableSearch();
//   });
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
    await $.getJSON(`${deferUrl}?key=${searchKey.val()}&sort=${sort}&direction=${direction}`, function(response) {
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
    $.getJSON(`${deferUrl}?key=${searchKey.val()}`, function(response) {
       renderTable(response);
     });
}
async function renderTable(response){
  let table = '';
  await response.data.forEach(function(row, index){
    let invoiceDate = new Date(row.created_at).toLocaleDateString('en-us', {year:"numeric", month:"short", day:"numeric"});
    let dueDate = new Date(row.due_date).toLocaleDateString('en-us', {year:"numeric", month:"short", day:"numeric"});
    var due="";
    var duedate=new Date(row.due_date);
    var date=new Date();
    date.setHours(0,0,0,0);
    
    if(duedate < date)
    {
        if((row.grandtotal - row.paidtotal) >0)
        due='class="text-danger"';
    }
    table+=`<tr>
                <td class="text-center">${row.invoice_no}</td>
                <td class="text-center">${invoiceDate}</td>
                <td class="text-center">${row.orderid}</td>
                
                <td class="text-right">${row.subtotal}</td>
                <td class="text-right">${row.tax}</td>
                <td class="text-right">${row.grand_total}</td>
                <td class="text-center"><span `+due+` >${dueDate}</span></td>
                <td class="text-right" style="text-align: right;">
                	<span `+due+`>
                		${row.due_amount}
                	</span>
                </td>
                <td class="text-center">${row.status==0 ? '<span class="text-danger"> Unpaid </span>' :'<span class="text-success">Paid</span>'}</td>
                <td class="text-right">
               
                    <div class="fh_actions">
                        <a href="#" class="fh_link">Actions <i class="fa fa-caret-down"></i> </a>
                        <ul class="fh_dropdown">
                            <a style="cursor: pointer;"><li class="viewinv" data-id="${row.id}">View Invoice</li></a>
                            
                        </ul>
                    </div> 
                </td>
            </tr>`;
    
          
          
          
          
  });
  $('tbody.append-row').html(table ? table : `<tr><td colspan="10" class="text-center">No data found</td><tr>`);
  $('.paginate').html(response.links);
// <a style="cursor: pointer;" ><li ${row.status == 0 ?' class="makepayment"':''} data-id="${row.id}">Make Payment</li></a>
// <a href="{{customer_url('invoices')}}/${row.id}/del"><li>Delete</li></a>  
}
</script>
<script src="/js/customcust.js" ></script>
<script  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA2pKP9bGJRpU-35sWLBgirftfBgLhc03c&callback=initAutocomplete&libraries=places&v=weekly"  async ></script>
@endsection