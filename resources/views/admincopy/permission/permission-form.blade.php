@extends('layouts.admin')
@section('contents')
<div class="content-container">
   <div class="content-area">
      <div class="row">
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-xs-padding">
            <div class="card no-margin minH">
               <div class="card-block">
                  <div class="card-title">
                     <div class="card-title-header">
                        <div class="card-title-header-titr"><b>{{ isset($permission) ? 'Modify':'Create' }} Permissions </b></div>
                        <div class="card-title-header-between"></div>
                        <div class="card-title-header-actions">
                           <a href="{{url('admin/productss')}}"
                              class="btn btn-success-outline-x btn-icon card-title-header-details" rel="tooltip"
                              data-tooltip="Back">
                              <clr-icon shape="undo" class="is-solid"></clr-icon>
                           </a>
                           <a href="#"><img src="http://admin.freshhub.ca/img/help.svg" alt="help"
                              class="card-title-header-img card-title-header-details"></a>
                        </div>
                     </div>
                  </div>
                  <section class="card-text">
                     <div class="px-lg-3 " id="addAccountForm">
                        <form class="pt-0" id="form" method="post" action="{{ isset($permission) ? admin_url('permissions/'.$permission->id):admin_url('permissions')}}">
                           @if(isset($permission))
                              @method('PUT')
                           @endif
                           @csrf
                           <section class="form-block">
                              <div class="separator">
                                 <label class="separator-text separator-text-success">Permission Details</label>
                              </div>
                              <div class="form-group row">
                                 <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12 text-right no-md-padding">
                                    <label class="text-gray-dark"
                                       for="opportunity_source_id"> Permission Name</label>
                                 </div>
                                 <div class="col-lg-5 col-md-5 col-sm-12">
                                    <input class="form-control number" id="name"
                                       value="{{old('name',isset($permission) ? $permission->name:'')}}"
                                       name="name">
                                    @if ($errors->has('name'))
                                    <span class="form-error">{{ $errors->first('name') }}</span>
                                    @endif
                                 </div>
                                 
                              </div>
                              
                           </section>
                           <section>
                              <div class="form-group row">
                                 <div class="offset-lg-1 col-lg-3 col-sm-4 col-xs-6">
                                    <input type="hidden" name="id" value="{{old('id',isset($permission) ? $permission->id:'')}}" />
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