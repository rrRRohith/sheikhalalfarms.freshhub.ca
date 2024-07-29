@extends('layouts.admin')
@section('title','Staffs')
@section('page_title','Staffs')
@section('page_nav')
<ul>
    <li class="active"><a href="{{admin_url('staffs')}}">Staffs</a></li>
    
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
                                             @can('Staff Create')
                                             <td colspan="5">
                                                <a href="{{admin_url('staffs/create')}}"
                                                   class="btn btn-success pull-right">
                                                   <clr-icon shape="plus-circle"></clr-icon>
                                                   New Staff                   
                                                </a>
                                             </td>
                                             @endcan
                                          </tr>
                                       </thead>
                                       <thead>
                                          <tr>
                                             <th class="text-left">
                                                ID
                                             </th>
                                             <th></th>
                                             <th class="text-left">
                                                Name
                                             </th>
                                             <th class="text-left">
                                                Email
                                             </th>
                                             <th class="text-left">                                                                           
                                                Address
                                             </th class="text-left">
                                             <th>                                                               
                                                City
                                             </th>
                                             <!--<th>                                                               -->
                                             <!--   Country-->
                                             <!--</th>-->
                                             <!--<th>                -->
                                             <!--   Phone-->
                                             <!--</th>-->
                                             <th class="text-left">
                                                 Staff Type
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
                                          @foreach($staffs as $staff)
                                          <tr>
                                             <td data-label="" class="text-left"> {{$staff->id}}</td>
                                             
                                             <td><img src="/media/staffs/{{$staff->profile_picture}}" style="width:50px;height:50px;" /></td>
                                             <td class="text-lg-left  text-md-left"data-label="Organization"><label class="text-left"><a target='' href="{{url('admin/staffs')}}/{{$staff->id}}">{{$staff->firstname}} {{$staff->lastname}}</a></label></td>
                                             <td data-label="Email" class="text-left"><label class="text-left">{{$staff->email}}</label></td>
                                             <td data-label="City" class="text-left"><label >{{$staff->address}}</label></td>
                                             <td data-label="Account Province"><label class="text-left">{{$staff->city}}</label></td>
                                             <!--<td data-label="Account Province"><label class="">{{$staff->country}}</label></td>-->
                                             <!--<td data-label="Phone">-->
                                             <!--   <phone phone-range="{{$staff->phone}}" type-num="phone"></phone>-->
                                             <!--</td>-->
                                             <td class="text-left">{{$staff->name}}</td>
                                             
                                             <!--<td data-label="Phone">@if($staff->status==0)Inactive @else Active @endif </td>-->
                                             
                                             <td>
                                                    
                                                 <div class="col-lg-3 col-md-3 col-sm-12">
                                                    <label class="switch">
                                                    <input type="checkbox" <?php if(isset($staff)){ if($staff->status==1){ ?> checked <?php } } ?>
                                                     onchange="changeStatus('{{$staff->id}}');"
                                                    name="status">
                                                    <span class="slider round" style="height:31px;"></span>
                                                    </label>
                                                 </div>
                                             </td>
                                             <td data-label="Create on" class="text-left">{{date('d M Y ',strtotime($staff->created_at))}}</td>
                                             <td data-label=Actions class="text-right">
                                                <!--<label>-->
                                                <!--   @if($staff->status==0)-->
                                                <!--   <a target="" href="{{url('admin/staffs/changestatus')}}/{{$staff->id}}/1" data-tooltip="Activate" rel="tooltip">-->
                                                <!--      <clr-icon shape="check" size="22"></clr-icon>-->
                                                <!--   </a>-->
                                                <!--   @else-->
                                                <!--   <a target="" href="{{url('admin/staffs/changestatus')}}/{{$staff->id}}/0" data-tooltip=" Deactivate" rel="tooltip">-->
                                                <!--      <clr-icon shape="times" size="22"></clr-icon>-->
                                                <!--   </a>-->
                                                <!--   @endif-->
                                                <!--</label>-->
                                                @can('Staff Edit')
                                                <label>
                                                   <a target="" href="{{admin_url('staffs')}}/{{$staff->id}}/edit" class="icon-table" rel="tooltip" data-tooltip=" Edit">
                                                      <clr-icon shape="pencil" size="22"></clr-icon>
                                                   </a>
                                                </label>
                                                @endcan
                                                @can('Staff Delete')
                                                <label>
                                                   <a target="" href="{{admin_url('staffs')}}/{{$staff->id}}/del" class="icon-table" rel="tooltip" data-tooltip=" Delete">
                                                      <clr-icon shape="trash" size="22"></clr-icon>
                                                   </a>
                                                </label>
                                                @endcan
                                             </td>
                                          </tr>
                                          @endforeach
                                       </tbody>
                                       <tfoot>
                                          <tr>
                                             <th colspan="5">
                                                <nav class="pull-left number" aria-label="Page navigation">
                                                </nav>
                                             </th>
                                             <th colspan="5"
                                                class="text-lg-right text-md-right number">
                                                Show {{count($staffs)}} case from {{count($staffs)}}
                                                               
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
@section('bottom-scripts')
<script>
function changeStatus(id) {
    if (id) {
        $.ajax({
            
            url: "/admin/staffs/changestatus/" + id + "/status",
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