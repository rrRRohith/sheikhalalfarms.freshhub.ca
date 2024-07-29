@extends('layouts.admin')
@section('title','Products')
@section('page_title','Products')
@section('page_nav')
<ul>
    <li ><a href="{{admin_url('products')}}">Products</a></li>
    <li class="active"><a href="{{admin_url('categories')}}">Categories</a></li>  
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
                                   {{ Session::get('message') }}
                                 </div>
                                 @endif
                                 <div class="table-list-responsive-md">
                                    <table class="table table-list mt-0">
                                       <thead class="table-list-header-options">
                                          <tr>
                                             <td colspan="4">

                                                @can('Create Category')
                                                <a href="{{admin_url('categories/create')}}"
                                                   class="btn btn-success pull-right">
                                                   <clr-icon shape="plus-circle"></clr-icon>
                                                   New Category                            
                                                </a>
                                                @endcan
                                               
                                                
                                             </td>
                                          </tr>
                                       </thead>
                                       <thead>
                                          <tr>
                                             <th class="text-left">ID</th>
                                             <th class="text-left">
                                                Name
                                             </th>
                                             <th>Parent</th>
                                             <th class="text-left">
                                                Status
                                             </th>
                                             <th class="text-left">Created On</th>
                                             <th class="text-right">
                                                Action
                                             </th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                           @if(isset($categories) && count($categories)>0)
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
                                          @else
                                          <tr>
                                              <th>No Categories found</th>
                                          </tr>
                                          @endif
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
            
            url: "/admin/categories/changestatus/" + id ,
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