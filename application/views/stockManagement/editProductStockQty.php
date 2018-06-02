<div class="page-content-wrapper">
    <div class="page-content">
        <ul class="page-breadcrumb breadcrumb">

            <li>
                <a href="<?php echo __BASE_URL__; ?>/admin/franchiseeList">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a onclick="viewClient(<?php echo $franchiseeArr['id']; ?>);"
                   href="javascript:void(0);"><?php echo $franchiseeArr['szName']; ?></a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a onclick="#" href="javascript:void(0);"><?php echo $productDataAry['szProductCode']; ?></a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span class="active">Model Stock Value Management</span>
            </li>
        </ul>
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-equalizer font-red-sunglo"></i>&nbsp; &nbsp;
                            <span
                                class="caption-subject  bold uppercase font-red-sunglo">Edit Product Stock Quantity</span>
                        </div>
                        <div class="tools">
                            <a href="javascript:;" class="collapse"></a>
                        </div>
                    </div>


                    <div class="portlet-body form">
                        <!-- BEGIN FORM-->
                        <form action="" id="editProductStockQty" name="editProductStockQty" method="post"
                              class="form-horizontal form-row-sepe">
                            <div class="form-body">
                                <div
                                    class="form-group <?php if (form_error('editProductStockQty[szName]')) { ?>has-error<?php } ?>">
                                    <label class="control-label col-md-3">Product Category</label>
                                    <div class="col-md-4">
                                        <input id="szName" class="form-control input-large select2me read-only"
                                               type="text" readonly
                                               value="<?php echo set_value('editProductStockQty[szName]'); ?>"
                                               placeholder="Category" onfocus="remove_formError(this.id,'true')"
                                               name="editProductStockQty[szName]">
                                        <?php
                                        if (form_error('editProductStockQty[szName]')) {
                                            ?>
                                            <span class="help-block pull-left">
                                            <span><?php echo form_error('editProductStockQty[szName]'); ?></span>
                                            </span><?php } ?>
                                    </div>
                                </div>
                                <div
                                    class="form-group <?php if (form_error('editProductStockQty[szProductCode]')) { ?>has-error<?php } ?>">
                                    <label class="control-label col-md-3">Product</label>
                                    <div class="col-md-4">
                                        <div id="product_container">
                                            <input id="szProductCode"
                                                   class="form-control input-large select2me read-only" readonly
                                                   type="text"
                                                   value="<?php echo set_value('editProductStockQty[szProductCode]'); ?>"
                                                   placeholder="Product Code" onfocus="remove_formError(this.id,'true')"
                                                   name="editProductStockQty[szProductCode]">
                                        </div>

                                        <?php
                                        if (form_error('editProductStockQty[szProductCode]')) {
                                            ?>
                                            <span class="help-block pull-left">
                                            <span><?php echo form_error('editProductStockQty[szProductCode]'); ?></span>
                                            </span><?php } ?>
                                    </div>
                                </div>
                                <?php
                                if (!empty($flag)) {
                                    if ($flag == 1) {
                                        ?>
                                        <div
                                            class="form-group <?php if (form_error('editProductStockQty[szQuantity]')) { ?>has-error<?php } ?>">
                                            <label class="control-label col-md-3">Available Quantity</label>
                                            <div class="col-md-4">
                                                <div class="input-group">
                                                    <input id="szQuantity"
                                                           class="form-control input-large select2me read-only"
                                                           type="text" readonly
                                                           value="<?php echo set_value('editProductStockQty[szQuantity]'); ?>"
                                                           placeholder="Product Quantity"
                                                           onfocus="remove_formError(this.id,'true')"
                                                           name="editProductStockQty[szQuantity]">
                                                </div>
                                                <?php
                                                if (form_error('editProductStockQty[szQuantity]')) {
                                                    ?>
                                                    <span class="help-block pull-left">
                                                    <span><?php echo form_error('editProductStockQty[szQuantity]'); ?></span>
                                                    </span><?php } ?>
                                            </div>
                                        </div>
                                        <div
                                            class="form-group <?php if (form_error('editProductStockQty[szAdjustQuantity]')) { ?>has-error<?php } ?>">
                                            <label class="control-label col-md-3">Subtract Quantity</label>
                                            <div class="col-md-4">
                                                <div class="input-group">
                                                    <input id="szAdjustQuantity"
                                                           class="form-control input-large select2me " type="text"
                                                           value="<?php echo set_value('editProductStockQty[szAdjustQuantity]'); ?>"
                                                           placeholder="Subtract Quantity"
                                                           onfocus="remove_formError(this.id,'true')"
                                                           name="editProductStockQty[szAdjustQuantity]">
                                                </div>
                                                <?php
                                                if (form_error('editProductStockQty[szAdjustQuantity]')) {
                                                    ?>
                                                    <span class="help-block pull-left">
                                                    <span><?php echo form_error('editProductStockQty[szAdjustQuantity]'); ?></span>
                                                    </span><?php } ?>
                                            </div>
                                        </div>
                                    <?php } else { ?>
                                        <div
                                            class="form-group <?php if (form_error('editProductStockQty[szQuantity]')) { ?>has-error<?php } ?>">
                                            <label class="control-label col-md-3">Available Quantity</label>
                                            <div class="col-md-4">
                                                <div class="input-group">
                                                    <input id="szQuantity"
                                                           class="form-control input-large select2me read-only"
                                                           type="text" readonly
                                                           value="<?php echo set_value('editProductStockQty[szQuantity]'); ?>"
                                                           placeholder="Product Quantity"
                                                           onfocus="remove_formError(this.id,'true')"
                                                           name="editProductStockQty[szQuantity]">
                                                </div>
                                                <?php
                                                if (form_error('editProductStockQty[szQuantity]')) {
                                                    ?>
                                                    <span class="help-block pull-left">
                                                    <span><?php echo form_error('editProductStockQty[szQuantity]'); ?></span>
                                                    </span><?php } ?>
                                            </div>
                                        </div>
                                        <?php if (!empty($qtyrequested[0]['szQuantity']) && ($qtyrequested[0]['szQuantity'] > 0)) { ?>
                                            <div
                                                class="form-group <?php if (form_error('editProductStockQty[szQuantity]')) { ?>has-error<?php } ?>">
                                                <div class="col-md-3"></div>
                                                <div class="col-md-4 text-danger">
                                                    You have allotted
                                                    <b><?php echo $assignqty; ?></b> quantity for this product out
                                                    of
                                                    <b><?php echo $qtyrequested[0]['szQuantity']; ?></b> requested
                                                    quantity by this franchisee.
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <div
                                            class="form-group <?php if (form_error('editProductStockQty[szAddMoreQuantity]')) { ?>has-error<?php } ?>">
                                            <label class="control-label col-md-3">Add More Quantity</label>
                                            <div class="col-md-4">
                                                <div class="input-group">
                                                    <input id="szAddMoreQuantity"
                                                           class="form-control input-large select2me" type="text"
                                                           value="<?php echo set_value('editProductStockQty[szAddMoreQuantity]'); ?>"
                                                           placeholder="Add More Quantity"
                                                           onfocus="remove_formError(this.id,'true')"
                                                           name="editProductStockQty[szAddMoreQuantity]">
                                                </div>
                                                <?php
                                                if (form_error('editProductStockQty[szAddMoreQuantity]')) {
                                                    ?>
                                                    <span class="help-block pull-left">
                                                    <span><?php echo form_error('editProductStockQty[szAddMoreQuantity]'); ?></span>
                                                    </span><?php } ?>
                                            </div>
                                        </div>
                                    <?php }

                                } ?>

                                <div class="row">
                                    <div class="col-md-offset-3 col-md-4">
                                        <a href="<?= __BASE_URL__ ?>/stock_management/productstockqty"
                                           class="btn default uppercase" type="button">Cancel</a>
                                        <input type="submit" class="btn green-meadow" value="SAVE"
                                               name="editProductStockQty[submit]">
                                    </div>
                                </div>

                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>    
