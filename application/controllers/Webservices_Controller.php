<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Webservices_Controller extends CI_Controller
{
    function __construct()
    {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        parent::__construct();
        $this->load->model('Error_Model');
        $this->load->model('Admin_Model');
        $this->load->model('Franchisee_Model');
        $this->load->model('Webservices_Model');
        $this->load->model('Order_Model');
        $this->load->model('Inventory_Model');
        $this->load->model('Forum_Model');
    }

    public function index()
    {
        $message = 'Permission Denied!!!';
        $responsedata = array("message" => $message);
        header('Content-Type: application/json');
        echo json_encode($responsedata);
    }

    public function userlogin()
    {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $jsondata = json_decode(file_get_contents("php://input"));
        $data['user']['szEmail'] = !empty($jsondata->szEmail) ? $jsondata->szEmail : "";
        $data['user']['szPassword'] = !empty($jsondata->szPassword) ? $jsondata->szPassword : "";
        $data['user']['szrole'] = !empty($jsondata->szrole) ? $jsondata->szrole : "cl";
        $userLoginArr = $this->Webservices_Model->validateuser($data['user']);
        if (!empty($userLoginArr)) {
            $responsedata = array("code" => 200, "message" => "User logged in sucessfully.", "userid" => $userLoginArr['id'], "role" => $userLoginArr['iRole']);
            header('Content-Type: application/json');
        } else {
            $errorMsgArr = $this->Webservices_Model->arErrorMessages;
            if (!empty($errorMsgArr) && !empty($errorMsgArr['szEmail'])) {
                $responsedata = array("code" => 201, "message" => $errorMsgArr['szEmail']);
                header('Content-Type: application/json');

            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['szPassword'])) {
                $responsedata = array("code" => 202, "message" => "Wrong credentials");
                header('Content-Type: application/json');
            } else {
                $responsedata = array("code" => 111, "message" => "Bad Request.");
                header('Content-Type: application/json');
            }
        }
        echo json_encode($responsedata);
    }

    function getuserdetails()
    {
        $jsondata = json_decode(file_get_contents("php://input"));
        $userid = !empty($jsondata->userid) ? $jsondata->userid : "";
        $userDetailsArr = $this->Webservices_Model->getuserdetails($userid);
        if (!empty($userDetailsArr)) {
            $responsedata = array("code" => 200,
                "message" => "User record retrieved successfully.",
                "userid" => $userDetailsArr[0]['id'],
                "szName" => $userDetailsArr[0]['szName'],
                "szEmail" => $userDetailsArr[0]['szEmail'],
                "iRole" => $userDetailsArr[0]['iRole']);
            header('Content-Type: application/json');
        } else {
            $errorMsgArr = $this->Webservices_Model->arErrorMessages;
            if (!empty($errorMsgArr) && !empty($errorMsgArr['usernotexist'])) {
                $responsedata = array("code" => 201, "message" => $errorMsgArr['usernotexist']);
                header('Content-Type: application/json');

            } else {
                $responsedata = array("code" => 111, "message" => "Bad Request.");
                header('Content-Type: application/json');
            }
        }
        echo json_encode($responsedata);
    }

    function getclientdetails()
    {
        $jsondata = json_decode(file_get_contents("php://input"));
        $franchiseeid = !empty($jsondata->franchiseeid) ? $jsondata->franchiseeid : "";
        $parentid = !empty($jsondata->parentid) ? $jsondata->parentid : "0";
        $agentid = !empty($jsondata->agentid) ? $jsondata->agentid : "0";
        $loggedinFranchisee = 0;
        $NominatedClientName = '';
        if ($parentid > 0) {
            $loggedinFranchisee = $franchiseeid;
            $clientDetsArr = $this->Webservices_Model->getclientdetailsbyclientid($parentid);
            if (!empty($clientDetsArr)) {
                $franchiseeid = $clientDetsArr[0]['franchiseeId'];
                $NominatedClientName = $clientDetsArr[0]['szName'];
                $ClientName = $clientDetsArr[0]['szBusinessName'];
            }
        }
        $userDetailsArr = $this->Webservices_Model->getclientdetails($franchiseeid, $parentid, $agentid);
        if ($parentid == 0) {
            $AssignCorpuserDetailsArr = $this->Webservices_Model->getcorpclientdetails($franchiseeid);
            if (!empty($AssignCorpuserDetailsArr)) {
                $CorpuserDetailsArr = array();
                foreach ($AssignCorpuserDetailsArr as $assignCorpUser) {
                    $CorpSitesDetailsArr = $this->Webservices_Model->getclientdetails($assignCorpUser['corpfrid']);
                    if (!empty($CorpSitesDetailsArr)) {
                        foreach ($CorpSitesDetailsArr as $CorpUser) {
                            array_push($CorpuserDetailsArr, $CorpUser);
                        }
                    }
                }

            }
        }
        if ($parentid > 0) {
            $AssignCorpuserDetailsArr = $this->Webservices_Model->getcorpclientdetails($loggedinFranchisee, $franchiseeid);
            if (!empty($AssignCorpuserDetailsArr)) {
                $userDetailsArr = array();
                foreach ($AssignCorpuserDetailsArr as $assignCorpUser) {
                    $CorpuserDetailsArr = $this->Webservices_Model->getclientdetails($assignCorpUser['corpfrid'], $parentid, $agentid, $assignCorpUser['clientid']);
                    if (!empty($CorpuserDetailsArr)) {
                        foreach ($CorpuserDetailsArr as $CorpUser) {
                            array_push($userDetailsArr, $CorpUser);
                        }
                    }
                }
            }
        }
        /*$CorpClient = array();
            if(!empty($AssignCorpuserDetailsArr)){
                $i=sizeof($userDetailsArr);
                foreach ($AssignCorpuserDetailsArr as $AssignCorpUsr){
                    if(!in_array($AssignCorpUsr['id'],$userDetailsArr)){
                        array_push($userDetailsArr[$i], $AssignCorpUsr);
                        $i++;
                    }
                }
            }*/
        if ($parentid == 0 && !empty($userDetailsArr) && !empty($CorpuserDetailsArr)) {
            $allClients = array_merge($userDetailsArr, $CorpuserDetailsArr);
        } else {
            $allClients = $userDetailsArr;
        }

        if (!empty($userDetailsArr)) {
            $responsedata = array("code" => 200,
                "message" => "Franchisee clients/sites record retrieved successfully.",
                "userid" => $userDetailsArr[0]['id'],
                "szName" => $userDetailsArr[0]['szName'],
                "NominatedClientName" => $NominatedClientName,
                "szEmail" => $userDetailsArr[0]['szEmail'],
                "dataarr" => $allClients);
            header('Content-Type: application/json');
        } else {
            $responsedata = array("code" => 111, "message" => "Bad Request.");
            header('Content-Type: application/json');
        }
        echo json_encode($responsedata);
    }

    function addsosdata()
    {
        $jsondata = json_decode(file_get_contents("php://input"));
        $dataArr['sosdate'] = !empty($jsondata->sosdate) ? $jsondata->sosdate : "";
        $dataArr['userid'] = !empty($jsondata->userid) ? $jsondata->userid : "0";
        $dataArr['reqclient'] = !empty($jsondata->reqclient) ? $jsondata->reqclient : "";
        $dataArr['site'] = !empty($jsondata->site) ? $jsondata->site : "";
        $dataArr['other_drug_test'] = !empty($jsondata->othertest) ? $jsondata->othertest : "";
        $drug = '';
        $otherTest = false;
        $dsarrcount = count($jsondata->drugtest);

        if (!is_array($jsondata->drugtest)) {
            $drug = $jsondata->drugtest;
            if($drug == '5'){
                $otherTest = true;
            }
        } elseif (($dsarrcount > '1') && !empty($jsondata->drugtest)) {
            foreach ($jsondata->drugtest as $key => $value) {
                if ($value == '5') {
                    $otherTest = true;
                }
                $drug .= $value . ',';
            }
            if (!empty($drug)) {
                $drug = substr($drug, 0, -1);
            }
        }
        if ($otherTest) {
            $dataArr['otherTestCheck'] = true;
            $dataArr['other_drug_test'] = $dataArr['other_drug_test'];
        } else {
            $dataArr['otherTestCheck'] = false;
            $dataArr['other_drug_test'] = '';
        }
        $ServiceFac = '';
        $SFArrcount = count($jsondata->screenfacility);
        if ($SFArrcount == '1') {
            $ServiceFac = $jsondata->screenfacility;
        } elseif (($SFArrcount > '1') && !empty($jsondata->screenfacility)) {
            foreach ($jsondata->screenfacility as $SFkey => $SFvalue) {
                $ServiceFac .= $SFvalue . ',';
            }
            if (!empty($ServiceFac)) {
                $ServiceFac = substr($ServiceFac, 0, -1);
            }
        }

        $dataArr['drugtest'] = $drug;
        $dataArr['screenfacility'] = $ServiceFac;
        $dataArr['start_km'] = !empty($jsondata->startkm) ? $jsondata->startkm : "0";
        $dataArr['end_km'] = !empty($jsondata->endkm) ? $jsondata->endkm : "0";
        $dataArr['total_km'] = !empty($jsondata->totalkm) ? $jsondata->totalkm : "0";
        $dataArr['formtype'] = $jsondata->formtype;
        $dataArr['status'] = !empty($jsondata->status) ? $jsondata->status : "0";
        $dataArr['servicecomm'] = !empty($jsondata->servicecomm) ? $jsondata->servicecomm : "";
        $dataArr['donercount'] = !empty($jsondata->donercount) ? $jsondata->donercount : "1";
        $dataArr['servicecon'] = !empty($jsondata->servicecon) ? $jsondata->servicecon : "";
        $dataArr['totscreenu'] = $jsondata->totscreenu;
        $dataArr['totscreeno'] = $jsondata->totscreeno;
        $dataArr['negresu'] = $jsondata->negresu;
        $dataArr['negreso'] = $jsondata->negreso;
        $dataArr['furtestu'] = $jsondata->furtestu;
        $dataArr['furtesto'] = $jsondata->furtesto;
        $dataArr['totalcscreen'] = $jsondata->totalcscreen;
        $dataArr['negalcres'] = $jsondata->negalcres;
        $dataArr['posalcres'] = $jsondata->posalcres;
        $dataArr['refusals'] = $jsondata->refusals;
        $dataArr['devicename'] = !empty($jsondata->devicename) ? $jsondata->devicename : "";
        $dataArr['extraused'] = !empty($jsondata->extraused) ? $jsondata->extraused : "";
        $dataArr['breathtest'] = !empty($jsondata->breathtest) ? $jsondata->breathtest : "";
        $dataArr['collname'] = !empty($jsondata->collname) ? $jsondata->collname : "";
        $dataArr['collsign'] = !empty($jsondata->collsign) ? $jsondata->collsign : "";
        $dataArr['comments'] = !empty($jsondata->comments) ? $jsondata->comments : "";
        $dataArr['nominated'] = !empty($jsondata->nominated) ? $jsondata->nominated : "";
        $dataArr['nominedec'] = !empty($jsondata->nominedec) ? $jsondata->nominedec : "";
        $dataArr['sign'] = !empty($jsondata->sign) ? $jsondata->sign : "";
        $dataArr['update'] = !empty($jsondata->update) ? $jsondata->update : "";
        $dataArr['donercountpre'] = !empty($jsondata->donercountpre) ? $jsondata->donercountpre : "";
        $dataArr['donercountpost'] = !empty($jsondata->donercountpost) ? $jsondata->donercountpost : "";
        $dataArr['newdonerids'] = !empty($jsondata->newdonerids) ? $jsondata->newdonerids : "";
        $dataArr['idsos'] = !empty($jsondata->idsos) ? $jsondata->idsos : "";
        $dataArr['cocstat'] = !empty($jsondata->cocstat) ? $jsondata->cocstat : "0";
        $dataArr['kitcount'] = !empty($jsondata->kitcount) ? $jsondata->kitcount : "1";
        $dataArr['oldkitcount'] = !empty($jsondata->oldkitcount) ? $jsondata->oldkitcount : "0";
        $dataArr['totalkitcount'] = !empty($jsondata->totalkitcount) ? $jsondata->totalkitcount : "0";
        $dataArr['newkitids'] = !empty($jsondata->newkitids) ? $jsondata->newkitids : "";
        $dataArr['sign1'] = $jsondata->sign1;
        $dataArr['sign2'] = $jsondata->sign2;
        $dataArr['agent_comment'] = !empty($jsondata->agentcomment) ? $jsondata->agentcomment : "";
        for ($i = 1; $i <= $dataArr['donercount']; $i++) {
            $namevar = 'name' . $i;
            $resultvar = 'result' . $i;
            $drugvar = 'drug' . $i;
            $alcoholvar = 'alcohol' . $i;
            $labvar = 'lab' . $i;
            $drugtypevar = 'drugtype' . $i;
            $pos1readvar = 'pos1read' . $i;
            $pos2readvar = 'pos2read' . $i;
            $idcoc = 'idcoc' . $i;
            $iddonor = 'iddonor' . $i;
            $othvar = 'oth' . $i;
            $dataArr['name' . $i] = !empty($jsondata->$namevar) ? $jsondata->$namevar : "";
            $dataArr['result' . $i] = !empty($jsondata->$resultvar) ? $jsondata->$resultvar : "0";
            if ($jsondata->$drugvar == "1") {
                $dataArr['drug' . $i] = !empty($jsondata->$drugvar) ? $jsondata->$drugvar : "0";
            } else {
                $dataArr['drug' . $i] = "";
            }
            $dataArr['alcohol' . $i] = !empty($jsondata->$alcoholvar) ? $jsondata->$alcoholvar : "0";
            $dataArr['lab' . $i] = !empty($jsondata->$labvar) ? $jsondata->$labvar : "";
            $dataArr['idcoc' . $i] = !empty($jsondata->$idcoc) ? $jsondata->$idcoc : "0";
            $dataArr['iddonor' . $i] = !empty($jsondata->$iddonor) ? $jsondata->$iddonor : "";
            if ($dataArr['drug' . $i] == '1') {
                $dataArr['oth' . $i] = !empty($jsondata->$othvar) ? $jsondata->$othvar : "";
            } else {
                $dataArr['oth' . $i] = "";
            }

            $drugtype = '';
            if (!empty($jsondata->$drugtypevar)) {
                $drugtype = '';
                if (count($jsondata->$drugtypevar) > '1') {
                    foreach ($jsondata->$drugtypevar as $key => $value) {
                        $drugtype .= $value . ',';
                    }
                    if (!empty($drugtype)) {
                        $drugtype = substr($drugtype, 0, -1);
                    }
                } else {
                    $drugtype = $jsondata->$drugtypevar;
                }

            }
            $dataArr['drugtype' . $i] = ($dataArr['drug' . $i] == '1' ? $drugtype : '');
            if ($dataArr['alcohol' . $i] == "1") {
                $dataArr['pos1read' . $i] = !empty($jsondata->$pos1readvar) ? $jsondata->$pos1readvar : "";
                $dataArr['pos2read' . $i] = !empty($jsondata->$pos2readvar) ? $jsondata->$pos2readvar : "";
            } else {
                $dataArr['pos1read' . $i] = "";
                $dataArr['pos2read' . $i] = "";
            }

        }

        for ($dc = 1; $dc <= $dataArr['kitcount']; $dc++) {
            $prodvar = 'kit' . $dc;
            $qtyvar = 'kitqty' . $dc;
            $kitidvar = 'kitid' . $dc;
            $dataArr['kit' . $dc] = !empty($jsondata->$prodvar) ? $jsondata->$prodvar : "";
            $dataArr['kitqty' . $dc] = !empty($jsondata->$qtyvar) ? $jsondata->$qtyvar : "0";
            $dataArr['kitid' . $dc] = !empty($jsondata->$kitidvar) ? $jsondata->$kitidvar : "0";
        }

        if (($dataArr['furtestu'] > 0) || ($dataArr['furtesto'] > 0)) {
            $dataArr['furthertestreq'] = '1';
        } else {
            $dataArr['furthertestreq'] = '0';
        }

        if (!empty($dataArr)) {

            $sosdatares = $this->Webservices_Model->addsosdata($dataArr);
            $errorMsgArr = $this->Webservices_Model->arErrorMessages;
            if (!empty($errorMsgArr) && !empty($errorMsgArr['testdate'])) {
                $responsedata = array("code" => 203, "message" => $errorMsgArr['testdate']);
            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['site'])) {
                $responsedata = array("code" => 203, "message" => $errorMsgArr['site']);
            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['drugtest'])) {
                $responsedata = array("code" => 203, "message" => $errorMsgArr['drugtest']);
            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['othertest'])) {
                $responsedata = array("code" => 203, "message" => $errorMsgArr['othertest']);
            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['screenfacility'])) {
                $responsedata = array("code" => 203, "message" => $errorMsgArr['screenfacility']);
            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['startkm'])) {
                $responsedata = array("code" => 203, "message" => $errorMsgArr['start_km']);
            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['endkm'])) {
                $responsedata = array("code" => 203, "message" => $errorMsgArr['end_km']);
            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['totalkm'])) {
                $responsedata = array("code" => 203, "message" => $errorMsgArr['total_km']);
            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['servicecomm'])) {
                $responsedata = array("code" => 203, "message" => $errorMsgArr['servicecomm']);
            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['servicecon'])) {
                $responsedata = array("code" => 203, "message" => $errorMsgArr['servicecon']);
            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['totscreenu'])) {
                $responsedata = array("code" => 203, "message" => $errorMsgArr['totscreenu']);
            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['totscreeno'])) {
                $responsedata = array("code" => 203, "message" => $errorMsgArr['totscreeno']);
            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['negresu'])) {
                $responsedata = array("code" => 203, "message" => $errorMsgArr['negresu']);
            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['negreso'])) {
                $responsedata = array("code" => 203, "message" => $errorMsgArr['negreso']);
            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['furtestu'])) {
                $responsedata = array("code" => 203, "message" => $errorMsgArr['furtestu']);
            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['furtesto'])) {
                $responsedata = array("code" => 203, "message" => $errorMsgArr['furtesto']);
            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['totalcscreen'])) {
                $responsedata = array("code" => 203, "message" => $errorMsgArr['totalcscreen']);
            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['negalcres'])) {
                $responsedata = array("code" => 203, "message" => $errorMsgArr['negalcres']);
            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['posalcres'])) {
                $responsedata = array("code" => 203, "message" => $errorMsgArr['posalcres']);
            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['refusals'])) {
                $responsedata = array("code" => 203, "message" => $errorMsgArr['refusals']);
            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['devicename'])) {
                $responsedata = array("code" => 203, "message" => $errorMsgArr['devicename']);
            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['extraused'])) {
                $responsedata = array("code" => 203, "message" => $errorMsgArr['extraused']);
            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['breathtest'])) {
                $responsedata = array("code" => 203, "message" => $errorMsgArr['breathtest']);
            }elseif (!empty($errorMsgArr) && !empty($errorMsgArr['collname'])) {
                $responsedata = array("code" => 203, "message" => $errorMsgArr['collname']);
            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['sign1'])) {
                $responsedata = array("code" => 203, "message" => $errorMsgArr['collsign']);
            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['nominated'])) {
                $responsedata = array("code" => 203, "message" => $errorMsgArr['nominated']);
            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['nominedec'])) {
                $responsedata = array("code" => 203, "message" => $errorMsgArr['nominedec']);
            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['sign2'])) {
                $responsedata = array("code" => 203, "message" => "Nominated Client Representative signature required.");
            } elseif (!empty($sosdatares['totalcoccount'][0]['totalcoc'])) {
                $coccount = (int)$sosdatares['totalcoccount'][0]['totalcoc'];
                $cocid = (int)$sosdatares['cocid'][0]['cocid'];
                if ((int)$coccount > '1') {
                    $responsedata = array("code" => 200, "count" => (int)$coccount, "sosid" => $sosdatares['sosid'], "message" => "SOS form data saved successfully.");
                } else {
                    $responsedata = array("code" => 200, "count" => (int)$coccount, "sosid" => $sosdatares['sosid'], "cocid" => $cocid, "message" => "SOS form data saved successfully.");
                }

            } elseif ($sosdatares['sosid'] > 0) {
                $responsedata = array("code" => 200, "message" => "SOS form data saved successfully.", "sosid" => $sosdatares['sosid']);
            } else {
                $responsedata = array("code" => 201, "errordata" => $sosdatares);
            }
        } else {
            $responsedata = array("code" => 111, "message" => "Bad Request.");
        }
        header('Content-Type: application/json');
        echo json_encode($responsedata);
    }

    function getsosformdatabysiteid()
    {
        $jsondata = json_decode(file_get_contents("php://input"));
        $data['siteid'] = !empty($jsondata->siteid) ? $jsondata->siteid : "";
        $data['status'] = !empty($jsondata->status) ? $jsondata->status : "0";
        $sosformdata = $this->Webservices_Model->getsosformdata($data['siteid'], $data['status']);
        if (!empty($sosformdata)) {
            $responsedata = array("code" => 200, "dataarr" => $sosformdata);
            header('Content-Type: application/json');
        } else {
            $errorMsgArr = $this->Webservices_Model->arErrorMessages;
            if (!empty($errorMsgArr) && !empty($errorMsgArr['norecord'])) {
                $responsedata = array("code" => 201, "message" => $errorMsgArr['norecord']);
                header('Content-Type: application/json');

            } else {
                $responsedata = array("code" => 111, "message" => "Bad Request.");
                header('Content-Type: application/json');
            }
        }
        echo json_encode($responsedata);
    }

    function getsossitesbyfranchiseeid()
    {
        $jsondata = json_decode(file_get_contents("php://input"));
        $data['siteid'] = !empty($jsondata->siteid) ? $jsondata->siteid : "";
        $sosformdata = $this->Webservices_Model->getsossitesbyfranchiseeid($data['siteid']);
        if (!empty($sosformdata)) {
            $responsedata = array("code" => 200, "dataarr" => $sosformdata);
            header('Content-Type: application/json');
        } else {
            $responsedata = array("code" => 201, "message" => 'No site found');
            header('Content-Type: application/json');
        }
        echo json_encode($responsedata);
    }

    function getclientsites()
    {
        $jsondata = json_decode(file_get_contents("php://input"));
        $data['clientid'] = !empty($jsondata->clientid) ? $jsondata->clientid : "";
        $clientdata = $this->Webservices_Model->getclientsites($data['clientid']);
        if (!empty($clientdata)) {
            $responsedata = array("code" => 200, "dataarr" => $clientdata);
            header('Content-Type: application/json');
        } else {
            $errorMsgArr = $this->Webservices_Model->arErrorMessages;
            if (!empty($errorMsgArr) && !empty($errorMsgArr['norecord'])) {
                $responsedata = array("code" => 201, "message" => $errorMsgArr['norecord']);
                header('Content-Type: application/json');

            } else {
                $responsedata = array("code" => 111, "message" => "Bad Request.");
                header('Content-Type: application/json');
            }
        }
        echo json_encode($responsedata);
    }

    function getfranchiseeclients()
    {
        $jsondata = json_decode(file_get_contents("php://input"));
        $data['franchiseeid'] = !empty($jsondata->franchiseeid) ? $jsondata->franchiseeid : "";
        $franchiseedata = $this->Webservices_Model->getfranchiseeclients($data['franchiseeid']);
        if (!empty($franchiseedata)) {
            $responsedata = array("code" => 200, "dataarr" => $franchiseedata);
            header('Content-Type: application/json');
        } else {
            $errorMsgArr = $this->Webservices_Model->arErrorMessages;
            if (!empty($errorMsgArr) && !empty($errorMsgArr['norecord'])) {
                $responsedata = array("code" => 201, "message" => $errorMsgArr['norecord']);
                header('Content-Type: application/json');

            } else {
                $responsedata = array("code" => 111, "message" => "Bad Request.");
                header('Content-Type: application/json');
            }
        }
        echo json_encode($responsedata);
    }

    function getfranchiseesites()
    {
        $jsondata = json_decode(file_get_contents("php://input"));
        $data['franchiseeid'] = !empty($jsondata->franchiseeid) ? $jsondata->franchiseeid : "";
        $franchiseesitesdata = $this->Webservices_Model->getfranchiseesites($data['franchiseeid']);
        if (!empty($franchiseesitesdata[0])) {
            $responsedata = array("code" => 200, "dataarr" => $franchiseesitesdata[0]);
            header('Content-Type: application/json');
        } else {
            $errorMsgArr = $this->Webservices_Model->arErrorMessages;
            if (!empty($errorMsgArr) && !empty($errorMsgArr['norecord'])) {
                $responsedata = array("code" => 201, "message" => $errorMsgArr['norecord']);
                header('Content-Type: application/json');

            } else {
                $responsedata = array("code" => 111, "message" => "Bad Request.");
                header('Content-Type: application/json');
            }
        }
        echo json_encode($responsedata);
    }

    function getclientsallsosdata()
    {
        $jsondata = json_decode(file_get_contents("php://input"));
        $data['clientid'] = !empty($jsondata->clientid) ? $jsondata->clientid : "";
        $clientsosdata = $this->Webservices_Model->getclientsosformdata($data['clientid']);
        if (!empty($clientsosdata)) {
            $responsedata = array("code" => 200, "dataarr" => $clientsosdata);
            header('Content-Type: application/json');
        } else {
            $errorMsgArr = $this->Webservices_Model->arErrorMessages;
            if (!empty($errorMsgArr) && !empty($errorMsgArr['norecord'])) {
                $responsedata = array("code" => 201, "message" => $errorMsgArr['norecord']);
                header('Content-Type: application/json');

            } else {
                $responsedata = array("code" => 111, "message" => "Bad Request.");
                header('Content-Type: application/json');
            }
        }
        echo json_encode($responsedata);
    }

    function getfranchiseesosdata()
    {
        $jsondata = json_decode(file_get_contents("php://input"));
        $data['franchiseeid'] = !empty($jsondata->franchiseeid) ? $jsondata->franchiseeid : "";
        $data['status'] = $jsondata->status == '1' ? true : false;
        $corpFrArr = $this->Webservices_Model->getcorpclientdetails($data['franchiseeid']);
        $franchiseesosdata = $this->Webservices_Model->getfranchiseesosformdata($data['franchiseeid']);
        if (!empty($corpFrArr)) {
            foreach ($corpFrArr as $corpFr) {
                $CorpfranchiseesosdataArr = $this->Webservices_Model->getCorpfranchiseesosformdata($corpFr['corpfrid'], $corpFr['clientid']);
                if (!empty($CorpfranchiseesosdataArr)) {
                    foreach ($CorpfranchiseesosdataArr as $Corpfranchiseesosdata) {
                        if (!in_array($Corpfranchiseesosdata, $franchiseesosdata)) {
                            array_push($franchiseesosdata, $Corpfranchiseesosdata);
                        }
                    }
                }
            }
        }
        if (!empty($franchiseesosdata[0])) {
            $responsedata = array("code" => 200, "dataarr" => $franchiseesosdata);
            header('Content-Type: application/json');
        } else {
            $errorMsgArr = $this->Webservices_Model->arErrorMessages;
            if (!empty($errorMsgArr) && !empty($errorMsgArr['norecord'])) {
                $responsedata = array("code" => 201, "message" => $errorMsgArr['norecord']);
                header('Content-Type: application/json');

            } else {
                $responsedata = array("code" => 111, "message" => "Bad Request.");
                header('Content-Type: application/json');
            }
        }
        echo json_encode($responsedata);
    }

    function getagentsosdata()
    {
        $jsondata = json_decode(file_get_contents("php://input"));
        $data['agentid'] = !empty($jsondata->agentid) ? $jsondata->agentid : "";
        $data['status'] = $jsondata->status == '1' ? true : false;
        $agentsosdata = $this->Webservices_Model->getagentsosformdata($data['agentid']);
        if (!empty($agentsosdata[0])) {
            $responsedata = array("code" => 200, "dataarr" => $agentsosdata);
            header('Content-Type: application/json');
        } else {
            $errorMsgArr = $this->Webservices_Model->arErrorMessages;
            if (!empty($errorMsgArr) && !empty($errorMsgArr['norecord'])) {
                $responsedata = array("code" => 201, "message" => $errorMsgArr['norecord']);
                header('Content-Type: application/json');

            } else {
                $responsedata = array("code" => 111, "message" => "Bad Request.");
                header('Content-Type: application/json');
            }
        }
        echo json_encode($responsedata);
    }

    function getdonorsbysosid()
    {
        $jsondata = json_decode(file_get_contents("php://input"));
        $data['sosid'] = !empty($jsondata->sosid) ? $jsondata->sosid : "";
        $donordata = $this->Webservices_Model->getdonorsbysosid($data['sosid']);
        $allRecArr = array();
        if (!empty($donordata)) {
            foreach ($donordata as $records){
                $donorCocData = $this->Webservices_Model->getcocdatabycocid($records['cocid']);
                $donorCocData[0]['donerName'] = $records['donerName'];
                $donorCocData[0]['donorid'] = $records['id'];
                $donorCocData[0]['cocstatus'] = $records['cocstatus'];
                $donorCocData[0]['drug'] = $records['drug'];
                $donorCocData[0]['result'] = $records['result'];
                $donorCocData[0]['otherdrug'] = $records['otherdrug'];
                $donorCocData[0]['alcoholreading1'] = $records['alcoholreading1'];
                $donorCocData[0]['alcoholreading2'] = $records['alcoholreading2'];
                $donorCocData[0]['sosid'] = $records['sosid'];
                $donorCocData[0]['cocid'] = $records['cocid'];
                $donorCocData[0]['cocstatus'] = $records['cocstatus'];
                array_push($allRecArr,$donorCocData[0]);
            }
            $responsedata = array("code" => 200, "dataarr" => $allRecArr);
            header('Content-Type: application/json');
        } else {
            $errorMsgArr = $this->Webservices_Model->arErrorMessages;
            if (!empty($errorMsgArr) && !empty($errorMsgArr['norecord'])) {
                $responsedata = array("code" => 201, "message" => $errorMsgArr['norecord']);
                header('Content-Type: application/json');

            } else {
                $responsedata = array("code" => 111, "message" => "Bad Request.");
                header('Content-Type: application/json');
            }
        }
        echo json_encode($responsedata);
    }

    function getsosbycocid()
    {
        $jsondata = json_decode(file_get_contents("php://input"));
        $data['cocid'] = !empty($jsondata->cocid) ? $jsondata->cocid : "";
        $sosdata = $this->Webservices_Model->getsosdatabycocid($data['cocid']);
        if (!empty($sosdata)) {
            $responsedata = array("code" => 200, "dataarr" => $sosdata);
            header('Content-Type: application/json');
        } else {
            $errorMsgArr = $this->Webservices_Model->arErrorMessages;
            if (!empty($errorMsgArr) && !empty($errorMsgArr['norecord'])) {
                $responsedata = array("code" => 201, "message" => $errorMsgArr['norecord']);
                header('Content-Type: application/json');

            } else {
                $responsedata = array("code" => 111, "message" => "Bad Request.");
                header('Content-Type: application/json');
            }
        }
        echo json_encode($responsedata);
    }

    function addcocdata()
    {
        $jsondata = json_decode(file_get_contents("php://input"));
        $data['coc']['cocdate'] = !empty($jsondata->cocdate) ? $jsondata->cocdate : "";
        $data['coc']['drugtest'] = !empty($jsondata->drugtest) ? $jsondata->drugtest : "";
        $data['coc']['dob'] = !empty($jsondata->dob) ? $jsondata->dob : "";
        $data['coc']['employeetype'] = !empty($jsondata->employeetype) ? $jsondata->employeetype : "";
        $data['coc']['contractor'] = !empty($jsondata->contractor) ? $jsondata->contractor : "";
        $data['coc']['idtype'] = !empty($jsondata->idtype) ? $jsondata->idtype : "";
        $data['coc']['idnumber'] = !empty($jsondata->idnumber) ? $jsondata->idnumber : "";
        $data['coc']['lastweekq'] = !empty($jsondata->lastweekq) ? $jsondata->lastweekq : "";
        $data['coc']['donorsign'] = !empty($jsondata->donorsign) ? $jsondata->donorsign : "";
        $data['coc']['donorsigndate'] = !empty($jsondata->donorsigndate) ? $jsondata->donorsigndate : "";
        $data['coc']['voidtime'] = trim($jsondata->voidtime) == ':' ? "" : $jsondata->voidtime;
        $data['coc']['sampletempc'] = !empty($jsondata->sampletempc) ? $jsondata->sampletempc : "";
        $data['coc']['tempreadtime'] = trim($jsondata->tempreadtime) == ':' ? "" : $jsondata->tempreadtime;
        $data['coc']['intect'] = !empty($jsondata->intect) ? $jsondata->intect : "";
        $data['coc']['intectexpiry'] = !empty($jsondata->intectexpiry) ? $jsondata->intectexpiry : "";
        $data['coc']['visualcolor'] = !empty($jsondata->visualcolor) ? $jsondata->visualcolor : "";
        $data['coc']['creatinine'] = !empty($jsondata->creatinine) ? $jsondata->creatinine : "";
        $data['coc']['otherintegrity'] = !empty($jsondata->otherintegrity) ? $jsondata->otherintegrity : "";
        $data['coc']['hudration'] = !empty($jsondata->hudration) ? $jsondata->hudration : "";
        $data['coc']['devicename'] = !empty($jsondata->devicename) ? $jsondata->devicename : "";
        $data['coc']['lotno'] = !empty($jsondata->lotno) ? $jsondata->lotno : "";
        $data['coc']['lotexpiry'] = !empty($jsondata->lotexpiry) ? $jsondata->lotexpiry : "";
        $data['coc']['cocain'] = !empty($jsondata->cocain) ? $jsondata->cocain : "";
        $data['coc']['amp'] = !empty($jsondata->amp) ? $jsondata->amp : "";
        $data['coc']['mamp'] = !empty($jsondata->mamp) ? $jsondata->mamp : "";
        $data['coc']['thc'] = !empty($jsondata->thc) ? $jsondata->thc : "";
        $data['coc']['opiates'] = !empty($jsondata->opiates) ? $jsondata->opiates : "";
        $data['coc']['benzo'] = !empty($jsondata->benzo) ? $jsondata->benzo : "";
        $data['coc']['otherdc'] = !empty($jsondata->otherdc) ? $jsondata->otherdc : "";
        $data['coc']['ctstime'] = trim($jsondata->ctstime) == ':' ? "" : $jsondata->ctstime;
        $data['coc']['collectorone'] = !empty($jsondata->collectorone) ? $jsondata->collectorone : "";
        $data['coc']['collectorsignone'] = !empty($jsondata->collectorsignone) ? $jsondata->collectorsignone : "";
        $data['coc']['commentscol1'] = !empty($jsondata->commentscol1) ? $jsondata->commentscol1 : "";
        $data['coc']['collectortwo'] = !empty($jsondata->collectortwo) ? $jsondata->collectortwo : "";
        $data['coc']['collectorsigntwo'] = !empty($jsondata->collectorsigntwo) ? $jsondata->collectorsigntwo : "";
        $data['coc']['comments'] = !empty($jsondata->comments) ? $jsondata->comments : "";
        $data['coc']['onsitescreeningrepo'] = !empty($jsondata->onsitescreeningrepo) ? $jsondata->onsitescreeningrepo : "";
        /*$data['coc']['receiverone'] = !empty($jsondata->receiverone) ? $jsondata->receiverone : "";
        $data['coc']['receiveronesign'] = !empty($jsondata->receiveronesign) ? $jsondata->receiveronesign : "";
        $data['coc']['receiveronedate'] = !empty($jsondata->receiveronedate) ? $jsondata->receiveronedate : "";
        $data['coc']['receiveronetime'] = trim($jsondata->receiveronetime) == ': AM' || trim($jsondata->receiveronetime) == ': PM'? "":$jsondata->receiveronetime;
        $data['coc']['receiveroneseal'] = !empty($jsondata->receiveroneseal) ? $jsondata->receiveroneseal : "";
        $data['coc']['receiveronelabel'] = !empty($jsondata->receiveronelabel) ? $jsondata->receiveronelabel : "";
        $data['coc']['receivertwo'] = !empty($jsondata->receivertwo) ? $jsondata->receivertwo : "";
        $data['coc']['receivertwosign'] = !empty($jsondata->receivertwosign) ? $jsondata->receivertwosign : "";
        $data['coc']['receivertwodate'] = !empty($jsondata->receivertwodate) ? $jsondata->receivertwodate : "";
        $data['coc']['receivertwotime'] = trim($jsondata->receivertwotime) == ': AM' || trim($jsondata->receivertwotime) == ': PM' ? "":$jsondata->receivertwotime;
        $data['coc']['receivertwoseal'] = !empty($jsondata->receivertwoseal) ? $jsondata->receivertwoseal : "";
        $data['coc']['receivertwolabel'] = !empty($jsondata->receivertwolabel) ? $jsondata->receivertwolabel : "";*/
        $data['coc']['reference'] = (!empty($jsondata->reference) ? $jsondata->reference : "");
        $data['coc']['cocid'] = (!empty($jsondata->cocid) ? $jsondata->cocid : "");
        $data['coc']['status'] = (!empty($jsondata->status) ? $jsondata->status : "0");
        $data['coc']['devicesrno'] = !empty($jsondata->devicesrno) ? $jsondata->devicesrno : "";
        $data['coc']['cutoff'] = $jsondata->cutoff;
        $data['coc']['donwaittime'] = !empty($jsondata->donwaittime) ? $jsondata->donwaittime : "";
        $data['coc']['dontest1'] = $jsondata->dontest1;
        $data['coc']['dontesttime1'] = trim($jsondata->dontesttime1) == ':' ? "" : $jsondata->dontesttime1;
        $data['coc']['dontest2'] = $jsondata->dontest2;
        $data['coc']['dontesttime2'] = trim($jsondata->dontesttime2) == ':' ? "" : $jsondata->dontesttime2;
        $data['coc']['donordecdate'] = !empty($jsondata->donordecdate) ? $jsondata->donordecdate : "";
        $data['coc']['donordecsign'] = !empty($jsondata->donordecsign) ? $jsondata->donordecsign : "";
        $data['coc']['signcoc1'] = $jsondata->signcoc1;
        $data['coc']['signcoc2'] = $jsondata->signcoc2;
        $data['coc']['signcoc3'] = $jsondata->signcoc3;
        $data['coc']['signcoc4'] = $jsondata->signcoc4;
        $data['coc']['signcoc5'] = $jsondata->signcoc5;
        $data['coc']['signcoc6'] = $jsondata->signcoc6;
        $donordata = $this->Webservices_Model->addcocdata($data['coc']);
        $errorMsgArr = $this->Webservices_Model->arErrorMessages;
        if ($donordata) {
            if (!empty($errorMsgArr) && !empty($errorMsgArr['success'])) {
                $responsedata = array("code" => 200, "message" => $errorMsgArr['success']);
            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['successcomplete'])) {
                $responsedata = array("code" => 202, "message" => $errorMsgArr['successcomplete']);
            }
        } else {

            if (!empty($errorMsgArr) && !empty($errorMsgArr['cocdate'])) {
                $responsedata = array("code" => 201, "message" => $errorMsgArr['cocdate']);

            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['drugtest'])) {
                $responsedata = array("code" => 201, "message" => $errorMsgArr['drugtest']);

            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['dob'])) {
                $responsedata = array("code" => 201, "message" => $errorMsgArr['dob']);

            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['employeetype'])) {
                $responsedata = array("code" => 201, "message" => $errorMsgArr['employeetype']);

            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['idtype'])) {
                $responsedata = array("code" => 201, "message" => $errorMsgArr['idtype']);

            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['idnumber'])) {
                $responsedata = array("code" => 201, "message" => $errorMsgArr['idnumber']);

            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['lastweekq'])) {
                $responsedata = array("code" => 201, "message" => $errorMsgArr['lastweekq']);

            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['donorsign'])) {
                $responsedata = array("code" => 201, "message" => $errorMsgArr['donorsign']);

            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['donorsigndate'])) {
                $responsedata = array("code" => 201, "message" => $errorMsgArr['donorsigndate']);

            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['devicesrno'])) {
                $responsedata = array("code" => 201, "message" => $errorMsgArr['devicesrno']);

            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['cutoff'])) {
                $responsedata = array("code" => 201, "message" => $errorMsgArr['cutoff']);

            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['donwaittime'])) {
                $responsedata = array("code" => 201, "message" => $errorMsgArr['donwaittime']);

            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['dontest1'])) {
                $responsedata = array("code" => 201, "message" => $errorMsgArr['dontest1']);

            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['dontesttime1'])) {
                $responsedata = array("code" => 201, "message" => $errorMsgArr['dontesttime1']);

            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['dontest2'])) {
                $responsedata = array("code" => 201, "message" => $errorMsgArr['dontest2']);

            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['dontesttime2'])) {
                $responsedata = array("code" => 201, "message" => $errorMsgArr['dontesttime2']);

            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['voidtime'])) {
                $responsedata = array("code" => 201, "message" => $errorMsgArr['voidtime']);

            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['sampletempc'])) {
                $responsedata = array("code" => 201, "message" => $errorMsgArr['sampletempc']);

            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['tempreadtime'])) {
                $responsedata = array("code" => 201, "message" => $errorMsgArr['tempreadtime']);

            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['intect'])) {
                $responsedata = array("code" => 201, "message" => $errorMsgArr['intect']);

            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['intectexpiry'])) {
                $responsedata = array("code" => 201, "message" => $errorMsgArr['intectexpiry']);

            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['visualcolor'])) {
                $responsedata = array("code" => 201, "message" => $errorMsgArr['visualcolor']);

            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['creatinine'])) {
                $responsedata = array("code" => 201, "message" => $errorMsgArr['creatinine']);

            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['otherintegrity'])) {
                $responsedata = array("code" => 201, "message" => $errorMsgArr['otherintegrity']);

            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['hudration'])) {
                $responsedata = array("code" => 201, "message" => $errorMsgArr['hudration']);

            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['devicename'])) {
                $responsedata = array("code" => 201, "message" => $errorMsgArr['devicename']);

            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['reference'])) {
                $responsedata = array("code" => 201, "message" => $errorMsgArr['reference']);

            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['lotno'])) {
                $responsedata = array("code" => 201, "message" => $errorMsgArr['lotno']);

            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['lotexpiry'])) {
                $responsedata = array("code" => 201, "message" => $errorMsgArr['lotexpiry']);

            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['cocain'])) {
                $responsedata = array("code" => 201, "message" => $errorMsgArr['cocain']);

            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['amp'])) {
                $responsedata = array("code" => 201, "message" => $errorMsgArr['amp']);

            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['mamp'])) {
                $responsedata = array("code" => 201, "message" => $errorMsgArr['mamp']);

            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['thc'])) {
                $responsedata = array("code" => 201, "message" => $errorMsgArr['thc']);

            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['opiates'])) {
                $responsedata = array("code" => 201, "message" => $errorMsgArr['opiates']);

            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['benzo'])) {
                $responsedata = array("code" => 201, "message" => $errorMsgArr['benzo']);

            }elseif (!empty($errorMsgArr) && !empty($errorMsgArr['otherdc'])) {
                $responsedata = array("code" => 201, "message" => $errorMsgArr['otherdc']);

            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['donordecdate'])) {
                $responsedata = array("code" => 201, "message" => $errorMsgArr['donordecdate']);

            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['donordecsign'])) {
                $responsedata = array("code" => 201, "message" => $errorMsgArr['donordecsign']);

            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['collectorone'])) {
                $responsedata = array("code" => 201, "message" => $errorMsgArr['collectorone']);

            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['collectorsignone'])) {
                $responsedata = array("code" => 201, "message" => $errorMsgArr['collectorsignone']);

            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['collectortwo'])) {
                $responsedata = array("code" => 201, "message" => $errorMsgArr['collectortwo']);

            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['collectorsigntwo'])) {
                $responsedata = array("code" => 201, "message" => $errorMsgArr['collectorsigntwo']);

            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['onsitescreeningrepo'])) {
                $responsedata = array("code" => 201, "message" => $errorMsgArr['onsitescreeningrepo']);

            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['receiverone'])) {
                $responsedata = array("code" => 201, "message" => $errorMsgArr['receiverone']);

            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['receiveronedate'])) {
                $responsedata = array("code" => 201, "message" => $errorMsgArr['receiveronedate']);

            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['receiveronetime'])) {
                $responsedata = array("code" => 201, "message" => $errorMsgArr['receiveronetime']);

            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['receiveroneseal'])) {
                $responsedata = array("code" => 201, "message" => $errorMsgArr['receiveroneseal']);

            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['receiveronelabel'])) {
                $responsedata = array("code" => 201, "message" => $errorMsgArr['receiveronelabel']);

            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['receiveronesign'])) {
                $responsedata = array("code" => 201, "message" => $errorMsgArr['receiveronesign']);

            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['error'])) {
                $responsedata = array("code" => 201, "message" => $errorMsgArr['error']);

            } else {
                $responsedata = array("code" => 111, "message" => "Bad Request.");
            }
        }
        header('Content-Type: application/json');
        echo json_encode($responsedata);
    }

    function getuserhierarchybysiteid()
    {
        $jsondata = json_decode(file_get_contents("php://input"));
        $data['siteid'] = !empty($jsondata->siteid) ? $jsondata->siteid : "";
        $hierdata = $this->Webservices_Model->getuserhierarchybysiteid($data['siteid']);
        if (!empty($hierdata)) {
            $responsedata = array("code" => 200, "dataarr" => $hierdata);
            header('Content-Type: application/json');
        } else {
            $errorMsgArr = $this->Webservices_Model->arErrorMessages;
            if (!empty($errorMsgArr) && !empty($errorMsgArr['norecord'])) {
                $responsedata = array("code" => 201, "message" => $errorMsgArr['norecord']);
                header('Content-Type: application/json');

            } else {
                $responsedata = array("code" => 111, "message" => "Bad Request.");
                header('Content-Type: application/json');
            }
        }
        echo json_encode($responsedata);
    }

    function marksoscomplete()
    {
        $jsondata = json_decode(file_get_contents("php://input"));
        $data['sosid'] = !empty($jsondata->sosid) ? $jsondata->sosid : "";
        $sosdata = $this->Webservices_Model->marksoscomplete($data['sosid']);
        if ($sosdata) {
            $responsedata = array("code" => 200, "message" => "Status changed sucessfully");
        } else {
            $errorMsgArr = $this->Webservices_Model->arErrorMessages;
            if (!empty($errorMsgArr) && !empty($errorMsgArr['error'])) {
                $responsedata = array("code" => 201, "message" => $errorMsgArr['error']);

            } else {
                $responsedata = array("code" => 111, "message" => "Bad Request.");
            }
        }
        header('Content-Type: application/json');
        echo json_encode($responsedata);
    }

    function delcoc()
    {
        $jsondata = json_decode(file_get_contents("php://input"));
        $data['cocid'] = !empty($jsondata->cocid) ? $jsondata->cocid : "0";
        $delstatus = $this->Webservices_Model->delcoc($data['cocid']);
        if ($delstatus) {
            $responsedata = array("code" => 200, "message" => "COC form cancelled successfully.");
        } else {
            $responsedata = array("code" => 201, "message" => "Some error occured while cancelling COC form. Please try again.");

        }
        header('Content-Type: application/json');
        echo json_encode($responsedata);
    }

    function deldonor()
    {
        $jsondata = json_decode(file_get_contents("php://input"));
        $data['donorid'] = !empty($jsondata->donorid) ? $jsondata->donorid : "0";
        $delstatus = $this->Webservices_Model->deldonor($data['donorid']);
        if ($delstatus) {
            $responsedata = array("code" => 200, "message" => "Donor deleted successfully.");
        } else {
            $responsedata = array("code" => 201, "message" => "Some error occured while deleting Donor. Please try again.");

        }
        header('Content-Type: application/json');
        echo json_encode($responsedata);
    }

    function getallprodbycatid()
    {
        $jsondata = json_decode(file_get_contents("php://input"));
        $data['catid'] = !empty($jsondata->catid) ? $jsondata->catid : "0";
        $prodarr = $this->Webservices_Model->getallprodbycatid($data['catid']);
        if ($prodarr) {
            $responsedata = array("code" => 200, "prodarr" => $prodarr);
        } else {
            $responsedata = array("code" => 201, "message" => "No product found.");

        }
        header('Content-Type: application/json');
        echo json_encode($responsedata);
    }

    function getallcategories()
    {
        $catarr = $this->Webservices_Model->getallcategories();
        if ($catarr) {
            $responsedata = array("code" => 200, "catarr" => $catarr);
        } else {
            $responsedata = array("code" => 201, "message" => "No product category found.");
        }
        header('Content-Type: application/json');
        echo json_encode($responsedata);
    }

    function addtocart()
    {
        $jsondata = json_decode(file_get_contents("php://input"));
        $data['cart']['franchiseeid'] = !empty($jsondata->franchiseeid) ? $jsondata->franchiseeid : "";
        $data['cart']['productid'] = !empty($jsondata->productid) ? $jsondata->productid : "";
        $data['cart']['quantity'] = !empty($jsondata->quantity) ? $jsondata->quantity : "";
        $cartAditionStatus = $this->Webservices_Model->addtocart($data['cart']);
        $errorMsgArr = $this->Webservices_Model->arErrorMessages;
        if ($cartAditionStatus) {
            $responsedata = array("code" => 200, "message" => "Product successfully added to your cart.");
        } else {
            if (!empty($errorMsgArr) && !empty($errorMsgArr['franchiseeid'])) {
                $responsedata = array("code" => 201, "message" => "Something wrong with franchisee. Please logout and try again.");
            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['productid'])) {
                $responsedata = array("code" => 201, "message" => "Something wrong with this product. Please logout and try again.");
            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['quantity'])) {
                $responsedata = array("code" => 201, "message" => $errorMsgArr['quantity']);
            } else {
                $responsedata = array("code" => 201, "message" => "Something goes wrong. Please try again.");
            }
        }
        header('Content-Type: application/json');
        echo json_encode($responsedata);
    }

    function emptycart()
    {
        $jsondata = json_decode(file_get_contents("php://input"));
        $data['franchiseeid'] = !empty($jsondata->franchiseeid) ? $jsondata->franchiseeid : "";
        $cartStatus = $this->Webservices_Model->emptycart($data);
        if ($cartStatus) {
            $responsedata = array("code" => 200, "message" => "No product is in your cart.");
        } else {
            $responsedata = array("code" => 201, "message" => "Something goes wrong. Please try again.");
        }
        header('Content-Type: application/json');
        echo json_encode($responsedata);
    }

    function deleteitemfromcart()
    {
        $jsondata = json_decode(file_get_contents("php://input"));
        $data['cart']['franchiseeid'] = !empty($jsondata->franchiseeid) ? $jsondata->franchiseeid : "";
        $data['cart']['productid'] = !empty($jsondata->productid) ? $jsondata->productid : "";
        $cartStatus = $this->Webservices_Model->deleteitemfromcart($data['cart']);
        $errorMsgArr = $this->Webservices_Model->arErrorMessages;
        if ($cartStatus) {
            $responsedata = array("code" => 200, "message" => "Product successfully removed from your cart.");
        } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['cartproductid'])) {
            $responsedata = array("code" => 201, "message" => $errorMsgArr['cartproductid']);
        } else {
            $responsedata = array("code" => 201, "message" => "Something goes wrong. Please try again.");
        }
        header('Content-Type: application/json');
        echo json_encode($responsedata);
    }

    function getfranchiseecartitems()
    {
        $jsondata = json_decode(file_get_contents("php://input"));
        $data['franchiseeid'] = !empty($jsondata->franchiseeid) ? $jsondata->franchiseeid : "0";
        $franchiseeCartArr = $this->Webservices_Model->getfranchiseecartitems($data['franchiseeid']);
        if (!empty($franchiseeCartArr)) {
            $responsedata = array("code" => 200, "cartarr" => $franchiseeCartArr);
        } else {
            $responsedata = array("code" => 201, "message" => "No product found.");
        }
        header('Content-Type: application/json');
        echo json_encode($responsedata);
    }

    function updatecart()
    {
        $jsondata = json_decode(file_get_contents("php://input"));
        $dataArr['totcartitems'] = !empty($jsondata->totcartitems) ? $jsondata->totcartitems : "0";
        for ($i = 1; $i <= $dataArr['totcartitems']; $i++) {
            $cartidvar = 'cartid' . $i;
            $qtyvar = 'qty' . $i;
            $dataArr['cartid' . $i] = !empty($jsondata->$cartidvar) ? $jsondata->$cartidvar : "0";
            $dataArr['qty' . $i] = !empty($jsondata->$qtyvar) ? $jsondata->$qtyvar : "0";
        }

        if ($dataArr['totcartitems'] > '0') {
            $updatecartstatus = $this->Webservices_Model->updatecart($dataArr);
            if ($updatecartstatus) {
                $responsedata = array("code" => 200, "message" => "Cart updated successfully.");
            } else {
                $responsedata = array("code" => 201, "message" => "Minimum quantity allowed is 25. Enter valid quantity to proceed further.");
            }
            header('Content-Type: application/json');
            echo json_encode($responsedata);
        }
    }

    function addorder()
    {
        $jsondata = json_decode(file_get_contents("php://input"));
        $dataArr['franchiseeid'] = !empty($jsondata->franchiseeid) ? $jsondata->franchiseeid : "0";
        $dataArr['totalprice'] = !empty($jsondata->totalprice) ? $jsondata->totalprice : "0";

        $orderstatus = $this->Webservices_Model->addorder($dataArr);
        if ($orderstatus) {
            $responsedata = array("code" => 200, "message" => "Your order has been placed successfully.");
        } else {
            $responsedata = array("code" => 201, "message" => "Something goes wrong. Please try again.");
        }
        header('Content-Type: application/json');
        echo json_encode($responsedata);

    }

    function getorderdetails()
    {
        $jsondata = json_decode(file_get_contents("php://input"));
        $orderid = !empty($jsondata->orderid) ? $jsondata->orderid : "0";
        $orderdetailsArr = $this->Webservices_Model->getorderdetails($orderid);
        if (!empty($orderdetailsArr)) {
            $responsedata = array("code" => 200, "orderdetailsArr" => $orderdetailsArr);
        } else {
            $responsedata = array("code" => 201, "message" => "No order found.");
        }
        header('Content-Type: application/json');
        echo json_encode($responsedata);
    }

    function canceldonorcoc()
    {
        $jsondata = json_decode(file_get_contents("php://input"));
        $donorid = !empty($jsondata->donorid) ? $jsondata->donorid : "0";
        $changestatus = $this->Webservices_Model->canceldonorcoc($donorid);
        if ($changestatus) {
            $responsedata = array("code" => 200, "message" => "COC form cancelled successfully.");
        } else {
            $responsedata = array("code" => 201, "message" => "Something goes wrong. Please try again.");
        }
        header('Content-Type: application/json');
        echo json_encode($responsedata);
    }

    function getsavedkitsbysosid()
    {
        $jsondata = json_decode(file_get_contents("php://input"));
        $data['sosid'] = !empty($jsondata->sosid) ? $jsondata->sosid : "0";
        $data['used'] = !empty($jsondata->used) ? $jsondata->used : "0";
        $kitarr = $this->Webservices_Model->getSavedKitsBySosid($data['sosid'], $data['used']);
        if ($kitarr) {
            $responsedata = array("code" => 200, "kitarr" => $kitarr);
        } else {
            $responsedata = array("code" => 201, "message" => "No product found.");
        }
        header('Content-Type: application/json');
        echo json_encode($responsedata);
    }

    function delusedkit()
    {
        $jsondata = json_decode(file_get_contents("php://input"));
        $data['kitid'] = !empty($jsondata->kitid) ? $jsondata->kitid : "0";
        $delstatus = $this->Webservices_Model->delUsedKit($data['kitid']);
        if ($delstatus) {
            $responsedata = array("code" => 200, "message" => "Selected product removed successfully.");
        } else {
            $responsedata = array("code" => 201, "message" => "Some error occured while deleting selected product. Please try again.");

        }
        header('Content-Type: application/json');
        echo json_encode($responsedata);
    }

    function testcompletebyinventorycheck()
    {
        $jsondata = json_decode(file_get_contents("php://input"));
        $data['franchiseeid'] = !empty($jsondata->franchiseeid) ? $jsondata->franchiseeid : "0";
        $data['sosid'] = !empty($jsondata->sosid) ? $jsondata->sosid : "0";
        $inventoryStatus = $this->Webservices_Model->inventoryCheck($data['franchiseeid'], $data['sosid']);
        if ($inventoryStatus) {
            $responsedata = array("code" => 200, "message" => "Your inventory updated successfully.");
        } else {
            $responsedata = array("code" => 201, "message" => "Your inventory don't have sufficient amount of products to complete this test. Please upgrade your inventory and try again.");
        }
        header('Content-Type: application/json');
        echo json_encode($responsedata);
    }

    function getclientdetailsbyclientid()
    {
        $jsondata = json_decode(file_get_contents("php://input"));
        $data['clientid'] = !empty($jsondata->clientid) ? $jsondata->clientid : "0";
        $clientdata = $this->Webservices_Model->getclientdetailsbyclientid($data['clientid']);
        if (!empty($clientdata)) {
            $responsedata = array("code" => 200, "dataarr" => $clientdata);
        } else {
            $responsedata = array("code" => 201, "message" => "No record found.");
        }
        header('Content-Type: application/json');
        echo json_encode($responsedata);
    }

    function getsosformdatabysosid()
    {
        $jsondata = json_decode(file_get_contents("php://input"));
        $data['sosid'] = !empty($jsondata->sosid) ? $jsondata->sosid : "";
        $sosformdata = $this->Webservices_Model->getsosformdatabysosid($data['sosid']);
        $usertype = $this->Webservices_Model->getuserdetails($sosformdata[0]['createdBy']);
        if (!empty($sosformdata)) {
            $responsedata = array("code" => 200, "dataarr" => $sosformdata, "role" => $usertype[0]['iRole']);
            header('Content-Type: application/json');
        } else {
            $responsedata = array("code" => 201, "message" => 'No site found');
            header('Content-Type: application/json');
        }
        echo json_encode($responsedata);
    }

    function getcocdatabycocid()
    {
        $jsondata = json_decode(file_get_contents("php://input"));
        $data['cocid'] = !empty($jsondata->cocid) ? $jsondata->cocid : "";
        $cocformdata = $this->Webservices_Model->getcocdatabycocid($data['cocid']);
        if (!empty($cocformdata)) {
            $responsedata = array("code" => 200, "dataarr" => $cocformdata);
            header('Content-Type: application/json');
        } else {
            $responsedata = array("code" => 201, "message" => 'No COC form recorded for this donor.');
            header('Content-Type: application/json');
        }
        echo json_encode($responsedata);
    }

    function getfranchiseeorders()
    {
        $jsondata = json_decode(file_get_contents("php://input"));
        $data['franchiseeid'] = !empty($jsondata->franchiseeid) ? $jsondata->franchiseeid : "0";
        $franchiseeOrderArr = $this->Webservices_Model->getfranchiseeorders($data['franchiseeid']);
        if (!empty($franchiseeOrderArr)) {
            $responsedata = array("code" => 200, "orderarr" => $franchiseeOrderArr);
        } else {
            $responsedata = array("code" => 201, "message" => "No order found.");
        }
        header('Content-Type: application/json');
        echo json_encode($responsedata);
    }

    function getagentfranchisee()
    {
        $jsondata = json_decode(file_get_contents("php://input"));
        $data['agentid'] = !empty($jsondata->agentid) ? $jsondata->agentid : "0";
        $agentArr = $this->Webservices_Model->getagentfranchisee($data['agentid']);
        if (!empty($agentArr)) {
            $responsedata = array("code" => 200, "franchiseeid" => $agentArr[0]['franchiseeid']);
        } else {
            $responsedata = array("code" => 201, "message" => "No data found.");
        }
        header('Content-Type: application/json');
        echo json_encode($responsedata);
    }

    function uploaddata()
    {
        define('UPLOAD_DIR', 'uploadsign/');
        $img = $_POST['imgBase64'];
        $siteid = $_POST['siteid'];
        $fieldname = $_POST['fieldname'];
        $status = $_POST['status'];
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        $imgname = date('d-m-Y-H-i-s') . '-' . uniqid() . '.png';
        $file = UPLOAD_DIR . $imgname;
        $success = file_put_contents($file, $data);
        if ($success) {
            if ($this->Webservices_Model->savecollsign($siteid, $imgname, $fieldname, $status)) {
                return $success;
            } else {
                return false;
            }
        };
        //print $success ? $file : 'Unable to save the file.';
    }

    function uploadcocdata()
    {
        define('UPLOAD_DIR', 'uploadsign/');
        $img = $_POST['imgBase64'];
        $cocid = $_POST['cocid'];
        $fieldname = $_POST['fieldname'];
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        $imgname = date('d-m-Y-H-i-s') . '-' . uniqid() . '.png';
        $file = UPLOAD_DIR . $imgname;
        $success = file_put_contents($file, $data);
        if ($success) {
            if ($this->Webservices_Model->savecocsign($cocid, $imgname, $fieldname)) {
                return $success;
            } else {
                return false;
            }
        };
    }

    function sosformpdf()
    {
        $jsondata = json_decode(file_get_contents("php://input"));
        $sosid = !empty($jsondata->sosid) ? $jsondata->sosid : "0";
        ob_start();
        define('UPLOAD_DIR', 'uploadsign/');
        $sosdetarr = $this->Webservices_Model->getsosformdatabysosid($sosid);
        $sosuserdets = $this->Webservices_Model->getuserhierarchybysiteid($sosdetarr[0]['Clientid']);
        $franchiseeDets = $this->Webservices_Model->getuserdetails($sosuserdets[0]['franchiseeId']);
        $ClientDets = $this->Webservices_Model->getuserdetails($sosuserdets[0]['clientType']);
        $ClientBusinessDetArr = $this->Webservices_Model->getclientdetailsbyclientid($sosuserdets[0]['clientType']);
        $SiteDets = $this->Webservices_Model->getuserdetails($sosdetarr[0]['Clientid']);
        $testtypesarr = explode(',', $sosdetarr[0]['Drugtestid']);
        $donorsarr = $this->Webservices_Model->getdonorsbysosid($sosid);
        $userprods = $this->Webservices_Model->getsavedkitsbysosid($sosid, 1);
        $getState = $this->Franchisee_Model->getStateByFranchiseeId($sosuserdets[0]['franchiseeId']);
        $franchiseecode = $this->Franchisee_Model->getusercodebyuserid($sosuserdets[0]['clientType']);
        $SFArr = explode(',', $sosdetarr[0]['screening_facilities']);

        $_SESSION['PDF-TESTDATE'] = 'Drug Test Date: ' . date( 'd/m/Y', strtotime( $sosdetarr[0]['testdate'] ) );

        $this->load->library('Pdf');
        $pdf = new Pdf('L', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetTitle('Drug-safe SOS Form Details');
        $pdf->SetAuthor('Drug-safe');
        $pdf->SetSubject('SOS Form PDF');
        $pdf->SetMargins(PDF_MARGIN_LEFT - 10, PDF_MARGIN_TOP - 20, PDF_MARGIN_RIGHT - 10);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM - 15);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->SetDisplayMode('real', 'default');
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter( true );
        $pdf->setFooterData(array(0,64,0), array(0,64,128));
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetFont('times', '', 8);

        $pdf->AddPage('P');

        //$sosid = $this->session->userdata('sosid');

        if (!empty($testtypesarr)) {
            if ($testtypesarr[0] == '1') {
                $alchohol = true;
            } else if ($testtypesarr[0] == '2') {
                $oral = true;
            } else if ($testtypesarr[0] == '3') {
                $urineasnza = true;
            } else if ($testtypesarr[0] == '4') {
                $asnza = true;
            } else if ($testtypesarr[0] == '5') {
                $other = true;
            }

            if ($testtypesarr[1] == '1') {
                $alchohol = true;
            } else if ($testtypesarr[1] == '2') {
                $oral = true;
            } else if ($testtypesarr[1] == '3') {
                $urineasnza = true;
            } else if ($testtypesarr[1] == '4') {
                $asnza = true;
            } else if ($testtypesarr[1] == '5') {
                $other = true;
            }

            if ($testtypesarr[2] == '1') {
                $alchohol = true;
            } else if ($testtypesarr[2] == '2') {
                $oral = true;
            } else if ($testtypesarr[2] == '3') {
                $urineasnza = true;
            } else if ($testtypesarr[2] == '4') {
                $asnza = true;
            } else if ($testtypesarr[2] == '5') {
                $other = true;
            }

            if ($testtypesarr[3] == '1') {
                $alchohol = true;
            } else if ($testtypesarr[3] == '2') {
                $oral = true;
            } else if ($testtypesarr[3] == '3') {
                $urineasnza = true;
            } else if ($testtypesarr[3] == '4') {
                $asnza = true;
            } else if ($testtypesarr[3] == '5') {
                $other = true;
            }
            if ($testtypesarr[4] == '1') {
                $alchohol = true;
            } else if ($testtypesarr[4] == '2') {
                $oral = true;
            } else if ($testtypesarr[4] == '3') {
                $urineasnza = true;
            } else if ($testtypesarr[4] == '4') {
                $asnza = true;
            } else if ($testtypesarr[4] == '5') {
                $other = true;
            }
        }

        $drugteststring = '';
        if ($alchohol) {
            $drugteststring = 'Alcohol, ';
        }
        if ($oral) {
            $drugteststring .= 'Oral Fluid, ';
        }
        if ($urineasnza) {
            $drugteststring .= 'Urine, ';
        }
        if ($asnza) {
            $drugteststring .= 'AS/NZA 4308:2008, ';
        }
        if ($other) {
            $drugteststring .= 'Other: ' . $sosdetarr[0]['other_drug_test'] . ', ';
        }
        if (!empty($SFArr)) {
            if ($SFArr[0] == '1') {
                $inHouse = true;
            } else if ($SFArr[0] == '2') {
                $onClinic = true;
            }
            if ($SFArr[1] == '1') {
                $inHouse = true;
            } else if ($SFArr[1] == '2') {
                $onClinic = true;
            }
        }
        $SFString = '';
        if ($inHouse) {
            $SFString .= 'In House, ';
        }
        if ($onClinic) {
            $SFString .= 'Mobile Clinic, ';
        }
        $drugteststring = substr(trim($drugteststring), 0, -1);
        $SFString = substr(trim($SFString), 0, -1);
        $html = '<a style="text-align:center;  margin-bottom:0px;" href="' . __BASE_URL__ . '" ><img style="width:100px" src="' . __BASE_URL__ . '/images/logo.png" alt="logo" class="logo-default" /> </a>
            <div><br><span style="text-align:center; font-size:12px; margin-bottom:0px; color:black"><b>SOS Details</b></span></div>
            <div class= "table-responsive" >
                            <table border="1" cellpadding="5">
                                    <tr>
                                    <td colspan="3"><h3>SUMMARY OF SERVICE</h3><h4><i>Strictly Confidential</i></h4></td>
                                    <td colspan="2" rowspan="3"><h3>' . $franchiseeDets[0]['szName'] . '</h3></td>
                                    <td colspan="3">Address: ' . $franchiseeDets[0]['szAddress'] . ', ' . $franchiseeDets[0]['szZipCode'] . ', ' . $franchiseeDets[0]['szCity'] . ', ' . $getState['name'] . ', ' . $franchiseeDets[0]['szCountry'] . '</td>
                                    </tr>
                                    <tr>
                                    <td colspan="3" rowspan="2">T: ' . $franchiseeDets[0]['szContactNumber'] . '</td>
                                    <td colspan="3">ABN: ' . $franchiseeDets[0]['abn'] . '</td>
                                    </tr>
                                    <tr>
                                    <td colspan="3">Email: ' . $franchiseeDets[0]['szEmail'] . '</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="left">Client Code: ' . (!empty($franchiseecode['userCode']) ? $franchiseecode['userCode'] : 'N/A') . '</td><td colspan="3" align="left">Requesting Client: ' . $ClientBusinessDetArr[0]['szBusinessName'] . '</td>
                                        <td colspan="2">Date: ' . date('d/m/Y', strtotime($sosdetarr[0]['testdate'])) . '</td>
                                    </tr>
                                    <tr>
                                        <td colspan="8">Site Location: ' . $SiteDets[0]['szName'] . '</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">Screening Facilities: ' . $SFString . '</td><td colspan="4">  Start(km): ' . $sosdetarr[0]['start_km'] . ', End(km): ' . $sosdetarr[0]['end_km'] . ', Total(km): ' . $sosdetarr[0]['total_km'] . '</td>
                                    </tr>
                                    <tr>
                                        <td colspan="8">Drug to be tested: ' . $drugteststring . '</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">Service Commenced: ' . $sosdetarr[0]['ServiceCommencedOn'] . '</td>
                                        <td colspan="4">Service Concluded: ' . $sosdetarr[0]['ServiceConcludedOn'] . '</td>
                                    </tr>';
        if (!empty($donorsarr)) {
            $html .= '<tr>
                                                <td><b>#</b></td>
                                                <td><b>Donor Name</b></td>
                                                <td><b>Result*</b></td>
                                                <td colspan="2"><b>Drug</b></td>
                                                <td colspan="2"><b>Alcohol**</b></td>
                                                <td><b>Lab</b></td>
                                            </tr>';
            $count = 1;
            foreach ($donorsarr as $donors) {
                $drugs = '';
                $drugarr = explode(',', $donors['drug']);
                if ($drugarr[0] == '1') {
                    $drugs .= 'Ice-Methamphetamine(mAmp)<br>';
                } else if ($drugarr[1] == '1') {
                    $drugs .= 'Ice-Methamphetamine(mAmp)<br>';
                } else if ($drugarr[2] == '1') {
                    $drugs .= 'Ice-Methamphetamine(mAmp)<br>';
                } else if ($drugarr[3] == '1') {
                    $drugs .= 'Ice-Methamphetamine(mAmp)<br>';
                } else if ($drugarr[4] == '1') {
                    $drugs .= 'Ice-Methamphetamine(mAmp)<br>';
                } else if ($drugarr[5] == '1') {
                    $drugs .= 'Ice-Methamphetamine(mAmp)<br>';
                }else if ($drugarr[6] == '1') {
                    $drugs .= 'Ice-Methamphetamine(mAmp)<br>';
                }

                if ($drugarr[0] == '2') {
                    $drugs .= 'THC-Marijuana(THC)<br>';
                } else if ($drugarr[1] == '2') {
                    $drugs .= 'THC-Marijuana(THC)<br>';
                } else if ($drugarr[2] == '2') {
                    $drugs .= 'THC-Marijuana(THC)<br>';
                } else if ($drugarr[3] == '2') {
                    $drugs .= 'THC-Marijuana(THC)<br>';
                } else if ($drugarr[4] == '2') {
                    $drugs .= 'THC-Marijuana(THC)<br>';
                } else if ($drugarr[5] == '2') {
                    $drugs .= 'THC-Marijuana(THC)<br>';
                } else if ($drugarr[6] == '2') {
                    $drugs .= 'THC-Marijuana(THC)<br>';
                }

                if ($drugarr[0] == '3') {
                    $drugs .= 'Heroine-Opiates(OPI)<br>';
                } else if ($drugarr[1] == '3') {
                    $drugs .= 'Heroine-Opiates(OPI)<br>';
                } else if ($drugarr[2] == '3') {
                    $drugs .= 'Heroine-Opiates(OPI)<br>';
                } else if ($drugarr[3] == '3') {
                    $drugs .= 'Heroine-Opiates(OPI)<br>';
                } else if ($drugarr[4] == '3') {
                    $drugs .= 'Heroine-Opiates(OPI)<br>';
                } else if ($drugarr[5] == '3') {
                    $drugs .= 'Heroine-Opiates(OPI)<br>';
                } else if ($drugarr[6] == '3') {
                    $drugs .= 'Heroine-Opiates(OPI)<br>';
                }

                if ($drugarr[0] == '4') {
                    $drugs .= 'Cocaine-Cocaine(COC)<br>';
                } else if ($drugarr[1] == '4') {
                    $drugs .= 'Cocaine-Cocaine(COC)<br>';
                } else if ($drugarr[2] == '4') {
                    $drugs .= 'Cocaine-Cocaine(COC)<br>';
                } else if ($drugarr[3] == '4') {
                    $drugs .= 'Cocaine-Cocaine(COC)<br>';
                } else if ($drugarr[4] == '4') {
                    $drugs .= 'Cocaine-Cocaine(COC)<br>';
                } else if ($drugarr[5] == '4') {
                    $drugs .= 'Cocaine-Cocaine(COC)<br>';
                } else if ($drugarr[6] == '4') {
                    $drugs .= 'Cocaine-Cocaine(COC)<br>';
                }
                if ($drugarr[0] == '5') {
                    $drugs .= 'Benzodiazepines-Benzodiazepines(BZO)<br>';
                } else if ($drugarr[1] == '5') {
                    $drugs .= 'Benzodiazepines-Benzodiazepines(BZO)<br>';
                } else if ($drugarr[2] == '5') {
                    $drugs .= 'Benzodiazepines-Benzodiazepines(BZO)<br>';
                } else if ($drugarr[3] == '5') {
                    $drugs .= 'Benzodiazepines-Benzodiazepines(BZO)<br>';
                } else if ($drugarr[4] == '5') {
                    $drugs .= 'Benzodiazepines-Benzodiazepines(BZO)<br>';
                } else if ($drugarr[5] == '5') {
                    $drugs .= 'Benzodiazepines-Benzodiazepines(BZO)<br>';
                } else if ($drugarr[6] == '5') {
                    $drugs .= 'Benzodiazepines-Benzodiazepines(BZO)<br>';
                }

                if ($drugarr[0] == '6') {
                    $drugs .= 'Amphetamine-Amphetamine(AMP)<br>';
                } else if ($drugarr[1] == '6') {
                    $drugs .= 'Amphetamine-Amphetamine(AMP)<br>';
                } else if ($drugarr[2] == '6') {
                    $drugs .= 'Amphetamine-Amphetamine(AMP)<br>';
                } else if ($drugarr[3] == '6') {
                    $drugs .= 'Amphetamine-Amphetamine(AMP)<br>';
                } else if ($drugarr[4] == '6') {
                    $drugs .= 'Amphetamine-Amphetamine(AMP)<br>';
                } else if ($drugarr[5] == '6') {
                    $drugs .= 'Amphetamine-Amphetamine(AMP)<br>';
                } else if ($drugarr[6] == '6') {
                    $drugs .= 'Amphetamine-Amphetamine(AMP)<br>';
                }

                if ($drugarr[0] == '7') {
                    $drugs .= 'Other<br>';
                } else if ($drugarr[1] == '7') {
                    $drugs .= 'Other<br>';
                } else if ($drugarr[2] == '7') {
                    $drugs .= 'Other<br>';
                } else if ($drugarr[3] == '7') {
                    $drugs .= 'Other<br>';
                } else if ($drugarr[4] == '7') {
                    $drugs .= 'Other<br>';
                } else if ($drugarr[5] == '7') {
                    $drugs .= 'Other<br>';
                } else if ($drugarr[6] == '7') {
                    $drugs .= 'Other<br>';
                }

                /*if (!empty($donors['otherdrug'])) {
                    $drugs .= $donors['otherdrug'] . '<br>';
                }*/

                $alcoholread1 = '';
                $alcoholread2 = '';
                if ($donors['alcoholreading1'] != '') {
                    $alcoholread1 = $donors['alcoholreading1'];
                }
                if ($donors['alcoholreading2'] != '') {
                    $alcoholread2 = $donors['alcoholreading2'];
                }
                $html .= '<tr>
                                                <td>' . $count . '</td>
                                                <td>' . $donors['donerName'] . '</td>
                                                <td>' . (!empty($drugs) || $alcoholread1 != '' || $alcoholread2 != '' ? 'U' : 'N') . '</td>
                                                <td colspan="2">' . (!empty($drugs) ? $drugs : 'N/A') . '</td>
                                                <td colspan="2">' . (!empty($alcoholread1) ? 'P' : 'N') . ', Reading One:' . (!empty($alcoholread1) ? $alcoholread1 : 'N/A') . '<br/>' . (!empty($alcoholread2) ? 'P' : 'N') . ', Reading Two:' . (!empty($alcoholread2) ? $alcoholread2 : 'N/A') . '</td>
                                                <td>' . ($drugs != '' ? 'Y' : 'N') . '</td>
                                            </tr>';
                $count++;
            }
        }
        $html .= '<tr>
                                        <td colspan="3">* U = Positive, result requiring further testing N = Negative<br />** P = Positive N = Negative</td>
                                        <td>Urine</td>
                                        <td>Oral</td>
                                        <td colspan="2">Total No Alcohol Screen</td>
                                        <td colspan="1">' . $sosdetarr[0]['TotalAlcoholScreening'] . '</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">Total Donor Screenings/Collections</td>
                                        <td>' . $sosdetarr[0]['TotalDonarScreeningUrine'] . '</td>
                                        <td>' . $sosdetarr[0]['TotalDonarScreeningOral'] . '</td>
                                        <td colspan="2">Negative Alcohol</td>
                                        <td colspan="1">' . $sosdetarr[0]['NegativeAlcohol'] . '</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">Negative Results</td>
                                        <td>' . $sosdetarr[0]['NegativeResultUrine'] . '</td>
                                        <td>' . $sosdetarr[0]['NegativeResultOral'] . '</td>
                                        <td colspan="2">Positive Alcohol</td>
                                        <td colspan="1">' . $sosdetarr[0]['PositiveAlcohol'] . '</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">Results Requiring Further Testing</td>
                                        <td>' . $sosdetarr[0]['FurtherTestUrine'] . '</td>
                                        <td>' . $sosdetarr[0]['FurtherTestOral'] . '</td>
                                        <td colspan="2">Refusals, No Shows or Other</td>
                                        <td colspan="1">' . $sosdetarr[0]['Refusals'] . '</td>
                                    </tr>
                                    <tr>
                                        <td colspan="8">Extra Used: ' . $sosdetarr[0]['ExtraUsed'] . '</td>
                                    </tr>
                                    <tr>
                                        <td colspan="8">I\'ve conducted the alcohol and/or drug screening/collection service detailed above and confirm that all procedures were undertaken in accordance with the relevant Standard. <b>Collector Signature:</b> <img  style="width:120px" src="' . __BASE_UPLOADED_SIGN_URL__ . $sosdetarr[0]['collsign'] . '" /></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">Collector Name: ' . $sosdetarr[0]['collname'] . '</td>
                                        <td colspan="6">Comments or Observation: ' . $sosdetarr[0]['Comments'] . '</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">Nominated Client Representative: ' . $ClientDets[0]['szName'] . '</td>
                                        <td colspan="2">Signature: <img  style="width:120px" src="' . __BASE_UPLOADED_SIGN_URL__ . $sosdetarr[0]['RepresentativeSignature'] . '" /></td>
                                        <td colspan="2">Time: ' . $sosdetarr[0]['RepresentativeSignatureTime'] . '</td>
                                    </tr>
                                    ';
        $html .= '
                            </table>
                        </div>                      
                        ';

        $pdf->writeHTML($html, true, false, true, false, '');
        ob_end_clean();
        $pdfname = 'view_sos_details-' . date('d-m-Y-H-i-s') . '-' . uniqid() . '.pdf';
        $pdf->Output(__APP_PATH__ . '/' . UPLOAD_DIR . $pdfname, 'F');
        sleep(10);
        $responsedata = array("code" => 200, "file" => __BASE_URL__ . '/uploadsign/' . $pdfname);
        header('Content-Type: application/json');
        echo json_encode($responsedata);
    }

    function cocformpdf()
    {
        $jsondata = json_decode(file_get_contents("php://input"));
        $cocid = !empty($jsondata->cocid) ? $jsondata->cocid : "0";
        $sosstat = $jsondata->sosstat;
        ob_start();
        define('UPLOAD_DIR', 'uploadsign/');
        $this->load->library('Pdf');
        $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetTitle('Drug-safe COC Form Details');
        $pdf->SetAuthor('Drug-safe');
        $pdf->SetSubject('COC Form PDF');
        $pdf->SetMargins(PDF_MARGIN_LEFT - 10, PDF_MARGIN_TOP - 20, PDF_MARGIN_RIGHT - 10);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM - 15);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->SetDisplayMode('real', 'default');
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetFont('times', '', 8);

        $pdf->AddPage('P');

        //$cocid = $this->session->userdata('cocid');
        $cocdetarr = $this->Webservices_Model->getcocdatabycocid($cocid);
        $sosdetarr = $this->Webservices_Model->getsosdatabycocid($cocid, $sosstat, 1);
        $sosuserdets = $this->Webservices_Model->getuserhierarchybysiteid($sosdetarr[0]['Clientid']);
        //echo 'Hi '.$sosuserdets[0]['franchiseeId'];
        $franchiseeDets = $this->Webservices_Model->getuserdetails($sosuserdets[0]['franchiseeId']);
        $ClientDets = $this->Webservices_Model->getuserdetails($sosuserdets[0]['clientType']);
        $ClientBusinessDetArr = $this->Webservices_Model->getclientdetailsbyclientid($sosuserdets[0]['clientType']);
        $SiteDets = $this->Webservices_Model->getuserdetails($sosdetarr[0]['Clientid']);
        $getState = $this->Franchisee_Model->getStateByFranchiseeId($sosuserdets[0]['franchiseeId']);
        if (!empty($cocdetarr[0]['drugtest'])) {
            $drugtype = explode(',', $cocdetarr[0]['drugtest']);
        }
        $html = '<a style="text-align:center;  margin-bottom:0px;" href="' . __BASE_URL__ . '" ><img style="width:100px" src="' . __BASE_URL__ . '/images/logo.png" alt="logo" class="logo-default" /> </a>
            <div><br><span style="text-align:center; font-size:12px; margin-bottom:0px; color:black"><b>COC Details</b></span></div>
            <div class= "table-responsive" >
                            <table border="1" cellpadding="3">
                                    <tr>
                                    <td colspan="3"><h4>CHAIN OF CUSTODY FORM</h4></td>
                                    <td colspan="2" rowspan="3"><h3>' . $franchiseeDets[0]['szName'] . '</h3></td>
                                    <td colspan="3">Address: ' . $franchiseeDets[0]['szAddress'] . ', ' . $franchiseeDets[0]['szZipCode'] . ', ' . $franchiseeDets[0]['szCity'] . ', ' . $getState['name'] . ', ' . $franchiseeDets[0]['szCountry'] . '</td>
                                    </tr>
                                    <tr>                                    
                                    <td colspan="3" rowspan="2">T: ' . $franchiseeDets[0]['szContactNumber'] . '</td>                                  
                                    <td colspan="3">ABN: ' . $franchiseeDets[0]['abn'] . '</td>
                                    </tr>
                                    <tr>
                                    <td colspan="3">Email: ' . $franchiseeDets[0]['szEmail'] . '</td>
                                    </tr>
                                    <tr>
    <td colspan="4"><b>REQUESTING AUTHORITY</b></td>
    <td colspan="4"><b>DONOR INFORMATION</b></td>
