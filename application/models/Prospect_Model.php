<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Prospect_Model extends Error_Model
{
    public function __construct()
    {
        parent::__construct();
    }
     function set_szName($value,$field=false,$message=false, $flag = true)
    {
        $this->data['szName'] = $this->validateInput($value, __VLD_CASE_NAME__, $field, $message, false, false, $flag);
    }
    function set_szEmail($value,$field=false,$message=false , $flag = true)
    {
        $this->data['szEmail'] = $this->validateInput($value, __VLD_CASE_EMAIL__, "$field", "$message", false, false, $flag);
    }
    function set_szContactNumber($value,$field=false,$message=false, $flag = true)
    {
        $this->data['szContactNumber'] = $this->validateInput($value, __VLD_CASE_PHONE2__,$field,$message, false, 10, $flag);
    }
    function set_szCity($value, $flag = true)
    {
        $this->data['szCity'] = $this->validateInput($value, __VLD_CASE_NAME__, "szCity", "City", false, false, $flag);
    }
    function set_szNoOfSites($value, $flag = true)
    {
        $this->data['szNoOfSites'] = $this->validateInput($value, __VLD_CASE_NUMERIC__, "szNoOfSites", "No Of Sites", false, false, $flag);
    }
        function set_iFranchiseeId($value, $flag = true)
    {
        $this->data['iFranchiseeId'] = $this->validateInput($value, __VLD_CASE_ANYTHING__, "iFranchiseeId", "Franchisee", false, false, $flag);
    }
    
    function set_szCountry($value, $flag = true)
    {
        $this->data['szCountry'] = $this->validateInput($value, __VLD_CASE_ANYTHING__, "szCountry", "Country", false, false, $flag);
    }

    function set_szZipCode($value, $flag = true)
    {
        $this->data['szZipCode'] = $this->validateInput($value,__VLD_CASE_DIGITS__, "szZipCode", "ZIP/Postal Code", 4,4, $flag);
    }
    function set_abn($value, $flag = true)
    {
           $this->data['abn'] = $this->validateInput($value,__VLD_CASE_DIGITS__, "abn", "ABN",11,11, $flag); 
        
    }
    function set_szAddress($value, $flag = true)
    {
        $this->data['szAddress'] = $this->validateInput($value, __VLD_CASE_ANYTHING__, "szAddress", "Address", false, false, $flag);
    }
      function set_industry($value, $flag = true)
    {
        $this->data['industry'] = $this->validateInput($value, __VLD_CASE_ANYTHING__, "industry", "Industry", false, false, $flag);
    }
     function set_L_G_Channel($value, $flag = true)
    {
        $this->data['L_G_Channel'] = $this->validateInput($value, __VLD_CASE_ANYTHING__, "L_G_Channel", "Lead Generation Channel", false, false, $flag);
    }

    function getAllProspectDetails($franchiseeId='0',$szBusinessName='0',$status='0', $limit = false, $offset = 0)
    {

          if($franchiseeId){
              $franchiseeid  = $franchiseeId; 
          }
         
      if((!empty($szBusinessName)) || (!empty($status )) || (!empty($franchiseeId)))
      {
            $array = 'isDeleted = 0 '.($franchiseeId>0?' AND iFranchiseeId = '.(int)$franchiseeId:'').($status>0?' AND status = '.(int)$status:'').((!empty($szBusinessName))?' AND szBusinessName = '.'"'.$szBusinessName.'"':'') ;   
      }
       else{
       $array = array('isDeleted' => '0');
         }
         if(!empty($limit)){
             $query = $this->db->select('id,iFranchiseeId,szName,szNoOfSites,dt_last_updated_status,L_G_Channel,szCity,szState,szZipCode,abn,szContactMobile,szContactEmail,szContactPhone,industry,szCountry,szAddress,szBusinessName,szEmail,szContactNumber,dtCreatedOn,dtUpdatedOn,status,dt_last_updated_meeting,clientcreated')
                 ->from(__DBC_SCHEMATA_PROSPECT__)
                 ->order_by("dt_last_updated_status","desc")
                 ->limit($limit, $offset)
                 ->where($array)
                 ->get();
         }else{
             $query = $this->db->select('id,iFranchiseeId,szName,szNoOfSites,dt_last_updated_status,L_G_Channel,szCity,szState,szZipCode,abn,szContactMobile,szContactEmail,szContactPhone,industry,szCountry,szAddress,szBusinessName,szEmail,szContactNumber,dtCreatedOn,dtUpdatedOn,status,dt_last_updated_meeting,clientcreated')
                 ->from(__DBC_SCHEMATA_PROSPECT__)
                 ->order_by("dt_last_updated_status","desc")
                 ->where($array)
                 ->get();
         }

        if ($query->num_rows() > 0) {
            $row = $query->result_array();
            return $row;
        } else {
            return false;
        }
    }
    function validateProspectData($data, $arExclude = array(), $idUser=0,$flag='0')
      {
        if (!empty($data)) {
            $this->error = FALSE;
            if($data['szContactEmail']=='N/A')
            {
               $data['szContactEmail']=''; 
            }
            if($data['szContactPhone']=='N/A')
            {
               $data['szContactPhone']=''; 
            }
            if($data['szContactMobile']=='N/A')
            {
               $data['szContactMobile']=''; 
            }
             if($data['abn']=='N/A')
            {
               $data['abn']=''; 
            }
             if($data['szName']=='N/A')
            {
               $data['szName']=''; 
            }
              if($data['szContactNumber']=='N/A')
            {
               $data['szContactNumber']=''; 
            }
             if($data['szEmail']=='N/A')
            {
               $data['szEmail']=''; 
            }
             if($data['szCity']=='N/A')
            {
               $data['szCity']=''; 
            }
             if($data['szAddress']=='N/A')
            {
               $data['szAddress']=''; 
            }
             if($data['szZipCode']=='N/A')
            {
               $data['szZipCode']=''; 
            }
             if($data['szNoOfSites']=='N/A')
            {
               $data['szNoOfSites']=''; 
            }
            if (!in_array('szBusinessName', $arExclude)) $this->set_szName(sanitize_all_html_input(trim($data['szBusinessName'])),"szBusinessName","Business Name",true);
            if (!in_array('abn', $arExclude)) $this->set_abn(sanitize_all_html_input(trim($data['abn'])), false);
            if (!in_array('szName', $arExclude)) $this->set_szName(sanitize_all_html_input(trim($data['szName'])),"szName","Contact Name", false);
            if (!in_array('szEmail', $arExclude)) $this->set_szEmail(sanitize_all_html_input(trim($data['szEmail'])),"szEmail","Primary Email address", false);
            if (!in_array('szContactNumber', $arExclude)) $this->set_szContactNumber(sanitize_all_html_input(trim($data['szContactNumber'])),"szContactNumber","Primary Phone Number", false);
            if (!in_array('szContactEmail', $arExclude)) $this->set_szEmail(sanitize_all_html_input(trim($data['szContactEmail'])),"szContactEmail","Contact Email address", false);
            if (!in_array('szContactPhone', $arExclude)) $this->set_szContactNumber(sanitize_all_html_input(trim($data['szContactPhone'])),"szContactPhone"," Contact Phone Number", false);
            if (!in_array('szContactMobile', $arExclude)) $this->set_szContactNumber(sanitize_all_html_input(trim($data['szContactMobile'])),"szContactMobile","Contact Mobile Number", false);
            if (!in_array('szCity', $arExclude)) $this->set_szCity(sanitize_all_html_input(trim($data['szCity'])), false);
            if (!in_array('L_G_Channel', $arExclude)) $this->set_L_G_Channel(sanitize_all_html_input(trim($data['L_G_Channel'])), true);
            if (!in_array('szNoOfSites', $arExclude)) $this->set_szNoOfSites(sanitize_all_html_input(trim($data['szNoOfSites'])), false); 
            if($flag==2){
                if (!in_array('iFranchiseeId', $arExclude)) $this->set_iFranchiseeId(sanitize_all_html_input(trim($data['iFranchiseeId'])), true);
            }
            if($flag==1){
                if (!in_array('szCountry', $arExclude)) $this->set_szCountry(sanitize_all_html_input(trim($data['szCountry'])), true);   
            }
            if (!in_array('szZipCode', $arExclude)) $this->set_szZipCode(sanitize_all_html_input(trim($data['szZipCode'])), false);
            if (!in_array('szAddress', $arExclude)) $this->set_szAddress(sanitize_all_html_input(trim($data['szAddress'])), false);
            if(!in_array('industry',$arExclude)) $this->set_industry(sanitize_all_html_input(trim($data['industry'])),true);
      
            if($this->error == false )
            {
                 if ($this->checkProspectExists($data['szEmail'], $idUser)) {
                    $this->addError('szEmail', "Someone already registered with entered email address.");
                    return false;
                }
                if ($this->checkBusinessNameExists($data['szBusinessName'],$idUser)) {
                    $this->addError('szBusinessName', "Business Name must be unique.");
                    return false;
                }
               
            }
             
            if ($this->error == true){
            return false; }
            else {
                return true;
            }
        }
        return false;
    
  }
    function insertProspectData($data,$flag='0'){
       
          if(empty($data['iFranchiseeId'])){
             $data['iFranchiseeId']  =  $_SESSION['drugsafe_user']['id'];  
          }
          else{
             $data['iFranchiseeId'] =$data['iFranchiseeId']; 
          }
     
       $date = date('Y-m-d H:i:s');
       if($flag==1){
      
           if($data['dt_last_updated_meeting']=='N/A')
           {
            $meetingDateTime = '0000-00-00 00:00:00';
           }
           else{
           $meetingDateTime = $this->getSqlFormattedDate($data['dt_last_updated_meeting']);    
           }
          
           if($data['industry']== 'Agriculture, Forestry and Fishing'){
                               $value = '1';
                            }
                            if($data['industry']=='Mining'){
                               $value = '2';
                            }
                            if($data['industry']=='Manufacturing'){
                               $value = '3';
                            }
                            if($data['industry']=='Electricity, Gas and Water Supply'){
                               $value = '4';
                            }if($data['industry']=='Construction'){
                               $value = '5';
                            }if($data['industry']=='Wholesale Trade'){
                               $value = '6';
                            }if($data['industry']=='Transport and Storage'){
                               $value = '7';
                            }if($data['industry']=='Communication Services'){
                               $value = '8';
                            }if($data['industry']=='Agriculture, Property and Business Services'){
                               $value = '9';
                            }if($data['industry']=='Agriculture, Government Administration and Defence'){
                               $value = '10';
                            }if($data['industry']=='Education'){
                               $value = '11';
                            }
                            if($data['industry']=='Health and Community Services'){
                               $value = '12';
                            }if($data['industry']=='Other'){
                               $value = '13';
                            }  
                      if($data['status']=="Discovery Meeting") {
                          $status = '2'; 
                      }
                      if($data['status']=="In Progress") {
                          $status = '3'; 
                      }
                      if($data['status']=="Non Convertible") {
                          $status = '4'; 
                      }
                      if($data['status']=="Contact Later") {
                          $status = '5'; 
                      }
                      if($data['status']=="Closed Sale") {
                          $status = '6'; 
                      }  
                     if($data['status']=="Pre Discovery") {
                          $status = '1'; 
                      }
                      if(empty($data['status'])|| ($data['status']=='N/A')) {
                          $status = '1'; 
                         $statusDateTime =$date; 
                      }
                     
                        if($data['dt_last_updated_status']=='N/A')
                       {
                        $statusDateTime = '0000-00-00 00:00:00';
                      
                       }
                       else{
                        $statusDateTime = $this->getSqlFormattedDate($data['dt_last_updated_status']);
                         
                       }  
             
                    if($data['szContactEmail']=='N/A'){
                     $data['szContactEmail'] = '';
                    }  
                    else{
                       $data['szContactEmail'] = $data['szContactEmail'];  
                    }
                     if($data['szContactMobile']=='N/A'){
                     $data['szContactMobile'] = '';
                    }  
                    else{
                       $data['szContactMobile'] = $data['szContactMobile'];  
                    }
                     if($data['szContactPhone']=='N/A'){
                     $data['szContactPhone'] = '';
                    }  
                    else{
                       $data['szContactPhone'] = $data['szContactPhone'];  
                    }
                     if($data['szName']=='N/A'){
                     $data['szName'] = '';
                    }  
                    else{
                       $data['szName'] = $data['szName'];  
                    }
                     if($data['szEmail']=='N/A'){
                     $data['szEmail'] = '';
                    }  
                    else{
                       $data['szEmail'] = $data['szEmail'];  
                    }
                     if($data['szContactNumber']=='N/A'){
                     $data['szContactNumber'] = '';
                    }  
                    else{
                       $data['szContactNumber'] = $data['szContactNumber'];  
                    }
                     if($data['szCountry']=='N/A'){
                     $data['szCountry'] = '';
                    }  
                    else{
                       $data['szCountry'] = $data['szCountry'];  
                    }
                     if($data['abn']=='N/A'){
                     $data['abn'] = '';
                    }  
                    else{
                       $data['abn'] = $data['abn'];  
                    }
                    if($data['szCity']=='N/A'){
                     $data['szCity'] = '';
                    }  
                    else{
                       $data['szCity'] = $data['szCity'];  
                    }
                     if($data['szZipCode']=='N/A'){
                     $data['szZipCode'] = '';
                    }  
                    else{
                       $data['szZipCode'] = $data['szZipCode'];  
                    }
                     if($data['szNoOfSites']=='N/A'){
                     $data['szNoOfSites'] = '';
                    }  
                    else{
                       $data['szNoOfSites'] = $data['szNoOfSites'];  
                    }
                     if($data['szAddress']=='N/A'){
                     $data['szAddress'] = '';
                    }  
                    else{
                       $data['szAddress'] = $data['szAddress'];  
                    }
                $whereAry = array(
                'iFranchiseeId' => (int)$data['iFranchiseeId'],
                'szName' => trim($data['szName']),
                'szEmail' => trim($data['szEmail']),
                'szContactNumber' => trim($data['szContactNumber']),
                'dtCreatedOn' =>$date,
                'dtUpdatedOn' =>$date,
                'isDeleted' =>'0',
                'szCountry' => trim($data['szCountry']),
                'abn' => trim($data['abn']), 
                'szCity' => trim($data['szCity']),
                'szZipCode' => trim($data['szZipCode']),
                'szAddress' => trim($data['szAddress']),
                'szBusinessName' => trim($data['szBusinessName']),
                'szContactEmail' => trim($data['szContactEmail']),
                'szContactPhone' => trim($data['szContactPhone']),
                'szContactMobile' => trim($data['szContactMobile']),
                'industry' => trim($value),
                'status' => trim($status),
                'szCreatedBy' => (int)$_SESSION['drugsafe_user']['id'],
                'szNoOfSites' => trim($data['szNoOfSites']),
                'L_G_Channel' => trim($data['L_G_Channel']),
               'dt_last_updated_meeting' => $meetingDateTime,
               'dt_last_updated_status' => $statusDateTime
            );    
       }
       else{
        $whereAry = array(
                'iFranchiseeId' => (int)$data['iFranchiseeId'],
                'szName' => trim($data['szName']),
                'szEmail' => trim($data['szEmail']),
                'szContactNumber' => trim($data['szContactNumber']),
                'dtUpdatedOn' =>$date,
                'dtCreatedOn' =>$date,
                'isDeleted' =>'0',
                'szCountry' => trim($data['szCountry']),
                'abn' => trim($data['abn']), 
                'szCity' => trim($data['szCity']),
                'szZipCode' => trim($data['szZipCode']),
                'szAddress' => trim($data['szAddress']),
                'szBusinessName' => trim($data['szBusinessName']),
                'szContactEmail' => trim($data['szContactEmail']),
                'szContactPhone' => trim($data['szContactPhone']),
                'szContactMobile' => trim($data['szContactMobile']),
                'szCreatedBy' => (int)$_SESSION['drugsafe_user']['id'],
                'industry' => trim($data['industry']),
                'status' => '1',
                'szNoOfSites' => trim($data['szNoOfSites']),
                'dt_last_updated_status' => $date,
                'L_G_Channel' => trim($data['L_G_Channel'])
            );   
           }
           
            $this->db->insert(__DBC_SCHEMATA_PROSPECT__, $whereAry);
            if (!($this->db->affected_rows() > 0)) {
                $message = "Some error occurred while adding product.";
                array_push($failarr, $message);
                return false;
            }
            else{
                $prospectId = (int)$this->db->insert_id();
                 $whereAry = array(
                'prospectId' => (int)$prospectId,
                'status' => (int)'1',
                'dtUpdatedOn' =>$date,
                'szUpdatedBy' =>(int)$data['iFranchiseeId']
            );
            $this->db->insert(__DBC_SCHEMATA_STATUS__, $whereAry);   
               return true; 
            }
        
    }
    function getProspectDetailsByProspectsId($prospectsId)
    {
        
        $array = array('id' => (int)$prospectsId, 'isDeleted' => '0');
        $query = $this->db->select('id,szName,dt_last_updated_status,L_G_Channel,szNoOfSites,iFranchiseeId,szEmail,szContactNumber,abn,szCity,szCountry,szBusinessName,szContactEmail,szContactPhone,szContactMobile,industry,szZipCode,szAddress,dtCreatedOn,dtUpdatedOn,status')
            ->from(__DBC_SCHEMATA_PROSPECT__)
            ->where($array)
            ->get();
        /*$q = $this->db->last_query();
        echo $q;*/
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
            return $row['0'];
        } else {
            return false;
        }
    }
    public function deleteProspectRecord($prospectId)
    {
       $prospectStatusAry = $this->Prospect_Model->getProspectStatusDetails($idProspect,1);
       if(!empty($prospectStatusAry))
       {
        foreach($prospectStatusAry as $prospectData){
        $this->deleteStatus($prospectData['id']);  
       }      
       }
       $mettingsDetailsSearchAry = $this->Prospect_Model->getAllMeetingDetailsByProspectsId($idProspect);
       if(!empty($mettingsDetailsSearchAry)){
         foreach($mettingsDetailsSearchAry as $meetingData){
        $this->deleteMeeting($meetingData['id']);  
       }   
       }
       
      
        $dataAry = array(
            'isDeleted' => '1'
        );
        $this->db->where('id', $prospectId);
        if ($query = $this->db->update(__DBC_SCHEMATA_PROSPECT__, $dataAry)) {
            return true;
        } else {
            return false;
        }
    }
    function updateProspectDetails($data,$prospectId){
         if(empty($data['iFranchiseeId'])){
             $data['iFranchiseeId']  =  $_SESSION['drugsafe_user']['id'];  
          }
          else{
             $data['iFranchiseeId'] =$data['iFranchiseeId']; 
          }
         $failarr = array();
         $franchiseeid  =  $_SESSION['drugsafe_user']['id'];
         $date = date('Y-m-d H:i:s');
            $dataAry = array(
                'iFranchiseeId' => (int)$data['iFranchiseeId'],
                'szName' => trim($data['szName']),
                'szEmail' => trim($data['szEmail']),
                'szContactNumber' => trim($data['szContactNumber']),
                'szCountry' => trim($data['szCountry']),
                'abn' => trim($data['abn']), 
                'szCity' => trim($data['szCity']),
                'szZipCode' => trim($data['szZipCode']),
                'szAddress' => trim($data['szAddress']),
                'szBusinessName' => trim($data['szBusinessName']),
                'szContactEmail' => trim($data['szContactEmail']),
                'szContactPhone' => trim($data['szContactPhone']),
                'szContactMobile' => trim($data['szContactMobile']),
                'szCreatedBy' => $_SESSION['drugsafe_user']['id'],
                'industry' => trim($data['industry']),
                'dtUpdatedOn' =>$date,
                'szNoOfSites' => trim($data['szNoOfSites']),
                'L_G_Channel' => trim($data['L_G_Channel']) ,
                'isDeleted' =>'0'
            );
         
        $whereAry = array('id' => (int)$prospectId);
     $qyeryUpdate =  $this->db->where($whereAry)
            ->update(__DBC_SCHEMATA_PROSPECT__, $dataAry);
        
         if (!$qyeryUpdate) {
                $message = "Some error occurred while edit prospect.";
                array_push($failarr, $message);
            }
            else{
               return true; 
            }
    }
    function insertMeetingNotes($data,$idProspect){
       
        $date = date('Y-m-d H:i:s');
        $franchiseeid  =  $_SESSION['drugsafe_user']['id'];
            $whereAry = array(
                'idProspect' => (int)$idProspect,
                'szDescription' => trim($data['szDiscription']),
                'dtCreatedOn' => $date,
                'szCreatedBy' => $franchiseeid
            );
          $this->db->insert(__DBC_SCHEMATA_MEETINGS_NOTE__, $whereAry);
            if (!($this->db->affected_rows() > 0)) {
                return false; 
            }
            else{
                $whereAry = array('id' => (int)$idProspect);
                $dataAry = array(
                'dt_last_updated_meeting' => $date
             );
             $qyeryUpdate =  $this->db->where($whereAry)
             ->update(__DBC_SCHEMATA_PROSPECT__, $dataAry);
               return true; 
            }
        
    }
    function getAllMeetingDetailsByProspectsId($prospectsId,$meetingNoteCreatedBy='0', $limit = __PAGINATION_RECORD_LIMIT__, $offset = 0,$flag='')
    { 
       if($meetingNoteCreatedBy > 0){
         $array = array('idProspect' => (int)$prospectsId,'szCreatedBy' => (int)$meetingNoteCreatedBy,);   
       } 
       else{
            $array = array('idProspect' => (int)$prospectsId);
       }
     
       if($flag==1){
          $query = $this->db->select('szCreatedBy')
           ->distinct('szCreatedBy')
            ->from(__DBC_SCHEMATA_MEETINGS_NOTE__)
            ->where($array)
             ->limit($limit, $offset)
            ->order_by("id","desc")
            ->get();
       }
       else{
           $query = $this->db->select('id,szDescription,dtCreatedOn,szCreatedBy')
       
            ->from(__DBC_SCHEMATA_MEETINGS_NOTE__)
            ->where($array)
               ->limit($limit, $offset)
            ->order_by("id","desc")
            ->get(); 
       }
        
//        $q = $this->db->last_query();
//        echo $q; die;
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
            return $row;
        } else {
            return false;
        }
    }
    function getProspectStatusDetails($prospectsId,$flag='0')
    {
         $array = array('prospectId' => (int)$prospectsId);
        if($flag==1){
          $query = $this->db->select('id,status,prospectId,dtUpdatedOn,szUpdatedBy')
            ->from(__DBC_SCHEMATA_STATUS__)
           ->order_by("id","desc")
            ->where($array)
            ->get();
       }
       else{
             $query = $this->db->select('MAX(id)')
            ->from(__DBC_SCHEMATA_STATUS__)
            ->where($array)
            ->get();
       }
      

        if ($query->num_rows() > 0) {
            $row = $query->result_array();
            if($flag==1){
             return $row;    
            }
            else{
              return $row['0'];   
            }
           
        } else {
            return false;
        }
    } 
    function getStatusDetailsByStatusId($statusId)
    {
       
        $array = array('id' => (int)$statusId);
        $query = $this->db->select('id,status,szUpdatedBy,prospectId,dtUpdatedOn')
            ->from(__DBC_SCHEMATA_STATUS__)
            ->where($array)
            ->get();
//      $q = $this->db->last_query();
//        echo $q;
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
            return $row['0'];
        } else {
            return false;
        }
    }
    
    function updateProspectStatus($data,$prospectsId)
    { 
        $date = date('Y-m-d H:i:s');
        $franchiseeid  =  $_SESSION['drugsafe_user']['id'];
            $whereAry = array(
                'prospectId' => (int)$prospectsId,
                'status' => $data['status'],
                'dtUpdatedOn' =>$date,
                'szUpdatedBy' =>$franchiseeid
               
            );
            $this->db->insert(__DBC_SCHEMATA_STATUS__, $whereAry);   
            if (!($this->db->affected_rows() > 0)) {
                $message = "Some error occurred while adding product.";
                array_push($failarr, $message);
            }
            else{
             $dataAry = array(
                'status' => $data['status'],
                'dt_last_updated_status' => $date
           
            ); 
          $whereAry = array('id' => (int)$prospectsId);
          $qyeryUpdate =  $this->db->where($whereAry)
            ->update(__DBC_SCHEMATA_PROSPECT__, $dataAry);
               return true; 
            }
        
    }
    function getMettingDetailsById($Id)
    {
        
       $array = array('id' => (int)$Id);
       $query = $this->db->select('szDescription')
            ->from(__DBC_SCHEMATA_MEETINGS_NOTE__)
            ->where($array)
            ->get();
        /*$q = $this->db->last_query();
        echo $q;*/
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
            return $row['0'];
        } else {
            return false;
        }
    }
    public function checkProspectExists($szEmail = false, $id = 0)
    {

        $szEmail = trim($szEmail);

        $user_session = $this->session->userdata('drugsafe_user');

        if ((empty($szEmail)) && (!empty($user_session))) {
            $user_session = $this->session->userdata('drugsafe_user');
            $szEmail = $user_session['szEmail'];

        }

        if ((int)$id > 0) {
            $result = $this->db->get_where(__DBC_SCHEMATA_PROSPECT__, array('szEmail' => $szEmail, 'id !=' => (int)$id, 'isDeleted !=' => '1'));
        } else {
            $result = $this->db->get_where(__DBC_SCHEMATA_PROSPECT__, array('szEmail' => $szEmail, 'isDeleted !=' => '1'));
        }

        if ($result->num_rows() > 0) {
            return $result;
        } else {
            return false;
        }
    } 
    public function checkBusinessNameExists($szBusinessName = false, $id = 0,$flag='0')
    {
        $szBusinessName = trim($szBusinessName);

    
        if ((int)$id > 0) {
            if($flag==1){
                $result = $this->db->get_where(__DBC_SCHEMATA_PROSPECT__, array('szBusinessName' => $szBusinessName,'id!=' => (int)$id,'isDeleted !=' => '1'));  
            }
            else{
                  $result = $this->db->get_where(__DBC_SCHEMATA_PROSPECT__, array('szBusinessName' => $szBusinessName,'id!=' => (int)$id,'isDeleted !=' => '1'));
            }
          
        } else {
            $result = $this->db->get_where(__DBC_SCHEMATA_PROSPECT__, array('szBusinessName' => $szBusinessName,'isDeleted !=' => '1'));
        }

        if ($result->num_rows() > 0) {
            return $result;
        } else {
            return false;
        }
    } 
    function getSqlFormattedDate($unFormatted_date)
    { 
        $dateAry = explode('at', $unFormatted_date);
        $dateDataAry = explode('/',$dateAry['0']);

        $timeDataAry = explode(':',$dateAry['1']);

        $time1DataAry = explode(' ',$timeDataAry['1']);
       if($time1DataAry=='AM'){
        $formattedDate=trim($dateDataAry['2']).'-'.trim($dateDataAry['1']).'-'.$dateDataAry['0'].' ';  

        }
       else{
           $value =$timeDataAry['0'] ;
           $time = 12+$value;
           $formattedDate=trim($dateDataAry['2']).'-'.trim($dateDataAry['1']).'-'.$dateDataAry['0'].' ';  


       }

       return $formattedDate;  
    }
    public function deleteMeeting($meetingId)
	{   
          
                $this->db->where('id', $meetingId);
		if($query = $this->db->delete(__DBC_SCHEMATA_MEETINGS_NOTE__))
                {
                    return true;
                }
                else
                {
                    return false;
                }	
	}
    public function deleteStatus($prospectId)
   {   
         $this->db->where('prospectId', $prospectId);
		if($query = $this->db->delete(__DBC_SCHEMATA_STATUS__))
                {
                    return true;
                }
                else
                {
                    return false;
                }	
	}
    function getAllProspectDetailsByFrId($franchiseeId)
    {
      
       $array = array('iFranchiseeId' => (int)$franchiseeId, 'isDeleted' => '0');
        
           $query = $this->db->select('id,szName,szCity,szZipCode,abn,szContactMobile,szContactEmail,szContactPhone,industry,szCountry,szAddress,szBusinessName,szEmail,szContactNumber,dtCreatedOn,dtUpdatedOn,status,dt_last_updated_meeting')
            ->from(__DBC_SCHEMATA_PROSPECT__)
           ->order_by("id","desc") 
           ->limit($limit, $offset)
            ->where($array)
            ->get();
    

        if ($query->num_rows() > 0) {
            $row = $query->result_array();
            return $row;
        } else {
            return false;
        }
    }
    public function changeToClient($idProspect)
    {
       $prospectArr = $this->getProspectDetailsByProspectsId($idProspect);
       if(!empty($prospectArr)){
           /*print_r($prospectArr);
           die;*/
           $data['szName'] = $prospectArr['szName'];
           $data['szEmail'] = $prospectArr['szEmail'];
           $prospectArr['szContactNumber'] = $prospectArr['szContactNumber'];
           $data['szCountry'] = $prospectArr['szCountry'];
           $data['abn'] = $prospectArr['abn'];
           $data['szCity'] = $prospectArr['szCity'];
           $data['szZipCode'] = $prospectArr['szZipCode'];
           $data['szAddress'] = $prospectArr['szAddress'];
           $prospectArr['franchiseeId'] = $prospectArr['iFranchiseeId'];
           $data['szBusinessName'] = $prospectArr['szBusinessName'];
           $data['szContactEmail'] = $prospectArr['szContactEmail'];
           $data['szContactPhone'] = $prospectArr['szContactPhone'];
           $data['szContactMobile'] = $prospectArr['szContactMobile'];
           $data['szNoOfSites'] = $prospectArr['szNoOfSites'];
           $data['industry'] = $prospectArr['industry'];
           $prospectArr['discount'] = 0.00;
           $prospectArr['szParentId'] = '';
           if($this->Franchisee_Model->insertClientDetails($prospectArr,$prospectArr['franchiseeId'])){
               $dataAry = array(
                   'clientcreated' => '1'
               );
               $query = $this->db->where('id', $idProspect)
                   ->update(__DBC_SCHEMATA_PROSPECT__, $dataAry);

               if ($query) {
                   return true;
               } else {
                   return false;
               }
           }else{
               return false;
           }
       }
    }
    function getstatusDetailsforDetailedReport($franchiseeid,$startDate,$endDate,$status='0',$szBusinessName='', $limit = __PAGINATION_RECORD_LIMIT__, $offset = 0)
    {  
       
          
           $array =__DBC_SCHEMATA_PROSPECT__ . '.iFranchiseeId = ' . (int)$franchiseeid . ' AND '. __DBC_SCHEMATA_STATUS__ . '.dtUpdatedOn >= '.'"'.$startDate .'00:00:00 " AND ' . __DBC_SCHEMATA_STATUS__ . '.dtUpdatedOn <= '.'"'.$endDate .' 23:59:59"'. (!empty($szBusinessName) ? ' AND ' . __DBC_SCHEMATA_PROSPECT__ . '.szBusinessName = ' .'"'.$szBusinessName.'"':'').(!empty($status) ? ' AND ' . __DBC_SCHEMATA_STATUS__ . '.status = ' .(int)$status:'');
          
           $this->db->select('tbl_prospect_status.status,iFranchiseeId,tbl_prospect_status.dtUpdatedOn,szName,szBusinessName,szEmail,szContactNumber');
           $this->db->from('tbl_prospect_status');
           $this->db->join('tbl_prospect', 'tbl_prospect_status.prospectId = tbl_prospect.id');
           $this->db ->order_by("tbl_prospect_status.dtUpdatedOn","desc") ;
           $this->db->where($array);
           $this->db->limit($limit, $offset);
           $query =  $this->db  ->get();
//       $q = $this->db->last_query();
//       echo $q; die;
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
            return $row;
        } else {
            return array();
        }
    }
    function getAllProspectDetailsByOpId($opId)
    {  
        
         $array = array('isDeleted' => '0','clientcreated'=> '0','operationManagerId'=> (int)$opId);
          
           $this->db->select('tbl_prospect.szBusinessName');
           $this->db->from('tbl_prospect');
           $this->db->join('tbl_franchisee', 'tbl_prospect.iFranchiseeId = tbl_franchisee.franchiseeId');
           $this->db->where($array);
           $query =  $this->db  ->get();

        if ($query->num_rows() > 0) {
            $row = $query->result_array();
            return $row;
        } else {
            return array();
        }
    }
    function getLatestMettingDetailsById($Id,$meatingDate)
    {
        
       $array = array('idProspect' => (int)$Id,'dtCreatedOn' => $meatingDate);
       $query = $this->db->select('szDescription')
            ->from(__DBC_SCHEMATA_MEETINGS_NOTE__)
            ->where($array)
            ->get();
//       $q = $this->db->last_query();
//        echo $q;die;
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
            return $row['0'];
        } else {
            return false;
        }
    }
}
?>