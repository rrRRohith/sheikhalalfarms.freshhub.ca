@extends('layouts.admin')
@section('title',isset($user) ? 'Edit Staff' :'Add Staff')
@section('page_title','Staffs')
@section('page_nav')
<ul>
    <li class="active"></li>
    
</ul>
@endsection
@section('contents')
<div class="content-container">
   <div class="content-area">
      <div class="row staff_create">
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card no-margin minH">
               <div class="card-block">
                <div class="card-title">
                      <a href="/admin/staffs" class="pull-right white_button"><i class="fa fa-arrow-left"></i> All Staffs</a>
                    <h3>@isset($user) Edit Staff @else New Staff @endisset</h3>
                  </div>
                  <section class="card-text">
                     <div class="px-lg-3 no-padding fh_form" id="addAccountForm">
                        <form class="pt-0" id="form" method="post"
                           action="@if(isset($user)){{url('admin/staffs/'.$user->id)}}@else{{url('admin/staffs')}}@endif">
                           @if(isset($user))
                           @method('PUT')
                           @endif
                           @csrf
                           <section class="form-block">
                             
                               <div class="row">
                                   
                             <div class="col-sm-9">
                              <div class="form-group row">
                                 <div class="col-md-6">
                                    <label class="text-gray-dark"
                                       for="opportunity_source_id"> User Name</label>
                                       <input class="form-control number" id="username"
                                       value="{{old('username',isset($user)?$user->username:'')}}"
                                       name="username">
                                    @if ($errors->has('username'))
                                    <span class="form-error">{{ $errors->first('username') }}</span>
                                    @endif
                                 </div>

                                 <div class="col-md-6">
                                    <label class="text-gray-dark"
                                       for="opportunity_source_id"> Password</label>
                                       <input class="form-control number" id="password"
                                       value="" name="password" type="password">
                                    @if ($errors->has('password'))
                                    <span class="form-error">{{ $errors->first('password') }}</span>
                                    @endif
                                 </div>
          
                              </div>
                              <div class="form-group row">
                                 <div class="col-md-6">
                                    <label class="text-gray-dark"
                                       for="account_name">First Name*</label>
                                    <input class="form-control" id="firstname"
                                       value="{{old('firstname',isset($user)?$user->firstname:'')}}"
                                       name="firstname">
                                    @if ($errors->has('firstname'))
                                    <span class="form-error">{{ $errors->first('firstname') }}</span>
                                    @endif
                                 </div>

                                 <div class="col-md-6">
                                    <label class="text-gray-dark"
                                       for="company_brand">Last Name</label>
                                      <input class="form-control" id="lastname"
                                       value="{{old('lastname',isset($user)?$user->lastname:'')}}"
                                       name="lastname">
                                    @if ($errors->has('lastname'))
                                   <span class="form-error">{{ $errors->first('lastname') }}</span>
                                    @endif
                                 </div>
                         
                              </div>
                           
                                  
                    
                              <div class="form-group row">
                                 <div class="col-md-5">
                                    <label class="text-gray-dark"
                                       for="account_phone">Phone</label>
                                    <input type="text" id="phone" name="phone"
                                       value="{{old('phone',isset($user)?$user->phone:'')}}">
                                    
                                    @if ($errors->has('phone'))
                                    <span class="form-error">{{ $errors->first('phone') }}</span>
                                    @endif
                                    
                                 </div>

                                 <div class="col-md-5">
                                    <label class="text-gray-dark"
                                       for="account_email">Email</label>
                                    <input class="form-control" name="email"
                                       value="{{old('email',isset($user)?$user->email:'')}}"
                                       id="email" type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" placeholder="example@domain.com">
                                    @if ($errors->has('email'))
                                    <span class="form-error">{{ $errors->first('email') }}</span>
                                    @endif
                                 </div>
                            <div class="col-md-2">
                                    <label class="text-gray-dark"
                                       for="opportunity_source_id"> Staff Role</label>
                                    <select class="form-control" name="role"  id="role">
                                       @foreach($roles as $role)
                                          <option value="{{$role->id}}" @if(isset($user) && $user->hasRole($role->name)) selected="selected" @endif>{{$role->name}}</option>
                                       @endforeach
                                    </select>
                                 </div>
                            

                              </div>
                                 <div class="form-group row">
                                 <div class="col-md-5">
                                    <label class="text-gray-dark"
                                       for="account_address">Address</label>
                                     <input class="form-control" id="address"
                                       value="{{old('address',isset($user)?$user->address:'')}}"
                                       name="address">
                                    @if ($errors->has('address'))
                                    <span class="form-error">{{ $errors->first('address') }}</span>
                                    @endif
                                 </div>
                            <div class="col-md-2">
                                    <label class="text-gray-dark"
                                       for="account_economic_identifier">Postal Code</label>
                                         <input class="form-control number" id="postalcode"
                                       value="{{old('postalcode',isset($user)?$user->postalcode:'')}}"
                                       name="postalcode">
                                 </div>
                                 <div class="col-md-3">
                                    <label class="text-gray-dark"
                                       for="account_city">City</label>
                                    <input class="form-control" name="city"
                                       value="{{old('city',isset($user)?$user->city:'')}}"
                                       id="city">
                                 </div>
                                  <div class="col-md-2">
                                    <label class="text-gray-dark"
                                       for="account_province">Province</label>
                                    <select name="province" id="province" class="form-control">
                                       @foreach($provinces as $p)
                                       <option value="{{$p->shortcode}}" <?php if(isset($user)){if(($user->province)==($p->shortcode)){?> selected <?php }}?> >{{$p->name}}</option>
                                       @endforeach
                                    </select>
                                    @if ($errors->has('province'))
                                    <span class="form-error">{{ $errors->first('province') }}</span>
                                    @endif 
                                 </div>
                              </div>
                              

                               </div>
                               <div class="col-sm-3 staffimage_upload">
                             
                                    
                                       <img id="uploaded-image"
                                                src="{{old('profile_picture',isset($user) && $user->profile_picture != '' ? asset('images/users/'.$user->profile_picture):asset('images/users/dummy.jpg'))}}" style="display:block;width:150px;height:150px;">
                                        <label class="text-gray-dark" for="opportunity_source_id"> Profile Picture</label>
                                       <br><input type="file" accept="image/*" id="profile_pic">
                                        <input type="hidden" name="profile_picture" id="picture" />
                                
     
                               </div>
                                 <div class="col-sm-12">
                                    <button type="submit"
                                       class="green_button">
                                       <i class="fa fa-tick"></i>
                                       Save                        
                                    </button>
                                 </div>
                               
                               </div>
                           </section>
                           <section>
            
                           </section>
                        </form>
                     </div>
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
let autocomplete;
let address;

