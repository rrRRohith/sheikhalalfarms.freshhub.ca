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
                                 
                                            <div class="row" style="padding-bottom: 8px;">
                                              <div class="col-sm-8"></div>
                                                <div class="col-sm-4">
                                                   
                                                    <input type="text" name="search" id="table-search"  value="{{Request()->search}}" placeholder="Search by name or code">
                                                </div>
                                                
                                                
                                          
                                            </div>
                                        
                                 <div class="table-list-responsive-md">
                                     
                                    <table class="table table-customer mt-0" id="table">
                                       
                                       <thead>
                                          <tr>
                                             <th>
                                              <a class="sort" href="#id" data-sort="id" data-direction="desc">
                                              ID <i class="ml-2 fa fa-sort"></i></a> 
                                             </th>
                                             <th class="text-left"><a class="sort" href="#name" data-sort="name" data-direction="asc">
                                                Name <i class="ml-2 fa fa-sort"></i></a>
                                             </th>
                                             <th class="text-left"><a class="sort" href="#shortcode" data-sort="shortcode" data-direction="asc">
                                                Code <i class="ml-2 fa fa-sort"></i></a>
                                             </th>
                                             <th class="text-left"><a class="sort" href="#status" data-sort="status" data-direction="asc">
                                                Status <i class="ml-2 fa fa-sort"></i>
                                              </a>
                                             </th>
                                           <th class="text-right">Actions</th>
                                          </tr>
                                       </thead>
                                       <tbody class="append-row">
                                        <tr><td colspan="5" class="text-center">Loading Data...</td><tr>
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
            url: "/admin/unittype/changestatus/" + id ,
            type: 'get',
            data: {},
            success: function(data) {
                console.log('success');
            }
        });
    }
}
</script>
<script>
let searchKey = $('input#table-search');
let sortDiv = $('div.paginate');
let deferUrl = `{{ admin_url('unittype/defer')}}`;
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
  $('a.sort').on('click',async function(e){
    e.preventDefault();
    let srtTH = $(this);
    let key = $('input#table-search').val();
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
  $('tbody.append-row').html(`<tr><td colspan="5" class="text-center">Loading Data...</td><tr>`);
}
async function renderTable(response){
  let table = '';
  await response.data.forEach(function(row, index){
    let createdAt = new Date(row.created_at).toLocaleDateString('en-us', {year:"numeric", month:"short", day:"numeric"});
    table+=`<tr><td>
              ${row.id}
            </td>
            <td class="text-lg-left  text-md-left"data-label="Organization">
              <label class="">${row.name}</label>
            </td>
            <td class="text-lg-left  text-md-left"data-label="Organization">
              <label class="">${row.shortcode}</label>
            </td>
            <td class="text-lg-left  text-md-left"data-label="Organization">
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" ${row.status == '1' ? 'checked' : ''}                                                   onchange="changeStatus('${row.id}');"                                                    name="status">
                <label class="form-check-label" for="flexSwitchCheckChecked"></label>
              </div> 
            </td>
            <td class="text-right" >
              <div class="fh_actions pull-right">
                <a href="#" class="fh_link">Actions <i class="fa fa-caret-down"></i> </a>
                  <ul class="fh_dropdown">
                    @can('Customer Edit')
                      <a href="/admin/unittype/${row.id}/edit"><li><i class="fa fa-edit"></i> Edit</li></a>
                    @endcan
                    @can('Customer Delete')
                      <a href="/admin/unittype/${row.id}/del"><li><i class="fa fa-trash"></i> Delete</li></a>
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