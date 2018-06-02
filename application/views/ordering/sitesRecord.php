<script type='text/javascript'>
    $(function () {

        $("#szSearchname").customselect();

    });
</script>
<div class="page-content-wrapper">
    <div class="page-content">
		<?php
		if ( ! empty( $_SESSION['drugsafe_user_message'] ) ) {
			if ( trim( $_SESSION['drugsafe_user_message']['type'] ) == "success" ) {
				?>
                <div class="alert alert-success">
					<?php echo $_SESSION['drugsafe_user_message']['content']; ?>
                </div>
			<?php }
			if ( trim( $_SESSION['drugsafe_user_message']['type'] ) == "error" ) {
				?>
                <div class="alert alert-danger">
					<?php echo $_SESSION['drugsafe_user_message']['content']; ?>
                </div>
			<?php }
			$this->session->unset_userdata( 'drugsafe_user_message' );
		}
		?>

        <div id="page_content" class="row">
            <div class="col-md-12">
                <ul class="page-breadcrumb breadcrumb">

                    <li>
                        <a href="<?php echo __BASE_URL__; ?>/ordering/sitesRecord">Home</a>
                        <i class="fa fa-circle"></i>
                    </li>
					<?php
					if ( ! empty( $_POST['szSearchClRecord2'] ) ) {
						$userDataAry = $this->Admin_Model->getUserDetailsByEmailOrId( '', $_POST['szSearchClRecord2'] );

						?>
                        <li>
                            <a onclick=""
                               href="javascript:void(0);"><?php echo $userDataAry['szName']; ?></a>
                            <i class="fa fa-circle"></i>
                        </li>
                        <li>
                            <span class="active">Sites Record</span>
                        </li>
					<?php } else {
						?>
                        <li>
                            <span class="active">Select Franchisee</span>
                        </li>
					<?php } ?>
                </ul>

                <div class="portlet light bordered">


					<?php
					if ( ( $_SESSION['drugsafe_user']['iRole'] == '1' ) || ( $_SESSION['drugsafe_user']['iRole'] == '5' ) ) {
						if ( $_SESSION['drugsafe_user']['iRole'] == '5' ) {
							$searchOptionArr = $this->Admin_Model->viewFranchiseeList( false, $_SESSION['drugsafe_user']['id'], false, false, false, false, false, false, 1 );
						} else {
							$searchOptionArr = $this->Admin_Model->viewFranchiseeList( false, false, false, false, false, false, false, false, 1 );
						}
						?>
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-equalizer font-green-meadow"></i>
                                <span class="caption-subject font-green-meadow ">Plese select a Franchisee to display their related Invoices.</span>
                            </div>
                        </div>
                        <div class="row">
                            <form class="form-horizontal" id="szSearchClientRecord"
                                  action="<?= __BASE_URL__ ?>/ordering/sitesRecord" name="szSearchClientRecord"
                                  method="post">
                                <div class="search col-md-3">
                                    <select class="form-control custom-select" name="szSearchClRecord2"
                                            id="szSearchname"
                                            onfocus="remove_formError(this.id,'true')">
                                        <option value="">Franchisee Name</option>
										<?php
										foreach ( $searchOptionArr as $searchOptionList ) {
											$selected = ( $searchOptionList['id'] == $_POST['szSearchClRecord2'] ? 'selected="selected"' : '' );
											echo '<option value="' . $searchOptionList['id'] . '"' . $selected . '>' . $searchOptionList['userCode'] . '-' . $searchOptionList['szName'] . '</option>';
										}
										?>
                                    </select>
                                </div>

                                <div class="col-md-1">
                                    <button class="btn green-meadow" type="submit"><i class="fa fa-search"></i></button>
                                </div>
                            </form>
                        </div>
						<?php
					}
					if ( ! empty( $_POST['szSearchClRecord2'] ) ) { ?>
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-equalizer font-red-sunglo"></i>
                                <span class="caption-subject font-red-sunglo bold uppercase">Proforma Invoices</span>
                            </div>
                        </div>
						<?php if ( ! empty( $sosRormDetailsAry ) ) {
							$i = 0;
							$j = 0;
$ProformaInvoiceRecords = array();
							$dataArr = array();
							foreach ( $sosRormDetailsAry as $sosRormDetailsData => $sosRormDetailsDataArr ) {
								foreach ( $sosRormDetailsDataArr as $sosRormDetailsData ) {
									$ClirntDetailsDataAry = $this->Franchisee_Model->getParentClientDetailsId( $sosRormDetailsData['Clientid'] );
									$userDataAry          = $this->Admin_Model->getUserDetailsByEmailOrId( '', $ClirntDetailsDataAry['clientType'] );
									$franchiseecode       = $this->Franchisee_Model->getusercodebyuserid( $userDataAry['id'] );
									$drugtestidArr        = explode( ',', $sosRormDetailsData['Drugtestid'] );
									$drugtestArr          = implode( '', $drugtestidArr );
									if ( empty( $drugtestArr ) ) {
										$drugtestArr = '0';
									}
									$manualCalcDetails = $this->Ordering_Model->getManualCalculationBySosId( $sosRormDetailsData['id'] );
									/*if(!empty($manualCalcDetails))
									{*/
//                                    print_r($sosRormDetailsAry);
									if ( ( ! empty( $manualCalcDetails ) && $_SESSION['drugsafe_user']['iRole'] == '1' ) || ( $_SESSION['drugsafe_user']['iRole'] == '2' ) || ( ! empty( $manualCalcDetails ) && $_SESSION['drugsafe_user']['iRole'] == '5' ) ) {
										if ( $j == 0 ) { ?>
                                            <!--                                            <div class="row tabrow">-->
                                            <div class="table-responsive">
                                            <table class="table table-striped table-bordered table-hover">
                                            <thead>
                                            <tr>
                                                <th>Proforma Invoice #</th>
                                                <th> Client Code</th>
                                                <th> Client Name</th>
                                                <th> Test Date</th>
                                                <th> Service Commenced</th>
                                                <th> Service Concluded</th>
                                                <th> Proforma Invoice Date</th>
                                                <th> Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
										<?php }

										$recordsArr = array( 'id'       => ( ! empty( $manualCalcDetails['id'] ) ? '#' . sprintf( __FORMAT_NUMBER__, $manualCalcDetails['id'] ) : 'N/A' ),
										                     'tempid' =>( ! empty( $manualCalcDetails['id'] ) ? $manualCalcDetails['id'] : 0 ),
										                     'usercode' => ( ! empty( $franchiseecode['userCode'] ) ? $franchiseecode['userCode'] : 'N/A' ),
                                            'clientname' => $userDataAry['szName'],
                                            'testdate' => date( 'd/m/Y', strtotime( $sosRormDetailsData['testdate'] ) ),
                                            'servicecommenced' => $sosRormDetailsData['ServiceCommencedOn'],
                                            'serviceconcluded'=>$sosRormDetailsData['ServiceConcludedOn'],
                                            'sosid' => $sosRormDetailsData['id'],
                                            'updated_on' => $sosRormDetailsData['updated_on'],
                                            'editid' => ( ! empty( $manualCalcDetails['id'] ) ? $manualCalcDetails['id'] : 'N/A' ),
                                            'invoicedate' =>( ( ! empty( $manualCalcDetails['dtCreatedOn'] ) && $manualCalcDetails['dtCreatedOn'] != '0000-00-00' ) ? date( 'd/m/Y', strtotime( $manualCalcDetails['dtCreatedOn'] ) ) : 'N/A' )
										);
										    $recordsArr['emptydata'] = (( empty( $manualCalcDetails ) && $_SESSION['drugsafe_user']['iRole'] == '2' )?'1':'0');
										$recordsArr['editrec'] = (( empty( $manualCalcDetails ) && $_SESSION['drugsafe_user']['iRole'] == '2' )?'0':($_SESSION['drugsafe_user']['iRole'] == '2'?'1':'0'));
											$recordsArr['actionClientid'] = $sosRormDetailsData['Clientid'];
											$recordsArr['actionarr'] = $drugtestArr;
											$recordsArr['actionsosdata'] = $sosRormDetailsData['id'];
$actDateTimeArr = explode('/',$recordsArr['invoicedate']);
$ActDateTime = $actDateTimeArr[2].'-'.$actDateTimeArr[1].'-'.$actDateTimeArr[0];
$recordsArr['strtTime'] = strtotime($ActDateTime);
											array_push($dataArr,$recordsArr);

										$j ++;
									}
//                                    }
								}
								$i ++;
							}
/*array_push($ProformaInvoiceRecords,$dataArr);
							print_r($dataArr);
							echo '<br />';
							echo '<br />';*/
//print_r($dataArr);
							$InvoiceDateArr = array();
							$unInvoicedArr = array();
							$updatedOn = array();
							foreach ($dataArr as $key => $row)
							{
								$InvoiceDateArr[$key] = $row['strtTime'];
                                $unInvoicedArr[$key] = $row['sosid'];
                                $updatedOn[$key] = $row['updated_on'];
							}
							array_multisort($InvoiceDateArr, SORT_DESC,$updatedOn, SORT_DESC,$dataArr);
//							print_r($dataArr);
							if(!empty($dataArr)){
							    foreach ($dataArr as $records){ ?>
                                    <tr>
                                        <td><?php echo $records['id']; ?> </td>
                                        <td> <?php echo $records['usercode']; ?> </td>
                                        <td> <?php echo $records['clientname'] ?> </td>
                                        <td> <?php echo $records['testdate']; ?> </td>
                                        <td> <?php echo $records['servicecommenced']; ?> </td>
                                        <td> <?php echo $records['serviceconcluded']; ?> </td>
                                        <td><?php echo $records['invoicedate']; ?> </td>
                                        <td>

										    <?php
										    if ( $records['emptydata'] == '1' ) {
											    ?>
                                                <a class="btn btn-circle btn-icon-only btn-default"
                                                   id="viewCalcForm" title="generate Form"
                                                   onclick="viewCalcform('<?php echo $records['actionClientid']; ?>','<?php echo $records['actionarr']; ?>','<?php echo $records['actionsosdata']; ?>');"
                                                   href="javascript:void(0);"></i>
                                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                                </a>
											    <?php
										    } else {
											    if ( $records['editrec'] == '1' ) {
												    ?>
                                                    <a class="btn btn-circle btn-icon-only btn-default"
                                                       id="editCalcForm" title="Edit Calc Form"
                                                       onclick="editCalcForm('<?php echo $records['actionClientid']; ?>','<?php echo $records['actionarr']; ?>','<?php echo $records['actionsosdata']; ?>','<?php echo $records['editid']; ?>');"
                                                       href="javascript:void(0);"></i>
                                                        <i class="fa fa-pencil" aria-hidden="true"></i>
                                                    </a>
											    <?php } ?>
                                                <a class="btn btn-circle btn-icon-only btn-default"
                                                   id="viewDetils" title="View Calc Details"
                                                   onclick="viewCalcDetails('<?php echo $records['actionClientid']; ?>','<?php echo $records['actionarr']; ?>','<?php echo $records['actionsosdata']; ?>');"
                                                   href="javascript:void(0);"></i>
                                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                                </a>
											    <?php

										    }
										    ?>


                                        </td>
                                    </tr>
                                <?php }
                            }
							?>
                            </tbody>
                            </table>
							<?php
							if ( $j == 0 && $_SESSION['drugsafe_user']['iRole'] == '1' ) {
								echo "No invoice found";
							}
							?>
                            </div>
                            <!--                            </div>-->
							<?php

						} else {
							echo "No invoice found";
						}
					}
					?>
					<?php if ( ! empty( $clientAry ) ) { ?>
                        <div class="row">

                            <div class="col-md-7 col-sm-7">
                                <div class="dataTables_paginate paging_bootstrap_full_number">
									<?php echo $this->pagination->create_links(); ?>
                                </div>
                            </div>


                        </div>
					<?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<div id="popup_box"></div>