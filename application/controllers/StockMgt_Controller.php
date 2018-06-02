<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class StockMgt_Controller extends CI_Controller {
     
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
            if($is_user_login)
            {
  
                   redirect(base_url('/stock_management/modelstockvalue')); 
                    die;

            }
            else
            {
             ob_end_clean();
             redirect(base_url('/admin/admin_login')); 
                die;
            }

        } 

        function ModelStock()
        {
         
            $idfranchisee = $this->input->post('idfranchisee');
            $flag = $this->input->post('flag');
           
            {
                $this->session->set_userdata('idfranchisee',$idfranchisee);
                
                echo "SUCCESS||||";
                echo "modelstockvalue";
            }
            
        }
        function modelstockvalue()
        {
            $count = $this->Admin_Model->getnotification();
            $commentReplyNotiCount = $this->Forum_Model->commentReplyNotifications();
            $is_user_login = is_user_login($this);
        
            // redirect to franchisee list if already logged in
            if(!$is_user_login)
            {
                ob_end_clean();
                 redirect(base_url('/admin/admin_login'));
                die;
            }
          
             $idfranchisee = $this->session->userdata('idfranchisee');
             $franchiseeArr = $this->Admin_Model->getAdminDetailsByEmailOrId('',$idfranchisee);

             $drugTestKitAray =$this->StockMgt_Model->viewDrugTestKitList($idfranchisee,'1');
      
             $fr_value_data = array();
             foreach ($drugTestKitAray as $drugTestKitdata){
              if($_SESSION['drugsafe_user']['iRole']==5){
              $drugTestKitDataArr = $this->StockMgt_Model->getStockValueDetailsById($idfranchisee,$drugTestKitdata['iProductId']);}
              else{
              $drugTestKitDataArr = $this->StockMgt_Model->getStockValueDetailsById($idfranchisee,$drugTestKitdata['id']);}    
            
             array_push($fr_value_data, $drugTestKitDataArr);
          }
         
             
             
            $marketingMaterialAray =$this->StockMgt_Model->viewMarketingMaterialList($idfranchisee);
  
                $mr_value_data = array();
                foreach ($marketingMaterialAray as $marketingMaterialdata){
                $marketingMaterialDataArr = $this->StockMgt_Model->getStockValueDetailsById($idfranchisee,$marketingMaterialdata['id']);
                array_push($mr_value_data,$marketingMaterialDataArr);
             }
             
                $consumablesAray =$this->StockMgt_Model->viewConsumablesList($idfranchisee);
  
                $con_value_data = array();
                foreach ($consumablesAray as $consumablesdata){
                $consumablesDataArr = $this->StockMgt_Model->getStockValueDetailsById($idfranchisee,$consumablesdata['id']);
                array_push($con_value_data,$consumablesDataArr);
             }

                    $data['drugTestKitDataArr'] = $fr_value_data;
                    $data['marketingMaterialDataArr'] = $mr_value_data;
                    $data['marketingMaterialAray'] = $marketingMaterialAray;
                    $data['consumablesDataArr'] = $con_value_data;
                    $data['consumablesAray'] = $consumablesAray;
                    $data['drugTestKitAray'] = $drugTestKitAray;
                    $data['idfranchisee'] = $idfranchisee;
                    $data['franchiseeArr'] = $franchiseeArr;
                    $data['szMetaTagTitle'] = "Model Stock Value";
                    $data['is_user_login'] = $is_user_login;
                    $data['pageName'] = "Inventory";
                    $data['notification'] = $count;
            $data['commentnotification'] = $commentReplyNotiCount;
                    
            $this->load->view('layout/admin_header',$data);
            $this->load->view('stockManagement/modelStockValue');
            $this->load->view('layout/admin_footer');
        }
        
       function addModelStock()
        {
           $idProduct = $this->input->post('idProduct');
          $this->session->set_userdata('idProduct',$idProduct);
            {
                echo "SUCCESS||||";
                echo "addmodelstockvalue";
            }
 
        }
        function addmodelstockvalue()
        {
            $is_user_login = is_user_login($this);
             $count = $this->Admin_Model->getnotification();
            $commentReplyNotiCount = $this->Forum_Model->commentReplyNotifications();
            // redirect to franchisee list if already logged in
            if(!$is_user_login)
            {
                ob_end_clean();
                 redirect(base_url('/admin/admin_login'));
                die;
            }
            $idfranchisee = $this->session->userdata('idfranchisee');
            $franchiseeArr = $this->Admin_Model->getAdminDetailsByEmailOrId('',$idfranchisee);
            
            $validate = $this->input->post('addModelStockValue');

            $idProduct = $this->session->userdata('idProduct');
          
          
            $productDataAry = $this->StockMgt_Model->getProductsDetailsById($idProduct);
         
            $idCategory = $productDataAry['szProductCategory'];
           
           
            $CategoryDataAry = $this->StockMgt_Model->getCategoryDetailsById($idCategory);
 
            $frdata = array();
            $frdata   =  array_merge($productDataAry,$CategoryDataAry);
            if($frdata['szProductCategory']==1){
                    $drActive= $frdata['szProductCategory'];   
                    $this->session->set_userdata('drugsafe_tab_status', $drActive);
            }
            if($frdata['szProductCategory']==2){
                    $mrActive= $frdata['szProductCategory'];   
                    $this->session->set_userdata('drugsafe_tab_status', $mrActive);
            }
            if($frdata['szProductCategory']==3){
                    $conActive= $frdata['szProductCategory'];   
                    $this->session->set_userdata('drugsafe_tab_status', $conActive);
            }
            
            $this->load->library('form_validation');
            $this->form_validation->set_rules('addModelStockValue[szName]', 'Product Category', 'required');
            $this->form_validation->set_rules('addModelStockValue[szProductCode]', 'Product Code');
            $this->form_validation->set_rules('addModelStockValue[szModelStockVal]', 'Model Stock Value','trim|required|greater_than[0]|less_than_equal_to[1000]');
             $this->form_validation->set_message('required', '{field} is required.');
            
            if ($this->form_validation->run() == FALSE)
            {
                $_POST['addModelStockValue'] = $frdata;
                $data['franchiseeArr'] = $franchiseeArr;
                $data['productDataAry'] = $productDataAry;
                $data['idProduct'] = $idProduct;
                $data['szMetaTagTitle'] = "Add Model Stock Value";
                $data['is_user_login'] = $is_user_login;
                $data['pageName'] = "Add_Model_Stock_Value";
                $data['notification'] = $count;
                $data['commentnotification'] = $commentReplyNotiCount;
                
            $this->load->view('layout/admin_header',$data);
            $this->load->view('stockManagement/addModelStockValue');
            $this->load->view('layout/admin_footer');
            }
            else
            {
                if( $this->StockMgt_Model->insertModelStockValue($idfranchisee,$validate,$idProduct))
                {
                    $szMessage['type'] = "success";
                    $szMessage['content'] = "<strong><h3>Model Stock Value added successfully.</h3></strong> ";
                    $this->session->set_userdata('drugsafe_user_message', $szMessage);
                    
                    if($idCategory==1){
                    $drActive= $idCategory;   
                    $this->session->set_userdata('drugsafe_tab_status', $drActive); 
                     redirect(base_url('/stock_management/modelstockvalue'));
                    die;
                    }
                    elseif($idCategory==2){
                    $mrActive= $idCategory                  ; 
                    $this->session->set_userdata('drugsafe_tab_status', $mrActive);
                    redirect(base_url('/stock_management/modelstockvalue'));
                    die;  
                    }
                    else{
                    $conActive= $idCategory                  ; 
                    $this->session->set_userdata('drugsafe_tab_status', $conActive);
                    redirect(base_url('/stock_management/modelstockvalue'));
                    die;  
                    }
                }
            }
        }

         function editModelStock()
        {
           $idProduct = $this->input->post('idProduct');
           $this->session->set_userdata('idProduct',$idProduct);
            {
                echo "SUCCESS||||";
                echo "editmodelstockvalue";
            }
 
        }
        function editmodelstockvalue()
        {
            $count = $this->Admin_Model->getnotification();
            $commentReplyNotiCount = $this->Forum_Model->commentReplyNotifications();
            $is_user_login = is_user_login($this);

            // redirect to dashboard if already logged in
            if(!$is_user_login)
            {
                ob_end_clean();
                redirect(base_url('/admin/admin_login'));
                die;
            }
            $idfranchisee = $this->session->userdata('idfranchisee');
            $franchiseeArr = $this->Admin_Model->getAdminDetailsByEmailOrId('',$idfranchisee);
            
           
            $idProduct = $this->session->userdata('idProduct');
            $modelStockDataAry = $this->StockMgt_Model->getStockValueDetailsById($idfranchisee,$idProduct);
            $productDataAry = $this->StockMgt_Model->getProductsDetailsById($idProduct);
            $idCategory = $productDataAry['szProductCategory'];
           
            $CategoryDataAry = $this->StockMgt_Model->getCategoryDetailsById($idCategory);
 
            $frdata = array();
            $frdata   =  array_merge($modelStockDataAry, $productDataAry,$CategoryDataAry);

          if($frdata['szProductCategory']==1){
                    $drActive= $frdata['szProductCategory'];   
                    $this->session->set_userdata('drugsafe_tab_status', $drActive);
            }
            if($frdata['szProductCategory']==2){
                    $mrActive= $frdata['szProductCategory'];   
                    $this->session->set_userdata('drugsafe_tab_status', $mrActive);
            }
            if($frdata['szProductCategory']==3){
                    $conActive= $frdata['szProductCategory'];   
                    $this->session->set_userdata('drugsafe_tab_status', $conActive);
            } 
            $this->load->library('form_validation');
            $this->form_validation->set_rules('editModelStockValue[szName]', 'Product Category', 'required');
            $this->form_validation->set_rules('editModelStockValue[szProductCode]', 'Product Code', 'required');
            $this->form_validation->set_rules('editModelStockValue[szModelStockVal]', 'Model Stock Value', 'required|numeric|greater_than[0]|less_than_equal_to[1000]');
            $this->form_validation->set_message('required', '{field} is required.');
            
            if ($this->form_validation->run() == FALSE)
            {
                
                $_POST['editModelStockValue'] = $frdata;
                $data['idProduct'] = $idProduct;
                $data['productDataAry'] = $productDataAry;
                $data['franchiseeArr'] = $franchiseeArr;
                $data['notification'] = $count;
                $data['commentnotification'] = $commentReplyNotiCount;
                $data['szMetaTagTitle'] = "Edit Model Stock Value";
                $data['is_user_login'] = $is_user_login;
                $data['pageName'] = "Edit_Model_Stock_Value";
                
            $this->load->view('layout/admin_header',$data);
            $this->load->view('stockManagement/editModelStockValue');
            $this->load->view('layout/admin_footer');
            }
            else
            {
               $data_validate = $this->input->post('editModelStockValue');
           
                if( $this->StockMgt_Model->updateModelStockVal($data_validate,$idProduct,$idfranchisee))
                {
                    $szMessage['type'] = "success";
                    $szMessage['content'] = "<strong><h3>Model Stock Value Updated successfully.</h3></strong> ";
                    $this->session->set_userdata('drugsafe_user_message', $szMessage); 
                    if($idCategory==1){ 
                        
                    $drActive= $idCategory;   
                    $this->session->set_userdata('drugsafe_tab_status', $drActive); 
                      redirect(base_url('/stock_management/modelstockvalue'));
                    die;
                    }
                    elseif($idCategory==2){
                    $mrActive= $idCategory                  ; 
                    $this->session->set_userdata('drugsafe_tab_status', $mrActive);
                     redirect(base_url('/stock_management/modelstockvalue'));
                    die;  
                    }
                    else{
                    $conActive= $idCategory; 
                    $this->session->set_userdata('drugsafe_tab_status', $conActive);
                     redirect(base_url('/stock_management/modelstockvalue'));
                    die;  
                    }
                }
            }
        }
         function productStock()
        {
         
            $idfranchisee = $this->input->post('idfranchisee');
            {
                $this->session->set_userdata('idfranchisee',$idfranchisee);
                echo "SUCCESS||||";
                echo "productstockqty";
            }
            
        }
        function productstockqty()
        {
            $is_user_login = is_user_login($this);
            $count = $this->Admin_Model->getnotification();
            $commentReplyNotiCount = $this->Forum_Model->commentReplyNotifications();
            // redirect to franchisee list if already logged in
            if(!$is_user_login)
            {
                ob_end_clean();
                 redirect(base_url('/admin/admin_login'));
                die;
            }
          
             $idfranchisee = $this->session->userdata('idfranchisee');
             $franchiseeArr = $this->Admin_Model->getAdminDetailsByEmailOrId('',$idfranchisee);
             $drugTestKitAray =$this->StockMgt_Model->viewDrugTestKitList($idfranchisee);
             $marketingMaterialAray =$this->StockMgt_Model->viewMarketingMaterialList($idfranchisee);
             $consumablesAray =$this->StockMgt_Model->viewConsumablesList($idfranchisee); 

                    $data['marketingMaterialAray'] = $marketingMaterialAray;
                    $data['drugTestKitAray'] = $drugTestKitAray;
                    $data['consumablesAray'] = $consumablesAray;
                    $data['franchiseeArr'] = $franchiseeArr;
                    $data['idfranchisee'] = $idfranchisee;
                    $data['szMetaTagTitle'] = "Product_Stock_Management";
                    $data['is_user_login'] = $is_user_login;
                    $data['pageName'] = "Inventory";
                    $data['notification'] = $count;
            $data['commentnotification'] = $commentReplyNotiCount;
            $this->load->view('layout/admin_header',$data);
            $this->load->view('stockManagement/productStockMgt');
            $this->load->view('layout/admin_footer');
        }  
        function addProductStock()
        {
           $idProduct = $this->input->post('idProduct');
           $this->session->set_userdata('idProduct',$idProduct);
            {
                echo "SUCCESS||||";
                echo "addProductStockqty";
            }
 
        }
        function addProductStockqty()
        {
            $is_user_login = is_user_login($this);
            $count = $this->Admin_Model->getnotification();
            $commentReplyNotiCount = $this->Forum_Model->commentReplyNotifications();
            // redirect to franchisee list if already logged in
            if(!$is_user_login)
            {
                ob_end_clean();
                 redirect(base_url('/admin/admin_login'));
                die;
            }
            $idfranchisee = $this->session->userdata('idfranchisee');
            $franchiseeArr = $this->Admin_Model->getAdminDetailsByEmailOrId('',$idfranchisee);
            
            $validate = $this->input->post('addProductStockQty');
           
   
            $idProduct = $this->session->userdata('idProduct');
          
          
            $productDataAry = $this->StockMgt_Model->getProductsDetailsById($idProduct);
         
            $idCategory = $productDataAry['szProductCategory'];
           
           
            $CategoryDataAry = $this->StockMgt_Model->getCategoryDetailsById($idCategory);
 
            $frdata = array();
            $frdata   =  array_merge($productDataAry,$CategoryDataAry);
           
            if($frdata['szProductCategory']==1){
                    $drActive= $frdata['szProductCategory'];   
                    $this->session->set_userdata('drugsafe_tab_status', $drActive);
            }
            if($frdata['szProductCategory']==2){
                    $mrActive= $frdata['szProductCategory'];   
                    $this->session->set_userdata('drugsafe_tab_status', $mrActive);
            }
            if($frdata['szProductCategory']==3){
                    $conActive= $frdata['szProductCategory'];   
                    $this->session->set_userdata('drugsafe_tab_status', $conActive);
            }
           

            $this->load->library('form_validation');
            $this->form_validation->set_rules('addProductStockQty[szName]', 'Product Category', 'required');
            $this->form_validation->set_rules('addProductStockQty[szProductCode]', 'Product Code', 'required');
            $this->form_validation->set_rules('addProductStockQty[szQuantity]', 'Quantity', 'required|numeric|greater_than[0]|less_than_equal_to[1000]');
            $this->form_validation->set_message('required', '{field} is required.');
            
            if ($this->form_validation->run() == FALSE)
            {
                $_POST['addProductStockQty'] = $frdata;
                $data['idProduct'] = $idProduct;
                $data['franchiseeArr'] = $franchiseeArr;
                $data['productDataAry'] = $productDataAry;
                $data['szMetaTagTitle'] = "Add_Product_Stock_Quantity";
                $data['is_user_login'] = $is_user_login;
                $data['pageName'] = "Add_Product_Stock_Quantity";
                $data['notification'] = $count;
                $data['commentnotification'] = $commentReplyNotiCount;
           $this->load->view('layout/admin_header',$data);
            $this->load->view('stockManagement/addProductStockQty');
            $this->load->view('layout/admin_footer');
            }
            else
            {
                if( $this->StockMgt_Model->insertProductStockQuantity($idfranchisee,$validate,$idProduct))
                {
                    $szMessage['type'] = "success";
                    $szMessage['content'] = "<strong><h3> Product Stock Quantity added successfully.</h3></strong>";
                    $this->session->set_userdata('drugsafe_user_message', $szMessage);
                    
                    if($idCategory==1){
                    $drActive= $idCategory;   
                    $this->session->set_userdata('drugsafe_tab_status', $drActive); 
                    redirect(base_url('/stock_management/productstockqty'));
                    die;
                    }
                    elseif($idCategory==2){
                    $mrActive= $idCategory                  ; 
                    $this->session->set_userdata('drugsafe_tab_status', $mrActive);
                      redirect(base_url('/stock_management/productstockqty'));
                    die;  
                    }
                    else{
                    $conActive= $idCategory; 
                    $this->session->set_userdata('drugsafe_tab_status', $conActive);
                       redirect(base_url('/stock_management/productstockqty'));
                    die;  
                    }
                }
            }
        }
        
         function editProductStock()
        {
            $idProduct = $this->input->post('idProduct');
            $flag = $this->input->post('flag');
            
            {
                 $this->session->set_userdata('flag',$flag);
                 $this->session->set_userdata('idProduct',$idProduct);
                
                echo "SUCCESS||||";
                echo "editproductstockqty";
            }
 
        }
        function editproductstockqty()
        {
            
            $is_user_login = is_user_login($this);
            $count = $this->Admin_Model->getnotification();
            $commentReplyNotiCount = $this->Forum_Model->commentReplyNotifications();
            // redirect to dashboard if already logged in
            if(!$is_user_login)
            {
                ob_end_clean();
                 redirect(base_url('/admin/admin_login'));
                die;
            }
            $idfranchisee = $this->session->userdata('idfranchisee');
            $franchiseeArr = $this->Admin_Model->getAdminDetailsByEmailOrId('',$idfranchisee);
            $flag = $this->session->userdata('flag');
            
            $idProduct = $this->session->userdata('idProduct');
            $modelStockDataAry = $this->StockMgt_Model->getProductQtyDetailsById($idfranchisee,$idProduct);
         
            $QtyReqArr =  $this->StockMgt_Model->getQtyReqById($idProduct,$idfranchisee);
   
            $QtyAssignArr =  $this->StockMgt_Model->getQtyAssignListById($idProduct,$idfranchisee,$QtyReqArr[0]['id']);
            $productDataAry = $this->StockMgt_Model->getProductsDetailsById($idProduct);
           
            $idCategory = $productDataAry['szProductCategory'];
           
            $CategoryDataAry = $this->StockMgt_Model->getCategoryDetailsById($idCategory);
 
            
            $frdata = array();
            $frdata   =  array_merge($modelStockDataAry, $productDataAry,$CategoryDataAry);
            $totalAssign = 0;
          if(!empty($QtyAssignArr)){
            foreach ($QtyAssignArr as $qtyassign){
        $totalAssign = $totalAssign + $qtyassign['szQuantityAssigned'];
    }
}
             if($frdata['szProductCategory']==1){
                    $drActive= $frdata['szProductCategory'];   
                    $this->session->set_userdata('drugsafe_tab_status', $drActive);
            }
            if($frdata['szProductCategory']==2){
                    $mrActive= $frdata['szProductCategory'];   
                    $this->session->set_userdata('drugsafe_tab_status', $mrActive);
            }
            if($frdata['szProductCategory']==3){
                    $conActive= $frdata['szProductCategory'];   
                    $this->session->set_userdata('drugsafe_tab_status', $conActive);
            }
            $this->load->library('form_validation');
            $this->form_validation->set_rules('editProductStockQty[szName]', 'Product Category', 'required');
            $this->form_validation->set_rules('editProductStockQty[szProductCode]', 'Product Code', 'required');
            $this->form_validation->set_rules('editProductStockQty[szQuantity]', 'Quantity', 'required|numeric|less_than_equal_to[1000]');
            if($flag==1){
            $qty =  (int)$modelStockDataAry['szQuantity'] ;
            $this->form_validation->set_rules('editProductStockQty[szAdjustQuantity]', 'Adjust Quantity', 'trim|required|numeric|integer|greater_than_equal_to[0]|less_than['.$qty.']');
            }
            else{
             $this->form_validation->set_rules('editProductStockQty[szAddMoreQuantity]', 'Add More Quantity', 'required|numeric|less_than_equal_to[1000]');
            }
             $this->form_validation->set_message('required', '{field} is required.');
             
            if ($this->form_validation->run() == FALSE)
            {
              
                 $_POST['editProductStockQty'] = $frdata;
                 $data['assignqty'] = $totalAssign;
                 $data['qtyrequested'] = $QtyReqArr;
                 $data['idProduct'] = $idProduct;
                 $data['flag'] = $flag;
                 $data['productDataAry'] = $productDataAry;
                 $data['franchiseeArr'] = $franchiseeArr;
                 
                $data['notification'] = $count;
                $data['commentnotification'] = $commentReplyNotiCount;
                $data['szMetaTagTitle'] = "Edit Model Stock Value";
                $data['is_user_login'] = $is_user_login;
                $data['pageName'] = "Edit_Product_Stock_Quantity";
                
            $this->load->view('layout/admin_header',$data);
            $this->load->view('stockManagement/editProductStockQty');
            $this->load->view('layout/admin_footer');
            }
            else
            {
               $data_validate = $this->input->post('editProductStockQty');

                if( $this->StockMgt_Model->updateProductStockQty($data_validate,$idfranchisee,$idProduct,$flag))
                {
                    $szMessage['type'] = "success";
                    $szMessage['content'] = "<strong><h3>Product Stock Quantity Updated successfully.</h3></strong> ";
                    $this->session->set_userdata('drugsafe_user_message', $szMessage); 
                    if($idCategory==1){ 
                        
                    $drActive= $idCategory;   
                    $this->session->set_userdata('drugsafe_tab_status', $drActive); 
                     redirect(base_url('/stock_management/productstockqty'));
                    die;
                    }
                    else{
                    $mrActive= $idCategory; 
                    $this->session->set_userdata('drugsafe_tab_status', $mrActive);
                      redirect(base_url('/stock_management/productstockqty'));
                    die;  
                    }
                }
            }
        }
         public function quantityRequestAlert()
        {
                $data['mode'] = '__REQUEST_QUANTITY_POPUP__';
                $data['idProduct'] = $this->input->post('idProduct');
                $data['flag'] = $this->input->post('flag');
                
            $this->load->view('admin/admin_ajax_functions',$data);
        }
        public function quantityRequestConfirmation()
         {

            $data_validate = $this->input->post('requestQuantity');

            $idProduct = $this->input->post('idProduct');

            $flag = $this->input->post('flag');

            $idfranchisee = $_SESSION['drugsafe_user']['id'];

            $data['flag'] = $this->input->post('flag');

            $this->load->library('form_validation');

            $this->form_validation->set_rules('requestQuantity[szQuantity]','Request Quantity','trim|required|numeric|integer|greater_than[0]|less_than[1000]|callback_requestQuantity_check');

             $this->form_validation->set_message('required', '{field} is required.');

            if ($this->form_validation->run() == FALSE)
           {
                ?>
                <div id="requestQuantityStatus" class="modal fade" tabindex="-2" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                     <div class="modal-title">
                       <div class="caption">
                             <h4>   <i class="icon-equalizer font-red-sunglo"></i> &nbsp;
                                <span  class="caption-subject font-red-sunglo bold uppercase"> Request Quantity</span> </h4>
                        </div>
                   
                </div>
                       </div>
                <div class="modal-body">
                      <form action=""  id="requestQuantityForm" name="requestQuantity" method="post" class="form-horizontal form-row-sepe">
                       <div class="form-body">
                           <div class="form-group <?php if(form_error('requestQuantity[szQuantity]')){?>has-error<?php }?>">
                                    <label class="control-label col-md-3">Request Quantity</label>
                                        <div class="col-md-4">
                                           <div class="input-group">
                                                <input id="szQuantity" class="form-control input-large select2me input-square-right required  " type="text" value="<?php echo set_value('requestQuantity[szQuantity]'); ?>" placeholder="Request Quantity" onfocus="remove_formError(this.id,'true')" name="requestQuantity[szQuantity]">
                                            </div>
                                         <?php
                                            if(form_error('requestQuantity[szQuantity]')){?>
                                            <span class="help-block pull-left"><span><?php echo form_error('requestQuantity[szQuantity]');?></span>
                                            </span><?php }?> 
                                        </div>
                                </div> 
                </div>
                      </form>
                         
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                    
                    <button type="button" onclick="requestQuantityConfirmation('<?php echo $idProduct;?>','<?php  echo $flag ?>'); return false;" class="btn green">Submit</button>
                </div>
            </div>
        </div>
    </div>
<?php
           }
           else{

            $data['mode'] = '__REQUEST_QUANTITY_POPUP_CONFIRM__';
               //die($idProduct.'---'.$data_validate.'---'.$idfranchisee);
            $this->StockMgt_Model->requestQuantity($idProduct,$data_validate,$idfranchisee);
            $this->load->view('admin/admin_ajax_functions',$data);
           }
  
        } 
         
        function requestQuantity_check($szQuantity)
        {
         $idProduct = $this->input->post('idProduct');
        
          $idfranchisee = $_SESSION['drugsafe_user']['id'];
          $reqQtyListAray =$this->StockMgt_Model->reqQtyFr_check($idfranchisee,$idProduct);
          if(!empty($reqQtyListAray))
          {
              $this->form_validation->set_message('requestQuantity_check', 'Request for this product has been already sent.');
               return false;
          }
          else{
               return true;
          }
          
       }
        
        
        
        function stockreqlist()
        {
           $is_user_login = is_user_login($this);
           
            // redirect to dashboard if already logged in
            if(!$is_user_login)
            {
                ob_end_clean();
                  redirect(base_url('/admin/admin_login'));
                die;
            }
            
            
                $count = $this->Admin_Model->getnotification();
            $commentReplyNotiCount = $this->Forum_Model->commentReplyNotifications();
                $config['base_url'] = __BASE_URL__ . "/stock_management/stockreqlist/";
                $config['total_rows'] = count($this->StockMgt_Model->getQtyRequestFrId($limit,$offset));
                $config['per_page'] = __PAGINATION_RECORD_LIMIT__;


               $this->pagination->initialize($config);
              if($_SESSION['drugsafe_user']['iRole']==1){
               $frReqQtyAray =$this->StockMgt_Model->getQtyRequestFrId($config['per_page'],$this->uri->segment(3));
              }
              else{
                   $operationManagerId = $_SESSION['drugsafe_user']['id'];
                    $franchiseeAray =$this->Admin_Model->viewFranchiseeList(false,$operationManagerId);
                   $frReqQtyAray = array();
                   $i=0;
                     foreach ($franchiseeAray as $franchiseeData) {
                     $frReqQtyAray[$i] =$this->StockMgt_Model->getQtyRequestFrIdByOpId($franchiseeData['franchiseeId']);
                     //array_push($frReqQtyAray, $frdata);
                     $i++;
             }
                 
                 $frReqQtyAray = array_filter($frReqQtyAray);    
                  //  $frReqQtyAray =$this->StockMgt_Model->getQtyRequestFrIdByOpId();
                  }
                    $data['frReqQtyAray'] = $frReqQtyAray;
                   // $data['franchiseeAray'] = $reqQtyAray;
                    $data['szMetaTagTitle'] = "Stock Request List";
                    $data['is_user_login'] = $is_user_login;
                    $data['pageName'] = "Stock_Request";
                    $data['notification'] = $count;
            $data['commentnotification'] = $commentReplyNotiCount;
                    $data['data'] = $data;
            $this->load->view('layout/admin_header',$data);
            $this->load->view('stockManagement/reqQtyfranchiseeList');
            $this->load->view('layout/admin_footer');

        }
        function viewproductlistData()
        {
            $idfranchisee = $this->input->post('idfranchisee');
 
               $this->session->set_userdata('idfranchisee',$idfranchisee);
                
                echo "SUCCESS||||";
                echo "viewproductlist";
            
 
        }

        function viewproductlist()
        {
            $is_user_login = is_user_login($this);

            // redirect to dashboard if already logged in
            if(!$is_user_login)
            {
                ob_end_clean();
                 redirect(base_url('/admin/admin_login'));
                die;
            }
            
            $searchAry = $_POST['szProdReqList'];
        
            $idfranchisee = $this->session->userdata('idfranchisee'); 
            $count = $this->Admin_Model->getnotification();
            $commentReplyNotiCount = $this->Forum_Model->commentReplyNotifications();
                $config['base_url'] = __BASE_URL__ . "/stock_management/viewproductlist/";
                $config['total_rows'] = count($this->StockMgt_Model->getRequestQtyList($searchAry,$idfranchisee,$limit,$offset));
                $config['per_page'] = __PAGINATION_RECORD_LIMIT__;


        $this->pagination->initialize($config);
            
            $reqQtyListAray =$this->StockMgt_Model->getRequestQtyList($searchAry,$idfranchisee,$config['per_page'],$this->uri->segment(3));
            $reqProdListArr = $this->StockMgt_Model->getRequestQtyList('',$idfranchisee);
          //print_r($reqProdListArr);
            $franchiseeArr = $this->Admin_Model->getAdminDetailsByEmailOrId('',$idfranchisee);

            $data['reqQtyListAray'] = $reqQtyListAray;
            $data['reqProdListArr'] = $reqProdListArr;
            $data['idfranchisee'] = $idfranchisee;
            $data['franchiseeArr'] = $franchiseeArr;
            $data['pageName'] = "Stock_Request";
            $data['notification'] = $count;
            $data['commentnotification'] = $commentReplyNotiCount;
            $data['szMetaTagTitle'] = "Requested Product List";
            $data['is_user_login'] = $is_user_login;
         
            
            $this->load->view('layout/admin_header',$data);
            $this->load->view('stockManagement/productReqList');
            $this->load->view('layout/admin_footer');
        }
         public function allotReqQtyAlert()
        {
            $data['mode'] = '__ALLOT_QUANTITY_POPUP__';
            $data['idProduct'] = $this->input->post('idProduct');
            $requestQuantity =  $this->input->post('szReqQuantity');
            $data['szReqQuantity'] = $requestQuantity;
          
            $this->load->view('admin/admin_ajax_functions',$data);
        }
         public function allotReqQtyConfirmation()
           {  
            $data_validate = $this->input->post('allotQuantity');
           
            $idProduct = $this->input->post('idProduct');
           
          
            $value['szAddMoreQuantity'] = $this->input->post('szQuantity');
          
            $val['szReqQuantity'] = $this->input->post('szReqQuantity');
          
            $idfranchisee = $this->session->userdata('idfranchisee'); 
            

            $productQtyDetails =  $this->StockMgt_Model->getProductQtyDetailsById($idfranchisee,$idProduct);
            $productQtyDetails['szAddMoreQuantity'] = $data_validate['szAddMoreQuantity'];
            $productQtyDetails['szReqQuantity'] = $data_validate['szReqQuantity'];

           $this->load->library('form_validation');
           $this->form_validation->set_rules('allotQuantity[szReqQuantity]', 'Request Quantity', 'required');
           $this->form_validation->set_message('required', '{field} is required.');
            $QtyReqArr =  $this->StockMgt_Model->getQtyReqById($idProduct,$idfranchisee);
                $i=0;
                $reqId = $QtyReqArr[$i]['id'];
           $QtyAssignArr =  $this->StockMgt_Model->getQtyAssignListById($idProduct,$idfranchisee,$reqId);
                 $total=0;
               if(!empty($QtyAssignArr))
               {
                   
                  foreach($QtyAssignArr as $QtyAssigndata)
                  {
                      $total+=$QtyAssigndata['szQuantityAssigned'];
                  }
              }
           $qty =  (int)$data_validate['szReqQuantity']-$total ;
           $this->form_validation->set_rules('allotQuantity[szAddMoreQuantity]', 'Assign Quantity', 'trim|required|numeric|integer|greater_than_equal_to[0]|less_than_equal_to['.$qty.']');
            $this->form_validation->set_message('required', '{field} is required.');
           
          
            if ($this->form_validation->run() == FALSE)
           {
           ?>
                <div id="allotQuantityStatus" class="modal fade" tabindex="-2" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                     <div class="modal-title">
                       <div class="caption">
                             <h4>   <i class="icon-equalizer font-red-sunglo"></i> &nbsp;
                                <span  class="caption-subject font-red-sunglo bold uppercase"> Allot Quantity</span> </h4>
                        </div>
                   
                </div>
                       </div>
                <div class="modal-body">
                      <form action=""  id="allotQuantityForm" name="allotQuantity" method="post" class="form-horizontal form-row-sepe">
                       <div class="form-body">
                          <div class="form-group <?php if(form_error('allotQuantity[szReqQuantity]')){?>has-error<?php }?>">
                                    <label class="control-label col-md-4">Request Quantity</label>
                                        <div class="col-md-4">
                                           <div class="input-group">
                                                <input id="szReqQuantity" class="form-control input-large select2me read-only" readonly type="text" value="<?php echo set_value('allotQuantity[szReqQuantity]'); ?>" placeholder="Requested Quantity" onfocus="remove_formError(this.id,'true')" name="allotQuantity[szReqQuantity]">
                                            </div>
                                          <?php
                                            if(form_error('allotQuantity[szReqQuantity]')){?>
                                            <span class="help-block pull-left"><span><?php echo form_error('allotQuantity[szReqQuantity]');?></span>
                                            </span><?php }?> 
                                        </div>
                                </div> 
                           <div class="form-group <?php if(form_error('allotQuantity[szAddMoreQuantity]')){?>has-error<?php }?>">
                                    <label class="control-label col-md-4">Assign Quantity</label>
                                        <div class="col-md-4">
                                           <div class="input-group">
                                                <input id="szAddMoreQuantity" class="form-control input-large select2me " type="text" value="<?php echo set_value('allotQuantity[szAddMoreQuantity]'); ?>" placeholder="Assign Quantity" onfocus="remove_formError(this.id,'true')" name="allotQuantity[szAddMoreQuantity]">
                                            </div>
                                          <?php
                                            if(form_error('allotQuantity[szAddMoreQuantity]')){?>
                                            <span class="help-block pull-left"><span><?php echo form_error('allotQuantity[szAddMoreQuantity]');?></span>
                                            </span><?php }?> 
                                        </div>
                                </div> 
                </div>
                      </form>
                         
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                    
                    <button type="button" onclick="allotQuantityConfirmation('<?php echo $idProduct;?>'); return false;" class="btn green">Submit</button>
                </div>
            </div>
        </div>
    </div>   
              <?php
           }
           else{
            $this->StockMgt_Model->updateProductStockQty($productQtyDetails,$idfranchisee,$idProduct,'3');
            $data['mode'] = '__ALLOT_QUANTITY_POPUP_CONFIRM__';
            $this->load->view('admin/admin_ajax_functions',$data);
           }
        } 
    }      
?>