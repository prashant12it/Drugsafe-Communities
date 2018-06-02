<div class="page-content-wrapper">
        <div class="page-content">
            <div id="page_content" class="row">
                
                <div class="col-md-12">
                     <ul class="page-breadcrumb breadcrumb">
                        <li>
                            <a href="<?php echo __BASE_URL__;?>/ordering/autocalform">Home</a>
                            <i class="fa fa-circle"></i>
                        </li>
                        <li>
                            <span class="active">Other Revenue stream  </span>
                        </li>
                    </ul>
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-equalizer font-red-sunglo"></i>
                                <span class="caption-subject font-red-sunglo bold uppercase">Other Revenue stream (Manual Entry)</span>
                            </div>
                            <div class="actions">
                                <div class="btn-group btn-group-devided" data-toggle="buttons">
                                </div>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <form class="form-horizontal" id="orderingData" action="<?php echo __BASE_URL__?>/ordering/autocalform" name="orderingData" method="post">
                                <div class="form-body">
                                    <div class="form-group <?php if(form_error('orderingData[urineNata]')){?>has-error<?php }?>">
                                        <label class="col-md-4 control-label"> Urine NATA Laboratory screening</label>
                                        <div class="col-md-5">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-user"></i>
                                                </span>
                                                <input id="urineNata" class="form-control" type="text" value="<?php echo set_value('orderingData[urineNata]'); ?>" placeholder="Urine NATA Laboratory screening" onfocus="remove_formError(this.id,'true')" name="orderingData[urineNata]">
                                            </div>
                                            <?php
                                            if(form_error('orderingData[urineNata]')){?>
                                            <span class="help-block pull-left"><span><?php echo form_error('orderingData[urineNata]');?></span>
                                            </span><?php }?>
                                           
                                        </div>
                                    </div>
                               
                                     <div class="form-group <?php if(form_error('orderingData[nataLabCnfrm]')){?>has-error<?php }?>">
                                        <label class="col-md-4 control-label"> NATA Laboratory confirmation </label>
                                        <div class="col-md-5">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-user"></i>
                                                </span>
                                                <input id="nataLabCnfrm" class="form-control" type="text" value="<?php echo set_value('orderingData[nataLabCnfrm]'); ?>" placeholder="NATA Laboratory confirmation" onfocus="remove_formError(this.id,'true')" name="orderingData[nataLabCnfrm]">
                                            </div>
                                             <?php
                                            if(form_error('orderingData[nataLabCnfrm]')){?>
                                            <span class="help-block pull-left"><span><?php echo form_error('orderingData[nataLabCnfrm]');?></span>
                                            </span><?php }?>
                                        </div>
                                    </div>
                                     <div class="form-group <?php if(form_error('orderingData[oralFluidNata]')){?>has-error<?php }?>">
                                        <label class="col-md-4 control-label"> Oral Fluid NATA Laboratory confirmation </label>
                                        <div class="col-md-5">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-user"></i>
                                                </span>
                                                <input id="oralFluidNata" class="form-control" type="text" value="<?php echo set_value('orderingData[oralFluidNata]'); ?>" placeholder="Oral Fluid NATA Laboratory confirmation" onfocus="remove_formError(this.id,'true')" name="orderingData[oralFluidNata]">
                                            </div>
                                             <?php
                                            if(form_error('orderingData[oralFluidNata]')){?>
                                            <span class="help-block pull-left"><span><?php echo form_error('orderingData[oralFluidNata]');?></span>
                                            </span><?php }?>
                                        </div>
                                    </div>
                                     <div class="form-group <?php if(form_error('orderingData[SyntheticCannabinoids]')){?>has-error<?php }?>">
                                        <label class="col-md-4 control-label"> Synthetic Cannabinoids or Designer Drugs, per sample </label>
                                        <div class="col-md-5">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-user"></i>
                                                </span>
                                                <input id="SyntheticCannabinoids" class="form-control" type="text" value="<?php echo set_value('orderingData[SyntheticCannabinoids]'); ?>" placeholder="Synthetic Cannabinoids" onfocus="remove_formError(this.id,'true')" name="orderingData[SyntheticCannabinoids]">
                                            </div>
                                             <?php
                                            if(form_error('orderingData[SyntheticCannabinoids]')){?>
                                            <span class="help-block pull-left"><span><?php echo form_error('orderingData[SyntheticCannabinoids]');?></span>
                                            </span><?php }?>
                                        </div>
                                    </div>
                                    
                                   
                                     <div class="form-group <?php if(form_error('orderingData[labScrenning]')){?>has-error<?php }?>">
                                        <label class="col-md-4 control-label">Laboratory screening</label>
                                        <div class="col-md-5">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-user"></i>
                                                </span>
                                                <input id="labScrenning" class="form-control" type="text" value="<?php echo set_value('orderingData[labScrenning]'); ?>" placeholder="Laboratory screening" onfocus="remove_formError(this.id,'true')" name="orderingData[labScrenning]">
                                            </div>
                                             <?php
                                            if(form_error('orderingData[labScrenning]')){?>
                                            <span class="help-block pull-left"><span><?php echo form_error('orderingData[labScrenning]');?></span>
                                            </span><?php }?>
                                        </div>
                                    </div>
                                     <div class="form-group <?php if(form_error('orderingData[RtwScrenning]')){?>has-error<?php }?>">
                                        <label class="col-md-4 control-label">Return to work (RTW) screening</label>
                                        <div class="col-md-5">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-user"></i>
                                                </span>
                                                <input id="RtwScrenning" class="form-control" type="text" value="<?php echo set_value('orderingData[RtwScrenning]'); ?>" placeholder="Return to work screening" onfocus="remove_formError(this.id,'true')" name="orderingData[RtwScrenning]">
                                            </div>
                                             <?php
                                            if(form_error('orderingData[RtwScrenning]')){?>
                                            <span class="help-block pull-left"><span><?php echo form_error('orderingData[RtwScrenning]');?></span>
                                            </span><?php }?>
                                        </div>
                                    </div>
                                  
                                      
                                            <div class="text align-center font-green-meadow">
                                               Drugsafe Communities mobile clinic screening</div>
                                               <hr>
                                     
                                     <div class="form-group <?php if(form_error('orderingData[mobileScreenBasePrice]')){?>has-error<?php }?>">
                                        <label class="col-md-4 control-label">Base Price (BP/hr)</label>
                                        <div class="col-md-5">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-user"></i>
                                                </span>
                                                <input id="mobileScreenBasePrice" class="form-control" type="text" value="<?php echo set_value('orderingData[mobileScreenBasePrice]'); ?>" placeholder="Base Price " onfocus="remove_formError(this.id,'true')" name="orderingData[mobileScreenBasePrice]"  onblur="calTotal()">
                                            </div>
                                             <?php
                                            if(form_error('orderingData[mobileScreenBasePrice]')){?>
                                            <span class="help-block pull-left"><span><?php echo form_error('orderingData[mobileScreenBasePrice]');?></span>
                                            </span><?php }?>
                                        </div>
                                       
                                    </div>
                                     <div class="form-group <?php if(form_error('orderingData[mobileScreenHr]')){?>has-error<?php }?>">
                                        <label class="col-md-4 control-label ">Hours </label>
                                        <div class="col-md-5">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-user"></i>
                                                </span>
                                                <input id="mobileScreenHr" class="form-control" type="text" value="<?php echo set_value('orderingData[mobileScreenHr]'); ?>" onblur="calTotal()" placeholder=" Hours " onfocus="remove_formError(this.id,'true')" name="orderingData[mobileScreenHr]">
                                            </div>
                                             <?php
                                            if(form_error('orderingData[mobileScreenHr]')){?>
                                            <span class="help-block pull-left"><span><?php echo form_error('orderingData[mobileScreenHr]');?></span>
                                            </span><?php }?>
                                        </div>
                                    </div>
                                       <div class="form-group <?php if(form_error('orderingData[mobileScreen]')){?>has-error<?php }?>">
                                        <label class="col-md-4 control-label font-green-meadow text "><b>Total</b> </label>
                                        <div class="col-md-5">
                                            <div class="input-group">
                                                <label class="col-md-4 control-label  " id="mobileScreen" value="  name="orderingData[mobileScreen]"></label>
                                                
                                            </div>
                                             <?php
                                            if(form_error('orderingData[mobileScreen]')){?>
                                            <span class="help-block pull-left"><span><?php echo form_error('orderingData[mobileScreen]');?></span>
                                            </span><?php }?>
                                        </div>
                                    </div>
                                <hr>
                                 <div class="text align-center font-green-meadow">
                                             Travel</div>
                                               <hr>
                                     <div class="form-group <?php if(form_error('orderingData[travelType]')){?>has-error<?php }?>">
                                        <label class="col-md-4 control-label">Base Price (BP/hr)</label>
                                        <div class="col-md-5">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-user"></i>
                                                </span>
                                                  <select class="form-control " name="orderingData[travelType]" id="travelType"
                                                    Placeholder="Travel" onfocus="remove_formError(this.id,'true')"  onchange="showHideTextboxForCalc()">
                                                <option value=''>Select</option>
                                                
                                                        <option  value="1" <?php echo (sanitize_post_field_value($_POST['orderingData']['travelType']) == trim("Drugsafe Communiies") ? "selected" : ""); ?>>Drugsafe Communities</option>
                                                        <option  value="2" <?php echo (sanitize_post_field_value($_POST['orderingData']['travelType']) == trim("Marketing Material Communiies") ? "selected" : ""); ?>>Marketing Material Communities</option>
                                                        
                                                       
                                                  
                                            </select>
                                            </div>
                                             <?php
                                            if(form_error('orderingData[travelType]')){?>
                                            <span class="help-block pull-left"><span><?php echo form_error('orderingData[travelType]');?></span>
                                            </span><?php }?>
                                        </div>
                                    </div>
                                      <div class="text" id="text" style="display:none;"> 
                                        <div class="form-group <?php if(form_error('orderingData[travelBasePrice]')){?>has-error<?php }?>">
                                        <label class="col-md-4 control-label ">Base Price </label>
                                        <div class="col-md-5">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-user"></i>
                                                </span>
                                                <input id="travelBasePrice" class="form-control" type="text" value="<?php echo set_value('orderingData[travelBasePrice]'); ?>" onblur="calTotalTravel()" placeholder=" Base Price " onfocus="remove_formError(this.id,'true')" name="orderingData[travelBasePrice]">
                                            </div>
                                             <?php
                                            if(form_error('orderingData[travelBasePrice]')){?>
                                            <span class="help-block pull-left"><span><?php echo form_error('orderingData[travelBasePrice]');?></span>
                                            </span><?php }?>
                                        </div>
                                    </div> 
                                    </div>               
                                  <div class="form-group <?php if(form_error('orderingData[travelHr]')){?>has-error<?php }?>">
                                        <label class="col-md-4 control-label ">Hours </label>
                                        <div class="col-md-5">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-user"></i>
                                                </span>
                                                <input id="travelHr" class="form-control" type="text" value="<?php echo set_value('orderingData[travelHr]'); ?>" onblur="calTotalTravel()" placeholder=" Hours " onfocus="remove_formError(this.id,'true')" name="orderingData[travelHr]">
                                            </div>
                                             <?php
                                            if(form_error('orderingData[travelHr]')){?>
                                            <span class="help-block pull-left"><span><?php echo form_error('orderingData[travelHr]');?></span>
                                            </span><?php }?>
                                        </div>
                                    </div>
                                       <div class="form-group <?php if(form_error('orderingData[travel]')){?>has-error<?php }?>">
                                        <label class="col-md-4 control-label font-green-meadow text "><b>Total</b> </label>
                                        <div class="col-md-5">
                                            <div class="input-group">
                                              
                                                <label class="col-md-4 control-label  " id="travel" value=""  name="orderingData[travel]"></label>
                                                
                                            </div>
                                             <?php
                                            if(form_error('orderingData[travel]')){?>
                                            <span class="help-block pull-left"><span><?php echo form_error('orderingData[travel]');?></span>
                                            </span><?php }?>
                                        </div>
                                    </div>
                                    <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-4">
                                            <a href="<?= __BASE_URL__ ?>/ordering/sitesRecord" class="btn default uppercase"
                                           type="button">Cancel</a>
                                            <input type="submit" class="btn green-meadow" value="SAVE" name="orderingData[submit]">
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