</tr>
<tr>
    <td colspan="4">Collection/Screen Date: ' . date('d/m/Y', strtotime($cocdetarr[0]['cocdate'])) . '</td>
    <td colspan="4">Name: ' . $sosdetarr[0]['donerName'] . '</td>
</tr>
<tr>
    <td colspan="4">Nominated Representative: ' . $ClientDets[0]['szName'] . '</td>
    <td colspan="4"></td>
</tr>
<tr>
    <td colspan="4">Client: ' . $ClientBusinessDetArr[0]['szBusinessName'] . '</td>
    <td colspan="4">DOB: ' . date('d/m/Y', strtotime($cocdetarr[0]['dob'])) . '</td>
</tr>
<tr>
    <td colspan="4">Collection Site: ' . $SiteDets[0]['szName'] . '</td>
    <td colspan="4">' . ($cocdetarr[0]['employeetype'] == '1' ? 'Employee' : ($cocdetarr[0]['employeetype'] == '2' ? 'Contractor' : '')) . '</td>
</tr>
<tr>
    <td colspan="4">Drug to be tested: ';
        if (!empty($drugtype)) {
            $drugtestList = '';
            foreach ($drugtype as $key => $val) {
                if ($val == '1') {
                    $drugtestList .= 'Alcohol, ';
                }
                if ($val == '2') {
                    $drugtestList .= 'Oral Fluid, ';
                }
                if ($val == '3') {
                    $drugtestList .= 'Urine, ';
                }
                if ($val == '5') {
                    $drugtestList .= 'Other: '.$sosdetarr[0]['other_drug_test'].',';
                }
            }
            $html .= substr(trim($drugtestList), 0, -1);
//            $html .= ($cocdetarr[0]['drugtest'] == '1'?'Alcohol':($cocdetarr[0]['drugtest'] == '2'?'Oral Fluid':($cocdetarr[0]['drugtest'] == '3'?'Urine':'Other')));
        }
        $html .= '</td>
    <td colspan="4">Contractor details: ' . (!empty($cocdetarr[0]['contractor']) ? $cocdetarr[0]['contractor'] : '') . '</td>
