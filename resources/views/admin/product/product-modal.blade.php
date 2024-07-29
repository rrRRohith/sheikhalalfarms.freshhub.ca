<div id="product_creator_wrapper" style="display:none;">
    <div id="product_creator">
        <form action="/admin/products/create" id="create-product">
        <div class="pc_wrapper">
                @csrf
                <div class="pc_header">
                    <a href="#" class="pc_close"><i class="fa fa-close"></i></a>
                    <h4>Create New Product</h4>
                </div>
                <div class="pc_body">
                    
                    <div class="row">
                        <div class="col-sm-12">
                            <h5>Enter Product Information</h5>
                            <hr/>
                            <div class="form-group">
                                <label>Product Name</label>
                                <input type="text" name="name" class="form-control" required />
                            </div>
                        </div>
                        <div class="col-sm-7">
                            
                            <div class="form-group">
                                <label>SKU</label>
                                <input type="text" name="sku" class="form-control" required />
                            </div>
                            
                            <div class="form-group">
                                <label>Category</label>
                                <select  class="form-control" name="category_id">
                                     @foreach($categories as $p)
                                       <option value="{{$p->id}}" >{{$p->name}}</option>
                                     @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <img id="uploaded-image"  style="display:block;width:150px;height:auto;">
                                            <label class="text-gray-dark" for="opportunity_source_id">Image</label>
                                           <br><input type="file" accept="image/*" id="pictur">
                                            <input type="hidden" name="picture" id="picture" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                    
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label>Unit Type</label>
                                <select  class="form-control" name="unittype" required>
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
                                <input type="number" class="form-control" name="unit" value="1" required />
                            </div>
                        </div>
                        
                    </div>
                    <div class="row">
                        
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label>Weight (<span>{{defWeight()}}</span>)</label>
                                <input type="text" class="form-control" name="weight" value="1"  />
                            </div>
                        </div>
    
                        
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Price</label>
                                <input type="text" class="form-control" name="price" value="0.00" required />
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label>Price By</label>
                                <select class="form-control" name="price_by">
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
                                <textarea rows="3"  class="form-control" name="description"></textarea>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label>Stock</label>
                                <input type="number" class="form-control" min="0" step="1" name="stock" id="stock" value="0" />
                            </div>
                        </div>

                        @if(isset($customers))
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Customer price</label>
                                <div class="form-control" style="height:100px;overflow-y:scroll;" id="customer_price" >
                                    <table>
                                        @foreach($customers as $custr)
                                        <tr>
                                            <td>{{$custr->business_name}} {{$custr->business_name != '' ? $custr->firstname.' '.$custr->lastname:' ('.$custr->firstname.' '.$custr->lastname.')'}} </td>
                                            <td>&nbsp;</td>
                                            <td><input type="number" name="customer[{{$custr->id}}]" value="" style="width:80px;" /></td>
                                        </tr>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                        </div>
                        @endif
    
                    
                    </div>
                        
                </div>
                <div class="pc_footer">
                    <button type="submit" class="green_button" id="create_product_button">Submit</button>
                </div>
            
        </div>
        </form>
        <div class="loading-info">
            Creating product... 
        </div>
    </div>
</div>
<div class="modal" tabindex="-1" role="dialog" id="uploadimageModal">
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