<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Form_Management_Model extends Error_Model {
    
   public function getsosFormDetails($idsite,$flag=0)
    {
        $whereAry = array('Clientid=' => $idsite);
        $this->db->select('*');
        $this->db->from(__DBC_SCHEMATA_SOS_FORM__);
        $this->db->join('ds_user', 'ds_sos.Clientid = ds_user.id');
        $this->db->where($whereAry);
        $query = $this->db->get();


        if ($query->num_rows() > 0) {
            $row = $query->result_array();
            if($flag==1){
                return $row[0];
            }
            else{
               return $row;  
            }
        } else {
            return array();
        }
    } 
     public function getsosFormDetailsByClientId($idClient)
    {
        $whereAry = array('Clientid' => $idClient,'Status'=>'1');
        $this->db->select('*');
        $this->db->from(__DBC_SCHEMATA_SOS_FORM__);
        $this->db->where($whereAry); 
//         $this->db->order_by("id", "desc");
        $query = $this->db->get();
        //$sql = $this->db->last_query($query);
        //print_r($sql);die;
        if ($query->num_rows() > 0) {
                $row = $query->result_array();
                return $row;
        } else {
            return array();
        }
    } 
     public function getDonarDetailBySosId($idSos)
    {
        $whereAry = array('sosid' => $idSos);
        $this->db->select('*');
        $this->db->order_by($sortBy, $orderBy);
        $this->db->order_by("id", "asc");
        $this->db->from(__DBC_SCHEMATA_DONER__);
        $this->db->where($whereAry); 
        $query = $this->db->get();


        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array();
        }
    } 
     public function getSosDetailBySosId($idSos)
    {
        $whereAry = array('id' => $idSos);
        $this->db->select('*');
        $this->db->order_by($sortBy, $orderBy);
        $this->db->order_by("id", "asc");
        $this->db->from(__DBC_SCHEMATA_SOS_FORM__);
        $this->db->where($whereAry); 
        $query = $this->db->get();


        if ($query->num_rows() > 0) {
         $row=  $query->result_array();
            return $row[0];
        } else {
            return array();
        }
    } 
      public function getDonarDetailByCocId($idCoc)
    {
        $whereAry = array('cocid' => $idCoc);
        $this->db->select('*');
        $this->db->order_by($sortBy, $orderBy);
        $this->db->order_by("id", "asc");
        $this->db->from(__DBC_SCHEMATA_DONER__);
        $this->db->where($whereAry); 
        $query = $this->db->get();


        if ($query->num_rows() > 0) {
         $row=  $query->result_array();
            return $row[0];
        } else {
            return array();
        }
    } 
    public function getActiveDonorDetailsBySosId($idSos)
    {
        $whereAry = array('sosid' => $idSos,'cocid!='=>'0');
        $this->db->select('*');
        $this->db->from(__DBC_SCHEMATA_DONER__);
        $this->db->where($whereAry); 
        $query = $this->db->get();
       
        if ($query->num_rows() > 0) {
             $row = $query->result_array();
                return $row;
        } else {
            return array();
        }
    } 
    public function getCocFormDetailsByCocId($idcoc)
    {
        $whereAry = array('id' => $idcoc);
        $this->db->select('*');
        $this->db->from(__DBC_SCHEMATA_COC_FORM__);
        $this->db->where($whereAry); 
        $query = $this->db->get();
       
        if ($query->num_rows() > 0) {
             $row = $query->result_array();
                return $row[0];
        } else {
            return array();
        }
    } 
    public function getsosFormDetailsByMultipleClientId($id)
    {
        $whereAry = array('Status'=>'1');
        
        $this->db->where_in('Clientid', $id);
        $this->db->select('*');
        $this->db->from(__DBC_SCHEMATA_SOS_FORM__);
        $this->db->where($whereAry); 
        $query = $this->db->get();
       /*$sql = $this->db->last_query($query);
      echo $sql;*/
        if ($query->num_rows() > 0) {
             $row = $query->result_array();
                return $row;
        } else {
            return array();
        }
    } 
    public function getAllsosFormDetails($searchAry=array())
    {
        $dtStart = (!empty($searchAry['dtStart'])?$this->Order_Model->getSqlFormattedDate($searchAry['dtStart']):'');
        $dtEnd = (!empty($searchAry['dtEnd'])?$this->Order_Model->getSqlFormattedDate($searchAry['dtEnd']):'');
        $franchiseeid = $searchAry['szSearchClRecord2'];
        $this->db->select('*');
        $this->db->from(__DBC_SCHEMATA_MANUAL_CAL__, __DBC_SCHEMATA_SOS_FORM__,'tbl_client',__DBC_SCHEMATA_FRANCHISEE__);
        $this->db->join('ds_sos', 'tbl_manual_calc.sosid = ds_sos.id');
        $this->db->join('tbl_client', 'ds_sos.Clientid = tbl_client.clientId');
        $this->db->join('tbl_franchisee', 'tbl_client.franchiseeId = tbl_franchisee.franchiseeId');
        if(!empty($searchAry['dtStart'])){
            $this->db->where('tbl_manual_calc.dtCreatedOn >=', $dtStart);
            $this->db->where('tbl_manual_calc.dtCreatedOn <=', $dtEnd);
            if($franchiseeid>0){
	            $this->db->where('tbl_client.franchiseeId = ', $franchiseeid);
            }
        }
        $this->db->where('clientType !=', '0');
        $this->db->where('status', '1');
        if($_SESSION['drugsafe_user']['iRole']==5){
         $this->db->where('tbl_franchisee.operationManagerId', $_SESSION['drugsafe_user']['id']);   
        }
         if($_SESSION['drugsafe_user']['iRole']==2){
         $this->db->where('tbl_client.franchiseeId', $_SESSION['drugsafe_user']['id']);   
        }
        $this->db->group_by('tbl_client.franchiseeId');
        $query = $this->db->get();
//        echo $sql = $this->db->last_query();
        //die();
        if ($query->num_rows() > 0) {
             $row = $query->result_array();
                return $row;
        } else {
            return array();
        
        }
    }

    public function getFranchisees($operationManagerId = 0)
    {
        if ($operationManagerId>0) {
            $whereAry = array('frtbl.operationManagerId=' => $operationManagerId, 'user.isDeleted=' => '0', 'iRole' => '2');
        } else {
            $whereAry = array('user.isDeleted=' => '0', 'user.iRole' => '2' );
        }

        $this->db->select('user.id, user.szName, user.abn, user.szEmail, user.szContactNumber, user.userCode, user.szAddress, user.szZipCode, user.szCity, user.regionId, user.szCountry');
        $this->db->from(__DBC_SCHEMATA_USERS__.' as user');
        $this->db->join(__DBC_SCHEMATA_FRANCHISEE__.' as frtbl', 'frtbl.franchiseeId = user.id');
        $this->db->where($whereAry);
        $this->db->order_by('user.szName', 'ASC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array();
        }
    }

    function getsosformdata($siteid, $fromdate, $todate, $status =0)
    {
        $whereAry = 'sos.Clientid =' . (int)$siteid . ' AND sos.Status = '.(int)$status;
        $query = $this->db->select('sos.id, sos.testdate, sos.Clientid, sos.Drugtestid, sos.ServiceCommencedOn, sos.ServiceConcludedOn,
                                                sos.FurtherTestRequired, sos.TotalDonarScreeningUrine, sos.TotalDonarScreeningOral, sos.NegativeResultUrine,
                                                sos.NegativeResultOral, sos.FurtherTestUrine, sos.FurtherTestOral, sos.TotalAlcoholScreening, sos.NegativeAlcohol,
                                                sos.PositiveAlcohol, sos.Refusals, sos.DeviceName, sos.ExtraUsed, sos.BreathTesting, sos.Comments, sos.collsign, sos.ClientRepresentative,
                                                sos.RepresentativeSignature, sos.RepresentativeSignatureTime, sos.Status, sos.lab_form, client.clientType, client.franchiseeId')
            ->from(__DBC_SCHEMATA_SOS_FORM__ . ' as sos')
            ->join(__DBC_SCHEMATA_CLIENT__ . ' as client', 'sos.Clientid = client.clientId')
            ->where($whereAry)
            ->where('sos.testdate >=', $fromdate)
            ->where('sos.testdate <=', $todate)
            ->order_by("sos.testdate","DESC")
            ->get();
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
            return $row;
        } else {
            $this->addError("norecord", "No record found.");
            return false;
        }
    }
     public function getAllsosFormDetailsforClient($searchAry=array())
    {    
         $dtStart = $this->Order_Model->getSqlFormattedDate($searchAry['dtStart']);
          $dtEnd = $this->Order_Model->getSqlFormattedDate($searchAry['dtEnd']);
          if(strtotime($dtStart) > strtotime($dtEnd))
            {
                $this->addError("dtEnd","To Date should be greater than From Date.");
                return false;
            } 
            
           if(empty($searchAry['szSearchClRecord1'])){
           $whereAry = array('tbl_manual_calc.dtCreatedOn >=' => $dtStart,'clientType !='=> '0','tbl_manual_calc.dtCreatedOn <=' =>$dtEnd, 'status=' => '1', 'tbl_client.franchiseeId =' =>$searchAry['szSearchClRecord2']);
           }
            else{
              $whereAry = array('tbl_manual_calc.dtCreatedOn >=' => $dtStart,'clientType !='=>'0','tbl_manual_calc.dtCreatedOn <=' =>$dtEnd, 'status=' => '1', 'tbl_client.franchiseeId =' =>$searchAry['szSearchClRecord2'],'clientType =' => $searchAry['szSearchClRecord1']);    
            }
        
       
        $this->db->select('*');
        $this->db->from(__DBC_SCHEMATA_MANUAL_CAL__, __DBC_SCHEMATA_SOS_FORM__,'tbl_client',__DBC_SCHEMATA_FRANCHISEE__,__DBC_SCHEMATA_USERS__);
        $this->db->join('ds_sos', 'tbl_manual_calc.sosid = ds_sos.id');
        $this->db->join('tbl_client', 'ds_sos.Clientid = tbl_client.clientId');
        $this->db->join('tbl_franchisee', 'tbl_client.franchiseeId = tbl_franchisee.franchiseeId');
        $this->db->join('ds_user', 'tbl_client.clientType = ds_user.id');
       
         $this->db->where($whereAry);   
       
//        $this->db->group_by('tbl_client.franchiseeId');
        $query = $this->db->get();
//    echo $sql = $this->db->last_query(); die();
        if ($query->num_rows() > 0) {
             $row = $query->result_array();
                return $row;
        } else {
            return array();
        
        }
    }
    function getsosformdataForClient($clientid, $fromdate='', $todate='', $status =0,$siteid='')
    { 
        $whereAry = 'client.clientType =' . (int)$clientid . ' AND sos.Status = '.(int)$status;
        $query = $this->db->select('sos.id, sos.testdate, sos.Clientid, sos.Drugtestid, sos.ServiceCommencedOn, sos.ServiceConcludedOn,
                                                sos.FurtherTestRequired, sos.TotalDonarScreeningUrine, sos.TotalDonarScreeningOral, sos.NegativeResultUrine,
                                                sos.NegativeResultOral, sos.FurtherTestUrine, sos.FurtherTestOral, sos.TotalAlcoholScreening, sos.NegativeAlcohol,
                                                sos.PositiveAlcohol, sos.Refusals, sos.DeviceName, sos.ExtraUsed, sos.BreathTesting, sos.Comments, sos.collsign, sos.ClientRepresentative,
                                                sos.RepresentativeSignature, sos.RepresentativeSignatureTime, sos.Status, client.clientType, client.franchiseeId');
             $this->db->from(__DBC_SCHEMATA_SOS_FORM__ . ' as sos');
             $this->db->join(__DBC_SCHEMATA_CLIENT__ . ' as client', 'sos.Clientid = client.clientId');
             $this->db->where($whereAry);
             if(!empty($fromdate)){
              $this->db->where('sos.testdate >=', $fromdate);   
             }
             if(!empty($todate)){
              $this->db->where('sos.testdate <=', $todate);   
             }
             if(!empty($siteid)){
              $this->db->where('sos.Clientid =', $siteid);   
             }
//            ->where('sos.testdate >=', $fromdate)
//            ->where('sos.testdate <=', $todate)
             $this->db->order_by("sos.testdate","DESC");
            $query =  $this->db->get();
//       $sql = $this->db->last_query();
//        print_r($sql);die;
        if ($query->num_rows() > 0) {
             $row = $query->result_array();
                return $row;
        } else {
            $this->addError("norecord", "No record found.");
            return false;
        }
    }
}
?>