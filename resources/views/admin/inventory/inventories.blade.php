@extends('layouts.admin')
@section('title','Inventory')
@section('page_title','Inventories')
@section('page_nav')
<ul>
     <li class="active"></li>  
    <!--<li><a href="{{admin_url('warehouses')}}">Warehouses</a></li>-->
     <!--<li><a href="{{admin_url('inventories/current-stock')}}">Stock</a>-->
   
</ul>
@endsection
@section('contents')
<div class="content-container">
   <div class="content-area">
      <div class="row main_content">
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
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
                                    <div class="row" id="filter_form">
                                        <div class="col-sm-4 col-lg-4">
                                            <label class="control-label">Filter By keyword:</label> 
                                            <input type="text" name="search" id="table-search"  value="{{Request()->search}}" placeholder="Search by product name, sku">
                                        </div>
                                    </div>
                                 <div class="table-list-responsive-md">
                                    <table class="table table-customer mt-0">
                                      
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>SKU</th>
                                                <th>Product</th>
                                                <th>Description</th>
                                                <th>Stock</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="append-row">
                                                <tr><td colspan="9" class="text-center">Loading Data...</td><tr>
                                            </tbody>
                                    </table>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </section>
                     
                     
                  <!--</section>-->
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@include('admin.inventory.stockadd')
@endsection
@section('bottom-scripts')

<script>
    $('body').delegate('.addstock','click',function(e){
        e.preventDefault();
        $('#id').val($(this).data('id'));
        $('#prname').html($(this).data('name'));
           $('#stock_modal').fadeIn('slow');
    });
    $("#stock_modal .close").click(function(e){
		e.preventDefault();
		$("#stock_modal").fadeOut(50);
	});
	
</script>
<script>
let searchKey    = $('input#table-search');
// let searchCategory   = $('select#category');
// let searchStatus = $('select#status');
// let sortDiv = $('div.paginate');
let deferUrl = `{{ admin_url('inventories/defer')}}`;
$(document).ready(function() {

  $.getJSON(`${deferUrl}?key=${searchKey.val()}`,  function(response) {
    renderTable(response);
  });
  $('#table-search').on('keyup', function(){
    loadingRow();
    $.getJSON(`${deferUrl}?key=${searchKey.val()}`, function(response) {
      renderTable(response);
    });
  });

//   $('a.sort').on('click',async function(e){
//     e.preventDefault();
//     let srtTH = $(this);
//     let key = $('input#table-search').val();
//     let sort = srtTH.attr('data-sort');
//     let direction = srtTH.attr('data-direction');
//       if(sort == null || direction == null)
//         return false;
//     sortDiv.attr('data-sort', sort);
//     sortDiv.attr('data-direction', direction);
//     loadingRow();
//     await $.getJSON(`${deferUrl}?key=${searchKey.val()}&sort=${sort}&direction=${direction}`, function(response) {
//       renderTable(response);
//       srtTH.attr('data-direction', direction == 'asc' ? 'desc' : 'asc');
//     });
//   });
$("#stock_form").submit(function(e){
		e.preventDefault();
		
		var formvars = $("#stock_form").serialize();
        
		$.ajax({
            type: 'POST',
            url: $(this).attr("action"),
            data: formvars,
            dataType:"json",
            success: function(data) {
                $("#stock_modal").fadeOut(5);
            	$.getJSON(`${deferUrl}?key=${searchKey.val()}`, function(response) {
      renderTable(response);
            	});
    
            },
            error: function(xhr, status, error){
            	
            	alert('Some errors in submission, Please retry');
                console.log(xhr);
                console.log(status);
                console.log(error);
            }
        })
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
    table+=`<tr>
                <td>
                    ${row.id}
                </td>
                <td>${row.sku}</td>
                <td>${row.name}</td>
                <td>${row.description}</td>
                <td>${row.qty}</td>
                <td><button data-id="${row.id}" data-name="${row.name}" class="pull-left white_button addstock">Add Stock</button></td>
                </tr>`;
    
          
  });
  $('tbody.append-row').html(table ? table : `<tr><td colspan="7" class="text-center">No data found</td><tr>`);
  
}
</script>
@endsection