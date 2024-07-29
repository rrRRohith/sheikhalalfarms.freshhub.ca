@extends('layouts.admin')
@section('title','Deliveries')
@section('page_title','Deliveries')
@section('page_nav')
<ul>
    <li class="active"><a href="{{admin_url('deliveries')}}">Deliveries</a></li>
    <li><a  href="{{admin_url('generaterunsheet')}}">Assign Drivers</a>
    
    
</ul>
@endsection
@section('contents')
<div class="content-container">
   <div class="content-area">
      <div class="row main_content">
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 addnew_form">
            <div class="card no-margin minH">
                
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
                                 <div class="col-sm-4">
                                    <label style="font-size:16px;"><strong>Total Deliveries</strong></label> : <span style="font-size:16px;" id="totorder"></span><br>
                                     <label style="font-size:16px;"><strong>Unassigned Deliveries</strong></label> : <span style="font-size:16px;" id="unassign"></span>
                                 </div>
                                 
                                 <div class="col-sm-2">
                                    <label>Search</label><br>
                                    <input type="text" class="form-control" name="search" id="table-search" value="{{Request()->key}}" placeholder="Search by storename, phone number or invoice number">
                                    <br>
                                    
                                 </div>
                                 <div class="col-sm-2">
                                    <label>Search By Driver</label><br>
                                    <select class="form-control" name="driver" id="driver">
                                        <option value="">All</option>
                                        @foreach($drivers as $driver)
                                            <option value="{{$driver->id}}">{{$driver->firstname}} {{$driver->lastname}}</option>
                                        @endforeach
                                    </select>
                                    <br>
                                    
                                 </div>
                                 <div class="col-sm-2">
                                    <label>Sort by status</label><br>
                                    <select class="form-control" name="status" id="status">
                                        <option value="">All</option>
                                        <option value="1">Assigned</option>
                                        <option value="0">Not Assigned</option>
                                    </select>
                                    <br>
                                    
                                 </div>
                                 <div class="col-sm-2">
                                    <label>Delivery Date</label><br>
                                    <input type="date" class="form-control" name="date" id="date" value="{{Request()->date ?? date('Y-m-d')}}">
                                    <input type="hidden" name="date1" id="date1" value="{{date('Y-m-d')}}">
                                    <input type="hidden" name="time1" id="time1" value="{{strtotime(date('H:i:s'))}}">
                                    <input type="hidden" name="time2" id="time2" value="{{strtotime('17:00:00')}}">
                                    <br>
                                    
                                 </div>
                             </div>
                          

                            
                         </div>
                         
                    </div>

                  </section>
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
                                             <!--<th class="sort" data-order="{{(Request()->sort=='asc') ? 'desc' : 'asc'}} "><a style="cursor:pointer;">Delivery Date</a></th>-->
                                              <th>Delivery Date</th>
                                              <th>Invoice Number</th>
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
                                       <tbody class="append-row">
                                                <tr><td colspan="8" class="text-center">Loading Data...</td><tr>
                                            </tbody>
                                       
                                    
                                    </table>
                                 </div>
                                 
                              
                             
                          </div>
                       </div>
                    </div>

                    </section>
                    <!--@if(isset($orders) && count($orders)>0)<button type="submit" class="white_button"><i class="fa fa-bolt"></i> Generate Runsheet</button>@endif-->
                   


                    
                 
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
        // $('#date').on('change',function(){
        //     var date1=$(this).val();
        //     var url="<?php echo admin_url('deliveries')?>?date=" +date1;
        //     window.location=url;
        // });
        // $('#search1').on('keyup',function(){
        //     var term=$(this).val();
        //     var url="<?php echo admin_url('deliveries')?>?search=" +term;
        //     window.location=url;
        // });
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
let searchStatus= $('select#status');
let searchDriver= $('select#driver');
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
  $('#status').on('change', function(){
    loadingRow();
    tableSearch();
  });
  $('#driver').on('change', function(){
    loadingRow();
    tableSearch();
  });
  function tableSearch()
  {
      $.getJSON(`${deferUrl}?key=${searchKey.val()}&date=${searchDate.val()}&status=${searchStatus.val()}&driver=${searchDriver.val()}`, function(response) {
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
    await $.getJSON(`${deferUrl}?key=${searchKey.val()}&date=${searchDate.val()}&status=${searchStatus.val()}&sort=${sort}&direction=${direction}`, function(response) {
      renderTable(response);
      srtTH.attr('data-direction', direction == 'asc' ? 'desc' : 'asc');
    });
  });
});
function loadingRow()
{
  $('tbody.append-row').html(`<tr><td colspan="8" class="text-center">Loading Data...</td><tr>`);
}
async function renderTable(response){
  let table = '';
  var tot=0;
  var ass=0;
  await response.data.forEach(function(row, index){
    let createdAt = new Date(row.created_at).toLocaleDateString('en-us', {year:"numeric", month:"short", day:"numeric"});
    let shippingDate=new Date(row.shipping_date).toLocaleDateString('en-us', {year:"numeric", month:"short", day:"numeric"});
    var text="";
    if(row.assign_driver==0)
    {
    text='<font color="red">Not Assigned</font>';
    ass++;
    }
    else
    {
        text=getDriver(row.driver_id,row.id);
    }
    tot++;
    table+=`<tr>
               <td>
                   ${shippingDate}
               </td>
               <td>${row.invoice_number}</td>
               <td>${row.shopname}</td>
               <td>
                   <input type="hidden" name="id[]" value="${row.id}">
                  ${row.name}
               </td>
               
               <td>
                   <a href="https://www.google.com/maps/place/${row.address}" target="_blank"><i class="fa fa-map-marker"></i> ${row.address}</a>
               </td>
               <td>
                   ${row.quantity}
               </td>
               <td>
                  ${row.grand_total}
               </td>
               <td>`+text+`</td>
               
               
           </tr>`;
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
          
  });
  $('tbody.append-row').html(table ? table : `<tr><td colspan="8" class="text-center">No data found</td><tr>`);
  $('#totorder').html(tot);
  $('#unassign').html(ass);
  $('.paginate').html(response.links);
}
function getDriver(id,orderid)
{
    var date=$('#date1').val();
    var seldate=$('#date').val();
    var curtime=$('#time1').val();
    var endtime=$('#time2').val();
    var dis="";
    if((date > seldate))
    {
        dis='disabled';
        
    }
    if(date == seldate)
    {
        if(curtime > endtime)
        {
    dis='disabled';
        }
    }
    var driver='<select name="driver_id" id="driver_id" class="form-control" data-id="'+orderid+'" '+dis+'><option value="">Assign None</option>';
    @foreach($drivers as $driver)
    driver+='<option value="{{$driver->id}}"';
    if(id=='{{$driver->id}}'){
        driver+='selected';
    }
    driver+='>{{$driver->firstname}} {{$driver->lastname}}</option>';
    @endforeach
    driver+='</select>';
    return driver;
}
$('body').delegate('#driver_id','change',function(){
    var id=$(this).data('id');
    var driver=$(this).val();
   
    var url="<?php echo admin_url('deliveries/reassign')?>?id=" +id+"&driver="+driver;
    $.ajax({
    type: "get",
    url: url,
    success: function(data) {
        location.reload();
    }
});
    
});
</script>
@endsection