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
                        <a onclick="viewFranchisee(<?php echo $idOperationManager?>);" href="javascript:void(0);"><?php echo $_POST['editOperationManager']['szName'] ;?></a>
                        <i class="fa fa-circle"></i>
                       </li>
                        <li>
                            <span class="active">Edit Operation Manager</span>
                        </li>
                    </ul>
                    
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-equalizer font-red-sunglo"></i>
                                <span class="caption-subject font-red-sunglo bold uppercase">Edit Operation Manager</span>
                            </div>
                            <div class="actions">
                                <div class="btn-group btn-group-devided" data-toggle="buttons">
                                    <button class="btn btn-sm green-meadow" onclick="redirect_url('<?php echo base_url();?>admin/operationManagerList');">
                                        &nbsp; Operation Manager List
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <form class="form-horizontal" id="editOperationManager" action="<?=__BASE_URL__?>/admin/edit_Operation_Manager" name="editOperationManager" method="post">
                                <div class="form-body">
                                    <div class="form-group <?php if(!empty($arErrorMessages['szName'])){?>has-error<?php }?>">
                                        <label class="col-md-3 control-label"> Name</label>
                                        <div class="col-md-5">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-user"></i>
                                                </span>
                                                <input id="szName" class="form-control" type="text" value="<?php echo $_POST['editOperationManager']['szName'] ;?>" placeholder="Name" onfocus="remove_formError(this.id,'true')" name="editOperationManager[szName]">
                                            </div>
                                            <?php if(!empty($arErrorMessages['szName'])){?>
                                            <span class="help-block pull-left">
                                                <i class="fa fa-times-circle"></i>
                                                <?php echo $arErrorMessages['szName'];?>
                                            </span>
                                        <?php }?>
                                        </div>
                                        
                                        
                                    </div>
                                    
                                    <div class="form-group <?php if(!empty($arErrorMessages['szEmail'])){?>has-error<?php }?>">
                                        <label class="col-md-3 control-label"> Email</label>
                                        <div class="col-md-5">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-envelope"></i>
                                                </span>
                                                <input id="szEmail" class="form-control" type="text" value="<?php echo $_POST['editOperationManager']['szEmail'] ;?>" placeholder="Email" onfocus="remove_formError(this.id,'true')" name="editOperationManager[szEmail]">
                                            </div>
                                             <?php if(!empty($arErrorMessages['szEmail'])){?>
                                            <span class="help-block pull-left">
                                                <i class="fa fa-times-circle"></i>
                                                <?php echo $arErrorMessages['szEmail'];?>
                                            </span>
                                        <?php }?>
                                        </div>
                                       
                                    </div>
                                    <input id="szOrgEmail" class="form-control" type="hidden" value="<?php echo $_POST['editOperationManager']['szEmail'] ;?>" placeholder="Email" onfocus="remove_formError(this.id,'true')" name="editOperationManager[szOrgEmail]">
                                    <div class="form-group <?php if(!empty($arErrorMessages['szContactNumber'])){?>has-error<?php }?>">
                                        <label class="col-md-3 control-label"> Contact No</label>
                                        <div class="col-md-5">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-phone"></i>
                                                </span>
                                                <input id="szContactNumber" class="form-control" type="text" value="<?php echo $_POST['editOperationManager']['szContactNumber'] ;?>" placeholder="Contact Number" onfocus="remove_formError(this.id,'true')" name="editOperationManager[szContactNumber]">
                                            </div>
                                             <?php if(!empty($arErrorMessages['szContactNumber'])){?>
                                            <span class="help-block pull-left">
                                                <i class="fa fa-times-circle"></i>
                                                <?php echo $arErrorMessages['szContactNumber'];?>
                                            </span>
                                        <?php }?>
                                        </div>
                                    </div>
                                     <div class="form-group <?php if(!empty($arErrorMessages['szAddress'])){?>has-error<?php }?>">
                                        <label class="col-md-3 control-label">Address</label>
                                        <div class="col-md-5">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-home"></i>
                                                </span>
                                                <input id="szAddress" class="form-control" type="text" value="<?php echo $_POST['editOperationManager']['szAddress'] ;?>" placeholder="Address" onfocus="remove_formError(this.id,'true')" name="editOperationManager[szAddress]">
                                            </div>
                                             <?php if(!empty($arErrorMessages['szAddress'])){?>
                                            <span class="help-block pull-left">
                                                <i class="fa fa-times-circle"></i>
                                                <?php echo $arErrorMessages['szAddress'];?>
                                            </span>
                                        <?php }?>
                                        </div>
                                    </div>
                                    <div
                                    class="form-group <?php if (!empty($arErrorMessages['szCountry']) != '') { ?>has-error<?php } ?>">
                                    <label class="col-md-3 control-label">Country</label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-flag"></i>
                                                </span>
                                           <input id="szCountry" class="form-control read-only" type="text"
                                                   value="Australia"
                                                   placeholder="Country" onfocus="remove_formError(this.id,'true')"
                                                   name="editOperationManager[szCountry]" readonly> 
                                        </div>
                                        <?php if (!empty($arErrorMessages['szCountry'])) { ?>
                                            <span class="help-block pull-left">
                                                <i class="fa fa-times-circle"></i>
                                                <?php echo $arErrorMessages['szCountry']; ?>
                                            </span>
                                        <?php } ?>
                                    </div>

                                </div>
                                <div
                                    class="form-group <?php if (!empty($arErrorMessages['szState']) != '') { ?>has-error<?php } ?>">
                                    <label class="col-md-3 control-label">State</label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-flag-checkered"></i>
                                                </span>
                                            <select class="form-control " name="editOperationManager[szState]" id="szState"
                                                    Placeholder="State" onfocus="remove_formError(this.id,'true')">
                                                <option value=''>Select</option>
                                                 <?php
                                                if(!empty($getAllStates))
                                                {
                                                    foreach($getAllStates as $getAllStatesData)
                                                    {
                                                        $selected = ($getAllStatesData['id'] == $_POST['editOperationManager']['szState'] ? 'selected="selected"' : '');
                                                        echo '<option value="'.$getAllStatesData['id'].'"' . $selected . ' >'.$getAllStatesData['name'].'</option>';
                                                    } 
                                                } 
                                            ?>
                                            </select>
                                        </div>
                                        <?php if (!empty($arErrorMessages['szState'])) { ?>
                                            <span class="help-block pull-left">
                                                <i class="fa fa-times-circle"></i>
                                                <?php echo $arErrorMessages['szState']; ?>
                                            </span>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="form-group <?php if(!empty($arErrorMessages['szCity'])){?>has-error<?php }?>">
                                        <label class="col-md-3 control-label"> City</label>
                                        <div class="col-md-5">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-building"></i>
                                                </span>
                                                <input id="szCity" class="form-control" type="text" value="<?php echo $_POST['editOperationManager']['szCity'] ;?>" placeholder="City" onfocus="remove_formError(this.id,'true')" name="editOperationManager[szCity]">
                                            </div>
                                            <?php if(!empty($arErrorMessages['szCity'])){?>
                                            <span class="help-block pull-left">
                                                <i class="fa fa-times-circle"></i>
                                                <?php echo $arErrorMessages['szCity'];?>
                                            </span>
                                        <?php }?>
                                        </div>
                                         
                                    </div>
                                    
                                     <div class="form-group <?php if(!empty($arErrorMessages['szZipCode'])){?>has-error<?php }?>">
                                        <label class="col-md-3 control-label">ZIP/Postal Code</label>
                                        <div class="col-md-5">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-area-chart"></i>
                                                </span>
                                                <input id="szZipCode" class="form-control" type="text" value="<?php echo $_POST['editOperationManager']['szZipCode'] ;?>" placeholder="ZIP/Postal Code" onfocus="remove_formError(this.id,'true')" name="editOperationManager[szZipCode]">
                                            </div>
                                            <?php if(!empty($arErrorMessages['szZipCode'])){?>
                                            <span class="help-block pull-left">
                                                <i class="fa fa-times-circle"></i>
                                                <?php echo $arErrorMessages['szZipCode'];?>
                                            </span>
                                        <?php }?>
                                        </div>
                                        
                                    </div>
                                    
                                    
                                   <input id="iRole" class="form-control" type="hidden" value="5" placeholder="Role" onfocus="remove_formError(this.id,'true')" name="editOperationManager[iRole]">
                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-4">
                                            <?php if($flag==1){?>
                                            <a href="<?=__BASE_URL__?>/admin/operationManagerList" class="btn default uppercase" type="button">Cancel</a>
                                            <?php } else{?>
                                            <a href="<?=__BASE_URL__?>/franchisee/franchiseeRecord" class="btn default uppercase" type="button">Cancel</a>
                                            <?php } ?>
                                            <input type="submit" class="btn green-meadow" value="SAVE" name="editOperationManager[submit]">
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