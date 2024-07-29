@extends('layouts.admin')
@section('title',isset($product)? 'Edit Product' : 'Add Product')
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
         <div class="col-md-12">
            <div class="card no-margin minH">
               <div class="card-block">
                  <!--<!--<div class="card-title">-->
                  <!--   <div class="card-title-header">-->
                  <!--      <div class="card-title-header-titr"><b>@if(isset($product)) Edit @else Add @endif Product </b></div>-->
                  <!--      <div class="card-title-header-between"></div>-->
                  <!--      <div class="card-title-header-actions">-->
                  <!--         <a href="{{admin_url('products')}}"-->
                  <!--            class="btn btn-success-outline-x btn-icon card-title-header-details" rel="tooltip"-->
                  <!--            data-tooltip="Back">-->
                  <!--            <clr-icon shape="undo" class="is-solid"></clr-icon>-->
                  <!--         </a>-->
                  <!--         <a href="#"><img src="http://test.freshhub.ca/img/help.svg" alt="help"-->
                  <!--            class="card-title-header-img card-title-header-details"></a>-->
                  <!--      </div>-->
                  <!--   </div>
                  </div>-->
                  <div class="card-title">
                      <a href="/admin/products" class="pull-right white_button"><i class="fa fa-arrow-left"></i> All Products</a>
                    <h3>@isset($product) Edit Product @else New Product @endisset</h3>
                  </div>
                  <section class="card-text">
                     <div class="px-lg-3 " id="addAccountForm">
                        <form class="pt-0" id="form" method="post" action="@if(isset($product)){{admin_url('products/'.$product->id)}}@else{{admin_url('products')}}@endif" enctype="multipart/form-data">
                           @if(isset($product))
                           @method('PUT')
                           @endif
                           @csrf
                           <section class="form-block">
                              
                              <div class="row">
                                 
                                  <div class="col-sm-9">
                                      <div class="form-group row">
                                         <div class="col-md-6">
                                            <label class="text-gray-dark"
                                               for="opportunity_source_id"> Product Name</label>
                                            <input class="form-control number" id="name"
                                               value="{{old('name',isset($product)?$product->name:'')}}"
                                               name="name">
                                            @if ($errors->has('name'))
                                            <span class="form-error">{{ $errors->first('name') }}</span>
                                            @endif
                                         </div>
                                        
                                         <div class="col-md-3">
                                            <label class="text-gray-dark"
                                               for="company_brand">SKU</label>
                                             <input class="form-control" id="sku"
                                               value="{{old('sku',isset($product)?$product->sku:'')}}"
                                               name="sku">
                                            @if ($errors->has('sku'))
                                            <span class="form-error">{{ $errors->first('sku') }}</span>
                                            @endif
                                         </div>

                                         <div class="col-md-3">
                                            <label class="text-gray-dark"
                                               for="account_province">Category</label>
                                            <select name="category_id" id="category_id" class="form-control">
                                               @foreach($category as $p)
                                               <option value="{{$p->id}}" <?php if(isset($product)){if(($product->category_id)==($p->id)){?> selected <?php }}?> >{{$p->name}}</option>
                                               @endforeach
                                            </select>
                                            @if ($errors->has('category_id'))
                                            <span class="form-error">{{ $errors->first('category_id') }}</span>
                                            @endif 
                                         </div>
                                        
             
                                      </div>

                                      <div class="form-group row">
                                          <div class="col-md-3">
                                            <label class="text-gray-dark"
                                               for="company_brand">Unit Type</label>
                                            <select name="unittype" id="unit" class="form-control">
                                                <option value="">Select Unit Type</option>
                                               @foreach($units as $u)
                                               <option value="{{$u->id}}" <?php if(isset($product)){if(($product->unittype)==($u->id)){?> selected <?php }}?> >{{$u->name}} - {{$u->shortcode}}</option>
                                               @endforeach
                                            </select>
                                            @if ($errors->has('unittype'))
                                            <span class="form-error">{{ $errors->first('unittype') }}</span>
                                            @endif
                                         </div>

                                         <div class="col-md-3">
                                            <label class="text-gray-dark"
                                               for="account_province">Unit</label>
                                              <input class="form-control" id="unit"
                                               value="{{old('unit',isset($product)?$product->unit:'')}}"
                                               name="unit" type="number">
                                            @if ($errors->has('unit'))
                                            <span class="form-error">{{ $errors->first('unit') }}</span>
                                            @endif 
                                         </div>
   

                                          <div class="col-md-3">
                                            <label class="text-gray-dark"
                                               for="company_brand">Weight</label>
                                            <input class="form-control" id="weight"
                                               value="{{old('weight',isset($product)?(round(($product->weight/$weight->value),2)):'')}}"
                                               name="weight">
                                            @if ($errors->has('weight'))
                                            <span class="form-error">{{ $errors->first('weight') }}</span>
                                            @endif
                                         </div>

                                         <div class="col-md-3">
                                            <label class="text-gray-dark"
                                               for="account_address">Price</label>
                                            <input class="form-control" id="price"
                                               value="{{old('price',isset($product)?$product->price:'')}}"
                                               name="price">
                                            @if ($errors->has('price'))
                                            <span class="form-error">{{ $errors->first('price') }}</span>
                                            @endif
                                         </div>
                  
                                         <!--<div class="col-lg-1 col-md-1 col-sm-12 col-xs-12 text-right no-md-padding">-->
                                         <!--   <label class="text-gray-dark"-->
                                         <!--      for="opportunity_source_id"> Picture</label>-->
                                         <!--</div>-->
                                         
                                         <!--<div class="col-lg-3 col-md-3 col-sm-12">-->
                                         <!--    @if(isset($product) && $product->picture !='')-->
                                         <!--<span><center><img src="{{asset('/media/products/'.$product->picture)}}" style="width:50px;height:50px;" ></center></span><br>-->
                                         <!--@endif-->
                                         <!--   <input type="file" class="form-control" id="picture" name="picture">-->
                                         <!--</div>-->
                                      </div>
                                      <div class="form-group row">
                                         <div class="col-md-12">
                                            <label class="text-gray-dark"
                                               for="opportunity_source_id"> Description</label>
                                            <textarea rows="3" name="description" id="description" class="form-control">{{old('name',isset($product)?$product->description:'')}}</textarea>
                                            
                                            @if ($errors->has('description'))
                                            <span class="form-error">{{ $errors->first('description') }}</span>
                                            @endif
                                         </div>
                                        </div>
                                  </div>
                                   <div class="col-sm-3" >
                             
                                    
                                       <img id="uploaded-image"
                                                src="{{old('picture',isset($product) && $product->picture != '' ? asset('images/products/'.$product->picture):asset('images/users/dummy-image.jpg'))}}" style="display:block;width:150px;height:auto;">
                                        <label class="text-gray-dark" for="opportunity_source_id">Image</label>
                                       <br><input type="file" accept="image/*" id="pictur">
                                        <input type="hidden" name="picture" id="picture" />
                                
     
                               </div>
                                <div class="col-sm-12">
                                    <button type="submit"
                                       class="green_button">
                                       <i class="fa fa-check"></i> 
                                       Save                        
                                    </button>
                                 </div>
            
                              </div>
                              
                           </section>
                           <!--<section>-->
                           <!--   <div class="form-group row">-->
                           <!--      <div class="col-lg-3 col-sm-4 col-xs-6">-->
                           <!--         <button type="submit"-->
                           <!--            class="btn btn-success btn-block">-->
                           <!--            <clr-icon-->
                           <!--               shape="floppy"></clr-icon>-->
                           <!--            Save                        -->
                           <!--         </button>-->
                           <!--      </div>-->
                           <!--   </div>-->
                           <!--</section>-->
                        </form>
                     </div>
                 
               
            </div>
         </div>
      </div>
   </div>
</div>
		
<div class="modal" tabindex="-1" role="dialog" id="uploadimageModal">
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
                        <div id="image_demo"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary crop_image">Crop and Save</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('bottom-scripts')
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
        $("#uploaded-image").attr("src", response).css("display", "block");
        $("#picture").val(response);
    });
    $("#pictur").val("");
    $('#uploadimageModal').modal('hide');
});
</script>
@endsection