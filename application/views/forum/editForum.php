<div class="page-content-wrapper">
        <div class="page-content">
            <div id="page_content" class="row">
                
                <div class="col-md-12">
                     <ul class="page-breadcrumb breadcrumb">
                        <li>
                            <a href="<?php echo __BASE_URL__;?>">Home</a>
                            <i class="fa fa-circle"></i>
                        </li>
                        <li>
                        <?php $CategoryDataAry = $this->Forum_Model->getCategoryDetailsById(set_value('forumData[idCategory]'));?>
                        <a href="<?php __BASE_URL__ ?>/forum/categoriesList" ><?php echo $CategoryDataAry['szName'] ; ?></a>
                        <i class="fa fa-circle"></i>
                    </li>
                     <li>
                        <a href="<?php __BASE_URL__ ?>/forum/forumList" ><?php echo set_value('forumData[szForumTitle]'); ?></a>
                        <i class="fa fa-circle"></i>
                    </li>
                        <li>
                            <span class="active">Edit Forum </span>
                        </li>
                    </ul>
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-equalizer font-red-sunglo"></i>
                                <span class="caption-subject font-red-sunglo bold uppercase">Edit Forum</span>
                            </div>
                            <div class="actions">
                                <div class="btn-group btn-group-devided" data-toggle="buttons">
                                </div>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <form class="form-horizontal" id="forumData" action="<?php echo __BASE_URL__?>/forum/editForum" name="forumData" method="post">
                                <div class="form-body">
                                   
                                <div class="form-group <?php if(form_error('forumData[szForumTitle]')){?>has-error<?php }?>">
                                         <label class="col-md-3 control-label">Forum Title</label>
                                        <div class="col-md-5">
                                           <div class="input-group">
                                                 <span class="input-group-addon">
                                                 <i class="fa fa-header"></i>
                                                </span>
                                                <input id="szForumTitle" class="form-control" type="text" value="<?php echo set_value('forumData[szForumTitle]') ;?>" placeholder="Forum Title" onfocus="remove_formError(this.id,'true')" name="forumData[szForumTitle]">
                                                </div>
                                            <?php
                                              if(form_error('forumData[szForumTitle]')){?>
                                            <span class="help-block pull-left"><span><?php echo form_error('forumData[szForumTitle]');?></span>
                                            </span><?php }?>
                                           
                                        </div>
                                    </div>
                                     <div class="form-group <?php if(form_error('forumData[idCategory]')){?>has-error<?php }?>">
                                            <label class="col-md-3 control-label">Forum Category</label>
                                            <div class="col-md-5">
                                                <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-list"></i>
                                                </span>
                                                    <select class="form-control" name="forumData[idCategory]"
                                                            id="idCategory" Placeholder="Forum Category"
                                                            onfocus="remove_formError(this.id,'true')">
                                                        <option value=''>Select</option>
                                                        <?php
                                                         $categoriesListAray =$this->Forum_Model->viewCategoriesList();
                                                        if (!empty($categoriesListAray)) {
                                                            foreach ($categoriesListAray as $categoriesListDetails) {
                                                                ?>
                                                                <option
                                                                    value="<?php echo trim($categoriesListDetails['id']); ?>" <?php echo(set_value('forumData[idCategory]') == trim($categoriesListDetails['id']) ? "selected" : ""); ?>><?php echo trim($categoriesListDetails['szName']); ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <?php
                                            if(form_error('forumData[idCategory]')){?>
                                            <span class="help-block pull-left"><span><?php echo form_error('forumData[idCategory]');?></span>
                                            </span><?php }?>
                                            </div>

                                        </div>  
                                    <div class="form-group <?php if(form_error('forumData[szForumDiscription]')){?>has-error<?php }?>">
                                        <label class="col-md-3 control-label"> Short Description</label>
                                        <div class="col-md-5">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-file-text"></i>
                                                </span>
                                                 <textarea  name="forumData[szForumDiscription]" id="szForumDiscription" class="form-control"  value=""  rows="5" placeholder="Forum Description" onfocus="remove_formError(this.id,'true')" ><?php echo set_value('forumData[szForumDiscription]'); ?></textarea>
                                              
                                            </div>
                                              <?php
                                            if(form_error('forumData[szForumDiscription]')){?>
                                            <span class="help-block pull-left"><span><?php echo form_error('forumData[szForumDiscription]');?></span>
                                            </span><?php }?>
                                        </div>
                                    </div>
                                    <div class="form-group <?php if(form_error('forumData[szForumLongDiscription]')){?>has-error<?php }?>">
                                                      <label class="col-md-3 control-label">Long Description</label>
                                                      <div class="col-md-5">
                                                        <div class="input-group">
                                                           
                                                 <textarea  name="forumData[szForumLongDiscription]" id="szForumLongDiscription" class="form-control"  value=""  rows="5" placeholder="Long Description" onfocus="remove_formError(this.id,'true')" ><?php echo set_value('forumData[szForumLongDiscription]'); ?></textarea>
                                              
                                            </div> 
                                                            <?php
                                            if(form_error('forumData[szForumLongDiscription]')){?>
                                            <span class="help-block pull-left"><span><?php echo form_error('forumData[szForumLongDiscription]');?></span>
                                            </span><?php }?>
                                                       
                                                        </div>
                                                      
                                                    </div>
                                    
                                       
                                    <div class="form-group <?php if(form_error('forumData[szforumImage]')){?>has-error<?php }?>">
                                        <label class="col-md-3 control-label">Forum Image</label>
                                        <div class="col-md-5">
                                            <div class="input-group">
                                                <div class="profile-userbuttons">
                                                    <div id="product_image">
                                                        <?php
							$NewImageName=set_value('forumData[szforumImage]');
                                                        if($NewImageName!= '')
                                                        {
							    $randomNum=rand().time();
                                                            ?>
							    <div id="photoDiv_<?php echo $randomNum; ?>">
                                                                <img class="file_preview_image" src="<?php echo __BASE_USER_PRODUCT_IMAGES_URL__; ?>/<?php echo $NewImageName; ?>" width="60" height="60"/>
                                                                <a href="javascript:void(0);" id="remove_btn_<?php echo $randomNum; ?>" class="btn red-intense btn-sm" onclick="removeIncidentPhoto('');">Remove</a>
                                                            </div>
							<?php
                                                        }
                                                        ?>
                                                    </div>
                                                    <div class="<?php if($NewImageName) { ?> hide <?php }?>"  id="product_image_upload" onfocus="remove_formError(this.id,'true')">Upload</div>
                                                </div>
                                                <input type="hidden" name="forumData[szforumImage]" id="szforumImage" value="<?php echo set_value('forumData[szforumImage]'); ?>" onfocus="remove_formError(this.id,'true')" /> 
                                            <p id="upload_error_status" class="hide" style="font-color:#e73d4a">Error occur while uploading image. Please inform to Anova Golf.</p>
                                        </div>
                                             <?php
                                            if(form_error('forumData[szforumImage]')){?>
                                            <span class="help-block pull-left"><span><?php echo form_error('forumData[szforumImage]');?></span>
                                            </span><?php }?>
                                            
                                        </div>
                                        
                                    </div>
                                    
                                    <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-4">
                                            <a href="<?= __BASE_URL__ ?>/forum/forumList" class="btn default uppercase"
                                           type="button">Cancel</a>
                                            <input type="submit" class="btn green-meadow" value="SAVE" name="forumData[submit]">
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
                        $("#status").html("<font color='green'>Upload is success</font>");
                        data = JSON.parse(data);
                        $('#product_image').show();
                        $("#product_image").html(data.img_div);
                        $("#szforumImage").val(data.name);
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
        $('#szforumImage').val('');
        }
        function hideUploadBtn()
        {
            $(".ajax-upload-dragdrop").addClass('hide');
        }
</script>
<script>
CKEDITOR.replace( 'szForumLongDiscription' );
</script>