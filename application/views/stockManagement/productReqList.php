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
                            <a href="<?php echo __BASE_URL__;?>/stock_management/stockreqlist">Home</a>
                            <i class="fa fa-circle"></i>
                        </li>
                        <li>
                        <a onclick="viewClient(<?php echo $franchiseeArr['id'];?>);" href="javascript:void(0);"><?php echo $franchiseeArr['szName'];?></a>
                        <i class="fa fa-circle"></i>
                        </li>
                        <li>
                            <span class="active">Request Product List</span>
                        </li>
                    </ul>
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-equalizer font-red-sunglo"></i>
                                <span class="caption-subject font-red-sunglo bold uppercase">Stock Request List</span>
                            </div>
                           
                        </div>
                        
                        <?php
                      
                        if(!empty($reqQtyListAray))
                        {
                           
                            ?>
                          <div class="row">
                              <form class="form-horizontal" id="szSearchProdReqList" action="<?=__BASE_URL__?>/stock_management/viewproductlist" name="szSearchProdReqList" method="post">
                          <div class="search col-md-3">
<!--                            <input type="text" name="szProdReqList" id="szProdReqList" class="form-control input-square-right " placeholder="Product Code" value="--><?//=sanitize_post_field_value($_POST['szProdReqList'])?><!--">-->
                              <select class="form-control custom-select" name="szProdReqList" id="szSearchProdCode" onfocus="remove_formError(this.id,'true')">
                                  <option value="">Product Code</option>
                                  <?php
                                  foreach($reqProdListArr as $ReqProd)
                                  {
                                      $selected = ($ReqProd['szProductCode'] == $_POST['szProdReqList'] ? 'selected="selected"' : '');
                                      echo '<option value="'.$ReqProd['szProductCode'].'"' . $selected . ' >'.$ReqProd['szProductCode'].'</option>';
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
                                        <th> Product Category</th>
                                        <th> Descreption</th>
                                        <th> Cost</th>
                                        <th> Requested Quantity </th>
                                        <th> Processed Quantity </th>
                                        <th> Action</th>
                                   
                                    </tr>
                                </thead>
                                <tbody>
                                     <?php
                                    if($reqQtyListAray)
                                    {   $i = 0;
                                       
                                        foreach($reqQtyListAray as $reqQtyListData)
                                        {
                                         $idfranchisee= $franchiseeArr['id'];
                                           $idProduct =$reqQtyListData['iProductId'];
                                          
                                           $productCategortDataAry = $this->StockMgt_Model->getCategoryDetailsById($reqQtyListData['szProductCategory']);
                                           $QtyReqArr =  $this->StockMgt_Model->getQtyReqById($idProduct,$idfranchisee);
                                            $i=0;
                                             $reqId = $QtyReqArr[$i]['id'];
                                             $QtyAssignArr =  $this->StockMgt_Model->getQtyAssignListById($idProduct,$idfranchisee,$reqId);
//                                             print_r($QtyAssignArr);die;
                                          // $QtyAssignListAry = $this->StockMgt_Model->getQtyAssignListById($idProduct,$idfranchisee); 
                                         
                                            $total=0;
                                          if(!empty($QtyAssignArr))
                                            {
                                               
                                               foreach($QtyAssignArr as $QtyAssignListdata)
                                               {
                                                   $total+=$QtyAssignListdata['szQuantityAssigned'];
                                                  
                                               }
                                            }  
                                           
                                          
                                        ?>
                                        <tr>
                                             <td>
                                                <img class="file_preview_image" src="<?php echo __BASE_USER_PRODUCT_IMAGES_URL__; ?>/<?php echo $reqQtyListData['szProductImage']; ?>" width="60" height="60"/>
                                                  
                                            </td>
                                            
                                            <td> <?php echo $reqQtyListData['szProductCode'];?> </td>
                                            <td> <?php echo $productCategortDataAry['szName']?> </td>
                                            <td> <?php echo $reqQtyListData['szProductDiscription'];?> </td>
                                            <td> $<?php echo $reqQtyListData['szProductCost'];?> </td>
                                            <td> <?php echo $reqQtyListData['szQuantity'];?>  </td>
                                           <td> <?php echo ($total > 0 ? $total : 'N/A')?></td>
                                            
                                           
                                            <td>
                                                 <a class="btn btn-circle btn-icon-only btn-default" id="quantityStatus" title="Allot Quantity"  onclick="allotReqQtyAlert(<?php echo $idProduct;?>,<?php echo $reqQtyListData['szQuantity'];?>);" href="javascript:void(0);"></i>
                                                    <i class="fa fa-mail-reply" aria-hidden="true"></i>
                                                </a>
                                            </td>

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
                        <?php  if(!empty($reqQtyListAray)){?>
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