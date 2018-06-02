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
                            
                      <?php  if($flag==1){?>
                        <a href="<?php echo __BASE_URL__;?>/prospect/prospectRecord"><?php echo  $_POST['editProspect']['szBusinessName'];?></a>
                         <?php } else {?>
                         <a href="<?php echo __BASE_URL__;?>/prospect/view_prospect_details"><?php echo $_POST['editProspect']['szBusinessName'];?></a>
                         <?php }?>
                       <i class="fa fa-circle"></i>
                        </li>
                             
                        <li>
                            <span class="active">Edit Prospect</span>
                        </li>
                    </ul>
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-equalizer font-red-sunglo"></i>
                                <span class="caption-subject font-red-sunglo bold uppercase">Edit Prospect</span>
                            </div>
                            <div class="actions">
                                <div class="btn-group btn-group-devided" data-toggle="buttons">
                                    <button class="btn btn-sm green-meadow" onclick="redirect_url('<?php echo base_url();?>prospect/prospectRecord');">
                                        &nbsp; Prospect List
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="portlet-body">
                           
                            <form class="form-horizontal" id="editProspect" action="<?=__BASE_URL__?>/prospect/edit_prospect" name="editProspect" method="post">
                               <div class="form-body">
                               <div
                                        class="form-group <?php if (!empty($arErrorMessages['szBusinessName'])) { ?>has-error<?php } ?>">
                                        <label class="col-md-4 control-label"> Business Name</label>
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-user"></i>
                                                </span>
                                                <input id="szBusinessName" class="form-control" type="text"
                                                       value="<?php echo $_POST['editProspect']['szBusinessName']; ?>"
                                                       placeholder="Business Name"
                                                       onfocus="remove_formError(this.id,'true')"
                                                       name="editProspect[szBusinessName]">
                                            </div>
                                            <?php if (!empty($arErrorMessages['szBusinessName'])) { ?>
                                                <span class="help-block pull-left">
                                                <i class="fa fa-times-circle"></i>
                                                    <?php echo $arErrorMessages['szBusinessName']; ?>
                                            </span>
                                            <?php } ?>
                                        </div>


                                    </div>
                                <div class="form-group <?php if (!empty($arErrorMessages['abn'])) { ?>has-error<?php } ?>">
                                        <label class="col-md-4 control-label">ABN</label>
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-user"></i>
                                                </span>
                                                <input id="abn" class="form-control" type="text"
                                                       value="<?php echo $_POST['editProspect']['abn']; ?>"
                                                       placeholder="ABN"
                                                       onfocus="remove_formError(this.id,'true')"
                                                       name="editProspect[abn]">
                                            </div>
                                            <?php if (!empty($arErrorMessages['abn'])) { ?>
                                                <span class="help-block pull-left">
                                                <i class="fa fa-times-circle"></i>
                                                    <?php echo $arErrorMessages['abn']; ?>
                                            </span>
                                            <?php } ?>
                                        </div>


                                    </div>   
                                <div  class="form-group <?php if (!empty($arErrorMessages['szName']) != '') { ?>has-error<?php } ?>">
                                    <label class="col-md-4 control-label"> Contact Name</label>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-user"></i>
                                                </span>
                                            <input id="szName" class="form-control" type="text"
                                                   value="<?php echo $_POST['editProspect']['szName']; ?>"
                                                   placeholder="Contact Name" onfocus="remove_formError(this.id,'true')"
                                                   name="editProspect[szName]"/>

                                        </div>
                                        <?php if (!empty($arErrorMessages['szName'])) { ?>
                                            <span class="help-block pull-left">
                                                <i class="fa fa-times-circle"></i>
                                                <?php echo $arErrorMessages['szName']; ?>
                                            </span>
                                        <?php } ?>
                                    </div>
                                </div>
                                 <div class="form-group <?php if (!empty($arErrorMessages['szEmail'])) { ?>has-error<?php } ?>">
                                        <label class="col-md-4 control-label"> Primary Email</label>
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-envelope"></i>
                                                </span>
                                                <input id="szEmail" class="form-control" type="text"
                                                       value="<?php echo $_POST['editProspect']['szEmail']; ?>"
                                                       placeholder="Primary Email"
                                                       onfocus="remove_formError(this.id,'true')"
                                                       name="editProspect[szEmail]">
                                            </div>
                                            <?php if (!empty($arErrorMessages['szEmail'])) { ?>
                                                <span class="help-block pull-left">
                                                <i class="fa fa-times-circle"></i>
                                                    <?php echo $arErrorMessages['szEmail']; ?>
                                            </span>
                                            <?php } ?>
                                        </div>

                                    </div>
                               
                                <div class="form-group <?php if (!empty($arErrorMessages['szContactNumber']) != '') { ?>has-error<?php } ?>">
                                    <label class="col-md-4 control-label"> Primary Phone</label>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-phone"></i>
                                                </span>
                                            <input id="szContactNumber" class="form-control" type="text"
                                                   value="<?php echo $_POST['editProspect']['szContactNumber']; ?>"
                                                   placeholder="Primary Phone Number"
                                                   onfocus="remove_formError(this.id,'true')"
                                                   name="editProspect[szContactNumber]">
                                        </div>
                                        <?php if (!empty($arErrorMessages['szContactNumber'])) { ?>
                                            <span class="help-block pull-left">
                                                <i class="fa fa-times-circle"></i>
                                                <?php echo $arErrorMessages['szContactNumber']; ?>
                                            </span>
                                        <?php } ?>
                                    </div>

                                </div>
                                     <div
                                        class="form-group <?php if (!empty($arErrorMessages['szNoOfSites'])) { ?>has-error<?php } ?>">
                                        <label class="col-md-4 control-label">No Of Sites</label>
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-users"></i>
                                                </span>
                                                <input id="szNoOfSites" class="form-control" type="text"
                                                       value="<?php echo $_POST['editProspect']['szNoOfSites']; ?>"
                                                       placeholder="No Of Sites"
                                                       onfocus="remove_formError(this.id,'true')"
                                                       name="editProspect[szNoOfSites]">
                                            </div>
                                            <?php if (!empty($arErrorMessages['szNoOfSites'])) { ?>
                                                <span class="help-block pull-left">
                                                <i class="fa fa-times-circle"></i>
                                                    <?php echo $arErrorMessages['szNoOfSites']; ?>
                                            </span>
                                            <?php } ?>
                                        </div>
                                    </div>
                              <div class="form-group <?php if (!empty($arErrorMessages['industry']) != '') { ?>has-error<?php } ?>">
                                    <label class="col-md-4 control-label">Industry</label>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-industry"></i>
                                                </span>
                                            <select class="form-control " name="editProspect[industry]" id="industry"
                                                    Placeholder="Industry" onfocus="remove_formError(this.id,'true')">
                                                <option value=''>Select</option>
                                                  <?php
                                                      
                                                       $industryListArr =$this->Admin_Model->viewAllIndustryList();
                                                        if (!empty($industryListArr)) {
                                                            foreach ($industryListArr as $industryList) { echo $industryList;
                                                                ?>
                                                                <option
                                                                    value="<?php echo $industryList['id'];?>" <?php echo(sanitize_post_field_value($_POST['editProspect']['industry']) == trim($industryList['id']) ? "selected" : ""); ?>><?php echo trim($industryList['szName']); ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                            </select>
                                        </div>
                                        <?php if (!empty($arErrorMessages['industry'])) { ?>
                                            <span class="help-block pull-left">
                                                <i class="fa fa-times-circle"></i>
                                                <?php echo $arErrorMessages['industry']; ?>
                                            </span>
                                        <?php } ?>
                                    </div>

                                </div>
                                      <div class="form-group <?php if (!empty($arErrorMessages['industry']) != '') { ?>has-error<?php } ?>">
                                    <label class="col-md-4 control-label">Lead Generation Channel</label>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-industry"></i>
                                                </span>
                                            <select class="form-control " name="editProspect[L_G_Channel]" id="L_G_Channel"
                                                    Placeholder="L_G_Channel" onfocus="remove_formError(this.id,'true')">
                                               
                                                 <option value=''>Select</option>
                                                 <option value="LinkedIn" <?php echo(sanitize_post_field_value($_POST['editProspect']['L_G_Channel']) == trim('LinkedIn') ? "selected" : ""); ?>>LinkedIn</option>
                                                  <option value="Business Chamber" <?php echo(sanitize_post_field_value($_POST['editProspect']['L_G_Channel']) == trim('Business Chamber') ? "selected" : ""); ?>>Business Chamber</option>
                                                   <option value="Business List" <?php echo(sanitize_post_field_value($_POST['editProspect']['L_G_Channel']) == trim('Business List') ? "selected" : ""); ?>>Business List</option>
                                                    <option value="Industry Associations" <?php echo(sanitize_post_field_value($_POST['editProspect']['L_G_Channel']) == trim('Industry Associations') ? "selected" : ""); ?>>Industry Associations</option>
                                                     <option value="Other" <?php echo(sanitize_post_field_value($_POST['editProspect']['L_G_Channel']) == trim('Other') ? "selected" : ""); ?>>Other</option>
                                                               
                                            </select>
                                        </div>
                                        <?php if (!empty($arErrorMessages['L_G_Channel'])) { ?>
                                            <span class="help-block pull-left">
                                                <i class="fa fa-times-circle"></i>
                                                <?php echo $arErrorMessages['L_G_Channel']; ?>
                                            </span>
                                        <?php } ?>
                                    </div>
                                    </div>
                                       <?php if($_SESSION['drugsafe_user']['iRole'] == '1'){ 
                               ?>
                                             <div
                                            class="form-group <?php if (!empty($arErrorMessages['iFranchiseeId'])) { ?>has-error<?php } ?>">
                                            <label class="col-md-4 control-label">Franchisee</label>
                                            <div class="col-md-6">
                                                <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-male"></i>
                                                </span>
                                                    <select class="form-control" name="editProspect[iFranchiseeId]"
                                                            id="iFranchiseeId" Placeholder="Franchisee"
                                                            onfocus="remove_formError(this.id,'true')">
                                                        <option value=''>Select</option>
                                                        <?php
                                                     $franchiseeAray =$this->Admin_Model->viewFranchiseeList(false,false);
                                             
                                                        if (!empty($franchiseeAray)) {
                                                            foreach ($franchiseeAray as $franchiseeDetails) {
                                                                ?>
                                                                <option
                                                                    value="<?php echo trim($franchiseeDetails['id']); ?>" <?php echo(sanitize_post_field_value($_POST['editProspect']['iFranchiseeId']) == trim($franchiseeDetails['id']) ? "selected" : ""); ?>><?php echo trim($franchiseeDetails['szName']); ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <?php if (!empty($arErrorMessages['iFranchiseeId'])) { ?>
                                                    <span class="help-block pull-left">
                                                <i class="fa fa-times-circle"></i>
                                                        <?php echo $arErrorMessages['iFranchiseeId']; ?>
                                            </span>
                                                <?php } ?>
                                            </div>

                                        </div>
                                    <?php   
                                   }
                                   else{?>
                                       <input id="iFranchiseeId" class="form-control" type="hidden"
                                           value="<?php echo $idfranchisee; ?>"
                                           name="clientData[iFranchiseeId]">
                                       <?php
                                   }?>
                                  <div class="subCaption">
                                        <i class="icon-equalizer font-green-meadow"></i>
                                        <span
                                            class="caption-subject font-green-meadow bold uppercase">Contact Details</span>
                                    </div>

                                    <div
                                        class="form-group <?php if (!empty($arErrorMessages['szContactEmail'])) { ?>has-error<?php } ?>">
                                        <label class="col-md-4 control-label"> Contact Email</label>
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-envelope"></i>
                                                </span>
                                                <input id="szContactEmail" class="form-control" type="text"
                                                       value="<?php echo $_POST['editProspect']['szContactEmail']; ?>"
                                                       placeholder="Contact Email"
                                                       onfocus="remove_formError(this.id,'true')"
                                                       name="editProspect[szContactEmail]">
                                            </div>
                                            <?php if (!empty($arErrorMessages['szContactEmail'])) { ?>
                                                <span class="help-block pull-left">
                                                <i class="fa fa-times-circle"></i>
                                                    <?php echo $arErrorMessages['szContactEmail']; ?>
                                            </span>
                                            <?php } ?>
                                        </div>

                                    </div>
                                    <div
                                        class="form-group <?php if (!empty($arErrorMessages['szContactPhone'])) { ?>has-error<?php } ?>">
                                        <label class="col-md-4 control-label">Contact Phone</label>
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-phone"></i>
                                                </span>
                                                <input id="szContactPhone" class="form-control" type="text"
                                                       value="<?php echo $_POST['editProspect']['szContactPhone']; ?>"
                                                       placeholder="Contact Phone"
                                                       onfocus="remove_formError(this.id,'true')"
                                                       name="editProspect[szContactPhone]">
                                            </div>
                                            <?php if (!empty($arErrorMessages['szContactPhone'])) { ?>
                                                <span class="help-block pull-left">
                                                <i class="fa fa-times-circle"></i>
                                                    <?php echo $arErrorMessages['szContactPhone']; ?>
                                            </span>
                                            <?php } ?>
                                        </div>

                                    </div>
                                    <div
                                        class="form-group <?php if (!empty($arErrorMessages['szContactMobile'])) { ?>has-error<?php } ?>">
                                        <label class="col-md-4 control-label">Contact Mobile</label>
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-mobile-phone"></i>
                                                </span>
                                                <input id="szContactMobile" class="form-control" type="text"
                                                       value="<?php echo $_POST['editProspect']['szContactMobile']; ?>"
                                                       placeholder="Contact Mobile"
                                                       onfocus="remove_formError(this.id,'true')"
                                                       name="editProspect[szContactMobile]">
                                            </div>
                                            <?php if (!empty($arErrorMessages['szContactMobile'])) { ?>
                                                <span class="help-block pull-left">
                                                <i class="fa fa-times-circle"></i>
                                                    <?php echo $arErrorMessages['szContactMobile']; ?>
                                            </span>
                                            <?php } ?>
                                        </div>

                                    </div>
                              
                                <div
                                    class="form-group <?php if (!empty($arErrorMessages['szAddress'])) { ?>has-error<?php } ?>">
                                    <label class="col-md-4 control-label">Address</label>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-home"></i>
                                                </span>
                                            <input id="szAddress" class="form-control" type="text"
                                                   value="<?php echo $_POST['editProspect']['szAddress']; ?>"
                                                   placeholder="Address" onfocus="remove_formError(this.id,'true')"
                                                   name="editProspect[szAddress]">
                                        </div>
                                        <?php if (!empty($arErrorMessages['szAddress'])) { ?>
                                            <span class="help-block pull-left">
                                                <i class="fa fa-times-circle"></i>
                                                <?php echo $arErrorMessages['szAddress']; ?>
                                            </span>
                                        <?php } ?>
                                    </div>
                                </div>
                                 
                                   <div class="form-group <?php if (!empty($arErrorMessages['szCountry']) != '') { ?>has-error<?php } ?>">
                                    <label class="col-md-4 control-label">Country</label>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-flag"></i>
                                                </span>
                                         <input id="szCountry" class="form-control read-only" type="text"
                                                   value="Australia"
                                                   placeholder="Country" onfocus="remove_formError(this.id,'true')"
                                                   name="editProspect[szCountry]" readonly> 
                                        </div>
                                        <?php if (!empty($arErrorMessages['szCountry'])) { ?>
                                            <span class="help-block pull-left">
                                                <i class="fa fa-times-circle"></i>
                                                <?php echo $arErrorMessages['szCountry']; ?>
                                            </span>
                                        <?php } ?>
                                    </div>

                                </div>

                                   <div class="form-group">
                                       <label class="col-md-4 control-label">State</label>
                                       <div class="col-md-6">
                                           <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-map-marker"></i>
                                            </span>
                                               <div class="form-control">
                                                   <?php echo $getState['name'] ;?>
                                               </div>

                                           </div>

                                       </div>

                                   </div>
                                <div
                                    class="form-group <?php if (!empty($arErrorMessages['szCity'])) { ?>has-error<?php } ?>">
                                    <label class="col-md-4 control-label"> City</label>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-building"></i>
                                                </span>
                                            <input id="szCity" class="form-control" type="text"
                                                   value="<?php echo $_POST['editProspect']['szCity']; ?>"
                                                   placeholder="City" onfocus="remove_formError(this.id,'true')"
                                                   name="editProspect[szCity]">
                                        </div>
                                        <?php if (!empty($arErrorMessages['szCity'])) { ?>
                                            <span class="help-block pull-left">
                                                <i class="fa fa-times-circle"></i>
                                                <?php echo $arErrorMessages['szCity']; ?>
                                            </span>
                                        <?php } ?>
                                    </div>

                                </div>
                                <div
                                    class="form-group <?php if (!empty($arErrorMessages['szZipCode'])) { ?>has-error<?php } ?>">
                                    <label class="col-md-4 control-label">ZIP/Postal Code</label>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-area-chart"></i>
                                                </span>
                                            <input id="szZipCode" class="form-control" type="text"
                                                   value="<?php echo $_POST['editProspect']['szZipCode']; ?>"
                                                   placeholder="ZIP/Postal Code"
                                                   onfocus="remove_formError(this.id,'true')"
                                                   name="editProspect[szZipCode]">
                                        </div>
                                        <?php if (!empty($arErrorMessages['szZipCode'])) { ?>
                                            <span class="help-block pull-left">
                                                <i class="fa fa-times-circle"></i>
                                                <?php echo $arErrorMessages['szZipCode']; ?>
                                            </span>
                                        <?php } ?>
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
                                     
                                        <input type="submit" class="btn green-meadow" value="SAVE"
                                               name="editProspect[submit]">
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