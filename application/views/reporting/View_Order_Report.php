<script type='text/javascript'>
    $(function() {
      $("#szSearch1").customselect();
       $("#szSearch2").customselect();
      $("#szSearch3").customselect();
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
                        <span class="active">View Orders Report</span>
                    </li>
                    
                </ul>

                <div class="portlet light bordered about-text" id="user_info">
                   
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-equalizer font-red-sunglo"></i>
                                <span class="caption-subject font-red-sunglo bold uppercase">
                                   View Orders Report
                                </span>
                            </div>
                
                        </div>
                        
                       <div class="row">
                      <form name="orderSearchForm" id="orderSearchForm" action="<?=__BASE_URL__?>/order/view_order_list" method="post">
                <div class="row">
                    <div class="clienttypeselect col-md-3">
                        <div class="form-group ">
                           <select class="form-control custom-select" name="szSearch1" id="szSearch1" onfocus="remove_formError(this.id,'true')">
                                          <option value="">Franchisee Name</option>
                                          <?php
                                          foreach($allFrDetailsSearchAray as $allFrDetailsSearchList)
                                          {
                                              $selected = ($allFrDetailsSearchList['franchiseeid'] == $_POST['szSearch1'] ? 'selected="selected"' : '');
                                              echo '<option value="'.$allFrDetailsSearchList['franchiseeid'].'"'.$selected.' >'.$allFrDetailsSearchList['szName'].'</option>';
                                          }
                                          ?>
                           </select>
                        </div>
                    </div>
                    <div class="col-md-1">
                    </div>

                    <div class="col-md-3">
                        <div class="form-group ">
                           <select class="form-control custom-select" name="szSearch2" id="szSearch2" onfocus="remove_formError(this.id,'true')">
                                          <option value="">Order No</option>
                                          <?php
                                          foreach($validOrdersDetailsSearchAray as $validOrdersDetailsSearchList)
                                          {
                                              $selected = ($validOrdersDetailsSearchList['orderid'] == $_POST['szSearch2'] ? 'selected="selected"' : '');
                                              echo '<option value="'.$validOrdersDetailsSearchList['orderid'].'" '.$selected.' >#0000'.$validOrdersDetailsSearchList['orderid'].'</option>';
                                          }
                                          ?>
                           </select>
                        </div>
                    </div>
                    <div class="col-md-1">
                        </div>
                          
                       <div class="col-md-3">
                        <div class="form-group <?php if (!empty($arErrorMessages['szSearch4']) != '') { ?>has-error<?php } ?>">
                           <div class="input-group input-medium date date-picker" data-date-format="dd/mm/yyyy" >
                                          
                                           <input type="text" id="szSearch4" class="form-control" value="<?php echo set_value('szSearch4'); ?>" readonly placeholder="Start Order Date" onfocus="remove_formError(this.id,'true')" name="szSearch4">
                                               <span class="input-group-addon">
                                               <i class="fa fa-calendar"></i>
                                               </span>
                                       </div>
                                       <!-- /input-group -->
                                     <?php
                               if(form_error('szSearch4')){?>
                               <span class="help-block pull-left"><span><?php echo form_error('szSearch4');?></span>
                             </span><?php }?> 
                                         <?php if (!empty($arErrorMessages['szSearch4'])) { ?>
                                            <span class="help-block pull-left">
                                                <i class="fa fa-times-circle"></i>
                                                <?php echo $arErrorMessages['szSearch4']; ?>
                                            </span>
                                        <?php } ?>
                          </div>
                        
                    </div>
                </div>
                     <div class="row">
                     <div class="col-md-3">
                        <div class="form-group <?php if (!empty($arErrorMessages['szSearch5']) != '') { ?>has-error<?php } ?>">
                           <div class="input-group input-medium date date-picker" data-date-format="dd/mm/yyyy" >
                                          
                                           <input type="text" id="szSearch5" class="form-control" value="<?php echo set_value('szSearch5'); ?>" readonly placeholder="End Order Date" onfocus="remove_formError(this.id,'true')" name="szSearch5">
                                               <span class="input-group-addon">
                                               <i class="fa fa-calendar"></i>
                                               </span>
                                       </div>
                                       <!-- /input-group -->
                                     <?php
                               if(form_error('szSearch5')){?>
                               <span class="help-block pull-left"><span><?php echo form_error('szSearch5');?></span>
                             </span><?php }?> 
                                         <?php if (!empty($arErrorMessages['szSearch5'])) { ?>
                                            <span class="help-block pull-left">
                                                <i class="fa fa-times-circle"></i>
                                                <?php echo $arErrorMessages['szSearch5']; ?>
                                            </span>
                                        <?php } ?>
                          </div>
                    </div>
                        <div class="col-md-1">
                         </div>

                         <div class="col-md-1">
                              <button class="btn green-meadow" type="submit" ><i class="fa fa-search"></i></button>
                         </div>
                    </div>                  
                </form> 
                     </div>    
                    
                <div class="row">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered table-striped">
                            <thead>
                            <tr>
                                    <th>
                                             #
                                    </th>
                                    <th>
                                         Franchisee 
                                    </th>
                                    <th>
                                          Order Date 
                                    </th>
                                    <th>
                                             Order#  
                                    </th>
                                    <th>
                                          No of Products
                                    </th>
                                   
                                    <th>
                                             Order Cost
                                    </th>
                                    <th>
                                             Xero Invoice No                                                               </th>

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
                   
            </div>
                
        </div>
    </div>
 </div>
<div id="popup_box"></div>
