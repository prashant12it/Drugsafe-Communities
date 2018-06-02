<script type='text/javascript'>
    $(function () {
        $("#szSearch1").customselect();
        $("#szSearch2").customselect();
        $("#szSearch3").customselect();
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

                    <li>
                        <a href="<?php echo __BASE_URL__; ?>">Home</a>
                        <i class="fa fa-circle"></i>
                    </li>

                    <li>
                        <span class="active">Inventory Report</span>
                    </li>
                </ul>

                <div class="portlet light bordered about-text" id="user_info">

                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-equalizer font-red-sunglo"></i>
                            <span class="caption-subject font-red-sunglo bold uppercase">
                                   Client Comparison Report
                                </span>
                        </div>
                        <?php if(!$err && !empty($compareresultarr)){?>
                            <div class="actions">
                                  <a onclick="comparisonReportChart('<?php echo $_POST['szSearch3'];?>','<?php echo $drugtesttype;?>','<?php echo $comparetype;?>')" href="javascript:void(0);" class=" btn green-meadow">
                                    <i class="fa fa-bar-chart"></i> View Chart </a>
                                <a onclick="comparisonReportPdf('<?php echo $_POST['szSearch3'];?>','<?php echo $drugtesttype;?>','<?php echo $comparetype;?>')" href="javascript:void(0);" class=" btn green-meadow">
                                    <i class="fa fa-file-pdf-o"></i> View Pdf </a>

                                <a onclick="comparisonReportXls('<?php echo $_POST['szSearch3'];?>','<?php echo $drugtesttype;?>','<?php echo $comparetype;?>')" href="javascript:void(0);" class=" btn green-meadow">
                                    <i class="fa fa-file-excel-o"></i> View Xls </a>

                            </div>
                        <?php } ?>
                    </div>

    
                    <div class="  row">
                    <form class="search-bar" name="orderSearchForm" id="orderSearchForm"
                          action="<?= __BASE_URL__ ?>/reporting/clientcomparisonReport" method="post">
                        <div class="row">
                        <?php if(($_SESSION['drugsafe_user']['iRole'] == 1)||($_SESSION['drugsafe_user']['iRole'] == 5)){?>
                            <div class="col-md-3 clienttypeselect">
                                  <?php if($_SESSION['drugsafe_user']['iRole']==1 ){
                                       $allFrDetailsSearchAray =$this->Admin_Model->viewFranchiseeList(false,false,false,false,false,false,false,false,1); 
                                   }
                                   if($_SESSION['drugsafe_user']['iRole']==5 ){
                                       $allFrDetailsSearchAray =$this->Admin_Model->viewFranchiseeList(false,$_SESSION['drugsafe_user']['id'],false,false,false,false,false,false,1); 
                                   }
                                       ?> 
                                
                                <div class="form-group <?php if (!empty($arErrorMessages['szSearch1']) != '') { ?>has-error<?php } ?>">
                                    <select class="form-control custom-select" name="szSearch1" id="szSearch1"
                                            onblur="remove_formError(this.id,'true')"
                                            onchange="getClientListByFrIdData(this.value);">
                                        <option value="">Franchisee Name</option>
                                        <?php
                                        foreach ($allFrDetailsSearchAray as $allFrDetailsSearchList) {
                                            $selected = ($allFrDetailsSearchList['id'] == $_POST['szSearch1'] ? 'selected="selected"' : '');
                                            if($allFrDetailsSearchList['id'] == $_POST['szSearch1']){ ?>
                                        <script type="text/javascript">
                                            setTimeout(function(){getClientListByFrIdData('<?php echo $_POST['szSearch1'];?>','<?php echo $_POST['szSearch2'];?>','<?php echo $_POST['szSearch3'];?>');},300);
                                        
                                        </script>
                                            <?php }
                                            echo '<option value="' . $allFrDetailsSearchList['id'] . '"' . $selected . ' >'  .$allFrDetailsSearchList['userCode'].'-'. $allFrDetailsSearchList['szName'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                    <?php
                                    if (form_error('szSearch1')) {
                                        ?>
                                        <span class="help-block pull-left">
                                        <span><?php echo form_error('szSearch1'); ?></span>
                                        </span><?php } ?>
                                </div>
                            </div>
                           
                            <?php }elseif($_SESSION['drugsafe_user']['iRole'] == 2){?>
                            <input type="hidden" name="szSearch1" value="<?php echo $_SESSION['drugsafe_user']['id'];?>" />
                            <script type="text/javascript">
                                setTimeout(function(){getClientListByFrIdData('<?php echo $_SESSION['drugsafe_user']['id'];?>','<?php echo $_POST['szSearch2'];?>','<?php echo $_POST['szSearch3'];?>');},300);
                            </script>
                        <?php } ?>
                            <div class="col-md-3 clienttypeselect">
                                <div class="form-group ">
                                    <div id="clientname">
                                        <select class="form-control custom-select" name="szSearch2" id="szSearch2"
                                                onfocus="remove_formError(this.id,'true')"
                                                onchange="getSiteListByClientIdData(this.value)">
                                            <option value="">Client Name</option>
                                            <?php
                                            foreach ($clientarr as $clientData) {
                                                $selected = ($clientData['id'] == $_POST['szSearch2'] ? 'selected="selected"' : '');
                                                if($clientData['id'] == $_POST['szSearch2']){ ?>
                                                    <script type="text/javascript">
                                                        setTimeout(function(){getSiteListByClientIdData('<?php echo $_POST['szSearch2'];?>','<?php echo $_POST['szSearch3'];?>','<?php echo $_POST['szSearch1'];?>');},500);
                                                    </script>
                                                <?php }
                                                echo '<option value="' . $clientData['id'] . '"' . $selected . ' >' . $clientData['szName'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <?php
                                    if (form_error('szSearch2')) {
                                        ?>
                                        <span class="help-block pull-left">
                                        <span><?php echo form_error('szSearch2'); ?></span>
                                        </span><?php } ?>
                                </div>
                            </div>
                          
                            <div class="clienttypeselect col-md-3">
                                <div class="form-group ">
                                    <div id="sitename">
                                        <select class="form-control custom-select" name="szSearch3" id="szSearch3"
                                                onfocus="remove_formError(this.id,'true')">
                                            <option value="">Company Name/site</option>
                                            <?php
                                            foreach ($sitearr as $siteData) {
                                                $selected = ($siteData['id'] == $_POST['szSearch3'] ? 'selected="selected"' : '');
                                                echo '<option value="' . $siteData['id'] . '"' . $selected . ' >' . $siteData['szName'] . '</option>';
                                            }
                                            ?>
                                        </select>

                                    </div>
                                    <?php
                                    if (form_error('szSearch3')) {
                                        ?>
                                        <span class="help-block pull-left">
                                        <span><?php echo form_error('szSearch3'); ?></span>
                                        </span><?php } ?>
                                </div>
                            </div>
                  
                       <?php if($_SESSION['drugsafe_user']['iRole']==2 ){ ?>
                       
                           
                            <div class="col-md-3">
                                <div class="form-group <?php if (!empty($arErrorMessages['szSearch4']) != '') { ?>has-error<?php } ?>">

                                    <select class="form-control custom-select" name="szSearch4" id="szSearch4"
                                            onblur="remove_formError(this.id,'true')">
                                        <option value=''>Test Type</option>
                                        <option value="A" <?php echo(sanitize_post_field_value($_POST['szSearch4']) == trim("A") ? "selected" : ""); ?>>
                                            Alcohol
                                        </option>
                                        <option value="U" <?php echo(sanitize_post_field_value($_POST['szSearch4']) == trim("U") ? "selected" : ""); ?>>
                                            Urine AS/NZA 4308:2001
                                        </option>
                                        <option value="O" <?php echo(sanitize_post_field_value($_POST['szSearch4']) == trim("O") ? "selected" : ""); ?>>
                                            Oral Fluid AS 4760:2006
                                        </option>
                                        <option value="AZ" <?php echo(sanitize_post_field_value($_POST['szSearch4']) == trim("AZ") ? "selected" : ""); ?>>
                                            As/NZA 4308:2008
                                        </option>
                                    </select>
                                    <?php
                                    if (form_error('szSearch4')) {
                                        ?>
                                        <span class="help-block pull-left">
                                        <span><?php echo form_error('szSearch4'); ?></span>
                                        </span><?php } ?>

                                </div>
                            </div>
                            </div>
                        <div class="row">
                               
                            <div class="col-md-3">
                                <div class="form-group <?php if (!empty($arErrorMessages['szSearch5']) != '') { ?>has-error<?php } ?>">

                                    <select class="form-control custom-select" name="szSearch5" id="szSearch5"
                                            onblur="remove_formError(this.id,'true')">
                                        <option value=''>Compare Data</option>
                                        <option value="1" <?php echo(sanitize_post_field_value($_POST['szSearch5']) == trim("1") ? "selected" : ""); ?>>
                                            Monthly
                                        </option>
                                        <option value="2" <?php echo(sanitize_post_field_value($_POST['szSearch5']) == trim("2") ? "selected" : ""); ?>>
                                            Yearly
                                        </option>

                                    </select>
                                    <?php
                                    if (form_error('szSearch5')) {
                                        ?>
                                        <span class="help-block pull-left">
                                        <span><?php echo form_error('szSearch5'); ?></span>
                                        </span><?php } ?>

                                </div>
                            </div>

                            <div class="col-md-1">
                                <button class="btn green-meadow" type="submit"><i class="fa fa-search"></i></button>
                            </div>
                      </div>
                       <?php }  else { ?>
                         </div>
                        <div class="row">
                           
                            <div class="col-md-3">
                                <div class="form-group <?php if (!empty($arErrorMessages['szSearch4']) != '') { ?>has-error<?php } ?>">

                                    <select class="form-control custom-select" name="szSearch4" id="szSearch4"
                                            onblur="remove_formError(this.id,'true')">
                                        <option value=''>Test Type</option>
                                        <option value="A" <?php echo(sanitize_post_field_value($_POST['szSearch4']) == trim("A") ? "selected" : ""); ?>>
                                            Alcohol
                                        </option>
                                        <option value="U" <?php echo(sanitize_post_field_value($_POST['szSearch4']) == trim("U") ? "selected" : ""); ?>>
                                            Urine AS/NZA 4308:2001
                                        </option>
                                        <option value="O" <?php echo(sanitize_post_field_value($_POST['szSearch4']) == trim("O") ? "selected" : ""); ?>>
                                            Oral Fluid AS 4760:2006
                                        </option>
                                        <option value="AZ" <?php echo(sanitize_post_field_value($_POST['szSearch4']) == trim("AZ") ? "selected" : ""); ?>>
                                            As/NZA 4308:2008
                                        </option>
                                    </select>
                                    <?php
                                    if (form_error('szSearch4')) {
                                        ?>
                                        <span class="help-block pull-left">
                                        <span><?php echo form_error('szSearch4'); ?></span>
                                        </span><?php } ?>

                                </div>
                            </div>
                           
                       
                               
                            <div class="col-md-3">
                                <div class="form-group <?php if (!empty($arErrorMessages['szSearch5']) != '') { ?>has-error<?php } ?>">

                                    <select class="form-control custom-select" name="szSearch5" id="szSearch5"
                                            onblur="remove_formError(this.id,'true')">
                                        <option value=''>Compare Data</option>
                                        <option value="1" <?php echo(sanitize_post_field_value($_POST['szSearch5']) == trim("1") ? "selected" : ""); ?>>
                                            Monthly
                                        </option>
                                        <option value="2" <?php echo(sanitize_post_field_value($_POST['szSearch5']) == trim("2") ? "selected" : ""); ?>>
                                            Yearly
                                        </option>

                                    </select>
                                    <?php
                                    if (form_error('szSearch5')) {
                                        ?>
                                        <span class="help-block pull-left">
                                        <span><?php echo form_error('szSearch5'); ?></span>
                                        </span><?php } ?>

                                </div>
                            </div>

                            <div class="col-md-1">
                                <button class="btn green-meadow" type="submit"><i class="fa fa-search"></i></button>
                            </div>
                      </div>
                       <?php } ?>
                    </form>
                        </div>
                    <?php
                    if ((!$err) && (!empty($compareresultarr))) {
                        ?>
                        <div class="portlet-body alert">
                            <div class="row">
                                <div>
                                    <div class="portlet green-meadow box">
                                        <div class="portlet-title">
                                            <div class="caption">
                                                <i class="fa fa-users"></i>Client Comparison Report
                                            </div>

                                        </div>
                                    </div>
                                    <div class="portlet-body">
                                        <?php if(!empty($userdataarr)){ ?>
                                            <div class="table-responsive">
                                                <table class="table table-hover table-bordered table-striped">
                                                    <tr>
                                                    <th>Franchisee Name:</th><td><?php echo (!empty($userdataarr['franchiseename'])?$userdataarr['franchiseename']:'');?></td>
                                                    <th>Client Name:</th><td><?php echo (!empty($userdataarr['clientname'])?$userdataarr['clientname']:'');?></td>
                                                    <th>Company Name/site:</th><td><?php echo (!empty($userdataarr['sitename'])?$userdataarr['sitename']:'');?></td>
                                                    </tr>
                                                </table>
                                            </div>
                                       <?php }?>

                                        <div class="table-responsive">
                                            <table class="table table-hover table-bordered table-striped">
                                                <thead>
                                                <tr>
                                                    <th><?php echo($comparetype == 1 ? 'Month' : 'Year'); ?></th>
                                                    <th>Test Type</th>
                                                    <th>Total Donors Screenings/Collection at Clients sites</th>
                                                    <th>Positive Test Result</th>
                                                    <th>Negative Test Result</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                foreach ($compareresultarr as $comparisondata) { ?>
                                                    <tr>
                                                        <td>
                                                            <?php echo($comparetype == 1 ? $comparisondata['month'].' '.$comparisondata['year'] : $comparisondata['year']); ?>
                                                        </td>
                                                        <td><?php echo ($testtype == 'A'?'Alcohol':($testtype == 'U'?'Urine AS/NZA 4308:2001':($testtype == 'O'?'Oral Fluid AS 4760:2006':($testtype=='AZ'?'As/NZA 4308:2008':''))));?></td>
                                                        <td><?php echo ($testtype == 'A'?$comparisondata['totalAlcohol']:($testtype == 'U'?$comparisondata['totalDonarUrine']:($testtype == 'O'?$comparisondata['totalDonarOral']:($testtype=='AZ'?$comparisondata['totalDonarUrine']:'0'))));?></td>
                                                        <td><?php echo ($testtype == 'A'?$comparisondata['totalPositiveAlcohol']:($testtype == 'U'?($comparisondata['totalDonarUrine']-$comparisondata['totalNegativeUrine']):($testtype == 'O'?($comparisondata['totalDonarOral']-$comparisondata['totalNegativeOral']):($testtype=='AZ'?($comparisondata['totalDonarUrine']-$comparisondata['totalNegativeUrine']):'0'))));?></td>
                                                        <td><?php echo ($testtype == 'A'?$comparisondata['totalNegativeAlcohol']:($testtype == 'U'?$comparisondata['totalNegativeUrine']:($testtype == 'O'?$comparisondata['totalNegativeOral']:($testtype=='AZ'?$comparisondata['totalNegativeUrine']:'0'))));?></td>
                                                    </tr>
                                                <?php }
                                                ?>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    <?php }elseif(!$err && empty($compareresultarr)){ ?>
                    <div class="portlet-body alert">
                        <div class="row">
                            <div>
                                <div class="portlet green-meadow box">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="fa fa-users"></i>Client Comparison Report
                                        </div>

                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-bordered table-striped">
                                            <tbody>
                                            <tr>
                                                <td>No data found.</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
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
</div>
</div>
<div id="popup_box"></div>