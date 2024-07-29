@extends('layouts.customer')
@section('contents')
<div class="content-container">
   <div class="content-area">
      <div class="row">
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-xs-padding">
            <div class="card no-margin minH">
               <div class="card-block">
                  <div class="card-title">
                     <div class="card-title-header">
                        <div class="card-title-header-titr"><b> Search Results </b></div>
                        <div class="card-title-header-between"></div>
                        <div class="card-title-header-actions">
                           <a href="#"><img src="http://admin.freshhub.ca/img/help.svg" alt="help"
                              class="card-title-header-img card-title-header-details"></a>
                        </div>
                     </div>
                  </div>
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
                                 
                                 @if(isset($customers) && count($customers)>0)
                                 <div class="table-list-responsive-md">
                                    <table class="table table-list mt-0">
                                       <thead class="table-list-header-options">
                                          <tr>
                                           
                                             <td colspan="2">
                                                <!--<a href="{{admin_url('customers/create')}}"-->
                                                <!--   class="btn btn-success pull-right">-->
                                                <!--   <clr-icon shape="plus-circle"></clr-icon>-->
                                                <!--   New customers                            -->
                                                <!--</a>-->
                                                Customers
                                             </td>
                                          </tr>
                                       </thead>
                                       <thead>
                                          <tr>
                                             <th class="text-left">ID</th>
                                             <th class="text-left"> Name </th>
                                             <th class="text-left"> Email </th>
                                             <th class="text-left"> Customer Type </th>
                                             <th class="text-left"> Address </th>
                                             <th class="text-left"> City</th>
                                             <th class="text-left">  Due Amount </th>
                                             <th class="text-left"> Status</th>
                                             <th class="text-left"> Created On</th>
                                             <th class="text-right">Actions</th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                          @foreach($customers as $c)
                                          <tr>
                                            <td data-label="" class="text-left"> {{$c->id}} </td>
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
                                             <td>{{$c->debit-$c->credit}}</td>
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
                                       </tbody>
                                    </table>
                                 </div>
                                 @endif
                                 @if(isset($products) && count($products)>0)
                                 <div class="table-list-responsive-md">
                                    <table class="table table-list mt-0">
                                       <thead class="table-list-header-options">
                                          <tr>
                                             <td colspan="5"> </td>
                                             <!--<td colspan="5">-->
                                             <!-- @can('Create Product')-->
                                             <!--   <a href="{{admin_url('products/create')}}"-->
                                             <!--      class="btn btn-success pull-right">-->
                                             <!--      <clr-icon shape="plus-circle"></clr-icon>-->
                                             <!--      New Product                            -->
                                             <!--   </a>-->
                                             <!--   @endcan-->
                                             <!--</td>-->
                                          </tr>
                                       </thead>
                                       <thead>
                                          <tr><th class="text-left">ID</th>
                                             <th></th>
                                             <th class="text-left">Name</th>
                                             <th class="text-left">Category</th>
                                             <th class="text-left"> Weight</th>
                                             <th class="text-left">Price</th>
                                             <th class="text-left">Status </th>
                                             <th class="text-left">Created On </th>
                                             <th class="text-right">Actions</th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                          @foreach($products as $w)
                                          <tr>
                                              <td class="text-left">{{$w->id}}</td>
                                             <td>
                                                <img src= "{!!$w->picture !='' ? '/media/products/'.$w->picture : '/media/products/dummy.jpg' !!}"  style="width:50px;height:50px;"/>
                                             </td>
                                             <td  class="text-left" data-label="Organization"><label>{{$w->name}}</label></td>
                                             <td class="text-left" data-label="Organization"><label>{{$w->category['name']}}</label></td>
                                             <td class="text-left" data-label="Organization"><label>{{$w->weight}}</label></td>
                                             <td class="text-left" data-label="Organization" class="text-right"><label class="">{{$w->price}}</label></td>
                                             <td>
                                                 <div class="col-lg-3 col-md-3 col-sm-12">
                                                    <label class="switch">
                                                    <input type="checkbox" <?php if(isset($w)){ if($w->status==1){ ?> checked <?php } } ?>
                                                     onchange="changeStatus('{{$w->id}}');"
                                                    name="status">
                                                    <span class="slider round" style="height:31px;"></span>
                                                    </label>
                                                 </div>
                                            </td>
                                             <td data-label="Created on" class="text-left">{{date('d M Y',strtotime($w->created_at))}} </td>
                                             <td class="text-right">
                                                @can('Edit Product')<label>
                                                   <a target="" href="products/{{$w->id}}/edit" class="icon-table" rel="tooltip" data-tooltip=" Edit">
                                                      <clr-icon shape="pencil" size="22"></clr-icon>
                                                   </a>
                                                </label>@endcan
                                                @can('Delete Product')<label>
                                                   <a target="" href="products/{{$w->id}}/del" class="icon-table" rel="tooltip" data-tooltip=" Delete">
                                                      <clr-icon shape="trash" size="22"></clr-icon>
                                                   </a>
                                                </label>@endcan
                                             </td>
                                          </tr>
                                          @endforeach
                                       </tbody>
                                    </table>
                                 </div>
                                 @endif
                                  @if(isset($categories) && count($categories)>0)
                                  <div class="table-list-responsive-md">
                                    <table class="table table-list mt-0">
                                       <thead class="table-list-header-options">
                                          <tr>
                                             <td colspan="4">

                                                <!--@can('Create Category')-->
                                                <!--<a href="{{admin_url('categories/create')}}"-->
                                                <!--   class="btn btn-success pull-right">-->
                                                <!--   <clr-icon shape="plus-circle"></clr-icon>-->
                                                <!--   New Category                            -->
                                                <!--</a>-->
                                                <!--@endcan-->
                                             </td>
                                          </tr>
                                       </thead>
                                       <thead>
                                          <tr>
                                             <th class="text-left">ID</th>
                                             <th class="text-left">Name</th>
                                             <th>Parent</th>
                                             <th class="text-left">Status</th>
                                             <th class="text-left">Created On</th>
                                             <th class="text-right"> Action</th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                          @foreach($categories as $w)
                                          <tr>
                                             <td class="text-left">{{$w->id}}</td>
                                             <td class="text-left"><label class="">{{$w->name}}</label></td>
                                             <td>@if($w->parent_id > 0) {{$categories->where('id',$w->parent_id)->first()->name}} @else - @endif</td>
                                             <td class="text=left">
                                                 <div class="col-lg-3 col-md-3 col-sm-12">
                                                    <label class="switch">
                                                    <input type="checkbox" <?php if(isset($w)){ if($w->status==1){ ?> checked <?php } } ?>
                                                     onchange="changeStatus('{{$w->id}}');"
                                                    name="status">
                                                    <span class="slider round" style="height:31px;"></span>
                                                    </label>
                                                 </div>
                                              </td>
                                             <td data-label="Created on" class="text-left">{{date('d M Y ',strtotime($w->created_at))}} </td>
                                             <td class="text-right">
                                                <label>
                                                   <a target="" href="{{admin_url('categories/'.$w->id.'/edit')}}" class="icon-table" rel="tooltip" data-tooltip=" Edit">
                                                      <clr-icon shape="pencil" size="22"></clr-icon>
                                                   </a>
                                                </label>
                                                <label>
                                                   <a target="" href="{{admin_url('categories/'.$w->id.'/del')}}" class="icon-table" rel="tooltip" data-tooltip=" Delete">
                                                      <clr-icon shape="trash" size="22"></clr-icon>
                                                   </a>
                                                </label>
                                             </td>
                                          </tr>
                                          @endforeach
                                       </tbody>
                                    </table>
                                 </div>
                                  @endif
                                  @if(count($customers)==0 && count($products)==0 && count($categories)==0)
								    <h5 class="text-danger text-center font-weight-bold"><font color="red">No Results Found</font></h5>
								  @endif
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