@extends('layouts.admin')
@section('title', 'Customer Type')
@section('page_title','Customers')
@section('page_nav')
<ul>
  <li><a  href="{{url('admin/customers')}}">All Customers</a></li>
  <li><a  href="{{url('admin/customers/getcust/1')}}">Active Customers</a></li>
  <li><a  href="{{url('admin/customers/getcust/0')}}">Inactive Customers</a></li>
  <li class="active"><a  href="{{url('admin/customertype')}}">Customer Types</a> </li>
</ul>  
@endsection
@section('contents')
<div class="content-container">
   <div class="content-area">
      <div class="row">
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-xs-padding">
            <div class="card no-margin minH">
               <div class="card-block">
                 
                  <section class="card-text">
                     <section class="card-text">
                        <div class="row filter-customer">
                           <div class="col-lg-12">
                              <div class="filter-customer-list">
                                 @if (Session::has('message'))
                                 <div class="alert alert-success">
                                    <font color="red" size="4px">{{ Session::get('message') }}</font>
                                 </div>
                                 @endif
                                 <div class="table-list-responsive-md">
                                    <table class="table table-list mt-0">
                                       <thead class="table-list-header-options">
                                          <tr>
                                             <td>
                                               
                                             </td>
                                             
                                             <td colspan="2">
                                                <a href="{{admin_url('customertype/create')}}"
                                                   class="btn btn-success pull-right">
                                                   <clr-icon shape="plus-circle"></clr-icon>
                                                   New Customer Type                           
                                                </a>
                                             </td>
                                             
                                          </tr>
                                       </thead>
                                       <thead>
                                          <tr>
                                             <th>
                                                <div class="checkbox">
                                                   <input type="checkbox" id="checkrads" class="chk-select-all">
                                                   <label for="checkrads"></label>
                                                </div>
                                             </th>
                                             <th class="text-left">
                                                Name
                                             </th>
                                             
                                             
                                             <th class="text-right">Actions</th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                       @if(isset($customertypes) && count($customertypes)>0)
                                          @foreach($customertypes as $t)
                                          <tr  >
                                             <td>
                                                <div class="checkbox">
                                                   <input type="checkbox" id="checkrads_2"
                                                      value="2">
                                                   <label for="checkrads_2"></label>
                                                </div>
                                             </td>
                                             <td class="text-lg-left  text-md-left"data-label="Organization"><label class=""><a target='' href="{{admin_url('customers')}}/{{$t->id}}">{{$t->name}}</a></label></td>

                                             
                                             <td class="text-right">
                                             
                                                @can('Customer Edit')
                                                <label>
                                                   <a target="" href="{{admin_url('customertype')}}/{{$t->id}}/edit" class="icon-table" rel="tooltip" data-tooltip=" Edit">
                                                      <clr-icon shape="pencil" size="22"></clr-icon>
                                                   </a>
                                                </label>
                                                @endcan
                                                @can('Customer Delete')
                                                <label>
                                                   <a target="" href="{{admin_url('customertype')}}/{{$t->id}}/del" class="icon-table" rel="tooltip" data-tooltip=" Delete">
                                                      <clr-icon shape="trash" size="22"></clr-icon>
                                                   </a>
                                                </label>
                                                @endcan
                                             </td>
                                          </tr>
                                          @endforeach
                                       @else
                                        <tr>
                                             <td colspan="3">
                                                <h3>Sorry No Customer Types Availiable</h3>
                                             </td>
                                        </tr>
                                       @endif
                                       </tbody>
                                       <tfoot>
                                          <tr>
                                             <th colspan="1">
                                                <nav class="pull-left number" aria-label="Page navigation">
                                                </nav>
                                             </th>
                                             <th colspan="2"
                                                class="text-lg-right text-md-right number">
                                                Show {{count($customertypes)}} case from {{count($customertypes)}}
                                                Customer                        
                                             </th>
                                          </tr>
                                       </tfoot>
                                    </table>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </section>
                  </section>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection