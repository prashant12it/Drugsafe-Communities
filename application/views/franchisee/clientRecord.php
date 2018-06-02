<script type='text/javascript'>
    $(function () {
        $("#szSearchname").customselect();
        $("#szSearchClientname").customselect();
         $("#szSearch4").customselect();
        $("#szSearch5").customselect();
    });
</script>

<div class="page-content-wrapper">
    <div class="page-content">
        <?php
        if (!empty($_SESSION['drugsafe_user_message'])) {
            if (trim($_SESSION['drugsafe_user_message']['type']) == "success") {
                ?>
                <div class="alert alert-success">
                    <?php echo $_SESSION['drugsafe_user_message']['content']; ?>
                </div>
            <?php }
            if (trim($_SESSION['drugsafe_user_message']['type']) == "error") {
                ?>
                <div class="alert alert-danger">
                    <?php echo $_SESSION['drugsafe_user_message']['content']; ?>
                </div>
            <?php }
            $this->session->unset_userdata('drugsafe_user_message');
        }
        ?>

        <div id="page_content" class="row">
            <div class="col-md-12">
                <ul class="page-breadcrumb breadcrumb">

                    <?php
                    if ($_SESSION['drugsafe_user']['iRole'] == '2') {
                        ?>

                        <li>
                            <a href="<?php echo __BASE_URL__; ?>/franchisee/clientRecord">Home</a>
                            <i class="fa fa-circle"></i>
                        </li>
                    <?php } elseif ($_SESSION['drugsafe_user']['iRole'] == '5') { ?>
                        <li>
                            <a href="<?php echo __BASE_URL__; ?>/admin/franchiseeList">Home</a>
                            <i class="fa fa-circle"></i>
                        </li>
                        <?php
                    } else { ?>
                        <li>
                            <a href="<?php echo __BASE_URL__; ?>">Home</a>
                            <i class="fa fa-circle"></i>
                        </li>
                        <?php
                        if (!empty($clientAry)) {
                       $operation_manager_id = $this->Franchisee_Model->getoperationManagerId($clientAry['0']['franchiseeId']);
                        $franchiseeDetArr = $this->Admin_Model->getAdminDetailsByEmailOrId('', $operation_manager_id['operationManagerId']);
                            $franchiseeDetArr1 = $this->Admin_Model->getAdminDetailsByEmailOrId('', $clientAry['0']['franchiseeId']);
                            ?>
                           <li>
                        <a onclick="viewFranchisee(<?php echo $operation_manager_id['operationManagerId'];?>);" href="javascript:void(0);"><?php echo $franchiseeDetArr['szName'];?></a>
                        <i class="fa fa-circle"></i>
                       </li>
                        <li>
                        <a onclick="viewClient(<?php echo $clientAry['0']['franchiseeId'];?>);" href="javascript:void(0);"><?php echo $franchiseeDetArr1['szName'];?></a>
                        <i class="fa fa-circle"></i>
                       </li>

                        <?php } ?>
                    <?php } ?>

                    <li>
                        <span class="active">Client Record</span>
                    </li>
                </ul>

                <div class="portlet light bordered">
                    <?php if (($_SESSION['drugsafe_user']['iRole'] == '1') ||  ($_SESSION['drugsafe_user']['iRole'] == '5')) { ?>
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-equalizer font-green-meadow"></i>
                                <span class="caption-subject font-green-meadow ">Plese select a Franchisee to display their related clients.</span>
                            </div>
                            <?php   if (!empty($clientAry) || !empty($corpuserDetailsArr)) {?>
                                 <div class="actions">
                               <a onclick="ViewPdfClientReport('<?php echo $_POST['szSearchClRecord2'];?>','<?php echo $_POST['szSearchClRecord1'];?>','<?php echo $_POST['szSearch4'];?>','<?php echo $_POST['szSearch5'];?>')" href="javascript:void(0);"
                                   class=" btn green-meadow">
                                    <i class="fa fa-file-pdf-o"></i> View Pdf </a>
                                <a onclick="ViewExcelClientReport('<?php echo $_POST['szSearchClRecord2'];?>','<?php echo $_POST['szSearchClRecord1'];?>','<?php echo $_POST['szSearch4'];?>','<?php echo $_POST['szSearch5'];?>')" href="javascript:void(0);"
                                   class=" btn green-meadow">
                                <i class="fa fa-file-excel-o"></i> View Xls </a>

                            </div>
                             <?php } ?>
                        </div>
                            <?php } else { ?>
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-equalizer font-red-sunglo"></i>
                                <span class="caption-subject font-red-sunglo bold uppercase">Client Record</span>
                            </div>
                            <?php
                            if ($_SESSION['drugsafe_user']['iRole'] == '2') {
                                ?>
                                <div class="actions">
                                    <div class="btn-group btn-group-devided" data-toggle="buttons">
                                        <button class="btn btn-sm green-meadow"
                                                onclick="addClientData('<?php echo $idfranchisee;?>','','<?php echo __URL_FRANCHISEE_CLIENTRECORD__; ?>','2');"
                                                href="javascript:void(0);">
                                            &nbsp;Add New Client
                                        </button>
                                    </div>
                              <?php if (!empty($clientAry) || !empty($corpuserDetailsArr)) {
                            ?>      
                               <a onclick="ViewPdfClientReport('<?php echo $_POST['szSearchClRecord2'];?>','<?php echo $_POST['szSearchClRecord1'];?>','<?php echo $_POST['szSearch4'];?>','<?php echo $_POST['szSearch5'];?>')" href="javascript:void(0);"
                                   class=" btn green-meadow">
                                    <i class="fa fa-file-pdf-o"></i> View Pdf </a>
                                <a onclick="ViewExcelClientReport('<?php echo $_POST['szSearchClRecord2'];?>','<?php echo $_POST['szSearchClRecord1'];?>','<?php echo $_POST['szSearch4'];?>','<?php echo $_POST['szSearch5'];?>')" href="javascript:void(0);"
                                   class=" btn green-meadow">
                                <i class="fa fa-file-excel-o"></i> View Xls </a>
                              <?php } ?> 
                                </div>
                            <?php } ?>
                        </div>
                    <?php } ?>
                    <?php
                    if (($_SESSION['drugsafe_user']['iRole'] == '5')||($_SESSION['drugsafe_user']['iRole'] == '1')) {
                         
                        ?>
                       
                            <form class="search-bar" id="szSearchClientRecord"
                                  action="<?= __BASE_URL__ ?>/franchisee/clientRecord" name="szSearchClientRecord"
                                  method="post">
                                <div class=" row">
                                <div class=" col-md-3 search">
                                 <div class="form-group <?php if (!empty($arErrorMessages['szSearchClRecord2']) != '') { ?>has-error<?php } ?>">
                                    <select class="form-control custom-select" name="szSearchClRecord2"
                                            id="szSearchname" onblur="remove_formError(this.id,'true')"
                                            onchange="getClientListByFrId(this.value);">
                                        <option value="">Franchisee Name</option>
                                    
                                        <?php
                                         if ($_SESSION['drugsafe_user']['iRole'] == '1') {
                                           $searchOptionArr =$this->Admin_Model->viewFranchiseeList();
                                            }
                                            else{
                                                     $operationManagerId = $_SESSION['drugsafe_user']['id'];
                                                     $searchOptionArr =$this->Admin_Model->viewFranchiseeList(false,$operationManagerId);
                                            }
                                        foreach ($searchOptionArr as $searchOptionList) {
                                            $selected = ($searchOptionList['id'] == $_POST['szSearchClRecord2'] ? 'selected="selected"' : '');
                                            echo '<option value="' . $searchOptionList['id'] . '"' . $selected . ' >' .$searchOptionList['userCode'].'-'. $searchOptionList['szName'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                </div>

                                <div class=" col-md-3 clienttypeselect">
                                    <div id='szClient'>
                                        <div class="form-group <?php if (!empty($arErrorMessages['szSearchClRecord1']) != '') { ?>has-error<?php } ?>">
                                        <select class="form-control custom-select" name="szSearchClRecord1"
                                                id="szSearchClientname" onfocus="remove_formError(this.id,'true')">
                                            <option value="">Client Name</option>
                                            <?php
                                            foreach ($clientlistArr as $clientList) {
                                            $franchiseecode = $this->Franchisee_Model->getusercodebyuserid($clientList['id']);
                                                $selected = ($clientList['id'] == $_POST['szSearchClRecord1'] ? 'selected="selected"' : '');
                                                echo '<option value="' . $clientList['id'] . '"' . $selected . ' >' .$franchiseecode['userCode'].'-'. $clientList['szName'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                        </div>
                                </div>
                            <div class="col-md-3 clienttypeselect">
                                        <div class="form-group <?php if (!empty($arErrorMessages['szSearch4']) != '') { ?>has-error<?php } ?>">
                                            <div class="input-group input-medium date date-picker"
                                                 data-date-format="dd/mm/yyyy">

                                                <input type="text" id="szSearch4" class="form-control"
                                                       value="<?php echo set_value('szSearch4'); ?>" readonly
                                                       placeholder="Date From"
                                                       onfocus="remove_formError(this.id,'true')" name="szSearch4">
                                                <span class="input-group-addon">
                                               <i class="fa fa-calendar"></i>
                                               </span>
                                            </div>
                                            <!-- /input-group -->
                                            <?php
                                            if (form_error('szSearch4')) {
                                                ?>
                                                <span class="help-block pull-left">
                                                <span><?php echo form_error('szSearch4'); ?></span>
                                                </span><?php } ?>
                                            <?php if (!empty($arErrorMessages['szSearch4'])) { ?>
                                                <span class="help-block pull-left">
                                                <i class="fa fa-times-circle"></i>
                                                    <?php echo $arErrorMessages['szSearch4']; ?>
                                            </span>
                                            <?php } ?>
                                        </div>

                                    </div>
                                    </div>
                                    <div class="row ">
                                   <div class=" col-md-3 clienttypeselect ">
                                      <div class="form-group <?php if (!empty($arErrorMessages['szSearch5']) != '') { ?>has-error<?php } ?>">
                                            <div class="input-group input-medium date date-picker"
                                                 data-date-format="dd/mm/yyyy">

                                                <input type="text" id="szSearch5" class="form-control"
                                                       value="<?php echo set_value('szSearch5'); ?>" readonly
                                                       placeholder="Date To"
                                                       onfocus="remove_formError(this.id,'true')" name="szSearch5">
                                                <span class="input-group-addon">
                                               <i class="fa fa-calendar"></i>
                                               </span>
                                            </div>
                                            <!-- /input-group -->
                                            <?php
                                            if (form_error('szSearch5')) {
                                                ?>
                                                <span class="help-block pull-left">
                                                <span><?php echo form_error('szSearch5'); ?></span>
                                                </span><?php } ?>
                                            <?php if (!empty($arErrorMessages['szSearch5'])) { ?>
                                                <span class="help-block pull-left">
                                                <i class="fa fa-times-circle"></i>
                                                    <?php echo $arErrorMessages['szSearch5']; ?>
                                            </span>
                                            <?php } ?>
                                        </div> 
                                    </div>
                                <div class="col-md-1 clienttypeselect">
                                    <button class="btn green-meadow" type="submit"><i class="fa fa-search"></i></button>
                                </div>
                               </div>
                            </form>
                        

                        <?php
                        if (!empty($clientAry) || !empty($corpuserDetailsArr)) {
                            ?>
                    
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="icon-equalizer font-red-sunglo"></i>
                                    <span class="caption-subject font-red-sunglo bold uppercase">Client Record</span>
                                </div>
                            </div>
                          
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                        <tr>
                                            <th> Client Code</th>
                                            <th> Name</th>
                                            <th> Email</th>
                                            <?php
                                            if ($_SESSION['drugsafe_user']['iRole'] == '1') {
                                                ?>
                                                <th> Franchisee</th>
                                                <?php
                                            }
                                            ?>

                                            <th> No of Sites</th>
                                            <th> Contact No</th>
                                            <th> Created By</th>
                                            <th> Updated By</th>
                                            <th> Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $i = 0;
                                        if(!empty($clientAry)) {
                                            foreach ($clientAry as $clientData) {
                                                $franchiseecode = $this->Franchisee_Model->getusercodebyuserid($clientData['id']);
                                                ?>
                                                <tr>
                                                    <td> <?php echo(!empty($franchiseecode['userCode']) ? $franchiseecode['userCode'] : 'N/A'); ?> </td>
                                                     <td> <?php echo(!empty($clientData['szName']) ? $clientData['szName'] : 'N/A'); ?> </td>
                                                      <td> <?php echo(!empty($clientData['szEmail']) ? $clientData['szEmail'] : 'N/A'); ?> </td>
                                                    <?php
                                                    if ($_SESSION['drugsafe_user']['iRole'] == '1') {
                                                        ?>
                                                        <td>
                                                            <?php
                                                            $franchiseeDetArr = $this->Admin_Model->getAdminDetailsByEmailOrId('', $clientData['franchiseeId']);
                                                            echo $franchiseeDetArr['szName'];
                                                            ?>
                                                        </td>
                                                        <?php
                                                    }
                                                    ?>

                                                    <td>
                                                        <?php
                                                        $childClientDetailsAray = $this->Franchisee_Model->viewChildClientDetails($clientData['id']);
                                                        echo count($childClientDetailsAray);
                                                        ?>


                                                    </td>
                                                     <td> <?php echo(!empty($clientData['szContactNumber']) ? $clientData['szContactNumber'] : 'N/A'); ?> </td>
                                                      

                                                    <td>
                                                        <?php
                                                        if ($clientData['szCreatedBy']) {
                                                            $franchiseeDetArr = $this->Admin_Model->getAdminDetailsByEmailOrId('', $clientData['szCreatedBy']);
                                                            echo $franchiseeDetArr['szName'];
                                                        }
                                                        ?>

                                                    </td>
                                                    <td>
                                                        <?php
                                                        if ($clientData['szLastUpdatedBy']) {
                                                            $franchiseeDetArr = $this->Admin_Model->getAdminDetailsByEmailOrId('', $clientData['szLastUpdatedBy']);
                                                            echo $franchiseeDetArr['szName'];
                                                        } else {
                                                            echo "N.A";
                                                        }
                                                        ?>
                                                    </td>

                                                    <td>
                                                        <?php
                                                        if ($_SESSION['drugsafe_user']['iRole'] == '2') {
                                                            ?>
                                                            <?php
                                                            if ($clientData['clientType'] == '0') {
                                                                if ($clientData['szNoOfSites'] > count($childClientDetailsAray)) {
                                                                    ?>

                                                                    <a class="btn btn-circle btn-icon-only btn-default"
                                                                       id="userAdd"
                                                                       title="Add Site"
                                                                       onclick="addClientData(<?php echo $clientData['franchiseeId']; ?>,'<?php echo $clientData['id']; ?>','<?php echo __URL_FRANCHISEE_CLIENTRECORD__; ?>');"
                                                                       href="javascript:void(0);"></i>
                                                                        <i class="fa fa-plus" aria-hidden="true"></i>

                                                                    </a>
                                                                <?php }
                                                            }
                                                            ?>
                                                            <a class="btn btn-circle btn-icon-only btn-default"
                                                               title="Edit Client Data"
                                                               onclick="editClient('<?php echo $clientData['id']; ?>','<?php echo $clientData['franchiseeId']; ?>','<?php echo __URL_FRANCHISEE_CLIENTRECORD__; ?>','1');"
                                                               href="javascript:void(0);">
                                                                <i class="fa fa-pencil"></i>
                                                            </a>
                                                            <?php
                                                        } ?>
                                                        <a class="btn btn-circle btn-icon-only btn-default"
                                                           id="userStatus"
                                                           title="View Client Details"
                                                           onclick="viewClientDetails(<?php echo $clientData['id']; ?>,<?php echo $idfranchisee; ?>);"
                                                           href="javascript:void(0);"></i>
                                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                                        </a>
                                                        <?php
                                                        if ($_SESSION['drugsafe_user']['iRole'] == '2') {
                                                            ?>
                                                            <a class="btn btn-circle btn-icon-only btn-default"
                                                               id="userStatus"
                                                               title="Delete Client"
                                                               onclick="clientDelete('<?php echo $clientData['id']; ?>','<?php echo __URL_FRANCHISEE_CLIENTRECORD__; ?>');"
                                                               href="javascript:void(0);"></i>
                                                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                                                            </a>

                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                                <?php
                                                $i++;
                                            }
                                        }
                                        if(!empty($corpuserDetailsArr)) {
                                            $displyedClient = array();
                                            foreach ($corpuserDetailsArr as $CorpclientData) {
                                                if (!in_array($CorpclientData['id'], $displyedClient)){
                                                    array_push($displyedClient,$CorpclientData['id']);
                                                $franchiseecode = $this->Franchisee_Model->getusercodebyuserid($CorpclientData['id']);
                                                $showdata = true;
                                                if(isset($_POST['szSearchClRecord1']) && !empty($_POST['szSearchClRecord1'])){
                                                    $showdata = false;
                                                    if($_POST['szSearchClRecord1'] == $CorpclientData['szName']){
                                                        $showdata  = true;
                                                    }
                                                }
                                                if($showdata) {
                                                    ?>
                                                    <tr>
                                                        <td> <?php echo(!empty($franchiseecode['userCode']) ? $franchiseecode['userCode'] : 'N/A'); ?> </td>
                                                        <td> <?php echo(!empty($CorpclientData['szName']) ? $CorpclientData['szName'] : 'N/A'); ?> </td>
                                                        <td> <?php echo(!empty($CorpclientData['szName']) ? $CorpclientData['szName'] : 'N/A'); ?> </td>
                                                   
                                                        <?php
                                                        if ($_SESSION['drugsafe_user']['iRole'] == '1') {
                                                            ?>
                                                            <td>
                                                                <?php
                                                                $franchiseeDetArr = $this->Admin_Model->getAdminDetailsByEmailOrId('', $CorpclientData['franchiseeId']);
                                                                echo $franchiseeDetArr['szName'];
                                                                ?>
                                                            </td>
                                                            <?php
                                                        }
                                                        ?>

                                                        <td>
                                                            <?php
                                                            $childClientDetailsAray = $this->Franchisee_Model->viewChildClientDetails($CorpclientData['id']);
                                                            echo count($childClientDetailsAray);
                                                            ?>


                                                        </td>
                                                        <td> <?php echo(!empty($CorpclientData['szContactNumber']) ? $CorpclientData['szContactNumber'] : 'N/A'); ?> </td>

                                                        <td>
                                                            <?php
                                                            if ($CorpclientData['szCreatedBy']) {
                                                                $franchiseeDetArr = $this->Admin_Model->getAdminDetailsByEmailOrId('', $CorpclientData['szCreatedBy']);
                                                                echo $franchiseeDetArr['szName'];
                                                            }
                                                            ?>

                                                        </td>
                                                        <td>
                                                            <?php
                                                            if ($CorpclientData['szLastUpdatedBy']) {
                                                                $franchiseeDetArr = $this->Admin_Model->getAdminDetailsByEmailOrId('', $CorpclientData['szLastUpdatedBy']);
                                                                echo $franchiseeDetArr['szName'];
                                                            } else {
                                                                echo "N.A";
                                                            }
                                                            ?>
                                                        </td>

                                                        <td>

                                                            <a class="btn btn-circle btn-icon-only btn-default"
                                                               id="userStatus"
                                                               title="View Client Details"
                                                               onclick="viewClientDetails(<?php echo $CorpclientData['id']; ?>,<?php echo $idfranchisee; ?>,'1');"
                                                               href="javascript:void(0);"></i>
                                                                <i class="fa fa-eye" aria-hidden="true"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                    $i++;
                                                }
                                            }
                                            }
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php
                        } else {
                            echo "Not Found";
                        }
                    } else {
                       
                    ?>
                    <div class="row search">
                        <form class="form-horizontal search-bar" id="szSearchClientRecord"
                              action="<?= __BASE_URL__ ?>/franchisee/clientRecord" name="szSearchClientRecord"
                              method="post">

                            <div class=" col-md-3 clienttypeselect">
                                <div class="form-group <?php if (!empty($arErrorMessages['szSearchClRecord2']) != '') { ?>has-error<?php } ?>">
                                <select class="form-control custom-select" name="szSearchClRecord1"
                                        id="szSearchClientname"
                                        onfocus="remove_formError(this.id,'true')">
                                    <option value="">Client Name</option>
                                    <?php
                                    foreach ($clientlistArr as $clientIdList) {
                                        $franchiseecode = $this->Franchisee_Model->getusercodebyuserid($clientIdList['id']);
                                                $selected = ($clientIdList['id'] == $_POST['szSearchClRecord1'] ? 'selected="selected"' : '');
                                                echo '<option value="' . $clientIdList['id'] . '"' . $selected . ' >' .$franchiseecode['userCode'].'-'. $clientIdList['szName'] . '</option>';
                                    }
                                    ?>
                                </select>
                                </div>
                            </div>
                          <div class="col-md-3 ">
                                        <div class="form-group <?php if (!empty($arErrorMessages['szSearch4']) != '') { ?>has-error<?php } ?>">
                                            <div class="input-group input-medium date date-picker"
                                                 data-date-format="dd/mm/yyyy">

                                                <input type="text" id="szSearch4" class="form-control"
                                                       value="<?php echo set_value('szSearch4'); ?>" readonly
                                                       placeholder="Date From"
                                                       onfocus="remove_formError(this.id,'true')" name="szSearch4">
                                                <span class="input-group-addon">
                                               <i class="fa fa-calendar"></i>
                                               </span>
                                            </div>
                                            <!-- /input-group -->
                                            <?php
                                            if (form_error('szSearch4')) {
                                                ?>
                                                <span class="help-block pull-left">
                                                <span><?php echo form_error('szSearch4'); ?></span>
                                                </span><?php } ?>
                                            <?php if (!empty($arErrorMessages['szSearch4'])) { ?>
                                                <span class="help-block pull-left">
                                                <i class="fa fa-times-circle"></i>
                                                    <?php echo $arErrorMessages['szSearch4']; ?>
                                            </span>
                                            <?php } ?>
                                        </div>

                                    </div>
                                   <div class="col-md-3 ">
                                      <div
                                            class="form-group <?php if (!empty($arErrorMessages['szSearch5']) != '') { ?>has-error<?php } ?>">
                                            <div class="input-group input-medium date date-picker"
                                                 data-date-format="dd/mm/yyyy">

                                                <input type="text" id="szSearch5" class="form-control"
                                                       value="<?php echo set_value('szSearch5'); ?>" readonly
                                                       placeholder="Date To"
                                                       onfocus="remove_formError(this.id,'true')" name="szSearch5">
                                                <span class="input-group-addon">
                                               <i class="fa fa-calendar"></i>
                                               </span>
                                            </div>
                                            <!-- /input-group -->
                                            <?php
                                            if (form_error('szSearch5')) {
                                                ?>
                                                <span class="help-block pull-left">
                                                <span><?php echo form_error('szSearch5'); ?></span>
                                                </span><?php } ?>
                                            <?php if (!empty($arErrorMessages['szSearch5'])) { ?>
                                                <span class="help-block pull-left">
                                                <i class="fa fa-times-circle"></i>
                                                    <?php echo $arErrorMessages['szSearch5']; ?>
                                            </span>
                                            <?php } ?>
                                        </div> 
                                    </div>
                            <div class="col-md-1">
                                <button class="btn green-meadow" type="submit"><i class="fa fa-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>

 <?php if (!empty($clientAry) || !empty($corpuserDetailsArr)) {
                    ?>
                    <div id="page_content" class="row">
                        <div class="col-md-12">
                           
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                        <tr>
                                            <th> Client Code</th>
                                            <th> Name</th>
                                            <th> Email</th>
                                            <?php
                                            if ($_SESSION['drugsafe_user']['iRole'] == '1') {
                                                ?>
                                                <th> Franchisee</th>
                                            <?php } ?>

                                            <th> No of Sites</th>
                                            <th> Contact No</th>
                                            <th> Created By</th>
                                            <th> Updated By</th>
                                            <th> Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $i = 0;
                                        if (!empty($clientAry)){
                                            foreach ($clientAry as $clientData) {
                                                $franchiseecode = $this->Franchisee_Model->getusercodebyuserid($clientData['id']);
                                                $addEditClientDet = false;
                                                if ($clientData['szNoOfSites'] > 0) {
                                                    $addEditClientDet = true;
                                                }
                                                ?>
                                                <tr>
                                                    <td> <?php echo(!empty($franchiseecode['userCode']) ? $franchiseecode['userCode'] : 'N/A'); ?> </td>
                                                     <td> <?php echo(!empty($clientData['szName']) ? $clientData['szName'] : 'N/A'); ?> </td> 
                                                      <td> <?php echo(!empty($clientData['szEmail']) ? $clientData['szEmail'] : 'N/A'); ?> </td> 
                                                    <?php
                                                    if ($_SESSION['drugsafe_user']['iRole'] == '1') {
                                                        ?>
                                                        <td>
                                                            <?php
                                                            $franchiseeDetArr = $this->Admin_Model->getAdminDetailsByEmailOrId('', $clientData['franchiseeId']);
                                                            echo $franchiseeDetArr['szName'];
                                                            ?>
                                                        </td>
                                                    <?php } ?>
                                                    <td>
                                                        <?php
                                                        $childClientDetailsAray = $this->Franchisee_Model->viewChildClientDetails($clientData['id']);
                                                        echo count($childClientDetailsAray);
                                                        ?>


                                                    </td>
                                                     <td> <?php echo(!empty($clientData['szContactNumber']) ? $clientData['szContactNumber'] : 'N/A'); ?> </td>
                                                    <td>
                                                        <?php
                                                        if ($clientData['szCreatedBy']) {
                                                            $franchiseeDetArr = $this->Admin_Model->getAdminDetailsByEmailOrId('', $clientData['szCreatedBy']);
                                                            echo $franchiseeDetArr['szName'];
                                                        }
                                                        ?>

                                                    </td>
                                                    <td>
                                                        <?php
                                                        if ($clientData['szLastUpdatedBy']) {
                                                            $franchiseeDetArr = $this->Admin_Model->getAdminDetailsByEmailOrId('', $clientData['szLastUpdatedBy']);
                                                            echo $franchiseeDetArr['szName'];
                                                        }else{
                                                            echo "N.A";
                                                        }
                                                        ?>
                                                    </td>

                                                    <td>
                                                        <?php
                                                        if ($_SESSION['drugsafe_user']['iRole'] == '2') {
                                                            ?>
                                                            <?php
                                                            if ($clientData['clientType'] == '0') {
                                                                if (($clientData['szNoOfSites'] > count($childClientDetailsAray)) && $addEditClientDet) {
                                                                    ?>

                                                                    <a class="btn btn-circle btn-icon-only btn-default"
                                                                       id="userAdd"
                                                                       title="Add Site"
                                                                       onclick="addClientData(<?php echo $clientData['franchiseeId']; ?>,'<?php echo $clientData['id']; ?>','<?php echo __URL_FRANCHISEE_CLIENTRECORD__; ?>');"
                                                                       href="javascript:void(0);"></i>
                                                                        <i class="fa fa-plus"
                                                                           aria-hidden="true"></i>

                                                                    </a>
                                                                <?php }
                                                            }
                                                            if ($addEditClientDet) {
                                                                ?>

                                                                <a class="btn btn-circle btn-icon-only btn-default"
                                                                   title="Edit Client Data"
                                                                   onclick="editClient('<?php echo $clientData['id']; ?>','<?php echo $clientData['franchiseeId']; ?>','<?php echo __URL_FRANCHISEE_CLIENTRECORD__; ?>');"
                                                                   href="javascript:void(0);">
                                                                    <i class="fa fa-pencil"></i>
                                                                </a>
                                                            <?php }
                                                        } ?>
                                                        <a class="btn btn-circle btn-icon-only btn-default"
                                                           id="userStatus"
                                                           title="View Client Details"
                                                           onclick="viewClientDetails(<?php echo $clientData['id']; ?>,<?php echo $idfranchisee; ?>);"
                                                           href="javascript:void(0);"></i>
                                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                                        </a>
                                                        <?php
                                                        if ($_SESSION['drugsafe_user']['iRole'] == '2') {
                                                            if (empty($childClientDetailsAray)) {
                                                                ?>
                                                                <a class="btn btn-circle btn-icon-only btn-default"
                                                                   id="userStatus"
                                                                   title="Delete Client"
                                                                   onclick="clientDelete('<?php echo $clientData['id']; ?>','<?php echo __URL_FRANCHISEE_CLIENTRECORD__; ?>');"
                                                                   href="javascript:void(0);"></i>
                                                                    <i class="fa fa-trash-o"
                                                                       aria-hidden="true"></i>
                                                                </a>

                                                            <?php }
                                                        } ?>
                                                    </td>
                                                </tr>
                                                <?php
                                                $i++;
                                            }
                                        }
                                        if(!empty($corpuserDetailsArr)) {
                                            $displyedClient = array();
                                            foreach ($corpuserDetailsArr as $CorpclientData) {
                                                if (!in_array($CorpclientData['id'], $displyedClient)){
                                                    array_push($displyedClient,$CorpclientData['id']);
                                                    $franchiseecode = $this->Franchisee_Model->getusercodebyuserid($CorpclientData['id']);
                                                ?>
                                                <tr>
                                                    <td> <?php echo(!empty($franchiseecode['userCode']) ? $franchiseecode['userCode'] : 'N/A'); ?> </td>
                                                    <td> <?php echo $CorpclientData['szName']; ?> </td>
                                                    <td> <?php echo $CorpclientData['szEmail']; ?> </td>
                                                    <?php
                                                    if ($_SESSION['drugsafe_user']['iRole'] == '1') {
                                                        ?>
                                                        <td>
                                                            <?php
                                                            $franchiseeDetArr = $this->Admin_Model->getAdminDetailsByEmailOrId('', $CorpclientData['franchiseeId']);
                                                            echo $franchiseeDetArr['szName'];
                                                            ?>
                                                        </td>
                                                        <?php
                                                    }
                                                    ?>

                                                    <td>
                                                        <?php
                                                        $childClientDetailsAray = $this->Franchisee_Model->viewChildClientDetails($CorpclientData['id']);
                                                        echo count($childClientDetailsAray);
                                                        ?>


                                                    </td>
                                                    <td> <?php echo $CorpclientData['szContactNumber']; ?> </td>

                                                    <td>
                                                        <?php
                                                        if ($CorpclientData['szCreatedBy']) {
                                                            $franchiseeDetArr = $this->Admin_Model->getAdminDetailsByEmailOrId('', $CorpclientData['szCreatedBy']);
                                                            echo $franchiseeDetArr['szName'];
                                                        }
                                                        ?>

                                                    </td>
                                                    <td>
                                                        <?php
                                                        if ($CorpclientData['szLastUpdatedBy']) {
                                                            $franchiseeDetArr = $this->Admin_Model->getAdminDetailsByEmailOrId('', $CorpclientData['szLastUpdatedBy']);
                                                            echo $franchiseeDetArr['szName'];
                                                        } else {
                                                            echo "N.A";
                                                        }
                                                        ?>
                                                    </td>

                                                    <td>

                                                        <a class="btn btn-circle btn-icon-only btn-default"
                                                           id="userStatus"
                                                           title="View Client Details"
                                                           onclick="viewClientDetails(<?php echo $CorpclientData['id']; ?>,<?php echo $idfranchisee; ?>,'1');"
                                                           href="javascript:void(0);"></i>
                                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <?php
                                                $i++;
                                            }
                                            }
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                          
                            <?php
                        } else {
                            echo "Not Found";
                        }
                        ?>
                        </div>
                        </div>
                        <div id="popup_box"></div>
                    <?php } ?>
                    <div class="row">
                        <?php if (!empty($clientAry)) { ?>
                            <div class="col-md-7 col-sm-7">
                                <div class="dataTables_paginate paging_bootstrap_full_number">
                                    <?php echo $this->pagination->create_links(); ?>
                                </div>
                            </div>

                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<div id="popup_box"></div>