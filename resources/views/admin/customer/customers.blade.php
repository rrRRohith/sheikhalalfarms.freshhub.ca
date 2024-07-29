@extends('layouts.admin')
@section('title',$submenu .'Customers')
@section('page_title','Customers')
@section('page_nav')

<ul>
    @can('Customer View')
  <li @if($submenu=="All") class="active" @else class=""  @endif><a  href="{{url('admin/customers')}}">All Customers</a></li>
  <li @if($submenu=="Active") class="active" @else class="" @endif><a  href="{{url('admin/customers?status=1')}}">Active Customers</a></li>
  <li @if($submenu=="Inactive") class="active" @else class="" @endif ><a   href="{{url('admin/customers?status=0')}}">Inactive Customers</a></li>@endcan
  @can('Customertype View')<li @if($submenu=="Customertype") class="active" @else class=""  @endif><a  href="{{url('admin/customertype')}}">Customer Types</a> </li>@endcan
</ul>   
@endsection
@section('contents')
<div class="content-container">
    <div class="content-area">
        <div class="row main_content">
            <div class="col-md-12">
                <div class="card no-margin minH">
                    <div class="card-block">
                        <div class="card-title">
                            @can('Customer Create')
                           <!--<a href="{{admin_url('customers/create')}}"  class="pull-right green_button">-->
                           <!--                            <i class="fa fa-new"></i> New Customer</a>-->
                           <a class="pull-right green_button newcustomer">
                                                       <i class="fa fa-new"></i> New Customer</a>
                            @endcan
                            <h3>Customers</h3>
                        </div>
                        <section class="card-text customers_outer">
                            <div class="row filter-customer">
                                <div class="col-lg-12">
                                    <div class="filter-customer-list">
                                        @if (Session::has('message'))
                                        <div class="alert alert-success">
                                            {{ Session::get('message') }}
                                        </div>
                                        @endif
                                        
                                        <form action="" method="get" id="filter_form">
                                            @csrf
                                            <div class="row">
                                                <div class="col-sm-4 col-lg-4">
                                                    <label class="control-label">Search By Keyword</label> 
                                                    <input type="text" name="search" id="table-search"  value="{{Request()->search}}" placeholder="City Name,Store name,Customer Name,Address">
                                                </div>
                                                <div class="col-sm-4 col-lg-3">
                                                    <label class="control-label">Search By Type:</label>
                                                    <select name="customer_type" id="type" class="form-control">
                                                        <option value="">Select Type</option>
                                                        @foreach($customertypes as $customertype)
                                                            <option value="{{$customertype->id}}" @if(isset(Request()->customer_type) && (Request()->customer_type==$customertype->id)) selected @endif >{{$customertype->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-sm-4 col-lg-3">
                                                    <label class="control-label">Select By Customers:</label>
                                                    <select name="status"  class="form-control" id="status">
                                                        <option value="" selected>All Customers</option>
                                                        <option value="1" @if(isset(Request()->status) && (Request()->status==1)) selected @endif>Active</option>
                                                        <option value="0" @if(isset(Request()->status) && (Request()->status==0)) selected @endif>Inactive</option>
                                                    </select>
                                                </div>
                                                <!-- <div class="col-sm-12 col-lg-2">
                                                  
                                                    <button  class="white_button" type="submit">Filter Customers</button>
                                                </div> -->
                                            </div>
                                        </form>
                                        
                                        <div class="table-list-responsive-md">
                                            
                                            <table class="table table-customer mt-0">

                                                <thead>
                                                    <tr>

                                                        <th class="text-left"><a class="sort" href="#id" data-sort="id" data-direction="desc">
                                              ID <i class="ml-2 fa fa-sort"></i></a> </th>
                                                        <!--<th class="text-left"><a class="sort" href="#firstname" data-sort="firstname" data-direction="asc">Name <i class="ml-2 fa fa-sort"></i></a></th>-->
                                                        <th class="text-left"><a class="sort" href="#business_name" data-sort="business_name" data-direction="asc">Store Name <i class="ml-2 fa fa-sort"></i></a></th>
                                                        <th class="text-left">Type</th>
                                                        <th class="text-left"><a class="sort" href="#address" data-sort="address" data-direction="asc">Addr. <i class="ml-2 fa fa-sort"></i></a></th>
                                                        <th class="text-left">Unpaid Inv.</th>
                                                        <th class="text-left">Total Due</th>
                                                        <th class="text-left"><a class="sort" href="#status" data-sort="status" data-direction="asc">Status <i class="ml-2 fa fa-sort"></i></a></th>
                                                        <th>Special Price</th>
                                                        <th class="text-right">Actions</th>
                                                    </tr>
                                                </thead>
                                            <tbody class="append-row">
                                                <tr><td colspan="9" class="text-center">Loading Data...</td><tr>
                                            </tbody>
                                            
                                        </table>
                                        
                                        
                                        
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
<!--<div id="error" style="display: none;">-->
<!--    <div class="modal_box">-->
<!--        <div class="modal_title">-->
<!--            <a class="pull-right close"><i class="fa fa-close"></i></a>-->
<!--            <h3><span id="err">Errors</span></h3>-->
<!--        </div>-->
<!--        <div class="modal_body">-->
<!--            <div class="px-lg-3 no-padding fh_form" id="errorForm">-->
                
<!--            </div>-->
<!--            <div class="col-sm-12">-->
<!--                <button type="submit" class="btn btn-success btn-block green_button close">-->
<!--                    <clr-icon shape="floppy"></clr-icon>-->
<!--                   close                        -->
<!--                </button>-->
           
<!--            </div>-->
<!--        </div>-->
<!--        <div class="modal_footer">-->

<!--        </div>-->
<!--    </div>-->
<!--</div>-->
@include('admin.customer.customer-modal')
@include('admin.customer.customer-error')

@endsection
@section('bottom-scripts')
<script>
function changeStatus(id) {
    if (id) {
        $.ajax({
            
            url: "/admin/customers/changestatus/" + id + "/status",
            type: 'get',
            data: {},
            success: function(data) {
                console.log(data.status);
            }
        });
    }
}




    // $('#type').on('change',function(){
    //     var type=$(this).val();
    //     window.location.href = "<?php echo url('admin/customers');?>/"+type;
    // });
$(document).ready(function(){
    
       $('.newcustomer').click(function(e){
           e.preventDefault();
           $('#mhead').html('Add Customer');
           $('#username').val('');
           $('#username').attr('readonly', false);
                        $('#id').val('');
                        $('#business_name').val('');
                        $('#sales_rep').val('');
                        $('#customer_type').val('');
                        $('#firstname').val('');
                        $('#lastname').val('');
                        $('#address').val('');
                        $('#postalcode').val('');
                        $('#city1').val('');
                        $('#province').val('ON');
                        $('#phone').val('');
                        $('#email').val('');
                        $('#payment_method').val(1);
                        $('#payment_term').val('');
                        $('#driver_id').val('');
                        $('#description').val('');
                        var img="{{asset('/images/users/dummy.jpg')}}";
                        $("#uploaded-image1").attr("src", img).css("display", "block");
           $('#customer_modal').fadeIn('slow');
       });
       $('body').delegate('.editcustomer','click',function(e){
           e.preventDefault();
           $('#mhead').html('Edit Customer');
           var id=$(this).data('id');
           var url="{{admin_url('customers/getdetails')}}/"+id;
           $.ajax({
                url:url,
                type:"GET",
                dataType:"json",
                success:function(data)
                {
                    $.each(data,function(key,value)
                    {
                        console.log(data);
                        $('#username').val(value.username);
                        $('#username').attr('readonly', true);
                        $('#id').val(value.id);
                        $('#business_name').val(value.business_name);
                        $('#sales_rep').val(value.sales_rep);
                        $('#customer_type').val(value.customer_type);
                        $('#firstname').val(value.firstname+' '+value.lastname);
                        $('#lastname').val(value.lastname);
                        $('#address').val(value.address);
                        $('#postalcode').val(value.postalcode);
                        $('#city').val(value.city);
                        $('#province').val(value.province);
                        $('#phone').val(value.phone);
                        $('#email').val(value.email);
                        $('#payment_method').val(value.payment_method);
                        $('#payment_term').val(value.payment_term);
                        $('#driver_id').val(value.driver_id);
                        $('#description').val(value.description);
                        var img="{{asset('images/users')}}/"+value.profile_picture;
                        $("#uploaded-image1").attr("src", img).css("display", "block");
                        var url1="{{admin_url('customers')}}/"+value.id;
                        $('#customer_form').attr('action', url1);
                        $('#customer_form').attr('method', 'PUT');
                        
                    });
                }
           });
           $('#customer_modal').fadeIn('slow');
       });
       
       $("#customer_modal .close").click(function(e){
		e.preventDefault();
		$("#customer_modal").fadeOut(50);
	})

	$("#customer_form").submit(function(e){
		e.preventDefault();
		
		var formvars = $("#customer_form").serialize();
        var met=$('#id').val() !='' ? 'PUT' : 'POST';
        
		$.ajax({
            type: met,
            url: $(this).attr("action"),
            data: formvars,
            dataType:"json",
            success: function(data) {
                $("#customer_modal").fadeOut(5);
            	location.reload();
            },
            error: function(xhr, status, error){
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
	$("#error .close").click(function(e){
		e.preventDefault();
		$("#error").fadeOut(50);
	})
});
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.css" />

<script>
var image_crop = $('#image_demo1').croppie({
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
        image_crop.croppie('bind', {
            url: event.target.result,
        });
    }
    reader.readAsDataURL(this.files[0]);
    $('#uploadimageModal1').modal('show');
});


$('.crop_image1').click(function(event) {
    image_crop.croppie('result', {
        type: 'canvas',
        format: 'png'
    }).then(function(response) {
        $("#uploaded-image1").attr("src", response).css("display", "block");
        $("#picture1").val(response);
    });
    $("#profile_pic").val("");
    $('#uploadimageModal1').modal('hide');
});
$('#payment_method').change(function(){
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
</script>
<script>
$("#phone").inputmask({"mask": "(999) 999-9999"});
</script>
<script>
let searchKey    = $('input#table-search');
let searchType   = $('select#type');
let searchStatus = $('select#status');
let sortDiv = $('div.paginate');
let deferUrl = `{{ admin_url('customers/defer')}}`;
$(document).ready(function() {

  $.getJSON(`${deferUrl}?status=${searchStatus.val()}`,  function(response) {
    renderTable(response);
  });
  $('#table-search').on('keyup', function(){
    loadingRow();
    tableSearch();
  });
  $('#type').on('change', function(){
    loadingRow();
    tableSearch();
  });
  $('#status').on('change', function(){
    loadingRow();
    tableSearch();
  });
  function tableSearch()
  {
      $.getJSON(`${deferUrl}?key=${searchKey.val()}&type=${searchType.val()}&status=${searchStatus.val()}`, function(response) {
      renderTable(response);
    });
  }
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
  $('tbody.append-row').html(`<tr><td colspan="7" class="text-center">Loading Data...</td><tr>`);
}
async function renderTable(response){
  let table = '';
  await response.data.forEach(function(row, index){
    let createdAt = new Date(row.created_at).toLocaleDateString('en-us', {year:"numeric", month:"short", day:"numeric"});
    table+=`<tr><td>
              ${row.id}
            </td>
            
            <td class="text-lg-left  text-md-left"data-label="Organization">
              <label class="">${row.storename}</label>
            </td>
            <td class="text-lg-left  text-md-left"data-label="Organization">
              <label class="">${row.type}</label>
            </td>
            <td class="text-lg-left  text-md-left"data-label="Organization">
              <label class="">${row.address}</label>
            </td>
            <td class="text-lg-left  text-md-left"data-label="Organization">
              <label class="">${row.unpaid_invoice}</label>
            </td>
            <td class="text-lg-left  text-md-left"data-label="Organization">
              <label class="">${row.total_due}</label>
            </td>
            <td class="text-lg-left  text-md-left"data-label="Organization">
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" ${row.status == '1' ? 'checked' : ''}                                                   onchange="changeStatus('${row.id}');"                                                    name="status">
                <label class="form-check-label" for="flexSwitchCheckChecked"></label>
              </div> 
            </td>
            <td>
                <u><a href="/admin/customers/${row.id}/price" >Price List</a></u>
            </td>
            <td class="text-right" >
              <div class="fh_actions pull-right">
                <a href="#" class="fh_link">Actions <i class="fa fa-caret-down"></i> </a>
                  <ul class="fh_dropdown">
                    @can('Customer Edit')
                      <a class="editcustomer" data-id="${row.id}"><li><i class="fa fa-edit"></i> Edit</li></a>
                    @endcan
                    @can('Customer Delete')
                      <a href="/admin/customers/${row.id}/del"><li><i class="fa fa-trash"></i> Delete</li></a>
                    @endcan
                  </ul>
              </div>
            </td>
          </tr>`;
          
  });
  $('tbody.append-row').html(table ? table : `<tr><td colspan="7" class="text-center">No data found</td><tr>`);
  $('.paginate').html(response.links);
}
let customer_autocomplete;
let customer_address;

function initAutocomplete() {
    customer_address = document.querySelector("#custaddress");
    customer_autocomplete = new google.maps.places.Autocomplete(customer_address, {
    componentRestrictions: { country: [ "ca"] },
    fields: ["address_components", "geometry"],
    types: ["address"],
});
customer_autocomplete.addListener("place_changed", fillCustAddress);
}
function fillCustAddress() {
    // Get the place details from the autocomplete object.
    const place = customer_autocomplete.getPlace();
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
                add =`${component.long_name} `;
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
    // console.log('Bil:'+address1+' '+postcode)
    // address1 +=", \n"+`${postcode}`;
    document.querySelector("#custpostalcode").value = postcode;
    // document.querySelector("#address").value = address1;
    
    // billing_address.focus();
    
    // After filling the form with address components from the Autocomplete
    // prediction, set cursor focus on the second address line to encourage
    // entry of subpremise information such as apartment, unit, or floor number.
}
</script>
<script  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA2pKP9bGJRpU-35sWLBgirftfBgLhc03c&callback=initAutocomplete&libraries=places&v=weekly"  async ></script>
<!--<script src="/js/custom.js" ></script>-->
@endsection