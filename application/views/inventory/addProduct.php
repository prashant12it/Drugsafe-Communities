<div class="page-content-wrapper">
        <div class="page-content">
            <div id="page_content" class="row">
                
                <div class="col-md-12">
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-equalizer font-red-sunglo"></i>
                                <span class="caption-subject font-red-sunglo bold uppercase">Add Product</span>
                            </div>
                            <div class="actions">
                                <div class="btn-group btn-group-devided" data-toggle="buttons">
                                </div>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <form class="form-horizontal" id="clientData" action="<?php echo __BASE_URL__?>/inventory/addProduct" name="productDate" method="post">
                                <div class="form-body">
                                    <div class="form-group <?php if(form_error('productData[szProductCode]')){?>has-error<?php }?>">
                                        <label class="col-md-3 control-label"> Product Code</label>
                                        <div class="col-md-5">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-user"></i>
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
                                                <i class="fa fa-user"></i>
                                                </span>
                                                <input id="szProductCost" class="form-control" type="text" value="<?php echo set_value('productData[szProductCost]'); ?>" placeholder="Product Cost" onfocus="remove_formError(this.id,'true')" name="productData[szProductCost]">
                                            </div>
                                             <?php
                                            if(form_error('productData[szProductCost]')){?>
                                            <span class="help-block pull-left"><span><?php echo form_error('productData[szProductCost]');?></span>
                                            </span><?php }?>
                                        </div>
                                    </div>
                                    <div class="form-group <?php if(form_error('productData[szProductCategory]')){?>has-error<?php }?>">
                                        <label class="col-md-3 control-label">Product Category</label>
                                        <div class="col-md-5">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-user"></i>
                                                </span>
                                                <select class="form-control" name="productData[szProductCategory]" id="szProductCategory" Placeholder="Category" onfocus="remove_formError(this.id,'true')">
                                                    <option value=''>Product Category</option>
                                                    <option value='1' <?php echo (set_value('productData[szProductCategory]') == '1' ? "selected" : "");?>>Drug Test Kits</option>
                                                    <option value='2' <?php echo (set_value('productData[szProductCategory]') == '2' ? "selected" : "");?>>Marketing Material</option>
                                                </select>
                                            </div>
                                             <?php
                                            if(form_error('productData[szProductCategory]')){?>
                                            <span class="help-block pull-left"><span><?php echo form_error('productData[szProductCategory]');?></span>
                                            </span><?php }?>
                                        </div>
                                    </div>
                                         <div class="form-group <?php if(form_error('productData[szProductDiscription]')){?>has-error<?php }?>">
                                        <label class="col-md-3 control-label"> Product Description</label>
                                        <div class="col-md-5">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-user"></i>
                                                </span>
                                                 <textarea  name="productData[szProductDiscription]" id="szProductDiscription" class="form-control"  value=""  rows="5" placeholder="Product Description" onfocus="remove_formError(this.id,'true')" ><?php echo set_value('productData[szProductDiscription]'); ?></textarea>
                                              
                                            </div>
                                              <?php
                                            if(form_error('productData[szProductDiscription]')){?>
                                            <span class="help-block pull-left"><span><?php echo form_error('productData[szProductDiscription]');?></span>
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
                                    </div>
                                    <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-4">
                                            <input type="submit" class="btn green-meadow" value="SAVE" name="productData[submit]">
                                        </div>
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
                        data = JSON.parse(data);
                        $('#product_image').show();
                        $("#product_image").html(data.img_div);
                        $("#szProductImage").val(data.name);
                    },
                    afterUploadAll:function()
                    {
                        $(".ajax-file-upload-statusbar").addClass('hide');
                        $("#product_image_upload").addClass('hide');
                    },
                    onError: function(files,status,errMsg)
                    {		
                        $("#upload_error_status").removeClass('hide');
                    }
            }
            $("#product_image_upload").uploadFile(settings);
        });
        function removeIncidentPhoto(){
        $('#product_image').hide();
        $(".ajax-upload-dragdrop").removeClass('hide');
         $("#product_image_upload").removeClass('hide');
        $('#szProductImage').val('');
        }
</script>