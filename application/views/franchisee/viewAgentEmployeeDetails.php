
<div class="page-content-wrapper">
        <div class="page-content">
             <?php
            if(!empty($_SESSION['drugsafe_user_message'])){
                if(trim($_SESSION['drugsafe_user_message']['type']) == "success"){
                    ?>
                    <div class="alert alert-success">
                        <?php echo $_SESSION['drugsafe_user_message']['content'];?>
                    </div>
                <?php }
                if(trim($_SESSION['drugsafe_user_message']['type']) == "error") {
                    ?>
                    <div class="alert alert-danger">
                        <?php echo $_SESSION['drugsafe_user_message']['content'];?>
                    </div>
                <?php }
                $this->session->unset_userdata('drugsafe_user_message');
            }
            ?>
            
            <div id="page_content" class="row">
                <div class="col-md-12">
                    <ul class="page-breadcrumb breadcrumb">
                    <?php  $franchiseeDetArr = $this->Admin_Model->getAdminDetailsByEmailOrId('',$agentEmployeeDetailsAray['clientType']);?>    
                  
                    <li>
                        <a href="<?php echo __BASE_URL__;?>/franchisee/clientRecord">Home</a>
                        <i class="fa fa-circle"></i>
                    </li>
                            <li>
                            <a onclick="viewClientAgentDetails(<?php echo $agentEmployeeDetailsAray['clientType']; ?>,'2');" href="javascript:void(0);"><?php echo $franchiseeDetArr['szName'];?></a>
                         <i class="fa fa-circle"></i>
                            </li>
                        <li>
                            <a onclick="" href="javascript:void(0);"><?php echo $agentEmployeeDetailsAray['szName'];?>'s Details</a>
                       
                        </li>
                     
                      
                    </ul>
     <div class="portlet light bordered about-text" id="user_info">
        <div class="portlet-title">
            <div class="caption">
                <i class="icon-equalizer font-red-sunglo"></i>
                <span class="caption-subject font-red-sunglo bold uppercase">
                 
                    <?php 
                    /*if($clientDetailsAray['clientType']=='0')
                    {
                        echo $clientDetailsAray['szName']."'s Headquarters";
                    }
                    else
                    {*/
                       echo $agentEmployeeDetailsAray['szName']."'s Details";
//                    }
                   ?>
                    &nbsp; &nbsp;
                   <?php  if($_SESSION['drugsafe_user']['iRole']=='2'){?>
                  <a class="btn btn-circle btn-icon-only btn-default" title="Edit Client Data" onclick="editAgentEmployeeDetails('<?php echo $agentEmployeeDetailsAray['agentId']; ?>','2');" href="javascript:void(0);">
                    <i class="fa fa-pencil"></i> 
                  </a> 
                <?php }?>
                </span>
            </div>
            <!--<div class="actions">
                <div class="btn-group btn-group-devided" data-toggle="buttons">
                    <button class="btn btn-sm green-meadow" onclick="redirect_url('<?php /*echo base_url();*/?>franchisee/clientList');">
                        &nbsp;Client List
                    </button>
                </div>
            </div>-->
        </div>
         <?php  $regioncode = $this->Admin_Model->getregionbyregionid($franchiseeDetArr['regionId']);
                     if(empty($regioncode['regionName'])){
                                               $Region = "N/A";
                                       }   else{
                                                $Region = $regioncode['regionName'];
                                            }?>
        <div class="portlet-body alert">
            <div class="row">
                <div class="col-md-6">
                     <div class="row">
                        <div class="col-sm-4 text-info bold">
                            <lable> Business Name:</lable>
                        </div>
                        <div class="col-sm-8">
                            <p><?php echo $agentEmployeeDetailsAray['szBusinessName'];?></p>
                        </div>
                    </div>
                     <div class="row">
                        <div class="col-sm-4 text-info bold">
                            <lable>Primary Email:</lable>
                        </div>
                        <div class="col-sm-8">
                            <p><?php echo $agentEmployeeDetailsAray['szEmail'];?></p>
                        </div>
                    </div>
                     
                      <div class="row">
                        <div class="col-sm-4 text-info bold">
                            <lable> Region Name:</lable>
                        </div>
                        <div class="col-sm-8">
                            <p><?php echo $Region;?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 text-info bold">
                            <lable>City:</lable>
                        </div>
                        <div class="col-sm-8">
                            <p><?php echo $agentEmployeeDetailsAray['szCity'];?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 text-info bold">
                            <lable>Country:</lable>
                        </div>
                        <div class="col-sm-8">
                            <p><?php echo $agentEmployeeDetailsAray['szCountry'];?></p>
                        </div>
                    </div>
                   
                </div>
                <div class="col-md-6">
                    
                     <div class="row">
                        <div class="col-sm-4 text-info bold">
                            <lable>Contact Name:</lable>
                        </div>
                        <div class="col-sm-8">
                            <p><?php echo $agentEmployeeDetailsAray['szName'];?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 text-info bold">
                            <lable>Primary Phone No:</lable>
                        </div>
                        <div class="col-sm-8">
                            <p><?php echo $agentEmployeeDetailsAray['szContactNumber'];?></p>
                        </div>
                    </div>
                     
                    
                    
                    <div class="row">
                        <div class="col-sm-4 text-info bold">
                            <lable>Address:</lable>
                        </div>
                        <div class="col-sm-8">
                            <p><?php echo $agentEmployeeDetailsAray['szAddress'];?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 text-info bold">
                            <lable>State:</lable>
                        </div>
                        <div class="col-sm-8">
                            <p><?php echo $agentEmployeeDetailsAray['szState'];?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 text-info bold">
                            <lable>ZIP/Postal Code:</lable>
                        </div>
                        <div class="col-sm-8">
                            <p><?php echo $agentEmployeeDetailsAray['szZipCode'];?></p>
                        </div>
                    </div>
                </div> 
                
             </div>
           
        </div>
     </div>
        
      
</div>
</div>
</div>
</div>
</div>
<div id="popup_box"></div>