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
                        <span class="active">Orders Report List</span>
                    </li>
                </ul>

                <div class="portlet light bordered about-text" id="user_info">

                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-equalizer font-red-sunglo"></i>
                            <span class="caption-subject font-red-sunglo bold uppercase">
                                    Orders Report List
                                </span>
                        </div>
                        <?php if(!empty($validOrdersDetailsAray)){?>
                            <div class="actions">

                                <a onclick="ViewpdfOrderReport('<?php echo $_POST['szSearch1'];?>','<?php echo $_POST['szSearch2'];?>','<?php echo $_POST['szSearch4'];?>','<?php echo $_POST['szSearch5'];?>')" href="javascript:void(0);"
                                   class=" btn green-meadow">
                                    <i class="fa fa-file-pdf-o"></i> View Pdf </a>

                                <a onclick="ViewexcelOrderReport('<?php echo $_POST['szSearch1'];?>','<?php echo $_POST['szSearch2'];?>','<?php echo $_POST['szSearch4'];?>','<?php echo $_POST['szSearch5'];?>')" href="javascript:void(0);"
                                   class=" btn green-meadow">
                                    <i class="fa fa-file-excel-o"></i> View Xls </a>

                            </div>
                        <?php } ?>
                    </div>
                    <div class="portlet-body totalpr alert">
                        <div class="row">
                            <form name="orderSearchForm" id="orderSearchForm" class="search-bar"
                                  action="<?= __BASE_URL__ ?>/order/view_order_report" method="post">
                               
                      <?php if($_SESSION['drugsafe_user']['iRole']==1){?>
                                 <div class="row">
                                    <div class="clienttypeselect col-md-3">
                                        <div class="form-group ">
                                            <select class="form-control custom-select" name="szSearch1" id="szSearch1"
                                                    onfocus="remove_formError(this.id,'true')">
                                                <option value="">Franchisee Name</option>
                                                <?php
                                                foreach ($allFrDetailsSearchAray as $allFrDetailsSearchList) {
                                                    $selected = ($allFrDetailsSearchList['franchiseeid'] == $_POST['szSearch1'] ? 'selected="selected"' : '');
                                                    echo '<option value="' . $allFrDetailsSearchList['franchiseeid'] . '"' . $selected . ' >' .$allFrDetailsSearchList['userCode'].'-'. $allFrDetailsSearchList['szName'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>                           
                                   <div class="col-md-3 ">
                                        <div class="form-group ">
                                            <select class="form-control custom-select" name="szSearch2" id="szSearch2"
                                                    onfocus="remove_formError(this.id,'true')">
                                                <option value="">Order No</option>
                                                <?php
                                                foreach ($validOrdersDetailsSearchAray as $validOrdersDetailsSearchList) {
                                                    $selected = ($validOrdersDetailsSearchList['orderid'] == $_POST['szSearch2'] ? 'selected="selected"' : '');
                                                    echo '<option value="' . $validOrdersDetailsSearchList['orderid'] . '" ' . $selected . ' >#' . sprintf(__FORMAT_NUMBER__, $validOrdersDetailsSearchList['orderid']) . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                
                                    <div class="col-md-3 search">
                                        <div class="form-group <?php if (!empty($arErrorMessages['szSearch4']) != '') { ?>has-error<?php } ?>">
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
                                   <div class="col-md-3 ">
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
                                    </div>
                                    <div class="row">
                                     <div class="col-md-3">
                                <div class="form-group ">
                                    <select class="form-control custom-select" name="szSearch3" id="szSearch3"
                                            onblur="remove_formError(this.id,'true')">
                                        <option value=''>Status</option>
                                        <option value="1" <?php echo(sanitize_post_field_value($_POST['szSearch3']) == trim("1") ? "selected" : ""); ?>>
                                            Ordered
                                        </option>
                                        <option value="2" <?php echo(sanitize_post_field_value($_POST['szSearch3']) == trim("2") ? "selected" : ""); ?>>
                                            Dispatched
                                        </option>
                                        <option value="3" <?php echo(sanitize_post_field_value($_POST['szSearch3']) == trim("3") ? "selected" : ""); ?>>
                                           Canceled
                                        </option>
                                        
                                    </select>
                          
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
                      <?php } else { ?>  
                               
                             <div class="col-md-3">
                                        <div class="form-group ">
                                            <select class="form-control custom-select" name="szSearch2" id="szSearch2"
                                                    onfocus="remove_formError(this.id,'true')">
                                                <option value="">Order No</option>
                                                <?php
                                                foreach ($validOrdersDetailsSearchAray as $validOrdersDetailsSearchList) {
                                                    $selected = ($validOrdersDetailsSearchList['orderid'] == $_POST['szSearch2'] ? 'selected="selected"' : '');
                                                    echo '<option value="' . $validOrdersDetailsSearchList['orderid'] . '" ' . $selected . ' >#' . sprintf(__FORMAT_NUMBER__, $validOrdersDetailsSearchList['orderid']) . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                
                                    <div class="col-md-3">
                                        <div class="form-group <?php if (!empty($arErrorMessages['szSearch4']) != '') { ?>has-error<?php } ?>">
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
                              
                                <div class="col-md-2">
                                <div class="form-group ">
                                    <select class="form-control custom-select" name="szSearch3" id="szSearch3"
                                            onblur="remove_formError(this.id,'true')">
                                        <option value=''>Status</option>
                                        <option value="1" <?php echo(sanitize_post_field_value($_POST['szSearch3']) == trim("1") ? "selected" : ""); ?>>
                                            Ordered
                                        </option>
                                        <option value="2" <?php echo(sanitize_post_field_value($_POST['szSearch3']) == trim("2") ? "selected" : ""); ?>>
                                            Dispatched
                                        </option>
                                        <option value="3" <?php echo(sanitize_post_field_value($_POST['szSearch3']) == trim("3") ? "selected" : ""); ?>>
                                           Canceled
                                        </option>
                                        
                                    </select>
                          
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

                                 
                                

                      <?php } ?>  
                            </form>
                        </div>
                    </div>
                     <?php
                    if(($_POST['szSearch4']!='') && ($_POST['szSearch5']!=''))
                    {
                    if (!empty($validOrdersDetailsAray)) {
                    ?>
                   
                    <div class="portlet-body alert">
                        <div class="row">
                            <div>
                                <div class="portlet green-meadow box">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="fa fa-users"></i>View Orders Report
                                        </div>

                                    </div>
                                </div>
                                <?php

                                if (!empty($validOrdersDetailsAray)) {
                                    ?>

                                    <div class="portlet-body">
                                        <div class="table-responsive">
                                            <table class="table table-hover table-bordered table-striped">
                                                <thead>
                                                <tr>
                                                    <th>
                                                        #
                                                    </th>
                                                    <?php if($_SESSION['drugsafe_user']['iRole']==1){?>
                                                    <th>
                                                        Franchisee
                                                    </th>
                                                    <?php } ?>
                                                    <th>
                                                        Order Date
                                                    </th>
                                                    <th>
                                                        Order #
                                                    </th>
                                                     <th>
                                                       Status
                                                    </th>
                                                    <th>
                                                        No. of products
                                                    </th>
                                                    <th>
                                                        Order Cost EXL GST
                                                    </th>
                                                   <th>
                                                        Order Details
                                                    </th>
                                                    <!--<th>
                                                        Xero Invoice No.
                                                    </th>-->
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
                                                        <?php if($_SESSION['drugsafe_user']['iRole']==1){?>
                                                        <td>
                                                            <?php echo $franchiseeDetArr1['szName']; ?>
                                                        </td>
                                                        <?php } ?>
                                                        <td>
                                                            <?php echo $date['2']; ?> <?php echo $monthName; ?>  <?php echo $date['0']; ?>
                                                            at <?php echo $x; ?>
                                                        </td>
                                                        <td>
                                                            #<?php echo sprintf(__FORMAT_NUMBER__, $validOrdersDetailsData['orderid']); ?>
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

                                                                    ?></td>
                                                        <td>
                                                            <?php echo $validOrdersDetailsData['totalproducts']; ?>
                                                        </td>
                                                        <td>
                                                           $<?php echo ($validOrdersDetailsData['price']>0?$validOrdersDetailsData['price']:'0.00'); ?>
                                                        </td>

                                                        <td>
                                                            <a class="btn btn-circle btn-icon-only btn-default"
                                                               title="View Order Details"
                                                               onclick="view_order_details('<?php echo $validOrdersDetailsData['orderid']; ?>')"
                                                               href="javascript:void(0);">
                                                                <i class="fa fa-eye"></i>
                                                            </a>
                                                        </td>
                                                        <!--<td>
                                                            <?php /*echo (!empty($validOrdersDetailsData['XeroIDnumber'])?$validOrdersDetailsData['XeroIDnumber']:'N/A'); */?>
                                                        </td>-->
                                                    </tr>
                                                    <?php

                                                }


                                                ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                <?php }else{
                                    echo 'No order found';
                                } ?>
                            </div>
                        </div>
                    </div>
                     <?php }
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
</div>
<div id="popup_box"></div>