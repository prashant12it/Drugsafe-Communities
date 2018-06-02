<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Admin_Controller extends CI_Controller
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
            if ($_SESSION['drugsafe_user']['iRole'] == '5') {
                ob_end_clean();
                redirect(base_url('/admin/franchiseeList'));
                die;
            } elseif ($_SESSION['drugsafe_user']['iRole'] == '1') {
                ob_end_clean();
                redirect(base_url('/admin/operationManagerList'));
                die;
            }elseif ($_SESSION['drugsafe_user']['iRole'] == '2') {
                ob_end_clean();
                 redirect(base_url('/franchisee/clientRecord'));
                die;
            }
            else {
                ob_end_clean();
                redirect(base_url('/formManagement/view_form_for_client'));
                die;
            }
        } else {
            ob_end_clean();
            redirect(base_url('/admin/admin_login'));
            die;
        }
    }
    public function admin_login()
    {
        ob_start();
        $is_user_login = is_user_login($this);
        // redirect to dashboard if already logged in
    if($_SESSION['drugsafe_user']['id']>0){
        if ($is_user_login) {
            ob_end_clean();
            echo "<script type='text/javascript'>window.location.href = '" . __BASE_URL__ . "/admin/franchiseeList';</script>";
            exit();
            /*header("Location:" . __BASE_URL__ . "/admin/franchiseeList");
           die;*/
    }}
        $validate = $this->input->post('adminLogin');
        $iRemember = (int)$this->input->post('adminLogin[iRemember]');
        
        if ($this->Admin_Model->validateAdminData($validate)) {
           
            $adminAry = $this->Admin_Model->adminLoginUser($validate);
            if (!empty($adminAry)) {
                if ((int)$iRemember == 1) {
                    set_customer_cookie($this, $adminAry);
                }
                $user_session = $this->session->userdata('drugsafe_user');
                if ($user_session[iRole] == '1') {
                    ob_end_clean();
                    redirect(base_url('/admin/operationManagerList'));
                } elseif ($user_session[iRole] == '5') {
                    ob_end_clean();
                    redirect(base_url('/admin/franchiseeList'));
                }elseif ($user_session[iRole] == '2') {
                ob_end_clean();
                 redirect(base_url('/franchisee/clientRecord'));
                die;
            }
            else {
                ob_end_clean();
                redirect(base_url('/formManagement/view_form_for_client'));
                die;
            }
            }
        }
       
        $data['szMetaTagTitle'] = "Admin Login";
        $data['arErrorMessages'] = $this->Admin_Model->arErrorMessages;
        $data['is_user_login'] = $is_user_login;
        $this->load->view('layout/login_header', $data);
        $this->load->view('admin/admin_login');
        $this->load->view('layout/login_footer');
    }
    public function dashboard()
    {
        $is_user_login = is_user_login($this);
        if (!$is_user_login) {
            ob_end_clean();
            redirect(base_url('/admin/admin_login'));
            die;
        }
        $user_session = $this->session->userdata('drugsafe_user');
        $data['szMetaTagTitle'] = "Dashboard";
        $data['is_user_login'] = $is_user_login;
        $data['pageName'] = "Admin_Dashboard";
        $this->load->view('layout/admin_header', $data);
        $this->load->view('admin/dashboard');
        $this->load->view('layout/admin_footer');
    }
    function logout()
    {
        logout($this);
        ob_end_clean();
        redirect(base_url('/admin/admin_login'));
    }
    function changePassword()
    {
        $count = $this->Admin_Model->getnotification();
        $commentReplyNotiCount = $this->Forum_Model->commentReplyNotifications();
        $is_user_login = is_user_login($this);
        // redirect to dashboard if already logged in
        if (!$is_user_login) {
            ob_end_clean();
            redirect(base_url('/admin/admin_login'));
            die;
        }
        $data_validate = $this->input->post('drugsafeChangePassword');
        if ($this->Admin_Model->validateUserData($data_validate)) {
            if ($this->Admin_Model->updateChangePassword()) {
                $szMessage['type'] = "success";
                $szMessage['content'] = "<h4><strong>Your new password successfully updated.</strong></h4> ";
                $this->session->set_userdata('drugsafe_user_message', $szMessage);
                if ($_SESSION['drugsafe_user']['iRole'] == 5) {
                    ob_end_clean();
                    redirect(base_url('/admin/franchiseeList'));
                    die;
                } elseif ($_SESSION['drugsafe_user']['iRole'] == 2) {
                    redirect(base_url('/franchisee/clientRecord'));
                    die;
                } else {
                    ob_end_clean();
                    redirect(base_url('/admin/operationManagerList'));
                    die;
                }
            }
        }
        $data['szMetaTagTitle'] = "Change Password";
        $data['arErrorMessages'] = $this->Admin_Model->arErrorMessages;
        $data['is_user_login'] = $is_user_login;
        $data['pageName'] = "Profile";
        $data['notification'] = $count;
        $data['commentnotification'] = $commentReplyNotiCount;
        $this->load->view('layout/admin_header', $data);
        $this->load->view('admin/changePassword');
        $this->load->view('layout/admin_footer');
    }
    function addFranchiseeData()
    {
        $idOperationManager = $this->input->post('idOperationManager');
        $flag = $this->input->post('flag');
        $this->session->set_userdata('flag', $flag);
        if ($idOperationManager > 0) {
            $this->session->set_userdata('idOperationManager', $idOperationManager);
        }
        echo "SUCCESS||||";
        echo "addFranchisee";
    }
    function addFranchisee(){
        $is_user_login = is_user_login($this);
        // redirect to dashboard if already logged in
        if (!$is_user_login) {
            ob_end_clean();
            redirect(base_url('/admin/admin_login'));
            die;
        }
        $validate = $this->input->post('addFranchisee');
        if ($validate['szState']) {
            $getReginolCode = $this->Admin_Model->getRegionByStateId($validate['szState']);
        }
        $idOperationManager = $this->session->userdata('idOperationManager');
        $getAllStates = $this->Admin_Model->getAllStateByCountryId('101');
        $flag = $this->session->userdata('flag');
        $count = $this->Admin_Model->getnotification();
        $commentReplyNotiCount = $this->Forum_Model->commentReplyNotifications();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('addFranchisee[sztype]', 'Franchisee Type', 'required');
        $this->form_validation->set_rules('addFranchisee[szName]', 'Name', 'required|alpha_dash_space');
        $this->form_validation->set_message('alpha_dash_space', ' %s must be only letters and white space.');
        $this->form_validation->set_rules('addFranchisee[abn]', 'ABN', 'required|abn_numeric|abn_length');
        $this->form_validation->set_rules('addFranchisee[operationManagerId]', 'Operation Manager', 'required');
        $this->form_validation->set_rules('addFranchisee[szRegionName]', 'Region Name', 'required');
        $this->form_validation->set_rules('addFranchisee[szState]', 'State', 'required');
        $this->form_validation->set_rules('addFranchisee[szEmail]', 'Email', 'required|chekDuplicate[' .__DBC_SCHEMATA_USERS__. '.szEmail]|valid_email');
        $this->form_validation->set_rules('addFranchisee[szContactNumber]', 'Contact No', 'required|valid_phone_number');
        $this->form_validation->set_rules('addFranchisee[szAddress]', 'Address', 'required');
        $this->form_validation->set_rules('addFranchisee[szCity]', 'City', 'required|alpha_dash_space');
        $this->form_validation->set_rules('addFranchisee[szZipCode]', 'ZIP/Postal Code', 'required|zipCode_legth');
        $this->form_validation->set_message('valid_phone_number', ' %s : enter 10 digit number.');
        $this->form_validation->set_message('chekDuplicate', ' %s must be unique.');
        $this->form_validation->set_message('abn_numeric', ' %s must be only digits.');
        $this->form_validation->set_message('abn_length', ' %s must contain 11 digits only.');
        $this->form_validation->set_message('zipCode_legth', ' %s must contain 4 digits only.');
        $this->form_validation->set_message('required', '{field} is required.');
        if ($this->form_validation->run() == FALSE) {
            $data['idOperationManager'] = $idOperationManager;
            $data['szMetaTagTitle'] = "Add Franchisee";
            $data['pageName'] = "Franchisee_List";
            $data['validate'] = $validate;
            $data['flag'] = $flag;
            $data['getAllStates'] = $getAllStates;
            $data['arErrorMessages'] = $this->Admin_Model->arErrorMessages;
            $data['notification'] = $count;
            $data['getReginolCode'] = $getReginolCode;
            $data['commentnotification'] = $commentReplyNotiCount;
            $this->load->view('layout/admin_header', $data);
            $this->load->view('admin/addFranchisee');
            $this->load->view('layout/admin_footer');
        } else {
            if ($this->Admin_Model->insertUserDetails($validate)) {
                $szMessage['type'] = "success";
                $szMessage['content'] = "<h4><strong>New franchisee added successfully.</strong></h4> ";
                $this->session->set_userdata('drugsafe_user_message', $szMessage);
                ob_end_clean();
                $this->session->unset_userdata('idOperationManager');
                $this->session->unset_userdata('flag');
                redirect(base_url('/admin/franchiseeList'));
                die;
            }
        }
    }
    function welweb()
    {
        $responsedata = array("code" => 200, "message" => "Webservice Working sucessfully.");
        header('Content-Type: application/json');
        echo json_encode($responsedata);
        die;
    }
    function franchiseeList()
    {
//            echo 'fr1';
        $is_user_login = is_user_login($this);
//            echo 'fr2';
        // redirect to dashboard if already logged in
        $count = $this->Admin_Model->getnotification();
        $commentReplyNotiCount = $this->Forum_Model->commentReplyNotifications();
//            echo 'fr3';
        if (!$is_user_login) {
//                echo 'fr4';
            ob_end_clean();
            redirect(base_url('/admin/admin_login'));
            die;
        }
//            echo 'fr5';
        if ($_SESSION['drugsafe_user']['iRole'] == '5') {
            $operationManagerId = $_SESSION['drugsafe_user']['id'];
        }
//        die('fr6');
        $searchAry = '';
        if (isset($_POST['szSearch2']) && !empty($_POST['szSearch2'])) {
            $szName = $_POST['szSearch2'];
        }
        // handle pagination
        $config['base_url'] = __BASE_URL__ . "/admin/franchiseeList/";
        $config['total_rows'] = count($this->Admin_Model->viewFranchiseeList($searchAry, $operationManagerId, false, false, $id, $szName, $email, $opId));
        $config['per_page'] = __PAGINATION_RECORD_LIMIT__;
        $this->pagination->initialize($config);
        $franchiseeAray = $this->Admin_Model->viewFranchiseeList($searchAry, $operationManagerId, $config['per_page'], $this->uri->segment(3), $id, $szName, $email, $opId);
        $searchOptionArr = $this->Admin_Model->viewDistinctFranchiseeList($operationManagerId);
        $data['szMetaTagTitle'] = "Franchisee List";
        $data['is_user_login'] = $is_user_login;
        $data['pageName'] = "Franchisee_List";
        $data['arErrorMessages'] = $this->Admin_Model->arErrorMessages;
        $data['data'] = $data;
        $data['notification'] = $count;
        $data['commentnotification'] = $commentReplyNotiCount;
        $data['franchiseeAray'] = $franchiseeAray;
        $data['allfranchisee'] = $searchOptionArr;
        $this->load->view('layout/admin_header', $data);
        $this->load->view('admin/franchiseeList');
        $this->load->view('layout/admin_footer');
    }
