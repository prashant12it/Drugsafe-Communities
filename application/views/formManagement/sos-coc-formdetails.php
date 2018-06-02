<script type='text/javascript'>
    $(function () {
        $("#szSearch1").customselect();
        $("#szSearch2").customselect();
        $("#szSearch3").customselect();
        $("#szSearch4").customselect();
//        $("#szSearch5").customselect();
    });
</script>
<div id="loader"></div>
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
                        <span class="active">SOS-COC Forms Report</span>
                    </li>
                </ul>

                <div class="portlet light bordered about-text" id="user_info">

                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-equalizer font-red-sunglo"></i>
                            <span class="caption-subject font-red-sunglo bold uppercase">
                                   SOS-COC Forms Report
                                </span>
                        </div>
                        <?php if (!$err && !empty($compareresultarr)) { ?>
                            <div class="actions">

                                <a onclick="comparisonReportPdf('<?php echo $_POST['szSearch3']; ?>','<?php echo $drugtesttype; ?>','<?php echo $comparetype; ?>')"
                                   href="javascript:void(0);" class=" btn green-meadow">
                                    <i class="fa fa-file-pdf-o"></i> View Pdf </a>

                                <a onclick="comparisonReportXls('<?php echo $_POST['szSearch3']; ?>','<?php echo $drugtesttype; ?>','<?php echo $comparetype; ?>')"
                                   href="javascript:void(0);" class=" btn green-meadow">
                                    <i class="fa fa-file-excel-o"></i> View Xls </a>

                            </div>
                        <?php } ?>
                    </div>


                    <form name="orderSearchForm" id="orderSearchForm" class="search-bar"
                          action="<?= __BASE_URL__ ?>/formManagement/viewForm" method="post">
                      
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group <?php if (!empty($arErrorMessages['dtStart']) != '') { ?>has-error<?php } ?>">
                                    <div class="input-group input-medium date date-picker"
                                         data-date-format="dd/mm/yyyy">

                                        <input type="text" id="dtStart" class="form-control"
                                               value="<?php echo set_value('dtStart'); ?>" readonly
                                               placeholder="Test Date From"
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
                                               placeholder="Test Date To"
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
                            <?php
                           // echo $socFr;die();
                            if($socFr)
                            {
                                ?>
                                 <div class="col-md-3 clienttypeselect">

                                <div class="form-group <?php if (!empty($arErrorMessages['szSearch1']) != '') { ?>has-error<?php } ?>">
                                    <select class="form-control custom-select" name="szSearch1" id="szSearch1"
                                            onblur="remove_formError(this.id,'true')"
                                            onchange="getClientListByFrIdData(this.value);">
                                        <option value="">Franchisee Name</option>
                                        <?php
                                        foreach ($franchiseearr as $allFrDetailsSearchList) {
                                            $selected = ($allFrDetailsSearchList['id'] == $_POST['szSearch1'] ? 'selected="selected"' : '');
                                            if ($allFrDetailsSearchList['id'] == $_POST['szSearch1']) { ?>
                                                <script type="text/javascript">
                                                    setTimeout(function () {
                                                        getClientListByFrIdData('<?php echo $_POST['szSearch1'];?>','<?php echo $_POST['szSearch2'];?>','<?php echo $_POST['szSearch3'];?>');
                                                    }, 500);

                                                </script>
                                            <?php }
                                            echo '<option value="' . $allFrDetailsSearchList['id'] . '"' . $selected . ' >' .$allFrDetailsSearchList['userCode'].'-'. $allFrDetailsSearchList['szName'] . '</option>';
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
                                <?php
                                
                            }
                            ?>
                            
                            <?php if ($_SESSION['drugsafe_user']['iRole'] == 2) { ?>
                                <input type="hidden" name="szSearch1"
                                       value="<?php echo $_SESSION['drugsafe_user']['id']; ?>"/>
                               
                            <?php } ?>

                            <div class=" clienttypeselect col-md-3">
                                <div class="form-group ">
                                    <div id="clientname">
                                        <select class="form-control custom-select" name="szSearch2" id="szSearch2"
                                                onfocus="remove_formError(this.id,'true')"
                                                onchange="getSiteListByClientIdData(this.value,'','<?php echo $_SESSION['drugsafe_user']['id'];?>')">
                                            <option value="">Client Name</option>
                                            <?php
                                            foreach ($clientarr as $clientData) {
                                                $selected = ($clientData['id'] == $_POST['szSearch2'] ? 'selected="selected"' : '');
                                                echo '<option value="' . $clientData['id'] . '"' . $selected . ' >' . $clientData['szName'] . '</option>';
                                            if ($_SESSION['drugsafe_user']['iRole'] == 2) { ?>
                                                <script type="text/javascript">
                                                    setTimeout(function () {
                                                        getSiteListByClientIdData('<?php echo $_POST['szSearch2'];?>', '<?php echo $_POST['szSearch3'];?>', '<?php echo $_SESSION['drugsafe_user']['id'];?>');
                                                    }, 300);

                                                </script>
                                                <?php
                                            }
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
                                </div>
                                <div class="row">
                            <div class="col-md-3 clienttypeselect">

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
                            <div class="col-md-1">
                                <button class="btn green-meadow" type="submit"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
             
                </form>
                   
                    <?php
                    $fromEndDate = form_error('dtEnd');
                    if(($_POST['szSearch1']!='') && ($_POST['szSearch2']!='') && ($_POST['szSearch3']!='')&& ($_POST['dtStart']!='') && ($_POST['dtEnd']!='') && (empty($fromEndDate)))
                    {
                        if (!empty($TestList)) { ?>
                    <div class="portlet-body alert">
                        <div class="row">
                            <div>
                                <div class="portlet green-meadow box">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="fa fa-file-text"></i>SOS-COC Forms Report
                                        </div>

                                    </div>
                                </div>
                                <div class="portlet-body">
                                  
                                        <div class="table-responsive">
                                            <table class="table table-hover table-bordered table-striped">
                                                <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Franchisee Name</th>
                                                    <th>Client Code</th>
                                                    <th>Client Name</th>
                                                    <th>Site</th>
                                                    <th>Test Date</th>
                                                    <th>View SOS Form</th>
                                                    <th>View COC Form</th>
                                                    <th>Lab Advice Form</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                $count = 1;
                                                foreach ($TestList as $testdata){
                                                    
                                                     $franchiseecode = $this->Franchisee_Model->getusercodebyuserid($testdata['clientType']);
                                                    ?>
                                                <tr>
                                                    <td><?php echo $count;?></td>
                                                    <td><?php echo $franchisee['szName'];?></td>
                                                      <td> <?php echo (!empty($franchiseecode['userCode'])?$franchiseecode['userCode']:'N/A'); ?> </td>
                                                    <td><?php echo $Client['szName'];?></td>
                                                    <td><?php echo $Site['szName'];?></td>
                                                    <td><?php echo date('d/m/Y',strtotime($testdata['testdate']));?></td>
                                                    <td>
                                                        <a class="btn btn-circle btn-icon-only btn-default" id="viewsos" title="View SOS Form" onclick="showformdata('<?php echo $testdata['id'];?>','','1');" href="javascript:void(0);">
                                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a class="btn btn-circle btn-icon-only btn-default" id="viewcoc" title="View COC Forms" onclick="showdonorinfo('<?php echo $testdata['id'];?>');" href="javascript:void(0);">
                                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                                        </a>
                                                    </td>
                                                    <td><?php
                                                        if(!empty($testdata['lab_form'])){ ?>
                                                            <a class="btn btn-circle btn-icon-only btn-default" id="viewLAF" href="<?php echo __BASE_UPLOADED_SIGN_URL__.$testdata['lab_form'];?>" target="_blank" title="Download Lab Advice Form">
                                                                <i class="fa fa-download" aria-hidden="true"></i>
                                                            </a>
                                                        <?php }else{
                                                            echo 'N/A';
                                                        }
                                                        ?></td>
                                                </tr>
                                                <?php 
                                                $count++;
                                                }
                                               ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php }
 else {
      echo "<h4>No record found</h4>";
 }
                    }?>
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
<div class="show-stack-modal"></div>
<div class="show-stackonstack-modal"></div>