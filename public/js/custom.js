$(document).ready(function(){
	let customers = [];
	let products = [];
	let defweight = '';
	let tax='';
	let weightvalue='';
// 	let getweight = '';
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const request = urlParams.get('request');

    if(request=='new')
    {
        $("#full_modal").fadeIn(50);
		$("#table-container").html('');
		$("#order-modal-title").text('Create new order');
		$("#order_form").attr("action","/admin/orders/create-po");
		$("#form-action").val("create");
		$(".print").css("display","none");
		$(".submit").css("display","inline");
		$(".save").css("display","none");
		$(".save_send").css("display","none");
		addOrderTable();
    }

	init();

	function init() {

		$.get({
			url:'/admin/helpers/def-weight',
			success: function(data) {
				defweight = data.result;
			},
			fail: function(error) {
				console.log(error);
			}
		});
		$.get({
			url:'/admin/helpers/gettax',
			success: function(data) {
				tax = data.result;
			},
			fail: function(error) {
				console.log(error);
			}
		});
		$.get({
			url:'/admin/helpers/defweightvalue',
			success: function(data) {
				weightvalue = data.result;
			},
			fail: function(error) {
				console.log(error);
			}
		});
		
	}

	$(".fh_dropdown a").click(function(e){
		$(".fh_dropdown").fadeOut(50)
	});

	function showPrice(num) {
		return '$'+(Math.round(num * 100) / 100).toFixed(2);
	}


	/******************* Order Modal **************************/

	$("body").click(function(e){
		//$(".pulldown-menu").fadeOut(50);
	})

	// Show modal
	$("#new-order1").click(function(){
	    $("#full_modal").fadeIn(50);
		$("#table-container").html('');
		$("#order-modal-title").text('Create new order');
		$("#order_form").attr("action","/admin/orders/create-po");
		$("#form-action").val("create");
		$(".print").css("display","none");
		$(".submit").css("display","inline");
		$(".save").css("display","none");
		$(".save_send").css("display","none");
		$("#order_id").val('');
	 	$("#customer").val('');
 		$("#email").val('');
		$("#address").val('');
		$("#postalcode").val('');
		$("#city").val('');
		$("#province").val('');
		$('#selectone').css('display','block');
		$("#delivery_address").val('');
		$("#delivery_postalcode").val('');
		$("#delivery_city").val('');
		$("#delivery_province").val('');
		
// 		$("#order_date").val(new Date());
// 		$("#delivery_date").val('');
		$("#due_date").val('');
		$("#sales_rep").val(0);
		$("#driver_id").val('');
		$("#terms").val('');
		$("#customer_id").val('');
		$("#notes").val('');
		$("#discount").val('');
		$("#total_due").text(`$0.00`)
		addOrderTable();
	    
	});
	$('#type').click(function(){
	    var v=$(this).val();
	    if(v=='order')
	    {
	        $("#full_modal").fadeIn(50);
    		$("#table-container").html('');
    		$("#order-modal-title").text('Create new order');
    		$("#order_form").attr("action","/admin/orders/create-po");
    		$("#form-action").val("create");
    		$(".print").css("display","none")
    		$(".save").css("display","none");
    		$(".save_send").css("display","none");
    		$(".submit").css("display","inline");
    		$(".clear").css("display","inline");
    		$("#order_id").val('');
    	 	$("#customer").val('');
     		$("#email").val('');
    		$("#address").val('');
    		$("#postalcode").val('');
    		$("#city").val('');
    		$("#province").val('');
    		
    		$("#delivery_address").val('');
    		$("#delivery_postalcode").val('');
    		$("#delivery_city").val('');
    		$("#delivery_province").val('');
		
    // 		$("#order_date").val(new Date());
    // 		$("#delivery_date").val('');
    		$("#due_date").val('');
    		$("#sales_rep").val(0);
    		$("#driver_id").val('');
    		$("#terms").val('');
    		$("#customer_id").val('');
    		$("#notes").val('');
    		$("#discount").val('');
    		$("#total_due").text(`$0.00`)
    		addOrderTable();
	    }
	    else
	    {
	        
	        $("#full_modal").fadeIn(50);
    		$("#table-container").html('');
    		$("#order-modal-title").text('Create Invoice');
    		$("#order_form").attr("action","/admin/orders/create-invoice");
    		$("#form-action").val("createinvoice");
    		$(".print").css("display","none");
    		$(".submit").css("display","none");
    		$(".save").css("display","inline");
    		$(".save_send").css("display","inline");
    		$(".clear").css("display","inline");
    		$("#order_id").val('');
    	 	$("#customer").val('');
     		$("#email").val('');
    		$("#address").val('');
    		$("#postalcode").val('');
    		$("#city").val('');
    		$("#province").val('');
    		
    		$("#delivery_address").val('');
    		$("#delivery_postalcode").val('');
    		$("#delivery_city").val('');
    		$("#delivery_province").val('');
    		
    // 		$("#order_date").val(new Date());
    // 		$("#delivery_date").val('');
    		$("#due_date").val('');
    		$("#sales_rep").val(0);
    		$("#driver_id").val('');
    		$("#terms").val('');
    		$("#customer_id").val('');
    		$("#notes").val('');
    		$("#discount").val('');
    		$("#total_due").text(`$0.00`)
    		addOrderTable();
	    }
	});

	$("#new-order").click(function(e)
	{
		$("#full_modal").fadeIn(50);
		$("#table-container").html('');
		$("#order-modal-title").text('Create new order');
		$("#order_form").attr("action","/admin/orders/create-po");
		$("#form-action").val("create");
		$(".print").css("display","none")
		$(".submit").css("display","inline");
		$(".save").css("display","none");
		$(".save_send").css("display","none");
		$(".clear").css("display","inline");
		$("#order_id").val('');
	 	$("#customer").val('');
 		$("#email").val('');
		$("#address").val('');
		$("#postalcode").val('');
		$("#city").val('');
		$("#province").val('');
		
		$("#delivery_address").val('');
		$("#delivery_postalcode").val('');
		$("#delivery_city").val('');
		$("#delivery_province").val('');
		
// 		$("#order_date").val(new Date());
// 		$("#delivery_date").val('');
		$("#due_date").val('');
		$("#sales_rep").val(0);
		$("#driver_id").val('');
		$("#terms").val('');
		$("#customer_id").val('');
		$("#notes").val('');
		$("#discount").val('');
		$("#total_due").text(`$0.00`);
		addOrderTable();
	})
	$("#new-invoice").click(function(e){
		$("#full_modal").fadeIn(50);
		$("#table-container").html('');
		$("#order-modal-title").text('Create Invoice');
		$("#order_form").attr("action","/admin/orders/create-invoice");
		$("#form-action").val("createinvoice");
		$(".print").css("display","none")
	    $(".submit").css("display","none");
		$(".save").css("display","inline");
		$(".save_send").css("display","inline");
		$(".clear").css("display","inline");
		$("#order_id").val('');
	 	$("#customer").val('');
 		$("#email").val('');
		$("#address").val('');
		$("#postalcode").val('');
		$("#city").val('');
		$("#province").val('');
		
		$("#delivery_address").val('');
		$("#delivery_postalcode").val('');
		$("#delivery_city").val('');
		$("#delivery_province").val('');
		
// 		$("#order_date").val(new Date());
// 		$("#delivery_date").val('');
		$("#due_date").val('');
		$("#sales_rep").val(0);
		$("#driver_id").val('');
		$("#terms").val('');
		$("#customer_id").val('');
		$("#notes").val('');
		$("#discount").val('');
		$("#total_due").text(`$0.00`)
		addOrderTable();
	})

	// Hide Modal

	$("#full_modal .close").click(function(e){
		e.preventDefault();
		$("#full_modal").fadeOut(50);
	})
	
	/****************** Order Functions ***************************/ 

	// Make editable when clicked

	$("body").delegate(".product_row","click",function(){
		$('.product_row').find('input').addClass('noneditable');
		$(this).find("input").removeClass("noneditable");
	})

	// Remove an item

	$("body").delegate(".trash-row","click",function(){
		if($("#items-table tbody tr").count>0 && confirm('Are you sure to delete?')) {
		    $(this).parent().parent().remove();
		    addRow();
		} 
	});

	// Create a table list for order items

	function addOrderTable() {
	    let action = $("#form-action").val();
	    if(action=='create' || action=='edit')
	    {
		$("#table-container").append(`
		<input type="hidden" name="order_id" value="" id="order_id" />
				<table class="table order_table" id="items-table">
                    <thead>
                        <tr>
                            <th class="number_column">#</th>
                            <th class="sku_column">Product Code</th>
                            <th width="30%">Product</th>
                            
                            <th width="30%" class="description_column">Description</th>
                            
                            <th>Qty</th>
                            <th>Price</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>                       
                    </tbody>
                    <tfoot style="display:none">
                    	<tr>
                    		<td colspan="5" style="text-align:right;">Discount</td>
                    		<td><input type="text" name="discount" id="discount" style="text-align:right;" /></td>
                    		<td>&nbsp;</td>
                    	</tr>
                    	<tr>
                    		<td colspan="5" style="text-align:right;">Tax</td>
                    		<td><input type="text" name="tax" id="tax" style="text-align:right;" /></td>
                    		<td>&nbsp;</td>
                    	</tr>
                   		<tr>
                    		<td colspan="5"></td>
                    		<td><div id="net-total" class="text-right"></div></td>
                    		<td>&nbsp;</td>
                    	</tr>
                    	
                    </tfoot>
                 </table>`);
	    }
	    else
	    {
	        $("#table-container").append(`
		<input type="hidden" name="order_id" value="" id="order_id" />
				<table class="table order_table" id="items-table">
                    <thead>
                        <tr>
                            <th class="number_column">#</th>
                            <th class="sku_column" width="10%">Product Code</th>
                            <th width="25%">Product</th>
                            
                            <th width="15%" class="description_column">Description</th>
                            <th width="10%">Qty</th>
                            <th width="10%">Price</th>
                            <th width="10%">Weight (`+defweight+`)</th>
                            
                            <th width="10%">Amount</th>
                            <th width="10%">Tax</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>                       
                    </tbody>
                    <tfoot>
                    	<tr>
                    		<td colspan="8" style="text-align:right;">Discount</td>
                    		<td><input type="text" name="discount" id="discount" style="text-align:right;" /></td>
                    		<td>&nbsp;</td>
                    	</tr>
                    	<tr>
                    		<td colspan="8" style="text-align:right;">Tax</td>
                    		<td><div id="net-tax" class="text-right"></div></td>
                    		<td>&nbsp;</td>
                    	</tr>
                   		<tr>
                    		<td colspan="8" style="text-align:right;">Total</td>
                    		<td><div id="net-total" class="text-right"></div></td>
                    		<td>&nbsp;</td>
                    	</tr>
                    	
                    </tfoot>
                 </table>`);
	    }
		addRow('order')
	}

	// Remove unwanted rows

	function resetRows() {
		addRow();

		$(".product-id").each(function(){
			if($(this).val() != '') {
				$(this).parent().parent().remove();
			}
		});
		orderRow();
	}

	// Add new row to the items table

	function addRow(type) {
		var allfilled = true;

		$("#items-table tbody tr").find(".product-id").each(function(){
			if($(this).val() == '') 
				allfilled = false;
		});
		
		let action = $("#form-action").val();

		if(allfilled && action == 'createinvoice')
		{
		    //<div class="product-sku"></div> 
		    $("#items-table tbody").append(`<tr id="row0" class="product_row">
                        <td class="text-center number_column" valign="middle"><span class="row-id">0</span></td>
                        <td class="sku_column">
                            <input type="text" name="product_sku[]" class="form-control noneditable product-sku" autocomplete="off" />
                           
                        </td>
                        <td>
                            <input type="text" name="product_names[]" class="form-control noneditable product-name" autocomplete="off" />
                            <input type="hidden" name="product_ids[]" value="" class="product-id" data-priceby="" data-id=""/>
                        </td>
                        
                        <td class="description_column">
                            <input type="text" name="product_description[]" class="form-control product-description noneditable " autocomplete="off" />
                        
                        </td>
                        <td width="100">
                        <input type="number" name="quantities[]"  min="1" step="1" class="form-control noneditable product-quantity" data-qty=""/>
                        <input type="hidden" name="originalquantities[]" value="1" class="product-required" />
                    	<input type="hidden" name="weightlist[]" value="0" class="weight-list"/>
                    	<a href="#" class="process-item" data-value="invoice" style="display:none"><i class="fa fa-edit"></i></a>
                        </td>
                        <td width="100"><input type="number" class="form-control noneditable product-rate" step=".01" data-rate="" name="rates[]"></td>
                        <td width="100" class="text-center"><input type="number" min="0" step=".01" name="weights[]" data-weight="" value="" class="form-control noneditable product-weight" pattern="[0-9]"/></td>
                        <td><div class="product-total"></div></td>
                        <td><div class="product-tax"></div></td>
                        <td class="text-center" valign="middle"><big><a href="#" class="trash-row"><i class="fa fa-trash"></i></a></big></td>
                    </tr>`);
		} else if(allfilled && action == 'editinvoice') {

				//<div class="product-sku"></div> 
				$("#items-table tbody").append(`<tr id="row0" class="product_row">
							<td class="text-center number_column" valign="middle"><span class="row-id">0</span></td>
							<td class="sku_column">
								<input type="text" name="product_sku[]" class="form-control noneditable product-sku" autocomplete="off" />
							   
							</td>
							<td>
								<input type="text" name="product_names[]" class="form-control noneditable product-name" autocomplete="off" />
								<input type="hidden" name="product_ids[]" value="" class="product-id" data-priceby="" data-id=""/>
							</td>
							
							<td class="description_column"><input type="text" name="product_description[]" class="form-control product-description  noneditable " autocomplete="off" /></td>
							<td width="100">
							<input type="number" name="quantities[]"  min="1" step="1" class="form-control noneditable product-quantity" data-qty=""/>
							<input type="hidden" name="originalquantities[]" value="1" class="product-required" />
							<input type="hidden" name="weightlist[]" value="0" class="weight-list"/>
							<a href="#" class="process-item" data-value="invoice" style="display:none"><i class="fa fa-edit"></i></a>
							</td>
							<td width="100"><input type="number" class="form-control noneditable product-rate" step=".01" data-rate="" name="rates[]"></td>
							<td width="100" class="text-center"><input type="number" min="0" step=".01" name="weights[]" data-weight="" value="" class="form-control noneditable product-weight" pattern="[0-9]"/></td>
							<td><div class="product-total"></div></td>
							<td><div class="product-tax"></div></td>
							<td class="text-center" valign="middle"><big><a href="#" class="trash-row"><i class="fa fa-trash"></i></a></big></td>
						</tr>`);


		} else if(allfilled && action != 'createinvoice') {
		    //<div class="product-sku"></div> 
			$("#items-table tbody").append(`<tr id="row0" class="product_row">
                        <td class="text-center number_column" valign="middle"><span class="row-id">0</span></td>
                        <td class="sku_column">
                        <input type="text" name="product_sku[]" class="form-control noneditable product-sku" autocomplete="off" />
                        </td>
                        <td>
                            <input type="text" name="product_names[]" class="form-control noneditable product-name" autocomplete="off" />
                            <input type="hidden" name="product_ids[]" value="" class="product-id" data-priceby="" data-id=""/>
                        </td>
                        
                        <td class="description_column"><input type="text" name="product_description[]" class="form-control product-description noneditable " autocomplete="off" /></td>
                        
                        <td width="100"><input type="number" name="quantities[]"  min="1" step="1" class="form-control noneditable product-quantity" data-qty=""/></td>
                        <td width="100"><div class="product-rate"></div></td>
                        
                        <td class="text-center" valign="middle"><big><a href="#" class="trash-row"><i class="fa fa-trash"></i></a></big></td>
                    </tr>`);
			
		}
		
		orderRow();
	}
// 	function addProcessRow(type) {
// 		var allfilled = true;

// 		$("#items-table tbody tr").find(".product-id").each(function(){
// 			if($(this).val() == '') 
// 				allfilled = false;
// 		});

// 		if(allfilled) {
// 			$("#items-table tbody").append(`<tr id="row0" class="product_row">
//                         <td class="text-center number_column" valign="middle"><span class="row-id">0</span></td>
//                         <td>
//                             <input type="text" name="product_names[]" class="form-control noneditable product-name" autocomplete="off" />
//                             <input type="hidden" name="product_ids[]" value="" class="product-id" data-priceby=""/>
//                         </td>
//                         <td class="sku_column"><div class="product-sku"></div></td>
                        
//                         <td><div class="product-rate" data-rate=""></div></td>
//                         <td width="100" class="text-center"><input type="number" min="0" step="any" name="weights[]" data-weight="" value="" class="form-control noneditable product-weight" pattern="[0-9]"/></td>
//                         <td width="150"><input type="number" name="quantities[]"  min="1" step="1" class="form-control noneditable product-quantity" />
//                         <a href="#" class="process-item"><i class="fa fa-edit"></i></a></td>
//                         <td><div class="product-total text-right"></div></td>
                        
//                     </tr>`);
			
// 		}
// 		orderRow();
// 	}


	// Reorder the product items row


	function orderRow() {
		$("#items-table tbody tr").each(function(index){
			$(this).attr("id","row"+(index+1));
			$(this).find(".row-id").text(index+1);
		})
	}

	// Trash a row

	$("body").delegate(".trash-row","click",function(){
		if($("#items-table tbody tr").length >0 && confirm('Are you sure to delete?')) {
		   $(this).closest('tr').remove();
		    addRow();
		} 
	})
	
	$("body").delegate(".clear","click",function(){
	    let action = $("#form-action").val();
	    if(action=='create')
	    {
	       // $("#full_modal").fadeOut(50);
	       // $("#full_modal").fadeIn(50);
    		$("#table-container").html('');
    // 		$("#order-modal-title").text('Create new order');
    // 		$("#order_form").attr("action","/admin/orders/create-po");
    // 		$("#form-action").val("create");
    // 		$(".print").css("display","none")
    // 		$(".submit").css("display","inline");
    // 		$(".save").css("display","none");
    // 		$(".save_send").css("display","none");
    		$("#order_id").val('');
    	 	$("#customer").val('');
     		$("#email").val('');
    		$("#address").val('');
    		$("#postalcode").val('');
    		$("#city").val('');
    		$("#province").val('');
    		
    		$("#delivery_address").val('');
    		$("#delivery_postalcode").val('');
    		$("#delivery_city").val('');
    		$("#delivery_province").val('');
    		
    // 		$("#order_date").val(new Date());
    // 		$("#delivery_date").val('');
    		$("#due_date").val('');
    		$("#sales_rep").val(0);
    		$("#driver_id").val('');
    		$("#terms").val('');
    		$("#customer_id").val('');
    		$("#notes").val('');
    		$("#discount").val('');
    		$("#total_due").text(`$0.00`);
    		addOrderTable();
	    }
	    else if(action=='createinvoice')
	    {
	       // $("#full_modal").fadeOut(50);
	       // $("#full_modal").fadeIn(50);
    		$("#table-container").html('');
    // 		$("#order-modal-title").text('Create Invoice');
    // 		$("#order_form").attr("action","/admin/orders/create-invoice");
    // 		$("#form-action").val("createinvoice");
    // 		$(".print").css("display","none")
    // 	    $(".submit").css("display","none");
    // 		$(".save").css("display","inline");
    // 		$(".save_send").css("display","inline");
    		$("#order_id").val('');
    	 	$("#customer").val('');
     		$("#email").val('');
    		$("#address").val('');
    		$("#postalcode").val('');
    		$("#city").val('');
    		$("#province").val('');
    		
    		$("#delivery_address").val('');
    		$("#delivery_postalcode").val('');
    		$("#delivery_city").val('');
    		$("#delivery_province").val('');
    		
    // 		$("#order_date").val(new Date());
    // 		$("#delivery_date").val('');
    		$("#due_date").val('');
    		$("#sales_rep").val(0);
    		$("#driver_id").val('');
    		$("#terms").val('');
    		$("#customer_id").val('');
    		$("#notes").val('');
    		$("#discount").val('');
    		$("#total_due").text(`$0.00`)
    		addOrderTable();
	    }
	   // else if(action=='edit')
	   // {
	   //     $("#table-container").html('');
	   //     $("#customer").val('');
    //  		$("#email").val('');
    // 		$("#address").val('');
    // 		$("#postalcode").val('');
    // 		$("#city").val('');
    // 		$("#province").val('');
    		
    // 		$("#delivery_address").val('');
    // 		$("#delivery_postalcode").val('');
    // 		$("#delivery_city").val('');
    // 		$("#delivery_province").val('');
    		
    // // 		$("#order_date").val(new Date());
    // // 		$("#delivery_date").val('');
    // 		$("#due_date").val('');
    // 		$("#sales_rep").val(0);
    // 		$("#driver_id").val('');
    // 		$("#terms").val('');
    // 		$("#customer_id").val('');
    // 		$("#notes").val('');
    // 		$("#discount").val('');
    // 		$("#total_due").text(`$0.00`);
    // 		addOrderTable();
	   // }
	})

	// When quantity is changed

	$("body").delegate(".product-quantity","change",function(){
	    let action = $("#form-action").val();
	    let proid=$(this).parent().parent().find(".product-id").val();
	    let proname=$(this).parent().parent().find(".product-name").val();
	    let rowid=$(this).parent().parent().attr('id')
	    let qty=$(this).attr("data-qty");
	    if(Number(qty) < $(this).val())
	    {
	        $("#stock_modal1").fadeIn(50);
	        $('#prname').text(proname);
	        $('#avstock').text(qty);
	        $('#pid').val(proid);
	        $('.yesbutton').attr('data-id',proid);
	        $('.yesbutton').attr('data-rowid',rowid);
	        $('.nobutton').attr('data-rowid',rowid);
	       // updateStock(proid);
	    }
	    else
	    {
	    console.log('action:'+action)
	    if(action == 'create' || action == 'edit' || action=='createinvoice') {
	        var itemweight = $(this).parent().parent().find(".product-weight").attr("data-weight");
	        console.log('itemweight:'+itemweight)
	        $(this).parent().parent().find(".product-weight").val(itemweight * $(this).val())
	    }
	    
		showTotQty();
	    }
	})
	
	$("body").delegate(".product-rate","change",function(){
	    let action = $("#form-action").val();
	    console.log('action:'+action)
	   // if(action == 'process' || action=='createinvoice') {
	        var itemrate = $(this).parent().parent().find(".product-rate").val();
	        console.log('itemrate:'+itemrate)
	        $(this).parent().parent().find(".product-rate").attr("data-rate",$(this).val());
	   // }

	/* if($(this).attr("data-price-change-dialog") == 'no') {
		alert('Would like to fix this as new default charge for the customer?');
		$(this).attr("data-price-change-dialog","yes");
	   } */
	    
		showTotQty();
	})

	// Prevent Negative quantity

	$("body").delegate(".product-quantity","keyup",function(e){
		if (e.which < 48 || e.which > 57)
		{
			e.preventDefault();
		}
	})

	// Create the Order when form is submitted

	$("#order_form").submit(function(e){
		e.preventDefault();
		var formvars = $("#order_form").serialize();

		var action = $("#form-action").val();
		if(action == 'create') 
		{
			createOrder(formvars);
		}
		else if(action=='edit')
		{
		    editOrder(formvars);
		}
		else if(action=='createinvoice')
		{
		    createInvoice(formvars);
		}
		else if(action=='editinvoice')
		{
			editInvoice(formvars);
		}
		else 
		{
			checkRates(formvars);
		}
	});

	$('.save_send').click(function(){
	    var formvars = $("#order_form").serialize();
	    var action = $("#form-action").val();
	    if(action=='createinvoice')
	    {
	        var url='/admin/orders/create-invoice';
	       //var url='/admin/orders/checkmailinvoice';
	    }
		if(action=='editinvoice')
	    {
	        var url='/admin/orders/edit-invoice';
	       //var url='/admin/orders/checkmailinvoice';
	    }
	    else
	    {
	        var url='/admin/orders/process-po';
	    }
        $.ajax({
            type: "POST",
            url: url,
            data: formvars,
            dataType:"json",
            success: function(data) {

				console.log(data);

            	if(data.status == 'success') 
            	{
            		$("#order_form").trigger("reset");
            		resetRows();
            		alert(data.message);
            		$("#full_modal").fadeToggle(50);
            		$("#sendinvoice_modal").fadeIn(50);
            		var order=data.data1;
            		$('#orderid').val(order.id);
            		$('#modalto').val(order.email);
            		$('#mailto').html(order.email);
            		$('#modalsubject').val("Invoice#"+order.invoice.invoice_number);
            		$('#mailhead').html("Invoice#"+order.invoice.invoice_number+" details.");
            		$('#mailsubject').html("Invoice#"+order.invoice.invoice_number);
            		var body="To:"+order.user.firstname+" "+order.user.lastname+"<br>We appreciate your business. Please find your invoice details here. Feel free to contact us if you have any questions.<br>Have a great day!<br>Freshhub";
            		$('#modalbody').html(body);
            		$('#mailbody').html(body);
            		let date = new Date(order.invoice.due_date);
	                $('#maildue').html("Due "+('0'+date.getDate()).slice(-2)+ "-" + ('0'+(date.getMonth()+1)).slice(-2) + "-" + date.getFullYear() );
            // 		$('#maildue').html(order.invoice.due_date);
            		$('#mailamount').html("$"+order.invoice.grand_total);
            		$('#mailtext').html("<h4>Bill To : <span>"+order.user.firstname+" "+order.user.lastname+"</span><h4><h4>Terms:<span>"+order.terms+" days</pan></h4> ");
            		var pro="<table border='0' style='text-align: center;width: 100%;'>";
            		var item=order.item;
            		var tot=0;
            		$.each(item,function(i,m){
            		    pro+="<tr class='invoicemodal_row'><th width='50%' class='invoice_send_title'>"+m.product_name+"</th><td width='50%' rowspan='2'>"+m.total+"</td></tr><tr class='invoicemodal_row'><td class='prdct_dtls'>"+m.quantity+" * $"+m.rate+" $"+m.tax+" tax </td></tr>";
            		    tot+=m.total;
            		    });
            		 pro+="<tr class='invoicemodal_row'><th class='invoice_send_title'>Subtotal</th><td>$"+tot+"</td></tr><tr class='invoicemodal_row'><th class='invoice_send_title'>Tax</th><td>$"+order.tax+"</td></tr><tr class='invoicemodal_row'><th class='invoice_send_title'>Discount</th><td>$"+order.discount_amount+"</td></tr><tr class='invoicemodal_row'><th class='invoice_send_title'>Total</th><td>$"+order.grand_total+"</td></tr><tr class='invoicemodal_row'><th class='invoice_send_title'>Balance Due</th><td>$"+(Number(order.grand_total)-Number(order.paid_amount))+"</td></tr></table>"  ; 
            		$('#mailproduct').html(pro);
            // 		location.reload();
            	}
            	else
            	{
            		console.log(data.data);
            		alert(data.message);
            	}
            },
            error: function(xhr, status, error){
            	alert('Some errors in submission, Please retry');
            	if(xhr.status == 422) {
            		var validation = xhr.responseJSON.errors;
            	}

                console.log(xhr);
                console.log(status);
                console.log(error);
            }
        })
	    
	});
	$('body').delegate('#modalsubject','change',function(){
	    var subject=$(this).val();
	    $('#mailsubject').html(subject);
	})
	$('body').delegate('#modalbody','change',function(){
	    var subject=$(this).val();
	    $('#mailbody').html(subject.replace("\n", "<br />"));
	})
	$('body').delegate('.due_link','click',function(){
	    var custid=$(this).attr('data-id');
	    var url="/admin/customers/getdues/"+custid;
	    $.ajax({
			type: "GET",
			url: url,
			dataType: "json",
			success: function(data) {
			    $("#duelist").fadeIn(50);
			    $('#duebody').children('tr').remove();
			    var html="<table class='table'><thead><th>#</th><th>INVOICE #</th><th>Total Amount</th><th>Paid Amount</th><th>Due Amount</th></thead><tbody id='duebody'>";
			    var j=0;
			    $.each(data,function(i,item){
			        if(item.grand_total-item.paid_total >0)
			        {
			            j++;
			            var due=item.grand_total-item.paid_total;
			            var row="<tr><td>"+j+"</td><td>"+item.invoice_number+"</td><td>"+showPrice(item.grand_total)+"</td><td>"+showPrice(item.paid_total)+"</td><td>"+showPrice(due)+"</td></tr>"; 
			            html+=row;
			        }
			    });
			    
			    $("#dueForm").html(html+'</tbody></table>');
			    console.log(data);
			}
	    });
	    
	});


	function createOrder(formvars) {
        var url="/admin/orders";
		$.ajax({
            type: "POST",
            url: '/admin/orders/create-po',
            data: formvars,
            dataType:"json",
            success: function(data) {

				console.log(data);

            	if(data.status == 'success') {
            		$("#order_form").trigger("reset");
            		resetRows();
            		alert(data.message);
            		$("#full_modal").fadeToggle(50);
            // 		location.reload();
            window.location=url;
            	}
            	else
            	{
            		console.log(data.data);
            		alert(data.message);
            	}
            },
            error: function(xhr, status, error){
            	alert('Some errors in submission, Please retry');
            	if(xhr.status == 422) {
            		var validation = xhr.responseJSON.errors;
            	}

                console.log(xhr);
                console.log(status);
                console.log(error);
            }
        })
	}
	
	function createInvoice(formvars) {
        var url="/admin/invoices";
		$.ajax({
            type: "POST",
            url: '/admin/orders/create-invoice',
            data: formvars,
            dataType:"json",
            success: function(data) {

				console.log(data);

            	if(data.status == 'success') {
            		$("#order_form").trigger("reset");
            		resetRows();
            		alert(data.message);
            		$("#full_modal").fadeToggle(50);
            // 		location.reload();
            window.location=url;
            	}
            	else
            	{
            		console.log(data.data);
            		alert(data.message);
            	}
            },
            error: function(xhr, status, error){
            	alert('Some errors in submission, Please retry');
            	if(xhr.status == 422) {
            		var validation = xhr.responseJSON.errors;
            	}

                console.log(xhr);
                console.log(status);
                console.log(error);
            }
        })
	}

	/******************* Customer Search & Creation ********************/

	// Show customer list

	$("#customer").click(function(e){
		//e.stopPropagation();
		$("#customer-list").fadeIn(50);
	})

	// Search and get customers list

	$("#customer").keyup(function(e){
		$.ajax({
			type: "GET",
			url: '/admin/customers/search',
			data: {keyword: $("#customer").val() },
			dataType: "json",
			success: function(data) {
				customers = data;
				$("#customer-list").html('<li><a href="#" id="button_new_customer"><strong>Create New Customer</strong></a></li>');
				$.each(data, function(i, item) {
					$("#customer-list").append('<li><a href="#" class="customer-select" data-id="'+item.id+'"> #'+item.id+' - '+item.business_name+(item.email != null ? ' (' + item.email + ')':'')+ '</a></li>');
				})
			}
		});
	})

	$("#customer-list").click(function(e){
		//e.stopPropagation();
	})

	const zeroPad = (num, places) => String(num).padStart(places, '0')

	// When a customer is selected, pull his/her info

	$("body").delegate(".customer-select","click",function(){
		var selectedid = $(this).attr("data-id");
		$("#customer-list").fadeToggle(50);

		$.each(customers, function(i, item) {
			if(selectedid == item.id) {
				var today = new Date();
				var ddate = new Date();
				var days = '';

				console.log(item)
				$("#customer").val(item.business_name ?? item.firstname + ' ' + item.lastname);
				$("#email").val(item.email);
				$('#address1').val(item.address);
				$("#address").val(item.address+', \n'+item.city+', '+item.province+', \n'+item.postalcode);
				$("#postalcode").val(item.postalcode);
				$("#city").val(item.city);
				$("#province").val(item.province);
				$("#delivery_address1").val(item.address);
				$("#delivery_address").val(item.address+', \n'+item.city+', '+item.province+', \n'+item.postalcode);
				$("#delivery_postalcode").val(item.postalcode);
				$("#delivery_city").val(item.city);
				$("#delivery_province").val(item.province);
				if(item.payment_method !=3){
				    $("#pt").css('display','none');
				    $("#terms").val(0);
				}
				else
				{
			    $("#pt").css('display','block');
				$("#terms").val(item.payment_days);
				}
				$("#customer_id").val(item.id);
            	$("#sales_rep").val(item.sales_rep);
            	$("#driver_id").val(item.driver_id);
            	$(".duedays").text(days);
            	$("#total_due").text(`$`+Number(item.due).toFixed(2));
            	$("#duelink").attr("data-id",item.id);
            	$("#duelink").addClass("due_link");
            	$('#duelink').css('cursor','pointer');
            	setDueDate();

				if(item.email == null) {
					$(".save_send").css("display","none");
				}
				else {
					$(".save_send").css("display","inline");
				}
			}
		})
	})
	
	$("#terms").change(function(){
	    setDueDate();
	})
	
	function setDueDate() {
	    let order_date = new Date($("#order_date").val());
        let terms = $("#terms").val();
        
        if(order_date != '' && terms != '') {
            let due_date = new Date(new Date().getTime() + 24 * 60 * 60 * 1000 * Number(terms));
	        $("#due_date").val(due_date.getFullYear() + "-" + ('0'+(due_date.getMonth()+1)).slice(-2) + "-" + ('0'+due_date.getDate()).slice(-2));
        }
	}
	
	
	
// 	$("body").delegate("#terms","change",function(){
// 	    var today = new Date();
// 		var ddate = new Date();
// 		var days = '';
// 	    days = $('#terms').val() + 'days';
// 		ddate.setDate(today.getDate() + ($('#terms').val()));
// 		var duedate = ddate.getFullYear() + "-" + (ddate.getMonth()+1) + "-" + ddate.getDate();
// 		console.log(duedate)
// 		$(".duedays").text(days);
// 		$("#due_date").val(duedate);
// 	});

	// Show new customer form

	$("body").delegate("#button_new_customer","click",function(e){
		$("#customer_modal").fadeIn(50);
		$("#customer-list").fadeOut(50);
	});

	// Close new customer form

	$("#customer_modal .close").click(function(e){
		e.preventDefault();
		$("#customer_modal").fadeOut(50);
	})
	
	$("#sendinvoice_modal .close").click(function(e){
		e.preventDefault();
		$("#sendinvoice_modal").fadeOut(50);
	})

	// When customer form is submitted

	$("#customer_form").submit(function(e){
		e.preventDefault();
		var formvars = $("#customer_form").serialize();

		$.ajax({
            type: "POST",
            url: $(this).attr("action"),
            data: formvars,
            dataType:"json",
            success: function(data) {

				console.log(data);

            	$("#customer").val(data.user.firstname + ' ' + data.user.lastname);
            	$("#email").val(data.user.email);
            	$('#address1').val(data.user.address);
            	$("#address").val(data.user.address+', \n'+data.user.city+', '+data.user.province+', \n'+data.user.postalcode);
            	$("#postalcode").val(data.user.postalcode);
            	$("#city").val(data.user.city);
            	$("#province").val(data.user.province);
            	$("#delivery_address1").val(data.user.address);
            	$("#delivery_address").val(data.user.address+', \n'+data.user.city+', '+data.user.province+', \n'+data.user.postalcode);
				$("#delivery_postalcode").val(data.user.postalcode);
				$("#delivery_city").val(data.user.city);
				$("#delivery_province").val(data.user.province);
            	$("#delivery_date").val();
            	$("#due_date").val(data.user.due_date);
            	$("#sales_rep").val(data.user.sales_rep);
            	$("#driver_id").val(data.user.driver_id);
            	if(data.user.payment_method !=3)
            	{
				    $("#pt").css('display','none');
				    $("#terms").val(0);
				}
				else
				{
			    $("#pt").css('display','block');
				$("#terms").val(data.user.payment_terms);
				}
            	$("#customer_id").val(data.user.id);

				$("#customer_modal").fadeOut(5);

                console.log(data);
            },
            error: function(xhr, status, error){
            // 	alert('Some errors in submission, Please retry');
            	if(xhr.status == 422) {
            		var validation = xhr.responseJSON.errors;
            	}
        		$('#error').fadeIn('slow');
            	let errtext = '<ul>';
                let errs = xhr.responseJSON.errors;
                
                if(errs != '') {
                $.each(errs, function(idex, er) {
                errtext += '<li>'+er[0]+"</li>\n";
                })
                }
                
                $("#errorForm").html(errtext+'</ul>');

                console.log(xhr);
                console.log(status);
                console.log(error);
            }
        })
	});
	$('body').delegate('#error .close','click',function(e){
		e.preventDefault();
		$("#error").fadeOut(50);
	})
	$('body').delegate('#duelist .close','click',function(e){
		e.preventDefault();
		$("#duelist").fadeOut(50);
	})
	$('body').delegate('#payment_method','change',function(){
    var id=$(this).val();
    if(id==3)
    {
        $('#payment_terms').css('display','block')
    }
    else
    {
        $('#payment_terms').css('display','none')
    }
});

	/******************** Product Search & Creation Functions ********************/

	// When clicked in product field

	$("body").delegate(".product-name","click",function(){
		$("#products-list").fadeToggle(50);
	})

	// Initiate product search for each keypress

	$("body").delegate(".product-name","keyup",function(){
		$("#products-list").remove();
		$(this).parent().append('<ul class="pulldown-menu product-list" id="products-list">' + 
								'<li><a href="#" id="button_new_product"><strong>Create New Product</strong></a></li></ul>');
		products = [];
		var cid = $("#customer_id").val();
		if(cid == '') {
			return false;
		}
		var cid = $("#customer_id").val();

		$.ajax({
			type: "GET",
			url: '/admin/products/search?cid=',
			data: {keyword: $(this).val() },
			dataType: "json",
			success:function(data) {
				console.log(data);
				products = data;
				$.each(products, function(i, prod) {
				    $.ajax({
            type: "get",
            url: "/admin/helpers/getweightprice/"+prod.id+"?cid="+cid,
            success: function(data1) {

                weight=data1.weight+''+defweight;
                rate=data1.price;
					$("#products-list").append('<li><a href="#" class="product-select" data-id="'+prod.id+'"> #'+ prod.sku +' - ' +prod.name + '-'+weight+' @ $'+rate+' ( stock : '+prod.qty+' )</a></li>');
            }
				    });
				});	
				console.log(products);
			},
			error: function(error) {
				console.log(error);
			},
		});
	});
	
	$("body").delegate(".product-sku","click",function(){
		$("#products-list").fadeToggle(50);
	})

	// Initiate product search for each keypress

	$("body").delegate(".product-sku","keyup",function(){
		$("#products-list").remove();
		$(this).parent().append('<ul class="pulldown-menu product-list" id="products-list">' + 
								'</ul>');
		products = [];

		$.ajax({
			type: "GET",
			url: '/admin/products/search/1',
			data: {keyword: $(this).val() },
			dataType: "json",
			success:function(data) {
				products = data;
				$.each(products, function(i, prod) {
				    $.ajax({
            type: "get",
            url: "/admin/helpers/getweightprice/"+prod.id,
            success: function(data1) {
                weight=data1.weight+''+defweight;
                rate=data1.price;
					$("#products-list").append('<li><a href="#" class="product-select" data-id="'+prod.id+'"> #'+ prod.sku +' - ' +prod.name + '-'+weight+' @ $'+rate+' ( stock : '+prod.qty+' )</a></li>');
            }
				    });
				});	
				console.log(products);
			},
			error: function(error) {
				console.log(error);
			},
		});
	});

	// When new product button is clicked

    $("body").delegate("#button_new_product","click",function(){
    	$("#product_creator_wrapper").fadeToggle(50);
    	//$("#products-list").fadeToggle(50);
    }) // End of Create product button click

    // Close the product creation modal

    $(".pc_close").click(function(){
        $("#product_creator_wrapper").css("display","none");   
    }) // End of product creation close

    // Create new product when product form submitted

    $("#create-product").submit(function(e){            
       e.preventDefault();
        var datastring = $("#create-product").serialize();
        $(".pc_wrapper").fadeOut(50);
        $('.loading-info').css({opacity: 0, display: 'flex'}).animate({opacity: 1}, 1000);

        $.ajax({
            type: "POST",
            url: "/admin/products/create",
            data: datastring,
            success: function(data) {

				$("#products-list").parent().parent().find(".product-name").val(data.product.name);
				$("#products-list").parent().parent().find(".product-id").val(data.product.id);
				$("#products-list").parent().parent().find(".product-id").attr("data-priceby",data.product.price_by);
				$("#products-list").parent().parent().find(".product-id").attr("data-id",data.product.id);
				$("#products-list").parent().parent().find(".process-item").css('display','block');
				$("#products-list").parent().parent().find(".product-quantity").val(1);
				$("#products-list").parent().parent().find(".product-quantity").attr("data-qty",data.product.qty);
				$("#products-list").parent().parent().find(".product-description").val(data.product.description);
				$("#products-list").parent().parent().find(".product-sku").val(data.product.sku);
				
				$("#products-list").parent().parent().find(".product-weight").val(item.weight);
				$("#products-list").parent().parent().find(".product-weight").attr("data-weight",item.weight);
			    $("#products-list").parent().parent().find(".product-rate").attr("data-rate",item.price);
			    $("#products-list").parent().parent().find(".product-rate").val(Number(item.price).toFixed(2));
			    $("#products-list").parent().parent().find(".product-rate").html(`$`+Number(item.price).toFixed(2));
			    
				$("#products-list").remove();
				$("#products-list").fadeOut(50);
                addRow();

                $(".pc_wrapper").fadeIn(50);
                $('.loading-info').fadeOut(50);
                $("#product_creator_wrapper").fadeOut(50);

                console.log(data);
            },
            fail:function(error) {
                console.log(error)
            }
        });
    }); // End of product creation
    
    
    $("#update-stock").submit(function(e){            
       e.preventDefault();
        var datastring = $("#update-stock").serialize();
        var rowid=$('#row_id').val();
        // alert($('#'+rowid).find(".product-quantity").attr("data-qty"));
        if(rowid !='')
        {
         var row=rowid.replace('row','');
        }
        if(row=='')
        {
            row=rowid;
        }
        $(".pc_wrapper1").fadeOut(50);
        $('.loading-info1').css({opacity: 0, display: 'flex'}).animate({opacity: 1}, 1000);

        $.ajax({
            type: "POST",
            url: "/admin/products/updatestock",
            data: datastring,
            success: function(data) {
                console.log(data);
                if(rowid == '')
                {
    				$("#products-list").parent().parent().find(".product-name").val(data.product.name);
    				$("#products-list").parent().parent().find(".product-id").val(data.product.id);
    				$("#products-list").parent().parent().find(".product-id").attr("data-priceby",data.product.price_by);
    				$("#products-list").parent().parent().find(".product-id").attr("data-id",row);
    				$("#products-list").parent().parent().find(".product-quantity").val(1);
    				$("#products-list").parent().parent().find(".product-quantity").attr("data-qty",data.product.qty);
    				$("#products-list").parent().parent().find(".product-description").val(data.product.description);
    				$("#products-list").parent().parent().find(".product-sku").val(data.product.sku);
    				
    				$("#products-list").parent().parent().find(".product-weight").val(data.product.weight);
    				$("#products-list").parent().parent().find(".product-weight").attr("data-weight",data.product.weight);
    			    $("#products-list").parent().parent().find(".product-rate").attr("data-rate",data.product.price);
    			    $("#products-list").parent().parent().find(".product-rate").val(Number(data.product.price).toFixed(2));
    			    $("#products-list").parent().parent().find(".product-rate").html(`$`+Number(data.product.price).toFixed(2));
    			    
    				$("#products-list").remove();
    				$("#products-list").fadeOut(50);
                    addRow();
                    
                }
                else
                {
                    $('#'+rowid).find(".product-quantity").attr("data-qty",data.product.qty);
                    $('#'+rowid).find(".product-quantity").val(1);
                    $("#process_modal #availqty").val(data.product.qty);
                    $("#process_modal #changed-quantity").val($("#process_modal #original-quantity").val());
                }
                    
                $(".pc_wrapper1").fadeIn(50);
                $('.loading-info1').fadeOut(50);
                $("#product_creator_wrapper1").fadeOut(50);

                console.log(data);
            },
            fail:function(error) {
                console.log(error)
            }
        });
    }); // End of product creation
    
       

	// When a product is selected from the list

	$("body").delegate(".product-select","click",function(){
		var selectedid = $(this).attr("data-id");
        var weight='';
        var rate='';
        var rowid=$(this).parent().parent().parent().parent().attr('id').replace('row','');

		var cid = $("#customer_id").val();
		
        
		$.each(products, function(i, item) {
			if(selectedid == item.id) {
			    $.ajax({
            type: "get",
            url: "/admin/helpers/getweightprice/"+item.id+'?cid='+cid,
            success: function(data) {
                if(item.qty >0)
                {
                    weight=data.weight;
                    rate= data.price ;
    				$("#products-list").parent().parent().find(".product-name").val(item.name);
    				$("#products-list").parent().parent().find(".product-id").val(item.id);
    				$("#products-list").parent().parent().find(".product-id").attr("data-priceby",item.price_by);
    				$("#products-list").parent().parent().find(".product-id").attr("data-id",rowid);
    				$("#products-list").parent().parent().find(".process-item").css('display','block');
    				$("#products-list").parent().parent().find(".product-quantity").val(1);
    				$("#products-list").parent().parent().find(".product-quantity").attr("data-qty",item.qty);
    				$("#products-list").parent().parent().find(".product-description").val(item.description);
    				
    			    $("#products-list").parent().parent().find(".product-weight").val(weight);
    			    $("#products-list").parent().parent().find(".product-weight").attr("data-weight",weight);
    			    $("#products-list").parent().parent().find(".product-rate").attr("data-rate",rate);
    			    $("#products-list").parent().parent().find(".product-rate").val(Number(rate).toFixed(2));
    			    $("#products-list").parent().parent().find(".product-rate").html(`$`+Number(rate).toFixed(2));
    				
    				$("#products-list").parent().parent().find(".product-sku").val(item.sku);
    				
    				$("#products-list").remove();
    				$("#products-list").fadeOut(50);
    
    				addRow();
    				showTotQty();
                }
                else
                {
                    
                    $("#stock_modal1").fadeIn(50);
        	        $('#prname').text(item.name);
        	        $('#avstock').text(item.qty);
        	        $('#pid').val(item.id);
        	        $('.yesbutton').attr('data-id',item.id);
                    
                }
                }
			    });
			}
		})
	});


	/*************** Order Processing Functions ************************/

	// Inititate process order function

	$("body").delegate(".process-order","click",function(){
		
		$("#table-container").html('');
		addProcessTable();

		var id = $(this).attr("data-id")

		$("#full_modal").fadeIn(50);
		$("#form-action").val("process");
		$('#order-modal-title').text("Process Order");
		$("#order_form").attr("action","/admin/orders/process-po");
        $(".print").css("display","inline");
        $(".submit").css("display","none");
		$(".save").css("display","inline");
		$(".save_send").css("display","inline");
		$(".clear").css("display","none");
        $(".print").attr("href",'/admin/order/printorder/'+id);
        $(".print").attr("target",'_blank');
        
		$.ajax({
			url: '/admin/orders/detail/'+id,
			method: 'GET',
			success: function(data) {
				if(data.status == 'fail') {
					alert(data.message);
					$("#full_modal").fadeOut(50);
				}
				else
				{
				    
					console.log(data.order)
					var order = data.order;
					$('#order-modal-title').text("Process Order");
					var due=0;
					
					$.each(order.user.invoice, function(i, itm) {
            				due=Number(due)+Number(itm.grand_total);
            			});


					$("#order_id").val(order.id);
				 	$("#customer").val(order.user.firstname + ' ' + order.user.lastname);
             		$("#email").val(order.user.email);
            		$("#address1").val(order.billing.address);
            		$('#address').val(order.billing.address+', \n'+order.billing.city+', '+order.billing.province+',\n'+order.billing.postalcode);
            		$("#postalcode").val(order.billing.postalcode);
            		$("#city").val(order.billing.city);
            		$("#province").val(order.billing.province);
            		
            		$("#delivery_address1").val(order.delivery.address);
            		$("#delivery_address").val(order.delivery.address+',\n'+order.delivery.city+', '+order.delivery.province+', \n'+order.delivery.postalcode);
            		$("#delivery_postalcode").val(order.delivery.postalcode);
            		$("#delivery_city").val(order.delivery.city);
            		$("#delivery_province").val(order.delivery.province);
            		
            		$("#order_date").val(toMysqlDate(order.order_date));
            		$("#delivery_date").val(toMysqlDate(order.shipping_date));
            		$("#due_date").val(toMysqlDate(order.due_date));
            		$("#sales_rep").val(order.sales_rep);
            		$("#driver_id").val(order.driver_id);
            		$("#terms").val(order.terms);
            		$("#customer_id").val(order.user.id);
            		$("#notes").val(order.notes);
            		$("#discount").val(order.discount_amount);
            		$("#total_due").text(`$`+Number(due).toFixed(2))
            		if(order.item.length > 0) {
            			$("#items-table tbody").html('');

            			$.each(order.item, function(i, itm) {
            				restoreRow(itm, i+1);
            			});
            // 			addProcessRow();

            			orderRow();
            			showTotQty();
            		}

					if(order.user.email == null) {
						$(".save_send").css("display","none");
					}
					else {
						$(".save_send").css("display","inline");
					}
				}
			},
			error: function(data) {
				alert('Unable to get the order details. Contact support');
				$("#full_modal").fadeOut(50);
			}
		})
	}); // End of Process modal function

	
	$("body").delegate(".edit-order","click",function(){
		$("#table-container").html('');
		var id = $(this).attr("data-id")
		$('#order-modal-title').text("Edit Order");

		$("#full_modal").fadeIn(50);
		$("#form-action").val("edit");
		$(".print").css("display","none")
		$(".save").css("display","none")
		$(".submit").css("display","inline");
		$(".save_send").css("display","none");
		$(".clear").css("display","none");
		$("#order_form").attr("action","/admin/orders/edit-po");
		addOrderTable();

		
        // $(".print").css("display","inline");
        
		$.ajax({
			url: '/admin/orders/detail/'+id,
			method: 'GET',
			success: function(data) {
				if(data.status == 'fail') {
					alert(data.message);
					$("#full_modal").fadeOut(50);
				}
				else
				{
					console.log(data.order)
					var order = data.order;
					var due=0;
					
					$.each(order.user.invoice, function(i, itm) {
            				due=Number(due)+Number(itm.grand_total);
            			});


					$("#order_id").val(order.id);
				 	$("#customer").val(order.user.firstname + ' ' + order.user.lastname);
             		$("#email").val(order.user.email);
            		$("#address1").val(order.billing.address);
            		$("#address").val(order.billing.address+',\n'+order.billing.city+', '+order.billing.province+',\n'+order.billing.postalcode);
            		$("#postalcode").val(order.billing.postalcode);
            		$("#city").val(order.billing.city);
            		$("#province").val(order.billing.province);
            		
            		$("#delivery_address1").val(order.delivery.address);
            		$("#delivery_address").val(order.delivery.address+',\n'+order.delivery.city+', '+order.delivery.province+',\n'+order.delivery.postalcode);
            		$("#delivery_postalcode").val(order.delivery.postalcode);
            		$("#delivery_city").val(order.delivery.city);
            		$("#delivery_province").val(order.delivery.province);
            		
            		$("#order_date").val(toMysqlDate(order.order_date));
            		$("#delivery_date").val(toMysqlDate(order.shipping_date));
            		$("#due_date").val(toMysqlDate(order.due_date));
            		$("#sales_rep").val(order.sales_rep);
            		$("#driver_id").val(order.driver_id);
            		$("#terms").val(order.terms);
            		$("#customer_id").val(order.user.id);
            		$("#notes").val(order.notes);
            		$("#discount").val(order.discount_amount);
            		$("#total_due").text(`$`+Number(due).toFixed(2))
            		if(order.item.length > 0) {
            		    
            			$("#items-table tbody").html('');
             			var promises = [];
             			
             			$.each(order.item, function(i, itm) {
            				editRow(itm, i+1);
            			});
            			
            			addRow();
            			
            		}
				}
			},
			error: function(data) {
				alert('Unable to get the order details. Contact support');
				$("#full_modal").fadeOut(50);
			}
		})
	}); // End of Edit order modal function
	
	function editRow(item, i) {
   		var weights = '';
        var getweight='';
        var rate='';
        var weight='';
        var qty='';
   		
   		$.ajax({
			url:'/admin/helpers/get-weight/'+item.id,
			method: 'GET',
			success: function(data) {
			    getweight=data.result;
			    rate=data.rate;
			    weight=data.weight;
			    qty=data.qty;
			    console.log(data);
				
				let action = $("#form-action").val();

				if(action == 'editinvoice')
				{
					$("#items-table tbody").prepend(`<tr id="row`+item.id+`" class="product_row">
							<td class="text-center number_column" valign="middle"><span class="row-id">`+i+`</span></td>
							<td class="sku_column">
								<input type="text" name="product_sku[]" class="form-control noneditable product-sku" autocomplete="off"  value="`+item.product_sku+`" />
							   
							</td>
							<td>
								<input type="text" name="product_names[]" class="form-control noneditable product-name" autocomplete="off" value="`+item.product_name+`" />
								<input type="hidden" name="product_ids[]" value="`+item.product_id+`" class="product-id" data-priceby="`+item.price_by+`" data-id="`+item.id+`"/>
							</td>
							<td class="description_column">
							<input type="text" name="product_description[]" class="form-control noneditable product-name" autocomplete="off" value="`+item.product_description+`" />
							</td>
							<td width="100">
							<input type="number" name="quantities[]"  min="1" step="1" class="form-control noneditable product-quantity" value="`+item.quantity+`" data-qty="`+qty+`"/>
							<input type="hidden" name="originalquantities[]" value="1" class="product-required" />
							<input type="hidden" name="weightlist[]" value="0" class="weight-list"/>
							<a href="#" class="process-item" data-value="invoice" style="display:none"><i class="fa fa-edit"></i></a>
							</td>
							<td width="100"><input type="number" class="form-control noneditable product-rate" step=".01" data-rate="`+item.rate+`" name="rates[]" value="`+item.rate+`"></td>
							<td width="100" class="text-center"><input type="number" min="0" step=".01" name="weights[]" data-weight="" value="`+ item.weight +`" class="form-control noneditable product-weight" pattern="[0-9]"/></td>
							<td><div class="product-total">`+ item.total.toFixed(2) +`</div></td>
							<td><div class="product-tax">`+ item.tax +`</div></td>
							<td class="text-center" valign="middle"><big><a href="#" class="trash-row"><i class="fa fa-trash"></i></a></big></td>
						</tr>`);

					orderRow();
					showTotQty();

				} else {
					$("#items-table tbody").prepend(`<tr id="row`+item.id+`" class="product_row">
							<td class="text-center number_column" valign="middle"><span class="row-id">`+i+`</span></td>
							<td class="sku_column"><input type="text" name="product_sku[]" class="form-control noneditable product-sku" autocomplete="off" value="`+item.product_sku+`"/></td>
							<td>
								<input type="text" name="product_names[]" class="form-control noneditable product-name" autocomplete="off" value="`+item.product_name+`"/>
								<input type="hidden" name="product_ids[]" value="`+item.product_id+`" class="product-id" data-priceby="`+item.price_by+`" data-id="`+item.id+`"/>
							</td>
							<td class="description_column"><input type="text" name="product_description[]" class="form-control product-description noneditable " value="`+item.product_description+`" autocomplete="off" /></td>
							
							<td width="100"><input type="number" name="quantities[]"  min="1" step="1" class="form-control noneditable product-quantity" value="`+item.quantity+`" data-qty="`+qty+`"/></td>
							<td width="100"><div class="product-rate">`+item.rate+`</div></td>
							<td class="text-center" valign="middle"><big><a href="#" class="trash-row"><i class="fa fa-trash"></i></a></big></td>
						</tr>`);

					orderRow();
				}
                
			}
   		});
   	

		
	} // End of Insert rows for edit
	
	function toMysqlDate(dt) {
	    
	    let newdt = new Date(dt);
	   
	   return newdt.getFullYear()+'-'+('0'+(newdt.getMonth()+1)).slice(-2)+'-'+('0'+newdt.getDate()).slice(-2);
	    
	    
	}

	function addProcessTable() {

		$("#table-container").append(`
				<input type="hidden" name="order_id" value="" id="order_id" />
				<table class="table process_table" id="items-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th width="10%">Product Code</th>
                            <th width="25%">Product</th>
                            <th width="20%">Description</th>
                            <th width="10%">Qty</th>
                            <th ></th>
                            <th width="10%">Price</th>
                            <th width="10%">Weight(`+defweight+`)</th>
                            <th width="5%" class="text-right">Amount</th>
                            <th width="5%" class="text-right">Tax</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot>
                        <tr>
                    		<th colspan="9" style="text-align:right;">Discount</th>
                    		<th width="100"><input type="text" name="discount" id="discount" value="0" class="text-right"/></th>
                    	</tr>
                    	<tr>
                    		<th colspan="9" style="text-align:right;">Tax</th>
                    		<th width="100" style="text-align:right;"><div id="net-tax"></div></th>
                    	</tr>
                   		<tr>
                    		<th colspan="6" style="position:unset;line-height:35px;"></th>
                    		
                    		<th><div id="net-quantity"></div></th>
                    		<th><div id="net-weight"></div></th>
                    		<th></th>
                    		<th><div id="net-total" class="text-right"></div></th>
                    	</tr>
                    </tfoot>
                 </table>
                 <div id="order-totals">
                 </div>`);
		addRow('process');
	}

	// Function to restore the order item into the process table

	function restoreRow(item, i) {
   		var weights = '';
        var getweight='';
        var rate='';
        var weight='';
        var qty='';
   		for(var x=1; x<=item.quantity; x++) {
   			if(x > 1) { weights += ','; }
   			weights += `0`;
   		}
   		$.ajax({
			url:'/admin/helpers/get-weight/'+item.id,
			method: 'GET',
			success: function(data) {
			    getweight=data.result;
			    rate=data.rate;
			    weight=data.weight;
			    qty=data.qty;
			    $("#items-table tbody").append(`<tr id="row`+item.id+`" class="product_row">
                        <td class="text-center" valign="middle"><span class="row-id">`+i+`</span></td>
                        <td><input type="text" name="product_sku[]" class="form-control noneditable product-sku" autocomplete="off" value="`+item.product_sku+`"/></td>
                        <td>
                            <input type="text" name="product_names[]" value="`+item.product_name+`" class="form-control noneditable product-name" autocomplete="off" />
                            <input type="hidden" name="product_ids[]" value="`+item.product_id+`" class="product-id" data-id="`+item.id+`" data-priceby="`+item.price_by+`" />
                        </td>
                        <td>
                            <input type="text" name="product_description[]" class="form-control product-description noneditable " value="`+item.product_description+`" autocomplete="off" />
                        </td>
                        <td width="100" class="text-center">
                        	<input type="number" name="quantities[]" value="`+item.quantity+`"  class="form-control noneditable product-quantity" readonly data-qty="`+qty+`"/>
                        	<input type="hidden" name="backorderquantities[]" value="0" class="product-backorder" />\
                        	<input type="hidden" name="originalquantities[]" value="`+item.quantity+`" class="product-required" />
                        	<input type="hidden" name="weightlist[]" value="`+weights+`" class="weight-list"/>
                        	
                        </td>
                        <td>
                            <a href="#" class="process-item" style="position:unset;line-height:35px;"><i class="fa fa-edit" style="font-size:35px"></i></a>
                        </td>
                        <td width="100"><input type="number" class="form-control noneditable product-rate" data-rate="`+rate+`" value="`+Number(rate).toFixed()+`" data-original-rate="`+Number(rate).toFixed()+`" name="rates[]"></td>
                        <td width="100" class="text-center"><input type="number" min="0" step=".01" name="weights[]" value="`+getweight+`" class="form-control noneditable product-weight" data-weight="`+weight+`"/></td>
                        
                        <td width="100"><div class="product-total text-right">`+item.total+`</div></td>
                        <td><div class="product-tax text-right"></div></td>
                    </tr>`);
                    showTotQty();
			}
   		    
   		});
   	

		
	} // End of Insert rows for processing
	
	function updateStock(id,rowid='')
	{
	    
	    $.ajax({
    			url: '/admin/products/getdetails/'+id,
    			method: 'GET',
    			dataType:"json",
    			success: function(data1) {
    			    $.each(data1,function(key,value)
                        {
                            var weight=(value.weight/Number(weightvalue)).toFixed(2);
                            var rate =(value.price*Number(weightvalue)).toFixed(2);
                            $('#row_id').val(rowid);
                            $('#product_id').val(id);
                            $('#availstock').text(value.qty);
                            $('#name').val(value.name);
                            $('#sku').val(value.sku);
                            $('#category_id').val(value.category_id);
                            $('#unittype').val(value.unittype);
                            $('#unit').val(value.unit);
                            $('#weight').val(weight);
                            $('#price').val(rate);
                            $('#price_by').val(value.price_by);
                            $('#description1').val(value.description);
                            // if(value.picture !='')
                            // var img="{{asset('images/products')}}/"+value.picture;
                            // else
                            // var img="";
                            // $("#uploaded-image2").attr("src", img).css("display", "block");
                            if(value.qty < 0)
                                $('#availstock').css('color','red');
                            else
                                $('#availstock').css('color','green');
                        });
        			    $("#product_creator_wrapper1").fadeToggle(50);
                        
                        
    			}
        	});
	}
	$('body').delegate('.yesbutton','click',function(){
	    $('#stock_modal1').fadeOut(50);
	    var id=$(this).data('id');
	    var rowid=$(this).data('rowid');
	    
	        updateStock(id,rowid);
	});
	$('body').delegate('.nobutton','click',function(){
	    var rowid=$(this).data('rowid');
	    $('#stock_modal1').fadeOut(50);
	    $('#'+rowid).find(".product-quantity").val(1);
	    $("#process_modal #changed-quantity").val($("#process_modal #original-quantity").val());
	    showTotQty();
	    
	});
    $("#stock_modal1 .close").click(function(e){
		e.preventDefault();
		$("#stock_modal1").fadeOut(50);
	});

	// Update Price when Weight is changed

	$("body").delegate(".product-weight","change",function(){
		showTotQty();
	});
	$(".pcedit_close").click(function(){
           $("#product_creator_wrapper1").fadeOut("slow");
   })

	// Show modal when an item is changing by click on edit
	
	$("body").delegate(".process-item","click",function(){
		var qty = $(this).parent().parent().find(".product-quantity").val();
		var orgqty = $(this).parent().parent().find(".product-required").val();
		var productname = $(this).parent().parent().find(".product-name").val();
		var processid = $(this).parent().parent().find(".product-id").attr("data-id");
		var productid= $(this).parent().parent().find(".product-id").val();
		var backorder = $(this).parent().parent().find(".product-backorder").val();
		var weights = $(this).parent().parent().find(".weight-list").val();
		var availqty = $(this).parent().parent().find(".product-quantity").data('qty');
		
		$("#weight-list").html('');

		weightspair = weights.split(',');

		for(var y=0; y< qty; y++) {
			var targetq = y + 1;
			$("#weight-list").append(`<li><label>#weight for item`+targetq+` (`+defweight+`)<input type="number" class="quantity-weight" value="`+weightspair[y]+`" step=".01" style="width:20%;display:inline-block;margin-left:5%;"/>`);
		}

		$("#process_modal").fadeIn(50);
		if($(this).data("value")=='invoice')
		{
		    $('.hideinvoice').css('display','none');
		}
		else
		{
		    $('.hideinvoice').css('display','block');
		}
		$("#process-product").text(productname);
		$("#process-product").attr("data-id",productid);
		$("#changed-quantity").val(qty);
		$("#original-quantity").val(orgqty);
		$("#availqty").val(availqty);
		$("#backorder-quantity").val(backorder);
		$("#process-id").val(processid);
	}) // End of Process modal for Quantity & Weight

	// When product quantity is changed

	$("body").delegate(".process-table .product-quantity","change",function(){
		var rate = $(this).parent().parent().find('product-rate');
		var total = $(this).parent().parent().find('product-total');
		total.text = rate * $(this).val();
	})

	// When product quantity is adjusted

	$("body").delegate("#changed-quantity","change",function(){
		var qty = $(this).val();
		var availqty=$('#availqty').val();
		var rowid=$("#process-id").val();
		var originalqty = $("#original-quantity").val();
		var backorderqty = Number(originalqty) - Number(qty);
		var listlength = $("#weight-list li").length;
		var diff = Number(listlength) - Number(qty);
		console.log('List: '+listlength + '/' +diff);
        if(Number(availqty) < Number(qty))
        {
            var proname=$("#process-product").html();
            var proid=$("#process-product").data('id');
            // alert("This Product has only "+availqty+ " in stock.Please update the quantity");
            // $(this).val(originalqty);
            $("#stock_modal1").fadeIn(50);
	        $('#prname').text(proname);
	        $('#avstock').text(availqty);
	        $('#pid').val(proid);
	        $('.yesbutton').attr('data-id',proid);
	        $('.yesbutton').attr('data-rowid',"row"+rowid);
	        $('.nobutton').attr('data-rowid',"row"+rowid);
        }
        else
        {
		for(var y=1; y <= Math.abs(diff); y++) {
		    var id=Number(listlength)+y;
			if(diff > 0) 
				$("#weight-list li:last").remove();
			else
				$("#weight-list").append(`<li><label>#weight for item`+id+` (`+defweight+`)<input type="number" class="quantity-weight" value="0" style="width:20%;display:inline-block;margin-left:5%;"/></label></li>`);
		}

		if($("#send-backorder").prop("checked")== true) {
			if(backorderqty > 0)
				$("#backorder-quantity").val(backorderqty);
			else
				$("#backorder-quantity").val(0);
		}
        }
	}) // End of Quantity change trigger

	// When backorder quantity changed

	$("body").delegate("#send-backorder","change",function(){

		if(this.checked) {
			var qty = $("#changed-quantity").val();
			var originalqty = $("#original-quantity").val();
			var backorderqty = Number(originalqty) - Number(qty);

			if(backorderqty > 0)
				$("#backorder-quantity").val(backorderqty);
			else
				$("#backorder-quantity").val(0);

			$(this).parent().parent().next().fadeIn(50)
		}
		else {
			$("#backorder-quantity").val(0);
			$(this).parent().parent().next().fadeOut(50)
		}
	}) // End of backorder items 

	// Close the process modal

	$("body").delegate("#process_modal .close","click", function(){
		$("#process_modal").fadeOut(50);
	}) // End of Quantity WEight change cancelled

	// When item is updated

	$("body").delegate("#process_modal .update","click", function(){
		var id = $("#process-id").val();
		var qweights = '';
		var totweight = 0;

		$(".quantity-weight").each(function(){
			qweights += $(this).val()+',';
			totweight += Number($(this).val());
		})

		$("#row"+id).find('.product-quantity').val($("#changed-quantity").val());
		$("#row"+id).find('.product-backorder').val($("#backorder-quantity").val());
		$("#row"+id).find('.product-weight').val(totweight.toFixed(2));
		$("#row"+id).find('.weight-list').val(qweights);
		$("#row"+id).find('.product-weight').val();
		$("#process_modal").fadeOut(50);

		showTotQty();

		updateBackorders();
	})  // End of Qunatity and Weight changes when processing

	function checkRates(formvars) {

		var isRateChanged = false;

		$("#update_rates").html('');
		$("#rate_customer").val($("#customer_id").val());

		$(".product-rate").each(function(){
			if($(this).val() != $(this).attr("data-original-rate")) {
				var productName = $(this).parent().parent().find('.product-name').first().val();
				var productId = $(this).parent().parent().find('.product-id').first().val();
				isRateChanged = true;
				$("#update_rates").append(
					'<p><input type="checkbox" name="product['+ productId +']" value="'+ $(this).val() +'" /> - <strong>$'+$(this).val()+'</strong> (<span style="text-decoration:line-through;">$'+ $(this).attr("data-original-rate") +'</span>): <strong>'+productName+'</strong></p>'
				)
			}
		})
		
		if(isRateChanged) {
			$("#rate_change_modal").fadeIn('slow');
		}
		else {
			processOrder(formvars);
		}
	}

	$("#noChangeRate").click(function(){
		$("#rate_change_modal").fadeOut("slow");
		processOrder($("#order_form").serialize());
	});

	$("#rate-confirm").submit(function(e){

		e.preventDefault();

		var formvars = $("#rate-confirm").serialize();
		$("#rate_customer").val($("#customer_id").val());
		$("#rate_customer").attr("data-id",$("#customer_id").val());

		$.ajax({
            type: "POST",
            url: '/admin/customers/update-rate',
            data: formvars,
            dataType:"json",
            success: function(data) {

				console.log(data);

            	if(data.status == 'success') 
            	{
					$("#rate_change_modal").fadeOut("slow");
					processOrder($("#order_form").serialize());
            	}
            	else
            	{
            		console.log(data.data);
            		alert(data.message);
            	}
            },
            error: function(xhr, status, error){
            	alert('Some errors in submission, Please retry');
            	if(xhr.status == 422) {
            		var validation = xhr.responseJSON.errors;
            	}

                console.log(xhr);
                console.log(status);
                console.log(error);
            }
        })

	});

	function processOrder(formvars) {

		$.ajax({
            type: "POST",
            url: '/admin/orders/process-po',
            data: formvars,
            dataType:"json",
            success: function(data) {

				console.log(data);

            	if(data.status == 'success') 
            	{
            		$("#order_form").trigger("reset");
            		resetRows();
            		alert(data.message);
            		$("#full_modal").fadeToggle(50);
            		location.reload();
            	}
            	else
            	{
            		console.log(data.data);
            		alert(data.message);
            	}
            },
            error: function(xhr, status, error){
            	alert('Some errors in submission, Please retry');
            	if(xhr.status == 422) {
            		var validation = xhr.responseJSON.errors;
            	}

                console.log(xhr);
                console.log(status);
                console.log(error);
            }
        })
	}
	
	function editOrder(formvars) {

		$.ajax({
            type: "POST",
            url: '/admin/orders/edit-po',
            data: formvars,
            dataType:"json",
            success: function(data) {

				console.log(data);

            	if(data.status == 'success') {
            		$("#order_form").trigger("reset");
            		resetRows();
            		alert(data.message);
            		$("#full_modal").fadeToggle(50);
            		location.reload();
            	}
            	else
            	{
            		console.log(data.data);
            		alert(data.message);
            	}
            },
            error: function(xhr, status, error){
            	alert('Some errors in submission, Please retry');
            	if(xhr.status == 422) {
            		var validation = xhr.responseJSON.errors;
            	}

                console.log(xhr);
                console.log(status);
                console.log(error);
            }
        })
	}

	function editInvoice(formvars) {

		$.ajax({
            type: "POST",
            url: '/admin/orders/edit-invoice',
            data: formvars,
            dataType:"json",
            success: function(data) {

				//console.log(data);

            	if(data.status == 'success') {
					
            		$("#order_form").trigger("reset");
            		resetRows();
            		alert(data.message);
            		$("#full_modal").fadeToggle(50);
            		location.reload();
            	}
            	else
            	{
            		console.log(data.data);
            		alert(data.message);
            	}
            },
            error: function(xhr, status, error){
            	alert('Some errors in submission, Please retry');
            	if(xhr.status == 422) {
            		var validation = xhr.responseJSON.errors;
            	}

                console.log(xhr);
                console.log(status);
                console.log(error);
            }
        })
	}
	
	$("body").delegate("#discount","keyup",function(){
	    showTotQty();
	});


	/******** Common functions for Order creation and Processing **************/

	// Update Quantity, Weight, Total etc

	function showTotQty() {
		let net_quantity = 0;
		let net_weight = 0;
		let net_total = 0;
		let discount = 0;
		
		$(".product-quantity").each(function(){
			let this_quantity = $(this).val();
			let this_rate = $(this).parent().parent().find(".product-rate").attr("data-rate");
			let this_weight = $(this).parent().parent().find(".product-weight").val();
			let this_priceby = $(this).parent().parent().find(".product-id").attr("data-priceby");
			let this_total = 0;
			let this_tax=0;

			if(this_priceby  == 'quantity') {
				this_total = this_quantity*this_rate;
				//this_total = this_quantity*this_rate;
			}
			else {
				this_total = this_weight*this_rate;
			}
            this_tax=(Number(tax)*this_total)/100;
			net_quantity = net_quantity + Number(this_quantity);
			net_total = net_total + this_total;
			net_weight = Number(net_weight) + Number(this_weight);
			

			$(this).parent().parent().find(".product-total").text(showPrice(this_total));
			$(this).parent().parent().find(".product-tax").text(showPrice(this_tax));
		});
		
		discount = $("#discount").val();
		
		if(discount > 0) {
		    net_total = net_total - discount;
		}
		
		if(net_total < 0) {
		    net_total = 0;
		}
        net_tax=(tax*net_total)/100;
        net_total=net_total + net_tax;
        $("#net-tax").text(showPrice(net_tax));
		$(".total_qty").text(net_quantity);
		$("#net-quantity").text(net_quantity);
		$("#net-total").text(showPrice(net_total));
		$("#net-weight").text(net_weight.toFixed(2));
	}


	// Update backorders


	function updateBackorders() {
		$("#backorder-container").html(`Backorders 
										<table cellpadding="10" class="backorder-table" width="100%">
											<thead>
												<tr>
													<th>#</th>
													<th>Product</th>
													<th>SKU</th>
													<th>Qty</th>
												</tr>
											</thead>
											<tbody>
											</tbody>
										</table>`);
		var icount = 0;

		$(".process_table tbody tr").each(function(){
			var product = $(this).find('.product-name').val();
			var sku = $(this).find('.product-sku').val();
			var qty = $(this).find('.product-backorder').val();

			if(Number(qty) > 0) 
				$(".backorder-table tbody").append('<tr><td>'+(++icount)+'</td><td>'+product+'</td><td>'+sku+'</td><td>'+qty+'</td></tr>');
		})

		if(icount === 0) {
			$("#backorder-container").html('');
		}
	}

	$('body').delegate('.editinv','click',function(){

		var id = $(this).attr("data-id")
		
		$("#full_modal").fadeIn(50);
		$("#table-container").html('');
		$("#order-modal-title").text('Modify Invoice');
		$("#order_form").attr("action","/admin/orders/update-invoice");
		$("#form-action").val("editinvoice");
		$(".print").css("display","none")
		$(".submit").css("display","none");
		$(".save").css("display","inline");
		$(".save_send").css("display","inline");
		$(".clear").css("display","inline");
		$("#order_id").val('');
		$("#customer").val('');
		$("#email").val('');
		$("#address").val('');
		$("#postalcode").val('');
		$("#city").val('');
		$("#province").val('');
		
		$("#delivery_address").val('');
		$("#delivery_postalcode").val('');
		$("#delivery_city").val('');
		$("#delivery_province").val('');
		
	// 		$("#order_date").val(new Date());
	// 		$("#delivery_date").val('');
		$("#due_date").val('');
		$("#sales_rep").val(0);
		$("#driver_id").val('');
		$("#terms").val('');
		$("#customer_id").val('');
		$("#notes").val('');
		$("#discount").val('');
		$("#total_due").text(`$0.00`)
		addOrderTable();

	
		// $(".print").css("display","inline");
		
		$.ajax({
			url: '/admin/invoices/detail/'+id,
			method: 'GET',
			success: function(data) {
				if(data.status == 'fail') {
					alert(data.message);
					$("#full_modal").fadeOut(50);
				}
				else
				{
					console.log('Invoice received');
					console.log(data.invoice)
					var order = data.order;
					var due=0;
					
					$.each(order.user.invoice, function(i, itm) {
							due=Number(due)+Number(itm.grand_total);
					});
	
					$("#order_id").val(order.id);
					$("#customer").val(order.user.firstname + ' ' + order.user.lastname);
					$("#email").val(order.user.email);
					$("#address1").val(order.billing.address);
					$("#address").val(order.billing.address+',\n'+order.billing.city+', '+order.billing.province+',\n'+order.billing.postalcode);
					$("#postalcode").val(order.billing.postalcode);
					$("#city").val(order.billing.city);
					$("#province").val(order.billing.province);
					
					$("#delivery_address1").val(order.delivery.address);
					$("#delivery_address").val(order.delivery.address+',\n'+order.delivery.city+', '+order.delivery.province+',\n'+order.delivery.postalcode);
					$("#delivery_postalcode").val(order.delivery.postalcode);
					$("#delivery_city").val(order.delivery.city);
					$("#delivery_province").val(order.delivery.province);
					
					$("#order_date").val(toMysqlDate(order.order_date));
					$("#delivery_date").val(toMysqlDate(order.shipping_date));
					$("#due_date").val(toMysqlDate(order.due_date));
					$("#sales_rep").val(order.sales_rep);
					$("#driver_id").val(order.driver_id);
					$("#terms").val(order.terms);
					$("#customer_id").val(order.user.id);
					$("#notes").val(order.notes);
					$("#discount").val(order.discount_amount);
					$("#total_due").text(`$`+Number(due).toFixed(2))

					//$("#net-tax").text(`$`+Number(order.tax).toFixed(2));

					if(order.item.length > 0) {
						
						$("#items-table tbody").html('');
						var promises = [];
						
						$.each(order.item, function(i, itm) {
							editRow(itm, i+1);
						});
						
						addRow();
					}
				}
			},
			error: function(data) {
				alert('Unable to get the invoice details. Contact support');
				console.log(data);
				//$("#full_modal").fadeOut(50);
			}
		})
	
	 });
	
// 	$(".print").click(function(e){
// 	    e.preventDefault();
	    
// 	    var divContents = document.getElementById("full_modal").innerHTML;
//         var a = window.open('', '', 'height=500, width=500');
//         a.document.write('<html>');
//         a.document.write('<body >');
//         a.document.write(divContents);
//         a.document.write('</body></html>');
//         a.document.close();
//         a.print();
// 	})


}); // End of Docuemnt Ready Functions!


