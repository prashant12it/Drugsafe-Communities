
    <div class="page-content-wrapper">
    <div class="page-content">
        <div id="page_content" class="row">

            <div class="col-md-12">
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <a href="<?php echo __BASE_URL__; ?>">Home</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <span class="active">Add Region</span>
                    </li>
                </ul>
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-equalizer font-red-sunglo"></i>
                            <span class="caption-subject font-red-sunglo bold uppercase">Add Region</span>
                        </div>
                         <div class="actions">
                        <a href="<?php echo __BASE_URL__;?>/admin/regionManagerList"
                                   class=" btn green-meadow">
                                Back </a>
                              </div>
                    </div>
                   <div class="portlet-body">
                        <form class="form-horizontal" id="addfranchisee"
                              action="<?= __BASE_URL__ ?>/admin/addRegion" name="addRegion" method="post">
                            <div class="form-body">
                                <div
                                    class="form-group <?php if(form_error('addRegion[szState]')){?>has-error<?php }?>">
                                    <label class="col-md-3 control-label">State</label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-flag-checkered"></i>
                                                </span>
                                            <select class="form-control " name="addRegion[szState]" id="szState"
                                                    Placeholder="State" onfocus="remove_formError(this.id,'true')" onchange="addRegionCode(this.value);">
                                                <option value=''>Select</option>
                                                 <?php
                                                if(!empty($getAllStates))
                                                {
                                                    foreach($getAllStates as $getAllStatesData)
                                                    {
                                                        $selected = ($getAllStatesData['id'] == $_POST['addRegion']['szState'] ? 'selected="selected"' : '');
                                                        echo '<option value="'.$getAllStatesData['id'].'"' . $selected . ' >'.$getAllStatesData['name'].'</option>';
                                                    } 
                                                } 
                                            ?>
                                            </select>
                                        </div>
                                        <?php
                                            if(form_error('addRegion[szState]')){?>
                                            <span class="help-block pull-left"><span><?php echo form_error('addRegion[szState]');?></span>
                                            </span><?php }?>
                                    </div>

                                </div>
                                <div id="Region">
                                <div
                                    class="form-group">
                                    <label class="col-md-3 control-label">Region Code</label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-area-chart"></i>
                                                </span>
                                            <input id="iRegionCode" class="form-control" type="text"
                                                   value="<?php echo $_POST['addRegion']['iRegionCode']; ?>"
                                                   placeholder="Region Code"
                                                   onfocus="remove_formError(this.id,'true')"
                                                   name="addRegion[iRegionCode]" readonly>
                                        </div>
                                    </div>
                                </div>
                                </div>
                                <div
                                    class="form-group <?php if(form_error('addRegion[szRegionName]')){?>has-error<?php }?>">
                                    <label class="col-md-3 control-label"> Region Name</label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-building"></i>
                                                </span>
                                            <input id="szCity" class="form-control" type="text"
                                                   value="<?php echo $_POST['addRegion']['szRegionName']; ?>"
                                                   placeholder="Region Name" onfocus="remove_formError(this.id,'true')"
                                                   name="addRegion[szRegionName]"> 
                                        </div>
                                        <?php
                                            if(form_error('addRegion[szRegionName]')){?>
                                            <span class="help-block pull-left"><span><?php echo form_error('addRegion[szRegionName]');?></span>
                                            </span><?php }?>
                                    </div>

                                </div>
                                
                            </div>
                            <div class="form-actions">
                                <div class="row">

                                    <div class="col-md-offset-3 col-md-4">
                                        <a href="<?=__BASE_URL__?>/admin/regionManagerList" class="btn default uppercase" type="button">Cancel</a>
                                        <input type="submit" class="btn green-meadow" value="SAVE"
                                               name="addRegion[submit]">
                                    </div>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>