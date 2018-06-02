function showMessege() {
    if ($('#remember-me').is(':checked')) {
        $('.login-info').show();
    } else {
        $('.login-info').hide();
    }
}


function closeClientStatusConfirmation() {
    $('#clientStatusConfirmation').modal("hide");
    $('.modal-backdrop').remove();
}
function open_me(h_rf) {
    window.open(h_rf, '_blank', 'width=400,height=350,toolbar=0,menubar=0,location=0,status=0,scrollbars=1,resizable=0,left=0,top=0');

    return false;
}


function openTaxDetails(pageUrl) {
    $("#pageUrl").val(pageUrl);
    $("#taxYearPopUp").attr('style', 'display:block');
    $('#taxYearStatus').modal("show");
}


function redirect_url(page_url) {
    if (page_url != '') {
        window.location = page_url;
    }
    else {
        return false;
    }
}
function ajaxKeyUpLogin(selector, event) {
    if (event.keyCode == '13') {
        userLogin();
    }
}

function userLogin() {
    $("#loginUser").submit();
}

function remove_formError(fieldId, addOnFlag) {
//    alert(fieldId);
    if (addOnFlag == 'true') {
        $("#" + fieldId).parent('div').parent('div').parent('div').removeClass('has-error');
    }
    else {
        $("#" + fieldId).parent('div').parent('div').removeClass('has-error');

    }
    $("#" + fieldId).parent('div').parent('div').children('.help-block').addClass('hide');
    $("#" + fieldId).parent('div').children('.help-block').addClass('hide');
}

function remove_formFieldError(fieldId) {
//    alert(fieldId);
    $("#" + fieldId).parent('div').removeClass('has-error');
    $("#" + fieldId).parent('div').children('.help-block').addClass('hide');
}
function remove_typeaheadError(fieldId) {
//    alert($("#"+fieldId).parent('span').parent('div').parent('div').attr('class'));
    $("#" + fieldId).parent('span').parent('div').parent('div').parent('div').removeClass('has-error');
    $("#" + fieldId).parent('span').parent('div').parent('div').children('.help-block').addClass('hide');
}

function open_forgot_password_form() {
    $(".forget-form").show();

    $(".login-form").hide();
}

function open_login_form() {
    $(".forget-form").hide();

    $(".login-form").show();
}

function forgot_password() {
    var szForgotEmail = $("#szForgotEmail").val();

    if (szForgotEmail == '') {
        $("#forgot_email_error").html("Email address is required");
        $("#forgot_email_error").parent('span').removeClass("hide");
        $("#szForgotEmail").parent('div').parent('div').addClass("has-error");
    }
    if (szForgotEmail != '') {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if (!regex.test(szForgotEmail)) {
            $("#forgot_email_error").html("Email address is not valid.");
            $("#forgot_email_error").parent('span').removeClass("hide");
            $("#szForgotEmail").parent('div').parent('div').addClass("has-error");
        }
        else {
            $.post(__SITE_JS_PATH__ + "/ajax_user.php", {
                mode: '__FORGOT_PASSWORD__',
                szForgotEmail: szForgotEmail
            }, function (result) {
                var result_ary = result.split("||||");
                if (result_ary[0] == 'SUCCESS') {
                    $("#szForgotEmail").val('');
                    open_login_form();
                    $("#forgot_success").removeClass("hide");
                }
                else if (result_ary[0] == 'ERROR') {
                    $("#forgot_email_error").html("The email address you entered is not registered with the system. Please try again.");
                    $("#forgot_email_error").parent('span').removeClass("hide");
                    $("#szForgotEmail").parent('div').parent('div').addClass("has-error");
                }

            });
        }
    }
}
function isEmail(email) {
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);
}
function getStateListingProfile(szCountry) {

    $.post(__BASE_URL__ + "/admin/getStatesByCountry", {szCountry: szCountry}, function (result) {
        if (result != '') {
            $("#state_container").html(result);
        }
    });
}
function getFranchiseeListing(operationManagerId) {

    $.post(__BASE_URL__ + "/admin/getFranchiseeByOperationManager", {operationManagerId: operationManagerId}, function (result) {
        if (result != '') {
            $("#franchisee_container").html(result);
        }
    });
}
function editFranchiseeDetails(idfranchisee, idOperationManager) {
    $.post(__BASE_URL__ + "/admin/editfranchiseedata", {
        idfranchisee: idfranchisee,
        idOperationManager: idOperationManager
    }, function (result) {
        ar_result = result.split('||||');
        window.location = __BASE_URL__ + "/admin/" + ar_result[1];

    });
}
function editProspectDetails(idProspect, flag) {
    $.post(__BASE_URL__ + "/prospect/editProspectData", {idProspect: idProspect, flag: flag}, function (result) {
        ar_result = result.split('||||');
        window.location = __BASE_URL__ + "/prospect/" + ar_result[1];

    });
}
function editOperationManagerDetails(idOperationManager, flag) {
    $.post(__BASE_URL__ + "/admin/editOperationManagerData", {
        idOperationManager: idOperationManager,
        flag: flag
    }, function (result) {
        ar_result = result.split('||||');
        window.location = __BASE_URL__ + "/admin/" + ar_result[1];

    });
}
function editForum(id) {
    $.post(__BASE_URL__ + "/forum/editForumData", {id: id}, function (result) {
        ar_result = result.split('||||');
        window.location = __BASE_URL__ + "/forum/" + ar_result[1];

    });
}
function addFranchiseeData(idOperationManager, flag) {

    $.post(__BASE_URL__ + "/admin/addFranchiseeData", {
        idOperationManager: idOperationManager,
        flag: flag
    }, function (result) {
        console.log(result);
        ar_result = result.split('||||');
        window.location = __BASE_URL__ + "/admin/" + ar_result[1];

    });
}
function addTopic(idForum) {

    $.post(__BASE_URL__ + "/forum/addTopicData", {idForum: idForum}, function (result) {
        ar_result = result.split('||||');
        window.location = __BASE_URL__ + "/forum/" + ar_result[1];

    });
}
function addForum(idCategory, flag) {

    $.post(__BASE_URL__ + "/forum/addForumData", {idCategory: idCategory, flag: flag}, function (result) {
        ar_result = result.split('||||');
        window.location = __BASE_URL__ + "/forum/" + ar_result[1];

    });
}
function franchiseeDelete(idfranchisee) {
    jQuery('#loader').attr('style', 'display:block');
    $.post(__BASE_URL__ + "/admin/deleteFranchiseeAlert", {idfranchisee: idfranchisee}, function (result) {
        var result_ary = result.split("||||");
        var res = result_ary[0].trim(" ");
        if (res == 'SUCCESS') {
            $("#popup_box").html(result_ary[1]);
            $('#clientStatus').modal("show");
        }
        jQuery('#loader').attr('style', 'display:none');

    });
}
function deleteFranchiseeConfirmation(idfranchisee) {

    $('.modal-backdrop').remove();
    $('#static').modal("hide");
    $('#clientStatus').modal("hide");
    jQuery('#loader').attr('style', 'display:block');
    $.post(__BASE_URL__ + "/admin/deleteFranchiseeConfirmation", {idfranchisee: idfranchisee}, function (result) {
        var result_ary = result.split("||||");
        var res = result_ary[0].trim(" ");
        if (res == 'SUCCESS') {
            $("#popup_box").html(result_ary[1]);
            $('#clientStatusConfirmation').modal("show");
        }
        jQuery('#loader').attr('style', 'display:none');

    });
}
function forumDeleteAlert(id) {
    jQuery('#loader').attr('style', 'display:block');
    $.post(__BASE_URL__ + "/forum/forumDeleteAlert", {id: id}, function (result) {
        var result_ary = result.split("||||");
        var res = result_ary[0].trim(" ");
        if (res == 'SUCCESS') {
            $("#popup_box").html(result_ary[1]);
            $('#forumStatus').modal("show");
        }
        jQuery('#loader').attr('style', 'display:none');

    });
}
function deleteForumConfirmation(id) {

    $('.modal-backdrop').remove();
    $('#static').modal("hide");
    $('#forumStatus').modal("hide");
    jQuery('#loader').attr('style', 'display:block');
    $.post(__BASE_URL__ + "/forum/deleteForumConfirmation", {id: id}, function (result) {
        var result_ary = result.split("||||");
        var res = result_ary[0].trim(" ");
        if (res == 'SUCCESS') {
            $("#popup_box").html(result_ary[1]);
            $('#forumStatusConfirmation').modal("show");
        }
        jQuery('#loader').attr('style', 'display:none');

    });
}
function operationManagerDelete(idOperationManager) {
    jQuery('#loader').attr('style', 'display:block');
    $.post(__BASE_URL__ + "/admin/deleteOperationManagerAlert", {idOperationManager: idOperationManager}, function (result) {
        var result_ary = result.split("||||");
        var res = result_ary[0].trim(" ");
        if (res == 'SUCCESS') {
            $("#popup_box").html(result_ary[1]);
            $('#operationManagerStatus').modal("show");
        }
        jQuery('#loader').attr('style', 'display:none');

    });
}
function deleteOperationManagerConfirmation(idOperationManager) {

    $('.modal-backdrop').remove();
    $('#static').modal("hide");
    $('#operationManagerStatus').modal("hide");
    jQuery('#loader').attr('style', 'display:block');
    $.post(__BASE_URL__ + "/admin/deleteOperationManagerConfirmation", {idOperationManager: idOperationManager}, function (result) {
        var result_ary = result.split("||||");
        var res = result_ary[0].trim(" ");
        if (res == 'SUCCESS') {
            $("#popup_box").html(result_ary[1]);
            $('#operationManagerStatusConfirmation').modal("show");
        }
        jQuery('#loader').attr('style', 'display:none');

    });
}
function viewFrStockAssignList(flag) {

    $.post(__BASE_URL__ + "/reporting/frstockassignlistData", {flag: flag}, function (result) {
        ar_result = result.split('||||');
        window.location = __BASE_URL__ + "/reporting/" + ar_result[1];

    });
}
function viewstockreqlistData(flag) {

    $.post(__BASE_URL__ + "/reporting/allstockreqlistData", {flag: flag}, function (result) {
        ar_result = result.split('||||');
        window.location = __BASE_URL__ + "/reporting/" + ar_result[1];

    });
}
function viewStockAssignList(flag) {

    $.post(__BASE_URL__ + "/reporting/stockassignlistData", {flag: flag}, function (result) {
        ar_result = result.split('||||');
        window.location = __BASE_URL__ + "/reporting/" + ar_result[1];

    });
}

function viewForm(flag) {

    $.post(__BASE_URL__ + "/formManagement/viewFormData", {flag: flag}, function (result) {
        ar_result = result.split('||||');
        window.location = __BASE_URL__ + "/formManagement/" + ar_result[1];

    });
}
function viewForum(idForum) {

    $.post(__BASE_URL__ + "/forum/viewForumListData", {idForum: idForum}, function (result) {
        ar_result = result.split('||||');
        window.location = __BASE_URL__ + "/forum/" + ar_result[1];

    });
}
function viewTopicDetails(idTopic, idForum) {

    $.post(__BASE_URL__ + "/forum/viewTopicData", {idTopic: idTopic, idForum: idForum}, function (result) {
        ar_result = result.split('||||');
        window.location = __BASE_URL__ + "/forum/" + ar_result[1];

    });
}
function viewForumDetails(idCategory) {

    $.post(__BASE_URL__ + "/forum/viewForumData", {idCategory: idCategory}, function (result) {
        ar_result = result.split('||||');
        window.location = __BASE_URL__ + "/forum/" + ar_result[1];

    });
}
function viewClient(idfranchisee) {

    $.post(__BASE_URL__ + "/franchisee/viewClientData", {idfranchisee: idfranchisee}, function (result) {
        ar_result = result.split('||||');
        window.location = __BASE_URL__ + "/franchisee/" + ar_result[1];

    });
}
function viewFranchisee(idOperationManager) {

    $.post(__BASE_URL__ + "/franchisee/viewFranchiseeData", {idOperationManager: idOperationManager}, function (result) {
        ar_result = result.split('||||');
        window.location = __BASE_URL__ + "/franchisee/" + ar_result[1];

    });
}


function addClientData(idfranchisee, idclient, url, flag) {
    if (idclient == undefined || idclient == null) {
        idclient = 0;
    }
    $.post(__BASE_URL__ + "/franchisee/addClientData", {
        idfranchisee: idfranchisee,
        idclient: idclient,
        url: url,
        flag: flag
    }, function (result) {
        ar_result = result.split('||||');
        window.location = __BASE_URL__ + "/franchisee/" + ar_result[1];

    });
}
function clientDelete(idClient, url, flag) {
    jQuery('#loader').attr('style', 'display:block');
    $.post(__BASE_URL__ + "/franchisee/deleteClientAlert", {
        idClient: idClient,
        url: url,
        flag: flag
    }, function (result) {
        var result_ary = result.split("||||");
        var res = result_ary[0].trim(" ");
        if (res == 'SUCCESS') {
            $("#popup_box").html(result_ary[1]);
            $('#clientStatus').modal("show");
        }
        jQuery('#loader').attr('style', 'display:none');

    });
}
function deleteClientConfirmation(idClient, flag) {

    $('.modal-backdrop').remove();
    $('#static').modal("hide");
    $('#clientStatus').modal("hide");
    jQuery('#loader').attr('style', 'display:block');
    $.post(__BASE_URL__ + "/franchisee/deleteClientConfirmation", {idClient: idClient, flag: flag}, function (result) {
        var result_ary = result.split("||||");
        var res = result_ary[0].trim(" ");
        if (res == 'SUCCESS') {
            $("#popup_box").html(result_ary[1]);
            $('#clientStatusConfirmation').modal("show");
        }
        jQuery('#loader').attr('style', 'display:none');

    });
}

function getParenDetails(franchiseeId, clientType) {

    $.post(__BASE_URL__ + "/franchisee/getParentClient", {
        franchiseeId: franchiseeId,
        clientType: clientType
    }, function (result) {
        if (result != '') {
            if (clientType == "1") {
                $("#parenitIdedit").remove();
                $(result).insertAfter("#clientType");

            }
        }
        else {
            $("#parentId").remove();
            $("#parenitIdedit").remove();
        }
    });
}
function getStateListingProfileclient(szCountry) {
    $.post(__BASE_URL__ + "/franchisee/getStatesByCountryClient", {szCountry: szCountry}, function (result) {
        if (result != '') {
            $("#state_container").html(result);
        }
    });
}
function viewClientDetails(idClient, idfranchisee, corpclient,flag) {
  
    if (!corpclient) {
        corpclient = 0;
    }
    $.post(__BASE_URL__ + "/franchisee/viewClientDetailsData", {
        idClient: idClient,
        idfranchisee: idfranchisee,
         corpclient: corpclient,
         flag: flag
    }, function (result) {
        ar_result = result.split('||||');
        window.location = __BASE_URL__ + "/franchisee/" + ar_result[1];

    });
}

function editClient(idClient, idfranchisee, url, flag) {

    $.post(__BASE_URL__ + "/franchisee/editClientData", {
        idClient: idClient,
        idfranchisee: idfranchisee,
        url: url,
        flag: flag,
    }, function (result) {

        ar_result = result.split('||||');

        window.location = __BASE_URL__ + "/franchisee/" + ar_result[1];

    });
}
function productDeleteAlert(idProduct, flag) {
    jQuery('#loader').attr('style', 'display:block');
    $.post(__BASE_URL__ + "/inventory/deleteProductAlert", {idProduct: idProduct, flag: flag}, function (result) {
        var result_ary = result.split("||||");
        var res = result_ary[0].trim(" ");
        if (res == 'SUCCESS') {
            $("#popup_box").html(result_ary[1]);
            $('#productStatus').modal("show");
        }
        jQuery('#loader').attr('style', 'display:none');

    });
}
function deleteProductConfirmation(idProduct, flag) {

    $('.modal-backdrop').remove();
    $('#static').modal("hide");
    $('#productStatus').modal("hide");
    jQuery('#loader').attr('style', 'display:block');
    $.post(__BASE_URL__ + "/inventory/deleteProductConfirmation", {
        idProduct: idProduct,
        flag: flag
    }, function (result) {
        var result_ary = result.split("||||");
        var res = result_ary[0].trim(" ");
        if (res == 'SUCCESS') {
            $("#popup_box").html(result_ary[1]);
            $('#productStatusConfirmation').modal("show");
        }
        jQuery('#loader').attr('style', 'display:none');

    });
}
function deleteCategoryAlert(idCategory) {
    jQuery('#loader').attr('style', 'display:block');
    $.post(__BASE_URL__ + "/forum/deleteCategoryAlert", {idCategory: idCategory}, function (result) {
        var result_ary = result.split("||||");
        var res = result_ary[0].trim(" ");
        if (res == 'SUCCESS') {
            $("#popup_box").html(result_ary[1]);
            $('#CategoryStatus').modal("show");
        }
        jQuery('#loader').attr('style', 'display:none');

    });
}
function deleteCategoryConfirmation(idCategory) {

    $('.modal-backdrop').remove();
    $('#static').modal("hide");
    $('#CategoryStatus').modal("hide");
    jQuery('#loader').attr('style', 'display:block');
    $.post(__BASE_URL__ + "/forum/deleteCategoryConfirmation", {idCategory: idCategory}, function (result) {
        var result_ary = result.split("||||");
        var res = result_ary[0].trim(" ");
        if (res == 'SUCCESS') {
            $("#popup_box").html(result_ary[1]);
            $('#categoryStatusConfirmation').modal("show");
        }
        jQuery('#loader').attr('style', 'display:none');

    });
}
function replyToCmntsAlert(idCmnt) {
    jQuery('#loader').attr('style', 'display:block');
    $.post(__BASE_URL__ + "/forum/replyToCmnt", {idCmnt: idCmnt}, function (result) {
        var result_ary = result.split("||||");
        var res = result_ary[0].trim(" ");
        if (res == 'SUCCESS') {
            $("#popup_box").html(result_ary[1]);
            $('#replyStatus').modal("show");
        }
        jQuery('#loader').attr('style', 'display:none');

    });
}
function replyToCmntConfirmation(idCmnt) {
    var val = jQuery('#szReply').val();

    $('.modal-backdrop').remove();
    $('#static').modal("hide");
    $('#replyStatus').modal("hide");
    jQuery('#loader').attr('style', 'display:block');
    $.post(__BASE_URL__ + "/forum/replyToCmntConfirmation", {val: val, idCmnt: idCmnt}, function (result) {
        var result_ary = result.split("||||");
        var res = result_ary[0].trim(" ");
        if (res == 'SUCCESS') {
            $("#popup_box").html(result_ary[1]);
            $('#replyStatusConfirmation').modal("show");
        }
        jQuery('#loader').attr('style', 'display:none');

    });
}
function editProduct(idProduct, flag) {
    $.post(__BASE_URL__ + "/inventory/editProductData", {
        idProduct: idProduct, flag: flag

    }, function (result) {

        ar_result = result.split('||||');

        window.location = __BASE_URL__ + "/inventory/" + ar_result[1];

    });
}
function editCategory(idCategory) {
    $.post(__BASE_URL__ + "/forum/editCategoryData", {
        idCategory: idCategory

    }, function (result) {

        ar_result = result.split('||||');

        window.location = __BASE_URL__ + "/forum/" + ar_result[1];

    });
}

