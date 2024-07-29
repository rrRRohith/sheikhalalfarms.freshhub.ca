@extends('layouts.admin')
@section('title','Deliveries')
@section('page_title','Deliveries')
@section('page_nav')
<ul>
    <li class="active"><a href="{{admin_url('deliveries')}}">Deliveries</a></li>
    <!--<li><a  href="#">Generate Runsheet</a>-->
    
    
</ul>
@endsection
@section('contents')
<div class="content-container">
   <div class="content-area">
      <div class="row main_content">
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 addnew_form">
            <div class="card no-margin minH">
                <div class="row clearfix diverselector">
                    @foreach($drivers as $driver)
                    <div class="col-sm-6 col-md-3 driverdiv" data-id="{{$driver->id}}" data-count="{{count($driver->driverorder)}}">
                        <button class="driverselector_button white_button">{{$driver->firstname}} <span>{{count($driver->driverorder)}}</span></button>
                    
                    </div>
                    @endforeach
                </div>
               <div class="card-block" style="padding:5px;">
                  <!--  <div class="card-title">-->
                  <!--  <a href="{{admin_url('runsheets')}}" class="pull-right white_button"> -->
                  <!--    <i class="fa fa-arrow-left" aria-hidden="true"></i> All Runsheets</a>-->
                  <!--  <h3>Deliveries</h3>-->
                  <!--</div>-->
                  
                  @php $case=0;@endphp
                  @if(isset($orders) && count($orders)>0)
                  @foreach($orders as $order)
                  @foreach($order->item as $item)
                  @php $case+=$item->quantity;@endphp
                  @endforeach
                  @endforeach
                  @endif
                  <section class="card-text">

                    <div class="row">
                        <div class="col-md-12" id="addAccountForm">
                             <div class="row">
                                 <div class="col-sm-6">
                                    <label style="font-size:16px;"><strong>Total Deliveries</strong></label> : <span style="font-size:16px;">{{$totorders}}</span><br>
                                     <label style="font-size:16px;"><strong>Unassigned Deliveries</strong></label> : <span style="font-size:16px;">@if(isset($orders) && count($orders)>0) {{$orders->where('assign_driver',0)->count()}} @else 0 @endif</span>
                                 </div>
                                 <div class="col-sm-3">
                                    <label>Search</label><br>
                                    <input type="text" class="form-control" name="search" id="search1" value="{{Request()->search}}" placeholder="Search by storename, phone number or invoice number">
                                    <br>
                                    
                                 </div>
                                 <div class="col-sm-3">
                                    <label>Delivery Date</label><br>
                                    <input type="date" class="form-control" name="date" id="date" value="{{Request()->date ?? date('Y-m-d')}}">
                                    <br>
                                    
                                 </div>
                             </div>
                          

                            
                         </div>
                         
                    </div>

                  </section>



                    @if(isset($orders))
                    <input type="checkbox" id="all" @if(Request()->all=='yes') checked @endif> Show all deliveries

                  <section class="card-text">

                     <div class="row filter-customer">
                       <div class="col-lg-12">
                          <div class="filter-customer-list">
                            @if (Session::has('message'))
                             <div class="alert alert-success">
                                <font color="red" size="4px">{{ Session::get('message') }}</font>
                             </div>
                            @endif
                               
                                <div class="table-list-responsive-md">
                                    <table class="table table-customer mt-0">
                                       <thead>
                                          <tr>
                                             <th class="sort" data-order="{{(Request()->sort=='asc') ? 'desc' : 'asc'}} "><a style="cursor:pointer;">Delivery Date</a></th>
                                             <th>Store Name</th>
                                             <th>Contact Person</th>
                                             <th>Address</th>
                                             <th class="text-center">Case/Qty</th>
                                             <th>Invoice Amount</th>
                                             <!--<th class="text-center">Weight</th>-->
                                             <!--<th class="text-center">Assign Route</th>-->
                                             <th class="text-left">Assign Driver</th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                           
                                           @if(count($orders)>0)
                                           @foreach($orders as $order)
                                           <tr>
                                               <td>
                                                   {{date('d M Y',strtotime($order->shipping_date))}}
                                               </td>
                                               <td>{{$order->user->business_name}}</td>
                                               <td>
                                                   <input type="hidden" name="id[]" value="{{$order->id}}">
                                                   
                                                   
                                                  {{$order->user->firstname}} {{$order->user->lastname}}
                                               </td>
                                               
                                               <td>
                                                   <a href="https://www.google.com/maps/place/{{urlencode($order->delivery->address)}}" target="_blank"><i class="fa fa-map-marker"></i> {{$order->delivery->address}}</a>
                                               </td>
                                               <td>
                                                   {{$order->item->sum('quantity')}}
                                               </td>
                                               <td>
                                                  {{showPrice($order->grand_total)}}
                                               </td>
                                               <td>
                                                   @if($order->assign_driver==0)
                                                   <form action="{{admin_url('assigndriver')}}" method="post" class="assigndelivery_form">
                                                       @csrf
                                                    <input type="hidden" name="orderid" value="{{$order->id}}">      
                                                   <select class="form-control driver_select" name="driver" id="driver" required >
                                                       <option value="">Select Driver</option>
                                                       @foreach($drivers as $driver)
                                                       <option value="{{$driver->id}}" @if($order->driver_id==$driver->id) selected @endif>{{$driver->firstname}} {{$driver->lastname}}</option>
                                                       @endforeach
                                                   </select>
                                                   
                                                   <button type="submit" class="white_button"><i class="fa fa-check" aria-hidden="true" ></i>Assign</button>
                                                    
                                                   </form>
                                                   @else
                                                   <font color="darkmagenta" size="3px">{{$order->driver->firstname}} {{$order->driver->lastname}}</font>
                                                   @endif
                                               </td>
                                               
                                           </tr>
                                           @endforeach
                                           @else
                                           <tr>
                                               <th colspan="7"><center>No Deliveries Found for this date</center></th>
                                           </tr>
                                           @endif
                                       </tbody>
                                    
                                    </table>
                                 </div>
                                 
                              
                             
                          </div>
                       </div>
                    </div>

                    </section>
                    <!--@if(isset($orders) && count($orders)>0)<button type="submit" class="white_button"><i class="fa fa-bolt"></i> Generate Runsheet</button>@endif-->
                   


                    @endif
                 
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

