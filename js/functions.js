function redirect_url(page_url)
{	
	if(page_url!='')
        {
             window.location=page_url;
        }
        else
        {
                return false ;
        }
}


function ajaxKeyUpLogin(selector,event)
{
    if(event.keyCode=='13')
    {
        userLogin();
    }
}

function userLogin()
{
    $("#loginUser").submit();
}

function remove_formError(fieldId,addOnFlag)
{
//    alert(fieldId);
    if(addOnFlag == 'true')
    {
        $("#"+fieldId).parent('div').parent('div').parent('div').removeClass('has-error');
    }
    else
    {
        $("#"+fieldId).parent('div').parent('div').removeClass('has-error');
    
    }
    $("#"+fieldId).parent('div').parent('div').children('.help-block').addClass('hide');
    $("#"+fieldId).parent('div').children('.help-block').addClass('hide');
}

function remove_formFieldError(fieldId)
{
//    alert(fieldId);
    $("#"+fieldId).parent('div').removeClass('has-error');
    $("#"+fieldId).parent('div').children('.help-block').addClass('hide');
}
function remove_typeaheadError(fieldId)
{
//    alert($("#"+fieldId).parent('span').parent('div').parent('div').attr('class'));
    $("#"+fieldId).parent('span').parent('div').parent('div').parent('div').removeClass('has-error');
    $("#"+fieldId).parent('span').parent('div').parent('div').children('.help-block').addClass('hide');
}

function open_forgot_password_form()
{
    $(".forget-form").show();
    
    $(".login-form").hide();
}

function open_login_form()
{
    $(".forget-form").hide();
    
    $(".login-form").show();
}

function forgot_password()
{
    var szForgotEmail=$("#szForgotEmail").val();
    
    if(szForgotEmail == '')
    {
        $("#forgot_email_error").html("Email address is required");
        $("#forgot_email_error").parent('span').removeClass("hide");
        $("#szForgotEmail").parent('div').parent('div').addClass("has-error");
    }
    if(szForgotEmail != '')
    {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if(!regex.test(szForgotEmail))
        {
            $("#forgot_email_error").html("Email address is not valid.");
            $("#forgot_email_error").parent('span').removeClass("hide");
            $("#szForgotEmail").parent('div').parent('div').addClass("has-error");
        }
        else
        {
            $.post(__SITE_JS_PATH__+"/ajax_user.php",{mode:'__FORGOT_PASSWORD__',szForgotEmail:szForgotEmail},function(result){
                var result_ary = result.split("||||");
                if(result_ary[0]=='SUCCESS')
                {
                    $("#szForgotEmail").val('');
                    open_login_form();
                    $("#forgot_success").removeClass("hide");
                }
                else if(result_ary[0]=='ERROR')
                {
                    $("#forgot_email_error").html("The email address you entered is not registered with the system. Please try again.");
                    $("#forgot_email_error").parent('span').removeClass("hide");
                    $("#szForgotEmail").parent('div').parent('div').addClass("has-error");
                }

            });
        }
    }
}

function addNewEmployee()
{
    
    var value=jQuery("#addNewEmployeeForm").serialize();
    var newvalue=value+"&mode=__ADD_NEW_EMPLOYEE__";
    jQuery('#loader').attr('style','display:block');
    jQuery.post(__SITE_JS_PATH__+"/ajax_user.php",newvalue,function(result){
        var result_ary = result.split("||||");
        if(result_ary[0]=='SUCCESS')
        {
            $("#newEmpForm").html(result_ary[1]);
            $('#static').modal("show");
        }
        else if(result_ary[0]=='ERROR')
        {
            $("#newEmpForm").html(result_ary[1]);
        }
        jQuery('#loader').attr('style','display:none');
    });
}

function addNewRefReason()
{
    var value=jQuery("#addNewRefundReasonForm").serialize();
    var newvalue=value+"&mode=__ADD_NEW_REFUND_REASON__";
    jQuery('#loader').attr('style','display:block');
    jQuery.post(__SITE_JS_PATH__+"/ajax_master.php",newvalue,function(result){
        var result_ary = result.split("||||");
        if(result_ary[0]=='SUCCESS')
        {
            $("#newRefResForm").html(result_ary[1]);
            $('#static').modal("show");
        }
        else if(result_ary[0]=='ERROR')
        {
            $("#newRefResForm").html(result_ary[1]);
            $('#static').modal("show");
        }
        jQuery('#loader').attr('style','display:none');
    });
}

function addNewService()
{
    var value=jQuery("#addNewServiceForm").serialize();
    var newvalue=value+"&mode=__ADD_NEW_SERVICE__";
    jQuery('#loader').attr('style','display:block');
    jQuery.post(__SITE_JS_PATH__+"/ajax_master.php",newvalue,function(result){
        var result_ary = result.split("||||");
        if(result_ary[0]=='SUCCESS')
        {
            $("#newRefResForm").html(result_ary[1]);
            $('#static').modal("show");
        }
        else if(result_ary[0]=='ERROR')
        {
            $("#newRefResForm").html(result_ary[1]);
            $('#static').modal("show");
        }
        jQuery('#loader').attr('style','display:none');
    });
}

function deleteRefRes(refresid){
    if(refresid > '0'){
        var newvalue="delid="+refresid+"&mode=__DEL_REFUND_REASON__";
        
               jQuery('#loader').attr('style','display:block');
               jQuery.post(__SITE_JS_PATH__+"/ajax_master.php",newvalue,function(result){
                    var result_ary = result.split("||||");
                    if(result_ary[0]=='SUCCESS')
                    {
                        $("#newRefResForm").html(result_ary[1]);
                        $('#static').modal("show");
                    }
                    else if(result_ary[0]=='ERROR')
                    {
                        $("#newRefResForm").html(result_ary[1]);
                        $('#static').modal("show");
                    }
                    jQuery('#loader').attr('style','display:none');
                });
        
    }
}

function delService(serviceid){
    if(serviceid > '0'){
        var newvalue="delid="+serviceid+"&mode=__DEL_SERVICE__";
        
               jQuery('#loader').attr('style','display:block');
               jQuery.post(__SITE_JS_PATH__+"/ajax_master.php",newvalue,function(result){
                    var result_ary = result.split("||||");
                    if(result_ary[0]=='SUCCESS')
                    {
                        $("#newRefResForm").html(result_ary[1]);
                        $('#static').modal("show");
                    }
                    else if(result_ary[0]=='ERROR')
                    {
                        $("#newRefResForm").html(result_ary[1]);
                        $('#static').modal("show");
                    }
                    jQuery('#loader').attr('style','display:none');
                });
            
        
    }
}


function editRefReason()
{
    var value=jQuery("#editNewRefundReasonForm").serialize();
    var newvalue=value+"&mode=__UPDATE_REFUND_REASON__";
    jQuery('#loader').attr('style','display:block');
    jQuery.post(__SITE_JS_PATH__+"/ajax_master.php",newvalue,function(result){
        var result_ary = result.split("||||");
        if(result_ary[0]=='SUCCESS')
        {
            $("#newRefResForm").html(result_ary[1]);
            $('#static').modal("show");
        }
        else if(result_ary[0]=='ERROR')
        {
            $("#newRefResForm").html(result_ary[1]);
            $('#static').modal("show");
        }
        jQuery('#loader').attr('style','display:none');
    });
}

function editService()
{
    var value=jQuery("#editServiceForm").serialize();
    var newvalue=value+"&mode=__UPDATE_SERVICE__";
    jQuery('#loader').attr('style','display:block');
    jQuery.post(__SITE_JS_PATH__+"/ajax_master.php",newvalue,function(result){
        var result_ary = result.split("||||");
        if(result_ary[0]=='SUCCESS')
        {
            $("#newRefResForm").html(result_ary[1]);
            $('#static').modal("show");
        }
        else if(result_ary[0]=='ERROR')
        {
            $("#newRefResForm").html(result_ary[1]);
            $('#static').modal("show");
        }
        jQuery('#loader').attr('style','display:none');
    });
}

