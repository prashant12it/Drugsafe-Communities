<script type='text/javascript'>
    $(function () {
//        $("#szSearch").customselect();
        $("#szSearchname").customselect();
        $("#szSearchProductCode").customselect();

    });
</script>
<?php $this->session->unset_userdata('flag'); ?>
<div class="page-content-wrapper">
    <div class="page-content">

        <div id="page_content" class="row">
            <div class="col-md-12">
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <a href="<?php echo __BASE_URL__; ?>/reporting/stockassignlist">Home</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                    <li>
                        <span class="active"> Stock Assignments</span>
                    </li>
                </ul>
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-equalizer font-red-sunglo"></i>
                            <span class="caption-subject font-red-sunglo bold uppercase">Stock Assignments</span>
                        </div>
                        <?php

                        if (!empty($allQtyAssignAray)) {

                            ?>
                            <div class="actions">
                         
                                     <a onclick="assignReportingPdf('<?php echo $_POST['szSearch2'];?>','<?php echo $_POST['szSearch'];?>','1')" href="javascript:void(0);" 
                                   class=" btn green-meadow">
                                    <i class="fa fa-file-pdf-o"></i> View Pdf </a>
                                
                                
                               
                               <a onclick="stockassignexcellist('<?php echo $_POST['szSearch2'];?>','<?php echo $_POST['szSearch'];?>','1')" href="javascript:void(0);" 
                                   class=" btn green-meadow">
                                    <i class="fa fa-file-excel-o"></i> View Xls </a>
                            </div>
                            <?php
                        }
                        ?>
                    </div>

                    <?php

                    if (!empty($allQtyAssignAray)) {


                        ?>
                        <div class="row">
                            <form class="form-horizontal" id="szSearchReqAssignList"
                                  action="<?= __BASE_URL__ ?>/reporting/stockassignlist " name="szSearchReqAssignList"
                                  method="post">
                                <!--                                  <div class="search col-md-3">
                            <input type="text" name="szSearch" id="szSearch" class="form-control input-square-right " placeholder="Id Or Name Or Email" value="<? //=sanitize_post_field_value($_POST['szSearch'])?>">
                              <select class="form-control custom-select" name="szSearch1" id="szSearch" onfocus="remove_formError(this.id,'true')">
                                  <option value="">Franchisee Id</option>
                                  <?php
                                foreach ($allQtyAssignListAray as $allQtyAssignListItem) {
                                    $selected = ($allQtyAssignListItem['iFranchiseeId'] == $_POST['szSearch1'] ? 'selected="selected"' : '');
                                    echo '<option value="' . $allQtyAssignListItem['iFranchiseeId'] . '" >FR-' . $allQtyAssignListItem['iFranchiseeId'] . '</option>';
                                }
                                ?>
                              </select>
                          </div>
                                  <div class="col-md-1" style="text-align: center; padding: 5px 0px;">OR</div>-->
                                <!--                           <!--<button class="btn green-meadow" type="submit" ><i class="fa fa-search"></i></button>-->
                                <div class="search col-md-3">
                                    <!--                            <input type="text" name="szSearch" id="szSearch" class="form-control input-square-right " placeholder="Id Or Name Or Email" value="-->
                                    <? /*//=sanitize_post_field_value($_POST['szSearch'])*/ ?><!--">-->
                                    <select class="form-control custom-select" name="szSearch2" id="szSearchname"
                                            onfocus="remove_formError(this.id,'true')">
                                        <option value="">Franchisee Name</option>
                                        <?php foreach ($allQtyAssignListAray as $allQtyAssignListItem) {
                                            $selected = ($allQtyAssignListItem['szName'] == $_POST['szSearch2'] ? 'selected="selected"' : '');
                                            echo '<option value="' . $allQtyAssignListItem['szName'] . '" ' . $selected . '>' . $allQtyAssignListItem['szName'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-1" style="text-align: center; padding: 5px 0px;"></div>
                                <div class="search col-md-3">
                                    <!--                            <input type="text" name="szSearch" id="szSearch" class="form-control input-square-right " placeholder="Id Or Name Or Email" value="-->
                                    <? //=sanitize_post_field_value($_POST['szSearch'])?><!--">-->
                                    <select class="form-control custom-select" name="szSearch" id="szSearchProductCode"
                                            onfocus="remove_formError(this.id,'true')">
                                       
                                            <option value="">Product Code</option>

                                        <?php 
                                        foreach ($allQtyProductAssignListAray as $allQtyProductAssignListItem) {
                                            $selected = ($allQtyProductAssignListItem['szProductCode'] == $_POST['szSearch'] ? 'selected="selected"' : '');
                                            echo '<option value="' . $allQtyProductAssignListItem['szProductCode'] . '"' . $selected . ' >' . $allQtyProductAssignListItem['szProductCode'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-1">
                                    <button class="btn green-meadow" type="submit" value="Submit" name="submit"><i
                                            class="fa fa-search"></i></button>
                                </div>
                            </form>
                        </div>
                        <div class="row">

                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th> Id</th>
                                        <th> Franchisee</th>
                                        <th> Product Code</th>
                                        <th> Cost Per Item</th>
                                        <th> Total Cost For Quantity Assign</th>
<!--                                        <th>Quantity Assign By</th>
                                        <th>Quantity Updated By</th>-->
                                        <th> Quantity Assigned</th>
                                        <th> Quantity Adjusted</th>
                                        <th> Available Quantity</th>
                                        <th> Assigned On</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    if ($allQtyAssignAray) {
                                        $i = 0;

                                        foreach ($allQtyAssignAray as $allQtyAssignData) {
                                            $qtyAssignDataArr = $this->StockMgt_Model->getQtyAssignTrackingDetailsById($allQtyAssignData['iFranchiseeId'], $allQtyAssignData['id']);
                                            $qtyUpdateDataArr = $this->StockMgt_Model->getQtyUpdateTrackingDetailsById($allQtyAssignData['iFranchiseeId'], $allQtyAssignData['id']);
                                            $qtyUpdateData1Arr = end($qtyUpdateDataArr);
//                                           $productDataAry = $this->Inventory_Model->getProductDetailsById($allQtyAssignData['iProductId']);
//                                          
//                                           $franchiseeArr = $this->Admin_Model->getAdminDetailsByEmailOrId('',$allQtyAssignData['iFranchiseeId']);
//                                        
//                                      
                                            ?>
                                            <tr>
                                                <td> FR-<?php echo $allQtyAssignData['iFranchiseeId']; ?> </td>
                                                <td> <?php echo $allQtyAssignData['szName'] ?> </td>
                                                <td> <?php echo $allQtyAssignData['szProductCode']; ?> </td>
                                                <td> $<?php echo $allQtyAssignData['szProductCost']; ?> </td>
                                                <td> <?php
                                                    if ($allQtyAssignData['quantityDeducted'] != 0) {
                                                        $Qty = $allQtyAssignData['quantityDeducted'];
                                                        $Cost = $allQtyAssignData['szProductCost'];
                                                        $TotalCostPerQty = ($Qty * $Cost);
                                                        echo "(-) $" . $TotalCostPerQty;
                                                    } else {
                                                        $Qty = $allQtyAssignData['szQuantityAssigned'];
                                                        $Cost = $allQtyAssignData['szProductCost'];
                                                        $TotalCostPerQty = ($Qty * $Cost);
                                                        echo "(+) $" . $TotalCostPerQty;
                                                    }
                                                    ?>
                                                </td>
<!--                                                <td>
                                                    <?php
                                                    if ($qtyAssignDataArr['szAssignBy']) {
                                                        $franchiseeDetArr = $this->Admin_Model->getAdminDetailsByEmailOrId('', $qtyAssignDataArr['szAssignBy']);
                                                        echo $franchiseeDetArr['szName'];
                                                    } else {
                                                        echo "N.A";
                                                    }

                                                    ?>
                                                </td>

                                                <td>
                                                    <?php
                                                    if ($qtyUpdateData1Arr['szLastUpdatedBy']) {
                                                        $franchiseeDetArr = $this->Admin_Model->getAdminDetailsByEmailOrId('', $qtyUpdateData1Arr['szLastUpdatedBy']);
                                                        echo $franchiseeDetArr['szName'];
                                                    } else {
                                                        echo "N.A";
                                                    }

                                                    ?>
                                                </td>-->
                                                <td> <?php echo $allQtyAssignData['szQuantityAssigned']; ?> </td>
                                                <td> <?php echo $allQtyAssignData['quantityDeducted']; ?> </td>
                                                <td> <?php echo $allQtyAssignData['szTotalAvailableQty']; ?> </td>
                                                <td> <?php echo date('d/m/Y h:i:s A', strtotime($allQtyAssignData['dtAssignedOn'])) ?>  </td>

                                            </tr>
                                            <?php
                                        }
                                    } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <?php
                        $i++;
                    } else {
                        echo "Not Found";
                    }
                    ?>
                    <?php if (!empty($allQtyAssignAray)) { ?>
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