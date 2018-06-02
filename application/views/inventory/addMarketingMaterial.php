<div class="page-content-wrapper">
        <div class="page-content">
            <div id="page_content" class="row">
                
                <div class="col-md-12">
                     <ul class="page-breadcrumb breadcrumb">
                        <li>
                            <a href="<?php echo __BASE_URL__;?>/inventory/marketingmateriallist">Home</a>
                            <i class="fa fa-circle"></i>
                        </li>
                        <li>
                            <span class="active">Add Marketing Material </span>
                        </li>
                    </ul>
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-equalizer font-red-sunglo"></i>
                                <span class="caption-subject font-red-sunglo bold uppercase">Add Marketing Material</span>
                            </div>
                            <div class="actions">
                                <div class="btn-group btn-group-devided" data-toggle="buttons">
                                </div>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <form class="form-horizontal" id="clientData" action="<?php echo __BASE_URL__?>/inventory/addMarketingMaterial" name="productDate" method="post">
                                <div class="form-body">
                                    <div class="form-group <?php if(form_error('productData[szProductCode]')){?>has-error<?php }?>">
                                        <label class="col-md-3 control-label"> Product Code</label>
                                        <div class="col-md-5">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-tags"></i>
                                                </span>
                                                <input id="szProductCode" class="form-control" type="text" value="<?php echo set_value('productData[szProductCode]'); ?>" placeholder="Product Code" onfocus="remove_formError(this.id,'true')" name="productData[szProductCode]">
                                            </div>
                                            <?php
                                            if(form_error('productData[szProductCode]')){?>
                                            <span class="help-block pull-left"><span><?php echo form_error('productData[szProductCode]');?></span>
                                            </span><?php }?>
                                           
                                        </div>
                                    </div>
                               
                                     <div class="form-group <?php if(form_error('productData[szProductCost]')){?>has-error<?php }?>">
                                        <label class="col-md-3 control-label"> Product Cost </label>
                                        <div class="col-md-5">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-dollar"></i>
                                                </span>
                                                <input id="szProductCost" class="form-control" type="text" value="<?php echo set_value('productData[szProductCost]'); ?>" placeholder="Product Cost" onfocus="remove_formError(this.id,'true')" name="productData[szProductCost]">
                                            </div>
                                             <?php
                                            if(form_error('productData[szProductCost]')){?>
                                            <span class="help-block pull-left"><span><?php echo form_error('productData[szProductCost]');?></span>
                                            </span><?php }?>
                                        </div>
                                    </div>
                                    <div class="form-group <?php if(form_error('productData[szProductDiscription]')){?>has-error<?php }?>">
                                        <label class="col-md-3 control-label"> Product Description</label>
                                        <div class="col-md-5">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-file-text"></i>
                                                </span>
                                                 <textarea  name="productData[szProductDiscription]" id="szProductDiscription" class="form-control"  value=""  rows="5" placeholder="Product Description" onfocus="remove_formError(this.id,'true')" ><?php echo set_value('productData[szProductDiscription]'); ?></textarea>
                                              
                                            </div>
                                              <?php
                                            if(form_error('productData[szProductDiscription]')){?>
                                            <span class="help-block pull-left"><span><?php echo form_error('productData[szProductDiscription]');?></span>
                                            </span><?php }?>
                                        </div>
                                    </div>
                                    <div class="form-group <?php if(form_error('productData[supplier]')){?>has-error<?php }?>">
                                        <label class="col-md-3 control-label"> Supplier Name</label>
                                        <div class="col-md-5">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-user"></i>
                                                </span>
                                                 <input id="supplier" class="form-control" type="text" value="<?php echo set_value('productData[supplier]'); ?>" placeholder="Supplier Name" onfocus="remove_formError(this.id,'true')" name="productData[supplier]">
                                              
                                            </div>
                                              <?php
                                            if(form_error('productData[supplier]')){?>
                                            <span class="help-block pull-left"><span><?php echo form_error('productData[supplier]');?></span>
                                            </span><?php }?>
                                        </div>
                                    </div>
                                    <div class="form-group <?php if(form_error('productData[szAvailableQuantity]')){?>has-error<?php }?>">
                                        <label class="col-md-3 control-label"> Available Quantity</label>
                                        <div class="col-md-5">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-cubes"></i>
                                                </span>
                                                 <input id="szAvailableQuantity" class="form-control" type="text" value="<?php echo set_value('productData[szAvailableQuantity]'); ?>" placeholder="Available Quantity" onfocus="remove_formError(this.id,'true')" name="productData[szAvailableQuantity]">
                                              
                                            </div>
                                              <?php
                                            if(form_error('productData[szAvailableQuantity]')){?>
                                            <span class="help-block pull-left"><span><?php echo form_error('productData[szAvailableQuantity]');?></span>
                                            </span><?php }?>
                                        </div>
                                    </div>
                                     <div class="form-group <?php if(form_error('productData[min_ord_qty]')){?>has-error<?php }?>">
                                        <label class="col-md-3 control-label"> Minimum Order Quantity</label>
                                        <div class="col-md-5">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-cubes"></i>
                                                </span>
                                                 <input id="min_ord_qty" class="form-control" min="1" type="number"  value="<?php echo set_value('productData[min_ord_qty]'); ?>" placeholder="Minimum Order Quantity" onfocus="remove_formError(this.id,'true')" name="productData[min_ord_qty]">
                                              
                                            </div>
                                              <?php
                                            if(form_error('productData[min_ord_qty]')){?>
                                            <span class="help-block pull-left"><span><?php echo form_error('productData[min_ord_qty]');?></span>
                                            </span><?php }?>
                                        </div>
                                    </div>
                                      <div class="form-group <?php if(form_error('productData[model_stk_val]')){?>has-error<?php }?>">
                                        <label class="col-md-3 control-label"> Model Stock Value</label>
                                        <div class="col-md-5">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-cube"></i>
                                                </span>
                                                <input id="model_stk_val" class="form-control"  type="number" min="1" value="<?php echo set_value('productData[model_stk_val]'); ?>" placeholder="Model Stock Value" onfocus="remove_formError(this.id,'true')" name="productData[model_stk_val]">
                                              
                                            </div>
                                              <?php
                                            if(form_error('productData[model_stk_val]')){?>
                                            <span class="help-block pull-left"><span><?php echo form_error('productData[model_stk_val]');?></span>
                                            </span><?php }?>
                                        </div>
                                    </div>
                                     <div class="form-group <?php if(form_error('productData[dtExpiredOn]')){?>has-error<?php }?>">
                                             <label class="col-md-3 control-label">Expiry Date</label>
                                            <div class="col-md-3">
                                                    <div class="input-group input-medium date date-picker" data-date-format="dd-mm-yyyy" data-date-start-date="+0d">
                                                         <span class="input-group-addon">
                                                         <i class="fa fa-times"></i>
                                                         </span>
                                                        <input type="text" id="dtExpiredOn" class="form-control" value="<?php echo set_value('productData[dtExpiredOn]'); ?>" readonly placeholder="Expired On" onfocus="remove_formError(this.id,'true')" name="productData[dtExpiredOn]">
                                                            <span class="input-group-addon">
                                                            <i class="fa fa-calendar"></i></button>
                                                            </span>
                                                    </div>
                                                    <!-- /input-group -->
                                                  <?php
                                            if(form_error('productData[dtExpiredOn]')){?>
                                            <span class="help-block pull-left"><span><?php echo form_error('productData[dtExpiredOn]');?></span>
                                            </span><?php }?>  
                                            </div>
                                    </div>
                                     
                                    <div class="form-group <?php if(form_error('productData[szProductImage]')){?>has-error<?php }?>">
                                        <label class="col-md-3 control-label">Product Image</label>
                                        <div class="col-md-5">
                                            <div class="input-group">
                                                <div class="profile-userbuttons">
                                                    <div id="product_image">
                                                        <?php
                                                        $NewImageName=set_value('productData[szProductImage]');
							if($NewImageName!= '')
                                                        {
                                                            ?>
							        <img class="file_preview_image" src="<?php echo __BASE_USER_PRODUCT_IMAGES_URL__; ?>/<?php echo $NewImageName; ?>" width="60" height="60"/>
                                                                <a href="javascript:void(0);" id="remove_btn_<?php echo $randomNum; ?>" class="btn red-intense btn-sm" onclick="removeIncidentPhoto('');">Remove</a>
                                                     </div>
															<?php
                                                        }
                                                        ?>
                                                    </div>
                                                    <div class="<?php if($NewImageName) { ?> hide <?php }?>"  id="product_image_upload" onfocus="remove_formError(this.id,'true')">Upload</div>
                                                </div>
                                                <input type="hidden" name="productData[szProductImage]" id="szProductImage" value="<?php echo set_value('productData[szProductImage]'); ?>" onfocus="remove_formError(this.id,'true')" /> 
                                            <p id="upload_error_status" class="hide" style="font-color:#e73d4a">Error occur while uploading image. Please inform to Anova Golf.</p>
                                        </div>
                                             <?php
                                            if(form_error('productData[szProductImage]')){?>
                                            <span class="help-block pull-left"><span><?php echo form_error('productData[szProductImage]');?></span>
                                            </span><?php }?>
                                            
                                        </div>
                                        <input type="hidden" name="productData[szProductCategory]" id="szProductCategory" value="2"/> 
                                    </div>
                                    <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-4">
                                            <a href="<?= __BASE_URL__ ?>/inventory/marketingmateriallist" class="btn default uppercase"
                                           type="button">Cancel</a>
                                            <input type="submit" class="btn green-meadow" value="SAVE" name="productData[submit]">
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
    </div>
    
 <script type="text/javascript">

        $(document).ready(function()
        {

            var settings = {
                    url: "<?php echo __BASE_URL__; ?>/inventory/uploadProfileImage",
                    method: "POST",
                    allowedTypes:"jpg,png,gif,jpe,jpeg,JPEG,JPG,PNG",
                    fileName: "myfile",
                    multiple: true,
                    onSuccess:function(files,data,xhr)
                    {
                        $("#status").html("<font color='green'>Upload is success</font>");
                        data = JSON.parse(data);
                        $('#product_image').show();
                        $("#product_image").html(data.img_div);
                        $("#szProductImage").val(data.name);
                    },
                    afterUploadAll:function()
                    {
                        $(".profile-userbuttons .ajax-upload-dragdrop").addClass('hide');
                        $(".profile-userbuttons .upload-statusbar").addClass('hide')
                        $('#product_image').removeClass('hide');
                        $('.help-block').addClass('hide');
                    },
                    onError: function(files,status,errMsg)
                    {		
                        $("#upload_error_status").removeClass('hide');
                    }
            }
            $("#product_image_upload").uploadFile(settings);
            if($('#product_image').is(':visible')){
                setTimeout(function() { hideUploadBtn(); }, 500);
            }


        });
        function removeIncidentPhoto(){
        $('#product_image').hide();
        $(".ajax-upload-dragdrop").removeClass('hide');
         $("#product_image_upload").removeClass('hide');
        $('#szProductImage').val('');
        }
        function hideUploadBtn()
        {
            $(".ajax-upload-dragdrop").addClass('hide');
        }

</script>