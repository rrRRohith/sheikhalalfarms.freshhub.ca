@extends('layouts.admin')
@section('title','Dashboard')
@section('page_title','Dashboard')
@section('page_nav')
<ul>
    <li class="active"></li>
    <!--<li><a href="{{admin_url('profile')}}">Profile</a></li>  -->
    <!--<li><a href="{{admin_url('changepassword')}}">Change Password</a></li>-->
</ul>
@endsection

@push('styles')
<link href="/css/dashboard.css" rel="stylesheet" />
@endpush

@section('contents')
<div class="content-container">
   <div class="content-area">
      <div id="dashboard">
          
           <div class="row">
               <div class="col-md-6">
                   <div id="orders_hourly" class="bg-green border">
                       
                   </div>
               </div>
               <div class="col-md-6">
                   <div class="info-boxes">
                       <a class="info-box bg-yellow" href="{{admin_url('orders')}}">
                           <span>{{count($todaysales)}}</span>
                           Today's Orders
                       </a>
                       <a class="info-box bg-red" href="{{admin_url('report/sale')}}?duration=3&day={{date('Y-m-d')}}">
                           <span>{{showPrice($todaysales->sum('grand_total'))}}</span>
                           Today's Sales
                       </a>
                       <a class="info-box bg-lightblue" href="{{admin_url('orders')}}">
                           <span>{{showPrice($todaysales->sum('discount_amount'))}}</span>
                           Today's Discounts
                       </a>

                       <a class="info-box bg-green" id="new-order1" style="cursor: pointer;">
                           New Order
                           <ul class="mainorder_dropdown" style="display:none;">
                               <li id="new-order">Create PO</li> 
                               <li id="new-invoice">Create Invoice</li>
                           </ul>
                       </a>
                       <a class="info-box bg-yellow" href="{{admin_url('customers')}}">
                           <span>{{count($customers)}}</span>
                           New Customers
                       </a>
                       <a class="info-box bg-red" href="{{admin_url('deliveries')}}?date={{date('Y-m-d')}}">
                           <span>{{count($assigneddelivery)}}/{{count($totaldelivery)}}</span>
                           Today's Deliveries
                       </a>
                    </div>
               </div>
           </div>
           <div class="mb-4"></div>
           <div class="row">
               <div class="col-md-6">
                   <div id="orders_daily">
                       
                   </div>
                   <div class="mb-4"></div>
                   <div id="invoices_today">
                       <h3>Today's invoices </h3>
                   </div>
                   <div class="table-list-responsive-md">
                                    <table class="table table-customer mt-0">
                                       
                                       <thead>
                                          <tr>
                           <th>
                              <div>Invoice Id</div> 
                           </th>
                           <th>
                               <div>Customer</div>
                           </th>
                           <th>
                               <div>Discount</div>
                           </th>
                           <th>
                               <div>Grand Total</div>
                           </th>
                       </tr>
                       </thead>
                       <tbody>
                           @foreach($todayinvoices as $invoices)
                           <tr>
                               <td>{{$invoices->invoice_number}}</td>
                               <td>{{$invoices->user->firstname}} {{$invoices->user->lastname}}</td>
                               <td>${{$invoices->discount}}</td>
                               <td>${{$invoices->grand_total}}</td>
                           </tr>
                           @endforeach
                       </tbody>
                       </table>
                       </div>
               </div>
               <div class="col-md-6">
                   <div class="top_products">
                       <h3>Top selling products table</h3>
                   </div>
                   <div class="table-list-responsive-md">
                                    <table class="table table-customer mt-0">
                                       
                                       <thead>
                                          <tr>
                           <th>
                              <div>#</div> 
                           </th>
                           <th>
                               <div>Product</div>
                           </th>
                           <th>
                               <div>SKU</div>
                           </th>
                       </tr>
                       </thead>
                       <tbody>
                           @foreach($topproducts as $product)
                           <tr>
                             <td><img src="{{asset('images/products/'.$product->picture)}}" style="width:50px;height:auto;"></td> 
                             <td>{{$product->name}}</td>
                             <td>{{$product->sku}}</td>
                           </tr>
                           @endforeach
                       </tbody>
                   </table>
                   </div>
               </div>
           </div>

          
      </div>
   </div>
</div>
@include('admin.order.order-modal')
@include('admin.customer.customer-modal')
@include('admin.product.product-modal')
@include('admin.customer.customer-error')
@include('admin.product.addstock')
@include('admin.order.process-modal')
@include('admin.customer.duelist')
@include('admin.order.sent-invoice-modal')
@endsection
@section('bottom-scripts')
<script src="/js/custom.js" ></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
    

// 	 $('#new-order2').click(function() {
// 	$('.mainorder_dropdown').toggle(0);
// }); 
        // Load the Visualization API and the corechart package.
      google.charts.load('current', {'packages':['corechart']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.charts.setOnLoadCallback(drawHourly);
      google.charts.setOnLoadCallback(drawDaily);
      

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      
      function drawHourly() {

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Slices');
        data.addRows([
            @foreach($hourlyorders as $ho)
                ['{{$ho->hour}}', {{$ho->orders}}],
            @endforeach
        ]);

        // Set chart options
        var options = {'title':'Hourly Orders',
                       'height':400,
                        'colors': ['#e0440e', '#e6693e', '#ec8f6e', '#f3b49f', '#f6c7b6'],
                        'is3D': true,
                         'backgroundColor': {
                          'fill': '#efefef',
                          'opacity': 100
                       },
        };

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.ColumnChart(document.getElementById('orders_hourly'));
        chart.draw(data, options);
      }
      
      
      
      function drawDaily() {

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Slices');
        data.addRows([
            @foreach($dailyorders as $do)
                ['{{$do->day}}', {{$do->orders}}],
            @endforeach
        ]);

        // Set chart options
        var options = {'title':'Monthly Orders',
                       'height':400,
                        'colors': ['#e0440e', '#e6693e', '#ec8f6e', '#f3b49f', '#f6c7b6'],
                        'is3D': true,
                        'backgroundColor': {
                          'fill': '#efefef',
                          'opacity': 100
                       }
        };

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.ColumnChart(document.getElementById('orders_daily'));
        chart.draw(data, options);
      }
      
      
      
      
      
      function topProducts() {

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Slices');
        data.addRows([
          @foreach($products as $product)
          ['{{$product->name}}', {{rand(0,100)}}],
          @endforeach
        ]);

        // Set chart options
        var options = {'title':'Top Products',
                       'width':'80%',
                       'height':300};

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('top_products'));
        chart.draw(data, options);
      }
      
      
      function topCustomers() {

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Slices');
        data.addRows([
          @foreach($customers as $customer)
          ['{{$customer->firstname.' '.$customer->lastname}}', {{rand(0,100)}}],
          @endforeach
        ]);

        // Set chart options
        var options = {'title':'Top Customers',
                       'width':'80%',
                       'height':300};

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('top_customers'));
        chart.draw(data, options);
      }
      
      
    </script>
    <script  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA2pKP9bGJRpU-35sWLBgirftfBgLhc03c&callback=initAutocomplete&libraries=places&v=weekly"  async ></script>
@endsection