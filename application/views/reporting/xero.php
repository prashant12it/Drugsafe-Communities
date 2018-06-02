
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
                        <span class="active">Invoices</span>
                    </li>
                    
                </ul>

                <div class="portlet light bordered about-text" id="user_info">
                   
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-equalizer font-red-sunglo"></i>
                                <span class="caption-subject font-red-sunglo bold uppercase">
                                   Invoice 
                                </span>
                                 <span class="font-green-meadow">
                                   INV-123 
                                </span>
                            </div>
                
                        </div>
                 
                                <div class="row">
                    <div class="">
                        <table class="table table-hover  table-striped ">
                            <thead>
                            <tr>
                                <div class="row margin-bottom-15">
                                  <div class="col-md-6 Text_blur">
                                <b>&nbsp;&nbsp; Awating Payment </b>
                                </div>
                                 <div class="col-md-6 Text">
                                     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <i class="fa fa-eye"></i>     
                                <b> Preview </b>&nbsp;
                                 <a href="<?=__BASE_URL__?>/admin/admin_login" class="btn btn-xs green-meadow" type="button">Email</a>
                                 &nbsp;
                                 <a href="<?=__BASE_URL__?>/admin/admin_login" class="btn btn-xs green-meadow" type="button">Print Pdf</a>
                                 &nbsp;
                                 <a href="<?=__BASE_URL__?>/admin/admin_login" class="btn btn-xs green-meadow" type="button"><i class="fa fa-file"></i>  </a>
                                  &nbsp;
                                 <a href="<?=__BASE_URL__?>/admin/admin_login" class="btn btn-xs green-meadow" type="button">Invoice Options</a>
                                </div> 
                                </div>
                             
                            </tr>
                            </thead>
                            <tbody>
 <div class="well-large">
                            <tr>
                                <hr>
                                
                                 <div class="row">
                                       <div class="col-md-8">
                                      <div class="col-md-3">
                                           <b>To</b>
                                           </div>
                                   
                                <div class="col-md-3">
                                           <b>Date</b>
                                           </div>
                                    
                                    <div class="col-md-2">
                                           <b>Due Date</b>
                                           </div>
                                     
                    <div class="col-md-2">
                                           <b>Invoice #</b>
                                           </div>
                                  
                          <div class="col-md-1">
                                          <b>Refrence</b>
                                           </div>
                             </div>
                                     <div class="col-md-4">
                                          
                                          <div class="Total_align">
                                             <b>Total</b>
                                     </div>
                                     
                              </div>
                                      </div>
                        </tr>
                                <tr>
                                 <div class="row">
                                       <div class="col-md-8">
                                      <div class="col-md-3 Text">
                                         shalini g-94 sector-22 noida 8374657465745
                                           </div>
                                   
                                <div class="col-md-3">
                                          13 aug 1994
                                           </div>
                                    
                                    <div class="col-md-2">
                                          1 jun 1995
                                           </div>
                                     
                                  <div class="col-md-2">
                                          #000012
                                           </div>
                                  
                          <div class="col-md-1">
                                          Test
                                           </div>
                             </div>
                                     <div class="col-md-4">
                                          
                                          <div class="Total_align">
                                           $<?php echo number_format($priceTotal, 2, '.', ',');;?> 
                                     </div>
                                     
                              </div>
                                      </div>
                              
                                </tr>

                            </tbody>
                            </table>
                    </div>        
                </div>
        <hr>
       
                                     <div class="Text_align">
                                          Amounts are Tax Exclusive
                                     </div>
                                     
                            
                 
                <div class="row">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered table-striped">
                            <thead>
                            <tr>
                                    <th>
                                             Item Code
                                    </th>
                                    <th>
                                         Description 
                                    </th>
                                    <th>
                                         Quantity
                                    </th>
                                    <th>
                                          Unit Price 
                                    </th>
                                    <th>
                                          Disc %
                                    </th>
                                   
                                    <th>
                                           Account
                                    </th>
                                    <th>
                                           Tax Rate                                                  
                                     </th>
                                    <th>
                                          Amount AUD                                          
                                    </th>
                                     

                            </tr>
                            </thead>
                            <tbody>

                            <tr>
                                    <td><?php echo $i; ?> </td>
                                    <td>
                                         <?php echo $franchiseeDetArr1['szName'];?> 
                                    </td>
                                    <td>
                                         <?php echo $date['2'];?> <?php echo $monthName;?>  <?php  echo $date['0'];?> at <?php echo $x;?>
                                    </td>
                                    <td>  </td>
                                    <td></td>
                                    <td>
                                       
                                    </td>
                                    <td>

                                    </td>

                                </tr>

                            </tbody>
                            </table>
                    </div>        
                </div>
                     <div class="row">
                                    <div class="col-md-6">
                                    </div>
                                    <div class="col-md-6">
                                            <div class="well">
                                                    <div class="row static-info align-reverse">
                                                            <div class="col-md-8 name">
                                                                    Sub Total:
                                                            </div>
                                                            <div class="col-md-3 value">
                                                                $<?php echo number_format($priceTotal, 2, '.', ',');;?> 
                                                                     
                                                            </div>
                                                    </div>
                                                <div class="row static-info align-reverse">
                                                            <div class="col-md-8 name">
                                                                     Total GST 10%:
                                                            </div>
                                                            <div class="col-md-3 value">
                                                                $<?php echo number_format($priceTotal, 2, '.', ',');;?> 
                                                                     
                                                            </div>
                                                    </div>
                                                <div class="row static-info align-reverse">
                                                            <div class="col-md-8 name">
                                                                   <h4> <b> Total: </b> </h4>      
                                                     </div>
                                                            <div class="col-md-3 value">
                                                                  <h4> <b>  $<?php echo number_format($priceTotal, 2, '.', ',');;?>  </b> </h4>   
                                                               
                                                                     
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
