
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
                         <?php
                    if($_SESSION['drugsafe_user']['iRole'] == '2'){
                     ?>
                  
                    <li>
                        <a href="<?php echo __BASE_URL__;?>/franchisee/clientRecord">Home</a>
                        <i class="fa fa-circle"></i>
                    </li>
                      <?php } else {?>
                    
                    <li>
                        <a href="<?php echo __BASE_URL__;?>">Home</a>
                        <i class="fa fa-circle"></i>
                    </li>
                      <?php  } ?>
                 
                     <?php
                   
                     $franchiseeDetArr = $this->Admin_Model->getAdminDetailsByEmailOrId('',$franchiseeid);
                    if(($_SESSION['drugsafe_user']['iRole'] == '1') || ($_SESSION['drugsafe_user']['iRole'] == '5')){
                     ?>
                        <li>
                        <a onclick="viewClient(<?php echo $franchiseeid ;?>);" href="javascript:void(0);"><?php echo $franchiseeDetArr['szName'];?></a>
                        <i class="fa fa-circle"></i>
                       </li>
                    <?php }?>
                         <li>
                            <a href="<?php echo __BASE_URL__; ?>/franchisee/agentRecord"><?php echo $recordArr['0']['szName']; ?></a>
                             <i class="fa fa-circle"></i>
                        </li>
                        <li>
                              
                                <span class="active">Details</span>
                            </li>
                   
                    
                    </ul>
     <div class="portlet light bordered about-text" id="user_info">
        <div class="portlet-title">
            <div class="caption">
                <i class="icon-equalizer font-red-sunglo"></i>
                <span class="caption-subject font-red-sunglo bold uppercase">
                <?php
                      echo $recordArr['0']['szName']."'s Details";
                ?>
                    
                </span>
            </div>
            <div class="actions">
             <a href="<?php echo __BASE_URL__; ?>/franchisee/agentRecord"
               class=" btn green-meadow">
            Back </a>
        </div>
        </div>
        
        <div class="portlet-body alert">
            <div class="row">
                <div class="col-md-6">
                     <div class="row">
                        <div class="col-sm-4 text-info bold">
                            <lable>  Name:</lable>
                        </div>
                        <div class="col-sm-8">
                            <p><?php echo $recordArr['0']['szName'];?></p>
                        </div>
                    </div>
                     <div class="row">
                        <div class="col-sm-4 text-info bold">
                            <lable> Email:</lable>
                        </div>
                        <div class="col-sm-8">
                            <p><?php echo $recordArr['0']['szEmail'];?></p>
                        </div>
                    </div>
                  <div class="row">
                        <div class="col-sm-4 text-info bold">
                            <lable>Address:</lable>
                        </div>
                        <div class="col-sm-8">
                            <p><?php echo $recordArr['0']['szAddress'];?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 text-info bold">
                            <lable>State:</lable>
                        </div>
                        <div class="col-sm-8">
                            <p><?php echo $getState['name'];?></p>
                        </div>
                    </div>
                     <div class="row">
                        <div class="col-sm-4 text-info bold">
                            <lable>ZIP/Postal Code:</lable>
                        </div>
                        <div class="col-sm-8">
                            <p><?php echo $recordArr['0']['szZipCode'];?></p>
                        </div>
                    </div>

                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-sm-4 text-info bold">
                            <lable>ABN:</lable>
                        </div>
                        <div class="col-sm-8">
                            <p><?php echo $recordArr['0']['abn'];?></p>
                        </div>
                    </div>
                     
                    <div class="row">
                        <div class="col-sm-4 text-info bold">
                            <lable>Contact Number:</lable>
                        </div>
                        <div class="col-sm-8">
                            <p><?php echo $recordArr['0']['szContactNumber'];?></p>
                        </div>
                    </div>
                     <div class="row">
                        <div class="col-sm-4 text-info bold">
                            <lable>Country:</lable>
                        </div>
                        <div class="col-sm-8">
                            <p><?php echo $recordArr['0']['szCountry'];?></p>
                        </div>
                    </div>
                  <div class="row">
                        <div class="col-sm-4 text-info bold">
                            <lable>City:</lable>
                        </div>
                        <div class="col-sm-8">
                            <p><?php echo $recordArr['0']['szCity'];?></p>
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