</tr>
<tr>
    <td colspan="4">Please Note: NATA/RCPA accreditation does not cover the performance of breath test</td>
    <td colspan="2">Identity Verified</td>
    <td>ID Type: ' . ($cocdetarr[0]['idtype'] == '1' ? 'Driving License' : ($cocdetarr[0]['idtype'] == '2' ? 'Photo ID Card' : ($cocdetarr[0]['idtype'] == '3' ? 'Passport' : ''))) . '</td>
    <td>ID No: ' . $cocdetarr[0]['idnumber'] . '</td>
</tr>
<tr>
 <td colspan="5">Have you taken any medication, drugs or other non-prescription agents in last week? ' . $cocdetarr[0]['lastweekq'] . '<br />I consent to the testing of my breath/urine/oral fluid sample for alcohol &/or drugs.</td>
    <td colspan="3">Donor Signature: <img style="width:120px" src="' . __BASE_UPLOADED_SIGN_URL__ . $cocdetarr[0]['donorsign'] . '" /></td>
</tr>
<tr>
    <td rowspan="2" colspan="2"><b>Alcohol Breath Test</b></td>
    <td colspan="2">Device Serial#: ' . $cocdetarr[0]['devicesrno'] . '</td>
    <td colspan="2">Cut off Level: ' . $cocdetarr[0]['cutoff'] . '</td>
    <td colspan="2">Wait Time<sub>[Minutes]</sub>: ' . $this->formatcustomTime($cocdetarr[0]['donwaittime']) . '</td>
