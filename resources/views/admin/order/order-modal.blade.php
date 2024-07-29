<style>

</style>


<div id="full_modal" style="display: none;">
    <div class="full_modal_content">
        <form action="/admin/orders/create-po" id="order_form" autocomplete="nope"  />
            <input type="hidden" id="form-action" value="create" />
            @csrf
            <div class="full_modal_header">
                <a class="pull-right close" style="font-size:35px;font-weight:normal; line-height:100%;"><i class="fa fa-times-circle-o fa-lg" aria-hidden="true"></i></a>
                <h2 id="order-modal-title">Create New Order</h2>
            </div>
            <div class="full_modal_body">
                <div class="order_header">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="row form-group">
                                <div class="col-sm-4">
                                    <label>StoreName / Customer Name</label>
                                    <input type="text" name="customer" value="" required id="customer" autocomplete="nope"  placeholder="Search by store or customer."/>
                                    <ul class="pulldown-menu" id="customer-list" style="display:none;">
                                        <li><a href="#" id="button_new_customer"><big>Create New Customer</big></a></li>
                                    </ul>
                                    <input type="hidden" name="customer_id" value="" id="customer_id" />
                                </div>
    
                                <div class="col-sm-4">
                                    <label>Email</label>
                                    <input type="email" name="email" value="" id="email"/>
                                </div>
                            </div>
    
                            <div class="row form-group">
                                <div class="col-sm-4">
                                    <label>Billing Address:</label>
                                    <textarea name="address" id="address" required class="form-control" autocomplete="nope" rows="3"></textarea>
                                    <input type="hidden" name="address1" id="address1" required class="form-control" autocomplete="nope" />
                                    <input type="hidden" name="postalcode" id="postalcode" />
                                    <input type="hidden" name="city" id="city" />
                                    <input type="hidden" name="province" id="province" />
                                </div>
                                <div class="col-sm-2" id="pt">
                                    <label>Terms</label>
                                    <select name="terms" class="form-control" id="terms">
                                        <option value="0">--</option>
                                        @foreach($paymentterms as $paymentterm)
                                        <option value="{{$paymentterm->value}}">{{$paymentterm->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-3">
                                    <label>Order Date</label>
                                    <input type="date" name="order_date" id="order_date" value="{{date('Y-m-d')}}" value="" required />
                                </div>
                                
                                <div class="col-sm-3">
                                    <label>Due Date <span class="duedays"></span></label>
                                    <input type="date" name="due_date" id="due_date" value="{{date('Y-m-d',strtotime('tomorrow'))}}" value="" required/>
                                </div>
                            </div>
                            
                            <div class="row form-group">
                                <div class="col-sm-4">
                                    <label>Delivery Address</label>
                                    <textarea name="delivery_address" id="delivery_address" class="form-control" autocomplete="nope" rows="3"></textarea>
                                    <input type="hidden" name="delivery_address1" id="delivery_address1" class="form-control" autocomplete="nope" />
                                    <input type="hidden" name="delivery_postalcode" id="delivery_postalcode" />
                                    <input type="hidden" name="delivery_city" id="delivery_city" />
                                    <input type="hidden" name="delivery_province" id="delivery_province" />
                                </div>
                                <div class="col-sm-2">
                                    <label>Delivery Date</label>
                                    <input type="date" name="delivery_date" id="delivery_date" value="{{date('Y-m-d',strtotime('tomorrow'))}}" value="" required />
                                </div>
                                <div class="col-sm-3">
                                    <label>Driver</label>
                                    <select name="driver_id" id="driver_id" class="form-control">
                                        <option value="">--</option>
                                        @foreach($drivers as $driver)
                                        <option value="{{$driver->id}}">{{'#'.$driver->id . ' - '. $driver->firstname.' '.$driver->lastname}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="col-sm-3">
                                    <label>Sales Rep</label>
                                    <select name="sales_rep" class="form-control" id="sales_rep">
                                        <option value="0">--</option>
                                        @foreach($salesreps as $rep)
                                        <option value="{{$rep->id}}">{{'#'.$rep->id . ' - '. $rep->firstname.' '.$rep->lastname}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            
                        </div>
                        <div class="col-sm-6">
                            <div id="selectone" style="min-height:40px;text-align:right;display:none;" >
                           <!--     <a id="new-order2" style="cursor: pointer;">-->
                           <!--    New Order-->
                           <!--    <ul class="mainorder_dropdown" style="display:none;">-->
                           <!--        <li id="new-order">Create PO</li> -->
                           <!--        <li id="new-invoice">Create Invoice</li>-->
                           <!--    </ul>-->
                           <!--</a>-->
                                <select name="type" id="type" class="form-control" style="width:150px;display:inline-block;">
                                    <option value="order">Create PO</option>
                                    <option value="invoice">Create Invoice</option>
                                </select>
                            </div>
                            <div style="min-height:69px;text-align:right;font-size:150%;">
                                <span>Amount Due</span>
                                <a id="duelink"><span id="total_due" style="font-weight:700;display:block;" >$0.00</span></a>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6">
                                    <label>Notes</label>
                                    <textarea class="form-control" rows="6" name="notes" id="notes"></textarea>
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
    
            <div class="full_modal_footer" style="background:black;">
                <div class="modal-actions row clearfix">
                    <div class="mf_left col-md-4">
                        <button class="close black_button">Cancel</button>
                        <a class="clear black_button">Clear</a>
                    </div>
                     <div class="mf_center col-md-4">
                         <ul class="invoicemodal_menu">
                             <li><a href="#">Print or Preview</a></li>
                        
                         </ul>
                     </div>
                     <div class="mf_right col-md-4">
                        <button type="submit" class="submit green_button" name="submit">Submit</button>
                        <button type="submit" class="save green_button" name="submit">Save</button>
                        <a href="#" class="save_send green_button" name="submit">Save & Send</a>
                     </div>
                    </div>
 
            
                </div>
            </div>
        </form>
    </div>
</div>

