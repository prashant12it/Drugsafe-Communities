<div class="page-content-wrapper">
<!-- BEGIN CONTENT BODY -->
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
      <ul class="page-breadcrumb breadcrumb">
                        <li>
                            <a href="<?php echo __BASE_URL__;?>/admin/franchiseeList">Home</a>
                            <i class="fa fa-circle"></i>
                        </li>
                        <li>
                        <a onclick="viewClient(<?php echo $franchiseeArr['id'];?>);" href="javascript:void(0);"><?php echo $franchiseeArr['szName'];?></a>
                        <i class="fa fa-circle"></i>
                        </li>
                        <li>
                            <span class="active">Product Quantity Management</span>
                        </li>
     </ul>
     <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <i class="icon-equalizer font-red-sunglo"></i>&nbsp; &nbsp;
                <span class="caption-subject  bold uppercase font-red-sunglo">Product Quantity Management</span>
            </div>
            
        </div>
    <div class="portlet-body">
        
        <div class="tabbable tabbable-tabdrop">
            <ul class="nav nav-tabs">
              <?php 
        
            if(!empty($_SESSION['drugsafe_tab_status']))
            {
                if($_SESSION['drugsafe_tab_status']==1){
                  $drActive ='active'; 
                }
                 elseif($_SESSION['drugsafe_tab_status']==2){
                  $mrActive ='active'; 
                }
                else {
                  $conActive ='active';   
                }
           $this->session->unset_userdata('drugsafe_tab_status');
            }
        else {
               $drActive ='active'; 
     
 }
            ?>
                <li class=" <?php echo $drActive?> ">
                        <a href="#tab1" data-toggle="tab">Drug Test Kit List</a>
                </li>
                 <li class="<?php echo $mrActive?>">
                        <a href="#tab2" data-toggle="tab">Marketing Material List</a>
                </li>
                 <li class="<?php echo $conActive?>">
                        <a href="#tab3" data-toggle="tab">Consumables List</a>
                </li>
            </ul>
                 <div class="tab-content">
                     <div class="tab-pane <?php echo $drActive?>" id="tab1">
                        <div id="page_content" class="row">
                            <div class="col-md-12">
                                <div class="portlet light bordered">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="icon-equalizer font-red-sunglo"></i>
                                            <span class="caption-subject font-red-sunglo bold uppercase">Drug Test Kit</span>
                                        </div>
                                       </div>
                                    <?php

                                    if(!empty($drugTestKitAray))
                                    {

                                        ?>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th> Image </th>
                                                    <th> Product Code</th>
                                                    <th> Description</th>
                                                    <th> Cost</th>
                                                    <th>Quantity </th>
<!--                                                    <th>Quantity Assign By </th>
                                                    <th>Quantity Updated By  </th>-->
                                                    <th> Action </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                   $i = 0;
                                                    foreach($drugTestKitAray as $drugTestKitData)
                                                    {        
                                                        $idfranchisee = $franchiseeArr['id'];
                                                    if($_SESSION['drugsafe_user']['iRole']==5){
                                                          $drugTestKitDataArr = $this->StockMgt_Model->getProductQtyDetailsById($idfranchisee,$drugTestKitData['iProductId']);
                                                          $qtyAssignDataArr = $this->StockMgt_Model->getQtyAssignTrackingDetailsById($idfranchisee,$drugTestKitData['iProductId']);
                                                          $qtyUpdateDataArr = $this->StockMgt_Model->getQtyUpdateTrackingDetailsById($idfranchisee,$drugTestKitData['iProductId']);
                                                          $qtyUpdateData1Arr =end($qtyUpdateDataArr);
                                                    } else
                                                        {
                                                          $drugTestKitDataArr = $this->StockMgt_Model->getProductQtyDetailsById($idfranchisee,$drugTestKitData['id']); 
                                                          $qtyAssignDataArr = $this->StockMgt_Model->getQtyAssignTrackingDetailsById($idfranchisee,$drugTestKitData['id']);
                                                          $qtyUpdateDataArr = $this->StockMgt_Model->getQtyUpdateTrackingDetailsById($idfranchisee,$drugTestKitData['id']);
                                                          $qtyUpdateData1Arr =end($qtyUpdateDataArr);
                                                    }
                                                            
                                                          
                                                        
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <img class="file_preview_image" src="<?php echo __BASE_USER_PRODUCT_IMAGES_URL__; ?>/<?php echo $drugTestKitData['szProductImage']; ?>" width="60" height="60"/>    
                                                        </td>
                                                        <td> <?php echo $drugTestKitData['szProductCode']?> </td>
                                                        <td> <?php echo $drugTestKitData['szProductDiscription'];?> </td>
                                                        <td> $<?php echo $drugTestKitData['szProductCost'];?> </td>
                                                       <?php  if($_SESSION['drugsafe_user']['iRole']==5){?>
                                                        <td><?php echo($drugTestKitData['szQuantity'] > 0 ? $drugTestKitData['szQuantity'] : 'N/A')?></td>
                                                       <?php } else { ?> 
                                                        <td><?php echo($drugTestKitDataArr['szQuantity'] > 0 ? $drugTestKitDataArr['szQuantity'] : 'N/A')?></td>
                                                       <?php }?>
<!--                                                        <td>
                                                        <?php 
                                                        if($qtyAssignDataArr['szAssignBy'])
                                                        {
                                                            $franchiseeDetArr = $this->Admin_Model->getAdminDetailsByEmailOrId('',$qtyAssignDataArr['szAssignBy']);
                                                            echo $franchiseeDetArr['szName'];
                                                        }
                                                        else
                                                        {
                                                           echo "N.A";
                                                        }

                                                        ?> 
                                                    </td>-->
                                                        
<!--                                                        <td>
                                                             <?php 
                                                        if($qtyUpdateData1Arr['szLastUpdatedBy'])
                                                        {
                                                            $franchiseeDetArr = $this->Admin_Model->getAdminDetailsByEmailOrId('',$qtyUpdateData1Arr['szLastUpdatedBy']);
                                                            if(empty($qtyAssignDataArr['szAssignBy'])){
                                                              echo "N.A";   
                                                            }
                                                            else{
                                                                 echo $franchiseeDetArr['szName'];
                                                            }
                                                           
                                                        }
                                                        else
                                                        {
                                                           echo "N.A";
                                                        }

                                                        ?> 
                                                    </td>-->
                                                        <td>
                                                            <?php if(empty($drugTestKitDataArr['szQuantity']) && ($drugTestKitDataArr['szQuantity'] != '0')){?>
                                                            <a class="btn btn-circle btn-icon-only btn-default" title="Add Product Stock Quantity" onclick="addProductStockQuantity(<?php echo $drugTestKitData['id'];?>);" href="javascript:void(0);">
                                                                <i class="fa fa-plus"></i> 
                                                            </a>
                                                            <?php }else{?>
                                                            <?php  if($_SESSION['drugsafe_user']['iRole']==5){?>
                                                        <a class="btn btn-circle btn-icon-only btn-default" title="Adjust Quantity" onclick="editProductStockQuantity(<?php echo $drugTestKitData['iProductId'];?>,'1');" href="javascript:void(0);">
                                                                <i class="fa fa-minus"></i> 
                                                            </a>
                                                           <a class="btn btn-circle btn-icon-only btn-default" title=" Add More Product Stock Quantity" onclick="editProductStockQuantity(<?php echo $drugTestKitData['iProductId'];?>,'2');" href="javascript:void(0);">
                                                                <i class="fa fa-plus"></i> 
                                                            </a>
                                                       <?php } else { ?> 
                                                      
                                                             <a class="btn btn-circle btn-icon-only btn-default" title="Adjust Quantity" onclick="editProductStockQuantity(<?php echo $drugTestKitData['id'];?>,'1');" href="javascript:void(0);">
                                                                <i class="fa fa-minus"></i> 
                                                            </a>
                                                           <a class="btn btn-circle btn-icon-only btn-default" title=" Add More Product Stock Quantity" onclick="editProductStockQuantity(<?php echo $drugTestKitData['id'];?>,'2');" href="javascript:void(0);">
                                                                <i class="fa fa-plus"></i> 
                                                            </a>
                                                            <?php }?>
                                                           <?php }?>  
                                                        </td>
                                                    </tr>
                                                    <?php
                                                    $i++;
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
                 <div id="popup_box"></div>   
            </div>
<div class="tab-pane <?php echo $mrActive?>" id="tab2">
    <div id="page_content" class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-equalizer font-red-sunglo"></i>
                        <span class="caption-subject font-red-sunglo bold uppercase">Marketing Material</span>
                    </div>
               

                </div>
                <?php

                if(!empty($marketingMaterialAray))
                {
                    ?>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th> Image </th>
                                <th> Product Code</th>
                                <th> Description</th>
                                <th> Cost</th>
                                <th> Quantity </th>
<!--                                <th>Quantity Assign By </th>
                                <th>Quantity Updated By  </th>-->
                                <th> Action </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                               $i = 0;
                                foreach($marketingMaterialAray as $marketingMaterialData)
                                {  
                                     $idfranchisee = $franchiseeArr['id'];
                                        if($_SESSION['drugsafe_user']['iRole']==5){
                                               $marketingMaterialDataArr = $this->StockMgt_Model->getProductQtyDetailsById($idfranchisee,$marketingMaterialData['iProductId']);
                                              $qtyAssignDataArr = $this->StockMgt_Model->getQtyAssignTrackingDetailsById($idfranchisee,$marketingMaterialData['iProductId']);
                                              $qtyUpdateDataArr = $this->StockMgt_Model->getQtyUpdateTrackingDetailsById($idfranchisee,$marketingMaterialData['iProductId']);
                                              $qtyUpdateData1Arr =end($qtyUpdateDataArr);
                                        } else
                                            {
                                            $marketingMaterialDataArr = $this->StockMgt_Model->getProductQtyDetailsById($idfranchisee,$marketingMaterialData['id']);
                                            $qtyAssignDataArr = $this->StockMgt_Model->getQtyAssignTrackingDetailsById($idfranchisee,$marketingMaterialData['id']);
                                              $qtyUpdateDataArr = $this->StockMgt_Model->getQtyUpdateTrackingDetailsById($idfranchisee,$marketingMaterialData['id']);
                                              $qtyUpdateData1Arr =end($qtyUpdateDataArr);
                                        }

                                   
                                                             
                                    ?>
                                <tr>
                                   <td>
                                        <img class="file_preview_image" src="<?php echo __BASE_USER_PRODUCT_IMAGES_URL__; ?>/<?php echo $marketingMaterialData['szProductImage']; ?>" width="60" height="60"/>

                                    </td>
                                    <td> <?php echo $marketingMaterialData['szProductCode']?> </td>
                                    <td> <?php echo $marketingMaterialData['szProductDiscription'];?> </td>
                                    <td> $<?php echo $marketingMaterialData['szProductCost'];?> </td>
                                       <?php  if($_SESSION['drugsafe_user']['iRole']==5){?>
                                        <td><?php echo($marketingMaterialData['szQuantity'] > 0 ? $marketingMaterialData['szQuantity'] : 'N/A')?></td>
                                       <?php } else { ?> 
                                        <td><?php echo($marketingMaterialDataArr['szQuantity'] > 0 ? $marketingMaterialDataArr['szQuantity'] : 'N/A')?></td>
                                       <?php }?>
<!--                                        <td>
                                        <?php 
                                        if($qtyAssignDataArr['szAssignBy'])
                                        {
                                            $franchiseeDetArr = $this->Admin_Model->getAdminDetailsByEmailOrId('',$qtyAssignDataArr['szAssignBy']);
                                            echo $franchiseeDetArr['szName'];
                                        }
                                        else
                                        {
                                           echo "N.A";
                                        }

                                        ?> 
                                    </td>-->

<!--                                        <td>
                                             <?php 
                                        if($qtyUpdateData1Arr['szLastUpdatedBy'])
                                        {
                                            $franchiseeDetArr = $this->Admin_Model->getAdminDetailsByEmailOrId('',$qtyUpdateData1Arr['szLastUpdatedBy']);
                                            echo $franchiseeDetArr['szName'];
                                        }
                                        else
                                        {
                                           echo "N.A";
                                        }

                                        ?> 
                                    </td>-->
                                     
                                    <td>
                                         <?php if(empty($marketingMaterialDataArr['szQuantity']) && ($marketingMaterialDataArr['szQuantity'] != '0')){?>
                                        
                                        <a class="btn btn-circle btn-icon-only btn-default" title="Add Model Stock Value" onclick="addProductStockQuantity(<?php echo $marketingMaterialData['id'];?>);" href="javascript:void(0);">
                                            <i class="fa fa-plus"></i> 
                                        </a>
                                        <?php }else{?>
                                         <a class="btn btn-circle btn-icon-only btn-default" title="Adjust Quantity" onclick="editProductStockQuantity(<?php echo $marketingMaterialData['id'];?>,'1');" href="javascript:void(0);">
                                            <i class="fa fa-minus"></i> 
                                        </a>
                                         <a class="btn btn-circle btn-icon-only btn-default" title=" Add More Product Stock Quantity" onclick="editProductStockQuantity(<?php echo $marketingMaterialData['id'];?>,'2');" href="javascript:void(0);">
                                            <i class="fa fa-plus"></i> 
                                        </a>
                                        <?php }?>
                                    </td>
                                  
                                </tr>
                                <?php
                                $i++;
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
<div class="tab-pane <?php echo $conActive?>" id="tab3">
                        <div id="page_content" class="row">
                            <div class="col-md-12">
                                <div class="portlet light bordered">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="icon-equalizer font-red-sunglo"></i>
                                            <span class="caption-subject font-red-sunglo bold uppercase">Consumables</span>
                                        </div>
                                       </div>
                                    <?php

                                    if(!empty($consumablesAray))
                                    {

                                        ?>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th> Image </th>
                                                    <th> Product Code</th>
                                                    <th> Description</th>
                                                    <th> Cost</th>
                                                    <th>Quantity </th>
<!--                                                    <th>Quantity Assign By </th>
                                                    <th>Quantity Updated By  </th>-->
                                                    <th> Action </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                   $i = 0;
                                                    foreach($consumablesAray as $consumablesData)
                                                    { $idfranchisee = $franchiseeArr['id'];
                                                    
                                                     if($_SESSION['drugsafe_user']['iRole']==5){
                                              $consumablesDataArr = $this->StockMgt_Model->getProductQtyDetailsById($idfranchisee,$consumablesData['iProductId']);
                                              $qtyAssignDataArr = $this->StockMgt_Model->getQtyAssignTrackingDetailsById($idfranchisee,$consumablesData['iProductId']);
                                              $qtyUpdateDataArr = $this->StockMgt_Model->getQtyUpdateTrackingDetailsById($idfranchisee,$consumablesData['iProductId']);
                                              $qtyUpdateData1Arr =end($qtyUpdateDataArr);
                                        } else
                                            {
                                             $consumablesDataArr = $this->StockMgt_Model->getProductQtyDetailsById($idfranchisee,$consumablesData['id']);
                                            $qtyAssignDataArr = $this->StockMgt_Model->getQtyAssignTrackingDetailsById($idfranchisee,$consumablesData['id']);
                                              $qtyUpdateDataArr = $this->StockMgt_Model->getQtyUpdateTrackingDetailsById($idfranchisee,$consumablesData['id']);
                                              $qtyUpdateData1Arr =end($qtyUpdateDataArr);
                                        }
                                                          $consumablesDataArr = $this->StockMgt_Model->getProductQtyDetailsById($idfranchisee,$consumablesData['id']);
                                                        
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <img class="file_preview_image" src="<?php echo __BASE_USER_PRODUCT_IMAGES_URL__; ?>/<?php echo $consumablesData['szProductImage']; ?>" width="60" height="60"/>    
                                                        </td>
                                                        <td> <?php echo $consumablesData['szProductCode']?> </td>
                                                        <td> <?php echo $consumablesData['szProductDiscription'];?> </td>
                                                        <td> $<?php echo $consumablesData['szProductCost'];?> </td>
                                                       <?php  if($_SESSION['drugsafe_user']['iRole']==5){?>
                                                            <td><?php echo($consumablesData['szQuantity'] > 0 ? $consumablesData['szQuantity'] : 'N/A')?></td>
                                                           <?php } else { ?> 
                                                            <td><?php echo($consumablesDataArr['szQuantity'] > 0 ? $consumablesDataArr['szQuantity'] : 'N/A')?></td>
                                                           <?php }?>
<!--                                                            <td>
                                                            <?php 
                                                            if($qtyAssignDataArr['szAssignBy'])
                                                            {
                                                                $franchiseeDetArr = $this->Admin_Model->getAdminDetailsByEmailOrId('',$qtyAssignDataArr['szAssignBy']);
                                                                echo $franchiseeDetArr['szName'];
                                                            }
                                                            else
                                                            {
                                                               echo "N.A";
                                                            }

                                                            ?> 
                                                        </td>-->

<!--                                                            <td>
                                                                 <?php 
                                                            if($qtyUpdateData1Arr['szLastUpdatedBy'])
                                                            {
                                                                $franchiseeDetArr = $this->Admin_Model->getAdminDetailsByEmailOrId('',$qtyUpdateData1Arr['szLastUpdatedBy']);
                                                                echo $franchiseeDetArr['szName'];
                                                            }
                                                            else
                                                            {
                                                               echo "N.A";
                                                            }

                                                            ?> 
                                                        </td>-->

                                                        <td>
                                                            <?php if(empty($consumablesDataArr['szQuantity']) && ($consumablesDataArr['szQuantity'] != '0')){?>
                                                            <a class="btn btn-circle btn-icon-only btn-default" title="Add Product Stock Quantity" onclick="addProductStockQuantity(<?php echo $consumablesData['id'];?>);" href="javascript:void(0);">
                                                                <i class="fa fa-plus"></i> 
                                                            </a>
                                                            <?php }else{?>
                                                             <a class="btn btn-circle btn-icon-only btn-default" title="Adjust Quantity" onclick="editProductStockQuantity(<?php echo $consumablesData['id'];?>,'1');" href="javascript:void(0);">
                                                                <i class="fa fa-minus"></i> 
                                                            </a>
                                                           <a class="btn btn-circle btn-icon-only btn-default" title=" Add More Product Stock Quantity" onclick="editProductStockQuantity(<?php echo $consumablesData['id'];?>,'2');" href="javascript:void(0);">
                                                                <i class="fa fa-plus"></i> 
                                                            </a>
                                                            <?php }?>
                                                            
                                                        </td>
                                                    </tr>
                                                    <?php
                                                    $i++;
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
                 <div id="popup_box"></div>   
            </div>                     
<div id="popup_box"></div>       
 </div>
 </div>
</div>   
</div>
</div>
</div>