</tr>
<tr>
    <td>Test 1: ' . $cocdetarr[0]['dontest1'] . '</td>
    <td colspan="2">Time: ' . $this->formatcustomTime($cocdetarr[0]['dontesttime1']) . ' hours</td>
    <td>Test 2: ' . $cocdetarr[0]['dontest2'] . '</td>
    <td>Time: ' . $this->formatcustomTime($cocdetarr[0]['dontesttime2']) . ' hours</td>
</tr>
<tr>
    <td colspan="8"><b>Collection of Sample/On-Site Drug Screening Results</b></td>
</tr>
<tr>
    <td colspan="2">Void Time: ' . $this->formatcustomTime($cocdetarr[0]['voidtime']) . ' hours</td>
    <td colspan="2">Sample Temp C: ' . $cocdetarr[0]['sampletempc'] . '</td>
    <td colspan="4">Temp Read Time within 4 min: ' . $this->formatcustomTime($cocdetarr[0]['tempreadtime']) . ' hours</td>
</tr>
<tr>
    <td colspan="2">Adulterant Test Lot No.: ' . $cocdetarr[0]['intect'] . '</td>
    <td colspan="2">Expiry: ' . (!empty($cocdetarr[0]['intect']) ? date('d/m/Y', strtotime($cocdetarr[0]['intectexpiry'])) : '') . '</td>
    <td colspan="4">Visual Colour: ' . $cocdetarr[0]['visualcolor'] . '</td>
