<div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <div class="page-content">
                     <?php 
                    if(!empty($_SESSION['drugsafe_user_message'])){
                        if(trim($_SESSION['drugsafe_user_message']['type']) == "success"){
                        ?>
                            <div class="alert alert-success">
                                <?php echo $_SESSION['drugsafe_user_message']['content'];?>
                            </div>
                        <?php }
                        if(trim($_SESSION['drugsafe_user_message']['type']) == "error") {
                        ?>
                            <div class="alert alert-danger">
                                <?php echo $_SESSION['drugsafe_user_message']['content'];?>
                            </div>
                        <?php }
                        $this->session->unset_userdata('drugsafe_user_message');
                    }
                ?>
                    
                    <!-- BEGIN PAGE HEAD-->
                    <div class="page-head">
                        <!-- BEGIN PAGE TITLE -->
                        <div class="page-title">
                            <h1>Dashboard  
                            </h1>
                        </div>
                        
                    </div>
                 <div class="clearfix">
                    <div class="internal">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="tabbable-line boxless tabbable-reversed">
                                    <div class="form-body">
                                        <div class="alert alert-info">
                                            <strong>Welcome <?php echo $_SESSION['drugsafe_user']['szName'];?> ! </strong>
                                            <br/>
                                            <span>
                                                You are on you way to setting up a profile with Drug Safe.
                                                <br/>
                                                Thank you for joining Drug Safe.
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
                   
                <!-- END CONTENT BODY -->
            </div>
   </div>              