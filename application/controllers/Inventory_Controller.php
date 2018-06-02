<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Inventory_Controller extends CI_Controller {
     
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
            // redirect to dashboard if already logged in
            if (!$is_user_login) {
                ob_end_clean();
                  redirect(base_url('/admin/admin_login'));
                die;
            }
            redirect(base_url('/inventory/drugTestKitList'));
          
        }
	
        public function addMarketingMaterial() 
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
            $this->load->library('form_validation');
            $this->form_validation->set_rules('productData[szProductCode]', 'Product Code', 'required|chekDuplicate['. __DBC_SCHEMATA_PRODUCT__ . '.szProductCode]');
            $this->form_validation->set_rules('productData[szProductDiscription]', 'Product Description', 'required');
            $this->form_validation->set_rules('productData[szProductCost]', 'Product Cost', 'required|numeric|greater_than[0]');
//            $this->form_validation->set_rules('productData[dtExpiredOn]', 'Expiry Date', 'required');
            $this->form_validation->set_rules('productData[supplier]', 'Supplier Name', 'alpha_numeric_spaces');
            $this->form_validation->set_rules('productData[min_ord_qty]', 'Minimum Order Quantity', 'required|numeric|greater_than[0]');
            $this->form_validation->set_rules('productData[model_stk_val]', 'Model Stock Value', 'required|numeric|greater_than[0]');
            $this->form_validation->set_rules('productData[szProductImage]', 'Product Image', 'required');
            $this->form_validation->set_rules('productData[szAvailableQuantity]', 'Available Quantity', 'required|numeric|greater_than_equal_to[0]|less_than_equal_to[1000]');
            $this->form_validation->set_message('alpha_numeric_spaces', 'Supplier Name must contain alpha-numeric characters only.');
            $this->form_validation->set_message('chekDuplicate', ' %s already exist.');
            $this->form_validation->set_message('required', '{field} is required.');
            if ($this->form_validation->run() == FALSE)
            { 
                $data['notification'] = $count;
                $data['commentnotification'] = $commentReplyNotiCount;
                $data['szMetaTagTitle'] = "Add Marketing Material";
                $data['is_user_login'] = $is_user_login;
                $data['pageName'] = "Inventory";
                $data['subpageName'] = "Marketing_Material_List";
                $this->load->view('layout/admin_header', $data);
                $this->load->view('inventory/addMarketingMaterial');
                $this->load->view('layout/admin_footer');
            }
            else
            {
                if( $this->Inventory_Model->insertProduct())
                {
                    $szMessage['type'] = "success";
                    $szMessage['content'] = "<h4><strong> Marketing Material added successfully.</strong></h4>";
                    $this->session->set_userdata('drugsafe_user_message', $szMessage);
                     redirect(base_url('/inventory/marketingMaterialList'));
                    die;
                }
            }
        }
        public function addDrugTestKit() 
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
            $this->load->library('form_validation');
            $this->form_validation->set_rules('productData[szProductCode]', 'Product Code', 'required|chekDuplicate['. __DBC_SCHEMATA_PRODUCT__ . '.szProductCode]');
            $this->form_validation->set_rules('productData[szProductDiscription]', 'Product Description', 'required');
            $this->form_validation->set_rules('productData[szProductCost]', 'Product Cost', 'required|numeric|greater_than[0]');
