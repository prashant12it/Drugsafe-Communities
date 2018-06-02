<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reporting_Model extends Error_Model {
    
    public function __construct()
    {
        parent::__construct();
    }
    
     public function getAllQtyRequestDetails($searchAry = '',$limit=__PAGINATION_RECORD_LIMIT__,$offset=0,$searchItemData='',$flag='0')
        {
     
          if(!empty($searchItemData)){
               $searchq = "iFranchiseeId LIKE '%$searchItemData%' OR szName LIKE '%$searchItemData%' OR szProductCode LIKE '%$searchItemData%'";
            }
            if($flag==1){
            $this->db->distinct();
           $this->db->select( 'szName');  
         }elseif($flag==2)
        {
           $this->db->distinct();
           $this->db->select( 'szProductCode');   
        }
            else{
           $this->db->select( '*');  
        }
         
          
            $this->db->from(__DBC_SCHEMATA_REQUEST_QUANTITY__);
            if($_SESSION['drugsafe_user']['iRole']==5){
          
            $operationManagerId =  $_SESSION['drugsafe_user']['id'];
            $whereAry = array('operationManagerId' => $operationManagerId);
            $this->db->join('ds_user','tbl_stock_request.iFranchiseeId = ds_user.id');
            $this->db->join('tbl_product','tbl_stock_request.iProductId = tbl_product.id');
            $this->db->join('tbl_franchisee','tbl_stock_request.iFranchiseeId = tbl_franchisee.franchiseeId');
             if (!empty($searchq)) {
               $this->db->where($searchq);
               $this->db->where($whereAry);
               }
               else{
                  $this->db->where($whereAry);  
               }
            
            }
            else{
             $this->db->join('ds_user','tbl_stock_request.iFranchiseeId = ds_user.id');
             $this->db->join('tbl_product','tbl_stock_request.iProductId = tbl_product.id');   
             if (!empty($searchq)) {
               $this->db->where($searchq);
               } 
                if($flag==3){
                    if( $searchItemFr &&  $searchItemProd ){
                          $whereAry = array('szName' => $searchItemFr,'szProductCode' => $searchItemProd);  
                    } else{
                         $whereAry = array('szName' => $_POST['szSearch2'],'szProductCode' => $_POST['szSearch']);   
                    }
           
                 $this->db->where($whereAry);
            }
            }
            
            
            $this->db->limit($limit, $offset);
            $this->db->order_by(__DBC_SCHEMATA_REQUEST_QUANTITY__.'.id DESC');
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
         public function getAllQtyAssignDetails($searchAry = '',$limit = __PAGINATION_RECORD_LIMIT__,$offset = 0,$searchItemData='',$flag='0')
        {
            if(!empty($searchItemData)){
               $searchq = "iFranchiseeId LIKE '%$searchItemData%' OR szName LIKE '%$searchItemData%' OR szProductCode LIKE '%$searchItemData%'";
            }
           
        if($flag==1){
            $this->db->distinct();
           $this->db->select( 'szName');  
        }elseif($flag==2)
        {
           $this->db->distinct();
           $this->db->select( 'szProductCode');   
        }
            else{
           $this->db->select( '*');  
        }
           
            $this->db->from(__DBC_SCHEMATA_STOCK_REQ_TRACKING__);
            
             if($_SESSION['drugsafe_user']['iRole']==5){
          
            $operationManagerId =  $_SESSION['drugsafe_user']['id'];
            $whereAry = array('operationManagerId' => $operationManagerId);
            $this->db->join('ds_user','tbl_stock_assign_tracking.iFranchiseeId = ds_user.id');
            $this->db->join('tbl_product','tbl_stock_assign_tracking.iProductId = tbl_product.id');
            $this->db->join('tbl_franchisee','tbl_stock_assign_tracking.iFranchiseeId = tbl_franchisee.franchiseeId');
             if (!empty($searchq)) {
               $this->db->where($searchq);
               $this->db->where($whereAry);
               }
               else{
                  $this->db->where($whereAry);  
               }
            
            }
            else{
            $this->db->join('ds_user','tbl_stock_assign_tracking.iFranchiseeId = ds_user.id');
            $this->db->join('tbl_product','tbl_stock_assign_tracking.iProductId = tbl_product.id');
             if (!empty($searchq)) {
               $this->db->where($searchq);
               }
                if($flag==3){
                    if( $searchItemFr &&  $searchItemProd ){
                          $whereAry = array('szName' => $searchItemFr,'szProductCode' => $searchItemProd);  
                    } else{
                         $whereAry = array('szName' => $_POST['szSearch2'],'szProductCode' => $_POST['szSearch']);   
                    }
           
                 $this->db->where($whereAry);
            }
            }
            $this->db->limit($limit, $offset);
            $this->db->order_by(__DBC_SCHEMATA_STOCK_REQ_TRACKING__.'.id DESC');
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
      
        public function getFrAllQtyRequestDetails($searchAry = '',$limit = __PAGINATION_RECORD_LIMIT__,$offset = 0,$franchiseeId = 0,$flag='0')
        {
        
            $searchAry = trim($searchAry);
             if(!empty($searchAry)){
          
                $whereAry = array('iFranchiseeId' => $franchiseeId,'szProductCode' => $searchAry);
           
                }
                else{
                    $whereAry = array('iFranchiseeId' => $franchiseeId); 
                }
            if($flag==1){
           
           $this->db->distinct();
           $this->db->select( 'szProductCode');   
        }
            else{
           $this->db->select( '*');  
        }
         
          
            $this->db->from(__DBC_SCHEMATA_REQUEST_QUANTITY__);
            $this->db->join('tbl_product','tbl_stock_request.iProductId = tbl_product.id');
          
             $this->db->where($whereAry);
            $this->db->limit($limit, $offset);
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
         public function getFrAllQtyAssignDetails($searchAry='',$limit = __PAGINATION_RECORD_LIMIT__,$offset = 0,$franchiseeId = 0,$flag='0')
        {
            $searchAry = trim($searchAry);
             if(!empty($searchAry)){
          
                $whereAry = array('iFranchiseeId' => $franchiseeId,'szProductCode' => $searchAry);
           
                }
                else{
                    $whereAry = array('iFranchiseeId' => $franchiseeId); 
                }
                 if($flag==1){
           
           $this->db->distinct();
           $this->db->select( 'szProductCode');   
        }
            else{
           $this->db->select( '*');  
        }
           
            $this->db->from(__DBC_SCHEMATA_STOCK_REQ_TRACKING__);
            $this->db->join('tbl_product','tbl_stock_assign_tracking.iProductId = tbl_product.id');
            $this->db->where($whereAry);
            $this->db->limit($limit, $offset);
            $this->db->order_by(__DBC_SCHEMATA_STOCK_REQ_TRACKING__.'.id DESC');
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
public function searchterm_handler($searchterm='')
{
    if($searchterm)
    { 
        $this->session->set_userdata('searchterm',$searchterm);
        return $searchterm;
    }
    elseif($this->session->userdata('searchterm'))
    { 
        $searchterm = $this->session->userdata('searchterm');
        return $searchterm;
    }
    else
    { 
        $searchterm ="";
        return $searchterm;
    }
}
public function searchtermAssign_handler($searchtermAssign='')
{
    if($searchtermAssign)
    { 
        $this->session->set_userdata('searchtermAssign',$searchtermAssign);
        return $searchtermAssign;
    }
    elseif($this->session->userdata('searchtermAssign'))
    { 
        $searchtermAssign= $this->session->userdata('searchtermAssign');
        return $searchtermAssign;
    }
    else
    { 
        $searchtermAssign ="";
        return $searchtermAssign;
    }
}
public function getAllQtyAssignDetailsForPdf($FrName = '',$productCode='')
        {
            if(!empty($FrName)){
               $searchq = " szName LIKE '%$FrName%'";
            }
            if(!empty($productCode)){
               $searchq = "szProductCode LIKE '%$productCode%'";
            }
            if(!empty($FrName) && !empty($productCode)){
               $searchq = array('szName' => $FrName,'szProductCode' => $productCode);
            }
           
           $this->db->select( '*');  
      
           
            $this->db->from(__DBC_SCHEMATA_STOCK_REQ_TRACKING__);
            
          
            $this->db->join('ds_user','tbl_stock_assign_tracking.iFranchiseeId = ds_user.id');
            $this->db->join('tbl_product','tbl_stock_assign_tracking.iProductId = tbl_product.id');
             if (!empty($searchq)) {
               $this->db->where($searchq);
               }
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
        public function getAllQtyRequestDetailsForPdf($FrName='',$productCode='')
        {
     
          if(!empty($FrName)){
               $searchq = " szName LIKE '%$FrName%'";
            }
            if(!empty($productCode)){
               $searchq = "szProductCode LIKE '%$productCode%'";
            }
            if(!empty($FrName) && !empty($productCode)){
               $searchq = array('szName' => $FrName,'szProductCode' => $productCode);
            }
            $this->db->select( '*');  
            $this->db->from(__DBC_SCHEMATA_REQUEST_QUANTITY__);
            $this->db->join('ds_user','tbl_stock_request.iFranchiseeId = ds_user.id');
            $this->db->join('tbl_product','tbl_stock_request.iProductId = tbl_product.id');   
            if (!empty($searchq)) {
               $this->db->where($searchq);
               } 
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
        public function getSosAndClientDetils($searchAry=array())
        {
      
            if($searchAry['szIndustry']!='')
            {
                $this->db->where('industry',$searchAry['szIndustry']);
            }
            $dtStart = $this->Order_Model->getSqlFormattedDate($searchAry['dtStart']);
            $dtEnd = $this->Order_Model->getSqlFormattedDate($searchAry['dtEnd']);
            
            $this->db->select('*');
            $this->db->from('ds_sos');
            $this->db->join('tbl_client', 'tbl_client.clientId = ds_sos.Clientid');
            $this->db->where('testdate >=', $dtStart);
            $this->db->where('testdate <=', $dtEnd);
            $this->db->where('clientType !=', '0');
            $this->db->where('status', '1');
            $this->db->group_by('industry');
            $this->db->select_sum('TotalAlcoholScreening', 'totalAlcohol');
            $this->db->select_sum('TotalDonarScreeningUrine','totalDonarUrine');
            $this->db->select_sum('TotalDonarScreeningOral','totalDonarOral');
            $this->db->select_sum('NegativeResultUrine','totalNegativeUrine');
            $this->db->select_sum('NegativeResultOral','totalNegativeOral');
            $this->db->select_sum('NegativeAlcohol','totalNegativeAlcohol');
            $this->db->select_sum('PositiveAlcohol','totalPositiveAlcohol');
            $query = $this->db->get();
           /*$q = $this->db->last_query();
           echo $q;*/

        if ($query->num_rows() > 0) {
             return $query->result_array();   
        }else{
            return array();
        }
    }

    function getcomparisonrecord($siteid,$drugtype,$compparm=1){
         $groupbystr = 'MONTH(testdate), YEAR(testdate) DESC';
         if($compparm == 2){
             $groupbystr = 'YEAR(testdate) DESC';
         }
        $wherestr = " Clientid = ".(int)$siteid." AND Drugtestid LIKE '%".$drugtype."%'";
        $query = $this->db->select('MONTHNAME(testdate) as month, YEAR(testdate) as year')
            ->select_sum('TotalAlcoholScreening', 'totalAlcohol')
            ->select_sum('TotalDonarScreeningUrine','totalDonarUrine')
            ->select_sum('TotalDonarScreeningOral','totalDonarOral')
            ->select_sum('NegativeResultUrine','totalNegativeUrine')
            ->select_sum('NegativeResultOral','totalNegativeOral')
            ->select_sum('NegativeAlcohol','totalNegativeAlcohol')
            ->select_sum('PositiveAlcohol','totalPositiveAlcohol')
            ->from(__DBC_SCHEMATA_SOS_FORM__)
            ->where($wherestr)
            ->group_by($groupbystr)
            ->get();
        /*$q = $this->db->last_query();
        echo $q;*/
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array();
        }
    }
       
        function getAllRevenueManualalc($searchAry=array(),$franchiseeId,$clientId='')
        {
           
           if($clientId)
           {
                  $this->db->where('clientType',$clientId);
           }
            $dtStart = $this->Order_Model->getSqlFormattedDate($searchAry['dtStart']);
            $dtEnd = $this->Order_Model->getSqlFormattedDate($searchAry['dtEnd']);
            $whereAry = array('clientType!='=>'0','status='=>'1'); 
                        $this->db->select( '*');
                            $this->db->from(__DBC_SCHEMATA_CLIENT__);
                            $this->db->join(__DBC_SCHEMATA_SOS_FORM__, __DBC_SCHEMATA_SOS_FORM__ . '.Clientid = ' . __DBC_SCHEMATA_CLIENT__ . '.clientId');
                            $this->db->join(__DBC_SCHEMATA_MANUAL_CAL__, __DBC_SCHEMATA_MANUAL_CAL__ . '.sosid = ' . __DBC_SCHEMATA_SOS_FORM__ . '.id');
                            $this->db ->where($whereAry);
                            $this->db->where('franchiseeId',$franchiseeId);
                            if(!empty($searchAry)){
                                $this->db ->where('dtCreatedOn >=', $dtStart);
                                $this->db->where('dtCreatedOn <=', $dtEnd);
                            }
                          $query =  $this->db->get();
            
             if($query->num_rows() > 0)
            {
                return $query->result_array();
            }
            else
            {
                return array();
            }
        }
	     function getSummeryRevenueManualalc($searchAry=array(),$franchiseeId)
        {
        
            $dtStart = $this->Order_Model->getSqlFormattedDate($searchAry['dtStart']);
            $dtEnd = $this->Order_Model->getSqlFormattedDate($searchAry['dtEnd']);
            $whereAry = array('clientType!='=>'0','status='=>'1'); 
            $query=$this->db->select( '*')
                            ->from(__DBC_SCHEMATA_CLIENT__)
                            ->join(__DBC_SCHEMATA_SOS_FORM__, __DBC_SCHEMATA_SOS_FORM__ . '.Clientid = ' . __DBC_SCHEMATA_CLIENT__ . '.clientId')
                            ->join(__DBC_SCHEMATA_MANUAL_CAL__, __DBC_SCHEMATA_MANUAL_CAL__ . '.sosid = ' . __DBC_SCHEMATA_SOS_FORM__ . '.id')
                            ->where($whereAry)
                            ->where('dtCreatedOn >=', $dtStart)
                            ->where('dtCreatedOn <=', $dtEnd)
                            ->get();
	         if($query->num_rows() > 0)
            {
                return $query->result_array();
            }
            else
            {
                return array();
            }
        }
     public function viewFranchiseeInventoryList($franchiseeName='', $catid)
        {
         if(!empty($franchiseeName)){
          $whereAry = array('product.isDeleted=' => '0','product.szProductCategory' => $catid ,'user.szName=' => $franchiseeName);    
         }
         else{
              $whereAry = array('product.isDeleted=' => '0','product.szProductCategory' => $catid);
         }
           
            $this->db->select('*');   
          
            $this->db->from(__DBC_SCHEMATA_PRODUCT__.' as product');
            $this->db->join(__DBC_SCHEMATA_PRODUCT_STOCK_QUANTITY__.' as qty','qty.iProductId = product.id');
            $this->db->join(__DBC_SCHEMATA_USERS__.' as user','qty.iFranchiseeId = user.id');
            $this->db->where($whereAry);
            $this->db->limit($limit, $offset);
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
}
?>
