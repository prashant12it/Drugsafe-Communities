<script type='text/javascript'>
    $(function() {
      $("#szSearch1").customselect();
       $("#szSearch2").customselect();
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
                        <span class="active">Franchisee Stock Quantity Report</span>
                    </li>
                </ul>

                <div class="portlet light bordered about-text" id="user_info">
                   
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-equalizer font-red-sunglo"></i>
                                <span class="caption-subject font-red-sunglo bold uppercase">
                                    Franchisee Stock Quantity Report
                                </span>
                            </div>
                             <?php
                            if(!empty($viewFranchiseeInventoryListAry))
                        { 
                           $this->session->unset_userdata('franchiseeName');
                           $this->session->unset_userdata('prodCategory');
           
                                
                           
                            ?>
                          
                            <div class="actions">
                               
                                 <a onclick="ViewpdfFrStockQtyReport('<?php echo $_POST['szSearch1'];?>','<?php echo $_POST['szSearch2'];?>')" href="javascript:void(0);" 
                                   class=" btn green-meadow">
                                    <i class="fa fa-file-pdf-o"></i> View Pdf </a>
                                
                               <a onclick="ViewexcelFrStockQtyReport('<?php echo $_POST['szSearch1'];?>','<?php echo $_POST['szSearch2'];?>')" href="javascript:void(0);" 
                                   class=" btn green-meadow">
                                    <i class="fa fa-file-excel-o"></i> View Xls </a>
                                    
                            </div>
                            <?php
                        }
                            ?>
                        </div>
                        
                    <div class="  row">
                      <form class="search-bar" name="orderSearchForm" id="orderSearchForm" action="<?=__BASE_URL__?>/reporting/view_fr_stock_qty_report" method="post">
                  
                    <div class="clienttypeselect search col-md-3"> 
                        <?php  if ($_SESSION['drugsafe_user']['iRole'] == '5') {
                    $operationManagerId = $_SESSION['drugsafe_user']['id'];
                     }
                       
                     ?>
                 
                          <div class="form-group <?php if (!empty($arErrorMessages['szSearch1']) != '') { ?>has-error<?php } ?>"> 
                            <select class="form-control custom-select" name="szSearch1" id="szSearch1" onchange="remove_formError(this.id,'true')">
                                          <option value="">Franchisee Name</option>
                                          <?php
                                           $searchOptionArr = $this->Admin_Model->viewDistinctFranchiseeList($operationManagerId);
                                            ?>
                                          <?php
                                          foreach($searchOptionArr as $searchOptionData)
                                          {
                                              $selected = ($searchOptionData['szName'] == $_POST['szSearch1'] ? 'selected="selected"' : '');
                                              echo '<option value="'.$searchOptionData['szName'].'"'.$selected.' >'.$searchOptionData['szName'].'</option>';
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
                            
                              <select class="form-control custom-select" name="szSearch2" id="szSearch2" onchange="remove_formError(this.id,'true')" >
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
                 
                    

                <div class="col-md-1">
                    <button class="btn green-meadow" type="submit" ><i class="fa fa-search"></i></button>
                </div>
               
                 
            </form>  
                      </div>
               <?php
                    if($_POST['szSearch2']!='')
                    {
                    if (!empty($viewFranchiseeInventoryListAry)) {
                    ?>       
                   
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered table-striped">
                            <thead>
                            <tr>
                               
                                <th>  Product Code</th>
                                <th>  Description</th>
                                <th>  Franchisee Name </th>
                                <th>  State </th>
                                <th>  Available Stock Quantity</th>
                            </thead>
                            <tbody>
                                     <?php     
                                     $i = 0;
                                                foreach($viewFranchiseeInventoryListAry as $viewFranchiseeInventoryData)
                                                { 
                                                  
                                                 $franchiseeArr = $this->Admin_Model->getAdminDetailsByEmailOrId( '', $viewFranchiseeInventoryData['iFranchiseeId'] );
                                                 $getState = $this->Franchisee_Model->getStateByFranchiseeId($viewFranchiseeInventoryData['iFranchiseeId']);
                                                
                                                    $i++ ;
                                                    ?>
                                    <tr>
                                        <td>
                                           <?php echo $viewFranchiseeInventoryData['szProductCode'] ;?>
                                        </td>
                                        <td>
                                           <?php echo $viewFranchiseeInventoryData['szProductDiscription'] ;?>
                                        </td>
                                        <td>
                                           <?php echo $franchiseeArr['szName'] ;?>
                                        </td>
                                        <td>
                                           <?php echo $getState['name'] ;?>
                                        </td>
                                        <td>  <?php echo $viewFranchiseeInventoryData['szQuantity']; ?> </td>
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