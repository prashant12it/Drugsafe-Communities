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
                        <span class="active">Inventory Report</span>
                    </li>
                </ul>

                <div class="portlet light bordered about-text" id="user_info">
                   
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-equalizer font-red-sunglo"></i>
                                <span class="caption-subject font-red-sunglo bold uppercase">
                                    Inventory Report
                                </span>
                            </div>
                             <?php
                            if(!empty($validPendingOrdersDetailsAray))
                        { 
                           $this->session->unset_userdata('franchiseeId');
                           $this->session->unset_userdata('productCode');
                           $this->session->unset_userdata('prodCategory');
           
                                
                           
                            ?>
                          
                            <div class="actions">
                               
                                 <a onclick="ViewpdfInventoryReport('<?php echo $_POST['szSearch1'];?>','<?php echo $_POST['szSearch2'];?>','<?php echo $_POST['szSearch3'];?>')" href="javascript:void(0);" 
                                   class=" btn green-meadow">
                                    <i class="fa fa-file-pdf-o"></i> View Pdf </a>
                                
                               <a onclick="ViewexcelInventoryReport('<?php echo $_POST['szSearch1'];?>','<?php echo $_POST['szSearch2'];?>','<?php echo $_POST['szSearch3'];?>')" href="javascript:void(0);" 
                                   class=" btn green-meadow">
                                    <i class="fa fa-file-excel-o"></i> View Xls </a>
                                    
                            </div>
                            <?php
                        }
                            ?>
                        </div>
                        
                    <div class="  row">
                      <form class="search-bar" name="orderSearchForm" class="search-bar" id="orderSearchForm" action="<?=__BASE_URL__?>/reporting/inventoryReport" method="post">
                
                    
                    <div class="clienttypeselect search col-md-3">
                       
                        <div class="form-group <?php if (!empty($arErrorMessages['szSearch1']) != '') { ?>has-error<?php } ?>">
                            <select class="form-control custom-select" name="szSearch1" id="szSearch1" onchange="remove_formError(this.id,'true')">
                                          <option value="">Franchisee Name</option>
                                          <?php
                                          foreach($allFrPendingDetailsSearchAray as $allFrPendingDetailsSearchList)
                                          {
                                              $selected = ($allFrPendingDetailsSearchList['franchiseeid'] == $_POST['szSearch1'] ? 'selected="selected"' : '');
                                              echo '<option value="'.$allFrPendingDetailsSearchList['franchiseeid'].'"'.$selected.' >'.$allFrPendingDetailsSearchList['userCode'].'-'. $allFrPendingDetailsSearchList['szName'].'</option>';
                                          }
                                          ?>
                           </select>
                             <?php
                               if(form_error('szSearch1')){?>
                               <span class="help-block pull-left"><span><?php echo form_error('szSearch1');?></span>
                             </span><?php }?> 
                        </div>
                    </div>
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
                   
			<div class="search clienttypeselect col-md-3">
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
                    if(($_POST['szSearch2']!='') && ($_POST['szSearch1']!=''))
                    {
                    if (!empty($validPendingOrdersDetailsAray)) {
                    ?>     
                  
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
                                          Model Stock Value 
                                    </th>
                                    <th>
                                          In Stock  
                                    </th>
                                  
                                      <th>
                                         Requested 
                                    </th>  
                             
                            </thead>
                            <tbody>
                                     <?php         $i = 0;
                                                foreach($validPendingOrdersDetailsAray as $validPendingOrdersDetailsData)
                                                { 
                                                    $i++ ;
                                                   $productcatAry = $this->Order_Model->getCategoryDetailsById(trim($validPendingOrdersDetailsData['szProductCategory']));
                                                   $availprodqty = $this->Order_Model->getorderdanddispatchval($validPendingOrdersDetailsData['iFranchiseeId'],$validPendingOrdersDetailsData['id']);
                                                 
                                                   ?>
                            <tr>
                                    <td><?php echo $i; ?> </td>
                                    <td>
                                         <?php echo $productcatAry['szName'];?> 
                                    </td>
                                    <td>
                                         <?php echo $validPendingOrdersDetailsData['szProductCode'] ;?>
                                    </td>
                                    <td>
                                         <?php echo $validPendingOrdersDetailsData['model_stk_val'] ;?>
                                    </td>
                                   <td>  <?php echo $validPendingOrdersDetailsData['szAvailableQuantity'] ;?> </td>
                                <?php
                                                    if(!empty($availprodqty)) {
                                                        $printzero = true;
                                                        foreach ($availprodqty as $requestedqty) {
                                                             $getAllDispatchedQtyAry = $this->Order_Model->getAllDispatchedQty($requestedqty['franchiseeid'],$requestedqty['productid']);
                                                         
                                                             if ($requestedqty['productid'] == $validPendingOrdersDetailsData['id']) {
                                                              $qty = $requestedqty['quantity']- $getAllDispatchedQtyAry['0']['dispatch_qty'];  
                                                           
                                                                ?>
                                   
                                                                <td>  <?php echo $qty; ?> </td>
                                                               
                                                            <?php $printzero = false; }
                                                        }
                                                        if($printzero) { ?>
                                                            <td>0</td>
                                                            
                                                         <?php }
                                                    }else{
                                                        echo '<td>0</td>';
                                                    } ?>



                                </tr>
                              <?php
                                         
                                              }
                                            
                                             
                                           ?>
                            </tbody>
                            </table>
                    </div>        
               
                      <?php } else {
                          
                            echo "Not Found";    
                           }
                           
                            }?> 
                  </div>
   
                   
                        </div>
         
                </div>

            </div>
        </div>
    </div>
</div>
</div>
<div id="popup_box"></div>