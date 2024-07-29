@extends('layouts.admin')
@section('title','Deliveries')
@section('page_title','Deliveries')
@section('page_nav')
<ul>
    <li class="active"><a href="{{admin_url('deliveries')}}">Deliveries</a></li>
    <!--<li><a  href="#">Generate Runsheet</a>-->
    
    
</ul>
@endsection
@section('contents')
<div class="content-container">
   <div class="content-area">
      <div class="row main_content">
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 addnew_form">
            <div class="card no-margin minH">
                <div class="row clearfix diverselector">
                    @foreach($drivers as $driver)
                    <div class="col-sm-6 col-md-3 driverdiv" data-id="{{$driver->id}}" data-count="{{count($driver->driverorder)}}">
                        <button class="driverselector_button white_button">{{$driver->firstname}} <span>{{count($driver->driverorder)}}</span></button>
                    
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection