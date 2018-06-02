<div class="page-content-wrapper">
    <div class="page-content">
        <div id="page_content" class="row">
            <div class="col-md-12">
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <a href="<?php echo __BASE_URL__; ?>">Home</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <?php
                    if ($franchiseeArr['id']) {
                    if (($_SESSION['drugsafe_user']['iRole'] == '5')|| ($_SESSION['drugsafe_user']['iRole'] == '1')) {    
                        ?>
                        <li>
                            <a onclick="viewClient(<?php echo $franchiseeArr['id']; ?>);"
                               href="javascript:void(0);"><?php echo $franchiseeArr['szName']; ?></a>
                            <i class="fa fa-circle"></i>
                        </li>
                        <?php

                    } }
                    ?>

                    <?php

                    if ($szParentId > 0) {
                        ?>
                        <li>
                            <a onclick="viewClientDetails(<?php echo $clientDetailsAray['id']; ?>);"
                               href="javascript:void(0);"><?php echo $clientDetailsAray['szName']; ?></a>
                            <i class="fa fa-circle"></i>
                        </li>
                        <li>
                            <span class="active">Add Site</span>
                        </li>
                    <?php } else {
                        ?>
                        <li>
                            <span class="active">Add Client</span>
                        </li>
                    <?php } ?>
                </ul>
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-equalizer font-red-sunglo"></i>
                            <?php if ($szParentId > 0) { ?>
                                <span class="caption-subject font-red-sunglo bold uppercase">Add Site</span>
                            <?php } else { ?>
                                <span class="caption-subject font-red-sunglo bold uppercase">Add Client</span>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <form class="form-horizontal" id="clientData"
                              action="<?php echo __BASE_URL__ ?>/franchisee/addClient" name="clientData" method="post">

                            <div class="form-body">
                                <?php if (empty($szParentId)) { ?>
                                    <div
                                            class="form-group <?php if (!empty($arErrorMessages['szBusinessName'])) { ?>has-error<?php } ?>">
                                        <label class="col-md-4 control-label"> Business Name</label>
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-user"></i>
                                                </span>
                                                <input id="szBusinessName" class="form-control" type="text"
                                                       value="<?php echo $_POST['clientData']['szBusinessName']; ?>"
                                                       placeholder="Business Name"
                                                       onfocus="remove_formError(this.id,'true')"
                                                       name="clientData[szBusinessName]">
                                            </div>
                                            <?php if (!empty($arErrorMessages['szBusinessName'])) { ?>
                                                <span class="help-block pull-left">
                                                <i class="fa fa-times-circle"></i>
                                                    <?php echo $arErrorMessages['szBusinessName']; ?>
                                            </span>
                                            <?php } ?>
                                        </div>


                                    </div>
                                    <div
                                            class="form-group <?php if (!empty($arErrorMessages['abn'])) { ?>has-error<?php } ?>">
                                        <label class="col-md-4 control-label">ABN</label>
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-user"></i>
                                                </span>
                                                <input id="abn" class="form-control" type="text"
                                                       value="<?php echo $_POST['clientData']['abn']; ?>"
                                                       placeholder="ABN"
                                                       onfocus="remove_formError(this.id,'true')"
                                                       name="clientData[abn]">
                                            </div>
                                            <?php if (!empty($arErrorMessages['abn'])) { ?>
                                                <span class="help-block pull-left">
                                                <i class="fa fa-times-circle"></i>
                                                    <?php echo $arErrorMessages['abn']; ?>
                                            </span>
                                            <?php } ?>
                                        </div>


                                    </div>
                                    <div
                                            class="form-group <?php if (!empty($arErrorMessages['szName'])) { ?>has-error<?php } ?>">
                                        <label class="col-md-4 control-label"> Contact Name</label>
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-user"></i>
                                                </span>
                                                <input id="szName" class="form-control" type="text"
                                                       value="<?php echo $_POST['clientData']['szName']; ?>"
                                                       placeholder="Contact Name"
                                                       onfocus="remove_formError(this.id,'true')"
                                                       name="clientData[szName]">
                                            </div>
                                            <?php if (!empty($arErrorMessages['szName'])) { ?>
                                                <span class="help-block pull-left">
                                                <i class="fa fa-times-circle"></i>
                                                    <?php echo $arErrorMessages['szName']; ?>
                                            </span>
                                            <?php } ?>
                                        </div>


                                    </div>

                                    <div
                                            class="form-group <?php if (!empty($arErrorMessages['szEmail'])) { ?>has-error<?php } ?>">
                                        <label class="col-md-4 control-label"> Primary Email</label>
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-envelope"></i>
                                                </span>
                                                <input id="szEmail" class="form-control" type="text"
                                                       value="<?php echo $_POST['clientData']['szEmail']; ?>"
                                                       placeholder="Primary Email"
                                                       onfocus="remove_formError(this.id,'true')"
                                                       name="clientData[szEmail]">
                                            </div>
                                            <?php if (!empty($arErrorMessages['szEmail'])) { ?>
                                                <span class="help-block pull-left">
                                                <i class="fa fa-times-circle"></i>
                                                    <?php echo $arErrorMessages['szEmail']; ?>
                                            </span>
                                            <?php } ?>
                                        </div>

                                    </div>
                                    <div
                                            class="form-group <?php if (!empty($arErrorMessages['szContactNumber'])) { ?>has-error<?php } ?>">
                                        <label class="col-md-4 control-label">Primary Phone</label>
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-phone"></i>
                                                </span>
                                                <input id="szContactNumber" class="form-control" type="text"
                                                       value="<?php echo $_POST['clientData']['szContactNumber']; ?>"
                                                       placeholder="Primary Phone"
                                                       onfocus="remove_formError(this.id,'true')"
                                                       name="clientData[szContactNumber]">
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
                                                       value="<?php echo $_POST['clientData']['szNoOfSites']; ?>"
                                                       placeholder="No Of Sites"
                                                       onfocus="remove_formError(this.id,'true')"
                                                       name="clientData[szNoOfSites]">
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
                                                <select class="form-control " name="clientData[industry]" id="industry"
                                                        Placeholder="Industry"
                                                        onfocus="remove_formError(this.id,'true')">

                                                    <option value=''>Select</option>
                                                    <?php
                                                    $industryListArr = $this->Admin_Model->viewAllIndustryList();
                                                    if (!empty($industryListArr)) {
                                                        foreach ($industryListArr as $industryListDetails) {
                                                            ?>
                                                            <option value="<?php echo trim($industryListDetails['id']); ?>" <?php echo(sanitize_post_field_value($_POST['clientData']['industry']) == trim($industryListDetails['id']) ? "selected" : ""); ?>><?php echo trim($industryListDetails['szName']); ?></option>
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

                                    <div class="form-group <?php if (!empty($arErrorMessages['discount']) != '') { ?>has-error<?php } ?>">
                                        <label class="col-md-4 control-label">Discount</label>
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-deviantart"></i>
                                                </span>
                                                <select class="form-control " name="clientData[discount]" id="discount"
                                                        onfocus="remove_formError(this.id,'true')">

                                                    <option value=''>Select</option>
                                                    <?php
                                                    //$industryListArr =$this->Admin_Model->viewAllIndustryList();
                                                    if (!empty($discountarr)) {
                                                        foreach ($discountarr as $discountListDetails) {
                                                            ?>
                                                            <option value="<?php echo trim($discountListDetails['id']); ?>" <?php echo(sanitize_post_field_value($_POST['clientData']['discount']) == trim($discountListDetails['id']) ? "selected" : ""); ?>><?php echo trim($discountListDetails['percentage']); ?>
                                                                %
                                                            </option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <?php if (!empty($arErrorMessages['discount'])) { ?>
                                                <span class="help-block pull-left">
                                                <i class="fa fa-times-circle"></i>
                                                    <?php echo $arErrorMessages['discount']; ?>
                                            </span>
                                            <?php } ?>
                                        </div>

                                    </div>
                                <?php } else { ?>
                                    <div
                                            class="form-group <?php if (!empty($arErrorMessages['szName'])) { ?>has-error<?php } ?>">
                                        <label class="col-md-4 control-label">Company Name</label>
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-user"></i>
                                                </span>
                                                <input id="szName" class="form-control" type="text"
                                                       value="<?php echo $_POST['clientData']['szName']; ?>"
                                                       placeholder="Company Name"
                                                       onfocus="remove_formError(this.id,'true')"
                                                       name="clientData[szName]">
                                            </div>
                                            <?php if (!empty($arErrorMessages['szName'])) { ?>
                                                <span class="help-block pull-left">
                                                <i class="fa fa-times-circle"></i>
                                                    <?php echo $arErrorMessages['szName']; ?>
                                            </span>
                                            <?php } ?>
                                        </div>


                                    </div>
                                    <div
                                            class="form-group <?php if (!empty($arErrorMessages['per_form_complete'])) { ?>has-error<?php } ?>">
                                        <label class="col-md-4 control-label">Name of Person Completing Form</label>
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-user"></i>
                                                </span>
                                                <input id="per_form_complete" class="form-control" type="text"
                                                       value="<?php echo $_POST['clientData']['per_form_complete']; ?>"
                                                       placeholder="Name of Person Completing Form"
                                                       onfocus="remove_formError(this.id,'true')"
                                                       name="clientData[per_form_complete]">
                                            </div>
                                            <?php if (!empty($arErrorMessages['per_form_complete'])) { ?>
                                                <span class="help-block pull-left">
                                                <i class="fa fa-times-circle"></i>
                                                    <?php echo $arErrorMessages['per_form_complete']; ?>
                                            </span>
                                            <?php } ?>
                                        </div>


                                    </div>

                                    <div
                                            class="form-group <?php if (!empty($arErrorMessages['szEmail'])) { ?>has-error<?php } ?>">
                                        <label class="col-md-4 control-label"> Company Email</label>
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-envelope"></i>
                                                </span>
                                                <input id="szEmail" class="form-control" type="text"
                                                       value="<?php echo $_POST['clientData']['szEmail']; ?>"
                                                       placeholder="Company Email"
                                                       onfocus="remove_formError(this.id,'true')"
                                                       name="clientData[szEmail]">
                                            </div>
                                            <?php if (!empty($arErrorMessages['szEmail'])) { ?>
                                                <span class="help-block pull-left">
                                                <i class="fa fa-times-circle"></i>
                                                    <?php echo $arErrorMessages['szEmail']; ?>
                                            </span>
                                            <?php } ?>
                                        </div>

                                    </div>
                                    <div
                                            class="form-group <?php if (!empty($arErrorMessages['szContactNumber'])) { ?>has-error<?php } ?>">
                                        <label class="col-md-4 control-label">Company Phone Number </label>
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-phone"></i>
                                                </span>
                                                <input id="szContactNumber" class="form-control" type="text"
                                                       value="<?php echo $_POST['clientData']['szContactNumber']; ?>"
                                                       placeholder="Company Phone Number"
                                                       onfocus="remove_formError(this.id,'true')"
                                                       name="clientData[szContactNumber]">
                                            </div>
                                            <?php if (!empty($arErrorMessages['szContactNumber'])) { ?>
                                                <span class="help-block pull-left">
                                                <i class="fa fa-times-circle"></i>
                                                    <?php echo $arErrorMessages['szContactNumber']; ?>
                                            </span>
                                            <?php } ?>
                                        </div>

                                    </div>

                                <?php } ?>
                                <?php

                                if ($_SESSION['drugsafe_user']['iRole'] == '1') {
                                //                                    if (!$idfranchisee)
                                if ($flag == 2) {
                                ?>

                                <div class="form-group <?php if (!empty($arErrorMessages['operationManagerId'])) { ?>has-error<?php } ?>">
                                    <label class="col-md-4 control-label">Operation Manager</label>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-male"></i>
                                                </span>
                                            <select class="form-control " name="clientData[operationManagerId]"
                                                    id="operationManagerId" Placeholder="Operation Manager"
                                                    onchange="getFranchiseeListing(this.value);"
                                                    onfocus="remove_formError(this.id,'true')">
                                                <option value=''>Select</option>
                                                <?php
                                                $operationManagerListArr = $this->Admin_Model->viewOperationManagerList();
                                                if (!empty($operationManagerListArr)) {
                                                    foreach ($operationManagerListArr as $operationManagerListDetails) {
                                                        ?>
                                                        <option value="<?php echo trim($operationManagerListDetails['id']); ?>" <?php echo(sanitize_post_field_value($_POST['clientData']['operationManagerId']) == trim($operationManagerListDetails['id']) ? "selected" : ""); ?>><?php echo trim($operationManagerListDetails['szName']); ?></option>
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
                            </div>
                            <div class="form-group <?php if (!empty($arErrorMessages['franchiseeId'])) { ?>has-error<?php } ?>">
                                <label class="col-md-4 control-label">Franchisee</label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-male"></i>
                                                </span>
                                        <div id="franchisee_container">
                                            <?php if (empty($validate['operationManagerId'])) { ?>
                                                <input type="text" class="form-control" id="franchiseeId"
                                                       name="clientData[franchiseeId]" placeholder="Franchisee"
                                                       value="<?= sanitize_post_field_value($_POST['clientData']['franchiseeId']) ?>"
                                                       onfocus="remove_formError(this.id,'true')">
                                            <?php } else {
                                                $franchiseeDetArr1 = $this->Admin_Model->getAdminDetailsByEmailOrId('', $validate['franchiseeId']);
                                                ?>

                                                <select class="form-control " name="clientData[franchiseeId]"
                                                        id="franchiseeId" Placeholder="Franchisee"
                                                        onfocus="remove_formError(this.id,'true')">
                                                    <option value=''>Select</option>

                                                    <option value="<?php echo trim($franchiseeDetArr1['id']); ?>" <?php echo(sanitize_post_field_value($_POST['clientData']['franchiseeId']) == trim($franchiseeDetArr1['id']) ? "selected" : ""); ?>><?php echo trim($franchiseeDetArr1['szName']); ?></option>

                                                </select>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <?php if (!empty($arErrorMessages['franchiseeId'])) { ?>
                                        <span class="help-block pull-left">
                                                <i class="fa fa-times-circle"></i>
                                            <?php echo $arErrorMessages['franchiseeId']; ?>
                                            </span>
                                    <?php } ?>


                                </div>
                            </div>

                            <?php

                            } else {
                                ?>
                                <input id="franchiseeId" class="form-control" type="hidden"
                                       value="<?php echo $idfranchisee; ?>" name="clientData[franchiseeId]">
                                <?php $franchiseeAry = $this->Franchisee_Model->getFranchiseeDetailsByOperationManagerId(trim($idfranchisee));

                                ?>
                                <input id="OperationManagerId" class="form-control" type="hidden"
                                       value="<?php echo $franchiseeAry['operationManagerId']; ?>"
                                       name="clientData[operationManagerId]">
                                <?php
                            }
                            ?>

                            <?php

                            }
                            elseif ($_SESSION['drugsafe_user']['iRole'] == '5') {
                                if (!$idfranchisee) { ?>
                                    <div
                                            class="form-group <?php if (!empty($arErrorMessages['franchiseeId'])) { ?>has-error<?php } ?>">
                                        <label class="col-md-4 control-label">Franchisee</label>
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-male"></i>
                                                </span>
                                                <select class="form-control" name="clientData[franchiseeId]"
                                                        id="franchiseeId" Placeholder="Franchisee"
                                                        onfocus="remove_formError(this.id,'true')">
                                                    <option value=''>Select</option>
                                                    <?php
                                                    $operationManagerId = $_SESSION['drugsafe_user']['id'];
                                                    $franchiseeAray = $this->Admin_Model->viewFranchiseeList(false, $operationManagerId);

                                                    if (!empty($franchiseeAray)) {
                                                        foreach ($franchiseeAray as $franchiseeDetails) {
                                                            ?>
                                                            <option
                                                                    value="<?php echo trim($franchiseeDetails['id']); ?>" <?php echo(sanitize_post_field_value($_POST['clientData']['franchiseeId']) == trim($franchiseeDetails['id']) ? "selected" : ""); ?>><?php echo trim($franchiseeDetails['szName']); ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <?php if (!empty($arErrorMessages['franchiseeId'])) { ?>
                                                <span class="help-block pull-left">
                                                <i class="fa fa-times-circle"></i>
                                                    <?php echo $arErrorMessages['franchiseeId']; ?>
                                            </span>
                                            <?php } ?>
                                        </div>

                                    </div>
                                    <?php
                                } else {
                                    ?>
                                    <input id="franchiseeid" class="form-control" type="hidden"
                                           value="<?php echo $idfranchisee; ?>"
                                           name="clientData[franchiseeId]">
                                    <?php
                                } ?>
                                <input id="OperationManagerId" class="form-control" type="hidden"
                                       value="<?php echo $_SESSION['drugsafe_user']['id'] ?>"
                                       name="clientData[operationManagerId]">
                                <?php
                            } else {
                                ?>

                                <input id="franchiseeid" class="form-control" type="hidden"
                                       value="<?php echo $_SESSION['drugsafe_user']['id']; ?>"
                                       name="clientData[franchiseeId]">
                                <?php $idfranchisee = $_SESSION['drugsafe_user']['id'];
                                $franchiseeAry = $this->Franchisee_Model->getFranchiseeDetailsByOperationManagerId(trim($idfranchisee)); ?>
                                <input id="OperationManagerId" class="form-control" type="hidden"
                                       value="<?php echo $franchiseeAry['operationManagerId'] ?>"
                                       name="clientData[operationManagerId]">
                                <?php
                            }
                            ?>

                            <?php if ($szParentId > 0) { ?>
                                <input id="szParentId" class="form-control" type="hidden"
                                       value="<?php echo $szParentId; ?>" name="clientData[szParentId]">
                            <?php } else { ?>
                                <input id="szParentId" class="form-control" type="hidden" value="0"
                                       name="clientData[szParentId]">
                            <?php } ?>

                            <?php if (empty($szParentId)) { ?>
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
                                                   value="<?php echo $_POST['clientData']['szContactEmail']; ?>"
                                                   placeholder="Contact Email"
                                                   onfocus="remove_formError(this.id,'true')"
                                                   name="clientData[szContactEmail]">
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
                                                   value="<?php echo $_POST['clientData']['szContactPhone']; ?>"
                                                   placeholder="Contact Phone"
                                                   onfocus="remove_formError(this.id,'true')"
                                                   name="clientData[szContactPhone]">
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
                                                   value="<?php echo $_POST['clientData']['szContactMobile']; ?>"
                                                   placeholder="Contact Mobile"
                                                   onfocus="remove_formError(this.id,'true')"
                                                   name="clientData[szContactMobile]">
                                        </div>
                                        <?php if (!empty($arErrorMessages['szContactMobile'])) { ?>
                                            <span class="help-block pull-left">
                                                <i class="fa fa-times-circle"></i>
                                                <?php echo $arErrorMessages['szContactMobile']; ?>
                                            </span>
                                        <?php } ?>
                                    </div>

                                </div>
                            <?php } ?>
                            <div
                                    class="form-group <?php if (!empty($arErrorMessages['szAddress'])) { ?>has-error<?php } ?>">
                                <label class="col-md-4 control-label">Address</label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-home"></i>
                                                </span>
                                        <input id="szAddress" class="form-control" type="text"
                                               value="<?php echo $_POST['clientData']['szAddress']; ?>"
                                               placeholder="Address" onfocus="remove_formError(this.id,'true')"
                                               name="clientData[szAddress]">
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
                                               name="clientData[szCountry]" readonly>
                                    </div>
                                    <?php if (!empty($arErrorMessages['szCountry'])) { ?>
                                        <span class="help-block pull-left">
                                                <i class="fa fa-times-circle"></i>
                                            <?php echo $arErrorMessages['szCountry']; ?>
                                            </span>
                                    <?php } ?>
                                </div>

                            </div>
                            <!--Corporate site client region-->
                            <input type="hidden" name="clientData[frtype]" value="<?php echo $corpFranchisee; ?>"/>
                            <?php if ($corpFranchisee == 1) { ?>
                                <div
                                        class="form-group <?php if (!empty($arErrorMessages['szState'])) { ?>has-error<?php } ?>">
                                    <label class="col-md-4 control-label">State</label>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-flag-checkered"></i>
                                                </span>
                                            <select class="form-control " name="clientData[szState]" id="szState"
                                                    Placeholder="State" onfocus="remove_formError(this.id,'true')"
                                                    onchange="getAllReginolCode(this.value);">
                                                <option value=''>Select</option>
                                                <?php
                                                if (!empty($getAllStates)) {
                                                    foreach ($getAllStates as $getAllStatesData) {
                                                        $selected = ($getAllStatesData['id'] == $_POST['clientData']['szState'] ? 'selected="selected"' : '');
                                                        echo '<option value="' . $getAllStatesData['id'] . '"' . $selected . ' >' . $getAllStatesData['name'] . '</option>';
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <?php
                                        if (!empty($arErrorMessages['szState'])) {
                                            ?>
                                            <span class="help-block pull-left">
                                            <i class="fa fa-times-circle"></i><?php echo $arErrorMessages['szState']; ?>
                                            </span><?php } ?>
                                    </div>

                                </div>
                                <div class="reginolFiled" id="reginolFiled">
                                    <?php
                                    if ($_POST['clientData']['szState'] != '') {
                                        ?>

                                        <div class="form-group <?php if (!empty($arErrorMessages['szRegionName'])) { ?>has-error<?php } ?>">
                                            <label class="col-md-4 control-label">Region Name</label>
                                            <div class="col-md-6">
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-map-marker"></i>
                                                    </span>
                                                    <select class="form-control " name="clientData[szRegionName]"
                                                            id="szRegionName" Placeholder="Region Name"
                                                            onfocus="remove_formError(this.id,'true')">
                                                        <option value=''>Select</option>
                                                        <?php
                                                        if (!empty($getReginolCode)) {
                                                            foreach ($getReginolCode as $getReginolCodeData) {
                                                                $selected = ($getReginolCodeData['id'] == $_POST['clientData']['szRegionName'] ? 'selected="selected"' : '');
                                                                echo '<option value="' . $getReginolCodeData['id'] . '"' . $selected . ' >' . $getReginolCodeData['regionName'] . '</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <?php
                                                if (!empty($arErrorMessages['szRegionName'])) {
                                                    ?>
                                                    <span class="help-block pull-left">
                                                <i class="fa fa-times-circle"></i><?php echo $arErrorMessages['szRegionName']; ?></span>
                                                <?php } ?>
                                            </div>

                                        </div>
                                        <script type="text/javascript">
                                            setTimeout(function () {
                                                getAllReginolCode('<?php echo $_POST['clientData']['szState'];?>', '<?php echo $arErrorMessages['szRegionName'];?>', '<?php echo $_POST['clientData']['szRegionName'];?>');
                                            }, 500);

                                        </script>
                                        <?php
                                    }

                                    ?>
                                </div>

                                <!--End Corporate site client region-->
                            <?php } else { ?>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">State</label>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-map-marker"></i>
                                            </span>
                                            <div class="form-control">
                                                <?php echo $getState['name']; ?>
                                            </div>

                                        </div>

                                    </div>

                                </div>
                            <?php } ?>
                            <div
                                    class="form-group <?php if (!empty($arErrorMessages['szCity'])) { ?>has-error<?php } ?>">
                                <label class="col-md-4 control-label"> City</label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-building"></i>
                                                </span>
                                        <input id="szCity" class="form-control" type="text"
                                               value="<?php echo $_POST['clientData']['szCity']; ?>"
                                               placeholder="City" onfocus="remove_formError(this.id,'true')"
                                               name="clientData[szCity]">
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
                                               value="<?php echo $_POST['clientData']['szZipCode']; ?>"
                                               placeholder="ZIP/Postal Code"
                                               onfocus="remove_formError(this.id,'true')"
                                               name="clientData[szZipCode]">
                                    </div>
                                    <?php if (!empty($arErrorMessages['szZipCode'])) { ?>
                                        <span class="help-block pull-left">
                                                <i class="fa fa-times-circle"></i>
                                            <?php echo $arErrorMessages['szZipCode']; ?>
                                            </span>
                                    <?php } ?>
                                </div>

                            </div>

                            <?php if (!empty($szParentId)) { ?>
                                <!-- BEGIN CONTACT DETAILS PORTLET-->
                                <div class="portlet box green-meadow">
                                    <div class="portlet-title" data-toggle="collapse" data-target="#contact-details">
                                        <div class="caption">
                                            <i class="icon-equalizer "></i>
                                            Contact Details
                                        </div>
                                        <div class="tools">
                                            <a href="javascript:;" class="collapse-sec collapsed" data-toggle="collapse"
                                               data-target="#contact-details">
                                            </a>


                                        </div>
                                    </div>

                                    <div class="portlet-body collapse" id="contact-details">
                                        <table class="table table-hover">
                                            <hr>
                                            <div class="font-green-meadow text">Who will be responsible for
                                                Scheduling? If you would like us to manage the scheduling, write
                                                "DrugSafe".
                                            </div>
                                            <hr>
                                            <div
                                                    class="form-group <?php if (!empty($arErrorMessages['sp_name'])) { ?>has-error<?php } ?>">
                                                <label class="col-md-4 control-label"> Contact Name</label>
                                                <div class="col-md-6">
                                                    <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-user"></i>
                                                </span>
                                                        <input id="sp_name" class="form-control" type="text"
                                                               value="<?php echo $_POST['clientData']['sp_name']; ?>"
                                                               placeholder="Contact Name"
                                                               onfocus="remove_formError(this.id,'true')"
                                                               name="clientData[sp_name]">
                                                    </div>
                                                    <?php if (!empty($arErrorMessages['sp_name'])) { ?>
                                                        <span class="help-block pull-left">
                                                <i class="fa fa-times-circle"></i>
                                                            <?php echo $arErrorMessages['sp_name']; ?>
                                            </span>
                                                    <?php } ?>
                                                </div>

                                            </div>
                                            <div
                                                    class="form-group <?php if (!empty($arErrorMessages['sp_mobile'])) { ?>has-error<?php } ?>">
                                                <label class="col-md-4 control-label">Contact Phone Number</label>
                                                <div class="col-md-6">
                                                    <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-phone"></i>
                                                </span>
                                                        <input id="sp_mobile" class="form-control" type="text"
                                                               value="<?php echo $_POST['clientData']['sp_mobile']; ?>"
                                                               placeholder="Contact Phone Number"
                                                               onfocus="remove_formError(this.id,'true')"
                                                               name="clientData[sp_mobile]">
                                                    </div>
                                                    <?php if (!empty($arErrorMessages['sp_mobile'])) { ?>
                                                        <span class="help-block pull-left">
                                                <i class="fa fa-times-circle"></i>
                                                            <?php echo $arErrorMessages['sp_mobile']; ?>
                                            </span>
                                                    <?php } ?>
                                                </div>

                                            </div>
                                            <div
                                                    class="form-group <?php if (!empty($arErrorMessages['sp_email'])) { ?>has-error<?php } ?>">
                                                <label class="col-md-4 control-label">Contact Email</label>
                                                <div class="col-md-6">
                                                    <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-envelope"></i>
                                                </span>
                                                        <input id="sp_email" class="form-control" type="text"
                                                               value="<?php echo $_POST['clientData']['sp_email']; ?>"
                                                               placeholder="Contact Email"
                                                               onfocus="remove_formError(this.id,'true')"
                                                               name="clientData[sp_email]">
                                                    </div>
                                                    <?php if (!empty($arErrorMessages['sp_email'])) { ?>
                                                        <span class="help-block pull-left">
                                                <i class="fa fa-times-circle"></i>
                                                            <?php echo $arErrorMessages['sp_email']; ?>
                                            </span>
                                                    <?php } ?>
                                                </div>

                                            </div>
                                            <hr>
                                            <div class="font-green-meadow text">Would anyone else be involved in
                                                Scheduling?
                                            </div>
                                            <hr>
                                            <div
                                                    class="form-group <?php if (!empty($arErrorMessages['iis_name'])) { ?>has-error<?php } ?>">
                                                <label class="col-md-4 control-label"> Contact Name</label>
                                                <div class="col-md-6">
                                                    <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-user"></i>
                                                </span>
                                                        <input id="iis_name" class="form-control" type="text"
                                                               value="<?php echo $_POST['clientData']['iis_name']; ?>"
                                                               placeholder="Contact Name"
                                                               onfocus="remove_formError(this.id,'true')"
                                                               name="clientData[iis_name]">
                                                    </div>
                                                    <?php if (!empty($arErrorMessages['iis_name'])) { ?>
                                                        <span class="help-block pull-left">
                                                <i class="fa fa-times-circle"></i>
                                                            <?php echo $arErrorMessages['iis_name']; ?>
                                            </span>
                                                    <?php } ?>
                                                </div>

                                            </div>
                                            <div
                                                    class="form-group <?php if (!empty($arErrorMessages['iis_mobile'])) { ?>has-error<?php } ?>">
                                                <label class="col-md-4 control-label">Contact Phone Number</label>
                                                <div class="col-md-6">
                                                    <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-phone"></i>
                                                </span>
                                                        <input id="iis_mobile" class="form-control" type="text"
                                                               value="<?php echo $_POST['clientData']['iis_mobile']; ?>"
                                                               placeholder="Contact Phone Number"
                                                               onfocus="remove_formError(this.id,'true')"
                                                               name="clientData[iis_mobile]">
                                                    </div>
                                                    <?php if (!empty($arErrorMessages['iis_mobile'])) { ?>
                                                        <span class="help-block pull-left">
                                                <i class="fa fa-times-circle"></i>
                                                            <?php echo $arErrorMessages['iis_mobile']; ?>
                                            </span>
                                                    <?php } ?>
                                                </div>

                                            </div>
                                            <div
                                                    class="form-group <?php if (!empty($arErrorMessages['iis_email'])) { ?>has-error<?php } ?>">
                                                <label class="col-md-4 control-label">Contact Email</label>
                                                <div class="col-md-6">
                                                    <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-envelope"></i>
                                                </span>
                                                        <input id="iis_email" class="form-control" type="text"
                                                               value="<?php echo $_POST['clientData']['iis_email']; ?>"
                                                               placeholder="Contact Email"
                                                               onfocus="remove_formError(this.id,'true')"
                                                               name="clientData[iis_email]">
                                                    </div>
                                                    <?php if (!empty($arErrorMessages['iis_email'])) { ?>
                                                        <span class="help-block pull-left">
                                                <i class="fa fa-times-circle"></i>
                                                            <?php echo $arErrorMessages['iis_email']; ?>
                                            </span>
                                                    <?php } ?>
                                                </div>

                                            </div>
                                            <hr>
                                            <div class="font-green-meadow text"> Who is to receive the confirmatory
                                                lab results?
                                            </div>
                                            <hr>
                                            <div
                                                    class="form-group <?php if (!empty($arErrorMessages['rlr_name'])) { ?>has-error<?php } ?>">
                                                <label class="col-md-4 control-label"> Contact Name</label>
                                                <div class="col-md-6">
                                                    <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-user"></i>
                                                </span>
                                                        <input id="rlr_name" class="form-control" type="text"
                                                               value="<?php echo $_POST['clientData']['rlr_name']; ?>"
                                                               placeholder="Contact Name"
                                                               onfocus="remove_formError(this.id,'true')"
                                                               name="clientData[rlr_name]">
                                                    </div>
                                                    <?php if (!empty($arErrorMessages['rlr_name'])) { ?>
                                                        <span class="help-block pull-left">
                                                <i class="fa fa-times-circle"></i>
                                                            <?php echo $arErrorMessages['rlr_name']; ?>
                                            </span>
                                                    <?php } ?>
                                                </div>

                                            </div>
                                            <div
                                                    class="form-group <?php if (!empty($arErrorMessages['rlr_mobile'])) { ?>has-error<?php } ?>">
                                                <label class="col-md-4 control-label">Contact Phone Number</label>
                                                <div class="col-md-6">
                                                    <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-phone"></i>
                                                </span>
                                                        <input id="rlr_mobile" class="form-control" type="text"
                                                               value="<?php echo $_POST['clientData']['rlr_mobile']; ?>"
                                                               placeholder="Contact Phone Number"
                                                               onfocus="remove_formError(this.id,'true')"
                                                               name="clientData[rlr_mobile]">
                                                    </div>
                                                    <?php if (!empty($arErrorMessages['rlr_mobile'])) { ?>
                                                        <span class="help-block pull-left">
                                                <i class="fa fa-times-circle"></i>
                                                            <?php echo $arErrorMessages['rlr_mobile']; ?>
                                            </span>
                                                    <?php } ?>
                                                </div>

                                            </div>
                                            <div
                                                    class="form-group <?php if (!empty($arErrorMessages['rlr_email'])) { ?>has-error<?php } ?>">
                                                <label class="col-md-4 control-label">Contact Email</label>
                                                <div class="col-md-6">
                                                    <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-envelope"></i>
                                                </span>
                                                        <input id="rlr_email" class="form-control" type="text"
                                                               value="<?php echo $_POST['clientData']['rlr_email']; ?>"
                                                               placeholder="Contact Email"
                                                               onfocus="remove_formError(this.id,'true')"
                                                               name="clientData[rlr_email]">
                                                    </div>
                                                    <?php if (!empty($arErrorMessages['rlr_email'])) { ?>
                                                        <span class="help-block pull-left">
                                                <i class="fa fa-times-circle"></i>
                                                            <?php echo $arErrorMessages['rlr_email']; ?>
                                            </span>
                                                    <?php } ?>
                                                </div>

                                            </div>
                                            <hr>
                                            <div class="font-green-meadow text"> Are the any other people who are
                                                to receive the confirmatory lab results?
                                            </div>
                                            <hr>
                                            <div
                                                    class="form-group <?php if (!empty($arErrorMessages['orlr_name'])) { ?>has-error<?php } ?>">
                                                <label class="col-md-4 control-label"> Contact Name</label>
                                                <div class="col-md-6">
                                                    <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-user"></i>
                                                </span>
                                                        <input id="orlr_name" class="form-control" type="text"
                                                               value="<?php echo $_POST['clientData']['orlr_name']; ?>"
                                                               placeholder="Contact Name"
                                                               onfocus="remove_formError(this.id,'true')"
                                                               name="clientData[orlr_name]">
                                                    </div>
                                                    <?php if (!empty($arErrorMessages['orlr_name'])) { ?>
                                                        <span class="help-block pull-left">
                                                <i class="fa fa-times-circle"></i>
                                                            <?php echo $arErrorMessages['orlr_name']; ?>
                                            </span>
                                                    <?php } ?>
                                                </div>

                                            </div>
                                            <div
                                                    class="form-group <?php if (!empty($arErrorMessages['orlr_mobile'])) { ?>has-error<?php } ?>">
                                                <label class="col-md-4 control-label">Contact Phone Number</label>
                                                <div class="col-md-6">
                                                    <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-phone"></i>
                                                </span>
                                                        <input id="orlr_mobile" class="form-control" type="text"
                                                               value="<?php echo $_POST['clientData']['orlr_mobile']; ?>"
                                                               placeholder="Contact Phone Number"
                                                               onfocus="remove_formError(this.id,'true')"
                                                               name="clientData[orlr_mobile]">
                                                    </div>
                                                    <?php if (!empty($arErrorMessages['orlr_mobile'])) { ?>
                                                        <span class="help-block pull-left">
                                                <i class="fa fa-times-circle"></i>
                                                            <?php echo $arErrorMessages['orlr_mobile']; ?>
                                            </span>
                                                    <?php } ?>
                                                </div>

                                            </div>
                                            <div
                                                    class="form-group <?php if (!empty($arErrorMessages['orlr_email'])) { ?>has-error<?php } ?>">
                                                <label class="col-md-4 control-label">Contact Email</label>
                                                <div class="col-md-6">
                                                    <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-envelope"></i>
                                                </span>
                                                        <input id="orlr_email" class="form-control" type="text"
                                                               value="<?php echo $_POST['clientData']['orlr_email']; ?>"
                                                               placeholder="Contact Email"
                                                               onfocus="remove_formError(this.id,'true')"
                                                               name="clientData[orlr_email]">
                                                    </div>
                                                    <?php if (!empty($arErrorMessages['orlr_email'])) { ?>
                                                        <span class="help-block pull-left">
                                                <i class="fa fa-times-circle"></i>
                                                            <?php echo $arErrorMessages['orlr_email']; ?>
                                            </span>
                                                    <?php } ?>
                                                </div>

                                            </div>
                                        </table>

                                    </div>
                                </div>
                                <!-- END CONTACT DETAILS PORTLET-->
                                <!-- BEGIN ONSITE SCREENING INFORMATION PORTLET-->
                                <div class="portlet box green-meadow ">
                                    <div class="portlet-title" data-toggle="collapse" data-target="#onsite">
                                        <div class="caption">
                                            <i class="icon-equalizer "></i>
                                            ONSITE SCREENING INFORMATION
                                        </div>
                                        <div class="tools">
                                            <a href="javascript:void(0);" class="collapse-sec collapsed"
                                               data-toggle="collapse" data-target="#onsite">
                                            </a>

                                        </div>
                                    </div>

                                    <div id="onsite" class="portlet-body collapse">
                                        <table class="table table-hover">
                                            <hr>
                                            <div class="font-green-meadow text"> Primary Site Contact (Assist with donor
                                                selection and supervise/manage donors if required).
                                            </div>
                                            <hr>
                                            <div
                                                    class="form-group <?php if (!empty($arErrorMessages['psc_name'])) { ?>has-error<?php } ?>">
                                                <label class="col-md-4 control-label"> Contact Name</label>
                                                <div class="col-md-6">
                                                    <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-user"></i>
                                                </span>
                                                        <input id="psc_name" class="form-control" type="text"
                                                               value="<?php echo $_POST['clientData']['psc_name']; ?>"
                                                               placeholder="Contact Name"
                                                               onfocus="remove_formError(this.id,'true')"
                                                               name="clientData[psc_name]">
                                                    </div>
                                                    <?php if (!empty($arErrorMessages['psc_name'])) { ?>
                                                        <span class="help-block pull-left">
                                                <i class="fa fa-times-circle"></i>
                                                            <?php echo $arErrorMessages['psc_name']; ?>
                                            </span>
                                                    <?php } ?>
                                                </div>

                                            </div>
                                            <div
                                                    class="form-group <?php if (!empty($arErrorMessages['psc_phone'])) { ?>has-error<?php } ?>">
                                                <label class="col-md-4 control-label">Landline Phone Number</label>
                                                <div class="col-md-6">
                                                    <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-phone"></i>
                                                </span>
                                                        <input id="psc_phone" class="form-control" type="text"
                                                               value="<?php echo $_POST['clientData']['psc_phone']; ?>"
                                                               placeholder="Landline Phone Number"
                                                               onfocus="remove_formError(this.id,'true')"
                                                               name="clientData[psc_phone]">
                                                    </div>
                                                    <?php if (!empty($arErrorMessages['psc_phone'])) { ?>
                                                        <span class="help-block pull-left">
                                                <i class="fa fa-times-circle"></i>
                                                            <?php echo $arErrorMessages['psc_phone']; ?>
                                            </span>
                                                    <?php } ?>
                                                </div>

                                            </div>
                                            <div
                                                    class="form-group <?php if (!empty($arErrorMessages['psc_mobile'])) { ?>has-error<?php } ?>">
                                                <label class="col-md-4 control-label">Mobile Phone Number</label>
                                                <div class="col-md-6">
                                                    <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-mobile-phone"></i>
                                                </span>
                                                        <input id="psc_mobile" class="form-control" type="text"
                                                               value="<?php echo $_POST['clientData']['psc_mobile']; ?>"
                                                               placeholder="Mobile Phone Number"
                                                               onfocus="remove_formError(this.id,'true')"
                                                               name="clientData[psc_mobile]">
                                                    </div>
                                                    <?php if (!empty($arErrorMessages['psc_mobile'])) { ?>
                                                        <span class="help-block pull-left">
                                                <i class="fa fa-times-circle"></i>
                                                            <?php echo $arErrorMessages['psc_mobile']; ?>
                                            </span>
                                                    <?php } ?>
                                                </div>

                                            </div>
                                            <hr>
                                            <div class="font-green-meadow text"> Secondary Site Contact (in the
                                                event that the primary site contact is unavailable).
                                            </div>
                                            <hr>
                                            <div
                                                    class="form-group <?php if (!empty($arErrorMessages['ssc_name'])) { ?>has-error<?php } ?>">
                                                <label class="col-md-4 control-label"> Contact Name</label>
                                                <div class="col-md-6">
                                                    <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-user"></i>
                                                </span>
                                                        <input id="ssc_name" class="form-control" type="text"
                                                               value="<?php echo $_POST['clientData']['ssc_name']; ?>"
                                                               placeholder="Contact Name"
                                                               onfocus="remove_formError(this.id,'true')"
                                                               name="clientData[ssc_name]">
                                                    </div>
                                                    <?php if (!empty($arErrorMessages['ssc_name'])) { ?>
                                                        <span class="help-block pull-left">
                                                <i class="fa fa-times-circle"></i>
                                                            <?php echo $arErrorMessages['ssc_name']; ?>
                                            </span>
                                                    <?php } ?>
                                                </div>

                                            </div>
                                            <div
                                                    class="form-group <?php if (!empty($arErrorMessages['ssc_phone'])) { ?>has-error<?php } ?>">
                                                <label class="col-md-4 control-label">Landline Phone Number</label>
                                                <div class="col-md-6">
                                                    <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-phone"></i>
                                                </span>
                                                        <input id="ssc_phone" class="form-control" type="text"
                                                               value="<?php echo $_POST['clientData']['ssc_phone']; ?>"
                                                               placeholder="Landline Phone Number"
                                                               onfocus="remove_formError(this.id,'true')"
                                                               name="clientData[ssc_phone]">
                                                    </div>
                                                    <?php if (!empty($arErrorMessages['ssc_phone'])) { ?>
                                                        <span class="help-block pull-left">
                                                <i class="fa fa-times-circle"></i>
                                                            <?php echo $arErrorMessages['ssc_phone']; ?>
                                            </span>
                                                    <?php } ?>
                                                </div>

                                            </div>
                                            <div
                                                    class="form-group <?php if (!empty($arErrorMessages['ssc_mobile'])) { ?>has-error<?php } ?>">
                                                <label class="col-md-4 control-label">Mobile Phone Number</label>
                                                <div class="col-md-6">
                                                    <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-mobile-phone"></i>
                                                </span>
                                                        <input id="ssc_mobile" class="form-control" type="text"
                                                               value="<?php echo $_POST['clientData']['ssc_mobile']; ?>"
                                                               placeholder="Mobile Phone Number"
                                                               onfocus="remove_formError(this.id,'true')"
                                                               name="clientData[ssc_mobile]">
                                                    </div>
                                                    <?php if (!empty($arErrorMessages['ssc_mobile'])) { ?>
                                                        <span class="help-block pull-left">
                                                <i class="fa fa-times-circle"></i>
                                                            <?php echo $arErrorMessages['ssc_mobile']; ?>
                                            </span>
                                                    <?php } ?>
                                                </div>

                                            </div>

                                            <hr>
                                            <div
                                                    class="form-group <?php if (!empty($arErrorMessages['instructions'])) { ?>has-error<?php } ?>">
                                                <label class="col-md-4 control-label"> Any special instruction for
                                                    DrugSafe staff (directions, instructions, etc.) </label>
                                                <div class="col-md-6">
                                                    <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-code"></i>
                                                </span>
                                                        <textarea name="clientData[instructions]" id="instructions"
                                                                  class="form-control"
                                                                  value="<?php echo $_POST['clientData']['ssc_mobile']; ?>"
                                                                  rows="5"
                                                                  placeholder=" Any special instruction for DrugSafe staff "
                                                                  onfocus="remove_formError(this.id,'true')"><?php echo set_value('clientData[instructions]'); ?></textarea>
                                                    </div>
                                                    <?php if (!empty($arErrorMessages['instructions'])) { ?>
                                                        <span class="help-block pull-left">
                                                <i class="fa fa-times-circle"></i>
                                                            <?php echo $arErrorMessages['instructions']; ?>
                                            </span>
                                                    <?php } ?>
                                                </div>

                                            </div>
                                            <div
                                                    class="form-group <?php if (!empty($arErrorMessages['site_people'])) { ?>has-error<?php } ?>">
                                                <label class="col-md-4 control-label">How many people on site?</label>
                                                <div class="col-md-6">
                                                    <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-users"></i>
                                                </span>
                                                        <input id="site_people" class="form-control" type="text"
                                                               value="<?php echo $_POST['clientData']['site_people']; ?>"
                                                               placeholder="People on site"
                                                               onfocus="remove_formError(this.id,'true')"
                                                               name="clientData[site_people]">
                                                    </div>
                                                    <?php if (!empty($arErrorMessages['site_people'])) { ?>
                                                        <span class="help-block pull-left">
                                                <i class="fa fa-times-circle"></i>
                                                            <?php echo $arErrorMessages['site_people']; ?>
                                            </span>
                                                    <?php } ?>
                                                </div>

                                            </div>
                                            <div
                                                    class="form-group <?php if (!empty($arErrorMessages['test_count'])) { ?>has-error<?php } ?>">
                                                <label class="col-md-4 control-label">How many to test?</label>
                                                <div class="col-md-6">
                                                    <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-users"></i>
                                                </span>
                                                        <input id="test_count" class="form-control" type="text"
                                                               value="<?php echo $_POST['clientData']['test_count']; ?>"
                                                               placeholder="Test Count"
                                                               onfocus="remove_formError(this.id,'true')"
                                                               name="clientData[test_count]">
                                                    </div>
                                                    <?php if (!empty($arErrorMessages['test_count'])) { ?>
                                                        <span class="help-block pull-left">
                                                <i class="fa fa-times-circle"></i>
                                                            <?php echo $arErrorMessages['test_count']; ?>
                                            </span>
                                                    <?php } ?>
                                                </div>

                                            </div>
                                            <div
                                                    class="form-group <?php if (!empty($arErrorMessages['initial_testing_req'])) { ?>has-error<?php } ?>">
                                                <label class="col-md-4 control-label">Initial Testing
                                                    Requirements</label>
                                                <div class="col-md-6">
                                                    <div class="input-group">

                                                        <label class="radio-inline "><input type="radio"
                                                                                            id="initial_testing_req"
                                                                                            value="0" <?php echo(sanitize_post_field_value($_POST['clientData']['initial_testing_req']) == 0 ? "checked" : ""); ?>
                                                                                            name="clientData[initial_testing_req]"
                                                                                            checked> Random</label>
                                                        <label class="radio-inline"><input type="radio"
                                                                                           id="initial_testing_req"
                                                                                           value="1"<?php echo(sanitize_post_field_value($_POST['clientData']['initial_testing_req']) == 1 ? "checked" : ""); ?>
                                                                                           name="clientData[initial_testing_req]">
                                                            Blanket</label>
                                                    </div>
                                                    <?php if (!empty($arErrorMessages['initial_testing_req'])) { ?>
                                                        <span class="help-block pull-left">
                                                <i class="fa fa-times-circle"></i>
                                                            <?php echo $arErrorMessages['initial_testing_req']; ?>
                                            </span>
                                                    <?php } ?>
                                                </div>

                                            </div>
                                            <div
                                                    class="form-group <?php if (!empty($arErrorMessages['ongoing_testing_req'])) { ?>has-error<?php } ?>">
                                                <label class="col-md-4 control-label">Ongoing Testing
                                                    Requirements</label>
                                                <div class="col-md-6">
                                                    <div class="input-group">
                                                        <label class="radio-inline"><input type="radio"
                                                                                           id="ongoing_testing_req"
                                                                                           value="0"<?php echo(sanitize_post_field_value($_POST['clientData']['ongoing_testing_req']) == 0 ? "checked" : ""); ?>
                                                                                           name="clientData[ongoing_testing_req]"
                                                                                           checked> Random</label>
                                                        <label class="radio-inline"><input type="radio"
                                                                                           id="ongoing_testing_req"
                                                                                           value="1"<?php echo(sanitize_post_field_value($_POST['clientData']['ongoing_testing_req']) == 1 ? "checked" : ""); ?>
                                                                                           name="clientData[ongoing_testing_req]">
                                                            Blanket</label>
                                                    </div>
                                                    <?php if (!empty($arErrorMessages['ongoing_testing_req'])) { ?>
                                                        <span class="help-block pull-left">
                                                <i class="fa fa-times-circle"></i>
                                                            <?php echo $arErrorMessages['ongoing_testing_req']; ?>
                                            </span>
                                                    <?php } ?>
                                                </div>


                                            </div>
                                            <div class="form-group <?php if (!empty($arErrorMessages['site_visit'])) { ?>has-error<?php } ?>">
                                                <label class="col-md-4 control-label">How many times would you like
                                                    DrugSafe to visit your site and test per year?</label>
                                                <div class="col-md-6">
                                                    <div class="input-group">
                                                        <?php
                                                        if (!empty($_POST['clientData'])) {

                                                            if ($_POST['clientData']['site_visit'] == 0) {
                                                                $val = "0";

                                                            } else {
                                                                $val = $_POST['clientData']['site_visit'];
                                                            }
                                                        } else {
                                                            $val = "0";
                                                        }

                                                        ?>
                                                        <span class="input-group-addon">
                                                <i class="fa fa-user"></i>
                                                </span>
                                                        <input id="site_visit" class="form-control" type="number"
                                                               min="0" max="52"
                                                               value="<?php echo $val; ?>"
                                                               placeholder="Site Visit"
                                                               onfocus="remove_formError(this.id,'true')"
                                                               name="clientData[site_visit]">
                                                    </div>
                                                    <?php if (!empty($arErrorMessages['site_visit'])) { ?>
                                                        <span class="help-block pull-left">
                                                         <i class="fa fa-times-circle"></i>
                                                            <?php echo $arErrorMessages['site_visit']; ?>
                                                       </span>
                                                    <?php } ?>
                                                </div>

                                            </div>
                                            <div class="form-group <?php if (!empty($arErrorMessages['onsite_service'])) { ?>has-error<?php } ?>">
                                                <label class="col-md-4 control-label">What type of service would you
                                                    like on-site?</label>
                                                <div class="col-md-6">
                                                    <div class="input-group">
                                                        <label class="radio-inline"><input type="radio"
                                                                                           id="onsite_service"
                                                                                           value="0"<?php echo(sanitize_post_field_value($_POST['clientData']['onsite_service']) == 0 ? "checked" : ""); ?>
                                                                                           checked
                                                                                           name="clientData[onsite_service]">
                                                            Mobile Clinic </label>
                                                        <label class="radio-inline"><input type="radio"
                                                                                           id="onsite_service"
                                                                                           value="1"<?php echo(sanitize_post_field_value($_POST['clientData']['onsite_service']) == 1 ? "checked" : ""); ?>
                                                                                           name="clientData[onsite_service]">
                                                            In-house</label>
                                                    </div>
                                                    <?php if (!empty($arErrorMessages['onsite_service'])) { ?>
                                                        <span class="help-block pull-left">
                                                <i class="fa fa-times-circle"></i>
                                                            <?php echo $arErrorMessages['onsite_service']; ?>
                                            </span>
                                                    <?php } ?>
                                                </div>

                                            </div>
                                            <div
                                                    class="form-group <?php if (!empty($arErrorMessages['start_time'])) { ?>has-error<?php } ?>">
                                                <label class="col-md-4 control-label">Preferred start time</label>
                                                <div class="col-md-6">
                                                    <div class="input-icon">
                                                        <i class="fa fa-clock-o"></i>
                                                        <input type="text"
                                                               class="form-control timepicker timepicker-default"
                                                               id="start_time"
                                                               value="<?php echo $_POST['clientData']['start_time']; ?>"
                                                               name="clientData[start_time]"
                                                               onfocus="remove_formError(this.id,'true')">
                                                    </div>
                                                    <?php if (!empty($arErrorMessages['start_time'])) { ?>
                                                        <span class="help-block pull-left">
                                                <i class="fa fa-times-circle"></i>
                                                            <?php echo $arErrorMessages['start_time']; ?>
                                            </span>
                                                    <?php } ?>
                                                </div>

                                            </div>
                                            <div
                                                    class="form-group <?php if (!empty($arErrorMessages['power_access'])) { ?>has-error<?php } ?>">
                                                <label class="col-md-4 control-label">Access to power for our
                                                    Mobile</label>
                                                <div class="col-md-6">
                                                    <?php
                                                    if (!empty($_POST['clientData'])) {

                                                        if ($_POST['clientData']['power_access'] == 0) {
                                                            $Ychecked = "checked";

                                                        }
                                                        if ($_POST['clientData']['power_access'] == 1) {
                                                            $Nchecked = "checked";
                                                        }
                                                    } else {
                                                        $Nchecked = "checked";
                                                    }

                                                    ?>
                                                    <div class="input-group">
                                                        <label class="radio-inline"><input type="radio"
                                                                                           id="power_access"
                                                                                           value="0" <?php echo $Ychecked; ?>
                                                                                           name="clientData[power_access]">
                                                            Yes</label>
                                                        <label class="radio-inline"><input type="radio"
                                                                                           id="power_access"
                                                                                           value="1"<?php echo $Nchecked; ?>
                                                                                           name="clientData[power_access]">
                                                            No</label>
                                                    </div>
                                                    <?php if (!empty($arErrorMessages['power_access'])) { ?>
                                                        <span class="help-block pull-left">
                                                <i class="fa fa-times-circle"></i>
                                                            <?php echo $arErrorMessages['power_access']; ?>
                                            </span>
                                                    <?php } ?>
                                                </div>

                                            </div>
                                            <div
                                                    class="form-group <?php if (!empty($arErrorMessages['risk_assessment'])) { ?>has-error<?php } ?>">
                                                <label class="col-md-4 control-label">Is a risk assessment required
                                                    prior to working on-site?</label>
                                                <div class="col-md-6">
                                                    <?php
                                                    if (!empty($_POST['clientData'])) {
                                                        $Ychecked = '';
                                                        $Nchecked = '';
                                                        if ($_POST['clientData']['risk_assessment'] == 0) {
                                                            $Ychecked = "checked";
                                                        }
                                                        if ($_POST['clientData']['risk_assessment'] == 1) {
                                                            $Nchecked = "checked";
                                                        }
                                                    } else {
                                                        $Nchecked = "checked";
                                                    }

                                                    ?>
                                                    <div class="input-group">
                                                        <label class="radio-inline"><input type="radio"
                                                                                           id="risk_assessment"
                                                                                           value="0" <?php echo $Ychecked; ?>
                                                                                           name="clientData[risk_assessment]">
                                                            Yes</label>
                                                        <label class="radio-inline"><input type="radio"
                                                                                           id="risk_assessment"
                                                                                           value="1" <?php echo $Nchecked; ?>
                                                                                           name="clientData[risk_assessment]"
                                                            > No</label>
                                                    </div>
                                                    <?php if (!empty($arErrorMessages['risk_assessment'])) { ?>
                                                        <span class="help-block pull-left">
                                                <i class="fa fa-times-circle"></i>
                                                            <?php echo $arErrorMessages['risk_assessment']; ?>
                                            </span>
                                                    <?php } ?>
                                                </div>

                                            </div>
                                            <div
                                                    class="form-group <?php if (!empty($arErrorMessages['req_comp_induction'])) { ?>has-error<?php } ?>">
                                                <label class="col-md-4 control-label">Are our people required to
                                                    complete an induction?</label>
                                                <div class="col-md-6">
                                                    <?php
                                                    if (!empty($_POST['clientData'])) {

                                                        if ($_POST['clientData']['req_comp_induction'] == 0) {
                                                            $Ychecked = "checked";

                                                        }
                                                        if ($_POST['clientData']['req_comp_induction'] == 1) {
                                                            $Nchecked = "checked";
                                                        }
                                                    } else {
                                                        $Nchecked = "checked";
                                                    }

                                                    ?>
                                                    <div class="input-group">
                                                        <label class="radio-inline"><input type="radio"
                                                                                           id="req_comp_induction"
                                                                                           value="0" <?php echo $Ychecked; ?>
                                                                                           name="clientData[req_comp_induction]">
                                                            Yes</label>
                                                        <label class="radio-inline"><input type="radio"
                                                                                           id="req_comp_induction"
                                                                                           value="1" <?php echo $Nchecked; ?>
                                                                                           name="clientData[req_comp_induction]"
                                                            > No</label>
                                                    </div>
                                                    <?php if (!empty($arErrorMessages['req_comp_induction'])) { ?>
                                                        <span class="help-block pull-left">
                                                <i class="fa fa-times-circle"></i>
                                                            <?php echo $arErrorMessages['req_comp_induction']; ?>
                                            </span>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <div
                                                    class="form-group <?php if (!empty($arErrorMessages['randomisation'])) { ?>has-error<?php } ?>">
                                                <label class="col-md-4 control-label">Randomization process</label>
                                                <div class="col-md-6">
                                                    <?php
                                                    if (!empty($_POST['clientData'])) {

                                                        if ($_POST['clientData']['randomisation'] == 0) {
                                                            $Mchecked = "checked";
                                                        }
                                                        if ($_POST['clientData']['randomisation'] == 1) {
                                                            $Dchecked = "checked";
                                                        }
                                                        if ($_POST['clientData']['randomisation'] == 2) {
                                                            $Cchecked = "checked";
                                                        }
                                                    } else {
                                                        $Dchecked = "checked";
                                                    }

                                                    ?>
                                                    <div class="input-group">

                                                        <label><input type="radio" id="randomisation"
                                                                      value="0" <?php echo $Mchecked; ?>
                                                                      name="clientData[randomisation]"> Marble
                                                            selection (% split)-not accurate</label>


                                                        <label><input type="radio" id="randomisation"
                                                                      value="1" <?php echo $Dchecked; ?>
                                                                      name="clientData[randomisation]">
                                                            DrugSafe given names then select via algorythm</label>


                                                        <label><input type="radio" id="randomisation"
                                                                      value="2" <?php echo $Cchecked; ?>
                                                                      name="clientData[randomisation]"> Client does
                                                            randomization</label>

                                                    </div>
                                                    <?php if (!empty($arErrorMessages['randomisation'])) { ?>
                                                        <span class="help-block pull-left">
                                                <i class="fa fa-times-circle"></i>
                                                            <?php echo $arErrorMessages['randomisation']; ?>
                                            </span>
                                                    <?php } ?>
                                                </div>

                                            </div>
                                            <div

                                                    class="form-group <?php if (!empty($arErrorMessages['req_ppe'])) { ?>has-error<?php } ?>">
                                                <label class="col-md-4 control-label">Required PPE</label>
                                                <div class="col-md-6">
                                                    <?php if (!empty($_POST['req_ppe'])) {
                                                        if (in_array("1", $_POST['req_ppe'])) {
                                                            $checked1 = "checked";
                                                        }
                                                        if (in_array("2", $_POST['req_ppe'])) {
                                                            $checked2 = "checked";
                                                        }
                                                        if (in_array("3", $_POST['req_ppe'])) {
                                                            $checked3 = "checked";
                                                        }
                                                        if (in_array("4", $_POST['req_ppe'])) {
                                                            $checked4 = "checked";
                                                        }
                                                        if (in_array("5", $_POST['req_ppe'])) {
                                                            $checked5 = "checked";
                                                        }
                                                    }
                                                    ?>
                                                    <div class="input-group">
                                                        <div class="checkbox">
                                                            <label><input type="checkbox" id="req_ppe1"
                                                                          value="1" <?php echo $checked1; ?>
                                                                          name="req_ppe[]"> High Vis Work
                                                                Wear</label>
                                                        </div>
                                                        <div class="checkbox">
                                                            <label><input type="checkbox" id="req_ppe2"
                                                                          value="2" <?php echo $checked2; ?>
                                                                          name="req_ppe[]"> Head Protection</label>
                                                        </div>
                                                        <div class="checkbox">
                                                            <label><input type="checkbox" id="req_ppe3"
                                                                          value="3"<?php echo $checked3; ?>
                                                                          name="req_ppe[]"> Face/Eye
                                                                Protection</label>
                                                        </div>
                                                        <div class="checkbox">
                                                            <label><input type="checkbox" id="req_ppe4"
                                                                          value="4" <?php echo $checked4; ?>
                                                                          name="req_ppe[]"> Safety Boots</label>
                                                        </div>
                                                        <div class="checkbox">
                                                            <label><input type="checkbox" id="req_ppe5"
                                                                          name="req_ppe[]"
                                                                          value="5" <?php echo $checked5; ?> >
                                                                Long Sleeve Clothing
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <?php if (!empty($arErrorMessages['req_ppe'])) { ?>
                                                        <span class="help-block pull-left">
                                                <i class="fa fa-times-circle"></i>
                                                            <?php echo $arErrorMessages['req_ppe']; ?>
                                            </span>
                                                    <?php } ?>
                                                </div>

                                            </div>
                                            <div
                                                    class="form-group <?php if (!empty($arErrorMessages['paperwork'])) { ?>has-error<?php } ?>">
                                                <label class="col-md-4 control-label">Who would be responsible for all
                                                    the paperwork at the end of testing?</label>
                                                <div class="col-md-6">
                                                    <div class="input-group">

                                                        <label><input type="radio" id="paperwork"
                                                                      value="0"<?php echo(sanitize_post_field_value($_POST['clientData']['paperwork']) == 0 ? "checked" : ""); ?>
                                                                      name="clientData[paperwork]" checked
                                                                      onclick="showHideTextbox('0');"> Leave onsite
                                                            with site contact</label>
                                                        <label><input type="radio" id="paperwork"
                                                                      value="1"<?php echo(sanitize_post_field_value($_POST['clientData']['paperwork']) == 1 ? "checked" : ""); ?>
                                                                      name="clientData[paperwork]"
                                                                      onclick="showHideTextbox('1');"> Return to
                                                            DrugSafe for filing</label>
                                                        <label><input type="radio" id="paperwork"
                                                                      value="2"<?php echo(sanitize_post_field_value($_POST['clientData']['paperwork']) == 2 ? "checked" : ""); ?>
                                                                      name="clientData[paperwork]"
                                                                      onclick="showHideTextbox('2');"> Return to
                                                            DrugSafe and emailed to specific contact</label>

                                                    </div>
                                                </div>
                                                <?php if (!empty($arErrorMessages['paperwork'])) { ?>
                                                    <span class="help-block pull-left">
                                                <i class="fa fa-times-circle"></i>
                                                        <?php echo $arErrorMessages['paperwork']; ?>
                                            </span>
                                                <?php } ?>
                                            </div>
                                            <div class="text" id="text"
                                                 <?php if (trim($_POST['clientData']['paperwork'] == '2')){ ?>style="display:block;"
                                                 <?php }else{ ?>style="display:none;"<?php } ?>>
                                                <div
                                                        class="form-group <?php if (!empty($arErrorMessages['specify_contact'])) { ?>has-error<?php } ?>">
                                                    <label class="col-md-4 control-label">Specify Contact</label>
                                                    <div class="col-md-6">
                                                        <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-users"></i>
                                                </span>
                                                            <input id="specify_contact" class="form-control div1"
                                                                   type="text"
                                                                   value="<?php echo $_POST['clientData']['specify_contact']; ?>"
                                                                   placeholder="Specify Contact"
                                                                   onfocus="remove_formError(this.id,'true')"
                                                                   name="clientData[specify_contact]"></div>
                                                        <?php if (!empty($arErrorMessages['specify_contact'])) { ?>
                                                            <span class="help-block pull-left">
                                        <i class="fa fa-times-circle"></i>
                                                                <?php echo $arErrorMessages['specify_contact']; ?>
                                    </span>
                                                        <?php } ?>
                                                    </div>
                                                </div>

                                            </div>


                                        </table>

                                    </div>
                                </div>


                                <!-- END CONTACT DETAILS PORTLET-->
                            <?php } ?>
                            <input id="iRole" class="form-control" type="hidden" value="2" placeholder="Role"
                                   onfocus="remove_formError(this.id,'true')" name="clientData[iRole]">
                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-offset-3 col-md-4">
                                        <?php if ($flag == 1) { ?>
                                            <a href="<?= __BASE_URL__ ?>/admin/franchiseeList"
                                               class="btn default uppercase" type="button">Cancel</a>
                                        <?php } else { ?>
                                            <a href="<?= __BASE_URL__ ?>/franchisee/clientRecord"
                                               class="btn default uppercase" type="button">Cancel</a>
                                        <?php } ?>
                                        <input type="submit" class="btn green-meadow" value="SAVE"
                                               name="clientData[submit]">

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