function changeEmployeeStatus(empId,iStatus)
{
    jQuery('#loader').attr('style','display:block');
    $.post(__SITE_JS_PATH__+"/ajax_user.php",{mode:'__CHANGE_EMPLOYEE_STATUS__',empId:empId,iStatus:iStatus},function(result){
        var result_ary = result.split("||||");
        if(result_ary[0]=='SUCCESS')
        {
            $("#employeeList").html(result_ary[1]);
            $('#employeeStatus').modal("show");
        }
        jQuery('#loader').attr('style','display:none');

    });
}
function changeEmployeeStatusConfirmation(empId,iStatus)
{
    jQuery('#loader').attr('style','display:block');
    $.post(__SITE_JS_PATH__+"/ajax_user.php",{mode:'__CHANGE_EMPLOYEE_STATUS_CONFIRMATION__',empId:empId,iStatus:iStatus},function(result){
        var result_ary = result.split("||||");
        if(result_ary[0]=='SUCCESS')
        {
            $("#employeeList").html(result_ary[1]);
            $('#employeeStatus').modal("hide");
            $('.modal-backdrop').remove();
            $('#employeeStatusConfirmation').modal("show");
        }
        jQuery('#loader').attr('style','display:none');

    });
}

function deleteEmployee(empId)
{
    jQuery('#loader').attr('style','display:block');
    $.post(__SITE_JS_PATH__+"/ajax_user.php",{mode:'__DELETE_EMPLOYEE__',empId:empId},function(result){
        var result_ary = result.split("||||");
        if(result_ary[0]=='SUCCESS')
        {
            $("#employeeList").html(result_ary[1]);
            $('#employeeStatus').modal("show");
        }
        jQuery('#loader').attr('style','display:none');

    });
}

function deleteRefundResult(refresId)
{
    jQuery('#loader').attr('style','display:block');
    $.post(__SITE_JS_PATH__+"/ajax_master.php",{mode:'__DELETE_REFUND_RESULT__',refresId:refresId},function(result){
        var result_ary = result.split("||||");
        if(result_ary[0]=='SUCCESS')
        {
            $("#newRefResForm").html(result_ary[1]);
            $('#employeeStatus').modal("show");
        }
        jQuery('#loader').attr('style','display:none');

    });
}

function deleteService(serviceId)
{
    jQuery('#loader').attr('style','display:block');
    $.post(__SITE_JS_PATH__+"/ajax_master.php",{mode:'__DELETE_SERVICE__',serviceId:serviceId},function(result){
        var result_ary = result.split("||||");
        if(result_ary[0]=='SUCCESS')
        {
            $("#newRefResForm").html(result_ary[1]);
            $('#employeeStatus').modal("show");
        }
        jQuery('#loader').attr('style','display:none');

    });
}

function deleteEmployeeConfirmation(empId)
{
    jQuery('#loader').attr('style','display:block');
    $.post(__SITE_JS_PATH__+"/ajax_user.php",{mode:'__DELETE_EMPLOYEE_CONFIRMATION__',empId:empId},function(result){
        var result_ary = result.split("||||");
        if(result_ary[0]=='SUCCESS')
        {
            $("#employeeList").html(result_ary[1]);
            $('#employeeStatus').modal("hide");
            $('.modal-backdrop').remove();
            $('#employeeStatusConfirmation').modal("show");
        }
        jQuery('#loader').attr('style','display:none');

    });
}

function editEmployee()
{
    var value=jQuery("#editEmployeeForm").serialize();
    var newvalue=value+"&mode=__EDIT_EMPLOYEE__";
    jQuery('#loader').attr('style','display:block');
    jQuery.post(__SITE_JS_PATH__+"/ajax_user.php",newvalue,function(result){
        var result_ary = result.split("||||");
        if(result_ary[0]=='SUCCESS')
        {
            $("#newEmpForm").html(result_ary[1]);
            $('#static').modal("show");
        }
        else if(result_ary[0]=='ERROR')
        {
            $("#newEmpForm").html(result_ary[1]);
        }
        jQuery('#loader').attr('style','display:none');
    });
}


function openPersonalDetailForm()
{
    jQuery('#loader').attr('style','display:block');
    $.post(__SITE_JS_PATH__+"/ajax_user.php",{mode:'__OPEN_PERSONAL_DETAIL_FORM__'},function(result){
        var result_ary = result.split("||||");
        if(result_ary[0]=='SUCCESS')
        {
            $("#my_profile").html(result_ary[1]);
            
        }
        jQuery('#loader').attr('style','display:none');

    });
}

function openChangePasswordForm()
{
    jQuery('#loader').attr('style','display:block');
    $.post(__SITE_JS_PATH__+"/ajax_user.php",{mode:'__OPEN_CHANGE_PASSWORD_FORM__'},function(result){
        var result_ary = result.split("||||");
        if(result_ary[0]=='SUCCESS')
        {
            $("#my_profile").html(result_ary[1]);
            
        }
        jQuery('#loader').attr('style','display:none');

    });
}

function editProfile()
{
    var value=jQuery("#editProfileForm").serialize();
    var newvalue=value+"&mode=__EDIT_PROFILE__";
    jQuery('#loader').attr('style','display:block');
    jQuery.post(__SITE_JS_PATH__+"/ajax_user.php",newvalue,function(result){
        var result_ary = result.split("||||");
        if(result_ary[0]=='SUCCESS')
        {
            $("#my_profile").html(result_ary[1]);
            $('#static').modal("show");
        }
        else if(result_ary[0]=='ERROR')
        {
            $("#my_profile").html(result_ary[1]);
        }
        jQuery('#loader').attr('style','display:none');
    });
}
function changePassword()
{
    var value=jQuery("#changePasswordForm").serialize();
    var newvalue=value+"&mode=__CHANGE_PASSWORD__";
    jQuery('#loader').attr('style','display:block');
    jQuery.post(__SITE_JS_PATH__+"/ajax_user.php",newvalue,function(result){
        var result_ary = result.split("||||");
        if(result_ary[0]=='SUCCESS')
        {
            $("#my_profile").html(result_ary[1]);
            $('#static').modal("show");
        }
        else if(result_ary[0]=='ERROR')
        {
            $("#my_profile").html(result_ary[1]);
        }
        jQuery('#loader').attr('style','display:none');
    });
}

function addNewClient()
{
    var value=jQuery("#addNewClientForm").serialize();
    var newvalue=value+"&mode=__ADD_NEW_CLIENT__";
    jQuery('#loader').attr('style','display:block');
    jQuery.post(__SITE_JS_PATH__+"/ajax_client.php",newvalue,function(result){
        var result_ary = result.split("||||");
        if(result_ary[0]=='SUCCESS')
        {
            $("#page_content").html(result_ary[1]);
            $('#static').modal("show");
        }
        else if(result_ary[0]=='ERROR')
        {
            $("#page_content").html(result_ary[1]);
        }
        jQuery('#loader').attr('style','display:none');
    });
}




function changeClientStatus(clientId,iStatus)
{
    var szSearchText = $("#szSearchText").val();
    jQuery('#loader').attr('style','display:block');
    $.post(__SITE_JS_PATH__+"/ajax_client.php",{mode:'__CHANGE_CLIENT_STATUS__',clientId:clientId,iStatus:iStatus,szSearchText:szSearchText},function(result){
        var result_ary = result.split("||||");
        if(result_ary[0]=='SUCCESS')
        {
            $("#page_content").html(result_ary[1]);
            $('#clientStatus').modal("show");
        }
        jQuery('#loader').attr('style','display:none');

    });
}
function changeClientStatusConfirmation(clientId,iStatus)
{
    var szSearchText = $("#szSearchText").val();
    jQuery('#loader').attr('style','display:block');
    $.post(__SITE_JS_PATH__+"/ajax_client.php",{mode:'__CHANGE_CLIENT_STATUS_CONFIRMATION__',clientId:clientId,iStatus:iStatus,szSearchText:szSearchText},function(result){
        var result_ary = result.split("||||");
        if(result_ary[0]=='SUCCESS')
        {
            $("#page_content").html(result_ary[1]);
            $('#clientStatus').modal("hide");
            $('.modal-backdrop').remove();
            $('#clientStatusConfirmation').modal("show");
        }
        jQuery('#loader').attr('style','display:none');

    });
}

function deleteClient(clientId)
{
    var szSearchText = $("#szSearchText").val();
    jQuery('#loader').attr('style','display:block');
    $.post(__SITE_JS_PATH__+"/ajax_client.php",{mode:'__DELETE_CLIENT__',clientId:clientId,szSearchText:szSearchText},function(result){
        var result_ary = result.split("||||");
        if(result_ary[0]=='SUCCESS')
        {
            $("#page_content").html(result_ary[1]);
            $('#clientStatus').modal("show");
        }
        jQuery('#loader').attr('style','display:none');

    });
}

