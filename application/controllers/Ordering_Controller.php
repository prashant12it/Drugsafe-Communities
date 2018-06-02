<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ordering_Controller extends CI_Controller
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

    function viewcalform()
    {
        $idsite = $this->input->post('idsite');
        $Drugtestid = $this->input->post('Drugtestid');
        $sosid = $this->input->post('sosid');
        $this->session->set_userdata('Drugtestid', $Drugtestid);
        $this->session->set_userdata('idsite', $idsite);
        $this->session->set_userdata('sosid', $sosid);
        echo "SUCCESS||||";
        echo "calform";
    }

    public function calform()
    {
        $count = $this->Admin_Model->getnotification();
        $commentReplyNotiCount = $this->Forum_Model->commentReplyNotifications();
        $is_user_login = is_user_login($this);
        // redirect to dashboard if already logged in
        if (!$is_user_login) {
            ob_end_clean();
            redirect(base_url('/admin/admin_login'));
            die;
        }
        $freanchId = $this->session->userdata('freanchId');
        $Drugtestid = $this->session->userdata('Drugtestid');
        $idsite = $this->session->userdata('idsite');
        $sosid = $this->session->userdata('sosid');
        $data = $this->input->post('orderingData');
        if($data){
            $checkforvalidation = false;
        }else{
            $checkforvalidation = true;
        }

        $this->load->library('form_validation');


        if($data['OtherDrugOpt'] == '1'){
            $this->form_validation->set_rules('orderingData[OtherDrugRRPValue]', 'RRP for '.$data['OtherDrugName'], 'required|numeric');
            $checkforvalidation = true;
        }
          if(!empty($data['FCOBasePrice']) || !empty($data['FCOHr'])){
        $this->form_validation->set_rules('orderingData[FCOBasePrice]', 'Base Price', 'required|numeric');
        $this->form_validation->set_rules('orderingData[FCOHr]', 'Hours', 'required|greater_than[1]|numeric');
        $checkforvalidation = true;
          }
        if(!empty($data['SyntheticCannabinoids'])){
            $this->form_validation->set_rules('orderingData[SyntheticCannabinoids]', 'Synthetic Cannabinoids Screening', 'required|numeric');
            $checkforvalidation = true;
        }
         if(!empty($data['mobileScreenBasePrice']) || !empty($data['mobileScreenHr'])){
        $this->form_validation->set_rules('orderingData[mobileScreenBasePrice]', 'Base Price', 'required|numeric');
        $this->form_validation->set_rules('orderingData[mobileScreenHr]', 'Hours', 'required|numeric');
             $checkforvalidation = true;
         }
          if(!empty($data['CallOutBasePrice']) || !empty($data['CallOutHr'])){
        $this->form_validation->set_rules('orderingData[CallOutBasePrice]', 'Base Price', 'required|numeric');
        $this->form_validation->set_rules('orderingData[CallOutHr]', 'Hours', 'required|greater_than[0]|numeric');
              $checkforvalidation = true;
         }
        if(!empty($data['urineNata'])){
            $this->form_validation->set_rules('orderingData[urineNata]', 'Urine NATA Laboratory screening', 'required|numeric');
            $checkforvalidation = true;
        }
        if(!empty($data['nataLabCnfrm'])){
            $this->form_validation->set_rules('orderingData[nataLabCnfrm]', 'NATA Laboratory confirmation', 'required|numeric');
            $checkforvalidation = true;
        }
        if(!empty($data['oralFluidNata'])){
            $this->form_validation->set_rules('orderingData[oralFluidNata]', 'Oral Fluid NATA Laboratory confirmation', 'required|numeric');
            $checkforvalidation = true;
        }
        if(!empty($data['laboratoryScreening'])){
            $this->form_validation->set_rules('orderingData[laboratoryScreening]', 'Laboratory Screening', 'required|numeric');
            $checkforvalidation = true;
        }
        if(!empty($data['laboratoryConfirmation'])){
            $this->form_validation->set_rules('orderingData[laboratoryConfirmation]', 'Laboratory Confirmation', 'required|numeric');
            $checkforvalidation = true;
        }
        if(!empty($data['RtwScrenning'])){
            $this->form_validation->set_rules('orderingData[RtwScrenning]', 'Return to work  screening', 'required|numeric');
            $checkforvalidation = true;
        }
        if(!empty($data['DCmobileScreenBasePrice']) || !empty($data['DCmobileScreenHr'])){
        $this->form_validation->set_rules('orderingData[DCmobileScreenBasePrice]', 'Base Price', 'required|numeric');
        $this->form_validation->set_rules('orderingData[DCmobileScreenHr]', 'Hours', 'required|numeric');
            $checkforvalidation = true;
        }
        if(!empty($data['travelType'])){
            $this->form_validation->set_rules('orderingData[travelType]', 'Travel Type', 'required');
            $checkforvalidation = true;
        }

         if(!empty($data['travelBasePrice']) || !empty($data['travelHr'])){
        $this->form_validation->set_rules('orderingData[travelBasePrice]', ' Travel Base Price', 'required|numeric');
        $this->form_validation->set_rules('orderingData[travelHr]', 'Travel Hours', 'required|numeric');
             $checkforvalidation = true;
         }
        if(!empty($data['cancellationFee'])){
            $this->form_validation->set_rules('orderingData[cancellationFee]', 'Cancellation Fee', 'required|numeric');
            $checkforvalidation = true;
        }

        $sosDataArr = $this->Webservices_Model->getsosformdatabysosid($sosid);
        $this->form_validation->set_message('required', '{field} is required.');
        if (($checkforvalidation) && ($this->form_validation->run() == FALSE)) {
            $data['sosid'] = $sosid;
            $data['sosData'] = $sosDataArr;
            $data['idsite'] = $idsite;
            $data['Drugtestid'] = $Drugtestid;
            $data['notification'] = $count;
            $data['commentnotification'] = $commentReplyNotiCount;
            $data['szMetaTagTitle'] = "Generate Proforma Invoice";
            $data['is_user_login'] = $is_user_login;
            $data['pageName'] = "Generate Proforma Invoice";
            $data['subpageName'] = "Sites_Record";
            $data['freanchId'] = $freanchId;
            $this->load->view('layout/admin_header', $data);
            $this->load->view('ordering/manualOrdering');
            $this->load->view('layout/admin_footer');
        } else {
            if ($this->Ordering_Model->insertCalulatedData($data)) {
                $szMessage['type'] = "success";
                $szMessage['content'] = "<strong>Proforma Invoice saved successfully.</strong> ";
                $this->session->set_userdata('drugsafe_user_message', $szMessage);

                $data['idsite'] = $idsite;
                $data['Drugtestid'] = $Drugtestid;
                $data['sosid'] = $sosid;
                $data['sosData'] = $sosDataArr;
                $data['notification'] = $count;
                $data['data'] = $data;
                $data['szMetaTagTitle'] = "Generate Proforma Invoice";
                $data['is_user_login'] = $is_user_login;
                $data['pageName'] = "Generate Proforma Invoice";
                $data['freanchId'] = $freanchId;
                $data['subpageName'] = "Sites_Record";
				$data['editform'] = "0";
                $this->load->view('layout/admin_header', $data);
                $this->load->view('ordering/manualCalcResult');
                $this->load->view('layout/admin_footer');


            }
        }
    }

    function sitesRecord()
    {
        $is_user_login = is_user_login($this);
        $count = $this->Admin_Model->getnotification();
        $commentReplyNotiCount = $this->Forum_Model->commentReplyNotifications();

        if (!$is_user_login) {
            redirect(base_url('/admin/admin_login'));
        }
        $id = 0;
        if ($_SESSION['drugsafe_user']['iRole'] == '2') {
            $id = $_SESSION['drugsafe_user']['id'];
        }
        if ($_SESSION['drugsafe_user']['iRole'] == '5') {
            $operationManagrrId = $_SESSION['drugsafe_user']['id'];
        }
        $searchAry = '';
        $idFreanch = $this->session->userdata('idFreanch');
        if ($idFreanch) {
            $_POST['szSearchClRecord2'] = $idFreanch;
            $this->session->unset_userdata('idFreanch');
        }
        if($id>0){
            $_POST['szSearchClRecord2'] = $id;
        }
        if (isset($_POST['szSearchClRecord2']) && !empty($_POST['szSearchClRecord2'])) {
            $id = $_POST['szSearchClRecord2'];
        }
        $this->session->set_userdata('freanchId', $id);
        if ($id > 0) {
            $childclientAray = $this->Ordering_Model->getAllChClientDetails($config['per_page'], $this->uri->segment(3), $id);
            $i = 0;
            $sosRormDetailsAry = array();
            foreach ($childclientAray as $childclientData) {
                $sosRormDetailsAry[$i] = $this->Form_Management_Model->getsosFormDetailsByClientId($childclientData['clientId']);
                $i++;
            }
            $sosRormDetailsAry = array_filter($sosRormDetailsAry);
        }
        $manualCalcDetails = $this->Ordering_Model->getManualCalculationBySosId($sosRormDetailsAry['id']);
       
        $data['childclientAray'] = $childclientAray;
        $data['sosRormDetailsAry'] = $sosRormDetailsAry;
        $data['pageName'] = "proforma_invoice";
        $data['subpageName'] = "view_proforma_invoice";
        $data['szMetaTagTitle'] = "Sites Record";
        $data['is_user_login'] = $is_user_login;
        $data['notification'] = $count;
        $data['commentnotification'] = $commentReplyNotiCount;
        $this->load->view('layout/admin_header', $data);
        $this->load->view('ordering/sitesRecord');
        $this->load->view('layout/admin_footer');
    }

    function editCalcForm()
    {
        $idsite = $this->input->post('idsite');
        $Drugtestid = $this->input->post('Drugtestid');
        $sosid = $this->input->post('sosid');
        $manualCalId = $this->input->post('manualCalId');

        $this->session->set_userdata('Drugtestid', $Drugtestid);
        $this->session->set_userdata('idsite', $idsite);
        $this->session->set_userdata('sosid', $sosid);
        $this->session->set_userdata('manualCalId', $manualCalId);
        echo "SUCCESS||||";
        echo "editcalform";
    }
    public function editcalform()
    {
        $count = $this->Admin_Model->getnotification();
        $commentReplyNotiCount = $this->Forum_Model->commentReplyNotifications();
        $is_user_login = is_user_login($this);
        // redirect to dashboard if already logged in
        if (!$is_user_login) {
            ob_end_clean();
            redirect(base_url('/admin/admin_login'));
            die;
        }
        $freanchId = $this->session->userdata('freanchId');
        $Drugtestid = $this->session->userdata('Drugtestid');
        $idsite = $this->session->userdata('idsite');
        $manualCalId = $this->session->userdata('manualCalId');
        $sosid = $this->session->userdata('sosid');
        $data_validate = $this->input->post('orderingData');
        if($data_validate){
            $checkforvalidation = false;
        }else{
            $checkforvalidation = true;
        }
      
        if (empty($data_validate)) {
            $manualCalcDataAry = $this->Ordering_Model->getManualCalculationBySosId($sosid);
            if(!empty($manualCalcDataAry)){
                $manualCalcDataAry['OtherDrugRRPValue'] = ($manualCalcDataAry['other_drug_rrp']>0.00?$manualCalcDataAry['other_drug_rrp']:0.00);
                $manualCalcDataAry['urineNata'] = ($manualCalcDataAry['urineNata']>0.00?$manualCalcDataAry['urineNata']:'');
                $manualCalcDataAry['nataLabCnfrm'] = ($manualCalcDataAry['nataLabCnfrm']>0.00?$manualCalcDataAry['nataLabCnfrm']:'');
                $manualCalcDataAry['oralFluidNata'] = ($manualCalcDataAry['oralFluidNata']>0.00?$manualCalcDataAry['oralFluidNata']:'');
                $manualCalcDataAry['SyntheticCannabinoids'] = ($manualCalcDataAry['SyntheticCannabinoids']>0.00?$manualCalcDataAry['SyntheticCannabinoids']:'');
                $manualCalcDataAry['labScrenning'] = ($manualCalcDataAry['labScrenning']>0.00?$manualCalcDataAry['labScrenning']:'');
                $manualCalcDataAry['RtwScrenning'] = ($manualCalcDataAry['RtwScrenning']>0.00?$manualCalcDataAry['RtwScrenning']:'');
                $manualCalcDataAry['mobileScreenBasePrice'] = ($manualCalcDataAry['mobileScreenBasePrice']>0.00?$manualCalcDataAry['mobileScreenBasePrice']:'');
                $manualCalcDataAry['travelBasePrice'] = ($manualCalcDataAry['travelBasePrice']>0.00?$manualCalcDataAry['travelBasePrice']:'');
                $manualCalcDataAry['fcobp'] = ($manualCalcDataAry['fcobp']>0.00?$manualCalcDataAry['fcobp']:'');
                $manualCalcDataAry['mcbp'] = ($manualCalcDataAry['mcbp']>0.00?$manualCalcDataAry['mcbp']:'');
                $manualCalcDataAry['cobp'] = ($manualCalcDataAry['cobp']>0.00?$manualCalcDataAry['cobp']:'');
                $manualCalcDataAry['labconf'] = ($manualCalcDataAry['labconf']>0.00?$manualCalcDataAry['labconf']:'');
                $manualCalcDataAry['cancelfee'] = ($manualCalcDataAry['cancelfee']>0.00?$manualCalcDataAry['cancelfee']:'');
                $manualCalcDataAry['mobileScreenHr'] = ($manualCalcDataAry['mobileScreenHr']>0?$manualCalcDataAry['mobileScreenHr']:'');
                $manualCalcDataAry['travelHr'] = ($manualCalcDataAry['travelHr']>0?$manualCalcDataAry['travelHr']:'');
                $manualCalcDataAry['travelType'] = ($manualCalcDataAry['travelType']>0?$manualCalcDataAry['travelType']:'');
                $manualCalcDataAry['fcohr'] = ($manualCalcDataAry['fcohr']>0?$manualCalcDataAry['fcohr']:'');
                $manualCalcDataAry['mchr'] = ($manualCalcDataAry['mchr']>0?$manualCalcDataAry['mchr']:'');
                $manualCalcDataAry['cohr'] = ($manualCalcDataAry['cohr']>0?$manualCalcDataAry['cohr']:'');
            }
        } else {
            $manualCalcDataAry = $data_validate;
        }
      
          $this->load->library('form_validation');
        if($data_validate['OtherDrugOpt'] == '1'){
            $this->form_validation->set_rules('orderingData[OtherDrugRRPValue]', 'RRP for '.$data_validate['OtherDrugName'], 'required|numeric');
            $checkforvalidation = true;
        }
          if(!empty($data_validate['fcobp']) || !empty($data_validate['fcohr'])){
        $this->form_validation->set_rules('orderingData[fcobp]', 'Base Price', 'required|numeric');
        $this->form_validation->set_rules('orderingData[fcohr]', 'Hours', 'required|greater_than[1]|numeric');
              $checkforvalidation = true;
          }
        if(!empty($data_validate['SyntheticCannabinoids'])){
            $this->form_validation->set_rules('orderingData[SyntheticCannabinoids]', 'Synthetic Cannabinoids Screening', 'required|numeric');
            $checkforvalidation = true;
        }
         if(!empty($data_validate['mcbp']) || !empty($data_validate['mchr'])){
        $this->form_validation->set_rules('orderingData[mcbp]', 'Base Price', 'required|numeric');
        $this->form_validation->set_rules('orderingData[mchr]', 'Hours', 'required|numeric');
             $checkforvalidation = true;
         }
          if(!empty($data_validate['cobp']) || !empty($data_validate['cohr'])){
        $this->form_validation->set_rules('orderingData[cobp]', 'Base Price', 'required|numeric');
        $this->form_validation->set_rules('orderingData[cohr]', 'Hours', 'required|greater_than[0]|numeric');
              $checkforvalidation = true;
         }
        if(!empty($data_validate['urineNata'])){
            $this->form_validation->set_rules('orderingData[urineNata]', 'Urine NATA Laboratory screening', 'required|numeric');
            $checkforvalidation = true;
        }
        if(!empty($data_validate['nataLabCnfrm'])){
            $this->form_validation->set_rules('orderingData[nataLabCnfrm]', 'NATA Laboratory confirmation', 'required|numeric');
            $checkforvalidation = true;
        }
        if(!empty($data_validate['oralFluidNata'])){
            $this->form_validation->set_rules('orderingData[oralFluidNata]', 'Oral Fluid NATA Laboratory confirmation', 'required|numeric');
            $checkforvalidation = true;
        }
        if(!empty($data_validate['labScrenning'])){
            $this->form_validation->set_rules('orderingData[labScrenning]', 'Laboratory Screening', 'required|numeric');
            $checkforvalidation = true;
        }
        if(!empty($data_validate['labconf'])){
            $this->form_validation->set_rules('orderingData[labconf]', 'Laboratory Confirmation', 'required|numeric');
            $checkforvalidation = true;
        }
        if(!empty($data_validate['RtwScrenning'])){
            $this->form_validation->set_rules('orderingData[RtwScrenning]', 'Return to work  screening', 'required|numeric');
            $checkforvalidation = true;
        }
        if(!empty($data_validate['mobileScreenBasePrice']) || !empty($data_validate['mobileScreenHr'])){
        $this->form_validation->set_rules('orderingData[mobileScreenBasePrice]', 'Base Price', 'required|numeric');
        $this->form_validation->set_rules('orderingData[mobileScreenHr]', 'Hours', 'required|numeric');
            $checkforvalidation = true;
        }
        if(!empty($data_validate['travelType'])){
            $this->form_validation->set_rules('orderingData[travelType]', 'Travel Type', 'required');
            $checkforvalidation = true;
        }

         if(!empty($data_validate['travelBasePrice']) || !empty($data_validate['travelHr'])){
        $this->form_validation->set_rules('orderingData[travelBasePrice]', ' Travel Base Price', 'required|numeric');
        $this->form_validation->set_rules('orderingData[travelHr]', 'Travel Hours', 'required|numeric');
             $checkforvalidation = true;
         }
        if(!empty($data_validate['cancelfee'])){
            $this->form_validation->set_rules('orderingData[cancelfee]', 'Cancellation Fee', 'required|numeric');
            $checkforvalidation = true;
        }
        $sosDataArr = $this->Webservices_Model->getsosformdatabysosid($sosid);
        $this->form_validation->set_message('required', '{field} is required.');
           if (($checkforvalidation) && ($this->form_validation->run() == FALSE)) {
        
          
            $_POST['orderingData'] = $manualCalcDataAry;
            $data['sosid'] = $sosid;
               $data['sosData'] = $sosDataArr;
            $data['idsite'] = $idsite;
            $data['Drugtestid'] = $Drugtestid;
            $data['notification'] = $count;
            $data['commentnotification'] = $commentReplyNotiCount;
            $data['freanchId'] = $freanchId;
            $data['szMetaTagTitle'] = "Ordering";
            $data['is_user_login'] = $is_user_login;
            $data['pageName'] = "Ordering";
            $data['subpageName'] = "Sites_Record";
            $this->load->view('layout/admin_header', $data);
            $this->load->view('ordering/editManualOrdering');
            $this->load->view('layout/admin_footer');
        } else {
            if ($this->Ordering_Model->updateCalulatedData($data_validate, $manualCalId)) {
                $szMessage['type'] = "success";
                $szMessage['content'] = "<strong>Proforma Invoice updated successfully.</strong> ";
                $this->session->set_userdata('drugsafe_user_message', $szMessage);

                $data['sosData'] = $sosDataArr;
                $data['idsite'] = $idsite;
                $data['Drugtestid'] = $Drugtestid;
                $data['sosid'] = $sosid;
                $data['notification'] = $count;
                $data['data'] = $data_validate;
                $data['szMetaTagTitle'] = "Ordering";
                $data['is_user_login'] = $is_user_login;
                $data['freanchId'] = $freanchId;
                $data['pageName'] = "Ordering";
                $data['subpageName'] = "Sites_Record";
				$data['editform'] = "1";
                $this->load->view('layout/admin_header', $data);
                $this->load->view('ordering/manualCalcResult');
                $this->load->view('layout/admin_footer');


            }
        }
    }
    function viewCalc()
    {
        $idsite = $this->input->post('idsite');
        $Drugtestid = $this->input->post('Drugtestid');
        $sosid = $this->input->post('sosid');
        $this->session->set_userdata('Drugtestid', $Drugtestid);
        $this->session->set_userdata('idsite', $idsite);
        $this->session->set_userdata('sosid', $sosid);
        echo "SUCCESS||||";
        echo "viewCalcDetails";
    }
    function viewCalcDetails()
    {
        $is_user_login = is_user_login($this);
        $count = $this->Admin_Model->getnotification();
        $commentReplyNotiCount = $this->Forum_Model->commentReplyNotifications();
        $freanchId = $this->session->userdata('freanchId');
        $Drugtestid = $this->session->userdata('Drugtestid');
        $idsite = $this->session->userdata('idsite');
        $sosid = $this->session->userdata('sosid');
        $data = $this->Ordering_Model->getManualCalculationBySosId($sosid);
        $sosDataArr = $this->Webservices_Model->getsosformdatabysosid($sosid);
        $data['idsite'] = $idsite;
        $data['Drugtestid'] = $Drugtestid;
        $data['sosid'] = $sosid;
        $data['sosData'] = $sosDataArr;
        $data['notification'] = $count;
        $data['commentnotification'] = $commentReplyNotiCount;
        $data['data'] = $data;
        $data['freanchId'] = $freanchId;
        $data['szMetaTagTitle'] = "Proforma Invoice Calculations";
        $data['is_user_login'] = $is_user_login;
        $data['pageName'] = "Proforma Invoice Calculations";
        $data['subpageName'] = "Sites_Record";
        $this->load->view('layout/admin_header', $data);
        $this->load->view('ordering/viewCalcDetails');
        $this->load->view('layout/admin_footer');

    }

    function calcDetailspdf()
    {
        $idsite = $this->input->post('idsite');
        $Drugtestid = $this->input->post('Drugtestid');
        $sosid = $this->input->post('sosid');
        $this->session->set_userdata('idsite', $idsite);
        $this->session->set_userdata('Drugtestid', $Drugtestid);
        $this->session->set_userdata('sosid', $sosid);
        echo "SUCCESS||||";
        echo "pdfcalculationdetails";
    }

    public function pdfcalculationdetails()
    {
        ob_start();
        $this->load->library('Pdf');
        $pdf = new Pdf('L', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetTitle('Drug-safe Proforma Invoice report');
        $pdf->SetAuthor('Drug-safe');
        $pdf->SetSubject('Proforma Invoice Report PDF');
        $pdf->SetMargins(PDF_MARGIN_LEFT - 10, PDF_MARGIN_TOP - 18, PDF_MARGIN_RIGHT - 10);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->SetDisplayMode('real', 'default');
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetFont('times', '', 12);

        $pdf->AddPage('L');

        $Drugtestid = $this->session->userdata('Drugtestid');
        $idsite = $this->session->userdata('idsite');
        $sosid = $this->session->userdata('sosid');
        $FrenchiseeDataArr = $this->Webservices_Model->getuserhierarchybysiteid($idsite);
        $getState = $this->Franchisee_Model->getStateByFranchiseeId($FrenchiseeDataArr[0]['franchiseeId']);
        $siteDataArr = $this->Webservices_Model->getuserdetails($idsite);
        $clientDataArr = $this->Webservices_Model->getuserdetails($FrenchiseeDataArr[0]['clientType']);
        $data = $this->Ordering_Model->getManualCalculationBySosId($sosid);
        $DrugtestidArr = array_map('intval', str_split($Drugtestid));
        $testDate = $this->Webservices_Model->getsosformdatabysosid($sosid);
        $countDoner = count($this->Form_Management_Model->getDonarDetailBySosId($sosid));
        $ValTotal = 0;
        if (in_array(1, $DrugtestidArr)) {
            $ValTotal = number_format($ValTotal + $countDoner * __RRP_1__, 2, '.', '');
        }
        if (in_array(2, $DrugtestidArr)) {
            $ValTotal = number_format($ValTotal + $countDoner * __RRP_2__, 2, '.', '');
        }
        if (in_array(3, $DrugtestidArr)) {
            $ValTotal = number_format($ValTotal + $countDoner * __RRP_3__, 2, '.', '');
        }
        if (in_array(4, $DrugtestidArr)) {
            $ValTotal = number_format($ValTotal + $countDoner * __RRP_4__, 2, '.', '');
        }
        $otherRRPVal = 0;
        if(in_array(5, $DrugtestidArr)) {
            $otherRRPVal = $countDoner * $data['other_drug_rrp'];
        }
        //$Royaltyfees = $ValTotal * 0.1;
        //$Royaltyfees = number_format($Royaltyfees, 2, '.', '');
        $GST = $ValTotal * 0.1;
        $GST = number_format($GST, 2, '.', '');
        $TotalbeforeRoyalty = $ValTotal + $GST;
        $TotalbeforeRoyalty = number_format($TotalbeforeRoyalty, 2, '.', '');
        //$TotalafterRoyalty = $ValTotal - $Royaltyfees + $GST;
        //$TotalafterRoyalty = number_format($TotalafterRoyalty, 2, '.', '');
        //$NetTotal = $ValTotal - $Royaltyfees;
        //$NetTotal = number_format($NetTotal, 2, '.', '');

        $DcmobileScreen = $data['mobileScreenBasePrice'] * ($data['mobileScreenHr']>1?$data['mobileScreenHr']:1);
        $mobileScreen = $data['mcbp'] * ($data['mchr']>1?$data['mchr']:1);
        $calloutprice = $data['cobp'] * ($data['cohr']>3?$data['cohr']:3);
        $fcoprice = $data['fcobp'] * ($data['fcohr']>2?$data['fcohr']:2);
        $travel = $data['travelBasePrice'] * ($data['travelHr']>1?$data['travelHr']:1);

        $TotalTrevenu = $otherRRPVal + $data['urineNata'] + $data['labconf']+$data['cancelfee']+ $data['nataLabCnfrm'] + $data['oralFluidNata'] + $data['SyntheticCannabinoids'] + $data['labScrenning'] + $data['RtwScrenning'] + $mobileScreen + $DcmobileScreen+ $travel + $calloutprice + $fcoprice;

        $TotalTrevenu = number_format($TotalTrevenu, 2, '.', '');
        //$RoyaltyfeesManual = ($TotalTrevenu * 0.1);
        //$RoyaltyfeesManual = number_format($RoyaltyfeesManual, 2, '.', '');
        $GSTmanual = ($TotalTrevenu * 0.1);
        $GSTmanual = number_format($GSTmanual, 2, '.', '');
        $Total1 = $TotalTrevenu + $GSTmanual;
        $Total1 = number_format($Total1, 2, '.', '');
        //$Total2 = $TotalTrevenu - $RoyaltyfeesManual + $GSTmanual;
        //$Total2 = number_format($Total2, 2, '.', '');
        //$totalRoyalty = $Royaltyfees + $RoyaltyfeesManual;

        $totalinvoiceAmt = $ValTotal + $TotalTrevenu;

        $discount = $this->Ordering_Model->getClientDiscountByClientId($FrenchiseeDataArr[0]['clientType']);
        if(!empty($discount)){
            $discountpercent = $discount['percentage'];
        }else{
            $discountpercent = 0;
        }
        if($discountpercent>0){
            $totaldiscount = $totalinvoiceAmt*$discountpercent*0.01;
            $totalafterdiscount = $totalinvoiceAmt-$totaldiscount;
            $totalGst = $totalafterdiscount*0.1;
            $totalRoyaltyBefore = $totalGst + $totalafterdiscount;
        }else{
            $totalGst = $GST + $GSTmanual;
            $totalRoyaltyBefore = $Total1 + $TotalbeforeRoyalty;
            $totaldiscount = 0;
            $totalafterdiscount = 0;
        }
       $val =  sprintf(__FORMAT_NUMBER__, $data['id']);
        $SFArr = explode(',',$testDate[0]['screening_facilities']);
        $InHouse = false;
        $onClinic = false;
        if(!empty($SFArr)){
            if($SFArr[0] == '1'){
                $InHouse = true;
            }elseif($SFArr[0] == '2'){
                $onClinic = true;
            }
            if($SFArr[1] == '1'){
                $InHouse = true;
            }elseif($SFArr[1] == '2'){
                $onClinic = true;
            }
        }
        //$totalRoyaltyAfter = $Total2 + $TotalafterRoyalty;
        $html = '<div class="wraper">
        <table cellpadding="5px">
       
    <tr>
        <td rowspan="4" align="left"><a style="text-align:left;  margin-bottom:15px;" href="' . __BASE_URL__ . '" ><img style="width:145px" src="' . __BASE_URL__ . '/images/logo.png" alt="logo" class="logo-default" /> </a></td>
        <td align="right"><b>Address:</b> '.$FrenchiseeDataArr[0]['szAddress'].', '.$FrenchiseeDataArr[0]['szZipCode'].', '.$getState['name'].', '.$FrenchiseeDataArr[0]['szCountry'].'</td>
    </tr>
    <tr>
        <td align="right"><b>Phone:</b> '.$FrenchiseeDataArr[0]['szContactNumber'].'</td>
    </tr>
    <tr>
        <td align="right"><b>Email:</b> '.$FrenchiseeDataArr[0]['szEmail'].'</td>
    </tr>
    <tr>
        <td align="right"><b>ABN:</b> '.$FrenchiseeDataArr[0]['abn'].'</td>
    </tr>
</table>
<br />
<h1 style="text-align: center;">Proforma Invoice</h1>

<table cellpadding="5px">
    <tr>
        <td width="50%" align="left" font-size="20"><b>Proforma Invoice#:</b> #'.$val.'</td><td width="50%" align="right"><b>Proforma Invoice Date:</b> '.date('d/m/Y',strtotime($data['dtCreatedOn'])).'</td>
    </tr>
    <tr>
        <td width="50%" align="left" font-size="20"><b>Business Name:</b> '.$clientDataArr[0]['szName'].'</td><td width="50%" align="right"><b>Company Name:</b> '.$siteDataArr[0]['szName'].'</td>
    </tr>
    <tr>
        <td width="50%" align="left"><b>Business Address:</b> '.$clientDataArr[0]['szAddress'].', '.$clientDataArr[0]['szZipCode'].', '.$getState['name'].', '.$clientDataArr[0]['szCountry'].'</td><td width="50%" align="right"><b>Company Address:</b> '.$siteDataArr[0]['szAddress'].', '.$siteDataArr[0]['szZipCode'].', '.$getState['name'].', '.$siteDataArr[0]['szCountry'].'</td>
    </tr>
    <tr>
        <td width="50%" align="left"><b>ABN:</b> '.$clientDataArr[0]['abn'].'</td><td width="50%" align="right"><b>Test Date:</b> '.date('d/m/Y',strtotime($testDate[0]['testdate'])).'</td>
    </tr>
    <tr>
        <td width="50%" align="left"><b>Screening Facilities:</b> '.($InHouse?'In House':'').($InHouse && $onClinic?' and ':'').($onClinic?'Mobile Clinic':'').'</td><td width="50%" align="right"><b>No of Donors Tested:</b> '.$countDoner.'</td>
    </tr>
</table>
<h3 style="color:black">System Calculated Result</h3>
<table border="1px" cellpadding="5px">
    <tr>
        <td width="80%" align="left"><b>Total (Excluding GST):</b></td><td width="20%" align="right">$'.number_format($ValTotal,2,'.',',').'</td>
    </tr>
    <tr>
        <td width="80%" align="left"><b>GST (10%):</b></td><td width="20%" align="right">$'.number_format($GST, 2, '.', ',').'</td>
    </tr>
    <tr>
        <td width="80%" align="left"><b>Total (Including GST):</b></td><td width="20%" align="right">$'.number_format($TotalbeforeRoyalty, 2, '.', ',').'</td>
    </tr>
</table>
<h3 style="color:black">Other Revenue Stream Calculation Result</h3>
<table border="1px" cellpadding="5px">
    <tr>
        <td width="80%" align="left"><b>Total (Excluding GST):</b></td><td width="20%" align="right">$'.number_format($TotalTrevenu,2,'.',',').'</td>
    </tr>
    <tr>
        <td width="80%" align="left"><b>GST (10%):</b></td><td width="20%" align="right">$'.number_format($GSTmanual, 2, '.', ',').'</td>
    </tr>
    <tr>
        <td width="80%" align="left"><b>Total (Including GST):</b></td><td width="20%" align="right">$'.number_format($Total1, 2, '.', ',').'</td>
    </tr>
</table>
<br />
<h3 style="color:black">Proforma Invoice Totals</h3>
<br />
<table border="1px" cellpadding="5px">
    <tr>
        <td width="80%" align="left"><b>Total (Excluding GST):</b></td><td width="20%" align="right">$'.number_format($totalinvoiceAmt, 2, '.', ',').'</td>
    </tr>
    <tr>
        <td width="80%" align="left"><b>Discount '.($discountpercent>0?'('.$discountpercent.'%)':'').':</b></td><td width="20%" align="right">'.($discountpercent>0?'$'.number_format($totaldiscount, 2, '.', ','):'-').'</td>
    </tr>
    <tr>
        <td width="80%" align="left"><b>Total After Discount (Excluding GST):</b></td><td width="20%" align="right">'.($discountpercent>0?'$'.number_format($totalafterdiscount, 2, '.', ','):'-').'</td>
    </tr>
    <tr>
        <td width="80%" align="left"><b>GST (10%):</b></td><td width="20%" align="right">$'.number_format($totalGst, 2, '.', ',').'</td>
    </tr>
    <tr>
        <td width="80%" align="left"><b>Total (Including GST):</b></td><td width="20%" align="right">$'.number_format($totalRoyaltyBefore, 2, '.', ',').'</td>
    </tr>
</table>
        </div>';
        $pdf->writeHTML($html, true, false, true, false, '');

        error_reporting(E_ALL);/*
        $this->session->unset_userdata('idsite');
        $this->session->unset_userdata('Drugtestid');
        $this->session->unset_userdata('sosid');*/
        ob_end_clean();
        $pdf->Output('view_calculation_details.pdf', 'I');
    }

    function siteRecordpage()
    {
        $freanchId = $this->input->post('freanchId');
        $this->session->set_userdata('idFreanch', $freanchId);
        echo "SUCCESS||||";
        echo "sitesRecord";
    }
    function discountPercentage()
    {
        $is_user_login = is_user_login($this);
        if(!$is_user_login)
        {
            ob_end_clean();
            redirect(base_url('/admin/admin_login'));
            die;
        }
        $getAllDiscountAry=$this->Ordering_Model->getAllDiscounPercentage();
        $data['szMetaTagTitle'] = "Discount Percentage List";
        $data['is_user_login'] = $is_user_login;
        $data['pageName'] = "proforma_invoice";
        $data['subpageName'] = "discount_percentage";
        $data['getAllDiscountAry']=$getAllDiscountAry;
        $this->load->view('layout/admin_header',$data);
        $this->load->view('ordering/discountList');
        $this->load->view('layout/admin_footer');
    }
    function createDiscount()
    {
        $is_user_login = is_user_login($this);
        if(!$is_user_login)
        {
            ob_end_clean();
            redirect(base_url('/admin/admin_login'));
            die;
            }
            $data = $this->input->post('createDiscount');
            $this->load->library('form_validation');
            $this->form_validation->set_rules('createDiscount[percentage]', 'Discount Percentage', 'required|is_numeric|maximumCheck');
            $this->form_validation->set_rules('createDiscount[description]', 'Description', 'required');
            $this->form_validation->set_message('maximumCheck', ' %s field must be less than 100.');
            $this->form_validation->set_message('required', '{field} is required.');
            
            if ($this->form_validation->run() == FALSE)
            { 
                $data['szMetaTagTitle'] = "Create Discount";
                $data['is_user_login'] = $is_user_login;
                $data['pageName'] = "proforma_invoice";
                $data['subpageName'] = "discount_percentage";
                $this->load->view('layout/admin_header',$data);
                $this->load->view('ordering/createDiscount');
                $this->load->view('layout/admin_footer');
            }
            else
            {
                if($this->Ordering_Model->insertDiscount($data))
                {
		    redirect(base_url('ordering/discountPercentage/'));
                    die;
                }
            }
        }
        function editDiscountDetails()
        {
            $idDiscount = $this->input->post('idDiscount');
           
            if($idDiscount>0)
            {
                $this->session->set_userdata('idDiscount',$idDiscount);
                echo "SUCCESS||||";
                echo "editDiscount";
            }
            
        }
        
        public function editDiscount()
        {
          $is_user_login = is_user_login($this);
            // redirect to dashboard if already logged in
            if(!$is_user_login)
            {
                ob_end_clean();
               redirect(base_url('/admin/admin_login'));
                die;
            }
            $data_validate = $this->input->post('editDiscount');
            $idDiscount = $this->session->userdata('idDiscount');
            if(empty($data_validate))
            {
                 $getDiscountData = $this->Ordering_Model->getDiscountById($idDiscount);
            }
            else
            {
                $getDiscountData = $data_validate;
            }
            $this->load->library('form_validation');
            $this->form_validation->set_rules('editDiscount[percentage]', 'Discount Percentage', 'required|is_numeric|maximumCheck');
            $this->form_validation->set_rules('editDiscount[description]', 'Description', 'required');
            $this->form_validation->set_message('maximumCheck', ' %s field must be less than 100.');
             $this->form_validation->set_message('required', '{field} is required.');
             if ($this->form_validation->run() == FALSE)
            { 
                $data['szMetaTagTitle'] = "Edit Discount";
                $data['is_user_login'] = $is_user_login;
                $data['pageName'] = "proforma_invoice";
                $data['subpageName'] = "discount_percentage";
	        $_POST['editDiscount']=$getDiscountData;
                $this->load->view('layout/admin_header',$data);
                $this->load->view('ordering/editDiscount');
                $this->load->view('layout/admin_footer');
            }
            else
            {
                if($this->Ordering_Model->updateDiscount($data_validate,$idDiscount))
                {
		    redirect(base_url('ordering/discountPercentage/'));
                    die;
                }
            }
         }
        public function discountDeleteeAlert()
        {
            $data['mode'] = '__DELETE_DISCOUNT_POPUP__';
            $data['idDiscount'] = $this->input->post('idDiscount');
            $this->load->view('admin/admin_ajax_functions',$data);
        }
        public function deletediscountConfirmation()
        {
            $data['mode'] = '___DELETE_DISCOUNT_CONFIRM__';
            $data['idDiscount'] = $this->input->post('idDiscount');
            $this->Ordering_Model->deleteDiscount($data['idDiscount']);
            $this->load->view('admin/admin_ajax_functions',$data);
        }
      function discountViewData()
        {
            $idDiscount = $this->input->post('idDiscount');
           
            if($idDiscount>0)
            {
                $this->session->set_userdata('idDiscount',$idDiscount);
                echo "SUCCESS||||";
                echo "discount_view";
            }
            
        }
        
        public function discount_view()
        {
          $is_user_login = is_user_login($this);
            // redirect to dashboard if already logged in
            if(!$is_user_login)
            {
                ob_end_clean();
               redirect(base_url('/admin/admin_login'));
                die;
            }
           
            $idDiscount = $this->session->userdata('idDiscount');
            $getAllDiscountAry=$this->Ordering_Model->getDiscountById($idDiscount);
                    $data['szMetaTagTitle'] = "View Discount";
                    $data['is_user_login'] = $is_user_login;
                    $data['getAllDiscountAry'] = $getAllDiscountAry;
                    $data['pageName'] = "proforma_invoice";
                    $data['subpageName'] = "discount_percentage";
                  
                
                $this->load->view('layout/admin_header',$data);
                $this->load->view('ordering/viewDiscount');
                $this->load->view('layout/admin_footer');
          
         }
  function viewTaxIncoiceData()
    {
        $idsite = $this->input->post('idsite');
        $Drugtestid = $this->input->post('Drugtestid');
        $sosid = $this->input->post('sosid');
        $this->session->set_userdata('Drugtestid', $Drugtestid);
        $this->session->set_userdata('idsite', $idsite);
        $this->session->set_userdata('sosid', $sosid);
        echo "SUCCESS||||";
        echo "viewTaxIncoice";
    }

    public function viewTaxIncoice()
    {
       
        $is_user_login = is_user_login($this);
        // redirect to dashboard if already logged in
        if (!$is_user_login) {
            ob_end_clean();
            redirect(base_url('/admin/admin_login'));
            die;
        }
        $count = $this->Admin_Model->getnotification();
        $commentReplyNotiCount = $this->Forum_Model->commentReplyNotifications();
        $freanchId = $this->session->userdata('freanchId');
        $Drugtestid = $this->session->userdata('Drugtestid');
        $idsite = $this->session->userdata('idsite');
        $sosid = $this->session->userdata('sosid');
        $data = $this->Ordering_Model->getManualCalculationBySosId($sosid);
        $sosDataArr = $this->Webservices_Model->getsosformdatabysosid($sosid);
        $data['idsite'] = $idsite;
        $data['Drugtestid'] = $Drugtestid;
        $data['sosid'] = $sosid;
        $data['sosData'] = $sosDataArr;
        $data['notification'] = $count;
        $data['commentnotification'] = $commentReplyNotiCount;
        $data['data'] = $data;
        $data['freanchId'] = $freanchId;
        $data['szMetaTagTitle'] = "Generate Tax Invoice";
        $data['is_user_login'] = $is_user_login;
        $data['pageName'] = "Generate Proforma Invoice";
        $data['subpageName'] = "Sites_Record";
        $data['data'] = $data;
        $this->load->view('layout/admin_header', $data);
        $this->load->view('ordering/tax_invoice');
        $this->load->view('layout/admin_footer');

    }
      function taxInvoicepdfData()
    {
        $idsite = $this->input->post('idsite');
        $Drugtestid = $this->input->post('Drugtestid');
        $sosid = $this->input->post('sosid');
        $this->session->set_userdata('Drugtestid', $Drugtestid);
        $this->session->set_userdata('idsite', $idsite);
        $this->session->set_userdata('sosid', $sosid);
        echo "SUCCESS||||";
        echo "taxInvoicepdf";
    }

    public function taxInvoicepdf()
    {
        ob_start();
        $this->load->library('Pdf');
        $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetTitle('Drug-safe Tax Invoice report');
        $pdf->SetAuthor('Drug-safe');
        $pdf->SetSubject('Tax Invoice Report PDF');
        $pdf->SetMargins(PDF_MARGIN_LEFT - 10, PDF_MARGIN_TOP - 18, PDF_MARGIN_RIGHT - 10);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->SetDisplayMode('real', 'default');
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetFont('times', '', 10);

        $pdf->AddPage('P');
        $freanchId = $this->session->userdata('freanchId');
        $Drugtestid = $this->session->userdata('Drugtestid');
        $idsite = $this->session->userdata('idsite');
        $sosid = $this->session->userdata('sosid');
        $FrenchiseeDataArr = $this->Webservices_Model->getuserhierarchybysiteid($idsite);
        $clientdetsArr = $this->Webservices_Model->getuserhierarchybysiteid($FrenchiseeDataArr[0]['clientType']);
        $getState = $this->Franchisee_Model->getStateByFranchiseeId($FrenchiseeDataArr[0]['franchiseeId']);
        $siteDataArr = $this->Webservices_Model->getuserdetails($idsite);
        $clientDataArr = $this->Webservices_Model->getuserdetails($FrenchiseeDataArr[0]['clientType']);
        $data = $this->Ordering_Model->getManualCalculationBySosId($sosid);
        $DrugtestidArr = array_map('intval', str_split($Drugtestid));
        $testDate = $this->Webservices_Model->getsosformdatabysosid($sosid);
        $countDoner = count($this->Form_Management_Model->getDonarDetailBySosId($sosid));
        $val =  sprintf(__FORMAT_NUMBER__, $data['id']);

        $ValTotal = 0;
        if (in_array(1, $DrugtestidArr)) {
            $ValTotal = number_format($ValTotal + $countDoner * __RRP_1__, 2, '.', '');
        }
        if (in_array(2, $DrugtestidArr)) {
            $ValTotal = number_format($ValTotal + $countDoner * __RRP_2__, 2, '.', '');
        }
        if (in_array(3, $DrugtestidArr)) {
            $ValTotal = number_format($ValTotal + $countDoner * __RRP_3__, 2, '.', '');
        }
        if (in_array(4, $DrugtestidArr)) {
            $ValTotal = number_format($ValTotal + $countDoner * __RRP_4__, 2, '.', '');
        }

        $html = '<div class="wraper">
        <table cellpadding="5px">
       
    <tr>
        <td rowspan="4" align="left"><a style="text-align:left;  margin-bottom:15px;" href="' . __BASE_URL__ . '" ><img style="width:145px" src="' . __BASE_URL__ . '/images/logo.png" alt="logo" class="logo-default" /> </a></td><td align="right"><b>Address:</b> '.$FrenchiseeDataArr[0]['szAddress'].', '.$FrenchiseeDataArr[0]['szZipCode'].', '.$getState['name'].', '.$FrenchiseeDataArr[0]['szCountry'].' </td>
    </tr>
    <tr>
        <td align="right"><b>Phone:</b> '.$FrenchiseeDataArr[0]['szContactNumber'].'</td>
    </tr>
    <tr>
        <td align="right"><b>Email:</b> '.$FrenchiseeDataArr[0]['szEmail'].'  </td>
    </tr>
    <tr>
        <td align="right"><b>ABN:</b> '.$FrenchiseeDataArr[0]['abn'].'</td>
    </tr>
</table>
<br />
<h1 style="text-align: center;">Tax Invoice</h1>

<table cellpadding="5">
    <tr>
        <td width="50%" align="left" font-size="20"><b>Invoice #:</b> '.$val.'</td><td width="50%" align="right"><b>Invoice Date:</b>'.date('d/m/Y',strtotime($data['dtCreatedOn'])).'</td>
    </tr>
    <tr>
        <td width="50%" align="left" font-size="20"><b>Contact Name:</b> '.$clientDataArr[0]['szName'].'</td><td width="50%" align="right"><b>Company Name:</b> '.$siteDataArr[0]['szName'].'</td>
    </tr>
    <tr>
        <td width="50%" align="left" font-size="20"><b>Business Name:</b> '.$clientdetsArr[0]['szBusinessName'].'</td><td width="50%" align="right"><b>Company Address:</b> '.$siteDataArr[0]['szAddress'].', '.$siteDataArr[0]['szZipCode'].', '.$getState['name'].', '.$siteDataArr[0]['szCountry'].'</td>
    </tr>
    <tr>
        <td width="50%" align="left"><b>Business Address:</b> '.$clientDataArr[0]['szAddress'].', '.$clientDataArr[0]['szZipCode'].', '.$getState['name'].', '.$clientDataArr[0]['szCountry'].'</td><td width="50%" align="right"><b>Test Date:</b> '.date('d/m/Y',strtotime($testDate[0]['testdate'])).'</td>
    </tr>
    <tr>
        <td width="50%" align="left"><b>ABN:</b>'.$clientDataArr[0]['abn'].'</td><td width="50%" align="right"><b>No of Donors Tested:</b> '.$countDoner.'</td>
    </tr>
    
</table>
<h3 style="color:red">Services Provided</h3>
                            <table border="1" cellpadding="5">
                                    <tr>
                                        <th><b>System Calculation</b> </th>
                                        <th> <b>No of Donors</b> </th>
                                        <th> <b>RRP</b> </th>
                                        <th> <b>$ Value </b> </th>
                                   
                                    </tr>';
        if(in_array(1, $DrugtestidArr)) {
            $Val1=$countDoner*__RRP_1__;
            $html .= '<tr>
                                            <td>Alcohol</td>
                                            <td>'.$countDoner.'</td>
                                            <td>$'.number_format(__RRP_1__,2,'.',',').'</td>
                                            <td>$'.number_format($Val1,2,'.',',').'</td>
                                       </tr>';
        }
        if(in_array(2, $DrugtestidArr)) {
            $Val2=$countDoner*__RRP_2__;
            $html .= '<tr>
                                            <td>Oral Fluid</td>
                                            <td>'.$countDoner.'</td>
                                            <td>$'.number_format(__RRP_2__,2,'.',',').'</td>
                                            <td>$'.number_format($Val2,2,'.',',').'</td>
                                       </tr>';
        }
        if(in_array(3, $DrugtestidArr)) {
            $Val3=$countDoner*__RRP_3__;
            $html .= '<tr>
                                            <td>URINE</td>
                                            <td>'.$countDoner.'</td>
                                            <td>$'.number_format(__RRP_3__,2,'.',',').'</td>
                                            <td>$'.number_format($Val3,2,'.',',').'</td>
                                       </tr>';
        }
        if(in_array(4, $DrugtestidArr)) {
            $Val4=$countDoner*__RRP_4__;
            $html .= '<tr>
                                            <td>AS/NZA 4308:2008</td>
                                            <td>'.$countDoner.'</td>
                                            <td>$'.number_format(__RRP_4__,2,'.',',').'</td>
                                            <td>$'.number_format($Val4,2,'.',',').'</td>
                                       </tr>';
        }
            $html .='</table><br /><br />';
        $otherRRPVal = 0;
        if(in_array(5, $DrugtestidArr)) {
            $otherRRPVal=$countDoner*$data['other_drug_rrp'];
            $html .= '<table border="1" cellpadding="5">
                                    <tr>
                                        <th><b>Manual Calculation</b> </th>
                                        <th> <b>No of Donors</b> </th>
                                        <th> <b>RRP</b> </th>
                                        <th> <b>$ Value </b> </th>
                                   
                                    </tr><tr>
                                            <td>'.$testDate[0]['other_drug_test'].'</td>
                                            <td>'.$countDoner.'</td>
                                            <td>$'.number_format($data['other_drug_rrp'],2,'.',',').'</td>
                                            <td>$'.number_format($otherRRPVal,2,'.',',').'</td>
                                       </tr>
                                       </table><br /><br />';
        }

        $DcmobileScreen = number_format($data['mobileScreenBasePrice'], 2, '.', '') * ($data['mobileScreenHr']>1?$data['mobileScreenHr']:1);
        $mobileScreen = number_format($data['mcbp'], 2, '.', '') * ($data['mchr']>1?$data['mchr']:1);
        $calloutprice = number_format($data['cobp'], 2, '.', '') * ($data['cohr']>3?$data['cohr']:3);
        $fcoprice = number_format($data['fcobp'], 2, '.', '') * ($data['fcohr']>2?$data['fcohr']:2);
        $travel = number_format($data['travelBasePrice'], 2, '.', '') * ($data['travelHr']>1?$data['travelHr']:1);
        $TotalTrevenu = $otherRRPVal + $data['urineNata'] + $data['labconf']+$data['cancelfee']+ $data['nataLabCnfrm'] + $data['oralFluidNata'] + $data['SyntheticCannabinoids'] + $data['labScrenning'] + $data['RtwScrenning'] + $mobileScreen + $DcmobileScreen+ $travel + $calloutprice + $fcoprice;
        $TotalTrevenu = number_format($TotalTrevenu, 2, '.', '');
                            $html .='<table border="1" cellpadding="5">
                                    <tr>
                                        <th></th>
                                         <th> <b>Base Price </b> </th>
                                        <th> <b>No of Hours</b> </th>
                                        <th> <b>$ Value </b> </th>
                                   
                                    </tr>';
                                       $html .='<tr>
                                            <td>Single Field Collection Officer (FCO)</td>
                                            <td>$'.(!empty($data['fcobp'])?number_format($data['fcobp'], 2, '.', ','):'').'</td>
                                            <td>'.(!empty($data['fcohr'])?($data['fcohr']>2?$data['fcohr']:2):'').'</td>
                                            <td> $'.number_format($fcoprice, 2, '.', ',').' </td>
                                        </tr>
                                         <tr>
                                            <td>Mobile Clinic</td>
                                            <td>$'.(!empty($data['mcbp'])?number_format($data['mcbp'], 2, '.', ','):'').'</td>
                                            <td>'.(!empty($data['mchr'])?($data['mchr']>1?$data['mchr']:1):'').'</td>
                                            <td> $'.number_format($mobileScreen, 2, '.', ',').' </td>
                                      
                                            
                                        </tr>
                                         <tr>
                                            <td>Call Out (including an alcohol & drug screen)</td>
                                            <td>$'.(!empty($data['cobp'])?number_format($data['cobp'], 2, '.', ','):'').'</td>
                                            <td>'.(!empty($data['cohr'])?($data['cohr']>3?$data['cohr']:3):'').'</td>
                                            <td> $'.number_format($calloutprice, 2, '.', ',').' </td>
                                        </tr>
                                         <tr>
                                            <td>Drug-Safe Communities mobile clinic screening</td>
                                            <td>$'.(!empty($data['mobileScreenBasePrice'])?number_format($data['mobileScreenBasePrice'], 2, '.', ','):'').'</td>
                                            <td>'.(!empty($data['mobileScreenHr'])?($data['mobileScreenHr']>1?$data['mobileScreenHr']:1):'').'</td>
                                            <td> $'.number_format($DcmobileScreen, 2, '.', ',').' </td>
                                        </tr>
                                         <tr>
                                            <td>Travel'.($data['travelType'] == 1?'– When > 100 km return trip from DSC base.':($data['travelType'] == 2?'– When > 100 km return trip from MC base. Includes tester.':'')).'</td>
                                            <td>$'.(!empty($data['travelBasePrice'])?number_format($data['travelBasePrice'], 2, '.', ','):'').'</td>
                                            <td>'.(!empty($data['travelHr'])?($data['travelHr']>1?$data['travelHr']:1):'').'</td>
                                            <td> $'.number_format($travel, 2, '.', ',').' </td>
                                        </tr>
                                         <tr>
                                              <td colspan="3">Synthetic Cannabinoids screening</td>
                                            
                                            <td> $'.number_format($data['SyntheticCannabinoids'], 2, '.', ',').' </td>
                                      
                                            
                                        </tr>
                                         <tr>
                                              <td colspan="3">Urine NATA Laboratory screening</td>   
                                            <td> $'.number_format($data['urineNata'], 2, '.', ',').' </td>
                                      
                                            
                                        </tr>
                                         <tr>
                                             <td colspan="3">NATA Laboratory confirmation</td>
                                          
                                            <td> $'.number_format($data['nataLabCnfrm'], 2, '.', ',').' </td>
                                      
                                            
                                        </tr>
                                         <tr>
                                             <td colspan="3">Oral Fluid NATA Laboratory confirmation</td>
                                         
                                            <td> $'.number_format($data['oralFluidNata'], 2, '.', ',').' </td>
                                      
                                            
                                        </tr>
                                         <tr>
                                             <td colspan="3">Synthetic Cannabinoids or Designer Drugs, per sample. - Laboratory screening</td>
                                         
                                            <td> $'.number_format($data['labScrenning'], 2, '.', ',').' </td>
                                      
                                            
                                        </tr>
                                         <tr>
                                             <td colspan="3">Synthetic Cannabinoids or Designer Drugs, per sample. - Laboratory confirmation</td>
                                         
                                            <td> $'.number_format($data['labconf'], 2, '.', ',').' </td>
                                      
                                            
                                        </tr>
                                         <tr>
                                              <td colspan="3">Return to work (RTW) screening</td>
                                         
                                            <td> $'.number_format($data['RtwScrenning'], 2, '.', ',').' </td>
                                      
                                            
                                        </tr>
                                         <tr>
                                             <td colspan="3">Cancellation Fee</td>
                                            
                                            <td> $'.number_format($data['cancelfee'], 2, '.', ',').'</td>
                                      
                                            
                                        </tr>
       
                            </table>';
        $totalinvoiceAmt = $ValTotal + $TotalTrevenu;
        $totalinvoiceAmt = number_format($totalinvoiceAmt, 2, '.', '');
        $FrenchiseeDataArr = $this->Webservices_Model->getuserhierarchybysiteid($idsite);
        $discount = $this->Ordering_Model->getClientDiscountByClientId($FrenchiseeDataArr[0]['clientType']);
        $totalDisc = ($totalinvoiceAmt*$discount['percentage'])*0.01;
        $totalDisc = number_format($totalDisc, 2, '.', '');
        $totalAfterDisc = $totalinvoiceAmt-$totalDisc;
        $totalAfterDisc = number_format($totalAfterDisc, 2, '.', '');
        $totalGst = $totalAfterDisc*0.1;
        $totalGst =number_format($totalGst, 2, '.', '');
        $totalRoyaltyBefore = $totalGst + $totalAfterDisc;
        $totalRoyaltyBefore =number_format($totalRoyaltyBefore, 2, '.', '');
$html.='<br /><br />
<table border="1px" cellpadding="5">
    <tr>
        <td width="80%" align="left"><b>Discounts:</b></td><td width="20%" align="right">$'.number_format($totalDisc, 2, '.', ',').'</td>
    </tr>
    <tr>
     <td width="80%" align="left"><b>Sub Total (Exc GST):</b></td><td width="20%" align="right">$'.number_format($totalAfterDisc, 2, '.', ',').'</td>
    </tr>
    <tr>
        <td width="80%" align="left"><b>GST:</b></td><td width="20%" align="right">$'.number_format($totalGst, 2, '.', ',').'</td>
    </tr>
    <tr>
        <td width="80%" align="left"><b>Invoice Amount (INC GST):</b></td><td width="20%" align="right">$'.number_format($totalRoyaltyBefore, 2, '.', ',').'</td>
    </tr>
   
</table>
      <h3 style="color:black">Please pay within 7 days.</h3> 
        </div> ';
        $pdf->writeHTML($html, true, false, true, false, '');

        error_reporting(E_ALL);/*
        $this->session->unset_userdata('idsite');
        $this->session->unset_userdata('Drugtestid');
        $this->session->unset_userdata('sosid');*/
        ob_end_clean();
        $pdf->Output('view_calculation_details.pdf', 'I');
    }
     function taxInvoiceExcelData()
    {
       
        echo "SUCCESS||||";
        echo "taxInvoiceExcel";
    }

    public function taxInvoiceExcel()
    {
        $this->load->library('excel');
        $filename = 'Report';
        $title = 'Stock request list';
        $file = $filename . '-' . $title; //save our workbook as this file name


        $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->setTitle($filename);
        $this->excel->getActiveSheet()->setCellValue('A1', 'Franchisee Id');
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(13);
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $this->excel->getActiveSheet()->setCellValue('B1', 'Franchisee');
        $this->excel->getActiveSheet()->getStyle('B1')->getFont()->setSize(13);
        $this->excel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $this->excel->getActiveSheet()->setCellValue('C1', 'Product Code');
        $this->excel->getActiveSheet()->getStyle('C1')->getFont()->setSize(13);
        $this->excel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $this->excel->getActiveSheet()->setCellValue('D1', 'Quantity Request');
        $this->excel->getActiveSheet()->getStyle('D1')->getFont()->setSize(13);
        $this->excel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $this->excel->getActiveSheet()->setCellValue('E1', 'Requested On');
        $this->excel->getActiveSheet()->getStyle('E1')->getFont()->setSize(13);
        $this->excel->getActiveSheet()->getStyle('E1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('E1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $franchiseeName = $this->session->userdata('franchiseeName');
        $productCode = $this->session->userdata('productCode');
        $allReqQtyAray = $this->Reporting_Model->getAllQtyRequestDetailsForPdf($franchiseeName, $productCode);
        if (!empty($allReqQtyAray)) {
            $i = 2;
            foreach ($allReqQtyAray as $item) {
                $this->excel->getActiveSheet()->setCellValue('A' . $i, $item['iFranchiseeId']);
                $this->excel->getActiveSheet()->setCellValue('B' . $i, $item['szName']);
                $this->excel->getActiveSheet()->setCellValue('C' . $i, $item['szProductCode']);
                $this->excel->getActiveSheet()->setCellValue('D' . $i, $item['szQuantity']);
                $this->excel->getActiveSheet()->setCellValue('E' . $i, date('d/m/Y h:i:s A', strtotime($item['dtRequestedOn'])));

                $this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(TRUE);
                $this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(TRUE);
                $this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(TRUE);
                $this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(TRUE);
                $this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(TRUE);
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

}

?>