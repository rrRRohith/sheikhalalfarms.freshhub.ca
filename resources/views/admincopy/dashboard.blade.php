@extends('layouts.admin')
@section('title','Dashboard')
@section('page_title','Dashboard')
@section('page_nav')
<ul>
    <li class="active"><a href="{{admin_url('')}}">Dashboard</a></li>
    <li><a href="{{admin_url('profile')}}">Profile</a></li>  
</ul>
@endsection
@section('contents')
<div class="content-container">
   <div class="content-area">
      <div class="row">
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-xs-padding">
            <div class="card no-margin minH">
               <div class="card-block">
                  <!--<div class="card-title">-->
                  <!--   <div class="card-title-header">-->
                  <!--      <div class="card-title-header-titr"><b> Dashboard - Monthly </b></div>-->
                  <!--      <div class="card-title-header-between"></div>-->
                  <!--      <div class="card-title-header-actions">-->
                  <!--         <a href="#"><img src="{{asset('/img/help.svg')}}" alt="help"-->
                  <!--            class="card-title-header-img card-title-header-details"></a>-->
                  <!--      </div>-->
                  <!--   </div>-->
                  <!--</div>-->
                  <section class="card-text">
                     <section class="card-text">
                        <div class="row px-xs-1 px-2 summer-report">
                           <div class="col-lg-3 col-md-6 col-sm-12 px-half">
                              <div class="summer-report-item">
                                 <div class="row summer-report-result">
                                    <a href="/opportunities?start_date=2020-08-01&amp;end_date=2020-08-31&amp;date_name=created_at&amp;result_type=paginate,10"
                                       class="summer-report-num number text-success input-mask-a" data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'autoGroup': true">
                                    0
                                    </a>
                                    <div class="summer-report-text text-gray-dark">The number of new opportunities</div>
                                 </div>
                                 <div class="summer-report-img">
                                    <img src="{{asset('img/opportunities-circle.svg')}}" alt="">
                                 </div>
                              </div>
                           </div>
                           <div class="col-lg-3 col-md-6 col-sm-12 px-half">
                              <div class="summer-report-item">
                                 <div class="row summer-report-result">
                                    <a href="/leads?start_date=2020-08-01&amp;end_date=2020-08-31&amp;date_name=created_at&amp;result_type=paginate,10"
                                       class="summer-report-num number text-success input-mask-a" data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'autoGroup': true">
                                    0
                                    </a>
                                    <div class="summer-report-text text-gray-dark">The number of new leads</div>
                                 </div>
                                 <div class="summer-report-img">
                                    <img src="{{asset('img/teamwork-circle.svg')}}" alt="">
                                 </div>
                              </div>
                           </div>
                           <div class="col-lg-3 col-md-6 col-sm-12 px-half">
                              <div class="summer-report-item">
                                 <div class="row summer-report-result">
                                    <a href="/quotes?start_date=2020-08-01&amp;end_date=2020-08-31&amp;date_name=quote_date&amp;result_type=paginate,10"
                                       class="summer-report-num number text-success input-mask-a" data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'autoGroup': true">
                                    0
                                    </a>
                                    <div class="summer-report-text text-gray-dark">The number of new quotes</div>
                                 </div>
                                 <div class="summer-report-img">
                                    <img src="{{asset('img/quote-circle.svg')}}" alt="">
                                 </div>
                              </div>
                           </div>
                           <div class="col-lg-3 col-md-6 col-sm-12 px-half">
                              <div class="summer-report-item">
                                 <div class="row summer-report-result">
                                    <a href="/quotes?start_date=2020-08-01&amp;end_date=2020-08-31&amp;date_name=quote_date&amp;result_type=paginate,10" class="summer-report-num number text-success input-mask-a" data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'autoGroup': true">
                                    0
                                    </a>
                                    <div class="summer-report-text text-gray-dark">Total of new quotes</div>
                                 </div>
                                 <div class="summer-report-img">
                                    <img src="{{asset('img/quote-dollar-circle.svg')}}" alt="">
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="row px-xs-1 px-2 summer-report">
                           <div class="col-lg-3 col-md-6 col-sm-12 px-half">
                              <div class="summer-report-item">
                                 <div class="row summer-report-result">
                                    <a href="/invoices?start_date=2020-08-01&amp;end_date=2020-08-31&amp;date_name=invoice_date&amp;result_type=paginate,10"
                                       class="summer-report-num number text-success input-mask-a" data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'autoGroup': true">
                                    0
                                    </a>
                                    <div class="summer-report-text text-gray-dark">The number of new invoices</div>
                                 </div>
                                 <div class="summer-report-img">
                                    <img src="{{asset('img/invoice-circle.svg')}}" alt="">
                                 </div>
                              </div>
                           </div>
                           <div class="col-lg-3 col-md-6 col-sm-12 px-half">
                              <div class="summer-report-item">
                                 <div class="row summer-report-result">
                                    <a href="/invoices?start_date=2020-08-01&amp;end_date=2020-08-31&amp;date_name=invoice_date&amp;result_type=paginate,10"
                                       class="summer-report-num number text-success input-mask-a" data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'autoGroup': true">
                                    0
                                    </a>
                                    <div class="summer-report-text text-gray-dark">Total of new invoices</div>
                                 </div>
                                 <div class="summer-report-img">
                                    <img src="{{asset('img/accounting-circle.svg')}}" alt="">
                                 </div>
                              </div>
                           </div>
                           <div class="col-lg-3 col-md-6 col-sm-12 px-half">
                              <div class="summer-report-item">
                                 <div class="row summer-report-result">
                                    <div class="summer-report-num number text-success input-mask-a" data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'autoGroup': true">0</div>
                                    <div class="summer-report-text text-gray-dark">The number of sent sms</div>
                                 </div>
                                 <div class="summer-report-img">
                                    <img src="{{asset('img/smartphone-circle.svg')}}" alt="">
                                 </div>
                              </div>
                           </div>
                        </div>
                     </section>
                     <div class="card-title">
                        <div class="card-title-header mt-3">
                           <span class="card-title-header-titr"><b> Monthly Sales </b></span>
                        </div>
                     </div>
                     <section>
                        <div class="row px-xs-1 px-3">
                           <div class="col-lg-6 col-md-6">
                              <canvas id="chart-area" width="100%" height="50"></canvas>
                           </div>
                           <div class="col-lg-6 col-md-6">
                              <bar-chart height="350"
                                 title="Total sale by months"
                                 :chart-data='{ labels: ["January","February","March","April","May","June","July","August","September","October","November","December"], datasets: [{"label":"admin admin","backgroundColor":"#FF6384","data":[0,0,0,0,0,0,0,0,0,0,0,0]},{"label":"Grantley Mullenger","backgroundColor":"#36A2EB","data":[0,0,0,0,0,0,0,0,0,0,0,0]}] }'>
                              </bar-chart>
                           </div>
                        </div>
                     </section>
                     <section>
                        <div class="row px-3 mt-3">
                           <div class="col-lg-6 col-md-6">
                              <div class="card-title">
                                 <div class="card-title-header mt-3">
                                    <span class="card-title-header-titr"><b> The number of opportunities added by technician </b></span>
                                 </div>
                              </div>
                              <line-chart height="200"
                                 :chart-data='{labels: ["January","February","March","April","May","June","July","August","September","October","November","December"], datasets: [{"label":"admin admin","borderColor":"#FF6384","data":[0,0,0,0,3,0,0,0,0,0,0,0]},{"label":"Grantley Mullenger","borderColor":"#36A2EB","data":[0,0,0,0,0,0,0,0,0,0,0,0]}]}'>
                              </line-chart>
                           </div>
                           <div class="col-lg-6 col-md-6">
                              <div class="card-title">
                                 <div class="card-title-header mt-3">
                                    <span class="card-title-header-titr"><b> The number of notes added by technician </b></span>
                                 </div>
                              </div>
                              <line-chart height="200"
                                 :chart-data='{labels: ["January","February","March","April","May","June","July","August","September","October","November","December"], datasets: [{"label":"admin admin","borderColor":"#FF6384","data":[0,0,0,0,0,0,0,0,0,0,0,0]},{"label":"Grantley Mullenger","borderColor":"#36A2EB","data":[0,0,0,0,0,0,0,0,0,0,0,0]}]}'>
                              </line-chart>
                           </div>
                        </div>
                     </section>
                     <section>
                        <div class="row px-3 mt-3">
                           <div class="col-lg-6 col-md-6">
                              <div class="card-title">
                                 <div class="card-title-header mt-3">
                                    <span class="card-title-header-titr"><b> The number of leads added by technician </b></span>
                                 </div>
                              </div>
                              <line-chart height="200"
                                 :chart-data='{labels: ["January","February","March","April","May","June","July","August","September","October","November","December"], datasets: [{"label":"admin admin","borderColor":"#FF6384","data":[0,0,0,0,0,0,0,0,0,0,0,0]},{"label":"Grantley Mullenger","borderColor":"#36A2EB","data":[0,0,0,0,0,0,0,0,0,0,0,0]}]}'>
                              </line-chart>
                           </div>
                           <div class="col-lg-6 col-md-6">
                              <div class="card-title">
                                 <div class="card-title-header mt-3">
                                    <span class="card-title-header-titr"><b> The number of quotes added by technician</b></span>
                                 </div>
                              </div>
                              <line-chart height="200"
                                 :chart-data='{labels: ["January","February","March","April","May","June","July","August","September","October","November","December"], datasets: [{"label":"admin admin","borderColor":"#FF6384","data":[0,0,0,0,0,0,0,0,0,0,0,0]},{"label":"Grantley Mullenger","borderColor":"#36A2EB","data":[0,0,0,0,763000,0,0,0,0,0,0,0]}]}'>
                              </line-chart>
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