function initAutocomplete() {
    address = document.querySelector("#address");
    autocomplete = new google.maps.places.Autocomplete(address, {
    componentRestrictions: { country: [ "ca"] },
    fields: ["address_components", "geometry"],
    types: ["address"],
});
autocomplete.addListener("place_changed", fillCustAddress);
}
function fillCustAddress() {
    // Get the place details from the autocomplete object.
    const place = autocomplete.getPlace();
    let add= "";
    let address1 = "";
    let postcode = "";
    
    // Get each component of the address from the place details,
    // and then fill-in the corresponding field on the form.
    // place.address_components are google.maps.GeocoderAddressComponent objects
    // which are documented at http://goo.gle/3l5i5Mr
    for (const component of place.address_components) {
        const componentType = component.types[0];
        switch (componentType) {
            case "street_number": {
                address1 = `${component.long_name} ${address1}`;
                add =`${component.long_name} `;
                break;
            }
        
            case "route": {
                address1 += component.long_name;
                add += component.long_name;
                break;
            }
        
            case "postal_code": {
                postcode = `${component.long_name}${postcode}`;
                break;
            }
        
            case "postal_code_suffix": {
                postcode = `${postcode}-${component.long_name}`;
                break;
            }
            case "locality": {
                document.querySelector("#city").value = component.long_name;
                address1 += ', \n'+component.long_name;
                break;
            }
            case "administrative_area_level_1": {
                document.querySelector("#province").value = component.short_name;
                address1 += ', ' + component.short_name;
                break;
            }
        
        }
    }
    document.querySelector("#address").value = add;
    // console.log('Bil:'+address1+' '+postcode)
    // address1 +=", \n"+`${postcode}`;
    document.querySelector("#postalcode").value = postcode;
    // document.querySelector("#address").value = address1;
    
    // billing_address.focus();
    
    // After filling the form with address components from the Autocomplete
    // prediction, set cursor focus on the second address line to encourage
    // entry of subpremise information such as apartment, unit, or floor number.
}
</script>
<script  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA2pKP9bGJRpU-35sWLBgirftfBgLhc03c&callback=initAutocomplete&libraries=places&v=weekly"  async ></script>
<script>
$("#phone").inputmask({"mask": "(999) 999-9999"});
</script>
@endsection