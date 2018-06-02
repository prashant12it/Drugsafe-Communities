<script type='text/javascript'>
    $(function () {
        $("#szSearch1").customselect();
        $("#szSearch2").customselect();
        $("#szSearch3").customselect();
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
                        <span class="active">Order List</span>
                    </li>
                </ul>

                <div class="portlet light bordered about-text" id="user_info">

                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-equalizer font-red-sunglo"></i>
                            <span class="caption-subject font-red-sunglo bold uppercase">
                                    Order List
                                </span>
                        </div>

                    </div>
                    <div class="portlet-body totalpr alert">
                    <div class="row">
                        <form name="orderSearchForm" id="orderSearchForm" class="search-bar"
                              action="<?= __BASE_URL__ ?>/order/view_order_list" method="post">
                            <div class="row">
                        <?php  if($_SESSION['drugsafe_user']['iRole']==1){ 
                            ?>
                                <div class="clienttypeselect col-md-3">
                                    <div class="form-group ">
                                        <select class="form-control custom-select" name="szSearch1" id="szSearch1"
                                                onfocus="remove_formError(this.id,'true')">
                                            <option value="">Franchisee Name</option>
                                            <?php
                                            foreach ($allFrDetailsSearchAray as $allFrDetailsSearchList) {
                                                $selected = ($allFrDetailsSearchList['franchiseeid'] == $_POST['szSearch1'] ? 'selected="selected"' : '');
                                                echo '<option value="' . $allFrDetailsSearchList['franchiseeid'] . '"' . $selected . ' >' .$allFrDetailsSearchList['userCode'].'-'.$allFrDetailsSearchList['szName'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                              <?php }?>
                                <div class="col-md-2">
                                    <div class="form-group ">
                                        <select class="form-control custom-select" name="szSearch2" id="szSearch2"
                                                onfocus="remove_formError(this.id,'true')">
                                            <option value="">Order No</option>
                                            <?php
                                            foreach ($validOrdersDetailsSearchAray as $validOrdersDetailsSearchList) {
                                                $selected = ($validOrdersDetailsSearchList['orderid'] == $_POST['szSearch2'] ? 'selected="selected"' : '');
                                                echo '<option value="' . $validOrdersDetailsSearchList['orderid'] . '" ' . $selected . ' >#' .sprintf(__FORMAT_NUMBER__, $validOrdersDetailsSearchList['orderid'])  . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                              
                                <div class="col-md-3">
                                    <div
                                        class="form-group <?php if (!empty($arErrorMessages['szSearch4']) != '') { ?>has-error<?php } ?>">
                                        <div class="input-group input-medium date date-picker"
                                             data-date-format="dd/mm/yyyy">

                                            <input type="text" id="szSearch4" class="form-control"
                                                   value="<?php echo set_value('szSearch4'); ?>" readonly
                                                   placeholder="Start Order Date"
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

                                <div class="col-md-3">
                                    <div
                                        class="form-group <?php if (!empty($arErrorMessages['szSearch5']) != '') { ?>has-error<?php } ?>">
                                        <div class="input-group input-medium date date-picker"
                                             data-date-format="dd/mm/yyyy">

                                            <input type="text" id="szSearch5" class="form-control"
                                                   value="<?php echo set_value('szSearch5'); ?>" readonly
                                                   placeholder="End Order Date"
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
                                    <div class="form-group">
                                        <button class="btn green-meadow" type="submit"><i
                                                class="fa fa-search"></i> 
                                        </button>
                                        &nbsp;
                                        <!--<button class="btn red uppercase bold" type="button" onclick="resetClientSearch();"><i class="fa fa-refresh"></i>Reset</button>-->
                                    </div>
                                </div>

                                </div>
                        </form>
                    </div>
                        </div>
                    <?php
                    
                    if(($_POST['szSearch4']!='') && ($_POST['szSearch5']!=''))
                    { 
                    if (!empty($validOrdersDetailsAray)) {
                       
                    ?>
                        <div class="portlet-body alert" >
                            <div class="row">
                                <div>
                                    <div class="portlet green-meadow box">
                                        <div class="portlet-title">
                                            <div class="caption">
                                                <i class="fa fa-users"></i>View Order List
                                            </div>

                                        </div>
                                        </div>
                                        <?php
                                        if (!empty($validOrdersDetailsAray)) {
                                            ?>
                                            <div class="portlet-body">
                                                <div class="table-responsive" id="table_content_data">
                                                    <table class="table table-hover table-bordered table-striped">
                                                        <thead>
                                                        <tr>
                                                            <th>
                                                                #
                                                            </th>
                                                            <th>
                                                                Order No
                                                            </th>
                                                             <?php  if($_SESSION['drugsafe_user']['iRole']==1){ ?>
                                                            <th>
                                                                Franchisee
                                                            </th>
                                                             <?php  } ?>
                                                            <th>
                                                                Order Date
                                                            </th>
                                                            <th>
                                                                Status
                                                            </th>
                                                            <th>
                                                                Order Details
                                                            </th>
                                                             <?php  if($_SESSION['drugsafe_user']['iRole']==1){ ?>
                                                            <th>
                                                                Edit Order
                                                            </th>
                                                           
                                                            <th>
                                                                Delivery Docket
                                                            </th>
                                                              <?php  } ?>
                                                             <th>
                                                              Order Received 
                                                            </th>

                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php
                                                        $i = 0;
                                                        foreach ($validOrdersDetailsAray as $validOrdersDetailsData) {
                                                            $i++;
                                                            $productDataArr = $this->Inventory_Model->getProductDetailsById($validOrdersDetailsData['productid']);
                                                            $franchiseeDetArr1 = $this->Admin_Model->getAdminDetailsByEmailOrId('', $validOrdersDetailsData['franchiseeid']);
                                                            $splitTimeStamp = explode(" ", $validOrdersDetailsData['createdon']);
                                                            $date1 = $splitTimeStamp[0];
                                                            $time1 = $splitTimeStamp[1];
                                                            $x = date("g:i a", strtotime($time1));
                                                            $date = explode('-', $date1);
                                                            $monthNum = $date['1'];
                                                            $dateObj = DateTime::createFromFormat('!m', $monthNum);
                                                            $monthName = $dateObj->format('M');
                                                            ?>
                                                            <tr>
                                                                <td><?php echo $i; ?> </td>
                                                                <td>
                                                                    #<?php echo sprintf(__FORMAT_NUMBER__, $validOrdersDetailsData['orderid']); ?>
                                                                </td>
                                                                  <?php  if($_SESSION['drugsafe_user']['iRole']==1){ ?>
                                                                <td>
                                                                    <?php echo $franchiseeDetArr1['szName']; ?>
                                                                </td>
                                                                  <?php } ?>
                                                                <td>
                                                                    <?php echo $date['2']; ?> <?php echo $monthName; ?>  <?php echo $date['0']; ?>
                                                                    at <?php echo $x; ?>
                                                                </td>
                                                                <td>
                                                                    <?php if ($validOrdersDetailsData['status'] == 1) { ?>

                                                                        <p title="Order Status"
                                                                           class="label label-sm label-warning">
                                                                            Ordered
                                                                        </p>
                                                                        <?php
                                                                    }
                                                                    if ($validOrdersDetailsData['status'] == 2) {
                                                                        ?>
                                                                        <p title="Order Status"
                                                                           class="label label-sm label-success">
                                                                         Dispatched
                                                                        </p>
                                                                        <?php
                                                                    }
                                                                    if ($validOrdersDetailsData['status'] == 3) {
                                                                        ?>
                                                                        <p title="Order Status"
                                                                           class="label label-sm label-danger">
                                                                            Canceled
                                                                        </p>
                                                                        <?php
                                                                    }
                                                                    if ($validOrdersDetailsData['status'] == 4) {
                                                                        ?>
                                                                        <p title="Order Status"
                                                                           class="label label-sm label-info">
                                                                            Pending
                                                                        </p>
                                                                        <?php
                                                                    }
                                                                    ?></td>

                                                                <td>
                                                                    <a class="btn btn-circle btn-icon-only btn-default"
                                                                       title="View Order Details"
                                                                       onclick="view_order_details('<?php echo $validOrdersDetailsData['orderid']; ?>','1')"
                                                                       href="javascript:void(0);">
                                                                        <i class="fa fa-eye"></i>
                                                                    </a>
                                                                </td>
                                                                  <?php  if($_SESSION['drugsafe_user']['iRole']==1){ ?>
                                                                <td>
                                                                    <?php
                                                                    if ($validOrdersDetailsData['status'] == 1 || $validOrdersDetailsData['status'] == 2 || $validOrdersDetailsData['status'] == 4) {
                                                                        $checkOrderEditable = $this->Order_Model->checkOrderEditable($validOrdersDetailsData['orderid']);
                                                                        if (!empty($checkOrderEditable)) {
                                                                         if($validOrdersDetailsData['status'] == 2){
                                                                            ?>
                                                                            <a class="btn btn-circle blue btn-icon-only btn-default"
                                                                               title="Edit Order Details"
                                                                               onclick="edit_order_details(<?php echo $validOrdersDetailsData['orderid']; ?>,'1');"
                                                                               href="javascript:void(0);">
                                                                                <i class="fa fa-pencil"></i>
                                                                            </a>
                                                                         <?php } else{ ?>
                                                                           <a class="btn btn-circle blue btn-icon-only btn-default"
                                                                               title="Edit Order Details"
                                                                               onclick="edit_order_details(<?php echo $validOrdersDetailsData['orderid']; ?>);"
                                                                               href="javascript:void(0);">
                                                                                <i class="fa fa-pencil"></i>
                                                                            </a>  
                                                                        <?php
                                                                         }
                                                                         }
                                                                    }
                                                                    ?>
                                                                </td>
                                                                 
                                                                <td>
                                                                    <?php if ($validOrdersDetailsData['status'] == 2) { ?>
                                                                        <a class="btn btn-circle btn-icon-only btn-default"
                                                                           title="View Pdf"
                                                                           onclick="view_order_details_pdf(<?php echo $validOrdersDetailsData['orderid']; ?>,'3');"
                                                                           href="javascript:void(0);">
                                                                            <i class="fa fa-file-pdf-o"></i>
                                                                        </a>
                                                                    <?php } ?>
                                                                </td>
                                                                 <?php } ?>
                                                                  <td>
                                                                      <?php
                                                                      if($validOrdersDetailsData['status'] == 2){
                                                                          $dispatchDatesArr = $this->Order_Model->getTotalOrderDispatchDates($validOrdersDetailsData['orderid'],1);
                                                                          if(!empty($dispatchDatesArr)){ ?>
                                                                              <a class="btn btn-circle btn-icon-only btn-default"
                                                                                 title="Receive Order"
                                                                                 onclick="receive_order_details('<?php echo $validOrdersDetailsData['orderid']; ?>')"
                                                                                 href="javascript:void(0);">
                                                                                  <i class="fa fa-download"></i>
                                                                              </a>
                                                                          <?php }else{ ?>
                                                                              <p title="Order Status"
                                                                                 class="label label-sm label-info">
                                                                                  Order Received
                                                                              </p>
                                                                          <?php }
                                                                      }
                                                                      ?>

                                                                </td>

                                                            </tr>
                                                            <?php
                                                        }
                                                        ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        <?php }else{
                                            echo 'No record found';
                                        } ?>
                                    </div>
                                </div>
                            </div>
                       
                    <?php } else{
                         echo 'No record found';
                         }}?>
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