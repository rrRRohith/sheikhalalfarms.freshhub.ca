@extends('layouts.admin')
@section('title',$submenu .'Customers')
@section('page_title','Customers')
@section('page_nav')

<ul>
    @can('Customer View')
  <li @if($submenu=="All") class="active" @else class=""  @endif><a  href="{{url('admin/customers')}}">All Customers</a></li>
  <li @if($submenu=="Active") class="active" @else class="" @endif><a  href="{{url('admin/customers?status=1')}}">Active Customers</a></li>
  <li @if($submenu=="Inactive") class="active" @else class="" @endif ><a   href="{{url('admin/customers?status=0')}}">Inactive Customers</a></li>@endcan
  @can('Customertype View')<li @if($submenu=="Customertype") class="active" @else class=""  @endif><a  href="{{url('admin/customertype')}}">Customer Types</a> </li>@endcan
</ul>   
@endsection
@section('contents')
<div class="content-container">
    <div class="content-area">
        <div class="row main_content">
            <div class="col-md-12">
                <div class="card no-margin minH">
                    <div class="card-block">
                        <div class="card-title">
                            <h3>Special Prices</h3>
                        </div>
                        <section class="card-text customers_outer">
                            <div class="row filter-customer">
                                <div class="col-lg-12">
                                    <div class="filter-customer-list">
                                        @if (Session::has('message'))
                                        <div class="alert alert-success">
                                            {{ Session::get('message') }}
                                        </div>
                                        @endif

                                        <div class="table-list-responsive-md">
                                            <form action="" method="POST">
                                                @csrf
                                            <table class="table table-customer mt-0">
                                                <thead>
                                                    <tr>
                                                        <th class="text-left">
                                                            <a class="sort" href="#id" data-sort="id" data-direction="desc">
                                                               Product# </a> 
                                                        </th>
                                                        <th class="text-left">Product</th>
                                                        <th>Original Price</th>
                                                        <th>Special Price</th>
                                                        <th>Difference</th>
                                                        <th>Last updated</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody >
                                                    @foreach($products as $product)
                                                    <tr>
                                                        <td>{{$product->id}}</td>
                                                        <td>{{$product->name}}</td>
                                                        <td class="text-right" ><span id="price_{{$product->id}}" data-price="{{$product->price}}">{{showPrice($product->price)}}</span></td>
                                                        <td><input type="number" name="price[{{$product->id}}]" class="special_price" data-id="{{$product->id}}" value="{{str_replace('$','',$product->special_price ?? '')}}" style="width:150px;" id="special_price_{{$product->id}}" /></td>
                                                        <td class="text-right">
                                                            <span class="diff_price" id="diff_price{{$product->id}}">
                                                                @if($product->price >= $product->special_price)
                                                                    <span style="color:green;">{{$product->price-($product->special_price ?? $product->price)}}</span>
                                                                @else
                                                                    <span style="color:red;">{{$product->price-($product->special_price ?? $product->price)}}</span>
                                                                @endif
                                                            
                                                            </span>
                                                        </td>
                                                        <td>{{$product->updated_at ? date('d M Y, H:ia',strtotime($product->updated_at)):''}}</td>
                                                        <td><a href="#" class="btn btn-primary btn-sm white_button remove-button" data-id="{{$product->id}}">Remove</a></td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>   
                                            </table>

                                            <div style="padding: 15px 0;" class="text-right">
                                                <button type="submit" class="btn btn-success green_button">
                                                    Submit
                                                </button>

                                            </div>
                                        </form>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <div class="p-0 col-lg-4 mr-auto paginate d-flex" data-sort="" data-direction=""></div>
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

        $(".remove-button").click(function(e){
            var id = $(this).attr("data-id");
            $("#special_price_"+id).val('');
            $("#diff_price"+id).html('<span style="color:black;">0</span>');
        })

        $(".special_price").change(function(e){

            if($(this).val()=='') {
                $("#diff_price"+pid).html('<span style="color:black;">0</span>');
                return;
            }

            var sprice = $(this).val();
            var pid = $(this).attr("data-id");
            var oprice = $("#price_"+pid).attr("data-price");
            var diff = oprice - sprice;

            if(oprice >= sprice) {
                $("#diff_price"+pid).html('<span style="color:green;">' + diff.toFixed(2) + '</span>');
            }
            else {
                $("#diff_price"+pid).html('<span style="color:red;">' + diff.toFixed(2) + '</span>');
            }
            
        })


    });

</script>
@endsection