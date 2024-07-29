@extends('layouts.admin')
@section('title','Warehouse')
@section('page_title','Inventories')
@section('page_nav')
<ul>
     <li><a href="{{admin_url('inventories')}}">Inventories</a></li>  
    <li class="active"><a href="{{admin_url('warehouses')}}">Warehouses</a></li>
     <li><a href="{{url('admin/inventories/current-stock')}}">Stock</a>
   
</ul>
@endsection
@section('contents')
<div class="content-container">
   <div class="content-area">
      <div class="row main_content">
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding">
            <div class="card no-margin minH">
               <div class="card-block">
                   <section class="card-text customers_outer">
                     <div class="row filter-customer">
                           <div class="col-lg-12">
                              <div class="filter-customer-list">
                                 @if (Session::has('message'))
                                 <div class="alert alert-success">
                                    <font color="red" size="4px">{{ Session::get('message') }}</font>
                                 </div>
                                 @endif
                                 <div class="headercnt_top">
                                    <div class="innerpage_title">
                                        <h3>Warehouses</h3>
                                    </div>
                                        <a href="{{admin_url('warehouses/create')}}"
                                                   class="btn btn-success pull-right green_button">
                                                   <clr-icon shape="plus-circle"></clr-icon>
                                                   New Warehouse                            
                                                </a>
                                                <div class="clearfix"></div>
                                 </div>
                                     
                                 <div class="table-list-responsive-md">
                                    <table class="table table-customer mt-0">
                                       <thead class="table-list-header-options">
                                          <tr>
                    
                                             <td colspan="3">
                                             </td>
                                             <td colspan="3">
                                         
                                             </td>
                                          </tr>
                                       </thead>
                                       <thead>
                                          <tr>
                                             <!--<th>-->
                                             <!--   <div class="checkbox">-->
                                             <!--      <input type="checkbox" id="checkrads" class="chk-select-all">-->
                                             <!--      <label for="checkrads"></label>-->
                                             <!--   </div>-->
                                             <!--</th>-->
                                             <th class="text-left">ID</th>
                                             <th class="text-left">
                                                Name
                                             </th>
                                             <th class="text-left">
                                                Status
                                             </th>
                                             <th class="text-left"> Created On</th>
                                             </th>
                                             <th class="text-right">Actions</th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                          @foreach($warehouse as $w)
                                          <tr  >
                                             <!--<td>-->
                                             <!--   <div class="checkbox">-->
                                             <!--      <input type="checkbox" id="checkrads_2"-->
                                             <!--         value="2">-->
                                             <!--      <label for="checkrads_2"></label>-->
                                             <!--   </div>-->
                                             <!--</td>-->
                                             <td class="text-left">{{$w->id}}</td>
                                             <td class="text-left" data-label="Organization"><label class="">{{$w->name}}</label></td>
                                             <!--<td data-label="Phone">@if($w->status==0)Inactive @else Active @endif </td>-->
                                             <td>
                                                    <div class="form-check form-switch">
                                                      <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" <?php if(isset($w)){ if($w->status==1){ ?> checked <?php } } ?>
                                                         onchange="changeStatus('{{$w->id}}');"
                                                        name="status">
                                                      <label class="form-check-label" for="flexSwitchCheckChecked"></label>
                                                    </div>
                                               </td>
                                             
                                             
                                             <td class="text-left">{{date('d M Y',strtotime($w->created_at))}}</td>
                                             
                                             <td data-label="Actions" class="text-right">
                                                <!--<label>-->
                                                <!--   @if($w->status==0)-->
                                                <!--   <a target="" href="warehouses/changestatus/{{$w->id}}/1" data-tooltip="Activate" rel="tooltip">-->
                                                <!--      <clr-icon shape="check" size="22"></clr-icon>-->
                                                <!--   </a>-->
                                                <!--   @else-->
                                                <!--   <a target="" href="warehouses/changestatus/{{$w->id}}/0" data-tooltip=" Deactivate" rel="tooltip">-->
                                                <!--      <clr-icon shape="times" size="22"></clr-icon>-->
                                                <!--   </a>-->
                                                <!--   @endif-->
                                                <!--</label>-->
                                                <!--<label>-->
                                                <!--   <a target="" href="warehouses/{{$w->id}}/edit" class="icon-table" rel="tooltip" data-tooltip=" Edit">-->
                                                <!--      <clr-icon shape="pencil" size="22"></clr-icon>-->
                                                <!--   </a>-->
                                                <!--</label>-->
                                                <!--<label>-->
                                                <!--   <a target="" href="warehouses/{{$w->id}}/del" class="icon-table" rel="tooltip" data-tooltip=" Delete">-->
                                                <!--      <clr-icon shape="trash" size="22"></clr-icon>-->
                                                <!--   </a>-->
                                                <!--</label>-->
                                                
                                                
                                                
                                                   
                                                    <div class="fh_actions">
                                                            <a href="#" class="fh_link">Actions <i class="fa fa-caret-down"></i> </a>
                                                            <ul class="fh_dropdown">
                                                                <li><a href="{{admin_url('warehouses')}}/{{$w->id}}/edit">Edit</a></li>
                                                                <li><a href="{{admin_url('warehouses')}}/{{$w->id}}/del">Delete</a></li>
                                                            </ul>
                                                    </div> 
                                           
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
            
            url: "/admin/warehouses/changestatus/" + id + "/status",
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