<div id="customer_modal" style="display: none;">
    <div class="modal_box">
        <div class="modal_title">
            <a class="pull-right close"><i class="fa fa-close"></i></a>
            <h3><span id="mhead">New Customer</span></h3>
        </div>
        <div class="modal_body">
            <div class="px-lg-3 no-padding fh_form" id="addAccountForm">
                <form class="pt-0" id="customer_form" method="post" action="{{admin_url('customers/create')}}">
                    @csrf
                    <input type="hidden" name="id" id="id">
                    <section class="form-block">
                        <div class="row">
                            <div class="col-md-9">  
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label class="text-gray-dark" for="opportunity_source_id"> Username (Minimum 4 letters)</label>
                                        <input class="form-control number" id="username" value="{{old('username',isset($user)?$user->username:'')}}" name="username" minlength="4" maxlength="30">
                                        @if ($errors->has('username'))
                                        <span class="form-error">{{$errors->first('username')}}</span>
                                        @endif
                                    </div>

                                    <div class="col-md-6">
                                        <label class="text-gray-dark" for="opportunity_source_id"> Password <span>(Minimum 5 letters or characters)</span></label>
                                        <input class="form-control" id="password" name="password" type="password" minlength="5">
                                        @if ($errors->has('password'))
                                        <span class="form-error">{{ $errors->first('password') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label class="text-gray-dark" for="opportunity_source_id"> Company Name</label>
                                        <input class="form-control number" id="business_name" value="{{old('business_name',isset($user)?$user->business_name:'')}}" name="business_name" type="text" maxlength="50">
                                        @if ($errors->has('business_name'))
                                        <span class="form-error">{{$errors->first('business_name')}}</span>
                                        @endif
                                    </div>
                                    <div class="col-md-3">
                                        <label class="text-gray-dark" for="opportunity_source_id"> Sales Rep.</label>
                                        <select name="sales_rep" id="sales_rep" class="form-control" required>
                                            <option value="">--</option>
                                            @foreach($salesreps as $salesrep)
                                            <option value="{{$salesrep->id}}" <?php if(isset($user)){if(($user->sales_rep)==($salesrep->id)){?> selected <?php }} else if(old('sales_rep')==$salesrep->id){?> selected <?php }?>>{{$salesrep->firstname}} {{$salesrep->lastname}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="text-gray-dark" for="opportunity_source_id">Customer Type</label>
                                        <select name="customer_type" id="customer_type" class="form-control" required>
                                            <option value="">--</option>
                                            @foreach(getCustomerTypes() as $customertype)
                                            <option value="{{$customertype->id}}" <?php if(isset($user)){if(($user->customer_type)==($customertype->id)){?> selected <?php }} else if(old('customer_type')==$customertype->id){?> selected <?php }?>>{{$customertype->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label class="text-gray-dark" for="account_name">Contact Name*</label>
                                        <input class="form-control" id="firstname" value="{{old('firstname',isset($user)?$user->firstname.' '.$user->lastname:'')}}" name="firstname" type="text" maxlength="30" required>
                                        @if ($errors->has('firstname'))
                                        <span class="form-error">{{ $errors->first('firstname') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-gray-dark" for="account_address">Address*</label>
                                        <input type="text" class="form-control" id="address" value="{{old('address',isset($user)?$user->address:'')}}" name="address" maxlength="150" required>
                                        @if ($errors->has('address'))
                                        <span class="form-error">{{ $errors->first('address') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label class="text-gray-dark" for="account_economic_identifier">Postal Code</label>
                                        <input type="text" class="form-control number" id="postalcode" value="{{old('postalcode',isset($user)?$user->postalcode:'')}}" name="postalcode" maxlength="7">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="text-gray-dark" for="account_city">City</label>
                                        <input type="text" class="form-control" name="city" value="{{old('city',isset($user)?$user->city:'')}}" id="city" maxlength="30">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="text-gray-dark" for="account_province">Province</label>
                                        <select name="province" id="custprovince" class="form-control" required>
                                           @foreach(getProvinces() as $p)
                                           <option value="{{$p->shortcode}}" <?php if(isset($user)){if(($user->province)==($p->shortcode)){?> selected <?php }}?> >{{$p->shortcode}}</option>
                                           @endforeach
                                        </select>
                                        @if ($errors->has('province'))
                                        <span class="form-error">{{ $errors->first('province') }}</span>
                                        @endif 
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label class="text-gray-dark" for="account_phone">Phone</label>
                                        <input type="text" id="phone" name="phone" value="{{old('phone',isset($user)?$user->phone:'')}}" required>
                                        @if ($errors->has('phone'))
                                        <span class="form-error">{{ $errors->first('phone') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-gray-dark" for="account_email">Email</label>
                                        <input class="form-control" type="email" name="email" value="{{old('email',isset($user)?$user->email:'')}}" id="email" maxlength="50" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" >
                                        @if ($errors->has('email'))
                                        <span class="form-error">{{ $errors->first('email') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label class="text-gray-dark" for="opportunity_source_id">Payment Type</label>
                                        <select name="payment_method" id="payment_method" class="form-control" required>
                                            @foreach(getPaymentMethods() as $paymentmethod)
                                            <option value="{{$paymentmethod->id}}" <?php if(isset($user)){if(($user->payment_method)==($paymentmethod->id)){?> selected <?php }}else if(old('payment_method')==$paymentmethod->id){?> selected <?php }?>>{{$paymentmethod->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>   
                                    <div class="col-md-4" id="payment_terms" style="display:none;">
                                        <label class="text-gray-dark" for="opportunity_source_id">Payment Terms</label>
                                        <select name="payment_term" id="payment_term" class="form-control" >
                                            <option value="">--</option>
                                            @foreach(getPaymentTerms() as $paymentterm)
                                            <option value="{{$paymentterm->id}}" <?php if(isset($user)){if(($user->payment_term)==($paymentterm->id)){?> selected <?php }} else if(old('payment_term')==$paymentterm->id){?> selected <?php } ?>>{{$paymentterm->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="text-gray-dark" for="opportunity_source_id"> Assign Driver</label>
                                        <select name="driver_id" id="driver_id" class="form-control">
                                            <option value="">Select Driver</option>
                                            @foreach($drivers as $driver)
                                            <option value="{{$driver->id}}" <?php if(isset($user)){if(($user->driver_id)==($driver->id)){?> selected <?php }}else if(old('driver_id')==$driver->id){?> selected <?php }?>>{{$driver->firstname}} {{$driver->lastname}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row"> 
                                    <div class="col-md-12">
                                        <label class="text-gray-dark" for="opportunity_source_id">Notes</label>
                                        <textarea rows="2" name="description" id="description" class="form-control">{{old('description',isset($user)?$user->description:'')}}</textarea>
                                        @if ($errors->has('description'))
                                        <span class="form-error">{{ $errors->first('description') }}</span>
                                        @endif
                                    </div>
                                </div>
                            
                            </div>
                            <div class="col-md-3" >
                                <img id="uploaded-image1" src="{{old('profile_picture',isset($user) && $user->profile_picture != '' ? asset('images/users/'.$user->profile_picture):asset('/images/users/dummy.jpg'))}}" style="width:auto;max-height:250px;max-width:100%;height:auto;">
                                <label class="text-gray-dark" for="opportunity_source_id"> Profile Picture</label>
                                <br><input type="file" accept="image/*" id="profile_pic">
                                <input type="hidden" name="profile_picture" id="picture1" />
                            </div>
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-success btn-block green_button">
                                    <clr-icon shape="floppy"></clr-icon>
                                   Save                        
                                </button>
                           
                            </div>
                               
                    </div>
                         
                   </section>
                 
                   

                      
                 
                </form>
             </div>
        </div>
        <div class="modal_footer">

        </div>
    </div>
</div>
<div class="modal" tabindex="-1" role="dialog" id="uploadimageModal1">
    <div class="modal-dialog" role="document" style="min-width: 700px">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Image</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <div id="image_demo1"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary crop_image1">Crop and Save</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>