@endsection
@section('bottom-scripts')
<script>
    $(document).ready(function(){
        $('#date').on('change',function(){
            var date1=$(this).val();
            var url="<?php echo admin_url('deliveries')?>?date=" +date1;
            window.location=url;
        });
        $('#search1').on('keyup',function(){
            var term=$(this).val();
            var url="<?php echo admin_url('deliveries')?>?search=" +term;
            window.location=url;
        });
        $('.driverdiv').on('click',function(){
            var driverid=$(this).data('id');
            var date=$('#date').val();
            var cou=$(this).data('count');
            if(date !='')
            {
                if(cou >0)
                {
                var url="<?php echo admin_url('getorders')?>?driver="+driverid+"&date="+date;
                window.location=url;
                }
                else
                {
                    alert("No pending delivery found for the selected driver");
                }
            }
            else
            {
                alert('Please select a date first');
                $('#date').focus();
            }
        });
    $('.sort').click(function(){
        var sort=$(this).data('order');
        var url="<?php echo admin_url('deliveries')?>?sort="+sort;
        window.location=url;
    });
    
    $('#all').change(function(){
        var date=$('#date').val();
       if($("#all").prop('checked') == true)
       {
           var url="<?php echo admin_url('deliveries')?>?date="+date+"&all=yes";
       }
       else
       {
           var url="<?php echo admin_url('deliveries')?>?date="+date;
       }
       window.location=url;
    });
    });
</script>
<script>
let searchKey    = $('input#table-search');
let searchDate  = $('input#date');
let sortDiv = $('div.paginate');
let deferUrl = `{{ admin_url('deliveries/defer')}}`;
$(document).ready(function() {

  $.getJSON(`${deferUrl}`,  function(response) {
    renderTable(response);
  });
  $('#table-search').on('keyup', function(){
    loadingRow();
    tableSearch();
  });
  $('#date').on('change', function(){
    loadingRow();
    tableSearch();
  });
  function tableSearch()
  {
      $.getJSON(`${deferUrl}?key=${searchKey.val()}&date=${searchDate.val()}`, function(response) {
      renderTable(response);
    });
  }
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
              <label class="">${row.storename}</label>
            </td>
            <td class="text-lg-left  text-md-left"data-label="Organization">
              <label class="">${row.type}</label>
            </td>
            <td class="text-lg-left  text-md-left"data-label="Organization">
              <label class="">${row.address}</label>
            </td>
            <td class="text-lg-left  text-md-left"data-label="Organization">
              <label class="">${row.unpaid_invoice}</label>
            </td>
            <td class="text-lg-left  text-md-left"data-label="Organization">
              <label class="">${row.total_due}</label>
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
                      <a class="editcustomer" data-id="${row.id}"><li><i class="fa fa-edit"></i> Edit</li></a>
                    @endcan
                    @can('Customer Delete')
                      <a href="/admin/customers/${row.id}/del"><li><i class="fa fa-trash"></i> Delete</li></a>
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