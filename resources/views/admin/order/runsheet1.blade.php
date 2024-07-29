<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="css/bootstrap.css">
    <script src="/vendors/jquery/js/jquery.min.js?v=2.1"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="{{ asset('js/jquery-2.2.4.min.js')}}"></script>
    <script type="text/javascript" src="js/jquery.printPage.js"></script>
</head>
<style>

.table {
  font-family: 'Open Sans', sans-serif
}  
</style>

<body style="background-color:#ffffff;color:#000000;">
    <div class="container mt-5">
        <h2 class="text-center mb-3"></h2>
        

        <div class="d-flex justify-content-end mb-4">
           
        </div>
        <div class="logo text-center padding-side-30">
            <img src="{{asset('img/freshhub_logo.png')}}" alt="FreshHub logo" style="width:250px;height:auto;">
        </div>
        <h2 class="text-center"><label class="font-weight-bold" style="font-family: 'Open Sans', sans-serif;font-size:25px;">Runsheets</label></h2>
        <div class="row">
            <div class="col-12">
               <label class="font-weight-bold" style="font-family: 'Open Sans', sans-serif;font-size:16px;">Driver Name : {{$orders[0]->driver->firstname}} {{$orders[0]->driver->lastname}}</label>
            </div>
            <br>
            <div class="col-12">
                <label class="font-weight-bold" style="font-family: 'Open Sans', sans-serif;font-size:16px;"> Date : {{date('F d Y',strtotime($orders[0]->shipping_date))}}</label>
            </div>
        </div>
        <br>
        <table class="table table-bordered mb-5" cellspacing="0" cellpadding="5" border="1">
          <tr>
            <th  scope="col">#</th>
            <!-- <th  scope="col">PO</th>-->
            <th  scope="col"> Invoice No</th>
             <th  scope="col"> Store Name</th>
            <th  scope="col">Contact Name</th>
            <th  scope="col"> Shipping Address</th>
            <th  scope="col">Phone</th>
            <th scope="col">Cases Of Delivery</th>
            <th scope="col">Weight</th>
            <th scope="col">Invoice Amount</th>
            <th scope="col" width="10%">Signature</th>
            <!--<th scope="col">Payment Method</th> -->
                                               
          
            
          </tr>
          @php $id=1; @endphp
            @foreach($orders as $order)
            @php $address=" {$order->delivery->address}, {$order->delivery->city}, {$order->delivery->province}, {$order->delivery->postalcode}"; @endphp
          <tr>
            <td scope="row">{{$id}}</td>
            <!--<td scope="row">PO{{$order->id}}</td>-->
             <td scope="row">{{$order->invoice->invoice_number}}</td>
              <td scope="row"> {{$order->user->business_name}}</td>
            <td scope="row">{{$order->user->firstname}}  {{$order->user->lastname}}</td>
            <td scope="row">
                                                      {{$address}}
                                                    </td>
            <td scope="row">{{$order->user->phone}}</td>
            <td scope="row" class="text-center">
                {{$order->item->sum('quantity')}}
            </td>
            <td scope="row" class="text-center">
                {{getWeight($order->item->sum('weight')).' '.defWeight()}}
            </td>
              <td scope="row">
                 ${{$order->grand_total}}
            </td>
            <td></td>
            <!--  <td scope="row">-->
            <!--      {{$order->user->paymentmethod->name}}-->
            <!--</td>-->
          
          </tr>
          @php $id++; @endphp
         @endforeach
          
          
        </table>
</div>
    </body>
    
</html>
<script type="text/javascript">
$(document).ready(function(){
window.print();
});
</script>