
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
                                                    <input type="text" name="search" id="table-search"  value="{{Request()->search}}" placeholder="Search by product id, sku, name and description">
                                                </div>
                                                <div class="col-sm-4 col-lg-3">
                                                    <label class="control-label">Filter By Category:</label>
                                                    <select name="category" id="category" class="form-control">
                                                        <option value="">Select Category</option>
                                                        @foreach($category as $categor)
                                                        <option value="{{$categor->id}}" @if(isset(Request()->category) && (Request()->category==$categor->id)) selected @endif>{{$categor->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-sm-4 col-lg-3">
                                                    <label class="control-label">Filter By Status:</label>
                                                    <select name="status" id="status"  class="form-control">
                                                        <option value="">All</option>
                                                        <option value="1" @if(isset(Request()->status) && (Request()->status==1)) selected @endif>Active</option>
                                                        <option value="0" @if(isset(Request()->status) && (Request()->status==0)) selected @endif>Inactive</option>
                                                    </select>
                                                </div>
                                                
                                            </div>
                                        </form>
                                    <div class="table-list-responsive-md">
                                        <table class="table table-customer mt-0">
                                            <thead>
                                                <tr>
                                                    <th class="text-left"><a class="sort" href="#id" data-sort="id" data-direction="desc">
                                                        ID <i class="ml-2 fa fa-sort"></i></a>
                                                    </th>
                                                    <th class="text-center">
                                                        Image 
                                                    </th>
                                                    <th class="text-left"><a class="sort" href="#name" data-sort="name" data-direction="asc">
                                                        Name <i class="ml-2 fa fa-sort"></i></a>
                                                    </th>
                                                    <th class="text-left">
                                                        Category
                                                    </th>
                                                    <th class="text-left"><a class="sort" href="#weight" data-sort="weight" data-direction="asc">
                                                        Weight <i class="ml-2 fa fa-sort"></i></a>
                                                    </th>
                                                    <th class="text-left"><a class="sort" href="#price" data-sort="price" data-direction="asc">
                                                        Price <i class="ml-2 fa fa-sort"></i></a>
                                                    </th>
                                                    <th class="text-left"><a class="sort" href="#status" data-sort="status" data-direction="asc">
                                                        Status <i class="ml-2 fa fa-sort"></i></a>
                                                    </th>
                                                    <th class="text-left"><a class="sort" href="#created_at" data-sort="created_at" data-direction="asc">
                                                        Created On <i class="ml-2 fa fa-sort"></i></a>
                                                    </th>
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
                     <!--</section>-->
                    </section>
                    <div class="p-0 col-lg-4 mr-auto paginate d-flex" data-sort="" data-direction=""></div>
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
                                <input type="text" class="form-control" name="stock" id="stock" value="0"/>
                            </div>
                        </div>
    
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Customer price</label>
                                <div class="form-control" style="height:100px;overflow-y:scroll;" id="customer_price" >
                                    <table>
                                        @foreach($customers as $custr)
                                        <tr>
                                            <td>{{$custr->business_name}} {{$custr->business_name != '' ? $custr->firstname.' '.$custr->lastname:' ('.$custr->firstname.' '.$custr->lastname.')'}} </td>
                                            <td>&nbsp;</td>
                                            <td><input type="number" name="customer[{{$custr->id}}]" value="" style="width:80px;" /></td>
                                        </tr>
                                        @endforeach
                                    </table>
                            
                                </div>
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
        
    $('#status1').css("display", "none");
    }
    else
    {
       
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
       $('body').delegate('.editproduct','click',function(e){
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
                        console.log(key + '/' + value);
                        
                        var weight=(value.weight/{{$weight->value}}).toFixed(2);
                        var rate =(value.price*{{$weight->value}}).toFixed(2);
                        $('#name').val(value.name);
                        $('#id').val(value.id);
                        $('#sku').val(value.sku);
                        $('#category_id').val(value.category_id);
                        $('#unittype').val(value.unittype);
                        $('#unit').val(value.unit);
                        $('#weight').val(weight);
                        $('#price').val(rate);
                        $('#price_by').val(value.price_by);
                        $('#description').val(value.description);
                        $('#stock').val(value.qty);
                        if(value.picture !='')
                        var img="{{asset('images/products')}}/"+value.picture;
                        else
                        var img="";
                        $("#uploaded-image1").attr("src", img).css("display", "block");
                        
                    });

                    var url = "{{admin_url('products/getprices')}}/"+id;

                    $.ajax({
                        url:url,
                        type:"GET",
                        dataType:"json",
                        success:function(data)
                        {
                            
                            var returncode = '';

                            $.each(data,function(key,value)
                            {
                                returncode = returncode + `<tr><td>`+value.business_name+` - `+ value.firstname + ` ` + value.lastname + `</td>
                                            <td>&nbsp;</td>
                                            <td><input type="number" name="customer[` + value.customer_id + `]" value="`+ value.custom_price +`" style="width:80px;" /></td></tr>`;
                            });

                            console.log($("#customer_price").html());

                            returncode = '<table>'+returncode+'</table>';
                            $("#customer_price").html(returncode);
                        },
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
            console.log(datastring)
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
<script>
let searchKey    = $('input#table-search');
let searchCategory   = $('select#category');
let searchStatus = $('select#status');
let sortDiv = $('div.paginate');
let deferUrl = `{{ admin_url('products/defer')}}`;
$(document).ready(function() {

  $.getJSON(`${deferUrl}`,  function(response) {
    renderTable(response);
  });
  $('#table-search').on('keyup', function(){
    loadingRow();
    tableSearch();
  });
  $('#category').on('change', function(){
    loadingRow();
    tableSearch();
  });
  $('#status').on('change', function(){
    loadingRow();
    tableSearch();
  });
  function tableSearch()
  {
      $.getJSON(`${deferUrl}?key=${searchKey.val()}&type=${searchCategory.val()}&status=${searchStatus.val()}`, function(response) {
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
              <img src= "{{asset('images/products/${row.picture}')}}" style="width:50px;height:50px;"/>
            </td>
            <td class="text-lg-left  text-md-left"data-label="Organization">
              <label class="">${row.name}</label>
            </td>
            <td class="text-lg-left  text-md-left"data-label="Organization">
              <label class="">${row.category}</label>
            </td>
            <td class="text-lg-left  text-md-left"data-label="Organization">
              <label class="">${row.weight}</label>
            </td>
            <td class="text-lg-left  text-md-left"data-label="Organization">
              <label class="">${row.price}</label>
            </td>
            <td class="text-lg-left  text-md-left"data-label="Organization">
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" ${row.status == '1' ? 'checked' : ''}                                                   onchange="changeStatus('${row.id}');"                                                    name="status">
                <label class="form-check-label" for="flexSwitchCheckChecked"></label>
              </div> 
            </td>
            <td class="text-lg-left  text-md-left"data-label="Organization">
              <label class="">${createdAt}</label>
            </td>
            <td class="text-right" >
              <div class="fh_actions pull-right">
                <a href="#" class="fh_link">Actions <i class="fa fa-caret-down"></i> </a>
                  <ul class="fh_dropdown">
                    @can('Edit Product')
                      <a class="editproduct" data-id="${row.id}"><li><i class="fa fa-edit"></i> Edit</li></a>
                    @endcan
                    @can('Delete Product')
                      <a href="/admin/products/${row.id}/del" onClick="return confirm('Are you sure you want to delete this product?');"><li><i class="fa fa-trash"></i> Delete</li></a>
                    @endcan
                  </ul>
              </div>
            </td>
          </tr>`;
          
  });
  $('tbody.append-row').html(table ? table : `<tr><td colspan="7" class="text-center">No data found</td><tr>`);
  $('.paginate').html(response.links);
}
</script>
@endsection