function deleteClientConfirmation(clientId,flag)
{
    var szSearchText = $("#szSearchText").val();
    jQuery('#loader').attr('style','display:block');
    $.post(__SITE_JS_PATH__+"/ajax_client.php",{mode:'__DELETE_CLIENT_CONFIRMATION__',clientId:clientId,szSearchText:szSearchText},function(result){
        var result_ary = result.split("||||");
        if(result_ary[0]=='SUCCESS')
        {
            $("#page_content").html(result_ary[1]);
            $('#clientStatus').modal("hide");
            $('.modal-backdrop').remove();
            $('#clientStatusConfirmation').modal("show");
        }
        jQuery('#loader').attr('style','display:none');

    });
}

function addNewStatus()
{
    var value=jQuery("#addNewStatusForm").serialize();
    var newvalue=value+"&mode=__ADD_NEW_STATUS__";
    jQuery('#loader').attr('style','display:block');
    jQuery.post(__SITE_JS_PATH__+"/ajax_master.php",newvalue,function(result){
        var result_ary = result.split("||||");
        if(result_ary[0]=='SUCCESS')
        {
            $("#page_content").html(result_ary[1]);
            $('#static').modal("show");
        }
        else if(result_ary[0]=='ERROR')
        {
            $("#page_content").html(result_ary[1]);
        }
        jQuery('#loader').attr('style','display:none');
    });
}

function editStatus()
{
    var value=jQuery("#editStatusForm").serialize();
    var newvalue=value+"&mode=__EDIT_STATUS__";
    jQuery('#loader').attr('style','display:block');
    jQuery.post(__SITE_JS_PATH__+"/ajax_master.php",newvalue,function(result){
        var result_ary = result.split("||||");
        if(result_ary[0]=='SUCCESS')
        {
            $("#page_content").html(result_ary[1]);
            $('#static').modal("show");
        }
        else if(result_ary[0]=='ERROR')
        {
            $("#page_content").html(result_ary[1]);
        }
        jQuery('#loader').attr('style','display:none');
    });
}

function deleteStatus(statusId)
{
    jQuery('#loader').attr('style','display:block');
    $.post(__SITE_JS_PATH__+"/ajax_master.php",{mode:'__DELETE_STATUS__',statusId:statusId},function(result){
        var result_ary = result.split("||||");
        if(result_ary[0]=='SUCCESS')
        {
            $("#page_content").html(result_ary[1]);
            $('#delete_Status').modal("show");
        }
        jQuery('#loader').attr('style','display:none');

    });
}

function deleteStatusConfirmation(statusId)
{
    jQuery('#loader').attr('style','display:block');
    $.post(__SITE_JS_PATH__+"/ajax_master.php",{mode:'__DELETE_STATUS_CONFIRMATION__',statusId:statusId},function(result){
        var result_ary = result.split("||||");
        if(result_ary[0]=='SUCCESS')
        {
            $("#page_content").html(result_ary[1]);
            $('#delete_Status').modal("hide");
            $('.modal-backdrop').remove();
            $('#delete_StatusConfirmation').modal("show");
        }
        jQuery('#loader').attr('style','display:none');

    });
}
function addNewConfirmType()
{
    var value=jQuery("#addNewConfirmTypeForm").serialize();
    var newvalue=value+"&mode=__ADD_NEW_COMFIRM_TYPE__";
    jQuery('#loader').attr('style','display:block');
    jQuery.post(__SITE_JS_PATH__+"/ajax_master.php",newvalue,function(result){
        var result_ary = result.split("||||");
        if(result_ary[0]=='SUCCESS')
        {
            $("#page_content").html(result_ary[1]);
            $('#static').modal("show");
        }
        else if(result_ary[0]=='ERROR')
        {
            $("#page_content").html(result_ary[1]);
        }
        jQuery('#loader').attr('style','display:none');
    });
}

function editConfirmType()
{
    var value=jQuery("#editConfirmTypeForm").serialize();
    var newvalue=value+"&mode=__EDIT_COMFIRM_TYPE__";
    jQuery('#loader').attr('style','display:block');
    jQuery.post(__SITE_JS_PATH__+"/ajax_master.php",newvalue,function(result){
        var result_ary = result.split("||||");
        if(result_ary[0]=='SUCCESS')
        {
            $("#page_content").html(result_ary[1]);
            $('#static').modal("show");
        }
        else if(result_ary[0]=='ERROR')
        {
            $("#page_content").html(result_ary[1]);
        }
        jQuery('#loader').attr('style','display:none');
    });
}

function deleteConfirmType(confirmTypeId)
{
    jQuery('#loader').attr('style','display:block');
    $.post(__SITE_JS_PATH__+"/ajax_master.php",{mode:'__DELETE_COMFIRM_TYPE__',confirmTypeId:confirmTypeId},function(result){
        var result_ary = result.split("||||");
        if(result_ary[0]=='SUCCESS')
        {
            $("#page_content").html(result_ary[1]);
            $('#delete_ConfirmType').modal("show");
        }
        jQuery('#loader').attr('style','display:none');

    });
}

function deleteConfirmTypeConfirmation(confirmTypeId)
{
    jQuery('#loader').attr('style','display:block');
    $.post(__SITE_JS_PATH__+"/ajax_master.php",{mode:'__DELETE_COMFIRM_TYPE_CONFIRMATION__',confirmTypeId:confirmTypeId},function(result){
        var result_ary = result.split("||||");
        if(result_ary[0]=='SUCCESS')
        {
            $("#page_content").html(result_ary[1]);
            $('#delete_ConfirmType').modal("hide");
            $('.modal-backdrop').remove();
            $('#delete_ConfirmTypeConfirmation').modal("show");
        }
        jQuery('#loader').attr('style','display:none');

    });
}

function addNewCarrier()
{
   
    var value=jQuery("#addNewCarrierForm").serialize();
    var newvalue=value+"&mode=__ADD_NEW_CARRIER__";
    jQuery('#loader').attr('style','display:block');
    jQuery.post(__SITE_JS_PATH__+"/ajax_master.php",newvalue,function(result){
        var result_ary = result.split("||||");
        if(result_ary[0]=='SUCCESS')
        {
            $("#page_content").html(result_ary[1]);
            $('#static').modal("show");
        }
        else if(result_ary[0]=='ERROR')
        {
            $("#page_content").html(result_ary[1]);
        }
        jQuery('#loader').attr('style','display:none');
    });
}

function editCarrier()
{
    var value=jQuery("#editCarrierForm").serialize();
    var newvalue=value+"&mode=__EDIT_CARRIER__";
    jQuery('#loader').attr('style','display:block');
    jQuery.post(__SITE_JS_PATH__+"/ajax_master.php",newvalue,function(result){
        var result_ary = result.split("||||");
        if(result_ary[0]=='SUCCESS')
        {
            $("#page_content").html(result_ary[1]);
            $('#static').modal("show");
        }
        else if(result_ary[0]=='ERROR')
        {
            $("#page_content").html(result_ary[1]);
        }
        jQuery('#loader').attr('style','display:none');
    });
}

function deleteCarrier(carrierId)
{
    jQuery('#loader').attr('style','display:block');
    $.post(__SITE_JS_PATH__+"/ajax_master.php",{mode:'__DELETE_CARRIER__',carrierId:carrierId},function(result){
        var result_ary = result.split("||||");
        if(result_ary[0]=='SUCCESS')
        {
            $("#page_content").html(result_ary[1]);
            $('#delete_Carrier').modal("show");
        }
        jQuery('#loader').attr('style','display:none');

    });
}

function deleteCarrierConfirmation(carrierId)
{
    jQuery('#loader').attr('style','display:block');
    $.post(__SITE_JS_PATH__+"/ajax_master.php",{mode:'__DELETE_CARRIER_CONFIRMATION__',carrierId:carrierId},function(result){
        var result_ary = result.split("||||");
        if(result_ary[0]=='SUCCESS')
        {
            $("#page_content").html(result_ary[1]);
            $('#delete_Carrier').modal("hide");
            $('.modal-backdrop').remove();
            $('#delete_CarrierConfirmation').modal("show");
        }
        jQuery('#loader').attr('style','display:none');

    });
}

