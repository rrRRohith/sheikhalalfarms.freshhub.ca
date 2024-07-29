
@extends('layouts.admin')
@section('title','Products')
@section('page_title','Products')
@section('page_nav')
    <ul>
        <li class="active"><a href="{{admin_url('products')}}">Products</a></li>
        <li><a href="{{admin_url('categories')}}">Categories</a></li>  
    </ul>
@endsection

@section('contents')
@php 
use App\Weight;

$weight=Weight::where('base',1)->first();
@endphp
<div class="content-container">
    <div class="content-area">
        <div class="row main_content">
            <div class="col-sm-12">
                <div class="card no-margin minH">
                    <div class="card-block">
                        <div class="card-title">
                             @can('Create Product')
                           <!--<a href="{{admin_url('products/create')}}"  class="pull-right green_button"><i class="fa fa-new"></i> New Product</a>-->
                                <a class="pull-right green_button newproduct"><i class="fa fa-new"></i> New Product</a>
                            @endcan
                            <h3>All Products</h3>
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
                                            <div class="row">
                                                <div class="col-sm-4 col-lg-4">
                                                    <label class="control-label">Filter By text:</label> 
                                                    <input type="text" name="search" id="search"  value="{{Request()->search}}" placeholder="Search by product id, sku, name and description">
                                                </div>
                                                <div class="col-sm-4 col-lg-3">
                                                    <label class="control-label">Filter By Category:</label>
                                                    <select name="category" id="category" class="form-control">
                                                        <option value="">Select Category</option>
                                                        @foreach($categories as $category)
                                                        <option value="{{$category->id}}" @if(isset(Request()->category) && (Request()->category==$category->id)) selected @endif>{{$category->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-sm-4 col-lg-3">
                                                    <label class="control-label">Filter By Status:</label>
                                                    <select name="status"  class="form-control">
                                                        <option value="">All</option>
                                                        <option value="1" @if(isset(Request()->status) && (Request()->status==1)) selected @endif>Active</option>
                                                        <option value="0" @if(isset(Request()->status) && (Request()->status==0)) selected @endif>Inactive</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-12 col-md-12 col-lg-2">
                                                    
                                                    <button  class="white_button" type="submit">Filter Products</button>
                                                </div>
                                            </div>
                                        </form>
                                    <div class="table-list-responsive-md">
                                        <table class="table table-customer mt-0">
                                            <thead>
                                                <tr>
                                                    <th class="text-left">
                                                        ID
                                                    </th>
                                                    <th>
                                                        Image
                                                    </th>
                                                    <th class="text-left">
                                                        Name
                                                    </th>
                                                    <th class="text-left">
                                                        Category
                                                    </th>
                                                    <th class="text-left">
                                                        Weight
                                                    </th>
                                                    <th class="text-left">
                                                        Price
                                                    </th>
                                                    <th class="text-left">
                                                        Status
                                                    </th>
                                                    <th class="text-left">
                                                        Created On
                                                    </th>
                                                    <th class="text-right">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($product as $w)
                                                    <tr>
                                                        <td class="text-left">{{$w->id}}</td>
                                                        <td>
                                                            <img src= "{!!$w->picture !='' ? '/images/products/'.$w->picture : '/media/products/dummy.jpg' !!}" style="width:50px;height:50px;"/>
                                                        </td>
                                                        <td  class="text-left" data-label="Organization"><label>{{$w->name}}</label></td>
                                                        
                                                        <td class="text-left" data-label="Organization"><label>{{$w->category['name']}}</label></td>
                                                        <td class="text-left" data-label="Organization"><label>{{Helper::getWeight($w->weight)}}</label></td>
                                                        <td class="text-left" data-label="Organization" class="text-right"><label class="">{{$w->price}}</label></td>
                                                        <td>
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" <?php if(isset($w)){ if($w->status==1){ ?> checked <?php } } ?> onchange="changeStatus('{{$w->id}}');" name="status">
                                                                <label class="form-check-label" for="flexSwitchCheckChecked"></label>
                                                            </div>
                                                        </td>
                                                        <td data-label="Created on" class="text-left">{{date('d M Y',strtotime($w->created_at))}} </td>
                                                        <td class="text-right">
                                                            <div class="fh_actions">
                                                                <a href="#" class="fh_link">Actions <i class="fa fa-caret-down"></i> </a>
                                                                <ul class="fh_dropdown">
                                                                    <a class="editproduct" data-id="{{$w->id}}"><li><i class="fa fa-edit" aria-hidden="true"></i> Edit</li></a>
                                                                    <a href="{{admin_url('products')}}/{{$w->id}}/del"><li><i class="fa fa-trash" aria-hidden="true"></i> Delete</li></a>
                                                                </ul>
                                                            </div> 
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                     <!--</section>-->
                    </section>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@include('admin.product.product-modal')
<div id="product_creator_wrapper1" style="display:none;">
    <div id="product_creator">
        <div class="pc_wrapper1">
            <form action="/admin/products/create" id="edit-product">
                @csrf
                <input type="hidden" id="id" value="">
                <div class="pc_header">
                    <a href="#" class="pcedit_close"><i class="fa fa-close"></i></a>
                    <h3>Edit Product</h3>
                </div>
                <div class="pc_body">
                    
                    <div class="row">
                        <div class="col-sm-12">
                            <p>Enter Product Information</p>
                            <hr/>
                            <div class="form-group">
                                <label>Product Name</label>
                                <input type="text" name="name" id="name" class="form-control" required />
                            </div>
                        </div>
                        <div class="col-sm-7">
                            
                            <div class="form-group">
                                <label>SKU</label>
                                <input type="text" name="sku" id="sku" class="form-control" required />
                            </div>
                            
                            <div class="form-group">
                                <label>Category</label>
                                <select  class="form-control" name="category_id" id="category_id">
                                     @foreach($categories as $p)
                                       <option value="{{$p->id}}" >{{$p->name}}</option>
                                     @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <!--<img id="uploaded-image"  style="display:block;width:150px;height:auto;">-->
                                <img id="uploaded-image1"  style="display:block;width:150px;height:auto;">
                                            <label class="text-gray-dark" for="opportunity_source_id">Image</label>
                                           <br><input type="file" accept="image/*" id="pictur1">
                                            <input type="hidden" name="picture" id="picture1" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                    
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label>Unit Type</label>
                                <select  class="form-control" name="unittype" id="unittype">
                                   <option value="">Select Unit</option>
                                   @foreach($units as $u)
                                   <option value="{{$u->id}}" >{{$u->name}} - {{$u->shortcode}}</option>
                                   @endforeach 
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Unit</label>
                                <input type="number" class="form-control" name="unit" id="unit" value="1" required />
                            </div>
                        </div>
                        
                    </div>
                    <div class="row">
                        
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label>Weight</label>
                                <input type="text" class="form-control" name="weight" id="weight" value="1"   />
                            </div>
                        </div>
    
                        
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Price</label>
                                <input type="text" class="form-control" name="price" id="price" value="0.00" required />
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label>Price By</label>
                                <select class="form-control" name="price_by" id="price_by">
                                    <option value="quantity">Quantity</option>
                                    <option value="weight" selected>Weight</option>
                                </select>
                            </div>
                        </div>
                        
                    </div>
                    
                    <div class="row">
                        
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Description</label>
                                <textarea rows="3"  class="form-control" name="description" id="description"></textarea>
                            </div>
                        </div>
                        
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label>Initial stock</label>
                                <input type="text" class="form-control" name="stock" id="stock"/>
                            </div>
                        </div>
    
                    
                    </div>
                        
                </div>
                <div class="pc_footer">
                    <button type="submit" class="green_button" id="create_product_button">Submit</button>
                </div>
            </form>
        </div>
        <div class="loading-info1">
            Updating product... 
        </div>
    </div>
</div>



<div class="modal" tabindex="-1" role="dialog" id="uploadimageModal1">
    <div class="modal-dialog" role="document" style="min-width: 700px">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Image</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <div id="image_demo1"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary crop_image1">Crop and Save</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endsection
@section('bottom-scripts')
<script src="https://kit.fontawesome.com/yourcode.js" crossorigin="anonymous"></script>
<script>
function changeStatus(id) {
    if (id) {
        $.ajax({
            
            url: "/admin/products/changestatus/" + id + "/status",
            type: 'get',
            data: {},
            success: function(data) {
                console.log(data.status);
            }
        });
    }
}
$('#status').on('click',function(){
    if($("ul #status1").is(":visible")){
        alert("visible");
    $('#status1').css("display", "none");
    }
    else
    {
        alert("hidden");
        $('#status1').css("display", "block");
    }
});
// $( "ul" ).click(function( event ) {
//   var target = $( event.target );
//   if ( target.is( "li" ) ) {
//     target.css( "background-color", "red" );
//   }
// });
</script>

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
        $("#uploaded-image1").css("display", "none");
        $("#uploaded-image").attr("src", response).css("display", "block");
        $("#picture").val(response);
    });
    $("#pictur").val("");
    $('#uploadimageModal').modal('hide');
});

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
$('#pictur1').on('change', function() {
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
        // $("#uploaded-image1").css("display", "none");
        $("#uploaded-image1").attr("src", response).css("display", "block");
        $("#picture1").val(response);
    });
    $("#pictur1").val("");
    $('#uploadimageModal1').modal('hide');
});

