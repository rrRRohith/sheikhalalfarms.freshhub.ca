$(document).ready(function(){
	let customers = [];
	let products = [];
	let defweight = '';


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

	$("#new-order").click(function(e){
		$("#full_modal").fadeIn(50);
		$("#table-container").html('');
		$("#order-modal-title").text('Create new order');
		$("#order_form").attr("action","/admin/orders/create-po");
		$("#form-action").val("create");
		$(".print").css("display","none")
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
		$("#table-container").append(`
				<table class="table order_table" id="items-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th width="30%">Product</th>
                            <th>SKU(Code)</th>
                            <th width="40%">Description</th>
                            <th>Qty</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>                       
                    </tbody>
                 </table>`);
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

		if(allfilled) {
			$("#items-table tbody").append(`<tr id="row0" class="product_row">
                        <td class="text-center" valign="middle"><span class="row-id">0</span></td>
                        <td>
                            <input type="text" name="product_names[]" class="form-control noneditable product-name" autocomplete="off" />
                            <input type="hidden" name="product_ids[]" value="" class="product-id" />
                        </td>
                        <td><div class="product-sku"></div></td>
                        <td><div class="product-description"></div></td>
                        <td width="150"><input type="number" name="quantities[]"  min="1" step="1" class="form-control noneditable product-quantity" /></td>
                        <td class="text-center" valign="middle"><big><a href="#" class="trash-row"><i class="fa fa-trash"></i></a></big></td>
                    </tr>`);
			orderRow();
		}
	}


	// Reorder the product items row


	function orderRow() {
		$("#items-table tbody tr").each(function(index){
			$(this).attr("id","row"+(index+1));
			$(this).find(".row-id").text(index+1);
		})
	}

	// Trash a row

	$("body").delegate(".trash-row","click",function(){
		if($("#items-table tbody tr").count>0 && confirm('Are you sure to delete?')) {
		   $(this).parent().parent().remove();
		    addRow();
		} 
	})

	// When quantity is changed

	$("body").delegate(".product-quantity","change",function(){
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

		if(action == 'create') {
			createOrder(formvars);
		}
		else {
			processOrder(formvars);
		}
	});


	function createOrder(formvars) {

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
					$("#customer-list").append('<li><a href="#" class="customer-select" data-id="'+item.id+'"> #'+item.id+' - '+item.firstname+' '+item.lastname+ ' (' + item.email + ') </a></li>');
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

				if(item.paymentmethod.name == 'CREDIT') {
					days = '('+item.paymentterm.value + ' days)';
					ddate.setDate(today.getDate() + (item.paymentterm.value + 1));
				}
				else {
					ddate.setDate(today.getDate() + 1);
				}

				var duedate = ddate.getFullYear() + "-" + (ddate.getMonth()+1) + "-" + ddate.getDate();

				console.log(item.sales_rep)

				$("#customer").val(item.firstname + ' ' + item.lastname);
				$("#email").val(item.email);
				$("#address").val(item.address);
				$("#postalcode").val(item.postalcode);
				$("#city").val(item.city);
				$("#province").val(item.province);

				//$("#delivery_date").val();

				$("#terms").val(item.payment_term);
				$("#customer_id").val(item.id);
				$("#due_date").val(duedate);
            	$("#sales_rep").val(item.sales_rep);
            	$("#driver_id").val(item.driver_id);
            	$(".duedays").text(days);
			}
		})
	})

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

	// When customer form is submitted

	$("#customer_form").submit(function(e){
		e.preventDefault();
		$("#customer_modal").fadeOut(5);

		var formvars = $("#customer_form").serialize();

		$.ajax({
            type: "POST",
            url: $(this).attr("action"),
            data: formvars,
            dataType:"json",
            success: function(data) {

            	$("#customer").val(data.customer.firstname + ' ' + data.customer.lastname);
            	$("#email").val(data.customer.email);
            	$("#address").val(data.customer.address);
            	$("#postalcode").val(data.customer.postalcode);
            	$("#city").val(data.customer.city);
            	$("#province").val(data.customer.province);
            	$("#delivery_date").val();
            	$("#due_date").val(data.customer.due_date);
            	$("#sales_rep").val(data.customer.sales_rep);
            	$("#driver_id").val(data.customer.driver_id);
            	$("#terms").val(data.customer.payment_term);
            	$("#customer_id").val(data.customer.id);

                console.log(data);
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

		$.ajax({
			type: "GET",
			url: '/admin/products/search',
			data: {keyword: $(this).val() },
			dataType: "json",
			success: function(data) {
				products = data;
				$.each(products, function(i, prod) {
					$("#products-list").append('<li><a href="#" class="product-select" data-id="'+prod.id+'"> #'+prod.id+' - '+prod.name + '(' + prod.sku + ') </a></li>');
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
    	$("#products-list").fadeToggle(50);
    }) // End of Create product button click

    // Close the product creation modal

    $(".pc_close").click(function(){
        $("#product_creator_wrapper").css("display","none");   
    }) // End of product creation close

    // Create new product when product form submitted

    $("#create-product").submit(function(e){            
       e.preventDefault();
        var datastring = $("#create-product").serialize();
        $(".pc_wrapper").fadeOut('slow');
        $('.loading-info').css({opacity: 0, display: 'flex'}).animate({opacity: 1}, 1000);

        $.ajax({
            type: "POST",
            url: "/admin/products/create",
            data: datastring,
            success: function(data) {
                var i = $("#new_product_row").val();

                $("#product_name-"+i).val(data.product.name);
                $("#product_id-"+i).val(data.product.id);
                $("#rate-"+i).val(data.product.price);
                $("#quantity-"+i).val(1);
                $("#description-"+i).val(data.product.description);
                $("#creditrate-"+i).html(data.product.price);
                $("#amount-"+i).html(data.product.price);
                $("#result-div-"+i).css("display","none");

                addRow();

                $(".pc_wrapper").fadeIn('slow');
                $('.loading-info').fadeOut('slow');
                $("#product_creator_wrapper").fadeOut("slow");

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

		$.each(products, function(i, item) {
			if(selectedid == item.id) {
				$("#products-list").parent().parent().find(".product-name").val(item.name);
				$("#products-list").parent().parent().find(".product-id").val(item.id);
				$("#products-list").parent().parent().find(".product-quantity").val(1);
				$("#products-list").parent().parent().find(".product-description").html(item.description);
				$("#products-list").parent().parent().find(".product-sku").text(item.sku);
				$("#products-list").remove();
				$("#products-list").fadeOut(50);

				addRow();
				showTotQty();
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
		$("#order_form").attr("action","/admin/orders/process-po");
        $(".print").css("display","inline");
        
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


					$("#order_id").val(order.id);
				 	$("#customer").val(order.user.firstname + ' ' + order.user.lastname);
             		$("#email").val(order.user.email);
            		$("#address").val(order.billing.address);
            		$("#postalcode").val(order.billing.postalcode);
            		$("#city").val(order.billing.city);
            		$("#province").val(order.billing.province);
            		$("#delivery_date").val();
            		$("#due_date").val(order.due_date);
            		$("#sales_rep").val(order.user.sales_rep);
            		$("#driver_id").val(order.user.driver_id);
            		$("#terms").val(order.user.payment_term);
            		$("#customer_id").val(order.user.id);
            		$("#notes").val(order.notes);

            		if(order.item.length > 0) {
            			$("#items-table tbody").html('');

            			$.each(order.item, function(i, itm) {
            				restoreRow(itm, i+1);
            			});

            			//orderRow();
            			showTotQty();
            		}
				}
			},
			error: function(data) {
				alert('Unable to get the order details. Contact support');
				$("#full_modal").fadeOut(50);
			}
		})
	}); // End of Process modal function

	function addProcessTable() {

		$("#table-container").append(`
				<input type="hidden" name="order_id" value="" id="order_id" />
				<table class="table process_table" id="items-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th width="30%">Product</th>
                            <th>SKU(Code)</th>
                            <th>Rate</th>
                            <th>Weight(`+defweight+`)</th>
                            <th>Qty</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot>
                   		<tr>
                    		<th colspan="4"></th>
                    		<th><div id="net-weight"></div></th>
                    		<th><div id="net-quantity"></div></th>
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

   		for(var x=1; x<=item.quantity; x++) {
   			if(x > 1) { weights += ','; }
   			weights += `0`;
   		}

		$("#items-table tbody").append(`<tr id="row`+item.id+`" class="product_row">
                        <td class="text-center" valign="middle"><span class="row-id">`+i+`</span></td>
                        <td>
                            <input type="text" name="product_names[]" value="`+item.product_name+`" class="form-control noneditable product-name" autocomplete="off" />
                            <input type="hidden" name="product_ids[]" value="`+item.product_id+`" class="product-id" data-id="`+item.id+`" data-priceby="`+item.price_by+`" />
                        </td>
                        <td><div class="product-sku">`+item.product_sku+`</div></td>
                        <td><div class="product-rate text-right" data-rate="`+item.rate+`">$`+Number(item.rate).toFixed(2)+`</div></td>
                        <td width="100" class="text-center"><input type="number" min="0" step="any" name="weights[]" value="`+item.weight+`" class="form-control noneditable product-weight" pattern="[0-9]" /></td>
                        <td width="150" class="text-center">
                        	<input type="number" name="quantities[]" value="`+item.quantity+`"  class="form-control noneditable product-quantity" readonly />
                        	<input type="hidden" name="backorderquantities[]" value="0" class="product-backorder" />\
                        	<input type="hidden" name="originalquantities[]" value="`+item.quantity+`" class="product-required" />
                        	<input type="hidden" name="weightlist[]" value="`+weights+`" class="weight-list"/>
                        	<a href="#" class="process-item"><i class="fa fa-edit"></i></a>
                        </td>
                        <td width="150"><div class="product-total text-right">$0</div></td>
                    </tr>`);
	} // End of Insert rows for processing


	// Update Price when Weight is changed

	$("body").delegate(".product-weight","change",function(){
		showTotQty();
	});

	// Show modal when an item is changing by click on edit
	
	$("body").delegate(".process-item","click",function(){
		var qty = $(this).parent().parent().find(".product-quantity").val();
		var orgqty = $(this).parent().parent().find(".product-required").val();
		var productname = $(this).parent().parent().find(".product-name").val();
		var productid = $(this).parent().parent().find(".product-id").attr("data-id");
		var backorder = $(this).parent().parent().find(".product-backorder").val();
		var weights = $(this).parent().parent().find(".weight-list").val();
		$("#weight-list").html('');

		weightspair = weights.split(',');

		for(var y=0; y< qty; y++) {
			var targetq = y + 1;
			$("#weight-list").append(`<li><label>#`+targetq+` (`+defweight+`)<input type="number" class="quantity-weight" value="`+weightspair[y]+`" />`);
		}

		$("#process_modal").fadeIn(50);
		$("#process-product").text(productname);
		$("#changed-quantity").val(qty);
		$("#original-quantity").val(orgqty);
		$("#backorder-quantity").val(backorder);
		$("#process-id").val(productid);
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
		var originalqty = $("#original-quantity").val();
		var backorderqty = Number(originalqty) - Number(qty);
		var listlength = $("#weight-list li").length;
		var diff = Number(listlength) - Number(qty);

		console.log('List: '+listlength + '/' +diff);

		for(var y=1; y <= Math.abs(diff); y++) {
			if(diff > 0) 
				$("#weight-list li:last").remove();
			else
				$("#weight-list").append(`<li><label>#`+qty+` (`+defweight+`)<input type="number" class="quantity-weight" value="0" />`);
		}

		if($("#send-backorder").prop("checked")== true) {
			if(backorderqty > 0)
				$("#backorder-quantity").val(backorderqty);
			else
				$("#backorder-quantity").val(0);
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
		$("#row"+id).find('.product-weight').val(totweight);
		$("#row"+id).find('.weight-list').val(qweights);
		$("#row"+id).find('.product-weight').val();
		$("#process_modal").fadeOut(50);

		showTotQty();

		updateBackorders();
	})  // End of Qunatity and Weight changes when processing


	function processOrder(formvars) {

		$.ajax({
            type: "POST",
            url: '/admin/orders/process-po',
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


	/******** Common functions for Order creation and Processing **************/

	// Update Quantity, Weight, Total etc

	function showTotQty() {
		let net_quantity = 0;
		let net_weight = 0;
		let net_total = 0;

		$(".product-quantity").each(function(){
			let this_quantity = $(this).val();
			let this_rate = $(this).parent().parent().find(".product-rate").attr("data-rate");
			let this_weight = $(this).parent().parent().find(".product-weight").val();
			let this_priceby = $(this).parent().parent().find(".product-id").attr("data-priceby");
			let this_total = 0;

			if(this_priceby  == 'quantity') {
				this_total = this_weight*this_rate;
				//this_total = this_quantity*this_rate;
			}
			else {
				this_total = this_weight*this_rate;
			}

			net_quantity = net_quantity + Number(this_quantity);
			net_total = net_total + this_total;
			net_weight = Number(net_weight) + Number(this_weight);

			$(this).parent().parent().find(".product-total").text(showPrice(this_total));
		});

		$(".total_qty").text(net_quantity);
		$("#net-quantity").text(net_quantity);
		$("#net-total").text(showPrice(net_total));
		$("#net-weight").text(net_weight);
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
			var sku = $(this).find('.product-sku').text();
			var qty = $(this).find('.product-backorder').val();

			if(Number(qty) > 0) 
				$(".backorder-table tbody").append('<tr><td>'+(++icount)+'</td><td>'+product+'</td><td>'+sku+'</td><td>'+qty+'</td></tr>');
		})

		if(icount === 0) {
			$("#backorder-container").html('');
		}
	}
	
	$(".print").click(function(e){
	    e.preventDefault();
	    
	    var divContents = document.getElementById("full_modal").innerHTML;
        var a = window.open('', '', 'height=500, width=500');
        a.document.write('<html>');
        a.document.write('<body >');
        a.document.write(divContents);
        a.document.write('</body></html>');
        a.document.close();
        a.print();
	})


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


