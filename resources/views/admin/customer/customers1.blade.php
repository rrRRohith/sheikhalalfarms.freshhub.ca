@extends('layouts.admin')
@section('title',$submenu .'Customers')
@section('page_title','Customers')
@section('page_nav')

<ul>
  <li @if($submenu=="All") class="active" @else class=""  @endif><a  href="{{url('admin/customers')}}">All Customers</a></li>
  <li @if($submenu=="Active") class="active" @else class="" @endif><a  href="{{url('admin/customers/getcust/1')}}">Active Customers</a></li>
  <li @if($submenu=="Inactive") class="active" @else class="" @endif ><a   href="{{url('admin/customers/getcust/0')}}">Inactive Customers</a></li>
  <li @if($submenu=="Customertype") class="active" @else class=""  @endif><a  href="{{url('admin/customertype')}}">Customer Types</a> </li>
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
                                                    <input type="text" name="search" id="search"  value="{{Request()->search}}" placeholder="City Name,Store name,Customer Name,Address">
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
                                                    <select name="status"  class="form-control">
                                                        <option value="2" @if(isset(Request()->status) && (Request()->status==2)) selected @endif>All Customers</option>
                                                        <option value="1" @if(isset(Request()->status) && (Request()->status==1)) selected @endif>Active</option>
                                                        <option value="0" @if(isset(Request()->status) && (Request()->status==0)) selected @endif>Inactive</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-12 col-lg-2">
                                                  
                                                    <button  class="white_button" type="submit">Filter Customers</button>
                                                </div>
                                            </div>
                                        </form>
                                        
                                        <div class="table-list-responsive-md">
                                            
                                            <table class="table table-customer mt-0">

                                                <thead>
                                                    <tr>
                                                        <th class="text-left">ID</th>
                                                        <th class="text-left">Name</th>
                                                        <th class="text-left">Store Name</th>
                                                        <th class="text-left">Type</th>
                                                        <th class="text-left">Addr.</th>
                                                        <th class="text-left">Unpaid Inv.</th>
                                                        <th class="text-left">Total Due</th>
                                                        <th class="text-left">Status</th>
                                                        <th class="text-right">Actions</th>
                                                    </tr>
                                                </thead>
                                            <tbody>
                                                @php $i=1;@endphp
                                                @if(isset($customer) && count($customer)>0)
                                                
                                                @foreach($customer as $c)
                                                
                                                    <tr>
                                                        <td data-label="" class="text-left">{{$c->id}}</td>
                                                        <td class="text-lg-left  text-md-left"data-label="Organization"><label class=""><a target='' href="{{admin_url('customers')}}/{{$c->id}}">{{$c->firstname}} {{$c->lastname}}</a></label></td>
                                                        <td data-label="City" class="text-left"><label class="">{{$c->business_name}}</label></td>
                                                        <td data-label="Customer type" class="text-left">{{$c->types->name ?? ''}}</td>
                                                        <td>{{$c->address}}</td>
                                                        <td class="text-center">{{count($c->invoice)}}</td>
                                                        <td class="text-right" align="right"><a href="{{admin_url('invoices')}}/{{$c->id}}">{{'$'.number_format($c->invoice->sum('grand_total'),2)}}</a></td>
                                                        <td class="text-center">
                                                            <div class="form-check form-switch">
                                                               <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" <?php if(isset($c)){ if($c->status==1){ ?> checked <?php } } ?> onchange="changeStatus('{{$c->id}}');" name="status">
                                                               <label class="form-check-label" for="flexSwitchCheckChecked"></label>
                                                            </div>
                                                        </td>
                                                        <td class="text-right">
                                                            <div class="fh_actions">
                                                                <a href="#" class="fh_link">Actions <i class="fa fa-caret-down"></i> </a>
                                                                <ul class="fh_dropdown">
                                                                    <!--<li><a href="{{admin_url('customers')}}/{{$c->id}}/edit">Edit</a></li>-->
                                                                     <a class="editcustomer" data-id="{{$c->id}}"><li><i class="fa fa-edit" aria-hidden="true"></i> Edit</li></a>
                                                                    <a href="{{admin_url('customers')}}/{{$c->id}}/del"><li><i class="fa fa-trash" aria-hidden="true"></i> Delete</li></a>
                                                                </ul>
                                                            </div> 
                                                        </td>
                                                    </tr>
                                                    @php $i++;@endphp
                                                @endforeach
                                                @else
                                                <tr>
                                                    <td colspan="9" class="text-center">No Customers Found</td>
                                                </tr>
                                            @endif
                                            </tbody>
                                            
                                        </table>
                                        
                                        
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <div class="text-bold" style="padding:10px;"> {{$customer->links()}}Showing Page {{$customer->currentPage()}} of {{$customer->lastPage()}} </div>
                </div>
            </div>
        </div>
      </div>
    </div>
</div>
@include('admin.customer.customer-modal')

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
       $('.editcustomer').click(function(e){
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
                        $('#city1').val(value.city);
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
            	
            	alert('Some errors in submission, Please retry');
                console.log(xhr);
                console.log(status);
                console.log(error);
            }
        })
	});
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
</script>
<script>
$("#phone").inputmask({"mask": "(999) 999-9999"});
</script>
<!--<script src="/js/custom.js" ></script>-->
@endsection