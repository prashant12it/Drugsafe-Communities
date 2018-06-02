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
                         <?php
                          $prospectDetailsAry = $this->Prospect_Model->getProspectDetailsByProspectsId($idProspect);
                         if($flag==1){?>
                        <a href="<?php echo __BASE_URL__;?>/prospect/prospectRecord"><?php echo  $prospectDetailsAry['szBusinessName'];?></a>
                         <?php } else {?>
                         <a href="<?php echo __BASE_URL__;?>/prospect/view_prospect_details"><?php echo  $prospectDetailsAry['szBusinessName'];?></a>
                         <?php }?>
                        <i class="fa fa-circle"></i>
                       </li>
                    <li>
                       <span class="active">Add Meeting Note</span>
                    </li>
                </ul>
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-equalizer font-red-sunglo"></i>
                            <span class="caption-subject font-red-sunglo bold uppercase">Add Meeting Note</span>
                        </div>
                        <div class="actions">
                            <div class="btn-group btn-group-devided" data-toggle="buttons">
                            </div>
                        </div>
                    </div>
                        <div class="portlet-body">
                            <form class="form-horizontal" id="meetingNotesData" action="<?php echo __BASE_URL__?>/prospect/add_meeting_notes" name="meetingNotesData" method="post">
                                <div class="form-body">
                                    <div class="form-group <?php if(form_error('meetingNotesData[szDiscription]')){?>has-error<?php }?>">
                                        <label class="col-md-3 control-label">Meeting Note</label>
                                        <div class="col-md-5">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-file-text"></i>
                                                </span>
                                                 <textarea  name="meetingNotesData[szDiscription]" id="szDiscription" class="form-control"  value=""  rows="5" placeholder="Meeting Note" onfocus="remove_formError(this.id,'true')" ><?php echo set_value('meetingNotesData[szTopicDiscription]'); ?></textarea>
                                              
                                            </div>
                                              <?php
                                            if(form_error('meetingNotesData[szDiscription]')){?>
                                            <span class="help-block pull-left"><span><?php echo form_error('meetingNotesData[szDiscription]');?></span>
                                            </span><?php }?>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-4">
                                              <?php if($flag==1){?>
                                 <a href="<?= __BASE_URL__ ?>/prospect/prospectRecord" class="btn default uppercase"
                                           type="button">Cancel</a>
                                   <?php } else {?>
                                         <a href="<?= __BASE_URL__ ?>/prospect/view_prospect_details" class="btn default uppercase"
                                           type="button">Cancel</a>
                              
                                 <?php }?>
                                            <input type="submit" class="btn green-meadow" value="SAVE" name="meetingNotesData[submit]">
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