</tr>
<tr>
    <td colspan="2">Creatinine: ' . $cocdetarr[0]['creatinine'] . '</td>
    <td colspan="2">Other Integrity: ' . $cocdetarr[0]['otherintegrity'] . '</td>
    <td colspan="4">Hydration: ' . $cocdetarr[0]['hudration'] . '</td>
</tr>
<tr>
    <td colspan="2">Drug Device Name: ' . $cocdetarr[0]['devicename'] . '</td>
    <td colspan="2">Reference#: ' . $cocdetarr[0]['reference'] . '</td>
    <td colspan="2">Lot#: ' . $cocdetarr[0]['lotno'] . '</td>
    <td colspan="2">Expiry: ' . (date('d/m/Y', strtotime($cocdetarr[0]['lotexpiry'])) != '01/01/1970' && date('d/m/Y', strtotime($cocdetarr[0]['lotexpiry'])) != '30/11/-0001' ? date('d/m/Y', strtotime($cocdetarr[0]['lotexpiry'])) : 'N/A') . '</td>
</tr>
<tr>
    <td><b>Drugs Class</b></td>
    <td>Cocaine </td>
    <td>Amp </td>
    <td>mAmp </td>
    <td>THC </td>
    <td>Opiates </td>
    <td>Benzo </td>
    <td>Other </td>
