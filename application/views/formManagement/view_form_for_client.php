<script type='text/javascript'>
    $(function () {
       
        $("#szSearch1").customselect();
        
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
                        <span class="active">SOS-COC Form</span>
                    </li>
                </ul>

                <div class="portlet light bordered about-text" id="user_info">

                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-equalizer font-red-sunglo"></i>
                            <span class="caption-subject font-red-sunglo bold uppercase">
                                   SOS-COC Form 
                                </span>
                        </div>
           
                    </div>


                    <form name="orderSearchForm" id="orderSearchForm"
                          action="<?= __BASE_URL__ ?>/formManagement/view_form_for_client" method="post">
                      
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
                           <div class="col-md-3 clienttypeselect">

                                <div class="form-group ">
                                    <div id="sitename">
                                        <select class="form-control custom-select" name="szSearch1" id="szSearch1"
                                                onfocus="remove_formError(this.id,'true')">
                                            <option value="">Company Name/site</option>
                                            <?php
                                            foreach ($sitesArr as $siteData) {
                                                $selected = ($siteData['id'] == $_POST['szSearch1'] ? 'selected="selected"' : '');
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
                  
                        if (!empty($TestList)) { ?>
                    <div class="portlet-body alert">
                        <div class="row">
                            <div>
                                <div class="portlet green-meadow box">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="fa fa-file-text"></i>SOS-COC Form
                                        </div>

                                    </div>
                                </div>
                                <div class="portlet-body">
                                  
                                        <div class="table-responsive">
                                            <table class="table table-hover table-bordered table-striped">
                                                <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Client Code</th>
                                                    <th>Site</th>
                                                    <th>Test Date</th>
                                                    <th>View SOS Form</th>
                                                    <th>View COC Form</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                $count = 1;
                                                foreach ($TestList as $testdata){
                                                     $SiteDets = $this->Webservices_Model->getuserdetails($testdata['Clientid']);
                                                     $franchiseecode = $this->Franchisee_Model->getusercodebyuserid($testdata['clientType']);
                                                    ?>
                                                <tr>
                                                    <td><?php echo $count;?></td>
                                                      <td> <?php echo (!empty($franchiseecode['userCode'])?$franchiseecode['userCode']:'N/A'); ?> </td>
                                                    <td><?php echo $SiteDets['0']['szName'];?></td>
                                                    <td><?php echo date('d/m/Y',strtotime($testdata['testdate']));?></td>
                                                    <td>
                                                        <a class="btn btn-circle btn-icon-only btn-default" id="viewsos" title="View SOS Form" onclick="showformdata('<?php echo $testdata['id'];?>','1');" href="javascript:void(0);">
                                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a class="btn btn-circle btn-icon-only btn-default" id="viewcoc" title="View COC Forms" onclick="showdonorinfo('<?php echo $testdata['id'];?>');" href="javascript:void(0);">
                                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                                        </a>
                                                    </td>
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
</div>
<div class="show-stack-modal"></div>
<div class="show-stackonstack-modal"></div>