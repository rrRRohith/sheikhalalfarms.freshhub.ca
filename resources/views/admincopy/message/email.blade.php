@extends('layouts.admin')
@section('title','Emails')
@section('page_title','Configuration')
@section('page_nav')
<ul>
    <li><a href="{{url('admin/settings')}}">Settings</a> </li>
    <li ><a href="{{url('admin/roles')}}">Roles & Permissions</a> </li>
    <li class="active"><a href="{{url('admin/emails')}}">Emails</a> </li>
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
<div class="table-list-responsive-md">
   <table class="table table-list mt-0 jsScrollTable">
      <thead class="table-list-header-options">
      </thead>
      <thead>
         <tr>
            <th>Name</th>
            <th>Action</th>
            <th>Created_at</th>
            <th>Updated_at</th>
         </tr>
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
      <tbody>
      </tbody>
      <tfoot>
         <tr>
         </tr>
      </tfoot>
   </table>
</div>
<br>
<div class="modal js-text-modal">
   <div class="modal-dialog modal-lg" role="dialog" aria-hidden="true">
      <div class="modal-content">
         <div class="modal-header">
            <button aria-label="Close" class="close" type="button" onClick="cancelModal()">
               <clr-icon aria-hidden="true" shape="close"></clr-icon>
            </button>
            <h3 class="modal-title modal-email-label"></h3>
         </div>
         <div class="modal-body" id="modal-email-content">
         </div>
      </div>
   </div>
</div>
@endsection