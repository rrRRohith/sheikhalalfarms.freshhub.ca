<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css')}}">
    <script src="{{ asset('vendors/jquery/js/jquery.min.js?v=2.1')}}"></script>
    <script type="text/javascript" src="{{ asset('js/bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery-2.2.4.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/jquery.printPage.js')}}"></script>
</head>
<style>

.table {
  font-family: 'Open Sans', sans-serif
}  
.green_button{
 
}



#mailbody {
 
}

#mailproduct {

}
</style>
<body style="background-color:#ffffff;color:#000000;">
    <div class="container mt-5">
        <div class="row form-group">
            
            <div class="col-sm-12 bodymail">
                <div class="row form-group">
                    <div class="mail_header">
                      
                        <h3 id="mailhead" style="text-align: center;font-size: 30px;margin-bottom: 15px;color: #393a3d;">Invoice No:{{$order->invoice->invoice_number}} Details</h3>
                        <center><img src="{{asset('img/freshhub_logo.png')}}" class="header-logo" alt="Fresh Hub" title="Fresh Hub" style="height:50px;margin-top: 10px;margin-bottom:25px;width:auto;"></center>
                    </div>
                    <div class="dueamount_box" style="margin-top: 10px;background: #dce9f1;padding: 25px 10px;width:750px;max-width:95%;margin-left: auto;margin-right: auto;">    
                  <center><h4 id="maildue" style="color: #393a3d;font-size: 16px;line-height:22px;text-transform: uppercase;margin-top: 10px;margin-bottom: 15px;">Due {{date('d - m - Y',strtotime($order->invoice->due_date))}}</h4></center>
                        <center><h3 id="mailamount" style="font-size:35px;margin-top:10px;line-height:40px;font-weight: 500;text-align: center;margin-bottom:35px;">{{showPrice($order->invoice->grand_total)}}</h3></center>
                        <center><a href="{{customer_url('invoices')}}" class="green_button" style="text-decoration:none !important;background-color: #2ca01c !important;border: 2px solid #2ca01c !important;color: #fff !important;padding: 10px 15px !important;line-height:26px;font-size:14px;font-weight: 500;border-radius: 25px;text-decoration:none;">Review and Pay</a></center>
                 
                    </div>
                     
                    <div id="mailbody" style="width:750px;max-width:95%;margin-left: auto;margin-right: auto;padding-top: 20px;padding-bottom: 20px;font-size: 16px;line-height: 32px;">
                        {{$body}}
                        
                    </div>
                    
                
                    <div id="mailtext" style="padding-top: 20px;padding-bottom: 20px;background-color: #f4f5f8;text-align: center;font-family: ArialMT, Arial, Helvetica, Times New Roman; width:750px;max-width:95%;margin-left:auto;margin-right: auto;">
                        <h4 style="font-size:20px;width: 250px;margin-left: auto;margin-right: auto;max-width: 100%;padding-left: 10px;padding-right: 10px;">Bill To : {{$order->user->firstname}} {{$order->user->lastname}}</h4><h4 style="width: 250px;margin-left: auto;margin-right: auto;max-width: 100%;padding-left: 10px;font-size:20px;padding-right: 10px;">@if($order->terms>0) Terms:{{$order->terms}} days @endif</h4>
                
                            





    
    
    
                    </div>
                    <div class="col-sm-12" id="mailproduct" style="width:750px;max-width:95%;margin-left: auto;margin-right: auto;margin-top: 15px;padding-left:15px;padding-right:15px;">
                        <table border="0"style="text-align:left;width: 100%;font-size:15px;line-height:26px;">
                            @php $tot=0;@endphp
                            @foreach($order->item as $item)
                            <tr>
                                <th width="50%" style="text-align:left;">{{$item->product_name}}</th>
                                <td width="50%" rowspan="2" style="text-align:right">{{showPrice($item->total)}}</td>
                            </tr>
                            <tr>
                                <td style="text-align:left;">{{$item->quantity}} * {{showPrice($item->rate)}} {{showPrice($item->tax)}}</td>
                            </tr>
                            @php
                            $tot+=$item->total;
                            @endphp
                            @endforeach
                            <tr>
                                <th style="text-align:left;">Subtotal</th>
                                <td style="text-align:right">{{showPrice($tot)}}</td>
                            </tr>
                            <tr>
                                <th style="text-align:left;">Tax</th>
                                <td style="text-align:right">{{showPrice($order->tax)}}</td>
                            </tr>
                            <tr>
                                <th style="text-align:left;">Discount </th>
                                <td style="text-align:right;">{{showPrice($order->discount_amount)}}</td>
                            </tr>
                            <tr>
                                <th style="text-align:left;">Total</th>
                                <td style="text-align:right;">{{showPrice($order->grand_total)}}</td>
                            </tr>
                            <tr>
                                <th style="text-align:left;">Balance Due</th>
                                <td style="text-align:right">{{showPrice($order->grand_total-$order->paid_amount)}}</td>
                            </tr>
                        </table>
                    </div>
                    
                    
                </div>
            </div>
        </div>
    </div>
</body>
<script type="text/javascript">
    $(document).ready(function(){
    window.print();
    });
</script>
</html>