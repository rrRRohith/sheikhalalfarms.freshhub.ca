@extends('layouts.customer')
@section('title','Backorders')
@section('page_title','Sales & Financials')
@section('page_nav')
<ul>
    <li><a href="{{customer_url('orders')}}">All Orders</a></li>
    <li><a  href="{{customer_url('invoices')}}">Invoices</a>
    <li  class="active"><a  href="{{customer_url('backorders')}}">Backorders</a></li>
</ul>
@endsection
@section('contents')
<div class="content-container">
   <div class="content-area">
      <div class="row">
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-xs-padding">
            <div class="card no-margin minH">
               <div class="card-block">
                   <button id="new-order" class="green_button pull-right">

                            <clr-icon shape="plus-circle"></clr-icon> New order 

                        </button>
                  <h3>Backorders</h3>
                   <section class="card-text customers_outer">
                     <div class="row filter-customer">
                           <div class="col-lg-12">
                              <div class="filter-customer-list">
                                 @if (Session::has('message'))
                                 <div class="alert alert-success">
                                    <font color="red" size="4px">{{ Session::get('message') }}</font>
                                 </div>
                                 @endif
                                 <div class="row clearfix" id="filter_form">
                                    <div class="col-sm-4 col-lg-4">
                                        <div class="form-group">
                                            <label>Search by Keyword</label>
                                            <input type="text"  name="search" id="table-search"  value="{{Request()->search}}" class="form-control" placeholder="search by PO number,Store name"/>
                                        </div>
                                    </div>
                                 </div>
                                <div class="table-list-responsive-md">
                                    <table class="table table-customer mt-0">
                                       <thead>
                                          <tr>
                                             <!--<th class="text-center">-->
                                             <!--   #PO-->
                                             <!--</th>-->
                                             <th class="text-center">
                                                Order Date
                                             </th>
                                             <th class="text-center">
                                                 Qty
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
                  </section>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@include('customers.order-modal')
@endsection
@section('bottom-scripts')
<script>
let searchKey    = $('input#table-search');
let sortDiv = $('div.paginate');
let deferUrl = `{{ customer_url('backorders/defer')}}`;
$(document).ready(function() {

  $.getJSON(`${deferUrl}`,  function(response) {
    renderTable(response);
  });
  $('#table-search').on('keyup', function(){
    loadingRow();
    tableSearch();
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
function tableSearch()
{
    $.getJSON(`${deferUrl}?key=${searchKey.val()}`, function(response) {
       renderTable(response);
     });
}
async function renderTable(response){
  let table = '';
  await response.data.forEach(function(row, index){
    let orderDate = new Date(row.order_date).toLocaleDateString('en-us', {year:"numeric", month:"short", day:"numeric"});
    
    table+=`<tr>
             
             <td class="text-center">
                ${orderDate}
             </td>
             <td class="text-center">
                  ${row.quantity}
             </td>
             <td>
                 <div class="fh_actions">
                    <a href="#" class="fh_link">Actions <i class="fa fa-caret-down"></i> </a>
                    <ul class="fh_dropdown">
                        <a href="{{customer_url('backorders')}}/${row.id}"><li><i class="fa fa-eye" aria-hidden="true"></i> View Details</li></a>
                        
                    </ul>
                 </div> 
             </td>
             
             
            
          </tr>`;
          
          
  });
  $('tbody.append-row').html(table ? table : `<tr><td colspan="7" class="text-center">No data found</td><tr>`);
  $('.paginate').html(response.links);
//   <a href="{{customer_url('backorders')}}/convertbackorder/${row.id}"><li><i class="fa fa-check" aria-hidden="true"></i> Accept Order</li></a>
}
</script>
<script src="/js/customcust.js" ></script>
<script  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA2pKP9bGJRpU-35sWLBgirftfBgLhc03c&callback=initAutocomplete&libraries=places&v=weekly"  async ></script>
@endsection