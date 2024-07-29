@extends('layouts.admin')
@section('title','Weight')
@section('page_title','Configuration')
@section('page_nav')
<ul>
    <li><a href="{{url('admin/configuration')}}">Settings</a> </li>
    <li><a href="{{url('admin/roles')}}">Roles & Permissions</a> </li>
    <!--<li><a href="{{url('admin/emails')}}">Emails</a> </li>-->
    <li><a href="{{url('admin/unittype')}}">Unit Type</a> </li>
    <li class="active"><a href="{{url('admin/weight')}}">Weight</a></li>
  
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
                       <!--<a href="{{admin_url('unittype/create')}}"  class="pull-right green_button">-->
                       <!--                            <i class="fa fa-new"></i> New Unit Type </a>-->
                    <h3>Weights</h3>
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
                                 <div class="table-list-responsive-md">
                                     
                                    <table class="table table-customer mt-0">
                                       
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
                                               Set Default Weight
                                             </th>
                                           <!--<th class="text-right">Actions</th>-->
                                          </tr>
                                       </thead>
                                       @if(isset($weights) && count($weights)>0)
                                       <tbody>
                                       
                                          @foreach($weights as $t)
                                          <tr  >
                                             <td width="5">
                                               {{$t->id}}
                                             </td>
                                             <td class="text-lg-left  text-md-left"data-label="Organization"><label class="">{{$t->name}}</label></td>
                                             <td class="text-lg-left  text-md-left"data-label="Organization"><label class="">{{$t->code}}</label></td>
                                             <td class="text-lg-left  text-md-left"data-label="Organization">
                                                 <!--<input type="radio" name="base" <?php if($t->base==1){ ?> checked <?php } ?> onchange="changeStatus('{{$t->id}}');">-->
                                                 <div class="form-check form-switch">
                                                  <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" <?php if($t->base==1){ ?> checked <?php } ?>
                                                     onchange="changeStatus('{{$t->id}}');"
                                                    name="status" readonly>
                                                  <label class="form-check-label" for="flexSwitchCheckChecked"></label>
                                                </div> 
                                             </td>
                                             <!--<td class="text-right" >-->
                                             <!--   <div class="fh_actions pull-right">-->
                                             <!--       <a href="#" class="fh_link">Actions <i class="fa fa-caret-down"></i> </a>-->
                                             <!--       <ul class="fh_dropdown">-->
                                             <!--           @can('Customer Edit')-->
                                             <!--           <li><a href="{{admin_url('unittype')}}/{{$t->id}}/edit"><i class="fa fa-edit"></i> Edit</a></li>-->
                                             <!--           @endcan-->
                                             <!--           @can('Customer Delete')-->
                                             <!--           <li><a href="{{admin_url('unittype')}}/{{$t->id}}/del"><i class="fa fa-trash"></i> Delete</a></li>-->
                                             <!--           @endcan-->
                                             <!--       </ul>-->
                                             <!--   </div>-->
                                             <!--</td>-->
                                          </tr>
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
                    <div class="text-bold" style="padding:10px;"> {{$weights->links()}}Showing Page {{$weights->currentPage()}} of {{$weights->lastPage()}} </div>
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
    var url="<?php echo admin_url('weight/changebase')?>/"+id;
    window.location.href=url;
    // alert(url);
    // alert(id);
    // if (id) {
    //     $.ajax({
    //         url: "/admin/weight/changestatus/" + id ,
    //         type: 'get',
    //         data: {},
    //         success: function(data) {
    //             console.log(data.status);
    //         }
    //     });
    // }
}
</script>
@endsection