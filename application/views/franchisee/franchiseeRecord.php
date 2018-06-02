<script type='text/javascript'>
    $(function() {
        $("#szSearch").customselect();
        $("#szSearchname").customselect();
        $("#szSearchemail").customselect();
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
                    <?php
                    if($_SESSION['drugsafe_user']['iRole'] == '1'){
                     ?>
                    <li>
                        <a href="<?php echo __BASE_URL__;?>/admin/operationManagerList">Home</a>
                        <i class="fa fa-circle"></i>
                    </li>
                     <?php } else {?>
                     <li>
                        <a href="<?php echo __BASE_URL__;?>">Home</a>
                        <i class="fa fa-circle"></i>
                    </li>
                     <?php }?>
                    <li>
                        <a onclick="viewFranchisee(<?php echo $operationManagerAray['id'];?>);" href="javascript:void(0);"><?php echo $operationManagerAray['szName'];?></a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <span class="active">Franchisee List</span>
                    </li>
                </ul>
                
        <div class="portlet light bordered about-text" id="user_info">
        <div class="portlet-title">
            <div class="caption">
                <i class="icon-equalizer font-red-sunglo equalizer"></i>
                <span class="caption-subject font-red-sunglo bold uppercase">
                 
                    <?php 
                       echo "operation manager Details";
                   ?>
                    &nbsp; &nbsp;
                    <a class="btn btn-circle btn-icon-only btn-default" title="Edit Operation Manager Data" onclick="editOperationManagerDetails('<?php echo $operationManagerAray['id'];?>','2');" href="javascript:void(0);">
                        <i class="fa fa-pencil"></i> 
                    </a>
                </span>
            </div>
            
        </div>
                    
        <div class="portlet-body alert">
            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-sm-4 text-info bold">
                            <lable>Name:</lable>
                        </div>
                        <div class="col-sm-8">
                            <p><?php echo $operationManagerAray['szName'];?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 text-info bold">
                            <lable>Contact No:</lable>
                        </div>
                        <div class="col-sm-8">
                            <p><?php echo $operationManagerAray['szContactNumber'];?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 text-info bold">
                            <lable>City:</lable>
                        </div>
                        <div class="col-sm-8">
                            <p><?php echo $operationManagerAray['szCity'];?></p>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-4 text-info bold">
                            <lable>Country:</lable>
                        </div>
                        <div class="col-sm-8">
                            <p><?php echo $operationManagerAray['szCountry'];?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                  
                    <div class="row">
                        <div class="col-sm-4 text-info bold">
                            <lable>Email Id:</lable>
                        </div>
                        <div class="col-sm-8">
                            <p><?php echo $operationManagerAray['szEmail'];?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 text-info bold">
                            <lable>Address:</lable>
                        </div>
                        <div class="col-sm-8">
                            <p><?php echo $operationManagerAray['szAddress'];?></p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4 text-info bold">
                            <lable>State:</lable>
                        </div>
                        <div class="col-sm-8">
                            <p><?php 
                             $getStateIdByOperationId = $this->Admin_Model->getStateByOperationid($operationManagerAray['id']);
                            if($getStateIdByOperationId)
                            {
                                $stateId = $getStateIdByOperationId['stateId'];
                                if($stateId)
                                {
                                    $stateData = $this->Admin_Model->getStateById($stateId);
                                    echo $stateData['name'];
                                }
                                
                            }
                            
                            ?></p>
                        </div>
                    </div>
                  <div class="row">
                        <div class="col-sm-4 text-info bold">
                            <lable>ZIP/Postal Code:</lable>
                        </div>
                        <div class="col-sm-8">
                            <p><?php echo $operationManagerAray['szZipCode'];?></p>
                        </div>
                    </div>  

                </div>
              
             </div>
            
        </div>
                </div>
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-equalizer font-red-sunglo"></i>
                            <span class="caption-subject font-red-sunglo bold uppercase"><?php echo $operationManagerAray['szName'];?>'s Franchisee List</span>
                        </div>
                        <div class="actions">
                                <div class="btn-group btn-group-devided" data-toggle="buttons">
                                    <button class="btn btn-sm green-meadow"  onclick="addFranchiseeData('<?php echo $operationManagerAray['id'];?>');" href="javascript:void(0);">
                                        &nbsp;Add New Franchisee
                                    </button>
                                </div>
                            </div>
                    </div>

                    <?php
                  
                    if (!empty($franchiseeAray)) {
                        ?>
                     <div class="row">
                              <form class="search-bar" id="szSearchFranchiseeList" action="<?=__BASE_URL__?>/franchisee/franchiseeRecord" name="szSearchFranchiseeList" method="post">

                                  <div class="search clienttypeselect col-md-3">
                                   <div class="form-group <?php if (!empty($arErrorMessages['szSearch2']) != '') { ?>has-error<?php } ?>"> 
                                      <select class="form-control custom-select" name="szSearch2" id="szSearchname" onfocus="remove_formError(this.id,'true')">
                                          <option value="">Franchisee Name</option>
                                          <?php
                                          foreach($allfranchisee as $franchiseeIdList)
                                          {
                                              $selected = ($franchiseeIdList['szName'] == $_POST['szSearch2'] ? 'selected="selected"' : '');
                                              echo '<option value="'.$franchiseeIdList['szName'].'" ' . $selected . '>'.$franchiseeIdList['szName'].'</option>';
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
                                    <th>Franchisee code</th>
                                    <th> Name</th>
                                    <th> Email</th>
                                    <th> Contact No</th>
                                    <th> State</th>
                                    <th> Region Name</th>
                                    <th> Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $i = 0;
                                foreach ($franchiseeAray as $franchiseeData) {
                                            $Statedata = $this->Admin_Model->getstatebyregionid($franchiseeData['regionId']);
                                            $regioncode = $this->Admin_Model->getregionbyregionid($franchiseeData['regionId']);
                                    ?>
                                    <tr>
                                        <td><?php echo $franchiseeData['userCode']; ?> </td>
                                        <td> <?php echo $franchiseeData['szName'] ?> </td>
                                        <td> <?php echo $franchiseeData['szEmail']; ?> </td>
                                        <td> <?php echo $franchiseeData['szContactNumber']; ?> </td>
                                        <?php
                                            if(empty($Statedata['0']['name'])){
                                               $State = "N/A";
                                            } else {
                                                $State = $Statedata['0']['name'];
                                              }
                                           
                                       if(empty($regioncode['regionName'])){
                                               $Region = "N/A";
                                       }   else{
                                                $Region = $regioncode['regionName'];
                                            }
                                           ?>
                                            
                                            <td> <?php echo $State;?> </td>
                                             <td> <?php echo $Region;?> </td>
                                            <td>
                                            
                                             <?php if ($franchiseeData['iActive']==1) {?>   
                                              <a class="btn btn-circle btn-icon-only btn-default" id="status" title="Disable Franchisee" onclick="franchiseeStatus(<?php echo $franchiseeData['id'];?>,'0');" href="javascript:void(0);">
                                             <i class="fa fa-circle clr_green" aria-hidden="true"></i>
                                              </a>
                                                 <?php } else {?>
                                              <a class="btn btn-circle btn-icon-only btn-default" id="status" title="Franchisee Inactive" onclick="" href="javascript:void(0);">
                                             <i class="fa fa-circle clr" aria-hidden="true"></i>
                                              </a>
                                             <?php } ?>  
                                            
                                               <?php 
                                               if($franchiseeData['iActive']=='1')
                                                {
                                                   ?>
                                                <a class="btn btn-circle btn-icon-only btn-default" title="Edit Franchisee Data" onclick="editFranchiseeDetails('<?php echo $franchiseeData['id'];?>',<?php echo $operationManagerAray['id'];?>,'1');" href="javascript:void(0);">
                                                    <i class="fa fa-pencil"></i> 
                                                </a>
                                                <a class="btn btn-circle btn-icon-only btn-default" id="modelStoclVal" title="Model Stock Value Management" onclick="viewModelStockValMgt(<?php echo $franchiseeData['id'];?>);" href="javascript:void(0);"></i>
                                                    <i class="fa fa-cube" aria-hidden="true"></i>
                                                </a>
                                               <?php 
                                                $drugTestKitListAray =$this->Inventory_Model->viewDrugTestKitList(false,false,false,1);
                                                
                                         if(!empty($drugTestKitListAray)){
                                            foreach($drugTestKitListAray as $drugTestKitListData)
                                            {
                                                $drugTestKitDataArr[$drugTestKitListData['id']] = $this->StockMgt_Model->getStockValueDetailsByProductId($franchiseeData['id'],$drugTestKitListData['id']);   
                                               
                                            }
                                          $emptyArr = false;
                                           foreach($drugTestKitDataArr as $key => $val) {
                                           if(empty($val)){
                                             $emptyArr = true;
                                          }
                                            }
                                            
                                            if($emptyArr != true){
                                         
                                    ?>
                                                <a class="btn btn-circle btn-icon-only btn-default" id="productStoclMgt" title="Product Stock  Management" onclick="viewProductStockMgt(<?php echo $franchiseeData['id'];?>);" href="javascript:void(0);"></i>
                                                    <i class="fa fa-cubes" aria-hidden="true"></i>
                                                </a>
                                                <?php } } }  ?>
                                             <a class="btn btn-circle btn-icon-only btn-default" id="userStatus" title="View Franchisee Details" onclick="viewClient(<?php echo $franchiseeData['id'];?>);" href="javascript:void(0);">
                                                   <i class="fa fa-eye" aria-hidden="true"></i>
                                               </a>
                                               
                                               <?php  
                                                if($franchiseeData['iActive']=='1') {
                                               $clientDetailsAray = $this->Franchisee_Model->getClientCountId($franchiseeData['id']);
                                                
                                                if(empty($clientDetailsAray)){
                                               ?>
                                               <a class="btn btn-circle btn-icon-only btn-default" id="userStatus" title="Delete Franchisee" onclick="franchiseeDelete(<?php echo $franchiseeData['id'];?>);" href="javascript:void(0);"></i>
                                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                                </a>
                                                 <?php 
                                                } }
                                               ?>
                                            </td> 
                                        
                                        
<!--                                     <td>
                                                <a class="btn btn-circle btn-icon-only btn-default" title="Edit franchisee Data" onclick="editFranchiseeDetails('<?php echo $franchiseeData['id'];?>',<?php echo $operationManagerAray['id'];?>);" href="javascript:void(0);">
                                                    <i class="fa fa-pencil"></i> 
                                                </a>
                                                <a class="btn btn-circle btn-icon-only btn-default" id="modelStoclVal" title="Model Stock Value Management" onclick="viewModelStockValMgt(<?php echo $franchiseeData['id'];?>);" href="javascript:void(0);"></i>
                                                    <i class="fa fa-cube" aria-hidden="true"></i>
                                                </a>
                                                <a class="btn btn-circle btn-icon-only btn-default" id="productStoclMgt" title="Product Stock  Management" onclick="viewProductStockMgt(<?php echo $franchiseeData['id'];?>);" href="javascript:void(0);"></i>
                                                    <i class="fa fa-cubes" aria-hidden="true"></i>
                                                </a>
                                            <?php 
                                                $clientDetailsAray = $this->Franchisee_Model->getClientCountId($franchiseeData['id']);
                                                
                                                if(empty($clientDetailsAray)){
                                               ?>
                                               <a class="btn btn-circle btn-icon-only btn-default" id="userStatus" title="Delete Franchisee" onclick="franchiseeDelete(<?php echo $franchiseeData['id'];?>);" href="javascript:void(0);"></i>
                                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                                </a>
                                                 <?php 
                                                }
                                               ?>
                                                
                                                
                                            </td>-->
                                        </tr>
                                    </tr>
                                    <?php
                                     $i++;
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                       
                        <?php
                    } else {
                        echo "Not Found";
                    }
                  
                    ?>
         <?php  if(!empty($franchiseeAry)){?>
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