</tr>
<tr>
    <td>Screening Result - N = Negative result<br />U = Further testing required</td>
    <td>' . ($cocdetarr[0]['cocain'] == 'U' ? 'Further Testing Required' : ($cocdetarr[0]['cocain'] == 'N' ? 'Negative' : '')) . '</td>
    <td>' . ($cocdetarr[0]['amp'] == 'U' ? 'Further Testing Required' : ($cocdetarr[0]['amp'] == 'N' ? 'Negative' : '')) . '</td>
    <td>' . ($cocdetarr[0]['mamp'] == 'U' ? 'Further Testing Required' : ($cocdetarr[0]['mamp'] == 'N' ? 'Negative' : '')) . '</td>
    <td>' . ($cocdetarr[0]['thc'] == 'U' ? 'Further Testing Required' : ($cocdetarr[0]['thc'] == 'N' ? 'Negative' : '')) . '</td>
    <td>' . ($cocdetarr[0]['opiates'] == 'U' ? 'Further Testing Required' : ($cocdetarr[0]['opiates'] == 'N' ? 'Negative' : '')) . '</td>
    <td>' . ($cocdetarr[0]['benzo'] == 'U' ? 'Further Testing Required' : ($cocdetarr[0]['benzo'] == 'N' ? 'Negative' : '')) . '</td>
    <td>' . ($cocdetarr[0]['otherdc'] == 'U' ? 'Further Testing Required' : ($cocdetarr[0]['otherdc'] == 'N' ? 'Negative' : '')) . '</td>
