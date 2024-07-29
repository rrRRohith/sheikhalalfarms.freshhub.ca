@extends('layouts.admin')
@section('page_title','Inventories')
@section('title','Stock')

@section('page_nav')
<ul>
    <li><a href="{{admin_url('inventories')}}">Inventories</a></li>  
    <!--<li><a href="{{admin_url('warehouses')}}">Warehouses</a></li>-->
    <li  class="active"><a href="{{url('admin/inventories/current-stock')}}">Stock</a>
   
</ul>
@endsection
@section('contents')
<div class="content-container">
    <div class="content-area">
        <div class="row main_content">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card no-margin minH">
                    <div class="card-block">
                         <div class="headercnt_top">
                            <div class="innerpage_title">
                                <h3>Stocks</h3>
                            </div>
                            <!--<a href="{{url('admin/inventories/create')}}" class="btn btn-success pull-right main_button green_button">-->
                            <!--   <clr-icon shape="plus-circle"></clr-icon>-->
                            <!--       Add Inventory                            -->
                            <!--</a>-->
                            <div class="clearfix"></div>
                        </div>
                        <section class="card-text customers_outer">
                            <div class="row filter-customer">
                                <div class="col-lg-12">
                                    <div class="filter-customer-list">
                                        @if (Session::has('message'))
                                            <div class="alert alert-success">
                                                <font color="red" size="4px">{{ Session::get('message') }}</font>
                                            </div>
                                        @endif
                             
                                        <div class="table-list-responsive-md">
                                            <table class="table table-customer mt-0">
                                                <thead class="table-list-header-options">
                                                    <tr>
                                                        <td colspan="3">
                                                            <form id="search_form" action="http://admin.freshhub.ca/accounts/search" method="get">
                                                                <div class="input-group input-group-icon input-group-table">
                                                                    <span class="input-group-prepend" id="basic-addon1">
                                                                        <clr-icon shape="search" size="20"></clr-icon>
                                                                    </span>
                                                                    <input type="search" class="form-control input-light" placeholder="Search ..." name="search_text" value="" aria-describedby="basic-addon1">
                                                                </div>
                                                            </form>
                                                        </td>
                                                        <td colspan="2">
                                                        </td>
                                                    </tr>
                                                </thead>
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">
                                                            ID
                                                        </th>
                                                        <th class="text-left">
                                                            Product
                                                        </th>
                                                        <!--<th class="text-left">-->
                                                        <!--    Warehouse-->
                                                        <!--</th>-->
                                                        <th>Unit Type</th>
                                                        <th>Weight</th>
                                                        <th class="text-left">
                                                            Current Stock
                                                        </th>
                                                    <!--<th class="text-left">Actions</th>-->
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <form action="{{admin_url('updatestock')}}" method="post"> 
                                                    @csrf
                                                        @foreach($stock as $w)
                                                            <input type="hidden" name="product_id[]" value="{{$w->product_id}}">
                                                            <tr>
                                                                <td class="text-center">
                                                                    {{$w->id}}
                                                                </td>
                                                                <td class="text-left" data-label="Organization"><label class="">{{$w->product->name}}</label></td>
                                                            <!--<td  class="text-left" data-label="Organization"><label class="">{{$w->warehouse->name}}</label></td>-->
                                                                <td class="text-left">{{$w->product->units->name ?? ''}}-{{$w->product->units->shortcode ?? ''}}</td>
                                                                <td class="text-left">{{$w->product->weight}}</td>
                                                                <td  class="text-left" data-label="Organization"><label class=""><input type="text" name="stock[]" value="{{$w->quantity}}"></label></td>
                                                            </tr>
                                                        @endforeach
                                                        <tr><td colspan="5" style="text-align:right;"><button type="submit" class="btn btn-success pull-right green_button">Update Stock</button></td></tr>
                                                    </form>
                                                </tbody>
                                           
                                       
                                    </table>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </section>
                     <div class="modal js-field-customization">
                        <div class="modal-dialog" role="dialog" aria-hidden="true">
                           <div class="modal-content">
                              <form class="" method="POST" action="http://admin.freshhub.ca/accounts/datatablearrangement">
                                 <input name="module_name" type="hidden" value="accounts">
                                 <input name="moduleID" id="moduleID" type="hidden" value="1">
                                 <input type="hidden" name="" value="">
                                 <div class="modal-header">
                                    <button aria-label="Close" class="close" type="button" onClick="cancelModal()">
                                       <clr-icon aria-hidden="true" shape="close"></clr-icon>
                                    </button>
                                    <h3 class="modal-title">Customize Columns</h3>
                                 </div>
                                 <div class="modal-body  modal-middle-y ui-sortable">
                                    <div id="" class="row ui-sortable-handle">
                                       <clr-icon shape="drag-handle" size="32"></clr-icon>
                                       <div class="col-lg-1 col-md-1 col-sm-1 col-xs-2">
                                          <div class="checkbox">
                                             <input name="account_name"
                                                checked
                                                type="checkbox"
                                                value="1"
                                                id="fields__1">
                                             <label for="fields__1"></label>
                                          </div>
                                       </div>
                                       <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                          <label>Organization</label>
                                       </div>
                                    </div>
                                    <div id="" class="row ui-sortable-handle">
                                       <clr-icon shape="drag-handle" size="32"></clr-icon>
                                       <div class="col-lg-1 col-md-1 col-sm-1 col-xs-2">
                                          <div class="checkbox">
                                             <input name="account_national_id"
                                                type="checkbox"
                                                value="1"
                                                id="fields__2">
                                             <label for="fields__2"></label>
                                          </div>
                                       </div>
                                       <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                          <label>National ID</label>
                                       </div>
                                    </div>
                                    <div id="" class="row ui-sortable-handle">
                                       <clr-icon shape="drag-handle" size="32"></clr-icon>
                                       <div class="col-lg-1 col-md-1 col-sm-1 col-xs-2">
                                          <div class="checkbox">
                                             <input name="account_email"
                                                checked
                                                type="checkbox"
                                                value="1"
                                                id="fields__3">
                                             <label for="fields__3"></label>
                                          </div>
                                       </div>
                                       <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                          <label>Email</label>
                                       </div>
                                    </div>
                                    <div id="" class="row ui-sortable-handle">
                                       <clr-icon shape="drag-handle" size="32"></clr-icon>
                                       <div class="col-lg-1 col-md-1 col-sm-1 col-xs-2">
                                          <div class="checkbox">
                                             <input name="account_website"
                                                type="checkbox"
                                                value="1"
                                                id="fields__4">
                                             <label for="fields__4"></label>
                                          </div>
                                       </div>
                                       <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                          <label>Website</label>
                                       </div>
                                    </div>
                                    <div id="" class="row ui-sortable-handle">
                                       <clr-icon shape="drag-handle" size="32"></clr-icon>
                                       <div class="col-lg-1 col-md-1 col-sm-1 col-xs-2">
                                          <div class="checkbox">
                                             <input name="account_economic_identifier"
                                                type="checkbox"
                                                value="1"
                                                id="fields__5">
                                             <label for="fields__5"></label>
                                          </div>
                                       </div>
                                       <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                          <label>Economic Identifier</label>
                                       </div>
                                    </div>
                                    <div id="" class="row ui-sortable-handle">
                                       <clr-icon shape="drag-handle" size="32"></clr-icon>
                                       <div class="col-lg-1 col-md-1 col-sm-1 col-xs-2">
                                          <div class="checkbox">
                                             <input name="account_city"
                                                checked
                                                type="checkbox"
                                                value="1"
                                                id="fields__6">
                                             <label for="fields__6"></label>
                                          </div>
                                       </div>
                                       <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                          <label>City</label>
                                       </div>
                                    </div>
                                    <div id="" class="row ui-sortable-handle">
                                       <clr-icon shape="drag-handle" size="32"></clr-icon>
                                       <div class="col-lg-1 col-md-1 col-sm-1 col-xs-2">
                                          <div class="checkbox">
                                             <input name="account_province"
                                                checked
                                                type="checkbox"
                                                value="1"
                                                id="fields__7">
                                             <label for="fields__7"></label>
                                          </div>
                                       </div>
                                       <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                          <label>Account Province</label>
                                       </div>
                                    </div>
                                    <div id="" class="row ui-sortable-handle">
                                       <clr-icon shape="drag-handle" size="32"></clr-icon>
                                       <div class="col-lg-1 col-md-1 col-sm-1 col-xs-2">
                                          <div class="checkbox">
                                             <input name="account_address"
                                                type="checkbox"
                                                value="1"
                                                id="fields__8">
                                             <label for="fields__8"></label>
                                          </div>
                                       </div>
                                       <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                          <label>Account Address</label>
                                       </div>
                                    </div>
                                    <div id="" class="row ui-sortable-handle">
                                       <clr-icon shape="drag-handle" size="32"></clr-icon>
                                       <div class="col-lg-1 col-md-1 col-sm-1 col-xs-2">
                                          <div class="checkbox">
                                             <input name="account_brand"
                                                checked
                                                type="checkbox"
                                                value="1"
                                                id="fields__9">
                                             <label for="fields__9"></label>
                                          </div>
                                       </div>
                                       <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                          <label>Brand</label>
                                       </div>
                                    </div>
                                    <div id="" class="row ui-sortable-handle">
                                       <clr-icon shape="drag-handle" size="32"></clr-icon>
                                       <div class="col-lg-1 col-md-1 col-sm-1 col-xs-2">
                                          <div class="checkbox">
                                             <input name="account_phone"
                                                checked
                                                type="checkbox"
                                                value="1"
                                                id="fields__10">
                                             <label for="fields__10"></label>
                                          </div>
                                       </div>
                                       <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                          <label>Phone</label>
                                       </div>
                                    </div>
                                    <div id="" class="row ui-sortable-handle">
                                       <clr-icon shape="drag-handle" size="32"></clr-icon>
                                       <div class="col-lg-1 col-md-1 col-sm-1 col-xs-2">
                                          <div class="checkbox">
                                             <input name="account_scope"
                                                type="checkbox"
                                                value="1"
                                                id="fields__11">
                                             <label for="fields__11"></label>
                                          </div>
                                       </div>
                                       <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                          <label>Industry</label>
                                       </div>
                                    </div>
                                    <div id="" class="row ui-sortable-handle">
                                       <clr-icon shape="drag-handle" size="32"></clr-icon>
                                       <div class="col-lg-1 col-md-1 col-sm-1 col-xs-2">
                                          <div class="checkbox">
                                             <input name="technician_id"
                                                type="checkbox"
                                                value="1"
                                                id="fields__33">
                                             <label for="fields__33"></label>
                                          </div>
                                       </div>
                                       <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                          <label>Technician</label>
                                       </div>
                                    </div>
                                    <div id="" class="row ui-sortable-handle">
                                       <clr-icon shape="drag-handle" size="32"></clr-icon>
                                       <div class="col-lg-1 col-md-1 col-sm-1 col-xs-2">
                                          <div class="checkbox">
                                             <input name="opportunity_source"
                                                type="checkbox"
                                                value="1"
                                                id="fields__35">
                                             <label for="fields__35"></label>
                                          </div>
                                       </div>
                                       <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                          <label>Source Title</label>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="modal-footer">
                                    <div class="col-lg-4 col-md-5 col-sm-12">
                                       <button class="btn btn-success btn-block" type="submit" onClick="submitModal()">
                                          <clr-icon shape="floppy"></clr-icon>
                                          Save                        
                                       </button>
                                    </div>
                                 </div>
                              </form>
                           </div>
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