
<script type='text/javascript'>
    $(function() {

        $("#szSearchname").customselect();

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
             
               
                
              <?php 
              
                $idFr = $this->session->userdata('szSearchFrRecord');
                $userDataAry = $this->Admin_Model->getUserDetailsByEmailOrId('',$idFr);
              
               
             ?>   
            <div class="col-md-12">
                 <ul class="page-breadcrumb breadcrumb">
                   <li>
                          <a href="<?php echo __BASE_URL__; ?>">Home</a>
                        <i class="fa fa-circle"></i>
                    </li>
                      <li>
                            <a onclick=""
                               href="javascript:void(0);"><?php echo $userDataAry['szName']; ?></a>
                            <i class="fa fa-circle"></i>
                        </li>
                        
                   <?php  if (empty($sosRormDetailsAry)) {
                   $idCl = $this->session->userdata('szSearchClRecord');
                $clientDataAry = $this->Admin_Model->getUserDetailsByEmailOrId('',$idCl);
                        ?>
                         <li>
                             <a onclick=""
                               href="javascript:void(0);"><?php echo $franchiseeDataAry['szName']; ?></a>
                            <i class="fa fa-circle"></i>
                        </li>
                        <li>
                            <span class="active">Select Site</span>
                        </li>
                   <?php } else {
                        $idCl = $this->session->userdata('szSearchClRecord');
                        $clientDataAry = $this->Admin_Model->getUserDetailsByEmailOrId('',$idCl);
                $idCl2 = $this->session->userdata('szSearchClRecord2');
                $siteDataAry = $this->Admin_Model->getUserDetailsByEmailOrId('',$_POST['szSearchClRecord2']);
                        ?>
                          <li>
                             <a onclick=""
                               href="javascript:void(0);"><?php echo $clientDataAry['szName']; ?></a>
                            <i class="fa fa-circle"></i>
                        </li>
                          <li>
                             <a onclick=""
                               href="javascript:void(0);"><?php echo $siteDataAry['szName']; ?></a>
                            <i class="fa fa-circle"></i>
                        </li>
                         
                    <li>
                            <span class="active">Test Details</span>
                        </li>
                         <?php } 

                        ?>
                </ul>
                <div class="portlet light bordered">
                   <?php  if (empty($sosRormDetailsAry)) {

                        ?>
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-equalizer font-green-meadow"></i>
                           
                            <span class="caption-subject font-green-meadow ">Plese select <?php echo $franchiseeDataAry['szName'] ?>'s site to display their related  form data.</span>
                        </div>
                      </div>
                    <div class="row">
                              <form class="form-horizontal" id="szSearchClientRecord" action="<?=__BASE_URL__?>/formManagement/viewForm" name="szSearchClientRecord" method="post">

                                  <div class="search col-md-3">
                                      <select class="form-control custom-select" name="szSearchClRecord2" id="szSearchname" onfocus="remove_formError(this.id,'true')">
                                          <option value="">Site Name</option>
                                          <?php
                                         foreach($childClientDetailsAray as $childClientDetailsList)
                                          {
                                              $selected = ($childClientDetailsList['id'] == $_POST['szSearchClRecord2'] ? 'selected="selected"' : '');
                                              echo '<option value="'.$childClientDetailsList['id'].'" ' . $selected . '>'.$childClientDetailsList['szName'].'</option>';
                                          }
                                          ?>
                                      </select>
                                  </div>
                               
                                  <div class="col-md-1">
                                      <button class="btn green-meadow" type="submit" ><i class="fa fa-search"></i></button>
                                  </div>
                                    <?php 
                                   
                                  
                                   ?>
                                   <input type="hidden" name="clientId[clientId]" id="idFr" value="<?php echo $parentClientId ;?>"/> 
                                   <input type="hidden" name="iflag[flag]" id="flag" value="3"/> 
                           </form>
                          </div>
                   <?php }?>
                      <?php  if($data['value']==2){?>
                 
              <div class="row">  
                <h4> Not Found</h4>
                  </div>
                   <?php } else{?> 
                  <?php
                  if(!empty($_POST['szSearchClRecord2'])){
                    if (!empty($sosRormDetailsAry)) {

                        ?>
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-equalizer font-red-sunglo"></i>
                            <span class="caption-subject font-red-sunglo bold uppercase">Test Record</span>
                        </div>
                        </div>
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>Test Date</th>
                                    <th>ServiceCommencedOn</th>
                                    <th>ServiceConcludedOn</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $i = 0;
                                foreach ($sosRormDetailsAry as $sosRormDetailsData) {
                                    ?>
                                    <tr>
                                       
                                        <td> <?php echo $sosRormDetailsData['testdate']; ?> </td>
                                        <td> <?php echo $sosRormDetailsData['ServiceCommencedOn'] ?> </td>
                                        <td> <?php echo $sosRormDetailsData['ServiceConcludedOn']; ?> </td>
                                        <td> 
                                        <a class="btn btn-circle btn-icon-only btn-default" id="userStatus"
                                               title="View SoS Form Details"
                                               onclick="viewSosFormDetails(<?php echo $sosRormDetailsData['Clientid']; ?>,<?php echo $sosRormDetailsData['id']; ?>);"
                                               href="javascript:void(0);"></i>
                                                <i class="fa fa-eye" aria-hidden="true"></i>
                                        </a>
                                       </td>
                                    </tr>
                                    <?php
                                     $i++;
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                         </div>
                        <?php

                    } else {
                        echo "Not Found";
             }
                   }}
                    ?>
         <?php  if(!empty($clientAry)){?>
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