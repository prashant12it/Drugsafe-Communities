<div class="page-content-wrapper">
    <div class="page-content">
        <?php $operation_manager_id = $this->Franchisee_Model->getoperationManagerId($franchiseeArr['id']);
                        $franchiseeDetArr = $this->Admin_Model->getAdminDetailsByEmailOrId('', $operation_manager_id['operationManagerId']);?>
          <ul class="page-breadcrumb breadcrumb">
             
                        <li>
                            <a href="<?php echo __BASE_URL__;?>/admin/franchiseeList">Home</a>
                            <i class="fa fa-circle"></i>
                        </li>
                        <li>
                        <a onclick="viewFranchisee(<?php echo $operation_manager_id['operationManagerId'];?>);" href="javascript:void(0);"><?php echo $franchiseeDetArr['szName'];?></a>
                        <i class="fa fa-circle"></i>
                        </li>
                         <li>
                        <a onclick="viewClient(<?php echo $franchiseeArr['id'];?>);" href="javascript:void(0);"><?php echo $franchiseeArr['szName'];?></a>
                        <i class="fa fa-circle"></i>
                        </li>
                        <li>
                        <a href="<?php echo __BASE_URL__;?>/stock_management/modelstockvalue"><?php echo $productDataAry['szProductCode'];?></a>
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
                            <span class="caption-subject  bold uppercase font-red-sunglo">Add Model Stock Value</span>
                        </div>
                        <div class="tools">
                                <a href="javascript:;" class="collapse"></a>     
                        </div>
                    </div>
                    <div class="portlet-body form">
                            <!-- BEGIN FORM-->
                        <form action=""  id="addModelStockValue" name="addModelStockValue" method="post" class="form-horizontal form-row-sepe">
                            <div class="form-body">
                                <div class="form-group <?php if(form_error('addModelStockValue[szName]')){?>has-error<?php }?>">
                                    <label class="control-label col-md-3">Product Category</label>
                                        <div class="col-md-4">
                                            <input id="szName" class="form-control input-large select2me read-only" type="text" readonly value="<?php echo set_value('addModelStockValue[szName]'); ?>" placeholder="Category" onfocus="remove_formError(this.id,'true')" name="addModelStockValue[szName]">
                                          <?php
                                            if(form_error('addModelStockValue[szName]')){?>
                                            <span class="help-block pull-left"><span><?php echo form_error('addModelStockValue[szName]');?></span>
                                            </span><?php }?>  
                                        </div>
                                </div>
                                <div class="form-group <?php if(form_error('addModelStockValue[szProductCode]')){?>has-error<?php }?>">
                                    <label class="control-label col-md-3">Product</label>
                                        <div class="col-md-4">
                                            <div id="product_container">
                                                 <input id="szProductCode" class="form-control input-large select2me read-only" type="text" readonly value="<?php echo set_value('addModelStockValue[szProductCode]'); ?>" placeholder="Product Code" onfocus="remove_formError(this.id,'true')" name="addModelStockValue[szProductCode]">
                                             </div>
                                          
                                           <?php
                                            if(form_error('addModelStockValue[szProductCode]')){?>
                                            <span class="help-block pull-left"><span><?php echo form_error('addModelStockValue[szProductCode]');?></span>
                                            </span><?php }?>   
                                        </div>
                                </div>
                               
                                <div class="form-group <?php if(form_error('addModelStockValue[szModelStockVal]')){?>has-error<?php }?>">
                                    <label class="control-label col-md-3">Model Stock value</label>
                                        <div class="col-md-4">
                                           <div class="input-group">
                                                <input id="szModelStockVal" class="form-control input-large select2me" type="text" value="<?php echo set_value('addModelStockValue[szModelStockVal]'); ?>" placeholder="Model Stock Value" onfocus="remove_formError(this.id,'true')" name="addModelStockValue[szModelStockVal]">
                                            </div>
                                          <?php
                                            if(form_error('addModelStockValue[szModelStockVal]')){?>
                                            <span class="help-block pull-left"><span><?php echo form_error('addModelStockValue[szModelStockVal]');?></span>
                                            </span><?php }?> 
                                        </div>
                                </div>  
                                
                            <div class="row">
                                <div class="col-md-offset-3 col-md-4">
                                    <a href="<?=__BASE_URL__?>/stock_management/modelstockvalue" class="btn default uppercase" type="button">Cancel</a>
                                    <input type="submit" class="btn green-meadow" value="SAVE" name="addModelStockValue[submit]">
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