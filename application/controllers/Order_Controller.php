<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Order_Controller extends CI_Controller
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
    function drugtestkit()
    {
        $is_user_login = is_user_login($this);
        // redirect to dashboard if already logged in
        if (!$is_user_login) {
            ob_end_clean();
            redirect(base_url('/admin/admin_login'));
            die;
        }
        $searchAry = $_POST['szSearchProdCode'];
        $config['base_url'] = __BASE_URL__ . "/order/drugtestkit/";
        $config['total_rows'] = count($this->Inventory_Model->viewDrugTestKitList($limit, $offset, $searchAry, 2));
        $config['per_page'] = __PAGINATION_RECORD_LIMIT__;
        $this->pagination->initialize($config);
        $idfranchisee = $_SESSION['drugsafe_user']['id'];
        $drugTestKitAray = $this->Inventory_Model->viewDrugTestKitList($config['per_page'], $this->uri->segment(3), $searchAry, 2);
        $drugTestKitListAray = $this->Inventory_Model->viewDrugTestKitList(false, false, false, 2);
        $count = $this->Admin_Model->getnotification();
        $data['drugTestKitAray'] = $drugTestKitAray;
        $data['szMetaTagTitle'] = " Drug Test Kit ";
        $data['is_user_login'] = $is_user_login;
        $data['pageName'] = "Inventory";
        $data['subpageName'] = "Drug_Test_Kit";
        $data['notification'] = $count;
        $data['data'] = $data;
        $data['arErrorMessages'] = $this->Admin_Model->arErrorMessages;
        $data['drugtestkitlist'] = $drugTestKitListAray;
        $this->load->view('layout/admin_header', $data);
        $this->load->view('order/orderDrugTestKit');
        $this->load->view('layout/admin_footer');
    }
    function marketingmaterial()
    {
        $is_user_login = is_user_login($this);
        // redirect to dashboard if already logged in
        if (!$is_user_login) {
            ob_end_clean();
            redirect(base_url('/admin/admin_login'));
            die;
        }
        $searchAry = $_POST['szSearchProdCode'];
        $config['base_url'] = __BASE_URL__ . "/order/marketingmaterial/";
        $config['total_rows'] = count($this->Inventory_Model->viewMarketingMaterialList($searchAry, $limit, $offset, 2));
        $config['per_page'] = __PAGINATION_RECORD_LIMIT__;
        $this->pagination->initialize($config);
        $idfranchisee = $_SESSION['drugsafe_user']['id'];
        $marketingMaterialAray = $this->Inventory_Model->viewMarketingMaterialList($searchAry, $config['per_page'], $this->uri->segment(3), 2);
        $marketingMaterialListAray = $this->Inventory_Model->viewMarketingMaterialList(false, false, false, 2);
        $count = $this->Admin_Model->getnotification();
        $data['marketingMaterialAray'] = $marketingMaterialAray;
        $data['szMetaTagTitle'] = "Marketing Material";
        $data['is_user_login'] = $is_user_login;
        $data['pageName'] = "Inventory";
        $data['subpageName'] = "Marketing_Material";
        $data['notification'] = $count;
        $data['arErrorMessages'] = $this->Admin_Model->arErrorMessages;
        $data['data'] = $data;
        $data['marketingMaterialListAray'] = $marketingMaterialListAray;
        $this->load->view('layout/admin_header', $data);
        $this->load->view('order/orderMarketingMaterial');
        $this->load->view('layout/admin_footer');
    }
    function uploadProfileImage()
    {
        $output_dir = __APP_PATH_PRODUCT_IMAGES__;
        $ret = array();
        $RandomNum = time();
        $ImageName = str_replace(' ', '-', strtolower($_FILES['myfile']['name']));
        $ImageType = $_FILES['myfile']['type']; //"image/png", image/jpeg etc.
        $ImageExt = substr($ImageName, strrpos($ImageName, '.'));
        $ImageExt = str_replace('.', '', $ImageExt);
        $ImageName = preg_replace("/\.[^.\s]{3,4}$/", "", $ImageName);
        if ($ImageName > 10) {
            $ImageName = substr($ImageName, 0, 10);
        }
        if (strlen($ImageName) > 20) {
            $ImageName = substr_replace($ImageName, '', 20);
        }
        $NewImageName = 'Drug_product_' . $ImageName . '-' . $RandomNum . '.' . $ImageExt;
        move_uploaded_file($_FILES["myfile"]["tmp_name"], $output_dir . '/' . $NewImageName);
//       	 	 echo $output_dir. $NewImageName;
        $randomNum = rand() . time();
        $ret['name'] = $NewImageName;
        $ret['rand_num'] = $randomNum;
        $ret['img_div'] = '<div id="photoDiv_' . $randomNum . '"><img class="" src="' . __BASE_USER_PRODUCT_IMAGES_URL__ . '/' . $NewImageName . '" width="60" height="60" alt="Product  Image" />
                                   <a href="javascript:void(0);" id="remove_btn_' . $randomNum . '" class="btn red-intense btn-sm" onclick="removeIncidentPhoto();">Remove</a>
                           </div>';
        echo json_encode($ret);
    }
    function consumables()
    {
        $is_user_login = is_user_login($this);
        // redirect to dashboard if already logged in
        if (!$is_user_login) {
            ob_end_clean();
            redirect(base_url('/admin/admin_login'));
            die;
        }
        $searchAry = $_POST['szSearchProdCode'];
        $config['base_url'] = __BASE_URL__ . "/order/consumables/";
        $config['total_rows'] = count($this->Inventory_Model->viewConsumablesList($limit, $offset, $searchAry, 3));
        $config['per_page'] = __PAGINATION_RECORD_LIMIT__;
        $this->pagination->initialize($config);
        $idfranchisee = $_SESSION['drugsafe_user']['id'];
        $consumablesAray = $this->Inventory_Model->viewConsumablesList($config['per_page'], $this->uri->segment(3), $searchAry, 3);
        $consumableslistAry = $this->Inventory_Model->viewConsumablesList(false, false, false, 3);
        $count = $this->Admin_Model->getnotification();
        $data['consumablesAray'] = $consumablesAray;
        $data['szMetaTagTitle'] = " Consumables";
        $data['is_user_login'] = $is_user_login;
        $data['pageName'] = "Inventory";
        $data['subpageName'] = "Consumables";
        $data['notification'] = $count;
        $data['data'] = $data;
        $data['consumableslist'] = $consumableslistAry;
        $this->load->view('layout/admin_header', $data);
        $this->load->view('order/orderConsumables');
        $this->load->view('layout/admin_footer');
    }
    function placeOrderData()
    {
        $idProduct = $this->input->post('idProduct');
        $quantity = $this->input->post('val');
        $flag = $this->input->post('flag');
        $this->session->set_userdata('flag', $flag);
        $MinQuantity = $this->Order_Model->getMinQtyOfProduct($idProduct);
        if ($quantity >= $MinQuantity['min_ord_qty']) {
            $this->Order_Model->InsertOrder($idProduct, $quantity);
            echo "SUCCESS||||";
            echo "placeOrderConfirmation";
        } else {
            echo "ERROR||||";
            echo "placeOrderErrorConfirmation||||".$MinQuantity['min_ord_qty'];
        }
    }
    public function placeOrder()
    {
        $flag = $this->session->userdata('flag');
        $data['mode'] = '__PLACE_ORDER_POPUP_CONFIRM__';
        $this->load->view('admin/admin_ajax_functions', $data);
    }
    public function placeOrderErrorConfirmation()
    {
        $qty = $this->input->post('qty');
        $flag = $this->session->userdata('flag');
        $data['mode'] = '__PLACE_ORDER_POPUP_ERROR_CONFIRM__';
        $data['qty'] = $qty;
        $data['prodname'] = $this->input->post('prodname');
        $this->load->view('admin/admin_ajax_functions', $data);
    }
    function orderList()
    {
        $is_user_login = is_user_login($this);
        // redirect to dashboard if already logged in
        if (!$is_user_login) {
            ob_end_clean();
            redirect(base_url('/admin/admin_login'));
            die;
        }
        $searchAry = $_POST['szSearchProdCode'];
        $config['base_url'] = __BASE_URL__ . "/order/orderList/";
        $config['total_rows'] = count($this->Order_Model->getOrdersList($limit, $offset, $searchAry));
        $config['per_page'] = __PAGINATION_RECORD_LIMIT__;
        $this->pagination->initialize($config);
        $idfranchisee = $_SESSION['drugsafe_user']['id'];
        $totalOrdersAray = $this->Order_Model->getOrdersList($config['per_page'], $this->uri->segment(3), $searchAry);
        $totalOrdersSearchAray = $this->Order_Model->getOrdersList();
        $count = $this->Admin_Model->getnotification();
        $data['totalOrdersSearchAray'] = $totalOrdersSearchAray;
        $data['totalOrdersAray'] = $totalOrdersAray;
        $data['szMetaTagTitle'] = " Order List";
        $data['is_user_login'] = $is_user_login;
        $data['pageName'] = "Orders";
        $data['notification'] = $count;
        $data['data'] = $data;
        $data['arErrorMessages'] = $this->Admin_Model->arErrorMessages;
        //$data['drugtestkitlist'] = $drugTestKitListAray;
        $this->load->view('layout/admin_header', $data);
        $this->load->view('order/cartOrderValuelist');
        $this->load->view('layout/admin_footer');
    }
    public function DeleteOrderAlert()
    {
        $data['mode'] = '__DELETE_ORDER_POPUP__';
        $data['idOrder'] = $this->input->post('idOrder');
        $this->load->view('admin/admin_ajax_functions', $data);
    }
    public function OrderDeleteConfirmation()
    {
        $data['mode'] = '__DELETE_ORDER_CONFIRM__';
        $data['idOrder'] = $this->input->post('idOrder');
        $this->Order_Model->deleteOrder($data['idOrder']);
        $this->load->view('admin/admin_ajax_functions', $data);
    }
    public function updateCartData()
    {
        $is_user_login = is_user_login($this);
        // redirect to dashboard if already logged in
        if (!$is_user_login) {
            ob_end_clean();
            redirect(base_url('/admin/admin_login'));
            die;
        }
        $count = $_POST['count'];
        for ($i = 1; $i <= $count; $i++) {
            $quantity = $_POST['order_quantity' . $i];
            $orderId = $_POST['order_id' . $i];
            $orderUpdate = $this->Order_Model->updateOrder($quantity, $orderId);
        } 
        if ($orderUpdate) {
            $szMessage['type'] = "success";
            $szMessage['content'] = "<strong><h3>Your Cart has been successfully updated.</h3></strong> ";
            $this->session->set_userdata('drugsafe_user_message', $szMessage);
            ob_end_clean();
            redirect(base_url('/order/orderList'));
        }
    }
    function checkOutOrderData()
    {
        $idfranchisee = $this->input->post('idfranchisee');
        $this->session->set_userdata('idfranchisee', $idfranchisee);
       if($idfranchisee)
       {
            echo "SUCCESS||||";
            echo "checkOutOrder";
        } else {
            echo "ERROR||||";
            echo "placeOrderErrorConfirmation";
        }
    }
    public function checkOutOrder()
    {
        $is_user_login = is_user_login($this);
        // redirect to dashboard if already logged in
        if (!$is_user_login) {
            ob_end_clean();
            redirect(base_url('/admin/admin_login'));
            die;
        }
        $this->session->unset_userdata('orderid');
        $franchiseeid = $this->session->userdata('idfranchisee');
        $totalOrdersAray = $this->Order_Model->getOrdersListByFranchisee($franchiseeid);
      
        $TotalPrice = 0;
        foreach ($totalOrdersAray as $totalOrdersData) {
            $productDataArr = $this->Inventory_Model->getProductDetailsById($totalOrdersData['productid']);
            $price = ($totalOrdersData['quantity']) * ($productDataArr['szProductCost']);
            $TotalPrice += $price;
        }
        if ($idorder = $this->Order_Model->InsertOrderSuccess($totalOrdersAray['0']['franchiseeid'], $TotalPrice)) {
            foreach ($totalOrdersAray as $totalOrdersData) {
                $queryInsert = $this->Order_Model->InsertOrderDetails($totalOrdersData, $idorder);
            }
            if ($queryInsert) {
                $sendEmailForOrderAray =$this->Order_Model->sendOrderEmail();
                if($sendEmailForOrderAray){
                $szMessage['type'] = "success";
                $szMessage['content'] = "<strong><h3>Your Order has been successfully placed.</h3></strong> ";
                $this->session->set_userdata('drugsafe_user_message', $szMessage);
                ob_end_clean();
                $this->session->unset_userdata('idfranchisee');
                redirect(base_url('/order/ordersuccess'));
                }
            }
        }
    }
    public function ordersuccess()
    {
        $count = $this->Admin_Model->getnotification();
        $is_user_login = is_user_login($this);
        // redirect to dashboard if already logged in
        if (!$is_user_login) {
            ob_end_clean();
            redirect(base_url('/admin/admin_login'));
            die;
        }
        $orderid = $this->session->userdata('orderid');
        $totalOrdersDetailsAray = $this->Order_Model->getOrderDetailsByOrderId($orderid);
        $data['totalOrdersDetailsAray'] = $totalOrdersDetailsAray;
        $data['orderid'] = $orderid;
        $data['szMetaTagTitle'] = "Order Details";
        $data['is_user_login'] = $is_user_login;
        $data['pageName'] = "Orders";
        $data['notification'] = $count;
        $data['data'] = $data;
        $data['arErrorMessages'] = $this->Admin_Model->arErrorMessages;
        //$data['drugtestkitlist'] = $drugTestKitListAray;
        $this->load->view('layout/admin_header', $data);
        $this->load->view('order/successOrder');
        $this->load->view('layout/admin_footer');
    }
    public function view_order_list()
    {
        $count = $this->Admin_Model->getnotification();
        $is_user_login = is_user_login($this);
        // redirect to dashboard if already logged in
        if (!$is_user_login) {
            ob_end_clean();
            redirect(base_url('/admin/admin_login'));
            die;
        }
        $searchAry = $_POST;
        $validOrdersDetailsAray = $this->Order_Model->getallValidOrderDetails($searchAry);
        $validOrdersDetailsSearchAray = $this->Order_Model->getallValidOrderDetails();
        $allFrDetailsSearchAray = $this->Order_Model->getallValidOrderFrId();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('szSearch4', 'Start Order date ', 'required');
        $this->form_validation->set_rules('szSearch5', 'End Order date', 'required');
        $this->form_validation->set_message('required', '{field} is required.');
        if ($this->form_validation->run() == FALSE) {
            $data['validOrdersDetailsSearchAray'] = $validOrdersDetailsSearchAray;
            $data['allFrDetailsSearchAray'] = $allFrDetailsSearchAray;
            $data['szMetaTagTitle'] = "Order Details";
            $data['is_user_login'] = $is_user_login;
            $data['pageName'] = "Orders";
            $data['subpageName'] = "View_Order_List";
            $data['notification'] = $count;
            $data['data'] = $data;
            $data['arErrorMessages'] = $this->Order_Model->arErrorMessages;
            //$data['drugtestkitlist'] = $drugTestKitListAray;
            $this->load->view('layout/admin_header', $data);
            $this->load->view('order/viewOrderDetails');
            $this->load->view('layout/admin_footer');
        } else {
            $data['validOrdersDetailsAray'] = $validOrdersDetailsAray;
            $data['validOrdersDetailsSearchAray'] = $validOrdersDetailsSearchAray;
            $data['allFrDetailsSearchAray'] = $allFrDetailsSearchAray;
            $data['szMetaTagTitle'] = "Order Details";
            $data['is_user_login'] = $is_user_login;
            $data['pageName'] = "Orders";
            $data['subpageName'] = "View_Order_List";
            $data['notification'] = $count;
            $data['data'] = $data;
            $data['arErrorMessages'] = $this->Order_Model->arErrorMessages;
            //$data['drugtestkitlist'] = $drugTestKitListAray;
            $this->load->view('layout/admin_header', $data);
            $this->load->view('order/viewOrderDetails');
            $this->load->view('layout/admin_footer');
        }
    }
    public function viewOrderData()
    {
        $data['mode'] = '__VIEW_ORDER_DETAILS_POPUP__';
        $data['idOrder'] = $this->input->post('idOrder');
        $data['flag'] = $this->input->post('flag');
        $this->load->view('admin/admin_ajax_functions', $data);
    }
    public function editOrderData()
    {
        $data['mode'] = '__EDIT_ORDER_DETAILS_POPUP__';
        $data['idOrder'] = $this->input->post('idOrder');
        $data['flag'] = $this->input->post('flag');
        $this->load->view('admin/admin_ajax_functions', $data);
    }
    public function cancelOrderConfirmation()
    {    $searchAry['szSearch1'] = $this->input->post('frName');
         $searchAry['szSearch4'] = $this->input->post('startDate');
         $searchAry['szSearch5'] = $this->input->post('endDate');
         $searchAry['szSearch2'] = $this->input->post('orderNo');
         $data['mode'] = '__CANCEL_ORDER_CONFIRM_DETAILS_POPUP__';
         $data['idOrder'] = $this->input->post('idOrder'); 
       if($this->Order_Model->updateOrderByOrderId($data['idOrder'], 3)){
        
        $count = $this->Admin_Model->getnotification();
        $validOrdersDetailsAray = $this->Order_Model->getallValidOrderDetails($searchAry);
        $validOrdersDetailsSearchAray = $this->Order_Model->getallValidOrderDetails();
        $allFrDetailsSearchAray = $this->Order_Model->getallValidOrderFrId();
        
            $data['validOrdersDetailsAray'] = $validOrdersDetailsAray;
            $data['validOrdersDetailsSearchAray'] = $validOrdersDetailsSearchAray;
            $data['allFrDetailsSearchAray'] = $allFrDetailsSearchAray;
            $data['szMetaTagTitle'] = "Order Details";
            $data['is_user_login'] = $is_user_login;
            $data['pageName'] = "Orders";
            $data['subpageName'] = "View_Order_List";
            $data['notification'] = $count;
            $data['data'] = $data;
            $data['arErrorMessages'] = $this->Order_Model->arErrorMessages;
          
        $this->load->view('admin/admin_ajax_functions', $data);
       }  
    }
    public function deliverOrderConfirmation()
    {
        $data['mode'] = '__DELIVER_ORDER_CONFIRM_DETAILS_POPUP__';
        $data['idOrder'] = $this->input->post('idOrder');
        $this->Order_Model->updateOrderByOrderId($data['idOrder'], 2);
        $this->load->view('admin/admin_ajax_functions', $data);
    }
    function view_order_details()
    {
        $idOrder = $this->input->post('idOrder');
         $flag = $this->input->post('flag');
         $this->session->set_userdata('flag', $flag);
        $this->session->set_userdata('idOrder', $idOrder);
        echo "SUCCESS||||";
        if($flag==1){
         echo "pdf_dispatch_order_details";   
        }
        elseif($flag==3){
         echo "pdforderdetails";   
        }
        else{
         echo "pdf_order_details";   
        }
        
    }
    public function pdf_dispatch_order_details()
    {
       ob_start();
        $this->load->library('Pdf');
        $pdf = new Pdf('L', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetTitle('Drug-safe Order Details');
        $pdf->SetAuthor('Drug-safe');
        $pdf->SetSubject('Order Details Report PDF');
        $pdf->SetMargins(PDF_MARGIN_LEFT - 10, PDF_MARGIN_TOP - 18, PDF_MARGIN_RIGHT - 10);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->SetDisplayMode('real', 'default');
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetFont('times', '', 12);
        $pdf->AddPage('L');
        //$pdf->writeCell();
        $idOrder = $this->session->userdata('idOrder');
        $flag = $this->session->userdata('flag');
        $OrdersDetailsAray = $this->Order_Model->getOrderByOrderId($idOrder);
     
        $franchiseeDetArr1 = $this->Admin_Model->getAdminDetailsByEmailOrId('', $OrdersDetailsAray['franchiseeid']);
        
        if ($OrdersDetailsAray['status'] == 2) {
            $status = 'Dispatched';
        }
        
     $orderVal =     date('d M Y',strtotime($OrdersDetailsAray['createdon'])) . ' at '.date('h:i A',strtotime($OrdersDetailsAray['createdon']));
     $dispatchVal =     date('d M Y',strtotime($OrdersDetailsAray['dispatchedon'])) . ' at '.date('h:i A',strtotime($OrdersDetailsAray['dispatchedon']));
      $cancelVal =     date('d M Y',strtotime($OrdersDetailsAray['canceledon'])) . ' at '.date('h:i A',strtotime($OrdersDetailsAray['canceledon']));
        $dispatchDatesArr = $this->Order_Model->getTotalOrderDispatchDates($idOrder); 
      $freightpriceval = number_format($OrdersDetailsAray['freightprice'], 2, '.', '');
        $totalFreightPrice = number_format($freightpriceval, 2, '.', ',');
      $html = '<div class="wraper">
        <table cellpadding="5px">
       
    <tr>
        <td rowspan="4" align="left"><a style="text-align:left;  margin-bottom:15px;" href="' . __BASE_URL__ . '" ><img style="width:145px" src="' . __BASE_URL__ . '/images/logo.png" alt="logo" class="logo-default" /> </a></td>
    </tr>
</table>
<br />
<h2 style="text-align: center;">ORDER DETAILS </h2>
<br>
<h3 style="color:black">Order Info  </h3>
<br />
<table cellpadding="5px">
    <tr>
        <td width="50%" align="left" font-size="20"><b>Order # :</b> #0000' . $idOrder . '</td>
    </tr>
    <tr>
        <td width="50%" align="left"><b>Order Date & Time : </b> '.$orderVal.'</td>
    </tr>
     ';
 
     if($OrdersDetailsAray['status'] == 2) { 
   $html .= '      
   <tr>
        <td width="50%" align="left"><b>Dispatched Date & Time : </b> '. $dispatchVal .'</td>
    </tr> ';   
 }  
  $html .= '   <tr>
        <td width="50%" align="left"><b>Order Status : </b> '.$status.'</td>
    </tr> ';
 
   $html .= '  <tr>
        <td width="50%" align="left"><b>Freight Price: </b> $'.$totalFreightPrice.'</td>
    </tr>
     <tr>
        <td width="50%" align="left"><b>Total Price EXL GST: </b> $'.$OrdersDetailsAray['dispatched_price'].'</td>
    </tr>';
 
  if($_SESSION['drugsafe_user']['iRole']==1){
   $html .= '
     <tr>
        <td width="50%" align="left"><b>Franchisee : </b> '. $franchiseeDetArr1['szName'] .'</td>
    </tr>';
  }
$html .= '    
</table>
<h3 style="color:black">Dispatch Info </h3>
            <div>        
                <div class= "table-responsive" >
                    ';
	    $tbl = <<<EOD
$html
EOD;
	    $pdf->writeHTML($tbl, true, false, false, false, '');
        $totalDispatched = $this->Order_Model->getTotalOrderDispatchDates($idOrder);
        if (!empty($totalDispatched)) {
            $i = 0;
            foreach ($totalDispatched as $DispatchOrderDetData) {
                $html1 ='';
                $html1 .='<table border="1" cellpadding="5">
                <tr nobr="true" bgcolor="#4deecd"><td colspan="4"><h2><font color="black">Dispatched On: '.date('d/m/Y h:i:s a',strtotime($DispatchOrderDetData['dispatch_date'])).'</font></h2></td></tr>
                                    <tr  nobr="true">
                                        <th><b>Product Code</b> </th>
                                        <th> <b>Product Cost</b> </th>
                                        <th> <b>Dispatched Quantity</b> </th>
                                        <th><b>Total Price EXL GST</b> </th>
                                    </tr>';
                $DispatchedOrdDetArr = $this->Order_Model->getDispatchedOrderDetByDispatchDate($DispatchOrderDetData['dispatch_date']);
                if(!empty($DispatchedOrdDetArr)){
                    $totalAmount = 0.00;
                    foreach ($DispatchedOrdDetArr as $DispatchOrderDet){
                        $productDataArr = $this->Inventory_Model->getProductDetailsById($DispatchOrderDet['productid']);
                        $totalAmount += number_format(($DispatchOrderDet['dispatch_qty']) * ($productDataArr['szProductCost']), 2, '.', '');
                        $html1 .= '<tr  nobr="true">
                                            <td> ' . $productDataArr['szProductCode'] . ' </td>
                                            <td> $' . $productDataArr['szProductCost'] . '</td>
                                            <td> ' . $DispatchOrderDet['dispatch_qty'] . ' </td>
                                            <td> $' . number_format(($DispatchOrderDet['dispatch_qty']) * ($productDataArr['szProductCost']), 2, '.', ',') . ' </td>                                
                                        </tr>';
                        $i++;
                    }
                }
                $html1 .= '<tr  nobr="true"><td colspan="3"><b>Total</b></td><td><b>$'.number_format($totalAmount, 2, '.', ',').'</b></td></tr>
                </table>';
	            $tbl = <<<EOD
                $html1
EOD;
	            $pdf->writeHTML($tbl, true, false, false, false, '');
            }
        }
        $html2 = '</div>
                        </div>
                      
                        ';
	    $tbl = <<<EOD
                $html2
EOD;
		$pdf->writeHTML($tbl, true, false, true, false, '');
        error_reporting(E_ALL);
        ob_end_clean();
        $pdf->Output('view_order_details.pdf', 'I');
    }
   public function pdforderdetails()
    {
       ob_start();
        $this->load->library('Pdf');
        $pdf = new Pdf('L', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetTitle('Drug-safe Delivery Docket');
        $pdf->SetAuthor('Drug-safe');
        $pdf->SetSubject(' Delivery Docket PDF');
        $pdf->SetMargins(PDF_MARGIN_LEFT - 10, PDF_MARGIN_TOP - 18, PDF_MARGIN_RIGHT - 10);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->SetDisplayMode('real', 'default');
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetFont('times', '', 12);
        $pdf->AddPage('L');
        //$pdf->writeCell();
        $idOrder = $this->session->userdata('idOrder');
        $flag = $this->session->userdata('flag');
        $OrdersDetailsAray = $this->Order_Model->getOrderByOrderId($idOrder);
     
        $franchiseeDetArr1 = $this->Admin_Model->getAdminDetailsByEmailOrId('', $OrdersDetailsAray['franchiseeid']);
        if ($OrdersDetailsAray['status'] == 1) {
            $status = Ordered;
        }
        
        if ($OrdersDetailsAray['status'] == 3) {
            $status = Canceled;
        }
        
      $orderVal =     date('d M Y',strtotime($OrdersDetailsAray['createdon'])) . ' at '.date('h:i A',strtotime($OrdersDetailsAray['createdon']));
      $cancelVal =     date('d M Y',strtotime($OrdersDetailsAray['canceledon'])) . ' at '.date('h:i A',strtotime($OrdersDetailsAray['canceledon']));
 $html = '<div class="wraper">
        <table cellpadding="5px">
       
    <tr>
        <td rowspan="5" align="left"><a style="text-align:left;  margin-bottom:15px;" href="' . __BASE_URL__ . '" ><img style="width:145px" src="' . __BASE_URL__ . '/images/logo.png" alt="logo" class="logo-default" /> </a></td>
    </tr>
</table>
<br />
<h2 style="text-align: center;">Delivery Docket</h2>
<br>
<h3 style="color:black">Order Info  </h3>
<br />
<table cellpadding="5px">
    <tr>
        <td width="50%" align="left" font-size="20"><b>Order # :</b> #0000' . $idOrder . '</td>
    </tr>
    <tr>
        <td width="50%" align="left"><b>Order Date & Time : </b> '.$orderVal.'</td>
    </tr>
     ';
 
      if($OrdersDetailsAray['status'] == 3) { 
   $html .= '      
   <tr>
        <td width="50%" align="left"><b>Cancelled Date & Time : </b> '. $cancelVal .'</td>
    </tr> ';   
    } 
  
  if($_SESSION['drugsafe_user']['iRole']==1){
   $html .= '
     <tr>
        <td width="50%" align="left"><b>Franchisee : </b> '. $franchiseeDetArr1['szName'] .'</td>
    </tr>';
  }
$html .= '    
</table>
<br />
<h3 style="color:black">Products Info </h3>
            <div>       
                <div class= "table-responsive" >
                    ';
	    $tbl = <<<EOD
$html
EOD;
	    $pdf->writeHTML($tbl, true, false, false, false, '');
       $totalDispatched = $this->Order_Model->getTotalOrderDispatchDates($idOrder);
        if (!empty($totalDispatched)) {
            $i = 0;
            foreach ($totalDispatched as $totalDispatchedData) {
                $html1 ='';
                $html1 .='<table border="1" cellpadding="5">
                <tr nobr="true" bgcolor="#4deecd"><td colspan="5"><h2><font color="black">Dispatched On: '.date('d/m/Y h:i:s a',strtotime($totalDispatchedData['dispatch_date'])).'</font></h2></td></tr>
                                    <tr  nobr="true">
                                        <th><b>Product Code</b> </th>
                                        <th> <b>Product Description</b> </th>
                                        <th> <b>Ordered Quantity</b> </th>
                                        <th> <b>Dispatched</b> </th>
                                        <th> <b>Notes</b> </th>
                                    </tr>';
                $DispatchedOrdDetArr = $this->Order_Model->getDispatchedOrderDetByDispatchDate($totalDispatchedData['dispatch_date']);
                if(!empty($DispatchedOrdDetArr)){
                   
                    $i=0;
                    foreach ($DispatchedOrdDetArr as $DispatchOrderDet){ 
                        $totalQtyDispatchAray = $this->Order_Model->getTotalDispatchedByOrderDetailId($DispatchOrderDet['order_detail_id']);
                        $productDataArr = $this->Inventory_Model->getProductDetailsById($DispatchOrderDet['productid']);
//                        $previousBackOrder = $DispatchOrderDet['quantity']- $totalQtyDispatchAray['total_dispatched'];
//                      if($backorder == ''){
//                          $backorder = $DispatchOrderDet['quantity']- $totalQtyDispatchAray['total_dispatched'];
//                      }
//                      else{
//                        $backorder = $backorder + $DispatchOrderDet['dispatch_qty'];  
//                      }
//                         $backorder = $DispatchOrderDet['quantity']- $totalQtyDispatchAray['total_dispatched'];
                        $html1 .= '<tr nobr="true">
                                            <td> ' . $productDataArr['szProductCode'] . ' </td>
                                            <td> ' . $productDataArr['szProductDiscription'] . '</td>
                                            <td>'.   $DispatchOrderDet['quantity'].'</td>
                                            <td> ' . $DispatchOrderDet['dispatch_qty'] . ' </td>
                                            <td> ' . ($DispatchOrderDet['back_order'] >0?'Back Ordered - '.$DispatchOrderDet['back_order'] :'--') . ' </td> 
                                        </tr>';
                        $i++;
                    }
                }
                $html1 .= '
                </table>';
	            $tbl = <<<EOD
                $html1
EOD;
	            $pdf->writeHTML($tbl, true, false, false, false, '');
            }
        }
        $html2 = '</div>
                        </div>
                      
                        ';
	    $tbl = <<<EOD
                $html2
EOD;
	$pdf->writeHTML($tbl, true, false, true, false, '');
        error_reporting(E_ALL);
        ob_end_clean();
       $pdf->Output('view_delivery_docket.pdf', 'I');
    }
    public function pdf_order_details()
    {
       ob_start();
        $this->load->library('Pdf');
        $pdf = new Pdf('L', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetTitle('Drug-safe Order Details');
        $pdf->SetAuthor('Drug-safe');
        $pdf->SetSubject('Order Details Report PDF');
        $pdf->SetMargins(PDF_MARGIN_LEFT - 10, PDF_MARGIN_TOP - 18, PDF_MARGIN_RIGHT - 10);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->SetDisplayMode('real', 'default');
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetFont('times', '', 12);

        $pdf->AddPage('L');
   
         $idOrder = $this->session->userdata('idOrder');
         $OrdersDetailsAray = $this->Order_Model->getOrderByOrderId($idOrder);
         $franchiseeDetArr1 = $this->Admin_Model->getAdminDetailsByEmailOrId('', $OrdersDetailsAray['franchiseeid']);
          if ($OrdersDetailsAray['status'] == 1) {
            $status = Ordered;
        }
      
        if ($OrdersDetailsAray['status'] == 3) {
            $status = Canceled;
        }
       if($OrdersDetailsAray['canceledon']=="0000-00-00 00:00:00"){
         $cancelVal =   "N/A";  
       } 
       else{
         $cancelVal =     date('d M Y',strtotime($OrdersDetailsAray['canceledon'])) . ' at '.date('h:i A',strtotime($OrdersDetailsAray['canceledon']));   
       }
        if($OrdersDetailsAray['createdon']=="0000-00-00 00:00:00"){
         $orderVal =   "N/A";
       } 
       else{
         $orderVal =     date('d M Y',strtotime($OrdersDetailsAray['createdon'])) . ' at '.date('h:i A',strtotime($OrdersDetailsAray['createdon']));   
       }
    
    
 $totalOrdersDetailsAray = $this->Order_Model->getOrderDetailsByOrderId($idOrder);
 $html = '<div class="wraper">
        <table cellpadding="5px">
       
    <tr>
        <td rowspan="4" align="left"><a style="text-align:left;  margin-bottom:15px;" href="' . __BASE_URL__ . '" ><img style="width:145px" src="' . __BASE_URL__ . '/images/logo.png" alt="logo" class="logo-default" /> </a></td>
    </tr>

</table>
<br />
<h2 style="text-align: center;">ORDER DETAILS</h2>

<br>
<h3 style="color:black">Order Info  </h3>
<br />
<table cellpadding="5px">
    <tr>
        <td width="50%" align="left" font-size="20"><b>Order # :</b> #0000' . $idOrder . '</td>
    </tr>
    <tr>
        <td width="50%" align="left"><b>Order Date & Time : </b> '.$orderVal.'</td>
    </tr>
     ';
  if($flag==1){
      if($OrdersDetailsAray['status'] == 3) { 
   $html .= '      
   <tr>
        <td width="50%" align="left"><b>Cancelled Date & Time : </b> '. $cancelVal .'</td>
    </tr> ';   
    } 
     if($OrdersDetailsAray['status'] == 2) { 
   $html .= '      
   <tr>
        <td width="50%" align="left"><b>Dispatched Date & Time : </b> '. $dispatchVal .'</td>
    </tr> ';   
 } } 
  $html .= '   <tr>
        <td width="50%" align="left"><b>Order Status : </b> '.$status.'</td>
    </tr> ';
   $html .= '  <tr>
        <td width="50%" align="left"><b>Total Price EXL GST : </b> $'.$OrdersDetailsAray['price'].'</td>
    </tr>';

  if($_SESSION['drugsafe_user']['iRole']==1){
   $html .= '
     <tr>
        <td width="50%" align="left"><b>Franchisee : </b> '. $franchiseeDetArr1['szName'] .'</td>
    </tr>';
  }
$html .= '    
</table>
<br />
<h3 style="color:black">Products Info </h3>
            <div>
         
                        <div class= "table-responsive" >
                            <table border="1" cellpadding="5">
                                    <tr>
                                        <th><b>Product Code</b> </th>
                                        <th> <b>Product Cost</b> </th>
                                        <th> <b>Quantity</b> </th>
                                        <th><b>Total Price</b> </th>
                                    </tr>';
        $totalOrdersDetailsAray = $this->Order_Model->getOrderDetailsByOrderId($idOrder);
        if ($totalOrdersDetailsAray) {
            $i = 0;
            foreach ($totalOrdersDetailsAray as $totalOrdersDetailsData) {
                $productDataArr = $this->Inventory_Model->getProductDetailsById($totalOrdersDetailsData['productid']);
                $html .= '<tr>
                                            <td> ' . $productDataArr['szProductCode'] . ' </td>
                                            <td> $' . $productDataArr['szProductCost'] . '</td>
                                            <td> ' . $totalOrdersDetailsData['quantity'] . ' </td>
                                            <td> $' . number_format(($totalOrdersDetailsData['quantity']) * ($productDataArr['szProductCost']), 2, '.', ',') . ' </td>
                                
                                        </tr>';
            }
        }
        $i++;
        $html .= '
                            </table>
                        </div>
                      
                        ';

        $pdf->writeHTML($html, true, false, true, false, '');

        error_reporting(E_ALL);
        $this->session->unset_userdata('idOrder');
        $this->session->unset_userdata('flag');

        ob_end_clean();
        $pdf->Output('view_order_details.pdf', 'I');
    }
    function View_excel_order_details_data()
        {
            $idOrder = $this->input->post('idOrder');
	        $flag = $this->input->post('flag');
	        $this->session->set_userdata('flag', $flag);
                $this->session->set_userdata('idOrder',$idOrder);
               
                
                echo "SUCCESS||||";
                if($flag==1){
                   echo "View_excel_dispatch_order_details";  
                }
                else{
                  echo "View_excel_order_details";   
                }
               
            
 
        }
    public function View_excel_dispatch_order_details()
    {
        $this->load->library('excel');
        $filename = 'Report';
        $title = 'Drug-safe Order Details';
        $file = $filename . '-' . $title ; //save our workbook as this file name
        $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->setTitle($filename);
         $idOrder = $this->session->userdata('idOrder');
         $OrdersDetailsAray = $this->Order_Model->getOrderByOrderId($idOrder);
         $franchiseeDetArr1 = $this->Admin_Model->getAdminDetailsByEmailOrId('', $OrdersDetailsAray['franchiseeid']);
          if ($OrdersDetailsAray['status'] == 1) {
            $status = 'Ordered';
        }
        if ($OrdersDetailsAray['status'] == 2) {
            $status = 'Dispatched';
        }
        if ($OrdersDetailsAray['status'] == 3) {
            $status = 'Canceled';
        }
        if ($OrdersDetailsAray['status'] == 4) {
            $status = 'Pending';
        }
       if($OrdersDetailsAray['createdon']=="0000-00-00 00:00:00"){
         $dispatchVal =   "N/A";  
       } 
       else{
         $dispatchVal =     date('d M Y',strtotime($OrdersDetailsAray['dispatchedon'])) . ' at '.date('h:i A',strtotime($OrdersDetailsAray['dispatchedon']));   
       }
        if($OrdersDetailsAray['createdon']=="0000-00-00 00:00:00"){
         $orderVal =   "N/A";
       } 
       else{
         $orderVal =     date('d M Y',strtotime($OrdersDetailsAray['createdon'])) . ' at '.date('h:i A',strtotime($OrdersDetailsAray['createdon']));   
       }
     $cancelVal =     date('d M Y',strtotime($OrdersDetailsAray['canceledon'])) . ' at '.date('h:i A',strtotime($OrdersDetailsAray['canceledon']));
    
     $totalOrdersDetailsAray = $this->Order_Model->getOrderDetailsByOrderId($idOrder);
        $dispatchDatesArr = $this->Order_Model->getTotalOrderDispatchDates($idOrder);
        $freightpriceval = number_format($OrdersDetailsAray['freightprice'], 2, '.', '');
        $totalFreightPrice = number_format($freightpriceval, 2, '.', ',');
        $this->excel->getActiveSheet()->setTitle($filename);
        $this->excel->getActiveSheet()->setCellValue('C1', 'ORDER DETAILS');
        $this->excel->getActiveSheet()->getStyle('C1')->getFont()->setSize(13);
        $this->excel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
     
        $this->excel->getActiveSheet()->setTitle($filename);
        $this->excel->getActiveSheet()->setCellValue('A2', 'Order Info ');
        $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(13);
        $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $this->excel->getActiveSheet()->setTitle($filename);
        $this->excel->getActiveSheet()->setCellValue('A11', 'Products Info ');
        $this->excel->getActiveSheet()->getStyle('A11')->getFont()->setSize(13);
        $this->excel->getActiveSheet()->getStyle('A11')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A11')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        
         $this->excel->getActiveSheet()->setCellValue('A4','Order # :');
         $this->excel->getActiveSheet()->setCellValue('A5','Order Date & Time :');
         if($OrdersDetailsAray['status'] ==3){
         $this->excel->getActiveSheet()->setCellValue('A6','Canceled Date & Time :');
         $this->excel->getActiveSheet()->setCellValue('A7','Order Status  :');
         $this->excel->getActiveSheet()->setCellValue('A8','Freight Price:');
         $this->excel->getActiveSheet()->setCellValue('A9','Total Price EXL GST:');
          if($_SESSION['drugsafe_user']['iRole']==1){
         $this->excel->getActiveSheet()->setCellValue('A10','Franchisee :');
         }
         }
          elseif($OrdersDetailsAray['status'] ==2){
           $this->excel->getActiveSheet()->setCellValue('A6','Dispatched Date & Time :');
           $this->excel->getActiveSheet()->setCellValue('A7','Order Status  :');
           $this->excel->getActiveSheet()->setCellValue('A8','Freight Price:');
           $this->excel->getActiveSheet()->setCellValue('A9','Total Price EXL GST:');
            if($_SESSION['drugsafe_user']['iRole']==1){
           $this->excel->getActiveSheet()->setCellValue('A10','Franchisee :');
            }
         }
         else{
           $this->excel->getActiveSheet()->setCellValue('A6','Order Status  :');
           $this->excel->getActiveSheet()->setCellValue('A7','Freight Price:');
           $this->excel->getActiveSheet()->setCellValue('A8','Total Price EXL GST:');
           if($_SESSION['drugsafe_user']['iRole']==1){
           $this->excel->getActiveSheet()->setCellValue('A9','Franchisee :');
            }
         }
        
         $this->excel->getActiveSheet()->setCellValue('B4','#0000' .$idOrder);
         $this->excel->getActiveSheet()->setCellValue('B5',$orderVal);
          if($OrdersDetailsAray['status'] ==3){
         $this->excel->getActiveSheet()->setCellValue('B6',$cancelVal);
         $this->excel->getActiveSheet()->setCellValue('B7',$status);
              $this->excel->getActiveSheet()->setCellValue('B8','$'.$totalFreightPrice);
         $this->excel->getActiveSheet()->setCellValue('B9','$'.($OrdersDetailsAray['dispatched_price']));
          if($_SESSION['drugsafe_user']['iRole']==1){
         $this->excel->getActiveSheet()->setCellValue('B10',$franchiseeDetArr1['szName']);
          }
         }
          elseif($OrdersDetailsAray['status'] ==2){
           $this->excel->getActiveSheet()->setCellValue('B6',$dispatchVal);
           $this->excel->getActiveSheet()->setCellValue('B7',$status);
              $this->excel->getActiveSheet()->setCellValue('B8','$'.$totalFreightPrice);
         $this->excel->getActiveSheet()->setCellValue('B9','$'.($OrdersDetailsAray['dispatched_price']));
          if($_SESSION['drugsafe_user']['iRole']==1){
         $this->excel->getActiveSheet()->setCellValue('B10',$franchiseeDetArr1['szName']);
          }
         }
         else{
         $this->excel->getActiveSheet()->setCellValue('B6',$status);
             $this->excel->getActiveSheet()->setCellValue('B7','$'.$totalFreightPrice);
         $this->excel->getActiveSheet()->setCellValue('B8','$'.($OrdersDetailsAray['dispatched_price']));
          if($_SESSION['drugsafe_user']['iRole']==1){
         $this->excel->getActiveSheet()->setCellValue('B9',$franchiseeDetArr1['szName']);
          }
         }
        $totalDispatched = $this->Order_Model->getTotalOrderDispatchDates($idOrder);
if (!empty($totalDispatched)) {
    $i = 12;
    foreach ($totalDispatched as $DispatchOrderDetData) {
        $this->excel->getActiveSheet()->mergeCells('A'.($i+1).':D'.($i+1));
        $this->excel->getActiveSheet()->setCellValue('A'.($i+1), 'Dispatched On: '.date('d/m/Y h:i:s a',strtotime($DispatchOrderDetData['dispatch_date'])));
        $this->excel->getActiveSheet()->getStyle('A'.($i+1))->getFont()->setSize(13);
        $this->excel->getActiveSheet()->getStyle('A'.($i+1))->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A'.($i+1))->getAlignment()->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('A'.($i+2), 'Product Code');
        $this->excel->getActiveSheet()->getStyle('A'.($i+2))->getFont()->setSize(13);
        $this->excel->getActiveSheet()->getStyle('A'.($i+2))->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A'.($i+2))->getAlignment()->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('B'.($i+2), 'Product Cost');
        $this->excel->getActiveSheet()->getStyle('B'.($i+2))->getFont()->setSize(13);
        $this->excel->getActiveSheet()->getStyle('B'.($i+2))->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('B'.($i+2))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('C'.($i+2), 'Dispatched Quantity');
        $this->excel->getActiveSheet()->getStyle('C'.($i+2))->getFont()->setSize(13);
        $this->excel->getActiveSheet()->getStyle('C'.($i+2))->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('C'.($i+2))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('D'.($i+2), 'Total Price EXL GST');
        $this->excel->getActiveSheet()->getStyle('D'.($i+2))->getFont()->setSize(13);
        $this->excel->getActiveSheet()->getStyle('D'.($i+2))->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('D'.($i+2))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $DispatchedOrdDetArr = $this->Order_Model->getDispatchedOrderDetByDispatchDate($DispatchOrderDetData['dispatch_date']);
        if(!empty($DispatchedOrdDetArr)){
            $j = $i;
            $totalAmount = 0.00;
            foreach ($DispatchedOrdDetArr as $DispatchOrderDet){
                $productDataArr = $this->Inventory_Model->getProductDetailsById($DispatchOrderDet['productid']);
                $totalAmount += number_format(($DispatchOrderDet['dispatch_qty']) * ($productDataArr['szProductCost']), 2, '.', '');
                $this->excel->getActiveSheet()->setCellValue('A'.($j+3),$productDataArr['szProductCode']);
                $this->excel->getActiveSheet()->setCellValue('B'.($j+3),'$'.$productDataArr['szProductCost']);
                $this->excel->getActiveSheet()->setCellValue('C'.($j+3),$DispatchOrderDet['dispatch_qty']);
                $this->excel->getActiveSheet()->getStyle('C'.($j+3))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $this->excel->getActiveSheet()->setCellValue('D'.($j+3),'$'.number_format(($DispatchOrderDet['dispatch_qty']) * ($productDataArr['szProductCost']), 2, '.', ','));
                $j++;
            }
            $i = $j+3;
        }
        $this->excel->getActiveSheet()->mergeCells('A'.($i).':C'.($i));
        $this->excel->getActiveSheet()->setCellValue('A'.($i), 'Total');
        $this->excel->getActiveSheet()->getStyle('A'.($i))->getFont()->setSize(13);
        $this->excel->getActiveSheet()->getStyle('A'.($i))->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A'.($i))->getAlignment()->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('D'.($i),'$'.number_format($totalAmount, 2, '.', ',') );
        $this->excel->getActiveSheet()->getStyle('D'.($i))->getFont()->setSize(13);
        $this->excel->getActiveSheet()->getStyle('D'.($i))->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('D'.($i))->getAlignment()->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $i++;
    }
    $this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(TRUE);
    $this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(TRUE);
    $this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(TRUE);
    $this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(TRUE);
    $this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(TRUE);
}
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="' . $file . '"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
//if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        $this->session->unset_userdata('productCode');
        $this->session->unset_userdata('franchiseeName');
//force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
    }
    public function View_excel_order_details()
    {
        $this->load->library('excel');
        $filename = 'Report';
        $title = 'Drug-safe Order Details';
        $file = $filename . '-' . $title ; //save our workbook as this file name
        $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->setTitle($filename);
        $this->excel->getActiveSheet()->setCellValue('A13', 'Product Code');
        $this->excel->getActiveSheet()->getStyle('A13')->getFont()->setSize(13);
        $this->excel->getActiveSheet()->getStyle('A13')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A13')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('B13', 'Product Cost');
        $this->excel->getActiveSheet()->getStyle('B13')->getFont()->setSize(13);
        $this->excel->getActiveSheet()->getStyle('B13')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('B13')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('C13', 'Quantity');
        $this->excel->getActiveSheet()->getStyle('C13')->getFont()->setSize(13);
        $this->excel->getActiveSheet()->getStyle('C13')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('C13')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('D13', 'Total Price EXL GST');
        $this->excel->getActiveSheet()->getStyle('D13')->getFont()->setSize(13);
        $this->excel->getActiveSheet()->getStyle('D13')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('D13')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
         $idOrder = $this->session->userdata('idOrder');
         $OrdersDetailsAray = $this->Order_Model->getOrderByOrderId($idOrder);
         $franchiseeDetArr1 = $this->Admin_Model->getAdminDetailsByEmailOrId('', $OrdersDetailsAray['franchiseeid']);
          if ($OrdersDetailsAray['status'] == 1) {
            $status = Ordered;
        }
      
        if ($OrdersDetailsAray['status'] == 3) {
            $status = Canceled;
        }
       if($OrdersDetailsAray['canceledon']=="0000-00-00 00:00:00"){
         $cancelVal =   "N/A";  
       } 
       else{
         $cancelVal =     date('d M Y',strtotime($OrdersDetailsAray['canceledon'])) . ' at '.date('h:i A',strtotime($OrdersDetailsAray['canceledon']));   
       }
        if($OrdersDetailsAray['createdon']=="0000-00-00 00:00:00"){
         $orderVal =   "N/A";
       } 
       else{
         $orderVal =     date('d M Y',strtotime($OrdersDetailsAray['createdon'])) . ' at '.date('h:i A',strtotime($OrdersDetailsAray['createdon']));   
       }
    
    
     $totalOrdersDetailsAray = $this->Order_Model->getOrderDetailsByOrderId($idOrder);
       
        $this->excel->getActiveSheet()->setTitle($filename);
        $this->excel->getActiveSheet()->setCellValue('C1', 'ORDER DETAILS');
        $this->excel->getActiveSheet()->getStyle('C1')->getFont()->setSize(13);
        $this->excel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
     
        $this->excel->getActiveSheet()->setTitle($filename);
        $this->excel->getActiveSheet()->setCellValue('A2', 'Order Info ');
        $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(13);
        $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $this->excel->getActiveSheet()->setTitle($filename);
        $this->excel->getActiveSheet()->setCellValue('A11', 'Products Info ');
        $this->excel->getActiveSheet()->getStyle('A11')->getFont()->setSize(13);
        $this->excel->getActiveSheet()->getStyle('A11')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A11')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        
         $this->excel->getActiveSheet()->setCellValue('A4','Order # :');
         $this->excel->getActiveSheet()->setCellValue('A5','Order Date & Time :');
         if($OrdersDetailsAray['status'] ==3){
          $this->excel->getActiveSheet()->setCellValue('A6','Canceled Date & Time :');
          $this->excel->getActiveSheet()->setCellValue('A7','Order Status  :');
         $this->excel->getActiveSheet()->setCellValue('A8','Total Price EXL GST :');
         if($_SESSION['drugsafe_user']['iRole']==1){
         $this->excel->getActiveSheet()->setCellValue('A9','Franchisee :');
         }
         }
         else{
           $this->excel->getActiveSheet()->setCellValue('A6','Order Status  :');
           $this->excel->getActiveSheet()->setCellValue('A7','Total Price EXL GST :');
            if($_SESSION['drugsafe_user']['iRole']==1){
           $this->excel->getActiveSheet()->setCellValue('A8','Franchisee :'); 
            }
         }
        
         
         
         $this->excel->getActiveSheet()->setCellValue('B4','#0000' .$idOrder);
         $this->excel->getActiveSheet()->setCellValue('B5',$orderVal);
          if($OrdersDetailsAray['status'] ==3){
         $this->excel->getActiveSheet()->setCellValue('B6',$cancelVal);
         $this->excel->getActiveSheet()->setCellValue('B7',$status);
         $this->excel->getActiveSheet()->setCellValue('B8','$'.$OrdersDetailsAray['price']);
          if($_SESSION['drugsafe_user']['iRole']==1){
         $this->excel->getActiveSheet()->setCellValue('B9',$franchiseeDetArr1['szName']);
          }
         }
         
         else{
         $this->excel->getActiveSheet()->setCellValue('B6',$status);
         $this->excel->getActiveSheet()->setCellValue('B7','$'.$OrdersDetailsAray['price']);
          if($_SESSION['drugsafe_user']['iRole']==1){
         $this->excel->getActiveSheet()->setCellValue('B8',$franchiseeDetArr1['szName']);
          }
         }
         
      if ($totalOrdersDetailsAray) {
            $i = 14 ;
            foreach ($totalOrdersDetailsAray as $item) {
                $productDataArr = $this->Inventory_Model->getProductDetailsById($item['productid']);
         $price =   number_format(($item['quantity']) * ($productDataArr['szProductCost']), 2, '.', ',');
                
                $this->excel->getActiveSheet()->setCellValue('A'.$i, $productDataArr['szProductCode']);
                $this->excel->getActiveSheet()->setCellValue('B'.$i, '$'.$productDataArr['szProductCost']);
                $this->excel->getActiveSheet()->setCellValue('C'.$i, $item['quantity']);
                $this->excel->getActiveSheet()->setCellValue('D'.$i, '$'.$price);
                $this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(TRUE);
                $this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(TRUE);
                $this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(TRUE);
                $this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(TRUE);
                $i++;
            }
        }
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="' . $file . '"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
//if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        $this->session->unset_userdata('productCode');
        $this->session->unset_userdata('franchiseeName');
//force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
    }
    public function dispatchProductData()
    {
        $is_user_login = is_user_login($this);
        // redirect to dashboard if already logged in
        if (!$is_user_login) {
            ob_end_clean();
            redirect(base_url('/admin/admin_login'));
            die;
        }
        if ($_POST['pending'] == 1) {
            $count = $_POST['count'];
            $franchiseeId = $_POST['franchiseeId'];
            $total_price = 0;
            for ($i = 1; $i <= $count; $i++) {
                $quantity = $_POST['order_quantity' . $i];
                $total_price += $_POST['total_price' . $i];
                $orderId = $_POST['order_id' . $i];
                $productId = $_POST['product_id' . $i];
                $productDataArr = $this->Inventory_Model->getProductDetailsById($productId);
                $szAvailableQuantity = $productDataArr['szAvailableQuantity'];
                if ($szAvailableQuantity < $quantity) {
                    $szMessage['type'] = "error";
                    $szMessage['content'] = "<strong><h3>Dispatch Quantity must be less than available quantity.</h3></strong> ";
                    $this->session->set_userdata('drugsafe_user_message', $szMessage);
                    ob_end_clean();
                    redirect(base_url('/order/view_order_list'));
                } else {
                    $orderPending = $this->Order_Model->pendingOrder($quantity, $orderId, $productId, $szAvailableQuantity, $franchiseeId);
                }
            }
            $totalPrice = $_POST['total'];
            if ($this->Order_Model->orderPendingUpdate($_POST['order_id1'], $totalPrice)) {
                $szMessage['type'] = "success";
                $szMessage['content'] = "<strong><h3>Your Order has been in pending state.</h3></strong> ";
                $this->session->set_userdata('drugsafe_user_message', $szMessage);
                ob_end_clean();
                redirect(base_url('/order/view_order_list'));
            }
            $szMessage['type'] = "error";
            $szMessage['content'] = "<strong><h3>Dispatch Quantity field can't be empty.</h3></strong> ";
            $this->session->set_userdata('drugsafe_user_message', $szMessage);
            ob_end_clean();
            redirect(base_url('/order/view_order_list'));
        } else {
            $count = $_POST['count'];
            $franchiseeId = $_POST['franchiseeId'];
            $total_price = 0;
            $countOrderDispatch = 0;
            for ($i = 1; $i <= $count; $i++) {
                $quantity = $_POST['order_quantity' . $i];
                $total_price += $_POST['total_price' . $i];
                $orderId = $_POST['order_id' . $i];
                $productId = $_POST['product_id' . $i];
                $productDataArr = $this->Inventory_Model->getProductDetailsById($productId);
                $szAvailableQuantity = $productDataArr['szAvailableQuantity'];
                if ($szAvailableQuantity < $quantity) {
                    $szMessage['type'] = "error";
                    $szMessage['content'] = "<strong><h3>Dispatch Quantity must be less than available quantity.</h3></strong> ";
                    $this->session->set_userdata('drugsafe_user_message', $szMessage);
                    ob_end_clean();
                    redirect(base_url('/order/view_order_list'));
                } else {
                    if (!empty($quantity)) {
                        $orderDispatch = $this->Order_Model->dispatchOrder($quantity, $orderId, $productId, $szAvailableQuantity, $franchiseeId);
                        $countOrderDispatch = count($orderDispatch);
                    }
                }
            }
            if ($countOrderDispatch == $count) {
                $totalPrice = $_POST['total'];
                if ($this->Order_Model->orderFinalUpdate($_POST['order_id1'], $totalPrice)) {
                    $szMessage['type'] = "success";
                    $szMessage['content'] = "<strong><h3>Your Order has been successfully dispatched.</h3></strong> ";
                    $this->session->set_userdata('drugsafe_user_message', $szMessage);
                    ob_end_clean();
                    redirect(base_url('/order/view_order_list'));
                }
            } else {
                $szMessage['type'] = "error";
                $szMessage['content'] = "<strong><h3>Dispatch Quantity field can't be empty.</h3></strong> ";
                $this->session->set_userdata('drugsafe_user_message', $szMessage);
                ob_end_clean();
                redirect(base_url('/order/view_order_list'));
            }
        }
    }
    function dispatchsingleprod(){
       
        $ordid = $_POST['ordid'];
        $prodid = $_POST['prodid'];
        $qty = $_POST['qty'];
        $RemainingQty = $_POST['RemainingQty'];
        $freightPrice = $_POST['freightPrice'];
        $dispStat = $this->Order_Model->dispatchsingleprod($ordid,$prodid,$qty,$freightPrice,$RemainingQty);
        if($dispStat){
            $updatedRemainingQty = $qty-$RemainingQty;
            if($updatedRemainingQty == '0'){
                if($this->Order_Model->AllDispatched($ordid,$prodid)){
                    echo 'SUCCESS';
                }else{
                    echo 'FAIL';
                }
            }else{
                echo 'SUCCESS';
            }
        }else{
            echo 'FAIL';
        }
    }
    function dispatchfinal(){
        $ordid = $_POST['ordid'];
        $price = $_POST['price'];
        $freightPrice = $_POST['freightPrice'];
        $dispStat = $this->Order_Model->changesdispatchstatus($ordid,'2',$price,$freightPrice);
        if($dispStat){
            
         $searchAry['szSearch1'] = $this->input->post('frName');
         $searchAry['szSearch4'] = $this->input->post('startDate');
         $searchAry['szSearch5'] = $this->input->post('endDate');
         $searchAry['szSearch2'] = $this->input->post('orderNo');
            $count = $this->Admin_Model->getnotification();
            $validOrdersDetailsAray = $this->Order_Model->getallValidOrderDetails($searchAry);
            $validOrdersDetailsSearchAray = $this->Order_Model->getallValidOrderDetails();
            $allFrDetailsSearchAray = $this->Order_Model->getallValidOrderFrId();
        
            $data['validOrdersDetailsAray'] = $validOrdersDetailsAray;
            $data['validOrdersDetailsSearchAray'] = $validOrdersDetailsSearchAray;
            $data['allFrDetailsSearchAray'] = $allFrDetailsSearchAray;
            $data['szMetaTagTitle'] = "Order Details";
            $data['is_user_login'] = $is_user_login;
            $data['pageName'] = "Orders";
            $data['subpageName'] = "View_Order_List";
            $data['notification'] = $count;
            $data['data'] = $data;
            $data['arErrorMessages'] = $this->Order_Model->arErrorMessages;
          
            $data['mode'] = '__PRODUCT_DISPATCHED_SUCCESSFULLY__';
            $this->load->view('admin/admin_ajax_functions', $data);
            $this->Order_Model->xeroIntigration($ordid);
        }else{
            return false;
        }
    }
    function dispatchpending(){
        $ordid = $_POST['ordid'];
        $dispStat = $this->Order_Model->changesdispatchstatus($ordid,'4');
        if($dispStat){
            $data['mode'] = '__ORDER_STATUS_CHANGED__';
            $this->load->view('admin/admin_ajax_functions', $data);
        }else{
            return false;
        }
    }
    public function view_order_report()
    {
        $count = $this->Admin_Model->getnotification();
        $is_user_login = is_user_login($this);
        // redirect to dashboard if already logged in
        if (!$is_user_login) {
            ob_end_clean();
            redirect(base_url('/admin/admin_login'));
            die;
        }
        $searchAry = $_POST;
        $validOrdersDetailsAray = $this->Order_Model->getallValidOrderDetails($searchAry);
        $validOrdersDetailsSearchAray = $this->Order_Model->getallValidOrderDetails();
        $allFrDetailsSearchAray = $this->Order_Model->getallValidOrderFrId();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('szSearch4', 'Start Order date ', 'required');
        $this->form_validation->set_rules('szSearch5', 'End Order date', 'required');
        $this->form_validation->set_message('required', '{field} is required.');
        if ($this->form_validation->run() == FALSE) {
            $data['validOrdersDetailsSearchAray'] = $validOrdersDetailsSearchAray;
            $data['allFrDetailsSearchAray'] = $allFrDetailsSearchAray;
            $data['szMetaTagTitle'] = "Order Details Report";
            $data['is_user_login'] = $is_user_login;
            $data['pageName'] = "Reporting";
            $data['subpageName'] = "Orders_Report";
            $data['notification'] = $count;
            $data['data'] = $data;
            $data['arErrorMessages'] = $this->Order_Model->arErrorMessages;
            //$data['drugtestkitlist'] = $drugTestKitListAray;
            $this->load->view('layout/admin_header', $data);
            $this->load->view('order/viewOrderDetailsReport');
            $this->load->view('layout/admin_footer');
        } else {
            $data['validOrdersDetailsAray'] = $validOrdersDetailsAray;
            $data['validOrdersDetailsSearchAray'] = $validOrdersDetailsSearchAray;
            $data['allFrDetailsSearchAray'] = $allFrDetailsSearchAray;
            $data['szMetaTagTitle'] = "Order Details Report";
            $data['is_user_login'] = $is_user_login;
            $data['pageName'] = "Reporting";
            $data['subpageName'] = "Orders_Report";
            $data['notification'] = $count;
            $data['data'] = $data;
            $data['arErrorMessages'] = $this->Order_Model->arErrorMessages;
            //$data['drugtestkitlist'] = $drugTestKitListAray;
            $this->load->view('layout/admin_header', $data);
            $this->load->view('order/viewOrderDetailsReport');
            $this->load->view('layout/admin_footer');
        }
    }
    
   public function receiveOrderData()
    {
        $data['mode'] = '__RECEIVE_ORDER_DETAILS_POPUP__';
        $data['idOrder'] = $this->input->post('idOrder');
        $this->load->view('admin/admin_ajax_functions', $data);
    }  
	
    public function receiveordConfirmation()
    {
        $searchAry['szSearch1'] = $this->input->post('frName');
         $searchAry['szSearch4'] = $this->input->post('startDate');
         $searchAry['szSearch5'] = $this->input->post('endDate');
         $searchAry['szSearch2'] = $this->input->post('orderNo');
         
         $data['mode'] = '__RECEIVE_ORDER_CONFIRM_DETAILS_POPUP__';
         $data['idOrder'] = $this->input->post('idOrder');
         $data['orderdate'] = $this->input->post('orderdate');
         
         $totalOrdersDetailsAray = $this->Order_Model->getDispatchedOrderDetByDispatchDate($data['orderdate'],$data['idOrder']);
         $ordid ='';
         $prodid='';
         $qty='';
        foreach($totalOrdersDetailsAray as $totalOrdersDetailData){
        $ordid = $totalOrdersDetailData['orderid'];
        $prodid = $totalOrdersDetailData['productid'];
        $qty = $totalOrdersDetailData['dispatch_qty'];
        $dispatchProdId = $totalOrdersDetailData['id'];
        $this->Order_Model->adjustFranchisorInventory($prodid,$qty);
        $this->Order_Model->updateInventoryByOrderId($ordid,$prodid,$qty,$dispatchProdId);
        }
       
        $count = $this->Admin_Model->getnotification();
        $validOrdersDetailsAray = $this->Order_Model->getallValidOrderDetails($searchAry);
        $validOrdersDetailsSearchAray = $this->Order_Model->getallValidOrderDetails();
        $allFrDetailsSearchAray = $this->Order_Model->getallValidOrderFrId();
        
            $data['validOrdersDetailsAray'] = $validOrdersDetailsAray;
            $data['validOrdersDetailsSearchAray'] = $validOrdersDetailsSearchAray;
            $data['allFrDetailsSearchAray'] = $allFrDetailsSearchAray;
            $data['szMetaTagTitle'] = "Order Details";
            $data['is_user_login'] = $is_user_login;
            $data['pageName'] = "Orders";
            $data['subpageName'] = "View_Order_List";
            $data['notification'] = $count;
            $data['data'] = $data;
            $data['arErrorMessages'] = $this->Order_Model->arErrorMessages;
       $this->load->view('admin/admin_ajax_functions', $data);
    }
    public function view_order_list_by_fr()
    {
        $count = $this->Admin_Model->getnotification();
        $is_user_login = is_user_login($this);
        // redirect to dashboard if already logged in
        if (!$is_user_login) {
            ob_end_clean();
            redirect(base_url('/admin/admin_login'));
            die;
        }
        $searchAry = $_POST;
        $validOrdersDetailsAray = $this->Order_Model->getallValidOrderDetails($searchAry);
        $validOrdersDetailsSearchAray = $this->Order_Model->getallValidOrderDetails();
        //$validOrderIdforFr = $this->Order_Model->validOrderIdforFr();
        $allFrDetailsSearchAray = $this->Order_Model->getallValidOrderFrId();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('szSearch4', 'Start Order date ', 'required');
        $this->form_validation->set_rules('szSearch5', 'End Order date', 'required');
        $this->form_validation->set_message('required', '{field} is required.');
        if ($this->form_validation->run() == FALSE) {
            $data['validOrdersDetailsSearchAray'] = $validOrdersDetailsSearchAray;
            $data['allFrDetailsSearchAray'] = $allFrDetailsSearchAray;
            $data['szMetaTagTitle'] = "Order Details";
            $data['is_user_login'] = $is_user_login;
            $data['pageName'] = "Orders";
            $data['subpageName'] = "View_Order_List";
            $data['notification'] = $count;
            $data['data'] = $data;
            $data['arErrorMessages'] = $this->Order_Model->arErrorMessages;
            //$data['drugtestkitlist'] = $drugTestKitListAray;
            $this->load->view('layout/admin_header', $data);
            $this->load->view('order/viewOrderDetailsByFr');
            $this->load->view('layout/admin_footer');
        } else {
            $data['validOrdersDetailsAray'] = $validOrdersDetailsAray;
            $data['validOrdersDetailsSearchAray'] = $validOrdersDetailsSearchAray;
            $data['allFrDetailsSearchAray'] = $allFrDetailsSearchAray;
            $data['szMetaTagTitle'] = "Order Details";
            $data['is_user_login'] = $is_user_login;
            $data['pageName'] = "Orders";
            $data['subpageName'] = "View_Order_List";
            $data['notification'] = $count;
            $data['data'] = $data;
            $data['arErrorMessages'] = $this->Order_Model->arErrorMessages;
            //$data['drugtestkitlist'] = $drugTestKitListAray;
            $this->load->view('layout/admin_header', $data);
            $this->load->view('order/viewOrderDetailsByFr');
            $this->load->view('layout/admin_footer');
        }
    } 
}
?>