//            $this->form_validation->set_rules('productData[dtExpiredOn]', 'Expiry Date', 'required');
             $this->form_validation->set_rules('productData[supplier]', 'Supplier Name', 'alpha_numeric_spaces');
            $this->form_validation->set_rules('productData[min_ord_qty]', 'Minimum Order Quantity', 'required|numeric|greater_than[0]');
            $this->form_validation->set_rules('productData[model_stk_val]', 'Model Stock Value', 'required|numeric|greater_than[0]');
            $this->form_validation->set_rules('productData[szAvailableQuantity]', 'Available Quantity', 'required|numeric|greater_than_equal_to[0]|less_than_equal_to[1000]');
            $this->form_validation->set_rules('productData[szProductImage]', 'Product Image', 'required');
            $this->form_validation->set_message('chekDuplicate', ' %s already exist.');
            $this->form_validation->set_message('required', '{field} is required.');
             $this->form_validation->set_message('alpha_numeric_spaces', 'Supplier Name must contain alpha-numeric characters only.');
            
            if ($this->form_validation->run() == FALSE)
            { 
                $data['notification'] = $count;
                $data['commentnotification'] = $commentReplyNotiCount;
                $data['szMetaTagTitle'] = "Add Product";
                $data['is_user_login'] = $is_user_login;
                $data['pageName'] = "Inventory";
                $data['subpageName'] = "Drug_Test_Kit_List";
                $this->load->view('layout/admin_header', $data);
                $this->load->view('inventory/addDrugTestKit');
                $this->load->view('layout/admin_footer');
            }
            else
            {
                if( $this->Inventory_Model->insertProduct())
                {
                   $szProductCategory = $_POST['productData']['szProductCategory'];
                    if($szProductCategory==1)
                    {
                        $szMessage['type'] = "success";
                        $szMessage['content'] = "<h4><strong>Drug Test Kit added successfully.</strong></h4>";
                        $this->session->set_userdata('drugsafe_user_message', $szMessage); 
                         redirect(base_url('/inventory/drugTestKitList'));
                        die;
                    }
                }
            }
        }
        public function addConsumables() {
           $count = $this->Admin_Model->getnotification();
           $commentReplyNotiCount = $this->Forum_Model->commentReplyNotifications();
            $is_user_login = is_user_login($this);
            // redirect to dashboard if already logged in
            if (!$is_user_login) {
                ob_end_clean();
               redirect(base_url('/admin/admin_login'));
                die;
            }
            $this->load->library('form_validation');
            $this->form_validation->set_rules('productData[szProductCode]', 'Product Code', 'required|chekDuplicate['. __DBC_SCHEMATA_PRODUCT__ . '.szProductCode]');
            $this->form_validation->set_rules('productData[szProductDiscription]', 'Product Description', 'required');
            $this->form_validation->set_rules('productData[szProductCost]', 'Product Cost', 'required|numeric|greater_than[0]');
//            $this->form_validation->set_rules('productData[dtExpiredOn]', 'Expiry Date', 'required');
            $this->form_validation->set_rules('productData[supplier]', 'Supplier Name', 'alpha_numeric_spaces');
            $this->form_validation->set_rules('productData[min_ord_qty]', 'Minimum Order Quantity', 'required|numeric|greater_than[0]');
            $this->form_validation->set_rules('productData[model_stk_val]', 'Model Stock Value', 'required|numeric|greater_than[0]');
            $this->form_validation->set_rules('productData[szAvailableQuantity]', 'Available Quantity', 'required|numeric|greater_than_equal_to[0]|less_than_equal_to[1000]');
            $this->form_validation->set_rules('productData[szProductImage]', 'Product Image', 'required');
            $this->form_validation->set_message('chekDuplicate', ' %s already exist.');
             $this->form_validation->set_message('alpha_numeric_spaces', 'Supplier Name must contain alpha-numeric characters only.');
            $this->form_validation->set_message('required', '{field} is required.');
            if ($this->form_validation->run() == FALSE)
            { 
                $data['notification'] = $count;
                $data['commentnotification'] = $commentReplyNotiCount;
                $data['szMetaTagTitle'] = "Add Consumables";
                $data['is_user_login'] = $is_user_login;
                $data['pageName'] = "Inventory";
                $data['subpageName'] = "Consumables_List";
                $this->load->view('layout/admin_header', $data);
                $this->load->view('inventory/addConsumables');
                $this->load->view('layout/admin_footer');
            }
            else
            {
                if( $this->Inventory_Model->insertProduct())
                {
                    $szMessage['type'] = "success";
                    $szMessage['content'] = "<h4><strong>Consumables added successfully.</strong></h4>  ";
                    $this->session->set_userdata('drugsafe_user_message', $szMessage); 
                     redirect(base_url('/inventory/consumablesList'));
                  
                    die;
                }
            }
        }
        function editProductData()
        {
            
             $idProduct = $this->input->post('idProduct');
             $flag = $this->input->post('flag');
     
             $this->session->set_userdata('idProduct',$idProduct);
             $this->session->set_userdata('flag',$flag);
           
            echo "SUCCESS||||";
            echo "editDrugTestKit";
            
        }
        
         public function editDrugTestKit() {
            $count = $this->Admin_Model->getnotification();
            $commentReplyNotiCount = $this->Forum_Model->commentReplyNotifications();
            $is_user_login = is_user_login($this);
            // redirect to dashboard if already logged in
            if (!$is_user_login) {
                ob_end_clean();
                 redirect(base_url('/admin/admin_login'));
                die;
            }
           
            $idProduct = $this->session->userdata('idProduct');
            $flag = $this->session->userdata('flag');
            $data_validate = $this->input->post('productData');
            $productDataAry = $this->Inventory_Model->getProductDetailsById($idProduct);
           
            if ($productDataAry['szProductCode'] != $data_validate['szProductCode']) {
            $isunique = '|chekDuplicate['. __DBC_SCHEMATA_PRODUCT__ . '.szProductCode]';
            } else {
            $isunique = '';
        }
           
            $this->load->library('form_validation');
            $this->form_validation->set_rules('productData[szProductCode]', 'Product Code', 'required' . $isunique);
            $this->form_validation->set_rules('productData[szProductDiscription]', 'Product Description', 'required');
            $this->form_validation->set_rules('productData[szProductCost]', 'Product Cost', 'required|numeric|greater_than[0]');
            $this->form_validation->set_rules('productData[szProductCategory]', 'Product Category', 'required');
            $this->form_validation->set_rules('productData[supplier]', 'Supplier Name','alpha_numeric_spaces');
            $this->form_validation->set_rules('productData[min_ord_qty]', 'Minimum Order Quantity', 'required|numeric|greater_than[0]');
            $this->form_validation->set_rules('productData[model_stk_val]', 'Model Stock Value', 'required|numeric|greater_than[0]');
            $this->form_validation->set_rules('productData[szAvailableQuantity]', 'Available Quantity', 'required|numeric|greater_than_equal_to[0]|less_than_equal_to[1000]');
//            $this->form_validation->set_rules('productData[dtExpiredOn]', 'Expiry Date', 'required');
             $this->form_validation->set_message('chekDuplicate', ' %s already exist.');
            $this->form_validation->set_rules('productData[szProductImage]', 'Product Image', 'required');
             $this->form_validation->set_message('alpha_numeric_spaces', 'Supplier Name must contain alpha-numeric characters only.');
            
            $this->form_validation->set_message('required', '{field} is required.');
            
            if ($this->form_validation->run() == FALSE)
            {
                $data['szMetaTagTitle'] = "Edit Product";
                $data['is_user_login'] = $is_user_login;
                $data['pageName'] = "Inventory";
                $data['subpageName'] = "Drug_Test_Kit_List";
                $_POST['productData']=$productDataAry;
                $data['notification'] = $count;
                $data['commentnotification'] = $commentReplyNotiCount;
                $this->load->view('layout/admin_header', $data);
                $this->load->view('inventory/editDrugTestKit');
                $this->load->view('layout/admin_footer');
            }
            else
            {
                if( $this->Inventory_Model->UpdateProduct($idProduct))
                {
                   
                        $szMessage['type'] = "success";
                        $szMessage['content'] = "</h4> <strong> Drug Test Kit updated successfully.</strong><h4>  ";
                        $this->session->set_userdata('drugsafe_user_message', $szMessage);
                        $this->session->unset_userdata('idProduct');
                        $this->session->unset_userdata('flag');
                        ob_end_clean();
                         redirect(base_url('/inventory/drugTestKitList'));
                        die;
                   
                }
            }
        }
        function uploadProfileImage()
        {
            
            $output_dir = __APP_PATH_PRODUCT_IMAGES__;
            
            $ret = array();
            $RandomNum   = time();
            $ImageName      = str_replace(' ','-',strtolower($_FILES['myfile']['name']));
            $ImageType      = $_FILES['myfile']['type']; //"image/png", image/jpeg etc.
            $ImageExt = substr($ImageName, strrpos($ImageName, '.'));
            $ImageExt       = str_replace('.','',$ImageExt);
            $ImageName      = preg_replace("/\.[^.\s]{3,4}$/", "", $ImageName);
            if($ImageName > 10)
            {
                $ImageName=substr($ImageName,0,10);
            }
            if(strlen($ImageName)>20)
            {
                $ImageName=substr_replace($ImageName,'',20);
            }
            $NewImageName = 'Drug_product_'.$ImageName.'-'.$RandomNum.'.'.$ImageExt;
            move_uploaded_file($_FILES["myfile"]["tmp_name"],$output_dir.'/'. $NewImageName);
            // echo $output_dir. $NewImageName;
            $randomNum=rand().time();
            $ret['name']= $NewImageName;
            $ret['rand_num']= $randomNum;
            $ret['img_div']= '<div id="photoDiv_'.$randomNum.'"><img class="" src="'.__BASE_USER_PRODUCT_IMAGES_URL__.'/'.$NewImageName.'" width="60" height="60" alt="Product  Image" />
                                   <a href="javascript:void(0);" id="remove_btn_'.$randomNum.'" class="btn red-intense btn-sm" onclick="removeIncidentPhoto();">Remove</a>
                           </div>';
           
            echo json_encode($ret);
        }
        function drugtestkitlist()
        {
           $is_user_login = is_user_login($this);
            // redirect to dashboard if already logged in
            if(!$is_user_login)
            {
                ob_end_clean();
               redirect(base_url('/admin/admin_login'));
                die;
            }
             $searchAry = $_POST['szSearchProdCode'];
             
             $config['base_url'] = __BASE_URL__ . "/inventory/drugtestkitlist/";
             $config['total_rows'] = count($this->Inventory_Model->viewDrugTestKitList($limit,$offset,$searchAry));
             $config['per_page'] = __PAGINATION_RECORD_LIMIT__;
             $this->pagination->initialize($config);
            
               $idfranchisee = $_SESSION['drugsafe_user']['id'];
          
               $drugTestKitAray =$this->Inventory_Model->viewDrugTestKitList($config['per_page'],$this->uri->segment(3),$searchAry);
            $drugTestKitListAray =$this->Inventory_Model->viewDrugTestKitList();
               $count = $this->Admin_Model->getnotification();
            $commentReplyNotiCount = $this->Forum_Model->commentReplyNotifications();
                    $data['drugTestKitAray'] = $drugTestKitAray;
                    $data['szMetaTagTitle'] = " Drug Test Kit List";
                    $data['is_user_login'] = $is_user_login;
                    $data['pageName'] = "Inventory";
                    $data['subpageName'] = "Drug_Test_Kit_List";
                    $data['notification'] = $count;
            $data['commentnotification'] = $commentReplyNotiCount;
                    $data['data'] = $data;
            $data['drugtestkitlist'] = $drugTestKitListAray;
 
            $this->load->view('layout/admin_header',$data);
            $this->load->view('inventory/drugTestKitList');
            $this->load->view('layout/admin_footer');
        }
        function marketingmateriallist()
        {
           $is_user_login = is_user_login($this);
            // redirect to dashboard if already logged in
            if(!$is_user_login)
            {
                ob_end_clean();
                redirect(base_url('/admin/admin_login'));
                die;
            }
            
             $searchAry = $_POST['szSearchProdCode'];
             $config['base_url'] = __BASE_URL__ . "/inventory/marketingmateriallist/";
             $config['total_rows'] = count($this->Inventory_Model->viewMarketingMaterialList($searchAry,$limit,$offset));
             $config['per_page'] = __PAGINATION_RECORD_LIMIT__;
             $this->pagination->initialize($config);
            
             $idfranchisee = $_SESSION['drugsafe_user']['id'];
             $marketingMaterialAray =$this->Inventory_Model->viewMarketingMaterialList($searchAry,$config['per_page'],$this->uri->segment(3));
            $marketingMaterialListAray =$this->Inventory_Model->viewMarketingMaterialList();
             $count = $this->Admin_Model->getnotification();
            $commentReplyNotiCount = $this->Forum_Model->commentReplyNotifications();
                    $data['marketingMaterialAray'] = $marketingMaterialAray;
                    $data['szMetaTagTitle'] = "Marketing Material List";
                    $data['is_user_login'] = $is_user_login;
                    $data['pageName'] = "Inventory";
                    $data['subpageName'] = "Marketing_Material_List";
                    $data['notification'] = $count;
            $data['commentnotification'] = $commentReplyNotiCount;
                    $data['arErrorMessages'] = $this->Admin_Model->arErrorMessages;
                    $data['data'] = $data;
            $data['marketingMaterialListAray'] = $marketingMaterialListAray;
 
            $this->load->view('layout/admin_header',$data);
            $this->load->view('inventory/marketingMaterialList');
            $this->load->view('layout/admin_footer');
        }
        public function deleteProductAlert()
        {
            $data['mode'] = '__DELETE_PRODUCT_POPUP__';
            $data['idProduct'] = $this->input->post('idProduct');
            $data['flag'] = $this->input->post('flag');
          
            $this->load->view('admin/admin_ajax_functions',$data);
        }
        public function deleteProductConfirmation()
        {
            $data['mode'] = '__DELETE_PRODUCT_POPUP_CONFIRM__';
            $data['idProduct'] = $this->input->post('idProduct');
            $data['flag'] = $this->input->post('flag');
            $this->Inventory_Model->deleteProduct($data['idProduct']);
            $this->load->view('admin/admin_ajax_functions',$data);
        }   
        
        function editMarketingData()
        {
            $idProduct = $this->input->post('idProduct');
            $flag = $this->input->post('flag');
            $this->session->set_userdata('idProduct',$idProduct);
            $this->session->set_userdata('flag',$flag);
            echo "SUCCESS||||";
            echo "editMarketingMaterial";
        }
        
        public function editMarketingMaterial() {
            $count = $this->Admin_Model->getnotification();
            $commentReplyNotiCount = $this->Forum_Model->commentReplyNotifications();
            $is_user_login = is_user_login($this);
            // redirect to dashboard if already logged in
            if (!$is_user_login) {
                ob_end_clean();
               redirect(base_url('/admin/admin_login'));
                die;
            }
            
            $idProduct = $this->session->userdata('idProduct');
            $flag = $this->session->userdata('flag');
         
            $productDataAry = $this->Inventory_Model->getProductDetailsById($idProduct);
            $data_validate = $this->input->post('productData');
            if ($productDataAry['szProductCode'] != $data_validate['szProductCode']) {
            $isunique = '|chekDuplicate['. __DBC_SCHEMATA_PRODUCT__ . '.szProductCode]';
            } else {
            $isunique = '';
        }
            $this->load->library('form_validation');
            $this->form_validation->set_rules('productData[szProductCode]', 'Product Code', 'required' .$isunique);
            $this->form_validation->set_rules('productData[szProductDiscription]', 'Product Description', 'required');
            $this->form_validation->set_rules('productData[szProductCost]', 'Product Cost', 'required|numeric|greater_than[0]');
            $this->form_validation->set_rules('productData[szAvailableQuantity]', 'Available Quantity', 'required|numeric|greater_than_equal_to[0]|less_than_equal_to[1000]');
//            $this->form_validation->set_rules('productData[dtExpiredOn]', 'Expiry Date', 'required');
            $this->form_validation->set_rules('productData[supplier]', 'Supplier Name','alpha_numeric_spaces');
            $this->form_validation->set_rules('productData[min_ord_qty]', 'Minimum Order Quantity', 'required|numeric|greater_than[0]');
            $this->form_validation->set_rules('productData[model_stk_val]', 'Model Stock Value', 'required|numeric|greater_than[0]');
            $this->form_validation->set_rules('productData[szProductImage]', 'Product Image', 'required');
            $this->form_validation->set_message('chekDuplicate', ' %s already exist.');
            $this->form_validation->set_message('required', '{field} is required.');
             $this->form_validation->set_message('alpha_numeric_spaces', 'Supplier Name must contain alpha-numeric characters only.');
            
            if ($this->form_validation->run() == FALSE)
            {
                $data['notification'] = $count;
                $data['commentnotification'] = $commentReplyNotiCount;
                $data['szMetaTagTitle'] = "Edit Product";
                $data['is_user_login'] = $is_user_login;
                $data['pageName'] = "Inventory";
                $data['subpageName'] = "Marketing_Material_List";
                $_POST['productData']=$productDataAry;
                $this->load->view('layout/admin_header', $data);
                $this->load->view('inventory/editMarketingMaterial');
                $this->load->view('layout/admin_footer');
            }
            else
            {
                if( $this->Inventory_Model->UpdateProduct($idProduct))
                {
                    $szMessage['type'] = "success";
                        $szMessage['content'] = "<h4><strong> Marketing Material updated successfully. </strong> </h4>  ";
                        $this->session->set_userdata('drugsafe_user_message', $szMessage);
                        $this->session->unset_userdata('idProduct');
                        $this->session->unset_userdata('flag');
                        ob_end_clean();
                          redirect(base_url('/inventory/marketingMaterialList'));
                        die;
                }
            }
        }
        function editConsumablesData()
        {
           
             $idProduct = $this->input->post('idProduct');
             $flag = $this->input->post('flag');
     
            $this->session->set_userdata('idProduct',$idProduct);
            $this->session->set_userdata('flag',$flag);
           
            echo "SUCCESS||||";
            echo "editConsumables";
            
        }
        
         public function editConsumables() {
            $count = $this->Admin_Model->getnotification();
             $commentReplyNotiCount = $this->Forum_Model->commentReplyNotifications();
            $is_user_login = is_user_login($this);
            // redirect to dashboard if already logged in
            if (!$is_user_login) {
                ob_end_clean();
                redirect(base_url('/admin/admin_login'));
                die;
            }
            
            $idProduct = $this->session->userdata('idProduct');
            $flag = $this->session->userdata('flag');
         
            $productDataAry = $this->Inventory_Model->getProductDetailsById($idProduct);
             $data_validate = $this->input->post('productData');
            if ($productDataAry['szProductCode'] != $data_validate['szProductCode']) {
            $isunique = '|chekDuplicate['. __DBC_SCHEMATA_PRODUCT__ . '.szProductCode]';
            } else {
                $isunique = '';
            }
           
            $this->load->library('form_validation');
            $this->form_validation->set_rules('productData[szProductCode]', 'Product Code', 'required' .$isunique);
            $this->form_validation->set_rules('productData[szProductDiscription]', 'Product Description', 'required');
            $this->form_validation->set_rules('productData[szProductCost]', 'Product Cost', 'required|numeric|greater_than[0]');
            $this->form_validation->set_rules('productData[szAvailableQuantity]', 'Available Quantity', 'required|numeric|greater_than_equal_to[0]|less_than_equal_to[1000]');
            $this->form_validation->set_rules('productData[supplier]', 'Supplier Name','alpha_numeric_spaces');
            $this->form_validation->set_rules('productData[min_ord_qty]', 'Minimum Order Quantity', 'required|numeric|greater_than[0]');
            $this->form_validation->set_rules('productData[model_stk_val]', 'Model Stock Value', 'required|numeric|greater_than[0]');
//            $this->form_validation->set_rules('productData[dtExpiredOn]', 'Expiry Date', 'required');
            $this->form_validation->set_rules('productData[szProductImage]', 'Product Image', 'required');
            $this->form_validation->set_message('chekDuplicate', ' %s already exist.');
            $this->form_validation->set_message('required', '{field} is required.');
            $this->form_validation->set_message('alpha_numeric_spaces', 'Supplier Name must contain alpha-numeric characters only.');
            
            if ($this->form_validation->run() == FALSE)
            {
                $data['notification'] = $count;
                $data['commentnotification'] = $commentReplyNotiCount;
                $data['szMetaTagTitle'] = "Edit Product";
                $data['is_user_login'] = $is_user_login;
                $data['pageName'] = "Inventory";
                $data['subpageName'] = "Consumables_List";
                $_POST['productData']=$productDataAry;
                $this->load->view('layout/admin_header', $data);
                $this->load->view('inventory/editConsumables');
                $this->load->view('layout/admin_footer');
            }
            else
            {
                if( $this->Inventory_Model->UpdateProduct($idProduct))
                {
                    $szMessage['type'] = "success";
                    $szMessage['content'] = "<h4> <strong> Consumables updated successfully.</strong></h4>  ";
                    $this->session->set_userdata('drugsafe_user_message', $szMessage); 
                    $this->session->unset_userdata('idProduct');
                    $this->session->unset_userdata('flag');
                    ob_end_clean();
                    redirect(base_url('/inventory/ConsumablesList'));
                    die;
                }
            }
        }
        function consumableslist()
        {
            $is_user_login = is_user_login($this);
            // redirect to dashboard if already logged in
            if(!$is_user_login)
            {
                ob_end_clean();
               redirect(base_url('/admin/admin_login'));
                die;
            }
            $searchAry = $_POST['szSearchProdCode'];
            $config['base_url'] = __BASE_URL__ . "/inventory/consumableslist/";
            $config['total_rows'] = count($this->Inventory_Model->viewConsumablesList($limit,$offset,$searchAry));
            $config['per_page'] = __PAGINATION_RECORD_LIMIT__;
            $this->pagination->initialize($config);
            $idfranchisee = $_SESSION['drugsafe_user']['id'];
          $consumablesAray =$this->Inventory_Model->viewConsumablesList($config['per_page'],$this->uri->segment(3),$searchAry);
               $consumableslistAry =$this->Inventory_Model->viewConsumablesList();
               $count = $this->Admin_Model->getnotification();
            $commentReplyNotiCount = $this->Forum_Model->commentReplyNotifications();
                    $data['consumablesAray'] = $consumablesAray;
                    $data['szMetaTagTitle'] = " Consumables List";
                    $data['is_user_login'] = $is_user_login;
                    $data['pageName'] = "Inventory";
                    $data['subpageName'] = "Consumables_List";
                    $data['notification'] = $count;
            $data['commentnotification'] = $commentReplyNotiCount;
                    $data['data'] = $data;
                    $data['consumableslist'] = $consumableslistAry;
 
            $this->load->view('layout/admin_header',$data);
            $this->load->view('inventory/consumablesList');
            $this->load->view('layout/admin_footer');
        }
         public function viewProductDetails()
        {
            $data['mode'] = '__VIEW_PRODUCT_POPUP__';
            $data['idProduct'] = $this->input->post('idProduct');
            $data['flag'] = $this->input->post('flag');
            $this->load->view('admin/common_ajax_functions',$data);
        }
       
    }      
?>