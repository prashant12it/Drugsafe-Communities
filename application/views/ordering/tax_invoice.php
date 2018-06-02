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
                        <span class="active">Tax Invoice</span>
                    </li>
                </ul>

                <div class="portlet light bordered about-text" id="user_info">
                   <?php
                   $DrugtestidArr  = array_map('intval', str_split($Drugtestid));
                   $ValTotal = 0;
                   if(in_array(1, $DrugtestidArr)||in_array(2, $DrugtestidArr)||in_array(3, $DrugtestidArr)||in_array(4, $DrugtestidArr)||in_array(5, $DrugtestidArr)){
                   $countDoner = count($this->Form_Management_Model->getDonarDetailBySosId($sosid));

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
                   ?>
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-equalizer font-red-sunglo"></i>
                                <span class="caption-subject font-red-sunglo bold uppercase">
                                  Services Provided
                                </span>
                            </div>
                             <div class="actions">
                                <a onclick="taxInvoicepdf('<?php echo $idsite;?>','<?php echo $Drugtestid;?>','<?php echo $sosid;?>')" href="javascript:void(0);"
                                   class=" btn green-meadow">
                                <i class="fa fa-file-pdf-o"></i> View Pdf </a>
                                
                                 <a href="<?php echo __BASE_URL__; ?>/ordering/viewCalcDetails"
                                   class=" btn green-meadow">
                                Back </a>
                            </div>
                         

                        </div>

                   <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                     <tr>
                                         <th>System Calculation</th>
                                        <th>No of Donors</th>
                                        <th>RRP</th>
                                        <th>$ Value </th>
                                     </tr>
                                </thead>
                                <tbody>

                                <?php if(in_array(1, $DrugtestidArr)){?>
                                    <tr>
                                        <td>Alcohol</td>
                                        <td> <?php echo $countDoner ?> </td>
                                        <td> $<?php echo number_format(__RRP_1__,2,'.',','); ?> </td>
                                        <td> $<?php $Val1=$countDoner*__RRP_1__; echo number_format($Val1,2,'.',','); ?>  </td>
                                    </tr>
                                <?php }?>
                                <?php if(in_array(2, $DrugtestidArr)){?>
                                    <tr>
                                        <td>Oral Fluid</td>
                                        <td> <?php echo $countDoner ?> </td>
                                        <td> $<?php echo number_format(__RRP_2__,2,'.',','); ?> </td>
                                        <td> $<?php $Val2=$countDoner*__RRP_2__; echo number_format($Val2,2,'.',','); ?>  </td>
                                    </tr>
                                <?php }?>
                                <?php if(in_array(3, $DrugtestidArr)){?>
                                    <tr>
                                        <td>URINE</td>
                                        <td> <?php echo $countDoner ?> </td>
                                        <td> $<?php echo number_format(__RRP_3__,2,'.',','); ?> </td>
                                        <td> $<?php $Val3=$countDoner*__RRP_3__; echo number_format($Val3,2,'.',',');?>  </td>

                                    </tr>
                                <?php }?>
                                <?php if(in_array(4, $DrugtestidArr)){?>
                                    <tr>
                                        <td>AS/NZA 4308:2008</td>
                                        <td> <?php echo $countDoner ?> </td>
                                        <td> $<?php echo number_format(__RRP_4__,2,'.',','); ?> </td>
                                        <td> $<?php $Val4=$countDoner*__RRP_4__; echo number_format($Val4,2,'.',',');?>  </td>

                                    </tr>
                                <?php }?>
                                       
                                </tbody>
                            </table>

                       <?php
                       $otherRRPVal = 0;
                       if (in_array(5, $DrugtestidArr)) { ?>
                       <table class="table table-striped table-bordered table-hover">
                           <thead>
                           <tr>
                               <th>Manual Calculation</th>
                               <th>No of Donors</th>
                               <th>RRP</th>
                               <th>$ Value </th>
                           </tr>
                           </thead>
                           <tbody>
                           <tr>
                               <td><?php echo $sosData[0]['other_drug_test'];?></td>
                               <td> <?php echo $countDoner ?> </td>
                               <td> $<?php echo number_format($data['other_drug_rrp'],2,'.',','); ?> </td>
                               <td> $<?php $otherRRPVal =$countDoner*$data['other_drug_rrp']; echo number_format($otherRRPVal,2,'.',',');?>  </td>

                           </tr>
                           </tbody>
                       </table>
                       <?php } ?>
                        </div>
                    <?php } ?>

                      <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Base Price </th>
                                        <th>No of Hours</th>
                                        <th>$ Value </th>
                                    </tr>
                                </thead>
                                <tbody>
