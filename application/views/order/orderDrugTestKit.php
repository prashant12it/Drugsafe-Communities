<script type='text/javascript'>
    $(function() {
        $("#szSearchProdCode").customselect();
    });
</script>
<div class="page-content-wrapper">
        <div class="page-content">
          
             <?php 
            if(!empty($_SESSION['drugsafe_user_message']))
            {
                    if(trim($_SESSION['drugsafe_user_message']['type']) == "success")
                    {
                    ?>
                        <div class="alert alert-success">
                            <?php echo $_SESSION['drugsafe_user_message']['content'];?>
                        </div>
                    <?php

                    }
                    if(trim($_SESSION['drugsafe_user_message']['type']) == "error")
                    {
                    ?>
                        <div class="alert alert-danger">
                            <?php echo $_SESSION['drugsafe_user_message']['content'];?>
                        </div>
                    <?php
                    }
                    $this->session->unset_userdata('drugsafe_user_message');
            }
            ?>
            <div id="page_content" class="row">
                <div class="col-md-12">
                    <ul class="page-breadcrumb breadcrumb">
                        <li>
                            <a href="<?php echo __BASE_URL__;?>">Home</a>
                            <i class="fa fa-circle"></i>
                        </li>
                        <li>
                            <span class="active">Drug Test Kit </span>
                        </li>
                    </ul>
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-equalizer font-red-sunglo"></i>
                                <span class="caption-subject font-red-sunglo bold uppercase">Drug Test Kit</span>
                            </div>
                      
                         <div class="actions">
                                <a class="btn btn-circle btn-icon-only btn-default" title="Add To Cart" onclick="redirect_url('<?php echo base_url(); ?>order/orderList');" href="javascript:void(0);">
                                    <i class="icon-basket"></i>
                                   
                                </a>
                                 <?php  $totalOrdersArr =$this->Order_Model->getOrdersList();
                     
                                    $count=0;
                                    foreach($totalOrdersArr as $totalOrdersData){
   
                                       $count++; 

                                     }?>
                              <span class="badge badge-danger" onclick="redirect_url('<?php echo base_url(); ?>order/orderList');"><?php echo $count;?></span>
                            </div>
                          </div>
                        <?php
                        
                        if(!empty($drugTestKitAray))
                        {
                           ?>
                        
                           <div class="row">
                                <form class="form-horizontal" id="szSearchDrugTestList" action="<?=__BASE_URL__?>/order/drugtestkit " name="szSearchDrugTestList" method="post">
                                    <div class="search col-md-3">
                                        <select class="form-control custom-select" name="szSearchProdCode" id="szSearchProdCode" onfocus="remove_formError(this.id,'true')">
                                            <option value="">Product Code</option>
                                            <?php
                                            foreach($drugtestkitlist as $drugItem)
                                            {
                                                $selected = ($drugItem['szProductCode'] == $_POST['szSearchProdCode'] ? 'selected="selected"' : '');
                                                echo '<option value="'.$drugItem['szProductCode'].'" ' . $selected . ' >'.$drugItem['szProductCode'].'</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-1">
                                           <button class="btn green-meadow" type="submit" ><i class="fa fa-search"></i></button>
                                    </div>
                                </form>
                            </div>
                            <div class="row">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                          <tr>
                                                <th> Image </th>
                                                <th> Product Code</th>
                                                <th>  Description</th>
                                                <th>  Cost</th>
                                                 <th>  Model Stock Value</th>
                                                 <th>  Available Stock Quantity</th>
                                                 <th>  Minimum Order Quantity</th>
                                                <th style="width:60px;">  Quantity</th>
                                                <th>  Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                               $i = 1;
                                                foreach($drugTestKitAray as $drugTestKitData)
                                                { 
                                                    $idfranchisee = $_SESSION['drugsafe_user']['id'];
                                          
                                                   $drugTestKitDataArr = $this->StockMgt_Model->getStockValueDetailsById($idfranchisee,$drugTestKitData['id']);
                                                   $modelStockDataAry = $this->StockMgt_Model->getProductQtyDetailsById($idfranchisee,$drugTestKitData['id']);

                                                
                                                   ?>
                                                <tr>
                                                    <td>
                                                        <img class="file_preview_image" src="<?php echo __BASE_USER_PRODUCT_IMAGES_URL__; ?>/<?php echo $drugTestKitData['szProductImage']; ?>" width="60" height="60"/>    
                                                    </td>
                                                    <td><?php echo $drugTestKitData['szProductCode']?> </td>
                                                    <td> <?php echo $drugTestKitData['szProductDiscription'];?> </td>
                                                    <td> $<?php echo $drugTestKitData['szProductCost'];?> </td>
<!--                                                 <?php 
                                                    $date= $drugTestKitData['dtExpiredOn'];
                                                    $dtExpiredOn = date("d-m-Y", strtotime($date)); 
                                                    echo $dtExpiredOn;?> </td>-->
                                                     <td><?php echo($drugTestKitDataArr['szModelStockVal'] > 0 ? $drugTestKitDataArr['szModelStockVal'] : 'N/A')?></td>
                                                    <td><?php echo($modelStockDataAry['szQuantity'] > 0 ? $modelStockDataAry['szQuantity'] : 'N/A')?></td>
                                                     <td><?php echo($drugTestKitData['min_ord_qty'] > 0 ? $drugTestKitData['min_ord_qty'] : 'N/A')?></td>
                                         
                                                    <td>
                                                         <input type="number"min="<?php echo($drugTestKitData['min_ord_qty'] > 0 ? $drugTestKitData['min_ord_qty'] : '1')?>"  class="form-control btn-xs "  name="order_quantity<?php echo $i;?>" id="order_quantity<?php echo $i;?>" >
                                                    </td>
                                                    <td>
                                                        <a class="btn btn-circle btn-icon-only btn-default" title="Add To Cart" onclick="placeOrder('<?php echo $drugTestKitData['id'];?>','<?php echo $i;?>','1');" href="javascript:void(0);">
                                                            <i class="fa fa-cart-plus"></i> 
                                                        </a>
                                                    </td>
                                                </tr>
                                               <?php
                                               $i++;
                                              }
                                           ?>

                                        </tbody>
                                     </table>
                                     </div>
                            </div>
                             <?php
                            
                        }
                        else
                        {
                            echo "Not Found";
                        }
                        ?>
                        <?php  if(!empty($drugTestKitAray)){?>
		<div class="row">
                  
                    <div class="col-md-7 col-sm-7">
                        <div class="dataTables_paginate paging_bootstrap_full_number">
                            <?php echo $this->pagination->create_links();?>
                        </div>
                    </div>
	    	
                 
            </div>
    	<?php }?>
               </div>
                </div>
            </div> 
        </div>
    </div>
</div>
<div id="popup_box"></div>