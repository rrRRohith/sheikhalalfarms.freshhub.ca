@extends('layouts.admin')
@section('title',isset($warehouse) ? 'Edit Warehouse' : 'Add Warehouse')
@section('page_title','Inventories')
@section('page_nav')
<ul>
     <li><a href="{{admin_url('inventories')}}">Inventories</a></li>  
    <li class="active"><a href="{{admin_url('warehouses')}}">Warehouses</a></li>
     <li><a href="{{url('admin/inventories/current-stock')}}">Stock</a>
   
</ul>
@endsection
@section('contents')
<div class="content-container">
   <div class="content-area">
      <div class="row main_content">
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding addenew_form">
            <div class="card no-margin minH">
               <div class="card-block">
                  
                  <section class="card-text">
                     <div class="px-lg-3 fh_form" id="addAccountForm">
                        <form class="pt-0" id="form" method="post"
                           action="@if(isset($warehouse)){{admin_url('warehouses/'.$warehouse->id)}}@else{{admin_url('warehouses')}}@endif">
                           @if(isset($warehouse))
                           @method('PUT')
                           @endif
                           @csrf
                           <section class="form-block">
                              <div class="separator">
                                 <label class="separator-text separator-text-success">Warehouse Details</label>
                              </div>
                              <div class="form-group row">
                                 <div class="col-md-3 no-md-padding">
                                    <label class="text-gray-dark"
                                       for="account_name">Name*</label>
                                    <input class="form-control" id="name"
                                       value="{{old('name',isset($warehouse)?$warehouse->name:'')}}"
                                       name="name">
                                    @if ($errors->has('name'))
                                    <span class="form-error">{{ $errors->first('name') }}</span>
                                    @endif
                                 </div>
                     
                              </div>
                              <div class="form-group row">
                                 <div class="col-md-12 no-md-padding">
                                    <label class="text-gray-dark"
                                       for="account_email">status</label>
                                        <div class="form-check form-switch">
                                     <label class="form-check-label" for="flexSwitchCheckChecked"></label>
                                      <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" 
                                      <?php if(isset($warehouse)){ if($warehouse->status==1){ ?> checked <?php } } ?> name="status">
                                    </div>
                                 </div>

                              </div>
                           </section>
                           <section>
                              <div class="form-group row">
                                 <div class="col-lg-3 col-sm-4 col-xs-6 no-padding">
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