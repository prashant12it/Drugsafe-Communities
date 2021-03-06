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
                        <span class="active">Other Revenue stream  </span>
                    </li>
                </ul>

                <div class="portlet light bordered">
                    <?php
                    $DrugtestidArr = array_map('intval', str_split($Drugtestid));
                    if (in_array(1, $DrugtestidArr) || in_array(2, $DrugtestidArr) || in_array(3, $DrugtestidArr) || in_array(4, $DrugtestidArr)|| in_array(5, $DrugtestidArr)) {
                        $countDoner = count($this->Form_Management_Model->getDonarDetailBySosId($sosid));
                        ?>
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-equalizer font-red-sunglo"></i>
                                <span class="caption-subject font-red-sunglo bold uppercase">System Calculation</span>
                            </div>
                            <div class="actions">
                                <a onclick="backSiteRecord('<?php echo $freanchId; ?>')" href="javascript:void(0);"
                                   class=" btn green-meadow">
                                    Back </a>
                            </div>
                        </div>
                        <div class="portlet-body">

                            <div class="row">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                        <tr>
                                            <th>System Calculation</th>
                                            <th> No of Donors</th>
                                            <th> RRP</th>
                                            <th> Value</th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php if (in_array(1, $DrugtestidArr)) { ?>
                                            <tr>
                                                <td>Alcohol</td>
                                                <td> <?php echo $countDoner ?> </td>
                                                <td> $<?php echo number_format(__RRP_1__, 2, '.', ','); ?> </td>
                                                <td> $<?php $Val1 = $countDoner * __RRP_1__;
                                                    echo number_format($Val1, 2, '.', ','); ?>  </td>
                                            </tr>
                                        <?php } ?>
                                        <?php if (in_array(2, $DrugtestidArr)) { ?>
                                            <tr>
                                                <td>Oral Fluid</td>
                                                <td> <?php echo $countDoner ?> </td>
                                                <td> $<?php echo number_format(__RRP_2__, 2, '.', ','); ?> </td>
                                                <td> $<?php $Val2 = $countDoner * __RRP_2__;
                                                    echo number_format($Val2, 2, '.', ','); ?>  </td>
                                            </tr>
                                        <?php } ?>
                                        <?php if (in_array(3, $DrugtestidArr)) { ?>
                                            <tr>
                                                <td>URINE</td>
                                                <td> <?php echo $countDoner ?> </td>
                                                <td> $<?php echo number_format(__RRP_3__, 2, '.', ','); ?> </td>
                                                <td> $<?php $Val3 = $countDoner * __RRP_3__;
                                                    echo number_format($Val3, 2, '.', ','); ?>  </td>

                                            </tr>
                                        <?php } ?>
                                        <?php if (in_array(4, $DrugtestidArr)) { ?>
                                            <tr>
                                                <td>AS/NZA 4308:2008</td>
                                                <td> <?php echo $countDoner ?> </td>
                                                <td> $<?php echo number_format(__RRP_4__, 2, '.', ','); ?> </td>
                                                <td> $<?php $Val4 = $countDoner * __RRP_4__;
                                                    echo number_format($Val4, 2, '.', ','); ?>  </td>

                                            </tr>
                                        <?php } ?>

                                        <tr>
                                            <td colspan="3">Total</td>

                                            <td>$<?php $ValTotal = $Val1 + $Val2 + $Val3 + $Val4;
                                                echo number_format($ValTotal, 2, '.', ','); ?> </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">Royalty fees</td>

                                            <td>$<?php $Royaltyfees = $ValTotal * 0.1;
                                                echo number_format($Royaltyfees, 2, '.', ','); ?> </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">GST</td>

                                            <td>$<?php $GST = $ValTotal * 0.1;
                                                echo number_format($GST, 2, '.', ','); ?> </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">Total before Royalty and Inc GST</td>

                                            <td>$<?php $TotalbeforeRoyalty = $ValTotal + $GST;
                                                echo number_format($TotalbeforeRoyalty, 2, '.', ','); ?> </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">Total after royalty and Inc GST</td>

                                            <td>$<?php $TotalafterRoyalty = $ValTotal - $Royaltyfees + $GST;
                                                echo number_format($TotalafterRoyalty, 2, '.', ','); ?> </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">Net Total after royalty and exl GST</td>

                                            <td>$<?php $NetTotal = $ValTotal - $Royaltyfees;
                                                echo number_format($NetTotal, 2, '.', ','); ?> </td>
                                        </tr>


                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                        <?php
                    }

                    // if(in_array(4, $DrugtestidArr)||in_array(5, $DrugtestidArr)){
                    ?>


                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-equalizer font-red-sunglo"></i>
                            <span class="caption-subject font-red-sunglo bold uppercase">Other Revenue stream (Manual Entry)</span>
                        </div>
                        <div class="actions">
                            <div class="btn-group btn-group-devided" data-toggle="buttons">
                            </div>
                        </div>
                    </div>


                    <div class="portlet-body">
                        <form class="form-horizontal" id="orderingData"
                              action="<?php echo __BASE_URL__ ?>/ordering/calform" name="orderingData" method="post">
                            <div class="form-body">
                                <input type="hidden" name="orderingData[OtherDrugOpt]" value="0" />
                                <input type="hidden" name="orderingData[OtherDrugName]" value="<?php echo $sosData[0]['other_drug_test'];?>" />
                                <?php if(in_array(5, $DrugtestidArr)){?>
                                    <input type="hidden" name="orderingData[OtherDrugOpt]" value="1" />
                                    <input type="hidden" name="orderingData[OtherDrugName]" value="" />
                                    <div class="portlet-title">
                                        <div class="caption">

                                            <span class="caption-subject font-red-sunglo bold uppercase">Other Drug Value</span>
                                        </div>
                                        <div class="actions">
                                            <div class="btn-group btn-group-devided" data-toggle="buttons">
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group <?php if (form_error('orderingData[OtherDrugRRPValue]')) { ?>has-error<?php } ?>">
                                        <label class="col-md-4 control-label">RRP for <b>"<?php echo $sosData[0]['other_drug_test'];?>"</b></label>
                                        <div class="col-md-5">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-dollar"></i>
                                                </span>
                                                <input id="OtherDrugRRPValue" class="form-control" type="text"
                                                       value="<?php echo set_value('orderingData[OtherDrugRRPValue]'); ?>"
                                                       placeholder="RRP" onfocus="remove_formError(this.id,'true')"
                                                       name="orderingData[OtherDrugRRPValue]"
                                                       onkeyup="calOtherDrugPrice(this,'<?php echo $countDoner;?>');">
                                            </div>
                                            <?php
                                            if (form_error('orderingData[OtherDrugRRPValue]')) {
                                                ?>
                                                <span class="help-block pull-left">
                                                <span><?php echo form_error('orderingData[OtherDrugRRPValue]'); ?></span>
                                                </span><?php } ?>
                                        </div>

                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label font-green-meadow text "><b>Value</b> </label>
                                        <div class="col-md-5">
                                            <div class="input-group">
                                                <label class="col-md-4 control-label" id="otherdrugVal"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                <?php }?>
                                <div class="portlet-title">
                                    <div class="caption">

                                        <span class="caption-subject font-red-sunglo bold uppercase">On Site Testing</span>
                                    </div>
                                    <div class="actions">
                                        <div class="btn-group btn-group-devided" data-toggle="buttons">
                                        </div>
                                    </div>
                                </div>

                                <hr>
                                <div class="text align-center font-green-meadow">
                                    Single Field Collection Officer (FCO)
                                </div>
                                <hr>
                                <div class="form-group <?php if (form_error('orderingData[FCOBasePrice]')) { ?>has-error<?php } ?>">
                                    <label class="col-md-4 control-label">Base Price (BP/hr)</label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-dollar"></i>
                                                </span>
                                            <input id="FCOBasePrice" class="form-control" type="text"
                                                   value="<?php echo set_value('orderingData[FCOBasePrice]'); ?>"
                                                   placeholder="Base Price " onfocus="remove_formError(this.id,'true')"
                                                   name="orderingData[FCOBasePrice]"
                                                   onblur="calcombinetotalprice('FCOBasePrice','FCOHr',2,'FCOTotal')">
                                        </div>
                                        <?php
                                        if (form_error('orderingData[FCOBasePrice]')) {
                                            ?>
                                            <span class="help-block pull-left">
                                            <span><?php echo form_error('orderingData[FCOBasePrice]'); ?></span>
                                            </span><?php } ?>
                                    </div>

                                </div>
                                <div class="form-group <?php if (form_error('orderingData[FCOHr]')) { ?>has-error<?php } ?>">
                                    <label class="col-md-4 control-label ">Hours </label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                                </span>
                                            <input id="FCOHr" class="form-control" type="text"
                                                   value="<?php echo set_value('orderingData[FCOHr]'); ?>"
                                                   onblur="calcombinetotalprice('FCOBasePrice','FCOHr',2,'FCOTotal')"
                                                   placeholder=" Hours " onfocus="remove_formError(this.id,'true')"
                                                   name="orderingData[FCOHr]">
                                        </div>
                                        <?php
                                        if (form_error('orderingData[FCOHr]')) {
                                            ?>
                                            <span class="help-block pull-left">
                                            <span><?php echo form_error('orderingData[FCOHr]'); ?></span>
                                            </span><?php } ?>
                                    </div>
                                </div>
                                <div class="form-group <?php if (form_error('orderingData[FCOTotal]')) { ?>has-error<?php } ?>">
                                    <label class="col-md-4 control-label font-green-meadow text "><b>Total</b> </label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <label class="col-md-4 control-label" id="FCOTotal" value=" "
                                                   name="orderingData[FCOTotal]"></label>

                                        </div>
                                        <?php
                                        if (form_error('orderingData[FCOTotal]')) {
                                            ?>
                                            <span class="help-block pull-left">
                                            <span><?php echo form_error('orderingData[FCOTotal]'); ?></span>
                                            </span><?php } ?>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group <?php if (form_error('orderingData[SyntheticCannabinoids]')) { ?>has-error<?php } ?>">
                                    <label class="col-md-4 control-label"> Synthetic Cannabinoids screening</label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-dollar"></i>
                                                </span>
                                            <input id="SyntheticCannabinoids" class="form-control" type="text"
                                                   value="<?php echo set_value('orderingData[SyntheticCannabinoids]'); ?>"
                                                   placeholder="Synthetic Cannabinoids screening"
                                                   onfocus="remove_formError(this.id,'true')"
                                                   name="orderingData[SyntheticCannabinoids]">
                                        </div>
                                        <?php
                                        if (form_error('orderingData[SyntheticCannabinoids]')) {
                                            ?>
                                            <span class="help-block pull-left">
                                            <span><?php echo form_error('orderingData[SyntheticCannabinoids]'); ?></span>
                                            </span><?php } ?>

                                    </div>
                                </div>
                                <hr>
                                <div class="text align-center font-green-meadow">
                                    Mobile Clinic
                                </div>
                                <hr>
                                <div class="form-group <?php if (form_error('orderingData[mobileScreenBasePrice]')) { ?>has-error<?php } ?>">
                                    <label class="col-md-4 control-label">Base Price (BP/hr)</label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-dollar"></i>
                                                </span>
                                            <input id="mobileScreenBasePrice" class="form-control" type="text"
                                                   value="<?php echo set_value('orderingData[mobileScreenBasePrice]'); ?>"
                                                   placeholder="Base Price " onfocus="remove_formError(this.id,'true')"
                                                   name="orderingData[mobileScreenBasePrice]"
                                                   onblur="calcombinetotalprice('mobileScreenBasePrice','mobileScreenHr',1,'mobileScreen');">
                                        </div>
                                        <?php
                                        if (form_error('orderingData[mobileScreenBasePrice]')) {
                                            ?>
                                            <span class="help-block pull-left">
                                            <span><?php echo form_error('orderingData[mobileScreenBasePrice]'); ?></span>
                                            </span><?php } ?>
                                    </div>

                                </div>
                                <div class="form-group <?php if (form_error('orderingData[mobileScreenHr]')) { ?>has-error<?php } ?>">
                                    <label class="col-md-4 control-label ">Hours </label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                                </span>
                                            <input id="mobileScreenHr" class="form-control" type="text"
                                                   value="<?php echo set_value('orderingData[mobileScreenHr]'); ?>"
                                                   onblur="calcombinetotalprice('mobileScreenBasePrice','mobileScreenHr',1,'mobileScreen');"
                                                   placeholder=" Hours " onfocus="remove_formError(this.id,'true')"
                                                   name="orderingData[mobileScreenHr]">
                                        </div>
                                        <?php
                                        if (form_error('orderingData[mobileScreenHr]')) {
                                            ?>
                                            <span class="help-block pull-left">
                                            <span><?php echo form_error('orderingData[mobileScreenHr]'); ?></span>
                                            </span><?php } ?>
                                    </div>
                                </div>
                                <div class="form-group <?php if (form_error('orderingData[mobileScreen]')) { ?>has-error<?php } ?>">
                                    <label class="col-md-4 control-label font-green-meadow text "><b>Total</b> </label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <label class="col-md-4 control-label" id="mobileScreen" value=" "
                                                   name="orderingData[mobileScreen]"></label>
                                        </div>
                                        <?php
                                        if (form_error('orderingData[mobileScreen]')) {
                                            ?>
                                            <span class="help-block pull-left">
                                            <span><?php echo form_error('orderingData[mobileScreen]'); ?></span>
                                            </span><?php } ?>
                                    </div>
                                </div>
                                <hr>
                                <div class="text align-center font-green-meadow">
                                    Call Out (including an alcohol & drug screen)
                                </div>
                                <hr>
                                <div class="form-group <?php if (form_error('orderingData[CallOutBasePrice]')) { ?>has-error<?php } ?>">
                                    <label class="col-md-4 control-label">Base Price (BP/hr)</label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-dollar"></i>
                                                </span>
                                            <input id="CallOutBasePrice" class="form-control" type="text"
                                                   value="<?php echo set_value('orderingData[CallOutBasePrice]'); ?>"
                                                   placeholder="Base Price " onfocus="remove_formError(this.id,'true')"
                                                   name="orderingData[CallOutBasePrice]"
                                                   onblur="calcombinetotalprice('CallOutBasePrice','CallOutHr',1,'CallOutTotal');">
                                        </div>
                                        <?php
                                        if (form_error('orderingData[CallOutBasePrice]')) {
                                            ?>
                                            <span class="help-block pull-left">
                                            <span><?php echo form_error('orderingData[CallOutBasePrice]'); ?></span>
                                            </span><?php } ?>
                                    </div>

                                </div>
                                <div class="form-group <?php if (form_error('orderingData[CallOutHr]')) { ?>has-error<?php } ?>">
                                    <label class="col-md-4 control-label ">Hours </label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                                </span>
                                            <input id="CallOutHr" class="form-control" type="text"
                                                   value="<?php echo set_value('orderingData[CallOutHr]'); ?>"
                                                   onblur="calcombinetotalprice('CallOutBasePrice','CallOutHr',1,'CallOutTotal');"
                                                   placeholder=" Hours " onfocus="remove_formError(this.id,'true')"
                                                   name="orderingData[CallOutHr]">
                                        </div>
                                        <?php
                                        if (form_error('orderingData[CallOutHr]')) {
                                            ?>
                                            <span class="help-block pull-left">
                                            <span><?php echo form_error('orderingData[CallOutHr]'); ?></span>
                                            </span><?php } ?>
                                    </div>
                                </div>
                                <div class="form-group <?php if (form_error('orderingData[CallOutTotal]')) { ?>has-error<?php } ?>">
                                    <label class="col-md-4 control-label font-green-meadow text "><b>Total</b> </label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <label class="col-md-4 control-label" id="CallOutTotal" value=" "
                                                   name="orderingData[CallOutTotal]"></label>

                                        </div>
                                        <?php
                                        if (form_error('orderingData[CallOutTotal]')) {
                                            ?>
                                            <span class="help-block pull-left">
                                            <span><?php echo form_error('orderingData[CallOutTotal]'); ?></span>
                                            </span><?php } ?>
                                    </div>
                                </div>
                                <hr>
                                <div class="portlet-title">
                                    <div class="caption">
                                        <span class="caption-subject font-red-sunglo bold uppercase">Laboratory Testing</span>
                                    </div>

                                </div>
                                <hr>
                                <div class="form-group <?php if (form_error('orderingData[urineNata]')) { ?>has-error<?php } ?>">
                                    <label class="col-md-4 control-label"> Urine NATA Laboratory screening</label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-dollar"></i>
                                                </span>
                                            <input id="urineNata" class="form-control" type="text"
                                                   value="<?php echo set_value('orderingData[urineNata]'); ?>"
                                                   placeholder="Urine NATA Laboratory screening"
                                                   onfocus="remove_formError(this.id,'true')"
                                                   name="orderingData[urineNata]">
                                        </div>
                                        <?php
                                        if (form_error('orderingData[urineNata]')) {
                                            ?>
                                            <span class="help-block pull-left">
                                            <span><?php echo form_error('orderingData[urineNata]'); ?></span>
                                            </span><?php } ?>

                                    </div>
                                </div>

                                <div class="form-group <?php if (form_error('orderingData[nataLabCnfrm]')) { ?>has-error<?php } ?>">
                                    <label class="col-md-4 control-label"> NATA Laboratory confirmation </label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-dollar"></i>
                                                </span>
                                            <input id="nataLabCnfrm" class="form-control" type="text"
                                                   value="<?php echo set_value('orderingData[nataLabCnfrm]'); ?>"
                                                   placeholder="NATA Laboratory confirmation"
                                                   onfocus="remove_formError(this.id,'true')"
                                                   name="orderingData[nataLabCnfrm]">
                                        </div>
                                        <?php
                                        if (form_error('orderingData[nataLabCnfrm]')) {
                                            ?>
                                            <span class="help-block pull-left">
                                            <span><?php echo form_error('orderingData[nataLabCnfrm]'); ?></span>
                                            </span><?php } ?>
                                    </div>
                                </div>
                                <div class="form-group <?php if (form_error('orderingData[oralFluidNata]')) { ?>has-error<?php } ?>">
                                    <label class="col-md-4 control-label"> Oral Fluid NATA Laboratory
                                        confirmation </label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-dollar"></i>
                                                </span>
                                            <input id="oralFluidNata" class="form-control" type="text"
                                                   value="<?php echo set_value('orderingData[oralFluidNata]'); ?>"
                                                   placeholder="Oral Fluid NATA Laboratory confirmation"
                                                   onfocus="remove_formError(this.id,'true')"
                                                   name="orderingData[oralFluidNata]">
                                        </div>
                                        <?php
                                        if (form_error('orderingData[oralFluidNata]')) {
                                            ?>
                                            <span class="help-block pull-left">
                                            <span><?php echo form_error('orderingData[oralFluidNata]'); ?></span>
                                            </span><?php } ?>
                                    </div>
                                </div>
                                <hr>
                                <div class="text align-center font-green-meadow">
                                    Synthetic Cannabinoids or Designer Drugs, per sample.
                                </div>
                                <hr>
                                <div class="form-group <?php if (form_error('orderingData[laboratoryScreening]')) { ?>has-error<?php } ?>">
                                    <label class="col-md-4 control-label"> Laboratory screening </label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-dollar"></i>
                                                </span>
                                            <input id="laboratoryScreening" class="form-control" type="text"
                                                   value="<?php echo set_value('orderingData[laboratoryScreening]'); ?>"
                                                   placeholder="Laboratory Screening"
                                                   onfocus="remove_formError(this.id,'true')"
                                                   name="orderingData[laboratoryScreening]">
                                        </div>
                                        <?php
                                        if (form_error('orderingData[laboratoryScreening]')) {
                                            ?>
                                            <span class="help-block pull-left">
                                            <span><?php echo form_error('orderingData[laboratoryScreening]'); ?></span>
                                            </span><?php } ?>
                                    </div>
                                </div>

                                <div class="form-group <?php if (form_error('orderingData[laboratoryConfirmation]')) { ?>has-error<?php } ?>">
                                    <label class="col-md-4 control-label">Laboratory confirmation</label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-dollar"></i>
                                                </span>
                                            <input id="laboratoryConfirmation" class="form-control" type="text"
                                                   value="<?php echo set_value('orderingData[laboratoryConfirmation]'); ?>"
                                                   placeholder="Laboratory Confirmation"
                                                   onfocus="remove_formError(this.id,'true')"
                                                   name="orderingData[laboratoryConfirmation]">
                                        </div>
                                        <?php
                                        if (form_error('orderingData[laboratoryConfirmation]')) {
                                            ?>
                                            <span class="help-block pull-left">
                                            <span><?php echo form_error('orderingData[laboratoryConfirmation]'); ?></span>
                                            </span><?php } ?>
                                    </div>
                                </div>
                                <hr>
                                <div class="portlet-title">
                                    <div class="caption">
                                        <span class="caption-subject font-red-sunglo bold uppercase">Other testing services</span>
                                    </div>

                                </div>
                                <hr>
                                <div class="form-group <?php if (form_error('orderingData[RtwScrenning]')) { ?>has-error<?php } ?>">
                                    <label class="col-md-4 control-label">Return to work (RTW) screening</label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-dollar"></i>
                                                </span>
                                            <input id="RtwScrenning" class="form-control" type="text"
                                                   value="<?php echo set_value('orderingData[RtwScrenning]'); ?>"
                                                   placeholder="Return to work screening"
                                                   onfocus="remove_formError(this.id,'true')"
                                                   name="orderingData[RtwScrenning]">
                                        </div>
                                        <?php
                                        if (form_error('orderingData[RtwScrenning]')) {
                                            ?>
                                            <span class="help-block pull-left">
                                            <span><?php echo form_error('orderingData[RtwScrenning]'); ?></span>
                                            </span><?php } ?>
                                    </div>
                                </div>

                                <hr>
                                <div class="text align-center font-green-meadow">
                                    Drugsafe Communities mobile clinic screening
                                </div>
                                <hr>

                                <div class="form-group <?php if (form_error('orderingData[DCmobileScreenBasePrice]')) { ?>has-error<?php } ?>">
                                    <label class="col-md-4 control-label">Base Price (BP/hr)</label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-dollar"></i>
                                                </span>
                                            <input id="DCmobileScreenBasePrice" class="form-control" type="text"
                                                   value="<?php echo set_value('orderingData[DCmobileScreenBasePrice]'); ?>"
                                                   placeholder="Base Price " onfocus="remove_formError(this.id,'true')"
                                                   name="orderingData[DCmobileScreenBasePrice]"
                                                   onblur="calcombinetotalprice('DCmobileScreenBasePrice','DCmobileScreenHr',1,'DCmobileScreenTotal');">
                                        </div>
                                        <?php
                                        if (form_error('orderingData[DCmobileScreenBasePrice]')) {
                                            ?>
                                            <span class="help-block pull-left">
                                            <span><?php echo form_error('orderingData[DCmobileScreenBasePrice]'); ?></span>
                                            </span><?php } ?>
                                    </div>

                                </div>
                                <div class="form-group <?php if (form_error('orderingData[DCmobileScreenHr]')) { ?>has-error<?php } ?>">
                                    <label class="col-md-4 control-label ">Hours </label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                                </span>
                                            <input id="DCmobileScreenHr" class="form-control" type="text"
                                                   value="<?php echo set_value('orderingData[DCmobileScreenHr]'); ?>"
                                                   onblur="calcombinetotalprice('DCmobileScreenBasePrice','DCmobileScreenHr',1,'DCmobileScreenTotal');"
                                                   placeholder=" Hours " onfocus="remove_formError(this.id,'true')"
                                                   name="orderingData[DCmobileScreenHr]">
                                        </div>
                                        <?php
                                        if (form_error('orderingData[DCmobileScreenHr]')) {
                                            ?>
                                            <span class="help-block pull-left">
                                            <span><?php echo form_error('orderingData[DCmobileScreenHr]'); ?></span>
                                            </span><?php } ?>
                                    </div>
                                </div>
                                <div class="form-group <?php if (form_error('orderingData[DCmobileScreenTotal]')) { ?>has-error<?php } ?>">
                                    <label class="col-md-4 control-label font-green-meadow text "><b>Total</b> </label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <label class="col-md-4 control-label" id="DCmobileScreenTotal" value=" "
                                                   name="orderingData[DCmobileScreenTotal]"></label>

                                        </div>
                                        <?php
                                        if (form_error('orderingData[DCmobileScreenTotal]')) {
                                            ?>
                                            <span class="help-block pull-left">
                                            <span><?php echo form_error('orderingData[DCmobileScreenTotal]'); ?></span>
                                            </span><?php } ?>
                                    </div>
                                </div>
                                <hr>
                                <div class="text align-center font-green-meadow">
                                    Travel
                                </div>
                                <hr>


                                <div class="form-group <?php if (form_error('orderingData[travelType]')) { ?>has-error<?php } ?>">
                                    <label class="col-md-4 control-label">Base Price (BP/hr)</label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-truck"></i>
                                                </span>
                                            <select class="form-control " name="orderingData[travelType]"
                                                    id="travelType"
                                                    Placeholder="Travel" onfocus="remove_formError(this.id,'true')"
                                                    onchange="showHideTextboxForCalc()">
                                                <option value=''>Select</option>

                                                <option value="1" <?php echo(sanitize_post_field_value($_POST['orderingData']['travelType']) == "1" ? "selected" : ""); ?>>
                                                    When >100km return trip from DSC base.
                                                </option>
                                                <option value="2" <?php echo(sanitize_post_field_value($_POST['orderingData']['travelType']) == "2" ? "selected" : ""); ?>>
                                                    When >100km return trip from MC base. Includes tester.
                                                </option>


                                            </select>
                                        </div>
                                        <?php
                                        if (form_error('orderingData[travelType]')) {
                                            ?>
                                            <span class="help-block pull-left">
                                            <span><?php echo form_error('orderingData[travelType]'); ?></span>
                                            </span><?php } ?>
                                    </div>
                                </div>
                                <div class="text" id="text"
                                    <?php
                                    if ($_POST['orderingData']['travelType'] == "") {
                                        ?>
                                        style="display:none;"
                                        <?php
                                    }
                                    ?>
                                >
                                    <div class="form-group <?php if (form_error('orderingData[travelBasePrice]')) { ?>has-error<?php } ?>">
                                        <label class="col-md-4 control-label ">Base Price </label>
                                        <div class="col-md-5">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-dollar"></i>
                                                </span>
                                                <input id="travelBasePrice" class="form-control" type="text"
                                                       value="<?php echo set_value('orderingData[travelBasePrice]'); ?>"
                                                       onblur="calcombinetotalprice('travelBasePrice','travelHr',1,'travel');"
                                                       placeholder=" Base Price "
                                                       onfocus="remove_formError(this.id,'true')"
                                                       name="orderingData[travelBasePrice]">
                                            </div>
                                            <?php
                                            if (form_error('orderingData[travelBasePrice]')) {
                                                ?>
                                                <span class="help-block pull-left">
                                                <span><?php echo form_error('orderingData[travelBasePrice]'); ?></span>
                                                </span><?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group <?php if (form_error('orderingData[travelHr]')) { ?>has-error<?php } ?>">
                                    <label class="col-md-4 control-label ">Hours </label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                                </span>
                                            <input id="travelHr" class="form-control" type="text"
                                                   value="<?php echo set_value('orderingData[travelHr]'); ?>"
                                                   onblur="calcombinetotalprice('travelBasePrice','travelHr',1,'travel');"
                                                   placeholder=" Hours " onfocus="remove_formError(this.id,'true')"
                                                   name="orderingData[travelHr]">
                                        </div>
                                        <?php
                                        if (form_error('orderingData[travelHr]')) {
                                            ?>
                                            <span class="help-block pull-left">
                                            <span><?php echo form_error('orderingData[travelHr]'); ?></span>
                                            </span><?php } ?>
                                    </div>
                                </div>
                                <div class="form-group <?php if (form_error('orderingData[travel]')) { ?>has-error<?php } ?>">
                                    <label class="col-md-4 control-label font-green-meadow text "><b>Total</b> </label>
                                    <div class="col-md-5">
                                        <div class="input-group">

                                            <label class="col-md-4 control-label  " id="travel" value=""
                                                   name="orderingData[travel]"></label>

                                        </div>
                                        <?php
                                        if (form_error('orderingData[travel]')) {
                                            ?>
                                            <span class="help-block pull-left">
                                            <span><?php echo form_error('orderingData[travel]'); ?></span>
                                            </span><?php } ?>
                                    </div>
                                    <input id="sosid" class="form-control" type="hidden" value="<?php echo $sosid ?>"
                                           name="orderingData[sosid]">
                                </div>
                                <hr>
                                <div class="form-group <?php if (form_error('orderingData[cancellationFee]')) { ?>has-error<?php } ?>">
                                    <label class="col-md-4 control-label">Cancellation Fee</label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-dollar"></i>
                                                </span>
                                            <input id="cancellationFee" class="form-control" type="text"
                                                   value="<?php echo set_value('orderingData[cancellationFee]'); ?>"
                                                   placeholder="Cancellation Fee"
                                                   onfocus="remove_formError(this.id,'true')"
                                                   name="orderingData[cancellationFee]">
                                        </div>
                                        <?php
                                        if (form_error('orderingData[cancellationFee]')) {
                                            ?>
                                            <span class="help-block pull-left">
                                            <span><?php echo form_error('orderingData[cancellationFee]'); ?></span>
                                            </span><?php } ?>
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-4">
                                            <a href="<?php echo __BASE_URL__; ?>/ordering/sitesRecord"
                                               class="btn default uppercase"
                                               type="button">Cancel</a>
                                            <input type="submit" class="btn green-meadow" value="SAVE"
                                                   name="orderingData[submit]">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <?php // }?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>