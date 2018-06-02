<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="content">
    <!-- BEGIN LOGIN FORM -->
    <form class="login-form" id="recoverPasswordForm" action="<?php echo __BASE_URL__;?>/admin/adminPassword_Recover/<?php echo $passwordKey;?>" name="recoverPasswordForm" method="post">
        <h3 class="form-title font-green">Password Recovery</h3>

        <div class="form-group <?php if(trim($arErrorMessages['szPassword']) != ''){?>has-error<?php }?>">
               <input type="password" name="recoverAdminData[szPassword]" id="szPassword" class="form-control input-square-right required min-length" placeholder="New Password" value="<?php echo $_POST['recoverAdminData']['szPassword'];?>">
            <?php if(trim($arErrorMessages['szPassword']) != ''){?>
                <span class="help-block pull-left">
                    <i class="fa fa-times-circle"></i>
                    <?php echo $arErrorMessages['szPassword'];?>
                </span>
            <?php }?>
        </div>
        <div class="form-group <?php if(trim($arErrorMessages['szConfirmPassword']) != ''){?>has-error<?php }?>">
               <input type="password" name="recoverAdminData[szConfirmPassword]" id="szConfirmPassword" class="form-control input-square-right required re-match min-length" placeholder="Confirm Password" value="<?php echo $_POST['recoverAdminData']['szConfirmPassword'];?>">
                <input type="hidden" name="recoverAdminData[passwordKey]" id="passwordKey" value="<?php echo $passwordKey;?>">
        </div>

        <div class="form-actions">
            
             <input type="submit" class="btn red btn-block uppercase" value="SAVE"
                                               name="recoverAdminData[submit]">
        </div>

        <div class="create-account">
            <p>
               <a tabindex="28" data-swap="wrapper-signup" href="<?php echo __BASE_URL__;?>/admin/admin_login" class="swap track-Auth-Login-ClickGetFree">Already have your password?</a>
            </p>
        </div>
    </form>
    <!-- END LOGIN FORM -->
</div>