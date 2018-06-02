<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ordering_Model extends Error_Model {
   
    function insertCalulatedData($data)
    {	
        
           $travel = $data['travelHr']*$data['travelBasePrice'];
           $mobileScreen = $data['mobileScreenBasePrice']*$data['mobileScreenHr'];
           $dtCreatedOn=date("Y-m-d");
            
            $dataAry = array(
                                'sosid' => $data['sosid'],
                'other_drug_rrp' => ($data['OtherDrugRRPValue']>0?$data['OtherDrugRRPValue']:0.00),
                                'urineNata' => $data['urineNata'],
                                'nataLabCnfrm' => $data['nataLabCnfrm'],
                                'oralFluidNata'=>$data['oralFluidNata'],
                                'SyntheticCannabinoids' => $data['SyntheticCannabinoids'],
                                'labScrenning' => $data['laboratoryScreening'],
				'RtwScrenning' => $data['RtwScrenning'],
                                'mobileScreenBasePrice'=>$data['DCmobileScreenBasePrice'],
                                'mobileScreenHr' => $data['DCmobileScreenHr'],
                                'travelBasePrice' => $data['travelBasePrice'],
				'travelHr' => $data['travelHr'],
                                'travelType' => $data['travelType'],
                'fcobp' => $data['FCOBasePrice'],
                'fcohr' => $data['FCOHr'],
                'mcbp' => $data['mobileScreenBasePrice'],
                'mchr' => $data['mobileScreenHr'],
                'cobp' => $data['CallOutBasePrice'],
                'cohr' => $data['CallOutHr'],
                'labconf' => $data['laboratoryConfirmation'],
                'cancelfee' => $data['cancellationFee'],
                'dtCreatedOn' => $dtCreatedOn
          
                            );
	$query=    $this->db->insert(__DBC_SCHEMATA_MANUAL_CAL__, $dataAry);
//            $sql = $this->db->last_query($query);
//print_r($sql);die;
            if($this->db->affected_rows() > 0)
            {
//	         $orderingid= (int)$this->db->insert_id();
//                 $this->db->select('*');
//                 $this->db->from(__DBC_SCHEMATA_MANUAL_CAL__)
//                 ->where('id', $orderingid);
//                 $query = $this->db->get();
//                 if ($query->num_rows() > 0) {
//                 $row = $query->result_array();
//                 return $row[0];
//                } else {
//                  return array();
//               }
//           
                return true;
          }
          else
            {
                return false;
            }
        }
     public function getAllChClientDetails($limit = __PAGINATION_RECORD_LIMIT__,$offset = 0,$id=0)
        { 
            
            $whereAry = array('franchiseeId=' => $id,'clientType!='=>'0'); 
           
             $this->db->select('clientId,clientType');
            $this->db->from(__DBC_SCHEMATA_CLIENT__);
            
               $this->db->where($whereAry); 
        
           $this->db->order_by("franchiseeId","asc");
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
        public function getManualCalculationBySosId($sisId = 0)
        {
			
           
            $whereAry = array('sosid' => $this->sql_real_escape_string(trim($sisId)));
            $this->db->select('*');
            $this->db->where($whereAry);
            $query = $this->db->get(__DBC_SCHEMATA_MANUAL_CAL__);
            
            $sql = $this->db->last_query();
            //print_r($sql);die();
            

        if ($query->num_rows() > 0) {
           $row = $query->result_array();
            return $row[0];
        } else {
           return array();
        }
   }
   function updateCalulatedData($data,$manualCalId)
    {	
       $dtUpdatedOn=date('Y-m-d');
        $dataAry = array(
                          
                                 'sosid' => $data['sosid'],
            'other_drug_rrp' => ($data['OtherDrugRRPValue']>0?$data['OtherDrugRRPValue']:0.00),
                                'urineNata' => $data['urineNata'],
                                'nataLabCnfrm' => $data['nataLabCnfrm'],
                                'oralFluidNata'=>$data['oralFluidNata'],
                                'SyntheticCannabinoids' => $data['SyntheticCannabinoids'],
                                'labScrenning' => $data['labScrenning'],
				'RtwScrenning' => $data['RtwScrenning'],
                                'mobileScreenBasePrice'=>$data['mobileScreenBasePrice'],
                                'mobileScreenHr' => $data['mobileScreenHr'],
                                'travelBasePrice' => $data['travelBasePrice'],
				'travelHr' => $data['travelHr'],
                                'travelType' => $data['travelType'],
                'fcobp' => $data['fcobp'],
                'fcohr' => $data['fcohr'],
                'mcbp' => $data['mcbp'],
                'mchr' => $data['mchr'],
                'cobp' => $data['cobp'],
                'cohr' => $data['cohr'],
                'labconf' => $data['labconf'],
                'cancelfee' => $data['cancelfee'],
                'dtUpdatedOn' => $dtUpdatedOn
                
                   );
	$this->db->where('id',(int)$manualCalId);
        $queyUpdate=$this->db->update(__DBC_SCHEMATA_MANUAL_CAL__, $dataAry);
        
        if($queyUpdate)
        { 
            return true;
        }
        else
        {
            return false;
        }
    }
    function getAllDiscounPercentage()
    {
        $query=$this->db->select('*')
                        ->from(__DBC_SCHEMATA_DISCOUNT__)
                        ->get();
         if ($query->num_rows() > 0) {
             $row = $query->result_array();
            return $row;
        }
        return false;
    }
    function getDiscountById($id)
    {
        $query=$this->db->select('*')
                        ->from(__DBC_SCHEMATA_DISCOUNT__)
                        ->where('id',$id)
                        ->get();
         if ($query->num_rows() > 0) {
             $row = $query->result_array();
            return $row['0'];
        }
        return false;
    }
    function insertDiscount($data)
    {
        $dataAry = 
                array(
                        'percentage' => $data['percentage'],
                        'description' => $data['description']
                     );
	$query=    $this->db->insert(__DBC_SCHEMATA_DISCOUNT__, $dataAry);

        if($this->db->affected_rows() > 0){
	    return true;
        }
        else{
            return false;
        }
    }
    function updateDiscount($data,$idDiscount)
    {
        $dataAry = array(
            'percentage' => $data['percentage'],
            'description' => $data['description']
        );
        
        $this->db->where('id',$idDiscount);
        $query=$this->db->update(__DBC_SCHEMATA_DISCOUNT__, $dataAry);
        if ($query) {
            return true;
        } else {
            return false;
        }
    }  
    
     function deleteDiscount($idDiscount)
    {
       
        $this->db->where('id', $idDiscount);
        $query=$this->db->delete(__DBC_SCHEMATA_DISCOUNT__);
      // echo $sql=$this->db->last_query();die();
        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    function getClientDiscountByClientId($clientid)
    {
        $query=$this->db->select('discount.id,discount.percentage,discount.description')
            ->from(__DBC_SCHEMATA_DISCOUNT__.' as discount')
            ->join(__DBC_SCHEMATA_CLIENT__.' as client','client.discountid = discount.id')
            ->where('client.clientId',(int)$clientid)
            ->get();
        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
            return $row['0'];
        }
        return false;
    }
	
	function getAssignedDiscount($discountid)
    {
        $array = __DBC_SCHEMATA_CLIENT__ . '.discountid = '.(int)$discountid.' AND ' . __DBC_SCHEMATA_CLIENT__ . '.clientType = 0 AND ' . __DBC_SCHEMATA_USERS__ . '.iActive = 1  AND ' . __DBC_SCHEMATA_USERS__ . '.isDeleted = 0 ';
        //$array = array(__DBC_SCHEMATA_CLIENT__ . '.franchiseeId' => (int)$franchiseeid, __DBC_SCHEMATA_CLIENT__ . '.clientType' => (int)$parent, __DBC_SCHEMATA_USERS__ . '.isDeleted' => '0');
        $query = $this->db->distinct(__DBC_SCHEMATA_CLIENT__ . '.clientId')			
            ->from(__DBC_SCHEMATA_CLIENT__)
            ->join(__DBC_SCHEMATA_USERS__, __DBC_SCHEMATA_CLIENT__ . '.clientId = ' . __DBC_SCHEMATA_USERS__ . '.id')
            ->where($array)
            ->get();
        /*echo $q;*/
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
            return $row;
        } else {
            $this->addError("usernotexist", "User does not exist.");
            return false;
        }
    }
}
?>