function searchClients()
{
    var szSearchText = $("#szSearchText").val();
    
    if(szSearchText!='')
    {
        jQuery('#loader').attr('style','display:block');
        $.post(__SITE_JS_PATH__+"/ajax_client.php",{mode:'__SEARCH_CLIENTS__',szSearchText:szSearchText},function(result){
            var result_ary = result.split("||||");
            if(result_ary[0]=='SUCCESS')
            {
                $("#page_content").html(result_ary[1]);
            }
            jQuery('#loader').attr('style','display:none');

        });
    }
}
function resetClientSearch()
{
    
    jQuery('#loader').attr('style','display:block');
    $.post(__SITE_JS_PATH__+"/ajax_client.php",{mode:'__RESET_CLIENT_SEARCH__'},function(result){
        var result_ary = result.split("||||");
        if(result_ary[0]=='SUCCESS')
        {
            $("#page_content").html(result_ary[1]);
        }
        jQuery('#loader').attr('style','display:none');

    });
}

function addNewClientAccount()
{
    var value=jQuery("#addNewClientAccountForm").serialize();
    var newvalue=value+"&mode=__ADD_NEW_CLIENT_ACCOUNT__";
    jQuery('#loader').attr('style','display:block');
    jQuery.post(__SITE_JS_PATH__+"/ajax_client.php",newvalue,function(result){
        var result_ary = result.split("||||");
        if(result_ary[0]=='SUCCESS')
        {
            $("#page_content").html(result_ary[1]);
            $('#static').modal("show");
        }
        else if(result_ary[0]=='ERROR')
        {
            $("#page_content").html(result_ary[1]);
        }
        jQuery('#loader').attr('style','display:none');
    });
}


function editClientAccount()
{
    var value=jQuery("#editClientAccountForm").serialize();
    var newvalue=value+"&mode=__EDIT_CLIENT_ACCOUNT__";
    jQuery('#loader').attr('style','display:block');
    jQuery.post(__SITE_JS_PATH__+"/ajax_client.php",newvalue,function(result){
        var result_ary = result.split("||||");
        if(result_ary[0]=='SUCCESS')
        {
            $("#page_content").html(result_ary[1]);
            $('#static').modal("show");
        }
        else if(result_ary[0]=='ERROR')
        {
            $("#page_content").html(result_ary[1]);
        }
        jQuery('#loader').attr('style','display:none');
    });
}

function changeClientAccountStatus(clientAccountId,clientId,iStatus)
{
    var szSearchText=jQuery("#szSearchText").val();
    jQuery('#loader').attr('style','display:block');
    $.post(__SITE_JS_PATH__+"/ajax_client.php",{mode:'__CHANGE_CLIENT_ACCOUNT_STATUS__',clientAccountId:clientAccountId,clientId:clientId,iStatus:iStatus,szSearchText:szSearchText},function(result){
        var result_ary = result.split("||||");
        if(result_ary[0]=='SUCCESS')
        {
            $("#page_content").html(result_ary[1]);
            $('#clientStatus').modal("show");
        }
        jQuery('#loader').attr('style','display:none');

    });
}
function changeClientAccountStatusConfirmation(clientAccountId,clientId,iStatus)
{
    var szSearchText=jQuery("#szSearchText").val();
    jQuery('#loader').attr('style','display:block');
    $.post(__SITE_JS_PATH__+"/ajax_client.php",{mode:'__CHANGE_CLIENT_ACCOUNT_STATUS_CONFIRMATION__',clientAccountId:clientAccountId,clientId:clientId,iStatus:iStatus,szSearchText:szSearchText},function(result){
        var result_ary = result.split("||||");
        if(result_ary[0]=='SUCCESS')
        {
            $("#page_content").html(result_ary[1]);
            $('#clientStatus').modal("hide");
            $('.modal-backdrop').remove();
            $('#clientStatusConfirmation').modal("show");
        }
        jQuery('#loader').attr('style','display:none');

    });
}

function deleteClientAccount(clientAccountId)
{ 
    var szSearchText=jQuery("#szSearchText").val();
    jQuery('#loader').attr('style','display:block');
    $.post(__SITE_JS_PATH__+"/ajax_client.php",{mode:'__DELETE_CLIENT_ACCOUNT__',clientAccountId:clientAccountId,szSearchText:szSearchText},function(result){
      var result_ary = result.split("||||");
      if(result_ary[0]=='SUCCESS')
      {
         $("#page_content").html(result_ary[1]);
         $('#clientStatus').modal("show");
      }
      jQuery('#loader').attr('style','display:none');

    });
}

function deleteClientAccountConfirmation(clientAccountId)
{
    var szSearchText=jQuery("#szSearchText").val();
    jQuery('#loader').attr('style','display:block');
    $.post(__SITE_JS_PATH__+"/ajax_client.php",{mode:'__DELETE_CLIENT_ACCOUNT_CONFIRMATION__',clientAccountId:clientAccountId,szSearchText:szSearchText},function(result){
        var result_ary = result.split("||||");
        if(result_ary[0]=='SUCCESS')
        {
            $("#page_content").html(result_ary[1]);
            $('#clientStatus').modal("hide");
            $('.modal-backdrop').remove();
            $('#clientStatusConfirmation').modal("show");
        }
        jQuery('#loader').attr('style','display:none');

    });
}

function addNewRefund(page_url)
{
    var value=jQuery("#addNewRefundForm").serialize();
    var newvalue=value+"&mode=__ADD_NEW_REFUND__";
    jQuery('#loader').attr('style','display:block');
    jQuery.post(__SITE_JS_PATH__+"/ajax_client.php",newvalue,function(result){
        var result_ary = result.split("||||");
        if(result_ary[0]=='SUCCESS')
        {
            window.location.href =page_url;
        }
        else if(result_ary[0]=='ERROR')
        {
            $("#addNewRefund").html(result_ary[1]);
        }
        jQuery('#loader').attr('style','display:none');
    });
}
function addSaveAndNewRefund(page_url)
{
    var value=jQuery("#addNewRefundForm").serialize();
    var newvalue=value+"&mode=__ADD_SAVE_AND_NEW_REFUND__";
    jQuery('#loader').attr('style','display:block');
    jQuery.post(__SITE_JS_PATH__+"/ajax_client.php",newvalue,function(result){
        var result_ary = result.split("||||");
        if(result_ary[0]=='SUCCESS')
        {
            window.location.href =page_url;
        }
        else if(result_ary[0]=='ERROR')
        {
            $("#addNewRefund").html(result_ary[1]);
        }
        jQuery('#loader').attr('style','display:none');
    });
}
function deleteRefund(refundId,invoiceId)
{
 
    jQuery('#loader').attr('style','display:block');
    
    var sessionKey=$("#sessionKey").val();
    var newvalue="&mode=__DELETE_REFUND__&invoiceId="+invoiceId+"&refundId="+refundId+"&sessionKey="+sessionKey;
    jQuery.post(__SITE_JS_PATH__+"/ajax_client.php",newvalue,function(result){
    var result_ary = result.split("||||");
        if(result_ary[0]=='SUCCESS')
        {
            $("#editRefund").html(result_ary[1]);
            $('#delete_Refund').modal("show");
        }
        jQuery('#loader').attr('style','display:none');

    });
}

function deleteRefundConfirmation(refundId,invoiceId,page_url)
{
    jQuery('#loader').attr('style','display:block');
    var sessionKey=$("#sessionKey").val();
    var newvalue="&mode=__DELETE_REFUND_CONFIRMATION__&&invoiceId="+invoiceId+"&refundId="+refundId+"&sessionKey="+sessionKey;
    jQuery.post(__SITE_JS_PATH__+"/ajax_client.php",newvalue,function(result){
    var result_ary = result.split("||||");
        if(result_ary[0]=='SUCCESS')
        {
             window.location.href =page_url;
        }
    });
}
function editRefund()
{
    var value=jQuery("#editRefundForm").serialize();
    var newvalue=value+"&mode=__EDIT_REFUND__";
    jQuery('#loader').attr('style','display:block');
    jQuery.post(__SITE_JS_PATH__+"/ajax_client.php",newvalue,function(result){
        var result_ary = result.split("||||");
        if(result_ary[0]=='SUCCESS')
        {
            $("#editRefund").html(result_ary[1]);
            $('#static').modal("show");
        }
        else if(result_ary[0]=='ERROR')
        {
            $("#editRefund").html(result_ary[1]);
        }
        jQuery('#loader').attr('style','display:none');
    });
}

function sortRefundsListing(invoiceId,sortBy,sortValue)
{ 
   var szSearchText = $("#szSearchText").val();
   var sessionKey = $("#sessionKey").val();
  
    $.post(__SITE_JS_PATH__+"/ajax_client.php",{mode:'__REFUNDS_SORTING__',invoiceId:invoiceId,sortBy:sortBy,sortValue:sortValue,szSearchText:szSearchText,sessionKey:sessionKey},function(result){
        var result_ary = result.split("||||");
        if(result_ary[0]=='SUCCESS')
        {
           jQuery("#page_content").html(result_ary[1]);
           jQuery("#sortValue").attr('value',sortValue);
           jQuery("#sortBy").attr('value',sortBy);
        }
       
    });
}

function searchRefunds(invoiceId,sessionKey)
{
    var szSearchText = $("#szSearchText").val();
    var sortBy = $("#sortBy").val();
    var sortValue = $("#sortValue").val();
    
    if(szSearchText!='')
    {
        jQuery('#loader').attr('style','display:block');
        $.post(__SITE_JS_PATH__+"/ajax_client.php",{mode:'__SEARCH_REFUNDS__',szSearchText:szSearchText,invoiceId:invoiceId,sortBy:sortBy,sortValue:sortValue,sessionKey:sessionKey},function(result){
            var result_ary = result.split("||||");
            if(result_ary[0]=='SUCCESS')
            {
                $("#page_content").html(result_ary[1]);
            }
            jQuery('#loader').attr('style','display:none');

        });
    }
}
function resetRefundsSearch(invoiceId,sessionKey)
{
    var sortBy = $("#sortBy").val();
    var sortValue = $("#sortValue").val();
    
    jQuery('#loader').attr('style','display:block');
    $.post(__SITE_JS_PATH__+"/ajax_client.php",{mode:'__RESET_REFUNDS_SEARCH__',invoiceId:invoiceId,sortBy:sortBy,sortValue:sortValue,sessionKey:sessionKey},function(result){
    var result_ary = result.split("||||");
    if(result_ary[0]=='SUCCESS')
    {
        $("#page_content").html(result_ary[1]);
    }
    jQuery('#loader').attr('style','display:none');
    });
}

function searchClientAccounts(clientId)
{
    var szSearchText = $("#szSearchText").val();
    
    if(szSearchText!='')
    {
        jQuery('#loader').attr('style','display:block');
        $.post(__SITE_JS_PATH__+"/ajax_client.php",{mode:'__SEARCH_CLIENT_ACCOUNTS__',szSearchText:szSearchText,clientId:clientId},function(result){
            var result_ary = result.split("||||");
            if(result_ary[0]=='SUCCESS')
            {
                $("#page_content").html(result_ary[1]);
            }
            jQuery('#loader').attr('style','display:none');

        });
    }
}
function resetClientAccountSearch(clientId)
{
    
    jQuery('#loader').attr('style','display:block');
    $.post(__SITE_JS_PATH__+"/ajax_client.php",{mode:'__RESET_CLIENT_ACCOUNT_SEARCH__',clientId:clientId},function(result){
        var result_ary = result.split("||||");
        if(result_ary[0]=='SUCCESS')
        {
            $("#page_content").html(result_ary[1]);
        }
        jQuery('#loader').attr('style','display:none');

    });
}



function deleteInvoices(invoiceId,sessionKey)
{ 
    jQuery('#loader').attr('style','display:block');
     var value=jQuery("#editInvoiceForm").serialize();
     var newvalue=value+"&mode=__DELETE_INVOICES__&invoiceId="+invoiceId+"&sessionKey="+sessionKey;
     jQuery.post(__SITE_JS_PATH__+"/ajax_client.php",newvalue,function(result){
        var result_ary = result.split("||||");
        if(result_ary[0]=='SUCCESS')
        {
            $("#page_content").html(result_ary[1]);
            $('#delete_invoices').modal("show");
        }
        jQuery('#loader').attr('style','display:none');

    });
}

function deleteInvoicesConfirmation(invoiceId,page_url)
{
    jQuery('#loader').attr('style','display:block');
    
    
    var value=jQuery("#searchInvoiceForm").serialize();
    var newvalue=value+"&mode=__DELETE_INVOICES_CONFIRMATION__&invoiceId="+invoiceId;
    
        jQuery.post(__SITE_JS_PATH__+"/ajax_client.php",newvalue,function(result){
        var result_ary = result.split("||||");
        if(result_ary[0]=='SUCCESS')
        {
             redirect_url(page_url);
        }
    });
}

function deleteInvoiceConfirmationPopUp(sessionKey)
{
    jQuery('#loader').attr('style','display:block');
    
    var newvalue="&mode=__DELETE_INVOICES_CONFIRMATION_POP_UP__&sessionKey="+sessionKey;
    
        jQuery.post(__SITE_JS_PATH__+"/ajax_client.php",newvalue,function(result){
        var result_ary = result.split("||||");
       
        if(result_ary[0]=='SUCCESS')
        {
            $("#page_content").html(result_ary[1]);
            $('#delete_popup').modal("show");
        }
        jQuery('#loader').attr('style','display:none');

    });
}


function resetInvoicesSearch()
{
    
    jQuery('#loader').attr('style','display:block');
    $.post(__SITE_JS_PATH__+"/ajax_client.php",{mode:'__RESET_INVOICES_SEARCH__'},function(result){
        var result_ary = result.split("||||");
        if(result_ary[0]=='SUCCESS')
        {
            redirect_url(result_ary[1]);
            
        }
    });
}

function getClientAccounts(clientName,updateFlag)
{
    jQuery('#loader').attr('style','display:block');
    $.post(__SITE_JS_PATH__+"/ajax_client.php",{mode:'__GET_CLIENT_ACCOUNT__',clientName:clientName,updateFlag:updateFlag},function(result){
        var result_ary = result.split("||||");
        if(result_ary[0]=='SUCCESS')
        {
            $("#account_value").html(result_ary[1]);
            $("#account_script").html(result_ary[2]);
        }
        jQuery('#loader').attr('style','display:none');

    });
}

function addNewInvoice(sessionKey)
{
     var value=jQuery("#addNewInvoiceForm").serialize();
    var newvalue=value+"&mode=__ADD_NEW_INVOICE__&sessionKey="+sessionKey;
    jQuery('#loader').attr('style','display:block');
    jQuery.post(__SITE_JS_PATH__+"/ajax_client.php",newvalue,function(result){
        var result_ary = result.split("||||");
        if(result_ary[0]=='SUCCESS')
        {
            $("#page_content").html(result_ary[1]);
            $('#static').modal("show");
        }
        else if(result_ary[0]=='ERROR')
        {
            $("#page_content").html(result_ary[1]);
        }
        jQuery('#loader').attr('style','display:none');
    });
}


function editInvoice(sessionKey)
{
    
   var value=jQuery("#editInvoiceForm").serialize();
    var newvalue=value+"&mode=__EDIT_INVOICE__&sessionKey="+sessionKey;
    jQuery('#loader').attr('style','display:block');
    jQuery.post(__SITE_JS_PATH__+"/ajax_client.php",newvalue,function(result){
        var result_ary = result.split("||||");
        if(result_ary[0]=='SUCCESS')
        {
            $("#page_content").html(result_ary[1]);
            $('#static').modal("show");
        }
        else if(result_ary[0]=='ERROR')
        {
            $("#page_content").html(result_ary[1]);
        }
        jQuery('#loader').attr('style','display:none');
    });
}


function getClientAccountForSearch(clientId)
{
    jQuery('#loader').attr('style','display:block');
    $.post(__SITE_JS_PATH__+"/ajax_client.php",{mode:'__GET_CLIENT_ACCOUNT_FOR_SEARCH__',clientId:clientId},function(result){
        var result_ary = result.split("||||");
        if(result_ary[0]=='SUCCESS')
        {
            $("#client_accounts").html(result_ary[1]);
        }
        jQuery('#loader').attr('style','display:none');

    });
}

