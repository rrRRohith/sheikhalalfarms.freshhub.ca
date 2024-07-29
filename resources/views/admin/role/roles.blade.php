@extends('layouts.admin')
@section('page_title','Configuration')
@section('page_nav')
<ul>
    <li><a href="{{url('admin/configuration')}}">Settings</a> </li>
    <li class="active"><a href="{{url('admin/roles')}}">Roles & Permissions</a> </li>
    <!--<li><a href="{{url('admin/emails')}}">Emails</a> </li>-->
    <li><a href="{{url('admin/unittype')}}">Unit Type</a> </li>
    <li><a href="{{url('admin/weight')}}">Weight</a></li>
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
                                        <h3>Roles & Permissions</h3>
                                    </div>
                              <a href="{{admin_url('roles/create')}}" class="btn btn-success pull-right main_button green_button">
                                                   <clr-icon shape="plus-circle"></clr-icon> New Role                            
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
                                    <table class="table table-customer mt-0 rolecontrol_form">
                                       <thead class="table-list-header-options">
                                          <!--<tr>-->
                                          <!--   <td>-->
                                                
                                          <!--   </td>-->
                                          <!--   <td>-->
                                                
                                          <!--   </td>-->
                                          <!--</tr>-->
                                       </thead>
                                       <thead>
                                          <tr>
                                             <th class="text-left" >
                                                Role Name
                                             </th>
                                             <th class="text-right">Actions</th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                          @foreach($roles as $role)
                                          <tr>
                                             <td class="text-left"><label class="">{!! ucwords($role->name) !!}</label></td>
                                             <td class="text-right">
                                               <form action="roles/{{$role->id}}" method="POST" id="delForm{{$role->id}}" class="roles_form">
                                                <!--<label>-->
                                                <!--   <a target="" href="roles/{{$role->id}}/edit" class="icon-table" rel="tooltip" data-tooltip=" Edit">-->
                                                <!--      <clr-icon shape="pencil" size="22"></clr-icon>-->
                                                <!--   </a>-->
                                                <!--</label>-->
                                                <!--<label>-->
                                                   
                                                <!--      @method("DELETE")-->
                                                <!--      @csrf-->
                                                <!--      <a href="#" onClick="if(confirm('Are  you sure to delete ?')){ document.getElementById('delForm'+'{{$role->id}}').submit() } else {return false;}" class="icon-table" rel="tooltip" data-tooltip=" Delete" >-->
                                                <!--         <clr-icon shape="trash" size="22"></clr-icon>-->
                                                <!--      </a>-->
                                                   
                                                <!--</label>-->
                                                        <div class="fh_actions">
                                                            <a href="#" class="fh_link">Actions <i class="fa fa-caret-down"></i> </a>
                                                            <ul class="fh_dropdown">
                                                                <a href="roles/{{$role->id}}/edit"><li><i class="fa fa-edit"></i>Edit</li></a>
                                                                <a href="" onClick="if(confirm('Are  you sure to delete ?')){ document.getElementById('delForm'+'{{$role->id}}').submit() } else {return false;}"><li><i class="fa fa-trash"></i>Delete</li></a>
                                                            </ul>
                                                    </div>  
                                                 <!--<select  class="form-control rolecontrol_action" onchange="location=this.options[this.selectedIndex].value;">-->
                                                 <!--   <option>Select Action</option>-->
                                                 <!--   <option value="roles/{{$role->id}}/edit">Edit<a href="roles/{{$role->id}}/edit"></a></option>-->
                                                 <!--   <option value="" onClick="if(confirm('Are  you sure to delete ?')){ document.getElementById('delForm'+'{{$role->id}}').submit() } else {return false;}" >Delete</option>       -->
                                                 <!-- </select> -->
                                                </form>
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
                 <div class="text-bold" style="padding:10px;"> {{$roles->links()}}Showing Page {{$roles->currentPage()}} of {{$roles->lastPage()}} </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection