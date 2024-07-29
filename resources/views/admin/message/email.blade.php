@extends('layouts.admin')
@section('title','Emails')
@section('page_title','Configuration')
@section('page_nav')
<ul>
    <li><a href="{{url('admin/configuration')}}">Settings</a> </li>
    <li ><a href="{{url('admin/roles')}}">Roles & Permissions</a> </li>
    <li class="active"><a href="{{url('admin/emails')}}">Emails</a> </li>
    <li><a href="{{url('admin/unittype')}}">Unit Type</a> </li>
    <li><a href="{{url('admin/weight')}}">Weight</a></li>
</ul>
@endsection
@section('contents')
<div class="content-container">
<div class="content-area">
<div class="row main_content">
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding">
<div class="card no-margin minH">
<div class="card-block">

<div class="content-container">
   <div class="content-area">
      <div class="row emailpage">
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-xs-padding">
            <div class="card no-margin minH">
               <div class="card-block">
                    <div class="headercnt_top">
                                    <div class="innerpage_title">
                                        <h3>Emails</h3>
                                    </div>
                       
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
                                    <table class="table table-customer mt-0 emial table">
                                      <thead class="table-list-header-options">
                                      </thead>
                                      <thead>
                                         <tr>
                                            <th>Name</th>
                                            <th>Action</th>
                                            <th>Created_at</th>
                                            <th>Updated_at</th>
                                         </tr>
                                      </thead>
                                         @foreach($email as $e)
                                         <tr>
                                            <td>
                                               {{$e->name}}
                                            </td>
                                            <td>
                                               {{$e->action}}
                                            </td>
                                            <td>
                                               {{date('d M Y',strtotime($e->created_at))}}
                                            </td>
                                            <td>
                                               {{date('d M Y',strtotime($e->updated_at))}}
                                            </td>
                                         </tr>
                                         @endforeach
                                      </thead>
                                      <!--<tbody>-->
                                      <!--</tbody>-->
                                      <!--<tfoot>-->
                                      <!--   <tr>-->
                                      <!--   </tr>-->
                                      <!--</tfoot>-->
                                   </table>
                                </div>
                                <br>
                                
                                </div>
                            </div>
                        <!--</div>-->
                    </div>
                 </section>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>            
                                
 @endsection