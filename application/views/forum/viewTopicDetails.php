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
            <?php
                        
                        if(!empty($forumTopicDataAry))
                        {
                          $franchiseeDetArr1 = $this->Admin_Model->getAdminDetailsByEmailOrId('', $forumTopicDataAry['0']['idUser']);
                          $forumDataArr = $this->Forum_Model->getForumDetailsById($idForum);
                         
                            ?>
            <div id="page_content" class="row">
                <div class="col-md-12">
                    <ul class="page-breadcrumb breadcrumb">
                        <li>
                            <a href="<?php echo __BASE_URL__;?>">Home</a>
                            <i class="fa fa-circle"></i>
                        </li>
                     <?php $categoriesListAray =$this->Forum_Model->viewCategoriesListByCatId($forumDataArr['idCategory']); 
                       ?>
                         <li>
                            <a href="<?php echo __BASE_URL__;?>/forum/categoriesList"><?php echo $categoriesListAray['szName']; ?></a>
                            <i class="fa fa-circle"></i>
                        </li>
                         <li>
                            <a href="<?php echo __BASE_URL__;?>/forum/forumList"><?php echo $forumDataArr['szForumTitle']; ?></a>
                            <i class="fa fa-circle"></i>
                        </li>
                         <li>
                            <a href="<?php echo __BASE_URL__;?>/forum/viewForum"> <?php echo $forumTopicDataAry['0']['szTopicTitle']?></a>
                            <i class="fa fa-circle"></i>
                        </li>
                         <li>
                           Details
                        </li>
                     
                    </ul>
                    <div class="portlet light bordered">

                      
                  <!-- somewhere deep start -->
     <div class="row">
    <div class="center-block col-md-16 Forum">
       
    <h4><i class="icon-equalizer "> </i>  <?php echo $forumDataArr['szForumTitle'];?></h4>
    </div>
  </div>

  <!-- somewhere deep end -->      
                        
                  
                        <div class="table-responsive ">
                            <table class="table table-striped  table-hover ">
                                <thead>
                                    <tr>
                                       <th style="color:#1bbc9b" ><h3> <?php echo $forumTopicDataAry['0']['szTopicTitle']?></h3> </th>
                               
                              
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                       $i = 0;
                                        foreach($forumTopicDataAry as $forumTopicData)
                                        {  
                                         
                                            
                                            ?>
                                        <tr>
                                            
                                            <td> <?php echo $forumTopicData['szTopicDescreption'];?> </td>
                                     
                                        </tr>
                                        <?php
                                        $i++;
                                        }
                                   ?>
                                        
                                </tbody>
                            </table>
                             </div>
                       
  <p><?php echo $franchiseeDetArr1['szName']?></p>
                             <?php
                            
                        }
                        else
                        {
                            echo "";
                        }
                        ?>
   <hr style="border-top: dotted 1px;" />
  <?php   $commentsDataArr = $this->Forum_Model->getAllCommentsByTopicId($forumTopicDataAry['0']['id']); ?>
  <?php if(!empty($commentsDataArr)){?>
       
        <!-- somewhere deep start -->
  <div class="row">
    <div class="center-block col-md-16 Reply">
     <i class="fa fa-comments"></i>  Comments
    </div>
  </div>
  <!-- somewhere deep end -->
  
 
            
<div class="tab-content">

        <!-- TASK COMMENTS -->
        <div class="form-group">
                <div class="col-md-12">
                        <ul class="media-list">
                                
                                 <?php
                          
                   $i = 0;
                    foreach($commentsDataArr as $commentsData)
                    {
                     
                    $splitTime = explode(" ",$commentsData['cmntDate']);
                    $Cmntdate = $splitTime[0];
                    $time = $splitTime[1];
                      $Cmnttime=  date("g:i a", strtotime($time));
                     $NewdateComment= explode('-', $Cmntdate);
                     $CnmtmonthNum  = $NewdateComment['1'];
                     $dateObj   = DateTime::createFromFormat('!m', $CnmtmonthNum);
                     $CmntmonthName = $dateObj->format('M');
                        
              $franchiseeDetArr1 = $this->Admin_Model->getAdminDetailsByEmailOrId('',$commentsData['idCmnters']);
              $szImage = __BASE_IMAGES_URL__."/default_profile_image.jpg";
                        ?>
                        <li class="media">
                                        <a class="pull-left" href="javascript:;">
<!--                                            <a href="viewForum.php"></a>-->
                                        <img class="todo-userpic"  src="<?php echo $szImage;?>" width="27px" height="27px">
                                        </a>
                                        <div class="media-body todo-comment">
                                            <?php if( $forumTopicDataAry['0']['isClosed']==0){?>
                                             <div class="dropdown">
                                                <button class="todo-comment-btn btn btn-circle btn-default btn-xs dropdown-toggle" type="button" data-toggle="dropdown">Action
                                                <span class="caret"></span></button>
                                                <ul class="dropdown-menu">
                                                  <li><a onclick="replyToCmntsAlert(<?php echo $commentsData['id'];?>);" href="javascript:void(0);">&nbsp; Reply &nbsp;</a></li>
                                                   <?php if($commentsData['idCmnters']==$_SESSION['drugsafe_user']['id'] ){ ?>
                                                  <li><a onclick="commentEditAlert(<?php echo $commentsData['id'];?>);" href="javascript:void(0);">&nbsp; Edit &nbsp;</a></li>
                                                  <li><a onclick="cmntDelete(<?php echo $commentsData['id'];?>);" href="javascript:void(0);">&nbsp; Delete &nbsp;</a></li>
                                                   <?php }
                                                      if($_SESSION['drugsafe_user']['id']==1 && $commentsData['idCmnters']!=1 ){   ?>
                                                   
                                                   <li><a onclick="cmntDelete(<?php echo $commentsData['id'];?>);" href="javascript:void(0);">&nbsp; Delete &nbsp;</a></li>
                                                     <?php }?>
                                                </ul>
                                              </div> 
                                            <?php }?>
                                            
                                                <p class="todo-comment-head">
                                                  
                                                        <span class="todo-comment-username"><?php echo $franchiseeDetArr1['szName']?></span> &nbsp; <span class="todo-comment-date"><?php echo $NewdateComment['2'];?> <?php echo $CmntmonthName;?>  <?php  echo $NewdateComment['0'];?> at <?php echo $Cmnttime;?></span>
                                                </p>
                                                <p class="todo-text-color">
                                                         <?php echo $commentsData['szCmnt'] ?> <br>
                                                </p>
                                                 <!-- Nested media object -->
                                                   <?php
                                                    $replyDataArr = $this->Forum_Model->getAllReplyByCmntsId($commentsData['id']); 
                                                          $i = 0;
                                                         foreach($replyDataArr as $replyData)
                                                          { 
                                                            
                                                             $splitTimeStamp = explode(" ",$replyData['dtReplyOn']);
                                                             $date1 = $splitTimeStamp[0];
                                                             $time1 = $splitTimeStamp[1];
                                                           
                                                           $x=  date("g:i a", strtotime($time1));
                                                     
                                                          $date= explode('-', $date1);
                                                        
                                                          
                                                          $monthNum  = $date['1'];
                                                         
                                                          $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                                                          $monthName = $dateObj->format('M'); 
                                                         
                                                            $franchiseeDetArr1 = $this->Admin_Model->getAdminDetailsByEmailOrId('',$replyData['idReplier']);
                                                           ?>
                                                 <div class="media replyoncomment">
                                                       
                                                        <div class="media-body">
                                                            
                                                               <div class="row">
                                                                   <div class="col-md-1"></div>
                                                                    <div class="col-md-4 todo-comment-head">
                                                                    <span class="todo-comment-username"><b style="color: #1bbc9b"><?php echo $franchiseeDetArr1['szName']?></b> </span> &nbsp; <span class="todo-comment-date"><?php echo $date['2'];?> <?php echo $monthName;?>  <?php  echo $date['0'];?> at <?php echo $x;?></span>
<!--                                                              <button class="todo-comment-btn btn btn-circle btn-default btn-xs dropdown-toggle" type="button" data-toggle="dropdown">Action
                                                              <span class="caret"></span></button>-->
                                                                 </div>  
                                                                     <?php if( $forumTopicDataAry['0']['isClosed']==0){?>
                                                              <?php if($replyData['idReplier']==$_SESSION['drugsafe_user']['id'] || $_SESSION['drugsafe_user']['id']==1){ ?>  
                                                            <div class="dropdown col-md-3">
                                                              <button class="todo-comment-btn btn btn-circle btn-default btn-xs dropdown-toggle" type="button" data-toggle="dropdown">Action
                                                                <span class="caret"></span></button>
                                                                <ul class="dropdown-menu">
                                                           <?php if($replyData['idReplier']==$_SESSION['drugsafe_user']['id'] ){ ?>   
                                                            <li><a onclick="replyEditAlert(<?php echo $replyData['id'];?>);" href="javascript:void(0);">&nbsp; Edit &nbsp;</a></li>
                                                            <li><a onclick="replyDelete(<?php echo $replyData['id'];?>);" href="javascript:void(0);">&nbsp; Delete &nbsp;</a></li>
                                                             <?php }
                                                               if($_SESSION['drugsafe_user']['id']==1 && $replyData['idReplier']!=1 ){   ?>
                                                             <li><a onclick="replyDelete(<?php echo $replyData['id'];?>);" href="javascript:void(0);">&nbsp; Delete &nbsp;</a></li>
                                                               <?php }?>
                                                                </ul>
                                                        </div> 
                                                                   
                                                             <?php }?>      
                                                                     <?php }?>
                                                               
                                                                   </div>
                                                             <div class="row">
                                                                <div class="col-md-1"></div>
                                                                <div class="col-md-9">
                                                                <p class="todo-text-color">
                                                                        <?php echo $replyData['szReply'] ?>
                                                                </p>
                                                                </div>
                                                                </div>
                                                        </div>
                                                </div>
                                                          <?php }?>
                                        </div>
                                </li>
                             <hr>   
                                  <?php
                    $i++;
                    }
               ?>
                               
                        </ul>
                </div>
        </div>
        <!-- END TASK COMMENTS -->
      
</div>
   <?php } else {
    echo "";
 } ?>

   <div class="row reply-editor">
    <form class="form-horizontal" id="replyData" action="<?=__BASE_URL__?>/forum/viewTopicDetails " name="replyData" method="post">
   <div class="form-group <?php if(form_error('replyData[szForumLongDiscription]')){?>has-error<?php }?>">
   
    <?php if( $forumTopicDataAry['0']['isClosed']==0){?>
    <div class="col-md-12">
      <div class="input-group">

<textarea  name="replyData[szForumLongDiscription]" id="szForumLongDiscription" class="form-control"  value=""  rows="5" placeholder="Long Description" onfocus="remove_formError(this.id,'true')" ><?php echo set_value('replyData[szForumLongDiscription]'); ?></textarea>

</div> 
          <?php
if(form_error('replyData[szForumLongDiscription]')){?>
<span class="help-block pull-left"><span><?php echo form_error('replyData[szForumLongDiscription]');?></span>
</span><?php }?>

      </div>

  </div>
        <div class="col-md-1">
   <input type="submit" class="btn green-meadow" value="SAVE" name="replyData[submit]">
        </div>
         <?php }?>
    </form>
   </div>
   
                </div>
            </div>
        </div> 
    </div>
</div>
<script>
CKEDITOR.replace( 'szForumLongDiscription' );
</script>
</div>
<div id="popup_box"></div>