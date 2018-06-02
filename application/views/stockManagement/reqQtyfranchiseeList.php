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
                            <a href="<?php echo __BASE_URL__;?>/stock_management/stockreqlist">Home</a>
                            <i class="fa fa-circle"></i>
                        </li>
                        <li>
                            <span class="active">Request Franchisee List</span>
                        </li>
                    </ul>
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-equalizer font-red-sunglo"></i>
                                <span class="caption-subject font-red-sunglo bold uppercase">Request Franchisee List</span>
                            </div>
                          
                        </div>

                        <?php
                        if(!empty($frReqQtyAray))
                        {
                            ?>
                     
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th> #</th>
                                        <th> Order Number</th>
                                        <th> Franchisee</th>
                                        <th> Order Date</th>
                                        <th> Quantity Requests </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    if($frReqQtyAray)
                                    {   $i = 0;
                                      
                                        foreach($frReqQtyAray as $frReqQtyArayData)
                                        {
                                          
                                            //$franchiseeAray = $this->Admin_Model->getUserDetailsByEmailOrId('',$frReqQtyArayData['iFranchiseeId']);
                                            
                                            $reqQtyListAray =$this->StockMgt_Model->getRequestQtyList(false,$frReqQtyArayData['id'],false,false);
                                               $count=0;
                                               foreach($reqQtyListAray as $reqQtyListData){

                                                  $count++; 

                                                }
                                           
                                        ?>
                                        <tr>
                                            <td> <?php echo $frReqQtyArayData['id'];?> </td>
                                            <td> <?php echo $frReqQtyArayData['szName']?> </td>
                                            <td> <?php echo $frReqQtyArayData['szName']?> </td>
                                            <td> <?php echo $frReqQtyArayData['szName']?> </td>
                                           <td>
                                                
                                                <a class="btn btn-circle btn-icon-only btn-default" id="quantityStatus" title="View Quantity Requests" onclick="ViewReqProductList(<?php echo $frReqQtyArayData['id'];?>);" href="javascript:void(0);"></i>
                                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                                </a>
                                                <!-- BEGIN NOTIFICATION  -->
                                       
                                                <span class="badge badge-danger"><?php echo $count ?></span>
                                                <!-- END NOTIFICATION  -->

                                               
                                            </td>
                                        </tr>
                                        <?php 
                                        }
                                    } ?>
                                </tbody>
                            </table>
                      
                        </div>
                             <?php
                            $i++;  
                        }
                        else
                        {
                            echo "Not Found";
                        }
                        ?>
                       <?php  if(!empty($frReqQtyAray)){?>
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