function editMarketingDetails(idProduct, flag) {


    $.post(__BASE_URL__ + "/inventory/editMarketingData", {
        idProduct: idProduct, flag: flag

    }, function (result) {

        ar_result = result.split('||||');

        window.location = __BASE_URL__ + "/inventory/" + ar_result[1];

    });
}


function viewModelStockValMgt(idfranchisee) {

    $.post(__BASE_URL__ + "/stock_management/ModelStock", {idfranchisee: idfranchisee}, function (result) {
        ar_result = result.split('||||');
        window.location = __BASE_URL__ + "/stock_management/" + ar_result[1];
    });
}


function addModelStockValue(idProduct) {

    $.post(__BASE_URL__ + "/stock_management/addModelStock", {idProduct: idProduct}, function (result) {
        ar_result = result.split('||||');
        window.location = __BASE_URL__ + "/stock_management/" + ar_result[1];


    });
}

function getProductListing(szProductCategory) {

    $.post(__BASE_URL__ + "/stock_management/getProductsByCategory", {szProductCategory: szProductCategory}, function (result) {
        if (result != '') {
            $("#product_container").html(result);
        }
    });
}
function editModelStockValue(idProduct) {

    $.post(__BASE_URL__ + "/stock_management/editModelStock", {idProduct: idProduct}, function (result) {
        ar_result = result.split('||||');
        window.location = __BASE_URL__ + "/stock_management/" + ar_result[1];


    });
}
function viewProductStockMgt(idfranchisee) {
    $.post(__BASE_URL__ + "/stock_management/productStock", {idfranchisee: idfranchisee}, function (result) {
        ar_result = result.split('||||');

        if ($.trim(ar_result[0]) == "SUCCESS") {
            window.location = __BASE_URL__ + "/stock_management/" + ar_result[1];

        }
    });
}
function addProductStockQuantity(idProduct) {

    $.post(__BASE_URL__ + "/stock_management/addProductStock", {idProduct: idProduct}, function (result) {
        ar_result = result.split('||||');
        window.location = __BASE_URL__ + "/stock_management/" + ar_result[1];


    });
}
function editProductStockQuantity(idProduct, flag) {

    $.post(__BASE_URL__ + "/stock_management/editProductStock", {idProduct: idProduct, flag: flag}, function (result) {
        ar_result = result.split('||||');
        window.location = __BASE_URL__ + "/stock_management/" + ar_result[1];


    });
}
function requestQuantityAlert(idProduct, flag) {
    jQuery('#loader').attr('style', 'display:block');
    $.post(__BASE_URL__ + "/stock_management/quantityRequestAlert", {
        idProduct: idProduct,
        flag: flag
    }, function (result) {
        var result_ary = result.split("||||");
        var res = result_ary[0].trim(" ");
        if (res == 'SUCCESS') {
            $("#popup_box").html(result_ary[1]);
            $('#requestQuantityStatus').modal("show");
            jQuery('#loader').attr('style', 'display:none');
        }


    });
}
function requestQuantityConfirmation(idProduct, flag) {

    var value = jQuery("#requestQuantityForm").serialize();
    var newValue = value + "&idProduct=" + idProduct + "&flag=" + flag;

    $('.modal-backdrop').remove();
    $('#static').modal("hide");
    $('#requestQuantityStatus').modal("hide");
    jQuery('#loader').attr('style', 'display:block');
    $.post(__BASE_URL__ + "/stock_management/quantityRequestConfirmation", newValue, function (result) {
        var result_ary = result.split("||||");
        var res = result_ary[0].trim(" ");
        if (res == 'SUCCESS') {
            $("#popup_box").html(result_ary[1]);
            $('#requestQuantityStatusConfirmation').modal("show");
            jQuery('#loader').attr('style', 'display:none');
        } else {
            $("#popup_box").html(result);
            $('#requestQuantityStatus').modal("show");
            jQuery('#loader').attr('style', 'display:block');
        }


    });
}
function allotReqQtyAlert(idProduct, szReqQuantity) {

    jQuery('#loader').attr('style', 'display:block');
    $.post(__BASE_URL__ + "/stock_management/allotReqQtyAlert", {
        idProduct: idProduct,
        szReqQuantity: szReqQuantity
    }, function (result) {
        var result_ary = result.split("||||");
        var res = result_ary[0].trim(" ");
        if (res == 'SUCCESS') {
            $("#popup_box").html(result_ary[1]);
            $('#allotQuantityStatus').modal("show");
            jQuery('#loader').attr('style', 'display:none');
        }


    });
}

function ViewReqProductList(idfranchisee) {
    $.post(__BASE_URL__ + "/stock_management/viewproductlistData", {idfranchisee: idfranchisee}, function (result) {
        ar_result = result.split('||||');
        window.location = __BASE_URL__ + "/stock_management/" + ar_result[1];

    });
}
function ViewSosFormPdf(idClient, idsite) {
    $.post(__BASE_URL__ + "/formManagement/ViewSosFormPdfData", {
        idClient: idClient,
        idsite: idsite
    }, function (result) {
        ar_result = result.split('||||');
        var URL = __BASE_URL__ + "/formManagement/" + ar_result[1];
        window.open(URL, '_blank');

    });
}
function ViewDonorDetails(idsos) {
    $.post(__BASE_URL__ + "/formManagement/ViewDonorDetailsData", {idsos: idsos}, function (result) {
        ar_result = result.split('||||');
        window.location = __BASE_URL__ + "/formManagement/" + ar_result[1];


    });
}
function viewCocForm(idcoc, idsos) {
    $.post(__BASE_URL__ + "/formManagement/ViewCocFormData", {idcoc: idcoc, idsos: idsos}, function (result) {
        ar_result = result.split('||||');
        window.location = __BASE_URL__ + "/formManagement/" + ar_result[1];


    });
}


function showHideTextbox(id) {
    if (id == 0) {
        jQuery('#text').attr('style', 'display:none');
    }
    else if (id == 1) {
        jQuery('#text').attr('style', 'display:none');
    }
    else if (id == 2) {
        jQuery('#text').attr('style', 'display:block');
    }
}
function showHideTextboxForCalc() {
    var val = jQuery('#travelType').val();
    if (val == 1 || val == 2) {
        jQuery('#text').attr('style', 'display:block');
    } else {
        jQuery('#text').attr('style', 'display:none');
    }
}

function viewSosFormDetails(idClient, idsite) {
    $.post(__BASE_URL__ + "/formManagement/sosFormsdata", {idClient: idClient, idsite: idsite}, function (result) {
        ar_result = result.split('||||');
        window.location = __BASE_URL__ + "/formManagement/" + ar_result[1];

    });
}
function editConsumables(idProduct, flag) {
    $.post(__BASE_URL__ + "/inventory/editConsumablesData", {
        idProduct: idProduct, flag: flag

    }, function (result) {

        ar_result = result.split('||||');

        window.location = __BASE_URL__ + "/inventory/" + ar_result[1];

    });
}
function calcombinetotalprice(id1, id2, mintime, showlabid) {
    var baseprice = $('#' + id1).val();
    var totaltime = $('#' + id2).val();
    var finalprice = 0;
    if (totaltime >= mintime) {
        finalprice = parseFloat(baseprice) * parseFloat(totaltime);
    } else {
        finalprice = parseFloat(baseprice) * parseFloat(mintime);
    }
    $('#' + showlabid).html('$' + parseFloat(finalprice).toFixed(2));
}
function calTotalFCO() {
    var Val1 = jQuery('#FCOBasePrice').val();
    var Val2 = jQuery('#FCOHr').val();
    var res = Val1 * Val2;

    jQuery('#FCOTotal').html(res);
}
function calTotal() {
    var Val1 = jQuery('#mobileScreenBasePrice').val();
    var Val2 = jQuery('#mobileScreenHr').val();
    var res = Val1 * Val2;

    jQuery('#mobileScreen').html(res);
}
function calTotalCallOut() {
    var Val1 = jQuery('#CallOutBasePrice').val();
    var Val2 = jQuery('#CallOutHr').val();
    var res = Val1 * Val2;

    jQuery('#CallOutTotal').html(res);
}
function calTotalDC() {
    var Val1 = jQuery('#DCmobileScreenBasePrice').val();
    var Val2 = jQuery('#DCmobileScreenHr').val();
    var res = Val1 * Val2;

    jQuery('#DCmobileScreenTotal').html(res);
}
function calTotalTravel() {

    var Val1 = jQuery('#travelBasePrice').val();
    var Val2 = jQuery('#travelHr').val();
    var res = Val1 * Val2;

    jQuery('#travel').html(res);
}
function viewCalcform(idsite, Drugtestid, sosid) {

    $.post(__BASE_URL__ + "/ordering/viewcalform", {
        idsite: idsite,
        Drugtestid: Drugtestid,
        sosid: sosid
    }, function (result) {
        ar_result = result.split('||||');
        window.location = __BASE_URL__ + "/ordering/" + ar_result[1];

    });

}

function calOtherDrugPrice(ele,donorCount) {
    var totalVal = parseFloat($(ele).val()) * parseInt(donorCount);
    $('#otherdrugVal').html('$'+(totalVal>0?parseFloat(totalVal).toFixed(2):'0.00'));
}

function editCalcForm(idsite, Drugtestid, sosid, manualCalId) {

    $.post(__BASE_URL__ + "/ordering/editCalcForm", {
        idsite: idsite,
        Drugtestid: Drugtestid,
        sosid: sosid,
        manualCalId: manualCalId
    }, function (result) {
        ar_result = result.split('||||');
        window.location = __BASE_URL__ + "/ordering/" + ar_result[1];

    });

}
function viewCalcDetails(idsite, Drugtestid, sosid) {

    $.post(__BASE_URL__ + "/ordering/viewCalc", {
        idsite: idsite,
        Drugtestid: Drugtestid,
        sosid: sosid
    }, function (result) {
        ar_result = result.split('||||');
        window.location = __BASE_URL__ + "/ordering/" + ar_result[1];

    });

}
function showTopic(idTopic) {

    jQuery('#loader').attr('style', 'display:block');
    $.post(__BASE_URL__ + "/forum/showTopicData", {idTopic: idTopic,}, function (result) {
        var result_ary = result.split("||||");
        var res = result_ary[0].trim(" ");
        if (res == 'SUCCESS') {
            $("#popup_box").html(result_ary[1]);
            $('#showTopic').modal("show");
            jQuery('#loader').attr('style', 'display:none');
        }


    });
}
function showReply(idReply) {

    jQuery('#loader').attr('style', 'display:block');
    $.post(__BASE_URL__ + "/forum/showReplyData", {idReply: idReply,}, function (result) {
        var result_ary = result.split("||||");
        var res = result_ary[0].trim(" ");
        if (res == 'SUCCESS') {
            $("#popup_box").html(result_ary[1]);
            $('#showReply').modal("show");
            jQuery('#loader').attr('style', 'display:none');
        }


    });
}
function approveReply(idReply) {
    jQuery('#loader').attr('style', 'display:block');
    $.post(__BASE_URL__ + "/forum/approveReplyAlert", {idReply: idReply,}, function (result) {
        var result_ary = result.split("||||");
        var res = result_ary[0].trim(" ");
        if (res == 'SUCCESS') {
            $("#popup_box").html(result_ary[1]);
            $('#approveReplyAlert').modal("show");
            jQuery('#loader').attr('style', 'display:none');
        }


    });
}
function approveReplyConfirmation(idReply) {

    $('.modal-backdrop').remove();
    $('#static').modal("hide");
    $('#approveReplyAlert').modal("hide");
    jQuery('#loader').attr('style', 'display:block');
    $.post(__BASE_URL__ + "/forum/approveReplyConfirmation", {idReply: idReply}, function (result) {
        var result_ary = result.split("||||");
        var res = result_ary[0].trim(" ");
        if (res == 'SUCCESS') {
            $("#popup_box").html(result_ary[1]);
            $('#approveReplyConfirmation').modal("show");
        }
        jQuery('#loader').attr('style', 'display:none');

    });
}
function unapproveReply(idReply) {
    jQuery('#loader').attr('style', 'display:block');
    $.post(__BASE_URL__ + "/forum/unapproveReplyAlert", {idReply: idReply,}, function (result) {
        var result_ary = result.split("||||");
        var res = result_ary[0].trim(" ");
        if (res == 'SUCCESS') {
            $("#popup_box").html(result_ary[1]);
            $('#unapproveReplyAlert').modal("show");
            jQuery('#loader').attr('style', 'display:none');
        }


    });
}
function unapproveReplyConfirmation(idReply) {

    $('.modal-backdrop').remove();
    $('#static').modal("hide");
    $('#approveReplyAlert').modal("hide");
    jQuery('#loader').attr('style', 'display:block');
    $.post(__BASE_URL__ + "/forum/unapproveReplyConfirmation", {idReply: idReply}, function (result) {
        var result_ary = result.split("||||");
        var res = result_ary[0].trim(" ");
        if (res == 'SUCCESS') {
            $("#popup_box").html(result_ary[1]);
            $('#unapproveReplyConfirmation').modal("show");
        }
        jQuery('#loader').attr('style', 'display:none');

    });
}

function replyDelete(idReply) {
    jQuery('#loader').attr('style', 'display:block');
    $.post(__BASE_URL__ + "/forum/replyDeleteAlert", {idReply: idReply}, function (result) {
        var result_ary = result.split("||||");
        var res = result_ary[0].trim(" ");
        if (res == 'SUCCESS') {
            $("#popup_box").html(result_ary[1]);
            $('#replyDelete').modal("show");
        }
        jQuery('#loader').attr('style', 'display:none');

    });
}
function replyDeleteConfirmation(idReply) {

    $('.modal-backdrop').remove();
    $('#static').modal("hide");
    $('#replyDelete').modal("hide");
    jQuery('#loader').attr('style', 'display:block');
    $.post(__BASE_URL__ + "/forum/replyDeleteConfirmation", {idReply: idReply}, function (result) {
        var result_ary = result.split("||||");
        var res = result_ary[0].trim(" ");
        if (res == 'SUCCESS') {
            $("#popup_box").html(result_ary[1]);
            $('#replyDeleteConfirmation').modal("show");
        }
        jQuery('#loader').attr('style', 'display:none');

    });
}
function cmntDelete(idCmnt) {
    jQuery('#loader').attr('style', 'display:block');
    $.post(__BASE_URL__ + "/forum/cmntDeleteAlert", {idCmnt: idCmnt}, function (result) {
        var result_ary = result.split("||||");
        var res = result_ary[0].trim(" ");
        if (res == 'SUCCESS') {
            $("#popup_box").html(result_ary[1]);
            $('#cmntDelete').modal("show");
        }
        jQuery('#loader').attr('style', 'display:none');

    });
}
function cmntDeleteConfirmation(idCmnt) {

    $('.modal-backdrop').remove();
    $('#static').modal("hide");
    $('#cmntDelete').modal("hide");
    jQuery('#loader').attr('style', 'display:block');
    $.post(__BASE_URL__ + "/forum/cmntDeleteConfirmation", {idCmnt: idCmnt}, function (result) {
        var result_ary = result.split("||||");
        var res = result_ary[0].trim(" ");
        if (res == 'SUCCESS') {
            $("#popup_box").html(result_ary[1]);
            $('#cmntDeleteConfirmation').modal("show");
        }
        jQuery('#loader').attr('style', 'display:none');

    });
}
function closeTopic(idTopic) {
    jQuery('#loader').attr('style', 'display:block');
    $.post(__BASE_URL__ + "/forum/closeTopicAlert", {idTopic: idTopic}, function (result) {
        var result_ary = result.split("||||");
        var res = result_ary[0].trim(" ");
        if (res == 'SUCCESS') {
            $("#popup_box").html(result_ary[1]);
            $('#closeTopic').modal("show");
        }
        jQuery('#loader').attr('style', 'display:none');

    });
}
function closeTopicConfirmation(idTopic) {
    $('.modal-backdrop').remove();
    $('#static').modal("hide");
    $('#closeTopic').modal("hide");
    jQuery('#loader').attr('style', 'display:block');
    $.post(__BASE_URL__ + "/forum/closeTopicConfirmationData", {idTopic: idTopic}, function (result) {
        var result_ary = result.split("||||");
        var res = result_ary[0].trim(" ");
        if (res == 'SUCCESS') {
            $("#popup_box").html(result_ary[1]);
            $('#closeTopicConfirmation').modal("show");
        }
        jQuery('#loader').attr('style', 'display:none');

    });
}
function replyEditAlert(idReply) {
    jQuery('#loader').attr('style', 'display:block');
    $.post(__BASE_URL__ + "/forum/replyEditData", {idReply: idReply}, function (result) {
        var result_ary = result.split("||||");
        var res = result_ary[0].trim(" ");
        if (res == 'SUCCESS') {
            $("#popup_box").html(result_ary[1]);
            $('#replyEdit').modal("show");
        }
        jQuery('#loader').attr('style', 'display:none');

    });
}
function replyEditConfirmation(idReply) {
    var val = jQuery('#szReply').val();
    $('.modal-backdrop').remove();
    $('#static').modal("hide");
    $('#replyEdit').modal("hide");
    jQuery('#loader').attr('style', 'display:block');
    $.post(__BASE_URL__ + "/forum/replyEditConfirmation", {idReply: idReply, val: val}, function (result) {
        var result_ary = result.split("||||");
        var res = result_ary[0].trim(" ");
        if (res == 'SUCCESS') {
            $("#popup_box").html(result_ary[1]);
            $('#replyEditConfirmation').modal("show");
        }
        jQuery('#loader').attr('style', 'display:none');

    });
}

