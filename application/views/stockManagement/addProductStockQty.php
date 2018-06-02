<div class="page-content-wrapper">
    <div class="page-content">
        <ul class="page-breadcrumb breadcrumb">
             
                        <li>
                            <a href="<?php echo __BASE_URL__;?>/admin/franchiseeList">Home</a>
                            <i class="fa fa-circle"></i>
                        </li>
                         <li>
                        <a onclick="viewClient(<?php echo $franchiseeArr['id'];?>);" href="javascript:void(0);"><?php echo $franchiseeArr['szName'];?></a>
                        <i class="fa fa-circle"></i>
                        </li>
                        <li>
                        <a onclick="#" href="javascript:void(0);"><?php echo $productDataAry['szProductCode'];?></a>
                        <i class="fa fa-circle"></i>
                        </li>
                        <li>
                            <span class="active">Model Stock Value Management</span>
                        </li>
     </ul>
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-equalizer font-red-sunglo"></i>&nbsp; &nbsp;
                            <span class="caption-subject  bold uppercase font-red-sunglo">Add Product Stock Quantity</span>
                        </div>
                        <div class="tools">
                                <a href="javascript:;" class="collapse"></a>     
                        </div>
                    </div>
                    <div class="portlet-body form">
                            <!-- BEGIN FORM-->
                        <form action=""  id="addProductStockQty" name="addProductStockQty" method="post" class="form-horizontal form-row-sepe">
                            <div class="form-body">
                                <div class="form-group <?php if(form_error('addProductStockQty[szName]')){?>has-error<?php }?>">
                                    <label class="control-label col-md-3">Product Category</label>
                                        <div class="col-md-4">
                                            <input id="szName" class="form-control input-large select2me read-only" type="text" readonly value="<?php echo set_value('addProductStockQty[szName]'); ?>" readonly placeholder="Category" onfocus="remove_formError(this.id,'true')" name="addProductStockQty[szName]" >
                                          <?php
                                            if(form_error('addProductStockQty[szName]')){?>
                                            <span class="help-block pull-left"><span><?php echo form_error('addProductStockQty[szName]');?></span>
                                            </span><?php }?>  
                                        </div>
                                </div>
                                <div class="form-group <?php if(form_error('addProductStockQty[szProductCode]')){?>has-error<?php }?>">
                                    <label class="control-label col-md-3">Product</label>
                                        <div class="col-md-4">
                                            <div id="product_container">
                                                 <input id="szProductCode" class="form-control input-large select2me read-only" type="text" readonly value="<?php echo set_value('addProductStockQty[szProductCode]'); ?>" readonly placeholder="Product Code" onfocus="remove_formError(this.id,'true')" name="addProductStockQty[szProductCode]">
                                             </div>
                                          
                                           <?php
                                            if(form_error('addProductStockQty[szProductCode]')){?>
                                            <span class="help-block pull-left"><span><?php echo form_error('addProductStockQty[szProductCode]');?></span>
                                            </span><?php }?>   
                                        </div>
                                </div>
                               
                                <div class="form-group <?php if(form_error('addProductStockQty[szQuantity]')){?>has-error<?php }?>">
                                    <label class="control-label col-md-3">Product Quantity</label>
                                        <div class="col-md-4">
                                           <div class="input-group">
                                                <input id="szQuantity" class="form-control input-large select2me" type="text" value="<?php echo set_value('addProductStockQty[szQuantity]'); ?>" placeholder="Product Quantity" onfocus="remove_formError(this.id,'true')" name="addProductStockQty[szQuantity]">
                                            </div>
                                          <?php
                                            if(form_error('addProductStockQty[szQuantity]')){?>
                                            <span class="help-block pull-left"><span><?php echo form_error('addProductStockQty[szQuantity]');?></span>
                                            </span><?php }?> 
                                        </div>
                                </div>  
                                
                            <div class="row">
                                <div class="col-md-offset-3 col-md-4">
                                    <a href="<?=__BASE_URL__?>/stock_management/productstockqty" class="btn default uppercase" type="button">Cancel</a>
                                    <input type="submit" class="btn green-meadow" value="SAVE" name="addProductStockQty[submit]">
                                </div>
                            </div>
                         
                            </div>
                           
                        </form>    
                    </div>
                </div>
            </div>
        </div> 
    </div>
</div>    
