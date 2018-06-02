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
                        <?php $categoriesListAray =$this->Forum_Model->viewCategoriesListByCatId($forumDetailsAry['0']['idCategory']); 
                       ?>
                         <li>
                            <a href="<?php echo __BASE_URL__;?>/forum/categoriesList"><?php echo $categoriesListAray['szName']; ?></a>
                            <i class="fa fa-circle"></i>
                        </li>
                         <li>
                            <a href="<?php echo __BASE_URL__;?>/forum/forumList"><?php echo $forumDetailsAry['0']['szForumTitle']; ?></a>
                            <i class="fa fa-circle"></i>
                        </li>
                         <li>
                           Details   
                        </li>
                     
                    </ul>
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption">
                               <i class="icon-equalizer font-red-sunglo"></i>
                                <span class="caption-subject font-red-sunglo bold uppercase"><?php echo $forumDetailsAry['0']['szForumTitle']?></span>
                            </div>
                           
                        </div>
                        <?php
                        
                        if(!empty($forumDetailsAry))
                        {
                            ?>
                        
                        
                   
                        <div class="table-responsive ">
                            <table class="table table-striped  table-hover ">
                                <thead>
                                   
                                </thead>
                                <tbody>
                                    <?php
                                       $i = 0;
                                        foreach($forumDetailsAry as $forumDetailsData)
                                        {  
                                       
                                          
                                            ?>
                                        <tr>
                                            <td>
                                                <?php if(!empty( $forumDetailsData['szforumImage'])){?>
                                                <img class="file_preview_image" src="<?php echo __BASE_USER_PRODUCT_IMAGES_URL__; ?>/<?php echo $forumDetailsData['szforumImage']; ?>" width="60" height="60"/>    
                                                <?php } else{?>
                                                 <img class="file_preview_image" src="<?php echo __BASE_URL__; ?>/images/no-image-available.png" width="60" height="60"/>    
                                                <?php }?> 
                                            </td>
                                         
                                            <td> <?php echo $forumDetailsData['szForumLongDiscription'];?> </td>
                                     
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
                            echo "";
                        }
                        ?>
          <hr>
           <?php
                        
                        if(!empty($forumTopicDataAry))
                        {
                            ?>
                        
                        
                  
                        <div class="table-responsive ">
                            <table class="table table-striped  table-hover ">
                                <thead>
                                    <tr>
                                        <th style="width: 300px">Topic</th>
                                         <th style="width: 100px"> Date Created </th>
                                          <th style="width: 100px">Created By</th>
                                        <th style="width: 100px">Status </th>
                                        <th style="width: 100px">Comments </th>
                                        <th style="width: 100px">Action</th>
                              
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                       $i = 0;
                                        foreach($forumTopicDataAry as $forumTopicData)
                                        {  
                                           
                                        $commentsDataArr = count($this->Forum_Model->getAllCommentsByTopicId($forumTopicData['id'])); 
                                              $createdByDetArr = $this->Admin_Model->getAdminDetailsByEmailOrId('', $forumTopicData['idUser']);   
                                            ?>
                                        <tr>
                                              <td> <?php echo $forumTopicData['szTopicTitle'];?> </td> 
                                              <td> <?php echo date('d M Y',strtotime($forumTopicData['dtCreatedOn'])); ?> </td>
                                              <td> <?php echo $createdByDetArr['szName'];?> </td>
                                            <?php if($forumTopicData['isClosed']==1)
                                            {?>
                                                  <td style="color: #e73d4a">Closed</td> 
                                       <?php      }
                                            else{ ?>
                                             <td style="color: #1bbc9b">Open</td>  
                                                   
                                            <?php         }
                                                
                                                
                                                ?>
                                          
                                            <td> <?php echo $commentsDataArr;?> </td>
                                            <td> <a class="btn btn-circle btn-icon-only btn-default" title="View Topic Details" onclick="viewTopicDetails('<?php echo $forumTopicData['id'];?>','<?php echo $forumTopicData['idForum'];?>');" href="javascript:void(0);">
                                                    <i class="fa fa-eye"></i> 
                                             </a>
                                            <?php if($forumTopicData['isClosed']==0   ){ 
                                                if($forumTopicData['idUser']==$_SESSION['drugsafe_user']['id'] || $_SESSION['drugsafe_user']['id']==1)
                                                {
                                                ?>
                                            <a class="btn btn-circle btn-icon-only btn-default" title=" Topic Close" onclick="closeTopic('<?php echo $forumTopicData['id'];?>');" href="javascript:void(0);">
                                                    <i class="fa fa-times-circle"></i> 
                                             </a>
                                            <?php 
                                                }
                                                }
                                                if($forumTopicData['idUser']==$_SESSION['drugsafe_user']['id'] || $_SESSION['drugsafe_user']['id']==1)
                                                {
                                                ?>
                                                <a class="btn btn-circle btn-icon-only btn-default" title="Delete Topic Details" onclick="deleteTopicDetails('<?php echo $forumTopicData['id'];?>');" href="javascript:void(0);">
                                                    <i class="fa fa-trash"></i> 
                                             </a>
                                                 <?php 
                                                } ?>
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
                            echo "";
                        }
                        ?>
            <?php  if(!empty($forumTopicDataAry)){?>
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