<?php
$DcmobileScreen = number_format($data['mobileScreenBasePrice'], 2, '.', '') * ($data['mobileScreenHr']>1?$data['mobileScreenHr']:1);
$mobileScreen = number_format($data['mcbp'], 2, '.', '') * ($data['mchr']>1?$data['mchr']:1);
$calloutprice = number_format($data['cobp'], 2, '.', '') * ($data['cohr']>3?$data['cohr']:3);
$fcoprice = number_format($data['fcobp'], 2, '.', '') * ($data['fcohr']>2?$data['fcohr']:2);
$travel = number_format($data['travelBasePrice'], 2, '.', '') * ($data['travelHr']>1?$data['travelHr']:1);
$TotalTrevenu = $otherRRPVal + $data['urineNata'] + $data['labconf']+$data['cancelfee']+ $data['nataLabCnfrm'] + $data['oralFluidNata'] + $data['SyntheticCannabinoids'] + $data['labScrenning'] + $data['RtwScrenning'] + $mobileScreen + $DcmobileScreen+ $travel + $calloutprice + $fcoprice;
$TotalTrevenu = number_format($TotalTrevenu, 2, '.', '');
?>
                                        <tr>
                                            <td>Single Field Collection Officer (FCO)</td>
                                            <td>$<?php echo (!empty($data['fcobp'])?number_format($data['fcobp'], 2, '.', ','):'');?></td>
                                            <td><?php echo (!empty($data['fcohr'])?($data['fcohr']>2?$data['fcohr']:2):'');?></td>
                                            <td> $<?php echo number_format($fcoprice, 2, '.', ',');?> </td>
                                        </tr>
                                         <tr>
                                            <td>Mobile Clinic</td>
                                             <td>$<?php echo (!empty($data['mcbp'])?number_format($data['mcbp'], 2, '.', ','):'');?></td>
                                             <td><?php echo (!empty($data['mchr'])?($data['mchr']>1?$data['mchr']:1):'');?></td>
                                             <td> $<?php echo number_format($mobileScreen, 2, '.', ',');?> </td>

                                        </tr>
                                         <tr>
                                            <td>Call Out (including an alcohol & drug screen)</td>
                                             <td>$<?php echo (!empty($data['cobp'])?number_format($data['cobp'], 2, '.', ','):'');?></td>
                                             <td><?php echo (!empty($data['cohr'])?($data['cohr']>3?$data['cohr']:3):'');?></td>
                                             <td> $<?php echo number_format($calloutprice, 2, '.', ',');?> </td>
                                        </tr>
                                         <tr>
                                            <td>Drug-Safe Communities mobile clinic screening</td>
                                             <td>$<?php echo (!empty($data['mobileScreenBasePrice'])?number_format($data['mobileScreenBasePrice'], 2, '.', ','):'');?></td>
                                             <td><?php echo (!empty($data['mobileScreenHr'])?($data['mobileScreenHr']>1?$data['mobileScreenHr']:1):'');?></td>
                                             <td> $<?php echo number_format($DcmobileScreen, 2, '.', ',');?> </td>
                                        </tr>
                                         <tr>
                                            <td>Travel <?php echo ($data['travelType'] == 1?'– When > 100 km return trip from DSC base.':($data['travelType'] == 2?'– When > 100 km return trip from MC base. Includes tester.':''));?></td>
                                             <td>$<?php echo (!empty($data['travelBasePrice'])?number_format($data['travelBasePrice'], 2, '.', ','):'');?></td>
                                             <td><?php echo (!empty($data['travelHr'])?($data['travelHr']>1?$data['travelHr']:1):'');?></td>
                                             <td> $<?php echo number_format($travel, 2, '.', ',');?> </td>
                                      
                                            
                                        </tr>
                                         <tr>
                                              <td colspan="3">Synthetic Cannabinoids screening</td>
                                            
                                            <td> $<?php echo number_format($data['SyntheticCannabinoids'], 2, '.', ',');?> </td>
                                      
                                            
                                        </tr>
                                         <tr>
                                              <td colspan="3">Urine NATA Laboratory screening</td>   
                                            <td> $<?php echo number_format($data['urineNata'], 2, '.', ',');?> </td>
                                      
                                            
                                        </tr>
                                         <tr>
                                             <td colspan="3">NATA Laboratory confirmation</td>
                                          
                                            <td> $<?php echo number_format($data['nataLabCnfrm'], 2, '.', ',');?> </td>
                                      
                                            
                                        </tr>
                                         <tr>
                                             <td colspan="3">Oral Fluid NATA Laboratory confirmation</td>
                                         
                                            <td> $<?php echo number_format($data['oralFluidNata'], 2, '.', ',');?> </td>
                                      
                                            
                                        </tr>
                                         <tr>
                                             <td colspan="3">Synthetic Cannabinoids or Designer Drugs, per sample. - Laboratory screening</td>
                                         
                                            <td> $<?php echo number_format($data['labScrenning'], 2, '.', ',');?> </td>
                                      
                                            
                                        </tr>
                                         <tr>
                                             <td colspan="3">Synthetic Cannabinoids or Designer Drugs, per sample. - Laboratory confirmation</td>
                                         
                                            <td> $<?php echo number_format($data['labconf'], 2, '.', ',');?> </td>
                                      
                                            
                                        </tr>
                                         <tr>
                                              <td colspan="3">Return to work (RTW) screening</td>
                                         
                                            <td> $<?php echo number_format($data['RtwScrenning'], 2, '.', ',');?> </td>
                                      
                                            
                                        </tr>
                                         <tr>
                                             <td colspan="3">Cancellation Fee</td>
                                            
                                            <td> $<?php echo number_format($data['cancelfee'], 2, '.', ',');?> </td>
                                      
                                            
                                        </tr>
                                       
                                </tbody>
                            </table>
                        </div>
                    <?php
                    $totalinvoiceAmt = $ValTotal + $TotalTrevenu;
                    $totalinvoiceAmt = number_format($totalinvoiceAmt, 2, '.', '');
                    $FrenchiseeDataArr = $this->Webservices_Model->getuserhierarchybysiteid($idsite);
                    $discount = $this->Ordering_Model->getClientDiscountByClientId($FrenchiseeDataArr[0]['clientType']);
                    $totalDisc = ($totalinvoiceAmt*$discount['percentage'])*0.01;
                    $totalDisc = number_format($totalDisc, 2, '.', '');
                    $totalAfterDisc = $totalinvoiceAmt-$totalDisc;
                    $totalAfterDisc = number_format($totalAfterDisc, 2, '.', '');
                    $totalGst = $totalAfterDisc*0.1;
                    $totalGst =number_format($totalGst, 2, '.', '');
                    $totalRoyaltyBefore = $totalGst + $totalAfterDisc;
                    $totalRoyaltyBefore =number_format($totalRoyaltyBefore, 2, '.', '');
                    ?>
                      <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                              
                                <tbody>
                                   
                                        <tr>
                                             <th width="900 px;">Discounts</th>
                                            <td>$<?php echo number_format($totalDisc, 2, '.', ',');?></td>
                                      
                                        </tr>
                                        <tr>
                                             <th width="900 px;">Sub Total (Exc GST)</th>
                                             <td>$<?php echo number_format($totalAfterDisc, 2, '.', ',');?></td>
                                      
                                        </tr>
                                        <tr>
                                          <th width="900 px;">GST</th>
                                           <td>$<?php echo number_format($totalGst, 2, '.', ',');?></td>
                                       
                                        </tr>
                                        <tr>
                                            <th width="900 px;">Invoice Amount (INC GST)</th>
                                            <td>$<?php echo number_format($totalRoyaltyBefore, 2, '.', ',');?></td>
                                      
                                        </tr>
                                       
                                </tbody>
                            </table>
                        </div>
                </div>

            </div>
        </div>
    </div>
</div>
</div>
<div id="popup_box"></div>