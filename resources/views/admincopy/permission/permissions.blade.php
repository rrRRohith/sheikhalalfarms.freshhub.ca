@extends('layouts.admin')
@section('contents')
<div class="content-container">
   <div class="content-area">
      <div class="row">
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-xs-padding">
            <div class="card no-margin minH">
               <div class="card-block">
                  <div class="card-title">
                     <div class="card-title-header">
                        <div class="card-title-header-titr"><b> Permissions </b></div>
                        <div class="card-title-header-between"></div>
                        <div class="card-title-header-actions">
                           <a href="#"><img src="{{asset('img/help.svg')}}" alt="help"
                              class="card-title-header-img card-title-header-details"></a>
                        </div>
                     </div>
                  </div>
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
                                                <a href="{{admin_url('permissions/create')}}" class="btn btn-success pull-right">
                                                   <clr-icon shape="plus-circle"></clr-icon> New Permission                            
                                                </a>
                                             </td>
                                          </tr>
                                       </thead>
                                       <thead>
                                          <tr>
                                             <th class="text-left" >
                                                Permission Name
                                             </th>
                                             <th class="text-right">Actions</th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                          @foreach($permissions as $permission)
                                          <tr>
                                             <td class="text-left"><label class="">{!! ucwords($permission->name) !!}</label></td>
                                             <td class="text-right">
                                               <form action="permissions/{{$permission->id}}" method="POST" id="delForm{{$permission->id}}">
                                                <label>
                                                   <a target="" href="permissions/{{$permission->id}}/edit" class="icon-table" rel="tooltip" data-tooltip=" Edit">
                                                      <clr-icon shape="pencil" size="22"></clr-icon>
                                                   </a>
                                                </label>
                                                <label>
                                                   
                                                      @method("DELETE")
                                                      @csrf
                                                      <a href="#" onClick="if(confirm('Are  you sure to delete ?')){ document.getElementById('delForm'+'{{$permission->id}}').submit() } else {return false;}" class="icon-table" rel="tooltip" data-tooltip=" Delete" >
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