$(document).ready(function(){
    
       $('.newproduct').click(function(e){
           e.preventDefault();
           $('#product_creator_wrapper').fadeIn('slow');
       });
       
       $(".pc_close").click(function(){
           $("#product_creator_wrapper").fadeOut("slow");
       })
       $('.editproduct').click(function(e){
           e.preventDefault();
           var id=$(this).data('id');
           var url="{{admin_url('products/getdetails')}}/"+id;
           $.ajax({
                url:url,
                type:"GET",
                dataType:"json",
                success:function(data)
                {
                    $.each(data,function(key,value)
                    {
                        var weight=(value.weight/{{$weight->value}}).toFixed(2);
                        $('#name').val(value.name);
                        $('#id').val(value.id);
                        $('#sku').val(value.sku);
                        $('#category_id').val(value.category_id);
                        $('#unittype').val(value.unittype);
                        $('#unit').val(value.unit);
                        $('#weight').val(weight);
                        $('#price').val(value.price);
                        $('#price_by').val(value.price_by);
                        $('#description').val(value.description);
                        $('#stock').val(value.qty);
                        var img="{{asset('images/products')}}/"+value.picture;
                        $("#uploaded-image1").attr("src", img).css("display", "block");
                        
                    });
                }
           });
           $('#product_creator_wrapper1').fadeIn('slow');
       });
       
       $(".pcedit_close").click(function(){
           $("#product_creator_wrapper1").fadeOut("slow");
       })
       
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
                    $(".pc_wrapper").fadeIn('slow');
                    $('.loading-info').fadeOut('slow');
                    $("#product_creator_wrapper").fadeOut("slow");
                    console.log(data);
                    location.reload();
                    
                },
                fail:function(error) {
                    console.log(error)
                }
            });
       });
       
       $("#edit-product").submit(function(e){
            e.preventDefault();
            var id=$('#id').val();
            var datastring = $("#edit-product").serialize();
            $(".pc_wrapper1").fadeOut('slow');
            $('.loading-info1').css({opacity: 0, display: 'flex'}).animate({opacity: 1}, 1000);
            $.ajax({
                type: "PUT",
                url: "/admin/products/"+id,
                data: datastring,
                success: function(data) {
                    $(".pc_wrapper1").fadeIn('slow');
                    $('.loading-info1').fadeOut('slow');
                    $("#product_creator_wrapper1").fadeOut("slow");
                    console.log(data);
                    location.reload();
                    
                },
                fail:function(error) {
                    console.log(error)
                }
            });
       });
       
   })
</script>
@endsection