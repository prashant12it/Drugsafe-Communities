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
                       
                        <li>
                            <span class="active">Topic List</span>
                        </li>
                    </ul>
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-equalizer font-red-sunglo"></i>
                                <span class="caption-subject font-red-sunglo bold uppercase">Topic List</span>
                            </div>
                            <?php 
                            if($_SESSION['drugsafe_user']['iRole']==1 || $_SESSION['drugsafe_user']['iRole']==5){
                            ?>
                        
                            <?php }?>    
                           
                        </div>
                        <?php
                        
                        if(!empty($topicDataArr))
                        {
                            
                      
                            ?>
                        
               
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                       
                                        <th style="width: 180px">Topic Title</th>
                                        <th style="width: 220px">Topic Description</th>
                                       <th style="width: 80px"> Actions </th>
                                       
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    <?php
                                    if(!empty($topicDataArr)){
                                     $i = 0;
                                       foreach($topicDataArr as $topicData)
                                        { 
                                    
                                        ?>
                                        <tr>
                                          
                                              <td> <?php echo $topicData['szTopicTitle']?> </td>
                                              <?php

                                              $retval = $topicData['szTopicDescreption'];
                                              $string = preg_replace('/(?<=\S,)(?=\S)/', ' ', $topicData['szTopicDescreption']);
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
                                                  $retval .= '<a onclick="showTopic('.$topicData['id'].');" href="javascript:void(0);" >Read more</a>';
                                              }
                                               ?>
                                            
                                              
                                              <td><?php echo $retval;  ?></td>
                                         
                                                <td>
                                                <a class="btn btn-circle btn-icon-only btn-default" title="Approve" onclick="approveTopic('<?php echo $topicData['id'];?>');" href="javascript:void(0);">
                                                    <i class="fa fa-check"></i> 
                                                </a>
                                                <a class="btn btn-circle btn-icon-only btn-default" id="ForumStatus" title="Unapprove" onclick="unapproveTopic(<?php echo $topicData['id'];?>);" href="javascript:void(0);"></i>
                                                    <i class="fa fa-times" aria-hidden="true"></i>
                                                </a>
                                                </td>
                                      
                                        </tr>
                                        <?php
                                        $i++;
                                        }   
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