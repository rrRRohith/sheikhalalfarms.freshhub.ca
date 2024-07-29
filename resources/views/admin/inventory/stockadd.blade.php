<div id="stock_modal" style="display: none;">
    <div class="modal_box">
        <div class="modal_title">
            <a class="pull-right close"><i class="fa fa-close"></i></a>
            <h3><span id="mhead">Add Stock</span></h3>
        </div>
        <div class="modal_body">
            <div class="px-lg-3 no-padding fh_form" id="addAccountForm">
                <form class="pt-0" id="stock_form" method="post" action="{{admin_url('updatestock')}}">
                    @csrf
                    <input type="hidden" name="id" id="id">
                    <section class="form-block">
                        <div class="row">
                            <div class="col-md-12">  
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <label class="text-gray-dark" for="opportunity_source_id"> Product Name : <span id="prname"></span></label>
                                        
                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <label class="text-gray-dark" for="opportunity_source_id"> Stock Quantity</label>
                                        <input class="form-control" id="stock" name="stock" type="text" required>
                                        
                                    </div>
                                </div>
                                
                                
                                
                                
                                
                                
                            
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
