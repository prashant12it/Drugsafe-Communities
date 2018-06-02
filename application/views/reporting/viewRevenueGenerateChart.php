<script type='text/javascript'>
    $(function () {
        $("#szIndustry").customselect();
        $("#szTestType").customselect();
    });
</script>
<div class="page-content-wrapper">
    <div class="page-content">
        <?php //test ?>

        <div id="page_content" class="row">
            <div class="col-md-12">
                <ul class="page-breadcrumb breadcrumb">

                    <li>
                        <a href="<?php echo __BASE_URL__; ?>">Home</a>
                        <i class="fa fa-circle"></i>
                    </li>

                    <li>
                        <span class="active">Revenue Generate Chart</span>
                    </li>
                </ul>

                <div class="portlet light bordered about-text" id="user_info">

                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-equalizer font-red-sunglo"></i>
                            <span class="caption-subject font-red-sunglo bold uppercase">
                                    Revenue Generate Chart
                            </span>
                        </div>
                    </div>
                    <div class="portlet-body alert">
                        <div class="row">
                            <div>
                                
                                <div class="portlet-body">
                                    <div class="table-responsive">
                                   
                                            <div id="revenue_Generate_Chart"></div>
                                      
                                  
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
</div>
</div>
</div>
<div id="popup_box"></div>
<?php
$Revenue_exl_gst='';
$Royalty_fees='';
$Net_Revenue_exl_gst='';
$Proforma_Invoice='';
if(!empty($getManualCalcStartToEndDate))
{
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
        if(in_array(2, $DrugtestidArr)) {
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
            
            $Revenue_exl_gst[] = ($discountpercent>0?$totalafterdiscount:$totalinvoiceAmt);
            $Royalty_fees[] = $Royaltyfees;
            $Net_Revenue_exl_gst[] =$NetTotal;
            $Proforma_Invoice[]='#'.sprintf(__FORMAT_NUMBER__, $getManualCalcData['id']);
            
    }
  
        $Proforma_Invoice = "'" . implode("','",  $Proforma_Invoice) . "'";
	 $Revenue_exl_gst_total = "" . implode(",",  $Revenue_exl_gst) . ""; 
	$Royalty_fees_total= "" . implode(",",  $Royalty_fees) . "";
	$Net_Revenue_exl_gst_total = "" . implode(",",  $Net_Revenue_exl_gst) . ""; 
	
}
 

?>

<script type="text/javascript">
   $(function () {

    $('#revenue_Generate_Chart').highcharts({
      yAxis: {
        title: {
            text: 'Amount'
        },
         labels: {
            formatter: function () {
                return '$' + this.value;
            }
        }
    },
      colors: ['#2f7ed8','#D2691E','#A9A9A9'],

        chart: {
            type: 'column',
            margin: 75,
            marginBottom: 100,
            options3d: {
                enabled: true,
                alpha: 15,
                beta: 0,
                depth: 110
            }
        },
        title: {
                        text: ''
                    },
        xAxis: {
             title: {
            text: 'Proforma Invoice #'
        },
                categories: [<?php echo $Proforma_Invoice ;?>],
                
            },
        plotOptions: {
            column: {
                depth: 40,
                stacking: true,
                grouping: true,
                groupZPadding: 100,
				dataLabels: {
                enabled: true,
                crop: true,
                overflow: 'none',
				style: {
                    fontSize: '10px'
                },
				color: '#ffffff',
				verticalAlign: 'top'
            }
            }
        },
        series: [{
            name: 'Revenue EXL GST',
            data: [<?php echo $Revenue_exl_gst_total ;?>],
            stack: 0
            
        }, {
             name: 'Royalty Fees',
            data: [<?php echo $Royalty_fees_total;?>],
            stack: 2
        }, {
            name: 'Net Revenue EXL GST',
            data: [<?php echo $Net_Revenue_exl_gst_total;?>],
            stack: 1
        }]



    });
    
});
</script>
