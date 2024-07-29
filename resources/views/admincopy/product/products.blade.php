@extends('layouts.admin')
@section('title','Products')
@section('page_title','Products')
@section('page_nav')
<ul>
    <li class="active"><a href="{{admin_url('products')}}">Products</a></li>
    <li><a href="{{admin_url('categories')}}">Categories</a></li>  
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
                                             <td colspan="5">
                                                
                                             </td>
                                             <td colspan="5">
                                              @can('Create Product')
                                                <a href="{{admin_url('products/create')}}"
                                                   class="btn btn-success pull-right">
                                                   <clr-icon shape="plus-circle"></clr-icon>
                                                   New Product                            
                                                </a>
                                                @endcan
                                             </td>
                                          </tr>
                                       </thead>
                                       <thead>
                                          <tr>
                                             <th class="text-left">
                                                  ID
                                             </th>
                                             <th >
                                            
                                             </th>
                                             <th class="text-left">
                                                Name
                                           </th>
                                             <th class="text-left">
                                                Category
                                             </th>
                                             <th class="text-left">
                                                Weight
                                             </th>
                                             <th class="text-left">
                                                Price
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
                                          @foreach($product as $w)
                                          <tr>
                                              <td class="text-left">{{$w->id}}</td>
                                              
                                             <td>
                                                <img src= "{!!$w->picture !='' ? '/media/products/'.$w->picture : '/media/products/dummy.jpg' !!}"
                                               
                                                style="width:50px;height:50px;"/>
                                             </td>
                                             <td  class="text-left" data-label="Organization"><label>{{$w->name}}</label></td>
                                             <!--<td  data-label="Organization"><label>{{$w->description}}</label></td>-->
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
                                                <!--<label>-->
                                                <!--   @if($w->status==0)-->
                                                <!--   <a target="" href="products/changestatus/{{$w->id}}/1" data-tooltip="Activate" rel="tooltip">-->
                                                <!--      <clr-icon shape="check" size="22"></clr-icon>-->
                                                <!--   </a>-->
                                                <!--   @else-->
                                                <!--   <a target="" href="products/changestatus/{{$w->id}}/0" data-tooltip=" Deactivate" rel="tooltip">-->
                                                <!--      <clr-icon shape="times" size="22"></clr-icon>-->
                                                <!--   </a>-->
                                                <!--   @endif-->
                                                <!--</label>-->
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
@section('bottom-scripts')
<script>
function changeStatus(id) {
    if (id) {
        $.ajax({
            
            url: "/admin/products/changestatus/" + id + "/status",
            type: 'get',
            data: {},
            success: function(data) {
                console.log(data.status);
            }
        });
    }
}
</script>
@endsection