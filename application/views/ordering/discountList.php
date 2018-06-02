<div class="page-content-wrapper">
        <div class="page-content">
            <div id="page_content" class="row">
                <div class="col-md-12">
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-equalizer font-red-sunglo"></i>
                                <span class="caption-subject font-red-sunglo bold uppercase">Discount Percentage List</span>
                            </div>
                            <?php if ($_SESSION['drugsafe_user']['iRole'] == 1) { ?>
                            <div class="actions">
                                <div class="btn-group btn-group-devided" data-toggle="buttons">
                                    <button class="btn btn-sm green-meadow" onclick="redirect_url('<?php echo base_url();?>ordering/createDiscount');">
                                        &nbsp;Create Discount
                                    </button>
                                </div>
                            </div>
                            <?php
                            
                            }?>
             
                             
                        </div>
                        <?php
                        
                        if(!empty($getAllDiscountAry))
                        {
                           
                            ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th> #</th>
                                        <th> Discount Percentage</th>
                                        <th> Description</th>
                                         <?php if ($_SESSION['drugsafe_user']['iRole'] == 1) { ?>
                                        <th> Action</th>
                                         <?php }?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                       $i = 0;
                                        foreach($getAllDiscountAry as $getAllDiscountData)
                                        {
											$getAssignedDiscountArr=$this->Ordering_Model->getAssignedDiscount($getAllDiscountData['id']);
											$deletableDiscount = true;
											if(!empty($getAssignedDiscountArr)){
												$deletableDiscount = false;
											}
                                            $i++;
                                        ?>
                                        <tr>
                                            <td> <?php echo $i;?> </td>
                                            <td> <?php echo $getAllDiscountData['percentage']?>% </td>
                                            <td> <?php echo $getAllDiscountData['description'];?> </td>
                                             <?php if ($_SESSION['drugsafe_user']['iRole'] == 1) { ?>
                                            <td>
                                                <a class="btn btn-circle btn-icon-only btn-default" title="Edit Discount Data" onclick="editDiscountDetails('<?php echo $getAllDiscountData['id'];?>');" href="javascript:void(0);">
                                                    <i class="fa fa-pencil"></i> 
                                                </a>
                                                 <a class="btn btn-circle btn-icon-only btn-default" id="viewStatus" title="View Discount" onclick="discountView(<?php echo $getAllDiscountData['id'];?>);" href="javascript:void(0);"></i>
                                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                                </a>
												<?php if($deletableDiscount){ ?>
                                                <a class="btn btn-circle btn-icon-only btn-default" id="userStatus" title="Delete Discount" onclick="discountDelete(<?php echo $getAllDiscountData['id'];?>);" href="javascript:void(0);"></i>
                                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                                </a>
                                                <?php } ?>
                                            </td>
                                        <?php } ?>
                                            
                                        </tr>
                                        <?php 
                                        }
                                   ?>
                                </tbody>
                            </table>
                        </div>
                             <?php
                            
                        }
                        else
                        {
                            echo "Not Found";
                        }
                        ?>
                        
                    </div>
                </div>
            </div> 
        </div>
    </div>
</div>
<div id="popup_box"></div>