function assignReportingPdf(franchiseeName, productCode, flag) {
    $.post(__BASE_URL__ + "/reporting/ViewAssignReportingPdfData", {
        franchiseeName: franchiseeName,
        productCode: productCode,
        flag: flag
    }, function (result) {
        ar_result = result.split('||||');
        var URL = __BASE_URL__ + "/reporting/" + ar_result[1];
        window.open(URL, '_blank');

    });
}
function ReqReportingPdf(franchiseeName, productCode) {
    $.post(__BASE_URL__ + "/reporting/ViewReqReportingPdfData", {
        franchiseeName: franchiseeName,
        productCode: productCode
    }, function (result) {
        ar_result = result.split('||||');
        var URL = __BASE_URL__ + "/reporting/" + ar_result[1];
        window.open(URL, '_blank');

    });
}
function stockassignexcellist(franchiseeName, productCode) {
    $.post(__BASE_URL__ + "/reporting/excelstockassignlistData", {
        franchiseeName: franchiseeName,
        productCode: productCode
    }, function (result) {
        ar_result = result.split('||||');
        var URL = __BASE_URL__ + "/reporting/" + ar_result[1];
        window.open(URL, '_blank');


    });
}
function stockreqexcellist(franchiseeName, productCode) {
    $.post(__BASE_URL__ + "/reporting/excelstockreqlistData", {
        franchiseeName: franchiseeName,
        productCode: productCode
    }, function (result) {
        ar_result = result.split('||||');
        var URL = __BASE_URL__ + "/reporting/" + ar_result[1];
        window.open(URL, '_blank');


    });
}
function view_pdf_fr_stockassignlist(productCode) {
    $.post(__BASE_URL__ + "/reporting/pdf_fr_stockassignlist_Data", {productCode: productCode}, function (result) {
        ar_result = result.split('||||');
        var URL = __BASE_URL__ + "/reporting/" + ar_result[1];
        window.open(URL, '_blank');

    });
}
function view_excelfr_stockassignlist(productCode) {
    $.post(__BASE_URL__ + "/reporting/excelfr_stockassignlist_Data", {productCode: productCode}, function (result) {
        ar_result = result.split('||||');
        var URL = __BASE_URL__ + "/reporting/" + ar_result[1];
        window.open(URL, '_blank');


    });
}
function Viewpdffrstockreqlist(productCode) {
    $.post(__BASE_URL__ + "/reporting/pdffrstockreqlistData", {productCode: productCode}, function (result) {
        ar_result = result.split('||||');
        var URL = __BASE_URL__ + "/reporting/" + ar_result[1];
        window.open(URL, '_blank');

    });
}
function Viewexcelfrstockreqlist(productCode) {
    $.post(__BASE_URL__ + "/reporting/excelfrstockreqlistData", {productCode: productCode}, function (result) {
        ar_result = result.split('||||');
        var URL = __BASE_URL__ + "/reporting/" + ar_result[1];
        window.open(URL, '_blank');


    });
}
function calcDetailspdf(idsite, Drugtestid, sosid) {
    $.post(__BASE_URL__ + "/ordering/calcDetailspdf", {
        idsite: idsite,
        Drugtestid: Drugtestid,
        sosid: sosid
    }, function (result) {
        ar_result = result.split('||||');
        var URL = __BASE_URL__ + "/ordering/" + ar_result[1];
        window.open(URL, '_blank');

    });
}
function backSiteRecord(freanchId) {

    $.post(__BASE_URL__ + "/ordering/siteRecordpage", {freanchId: freanchId}, function (result) {
        ar_result = result.split('||||');
        window.location = __BASE_URL__ + "/ordering/" + ar_result[1];

    });

}
function commentEditAlert(idComment) {
    jQuery('#loader').attr('style', 'display:block');
    $.post(__BASE_URL__ + "/forum/commentEditData", {idComment: idComment}, function (result) {
        var result_ary = result.split("||||");
        var res = result_ary[0].trim(" ");
        if (res == 'SUCCESS') {
            $("#popup_box").html(result_ary[1]);
            $('#commentEdit').modal("show");
        }
        jQuery('#loader').attr('style', 'display:none');

    });
}
function commentEditConfirmation(idComment) {
    var val = CKEDITOR.instances.szComment.getData();

    $('.modal-backdrop').remove();
    $('#static').modal("hide");
    $('#commentEdit').modal("hide");
    jQuery('#loader').attr('style', 'display:block');
    $.post(__BASE_URL__ + "/forum/commentEditConfirmation", {idComment: idComment, val: val}, function (result) {

        var result_ary = result.split("||||");
        var res = result_ary[0].trim(" ");
        if (res == 'SUCCESS') {
            $("#popup_box").html(result_ary[1]);
            $('#commentEditConfirmation').modal("show");
        }
        jQuery('#loader').attr('style', 'display:none');
    });
}


function approveTopic(idTopic) {
    jQuery('#loader').attr('style', 'display:block');
    $.post(__BASE_URL__ + "/forum/approveTopicAlert", {idTopic: idTopic,}, function (result) {
        var result_ary = result.split("||||");
        var res = result_ary[0].trim(" ");
        if (res == 'SUCCESS') {
            $("#popup_box").html(result_ary[1]);
            $('#approveTopicAlert').modal("show");
            jQuery('#loader').attr('style', 'display:none');
        }


    });
}
function approveTopicConfirmation(idTopic) {

    $('.modal-backdrop').remove();
    $('#static').modal("hide");
    $('#approveTopicAlert').modal("hide");
    jQuery('#loader').attr('style', 'display:block');
    $.post(__BASE_URL__ + "/forum/approveTopicConfirmation", {idTopic: idTopic}, function (result) {
        var result_ary = result.split("||||");
        var res = result_ary[0].trim(" ");
        if (res == 'SUCCESS') {
            $("#popup_box").html(result_ary[1]);
            $('#approveTopicConfirmation').modal("show");
        }
        jQuery('#loader').attr('style', 'display:none');

    });
}
function unapproveTopic(idTopic) {
    jQuery('#loader').attr('style', 'display:block');
    $.post(__BASE_URL__ + "/forum/unapproveTopicAlert", {idTopic: idTopic,}, function (result) {
        var result_ary = result.split("||||");
        var res = result_ary[0].trim(" ");
        if (res == 'SUCCESS') {
            $("#popup_box").html(result_ary[1]);
            $('#unapproveTopicAlert').modal("show");
            jQuery('#loader').attr('style', 'display:none');
        }


    });
}
function unapproveTopicConfirmation(idTopic) {

    $('.modal-backdrop').remove();
    $('#static').modal("hide");
    $('#unapproveTopicAlert').modal("hide");
    jQuery('#loader').attr('style', 'display:block');
    $.post(__BASE_URL__ + "/forum/unapproveTopicConfirmation", {idTopic: idTopic}, function (result) {
        var result_ary = result.split("||||");
        var res = result_ary[0].trim(" ");
        if (res == 'SUCCESS') {
            $("#popup_box").html(result_ary[1]);
            $('#unapproveTopicConfirmation').modal("show");
        }
        jQuery('#loader').attr('style', 'display:none');

    });
}

function deleteTopicDetails(idTopic) {
    jQuery('#loader').attr('style', 'display:block');
    $.post(__BASE_URL__ + "/forum/deleteTopicAlert", {idTopic: idTopic}, function (result) {
        var result_ary = result.split("||||");
        var res = result_ary[0].trim(" ");
        if (res == 'SUCCESS') {
            $("#popup_box").html(result_ary[1]);
            $('#deleteTopic').modal("show");
        }
        jQuery('#loader').attr('style', 'display:none');

    });
}
function topicDeleteConfirmation(idTopic) {

    jQuery('#loader').attr('style', 'display:block');
    $.post(__BASE_URL__ + "/forum/topicDeleteConfirmation", {idTopic: idTopic}, function (result) {
        var result_ary = result.split("||||");
        var res = result_ary[0].trim(" ");
        if (res == 'SUCCESS') {
            $("#popup_box").html(result_ary[1]);
            $('#topicDeleteConfirmation').modal("show");
        }
        jQuery('#loader').attr('style', 'display:none');

    });
}

function placeOrder(idProduct, inc, flag) {
    var val = $("#order_quantity" + inc).val();
    $.post(__BASE_URL__ + "/order/placeOrderData", {idProduct: idProduct, val: val, flag: flag}, function (result) {
        ar_result = result.split('||||');
        if (ar_result[0] == 'SUCCESS') {
            placeOrderConfirmation();
        }
        if (ar_result[0] == 'ERROR') {
            placeOrderErrorConfirmation(ar_result[2]);
        }

    });
}
function placeOrderConfirmation() {
    jQuery('#loader').attr('style', 'display:block');
    $.post(__BASE_URL__ + "/order/placeOrder", function (result) {
        var result_ary = result.split("||||");
        var res = result_ary[0].trim(" ");
        if (res == 'SUCCESS') {
            $("#popup_box").html(result_ary[1]);
            $('#orderplaceconfirmation').modal("show");
        }
        jQuery('#loader').attr('style', 'display:none');

    });
}
function placeOrderErrorConfirmation(qty,prodname) {
    if(!prodname){
        prodname = '';
    }
    jQuery('#loader').attr('style', 'display:block');
    $.post(__BASE_URL__ + "/order/placeOrderErrorConfirmation",{qty: qty, prodname: prodname}, function (result) {
        var result_ary = result.split("||||");
        var res = result_ary[0].trim(" ");
        if (res == 'SUCCESS') {
            $("#popup_box").html(result_ary[1]);
            $('#placeOrderErrorConfirmation').modal("show");
        }
        jQuery('#loader').attr('style', 'display:none');

    });
}

function DeleteOrder(idOrder) {
    jQuery('#loader').attr('style', 'display:block');
    $.post(__BASE_URL__ + "/order/DeleteOrderAlert", {idOrder: idOrder}, function (result) {
        var result_ary = result.split("||||");
        var res = result_ary[0].trim(" ");
        if (res == 'SUCCESS') {
            $("#popup_box").html(result_ary[1]);
            $('#DeleteOrder').modal("show");
        }
        jQuery('#loader').attr('style', 'display:none');

    });
}
function DeleteOrderConfirmation(idOrder) {
    $('.modal-backdrop').remove();
    $('#static').modal("hide");
    $('#DeleteOrder').modal("hide");
    jQuery('#loader').attr('style', 'display:block');
    $.post(__BASE_URL__ + "/order/OrderDeleteConfirmation", {idOrder: idOrder}, function (result) {
        var result_ary = result.split("||||");
        var res = result_ary[0].trim(" ");
        if (res == 'SUCCESS') {
            $("#popup_box").html(result_ary[1]);
            $('#DeleteOrderConfirmation').modal("show");
        }
        jQuery('#loader').attr('style', 'display:none');

    });
}
function checkOutOrder(idfranchisee, prodcount) {
    var check = 0;
    var prodname = '';
    for (var j = 1; j <= prodcount; j++) {
        var qty = $('#order_quantity' + j).val();
        var minqty = $('#min_prod_quantity' + j).val();
        prodname = $('#prod_code' + j).val();


        if (parseInt(qty) < parseInt(minqty)) {
            check = 1;
            break;
        }
    }
   
    if (check == 1) {
        placeOrderErrorConfirmation(minqty,prodname);
    }
    else {
        $.post(__BASE_URL__ + "/order/checkOutOrderData", {idfranchisee: idfranchisee}, function (result) {
            ar_result = result.split('||||');

            window.location = __BASE_URL__ + "/order/" + ar_result[1];

        });
    }
}
function view_order_details(idOrder, flag) {

    jQuery('#loader').attr('style', 'display:block');
    $.post(__BASE_URL__ + "/order/viewOrderData", {idOrder: idOrder, flag: flag}, function (result) {
        var result_ary = result.split("||||");
        var res = result_ary[0].trim(" ");
        if (res == 'SUCCESS') {
            $("#popup_box").html(result_ary[1]);
            $('#viewOrder').modal("show");
            jQuery('#loader').attr('style', 'display:none');
        }


    });
}
function edit_order_details(idOrder,flag) {
    jQuery('#loader').attr('style', 'display:block');
    $.post(__BASE_URL__ + "/order/editOrderData", {idOrder: idOrder,flag: flag}, function (result) {
        var result_ary = result.split("||||");
        var res = result_ary[0].trim(" ");
        if (res == 'SUCCESS') {
            $("#popup_box").html(result_ary[1]);
            $('#editOrder').modal("show");
            jQuery('#loader').attr('style', 'display:none');
        }

    });
}
function CancelOrderConfirmation(idOrder) {
    
     var startDate = jQuery('#szSearch4').val();
     var endDate = jQuery('#szSearch5').val();
     var frName = jQuery('#szSearch1').val();
     var orderNo = jQuery('#szSearch2').val();

   
   
    jQuery('#loader').attr('style', 'display:block');
    $.post(__BASE_URL__ + "/order/cancelOrderConfirmation", {idOrder: idOrder,startDate: startDate,endDate: endDate,frName: frName,orderNo: orderNo}, function (result) {
       
       var result_ary = result.split("||||"); 
         if (result_ary[0] == 'SUCCESS')
        {
            $('.modal-backdrop').remove();
            $('#static').modal("hide");
            $('#editOrder').modal("hide");
            jQuery('#popup_box').html(result_ary[1]);
            jQuery('#cancelOrderConfirmation').modal("show");
           
            jQuery("#table_content_data").html(result_ary[2]);
        }
     
        jQuery('#loader').attr('style', 'display:none');

    });
}

function changeordstatus(ordid, prodcount, status) {

     var startDate = jQuery('#szSearch4').val();
     var endDate = jQuery('#szSearch5').val();
     var frName = jQuery('#szSearch1').val();
     var orderNo = jQuery('#szSearch2').val();



    var counter = 0;
    var check = 0;
    var nonchangeable = 0;
    var freightPrice = $('#freightprice').val();
    if (status == '1') {
        calTotalPrice();
        $('.err').hide();
        for (var j = 1; j <= prodcount; j++) {
            if (!$('#order_quantity' + j).val()) {
                $('#orddiperr' + j).html('Dispatch quantity must be greater than 0.');
                $('#orddiperr' + j).show();
                return false;
            }
        }
    }
    var proceedcounter = 0;
    for (var k = 1; k <= prodcount; k++) {
        if (validatedispprod(k)) {
            proceedcounter++;
        } else {
            return false;
        }
    }
    if (prodcount == proceedcounter) {
        $('#loader').attr('style', 'display:block');
        for (var i = 1; i <= prodcount; i++) {
            var isdispid = $('#isdispid' + i).val();
            if (isdispid == '0') {
                if ($('#order_quantity' + i).val() > 0) {
                    counter++;
                    var prodid = $('#ordprodid' + i).val();
                    var qty = $('#order_quantity' + i).val();
                    var RemainingQty = $('#remainingQty' + i).val();
                    $.post(__BASE_URL__ + "/order/dispatchsingleprod", {
                        ordid: ordid,
                        prodid: prodid,
                        qty: qty,
                        RemainingQty: RemainingQty,
                        freightPrice : freightPrice
                    }, function (result) {
                        if (result == 'SUCCESS') {
                            check++;
                        } else {
                            $('#loader').attr('style', 'display:none');
                            alert('Something went wrong. Please try again.');
                            return false;
                        }
                    });
                }
            } else {
                $('#loader').attr('style', 'display:block');
                nonchangeable++;
            }
        }
    }

    setTimeout(function () {
        if (status == '1') {
            $('#loader').attr('style', 'display:block');
            if ((check == counter) || (nonchangeable == prodcount)) {
                var price = $('#totalprice').val();
                $.post(__BASE_URL__ + "/order/dispatchfinal", {
                    ordid: ordid,
                    price: price,
                    freightPrice:freightPrice,
                    startDate: startDate,
                    endDate: endDate,
                    frName: frName,
                    orderNo: orderNo
                }, function (result) {
                    var result_ary = result.split("||||"); 
                    if (result_ary[0] == 'SUCCESS')
                   {
                        $('.modal-backdrop').remove();
                        $('#static').modal("hide");
                        $('#loader').attr('style', 'display:none');
                        $("#popup_box").html(result_ary[1]);
                        $('#editOrder').modal("hide");
                        $('#dispatchprodsucess').modal("show");
                        jQuery("#table_content_data").html(result_ary[2]);
                    }
                });
            }
        } else if (status == '0') {
            if ((check == counter) || (nonchangeable == prodcount)) {
                $.post(__BASE_URL__ + "/order/dispatchpending", {
                    ordid: ordid
                }, function (result) {
                    var result_ary = result.split("||||");
                    var res = result_ary[0].trim(" ");
                    if (res == 'SUCCESS') {
                        $('#loader').attr('style', 'display:none');
                        $("#popup_box").html(result_ary[1]);
                        $('#editOrder').modal("hide");
                        $('#orderstatchanged').modal("show");
                    }
                });
            }
        }
    }, 1000);
}

