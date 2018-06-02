
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
                    <li>
                         <a href="<?php echo __BASE_URL__; ?>">Home</a>
                        <i class="fa fa-circle"></i>
                    </li>
                   
                        <li>
                            <span class="active">Select Franchisee</span>
                        </li>
                   
                </ul>
                <div class="portlet light bordered">
                      <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-equalizer font-green-meadow"></i>
                            <span class="caption-subject font-green-meadow ">Plese select a Franchisee to display their related clients.</span>
                        </div>
                      </div>
                      <div class="row">
                              <form class="form-horizontal" id="szSearchClientRecord" action="<?=__BASE_URL__?>/formManagement/viewForm" name="szSearchClientRecord" method="post">
                                  <div class="search col-md-3">
                                      <select class="form-control custom-select" name="szSearchFrRecord" id="szSearchname" onfocus="remove_formError(this.id,'true')">
                                          <option value="">Franchisee Name</option>
                                          <?php
                                            
                                            foreach($searchOptionArr as $searchOptionList)
                                            {
                                                $selected = ($searchOptionList['id'] == $_POST['szSearchFrRecord'] ? 'selected="selected"' : '');
                                                echo '<option value="'.$searchOptionList['id'].'"' . $selected . ' >'.$searchOptionList['szName'].'</option>';
                                            }
                                          ?>
                                      </select>
                                  </div>

                                  <div class="col-md-1">
                                      <button class="btn green-meadow" type="submit" ><i class="fa fa-search"></i></button>
                                  </div>
                             
                           </form>
                          </div>
                        <div class="row">  
                            <?php echo $notfound;?>
                        </div>
                        
                     
 
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<div id="popup_box"></div>                   
                  