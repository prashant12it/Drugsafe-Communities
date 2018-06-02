<script type='text/javascript'>
    $(function() {
 $("#szFranchisee").customselect();
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

                    <li>
                        <a href="<?php echo __BASE_URL__; ?>">Home</a>
                        <i class="fa fa-circle"></i>
                    </li>

                    <li>
                        <span class="active">Revenue Generate</span>
                    </li>
                </ul>

                <div class="portlet light bordered about-text" id="user_info">

                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-equalizer font-red-sunglo"></i>
                            <span class="caption-subject font-red-sunglo bold uppercase">
                                    Revenue Generate
                                </span>
                        </div>
                        <?php if(!empty($getManualCalcStartToEndDate)){?>
                            <div class="actions">
                                <a onclick="revenueGenerateChart('<?php echo $_POST['dtStart'];?>','<?php echo $_POST['dtEnd'];?>','<?php echo $_POST['szFranchisee'];?>')"
                                   href="javascript:void(0);" class=" btn green-meadow">
                                    <i class="fa fa-bar-chart"></i> View Chart </a>
                                <a onclick="ViewpdfRevenueGenerate('<?php echo $_POST['dtStart'];?>','<?php echo $_POST['dtEnd'];?>','<?php echo $_POST['szFranchisee'];?>')" href="javascript:void(0);" class=" btn green-meadow">
                                    <i class="fa fa-file-pdf-o"></i> View Pdf </a>

                                <a onclick="ViewexcelRevenueGenerate('<?php echo $_POST['dtStart'];?>','<?php echo $_POST['dtEnd'];?>','<?php echo $_POST['szFranchisee'];?>')" href="javascript:void(0);" class=" btn green-meadow">
                                    <i class="fa fa-file-excel-o"></i> View Xls </a>

                            </div>
                        <?php } ?>
                    </div>
                    <div class="portlet-body totalpr alert">
                        <div class="row">
                            <form name="revenueSearchForm" id="revenueSearchForm" class="search-bar"
                                  action="<?= __BASE_URL__ ?>/reporting/view_revenue_generate" method="post">
                                <div class="row">
                                    <div class="search col-md-3 clienttypeselect">
                                     <div class="form-group <?php if (!empty($arErrorMessages['szFranchisee']) != '') { ?>has-error<?php } ?>">
                                      <select class="form-control custom-select" name="szFranchisee" id="szFranchisee" onfocus="remove_formError(this.id,'true')">
                                          <option value="">Franchisee Name</option>
                                          <?php
                                            if(!empty($allfranchisee))
                                            {
                                                foreach($allfranchisee as $franchiseeIdList)
                                                {
                                                    $selected = ($franchiseeIdList['id'] == $_POST['szFranchisee'] ? 'selected="selected"' : '');
                                                    echo '<option value="'.$franchiseeIdList['id'].'"' . $selected . ' >' .$franchiseeIdList['userCode'].'-'.$franchiseeIdList['szName'].'</option>';
                                                } 
                                            }
                                          
                                          ?>
                                      </select>
                                          <?php
                                            if (form_error('szFranchisee')) {
                                                ?>
                                                <span class="help-block pull-left">
                                                <span><?php echo form_error('szFranchisee'); ?></span>
                                                </span><?php } ?>
                                            <?php if (!empty($arErrorMessages['szFranchisee'])) { ?>
                                                <span class="help-block pull-left">
                                                <i class="fa fa-times-circle"></i>
                                                    <?php echo $arErrorMessages['szFranchisee']; ?>
                                            </span>
                                            <?php } ?>
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
                                            <?php if (!empty($arErrorMessages['dtStart'])) { ?>
                                                <span class="help-block pull-left">
                                                <i class="fa fa-times-circle"></i>
                                                    <?php echo $arErrorMessages['dtStart']; ?>
                                            </span>
                                            <?php } ?>
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
                                            <?php if (!empty($arErrorMessages['dtEnd'])) { ?>
                                                <span class="help-block pull-left">
                                                <i class="fa fa-times-circle"></i>
                                                    <?php echo $arErrorMessages['dtEnd']; ?>
                                            </span>
                                            <?php } ?>
                                        </div>
                                    </div>
                                     <div class="col-md-3">
                                        <div class="form-group">
                                            <button class="btn green-meadow" type="submit"><i
                                                    class="fa fa-search"></i> 
                                            </button>
                                            &nbsp;
                                        </div>
                                    </div>
                                 </div>
                             </form>
                        </div>
                    </div>
                    <?php
                    $fromEndDate = form_error('dtEnd');
                    if(($_POST['szFranchisee']!='') && ($_POST['dtStart']!='') && ($_POST['dtEnd']!='') && (empty($fromEndDate)))
                    {
                    if (!empty($getManualCalcStartToEndDate)) {
                    ?>
                    <div class="portlet-body alert">
                        <div class="row">
                            <div>
                                <div class="portlet green-meadow box">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="fa fa-users"></i>Revenue Generate

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
                                                    <th>
                                                        Proforma Invoice #
                                                    </th>
                                                    <th>
                                                        Proforma Invoice Date
                                                    </th>
                                                    <th>
                                                        Client Code
                                                    </th>
                                                    <th>
                                                        Client Name
                                                    </th>
                                                    <th>
                                                         Revenue EXL GST
                                                    </th>
                                                    <th>
                                                        Royalty Fees
                                                    </th>
                                                    <th>
                                                        Net Revenue EXL GST
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
                                                        <td>
                                                           <?php echo '#'.sprintf(__FORMAT_NUMBER__, $getManualCalcData['id']);?>
                                                        </td>
                                                        <td>
                                                            <?php echo  date("d-m-Y", strtotime($getManualCalcData['dtCreatedOn']));?>
                                                           
                                                        </td>
                                                         <td> <?php echo(!empty($franchiseecode['userCode']) ? $franchiseecode['userCode'] : 'N/A'); ?> </td>
                                                        <td>
                                                            <?php echo $userDataAry['szName'] ?>
                                                        </td>
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
                                                     <td></td>
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
                    }
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