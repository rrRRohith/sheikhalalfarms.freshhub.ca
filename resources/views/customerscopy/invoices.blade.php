@extends('layouts.customer.header')
@section('contents')
<div class="content-container">
   <div class="content-area">
      <div class="row">
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-xs-padding">
            <div class="card no-margin minH">
               <div class="card-block">
                  <div class="card-title">
                     <div class="card-title-header">
                        <div class="card-title-header-titr"><b> Invoices </b></div>
                        <div class="card-title-header-between"></div>
                        <div class="card-title-header-actions">
                           <a href="#"><img src="{{asset('img/help.svg')}}" alt="help"
                              class="card-title-header-img card-title-header-details"></a>
                        </div>
                     </div>
                  </div>
                  <section class="card-text">
                     <section class="card-text">
                        <div class="row filter-customer">
                           <div class="col-lg-12">
                              <div class="filter-customer-list">
                                 @if (Session::has('message'))
                                 <div class="alert alert-success">
                                    <font color="red" size="4px">{{ Session::get('message') }}</font>
                                 </div>
                                 @endif
                                 <div class="table-list-responsive-md">
                                    <table class="table table-list mt-0">
                                       <thead class="table-list-header-options">
                                          <tr>
                                             <td colspan="5">
                                                
                                             </td>
                                             <td colspan="5">

                                             <!--<button id="myBtn">Open Modal</button>-->
                                             <!--<button id="myBtn" class="btn btn-success pull-right"><clr-icon shape="plus-circle"></clr-icon>-->
                                             <!--   New order  -->
                                             <!--   </button>-->
                                                <!--<a href=""-->
                                                <!--   class="btn btn-success pull-right">-->
                                                <!--   <clr-icon shape="plus-circle"></clr-icon>-->
                                                <!--   New order                           -->
                                                <!--</a>-->
                                               
                                               
                                                
                                             </td>
                                          </tr>
                                       </thead>
                                       <thead>
                                          <tr>
                                             
                                             <th >
                                                Date
                                             </th>
                                             <th>
                                                No
                                             </th>
                                             <th>
                                                Customer
                                             </th>
                                             <th>
                                                Amount
                                             </th>
                                             
                                             <th>
                                                Due Amount
                                             </th>
                                             <th class="text-right">Actions</th>
                                          </tr>
                                          @foreach($orders as $order)
                                          <tr>
                                             
                                             <td>
                                                {{date('d F Y',strtotime($order->order_date))}}
                                             </td>
                                             <td>
                                                {{$order->order_id}}
                                             </td>
                                             <td>
                                                {{$order->firstname}} {{$order->lastname}}
                                             </td>
                                             <td>
                                               {{$order->grand_total}}
                                             </td>
                                             
                                             <td >
                                               {{$order->grand_total-$order->paid_amount}}
                                             </td>
                                             <td class="text-right">
                                                  <label>
                                                   @if($order->status==0)
                                                   <a target="" href="{{customer_url('orders/changestatus')}}/{{$order->id}}" data-tooltip="Confirm Order" rel="tooltip">
                                                      <clr-icon shape="check" size="22"></clr-icon>
                                                   </a>
                                                   <button class="edit_modal" value="{{$order->id}}"><clr-icon shape="pencil" size="22"></clr-icon></button>
                                                   <!--<a target="" href="{{admin_url('orders')}}/{{$order->id}}/edit" class="icon-table" rel="tooltip" data-tooltip=" Edit">-->
                                                   <!--   <clr-icon shape="pencil" size="22"></clr-icon>-->
                                                   <!--</a>-->
                                                    @else
                                                    <label>
                                                   <a target="" href="{{customer_url('orders')}}/{{$order->id}}/generateinvoice" class="icon-table" rel="tooltip" data-tooltip="View Invoice">
                                                      <clr-icon shape="list" size="22"></clr-icon>
                                                   </a>
                                                </label>
                                                   @endif
                                                </label>
                                                <!--<label>-->
                                                <!--   <a target="" href="{{customer_url('invoices')}}/{{$order->id}}/del" class="icon-table" rel="tooltip" data-tooltip=" Delete">-->
                                                <!--      <clr-icon shape="trash" size="22"></clr-icon>-->
                                                <!--   </a>-->
                                                <!--</label>-->
                                             </td>
                                          </tr>
                                          @endforeach
                                       </thead>
                                       <tbody>
                                         
                                       </tbody>
                                    </table>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </section>
                  </section>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection