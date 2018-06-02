<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order_Model extends Error_Model {
    var $id;
    var $szName;
    var $szEmail;
    var $szPassword;
    var $data = array();
    
	  function InsertOrder($idProduct,$quantity)
        {		
             $date = date('Y-m-d H:i:s');
             $CheckOrderExistArr = $this->CheckOrderExist($idProduct);
            
              if(!empty($CheckOrderExistArr)){
                 $quantityTotal = 0; 
                 foreach($CheckOrderExistArr as $CheckOrderExistData) {
                     $quantityTotal +=  $CheckOrderExistData['quantity'] ; 
                 } 
                 $quantityforUpdate = $quantity+$quantityTotal;
                 $dataAry = array(
                       'franchiseeid' => $_SESSION['drugsafe_user']['id'],
                       'productid' => $idProduct,
                       'quantity' => $quantityforUpdate,
                       'addedon' => $date,
                   );
             $this->db->where('productid',(int)$idProduct);
             $queyUpdate=$this->db->update(__DBC_SCHEMATA_CART__, $dataAry);  
            } 
            else{
               $dataAry = array(
                                'franchiseeid' => $_SESSION['drugsafe_user']['id'],
                                'productid' => $idProduct,
				'quantity' => $quantity,
                                'addedon' => $date,
                            );
	    $this->db->insert(__DBC_SCHEMATA_CART__, $dataAry); 
            }
             
            
            if($this->db->affected_rows() > 0)
            {
	        return true;
            }
            else
            {
                return false;
             }
        }
       
    
        public function CheckOrderExist($id)
        {
        
            $whereAry = array('productid' => (int)$id);
            $this->db->select('id,quantity');
            $this->db->from(__DBC_SCHEMATA_CART__);
            $this->db->where($whereAry);
            $query = $this->db->get();
          
            if($query->num_rows() > 0)
            {
                return $query->result_array();
            }
            else
            {
                return array();
            }
        }
        public function getOrdersList($limit = __PAGINATION_RECORD_LIMIT__,$offset = 0,$searchAry = '')
        {
           if(!empty($searchAry)){
                    $whereAry = array('productid=' => $searchAry);
                    $this->db->where($whereAry);
                }
            $this->db->select('id,franchiseeid,productid,quantity');
            $this->db->from(__DBC_SCHEMATA_CART__);
            $query = $this->db->get();
          
            if($query->num_rows() > 0)
            {
                return  $query->result_array();
            }
            else
            {
                return array();
            }
        }
        public function deleteOrder($idOrder)
	{
        
             $this->db->where('id', $idOrder);
		if($query = $this->db->delete(__DBC_SCHEMATA_CART__))
                {
                    return true;
                }
                else
                {
                    return false;
                }	
	}
      public function updateOrder($quantity,$orderId)
	{
		$dataAry = array(
			'quantity' => $quantity
                );  
                $this->db->where('id', $orderId);
                 
		if($query = $this->db->update(__DBC_SCHEMATA_CART__, $dataAry))
                        
                {
                    return true;
                }
                else
                {
                    return false;
                }	
	}
  public function getOrdersListByFranchisee($franchiseeId)
        {
          
            $whereAry = array('franchiseeid=' => $franchiseeId);
            $this->db->select('id,franchiseeid,productid,addedon,quantity');
            $this->db->from(__DBC_SCHEMATA_CART__);
            $this->db->where($whereAry);
            $query = $this->db->get();
          
            if($query->num_rows() > 0)
            {
                return  $query->result_array();
            }
            else
            {
                return array();
            }
        }
   function InsertOrderSuccess($franchiseeId,$Price)
        { 
        
             $date = date('Y-m-d H:i:s');
            $dataAry = array(
                                'franchiseeid' => $franchiseeId,
                                'price' => $Price,
				'status' => '1',
                                'createdon' => $date,
                            );
	    $this->db->insert(__DBC_SCHEMATA_ORDER__, $dataAry); 
            if($this->db->affected_rows() > 0)
            {
                $id_order = (int)$this->db->insert_id();
             return $id_order;
            }
            else
            {
                return false;
            }
        }
     function InsertOrderDetails($totalOrdersData,$idorder)
        { 
          
          $orderid = $idorder;
          
                $dataAry = array(
                                'orderid' => $orderid,
                                'productid' => $totalOrdersData['productid'],
				'quantity' => $totalOrdersData['quantity'],
                                'dispatched' => '0',
                            );
            $this->db->insert(__DBC_SCHEMATA_ORDER_DETAILS__, $dataAry); 
        if($this->db->affected_rows() > 0){
            
             $this->db->where('franchiseeid', $totalOrdersData['franchiseeid']);
	     if($query = $this->db->delete(__DBC_SCHEMATA_CART__))
                { 
                 $this->session->set_userdata('orderid', $orderid);
                  $updatedataAry = array(
                                'validorder' => '1',
                            );
                  $this->db->where('id',(int)$orderid);
             if($this->db->update(__DBC_SCHEMATA_ORDER__, $updatedataAry))
             {
               return true;  
             }
             else{
                 return false; 
             }
                    return true;
                }
                else
                {
                    return false;
                }
                 return true;
            }
             else
            {
                return false;
            }
            
        }
       public function getOrderDetailsByFrId($franchiseeId)
        {
          
            $whereAry = array('franchiseeid=' => $franchiseeId);
            $this->db->select('id');
            $this->db->from(__DBC_SCHEMATA_ORDER__);
            $this->db->where($whereAry);
            $query = $this->db->get();
          
            if($query->num_rows() > 0)
            {
                $row = $query->result_array();
                  return $row['0'];
            }
            else
            {
                return array();
            }
        }  
       public function getOrderDetailsByOrderId($orderId)
        {
          
            $whereAry = array('orderid=' => $orderId);
            $this->db->select('id,orderid,productid,quantity,dispatched');
            $this->db->from(__DBC_SCHEMATA_ORDER_DETAILS__);
            $this->db->where($whereAry);
            $query = $this->db->get();
//           $q = $this->db->last_query();
//print_r($q);die;
            if($query->num_rows() > 0)
            {
                return  $query->result_array();
                   
            }
            else
            {
                return array();
            }
        }     
          public function getOrderByOrderId($orderId)
        {
          
            $whereAry = array('id=' => $orderId);
            $this->db->select('createdon,franchiseeid,status,price,freightprice,dispatched_price,last_changed,dispatchedon,canceledon');
            $this->db->from(__DBC_SCHEMATA_ORDER__);
            $this->db->where($whereAry);
            $query = $this->db->get();
          
            if($query->num_rows() > 0)
            {
                 $row = $query->result_array();
                 return  $row[0];
            }
            else
            {
                return array();
            }
        }

        public function getMinQtyOfProduct($prodid){
            $whereAry = array('id=' => $prodid);
            $this->db->select('min_ord_qty');
            $this->db->from(__DBC_SCHEMATA_PRODUCT__);
            $this->db->where($whereAry);
            $query = $this->db->get();

            if($query->num_rows() > 0)
            {
                $row = $query->result_array();
                return  $row[0];
            }
            else
            {
                return array();
            }
        }

 public function getallValidOrderDetails($searchAry=array())
    {
        
        if($_SESSION['drugsafe_user']['iRole']==2){
             $searchQuery = 'validorder = 1';
             $searchQuery .="
                            AND franchiseeid = ".(int)($_SESSION['drugsafe_user']['id']);
        }
        else{
            $searchQuery = 'validorder = 1';
        }
       
       
        
         if(!empty($searchAry))
        {
            
            foreach($searchAry as $key=>$searchData)
            { 
                if($key == 'szSearch4' || $key == 'szSearch5')
                {
                    if(!empty($searchData))
                    {
                         $searchData = $this->getSqlFormattedDate($searchData);
                      
                    }
                    if(!empty($searchData))
                    {
                        if($key == 'szSearch4')
                        {
                            $startcreatedon=$searchData;
                            $searchQuery .="
                                AND
                                    createdon >= '".$searchData." 00:00:00'
                                ";
                        }
                    }
                    
                    if($key == 'szSearch5')
                    { 
                        if(!empty($searchData))
                        {
                            $endcreatedon=$searchData;
                            if($endcreatedon != '')
                            {
                                if(strtotime($startcreatedon) > strtotime($endcreatedon))
                                {
                                    $this->addError("szSearch5","End Order date should be greater than Start Order date.");
                                    return false;
                                }
                            }
                            $searchQuery .="
                                AND
                                    createdon <= '".$searchData." 23:59:59'
                                ";
                        }
                    }
                    
                         
                }
             
                
                 if($key == 'szSearch1'){
                    if(!empty ($searchData)){
                        $searchQuery.="
                            AND franchiseeid = ".(int)($searchData);
                    }
                }
                 if($key == 'szSearch3'){
                    if(!empty ($searchData)){
                        $searchQuery.="
                            AND status = ".(int)($searchData);
                    }
                }
                if($key == 'szSearch2'){
                    if(!empty ($searchData)){
                        $searchQuery .="
                        AND 
                         orderid = ".(int)($searchData);
                    }
                }
                if($searchData != '')
                {
                    if($key =='szSearch3')
                    {
                        $searchQuery .="
                       AND
                            status = ".(int)($searchData);
                              
                    }
                    
                   
                    }
                }
                  
        }
        $this->db->where($searchQuery);
        $this->db->select('ds_orders.franchiseeid,ds_orders.isReceived,ds_orders.price,ds_orders.dispatched_price,ds_orders.last_changed,ds_orders.dispatchedon,ds_orders.canceledon,ds_orders.XeroIDnumber,ds_orders.xeroprocessed,ds_order_details.orderid,ds_orders.createdon,ds_orders.status,ds_order_details.productid,ds_order_details.quantity,ds_order_details.dispatched, COUNT(ds_order_details.orderid) as totalproducts');
        $this->db->order_by("orderid", "desc");
        $this->db->from(__DBC_SCHEMATA_ORDER__);
        $this->db->join(__DBC_SCHEMATA_ORDER_DETAILS__.' as ds_order_details', 'ds_orders.id = ds_order_details.orderid');
        $this->db->group_by('ds_order_details.orderid');
     
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
          
            }
         
        else {
            return array();
        }
    } 
      public function getallValidOrderFrId()
    {
        $whereAry = array('validorder=' => '1');
        $this->db->distinct();
        $this->db->select('szName,franchiseeid,userCode');
        $this->db->from(__DBC_SCHEMATA_ORDER__);
        $this->db->join('ds_user', 'ds_orders.franchiseeid = ds_user.id');
        $this->db->where($whereAry);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
          
            }
         
        else {
            return array();
        }
    } 
    function getSqlFormattedDate($unFormatted_date)
{
    $dateAry=explode('/', $unFormatted_date);
    $formattedDate=$dateAry['2'].'-'.$dateAry['1'].'-'.$dateAry['0'];
    return $formattedDate;
    
}
 public function updateOrderByOrderId($orderId,$flag='0')
	{
    $date = date('Y-m-d H:i:s');
     if($flag==2){
       $dataAry = array(
			'status' => '4',
                        'dispatchedon' => $date
                );   
     }
     if($flag==3){
        $dataAry = array(
			'status' => '3',
                        'canceledon' => $date
            
                );  
     }
		 
                $this->db->where('id', $orderId);
                 
		if($query = $this->db->update(__DBC_SCHEMATA_ORDER__, $dataAry))
                        
                {
                    return true;
                }
                else
                {
                    return false;
                }	
	}
         public function dispatchOrder($quantity,$orderId,$productid,$szAvailableQuantity,$franchiseeId)
	{ 
            
		$dataAry = array(
			'dispatched' => $quantity
                );
                 $whereAry = array('orderid=' => $orderId,'productid' => $productid);
                $this->db->where($whereAry);
                 
		if($query = $this->db->update(__DBC_SCHEMATA_ORDER_DETAILS__, $dataAry))
                        
                {
                    $availableQuantity = $szAvailableQuantity-$quantity;
                   $dataAry = array(
			'szAvailableQuantity' => $availableQuantity
                ); 
                 $whereAry = array('id' => $productid);
                $this->db->where($whereAry);
                 
                if($query = $this->db->update(__DBC_SCHEMATA_PRODUCT__, $dataAry)){
                 
                   $prodQuantity =  $this->StockMgt_Model->getProductQtyDetailsById($franchiseeId,$productid);
                  $Quantity = $prodQuantity['szQuantity']+$quantity;
                   $dataAry = array(
			'szQuantity' => $Quantity
                ); 
                 $whereAry = array('iFranchiseeId' => $franchiseeId,'iProductId' => $productid);
                 $this->db->where($whereAry);
                 if($this->db->update(__DBC_SCHEMATA_PRODUCT_STOCK_QUANTITY__, $dataAry)) {
                  return true;
                } 
                else{
                   return false;  
                }
                    return true;
                }
                else
                {
                    return false;
                }
                return true;
                }
                
                else{
                   return false;  
                }
	}
         public function orderFinalUpdate($orderId,$price)
	{ 
             
            $date = date('Y-m-d H:i:s');
		$dataAry = array(
			'status' => '2',
                        'price' => $price,
                        'dispatchedon' => $date
                );
                 $whereAry = array('id=' => $orderId);
                $this->db->where($whereAry);
                 
		if($query = $this->db->update(__DBC_SCHEMATA_ORDER__, $dataAry))
                        
                {
                    return true;
                }
                else
                {
                    return false;
                }	
	}
         public function pendingOrder($quantity,$orderId,$productid,$szAvailableQuantity,$franchiseeId)
	{ 
            
		$dataAry = array(
			'dispatched' => $quantity
                );
                 $whereAry = array('orderid=' => $orderId,'productid' => $productid);
                $this->db->where($whereAry);
                 
		if($query = $this->db->update(__DBC_SCHEMATA_ORDER_DETAILS__, $dataAry))
                        
                {
                    $availableQuantity = $szAvailableQuantity-$quantity;
                   $dataAry = array(
			'szAvailableQuantity' => $availableQuantity
                ); 
                 $whereAry = array('id' => $productid);
                $this->db->where($whereAry);
                 
                if($query = $this->db->update(__DBC_SCHEMATA_PRODUCT__, $dataAry)){
                 
                   $prodQuantity =  $this->StockMgt_Model->getProductQtyDetailsById($franchiseeId,$productid);
                  $Quantity = $prodQuantity['szQuantity']+$quantity;
                   $dataAry = array(
			'szQuantity' => $Quantity
                ); 
                 $whereAry = array('iFranchiseeId' => $franchiseeId,'iProductId' => $productid);
                 $this->db->where($whereAry);
                 if($this->db->update(__DBC_SCHEMATA_PRODUCT_STOCK_QUANTITY__, $dataAry)) {
                  return true;
                } 
                else{
                   return false;  
                }
                    return true;
                }
                else
                {
                    return false;
                }
                return true;
                }
                
                else{
                   return false;  
                }
	}
         public function orderPendingUpdate($orderId,$price)
	{ 
             
           $date = date('Y-m-d H:i:s');
		$dataAry = array(
			'status' => '4',
                        'price' => $price
                );
                 $whereAry = array('id=' => $orderId);
                $this->db->where($whereAry);
                 
		if($query = $this->db->update(__DBC_SCHEMATA_ORDER__, $dataAry))
                        
                {
                    return true;
                }
                else
                {
                    return false;
                }	
	}
      public function getallPendingValidOrderFrId()
    { 
        $whereAry = "(ds_orders.validorder LIKE '%1%' OR ds_orders.status LIKE '%4%' OR ds_orders.status LIKE '%1%')";
        $this->db->distinct();
        $this->db->select('szName,franchiseeid,userCode');
        $this->db->from(__DBC_SCHEMATA_ORDER__);
        $this->db->join('ds_user', 'ds_orders.franchiseeid = ds_user.id');
        $this->db->where($whereAry);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
          
            }
         
        else {
            return array();
        }
    }
    public function getallValidPendingOrderDetails($searchAry=array())
    {
       
        $searchQuery = 'validorder = 1 AND status != 3 AND status !=2'  ;
         if(!empty($searchAry))
        {
            
            foreach($searchAry as $key=>$searchData)
            { 

                 if($key == 'szSearch1'){
                    if(!empty ($searchData)){
                        $searchQuery.="
                            AND franchiseeid = ".(int)($searchData);
                    }
                }
                if($key == 'szSearch2'){
                    if(!empty ($searchData)){
                        $searchQuery .="
                        AND 
                         szProductCategory = ".(int)($searchData);
                    }
                }
                if($searchData != '')
                {
                    if($key =='szSearch3')
                    {
                        $searchQuery .="
                       AND
                             productid = ".(int)($searchData);
                              
                    }
                    
                   
                    }
                }
                  
        }
        $this->db->where($searchQuery);
        $this->db->select('ds_orders.franchiseeid, ds_orders.price, ds_order_details.orderid, ds_orders.createdon, ds_order_details.dispatched as dispatched, ds_orders.status, tbl_product.szProductCategory, tbl_product.id as productid, tbl_product.szProductCode, ds_order_details.quantity as quantity');
        $this->db->from(__DBC_SCHEMATA_ORDER__.' as ds_orders');
        $this->db->join(__DBC_SCHEMATA_ORDER_DETAILS__.' as ds_order_details', 'ds_orders.id = ds_order_details.orderid');
        $this->db->join(__DBC_SCHEMATA_PRODUCT_STOCK_QUANTITY__.' as prodstock', 'prodstock.iFranchiseeId = ds_orders.franchiseeid');
        $this->db->join(__DBC_SCHEMATA_PRODUCT__.' as tbl_product', 'ds_order_details.productid = tbl_product.id');

        $this->db->group_by("ds_order_details.productid");
        $this->db->order_by("ds_order_details.orderid", "desc");
        
        $query = $this->db->get();
        $q = $this->db->last_query();
//print_r($sql);die;
        if ($query->num_rows() > 0) {
            return $query->result_array();
          
            }
         
        else {
            return array();
        }
    } 
     public function getCategoryDetailsById($id)
    { 
        $whereAry = array('id' => $id) ;
        $this->db->select('szName');
        $this->db->from(__DBC_SCHEMATA_PRODUCT_CATEGORY__);
        $this->db->where($whereAry);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $row = $query->result_array();
          return $row['0'];
            }
         
        else {
            return array();
        }
    }
     public function getallValidPendingOrderFrDetails($searchAry=array())
    {
         $franchiseeid = $_SESSION['drugsafe_user']['id'];
         $searchQuery = "validorder LIKE '%1%'AND franchiseeid LIKE '%$franchiseeid%' AND status != '3'";
         if(!empty($searchAry))
        {  
             foreach($searchAry as $key=>$searchData)
            { 
                if($key == 'szSearch2'){
                    if(!empty ($searchData)){
                        $searchQuery .="
                        AND 
                         szProductCategory = ".(int)($searchData);
                    }
                }
                if($searchData != '')
                {
                    if($key =='szSearch3')
                    {
                        $searchQuery .="
                       AND
                             productid = ".(int)($searchData);
                              
                    }
                    
                   
                    }
                }
        }      
       
        $this->db->where($searchQuery);
        $this->db->distinct();
        $this->db->select('productid,franchiseeid,price,orderid,createdon,dispatched,status,szProductCategory,szProductCode,szAvailableQuantity,quantity');
        $this->db->order_by("orderid", "desc");
        $this->db->from(__DBC_SCHEMATA_ORDER__);
        $this->db->join('ds_order_details', 'ds_orders.id = ds_order_details.orderid');
        $this->db->join('tbl_product', 'ds_order_details.productid = tbl_product.id');
        
        
        $query = $this->db->get();
//$sql = $this->db->last_query($query);
//print_r($sql);die;
        if ($query->num_rows() > 0) {
            return $query->result_array();
          
            }
         
        else {
            return array();
        }
    } 
     public function getValidPendingOdrFrDetailsForPdf($productCode='',$prodCategory='')
        {
        $franchiseeid = $_SESSION['drugsafe_user']['id'];
        if(!empty($prodCategory)){
               $searchq = " szProductCategory LIKE '%$prodCategory%' AND franchiseeid LIKE '%$franchiseeid%' AND validorder LIKE '%1%' AND status != '3' ";
            }
            if(!empty($productCode)){
               $searchq = "productid LIKE '%$productCode%' AND franchiseeid LIKE '%$franchiseeid%' AND validorder LIKE '%1%' AND status != '3' ";
            }
            if(!empty($prodCategory) && !empty($productCode)){
                
                $searchq = "szProductCategory LIKE '%$prodCategory%' AND productid LIKE '%$productCode%' AND franchiseeid LIKE '%$franchiseeid%' AND validorder LIKE '%1%' AND status != '3'";
             
            }
            $this->db->where($searchq);
           $this->db->distinct();
           $this->db->select('productid,franchiseeid,price,orderid,createdon,dispatched,status,szProductCategory,szProductCode,szAvailableQuantity,quantity');
           $this->db->order_by("orderid", "desc");
           $this->db->from(__DBC_SCHEMATA_ORDER__);
           $this->db->join('ds_order_details', 'ds_orders.id = ds_order_details.orderid');
           $this->db->join('tbl_product', 'ds_order_details.productid = tbl_product.id');  
            
            $query = $this->db->get();
//$sql = $this->db->last_query($query);
// print_r($sql);die;
            if($query->num_rows() > 0)
            {
                return $query->result_array();
            }
            else
            {
                    return array();
            }
        }
         public function getValidPendingOdrDetailsForPdf($franchiseeid,$productCode='',$prodCategory='')
        {
 
          if(!empty($prodCategory)){
               $searchq = " szProductCategory LIKE '%$prodCategory%' AND franchiseeid LIKE '%$franchiseeid%' AND validorder LIKE '%1%' AND status != '3' AND status != '2' AND dispatched LIKE '%0%' ";
            }
            if(!empty($productCode)){
               $searchq = "productid LIKE '%$productCode%' AND franchiseeid LIKE '%$franchiseeid%' AND validorder LIKE '%1%' AND status != '3' AND status != '2' AND dispatched LIKE '%0%' ";
            }
            if(!empty($prodCategory) && !empty($productCode)){
                
                $searchq = "szProductCategory LIKE '%$prodCategory%' AND productid LIKE '%$productCode%' AND franchiseeid LIKE '%$franchiseeid%' AND validorder LIKE '%1%' AND status != '3' AND status != '2' AND dispatched LIKE '%0%' ";
             
            }
           
            $this->db->where($searchq);
           $this->db->distinct();
           $this->db->select('franchiseeid,price,orderid,createdon,dispatched,status,szProductCategory,szProductCode,szAvailableQuantity,quantity');
           $this->db->order_by("orderid", "desc");
           $this->db->from(__DBC_SCHEMATA_ORDER__);
           $this->db->join('ds_order_details', 'ds_orders.id = ds_order_details.orderid');
           $this->db->join('tbl_product', 'ds_order_details.productid = tbl_product.id');  
            
            $query = $this->db->get();
//          $sql = $this->db->last_query($query);
//         print_r($sql);die;
            if($query->num_rows() > 0)
            {
                return $query->result_array();
            }
            else
            {
                    return array();
            }
        }

      function dispatchsingleprod($ordid,$prodid,$qty,$freightPrice,$RemainingQty){
          
     $back_order = ($RemainingQty)-($qty);
            $query = $this->db->select('id')
             ->where(array('orderid' => (int)$ordid,'productid'=>$prodid,'dispatched' => 0))
            ->get(__DBC_SCHEMATA_ORDER_DETAILS__);
          if ($query->num_rows() > 0) {
              $result = $query->result_array();
              if(!empty($result)){
                  $dataAry = array(
                      'order_detail_id'=> (int)$result[0]['id'],
                      'dispatch_qty'=> (int)$qty,
                      'back_order'=> (int)$back_order,
                      'freightprice'=> $freightPrice,
                      'dispatch_date' => date('Y-m-d H:i:s')
                  );
              }
              $this->db->insert(__DBC_SCHEMATA_PARTIAL_DISPATCH__, $dataAry);
              if($this->db->affected_rows() > 0){
                  return true;
              }else{
                  $this->addError("error", "Something went wrong. Please try again.");
                  return false;
              }
          }else{
              $this->addError("error", "Something went wrong. Please try again.");
              return false;
          }
          /* $statusarr = array('dispatched' => (int)$qty);
           $conditionarr = array('orderid' => (int)$ordid,'productid'=>$prodid);
           $query = $this->db->where($conditionarr)
               ->update(__DBC_SCHEMATA_ORDER_DETAILS__, $statusarr);
           if ($query) {
               if($this->adjustFranchisorInventory($prodid,$qty)){
               $frIdByOrderId =  $this->getOrderByOrderId($ordid);


              $prodQuantity =  $this->StockMgt_Model->getProductQtyDetailsById($frIdByOrderId['franchiseeid'],$prodid);
              if(empty($prodQuantity)){
               $Quantity =$qty;
                 $dataAry = array(
                           'iFranchiseeId'=> $frIdByOrderId['franchiseeid'],
                           'iProductId'=> $prodid,
               'szQuantity' => $Quantity
                   );
                $query =   $this->db->insert(__DBC_SCHEMATA_PRODUCT_STOCK_QUANTITY__, $dataAry);
              }
              else{
                   $Quantity = $prodQuantity['szQuantity']+$qty;
                      $dataAry = array(
               'szQuantity' => $Quantity
                   );
                    $whereAry = array('iFranchiseeId' => $frIdByOrderId['franchiseeid'],'iProductId' => $prodid);
                    $this->db->where($whereAry);
                   $query =  $this->db->update(__DBC_SCHEMATA_PRODUCT_STOCK_QUANTITY__, $dataAry);
              }
              if($query)
                      {
                     return true;
                   }
                   else{
                      return false;
                   }


                   return true;
               }else{
                   return false;
               }
               return true;
           } else {
               $this->addError("error", "Something went wrong. Please try again.");
               return false;
           }*/
    }

    function changesdispatchstatus($ordid, $status, $price=0.00,$freightprice=0){
        $ordersDetailsAray = $this->getOrderByOrderId($ordid);
        $statusarr4 = array('status' => (int)$status,'last_changed'=>date('Y-m-d h:i:s'));
        $statusarr2 = array('status' => (int)$status,'dispatchedon'=>date('Y-m-d h:i:s'));
        $conditionarr = array('id' => (int)$ordid);
        $this->db->where($conditionarr)
            ->set('dispatched_price', 'dispatched_price + ' . (float)$price, FALSE)
            ->update(__DBC_SCHEMATA_ORDER__, ($status == '2'?$statusarr2:$statusarr4));
        if($freightprice>0){
            $priceArr = array('freightprice' =>($freightprice+$ordersDetailsAray['freightprice']));
            $this->db->where($conditionarr)
                ->update(__DBC_SCHEMATA_ORDER__, $priceArr);
            return true;
        }
        return true;
    }

    function adjustFranchisorInventory($prodid,$qty){
        $whereAry = array('id' => (int)$prodid);
        $this->db->where($whereAry)
            ->set('szAvailableQuantity', 'szAvailableQuantity-'.(int)$qty, FALSE)
            ->update(__DBC_SCHEMATA_PRODUCT__);
        if ($this->db->affected_rows() > 0) {
            return true;
        }else{
            return false;
        }
    }
        public function getManualCalcStartToEndDate($searchAry=array(),$sosId)
        {
            $dtStart = $this->getSqlFormattedDate($searchAry['dtStart']);
            $dtEnd = $this->getSqlFormattedDate($searchAry['dtEnd']);
            $this->db->where_in('sosid', $sosId);
            $this->db->from(__DBC_SCHEMATA_MANUAL_CAL__);
            $this->db->where('dtCreatedOn >=', $dtStart);
            $this->db->where('dtCreatedOn <=', $dtEnd);
            $query = $this->db->get();
            //echo $sql = $this->db->last_query(); die();
            if ($query->num_rows() > 0) 
            {
                return $query->result_array();
            }
            else 
            {
                return array();
            }
        }

        function  getAllDispatchedQty($franchiseeid,$prodid){

//            $searchQuery = 'dispatched = 0'  ;

                if($franchiseeid>0){
                    $searchQuery.="
                     ds_orders.franchiseeid = ".(int)($franchiseeid);
                }
                if($prodid>0)
                {
                    $searchQuery .="
               AND
                     ds_order_details.productid = ".(int)($prodid);

                }
            $this->db->where($searchQuery);
            $this->db->select('SUM(ds_partial_dispatch_tracking.dispatch_qty) as dispatch_qty');
            $this->db->from(__DBC_SCHEMATA_ORDER__.' as ds_orders');
            $this->db->join(__DBC_SCHEMATA_ORDER_DETAILS__.' as ds_order_details', 'ds_orders.id = ds_order_details.orderid');
             $this->db->join(__DBC_SCHEMATA_PARTIAL_DISPATCH__.' as ds_partial_dispatch_tracking', 'ds_order_details.id = ds_partial_dispatch_tracking.order_detail_id');
           
            $query = $this->db->get();
//           $q = $this->db->last_query();
//            echo $q;
//                die;
            if ($query->num_rows() > 0) {
                return $query->result_array();

            }

            else {
                return array();
            }
        }
 function  getorderdanddispatchval($franchiseeid,$prodid){

            $searchQuery = 'validorder = 1 AND status != 3'  ;

                if($franchiseeid>0){
                    $searchQuery.="
                    AND ds_orders.franchiseeid = ".(int)($franchiseeid);
                }
                if($prodid>0)
                {
                    $searchQuery .="
               AND
                     ds_order_details.productid = ".(int)($prodid);

                }
            $this->db->where($searchQuery);
            $this->db->select('SUM(ds_order_details.dispatched) as dispatched, ds_orders.franchiseeid,ds_order_details.productid, SUM(ds_order_details.quantity) as quantity');
            $this->db->from(__DBC_SCHEMATA_ORDER__.' as ds_orders');
            $this->db->join(__DBC_SCHEMATA_ORDER_DETAILS__.' as ds_order_details', 'ds_orders.id = ds_order_details.orderid');
            $this->db->group_by('ds_order_details.productid');
            $query = $this->db->get();
            /*$q = $this->db->last_query();
            echo $q;*/
//print_r($sql);die;
            if ($query->num_rows() > 0) {
                return $query->result_array();

            }

            else {
                return array();
            }
        }
        function getProductDetsByfranchiseeid($franchiseeid,$catid=0,$prodcode=0){
            $whereAry = 'prodstock.iFranchiseeId =' . (int)$franchiseeid .' AND prod.isDeleted = 0 '.($catid>0?' AND prod.szProductCategory = '.(int)$catid:'').($prodcode>0?' AND prod.id = '.(int)$prodcode:'') ;
            $query = $this->db->select('prodstock.szQuantity, prodstock.iFranchiseeId, prod.id, prod.szProductCode, prod.model_stk_val, prod.szProductDiscription, prod.szProductCategory,prod.szAvailableQuantity')
                ->from(__DBC_SCHEMATA_PRODUCT_STOCK_QUANTITY__. ' as prodstock')
                ->join(__DBC_SCHEMATA_PRODUCT__ . ' as prod', 'prod.id = prodstock.iProductId')
                ->where($whereAry)
                ->get();
            /*$q = $this->db->last_query();
            die($q);*/
            if ($query->num_rows() > 0) {
                $row = $query->result_array();
                return $row;
            } else {
                $this->addError("norecord", "No record found.");
                return false;
            }
        }

        function getTotalFrOrderdqty($franchiseeid,$prodid){
            $whereAry = 'ord.franchiseeid =' . (int)$franchiseeid .' AND orddet.productid = '.(int)$prodid ;
             //$whereAry = 'ord.franchiseeid =' . (int)$franchiseeid .' AND orddet.productid = '.(int)$prodid.' AND orddet.dispatched = 0' ;
            $query = $this->db->select('SUM(orddet.quantity) as quantity')
                ->from(__DBC_SCHEMATA_ORDER_DETAILS__. ' as orddet')
                ->join(__DBC_SCHEMATA_ORDER__ . ' as ord', 'ord.id = orddet.orderid')
                ->where($whereAry)
                ->get();
            /*$q = $this->db->last_query();
            die($q);*/
            if ($query->num_rows() > 0) {
                $row = $query->result_array();
                return $row;
            } else {
                $this->addError("norecord", "No record found.");
                return false;
            }
        }
     function updateInventoryByOrderId($ordid,$prodid,$qty,$dispatchProdId){
        $statusarr = array('received' => (int)1);
        $conditionarr = array('id' => (int)$dispatchProdId);
        $this->db->where($conditionarr);
        $queryUpdate = $this->db->update(__DBC_SCHEMATA_PARTIAL_DISPATCH__, $statusarr);
            if ($queryUpdate) {
            $frIdByOrderId =  $this->getOrderByOrderId($ordid);
            $prodQuantity =  $this->StockMgt_Model->getProductQtyDetailsById($frIdByOrderId['franchiseeid'],$prodid); 
           if(empty($prodQuantity)){
            $Quantity =$qty; 
              $dataAry = array(
                        'iFranchiseeId'=> $frIdByOrderId['franchiseeid'],
                        'iProductId'=> $prodid,
			'szQuantity' => $Quantity
                ); 
             $query =   $this->db->insert(__DBC_SCHEMATA_PRODUCT_STOCK_QUANTITY__, $dataAry);
           }
           else{
                $Quantity = $prodQuantity['szQuantity']+$qty;
                   $dataAry = array(
			'szQuantity' => $Quantity
                ); 
                 $whereAry = array('iFranchiseeId' => $frIdByOrderId['franchiseeid'],'iProductId' => $prodid);
                 $this->db->where($whereAry);
                $query =  $this->db->update(__DBC_SCHEMATA_PRODUCT_STOCK_QUANTITY__, $dataAry);
           }
           if($query)
                   {
                  return true;
                } 
                else{
                   return false;  
                }
                return true;
        } else {
            $this->addError("error", "Something went wrong. Please try again.");
            return false;
        }
    }

    function updateXeroOrderDetails($orderid,$xerono){
        $dataAry = array(
            'XeroIDnumber' => $xerono,
            'xeroprocessed' => 1
        );
        $this->db->where('id',(int)$orderid)
                ->update(__DBC_SCHEMATA_ORDER__, $dataAry);
    }

    function xeroIntigration($ordid)
    {
        $this->load->library('xero');
        $getOrderDetails=$this->getOrderByOrderId($ordid);
        $totalOrdersDetailsAray = $this->getOrderDetailsByOrderId($ordid);
        if(!empty($getOrderDetails))
        {
            $userDeatils=$this->Admin_Model->getUserDetailsByEmailOrId('',$getOrderDetails['franchiseeid']);
        }
        $lineItems = array();
        if (!empty($totalOrdersDetailsAray)) {
            foreach ($totalOrdersDetailsAray as $totalOrdersDetailsData) {
                $productDataArr = $this->Inventory_Model->getProductDetailsById($totalOrdersDetailsData['productid']);
                $dispatchOrderDetail = $this->getRecentlyDispatchOrderDate($totalOrdersDetailsData['id']);
                $lienItem = array(
                    "Description" => $productDataArr['szProductDiscription'],
                    "Quantity" => (!empty($dispatchOrderDetail['dispatch_qty'])?$dispatchOrderDetail['dispatch_qty']:'0'),
                    "UnitAmount" => $productDataArr['szProductCost'],
                    "AccountCode" => "200"
                );
                array_push($lineItems, $lienItem);
            }
        }
        $new_contact = array(
            array(
                "Name" => $userDeatils['szName'],
                "FirstName" => $userDeatils['szName'],
                "Addresses" => array(
                    "Address" => array(
                        array(
                            "AddressType" => "POBOX",
                            "AddressLine1" => $userDeatils['szAddress'],
                            "City" => $userDeatils['szCity'],
                            "Country" => $userDeatils['szCountry'],
                            "PostalCode" => $userDeatils['szZipCode']
                        ),
                        array(
                            "AddressType" => "STREET",
                            "AddressLine1" => $userDeatils['szAddress'],
                            "City" => $userDeatils['szCity'],
                            "Country" => $userDeatils['szCountry'],
                            "PostalCode" => $userDeatils['szZipCode']
                        )
                    )
                )
            )
        );
        // create the contact
        $this->xero->Contacts($new_contact);
        $new_invoice = array(
            array(
                "Type"=>"ACCREC",
                "Contact" => array(
                    "Name" => $userDeatils['szName']
                ),
                "Date" => $getOrderDetails['createdon'],
                "DueDate" => date('Y-m-d H:i:s', strtotime($getOrderDetails['createdon'] . ' +14 day')),
                "Status" => "AUTHORISED",
                "LineAmountTypes" => "Exclusive",
                "LineItems" => array(
                    "LineItem" => $lineItems
                ),
                "TaxType" => "OUTPUT"
            )
        );
        $this->xero->Invoices($new_invoice);
        $this->xero->Accounts(false, false, array("Name"=>$userDeatils['szName']));
        $org_invoices = $this->xero->Invoices;

        $invoice_count = sizeof($org_invoices->Invoices->Invoice);

        //$invoice_index = rand(0,$invoice_count);
        $invoice_index = $invoice_count-1;
        //$invoice_id = (string) $org_invoices->Invoices->Invoice[$invoice_index]->InvoiceID;
        $invoice_number = (string) $org_invoices->Invoices->Invoice[$invoice_index]->InvoiceNumber;
        $this->updateXeroOrderDetails($ordid,$invoice_number);
    }

    function checkOrderEditable($orderid){
        $query = $this->db->select('id')
            ->where(array('orderid'=>(int)$orderid, 'dispatched'=>'0'))
        ->get(__DBC_SCHEMATA_ORDER_DETAILS__);

        if ($query->num_rows() > 0) {
            $row = $query->result_array();
            return $row;
        }else{
            return false;
        }
    }

    function getTotalDispatchedByOrderDetailId($orderDetailId){
        $query = $this->db->select('SUM(dispatch_qty) as total_dispatched')
         ->where('order_detail_id',(int)$orderDetailId)
        ->get(__DBC_SCHEMATA_PARTIAL_DISPATCH__);
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
            return $row[0];
        }else{
            return false;
        }
    }
    function getTotalReceivedDispatchedqty($orderDetailId){
        $query = $this->db->select('SUM(dispatch_qty) as total_dispatched')
            ->where('order_detail_id',(int)$orderDetailId)
            ->where('received',(int)'1')
        ->get(__DBC_SCHEMATA_PARTIAL_DISPATCH__);
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
            return $row[0];
        }else{
            return false;
        }
    }

    function AllDispatched($orderId,$prodid){
        $statusarr = array('dispatched' => 1);
        $conditionarr = array('orderid' => (int)$orderId,'productid'=>$prodid, 'dispatched' => 0);
        $this->db->where($conditionarr)
            ->update(__DBC_SCHEMATA_ORDER_DETAILS__, $statusarr);
        if($this->db->affected_rows() > 0){
            return true;
        }else{
            $this->addError("error", "Something went wrong. Please try again.");
            return false;
        }
    }

    function getRecentlyDispatchOrderDate($orderDetailId){
        $query = $this->db->select('dispatch_qty')
                        ->where('order_detail_id = '.(int)$orderDetailId.' AND dispatch_date IN (SELECT MAX(`dispatch_date`) FROM '.__DBC_SCHEMATA_PARTIAL_DISPATCH__.' WHERE order_detail_id = '.(int)$orderDetailId.')', NULL, FALSE)
                        ->get(__DBC_SCHEMATA_PARTIAL_DISPATCH__);
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
            return $row[0];
        }else{
            return false;
        }
    }

    function getTotalOrderDispatchDates($orderid,$received=0){
        $conditionStr = 'orddet.orderid = '.(int)$orderid.($received==1?' AND part.received = 0':($received==2?' AND part.received = 1':''));
        $query = $this->db->select('part.dispatch_date')
            ->from(__DBC_SCHEMATA_PARTIAL_DISPATCH__ . ' as part')
            ->join(__DBC_SCHEMATA_ORDER_DETAILS__ . ' as orddet', 'orddet.id = part.order_detail_id')
            ->where($conditionStr)
            ->order_by(" part.id","desc")
            ->group_by('part.dispatch_date')
            ->get();
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
            return $row;
        }else{
            return false;
        }
    }

    function getDispatchedOrderDetByDispatchDate($dispatchDate,$orderid=0){
        $whereStr = 'part.dispatch_date = "'.$dispatchDate.'"'.($orderid>0?' AND orddet.orderid = '.(int)$orderid:'');
        $query = $this->db->select('part.dispatch_date, part.dispatch_qty, orddet.productid, part.freightprice, orddet.quantity, orddet.orderid, part.id ,orddet.id as order_detail_id,part.back_order')
            ->from(__DBC_SCHEMATA_PARTIAL_DISPATCH__ . ' as part')
            ->join(__DBC_SCHEMATA_ORDER_DETAILS__ . ' as orddet', 'orddet.id = part.order_detail_id')
            ->where($whereStr)
            ->order_by(" part.id","desc")
            ->get();
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
            return $row;
        }else{
            return false;
        }
    }
    function sendOrderEmail()
    {      $franchiseeid = $_SESSION['drugsafe_user']['id'];
            $franchiseeDetArr = $this->Admin_Model->getAdminDetailsByEmailOrId('',$franchiseeid);
            $orderIdAry = $this->getLatestOrdersId(); 
            $replace_ary = array();
            $replace_ary['supportEmail'] = __ORDER_SUPPORT_EMAIL__;
            $replace_ary['Link'] = __BASE_URL__ . "/admin/admin_login";
         
            createEmail($this, '__ORDER_NOTIFICATION__', $replace_ary,$franchiseeDetArr['szEmail'], '', __ORDER_SUPPORT_EMAIL__,$orderIdAry['id'], __ORDER_SUPPORT_EMAIL__,'',2);
          
        
            return true;
        

    }  
     public function getLatestOrdersId()
        {
            $this->db->select_max('id');
            $this->db->from(__DBC_SCHEMATA_ORDER__);
            $query = $this->db->get();
         
            if($query->num_rows() > 0)
            {
                $row = $query->result_array();
                return  $row['0'];
            }
            else
            {
                return array();
            }
        }
   }
?>