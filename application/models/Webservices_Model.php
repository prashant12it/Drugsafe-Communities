<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Webservices_Model extends Error_Model
{

    public function __construct()
    {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        parent::__construct();
    }

    function validateuser($data)
    {
        $this->set_szEmail(sanitize_all_html_input(trim($data['szEmail'])), 'szEmail', 'Email Address', true);
        $this->set_szPassword(sanitize_all_html_input(trim($data['szPassword'])), true);
        if ($this->error) {
            return false;
        } else {
            if ($this->checkUserExist($data['szEmail'])) {
                if ($data['szrole'] == 'fr') {
                    $role = "`iRole` = '2'";
                } elseif ($data['szrole'] == 'ag') {
                    $role = "`iRole` = '6'";
                } else {
                    $role = "(`iRole` = '3'
                    OR `iRole` = '4')";
                }
                $where = "szEmail='" . $data['szEmail'] . "' AND `szPassword` = '" . encrypt($data['szPassword']) . "' AND " . $role . " AND isDeleted = 0 AND iActive = 1";
                //$whereAry = array('szEmail' => $data['szEmail'], 'szPassword' => encrypt($data['szPassword']),'iRole' => $role, 'isDeleted' => 0);
                $query = $this->db->select('id, szName, szEmail, iRole')
                    ->from(__DBC_SCHEMATA_USERS__)
                    ->where($where)
                    ->get();
                if ($query->num_rows() > 0) {
                    $row = $query->result_array();

                    $userAry['id'] = $row[0]['id'];
                    $userAry['szName'] = $row[0]['szName'];
                    $userAry['szEmail'] = $row[0]['szEmail'];
                    $userAry['iRole'] = $row[0]['iRole'];
                    return $userAry;
                } else {
                    $this->addError("szPassword", "Wrong credentials. Please try again.");
                    return false;
                }
            } else {
                return false;
            }

        }

    }

    function set_szEmail($value, $field = false, $message = false, $flag = true)
    {
        $this->data['szEmail'] = $this->validateInput($value, __VLD_CASE_EMAIL__, $field, $message, false, false, $flag);
    }

    function set_szPassword($value, $flag = true)
    {
        $this->data['szPassword'] = $this->validateInput($value, __VLD_CASE_ANYTHING__, "szPassword", "Password", false, false, $flag);
    }

    function checkUserExist($emailid)
    {
        $whereAry = array('szEmail' => trim($emailid), 'isDeleted' => 0);
        $query = $this->db->select('szEmail')
            ->from(__DBC_SCHEMATA_USERS__)
            ->where($whereAry)
            ->get();
        if ($query->num_rows() > 0) {
            return true;
        } else {
            $this->addError("szEmail", "You are not registered with us.");
            return false;
        }
    }

    function getclientdetails($franchiseeid, $parent = 0, $agent = 0, $site = 0,$fromDate='',$todate='')
    { 
        $array = 'client.franchiseeId = ' . (int)$franchiseeid . ' AND user.isDeleted = 0 ' . ($agent > 0 && $parent == 0 ? ' AND client.agentId = ' . (int)$agent : ($agent > 0 && $parent > 0 ? ' AND client.clientType = ' . (int)$parent : ' AND client.clientType = ' . (int)$parent) . ($site > 0 ? ' AND client.clientId = ' . (int)$site : ''))
        .(!empty($fromDate)?" AND user.dtCreatedOn >= '".$fromDate." 00:00:00 '":'').(!empty($todate)?" AND user.dtCreatedOn <= '".$todate." 23:59:59'":'');
        $query = $this->db->select('user.id, user.szName, user.szEmail, client.franchiseeId,client.industry, user.szContactNumber, client.szCreatedBy, client.szLastUpdatedBy, client.szLastUpdatedBy, client.clientType,
                                    client.szBusinessName, client.szContactEmail, client.szContactMobile, client.discountid, client.szContactPhone, user.szCity, user.szCountry, user.abn,
                                    user.szAddress, user.szZipCode,user.dtCreatedOn')
            ->from(__DBC_SCHEMATA_USERS__ . ' as user')
            ->join(__DBC_SCHEMATA_CLIENT__ . ' as client', 'client.clientId = user.id')
            ->where($array)
            ->get();
       /* $q = $this->db->last_query();
        echo $q;*/
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
            return $row;
        } else {
            $this->addError("usernotexist", "User does not exist.");
            return false;
        }
    }

    function getcorpclientdetails($franchiseeid = 0, $corpFranchisee = 0)
    {
        $array = 'user.isDeleted = 0 ' . ($franchiseeid > 0 ? ' AND corpfranch.franchiseeId = ' . (int)$franchiseeid : '') . ($corpFranchisee > 0 ? ' AND corpfranch.corpfrid = ' . (int)$corpFranchisee : '') .' AND user.iActive = 1';
        $query = $this->db->select('user.id, user.szName, user.szEmail, corpfranch.clientid, corpfranch.corpfrid')
            ->from(__DBC_SCHEMATA_USERS__ . ' as user')
            ->join(__DBC_SCHEMATA_CORP_FRANCHISEE_MAPPING__ . ' as corpfranch', 'corpfranch.franchiseeid = user.id')
            ->where($array)
            ->get();
         /*$q = $this->db->last_query();
        echo $q;*/
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
            /*$CorpCl = array();
            if(!empty($row)){
                foreach ($row as $data){
                    $parentClient = $this->getclientdetailsbyclientid($data['clientid']);
                    if(!in_array($parentClient,$CorpCl)){
                        array_push($CorpCl,$parentClient);
                    }
                }
            }*/
            return $row;
        } else {
            $this->addError("usernotexist", "User does not exist.");
            return false;
        }
    }

    function getsossitesbyfranchiseeid($clientid = 0)
    {
        $array = array('Clientid' => (int)$clientid, 'Status' => '0');
        $query = $this->db->select('id')
            ->from(__DBC_SCHEMATA_SOS_FORM__)
            ->where($array)
            ->get();
        /*$q = $this->db->last_query();
        echo $q;*/
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
            return $row;
        } else {
            return false;
        }
    }

    function addsosdata($data)
    {
        $data['testdate'] = $this->formatdate($data['sosdate']);
        if ($data['status'] == '1' || $data['cocstat'] == '1') {
            $drgtestitemcount = strlen($data['drugtest']);
            $alc = false;
            $oral = false;
            $urine = false;
            $UZ = false;
            if ($drgtestitemcount == 1) {
                if ($data['drugtest'] == '1') {
                    $alc = true;
                } elseif ($data['drugtest'] == '2') {
                    $oral = true;
                } elseif ($data['drugtest'] == '3') {
                    $urine = true;
                } elseif ($data['drugtest'] == '4') {
                    $UZ = true;
                }
            } elseif ($drgtestitemcount > 1) {
                $drgtestarr = explode(',', $data['drugtest']);
                foreach ($drgtestarr as $key => $value) {
                    if ($value == '1') {
                        $alc = true;
                    } elseif ($value == '2') {
                        $oral = true;
                    } elseif ($value == '3') {
                        $urine = true;
                    } elseif ($value == '4') {
                        $UZ = true;
                    }
                }
            }
            $this->set_fieldReq(sanitize_all_html_input(trim($data['testdate'])), 'testdate', 'Date', true, __VLD_CASE_DATE__);
            $this->set_fieldReq(sanitize_all_html_input(trim($data['site'])), 'site', 'Site', true);
            $this->set_fieldReq(sanitize_all_html_input(trim($data['drugtest'])), 'drugtest', 'Drug to be tested', true);
            $this->set_fieldReq(sanitize_all_html_input(trim($data['other_drug_test'])), 'othertest', 'Other Test Name', ($data['otherTestCheck']?true:false));
            $this->set_fieldReq(sanitize_all_html_input(trim($data['screenfacility'])), 'screenfacility', 'Screening Facilities', true);
            $this->set_fieldReq(sanitize_all_html_input(trim($data['start_km'])), 'startkm', 'Start(km)', false,__VLD_CASE_DECIMAL__);
            $this->set_fieldReq(sanitize_all_html_input(trim($data['end_km'])), 'endkm', 'End(km)', false,__VLD_CASE_DECIMAL__);
            $this->set_fieldReq(sanitize_all_html_input(trim($data['total_km'])), 'totalkm', 'Total(km)', false,__VLD_CASE_DECIMAL__);
            $this->set_fieldReq(sanitize_all_html_input(trim($data['servicecomm'])), 'servicecomm', 'Service commenced', true);
            $this->set_fieldReq(sanitize_all_html_input(trim($data['servicecon'])), 'servicecon', 'Service concluded', true);
            $this->set_fieldReq(sanitize_all_html_input(trim($data['totscreenu'])), 'totscreenu', 'Total Donor Screenings/Collections Urine', ($urine || $UZ ? true : false), __VLD_CASE_DIGITS__);
            $this->set_fieldReq(sanitize_all_html_input(trim($data['totscreeno'])), 'totscreeno', 'Total Donor Screenings/Collections Oral', $oral, __VLD_CASE_DIGITS__);
            $this->set_fieldReq(sanitize_all_html_input(trim($data['negresu'])), 'negresu', 'Negative Results Urine', ($urine || $UZ ? true : false), __VLD_CASE_DIGITS__);
            $this->set_fieldReq(sanitize_all_html_input(trim($data['negreso'])), 'negreso', 'Negative Results Oral', $oral, __VLD_CASE_DIGITS__);
            $this->set_fieldReq(sanitize_all_html_input(trim($data['furtestu'])), 'furtestu', 'Results Requiring Further Testing Urine', ($urine || $UZ ? true : false), __VLD_CASE_DIGITS__);
            $this->set_fieldReq(sanitize_all_html_input(trim($data['furtesto'])), 'furtesto', 'Results Requiring Further Testing Oral', $oral, __VLD_CASE_DIGITS__);
            $this->set_fieldReq(sanitize_all_html_input(trim($data['totalcscreen'])), 'totalcscreen', 'Total No Alcohol Screen', $alc, __VLD_CASE_DIGITS__);
            $this->set_fieldReq(sanitize_all_html_input(trim($data['negalcres'])), 'negalcres', 'Negative Alcohol Results', $alc, __VLD_CASE_DIGITS__);
            $this->set_fieldReq(sanitize_all_html_input(trim($data['posalcres'])), 'posalcres', 'Positive Alcohol Results', $alc, __VLD_CASE_DIGITS__);
            $this->set_fieldReq(sanitize_all_html_input(trim($data['refusals'])), 'refusals', 'Refusals', true, __VLD_CASE_DIGITS__);
            $this->set_fieldReq(sanitize_all_html_input(trim($data['devicename'])), 'devicename', 'Device Name', false);
            $this->set_fieldReq(sanitize_all_html_input(trim($data['extraused'])), 'extraused', 'Extra Used', false);
            $this->set_fieldReq(sanitize_all_html_input(trim($data['breathtest'])), 'breathtest', 'Breath Testing Unit', false);
            $this->set_fieldReq(sanitize_all_html_input(trim($data['sign1'])), 'sign1', 'Collector Signature', true);
            //$this->set_fieldReq(sanitize_all_html_input(trim($data['collsign'])), 'collsign', 'Collector Signature', true);
            $this->set_fieldReq(sanitize_all_html_input(trim($data['nominated'])), 'nominated', 'Nominated Client Representative', true, __VLD_CASE_NAME__);
            $this->set_fieldReq(sanitize_all_html_input(trim($data['nominedec'])), 'nominedec', 'Nominated Client Representative signature time', true);
            $this->set_fieldReq(sanitize_all_html_input(trim($data['sign2'])), 'sign2', 'Nominated Client Representative signature', true);
        }
        if ($this->error) {
            return false;
        } else {
            $dataAry = array(
                'testdate' => date('Y-m-d', strtotime($data['testdate'])),
                'Clientid' => $data['site'],
                'Drugtestid' => $data['drugtest'],
                'other_drug_test' => $data['other_drug_test'],
                'screening_facilities' => $data['screenfacility'],
                'ServiceCommencedOn' => $data['servicecomm'],
                'ServiceConcludedOn' => $data['servicecon'],
                'start_km' => $data['start_km'],
                'end_km' => $data['end_km'],
                'total_km' => $data['total_km'],
                'FurtherTestRequired' => $data['furthertestreq'],
                'TotalDonarScreeningUrine' => $data['totscreenu'],
                'TotalDonarScreeningOral' => $data['totscreeno'],
                'NegativeResultUrine' => $data['negresu'],
                'NegativeResultOral' => $data['negreso'],
                'FurtherTestUrine' => $data['furtestu'],
                'FurtherTestOral' => $data['furtesto'],
                'TotalAlcoholScreening' => $data['totalcscreen'],
                'NegativeAlcohol' => $data['negalcres'],
                'PositiveAlcohol' => $data['posalcres'],
                'Refusals' => $data['refusals'],
                'DeviceName' => $data['devicename'],
                'ExtraUsed' => $data['extraused'],
                'BreathTesting' => $data['breathtest'],
                'Comments' => $data['comments'],
                'ClientRepresentative' => $data['nominated'],
                'RepresentativeSignatureTime' => $data['nominedec'],
                'Status' => $data['status'],
                'collname' => $data['collname'],
                'sign1' => $data['sign1'],
                'sign2' => $data['sign2'],
                'agent_comment' => $data['agent_comment'],
	            'createdBy' => $data['userid']
            );
            if ($data['update'] == '1') {
                $wheresosAry = array('id' => (int)$data['idsos']);
                $newdonors = (int)$data['donercountpost'] - (int)$data['donercountpre'];
                $this->db->where($wheresosAry)
                    ->update(__DBC_SCHEMATA_SOS_FORM__, $dataAry);

                $sosid = (int)$data['idsos'];
                $failarr = array("sosid" => $sosid);
                $newupdate = false;
                for ($i = 1; $i <= $data['donercount']; $i++) {
                    $oldupdate = true;
                    if (!empty($data['name' . $i])) {
                        $donerAry = array(
                            'donerName' => $data['name' . $i],
                            'result' => $data['result' . $i],
                            'drug' => $data['drugtype' . $i],
                            'alcoholreading1' => $data['pos1read' . $i],
                            'alcoholreading2' => $data['pos2read' . $i],
                            'lab' => $data['lab' . $i],
                            'sosid' => (int)$sosid,
                            'otherdrug' => $data['oth' . $i]
                        );
                        if ($newdonors > '0') {
                            $totalnewdonors = explode(',', $data['newdonerids']);
                            foreach ($totalnewdonors as $newkey => $newval) {
                                if ($i == $newval) {
                                    $newupdate = true;
                                    $this->db->insert(__DBC_SCHEMATA_DONER__, $donerAry);
                                    /*$q1 = $this->db->last_query();
                                    echo 'q1 '.$q1.'<br />';
                                    echo $data['result' . $i].'----'.$data['drug' . $i].'-----'.$data['alcohol' . $i];*/
                                    if (($this->db->affected_rows() > 0) && (($data['result' . $i] == '1') || ($data['drug' . $i] == '1') || ($data['alcohol' . $i] == '1'))) {
                                        $donerid = $this->db->insert_id();
                                        $cocdatearr = array('cocdate' => date('Y-m-d', strtotime($data['testdate'])));
                                        $this->db->insert(__DBC_SCHEMATA_COC_FORM__, $cocdatearr);
//                                        $q2 = $this->db->last_query();
//                                        echo 'q2 '.$q2.'<br />';
                                        if ($this->db->affected_rows() > 0) {
                                            $cocid = $this->db->insert_id();
                                            $updatearr = array('cocid' => (int)$cocid);
                                            $whereAry = array('id' => (int)$donerid);
                                            $this->db->where($whereAry)
                                                ->update(__DBC_SCHEMATA_DONER__, $updatearr);
                                            /*$q3 = $this->db->last_query();
                                            echo 'q3 '.$q3.'<br />';*/
                                            if (!($this->db->affected_rows() > 0)) {
                                                $message = "Some error occurred while adding " . $data['name' . $i] . " donor.";
                                                array_push($failarr, $message);
                                            }
                                        }
                                    } elseif (!($this->db->affected_rows() > 0)) {
                                        $message = "Some error occurred while adding " . $data['name' . $i] . " donor.";
                                        array_push($failarr, $message);
                                    }
                                } else {
                                    if ($oldupdate && !$newupdate) {
                                        $oldupdate = false;
                                        $weherecocarr = array('id' => (int)$data['iddonor' . $i]);
                                        $this->db->where($weherecocarr)
                                            ->update(__DBC_SCHEMATA_DONER__, $donerAry);
                                        /*$q4 = $this->db->last_query();
                                        echo 'q4 '.$q4.'<br />';
                                        die;*/
                                        if (($data['idcoc' . $i] == '0') && (($data['result' . $i] == '1') || ($data['drug' . $i] == '1') || ($data['alcohol' . $i] == '1'))) {
                                            $cocdateupdatearr = array('cocdate' => date('Y-m-d', strtotime($data['testdate'])));
                                            $this->db->insert(__DBC_SCHEMATA_COC_FORM__, $cocdateupdatearr);
                                            /*$q5 = $this->db->last_query();
                                            echo 'q5 '.$q5.'<br />';*/
                                            if ($this->db->affected_rows() > 0) {
                                                $cocupdateid = $this->db->insert_id();
                                                $updatedonorarr = array('cocid' => (int)$cocupdateid);
                                                $whereupdateAry = array('id' => (int)$data['iddonor' . $i]);
                                                $this->db->where($whereupdateAry)
                                                    ->update(__DBC_SCHEMATA_DONER__, $updatedonorarr);
                                                /*$q6 = $this->db->last_query();
                                                echo 'q6 '.$q6.'<br />';*/
                                                if (!($this->db->affected_rows() > 0)) {
                                                    $message = "Some error occurred while adding " . $data['name' . $i] . " donor.";
                                                    array_push($failarr, $message);
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        } else {
                            $weherecocarr = array('id' => (int)$data['iddonor' . $i]);
                            $this->db->where($weherecocarr)
                                ->update(__DBC_SCHEMATA_DONER__, $donerAry);
                            /*$q7 = $this->db->last_query();
                            echo 'q7 '.$q7.'<br />';
                            die;*/
                            if (($data['idcoc' . $i] == '0') && (($data['result' . $i] == '1') || ($data['drug' . $i] == '1') || ($data['alcohol' . $i] == '1'))) {
                                $cocdateupdatearr = array('cocdate' => date('Y-m-d', strtotime($data['testdate'])));
                                $this->db->insert(__DBC_SCHEMATA_COC_FORM__, $cocdateupdatearr);
                                /*$q8 = $this->db->last_query();
                                echo 'q8 '.$q8.'<br />';*/
                                if ($this->db->affected_rows() > 0) {
                                    $cocupdateid = $this->db->insert_id();
                                    $updatedonorarr = array('cocid' => (int)$cocupdateid);
                                    $whereupdateAry = array('id' => (int)$data['iddonor' . $i]);
                                    $this->db->where($whereupdateAry)
                                        ->update(__DBC_SCHEMATA_DONER__, $updatedonorarr);
                                    /*$q9 = $this->db->last_query();
                                    echo 'q9 '.$q9.'<br />';*/
                                    if (!($this->db->affected_rows() > 0)) {
                                        $message = "Some error occurred while adding " . $data['name' . $i] . " donor.";
                                        array_push($failarr, $message);
                                    }
                                }
                            }
                        }
                    }
                }

                if ($data['kitcount'] > '0' && $data['totalkitcount'] == '0') {
                    for ($dc = 1; $dc <= $data['kitcount']; $dc++) {
                        $this->savekits($data['kit' . $dc], $sosid, $data['kitqty' . $dc], $failarr);
                    }
                } elseif ($data['kitcount'] > '0' && $data['totalkitcount'] > '0') {
                    $newkits = (int)$data['totalkitcount'] - (int)$data['oldkitcount'];
                    for ($dc = 1; $dc <= $data['kitcount']; $dc++) {
                        if ($newkits > '0') {
                            $newkitarr = explode(',', $data['newkitids']);
                            foreach ($newkitarr as $key => $val) {
                                if ($dc == $val) {
                                    $this->savekits($data['kit' . $dc], $sosid, $data['kitqty' . $dc], $failarr);
                                    break;
                                } else {
                                    $this->updatesavedkits($data['kit' . $dc], $data['kitid' . $dc], $data['kitqty' . $dc]);
                                }
                            }
                        } else {
                            $this->updatesavedkits($data['kit' . $dc], $data['kitid' . $dc], $data['kitqty' . $dc]);
                        }
                    }

                }
                $datacocarr = $this->getcocdonorsbysosid($sosid);
                if ($data['formtype'] == '1' && !empty($datacocarr)) {
                    if ($datacocarr['totalcoc'] > '1') {
                        $failarr = array("totalcoccount" => $datacocarr, "sosid" => $sosid);
                    } else {
                        $singlecocarr = $this->getcocidbysosid($sosid);
                        $failarr = array("totalcoccount" => $datacocarr, "sosid" => $sosid, "cocid" => $singlecocarr);
                    }
                }
                return $failarr;
            } else {
                $this->db->insert(__DBC_SCHEMATA_SOS_FORM__, $dataAry);
                if ($this->db->affected_rows() > 0) {
                    $sosid = (int)$this->db->insert_id();
                    $failarr = array("sosid" => $sosid);
                    for ($i = 1; $i <= $data['donercount']; $i++) {
                        if (!empty($data['name' . $i])) {
                            $donerAry = array(
                                'donerName' => $data['name' . $i],
                                'result' => $data['result' . $i],
                                'drug' => $data['drugtype' . $i],
                                'alcoholreading1' => $data['pos1read' . $i],
                                'alcoholreading2' => $data['pos2read' . $i],
                                'lab' => $data['lab' . $i],
                                'sosid' => (int)$sosid,
                                'otherdrug' => $data['oth' . $i]
                            );
                            $this->db->insert(__DBC_SCHEMATA_DONER__, $donerAry);
                            if (($this->db->affected_rows() > 0) && (($data['result' . $i] == '1') || ($data['drug' . $i] == '1') || ($data['alcohol' . $i] == '1'))) {
                                $donerid = $this->db->insert_id();
                                $cocdatearr = array('cocdate' => date('Y-m-d', strtotime($data['testdate'])));
                                $this->db->insert(__DBC_SCHEMATA_COC_FORM__, $cocdatearr);
                                if ($this->db->affected_rows() > 0) {
                                    $cocid = $this->db->insert_id();
                                    $updatearr = array('cocid' => (int)$cocid);
                                    $whereAry = array('id' => (int)$donerid);
                                    $this->db->where($whereAry)
                                        ->update(__DBC_SCHEMATA_DONER__, $updatearr);
                                    if (!($this->db->affected_rows() > 0)) {
                                        $message = "Some error occurred while adding " . $data['name' . $i] . " donor.";
                                        array_push($failarr, $message);
                                    }
                                }
                            } elseif (!($this->db->affected_rows() > 0)) {
                                $message = "Some error occurred while adding " . $data['name' . $i] . " donor.";
                                array_push($failarr, $message);
                            }
                        }
                    }
                    for ($dc = 1; $dc <= $data['kitcount']; $dc++) {
                        $this->savekits($data['kit' . $dc], $sosid, $data['kitqty' . $dc], $failarr);
                    }
                    $datacocarr = $this->getcocdonorsbysosid($sosid);
                    if ($data['formtype'] == '1' && !empty($datacocarr)) {
                        if ($datacocarr['totalcoc'] > '1') {
                            $failarr = array("totalcoccount" => $datacocarr, "sosid" => $sosid);
                        } else {
                            $singlecocarr = $this->getcocidbysosid($sosid);
                            $failarr = array("totalcoccount" => $datacocarr, "sosid" => $sosid, "cocid" => $singlecocarr);
                        }
                    }
                    return $failarr;
                } else {
                    $failarr = array("No data inserted");
                    return $failarr;
                }
            }
        }
    }

    function formatdate($date)
    {
        $datearr = explode('/', $date);
        if(!empty($date)){
        $res = $datearr['2'] . '-' . $datearr['1'] . '-' . $datearr['0'];
        }
        else{
         $res = '';   
        }
        return $res;
    }

    function set_fieldReq($value, $field = false, $message = false, $flag = true, $validation = __VLD_CASE_ANYTHING__)
    {
        $this->data[$field] = $this->validateInput($value, $validation, $field, $message, false, false, $flag);
    }

    function savekits($prodid, $sosid, $qty, $failarr)
    {
        if ($prodid > '0') {
            $kitAry = array(
                'prodid' => (int)$prodid,
                'sosid' => (int)$sosid,
                'quantity' => (int)$qty
            );
            $this->db->insert(__DBC_SCHEMATA_USED_KITS__, $kitAry);
            if (!($this->db->affected_rows() > 0)) {
                $message = "Some error occurred while adding product.";
                array_push($failarr, $message);
            }
        }
    }

    function updatesavedkits($prodid, $kitid, $qty)
    {
        $kitAry = array(
            'prodid' => (int)$prodid,
            'quantity' => (int)$qty
        );
        $whereAry = array('id' => (int)$kitid);
        $this->db->where($whereAry)
            ->update(__DBC_SCHEMATA_USED_KITS__, $kitAry);
    }

    function getcocdonorsbysosid($sosid)
    {
        $whereAry = 'sosid =' . (int)$sosid . ' AND cocid > 0';
        $query = $this->db->select('COUNT(id) as totalcoc')
            ->from(__DBC_SCHEMATA_DONER__)
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

    function getcocidbysosid($sosid)
    {
        $whereAry = 'sosid =' . (int)$sosid . ' AND cocid > 0';
        $query = $this->db->select('cocid')
            ->from(__DBC_SCHEMATA_DONER__)
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

    function getfranchiseesites($franchiseeid)
    {
        $resultarr = array();
        $franchiseeclientsarr = $this->getfranchiseeclients($franchiseeid);
        if (!empty($franchiseeclientsarr)) {
            foreach ($franchiseeclientsarr as $franchiseeclient) {
                $clientsitearr = $this->getclientsites($franchiseeclient['clientId']);
                if (!empty($clientsitearr)) {
                    array_push($resultarr, $clientsitearr);
                }
            }
            if (!empty($resultarr)) {
                return $resultarr;
            } else {
                $this->addError("norecord", "No record found.");
                return false;
            }
        } else {
            $this->addError("norecord", "No record found.");
            return false;
        }
    }

    function getfranchiseeclients($franchiseeid)
    {
        $whereAry = array('client.franchiseeId' => (int)$franchiseeid, 'client.clientType' => '0', 'user.isDeleted' => '0');
        $query = $this->db->select('client.id, client.clientId, client.szBusinessName, client.szContactEmail, client.szContactPhone, 
        client.szContactMobile, user.szName,
                                     user.szEmail, user.szContactNumber, user.szAddress, user.szZipCode,
                                     user.szCity, user.szCountry')
            ->from(__DBC_SCHEMATA_CLIENT__ . ' as client')
            ->join(__DBC_SCHEMATA_USERS__ . ' as user', 'user.id = client.clientId')
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

    function getclientsites($clientid)
    {
        $whereAry = array('client.clientType' => (int)$clientid, 'user.isDeleted' => '0');
        $query = $this->db->select('site.id, site.siteid, site.per_form_complete, site.sp_name, site.sp_mobile, site.sp_email, 
                                     site.iis_name, site.iis_mobile, site.iis_email, site.rlr_name, site.rlr_mobile, site.rlr_email, site.orlr_name,
                                     site.orlr_mobile, site.orlr_email, site.psc_name, site.psc_mobile, site.psc_phone, site.ssc_name, 
                                     site.ssc_mobile, site.ssc_phone, site.instructions, site.site_people, site.test_count, site.initial_testing_req,
                                     site.site_visit, site.ongoing_testing_req, site.onsite_service, site.start_time, site.power_access,
                                     site.randomisation, site.risk_assessment, site.req_comp_induction,
                                     site.req_ppe, site.paperwork, site.specify_contact, client.clientId, user.id as userid, user.szName,
                                     user.szEmail, user.szContactNumber, user.szAddress, user.szZipCode,
                                     user.szCity, user.szCountry')
            ->from(__DBC_SCHEMATA_SITES__ . ' as site')
            ->join(__DBC_SCHEMATA_CLIENT__ . ' as client', 'client.id = site.siteid')
            ->join(__DBC_SCHEMATA_USERS__ . ' as user', 'user.id = client.clientId')
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

    function getfranchiseesosformdata($franchiseeid)
    {
        $resultarr = array();
        $franchiseeclientsarr = $this->getfranchiseeclients($franchiseeid);
        if (!empty($franchiseeclientsarr)) {
            foreach ($franchiseeclientsarr as $franchiseeclient) {
                $clientsosdataarr = $this->getclientsosformdata($franchiseeclient['clientId']);

                if (!empty($clientsosdataarr)) {
                    foreach ($clientsosdataarr as $key => $val) {
                        $clientsosdataarr[$key][0]['parentclientid'] = $franchiseeclient['clientId'];
                        $clientsosdataarr[$key][0]['clientBusinessName'] = $franchiseeclient['szBusinessName'];
                        $clientdetarr = $this->getuserdetails($franchiseeclient['clientId']);
                        if (!empty($clientdetarr)) {
                            $clientsosdataarr[$key][0]['clientname'] = $clientdetarr[0]['szName'];
                        }
                        $sitedetarr = $this->getuserdetails($clientsosdataarr[$key][0]['Clientid']);
                        if (!empty($sitedetarr)) {
                            $clientsosdataarr[$key][0]['sitename'] = $sitedetarr[0]['szName'];
                        }
                    }
                    array_push($resultarr, $clientsosdataarr);
                }
            }

            if (!empty($resultarr)) {
                return $resultarr;
            } else {
                $this->addError("norecord", "No record found.");
                return false;
            }
        } else {
            $this->addError("norecord", "No record found.");
            return false;
        }
    }

    function getclientsosformdata($clientid)
    {
        $resultarr = array();
        $clientsitesarr = $this->getclientsites($clientid);
        if (!empty($clientsitesarr)) {
            foreach ($clientsitesarr as $clientsite) {
                $sosdataarr = $this->getsosformdata($clientsite['userid']);
                if (!empty($sosdataarr)) {
                    array_push($resultarr, $sosdataarr);
                }
            }
            if (!empty($resultarr)) {
                return $resultarr;
            } else {
                $this->addError("norecord", "No record found.");
                return false;
            }
        } else {
            $this->addError("norecord", "No record found.");
            return false;
        }
    }

    function getsosformdata($siteid, $status = 0)
    {
        $whereAry = 'sos.Clientid =' . (int)$siteid . ' AND sos.Status = ' . (int)$status;
        $query = $this->db->select('sos.id, sos.testdate, sos.Clientid, sos.Drugtestid, sos.other_drug_test, sos.screening_facilities, sos.start_km, sos.end_km, sos.total_km, sos.ServiceCommencedOn, sos.ServiceConcludedOn,
                                                sos.FurtherTestRequired, sos.TotalDonarScreeningUrine, sos.TotalDonarScreeningOral, sos.NegativeResultUrine,
                                                sos.NegativeResultOral, sos.FurtherTestUrine, sos.FurtherTestOral, sos.TotalAlcoholScreening, sos.NegativeAlcohol,
                                                sos.PositiveAlcohol, sos.Refusals, sos.DeviceName, sos.ExtraUsed, sos.BreathTesting, sos.Comments, sos.collname, sos.collsign, sos.ClientRepresentative,
                                                sos.RepresentativeSignature, sos.RepresentativeSignatureTime, sos.Status, sos.sign1, sos.sign2, sos.agent_comment, client.clientType, client.franchiseeId')
            ->from(__DBC_SCHEMATA_SOS_FORM__ . ' as sos')
            ->join(__DBC_SCHEMATA_CLIENT__ . ' as client', 'sos.Clientid = client.clientId')
            ->where($whereAry)
            ->order_by("sos.testdate", "DESC")
            ->get();
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
            return $row;
        } else {
            $this->addError("norecord", "No record found.");
            return false;
        }
    }

    function getuserdetails($userid)
    {
        $array = array('id' => (int)$userid, 'isDeleted' => 0);
        $query = $this->db->select('id, szName, abn, szEmail, iRole, userCode, szContactNumber, szAddress, szZipCode, szCity, szCountry')
            ->from(__DBC_SCHEMATA_USERS__)
            ->where($array)
            ->get();
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
            return $row;
        } else {
            $this->addError("usernotexist", "User does not exist.");
        }
    }

    function getCorpfranchiseesosformdata($franchiseeid, $siteid)
    {
        $resultarr = array();
        $franchiseeclientsarr = $this->getfranchiseeclients($franchiseeid);
        if (!empty($franchiseeclientsarr)) {
            foreach ($franchiseeclientsarr as $franchiseeclient) {
                $clientsosdataarr = $this->getCorpclientsosformdata($siteid);

                if (!empty($clientsosdataarr)) {
                    foreach ($clientsosdataarr as $key => $val) {
                        $clientsosdataarr[$key][0]['parentclientid'] = $franchiseeclient['clientId'];
                        $clientdetarr = $this->getuserdetails($franchiseeclient['clientId']);
                        if (!empty($clientdetarr)) {
                            $clientsosdataarr[$key][0]['clientname'] = $clientdetarr[0]['szName'];
                        }
                        $sitedetarr = $this->getuserdetails($siteid);
                        if (!empty($sitedetarr)) {
                            $clientsosdataarr[$key][0]['sitename'] = $sitedetarr[0]['szName'];
                        }
                    }
                    array_push($resultarr, $clientsosdataarr);
                }
            }

            if (!empty($resultarr)) {
                return $resultarr;
            } else {
                $this->addError("norecord", "No record found.");
                return false;
            }
        } else {
            $this->addError("norecord", "No record found.");
            return false;
        }
    }

    function getCorpclientsosformdata($siteid)
    {
        $resultarr = array();
        $sosdataarr = $this->getsosformdata($siteid);
        if (!empty($sosdataarr)) {
            array_push($resultarr, $sosdataarr);
        }
        if (!empty($resultarr)) {
            return $resultarr;
        } else {
            $this->addError("norecord", "No record found.");
            return false;
        }

    }

    function getagentsosformdata($agentid)
    {
        $resultarr = array();
        $agentclientsarr = $this->getagentclients($agentid);
        if (!empty($agentclientsarr)) {
            foreach ($agentclientsarr as $agentclient) {
                $clientsosdataarr = $this->getclientsosformdata($agentclient['clientId']);

                if (!empty($clientsosdataarr)) {
                    foreach ($clientsosdataarr as $key => $val) {
                        $clientsosdataarr[$key][0]['parentclientid'] = $agentclient['clientId'];
                        $clientdetarr = $this->getuserdetails($agentclient['clientId']);
                        if (!empty($clientdetarr)) {
                            $clientsosdataarr[$key][0]['clientname'] = $clientdetarr[0]['szName'];
                        }
                        $sitedetarr = $this->getuserdetails($clientsosdataarr[$key][0]['Clientid']);
                        if (!empty($sitedetarr)) {
                            $clientsosdataarr[$key][0]['sitename'] = $sitedetarr[0]['szName'];
                        }
                    }
                    array_push($resultarr, $clientsosdataarr);
                }
            }

            if (!empty($resultarr)) {
                return $resultarr;
            } else {
                $this->addError("norecord", "No record found.");
                return false;
            }
        } else {
            $this->addError("norecord", "No record found.");
            return false;
        }
    }

    function getagentclients($agentid)
    {
        $whereAry = 'user.isDeleted = 0 AND user.iActive = 1 AND client.agentId = ' . (int)$agentid;
        $query = $this->db->select('user.id, user.szName, user.abn, user.szEmail, user.szContactNumber, user.szAddress, user.szZipCode, user.szCity, user.userCode, user.szCountry, client.clientId')
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

    function getsosformdatabysosid($sosid)
    {
        $whereAry = 'id =' . (int)$sosid;
        $query = $this->db->select('*')
            ->from(__DBC_SCHEMATA_SOS_FORM__)
            ->where($whereAry)
            ->get();
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
            //$donorsarr = $this->getdonorsbysosid($sosid);
            //array_push($row,$donorsarr);
            return $row;
        } else {
            $this->addError("norecord", "No record found.");
            return false;
        }
    }

    function getdonorsbysosid($sosid)
    {
        $array = array('sosid' => (int)$sosid);
        $query = $this->db->select('id, donerName, result, drug, otherdrug, alcoholreading1, alcoholreading2, lab, sosid, cocid, cocstatus')
            ->from(__DBC_SCHEMATA_DONER__)
            ->where($array)
            ->get();
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
            return $row;
        } else {
            $this->addError("norecord", "No record found.");
        }
    }

    function getsosdatabycocid($cocid, $sosstatus = 0, $cocstatus = 0)
    {
        $whereAry = 'donor.cocid =' . (int)$cocid . ' AND sos.Status = ' . $sosstatus . ' AND donor.cocstatus = ' . $cocstatus;
        $query = $this->db->select('sos.id, sos.testdate, sos.Clientid, sos.Drugtestid, sos.other_drug_test, sos.ServiceCommencedOn, sos.ServiceConcludedOn,
                                    sos.FurtherTestRequired, sos.TotalDonarScreeningUrine, sos.TotalDonarScreeningOral, sos.NegativeResultUrine,
                                    sos.NegativeResultOral, sos.FurtherTestUrine, sos.FurtherTestOral, sos.TotalAlcoholScreening, sos.NegativeAlcohol,
                                    sos.PositiveAlcohol, sos.Refusals, sos.DeviceName, sos.ExtraUsed, sos.BreathTesting, sos.Comments, sos.ClientRepresentative,
                                    sos.RepresentativeSignature, sos.RepresentativeSignatureTime, sos.Status, donor.donerName,donor.drug, donor.otherdrug, donor.alcoholreading1,donor.alcoholreading2, donor.cocid, 
                                    coc.cocdate, coc.drugtest, coc.dob, coc.employeetype, coc.contractor, coc.idtype, coc.idnumber, coc.lastweekq, coc.donorsign,
                                    coc.donorsigndate, coc.voidtime, coc.sampletempc, coc.tempreadtime, 
                                    coc.intect, coc.intectexpiry, coc.visualcolor, coc.creatinine,coc.otherintegrity,coc.hudration,coc.devicename as cocdevice,coc.lotno,coc.lotexpiry,coc.cocain,
                                    coc.amp,coc.mamp,coc.thc, coc.opiates, coc.benzo, coc.otherdc, coc.ctstime, coc.collectorone, coc.collectorsignone, coc.commentscol1, coc.collectortwo, coc.collectorsigntwo, coc.comments,
                                    coc.onsitescreeningrepo, coc.receiverone, coc.receiveronesign, coc.receiveronedate, coc.receiveronetime,coc.receiveroneseal,
                                    coc.receiveronelabel, coc.receivertwo, coc.receivertwosign, coc.receivertwodate, coc.receivertwotime, coc.receivertwoseal, coc.receivertwolabel,
                                    coc.reference,coc.devicesrno,coc.cutoff,coc.donwaittime,coc.dontest1,coc.dontesttime1,coc.dontest2,coc.dontesttime2,coc.donordecdate,coc.donordecsign, coc.signcoc1, coc.signcoc2, coc.signcoc3, coc.signcoc4, coc.signcoc5, coc.signcoc6')
            ->from(__DBC_SCHEMATA_SOS_FORM__ . ' as sos')
            ->join(__DBC_SCHEMATA_DONER__ . ' as donor', 'sos.id = donor.sosid')
            ->join(__DBC_SCHEMATA_COC_FORM__ . ' as coc', 'coc.id = donor.cocid')
            ->where($whereAry)
            ->get();
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
            return $row;
        } else {
            $this->addError("norecord", "No record found.");
        }
    }

    function addcocdata($data)
    {
        if (!empty($data['cocdate'])) {
            $data['cocdate'] = $this->formatdate($data['cocdate']);
        }
        if (!empty($data['dob'])) {
            $data['dob'] = $this->formatdate($data['dob']);
        }
        if (!empty($data['donorsigndate'])) {
            $data['donorsigndate'] = $this->formatdate($data['donorsigndate']);
        }
        if (!empty($data['donordecdate'])) {
            $data['donordecdate'] = $this->formatdate($data['donordecdate']);
        }
        if (!empty($data['intectexpiry'])) {
            $data['intectexpiry'] = $this->formatdate($data['intectexpiry']);
        }
        if (!empty($data['lotexpiry'])) {
            $data['lotexpiry'] = $this->formatdate($data['lotexpiry']);
        }
        /*if (!empty($data['receiveronedate'])) {
            $data['receiveronedate'] = $this->formatdate($data['receiveronedate']);
        }
        if (!empty($data['receivertwodate'])) {
            $data['receivertwodate'] = $this->formatdate($data['receivertwodate']);
        }*/
        $drugtestdata1 = '';
        $drugtestdata2 = '';
        $drugtestdata3 = '';
        if (!empty($data['drugtest'])) {
            if (!empty($data['drugtest'][0])) {
                $drugtestdata1 = $data['drugtest'][0];
            }
            if (!empty($data['drugtest'][1])) {
                $drugtestdata2 = $data['drugtest'][1];
            }
            if (!empty($data['drugtest'][2])) {
                $drugtestdata3 = $data['drugtest'][2];
            }
        }
        $data['drugtest'] = $drugtestdata1. ',' . $drugtestdata2.(!empty($drugtestdata3)?','.$drugtestdata3:'');
//        $data['drugtest'] = $drugtestdata1;
        if(empty($drugtestdata2)){
            $data['drugtest'] = substr($data['drugtest'],0,-1);
        }
        if ($data['status'] == '1') {
            $this->set_fieldReq(sanitize_all_html_input(trim($data['cocdate'])), 'cocdate', 'Date', true, __VLD_CASE_DATE__);
            $this->set_fieldReq(sanitize_all_html_input(trim($data['drugtest'])), 'drugtest', 'Drug to be tested', true);
            $this->set_fieldReq(sanitize_all_html_input(trim($data['dob'])), 'dob', 'DOB', true, __VLD_CASE_DATE__);
            $this->set_fieldReq(sanitize_all_html_input(trim($data['employeetype'])), 'employeetype', 'Employment Type', true, __VLD_CASE_NUMERIC__);
            $this->set_fieldReq(sanitize_all_html_input(trim($data['contractor'])), 'contractor', 'Contractor Details', false);
            $this->set_fieldReq(sanitize_all_html_input(trim($data['idtype'])), 'idtype', 'ID Type', true, __VLD_CASE_NUMERIC__);
            $this->set_fieldReq(sanitize_all_html_input(trim($data['idnumber'])), 'idnumber', 'ID Number', true);
            $this->set_fieldReq(sanitize_all_html_input(trim($data['lastweekq'])), 'lastweekq', 'Answer for the question - Have you taken any medication, drugs or other non-prescription agents in last week?', false);
            $this->set_fieldReq(sanitize_all_html_input(trim($data['signcoc1'])), 'signcoc1', 'Donor Signature', true);
            $this->set_fieldReq(sanitize_all_html_input(trim($data['donorsigndate'])), 'donorsigndate', 'Donor signature date', true, __VLD_CASE_DATE__);
            $this->set_fieldReq(sanitize_all_html_input(trim($data['devicesrno'])), 'devicesrno', 'Device Serial#', ($drugtestdata1 == '1' || $drugtestdata2 == '1' ? true : false));
            $this->set_fieldReq(sanitize_all_html_input(trim($data['cutoff'])), 'cutoff', 'Cut off level', ($drugtestdata1 == '1' ? true : false), __VLD_CASE_DECIMAL__);
            $this->set_fieldReq(sanitize_all_html_input(trim($data['donwaittime'])), 'donwaittime', 'Wait time', ($drugtestdata1 == '1' ? true : false));
            $this->set_fieldReq(sanitize_all_html_input(trim($data['dontest1'])), 'dontest1', 'Test 1', ($drugtestdata1 == '1' ? true : false), __VLD_CASE_DECIMAL__);
            $this->set_fieldReq(sanitize_all_html_input(trim($data['dontesttime1'])), 'dontesttime1', 'Test 1 time', ($drugtestdata1 == '1' ? true : false));
            $this->set_fieldReq(sanitize_all_html_input(trim($data['dontest2'])), 'dontest2', 'Test 2', ($drugtestdata1 == '1' ? true : false), __VLD_CASE_DECIMAL__);
            $this->set_fieldReq(sanitize_all_html_input(trim($data['dontesttime2'])), 'dontesttime2', 'Test 2 time', ($drugtestdata1 == '1' ? true : false));
            $this->set_fieldReq(sanitize_all_html_input(trim($data['voidtime'])), 'voidtime', 'Void Time', ($drugtestdata1 == '2' || $drugtestdata1 == '3' || $drugtestdata1 == '5' || $drugtestdata2 == '2' || $drugtestdata2 == '3' || $drugtestdata2 == '5' || $drugtestdata3 == '2' || $drugtestdata3 == '3' || $drugtestdata3 == '5' ? true : false));
            $this->set_fieldReq(sanitize_all_html_input(trim($data['sampletempc'])), 'sampletempc', 'Sample Temp C', ($drugtestdata1 == '3' || $drugtestdata2 == '3' || $drugtestdata3 == '3' || $drugtestdata1 == '5' || $drugtestdata2 == '5' || $drugtestdata3 == '5'? true : false), __VLD_CASE_DIGITS__);
            $this->set_fieldReq(sanitize_all_html_input(trim($data['tempreadtime'])), 'tempreadtime', 'Temp Read Time within 4 min', ($drugtestdata1 == '3' || $drugtestdata2 == '3' || $drugtestdata3 == '3' || $drugtestdata1 == '5' || $drugtestdata2 == '5' || $drugtestdata3 == '5' ? true : false));
            $this->set_fieldReq(sanitize_all_html_input(trim($data['intect'])), 'intect', 'Intect 7 Lot. No.', false, __VLD_CASE_NUMERIC__);
            $this->set_fieldReq(sanitize_all_html_input(trim($data['intectexpiry'])), 'intectexpiry', 'Intect 7 Expiry', false, __VLD_CASE_DATE__);
            $this->set_fieldReq(sanitize_all_html_input(trim($data['visualcolor'])), 'visualcolor', 'Visual Color', false);
            $this->set_fieldReq(sanitize_all_html_input(trim($data['creatinine'])), 'creatinine', 'Creatinine',  false, __VLD_CASE_ALPHANUMERIC__);
            $this->set_fieldReq(sanitize_all_html_input(trim($data['otherintegrity'])), 'otherintegrity', 'Other Integrity', false);
            $this->set_fieldReq(sanitize_all_html_input(trim($data['hudration'])), 'hudration', 'Hydration', false, __VLD_CASE_ALPHANUMERIC__);
            $this->set_fieldReq(sanitize_all_html_input(trim($data['devicename'])), 'devicename', 'Device Name', ($drugtestdata1 == '2' || $drugtestdata1 == '3' || $drugtestdata1 == '5' || $drugtestdata2 == '2' || $drugtestdata2 == '3' || $drugtestdata2 == '5' || $drugtestdata3 == '2' || $drugtestdata3 == '3' || $drugtestdata3 == '5' ? true : false));
            $this->set_fieldReq(sanitize_all_html_input(trim($data['reference'])), 'reference', 'Reference', ($drugtestdata1 == '2' || $drugtestdata1 == '3' || $drugtestdata1 == '5' || $drugtestdata2 == '2' || $drugtestdata2 == '3' || $drugtestdata2 == '5' || $drugtestdata3 == '2' || $drugtestdata3 == '3' || $drugtestdata3 == '5' ? true : false), __VLD_CASE_NUMERIC__);
            $this->set_fieldReq(sanitize_all_html_input(trim($data['lotno'])), 'lotno', 'Lot No.', ($drugtestdata1 == '2' || $drugtestdata1 == '3' || $drugtestdata1 == '5' || $drugtestdata2 == '2' || $drugtestdata2 == '3' || $drugtestdata2 == '5' || $drugtestdata3 == '2' || $drugtestdata3 == '3' || $drugtestdata3 == '5'  ? true : false), __VLD_CASE_NUMERIC__);
            $this->set_fieldReq(sanitize_all_html_input(trim($data['lotexpiry'])), 'lotexpiry', 'Lot Expiry', ($drugtestdata1 == '2' || $drugtestdata1 == '3' || $drugtestdata1 == '5' || $drugtestdata2 == '2' || $drugtestdata2 == '3' || $drugtestdata2 == '5' || $drugtestdata3 == '2' || $drugtestdata3 == '3' || $drugtestdata3 == '5' ? true : false), __VLD_CASE_DATE__);
            $this->set_fieldReq(sanitize_all_html_input(trim($data['cocain'])), 'cocain', 'Cocain', ($drugtestdata1 == '2' || $drugtestdata1 == '3' || $drugtestdata1 == '5' || $drugtestdata2 == '2' || $drugtestdata2 == '3' || $drugtestdata2 == '5' || $drugtestdata3 == '2' || $drugtestdata3 == '3' || $drugtestdata3 == '5' ? true : false));
            $this->set_fieldReq(sanitize_all_html_input(trim($data['amp'])), 'amp', 'AMP', ($drugtestdata1 == '2' || $drugtestdata1 == '3' || $drugtestdata1 == '5' || $drugtestdata2 == '2' || $drugtestdata2 == '3' || $drugtestdata2 == '5' || $drugtestdata3 == '2' || $drugtestdata3 == '3' || $drugtestdata3 == '5' ? true : false));
            $this->set_fieldReq(sanitize_all_html_input(trim($data['mamp'])), 'mamp', 'MAMP', ($drugtestdata1 == '2' || $drugtestdata1 == '3' || $drugtestdata1 == '5' || $drugtestdata2 == '2' || $drugtestdata2 == '3' || $drugtestdata2 == '5' || $drugtestdata3 == '2' || $drugtestdata3 == '3' || $drugtestdata3 == '5' ? true : false));
            $this->set_fieldReq(sanitize_all_html_input(trim($data['thc'])), 'thc', 'THC', ($drugtestdata1 == '2' || $drugtestdata1 == '3' || $drugtestdata1 == '5' || $drugtestdata2 == '2' || $drugtestdata2 == '3' || $drugtestdata2 == '5' || $drugtestdata3 == '2' || $drugtestdata3 == '3' || $drugtestdata3 == '5' ? true : false));
            $this->set_fieldReq(sanitize_all_html_input(trim($data['opiates'])), 'opiates', 'Opiates', ($drugtestdata1 == '2' || $drugtestdata1 == '3' || $drugtestdata1 == '5' || $drugtestdata2 == '2' || $drugtestdata2 == '3' || $drugtestdata2 == '5' || $drugtestdata3 == '2' || $drugtestdata3 == '3' || $drugtestdata3 == '5' ? true : false));
            $this->set_fieldReq(sanitize_all_html_input(trim($data['benzo'])), 'benzo', 'Benzo', ($drugtestdata1 == '2' || $drugtestdata1 == '3' || $drugtestdata1 == '5' || $drugtestdata2 == '2' || $drugtestdata2 == '3' || $drugtestdata2 == '5' || $drugtestdata3 == '2' || $drugtestdata3 == '3' || $drugtestdata3 == '5' ? true : false));
            $this->set_fieldReq(sanitize_all_html_input(trim($data['otherdc'])), 'otherdc', 'Other', ($drugtestdata1 == '2' || $drugtestdata1 == '3' || $drugtestdata1 == '5' || $drugtestdata2 == '2' || $drugtestdata2 == '3' || $drugtestdata2 == '5' || $drugtestdata3 == '2' || $drugtestdata3 == '3' || $drugtestdata3 == '5' ? true : false));
            $this->set_fieldReq(sanitize_all_html_input(trim($data['ctstime'])), 'ctstime', 'Collection time of sample', true );
            $this->set_fieldReq(sanitize_all_html_input(trim($data['donordecdate'])), 'donordecdate', 'Donor declaration date', true, __VLD_CASE_DATE__);
            $this->set_fieldReq(sanitize_all_html_input(trim($data['signcoc2'])), 'signcoc2', 'Donor declaration signature', true);
            $this->set_fieldReq(sanitize_all_html_input(trim($data['collectorone'])), 'collectorone', 'Collector 1 Name/Number', true);
            $this->set_fieldReq(sanitize_all_html_input(trim($data['signcoc3'])), 'signcoc3', 'Collector 1 Sign', true);
            $this->set_fieldReq(sanitize_all_html_input(trim($data['commentscol1'])), 'commentscol1', 'Comments', false);
            $this->set_fieldReq(sanitize_all_html_input(trim($data['collectortwo'])), 'collectortwo', 'Collector 2 Name/Number', false);
            $this->set_fieldReq(sanitize_all_html_input(trim($data['signcoc4'])), 'signcoc4', 'Collector 2 Sign', false);
            $this->set_fieldReq(sanitize_all_html_input(trim($data['comments'])), 'comments', 'Comments', false);
            $this->set_fieldReq(sanitize_all_html_input(trim($data['onsitescreeningrepo'])), 'onsitescreeningrepo', 'On-Site Screening Report', true, __VLD_CASE_NUMERIC__);
            /*$this->set_fieldReq(sanitize_all_html_input(trim($data['receiverone'])), 'receiverone', 'Received By (print)', true);
            $this->set_fieldReq(sanitize_all_html_input(trim($data['receiveronedate'])), 'receiveronedate', 'Receiving Date', true, __VLD_CASE_DATE__);
            $this->set_fieldReq(sanitize_all_html_input(trim($data['receiveronetime'])), 'receiveronetime', 'Receiving Time', true);
            $this->set_fieldReq(sanitize_all_html_input(trim($data['receiveroneseal'])), 'receiveroneseal', 'Seal Intact', true);
            $this->set_fieldReq(sanitize_all_html_input(trim($data['receiveronelabel'])), 'receiveronelabel', 'Label/Bar Code', true);
            $this->set_fieldReq(sanitize_all_html_input(trim($data['signcoc5'])), 'signcoc5', 'Receiver Signature', true);
            $this->set_fieldReq(sanitize_all_html_input(trim($data['receivertwo'])), 'receivertwo', 'Received By (print)', false);
            $this->set_fieldReq(sanitize_all_html_input(trim($data['receivertwodate'])), 'receivertwodate', 'Receiving Date', false, __VLD_CASE_DATE__);
            $this->set_fieldReq(sanitize_all_html_input(trim($data['receivertwotime'])), 'receivertwotime', 'Receiving Time', false);
            $this->set_fieldReq(sanitize_all_html_input(trim($data['receivertwoseal'])), 'receivertwoseal', 'Seal Intact', false);
            $this->set_fieldReq(sanitize_all_html_input(trim($data['receivertwolabel'])), 'receivertwolabel', 'Label/Bar Code', false);
            $this->set_fieldReq(sanitize_all_html_input(trim($data['signcoc6'])), 'signcoc6', 'Receiver Signature', false);*/
        }
        if ($this->error) {
            return false;
        } else {
            $updatearr = array(
                'cocdate' => (!empty($data['cocdate']) ? date('Y-m-d', strtotime($data['cocdate'])) : ''),
                'drugtest' => $data['drugtest'],
                'dob' => (!empty($data['dob']) ? date('Y-m-d', strtotime($data['dob'])) : ''),
                'employeetype' => $data['employeetype'],
                'contractor' => $data['contractor'],
                'idtype' => $data['idtype'],
                'idnumber' => $data['idnumber'],
                'lastweekq' => $data['lastweekq'],
                'donorsigndate' => $data['donorsigndate'],
                'voidtime' => $data['voidtime'],
                'sampletempc' => $data['sampletempc'],
                'tempreadtime' => $data['tempreadtime'],
                'intect' => $data['intect'],
                'intectexpiry' => (!empty($data['intectexpiry']) ? date('Y-m-d', strtotime($data['intectexpiry'])) : ''),
                'visualcolor' => $data['visualcolor'],
                'creatinine' => $data['creatinine'],
                'otherintegrity' => $data['otherintegrity'],
                'hudration' => $data['hudration'],
                'devicename' => $data['devicename'],
                'reference' => $data['reference'],
                'lotno' => $data['lotno'],
                'lotexpiry' => (!empty($data['lotexpiry']) ? date('Y-m-d', strtotime($data['lotexpiry'])) : ''),
                'cocain' => $data['cocain'],
                'amp' => $data['amp'],
                'mamp' => $data['mamp'],
                'thc' => $data['thc'],
                'opiates' => $data['opiates'],
                'benzo' => $data['benzo'],
                'otherdc' => $data['otherdc'],
                'ctstime' => $data['ctstime'],
                'collectorone' => $data['collectorone'],
                'commentscol1' => $data['commentscol1'],
                'collectortwo' => $data['collectortwo'],
                'comments' => $data['comments'],
                'onsitescreeningrepo' => $data['onsitescreeningrepo'],
                /*'receiverone' => $data['receiverone'],
                'receiveronedate' => (!empty($data['receiveronedate']) ? date('Y-m-d', strtotime($data['receiveronedate'])) : ''),
                'receiveronetime' => $data['receiveronetime'],
                'receiveroneseal' => $data['receiveroneseal'],
                'receiveronelabel' => $data['receiveronelabel'],
                'receivertwo' => $data['receivertwo'],
                'receivertwodate' => (!empty($data['receivertwodate']) ? date('Y-m-d', strtotime($data['receivertwodate'])) : ''),
                'receivertwotime' => $data['receivertwotime'],
                'receivertwoseal' => $data['receivertwoseal'],
                'receivertwolabel' => $data['receivertwolabel'],*/
                'devicesrno' => $data['devicesrno'],
                'cutoff' => $data['cutoff'],
                'donwaittime' => $data['donwaittime'],
                'dontest1' => $data['dontest1'],
                'dontesttime1' => $data['dontesttime1'],
                'dontest2' => $data['dontest2'],
                'dontesttime2' => $data['dontesttime2'],
                'donordecdate' => $data['donordecdate'],
                'signcoc1' => $data['signcoc1'],
                'signcoc2' => $data['signcoc2'],
                'signcoc3' => $data['signcoc3'],
                'signcoc4' => $data['signcoc4']/*,
                'signcoc5' => $data['signcoc5'],
                'signcoc6' => $data['signcoc6']*/
            );
            $cocid = $data['cocid'];
            $whereAry = array('id' => (int)$cocid);
            $this->db->where($whereAry)
                ->update(__DBC_SCHEMATA_COC_FORM__, $updatearr);
            /*$q = $this->db->last_query();
            echo $q;*/
            if ($this->db->affected_rows() > 0) {
                if ($data['status'] == '1') {
                    $statusarr = array('cocstatus' => '1');
                    $conditionarr = array('cocid' => (int)$cocid);
                    $this->db->where($conditionarr)
                        ->update(__DBC_SCHEMATA_DONER__, $statusarr);
                    if ($this->db->affected_rows() > 0) {
                        $this->addError("success", "COC data saved successfully");
                        return true;
                    }
                }
                $this->addError("success", "COC data saved successfully");
                return true;
            } else {
                if ($data['status'] == '1') {
                    $statusarr = array('cocstatus' => '1');
                    $conditionarr = array('cocid' => (int)$cocid);
                    $this->db->where($conditionarr)
                        ->update(__DBC_SCHEMATA_DONER__, $statusarr);
                    if ($this->db->affected_rows() > 0) {
                        $this->addError("success", "COC data saved successfully");
                        return true;
                    }
                } elseif ($data['status'] == '0') {
                    $this->addError("success", "COC data saved successfully");
                    return true;
                } else {
                    $this->addError("error", "Due to some error COC data is not saved successfully. Please try again.");
                    return false;
                }

            }
        }
    }

    function getuserhierarchybysiteid($siteid)
    {
        $whereAry = 'client.clientId =' . (int)$siteid . ' AND user.isDeleted = 0';
        $query = $this->db->select('client.franchiseeId, client.clientType, client.szBusinessName, user.szName, user.abn, user.szAddress, user.szContactNumber, user.szEmail, user.szZipCode, user.szCountry')
            ->from(__DBC_SCHEMATA_CLIENT__ . ' as client')
            ->join(__DBC_SCHEMATA_USERS__ . ' as user', 'client.franchiseeId = user.id')
            ->where($whereAry)
            ->get();
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
            return $row;
        } else {
            $this->addError("norecord", "No record found.");
        }
    }

    function delcoc($cocid)
    {
        $whereAry = 'id =' . (int)$cocid;
        $query = $this->db->where($whereAry)
            ->delete(__DBC_SCHEMATA_COC_FORM__);
        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    function deldonor($donorid)
    {
        $whereAry = 'id =' . (int)$donorid;
        $query = $this->db->where($whereAry)
            ->delete(__DBC_SCHEMATA_DONER__);
        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    function getDonorByID($donorid)
    {
        $array = array('id' => $donorid);
        $query = $this->db->select('COUNT(id) as totalcoc')
            ->from(__DBC_SCHEMATA_DONER__)
            ->where($array)
            ->get();
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
            return $row;
        } else {
            return false;
        }
    }

    function getDonorDetByID($donorid)
    {
        $array = array('id' => $donorid);
        $query = $this->db->from(__DBC_SCHEMATA_DONER__)
            ->where($array)
            ->get();
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
            return $row;
        } else {
            return false;
        }
    }

    function getallprodbycatid($catid)
    {
        $array = array('szProductCategory' => (int)$catid, 'isDeleted' => '0');
        $query = $this->db->select('id, szProductCode, szProductDiscription, szProductCost, min_ord_qty')
            ->from(__DBC_SCHEMATA_PRODUCT__)
            ->where($array)
            ->get();
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
            return $row;
        } else {
            return false;
        }
    }

    function getallcategories()
    {
        $array = array('isDeleted' => '0');
        $query = $this->db->select('id, szName, szDiscription')
            ->from(__DBC_SCHEMATA_PRODUCT_CATEGORY__)
            ->where($array)
            ->get();
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
            return $row;
        } else {
            return false;
        }
    }

    function addtocart($data)
    {
        $this->set_fieldReq(sanitize_all_html_input(trim($data['franchiseeid'])), 'franchiseeid', 'Franchisee', true, __VLD_CASE_NUMERIC__);
        $this->set_fieldReq(sanitize_all_html_input(trim($data['productid'])), 'productid', 'Product', true, __VLD_CASE_NUMERIC__);
        $this->set_fieldReq(sanitize_all_html_input(trim($data['quantity'])), 'quantity', 'Quantity', true, __VLD_CASE_NUMERIC__);
        if ($this->error) {
            return false;
        } else {
            $cartitemarr = array(
                'franchiseeid' => (int)$data['franchiseeid'],
                'productid' => (int)$data['productid'],
                'quantity' => (int)$data['quantity'],
                'addedon' => date('Y-m-d H:i:s')
            );
            $prodExistInCart = $this->checkproductexistincart((int)$data['franchiseeid'], (int)$data['productid']);
            if (!empty($prodExistInCart)) {
                $quantity = $prodExistInCart[0]['quantity'] + (int)$data['quantity'];
                $updatearr = array('quantity' => (int)$quantity);
                $whereAry = array('id' => (int)$prodExistInCart[0]['id']);
                $this->db->where($whereAry)
                    ->update(__DBC_SCHEMATA_CART__, $updatearr);
                if ($this->db->affected_rows() > 0) {
                    return true;
                } else {
                    return false;
                }
            } else {
                $this->db->insert(__DBC_SCHEMATA_CART__, $cartitemarr);
                if ($this->db->affected_rows() > 0) {
                    return true;
                } else {
                    return false;
                }
            }

        }
    }

    function checkproductexistincart($franchiseeid, $productid)
    {
        $array = array('franchiseeid' => (int)$franchiseeid, 'productid' => (int)$productid);
        $query = $this->db->select('id, quantity')
            ->from(__DBC_SCHEMATA_CART__)
            ->where($array)
            ->get();
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
            return $row;
        } else {
            return false;
        }
    }

    function deleteitemfromcart($data)
    {
        $this->set_fieldReq(sanitize_all_html_input(trim($data['franchiseeid'])), 'franchiseeid', 'Franchisee', true, __VLD_CASE_NUMERIC__);
        $this->set_fieldReq(sanitize_all_html_input(trim($data['productid'])), 'productid', 'Product', true, __VLD_CASE_NUMERIC__);
        if ($this->error) {
            return false;
        } else {
            $prodExistInCart = $this->checkproductexistincart((int)$data['franchiseeid'], (int)$data['productid']);
            if (!empty($prodExistInCart)) {
                $whereAry = 'franchiseeid =' . (int)$data['franchiseeid'] . ' AND productid = ' . (int)$data['productid'];
                $query = $this->db->where($whereAry)
                    ->delete(__DBC_SCHEMATA_CART__);
                if ($query) {
                    return true;
                } else {
                    return false;
                }
            } else {
                $this->addError('cartproductid', "Product does not exist in your cart.");
                return false;
            }
        }
    }

    function updatecart($data)
    {
        $checkcount = 0;
        if ($data['totcartitems'] > '0') {
            for ($i = 1; $i <= $data['totcartitems']; $i++) {

                if ($data['cartid' . $i] > '0') {
                    $cartqtyupdate = array(
                        'quantity' => (int)$data['qty' . $i]
                    );
                    $whereAry = array('id' => (int)$data['cartid' . $i]);
                    $updateq = $this->db->where($whereAry)
                        ->update(__DBC_SCHEMATA_CART__, $cartqtyupdate);
                    if ($updateq) {
                        $checkcount++;
                    }
                }
            }
        }
        if ($data['totcartitems'] > '0' && $checkcount == $data['totcartitems']) {
            return true;
        } else {
            return false;
        }
    }

    function addorder($data)
    {
        $this->set_fieldReq(sanitize_all_html_input(trim($data['franchiseeid'])), 'franchiseeid', 'Franchisee', true, __VLD_CASE_NUMERIC__);
        $this->set_fieldReq(sanitize_all_html_input(trim($data['totalprice'])), 'totalprice', 'Total Price', true, __VLD_CASE_NUMERIC__);
        if ($this->error) {
            return false;
        } else {
            $orderdataArr = array(
                'franchiseeid' => (int)$data['franchiseeid'],
                'price' => (int)$data['totalprice'],
                'createdon' => date('Y-m-d H:i:s')
            );
            $this->db->insert(__DBC_SCHEMATA_ORDER__, $orderdataArr);
            if ($this->db->affected_rows() > 0) {
                $orderid = (int)$this->db->insert_id();
                $frenchiseecartArr = $this->getfranchiseecartitems((int)$data['franchiseeid']);
                if (!empty($frenchiseecartArr)) {
                    $checkcount = 0;
                    $count = 0;
                    foreach ($frenchiseecartArr as $cartitems) {
                        if ($this->addOrderDetails((int)$orderid, (int)$cartitems['productid'], (int)$cartitems['quantity'])) {
                            $checkcount++;
                        }
                        $count++;
                    }
                    if ($count == $checkcount) {
                        if ($this->emptycart($data)) {
                            if ($this->markOrderVerified($orderid)) {
                                $this->sendAppOrderEmail($data['franchiseeid'],$orderid);
                                return true;
                            } else {
                                return false;
                            }
                        } else {
                            return false;
                        }
                    } else {
                        return false;
                    }
                } else {
                    $this->deleteOrder($orderid);
                    return false;
                }
            } else {
                return false;
            }
        }
    }

    function sendAppOrderEmail($franchiseeid,$orderid)
    {
        $franchiseeDetArr = $this->Admin_Model->getAdminDetailsByEmailOrId('',$franchiseeid);
        $orderIdAry = $this->getorderdetails($orderid);
        $replace_ary = array();
        $replace_ary['supportEmail'] = __ORDER_SUPPORT_EMAIL__;
        $replace_ary['Link'] = __BASE_URL__ . "/admin/admin_login";
        file_put_contents('elog.txt', "franchisee Id ".$franchiseeid."-\nOrder Id : ".$orderid."\ndb order id : ".$orderIdAry[0]['id'] ."\n Franchisee email: ".$franchiseeDetArr['szEmail']."\n");
        createEmail($this, '__ORDER_NOTIFICATION__', $replace_ary,$franchiseeDetArr['szEmail'], '', __ORDER_SUPPORT_EMAIL__,$orderid, __ORDER_SUPPORT_EMAIL__,'',2);
        return true;
    }

    function getfranchiseecartitems($franchiseeid)
    {
        $whereAry = 'cart.franchiseeid =' . (int)$franchiseeid . ' AND product.isDeleted = 0';
        $query = $this->db->select('cart.id, cart.franchiseeid, cart.productid, cart.quantity, product.szProductCode, product.szProductDiscription, product.szProductCost, product.min_ord_qty')
            ->from(__DBC_SCHEMATA_CART__ . ' as cart')
            ->join(__DBC_SCHEMATA_PRODUCT__ . ' as product', 'product.id = cart.productid')
            ->where($whereAry)
            ->get();
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
            return $row;
        } else {
            $this->addError("norecord", "No record found.");
        }
    }

    function addOrderDetails($orderid, $productid, $quantity)
    {
        $orderdetailArr = array(
            'orderid' => (int)$orderid,
            'productid' => (int)$productid,
            'quantity' => (int)$quantity
        );
        $this->db->insert(__DBC_SCHEMATA_ORDER_DETAILS__, $orderdetailArr);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function emptycart($data)
    {
        $this->set_fieldReq(sanitize_all_html_input(trim($data['franchiseeid'])), 'franchiseeid', 'Franchisee', true, __VLD_CASE_NUMERIC__);
        if ($this->error) {
            return false;
        } else {
            $whereAry = 'franchiseeid =' . (int)$data['franchiseeid'];
            $query = $this->db->where($whereAry)
                ->delete(__DBC_SCHEMATA_CART__);
            if ($query) {
                return true;
            } else {
                return false;
            }
        }
    }

    function markOrderVerified($orderid)
    {
        $orderdataArr = array(
            'createdon' => date('Y-m-d H:i:s'),
            'validorder' => 1
        );
        $whereAry = array('id' => (int)$orderid);
        $this->db->where($whereAry)
            ->update(__DBC_SCHEMATA_ORDER__, $orderdataArr);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function deleteOrder($orderid)
    {
        $whereAry = 'id =' . (int)$orderid;
        $query = $this->db->where($whereAry)
            ->delete(__DBC_SCHEMATA_ORDER__);
        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    function getorderdetails($orderid)
    {
        $whereAry = 'ord.id = ' . (int)$orderid . ' AND ord.validorder = 1 AND product.isDeleted = 0 AND cat.isDeleted = 0';
        $query = $this->db->select('ord.id, ord.franchiseeid, ord.price, ord.status, ord.createdon, ord.completedon, ord.dispatchedon,
                                    ord.canceledon, ord.xeroprocessed, ord.XeroIDnumber, orddet.quantity, orddet.dispatched, product.szProductCode, 
                                    product.szProductDiscription, product.szProductCost, product.dtExpiredOn, cat.szName, cat.szDiscription')
            ->from(__DBC_SCHEMATA_ORDER__ . ' as ord')
            ->join(__DBC_SCHEMATA_ORDER_DETAILS__ . ' as orddet', 'ord.id = orddet.orderid')
            ->join(__DBC_SCHEMATA_PRODUCT__ . ' as product', 'product.id = orddet.productid')
            ->join(__DBC_SCHEMATA_PRODUCT_CATEGORY__ . ' as cat', 'cat.id = product.szProductCategory')
            ->where($whereAry)
            ->get();
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
            return $row;
        } else {
            $this->addError("norecord", "No order found.");
            return false;
        }
    }

    function canceldonorcoc($donorid)
    {
        $donorupdate = array(
            'result' => '0',
            'drug' => '',
            'alcoholreading1' => '',
            'alcoholreading2' => '',
            'lab' => '',
            'cocid' => '0',
            'cocstatus' => '0'
        );
        $whereAry = array('id' => (int)$donorid);
        $updateq = $this->db->where($whereAry)
            ->update(__DBC_SCHEMATA_DONER__, $donorupdate);
        if ($updateq) {
            return true;
        } else {
            return false;
        }
    }

    function delUsedKit($kitid)
    {
        $whereAry = 'id =' . (int)$kitid;
        $query = $this->db->where($whereAry)
            ->delete(__DBC_SCHEMATA_USED_KITS__);
        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    function inventoryCheck($franchiseeid, $sosid)
    {
        $usedKitarr = $this->getSavedKitsBySosid($sosid);
        if (!empty($usedKitarr)) {
            $counter = 0;
            $checkCount = 0;
            foreach ($usedKitarr as $kit) {
                $counter++;
                $availInvArr = $this->getFranchiseeInventory($franchiseeid, $kit['prodid']);
                if (!empty($availInvArr) && ($availInvArr[0]['szQuantity'] >= $kit['quantity'])) {
                    if ($this->adjustFranchiseeInventory($availInvArr[0]['id'], $kit['quantity'])) {
                        $this->markKitStatusUsed($kit['id']);
                        $checkCount++;
                    }
                }
            }
            if ($checkCount == $counter) {
                if ($this->marksoscomplete($sosid)) {
                    return true;
                }
            } else {
                return false;
            }
        } else {
            return true;
        }
    }

    function getSavedKitsBySosid($sosid, $used = 0)
    {
        $array = array('kits.sosid' => (int)$sosid, 'kits.used' => (int)$used);
        $query = $this->db->select('kits.id, kits.prodid, kits.quantity, kits.used, prods.szProductCode')
            ->from(__DBC_SCHEMATA_USED_KITS__ . ' as kits')
            ->join(__DBC_SCHEMATA_PRODUCT__ . ' as prods', 'kits.prodid = prods.id')
            ->where($array)
            ->get();
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
            return $row;
        } else {
            $this->addError("norecord", "No kits found.");
        }
    }

    function getFranchiseeInventory($franchiseeid, $prodid)
    {
        $array = array('iFranchiseeId' => (int)$franchiseeid, 'iProductId' => (int)$prodid);
        $query = $this->db->select('id, szQuantity')
            ->from(__DBC_SCHEMATA_PRODUCT_STOCK_QUANTITY__)
            ->where($array)
            ->get();
        /*$q = $this->db->last_query();
        die($q);*/
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
            return $row;
        } else {
            $this->addError("norecord", "No record found.");
        }
    }

    function adjustFranchiseeInventory($id, $qty)
    {
        $whereAry = array('id' => (int)$id);
        $this->db->where($whereAry)
            ->set('szQuantity', 'szQuantity-' . (int)$qty, FALSE)
            ->update(__DBC_SCHEMATA_PRODUCT_STOCK_QUANTITY__);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function markKitStatusUsed($id)
    {
        $stockAry = array(
            'used' => '1'
        );
        $whereAry = array('id' => (int)$id);
        $this->db->where($whereAry)
            ->update(__DBC_SCHEMATA_USED_KITS__, $stockAry);
    }

    function marksoscomplete($sosid)
    {
        $statusarr = array('Status' => '1','updated_on' => date('Y-m-d h:i:s'));
        $conditionarr = array('id' => (int)$sosid);
        $q = $this->db->where($conditionarr)
            ->update(__DBC_SCHEMATA_SOS_FORM__, $statusarr);
        if ($q) {
            return true;
        } else {
            $this->addError("error", "Something went wrong. Please try again.");
            return false;
        }
    }

    function getcocdatabycocid($cocid)
    {
        $whereAry = 'id =' . (int)$cocid;
        $query = $this->db->select('*')
            ->from(__DBC_SCHEMATA_COC_FORM__)
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

    function getfranchiseeclientsitebysiteid($siteid)
    {
        $data = array();
        $sitedetarr = $this->getclientdetailsbyclientid($siteid);
        if (!empty($sitedetarr)) {
            $data['sitename'] = $sitedetarr[0]['szName'];
            $clientarr = $this->getuserdetails($sitedetarr[0]['clientType']);
            $data['clientname'] = (!empty($clientarr[0]['szName']) ? $clientarr[0]['szName'] : '');
            $franchiseearr = $this->getuserdetails($sitedetarr[0]['franchiseeId']);
            $data['franchiseename'] = (!empty($franchiseearr[0]['szName']) ? $franchiseearr[0]['szName'] : '');
        }
        return $data;
    }

    function getclientdetailsbyclientid($clientid)
    {
        $whereAry = array('client.clientId' => (int)$clientid, 'user.isDeleted' => '0');
        $query = $this->db->select('client.id, user.id as userid, user.szName,
                                     user.szEmail, user.szContactNumber, user.szAddress, user.szZipCode,
                                     user.szCity, user.szCountry, client.clientType, client.franchiseeId, client.szBusinessName')
            ->from(__DBC_SCHEMATA_CLIENT__ . ' as client')
            ->join(__DBC_SCHEMATA_USERS__ . ' as user', 'user.id = client.clientId')
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

    function getfranchiseeorders($franchiseeid)
    {
        $array = array('franchiseeid' => (int)$franchiseeid, 'validorder' => 1);
        $query = $this->db->select('id, price, status, createdon, dispatchedon, canceledon')
            ->from(__DBC_SCHEMATA_ORDER__)
            ->where($array)
            ->order_by('id', 'DESC')
            ->get();
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
            return $row;
        } else {
            return false;
        }
    }

    function getagentfranchisee($agentid)
    {
        $whereAry = 'agentid = ' . (int)$agentid;
        $query = $this->db->select('*')
            ->from(__DBC_SCHEMATA_AGENT_FRANCHISEE__)
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

    function savecollsign($siteid, $imgname, $fieldname, $status)
    {
        $wheresosAry = array('Clientid' => (int)$siteid, 'Status' => $status);
        $dataAry = array($fieldname => $imgname);
        $query = $this->db->where($wheresosAry)
            ->update(__DBC_SCHEMATA_SOS_FORM__, $dataAry);
        /* $q = $this->db->last_query();
         die($q);*/
        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    function savecocsign($cocid, $imgname, $fieldname)
    {
        $wheresosAry = array('id' => (int)$cocid);
        $dataAry = array($fieldname => $imgname);
        $query = $this->db->where($wheresosAry)
            ->update(__DBC_SCHEMATA_COC_FORM__, $dataAry);
        /* $q = $this->db->last_query();
         die($q);*/
        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    function getFranchiseeWithClient($clientId, $franchiseeid)
    {
        $whereAry = array('clientId' => $clientId, 'franchiseeId' => $franchiseeid, 'isDeleted=' => '0');
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

    function AddLabAdviceForm($sosid,$labFormName){
        $updatearr = array('lab_form' => $labFormName);
        $conditionarr = array('id' => (int)$sosid);
        $this->db->where($conditionarr)
            ->update(__DBC_SCHEMATA_SOS_FORM__, $updatearr);
        if($this->db->affected_rows() > 0){
            $sosDataArr = $this->getsosformdatabysosid($sosid);
            if(!empty($sosDataArr)){
                return $sosDataArr[0]['lab_form'];
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    function addsosdataOpenCoc($data)
    {
        $data['testdate'] = $this->formatdate($data['sosdate']);
        if ($data['status'] == '1' || $data['cocstat'] == '1') {
            $drgtestitemcount = strlen($data['drugtest']);
            $alc = false;
            $oral = false;
            $urine = false;
            $UZ = false;
            if ($drgtestitemcount == 1) {
                if ($data['drugtest'] == '1') {
                    $alc = true;
                } elseif ($data['drugtest'] == '2') {
                    $oral = true;
                } elseif ($data['drugtest'] == '3') {
                    $urine = true;
                } elseif ($data['drugtest'] == '4') {
                    $UZ = true;
                }
            } elseif ($drgtestitemcount > 1) {
                $drgtestarr = explode(',', $data['drugtest']);
                foreach ($drgtestarr as $key => $value) {
                    if ($value == '1') {
                        $alc = true;
                    } elseif ($value == '2') {
                        $oral = true;
                    } elseif ($value == '3') {
                        $urine = true;
                    } elseif ($value == '4') {
                        $UZ = true;
                    }
                }
            }
            $this->set_fieldReq(sanitize_all_html_input(trim($data['testdate'])), 'testdate', 'Date', true, __VLD_CASE_DATE__);
            $this->set_fieldReq(sanitize_all_html_input(trim($data['site'])), 'site', 'Site', true);
            $this->set_fieldReq(sanitize_all_html_input(trim($data['drugtest'])), 'drugtest', 'Drug to be tested', true);
            $this->set_fieldReq(sanitize_all_html_input(trim($data['other_drug_test'])), 'othertest', 'Other Test Name', ($data['otherTestCheck']?true:false));
            $this->set_fieldReq(sanitize_all_html_input(trim($data['screenfacility'])), 'screenfacility', 'Screening Facilities', true);
            $this->set_fieldReq(sanitize_all_html_input(trim($data['start_km'])), 'startkm', 'Start(km)', false,__VLD_CASE_DECIMAL__);
            $this->set_fieldReq(sanitize_all_html_input(trim($data['end_km'])), 'endkm', 'End(km)', false,__VLD_CASE_DECIMAL__);
            $this->set_fieldReq(sanitize_all_html_input(trim($data['total_km'])), 'totalkm', 'Total(km)', false,__VLD_CASE_DECIMAL__);
            $this->set_fieldReq(sanitize_all_html_input(trim($data['servicecomm'])), 'servicecomm', 'Service commenced', true);
            $this->set_fieldReq(sanitize_all_html_input(trim($data['servicecon'])), 'servicecon', 'Service concluded', true);
            $this->set_fieldReq(sanitize_all_html_input(trim($data['totscreenu'])), 'totscreenu', 'Total Donor Screenings/Collections Urine', ($urine || $UZ ? true : false), __VLD_CASE_DIGITS__);
            $this->set_fieldReq(sanitize_all_html_input(trim($data['totscreeno'])), 'totscreeno', 'Total Donor Screenings/Collections Oral', $oral, __VLD_CASE_DIGITS__);
            $this->set_fieldReq(sanitize_all_html_input(trim($data['negresu'])), 'negresu', 'Negative Results Urine', ($urine || $UZ ? true : false), __VLD_CASE_DIGITS__);
            $this->set_fieldReq(sanitize_all_html_input(trim($data['negreso'])), 'negreso', 'Negative Results Oral', $oral, __VLD_CASE_DIGITS__);
            $this->set_fieldReq(sanitize_all_html_input(trim($data['furtestu'])), 'furtestu', 'Results Requiring Further Testing Urine', ($urine || $UZ ? true : false), __VLD_CASE_DIGITS__);
            $this->set_fieldReq(sanitize_all_html_input(trim($data['furtesto'])), 'furtesto', 'Results Requiring Further Testing Oral', $oral, __VLD_CASE_DIGITS__);
            $this->set_fieldReq(sanitize_all_html_input(trim($data['totalcscreen'])), 'totalcscreen', 'Total No Alcohol Screen', $alc, __VLD_CASE_DIGITS__);
            $this->set_fieldReq(sanitize_all_html_input(trim($data['negalcres'])), 'negalcres', 'Negative Alcohol Results', $alc, __VLD_CASE_DIGITS__);
            $this->set_fieldReq(sanitize_all_html_input(trim($data['posalcres'])), 'posalcres', 'Positive Alcohol Results', $alc, __VLD_CASE_DIGITS__);
            $this->set_fieldReq(sanitize_all_html_input(trim($data['refusals'])), 'refusals', 'Refusals', true, __VLD_CASE_DIGITS__);
            $this->set_fieldReq(sanitize_all_html_input(trim($data['devicename'])), 'devicename', 'Device Name', false);
            $this->set_fieldReq(sanitize_all_html_input(trim($data['extraused'])), 'extraused', 'Extra Used', false);
            $this->set_fieldReq(sanitize_all_html_input(trim($data['breathtest'])), 'breathtest', 'Breath Testing Unit', false);
            $this->set_fieldReq(sanitize_all_html_input(trim($data['collname'])), 'collname', 'Collector Name', true);
            $this->set_fieldReq(sanitize_all_html_input(trim($data['sign1'])), 'sign1', 'Collector Signature', true);
            //$this->set_fieldReq(sanitize_all_html_input(trim($data['collsign'])), 'collsign', 'Collector Signature', true);
            $this->set_fieldReq(sanitize_all_html_input(trim($data['nominated'])), 'nominated', 'Nominated Client Representative', true, __VLD_CASE_NAME__);
            $this->set_fieldReq(sanitize_all_html_input(trim($data['nominedec'])), 'nominedec', 'Nominated Client Representative signature time', true);
            $this->set_fieldReq(sanitize_all_html_input(trim($data['sign2'])), 'sign2', 'Nominated Client Representative signature', true);
        }
        if ($this->error) {
            return false;
        } else {
            $dataAry = array(
                'testdate' => date('Y-m-d', strtotime($data['testdate'])),
                'Clientid' => $data['site'],
                'Drugtestid' => $data['drugtest'],
                'other_drug_test' => $data['other_drug_test'],
                'screening_facilities' => $data['screenfacility'],
                'ServiceCommencedOn' => $data['servicecomm'],
                'ServiceConcludedOn' => $data['servicecon'],
                'start_km' => $data['start_km'],
                'end_km' => $data['end_km'],
                'total_km' => $data['total_km'],
                'FurtherTestRequired' => $data['furthertestreq'],
                'TotalDonarScreeningUrine' => $data['totscreenu'],
                'TotalDonarScreeningOral' => $data['totscreeno'],
                'NegativeResultUrine' => $data['negresu'],
                'NegativeResultOral' => $data['negreso'],
                'FurtherTestUrine' => $data['furtestu'],
                'FurtherTestOral' => $data['furtesto'],
                'TotalAlcoholScreening' => $data['totalcscreen'],
                'NegativeAlcohol' => $data['negalcres'],
                'PositiveAlcohol' => $data['posalcres'],
                'Refusals' => $data['refusals'],
                'DeviceName' => $data['devicename'],
                'ExtraUsed' => $data['extraused'],
                'BreathTesting' => $data['breathtest'],
                'Comments' => $data['comments'],
                'ClientRepresentative' => $data['nominated'],
                'RepresentativeSignatureTime' => $data['nominedec'],
                'Status' => $data['status'],
                'collname' => $data['collname'],
                'sign1' => $data['sign1'],
                'sign2' => $data['sign2'],
                'agent_comment' => $data['agent_comment'],
                'createdBy' => $data['userid']
            );
            if ($data['update'] == '1') {
                $sosid = (int)$data['idsos'];
                $wheresosAry = array('id' => (int)$sosid);
                $this->db->where($wheresosAry)
                    ->update(__DBC_SCHEMATA_SOS_FORM__, $dataAry);
                $failarr = array("sosid" => $sosid);
                $donerid = $data['donorid'];
                    if (!empty($data['donorname'])) {
                        /*$donerAry = array(
                            'donerName' => (!empty($data['donorname'])?$data['donorname']:''),
                            'result' => (!empty($data['drugresult'])?$data['drugresult']:''),
                            'drug' => (!empty($data['drugtype'])?$data['drugtype']:''),
                            'alcoholreading1' => (!empty($data['pos1read'])?$data['pos1read']:''),
                            'alcoholreading2' => (!empty($data['pos2read'])?$data['pos2read']:''),
                            'lab' => (!empty($data['lab'])?$data['lab']:''),
                            'sosid' => (int)$sosid,
                            'otherdrug' => (!empty($data['oth'])?$data['oth']:'')
                        );*/
                        $donerAry = array(
                            'donerName' => (!empty($data['donorname'])?$data['donorname']:''),
                            'sosid' => (int)$sosid
                        );
                        if($donerid > 0) {
                            $weherecocarr = array('id' => (int)$data['donorid']);
                            $this->db->where($weherecocarr)
                                ->update(__DBC_SCHEMATA_DONER__, $donerAry);
                        }
                    }


                $datacocarr = array();
                if($donerid>0){
                    $datacocarr = $this->getDonorByID($donerid);
                }
                if (!empty($datacocarr)) {
                    if ($datacocarr['totalcoc'] > '1') {
                        $failarr = array("totalcoccount" => $datacocarr, "sosid" => $sosid);
                    } else {
                        $singlecocarr = $this->getDonorDetByID($donerid);
//                        $singlecocarr = $this->getcocidbysosid($sosid);
                        $failarr = array("totalcoccount" => $datacocarr, "sosid" => $sosid, "cocid" => $singlecocarr);
                    }
                }
                return $failarr;
            } else {
                $sosid = (int)$data['idsos'];
                if($sosid > 0){
                    $wheresosAry = array('id' => (int)$sosid);
                    $this->db->where($wheresosAry)
                        ->update(__DBC_SCHEMATA_SOS_FORM__, $dataAry);
                }else{
                    $this->db->insert(__DBC_SCHEMATA_SOS_FORM__, $dataAry);
                }
                $donerid = 0;
                if ($sosid > 0 || $this->db->affected_rows() > 0) {
                    if($sosid == '0'){
                        $sosid = (int)$this->db->insert_id();
                    }
                    $failarr = array("sosid" => $sosid);
                        if (!empty($data['donorname'])) {
                            /*$donerAry = array(
                                'donerName' => (!empty($data['donorname'])?$data['donorname']:''),
                                'result' => (!empty($data['drugresult'])?$data['drugresult']:''),
                                'drug' => (!empty($data['drugtype'])?$data['drugtype']:''),
                                'alcoholreading1' => (!empty($data['pos1read'])?$data['pos1read']:''),
                                'alcoholreading2' => (!empty($data['pos2read'])?$data['pos2read']:''),
                                'lab' => (!empty($data['lab'])?$data['lab']:''),
                                'sosid' => (int)$sosid,
                                'otherdrug' => (!empty($data['oth'])?$data['oth']:'')
                            );*/
                            $donerAry = array(
                                'donerName' => (!empty($data['donorname'])?$data['donorname']:''),
                                'sosid' => (int)$sosid
                            );
                            $this->db->insert(__DBC_SCHEMATA_DONER__, $donerAry);
                            if ($this->db->affected_rows() > 0) {
                                $donerid = $this->db->insert_id();
                                $cocdatearr = array('cocdate' => date('Y-m-d', strtotime($data['testdate'])));
                                $this->db->insert(__DBC_SCHEMATA_COC_FORM__, $cocdatearr);
                                if ($this->db->affected_rows() > 0) {
                                    $cocid = $this->db->insert_id();
                                    $updatearr = array('cocid' => (int)$cocid);
                                    $whereAry = array('id' => (int)$donerid);
                                    $this->db->where($whereAry)
                                        ->update(__DBC_SCHEMATA_DONER__, $updatearr);
                                    if (!($this->db->affected_rows() > 0)) {
                                        $message = "Some error occurred while adding " . $data['donorname'] . " donor.";
                                        array_push($failarr, $message);
                                    }
                                }
                            } elseif (!($this->db->affected_rows() > 0)) {
                                $message = "Some error occurred while adding " . $data['donorname'] . " donor.";
                                array_push($failarr, $message);
                            }
                        }
                    $datacocarr = array();
                    if($donerid>0){
                        $datacocarr = $this->getDonorByID($donerid);
                    }
                    if (!empty($datacocarr)) {
                        if ($datacocarr['totalcoc'] > '1') {
                            $failarr = array("totalcoccount" => $datacocarr, "sosid" => $sosid);
                        } else {
                            $singlecocarr = $this->getDonorDetByID($donerid);
                            $failarr = array("totalcoccount" => $datacocarr, "sosid" => $sosid, "cocid" => $singlecocarr);
                        }
                    }
                    return $failarr;
                } else {
                    $failarr = array("No data inserted");
                    return $failarr;
                }
            }
        }
    }
} 