<div class="page-content-wrapper">
        <div class="page-content">
            <div id="page_content" class="row">
                
                <div class="col-md-12">
                    <ul class="page-breadcrumb breadcrumb">
                        <li>
                              <a href="<?php echo __BASE_URL__; ?>">Home</a>
                            <i class="fa fa-circle"></i>
                        </li>
                       <li>
                         <?php  
                          $operationManagerDetArr = $this->Admin_Model->getAdminDetailsByEmailOrId('',$idOperationManager);
                         ?>
                         <a onclick="viewFranchisee(<?php echo $operationManagerDetArr['id'];?>);;" href="javascript:void(0);"><?php echo $operationManagerDetArr['szName'];?></a>
                        <i class="fa fa-circle"></i>
                      </li>
                      <li>
                         <a onclick="viewClient(<?php echo $idfranchisee;?>);;" href="javascript:void(0);"><?php echo $_POST['addFranchisee']['szName'] ;?></a>
                        <i class="fa fa-circle"></i>
                      </li>
                        <li>
                            <span class="active">Edit Franchisee</span>
                        </li>
                    </ul>
                   
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-equalizer font-red-sunglo"></i>
                                <span class="caption-subject font-red-sunglo bold uppercase">Edit Franchisee</span>
                            </div>
                            <div class="actions">
                                <div class="btn-group btn-group-devided" data-toggle="buttons">
                                    <button class="btn btn-sm green-meadow" onclick="redirect_url('<?php echo base_url();?>admin/franchiseeList');">
                                        &nbsp;List Franchisee
                                    </button>
                                </div>
                            </div>
                        </div>
                      
                        <div class="portlet-body">
                            <form class="form-horizontal" id="addFranchisee" action="<?=__BASE_URL__?>/admin/editFranchisee" name="addFranchisee" method="post">
                                <div class="form-body">
                                    <div
                                            class="form-group <?php if(!empty($arErrorMessages['sztype'])){?>has-error<?php }?>">
                                        <label class="col-md-3 control-label">Franchisee Type</label>
                                        <div class="col-md-5">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-child"></i>
                                                </span>
                                                <input type="hidden" id='sztype' name='addFranchisee[sztype]' value='<?php echo $_POST['addFranchisee']['franchiseetype'];?>'>
                                                <select class="form-control" name="addFranchisee[sztype]" id="sztype" disabled="disabled">
                                                    <?php
                                                    if(!isset($_POST['addFranchisee']['sztype'])){
                                                        $_POST['addFranchisee']['sztype'] = $_POST['addFranchisee']['franchiseetype'];
                                                    }
                                                    ?>
                                                    <option value="">Select Franchisee Type</option>
                                                    <option value="0" <?php echo ($_POST['addFranchisee']['sztype'] == '0'?'selected="selected"':'');?>>Non Corporate</option>
                                                    <option value="1" <?php echo ($_POST['addFranchisee']['sztype'] == '1'?'selected="selected"':'');?>>Corporate</option>
                                                </select>
                                            </div>
                                            <?php
                                            if(!empty($arErrorMessages['sztype'])){?>
                                                <span class="help-block pull-left"><span><?php echo $arErrorMessages['sztype'];?></span>
                                                </span><?php }?>
                                        </div>
                                    </div>
                                    <div class="form-group <?php if(!empty($arErrorMessages['szName'])){?>has-error<?php }?>">
                                        <label class="col-md-3 control-label"> Name</label>
                                        <div class="col-md-5">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-user"></i>
                                                </span>
                                                <input id="szName" class="form-control" type="text" value="<?php echo $_POST['addFranchisee']['szName'] ;?>" placeholder="Name" onfocus="remove_formError(this.id,'true')" name="addFranchisee[szName]">
                                            </div>
                                            <?php if(!empty($arErrorMessages['szName'])){?>
                                            <span class="help-block pull-left">
                                                <i class="fa fa-times-circle"></i>
                                                <?php echo $arErrorMessages['szName'];?>
                                            </span>
                                        <?php }?>
                                        </div>
                                        
                                        
                                    </div>
                                     <div
                                        class="form-group <?php if (!empty($arErrorMessages['abn'])) { ?>has-error<?php } ?>">
                                        <label class="col-md-3 control-label">ABN</label>
                                        <div class="col-md-5">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-user"></i>
                                                </span>
                                                <input id="abn" class="form-control" type="text"
                                                       value="<?php echo $_POST['addFranchisee']['abn']; ?>"
                                                       placeholder="ABN"
                                                       onfocus="remove_formError(this.id,'true')"
                                                       name="addFranchisee[abn]">
                                            </div>
                                            <?php if (!empty($arErrorMessages['abn'])) { ?>
                                                <span class="help-block pull-left">
                                                <i class="fa fa-times-circle"></i>
                                                    <?php echo $arErrorMessages['abn']; ?>
                                            </span>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="form-group <?php if(!empty($arErrorMessages['szEmail'])){?>has-error<?php }?>">
                                        <label class="col-md-3 control-label"> Email</label>
                                        <div class="col-md-5">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-envelope"></i>
                                                </span>
                                                <input id="szEmail" class="form-control" type="text" value="<?php echo $_POST['addFranchisee']['szEmail'] ;?>" placeholder="Email" onfocus="remove_formError(this.id,'true')" name="addFranchisee[szEmail]">
                                            </div>
                                             <?php if(!empty($arErrorMessages['szEmail'])){?>
                                            <span class="help-block pull-left">
                                                <i class="fa fa-times-circle"></i>
                                                <?php echo $arErrorMessages['szEmail'];?>
                                            </span>
                                        <?php }?>
                                        </div>
                                       
                                    </div>
                                    <input id="szOrgEmail" class="form-control" type="hidden" value="<?php echo $_POST['addFranchisee']['szEmail'] ;?>" placeholder="Email" onfocus="remove_formError(this.id,'true')" name="addFranchisee[szOrgEmail]">
                                    <div class="form-group <?php if(!empty($arErrorMessages['szContactNumber'])){?>has-error<?php }?>">
                                        <label class="col-md-3 control-label"> Contact No</label>
                                        <div class="col-md-5">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-phone"></i>
                                                </span>
                                                <input id="szContactNumber" class="form-control" type="text" value="<?php echo $_POST['addFranchisee']['szContactNumber'] ;?>" placeholder="Contact Number" onfocus="remove_formError(this.id,'true')" name="addFranchisee[szContactNumber]">
                                            </div>
                                             <?php if(!empty($arErrorMessages['szContactNumber'])){?>
                                            <span class="help-block pull-left">
                                                <i class="fa fa-times-circle"></i>
                                                <?php echo $arErrorMessages['szContactNumber'];?>
                                            </span>
                                        <?php }?>
                                        </div>
                                        
                                          </div>
                                           <?php
                              
                                  if($_SESSION['drugsafe_user']['iRole']=='1'){
                                        ?>
                                        <div class="form-group <?php if (!empty($arErrorMessages['operationManagerId'])) { ?>has-error<?php } ?>">
                                            <label class="col-md-3 control-label">Operation Manager</label>
                                            <div class="col-md-5">
                                                <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-male"></i>
                                                </span>
                                                    <select class="form-control" name="addFranchisee[operationManagerId]"
                                                            id="franchiseeId" Placeholder="Operation Manager"
                                                            onfocus="remove_formError(this.id,'true')">
                                                         <option value=''>Select</option>
                                                       
                                                        <?php
                                                      
                                                        $operationManagerAray =$this->Admin_Model->viewOperationManagerList();
                                                        if (!empty($operationManagerAray)) {
                                                            foreach ($operationManagerAray as $operationManagerDetails) { echo $operationManagerDetails;
                                                                ?>
                                                                <option
                                                                    value="<?php echo $operationManagerDetails['id'];?>" <?php echo(sanitize_post_field_value($idOperationManager) == trim($operationManagerDetails['id']) ? "selected" : ""); ?>><?php echo trim($operationManagerDetails['szName']); ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <?php if (!empty($arErrorMessages['operationManagerId'])) { ?>
                                                    <span class="help-block pull-left">
                                                <i class="fa fa-times-circle"></i>
                                                        <?php echo $arErrorMessages['operationManagerId']; ?>
                                            </span>
                                                <?php } ?>
                                            </div>

                                        </div>
                                        <?php
                                  }
                                        ?> 
                                  
                                     <div class="form-group <?php if(!empty($arErrorMessages['szAddress'])){?>has-error<?php }?>">
                                        <label class="col-md-3 control-label">Address</label>
                                        <div class="col-md-5">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-home"></i>
                                                </span>
                                                <input id="szAddress" class="form-control" type="text" value="<?php echo $_POST['addFranchisee']['szAddress'] ;?>" placeholder="Address" onfocus="remove_formError(this.id,'true')" name="addFranchisee[szAddress]">
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
                                        <div class="input-group ">
                                                <span class="input-group-addon">
                                                <i class="fa fa-flag"></i>
                                                </span>
                                               <input class="form-control read-only" type="text" readonly name="addFranchisee[szCountry]" id="szCountry" value="<?php echo $_POST['addFranchisee']['szCountry'];?>" />
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
                                            <div class="input-group read-only">
                                                <span class="input-group-addon">
                                                <i class="fa fa-flag-checkered"></i>
                                                </span>
                                                <?php

                                                $checkEditableArr = $this->Admin_Model->getAllUserFranchiseesId($_POST['addFranchisee']['id']);
                                                $selectedstateid = $this->Admin_Model->getstatebyregionid($_POST['addFranchisee']['regionId']);
                                                $selectedregionid[0] = $this->Admin_Model->getregionbyid($_POST['addFranchisee']['regionId']);
                                                if(!empty($checkEditableArr) || $_POST['addFranchisee']['id']>0){ ?>
                                                    <div class="form-control">
                                                        <?php echo $getState['name'] ; ?>
                                                        <input type="hidden" name="addFranchisee[szState]" value="<?php echo $getState['id'] ;?>" />
                                                         <input type="hidden" name="addFranchisee[id]" value="<?php echo $_POST['addFranchisee']['id'] ;?>" />
                                                         <input type="hidden" name="addFranchisee[regionId]" value="<?php echo $_POST['addFranchisee']['regionId'] ;?>" />
                                                    </div>
                                                <?php }else{
                                                ?>
                                                <select class="form-control " name="addFranchisee[szState]" id="szState"
                                                        Placeholder="State" onfocus="remove_formError(this.id,'true')" onchange="getReginolCode(this.value);">
                                                    <option value=''>Select</option>
                                                    <?php

                                                    if(!empty($getAllStates))
                                                    {
                                                        foreach($getAllStates as $getAllStatesData)
                                                        {
                                                            $selected = ($getAllStatesData['id'] == $selectedstateid[0]['id'] ? 'selected="selected"' : '');
                                                            echo '<option value="'.$getAllStatesData['id'].'"' . $selected . ' >'.$getAllStatesData['name'].'</option>';
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                <?php } ?>
                                            </div>
                                            <?php if (!empty($arErrorMessages['szState'])) { ?>
                                                <span class="help-block pull-left">
                                                <i class="fa fa-times-circle"></i>
                                                    <?php echo $arErrorMessages['szState']; ?>
                                            </span>
                                            <?php } ?>
                                        </div>

                                    </div>
                                    <div class="reginolFiled" id="reginolFiled">
                                            <div class="form-group <?php if (!empty($arErrorMessages['szRegionName']) != '') { ?>has-error<?php } ?>">
                                                <label class="col-md-3 control-label">Region Name</label>
                                                <div class="col-md-5">
                                                    <div class="input-group read-only">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-map-marker"></i>
                                                    </span>
                                                        <?php if(!empty($checkEditableArr) || $_POST['addFranchisee']['id']>0){ ?>
                                                            <div class="form-control">
                                                                <?php echo $selectedregionid[0]['regionName'] ;?>
                                                                <input type="hidden" name="addFranchisee[szRegionName]" value="<?php echo $selectedregionid[0]['id'] ;?>" />
                                                            </div>
                                                            <input type="hidden" name="addFranchisee[editable]" value="0" />
                                                            <?php }else{?>
                                                            <input type="hidden" name="addFranchisee[editable]" value="1" />
                                                            <?php
                                                            $getReginolCode = $this->Admin_Model->getRegionByStateId($selectedstateid[0]['id']);

                                                            if(!empty($getReginolCode) && !empty($selectedregionid)){
                                                                $getReginolCode = array_merge($getReginolCode,$selectedregionid);
                                                            }elseif(empty($getReginolCode) && !empty($selectedregionid)){
                                                                $getReginolCode = $selectedregionid;
                                                            }
                                                            ?>
                                                        <select class="form-control " name="addFranchisee[szRegionName]" id="szRegionName" Placeholder="Region Name" onfocus="remove_formError(this.id,'true')">
                                                            <option value=''>Select</option>
                                                            <?php
                                                            if(!empty($getReginolCode))
                                                            {
                                                                foreach($getReginolCode as $getReginolCodeData)
                                                                {
                                                                    $selected = ($getReginolCodeData['id'] ==  $selectedregionid[0]['id'] || $getReginolCodeData['id'] == $_POST['addFranchisee']['szRegionName'] ? 'selected="selected"' : '');
                                                                    echo '<option value="'.$getReginolCodeData['id'].'"' . $selected . ' >'.$getReginolCodeData['regionName'].'</option>';
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                        <?php } ?>
                                                    </div>
                                                    <?php if (!empty($arErrorMessages['szRegionName'])) { ?>
                                                        <span class="help-block pull-left">
                                                <i class="fa fa-times-circle"></i>
                                                            <?php echo $arErrorMessages['szRegionName']; ?>
                                            </span>
                                                    <?php } ?>
                                                </div>

                                            </div>

                                    </div>
                                 <div class="form-group <?php if(!empty($arErrorMessages['szCity'])){?>has-error<?php }?>">
                                        <label class="col-md-3 control-label"> City</label>
                                        <div class="col-md-5">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-building"></i>
                                                </span>
                                                <input id="szCity" class="form-control" type="text" value="<?php echo $_POST['addFranchisee']['szCity'] ;?>" placeholder="City" onfocus="remove_formError(this.id,'true')" name="addFranchisee[szCity]">
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
                                                <input id="szZipCode" class="form-control" type="text" value="<?php echo $_POST['addFranchisee']['szZipCode'] ;?>" placeholder="ZIP/Postal Code" onfocus="remove_formError(this.id,'true')" name="addFranchisee[szZipCode]">
                                            </div>
                                            <?php if(!empty($arErrorMessages['szZipCode'])){?>
                                            <span class="help-block pull-left">
                                                <i class="fa fa-times-circle"></i>
                                                <?php echo $arErrorMessages['szZipCode'];?>
                                            </span>
                                        <?php }?>
                                        </div>
                                    </div>
                                    <input id="iRole" class="form-control" type="hidden" value="2" placeholder="Role" onfocus="remove_formError(this.id,'true')" name="addFranchisee[iRole]">
                                     <?php
                              
                                  if($_SESSION['drugsafe_user']['iRole']=='5'){
                                        ?>
                                     <input id="operationManagerId" class="form-control" type="hidden"value="<?php echo $idOperationManager; ?>" name="addFranchisee[operationManagerId]">
                                  <?php }?>
                                     <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-4">
                                            <a href="<?=__BASE_URL__?>/admin/franchiseeList" class="btn default uppercase" type="button">Cancel</a>
                                            <input type="submit" class="btn green-meadow" value="SAVE" name="addFranchisee[submit]">
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