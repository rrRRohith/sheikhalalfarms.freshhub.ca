<div id="sendinvoice_modal" style="display: none;">
    <div class="sendinvoice_modal_content">
        <form action="" id="order_form" method="post"/>
            <input type="hidden" id="form-action" value="create" />
        @csrf
        <div class="sendinvoice_modal_header">
            <a class="pull-right close"><i class="fa fa-close"></i></a>
            <h2 id="order-modal-title">Send Email</h2>
        </div>
        <div class="sendinvoice_modal_body">
            <div class="order_body">
                
                    <div class="neworder-topfields" style="width:100%;">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label>From</label>
                                        <input type="text" name="from" id="modalfrom" autocomplete="off" value="admin@freshhub.ca" disabled/>
                                    </div>
        
                                    <div class="col-sm-12">
                                        <label>To</label>
                                        <input type="email" name="to" value="" id="modalto" required readonly />
                                    </div>
                                    <div class="col-sm-12">
                                        <label>Subject</label>
                                        <input type="text" name="subject" value="" id="modalsubject" required/>
                                    </div>
                                    <div class="col-sm-12">
                                        <label>Body</label>
                                        <textarea name="body" id="modalbody" rows="4" class="form-control" required></textarea>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="col-sm-6"  style="border:1px solid black">
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label>From : </label><span id="mailfrom">admin@freshhub.ca</span>
                                    </div>
                                    <div class="col-sm-12">
                                        <label>To : </label><span id="mailto">admin@freshhub.ca</span>
                                    </div>
                                    <hr>
                                    <h3 id="mailsubject">Invoice #1001 from Freshhub</h3>
                                    <div class="col-sm-12 bodymail" style="overflow-y:auto;height:180px;">
                                        <div class="row form-group">
                                            <div class="col-sm-12" style="color:#6b6c72">
                                                <center><span id="mailhead">Invoice No:1001 Details</span></center>
                                                <center><img src="/img/freshhub_logo.png" class="header-logo" alt="Fresh Hub" title="Fresh Hub" style="width:120px;height:auto;"></center>
                                            </div>
                                            <div class="col-sm-12" style="margin-top:10px;background:aliceblue;padding:5px;">
                                                <center><h4 id="maildue">23/01/2022</h4></center>
                                               
                                                <center><h3 id="mailamount">$5000.00</h3></center>
                                                <center><button class="green_button">Review and Pay</button></center>
                                            </div>
                                            <div class="col-sm-12" id="mailbody">
                                                To:<span> Albin Scaria</span>
                                                <p>We appreciate your business. Please find your invoice details here. Feel free to contact us if you have any questions.
                                                
                                                Have a great day!
                                                Freshhub</p>
                                                
                                            </div>
                                            
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                 
                
            </div>

            <!--<div class="order_body">-->
            <!--    <div class="row">-->
            <!--        <div class="col-sm-12" id="table-container">-->
            <!--            <table class="table order_table" id="items-table1">-->
            <!--        <thead>-->
            <!--            <tr>-->
            <!--                <th class="number_column">#</th>-->
            <!--                <th class="text-left">Description</th>-->
            <!--                <th class="text-left">Due Date</th>-->
            <!--                <th class="text-right">Original Amount</th>-->
            <!--                <th class="text-right">Open Balance</th>-->
            <!--                <th class="text-right">Payment</th>-->
                            
            <!--            </tr>-->
            <!--        </thead>-->
            <!--        <tbody> -->
                    
            <!--        </tbody>-->
            <!--     </table>-->
                        
            <!--        </div>-->
            <!--        <div class="col-sm-6">-->
            <!--            <label>Memo</label>-->
            <!--            <textarea class="form-control" rows="3" name="notes" id="notes" placeholder="Notes"></textarea>-->
            <!--        </div>-->
            <!--        <div class="col-sm-6 text-right" >-->
            <!--            <p><label>Amount to apply</label>  : <span id="amountapply">$123</span></p>-->
            <!--            <p><label>Amount to Credit</label> : <span id="amountcredit">$123</span></p>-->
            <!--        </div>-->

                    
            <!--    </div>-->
            <!--</div>-->

            <div class="order_footer">
                <div class="row">
                    <div class="col-sm-6">

                    </div>
                </div>
            </div>
        </div>

        <div class="sendinvoice_modal_footer">
            <div class="modal-actions">
                <a href="#" class="close white_button">Cancel</a>
                <a href="#" class="sendandclose white_button">Print</a>
                <!--<a href="#" class="print white_button">Print</a>-->
                <button type="submit" class="sendandclose green_button" >Send and Close</button>
            </div>
        </div>
        </form>
    </div>
</div>

