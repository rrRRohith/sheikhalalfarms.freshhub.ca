@extends('layouts.admin')
@section('title','Products')
@section('page_title','Products')
@section('page_nav')
<ul>
    <li ><a href="{{admin_url('products')}}">Products</a></li>
    <li class="active"><a href="{{admin_url('categories')}}">Categories</a></li>  
</ul>
@endsection
@section('contents')
<div class="content-container">
   <div class="content-area">
      <div class="row">
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-xs-padding">
            <div class="card no-margin minH">
               <div class="card-block">
                  <div class="card-title">
                     <div class="card-title-header">
                        <div class="card-title-header-titr"><b>@isset($category) Modify @else Create @endif Category </b></div>
                        <div class="card-title-header-between"></div>
                        <div class="card-title-header-actions">
                           <a href="{{admin_url('categories')}}"
                              class="btn btn-success-outline-x btn-icon card-title-header-details" rel="tooltip"
                              data-tooltip="Back">
                              <clr-icon shape="undo" class="is-solid"></clr-icon>
                           </a>
                           <a href="#"><img src="{{url('img/help.svg')}}" alt="help"
                              class="card-title-header-img card-title-header-details"></a>
                        </div>
                     </div>
                  </div>
                  <section class="card-text">
                     <div class="px-lg-3 " id="addAccountForm">
                        <form class="pt-0" id="form" method="post" action="@if(isset($category)){{admin_url('categories/'.$category->id)}}@else{{admin_url('categories')}}@endif" enctype="multipart/form-data">
                           @if(isset($category))
                           @method('PUT')
                           @endif
                           @csrf
                           <section class="form-block">
                              <div class="separator">
                                 <label class="separator-text separator-text-success">Category Details</label>
                              </div>
                              <div class="form-group row">
                                 <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12 text-right no-md-padding">
                                    <label class="text-gray-dark"
                                       for="opportunity_source_id"> Category Name</label>
                                 </div>
                                 <div class="col-lg-5 col-md-5 col-sm-12">
                                    <input class="form-control number" id="name"
                                       value="{{old('name',isset($category)?$category->name:'')}}"
                                       name="name">
                                       <input type="hidden" name="id" value="{{isset($category) ? $category->id:null}}" />
                                    @if ($errors->has('name'))
                                    <span class="form-error">{{ $errors->first('name') }}</span>
                                    @endif
                                 </div>
                                
                              </div>
                              <div class="form-group row">
                                 <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12 text-right no-md-padding">
                                    <label class="text-gray-dark"
                                       for="account_province">Parent Category</label>
                                 </div>
                                 <div class="col-lg-5 col-md-5 col-sm-12">
                                    <select name="parent_id" id="parent_id" class="form-control">
                                       <option value=""> - Select -</option>
                                       @foreach($categories as $cat)
                                       <option value="{{$cat->id}}" <?php if(isset($category)){if(($category->parent_id)==($cat->id)){?> selected <?php }}?> >{{$cat->name}}</option>
                                       @endforeach
                                    </select>
                                    @if ($errors->has('category_id'))
                                    <span class="form-error">{{ $errors->first('category_id') }}</span>
                                    @endif 
                                 </div>
                                 
                                 
                              </div>
                              <div class="form-group row">
                                 <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12 text-right no-md-padding">
                                    <label class="text-gray-dark" for="opportunity_source_id">Description</label>
                                 </div>
                                 <div class="col-lg-5 col-md-5 col-sm-12">
                                    <textarea class="form-control number" id="description" name="description" >{{old('name',isset($category)?$category->description:'')}}</textarea>
                                    @if ($errors->has('description'))
                                    <span class="form-error">{{ $errors->first('description') }}</span>
                                    @endif
                                 </div>
                              </div>
                              
                              <div class="form-group row">
                                 <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12 text-right no-md-padding">
                                    <label class="text-gray-dark" for="opportunity_source_id">&nbsp;</label>
                                 </div>
                                 <div class="col-lg-5 col-md-5 col-sm-12">
                                    <label><input type="checkbox" name="status" @if(isset($category) && $category->status) checked="checked" @endif /> Publish</label>
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