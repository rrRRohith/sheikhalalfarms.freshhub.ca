@extends('layouts.admin')
@section('title',$submenu .'Customers')
@section('page_title','Customers')
@section('page_nav')
<ul>
  <li @if($submenu=="All") class="active" @else class=""  @endif><a  href="{{url('admin/customers')}}">All Customers</a></li>
  <li @if($submenu=="Active") class="active" @else class="" @endif><a  href="{{url('admin/customers/getcust/1')}}">Active Customers</a></li>
  <li @if($submenu=="Inactive") class="active" @else class="" @endif ><a   href="{{url('admin/customers/getcust/0')}}">Inactive Customers</a></li>
  <li @if($submenu=="Customertype") class="active" @else class=""  @endif><a  href="{{url('admin/customertype')}}">Customer Types</a> </li>
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
                  <!--      <div class="card-title-header-titr"><b> -->
                  <!--       @if(isset($status)) @if($status==1) Active Customers  @else Inactive  Customers @endif @else All Customers @endif -->
                  <!--      </b></div>-->
                  <!--      <div class="card-title-header-between"></div>-->
                  <!--      <div class="card-title-header-actions">-->
                  <!--         <a href="#"><img src="{{asset('img/help.svg')}}" alt="help"-->
                  <!--            class="card-title-header-img card-title-header-details"></a>-->
                  <!--      </div>-->
                  <!--   </div>-->
                  <!--</div>-->
                  
                  
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
                                    <table class="table table-list mt-0">
                                       <thead class="table-list-header-options">
                                          <tr>
                                             <td colspan="5">
                                                 <form action="" method="get">
                                                     @csrf
                                                   
                                                 <div class="row">
                                                      
                                                     <div class="col-sm-3">

                                                         Search By City: <input type="text" name="city" id="city"  value="{{Request()->city}}" placeholder="City Name">
                                                      
                                                     </div>
                                                   
                                                     <div class="col-sm-3">
                                                        Search By Type: <select name="customer_type" id="type" class="form-control">
                                                             <option value="">Select Type</option>
                                                             @foreach($customertypes as $customertype)
                                                             <option value="{{$customertype->id}}" @if(isset(Request()->customer_type) && (Request()->customer_type==$customertype->id)) selected @endif >{{$customertype->name}}</option>
                                                             @endforeach
                                                             </select>
                                                      </div>
                                                        <div class="col-sm-3">
                                                        Select By Customers: <select name="status"  class="form-control">
                                                             <option value="2" @if(isset(Request()->status) && (Request()->status==2)) selected @endif>All Customers</option>
                                                             <option value="1" @if(isset(Request()->status) && (Request()->status==1)) selected @endif>Active</option>
                                                             <option value="0" @if(isset(Request()->status) && (Request()->status==0)) selected @endif>Inactive</option>
                                                             </select>
                                                      </div>
                                                       <div class="col-sm-3">
                                                            <button  class="btn btn-success" type="submit">Filter</button>
                                                        </div>
                                                 </div>
                                                 </form>
                                             </td>
                                             @can('Customer View')
                                             <td colspan="5">
                                                <a href="{{admin_url('customers/create')}}"
                                                   class="btn btn-success pull-right">
                                                   <clr-icon shape="plus-circle"></clr-icon>
                                                   New Customer                            
                                                </a>
                                             </td>
                                             @endcan
                                          </tr>
                                       </thead>
                                       <thead>
                                          <tr>
                                             <th class="text-left">
                                                 ID
                                                <!--<div class="checkbox">-->
                                                <!--   <input type="checkbox" id="checkrads" class="chk-select-all">-->
                                                <!--   <label for="checkrads"></label>-->
                                                <!--</div>-->
                                             </th>
                                             <th class="text-left">
                                                Name
                                             </th>
                                             <th class="text-left">
                                                Email
                                             </th>
                                             <th class="text-left">
                                                Customer Type
                                             </th>
                                             <th class="text-left">                                                                           
                                                Address
                                             </th>
                                             <th class="text-left">                                                               
                                                City
                                             </th>
                                             <!--<th class="text-left">                                                               -->
                                             <!--   Country-->
                                             <!--</th>-->
                                             <!--<th class="text-left">                -->
                                             <!--   Phone-->
                                             <!--</th>-->
                                             <th class="text-left">                
                                                Due Amount
                                             </th>
                                             <th class="text-left">                
                                                Status
                                             </th>
                                             <th class="text-left">                
                                                Created On
                                             </th>
                                             <th class="text-right">Actions</th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                       @if(isset($customer) && count($customer)>0)
                                          @foreach($customer as $c)
                                          <tr>
                                            
                                                <!--<div class="checkbox">-->
                                                <!--   <input type="checkbox" id="checkrads_2"-->
                                                <!--      value="2">-->
                                                <!--   <label for="checkrads_2"></label>-->
                                                <!--</div>-->
                                                <td data-label="" class="text-left"> {{$c->id}}
                                                
                                             </td>
                                             <td class="text-lg-left  text-md-left"data-label="Organization"><label class=""><a target='' href="{{admin_url('customers')}}/{{$c->id}}">{{$c->firstname}} {{$c->lastname}}</a></label></td>
                                             <td data-label="Email" class="text-left"><label class="">{{$c->email}}</label></td>
                                            
                                            
                                             <td data-label="Customer type" class="text-left">
                                                 <label class="">
                                                 @foreach($customertypes as $customertype)
                                                   @if($c->customer_type==$customertype->id)
                                                      {{$customertype->name}}
                                                   @endif
                                                 @endforeach
                                                 </label>
                                             </td>
                                             
                                             <td data-label="City" class="text-left"><label class="">{{$c->address}}</label></td>
                                             <td data-label="Account Province" class="text-left"><label class="">{{$c->city}}</label></td>
                                             <!--<td data-label="Account Province" class="text-left"><label class="">{{$c->country}}</label></td>-->
                                             <!--<td data-label="Phone" class="text-left">-->
                                             <!--   <phone phone-range="{{$c->phone}}" type-num="phone"></phone>-->
                                             <!--</td>-->
                                             <td>{{$c->debit-$c->credit}}</td>
                                           
                                             <!--<td data-label="Phone" class="text-left">@if($c->status==0)Inactive @else Active @endif </td>-->
                                            <!--<td>-->
                                            <!--       @if($c->status==0)-->
                                            <!--       <a target="" href="{{admin_url('customers/changestatus')}}/{{$c->id}}/1"   data-tooltip="Activate" rel="tooltip">-->
                                            <!--         <button>Active</button>-->
                                            <!--       </a>-->
                                            <!--       @else-->
                                            <!--       <a target="" href="{{admin_url('customers/changestatus')}}/{{$c->id}}/0"   data-tooltip=" Deactivate" rel="tooltip">-->
                                            <!--         <button>Inactive</button>-->
                                            <!--       </a>-->
                                            <!--       @endif-->
                                            <!--  </td>  -->
                                                <td>
                                                    
                                                     <div class="col-lg-3 col-md-3 col-sm-12">
                                                        <label class="switch">
                                                        <input type="checkbox" <?php if(isset($c)){ if($c->status==1){ ?> checked <?php } } ?>
                                                         onchange="changeStatus('{{$c->id}}');"
                                                        name="status">
                                                        <span class="slider round" style="height:31px;"></span>
                                                        </label>
                                                     </div>
                                                </td>
                                             
                                             <td data-label="Created on" class="text-left">{{date('d M Y ',strtotime($c->created_at))}} </td>
                                             
                                             
                                             <td class="text-right">
                                                <!--<label>-->
                                                <!--   @if($c->status==0)-->
                                                <!--   <a target="" href="{{admin_url('customers/changestatus')}}/{{$c->id}}/1" class="icon-table"  data-tooltip="Activate" rel="tooltip">-->
                                                <!--      <clr-icon shape="check" size="22"></clr-icon>-->
                                                <!--   </a>-->
                                                <!--   @else-->
                                                <!--   <a target="" href="{{admin_url('customers/changestatus')}}/{{$c->id}}/0" class="icon-table"  data-tooltip=" Deactivate" rel="tooltip">-->
                                                <!--      <clr-icon shape="times" size="22"></clr-icon>-->
                                                <!--   </a>-->
                                                <!--   @endif-->
                                                <!--</label>-->
                                                @can('Customer Edit')
                                                <label>
                                                   <a target="" href="{{admin_url('customers')}}/{{$c->id}}/edit" class="icon-table" rel="tooltip" data-tooltip=" Edit">
                                                      <clr-icon shape="pencil" size="22"></clr-icon>
                                                   </a>
                                                </label>
                                                @endcan
                                                @can('Customer Delete')
                                                <label>
                                                  
                                                   <a target="" href="{{admin_url('customers')}}/{{$c->id}}/del" class="icon-table" rel="tooltip" data-tooltip=" Delete">
                                                      <clr-icon shape="trash" size="22"></clr-icon>
                                                   </a>
                                                </label>
                                                @endcan
                                             </td>
                                          </tr>
                                          @endforeach
                                       @else
                                        <tr>
                                             <td>
                                                <h3>Sorry No Customers Availiable</h3>
                                             </td>
                                        </tr>
                                       @endif
                                       </tbody>
                                       <tfoot>
                                          <tr>
                                             <th colspan="5">
                                                <nav class="pull-left number" aria-label="Page navigation">
                                                </nav>
                                             </th>
                                             <th colspan="5"
                                                class="text-lg-right text-md-right number">
                                                Show {{count($customer)}} case from {{count($customer)}}
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
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
@section('bottom-scripts')
<script>
function changeStatus(id) {
    if (id) {
        $.ajax({
            
            url: "/admin/customers/changestatus/" + id + "/status",
            type: 'get',
            data: {},
            success: function(data) {
                console.log(data.status);
            }
        });
    }
}


    // $('#type').on('change',function(){
    //     var type=$(this).val();
    //     window.location.href = "<?php echo url('admin/customers');?>/"+type;
    // });

</script>
@endsection