// Change an order status

function changeStatus(id, status) {

	$.ajax({
		url: '/admin/orders/change-status/',
		data: 'id='+id+'&status='+status,
		success:function(data) {
			if(data.status == 'success') 
				location.reload();
			else
				alert('Failed to change the status');
		},
		error: function(error) {
			console.log(error)
		}
	})
}

function printDiv() {
    
}

// This sample uses the Places Autocomplete widget to:
// 1. Help the user select a place
// 2. Retrieve the address components associated with that place
// 3. Populate the form fields with those address components.
// This sample requires the Places library, Maps JavaScript API.
// Include the libraries=places parameter when you first load the API.
// For example: <script
// src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">
let autocomplete;
let del_autocomplete;
let billing_address;
let delivery_address;
let customer_autocomplete;
let customer_address;

function initAutocomplete() {
billing_address = document.querySelector("#address");
delivery_address = document.querySelector("#delivery_address");
customer_address = document.querySelector("#custaddress");
// Create the autocomplete object, restricting the search predictions to
// addresses in the US and Canada.
autocomplete = new google.maps.places.Autocomplete(billing_address, {
    componentRestrictions: { country: [ "ca"] },
    fields: ["address_components", "geometry"],
    types: ["address"],
});

del_autocomplete = new google.maps.places.Autocomplete(delivery_address, {
    componentRestrictions: { country: [ "ca"] },
    fields: ["address_components", "geometry"],
    types: ["address"],
});
customer_autocomplete = new google.maps.places.Autocomplete(customer_address, {
    componentRestrictions: { country: [ "ca"] },
    fields: ["address_components", "geometry"],
    types: ["address"],
});

// billing_address.focus();
// When the user selects an address from the drop-down, populate the
// address fields in the form.
autocomplete.addListener("place_changed", fillInAddress);
del_autocomplete.addListener("place_changed", fillDelAddress);
customer_autocomplete.addListener("place_changed", fillCustAddress);
}

