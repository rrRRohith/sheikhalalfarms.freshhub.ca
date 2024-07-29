@extends('layouts.admin')
@section('title','Routes')
@section('page_title','Routes')
@section('page_nav')

@endsection
@section('contents')
<div class="content-container">
   <div class="content-area">
      <div class="row">
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card no-margin minH">
               <div class="headercnt_top">
                    <div class="innerpage_title">
                        <h3>@if(isset($route)) Edit @else Add @endif Route Details</h3>
                    </div>
                       
                   </div>
                  <section class="card-text">
                     <div id="addAccountForm" class="col-md-6">
                        <form class="pt-0" id="form" method="post" action="@if(isset($route)){{admin_url('routes/'.$route->id)}}@else{{admin_url('routes')}}@endif" enctype="multipart/form-data">
                           @if(isset($route))
                           @method('PUT')
                           @endif
                           @csrf
                           
                           
                              <div class="form-group row">
                                 <div class="col-md-12">
                                    <label class="text-gray-dark"
                                       for="opportunity_source_id">Name</label>
                               
                                    <input class="form-control number" id="name"
                                       value="{{old('name',isset($route)?$route->name:'')}}"
                                       name="name">
                                       
                                    @if ($errors->has('name'))
                                    <span class="form-error">{{ $errors->first('name') }}</span>
                                    @endif
                                 </div>
                                
                             
                                 <div class="col-md-12">
                                    <label class="text-gray-dark" for="opportunity_source_id">City</label>
                                
                                    <input class="form-control number" id="city"
                                       value="{{old('city',isset($route)?$route->city:'')}}"
                                       name="city">
                                       
                                    @if ($errors->has('city'))
                                    <span class="form-error">{{ $errors->first('city') }}</span>
                                    @endif
                                 </div>
                              
                                 <div class="col-md-12">
                                    <label class="text-gray-dark" for="opportunity_source_id">Places</label>
                                 
                                
                                    <input class="form-control number" id="places"
                                       value="{{old('places',isset($route)?$route->places:'')}}"
                                       name="places">
                                       
                                    @if ($errors->has('places'))
                                    <span class="form-error">{{ $errors->first('places') }}</span>
                                    @endif
                                 </div>
                              </div>
                              
                              <!--<div class="form-group row">-->
                              <!--   <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12 text-right no-md-padding">-->
                              <!--      <label class="text-gray-dark" for="opportunity_source_id">&nbsp;</label>-->
                              <!--   </div>-->
                                 
                              <!--   <div class="col-lg-5 col-md-5 col-sm-12">-->
                              <!--   <div class="form-check form-switch">-->
                              <!--        <label class="form-check-label" for="flexSwitchCheckChecked">Publish</label>-->
                              <!--        <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" name="status" @if(isset($route) && $route->status) checked="checked" @endif>-->
                                     
                              <!--   </div>-->
                              <!--   </div>-->
                                 
                              <!--</div>-->
                              
                          
                              <div class="form-group row">
                                 <div class="col-xs-6">
                                    <button type="submit"
                                       class="btn btn-success btn-block green_button">
                                       <clr-icon
                                          shape="floppy"></clr-icon>
                                       Save                        
                                    </button>
                                 </div>
                              </div>
                           
                        </form>
                     </div>
                  </section>
               </div>
            </div>
         </div>
    
   </div>
</div>
@endsection