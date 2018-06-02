
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
                        <span class="active">Edit Discount</span>
                    </li>
                </ul>
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-equalizer font-red-sunglo"></i>
                            <span class="caption-subject font-red-sunglo bold uppercase">Edit Discount</span>
                        </div>
                    </div>
                   <div class="portlet-body">
                        <form class="form-horizontal" id="addfranchisee"
                              action="<?= __BASE_URL__ ?>/ordering/editDiscount" name="editDiscount" method="post">
                            <div class="form-body">
                                
                                <div
                                    class="form-group <?php if(form_error('editDiscount[percentage]')){?>has-error<?php }?>">
                                    <label class="col-md-3 control-label"> Discount Percentage</label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-building"></i>
                                                </span>
                                            <input id="szCity" class="form-control read-only" type="text"
                                                   value="<?php echo set_value('editDiscount[percentage]'); ?>"
                                                   placeholder="Discount Percentage" onfocus="remove_formError(this.id,'true')"
                                                   name="editDiscount[percentage]" readonly> 
                                        </div>
                                        <?php
                                            if(form_error('editDiscount[percentage]')){?>
                                            <span class="help-block pull-left"><span><?php echo form_error('editDiscount[percentage]');?></span>
                                            </span><?php }?>
                                    </div>

                                </div>
                                <div class="form-group <?php if(form_error('editDiscount[description]')){?>has-error<?php }?>">
                                        <label class="col-md-3 control-label">Description</label>
                                        <div class="col-md-5">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="fa fa-file-text"></i>
                                                </span>
                                                 <textarea  name="editDiscount[description]" id="description" class="form-control"  value=""  rows="5" placeholder="Description" onfocus="remove_formError(this.id,'true')" ><?php echo set_value('editDiscount[description]'); ?></textarea>
                                              
                                            </div>
                                              <?php
                                            if(form_error('editDiscount[description]')){?>
                                            <span class="help-block pull-left"><span><?php echo form_error('editDiscount[description]');?></span>
                                            </span><?php }?>
                                        </div>
                                    </div>
                            </div>
                            <div class="form-actions">
                                <div class="row">

                                    <div class="col-md-offset-3 col-md-4">
                                        <a href="<?=__BASE_URL__?>/ordering/discountPercentage" class="btn default uppercase" type="button">Cancel</a>
                                        <input type="submit" class="btn green-meadow" value="SAVE"
                                               name="editDiscount[submit]">
                                    </div>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>