function validatedispprod(id) {
    var ordqtyid = $('#ordqtyid' + id).val();
    var availqtyafterdisid = $('#availqtyafterdisid' + id).val();
    var availqtyid = $('#availqtyid' + id).val();
    var dispatch_quantity = $('#order_quantity' + id).val();
    var isdispid = $('#isdispid' + id).val();
    var RemainingQty = $('#remainingQty' + id).val();
    if (dispatch_quantity > 0 && isdispid == '0') {
        if (parseInt(dispatch_quantity) > parseInt(ordqtyid)) {
            $('#orddiperr' + id).html('Dispatch quantity must be less than or equal to ordered quantity.');
            $('#orddiperr' + id).show();
            return false;
        } else if (parseInt(dispatch_quantity) > parseInt(RemainingQty)) {
            $('#orddiperr' + id).html('Dispatch quantity must be less than or equal to non-dispatched ordered quantity i.e. '+RemainingQty);
            $('#orddiperr' + id).show();
            return false;
        }
         else if (parseInt(availqtyafterdisid) != parseInt(availqtyid)) {
             if(parseInt(dispatch_quantity) > parseInt(availqtyafterdisid)){
            $('#orddiperr' + id).html('Dispatch quantity must be less than or equal to available after dispatch quantity i.e. '+availqtyafterdisid);
            $('#orddiperr' + id).show();
            return false;
             }
             else{
              return true;      
             }
        }
        else if (parseInt(dispatch_quantity) > parseInt(availqtyid)) {
            $('#orddiperr' + id).html('Dispatch quantity must be less than or equal to available quantity.');
            $('#orddiperr' + id).show();
            return false;
        } else {
            $('#orddiperr' + id).hide();
            return true;
        }
    } else {
        return true;
    }
}

function deliverOrderConfirmation(idOrder) {
    $('.modal-backdrop').remove();
    $('#static').modal("hide");
    $('#editOrder').modal("hide");
    jQuery('#loader').attr('style', 'display:block');
    $.post(__BASE_URL__ + "/order/deliverOrderConfirmation", {idOrder: idOrder}, function (result) {
        var result_ary = result.split("||||");
        var res = result_ary[0].trim(" ");
        if (res == 'SUCCESS') {
            $("#popup_box").html(result_ary[1]);
            $('#deliverOrderConfirmation').modal("show");
        }
        jQuery('#loader').attr('style', 'display:none');

    });
}

function view_order_details_pdf(idOrder, flag) {
    $.post(__BASE_URL__ + "/order/view_order_details", {idOrder: idOrder, flag: flag}, function (result) {
        ar_result = result.split('||||');
        var URL = __BASE_URL__ + "/order/" + ar_result[1];
        window.open(URL, '_blank');

    });
}
function calTotalPrice() {

    var totalprodcount = $('#totalprodcount').val();
    var total = 0.00;
    for (var i = 1; i <= totalprodcount; i++) {
        var pertotal = 0.00;
        var ordqtyval = ($('#order_quantity' + i).val() ? $('#order_quantity' + i).val() : 0);
        var ordprodprice = ($('#order_prod_price' + i).val() ? $('#order_prod_price' + i).val() : 0.00);
        //if($('#order_quantity'+i).val()){
        var prodqty = parseInt(ordqtyval);
        var prodprice = parseFloat(ordprodprice).toFixed(2);
        pertotal = (prodprice * prodqty);
        total = total + (prodprice * prodqty);
        $('#total_price' + i).html('$' + parseFloat(pertotal).toFixed(2));
        //}
    }
    var freightPrice = $('#freightprice').val();
    if(freightPrice<=0){
        freightPrice = 0.00;
    }
    total = (parseFloat(total) + parseFloat(freightPrice));
    $('#finaltotal').html('$' + parseFloat(total).toFixed(2));
    $('#totalprice').val(parseFloat(total).toFixed(2));
}

function getProductCodeListByCategory(szCategory) {
    $.post(__BASE_URL__ + "/reporting/getProductCodeListByCategory", {szCategory: szCategory}, function (result) {
        if (result != '') {
            $("#szProductCode").empty();
            $("#szProductCode").html(result);
            $("#szSearch3").customselect();
        }
    });
}

function ViewpdfFrInventoryReport(prodCategory, productCode) {
    $.post(__BASE_URL__ + "/reporting/ViewpdfFrInventoryReportData", {
        prodCategory: prodCategory,
        productCode: productCode
    }, function (result) {
        ar_result = result.split('||||');
        var URL = __BASE_URL__ + "/reporting/" + ar_result[1];
        window.open(URL, '_blank');

    });
}
function ViewexcelFrInventoryReport(prodCategory, productCode) {
    $.post(__BASE_URL__ + "/reporting/ViewexcelFrInventoryReportData", {
        prodCategory: prodCategory,
        productCode: productCode
    }, function (result) {
        ar_result = result.split('||||');
        var URL = __BASE_URL__ + "/reporting/" + ar_result[1];
        window.open(URL, '_blank');


    });
}

function ViewpdfInventoryReport(franchiseeId, prodCategory, productCode) {
    $.post(__BASE_URL__ + "/reporting/ViewpdfInventoryReportData", {
        franchiseeId: franchiseeId,
        prodCategory: prodCategory,
        productCode: productCode
    }, function (result) {
        ar_result = result.split('||||');
        var URL = __BASE_URL__ + "/reporting/" + ar_result[1];
        window.open(URL, '_blank');

    });
}
function ViewexcelInventoryReport(franchiseeId, prodCategory, productCode) {
    $.post(__BASE_URL__ + "/reporting/ViewexcelInventoryReportData", {
        franchiseeId: franchiseeId,
        prodCategory: prodCategory,
        productCode: productCode
    }, function (result) {
        ar_result = result.split('||||');
        var URL = __BASE_URL__ + "/reporting/" + ar_result[1];
        window.open(URL, '_blank');


    });
}
function addAgentEmployeeDetails(idclient, flag) {

    $.post(__BASE_URL__ + "/franchisee/addAgentEmployeeData", {idclient: idclient, flag: flag}, function (result) {
        ar_result = result.split('||||');
        window.location = __BASE_URL__ + "/franchisee/" + ar_result[1];

    });
}
function editAgentEmployeeDetails(idAgent) {

    $.post(__BASE_URL__ + "/franchisee/editAgentEmployeeData", {
        idAgent: idAgent
    }, function (result) {

        ar_result = result.split('||||');

        window.location = __BASE_URL__ + "/franchisee/" + ar_result[1];

    });
}
function viewClientAgentDetails(idClient, flag) {

    $.post(__BASE_URL__ + "/franchisee/viewClientAgentDetailsData", {
        idClient: idClient,
        flag: flag,
    }, function (result) {

        ar_result = result.split('||||');

        window.location = __BASE_URL__ + "/franchisee/" + ar_result[1];

    });
}
function agentDelete(id_agent) {
    jQuery('#loader').attr('style', 'display:block');
    $.post(__BASE_URL__ + "/franchisee/agentDeleteAlert", {id_agent: id_agent}, function (result) {
        var result_ary = result.split("||||");
        var res = result_ary[0].trim(" ");
        if (res == 'SUCCESS') {
            $("#popup_box").html(result_ary[1]);
            $('#agentStatus').modal("show");
        }
        jQuery('#loader').attr('style', 'display:none');

    });
}
function agentDeleteConfirmation(id_agent) {

    $('.modal-backdrop').remove();
    $('#static').modal("hide");
    $('#agentStatus').modal("hide");
    jQuery('#loader').attr('style', 'display:block');
    $.post(__BASE_URL__ + "/franchisee/agentDeleteConfirmation", {id_agent: id_agent}, function (result) {
        var result_ary = result.split("||||");
        var res = result_ary[0].trim(" ");
        if (res == 'SUCCESS') {
            $("#popup_box").html(result_ary[1]);
            $('#agentStatusConfirmation').modal("show");
        }
        jQuery('#loader').attr('style', 'display:none');

    });
}
function viewAgentEmployeeDetails(idAgent) {

    $.post(__BASE_URL__ + "/franchisee/viewAgentEmployeeDetailsData", {
        idAgent: idAgent,
    }, function (result) {

        ar_result = result.split('||||');

        window.location = __BASE_URL__ + "/franchisee/" + ar_result[1];

    });
}
function ViewpdfOrderReport(szSearch1, szSearch2, szSearch4, szSearch5) {
    $.post(__BASE_URL__ + "/reporting/ViewpdfOrderReportData", {
        szSearch1: szSearch1,
        szSearch2: szSearch2,
        szSearch4: szSearch4,
        szSearch5: szSearch5
    }, function (result) {
        ar_result = result.split('||||');
        var URL = __BASE_URL__ + "/reporting/" + ar_result[1];
        window.open(URL, '_blank');

    });
}
function ViewexcelOrderReport(szSearch1, szSearch2, szSearch4, szSearch5) {
    $.post(__BASE_URL__ + "/reporting/ViewexcelOrderReportData", {
        szSearch1: szSearch1,
        szSearch2: szSearch2,
        szSearch4: szSearch4,
        szSearch5: szSearch5
    }, function (result) {
        ar_result = result.split('||||');
        var URL = __BASE_URL__ + "/reporting/" + ar_result[1];
        window.open(URL, '_blank');


    });
}
function ViewpdfRevenueGenerate(dtStart, dtEnd, szFranchisee) {
    $.post(__BASE_URL__ + "/reporting/ViewpdfofRevenueGenerate", {
        dtStart: dtStart,
        dtEnd: dtEnd,
        szFranchisee: szFranchisee
    }, function (result) {
        ar_result = result.split('||||');
        var URL = __BASE_URL__ + "/reporting/" + ar_result[1];
        window.open(URL, '_blank');

    });
}
function ViewexcelRevenueGenerate(dtStart, dtEnd, szFranchisee) {
    $.post(__BASE_URL__ + "/reporting/ViewexcelofRevenueGenerate", {
        dtStart: dtStart,
        dtEnd: dtEnd,
        szFranchisee: szFranchisee
    }, function (result) {
        ar_result = result.split('||||');
        var URL = __BASE_URL__ + "/reporting/" + ar_result[1];
        window.open(URL, '_blank');


    });
}
function ViewpdfRevenueSummery(dtStart, dtEnd) {
    $.post(__BASE_URL__ + "/reporting/ViewpdfofRevenueSummery", {dtStart: dtStart, dtEnd: dtEnd}, function (result) {
        ar_result = result.split('||||');
        var URL = __BASE_URL__ + "/reporting/" + ar_result[1];
        window.open(URL, '_blank');

    });
}
function ViewexcelRevenueSummery(dtStart, dtEnd) {
    $.post(__BASE_URL__ + "/reporting/ViewexcelofRevenueSummery", {dtStart: dtStart, dtEnd: dtEnd}, function (result) {
        ar_result = result.split('||||');
        var URL = __BASE_URL__ + "/reporting/" + ar_result[1];
        window.open(URL, '_blank');


    });

}
function industryReportPdf(dtStart, dtEnd, szIndustry, szTestType) {

    $.post(__BASE_URL__ + "/reporting/industryReportPdf", {
        dtStart: dtStart,
        dtEnd: dtEnd,
        szIndustry: szIndustry,
        szTestType: szTestType
    }, function (result) {
        ar_result = result.split('||||');
        var URL = __BASE_URL__ + "/reporting/" + ar_result[1];
        window.open(URL, '_blank');

    });
}
function industryReportXls(dtStart, dtEnd, szIndustry, szTestType) {
    $.post(__BASE_URL__ + "/reporting/industryReportOfXls", {
        dtStart: dtStart,
        dtEnd: dtEnd,
        szIndustry: szIndustry,
        szTestType: szTestType
    }, function (result) {
        ar_result = result.split('||||');
        var URL = __BASE_URL__ + "/reporting/" + ar_result[1];
        window.open(URL, '_blank');
    });

}
function getClientListByFrIdData(idFranchisee, idclient, idsite) {
    if (idFranchisee > 0) {
        $.post(__BASE_URL__ + "/reporting/getClientListByFrId", {
            idFranchisee: idFranchisee,
            idclient: idclient,
            idsite: idsite
        }, function (result) {
            if (result != '') {
                $("#clientname").empty();
                $("#clientname").html(result);
                $("#sitename").empty();
                $("#sitename").html('<select class="form-control custom-select" name="szSearch3" id="szSearch3" onfocus="remove_formError(this.id,\'true\')"><option value="">Company Name/site</option></select>');
                $("#szSearch2").customselect();
                $("#szSearch3").customselect();
            }
        });
    } else {
        $("#clientname").empty();
        $("#clientname").html('<select class="form-control custom-select" name="szSearch2" id="szSearch2" onfocus="remove_formError(this.id,\'true\')"><option value="">Client Name</option></select>');
        $("#sitename").empty();
        $("#sitename").html('<select class="form-control custom-select" name="szSearch3" id="szSearch3" onfocus="remove_formError(this.id,\'true\')"><option value="">Company Name/site</option></select>');
        $("#szSearch2").customselect();
        $("#szSearch3").customselect();
    }
}
function getSiteListByClientIdData(idClient, idsite, franchiseeid) {
    if (idClient > 0) {
        $.post(__BASE_URL__ + "/reporting/getSiteListByClientId", {
            idClient: idClient,
            idsite: idsite,
            franchiseeid: franchiseeid
        }, function (result) {
            if (result != '') {
                $("#sitename").empty();
                $("#sitename").html(result);
                $("#szSearch3").customselect();
            }
        });
    } else {
        $("#sitename").empty();
        $("#sitename").html('<select class="form-control custom-select" name="szSearch3" id="szSearch3" onfocus="remove_formError(this.id,\'true\')"><option value="">Company Name/site</option></select>');
        $("#szSearch3").customselect();
    }
}
function comparisonReportPdf(siteid, testtype, comparetype) {
    $.post(__BASE_URL__ + "/reporting/comparisonReportPdf", {
        siteid: siteid,
        testtype: testtype,
        comparetype: comparetype
    }, function (result) {
        ar_result = result.split('||||');
        var URL = __BASE_URL__ + "/reporting/" + ar_result[1];
        window.open(URL, '_blank');

    });
}
function comparisonReportXls(siteid, testtype, comparetype) {
    $.post(__BASE_URL__ + "/reporting/comparisonReportOfXls", {
        siteid: siteid,
        testtype: testtype,
        comparetype: comparetype
    }, function (result) {
        ar_result = result.split('||||');
        var URL = __BASE_URL__ + "/reporting/" + ar_result[1];
        window.open(URL, '_blank');
    });

}

function getClientListByFrId(idFranchisee) {
    $.post(__BASE_URL__ + "/franchisee/getClientListByFrIdData", {idFranchisee: idFranchisee}, function (result) {
        if (result != '') {
            $("#szClient").empty();
            $("#szClient").html(result);
            $("#szSearchClientname").customselect();
        }
    });
}
function getProspectListByFrId(idFranchisee) {
    $.post(__BASE_URL__ + "/prospect/getProspecttListByFrIdData", {idFranchisee: idFranchisee}, function (result) {
        if (result != '') {
            $("#szClient").empty();
            $("#szClient").html(result);
            $("#szSearch1").customselect();
        }
    });
}
function assignClientAgent(agentId) {
    jQuery('#loader').attr('style', 'display:block');
    $.post(__BASE_URL__ + "/franchisee/assignClientAgent", {agentId: agentId}, function (result) {
        var result_ary = result.split("||||");
        var res = result_ary[0].trim(" ");
        if (res == 'SUCCESS') {
            $("#popup_box").html(result_ary[1]);
            $('#assignClientPopupform').modal("show");
        }
        jQuery('#loader').attr('style', 'display:none');

    });
}

