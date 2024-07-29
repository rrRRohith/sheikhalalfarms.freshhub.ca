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
                                        
                                        @include('admin.reports.filters')
                                        
                                        <div class="table-list-responsive-md">
                                            
                                            <table class="table table-customer">

                                                <thead>
                                                    <tr>
                                                        <!--<th class="text-left">ID</th>-->
                                                        <th class="text-left">Store Name</th>
                                                        <th class="text-left">Purchase Qty</th>
                                                        <th class="text-left">Invoice Total</th>
                                                        <th class="text-left">Paid Total</th>
                                                        <th class="text-center">Due Amount</th>
                                                        <th class="text-center">Overdue Amount</th>
                                                        <!--<th class="text-left">Status</th>-->
                                                        <!--<th class="text-right">Actions</th>-->
                                                    </tr>
                                                </thead>
                                            <tbody>
                                                @php $i=1;@endphp
                                                @php $grandtotal=0;$paidamount=0;$totqty=0;$totdue=0;$totoverdue=0;@endphp
                                                @if(isset($customers) && count($customers)>0)
                                                
                                                @foreach($customers as $c)
                                                @php $qty=0;$dueamount=0;$overdue=0;$totqty1=0;@endphp
                                                  @foreach($c->invoice as $o)
                                                  @php $totqty1+=$o->item->sum('quantity');@endphp
                                                  @if($o->due_date > date('Y-m-d'))
                                                    @php $dueamount+=$o->grand_total-$o->paid_total;@endphp
                                                  @else
                                                    @php $overdue+=$o->grand_total-$o->paid_total;@endphp
                                                  @endif
                                                  @endforeach
                                                    <tr>
                                                        
                                                        <!--<td data-label="" class="text-left">{{$c->id}}</td>-->
                                                        <td class="text-lg-left  text-md-left"data-label="Organization"><label class=""><a data-id="{{$c->id}}" class="orderlist" style="cursor:pointer;">{{$c->business_name ?? $c->firstname.' '.$c->lastname}}</a></label></td>
                                                        <td data-label="City" class="text-left">{{$totqty1}}@php $totqty+=$totqty1; @endphp</td>
                                                        <td data-label="Customer type" class="text-left">{{showPrice($c->invoice->sum('grand_total'))}} @php $grandtotal+=$c->invoice->sum('grand_total'); @endphp</td>
                                                        <td>{{showPrice($c->invoice->sum('paid_total'))}} @php $paidamount+=$c->invoice->sum('paid_total'); @endphp</td>
                                                        <td class="text-center">{{showPrice($dueamount)}} @php $totdue+=$dueamount; @endphp</td>
                                                        <td class="text-center">{{showPrice($overdue)}} @php $totoverdue+=$overdue;@endphp</td>
                                                        
                                                    </tr>
                                                    @php $i++;@endphp
                                                @endforeach
                                                @else
                                                <tr>
                                                    <td colspan="9" class="text-center">No Customers Found</td>
                                                </tr>
                                            @endif
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>Total</th>
                                                    <th>{{$totqty}}</th>
                                                    <th>{{showPrice($grandtotal)}}</th>
                                                    <th>{{showPrice($paidamount)}}</th>
                                                    <th class="text-center">{{showPrice($totdue)}}</th>
                                                    <th class="text-center">{{showPrice($totoverdue)}}</th>
                                                </tr>
                                            </tfoot>
                                            
                                        </table>
                                        
                                        
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    
                </div>
            </div>
        </div>
      </div>
    </div>
</div>
<div id="report_order" style="display: none;">
    <div class="modal_box" style="max-width:1170px;">
        <div class="modal_title">
            <a class="pull-right close"><i class="fa fa-close"></i></a>
            <h3><span id="mhead">Orders</span></h3>
        </div>
        <div class="modal_body" id="orderslist">
            <div class="px-lg-3 no-padding fh_form" id="addAccountForm">
            <!--    <form class="pt-0" id="stock_form" method="post" action="{{admin_url('updatestock')}}">-->
            <!--        @csrf-->
            <!--        <input type="hidden" name="id" id="id">-->
            <!--        <section class="form-block">-->
            <!--            <div class="row">-->
            <!--                <div class="col-md-12">  -->
            <!--                    <div class="form-group row">-->
            <!--                        <div class="col-md-12">-->
            <!--                            <label class="text-gray-dark" for="opportunity_source_id"> Product Name : <span id="prname"></span></label>-->
                                        
                                        
            <!--                        </div>-->
            <!--                    </div>-->
            <!--                    <div class="form-group row">-->
            <!--                        <div class="col-md-12">-->
            <!--                            <label class="text-gray-dark" for="opportunity_source_id"> Stock Quantity</label>-->
            <!--                            <input class="form-control" id="stock" name="stock" type="text" required>-->
                                        
            <!--                        </div>-->
            <!--                    </div>-->
                                
                                
                                
                                
                                
                                
                            
            <!--                </div>-->
                            
            <!--                <div class="col-sm-12">-->
            <!--                    <button type="submit" class="btn btn-success btn-block green_button">-->
            <!--                        <clr-icon shape="floppy"></clr-icon>-->
            <!--                       Save                        -->
            <!--                    </button>-->
                           
            <!--                </div>-->
                               
            <!--        </div>-->
                         
            <!--       </section>-->
                 
                   

                      
                 
            <!--    </form>-->
             </div>
        </div>
        <div class="modal_footer">

        </div>
    </div>
</div>


@endsection
@section('bottom-scripts')
@include('admin.reports.footer')
<script>
    $('.orderlist').click(function(){
        var id=$(this).data('id');
        $.ajax({
            type: "get",
            url: "/admin/report/orderlist?id="+id,
            success: function(data) {
                $('#report_order').show();
                $('#mhead').html('');
                $('#addAccountForm').html(data);
            }
        });
    });
    $('body').delegate('.orderview','click',function(){
        var id=$(this).data('id');
        $.ajax({
            type: "get",
            url: "/admin/report/orderview?id="+id,
            success: function(data) {
                
                $('#mhead').html('Order View');
                $('#addAccountForm').html(data);
            }
        });
    });
    $('body').delegate('.close','click',function(e){
		e.preventDefault();
		$("#report_order").fadeOut(50);
	});
</script>
@endsection
