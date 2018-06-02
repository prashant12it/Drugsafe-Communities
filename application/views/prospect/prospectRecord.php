<script type='text/javascript'>
    $(function() {
        $("#szSearchname").customselect();
         $("#szSearchfr").customselect();
         $("#szSearchStatus").customselect();
    });
</script>
<div id="loader"></div>
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
                              <a href="<?php echo __BASE_URL__; ?>">Home</a>
                            <i class="fa fa-circle"></i>
                        </li>
                        <?php
                        if(!empty($_POST['szSearch3'])){
                        if(($_SESSION['drugsafe_user']['iRole']==1)|| ($_SESSION['drugsafe_user']['iRole']==5) ){
                            $userArray = $this->Admin_Model->getUserDetailsByEmailOrId('',$_POST['szSearch3']);?>
                         <li>
                           
                             <a href="<?php echo __BASE_URL__; ?>/prospect/franchiseeProspectRecord"><?php echo $userArray['szName'];?></a>
                            <i class="fa fa-circle"></i>
                        </li>
                             
                        <?php }} ?>
                        <li>
                            <span class="active">Prospect Record</span>
                        </li>
                    </ul>
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-equalizer font-red-sunglo"></i>
                                <span class="caption-subject font-red-sunglo bold uppercase">Prospect Record</span>
                            </div>
                            <div class="actions">
                               <?php if($_SESSION['drugsafe_user']['iRole']==2){ ?>
                                <div class="btn-group btn-group-devided" data-toggle="buttons">
                                    <button class="btn btn-sm green-meadow" onclick="redirect_url('<?php echo base_url();?>prospect/addprospect');">
                                        &nbsp;Add New Prospect 
                                    </button>
                                </div>
                               <?php } ?>
                                 <?php
                        if(!empty($prospectDetailsAry))
                        { 
                            ?>
                                &nbsp; &nbsp;
                                  <a onclick="export_csv_report('<?php echo $_POST['szSearch3'];?>','<?php echo $_POST['szSearch1'];?>','<?php echo $_POST['szSearch2'];?>')" href="javascript:void(0);"
                                   class=" btn green-meadow">
                                    <i class="fa fa-file-excel-o"></i> Export CSV</a>
                                     <?php
                        } 
                     if($_SESSION['drugsafe_user']['iRole']==2){
                            ?>
                       
                                  &nbsp; &nbsp;
                                  <a onclick="import_csv_popup()" href="javascript:void(0);"
                                   class=" btn green-meadow">
                                    <i class="fa fa-reply"></i> Import CSV</a>
                     <?php } ?>
                            </div>
                        </div>
                     <?php 
                        if(!empty($_POST))
                        { 
                
                       ?>
                       
                         <div class=" search row">
                              <form class="form-horizontal" id="szSearchField" action="<?=__BASE_URL__?>/prospect/prospectRecord" name="szSearchField" method="post">
                              <?php  if($_SESSION['drugsafe_user']['iRole']==1 || $_SESSION['drugsafe_user']['iRole']==5) {?>
                                  <div class="search clienttypeselect col-md-3">
                                   <?php if($_SESSION['drugsafe_user']['iRole']==1 ){
                                       $searchOptionArr =$this->Admin_Model->viewFranchiseeList(false,false); 
                                   }
                                   if($_SESSION['drugsafe_user']['iRole']==5 ){
                                       $searchOptionArr =$this->Admin_Model->viewFranchiseeList(false,$_SESSION['drugsafe_user']['id']); 
                                   }
                                       ?>
                                      <select class="form-control custom-select" name="szSearch3" id="szSearchfr" onfocus="remove_formError(this.id,'true')" onchange="getProspectListByFrId(this.value);">
                                          <option value="">Franchisee</option>
                                          <?php
                                          foreach($searchOptionArr as $searchOptionList)
                                          {
                                              $selected = ($searchOptionList['id'] == $_POST['szSearch3'] ? 'selected="selected"' : '');
                                              echo '<option value="'.$searchOptionList['id'].'"' . $selected . ' >'.$searchOptionList['szName'].'</option>';
                                          }
                                          ?>
                                      </select>
                                  </div>
                                
                             <?php }?>
                                  <div class="clienttypeselect search col-md-3">
                                     <div id='szClient'>
                                      <select class="form-control custom-select" name="szSearch1" id="szSearchname" onfocus="remove_formError(this.id,'true')">
                                          <option value="">Business Name</option>
                                          <?php
                                          foreach($prospectDetailsSearchAry as $prospectDetailsSearchList)
                                          {
                                              $selected = ($prospectDetailsSearchList['szBusinessName'] == $_POST['szBusinessName'] ? 'selected="selected"' : '');
                                              echo '<option value="'.$prospectDetailsSearchList['szBusinessName'].'"' . $selected . ' >'.$prospectDetailsSearchList['szBusinessName'].'</option>';
                                          }
                                          ?>
                                      </select>
                                           </div>
                                  </div>
                                 
                                <div class="  col-md-3">
                                   
                                      <select class="form-control custom-select" name="szSearch2" id="szSearchStatus" onfocus="remove_formError(this.id,'true')">
                                         
                                        <option value=''>Status</option>
                                        <option value="1" <?php echo(sanitize_post_field_value($_POST['szSearch2']) == trim("1") ? "selected" : ""); ?>>
                                            Pre Discovery 
                                        </option>
                                        <option value="2" <?php echo(sanitize_post_field_value($_POST['szSearch2']) == trim("2") ? "selected" : ""); ?>>
                                           Discovery Meeting
                                        </option>
                                        <option value="3" <?php echo(sanitize_post_field_value($_POST['szSearch2']) == trim("3") ? "selected" : ""); ?>>
                                          In Progress  
                                        </option>
                                        <option value="4" <?php echo(sanitize_post_field_value($_POST['szSearch2']) == trim("4") ? "selected" : ""); ?>>
                                          Non Convertible 
                                        </option>
                                        <option value="5" <?php echo(sanitize_post_field_value($_POST['szSearch2']) == trim("5") ? "selected" : ""); ?>>
                                          Contact Later 
                                        </option>
                                         <option value="6" <?php echo(sanitize_post_field_value($_POST['szSearch2']) == trim("6") ? "selected" : ""); ?>>
                                         Closed Sale
                                        </option>
                                  
                                      </select>
                                  </div>
<!--                                  <div class="search col-md-1"> </div>-->
                                  <div class=" col-md-1">
                           <button class="btn green-meadow" type="submit" ><i class="fa fa-search"></i></button>
                           </div>
                           </form>
                          </div>
                          <?php
                       }
                            ?>
                          <?php
                        if(!empty($prospectDetailsAry))
                        { 
                    
                            ?>
                           
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th> Sr No.</th>
                                        <th>Business Name</th>
                                        <th> Email</th>
                                        <th> Contact No </th>
                                        <th> Status </th>
                                        <th> Status Updated Date/Time </th>
                                        <th> Actions </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if($prospectDetailsAry)
                                    {   $i = 0;
                                        foreach($prospectDetailsAry as $prospectDetailsData)
                                        {
                                        
                                           $i++;
                                        ?>
                                        <tr>
                                            <td> <?php echo ($i+$startRec);?> </td>
                                            <td> <?php echo $prospectDetailsData['szBusinessName']?> </td>
                                            <td><?php if(empty($prospectDetailsData['szEmail'])){echo "N/A";} else {echo $prospectDetailsData['szEmail'];} ?>  </td>
                                            <td><?php if(empty($prospectDetailsData['szContactNumber'])){echo "N/A";} else {echo $prospectDetailsData['szContactNumber'];} ?>  </td>
                                            <td>
                                                                    <?php if ($prospectDetailsData['status'] == 1) { ?>

                                                                        <p title="Order Status"
                                                                           class="label label-sm label-warning">
                                                                            Pre Discovery 
                                                                        </p>
                                                                        <?php
                                                                    }
                                                                    if ($prospectDetailsData['status'] == 2) {
                                                                        ?>
                                                                        <p title="Order Status"
                                                                           class="label label-sm label-primary">
                                                                             Discovery Meeting
                                                                        </p>
                                                                        <?php
                                                                    }
                                                                   
                                                                    if ($prospectDetailsData['status'] == 3) {
                                                                        ?>
                                                                        <p title="Order Status"
                                                                           class="label label-sm label-info">
                                                                             In Progress
                                                                        </p>
                                                                        <?php
                                                                    }
                                                                    if ($prospectDetailsData['status'] == 4) {
                                                                        ?>
                                                                        <p title="Order Status"
                                                                           class="label label-sm label-danger">
                                                                              Non Convertible
                                                                        </p>
                                                                        <?php
                                                                    }
                                                                    if ($prospectDetailsData['status'] == 5) {
                                                                        ?>
                                                                        <p title="Order Status"
                                                                           class="label label-sm label-info">
                                                                             Contact Later 
                                                                        </p>
                                                                        <?php
                                                                    }
                                                                  
                                                                    if ($prospectDetailsData['status'] == 6) {
                                                                        ?>
                                                                        <p title="Order Status"
                                                                           class="label label-sm label-success">
                                                                             Closed Sale
                                                                        </p>
                                                                        <?php
                                                                    }

                                                                    ?></td>
                                                        
                                                     <td>  <?php 
                                                    if(($prospectDetailsData['dt_last_updated_status']) == '0000-00-00 00:00:00'){
                                                      echo "N/A";  
                                                    }
                                                    else{
                                                      echo date('d M Y',strtotime($prospectDetailsData['dt_last_updated_status'])) . ' at '.date('h:i A',strtotime($prospectDetailsData['dt_last_updated_status']));   
                                                    }
                                                     ?> </td>
                                           <td>
                                             <?php     if($_SESSION['drugsafe_user']['iRole']==2){
                                               if (($prospectDetailsData['status']== 1) || ($prospectDetailsData['status']== 2)|| ($prospectDetailsData['status']== 3)|| ($prospectDetailsData['status']== 5)) { ?>
                                                <a class="btn btn-circle btn-icon-only btn-default" id="addMeetingNote" title="Add Meeting Notes" onclick="addMeetingNotesData('<?php echo $prospectDetailsData['id'];?>','1');" href="javascript:void(0);">
                                                    <i class="fa fa-plus" aria-hidden="true"></i>

                                                </a>
                                                <a class="btn btn-circle btn-icon-only btn-default" title="Edit Prospect Data" id="editProspectDetails" onclick="editProspectDetails('<?php echo $prospectDetailsData['id'];?>','1');" href="javascript:void(0);">
                                                    <i class="fa fa-pencil"></i> 
                                                </a>
                                             <?php }} ?>
                                                <a class="btn btn-circle btn-icon-only btn-default" id="prospectsView" title="View Prospect Details" onclick="viewProspect(<?php echo $prospectDetailsData['id'];?>);" href="javascript:void(0);">
                                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                                </a>
                                                 <?php 
                                                  if($_SESSION['drugsafe_user']['iRole']==2){
                                                       if (($prospectDetailsData['status']== 1) || ($prospectDetailsData['status']== 2)|| ($prospectDetailsData['status']== 3)|| ($prospectDetailsData['status']== 5)) { ?>
                                               <?php $prospectDetailsByProspectsIdAry = $this->Prospect_Model->getAllMeetingDetailsByProspectsId($prospectDetailsData['id']);
                                               if(empty($prospectDetailsByProspectsIdAry)) {
                                               ?> 
                                               <a class="btn btn-circle btn-icon-only btn-default" id="ProspectStatus" title="Delete Prospect Record" onclick="prospectDelete(<?php echo $prospectDetailsData['id'];?>);" href="javascript:void(0);">
                                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                                </a>
                                                  <?php  } } }
                                               if ($prospectDetailsData['status'] == 6) {
                                               if($_SESSION['drugsafe_user']['iRole']==2 && $prospectDetailsData['clientcreated']==0){
                                               ?>
                                               <a class="btn btn-circle btn-icon-only btn-default" id="changeToClient" title ="Convert to Client" onclick="changeToClient('<?php echo $prospectDetailsData['id'];?>')" href="javascript:void(0);" >
                                                <i class="fa fa-bars"></i> 
                                                </a>
                                                 <?php
                                               } } 
                                               ?>  
                                            </td>
                                        </tr>
                                        <?php 
                                        }
                                    } ?>
                                </tbody>
                            </table>
                        </div>
                             <?php
                        }
                        else
                        {
                            echo "Not Found";
                        }
                        ?>
                           <?php  if(!empty($prospectDetailsAry)){?>
		     <div class="row">
                  
                    <div class="col-md-7 col-sm-7">
                        <div class="dataTables_paginate paging_bootstrap_full_number">
                            <?php echo $links;?>
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
    </div>
</div>
<div id="popup_box"></div>