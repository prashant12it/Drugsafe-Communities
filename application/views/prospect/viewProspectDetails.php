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
                   
                    
                     <li>
                        <a href="<?php echo __BASE_URL__;?>">Home</a>
                        <i class="fa fa-circle"></i>
                    </li>
                   
                   <li>
                        <a href="<?php echo __BASE_URL__; ?>/prospect/prospectRecord"><?php echo $prospectDetailsAry['szBusinessName'];?></a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <span class="active">Prospect Details</span>
                    </li>
                </ul>
                
                <div class="portlet light bordered about-text" id="user_info">
        <div class="portlet-title">
            <div class="caption">
                <i class="icon-equalizer font-red-sunglo"></i>
                <span class="caption-subject font-red-sunglo bold uppercase">
                 
                    <?php 
                       echo "Prospect Details";
                      if($_SESSION['drugsafe_user']['iRole']==2){
                            if (($prospectDetailsAry['status']==1) || ($prospectDetailsAry['status']== 2)|| ($prospectDetailsAry['status']== 3)|| ($prospectDetailsAry['status']== 5)) { ?>
                    &nbsp; &nbsp;
                    <a class="btn btn-circle btn-icon-only btn-default" title="Edit Prospect Data" onclick="editProspectDetails('<?php echo $prospectDetailsAry['id'];?>','2');" href="javascript:void(0);">
                        <i class="fa fa-pencil"></i> 
                    </a>
                          <?php } } ?>
                </span>
            </div>
            
        </div>
        <div class="portlet-body alert">
            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-sm-4 text-info bold">
                            <lable>Business Name:</lable>
                        </div>
                        <div class="col-sm-8">
                            <p><?php echo $prospectDetailsAry['szBusinessName'];?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 text-info bold">
                            <lable>ABN:</lable>
                        </div>
                        <div class="col-sm-8">
                            <p><?php if(empty($prospectDetailsAry['abn'])){echo "N/A";} else {echo $prospectDetailsAry['abn'];} ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 text-info bold">
                            <lable>Primary Phone No:</lable>
                        </div>
                        <div class="col-sm-8">
                             <p><?php if(empty($prospectDetailsAry['szContactNumber'])){echo "N/A";} else {echo $prospectDetailsAry['szContactNumber'];} ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 text-info bold">
                            <lable>Contact Email:</lable>
                        </div>
                        <div class="col-sm-8">
                            <p><?php if(empty($prospectDetailsAry['szContactEmail'])){echo "N/A";} else {echo $prospectDetailsAry['szContactEmail'];} ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 text-info bold">
                            <lable>Contact Mobile No:</lable>
                        </div>
                        <div class="col-sm-8">
                             <p><?php if(empty($prospectDetailsAry['szContactMobile'])){echo "N/A";} else {echo $prospectDetailsAry['szContactMobile'];} ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 text-info bold">
                            <lable>Country:</lable>
                        </div>
                        <div class="col-sm-8">
                            <p><?php if(empty($prospectDetailsAry['szCountry'])){echo "N/A";} else {echo $prospectDetailsAry['szCountry'];} ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 text-info bold">
                            <lable>City:</lable>
                        </div>
                        <div class="col-sm-8">
                             <p><?php if(empty($prospectDetailsAry['szCity'])){echo "N/A";} else {echo $prospectDetailsAry['szCity'];} ?></p>
                    </div>
                      </div>
                     <div class="row">
                        <div class="col-sm-4 text-info bold">
                            <lable>Zip Code:</lable>
                        </div>
                        <div class="col-sm-8">
                             <p><?php if(empty($prospectDetailsAry['szZipCode'])){echo "N/A";} else {echo $prospectDetailsAry['szZipCode'];} ?></p>
                        </div>
                    </div>
                      <div class="row">
                        <div class="col-sm-4 text-info bold">
                            <lable>Status:</lable>
                        </div>
                            <?php
                                if($prospectDetailsAry['status']==1) {
                                    ?>
                                   <div class="col-sm-8">
                                    <span class="label label-sm label-warning">
                                    Pre Discovery
                                   </span>
                                     &nbsp; &nbsp;
                                   <?php  if($_SESSION['drugsafe_user']['iRole']==2){ ?>
                                        <a class="btn btn-circle btn-icon-only btn-default" title="Edit Prospect Status" onclick="editProspectStatus('<?php echo $prospectDetailsAry['id'];?>');" href="javascript:void(0);">
                                            <i class="fa fa-pencil"></i> 
                                        </a>
                                   <?php  } ?>
                                    </div>
         
                                    <?php
                                    }
                                if($prospectDetailsAry['status']==2) {
                                    ?>
                                  <div class="col-sm-8">
                                    <span class="label label-sm label-primary">
                                  Discovery Meeting
                                    </span>
                                   &nbsp; &nbsp;
                                      <?php  if($_SESSION['drugsafe_user']['iRole']==2){ ?>
                                    <a class="btn btn-circle btn-icon-only btn-default" title="Edit Prospect Status" onclick="editProspectStatus('<?php echo $prospectDetailsAry['id'];?>');" href="javascript:void(0);">
                                        <i class="fa fa-pencil"></i> 
                                    </a>
                                     </div>
                                      <?php } ?>
                                    <?php
                                }
                               
                                if ($prospectDetailsAry['status'] ==3) {
                                    ?>
                                   <div class="col-sm-8">
                                     <span class="label label-sm label-info">
                                     In Progress  
                                   </span>
                                          <?php  if($_SESSION['drugsafe_user']['iRole']==2){ ?>
                                  &nbsp; &nbsp;
                                    <a class="btn btn-circle btn-icon-only btn-default" title="Edit Prospect Status" onclick="editProspectStatus('<?php echo $prospectDetailsAry['id'];?>');" href="javascript:void(0);">
                                        <i class="fa fa-pencil"></i> 
                                    </a>
                                          <?php  } ?>
                                    </div>

                                    <?php
                                }
                          if ($prospectDetailsAry['status'] ==4) {
                                    ?>
                                   <div class="col-sm-8">
                                     <span class="label label-sm label-danger">
                                    Non Convertible 
                                   </span>
                                 
                                    </div>

                                    <?php
                                }
                              if ($prospectDetailsAry['status'] ==5) {
                                    ?>
                                   <div class="col-sm-8">
                                     <span class="label label-sm label-info">
                                     Contact Later   
                                   </span>
                                  &nbsp; &nbsp;
                                     <?php  if($_SESSION['drugsafe_user']['iRole']==2){ ?>
                                    <a class="btn btn-circle btn-icon-only btn-default" title="Edit Prospect Status" onclick="editProspectStatus('<?php echo $prospectDetailsAry['id'];?>');" href="javascript:void(0);">
                                        <i class="fa fa-pencil"></i> 
                                    </a>
                                     <?php  } ?>
                                    </div>

                                    <?php
                                }
                               if ($prospectDetailsAry['status'] ==6) {
                                    ?>
                                   <div class="col-sm-8">
                                     <span class="label label-sm label-success">
                                     Closed Sale  
                                   </span>
                                
                                    </div>

                                    <?php
                                }
                                ?>
                        </div>   
                </div>
                <div class="col-md-6">
                   <div class="row">
                        <div class="col-sm-4 text-info bold">
                            <lable>Contact Name:</lable>
                        </div>
                        <div class="col-sm-8">
                             <p><?php if(empty($prospectDetailsAry['szName'])){echo "N/A";} else {echo $prospectDetailsAry['szName'];} ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 text-info bold">
                            <lable>Primary Email:</lable>
                        </div>
                        <div class="col-sm-8">
                             <p><?php if(empty($prospectDetailsAry['szEmail'])){echo "N/A";} else {echo $prospectDetailsAry['szEmail'];} ?></p>
                        </div>
                    </div>
                     <div class="row">
                        <div class="col-sm-4 text-info bold">
                            <lable>Industry:</lable>
                        </div>
                        <div class="col-sm-8">
                             <?php if($prospectDetailsAry['industry']==1){
                               $value = 'Agriculture, Forestry and Fishing';
                            }
                            if($prospectDetailsAry['industry']==2){
                               $value = 'Mining';
                            }
                            if($prospectDetailsAry['industry']==3){
                               $value = 'Manufacturing';
                            }
                            if($prospectDetailsAry['industry']==4){
                               $value = 'Electricity, Gas and Water Supply';
                            }if($prospectDetailsAry['industry']==5){
                               $value = 'Construction';
                            }if($prospectDetailsAry['industry']==6){
                               $value = 'Wholesale Trade';
                            }if($prospectDetailsAry['industry']==7){
                               $value = 'Transport and Storage';
                            }if($prospectDetailsAry['industry']==8){
                               $value = 'Communication Services';
                            }if($prospectDetailsAry['industry']==9){
                               $value = 'Agriculture, Property and Business Services';
                            }if($prospectDetailsAry['industry']==10){
                               $value = 'Agriculture, Government Administration and Defence';
                            }if($prospectDetailsAry['industry']==11){
                               $value = 'Education';
                            }
                            if($prospectDetailsAry['industry']==12){
                               $value = 'Health and Community Services';
                            }if($prospectDetailsAry['industry']==13){
                               $value = 'Other';
                            }  ?>
                            
                            <p><?php echo $value;?></p>
                           
                        </div>
                    </div>
                   
                  
                      <div class="row">
                        <div class="col-sm-4 text-info bold">
                            <lable>Contact Phone No:</lable>
                        </div>
                        <div class="col-sm-8">
     
                              <p><?php if(empty($prospectDetailsAry['szContactPhone'])){echo "N/A";} else {echo $prospectDetailsAry['szContactPhone'];} ?></p>
                        </div>
                    </div>
                  
                  <div class="row">
                        <div class="col-sm-4 text-info bold">
                            <lable>Address:</lable>
                        </div>
                        <div class="col-sm-8">
                             <p><?php if(empty($prospectDetailsAry['szAddress'])){echo "N/A";} else {echo $prospectDetailsAry['szAddress'];} ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 text-info bold">
                            <lable>State:</lable>
                        </div>
                        <div class="col-sm-8">
                             <p><?php if(empty($getState['name'])){echo "N/A";} else {echo $getState['name'];} ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 text-info bold">
                            <lable>No of Sites:</lable>
                        </div>
                        <div class="col-sm-8">
                             <p><?php if(empty($prospectDetailsAry['szNoOfSites'])){echo "N/A";} else {echo $prospectDetailsAry['szNoOfSites'];} ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 text-info bold">
                            <lable>Lead Generation Channel:</lable>
                        </div>
                        <div class="col-sm-8">
                            <p><?php echo $prospectDetailsAry['L_G_Channel'];?></p>
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
                            <span class="caption-subject font-red-sunglo bold uppercase"><?php echo $prospectDetailsAry['szName'];?>'s Meeting Notes</span>
                        </div>
                         <?php  if($_SESSION['drugsafe_user']['iRole']==2){ 
                      if (($prospectDetailsAry['status'] ==1)|| ($prospectDetailsAry['status'] ==2) ||($prospectDetailsAry['status'] ==3) || ($prospectDetailsAry['status'] ==5)) {
                                    ?>
                        <div class="actions">
                                <div class="btn-group btn-group-devided" data-toggle="buttons">
                                    <button class="btn btn-sm green-meadow"  onclick="addMeetingNotesData(<?php echo $prospectDetailsAry['id'];?>,'2');" href="javascript:void(0);">
                                        &nbsp;Add New Meeting Note
                                    </button>
                                </div>
                            </div>
                         <?php  } } ?>
                    </div>

                    <?php
                  
                    if (!empty($mettingsDetailsAry)) {
                     if($_SESSION['drugsafe_user']['iRole']!=2){
                        ?>
                    
                     <div class="row">
                              <form class="form-horizontal" id="szSearchFranchiseeList" action="<?=__BASE_URL__?>/prospect/view_prospect_details" name="szSearchFranchiseeList" method="post">
                      <!--                          <div class="search col-md-3">
                            <input type="text" name="szSearch" id="szSearch" class="form-control input-square-right " placeholder="Id Or Name Or Email" value="<?//=sanitize_post_field_value($_POST['szSearch'])?>">
                              <select class="form-control custom-select" name="szSearch1" id="szSearch" onfocus="remove_formError(this.id,'true')">
                                  <option value="">Franchisee Id</option>
                                  <?php
                                      foreach($allfranchisee as $franchiseeIdList)
                                      {
                                          $selected = ($franchiseeIdList['id'] == $_POST['szSearch1'] ? 'selected="selected"' : '');
                                          echo '<option value="'.$franchiseeIdList['id'].'" >FR-'.$franchiseeIdList['id'].'</option>';
                                      }
                                  ?>
                              </select>
                          </div>
                                  <div class="col-md-1" style="text-align: center; padding: 5px 0px;">OR</div>-->
<!--                           <!--<button class="btn green-meadow" type="submit" ><i class="fa fa-search"></i></button>-->
                                  <div class="search col-md-3">
                                      <!--                            <input type="text" name="szSearch" id="szSearch" class="form-control input-square-right " placeholder="Id Or Name Or Email" value="--><?/*//=sanitize_post_field_value($_POST['szSearch'])*/?><!--">-->
                                      <select class="form-control custom-select" name="szSearch2" id="szSearchname" onfocus="remove_formError(this.id,'true')">
                                          <option value="">Created By</option>
                                          <?php
                                          foreach($mettingsDetailsSearchAry as $mettingsDetailsSearchData)
                                          {
                                                 $franchiseeDetArr = $this->Admin_Model->getAdminDetailsByEmailOrId('',$mettingsDetailsSearchData['szCreatedBy']);
                                              $selected = ($mettingsDetailsSearchData['szCreatedBy'] == $_POST['szSearch2'] ? 'selected="selected"' : '');
                                              echo '<option value="'.$mettingsDetailsSearchData['szCreatedBy'].'" ' . $selected . '>'.$franchiseeDetArr['szName'].'</option>';
                                          }
                                          ?>
                                      </select>
                                  </div>
<!--                                  <div class="col-md-1" style="text-align: center; padding: 5px 0px;">OR</div>
                                  <div class="search col-md-3">
                                                                  <input type="text" name="szSearch" id="szSearch" class="form-control input-square-right " placeholder="Id Or Name Or Email" value="<?//=sanitize_post_field_value($_POST['szSearch'])?>">
                                      <select class="form-control custom-select" name="szSearch" id="szSearchemail" onfocus="remove_formError(this.id,'true')">
                                          <option value="">Franchisee Email</option>
                                          <?php
                                          foreach($allfranchisee as $franchiseeIdList)
                                          {
                                              $selected = ($franchiseeIdList['szEmail'] == $_POST['szSearch'] ? 'selected="selected"' : '');
                                              echo '<option value="'.$franchiseeIdList['szEmail'].'" >'.$franchiseeIdList['szEmail'].'</option>';
                                          }
                                          ?>
                                      </select>
                                  </div>-->
                                  <div class="col-md-1">
                                  <button class="btn green-meadow" type="submit" ><i class="fa fa-search"></i></button>
                                  </div>
                           </form>
                          </div>
                     <?php }?>
                 
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th> Sr No.</th>
                                    <th> Meeting Note</th>
                                    <th> Created By</th>
                                    <th> Date/Time</th> 
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $i = 0;
                                foreach ($mettingsDetailsAry as $mettingsDetailsData) {
                                     $i++;
                                    ?>
                                    <tr>
                                        <td><?php echo $i; ?> </td>
                                          <?php
                                         
                                          
                                              $retval = $mettingsDetailsData['szDescription'];
                                              $string = preg_replace('/(?<=\S,)(?=\S)/', ' ', $mettingsDetailsData['szDescription']);
                                              $string = str_replace("\n", " ", $string);
                                              $array = explode(" ", $string);
                                              if (count($array)<=15)
                                              {
                                                  $retval = $string;
                                              }
                                              else
                                              {
                                                  array_splice($array, 15);
                                                  $retval = implode(" ", $array)." ...";
                                                  $retval .= '<a onclick="showDescription('.$mettingsDetailsData['id'].',2);" href="javascript:void(0);" >Read more</a>';
                                              }
                                               ?>
                                            
                                              
                                              <td><?php echo $retval;  ?></td>
                                       <td>  <?php 
                                             if($mettingsDetailsData['szCreatedBy'])
                                            {
                                                $franchiseeDetArr = $this->Admin_Model->getAdminDetailsByEmailOrId('',$mettingsDetailsData['szCreatedBy']);
                                                echo $franchiseeDetArr['szName'];
                                            }
                                            else
                                            {
                                               echo "N/A";
                                            }
                                           
                                            ?> 
                                           </td>
                                        <td>  <?php echo date('d M Y',strtotime($mettingsDetailsData['dtCreatedOn'])) . ' at '.date('h:i A',strtotime($mettingsDetailsData['dtCreatedOn'])); ?> </td>
                                        </tr>
                                    </tr>
                                    <?php
                                   
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
         <?php  if(!empty($mettingsDetailsAry)){?>
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