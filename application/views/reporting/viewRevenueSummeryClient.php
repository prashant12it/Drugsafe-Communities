<script type='text/javascript'>
    $(function () {
        $("#szSearchname").customselect();
        $("#szSearchClientname").customselect();
    });
</script>
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
                        <span class="active">Revenue Summary Client</span>
                    </li>
                </ul>

                <div class="portlet light bordered about-text" id="user_info">

                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-equalizer font-red-sunglo"></i>
                            <span class="caption-subject font-red-sunglo bold uppercase">
                                    Revenue Summary Client
                                </span>
                        </div>
                        <?php if(!empty($getManualCalcStartToEndDate)){?>
                            <div class="actions">

                                <a onclick="ViewpdfRevenueSummeryClient('<?php echo $_POST['szSearchClRecord2'];?>','<?php echo $_POST['szSearchClRecord1'];?>','<?php echo $_POST['dtStart'];?>','<?php echo $_POST['dtEnd'];?>')" href="javascript:void(0);" class=" btn green-meadow">
                                    <i class="fa fa-file-pdf-o"></i> View Pdf </a>

                                <a onclick="ViewexcelRevenueSummeryClient('<?php echo $_POST['szSearchClRecord2'];?>','<?php echo $_POST['szSearchClRecord1'];?>','<?php echo $_POST['dtStart'];?>','<?php echo $_POST['dtEnd'];?>')" href="javascript:void(0);" class=" btn green-meadow">
                                    <i class="fa fa-file-excel-o"></i> View Xls </a>

                            </div>
                        <?php }elseif(!empty($allfranchisee)){?>
                        <div class="actions">

                            <a onclick="ViewpdfRevenueSummeryClient('<?php echo (!empty($_POST['szSearchClRecord2'])?$_POST['szSearchClRecord2']:"");?>','0','<?php echo (!empty($_POST['dtStart'])?$_POST['dtStart']:'');?>','<?php echo (!empty($_POST['dtEnd'])?$_POST['dtEnd']:'');?>','1')" href="javascript:void(0);" class=" btn green-meadow">
                                <i class="fa fa-file-pdf-o"></i> View Pdf </a>

                            <a onclick="ViewexcelRevenueSummeryClient('<?php echo (!empty($_POST['szSearchClRecord2'])?$_POST['szSearchClRecord2']:"");?>','0','<?php echo (!empty($_POST['dtStart'])?$_POST['dtStart']:'');?>','<?php echo (!empty($_POST['dtEnd'])?$_POST['dtEnd']:'');?>','1')" href="javascript:void(0);" class=" btn green-meadow">
                                <i class="fa fa-file-excel-o"></i> View Xls </a>

                        </div>

                       <?php } ?>
                    </div>
                    <div class="portlet-body totalpr alert">
                         <div class="row">
                            <form name="revenueSearchForm" id="revenueSearchForm" class="search-bar"
                                  action="<?= __BASE_URL__ ?>/reporting/view_revenue_summery_client" method="post">
                                 <?php if(($_SESSION['drugsafe_user']['iRole']==1)||($_SESSION['drugsafe_user']['iRole']==5 )){ ?>
                                  <div class="row">
                                <div class=" col-md-3 clienttypeselect">
                             <div class="form-group <?php if (!empty($arErrorMessages['szSearchClRecord2']) != '') { ?>has-error<?php } ?>"> 
                                    <select class="form-control custom-select" name="szSearchClRecord2"
                                            id="szSearchname" onblur="remove_formError(this.id,'true')"
                                            onchange="getClientCodeListByFrId(this.value);">
                                        <option value="">Franchisee Name</option>

                                        <?php if($_SESSION['drugsafe_user']['iRole']==1 ){
                                       $searchOptionArr =$this->Admin_Model->viewFranchiseeList(false,false,false,false,false,false,false,false,1); 
                                   }
                                   if($_SESSION['drugsafe_user']['iRole']==5 ){
                                       $searchOptionArr =$this->Admin_Model->viewFranchiseeList(false,$_SESSION['drugsafe_user']['id'],false,false,false,false,false,false,1); 
                                   }
                                       ?>   
                                       <?php
                                        foreach ($searchOptionArr as $searchOptionList) {
                                            $selected = ($searchOptionList['id'] == $_POST['szSearchClRecord2'] ? 'selected="selected"' : '');
                                            echo '<option value="' . $searchOptionList['id'] . '"' . $selected . ' >'.$searchOptionList['userCode'].'-'.$searchOptionList['szName'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                  <?php
                                            if (form_error('szSearchClRecord2')) {
                                                ?>
                                                <span class="help-block pull-left">
                                                <span><?php echo form_error('szSearchClRecord2'); ?></span>
                                                </span><?php } ?>
                                  </div>
                                </div>
                             
                              
                                     <div class=" col-md-3 clienttypeselect">
                               
                                    <div id='szClient'>
                                         <div class="form-group <?php if (!empty($arErrorMessages['szSearchClRecord2']) != '') { ?>has-error<?php } ?>"> 
                                        <select class="form-control custom-select" name="szSearchClRecord1"
                                                id="szSearchClientname" onfocus="remove_formError(this.id,'true')">
                                            <option value="">Client Name</option>
                                            <?php
                                            foreach ($clientlistArr as $clientList) {
                                                $selected = ($clientList['id'] == $_POST['szSearchClRecord1'] ? 'selected="selected"' : '');
                                                echo '<option value="' . $clientList['id'] . '"' . $selected . ' >'.$clientList['userCode']."-" .$clientList['szName'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                     </div>
                                         </div>
                                </div>
                                    <div class="col-md-3">
                                        <div class="form-group <?php if (!empty($arErrorMessages['dtStart']) != '') { ?>has-error<?php } ?>">
                                            <div class="input-group input-medium date date-picker"
                                                 data-date-format="dd/mm/yyyy">

                                                <input type="text" id="dtStart" class="form-control"
                                                       value="<?php echo set_value('dtStart'); ?>" readonly
                                                       placeholder="Start Revenue Date"
                                                       onfocus="remove_formError(this.id,'true')" name="dtStart">
                                                <span class="input-group-addon">
                                               <i class="fa fa-calendar"></i>
                                               </span>
                                            </div>
                                            <!-- /input-group -->
                                            <?php
                                            if (form_error('dtStart')) {
                                                ?>
                                                <span class="help-block pull-left">
                                                <span><?php echo form_error('dtStart'); ?></span>
                                                </span><?php } ?>
                                           
                                        </div>

                                    </div>
                                 </div>
                                    <div class="row">   
                                    <div class=" col-md-3">
                                        <div
                                            class="form-group <?php if (!empty($arErrorMessages['dtEnd']) != '') { ?>has-error<?php } ?>">
                                            <div class="input-group input-medium date date-picker"
                                                 data-date-format="dd/mm/yyyy">

                                                <input type="text" id="szSearch5" class="form-control"
                                                       value="<?php echo set_value('dtEnd'); ?>" readonly
                                                       placeholder="End Revenue Date"
                                                       onfocus="remove_formError(this.id,'true')" name="dtEnd">
                                                <span class="input-group-addon">
                                               <i class="fa fa-calendar"></i>
                                               </span>
                                            </div>
                                            <!-- /input-group -->
                                            <?php
                                            if (form_error('dtEnd')) {
                                                ?>
                                                <span class="help-block pull-left">
                                                <span><?php echo form_error('dtEnd'); ?></span>
                                                </span><?php } ?>
                                           
                                        </div>
                                    </div>
                                        
                                     <div class="col-md-1">
                                        <div class="form-group">
                                            <button class="btn green-meadow" type="submit"><i
                                                    class="fa fa-search"></i> 
                                            </button>
                                            &nbsp;
                                        </div>
                                    </div>
                                        </div>
                                  <?php } if($_SESSION['drugsafe_user']['iRole']==2) { ?>
                                   <div class=" col-md-3">
                               
                                    <div id='szClient'>
                                        <select class="form-control custom-select" name="szSearchClRecord1"
                                                id="szSearchClientname" onfocus="remove_formError(this.id,'true')">
                                            <option value="">Client Name</option>
                                            <?php
                                            foreach ($clientlistArr as $clientList) {
                                                $selected = ($clientList['id'] == $_POST['szSearchClRecord1'] ? 'selected="selected"' : '');
                                                echo '<option value="' . $clientList['id'] . '"' . $selected . ' >'.$clientList['userCode']."-" .$clientList['szName'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                    <div class="col-md-3">
                                        <div class="form-group <?php if (!empty($arErrorMessages['dtStart']) != '') { ?>has-error<?php } ?>">
                                            <div class="input-group input-medium date date-picker"
                                                 data-date-format="dd/mm/yyyy">

                                                <input type="text" id="dtStart" class="form-control"
                                                       value="<?php echo set_value('dtStart'); ?>" readonly
                                                       placeholder="Start Revenue Date"
                                                       onfocus="remove_formError(this.id,'true')" name="dtStart">
                                                <span class="input-group-addon">
                                               <i class="fa fa-calendar"></i>
                                               </span>
                                            </div>
                                            <!-- /input-group -->
                                            <?php
                                            if (form_error('dtStart')) {
                                                ?>
                                                <span class="help-block pull-left">
                                                <span><?php echo form_error('dtStart'); ?></span>
                                                </span><?php } ?>
                                           
                                        </div>
                                    </div>
                                 <div class="col-md-3">
                                        <div
                                            class="form-group <?php if (!empty($arErrorMessages['dtEnd']) != '') { ?>has-error<?php } ?>">
                                            <div class="input-group input-medium date date-picker"
                                                 data-date-format="dd/mm/yyyy">

                                                <input type="text" id="szSearch5" class="form-control"
                                                       value="<?php echo set_value('dtEnd'); ?>" readonly
                                                       placeholder="End Revenue Date"
                                                       onfocus="remove_formError(this.id,'true')" name="dtEnd">
                                                <span class="input-group-addon">
                                               <i class="fa fa-calendar"></i>
                                               </span>
                                            </div>
                                            <!-- /input-group -->
                                            <?php
                                            if (form_error('dtEnd')) {
                                                ?>
                                                <span class="help-block pull-left">
                                                <span><?php echo form_error('dtEnd'); ?></span>
                                                </span><?php } ?>
                                           
                                        </div>
                                    </div>
                                     <div class="col-md-1">
                                        <div class="form-group">
                                            <button class="btn green-meadow" type="submit"><i
                                                    class="fa fa-search"></i> 
                                            </button>
                                            &nbsp;
                                        </div>
                                    </div>
                                   <?php } ?>   
                             </form>
                       </div>
                    </div>
                    <?php
                    $fromEndDate = form_error('dtEnd');
                    if(($_POST['dtStart']!='') && ($_POST['dtEnd']!='') && ($onlyfranchisee>0) && (empty($fromEndDate)))
                    {
                    if (!empty($getManualCalcStartToEndDate)) {
                        
                      
                    ?>
                    <div class="portlet-body alert">
                        <div class="row">
                            <div>
                                <div class="portlet green-meadow box">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="fa fa-users"></i>Revenue Summary Client

                                        </div>

                                    </div>
                                </div> 
                                <div class="portlet-body">
                                        <div class="table-responsive">
                                            <table class="table table-hover table-bordered table-striped">
                                                <thead>
                                                <tr>
                                                    <th>
                                                        #
                                                    </th>
                                                    <?php if(($_SESSION['drugsafe_user']['iRole']==1)||($_SESSION['drugsafe_user']['iRole']==5)) { ?>
                                                    <th>
                                                        Franchisee Name 
                                                    </th>
                                                   <?php } ?>
                                                    <th>
                                                        Client Name 
                                                    </th>
                                                    <th>
                                                        Client Code 
                                                    </th>
                                                    <th> Proforma Invoice Date</th>
                                                    <th>
                                                        Revenue EXL GST
                                                    </th>
                                                    <th>
                                                        Royalty Fees
                                                    </th>
                                                    <th>
                                                        Net  Revenue EXL GST
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php
												
						$i = 0;
                                                $totalRevenu='';
                                                $totalRoyaltyfees='';
                                                $totalNetProfit='';
						  foreach ($getManualCalcStartToEndDate as $getManualCalcData) {
														
                                                
                              $getClientId=$this->Form_Management_Model->getSosDetailBySosId($getManualCalcData['sosid']);
                              $getClientDetails=$this->Admin_Model->getAdminDetailsByEmailOrId('',$getClientId['Clientid']);
                              $franchiseecode = $this->Franchisee_Model->getusercodebyuserid($getClientDetails['id']);
                          
                              $ClirntDetailsDataAry = $this->Franchisee_Model->getParentClientDetailsId($getClientId['Clientid']);
                              $userDataAry = $this->Admin_Model->getUserDetailsByEmailOrId('', $ClirntDetailsDataAry['clientType']);
                              $discount = $this->Ordering_Model->getClientDiscountByClientId($ClirntDetailsDataAry['clientType']);
                              $data = $this->Ordering_Model->getManualCalculationBySosId($getManualCalcData['sosid']);
                              $frDataAry = $this->Admin_Model->getUserDetailsByEmailOrId('', $getManualCalcData['franchiseeId']);
                              $DrugtestidArr = array_map('intval', str_split($getClientId['Drugtestid']));
                                                      if (in_array(1, $DrugtestidArr) || in_array(2, $DrugtestidArr) || in_array(3, $DrugtestidArr) || in_array(4, $DrugtestidArr)) {
                                                          $countDoner = count($this->Form_Management_Model->getDonarDetailBySosId($getManualCalcData['sosid']));
                                                      }
                                                      $ValTotal = 0;
                                                      if (in_array(1, $DrugtestidArr)) {
                                                          $ValTotal = number_format($ValTotal + $countDoner * __RRP_1__, 2, '.', '');
                                                      }
                                                      if (in_array(2, $DrugtestidArr)) {
                                                          $ValTotal = number_format($ValTotal + $countDoner * __RRP_2__, 2, '.', '');
                                                      }
                                                      if (in_array(3, $DrugtestidArr)) {
                                                          $ValTotal = number_format($ValTotal + $countDoner * __RRP_3__, 2, '.', '');
                                                      }
                                                      if (in_array(4, $DrugtestidArr)) {
                                                          $ValTotal = number_format($ValTotal + $countDoner * __RRP_4__, 2, '.', '');
                                                      }
                              $GST = $ValTotal * 0.1;
                              $GST = number_format($GST, 2, '.', '');
                              $TotalbeforeRoyalty = $ValTotal + $GST;
                              $TotalbeforeRoyalty = number_format($TotalbeforeRoyalty, 2, '.', '');
                              $DcmobileScreen = $data['mobileScreenBasePrice'] * ($data['mobileScreenHr']>1?$data['mobileScreenHr']:1);
                              $mobileScreen = $data['mcbp'] * ($data['mchr']>1?$data['mchr']:1);
                              $calloutprice = $data['cobp'] * ($data['cohr']>3?$data['cohr']:3);
                              $fcoprice = $data['fcobp'] * ($data['fcohr']>2?$data['fcohr']:2);
                              $travel = $data['travelBasePrice'] * ($data['travelHr']>1?$data['travelHr']:1);
                              $TotalTrevenu = $data['urineNata'] + $data['labconf']+$data['cancelfee']+ $data['nataLabCnfrm'] + $data['oralFluidNata'] + $data['SyntheticCannabinoids'] + $data['labScrenning'] + $data['RtwScrenning'] + $mobileScreen + $DcmobileScreen+ $travel + $calloutprice + $fcoprice;
                              $TotalTrevenu = number_format($TotalTrevenu, 2, '.', '');
                              $GSTmanual = ($TotalTrevenu * 0.1);
                              $GSTmanual = number_format($GSTmanual, 2, '.', '');
                              $Total1 = $TotalTrevenu + $GSTmanual;
                              $Total1 = number_format($Total1, 2, '.', '');
                              $totalinvoiceAmt = $ValTotal + $TotalTrevenu;
                              if(!empty($discount)){
                                  $discountpercent = $discount['percentage'];
                              }else{
                                  $discountpercent = 0;
                              }
                              if($discountpercent>0){
                                  $totaldiscount = $totalinvoiceAmt*$discountpercent*0.01;
                                  $totalafterdiscount = $totalinvoiceAmt-$totaldiscount;
                                  $totalGst = $totalafterdiscount*0.1;
                                  $totalRoyaltyBefore = $totalGst + $totalafterdiscount;
                              }else{
                                  $totalGst = $GST + $GSTmanual;
                                  $totalRoyaltyBefore = $Total1 + $TotalbeforeRoyalty;
                                  $totaldiscount = 0;
                                  $totalafterdiscount = 0;
                              }
                              $Royaltyfees = ($discountpercent>0?number_format($totalafterdiscount, 2, '.', ''):number_format($totalinvoiceAmt, 2, '.', ''))*0.1;
                              $Royaltyfees = number_format($Royaltyfees, 2, '.', '');
                              $NetTotal = ($discountpercent>0?number_format($totalafterdiscount, 2, '.', ''):number_format($totalinvoiceAmt, 2, '.', '')) - $Royaltyfees;
                              $NetTotal = number_format($NetTotal, 2, '.', '');
                              $totalRevenu=$totalRevenu+($discountpercent>0?number_format($totalafterdiscount, 2, '.', ''):number_format($totalinvoiceAmt, 2, '.', ''));
                              $totalRoyaltyfees=$totalRoyaltyfees+$Royaltyfees;
                              $totalNetProfit=$totalNetProfit+$NetTotal;
                                                    $i++;
                                                    ?>
                                                    <tr>
                                                        <td> <?php echo $i;?></td>
                                                         <?php if(($_SESSION['drugsafe_user']['iRole']==1)||($_SESSION['drugsafe_user']['iRole']==5)) {?>
                                                        <td>
                                                         <?php echo $frDataAry['szName'];?>
                                                        </td>
                                                          <?php } ?>
                                                         <td>
                                                         <?php echo $userDataAry['szName'];?>
                                                        </td>
                                                        <td>
                                                         <?php echo $userDataAry['userCode'];?>
                                                        </td>
                                                        <td><?php echo ((!empty($getManualCalcData['dtCreatedOn']) && $getManualCalcData['dtCreatedOn'] != '0000-00-00') ?date('d/m/Y',strtotime($getManualCalcData['dtCreatedOn'])):'N/A');?> </td>
                                                        <td>
                                                         $<?php  echo ($discountpercent>0?number_format($totalafterdiscount, 2, '.', ','):number_format($totalinvoiceAmt, 2, '.', ',')); ?>
                                                        </td>
                                                        <td>
                                                            $<?php echo number_format($Royaltyfees, 2, '.', ',');?>
                                                        </td>
                                                        <td>
                                                            $<?php echo number_format($NetTotal, 2, '.', ',');?>
                                                        </td>
                                                       
                                                 </tr>
                                                
                                                  <?php 
											   }
                                                ?>											   
                                                  <tr>
                                                   <td></td>
                                                    <td></td>
                                                   <?php if(($_SESSION['drugsafe_user']['iRole']==1)||($_SESSION['drugsafe_user']['iRole']==5)) {?>
                                                    <td></td>
                                                   <?php } ?>
                                                     <td></td>
                                                     <td><b>Total</b></td>
                                                      <td>
                                                          $<?php
                                                          $totalRevenu = number_format($totalRevenu, 2, '.', '');
                                                          echo number_format($totalRevenu, 2, '.', ',');?>
                                                      </td>
                                                      <td>
                                                          $<?php
                                                          $totalRoyaltyfees = number_format($totalRoyaltyfees, 2, '.', '');
                                                          echo number_format($totalRoyaltyfees, 2, '.', ',');?>
                                                      </td>
                                                      <td>
                                                          $<?php
                                                          $totalNetProfit = number_format($totalNetProfit, 2, '.', '');
                                                          echo number_format($totalNetProfit, 2, '.', ',');?>
                                                      </td>
                                                 </tr>
                                                  
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
                <?php }
                else
                {
                    echo "<h4>No record found</h4>";
                }
                    }elseif(!empty($allfranchisee)){?>
                    <div class="portlet-body alert">
                        <div class="row">
                            <div>
                                <div class="portlet green-meadow box">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="fa fa-users"></i>Revenue Summary Client

                                        </div>

                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-bordered table-striped">
                                            <thead>
                                            <tr>
                                                <th>
                                                    #
                                                </th>
                                                <?php if(($_SESSION['drugsafe_user']['iRole']==1)||($_SESSION['drugsafe_user']['iRole']==5)) { ?>
                                                    <th>
                                                        Franchisee Name
                                                    </th>
                                                <?php } ?>
                                                <th>
                                                    Client Name
                                                </th>
                                                <th>
                                                    Client Code
                                                </th>
                                                <th>
                                                   Proforma Invoice Date 
                                                </th>
                                                <th>
                                                    Revenue EXL GST
                                                </th>
                                                <th>
                                                    Royalty Fees
                                                </th>
                                                <th>
                                                    Net  Revenue EXL GST
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $allfranchiseeTotalAfterDis='';
                                            $allfranchiseetotalRoyaltyfees='';
                                            $allfranchiseetotalNetProfit='';
                                            $frDataAry = array();
                                            $userDataAry = array();
                                            $i = 1;
                                            foreach($allfranchisee as $allfranchiseeData)
                                            {
                                               
                                                $clientArr = $this->Webservices_Model->getclientdetails($allfranchiseeData['franchiseeId']);
                                                if(!empty($clientArr)) {
                                                    foreach ($clientArr as $clientData) {
                                                        $getManualCalcStartToEndDate = $this->Reporting_Model->getAllRevenueManualalc(array(), $allfranchiseeData['franchiseeId'], $clientData['id']);
                                                        if (!empty($getManualCalcStartToEndDate)){
                                                            $totalRevenu = '';
                                                        $totalRoyaltyfees = '';
                                                        $totalNetProfit = '';
                                                        foreach ($getManualCalcStartToEndDate as $getManualCalcData) {
                                                            $getClientId = $this->Form_Management_Model->getSosDetailBySosId($getManualCalcData['sosid']);
                                                            $getClientDetails = $this->Admin_Model->getAdminDetailsByEmailOrId('', $getClientId['Clientid']);
                                                            $franchiseecode = $this->Franchisee_Model->getusercodebyuserid($getClientDetails['id']);
                                                            $ClirntDetailsDataAry = $this->Franchisee_Model->getParentClientDetailsId($getClientId['Clientid']);
                                                            $userDataAry = $this->Admin_Model->getUserDetailsByEmailOrId('', $ClirntDetailsDataAry['clientType']);
                                                            $discount = $this->Ordering_Model->getClientDiscountByClientId($ClirntDetailsDataAry['clientType']);
                                                            $data = $this->Ordering_Model->getManualCalculationBySosId($getManualCalcData['sosid']);
                                                            $frDataAry = $this->Admin_Model->getUserDetailsByEmailOrId('', $getManualCalcData['franchiseeId']);
                                                            $DrugtestidArr = array_map('intval', str_split($getClientId['Drugtestid']));
                                                            if (in_array(1, $DrugtestidArr) || in_array(2, $DrugtestidArr) || in_array(3, $DrugtestidArr) || in_array(4, $DrugtestidArr)) {
                                                                $countDoner = count($this->Form_Management_Model->getDonarDetailBySosId($getManualCalcData['sosid']));
                                                            }
                                                            $ValTotal = 0;
                                                            if (in_array(1, $DrugtestidArr)) {
                                                                $ValTotal = number_format($ValTotal + $countDoner * __RRP_1__, 2, '.', '');
                                                            }
                                                            if (in_array(2, $DrugtestidArr)) {
                                                                $ValTotal = number_format($ValTotal + $countDoner * __RRP_2__, 2, '.', '');
                                                            }
                                                            if (in_array(3, $DrugtestidArr)) {
                                                                $ValTotal = number_format($ValTotal + $countDoner * __RRP_3__, 2, '.', '');
                                                            }
                                                            if (in_array(4, $DrugtestidArr)) {
                                                                $ValTotal = number_format($ValTotal + $countDoner * __RRP_4__, 2, '.', '');
                                                            }
                                                            $GST = $ValTotal * 0.1;
                                                            $GST = number_format($GST, 2, '.', '');
                                                            $TotalbeforeRoyalty = $ValTotal + $GST;
                                                            $TotalbeforeRoyalty = number_format($TotalbeforeRoyalty, 2, '.', '');
                                                            $DcmobileScreen = $data['mobileScreenBasePrice'] * ($data['mobileScreenHr'] > 1 ? $data['mobileScreenHr'] : 1);
                                                            $mobileScreen = $data['mcbp'] * ($data['mchr'] > 1 ? $data['mchr'] : 1);
                                                            $calloutprice = $data['cobp'] * ($data['cohr'] > 3 ? $data['cohr'] : 3);
                                                            $fcoprice = $data['fcobp'] * ($data['fcohr'] > 2 ? $data['fcohr'] : 2);
                                                            $travel = $data['travelBasePrice'] * ($data['travelHr'] > 1 ? $data['travelHr'] : 1);
                                                            $TotalTrevenu = $data['urineNata'] + $data['labconf'] + $data['cancelfee'] + $data['nataLabCnfrm'] + $data['oralFluidNata'] + $data['SyntheticCannabinoids'] + $data['labScrenning'] + $data['RtwScrenning'] + $mobileScreen + $DcmobileScreen + $travel + $calloutprice + $fcoprice;
                                                            $TotalTrevenu = number_format($TotalTrevenu, 2, '.', '');
                                                            $GSTmanual = ($TotalTrevenu * 0.1);
                                                            $GSTmanual = number_format($GSTmanual, 2, '.', '');
                                                            $Total1 = $TotalTrevenu + $GSTmanual;
                                                            $Total1 = number_format($Total1, 2, '.', '');
                                                            $totalinvoiceAmt = $ValTotal + $TotalTrevenu;
                                                            if (!empty($discount)) {
                                                                $discountpercent = $discount['percentage'];
                                                            } else {
                                                                $discountpercent = 0;
                                                            }
                                                            if ($discountpercent > 0) {
                                                                $totaldiscount = $totalinvoiceAmt * $discountpercent * 0.01;
                                                                $totalafterdiscount = $totalinvoiceAmt - $totaldiscount;
                                                                $totalGst = $totalafterdiscount * 0.1;
                                                                $totalRoyaltyBefore = $totalGst + $totalafterdiscount;
                                                            } else {
                                                                $totalGst = $GST + $GSTmanual;
                                                                $totalRoyaltyBefore = $Total1 + $TotalbeforeRoyalty;
                                                                $totaldiscount = 0;
                                                                $totalafterdiscount = 0;
                                                            }
                                                            $Royaltyfees = ($discountpercent > 0 ? number_format($totalafterdiscount, 2, '.', '') : number_format($totalinvoiceAmt, 2, '.', '')) * 0.1;
                                                            $Royaltyfees = number_format($Royaltyfees, 2, '.', '');
                                                            $NetTotal = ($discountpercent > 0 ? number_format($totalafterdiscount, 2, '.', '') : number_format($totalinvoiceAmt, 2, '.', '')) - $Royaltyfees;
                                                            $NetTotal = number_format($NetTotal, 2, '.', '');
                                                            $totalRevenu = $totalRevenu + ($discountpercent > 0 ? number_format($totalafterdiscount, 2, '.', '') : number_format($totalinvoiceAmt, 2, '.', ''));
                                                            $totalRoyaltyfees = $totalRoyaltyfees + $Royaltyfees;
                                                            $totalNetProfit = $totalNetProfit + $NetTotal;
                                                            ?>

                                                            <?php
                                                        }
                                                        ?>
                                                        <tr>
                                                            <td> <?php echo $i; ?></td>
                                                            <?php if (($_SESSION['drugsafe_user']['iRole'] == 1) || ($_SESSION['drugsafe_user']['iRole'] == 5)) { ?>
                                                                <td>
                                                                    <?php echo $frDataAry['szName']; ?>
                                                                </td>
                                                            <?php } ?>
                                                            <td>
                                                                <?php echo $userDataAry['szName']; ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $userDataAry['userCode']; ?>
                                                            </td>
                                                            <td>
                                                                <?php echo date('d M Y',strtotime($getManualCalcData['dtCreatedOn'])) . ' at '.date('h:i A',strtotime($getManualCalcData['dtCreatedOn']));?>
                                                            </td>
                                                            <td>
                                                                $<?php
                                                                $totalRevenu = number_format($totalRevenu, 2, '.', '');
                                                                echo number_format($totalRevenu, 2, '.', ','); ?>
                                                            </td>
                                                            <td>
                                                                $<?php
                                                                $totalRoyaltyfees = number_format($totalRoyaltyfees, 2, '.', '');
                                                                echo number_format($totalRoyaltyfees, 2, '.', ','); ?>
                                                            </td>
                                                            <td>
                                                                $<?php
                                                                $totalNetProfit = number_format($totalNetProfit, 2, '.', '');
                                                                echo number_format($totalNetProfit, 2, '.', ','); ?>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                        $allfranchiseeTotalAfterDis += $totalRevenu;
                                                        $allfranchiseetotalRoyaltyfees += $totalRoyaltyfees;
                                                        $allfranchiseetotalNetProfit += $totalNetProfit;
                                                        $i++;
                                                    }
                                                }
                                                }
                                            }
                                            ?>
                                            <tr>
                                                <?php if(($_SESSION['drugsafe_user']['iRole']==1)||($_SESSION['drugsafe_user']['iRole']==5)) {?>
                                                    <td colspan="4"></td>
                                                <?php }else{ ?>
                                                <td colspan="3"></td>
                                                <?php } ?>
                                                <td>
                                                    <b>Total</b>
                                                </td>
                                                <td>
                                                    $<?php
                                                    echo number_format($allfranchiseeTotalAfterDis, 2, '.', ',');?>
                                                </td>
                                                <td>
                                                    $<?php
                                                    echo number_format($allfranchiseetotalRoyaltyfees, 2, '.', ',');?>
                                                </td>
                                                <td>
                                                    $<?php
                                                    echo number_format($allfranchiseetotalNetProfit, 2, '.', ',');?>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
            </div>
                <?php }
                ?>

            </div>

        </div>

    </div>

</div>
</div>
</div>
</div>
</div>
<div id="popup_box"></div>