function searchInvoices()
{
    var value=jQuery("#searchInvoiceForm").serialize();
    var newvalue=value+"&mode=__SEARCH_INVOICE__";
    jQuery('#loader').attr('style','display:block');
    jQuery.post(__SITE_JS_PATH__+"/ajax_client.php",newvalue,function(result){
        var result_ary = result.split("||||");
        if(result_ary[0]=='SUCCESS')
        {
            window.location.href =result_ary[1];
        }
        else if(result_ary[0]=='ERROR')
        {
            $("#page_content").html(result_ary[1]);
            jQuery('#loader').attr('style','display:none');
        }
        
    });
}

function sortInvoicesListing(sortBy,sortValue)
{ 
    
    var value=jQuery("#searchInvoiceForm").serialize();
    var newvalue=value+"&mode=__INVOICES_SORTING__&sortBy="+sortBy+"&sortValue="+sortValue;
    jQuery('#loader').attr('style','display:block');
    jQuery.post(__SITE_JS_PATH__+"/ajax_client.php",newvalue,function(result){
        var result_ary = result.split("||||");
        if(result_ary[0]=='SUCCESS')
        {
            $("#page_content").html(result_ary[1]);
            
        }
        jQuery('#loader').attr('style','display:none');
    });
}

function selectAccountCarrier(szAccountNumber)
{
    jQuery('#loader').attr('style','display:block');
    $.post(__SITE_JS_PATH__+"/ajax_client.php",{mode:'__GET_CLIENT_ACCOUNT_CARRIER__',szAccountNumber:szAccountNumber},function(result){
        var result_ary = result.split("||||");
        if(result_ary[0]=='SUCCESS')
        {
            $("#carrier").html(result_ary[1]);
            $("#carrier_script").html(result_ary[2]);
        }
        jQuery('#loader').attr('style','display:none');

    });
}

function uploadImportRefunds(invoiceId,sessionKey)
{
    jQuery('#loader').attr('style','display:block');
    $.post(__SITE_JS_PATH__+"/ajax_client.php",{mode:'__UPLOAD_IMPORT_REFUNDS__',invoiceId:invoiceId,sessionKey:sessionKey},function(result){
        var result_ary = result.split("||||");
        if(result_ary[0]=='SUCCESS')
        {
            $("#page_content").html(result_ary[1]);
            $('.modal-backdrop').remove();
            $('#upload_refunds').modal("show");
        }
        jQuery('#loader').attr('style','display:none');

    });
}

function importRefundConfirmation(invoiceId,errorRecord,rowcount,sessionKey)
{
    console.log('1');
    jQuery('#loader').attr('style','display:block');
    $.post(__SITE_JS_PATH__+"/ajax_client.php",{mode:'__IMPORT_REFUND_CONFIRMATION__',invoiceId:invoiceId,errorRecord:errorRecord,rowcount:rowcount,sessionKey:sessionKey},function(result){
        var result_ary = result.split("||||");
        if(result_ary[0]=='SUCCESS')
        {
            $("#page_content").html(result_ary[1]);
            $('.modal-backdrop').remove();
            $('#importRefundConfirmation').modal("show");
        }
        jQuery('#loader').attr('style','display:none');
        console.log('2');
    });
    
}

function selectNoRefundStatus(noRefundId,updateFlag)
{
    if($("#"+noRefundId).prop('checked')==true)
    {
        jQuery('#loader').attr('style','display:block');
        $.post(__SITE_JS_PATH__+"/ajax_client.php",{mode:'__SELECT_NO_REFUND__',updateFlag:updateFlag},function(result){
            var result_ary = result.split("||||");
            if(result_ary[0]=='SUCCESS')
            {
                $("#status_values").html(result_ary[1]);
                $("#status_script").html(result_ary[2]);
            }
            jQuery('#loader').attr('style','display:none');

        });
    }
}

function uncheckNoRefunds()
{
    $("#noRefund_status").prop('checked',false);
    $("#noRefund_status").parent('span').removeClass('checked');
}

function ViewAllnvoices()
{
    jQuery('#loader').attr('style','display:block');
    $.post(__SITE_JS_PATH__+"/ajax_client.php",{mode:'__VIEW_ALL_INVOICES__'},function(result){
        var result_ary = result.split("||||");
        if(result_ary[0]=='SUCCESS')
        {
            redirect_url(result_ary[1]);  
        }
    });
}
function searchCreditReports()
{
    var value=jQuery("#searchInvoiceForm").serialize();
    var newvalue=value+"&mode=__SEARCH_CREDIT_REPORTS__";
    jQuery('#loader').attr('style','display:block');
    jQuery.post(__SITE_JS_PATH__+"/ajax_reports.php",newvalue,function(result){
        var result_ary = result.split("||||");
        if(result_ary[0]=='SUCCESS')
        {
            $("#page_content").html(result_ary[1]);
        }
        jQuery('#loader').attr('style','display:none');
    });
}

function resetcreditReportdSearch()
{
    
    jQuery('#loader').attr('style','display:block');
    $.post(__SITE_JS_PATH__+"/ajax_reports.php",{mode:'__RESET_CREDIT_REPORT_SEARCH__'},function(result){
        var result_ary = result.split("||||");
        if(result_ary[0]=='SUCCESS')
        {
            $("#page_content").html(result_ary[1]);
        }
        jQuery('#loader').attr('style','display:none');

    });
}
function searchTotalCreditReports()
{
    var value=jQuery("#searchInvoiceForm").serialize();
    var newvalue=value+"&mode=__SEARCH_TOTAL_CREDIT_REPORTS__";
    jQuery('#loader').attr('style','display:block');
    jQuery.post(__SITE_JS_PATH__+"/ajax_reports.php",newvalue,function(result){
        var result_ary = result.split("||||");
        if(result_ary[0]=='SUCCESS')
        {
            $("#page_content").html(result_ary[1]);
        }
        jQuery('#loader').attr('style','display:none');
    });
}

function resetTotalcreditReportSearch()
{
    
    jQuery('#loader').attr('style','display:block');
    $.post(__SITE_JS_PATH__+"/ajax_reports.php",{mode:'__RESET_TOTAL_CREDIT_REPORT_SEARCH__'},function(result){
        var result_ary = result.split("||||");
        if(result_ary[0]=='SUCCESS')
        {
            $("#page_content").html(result_ary[1]);
        }
        jQuery('#loader').attr('style','display:none');

    });
}

function getInvoicesReport()
{
    var value=jQuery("#invoiceReportForm").serialize();
    var newvalue=value+"&mode=__GET_INVOICE_REPORT__";
    jQuery('#loader').attr('style','display:block');
    jQuery.post(__SITE_JS_PATH__+"/ajax_reports.php",newvalue,function(result){
        var result_ary = result.split("||||");
        if(result_ary[0]=='SUCCESS')
        {
            $("#page_content").html(result_ary[1]);
        }
        jQuery('#loader').attr('style','display:none');
    });
}
function resetInvoicesReport()
{
    
    jQuery('#loader').attr('style','display:block');
    $.post(__SITE_JS_PATH__+"/ajax_reports.php",{mode:'__RESET_INVOICES_REPORT_SEARCH__'},function(result){
        var result_ary = result.split("||||");
        if(result_ary[0]=='SUCCESS')
        {
            $("#page_content").html(result_ary[1]);
        }
        jQuery('#loader').attr('style','display:none');

    });
}


function getManagerReport()
{
    var value=jQuery("#managerReportForm").serialize();
    var newvalue=value+"&mode=__GET_MANAGER_REPORT__";
    jQuery('#loader').attr('style','display:block');
    jQuery.post(__SITE_JS_PATH__+"/ajax_reports.php",newvalue,function(result){
        var result_ary = result.split("||||");
        if(result_ary[0]=='SUCCESS')
        {
            $("#page_content").html(result_ary[1]);
        }
        jQuery('#loader').attr('style','display:none');
    });
}
function resetManagerReport()
{
    jQuery('#loader').attr('style','display:block');
    $.post(__SITE_JS_PATH__+"/ajax_reports.php",{mode:'__RESET_MANAGER_REPORT_SEARCH__'},function(result){
        var result_ary = result.split("||||");
        if(result_ary[0]=='SUCCESS')
        {
            $("#page_content").html(result_ary[1]);
        }
        jQuery('#loader').attr('style','display:none');

    });
}

