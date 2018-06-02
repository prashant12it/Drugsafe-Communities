<script type='text/javascript'>
    $(function() {
       $("#szSearchAgentRecord").customselect();
       $("#szSearchClientname").customselect();
    });
</script>
<div class="page-content-wrapper">
        <div class="page-content">
            <?php if(isset($_SESSION['addagentsucess'])){ ?>
                <div class="alert alert-success">
                    <?php echo $_SESSION['addagentsucess'];
                    unset($_SESSION['addagentsucess']);?>
                </div>
            <?php }?>
             <div id="page_content" class="row">
                <div class="col-md-12">
                    <ul class="page-breadcrumb breadcrumb">
                        <li>
                            <a href="<?php echo __BASE_URL__;?>/franchisee/clientRecord">Home</a>
                            <i class="fa fa-circle"></i>
                        </li>
                         <?php
                        if(!empty($_POST['szSearchAgentRecord'])){
                       
                            $userArray = $this->Admin_Model->getUserDetailsByEmailOrId('',$_POST['szSearchAgentRecord']);?>
                         <li>
                           
                             <a href="<?php echo __BASE_URL__; ?>/franchisee/viewAgentEmpByfranchisee"><?php echo $userArray['szName'];?></a>
                            <i class="fa fa-circle"></i>
                        </li>
                             
                        <?php } ?>
			<li>
                           Agent/Employee Record
                        </li>
                    </ul>
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-equalizer font-red-sunglo"></i>
                                <span class="caption-subject font-red-sunglo bold uppercase"> Agent/Employee Record</span>
                            </div>
                             <?php if($_SESSION['drugsafe_user']['iRole']==2){?>
                            <div class="actions">
                            <div class="btn-group btn-group-devided" data-toggle="buttons">
                                    <button class="btn btn-sm green-meadow" onclick="redirect_url('<?php echo base_url();?>franchisee/addAgentEmployee');">
                                        &nbsp;Add Agent/Employee

                                    </button>
                                </div>
                        </div>
                             <?php }?>
                        </div>
                        <div class="search  row">
                              <form class="search-bar" id="szSearchClientRecord" action="<?php echo base_url();?>franchisee/agentRecord" name="szSearchClientRecord" method="post">
                           <?php if(($_SESSION['drugsafe_user']['iRole']==1)||($_SESSION['drugsafe_user']['iRole']==5)){?>
                                  <div class="search clienttypeselect col-md-3">
                                     <div class="form-group <?php if (!empty($arErrorMessages['szSearchAgentRecord']) != '') { ?>has-error<?php } ?>">                         
                                      <select class="form-control custom-select" name="szSearchAgentRecord" id="szSearchAgentRecord" onfocus="remove_formError(this.id,'true')" onchange="getAgentListByFrId(this.value);">
                                          <option value="">Franchisee Name</option>
                                            <?php
                                         if ($_SESSION['drugsafe_user']['iRole'] == '1') {
                                           $searchOptionArr =$this->Admin_Model->viewFranchiseeList(false,false,false,false,false,false,false,false,1);
                                            }
                                            else{
                                                      $operationManagerId = $_SESSION['drugsafe_user']['id'];
                                                     $searchOptionArr =$this->Admin_Model->viewFranchiseeList(false,$operationManagerId,false,false,false,false,false,false,1);
                                            }
                                            foreach($searchOptionArr as $searchOptionList)
                                                            {
                                                $selected = ($searchOptionList['id'] == $_POST['szSearchAgentRecord'] ? 'selected="selected"' : '');
                                                echo '<option value="'.$searchOptionList['id'].'" ' . $selected . '>'.$searchOptionList['userCode'].'-'.$searchOptionList['szName'].'</option>';
                                            }
                                          ?>
                                      </select>
                                    </div>
                                  </div>
                                      <div class="clienttypeselect col-md-3">
                                        <div id='szAgent'> 
                                            <div class="form-group <?php if (!empty($arErrorMessages['szSearchClRecord']) != '') { ?>has-error<?php } ?>">                         
                                      <select class="form-control custom-select" name="szSearchClRecord" id="szSearchClientname" onfocus="remove_formError(this.id,'true')">
                                          <option value="">Agent/Employee Name</option>
                                          <?php
                                          foreach($agentListArray as $agentList)
                                          {
                                              $selected = ($agentList['szName'] == $_POST['szSearchClRecord'] ? 'selected="selected"' : '');
                                              
                                              echo '<option value="'.$agentList['szName'].'"' . $selected . ' >'.$agentList['szName'].'</option>';
                                          }
                                          ?>
                                      </select>
                                                  </div>
                                            </div>
                                  </div>
                             <?php } else {?>
                                  <div class=" search clienttypeselect col-md-3">
                                        <div id='szAgent'>  
                                       <div class="form-group <?php if (!empty($arErrorMessages['szSearchClRecord']) != '') { ?>has-error<?php } ?>">                            
                                      <select class="form-control custom-select" name="szSearchClRecord" id="szSearchClientname" onfocus="remove_formError(this.id,'true')">
                                          <option value="">Agent/Employee Name</option>
                                          <?php
                                          foreach($agentListArray as $agentList)
                                          {
                                              $selected = ($agentList['szName'] == $_POST['szSearchClRecord'] ? 'selected="selected"' : '');
                                              
                                              echo '<option value="'.$agentList['szName'].'"' . $selected . ' >'.$agentList['szName'].'</option>';
                                          }
                                          ?>
                                      </select>
                                             </div>
                                            </div>
                                  </div>
                                   <?php } ?>
                              
                                  <div class="col-md-1">
                                      <button class="btn green-meadow" type="submit" ><i class="fa fa-search"></i></button>
                                  </div>
                           </form>
                          </div>
                        <?php
                        
                        if(!empty($agentRecordArray))
                        {?>
                       
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th> Id </th>
                                        <th> Agent/Employee Name </th>
                                        <th> Contact Email</th>
                                        <th> Contact Number</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                       $i = 0;
                                     
                                        foreach($agentRecordArray as $agentRecordData)
                                        { 
                                            ?>
                                        <tr>
                                            <td>AG-<?php echo $agentRecordData['id'];?></td>
                                            <td><?php echo $agentRecordData['szName'];?></td>
                                            <td> <?php echo $agentRecordData['szEmail'];?> </td>
                                            <td> <?php echo $agentRecordData['szContactNumber'];?> </td><td>
                                                 <?php
						 if($_SESSION['drugsafe_user']['iRole']==2)
						{?>
                                                <a class="btn btn-circle btn-icon-only btn-default" title="Edit Agent" onclick="editAgentEmployeeDetails('<?php echo $agentRecordData['id']; ?>');" href="javascript:void(0);">
                                                    <i class="fa fa-pencil"></i> 
                                                </a>
                                                <a class="btn btn-circle btn-icon-only btn-default" title="Assign Client" onclick="assignClientAgent('<?php echo $agentRecordData['id']; ?>');" href="javascript:void(0);">
                                                    <i class="fa fa-tasks"></i> 
                                                </a>
                                                <?php
                                                } ?>
                                                 <a class="btn btn-circle btn-icon-only btn-default" title="View Agent Details" onclick="ViewAgentDetails('<?php echo $agentRecordData['id']; ?>','<?php echo $agentRecordData['franchiseeid']; ?>');" href="javascript:void(0);">
                                                        <i class="fa fa-eye-slash"></i> 
                                                 </a>
                                                <?php
                                                 if($_SESSION['drugsafe_user']['iRole']==1)
						{?>
						    <a class="btn btn-circle btn-icon-only btn-default" title="View Assigned Clients" onclick="ViewAssignClient('<?php echo $agentRecordData['id']; ?>','<?php echo $agentRecordData['franchiseeid']; ?>');" href="javascript:void(0);">
                                                        <i class="fa fa-eye"></i> 
                                                    </a>
						<?php
						
                                        } if($_SESSION['drugsafe_user']['iRole']==2){
                                            $agentAssignedClientDetails = $this->Franchisee_Model->getfranchiseeagentclients($agentRecordData['franchiseeid'],$agentRecordData['id']);
                                        if(empty($agentAssignedClientDetails)){
						?>
						    <a class="btn btn-circle btn-icon-only btn-default" title=" Delete Agent" onclick="agentEmployeeDelete('<?php echo $agentRecordData['id']; ?>');" href="javascript:void(0);">
                                                        <i class="fa fa-trash"></i> 
                                                    </a>
						<?php
                                        } ?>
                                        <a class="btn btn-circle btn-icon-only btn-default" title="Change Password" onclick="changeAgentPassword('<?php echo $agentRecordData['id']; ?>');" href="javascript:void(0);">
                                                        <i class="fa fa-key"></i> 
                                                    </a>
                                        
                                       <?php  }
						?>
                                            </td>
                                        </tr>
                                        <?php
                                        $i++;
                                        }
                                   ?>
                                        
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
                     </div>
                </div>
            </div> 
        </div>
    </div>
</div>
<div id="popup_box"></div>