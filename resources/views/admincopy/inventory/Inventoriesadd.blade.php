@extends('layouts.admin')
@section('title',isset($inventory) ? 'Edit Inventory' :'Add Inventory')
@section('page_title','Inventories')
@section('page_nav')
<ul>
     <li class="active"><a href="{{admin_url('inventories')}}">Inventories</a></li>  
    <li><a href="{{admin_url('warehouse')}}">Warehouses</a></li>
     <li><a href="{{url('admin/inventories/current-stock')}}">Stock</a>
   
</ul>
@endsection
<style>
    .productrows{
        border: 1px solid black;
    padding-left: 20px;
    padding-right: 20px;
    }
    .del{
        background-color:red;
        border-color:red;
    }
</style>
@section('contents')
<div class="content-container">
   <div class="content-area">
      <div class="row">
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-xs-padding">
            <div class="card no-margin minH">
               <div class="card-block">
                  
                  <section class="card-text">
                     <div class="px-lg-3 " id="addAccountForm">
                        <form class="pt-0" id="form" method="post"
                           action="@if(isset($inventory)){{admin_url('inventories/'.$inventory->id)}}@else{{admin_url('inventories')}}@endif">
                           @if(isset($inventory))
                           @method('PUT')
                           @endif
                           @csrf
                           <section class="form-block">
                              <div class="separator">
                                 <label class="separator-text separator-text-success">Inventory Details</label>
                              </div>
                              <div class="form-group row">
                                 
                                 <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12 text-right no-md-padding">
                                    <label class="text-gray-dark"
                                       for="opportunity_source_id"> Warehouse</label>
                                 </div>
                                 <div class="col-lg-3 col-md-3 col-sm-12">
                                    <select name="warehouse_id" id="warehouse_id" class="form-control">
                                       <option value="">Select Warehouse</option>
                                       @foreach($warehouses as $p)
                                       <option value="{{$p->id}}" <?php if(isset($inventory)){if(($inventory->warehouse_id)==($p->id)){?> selected <?php }}?> >{{$p->name}}</option>
                                       @endforeach
                                    </select>
                                    @if ($errors->has('warehouse_id'))
                                    <strong>{{ $errors->first('warehouse_id') }}</strong>
                                    @endif
                                 </div>
                                 <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12 text-right no-md-padding">
                                    <label class="text-gray-dark"
                                       for="opportunity_source_id"> Reference Number</label>
                                 </div>
                                 <div class="col-lg-3 col-md-3 col-sm-12">
                                    <input class="form-control" id="reference_number"
                                           value="{{old('reference_number',isset($inventory)?$inventory->reference_number:'')}}"
                                           name="reference_number" placeholder="Reference Number">
                                    @if ($errors->has('reference_number'))
                                    <strong>{{ $errors->first('reference_number') }}</strong>
                                    @endif
                                 </div>
                                 <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12 text-right no-md-padding">
                                    <label class="text-gray-dark"
                                       for="opportunity_source_id"> From</label>
                                 </div>
                                 <div class="col-lg-3 col-md-3 col-sm-12">
                                    <input class="form-control" id="from_details"
                                           value="{{old('from_details',isset($inventory)?$inventory->from_details:'')}}"
                                           name="from_details" placeholder="From Details">
                                    @if ($errors->has('from_details'))
                                    <strong>{{ $errors->first('from_details') }}</strong>
                                    @endif
                                 </div>
                              </div>
                              <label>Inventory Items</label>
                              <div class="productrows">
                                  @php $i=0;@endphp
                                  @if(isset($inventory))
                                  @foreach($inventory->product as $products)
                                  <div class="form-group row" id="row-{{$i}}">
                                     <div class="col-lg-4 col-md-4 col-sm-12">
                                        <select name="product_id[]" id="product_id-{{$i}}" class="form-control productname">
                                           <option value="">Select the product</option>
                                           @foreach($product as $p)
                                           <option value="{{$p->id}}" @if($p->id==$products->product_id) selected @endif>{{$p->name}}</option>
                                           @endforeach
                                        </select>
                                        
                                     </div>
                                     <div class="col-lg-4 col-md-4 col-sm-12">
                                        <input class="form-control" id="stock_qty-{{$i}}"
                                           value="{{$products->quantity}}"
                                           name="stock_qty[]" placeholder="Quantity">
                                        
                                     </div>
                                     <div class="col-lg-3 col-md-3 col-sm-12">
                                        <input class="form-control" id="amount-{{$i}}"
                                           value="{{$products->amount}}"
                                           name="amount[]" placeholder="Amount">
                                        
                                     </div>
                                     <div class="col-lg-1 col-md-1 col-sm-12">
                                        <a class="btn btn-success del" data-id="{{$i}}">-</a>
                                        
                                     </div>
                                  </div>
                                  @php $i++; @endphp
                                  @endforeach
                                  @else
                                  <div class="form-group row" id="row-0">
                                     <div class="col-lg-4 col-md-4 col-sm-12">
                                        <select name="product_id[]" id="product_id-0" class="form-control productname">
                                           <option value="">Select the product</option>
                                           @foreach($product as $p)
                                           <option value="{{$p->id}}">{{$p->name}}</option>
                                           @endforeach
                                        </select>
                                        
                                     </div>
                                     <div class="col-lg-4 col-md-4 col-sm-12">
                                        <input class="form-control" id="stock_qty-0"
                                           value=""
                                           name="stock_qty[]" placeholder="Quantity">
                                        
                                     </div>
                                     <div class="col-lg-3 col-md-3 col-sm-12">
                                        <input class="form-control" id="amount-0"
                                           value=""
                                           name="amount[]" placeholder="Amount">
                                        
                                     </div>
                                     <div class="col-lg-1 col-md-1 col-sm-12">
                                        <a class="btn btn-success del" data-id="0">-</a>
                                        
                                     </div>
                                  </div>
                                  @endif
                                  <div class="form-group row" id="addrow">
                                      <div class="col-lg-3 col-md-3 col-sm-12">
                                        <a class="btn btn-success" id="addrow1"><clr-icon
                                          shape="plus"></clr-icon>Add More</a>
                                      </div>    
                                  </div>
                                  <input type="hidden" id="id" value="{{$i}}" name="id">
                              </div>
                           </section>
                           <section>
                              <div class="form-group row">
                                 <div class="offset-lg-1 col-lg-3 col-sm-4 col-xs-6">
                                    <button type="submit"
                                       class="btn btn-success btn-block">
                                       <clr-icon
                                          shape="floppy"></clr-icon>
                                       Save                        
                                    </button>
                                 </div>
                              </div>
                           </section>
                        </form>
                     </div>
                  </section>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>