function unassignclient(agentclientid) {
    jQuery('#loader').attr('style', 'display:block');
    $.post(__BASE_URL__ + "/franchisee/unassignclient", {agentclientid: agentclientid}, function (result) {
        var result_ary = result.split("||||");
        var res = result_ary[0].trim(" ");
        if (res == 'SUCCESS') {
            $("#popup_box_level1").html(result_ary[1]);
            $('#unassignclient').modal("show");
        }
        jQuery('#loader').attr('style', 'display:none');

    });
}
function confirmedUnassign(id) {
    jQuery('#loader').attr('style', 'display:block');
    $.post(__BASE_URL__ + "/franchisee/confirmedUnassign", {id: id}, function (result) {
        var result_ary = result.split("||||");
        var res = result_ary[0].trim(" ");
        if (res == 'SUCCESS') {
            $('#unassignclient').modal('hide');
            $('.modal-backdrop').remove();
            $("#popup_box_level1").empty();
            $("#popup_box_level1").html(result_ary[1]);
            $('#confirmedUnassign').modal("show");
        }
        jQuery('#loader').attr('style', 'display:none');

    });
}
function assignClientConfirmation(idAgent) {
    var value = jQuery("#assignClient").serialize();
    var newValue = value + "&idAgent=" + idAgent;
    jQuery('#loader').attr('style', 'display:block');
    $.post(__BASE_URL__ + "/franchisee/assignClientAgentConfirmation", newValue, function (result) {

        var result_ary = result.split("||||");
        var res = result_ary[0].trim(" ");
        if (res == 'SUCCESS') {
            $("#popup_box_level1").html(result_ary[1]);
            $('#clientAgentStatusConfirmation').modal("show");
            jQuery('#loader').attr('style', 'display:none');
        } else {
            $("#popup_box").html(result);
            $('#assignClientPopupform').modal("show");
            jQuery('#loader').attr('style', 'display:block');
        }


    });
}
function agentEmployeeDelete(agentId) {
    jQuery('#loader').attr('style', 'display:block');
    $.post(__BASE_URL__ + "/franchisee/deleteAgentEmployeeAlert", {agentId: agentId}, function (result) {
        var result_ary = result.split("||||");
        var res = result_ary[0].trim(" ");
        if (res == 'SUCCESS') {
            $("#popup_box").html(result_ary[1]);
            $('#agetDelete').modal("show");
        }
        jQuery('#loader').attr('style', 'display:none');

    });
}
function agentEmployeeDeleteConfirmation(agentId) {

    $('.modal-backdrop').remove();
    $('#static').modal("hide");
    $('#agetDelete').modal("hide");
    jQuery('#loader').attr('style', 'display:block');
    $.post(__BASE_URL__ + "/franchisee/deleteAgentEmployeeConfirmation", {agentId: agentId}, function (result) {
        var result_ary = result.split("||||");
        var res = result_ary[0].trim(" ");
        if (res == 'SUCCESS') {
            $("#popup_box").html(result_ary[1]);
            $('#agetDeleteConfirmation').modal("show");
        }
        jQuery('#loader').attr('style', 'display:none');

    });
}
function getReginolCode(stateId) {
    if (stateId > 0) {
        $.post(__BASE_URL__ + "/admin/getReginolCode", {stateId: stateId}, function (result) {
            if (result != '') {
                $("#reginolFiled").empty();
                $("#reginolFiled").html(result);
            }
        });
    }
    else {
        $("#reginolFiled").empty();
    }
}

function getAllReginolCode(stateId, error, regionid) {
    if (stateId > 0) {
        $.post(__BASE_URL__ + "/admin/getAllReginolCode", {
            stateId: stateId,
            error: error,
            regionid: regionid
        }, function (result) {
            if (result != '') {
                $("#reginolFiled").empty();
                $("#reginolFiled").html(result);
            }
        });
    }
    else {
        $("#reginolFiled").empty();
    }
}

function getAllReginolCodeForAgent(stateId, error, regionid) {
    if (stateId > 0) {
        $.post(__BASE_URL__ + "/admin/getAllReginolCodeForAgent", {
            stateId: stateId,
            error: error,
            regionid: regionid
        }, function (result) {
            if (result != '') {
                $("#reginolFiled").empty();
                $("#reginolFiled").html(result);
            }
        });
    }
    else {
        $("#reginolFiled").empty();
    }
}

function addRegionCode(stateId) {

    if (stateId > 0) {
        $.post(__BASE_URL__ + "/admin/addRegionCode", {stateId: stateId}, function (result) {
            if (result != '') {
                $("#Region").empty();
                $("#Region").html(result);
            }
        });
    }
    else {
        $("#Region").empty();
    }

}
function editRegionCode(stateId) {

    if (stateId > 0) {
        $.post(__BASE_URL__ + "/admin/editRegionCode", {stateId: stateId}, function (result) {
            if (result != '') {
                $("#Region").empty();
                $("#Region").html(result);
            }
        });
    }
    else {
        $("#Region").empty();
    }

}
function editRegionDetails(idRegion) {

    $.post(__BASE_URL__ + "/admin/editRegionDetails", {idRegion: idRegion}, function (result) {
        ar_result = result.split('||||');
        window.location = __BASE_URL__ + "/admin/" + ar_result[1];

    });
}
function regionDelete(regionId) {
    jQuery('#loader').attr('style', 'display:block');
    $.post(__BASE_URL__ + "/admin/regionDeleteeAlert", {regionId: regionId}, function (result) {
        var result_ary = result.split("||||");
        var res = result_ary[0].trim(" ");
        if (res == 'SUCCESS') {
            $("#popup_box").html(result_ary[1]);
            $('#regionDelete').modal("show");
        }
        jQuery('#loader').attr('style', 'display:none');

    });
}
function regionDeleteConfirmation(regionId) {

    $('.modal-backdrop').remove();
    $('#static').modal("hide");
    $('#regionDelete').modal("hide");
    jQuery('#loader').attr('style', 'display:block');
    $.post(__BASE_URL__ + "/admin/deleteRegionConfirmation", {regionId: regionId}, function (result) {
        var result_ary = result.split("||||");
        var res = result_ary[0].trim(" ");
        if (res == 'SUCCESS') {
            $("#popup_box").html(result_ary[1]);
            $('#regionDeleteConfirmation').modal("show");
        }
        jQuery('#loader').attr('style', 'display:none');

    });
}
function franchiseeStatus(idfranchisee, status) {

    jQuery('#loader').attr('style', 'display:block');
    $.post(__BASE_URL__ + "/admin/franchiseeStatus", {idfranchisee: idfranchisee, status: status}, function (result) {
        var result_ary = result.split("||||");
        var res = result_ary[0].trim(" ");
        if (res == 'SUCCESS') {
            $("#popup_box").html(result_ary[1]);
            $('#franchiseeStatus').modal("show");
        }
        jQuery('#loader').attr('style', 'display:none');

    });
}
function franchiseeStatusConfirmation(idfranchisee, status) {

    $('.modal-backdrop').remove();
    $('#static').modal("hide");
    $('#franchiseeStatus').modal("hide");
    jQuery('#loader').attr('style', 'display:block');
    $.post(__BASE_URL__ + "/admin/franchiseeStatusConfirmation", {
        idfranchisee: idfranchisee,
        status: status
    }, function (result) {
        var result_ary = result.split("||||");
        var res = result_ary[0].trim(" ");
        if (res == 'SUCCESS') {
            $("#popup_box").html(result_ary[1]);
            $('#franchiseeStatusConfirmation').modal("show");
        }
        jQuery('#loader').attr('style', 'display:none');

    });
}
function editDiscountDetails(idDiscount) {

    $.post(__BASE_URL__ + "/ordering/editDiscountDetails", {idDiscount: idDiscount}, function (result) {
        ar_result = result.split('||||');
        window.location = __BASE_URL__ + "/ordering/" + ar_result[1];

    });
}
function discountView(idDiscount) {

    $.post(__BASE_URL__ + "/ordering/discountViewData", {idDiscount: idDiscount}, function (result) {
        ar_result = result.split('||||');
        window.location = __BASE_URL__ + "/ordering/" + ar_result[1];

    });
}
function discountDelete(idDiscount) {
    jQuery('#loader').attr('style', 'display:block');
    $.post(__BASE_URL__ + "/ordering/discountDeleteeAlert", {idDiscount: idDiscount}, function (result) {
        var result_ary = result.split("||||");
        var res = result_ary[0].trim(" ");
        if (res == 'SUCCESS') {
            $("#popup_box").html(result_ary[1]);
            $('#discountDelete').modal("show");
        }
        jQuery('#loader').attr('style', 'display:none');

    });
}
function discountDeleteConfirmation(idDiscount) {

    $('.modal-backdrop').remove();
    $('#static').modal("hide");
    $('#discountDelete').modal("hide");
    jQuery('#loader').attr('style', 'display:block');
    $.post(__BASE_URL__ + "/ordering/deletediscountConfirmation", {idDiscount: idDiscount}, function (result) {
        var result_ary = result.split("||||");
        var res = result_ary[0].trim(" ");
        if (res == 'SUCCESS') {
            $("#popup_box").html(result_ary[1]);
            $('#discountDeleteConfirmation').modal("show");
        }
        jQuery('#loader').attr('style', 'display:none');

    });
}

function prospectDelete(prospectId) {
    jQuery('#loader').attr('style', 'display:block');
    $.post(__BASE_URL__ + "/prospect/deleteprospectAlert", {prospectId: prospectId}, function (result) {
        var result_ary = result.split("||||");
        var res = result_ary[0].trim(" ");
        if (res == 'SUCCESS') {
            $("#popup_box").html(result_ary[1]);
            $('#prospectStatus').modal("show");
        }
        jQuery('#loader').attr('style', 'display:none');

    });
}
function deleteProspectConfirmation(prospectId) {

    $('.modal-backdrop').remove();
    $('#static').modal("hide");
    $('#prospectStatus').modal("hide");
    jQuery('#loader').attr('style', 'display:block');
    $.post(__BASE_URL__ + "/prospect/deleteProspectConfirmation", {prospectId: prospectId}, function (result) {
        var result_ary = result.split("||||");
        var res = result_ary[0].trim(" ");
        if (res == 'SUCCESS') {
            $("#popup_box").html(result_ary[1]);
            $('#prospectStatusConfirmation').modal("show");
        }
        jQuery('#loader').attr('style', 'display:none');

    });
}
function viewProspect(idProspect) {

    $.post(__BASE_URL__ + "/prospect/viewProspectData", {idProspect: idProspect}, function (result) {
        ar_result = result.split('||||');
        window.location = __BASE_URL__ + "/prospect/" + ar_result[1];

    });
}
function addMeetingNotesData(idProspect, flag) {

    $.post(__BASE_URL__ + "/prospect/addMeetingNotesData", {idProspect: idProspect, flag: flag}, function (result) {
        ar_result = result.split('||||');
        window.location = __BASE_URL__ + "/prospect/" + ar_result[1];

    });
}
function viewMeetingNotes(idMeetingNotes) {

    $.post(__BASE_URL__ + "/prospect/viewMeetingNotesData", {idMeetingNotes: idMeetingNotes}, function (result) {
        ar_result = result.split('||||');
        window.location = __BASE_URL__ + "/prospect/" + ar_result[1];

    });
}
function editProspectStatus(idProspect) {
    jQuery('#loader').attr('style', 'display:block');
    $.post(__BASE_URL__ + "/prospect/editProspectStatusData", {idProspect: idProspect}, function (result) {
        var result_ary = result.split("||||");
        var res = result_ary[0].trim(" ");
        if (res == 'SUCCESS') {
            $("#popup_box").html(result_ary[1]);
            $('#editProspectStatus').modal("show");
            $('#submit_val').attr('style', 'opacity:0.4');
            $('#submit_val').removeAttr('onclick');

        }
        jQuery('#loader').attr('style', 'display:none');

    });
}
function editProspectStatusConfirmation(idProspect) {
    var value = jQuery("#changeStatus").serialize();
    var newValue = value + "&idProspect=" + idProspect;
    $('.modal-backdrop').remove();
    $('#static').modal("hide");
    $('#editProspectStatus').modal("hide");
    jQuery('#loader').attr('style', 'display:block');
    $.post(__BASE_URL__ + "/prospect/editProspectStatusConfirm", newValue, function (result) {

        var result_ary = result.split("||||");
        var res = result_ary[0].trim(" ");
        if (res == 'SUCCESS') {
            $("#popup_box").html(result_ary[1]);
            $('#editProspectStatusConfirmation').modal("show");
            jQuery('#loader').attr('style', 'display:none');
        } else {
            $("#popup_box").html(result);
            $('#editProspectStatus').modal("show");
            jQuery('#loader').attr('style', 'display:block');
        }


    });
}
function showDescription(idMeetingNote, flag) {

    jQuery('#loader').attr('style', 'display:block');
    $.post(__BASE_URL__ + "/prospect/showDescriptionData", {idMeetingNote: idMeetingNote,}, function (result) {
        var result_ary = result.split("||||");
        var res = result_ary[0].trim(" ");
        if (res == 'SUCCESS') {
            if (flag == 1) {
                $("#popup_box_level2").html(result_ary[1]);
                $('#showDescription').modal("show");
                jQuery('#loader').attr('style', 'display:none');
            }
            else {
                $("#popup_box").html(result_ary[1]);
                $('#showDescription').modal("show");
                jQuery('#loader').attr('style', 'display:none');
            }
        }


    });
}
function export_csv_report(franchiseeId, prospectId, status) {
    $.post(__BASE_URL__ + "/prospect/exportProspectCsvData", {
        franchiseeId: franchiseeId,
        prospectId: prospectId,
        status: status
    }, function (result) {
        ar_result = result.split('||||');
        var URL = __BASE_URL__ + "/prospect/" + ar_result[1];
        window.open(URL, '_blank');
    });
}
function import_csv_popup() {

    jQuery('#loader').attr('style', 'display:block');
    $.post(__BASE_URL__ + "/prospect/import_csv_popup_alert", function (result) {
        var result_ary = result.split("||||");
        var res = result_ary[0].trim(" ");
        if (res == 'SUCCESS') {
            $("#popup_box").html(result_ary[1]);
            $('#static').modal("show");
            jQuery('#loader').attr('style', 'display:none');
        }

    });
}

function import_csv_popup_confirmation() {
    var file = document.getElementById("imp_prospects").value
    var adminOrOp = $("#adminOrOp").val();
    if (adminOrOp) {
        var ifranchiseeId = $("#iFranchiseeId").val();
        if (!ifranchiseeId) {
            $('#err').html('Please select a franchisee.');
            $('#err').show();
            return false;
        }
    }
    if (!file) {
        $('#error').html('Please select a csv file.');
        $('#error').show();
        return false;
    }
    else {
        var fileExtention = (/[.]/.exec(file)) ? /[^.]+$/.exec(file) : undefined;
        if (fileExtention == 'csv') {
            $('.error').hide();
            $("#ProspectimportForm").submit();
        }
        else {
            $('#error').html('Invalid file uploaded. Only .csv file is allowed. Please try again.');
            $('#error').show();
            return false;
        }
    }
}
function changeToClient(prospectId) {
    jQuery('#loader').attr('style', 'display:block');
    $.post(__BASE_URL__ + "/prospect/changeToClientAlert", {prospectId: prospectId}, function (result) {
        var result_ary = result.split("||||");
        var res = result_ary[0].trim(" ");
        if (res == 'SUCCESS') {
            $("#popup_box").html(result_ary[1]);
            $('#changeToClientStatus').modal("show");
        }
        jQuery('#loader').attr('style', 'display:none');

    });
}
function changeToClientConfirmation(prospectId) {
    $('.modal-backdrop').remove();
    $('#static').modal("hide");
    $('#changeToClientStatus').modal("hide");
    jQuery('#loader').attr('style', 'display:block');
    $.post(__BASE_URL__ + "/prospect/changeToClientConfirmation", {prospectId: prospectId}, function (result) {
        var result_ary = result.split("||||");
        var res = result_ary[0].trim(" ");
        if (res == 'SUCCESS') {
            $("#popup_box").html(result_ary[1]);
            $('#changeToClientStatusConfirmation').modal("show");
        } else if (res == 'ERROR') {
            $("#popup_box").html(result_ary[1]);
            $('#changeToClientStatusConfirmation').modal("show");
        }
        jQuery('#loader').attr('style', 'display:none');

    });
}
function getAgentListByFrId(idFranchisee) {
    $.post(__BASE_URL__ + "/franchisee/getAgentListByFrIdData", {idFranchisee: idFranchisee}, function (result) {
        if (result != '') {
            $("#szAgent").empty();
            $("#szAgent").html(result);
            $("#szSearchClRecord").customselect();
        }
    });
}
function ViewAssignClient(idAgent, franchiseeid) {

    jQuery('#loader').attr('style', 'display:block');
    $.post(__BASE_URL__ + "/franchisee/ViewAssignClientData", {
        idAgent: idAgent,
        franchiseeid: franchiseeid
    }, function (result) {
        var result_ary = result.split("||||");
        var res = result_ary[0].trim(" ");
        if (res == 'SUCCESS') {
            $("#popup_box").html(result_ary[1]);
            $('#AssignClient').modal("show");
            jQuery('#loader').attr('style', 'display:none');
        }


    });
}
function ViewAgentDetails(idAgent, franchiseeid) {

    $.post(__BASE_URL__ + "/franchisee/ViewAgentDetailsData", {
        idAgent: idAgent,
        franchiseeid: franchiseeid
    }, function (result) {
        ar_result = result.split('||||');
        window.location = __BASE_URL__ + "/franchisee/" + ar_result[1];

    });
}

function assignfranchiseeClient(clientid, regionId) {
    jQuery('#loader').attr('style', 'display:block');
    $.post(__BASE_URL__ + "/franchisee/assignfranchiseeClient", {
        clientid: clientid,
        regionId: regionId
    }, function (result) {
        var result_ary = result.split("||||");
        var res = result_ary[0].trim(" ");
        if (res == 'SUCCESS') {
            $("#popup_box").html(result_ary[1]);
            $('#assignfrClientPopupform').modal("show");
        }
        jQuery('#loader').attr('style', 'display:none');

    });
}

function assignFranchiseeClientConfirmation(clientid, regionId) {
    var value = jQuery("#assignClient").serialize();
    var newValue = value + "&clientid=" + clientid + "&regionId=" + regionId;
    jQuery('#loader').attr('style', 'display:block');
    $.post(__BASE_URL__ + "/franchisee/assignFranchiseeClientConfirmation", newValue, function (result) {

        var result_ary = result.split("||||");
        var res = result_ary[0].trim(" ");
        if (res == 'SUCCESS') {
            $("#popup_box_level1").html(result_ary[1]);
            $('#clientFrAssignmentStatusConfirmation').modal("show");
            jQuery('#loader').attr('style', 'display:none');
        } else {
            $("#popup_box").html(result);
            $('#assignfrClientPopupform').modal("show");
            jQuery('#loader').attr('style', 'display:block');
        }


    });
}

