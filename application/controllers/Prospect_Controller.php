<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Prospect_Controller extends CI_Controller
{
    
    function __construct()
    {
        parent::__construct();
        $this->load->model('Prospect_Model');
        $this->load->model('Order_Model');
        $this->load->model('StockMgt_Model');
        $this->load->library('pagination');
        $this->load->model('Ordering_Model');
	$this->load->model('Reporting_Model');
        $this->load->model('Forum_Model');
        $this->load->model('Error_Model');
        $this->load->model('Admin_Model');
        $this->load->model('Franchisee_Model');
        $this->load->model('Inventory_Model');
        $this->load->model('Form_Management_Model');
        $this->load->model('StockMgt_Model');
        $this->load->model('Webservices_Model');
        
    }
//test
public function prospectRecord()
   {
       $is_user_login = is_user_login($this);
       // redirect to dashboard if already logged in
       if (!$is_user_login) {
           ob_end_clean();
           redirect(base_url('/admin/admin_login'));
           die;
       }
       
       if(($_SESSION['drugsafe_user']['iRole']==1) || ($_SESSION['drugsafe_user']['iRole']==5)){
         if(!empty($_POST['szSearch3']))
         {
           $id = $_POST['szSearch3'];   
         }
         else{
           $id = '';  
         }
       }
       if($_SESSION['drugsafe_user']['iRole']==2){
        
           $id = $_SESSION['drugsafe_user']['id'];  
        
       }
           $szBusinessName = $_POST['szSearch1'];
           $status = $_POST['szSearch2'];
        
        $config['base_url'] = __BASE_URL__ . "/prospect/prospectRecord/";
        $config['total_rows'] = count($this->Prospect_Model->getAllProspectDetails($id,$szBusinessName,$status));
        $config['per_page'] = __PAGINATION_RECORD_LIMIT__;
            $this->pagination->initialize($config);
           
           
        $prospectDetailsAry = $this->Prospect_Model->getAllProspectDetails($id,$szBusinessName,$status, $config['per_page'],$this->uri->segment(3));
        $prospectDetailsSearchAry = $this->Prospect_Model->getAllProspectDetails($id);
        if (!empty($_POST)) {
            $_POST['szSearch3'] = $_POST['szSearch3'];
        } else {
            $_POST['szSearch3'] = $id;
        }
        $segmentUriVal = $this->uri->segment(3);
        if(isset($segmentUriVal)){
            $data['startRec'] = $segmentUriVal;
        }else{
            $data['startRec'] = 0;
        }
        $data['links'] = $this->pagination->create_links();
       $data['prospectDetailsSearchAry'] = $prospectDetailsSearchAry;
       $data['prospectDetailsAry'] = $prospectDetailsAry;
       $data['szMetaTagTitle'] = "Prospect Record";
       $data['is_user_login'] = $is_user_login;
       $data['pageName'] = "Prospect_Record";
       $data['id'] = $id;
       $this->load->view('layout/admin_header', $data);
       $this->load->view('prospect/prospectRecord');
       $this->load->view('layout/admin_footer');
   }
public function addprospect()
{
    $is_user_login = is_user_login($this);
    // redirect to dashboard if already logged in
    if (!$is_user_login) {
        ob_end_clean();
        redirect(base_url('/admin/admin_login'));
        die;
    }
    $franchiseId = $_SESSION['drugsafe_user']['id'];
    $validate= $this->input->post('addprospect');
   if(($_SESSION['drugsafe_user']['iRole']==1)|| ($_SESSION['drugsafe_user']['iRole']==5) ){
       $validateData =  $this->Prospect_Model->validateProspectData($validate,array(),false,2) ;  
  
     } else{
        $validateData = $this->Prospect_Model->validateProspectData($validate,array(),false);
     }
     if($validateData)
            {
                if($this->Prospect_Model->insertProspectData($validate))
                {
                    $szMessage['type'] = "success";
                    $szMessage['content'] = "<h4><strong>New prospect added successfully.</strong></h4> ";
                    $this->session->set_userdata('drugsafe_user_message', $szMessage);
                    ob_end_clean();
                   if($_SESSION['drugsafe_user']['iRole'] == '1'){ 
                       redirect(base_url('/prospect/franchiseeProspectRecord'));
                   } else{
                       redirect(base_url('/prospect/prospectRecord'));  
                   }
                  
                }
            }
     $getState=$this->Franchisee_Model->getStateByFranchiseeId($franchiseId);
     $data['prospectDetailsAry'] = $prospectDetailsAry;
     $data['szMetaTagTitle'] = "Prospect Record";
     $data['is_user_login'] = $is_user_login;
     $data['pageName'] = "Prospect_Record";
     $data['validate'] = $validate;
     $data['getState']=$getState;
     $data['arErrorMessages'] = $this->Prospect_Model->arErrorMessages;
    
    $this->load->view('layout/admin_header', $data);
    $this->load->view('prospect/addProspect');
    $this->load->view('layout/admin_footer');
}
public function deleteprospectAlert()
      {
          $data['mode'] = '__DELETE_PROSPECT_POPUP__';
          $data['prospectId'] = $this->input->post('prospectId');
          $this->load->view('admin/admin_ajax_functions',$data);
      }
public function deleteProspectConfirmation()
{
    $data['mode'] = '__DELETE_PROSPECT_CONFIRM__';
    $data['prospectId'] = $this->input->post('prospectId');
    $this->Prospect_Model->deleteProspectRecord($data['prospectId']);
    $this->load->view('admin/admin_ajax_functions',$data);
}
   function editProspectData()
        {
           
            $idProspect = $this->input->post('idProspect');
            $flag = $this->input->post('flag');
            
            if($idProspect>0)
            {
                 $this->session->set_userdata('idProspect',$idProspect);
                 $this->session->set_userdata('flag',$flag);
                echo "SUCCESS||||";
                echo "edit_prospect";
            }
            
        }
        
        public function edit_prospect()
        {
             $is_user_login = is_user_login($this);
            // redirect to dashboard if already logged in
            if(!$is_user_login)
            {
                ob_end_clean();
               redirect(base_url('/admin/admin_login'));
                die;
            }
            $franchiseId = $_SESSION['drugsafe_user']['id'];
            $idProspect = $this->session->userdata('idProspect');
            $flag = $this->session->userdata('flag');
            if($idProspect >0)
            {
              
                $data_validate = $this->input->post('editProspect');
                if(empty($data_validate))
                {
                    $prospectDataAry = $this->Prospect_Model->getProspectDetailsByProspectsId($idProspect);
                   
                }
                else
                {
                    $prospectDataAry = $data_validate;
                }
                if(($_SESSION['drugsafe_user']['iRole']==1)|| ($_SESSION['drugsafe_user']['iRole']==5) ){
              $validateData =  $this->Prospect_Model->validateProspectData($data_validate,array(),$idProspect,2) ;  
  
                } else{
                   $validateData = $this->Prospect_Model->validateProspectData($data_validate,array(),$idProspect);
                }
           if($validateData)
             {
                    if($this->Prospect_Model->updateProspectDetails($data_validate,$idProspect))
                    {
                        $szMessage['type'] = "success";
                        $szMessage['content'] = "<h4><strong> Prospect data successfully updated.</strong></h4> ";
                        $this->session->set_userdata('drugsafe_user_message', $szMessage);
                      if($flag==1){
                        $this->session->unset_userdata('flag');
                        $this->session->unset_userdata('idProspect');
                        redirect(base_url('/prospect/prospectRecord'));  
                      }
                     if($flag==2){
                          $this->session->unset_userdata('flag');
                        redirect(base_url('/prospect/view_prospect_details'));  
                      }
                        
                      
                    }
                }
                $getState=$this->Franchisee_Model->getStateByFranchiseeId($franchiseId);
                    $data['szMetaTagTitle'] = "Edit Prospect Details ";
                    $data['is_user_login'] = $is_user_login;
                    $data['pageName'] = "Prospect_Record";
                    $_POST['editProspect'] = $prospectDataAry;
                    $data['getState']=$getState;
                    $_POST['flag'] = $flag;
                    $data['flag'] = $flag;
                    $data['arErrorMessages'] = $this->Prospect_Model->arErrorMessages;
            $this->load->view('layout/admin_header',$data);
            $this->load->view('prospect/editProspect');
            $this->load->view('layout/admin_footer');
            }
        }
         function viewProspectData()
    {
        $idProspect = $this->input->post('idProspect');
        if($idProspect>0)
        {
            $this->session->set_userdata('idProspect', $idProspect);
            echo "SUCCESS||||";
            echo "view_prospect_details";
        }
    }
    public function view_prospect_details()
    {
             $is_user_login = is_user_login($this);
            // redirect to dashboard if already logged in
            if(!$is_user_login)
            {
                ob_end_clean();
               redirect(base_url('/admin/admin_login'));
                die;
            }
            $meetingNoteCreatedBy = $_POST['szSearch2'];
            $idProspect = $this->session->userdata('idProspect');
            if($idProspect >0)
            {
              $prospectDetailsAry = $this->Prospect_Model->getProspectDetailsByProspectsId($idProspect);
              
              $config['base_url'] = __BASE_URL__ . "/prospect/view_prospect_details/";
              $config['total_rows'] = count($this->Prospect_Model->getAllMeetingDetailsByProspectsId($idProspect,$meetingNoteCreatedBy));
              $config['per_page'] = __PAGINATION_RECORD_LIMIT__;
               
            $this->pagination->initialize($config);
              $mettingsDetailsAry = $this->Prospect_Model->getAllMeetingDetailsByProspectsId($idProspect,$meetingNoteCreatedBy,$config['per_page'],$this->uri->segment(3));
              $mettingsDetailsSearchAry = $this->Prospect_Model->getAllMeetingDetailsByProspectsId($idProspect,false,false,false,1);
                $franchiseId = $prospectDetailsAry['iFranchiseeId'];
                $getState=$this->Franchisee_Model->getStateByFranchiseeId($franchiseId);
             
                    $data['szMetaTagTitle'] = "View Prospect Details ";
                    $data['is_user_login'] = $is_user_login;
                    $data['pageName'] = "Prospect_Record";
                    $data['prospectDetailsAry'] = $prospectDetailsAry;
                    $data['mettingsDetailsAry'] = $mettingsDetailsAry;
                    $data['mettingsDetailsSearchAry'] = $mettingsDetailsSearchAry;
                    $data['getState']=$getState;
                    $data['arErrorMessages'] = $this->Prospect_Model->arErrorMessages;
            $this->load->view('layout/admin_header',$data);
            $this->load->view('prospect/viewProspectDetails.php');
            $this->load->view('layout/admin_footer');
            }
        }
         function addMeetingNotesData()
        {
            $idProspect = $this->input->post('idProspect');
            $flag = $this->input->post('flag');
            $this->session->set_userdata('idProspect',$idProspect);
            $this->session->set_userdata('flag',$flag);
           
            echo "SUCCESS||||";
            echo "add_meeting_notes";
            
        }
        public function add_meeting_notes() {
         
              $is_user_login = is_user_login($this);
              $idProspect = $this->session->userdata('idProspect');
              $flag = $this->session->userdata('flag');
              
              $validate = $this->input->post('meetingNotesData');
          
            // redirect to dashboard if already logged in
            if (!$is_user_login) {
                ob_end_clean();
              redirect(base_url('/admin/admin_login'));
                die;
            }
            $this->load->library('form_validation');
            $this->form_validation->set_rules('meetingNotesData[szDiscription]', 'Meeting Note', 'required');
            $this->form_validation->set_message('required', '{field} is required.');
            if ($this->form_validation->run() == FALSE)
            { 
               
                $data['szMetaTagTitle'] = "Add Meeting Note";
                $data['is_user_login'] = $is_user_login;
                $data['pageName'] = "Prospect_Record";
                $data['flag'] = $flag;
                $data['idProspect'] = $idProspect;
                
                $this->load->view('layout/admin_header', $data);
                $this->load->view('prospect/addMeetingNotes');
                $this->load->view('layout/admin_footer');
            }
            else
            {
                if( $this->Prospect_Model->insertMeetingNotes($validate,$idProspect))
                {
                    $szMessage['type'] = "success";
                    $szMessage['content'] = "<h4><strong> Meeting Note added successfully.</strong></h4>";
                    $this->session->set_userdata('drugsafe_user_message', $szMessage); 
                    if($flag==1){
                       $this->session->unset_userdata('idProspect');
                       $this->session->unset_userdata('flag');  
                       redirect(base_url('/prospect/prospectRecord'));
                    }
                    else{
                       $this->session->unset_userdata('flag');   
                       redirect(base_url('/prospect/view_prospect_details'));
                    }
                   
                    
                }
            }
        }
         function viewMeetingNotesData()
    {
        $idMeetingNotes = $this->input->post('idMeetingNotes');
        if($idMeetingNotes>0)
        {
            $this->session->set_userdata('idMeetingNotes', $idMeetingNotes);
            echo "SUCCESS||||";
            echo "view_meeting_notes_details";
        }
    }
    public function view_meeting_notes_details()
    {
             $is_user_login = is_user_login($this);
            // redirect to dashboard if already logged in
            if(!$is_user_login)
            {
                ob_end_clean();
               redirect(base_url('/admin/admin_login'));
                die;
            }
            $idMeetingNotes = $this->session->userdata('idMeetingNotes');
            if($idMeetingNotes >0)
            {
//              $prospectDetailsAry = $this->Prospect_Model->getProspectDetailsByProspectsId($idProspect);
//              $mettingsDetailsAry = $this->Prospect_Model->getAllMeetingDetailsByProspectsId($idProspect);
             
                    $data['szMetaTagTitle'] = "View Prospect Details ";
                    $data['is_user_login'] = $is_user_login;
                    $data['pageName'] = "Prospect_Record";
                    $data['prospectDetailsAry'] = $prospectDetailsAry;
                    $data['mettingsDetailsAry'] = $mettingsDetailsAry;
                    $data['arErrorMessages'] = $this->Prospect_Model->arErrorMessages;
            $this->load->view('layout/admin_header',$data);
            $this->load->view('prospect/viewProspectDetails.php');
            $this->load->view('layout/admin_footer');
            }
        }
          public function editProspectStatusData()
        {
            $data['mode'] = '__PROSPECT_STATUS_EDIT_POPUP_FORM__';
            $idProspect= $this->input->post('idProspect');
            $data['idProspect'] = $this->input->post('idProspect');
            $this->load->view('admin/admin_ajax_functions',$data);
        }
        public function editProspectStatusConfirm()
        {  
          
            $data = $this->input->post('changeStatus');
            $idProspect = $this->input->post('idProspect');
           
            $this->load->library('form_validation');
            $this->form_validation->set_rules('changeStatus[status]', 'Status', 'required');
            $this->form_validation->set_message('required', '{field} is required.');
            if ($this->form_validation->run() == FALSE)
           {
           ?>
            <div id="editProspectStatus" class="modal fade" tabindex="-2" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <div class="modal-title">
                        <div class="caption">
                            <h4><i class="icon-equalizer font-red-sunglo"></i> &nbsp;
                                <span class="caption-subject font-red-sunglo bold uppercase"> Change Status </span></h4>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <form action="" id="changeStatus" name="changeStatus" method="post"
                          class="form-horizontal form-row-sepe">
                        <div class="form-body">
                            <div
                                class="form-group <?php if (form_error('changeStatus[status]')) { ?>has-error<?php } ?>">
                                <label class="control-label col-md-4">Status</label>
                                <div class="col-md-5">
                                   <div class="search">
                                        <div id='changeStatus'>                         
                                       <select class="form-control " name="changeStatus[status]" id="szState"
                                               Placeholder="Status" onfocus="remove_formError(this.id,'true')">
                                          
                                                <option value=''>Select</option>
                                                <option value="1" <?php echo (sanitize_post_field_value($prospectStatusDetailsAry['status']) == trim("1") ? "selected" : ""); ?>>Newly Added</option>
                                                <option value="2" <?php echo (sanitize_post_field_value($prospectStatusDetailsAry['status']) == trim("2") ? "selected" : ""); ?>>In Progress</option>
                                                <option value="3" <?php echo (sanitize_post_field_value($prospectStatusDetailsAry['status']) == trim("3") ? "selected" : ""); ?>>Completed</option>
                                               
                                      </select>
                                            </div>
                                  </div>
                                    <?php
                                    if (form_error('changeStatus[status]')) {
                                        ?>
                                        <span class="help-block pull-left">
                                        <span><?php echo form_error('changeStatus[status]'); ?></span>
                                        </span><?php } ?>
                                </div>
                            </div>
                        </div>
                    </form>
            <div class="portlet green-meadow box">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-cogs"></i> Status Change Info

                            </div>

                        </div>
                       <?php  $prospectStatusDetailsAry = $this->Prospect_Model->getProspectStatusDetails($idProspect,1);
                            ?>
                        <div class="portlet-body">
                                <div class="portlet-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th> Sr No</th>
                                        <th> Status</th>
                                        <th> Updated By</th>
                                        <th> Updated On</th
                                         
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $i=0;
                                    foreach ($prospectStatusDetailsAry as $prospectStatusDetailsData) {
                                      
                                          $i++;
                                     ?>
                                        <tr>
                                            <td> <?php echo $i; ?> </td>
                                            <td>
                                            <?php if ($prospectStatusDetailsData['status'] == 1) { ?>

                                                <p title="Order Status"
                                                   class="label label-sm label-warning">
                                                    Newly Added
                                                </p>
                                                <?php
                                            }
                                            if ($prospectStatusDetailsData['status'] == 3) {
                                                ?>
                                                <p title="Order Status"
                                                   class="label label-sm label-success">
                                                    Completed
                                                </p>
                                                <?php
                                            }
                                            if ($prospectStatusDetailsData['status'] == 2) {
                                                ?>
                                                <p title="Order Status"
                                                   class="label label-sm label-info">
                                                     In Progress
                                                </p>
                                                <?php
                                            }
                                           ?></td>
                                        <td>
                                            <?php 
                                             if($prospectStatusDetailsData['szUpdatedBy'])
                                            {
                                                $franchiseeDetArr = $this->Admin_Model->getAdminDetailsByEmailOrId('',$prospectStatusDetailsData['szUpdatedBy']);
                                                echo $franchiseeDetArr['szName'];
                                            }
                                            else
                                            {
                                               echo "N/A";
                                            }
                                           
                                            ?> 
                                         </td>
                                         <td>  <?php
                                        if($prospectStatusDetailsData['dtUpdatedOn']== '0000-00-00 00:00:00')
                                        {
                                          echo "N/A"; 
                                        }
                                        else{
                                             echo date('d M Y',strtotime($prospectStatusDetailsData['dtUpdatedOn'])) . ' at '.date('h:i A',strtotime($prospectStatusDetailsData['dtUpdatedOn']));   
                                          
                                        }
                                        ?> </td>
                                    

                                        </tr>
                                        
                                    <?php } ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                           
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                    <button type="button"
                            onclick="editProspectStatusConfirmation('<?php echo $idProspect; ?>'); return false;"
                            class="btn green">Submit
                    </button>
                </div>
            </div>
        </div>
    </div>
              <?php
           }
           else{
              
            $this->Prospect_Model->updateProspectStatus($data,$idProspect);
            $data['mode'] = '__PROSPECT_STATUS_EDIT_POPUP_CONFIRMATION__';
            $this->load->view('admin/admin_ajax_functions',$data);
           }
        }
        public function showDescriptionData()
      {
          $data['mode'] = '__SHOW_MEETING_DESCRIPTION_POPUP__';
          $data['idMeetingNote'] = $this->input->post('idMeetingNote');
          $this->load->view('admin/admin_ajax_functions',$data);
      }
       function exportProspectCsvData()
        {
            $franchiseeId = $this->input->post('franchiseeId');
            $prospectId = $this->input->post('prospectId');
            $status = $this->input->post('status');
          
                $this->session->set_userdata('franchiseeId',$franchiseeId);
                $this->session->set_userdata('prospectId',$prospectId);
                $this->session->set_userdata('status',$status);
               
                
                echo "SUCCESS||||";
                echo "export_prospect_csv";
            
 
        }
      
     public function export_prospect_csv()
        {
        ob_start();
        ini_set('max_execution_time', 5000);
        header( 'Content-type: text/html; charset=utf-8' );
        
        $szBusinessName = $this->session->userdata('prospectId');
        $status = $this->session->userdata('status');
        $franchiseeId = $this->session->userdata('franchiseeId');
        if(!empty($franchiseeId)){
           $id = $franchiseeId;    
        }
        
        if($_SESSION['drugsafe_user']['iRole']==2){
           $id = $_SESSION['drugsafe_user']['id'];  
       }
       if($_SESSION['drugsafe_user']['iRole']==2){
           $id = $_SESSION['drugsafe_user']['id'];  
       }
        $prospectDetailsAry = $this->Prospect_Model->getAllProspectDetails($id,$szBusinessName,$status);
        
        $data[0]['Sr No.'] ='Sr No.';
        $data[0]['business_name'] ='Business Name';
        $data[0]['contact_name'] ='Contact Name';
        $data[0]['abn'] ='ABN';
        $data[0]['szEmail'] ='Primary Email';
        $data[0]['szContactNumber'] ='Primary Phone No';
        $data[0]['industry'] ='Industry';
        $data[0]['status'] ='Status';
        $data[0]['szContactEmail'] ='Contact Email No';
        $data[0]['szContactMobile'] ='Contact Mobile No';
        $data[0]['szContactPhone'] ='Contact Phone No';
        $data[0]['szAddress'] ='Address';
        $data[0]['szCity'] ='City';
        $data[0]['szCountry'] ='Country';
        $data[0]['szZipCode'] ='Zip Code';
        $data[0]['L_G_Channel'] ='Lead Generation Channel';
        $data[0]['szNoOfSites'] ='No Of Sites';
        $data[0]['dt_last_updated_meeting'] ='Meeting Date/Time';
        $data[0]['dt_last_updated_status'] ='Status Updated Date/Time';
        
                       
                           
        $i=1;
        if(!empty($prospectDetailsAry))
           {
               foreach ($prospectDetailsAry as $prospectDetailsData)
               {
                   if($prospectDetailsData['dt_last_updated_meeting']=='0000-00-00 00:00:00'){
                     $meetingVal = "N/A";  
                   }
                   else{
                     $meetingVal = date('d/m/Y',  strtotime($prospectDetailsData['dt_last_updated_meeting'])). ' at '.date('h:i A',strtotime($prospectDetailsData['dt_last_updated_meeting'])); 
                   }
                    if($prospectDetailsData['dt_last_updated_status']=='0000-00-00 00:00:00'){
                     $statusVal = "N/A";  
                   }
                   else{
                     $statusVal = date('d/m/Y',  strtotime($prospectDetailsData['dt_last_updated_status'])). ' at '.date('h:i A',strtotime($prospectDetailsData['dt_last_updated_status'])); 
                   }
                     if($prospectDetailsData['industry']==1){
                               $value = 'Agriculture, Forestry and Fishing';
                            }
                            if($prospectDetailsData['industry']==2){
                               $value = 'Mining';
                            }
                            if($prospectDetailsData['industry']==3){
                               $value = 'Manufacturing';
                            }
                            if($prospectDetailsData['industry']==4){
                               $value = 'Electricity, Gas and Water Supply';
                            }if($prospectDetailsData['industry']==5){
                               $value = 'Construction';
                            }if($prospectDetailsData['industry']==6){
                               $value = 'Wholesale Trade';
                            }if($prospectDetailsData['industry']==7){
                               $value = 'Transport and Storage';
                            }if($prospectDetailsData['industry']==8){
                               $value = 'Communication Services';
                            }if($prospectDetailsData['industry']==9){
                               $value = 'Agriculture, Property and Business Services';
                            }if($prospectDetailsData['industry']==10){
                               $value = 'Agriculture, Government Administration and Defence';
                            }if($prospectDetailsData['industry']==11){
                               $value = 'Education';
                            }
                            if($prospectDetailsData['industry']==12){
                               $value = 'Health and Community Services';
                            }if($prospectDetailsData['industry']==13){
                               $value = 'Other';
                            }  
                            
                       $data[$i]['sn'] =$i;
                       $data[$i]['business_name'] =$prospectDetailsData['szBusinessName'];
                       $data[$i]['contact_name'] =($prospectDetailsData['szName']==''?'N/A':$prospectDetailsData['szName']);
                       $data[$i]['abn'] =($prospectDetailsData['abn']==''?'N/A':$prospectDetailsData['abn']);
                       $data[$i]['szEmail'] =($prospectDetailsData['szEmail']==''?'N/A':$prospectDetailsData['szEmail']);
                       $data[$i]['szContactNumber'] =($prospectDetailsData['szContactNumber']==''?'N/A':$prospectDetailsData['szContactNumber']);
                       $data[$i]['industry'] = $value;
                       $data[$i]['status'] =($prospectDetailsData['status']=='1'?'Pre Discovery':($prospectDetailsData['status']=='2'?'Discovery Meeting':($prospectDetailsData['status']=='3'?'In Progress' :($prospectDetailsData['status']=='4'?'Non Convertible' :($prospectDetailsData['status']=='5'?'Contact Later':($prospectDetailsData['status']=='6'?'Closed Sale':''))))));
                       $data[$i]['szContactEmail'] =($prospectDetailsData['szContactEmail']==''?'N/A':$prospectDetailsData['szContactEmail']);
                       $data[$i]['szContactMobile'] =($prospectDetailsData['szContactMobile']==''?'N/A':$prospectDetailsData['szContactMobile']);
                       $data[$i]['szContactPhone'] =($prospectDetailsData['szContactPhone']==''?'N/A':$prospectDetailsData['szContactPhone']);
                       $data[$i]['szAddress'] =($prospectDetailsData['szAddress']==''?'N/A':$prospectDetailsData['szAddress']);
                       $data[$i]['szCity'] =($prospectDetailsData['szCity']==''?'N/A':$prospectDetailsData['szCity']);
                       $data[$i]['szCountry'] =($prospectDetailsData['szCountry']==''?'N/A':$prospectDetailsData['szCountry']);
                       $data[$i]['szZipCode'] =($prospectDetailsData['szZipCode']==''?'N/A':$prospectDetailsData['szZipCode']);
                       $data[$i]['L_G_Channel'] =$prospectDetailsData['L_G_Channel'];
                       $data[$i]['szNoOfSites'] =($prospectDetailsData['szNoOfSites']==''?'N/A':$prospectDetailsData['szNoOfSites']);
                       $data[$i]['dt_last_updated_meeting'] = $meetingVal ; 
                       $data[$i]['dt_last_updated_status'] = $statusVal ; 
                      
                       $i++;
               }
           }
        header('Content-type: text/csv','charset=utf-8');
        header("Content-Disposition: attachment;filename=ProspectCsv".date('m-d-Y-h-i-s').".csv");            
        $f  =   fopen('php://output', 'w+');
        if(!empty($data))
        {
           foreach ($data as $fields) 
           {
                   $download= fputcsv($f, $fields);    
           }
        }
     }
      public function import_csv_popup_alert()
      {
          $data['mode'] = '__IMPORT_CSV_POPUP__';
          $this->load->view('admin/admin_ajax_functions',$data);
      }
    public function importCsvData(){
   
    $target_dir = __APP_PATH__."/uploads/";
    $target_file = $target_dir . basename($_FILES["imp_prospects"]["name"]);
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
    if($_POST["importProspects"] == '1') {
    
    if($imageFileType == 'csv'){
      
        if (move_uploaded_file($_FILES["imp_prospects"]["tmp_name"], $target_file)) {
            
           $File =$target_file;
           $arrResult  = array();
           $handle     = fopen($File, "r");
           if(empty($handle) === false) {
            while(($data = fgetcsv($handle, 1000, ",")) !== FALSE){
            $arrResult[] = $data;
            }
            fclose($handle);
          }
          array_shift($arrResult);
          $count =0;
        
            foreach ($arrResult as $worksheet) {
                
               $_POST['prospectAry']['szBusinessName'] = $worksheet[1];
               $_POST['prospectAry']['szName'] = $worksheet[2];
               $_POST['prospectAry']['abn'] = $worksheet[3];
               $_POST['prospectAry']['szEmail'] = $worksheet[4]; 
               $_POST['prospectAry']['szContactNumber'] = $worksheet[5]; 
               $_POST['prospectAry']['industry'] = $worksheet[6]; 
               $_POST['prospectAry']['status'] = $worksheet[7]; 
               $_POST['prospectAry']['szContactEmail'] = $worksheet[8]; 
               $_POST['prospectAry']['szContactMobile'] = $worksheet[9]; 
               $_POST['prospectAry']['szContactPhone'] = $worksheet[10];
               $_POST['prospectAry']['szAddress'] = $worksheet[11];
               $_POST['prospectAry']['szCity'] = $worksheet[12];
               $_POST['prospectAry']['szCountry'] = $worksheet[13];
               $_POST['prospectAry']['szZipCode'] = $worksheet[14];
               $_POST['prospectAry']['L_G_Channel'] = $worksheet[15];
               $_POST['prospectAry']['szNoOfSites'] = $worksheet[16];
               $_POST['prospectAry']['dt_last_updated_meeting'] = $worksheet[17];
               $_POST['prospectAry']['dt_last_updated_status'] = $worksheet[18];
               $_POST['prospectAry']['iFranchiseeId'] = $_POST['iFranchiseeId'];
               
              $validation=$this->Prospect_Model->validateProspectData($_POST['prospectAry'],array(),false,false,1);
                if($validation)
                {
                     $query =  $this->Prospect_Model->insertProspectData($_POST['prospectAry'],1); 
                }
                else
                {
                    $count++;
                    //continue;
                    
                }
            }
        
                   if($query){
                    $szMessage['type'] = "success";
                    if ($count==0){
                       $szMessage['content'] = "<h4><strong> Prospect Record imported successfully.</strong></h4>";   
                    }
                    else{
                        $szMessage['content'] = "<h4><strong> Prospect Record imported successfully, except ".$count. " rows because of invalid data. </strong></h4>";
                    }
                  
                    $this->session->set_userdata('drugsafe_user_message', $szMessage);  
                    redirect(base_url('/prospect/prospectRecord'));
                    }
                    else{
                     $szMessage['type'] = "error";
                    $szMessage['content'] = "<h4><strong> Sorry, there was an error while importing data. Please try again.</strong></h4>" ;
                    $this->session->set_userdata('drugsafe_user_message', $szMessage);  
                    redirect(base_url('/prospect/prospectRecord'));
               
                    }
        } else {
                    $szMessage['type'] = "error";
                    $szMessage['content'] = "<h4><strong> Sorry, there was an error While importing your file.</strong></h4>";
                    $this->session->set_userdata('drugsafe_user_message', $szMessage);  
                    redirect(base_url('/prospect/prospectRecord'));
           
        }
        
       }
      }
     }
    function franchiseeProspectRecord()
    {
        $is_user_login = is_user_login($this);
        $count = $this->Admin_Model->getnotification();
        $commentReplyNotiCount = $this->Forum_Model->commentReplyNotifications();
        if (!$is_user_login) {
            ob_end_clean();
            redirect(base_url('/admin/admin_login'));
            die;
        }
        $searchAry = '';
        if (isset($_POST['szSearchFrRecord']) && !empty($_POST['szSearchFrRecord'])) {
            $id = $_POST['szSearchFrRecord'];
        }
        if ($id > 0) {
            if ($_SESSION['drugsafe_user']['iRole'] == '1') {
                $prospectAray = $this->Prospect_Model->getAllProspectDetails($id);
              
            } else {
                $operationManagerId = $_SESSION['drugsafe_user']['id'];
                $prospectAray = $this->Prospect_Model->getAllProspectDetails($id);
            }
            if (!empty($prospectAray)) {
                $this->session->set_userdata('id', $id);
                redirect(base_url('/prospect/prospectRecord'));
            }
        }
        $data['prospectAray'] = $prospectAray;
        $data['pageName'] = "Prospect_Record";
        $data['szMetaTagTitle'] = "Prospect Record";
        $data['is_user_login'] = $is_user_login;
        $data['notification'] = $count;
        $data['commentnotification'] = $commentReplyNotiCount;
        $this->load->view('layout/admin_header', $data);
        $this->load->view('prospect/showProspectByFranchisee');
        $this->load->view('layout/admin_footer');
    }
   
    function getProspecttListByFrIdData($idFranchisee = '')
    {
        if (trim($idFranchisee) != '') {
            $_POST['idFranchisee'] = $idFranchisee;
        }
        $prospectAray = $this->Prospect_Model->getAllProspectDetailsByFrId($_POST['idFranchisee']);
        $result = "<select class=\"form-control custom-select required\" id=\"szSearch1\" name=\"szSearch1\" placeholder=\"Business Name\" onfocus=\"remove_formError(this.id,'true')\">";
        if (!empty($prospectAray)) {
            $result .= "<option value=''>Business Name</option>";
            foreach ($prospectAray as $prospectDetails) {
                $result .= "<option value='" . $prospectDetails['id'] . "'>" . $prospectDetails['szBusinessName'] . "</option>";
            }
        } else {
            $result .= "<option value=''>Business Name</option>";
        }
        $result .= "</select>";
        echo $result;
    }    
 public function changeToClientAlert()
 {
    $data['mode'] = '__CHANGE_TO_CLIENT__';
    $prospectId= $this->input->post('prospectId');
    $data['prospectId'] = $this->input->post('prospectId');
    $this->load->view('admin/admin_ajax_functions',$data);   
 }
 public function changeToClientConfirmation()
 { 
   
    $prospectAry = $this->Prospect_Model->getProspectDetailsByProspectsId($this->input->post('prospectId'));
  
    if($prospectAry){
   $emptyFieldArr = array();
     if(empty($prospectAry['abn'])){
   array_push($emptyFieldArr, 'ABN');
   }         
    if(empty($prospectAry['szName'])){
       array_push($emptyFieldArr, 'Name');
      }
       if(empty($prospectAry['szEmail'])){
     array_push($emptyFieldArr, 'Email');
     }
    if(empty($prospectAry['szContactNumber'])){
    array_push($emptyFieldArr, 'Contact No');
     }
      if(empty($prospectAry['szAddress'])){
    array_push($emptyFieldArr, 'Address');
     }
      if(empty($prospectAry['szNoOfSites'])){
    array_push($emptyFieldArr, 'No Of Sites');
     }
      if(empty($prospectAry['szCountry'])){
    array_push($emptyFieldArr, 'Country');
     }
       if(empty($prospectAry['szZipCode'])){
    array_push($emptyFieldArr, 'Zip Code');
     }
   if(empty($prospectAry['szCity'])){
    array_push($emptyFieldArr, 'City');
     }
     } 
    if(!empty($emptyFieldArr)){
     $data['mode'] = '__CHANGE_TO_CLIENT_CONFIRMATION_FAIL__'; 
     $data['emptyFieldArr'] = $emptyFieldArr;
     $data['prospectAry'] = $prospectAry; 
     $data['prospectId'] =  $this->input->post('prospectId'); 
    }
    else{
      $this->Prospect_Model->changeToClient($this->input->post('prospectId'));   
      $data['mode'] = '__CHANGE_TO_CLIENT_CONFIRMATION__';
   
    }
   
     $this->load->view('admin/admin_ajax_functions',$data);
  
 }
  public function prospect_summary_report()
    {
        $is_user_login = is_user_login($this);
        // redirect to dashboard if already logged in
        if (!$is_user_login) {
            ob_end_clean();
            redirect(base_url('/admin/admin_login'));
            die;
        }
           $count = $this->Admin_Model->getnotification();
           $searchAry = $_POST;
           $franchiseeid = $_POST['szSearchfr'];
           $szBusinessName = $_POST['szSearchBussName'];
           $status = $_POST['szSearch2'];
          if($franchiseeid){
            $searchArr = $this->Prospect_Model->getAllProspectDetails($franchiseeid);
          }
             if($_SESSION['drugsafe_user']['iRole']==2){ 
             $franchiseeid = $_SESSION['drugsafe_user']['id'];
             }
             if(!empty($franchiseeid)){
           $recordAry = $this->Prospect_Model->getAllProspectDetails($franchiseeid,$szBusinessName,$status);
             }
           
            $this->load->library('form_validation');
             if(($_SESSION['drugsafe_user']['iRole']==1)|| ($_SESSION['drugsafe_user']['iRole']==5)){ 
             $this->form_validation->set_rules('szSearchfr', 'Franchisee Name ', 'required');
             }
            $this->form_validation->set_message('required', '{field} is required.');
            if ($this->form_validation->run() == FALSE)
            { 
                    $data['szMetaTagTitle'] = "Sales CRM Summary Report";
                    $data['is_user_login'] = $is_user_login;
                    $data['pageName'] = "Reporting";
                    $data['subpageName'] = "Sales_CRM_Summary";
                    $data['notification'] = $count;
                    $data['searchArr'] = $searchArr;
                    $data['data'] = $data;
                    $data['recordAry']=$recordAry;
                    $data['arErrorMessages'] = $this->Prospect_Model->arErrorMessages;
            $this->load->view('layout/admin_header',$data);
            $this->load->view('prospect/prospect_summary_report');
            $this->load->view('layout/admin_footer'); 
            }
            else
            { 
                    $data['recordAry'] = $recordAry; 
                    $data['szMetaTagTitle'] = "Sales CRM Summary Report";
                    $data['is_user_login'] = $is_user_login;
                    $data['pageName'] = "Reporting";
                    $data['subpageName'] = "Sales_CRM_Summary";
                    $data['notification'] = $count;
                    $data['searchArr'] = $searchArr;
                    $data['data'] = $data;
                    $data['recordAry']=$recordAry;
                    $data['arErrorMessages'] = $this->Prospect_Model->arErrorMessages;
            $this->load->view('layout/admin_header',$data);
            $this->load->view('prospect/prospect_summary_report');
            $this->load->view('layout/admin_footer'); 
    }
     
               
    }
         public function viewProspectMeetingNotesData()
      {
          $data['mode'] = '__SHOW_MEETING_NOTES_POPUP__';
          $data['idProspect'] = $this->input->post('idProspect');
          $this->load->view('admin/admin_ajax_functions',$data);
      }
      function View_pdf_Sales_Crm_Report()
        {
        $szBusinessName = $this->input->post('szBusinessName');
        $status = $this->input->post('status');
        $franchiseeId = $this->input->post('franchiseeId');
        $this->session->set_userdata('status',$status);
        $this->session->set_userdata('szBusinessName',$szBusinessName);
        $this->session->set_userdata('franchiseeId',$franchiseeId);
        echo "SUCCESS||||";
        echo "viewpdfsalesCRMSummary";
            
 
        }
    public function viewpdfsalesCRMSummary()
    {
       ob_start();
        $this->load->library('Pdf');
       $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetTitle('Drug-safe Sales CRM Summary Report');
        $pdf->SetAuthor('Drug-safe');
        $pdf->SetSubject('Sales CRM Summary Report PDF');
        $pdf->SetMargins(PDF_MARGIN_LEFT - 10, PDF_MARGIN_TOP - 18, PDF_MARGIN_RIGHT - 10);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
// set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->SetDisplayMode('real', 'default');
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
// set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetFont('times', '', 12);
        // Add a page
       $pdf->AddPage('L');
        
       $franchiseeId = $this->session->userdata('franchiseeId');
        $szBusinessName = $this->session->userdata('szBusinessName');
       $status = $this->session->userdata('status');
        if($_SESSION['drugsafe_user']['iRole']==2){ 
             $franchiseeId = $_SESSION['drugsafe_user']['id'];
             }
        
        $html = '       
       <a style="text-align:center;  margin-bottom:5px;" href="' . __BASE_URL__ . '" ><img style="width:145px" src="' . __BASE_URL__ . '/images/logo.png" alt="logo" class="logo-default" /> </a>
            <div><p style="text-align:center; font-size:18px; margin-bottom:5px; color:black"><b>Sales CRM Summary Report</b></p></div>
            <div class= "table-responsive" >
                            <table border="1" cellpadding="5">
                                    <tr>
                                   
                                         <th style="width:70px"><b> Sr No.</b></th>
                                         <th style="width:150px"><b> Franchisee Name </b> </th>
                                         <th style="width:150px"><b>Business Name</b> </th>
                                         <th style="width:150px"><b>Contact Name</b> </th>
                                         <th style="width:150px"><b>Email</b> </th>
                                        <th style="width:150px"><b>Status</b> </th>
                                        <th style="width:170px"> <b>Status Updated On</b> </th>
                                   
                                   </tr>';
         $recordAry = $this->Prospect_Model->getAllProspectDetails($franchiseeId,$szBusinessName,$status);
        if ($recordAry) {
            $i = 0;
            foreach ($recordAry as $recordData) {
              
               $i++;
                $franchiseeArr = $this->Admin_Model->getUserDetailsByEmailOrId('', $recordData['iFranchiseeId']);
                $meetingAry = $this->Prospect_Model->getLatestMettingDetailsById($recordData['id'],$recordData['dt_last_updated_meeting']);
                if(($recordData['dt_last_updated_status']) == '0000-00-00 00:00:00'){
                $dt_last_updated_status = "N/A";  
              }
              else{
              $dt_last_updated_status =     date('d M Y',strtotime($recordData['dt_last_updated_status'])) . ' at '.date('h:i A',strtotime($recordData['dt_last_updated_status']));
              }
                
                
                $html .= '<tr>
                                            <td> ' . $i . ' </td>
                                            <td> ' . $franchiseeArr['szName'] . '</td>
                                            <td> ' . $recordData['szBusinessName'] . ' </td>
                                            <td> ' . (!empty($recordData['szName'])?$recordData['szName']:'N/A') . ' </td>
                                            <td>' . (!empty($recordData['szEmail'])?$recordData['szEmail']:'N/A') . ' </td>
                                            <td>' . ($recordData['status']=='1'?'Pre Discovery':($recordData['status']=='2'?'Discovery Meeting':($recordData['status']=='3'?'In Progress' :($recordData['status']=='4'?'Non Convertible' :($recordData['status']=='5'?'Contact Later':($recordData['status']=='6'?'Closed Sale':'')))))) . ' </td>
                                            <td> ' . $dt_last_updated_status. '  </td>
                                        </tr>';
                if(!empty($meetingAry)){
                  $meetingVal = $meetingAry['szDescription']; 
                }
                else{
                  $meetingVal = "N/A" ;  
                }
                $html .=
                                       ' <tr>
                                            <td colspan="7"> <b>Meeting Note:- </b>'.$meetingVal.' </td>
                                        </tr>';
                }
            
        }
        $i++;
        $html .= '
                            </table>
                        </div>
                      
                        ';
        $pdf->writeHTML($html, true, false, true, false, '');
        ob_end_clean();
         $this->session->unset_userdata('status');
         $this->session->unset_userdata('franchiseeId');
       $pdf->Output('Sales_CRM_Summary_Report.pdf', 'I');
    }
   function View_xls_Sales_Crm_Report()
        {
         $szBusinessName = $this->input->post('szBusinessName');
        $status = $this->input->post('status');
        $franchiseeId = $this->input->post('franchiseeId');
        $this->session->set_userdata('status',$status);
        $this->session->set_userdata('szBusinessName',$szBusinessName);
        $this->session->set_userdata('franchiseeId',$franchiseeId);
        echo "SUCCESS||||";
                echo "excel_sales_crm_report";
            
 
        }
    public function excel_sales_crm_report()
    {
        $this->load->library('excel');
        $filename = 'Report';
        $title = 'Sales CRM Summary Report';
        $file = $filename . '-' . $title ; //save our workbook as this file name
        $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->setTitle($filename);
        $this->excel->getActiveSheet()->setCellValue('A1', 'Sr No.');
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(13);
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('B1', 'Franchisee Name');
        $this->excel->getActiveSheet()->getStyle('B1')->getFont()->setSize(13);
        $this->excel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('C1', 'Business Name');
        $this->excel->getActiveSheet()->getStyle('C1')->getFont()->setSize(13);
        $this->excel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('D1', 'Contact Name');
        $this->excel->getActiveSheet()->getStyle('D1')->getFont()->setSize(13);
        $this->excel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('E1', 'Email');
        $this->excel->getActiveSheet()->getStyle('E1')->getFont()->setSize(13);
        $this->excel->getActiveSheet()->getStyle('E1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('E1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('F1', 'Status');
        $this->excel->getActiveSheet()->getStyle('F1')->getFont()->setSize(13);
        $this->excel->getActiveSheet()->getStyle('F1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('F1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
         $this->excel->getActiveSheet()->setCellValue('G1', 'Status Updated On');
        $this->excel->getActiveSheet()->getStyle('G1')->getFont()->setSize(13);
        $this->excel->getActiveSheet()->getStyle('G1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('G1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
       $franchiseeId = $this->session->userdata('franchiseeId');
         $szBusinessName = $this->session->userdata('szBusinessName');
        if($_SESSION['drugsafe_user']['iRole']==2){ 
             $franchiseeId = $_SESSION['drugsafe_user']['id'];
             }
       $status = $this->session->userdata('status');
         $recordAry = $this->Prospect_Model->getAllProspectDetails($franchiseeId,$szBusinessName,$status);
        $x=0;
         if ($recordAry) {
            
            $i = 2;
            foreach($recordAry as $item){
                 $x++;
                $franchiseeArr = $this->Admin_Model->getUserDetailsByEmailOrId('', $item['iFranchiseeId']);
               if(($item['dt_last_updated_status']) == '0000-00-00 00:00:00'){
                $dt_last_updated_status = "N/A";  
              }
              else{
              $dt_last_updated_status =     date('d M Y',strtotime($item['dt_last_updated_status'])) . ' at '.date('h:i A',strtotime($item['dt_last_updated_status']));
              }
                if(!empty($item['szName'])){
                 $name =$item['szName'];   
                }
                else{
                  $name ='N/A';  
                }
                 if(!empty($item['szEmail'])){
                $Email =$item['szEmail'];    
                }
                else{
                $Email ='N/A';    
                }
                $this->excel->getActiveSheet()->setCellValue('A'.$i, $x);
                $this->excel->getActiveSheet()->setCellValue('B'.$i, $franchiseeArr['szName']);
                $this->excel->getActiveSheet()->setCellValue('C'.$i, $item['szBusinessName']);
                $this->excel->getActiveSheet()->setCellValue('D'.$i, $name);
                $this->excel->getActiveSheet()->setCellValue('E'.$i, $Email);
                $this->excel->getActiveSheet()->setCellValue('F'.$i, ($item['status']=='1'?'Pre Discovery':($item['status']=='2'?'Discovery Meeting':($item['status']=='3'?'In Progress' :($item['status']=='4'?'Non Convertible' :($item['status']=='5'?'Contact Later':($item['status']=='6'?'Closed Sale':'')))))));
                $this->excel->getActiveSheet()->setCellValue('G'.$i, $dt_last_updated_status);
                
                $this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(TRUE);
                $this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(TRUE);
                $this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(TRUE);
                $this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(TRUE);
                $this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(TRUE);
                $this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(TRUE);
                $this->excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(TRUE);
                $i++;
            }
        }
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="' . $file . '"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
//if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        $this->session->unset_userdata('status');
         $this->session->unset_userdata('franchiseeId');
//force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
    } 
     public function sales_crm_detailed_report()
    {
        $is_user_login = is_user_login($this);
        // redirect to dashboard if already logged in
        if (!$is_user_login) {
            ob_end_clean();
            redirect(base_url('/admin/admin_login'));
            die;
        }
           $count = $this->Admin_Model->getnotification();
           $searchAry = $_POST;
           $franchiseeid = $_POST['szSearch3'];
           $dtStart = $this->Prospect_Model->getSqlFormattedDate($_POST['szSearch1']);
           $dtEnd = $this->Prospect_Model->getSqlFormattedDate($_POST['szSearch2']);
           $status = $_POST['szSearch4'];
            $szBusinessName = $_POST['szSearchBussName'];
             if($franchiseeid){
            $searchArr = $this->Prospect_Model->getAllProspectDetails($franchiseeid);
          }
            if($_SESSION['drugsafe_user']['iRole']==2){ 
             $franchiseeid = $_SESSION['drugsafe_user']['id'];
             }
          
           if($_POST){
             $recordAry = $this->Prospect_Model->getstatusDetailsforDetailedReport($franchiseeid,$dtStart,$dtEnd,$status,$szBusinessName);   
           }
          
            $this->load->library('form_validation');
            $this->form_validation->set_rules('szSearch1', 'Start Date ', 'required');
            if(!empty($_POST['szSearch2'])){
                 $this->form_validation->set_rules('szSearch2', 'End Date ', 'required|callback_endDate_check');    
                }
                else{
                 $this->form_validation->set_rules( 'szSearch2', 'End Date', 'required' );   
                }
            $this->form_validation->set_rules('szSearch3', 'Franchisee Name ', 'required');
            
            
            $this->form_validation->set_message('required', '{field} is required.');
            if ($this->form_validation->run() == FALSE)
            { 
                    $data['szMetaTagTitle'] = "Sales CRM Detailed Report";
                    $data['is_user_login'] = $is_user_login;
                    $data['pageName'] = "Reporting";
                    $data['subpageName'] = "Sales_CRM_Detailed";
                    $data['notification'] = $count;
                    $data['searchArr'] = $searchArr;
                    $data['data'] = $data;
                    $data['recordAry']=$recordAry;
                    $data['arErrorMessages'] = $this->Prospect_Model->arErrorMessages;
            $this->load->view('layout/admin_header',$data);
            $this->load->view('prospect/salesCrmDetailedReport');
            $this->load->view('layout/admin_footer'); 
            }
            else
            { 
                    $data['recordAry'] = $recordAry; 
                    $data['szMetaTagTitle'] = "Sales CRM Detailed Report";
                    $data['is_user_login'] = $is_user_login;
                    $data['pageName'] = "Reporting";
                    $data['subpageName'] = "Sales_CRM_Detailed";
                    $data['notification'] = $count;
                    $data['searchArr'] = $searchArr;
                    $data['data'] = $data;
                    $data['recordAry']=$recordAry;
                    $data['arErrorMessages'] = $this->Prospect_Model->arErrorMessages;
            $this->load->view('layout/admin_header',$data);
            $this->load->view('prospect/salesCrmDetailedReport');
            $this->load->view('layout/admin_footer'); 
    }           
    }
     function endDate_check()
        {
          $searchAry = $_POST;
          $dtStart = $this->Prospect_Model->getSqlFormattedDate($searchAry['szSearch1']);
          $dtEnd = $this->Prospect_Model->getSqlFormattedDate($searchAry['szSearch2']);
          
          
          if(($dtStart)> ($dtEnd))
          {
              $this->form_validation->set_message('endDate_check', 'End Date should be greater than Start Date.');
               return false;
          }
          else{
               return true;
          }
          
       }
      function View_pdf_Sales_Crm_Detailed_Report()
        {
        $startDate = $this->input->post('startDate');
        $endDate = $this->input->post('endDate');
        $franchiseeId = $this->input->post('franchiseeId');
        $szBusinessName = $this->input->post('szBusinessName');
        $status = $this->input->post('status');
        $this->session->set_userdata('endDate',$endDate);
         $this->session->set_userdata('szBusinessName',$szBusinessName);
        $this->session->set_userdata('startDate',$startDate);
        $this->session->set_userdata('status',$status);
        $this->session->set_userdata('franchiseeId',$franchiseeId);
        echo "SUCCESS||||";
        echo "viewpdfsalesCRMDetailed";
        }
    public function viewpdfsalesCRMDetailed()
    {
       ob_start();
        $this->load->library('Pdf');
        $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetTitle('Drug-safe Sales CRM Detailed Report');
        $pdf->SetAuthor('Drug-safe');
        $pdf->SetSubject('Sales CRM Detailed Report PDF');
        $pdf->SetMargins(PDF_MARGIN_LEFT - 10, PDF_MARGIN_TOP - 18, PDF_MARGIN_RIGHT - 10);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
// set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->SetDisplayMode('real', 'default');
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
// set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetFont('times', '', 12);
        // Add a page
       $pdf->AddPage('L');
        
       $franchiseeId = $this->session->userdata('franchiseeId');
       $status = $this->session->userdata('status');
       $startDate = $this->session->userdata('startDate');
       $endDate = $this->session->userdata('endDate');
       $dtStart = $this->Prospect_Model->getSqlFormattedDate($startDate);
       $dtEnd = $this->Prospect_Model->getSqlFormattedDate($endDate);
        $szBusinessName = $this->session->userdata('szBusinessName');
         if($_SESSION['drugsafe_user']['iRole']==2){ 
             $franchiseeId = $_SESSION['drugsafe_user']['id'];
             }  
    
        $html = '       
       <a style="text-align:center;  margin-bottom:5px;" href="' . __BASE_URL__ . '" ><img style="width:145px" src="' . __BASE_URL__ . '/images/logo.png" alt="logo" class="logo-default" /> </a>
            <div><p style="text-align:center; font-size:18px; margin-bottom:5px; color:black"><b>Sales CRM Detailed Report</b></p></div>
            <div class= "table-responsive" >
                            <table border="1" cellpadding="5">
                                    <tr>
                                   
                                         <th style="width:70px"><b> Sr No.</b></th>
                                         <th style="width:150px"><b> Franchisee Name </b> </th>
                                         <th style="width:150px"><b>Business Name</b> </th>
                                         <th style="width:150px"><b>Contact Name</b> </th>
                                         <th style="width:150px"><b>Email</b> </th>
                                        <th style="width:150px"><b>Status</b> </th>
                                        <th style="width:170px"> <b>Status Updated On</b> </th>
                                   
                                   </tr>';
         $recordAry = $this->Prospect_Model->getstatusDetailsforDetailedReport($franchiseeId,$dtStart,$dtEnd,$status,$szBusinessName);   
        if ($recordAry) {
            $i = 0;
            foreach ($recordAry as $recordData) {
              
               $i++;
                $franchiseeArr = $this->Admin_Model->getUserDetailsByEmailOrId('', $recordData['iFranchiseeId']);
                $dt_last_updated_status =     date('d M Y',strtotime($recordData['dtUpdatedOn'])) . ' at '.date('h:i A',strtotime($recordData['dtUpdatedOn']));
                
                $html .= '<tr>
                                            <td> ' . $i . ' </td>
                                            <td> ' . $franchiseeArr['szName'] . '</td>
                                            <td> ' . $recordData['szBusinessName'] . ' </td>
                                            <td> ' . (!empty($recordData['szName'])?$recordData['szName']:'N/A') . ' </td>
                                            <td>' . (!empty($recordData['szEmail'])?$recordData['szEmail']:'N/A') . ' </td>
                                            <td>' . ($recordData['status']=='1'?'Pre Discovery':($recordData['status']=='2'?'Discovery Meeting':($recordData['status']=='3'?'In Progress' :($recordData['status']=='4'?'Non Convertible' :($recordData['status']=='5'?'Contact Later':($recordData['status']=='6'?'Closed Sale':'')))))) . ' </td>
                                            <td> ' . $dt_last_updated_status. '  </td>
                                        </tr>';
            }
        }
        $i++;
        $html .= '
                            </table>
                        </div>
                      
                        ';
        $pdf->writeHTML($html, true, false, true, false, '');
        ob_end_clean();
         $this->session->unset_userdata('status');
         $this->session->unset_userdata('franchiseeId');
         $this->session->unset_userdata('startDate');
         $this->session->unset_userdata('endDate');
       $pdf->Output('Sales_CRM_Detailed_Report.pdf', 'I');
    }
     function View_xls_Sales_Crm_Detailed_Report()
        {
        $startDate = $this->input->post('startDate');
        $endDate = $this->input->post('endDate');
        $franchiseeId = $this->input->post('franchiseeId');
        $szBusinessName = $this->input->post('szBusinessName');
        $status = $this->input->post('status');
        $this->session->set_userdata('endDate',$endDate);
         $this->session->set_userdata('szBusinessName',$szBusinessName);
        $this->session->set_userdata('startDate',$startDate);
        $this->session->set_userdata('status',$status);
        $this->session->set_userdata('franchiseeId',$franchiseeId);
        echo "SUCCESS||||";
                echo "excel_sales_crm_detailed_report";
            
 
        }
    public function excel_sales_crm_detailed_report()
    {
        $this->load->library('excel');
        $filename = 'Report';
        $title = 'Sales CRM Detailed Report';
        $file = $filename . '-' . $title ; //save our workbook as this file name
        $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->setTitle($filename);
        $this->excel->getActiveSheet()->setCellValue('A1', 'Sr No.');
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(13);
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('B1', 'Franchisee Name');
        $this->excel->getActiveSheet()->getStyle('B1')->getFont()->setSize(13);
        $this->excel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('C1', 'Business Name');
        $this->excel->getActiveSheet()->getStyle('C1')->getFont()->setSize(13);
        $this->excel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('D1', 'Contact Name');
        $this->excel->getActiveSheet()->getStyle('D1')->getFont()->setSize(13);
        $this->excel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('E1', 'Email');
        $this->excel->getActiveSheet()->getStyle('E1')->getFont()->setSize(13);
        $this->excel->getActiveSheet()->getStyle('E1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('E1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('F1', 'Status');
        $this->excel->getActiveSheet()->getStyle('F1')->getFont()->setSize(13);
        $this->excel->getActiveSheet()->getStyle('F1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('F1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
         $this->excel->getActiveSheet()->setCellValue('G1', 'Status Updated On');
        $this->excel->getActiveSheet()->getStyle('G1')->getFont()->setSize(13);
        $this->excel->getActiveSheet()->getStyle('G1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('G1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $franchiseeId = $this->session->userdata('franchiseeId');
        $status = $this->session->userdata('status');
        $startDate = $this->session->userdata('startDate');
        $endDate = $this->session->userdata('endDate');
        
       $dtStart = $this->Prospect_Model->getSqlFormattedDate($startDate);
       $dtEnd = $this->Prospect_Model->getSqlFormattedDate($endDate);
        $szBusinessName = $this->session->userdata('szBusinessName');
         if($_SESSION['drugsafe_user']['iRole']==2){ 
             $franchiseeId = $_SESSION['drugsafe_user']['id'];
             }
          $recordAry = $this->Prospect_Model->getstatusDetailsforDetailedReport($franchiseeId,$dtStart,$dtEnd,$status,$szBusinessName);   
        $x=0;
         if ($recordAry) {
           
            $i = 2;
            foreach($recordAry as $item){
                  $x++;
                $franchiseeArr = $this->Admin_Model->getUserDetailsByEmailOrId('', $item['iFranchiseeId']);
                $dt_last_updated_status =     date('d M Y',strtotime($item['dtUpdatedOn'])) . ' at '.date('h:i A',strtotime($item['dtUpdatedOn']));
                
                                          
                if(!empty($item['szName'])){
                 $name =$item['szName'];   
                }
                else{
                  $name ='N/A';  
                }
                 if(!empty($item['szEmail'])){
                $Email =$item['szEmail'];    
                }
                else{
                $Email ='N/A';    
                }
                $this->excel->getActiveSheet()->setCellValue('A'.$i, $x);
                $this->excel->getActiveSheet()->setCellValue('B'.$i, $franchiseeArr['szName']);
                $this->excel->getActiveSheet()->setCellValue('C'.$i, $item['szBusinessName']);
                $this->excel->getActiveSheet()->setCellValue('D'.$i, $name);
                $this->excel->getActiveSheet()->setCellValue('E'.$i, $Email);
                $this->excel->getActiveSheet()->setCellValue('F'.$i, ($item['status']=='1'?'Pre Discovery':($item['status']=='2'?'Discovery Meeting':($item['status']=='3'?'In Progress' :($item['status']=='4'?'Non Convertible' :($item['status']=='5'?'Contact Later':($item['status']=='6'?'Closed Sale':'')))))));
                $this->excel->getActiveSheet()->setCellValue('G'.$i, $dt_last_updated_status);
                
                $this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(TRUE);
                $this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(TRUE);
                $this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(TRUE);
                $this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(TRUE);
                $this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(TRUE);
                $this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(TRUE);
                $this->excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(TRUE);
                $i++;
            }
        }
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="' . $file . '"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
//if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        $this->session->unset_userdata('status');
         $this->session->unset_userdata('franchiseeId');
//force user to download the Excel file without writing it to server's HD
          $this->session->unset_userdata('status');
          $this->session->unset_userdata('franchiseeId');
          $this->session->unset_userdata('startDate');
          $this->session->unset_userdata('endDate');
        $objWriter->save('php://output');
    }
      function viewMeetingNotePdfData()
        {
       $idProspect = $this->input->post('idProspect');
        $this->session->set_userdata('idProspect',$idProspect);
        echo "SUCCESS||||";
        echo "viewMeetingNotePdf";
            
 
        }
         public function viewMeetingNotePdf()
    {
       ob_start();
        $this->load->library('Pdf');
        $pdf = new Pdf('L', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetTitle('Drug-safe Meeting Note Report');
        $pdf->SetAuthor('Drug-safe');
        $pdf->SetSubject('Meeting Note Report PDF');
        $pdf->SetMargins(PDF_MARGIN_LEFT - 10, PDF_MARGIN_TOP - 18, PDF_MARGIN_RIGHT - 10);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->SetDisplayMode('real', 'default');
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetFont('times', '', 12);
        $pdf->AddPage('L');
   
          $idProspect = $this->session->userdata('idProspect');
          $prospectAry = $this->Prospect_Model->getProspectDetailsByProspectsId($idProspect);
          $franchiseeArr = $this->Admin_Model->getUserDetailsByEmailOrId('', $prospectAry['iFranchiseeId']);
          $meetingAry = $this->Prospect_Model->getAllMeetingDetailsByProspectsId($idProspect);
      
    $html = '<div class="wraper">
        <table cellpadding="5px">
       
    <tr>
        <td rowspan="4" align="left"><a style="text-align:left;  margin-bottom:15px;" href="' . __BASE_URL__ . '" ><img style="width:145px" src="' . __BASE_URL__ . '/images/logo.png" alt="logo" class="logo-default" /> </a></td>
    </tr>
</table>
<br />
<h2 style="text-align: center;">PROSPECT DETAILS</h2>
<br>
<h3 style="color:black">Prospect Info  </h3>
<br />
<table cellpadding="5px">
    <tr>
        <td width="50%" align="left" font-size="20"><b>Franchisee Name  :</b> ' .$franchiseeArr['szName'] . '</td>
    </tr>
    <tr>
        <td width="50%" align="left"><b>Business Name : </b> '.$prospectAry['szBusinessName'].'</td>
    </tr>
  
   <tr>
        <td width="50%" align="left"><b>Contact Name : </b> '. $prospectAry['szName'] .'</td>
    </tr>      
  
   <tr>
    <td width="50%" align="left"><b>Email : </b> '.$prospectAry['szEmail'].'</td>
      
    </tr> 
  <tr>
       <td width="50%" align="left"><b>Status : </b> '. ($prospectAry['status']=='1'?'Pre Discovery':($prospectAry['status']=='2'?'Discovery Meeting':($prospectAry['status']=='3'?'In Progress' :($prospectAry['status']=='4'?'Non Convertible' :($prospectAry['status']=='5'?'Contact Later':($prospectAry['status']=='6'?'Closed Sale':'')))))) .'</td>  
    </tr>
 
    
</table>
<br />
<h3 style="color:black">Meeting Note Info </h3>
            <div>
         
                        <div class= "table-responsive" >
                            <table border="1" cellpadding="5">
                                    <tr>
                                        <th width="10%" ><b>Sr No</b> </th>
                                        <th width="70%"> <b>Meeting Note</b> </th>
                                        <th width="20%"> <b>Meeting Date/Time</b> </th>
                                    </tr>';
       
        if ($meetingAry) {
            $i = 0;
            foreach ($meetingAry as $meetingData) {
            if(($meetingData['dtCreatedOn']) == '0000-00-00 00:00:00'){
                 $val = "N/A";  
              }
                else{
               $val = date('d M Y',strtotime($meetingData['dtCreatedOn'])) . ' at '.date('h:i A',strtotime($meetingData['dtCreatedOn']));   
             }    
              $i++;
                $html .= '<tr>
                                            <td> ' . $i. ' </td>
                                            <td> ' . $meetingData['szDescription'] . '</td>
                                            <td> ' . $val . '</td>
                                           
                                        </tr>';
            }
        }
        
        $html .= '
                            </table>
                        </div>
                      
                        ';
        $pdf->writeHTML($html, true, false, true, false, '');
        error_reporting(E_ALL);
        $this->session->unset_userdata('idProspect');
  
        ob_end_clean();
        $pdf->Output('view_meeting_note.pdf', 'I');
    }
  function ViewMeetingNoteExcelData()
        {
            $idProspect = $this->input->post('idProspect');
          
                $this->session->set_userdata('idProspect',$idProspect);
               
                
                echo "SUCCESS||||";
                echo "ViewMeetingNoteExcel";
            
 
        }
    public function ViewMeetingNoteExcel()
    {
        $this->load->library('excel');
        $filename = 'Report';
        $title = 'Drug-safe Meeting Note Details';
        $file = $filename . '-' . $title ; //save our workbook as this file name
        $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->setTitle($filename);
        $this->excel->getActiveSheet()->setCellValue('A12', 'Sr No');
        $this->excel->getActiveSheet()->getStyle('A12')->getFont()->setSize(13);
        $this->excel->getActiveSheet()->getStyle('A12')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A12')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('B12', 'Meeting Note');
        $this->excel->getActiveSheet()->getStyle('B12')->getFont()->setSize(13);
        $this->excel->getActiveSheet()->getStyle('B12')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('B12')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('C12', 'Meeting Date/Time');
        $this->excel->getActiveSheet()->getStyle('C12')->getFont()->setSize(13);
        $this->excel->getActiveSheet()->getStyle('C12')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('C12')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
       
          $idProspect = $this->session->userdata('idProspect');
          $prospectAry = $this->Prospect_Model->getProspectDetailsByProspectsId($idProspect);
          $franchiseeArr = $this->Admin_Model->getUserDetailsByEmailOrId('', $prospectAry['iFranchiseeId']);
          $meetingAry = $this->Prospect_Model->getAllMeetingDetailsByProspectsId($idProspect);
    
          if ($prospectAry['status'] == 1) {
            $status = "Pre Discovery";
        }
        if ($prospectAry['status'] == 2) {
            $status = "Discovery Meeting";
        }
        if ($prospectAry['status'] == 3) {
            $status = "In Progress" ;
        }
        if ($prospectAry['status'] == 4) {
            $status = "Non Convertible";
        }
         if ($prospectAry['status'] == 5) {
            $status = "Contact Later";
        }
         if ($prospectAry['status'] == 6) {
            $status = "Closed Sale";
        }
   
     
        $this->excel->getActiveSheet()->setCellValue('B1', 'PROSPECT DETAILS');
        $this->excel->getActiveSheet()->getStyle('B1')->getFont()->setSize(13);
        $this->excel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
     
      
        $this->excel->getActiveSheet()->setCellValue('A2', 'Prospect Info ');
        $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(13);
        $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
       
        $this->excel->getActiveSheet()->setCellValue('A10', 'Meeting Note Info ');
        $this->excel->getActiveSheet()->getStyle('A10')->getFont()->setSize(13);
        $this->excel->getActiveSheet()->getStyle('A10')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A10')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        
         $this->excel->getActiveSheet()->setCellValue('A4','Franchisee Name :');
         $this->excel->getActiveSheet()->setCellValue('A5','Business Name :');
         $this->excel->getActiveSheet()->setCellValue('A6','Contact Name :');
         $this->excel->getActiveSheet()->setCellValue('A7','Email :');
         $this->excel->getActiveSheet()->setCellValue('A8','Status :');
     
         $this->excel->getActiveSheet()->setCellValue('B4',$franchiseeArr['szName']);
         $this->excel->getActiveSheet()->setCellValue('B5',$prospectAry['szBusinessName']);
         $this->excel->getActiveSheet()->setCellValue('B6',$prospectAry['szName']);
         $this->excel->getActiveSheet()->setCellValue('B7',$prospectAry['szEmail']);
           $this->excel->getActiveSheet()->setCellValue('B8',$status);
        
   
         if ($meetingAry) {
            $i = 13 ;
            $x=0;
            foreach ($meetingAry as $item) {
               if($item['createdon']=="0000-00-00 00:00:00"){
                 $date =   "N/A";
                       } 
                   else{
                   $date = date('d M Y',strtotime($item['dtCreatedOn'])) . ' at '.date('h:i A',strtotime($item['dtCreatedOn']));   
                   }
               $x++;
                 
                $this->excel->getActiveSheet()->setCellValue('A'.$i, $x);
                $this->excel->getActiveSheet()->setCellValue('B'.$i, $item['szDescription']);
                $this->excel->getActiveSheet()->setCellValue('C'.$i, $date);
              
                $this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(TRUE);
                $this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(TRUE);
                $this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(TRUE);
              
                $i++;
            }
        }
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="' . $file . '"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
//if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        $this->session->unset_userdata('idProspect');
//force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
    }
     public function getBussinessListByFrIdData($idFranchisee = '')
    {
        if (trim($idFranchisee) != '') {
            $_POST['idFranchisee'] = $idFranchisee;
         
        }
        if( $_POST['idFranchisee']==0){
          $searchArr = '';   
        }
        else
        {
         $searchArr = $this->Prospect_Model->getAllProspectDetails($_POST['idFranchisee']);
        }
     
        $result = "<select class=\"form-control custom-select required\" id=\"szSearchBussName\" name=\"szSearchBussName\" placeholder=\"Business Name\" onfocus=\"remove_formError(this.id,'true')\">";
        if (!empty($searchArr)) {
            $result .= "<option value=''>Business Name</option>";
            foreach ($searchArr as $searchData) {
                $result .= "<option value='" . $searchData['szBusinessName'] . "'>" . $searchData['szBusinessName'] . "</option>";
            }
        } else {
            $result .= "<option value=''>Business Name</option>";
        }
        $result .= "</select>";
        echo $result;
    }
}
?>