@extends('layouts.admin')
@section('title',isset($user) ? 'Edit Customer' :'Add Customer')
@section('page_title','Customers')
@section('page_nav')
<ul>
  <li @if($submenu=='All') class="active" @else class="" @endif><a  href="{{url('admin/customers')}}">All Customers</a></li>
  <li @if($submenu=='Active') class="active" @else class="" @endif><a  href="{{url('admin/customers/getcust/1')}}">Active Customers</a></li>
  <li @if($submenu=='Inactive') class="active" @else class="" @endif><a  href="{{url('admin/customers/getcust/0')}}">Inactive Customers</a></li>
  <li @if($submenu=='customertype') class="active" @else class="" @endif ><a href="{{url('admin/customertype')}}">Customer Types</a> </li>
</ul>  
@endsection
@section('contents')
<div class="content-container customer_create">
   <div class="content-area">
      <div class="row">
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-xs-padding">
            <div class="card no-margin minH">
               <div class="card-block">
                    <div class="card-title">
                      <a href="/admin/customertype" class="pull-right white_button"><i class="fa fa-arrow-left"></i> All Customers</a>
                    <h3>@isset($user) Edit Customer @else New Customer @endisset</h3>
                  </div>
                  <section class="card-text">
                     <!--  <div class="form-group row">
                        <div class="toggle-switch toggle-switch-two-way">
                            <input value='0' name="contact_status" type="checkbox"
                                  checked   id="switchCustomerFormMode">
                            <label for="switchCustomerFormMode">Contact</label>
                            <label for="switchCustomerFormMode">Account</label>
                        </div>
                        </div> -->
                     <div class="px-lg-3 no-padding fh_form" id="addAccountForm">
                        <form class="pt-0" id="form" method="post"
                           action="@if(isset($user)){{admin_url('customers/'.$user->id)}}@else{{admin_url('customers')}}@endif">
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
                                           for="opportunity_source_id"> Username</label>
                                        <input class="form-control number" id="username"
                                           value="{{old('username',isset($user)?$user->username:'')}}"
                                           name="username">
                                        @if ($errors->has('username'))
                                        <span class="form-error">{{$errors->first('username')}}</span>
                                        @endif
                                     </div>

                                     <div class="col-md-6">
                                        <label class="text-gray-dark"
                                           for="opportunity_source_id"> Password</label>
                                            <input class="form-control number" id="password" name="password" type="password">
                                        @if ($errors->has('password'))
                                        <span class="form-error">{{ $errors->first('password') }}</span>
                                        @endif
                                     </div>
                           
                                  </div>
                             <div class="form-group row">
                                 <div class="col-md-6">
                                    <label class="text-gray-dark"
                                       for="opportunity_source_id"> Business Info</label>
                                     <input class="form-control number" id="business_name"
                                       value="{{old('business_name',isset($user)?$user->business_name:'')}}"
                                       name="business_name">
                                    @if ($errors->has('business_name'))
                                    <span class="form-error">{{$errors->first('business_name')}}</span>
                                    @endif
                                 </div>
                                 <div class="col-md-3">
                                    <label class="text-gray-dark"
                                       for="opportunity_source_id"> Sales Representative</label>
                                       <select name="sales_rep" id="sales_rep" class="form-control" required>
                                            <option value="">Select Sales Rep</option>
                                            @foreach($salesreps as $salesrep)
                                            <option value="{{$salesrep->id}}" <?php if(isset($user)){if(($user->sales_rep)==($salesrep->id)){?> selected <?php }} else if(old('sales_rep')==$salesrep->id){?> selected <?php }?>>{{$salesrep->firstname}} {{$salesrep->lastname}}</option>
                                            @endforeach
                                     </select>
                                 </div>
                                 <div class="col-md-3">
                                    <label class="text-gray-dark" for="opportunity_source_id"> Customer Type</label>
                                        <select name="customer_type" id="customer_type" class="form-control" required>
                                            <option value="">Select Customer Type</option>
                                            @foreach($customertypes as $customertype)
                                            <option value="{{$customertype->id}}" <?php if(isset($user)){if(($user->customer_type)==($customertype->id)){?> selected <?php }} else if(old('customer_type')==$customertype->id){?> selected <?php }?>>{{$customertype->name}}</option>
                                            @endforeach
                                        </select>
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
                                       @foreach($province as $p)
                                       <option value="{{$p->shortcode}}" <?php if(isset($user)){if(($user->province)==($p->shortcode)){?> selected <?php }}?> >{{$p->name}}</option>
                                       @endforeach
                                    </select>
                                    @if ($errors->has('province'))
                                    <span class="form-error">{{ $errors->first('province') }}</span>
                                    @endif 
                                 </div>
                              </div>
                    
                              <div class="form-group row">
                                 <div class="col-md-6">
                                    <label class="text-gray-dark"
                                       for="account_phone">Phone</label>
                                                              <input type="text" id="phone" name="phone"
                                       value="{{old('phone',isset($user)?$user->phone:'')}}">
                                    
                                    @if ($errors->has('phone'))
                                    <span class="form-error">{{ $errors->first('phone') }}</span>
                                    @endif
                                    
                                 </div>
                     
                                 <div class="col-md-6">
                                    <label class="text-gray-dark"
                                       for="account_email">Email</label>
                                                                           <input class="form-control" name="email"
                                       value="{{old('email',isset($user)?$user->email:'')}}"
                                       id="email">
                                    @if ($errors->has('email'))
                                    <span class="form-error">{{ $errors->first('email') }}</span>
                                    @endif
                                 </div>
                                </div>
                                 <!--<div class="col-lg-1 col-md-1 col-sm-12 col-xs-12 text-right no-md-padding">-->
                                 <!--   <label class="text-gray-dark"-->
                                 <!--      for="opportunity_source_id"> Profile Picture</label>-->
                                 <!--</div>-->
                                 <!--<div class="col-lg-3 col-md-3 col-sm-12">-->
                                 <!--   <input type="file" class="form-control" id="profile_picture" name="profile_picture">-->
                                 <!--   <input type="hidden" name="id" value="{{old('id',isset($user)?$user->id:'')}}" />-->
                                 <!--</div>-->
                                 <div class="form-group row">
                                      <div class="col-md-4">
                                    <label class="text-gray-dark"
                                       for="opportunity_source_id"> Payment Terms</label>
                                      <select name="payment_term" id="payment_term" class="form-control" required>
                                        <option value="">Select Payment Term</option>
                                        @foreach($paymentterms as $paymentterm)
                                        <option value="{{$paymentterm->id}}" <?php if(isset($user)){if(($user->payment_term)==($paymentterm->id)){?> selected <?php }} else if(old('payment_term')==$paymentterm->id){?> selected <?php } ?>>{{$paymentterm->name}}</option>
                                        @endforeach
                                    </select>
                                 </div>
                                 <div class="col-md-4">
                                    <label class="text-gray-dark"
                                       for="opportunity_source_id"> Payment Type</label>
                                      <select name="payment_method" id="payment_method" class="form-control" required>
                                        <option value="">Select Payment Type</option>
                                        @foreach($paymentmethods as $paymentmethod)
                                        <option value="{{$paymentmethod->id}}" <?php if(isset($user)){if(($user->payment_method)==($paymentmethod->id)){?> selected <?php }}else if(old('payment_method')==$paymentmethod->id){?> selected <?php }?>>{{$paymentmethod->name}}</option>
                                        @endforeach
                                    </select>
                                 </div>  
                                 <div class="col-md-4">
                                    <label class="text-gray-dark"
                                       for="opportunity_source_id"> Assign Driver</label>
                                      <select name="driver_id" id="driver_id" class="form-control" required>
                                        <option value="">Select Driver</option>
                                        @foreach($drivers as $driver)
                                        <option value="{{$driver->id}}" <?php if(isset($user)){if(($user->driver_id)==($driver->id)){?> selected <?php }}else if(old('driver_id')==$driver->id){?> selected <?php }?>>{{$driver->firstname}} {{$driver->lastname}}</option>
                                        @endforeach
                                    </select>
                                 </div>
                              </div>
                        
                             
                          

                         

                                 <!--<div class="col-lg-1 col-md-1 col-sm-12 col-xs-12 text-right no-md-padding">-->
                                 <!--   <label class="text-gray-dark"-->
                                 <!--      for="opportunity_source_id"> Customer Type</label>-->
                                 <!--</div>-->
                                 <!--<div class="col-lg-3 col-md-3 col-sm-12">-->
                                 <!--   <select name="customer_type" id="customer_type" class="form-control" required>-->
                                 <!--       <option value="">Select Customer Type</option>-->
                                 <!--       @foreach($customertypes as $customertype)-->
                                 <!--       <option value="{{$customertype->id}}" <!--?php if(isset($user)){if(($user->customer_type)==($customertype->id)){?> selected <!--?php }}?>>{{$customertype->name}}</option>-->
                                 <!--       @endforeach-->
                                 <!--   </select>-->
                                    
                                 <!--</div>-->
                              
                              <div class="form-group row"> 
                                    
                                   <div class="col-md-12">
                                       <label class="text-gray-dark"
                                       for="opportunity_source_id">Notes</label>
                                             <textarea rows="3" name="description" id="description" class="form-control">{{old('description',isset($user)?$user->description:'')}}</textarea>
                                            
                                            @if ($errors->has('description'))
                                            <span class="form-error">{{ $errors->first('description') }}</span>
                                            @endif
                                    </div>
                                 
                               
                                    </div>
                                    
                                    </div>
                                    
                                    <div class="col-sm-3" >
                                    
                                  
                                      <img id="uploaded-image"
                                                src="{{old('profile_picture',isset($user) && $user->profile_picture != '' ? asset('images/users/'.$user->profile_picture):asset('images/users/dummy-image.jpg'))}}" style="display:block;width:150px;height:150px;">
                                        <label class="text-gray-dark" for="opportunity_source_id"> Profile Picture</label>
                                       <br><input type="file" accept="image/*" id="profile_pic">
                                        <input type="hidden" name="profile_picture" id="picture" />
                                   
                                    
                                    </div>
                                    
                                    <div class="col-sm-12">
                                            <button type="submit"
                                           class="btn btn-success btn-block green_button">
                                           <clr-icon
                                              shape="floppy"></clr-icon>
                                           Save                        
                                        </button>
                                   
                                  </div>
                                       
                                  </div>
                                 
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
</script>
@endsection