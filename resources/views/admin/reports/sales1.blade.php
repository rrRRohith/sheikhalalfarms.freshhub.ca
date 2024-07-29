@extends('layouts.admin')
@section('title','Customers Report')
@section('page_title','Report')
@section('page_nav')

<ul>
  <li @if($submenu=='ReportByCustomer') class="active" @else class=""  @endif><a  href="{{admin_url('report/customer')}}">Customers</a></li>
  <li @if($submenu=="ReportBySale") class="active" @else class="" @endif><a  href="{{admin_url('report/sale')}}">Sales</a></li>
  <li @if($submenu=="ReportByProduct") class="active" @else class="" @endif ><a   href="{{admin_url('report/product')}}">Products</a></li>
  
</ul>   
@endsection
@section('contents')
<div class="content-container">
    <div class="content-area">
        <div class="row main_content">
            <div class="col-md-12">
                <div class="card no-margin minH">
                    <div class="card-block">
                        
                        <section class="card-text customers_outer">
                            <div class="row filter-customer">
                                <div class="col-lg-12">
                                    <div class="filter-customer-list">
                                        @if (Session::has('message'))
                                        <div class="alert alert-success">
                                            {{ Session::get('message') }}
                                        </div>
                                        @endif
                                        
                                        <form action="" method="get" id="filter_form">
                                            @csrf
                                            <div class="row">
                                                
                                                <div class="col-sm-3">
                                                    <label class="control-label">Duration</label>
                                                    <select name="duration" id="duration" class="form-control">
                                                        <option value="">All</option>
                                                        <option value="0">Day</option>
                                                        <option value="1">Week</option>
                                                        <option value="2">Custom</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-3">
                                                 <label class="control-label">Category</label>
                                                    <select name="category" id="category" class="form-control">
                                                        <option value="">All</option>
                                                        <option value="0">Day</option>
                                                        <option value="1">Week</option>
                                                        <option value="2">Custom</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-2">
                                                    <label class="control-label">Status</label>
                                                    <select name="status"  class="form-control">
                                                        <option value="2" @if(isset(Request()->status) && (Request()->status==2)) selected @endif>All</option>
                                                        <option value="1" @if(isset(Request()->status) && (Request()->status==1)) selected @endif>Active</option>
                                                        <option value="0" @if(isset(Request()->status) && (Request()->status==0)) selected @endif>Inactive</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-2">
                                                    <label class="control-label">&nbsp;</label><br/>
                                                    <button  class="white_button" type="submit">Filter Customers</button>
                                                </div>
                                            </div>
                                        </form>
                                        
                                        <div class="table-list-responsive-md">
                                     
                                    <table class="table table-customer mt-0">
                                       <thead>
                                          <tr>
                                             <th class="text-left">#</th>
                                             <th class="text-left"> #PO/Invoice </th>
                                             <th class="text-left">  Store Name</th>
                                             <th class="text-center">Ordering Date</th>
                                             <th class="text-center">Delivery Date</th>
                                             <th class="text-center"> Case Quantity </th>
                                             <th class="text-center">Total weight </th>
                                              <th class="text-right"> Amount </th>
                                             <!--<th class="text-center"> Status </th>-->
                                             <!--<th class="text-right">Actions</th>-->
                                          </tr>
                                          </thead>
                                          @if(isset($sales) && count($sales)>0)
                                          @foreach($sales as $order)
                                          <tr>
                                             <!--<td class="text-left">{{$order->id}}</td>-->
                                             <td class="text-left"><input type="checkbox" name="id[]" id="id-{{$order->id}}" value="{{$order->id}}" @if($order->status >= 4) disabled @endif class="print_check"></td>
                                             <td class="text-left">
                                                 @if($order->status > 3 && $order->invoice->id != '')
                                                 <a href="{{admin_url('orders/'.$order->invoice->id.'/generateinvoice')}}">
                                                 {{$order->invoice->invoice_number}}</a>
                                                 @else
                                                 <a href="{{admin_url('orders/orderdetails')}}/{{$order->id}}">
                                                 PO{{$order->id}}</a>
                                                 @endif
                                            </td>
                                              <td class="text-left text-bold"><a href="{{admin_url('customers')}}/{{$order->user_id}}/edit">
                                                @if($order->business_name !='')
                                                {{$order->business_name }}
                                                @else
                                                {{$order->user->firstname . ' ' . $order->user->lastname}}
                                                @endif
                                                </a>
                                             </td> 
                                             <td class="text-center">
                                                {{date('d M y h:ia',strtotime($order->order_date))}}
                                            </td>
                                            <td class="text-center">
                                                @if(strtotime($order->shipping_date) < time())
                                                    <span class="text-danger">{{date('D d M',strtotime($order->shipping_date))}}</span>
                                                @else
                                                    {{date('D d M',strtotime($order->shipping_date))}}
                                                @endif
                                            </td>
                                             <td class="text-center">
                                                {{$order->item->sum('quantity')}}
                                             </td>
                                             <td class="text-center">
                                                  @if($order->status > 3)
                                                    {{$order->item->sum('weight').defWeight()}}
                                                  @else
                                                    -
                                                  @endif
                                             </td>
                                             <td class="text-right">
                                                @if($order->status > 3)
                                                    {{showPrice($order->grand_total)}}
                                                @else
                                                    -
                                                @endif
                                             </td>
                                             
                                             
                                          </tr>
                                          @endforeach
                                           
                                          @else
                                          <tr>
                                              <td colspan="9"><center>No Orders Found !!</center></td>
                                          </tr>
                                          @endif
                                       </thead>
                                       <tbody>
                                       </tbody>
                                    </table>
                                        <!--<div class="text-right"><button type="submit" name="submit" class="green_button" target="_blank"><i class="fa fa-print" aria-hidden="true"></i> Print</button></div>-->
                                 </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <div class="text-bold" style="padding:10px;"> {{$sales->links()}}Showing Page {{$sales->currentPage()}} of {{$sales->lastPage()}} </div>
                </div>
            </div>
        </div>
      </div>
    </div>
</div>


@endsection
