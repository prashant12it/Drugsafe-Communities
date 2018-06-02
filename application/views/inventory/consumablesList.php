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
                            <a href="<?php echo __BASE_URL__;?>/inventory/consumableslist">Home</a>
                            <i class="fa fa-circle"></i>
                        </li>
                        <li>
                            <span class="active">Consumables List</span>
                        </li>
                    </ul>
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-equalizer font-red-sunglo"></i>
                                <span class="caption-subject font-red-sunglo bold uppercase">Consumables</span>
                            </div>
                            <?php 
                            if($_SESSION['drugsafe_user']['iRole']==1){
                            ?>
                            <div class="actions">
                            <div class="btn-group btn-group-devided" data-toggle="buttons">
                                    <button class="btn btn-sm green-meadow" onclick="redirect_url('<?php echo base_url();?>inventory/addConsumables');">
                                        &nbsp;Add Consumables
                                    </button>
                                </div>
                        </div>
                            <?php }?>    
                           
                        </div>
                        <?php
                        
                        if(!empty($consumablesAray))
                        {
                           
                            ?>
                        
                          <div class="row">
                           <form class="search-bar" id="szSearchConsumablesList" action="<?=__BASE_URL__?>/inventory/consumableslist " name="szSearchConsumablesList" method="post">
                          <div class="search clienttypeselect col-md-3">
                              <div class="form-group <?php if (!empty($arErrorMessages['szSearchProdCode']) != '') { ?>has-error<?php } ?>">
                              <select class="form-control custom-select" name="szSearchProdCode" id="szSearchProdCode" onfocus="remove_formError(this.id,'true')">
                                  <option value="">Product Code</option>
                                  <?php
                                  foreach($consumableslist as $consumablesItem)
                                  {
                                      $selected = ($consumablesItem['szProductCode'] == $_POST['szSearchProdCode'] ? 'selected="selected"' : '');
                                      echo '<option value="'.$consumablesItem['szProductCode'].'" ' . $selected . ' >'.$consumablesItem['szProductCode'].'</option>';
                                  }
                                  ?>
                              </select>
                          </div>
                              </div>
                               <div class="col-md-1">
                           <button class="btn green-meadow" type="submit" ><i class="fa fa-search"></i></button>
                               </div>
                           </form>
                          </div>
                
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th> Image </th>
                                        <th> Product Code</th>
                                        <th>  Description</th>
                                        <th>  Cost</th>
                                        <th>  Expiry Date</th>
                                         
                                            <?php
                                        if($_SESSION['drugsafe_user']['iRole']==1){
                                        ?>
                                        <th>  Available Quantity</th>
                                        <th> Actions </th>
                                       <?php }else{?>
                                        <th>  Model Stock Value</th>
                                        <th>  Available Stock Quantity</th>
                                        <th>  Action</th>
                                       <?php }?> 
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                       $i = 0;
                                        foreach($consumablesAray as $consumablesData)
                                        {  
                                             $idfranchisee = $_SESSION['drugsafe_user']['id'];
                                          
                                            $consumablesDataArr = $this->StockMgt_Model->getStockValueDetailsById($idfranchisee,$consumablesData['iProductId']);
                                            
                                              
                                           // $drugTestKitQtyDataArr = $this->StockMgt_Model->getProductQtyDetailsById($idfranchisee,$drugTestKitData['id']);
                                        
                                            ?>
                                        <tr>
                                            <td>
                                                <img class="file_preview_image" src="<?php echo __BASE_USER_PRODUCT_IMAGES_URL__; ?>/<?php echo $consumablesData['szProductImage']; ?>" width="60" height="60"/>    
                                            </td>
                                            <td> <?php echo $consumablesData['szProductCode']?> </td>
                                            <td> <?php echo $consumablesData['szProductDiscription'];?> </td>
                                            <td> $<?php echo $consumablesData['szProductCost'];?> </td>
                                             <td><?php 
                                            $date= $consumablesData['dtExpiredOn'];
                                            $dtExpiredOn = date("d-m-Y", strtotime($date)); 
                                            echo ($dtExpiredOn == '01-01-1970'?'N/A':$dtExpiredOn);?> </td>
                                              <td><?php echo $consumablesData['szAvailableQuantity'];?> </td>
                                            <?php
                                           if($_SESSION['drugsafe_user']['iRole']==1){
                                             ?>
                                                <td>
                                                <a class="btn btn-circle btn-icon-only btn-default" title="Edit Consumable Details" onclick="editConsumables('<?php echo $consumablesData['id'];?>','3');" href="javascript:void(0);">
                                                    <i class="fa fa-pencil"></i> 
                                                </a>
                                                <a class="btn btn-circle btn-icon-only btn-default" id="ConsumablesStatus" title="Delete Consumable Details" onclick="productDeleteAlert(<?php echo $consumablesData['id'];?>,'3');" href="javascript:void(0);"></i>
                                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                                </a>
                                                <a class="btn btn-circle btn-icon-only btn-default" id="ConsumablesView" title="View Consumable Details" onclick="viewProductDetails(<?php echo $consumablesData['id'];?>,'3');" href="javascript:void(0);"></i>
                                                <i class="fa fa-eye" aria-hidden="true"></i>
                                                </a>
                                                </td>
                                        <?php }else{?>
                                          <td><?php echo($consumablesDataArr['szModelStockVal'] > 0 ? $consumablesDataArr['szModelStockVal'] : 'N/A')?></td>
                                          <td><?php echo($consumablesData['szQuantity'] > 0 ? $consumablesData['szQuantity'] : 'N/A')?></td>
                                          <td>          
                                              <a class="btn btn-circle btn-icon-only btn-default" id="ConsumablesStatus" title="Request Quantity" onclick="requestQuantityAlert('<?php echo $consumablesData['iProductId'];?>','3');" href="javascript:void(0);">
                                                    <i class="fa fa-pencil"></i> 
                                              </a>
                                          </td> 
                                        <?php } 
                                        
                                        ?> 
                                      
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
                        <?php  if(!empty($consumablesAray)){?>
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