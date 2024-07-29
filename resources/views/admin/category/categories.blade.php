@extends('layouts.admin')
@section('title','Categories')
@section('page_title','Categories')
@section('page_nav')


    
<ul>
    <li ><a href="{{admin_url('products')}}">Products</a></li>
    <li class="active"><a href="{{admin_url('categories')}}">Categories</a></li>  
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
                                        <h3>All Categories</h3>
                                    </div>
                                    <a href="{{admin_url('categories/create')}}" class="btn btn-success pull-right main_button green_button">
                                        <clr-icon shape="plus-circle"></clr-icon> 
                                            New Category                            
                                        </a>
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
                                     <div class="newcategory_button">
                                        @can('Category Create')
                                    
                                        @endcan
                                        </div>
                                    <table class="table table-customer mt-0">
                                       
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
                                                  
                                                     <div class="form-check form-switch">
                                                      <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" <?php if(isset($w)){ if($w->status==1){ ?> checked <?php } } ?>
                                                         onchange="changeStatus('{{$w->id}}');"
                                                        name="status">
                                                      <label class="form-check-label" for="flexSwitchCheckChecked"></label>
                                                    </div>
                                                     
                                            </td>
                                             
                                             <td data-label="Created on" class="text-left">{{date('d M Y ',strtotime($w->created_at))}} </td>
                                            
                                             <td class="text-right">
                                                <!--<label>-->
                                                <!--   <a target="" href="{{admin_url('categories/'.$w->id.'/edit')}}" class="icon-table" rel="tooltip" data-tooltip=" Edit">-->
                                                <!--      <clr-icon shape="pencil" size="22"></clr-icon>-->
                                                <!--   </a>-->
                                                <!--</label>-->
                                                <!--<label>-->
                                                <!--   <a target="" href="{{admin_url('categories/'.$w->id.'/del')}}" class="icon-table" rel="tooltip" data-tooltip=" Delete">-->
                                                <!--      <clr-icon shape="trash" size="22"></clr-icon>-->
                                                <!--   </a>-->
                                                <!--</label>-->
                                                      <div class="fh_actions">
                                                            <a href="#" class="fh_link">Actions <i class="fa fa-caret-down"></i> </a>
                                                            <ul class="fh_dropdown">
                                                                <a href="{{admin_url('categories/'.$w->id.'/edit')}}"><li><i class="fa fa-edit" aria-hidden="true"></i> Edit</li></a>
                                                                <a href="{{admin_url('categories/'.$w->id.'/del')}}" onClick="return confirm('Are you sure you want to delete this category?');"><li><i class="fa fa-trash" aria-hidden="true"></i> Delete</li></a>
                                                            </ul>
                                                    </div>
                                                
                                              
                                                
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
                <div class="text-bold" style="padding:10px;"> {{$categories->links()}}Showing Page {{$categories->currentPage()}} of {{$categories->lastPage()}} </div>
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
                alert(data);
                console.log(data);
                location.reload();
            }
        });
    }
}
</script>
@endsection