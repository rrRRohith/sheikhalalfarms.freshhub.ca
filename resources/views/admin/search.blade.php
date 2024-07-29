@extends('layouts.admin')
@section('title','Search Results')
@section('page_title','Search Results')
@section('page_nav')
<ul>
    <li class="active"></li>
    <!--<li><a href="{{admin_url('profile')}}">Profile</a></li>  -->
    <!--<li><a href="{{admin_url('changepassword')}}">Change Password</a></li>-->
</ul>
@endsection
@section('contents')
<div class="content-container">
   <div class="content-area">
      <div class="row">
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card no-margin minH">
               <div class="card-block">
                  <div class="card-title">
                     <div class="card-title-header">
                        <h3>Search Results</h3>
                       
                        
                     </div>
                  </div>
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
                                 <h4 class="searchresult_title">Customers</h4>
                                 <div class="table-list-responsive-md">
                                    <table class="table mt-0 search_table">
                                       
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
                                             <!--<th class="text-right">Actions</th>-->
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
                                                <div class="form-check form-switch">
                                                               <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" <?php if(isset($c)){ if($c->status==1){ ?> checked <?php } } ?> onchange="changeStatus('{{$c->id}}');" name="status">
                                                               <label class="form-check-label" for="flexSwitchCheckChecked"></label>
                                                            </div>
                                                
                                              </td>
                                             <td data-label="Created on" class="text-left">{{date('d M Y ',strtotime($c->created_at))}} </td>
                                             <!--<td class="text-right">-->
                                             <!--   @can('Customer Edit')-->
                                             <!--   <label>-->
                                             <!--      <a target="" href="{{admin_url('customers')}}/{{$c->id}}/edit" class="icon-table" rel="tooltip" data-tooltip=" Edit">-->
                                             <!--         <clr-icon shape="pencil" size="22"></clr-icon>-->
                                             <!--      </a>-->
                                             <!--   </label>-->
                                             <!--   @endcan-->
                                             <!--   @can('Customer Delete')-->
                                             <!--   <label>-->
                                             <!--      <a target="" href="{{admin_url('customers')}}/{{$c->id}}/del" class="icon-table" rel="tooltip" data-tooltip=" Delete">-->
                                             <!--         <clr-icon shape="trash" size="22"></clr-icon>-->
                                             <!--      </a>-->
                                             <!--   </label>-->
                                             <!--   @endcan-->
                                             <!--</td>-->
                                          </tr>
                                          @endforeach
                                       </tbody>
                                    </table>
                                 </div>
                                 @endif
                                 @if(isset($products) && count($products)>0)
                                 <h4 class="searchresult_title">Products</h4>
                                 <div class="table-list-responsive-md">
                                    <table class="table mt-0 search_table">
                                       
                                       <thead>
                                          <tr><th class="text-left">ID</th>
                                             <th></th>
                                             <th class="text-left">Name</th>
                                             <th class="text-left">Category</th>
                                             <th class="text-left"> Weight</th>
                                             <th class="text-left">Price</th>
                                             <th class="text-left">Status </th>
                                             <th class="text-left">Created On </th>
                                             <!--<th class="text-right">Actions</th>-->
                                          </tr>
                                       </thead>
                                       <tbody>
                                          @foreach($products as $w)
                                          <tr>
                                              <td class="text-left">{{$w->id}}</td>
                                             <td>
                                                <img src= "{!!$w->picture !='' ? asset('images/products/'.$w->picture) : asset('images/products/dummy.jpg') !!}"  style="width:50px;height:50px;"/>
                                             </td>
                                             <td  class="text-left" data-label="Organization"><label>{{$w->name}}</label></td>
                                             <td class="text-left" data-label="Organization"><label>{{$w->category['name']}}</label></td>
                                             <td class="text-left" data-label="Organization"><label>{{$w->weight}}</label></td>
                                             <td class="text-left" data-label="Organization" class="text-right"><label class="">{{$w->price}}</label></td>
                                             <td>
                                                 <div class="form-check form-switch">
                                                               <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" <?php if(isset($w)){ if($w->status==1){ ?> checked <?php } } ?> onchange="changeStatus('{{$w->id}}');" name="status">
                                                               <label class="form-check-label" for="flexSwitchCheckChecked"></label>
                                                            </div>
                                            </td>
                                             <td data-label="Created on" class="text-left">{{date('d M Y',strtotime($w->created_at))}} </td>
                                             <!--<td class="text-right">-->
                                             <!--   @can('Edit Product')<label>-->
                                             <!--      <a target="" href="products/{{$w->id}}/edit" class="icon-table" rel="tooltip" data-tooltip=" Edit">-->
                                             <!--         <clr-icon shape="pencil" size="22"></clr-icon>-->
                                             <!--      </a>-->
                                             <!--   </label>@endcan-->
                                             <!--   @can('Delete Product')<label>-->
                                             <!--      <a target="" href="products/{{$w->id}}/del" class="icon-table" rel="tooltip" data-tooltip=" Delete">-->
                                             <!--         <clr-icon shape="trash" size="22"></clr-icon>-->
                                             <!--      </a>-->
                                             <!--   </label>@endcan-->
                                             <!--</td>-->
                                          </tr>
                                          @endforeach
                                       </tbody>
                                    </table>
                                 </div>
                                 @endif
                                  @if(isset($categories) && count($categories)>0)
                                  <h4 class="searchresult_title">Categories</h4>
                                  <div class="table-list-responsive-md">
                                    <table class="table mt-0 search_table">
                                       
                                       <thead>
                                          <tr>
                                             <th class="text-left">ID</th>
                                             <th class="text-left">Name</th>
                                             <th>Parent</th>
                                             <th class="text-left">Status</th>
                                             <th class="text-left">Created On</th>
                                             <!--<th class="text-right"> Action</th>-->
                                          </tr>
                                       </thead>
                                       <tbody>
                                          @foreach($categories as $w)
                                          <tr>
                                             <td class="text-left">{{$w->id}}</td>
                                             <td class="text-left"><label class="">{{$w->name}}</label></td>
                                             <td>-</td>
                                             <td class="text=left">
                                                 <div class="form-check form-switch">
                                                               <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" <?php if(isset($w)){ if($w->status==1){ ?> checked <?php } } ?> onchange="changeStatus('{{$w->id}}');" name="status">
                                                               <label class="form-check-label" for="flexSwitchCheckChecked"></label>
                                                            </div>
                                              </td>
                                             <td data-label="Created on" class="text-left">{{date('d M Y ',strtotime($w->created_at))}} </td>
                                             <!--<td class="text-right">-->
                                             <!--   <label>-->
                                             <!--      <a target="" href="{{admin_url('categories/'.$w->id.'/edit')}}" class="icon-table" rel="tooltip" data-tooltip=" Edit">-->
                                             <!--         <clr-icon shape="pencil" size="22"></clr-icon>-->
                                             <!--      </a>-->
                                             <!--   </label>-->
                                             <!--   <label>-->
                                             <!--      <a target="" href="{{admin_url('categories/'.$w->id.'/del')}}" class="icon-table" rel="tooltip" data-tooltip=" Delete">-->
                                             <!--         <clr-icon shape="trash" size="22"></clr-icon>-->
                                             <!--      </a>-->
                                             <!--   </label>-->
                                             <!--</td>-->
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
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection