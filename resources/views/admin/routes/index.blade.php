@extends('layouts.admin')
@section('title','Routes')
@section('page_title','Routes')
@section('page_nav')

<ul>
  <li></li>
  
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
                                        <h3>All Routes</h3>
                                    </div>
                                    <a href="{{admin_url('routes/create')}}" class="btn btn-success pull-right main_button green_button">
                                        <clr-icon shape="plus-circle"></clr-icon> 
                                            New Route                           
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
                                             <th>City</th>
                                             <th class="text-left">
                                                Places
                                             </th>
                                             <th class="text-left">Created On</th>
                                             <th class="text-right">
                                                Action
                                             </th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                           @if(isset($routes) && count($routes)>0)
                                           @php $i=1;@endphp
                                          @foreach($routes as $r)
                                          <tr>
                                              <td class="text-left">{{$i}}</td>
                                             <td class="text-left"><label class="">{{$r->name}}</label></td>
                                             <td>{{$r->city}}</td>
                                            <td class="text=left">{{$r->places}}</td>
                                             
                                             <td data-label="Created on" class="text-left">{{date('d M Y ',strtotime($r->created_at))}} </td>
                                            
                                             <td class="text-right">
                                                
                                                      <div class="fh_actions">
                                                            <a href="#" class="fh_link">Actions <i class="fa fa-caret-down"></i> </a>
                                                            <ul class="fh_dropdown">
                                                                <a href="{{admin_url('routes/'.$r->id.'/edit')}}"><li><i class="fa fa-edit" aria-hidden="true"></i> Edit</li></a>
                                                                <a href="{{admin_url('routes/'.$r->id.'/del')}}"><li><i class="fa fa-trash" aria-hidden="true"></i> Delete</li></a>
                                                            </ul>
                                                    </div>
                                                
                                              
                                                
                                             </td>
                                          </tr>
                                          @php $i++; @endphp
                                          @endforeach
                                          @else
                                          <tr>
                                              <th colspan="6"><center>No Routes found</center></th>
                                          </tr>
                                          @endif
                                       </tbody>
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