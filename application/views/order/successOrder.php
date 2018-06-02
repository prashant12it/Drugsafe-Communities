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
                        <span class="active">Order Details</span>
                    </li>
                </ul>

                <div class="portlet light bordered about-text" id="user_info">
                   
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-equalizer font-red-sunglo"></i>
                                <span class="caption-subject font-red-sunglo bold uppercase">
                                    Order Details
                                </span>
                            </div>
                
                        </div>
                        <div class="portlet-body alert">
                           <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="portlet green-meadow box">
                                        <div class="portlet-title">
                                                <div class="caption">
                                                       <div> <i class="fa fa-cogs "></i> Order #0000<?php echo $orderid?></div>
                                                </div>
                                            <div class="actions">
                                                <?php  $totalOrdersAray = $this->Order_Model->getOrderByOrderId($orderid); 
                                                $splitTimeStamp = explode(" ",$totalOrdersAray['createdon']);
                                                             $date1 = $splitTimeStamp[0];
                                                             $time1 = $splitTimeStamp[1];
                                                           
                                                           $x=  date("g:i a", strtotime($time1));
                                                     
                                                          $date= explode('-', $date1);
                                                        
                                                          
                                                          $monthNum  = $date['1'];
                                                         
                                                          $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                                                          $monthName = $dateObj->format('M'); ?>
                                      <span class="todo-comment-date"><?php echo $date['2'];?> <?php echo $monthName;?>  <?php  echo $date['0'];?> at <?php echo $x;?></span>
                                </div>
                            </div>
                                        </div>
                                            <div class="portlet-body">
                                                    <div class="table-responsive">
                                                            <table class="table table-hover table-bordered table-striped">
                                                            <thead>
                                                             <tr>
                                                                    <th>  Image </th>
                                                                    <th>  Product Code</th>
                                                                    <th>  Description</th>
                                                                    <th>  Cost</th>
                                                                    <th>  Quantity</th>
                                                                    <th>  Price</th>
                                                             </tr>
                                                             </thead>
                                        <tbody>
                                            <?php
                                           
                                                $priceTotal = 0;
                                                foreach($totalOrdersDetailsAray as $totalOrdersDetailsData)
                                                {   
                                                 $productDataArr = $this->Inventory_Model->getProductDetailsById($totalOrdersDetailsData['productid']);
                                                 $price = ($totalOrdersDetailsData['quantity'])*($productDataArr['szProductCost']);
                                                 $priceTotal +=$price; 
                                                   ?>
                                                <tr>
                                                    <td>
                                                        <img class="file_preview_image" src="<?php echo __BASE_USER_PRODUCT_IMAGES_URL__; ?>/<?php echo $productDataArr['szProductImage']; ?>" width="60" height="60"/>    
                                                    </td>
                                                    <td><?php echo $productDataArr['szProductCode']?> </td>
                                                    <td> <?php echo $productDataArr['szProductDiscription'];?> </td>
                                                    <td> $<?php echo $productDataArr['szProductCost'];?> </td>
                                                   <td> <?php echo $totalOrdersDetailsData['quantity'];?> </td>
                                                 
                                                   <td> $<?php echo number_format($price, 2, '.', ',');;?> </td>
                                                   
                                                </tr>
                                                 
                                            <?php  }
                                            
                                             
                                           ?>

                                        </tbody>
                                       </table>
                                    </div>
                                 </div>
                                </div>
                                 </div>
                            </div>
                            <div class="row">
                                    <div class="col-md-6">
                                    </div>
                                    <div class="col-md-6">
                                            <div class="well">
                                                    <div class="row static-info align-reverse">
                                                            <div class="col-md-8 name">
                                                                     Total Price(Exl GST):
                                                            </div>
                                                            <div class="col-md-3 value">
                                                                $<?php echo number_format($priceTotal, 2, '.', ',');;?> 
                                                                     
                                                            </div>
                                                    </div>
                                                    
                                            </div>
                                    </div>
                            </div>
                     <div class="row">
                          <div class="col-md-9">
                              </div>
                            <div class="col-md-3">
                          
                             <button type="button" onclick="redirect_url('<?php echo base_url();?>order/drugtestkit');" class="btn green-meadow"><i class="fa fa-cart-arrow-down"></i> Continue Ordering</button>   
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