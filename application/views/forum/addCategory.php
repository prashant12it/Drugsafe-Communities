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
                       <span class="active">Add Category</span>
                   </li>
                </ul>
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-equalizer font-red-sunglo"></i>
                            <span class="caption-subject font-red-sunglo bold uppercase">Add Category</span>
                        </div>
                        <div class="actions">
                            <div class="btn-group btn-group-devided" data-toggle="buttons">
                            </div>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <form class="form-horizontal" id="forumData" action="<?php echo __BASE_URL__?>/forum/addCategory" name="forumData" method="post">
                            <div class="form-body">
                                <div class="form-group <?php if(form_error('forumData[szCategoryName]')){?>has-error<?php }?>">
                                    <label class="col-md-3 control-label"> Category Name</label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                            <i class="fa fa-header"></i>
                                            </span>
                                            <input id="szCategoryName" class="form-control" type="text" value="<?php echo set_value('forumData[szCategoryName]'); ?>" placeholder="Category Name" onfocus="remove_formError(this.id,'true')" name="forumData[szCategoryName]">
                                        </div>
                                        <?php
                                        if(form_error('forumData[szCategoryName]')){?>
                                        <span class="help-block pull-left"><span><?php echo form_error('forumData[szCategoryName]');?></span>
                                        </span><?php }?>

                                    </div>
                                </div>

                                <div class="form-group <?php if(form_error('forumData[szCategoryDiscription]')){?>has-error<?php }?>">
                                    <label class="col-md-3 control-label"> Category Description</label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                            <i class="fa fa-file-text"></i>
                                            </span>
                                             <textarea  name="forumData[szCategoryDiscription]" id="szCategoryDiscription" class="form-control"  value=""  rows="5" placeholder="Category Description" onfocus="remove_formError(this.id,'true')" ><?php echo set_value('forumData[szCategoryDiscription]'); ?></textarea>

                                        </div>
                                          <?php
                                        if(form_error('forumData[szCategoryDiscription]')){?>
                                        <span class="help-block pull-left"><span><?php echo form_error('forumData[szCategoryDiscription]');?></span>
                                        </span><?php }?>
                                    </div>
                                </div>

                            </div>
                            
                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-4">
                                             <a href="<?= __BASE_URL__ ?>/forum/categoriesList" class="btn default uppercase"  type="button">Cancel</a>
                                            <input type="submit" class="btn green-meadow" value="SAVE" name="forumData[submit]">
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