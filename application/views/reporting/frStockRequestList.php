<script type='text/javascript'>
    $(function() {
        $("#szSearchProdCode").customselect();
    });
</script>
<div class="page-content-wrapper">
        <div class="page-content">
          
            <div id="page_content" class="row">
                <div class="col-md-12">
                    <ul class="page-breadcrumb breadcrumb">
                        <li>
                            <a href="<?php echo __BASE_URL__;?>/reporting/frstockreqlist">Home</a>
                            <i class="fa fa-circle"></i>
                        </li>
                        <li>
                        <li>
                            <span class="active">Stock Request List</span>
                        </li>
                    </ul>
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-equalizer font-red-sunglo"></i>
                                <span class="caption-subject font-red-sunglo bold uppercase">Stock Request List</span>
                            </div>
                            <?php
                            if(!empty($frAllReqQtyAray))
                        {
                           
                            ?>
                          
                            <div class="actions">
                               
                                 <a onclick="Viewpdffrstockreqlist('<?php echo $_POST['szSearchProdCode'];?>')" href="javascript:void(0);" 
                                   class=" btn green-meadow">
                                    <i class="fa fa-file-pdf-o"></i> View Pdf </a>
                                
                               <a onclick="Viewexcelfrstockreqlist('<?php echo $_POST['szSearchProdCode'];?>')" href="javascript:void(0);" 
                                   class=" btn green-meadow">
                                    <i class="fa fa-file-excel-o"></i> View Xls </a>
                                    
                            </div>
                            <?php
                        }
                            ?>
                       
                        </div>
                        
                        <?php
                      
                        if(!empty($frAllReqQtyAray))
                        {
                           
                            ?>
                          <div class="row">
                           <form class="form-horizontal" id="szSearchFrQtyReqList" action="<?=__BASE_URL__?>/reporting/frstockreqlist " name="szSearchFrQtyReqList" method="post">
                          <div class="search col-md-3">
<!--                            <input type="text" name="szSearchProdCode" id="szSearchProdCode" class="form-control input-square-right " placeholder="Product Code" value="--><?//=sanitize_post_field_value($_POST['szSearchProdCode'])?><!--">-->
                              <select class="form-control custom-select" name="szSearchProdCode" id="szSearchProdCode" onfocus="remove_formError(this.id,'true')">
                                  <option value="">Product Code</option>
                                  <?php
                                  foreach($AllQtyReqList as $AllQtyReqItem)
                                  {
                                      $selected = ($AllQtyReqItem['szProductCode'] == $_POST['szSearchProdCode'] ? 'selected="selected"' : '');
                                      echo '<option value="'.$AllQtyReqItem['szProductCode'].'"' . $selected . ' >'.$AllQtyReqItem['szProductCode'].'</option>';
                                  }
                                  ?>
                              </select>
                          </div>
                               <div class="col-md-1">
                           <button class="btn green-meadow" type="submit" ><i class="fa fa-search"></i></button>
                               </div>
                           </form>
                           </form>
                          </div>
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th> Product Code </th>
                                        <th> Quantity Request </th>
                                        <th> Requested On </th>
                                   
                                    </tr>
                                </thead>
                                <tbody>
                                     <?php
                                    if($frAllReqQtyAray)
                                    {   $i = 0;
                                       
                                        foreach($frAllReqQtyAray as $frAllReqQtyData)
                                        {
                                        
//                                           $productDataAry = $this->Inventory_Model->getProductDetailsById($allReqQtyData['iProductId']);
                                          
//                                           $franchiseeArr = $this->Admin_Model->getAdminDetailsByEmailOrId('',$allReqQtyData['iFranchiseeId']);
                                        
                                          
                                        ?>
                                        <tr>
                                            <td> <?php echo $frAllReqQtyData['szProductCode'];?> </td>
                                            <td> <?php echo $frAllReqQtyData['szQuantity'];?> </td>
                                             <td> <?php echo date('d/m/Y h:i:s A',strtotime( $frAllReqQtyData['dtRequestedOn']))?>  </td>
                                      

                                        </tr>
                                        <?php 
                                        }
                                    } ?>
                                </tbody>
                            </table>
                             </div>
                    </div>
                             <?php
                            $i++;  
                        }
                        else
                        {
                            echo "Not Found";
                        }
                        ?>
                        <?php  if(!empty($frAllReqQtyAray)){?>
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