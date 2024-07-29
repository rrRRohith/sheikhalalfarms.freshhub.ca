@extends('layouts.admin')
@section('page_title','Configuration')
@section('page_nav')
<ul>
    <li><a href="{{url('admin/settings')}}">Settings</a> </li>
    <li class="active"><a href="{{url('admin/roles')}}">Roles & Permissions</a> </li>
    <li><a href="{{url('admin/emails')}}">Emails</a> </li>
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
                           <div class="col-sm-12">
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
                                             <td>
                                                
                                             </td>
                                             <td>
                                                <a href="{{admin_url('roles/create')}}" class="btn btn-success pull-right">
                                                   <clr-icon shape="plus-circle"></clr-icon> New Role                            
                                                </a>
                                             </td>
                                          </tr>
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
                                               <form action="roles/{{$role->id}}" method="POST" id="delForm{{$role->id}}">
                                                <label>
                                                   <a target="" href="roles/{{$role->id}}/edit" class="icon-table" rel="tooltip" data-tooltip=" Edit">
                                                      <clr-icon shape="pencil" size="22"></clr-icon>
                                                   </a>
                                                </label>
                                                <label>
                                                   
                                                      @method("DELETE")
                                                      @csrf
                                                      <a href="#" onClick="if(confirm('Are  you sure to delete ?')){ document.getElementById('delForm'+'{{$role->id}}').submit() } else {return false;}" class="icon-table" rel="tooltip" data-tooltip=" Delete" >
                                                         <clr-icon shape="trash" size="22"></clr-icon>
                                                      </a>
                                                   
                                                </label>
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
                  </section>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection