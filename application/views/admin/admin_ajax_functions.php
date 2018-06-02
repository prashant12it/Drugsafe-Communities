<?php
if ($mode == '__DELETE_FRANCHISEE_POPUP__') {
    echo "SUCCESS||||";
    ?>
    <div id="clientStatus" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <div class="caption">
                        <h4><i class="icon-equalizer font-red-sunglo"></i> &nbsp;
                            <span class="caption-subject font-red-sunglo bold uppercase">Delete Franchisee Record</span>
                        </h4>
                    </div>

                </div>

                <div class="modal-body">
                    <p class="alert alert-warning"><i class="fa fa-exclamation-triangle"></i> Deleting this franchisee
                        record will delete all the client records (main client and site records) associated with this
                        client ?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                    <button type="button"
                            onclick="deleteFranchiseeConfirmation('<?php echo $idfranchisee; ?>'); return false;"
                            class="btn green-meadow"><i class="fa fa-user-times"></i> Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
    <?php
}
if ($mode == '__DELETE_FRANCHISEE_CONFIRM__') {
    echo "SUCCESS||||";
    ?>
    <div id="clientStatusConfirmation" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <div class="caption">
                        <h4><i class="icon-equalizer font-red-sunglo"></i> &nbsp;
                            <span
                                    class="caption-subject font-red-sunglo bold uppercase">Deleted Franchisee Record</span>
                        </h4>
                    </div>

                </div>

                <div class="modal-body">
                    <p class="alert alert-success"><i class="fa fa-check"></i> Selected Franchisee has been successfully
                        deleted.</p>
                </div>
                <div class="modal-footer">
                    <a href="<?php echo __BASE_URL__; ?>/admin/franchiseeList" class="btn dark btn-outline">Close</a>
                </div>
            </div>
        </div>
    </div>

    <?php
}
if ($mode == '__DELETE_CLIENT_POPUP__') {
    echo "SUCCESS||||";
    ?>
    <div id="clientStatus" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <div class="caption">
                        <h4><i class="icon-equalizer font-red-sunglo"></i> &nbsp;
                            <?php if ($flag == 1) { ?>
                                <span class="caption-subject font-red-sunglo bold uppercase">Delete Site Record</span>
                            <?php } else { ?>
                                <span class="caption-subject font-red-sunglo bold uppercase">Delete Client Record</span>
                            <?php } ?>

                        </h4>
                    </div>

                </div>

                <div class="modal-body">
                    <?php if ($flag == 1) { ?>
                        <p class="alert alert-warning"><i class="fa fa-exclamation-triangle"></i> Are you sure you want
                            to
                            delete the selected Site?</p>

                    <?php } else { ?>
                        <p class="alert alert-warning"><i class="fa fa-exclamation-triangle"></i> Are you sure you want
                            to
                            delete the selected Client?</p>
                    <?php } ?>

                </div>
                <div class="modal-footer">

                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                    <button type="button"
                            onclick="deleteClientConfirmation('<?php echo $idClient; ?>','<?php echo $flag; ?>'); return false;"
                            class="btn green-meadow"><i class="fa fa-user-times"></i> Delete
                    </button>

                </div>
            </div>
        </div>
    </div>
    <?php
}
if ($mode == '__DELETE_CLIENT_CONFIRM__') {
    echo "SUCCESS||||";
    ?>
    <div id="clientStatusConfirmation" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <div class="caption">
                        <h4><i class="icon-equalizer font-red-sunglo"></i> &nbsp;
                            <?php if ($flag == 1) { ?>
                                <span class="caption-subject font-red-sunglo bold uppercase">Deleted Site Record</span>

                            <?php } else { ?>
                                <span class="caption-subject font-red-sunglo bold uppercase">Deleted Client Record</span>
                            <?php } ?>

                        </h4>
                    </div>

                </div>

                <div class="modal-body">
                    <?php if ($flag == 1) { ?>
                        <p class="alert alert-success"><i class="fa fa-check"></i> Selected Site has been successfully
                            deleted.</p>

                    <?php } else { ?>
                        <p class="alert alert-success"><i class="fa fa-check"></i> Selected Client has been successfully
                            deleted.</p>
                    <?php } ?>

                </div>
                <div class="modal-footer">
                    <?php if ($flag == 1) { ?>
                        <a href="<?php echo __BASE_URL__; ?>/franchisee/viewClientDetails" class="btn dark btn-outline">Close</a>
                    <?php } else { ?>
                        <a href="<?php echo __BASE_URL__ . $url; ?>" class="btn dark btn-outline">Close</a>
                    <?php } ?>

                </div>
            </div>
        </div>
    </div>

    <?php
}
if ($mode == '__DELETE_PRODUCT_POPUP__') {
    echo "SUCCESS||||";
    ?>
    <div id="productStatus" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <div class="caption">
                        <h4><i class="icon-equalizer font-red-sunglo"></i> &nbsp;
                            <span class="caption-subject font-red-sunglo bold uppercase">Delete Product</span></h4>
                    </div>

                </div>
                <div class="modal-body">
                    <p class="alert alert-warning"><i class="fa fa-exclamation-triangle"></i> Are you sure you want to
                        delete the selected Product?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>

                    <button type="button"
                            onclick="deleteProductConfirmation('<?php echo $idProduct; ?>','<?php echo $flag ?>'); return false;"
                            class="btn green-meadow"><i class="fa fa-user-times"></i> Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
    <?php
}
if ($mode == '__DELETE_PRODUCT_POPUP_CONFIRM__') {
    echo "SUCCESS||||";
    ?>
    <div id="productStatusConfirmation" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <div class="caption">
                        <h4><i class="icon-equalizer font-red-sunglo"></i> &nbsp;
                            <span class="caption-subject font-red-sunglo bold uppercase">Deleted Product</span></h4>
                    </div>

                </div>
                <div class="modal-body">
                    <p class="alert alert-success"><i class="fa fa-check"></i> Selected Products has been successfully
                        deleted.</p>
                </div>
                <div class="modal-footer">
                    <?php if ($flag == 1) { ?>
                        <a href="<?php echo __BASE_URL__; ?>/inventory/drugTestKitList" class="btn dark btn-outline">Close</a>
                    <?php } elseif ($flag == 2) { ?>
                        <a href="<?php echo __BASE_URL__; ?>/inventory/marketingMaterialList"
                           class="btn dark btn-outline">Close</a>
                    <?php } else { ?>
                        <a href="<?php echo __BASE_URL__; ?>/inventory/consumableslist" class="btn dark btn-outline">Close</a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <?php
}
if ($mode == '__REQUEST_QUANTITY_POPUP__') {
    echo "SUCCESS||||";
    ?>
    <div id="requestQuantityStatus" class="modal fade" tabindex="-2" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <div class="modal-title">
                        <div class="caption">
                            <h4><i class="icon-equalizer font-red-sunglo"></i> &nbsp;
                                <span class="caption-subject font-red-sunglo bold uppercase"> Request Quantity</span>
                            </h4>
                        </div>

                    </div>
                </div>
                <div class="modal-body">
                    <form action="" id="requestQuantityForm" name="requestQuantity" method="post"
                          class="form-horizontal form-row-sepe">
                        <div class="form-body">
                            <div
                                    class="form-group <?php if (form_error('requestQuantity[szQuantity]')) { ?>has-error<?php } ?>">
                                <label class="control-label col-md-3">Request Quantity</label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <input id="szQuantity"
                                               class="form-control input-large select2me input-square-right required  "
                                               type="text"
                                               value="<?php echo set_value('requestQuantity[szQuantity]'); ?>"
                                               placeholder="Request Quantity" onfocus="remove_formError(this.id,'true')"
                                               name="requestQuantity[szQuantity]">
                                    </div>
                                    <?php
                                    if (form_error('requestQuantity[szQuantity]')) {
                                        ?>
                                        <span class="help-block pull-left">
                                        <span><?php echo form_error('requestQuantity[szQuantity]'); ?></span>
                                        </span><?php } ?>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>

                    <button type="button"
                            onclick="requestQuantityConfirmation('<?php echo $idProduct; ?>','<?php echo $flag ?>'); return false;"
                            class="btn green-meadow">Submit
                    </button>
                </div>
            </div>
        </div>
    </div>
    <?php
}
if ($mode == '__REQUEST_QUANTITY_POPUP_CONFIRM__') {
    echo "SUCCESS||||";
    ?>
    <div id="requestQuantityStatusConfirmation" class="modal fade" tabindex="-1" data-backdrop="static"
         data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <div class="modal-title">
                        <div class="caption">
                            <h4><i class="icon-equalizer font-red-sunglo"></i> &nbsp;
                                <span class="caption-subject font-red-sunglo bold uppercase"> Requested Quantity</span>
                            </h4>
                        </div>

                    </div>
                </div>
                <div class="modal-body">
                    <p class="alert alert-success"><i class="fa fa-check"></i> Requested Quantity has been successfully
                        send .</p>
                </div>
                <div class="modal-footer">
                    <?php
                    if ($flag == 1) {
                        ?>
                        <a href="<?php echo __BASE_URL__; ?>/inventory/drugtestkitlist" class="btn dark btn-outline">Close</a>
                        <?php
                    } elseif ($flag == 2) {
                        ?>
                        <a href="<?php echo __BASE_URL__; ?>/inventory/marketingmateriallist"
                           class="btn dark btn-outline">Close</a>
                        <?php
                    } else {
                        ?>
                        <a href="<?php echo __BASE_URL__; ?>/inventory/consumableslist" class="btn dark btn-outline">Close</a>
                        <?php
                    }
                    ?>

                </div>
            </div>
        </div>
    </div>
    <?php
}
if ($mode == '__ALLOT_QUANTITY_POPUP__') {
    echo "SUCCESS||||";
    ?>
    <div id="allotQuantityStatus" class="modal fade" tabindex="-2" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <div class="modal-title">
                        <div class="caption">
                            <h4><i class="icon-equalizer font-red-sunglo"></i> &nbsp;
                                <span class="caption-subject font-red-sunglo bold uppercase"> Allot Quantity</span></h4>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <form action="" id="allotQuantityForm" name="allotQuantity" method="post"
                          class="form-horizontal form-row-sepe">
                        <div class="form-body">
                            <div
                                    class="form-group <?php if (form_error('allotQuantity[szReqQuantity]')) { ?>has-error<?php } ?>">
                                <label class="control-label col-md-4">Request Quantity</label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <input id="szReqQuantity" class="form-control input-large select2me read-only"
                                               readonly type="text" value="<?php echo set_value('szReqQuantity'); ?>"
                                               placeholder="Requested Quantity"
                                               onfocus="remove_formError(this.id,'true')"
                                               name="allotQuantity[szReqQuantity]">
                                    </div>
                                    <?php
                                    if (form_error('allotQuantity[szReqQuantity]')) {
                                        ?>
                                        <span class="help-block pull-left">
                                        <span><?php echo form_error('allotQuantity[szReqQuantity]'); ?></span>
                                        </span><?php } ?>
                                </div>
                            </div>
                            <div
                                    class="form-group <?php if (form_error('allotQuantity[szAddMoreQuantity]')) { ?>has-error<?php } ?>">
                                <label class="control-label col-md-4">Assign Quantity</label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <input id="szAddMoreQuantity" class="form-control input-large select2me "
                                               type="text"
                                               value="<?php echo set_value('allotQuantity[szAddMoreQuantity]'); ?>"
                                               placeholder="Assign Quantity" onfocus="remove_formError(this.id,'true')"
                                               name="allotQuantity[szAddMoreQuantity]">
                                    </div>
                                    <?php
                                    if (form_error('allotQuantity[szAddMoreQuantity]')) {
                                        ?>
                                        <span class="help-block pull-left">
                                        <span><?php echo form_error('allotQuantity[szAddMoreQuantity]'); ?></span>
                                        </span><?php } ?>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                    <button type="button"
                            onclick="allotQuantityConfirmation('<?php echo $idProduct; ?>'); return false;"
                            class="btn green-meadow">Submit
                    </button>
                </div>
            </div>
        </div>
    </div>
    <?php
}
if ($mode == '__ALLOT_QUANTITY_POPUP_CONFIRM__') {
    echo "SUCCESS||||";
    ?>
    <div id="allotQuantityStatusConfirmation" class="modal fade" tabindex="-1" data-backdrop="static"
         data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <div class="modal-title">
                        <div class="caption">
                            <h4><i class="icon-equalizer font-red-sunglo"></i> &nbsp;
                                <span class="caption-subject font-red-sunglo bold uppercase"> Alloted Quantity</span>
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <p class="alert alert-success"><i class="fa fa-check"></i> Product quantities have been alloted
                        successfully.
                    </p>
                </div>
                <div class="modal-footer">
                    <a href="<?php echo __BASE_URL__; ?>/stock_management/viewproductlist" class="btn dark btn-outline">Close</a>
                </div>
            </div>
        </div>
    </div>
    <?php
}
if ($mode == '__DELETE_OPERATION_MANAGER_POPUP__') {
    echo "SUCCESS||||";
    ?>
    <div id="operationManagerStatus" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <div class="caption">
                        <h4><i class="icon-equalizer font-red-sunglo"></i> &nbsp;
                            <span class="caption-subject font-red-sunglo bold uppercase">Delete Operation Manager</span>
                        </h4>
                    </div>

                </div>
                <div class="modal-body">
                    <p class="alert alert-warning"><i class="fa fa-exclamation-triangle"></i> Deleting this operation
                        manager record will delete all the franchisee and client records (main client and site records)
                        associated with this operation manager ?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                    <button type="button"
                            onclick="deleteOperationManagerConfirmation('<?php echo $idOperationManager; ?>'); return false;"
                            class="btn green-meadow"><i class="fa fa-user-times"></i> Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
    <?php
}
if ($mode == '__DELETE_OPERATION_MANAGER_CONFIRM__') {
    echo "SUCCESS||||";
    ?>
    <div id="operationManagerStatusConfirmation" class="modal fade" tabindex="-1" data-backdrop="static"
         data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <div class="caption">
                        <h4><i class="icon-equalizer font-red-sunglo"></i> &nbsp;
                            <span
                                    class="caption-subject font-red-sunglo bold uppercase">Deleted Operation Manager</span>
                        </h4>
                    </div>

                </div>

                <div class="modal-body">
                    <p class="alert alert-success"><i class="fa fa-check"></i> Selected Operation Manager has been
                        successfully deleted.</p>
                </div>
                <div class="modal-footer">
                    <a href="<?php echo __BASE_URL__; ?>/admin/operationManagerList"
                       class="btn dark btn-outline">Close</a>
                </div>
            </div>
        </div>
    </div>

    <?php
}
if ($mode == '__DELETE_CATEGORY_POPUP__') {
    echo "SUCCESS||||";
    ?>
    <div id="CategoryStatus" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <div class="caption">
                        <h4><i class="icon-equalizer font-red-sunglo"></i> &nbsp;
                            <span class="caption-subject font-red-sunglo bold uppercase">Delete Category</span></h4>
                    </div>

                </div>
                <div class="modal-body">
                    <p class="alert alert-warning"><i class="fa fa-exclamation-triangle"></i> Are you sure you want to
                        delete the selected Category?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>

                    <button type="button"
                            onclick="deleteCategoryConfirmation('<?php echo $idCategory; ?>'); return false;"
                            class="btn green-meadow"><i class="fa fa-user-times"></i> Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
    <?php
}
if ($mode == '__DELETE_CATEGORY_POPUP_CONFIRM__') {
    echo "SUCCESS||||";
    ?>
    <div id="categoryStatusConfirmation" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <div class="caption">
                        <h4><i class="icon-equalizer font-red-sunglo"></i> &nbsp;
                            <span class="caption-subject font-red-sunglo bold uppercase">Deleted Category</span></h4>
                    </div>

                </div>


                <div class="modal-body">
                    <p class="alert alert-success"><i class="fa fa-check"></i> Selected Category has been successfully
                        deleted.</p>
                </div>
                <div class="modal-footer">
                    <a href="<?php echo __BASE_URL__; ?>/forum/categoriesList" class="btn dark btn-outline">Close</a>
                </div>
            </div>
        </div>
    </div>

    <?php
}
if ($mode == '__DELETE_FORUM_POPUP__') {
    echo "SUCCESS||||";
    ?>
    <div id="forumStatus" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <div class="caption">
                        <h4><i class="icon-equalizer font-red-sunglo"></i> &nbsp;
                            <span class="caption-subject font-red-sunglo bold uppercase">Delete Forum</span></h4>
                    </div>

                </div>

                <div class="modal-body">
                    <p class="alert alert-warning"><i class="fa fa-exclamation-triangle"></i> Are you sure you want to
                        delete the selected Forum?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>

                    <button type="button" onclick="deleteForumConfirmation('<?php echo $id; ?>'); return false;"
                            class="btn green-meadow"><i class="fa fa-user-times"></i> Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
    <?php
}
if ($mode == '__DELETE_FORUM_POPUP_CONFIRM__') {
    echo "SUCCESS||||";
    ?>
    <div id="forumStatusConfirmation" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <div class="caption">
                        <h4><i class="icon-equalizer font-red-sunglo"></i> &nbsp;
                            <span class="caption-subject font-red-sunglo bold uppercase">Deleted Forum</span></h4>
                    </div>

                </div>

                <div class="modal-body">
                    <p class="alert alert-success"><i class="fa fa-check"></i> Selected Forum has been successfully
                        deleted.</p>
                </div>
                <div class="modal-footer">
                    <a href="<?php echo __BASE_URL__; ?>/forum/forumList" class="btn dark btn-outline">Close</a>
                </div>
            </div>
        </div>
    </div>

    <?php
}
if ($mode == '__REPLY_POPUP__') {
    echo "SUCCESS||||";
    ?>
    <div id="replyStatus" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <!--                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                    <h4 class="modal-title">Reply</h4><br>
                                </div>-->

                <form action="" id="replyData" name="replyData" method="post" class="form-horizontal  ">
                    <div class="form-body ">
                        <p class="alert alert-info mdl_align"><i class="fa fa-reply"></i> Please Type your reply below
                            the given box.</p>

                        <hr>
                        <div class="form-group <?php if (form_error('replyData[szReply]')) { ?>has-error<?php } ?>">
                            <label class="col-md-1 control-label"> </label>
                            <div class="col-md-8">
                                <div class="input-group">

                                    <textarea name="replyData[szReply]" id="szReply" class="form-control" value=""
                                              rows="7" cols="250" placeholder="Reply"
                                              onfocus="remove_formError(this.id,'true')"><?php echo set_value('replyData[szReply]'); ?></textarea>

                                </div>
                                <?php
                                if (form_error('replyData[szReply]')) {
                                    ?>
                                    <span class="help-block pull-left">
                                    <span><?php echo form_error('replyData[szReply]'); ?></span>
                                    </span><?php } ?>
                            </div>
                        </div>

                    </div>

                </form>
                <div class="modal-footer">
                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                    <button type="button" onclick="replyToCmntConfirmation('<?php echo $idCmnt; ?>'); return false;"
                            class="btn green-meadow">Submit
                    </button>
                </div>
            </div>
        </div>
    </div>

    <?php
}
if ($mode == '__REPLY_CONFIRM_POPUP__') {
    echo "SUCCESS||||";
    ?>
    <div id="replyStatusConfirmation" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <div class="caption">
                        <h4><i class="icon-equalizer font-red-sunglo"></i> &nbsp;
                            <span class="caption-subject font-red-sunglo bold uppercase">Reply To Comment</span></h4>
                    </div>

                </div>

                <div class="modal-body">
                    <p class="alert alert-success"><i class="fa fa-check"></i> Reply has been posted successfully .</p>
                </div>
                <div class="modal-footer">
                    <a href="<?php echo __BASE_URL__; ?>/forum/viewTopicDetails" class="btn dark btn-outline">Close</a>
                </div>
            </div>
        </div>
    </div>

    <?php
}
if ($mode == '__TOPIC_POPUP__') {
    echo "SUCCESS||||";
    ?>


    <div id="showTopic" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <?php
                $TopicsArr = $this->Forum_Model->viewTopicListByTopicId($idTopic);
                $franchiseeDetArr1 = $this->Admin_Model->getAdminDetailsByEmailOrId('', $TopicsArr['idUser']);
                ?>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <div class="caption">
                        <h4><i class="icon-equalizer font-red-sunglo"></i> &nbsp;
                            <span class="caption-subject font-red-sunglo bold uppercase">Topic</span></h4>
                    </div>

                </div>

                <div>
                    <h4 class="text_cmnt"><b>Title - <?php echo $TopicsArr['szTopicTitle'] ?>  </b></h4>
                </div>
                <div class="modal-body">
                    <h4 class="alert alert-success"> <?php echo $TopicsArr['szTopicDescreption']; ?> </h4>
                    <span class="todo-comment-username cmntDetais"><?php echo $franchiseeDetArr1['szName'] ?></span>
                    &nbsp; <span
                            class="todo-comment-date"> <?php echo date('d M Y', strtotime($TopicsArr['dtCreatedOn'])) . ' at ' . date('h:i A', strtotime($TopicsArr['dtCreatedOn'])); ?></span>
                </div>

                <div class="modal-footer">
                    <a href="<?php echo __BASE_URL__; ?>/forum/approvallist" class="btn dark btn-outline">Close</a>
                </div>
            </div>
        </div>
    </div>


    <?php
}
if ($mode == '__SHOW_REPLY_POPUP__') {
    echo "SUCCESS||||";
    ?>

    <div id="showReply" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <?php $replyDataArr = $this->Forum_Model->getAllReplyByCmntsId($idReply, 2);
                $franchiseeDetArr1 = $this->Admin_Model->getAdminDetailsByEmailOrId('', $replyDataArr['0']['idReplier']);
                $cmntDataArr = $this->Forum_Model->getAllCommentsByCmntId($replyDataArr['0']['idCmnt']);
                $splitTimeStamp = explode(" ", $replyDataArr['0']['dtReplyOn']);
                $date1 = $splitTimeStamp[0];
                $time1 = $splitTimeStamp[1];
                $x = date("g:i a", strtotime($time1));
                $date = explode('-', $date1);
                $monthNum = $date['1'];
                $dateObj = DateTime::createFromFormat('!m', $monthNum);
                $monthName = $dateObj->format('M');
                ?>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <div class="caption">
                        <h4><i class="icon-equalizer font-red-sunglo"></i> &nbsp;
                            <span class="caption-subject font-red-sunglo bold uppercase">Reply</span></h4>
                    </div>

                </div>

                <div>
                    <h4 class="text_cmnt"><b> Comment </b></h4>
                    <h4 class="text_cmntData"><?php echo $cmntDataArr['szCmnt'] ?>  </h4>
                </div>
                <div class="modal-body">
                    <div class="text_cmnt"><h4><b> Reply </b></h4></div>
                    <p class="alert alert-success">  <?php echo $replyDataArr['0']['szReply']; ?></p>
                    <span class="todo-comment-username"><?php echo $franchiseeDetArr1['szName'] ?> </span> &nbsp; <span
                            class="todo-comment-date"><?php echo $date['2']; ?> <?php echo $monthName; ?>  <?php echo $date['0']; ?>
                        at <?php echo $x; ?></span>
                </div>

                <div class="modal-footer">
                    <a href="<?php echo __BASE_URL__; ?>/forum/approvallist" class="btn dark btn-outline">Close</a>
                </div>
            </div>
        </div>
    </div>

    <?php
}
if ($mode == '__APPROVE_REPLY_POPUP__') {
    echo "SUCCESS||||";
    ?>
    <div id="approveReplyAlert" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <div class="caption">
                        <h4><i class="icon-equalizer font-red-sunglo"></i> &nbsp;
                            <span class="caption-subject font-red-sunglo bold uppercase">Approve Reply</span></h4>
                    </div>

                </div>
                <div class="modal-body">
                    <p class="alert alert-warning"><i class="fa fa-exclamation-triangle"></i> Are you sure you want to
                        approve this reply?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>

                    <button type="button" onclick="approveReplyConfirmation('<?php echo $idReply; ?>'); return false;"
                            class="btn green-meadow"><i class="fa fa-check"></i> Approve
                    </button>
                </div>
            </div>
        </div>
    </div>
    <?php
}
if ($mode == '__REPLY_APPROVE_CONFIRM_POPUP__') {
    echo "SUCCESS||||";
    ?>
    <div id="approveReplyConfirmation" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <div class="caption">
                        <h4><i class="icon-equalizer font-red-sunglo"></i> &nbsp;
                            <span class="caption-subject font-red-sunglo bold uppercase">Approved Reply</span></h4>
                    </div>

                </div>

                <div class="modal-body">
                    <p class="alert alert-success"><i class="fa fa-check"></i> Reply has been successfully approved.</p>
                </div>
                <div class="modal-footer">
                    <a href="<?php echo __BASE_URL__; ?>/forum/approvallist" class="btn dark btn-outline">Close</a>
                </div>
            </div>
        </div>
    </div>

    <?php
}
if ($mode == '__UNAPPROVE_REPLY_POPUP__') {
    echo "SUCCESS||||";
    ?>
    <div id="unapproveReplyAlert" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <div class="caption">
                        <h4><i class="icon-equalizer font-red-sunglo"></i> &nbsp;
                            <span class="caption-subject font-red-sunglo bold uppercase">Unapprove Reply</span></h4>
                    </div>

                </div>
                <div class="modal-body">
                    <p class="alert alert-warning"><i class="fa fa-exclamation-triangle"></i> Are you sure you want to
                        unapprove this reply?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>

                    <button type="button" onclick="unapproveReplyConfirmation('<?php echo $idReply; ?>'); return false;"
                            class="btn green-meadow"><i class="fa fa-times"></i> Unapprove
                    </button>
                </div>
            </div>
        </div>
    </div>
    <?php
}
if ($mode == '__REPLY_UNAPPROVE_CONFIRM_POPUP__') {
    echo "SUCCESS||||";
    ?>
    <div id="unapproveReplyConfirmation" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <div class="caption">
                        <h4><i class="icon-equalizer font-red-sunglo"></i> &nbsp;
                            <span class="caption-subject font-red-sunglo bold uppercase">Unapproved Reply</span></h4>
                    </div>

                </div>

                <div class="modal-body">
                    <p class="alert alert-success"><i class="fa fa-check"></i> Reply has been successfully unapproved.
                    </p>
                </div>
                <div class="modal-footer">
                    <a href="<?php echo __BASE_URL__; ?>/forum/approvallist" class="btn dark btn-outline">Close</a>
                </div>
            </div>
        </div>
    </div>

    <?php
}
if ($mode == '__DELETE_REPLY_POPUP__') {
    echo "SUCCESS||||";
    ?>
    <div id="replyDelete" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <div class="caption">
                        <h4><i class="icon-equalizer font-red-sunglo"></i> &nbsp;
                            <span class="caption-subject font-red-sunglo bold uppercase">Delete Reply</span></h4>
                    </div>

                </div>

                <div class="modal-body">
                    <p class="alert alert-warning"><i class="fa fa-exclamation-triangle"></i> Are you sure you want to
                        delete the selected Reply?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>

                    <button type="button" onclick="replyDeleteConfirmation('<?php echo $idReply; ?>'); return false;"
                            class="btn green-meadow"><i class="fa fa-user-times"></i> Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
    <?php
}
if ($mode == '__DELETE_REPLY_POPUP_CONFIRM__') {
    echo "SUCCESS||||";
    ?>
    <div id="replyDeleteConfirmation" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <div class="caption">
                        <h4><i class="icon-equalizer font-red-sunglo"></i> &nbsp;
                            <span class="caption-subject font-red-sunglo bold uppercase">Deleted Comment</span></h4>
                    </div>

                </div>

                <div class="modal-body">
                    <p class="alert alert-success"><i class="fa fa-check"></i> Selected Reply has been successfully
                        deleted.</p>
                </div>
                <div class="modal-footer">
                    <a href="<?php echo __BASE_URL__; ?>/forum/viewTopicDetails" class="btn dark btn-outline">Close</a>
                </div>
            </div>
        </div>
    </div>

    <?php
}
if ($mode == '__DELETE_COMMENT_POPUP__') {
    echo "SUCCESS||||";
    ?>
    <div id="cmntDelete" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <div class="caption">
                        <h4><i class="icon-equalizer font-red-sunglo"></i> &nbsp;
                            <span class="caption-subject font-red-sunglo bold uppercase">Delete Comment</span></h4>
                    </div>

                </div>

                <div class="modal-body">
                    <p class="alert alert-warning"><i class="fa fa-exclamation-triangle"></i> Are you sure you want to
                        delete the selected Comment?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>

                    <button type="button" onclick="cmntDeleteConfirmation('<?php echo $idCmnt; ?>'); return false;"
                            class="btn green-meadow"><i class="fa fa-user-times"></i> Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
    <?php
}
if ($mode == '__DELETE_COMMENT_POPUP_CONFIRM__') {
    echo "SUCCESS||||";
    ?>
    <div id="cmntDeleteConfirmation" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <div class="caption">
                        <h4><i class="icon-equalizer font-red-sunglo"></i> &nbsp;
                            <span class="caption-subject font-red-sunglo bold uppercase">Deleted Comment</span></h4>
                    </div>

                </div>

                <div class="modal-body">
                    <p class="alert alert-success"><i class="fa fa-check"></i> Selected Comment has been successfully
                        deleted.</p>
                </div>
                <div class="modal-footer">
                    <a href="<?php echo __BASE_URL__; ?>/forum/viewTopicDetails" class="btn dark btn-outline">Close</a>
                </div>
            </div>
        </div>
    </div>

    <?php
}
if ($mode == '__TOPIC_CLOSE_POPUP__') {
    echo "SUCCESS||||";
    ?>
    <div id="closeTopic" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <div class="caption">
                        <h4><i class="icon-equalizer font-red-sunglo"></i> &nbsp;
                            <span class="caption-subject font-red-sunglo bold uppercase">Close Topic</span></h4>
                    </div>

                </div>


                <div class="modal-body">
                    <p class="alert alert-warning"><i class="fa fa-exclamation-triangle"></i> Are you sure you want to
                        close the selected Topic?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>

                    <button type="button" onclick="closeTopicConfirmation('<?php echo $idTopic; ?>'); return false;"
                            class="btn green-meadow"><i class="fa fa-user-times"></i> Submit
                    </button>
                </div>
            </div>
        </div>
    </div>
    <?php
}
if ($mode == '__TOPIC_CLOSE_POPUP_CONFIRM__') {
    echo "SUCCESS||||";
    ?>
    <div id="closeTopicConfirmation" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <div class="caption">
                        <h4><i class="icon-equalizer font-red-sunglo"></i> &nbsp;
                            <span class="caption-subject font-red-sunglo bold uppercase">Closed Topic</span></h4>
                    </div>

                </div>

                <div class="modal-body">
                    <p class="alert alert-success"><i class="fa fa-check"></i> Selected Topic has been successfully
                        closed.</p>
                </div>
                <div class="modal-footer">
                    <a href="<?php echo __BASE_URL__; ?>/forum/viewForum" class="btn dark btn-outline">Close</a>
                </div>
            </div>
        </div>
    </div>

    <?php
}
if ($mode == '__EDIT_REPLY_POPUP__') {
    echo "SUCCESS||||";
    ?>
    <div id="replyEdit" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <!--                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                    <h4 class="modal-title">Reply</h4><br>
                                </div>-->

                <form action="" id="replyData" name="replyData" method="post" class="form-horizontal  ">
                    <div class="form-body ">
                        <p class="alert alert-info mdl_align"><i class="fa fa-pencil"></i> Reply Edit</p>

                        <hr>
                        <div class="form-group <?php if (form_error('replyData[szReply]')) { ?>has-error<?php } ?>">
                            <label class="col-md-1 control-label"> </label>
                            <div class="col-md-8">
                                <div class="input-group">

                                    <textarea name="replyData[szReply]" id="szReply" class="form-control"
                                              value="<?php echo $szReply; ?>" rows="7" cols="250" placeholder="Reply"
                                              onfocus="remove_formError(this.id,'true')"><?php echo $szReply; ?></textarea>

                                </div>
                                <?php
                                if (form_error('replyData[szReply]')) {
                                    ?>
                                    <span class="help-block pull-left">
                                    <span><?php echo form_error('replyData[szReply]'); ?></span>
                                    </span><?php } ?>
                            </div>
                        </div>

                    </div>

                </form>
                <div class="modal-footer">
                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                    <button type="button" onclick="replyEditConfirmation('<?php echo $idReply; ?>'); return false;"
                            class="btn green-meadow">Submit
                    </button>
                </div>
            </div>
        </div>
    </div>

    <?php
}
if ($mode == '__EDIT_REPLY_POPUP_CONFIRM__') {
    echo "SUCCESS||||";
    ?>
    <div id="replyEditConfirmation" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <div class="caption">
                        <h4><i class="icon-equalizer font-red-sunglo"></i> &nbsp;
                            <span class="caption-subject font-red-sunglo bold uppercase">Edit Reply</span></h4>
                    </div>

                </div>

                <div class="modal-body">
                    <p class="alert alert-success"><i class="fa fa-check"></i> Reply has been edited successfully .</p>
                </div>
                <div class="modal-footer">
                    <a href="<?php echo __BASE_URL__; ?>/forum/viewTopicDetails" class="btn dark btn-outline">Close</a>
                </div>
            </div>
        </div>
    </div>

    <?php
}
if ($mode == '__APPROVE_TOPIC_POPUP__') {
    echo "SUCCESS||||";
    ?>
    <div id="approveTopicAlert" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <div class="caption">
                        <h4><i class="icon-equalizer font-red-sunglo"></i> &nbsp;
                            <span class="caption-subject font-red-sunglo bold uppercase">Approve Topic</span></h4>
                    </div>

                </div>
                <div class="modal-body">
                    <p class="alert alert-warning"><i class="fa fa-exclamation-triangle"></i> Are you sure you want to
                        approve this topic?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>

                    <button type="button"
                            onclick="approveTopicConfirmation('<?php echo $idTopic; ?>'); return false;"
                            class="btn green-meadow"><i class="fa fa-check"></i> Approve
                    </button>
                </div>
            </div>
        </div>
    </div>
    <?php
}
if ($mode == '__TOPIC_APPROVE_CONFIRM_POPUP__') {
    echo "SUCCESS||||";
    ?>
    <div id="approveTopicConfirmation" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <div class="caption">
                        <h4><i class="icon-equalizer font-red-sunglo"></i> &nbsp;
                            <span class="caption-subject font-red-sunglo bold uppercase">Approved Topic</span></h4>
                    </div>

                </div>

                <div class="modal-body">
                    <p class="alert alert-success"><i class="fa fa-check"></i> Topic has been successfully approved.
                    </p>
                </div>
                <div class="modal-footer">
                    <a href="<?php echo __BASE_URL__; ?>/forum/approvallist" class="btn dark btn-outline">Close</a>
                </div>
            </div>
        </div>
    </div>

<?php }
if ($mode == '__UNAPPROVE_TOPIC_POPUP__') {
    echo "SUCCESS||||";
    ?>
    <div id="unapproveTopicAlert" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <div class="caption">
                        <h4><i class="icon-equalizer font-red-sunglo"></i> &nbsp;
                            <span class="caption-subject font-red-sunglo bold uppercase">Unapprove Topic</span></h4>
                    </div>

                </div>

                <div class="modal-body">
                    <p class="alert alert-warning"><i class="fa fa-exclamation-triangle"></i> Are you sure you want to
                        unapprove this topic?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>

                    <button type="button"
                            onclick="unapproveTopicConfirmation('<?php echo $idTopic; ?>'); return false;"
                            class="btn green-meadow"><i class="fa fa-times"></i> Unapprove
                    </button>
                </div>
            </div>
        </div>
    </div>
    <?php
}
if ($mode == '__TOPIC_UNAPPROVE_CONFIRM_POPUP__') {
    echo "SUCCESS||||";
    ?>
    <div id="unapproveTopicConfirmation" class="modal fade" tabindex="-1" data-backdrop="static"
         data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <div class="caption">
                        <h4><i class="icon-equalizer font-red-sunglo"></i> &nbsp;
                            <span class="caption-subject font-red-sunglo bold uppercase">Unapproved Topic</span></h4>
                    </div>
                </div>

                <div class="modal-body">
                    <p class="alert alert-success"><i class="fa fa-check"></i> Topic has been successfully unapproved.
                    </p>
                </div>
                <div class="modal-footer">
                    <a href="<?php echo __BASE_URL__; ?>/forum/approvallist" class="btn dark btn-outline">Close</a>
                </div>
            </div>
        </div>
    </div>

    <?php
}
if ($mode == '__EDIT_COMMENT_POPUP__') {
    echo "SUCCESS||||";
    ?>
    <div id="commentEdit" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <!--                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                    <h4 class="modal-title">Reply</h4><br>
                                </div>-->

                <form action="" id="commentData" name="commentData" method="post" class="form-horizontal  ">
                    <div class="form-body ">
                        <p class="alert alert-info mdl_align"><i class="fa fa-pencil"></i> Comment Edit</p>

                        <hr>
                        <div class="form-group <?php if (form_error('commentData[szComment]')) { ?>has-error<?php } ?>">
                            <label class="col-md-1 control-label"> </label>
                            <div class="col-md-8">
                                <div class="input-group">
                                    <textarea name="commentData[szComment]" id="szComment" class=" ckeditor" rows="7"
                                              cols="250" placeholder="Reply"
                                              onfocus="remove_formError(this.id,'true')"><?php echo $szComment; ?></textarea>
                                </div>
                                <?php
                                if (form_error('commentData[szComment]')) {
                                    ?>
                                    <span class="help-block pull-left">
                                    <span><?php echo form_error('commentData[szComment]'); ?></span>
                                    </span><?php } ?>
                            </div>
                        </div>

                    </div>

                </form>
                <div class="modal-footer">
                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                    <button type="button" onclick="commentEditConfirmation('<?php echo $idComment; ?>'); return false;"
                            class="btn green-meadow">Submit
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script>
        CKEDITOR.replace('szComment');
    </script>

    <?php
}
if ($mode == '__EDIT_COMMENT_POPUP_CONFIRM__') {
    echo "SUCCESS||||";
    ?>
    <div id="commentEditConfirmation" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <div class="caption">
                        <h4><i class="icon-equalizer font-red-sunglo"></i> &nbsp;
                            <span class="caption-subject font-red-sunglo bold uppercase">Comment Edit</span></h4>
                    </div>

                </div>

                <div class="modal-body">
                    <p class="alert alert-success"><i class="fa fa-check"></i> Comment has been edited successfully .
                    </p>
                </div>
                <div class="modal-footer">
                    <a href="<?php echo __BASE_URL__; ?>/forum/viewTopicDetails" class="btn dark btn-outline">Close</a>
                </div>
            </div>
        </div>
    </div>

    <?php
}
if ($mode == '__DELETE_TOPIC_POPUP__') {
    echo "SUCCESS||||";
    ?>
    <div id="deleteTopic" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <div class="caption">
                        <h4><i class="icon-equalizer font-red-sunglo"></i> &nbsp;
                            <span class="caption-subject font-red-sunglo bold uppercase">Delete Topic</span></h4>
                    </div>

                </div>
                <div class="modal-body">
                    <p class="alert alert-warning"><i class="fa fa-exclamation-triangle"></i> Are you sure you want to
                        delete the selected Topic?</p>
                </div>
                <div class="modal-footer">

                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                    <button type="button" onclick="topicDeleteConfirmation('<?php echo $idTopic; ?>'); return false;"
                            class="btn green-meadow"><i class="fa fa-user-times"></i> Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
    <?php
}
if ($mode == '__DELETE_TOPIC_POPUP_CONFIRM__') {
    echo "SUCCESS||||";
    ?>
    <div id="topicDeleteConfirmation" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <div class="caption">
                        <h4><i class="icon-equalizer font-red-sunglo"></i> &nbsp;
                            <span class="caption-subject font-red-sunglo bold uppercase">Deleted Topic</span></h4>
                    </div>

                </div>

                <div class="modal-body">
                    <p class="alert alert-success"><i class="fa fa-check"></i> Selected Topic has been successfully
                        deleted.</p>
                </div>
                <div class="modal-footer">
                    <a href="<?php echo __BASE_URL__; ?>/forum/viewForum/" class="btn dark btn-outline">Close</a>
                </div>
            </div>
        </div>
    </div>

    <?php
}
if ($mode == '__PLACE_ORDER_POPUP_CONFIRM__') {
    echo "SUCCESS||||";
    ?>
    <div id="orderplaceconfirmation" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <div class="caption">
                        <h4><i class="icon-equalizer font-red-sunglo"></i> &nbsp;
                            <span class="caption-subject font-red-sunglo bold uppercase">Success</span></h4>
                    </div>

                </div>
                <div class="modal-body">
                    <p class="alert alert-success"><i class="fa fa-check"></i> Your Item has been successfully added to
                        cart.</p>
                </div>
                <div class="modal-footer">
                    <?php $flag = $this->session->userdata('flag');
                    if ($flag == 1) {
                        $this->session->unset_userdata('orderid');
                        ?>
                        <a href="<?php echo __BASE_URL__; ?>/order/drugtestkit" class="btn dark btn-outline">Close</a>
                    <?php }
                    if ($flag == 2) {
                        $this->session->unset_userdata('orderid');
                        ?>
                        <a href="<?php echo __BASE_URL__; ?>/order/marketingmaterial"
                           class="btn dark btn-outline">Close</a>
                    <?php }
                    if ($flag == 3) {
                        $this->session->unset_userdata('orderid');
                        ?>
                        <a href="<?php echo __BASE_URL__; ?>/order/consumables" class="btn dark btn-outline">Close</a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <?php
}
if ($mode == '__DELETE_ORDER_POPUP__') {
    echo "SUCCESS||||";
    ?>
    <div id="DeleteOrder" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <div class="caption">
                        <h4><i class="icon-equalizer font-red-sunglo"></i> &nbsp;
                            <span class="caption-subject font-red-sunglo bold uppercase">Remove Product</span></h4>
                    </div>

                </div>

                <div class="modal-body">
                    <p class="alert alert-warning"><i class="fa fa-exclamation-triangle"></i> Are you sure you want to
                        remove the selected Product?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                    <button type="button" onclick="DeleteOrderConfirmation('<?php echo $idOrder; ?>'); return false;"
                            class="btn red"><i class="fa fa-times"></i> Remove
                    </button>
                </div>
            </div>
        </div>
    </div>
    <?php
}
if ($mode == '__DELETE_ORDER_CONFIRM__') {
    echo "SUCCESS||||";
    ?>
    <div id="DeleteOrderConfirmation" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <div class="caption">
                        <h4><i class="icon-equalizer font-red-sunglo"></i> &nbsp;
                            <span class="caption-subject font-red-sunglo bold uppercase">Removed Product</span></h4>
                    </div>

                </div>

                <div class="modal-body">
                    <p class="alert alert-success"><i class="fa fa-check"></i> Selected Product has been successfully
                        removed.</p>
                </div>
                <div class="modal-footer">
                    <a href="<?php echo __BASE_URL__; ?>/order/orderList" class="btn dark btn-outline">Close</a>
                </div>
            </div>
        </div>
    </div>

    <?php
}
if ($mode == '__VIEW_ORDER_DETAILS_POPUP__') {
    echo "SUCCESS||||";
    ?>


    <div id="viewOrder" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <div class="caption">
                        <h4><i class="icon-equalizer font-red-sunglo"></i> &nbsp;
                            <span class="caption-subject font-red-sunglo bold uppercase">Order Details</span></h4>

                        <?php
                         $OrdersDetailsAray = $this->Order_Model->getOrderByOrderId($idOrder);
                        if ($flag != 1) { ?>
                            <hr>
                            <div class='row'>
                                <div class="actions">

                                    <div class=' col-md-6'>

                                    </div>
                                    <div class=' col-md-6'>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                       <?php if ($OrdersDetailsAray['status'] == 2) { ?>
                                        <a onclick="view_order_details_pdf('<?php echo $idOrder; ?>','1')"
                                           href="javascript:void(0);"
                                           class=" btn green-meadow">
                                            <i class="fa fa-file-pdf-o"></i> View Pdf </a>

                                        <a onclick="View_excel_order_details_list('<?php echo $idOrder; ?>','1')"
                                           href="javascript:void(0);"
                                           class=" btn green-meadow">
                                            <i class="fa fa-file-excel-o"></i> View Xls </a>
                                       <?php } else {?>
                                          <a onclick="view_order_details_pdf('<?php echo $idOrder; ?>')"
                                           href="javascript:void(0);"
                                           class=" btn green-meadow">
                                            <i class="fa fa-file-pdf-o"></i> View Pdf </a>

                                        <a onclick="View_excel_order_details_list('<?php echo $idOrder; ?>')"
                                           href="javascript:void(0);"
                                           class=" btn green-meadow">
                                            <i class="fa fa-file-excel-o"></i> View Xls </a>
                                         <?php }?>
                                    </div>

                                </div>
                            </div>
                        <?php } ?>
                    </div>


                </div>

                <div class="modal-body">

                    <div class="portlet green-meadow box">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-cogs"></i> Order Info

                            </div>

                        </div>
                        <?php
                       
                        $franchiseeDetArr1 = $this->Admin_Model->getAdminDetailsByEmailOrId('', $OrdersDetailsAray['franchiseeid']);
                        $splitTimeStamp = explode(" ", $OrdersDetailsAray['createdon']);
                        $date1 = $splitTimeStamp[0];
                        $time1 = $splitTimeStamp[1];
                        $x = date("g:i a", strtotime($time1));
                        $date = explode('-', $date1);
                        $monthNum = $date['1'];
                        $dateObj = DateTime::createFromFormat('!m', $monthNum);
                        $monthName = $dateObj->format('M');
                        ?>
                        <div class="portlet-body">
                            <div class="row static-info">
                                <div class="col-md-5 name">
                                    Order #:
                                </div>
                                <div class="col-md-7 value">
                                    #<?php echo sprintf(__FORMAT_NUMBER__, $idOrder); ?>
                                </div>
                            </div>
                            <div class="row static-info">
                                <div class="col-md-5 name">
                                    Order Date & Time:
                                </div>
                                <div class="col-md-7 value">
                                    <?php echo date('d M Y', strtotime($OrdersDetailsAray['createdon'])) . ' at ' . date('h:i A', strtotime($OrdersDetailsAray['createdon'])); ?>
                                </div>
                            </div>
                            <?php if ($OrdersDetailsAray['status'] == 2) { ?>
                                <div class="row static-info">
                                    <div class="col-md-5 name">
                                        Dispatched Date & Time:
                                    </div>
                                    <div class="col-md-7 value">
                                        <?php echo date('d M Y', strtotime($OrdersDetailsAray['dispatchedon'])) . ' at ' . date('h:i A', strtotime($OrdersDetailsAray['dispatchedon'])); ?>
                                    </div>
                                </div>
                            <?php }
                            if ($OrdersDetailsAray['status'] == 3) { ?>
                                <div class="row static-info">
                                    <div class="col-md-5 name">
                                        Cancelled Date & Time:
                                    </div>
                                    <div class="col-md-7 value">
                                        <?php echo date('d M Y', strtotime($OrdersDetailsAray['canceledon'])) . ' at ' . date('h:i A', strtotime($OrdersDetailsAray['canceledon'])); ?>
                                    </div>
                                </div>
                            <?php }
                            if ($OrdersDetailsAray['last_changed']) { ?>
                                <!--
                                <div class="row static-info">
                                    <div class="col-md-5 name">
                                        Last updated Date & Time:
                                    </div>
                                    <div class="col-md-7 value">
                                        <?php echo date('d M Y', strtotime($OrdersDetailsAray['last_changed'])) . ' at ' . date('h:i A', strtotime($OrdersDetailsAray['last_changed'])); ?>
                                    </div>
                                </div>-->
                            <?php } ?>
                            <div class="row static-info">
                                <div class="col-md-5 name">
                                    Order Status:
                                </div>
                                <?php if ($OrdersDetailsAray['status'] == 1) { ?>
                                    <div class="col-md-7 value">
                                                    <span class="label label-sm label-warning">
                                                    Ordered </span>
                                    </div>

                                    <?php
                                }
                                if ($OrdersDetailsAray['status'] == 2) {
                                    ?>
                                    <div class="col-md-7 value">
                                                    <span class="label label-sm label-success">
                                                   Dispatched  </span>
                                    </div>

                                    <?php
                                }
                                if ($OrdersDetailsAray['status'] == 3) {
                                    ?>
                                    <div class="col-md-7 value">
                                                    <span class="label label-sm label-danger">
                                                  Canceled   </span>
                                    </div>

                                    <?php
                                }
                                if ($OrdersDetailsAray['status'] == 4) {
                                    ?>
                                    <div class="col-md-7 value">
                                                    <span class="label label-sm label-info">
                                                     </span>
                                    </div>

                                    <?php
                                }
                                ?>

                            </div>
                                   <?php
                                
                                if ($OrdersDetailsAray['status'] == 2) {
                                    ?>
                            <div class="row static-info">
                                <div class="col-md-5 name">
                                    Freight Price:
                                </div>
                                <div class="col-md-7 value">
                                    $<?php
                                    $dispatchDatesArr = $this->Order_Model->getTotalOrderDispatchDates($idOrder);
                                    $freightpriceval = number_format($OrdersDetailsAray['freightprice'], 2, '.', '');
                                    echo number_format($freightpriceval, 2, '.', ','); 
//                                    echo number_format($freightpriceval, 2, '.', ',').' x '.count($dispatchDatesArr).' = $'.number_format(($freightpriceval*count($dispatchDatesArr)), 2, '.', ','); ?>
                                </div>
                            </div>
                                   
                            <div class="row static-info">
                                <div class="col-md-5 name">
                                    Total Price EXL GST:
                                </div>
                                <div class="col-md-7 value">
                                    $<?php
                                    echo number_format($OrdersDetailsAray['dispatched_price'], 2, '.', ','); ?>
                                </div>
                            </div>
                                <?php
                                } else{
                                    ?>
                                <div class="row static-info">
                                <div class="col-md-5 name">
                                    Total Price EXL GST:
                                </div>
                                <div class="col-md-7 value">
                                    $<?php
                                    echo number_format($OrdersDetailsAray['price'], 2, '.', ','); ?>
                                </div>
                            </div>
                                <?php
                                }
                                    ?>
                            <!--<div class="row static-info">
                                <div class="col-md-5 name">
                                    Dispatched Price:
                                </div>
                                <div class="col-md-7 value">
                                    $<?php
                            /*                                    echo number_format($OrdersDetailsAray['dispatched_price'], 2, '.', ','); */ ?>
                                </div>
                            </div>-->
                            <?php if ($_SESSION['drugsafe_user']['iRole'] == 1) { ?>
                                <div class="row static-info">
                                    <div class="col-md-5 name">
                                        Franchisee:
                                    </div>
                                    <div class="col-md-7 value">
                                        <?php echo $franchiseeDetArr1['szName'] ?>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <hr>
                     <div class="portlet green-meadow box">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-cogs"></i> Products Info

                            </div>

                        </div>
                        <?php $totalOrdersDetailsAray = $this->Order_Model->getOrderDetailsByOrderId($idOrder);
                        ?>
                        <div class="portlet-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th> Product Code</th>
                                        <th> Product Cost</th>
                                        <th> Ordered Qty</th>
                                           <?php
                                if ($OrdersDetailsAray['status'] == 2) {
                                    ?>
                                        <th> Dispatched Qty</th>
                                           <?php
                                          }
                                          ?>
                                        <th> Total Price EXL GST</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    foreach ($totalOrdersDetailsAray as $totalOrdersDetailsData) {
                                        $productDataArr = $this->Inventory_Model->getProductDetailsById($totalOrdersDetailsData['productid']);
                                        $TotalDispatched = $this->Order_Model->getTotalDispatchedByOrderDetailId($totalOrdersDetailsData['id']);?>
                                        <tr>
                                            <td> <?php echo $productDataArr['szProductCode']; ?> </td>
                                            <td> $<?php echo $productDataArr['szProductCost']; ?> </td>
                                            <td> <?php echo $totalOrdersDetailsData['quantity']; ?> </td>
                                               <?php
                                                   if ($OrdersDetailsAray['status'] == 2) {
                                             ?>
                                             <td> <?php echo (!empty($TotalDispatched['total_dispatched'])?$TotalDispatched['total_dispatched']:'N/A'); ?> </td>
                                             <td> $<?php
                                                echo number_format(($TotalDispatched['total_dispatched']) * ($productDataArr['szProductCost']), 2, '.', ','); ?>
                                            </td>
                                               <?php
                                                    } else{
                                                        ?>
                                             <td> $<?php
                                                echo number_format(($totalOrdersDetailsData['quantity']) * ($productDataArr['szProductCost']), 2, '.', ','); ?>
                                            </td>
                                                    <?php } ?>
                                        </tr>
                                    <?php } ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <?php
}
if ($mode == '__PLACE_ORDER_POPUP_ERROR_CONFIRM__') {
    echo "SUCCESS||||";
    ?>
    <div id="placeOrderErrorConfirmation" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <div class="caption">
                        <h4><i class="icon-equalizer font-red-sunglo"></i> &nbsp;
                            <span class="caption-subject font-red-sunglo bold uppercase">Error</span></h4>
                    </div>

                </div>
                <div class="modal-body">
                    <p class="alert alert-danger"><i class="fa fa-times"></i> Entered Quantity must be greater than or
                        equal
                        to <?php echo '<b>' . $qty . '</b>' . (!empty($prodname) ? ' for <b>' . $prodname . '</b>' : ''); ?>
                        .</p>
                </div>
                <div class="modal-footer">
                    <?php
                    $this->session->unset_userdata('orderid');
                    ?>
                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <?php
}
if ($mode == '__EDIT_ORDER_DETAILS_POPUP__') {   
    echo "SUCCESS||||";
    ?>


    <div id="editOrder" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <div class="caption">
                        <h4><i class="icon-equalizer font-red-sunglo"></i> &nbsp;
                            <span class="caption-subject font-red-sunglo bold uppercase">Edit Order </span></h4>
                    </div>

                </div>

                <div class="modal-body">

                    <div class="portlet green-meadow box">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-cogs"></i> Products Info

                            </div>

                        </div>
                        <?php $totalOrdersDetailsAray = $this->Order_Model->getOrderDetailsByOrderId($idOrder); ?>
                        <div class="portlet-body">
                            <form class="form-horizontal" id="dispatchProduct"
                                  action="<?= __BASE_URL__ ?>/order/dispatchProductData" name="dispatchProduct"
                                  method="post">
                                <div class="form-body" id="tabel_content">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover">
                                            <thead>
                                            <tr>
                                                <th> Product Code</th>
                                                <th> Product Cost</th>
                                                <th> Available</th>
                                                 <th> Available After Dispatch</th>
                                                 <th> Ordered</th>
                                                 <th> Dispatched Qty</th>
                                                <th> Back Order</th>
                                                <th> Dispatch Qty</th>
                                                <th> Total Price EXL GST</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $i = 1;
                                            $count = 0;
                                            foreach ($totalOrdersDetailsAray as $totalOrdersDetailsData) {
                                             
                                                $productDataArr = $this->Inventory_Model->getProductDetailsById($totalOrdersDetailsData['productid']);
                                                $ordersDetailsAray = $this->Order_Model->getOrderByOrderId($idOrder);
                                                $freightPrice = 0.00;
//                                                $readonly = '';
                                                if($ordersDetailsAray['freightprice']>0.00){
                                                    $freightPrice = number_format($ordersDetailsAray['freightprice'],2,'.','');
//                                                    $readonly = 'readonly="readonly" style="cursor:not-allowed"';
                                                }
                                               
                                                 $price = 0.00;
                                                 $TotalDispatched = $this->Order_Model->getTotalDispatchedByOrderDetailId($totalOrdersDetailsData['id']);
                                                 $TotalReceivedDispatched = $this->Order_Model->getTotalReceivedDispatchedqty ($totalOrdersDetailsData['id']);
                                              
                                                 if ($TotalDispatched['total_dispatched'] > '0') {
                                                  
                                                $avilableqtyafterdispatch = (($productDataArr['szAvailableQuantity'])-($TotalDispatched['total_dispatched'])) + ($TotalReceivedDispatched['total_dispatched']);
                                                if($avilableqtyafterdispatch > '0') {
                                                  $avilableqtyafterdispatch = $avilableqtyafterdispatch;  
                                                } 
                                                else{
                                                   $avilableqtyafterdispatch = '0' ;
                                                }
                                                } else {
                                                      $avilableqtyafterdispatch = '-';
                                                 }
                                                 $avilableqtyafterdispatchValForCheck = (($productDataArr['szAvailableQuantity'])-($TotalDispatched['total_dispatched'])) + ($TotalReceivedDispatched['total_dispatched']);
                                                ?>
                                                <tr>
                                                    <td> <?php echo $productDataArr['szProductCode']; ?>
                                                    </td>
                                                    <td> $<?php echo $productDataArr['szProductCost']; ?> </td>
                                                   
                                                    <td> <?php echo $productDataArr['szAvailableQuantity']; ?>
                                                    </td>
                                                    
                                                    <td> <?php echo $avilableqtyafterdispatch; ?>
                                                   
                                                    </td>
                                                     <td> <?php echo $totalOrdersDetailsData['quantity']; ?>
                                                    </td>
                                                    <?php if ($totalOrdersDetailsData['dispatched'] > '0') {
                                                        $price = $productDataArr['szProductCost'] * $totalOrdersDetailsData['quantity']; ?>
                                                        <td><?php echo '0'; ?></td>
                                                        <td>-</td>
<!--                                                        <td><?php echo $totalOrdersDetailsData['quantity']; ?></td>-->
                                                        <td><?php echo $TotalDispatched['total_dispatched'];?></td>
                                                        <td>
                                                            --
                                                        </td>
                                                    <?php } else {
                                                        $count++;
                                                        ?>
                                                         <td><?php echo $TotalDispatched['total_dispatched'];?></td>
                                                        <td><?php
                                                            $backorder = $totalOrdersDetailsData['quantity']-$TotalDispatched['total_dispatched'];
                                                            if((empty($TotalDispatched['total_dispatched']))){
                                                            echo "-";    
                                                            }
                                                            elseif($backorder == $totalOrdersDetailsData['quantity']){
                                                              
                                                               echo "-";    
                                                            }
                                                           else{
                                                             echo ($backorder>0?'<span style="color:red">'.$backorder.'</span>':'0');  
                                                           }
                                                            ?></td>
                                                        <td><input
                                                                    type="hidden" name="remainingQty<?php echo $i; ?>"
                                                                    id="remainingQty<?php echo $i; ?>"
                                                                    value="<?php echo ($totalOrdersDetailsData['quantity'] - $TotalDispatched['total_dispatched']); ?>">
                                                            <input
                                                                    type="hidden" name="ordprodid<?php echo $i; ?>"
                                                                    id="ordprodid<?php echo $i; ?>"
                                                                    value="<?php echo $totalOrdersDetailsData['productid']; ?>">
                                                            <input
                                                                    type="hidden" name="ordqtyid<?php echo $i; ?>"
                                                                    id="ordqtyid<?php echo $i; ?>"
                                                                    value="<?php echo $totalOrdersDetailsData['quantity']; ?>">
                                                            <input
                                                                    type="hidden" name="availqtyid<?php echo $i; ?>"
                                                                    id="availqtyid<?php echo $i; ?>"
                                                                    value="<?php echo($productDataArr['szAvailableQuantity'] > '0' ? $productDataArr['szAvailableQuantity'] : '0'); ?>">
                                                            <input
                                                                    type="hidden" name="availqtyafterdisid<?php echo $i; ?>"
                                                                    id="availqtyafterdisid<?php echo $i; ?>"
                                                                    value="<?php echo($avilableqtyafterdispatchValForCheck > '0' ? $avilableqtyafterdispatchValForCheck: '0'); ?>">
                                                            
                                                            <input type="hidden" name="isdispid<?php echo $i; ?>"
                                                                   id="isdispid<?php echo $i; ?>" value="0"/>
                                                            <input type="number" min="1" class="form-control btn-xs "
                                                                   max="100" name="order_quantity<?php echo $i; ?>"
                                                                   id="order_quantity<?php echo $i; ?>"
                                                                   onblur="calTotalPrice()">
                                                            <span id="orddiperr<?php echo $i; ?>" class="err"></span>
                                                            <input type="hidden"
                                                                   name="order_prod_price<?php echo $i; ?>"
                                                                   id="order_prod_price<?php echo $i; ?>"
                                                                   value="<?php echo $productDataArr['szProductCost']; ?>"/>
                                                        </td>
                                                       
                                                        <td>
                                                            <label class="lab<?php echo $i; ?>"
                                                                   name="total_price<?php echo $i; ?>" value=""
                                                                   id="total_price<?php echo $i; ?>">$0.00</label>
                                                        </td>

                                                    <?php
                                                        $i++;
                                                    } ?>
                                                </tr>
                                                <input id="ProductId" class="form-control" type="hidden"
                                                       value="<?php echo $productDataArr['id']; ?>"
                                                       name="product_id<?php echo $i; ?>"
                                                       id="product_id<?php echo $i; ?>">
                                                <?php } ?>
                                            <input id="orderId" class="form-control" type="hidden"
                                                   value="<?php echo $idOrder; ?>" name="order_id"
                                                   id="order_id<?php echo $i; ?>">
                                            <input type="hidden" name="totalprodcount" id="totalprodcount"
                                                   value="<?php echo $count; ?>"/>
                                            </tbody>
                                        </table>
                                        <div class="row">
                                            <div class="col-md-6">
                                            </div>
                                            <div class="col-md-6">
                                                <div class="well">
                                                    <div class="row static-info align-reverse totalpr">
                                                        <div class="col-md-6 name portlet_list_title">
                                                            Freight Price:
                                                        </div>
                                                        <div class="col-md-6 value">
                                                            <input id="freightprice" class="form-control" type="number"
                                                                   step="0.01" min="0.00"
                                                                   value="<?php echo $freightPrice; ?>" name="freightprice"
                                                                   onblur="calTotalPrice()">

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="well">
                                                    <div class="row static-info align-reverse totalpr">
                                                        <div class="col-md-6 name portlet_list_title">
                                                            Total Price (Exl GST):
                                                        </div>
                                                        <div class="col-md-6 value">
                                                            <input id="totalprice" class="form-control" type="hidden"
                                                                   value="<?php echo number_format($price, 2, '.', ''); ?>"
                                                                   name="totalprice">
                                                            <label name="finaltotal" value=""
                                                                   id="finaltotal">$<?php echo number_format($price, 2, '.', ','); ?></label>

                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <input class="form-control" type="hidden"
                                       value="<?php echo $ordersDetailsAray['franchiseeid'] ?>" name="franchiseeId"
                                       id="franchiseeId">


                                <div class="modal-footer">
                                    <button type="button"
                                            onmousedown="changeordstatus('<?php echo $idOrder; ?>','<?php echo $count; ?>','1');"
                                            class="btn green-meadow" name="submit"><i class="icon-basket"></i> Dispatch
                                        Order
                                    </button>
                                    <!--                                    <button type="button"
                                            onclick="changeordstatus('<?php echo $idOrder; ?>','<?php echo $count; ?>','0');"
                                            class="btn green-meadow" name="pending" value="1"><i
                                            class="fa fa-shopping-cart"></i> Pending Order
                                    </button>-->
                                    <!--                      <button type="button" onclick="pendingOrder('<?php echo $idOrder; ?>'); return false;" class="btn green-meadow"><i class="fa fa-shopping-cart"></i>  Pending Order</button>-->
                                    <?php if ($flag!=1){?>
                                    <button type="button"
                                            onmousedown="CancelOrderConfirmation('<?php echo $idOrder; ?>'); return false;"
                                            class="btn red"><i class="fa fa-times"></i> Cancel Order
                                    </button>
                                    <?php }?>
                               
                               <a href="" class="btn dark btn-outline" data-dismiss="modal">Close</a>
               
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>


    <?php
}
if ($mode == '__PRODUCT_DISPATCHED_SUCCESSFULLY__') {
    echo 'SUCCESS||||';
    if($data)
        {
    ?>
    <div id="dispatchprodsucess" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" onclick="redirect_url('<?php echo __BASE_URL__; ?>/order/view_order_list');"
                            class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <div class="caption">
                        <h4><i class="icon-equalizer font-red-sunglo"></i> &nbsp;
                            <span class="caption-subject font-red-sunglo bold uppercase">Ordered Quantities Alloted</span>
                        </h4>
                    </div>

                </div>

                <div class="modal-body">
                    <p class="alert alert-success"><i class="fa fa-check"></i> Product quantities have been alloted
                        successfully.
                    </p>
                </div>
                <div class="modal-footer">
                   <a href="" class="btn dark btn-outline" data-dismiss="modal">Close</a>
                </div>
            </div>
        </div>
    </div>
 <?php
     echo '||||'; 
         ?>      
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

            <th>
                Franchisee
            </th>

            <th>
                Order Date
            </th>
            <th>
                Status
            </th>
            <th>
                Order Details
            </th>

            <th>
                Edit Order
            </th>

            <th>
                Delivery Docket
            </th>

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
            ?>
            <tr>
                <td><?php echo $i; ?> </td>
                <td>
                    #<?php echo sprintf(__FORMAT_NUMBER__, $validOrdersDetailsData['orderid']); ?>
                </td>

                <td>
                    <?php echo $franchiseeDetArr1['szName']; ?>
                </td>

                <td>
                     <?php echo date('d M Y', strtotime($validOrdersDetailsData['createdon'])) . ' at ' . date('h:i A', strtotime($validOrdersDetailsData['createdon'])); ?>
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
            
    <?php    }
     
}
if ($mode == '__ORDER_STATUS_CHANGED__') {
    echo 'SUCCESS||||';
    ?>
    <div id="orderstatchanged" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" onclick="redirect_url('<?php echo __BASE_URL__; ?>/order/view_order_list');"
                            class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <div class="caption">
                        <h4><i class="icon-equalizer font-red-sunglo"></i> &nbsp;
                            <span class="caption-subject font-red-sunglo bold uppercase">Order Status</span></h4>
                    </div>

                </div>

                <div class="modal-body">
                    <p class="alert alert-success"><i class="fa fa-check"></i> Order status updated successfully.
                    </p>
                </div>
                <div class="modal-footer">
                    <a href="<?php echo __BASE_URL__; ?>/order/view_order_list" class="btn dark btn-outline">Close</a>
                </div>
            </div>
        </div>
    </div>
<?php }
if ($mode == '__CANCEL_ORDER_CONFIRM_DETAILS_POPUP__') {
   
    echo "SUCCESS||||";
    if($data)
        {
    ?>
    <div id="cancelOrderConfirmation" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <div class="caption">
                        <h4><i class="icon-equalizer font-red-sunglo"></i> &nbsp;
                            <span class="caption-subject font-red-sunglo bold uppercase">Canceled Order</span></h4>
                    </div>

                </div>
                <div class="modal-body">
                    <p class="alert alert-success"><i class="fa fa-check"></i> Ordered Quantity has been canceled
                        successfully.</p>
                </div>
                <div class="modal-footer">
                    <?php
                    ?>
                    <a href="" class="btn dark btn-outline" data-dismiss="modal">Close</a>
                </div>
            </div>
        </div>
    </div>
 
    <?php
     echo '||||'; 
         ?>      
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

            <th>
                Franchisee
            </th>

            <th>
                Order Date
            </th>
            <th>
                Status
            </th>
            <th>
                Order Details
            </th>

            <th>
                Edit Order
            </th>

            <th>
                Delivery Docket
            </th>

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
            ?>
            <tr>
                <td><?php echo $i; ?> </td>
                <td>
                    #<?php echo sprintf(__FORMAT_NUMBER__, $validOrdersDetailsData['orderid']); ?>
                </td>

                <td>
                    <?php echo $franchiseeDetArr1['szName']; ?>
                </td>

                <td>
                     <?php echo date('d M Y', strtotime($validOrdersDetailsData['createdon'])) . ' at ' . date('h:i A', strtotime($validOrdersDetailsData['createdon'])); ?>
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
                           onclick="view_order_details_pdf(<?php echo $validOrdersDetailsData['orderid']; ?>);"
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
            
    <?php    }
     
}
if ($mode == '__DELIVER_ORDER_CONFIRM_DETAILS_POPUP__') {
    echo "SUCCESS||||";
    ?>
    <div id="deliverOrderConfirmation" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <div class="caption">
                        <h4><i class="icon-equalizer font-red-sunglo"></i> &nbsp;
                            <span class="caption-subject font-red-sunglo bold uppercase">Pending Order</span></h4>
                    </div>

                </div>
                <div class="modal-body">
                    <p class="alert alert-success"><i class="fa fa-exclamation-triangle"></i> Ordered Quantity has been
                        in pending state.</p>
                </div>
                <div class="modal-footer">
                    <?php
                    ?>
                    <a href="<?php echo __BASE_URL__; ?>/order/view_order_list" class="btn dark btn-outline">Close</a>
                </div>
            </div>
        </div>
    </div>

    <?php
}
if ($mode == '__DISPATCH_ORDER_CONFIRM_POPUP__') {
    echo "SUCCESS||||";
    ?>
    <div id="deliverOrderConfirmation" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <div class="caption">
                        <h4><i class="icon-equalizer font-red-sunglo"></i> &nbsp;
                            <span class="caption-subject font-red-sunglo bold uppercase">Dispatch Order</span></h4>
                    </div>

                </div>
                <div class="modal-body">
                    <p class="alert alert-success"><i class="fa fa-check"></i> Ordered Quantity has been dispatched
                        successfully.</p>
                </div>
                <div class="modal-footer">
                    <?php
                    ?>
                    <a href="<?php echo __BASE_URL__; ?>/order/view_order_list" class="btn dark btn-outline">Close</a>
                </div>
            </div>
        </div>
    </div>

<?php }
if ($mode == '__DELETE_AGENT_POPUP__') {
    echo "SUCCESS||||";
    ?>
    <div id="agentStatus" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4><i class="icon-equalizer font-red-sunglo"></i> &nbsp;
                        <span class="caption-subject font-red-sunglo bold uppercase">Delete Agent</span></h4>
                </div>
                <div class="modal-body">
                    <p class="alert alert-warning"><i class="fa fa-exclamation-triangle"></i> Are you sure you want to
                        delete the selected Agent?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                    <button type="button" onclick="agentDeleteConfirmation('<?php echo $id_agent; ?>'); return false;"
                            class="btn green-meadow"><i class="fa fa-user-times"></i> Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
    <?php
}
if ($mode == '__DELETE_AGENT_CONFIRM__') {
    echo "SUCCESS||||";
    ?>
    <div id="agentStatusConfirmation" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4><i class="icon-equalizer font-red-sunglo"></i> &nbsp;
                        <span class="caption-subject font-red-sunglo bold uppercase">Deleted Agent</span></h4>
                </div>

                <div class="modal-body">
                    <p class="alert alert-success"><i class="fa fa-check"></i> Selected Agent has been successfully
                        deleted.</p>
                </div>
                <div class="modal-footer">
                    <a href="<?php echo __BASE_URL__; ?>/franchisee/viewClientAgentDetails"
                       class="btn dark btn-outline">Close</a>
                </div>
            </div>
        </div>
    </div>

    <?php
}
if ($mode == '__ASSIGN_CLIENT_POPUP_FORM__') {
    echo "SUCCESS||||";
    ?>
    <div id="assignClientPopupform" class="modal fade" tabindex="-2" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <div class="modal-title">
                        <div class="caption">
                            <h4><i class="icon-equalizer font-red-sunglo"></i> &nbsp;
                                <span class="caption-subject font-red-sunglo bold uppercase"> Agent-Client Assignment</span>
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <h4 class="modal-custom-heading"><i class="fa fa-users"></i> Assigned Clients</h4>
                    <hr>
                    <div class="table-reposnsive">
                        <?php if (!empty($agentAssignedClientDetails)) { ?>
                            <table class="table table-striped table-hover">
                                <thead>
                                <th>#</th>
                                <th>Client Name</th>
                                <th>Email</th>
                                <th>Contact</th>
                                <th>Action</th>
                                </thead>
                                <tbody>
                                <?php
                                $clcount = 1;
                                foreach ($agentAssignedClientDetails as $agentclients) {
                                    $isUnAssignable = true;
                                    $agentCLientSitesArr = $this->Webservices_Model->getclientsites($agentclients['id']);
                                    if (!empty($agentCLientSitesArr)) {
                                        foreach ($agentCLientSitesArr as $agentClientSite) {
                                            $siteSos = $this->Webservices_Model->getsosformdata($agentClientSite['clientId']);
                                            if (!empty($siteSos)) {
                                                $isUnAssignable = false;
                                            }
                                        }
                                    }
                                    ?>
                                    <tr>
                                        <td><?php echo $clcount; ?></td>
                                        <td><?php echo $agentclients['szName']; ?></td>
                                        <td><?php echo $agentclients['szEmail']; ?></td>
                                        <td><?php echo $agentclients['szContactNumber']; ?></td>
                                        <td><?php if ($isUnAssignable) { ?><a
                                                class="btn btn-circle btn-icon-only btn-default" title="Unassign Client"
                                                onclick="unassignclient('<?php echo $agentclients['agentclientid']; ?>');"
                                                href="javascript:void(0);">
                                                    <i class="fa fa-times"></i>
                                                </a><?php } ?></td>
                                    </tr>
                                    <?php $clcount++;
                                }
                                ?>
                                </tbody>
                            </table>
                        <?php } else {
                            echo '</p>No client is assigned to this agent/employee.</p>';
                        } ?>
                    </div>
                    <hr/>
                    <h4 class="modal-custom-heading"><i class="fa fa-plus"></i> Assign More Clients</h4>
                    <hr>
                    <form action="" id="assignClient" name="assignClient" method="post"
                          class="form-horizontal form-row-sepe">
                        <div class="form-body">
                            <div
                                    class="form-group <?php if (form_error('assignClient[szClient]')) { ?>has-error<?php } ?>">
                                <label class="control-label col-md-4">Client</label>
                                <div class="col-md-5">
                                    <div class="search">
                                        <div id='szClient'>
                                            <select class="form-control custom-select" name="assignClient[szClient]"
                                                    id="szClient" onfocus="remove_formError(this.id,'true')">
                                                <option value="">Client Name</option>
                                                <?php
                                                foreach ($clientlistArr as $clientList) {
                                                    echo '<option value="' . $clientList['id'] . '" >' . $clientList['szName'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <?php
                                    if (form_error('assignClient[szClient]')) {
                                        ?>
                                        <span class="help-block pull-left">
                                        <span><?php echo form_error('assignClient[szClient]'); ?></span>
                                        </span><?php } ?>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                    <button type="button"
                            onclick="assignClientConfirmation('<?php echo $agentId; ?>');"
                            class="btn green-meadow">Submit
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div id="popup_box_level1"></div>
    <?php
}
if ($mode == '__ASSIGN_CLIENT_POPUP_CONFIRMATION__') {
    echo "SUCCESS||||";
    ?>
    <div id="clientAgentStatusConfirmation" class="modal fade" tabindex="-1" data-backdrop="static"
         data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4><i class="icon-equalizer font-red-sunglo"></i> &nbsp;
                        <span class="caption-subject font-red-sunglo bold uppercase">Client Assign Confirmation</span>
                    </h4>
                </div>

                <div class="modal-body">
                    <p class="alert alert-success"><i class="fa fa-check"></i> Selected Client has been successfully
                        assigned.</p>
                </div>
                <div class="modal-footer">
                    <a href="<?php echo __BASE_URL__; ?>/franchisee/agentRecord" class="btn dark btn-outline">Close</a>
                </div>
            </div>
        </div>
    </div>

    <?php
}
if ($mode == '__DELETE_AGENT_EMPLOYE_POPUP__') {
    echo "SUCCESS||||";
    ?>
    <div id="agetDelete" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <div class="caption">
                        <h4><i class="icon-equalizer font-red-sunglo"></i> &nbsp;
                            <span class="caption-subject font-red-sunglo bold uppercase">Delete Agent/Employee Record</span>
                        </h4>
                    </div>

                </div>

                <div class="modal-body">
                    <p class="alert alert-warning"><i class="fa fa-exclamation-triangle"></i> Are you sure you want to
                        delete the selected Agent/Employee Record?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                    <button type="button"
                            onclick="agentEmployeeDeleteConfirmation('<?php echo $agentId; ?>'); return false;"
                            class="btn green-meadow"><i class="fa fa-user-times"></i> Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
    <?php
}
if ($mode == '___DELETE_AGENT_EMPLOYE_CONFIRM__') {
    echo "SUCCESS||||";
    ?>
    <div id="agetDeleteConfirmation" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <div class="caption">
                        <h4><i class="icon-equalizer font-red-sunglo"></i> &nbsp;
                            <span
                                    class="caption-subject font-red-sunglo bold uppercase">Deleted Agent/Employee Record</span>
                        </h4>
                    </div>

                </div>

                <div class="modal-body">
                    <p class="alert alert-success"><i class="fa fa-check"></i> Selected Agent/Employee has been
                        successfully
                        deleted.</p>
                </div>
                <div class="modal-footer">
                    <a href="<?php echo __BASE_URL__; ?>/franchisee/agentRecord" class="btn dark btn-outline">Close</a>
                </div>
            </div>
        </div>
    </div>

    <?php
}
if ($mode == '__UNASSIGN_CLIENT_CONFIRMATION_POPUP_FORM__') {
    echo "SUCCESS||||";
    ?>
    <div id="unassignclient" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <div class="caption">
                        <h4><i class="icon-equalizer font-red-sunglo"></i> &nbsp;
                            <span class="caption-subject font-red-sunglo bold uppercase">Unassign Client From Agent/Employee Record</span>
                        </h4>
                    </div>

                </div>

                <div class="modal-body">
                    <p class="alert alert-warning"><i class="fa fa-exclamation-triangle"></i> Are you sure you want to
                        unassign the selected client from this agent/employee record?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                    <button type="button"
                            onclick="confirmedUnassign('<?php echo $agentclientid; ?>');"
                            class="btn green-meadow"><i class="fa fa-user-times"></i> Unassign
                    </button>
                </div>
            </div>
        </div>
    </div>
    <?php
}
if ($mode == '__UNASSIGNED_CLIENT_SUCCESS__') {
    echo "SUCCESS||||";
    ?>
    <div id="confirmedUnassign" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4><i class="icon-equalizer font-red-sunglo"></i> &nbsp;
                        <span class="caption-subject font-red-sunglo bold uppercase">Client Unassigned</span></h4>
                </div>

                <div class="modal-body">
                    <p class="alert alert-success"><i class="fa fa-check"></i> Selected client has been successfully
                        unassigned from this agent.</p>
                </div>
                <div class="modal-footer">
                    <a class="btn dark btn-outline" href="<?php echo __BASE_URL__; ?>/franchisee/agentRecord">Close</a>
                </div>
            </div>
        </div>
    </div>

    <?php
}
if ($mode == '__DELETE_REGION_POPUP__') {
    echo "SUCCESS||||";
    ?>
    <div id="regionDelete" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <div class="caption">
                        <h4><i class="icon-equalizer font-red-sunglo"></i> &nbsp;
                            <span class="caption-subject font-red-sunglo bold uppercase">Delete Region Record</span>
                        </h4>
                    </div>

                </div>

                <div class="modal-body">
                    <p class="alert alert-warning"><i class="fa fa-exclamation-triangle"></i> Are you sure you want to
                        delete the selected Region?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                    <button type="button"
                            onclick="regionDeleteConfirmation('<?php echo $regionId; ?>'); return false;"
                            class="btn green-meadow"><i class="fa fa-user-times"></i> Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
    <?php
}
if ($mode == '___DELETE_REGION_CONFIRM__') {
    echo "SUCCESS||||";
    ?>
    <div id="regionDeleteConfirmation" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <div class="caption">
                        <h4><i class="icon-equalizer font-red-sunglo"></i> &nbsp;
                            <span
                                    class="caption-subject font-red-sunglo bold uppercase">Deleted Region Record</span>
                        </h4>
                    </div>

                </div>

                <div class="modal-body">
                    <p class="alert alert-success"><i class="fa fa-check"></i> Selected Region has been successfully
                        deleted.</p>
                </div>
                <div class="modal-footer">
                    <a href="<?php echo __BASE_URL__; ?>/admin/regionManagerList" class="btn dark btn-outline">Close</a>
                </div>
            </div>
        </div>
    </div>

    <?php
}
if ($mode == '__FRANCHISEE_STATUS_POPUP__') {
    echo "SUCCESS||||";
    if ($status == 1) {
        $statusMsg = "Enable";
    } else {
        $statusMsg = "Disable";
    }
    ?>
    <div id="franchiseeStatus" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <div class="caption">
                        <h4><i class="icon-equalizer font-red-sunglo"></i> &nbsp;
                            <span class="caption-subject font-red-sunglo bold uppercase"><?php echo $statusMsg; ?>
                                Franchisee</span>
                        </h4>
                    </div>

                </div>

                <div class="modal-body">
                    <p class="alert alert-warning"><i class="fa fa-exclamation-triangle"></i> Are you sure you want to
                        disable the selected Franchisee?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                    <button type="button"
                            onclick="franchiseeStatusConfirmation('<?php echo $idfranchisee; ?>',<?php echo $status; ?>); return false;"
                            class="btn green-meadow"><i class="fa fa-user-times"></i> <?php echo $statusMsg; ?>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <?php
}
if ($mode == '__FRANCHISEE_STATUS_CONFIRM__') {
    echo "SUCCESS||||";
    if ($status == 1) {
        $statusMsg = "Enable";
    } else {
        $statusMsg = "Disabled";
    }
    ?>
    <div id="franchiseeStatusConfirmation" class="modal fade" tabindex="-1" data-backdrop="static"
         data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <div class="caption">
                        <h4><i class="icon-equalizer font-red-sunglo"></i> &nbsp;
                            <span
                                    class="caption-subject font-red-sunglo bold uppercase"><?php echo $statusMsg; ?>
                                Franchisee</span>
                        </h4>
                    </div>

                </div>

                <div class="modal-body">
                    <p class="alert alert-success"><i class="fa fa-check"></i> Selected Franchisee has been successfully
                        disabled.</p>
                </div>
                <div class="modal-footer">
                    <a href="<?php echo __BASE_URL__; ?>/admin/franchiseeList" class="btn dark btn-outline">Close</a>
                </div>
            </div>
        </div>
    </div>

    <?php
}
if ($mode == '__DELETE_DISCOUNT_POPUP__') {
    echo "SUCCESS||||";
    ?>
    <div id="discountDelete" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <div class="caption">
                        <h4><i class="icon-equalizer font-red-sunglo"></i> &nbsp;
                            <span class="caption-subject font-red-sunglo bold uppercase">Delete Discount Record</span>
                        </h4>
                    </div>

                </div>

                <div class="modal-body">
                    <p class="alert alert-warning"><i class="fa fa-exclamation-triangle"></i> Are you sure you want to
                        delete the selected Discount?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                    <button type="button"
                            onclick="discountDeleteConfirmation('<?php echo $idDiscount; ?>'); return false;"
                            class="btn green-meadow"><i class="fa fa-user-times"></i> Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
    <?php
}
if ($mode == '___DELETE_DISCOUNT_CONFIRM__') {
    echo "SUCCESS||||";
    ?>
    <div id="discountDeleteConfirmation" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <div class="caption">
                        <h4><i class="icon-equalizer font-red-sunglo"></i> &nbsp;
                            <span
                                    class="caption-subject font-red-sunglo bold uppercase">Deleted Discount Record</span>
                        </h4>
                    </div>

                </div>

                <div class="modal-body">
                    <p class="alert alert-success"><i class="fa fa-check"></i> Selected Discount has been successfully
                        deleted.</p>
                </div>
                <div class="modal-footer">
                    <a href="<?php echo __BASE_URL__; ?>/ordering/discountPercentage"
                       class="btn dark btn-outline">Close</a>
                </div>
            </div>
        </div>
    </div>

    <?php
}
if ($mode == '__DELETE_PROSPECT_POPUP__') {
    echo "SUCCESS||||";
    ?>
    <div id="prospectStatus" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <div class="caption">
                        <h4><i class="icon-equalizer font-red-sunglo"></i> &nbsp;
                            <span class="caption-subject font-red-sunglo bold uppercase">Delete Prospect Record</span>
                        </h4>
                    </div>

                </div>

                <div class="modal-body">
                    <p class="alert alert-warning"><i class="fa fa-exclamation-triangle"></i> Deleting this Prospect
                        record will delete all the meeting notes associated with this
                        Prospect ?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                    <button type="button"
                            onclick="deleteProspectConfirmation('<?php echo $prospectId; ?>'); return false;"
                            class="btn green-meadow"><i class="fa fa-user-times"></i> Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
    <?php
}
if ($mode == '__DELETE_PROSPECT_CONFIRM__') {
    echo "SUCCESS||||";
    ?>
    <div id="prospectStatusConfirmation" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <div class="caption">
                        <h4><i class="icon-equalizer font-red-sunglo"></i> &nbsp;
                            <span
                                    class="caption-subject font-red-sunglo bold uppercase">Deleted Prospect Record</span>
                        </h4>
                    </div>

                </div>

                <div class="modal-body">
                    <p class="alert alert-success"><i class="fa fa-check"></i> Selected Prospect has been successfully
                        deleted.</p>
                </div>
                <div class="modal-footer">
                    <a href="<?php echo __BASE_URL__; ?>/prospect/prospectRecord" class="btn dark btn-outline">Close</a>
                </div>
            </div>
        </div>
    </div>

    <?php
}
if ($mode == '__PROSPECT_STATUS_EDIT_POPUP_FORM__') {
    echo "SUCCESS||||";
    ?>

    <div id="editProspectStatus" class="modal fade" tabindex="-2" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <div class="modal-title">
                        <div class="caption">
                            <h4><i class="icon-equalizer font-red-sunglo"></i> &nbsp;
                                <span class="caption-subject font-red-sunglo bold uppercase">Change Prospect Status</span>
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <form action="" id="changeStatus" name="changeStatus" method="post"
                          class="form-horizontal form-row-sepe">
                        <div class="form-body">
                            <?php $prospectStatusDetailsAry = $this->Prospect_Model->getProspectDetailsByProspectsId($idProspect);
                            ?>
                            <div
                                    class="form-group <?php if (form_error('changeStatus[szClient]')) { ?>has-error<?php } ?>">
                                <label class="control-label col-md-4"> Status</label>
                                <div class="col-md-5">
                                    <div class="search">
                                        <div id='changeStatus'>
                                            <select class="form-control " name="changeStatus[status]"
                                                    id="changeStatusVal"
                                                    Placeholder="Status" onfocus="remove_formError(this.id,'true')"
                                                    onchange="showSubmit(this.value);">

                                                <option value=''>Status</option>
                                                <?php if (($prospectStatusDetailsAry['status'] == 3) || ($prospectStatusDetailsAry['status'] == 2)) { ?>
                                                    <option value="1"
                                                            disabled <?php echo(sanitize_post_field_value($prospectStatusDetailsAry['status']) == trim("1") ? "selected " : ""); ?>>
                                                        Pre Discovery
                                                    </option>
                                                <?php } else { ?>
                                                    <option value="1" <?php echo(sanitize_post_field_value($prospectStatusDetailsAry['status']) == trim("1") ? "selected disabled" : ""); ?>>
                                                        Pre Discovery
                                                    </option>
                                                <?php } ?>
                                                <option value="2" <?php echo(sanitize_post_field_value($prospectStatusDetailsAry['status']) == trim("2") ? "selected disabled" : ""); ?>>
                                                    Discovery Meeting
                                                </option>
                                                <option value="3" <?php echo(sanitize_post_field_value($prospectStatusDetailsAry['status']) == trim("3") ? "selected disabled" : ""); ?>>
                                                    In Progress
                                                </option>
                                                <option value="4" <?php echo(sanitize_post_field_value($prospectStatusDetailsAry['status']) == trim("4") ? "selected disabled" : ""); ?>>
                                                    Non Convertible
                                                </option>
                                                <option value="5" <?php echo(sanitize_post_field_value($prospectStatusDetailsAry['status']) == trim("5") ? "selected disabled" : ""); ?>>
                                                    Contact Later
                                                </option>
                                                <option value="6" <?php echo(sanitize_post_field_value($prospectStatusDetailsAry['status']) == trim("6") ? "selected disabled" : ""); ?>>
                                                    Closed Sale
                                                </option>

                                            </select>
                                        </div>
                                    </div>
                                    <?php
                                    if (form_error('changeStatus[status]')) {
                                        ?>
                                        <span class="help-block pull-left">
                                        <span><?php echo form_error('changeStatus[status]'); ?></span>
                                        </span><?php } ?>
                                </div>
                            </div>
                            <input type="hidden" name="statusValue" id='statusValue'
                                   value="<?php echo $prospectStatusDetailsAry['0']['status']; ?>"/>
                            <input type="hidden" name="idProspect" id='idProspect' value="<?php echo $idProspect; ?>"/>
                        </div>
                    </form>
                    <div class="portlet green-meadow box">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-cogs"></i> Status Change Info

                            </div>

                        </div>
                        <?php $prospectStatusDetailsAry = $this->Prospect_Model->getProspectStatusDetails($idProspect, 1);
                        ?>
                        <div class="portlet-body">
                            <div class="portlet-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                        <tr>
                                            <th> Sr No</th>
                                            <th> Status</th>
                                            <th> Updated By</th>
                                            <th> Updated On</th

                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $i = 0;
                                        foreach ($prospectStatusDetailsAry as $prospectStatusDetailsData) {
                                            $i++;
                                            ?>
                                            <tr>
                                                <td> <?php echo $i; ?> </td>
                                                <td>
                                                    <?php if ($prospectStatusDetailsData['status'] == 1) { ?>

                                                        <p title="Order Status"
                                                           class="label label-sm label-warning">
                                                            Pre Discovery
                                                        </p>
                                                        <?php
                                                    }
                                                    if ($prospectStatusDetailsData['status'] == 2) {
                                                        ?>
                                                        <p title="Order Status"
                                                           class="label label-sm label-primary">
                                                            Discovery Meeting
                                                        </p>
                                                        <?php
                                                    }
                                                    if ($prospectStatusDetailsData['status'] == 3) {
                                                        ?>
                                                        <p title="Order Status"
                                                           class="label label-sm label-info">
                                                            In Progress
                                                        </p>
                                                        <?php
                                                    }
                                                    if ($prospectStatusDetailsData['status'] == 4) {
                                                        ?>
                                                        <p title="Order Status"
                                                           class="label label-sm label-danger">
                                                            Non Convertible
                                                        </p>
                                                        <?php
                                                    }
                                                    if ($prospectStatusDetailsData['status'] == 5) {
                                                        ?>
                                                        <p title="Order Status"
                                                           class="label label-sm label-info">
                                                            Contact Later
                                                        </p>
                                                        <?php
                                                    }
                                                    if ($prospectStatusDetailsData['status'] == 6) {
                                                        ?>
                                                        <p title="Order Status"
                                                           class="label label-sm label-success">
                                                            Closed Sale
                                                        </p>
                                                        <?php
                                                    }
                                                    ?></td>
                                                <td>
                                                    <?php
                                                    if ($prospectStatusDetailsData['szUpdatedBy']) {
                                                        $franchiseeDetArr = $this->Admin_Model->getAdminDetailsByEmailOrId('', $prospectStatusDetailsData['szUpdatedBy']);
                                                        echo $franchiseeDetArr['szName'];
                                                    } else {
                                                        echo "N/A";
                                                    }
                                                    ?>
                                                </td>
                                                <td>  <?php
                                                    if ($prospectStatusDetailsData['dtUpdatedOn'] == '0000-00-00 00:00:00') {
                                                        echo "N/A";
                                                    } else {
                                                        echo date('d M Y', strtotime($prospectStatusDetailsData['dtUpdatedOn'])) . ' at ' . date('h:i A', strtotime($prospectStatusDetailsData['dtUpdatedOn']));
                                                    }
                                                    ?> </td>


                                            </tr>

                                        <?php } ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                    <?php if ($prospectStatusDetailsAry['0']['status'] == 1) ?>
                    <button type="button" id="submit_val"
                            onclick="editProspectStatusConfirmation('<?php echo $idProspect; ?>'); return false;"
                            class="btn green-meadow">Submit
                    </button>
                </div>
            </div>
        </div>
    </div>
    <?php
}
if ($mode == '__PROSPECT_STATUS_EDIT_POPUP_CONFIRMATION__') {
    echo "SUCCESS||||";
    ?>
    <div id="editProspectStatusConfirmation" class="modal fade" tabindex="-1" data-backdrop="static"
         data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4><i class="icon-equalizer font-red-sunglo"></i> &nbsp;
                        <span class="caption-subject font-red-sunglo bold uppercase">Change Status Confirmation</span>
                    </h4>
                </div>

                <div class="modal-body">
                    <p class="alert alert-success"><i class="fa fa-check"></i> Status has been changed successfully .
                    </p>
                </div>
                <div class="modal-footer">
                    <a href="<?php echo __BASE_URL__; ?>/prospect/view_prospect_details" class="btn dark btn-outline">Close</a>
                </div>
            </div>
        </div>
    </div>

    <?php
}
if ($mode == '__SHOW_MEETING_DESCRIPTION_POPUP__') {
    echo "SUCCESS||||";
    ?>


    <div id="showDescription" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <?php $descriptionDataArr = $this->Prospect_Model->getMettingDetailsById($idMeetingNote);
                ?>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <div class="caption">
                        <h4><i class="icon-equalizer font-red-sunglo"></i> &nbsp;
                            <span class="caption-subject font-red-sunglo bold uppercase">Meeting Note</span></h4>
                    </div>

                </div>


                <div class="modal-body">

                    <p> <?php echo $descriptionDataArr['szDescription'] ?> </p>

                </div>

                <div class="modal-footer">
                    <a href="" class="btn dark btn-outline" data-dismiss="modal">Close</a>
                </div>
            </div>
        </div>
    </div>


    <?php
}
if ($mode == '__IMPORT_CSV_POPUP__') {
    echo "SUCCESS||||";
    ?>
    <div id="static" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <div class="caption">
                        <h4><i class="icon-equalizer font-red-sunglo"></i> &nbsp;
                            <span class="caption-subject font-red-sunglo bold uppercase">Import Prospects</span></h4>
                    </div>

                </div>
                <div class="modal-body">
                    <form name="ProspectimportForm" id="ProspectimportForm" method="post"
                          action="<?= __BASE_URL__ ?>/prospect/importCsvData" class="form-horizontal"
                          enctype="multipart/form-data">
                        <div class="form-body">
                            <div class="form-group ">
                                <label class="col-md-3 control-label"> </label>
                                <div class="col-md-5">

                                    <div class="input-group">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input autocomplete="off" type="file" name="imp_prospects"
                                                       id='imp_prospects'
                                                       onfocus="remove_formError(this.id,'true')">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <span></span>
                                </div>
                                <div class="col-md-5">
                                    <span id="error" class="err"></span>
                                </div>

                            </div>
                            <br>
                            <input type="hidden" name="importProspects" value="1"/>
                            <?php if (($_SESSION['drugsafe_user']['iRole'] == 5) || ($_SESSION['drugsafe_user']['iRole'] == 1)) { ?>
                                <div class="form-group ">
                                    <label class="col-md-3 control-label">Franchisee</label>
                                    <div class="col-md-8">
                                        <div class="input-group">
                                            <select class="form-control" name="iFranchiseeId"
                                                    id="iFranchiseeId" Placeholder="Franchisee"
                                                    onfocus="remove_formError(this.id,'true')">
                                                <option value=''>Select</option>
                                                <?php
                                                $franchiseeAray = $this->Admin_Model->viewFranchiseeList(false, false);
                                                if (!empty($franchiseeAray)) {
                                                    foreach ($franchiseeAray as $franchiseeDetails) {
                                                        ?>
                                                        <option
                                                                value="<?php echo trim($franchiseeDetails['id']); ?>" <?php echo(sanitize_post_field_value($_POST['iFranchiseeId']) == trim($franchiseeDetails['id']) ? "selected" : ""); ?>><?php echo trim($franchiseeDetails['szName']); ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>

                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <span></span>
                                    </div>
                                    <div class="col-md-5">
                                        <span id="err" class="err"></span>
                                    </div>

                                </div>
                                <input type="hidden" id="adminOrOp" name="adminOrOp" value="1"/>
                            <?php } ?>
                        </div>


                        <div class="modal-footer">
                            <a href="" class="btn dark btn-outline" data-dismiss="modal">Close</a>
                            <input type="button" name="pricesimport" value="Import"
                                   onclick="import_csv_popup_confirmation()" class="btn green-meadow"/>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
    <?php
}
if ($mode == '__CHANGE_TO_CLIENT__') {
    echo "SUCCESS||||";
    ?>
    <div id="changeToClientStatus" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <div class="caption">
                        <h4><i class="icon-equalizer font-red-sunglo"></i> &nbsp;
                            <span class="caption-subject font-red-sunglo bold uppercase">Convert To Client</span>
                        </h4>
                    </div>

                </div>

                <div class="modal-body">
                    <p class="alert alert-warning"><i class="fa fa-exclamation-triangle"></i> Are you sure you want to
                        convert the selected Prospect to Client?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                    <button type="button"
                            onclick="changeToClientConfirmation('<?php echo $prospectId; ?>'); return false;"
                            class="btn green-meadow"><i class="fa fa-check"></i> Submit
                    </button>
                </div>
            </div>
        </div>
    </div>
    <?php
}
if ($mode == '__CHANGE_TO_CLIENT_CONFIRMATION__') {
    echo "SUCCESS||||";
    ?>
    <div id="changeToClientStatusConfirmation" class="modal fade" tabindex="-1" data-backdrop="static"
         data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4><i class="icon-equalizer font-red-sunglo"></i> &nbsp;
                        <span class="caption-subject font-red-sunglo bold uppercase">Convert To Client Confirmation</span>
                    </h4>
                </div>

                <div class="modal-body">
                    <p class="alert alert-success"><i class="fa fa-check"></i>Selected Prospect has been successfully
                        converted to Client .</p>
                </div>
                <div class="modal-footer">
                    <a href="<?php echo __BASE_URL__; ?>/franchisee/clientRecord" class="btn dark btn-outline">Close</a>
                </div>
            </div>
        </div>
    </div>

    <?php
}
if ($mode == '__CHANGE_TO_CLIENT_CONFIRMATION_FAIL__') {
    echo "ERROR||||";
    ?>
    <div id="changeToClientStatusConfirmation" class="modal fade" tabindex="-1" data-backdrop="static"
         data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4><i class="icon-equalizer font-red-sunglo"></i> &nbsp;
                        <span class="caption-subject font-red-sunglo bold uppercase">Convert To Client Confirmation</span>
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="portlet red box">
                        <div class="portlet-title">
                            <div class="caption">
                                <h5><b> Selected Prospect can't be converted to Client because of the following
                                        reason. Please try again!</b></h5>

                            </div>

                        </div>
                        <?php
                        $prospectAry = $this->Prospect_Model->getProspectDetailsByProspectsId($prospectId);
                        ?>
                        <div class="portlet-body">
                            <?php $validate = $this->Admin_Model->validateParentClientData($prospectAry, array(), $idclient);
                            if (!($validate)) {
                                $arErrorMessages = $this->Admin_Model->arErrorMessages;
                            }
                            ?>

                            <?php if ($arErrorMessages['abn']) { ?>
                                <p class="alert alert-danger"><i
                                            class="fa fa-exclamation-triangle"></i> <?php echo $arErrorMessages['abn']; ?>
                                </p>
                            <?php } ?>
                            <?php if ($arErrorMessages['szName']) { ?>
                                <p class="alert alert-danger"><i
                                            class="fa fa-exclamation-triangle"></i> <?php echo $arErrorMessages['szName']; ?>
                                </p>
                            <?php } ?>
                            <?php if ($arErrorMessages['szEmail']) { ?>
                                <p class="alert alert-danger"><i
                                            class="fa fa-exclamation-triangle"></i> <?php echo $arErrorMessages['szEmail']; ?>
                                </p>
                            <?php } ?>
                            <?php if ($arErrorMessages['szContactNumber']) { ?>
                                <p class="alert alert-danger"><i
                                            class="fa fa-exclamation-triangle"></i> <?php echo $arErrorMessages['szContactNumber']; ?>
                                </p>
                            <?php } ?>
                            <?php if ($arErrorMessages['szCity']) { ?>
                                <p class="alert alert-danger"><i
                                            class="fa fa-exclamation-triangle"></i> <?php echo $arErrorMessages['szCity']; ?>
                                </p>
                            <?php } ?><?php if ($arErrorMessages['szZipCode']) { ?>
                                <p class="alert alert-danger"><i
                                            class="fa fa-exclamation-triangle"></i> <?php echo $arErrorMessages['szZipCode']; ?>
                                </p>
                            <?php } ?><?php if ($arErrorMessages['szAddress']) { ?>
                                <p class="alert alert-danger"><i
                                            class="fa fa-exclamation-triangle"></i> <?php echo $arErrorMessages['szAddress']; ?>
                                </p>
                            <?php } ?><?php if ($arErrorMessages['szNoOfSites']) { ?>
                                <p class="alert alert-danger"><i
                                            class="fa fa-exclamation-triangle"></i> <?php echo $arErrorMessages['szNoOfSites']; ?>
                                </p>
                            <?php } ?>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                    <button type="button"
                            onclick="editProspectDetails('<?php echo $prospectId; ?>',1);"
                            class="btn green-meadow" name="submit"><i class="icon-pencil"></i> Edit Prospect
                    </button>

                </div>
            </div>
        </div>
    </div>

    <?php
}
if ($mode == '__VIEW_ASSIGN_CLIENT_POPUP__') {
    echo "SUCCESS||||";
    ?>


    <div id="AssignClient" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <div class="caption">
                        <h4><i class="icon-equalizer font-red-sunglo"></i> &nbsp;
                            <span class="caption-subject font-red-sunglo bold uppercase"> Assigned Client Details</span>
                        </h4>
                    </div>

                </div>
                <div class="modal-body">

                    <div class="portlet green-meadow box">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-cogs"></i> Assigned Client Info

                            </div>

                        </div>
                        <?php $agentAssignedClientDetails = $this->Franchisee_Model->getfranchiseeagentclients($franchiseeid, $idAgent);
                        ?>
                        <div class="portlet-body">
                            <?php
                            if (!empty($agentAssignedClientDetails)) {
                                ?>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                        <tr>
                                            <th> #</th>
                                            <th>Client Name</th>
                                            <th> Email</th>
                                            <th> Contact Number</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $i = 0;
                                        foreach ($agentAssignedClientDetails as $agentAssignedClientData) {
                                            $i++;
                                            ?>
                                            <tr>
                                                <td> <?php echo $i; ?> </td>
                                                <td> <?php echo $agentAssignedClientData['szName']; ?> </td>
                                                <td> <?php echo $agentAssignedClientData['szEmail']; ?> </td>
                                                <td> <?php echo $agentAssignedClientData['szContactNumber']; ?>
                                                </td>


                                            </tr>
                                        <?php } ?>

                                        </tbody>
                                    </table>
                                </div>
                            <?php } else {
                                echo "No Record Found";
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="" class="btn dark btn-outline" data-dismiss="modal">Close</a>
                </div>
            </div>
        </div>
    </div>

    <?php
}
if ($mode == '__ASSIGN_CORP_FRANCHISEE_CLIENT_POPUP_FORM__') {
    echo "SUCCESS||||";
    ?>
    <div id="assignfrClientPopupform" class="modal fade" tabindex="-2" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <div class="modal-title">
                        <div class="caption">
                            <h4><i class="icon-equalizer font-red-sunglo"></i> &nbsp;
                                <span class="caption-subject font-red-sunglo bold uppercase"> Franchisee-Client Assignment</span>
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <h4 class="modal-custom-heading"><i class="fa fa-users"></i> Assigned Franchisee</h4>
                    <hr>
                    <div class="table-reposnsive">
                        <?php if (!empty($NonCorpFranchiseeArr)) { ?>
                            <table class="table table-striped table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Franchisee Code</th>
                                    <th>Franchisee</th>
                                    <th>Email</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $clcount = 1;
                                foreach ($NonCorpFranchiseeArr as $franchiseedet) {
                                    $franchiseeDetsArr = $this->Webservices_Model->getuserdetails($franchiseedet['franchiseeid']);
                                    $franchiseeCode = $this->Franchisee_Model->getusercodebyuserid($franchiseedet['franchiseeid']);
                                    ?>
                                    <tr>
                                        <td><?php echo $clcount; ?></td>
                                        <td><?php echo $franchiseeCode['userCode']; ?></td>
                                        <td><?php echo $franchiseeDetsArr[0]['szName']; ?></td>
                                        <td><?php echo $franchiseeDetsArr[0]['szEmail']; ?></td>
                                        <!--                                        <td>-->
                                        <?php //echo $franchiseeDetsArr[0]['szContactNumber'];
                                        ?><!--</td>-->
                                        <td><a class="btn btn-circle btn-icon-only btn-default" id="unassignsite"
                                               title="Unassign Site"
                                               onclick="unassignSite(<?php echo $franchiseedet['id']; ?>);"
                                               href="javascript:void(0);"></i>
                                                <i class="fa fa-times" aria-hidden="true"></i>
                                            </a></td>
                                    </tr>
                                    <?php $clcount++;
                                }
                                ?>
                                </tbody>
                            </table>
                        <?php } else {
                            echo '</p>No non-corporate franchisee is assigned to this client.</p>';
                        } ?>
                    </div>
                    <hr/>
                    <h4 class="modal-custom-heading"><i class="fa fa-plus"></i> Assign Franchisee</h4>
                    <hr>
                    <form action="" id="assignClient" name="assignClient" method="post"
                          class="form-horizontal form-row-sepe">
                        <div class="form-body">
                            <div
                                    class="form-group <?php if (form_error('assignfrClient[szFranchisee]')) { ?>has-error<?php } ?>">
                                <label class="control-label col-md-4">Franchisee</label>
                                <div class="col-md-5">
                                    <div class="search">
                                        <div id='szClient'>
                                            <select class="form-control custom-select"
                                                    name="assignfrClient[szFranchisee]" id="szFranchisee"
                                                    onfocus="remove_formError(this.id,'true')">
                                                <option value="">Franchisee Name</option>
                                                <?php
                                                foreach ($clientlistArr as $clientList) {
                                                    echo '<option value="' . $clientList['id'] . '" >' . $clientList['szName'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <?php
                                    if (form_error('assignfrClient[szFranchisee]')) {
                                        ?>
                                        <span class="help-block pull-left">
                                        <span><?php echo form_error('assignfrClient[szFranchisee]'); ?></span>
                                        </span><?php } ?>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                    <button type="button"
                            onclick="assignFranchiseeClientConfirmation('<?php echo $clientid; ?>','<?php echo $regionId; ?>');"
                            class="btn green-meadow">Assign
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div id="popup_box_level1"></div>
    <?php
}
if ($mode == '__ASSIGN_CORP_FRANCHISEE_CLIENT_POPUP_CONFIRMATION__') {
    echo "SUCCESS||||";
    ?>
    <div id="clientFrAssignmentStatusConfirmation" class="modal fade" tabindex="-1" data-backdrop="static"
         data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4><i class="icon-equalizer font-red-sunglo"></i> &nbsp;
                        <span class="caption-subject font-red-sunglo bold uppercase">Franchisee Assignment Confirmation</span>
                    </h4>
                </div>

                <div class="modal-body">
                    <p class="alert alert-success"><i class="fa fa-check"></i> This Site has been successfully assigned
                        to the selected Franchisee.</p>
                </div>
                <div class="modal-footer">
                    <a href="<?php echo __BASE_URL__; ?>/franchisee/clientRecord" class="btn dark btn-outline">Close</a>
                </div>
            </div>
        </div>
    </div>

    <?php
}
if ($mode == '__SHOW_MEETING_NOTES_POPUP__') {
    echo "SUCCESS||||";
    ?>


    <div id="showMeetingNotes" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <?php $mettingsDetailsAry = $this->Prospect_Model->getAllMeetingDetailsByProspectsId($idProspect);
                ?>

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <div class="caption">
                        <h4><i class="icon-equalizer font-red-sunglo"></i> &nbsp;
                            <span class="caption-subject font-red-sunglo bold uppercase">Meeting Note</span></h4>
                        <?php if (!empty($mettingsDetailsAry)) { ?>
                            <?php if ($flag != 2) { ?>
                                <hr>
                                <div class='row'>
                                    <div class="actions">

                                        <div class=' col-md-7'>

                                        </div>
                                        <div class=' col-md-5'>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <a onclick="view_meeting_note_pdf('<?php echo $idProspect; ?>')"
                                               href="javascript:void(0);"
                                               class=" btn green-meadow">
                                                <i class="fa fa-file-pdf-o"></i> View Pdf </a>

                                            <a onclick="View_meeting_note_excel('<?php echo $idProspect; ?>')"
                                               href="javascript:void(0);"
                                               class=" btn green-meadow">
                                                <i class="fa fa-file-excel-o"></i> View Xls </a>
                                        </div>

                                    </div>
                                </div>
                            <?php }
                        } ?>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="portlet green-meadow box">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-sticky-note"></i> Meeting Note

                            </div>

                        </div>

                        <div class="portlet-body">

                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                    <?php if (!empty($mettingsDetailsAry)){ ?>
                                    <tr>
                                        <th>Sr No.</th>
                                        <th>Meeting Note</th>
                                        <th>Meeting Date/Time</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $i = 0;
                                    foreach ($mettingsDetailsAry as $mettingsDetailsData) {
                                         if(($mettingsDetailsData['dtCreatedOn']) == '0000-00-00 00:00:00'){
                                         $val = "N/A";  
                                            }
                                        else{
                                       $val = date('d M Y',strtotime($mettingsDetailsData['dtCreatedOn'])) . ' at '.date('h:i A',strtotime($mettingsDetailsData['dtCreatedOn']));   
                                     }   
                                        $i++;
                                        ?>
                                        <tr>
                                            <td> <?php echo $i; ?> </td>
                                            <?php
                                            $retval = $mettingsDetailsData['szDescription'];
                                            $string = preg_replace('/(?<=\S,)(?=\S)/', ' ', $mettingsDetailsData['szDescription']);
                                            $string = str_replace("\n", " ", $string);
                                            $array = explode(" ", $string);
                                            if (count($array) <= 15) {
                                                $retval = $string;
                                            } else {
                                                array_splice($array, 15);
                                                $retval = implode(" ", $array) . " ...";
                                                $retval .= '<a onclick="showDescription(' . $mettingsDetailsData['id'] . ',1);" href="javascript:void(0);" >Read more</a>';
                                            }
                                            ?>


                                            <td><?php echo $retval; ?></td>
                                            <td><?php echo $val; ?></td>

                                        </tr>
                                    <?php }
                                    } else echo "Not Found" ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <a href="" class="btn dark btn-outline" data-dismiss="modal">Close</a>
                </div>
            </div>
        </div>
    </div>
    <div id="popup_box_level2"></div>
    <?php
}
if ($mode == '__RECEIVE_ORDER_DETAILS_POPUP__') {
    echo "SUCCESS||||";
    ?>
    <div id="receiveOrder" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <div class="caption">
                        <h4><i class="icon-equalizer font-red-sunglo"></i> &nbsp;
                            <span class="caption-subject font-red-sunglo bold uppercase">Dispatched Order Details</span>
                        </h4>


                    </div>


                </div>

                <div class="modal-body">

                    <div class="portlet green-meadow box">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-cogs"></i> Order Info

                            </div>

                        </div>
                        <?php
                        $OrdersDetailsAray = $this->Order_Model->getOrderByOrderId($idOrder);
                        $franchiseeDetArr1 = $this->Admin_Model->getAdminDetailsByEmailOrId('', $OrdersDetailsAray['franchiseeid']);
                        $splitTimeStamp = explode(" ", $OrdersDetailsAray['createdon']);
                        $date1 = $splitTimeStamp[0];
                        $time1 = $splitTimeStamp[1];
                        $x = date("g:i a", strtotime($time1));
                        $date = explode('-', $date1);
                        $monthNum = $date['1'];
                        $dateObj = DateTime::createFromFormat('!m', $monthNum);
                        $monthName = $dateObj->format('M');
                        ?>
                        <div class="portlet-body">
                            <div class="row static-info">
                                <div class="col-md-5 name">
                                    Order #:
                                </div>
                                <div class="col-md-7 value">
                                    #<?php echo sprintf(__FORMAT_NUMBER__, $idOrder); ?>
                                </div>
                            </div>
                            <div class="row static-info">
                                <div class="col-md-5 name">
                                    Order Date & Time:
                                </div>
                                <div class="col-md-7 value">
                                    <?php echo date('d M Y', strtotime($OrdersDetailsAray['createdon'])) . ' at ' . date('h:i A', strtotime($OrdersDetailsAray['createdon'])); ?>
                                </div>
                            </div>
                            <?php if ($OrdersDetailsAray['status'] == 2) { ?>
                                <div class="row static-info">
                                    <div class="col-md-5 name">
                                        Dispatched Date & Time:
                                    </div>
                                    <div class="col-md-7 value">
                                        <?php echo date('d M Y', strtotime($OrdersDetailsAray['dispatchedon'])) . ' at ' . date('h:i A', strtotime($OrdersDetailsAray['dispatchedon'])); ?>
                                    </div>
                                </div>
                            <?php }
                            if ($OrdersDetailsAray['status'] == 3) { ?>
                                <div class="row static-info">
                                    <div class="col-md-5 name">
                                        Cancelled Date & Time:
                                    </div>
                                    <div class="col-md-7 value">
                                        <?php echo date('d M Y', strtotime($OrdersDetailsAray['canceledon'])) . ' at ' . date('h:i A', strtotime($OrdersDetailsAray['canceledon'])); ?>
                                    </div>
                                </div>
                            <?php }
                            if ($OrdersDetailsAray['last_changed']) { ?>
                                <!--
                                <div class="row static-info">
                                    <div class="col-md-5 name">
                                        Last updated Date & Time:
                                    </div>
                                    <div class="col-md-7 value">
                                        <?php echo date('d M Y', strtotime($OrdersDetailsAray['last_changed'])) . ' at ' . date('h:i A', strtotime($OrdersDetailsAray['last_changed'])); ?>
                                    </div>
                                </div>-->
                            <?php } ?>
                            <div class="row static-info">
                                <div class="col-md-5 name">
                                    Order Status:
                                </div>
                                <?php if ($OrdersDetailsAray['status'] == 1) { ?>
                                    <div class="col-md-7 value">
                                                    <span class="label label-sm label-warning">
                                                    Ordered </span>
                                    </div>

                                    <?php
                                }
                                if ($OrdersDetailsAray['status'] == 2) {
                                    ?>
                                    <div class="col-md-7 value">
                                                    <span class="label label-sm label-success">
                                                   Dispatched  </span>
                                    </div>

                                    <?php
                                }
                                if ($OrdersDetailsAray['status'] == 3) {
                                    ?>
                                    <div class="col-md-7 value">
                                                    <span class="label label-sm label-danger">
                                                  Canceled   </span>
                                    </div>

                                    <?php
                                }
                                if ($OrdersDetailsAray['status'] == 4) {
                                    ?>
                                    <div class="col-md-7 value">
                                                    <span class="label label-sm label-info">
                                                     </span>
                                    </div>

                                    <?php
                                }
                                ?>

                            </div>
                            <div class="row static-info">
                                <div class="col-md-5 name">
                                    Freight Price:
                                </div>
                                <div class="col-md-7 value">
                                    $<?php
                                    $dispatchDatesArr = $this->Order_Model->getTotalOrderDispatchDates($idOrder);
                                    $freightpriceval = number_format($OrdersDetailsAray['freightprice'], 2, '.', '');
                                    echo number_format($freightpriceval, 2, '.', ','); ?>
                                </div>
                            </div>
                            <div class="row static-info">
                                <div class="col-md-5 name">
                                    Total Price EXL GST:
                                </div>
                                <div class="col-md-7 value">
                                    $<?php
                                    echo number_format($OrdersDetailsAray['dispatched_price'], 2, '.', ','); ?>
                                </div>
                            </div>
                            <!--<div class="row static-info">
                                <div class="col-md-5 name">
                                    Dispatched Price:
                                </div>
                                <div class="col-md-7 value">
                                    $<?php
                            /*                                    echo number_format($OrdersDetailsAray['dispatched_price'], 2, '.', ','); */ ?>
                                </div>
                            </div>-->
                            <?php if ($_SESSION['drugsafe_user']['iRole'] == 1) { ?>
                                <div class="row static-info">
                                    <div class="col-md-5 name">
                                        Franchisee:
                                    </div>
                                    <div class="col-md-7 value">
                                        <?php echo $franchiseeDetArr1['szName'] ?>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <hr>
                      <div class="portlet green-meadow box">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-cogs"></i> Products Info

                            </div>

                        </div>
                        <?php $totalOrdersDetailsAray = $this->Order_Model->getOrderDetailsByOrderId($idOrder);
                        $totalDispatched = $this->Order_Model->getTotalOrderDispatchDates($idOrder,1);
                        ?>
                        <div class="portlet-body">
                            <div class="table-responsive">

                                    <?php
    if (!empty($totalDispatched)) {
        $i = 0;
        foreach ($totalDispatched as $DispatchOrderDetData) { ?>
<h4>Dispatched On: <?php echo date('d/m/Y h:i:s a',strtotime($DispatchOrderDetData['dispatch_date'])); ?></h4>
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th> Product Code</th>
                                        <th> Product Cost</th>
                                        <th> Dispatched Quantity</th>
                                        <th> Total Price EXL GST</th>
                                    </tr>
                                    </thead>
                                    <tbody>
        <?php
        $DispatchedOrdDetArr = $this->Order_Model->getDispatchedOrderDetByDispatchDate($DispatchOrderDetData['dispatch_date']);
        if(!empty($DispatchedOrdDetArr)) {
            $totalAmount = 0.00;
            foreach ($DispatchedOrdDetArr as $DispatchOrderDet) {
                $productDataArr = $this->Inventory_Model->getProductDetailsById($DispatchOrderDet['productid']);
                $totalAmount += number_format(($DispatchOrderDet['dispatch_qty']) * ($productDataArr['szProductCost']), 2, '.', '');?>
                <tr>
                    <td> <?php echo $productDataArr['szProductCode']; ?> </td>
                    <td> $<?php echo $productDataArr['szProductCost']; ?> </td>
                    <td> <?php echo (!empty($DispatchOrderDet['dispatch_qty'])?$DispatchOrderDet['dispatch_qty']:'N/A'); ?> </td>
                    <td> $<?php
                        echo number_format(($DispatchOrderDet['dispatch_qty']) * ($productDataArr['szProductCost']), 2, '.', ',') ; ?>
                    </td>
                </tr>
            <?php $i++; } ?>
            <tr><td colspan="3"><b>Total</b></td><td><b>$<?php echo number_format($totalAmount, 2, '.', ',');?></b></td></tr>
                                    <tr><td colspan="4" align="right"><button type="button"
                                                                onclick="receiveordstatus('<?php echo $idOrder; ?>','<?php echo $DispatchOrderDetData['dispatch_date'];?>');"
                                                                class="btn green-meadow" name="submit"><i class="icon-check"></i> Receive Order
                                            </button></td> </tr>
                                    </tbody>
            </table>
        <?php } ?>

        <?php }
    }
                                    /*foreach ($totalOrdersDetailsAray as $totalOrdersDetailsData) {
                                        $productDataArr = $this->Inventory_Model->getProductDetailsById($totalOrdersDetailsData['productid']); */?><!--
                                        <tr>
                                            <td> <?php /*echo $productDataArr['szProductCode']; */?> </td>
                                            <td> $<?php /*echo $productDataArr['szProductCost']; */?> </td>
                                            <td> <?php /*echo $totalOrdersDetailsData['quantity']; */?> </td>
                                            <td> $<?php
/*                                                echo number_format(($totalOrdersDetailsData['quantity']) * ($productDataArr['szProductCost']), 2, '.', ','); */?>
                                            </td>
                                            <td> <?php /*echo $totalOrdersDetailsData['dispatched']; */?> </td>
                                        </tr>
                                    <?php /*} */?>
                                    </tbody>
                                </table>-->
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <?php
}
if ($mode == '__RECEIVE_ORDER_CONFIRM_DETAILS_POPUP__') {
    echo "SUCCESS||||";
    if($data)
        {
    ?>
    ?>
    <div id="receiveOrderConfirmation" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <div class="caption">
                        <h4><i class="icon-equalizer font-red-sunglo"></i> &nbsp;
                            <span class="caption-subject font-red-sunglo bold uppercase"> Order Received</span></h4>
                    </div>

                </div>
                <div class="modal-body">
                    <p class="alert alert-success"><i class="fa fa-check"></i> Ordered Quantity has been
                        allocated successfully.</p>
                </div>
                <div class="modal-footer">
                    <?php
                    ?>
                     <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
<?php
     echo '||||'; 
         ?>      
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
                     <?php echo date('d M Y', strtotime($validOrdersDetailsData['createdon'])) . ' at ' . date('h:i A', strtotime($validOrdersDetailsData['createdon'])); ?>
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
                           onclick="view_order_details_pdf(<?php echo $validOrdersDetailsData['orderid']; ?>);"
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
            
    <?php    }
     
}
if ($mode == '__CHANGE_PASSWORD_AGENT_EMPLOYE_POPUP__') {
    echo "SUCCESS||||";
    ?>
    <div id="agentChangePassword" class="modal fade" tabindex="-2" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <div class="modal-title">
                        <div class="caption">
                            <h4><i class="icon-equalizer font-red-sunglo"></i> &nbsp;
                                <span class="caption-subject font-red-sunglo bold uppercase">Change Password</span>
                            </h4>
                        </div>

                    </div>
                </div>
                <div class="modal-body">
                    <form action="" id="changePasswordForm" name="changePassword" method="post"
                          class="form-horizontal form-row-sepe">
                        <div class="form-body">
                            <div
                                    class="form-group <?php if (form_error('changePassword[szNewPassword]')) { ?>has-error<?php } ?>">
                                <label class="control-label col-md-4">New Password</label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <input id="szNewPassword"
                                               class="form-control input-large select2me input-square-right required  "
                                               type="password"
                                               value="<?php echo set_value('changePassword[szNewPassword]'); ?>"
                                               placeholder="New Password" onfocus="remove_formError(this.id,'true')"
                                               name="changePassword[szNewPassword]">
                                    </div>
                                    <?php
                                    if (form_error('changePassword[szNewPassword]')) {
                                        ?>
                                        <span class="help-block pull-left">
                                        <span><?php echo form_error('changePassword[szNewPassword]'); ?></span>
                                        </span><?php } ?>
                                </div>
                            </div>
                            <div
                                    class="form-group <?php if (form_error('changePassword[szConfirmPassword]')) { ?>has-error<?php } ?>">
                                <label class="control-label col-md-4">Confirm Password</label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <input id="szConfirmPassword"
                                               class="form-control input-large select2me input-square-right required  "
                                               type="password"
                                               value="<?php echo set_value('changePassword[szConfirmPassword]'); ?>"
                                               placeholder="Confirm Password" onfocus="remove_formError(this.id,'true')"
                                               name="changePassword[szConfirmPassword]">
                                    </div>
                                    <?php
                                    if (form_error('changePassword[szConfirmPassword]')) {
                                        ?>
                                        <span class="help-block pull-left">
                                        <span><?php echo form_error('changePassword[szConfirmPassword]'); ?></span>
                                        </span><?php } ?>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>

                    <button type="button"
                            onclick="changeAgentPasswordConfirmation('<?php echo $agentId; ?>'); return false;"
                            class="btn green-meadow">Submit
                    </button>
                </div>
            </div>
        </div>
    </div>
    <?php
}
if ($mode == '__CHANGE_PASSWORD_AGENT_EMPLOYE_CONFIRM__') {
    echo "SUCCESS||||";
    ?>
    <div id="agentChangePasswordConfirmation" class="modal fade" tabindex="-1" data-backdrop="static"
         data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <div class="modal-title">
                        <div class="caption">
                            <h4><i class="icon-equalizer font-red-sunglo"></i> &nbsp;
                                <span class="caption-subject font-red-sunglo bold uppercase">Changed Password</span>
                            </h4>
                        </div>

                    </div>
                </div>
                <div class="modal-body">
                    <p class="alert alert-success"><i class="fa fa-check"></i> Agent Password has been successfully
                        changed , Please check the email.</p>
                </div>
                <div class="modal-footer">
                    <a href="<?php echo __BASE_URL__; ?>/franchisee/agentRecord"
                </div>
            </div>
        </div>
    </div>
    <?php
}
if ($mode == '__UNASSIGN_SITE_POPUP__') {
    echo "SUCCESS||||";
    ?>
    <div id="unassignSiteAlert" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <div class="caption">
                        <h4><i class="icon-equalizer font-red-sunglo"></i> &nbsp;
                            <span class="caption-subject font-red-sunglo bold uppercase">Unassign Site</span></h4>
                    </div>

                </div>
                <div class="modal-body">
                    <p class="alert alert-warning"><i class="fa fa-exclamation-triangle"></i> Are you sure you want to
                        unassign this site?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>

                    <button type="button" onclick="unassignSiteConfirmation('<?php echo $mapid; ?>'); return false;"
                            class="btn green-meadow"><i class="fa fa-times"></i> Unassign
                    </button>
                </div>
            </div>
        </div>
    </div>
    <?php
}
if ($mode == '__UNASSIGN_SITE_CONFIRM_POPUP__') {
    echo "SUCCESS||||";
    ?>
    <div id="unassignSiteConfirmation" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <div class="caption">
                        <h4><i class="icon-equalizer font-red-sunglo"></i> &nbsp;
                            <span class="caption-subject font-red-sunglo bold uppercase">Unassign Site</span></h4>
                    </div>

                </div>

                <div class="modal-body">
                    <p class="alert alert-success"><i class="fa fa-check"></i> Site has been successfully unassigned.
                    </p>
                </div>
                <div class="modal-footer">
                    <a href="<?php echo __BASE_URL__; ?>/franchisee/viewClientDetails" class="btn dark btn-outline">Close</a>
                </div>
            </div>
        </div>
    </div>

    <?php
}
?>