
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
                            <a href="<?php echo __BASE_URL__;?>">Home</a>
                            <i class="fa fa-circle"></i>
                        </li>
                        <li>
                            <span class="active">Donor List</span>
                        </li>
                    </ul>
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-equalizer font-red-sunglo"></i>
                                <span class="caption-subject font-red-sunglo bold uppercase">Donor List</span>
                            </div>
                           
                        </div>
                     
                        <?php
                        if(!empty($DonorDetailsAry))
                        {
                            ?>
                         <div class="row">
                              <form class="form-horizontal" id="szSearchField" action="<?=__BASE_URL__?>/formManagement/ViewDonorDetails" name="szSearchField" method="post">
<!--                          <div class="search col-md-2">
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
                                  <div class="search col-md-2">
                                      <!--                            <input type="text" name="szSearch" id="szSearch" class="form-control input-square-right " placeholder="Id Or Name Or Email" value="--><?/*//=sanitize_post_field_value($_POST['szSearch'])*/?><!--">-->
                                      <select class="form-control custom-select" name="szSearch2" id="szSearchname" onfocus="remove_formError(this.id,'true')">
                                          <option value="">Franchisee Name</option>
                                          <?php
                                          foreach($allfranchisee as $franchiseeIdList)
                                          {
                                              $selected = ($franchiseeIdList['id'] == $_POST['szSearch2'] ? 'selected="selected"' : '');
                                              echo '<option value="'.$franchiseeIdList['id'].'"' . $selected . ' >'.$franchiseeIdList['szName'].'</option>';
                                          }
                                          ?>
                                      </select>
                                  </div>
<!--                                  <?php if($_SESSION['drugsafe_user']['iRole']==1){?> 
                                  <div class="col-md-1" style="text-align: center; padding: 5px 0px;">OR</div>
                           <!--<button class="btn green-meadow" type="submit" ><i class="fa fa-search"></i></button>
                                  <div class="search col-md-2">
                                                                  <input type="text" name="szSearch" id="szSearch" class="form-control input-square-right " placeholder="Id Or Name Or Email" value="<?/*//=sanitize_post_field_value($_POST['szSearch'])*/?>">
                                      <select class="form-control custom-select" name="szSearch3" id="szSearchOperationmanager" onfocus="remove_formError(this.id,'true')">
                                          <option value="">Operation Manager</option>
                                          <?php
                                          foreach($allfranchisee as $franchiseeIdList)
                                          {  
                                              $operationManagerDetArr = $this->Admin_Model->getAdminDetailsByEmailOrId('', $franchiseeIdList['operationManagerId']);
                                         
                                              $selected = ($franchiseeIdList['id'] == $_POST['szSearch3'] ? 'selected="selected"' : '');
                                              echo '<option value="'.$franchiseeIdList['id'].'" >'.$operationManagerDetArr['szName'].'</option>';
                                         
                                          }
                                          ?>
                                      </select>
                                  </div>
                                  <?php }?>
                               <div class="col-md-1" style="text-align: center; padding: 5px 0px;">OR</div>
                                  <div class="search col-md-2">
                                                                  <input type="text" name="szSearch" id="szSearch" class="form-control input-square-right " placeholder="Id Or Name Or Email" value="<?//=sanitize_post_field_value($_POST['szSearch'])?>">
                                      <select class="form-control custom-select" name="szSearch" id="szSearchemail" onfocus="remove_formError(this.id,'true')">
                                          <option value="">Franchisee Email</option>
                                          <?php
                                          foreach($allfranchisee as $franchiseeIdList)
                                          {
                                              $selected = ($franchiseeIdList['id'] == $_POST['szSearch'] ? 'selected="selected"' : '');
                                              echo '<option value="'.$franchiseeIdList['id'].'" >'.$franchiseeIdList['szEmail'].'</option>';
                                          }
                                          ?>
                                      </select>
                                  </div>-->
                                  <div class="col-md-1">
                                  <button class="btn green-meadow" type="submit" ><i class="fa fa-search"></i></button>
                                  </div>
                           </form>
                          </div>
                             <div class="row">
                             <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th> Id.</th>
                                        <th> Donor Name</th>
                                        <th> Actions </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if($DonorDetailsAry)
                                    {   $i = 0;
                                        foreach($DonorDetailsAry as $DonorDetailsData)
                                        {
                                           
                                        ?>
                                        <tr>
                                            <td> Dnr-<?php echo $DonorDetailsData['id'];?> </td>
                                            <td> <?php echo $DonorDetailsData['donerName']?> </td>
                                           
                                          <td>
                                             <a class="btn btn-circle btn-icon-only btn-default" id="viewCoc" title="View COC Form Details " onclick="viewCocForm(<?php echo $DonorDetailsData['cocid'];?>,<?php echo $idsos;?>);" href="javascript:void(0);"></i>
                                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                                </a>
                                               
                                                
                                            </td>
                                        </tr>
                                        <?php 
                                        
                                        }
                                         $i++;
                                    } ?>
                                </tbody>
                            </table>
                        </div>
                                 </div>
                             <?php
                            
                        }
                        else
                        {
                            echo "Not Found";
                        }
                        ?>
                           <?php  if(!empty($DonorDetailsAry)){?>
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
    </div>
</div>
<div id="popup_box"></div>