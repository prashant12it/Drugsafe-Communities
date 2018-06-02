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
                    <li>
                        <a href="<?php echo __BASE_URL__;?>">Home</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                     View Percentage Details
                    </li>
                    </ul>
       <div class="portlet light bordered about-text" id="user_info">
        <div class="portlet-title">
            <div class="caption">
                <i class="icon-equalizer font-red-sunglo"></i>
                <span class="caption-subject font-red-sunglo bold uppercase">
              
                     Percentage Details
               
                </span>
            </div>
            <div class="actions">
             <a href="<?php echo __BASE_URL__; ?>/ordering/discountPercentage"
               class=" btn green-meadow">
            Back </a>
        </div>
        </div>
                  
        <div class="portlet-body alert">
            <div class="row">
                <div class="col-md-12">
                     <div class="row">
                        <div class="col-sm-2 text-info bold">
                            <lable>  Description:</lable>
                        </div>
                        <div class="col-sm-10">
                            <p><?php echo $getAllDiscountAry['description'];?></p>
                        </div>
                    </div>
                     <div class="row">
                        <div class="col-sm-2 text-info bold">
                            <lable> Discount:</lable>
                        </div>
                        <div class="col-sm-10">
                            <p><?php echo $getAllDiscountAry['percentage'];?>%</p>
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