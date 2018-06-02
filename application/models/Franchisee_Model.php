<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Franchisee_Model extends Error_Model
{
    var $id;
    var $szName;
    var $szEmail;
    var $szPassword;
    var $data = array();

    public function __construct()
    {
        parent::__construct();
    }

    function insertClientDetails($data, $franchiseeId = '', $reqppval = 0)
    {
        $szNewPassword = create_login_password();

        $date = date('Y-m-d H:i:s');
        if (!empty($data['abn'])) {
            $abn = trim($data['abn']);
        } else {
            $abn = '';
        }
        $dataAry = array(

            'szName' => trim($data['szName']),
            'szEmail' => trim($data['szEmail']),
            'szPassword' => encrypt($szNewPassword),
            'szContactNumber' => trim($data['szContactNumber']),
            'szCountry' => trim($data['szCountry']),
            'abn' => trim($abn),
            'szCity' => trim($data['szCity']),
            'szZipCode' => trim($data['szZipCode']),
            'szAddress' => trim($data['szAddress']),
            'regionId' => ($data['frtype'] == '1'?(int)$data['szRegionName']:0),
            'iRole' => '3',
            'iActive' => '1',
            'dtCreatedOn' => $date
        );
        $this->db->insert(__DBC_SCHEMATA_USERS__, $dataAry);

        $id_client = (int)$this->db->insert_id();
        $CreatedBy = $_SESSION['drugsafe_user']['id'];

        $clientType = $data['szParentId'];
        if ($clientType == '') {
            $clientType = '0';
        }
        $clientcode = '';
        if (empty($clientType)) {
            $clientlastcode = $this->getmaxClientSiteCodeById($data['franchiseeId']);
            $nextclientcode = 0;
            if (!empty($clientlastcode)) {
                $nextclientcode = (int)$clientlastcode['maxcode'] + 1;
            }
            $usercode = $this->getusercodebyuserid($data['franchiseeId']);
            if (!empty($usercode)) {
                $clientcode = $usercode['userCode'] . '-' . sprintf('%04d', (int)$nextclientcode);
            }
            $clientAry = array(
                'franchiseeId' => $data['franchiseeId'],
                'clientId' => $id_client,
                'clientType' => $clientType,
                'szCreatedBy' => $CreatedBy,
                'szBusinessName' => trim($data['szBusinessName']),
                'szContactEmail' => trim($data['szContactEmail']),
                'szContactPhone' => trim($data['szContactPhone']),
                'szContactMobile' => trim($data['szContactMobile']),
                'szNoOfSites' => trim($data['szNoOfSites']),
                'industry' => trim($data['industry']),
                'clientCode' => (int)$nextclientcode,
                'discountid' => (int)$data['discount']
            );
        } else {
            $clientlastcode = $this->getmaxClientSiteCodeById($data['franchiseeId'], $clientType);
            $nextclientcode = 0;
            if (!empty($clientlastcode)) {
                $nextclientcode = (int)$clientlastcode['maxcode'] + 1;
            }
            $usercode = $this->getusercodebyuserid($clientType);
            if (!empty($usercode)) {
                $clientcode = $usercode['userCode'] . '-Site' . sprintf('%02d', (int)$nextclientcode);
            }
            $clientdets = $this->viewClientDetails($clientType);
            $clientAry = array(
                'franchiseeId' => $data['franchiseeId'],
                'clientId' => $id_client,
                'clientType' => $clientType,
                'szCreatedBy' => $CreatedBy,
                'clientCode' => (int)$nextclientcode,
                'industry' => trim($clientdets['industry'])
            );
        }

        if ($this->db->affected_rows() > 0) {

            $this->db->insert(__DBC_SCHEMATA_CLIENT__, $clientAry);


            if ($this->db->affected_rows() > 0) {
                $id_site = (int)$this->db->insert_id();
                $CodeGen = array('userCode' => $clientcode);
                $this->db->where('id', $id_client);
                $this->db->update(__DBC_SCHEMATA_USERS__, $CodeGen);
                if (empty($clientType)) {
                    $replace_ary = array();
                    $id_player = (int)$this->db->insert_id();
                    $replace_ary['szName'] = trim($data['szName']);
                    $replace_ary['szEmail'] = trim($data['szEmail']);
                    $replace_ary['szPassword'] = $szNewPassword;
                    $replace_ary['supportEmail'] = __CUSTOMER_SUPPORT_EMAIL__;
                    $replace_ary['Link'] = __BASE_URL__ . "/franchisee/addClient";

                    createEmail($this, '__ADD_NEW_CLIENT__', $replace_ary, trim($data['szEmail']), '', __CUSTOMER_SUPPORT_EMAIL__, $id_player, __CUSTOMER_SUPPORT_EMAIL__);

                }
                if (!empty($clientType)) {
                    if (empty($reqppval)) {
                        $reqppval = '';
                    } else {
                        $reqppval = $reqppval;
                    }

                    $siteAry = array(
                        'siteid' => (int)$id_site,
                        'per_form_complete' => trim($data['per_form_complete']),
                        'sp_name' => trim($data['sp_name']),
                        'sp_mobile' => trim($data['sp_mobile']),
                        'sp_email' => trim($data['sp_email']),
                        'iis_name' => trim($data['iis_name']),
                        'iis_mobile' => trim($data['iis_mobile']),
                        'iis_email' => trim($data['iis_email']),
                        'rlr_name' => trim($data['rlr_name']),
                        'rlr_mobile' => trim($data['rlr_mobile']),
                        'rlr_email' => trim($data['rlr_email']),
                        'orlr_name' => trim($data['orlr_name']),
                        'orlr_mobile' => trim($data['orlr_mobile']),
                        'orlr_email' => trim($data['orlr_email']),
                        'psc_name' => trim($data['psc_name']),
                        'psc_phone' => trim($data['psc_phone']),
                        'psc_mobile' => trim($data['psc_mobile']),
                        'ssc_name' => trim($data['ssc_name']),
                        'ssc_phone' => trim($data['ssc_phone']),
                        'ssc_mobile' => trim($data['ssc_mobile']),
                        'instructions' => trim($data['instructions']),
                        'site_people' => trim($data['site_people']),
                        'test_count' => trim($data['test_count']),
                        'initial_testing_req' => trim($data['initial_testing_req']),
                        'ongoing_testing_req' => trim($data['ongoing_testing_req']),
                        'site_visit' => trim($data['site_visit']),
                        'onsite_service' => trim($data['onsite_service']),
                        'start_time' => trim($data['start_time']),
                        'power_access' => trim($data['power_access']),
                        'risk_assessment' => trim($data['risk_assessment']),
                        'req_comp_induction' => trim($data['req_comp_induction']),
                        'randomisation' => trim($data['randomisation']),
                        'req_ppe' => trim($reqppval),
                        'paperwork' => trim($data['paperwork']),
                        'specify_contact' => trim($data['specify_contact']),

                    );
                    $this->db->insert(__DBC_SCHEMATA_SITES__, $siteAry);
                    if ($this->db->affected_rows() > 0) {
                        $replace_ary = array();
                        $id_player = (int)$this->db->insert_id();
                        $replace_ary['szName'] = trim($data['szName']);
                        $replace_ary['szEmail'] = trim($data['szEmail']);
                        $replace_ary['szPassword'] = $szNewPassword;
                        $replace_ary['supportEmail'] = __CUSTOMER_SUPPORT_EMAIL__;
                        $replace_ary['Link'] = __BASE_URL__ . "/franchisee/addClient";

                        createEmail($this, '__ADD_NEW_SITE__', $replace_ary, trim($data['szEmail']), '', __CUSTOMER_SUPPORT_EMAIL__, $id_player, __CUSTOMER_SUPPORT_EMAIL__);


                        return true;
                    } else {
                        return false;
                    }
                }

                return true;
            }
            return false;
        } else {
            return false;
        }
    }

    function getmaxClientSiteCodeById($franchiseeid, $clientid = 0)
    {
        $whereAry = 'franchiseeId = ' . (int)$franchiseeid . ($clientid > 0 ? ' AND clientType = ' . (int)$clientid : '');
        $query = $this->db->select('MAX(clientCode) as maxcode')
            ->from(__DBC_SCHEMATA_CLIENT__)
            ->where($whereAry)
            ->get();
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
            return $row[0];
        } else {
            $this->addError("norecord", "No code found.");
            return false;
        }
    }

    function getusercodebyuserid($userid)
    {
        $whereAry = 'id = ' . (int)$userid;
        $query = $this->db->select('userCode,regionId')
            ->from(__DBC_SCHEMATA_USERS__)
            ->where($whereAry)
            ->get();
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
            return $row[0];
        } else {
            $this->addError("norecord", "No code found.");
            return false;
        }
    }

    public function viewClientList($parent = false, $idfranchisee = 0, $limit = __PAGINATION_RECORD_LIMIT__, $offset = 0, $searchAry = '', $id = 0)
    {
        $whereAry = array('franchiseeId' => $idfranchisee, 'isDeleted=' => '0');
        $searchq = '';
        if ($id > '0') {
            $searchq = array('clientId=' => (int)$id, 'isDeleted=' => '0');
        }
        $this->db->select('*');
        $this->db->from('tbl_client');
        $this->db->join('ds_user', 'tbl_client.clientId = ds_user.id');

        if (!empty($searchq)) {
            $this->db->where($searchq);


        } else {
            $this->db->where($whereAry);
        }
        if ($parent) {
            $this->db->where('clientType', 0);
        }
        $this->db->limit($limit, $offset);
        $query = $this->db->get();
        $s = $this->db->last_query();
//           print_r($s);die;
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array();
        }
    }

    function getfranchiseeagentclients($franchiseeid, $agentid = 0)
    {
        $whereAry = 'user.isDeleted = 0 AND user.iActive = 1 AND client.franchiseeId = ' . (int)$franchiseeid . ($agentid > 0 ? ' AND client.agentId = ' . (int)$agentid : ' AND client.agentId = 0') . ' AND client.clientType = 0';
        $query = $this->db->select('user.id, user.szName, user.abn, user.szEmail, user.szContactNumber, user.szAddress, user.szZipCode, user.szCity, user.userCode, user.szCountry, client.id as agentclientid')
            ->from(__DBC_SCHEMATA_USERS__ . ' as user')
            ->join(__DBC_SCHEMATA_CLIENT__ . ' as client', 'user.id = client.clientId')
            ->where($whereAry)
            ->order_by('user.id', 'DESC')
            ->get();
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
            return $row;
        } else {
            $this->addError("norecord", "No record found.");
            return false;
        }
    }

    public function getAllClientDetails($parent = false, $franchiseId = '', $clientId = '', $limit = __PAGINATION_RECORD_LIMIT__, $offset = 0,$fromdate='',$todate='')
    {   
       
          $array = 'isDeleted = 0 AND clientType = 0 '.($franchiseId>0?' AND franchiseeId = '.(int)$franchiseId:'').(!empty($fromdate)?" AND ds_user.dtCreatedOn >= '".$fromdate." 00:00:00 '":'').(!empty($todate)?" AND ds_user.dtCreatedOn <= '".$todate." 23:59:59'":'').(!empty($clientId)?" AND ds_user.id = '".$clientId."'":'') ;
       
            $this->db->select('*');
            $this->db->from('tbl_client');
            $this->db->join('ds_user', 'tbl_client.clientId = ds_user.id');

                $this->db->where($array);
            //$this->db->group_by('ds_user.szName');
            $this->db->order_by("franchiseeId", "asc");
            $this->db->limit($limit, $offset);
            $query = $this->db->get();
//        
//     $sql = $this->db->last_query($query);
//     print_r($sql);die;
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array();
        }
    }

    public function deleteClient($idClient)
    {
        $childListArr = $this->viewChildClientDetails($idClient, false, false, false);
        if (!empty($childListArr)) {
            foreach ($childListArr as $childlist) {
                $this->deleteClient($childlist['id']);
            }

        }
        $data = $this->input->post('idClient');
        $dataAry = array(
            'isDeleted' => '1'
        );
        $this->db->where('id', $idClient);

        if ($query = $this->db->update(__DBC_SCHEMATA_USERS__, $dataAry)) {
            return true;
        } else {
            return false;
        }
    }

    public function viewChildClientDetails($idClient = 0, $limit = __PAGINATION_RECORD_LIMIT__, $offset = 0, $searchAry = '', $id = 0,$franchiseeid=0,$fromdate='',$todate='')
    {

        $searchq = '';
        if ($id > '0') {
            $searchq = 'clientId = ' . (int)$id.($franchiseeid>0?' AND franchiseeId = '.(int)$franchiseeid:'').(!empty($fromdate)?" AND ds_user.dtCreatedOn >= '".$fromdate." 00:00:00 '":'').(!empty($todate)?" AND ds_user.dtCreatedOn <= '".$todate." 23:59:59'":'');
        }
        else{
         $whereAry = 'clientType = '.$idClient.' AND isDeleted = 0 '.($franchiseeid>0?' AND franchiseeId = '.(int)$franchiseeid:'').(!empty($fromdate)?" AND ds_user.dtCreatedOn >= '".$fromdate." 00:00:00 '":'').(!empty($todate)?" AND ds_user.dtCreatedOn <= '".$todate." 23:59:59'":'');   
        }
        $this->db->select('*');
        $this->db->from('tbl_client');
        $this->db->join('ds_user', 'tbl_client.clientId = ds_user.id');


        if (!empty($searchq)) {
            
            //$whereAry = array('clientType' => $idClient, 'isDeleted=' => '0');
            $this->db->where($searchq);

        } else {
            $this->db->where($whereAry);
        }


        $this->db->limit($limit, $offset);
        $query = $this->db->get();
// $sql = $this->db->last_query($query);
//print_r($sql);die;


        if ($query->num_rows() > 0) {
            $row = $query->result_array();
            return $row;
        } else {
            return array();
        }
    }

    function getParentClientDetails($franchiseeId)
    {
        $whereAry = array('franchiseeId' => $franchiseeId, 'clientType=' => '0', 'isDeleted=' => '0');
        $this->db->select('*');
        $this->db->from(__DBC_SCHEMATA_CLIENT__);
        $this->db->join('ds_user', 'tbl_client.clientId = ds_user.id');
        $this->db->where($whereAry);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    function getOperationManagerId($Id)
    {
        $whereAry = array('franchiseeId' => $Id);
        $this->db->select('operationManagerId');
        $this->db->from(__DBC_SCHEMATA_FRANCHISEE__);
        $this->db->where($whereAry);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $row = $query->result_array();
            return $row[0];
        }
        return false;
    }

    function getClientFranchisee($clientId)
    {
        $whereAry = array('clientId' => $clientId, 'isDeleted=' => '0');
        $this->db->select('*');
        $this->db->from(__DBC_SCHEMATA_CLIENT__);
        $this->db->join('ds_user', 'tbl_client.clientId = ds_user.id');
        $this->db->where($whereAry);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    /*
  * Get User Details By Email or Id
  */

    public function viewClientDetails($idClient)
    {

        $whereAry = array('clientId' => $idClient, 'isDeleted=' => '0');

        $this->db->select('*');
        $this->db->from('tbl_client');
        $this->db->join('ds_user', 'tbl_client.clientId = ds_user.id');


        $this->db->where($whereAry);


        $this->db->where($whereAry);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $row = $query->result_array();
            return $row[0];
        } else {
            return array();
        }
    }

    public function updateClientDetails($idClient = 0, $data, $reqppval)
    {
        $date = date('Y-m-d');
        $dataAry = array(
            'szName' => trim($data['szName']),
            'szEmail' => trim($data['szEmail']),
            'szContactNumber' => trim($data['szContactNumber']),
            'abn' => trim($data['abn']),
            'szCountry' => trim($data['szCountry']),
            'szCity' => trim($data['szCity']),
            'szZipCode' => trim($data['szZipCode']),
            'szAddress' => trim($data['szAddress']),
            'iRole' => '3',
            'iActive' => '1',
            'dtUpdatedOn' => $date
        );
        $whereAry = array('id' => (int)$idClient);
        $this->db->where($whereAry);

        $queyUpdate = $this->db->update(__DBC_SCHEMATA_USERS__, $dataAry);
        $UpdatedBy = $_SESSION['drugsafe_user']['id'];
        if(($data['szEmail'])!= ($data['szOrgEmail'])){
                    $szNewPassword = create_login_password();
                    $franchiseeDetArr = $this->Admin_Model->getAdminDetailsByEmailOrId($UpdatedBy);
                    $replace_ary = array();
                    $id_player = (int)$this->db->insert_id();
                    $replace_ary['szName'] = trim($data['szName']);
                    $replace_ary['szPassword'] = $szNewPassword;
                    $replace_ary['szEmail'] = trim($data['szEmail']);
                    $replace_ary['supportEmail'] = $franchiseeDetArr['szEmail'];
      if (!empty($clientType)) {
                    createEmail($this, '__NEW_EMAIL_FOR_SITE__', $replace_ary, trim($data['szEmail']), '', trim($franchiseeDetArr['szEmail']), $id_player, trim($franchiseeDetArr['szEmail']));
      }
      else{
            createEmail($this, '__NEW_EMAIL_FOR_CLIENT__', $replace_ary,trim($data['szEmail']), '', trim($franchiseeDetArr['szEmail']), $id_player, trim($franchiseeDetArr['szEmail'])); 
      }
                    
            $dataPasswordAry = array(
           'szPassword' => encrypt($szNewPassword)
        );
        $whereAry = array('id' => (int)$idClient);
        $this->db->where($whereAry);
        $queyUpdate = $this->db->update(__DBC_SCHEMATA_USERS__, $dataPasswordAry);              
        }
        if ($idClient == '') {
            $idClient = $_SESSION['drugsafe_user']['id'];
        }
        $clientType = $data['szParentId'];
        if ($clientType == '') {
            $clientType = '0';
        }
        //$clientType= $this->data['clientType'];
        if (empty($clientType)) {
            $clientAry = array(

                'clientType' => $clientType,
                'szLastUpdatedBy' => $UpdatedBy,
                'industry' => $data['industry'],
                'szBusinessName' => trim($data['szBusinessName']),
                'szContactEmail' => trim($data['szContactEmail']),
                'szContactPhone' => trim($data['szContactPhone']),
                'szContactMobile' => trim($data['szContactMobile']),
                'szNoOfSites' => trim($data['szNoOfSites']),
                'discountid' => $data['discount']
            );
        } else {
            $clientAry = array(

                'clientType' => $clientType,
                'szLastUpdatedBy' => $UpdatedBy,

            );
        }

        if ($queyUpdate) {

            $whereAry = array('clientId' => (int)$idClient);
            $this->db->where($whereAry);
            $query = $this->db->update(__DBC_SCHEMATA_CLIENT__, $clientAry);

            if ($query) {
                if (!empty($clientType)) {
                    if ($data['paperwork'] == 2) {
                        $specify_contact = $data['specify_contact'];
                    } else {
                        $specify_contact = ' ';
                    }
                    $siteAry = array(
                        'per_form_complete' => trim($data['per_form_complete']),
                        'sp_name' => trim($data['sp_name']),
                        'sp_mobile' => trim($data['sp_mobile']),
                        'sp_email' => trim($data['sp_email']),
                        'iis_name' => trim($data['iis_name']),
                        'iis_mobile' => trim($data['iis_mobile']),
                        'iis_email' => trim($data['iis_email']),
                        'rlr_name' => trim($data['rlr_name']),
                        'rlr_mobile' => trim($data['rlr_mobile']),
                        'rlr_email' => trim($data['rlr_email']),
                        'orlr_name' => trim($data['orlr_name']),
                        'orlr_mobile' => trim($data['orlr_mobile']),
                        'orlr_email' => trim($data['orlr_email']),
                        'psc_name' => trim($data['psc_name']),
                        'psc_phone' => trim($data['psc_phone']),
                        'psc_mobile' => trim($data['psc_mobile']),
                        'ssc_name' => trim($data['ssc_name']),
                        'ssc_phone' => trim($data['ssc_phone']),
                        'ssc_mobile' => trim($data['ssc_mobile']),
                        'instructions' => trim($data['instructions']),
                        'site_people' => trim($data['site_people']),
                        'test_count' => trim($data['test_count']),
                        'initial_testing_req' => trim($data['initial_testing_req']),
                        'ongoing_testing_req' => trim($data['ongoing_testing_req']),
                        'site_visit' => trim($data['site_visit']),
                        'onsite_service' => trim($data['onsite_service']),
                        'start_time' => trim($data['start_time']),
                        'power_access' => trim($data['power_access']),
                        'risk_assessment' => trim($data['risk_assessment']),
                        'req_comp_induction' => trim($data['req_comp_induction']),
                        'randomisation' => trim($data['randomisation']),
                        'req_ppe' => trim($reqppval),
                        'paperwork' => trim($data['paperwork']),
                        'specify_contact' => trim($specify_contact),

                    );
                    $userDataAry = $this->getClientDetailsId($idClient);

                    $id_site = $userDataAry['id'];

                    $whereAry = array('siteid' => (int)$id_site);
                    $this->db->where($whereAry);
                    $siteUpdate = $this->db->update(__DBC_SCHEMATA_SITES__, $siteAry);

                    if ($siteUpdate) {

                        return true;
                    } else {
                        return false;
                    }
                }
                return true;

            } else {
                return false;
            }
            
        } else {
            return false;
        }
    }

    public function getClientDetailsId($id = 0)
    {
        if ((int)$id > 0) {
            $whereAry = array('clientId' => (int)$id);
        }

        $this->db->select('id');
        $this->db->where($whereAry);
        $query = $this->db->get(__DBC_SCHEMATA_CLIENT__);


        if ($query->num_rows() > 0) {
            $row = $query->result_array();
            return $row[0];
        } else {
            return array();
        }
    }

    public function getUserDetailsByEmailOrId($szEmail = '', $id = 0)
    {
        if ((int)$id > 0 && empty($szEmail)) {
            $whereAry = array('id' => (int)$id);
        } else if ((int)$id == 0 && !empty($szEmail)) {
            $whereAry = array('szEmail' => $this->sql_real_escape_string(trim($szEmail)));
        } else if ((int)$id > 0 && !empty($szEmail)) {
            $whereAry = array('szEmail' => $this->sql_real_escape_string(trim($szEmail)), 'id' => (int)$id);
        }

        $this->db->select('*');
        $this->db->from('tbl_client');
        $this->db->join('ds_user', 'tbl_client.clientId = ds_user.id');
        $this->db->where('ds_user.id', $id);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $row = $query->result_array();
            return $row[0];
        } else {
            return array();
        }
    }

    public function getSiteDetailsById($id = 0)
    {
        if ((int)$id > 0) {
            $whereAry = array('id' => (int)$id);
        }

        $this->db->select('*');
        $this->db->from('ds_sites');
        $this->db->join('tbl_client', 'ds_sites.siteid = tbl_client.id');
        $this->db->join('ds_user', 'tbl_client.clientId = ds_user.id');
        $this->db->where('ds_user.id', $id);

        $query = $this->db->get();
//   $s=$this->db->last_query();
//          print_r($s);die;
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
            return $row[0];
        } else {
            return array();
        }
    }

    public function getOperationManagerDetailsById($id = 0)
    {

        if ((int)$id > 0) {
            $whereAry = array('id' => (int)$id);
        }
        $this->db->select('*');
        $this->db->where($whereAry);
        $query = $this->db->get(__DBC_SCHEMATA_USERS__);

        if ($query->num_rows() > 0) {
            $row = $query->result_array();
            return $row[0];
        } else {
            return array();
        }
    }
    public function getStateByAgentid($agentId = 0)
    {

        $this->db->select('states.id, states.name, agemap.franchiseeid');
        $this->db->from(__DBC_SCHEMATA_AGENT_FRANCHISEE__.' as agemap');

        $this->db->join(__DBC_SCHEMATA_STATE__.' as states', 'states.id = agemap.stateid');
        $this->db->where('agemap.agentid', (int)$agentId);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $row = $query->result_array();
            return $row[0];
        } else {
            return array();
        }
    }
    public function getFranchiseeDetailsByOperationManagerId($id = 0)
    {

        if ((int)$id > 0) {
            $whereAry = array('franchiseeId' => (int)$id);
        }
        $this->db->select('operationManagerId');
        $this->db->where($whereAry);
        $query = $this->db->get(__DBC_SCHEMATA_FRANCHISEE__);

        if ($query->num_rows() > 0) {
            $row = $query->result_array();
            return $row[0];
        } else {
            return array();
        }
    }

    function getClientCountId($franchiseeId)
    {
        $whereAry = array('franchiseeId' => $franchiseeId);
        $this->db->select('id');
        $this->db->from(__DBC_SCHEMATA_CLIENT__);
        $this->db->where($whereAry);
        $query = $this->db->get();
        $s = $this->db->last_query();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    public function getParentClientDetailsId($id = 0)
    {
        if ((int)$id > 0) {
            $whereAry = array('clientId' => (int)$id);
        }

        $this->db->select('clientType');
        $this->db->where($whereAry);
        $query = $this->db->get(__DBC_SCHEMATA_CLIENT__);


        if ($query->num_rows() > 0) {
            $row = $query->result_array();
            return $row[0];
        } else {
            return array();
        }
    }

    function getClientTypeById($clientId)
    {
        $whereAry = array('clientId' => $clientId);
        $this->db->select('clientType');
        $this->db->from(__DBC_SCHEMATA_CLIENT__);
        $this->db->where($whereAry);
        $query = $this->db->get();
        $s = $this->db->last_query();

        if ($query->num_rows() > 0) {
            $row = $query->result_array();
            return $row[0];
        }
        return false;
    }

    function insertAgentDetails($data)
    {
        $szNewPassword = create_login_password();
        $date = date('Y-m-d H:i:s');
        $abn = '';
        if (!empty($data['abn'])) {
            $abn = $data['abn'];
        }
        $dataAry = array(

            'szName' => trim($data['szBusinessName']),
            'szEmail' => trim($data['szEmail']),
            'szPassword' => encrypt($szNewPassword),
            'szContactNumber' => trim($data['szContactNumber']),
            'szCountry' => trim($data['szCountry']),
            'abn' => trim($abn),
            'szCity' => trim($data['szCity']),
            'szZipCode' => trim($data['szZipCode']),
            'szAddress' => trim($data['szAddress']),
            'regionId' => (int)$data['szRegionName'],
            'iRole' => '6',
            'iActive' => '1',
            'dtCreatedOn' => $date
        );
        $this->db->insert(__DBC_SCHEMATA_USERS__, $dataAry);

        $id_agent = (int)$this->db->insert_id();
        $franchiseeId = $_SESSION['drugsafe_user']['id'];

        $clientAry = array(
            'franchiseeid' => $franchiseeId,
            'agentid' => $id_agent,
            'stateid' => (int)$data['szState']
        );

        if ($this->db->affected_rows() > 0) {

            $this->db->insert(__DBC_SCHEMATA_AGENT_FRANCHISEE__, $clientAry);


            if ($this->db->affected_rows() > 0) {
                if (empty($clientType)) {
                    $replace_ary = array();
                    $id_player = (int)$this->db->insert_id();
                    $replace_ary['szName'] = trim($data['szBusinessName']);
                    $replace_ary['szEmail'] = trim($data['szEmail']);
                    $replace_ary['szPassword'] = $szNewPassword;
                    $replace_ary['supportEmail'] = __CUSTOMER_SUPPORT_EMAIL__;

                    createEmail($this, '__ADD_NEW_AGENT__', $replace_ary, trim($data['szEmail']), '', __CUSTOMER_SUPPORT_EMAIL__, $id_player, __CUSTOMER_SUPPORT_EMAIL__);

                }

                return true;
            }
            return false;
        } else {
            return false;
        }
    }

    public function viewAgentDetails($idClient = 0, $limit = __PAGINATION_RECORD_LIMIT__, $offset = 0, $searchAry = '', $id = 0)
    {

        $whereAry = array('clientType' => $idClient, 'isDeleted=' => '0', 'agentId !=' => '0');

        $searchq = '';
        if ($id > '0') {
            $searchq = 'agentId = ' . (int)$id;
        }
        $this->db->select('*');
        $this->db->from('tbl_client');
        $this->db->join('ds_user', 'tbl_client.agentId = ds_user.id');


        if (!empty($searchq)) {
            $whereAry = array('clientType' => $idClient, 'isDeleted=' => '0', 'agentId !=' => '0');
            $this->db->where($searchq);

        } else {
            $this->db->where($whereAry);
        }


        $this->db->limit($limit, $offset);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $row = $query->result_array();
            return $row;
        } else {
            return array();
        }
    }

    public function updateAgentDetails($data, $idAgent)
    {
        $updateAgent = $this->updateUserdata($idAgent, $data);
        if ($updateAgent) {
            if((trim($data['szEmail']))!= (trim($data['szOrgEmail']))){
                $UpdatedBy = $_SESSION['drugsafe_user']['id'];
                    $szNewPassword = create_login_password();
                    $franchiseeDetArr = $this->Admin_Model->getAdminDetailsByEmailOrId($UpdatedBy);
                    $replace_ary = array();
                    $id_player = (int)$this->db->insert_id();
                    $replace_ary['szName'] = trim($data['szName']);
                    $replace_ary['szPassword'] = $szNewPassword;
                    $replace_ary['szEmail'] = trim($data['szEmail']);
                    $replace_ary['supportEmail'] = $franchiseeDetArr['szEmail'];
                    createEmail($this, '__NEW_EMAIL_FOR_AGENT__', $replace_ary, trim($data['szEmail']), '', trim($franchiseeDetArr['szEmail']), $id_player, trim($franchiseeDetArr['szEmail']));
                 
            $dataPasswordAry = array(
           'szPassword' => encrypt($szNewPassword)
        );
        $whereAry = array('id' => (int)$idAgent);
        $this->db->where($whereAry);
        $queyUpdate = $this->db->update(__DBC_SCHEMATA_USERS__, $dataPasswordAry);

        }
                $StateAry = array(
                    'stateid' => $data['szState']
                );
                $whereStateAry = array('agentid' => (int)$idAgent);
                $this->db->where($whereStateAry);
                $queystateUpdate = $this->db->update(__DBC_SCHEMATA_AGENT_FRANCHISEE__, $StateAry);
                if($queystateUpdate){
                    return true;
                }else{
                    return false;
                }

        } else {
            return false;
        }
    }

    function updateUserdata($userid, $dataArr)
    {
        $date = date('Y-m-d H:i:s');
        $recordAry = array(

            'szName' => trim($dataArr['szName']),
            'szEmail' => trim($dataArr['szEmail']),
            'szContactNumber' => trim($dataArr['szContactNumber']),
            'szCountry' => trim($dataArr['szCountry']),
            'abn' => trim($dataArr['abn']),
            'szCity' => trim($dataArr['szCity']),
            'szZipCode' => trim($dataArr['szZipCode']),
            'szAddress' => trim($dataArr['szAddress']),
            'dtUpdatedOn' => $date
        );

        $whereAry = array('id' => (int)$userid, 'isDeleted' => 0);

        $this->db->where($whereAry);

        $queyUpdate = $this->db->update(__DBC_SCHEMATA_USERS__, $recordAry);
        if ($queyUpdate) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteAgent($id_agent)
    {

        $dataAry = array(
            'isDeleted' => '1'
        );
        $this->db->where('id', $id_agent);
        $query = $this->db->update(__DBC_SCHEMATA_USERS__, $dataAry);
        if ($query) {

            return true;
        } else {
            return false;
        }
    }

    public function viewAgentEmployeeDetails($idAgent)
    {

        $whereAry = array('agentId' => $idAgent, 'isDeleted=' => '0');

        $this->db->select('*');
        $this->db->from('tbl_client');
        $this->db->join('ds_user', 'tbl_client.agentId = ds_user.id');

        $this->db->where($whereAry);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $row = $query->result_array();
            return $row[0];
        } else {
            return array();
        }
    }

    function getUserdetails($userid = 0, $isdeleted = 0, $isactive = 1)
    {
        $whereAry = 'isDeleted = ' . $isdeleted . ' AND iActive = ' . $isactive . ($userid > 0 ? ' AND id = ' . (int)$userid : '');
        $query = $this->db->select('id,szName,abn,szEmail,szContactNumber,szAddress,szZipCode,szCity,userCode,reginolId,szCountry,iRole,szIPAddress,dtCreatedOn,dtUpdatedOn')
            ->from(__DBC_SCHEMATA_USERS__)
            ->where($whereAry)
            ->get();
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
            return $row;
        } else {
            $this->addError("norecord", "No record found.");
            return false;
        }
    }

    function getAgentrecord($franchiseeid, $agentId = '0', $agentName = 0)
    {
        $whereAry = 'user.isDeleted = 0 AND user.iActive = 1 AND agent.franchiseeId = ' . (int)$franchiseeid . (!empty($agentName) ? ' AND user.szName = ' . '"' . $agentName . '"' : '') . ($agentId > 0 ? ' AND user.id = ' . (int)$agentId : '');
        $query = $this->db->select('user.id,agent.franchiseeid , user.szName, user.abn, user.szEmail, user.szContactNumber, user.szAddress, user.szZipCode, user.regionId, user.szCity, user.userCode, user.szCountry')
            ->from(__DBC_SCHEMATA_USERS__ . ' as user')
            ->join(__DBC_SCHEMATA_AGENT_FRANCHISEE__ . ' as agent', 'user.id = agent.agentid')
            //->join(__DBC_SCHEMATA_CLIENT__ . ' as client', 'agent.franchiseeid = client.franchiseeId')
            ->group_by('agent.agentid')
            ->where($whereAry)
            ->order_by('user.id', 'DESC')
            ->get();
//      echo $sql=$this->db->last_query(); die();
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
            return $row;
        } else {
            $this->addError("norecord", "No record found.");
            return false;
        }
    }

    function unassignClient($id)
    {
        $recordarr = array(
            'agentId' => 0
        );
        $whereAry = array('id' => (int)$id);
        $this->db->where($whereAry)
            ->update(__DBC_SCHEMATA_CLIENT__, $recordarr);
    }

    public function getAgentData($clientId = '', $id = 0)
    {

        if ($clientId) {
            $this->db->where('clientType', $clientId);
        }
        $this->db->select('*');
        $this->db->from('tbl_client');
        $this->db->join('ds_user', 'tbl_client.agentId = ds_user.id');
        $this->db->where('isDeleted', '0');
        $this->db->where('agentId !=', '0');
        $this->db->order_by("clientType", "asc");
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $row = $query->result_array();
            return $row;
        } else {
            return array();
        }

    }

    public function getAgentDataById($agentId)
    {
        ;
        $this->db->select('*');
        $this->db->from(__DBC_SCHEMATA_CLIENT__);
        $this->db->where('agentId', $agentId);
        // echo $sql=$this->db->last_query(); die();
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $row = $query->result_array();
            return $row[0];
        } else {
            return array();
        }
    }

    public function assignAgentClient($data, $idAgent)
    {
        $wherearr = array('clientId' => $data['szClient'], 'franchiseeId' => $data['franchiseeId']);
        $dataAry = array('agentId' => $idAgent);
        $this->db->where($wherearr);
        $queyUpdate = $this->db->update(__DBC_SCHEMATA_CLIENT__, $dataAry);
        if ($queyUpdate) {
            return true;
        } else {
            return false;
        }
    }

    function getStateByFranchiseeId($id)
    {
        $query = $this->db->select('regionId')
            ->where('id', $id)
            ->from(__DBC_SCHEMATA_USERS__)
            ->get();
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
            $getRegionDetails = $this->Admin_Model->getstateIdByResinolId($row['0']['regionId']);
            if (!empty($getRegionDetails)) {
                $getStateDetails = $this->Admin_Model->getStateById($getRegionDetails['stateId']);
                return $getStateDetails;
            }
        } else {
            return array();
        }

    }

    function getdistinctAgentrecord($franchiseeid, $agentName = 0)
    {
        $whereAry = 'user.isDeleted = 0 AND user.iActive = 1 AND agent.franchiseeId = ' . (int)$franchiseeid . (!empty($agentName) ? ' AND user.szName = ' . $agentName : '');
        $query = $this->db->select('user.szName')
            ->distinct('user.szName')
            ->from(__DBC_SCHEMATA_USERS__ . ' as user')
            ->join(__DBC_SCHEMATA_AGENT_FRANCHISEE__ . ' as agent', 'user.id = agent.agentid')
            //->join(__DBC_SCHEMATA_CLIENT__ . ' as client', 'agent.franchiseeid = client.franchiseeId')
            ->group_by('agent.agentid')
            ->where($whereAry)
            ->order_by('user.id', 'DESC')
            ->get();

//        echo $sql=$this->db->last_query(); die();
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
            return $row;
        } else {
            $this->addError("norecord", "No record found.");
            return false;
        }
    }

    function getNonCorpFranchisee($regionId = 0)
    {
        $wherestr = 'iRole = 2 AND franchiseetype = 0 AND iActive = 1 AND isDeleted = 0'.($regionId>0?' AND regionId = '.(int)$regionId:'');
        $query = $this->db->select('*')
            ->where($wherestr)
            ->from(__DBC_SCHEMATA_USERS__)
            ->get();
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
            return $row;
        } else {
            return array();
        }
    }

    function MapClientToFranchisee($clientid, $corpfranchisee, $franchiseeid)
    {

        $flag = false;
        $checkClientMappedOrNotArr = $this->getMappedNonCorpFranchisee($clientid, $corpfranchisee);
        if (!empty($checkClientMappedOrNotArr)) {
            $updateWhere = 'clientid = ' . (int)$clientid . ' AND corpfrid = ' . (int)$corpfranchisee;
            $dataAry = array('franchiseeid' => $franchiseeid);
            $this->db->where($updateWhere);
            $queyUpdate = $this->db->update(__DBC_SCHEMATA_CORP_FRANCHISEE_MAPPING__, $dataAry);
            if ($queyUpdate) {
                $flag = true;
            } else {
                $flag = false;
            }
        } else {
            $dataAry = array('franchiseeid' => $franchiseeid,
                'corpfrid' => $corpfranchisee,
                'clientid' => $clientid);
            $this->db->insert(__DBC_SCHEMATA_CORP_FRANCHISEE_MAPPING__, $dataAry);
            if ($this->db->affected_rows() > 0) {
                $flag = true;
            } else {
                $flag = false;
            }
        }
        if ($flag) {
            return true;
        } else {
            return false;
        }

        /*$getcorpDets = $this->getdetailsbyfrisandsiteid($corpfranchisee,$clientid);
        if(!empty($getcorpDets)){
            $getParentcorpDets = $this->getdetailsbyfrisandsiteid($corpfranchisee,$getcorpDets['clientType']);
            if(!empty($getParentcorpDets)){
                $clientAry = array(
                    'franchiseeId' => $franchiseeid,
                    'clientId' => $getcorpDets['clientType'],
                    'agentId' => $getParentcorpDets['agentId'],
                    'clientType' => $getParentcorpDets['clientType'],
                    'szCreatedBy' => $getParentcorpDets['szCreatedBy'],
                    'szBusinessName' => $getParentcorpDets['szBusinessName'],
                    'szContactEmail' => $getParentcorpDets['szContactEmail'],
                    'szContactPhone' => $getParentcorpDets['szContactPhone'],
                    'szContactMobile' => $getParentcorpDets['szContactMobile'],
                    'szNoOfSites' => '0',
                    'industry' => $getParentcorpDets['industry'],
                    'clientCode' => (int)$getParentcorpDets['clientCode'],
                    'discountid' => (int)$getParentcorpDets['discountid'],
                    'szLastUpdatedBy' => $corpfranchisee
                );
                $siteAry = array(
                    'franchiseeId' => $franchiseeid,
                    'clientId' => $clientid,
                    'agentId' => $getcorpDets['agentId'],
                    'clientType' => $getcorpDets['clientType'],
                    'szCreatedBy' => $getcorpDets['szCreatedBy'],
                    'szBusinessName' => $getcorpDets['szBusinessName'],
                    'szContactEmail' => $getcorpDets['szContactEmail'],
                    'szContactPhone' => $getcorpDets['szContactPhone'],
                    'szContactMobile' => $getcorpDets['szContactMobile'],
                    'szNoOfSites' => $getcorpDets['szNoOfSites'],
                    'industry' => $getcorpDets['industry'],
                    'clientCode' => (int)$getcorpDets['clientCode'],
                    'discountid' => (int)$getcorpDets['discountid'],
                    'szLastUpdatedBy' => $corpfranchisee
                );
                //$data = array($clientAry,$siteAry);
                $CheckClientExixstArr = $this->getdetailsbyfrisandsiteid($franchiseeid, $getcorpDets['clientType']);
                if(!empty($CheckClientExixstArr)){
                    $q = true;
                }else{
                    $q = $this->db->insert(__DBC_SCHEMATA_CLIENT__, $clientAry);
                }
                if($q){
                    $this->db->insert(__DBC_SCHEMATA_CLIENT__, $siteAry);
                    if($this->db->affected_rows() > 0) {
                        $siteid = $this->db->insert_id();
                        $oldsitedetarr = $this->getdetailsbyfrisandsiteid($corpfranchisee, $clientid);
                        if (!empty($oldsitedetarr)) {
                            $updatearr = array('siteid' => (int)$siteid);
                            $whereAry = array('siteid' => (int)$oldsitedetarr['id']);
                            $this->db->where($whereAry)
                                ->update(__DBC_SCHEMATA_SITES__, $updatearr);
                            if ($this->db->affected_rows() > 0) {
                                $whereAry = 'clientId =' . (int)$clientid . ' AND franchiseeId = ' . (int)$corpfranchisee;
                                $query = $this->db->where($whereAry)
                                    ->delete(__DBC_SCHEMATA_CLIENT__);
                                if ($query) {
                                    return true;
                                } else {
                                    return false;
                                }
                            }
                        } else {
                            return false;
                        }
                    }
                }
            }

        }*/

    }

    function moveSite($franchiseeid,$clientid,$corpfranchisee,$getcorpDets){
        $clientAry1 = array(
            'franchiseeId' => $franchiseeid,
            'clientId' => $clientid,
            'agentId' => $getcorpDets['agentId'],
            'clientType' => $getcorpDets['clientType'],
            'szCreatedBy' => $getcorpDets['szCreatedBy'],
            'szContactEmail' => $getcorpDets['szContactEmail'],
            'szContactPhone' => $getcorpDets['szContactPhone'],
            'szContactMobile' => $getcorpDets['szContactMobile'],
            'szNoOfSites' => $getcorpDets['szNoOfSites'],
            'industry' => $getcorpDets['industry'],
            'clientCode' => (int)$getcorpDets['clientCode'],
            'discountid' => (int)$getcorpDets['discountid'],
            'szLastUpdatedBy' => $corpfranchisee
        );
        $q2 = $this->db->insert(__DBC_SCHEMATA_CLIENT__, $clientAry1);
         echo '2------<br />';
            echo $this->db->last_query();
        if($q2){
            $whereAry = 'clientId =' . (int)$clientid.' AND franchiseeId = '.(int)$franchiseeid;
            $query = $this->db->where($whereAry)
                ->delete(__DBC_SCHEMATA_CLIENT__);
           /* echo '3------<br />';
            echo $this->db->last_query();*/
            if ($query) {
                return true;
            } else {
                return false;
            }
        }
    }

    function getdetailsbyfrisandsiteid($frid,$clid){
        $wherestr = 'clientid = ' . (int)$clid . ' AND franchiseeId = ' . (int)$frid;
        $query = $this->db->select('*')
            ->where($wherestr)
            ->from(__DBC_SCHEMATA_CLIENT__)
            ->get();
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
            return $row[0];
        } else {
            return array();
        }
    }

    function getMappedNonCorpFranchisee($clientid, $corpfranchiseeid)
    {
        $wherestr = 'corpclient.clientid = ' . (int)$clientid . ' AND corpclient.corpfrid = ' . (int)$corpfranchiseeid;
        $query = $this->db->select('corpclient.id, corpclient.franchiseeid')
            ->where($wherestr)
            ->from(__DBC_SCHEMATA_CORP_FRANCHISEE_MAPPING__.' as corpclient')
            ->join(__DBC_SCHEMATA_USERS__ . ' as user', 'user.id = corpclient.clientid')
            ->get();
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
            return $row;
        } else {
            return array();
        }
    }

    function switchClientFranchisee($clientid, $franchiseeid)
    {
        $updateWhere = 'clientId = ' . (int)$clientid;
        $dataAry = array('franchiseeId' => $franchiseeid);
        $this->db->where($updateWhere);
        $queyUpdate = $this->db->update(__DBC_SCHEMATA_CLIENT__, $dataAry);
        if ($queyUpdate) {
            return true;
        } else {
            return false;
        }
    }

    function getMappedFranchisees($franchiseeid)
    {
        $wherestr = 'corpfrid = ' . (int)$franchiseeid;
        $query = $this->db->select('*')
            ->where($wherestr)
            ->from(__DBC_SCHEMATA_CORP_FRANCHISEE_MAPPING__ . ' as corpfr')
            ->get();
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
            return $row;
        } else {
            return array();
        }
    }

    function getDiscountList($discountid = 0)
    {
        if ($discountid > 0) {
            $wherestr = 'id = ' . (int)$discountid;
        }
        $this->db->select('*');
        $this->db->from(__DBC_SCHEMATA_DISCOUNT__);
        if ($discountid > 0) {
            $this->db->where($wherestr);
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
            return $row;
        } else {
            return array();
        }
    }

 
       function getAllDistinctClientDetails($parent = false,$franchiseeid)
    {
        $whereAry = 'ds_user.isDeleted = 0 AND tbl_client.clientType = 0 AND tbl_client.franchiseeId = ' .(int)$franchiseeid ;
        $query = $this->db->select('ds_user.szName')
            ->distinct('ds_user.szName')
            ->from('tbl_client')
           ->join('ds_user', 'tbl_client.clientId = ds_user.id')
            ->where($whereAry)
            ->order_by('ds_user.id', 'DESC')
            ->get();

//        echo $sql=$this->db->last_query(); die();
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
            return $row;
        } else {
            $this->addError("norecord", "No record found.");
            return false;
        }
    }
     public function getfranchiseeagent($agentId)
    {

        if ((int)$agentId > 0) {
            $whereAry = array('agentid' => (int)$agentId);
        } 
        $this->db->select('*');
        $this->db->where($whereAry);
        $query = $this->db->get(__DBC_SCHEMATA_AGENT_FRANCHISEE__);

        if ($query->num_rows() > 0) {
            $row = $query->result_array();
            return $row[0];
        } else {
            return array();
        }
    }

     public function ChangeAgentPassword($password,$agentId)
    {
        $dataAry = array(
            'szPassword' => encrypt($password),
            'dtUpdatedOn' => date('Y-m-d H:i:s')
        );

        $whereAry = array('id ' => (int)$agentId);

        $this->db->where($whereAry);

        $this->db->update(__DBC_SCHEMATA_USERS__, $dataAry);


        if ($this->db->affected_rows() > 0) {
             $agentDetArr = $this->Admin_Model->getAdminDetailsByEmailOrId('', $agentId);
             $franchiseeArr = $this->getfranchiseeagent($agentId);
             $franchiseeDetArr = $this->Admin_Model->getAdminDetailsByEmailOrId('',$franchiseeArr['franchiseeid']);
             
                    $replace_ary = array();
                    $replace_ary['szName'] = $agentDetArr['szName'];
                    $replace_ary['szEmail'] = $agentDetArr['szEmail'];
                    $replace_ary['szPassword'] = $password;
                    $replace_ary['supportEmail'] = $franchiseeDetArr['szEmail'];

                    createEmail($this, '__NEW_PASSWORD_FOR_AGENT/EMP__', $replace_ary, $agentDetArr['szEmail'], '', __CUSTOMER_SUPPORT_EMAIL__, $id_player, __CUSTOMER_SUPPORT_EMAIL__);

            return true;
        } else {
            return false;
        }

    }

    function unassignSite($mapid){
        $whereAry = 'id =' . (int)$mapid;
        $query = $this->db->where($whereAry)
            ->delete(__DBC_SCHEMATA_CORP_FRANCHISEE_MAPPING__);
        if ($query) {
            return true;
        } else {
            return false;
        }
    }
    function getDiscountByDisId($discountid = 0)
    {
        $wherestr = 'id = ' . (int)$discountid;
        $this->db->select('*');
        $this->db->from(__DBC_SCHEMATA_DISCOUNT__);
        $this->db->where($wherestr);
       
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
            return $row['0'];
        } else {
            return array();
        }
    }

}
?>