@extends('layouts.admin')
@section('page_title','Configuration')
@section('page_nav')
<ul>
    <li><a href="{{url('admin/configuration')}}">Settings</a> </li>
    <li class="active"><a href="{{url('admin/roles')}}">Roles & Permissions</a> </li>
    <!--<li><a href="{{url('admin/emails')}}">Emails</a> </li>-->
    <li><a href="{{url('admin/unittype')}}">Unit Type</a> </li>
    <li><a href="{{url('admin/weight')}}">Weight</a></li>
</ul>
@endsection
@section('contents')
<div class="content-container">
   <div class="content-area">
      <div class="row main_content">
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 addenew_form">
            <div class="card no-margin minH">
               <div class="card-block">
                     <div class="headercnt_top">
                            <div class="innerpage_title">
                                        <h3>Role Details</h3>
                                    </div>
                        <div class="clearfix"></div>
                    </div> 
                  
                  <section class="card-text">
                     <div id="addAccountForm">
                        <form class="pt-0" id="form" method="post" action="{{ isset($role) ? admin_url('roles/'.$role->id):admin_url('roles')}}">
                           @if(isset($role))
                              @method('PUT')
                           @endif
                           @csrf
                           <section class="form-block">
                        
                              <div class="rolename_text">
                                
                                    <label class="text-gray-dark"
                                       for="opportunity_source_id"> Role Name</label>
                                              <input class="form-control number" id="name"
                                       value="{{old('name',isset($role) ? $role->name:'')}}"
                                       name="name">
                                    @if ($errors->has('name'))
                                    <span class="form-error">{{ $errors->first('name') }}</span>
                                    @endif
                                 
                              </div>
                              <div class="form-group row">
                                 <label class="text-gray-dark"
                                       for="opportunity_source_id"> Roles</label>
                                       
                                 @foreach($permissions as $permission)
                                    <div class="col-md-3 adminroles"> 
                                       <label class="control-label label-checkbox">
                                          <input type="checkbox" name="permissions[]" value="{{$permission->id}}" @if(isset($role) && $role->hasPermissionTo($permission->name)) checked="checked" @endif  /> {{$permission->name}}</label>
                                    </div>
                                 @endforeach
                              </div>
                              
                           </section>
                           <section>
                              <div class="form-group row">
                                 <div class="col-lg-3 col-sm-4 col-xs-6">
                                    <input type="hidden" name="id" value="{{old('id',isset($role) ? $role->id:'')}}" />
                                    <button type="submit"
                                       class="btn btn-success btn-block green_button">
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