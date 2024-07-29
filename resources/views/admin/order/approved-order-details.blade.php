@extends('layouts.admin')
@section('title','Orders')
@section('page_title','Sales & Financials')
@section('page_nav')
<ul>
    <li class="active"><a href="{{admin_url('orders')}}">All Orders</a></li>
    <li><a  href="{{admin_url('invoices')}}">Invoices</a>
    <li><a  href="{{admin_url('backorders')}}">Backorders</a></li>
    <li><a href="{{admin_url('getrunsheet')}}">Generate Runsheet</a></li>
</ul>
@endsection
@section('contents')
<div class="content-container">
   <div class="content-area">
      <div class="row main_content">
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-xs-padding">
            <div class="card no-margin minH">
               <div class="card-block">
                   <section class="card-text customers_outer">
                     <div class="row filter-customer">
                           <div class="col-lg-12">
                              <div class="filter-customer-list">
                                 @if (Session::has('message'))
                                 <div class="alert alert-success">
                                    <font color="red" size="4px">{{ Session::get('message') }}</font>
                                 </div>
                                 
                                 @endif
                                 <div class="table-list-responsive-md">
                                    <table class="table table-customer mt-0">
                                       <thead class="table-list-header-options">
                                           <tr>
                                              <td>
                                              </td>
                                          </tr>
                                       </thead>
                                       <thead>
                                          <tr>
                                             <th>
                                              #
                                             </th>
                                             <th class="text-left">
                                                Item
                                             </th>
                                             
                                             <th class="text-left">Quantity</th>
                                              <th class="text-left">
                                                Stock
                                             </th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                       @php $i=1;@endphp
                                     
                                      @foreach($orderitems as $orderitem)
                                         
                                          <tr >
                                             <td>
                                              {{$i}}
                                             </td>
                                             

                                             
                                             <td class="text-right">
                                             
                                                {{$orderitem->name}}
                                              
                                             </td>
                                             <td> {{$orderitem->quantity}}</td>
                                             @if(isset($orderitem->stock))
                                             <td>{{$orderitem->stock->quantity}}</td>
                                             @endif
                                          </tr>
                                             @php $i++;@endphp
                                        @endforeach
                                        
                                 
                                       </tbody>
                                    
                                    </table>
                                 </div>
                                 
                              </div>
                              <br>
                                <div class="text-center">
                                          <a href="{{admin_url('orders')}}"><button  type="submit">Back</button></a> 
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