//Operation Manager List
    function operationManagerList()
    {   
        $is_user_login = is_user_login($this);
        $count = $this->Admin_Model->getnotification();
        $commentReplyNotiCount = $this->Forum_Model->commentReplyNotifications();
        if (!$is_user_login){
            ob_end_clean();
            redirect(base_url('/admin/admin_login'));
            die;
        } elseif ($_SESSION['drugsafe_user']['iRole'] != '1') {
            ob_end_clean();
            redirect(base_url('/franchisee/clientRecord'));
        }
        $searchAry = '';
        if (isset($_POST['szSearch2']) && !empty($_POST['szSearch2'])) {
            $name = $_POST['szSearch2'];
        }
        // handle pagination
        $config['base_url'] = __BASE_URL__ . "/admin/operationManagerList/";
        $config['total_rows'] = count($this->Admin_Model->viewOperationManagerList($searchAry, false, false, $name));
        $config['per_page'] = __PAGINATION_RECORD_LIMIT__;
        $this->pagination->initialize($config);
        //end pagination
        
        //listing function
        $operationManagerAray = $this->Admin_Model->viewOperationManagerList($searchAry, $config['per_page'], $this->uri->segment(3), $name);
        $searchOptionArr = $this->Admin_Model->viewDistinctOperationManagerList();
        //end listing function
        
        $data['szMetaTagTitle'] = "Operation Manager List";
        $data['is_user_login'] = $is_user_login;
        $data['pageName'] = "Operation_Manager_List";
        $data['arErrorMessages'] = $this->Admin_Model->arErrorMessages;
        $data['data'] = $data;
        $data['notification'] = $count;
        $data['commentnotification'] = $commentReplyNotiCount;
        $data['operationManagerAray'] = $operationManagerAray;
        $data['allOperationManager'] = $searchOptionArr;
        
        $this->load->view('layout/admin_header', $data);
        $this->load->view('admin/operationManagerList');
        $this->load->view('layout/admin_footer');
    }
