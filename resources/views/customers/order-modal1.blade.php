<div id="full_modal" style="display: none;">
    <div class="full_modal_content">
        <form action="/customer/orders/create-po" id="order_form" />
            <input type="hidden" id="form-action" value="create" />
        @csrf
        <div class="full_modal_header">
            <a class="pull-right close"><i class="fa fa-close"></i></a>
            <h2 id="order-modal-title">Create New Order</h2>
        </div>
        <div class="full_modal_body">
            <div class="order_header">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="row form-group">
                            <!--<div class="col-md-4">-->
                                <!--<label>Customer</label>-->
                                <input type="hidden" name="customer" value="{{$customer->firstname}} {{$customer->lastname}}" required id="customer" autocomplete="off" />
                                <!--<ul class="pulldown-menu" id="customer-list" style="display:none;">-->
                                <!--    <li><a href="#" id="button_new_customer"><big>Create New Customer</big></a></li>-->
                                <!--</ul>-->
                                <input type="hidden" name="customer_id" value="{{$customer->id}}" id="customer_id" />
                            <!--</div>-->

                            <div class="col-md-4">
                                <label>Email</label>
                                <input type="email" name="email" value="{{$customer->email}}" id="email" required readonly />
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-4">
                                <label>Billing Address</label>
                                <input type="text" name="address" id="address" value="{{$customer->address}}" required readonly />
                            </div>
                            <div class="col-md-2">
                                <label>Postalcode</label>
                                <input type="text" name="postalcode" id="postalcode" value="{{$customer->postalcode}}" required readonly />
                            </div>
                            <div class="col-md-3">
                                <label>City</label>
                                <input type="text" name="city" id="city" value="{{$customer->city}}" required readonly />
                            </div>
                            <div class="col-md-2">
                                <label>Province</label>
                                @if(isset($provinces))
                                <select class="form-control" name="province">
                                    @foreach($provinces as $province)
                                        <option value="{{$province->shortcode}}" @if($customer->province==$province->shortcode) selected @endif>{{$province->name}}</option>
                                    @endforeach
                                </select>
                                @endif
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-4">
                                <label>Delivery Date</label>
                                <input type="date" name="delivery_date" id="delivery_date" value="{{date('Y-m-d',strtotime('tomorrow'))}}" value="" required />
                            </div>

                            <div class="col-md-2">
                                <label>Due Date <span class="duedays"></span></label>
                                <input type="date" name="due_date" id="due_date" value="{{date('Y-m-d',strtotime('tomorrow'))}}" value="" required />
                            </div>
                            <div class="col-md-3">
                                <label>Sales Rep</label>
                                <select name="sales_rep" class="form-control" id="sales_rep">
                                    <option value="0">--</option>
                                    @foreach($salesreps as $rep)
                                    <option value="{{$rep->id}}">{{'#'.$rep->id . ' - '. $rep->firstname.' '.$rep->lastname}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label>Driver</label>
                                <select name="driver_id" class="form-control">
                                    <option value="0">--</option>
                                    @foreach($drivers as $driver)
                                    <option value="{{$driver->id}}" @if($customer->driver_id==$driver->id) selected @endif>{{'#'.$driver->id . ' - '. $driver->firstname.' '.$driver->lastname}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 text-right">     

                    </div>
                </div>
            </div>

            <div class="order_body">
                <div class="row">
                    <div class="col-sm-12" id="table-container">
            
                    </div>
                    <div class="col-sm-6">
                        <label>Notes</label>
                        <textarea class="form-control" rows="3" name="notes" id="notes"></textarea>
                    </div>

                    <div class="col-sm-6">
                        <div id="backorder-container">

                        </div>
                        <!--<strong>Total Qty: <big class="total_qty">0</big></strong> //-->
                    </div>
                </div>
            </div>

            <div class="order_footer">
                <div class="row">
                    <div class="col-sm-6">

                    </div>
                </div>
            </div>
        </div>

        <div class="full_modal_footer">
            <div class="modal-actions">
                <a href="#" class="close white_button">Close</a>
                <a href="#" class="print white_button">Print</a>
                <button type="submit" class="green_button" >Submit</button>
            </div>
        </div>
        </form>
    </div>
</div>

