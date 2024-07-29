@extends('layouts.admin')
@section('title',$submenu)
@section('page_title','Dashboard')
@section('page_nav')
<ul>
    <li class="active"><a href="{{customer_url('')}}">Dashboard</a></li>
    <li><a href="{{customer_url('profile')}}">Profile</a></li>  
    <li><a href="{{customer_url('changepassword')}}">Change Password</a></li>
</ul>
@endsection
@push('styles')
<style>
    #dashboard {
        display: flex;
        flex-direction: row;
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
</style>
@endpush
@section('contents')
<div class="content-container">
   <div class="content-area">
      <div id="dashboard">
          <div class="boxes-column">
                <div class="box">
                    <div class="box-title">
                        <h3>Latest Orders</h3>
                    </div>
                      @if(isset($orders) && count($orders)>0)
                    <div class="box-body">
                        <table class="table" style="width:100%">
                            <tr>
                                <th>PO</th>
                                <th>Customer</th>
                                <th>Amount</th>
                                <th>Date</th>
                            </tr>
                            @foreach($orders as $order)
                            <tr>
                                <td>{{$order->id}}</td>
                                <td>{{$order->user->firstname.' '.$order->user->lastname}}</td>
                                <td>{{$order->grand_total}}</td>
                                <td>{{date('d M Y',strtotime($order->created_at))}}</td>
                            </tr>
                            @endforeach
                        </table>
                        
                    </div>
                    @else
                    <h5 class="text-danger text-center font-weight-bold"><font color="red">No Results Found</font></h5>
                    @endif
                </div>
                <div class="box">
                    <div class="box-title">
                        <h3>Invoices</h3>
                    </div>
                      @if(isset($invoices) && count($invoices)>0)
                    <div class="box-body">
                        <table class="table" style="width:100%">
                            <tr>
                                <th>Invoice No</th>
                                <th>Customer</th>
                                <th>Amount</th>
                                <th>Due Date</th>
                            </tr>
                            @foreach($invoices as $invoice)
                            <tr>
                                <td>{{$invoice->id}}</td>
                                <td>{{$invoice->user->firstname.' '.$invoice->user->lastname}}</td>
                                <td>{{$invoice->grand_total}}</td>
                                <td>{{date('d M Y',strtotime($invoice->due_date))}}</td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                    @else
                   <h5 class="text-danger text-center font-weight-bold"><font color="red">No Results Found</font></h5>
                    @endif
                </div>
               
          </div>
          <div class="boxes-column">
                <div class="box">
                    <div class="box-title">
                        <h3>Daily Orders</h3>
                    </div>
                    <div class="box-body">
                        <div id="daily_orders"></div>
                    </div>
                </div>
                <div class="box">
                    <div class="box-title">
                        <h3>Monthly Orders</h3>
                    </div>
                    <div class="box-body">
                        <div id="monthly_orders"></div>
                    </div>
                </div>
                <div class="box">
                    <div class="box-title">
                        <h3>Top Products</h3>
                    </div>
                    <div class="box-body">
                        <div id="top_products"></div>
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
      google.charts.setOnLoadCallback(drawMonthly);
      google.charts.setOnLoadCallback(drawDaily);
      google.charts.setOnLoadCallback(topProducts);
      google.charts.setOnLoadCallback(topCustomers);

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawMonthly() {

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Slices');
        data.addRows([
          ['Jan', 14],
          ['Feb', 31],
          ['Mar', 28],
          ['Apr', 47],
          ['May', 45],
          ['Jun', 56],
          ['Jul', 59],
          ['Aug', 51],
          ['Sep', 52],
        ]);

        // Set chart options
        var options = {'title':'Monthly Orders',
                       'width':'80%',
                       'height':300,
                        'colors': ['#e0440e', '#e6693e', '#ec8f6e', '#f3b49f', '#f6c7b6'],
                        'is3D': true,
        };

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.ColumnChart(document.getElementById('monthly_orders'));
        chart.draw(data, options);
      }
      
      
      function drawDaily() {

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Slices');
        data.addRows([
          ['Sep 10', 31],
          ['Sep 11', 28],
          ['Sep 13', 47],
          ['Sep 13', 45],
          ['Sep 14', 56],
          ['Sep 15', 59],
          ['Sep 16', 51],
          ['Sep 17', 52],
        ]);

        // Set chart options
        var options = {'title':'Daily Orders',
                       'width':'80%',
                       'height':300};

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.ColumnChart(document.getElementById('daily_orders'));
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