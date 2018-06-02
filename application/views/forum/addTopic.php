<div class="page-content-wrapper">
    <div class="page-content">
        <div id="page_content" class="row">
            <div class="col-md-12">
                <ul class="page-breadcrumb breadcrumb">
                    <?php $forumDataAry = $this->Forum_Model->getForumDetailsById($idForum);?>
                    <li>
                       <a href="<?php echo __BASE_URL__;?>">Home</a>
                       <i class="fa fa-circle"></i>
                    </li>
                     <li>
                        <?php $CategoryDataAry = $this->Forum_Model->getCategoryDetailsById($forumDataAry['idCategory']);?>
                        <a href="<?php __BASE_URL__ ?>/forum/categoriesList" ><?php echo $CategoryDataAry['szName']; ?></a>
                        <i class="fa fa-circle"></i>
                    </li>
                     <li>
                        <a href="<?php __BASE_URL__ ?>/forum/forumList" ><?php echo $forumDataAry[szForumTitle]; ?></a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                       <span class="active">Add Topic</span>
                    </li>
                </ul>
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-equalizer font-red-sunglo"></i>
                            <span class="caption-subject font-red-sunglo bold uppercase">Add Topic</span>
                        </div>
                        <div class="actions">
                            <div class="btn-group btn-group-devided" data-toggle="buttons">
                            </div>
                        </div>
                    </div>
                        <div class="portlet-body">
                            <form class="form-horizontal" id="forumData" action="<?php echo __BASE_URL__?>/forum/addTopic" name="forumData" method="post">
                                <div class="form-body">
                                    <div class="form-group <?php if(form_error('forumData[szTopicTitle]')){?>has-error<?php }?>">
                                        <label class="col-md-3 control-label"> Topic Title</label>
                                        <div class="col-md-5">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-header"></i>
                                                </span>
                                                <input id="szTopicTitle" class="form-control" type="text" value="<?php echo set_value('forumData[szTopicTitle]'); ?>" placeholder="Topic Title" onfocus="remove_formError(this.id,'true')" name="forumData[szTopicTitle]">
                                            </div>
                                            <?php
                                            if(form_error('forumData[szTopicTitle]')){?>
                                            <span class="help-block pull-left"><span><?php echo form_error('forumData[szTopicTitle]');?></span>
                                            </span><?php }?>
                                        </div>
                                    </div>
                               
                                    <div class="form-group <?php if(form_error('forumData[szTopicDiscription]')){?>has-error<?php }?>">
                                        <label class="col-md-3 control-label"> Topic Description</label>
                                        <div class="col-md-5">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-file-text"></i>
                                                </span>
                                                 <textarea  name="forumData[szTopicDiscription]" id="szTopicDiscription" class="form-control"  value=""  rows="5" placeholder="Topic Description" onfocus="remove_formError(this.id,'true')" ><?php echo set_value('forumData[szTopicDiscription]'); ?></textarea>
                                              
                                            </div>
                                              <?php
                                            if(form_error('forumData[szTopicDiscription]')){?>
                                            <span class="help-block pull-left"><span><?php echo form_error('forumData[szTopicDiscription]');?></span>
                                            </span><?php }?>
                                        </div>
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
                                    
                            </form>
                        </div>
                </div>
            </div> 
        </div>
    </div>
</div>
</div>