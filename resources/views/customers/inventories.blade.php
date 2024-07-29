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
                        <div class="card-title-header-titr"><b> Shop </b></div>
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
                             @foreach($inventory as $w)
                           <div class="col-lg-4">
                              <div class="filter-customer-list">
                                 <!--<a class="toggle-filter-customer left "-->
                                 <!--   href="#">-->
                                 <!--</a>-->
                                 
                                 <div class="table-list-responsive-md">
                                    <table class="table table-list mt-0">
                                       <thead class="table-list-header-options">
                                          <tr>
                                             
                                          </tr>
                                       </thead>
                                      
                                          <tr>
                                             
                                             <td rowspan="5">
                                               <img src="{!!$w->picture !='' ? '/media/products/'.$w->picture : '/media/products/dummy.jpg' !!}" style="width:100px;height:100px;" />
                                             </td>
                                             <th>{{$w->name}}</th>
                                          </tr>
                                       
                                          
                                          <tr>
                                             
                                             <td data-label="Organization"><label class="">{{$w->description}}</label></td>
                                             
                                             
                                          </tr>
                                          <tr>
                                             
                                             <td data-label="Organization"><label class="">Weight: {{$w->weight}}</label></td>
                                             
                                             
                                          </tr>
                                          <tr>
                                             
                                             <td data-label="Organization"><label class="">Price: ${{$w->price}}</label></td>
                                             
                                             
                                          </tr>
                                          <tr>
                                             
                                             <td data-label="Organization"><label class="">Category: {{$w->category->name}}</label></td>
                                             
                                             
                                          </tr>
                                          <!--<tr><th colspan=2><button style="height: 39px;background-color: white;">Order Now</button></th></tr>-->
                                          
                                       
                                    </table>
                                 </div>
                              </div>
                           </div>
                           @endforeach
                          
                           
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