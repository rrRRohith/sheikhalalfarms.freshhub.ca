@extends('layouts.customer')
@section('title',($submenu ?? '') .'Dashboard')
@section('page_title','Dashboard')
@section('page_nav')
<ul>
    <li class="active"></li>
      
</ul>
@endsection
@push('styles')
<style>
    #dashboard {
       width:100%;
    }
    
    .boxes-column {
        width: 50%;
    }
    
    .box {
        border:1px solid #DDD;
        padding: 15px;
    }
    
    .box-body {
        overflow: hidden;
    }
    
    a.info-box {
        font-size: 150%;
        display:flex;
        flex-direction: column;
        align-items: center;
        width: 33%;
        margin:15px;
        padding: 15px;
        justify-content:center;
        color: #FFF;
    }
    
    .info-box span {
        font-size: 300%;
        
    }
    
    .bg-green {
        background: Turquoise;
    }
    
    .bg-blue {
        background: RoyalBlue;
    }
    
    .bg-yellow {
        background: Gold;
    }
    
    .bg-red {
        background: Red;
    }
    
    .bg-lightblue {
        background: DeepSkyBlue;
    }
    
    .info-boxes {
        display: flex;
        flex-direction: row;
        align-items:stretch;
    }

    .border {
      1px solid #CCC;
    }
</style>
@endpush

@section('contents')
<div class="content-container">
   <div class="content-area">
      <div id="dashboard">
          
           <div class="row">
               
               <div class="col-sm-12">
                   <div class="info-boxes">
                       <a class="info-box bg-yellow" href="{{customer_url('orders')}}">
                           <span>{{count($todaysales)}}</span>
                           Monthly Orders
                       </a>
                       <a class="info-box bg-red" href="{{customer_url('orders')}}">
                           <span>${{round($todaysales->sum('grand_total'),2)}}</span>
                           Monthly Sales
                       </a>
                       <a class="info-box bg-lightblue" href="{{customer_url('orders')}}">
                           <span>${{$todaysales->sum('discount_amount')}}</span>
                           Monthly Discounts
                       </a>
                    </div>
                   <!-- <div class="info-boxes">-->
                   <!--    <a class="info-box bg-green" href="{{admin_url('orders')}}">-->
                   <!--        New Order-->
                   <!--    </a>-->
                   <!--    <a class="info-box bg-yellow" href="{{admin_url('customers')}}">-->
                   <!--        <span>{{count($customers)}}</span>-->
                   <!--        New Customers-->
                   <!--    </a>-->
                   <!--    <a class="info-box bg-red" href="{{admin_url('runsheets')}}">-->
                   <!--        <span>{{count($todaydelivery)}}</span>-->
                   <!--        Today's Deliveries-->
                   <!--    </a>-->

                   <!--</div>-->
               </div>
           </div>
           <div class="mb-4"></div>
           <div class="row">
               <div class="col-sm-6">
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
                           @if(isset($todayinvoices) && count($todayinvoices))
                           @foreach($todayinvoices as $invoices)
                           <tr>
                               <td>{{$invoices->id}}</td>
                               <td>{{$invoices->user->firstname}} {{$invoices->user->lastname}}</td>
                               <td>${{$invoices->discount}}</td>
                               <td>${{$invoices->grand_total}}</td>
                           </tr>
                           @endforeach
                           @else
                           <tr><th colspan="4"><center>No Invoices Found</center></th></tr>
                           @endif
                       </tbody>
                       </table>
                       </div>
               </div>
               <div class="col-sm-6">
                   <div class="top_products">
                       <h3>Top Purchased products table</h3>
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
@endsection
@section('bottom-scripts')
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
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
@endsection