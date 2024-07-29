$(document).ready(function(){
	let customers = [];
	let products = [];
	let defweight = '';


	init();


	function init() {

		$.get({
			url:'/customer/helpers/def-weight',
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
		$("#order_form").attr("action","/customer/orders/create-po");
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
		if($("#items-table tbody tr").length >0 && confirm('Are you sure to delete?')) {
		   $(this).closest('tr').remove();
		    addRow();
		} 
	});

	// Create a table list for order items

	function addOrderTable() {
		$("#table-container").append(`
		<input type="hidden" name="order_id" value="" id="order_id" />
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
                    <tfoot style="display:none">
                    <tr>
                		<td colspan="7"></td>
                		<td><div id="net-total" class="text-right"></div></td>
                		<td>&nbsp;</td>
                	</tr>
                    </tfoot>
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
                            <input type="hidden" name="product_ids[]" value="" class="product-id" data-priceby=""/>
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
	    let action = $("#form-action").val();
	    console.log('action:'+action)
	    if(action == 'create' || action == 'edit') {
	        var itemweight = $(this).parent().parent().find(".product-weight").attr("data-weight");
	        console.log('itemweight:'+itemweight)
	        $(this).parent().parent().find(".product-weight").val(itemweight * $(this).val())
	    }
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
		else if(action=='edit')
		{
		    editOrder(formvars);
		}
		else {
			processOrder(formvars);
		}
	});


	function createOrder(formvars) {
        var url="/customer/orders";
		$.ajax({
            type: "POST",
            url: '/customer/orders/create-po',
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
            	$("#address").val(data.user.address);
            	$("#postalcode").val(data.user.postalcode);
            	$("#city").val(data.user.city);
            	$("#province").val(data.user.province);
            	$("#delivery_date").val();
            	$("#due_date").val(data.user.due_date);
            	$("#sales_rep").val(data.user.sales_rep);
            	$("#driver_id").val(data.user.driver_id);
            	$("#terms").val(data.user.payment_term);
            	$("#customer_id").val(data.user.id);

				$("#customer_modal").fadeOut(5);

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
								'</ul>');
		products = [];

		$.ajax({
			type: "GET",
			url: '/customer/products/search',
			data: {keyword: $(this).val() },
			dataType: "json",
			success: function(data) {
				products = data;
				$.each(products, function(i, prod) {
			    $.ajax({
                    type: "get",
                    url: "/customer/helpers/getweightprice/"+prod.id,
                    success: function(data) {
                        weight=data.weight;
                        rate=data.price;
					$("#products-list").append('<li><a href="#" class="product-select" data-id="'+prod.id+'"> #'+prod.id+' - '+ prod.sku +' - ' +prod.name + '- ('+rate+'/'+weight+') </a></li>');
                    }});
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
				$("#products-list").parent().parent().find(".product-quantity").val(1);
				$("#products-list").parent().parent().find(".product-description").html(data.product.description);
				$("#products-list").parent().parent().find(".product-sku").text(data.product.sku);
				
				$("#products-list").parent().parent().find(".product-weight").val(item.weight);
				$("#products-list").parent().parent().find(".product-weight").attr("data-weight",item.weight);
			    $("#products-list").parent().parent().find(".product-rate").attr("data-rate",item.price);
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
       

	// When a product is selected from the list

	$("body").delegate(".product-select","click",function(){
		var selectedid = $(this).attr("data-id");
        var weight='';
        var rate='';
		$.each(products, function(i, item) {
			if(selectedid == item.id) {
			    $.ajax({
            type: "get",
            url: "/customer/helpers/getweightprice/"+item.id,
            success: function(data) {
                weight=data.weight;
                rate=data.price;
				$("#products-list").parent().parent().find(".product-name").val(item.name);
				$("#products-list").parent().parent().find(".product-id").val(item.id);
				$("#products-list").parent().parent().find(".product-id").attr("data-priceby",item.price_by);
				$("#products-list").parent().parent().find(".product-quantity").val(1);
				$("#products-list").parent().parent().find(".product-description").html(item.description);
				
				$("#products-list").parent().parent().find(".product-weight").val(weight);
				$("#products-list").parent().parent().find(".product-weight").attr("data-weight",weight);
			    $("#products-list").parent().parent().find(".product-rate").attr("data-rate",rate);
			    $("#products-list").parent().parent().find(".product-rate").html(`$`+Number(rate).toFixed(2));
				
				$("#products-list").parent().parent().find(".product-sku").text(item.sku);
				$("#products-list").remove();
				$("#products-list").fadeOut(50);

				addRow();
				showTotQty();
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
					
					var today = new Date();
				var ddate = new Date();
				

				
					ddate.setDate(order.due_date);
				

				var duedate = ddate.getFullYear() + "-" + (ddate.getMonth()+1) + "-" + ddate.getDate();
					


					$("#order_id").val(order.id);
				 	$("#customer").val(order.user.firstname + ' ' + order.user.lastname);
             		$("#email").val(order.user.email);
            		$("#address").val(order.billing.address);
            		$("#postalcode").val(order.billing.postalcode);
            		$("#city").val(order.billing.city);
            		$("#province").val(order.billing.province);
            		$("#delivery_date").val();
            		$("#due_date").val(duedate);
            		$("#sales_rep").val(order.user.sales_rep);
            		$("#driver_id").val(order.driver_id);
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
	
	
	$("body").delegate(".edit-order","click",function(){
		$("#table-container").html('');
		addOrderTable();

		var id = $(this).attr("data-id")

		$("#full_modal").fadeIn(50);
		$("#form-action").val("edit");
		$("#order-modal-title").text('Edit order');
		$("#order_form").attr("action","/customer/orders/edit-po");
        $(".print").css("display","none")
		$.ajax({
			url: '/customer/orders/detail/'+id,
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
            		$("#address").val(order.billing.address+',\n'+order.billing.city+', '+order.billing.province+',\n'+order.billing.postalcode);
            		$("#postalcode").val(order.billing.postalcode);
            		$("#city").val(order.billing.city);
            		$("#province").val(order.billing.province);
            		
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
        var weight='';
        var rate='';
   		
   		$.ajax({
			url:'/customer/helpers/get-weight/'+item.id,
			method: 'GET',
			success: function(data) {
			    getweight=data.result;
			    rate=data.rate;
			    weight=data.weight;
			 //   $("#products-list").parent().parent().find(".product-name").val(item.name);
				// $("#products-list").parent().parent().find(".product-id").val(item.id);
				// $("#products-list").parent().parent().find(".product-id").attr("data-priceby",item.price_by);
				// $("#products-list").parent().parent().find(".product-quantity").val(1);
				// $("#products-list").parent().parent().find(".product-description").html(item.description);
				
				// $("#products-list").parent().parent().find(".product-weight").val(getweight);
				// $("#products-list").parent().parent().find(".product-weight").attr("data-weight",weight);
			 //   $("#products-list").parent().parent().find(".product-rate").attr("data-rate",rate);
			 //   $("#products-list").parent().parent().find(".product-rate").html(`$`+Number(rate).toFixed(2));
				
				// $("#products-list").parent().parent().find(".product-sku").text(item.sku);
			    $("#items-table tbody").prepend(`<tr id="row`+item.id+`" class="product_row">
                        <td class="text-center number_column" valign="middle"><span class="row-id">`+i+`</span></td>
                        <td>
                            <input type="text" name="product_names[]" class="form-control noneditable product-name" autocomplete="off" value="`+item.product_name+`"/>
                            <input type="hidden" name="product_ids[]" value="`+item.product_id+`" class="product-id" data-priceby="`+item.price_by+`"/>
                        </td>
                        <td class="sku_column"><div class="product-sku">`+item.product_sku+`</div></td>
                        <td class="description_column"><div class="product-description">`+item.product_description+`</div></td>
                        
                        <td width="150"><input type="number" name="quantities[]"  min="1" step="1" class="form-control noneditable product-quantity" value="`+item.quantity+`"/></td>

                        <td class="text-center" valign="middle"><big><a href="#" class="trash-row"><i class="fa fa-trash"></i></a></big></td>
                    </tr>`);
                
                    
                 orderRow();
                 showTotQty();
                    
			}
   		    
   		});
   	

		
	} // End of Insert rows for edit


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
function editOrder(formvars) {

		$.ajax({
            type: "POST",
            url: '/customer/orders/edit-po',
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
				this_total = this_quantity*this_rate;
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

function initAutocomplete() {
billing_address = document.querySelector("#address");
delivery_address = document.querySelector("#delivery_address");
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

billing_address.focus();
// When the user selects an address from the drop-down, populate the
// address fields in the form.
autocomplete.addListener("place_changed", fillInAddress);
del_autocomplete.addListener("place_changed", fillDelAddress);
}

function fillInAddress() {
    // Get the place details from the autocomplete object.
    const place = autocomplete.getPlace();
    let address1 = "";
    let postcode = "";
    let add = "";
    // Get each component of the address from the place details,
    // and then fill-in the corresponding field on the form.
    // place.address_components are google.maps.GeocoderAddressComponent objects
    // which are documented at http://goo.gle/3l5i5Mr
    for (const component of place.address_components) {
        const componentType = component.types[0];
        switch (componentType) {
            case "street_number": {
                address1 = `${component.long_name} ${address1}`;
                break;
            }
        
            case "route": {
                address1 += component.long_name;
                add=component.long_name;
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
                address1 += ',\n'+component.long_name;
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
    
    delivery_address.focus();
    
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
                break;
            }
        
            case "route": {
                daddress1 += dcomponent.long_name;
                dadd1=dcomponent.long_name;
                break;
            }
        
            case "postal_code": {
                dpostcode = `${dcomponent.long_name}${dpostcode}`;
                break;
            }
        
            case "postal_code_suffix": {
                dpostcode = `${dpostcode}-${dcomponent.long_name}`;
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
    daddress1 +=", \n"+`${dpostcode}`;
    document.querySelector("#delivery_address1").value = dadd1;
    document.querySelector("#delivery_postalcode").value = dpostcode;
    document.querySelector("#delivery_address").value = daddress1;
    
    // After filling the form with address components from the Autocomplete
    // prediction, set cursor focus on the second address line to encourage
    // entry of subpremise information such as apartment, unit, or floor number.
}