</tr>
<tr><td colspan="8"><b>Collection time of sample:</b> ' . $this->formatcustomTime($cocdetarr[0]['ctstime']) . ' hours</td> </tr>
<tr>
    <td colspan="8" align="center"><b>Donor Declaration</b></td>
</tr>
<tr>
    <td colspan="8">I certify that the specimen(s) accompanying this form is my own. Where on-site screening was performed, such screening was carried out in my presence. In the case of my specimen(s) being sent to the laboratory for testing, I certify that the specimen containers were sealed with tamper evident seals in my presence and the identifying information on the label is correct. I certify that the information provided on this form to be correct and I consent to the release of all test results together with any relevant details contained on this form to the nominated representative of the requesting authority.</td>
</tr>
<tr>
    <td colspan="7">Donor Signature: <img style="width:120px" src="' . __BASE_UPLOADED_SIGN_URL__ . $cocdetarr[0]['donordecsign'] . '" /></td>
    <td>Date: ' . date('d/m/Y', strtotime($cocdetarr[0]['donordecdate'])) . '</td>
</tr>
<tr>
    <td colspan="8" align="center"><b>Collector Certification</b></td>
</tr>
<tr>
    <td colspan="8">I certify that I witnessed the Donor signature and that the specimen(s) identified on this form was provided to me by the Donor whose consent and declaration appears above, bears the same Donor identification as set forth above, and that the specimen(s) has been collected and if needed divided, labelled and sealed in accordance with the relevant Standard. *If two Collectors are present the second Collector (2) is to perform sample collection/screening for Alcohol and Urine.</td>
</tr>
<tr>
    <td colspan="4">Collector 1 Name/Number: ' . $cocdetarr[0]['collectorone'] . '</td>
    <td colspan="4">Collector 2 Name/Number: ' . $cocdetarr[0]['collectortwo'] . '</td>
</tr>
<tr>
    <td colspan="4">Signature: <img style="width:120px" src="' . __BASE_UPLOADED_SIGN_URL__ . $cocdetarr[0]['collectorsignone'] . '" /></td>
    <td colspan="4">Signature: <img style="width:120px" src="' . __BASE_UPLOADED_SIGN_URL__ . $cocdetarr[0]['collectorsigntwo'] . '" /></td>
</tr>
<tr>
    <td colspan="4">Comments or Observation: ' . $cocdetarr[0]['commentscol1'] . '</td>
    <td colspan="4">Comments or Observation: ' . $cocdetarr[0]['commentscol2'] . '</td>
</tr>
<tr><td colspan="8"><b>On-Site Screening Report:</b> ' . ($cocdetarr[0]['onsitescreeningrepo'] == '1'?'Final':($cocdetarr[0]['onsitescreeningrepo'] == '2'?'Interim':'')) . '</td> </tr>
<tr>
    <td colspan="8" align="center"><b>Chain of Custody</b></td>
</tr>
<tr>
    <td colspan="2">Received By(print) </td>
    <td colspan="2">Signature </td>
    <td colspan="2">Date/Time Received</td>
    <td>Seal Intact</td>
    <td>Label/Bar Code Match</td>
</tr>
<tr>
    <td colspan="2"><br><br></td>
    <td colspan="2"><br><br></td>
    <td colspan="2"><br><br></td>
    <td><br><br></td>
    <td><br><br></td>
</tr>
<tr>
    <td colspan="2"><br><br></td>
    <td colspan="2"><br><br></td>
    <td colspan="2"><br><br></td>
    <td><br><br></td>
    <td><br><br></td>
