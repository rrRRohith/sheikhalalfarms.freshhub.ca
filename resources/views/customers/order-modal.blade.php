<div id="full_modal" style="display: none;">
    <div class="full_modal_content">
        <form action="/customer/orders/create-po" id="order_form" />
            <input type="hidden" id="form-action" value="create" />
        @csrf
        <div class="full_modal_header">
            <a class="pull-right close" style="font-size:35px;font-weight:normal; line-height:100%;cursor:pointer;"> X<!--<i class="fa fa-close"></i>--></a>
            <h2 id="order-modal-title">Create New Order</h2>
        </div>
        @php $term=1;@endphp
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
                            <div class="col-sm-4">
                                <label>Billing Address</label>
                                <textarea name="address" id="address" required class="form-control" rows="3">{{$customer->address}}&#13;&#10;{{$customer->city}},{{$customer->province}}&#13;&#10;{{$customer->postalcode}}</textarea>
                                <input type="hidden" name="address1" id="address1" value="{{$customer->address}}"/>
                                <input type="hidden" name="postalcode" id="postalcode" value="{{$customer->postalcode}}"/>
                                <input type="hidden" name="city" id="city" value="{{$customer->city}}"/>
                                <input type="hidden" name="province" id="province" value="{{$customer->province}}"/>
                            </div>
                            <div class="col-sm-2">
                                <label>Terms</label>
                                <select name="terms" class="form-control" id="terms">
                                    <option value="0">--</option>
                                    @foreach($paymentterms as $paymentterm)
                                    <option value="{{$paymentterm->value}}"@if($customer->payment_term==$paymentterm->id) selected @endif>{{$paymentterm->name}}</option>
                                    @if($customer->payment_term==$paymentterm->id) @php $term=$paymentterm->value;@endphp @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <label>Order Date</label>
                                <input type="date" name="delivery_date" id="delivery_date" value="{{date('Y-m-d',strtotime('today'))}}" value="" required />
                            </div>
                            @php $ddate="+".$term." days";@endphp
                            <div class="col-sm-3">
                                <label>Due Date <span class="duedays"></span></label>
                                <input type="date" name="due_date" id="due_date" value="{{date('Y-m-d',strtotime($ddate))}}" value="" required/>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-4">
                                <label>Delivery Address</label>
                                <textarea name="delivery_address" id="delivery_address" class="form-control" rows="3">{{$customer->address}}&#13;&#10;{{$customer->city}},{{$customer->province}}&#13;&#10;{{$customer->postalcode}}</textarea>
                                <input type="hidden" name="delivery_address1" id="delivery_address1" value="{{$customer->address}}"/>
                                <input type="hidden" name="delivery_postalcode" id="delivery_postalcode" value="{{$customer->postalcode}}"/>
                                <input type="hidden" name="delivery_city" id="delivery_city" value="{{$customer->city}}"/>
                                <input type="hidden" name="delivery_province" id="delivery_province" value="{{$customer->province}}"/>
                            </div>
                            <div class="col-sm-2">
                                <label>Delivery Date</label>
                                <input type="date" name="delivery_date" id="delivery_date" value="{{date('Y-m-d',strtotime('tomorrow'))}}" value="" required />
                            </div>
                            <div class="col-sm-3">
                                <label>Driver</label>
                                <select name="driver_id" class="form-control" id="driver_id">
                                    <option value="0">--</option>
                                    @foreach($drivers as $driver)
                                    <option value="{{$driver->id}}" @if($customer->driver_id==$driver->id) selected @endif>{{'#'.$driver->id . ' - '. $driver->firstname.' '.$driver->lastname}}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            
                            
                            <div class="col-sm-3">
                                <label>Sales Rep</label>
                                <select name="sales_rep" class="form-control" id="sales_rep">
                                    <option value="0">--</option>
                                    @foreach($salesreps as $rep)
                                    <option value="{{$rep->id}}" @if($customer->sales_rep==$rep->id) selected @endif>{{'#'.$rep->id . ' - '. $rep->firstname.' '.$rep->lastname}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div style="min-height:95px;text-align:right;font-size:150%;">
                            <span id="total_due" >Total Due : ${{$customer->invoice->sum('grand_total')-$customer->invoice->sum('paid_total')}}</span>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label>Notes</label>
                                <textarea class="form-control" rows="3" name="notes" id="notes"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="order_body">
                <div class="row">
                    <div class="col-sm-12" id="table-container">
            
                    </div>
                    <div class="col-sm-6">
                        
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