function getInvoiceReportsAccountData()
{
    var value=jQuery("#invoiceReportsAccountData").serialize();
    var newvalue=value+"&mode=__GET_INVOICES_REPORTS_ACCOUNT_DATA__";
    jQuery('#loader').attr('style','display:block');
    jQuery.post(__SITE_JS_PATH__+"/ajax_reports.php",newvalue,function(result){
        var result_ary = result.split("||||");
        if(result_ary[0]=='SUCCESS')
        {
            $("#page_content").html(result_ary[1]);
        }
        jQuery('#loader').attr('style','display:none');
    });
}
function resetInvoiceReportsAccountData()
{
    
    jQuery('#loader').attr('style','display:block');
    $.post(__SITE_JS_PATH__+"/ajax_reports.php",{mode:'__RESET_INVOICES_REPORTS_ACCOUNT_DATA__'},function(result){
        var result_ary = result.split("||||");
        if(result_ary[0]=='SUCCESS')
        {
            $("#page_content").html(result_ary[1]);
        }
        jQuery('#loader').attr('style','display:none');

    });
}

function printCreditReports()
{
    var value=jQuery("#searchInvoiceForm").serialize();
    var newvalue=value+"&mode=__PRINT_CREDIT_REPORTS__";
    jQuery('#loader_long').attr('style','display:block');
    jQuery.post(__SITE_JS_PATH__+"/ajax_reports.php",newvalue,function(result){
        var result_ary = result.split("||||");
        if(result_ary[0]=='SUCCESS')
        {
            jQuery('#loader_long').attr('style','display:none');
            var redirect_url_2 = __SITE_JS_PATH__+"/download_pdf_file.php?szFileName="+$.trim(result_ary[1])+"&reportName=CreditReport";
            console.log(redirect_url_2);
            redirect_url(redirect_url_2);
        }
    });
}
function printTotalCreditReports()
{
    var value=jQuery("#searchInvoiceForm").serialize();
    var newvalue=value+"&mode=__PRINT_CREDIT_TOTAL_REPORTS__";
    jQuery('#loader_long').attr('style','display:block');
    jQuery.post(__SITE_JS_PATH__+"/ajax_reports.php",newvalue,function(result){
        var result_ary = result.split("||||");
        if(result_ary[0]=='SUCCESS')
        {
            jQuery('#loader_long').attr('style','display:none');
            var redirect_url_2 = __SITE_JS_PATH__+"/download_pdf_file.php?szFileName="+$.trim(result_ary[1])+"&reportName=CreditTotalReport";
            console.log(redirect_url_2);
            redirect_url(redirect_url_2);
        }
    });
}

function getEmailClientSummery()
{
   
    var value=jQuery("#emailClientSummeryReport").serialize();
    var newvalue=value+"&mode=__GET_EMIAL_CLIENT_SUMMERY_REPORTS__";
    jQuery('#loader').attr('style','display:block');
    jQuery.post(__SITE_JS_PATH__+"/ajax_reports.php",newvalue,function(result){
        var result_ary = result.split("||||");
        if(result_ary[0]=='SUCCESS')
        {
            $("#page_content").html(result_ary[1]);
        }
        jQuery('#loader').attr('style','display:none');
    });
}
function resetEmailClientSummery()
{
    
    jQuery('#loader').attr('style','display:block');
    $.post(__SITE_JS_PATH__+"/ajax_reports.php",{mode:'__RESET_EMAIL_CLIENT_SUMMERY_REPORTS__'},function(result){
        var result_ary = result.split("||||");
        if(result_ary[0]=='SUCCESS')
        {
            $("#page_content").html(result_ary[1]);
        }
        jQuery('#loader').attr('style','display:none');

    });
}
function getClientAccountForSearchAccounttbl(clientId)
{
    jQuery('#loader').attr('style','display:block');
    $.post(__SITE_JS_PATH__+"/ajax_client.php",{mode:'__GET_CLIENT_ACCOUNT_FOR_SEARCH_ACCOUNT_TBL__',clientId:clientId},function(result){
        var result_ary = result.split("||||");
        if(result_ary[0]=='SUCCESS')
        {
            $("#client_accounts").html(result_ary[1]);
        }
        jQuery('#loader').attr('style','display:none');

    });
}
function printManagerReport()
{
    var value=jQuery("#managerReportForm").serialize();
    var newvalue=value+"&mode=__PRINT_MANAGER_REPORTS__";
    jQuery('#loader_long').attr('style','display:block');
    jQuery.post(__SITE_JS_PATH__+"/ajax_reports.php",newvalue,function(result){
        var result_ary = result.split("||||");
        if(result_ary[0]=='SUCCESS')
        {
            jQuery('#loader_long').attr('style','display:none');
            var redirect_url_2 = __SITE_JS_PATH__+"/download_pdf_file.php?szFileName="+$.trim(result_ary[1])+"&reportName=ManagerReport";
            console.log(redirect_url_2);
            redirect_url(redirect_url_2);
        }
    });
}

function printInvoiceReport()
{
    var value=jQuery("#invoiceReportForm").serialize();
    var newvalue=value+"&mode=__PRINT_INVOICE_REPORTS__";
    jQuery('#loader_long').attr('style','display:block');
    jQuery.post(__SITE_JS_PATH__+"/ajax_reports.php",newvalue,function(result){
        var result_ary = result.split("||||");
        if(result_ary[0]=='SUCCESS')
        {
            jQuery('#loader_long').attr('style','display:none');
            var redirect_url_2 = __SITE_JS_PATH__+"/download_pdf_file.php?szFileName="+$.trim(result_ary[1])+"&reportName=InvoiceReport";
            console.log(redirect_url_2);
            redirect_url(redirect_url_2);
        }
    });
}
function updateStatus(invoiceId,sessionKey)
{
   
     var value=jQuery("#updateStatusForm").serialize();
     var sortBy = $("#sortBy").val();
     var sortValue = $("#sortValue").val();
     var szSearchText = $("#szSearchText").val();
     var newvalue=value+"&mode=__UPDATE_STATUS__&invoiceId="+invoiceId+"&sortBy="+sortBy+"&sortValue="+sortValue+"&szSearchText="+szSearchText+"&sessionKey="+sessionKey;
    jQuery('#loader').attr('style','display:block');
    jQuery.post(__SITE_JS_PATH__+"/ajax_client.php",newvalue,function(result){
        var result_ary = result.split("||||");
        if(result_ary[0]=='SUCCESS')
        {
            $("#page_content").html(result_ary[1]);
            $('#update_Status').modal("show");
        }
        jQuery('#loader').attr('style','display:none');

    });
}

function saveInvoiceStatus(sessionKey)
{
    
    var value=jQuery("#updateStatusForm").serialize();
    var sortBy = $("#sortBy").val();
    var sortValue = $("#sortValue").val();
    var szSearchText = $("#szSearchText").val();
    var newvalue=value+"&mode=__SAVE_INVOICE_STATUS__&sortBy="+sortBy+"&sortValue="+sortValue+"&szSearchText="+szSearchText+"&sessionKey="+sessionKey;
  
    jQuery('#loader').attr('style','display:block');
    jQuery.post(__SITE_JS_PATH__+"/ajax_client.php",newvalue,function(result){
        var result_ary = result.split("||||");
        if(result_ary[0]=='SUCCESS')
        {
            $("#page_content").html(result_ary[1]);
            $('#update_Status').modal("hide");
            $('.modal-backdrop').remove();
            $('#confirmStatus').modal("show");
        }
        else if(result_ary[0]=='ERROR')
        {
            $("#page_content").html(result_ary[1]);
            $('#update_Status').modal("show");
        }
        jQuery('#loader').attr('style','display:none');
    });
}
function deleteRefundConfirmationPopUp(invoiceId,sessionKey)
{
   
    var newvalue="&mode=__DELETE_REFUND_CONFIRMATION_POP_UP__&invoiceId="+invoiceId+"&sessionKey="+sessionKey;
    
        jQuery.post(__SITE_JS_PATH__+"/ajax_client.php",newvalue,function(result){
        var result_ary = result.split("||||");
       
        if(result_ary[0]=='SUCCESS')
        {
            $("#page_content").html(result_ary[1]);
            $('#delete_popup').modal("show");
        }
        jQuery('#loader').attr('style','display:none');

    });
}

function showClaimer(confirmType)
{
    jQuery('#loader').attr('style','display:block');
    $.post(__SITE_JS_PATH__+"/ajax_client.php",{mode:'__ENABLE_CLAIMER__',confirmType:confirmType},function(result){
        var result_ary = result.split("||||");
        if ($('#dtCreditDate').val() != '')
        {
           var date=$('#dtCreditDate').val();
        }
        else
        {
            var date=result_ary[1];
        }
        if(result_ary[0]=='SUCCESS')
        {
            $( "#claimer_value" ).prop( "disabled", false );
            $( "#dtCreditDate" ).datepicker('setDate', date);
            $('#dtCreditDate').removeAttr("disabled");
            $('#claimer_value').focus();
        }
        else if(result_ary[0]=='ERROR')
        {
            $('#dtCreditDate').val('');
            $("#confirm_type_error").removeClass('hide');
            $("#confirm_type_error").html('This claimer does not exist in our system please choose another one.');
            $("#confirmType").parent('div').parent('div').addClass('has-error'); 
//            $( "#claimer_value" ).prop( "disabled", true );
//            $('#dtCreditDate').attr("disabled", "disabled");
        }
        jQuery('#loader').attr('style','display:none');

    });
}

function toggleLogo()
{
    $(".custom-logo").toggleClass('hide');
}

function printInvoiceReportWithAccountData()
{
    var value=jQuery("#invoiceReportsAccountData").serialize();
    var newvalue=value+"&mode=__PRINT_INVOICE_REPORT_WITH_ACCOUNT_DATA__";
    jQuery('#loader_long').attr('style','display:block');
    jQuery.post(__SITE_JS_PATH__+"/ajax_reports.php",newvalue,function(result){
        var result_ary = result.split("||||");
        if(result_ary[0]=='SUCCESS')
        {
            jQuery('#loader_long').attr('style','display:none');
            var redirect_url_2 = __SITE_JS_PATH__+"/download_pdf_file.php?szFileName="+$.trim(result_ary[1])+"&reportName=InvoiceReportWithAccountDataReport";
            console.log(redirect_url_2);
            redirect_url(redirect_url_2);
        }
    });
}
function printEmailClientSummery()
{
    var value=jQuery("#emailClientSummeryReport").serialize();
    //var trackingFlag = $("#iTrackingNo").val();
    var newvalue=value+"&mode=__PRINT_EMAIL_CLIENT_SUMMERY__";
    jQuery('#loader_long').attr('style','display:block');
    jQuery.post(__SITE_JS_PATH__+"/ajax_reports.php",newvalue,function(result){
        var result_ary = result.split("||||");
        if(result_ary[0]=='SUCCESS')
        {
            jQuery('#loader_long').attr('style','display:none');
            var redirect_url_2 = __SITE_JS_PATH__+"/download_pdf_file.php?szFileName="+$.trim(result_ary[1])+"&reportName=EmailClientSummeryReport";
            console.log(redirect_url_2);
            redirect_url(redirect_url_2);
        }
    });
}
function printInvoiceDetailRefundList(iInvoiceId)
{
    var szSearchText = $("#szSearchText").val();
    var newvalue="&mode=__PRINT_INVOICE_DETAIL_REFUND_LIST_DATA__&szSearchText="+szSearchText+"&iInvoiceId="+iInvoiceId;
    jQuery('#loader_long').attr('style','display:block');
    jQuery.post(__SITE_JS_PATH__+"/ajax_reports.php",newvalue,function(result){
        var result_ary = result.split("||||");
        if(result_ary[0]=='SUCCESS')
        {
            jQuery('#loader_long').attr('style','display:none');
            var redirect_url_2 = __SITE_JS_PATH__+"/download_pdf_file.php?szFileName="+$.trim(result_ary[1])+"&reportName=InvoiceDetailWithRefundList";
            console.log(redirect_url_2);
            redirect_url(redirect_url_2);
        }
    });
}
function invoiceEditRefundPage(page_url)
{
    var newvalue="&mode=__INVOICE_EDIT_REFUND_PAGE__";
    jQuery('#loader').attr('style','display:block');
    jQuery.post(__SITE_JS_PATH__+"/ajax_client.php",newvalue,function(result){
        var result_ary = result.split("||||");
        if(result_ary[0]=='SUCCESS')
        {
            window.location.href =page_url;
        }
    });
}
function getClientAccountForReportSearch(clientId)
{
    jQuery('#loader').attr('style','display:block');
    $.post(__SITE_JS_PATH__+"/ajax_client.php",{mode:'__GET_CLIENT_ACCOUNT_FOR_REPORT_SEARCH__',clientId:clientId},function(result){
        var result_ary = result.split("||||");
        if(result_ary[0]=='SUCCESS')
        {
            $("#client_accounts").html(result_ary[1]);
        }
        jQuery('#loader').attr('style','display:none');

    });
}


function getInvoicesForImport()
{
    var value=jQuery("#invoiceReportForm").serialize();
    var newvalue=value+"&mode=__GET_INVOICES_FOR_IMPORT__";
    jQuery('#loader').attr('style','display:block');
    jQuery.post(__SITE_JS_PATH__+"/ajax_reports.php",newvalue,function(result){
        var result_ary = result.split("||||");
        if(result_ary[0]=='SUCCESS')
        {
            $("#page_content").html(result_ary[1]);
        }
        jQuery('#loader').attr('style','display:none');
    });
}
function resetInvoicesImport()
{
    
    jQuery('#loader').attr('style','display:block');
    $.post(__SITE_JS_PATH__+"/ajax_reports.php",{mode:'__RESET_INVOICES_IMPORT_SEARCH__'},function(result){
        var result_ary = result.split("||||");
        if(result_ary[0]=='SUCCESS')
        {
            $("#page_content").html(result_ary[1]);
        }
        jQuery('#loader').attr('style','display:none');

    });
}

function importInvoicesToQuickBooks()
{
    var value=jQuery("#invoiceReportForm").serialize();
    var newvalue=value+"&mode=__IMPORT_INVOICES_TO_QUICKBOOKS__";
    jQuery('#loader').attr('style','display:block');
    jQuery.post(__SITE_JS_PATH__+"/ajax_reports.php",newvalue,function(result){
        var result_ary = result.split("||||");
        if(result_ary[0]=='SUCCESS')
        {
            $("#page_content").html(result_ary[1]);
            $('#importConfirmation').modal("show");
        }
        jQuery('#loader').attr('style','display:none');
    });
}

function emailClientSummery()
{
    var value=jQuery("#emailClientSummeryReport").serialize();
    var newvalue=value+"&mode=__SEND_CLIENT_SUMMARY_MODAL__";
    jQuery('#loader').attr('style','display:block');
    jQuery.post(__SITE_JS_PATH__+"/ajax_reports.php",newvalue,function(result){
        var result_ary = result.split("||||");
        if(result_ary[0]=='SUCCESS')
        {
            $("#page_content").html(result_ary[1]);
            $('#static').modal("show");
        }
        jQuery('#loader').attr('style','display:none');
    });
}

function sendClientSummary()
{
    var szEmail=$("#szEmail").val();
    var email_ary = szEmail.split(";");
    var error_flag;
    error_flag=false;
    if($.trim(szEmail)!='')
    {
        
        for (i = 0; i < email_ary.length; i++) 
        {
            var email = email_ary[i];
            if(email != '')
            {
                if(!isEmail(email))
                {
                    error_flag=true;
                }
            }
        }
        if(!error_flag)
        {
            var value=jQuery("#emailClientSummeryReport").serialize();
            var newvalue=value+"&mode=__SEND_EMAIL_CLIENT_SUMMARY__&szEmail="+szEmail;
            jQuery('#loader').attr('style','display:block');
            jQuery.post(__SITE_JS_PATH__+"/ajax_reports.php",newvalue,function(result){
                var result_ary = result.split("||||");
                if(result_ary[0]=='SUCCESS')
                {
                    $("#page_content").html(result_ary[1]);
                    $('.modal-backdrop').remove();
                    $('#email_confirmation').modal("show");
                }
                jQuery('#loader').attr('style','display:none');
            });
        }
        else
        {
            $("#email_error").html('One or more given Email address is not valid.');
            $("#email_error").parent('span').removeClass('hide');
            $("#szEmail").parent('div').parent('div').parent('div').addClass('has-error');
        }
    }
    else
    {
        $("#email_error").html('Email address is required.');
        $("#email_error").parent('span').removeClass('hide');
        $("#szEmail").parent('div').parent('div').parent('div').addClass('has-error');
    }
}

function isEmail(email) {
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(email);
}