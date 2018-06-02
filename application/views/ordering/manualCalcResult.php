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
                        <a href="<?php echo __BASE_URL__; ?>/ordering/sitesRecord">Home</a>
                        <i class="fa fa-circle"></i>
                    </li>

                    <li>
                        <span class="active">Automatic Calculated Result</span>
                    </li>
                </ul>

                <div class="portlet light bordered about-text" id="user_info">
                    <?php
                    $DrugtestidArr = array_map('intval', str_split($Drugtestid));
                    if (in_array(1, $DrugtestidArr) || in_array(2, $DrugtestidArr) || in_array(3, $DrugtestidArr) || in_array(4, $DrugtestidArr) || in_array(5, $DrugtestidArr)) {
                        $countDoner = count($this->Form_Management_Model->getDonarDetailBySosId($sosid));
                        $ManualCalArr = $this->Ordering_Model->getManualCalculationBySosId($sosid);
                        ?>
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-equalizer font-red-sunglo"></i>
                                <span class="caption-subject font-red-sunglo bold uppercase">
                                    Automatic Calculated Result
                                </span>
                            </div>
                            <div class="actions">
                                <a onclick="viewTaxIncoice('<?php echo $idsite;?>','<?php echo $Drugtestid;?>','<?php echo $sosid;?>')" href="javascript:void(0);"
                                   class=" btn green-meadow">
                                    <i class="fa fa-navicon"></i> Tax Invoice</a>
                                <a onclick="calcDetailspdf('<?php echo $idsite;?>','<?php echo $Drugtestid;?>','<?php echo $sosid;?>')" href="javascript:void(0);" 
                                   class=" btn green-meadow">
                                <i class="fa fa-file-pdf-o"></i> View Pdf </a>
                                
                                 <a onclick="backSiteRecord('<?php echo $freanchId;?>')" href="javascript:void(0);" 
                                   class=" btn green-meadow">
                                Back </a>
                            </div>

                        </div>
                        <div class="portlet-body alert">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <?php
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

                                        /*$Val1=$countDoner*__RRP_1__;
                                              $Val2=$countDoner*__RRP_2__;
                                              $Val3=$countDoner*__RRP_3__;*/
                                        //echo $Val1.'---'.$Val2.'---'.$Val3.'---'.$countDoner;
                                        ?>
                                        <div class="col-sm-8 text-info bold">
                                            <lable>Total :</lable>
                                        </div>
                                        <div class="col-sm-2">
                                            <p>$<?php //$ValTotal=$Val1+$Val2+$Val3;
                                                echo number_format($ValTotal, 2, '.', ','); ?> </p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-8 text-info bold">
                                            <lable>Royalty fees:</lable>
                                        </div>
                                        <div class="col-sm-2">
                                            <p>$<?php $Royaltyfees = $ValTotal * 0.1;
                                                $Royaltyfees = number_format($Royaltyfees, 2, '.', '');
                                                echo number_format($Royaltyfees, 2, '.', ',');?> </p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-8 text-info bold">
                                            <lable>GST:</lable>
                                        </div>
                                        <div class="col-sm-2">
                                            <p>$<?php $GST = $ValTotal * 0.1;
                                                $GST = number_format($GST, 2, '.', '');
                                                echo number_format($GST, 2, '.', ',');?> </p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-8 text-info bold">
                                            <lable>Total before Royalty and Inc GST:</lable>
                                        </div>
                                        <div class="col-sm-2">
                                            <p>$<?php $TotalbeforeRoyalty = $ValTotal + $GST;
                                                $TotalbeforeRoyalty = number_format($TotalbeforeRoyalty, 2, '.', '');
                                                echo number_format($TotalbeforeRoyalty, 2, '.', ',');?> </p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-8 text-info bold">
                                            <lable>Total after royalty and Inc GST:</lable>
                                        </div>
                                        <div class="col-sm-2">
                                            <p>$<?php $TotalafterRoyalty = $ValTotal - $Royaltyfees + $GST;
                                               $TotalafterRoyalty = number_format($TotalafterRoyalty, 2, '.', '');
                                                echo number_format($TotalafterRoyalty, 2, '.', ',');?> </p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-8 text-info bold">
                                            <lable>Net Total after royalty and exl GST:</lable>
                                        </div>
                                        <div class="col-sm-2">
                                            <p>$<?php $NetTotal = $ValTotal - $Royaltyfees;
                                                $NetTotal = number_format($NetTotal, 2, '.', '');
                                                echo number_format($NetTotal, 2, '.', ',');?></p>
                                        </div>
                                    </div>

                                </div>

                            </div>

                        </div>
                    <?php } ?>
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-equalizer font-red-sunglo"></i>
                            <span class="caption-subject font-red-sunglo bold uppercase">
                 
                    <?php
                    echo "Manual Calculations Result";

                    ?>
                                &nbsp; &nbsp;
                                <!--                    <a class="btn btn-circle btn-icon-only btn-default" title="Edit Manual Cal Data" onclick="editOperationManagerDetails('<?php echo $operationManagerAray['id']; ?>','2');" href="javascript:void(0);">
                        <i class="fa fa-pencil"></i> 
                    </a>-->
                </span>
                        </div>

                    </div>
                    <div class="portlet-body alert">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-sm-8 text-info bold">
                                        <lable>Total Other revenue Streams:</lable>
                                    </div>
                                    <div class="col-sm-2">
                                        <p>$<?php
                                            $otherRRPVal = 0;
                                            if (in_array(5, $DrugtestidArr)) {
                                                $otherRRPVal = $countDoner * $ManualCalArr['other_drug_rrp'];
                                            }

										if($editform == "0"){
                                            $DcmobileScreen = $data['DCmobileScreenBasePrice'] * ($data['DCmobileScreenHr']>1?$data['DCmobileScreenHr']:1);
                                            $mobileScreen = $data['mobileScreenBasePrice'] * ($data['mobileScreenHr']>1?$data['mobileScreenHr']:1);
                                            $calloutprice = $data['CallOutBasePrice'] * ($data['CallOutHr']>3?$data['CallOutHr']:3);
                                            $fcoprice = $data['FCOBasePrice'] * ($data['FCOHr']>2?$data['FCOHr']:2);
                                            $travel = $data['travelBasePrice'] * ($data['travelHr']>1?$data['travelHr']:1);
                                            $TotalTrevenu = $otherRRPVal + $data['urineNata'] + $data['laboratoryConfirmation']+$data['cancellationFee']+ $data['nataLabCnfrm'] + $data['oralFluidNata'] + $data['SyntheticCannabinoids'] + $data['laboratoryScreening'] + $data['RtwScrenning'] + $mobileScreen + $DcmobileScreen+ $travel + $calloutprice + $fcoprice;
										}elseif($editform == "1"){
											$DcmobileScreen = $data['mobileScreenBasePrice'] * ($data['mobileScreenHr']>1?$data['mobileScreenHr']:1);
                                            $mobileScreen = $data['mcbp'] * ($data['mchr']>1?$data['mchr']:1);
                                            $calloutprice = $data['cobp'] * ($data['cohr']>3?$data['cohr']:3);
                                            $fcoprice = $data['fcobp'] * ($data['fcohr']>2?$data['fcohr']:2);
                                            $travel = $data['travelBasePrice'] * ($data['travelHr']>1?$data['travelHr']:1);
                                            $TotalTrevenu = $otherRRPVal + $data['urineNata'] + $data['labconf']+$data['cancelfee']+ $data['nataLabCnfrm'] + $data['oralFluidNata'] + $data['SyntheticCannabinoids'] + $data['labScrenning'] + $data['RtwScrenning'] + $mobileScreen + $DcmobileScreen+ $travel + $calloutprice + $fcoprice;
										}
                                            $TotalTrevenu = number_format($TotalTrevenu, 2, '.', '');
                                            echo number_format($TotalTrevenu, 2, '.', ',');?></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-8 text-info bold">
                                        <lable>Royalty fees:</lable>
                                    </div>
                                    <div class="col-sm-2">
                                        <p>$<?php $RoyaltyfeesManual = ($TotalTrevenu * 0.1);
                                            $RoyaltyfeesManual=  number_format($RoyaltyfeesManual, 2, '.', '');
                                            echo number_format($RoyaltyfeesManual, 2, '.', ',');?></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-8 text-info bold">
                                        <lable>GST:</lable>
                                    </div>
                                    <div class="col-sm-2">
                                        <p>$<?php
                                            $GSTmanual = ($TotalTrevenu * 0.1);
                                            $GSTmanual = number_format($GSTmanual, 2, '.', '');
                                            echo number_format($GSTmanual, 2, '.', ',');?></p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-8 text-info bold">
                                        <lable>Total before Royalty and Inc GST:</lable>
                                    </div>
                                    <div class="col-sm-2">
                                        <p>$<?php
                                            $Total1 = $TotalTrevenu + $GSTmanual;
                                            $Total1 = number_format($Total1, 2, '.', '');
                                            echo number_format($Total1, 2, '.', ',');?></p>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-sm-8 text-info bold">
                                        <lable>Total after royalty and Inc GST:</lable>
                                    </div>
                                    <div class="col-sm-2">
                                        <p>$<?php
                                            $Total2 = $TotalTrevenu - $RoyaltyfeesManual + $GSTmanual;
                                            $Total2 = number_format($Total2, 2, '.', '');
                                            echo number_format($Total2, 2, '.', ',');?></p>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-sm-8 text-info bold">
                                        <lable>Net Total after royalty and exl GST:</lable>
                                    </div>
                                    <div class="col-sm-2">
                                        <p>$<?php echo number_format($TotalTrevenu - $GSTmanual, 2, '.', ','); ?></p>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-equalizer font-red-sunglo"></i>
                            <span class="caption-subject font-red-sunglo bold uppercase">

                    <?php
                    echo "Proforma Invoice Totals";

                    ?>
                                &nbsp; &nbsp;
                                <!--                    <a class="btn btn-circle btn-icon-only btn-default" title="Edit Manual Cal Data" onclick="editOperationManagerDetails('<?php echo $operationManagerAray['id']; ?>','2');" href="javascript:void(0);">
                        <i class="fa fa-pencil"></i>
                    </a>-->
                </span>
                        </div>

                    </div>
                    <div class="portlet-body alert">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-sm-8 text-info bold">
                                        <lable>Total Invoice amount:</lable>
                                    </div>
                                    <div class="col-sm-2">
                                        <p>$<?php
                                            $totalinvoiceAmt = $ValTotal + $TotalTrevenu;
                                            echo number_format($totalinvoiceAmt, 2, '.', ','); ?></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-8 text-info bold">
                                        <lable>Discount<?php
                                            $FrenchiseeDataArr = $this->Webservices_Model->getuserhierarchybysiteid($idsite);
                                            $discount = $this->Ordering_Model->getClientDiscountByClientId($FrenchiseeDataArr[0]['clientType']);
                                            echo (!empty($discount)?'('.$discount['percentage'].'%)':'');
                                            ?>:</lable>
                                    </div>
                                    <div class="col-sm-2">
                                        <?php if(!empty($discount)){?>
                                            <p>$<?php
                                                $totalDisc = ($totalinvoiceAmt*$discount['percentage'])*0.01;
                                                echo number_format($totalDisc, 2, '.', ','); ?></p>
                                        <?php } else{
                                            $totalDisc = 0.00;
                                            echo '<p>-</p>';
                                        }?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-8 text-info bold">
                                        <lable>Total After Discount:</lable>
                                    </div>
                                    <div class="col-sm-2">
                                        <p>$<?php
                                            $totalAfterDisc = $totalinvoiceAmt-$totalDisc;
                                            echo number_format($totalAfterDisc, 2, '.', ','); ?></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-8 text-info bold">
                                        <lable>Total Royalty fees:</lable>
                                    </div>
                                    <div class="col-sm-2">
                                        <p>$<?php
                                            $totalRoyalty = $totalAfterDisc*0.1;
                                            $totalRoyalty =number_format($totalRoyalty, 2, '.', '');
                                            echo number_format($totalRoyalty, 2, '.', ','); ?></p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-8 text-info bold">
                                        <lable>GST:</lable>
                                    </div>
                                    <div class="col-sm-2">
                                        <p>$<?php
                                            $totalGst = $totalAfterDisc*0.1;
                                            $totalGst =number_format($totalGst, 2, '.', '');
                                            echo number_format($totalGst, 2, '.', ','); ?></p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-8 text-info bold">
                                        <lable>Total before Royalty, Inc Discount and Inc GST:</lable>
                                    </div>
                                    <div class="col-sm-2">
                                        <p>$<?php
                                            $totalRoyaltyBefore = $totalGst + $totalAfterDisc;
                                            echo number_format($totalRoyaltyBefore, 2, '.', ','); ?></p>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-sm-8 text-info bold">
                                        <lable>Total after royalty, Inc Discount and Inc GST:</lable>
                                    </div>
                                    <div class="col-sm-2">
                                        <p>$<?php
                                            $totalRoyaltyAfter = $totalRoyaltyBefore - $totalRoyalty;
                                            echo number_format($totalRoyaltyAfter, 2, '.', ','); ?></p>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-sm-8 text-info bold">
                                        <lable>Net Total after royalty, Inc Discount and exl GST:</lable>
                                    </div>
                                    <div class="col-sm-2">

                                        <p>$<?php
                                            $NetTotal = $totalAfterDisc - $totalRoyalty;
                                            echo number_format($NetTotal, 2, '.', ','); ?></p>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
</div>
<div id="popup_box"></div>