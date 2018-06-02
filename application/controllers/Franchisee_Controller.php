<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Franchisee_Controller extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Order_Model');
        $this->load->model('StockMgt_Model');
        $this->load->library('pagination');
        $this->load->model('Ordering_Model');
        $this->load->model('Forum_Model');
        $this->load->model('Error_Model');
        $this->load->model('Admin_Model');
        $this->load->model('Franchisee_Model');
        $this->load->model('Inventory_Model');
        $this->load->model('Form_Management_Model');
        $this->load->model('StockMgt_Model');
        $this->load->model('Webservices_Model');
        $this->load->library('pagination');
    }
    public function index()
    {
        $is_user_login = is_user_login($this);
        if ($is_user_login) {
            ob_end_clean();
            redirect(base_url('/franchisee/dashboard'));
            die;
        } else {
            ob_end_clean();
            redirect(base_url('/admin/admin_login'));
            die;
        }
    }
    public function dashboard()
    {
        $is_user_login = is_user_login($this);
        // redirect to dashboard if already logged in
        if (!$is_user_login) {
            ob_end_clean();
            redirect(base_url('/admin/admin_login'));
            die;
        }
        $data['szMetaTagTitle'] = "Dashboard";
        $data['is_user_login'] = $is_user_login;
        $data['pageName'] = "Franchisee_Dashboard";
        $this->load->view('layout/admin_header', $data);
        $this->load->view('admin/dashboard');
        $this->load->view('layout/admin_footer');
    }
    function addClientData()
    {
        $idfranchisee = $this->input->post('idfranchisee');
        $idclient = $this->input->post('idclient');
        $url = $this->input->post('url');
        $flag = $this->input->post('flag');
        $this->session->set_userdata('idfranchisee', $idfranchisee);
        $this->session->set_userdata('idclient', $idclient);
        $this->session->set_userdata('url', $url);
        $this->session->set_userdata('flag', $flag);
        echo "SUCCESS||||";
        echo "addClient";
    }
    function addClient()
    {
        $is_user_login = is_user_login($this);
        // redirect to dashboard if already logged in
        if (!$is_user_login) {
            ob_end_clean();
            redirect(base_url('/admin/admin_login'));
            die;
        }
        $count = $this->Admin_Model->getnotification();
        $commentReplyNotiCount = $this->Forum_Model->commentReplyNotifications();
        $validate = $this->input->post('clientData');
        $reqppearr = $this->input->post('req_ppe');
        if ($validate['szState']) {
            $getReginolCode = $this->Admin_Model->getRegionByStateId($validate['szState']);
        }
        $idfranchisee = $this->session->userdata('idfranchisee');
        $url = $this->session->userdata('url');
        $flag = $this->session->userdata('flag');
        $idclient = $this->session->userdata('idclient');
        $getAllStates = $this->Admin_Model->getAllStateByCountryId('101');
        $franchiseeAray = $this->Admin_Model->viewFranchiseeList(false, false, false);
        $franchiseId = $_SESSION['drugsafe_user']['id'];
        $getState=$this->Franchisee_Model->getStateByFranchiseeId($franchiseId);
        $data['corpFranchisee'] = 0;
        if (!empty($idclient)) {
            $franchiseeDetArr1 = $this->Admin_Model->getAdminDetailsByEmailOrId('', $idclient);
            $data['clientDetailsAray'] = $franchiseeDetArr1;
        }
        if (!empty($idfranchisee)) {
            $franchiseeDetArr = $this->Admin_Model->getAdminDetailsByEmailOrId('', $idfranchisee);
            $data['franchiseeArr'] = $franchiseeDetArr;
            if($franchiseeDetArr['franchiseetype'] == '1'){
                $data['corpFranchisee'] = 1;
            }
        }
        if (empty($idclient)) {
            if ($this->Admin_Model->validateParentClientData($validate, array(), $idclient)) {
                if ($this->Franchisee_Model->insertClientDetails($validate, $idfranchisee)) {
                    $szMessage['type'] = "success";
                    $szMessage['content'] = "<h4><strong>Client added successfully.</strong></h4> ";
                    $this->session->set_userdata('drugsafe_user_message', $szMessage);
                    ob_end_clean();
                    $this->session->unset_userdata('idfranchisee');
                    $this->session->unset_userdata('idclient');
                    $this->session->unset_userdata('flag');
                    ob_end_clean();
                    redirect(base_url($url));
                    //header("Location:" . __BASE_URL__ . $url);
                }
            }
        } else {
            if ($this->Admin_Model->validateClientData($validate, array(), $idclient)) {
                $reqppearr = $this->input->post('req_ppe');
                if (!empty($reqppearr)) {
                    $reqppval = '';
                    foreach ($reqppearr as $reqpp) {
                        $reqppval .= $reqpp . ',';
                    }
                    $reqppval = substr($reqppval, 0, -1);
                }
                if ($this->Franchisee_Model->insertClientDetails($validate, $idfranchisee, $reqppval)) {
                    $szMessage['type'] = "success";
                    $szMessage['content'] = "<h4><strong> Site added successfully.</strong></h4>";
                    $this->session->set_userdata('drugsafe_user_message', $szMessage);
                    ob_end_clean();
                    $this->session->unset_userdata('idfranchisee');
                    $this->session->unset_userdata('idclient');
                    $this->session->unset_userdata('flag');
                    ob_end_clean();
                    redirect(base_url($url));
                    //header("Location:" . __BASE_URL__ . $url);
                }
            }
        }
        $data['pageName'] = "Client_Record";
        $data['szMetaTagTitle'] = "Add Client";
        $data['is_user_login'] = $is_user_login;
        $data['notification'] = $count;
        $data['discountarr'] = $this->Franchisee_Model->getDiscountList();
        $data['commentnotification'] = $commentReplyNotiCount;
        $data['franchiseeAray'] = $franchiseeAray;
        $data['validate'] = $validate;
        $data['idfranchisee'] = $idfranchisee;
        $data['getState']=$getState;
        $data['getAllStates'] = $getAllStates;
        $data['getReginolCode'] = $getReginolCode;
        $data['flag'] = $flag;
        $data['szParentId'] = $idclient;
        $data['arErrorMessages'] = $this->Admin_Model->arErrorMessages;
        $this->load->view('layout/admin_header', $data);
        $this->load->view('franchisee/addClient');
        $this->load->view('layout/admin_footer');
    }
    function logout()
    {
        logout($this);
        ob_end_clean();
        redirect(base_url('/admin/admin_login'));
        die();
    }
    function getStatesByCountryClient($szCountry = '')
    {
        if (trim($szCountry) != '') {
            $_POST['szCountry'] = $szCountry;
        }
        $stateAry = $this->Admin_Model->getStatesByCountry(trim($_POST['szCountry']));
        if (!empty($stateAry)) {
            $result = "<select class=\"form-control required\" id=\"szState\" name=\"clientData[szState]\" placeholder=\"State\" onfocus=\"remove_formError(this.id,'true')\">";
            foreach ($stateAry as $stateDetails) {
                $result .= "<option value='" . $stateDetails['name'] . "'>" . $stateDetails['name'] . "</option>";
            }
            $result .= "</select>";
        } else {
            $result = "<input type=\"text\" class=\"form-control required\" id=\"szState\" name=\"clientData[szState]\" placeholder=\"State\" onfocus=\"remove_formError(this.id,'true')\">";
        }
        echo $result;
    }
    function viewClientData()
    {
        $idfranchisee = $this->input->post('idfranchisee');
        {
            $this->session->set_userdata('idfranchisee', $idfranchisee);
            echo "SUCCESS||||";
            echo "clientList";
        }
    }
    function clientList()
    {
        $is_user_login = is_user_login($this);
        // redirect to dashboard if already logged in
        if (!$is_user_login) {
            ob_end_clean();
            redirect(base_url('/admin/admin_login'));
            die;
        }
        $idfranchisee = $this->session->userdata('idfranchisee');
        // handle pagination
        $searchAry = '';
        if (isset($_POST['szSearchClRecord']) && !empty($_POST['szSearchClRecord'])) {
            $id = $_POST['szSearchClRecord'];
        }
        if (isset($_POST['szSearchClRecord1']) && !empty($_POST['szSearchClRecord1'])) {
            $id = $_POST['szSearchClRecord1'];
        }
        if (isset($_POST['szSearchClRecord2']) && !empty($_POST['szSearchClRecord2'])) {
            $id = $_POST['szSearchClRecord2'];
        }
        $config['base_url'] = __BASE_URL__ . "/franchisee/clientList/";
        $config['total_rows'] = count($this->Franchisee_Model->viewClientList(true, $franchiseId, $limit, $offset, $searchAry, $id));
        $config['per_page'] = __PAGINATION_RECORD_LIMIT__;
        $this->pagination->initialize($config);
        $clientAray = $this->Franchisee_Model->viewClientList(true, $idfranchisee, $config['per_page'], $this->uri->segment(3), $searchAry, $id);
        $clientlistArr = $this->Franchisee_Model->viewClientList(true, $idfranchisee);
        $getState=$this->Franchisee_Model->getStateByFranchiseeId($idfranchisee);
        $franchiseeArr = $this->Admin_Model->getAdminDetailsByEmailOrId('', $idfranchisee);
        $count = $this->Admin_Model->getnotification();
        $commentReplyNotiCount = $this->Forum_Model->commentReplyNotifications();
        $frdata = array();
        foreach ($clientAray as $cldata) {
            $franchiseeDataArr = $this->Admin_Model->getAdminDetailsByEmailOrId('', $cldata['szCreatedBy']);
            array_push($frdata, $franchiseeDataArr);
        }
        $data['franchiseeArr'] = $franchiseeArr;
        $data['clientlistArr'] = $clientlistArr;
        $data['franchiseeDataArr'] = $frdata;
        $data['idfranchisee'] = $idfranchisee;
        $data['clientAry'] = $clientAray;
        $data['pageName'] = "Client_Record";
        $data['szMetaTagTitle'] = "Client List";
        $data['is_user_login'] = $is_user_login;
        $data['notification'] = $count;
        $data['getState']=$getState;
        $data['commentnotification'] = $commentReplyNotiCount;
        $this->load->view('layout/admin_header', $data);
        $this->load->view('franchisee/clientList');
        $this->load->view('layout/admin_footer');
    }
    public function deleteClientAlert()
    {
        $data['mode'] = '__DELETE_CLIENT_POPUP__';
        $data['idClient'] = $this->input->post('idClient');
        $data['flag'] = $this->input->post('flag');
        $url = $this->input->post('url');
        $this->session->set_userdata('url', $url);
        $this->load->view('admin/admin_ajax_functions', $data);
    }
    public function deleteClientConfirmation()
    {
        $data['url'] = $this->session->userdata('url');
        $data['mode'] = '__DELETE_CLIENT_CONFIRM__';
        $data['flag'] = $this->input->post('flag');
        $data['idClient'] = $this->input->post('idClient');
        $this->Franchisee_Model->deleteClient($data['idClient']);
        $this->load->view('admin/admin_ajax_functions', $data);
    }
    function getParentClient()
    {
        $franchiseeId = $this->input->post('franchiseeId');
        $clientType = $this->input->post('clientType');
        if ($clientType == '1') {
            $parentClient = $this->Franchisee_Model->getParentClientDetails(trim($franchiseeId));
            if (!empty($parentClient)) {
                $result = "<div id=\"parentId\" class=\"form-group\">
                    <label class=\"col-md-3 control-label\">Parent Client</label>
                        <div class=\"col-md-5\">
                            <div class=\"input-group\">
                                <span class=\"input-group-addon\">
                                    <i class=\"fa fa-user\"></i>
                                </span>
                                <select class=\"form-control required\" name=\"clientData[szParentId]\" id=\"szParentId\"    Placeholder=\"Client Type\" onfocus=\"remove_formError(this.id,\"true\")\">";
                foreach ($parentClient as $parentClientData) {
                    $result .= "<option value='" . $parentClientData['id'] . "'>" . $parentClientData['szName'] . "</option>";
                }
                $result .= "</select>
                                </select>
                            </div>
                        </div>
                </div>";
            }
            echo $result;
        }
    }
    function viewClientDetailsData()
    {
        $idClient = $this->input->post('idClient');
        $idfranchisee = $this->input->post('idfranchisee');
        $corpclient = $this->input->post('corpclient');
        $flag = $this->input->post('flag');
        {
            $this->session->set_userdata('idClient', $idClient);
            $this->session->set_userdata('idfranchisee', $idfranchisee);
            $this->session->set_userdata('corpclient', $corpclient);
            $this->session->set_userdata('flag', $flag);
            echo "SUCCESS||||";
            echo "viewClientDetails";
        }
    }
    function viewClientDetails()
    {
        $is_user_login = is_user_login($this);
        $count = $this->Admin_Model->getnotification();
        $commentReplyNotiCount = $this->Forum_Model->commentReplyNotifications();
        // redirect to dashboard if already logged in
        if (!$is_user_login) {
            ob_end_clean();
            redirect(base_url('/admin/admin_login'));
            die;
        }
        $addEditClientDet = true;
        $idClient = $this->session->userdata('idClient');
        $corpclient = $this->session->userdata('corpclient');
        $flag = $this->session->userdata('flag');
        $frid = $this->session->userdata('idfranchisee');
        if (isset($_POST['szSearchClRecord']) && !empty($_POST['szSearchClRecord'])) {
            $id = $_POST['szSearchClRecord'];
        }
        if (isset($_POST['szSearchClRecord1']) && !empty($_POST['szSearchClRecord1'])) {
            $id = $_POST['szSearchClRecord1'];
        }
        if (isset($_POST['szSearchClRecord2']) && !empty($_POST['szSearchClRecord2'])) {
            $id = $_POST['szSearchClRecord2'];
        }
         if(isset($_POST['szSearch4']) && !empty($_POST['szSearch4'])){
              $fromdate = $this->Webservices_Model->formatdate($_POST['szSearch4']);
        }
         if(isset($_POST['szSearch5']) && !empty($_POST['szSearch5'])){
             $todate = $this->Webservices_Model->formatdate($_POST['szSearch5']);
        }
       
        $config['base_url'] = __BASE_URL__ . "/franchisee/viewClientDetails/";
        $config['total_rows'] = count($this->Franchisee_Model->viewChildClientDetails($idClient, $limit, $offset, $searchAry, $id,$idfranchisee,$fromdate,$todate));
        $config['per_page'] = __PAGINATION_RECORD_LIMIT__;
        $this->pagination->initialize($config);
        
        $clientDetailsAray = $this->Franchisee_Model->viewClientDetails($idClient);
        $franchiseId = $clientDetailsAray['franchiseeId'];
        $idfranchisee = $this->session->userdata('idfranchisee');
        $childClientDetailsAray = $this->Franchisee_Model->viewChildClientDetails($idClient, $config['per_page'], $this->uri->segment(3), $searchAry, $id,$idfranchisee,$fromdate,$todate);
        $clientFranchiseeArr = $this->Franchisee_Model->getClientFranchisee($idClient);
        //$sitesArr = $this->Franchisee_Model->viewChildClientDetails($idClient,0,0,'',0,$idfranchisee);
        $loggedinFranchisee = $frid;
        $clientDetsArr = $this->Webservices_Model->getclientdetailsbyclientid($idClient);
        if(!empty($clientDetsArr)){
            $franchiseeid = $clientDetsArr[0]['franchiseeId'];
        }
        if($franchiseeid != $_SESSION['drugsafe_user']['id']){
            $addEditClientDet = false;
        }
        $sitesArr = array();
        $sitesArr = $this->Webservices_Model->getclientdetails($franchiseeid,$idClient);
        $AssignCorpuserDetailsArr = $this->Webservices_Model->getcorpclientdetails($loggedinFranchisee,$franchiseeid);
        if(!empty($AssignCorpuserDetailsArr)){
            $addEditClientDet = false;
            $sitesArr = array();
            foreach ($AssignCorpuserDetailsArr as $assignCorpUser){
                $CorpuserDetailsArr = $this->Webservices_Model->getclientdetails($assignCorpUser['corpfrid'],$idClient,0,$assignCorpUser['clientid'],$fromdate,$todate);
	            $CorpuserSearchArr = $this->Webservices_Model->getclientdetails($assignCorpUser['corpfrid'],$idClient,0,$assignCorpUser['clientid']);
                if(!empty($CorpuserSearchArr)){
                    foreach ($CorpuserSearchArr as $CorpUser){
                        array_push($sitesArr,$CorpUser);
                    }
                }
            }
        }
    
        if ($clientDetailsAray['clientType'] > 0) {
            $parentClientDetArr = $this->Admin_Model->getAdminDetailsByEmailOrId('', $clientDetailsAray['clientType']);
            $data['ParentOfChild'] = $parentClientDetArr;
        }
        if (!empty($clientFranchiseeArr)) {
            $franchiseeDetArr = $this->Admin_Model->getAdminDetailsByEmailOrId('', $clientFranchiseeArr[0]['franchiseeId']);
            $data['franchiseeArr'] = $franchiseeDetArr;
        }
        if($franchiseeDetArr['franchiseetype'] == 1){
            $getState=$this->Franchisee_Model->getStateByFranchiseeId($idClient);
            $getRegionName = $this->Admin_Model->getregionbyregionid($clientDetailsAray['regionId']);
        }else{
            $getState=$this->Franchisee_Model->getStateByFranchiseeId($franchiseId);
            $getRegionName = $this->Admin_Model->getregionbyregionid($franchiseeDetArr['regionId']);
        }
        $clientAray = $this->Webservices_Model->getFranchiseeWithClient($idClient,$idfranchisee);
        /*if(!empty($clientAray)){
            if(($clientAray[0]['szNoOfSites'] == 0) && $clientAray[0]['clientType'] == 0){
                $addEditClientDet = false;
            }
        }*/
      ;
        $userDetailsArr = array();
        if($corpclient == '1'){
           
            $loggedinFranchisee = $idfranchisee;
            $clientDetsArr = $this->Webservices_Model->getclientdetailsbyclientid($idClient,0,0,0,$fromdate,$todate);
            if(!empty($clientDetsArr)){
                $idfranchisee = $clientDetsArr[0]['franchiseeId'];
            }
            $AssignCorpuserDetailsArr = $this->Webservices_Model->getcorpclientdetails($loggedinFranchisee,$idfranchisee);
            
            if(!empty($AssignCorpuserDetailsArr)){
                $addEditClientDet = false;
                $userDetailsArr = array();
                foreach ($AssignCorpuserDetailsArr as $assignCorpUser){
                    $CorpuserDetailsArr = $this->Webservices_Model->getclientdetails($assignCorpUser['corpfrid'],$idClient,0,$assignCorpUser['clientid'],$fromdate,$todate);
                    if(!empty($CorpuserDetailsArr)){
                        foreach ($CorpuserDetailsArr as $CorpUser){
                            array_push($userDetailsArr,$CorpUser);
                        }
                    }
                }
            }
        }
      
        $data['flag'] = $flag;
        $data['sitesArr'] = $sitesArr;
        $data['idClient'] = $idClient;
        $data['pageName'] = "Client_Record";
        $data['clientDetailsAray'] = $clientDetailsAray;
        $data['childClientDetailsAray'] = ($corpclient == '1'?$userDetailsArr:$childClientDetailsAray);
        $data['szMetaTagTitle'] = "Client Details";
        $data['is_user_login'] = $is_user_login;
        $data['getState']=$getState;
        $data['regionname']=$getRegionName['regionName'];
        $data['notification'] = $count;
        $data['idfranchisee'] = $idfranchisee;
        $data['commentnotification'] = $commentReplyNotiCount;
        $data['addEditClientDet'] = $addEditClientDet;
        $this->load->view('layout/admin_header', $data);
        $this->load->view('franchisee/clientDetails');
        $this->load->view('layout/admin_footer');
    }
    function editClientData()
    {
        $idClient = $this->input->post('idClient');
        $idfranchisee = $this->input->post('idfranchisee');
        $url = $this->input->post('url');
        $flag = $this->input->post('flag');
        if ($idClient > 0) {
            $this->session->set_userdata('idClient', $idClient);
            $this->session->set_userdata('idfranchisee', $idfranchisee);
            $this->session->set_userdata('url', $url);
            $this->session->set_userdata('flag', $flag);
            echo "SUCCESS||||";
            echo "editClient";
        }
    }
    public function editClient()
    {
        $count = $this->Admin_Model->getnotification();
        $commentReplyNotiCount = $this->Forum_Model->commentReplyNotifications();
        $idClient = $this->session->userdata('idClient');
        $flag = $this->session->userdata('flag');
        $idfranchisee = $this->session->userdata('idfranchisee');
        $url = $this->session->userdata('url');
        $clientDetailsAray = $this->Franchisee_Model->viewClientDetails($idClient);
        $franchiseId = $_SESSION['drugsafe_user']['id'];
        //$getState=$this->Franchisee_Model->getStateByFranchiseeId($franchiseId);
        if($clientDetailsAray['regionId'] > 0){
            $getState=$this->Franchisee_Model->getStateByFranchiseeId($idClient);
            $getRegionName = $this->Admin_Model->getregionbyregionid($clientDetailsAray['regionId']);
        }else{
            $getState=$this->Franchisee_Model->getStateByFranchiseeId($clientDetailsAray['franchiseeId']);
            $franchiseeDetArr = $this->Admin_Model->getAdminDetailsByEmailOrId('', $clientDetailsAray['franchiseeId']);
            $getRegionName = $this->Admin_Model->getregionbyregionid($franchiseeDetArr['regionId']);
        }
        if (!empty($clientDetailsAray['clientType'])) {
            $franchiseeDetArr2 = $this->Admin_Model->getAdminDetailsByEmailOrId('', $clientDetailsAray['clientType']);
            $data['clientChildDetailsAray'] = $franchiseeDetArr2;
        }
        if (!empty($idClient)) {
            $franchiseeDetArr1 = $this->Admin_Model->getAdminDetailsByEmailOrId('', $clientDetailsAray['clientId']);
            $data['clientDetailsAray'] = $franchiseeDetArr1;
        }
        if (!empty($idfranchisee)) {
            $franchiseeDetArr = $this->Admin_Model->getAdminDetailsByEmailOrId('', $clientDetailsAray['franchiseeId']);
            $data['franchiseeArr'] = $franchiseeDetArr;
        }
        if ($idClient > 0) {
            $data_validate = $this->input->post('clientData');
           
            if (empty($data_validate)) {
                if (empty($clientDetailsAray['clientType'])) {
                    $userDataAry = $this->Franchisee_Model->getUserDetailsByEmailOrId('', $idClient);
                } else {
                    $userDataAry = $this->Franchisee_Model->getSiteDetailsById($idClient);
                }
                if ($userDataAry['clientType'] != '0') {
                    $parentClient = $this->Franchisee_Model->getParentClientDetails(trim($idfranchisee));
                }
            } else {
                $userDataAry = $data_validate;
            }
            if (empty($clientDetailsAray['clientType'])) {
                if ($this->Admin_Model->validateParentClientData($data_validate, array(), $idClient)) {
                    if ($this->Franchisee_Model->updateClientDetails($idClient, $userDataAry)) {
                        $szMessage['type'] = "success";
                        $szMessage['content'] = "<h4><strong>Client details successfully updated.</strong></h4> ";
                        $this->session->set_userdata('drugsafe_user_message', $szMessage);
                        ob_end_clean();
                        if ($flag == 2) {
                            $mrActive = $flag;
                            $this->session->set_userdata('drugsafe_tab_status', $mrActive);
                            $this->session->unset_userdata('idClient');
                            $this->session->unset_userdata('idfranchisee');
                            $this->session->unset_userdata('url');
                            $this->session->unset_userdata('flag');
                            redirect(base_url('/franchisee/clientRecord'));
                            die;
                        }
                        redirect(base_url($url));
                        //header("Location:" . __BASE_URL__ . $url);
                        //die;
                    }
                }
            } else {
                $reqppearr = $this->input->post('req_ppe');
                if ($this->Admin_Model->validateClientData($data_validate, array(), $idClient)) {
                    $reqppval = '';
                    foreach ($reqppearr as $reqpp) {
                        $reqppval .= $reqpp . ',';
                    }
                    $reqppval = substr($reqppval, 0, -1);
                    if ($this->Franchisee_Model->updateClientDetails($idClient, $userDataAry, $reqppval)) {
                        $szMessage['type'] = "success";
                        if ($clientDetailsAray['clientType'] != '0') {
                            $szMessage['content'] = "<h4><strong>Site details successfully updated.</strong></h4> ";
                        } else {
                            $szMessage['content'] = "<h4><strong>Client details successfully updated. </strong></h4> ";
                        }
                        $this->session->set_userdata('drugsafe_user_message', $szMessage);
                        ob_end_clean();
                        redirect(base_url($url));
                        /*header("Location:" . __BASE_URL__ . $url);
                        die;*/
                    }
                }
            }
            if (!empty($clientDetailsAray['clientType'])) {
                $req_ppe_ary = explode(",", $userDataAry['req_ppe']);
                $data['req_ppe_ary'] = $req_ppe_ary;
            }
            $data['szMetaTagTitle'] = "Edit Client Details ";
            $data['pageName'] = "Client_Record";
            $data['flag'] = $flag;
            $data['discountarr'] = $this->Franchisee_Model->getDiscountList();
            $data['idClient'] = $idClient;
            $_POST['clientData'] = $userDataAry;
            $data['idfranchisee'] = $idfranchisee;
            $data['parentClient'] = $parentClient;
            $data['getState']=$getState;
            $data['regionname']=$getRegionName['regionName'];
            $data['arErrorMessages'] = $this->Admin_Model->arErrorMessages;
            $data['notification'] = $count;
            $data['commentnotification'] = $commentReplyNotiCount;
            $this->load->view('layout/admin_header', $data);
            $this->load->view('franchisee/editClient');
            $this->load->view('layout/admin_footer');
        }
    }
  function franchiseeClientRecord()
    {
        $is_user_login = is_user_login($this);
        $count = $this->Admin_Model->getnotification();
        $commentReplyNotiCount = $this->Forum_Model->commentReplyNotifications();
        if (!$is_user_login) {
            ob_end_clean();
            redirect(base_url('/admin/admin_login'));
            die;
        }
         $searchAry = '';
        
        if(isset($_POST['szSearchFrRecord']) && !empty($_POST['szSearchFrRecord'])){
            $idFr = $_POST['szSearchFrRecord'];
        }
//        print_r($id);die;
        if($idFr>0){
            
         //$clientAray = $this->Franchisee_Model->getAllClientDetails(true,$idFr);
            $AllclientAry = $this->Webservices_Model->getclientdetails($idFr);
            $AssignCorpuserDetailsArr = $this->Webservices_Model->getcorpclientdetails($idFr);
            $CorpuserDetailsArr = array();
            if(!empty($AssignCorpuserDetailsArr)){
                foreach ($AssignCorpuserDetailsArr as $assignCorpUser){
                    $CorpSitesDetailsArr = $this->Webservices_Model->getclientdetails($assignCorpUser['corpfrid']);
                    if(!empty($CorpSitesDetailsArr)){
                        foreach ($CorpSitesDetailsArr as $CorpUser){
                            if(!in_array($CorpUser,$CorpuserDetailsArr)){
                                array_push($CorpuserDetailsArr,$CorpUser);
                            }
                        }
                    }
                }
            }
            if(!empty($AllclientAry) && !empty($CorpuserDetailsArr)){
                $clientAray = array_merge($AllclientAry, $CorpuserDetailsArr);
            }elseif(!empty($AllclientAry)){
                $clientAray = $AllclientAry;
            }elseif(!empty($CorpuserDetailsArr)){
                $clientAray = $CorpuserDetailsArr;
            }
         if(!empty($clientAray)){
           $this->session->set_userdata('idFr', $idFr);
            redirect(base_url('/franchisee/clientRecord'));
         }   
        }
    
        $data['clientAry'] = $clientAray;
        $data['pageName'] = "Client_Record";
        $data['szMetaTagTitle'] = "Client Record";
        $data['is_user_login'] = $is_user_login;
        $data['notification'] = $count;
        $data['commentnotification'] = $commentReplyNotiCount;
        $this->load->view('layout/admin_header', $data);
        $this->load->view('franchisee/clientRecordByFr');
        $this->load->view('layout/admin_footer');
    }
   function clientRecord()
    {
        $is_user_login = is_user_login($this);
        if (!$is_user_login) {
            ob_end_clean();
            redirect(base_url('/admin/admin_login'));
            die;
        }
        if(($_SESSION['drugsafe_user']['iRole']==1)||($_SESSION['drugsafe_user']['iRole']==5)){
           if(!empty($_POST['szSearchClRecord2']))
         {
           $idFr = $_POST['szSearchClRecord2'];   
         }
         else{
           $idFr = $this->session->userdata('idFr');  
         }  
      
          if (!empty($_POST)) {
            $_POST['szSearchClRecord2'] = $_POST['szSearchClRecord2'];
        } else {
            $_POST['szSearchClRecord2'] = $idFr;
        }
          
        }
        else{
           $idFr = $_SESSION['drugsafe_user']['id'];  
        }
      if(isset($_POST['szSearchClRecord1']) && !empty($_POST['szSearchClRecord1'])){
            $clientId = $_POST['szSearchClRecord1'];
        }
         if(isset($_POST['szSearch4']) && !empty($_POST['szSearch4'])){
              $fromdate = $this->Webservices_Model->formatdate($_POST['szSearch4']);
        }
         if(isset($_POST['szSearch5']) && !empty($_POST['szSearch5'])){
             $todate = $this->Webservices_Model->formatdate($_POST['szSearch5']);
        }
         $config['base_url'] = __BASE_URL__ . "/franchisee/clientRecord/";
         $config['total_rows'] = count($this->Franchisee_Model->getAllClientDetails(true,$idFr,$clientId,$config['per_page'],$this->uri->segment(3),$fromdate,$todate));
         $config['per_page'] = __PAGINATION_RECORD_LIMIT__;
           
            
        $this->pagination->initialize($config);
        
        $clientAray = $this->Franchisee_Model->getAllClientDetails(true,$idFr,$clientId,$config['per_page'],$this->uri->segment(3),$fromdate,$todate);
      
        /*$AssignCorpuserDetailsArr = $this->Webservices_Model->getcorpclientdetails($idFr);
        $CorpuserDetailsArr = array();
        if(!empty($AssignCorpuserDetailsArr)){
            foreach ($AssignCorpuserDetailsArr as $assignCorpUser){
                $CorpSitesDetailsArr = $this->Webservices_Model->getclientdetails($assignCorpUser['corpfrid']);
                if(!empty($CorpSitesDetailsArr)){
                    foreach ($CorpSitesDetailsArr as $CorpUser){
                        array_push($CorpuserDetailsArr,$CorpUser);
                    }
                }
            }
        }*/
        //$clientlistArr = $this->Franchisee_Model->getAllDistinctClientDetails(true,$idFr);
        $AllclientAry = $this->Webservices_Model->getclientdetails($idFr);
        $AssignCorpuserDetailsArr = $this->Webservices_Model->getcorpclientdetails($idFr);
        $CorpuserDetailsArr = array();
        if(!empty($AssignCorpuserDetailsArr)){
            foreach ($AssignCorpuserDetailsArr as $assignCorpUser){
                $CorpSitesDetailsArr = $this->Webservices_Model->getclientdetails($assignCorpUser['corpfrid'],0,0,0,$fromdate,$todate);
	            $CorpSitesSearchArr = $this->Webservices_Model->getclientdetails($assignCorpUser['corpfrid']);
                if(!empty($CorpSitesDetailsArr)){
                    foreach ($CorpSitesDetailsArr as $CorpUser){
                        if(!in_array($CorpUser,$CorpuserDetailsArr)){
                            array_push($CorpuserDetailsArr,$CorpUser);
                        }
                    }
                }
	            if(!empty($CorpSitesSearchArr)){
		            foreach ($CorpSitesSearchArr as $CorpUser){
			            if(!in_array($CorpUser,$CorpSitesSearchArr)){
				            array_push($CorpSitesSearchArr,$CorpUser);
			            }
		            }
	            }
            }
        }
        if(!empty($AllclientAry) && !empty($CorpSitesSearchArr)){
            $clientlistArr = array_merge($AllclientAry, $CorpSitesSearchArr);
        }elseif(!empty($AllclientAry)){
            $clientlistArr = $AllclientAry;
        }elseif(!empty($CorpuserDetailsArr)){
            $clientlistArr = $CorpSitesSearchArr;
        }
        if(!empty($_POST)){
           $_POST['szSearchClRecord2']= $_POST['szSearchClRecord2'];  
        }
        else{
        $_POST['szSearchClRecord2']=$idFr;
        }
         $this->session->set_userdata('idFr', $idFr);
        $data['clientAry'] = $clientAray;
        $data['id'] = $id;
        $data['flag'] = $flag;
        $data['clientlistArr'] = $clientlistArr;
        $data['corpuserDetailsArr'] = $CorpuserDetailsArr;
        $data['pageName'] = "Client_Record";
        $data['szMetaTagTitle'] = "Client Record";
        $data['is_user_login'] = $is_user_login;
        $data['notification'] = $count;
        $data['idfranchisee'] = $idFr;
        $data['commentnotification'] = $commentReplyNotiCount;
        $this->load->view('layout/admin_header', $data);
        $this->load->view('franchisee/clientRecord');
        $this->load->view('layout/admin_footer');
   
    }
    function viewFranchiseeData()
    {
        $idOperationManager = $this->input->post('idOperationManager');
        $this->session->set_userdata('idOperationManager', $idOperationManager);
        echo "SUCCESS||||";
        echo "franchiseeRecord";
    }
    function franchiseeRecord()
    {
        $is_user_login = is_user_login($this);
        // redirect to dashboard if already logged in
        if (!$is_user_login) {
            ob_end_clean();
            redirect(base_url('/admin/admin_login'));
            die;
        }
        $count = $this->Admin_Model->getnotification();
        $searchAry = '';
       
        if (isset($_POST['szSearch2']) && !empty($_POST['szSearch2'])) {
            $name = $_POST['szSearch2'];
        }
        $idOperationManager = $this->session->userdata('idOperationManager');
        // handle pagination
        $searchAry = $_POST['szSearchClList'];
        $config['base_url'] = __BASE_URL__ . "/franchisee/franchiseeRecord/";
        $config['total_rows'] = count($this->Admin_Model->viewFranchiseeList($searchAry, $operationManagerAray['id'], false, false, $id, $name, $email));
        $config['per_page'] = __PAGINATION_RECORD_LIMIT__;
        $this->pagination->initialize($config);
        $operationManagerAray = $this->Franchisee_Model->getOperationManagerDetailsById($idOperationManager);
        $franchiseeAray = $this->Admin_Model->viewFranchiseeList($searchAry, $operationManagerAray['id'], $config['per_page'], $this->uri->segment(3), $id, $name, $email);
        $searchOptionArr =$this->Admin_Model->viewDistinctFranchiseeList($operationManagerAray['id']);
        
        $data['allfranchisee'] = $searchOptionArr;
        $data['operationManagerAray'] = $operationManagerAray;
        $data['franchiseeAray'] = $franchiseeAray;
        $data['idOperationManager'] = $idOperationManager;
        $data['pageName'] = "Operation_Manager_List";
        $data['szMetaTagTitle'] = "Franchisee List";
        $data['is_user_login'] = $is_user_login;
        $data['notification'] = $count;
        $this->load->view('layout/admin_header', $data);
        $this->load->view('franchisee/franchiseeRecord');
        $this->load->view('layout/admin_footer');
    }
    function addAgentEmployeeData()
    {
        $idclient = $this->input->post('idclient');
        $flag = $this->input->post('flag');
        $this->session->set_userdata('idclient', $idclient);
        $this->session->set_userdata('flag', $flag);
        echo "SUCCESS||||";
        echo "addAgentEmployee";
    }
    function addAgentEmployee()
    {
        $is_user_login = is_user_login($this);
        if (!$is_user_login) {
            ob_end_clean();
            redirect(base_url('/admin/admin_login'));
            die;
        }
        $franchiseId = $_SESSION['drugsafe_user']['id'];
        $getState=$this->Franchisee_Model->getStateByFranchiseeId($franchiseId);
        $getAllStates = $this->Admin_Model->getAllStateByCountryId('101');
        $allIndustry = $this->Admin_Model->viewAllIndustryList();
        /*if ($_POST['agentData']['szState']) {
            $getReginolCode = $this->Admin_Model->getRegionByStateId($_POST['agentData']['szState']);
        }*/
        $this->load->library('form_validation');
        $this->form_validation->set_rules('agentData[szBusinessName]', 'Name', 'required|alpha_dash_space|chekDuplicate['. __DBC_SCHEMATA_USERS__ . '.szName]');
        $this->form_validation->set_message('alpha_dash_space', ' %s must be only letters and white space.');
        $this->form_validation->set_rules('agentData[abn]', 'ABN', 'required|abn_numeric|abn_length');
        $this->form_validation->set_rules('agentData[szEmail]', 'Email', 'required|chekDuplicate['. __DBC_SCHEMATA_USERS__ . '.szEmail]|valid_email');
        $this->form_validation->set_rules('agentData[szContactNumber]', 'Contact No.', 'required|valid_phone_number');
        $this->form_validation->set_rules('agentData[szAddress]', 'Address', 'required');
        $this->form_validation->set_rules('agentData[szState]', 'State', 'required');
        $this->form_validation->set_rules('agentData[szCity]', 'City', 'required');
        $this->form_validation->set_rules('agentData[szZipCode]', 'ZIP/Postal Code', 'required|zipCode_legth');
        $this->form_validation->set_message('valid_phone_number', ' %s : enter 10 digit number.');
        $this->form_validation->set_message('abn_numeric', ' %s must be only digits.');
        $this->form_validation->set_message('chekDuplicate', ' %s must be unique.');
        $this->form_validation->set_message('abn_length', ' %s must contain 11 digits only.');
        $this->form_validation->set_message('zipCode_legth', ' %s must contain 4 digits only.');
        $this->form_validation->set_message('required', '{field} is required.');
        if ($this->form_validation->run() == FALSE) {
            $data['pageName'] = "Agent_Record";
            $data['szMetaTagTitle'] = "Add Agent";
            $data['is_user_login'] = $is_user_login;
            $data['allIndustry'] = $allIndustry;
            $data['getState']=$getState;
            $data['getAllStates'] = $getAllStates;
//            $data['getReginolCode'] = $getReginolCode;
            $this->load->view('layout/admin_header', $data);
            $this->load->view('franchisee/addAgent');
            $this->load->view('layout/admin_footer');
        } else {
            if ($this->Franchisee_Model->insertAgentDetails($_POST['agentData'])) {
                $this->session->set_userdata('addagentsucess', "Agent/Employee added successfully.");
                redirect(base_url('/franchisee/agentRecord'));
            }
        }
    }
    function editAgentEmployeeData()
    {
        $idAgent = $this->input->post('idAgent');
        if ($idAgent > 0) {
            $this->session->set_userdata('idAgent', $idAgent);
            echo "SUCCESS||||";
            echo "editAgentEmployee";
        }
    }
    public function editAgentEmployee()
    {
        $is_user_login = is_user_login($this);
        // redirect to dashboard if already logged in
        if (!$is_user_login) {
            ob_end_clean();
            redirect(base_url('/admin/admin_login'));
            die;
        }
        $count = $this->Admin_Model->getnotification();
        $commentReplyNotiCount = $this->Forum_Model->commentReplyNotifications();
        $idAgent = $this->session->userdata('idAgent');
        $franchiseId = $_SESSION['drugsafe_user']['id'];
        $getState=$this->Franchisee_Model->getStateByAgentid($idAgent);
        $getAllStates = $this->Admin_Model->getAllStateByCountryId('101');
        if ($idAgent > 0) {
            $data_validate = $this->input->post('agentData');
            if (empty($data_validate)) {
                $recordArr = $this->Franchisee_Model->getAgentrecord($franchiseId,$idAgent);
                
                $agentDataArray = $recordArr[0];
            } else {
                $agentDataArray = $data_validate;
                $agentoriginaldata = $this->Franchisee_Model->getAgentrecord($franchiseId, $idAgent);
            }
        }
        $this->load->library('form_validation');
        if ($agentoriginaldata[0]['szName'] != $data_validate['szName']) {
            $isuniqueName = '|chekDuplicate['. __DBC_SCHEMATA_USERS__ . '.szName]';
        } else {
            $isuniqueName = '';
        }
        $this->form_validation->set_rules('agentData[szName]', 'Name', 'required|alpha_dash_space' . $isuniqueName);
        $this->form_validation->set_message('alpha_dash_space', ' %s must be only letters and white space.');
        $this->form_validation->set_rules('agentData[abn]', 'ABN', 'required|abn_numeric|abn_length');
      
        if ($agentoriginaldata[0]['szEmail'] != $data_validate['szEmail']) {
            $isunique = '|chekDuplicate['. __DBC_SCHEMATA_USERS__ . '.szEmail]';
        } else {
            $isunique = '';
        }
        $this->form_validation->set_rules('agentData[szEmail]', 'Email', 'required|valid_email' . $isunique);
        $this->form_validation->set_rules('agentData[szContactNumber]', 'Contact No.', 'required|valid_phone_number');
        $this->form_validation->set_rules('agentData[szAddress]', 'Address', 'required');
        $this->form_validation->set_rules('agentData[szState]', 'State', 'required');
        $this->form_validation->set_rules('agentData[szCity]', 'City', 'required');
        $this->form_validation->set_rules('agentData[szZipCode]', 'ZIP/Postal Code', 'required|zipCode_legth');
        $this->form_validation->set_message('valid_phone_number', ' %s : enter 10 digit number.');
        $this->form_validation->set_message('abn_numeric', ' %s must be only digits.');
        $this->form_validation->set_message('chekDuplicate', ' %s must be unique.');
        $this->form_validation->set_message('abn_length', ' %s must contain 11 digits only.');
        $this->form_validation->set_message('zipCode_legth', ' %s must contain 4 digits only.');
        $this->form_validation->set_message('required', '{field} is required.');
        if ($this->form_validation->run() == FALSE) {
            $data['szMetaTagTitle'] = "Edit Client Details ";
            $data['pageName'] = "Agent_Record";
            $data['idAgent'] = $idAgent;
            $_POST['agentData'] = $agentDataArray;
            $data['notification'] = $count;
            $data['getAllStates'] = $getAllStates;
            $data['getState']=$getState;
            $data['commentnotification'] = $commentReplyNotiCount;
            $this->load->view('layout/admin_header', $data);
            $this->load->view('franchisee/editAgent');
            $this->load->view('layout/admin_footer');
        } else {
            if ($this->Franchisee_Model->updateAgentDetails($data_validate, $idAgent)) {
                $this->session->set_userdata('addagentsucess', "Agent/Employee record updated successfully.");
                redirect(base_url('/franchisee/agentRecord'));
            }
        }
    }
    function viewClientAgentDetailsData()
    {
        $idClient = $this->input->post('idClient');
        $flag = $this->input->post('flag');
        {
            $this->session->set_userdata('idClient', $idClient);
            $this->session->set_userdata('flag', $flag);
            echo "SUCCESS||||";
            echo "viewClientAgentDetails";
        }
    }
    function viewClientAgentDetails()
    {
        $is_user_login = is_user_login($this);
        $count = $this->Admin_Model->getnotification();
        $commentReplyNotiCount = $this->Forum_Model->commentReplyNotifications();
        // redirect to dashboard if already logged in
        if (!$is_user_login) {
            ob_end_clean();
            redirect(base_url('/admin/admin_login'));
            die;
        }
        $idClient = $this->session->userdata('idClient');
        if (isset($_POST['szSearchClRecord']) && !empty($_POST['szSearchClRecord'])) {
            $id = $_POST['szSearchClRecord'];
        }
        if (isset($_POST['szSearchClRecord1']) && !empty($_POST['szSearchClRecord1'])) {
            $id = $_POST['szSearchClRecord1'];
        }
        if (isset($_POST['szSearchClRecord2']) && !empty($_POST['szSearchClRecord2'])) {
            $id = $_POST['szSearchClRecord2'];
        }
        $config['base_url'] = __BASE_URL__ . "/franchisee/viewClientDetails/";
        $config['total_rows'] = count($this->Franchisee_Model->viewAgentDetails($idClient, $limit, $offset, $searchAry, $id));
        $config['per_page'] = __PAGINATION_RECORD_LIMIT__;
        $this->pagination->initialize($config);
        $clientDetailsAray = $this->Franchisee_Model->viewClientDetails($idClient);
        $agentDetailsAray = $this->Franchisee_Model->viewAgentDetails($idClient, $config['per_page'], $this->uri->segment(3), $searchAry, $id);
        $clientFranchiseeArr = $this->Franchisee_Model->getClientFranchisee($idClient);
        $agentSearchDetailsAray = $this->Franchisee_Model->viewAgentDetails($idClient);
        if ($clientDetailsAray['clientType'] > 0) {
            $parentClientDetArr = $this->Admin_Model->getAdminDetailsByEmailOrId('', $clientDetailsAray['clientType']);
            $data['ParentOfChild'] = $parentClientDetArr;
        }
        if (!empty($clientFranchiseeArr)) {
            $franchiseeDetArr = $this->Admin_Model->getAdminDetailsByEmailOrId('', $clientFranchiseeArr[0]['franchiseeId']);
            $data['franchiseeArr'] = $franchiseeDetArr;
        }
        $data['agentSearchDetailsAray'] = $agentSearchDetailsAray;
        $data['idClient'] = $idClient;
        $data['pageName'] = "Client_Record";
        $data['clientDetailsAray'] = $clientDetailsAray;
        $data['agentDetailsAray'] = $agentDetailsAray;
        $data['szMetaTagTitle'] = "Client Details";
        $data['is_user_login'] = $is_user_login;
        $data['notification'] = $count;
        $data['commentnotification'] = $commentReplyNotiCount;
        $this->load->view('layout/admin_header', $data);
        $this->load->view('franchisee/viewAgentDetails');
        $this->load->view('layout/admin_footer');
    }
    public function agentDeleteAlert()
    {
        $data['mode'] = '__DELETE_AGENT_POPUP__';
        $data['id_agent'] = $this->input->post('id_agent');
        $this->load->view('admin/admin_ajax_functions', $data);
    }
    public function agentDeleteConfirmation()
    {
        $data['mode'] = '__DELETE_AGENT_CONFIRM__';
        $data['id_agent'] = $this->input->post('id_agent');
        $this->Franchisee_Model->deleteAgent($data['id_agent']);
        $this->load->view('admin/admin_ajax_functions', $data);
    }
    function viewAgentEmployeeDetailsData()
    {
        $idAgent = $this->input->post('idAgent');
        $flag = $this->input->post('flag');
        {
            $this->session->set_userdata('idAgent', $idAgent);
            $this->session->set_userdata('flag', $flag);
            echo "SUCCESS||||";
            echo "viewAgentEmployeeDetails";
        }
    }
    function viewAgentEmployeeDetails()
    {
        $is_user_login = is_user_login($this);
        $count = $this->Admin_Model->getnotification();
        $commentReplyNotiCount = $this->Forum_Model->commentReplyNotifications();
        // redirect to dashboard if already logged in
        if (!$is_user_login) {
            ob_end_clean();
            redirect(base_url('/admin/admin_login'));
            die;
        }
        $idAgent = $this->session->userdata('idAgent');
        $agentEmployeeDetailsAray = $this->Franchisee_Model->viewAgentEmployeeDetails($idAgent);
        $data['agentEmployeeDetailsAray'] = $agentEmployeeDetailsAray;
        $data['pageName'] = "Client_Record";
        $data['szMetaTagTitle'] = "Client Details";
        $data['is_user_login'] = $is_user_login;
        $data['notification'] = $count;
        $data['commentnotification'] = $commentReplyNotiCount;
        $this->load->view('layout/admin_header', $data);
        $this->load->view('franchisee/viewAgentEmployeeDetails');
        $this->load->view('layout/admin_footer');
    }
   function getClientListByFrIdData($idFranchisee = '')
    {
        if (trim($idFranchisee) != '') {
            $_POST['idFranchisee'] = $idFranchisee;
        }
            //$clientlistArr = $this->Franchisee_Model->getAllDistinctClientDetails(true, $_POST['idFranchisee']);
        $AllclientAry = $this->Webservices_Model->getclientdetails($_POST['idFranchisee']);
        $AssignCorpuserDetailsArr = $this->Webservices_Model->getcorpclientdetails($_POST['idFranchisee']);
        $CorpuserDetailsArr = array();
        if(!empty($AssignCorpuserDetailsArr)){
            foreach ($AssignCorpuserDetailsArr as $assignCorpUser){
                $CorpSitesDetailsArr = $this->Webservices_Model->getclientdetails($assignCorpUser['corpfrid']);
                if(!empty($CorpSitesDetailsArr)){
                    foreach ($CorpSitesDetailsArr as $CorpUser){
                        if(!in_array($CorpUser,$CorpuserDetailsArr)) {
                            array_push($CorpuserDetailsArr, $CorpUser);
                        }
                    }
                }
            }
        }
        if(!empty($AllclientAry) && !empty($CorpuserDetailsArr)){
            $clientlistArr = array_merge($AllclientAry, $CorpuserDetailsArr);
        }elseif(!empty($AllclientAry)){
            $clientlistArr = $AllclientAry;
        }elseif(!empty($CorpuserDetailsArr)){
            $clientlistArr = $CorpuserDetailsArr;
        }
        $result = "<select class=\"form-control custom-select required\" id=\"szSearchClientname\" name=\"szSearchClRecord1\" placeholder=\"Client Name\" onfocus=\"remove_formError(this.id,'true')\">";
        if (!empty($clientlistArr)) {
            $result .= "<option value=''>Client Name</option>";
            foreach ($clientlistArr as $clientDetails) {
                $result .= "<option value='" . $clientDetails['szName'] . "'>" . $clientDetails['szName'] . "</option>";
            }
        } else {
            $result .= "<option value=''>Client Name</option>";
        }
        $result .= "</select>";
        echo $result;
    }
    function agentRecord()
    {
        $is_user_login = is_user_login($this);
        if (!$is_user_login) {
            ob_end_clean();
            redirect(base_url('/admin/admin_login'));
            die;
        }
        if(($_SESSION['drugsafe_user']['iRole']==1)||($_SESSION['drugsafe_user']['iRole']==5)){
           if(!empty($_POST['szSearchAgentRecord']))
         {
           $franchiseId = $_POST['szSearchAgentRecord'];   
         }
         else{
           $franchiseId = $this->session->userdata('id');  
         }  
      
          if (!empty($_POST)) {
            $_POST['szSearchAgentRecord'] = $_POST['szSearchAgentRecord'];
        } else {
            $_POST['szSearchAgentRecord'] = $franchiseId;
        }
          
        }
        else{
           $franchiseId = $_SESSION['drugsafe_user']['id'];  
        }
       
      $agentListArray = $this->Franchisee_Model->getdistinctAgentrecord($franchiseId);
       
        $agentName = $_POST['szSearchClRecord'];
        
        if (!empty($agentName)) {
            $agentRecordArray = $this->Franchisee_Model->getAgentrecord($franchiseId,false,$agentName);
        } else {
            $agentRecordArray = $this->Franchisee_Model->getAgentrecord($franchiseId);
        }
        $data['pageName'] = "Agent_Record";
        $data['szMetaTagTitle'] = "Agent Record";
        $data['is_user_login'] = $is_user_login;
        $data['franchiseId'] = $franchiseId;
        $data['agentRecordArray'] = $agentRecordArray;
        $data['agentListArray'] = $agentListArray;
        $this->load->view('layout/admin_header', $data);
        $this->load->view('franchisee/agentRecord');
        $this->load->view('layout/admin_footer');
    }
    public function unassignclient()
    {
        $data['mode'] = '__UNASSIGN_CLIENT_CONFIRMATION_POPUP_FORM__';
        $data['agentclientid'] = $this->input->post('agentclientid');
        $this->load->view('admin/admin_ajax_functions', $data);
    }
    public function confirmedUnassign()
    {
        $data['mode'] = '__UNASSIGNED_CLIENT_SUCCESS__';
        $id = $this->input->post('id');
        $this->Franchisee_Model->unassignClient($id);
        $this->load->view('admin/admin_ajax_functions', $data);
    }
    public function assignClientAgent()
    {
        $data['mode'] = '__ASSIGN_CLIENT_POPUP_FORM__';
        $franchiseId = $_SESSION['drugsafe_user']['id'];
        $agentId = $this->input->post('agentId');
        $clientlistArr = $this->Franchisee_Model->getfranchiseeagentclients($franchiseId,0);
        $agentAssignedClientDetails = $this->Franchisee_Model->getfranchiseeagentclients($franchiseId,$agentId);
        $data['agentAssignedClientDetails'] = $agentAssignedClientDetails;
        $data['clientlistArr'] = $clientlistArr;
        $data['agentId'] = $this->input->post('agentId');
        $this->load->view('admin/admin_ajax_functions', $data);
    }
    public function assignClientAgentConfirmation()
    {
        $franchiseId = $_SESSION['drugsafe_user']['id'];
        $clientlistArr = $this->Franchisee_Model->getfranchiseeagentclients($franchiseId,0);
        $data = $this->input->post('assignClient');
        $data['franchiseeId'] = $franchiseId;
        $idAgent = $this->input->post('idAgent');
        $agentAssignedClientDetails = $this->Franchisee_Model->getfranchiseeagentclients($franchiseId,$idAgent);
        $this->load->library('form_validation');
        $this->form_validation->set_rules('assignClient[szClient]', 'Client', 'required');
        $this->form_validation->set_message('required', '{field} is required.');
        if ($this->form_validation->run() == FALSE) {
            ?>
            <div id="assignClientPopupform" class="modal fade" tabindex="-2" data-backdrop="static"
                 data-keyboard="false">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <div class="modal-title">
                                <div class="caption">
                                    <h4><i class="icon-equalizer font-red-sunglo"></i> &nbsp;
                                        <span class="caption-subject font-red-sunglo bold uppercase"> Agent-Client Assignment</span>
                                    </h4>
                                </div>
                            </div>
                        </div>
                        <div class="modal-body">
                            <h4 class="modal-custom-heading"><i class="fa fa-users"></i> Assigned Clients</h4><hr/>
                            <div class="table-reposnsive">
                                <?php if(!empty($agentAssignedClientDetails)){?>
                                    <table class="table table-striped table-hover">
                                        <thead>
                                        <th>#</th>
                                        <th>Client Name</th>
                                        <th>Email</th>
                                        <th>Contact</th>
                                        <th>Action</th>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $clcount = 1;
                                        foreach ($agentAssignedClientDetails as $agentclients){?>
                                            <tr><td><?php echo $clcount;?></td>
                                                <td><?php echo $agentclients['szName'];?></td>
                                                <td><?php echo $agentclients['szEmail'];?></td>
                                                <td><?php echo $agentclients['szContactNumber'];?></td>
                                                <td><a class="btn btn-circle btn-icon-only btn-default" title="Unassign Client" onclick="unassignclient('<?php echo $agentclients['agentclientid'];?>');" href="javascript:void(0);">
                                                        <i class="fa fa-times"></i>
                                                    </a></td>
                                            </tr>
                                        <?php $clcount++; }
                                        ?>
                                        </tbody>
                                    </table>
                                <?php }else{
                                    echo '</p>No client is assigned to this agent/employee.</p>';
                                } ?>
                            </div>
                            <hr/>
                            <h4 class="modal-custom-heading"><i class="icon-equalizer"></i> Assign More Clients</h4><hr/>
                            <form action="" id="assignClient" name="assignClient" method="post"
                                  class="form-horizontal form-row-sepe">
                                <div class="form-body">
                                    <div
                                            class="form-group <?php if (form_error('assignClient[szClient]')) { ?>has-error<?php } ?>">
                                        <label class="control-label col-md-4">Client</label>
                                        <div class="col-md-5">
                                            <div class="search">
                                                <div id='szClient'>
                                                    <select class="form-control custom-select"
                                                            name="assignClient[szClient]" id="szClient"
                                                            onfocus="remove_formError(this.id,'true')">
                                                        <option value="">Client Name</option>
                                                        <?php
                                                        foreach ($clientlistArr as $clientList) {
                                                            $selected = ($clientList['id'] == $_POST['szClient'] ? 'selected="selected"' : '');
                                                            echo '<option value="' . $clientList['id'] . '"' . $selected . ' >' . $clientList['szName'] . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <?php
                                            if (form_error('assignClient[szClient]')) {
                                                ?>
                                                <span class="help-block pull-left">
                                                <span><?php echo form_error('assignClient[szClient]'); ?></span>
                                                </span><?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                            <button type="button"
                                    onclick="assignClientConfirmation('<?php echo $idAgent; ?>');"
                                    class="btn green-meadow">Submit
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div id="popup_box_level1"></div>
            <?php
        } else {
            if($this->Franchisee_Model->assignAgentClient($data, $idAgent)){
                $data['mode'] = '__ASSIGN_CLIENT_POPUP_CONFIRMATION__';
                $this->load->view('admin/admin_ajax_functions', $data);
            }else{
                return false;
            }
        }
    }
    public function deleteAgentEmployeeAlert()
    {
        $data['mode'] = '__DELETE_AGENT_EMPLOYE_POPUP__';
        $data['agentId'] = $this->input->post('agentId');
        $this->load->view('admin/admin_ajax_functions', $data);
    }
    public function deleteAgentEmployeeConfirmation()
    {
        $data['mode'] = '___DELETE_AGENT_EMPLOYE_CONFIRM__';
        $data['agentId'] = $this->input->post('agentId');
        $this->Franchisee_Model->deleteAgent($data['agentId']);
        $this->load->view('admin/admin_ajax_functions', $data);
    }
   function viewAgentEmpByfranchisee()
    {
        $is_user_login = is_user_login($this);
        $count = $this->Admin_Model->getnotification();
        $commentReplyNotiCount = $this->Forum_Model->commentReplyNotifications();
        if (!$is_user_login) {
            ob_end_clean();
            redirect(base_url('/admin/admin_login'));
            die;
        }
        $searchAry = '';
        if (isset($_POST['szSearchFrRecord']) && !empty($_POST['szSearchFrRecord'])) {
            $id = $_POST['szSearchFrRecord'];
        }
        if ($id > 0) {
            if ($_SESSION['drugsafe_user']['iRole'] == '1') {
                  $recordArr = $this->Franchisee_Model->getAgentrecord($id, $idAgent);
              
            } else {
                $operationManagerId = $_SESSION['drugsafe_user']['id'];
                 $recordArr = $this->Franchisee_Model->getAgentrecord($id, $idAgent);
            }
            if (!empty($recordArr)) {
                $this->session->set_userdata('id', $id);
                redirect(base_url('/franchisee/agentRecord'));
            }
        }
        $data['recordArr'] = $recordArr;
        $data['pageName'] = "Agent_Record";
        $data['szMetaTagTitle'] = "Agent Record";
        $data['is_user_login'] = $is_user_login;
        $data['notification'] = $count;
        $data['commentnotification'] = $commentReplyNotiCount;
        $this->load->view('layout/admin_header', $data);
        $this->load->view('franchisee/viewAgentEmpByFr');
        $this->load->view('layout/admin_footer');
    }
  function getAgentListByFrIdData($idFranchisee = '')
    {
        if (trim($idFranchisee) != '') {
            $_POST['idFranchisee'] = $idFranchisee;
        }
 
         $agentListArray = $this->Franchisee_Model->getdistinctAgentrecord($_POST['idFranchisee']);
        $result = "<select class=\"form-control custom-select required\" id=\"szSearchClRecord\" name=\"szSearchClientname\" placeholder=\"Agent/Employee Name\" onfocus=\"remove_formError(this.id,'true')\">";
        if (!empty($agentListArray)) {
            $result .= "<option value=''>Agent/Employee Name</option>";
            foreach ($agentListArray as $agentDetails) {
                $result .= "<option value='" . $agentDetails['szName'] . "'>" . $agentDetails['szName'] . "</option>";
            }
        } else {
            $result .= "<option value=''>Agent/Employee Name</option>";
        }
        $result .= "</select>";
        echo $result;
    }    
     public function ViewAssignClientData()
      {
           $data['mode'] = '__VIEW_ASSIGN_CLIENT_POPUP__';
           $data['idAgent'] = $this->input->post('idAgent');
           $data['franchiseeid'] = $this->input->post('franchiseeid');
           $this->load->view('admin/admin_ajax_functions',$data);
      }
    function ViewAgentDetailsData()
    {
        
        $idAgent = $this->input->post('idAgent');
        $franchiseeid = $this->input->post('franchiseeid');
        
        $this->session->set_userdata('franchiseeid', $franchiseeid);
        $this->session->set_userdata('idAgent', $idAgent);
        echo "SUCCESS||||";
        echo "view_agent_details";
    }
    function view_agent_details()
    {
        $is_user_login = is_user_login($this);
        // redirect to dashboard if already logged in
        if (!$is_user_login) {
            ob_end_clean();
            redirect(base_url('/admin/admin_login'));
            die;
        }
            $idAgent = $this->session->userdata('idAgent');
            $franchiseeid = $this->session->userdata('franchiseeid');
            
        $count = $this->Admin_Model->getnotification();
        $commentReplyNotiCount = $this->Forum_Model->commentReplyNotifications();
        $recordArr = $this->Franchisee_Model->getAgentrecord($franchiseeid, $idAgent);
        $getState=$this->Franchisee_Model->getStateByAgentid($idAgent);
        $data['recordArr'] = $recordArr;
        $data['getState'] = $getState;
        $data['franchiseeid'] = $franchiseeid;
        $data['pageName'] = "Agent_Record";
        $data['szMetaTagTitle'] = "Agent Details";
        $data['is_user_login'] = $is_user_login;
        $data['notification'] = $count;
        $data['commentnotification'] = $commentReplyNotiCount;
        $this->load->view('layout/admin_header', $data);
        $this->load->view('franchisee/viewAgentDetails');
        $this->load->view('layout/admin_footer');
    }
    public function assignfranchiseeClient()
    {
        $data['mode'] = '__ASSIGN_CORP_FRANCHISEE_CLIENT_POPUP_FORM__';
        $franchiseId = $_SESSION['drugsafe_user']['id'];
        $clientid = $this->input->post('clientid');
        $regionId = $this->input->post('regionId');
        $NonCorpFranchiseeArr = $this->Franchisee_Model->getMappedNonCorpFranchisee($clientid,$franchiseId);
        $clientlistArr = $this->Franchisee_Model->getNonCorpFranchisee($regionId);
        $data['NonCorpFranchiseeArr'] = $NonCorpFranchiseeArr;
        $data['clientlistArr'] = $clientlistArr;
        $data['clientid'] = $clientid;
        $data['regionId'] = $regionId;
        $this->load->view('admin/admin_ajax_functions', $data);
    }
    public function assignFranchiseeClientConfirmation()
    {
        $franchiseId = $_SESSION['drugsafe_user']['id'];
        $clientid = $this->input->post('clientid');
        $regionId = $this->input->post('regionId');
        $clientlistArr = $this->Franchisee_Model->getMappedNonCorpFranchisee($clientid,$franchiseId);
        $data = $this->input->post('assignfrClient');
        $data['franchiseeId'] = $franchiseId;
        $NonCorpFranchiseeArr = $this->Franchisee_Model->getNonCorpFranchisee($regionId);
        $this->load->library('form_validation');
        $this->form_validation->set_rules('assignfrClient[szFranchisee]', 'Franchisee', 'required');
        $this->form_validation->set_message('required', '{field} is required.');
        if ($this->form_validation->run() == FALSE) {
            ?>
            <div id="assignfrClientPopupform" class="modal fade" tabindex="-2" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <div class="modal-title">
                                <div class="caption">
                                    <h4><i class="icon-equalizer font-red-sunglo"></i> &nbsp;
                                        <span class="caption-subject font-red-sunglo bold uppercase"> Franchisee-Client Assignment</span></h4>
                                </div>
                            </div>
                        </div>
                        <div class="modal-body">
                            <h4 class="modal-custom-heading"><i class="fa fa-users"></i> Assigned Franchisee</h4><hr>
                            <div class="table-reposnsive">
                                <?php if(!empty($NonCorpFranchiseeArr)){?>
                                    <table class="table table-striped table-hover">
                                        <thead>
                                        <th>#</th>
                                        <th>Franchisee Code</th>
                                        <th>Franchisee</th>
                                        <th>Email</th>
                                        <th>Contact</th>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $clcount = 1;
                                        foreach ($NonCorpFranchiseeArr as $franchiseedet){?>
                                            <tr><td><?php echo $clcount;?></td>
                                                <td><?php echo $franchiseedet['userCode'];?></td>
                                                <td><?php echo $franchiseedet['szName'];?></td>
                                                <td><?php echo $franchiseedet['szEmail'];?></td>
                                                <td><?php echo $franchiseedet['szContactNumber'];?></td>
                                            </tr>
                                            <?php $clcount++; }
                                        ?>
                                        </tbody>
                                    </table>
                                <?php }else{
                                    echo '</p>No non-corporate franchisee is assigned to this client.</p>';
                                } ?>
                            </div>
                            <hr/>
                            <h4 class="modal-custom-heading"><i class="fa fa-plus"></i> Assign Franchisee</h4><hr>
                            <form action="" id="assignClient" name="assignClient" method="post"
                                  class="form-horizontal form-row-sepe">
                                <div class="form-body">
                                    <div
                                            class="form-group <?php if (form_error('assignfrClient[szFranchisee]')) { ?>has-error<?php } ?>">
                                        <label class="control-label col-md-4">Franchisee</label>
                                        <div class="col-md-5">
                                            <div class="search">
                                                <div id='szClient'>
                                                    <select class="form-control custom-select" name="assignfrClient[szFranchisee]" id="szFranchisee" onfocus="remove_formError(this.id,'true')">
                                                        <option value="">Franchisee Name</option>
                                                        <?php
                                                        foreach($clientlistArr as $clientList)
                                                        {
                                                            echo '<option value="'.$clientList['id'].'" >'.$clientList['szName'].'</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <?php
                                            if (form_error('assignfrClient[szFranchisee]')) {
                                                ?>
                                                <span class="help-block pull-left">
                                                <span><?php echo form_error('assignfrClient[szFranchisee]'); ?></span>
                                                </span><?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                            <button type="button"
                                    onclick="assignFranchiseeClientConfirmation('<?php echo $clientid; ?>');"
                                    class="btn green-meadow">Assign
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div id="popup_box_level1"></div>
            <?php
        } else {
            if($this->Franchisee_Model->MapClientToFranchisee($clientid,$franchiseId,$data['szFranchisee'])){
                $data['mode'] = '__ASSIGN_CORP_FRANCHISEE_CLIENT_POPUP_CONFIRMATION__';
                $this->load->view('admin/admin_ajax_functions', $data);
            }
        }
    }
     public function changeAgentPasswordAlert()
    {
        $data['mode'] = '__CHANGE_PASSWORD_AGENT_EMPLOYE_POPUP__';
        $data['agentId'] = $this->input->post('agentId');
        $this->load->view('admin/admin_ajax_functions', $data);
    }
  
      public function changeAgentPasswordConfirmation()
         {
            $data_validate = $this->input->post('changePassword');
            $agentId = $this->input->post('agentId');
            $this->load->library('form_validation');
            
              $this->form_validation->set_rules('changePassword[szNewPassword]','New Password','trim|required|matches[changePassword[szConfirmPassword]]');
                $this->form_validation->set_rules('changePassword[szConfirmPassword]','Confirm Password','trim|required');
             $this->form_validation->set_message('required', '{field} is required.');
            if ($this->form_validation->run() == FALSE)
           {
                ?>
              <div id="agentChangePassword" class="modal fade" tabindex="-2" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <div class="modal-title">
                        <div class="caption">
                            <h4><i class="icon-equalizer font-red-sunglo"></i> &nbsp;
                                <span class="caption-subject font-red-sunglo bold uppercase">Change Password</span>
                            </h4>
                        </div>

                    </div>
                </div>
                <div class="modal-body">
                    <form action="" id="changePasswordForm" name="changePassword" method="post"
                          class="form-horizontal form-row-sepe">
                        <div class="form-body">
                            <div
                                class="form-group <?php if (form_error('changePassword[szNewPassword]')) { ?>has-error<?php } ?>">
                                <label class="control-label col-md-4">New Password</label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <input id="szNewPassword"
                                               class="form-control input-large select2me input-square-right required  "
                                               type="password"
                                               value="<?php echo set_value('changePassword[szNewPassword]'); ?>"
                                               placeholder="New Password" onfocus="remove_formError(this.id,'true')"
                                               name="changePassword[szNewPassword]">
                                    </div>
                                    <?php
                                    if (form_error('changePassword[szNewPassword]')) {
                                        ?>
                                        <span class="help-block pull-left">
                                        <span><?php echo form_error('changePassword[szNewPassword]'); ?></span>
                                        </span><?php } ?>
                                </div>
                            </div>
                              <div
                                class="form-group <?php if (form_error('changePassword[szConfirmPassword]')) { ?>has-error<?php } ?>">
                                <label class="control-label col-md-4">Confirm Password</label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <input id="szConfirmPassword"
                                               class="form-control input-large select2me input-square-right required  "
                                               type="password"
                                               value="<?php echo set_value('changePassword[szConfirmPassword]'); ?>"
                                               placeholder="Confirm Password" onfocus="remove_formError(this.id,'true')"
                                               name="changePassword[szConfirmPassword]">
                                    </div>
                                    <?php
                                    if (form_error('changePassword[szConfirmPassword]')) {
                                        ?>
                                        <span class="help-block pull-left">
                                        <span><?php echo form_error('changePassword[szConfirmPassword]'); ?></span>
                                        </span><?php } ?>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>

                    <button type="button"
                            onclick="changeAgentPasswordConfirmation('<?php echo $agentId; ?>'); return false;"
                            class="btn green-meadow">Submit
                    </button>
                </div>
            </div>
        </div>
    </div>
<?php
           }
           else{
        $data['mode'] = '__CHANGE_PASSWORD_AGENT_EMPLOYE_CONFIRM__';
        $data['agentId'] = $this->input->post('agentId');
        $this->Franchisee_Model->ChangeAgentPassword($data_validate['szConfirmPassword'],$agentId);
        $this->load->view('admin/admin_ajax_functions', $data);
           }
  
        }
    public function unassignSiteAlert()
    {
        $data['mode'] = '__UNASSIGN_SITE_POPUP__';
        $data['mapid'] = $this->input->post('mapid');
        $this->load->view('admin/admin_ajax_functions',$data);
    }
    public function unassignSiteConfirmation()
    {
        $data['mode'] = '__UNASSIGN_SITE_CONFIRM_POPUP__';
        $data['mapid'] = $this->input->post('mapid');
        if($this->Franchisee_Model->unassignSite($data['mapid'])){
            $this->load->view('admin/admin_ajax_functions', $data);
        }
    }
}
?>