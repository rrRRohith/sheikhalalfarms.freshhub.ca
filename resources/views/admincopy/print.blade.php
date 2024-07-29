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

    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/jquery-2.2.4.min.js"></script>
    <script type="text/javascript" src="js/jquery.printPage.js"></script>
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center mb-3"></h2>

        <!--<div class="d-flex justify-content-end mb-4">-->
        <!--    <a class="btn btn-primary btnprn" href="{{url('/print')}}">Print</a>-->
        <!--</div>-->

        <table class="table table-bordered mb-5">
          <tr>
            <th  scope="col">Name</th>
            <th  scope="col">Address</th>
            <th  scope="col">City</th>
            <th  scope="col">Phone</th>
            <th  scope="col">Qty</th>
            <th  scope="col">Invoice Number</th>
            <th  scope="col">Amount</th>
            
          </tr>
          <tr>
            <td scope="row">Alfreds Futterkiste</td>
            <td scope="row">Flat no:34</td>
            <td scope="row">Toronto</td>
            <td scope="row">8787878765</td>
            <td scope="row">10</td>
            <td scope="row">#45345</td>
            <td scope="row">5000</td>
          </tr>
          
          <tr>
            <td scope="row">Jake Musk</td>
            <td scope="row">Flat no:35</td>
            <td scope="row">Toronto</td>
            <td scope="row">8765676548</td>
            <td scope="row">6</td>
            <td scope="row">#787678</td>
            <td scope="row">3000</td>
          </tr>
          
        </table>

    </body>
    
</html>