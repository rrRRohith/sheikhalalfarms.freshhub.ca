@extends('layouts.admin')
@section('title',isset($inventory) ? 'Edit Inventory' :'Add Inventory')
@section('contents')
<div class="content-container">
   <div class="content-area">
      <div class="row">
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-xs-padding">
            <div class="card no-margin minH">
               <div class="card-block">
                  <div class="card-title">
                     <div class="card-title-header">
                        <div class="card-title-header-titr"><b>@if(isset($inventory)) Edit @else Add @endif Inventory </b></div>
                        <div class="card-title-header-between"></div>
                        <div class="card-title-header-actions">
                           <a href="{{admin_url('inventories')}}"
                              class="btn btn-success-outline-x btn-icon card-title-header-details" rel="tooltip"
                              data-tooltip="Back">
                              <clr-icon shape="undo" class="is-solid"></clr-icon>
                           </a>
                           <a href="#"><img src="http://test.freshhub.ca/img/help.svg" alt="help"
                              class="card-title-header-img card-title-header-details"></a>
                        </div>
                     </div>
                  </div>
                  <section class="card-text">
                     <div class="px-lg-3 " id="addAccountForm">
                        <form class="pt-0" id="form" method="post"
                           action="@if(isset($inventory)){{admin_url('inventories/'.$inventory->id)}}@else{{admin_url('inventories')}}@endif">
                           @if(isset($inventory))
                           @method('PUT')
                           @endif
                           @csrf
                           <section class="form-block">
                              <div class="separator">
                                 <label class="separator-text separator-text-success">Inventory Details</label>
                              </div>
                              <div class="form-group row">
                                 <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12 text-right no-md-padding">
                                    <label class="text-gray-dark"
                                       for="opportunity_source_id"> Product Name</label>
                                 </div>
                                 <div class="col-lg-5 col-md-5 col-sm-12">
                                    <select name="product_id" id="product_id" class="form-control">
                                       <option value="">Select the product</option>
                                       @foreach($product as $p)
                                       <option value="{{$p->id}}" <?php if(isset($inventory)){if(($inventory->product_id)==($p->id)){?> selected <?php }}?> >{{$p->name}}</option>
                                       @endforeach
                                    </select>
                                    @if ($errors->has('product_id'))
                                    <strong>{{ $errors->first('product_id') }}</strong>
                                    @endif
                                 </div>
                                 <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12 text-right no-md-padding">
                                    <label class="text-gray-dark"
                                       for="opportunity_source_id"> Warehouse</label>
                                 </div>
                                 <div class="col-lg-5 col-md-5 col-sm-12">
                                    <select name="warehouse_id" id="warehouse_id" class="form-control">
                                       <option value="">Select Warehouse</option>
                                       @foreach($warehouses as $p)
                                       <option value="{{$p->id}}" <?php if(isset($inventory)){if(($inventory->warehouse_id)==($p->id)){?> selected <?php }}?> >{{$p->name}}</option>
                                       @endforeach
                                    </select>
                                    @if ($errors->has('warehouse_id'))
                                    <strong>{{ $errors->first('warehouse_id') }}</strong>
                                    @endif
                                 </div>
                              </div>
                              <div class="form-group row">
                                 <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12 text-right no-md-padding">
                                    <label class="text-gray-dark"
                                       for="account_name">Stock Quantity</label>
                                 </div>
                                 <div class="col-lg-5 col-md-3 col-sm-12">
                                    <input class="form-control" id="stock_qty"
                                       value="{{old('stock_qty',isset($inventory)?$inventory->stock_qty:'')}}"
                                       name="stock_qty">
                                    @if ($errors->has('stock_qty'))
                                    <strong>{{ $errors->first('stock_qty') }}</strong>
                                    @endif
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