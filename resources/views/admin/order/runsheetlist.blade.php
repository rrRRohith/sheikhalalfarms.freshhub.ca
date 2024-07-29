@extends('layouts.admin')
@section('title','Runsheets')
@section('page_title','Deliveres')
@section('page_nav')
<ul>
    <li  class="active"><a href="{{admin_url('deliveries')}}">Generate Runsheet</a></li>
    <li><a  href="{{admin_url('runsheets')}}">Runsheets</a>
</ul>
@endsection
@section('contents')
<div class="content-container">
   <div class="content-area">
      <div class="row main_content">
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-xs-padding addnew_form">
            <div class="card no-margin minH">
              <div class="card-block">
                  <div class="card-title">
                   
                    <h3>Runsheets</h3>
                  </div>
                   <section class="card-text customers_outer">
                     <div class="row filter-customer">
                           <div class="col-lg-12">
                              <div class="filter-customer-list">
                               @if (Session::has('message'))
                               <div class="alert alert-success">
                                  <font color="red" size="4px">{{ Session::get('message') }}</font>
                               </div>
                               @endif
                                
                               
                                @if(isset($runsheets) && count($runsheets)>0)
                                <div class="table-list-responsive-md">
                                    <table class="table table-customer mt-0"> 
                                       <thead>
                                          <tr>
                                             <th class="text-center">
                                              #
                                             </th>
                                             <th class="text-left">
                                                Driver
                                             </th>
                                             <th class="text-center">Delivery Date</th>
                                             <th>City</th>
                                             <th>Route</th>
                                             <th class="text-center">
                                                Status
                                             </th>
                                             <th class="text-right">Action</th>
                                             
                                          </tr>
                                       </thead>
                                       <tbody>
                                           @php $id=1; @endphp
                                           @foreach($runsheets as $runsheet)
                                           <tr>
                                               
                                               <td class="text-center">
                                                   {{$runsheet->id}}
                                               </td>
                                               <td class="text-left">
                                                   {{$runsheet->driver->firstname}} {{$runsheet->driver->lastname}}
                                               </td>
                                               <td class="text-center">
                                                  {{date('d M Y',strtotime($runsheet->delivery_date))}}
                                               </td>
                                               <td>{{$runsheet->city}}</td>

                                               <td>{{$runsheet->routes->name ?? ''}}</td>
                                               
                                               <td class="text-center">
                                                   @if($runsheet->status==0)
                                                   Not Printed
                                                   @else
                                                   Printed
                                                   @endif
                                               </td>
                                               <td>
                                                   <div class="fh_actions">
                                                        <a href="#" class="fh_link">Actions <i class="fa fa-caret-down"></i> </a>
                                                        <ul class="fh_dropdown">
                                                            <li><a href="{{admin_url('runsheets/print/'.$runsheet->id)}}" target="_blank">Print</a></li>
                                                            <!--<li><a href="{{admin_url('printrunsheet')}}/{{$runsheet->id}}" target="_blank">Print</a></li>-->
                                                        </ul>
                                                    </div>
                                               </td>
                                           </tr>
                                           @php $id++; @endphp
                                           @endforeach
                                            @else
                                          
                                              <p class="text-center text-danger"><center>No Results Found!!</center></p>
                                          
                                          @endif
                                       </tbody>
                                    
                                    </table>
                                 </div>
                                 
                                 
                                 
                              </div>
                           </div>
                        </div>
                        </section>
                        {{$runsheets->links()}}
                        <div class="text-bold" style="padding:10px;">  Showing Page {{$runsheets->currentPage()}} of {{$runsheets->lastPage()}} </div>
                     <!--</section>-->
                 
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

@endsection