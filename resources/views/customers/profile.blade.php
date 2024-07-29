@extends('layouts.customer')
@section('title','Profile')
@section('page_title','Profile')
@section('page_nav')
<ul>
    <li></li>
    
</ul>
@endsection


@section('contents')
<div class="content-container">
   <div class="content-area">
      <div class="row">
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card no-margin minH">
               <div class="card-block">
                    <div class="headercnt_top">
                         <!--<div class="innerpage_title">-->
                         <!--               <h3>Profile</h3>-->
                         <!--           </div>-->
                      
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
                     <form method="POST" action="{{customer_url('profile')}}" class="pt-0 profileedit_form">
                                    @csrf
                    
                        <div class="row clearfix">
                           
                             <div class="col-sm-4 col-md-2">
                                <div class="profileimage_field">
                                    <img id="uploaded-image"
                                                src="{{old('picture',isset($profile) && $profile->profile_picture != '' ? asset('images/users/'.$profile->profile_picture):asset('images/users/dummy-image.jpg'))}}"/>

                                </div>
                                        <div class="input-group mt-3">
                                            <div class="custom-file">
                                                <input type="file" accept="image/*" id="profile_pic">
                                                
                                                <input type="hidden" name="profile_picture" id="picture" />
                                            </div>
                                        </div>
                                    
                                
                            </div>
                            <div class="col-sm-8 col-md-10">
                              <div class="content-area">
                                 
                                    <div class="form-group row">
                                       <div class="col-md-6">
                                          <label class="text-gray-dark">First Name*</label>
                                          <input id="firstname" name="firstname" value="{{$profile->firstname}}"
                                             class="form-control">
                                          @if ($errors->has('firstname'))
                                          <strong>{{ $errors->first('firstname') }}</strong>
                                          @endif
                                       </div>
  
                                       <div class="col-md-6">
                                          <label class="text-gray-dark">Last Name*</label>
                                          <input id="lastname" name="lastname" value="{{$profile->lastname}}"
                                             class="form-control">
                                          @if ($errors->has('lastname'))
                                          <strong>{{ $errors->first('lastname') }}</strong>
                                          @endif
                                       </div>
                                    
                                       <div class="col-md-6">
                                          <label class="text-gray-dark">Mobile</label>
                                         <input type="text" name="phone" id="phone" value="{{$profile->phone}}" class="form-control">
                                          @if ($errors->has('phone'))
                                          <strong>{{ $errors->first('phone') }}</strong>
                                          @endif
                                       </div>

                                       <div class="col-md-6">
                                          <label class="text-gray-dark">Email</label>
                                          <input id="email" name="email" value="{{$profile->email}}"
                                             class="form-control number" readonly>
                                          @if ($errors->has('email'))
                                          <strong>{{ $errors->first('email') }}</strong>
                                          @endif
                                       </div>

                                       <div class="col-md-6">
                                          <label class="text-gray-dark">Address</label>
                                            <input id="address" name="address"
                                             value="{{$profile->address}}" class="form-control">
                                          @if ($errors->has('address'))
                                          <strong>{{ $errors->first('address') }}</strong>
                                          @endif
                                       </div>

                                       <div class="col-md-6">
                                          <label class="text-gray-dark">City</label>
                                          <input id="city" name="city"
                                             value="{{$profile->city}}"
                                             class="form-control">
                                          @if ($errors->has('city'))
                                          <strong>{{ $errors->first('city') }}</strong>
                                          @endif
                                       </div>

                                       <div class="col-md-6">
                                          <label class="text-gray-dark">Province</label>
                                          <select class="form-control" name="province" id="province">
                                               @foreach($provinces as $province)
                                               <option value="{{$province->shortcode}}" @if($profile->province==$province->shortcode) selected @endif>{{$province->name}}</option>
                                               @endforeach
                                           </select>
                                         <!--<input id="province" name="province"-->
                                          <!--   value="{{$profile->province}}" class="form-control number">-->
                                          @if ($errors->has('province'))
                                          <strong>{{ $errors->first('province') }}</strong>
                                          @endif
                                       </div>

                                       <div class="col-md-6">
                                          <label class="text-gray-dark">Pincode</label>
                                              <input id="postalcode" name="postalcode"
                                             value="{{$profile->postalcode}}" class="form-control">
                                          @if ($errors->has('postalcode'))
                                          <strong>{{ $errors->first('postalcode') }}</strong>
                                          @endif
                                       </div>

                               
                                       <div class="col-md-6">
                                          <button class="btn btn-success btn-block green_button">
                                             <clr-icon shape="floppy"></clr-icon>
                                             Save                                
                                          </button>
                                       </div>
                                    </div>
                                 
                              </div>
                           </div>
                           <!--<section id="panel2" role="tabpanel"-->
                           <!--   aria-labelledby="tab2" aria-hidden=true >-->
                           <!--   <div class="content-area">-->
                           <!--      <form method="POST" action="{{admin_url('changepassword')}}" class="pt-0 passwordchange_form">-->
                           <!--         @csrf-->
                           <!--         <div class="row form-group">-->
                           <!--            <div class="col-lg-6">-->
                           <!--               <label class="text-gray-dark">Old Password*</label>-->
                           <!--                <input type="password" name="oldpassword" class="form-control u-security-pass">-->
                           <!--               @if ($errors->has('oldpassword'))-->
                           <!--               <strong>{{ $errors->first('oldpassword') }}</strong>-->
                           <!--               @endif-->
                           <!--            </div>-->

                           <!--         </div>-->
                           <!--         <div class="row form-group">-->
                           <!--            <div class="col-lg-6">-->
                           <!--               <label class="text-gray-dark">New Password*</label>-->
                           <!--              <input type="password" name="password" class="form-control u-security-pass">-->
                           <!--               @if ($errors->has('password'))-->
                           <!--               <strong>{{ $errors->first('password') }}</strong>-->
                           <!--               @endif-->
                           <!--            </div>-->

                           <!--         </div>-->
                           <!--         <div class="row form-group">-->
                           <!--            <div class="col-lg-6">-->
                           <!--               <label class="text-gray-dark">Confirm Password*</label>-->
                           <!--                  <input type="password" name="password_confirmation"-->
                           <!--                  class="form-control u-security-pass">-->
                           <!--            </div>-->
                         
                           <!--         </div>-->
                           <!--         <div class="form-group row">-->
                           <!--            <div class="col-lg-6">-->
                                          <!-- changed -->
                           <!--               <button class="btn btn-success btn-block">-->
                           <!--                  <clr-icon shape="floppy"></clr-icon>-->
                           <!--                  Save                                -->
                           <!--               </button>-->
                           <!--            </div>-->
                           <!--         </div>-->
                           <!--      </form>-->
                           <!--   </div>-->
                           <!--</section>-->
                           
                        </div>
                     
                     </form>
                  </section>
               </div>
            </div>
         </div>
         
      </div>
   </div>
</div>
<div class="modal" tabindex="-1" role="dialog" id="uploadimageModal">
    <div class="modal-dialog" role="document" style="min-width: 700px">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Profile Picture</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <div id="image_demo"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary crop_image">Crop and Save</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('bottom-scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.css" />


<script>
var image_crop = $('#image_demo').croppie({
    viewport: {
        width: 300,
        height: 300,
        type: 'square'
    },
    boundary: {
        width: 350,
        height: 350
    }
});
/// catching up the cover_image change event and binding the image into my croppie. Then show the modal.
$('#profile_pic').on('change', function() {
    var reader = new FileReader();
    reader.onload = function(event) {
        image_crop.croppie('bind', {
            url: event.target.result,
        });
    }
    reader.readAsDataURL(this.files[0]);
    $('#uploadimageModal').modal('show');
});


$('.crop_image').click(function(event) {
    image_crop.croppie('result', {
        type: 'canvas',
        format: 'png'
    }).then(function(response) {
        $("#uploaded-image").attr("src", response).css("display", "block");
        $("#picture").val(response);
    });
    $("#profile_pic").val("");
    $('#uploadimageModal').modal('hide');
});
</script>
@endsection