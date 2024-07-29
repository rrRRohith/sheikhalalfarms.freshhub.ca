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
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card no-margin minH">
              <div class="card-block">
               <div class="headercnt_top">
                    <div class="innerpage_title">
                        <h3>Category Details</h3>
                    </div>
                       <div class="clearfix"></div>
                   </div>
                  <section class="card-text">
                     <div id="addAccountForm" class="col-xs-12 col-sm-8 col-md-5">
                        <form class="pt-0" id="form" method="post" action="@if(isset($category)){{admin_url('categories/'.$category->id)}}@else{{admin_url('categories')}}@endif" enctype="multipart/form-data">
                           @if(isset($category))
                           @method('PUT')
                           @endif
                           @csrf
                           <section class="form-block">
                           
                              <div class="form-group row">
                              <div class="col-md-12">
                                    <label class="text-gray-dark"
                                       for="opportunity_source_id"> Category Name</label>
                                     <input class="form-control number" id="name"
                                       value="{{old('name',isset($category)?$category->name:'')}}"
                                       name="name">
                                       <input type="hidden" name="id" value="{{isset($category) ? $category->id:null}}" />
                                    @if ($errors->has('name'))
                                    <span class="form-error">{{ $errors->first('name') }}</span>
                                    @endif
                                 </div>
                              <div class="col-md-12">
                                    <label class="text-gray-dark"
                                       for="account_province">Parent Category</label>
                               
                                 
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
                                 
                                <div class="col-md-12">
                                    <label class="text-gray-dark" for="opportunity_source_id">Description</label>
                                
                                 
                                    <textarea class="form-control number" id="description" name="description" >{{old('name',isset($category)?$category->description:'')}}</textarea>
                                    @if ($errors->has('description'))
                                    <span class="form-error">{{ $errors->first('description') }}</span>
                                    @endif
                                 </div>
                             
                                 <div class="col-md-12">
                                    <label class="text-gray-dark" for="opportunity_source_id">&nbsp;</label>
                                 
                                 <div class="form-check form-switch">
                                      <label class="form-check-label" for="flexSwitchCheckChecked">Publish</label>
                                      <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" name="status" @if(isset($category) && $category->status) checked="checked" @endif>
                                     
                                 </div>
                                 </div>
                                 
                              </div>
                              
                           </section>
                           <section>
                              <div class="form-group row">
                                 <div class="col-md-12">
                                    <button type="submit"
                                       class="btn btn-success btn-block green_button">
                                       <clr-icon
                                          shape="floppy"></clr-icon>
                                       Save                        
                                    </button>
                                
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