@endsection
@section('bottom-scripts')
<script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js" ></script>
<script>
$(document).ready(function() {
    $('#addrow1').on('click',function(){
        var id=Number($('#id').val())+1;
        $('#id').val(id);
        var html='<div class="form-group row" id="row-'+id+'"><div class="col-lg-4 col-md-4 col-sm-12"><select name="product_id[]" id="product_id-'+id+'" class="form-control"><option value="">Select the product</option></select></div><div class="col-lg-4 col-md-4 col-sm-12"><input class="form-control" id="stock_qty-'+id+'" value="" name="stock_qty[]" placeholder="Quantity"></div><div class="col-lg-3 col-md-3 col-sm-12"><input class="form-control" id="amount-'+id+'" value="" name="amount[]" placeholder="Amount"></div><div class="col-lg-1 col-md-1 col-sm-12"><a class="btn btn-success del" data-id="'+id+'">-</a></div></div>';
        $('#addrow').before(html);
        $.ajax({
                url:"{{admin_url('getproduct')}}",
                type:"GET",
                dataType:"json",
                success:function(data)
                {
                    $.each(data, function(key, value) {   
     $('#product_id-'+id)
         .append($("<option></option>")
                    .attr("value", value.id)
                    .text(value.name)); 
});
                }
        });
    })
    $('.del').on('click',function(){
       var id=$(this).data('id'); 
       alert(id);
       $('#row-'+id).remove();
    });
});
</script>
@endsection