function showSubmit(value) {
    var statusVal = $("#statusValue").val();
    var idProspect = $("#idProspect").val();
    if ((statusVal == value) || (!value)) {
        $('#submit_val').attr('style', 'opacity:0.4');
        $('#submit_val').removeAttr('onclick');
    }
    else {
        $('#submit_val').attr('style', 'opacity:1');
        $("#submit_val").unbind("click");
        $("#submit_val").click(function () {
            editProspectStatusConfirmation(idProspect);
        });
        $('#submit_val span').text('save');


    }
}
function getRegionNameByState(StateId) {

    $.post(__BASE_URL__ + "/admin/getRegionNameByStateData", {StateId: StateId}, function (result) {
        if (result != '') {
            $("#szRegion").empty();
            $("#szRegion").html(result);
            $("#szSearchRegionName").customselect();
        }
    });
}
function View_excel_order_details_list(idOrder,flag) {
    if(!flag){
        flag = 0;
    }
    $.post(__BASE_URL__ + "/order/View_excel_order_details_data", {idOrder: idOrder, flag: flag}, function (result) {
        ar_result = result.split('||||');
        var URL = __BASE_URL__ + "/order/" + ar_result[1];
        window.open(URL, '_blank');
    });

}
function showformdata(sosid,hide,viewAgentComment) {
    if(!hide){
        hide = 0;
    }
    if(!viewAgentComment){
        viewAgentComment = 0;
    }
    $('#loader').css('display', 'block');
    var jdata = {
        sosid: sosid
    }
    $.ajax({
        datatype: "json",
        url: __BASE_URL__ + "/webservices/getsosformdatabysosid/",
        type: "POST",
        crossDomain: true,
        cache: false,
        data: JSON.stringify(jdata),
        success: function (html) {
            if (html.code == '200') {
                var modalhtml = '<div class="modal fade custommodal customwebmodal" id="opensosdata" role="dialog">' +
                    '<div class="modal-dialog">' +
                    '<div class="modal-content">' +
                    '<div class="modal-header">' +
                    '<button type="button" class="close" data-dismiss="modal">&times;</button>' +
                    '<h2 class="modal-title font-green-sharp">SOS Data</h2>' +
                    /*'<button style="float: right" type="button" class="btn green-meadow" onclick="showsospdf('+sosid+')">View PDF</button>' +
                     '<br/>'+*/
                    '</div>' +
                    '<div class="modal-body">' +
                    '<div class="table-responsive">' +
                    '<table class="table sosmodaltable">' +
                    '<tbody>';
                $.each(html.dataarr, function (key, value) {
                    var alchohol = false;
                    var oral = false;
                    var urineasnza = false;
                    var asnza = false;
                    var otherTest = false;
                    var InHouse = false;
                    var OnClinic = false;
                    var testtypesarr = value.Drugtestid.split(',');
                    var screeningArr = value.screening_facilities.split(',');
                    if (testtypesarr) {
                        if (testtypesarr[0] == '1') {
                            alchohol = true;
                        } else if (testtypesarr[0] == '2') {
                            oral = true;
                        } else if (testtypesarr[0] == '3') {
                            urineasnza = true;
                        } else if (testtypesarr[0] == '4') {
                            asnza = true;
                        }else if (testtypesarr[0] == '5') {
                            otherTest = true;
                        }

                        if (testtypesarr[1] == '1') {
                            alchohol = true;
                        } else if (testtypesarr[1] == '2') {
                            oral = true;
                        } else if (testtypesarr[1] == '3') {
                            urineasnza = true;
                        } else if (testtypesarr[1] == '4') {
                            asnza = true;
                        }else if (testtypesarr[1] == '5') {
                            otherTest = true;
                        }

                        if (testtypesarr[2] == '1') {
                            alchohol = true;
                        } else if (testtypesarr[2] == '2') {
                            oral = true;
                        } else if (testtypesarr[2] == '3') {
                            urineasnza = true;
                        } else if (testtypesarr[2] == '4') {
                            asnza = true;
                        }else if (testtypesarr[2] == '5') {
                            otherTest = true;
                        }

                        if (testtypesarr[3] == '1') {
                            alchohol = true;
                        } else if (testtypesarr[3] == '2') {
                            oral = true;
                        } else if (testtypesarr[3] == '3') {
                            urineasnza = true;
                        } else if (testtypesarr[3] == '4') {
                            asnza = true;
                        }else if (testtypesarr[3] == '5') {
                            otherTest = true;
                        }

                        if (testtypesarr[4] == '1') {
                            alchohol = true;
                        } else if (testtypesarr[4] == '2') {
                            oral = true;
                        } else if (testtypesarr[4] == '3') {
                            urineasnza = true;
                        } else if (testtypesarr[4] == '4') {
                            asnza = true;
                        }else if (testtypesarr[4] == '5') {
                            otherTest = true;
                        }
                    }

                    if (screeningArr) {
                        if (screeningArr[0] == '1') {
                            InHouse = true;
                        } else if (screeningArr[0] == '2') {
                            OnClinic = true;
                        }
                        if (screeningArr[1] == '1') {
                            InHouse = true;
                        } else if (screeningArr[1] == '2') {
                            OnClinic = true;
                        }
                    }

                        var drugteststring = '';
                    if (alchohol) {
                        drugteststring = 'Alcohol<br>';
                    }
                    if (oral) {
                        drugteststring += 'Oral Fluid<br>';
                    }
                    if (urineasnza) {
                        drugteststring += 'Urine<br>';
                    }
                    /*if (asnza) {
                        drugteststring += 'AS/NZA 4308:2008<br>';
                    }*/
                    if (otherTest) {
                        drugteststring += 'Other: '+value.other_drug_test+'<br>';
                    }
                    var drugtesttr = '<tr><th>Drugs Tested:</th><td colspan="3">' + (drugteststring != '' ? drugteststring : 'Other') + '</td></tr>';
                    modalhtml += '<tr><td colspan="4"><button style="float: right" type="button" class="btn green-meadow" onclick="showsospdf(' + sosid + ',' + hide + ')">View PDF</button></td></tr> ' +
                        '<tr><th>Service Commenced:</th><td colspan="3">' + value.ServiceCommencedOn + '</td></tr>' +
                        '<tr><th>Services Concluded:</th><td colspan="3">' + value.ServiceConcludedOn + '</td></tr>' +
                        drugtesttr +
                        '<tr><th>Screening Facilities:</th><td colspan="3">' + (InHouse?'In House':'')+(InHouse && OnClinic?', ':'') +(OnClinic?'Mobile Clinic':'')+ '</td></tr>' +
                        '<tr><th>Start(km):</th><td colspan="3">' + value.start_km + '</td></tr>' +
                        '<tr><th>End(km):</th><td colspan="3">' + value.end_km + '</td></tr>' +
                        '<tr><th>Total(km):</th><td colspan="3">' + value.total_km + '</td></tr>' +
                        '<tr><th>Total Donor Screenings/Collections:</th><td>Urine: ' + (value.TotalDonarScreeningUrine > 0 ? value.TotalDonarScreeningUrine : '0') + '</td><td colspan="2">Oral: ' + (value.TotalDonarScreeningOral > 0 ? value.TotalDonarScreeningOral : '0') + '</td></tr>' +
                        '<tr><th>Negative Results:</th><td>Urine: ' + (value.NegativeResultUrine > 0 ? value.NegativeResultUrine : '0') + '</td><td colspan="2">Oral: ' + (value.NegativeResultOral > 0 ? value.NegativeResultOral : '0') + '</td></tr>' +
                        '<tr><th>Results Requiring Further Testing:</th><td>Urine: ' + (value.FurtherTestUrine > 0 ? value.FurtherTestUrine : '0') + '</td><td colspan="2">Oral: ' + (value.FurtherTestOral > 0 ? value.FurtherTestOral : '0') + '</td></tr>' +
                        '<tr><th>Alcohol Results:</th><td>Total No Alcohol Screen: ' + (value.TotalAlcoholScreening > 0 ? value.TotalAlcoholScreening : '0') + '</td><td>Negative Alcohol Results: ' + (value.NegativeAlcohol > 0 ? value.NegativeAlcohol : '0') + '</td><td>Positive Alcohol Results: ' + (value.PositiveAlcohol > 0 ? value.PositiveAlcohol : '0') + '</td></tr>' +
                        '<tr><th>Refusals:</th><td colspan="3">' + value.Refusals + '</td></tr>' +
                        // '<tr><th>Device Name:</th><td colspan="3">' + value.DeviceName + '</td></tr>' +
                        '<tr><th>Extra Used:</th><td colspan="3">' + value.ExtraUsed + '</td></tr>' +
                        // '<tr><th>Breath Testing Unit:</th><td colspan="3">' + value.BreathTesting + '</td></tr>' +
                        '<tr><th>Declaration:</th><td colspan="3">I\'ve conducted the alcohol and/or drug screening/collection service detailed above and confirm that all procedures were undertaken in accordance with the relevant Standard.</td></tr>' +
                        '<tr><th>Collector Name:</th><td colspan="3">' + value.collname + '</td></tr>' +
                        '<tr><th>Collector Signature:</th><td colspan="3"><img src="' + __BASE_URL__ + '/uploadsign/' + value.collsign + '" /></td></tr>' +
                        '<tr><th>Comments or Observation:</th><td colspan="3">' + value.Comments + '</td></tr>' +
                        '<tr><th>Time:</th><td colspan="3">' + value.RepresentativeSignatureTime + '</td></tr>' +
                        '<tr><th>Nominated Client Representative:</th><td colspan="3">' + value.ClientRepresentative + '</td></tr>' +
                        '<tr><th>Signature:</th><td colspan="3"><img src="' + __BASE_URL__ + '/uploadsign/' + value.RepresentativeSignature + '" /></td></tr>' +
                        (html.role == '6'?'<tr><th>Agent Comment:</th><td colspan="3">' + (viewAgentComment=='1' && value.agent_comment?value.agent_comment:"N/A") + '</td></tr>':'');
                });
                modalhtml += '</tbody></table>' +
                    '</div>' +
                    (hide==0?'<p><button type="button" class="btn green-meadow" onclick="usedprodsdets(' + sosid + ');">Used Products</button></p>':'') +
                    '<a href="#productsdetmodal" id="usedprods" data-toggle="modal" style="display: none"></a> </td>' +
                    '</div>' +
                    '<div class="modal-footer">' +
                    '<button type="button" class="btn green-meadow" data-dismiss="modal">Close</button>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</div>';
                $('.show-stack-modal').html(modalhtml);
                $('#loader').css('display', 'none');
                $('#opensosdata').modal('show');
            } else {
                $('#loader').css('display', 'none');
                alert(html.message);
            }
        }
    });
}
function usedprodsdets(sosid) {
    $('#loader').css('display', 'block');
    var jdata = {
        sosid: sosid,
        used: 1
    }
    $.ajax({
        datatype: "json",
        url: __BASE_URL__ + "/webservices/getsavedkitsbysosid/",
        type: "POST",
        crossDomain: true,
        cache: false,
        data: JSON.stringify(jdata),
        success: function (html) {
            if (html.code == '200') {
                var prodmodalhtml = '<div class="modal fade custommodal customwebmodal" id="productsdetmodal" role="dialog">' +
                    '<div class="modal-dialog">' +
                    '<div class="modal-content">' +
                    '<div class="modal-header">' +
                    '<button type="button" class="close" data-dismiss="modal">&times;</button>' +
                    '<h2 class="modal-title font-green-sharp">Used Products</h2>' +
                    '</div>' +
                    '<div class="modal-body">' +
                    '<div class="table-responsive">' +
                    '<table class="table">' +
                    '<thead>' +
                    '<tr><th>Product</th><th>Quantity</th></tr>' +
                    '</thead>' +
                    '<tbody>';
                $.each(html.kitarr, function (key, value) {

                    prodmodalhtml += '<tr><td>' + value.szProductCode + '</td><td>' + value.quantity + '</td></tr>';
                });
                prodmodalhtml += '</tbody></table>' +
                    '</div>' +
                    '</div>' +
                    '<div class="modal-footer">' +
                    '<button type="button" class="btn green-meadow" data-dismiss="modal">Close</button>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</div>';
                $('.show-stackonstack-modal').html(prodmodalhtml);
                $('#loader').css('display', 'none');
                $('#productsdetmodal').modal('show');
                //$('#usedprods').click();
            } else {
                $('#loader').css('display', 'none');
                alert(html.message);
            }
        }
    });
}
function showdonorinfo(sosid) {
    $('#loader').css('display', 'block');
    var jdata = {
        sosid: sosid
    }
    $.ajax({
        datatype: "json",
        url: __BASE_URL__ + "/webservices/getdonorsbysosid/",
        type: "POST",
        crossDomain: true,
        cache: false,
        data: JSON.stringify(jdata),
        success: function (html) {
            if (html.code == '200') {
                var donormodalhtml = '<div class="modal fade custommodal" id="donorsdetmodal" role="dialog">' +
                    '<div class="modal-dialog">' +
                    '<div class="modal-content">' +
                    '<div class="modal-header">' +
                    '<button type="button" class="close" data-dismiss="modal">&times;</button>' +
                    '<h2 class="modal-title font-green-sharp">Donors List</h2>' +
                    '</div>' +
                    '<div class="modal-body">' +
                    '<div class="table-responsive">' +
                    '<table class="table">' +
                    '<thead>' +
                    '<tr><th width="300">Donors</th><th colspan="2" style="text-align:center">Action</th></tr>' +
                    '</thead>' +
                    '<tbody>';
                $.each(html.dataarr, function (key, value) {

                    donormodalhtml += '<tr><td>' + value.donerName + '</td>' +
                        '<td><button type="button" class="btn green-meadow infobtn" data-toggle="modal" onclick="showdonorinfobydivid(\'#viewdonorinfo' + value.id + '\')" href="javascript:void(0);"><span class="spleft">Donor </span><span class="spright"><i class="fa fa-info-circle" aria-hidden="true"></i></span></button></td>' +
                        '<td><button type="button" class="btn green-meadow infobtn" onclick="viewcocdets(\'' + value.cocid + '\',\'' + value.donerName + '\');"><span class="spleft">COC </span><span class="spright"><i class="fa fa-info-circle" aria-hidden="true"></i></span></button>' +
                        '<a href="" id="cocview" data-toggle="modal" style="display: none"></a> </td>' +
                        '</tr>';
                });
                donormodalhtml += '</tbody></table>' +
                    '</div>' +
                    '</div>' +
                    '<div class="modal-footer">' +
                    '<button type="button" class="btn green-meadow" data-dismiss="modal">Close</button>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</div>';
                $.each(html.dataarr, function (key1, value1) {
                    var drugs = '';
                    var drugarr = value1.drug.split(',');
                    if(drugarr[0] == '1'){
                        drugs += 'Ice-Methamphetamine(mAmp)<br>';
                    }else if(drugarr[1] == '1'){
                        drugs += 'Ice-Methamphetamine(mAmp)<br>';
                    }else if(drugarr[2] == '1'){
                        drugs += 'Ice-Methamphetamine(mAmp)<br>';
                    }else if(drugarr[3] == '1'){
                        drugs += 'Ice-Methamphetamine(mAmp)<br>';
                    }else if(drugarr[4] == '1'){
                        drugs += 'Ice-Methamphetamine(mAmp)<br>';
                    }else if(drugarr[5] == '1'){
                        drugs += 'Ice-Methamphetamine(mAmp)<br>';
                    }else if(drugarr[6] == '1'){
                        drugs += 'Ice-Methamphetamine(mAmp)<br>';
                    }

                    if(drugarr[0] == '2'){
                        drugs += 'THC-Marijuana(THC)<br>';
                    }else if(drugarr[1] == '2'){
                        drugs += 'THC-Marijuana(THC)<br>';
                    }else if(drugarr[2] == '2'){
                        drugs += 'THC-Marijuana(THC)<br>';
                    }else if(drugarr[3] == '2'){
                        drugs += 'THC-Marijuana(THC)<br>';
                    }else if(drugarr[4] == '2'){
                        drugs += 'THC-Marijuana(THC)<br>';
                    }else if(drugarr[5] == '2'){
                        drugs += 'THC-Marijuana(THC)<br>';
                    }else if(drugarr[6] == '2'){
                        drugs += 'THC-Marijuana(THC)<br>';
                    }

                    if(drugarr[0] == '3'){
                        drugs += 'Heroine-Opiates(OPI)<br>';
                    }else if(drugarr[1] == '3'){
                        drugs += 'Heroine-Opiates(OPI)<br>';
                    }else if(drugarr[2] == '3'){
                        drugs += 'Heroine-Opiates(OPI)<br>';
                    }else if(drugarr[3] == '3'){
                        drugs += 'Heroine-Opiates(OPI)<br>';
                    }else if(drugarr[4] == '3'){
                        drugs += 'Heroine-Opiates(OPI)<br>';
                    }else if(drugarr[5] == '3'){
                        drugs += 'Heroine-Opiates(OPI)<br>';
                    }else if(drugarr[6] == '3'){
                        drugs += 'Heroine-Opiates(OPI)<br>';
                    }

                    if(drugarr[0] == '4'){
                        drugs += 'Cocaine-Cocaine(COC)<br>';
                    }else if(drugarr[1] == '4'){
                        drugs += 'Cocaine-Cocaine(COC)<br>';
                    }else if(drugarr[2] == '4'){
                        drugs += 'Cocaine-Cocaine(COC)<br>';
                    }else if(drugarr[3] == '4'){
                        drugs += 'Cocaine-Cocaine(COC)<br>';
                    }else if(drugarr[4] == '4'){
                        drugs += 'Cocaine-Cocaine(COC)<br>';
                    }else if(drugarr[5] == '4'){
                        drugs += 'Cocaine-Cocaine(COC)<br>';
                    }else if(drugarr[6] == '4'){
                        drugs += 'Cocaine-Cocaine(COC)<br>';
                    }

                    if(drugarr[0] == '5'){
                        drugs += 'Benzodiazepines-Benzodiazepines(BZO)<br>';
                    }else if(drugarr[1] == '5'){
                        drugs += 'Benzodiazepines-Benzodiazepines(BZO)<br>';
                    }else if(drugarr[2] == '5'){
                        drugs += 'Benzodiazepines-Benzodiazepines(BZO)<br>';
                    }else if(drugarr[3] == '5'){
                        drugs += 'Benzodiazepines-Benzodiazepines(BZO)<br>';
                    }else if(drugarr[4] == '5'){
                        drugs += 'Benzodiazepines-Benzodiazepines(BZO)<br>';
                    }else if(drugarr[5] == '5'){
                        drugs += 'Benzodiazepines-Benzodiazepines(BZO)<br>';
                    }else if(drugarr[6] == '5'){
                        drugs += 'Benzodiazepines-Benzodiazepines(BZO)<br>';
                    }

                    if(drugarr[0] == '6'){
                        drugs += 'Amphetamine-Amphetamine(AMP)<br>';
                    }else if(drugarr[1] == '6'){
                        drugs += 'Amphetamine-Amphetamine(AMP)<br>';
                    }else if(drugarr[2] == '6'){
                        drugs += 'Amphetamine-Amphetamine(AMP)<br>';
                    }else if(drugarr[3] == '6'){
                        drugs += 'Amphetamine-Amphetamine(AMP)<br>';
                    }else if(drugarr[4] == '6'){
                        drugs += 'Amphetamine-Amphetamine(AMP)<br>';
                    }else if(drugarr[5] == '6'){
                        drugs += 'Amphetamine-Amphetamine(AMP)<br>';
                    }else if(drugarr[6] == '6'){
                        drugs += 'Amphetamine-Amphetamine(AMP)<br>';
                    }

                    if(drugarr[0] == '7'){
                        drugs += 'Other<br>';
                    }else if(drugarr[1] == '7'){
                        drugs += 'Other<br>';
                    }else if(drugarr[2] == '7'){
                        drugs += 'Other<br>';
                    }else if(drugarr[3] == '7'){
                        drugs += 'Other<br>';
                    }else if(drugarr[4] == '7'){
                        drugs += 'Other<br>';
                    }else if(drugarr[5] == '7'){
                        drugs += 'Other<br>';
                    }else if(drugarr[6] == '7'){
                        drugs += 'Other<br>';
                    }

                    if (value1.otherdrug) {
                        drugs += value1.otherdrug + '<br>';
                    }
                    var alcoholread1 = '';
                    var alcoholread2 = '';
                    if (value1.alcoholreading1) {
                        alcoholread1 = value1.alcoholreading1;
                    }
                    if (value1.alcoholreading2) {
                        alcoholread2 = value1.alcoholreading2;
                    }
                    donormodalhtml += '<div class="modal fade custommodal" id="viewdonorinfo' + value1.id + '" role="dialog">' +
                        '<div class="modal-dialog">' +
                        '<div class="modal-content">' +
                        '<div class="modal-header">' +
                        '<button type="button" class="close" data-dismiss="modal">&times;</button>' +
                        '<h2 class="modal-title font-green-sharp">Donors Info</h2>' +
                        '</div>' +
                        '<div class="modal-body">' +
                        '<div class="table-responsive">' +
                        '<table class="table modaltable">' +
                        '<tbody>' +
                        '<tr><th>Drugs:</th><td>' + (drugs != '' ? drugs : 'N/A') + '</td></tr>' +
                        '<tr><th>Alcohol:</th><td>' + (alcoholread1 != '' ? 'P, ' : 'N, ') + 'Reading One:' + (alcoholread1 != '' ? alcoholread1 : 'N/A') + '<br />' + (alcoholread2 != '' ? 'P, ' : 'N, ') + 'Reading Two:' + (alcoholread2 != '' ? alcoholread2 : 'N/A') + '</td></tr>' +
                        '</tbody></table>' +
                        '</div>' +
                        '</div>' +
                        '<div class="modal-footer">' +
                        '<button type="button" class="btn green-meadow" data-dismiss="modal">Close</button>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>';
                });
                $('.show-stack-modal').html(donormodalhtml);
                $('#loader').css('display', 'none');
                $('#donorsdetmodal').modal('show');
            } else {
                $('#loader').css('display', 'none');
                alert(html.message);
            }
        }
    });
}

