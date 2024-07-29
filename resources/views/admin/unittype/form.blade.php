@extends('layouts.admin')
@section('title',isset($unittype) ? 'Edit Unit Type' :'Add Unit Type')
@section('page_title','Unit Type')
@section('page_nav')
<ul>
  
    <li><a href="{{url('admin/configuration')}}">Settings</a> </li>
    <li><a href="{{url('admin/roles')}}">Roles & Permissions</a> </li>
    <!--<li><a href="{{url('admin/emails')}}">Emails</a> </li>-->
    <li  class="active"><a href="{{url('admin/unittype')}}">Unit Type</a> </li>
    <li ><a href="{{url('admin/weight')}}">Weight</a></li>
</ul>  
@endsection
@section('contents')
<div class="content-container">
   <div class="content-area">
      <div class="row  main_content">
         <div class="col-md-12">
            <div class="card">
               <div class="card-block">
                  <div class="card-title">
                      <a href="/admin/unittype" class="pull-right white_button"><i class="fa fa-arrow-left"></i> All Types</a>
                    <h3>@isset($unittype) Edit Unit Type @else New Unit Type @endisset</h3>
                  </div>
                  <section class="card-text">
                      
                    <div class="row">
                        <div class="col-md-4 offset-md-4 " id="addAccountForm">
                            <form class="pt-0" id="form" method="post" class="fh_form" 
                               action="@if(isset($unittype)){{admin_url('unittype/'.$unittype->id)}} @else {{admin_url('unittype')}} @endif">
                               @if(isset($unittype))
                               @method('PUT')
                               @endif
                               @csrf
                               <div class="box">
                               <input type="hidden" id="id" name="id" value="@if(isset($unittype)) {{$unittype->id}} @endif">
                               <section class="form-block">
                                 
                                  <div class="form-group">

                                        <label class="control-label" for="name">Name</label>
                                        <input class="form-control number" id="name"
                                           value="{{old('name',isset($unittype)?$unittype->name:'')}}"
                                           name="name">
                                        @if ($errors->has('name'))
                                        <span class="form-error">{{$errors->first('name')}}</span>
                                        @endif
                                  </div>
                                  <div class="form-group">

                                        <label class="control-label" for="name">Code</label>
                                        <input class="form-control number" id="code"
                                           value="{{old('code',isset($unittype)?$unittype->shortcode:'')}}"
                                           name="code">
                                        @if ($errors->has('code'))
                                        <span class="form-error">{{$errors->first('code')}}</span>
                                        @endif
                                  </div>
                                  <div class="form-group">

                                        <label class="control-label" for="name">Status</label>
                                        <div class="form-check form-switch">
                                                  <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" <?php if(isset($unittype)) { if($unittype->status==1){ ?> checked <?php }} ?>
                                                    name="status">
                                                  <label class="form-check-label" for="flexSwitchCheckChecked"></label>
                                                </div> </td>
                                        @if ($errors->has('status'))
                                        <span class="form-error">{{$errors->first('status')}}</span>
                                        @endif
                                  </div>
                                  <div class="form-group">
                                      <button type="submit" class="green_button">
                                           <i class="fa fa-check"></i> Save                        
                                        </button>
                                  </div>
    
                               </section>
                              </div>
                            </form>
                         </div>
                    </div>
                    
                    
                  </section>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection