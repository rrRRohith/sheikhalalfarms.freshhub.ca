@extends('layouts.admin')
@section('title','Unit Types')
@section('page_title','Configuration')
@section('page_nav')
<ul>
    <li><a href="{{url('admin/configuration')}}">Settings</a> </li>
    <li><a href="{{url('admin/roles')}}">Roles & Permissions</a> </li>
    <!--<li><a href="{{url('admin/emails')}}">Emails</a> </li>-->
    <li  class="active"><a href="{{url('admin/unittype')}}">Unit Type</a> </li>
    <li ><a href="{{url('admin/weight')}}">Weight</a></li>
  
</ul>
@endsection
@section('contents')
<div class="content-container">
   <div class="content-area">
      <div class="row main_content">
         <div class="col-md-12">
            <div class="card no-margin minH">
               <div class="card-block">
                   <div class="card-title">
                       <a href="{{admin_url('unittype/create')}}"  class="pull-right green_button">
                                                   <i class="fa fa-new"></i> New Unit Type </a>
                    <h3>Unit types</h3>
                  </div>
                   <section class="card-text customers_outer">
                     <div class="row filter-customer">
                           <div class="col-lg-12">
                              <div class="filter-customer-list">
                                 @if (Session::has('message'))
                                 <div class="alert alert-success">
                                    {{ Session::get('message') }}
                                 </div>
                                 @endif
                                 <!--<form action="" method="get" id="filter_form">-->
                                 <!--           @csrf-->
                                 <!--           <div class="row">-->
                                 <!--               <div class="col-sm-5">-->
                                 <!--                   <label class="control-label">Search by name or code</label> -->
                                 <!--                   <input type="text" name="search" id="search"  value="{{Request()->search}}" placeholder="Search by name or code">-->
                                 <!--               </div>-->
                                 <!--               <div class="col-sm-5">-->
                                 <!--                   <label class="control-label">Sort by Name</label> -->
                                 <!--                   <select class="form-control" name="sort"  id="sort">-->
                                                        <!--<option value="">All</option>-->
                                 <!--                       <option value="0" @if(Request()->sort == '0') selected @endif>Ascending</option>-->
                                 <!--                       <option value="1" @if(Request()->sort == '1') selected @endif>Descending</option>-->
                                 <!--                   </select>-->
                                 <!--               </div>-->
                                                
                                                
                                 <!--               <div class="col-sm-2">-->
                                                    
                                 <!--                   <button  class="white_button" type="submit">Search</button>-->
                                 <!--               </div>-->
                                 <!--           </div>-->
                                 <!--       </form>-->
                                 <div class="table-list-responsive-md">
                                     
                                    <table class="table table-customer mt-0" id="table">
                                       
                                       <thead>
                                          <tr>
                                             <th>
                                              ID
                                             </th>
                                             <th class="text-left">
                                                Name
                                             </th>
                                             <th class="text-left">
                                                Code
                                             </th>
                                             <th class="text-left">
                                                Status
                                             </th>
                                           <th class="text-right">Actions</th>
                                          </tr>
                                       </thead>
                                       @if(isset($unittypes) && count($unittypes)>0)
                                       <tbody>
                                         @php $i=1; @endphp
                                          @foreach($unittypes as $t)
                                          <tr  >
                                             <td width="5">
                                               {{$i}}
                                             </td>
                                             <td class="text-lg-left  text-md-left"data-label="Organization"><label class="">{{$t->name}}</label></td>
                                             <td class="text-lg-left  text-md-left"data-label="Organization"><label class="">{{$t->shortcode}}</label></td>
                                             <td class="text-lg-left  text-md-left"data-label="Organization">
                                                 <div class="form-check form-switch">
                                                  <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" <?php if($t->status==1){ ?> checked <?php } ?>
                                                     onchange="changeStatus('{{$t->id}}');"
                                                    name="status">
                                                  <label class="form-check-label" for="flexSwitchCheckChecked"></label>
                                                </div> </td>
                                             <td class="text-right" >
                                                <div class="fh_actions pull-right">
                                                    <a href="#" class="fh_link">Actions <i class="fa fa-caret-down"></i> </a>
                                                    <ul class="fh_dropdown">
                                                        @can('Customer Edit')
                                                        <a href="{{admin_url('unittype')}}/{{$t->id}}/edit"><li><i class="fa fa-edit"></i> Edit</li></a>
                                                        @endcan
                                                        @can('Customer Delete')
                                                        <a href="{{admin_url('unittype')}}/{{$t->id}}/del"><li><i class="fa fa-trash"></i> Delete</li></a>
                                                        @endcan
                                                    </ul>
                                                </div>
                                             </td>
                                          </tr>
                                          @php $i++; @endphp
                                          @endforeach
                                       
                                       </tbody>
                                    @else
                                        <tbody></tbody><tr><th colspan="5"><div class="empty_message text-center">Sorry no unit type exists</div></th></tr></tbody>
                                    @endif
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
<!--<script src="//code.jquery.com/jquery-1.12.3.js"></script>-->
<script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script
    src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
<link rel="stylesheet"
    href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<link rel="stylesheet"
    href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
    <script>
  $(document).ready(function() {
    $('#table').DataTable();
} );
 </script>
<script>
function changeStatus(id) {
    if (id) {
        $.ajax({
            url: "/admin/unittype/changestatus/" + id ,
            type: 'get',
            data: {},
            success: function(data) {
                console.log(data.status);
            }
        });
    }
}
</script>
<script>
 $("#sort").on('change', function(){
   var 
 });
 $("#search").on('keyup', function(){
   alert("Works");
 })
  
</script>
@endsection