function viewcocdets(cocid, donorname) {
    $('#loader').css('display', 'block');
    var jdata = {
        cocid: cocid
    }
    $.ajax({
        datatype: "json",
        url: __BASE_URL__ + "/webservices/getcocdatabycocid/",
        type: "POST",
        crossDomain: true,
        cache: false,
        data: JSON.stringify(jdata),
        success: function (html) {
            if (html.code == '200') {
                var cocmodalhtml = '';
                $.each(html.dataarr, function (key, value) {
                    $('#cocview').attr('href', '#cocdatamodal' + value.id);
                    cocmodalhtml = '<div class="modal fade custommodal" id="cocdatamodal' + value.id + '" role="dialog">' +
                        '<div class="modal-dialog">' +
                        '<div class="modal-content">' +
                        '<div class="modal-header">' +
                        '<button type="button" class="close" data-dismiss="modal">&times;</button>' +
                        '<h2 class="modal-title font-green-sharp">COC Data</h4>' +
                        '</div>' +
                        '<div class="modal-body">' +
                        '<div class="table-responsive">' +
                        '<table class="table modaltable">' +
                        '<tbody>' +
                        '<tr><td colspan="2"><button style="float: right" type="button" class="btn green-meadow" onclick="showcocpdf(' + cocid + ')">View PDF</button></td></tr>' +
                        '<tr><th>Test Date:</th><td>' + formatdate(value.cocdate) + '</td></tr>' +
                        '<tr><th colspan="2" class="col-md-2"><h3 class="font-green-sharp">Donor Information</h3></th> </tr>' +
                        '<tr><th class="col-md-2">Donor Name:</th><td class="col-md-2">' + donorname + '</td></tr>' +
                        '<tr><th class="col-md-2">Date of birth:</th><td class="col-md-2">' + formatdate(value.dob) + '</td></tr>' +
                        '<tr><th class="col-md-2">Employment Type:</th><td class="col-md-2">' + (value.employeetype == '1' ? 'Employee' : (value.employeetype == '2' ? 'Contractor' : '')) + '</td></tr>' +
                        (value.employeetype == '2' ? '<tr><th class="col-md-2">Contractor Details:</th><td class="col-md-2">' + value.contractor + '</td></tr>' : '' ) +
                        '<tr><th class="col-md-2">ID Type:</th><td class="col-md-2">' + (value.idtype == '1' ? 'Driving License' : (value.idtype == '2' ? 'Photo ID Card' : (value.idtype == '3' ? 'Passport' : ''))) + '</td></tr>' +
                        '<tr><th class="col-md-2">ID Number:</th><td class="col-md-2">' + value.idnumber + '</td></tr>' +
                        '<tr><th class="col-md-2">Declaration:</th class="col-md-2"><td >I consent to the testing of my breath/urine/oral fluid sample for alcohol &/or drugs.</td></tr>' +
                        '<tr><th >Have you taken any medication, drugs or other non-prescription agents in last week?:</th><td>' + value.lastweekq + '</td></tr>' +
                        '<tr><th class="col-md-2">Donor Signature:</th><td class="col-md-2"><img src="' + __BASE_URL__ + '/uploadsign/' + value.donorsign + '" /></td></tr>' +
                        '<tr><td colspan="2"><p>Please Note: NATA/RCPA accreditation does not cover the performance of breath test.</p></td></tr>' +
                        '<tr><th colspan="2" ><h3 class="font-green-sharp">Alcohol Breath Test</h3></th> </tr>' +
                        '<tr><th class="col-md-2">Device Serial#:</th><td class="col-md-2">' + value.devicesrno + '</td></tr>' +
                        '<tr><th class="col-md-2">Cut off Level:</th><td class="col-md-2">' + value.cutoff + '</td></tr>' +
                        '<tr><th class="col-md-2">Wait Time <sub>[Minutes]</sub>:</th><td class="col-md-2">' + value.donwaittime + '</td></tr>' +
                        '<tr><th class="col-md-2">Test 1:</th><td class="col-md-2">' + value.dontest1 + '</td></tr>' +
                        '<tr><th class="col-md-2">Time <sub>[24 hr]</sub>:</th><td class="col-md-2">' + formattime(value.dontesttime1) + '</td></tr>' +
                        '<tr><th class="col-md-2">Test 2:</th><td class="col-md-2">' + value.dontest2 + '</td></tr>' +
                        '<tr><th class="col-md-2">Time <sub>[24 hr]</sub>:</th><td class="col-md-2">' + formattime(value.dontesttime2) + '</td></tr>' +
                        '<tr><th colspan="2" class="col-md-2"><h3 class="font-green-sharp nowhitespace">Collection of Sample/On-Site Drug Screening Results</h3></th> </tr>' +
                        '<tr><th class="col-md-2">Void Time <sub>[24 hr]</sub>:</th><td class="col-md-2">' + formattime(value.voidtime) + '</td></tr>' +
                        '<tr><th class="col-md-2">Sample Temp C:</th><td class="col-md-2">' + value.sampletempc + '</td></tr>' +
                        '<tr><th class="col-md-2">Temp Read Time within 4 min <sub>[24 hr]</sub>:</th><td class="col-md-2">' + formattime(value.tempreadtime) + '</td></tr>' +
                        '<tr><th class="col-md-2">Adulterant Test Lot No.:</th><td class="col-md-2">' + value.intect + '</td></tr>' +
                        '<tr><th class="col-md-2">Expiry:</th><td class="col-md-2">' + formatdate(value.intectexpiry) + '</td></tr>' +
                        '<tr><th class="col-md-2">Visual Colour:</th><td class="col-md-2">' + value.visualcolor + '</td></tr>' +
                        '<tr><th class="col-md-2">Creatinine:</th><td class="col-md-2">' + value.creatinine + '</td></tr>' +
                        '<tr><th class="col-md-2">Other Integrity:</th><td class="col-md-2">' + value.otherintegrity + '</td></tr>' +
                        '<tr><th class="col-md-2">Hydration:</th><td class="col-md-2">' + value.hudration + '</td> </tr>' +
                        '<tr><th class="col-md-2">Drug Device Name:</th><td class="col-md-2">' + value.devicename + '</td></tr>' +
                        '<tr><th class="col-md-2">Reference#:</th><td class="col-md-2">' + value.reference + '</td></tr>' +
                        '<tr><th class="col-md-2">Lot#:</th><td class="col-md-2">' + value.lotno + '</td></tr>' +
                        '<tr><th class="col-md-2">Expiry:</th><td class="col-md-2">' + formatdate(value.lotexpiry) + '</td></tr>' +
                        '<tr><th colspan="2" class="col-md-2"><h3 class="font-green-sharp">Drugs Class</h3></th> </tr>' +
                        '<tr><th class="col-md-2">Cocaine:</th><td class="col-md-2">' + (value.cocain == 'U' ? 'Further Testing Required' : (value.cocain == 'N' ? 'Negative' : '')) + '</td></tr>' +
                        '<tr><th class="col-md-2">Amp:</th><td class="col-md-2">' + (value.amp == 'U' ? 'Further Testing Required' : (value.amp == 'N' ? 'Negative' : '')) + '</td></tr>' +
                        '<tr><th class="col-md-2">mAmp:</th><td class="col-md-2">' + (value.mamp == 'U' ? 'Further Testing Required' : (value.mamp == 'N' ? 'Negative' : '')) + '</td></tr>' +
                        '<tr><th class="col-md-2">THC:</th><td class="col-md-2">' + (value.thc == 'U' ? 'Further Testing Required' : (value.thc == 'N' ? 'Negative' : '')) + '</td></tr>' +
                        '<tr><th class="col-md-2">Opiates:</th><td class="col-md-2">' + (value.opiates == 'U' ? 'Further Testing Required' : (value.opiates == 'N' ? 'Negative' : '')) + '</td></tr>' +
                        '<tr><th class="col-md-2">Benzo:</th><td class="col-md-2">' + (value.benzo == 'U' ? 'Further Testing Required' : (value.benzo == 'N' ? 'Negative' : '')) + '</td></tr>' +
                        '<tr><th class="col-md-2">Other:</th><td class="col-md-2">'+(value.otherdc=='U'?'Further Testing Required':(value.otherdc=='N'?'Negative':''))+'</td></tr>' +
                        '<tr><th class="col-md-2">Collection time of sample <sub>[24 hr]</sub>:</th><td class="col-md-2">' + formattime(value.ctstime) + '</td></tr>' +
                        '<tr><th colspan="2" class="col-md-2"><h3 class="font-green-sharp">Donor Declaration</h3></th> </tr>' +
                        '<tr><td colspan="2" class="col-md-2">I certify that the specimen(s) accompanying this form is my own. Where on-site screening was performed, such screening was carried out in my presence. In the case of my specimen(s) being sent to the laboratory for testing, I  certify that the specimen containers were sealed with tamper evident seals in my presence and the identifying information on the label is correct. I certify that the information provided  on this form to be correct and I consent to the release of all test results  together with any relevant details  contained on this form to the nominated representative of the requesting authority.</td></tr>' +
                        '<tr><th class="col-md-2">Date:</th><td class="col-md-2">' + formatdate(value.donordecdate) + '</td></tr>' +
                        '<tr><th class="col-md-2">Signature:</th><td class="col-md-2"><img src="' + __BASE_URL__ + '/uploadsign/' + value.donordecsign + '" /></td></tr>' +
                        '<tr><th colspan="2" class="col-md-2"><h3 class="font-green-sharp">Collector Certification</h3></th> </tr>' +
                        '<tr><td colspan="2" class="col-md-2">I certify that I witnessed the  Donor signature and that the specimen(s) identified on this form was provided to me by the Donor whose consent and  declaration appears above,  bears the same Donor identification as  set forth above, and that the specimen(s) has been collected and if needed divided, labelled and sealed in accordance  with the relevant Standard. *If two Collectors are present the second Collector (2) is to perform sample collection/screening for Alcohol and Urine.</td></tr>' +
                        '<tr><th class="col-md-2">Collector 1 Name/Number:</th><td class="col-md-2">' + value.collectorone + '</td></tr>' +
                        '<tr><th class="col-md-2">Signature:</th><td class="col-md-2"><img src="' + __BASE_URL__ + '/uploadsign/' + value.collectorsignone + '" /></td></tr>' +
                        '<tr><th class="col-md-2">Comments or Observation:</th><td class="col-md-2">' + value.commentscol1 + '</td></tr>' +
                        '<tr><th class="col-md-2">Collector 2 Name/Number:</th><td class="col-md-2">' + value.collectortwo + '</td></tr>' +
                        '<tr><th class="col-md-2">Signature:</th><td class="col-md-2"><img src="' + __BASE_URL__ + '/uploadsign/' + value.collectorsigntwo + '" /></td></tr>' +
                        '<tr><th class="col-md-2">Comments or Observation:</th><td class="col-md-2">' + value.comments + '</td></tr>' +
                        /*'<tr><th colspan="2" class="col-md-2"><h3 class="font-green-sharp">Chain of Custody</h3></th> </tr>' +
                        '<tr><th class="col-md-2">Received By(1):</th><td class="col-md-2">' + value.receiverone + '</td></tr>' +
                        '<tr><th class="col-md-2">Receiving Date:</th><td class="col-md-2">' + formatdate(value.receiveronedate) + '</td></tr>' +
                        '<tr><th class="col-md-2">Receiving Time:</th><td class="col-md-2">' + format12hrtime(value.receiveronetime) + '</td></tr>' +
                        '<tr><th class="col-md-2">Seal Intact:</th><td class="col-md-2">' + value.receiveroneseal + '</td></tr>' +
                        '<tr><th class="col-md-2">Label/Bar Code Match:</th><td class="col-md-2">' + value.receiveronelabel + '</td></tr>' +
                        '<tr><th class="col-md-2">Signature:</th><td class="col-md-2"><img src="' + __BASE_URL__ + '/uploadsign/' + value.receiveronesign + '" /></td></tr>' +
                        '<tr><th class="col-md-2">Received By(2):</th><td class="col-md-2">' + (value.receivertwo ? value.receivertwo : '-') + '</td></tr>' +
                        '<tr><th class="col-md-2">Receiving Date:</th><td class="col-md-2">' + (value.receivertwo ? formatdate(value.receivertwodate) : '-') + '</td></tr>' +
                        '<tr><th class="col-md-2">Receiving Time:</th><td class="col-md-2">' + (value.receivertwo ? format12hrtime(value.receivertwotime) : '-') + '</td></tr>' +
                        '<tr><th class="col-md-2">Seal Intact:</th><td class="col-md-2">' + (value.receivertwo ? value.receivertwoseal : '-') + '</td></tr>' +
                        '<tr><th class="col-md-2">Label/Bar Code Match:</th><td class="col-md-2">' + (value.receivertwo ? value.receivertwolabel : '-') + '</td></tr>' +
                        '<tr><th class="col-md-2">Signature:</th><td class="col-md-2">' + (value.receivertwo ? '<img src="' + __BASE_URL__ + '/uploadsign/' + value.receivertwosign + '" />' : '-') + '</td></tr>' +*/
                        '<tr><th class="col-md-2">On-Site Screening Report:</th><td class="col-md-2">'+(value.onsitescreeningrepo == '1'?'Final':(value.onsitescreeningrepo == '2'?'Interim':''))+'</td></tr>' +
                        '</tbody></table>' +
                        '</div>' +
                        '</div>' +
                        '<div class="modal-footer">' +
                        '<button type="button" class="btn green-meadow" data-dismiss="modal">Close</button>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>';
                });
                $('.show-stackonstack-modal').html(cocmodalhtml);
                var modalid = $('#cocview').attr('href');
                $('#loader').css('display', 'none');
                $(modalid).modal('show');
            } else {
                $('#loader').css('display', 'none');
                alert(html.message);
            }
        }
    });
}
function formatdate(val) {
    var datearr = val.split('-');
    var dateval = datearr[2] + '/' + datearr[1] + '/' + datearr[0];
    if ((dateval != '00/00/0000') && (dateval != '31/12/1969')) {
        return dateval;
    } else {
        return '';
    }
}
function showdonorinfobydivid(id) {
    $(id).modal('show');
}
function formattime(timeval) {
    timeval = timeval.split(':');
    if (parseInt(timeval[0].trim()) > 0) {
        timeval = ("0" + parseInt((timeval[0] ? timeval[0].trim() : 0))).slice(-2) + ' : ' + ("0" + parseInt((timeval[1] ? timeval[1].trim() : 0))).slice(-2);
        return timeval;
    } else {
        return "";
    }

}
function showsospdf(sosid,hide) {
    if(!hide){
        hide = 0;
    }
    $.post(__BASE_URL__ + "/formManagement/getsosformpdf", {sosid: sosid, hide: hide}, function (result) {
        ar_result = result.split('||||');
        var URL = __BASE_URL__ + "/formManagement/" + ar_result[1];
        window.open(URL, '_blank');
    });
}
function format12hrtime(timeval) {
    timeval = timeval.split(' ');
    var format = timeval[3];
    timeval = timeval[0] + ' : ' + timeval[2];
    var formattedTime = formattime(timeval);
    if (formattedTime != '') {
        return formattedTime + ' ' + format;
    } else {
        return "";
    }

}
function showcocpdf(cocid) {
    $.post(__BASE_URL__ + "/formManagement/getcocformpdf", {cocid: cocid}, function (result) {
        ar_result = result.split('||||');
        var URL = __BASE_URL__ + "/formManagement/" + ar_result[1];
        window.open(URL, '_blank');
    });
}

