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
<div class="content-container">
   <div class="content-area">
      <div class="row">
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-xs-padding">
            <div class="card no-margin minH">
               <div class="card-block">
                  <!--<div class="card-title">-->
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
                  <!--   </div>-->
                  </div>
                  <section class="card-text">
                     <div class="px-lg-3 " id="addAccountForm">
                        <form class="pt-0" id="form" method="post" action="@if(isset($product)){{admin_url('products/'.$product->id)}}@else{{admin_url('products')}}@endif" enctype="multipart/form-data">
                           @if(isset($product))
                           @method('PUT')
                           @endif
                           @csrf
                           <section class="form-block">
                              <div class="separator">
                                 <label class="separator-text separator-text-success">Product Details</label>
                              </div>
                              <div class="row">
                                  <div class="col-sm-9">
                                      <div class="form-group row">
                                         <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12 text-right no-md-padding">
                                            <label class="text-gray-dark"
                                               for="opportunity_source_id"> Product Name</label>
                                         </div>
                                         <div class="col-lg-5 col-md-5 col-sm-12">
                                            <input class="form-control number" id="name"
                                               value="{{old('name',isset($product)?$product->name:'')}}"
                                               name="name">
                                            @if ($errors->has('name'))
                                            <span class="form-error">{{ $errors->first('name') }}</span>
                                            @endif
                                         </div>
                                         <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12 text-right no-md-padding">
                                            <label class="text-gray-dark"
                                               for="opportunity_source_id"> Description</label>
                                         </div>
                                         <div class="col-lg-5 col-md-5 col-sm-12">
                                             <textarea rows="5" name="description" id="description" class="form-control">{{old('name',isset($product)?$product->description:'')}}</textarea>
                                            
                                            @if ($errors->has('description'))
                                            <span class="form-error">{{ $errors->first('description') }}</span>
                                            @endif
                                         </div>
                                      </div>
                                      <div class="form-group row">
                                          <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12 text-right no-md-padding">
                                            <label class="text-gray-dark"
                                               for="company_brand">SKU</label>
                                         </div>
                                         <div class="col-lg-5 col-md-3 col-sm-12">
                                            <input class="form-control" id="sku"
                                               value="{{old('sku',isset($product)?$product->sku:'')}}"
                                               name="sku">
                                            @if ($errors->has('sku'))
                                            <span class="form-error">{{ $errors->first('sku') }}</span>
                                            @endif
                                         </div>
                                         <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12 text-right no-md-padding">
                                            <label class="text-gray-dark"
                                               for="account_province">Category</label>
                                         </div>
                                         <div class="col-lg-5 col-md-5 col-sm-12">
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
                                          <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12 text-right no-md-padding">
                                            <label class="text-gray-dark"
                                               for="company_brand">Unit</label>
                                         </div>
                                         <div class="col-lg-5 col-md-3 col-sm-12">
                                            <select name="unit" id="unit" class="form-control">
                                                <option value="">Select Unit</option>
                                               @foreach($units as $u)
                                               <option value="{{$u->id}}" <?php if(isset($product)){if(($product->unit)==($u->id)){?> selected <?php }}?> >{{$u->name}} - {{$u->shortcode}}</option>
                                               @endforeach
                                            </select>
                                            @if ($errors->has('unit'))
                                            <span class="form-error">{{ $errors->first('unit') }}</span>
                                            @endif
                                         </div>
                                         <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12 text-right no-md-padding">
                                            <label class="text-gray-dark"
                                               for="account_province">Unit Type</label>
                                         </div>
                                         <div class="col-lg-5 col-md-5 col-sm-12">
                                            
                                            <input class="form-control" id="unittype"
                                               value="{{old('unittype',isset($product)?$product->unittype:'')}}"
                                               name="unittype">
                                            @if ($errors->has('unittype'))
                                            <span class="form-error">{{ $errors->first('unittype') }}</span>
                                            @endif 
                                         </div>
                                         
                                      </div>
                                      <div class="form-group row">
                                          <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12 text-right no-md-padding">
                                            <label class="text-gray-dark"
                                               for="company_brand">Weight</label>
                                         </div>
                                         <div class="col-lg-5 col-md-3 col-sm-12">
                                            <input class="form-control" id="weight"
                                               value="{{old('weight',isset($product)?$product->weight:'')}}"
                                               name="weight">
                                            @if ($errors->has('weight'))
                                            <span class="form-error">{{ $errors->first('weight') }}</span>
                                            @endif
                                         </div>
                                         <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12 text-right no-md-padding">
                                            <label class="text-gray-dark"
                                               for="account_address">Price</label>
                                         </div>
                                         <div class="col-lg-5 col-md-7 col-sm-12">
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
                                  </div>
                                  <div class="col-sm-3">
                                    
                                    <div class="row">
                                        @if(isset($product) && $product->picture !='')
                                        <div class="col-sm-12">
                                         <center><img src="{{asset('/media/products/'.$product->picture)}} " style="width:50%;height:auto;"></center>
                                        </div>
                                        @endif
                                        <br>
                                        <input type="file" class="form-control" id="picture" name="picture">
                                    </div>
                                    
                                    
                                  </div>
                              </div>
                              
                           </section>
                           <section>
                              <div class="form-group row">
                                 <div class="offset-lg-1 col-lg-3 col-sm-4 col-xs-6">
                                    <button type="submit"
                                       class="btn btn-success btn-block">
                                       <clr-icon
                                          shape="floppy"></clr-icon>
                                       Save                        
                                    </button>
                                 </div>
                              </div>
                           </section>
                        </form>
                     </div>
                  </section>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection