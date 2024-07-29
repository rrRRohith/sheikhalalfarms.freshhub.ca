<div id="product_creator_wrapper1" style="display:none;">
    <div id="product_creator">
        <div class="pc_wrapper1">
            <form action="/admin/products/create" id="update-stock" method="post">
                @csrf
                <input type="hidden" id="product_id" value="" name="pro_id">
                <input type="hidden" id="row_id" value="" name="row_id">
                <div class="pc_header">
                    <a href="#" class="pcedit_close"><i class="fa fa-close"></i></a>
                    <h3>Add Stock</h3>
                </div>
                <div class="pc_body">
                    
                    <div class="row">
                        <div class="col-sm-12">
                            <p>Enter Product Information</p>
                            <hr/>
                            <div class="form-group">
                                <label>Product Name</label>
                                <input type="text" name="name" id="name" class="form-control" readonly/>
                            </div>
                        </div>
                        <div class="col-sm-7">
                            
                            <div class="form-group">
                                <label>SKU</label>
                                <input type="text" name="sku" id="sku" class="form-control" readonly/>
                            </div>
                            
                            <div class="form-group">
                                <label>Category</label>
                                <select  class="form-control" name="category_id" id="category_id" disabled>
                                     @foreach($categories as $p)
                                       <option value="{{$p->id}}" >{{$p->name}}</option>
                                     @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <!--<img id="uploaded-image"  style="display:block;width:150px;height:auto;">-->
                                <img id="uploaded-image2"  style="display:block;width:150px;height:auto;">
                                            <label class="text-gray-dark" for="opportunity_source_id">Image</label>
                                           <!--<br><input type="file" accept="image/*" id="pictur1">-->
                                            <input type="hidden" name="picture" id="picture1" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                    
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label>Unit Type</label>
                                <select  class="form-control" name="unittype" id="unittype" disabled>
                                   <option value="">Select Unit</option>
                                   @foreach($units as $u)
                                   <option value="{{$u->id}}" >{{$u->name}} - {{$u->shortcode}}</option>
                                   @endforeach 
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Unit</label>
                                <input type="number" class="form-control" name="unit" id="unit" value="1" readonly/>
                            </div>
                        </div>
                        
                    </div>
                    <div class="row">
                        
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label>Weight</label>
                                <input type="text" class="form-control" name="weight" id="weight" value="1"   readonly/>
                            </div>
                        </div>
    
                        
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Price</label>
                                <input type="text" class="form-control" name="price" id="price" value="0.00" readonly/>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label>Price By</label>
                                <select class="form-control" name="price_by" id="price_by" disabled>
                                    <option value="quantity">Quantity</option>
                                    <option value="weight" selected>Weight</option>
                                </select>
                            </div>
                        </div>
                        
                    </div>
                    
                    <div class="row">
                        
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Description</label>
                                <textarea rows="9"  class="form-control" name="description" id="description1" readonly></textarea>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Availiable stock</label>
                                <div id="availstock"></div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Add stock</label>
                                <input type="text" class="form-control" name="stock" id="stock" required/>
                            </div>
                        </div>
    
                    
                    </div>
                        
                </div>
                <div class="pc_footer">
                    <button type="submit" class="green_button" id="create_product_button">Submit</button>
                </div>
            </form>
        </div>
        <div class="loading-info1">
            Updating product... 
        </div>
    </div>
</div>
<div id="stock_modal1" style="display: none;">
    <div class="modal_box">
        <div class="modal_title">
            <!--<a class="pull-right close"><i class="fa fa-close"></i></a>-->
            <h3><span id="mhead">Out of Stock Warning</span></h3>
        </div>
        <div class="modal_body">
            <div class="px-lg-3 no-padding fh_form" id="addAccountForm">
                    <input type="hidden" name="id" id="pid">
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
                                        <label class="text-gray-dark" for="opportunity_source_id">Availiable Stock Quantity: <span id="avstock"></span></label>
                                        
                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <label>Do you want to add stock? </label>
                                    </div>
                                </div>
                                
                                
                                
                                
                                
                                
                            
                            </div>
                            
                            <div class="col-sm-12">
                                <button class="btn btn-success btn-block green_button yesbutton" data-id="" data-rowid="">
                                    <clr-icon shape="floppy"></clr-icon>
                                   Yes                      
                                </button>
                                <button class="btn btn-success btn-block red_button nobutton">
                                    <clr-icon shape="floppy"></clr-icon>
                                   No                     
                                </button>
                           
                            </div>
                               
                    </div>
                         
                   </section>
                 
                   

                      
                 
                
             </div>
        </div>
        <div class="modal_footer">

        </div>
    </div>
</div>