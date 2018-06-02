<?php
if ($mode == '__VIEW_PRODUCT_POPUP__') {
    echo "SUCCESS||||";
       if($flag==1){
     $msg = "Drug Test Kit" ;
    }
    elseif($flag==2){
      $msg = "Marketing Material" ;   
    }
     elseif($flag==3){
      $msg = "Consumables" ;   
    }
    else{
      $msg = "Inventory Product Info" ;   
    }
    ?>
    <div id="ViewProductDetails" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <div class="caption">
                        <h4><i class="icon-equalizer font-red-sunglo"></i> &nbsp;
                        <span class="caption-subject font-red-sunglo bold uppercase">Inventory Product Details</span></h4>
                    </div>
                </div>

                <div class="modal-body">

                    <div class="portlet green-meadow box">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-cogs"></i> <?php echo $msg;?>

                            </div>

                        </div>
                        <?php   $productDataAry = $this->Inventory_Model->getProductDetailsById($idProduct);
                        if($productDataAry['supplier']==''){
                          $productDataAry['supplier'] = 'N/A';  
                        }
                        else{
                           $productDataAry['supplier'] = $productDataAry['supplier'];    
                        }
                        ?>
                        <div class="portlet-body">
                            <div class="row static-info">
                                <div class="col-md-5 name ">
                                    <img class="file_preview_image" src="<?php echo __BASE_USER_PRODUCT_IMAGES_URL__; ?>/<?php echo $productDataAry['szProductImage']; ?>" width="60" height="60"/>
                                </div>
                                <div class="col-md-7 value Text_align_popup  ">
                                    <?php echo $productDataAry['szProductCode']; ?>
                                </div>
                            </div>
                             <div class="row static-info">
                           
                            </div>
                             <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    
                                    <tbody>
                                        <tr>
                                            <td><b>Description:- </b><?php echo $productDataAry['szProductDiscription']; ?> </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                             <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>Cost</th>
                                        <th> Expiry Date</th>
                                        <th>Supplier Name</th>
                                        <th>Available Quantity</th>
                                        <th>Minimum Order Quantity</th>
                                        <th>Model Stock Value</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                             <td> $<?php echo $productDataAry['szProductCost'];?> </td>
                                             <td><?php 
                                            $date= $productDataAry['dtExpiredOn'];
                                            $dtExpiredOn = date("d-m-Y", strtotime($date)); 
                                            echo ($dtExpiredOn == '01-01-1970'?'N/A':$dtExpiredOn);?> </td>
                                             <td> <?php echo $productDataAry['supplier'];?> </td>
                                            <td> <?php echo $productDataAry['szAvailableQuantity'];?> </td>
                                           <td> <?php echo $productDataAry['min_ord_qty'];?> </td>
                                            <td> <?php echo $productDataAry['model_stk_val'];?> </td>

                                        </tr>
                               
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
?>