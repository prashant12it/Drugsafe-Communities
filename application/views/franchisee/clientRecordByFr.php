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
            <div class="col-md-12">
                  <ul class="page-breadcrumb breadcrumb">
                       <ul class="page-breadcrumb breadcrumb">
                      <?php if($_SESSION['drugsafe_user']['iRole'] == '5'){ ?>
                        <li>
                            <a href="<?php echo __BASE_URL__;?>/admin/franchiseeList">Home</a>
                            <i class="fa fa-circle"></i>
                        </li>
                      <?php } else{?>
                         <li>
                            <a href="<?php echo __BASE_URL__;?>/admin/operationManagerList">Home</a>
                            <i class="fa fa-circle"></i>
                        </li>
                      <?php }?>
                        <li>
                            <span class="active">Franchisee List</span>
                        </li>
                    </ul>
                   
                </ul>
                <div class="portlet light bordered">
                      <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-equalizer font-green-meadow"></i>
                            <span class="caption-subject font-green-meadow ">Plese select a Franchisee to display their related clients.</span>
                        </div>
                      </div>
                      <div class="row ">
                             <form class="search-bar" id="szSearchClientRecord" action="<?=__BASE_URL__?>/franchisee/franchiseeClientRecord" name="szSearchClientRecord" method="post">
                                  <div class="col-md-3 ">
                                     <div class="form-group <?php if (!empty($arErrorMessages['szSearchFrRecord']) != '') { ?>has-error<?php } ?>">
                                      <select class="form-control custom-select" name="szSearchFrRecord" id="szSearchname" onfocus="remove_formError(this.id,'true')">
                                          <option value="">Franchisee Name</option>
                                          <?php
                                           if ($_SESSION['drugsafe_user']['iRole'] == '1') {
                                            $searchOptionArr =$this->Admin_Model->viewFranchiseeList();
                                            
                                            }
                                            else{
                                                    $operationManagerId = $_SESSION['drugsafe_user']['id'];
                                                     $searchOptionArr =$this->Admin_Model->viewFranchiseeList(false,$operationManagerId);
                                                     
                                            }
                                            foreach($searchOptionArr as $searchOptionList)
                                                            {
                                                $selected = ($searchOptionList['id'] == $_POST['szSearchFrRecord'] ? 'selected="selected"' : '');
                                                echo '<option value="'.$searchOptionList['id'].'" ' . $selected . '>'.$searchOptionList['userCode'].'-'.$searchOptionList['szName'].'</option>';
                                            }
                                          ?>
                                      </select>
                                          </div>
                                  </div>

                                  <div class="col-md-1 search">
                                      <button class="btn green-meadow" type="submit" ><i class="fa fa-search"></i></button>
                                  </div>
                             
                           </form>
                          </div>
                    
                        <div class="row search_align">
                            
                            <?php if(!empty($_POST['szSearchFrRecord'])){
                                    if(empty($clientAray)){echo "Not Found";}}?>
                        </div>
           
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<div id="popup_box"></div>  