
<div class="content-container">
   <div class="content-area">
      <div class="row main_content">
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-xs-padding addnew_form">
            <div class="card no-margin minH">
               <div class="card-block">
                   <section class="card-text customers_outer">
                     <div class="row filter-customer">
                           <div class="col-lg-12">
                              <div class="filter-customer-list">
                                 
                                  
                                 <div class="d-flex justify-content-end mb-4">
            <a class="btn btn-success btnprn" href="{{admin_url('printrunsheet')}}/{{$orders[0]->runsheet_id}}">Print</a>
            
        </div>
        
        <div class="row">
            <div class="col-12">
                <label class="font-weight-bold">Driver Name : {{$orders[0]->driver->firstname}} {{$orders[0]->driver->lastname}}</label>
            </div>
            <br>
            <div class="col-12">
                <label class="font-weight-bold"> Date : {{date('F d Y',strtotime($orders[0]->shipping_date))}}</label>
            </div
            <br>
                                 
                                @if(isset($orders) && count($orders)>0)
                                <div class="table-list-responsive-md">
                                    <table class="table table-customer mt-0">
                                       
                                       <thead>
                                          <tr>
                                             
                                             <th>
                                              #
                                             </th>
                                             <th class="text-left">
                                                Order No
                                             </th>
                                             
                                             <th class="text-left">Customer</th>
                                             <th class="text-left">
                                                Address
                                             </th>
                                             <th class="text-left">Phone</th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                           @php $id=1; @endphp
                                           @foreach($orders as $order)
                                           <tr>
                                               
                                               <td>
                                                   {{$id}}
                                               </td>
                                               <td>
                                                   {{$order->order_id}}
                                               </td>
                                               <td>
                                                  {{$order->user->firstname}}  {{$order->user->lastname}}
                                               </td>
                                               <td>
                                                  {{$order->billing_address}}
                                               </td>
                                               <td>
                                                   {{$order->user->phone}}
                                               </td>
                                           </tr>
                                           @php $id++; @endphp
                                           @endforeach
                                       </tbody>
                                    
                                    </table>
                                 </div>
                                 
                                 
                                 @endif
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


@section('bottom-scripts')
<script type="text/javascript">
$(document).ready(function(){
window.print();
</script>
@endsection