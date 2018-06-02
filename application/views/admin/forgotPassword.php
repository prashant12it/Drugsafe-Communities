<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="content forgotpassword">
        <div class="logo">
            <a href="<?php echo __BASE_URL__;?>">
                <!--               <h1 class="site-title">Drug Safe</h1>-->
                <img src="<?php echo __BASE_URL__;?>/images/logo.png" />
            </a>
        </div>
         <!-- BEGIN FORGOT PASSWORD FORM -->
             <form class="login-form" id="forgotPassword" name="forgotPassword" method="post" autocomplete="off" action="<?php echo __BASE_URL__;?>/admin/admin_forgotPassword">
                <div class="form-title">
                    <span class="form-title">Forgot Password ?</span>
                    <span class="form-subtitle">Enter your e-mail to reset it.</span>
                </div>
                <div class="form-group">
                    <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Email"  id="drugSafeForgotPassword" name="drugSafeForgotPassword[szEmail]" onfocus="remove_formError(this.id,'true')"  value="<?php echo $_POST['drugSafeForgotPassword']['szEmail'];?>" >
                    <?php if(!empty($arErrorMessages['szEmail']) != ''){?>
                        <span class="help-block pull-left">
                                                                    <i class="fa fa-times-circle"></i>
                            <?php echo $arErrorMessages['szEmail'];?>
                                                                </span>
                    <?php }?>
                </div>
                <div class="form-actions">
                    
                    <a href="<?=__BASE_URL__?>/admin/admin_login" class="btn btn-default btn-cancel" type="button">Cancel</a>
                    <button type="submit" class="btn red btn-form-submit btn-success">Submit</button>
                </div>
            </form>
         <!-- END FORGOT PASSWORD FORM -->
</div>