function fillInAddress() {
    // Get the place details from the autocomplete object.
    const place = autocomplete.getPlace();
    let add= "";
    let address1 = "";
    let postcode = "";
    
    // Get each component of the address from the place details,
    // and then fill-in the corresponding field on the form.
    // place.address_components are google.maps.GeocoderAddressComponent objects
    // which are documented at http://goo.gle/3l5i5Mr
    for (const component of place.address_components) {
        const componentType = component.types[0];
        switch (componentType) {
            case "street_number": {
                address1 = `${component.long_name} ${address1}`;
                add=`${component.long_name} `;
                break;
            }
        
            case "route": {
                address1 += component.long_name;
                add += component.long_name;
                break;
            }
        
            case "postal_code": {
                postcode = `${component.long_name}${postcode}`;
                break;
            }
        
            case "postal_code_suffix": {
                postcode = `${postcode}-${component.long_name}`;
                break;
            }
            case "locality": {
                document.querySelector("#city").value = component.long_name;
                address1 += ', \n'+component.long_name;
                break;
            }
            case "administrative_area_level_1": {
                document.querySelector("#province").value = component.short_name;
                address1 += ', ' + component.short_name;
                break;
            }
        
        }
    }
    document.querySelector("#address1").value = add;
    console.log('Bil:'+address1+' '+postcode)
    address1 +=", \n"+`${postcode}`;
    document.querySelector("#postalcode").value = postcode;
    document.querySelector("#address").value = address1;
    
    // billing_address.focus();
    
    // After filling the form with address components from the Autocomplete
    // prediction, set cursor focus on the second address line to encourage
    // entry of subpremise information such as apartment, unit, or floor number.
}