</tr>
</table>
                        </div>                      
                        ';

        $pdf->writeHTML($html, true, false, true, false, '');
        ob_end_clean();
        $pdfname = 'view_coc_details-' . date('d-m-Y-H-i-s') . '-' . uniqid() . '.pdf';
        $pdf->Output(__APP_PATH__ . '/' . UPLOAD_DIR . $pdfname, 'F');
        sleep(10);
        $responsedata = array("code" => 200, "file" => __BASE_URL__ . '/uploadsign/' . $pdfname);
        header('Content-Type: application/json');
        echo json_encode($responsedata);
    }

    function getfranchiseeinventory()
    {
        $jsondata = json_decode(file_get_contents("php://input"));
        $data['franchiseeid'] = !empty($jsondata->franchiseeid) ? $jsondata->franchiseeid : "0";
        $data['prodid'] = !empty($jsondata->prodid) ? $jsondata->prodid : "0";
        $franchiseeInventoryArr = $this->Webservices_Model->getFranchiseeInventory($data['franchiseeid'], $data['prodid']);
        if (!empty($franchiseeInventoryArr)) {
            $responsedata = array("code" => 200, "dataarr" => $franchiseeInventoryArr);
        } else {
            $responsedata = array("code" => 201, "message" => "No product found.");
        }
        header('Content-Type: application/json');
        echo json_encode($responsedata);
    }

    function formatcustomTime($time)
    {
        $timeArr = explode(':', $time);
        $timeval = "";
        if (trim($timeArr[0]) > 0) {
            $timeval = sprintf("%02d", trim($timeArr[0])) . ' : ' . sprintf("%02d", trim($timeArr[1]));
        }
        return $timeval;
    }

    function generateLabAdviceForm()
    {
        $jsondata = json_decode(file_get_contents("php://input"));
        $sosid = !empty($jsondata->sosid) ? $jsondata->sosid : "0";

        ob_start();
        define('UPLOAD_DIR', 'uploadsign/');
        $this->load->library('Pdf');
        $pdf = new Pdf('L', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetTitle('Drug-safe Lab Advice Form');
        $pdf->SetAuthor('Drug-safe');
        $pdf->SetSubject('Lab Advice Form');
        $pdf->SetMargins(PDF_MARGIN_LEFT - 10, PDF_MARGIN_TOP - 15, PDF_MARGIN_RIGHT - 10);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM - 10);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->SetDisplayMode('real', 'default');
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetFont('times', '', 12);

        $pdf->AddPage('L');
        $html = '';
        $DonorsArr = $this->Webservices_Model->getdonorsbysosid($sosid);
        if (!empty($DonorsArr)) {
            $sosdetarr = $this->Webservices_Model->getsosformdatabysosid($sosid);
            $sosuserdets = $this->Webservices_Model->getuserhierarchybysiteid($sosdetarr[0]['Clientid']);
            $franchiseeDets = $this->Webservices_Model->getuserdetails($sosuserdets[0]['franchiseeId']);
            $getState = $this->Franchisee_Model->getStateByFranchiseeId($sosuserdets[0]['franchiseeId']);
            $positiveDrugCount = 0;
            $html .= '<div class="table-responsive">
    <table border="1" cellpadding="8">
        <tbody>
        <tr>
            <td colspan="3"><a style="text-align:center;  margin-bottom:0px;" href="' . __BASE_URL__ . '" ><img style="width:145px" src="' . __BASE_URL__ . '/images/logo.png" alt="logo" class="logo-default" /> </a></td>
            <td colspan="3"><br><br><b>Lab Tag/Express Post #:</b></td>
        </tr>
        <tr>
            <td colspan="6" style="background-color: #000; color: #fff; font-size:24px;">
                Laboratory Advice Form - Drug-Safe Communities
            </td>
        </tr>
        <tr>
            <td colspan="6">
                <br><span style="margin-top:10px; font-size:18px; font-weight:bold">To be completed by Field Testing Officer collecting the specimen.</span><br />
                <br>Please send the original copy of this form to the laboratory with the specimen(s) and the yellow copy to
                    Drug-Safe Communities Administration Client Services included with the on-site paperwork to 
                    '.$franchiseeDets[0]['szAddress'] . ', ' . $franchiseeDets[0]['szZipCode'] . ', ' . $franchiseeDets[0]['szCity'] . ', ' . $getState['name'] . ', ' . $franchiseeDets[0]['szCountry'].'.
            </td>
        </tr>
        <tr>
            <th><b>No.</b></th>
            <th><b>Donor Name</b></th>
            <th><b>Date Collected</b></th>
            <th><b>Barcode</b></th>
            <th><b>T-Number</b></th>
            <th><b>Date Result Received</b><br><span style="font-size:11px">(Support office use only)</span></th>
        </tr>';
            foreach ($DonorsArr as $donordata) {
                if (!empty($donordata['drug'])) {
                    $positiveDrugCount++;
                }
            }
            if ($positiveDrugCount > 0) {
                $clientCode = '';
                $DrugtestDate = '';
                $TestDate = array();
                $donorName = array();
                $sosformData = $this->Webservices_Model->getsosformdatabysosid($sosid);
                if (!empty($sosformData)) {
                    $DrugtestDate = date('d/m/Y', strtotime($sosformData[0]['testdate']));
                    $getCientArr = $this->Webservices_Model->getuserhierarchybysiteid($sosformData[0]['Clientid']);
                    if (!empty($getCientArr)) {
                        $getClientCodeArr = $this->Webservices_Model->getuserdetails($getCientArr[0]['clientType']);
                        if (!empty($getClientCodeArr)) {
                            $clientCode = $getClientCodeArr[0]['userCode'];
                        }
                    }
                }
                foreach ($DonorsArr as $donordata) {
                    if (!empty($donordata['drug'])) {
                        array_push($donorName, $donordata['donerName']);
                        $cocformData = $this->Webservices_Model->getcocdatabycocid($donordata['cocid']);
                        if (!empty($cocformData)) {
                            array_push($TestDate, date('d/m/Y', strtotime($cocformData[0]['cocdate'])));
                        }

                    }
                }
                if ($clientCode != '' && !empty($TestDate) && !empty($donorName)) {
                    $counter = 1;

                    for ($i = 0; $i < count($donorName); $i++) {
                        $html .= '<tr>
            <td>' . $counter . '</td>
            <td>' . $donorName[$i] . '</td>
            <td>' . $TestDate[$i] . '</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>';
                        $counter++;
                    }
                    $html .= '<tr>
            <td colspan="6">
                <b>Client No.: </b>' . $clientCode . '
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <b>Date sent to lab: </b>' . $DrugtestDate . '
            </td>
            <td colspan="3">
                <b>Total no. sent:</b>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <b>Name/emp no. of collector:</b>
            </td>
            <td colspan="3">
                <b>Signed:</b>
            </td>
        </tr>
        <tr>
            <td colspan="6">
                <br><span style="margin-top:10px; font-size:18px; font-weight:bold">Referral Laboratory (please circle):</span><br />
                <br>Laverty / RASL / Dorevitch / Safe Work QLD / Safe Work NT / Safe Work WA / Chemcentre
            </td>
        </tr>
        <tr>
            <td rowspan="2" colspan="3">Lab Advice Form - Drug-Safe Communities</td>
            <td colspan="3">Authorised by Operations Manager</td>
        </tr>
        <tr>
            <td colspan="3">Controlled document for exclusive use by Drug-Safe Communities personnel.</td>
        </tr>
        </tbody>
    </table>
    </tbody>
    </table>
    <p>&nbsp; &copy; Drug-Safe Communities '.date('Y').'</p>
    </div>';

                }
                $pdf->writeHTML($html, true, false, true, false, '');
                ob_end_clean();
                $pdfname = 'view_Lab_Advice_Form-' . date('d-m-Y-H-i-s') . '-' . uniqid() . '.pdf';
                $pdf->Output(__APP_PATH__ . '/' . UPLOAD_DIR . $pdfname, 'F');
                $labFormUploadStat = $this->Webservices_Model->AddLabAdviceForm($sosid, $pdfname);
                sleep(5);
                if (!empty($labFormUploadStat)) {
                    $responsedata = array("code" => 200, "result" => __BASE_URL__ . '/uploadsign/' . $labFormUploadStat);
                } else {
                    $responsedata = array("code" => 200, "result" => '0');
                }

            } else {
                $responsedata = array("code" => 200, "result" => '0');
            }

        } else {
            $responsedata = array("code" => 201, "result" => "No donor found.");
        }
        header('Content-Type: application/json');
        echo json_encode($responsedata);
    }

    function addsosdataopencoc()
    {
        $jsondata = json_decode(file_get_contents("php://input"));
        $dataArr['sosdate'] = !empty($jsondata->sosdate) ? $jsondata->sosdate : "";
        $dataArr['userid'] = !empty($jsondata->userid) ? $jsondata->userid : "0";
        $dataArr['reqclient'] = !empty($jsondata->reqclient) ? $jsondata->reqclient : "";
        $dataArr['site'] = !empty($jsondata->site) ? $jsondata->site : "";
        $dataArr['other_drug_test'] = !empty($jsondata->othertest) ? $jsondata->othertest : "";
        $drug = '';
        $otherTest = false;
        $dsarrcount = count($jsondata->drugtest);
        if (!is_array($jsondata->drugtest)) {
            $drug = $jsondata->drugtest;
            if($drug == '5'){
                $otherTest = true;
            }
        } elseif (($dsarrcount > '1') && !empty($jsondata->drugtest)) {
            foreach ($jsondata->drugtest as $key => $value) {
                if ($value == '5') {
                    $otherTest = true;
                }
                $drug .= $value . ',';
            }
            if (!empty($drug)) {
                $drug = substr($drug, 0, -1);
            }
        }
        if ($otherTest) {
            $dataArr['otherTestCheck'] = true;
            $dataArr['other_drug_test'];
        } else {
            $dataArr['otherTestCheck'] = false;
            $dataArr['other_drug_test'] = '';
        }
        $ServiceFac = '';
        $SFArrcount = count($jsondata->screenfacility);
        if ($SFArrcount == '1') {
            $ServiceFac = $jsondata->screenfacility;
        } elseif (($SFArrcount > '1') && !empty($jsondata->screenfacility)) {
            foreach ($jsondata->screenfacility as $SFkey => $SFvalue) {
                $ServiceFac .= $SFvalue . ',';
            }
            if (!empty($ServiceFac)) {
                $ServiceFac = substr($ServiceFac, 0, -1);
            }
        }

        $dataArr['drugtest'] = $drug;
        $dataArr['screenfacility'] = $ServiceFac;
        $dataArr['start_km'] = !empty($jsondata->startkm) ? $jsondata->startkm : "0";
        $dataArr['end_km'] = !empty($jsondata->endkm) ? $jsondata->endkm : "0";
        $dataArr['total_km'] = !empty($jsondata->totalkm) ? $jsondata->totalkm : "0";
        $dataArr['formtype'] = $jsondata->formtype;
        $dataArr['status'] = !empty($jsondata->status) ? $jsondata->status : "0";
        $dataArr['servicecomm'] = !empty($jsondata->servicecomm) ? $jsondata->servicecomm : "";
        $dataArr['donercount'] = !empty($jsondata->donercount) ? $jsondata->donercount : "1";
        $dataArr['servicecon'] = !empty($jsondata->servicecon) ? $jsondata->servicecon : "";
        $dataArr['totscreenu'] = $jsondata->totscreenu;
        $dataArr['totscreeno'] = $jsondata->totscreeno;
        $dataArr['negresu'] = $jsondata->negresu;
        $dataArr['negreso'] = $jsondata->negreso;
        $dataArr['furtestu'] = $jsondata->furtestu;
        $dataArr['furtesto'] = $jsondata->furtesto;
        $dataArr['totalcscreen'] = $jsondata->totalcscreen;
        $dataArr['negalcres'] = $jsondata->negalcres;
        $dataArr['posalcres'] = $jsondata->posalcres;
        $dataArr['refusals'] = $jsondata->refusals;
        $dataArr['devicename'] = !empty($jsondata->devicename) ? $jsondata->devicename : "";
        $dataArr['extraused'] = !empty($jsondata->extraused) ? $jsondata->extraused : "";
        $dataArr['breathtest'] = !empty($jsondata->breathtest) ? $jsondata->breathtest : "";
        $dataArr['collname'] = !empty($jsondata->collname) ? $jsondata->collname : "";
        $dataArr['collsign'] = !empty($jsondata->collsign) ? $jsondata->collsign : "";
        $dataArr['comments'] = !empty($jsondata->comments) ? $jsondata->comments : "";
        $dataArr['nominated'] = !empty($jsondata->nominated) ? $jsondata->nominated : "";
        $dataArr['nominedec'] = !empty($jsondata->nominedec) ? $jsondata->nominedec : "";
        $dataArr['sign'] = !empty($jsondata->sign) ? $jsondata->sign : "";
        $dataArr['update'] = !empty($jsondata->update) ? $jsondata->update : "";
        $dataArr['donercountpre'] = !empty($jsondata->donercountpre) ? $jsondata->donercountpre : "";
        $dataArr['donercountpost'] = !empty($jsondata->donercountpost) ? $jsondata->donercountpost : "";
        $dataArr['newdonerids'] = !empty($jsondata->newdonerids) ? $jsondata->newdonerids : "";
        $dataArr['idsos'] = !empty($jsondata->idsos) ? $jsondata->idsos : "";
        $dataArr['cocstat'] = !empty($jsondata->cocstat) ? $jsondata->cocstat : "0";
        $dataArr['kitcount'] = !empty($jsondata->kitcount) ? $jsondata->kitcount : "1";
        $dataArr['oldkitcount'] = !empty($jsondata->oldkitcount) ? $jsondata->oldkitcount : "0";
        $dataArr['totalkitcount'] = !empty($jsondata->totalkitcount) ? $jsondata->totalkitcount : "0";
        $dataArr['newkitids'] = !empty($jsondata->newkitids) ? $jsondata->newkitids : "";
        $dataArr['sign1'] = $jsondata->sign1;
        $dataArr['sign2'] = $jsondata->sign2;
        $dataArr['agent_comment'] = !empty($jsondata->agentcomment) ? $jsondata->agentcomment : "";

        $dataArr['donorname'] = !empty($jsondata->donorname) ? $jsondata->donorname : "";
        $dataArr['drugresult'] = !empty($jsondata->drugresult) ? $jsondata->drugresult : "";
        $dataArr['drugtype'] = !empty($jsondata->drugtype) ? $jsondata->drugtype : "";
        $dataArr['pos1read'] = !empty($jsondata->pos1read) ? $jsondata->pos1read : "";
        $dataArr['pos2read'] = !empty($jsondata->pos2read) ? $jsondata->pos2read : "";
        $dataArr['lab'] = !empty($jsondata->lab) ? $jsondata->lab : "";
        $dataArr['oth'] = !empty($jsondata->oth) ? $jsondata->oth : "";
        $dataArr['donorid'] = !empty($jsondata->donorid) ? $jsondata->donorid : "0";

        if (($dataArr['furtestu'] > 0) || ($dataArr['furtesto'] > 0)) {
            $dataArr['furthertestreq'] = '1';
        } else {
            $dataArr['furthertestreq'] = '0';
        }

        if (!empty($dataArr)) {
            $sosdatares = $this->Webservices_Model->addsosdataOpenCoc($dataArr);
            $errorMsgArr = $this->Webservices_Model->arErrorMessages;
            if (!empty($errorMsgArr) && !empty($errorMsgArr['testdate'])) {
                $responsedata = array("code" => 203, "message" => $errorMsgArr['testdate']);
            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['site'])) {
                $responsedata = array("code" => 203, "message" => $errorMsgArr['site']);
            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['drugtest'])) {
                $responsedata = array("code" => 203, "message" => $errorMsgArr['drugtest']);
            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['othertest'])) {
                $responsedata = array("code" => 203, "message" => $errorMsgArr['othertest']);
            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['screenfacility'])) {
                $responsedata = array("code" => 203, "message" => $errorMsgArr['screenfacility']);
            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['startkm'])) {
                $responsedata = array("code" => 203, "message" => $errorMsgArr['start_km']);
            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['endkm'])) {
                $responsedata = array("code" => 203, "message" => $errorMsgArr['end_km']);
            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['totalkm'])) {
                $responsedata = array("code" => 203, "message" => $errorMsgArr['total_km']);
            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['servicecomm'])) {
                $responsedata = array("code" => 203, "message" => $errorMsgArr['servicecomm']);
            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['servicecon'])) {
                $responsedata = array("code" => 203, "message" => $errorMsgArr['servicecon']);
            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['totscreenu'])) {
                $responsedata = array("code" => 203, "message" => $errorMsgArr['totscreenu']);
            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['totscreeno'])) {
                $responsedata = array("code" => 203, "message" => $errorMsgArr['totscreeno']);
            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['negresu'])) {
                $responsedata = array("code" => 203, "message" => $errorMsgArr['negresu']);
            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['negreso'])) {
                $responsedata = array("code" => 203, "message" => $errorMsgArr['negreso']);
            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['furtestu'])) {
                $responsedata = array("code" => 203, "message" => $errorMsgArr['furtestu']);
            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['furtesto'])) {
                $responsedata = array("code" => 203, "message" => $errorMsgArr['furtesto']);
            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['totalcscreen'])) {
                $responsedata = array("code" => 203, "message" => $errorMsgArr['totalcscreen']);
            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['negalcres'])) {
                $responsedata = array("code" => 203, "message" => $errorMsgArr['negalcres']);
            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['posalcres'])) {
                $responsedata = array("code" => 203, "message" => $errorMsgArr['posalcres']);
            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['refusals'])) {
                $responsedata = array("code" => 203, "message" => $errorMsgArr['refusals']);
            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['devicename'])) {
                $responsedata = array("code" => 203, "message" => $errorMsgArr['devicename']);
            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['extraused'])) {
                $responsedata = array("code" => 203, "message" => $errorMsgArr['extraused']);
            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['breathtest'])) {
                $responsedata = array("code" => 203, "message" => $errorMsgArr['breathtest']);
            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['sign1'])) {
                $responsedata = array("code" => 203, "message" => $errorMsgArr['collsign']);
            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['nominated'])) {
                $responsedata = array("code" => 203, "message" => $errorMsgArr['nominated']);
            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['nominedec'])) {
                $responsedata = array("code" => 203, "message" => $errorMsgArr['nominedec']);
            } elseif (!empty($errorMsgArr) && !empty($errorMsgArr['sign2'])) {
                $responsedata = array("code" => 203, "message" => "Nominated Client Representative signature required.");
            } elseif (!empty($sosdatares['totalcoccount'][0]['totalcoc'])) {
                $coccount = (int)$sosdatares['totalcoccount'][0]['totalcoc'];
                $cocid = (int)$sosdatares['cocid'][0]['cocid'];
                if ((int)$coccount > '1') {
                    $responsedata = array("code" => 200, "count" => (int)$coccount, "sosid" => $sosdatares['sosid'], "message" => "SOS form data saved successfully.");
                } else {
                    $responsedata = array("code" => 200, "count" => (int)$coccount, "sosid" => $sosdatares['sosid'], "cocid" => $cocid, "message" => "SOS form data saved successfully.");
                }

            } elseif ($sosdatares['sosid'] > 0) {
                $responsedata = array("code" => 200, "message" => "SOS form data added successfully.", "sosid" => $sosdatares['sosid']);
            } else {
                $responsedata = array("code" => 201, "errordata" => $sosdatares);
            }
        } else {
            $responsedata = array("code" => 111, "message" => "Bad Request.");
        }
        header('Content-Type: application/json');
        echo json_encode($responsedata);
    }
}