<script type='text/javascript'>
    $(function() {
        $("#szSearchforumTitle").customselect();
    });
</script>
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
                     <?php $categoriesListAray =$this->Forum_Model->viewCategoriesListByCatId($idCategory); 
                   ?>
                     <li>
                        <a href="<?php __BASE_URL__ ?>/forum/categoriesList" ><?php echo $categoriesListAray['szName']; ?></a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <span class="active">Forum List</span>
                    </li>
                </ul>
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-equalizer font-red-sunglo"></i>
                            <span class="caption-subject font-red-sunglo bold uppercase">Forum List</span>
                        </div>
                        <div class="actions">
                                 <a href="<?= __BASE_URL__ ?>/forum/categoriesList" 
                                   class=" btn green-meadow">
                                Back </a>
                            </div>
                        <?php 
                        if($_SESSION['drugsafe_user']['iRole']==1 || $_SESSION['drugsafe_user']['iRole']==5){
                        ?>
<!--                            <div class="actions">
                        <div class="btn-group btn-group-devided" data-toggle="buttons">
                                <button class="btn btn-sm green-meadow" onclick="addForum('',2);" href="javascript:void(0);">
                                    &nbsp;Add Topic
                                </button>
                            </div>
                    </div>-->
                        <?php }?>    

                    </div>
                    <?php
                    if(!empty($forumDataAray))
                    {
                        ?>

                    <div class="row">
                        <form class="search-bar" id="szSearchforumData" action="<?=__BASE_URL__?>/forum/forumList " name="szSearchforumData" method="post">
                            <div class="search col-md-3">
                        <div class="form-group">
                                <select class="form-control custom-select" name="szSearchforumTitle" id="szSearchforumTitle" onfocus="remove_formError(this.id,'true')">
                                    <option value="">Forum Title</option>
                                    <?php
                                    foreach($forumDataSearchAray as $forumDataSearchList)
                                    {
                                        $selected = ($forumDataSearchList['szForumTitle'] == $_POST['szSearchforumTitle'] ? 'selected="selected"' : '');
                                        echo '<option value="'.$forumDataSearchList['szForumTitle'].'" '.$selected.'>'.$forumDataSearchList['szForumTitle'].'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            </div>
                            <div class="col-md-1">
                             <button class="btn green-meadow" type="submit" ><i class="fa fa-search"></i></button>
                            </div>
                        </form>
                    </div>
               
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>

                                    <th style="width:200px"> Forum Title</th>
                                    <th style="width:450px"> Short Description </th>
                                     <th style="width:100px"> Total Topics </th>
                                     <th style="width:150px"> Date Created </th>
                                    <th> Actions </th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                   $i = 0;
                                    foreach($forumDataAray as $forumDataData)
                                    {  
                                    $TotalTopics = count($this->Forum_Model->viewTopicList($forumDataData['id'])); 
                                        ?>
                                    <tr>

                                        <td> <?php echo $forumDataData['szForumTitle']?> </td>
                                        <td> <?php echo $forumDataData['szForumDiscription'];?> </td>
                                        <td> <?php echo $TotalTopics;?> </td>
                                         <td> <?php echo date('d M Y',strtotime($forumDataData['dtCreatedOn'])); ?> </td>

                                            <td>
                                            <a class="btn btn-circle btn-icon-only btn-default" title="Add Topic " onclick="addTopic('<?php echo $forumDataData['id'];?>');" href="javascript:void(0);">
                                                <i class="fa fa-plus"></i> 
                                            </a>
                                                  <?php if($_SESSION['drugsafe_user']['iRole']==1){?>  
                                            <a class="btn btn-circle btn-icon-only btn-default" title="Edit Forum Details" onclick="editForum('<?php echo $forumDataData['id'];?>');" href="javascript:void(0);">
                                                <i class="fa fa-pencil"></i> 
                                            </a>
                                                  <?php }  ?>
                                            <a class="btn btn-circle btn-icon-only btn-default" title="View Forum Details" onclick="viewForum('<?php echo $forumDataData['id'];?>');" href="javascript:void(0);">
                                                <i class="fa fa-eye"></i> 
                                            </a>
                                                  <?php if($_SESSION['drugsafe_user']['iRole']==1){?>  
                                            <a class="btn btn-circle btn-icon-only btn-default" id="ForumStatus" title="Delete Forum Details " onclick="forumDeleteAlert(<?php echo $forumDataData['id'];?>);" href="javascript:void(0);"></i>
                                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                                            </a>
                                                  <?php }?>
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
                    <?php  if(!empty($forumDataAray)){?>
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