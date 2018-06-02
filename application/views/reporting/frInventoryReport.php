<script type='text/javascript'>
    $(function() {
      $("#szSearch1").customselect();
       $("#szSearch2").customselect();
      $("#szSearch3").customselect();
    });
</script>
<div class="page-content-wrapper">
    <div class="page-content">
        <?php
        if (!empty($_SESSION['drugsafe_user_message'])) {
            if (trim($_SESSION['drugsafe_user_message']['type']) == "success") {
                ?>
                <div class="alert alert-success">
                    <?php echo $_SESSION['drugsafe_user_message']['content']; ?>
                </div>
            <?php }
            if (trim($_SESSION['drugsafe_user_message']['type']) == "error") {
                ?>
                <div class="alert alert-danger">
                    <?php echo $_SESSION['drugsafe_user_message']['content']; ?>
                </div>
            <?php }
            $this->session->unset_userdata('drugsafe_user_message');
        }
        ?>

        <div id="page_content" class="row">
            <div class="col-md-12">
                <ul class="page-breadcrumb breadcrumb">

                    <li>
                        <a href="<?php echo __BASE_URL__; ?>">Home</a>
                        <i class="fa fa-circle"></i>
                    </li>

                    <li>
                        <span class="active">Inventory Ordered Report</span>
                    </li>
                </ul>

                <div class="portlet light bordered about-text" id="user_info">
                   
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-equalizer font-red-sunglo"></i>
                                <span class="caption-subject font-red-sunglo bold uppercase">
                                    Inventory Ordered Report 
                                </span>
                            </div>
                    <?php
                            if(!empty($_POST['szSearch2'])){
                         
                           $this->session->unset_userdata('productCode');
                           $this->session->unset_userdata('prodCategory');
           
                             if(!empty($validPendingOrderFrDetailsAray)) 
                        {      
                          
                            ?>
                        
                            <div class="actions">
                               
                                 <a onclick="ViewpdfFrInventoryReport('<?php echo $_POST['szSearch2'];?>','<?php echo $_POST['szSearch3'];?>')" href="javascript:void(0);" 
                                   class=" btn green-meadow">
                                    <i class="fa fa-file-pdf-o"></i> View Pdf </a>
                                
                               <a onclick="ViewexcelFrInventoryReport('<?php echo $_POST['szSearch2'];?>','<?php echo $_POST['szSearch3'];?>')" href="javascript:void(0);" 
                                   class=" btn green-meadow">
                                    <i class="fa fa-file-excel-o"></i> View Xls </a>
                                    
                            </div>
                            <?php
                             }  } 
                            ?>
                        </div>
                    <div class="row">
                      <form class="search-bar" name="orderSearchForm" id="orderSearchForm" action="<?=__BASE_URL__?>/reporting/frInventoryReport" method="post">
                    <div class="col-md-3 clienttypeselect">
                        <div class="form-group <?php if (!empty($arErrorMessages['szSearch2']) != '') { ?>has-error<?php } ?>">
                            
                              <select class="form-control custom-select" name="szSearch2" id="szSearch2" onblur="remove_formError(this.id,'true')" onchange="getProductCodeListByCategory(this.value);">
                                                <option value=''>Product Category</option>
                                                <option value="1" <?php echo (sanitize_post_field_value($_POST['szSearch2']) == trim("1") ? "selected" : ""); ?>>Drug Test Kit</option>
                                                <option value="2" <?php echo (sanitize_post_field_value($_POST['szSearch2']) == trim("2") ? "selected" : ""); ?>>Marketing Material</option>
                                                <option value="3" <?php echo (sanitize_post_field_value($_POST['szSearch2']) == trim("3") ? "selected" : ""); ?>>Consumables</option>
                             </select>
                            <?php
                               if(form_error('szSearch2')){?>
                               <span class="help-block pull-left"><span><?php echo form_error('szSearch2');?></span>
                             </span><?php }?>  
                           
                        </div>
                    </div>
                 
			<div class="col-md-3 clienttypeselect">
                        <div class="form-group <?php if (!empty($arErrorMessages['szIndustry']) != '') { ?>has-error<?php } ?>">
                            <div id='szProductCode'>
							<select class="form-control custom-select" name="szSearch3" id="szSearch3" onfocus="remove_formError(this.id,'true')">
                                <option value="">Product Code</option>
                                    <?php
                                    foreach($productAry as $productData)
                                    {
                                        $selected = ($productData['id'] == $_POST['szSearch3'] ? 'selected="selected"' : '');
                                         echo '<option value="'.$productData['id'].'"' . $selected . ' >'.$productData['szProductCode'].'</option>';
                                    }
                                    ?>
                            </select>
                         </div>
			  </div>
                                  </div>
                    

                <div class="col-md-1">
                           <button class="btn green-meadow" type="submit" ><i class="fa fa-search"></i></button>
                               </div>
               
                 
            </form>  
                      </div>
                <?php
                       if(!empty($_POST['szSearch2'])){
                        if(!empty($validPendingOrderFrDetailsAray)) 
                        { 
                           ?>      
                    <div class="row">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered table-striped">
                            <thead>
                            <tr>
                                    <th>
                                             #
                                    </th>
                                    <th>
                                         Category
                                    </th>
                                    <th>
                                          Product Code 
                                    </th>
                                    <th>
                                          In Stock  
                                    </th>
                                    <th>
                                         Ordered
                                    </th>
                                  
                            </thead>
                            <tbody>
                                     <?php         $i = 0;
                                     $checkarr = array();
                                                foreach($validPendingOrderFrDetailsAray as $validPendingOrderFrDetailsData) {
                                                    if (!in_array($validPendingOrderFrDetailsData['productid'], $checkarr))
                                                    {
                                                        $i++;
                                                    $productcatAry = $this->Order_Model->getCategoryDetailsById(trim($validPendingOrderFrDetailsData['szProductCategory']));
                                                    $validPendingOrdersQtyDetailsAray = $this->Order_Model->getProductDetsByfranchiseeid($validPendingOrderFrDetailsData['franchiseeid'], $validPendingOrderFrDetailsData['szProductCategory'], $validPendingOrderFrDetailsData['productid']);
                                                
                                                    $prodqtyarr = $this->Order_Model->getTotalFrOrderdqty($validPendingOrderFrDetailsData['franchiseeid'], $validPendingOrderFrDetailsData['productid']);
                                                    $getAllDispatchedQtyAry = $this->Order_Model->getAllDispatchedQty($validPendingOrderFrDetailsData['franchiseeid'],$validPendingOrderFrDetailsData['productid']);
                                                     
                                                    $qty = $prodqtyarr[0]['quantity']- $getAllDispatchedQtyAry['0']['dispatch_qty'];
                                                    if($qty!='0'){
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $i; ?> </td>
                                                        <td>
                                                            <?php echo $productcatAry['szName']; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $validPendingOrderFrDetailsData['szProductCode']; ?>
                                                        </td>
                                                        <?php
                                                        if (!empty($validPendingOrdersQtyDetailsAray)) {
                                                            $printzero = true;
                                                            foreach ($validPendingOrdersQtyDetailsAray as $qtyData) { ?>

                                                                <td>  <?php
                                                                    echo $qtyData['szQuantity']; ?> </td>

                                                                <?php $printzero = false;
                                                            }
                                                            ?>

                                                            <?php
                                                        } else {
                                                            echo '<td>0</td>';
                                                        } ?>

                                                        <td>  <?php
                                                            
                                                            if(!empty($getAllDispatchedQtyAry))
                                                            {  
                                                             $qty = $prodqtyarr[0]['quantity']- $getAllDispatchedQtyAry['0']['dispatch_qty'];  
                                                            echo $qty;
                                                            } else {
                                                            echo $prodqtyarr[0]['quantity'];    
                                                            }
                                                            
                                                            ?> </td>


                                                    </tr>
                                                    <?php
                                                    }
                                                    array_push($checkarr, $validPendingOrderFrDetailsData['productid']);
                                                }
                                              }
                                            
                                             
                                           ?>
                            </tbody>
                            </table>
                    </div>        
                </div>
                      <?php } else {
                          
                            echo "Not Found";    
                           }
                       }
                            ?> 
                  </div>
   
                   
                        </div>
         
                </div>

            </div>
        </div>
    </div>
</div>
</div>
<div id="popup_box"></div>