@extends('layouts.admin')
@section('title','Change Password')
@section('page_title','Change Password')
@section('page_nav')
<ul>
    <li></li>
    
</ul>
@endsection
@section('contents')
<div class="content-container">
   <div class="content-area">
      <div class="row main_content">
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 addenew_form">
            <div class="card no-margin minH">
               <div class="card-block">
                     <div class="headercnt_top">
                                    <!--<div class="innerpage_title">-->
                                    <!--    <h3>Change Password</h3>-->
                                    <!--</div>-->
                
                                                <div class="clearfix"></div>
                    </div>
                  <section class="card-text">
                     @if (Session::has('message'))
                     <div class="alert alert-success">
                        <div class="alert-items">
                           <div class="alert-item static">
                              <div class="alert-icon-wrapper">
                                 <clr-icon class="alert-icon"
                                    shape="check-circle"></clr-icon>
                              </div>
                              <span class="alert-text">
                              {{ Session::get('message') }}<br>
                              </span>
                           </div>
                        </div>
                        <button type="button" class="close" aria-label="Close">
                           <clr-icon aria-hidden="true" shape="close"></clr-icon>
                        </button>
                     </div>
                     @endif
                       <section id="panel2" role="tabpanel"
                              aria-labelledby="tab2" aria-hidden=true >
                              <div class="content-area">
                                 <form method="POST" action="{{admin_url('changepassword')}}" class="pt-0 passwordchange_form">
                                    @csrf
                                    <div class="row form-group">
                                       <div class="col-lg-6">
                                          <label class="text-gray-dark">Old Password*</label>
                                           <input type="password" name="oldpassword" class="form-control u-security-pass">
                                          @if ($errors->has('oldpassword'))
                                          <strong>{{ $errors->first('oldpassword') }}</strong>
                                          @endif
                                       </div>

                                    </div>
                                    <div class="row form-group">
                                       <div class="col-lg-6">
                                          <label class="text-gray-dark">New Password*</label>
                                         <input type="password" name="password" class="form-control u-security-pass">
                                          @if ($errors->has('password'))
                                          <strong>{{ $errors->first('password') }}</strong>
                                          @endif
                                       </div>

                                    </div>
                                    <div class="row form-group">
                                       <div class="col-lg-6">
                                          <label class="text-gray-dark">Confirm Password*</label>
                                             <input type="password" name="password_confirmation"
                                             class="form-control u-security-pass">
                                       </div>
                         
                                    </div>
                                    <div class="form-group row">
                                       <div class="col-lg-6">
                                          <!-- changed -->
                                          <button class="btn btn-success btn-block green_button">
                                             <clr-icon shape="floppy"></clr-icon>
                                             Save                                
                                          </button>
                                       </div>
                                    </div>
                                 </form>
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