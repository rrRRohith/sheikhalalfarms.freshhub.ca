@extends('layouts.admin')
@section('title','Staffs')
@section('page_title','Staffs')
@section('page_nav')
<ul>
    <li class="active"></li>
    
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
                            @can('Staff Create')
                                <a href="{{admin_url('staffs/create')}}"  class="pull-right green_button"><i class="fa fa-new"></i> New Staff</a>
                            @endcan
                            
                            <h3>All Staffs</h3>
                            
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
                                 
                                        <div class="row" id="filter_form">
                                            <div class="col-sm-4 col-lg-4">
                                                <label class="control-label">Search By Keyword</label> 
                                                <input type="text" name="search" id="table-search"  value="{{Request()->search}}" placeholder="City Name,Staff Name,Address,Email">
                                            </div>
                                        </div>
                                
                                        <div class="table-list-responsive-md">
                                            <table class="table table-customer mt-0 staff_table">
                                                <thead>
                                                    <tr>
                                                        <th class="text-left"><a class="sort" href="#id" data-sort="id" data-direction="desc">
                                                            ID <i class="ml-2 fa fa-sort"></i></a>
                                                        </th>
                                                        <th class="text-left">
                                                            Profile Picture
                                                        </th>
                                                        <th class="text-left"><a class="sort" href="#firstname" data-sort="firstname" data-direction="asc">
                                                            Name <i class="ml-2 fa fa-sort"></i></a>
                                                        </th>
                                                        <th class="text-left"><a class="sort" href="#email" data-sort="email" data-direction="asc">
                                                            Email <i class="ml-2 fa fa-sort"></i></a>
                                                        </th>
                                                        <th class="text-left"><a class="sort" href="#address" data-sort="address" data-direction="asc">                              
                                                            Address <i class="ml-2 fa fa-sort"></i></a>
                                                        </th class="text-left">
                                                        <th><a class="sort" href="#city" data-sort="city" data-direction="asc">
                                                            City <i class="ml-2 fa fa-sort"></i></a>
                                                        </th>
                                                        <th class="text-left">
                                                            Staff Type
                                                        </th>
                                                        <th class="text-left"><a class="sort" href="#status" data-sort="status" data-direction="asc">                
                                                            Status <i class="ml-2 fa fa-sort"></i></a>
                                                        </th>
                                                        <th class="text-left">                
                                                            Created On
                                                        </th>
                                                        <th class="text-right">
                                                            Actions
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody class="append-row">
                                                    <tr>
                                                        <td colspan="9" class="text-center">Loading Data...</td>
                                                    <tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <div class="p-0 col-lg-4 mr-auto paginate d-flex" data-sort="" data-direction=""></div>
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
<script>
let searchKey    = $('input#table-search');
// let searchCategory   = $('select#category');
// let searchStatus = $('select#status');
let sortDiv = $('div.paginate');
let deferUrl = `{{ admin_url('staffs/defer')}}`;
$(document).ready(function() {

  $.getJSON(`${deferUrl}`,  function(response) {
    renderTable(response);
  });
  $('#table-search').on('keyup', function(){
    loadingRow();
    $.getJSON(`${deferUrl}?key=${searchKey.val()}`, function(response) {
      renderTable(response);
    });
  });
  // $('#table-search').on('keyup', function(){
  //   loadingRow();
  //   $.getJSON(`${deferUrl}?key=${searchKey.val()}&type=${searchCategory.val()}&status=${searchStatus.val()}`, function(response) {
  //     renderTable(response);
  //   });
  // });
  // $('#category').on('change', function(){
  //   loadingRow();
  //   $.getJSON(`${deferUrl}?key=${searchKey.val()}&type=${searchCategory.val()}&status=${searchStatus.val()}`, function(response) {
  //     renderTable(response);
  //   });
  // });
  // $('#status').on('change', function(){
  //   loadingRow();
  //   $.getJSON(`${deferUrl}?key=${searchKey.val()}&type=${searchCategory.val()}&status=${searchStatus.val()}`, function(response) {
  //     renderTable(response);
  //   });
  // });
  $('a.sort').on('click',async function(e){
    e.preventDefault();
    let srtTH = $(this);
    // let key = $('input#table-search').val();
    let sort = srtTH.attr('data-sort');
    let direction = srtTH.attr('data-direction');
      if(sort == null || direction == null)
        return false;
    sortDiv.attr('data-sort', sort);
    sortDiv.attr('data-direction', direction);
    loadingRow();
    await $.getJSON(`${deferUrl}?key=${searchKey.val()}&sort=${sort}&direction=${direction}`, function(response) {
      renderTable(response);
      srtTH.attr('data-direction', direction == 'asc' ? 'desc' : 'asc');
    });
  });
});
function loadingRow()
{
  $('tbody.append-row').html(`<tr><td colspan="7" class="text-center">Loading Data...</td><tr>`);
}
async function renderTable(response){
  let table = '';
  await response.data.forEach(function(row, index){
    let createdAt = new Date(row.created_at).toLocaleDateString('en-us', {year:"numeric", month:"short", day:"numeric"});
    table+=`<tr><td>
              ${row.id}
            </td>
            <td class="text-lg-left  text-md-left"data-label="Organization">
              <img src= "{{asset('images/users/${row.picture}')}}" style="width:50px;height:50px;"/>
            </td>
            <td class="text-lg-left  text-md-left"data-label="Organization">
              <label class="">${row.firstname} ${row.lastname}</label>
            </td>
            <td class="text-lg-left  text-md-left"data-label="Organization">
              <label class="">${row.email}</label>
            </td>
            <td class="text-lg-left  text-md-left"data-label="Organization">
              <label class="">${row.address}</label>
            </td>
            <td class="text-lg-left  text-md-left"data-label="Organization">
              <label class="">${row.city}</label>
            </td>
            <td class="text-lg-left  text-md-left"data-label="Organization">
              <label class="">${row.staff_type}</label>
            </td>
            <td class="text-lg-left  text-md-left"data-label="Organization">
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" ${row.status == '1' ? 'checked' : ''}                                                   onchange="changeStatus('${row.id}');"                                                    name="status">
                <label class="form-check-label" for="flexSwitchCheckChecked"></label>
              </div> 
            </td>
            <td class="text-lg-left  text-md-left"data-label="Organization">
              <label class="">${createdAt}</label>
            </td>
            <td class="text-right" >
              <div class="fh_actions pull-right">
                <a href="#" class="fh_link">Actions <i class="fa fa-caret-down"></i> </a>
                  <ul class="fh_dropdown">
                    @can('Staff Edit')
                      <a href="/admin/staffs/${row.id}/edit"><li><i class="fa fa-edit"></i> Edit</li></a>
                    @endcan
                    @can('Staff Delete')
                      <a href="/admin/staffs/${row.id}/del" onClick="return confirm('Are you sure you want to delete this staff?');"><li><i class="fa fa-trash"></i> Delete</li></a>
                    @endcan
                  </ul>
              </div>
            </td>
          </tr>`;
          
  });
  $('tbody.append-row').html(table ? table : `<tr><td colspan="7" class="text-center">No data found</td><tr>`);
  $('.paginate').html(response.links);
}
</script>
@endsection