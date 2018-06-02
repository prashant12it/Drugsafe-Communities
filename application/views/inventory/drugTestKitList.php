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
                            <a href="<?php echo __BASE_URL__;?>/inventory/drugtestkitlist">Home</a>
                            <i class="fa fa-circle"></i>
                        </li>
                        <li>
                            <span class="active">Drug Test Kit List</span>
                        </li>
                    </ul>
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-equalizer font-red-sunglo"></i>
                                <span class="caption-subject font-red-sunglo bold uppercase">Drug Test Kit</span>
                            </div>
                            <?php 
                            if($_SESSION['drugsafe_user']['iRole']==1 || $_SESSION['drugsafe_user']['iRole']==5){
                            ?>
                            <div class="actions">
                            <div class="btn-group btn-group-devided" data-toggle="buttons">
                                    <button class="btn btn-sm green-meadow" onclick="redirect_url('<?php echo base_url();?>inventory/addDrugTestKit');">
                                        &nbsp;Add Drug Test Kit
                                    </button>
                                </div>
                        </div>
                            <?php }?>    
                           
                        </div>
                        <?php
                        
                        if(!empty($drugTestKitAray))
                        {
                           
                            ?>
                        
                          <div class="row">
                           <form class="search-bar" id="szSearchDrugTestList" action="<?=__BASE_URL__?>/inventory/drugtestkitlist " name="szSearchDrugTestList" method="post">
                          <div class="search col-md-3 clienttypeselect">
                          <div class="form-group <?php if (!empty($arErrorMessages['szSearchProdCode']) != '') { ?>has-error<?php } ?>">
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
                                          if($_SESSION['drugsafe_user']['iRole']==1 || $_SESSION['drugsafe_user']['iRole']==5){
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
                                        foreach($drugTestKitAray as $drugTestKitData)
                                        {  
                                             $idfranchisee = $_SESSION['drugsafe_user']['id'];
                                          
                                            $drugTestKitDataArr = $this->StockMgt_Model->getStockValueDetailsById($idfranchisee,$drugTestKitData['iProductId']);
                                            
                                              
                                           // $drugTestKitQtyDataArr = $this->StockMgt_Model->getProductQtyDetailsById($idfranchisee,$drugTestKitData['id']);
                                        
                                            ?>
                                        <tr>
                                            <td>
                                                <img class="file_preview_image" src="<?php echo __BASE_USER_PRODUCT_IMAGES_URL__; ?>/<?php echo $drugTestKitData['szProductImage']; ?>" width="60" height="60"/>    
                                            </td>
                                            <td> <?php echo $drugTestKitData['szProductCode']?> </td>
                                            <td> <?php echo $drugTestKitData['szProductDiscription'];?> </td>
                                            <td> $<?php echo $drugTestKitData['szProductCost'];?> </td>
                                            <td><?php 
                                            $date= $drugTestKitData['dtExpiredOn'];
                                            $dtExpiredOn = date("d-m-Y", strtotime($date)); 
                                            echo ($dtExpiredOn == '01-01-1970'?'N/A':$dtExpiredOn);?> </td>
                                             <td> <?php echo $drugTestKitData['szAvailableQuantity'];?> </td>
                                            <?php
                                           if($_SESSION['drugsafe_user']['iRole']==1 || $_SESSION['drugsafe_user']['iRole']==5){
                                             ?>
                                                <td>
                                                <a class="btn btn-circle btn-icon-only btn-default" title="Edit Drug-Test Kit Details" onclick="editProduct('<?php echo $drugTestKitData['id'];?>','1');" href="javascript:void(0);">
                                                    <i class="fa fa-pencil"></i> 
                                                </a>
                                                <a class="btn btn-circle btn-icon-only btn-default" id="drugTestKitStatus" title="Delete Drug-Test Kit Details" onclick="productDeleteAlert(<?php echo $drugTestKitData['id'];?>,'1');" href="javascript:void(0);"></i>
                                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                                </a>
                                                <a class="btn btn-circle btn-icon-only btn-default" id="drugTestKitView" title="View Drug-Test Kit Details" onclick="viewProductDetails(<?php echo $drugTestKitData['id'];?>,'1');" href="javascript:void(0);"></i>
                                                <i class="fa fa-eye" aria-hidden="true"></i>
                                                </a>
                                                </td>
                                        <?php }else{?>
                                          <td><?php echo($drugTestKitDataArr['szModelStockVal'] > 0 ? $drugTestKitDataArr['szModelStockVal'] : 'N/A')?></td>
                                          <td><?php echo($drugTestKitData['szQuantity'] > 0 ? $drugTestKitData['szQuantity'] : 'N/A')?></td>
                                          <td>          
                                              <a class="btn btn-circle btn-icon-only btn-default" id="drugTestKitStatus" title="Request Quantity" onclick="requestQuantityAlert('<?php echo $drugTestKitData['iProductId'];?>','1');" href="javascript:void(0);">
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