// End Operation Manager List
    
    function getStatesByCountry($szCountry = '')
    {
        if (trim($szCountry) != '') {
            $_POST['szCountry'] = $szCountry;
        }
        $stateAry = $this->Admin_Model->getStatesByCountry(trim($_POST['szCountry']));
        if (!empty($stateAry)) {
            $result = "<select class=\"form-control required\" id=\"szState\" name=\"addFranchisee[szState]\" placeholder=\"State\" onfocus=\"remove_formError(this.id,'true')\">";
            foreach ($stateAry as $stateDetails) {
                $result .= "<option value='" . $stateDetails['name'] . "'>" . $stateDetails['name'] . "</option>";
            }
            $result .= "</select>";
        } else {
            $result = "<input type=\"text\" class=\"form-control required\" id=\"szState\" name=\"addFranchisee[szState]\" placeholder=\"State\" onfocus=\"remove_formError(this.id,'true')\">";
        }
        echo $result;
    }
    function getFranchiseeByOperationManager($operationManagerId = '')
    {
        if (trim($operationManagerId) != '') {
            $_POST['operationManagerId'] = $operationManagerId;
        }
        $franchiseeAry = $this->Admin_Model->viewFranchiseeList(false, trim($_POST['operationManagerId']));
        if (!empty($franchiseeAry)) {
            $result = "<select class=\"form-control \" id=\"franchiseeId\" name=\"clientData[franchiseeId]\" placeholder=\"Franchisee\" onfocus=\"remove_formError(this.id,'true')\">";
            foreach ($franchiseeAry as $franchiseeDetails) {
                $result .= "<option value='" . $franchiseeDetails['id'] . "' >" . $franchiseeDetails['szName'] . "</option>";
            }
            $result .= "</select>";
        } else {
            $result = "<input type=\"text\" class=\"form-control required\" id=\"franchiseeId\" name=\"clientData[franchiseeId]\" placeholder=\"Franchisee\" onfocus=\"remove_formError(this.id,'true')\">";
        }
        echo $result;
    }
    function editfranchiseedata()
    {
        $idfranchisee = $this->input->post('idfranchisee');
        $idOperationManager = $this->input->post('idOperationManager');
        if ($idfranchisee > 0) {
            $this->session->set_userdata('idfranchisee', $idfranchisee);
            $this->session->set_userdata('idOperationManager', $idOperationManager);
            echo "SUCCESS||||";
            echo "editFranchisee";
        }
    }
    public function editFranchisee()
    {
        $is_user_login = is_user_login($this);
        // redirect to dashboard if already logged in
        if (!$is_user_login) {
            ob_end_clean();
            redirect(base_url('/admin/admin_login'));
            die;
        }
        $idOperationManager = $this->session->userdata('idOperationManager');
        $idfranchisee = $this->session->userdata('idfranchisee');
        $getState = $this->Franchisee_Model->getStateByFranchiseeId($idfranchisee);
        $getAllStates = $this->Admin_Model->getAllStateByCountryId('101');
        $count = $this->Admin_Model->getnotification();
        $commentReplyNotiCount = $this->Forum_Model->commentReplyNotifications();
        if ($idfranchisee > 0) {
            $data_validate = $this->input->post('addFranchisee');
            if ($data_validate['szState']) {
                $getReginolCode = $this->Admin_Model->getRegionByStateId($data_validate['szState']);
            }
            $reginolIdArray = $this->Admin_Model->getUserDetailsByEmailOrId('', $idfranchisee);
            $clientDetailsAray = $this->Franchisee_Model->getClientCountId($idfranchisee);
            if (!empty($clientDetailsAray)) {
                $stateReginolClass = "stateReginolhidden";
            }
            $reginolId = $reginolIdArray['reginolId'];
            if (empty($data_validate)) {
                $userDataAry = $this->Admin_Model->getUserDetailsByEmailOrId('', $idfranchisee);
            } else {
                $userDataAry = $data_validate;
            }
            if ($this->Admin_Model->validateUsersData($data_validate, array(), $idfranchisee, false, 1, 2)) {
                if ($this->Admin_Model->updateUsersDetails($data_validate, $idfranchisee)) {
                    $szMessage['type'] = "success";
                    $szMessage['content'] = "<h4><strong>Franchisee data successfully updated.</strong></h4> ";
                    $this->session->set_userdata('drugsafe_user_message', $szMessage);
                    ob_end_clean();
                    $this->session->unset_userdata('idOperationManager');
                    $this->session->unset_userdata('idfranchisee');
                    redirect(base_url('/admin/franchiseeList'));
                }
            }
            $data['szMetaTagTitle'] = "Edit Franchisee Details ";
            $data['is_user_login'] = $is_user_login;
            $data['pageName'] = "Franchisee_List";
            $data['validate'] = $validate;
            $data['idfranchisee'] = $idfranchisee;
            $data['idOperationManager'] = $idOperationManager;
            $_POST['addFranchisee'] = $userDataAry;
            $data['stateReginolClass'] = $stateReginolClass;
            $data['reginolId'] = $reginolId;
            $data['getState'] = $getState;
            $data['getAllStates'] = $getAllStates;
            $data['getReginolCode'] = $getReginolCode;
            $data['arErrorMessages'] = $this->Admin_Model->arErrorMessages;
            $data['notification'] = $count;
            $data['commentnotification'] = $commentReplyNotiCount;
            $this->load->view('layout/admin_header', $data);
            $this->load->view('admin/editFranchisee');
            $this->load->view('layout/admin_footer');
        }
    }
    public function deleteFranchiseeAlert()
    {
        $data['mode'] = '__DELETE_FRANCHISEE_POPUP__';
        $data['idfranchisee'] = $this->input->post('idfranchisee');
        $this->load->view('admin/admin_ajax_functions', $data);
    }
    public function deleteFranchiseeConfirmation()
    {
        $data['mode'] = '__DELETE_FRANCHISEE_CONFIRM__';
        $data['idfranchisee'] = $this->input->post('idfranchisee');
        $franchiseeDets = $this->Admin_Model->getUserDetailsByEmailOrId('', $data['idfranchisee']);
        if (!empty($franchiseeDets) && $franchiseeDets['iRole'] == '2') {
            $this->Admin_Model->assignUnassignRegionCode($franchiseeDets['regionId'], false);
        }
        $this->Admin_Model->deletefranchisee($data['idfranchisee']);
        $this->Admin_Model->deletemodelStockValue($data['idfranchisee']);
        $this->Admin_Model->deleteProductStockQuantity($data['idfranchisee']);
        $this->load->view('admin/admin_ajax_functions', $data);
    }
    public function admin_forgotPassword()
    {
        $is_user_login = is_user_login($this);
        if ($is_user_login) {
            ob_end_clean();
            redirect(base_url('/admin/admin_login'));
            die;
        }
        $data_validate = $this->input->post('drugSafeForgotPassword');
        //$data_validate = array('szEmail'=>$data_validate);
        $data_not_validate = array(
            'id',
            'szName',
            'szContactNumber',
            'szCountry',
            'szState',
            'szCity',
            'szZipCode',
            'szAddress'
        );
        if ($this->Admin_Model->validateUsersData($data_validate, $data_not_validate, '0', true)) {
            if ($this->Admin_Model->checkAdminAccountStatus($data_validate['szEmail'])) {
                if ($this->Admin_Model->sendNewPasswordToAdmin($data_validate['szEmail'])) {
                    $szMessage['type'] = "success";
                    $szMessage['content'] = "<h4><strong> Please check your email to recover your password.</strong></h4>";
                    $this->session->set_userdata('drugsafe_user_message', $szMessage);
                    $this->session->userdata('drugsafe_user_message');
                    ob_end_clean();
                    redirect(base_url('/admin/admin_login'));
                    die;
                }
            }
        }
        $data['szMetaTagTitle'] = "Admin Forgot Password";
        $data['arErrorMessages'] = $this->Admin_Model->arErrorMessages;
        $data['is_user_login'] = $is_user_login;
        $this->load->view('layout/login_header', $data);
        $this->load->view('admin/forgotPassword');
        $this->load->view('layout/login_footer');
    }
    public function adminPassword_Recover($arg1 = '', $arg2 = '')
    {
        $is_user_login = is_user_login($this);
        // redirect to dashboard if already logged in
        if ($is_user_login) {
            ob_end_clean();
            redirect(base_url('/admin/franchiseeList'));
            die;
        }
        //echo " Hello";
        $passwordKey = $this->Admin_Model->sql_real_escape_string(trim($arg1));
        //  echo $passwordKey;
        if ($this->Admin_Model->checkPasswordRecoveryExist($passwordKey)) {
            //echo $passwordKey;
            $data_validate = $this->input->post('recoverAdminData');
            // echo $data_validate;
            $data_not_validate = array(
                'id',
                'szName',
                'szEmail',
                'szContactNumber',
                'szCountry',
                'szState',
                'szCity',
                'szZipCode',
                'szAddress'
            );
            if ($this->Admin_Model->validateUsersData($data_validate, $data_not_validate, 0, TRUE)) {
                if ($this->Admin_Model->updateAdminPassword($passwordKey, $data_validate)) {
                    $szMessage['type'] = "success";
                    $szMessage['content'] = "<h4><strong>Your new password successfully updated.</strong></h4>";
                    $this->session->set_userdata('drugsafe_user_message', $szMessage);
                    ob_end_clean();
                    redirect(base_url('/admin/admin_login'));
                    die;
                } else {
                    $szMessage['type'] = "error";
                    $szMessage['content'] = "<h4><strong>Password recovery link is expired. Please reset your password again.</strong></h4>";
                    $this->session->set_userdata('drugsafe_user_message', $szMessage);
                    ob_end_clean();
                    redirect(base_url('/admin/admin_login'));
                    die;
                }
            }
        } else {
            $szMessage['type'] = "error";
            $szMessage['content'] = "<h4><strong> Your Password Key is wrong. Please reset your password again.</strong></h4>";
            $this->session->set_userdata('drugsafe_user_message', $szMessage);
            ob_end_clean();
            redirect(base_url('/admin/admin_login'));
            die;
        }
        $data['szMetaTagTitle'] = "Admin Forgot Password";
        $data['arErrorMessages'] = $this->Admin_Model->arErrorMessages;
        $data['is_user_login'] = $is_user_login;
        $data['passwordKey'] = $passwordKey;
        $this->load->view('layout/login_header', $data);
        $this->load->view('admin/adminPassword_Recover', $data);
        $this->load->view('layout/login_footer');
    }
    function addOperationManager()
    {
        $is_user_login = is_user_login($this);
        // redirect to dashboard if already logged in
        if (!$is_user_login) {
            ob_end_clean();
            redirect(base_url('/admin/admin_login'));
            die;
        }
        $validate = $this->input->post('addOperationManager');
        $getAllStates = $this->Admin_Model->getAllStateByCountryId('101');
        $count = $this->Admin_Model->getnotification();
        $commentReplyNotiCount = $this->Forum_Model->commentReplyNotifications();
        //validate and insert data in db
        if ($this->Admin_Model->validateUsersData($validate)) {
            if ($this->Admin_Model->insertOpertionDetails($validate)) {
                $szMessage['type'] = "success";
                $szMessage['content'] = "<h4><strong>New Operation Manager added successfully.</strong></h4>";
                $this->session->set_userdata('drugsafe_user_message', $szMessage);
                redirect(base_url('/admin/operationManagerList'));
            }
        }
        //end validate and insert data in db
        $data['szMetaTagTitle'] = "Add Operation Manager";
        $data['pageName'] = "Operation_Manager_List";
        $data['validate'] = $validate;
        $data['arErrorMessages'] = $this->Admin_Model->arErrorMessages;
        $data['notification'] = $count;
        $data['getAllStates'] = $getAllStates;
        $data['commentnotification'] = $commentReplyNotiCount;
        $this->load->view('layout/admin_header', $data);
        $this->load->view('admin/addOperationManager');
        $this->load->view('layout/admin_footer');
    }
    function editOperationManagerData()
    {
        $idOperationManager = $this->input->post('idOperationManager');
        $flag = $this->input->post('flag');
        if ($idOperationManager > 0) {
            $this->session->set_userdata('flag', $flag);
            $this->session->set_userdata('idOperationManager', $idOperationManager);
            echo "SUCCESS||||";
            echo "edit_Operation_Manager";
        }
    }
    public function edit_Operation_Manager()
    {
        $is_user_login = is_user_login($this);
        // redirect to dashboard if already logged in
        if (!$is_user_login) {
            ob_end_clean();
            redirect(base_url('/admin/admin_login'));
            die;
        }
        $getAllStates = $this->Admin_Model->getAllStateByCountryId('101');
        $idOperationManager = $this->session->userdata('idOperationManager');
        $flag = $this->session->userdata('flag');
        $count = $this->Admin_Model->getnotification();
        $commentReplyNotiCount = $this->Forum_Model->commentReplyNotifications();
        if ($idOperationManager > 0) {
            $data_validate = $this->input->post('editOperationManager');
            if (empty($data_validate)) {
                $userDataAry = $this->Admin_Model->getUserDetailsByEmailOrId('', $idOperationManager);
                if (!empty($userDataAry)) {
                    $getStateIdByOperationId = $this->Admin_Model->getStateByOperationid($userDataAry['id']);
                    $stateId = $getStateIdByOperationId['stateId'];
                }
            } else {
                $userDataAry = $data_validate;
                $stateId = $userDataAry['szState'];
            }
            if ($this->Admin_Model->validateUsersData($data_validate, array(), $idOperationManager)) {
                if ($this->Admin_Model->updateOperationDetails($data_validate, $idOperationManager)) {
                    $szMessage['type'] = "success";
                    $szMessage['content'] = "<h4><strong> Operation Manager data successfully updated.</strong><h4> ";
                    $this->session->set_userdata('drugsafe_user_message', $szMessage);
                    if ($flag == 1) {
                        $this->session->unset_userdata('flag');
                        $this->session->unset_userdata('idOperationManager');
                        redirect(base_url('/admin/operationManagerList'));
                    } else {
                        $this->session->unset_userdata('flag');
                        redirect(base_url('/franchisee/franchiseeRecord'));
                    }
                }
            }
            $data['szMetaTagTitle'] = "Edit Operation Manager Details ";
            $data['is_user_login'] = $is_user_login;
            $data['pageName'] = "Operation_Manager_List";
            $data['validate'] = $validate;
            $_POST['editOperationManager'] = $userDataAry;
            $data['arErrorMessages'] = $this->Admin_Model->arErrorMessages;
            $data['notification'] = $count;
            $_POST['editOperationManager']['szState'] = $stateId;
            $data['idOperationManager'] = $idOperationManager;
            $data['getAllStates'] = $getAllStates;
            $data['commentnotification'] = $commentReplyNotiCount;
            $data['flag'] = $flag;
            $this->load->view('layout/admin_header', $data);
            $this->load->view('admin/editOperationManager');
            $this->load->view('layout/admin_footer');
        }
    }
    public function deleteOperationManagerAlert()
    {
        $data['mode'] = '__DELETE_OPERATION_MANAGER_POPUP__';
        $data['idOperationManager'] = $this->input->post('idOperationManager');
        $this->load->view('admin/admin_ajax_functions', $data);
    }
    public function deleteOperationManagerConfirmation()
    {
        $data['mode'] = '__DELETE_OPERATION_MANAGER_CONFIRM__';
        $data['idOperationManager'] = $this->input->post('idOperationManager');
        $this->Admin_Model->deleteOperationManagerDetails($data['idOperationManager']);
        $this->load->view('admin/admin_ajax_functions', $data);
    }
    function getReginolCode()
    {
        $stateId = $this->input->post('stateId');
        $getReginolCode = $this->Admin_Model->getRegionByStateId($stateId);
        ?>
        <div class="form-group <?php if (!empty($arErrorMessages['szRegionName']) != '') { ?>has-error<?php } ?>">
            <label class="col-md-3 control-label">Region Name</label>
            <div class="col-md-5">
                <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-map-marker"></i>
                         </span>
                    <select class="form-control " name="addFranchisee[szRegionName]" id="szRegionName"
                            Placeholder="Region Name" onfocus="remove_formError(this.id,'true')">
                        <option value=''>Select</option>
                        <?php
                        if (!empty($getReginolCode)) {
                            foreach ($getReginolCode as $getReginolCodeData) {
                                $selected = ($getReginolCodeData['id'] == $_POST['addFranchisee']['szRegionName'] ? 'selected="selected"' : '');
                                echo '<option value="' . $getReginolCodeData['id'] . '"' . $selected . ' >' . $getReginolCodeData['regionName'] . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                <?php if (!empty($arErrorMessages['szRegionName'])) { ?>
                    <span class="help-block pull-left">
                                                <i class="fa fa-times-circle"></i>
                        <?php echo $arErrorMessages['szRegionName']; ?>
                                            </span>
                <?php } ?>
            </div>

        </div>
        <?php
    }
    function getAllReginolCode()
    {
        $Err = $this->input->post('error');
        $regionid = $this->input->post('regionid');
        $stateId = $this->input->post('stateId');
        $getReginolCode = $this->Admin_Model->getAllRegionByStateId($stateId);
        ?>
        <div class="form-group <?php if (!empty($Err)) { ?>has-error<?php } ?>">
            <label class="col-md-4 control-label">Region Name</label>
            <div class="col-md-6">
                <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-map-marker"></i>
                         </span>
                    <select class="form-control " name="clientData[szRegionName]" id="szRegionName"
                            Placeholder="Region Name" onfocus="remove_formError(this.id,'true')">
                        <option value=''>Select</option>
                        <?php
                        if (!empty($getReginolCode)) {
                            foreach ($getReginolCode as $getReginolCodeData) {
                                $selected = ($getReginolCodeData['id'] == $regionid ? 'selected="selected"' : '');
                                echo '<option value="' . $getReginolCodeData['id'] . '"' . $selected . ' >' . $getReginolCodeData['regionName'] . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                <?php if (!empty($Err)) { ?>
                    <span class="help-block pull-left">
                                                <i class="fa fa-times-circle"></i>
                        <?php echo $Err; ?>
                                            </span>
                <?php } ?>
            </div>

        </div>
        <?php
    }
    function getAllReginolCodeForAgent()
    {
        $Err = $this->input->post('error');
        $regionid = $this->input->post('regionid');
        $stateId = $this->input->post('stateId');
        $getReginolCode = $this->Admin_Model->getAllRegionByStateId($stateId);
        ?>
        <div class="form-group <?php if (!empty($Err)) { ?>has-error<?php } ?>">
            <label class="col-md-4 control-label">Region Name</label>
            <div class="col-md-6">
                <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-map-marker"></i>
                         </span>
                    <select class="form-control " name="agentData[szRegionName]" id="szRegionName"
                            Placeholder="Region Name" onfocus="remove_formError(this.id,'true')">
                        <option value=''>Select</option>
                        <?php
                        if (!empty($getReginolCode)) {
                            foreach ($getReginolCode as $getReginolCodeData) {
                                $selected = ($getReginolCodeData['id'] == $regionid ? 'selected="selected"' : '');
                                echo '<option value="' . $getReginolCodeData['id'] . '"' . $selected . ' >' . $getReginolCodeData['regionName'] . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                <?php if (!empty($Err)) { ?>
                    <span class="help-block pull-left">
                                                <i class="fa fa-times-circle"></i>
                        <?php echo $Err; ?>
                                            </span>
                <?php } ?>
            </div>

        </div>
        <?php
    }
    function regionManagerList()
    {
        $is_user_login = is_user_login($this);
        if (!$is_user_login) {
            ob_end_clean();
            redirect(base_url('/admin/admin_login'));
            die;
        }
        $idState = $_POST['szSearchstate'];
        $regionName = $_POST['szSearchRegionName'];
        
        $getAllStatesAry = $this->Admin_Model->getAllStateByCountryId('101');
        $getAllRegion = $this->Admin_Model->getAllRegion($idState,$regionName);
        
        $regionListArray = $this->Admin_Model->getRegionByStateIdForSearch($idState);
        
        $data['szMetaTagTitle'] = "Region List";
        $data['is_user_login'] = $is_user_login;
        $data['pageName'] = "Region_Manager_List";
        $data['getAllStatesAry'] = $getAllStatesAry;
        $data['getAllRegion'] = $getAllRegion;
        $data['regionListArray'] = $regionListArray;
        $this->load->view('layout/admin_header', $data);
        $this->load->view('admin/regionList');
        $this->load->view('layout/admin_footer');
    }
    function addRegion()
    {
        $is_user_login = is_user_login($this);
        if (!$is_user_login) {
            ob_end_clean();
            redirect(base_url('/admin/admin_login'));
            die;
        }
        $getAllStates = $this->Admin_Model->getAllStateByCountryId('101');
        $data = $_POST['addRegion'];
        $this->load->library('form_validation');
        $this->form_validation->set_rules('addRegion[szState]', 'State', 'required');
        $this->form_validation->set_rules('addRegion[szRegionName]', 'Region Name', 'required');
        $this->form_validation->set_message('required', '{field} is required.');
        if ($this->form_validation->run() == FALSE) {
            $data['szMetaTagTitle'] = "add Region";
            $data['is_user_login'] = $is_user_login;
            $data['pageName'] = "Region_Manager_List";
            $data['getAllStates'] = $getAllStates;
            $this->load->view('layout/admin_header', $data);
            $this->load->view('admin/addRegion');
            $this->load->view('layout/admin_footer');
        } else {
            if ($this->Admin_Model->insertRegion($data)) {
                    $szMessage['type'] = "success";
                    $szMessage['content'] = "<h4><strong>New Region has been added successfully .</strong><h4> ";
                    $this->session->set_userdata('drugsafe_user_message', $szMessage);
                redirect(base_url('admin/regionManagerList/'));
                die;
            }
        }
    }
    function addRegionCode()
    {
        $stateId = $this->input->post('stateId');
        $getRegionCode = $this->Admin_Model->getRegionCode($stateId);
        if ($getRegionCode['regionCodeMax'] == '') {
            $regionCode = $stateId * 100+1;
        } else {
            $regionCode = $getRegionCode['regionCodeMax'] + 1;
        }
        ?>
        <div class="form-group">
            <label class="col-md-3 control-label">Region Code</label>
            <div class="col-md-5">
                <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-area-chart"></i>
                        </span>
                    <input id="iRegionCode" class="form-control" type="text" value="<?php echo $regionCode; ?>"
                           placeholder="Region Code" onfocus="remove_formError(this.id,'true')"
                           name="addRegion[iRegionCode]" readonly>
                </div>
            </div>
        </div>
        <?php
    }
    function editRegionDetails()
    {
        $idRegion = $this->input->post('idRegion');
        if ($idRegion > 0) {
            $this->session->set_userdata('idRegion', $idRegion);
            echo "SUCCESS||||";
            echo "editRegion";
        }
    }
    public function editRegion()
    {
        $is_user_login = is_user_login($this);
        // redirect to dashboard if already logged in
        if (!$is_user_login) {
            ob_end_clean();
            redirect(base_url('/admin/admin_login'));
            die;
        }
        $data_validate = $this->input->post('editRegion');
    
        $idRegion = $this->session->userdata('idRegion');
        if (empty($data_validate)) {
            $getRegionData = $this->Admin_Model->getRegionById($idRegion);
        } else {
            $getRegionData = $data_validate;
        }
        $getAllStates = $this->Admin_Model->getAllStateByCountryId('101');
        $idRegion = $this->session->userdata('idRegion');
        
        $this->load->library('form_validation');
        $this->form_validation->set_rules('editRegion[stateId]', 'State', 'required');
        $this->form_validation->set_rules('editRegion[regionName]', 'Region Name', 'required');
        $this->form_validation->set_message('required', '{field} is required.');
        if ($this->form_validation->run() == FALSE) {
            $_POST['editRegion'] = $getRegionData;
            $data['szMetaTagTitle'] = "Edit Region ";
            $data['is_user_login'] = $is_user_login;
            $data['pageName'] = "Region_Manager_List";
            $_POST['addFranchisee'] = $userDataAry;
            $data['getAllStates'] = $getAllStates;
            $this->load->view('layout/admin_header', $data);
            $this->load->view('admin/editRegion');
            $this->load->view('layout/admin_footer');
        } else {
            if ($this->Admin_Model->updateRegion($data_validate, $idRegion)) {
                    $szMessage['type'] = "success";
                    $szMessage['content'] = "<h4><strong> Region data has been updated successfully .</strong><h4> ";
                    $this->session->set_userdata('drugsafe_user_message', $szMessage);
                redirect(base_url('admin/regionManagerList/'));
                die;
            }
        }
    }
    function editRegionCode()
    {
        $stateId = $this->input->post('stateId');
        $getRegionCode = $this->Admin_Model->getRegionCode($stateId);
        if ($getRegionCode['regionCodeMax'] == '') {
            $regionCode = ($stateId * 100)+1;
        } else {
            $regionCode = $getRegionCode['regionCodeMax'] + 1;
        }
        ?>
        <div class="form-group">
            <label class="col-md-3 control-label">Region Code</label>
            <div class="col-md-5">
                <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-area-chart"></i>
                        </span>
                    <input id="regionCode" class="form-control" type="text" value="<?php echo $regionCode; ?>"
                           placeholder="Region Code" onfocus="remove_formError(this.id,'true')"
                           name="editRegion[regionCode]" readonly>
                </div>
            </div>
        </div>
        <?php
    }
    public function regionDeleteeAlert()
    {
        $data['mode'] = '__DELETE_REGION_POPUP__';
        $data['regionId'] = $this->input->post('regionId');
        $this->load->view('admin/admin_ajax_functions', $data);
    }
    public function deleteRegionConfirmation()
    {
        $data['mode'] = '___DELETE_REGION_CONFIRM__';
        $data['regionId'] = $this->input->post('regionId');
        $this->Admin_Model->deleteRegion($data['regionId']);
        $this->load->view('admin/admin_ajax_functions', $data);
    }
    public function franchiseeStatus()
    {
        $data['mode'] = '__FRANCHISEE_STATUS_POPUP__';
        $data['idfranchisee'] = $this->input->post('idfranchisee');
        $data['status'] = $this->input->post('status');
        $this->load->view('admin/admin_ajax_functions', $data);
    }
    public function franchiseeStatusConfirmation()
    {
        $idfranchisee = $this->input->post('idfranchisee');
        $status = $this->input->post('status');
        $data['mode'] = '__FRANCHISEE_STATUS_CONFIRM__';
        $data['idfranchisee'] = $idfranchisee;
        $data['status'] = $status;
        $this->Admin_Model->updateFranchiseeStatus($idfranchisee, $status);
        $this->load->view('admin/admin_ajax_functions', $data);
    }
     function getRegionNameByStateData($idState = '')
    {
        if (trim($idState) != '') {
            $_POST['StateId'] = $idState;
        }
 
         $regionListArray = $this->Admin_Model->getRegionByStateIdForSearch($_POST['StateId']);
        
        $result = "<select class=\"form-control custom-select required\" id=\"szSearchRegionName\" name=\"szSearchRegionName\" placeholder=\"Region Name\" onfocus=\"remove_formError(this.id,'true')\">";
        if (!empty($regionListArray)) {
            $result .= "<option value=''>Region Name</option>";
            foreach ($regionListArray as $regionList) {
                $result .= "<option value='" . $regionList['regionName'] . "'>" . $regionList['regionName'] . "</option>";
            }
        } else {
            $result .= "<option value=''>Region Name</option>";
        }
        $result .= "</select>";
        echo $result;
    }  
 
}
?>