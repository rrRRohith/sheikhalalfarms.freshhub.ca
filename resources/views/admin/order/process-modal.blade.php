<div id="process_modal" style="display: none;">

    <div class="process_modal_content">



        <h4>Modify Item</h4>

        <hr/>

        <table cellpadding="10" width="100%">

            <tr>

                <th>Item</th>

                <th>

                    <div id="process-product"></div>

                </th>

            </tr>

            <tr>

                <th>Order Qty</th>

                <th>

                    <input type="number" class="form-control" id="changed-quantity" value="0" />

                    <input type="hidden" id="original-quantity" value="0" />

                    <input type="hidden" id="process-id" value="">
                    
                    <input type="hidden" id="availqty" value="">

                </th>

            </tr>

            <tr class="hideinvoice">

                <th>Backorder Removed Items?</th>

                <th><input type="checkbox" id="send-backorder" checked /></th>

            </tr>

            <tr class="hideinvoice">

                <th>Backorder Qty</th>

                <th><input type="number" class="form-control" id="backorder-quantity" value="0" /></th>

            </tr>

        </table>



        <p>&nbsp;</p>



        <h5>Enter Weight Info</h5>



        <hr/>







        <ul id="weight-list">

           

        </ul>

        

        <div class="action-buttons text-right">

           

                <button class="green_button update">Update</button> <button class="white_button close">Cancel</button>

            

        </div>

    </div>

</div>

