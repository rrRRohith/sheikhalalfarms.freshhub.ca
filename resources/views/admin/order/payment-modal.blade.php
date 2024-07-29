<div id="payment_modal" style="display: none;">
    <div class="payment_modal_content">
        <form action="/admin/invoices/makepayment" id="order_form" method="post"/>
            <input type="hidden" id="form-action" value="create" />
        @csrf
        <div class="payment_modal_header">
            <a class="pull-right close"><i class="fa fa-close"></i></a>
            <h2 id="order-modal-title">Receive Payment</h2>
        </div>
        <div class="payment_modal_body">
            <div class="order_header">
                
                    <div class="neworder-topfields" style="width:100%;">
                        <div class="row">
                            <div class="col-sm-6">
                                
                            
                        <div class="row form-group">
                            <div class="col-sm-6">
                                <label>Customer</label>
                                <input type="text" name="customer" id="customer1" autocomplete="off" disabled/>
                                <ul class="pulldown-menu" id="customer-list" style="display:none;">
                                    <!--<li><a href="#" id="button_new_customer"><big>Create New Customer</big></a></li>-->
                                </ul>
                                <input type="hidden" name="customer_id" value="" id="customer_id1" />
                            </div>

                            <div class="col-sm-6">
                                <label>Email</label>
                                <input type="email" name="email" value="" id="email1" required readonly />
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-4">
                                <label>Payment Date</label>
                                <input type="date" name="payment_date" id="payment_date" value="{{date('Y-m-d',strtotime('today'))}}" value="" required />
                            </div>
                            <div class="col-sm-4">
                                <label>Payment Method</label>
                                <select class="form-control" name="paymentmethod" id="paymentmethod">
                                    <option value="">Select</option>
                                    @foreach($paymentmethods as $paymentmethod)
                                    <option value="{{$paymentmethod->id}}">{{$paymentmethod->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label>Reference Number </label>
                                <input type="text" name="reference" id="reference" class="form-control"/>
                            </div>
                            
                            
                        </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="row form-group">
                            <div class="col-sm-12" style="text-align:right;">
                                <strong><b>Amount Received</b></strong>
                                <br>
                                <span id="amountreceived"></span>
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
                 
                
            </div>

            <div class="order_body">
                <div class="row">
                    <div class="col-sm-12" id="table-container">
                        <table class="table order_table" id="items-table1">
                    <thead>
                        <tr>
                            <th class="number_column">#</th>
                            <th class="text-left">Description</th>
                            <th class="text-left">Due Date</th>
                            <th class="text-right">Original Amount</th>
                            <th class="text-right">Open Balance</th>
                            <th class="text-right">Payment</th>
                            
                        </tr>
                    </thead>
                    <tbody> 
                    <!--<tr id="row0" class="product_row">-->
                    <!--    <td class="text-center number_column" valign="middle"><span class="row-id" style="display:none">0</span><input type="checkbox" name="invid" id="invid"></td>-->
                    <!--    <td class="text-left">-->
                    <!--        <span id="description"></span>-->
                    <!--    </td>-->
                    <!--    <td class="text-left" ><span id="due_date"></span></td>-->
                    <!--    <td class="text-right"><span id="original_amount"></span></div></td>-->
                    <!--    <td class="text-right"><input type="hidden" name="balamount" id="balamount"><span id="balance"></span></td>-->
                    <!--    <td class="text-right"><input type="text" name="payamount" id="payamount"  class="form-control" style="text-align:right;"/></td>-->
                        
                    <!--</tr>-->
                    </tbody>
                 </table>
                        
                    </div>
                    <div class="col-sm-6">
                        <label>Memo</label>
                        <textarea class="form-control" rows="3" name="notes" id="notes" placeholder="Notes"></textarea>
                    </div>
                    <div class="col-sm-6 text-right" >
                        <p><label>Amount to apply</label>  : <span id="amountapply">$123</span></p>
                        <p><label>Amount to Credit</label> : <span id="amountcredit">$123</span></p>
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

        <div class="payment_modal_footer">
            <div class="modal-actions">
                <a href="#" class="close white_button">Close</a>
                <!--<a href="#" class="print white_button">Print</a>-->
                <button type="submit" class="green_button" >Pay Now</button>
            </div>
        </div>
        </form>
    </div>
</div>