function fillDelAddress() {
    // Get the place details from the autocomplete object.
    const dplace = del_autocomplete.getPlace();
    let daddress1 = "";
    let dpostcode = "";
    let dadd1= "";
    
    // Get each component of the address from the place details,
    // and then fill-in the corresponding field on the form.
    // place.address_components are google.maps.GeocoderAddressComponent objects
    // which are documented at http://goo.gle/3l5i5Mr
    for (const dcomponent of dplace.address_components) {
        const componentType = dcomponent.types[0];
        switch (componentType) {
            case "street_number": {
                daddress1 = `${dcomponent.long_name} ${daddress1}`;
                dadd1 = `${dcomponent.long_name} `;
                break;
            }
        
            case "route": {
                daddress1 += dcomponent.long_name;
                dadd1 += dcomponent.long_name;
                break;
            }
        
            case "postal_code": {
                dpostcode = `${dcomponent.long_name}${dpostcode}`;
                break;
            }
        
            
            case "locality": {
                document.querySelector("#delivery_city").value = dcomponent.long_name;
                daddress1 += ', \n' + dcomponent.long_name;
                break;
            }
            case "administrative_area_level_1": {
                document.querySelector("#delivery_province").value = dcomponent.short_name;
                daddress1 += ', ' + dcomponent.short_name;
                break;
            }
        
        }
    }
    
    console.log('Del:'+daddress1);
    
    daddress1 +=",\n"+`${dpostcode}`;
                
    document.querySelector("#delivery_address1").value = dadd1;
    document.querySelector("#delivery_postalcode").value = dpostcode;
    document.querySelector("#delivery_address").value = daddress1;
    // delivery_address.focus();
    // After filling the form with address components from the Autocomplete
    // prediction, set cursor focus on the second address line to encourage
    // entry of subpremise information such as apartment, unit, or floor number.
}
function fillCustAddress() {
    
    const place = customer_autocomplete.getPlace();
    let add= "";
    let address1 = "";
    let postcode = "";
    
    
    for (const component of place.address_components) {
        const componentType = component.types[0];
        switch (componentType) {
            case "street_number": {
                address1 = `${component.long_name} ${address1}`;
                add=`${component.long_name} `;
                break;
            }
        
            case "route": {
                address1 += component.long_name;
                add += component.long_name;
                break;
            }
        
            case "postal_code": {
                postcode = `${component.long_name}${postcode}`;
                break;
            }
        
            case "postal_code_suffix": {
                postcode = `${postcode}-${component.long_name}`;
                break;
            }
            case "locality": {
                document.querySelector("#custcity").value = component.long_name;
                address1 += ', \n'+component.long_name;
                break;
            }
            case "administrative_area_level_1": {
                document.querySelector("#custprovince").value = component.short_name;
                address1 += ', ' + component.short_name;
                break;
            }
        
        }
    }
    document.querySelector("#custaddress").value = add;
   
    document.querySelector("#custpostalcode").value = postcode;
    
}