function viewProspectMeetingNotes(idProspect) {
    jQuery('#loader').attr('style', 'display:block');
    $.post(__BASE_URL__ + "/prospect/viewProspectMeetingNotesData", {idProspect: idProspect}, function (result) {
        var result_ary = result.split("||||");
        var res = result_ary[0].trim(" ");
        if (res == 'SUCCESS') {
            $("#popup_box").html(result_ary[1]);
            $('#showMeetingNotes').modal("show");
            jQuery('#loader').attr('style', 'display:none');
        }


    });
}
function ViewpdfSalesCrmReport(franchiseeId, szBusinessName, status) {

    $.post(__BASE_URL__ + "/prospect/View_pdf_Sales_Crm_Report", {
        franchiseeId: franchiseeId,
        szBusinessName: szBusinessName,
        status: status
    }, function (result) {
        ar_result = result.split('||||');
        var URL = __BASE_URL__ + "/prospect/" + ar_result[1];
        window.open(URL, '_blank');

    });
}

function ViewexcelSalesCrmReport(franchiseeId, szBusinessName, status) {
    $.post(__BASE_URL__ + "/prospect/View_xls_Sales_Crm_Report", {
        franchiseeId: franchiseeId,
        szBusinessName: szBusinessName,
        status: status
    }, function (result) {
        ar_result = result.split('||||');
        var URL = __BASE_URL__ + "/prospect/" + ar_result[1];
        window.open(URL, '_blank');

    });
}
function getClientCodeListByFrId(idFranchisee) {
    $.post(__BASE_URL__ + "/reporting/getClientCodeListByFrIdData", {idFranchisee: idFranchisee}, function (result) {
        if (result != '') {
            $("#szClient").empty();
            $("#szClient").html(result);
            $("#szSearchClientname").customselect();
        }
    });
}
function ViewpdfSalesCrmDetailedReport(startDate, endDate, franchiseeId, status, szBusinessName) {
    $.post(__BASE_URL__ + "/prospect/View_pdf_Sales_Crm_Detailed_Report", {
        startDate: startDate,
        endDate: endDate,
        franchiseeId: franchiseeId,
        status: status,
        szBusinessName: szBusinessName
    }, function (result) {
        ar_result = result.split('||||');
        var URL = __BASE_URL__ + "/prospect/" + ar_result[1];
        window.open(URL, '_blank');

    });
}

function ViewexcelSalesCrmDetailedReport(startDate, endDate, franchiseeId, status, szBusinessName) {
    $.post(__BASE_URL__ + "/prospect/View_xls_Sales_Crm_Detailed_Report", {
        startDate: startDate,
        endDate: endDate,
        franchiseeId: franchiseeId,
        status: status,
        szBusinessName: szBusinessName
    }, function (result) {
        ar_result = result.split('||||');
        var URL = __BASE_URL__ + "/prospect/" + ar_result[1];
        window.open(URL, '_blank');

    });
}
function ViewpdfRevenueSummeryClient(franchiseeId, clientId, dtStart, dtEnd, singleline) {
    if(!singleline){
        singleline = 0;
    }
    $.post(__BASE_URL__ + "/reporting/ViewpdfofRevenueSummaryClient", {
        franchiseeId: franchiseeId,
        clientId: clientId,
        dtStart: dtStart,
        dtEnd: dtEnd,
        singleline: singleline
    }, function (result) {
        ar_result = result.split('||||');
        var URL = __BASE_URL__ + "/reporting/" + ar_result[1];
        window.open(URL, '_blank');
    });
}
function ViewexcelRevenueSummeryClient(franchiseeId, clientId, dtStart, dtEnd, singleline) {
    if(!singleline){
        singleline = 0;
    }
    $.post(__BASE_URL__ + "/reporting/ViewexcelofRevenueSummeryClient", {
        franchiseeId: franchiseeId,
        clientId: clientId,
        dtStart: dtStart,
        dtEnd: dtEnd,
        singleline: singleline
    }, function (result) {
        ar_result = result.split('||||');
        var URL = __BASE_URL__ + "/reporting/" + ar_result[1];
        window.open(URL, '_blank');


    });

}
function industryReportChart(dtStart, dtEnd, szIndustry, szTestType) {

    $.post(__BASE_URL__ + "/reporting/industryReportChart", {
        dtStart: dtStart,
        dtEnd: dtEnd,
        szIndustry: szIndustry,
        szTestType: szTestType
    }, function (result) {
        ar_result = result.split('||||');
        var URL = __BASE_URL__ + "/reporting/" + ar_result[1];
        window.open(URL, '_blank');

    });
}
function receive_order_details(idOrder) {

    jQuery('#loader').attr('style', 'display:block');
    $.post(__BASE_URL__ + "/order/receiveOrderData", {idOrder: idOrder}, function (result) {
        var result_ary = result.split("||||");
        var res = result_ary[0].trim(" ");
        if (res == 'SUCCESS') {
            $("#popup_box").html(result_ary[1]);
            $('#receiveOrder').modal("show");
            jQuery('#loader').attr('style', 'display:none');
        }


    });
}
function receiveordstatus(idOrder,orderdate) {
    
     var startDate = jQuery('#szSearch4').val();
     var endDate = jQuery('#szSearch5').val();
     var frName = jQuery('#szSearch1').val();
     var orderNo = jQuery('#szSearch2').val();
    
    jQuery('#loader').attr('style', 'display:block');
    $.post(__BASE_URL__ + "/order/receiveordConfirmation", {idOrder: idOrder, orderdate: orderdate,startDate: startDate,endDate: endDate,frName: frName,orderNo: orderNo}, function (result) {
        
        
         var result_ary = result.split("||||"); 
         if (result_ary[0] == 'SUCCESS')
        {
            $('.modal-backdrop').remove();
            $('#static').modal("hide");
            $('#receiveOrder').modal("hide");
            $("#popup_box").html(result_ary[1]);
             $('#receiveOrderConfirmation').modal("show");
             jQuery("#table_content_data").html(result_ary[2]);
        }
        jQuery('#loader').attr('style', 'display:none');

    });
}
function comparisonReportChart(siteid, testtype, comparetype) {
    $.post(__BASE_URL__ + "/reporting/comparisonReportChart", {
        siteid: siteid,
        testtype: testtype,
        comparetype: comparetype
    }, function (result) {
        ar_result = result.split('||||');
        var URL = __BASE_URL__ + "/reporting/" + ar_result[1];
        window.open(URL, '_blank');

    });
}
function revenueGenerateChart(dtStart, dtEnd, szFranchisee) {
    $.post(__BASE_URL__ + "/reporting/revenueGenerateOfChart", {
        dtStart: dtStart,
        dtEnd: dtEnd,
        szFranchisee: szFranchisee
    }, function (result) {
        ar_result = result.split('||||');
        var URL = __BASE_URL__ + "/reporting/" + ar_result[1];
        window.open(URL, '_blank');

    });
}
function view_meeting_note_pdf(idProspect) {
    $.post(__BASE_URL__ + "/prospect/viewMeetingNotePdfData", {idProspect: idProspect}, function (result) {
        ar_result = result.split('||||');
        var URL = __BASE_URL__ + "/prospect/" + ar_result[1];
        window.open(URL, '_blank');

    });
}
function View_meeting_note_excel(idProspect) {
    $.post(__BASE_URL__ + "/prospect/ViewMeetingNoteExcelData", {idProspect: idProspect}, function (result) {
        ar_result = result.split('||||');
        var URL = __BASE_URL__ + "/prospect/" + ar_result[1];
        window.open(URL, '_blank');
    });

}
function changeAgentPassword(agentId) {
    jQuery('#loader').attr('style', 'display:block');
    $.post(__BASE_URL__ + "/franchisee/changeAgentPasswordAlert", {agentId: agentId}, function (result) {
        var result_ary = result.split("||||");
        var res = result_ary[0].trim(" ");
        if (res == 'SUCCESS') {
            $("#popup_box").html(result_ary[1]);
            $('#agentChangePassword').modal("show");
        }
        jQuery('#loader').attr('style', 'display:none');

    });
}
function changeAgentPasswordConfirmation(agentId) {

    var value = jQuery("#changePasswordForm").serialize();
    var newValue = value + "&agentId=" + agentId;

    $('.modal-backdrop').remove();
    $('#static').modal("hide");
    $('#agentChangePassword').modal("hide");
    jQuery('#loader').attr('style', 'display:block');
    $.post(__BASE_URL__ + "/franchisee/changeAgentPasswordConfirmation", newValue, function (result) {
        var result_ary = result.split("||||");
        var res = result_ary[0].trim(" ");
        if (res == 'SUCCESS') {
            $("#popup_box").html(result_ary[1]);
            $('#agentChangePasswordConfirmation').modal("show");
            jQuery('#loader').attr('style', 'display:none');
        } else {
            $("#popup_box").html(result);
            $('#agentChangePassword').modal("show");
            jQuery('#loader').attr('style', 'display:block');
        }


    });
}
function getBussinessListByFrId(idFranchisee) {
    $.post(__BASE_URL__ + "/prospect/getBussinessListByFrIdData", {idFranchisee: idFranchisee}, function (result) {
        if (result != '') {
            $("#szBusinessName").empty();
            $("#szBusinessName").html(result);
            $("#szSearchBussName").customselect();
        }
    });
}
function viewTaxIncoice(idsite, Drugtestid, sosid) {

    $.post(__BASE_URL__ + "/ordering/viewTaxIncoiceData", {
        idsite: idsite, Drugtestid: Drugtestid, sosid: sosid
    }, function (result) {

        ar_result = result.split('||||');

        window.location = __BASE_URL__ + "/ordering/" + ar_result[1];

    });
}
function taxInvoicepdf(idsite, Drugtestid, sosid) {
    $.post(__BASE_URL__ + "/ordering/taxInvoicepdfData", {
        idsite: idsite,
        Drugtestid: Drugtestid,
        sosid: sosid
    }, function (result) {
        ar_result = result.split('||||');
        var URL = __BASE_URL__ + "/ordering/" + ar_result[1];
        window.open(URL, '_blank');
    });
}
function updateCartData(prodcount) {
    var check = 0;
    var prodname = '';
    for (var j = 1; j <= prodcount; j++) {
        var qty = $('#order_quantity' + j).val();
        var minqty = $('#min_prod_quantity' + j).val();
        prodname = $('#prod_code' + j).val();
        if (parseInt(qty) < parseInt(minqty)) {
            check = 1;
            break;
        }
    }
    if (check == 1) {
        placeOrderErrorConfirmation(minqty,prodname);
    }
    else {
        $("#updateCart").submit();
    }
}

function unassignSite(mapid) {
    jQuery('#loader').attr('style', 'display:block');
    $.post(__BASE_URL__ + "/franchisee/unassignSiteAlert", {mapid: mapid,}, function (result) {
        var result_ary = result.split("||||");
        var res = result_ary[0].trim(" ");
        if (res == 'SUCCESS') {
            $("#popup_box").html(result_ary[1]);
            $('#unassignSiteAlert').modal("show");
            jQuery('#loader').attr('style', 'display:none');
        }
    });
}
function unassignSiteConfirmation(mapid) {

    $('.modal-backdrop').remove();
    $('#static').modal("hide");
    $('#approveReplyAlert').modal("hide");
    jQuery('#loader').attr('style', 'display:block');
    $.post(__BASE_URL__ + "/franchisee/unassignSiteConfirmation", {mapid: mapid}, function (result) {
        var result_ary = result.split("||||");
        var res = result_ary[0].trim(" ");
        if (res == 'SUCCESS') {
            $("#popup_box").html(result_ary[1]);
            $('#unassignSiteConfirmation').modal("show");
        }
        jQuery('#loader').attr('style', 'display:none');
    });
}
function ViewpdfFrStockQtyReport(franchiseeName, prodCategory) {
    $.post(__BASE_URL__ + "/reporting/ViewpdfFrStockQtyReportData", {
        franchiseeName: franchiseeName,
        prodCategory: prodCategory
    }, function (result) {
        ar_result = result.split('||||');
        var URL = __BASE_URL__ + "/reporting/" + ar_result[1];
        window.open(URL, '_blank');

    });
}
function ViewexcelFrStockQtyReport(franchiseeName, prodCategory) {
    $.post(__BASE_URL__ + "/reporting/ViewExcelFrStockQtyReportData", {
        franchiseeName: franchiseeName,
        prodCategory: prodCategory
    }, function (result) {
        ar_result = result.split('||||');
        var URL = __BASE_URL__ + "/reporting/" + ar_result[1];
        window.open(URL, '_blank');


    });
}

function viewProductDetails(idProduct, flag) {
    jQuery('#loader').attr('style', 'display:block');
    $.post(__BASE_URL__ + "/inventory/viewProductDetails", {idProduct: idProduct, flag: flag}, function (result) {
        var result_ary = result.split("||||");
        var res = result_ary[0].trim(" ");
        if (res == 'SUCCESS') {
            $("#popup_box").html(result_ary[1]);
            $('#ViewProductDetails').modal("show");
        }
        jQuery('#loader').attr('style', 'display:none');

    });
}

function getDivImage(divid, linkid) {
    var element = $("#" + divid); // global variable
    var getCanvas; // global variable
    html2canvas(element, {
        onrendered: function (canvas) {
            getCanvas = canvas;
            var imgageData = canvas.toDataURL("image/png");
            // Now browser starts downloading it instead of just showing it
            var newData = imgageData.replace(/^data:image\/png/, "data:application/octet-stream");
            $("#" + linkid).attr("download", "report.png").attr("href", newData);

        }
    });

}
function ViewExcelClientReport(frId,clName,fromDate,toDate) {
    $.post(__BASE_URL__ + "/reporting/ViewExcelClientReportData", {
        frId: frId,
        clName: clName,
        fromDate: fromDate,
        toDate: toDate
    }, function (result) {
        ar_result = result.split('||||');
        var URL = __BASE_URL__ + "/reporting/" + ar_result[1];
        window.open(URL, '_blank');
    });
}
function ViewPdfClientReport(frId,clName,fromDate,toDate) {
    $.post(__BASE_URL__ + "/reporting/ViewPdfClientReportData", {
        frId: frId,
        clName: clName,
        fromDate: fromDate,
        toDate: toDate
    }, function (result) {
        ar_result = result.split('||||');
        var URL = __BASE_URL__ + "/reporting/" + ar_result[1];
        window.open(URL, '_blank');
    });
}
function ViewPdfSiteReport(clientId,siteName,fromDate,toDate,corpclient,idfranchisee) {
    $.post(__BASE_URL__ + "/reporting/ViewPdfSiteReportData", {
        clientId: clientId,
        siteName: siteName,
        fromDate: fromDate,
        toDate: toDate,
        corpclient: corpclient,
        idfranchisee: idfranchisee
    }, function (result) {
        ar_result = result.split('||||');
        var URL = __BASE_URL__ + "/reporting/" + ar_result[1];
        window.open(URL, '_blank');
    });
}
function ViewExcelSiteReport(clientId,siteName,fromDate,toDate,corpclient,idfranchisee) {
    $.post(__BASE_URL__ + "/reporting/ViewExcelSiteReportData", {
         clientId: clientId,
        siteName: siteName,
        fromDate: fromDate,
        toDate: toDate,
        corpclient: corpclient,
        idfranchisee: idfranchisee
    }, function (result) {
        ar_result = result.split('||||');
        var URL = __BASE_URL__ + "/reporting/" + ar_result[1];
        window.open(URL, '_blank');
    });
}