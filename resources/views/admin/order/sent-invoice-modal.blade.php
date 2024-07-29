<div id="sendinvoice_modal" style="display: none;">
    <div class="modal_box">
        <div class="modal_title">
            <a class="pull-right close"><i class="fa fa-close"></i></a>
            <h3><span id="mhead">Send Email</span></h3>
        </div>
        <form class="pt-0" id="stock_form" method="post" action="{{url('admin/orders/sendinvoice')}}">
            @csrf
            <div class="modal_body">
                <div class="px-lg-3 no-padding fh_form" id="addAccountForm">
                    
                        <input type="hidden" name="orderid" id="orderid">
                        <section class="form-block">
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
                                            <input type="text" name="modalsubject" value="" id="modalsubject" required/>
                                        </div>
                                        <div class="col-sm-12">
                                            <label>Body</label>
                                            <textarea name="body" id="modalbody" rows="4" class="form-control" required></textarea>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="col-sm-6"  style="border:1px solid black">
                                    <div class="row form-group">
                                        <div class="invoicemail_address">
                                            <div class="col-sm-12">
                                                <label>From : &nbsp; </label><span id="mailfrom">admin@freshhub.ca</span>
                                            </div>
                                            <div class="col-sm-12">
                                                <label>To     : &nbsp; </label><span id="mailto">admin@freshhub.ca</span>
                                            </div>
                                        </div>
                                        <hr>
                                        <h3 id="mailsubject">Invoice #1001 from Freshhub</h3>
                                        <div class="col-sm-12 bodymail" style="overflow-y:auto;height:350px;">
                                            <div class="form-group">
                                                <div class="col-sm-12" style="color:#6b6c72">
                                                    <center><span id="mailhead">Invoice No:1001 Details</span></center>
                                                    <center><img src="/img/freshhub_logo.png" class="header-logo" alt="Fresh Hub" title="Fresh Hub"/></center>
                                                </div>
                                                <div class="dueamount_box">
                                                    <center><h4 id="maildue">23/01/2022</h4></center>
                                                   
                                                    <center><h3 id="mailamount">$5000.00</h3></center>
                                                    <center><button class="green_button">Review and Pay</button></center>
                                                </div>
                                                <div id="mailbody">
                                                    <p>To:<span> Albin Scaria</span></p>
                                                    <p>We appreciate your business. Please find your invoice details here. Feel free to contact us if you have any questions.</p>
                                                    
                                                    <p>Have a great day!
                                                    Freshhub</p>
                                                    
                                                </div>
                                                <div id="mailtext">
                                                    
                                            
                                                    
                                                </div>
                                                <div class="col-sm-12" id="mailproduct">
                                                    <table border="0"style="text-align: center;width: 100%;">
                                                        <tr>
                                                            <th width="50%">Chicken Head</th>
                                                            <th width="50%" rowspan="2">$50</th>
                                                        </tr>
                                                        <tr>
                                                            <td>5 * $5 $11.05</td>
                                                        </tr>
                                                        <tr><th>Subtotal</th><th></th></tr><tr><th>Tax</th><th></th></tr><tr><th>Total</th><th></th></tr><tr><th>Balance Due</th><th></th></tr>
                                                    </table>
                                                </div>
                                                
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!--<div class="col-sm-12">-->
                                <!--    <button type="submit" class="btn btn-success btn-block green_button">-->
                                <!--        <clr-icon shape="floppy"></clr-icon>-->
                                <!--       send                        -->
                                <!--    </button>-->
                               
                                <!--</div>-->
                                   
                        </div>
                             
                       </section>
                 </div>
            </div>
            <div class="modal_footer">
                <div class="modal-actions">
                    <a href="#" class="close white_button">Cancel</a>
                    <button type="submit" class="white_button" name="submit" value="print">Print</button>
                    <!--<a href="#" class="print white_button">Print</a>-->
                    <button type="submit" class="sendandclose green_button" name="submit" value="send">Send and Close</button>
                </div>
            </div>
        </form>
    </div>
</div>
