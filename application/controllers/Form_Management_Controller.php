<?php
defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

class Form_Management_Controller extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model( 'Order_Model' );
		$this->load->model( 'StockMgt_Model' );
		$this->load->library( 'pagination' );
		$this->load->model( 'Ordering_Model' );
		$this->load->model( 'Forum_Model' );
		$this->load->model( 'Error_Model' );
		$this->load->model( 'Admin_Model' );
		$this->load->model( 'Franchisee_Model' );
		$this->load->model( 'Inventory_Model' );
		$this->load->model( 'Form_Management_Model' );
		$this->load->model( 'StockMgt_Model' );
		$this->load->model( 'Webservices_Model' );
		$this->load->library( 'pagination' );
	}

	public function index() {
		$is_user_login = is_user_login( $this );
		if ( $is_user_login ) {
			ob_end_clean();
			redirect( base_url( '/admin/franchiseeList' ) );
			die;
		} else {
			ob_end_clean();
			redirect( base_url( '/admin/admin_login' ) );
			die;
		}
	}

	function viewFormData() {
		$flag = $this->input->post( 'flag' );
		$this->session->set_userdata( 'flag', $flag );
		echo "SUCCESS||||";
		echo "viewForm";
	}

	function viewForm() {
		$is_user_login = is_user_login( $this );
		// redirect to dashboard if already logged in
		if ( ! $is_user_login ) {
			ob_end_clean();
			redirect( base_url( '/admin/admin_login' ) );
			die;
		}
		$count                 = $this->Admin_Model->getnotification();
		$commentReplyNotiCount = $this->Forum_Model->commentReplyNotifications();
		$socFr                 = '';
		if ( $_SESSION['drugsafe_user']['iRole'] == '2' ) {
			$socFr = false;
			//$clientAry = $this->Franchisee_Model->viewClientList(true, $_SESSION['drugsafe_user']['id']);
			$AllclientAry             = $this->Webservices_Model->getclientdetails( $_SESSION['drugsafe_user']['id'] );
			$AssignCorpuserDetailsArr = $this->Webservices_Model->getcorpclientdetails( $_SESSION['drugsafe_user']['id'] );
			$CorpuserDetailsArr       = array();
			if ( ! empty( $AssignCorpuserDetailsArr ) ) {
				foreach ( $AssignCorpuserDetailsArr as $assignCorpUser ) {
					$CorpSitesDetailsArr = $this->Webservices_Model->getclientdetails( $assignCorpUser['corpfrid'] );
					if ( ! empty( $CorpSitesDetailsArr ) ) {
						foreach ( $CorpSitesDetailsArr as $CorpUser ) {
							if ( ! in_array( $CorpUser, $CorpuserDetailsArr ) ) {
								array_push( $CorpuserDetailsArr, $CorpUser );
							}
						}
					}
				}
			}
			if ( ! empty( $AllclientAry ) && ! empty( $CorpuserDetailsArr ) ) {
				$clientAry = array_merge( $AllclientAry, $CorpuserDetailsArr );
			} elseif ( ! empty( $AllclientAry ) ) {
				$clientAry = $AllclientAry;
			} elseif ( ! empty( $CorpuserDetailsArr ) ) {
				$clientAry = $CorpuserDetailsArr;
			}
			if ( $_POST['szSearch2'] ) {
				//$siteAry = $this->Franchisee_Model->viewChildClientDetails($_POST['szSearch2']);
				$loggedinFranchisee = $_SESSION['drugsafe_user']['id'];
				$clientDetsArr      = $this->Webservices_Model->getclientdetailsbyclientid( $_POST['szSearch2'] );
				if ( ! empty( $clientDetsArr ) ) {
					$franchiseeid = $clientDetsArr[0]['franchiseeId'];
				}
				$siteAry                  = $this->Webservices_Model->getclientdetails( $franchiseeid, $_POST['szSearch2'] );
				$AssignCorpuserDetailsArr = $this->Webservices_Model->getcorpclientdetails( $loggedinFranchisee, $franchiseeid );
				if ( ! empty( $AssignCorpuserDetailsArr ) ) {
					$siteAry = array();
					foreach ( $AssignCorpuserDetailsArr as $assignCorpUser ) {
						$CorpuserDetailsArr = $this->Webservices_Model->getclientdetails( $assignCorpUser['corpfrid'], $_POST['szSearch2'], 0, $assignCorpUser['clientid'] );
						if ( ! empty( $CorpuserDetailsArr ) ) {
							foreach ( $CorpuserDetailsArr as $CorpUser ) {
								if ( ! in_array( $CorpUser, $CorpuserDetailsArr ) ) {
									array_push( $siteAry, $CorpUser );
								}
							}
						}
					}
				}
			}
		} else {
			$socFr = true;

		}
		if ( $_SESSION['drugsafe_user']['iRole'] == '5' ) {
			$getFranchisees = $this->Admin_Model->viewFranchiseeList( false, $_SESSION['drugsafe_user']['id'], false, false, false, false, false, false, 1 );

		} elseif ( $_SESSION['drugsafe_user']['iRole'] == '1' ) {
			$getFranchisees = $this->Admin_Model->viewFranchiseeList( false, false, false, false, false, false, false, false, 1 );
		} else {
			$getFranchisees = array();
		}
		$this->load->library( 'form_validation' );
		$this->form_validation->set_rules( 'dtStart', 'Test Date From ', 'required' );
		if ( ! empty( $_POST['dtEnd'] ) ) {
			$this->form_validation->set_rules( 'dtEnd', 'Test Date To', 'required|callback_endDate_check' );
		} else {
			$this->form_validation->set_rules( 'dtEnd', 'Test Date To', 'required' );
		}

		$this->form_validation->set_rules( 'szSearch1', 'Franchisee Name', 'required' );
		$this->form_validation->set_rules( 'szSearch2', 'Client Name', 'required' );
		$this->form_validation->set_rules( 'szSearch3', 'Company Name/site', 'required' );
		$this->form_validation->set_message( 'required', '{field} is required.' );
		if ( $this->form_validation->run() == false ) {
			$data['franchiseearr']       = $getFranchisees;
			$data['notification']        = $count;
			$data['socFr']               = $socFr;
			$data['sitearr']             = $siteAry;
			$data['clientarr']           = $clientAry;
			$data['commentnotification'] = $commentReplyNotiCount;
			$data['pageName']            = "Reporting";
			$data['subpageName']         = "SOS_COC_Forms_Reports";
			$data['arErrorMessages']     = $this->Form_Management_Model->arErrorMessages;
			$this->load->view( 'layout/admin_header', $data );
			$this->load->view( 'formManagement/sos-coc-formdetails.php' );
			$this->load->view( 'layout/admin_footer' );
		} else {
			$search['dtStart']           = $this->input->post( 'dtStart' );
			$search['dtEnd']             = $this->input->post( 'dtEnd' );
			$search['szSearch1']         = $this->input->post( 'szSearch1' );
			$search['szSearch2']         = $this->input->post( 'szSearch2' );
			$search['szSearch3']         = $this->input->post( 'szSearch3' );
			$franchiseeDets              = $this->Webservices_Model->getuserdetails( $search['szSearch1'] );
			$ClientDets                  = $this->Webservices_Model->getuserdetails( $search['szSearch2'] );
			$SiteDets                    = $this->Webservices_Model->getuserdetails( $search['szSearch3'] );
			$fromdate                    = $this->Webservices_Model->formatdate( $search['dtStart'] );
			$todate                      = $this->Webservices_Model->formatdate( $search['dtEnd'] );
			$getTestList                 = $this->Form_Management_Model->getsosformdata( $search['szSearch3'], $fromdate, $todate, 1 );
			$data['franchiseearr']       = $getFranchisees;
			$data['franchisee']          = $franchiseeDets[0];
			$data['Client']              = $ClientDets[0];
			$data['Site']                = $SiteDets[0];
			$data['TestList']            = $getTestList;
			$data['franchiseearr']       = $getFranchisees;
			$data['pageName']            = "Reporting";
			$data['subpageName']         = "SOS_COC_Forms_Reports";
			$data['franchiseearr']       = $getFranchisees;
			$data['notification']        = $count;
			$data['socFr']               = $socFr;
			$data['sitearr']             = $siteAry;
			$data['clientarr']           = $clientAry;
			$data['commentnotification'] = $commentReplyNotiCount;
			$data['data']                = $data;
			$this->load->view( 'layout/admin_header', $data );
			$this->load->view( 'formManagement/sos-coc-formdetails.php' );
			$this->load->view( 'layout/admin_footer' );
		}
	}

	function endDate_check() {
		$searchAry = $_POST;
		$dtStart   = $this->Order_Model->getSqlFormattedDate( $searchAry['dtStart'] );
		$dtEnd     = $this->Order_Model->getSqlFormattedDate( $searchAry['dtEnd'] );


		if ( ( $dtStart ) > ( $dtEnd ) ) {
			$this->form_validation->set_message( 'endDate_check', 'Test Date To should be greater than Test Date From.' );

			return false;
		} else {
			return true;
		}

	}

	function sosFormsdata() {
		$idsite   = $this->input->post( 'idsite' );
		$idClient = $this->input->post( 'idClient' );
		$this->session->set_userdata( 'idClient', $idClient );
		$this->session->set_userdata( 'idsite', $idsite );
		echo "SUCCESS||||";
		echo "sosForm";
	}

	function sosForm() {
		$is_user_login = is_user_login( $this );
		// redirect to dashboard if already logged in
		if ( ! $is_user_login ) {
			ob_end_clean();
			redirect( base_url( '/admin/admin_login' ) );
			die;
		}
		$count                       = $this->Admin_Model->getnotification();
		$commentReplyNotiCount       = $this->Forum_Model->commentReplyNotifications();
		$idsite                      = $this->session->userdata( 'idsite' );
		$idClient                    = $this->session->userdata( 'idClient' );
		$sosRormDetailsAry           = $this->Form_Management_Model->getsosFormDetails( $idClient, 1 );
		$data['idClient']            = $idClient;
		$data['idsite']              = $idsite;
		$data['data']                = $data;
		$data['notification']        = $count;
		$data['commentnotification'] = $commentReplyNotiCount;
		$data['szMetaTagTitle']      = "Form Management";
		$data['is_user_login']       = $is_user_login;
		$data['pageName']            = "Form_Management";
		$data['sosRormDetailsAry']   = $sosRormDetailsAry;
		$this->load->view( 'layout/admin_header', $data );
		$this->load->view( 'formManagement/sosForm' );
		$this->load->view( 'layout/admin_footer' );
	}

	function ViewSosFormPdfData() {
		$idClient = $this->input->post( 'idClient' );
		$idsite   = $this->input->post( 'idsite' );
		$this->session->set_userdata( 'idClient', $idClient );
		$this->session->set_userdata( 'idsite', $idsite );
		echo "SUCCESS||||";
		echo "pdf_sosform";
	}

	public function pdf_sosform() {
		$this->load->library( 'Pdf' );
		$pdf = new Pdf( 'P', 'mm', 'A4', true, 'UTF-8', false );
		$pdf->SetCreator( PDF_CREATOR );
		$pdf->SetTitle( 'Drug-safe Form Management report' );
		$pdf->SetAuthor( 'Drug-safe' );
		$pdf->SetSubject( 'Form Management Report PDF' );
		$pdf->SetMargins( PDF_MARGIN_LEFT - 10, PDF_MARGIN_TOP - 18, PDF_MARGIN_RIGHT - 10 );
		$pdf->SetAutoPageBreak( true, PDF_MARGIN_BOTTOM );
// set image scale factor
		$pdf->setImageScale( PDF_IMAGE_SCALE_RATIO );
		$pdf->SetDisplayMode( 'real', 'default' );
		$pdf->setPrintHeader( false );
		$pdf->setPrintFooter( false );
// set default monospaced font
		$pdf->SetDefaultMonospacedFont( PDF_FONT_MONOSPACED );
		$pdf->SetFont( 'times', '', 12 );
		// Add a page
		$pdf->AddPage();
		$idClient          = $this->session->userdata( 'idClient' );
		$idsite            = $this->session->userdata( 'idsite' );
		$sosRormDetailsAry = $this->Form_Management_Model->getsosFormDetails( $idClient, 1 );

		$html              = '       
        <a style="text-align:center;  margin-bottom:5px;" href="' . __BASE_URL__ . '" ><img style="width:145px" src="' . __BASE_URL__ . '/images/logo.png" alt="logo" class="logo-default" /> </a>
            <div><p style="text-align:center; font-size:18px; margin-bottom:5px; color:black"><b>Form Management Report</b></p></div>
        
                        <div>
                             <lable><b>Requesting Client :</b> ' . $sosRormDetailsAry['szName'] . '</lable>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp;  &nbsp; &nbsp;  &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <lable><b>City :</b> ' . $sosRormDetailsAry['szCity'] . '</lable>  
                             
                        </div>
                        
                         <div>
                             <lable><b>Country :</b> ' . $sosRormDetailsAry['szCountry'] . '</lable>  &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp;  &nbsp; &nbsp;  &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  <lable><b>Address :</b> ' . $sosRormDetailsAry['szAddress'] . '</lable> 
                        </div>
                        <div>
                             <lable><b>State :</b> ' . $sosRormDetailsAry['szState'] . '</lable> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp;  &nbsp; &nbsp;  &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <lable><b>ZIP/Postal Code :</b> ' . $sosRormDetailsAry['szZipCode'] . '</lable>  
                        </div>
                        
                        <div>
                             <lable><b>Service Commenced On :</b> ' . $sosRormDetailsAry['ServiceCommencedOn'] . '</lable>   &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  <lable><b>Service Concluded On :</b> ' . $sosRormDetailsAry['ServiceConcludedOn'] . '</lable>  
                        </div>';
		$html              .= '
                  
                    
                  
        <div class= "table-responsive" >
                            <table border="1" cellpadding="5">
                                    <tr>
                                        <th> <b>Emp/Con.</b> </th>
                                        <th><b> Donar Name</b> </th>
                                        <th><b> Result</b> </th>
                                        <th><b> Drug </b> </th>
                                        <th> <b>Alcohol</b> </th>
                                        <th> <b>Lab</b> </th>
                                   
                                    </tr>';
		if ( $sosRormDetailsAry ) {
			$donarDetailBySosIdAry = $this->Form_Management_Model->getDonarDetailBySosId( $idsite );
			if ( ! empty( $donarDetailBySosIdAry ) ) {
				$i = 0;
				foreach ( $donarDetailBySosIdAry as $donarDetailBySosIdData ) {
					$html .= '<tr>
                                            <td>' . $donarDetailBySosIdData['id'] . ' </td>
                                            <td>' . $donarDetailBySosIdData['donerName'] . ' </td>
                                            <td>' . ( $donarDetailBySosIdData['result'] == 0 ? 'Negative' : 'Positive' ) . '</td>
                                            <td>' . $donarDetailBySosIdData['drug'] . ' </td>
                                            <td>' . ( $donarDetailBySosIdData['alcohol'] == 0 ? 'Negative' : 'Positive' ) . '</td>
                                            <td>' . $donarDetailBySosIdData['lab'] . ' </td>
                                        </tr>';
				}
			} else {
				$html .= '<tr>
                            <td align="center" colspan="6">Not Found</td>
                        </tr>';
			}
		}
		$i ++;
		$html .= '
                            </table>
                        </div>  
                        <hr>
                        <div class="table-responsive">
                            <table  border="1" cellpadding="5">
                                <thead>
                                    <tr>
                                        <th><b>* U = Result Requiring Further  Testing N = Negative <br> ** P = Positive N = Negative</b> </th>                                        
                                        <th><b> Urine </b></th>
                                        <th><b> Oral</b></th>  
                                    </tr>
                                </thead>
                                <tbody>
                                        <tr>
                                            <td>Total Donar Screenings/Collections </td>
                                            <td>' . $sosRormDetailsAry['TotalDonarScreeningUrine'] . '</td>
                                            <td> ' . $sosRormDetailsAry['TotalDonarScreeningOral'] . ' </td>
                                        </tr>
                                         <tr>
                                            <td> Negative Results</td>
                                            <td>' . $sosRormDetailsAry['NegativeResultOral'] . '</td>
                                            <td>' . $sosRormDetailsAry['NegativeResultOral'] . '</td>
                                        </tr>
                                         <tr>
                                            <td> Result Requiring Further Testing </td>
                                            <td>' . $sosRormDetailsAry['FurtherTestUrine'] . '</td>
                                            <td>' . $sosRormDetailsAry['FurtherTestOral'] . ' </td>
                                        </tr>
                                      
                                </tbody>
                            </table>
                        </div>
                        <hr>
                       <div>
                            <lable><b>Total No Alcohol Screens : </b> ' . $sosRormDetailsAry['TotalAlcoholScreening'] . '</lable> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  <lable><b>Positive Alcohol Results : </b> ' . $sosRormDetailsAry['PositiveAlcohol'] . '</lable>
                        </div>
                         <div>
                            <lable><b>Refusals , No Shows or Others : </b> ' . $sosRormDetailsAry['Refusals'] . '</lable>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; <lable><b>Negative Alcohol Results :</b> ' . $sosRormDetailsAry['NegativeAlcohol'] . '</lable>
                        </div>
                        <hr>
                         <div>
                            <lable><b>Device Name : </b> ' . $sosRormDetailsAry['DeviceName'] . '</lable> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;   &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; <lable><b>Breath Testing Unit : </b> ' . $sosRormDetailsAry['BreathTesting'] . '</lable>
                        </div> 
                         <div>
                            <lable><b>Extra Used :</b> ' . $sosRormDetailsAry['ExtraUsed'] . '</lable>
                        </div>
                        <hr>
                         <div>
                          <p>I/we <b>' . $sosRormDetailsAry['CollectorName'] . '</b> conducted the alcohol and/or drugscreening/collection service detailed above and confirm that all procedures were undertaken in accordance with the relevant Standard.</p><b>Collector Signature : </b>' . $sosRormDetailsAry['CollectorSignature'] . '</div>
                        </div>
                      <hr>
                      <div>
                          <p><b>Comments or Observation : </b>' . $sosRormDetailsAry['Comments'] . '</div>
                        </div>
                      <hr>
                        <div>
                            <lable><b>Nominated Client Representative :</b> ' . $sosRormDetailsAry['ClientRepresentative'] . '</lable> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp;<lable><b>Signed : </b> ' . $sosRormDetailsAry['RepresentativeSignature'] . '</lable>
                        </div>
                         <div>
                          <lable><b>Status :</b> ' . ( $sosRormDetailsAry['Status'] == 0 ? 'Not Completed' : 'Completed' ) . '</lable>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;  &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; <lable><b>Time :</b> ' . $sosRormDetailsAry['RepresentativeSignatureTime'] . '</lable> 
                        </div>';
		$pdf->writeHTML( $html, true, false, true, false, '' );
		ob_end_clean();
		$pdf->Output( 'Drugsafe_Form_Management_report.pdf', 'I' );
	}

	function cocFormDetails() {
		$count                 = $this->Admin_Model->getnotification();
		$commentReplyNotiCount = $this->Forum_Model->commentReplyNotifications();
		$is_user_login         = is_user_login( $this );
		// redirect to dashboard if already logged in
		if ( ! $is_user_login ) {
			ob_end_clean();
			redirect( base_url( '/admin/admin_login' ) );
			die;
		}
		$data['notification']        = $count;
		$data['commentnotification'] = $commentReplyNotiCount;
		$data['szMetaTagTitle']      = "Form Management";
		$data['is_user_login']       = $is_user_login;
		$data['pageName']            = "Form_Management";
		$this->load->view( 'layout/admin_header', $data );
		$this->load->view( 'formManagement/cocForm' );
		$this->load->view( 'layout/admin_footer' );
	}

	function ViewDonorDetailsData() {
		$idsos = $this->input->post( 'idsos' );
		$this->session->set_userdata( 'idsos', $idsos );
		echo "SUCCESS||||";
		echo "ViewDonorDetails";
	}

	function ViewDonorDetails() {
		$idsos                 = $this->session->userdata( 'idsos' );
		$count                 = $this->Admin_Model->getnotification();
		$commentReplyNotiCount = $this->Forum_Model->commentReplyNotifications();
		$is_user_login         = is_user_login( $this );
		// redirect to dashboard if already logged in
		if ( ! $is_user_login ) {
			ob_end_clean();
			redirect( base_url( '/admin/admin_login' ) );
			die;
		}
		$DonorDetailsAry             = $this->Form_Management_Model->getActiveDonorDetailsBySosId( $idsos );
		$data['notification']        = $count;
		$data['commentnotification'] = $commentReplyNotiCount;
		$data['idsos']               = $idsos;
		$data['szMetaTagTitle']      = "Donor Details";
		$data['DonorDetailsAry']     = $DonorDetailsAry;
		$data['is_user_login']       = $is_user_login;
		$data['pageName']            = "Form_Management";
		$this->load->view( 'layout/admin_header', $data );
		$this->load->view( 'formManagement/donorDetailsList' );
		$this->load->view( 'layout/admin_footer' );
	}

	function ViewCocFormData() {
		$idcoc = $this->input->post( 'idcoc' );
		$idsos = $this->input->post( 'idsos' );
		$this->session->set_userdata( 'idsos', $idsos );
		$this->session->set_userdata( 'idcoc', $idcoc );
		echo "SUCCESS||||";
		echo "ViewCocForm";
	}

	function ViewCocForm() {
		$idcoc                 = $this->session->userdata( 'idcoc' );
		$idsos                 = $this->session->userdata( 'idsos' );
		$count                 = $this->Admin_Model->getnotification();
		$commentReplyNotiCount = $this->Forum_Model->commentReplyNotifications();
		$is_user_login         = is_user_login( $this );
		// redirect to dashboard if already logged in
		if ( ! $is_user_login ) {
			ob_end_clean();
			redirect( base_url( '/admin/admin_login' ) );
			die;
		}
		$cocFormDetailsAry           = $this->Form_Management_Model->getCocFormDetailsByCocId( $idcoc );
		$data['notification']        = $count;
		$data['commentnotification'] = $commentReplyNotiCount;
		$data['idcoc']               = $idcoc;
		$data['idsos']               = $idsos;
		$data['szMetaTagTitle']      = "Donor Details";
		$data['cocFormDetailsAry']   = $cocFormDetailsAry;
		$data['is_user_login']       = $is_user_login;
		$data['pageName']            = "Form_Management";
		$this->load->view( 'layout/admin_header', $data );
		$this->load->view( 'formManagement/cocForm' );
		$this->load->view( 'layout/admin_footer' );
	}

	function getsosformpdf() {
		$sosid = $this->input->post( 'sosid' );
		$this->session->set_userdata( 'sosid', $sosid );
		$hide = $this->input->post( 'hide' );
		$this->session->set_userdata( 'hide', $hide );
		echo "SUCCESS||||";
		echo "sosformpdf";
	}

	public function sosformpdf() {
		ob_start();
        $sosid          = $this->session->userdata( 'sosid' );
        $hide           = $this->session->userdata( 'hide' );
        $sosdetarr      = $this->Webservices_Model->getsosformdatabysosid( $sosid );
        $usertype       = $this->Webservices_Model->getuserdetails( $sosdetarr[0]['createdBy'] );
        $sosuserdets    = $this->Webservices_Model->getuserhierarchybysiteid( $sosdetarr[0]['Clientid'] );
        $franchiseeDets = $this->Webservices_Model->getuserdetails( $sosuserdets[0]['franchiseeId'] );
        $ClientDets     = $this->Webservices_Model->getuserdetails( $sosuserdets[0]['clientType'] );
        $ClientBusinessDetArr = $this->Webservices_Model->getclientdetailsbyclientid( $sosuserdets[0]['clientType'] );
        $SiteDets       = $this->Webservices_Model->getuserdetails( $sosdetarr[0]['Clientid'] );
        $testtypesarr   = explode( ',', $sosdetarr[0]['Drugtestid'] );
        $donorsarr      = $this->Webservices_Model->getdonorsbysosid( $sosid );
        $userprods      = $this->Webservices_Model->getsavedkitsbysosid( $sosid, 1 );
        $getState       = $this->Franchisee_Model->getStateByFranchiseeId( $sosuserdets[0]['franchiseeId'] );
        $franchiseecode = $this->Franchisee_Model->getusercodebyuserid( $ClientDets[0]['id'] );
        $SFArr   = explode( ',', $sosdetarr[0]['screening_facilities'] );

        $_SESSION['PDF-TESTDATE'] = 'Drug Test Date: ' . date( 'd/m/Y', strtotime( $sosdetarr[0]['testdate'] ) );

		$this->load->library( 'Pdf' );
		$pdf = new Pdf( 'P', 'mm', 'A4', true, 'UTF-8', false );
		$pdf->SetCreator( PDF_CREATOR );
		$pdf->SetTitle( 'Drug-safe SOS Form Details' );
		$pdf->SetAuthor( 'Drug-safe' );
		$pdf->SetSubject( 'SOS Form PDF' );

		$pdf->SetDisplayMode( 'real', 'default' );
        $pdf->setPrintHeader( false );
		$pdf->setPrintFooter( true );
        $pdf->setFooterData(array(0,64,0), array(0,64,128));
		$pdf->SetDefaultMonospacedFont( PDF_FONT_MONOSPACED );
        $pdf->SetMargins( PDF_MARGIN_LEFT - 10, PDF_MARGIN_TOP - 15, PDF_MARGIN_RIGHT - 10);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak( true, PDF_MARGIN_BOTTOM - 15 );
        $pdf->setImageScale( PDF_IMAGE_SCALE_RATIO );
		$pdf->SetFont( 'times', '', 8 );


        $pdf->AddPage( 'P' );
        $pnum =  $pdf->getNumPages();
		if ( ! empty( $testtypesarr ) ) {
			if ( $testtypesarr[0] == '1' ) {
				$alchohol = true;
			} else if ( $testtypesarr[0] == '2' ) {
				$oral = true;
			} else if ( $testtypesarr[0] == '3' ) {
				$urineasnza = true;
			} else if ( $testtypesarr[0] == '4' ) {
				$asnza = true;
			} else if ( $testtypesarr[0] == '5' ) {
                $other = true;
            }
			if ( $testtypesarr[1] == '1' ) {
				$alchohol = true;
			} else if ( $testtypesarr[1] == '2' ) {
				$oral = true;
			} else if ( $testtypesarr[1] == '3' ) {
				$urineasnza = true;
			} else if ( $testtypesarr[1] == '4' ) {
				$asnza = true;
			} else if ( $testtypesarr[1] == '5' ) {
                $other = true;
            }
			if ( $testtypesarr[2] == '1' ) {
				$alchohol = true;
			} else if ( $testtypesarr[2] == '2' ) {
				$oral = true;
			} else if ( $testtypesarr[2] == '3' ) {
				$urineasnza = true;
			} else if ( $testtypesarr[2] == '4' ) {
				$asnza = true;
			} else if ( $testtypesarr[2] == '5' ) {
                $other = true;
            }
			if ( $testtypesarr[3] == '1' ) {
				$alchohol = true;
			} else if ( $testtypesarr[3] == '2' ) {
				$oral = true;
			} else if ( $testtypesarr[3] == '3' ) {
				$urineasnza = true;
			} else if ( $testtypesarr[3] == '4' ) {
				$asnza = true;
			} else if ( $testtypesarr[3] == '5' ) {
                $other = true;
            }
            if ( $testtypesarr[4] == '1' ) {
                $alchohol = true;
            } else if ( $testtypesarr[4] == '2' ) {
                $oral = true;
            } else if ( $testtypesarr[4] == '3' ) {
                $urineasnza = true;
            } else if ( $testtypesarr[4] == '4' ) {
                $asnza = true;
            } else if ( $testtypesarr[4] == '5' ) {
                $other = true;
            }
		}
		$drugteststring = '';
		if ( $alchohol ) {
			$drugteststring = 'Alcohol, ';
		}
		if ( $oral ) {
			$drugteststring .= 'Oral Fluid, ';
		}
		if ( $urineasnza ) {
			$drugteststring .= 'Urine, ';
		}
		if ( $asnza ) {
			$drugteststring .= 'AS/NZA 4308:2008, ';
		}
        if ( $other ) {
            $drugteststring .= 'Other: '.$sosdetarr[0]['other_drug_test'].', ';
        }
        if ( ! empty( $SFArr ) ) {
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
        if ( $inHouse ) {
            $SFString .= 'In House, ';
        }
        if ( $onClinic ) {
            $SFString .= 'Mobile Clinic, ';
        }

		$drugteststring = substr( trim( $drugteststring ), 0, - 1 );
        $SFString = substr( trim( $SFString ), 0, - 1 );
		$html           = '<a style="text-align:center;  margin-bottom:0px;" href="' . __BASE_URL__ . '" ><img style="width:100px" src="' . __BASE_URL__ . '/images/logo.png" alt="logo" class="logo-default" /> </a>
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
                                        <td colspan="3" align="left">Client Code: ' . ( ! empty( $franchiseecode['userCode'] ) ? $franchiseecode['userCode'] : 'N/A' ) . '</td><td align="left" colspan="3">Requesting Client: ' . $ClientBusinessDetArr[0]['szBusinessName'] . '</td>
                                        <td colspan="2">Date: ' . date( 'd/m/Y', strtotime( $sosdetarr[0]['testdate'] ) ) . '</td>
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
		if ( ! empty( $donorsarr ) ) {
			$html  .= '<tr>
                                                <td><b>#</b></td>
                                                <td><b>Donor Name</b></td>
                                                <td><b>Result*</b></td>
                                                <td colspan="2"><b>Drug</b></td>
                                                <td colspan="2"><b>Alcohol**</b></td>
                                                <td><b>Lab</b></td>
                                            </tr>';
			$count = 1;
			foreach ( $donorsarr as $donors ) {
				$drugs   = '';
				$drugarr = explode( ',', $donors['drug'] );
				if ( $drugarr[0] == '1' ) {
					$drugs .= 'Ice-Methamphetamine(mAmp)<br>';
				} else if ( $drugarr[1] == '1' ) {
					$drugs .= 'Ice-Methamphetamine(mAmp)<br>';
				} else if ( $drugarr[2] == '1' ) {
					$drugs .= 'Ice-Methamphetamine(mAmp)<br>';
				} else if ( $drugarr[3] == '1' ) {
					$drugs .= 'Ice-Methamphetamine(mAmp)<br>';
				} else if ( $drugarr[4] == '1' ) {
					$drugs .= 'Ice-Methamphetamine(mAmp)<br>';
				} else if ( $drugarr[5] == '1' ) {
					$drugs .= 'Ice-Methamphetamine(mAmp)<br>';
				} else if ( $drugarr[6] == '1' ) {
                    $drugs .= 'Ice-Methamphetamine(mAmp)<br>';
                }
				if ( $drugarr[0] == '2' ) {
					$drugs .= 'THC-Marijuana(THC)<br>';
				} else if ( $drugarr[1] == '2' ) {
					$drugs .= 'THC-Marijuana(THC)<br>';
				} else if ( $drugarr[2] == '2' ) {
					$drugs .= 'THC-Marijuana(THC)<br>';
				} else if ( $drugarr[3] == '2' ) {
					$drugs .= 'THC-Marijuana(THC)<br>';
				} else if ( $drugarr[4] == '2' ) {
					$drugs .= 'THC-Marijuana(THC)<br>';
				} else if ( $drugarr[5] == '2' ) {
					$drugs .= 'THC-Marijuana(THC)<br>';
				} else if ( $drugarr[6] == '2' ) {
                    $drugs .= 'THC-Marijuana(THC)<br>';
                }
				if ( $drugarr[0] == '3' ) {
					$drugs .= 'Heroine-Opiates(OPI)<br>';
				} else if ( $drugarr[1] == '3' ) {
					$drugs .= 'Heroine-Opiates(OPI)<br>';
				} else if ( $drugarr[2] == '3' ) {
					$drugs .= 'Heroine-Opiates(OPI)<br>';
				} else if ( $drugarr[3] == '3' ) {
					$drugs .= 'Heroine-Opiates(OPI)<br>';
				} else if ( $drugarr[4] == '3' ) {
					$drugs .= 'Heroine-Opiates(OPI)<br>';
				} else if ( $drugarr[5] == '3' ) {
					$drugs .= 'Heroine-Opiates(OPI)<br>';
				} else if ( $drugarr[6] == '3' ) {
                    $drugs .= 'Heroine-Opiates(OPI)<br>';
                }
				if ( $drugarr[0] == '4' ) {
					$drugs .= 'Cocaine-Cocaine(COC)<br>';
				} else if ( $drugarr[1] == '4' ) {
					$drugs .= 'Cocaine-Cocaine(COC)<br>';
				} else if ( $drugarr[2] == '4' ) {
					$drugs .= 'Cocaine-Cocaine(COC)<br>';
				} else if ( $drugarr[3] == '4' ) {
					$drugs .= 'Cocaine-Cocaine(COC)<br>';
				} else if ( $drugarr[4] == '4' ) {
					$drugs .= 'Cocaine-Cocaine(COC)<br>';
				} else if ( $drugarr[5] == '4' ) {
					$drugs .= 'Cocaine-Cocaine(COC)<br>';
				} else if ( $drugarr[6] == '4' ) {
                    $drugs .= 'Cocaine-Cocaine(COC)<br>';
                }
				if ( $drugarr[0] == '5' ) {
					$drugs .= 'Benzodiazepines-Benzodiazepines(BZO)<br>';
				} else if ( $drugarr[1] == '5' ) {
					$drugs .= 'Benzodiazepines-Benzodiazepines(BZO)<br>';
				} else if ( $drugarr[2] == '5' ) {
					$drugs .= 'Benzodiazepines-Benzodiazepines(BZO)<br>';
				} else if ( $drugarr[3] == '5' ) {
					$drugs .= 'Benzodiazepines-Benzodiazepines(BZO)<br>';
				} else if ( $drugarr[4] == '5' ) {
					$drugs .= 'Benzodiazepines-Benzodiazepines(BZO)<br>';
				} else if ( $drugarr[5] == '5' ) {
					$drugs .= 'Benzodiazepines-Benzodiazepines(BZO)<br>';
				} else if ( $drugarr[6] == '5' ) {
                    $drugs .= 'Benzodiazepines-Benzodiazepines(BZO)<br>';
                }
				if ( $drugarr[0] == '6' ) {
					$drugs .= 'Amphetamine-Amphetamine(AMP)<br>';
				} else if ( $drugarr[1] == '6' ) {
					$drugs .= 'Amphetamine-Amphetamine(AMP)<br>';
				} else if ( $drugarr[2] == '6' ) {
					$drugs .= 'Amphetamine-Amphetamine(AMP)<br>';
				} else if ( $drugarr[3] == '6' ) {
					$drugs .= 'Amphetamine-Amphetamine(AMP)<br>';
				} else if ( $drugarr[4] == '6' ) {
					$drugs .= 'Amphetamine-Amphetamine(AMP)<br>';
				} else if ( $drugarr[5] == '6' ) {
					$drugs .= 'Amphetamine-Amphetamine(AMP)<br>';
				} else if ( $drugarr[6] == '6' ) {
                    $drugs .= 'Amphetamine-Amphetamine(AMP)<br>';
                }

                if ( $drugarr[0] == '7' ) {
                    $drugs .= 'Other<br>';
                } else if ( $drugarr[1] == '7' ) {
                    $drugs .= 'Other<br>';
                } else if ( $drugarr[2] == '7' ) {
                    $drugs .= 'Other<br>';
                } else if ( $drugarr[3] == '7' ) {
                    $drugs .= 'Other<br>';
                } else if ( $drugarr[4] == '7' ) {
                    $drugs .= 'Other<br>';
                } else if ( $drugarr[5] == '7' ) {
                    $drugs .= 'Other<br>';
                } else if ( $drugarr[6] == '7' ) {
                    $drugs .= 'Other<br>';
                }
				/*if ( ! empty( $donors['otherdrug'] ) ) {
					$drugs .= $donors['otherdrug'] . '<br>';
				}*/
				$alcoholread1 = '';
				$alcoholread2 = '';
				if ( $donors['alcoholreading1'] != '' ) {
					$alcoholread1 = $donors['alcoholreading1'];
				}
				if ( $donors['alcoholreading2'] != '' ) {
					$alcoholread2 = $donors['alcoholreading2'];
				}
				$html .= '<tr>
                                                <td>' . $count . '</td>
                                                <td>' . $donors['donerName'] . '</td>
                                                <td>' . ( ! empty( $drugs ) || $alcoholread1 != '' || $alcoholread2 != '' ? 'U' : 'N' ) . '</td>
                                                <td colspan="2">' . ( ! empty( $drugs ) ? $drugs : 'N/A' ) . '</td>
                                                <td colspan="2">' . ( ! empty( $alcoholread1 ) ? 'P' : 'N' ) . ', Reading One:' . ( ! empty( $alcoholread1 ) ? $alcoholread1 : 'N/A' ) . '<br/>' . ( ! empty( $alcoholread2 ) ? 'P' : 'N' ) . ', Reading Two:' . ( ! empty( $alcoholread2 ) ? $alcoholread2 : 'N/A' ) . '</td>
                                                <td>' . ( $drugs != ''? 'Y' : 'N' ) . '</td>
                                            </tr>';
				$count ++;
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
                                        <td colspan="8">Extra Used: '.$sosdetarr[0]['ExtraUsed'].'</td>
                                    </tr>
                                    <tr>
                                        <td colspan="8">I\'ve conducted the alcohol and/or drug screening/collection service detailed above and confirm that all procedures were undertaken in accordance with the relevant Standard. <b>Collector Signature:</b> <img  style="width:120px" src="' . __BASE_UPLOADED_SIGN_URL__ . $sosdetarr[0]['collsign'] . '"/></td>
                                    </tr>
                                    <tr>
                                    <td colspan="2">Collector Name: ' . $sosdetarr[0]['collname'] . '</td>
                                        <td colspan="6">Comments or Observation: ' . $sosdetarr[0]['Comments'] . '</td>
                                    </tr>';
		if ( $hide == '0' && ! empty( $userprods ) ) {
			$html .= '<tr>
                                        <td colspan="8"><b>Product Quantity Used</b></td>
                                    </tr>';
			foreach ( $userprods as $prods ) {
				$html .= '<tr>
                                        <td colspan="4">' . $prods['szProductCode'] . '</td><td colspan="4">' . $prods['quantity'] . '</td>
                                    </tr>';
			}
		}
		$html .= '
                                    <tr>
                                        <td colspan="4">Nominated Client Representative: ' . $ClientDets[0]['szName'] . '</td>
                                        <td colspan="2">Signature: <img style="width:120px" src="' . __BASE_UPLOADED_SIGN_URL__ . $sosdetarr[0]['RepresentativeSignature'] . '"/></td>
                                        <td colspan="2">Time: ' . $sosdetarr[0]['RepresentativeSignatureTime'] . '</td>
                                    </tr>
                                    ';
		if ( $hide == '0' && $usertype[0]['iRole'] == '6' ) {
			$html .= '<tr><td>Agent Comment</td><td colspan="7">' . ( ! empty( $sosdetarr[0]['agent_comment'] ) ? $sosdetarr[0]['agent_comment'] : 'N/A' ) . '</td></tr>';
		}
		$html .= '
                            </table>
                        </div>                      
                        ';
//		echo $pnum;
//		if($pnum>1){
//            $pdf->writeHTMLCell(0, 0, '', '', 'Drug Test Date - '.$pnum.' - '. date( 'd/m/Y', strtotime( $sosdetarr[0]['testdate'] ) ), 0, 1, 0, true, 'center', true);
//        }
		$pdf->writeHTML( $html, true, false, true, false, '' );
		ob_end_clean();
		$pdf->Output( 'view_sos_details.pdf', 'I' );
	}

	function getcocformpdf() {
		$cocid = $this->input->post( 'cocid' );
		$this->session->set_userdata( 'cocid', $cocid );
		echo "SUCCESS||||";
		echo "cocformpdf";
	}

	public function cocformpdf() {

		ob_start();
		$this->load->library( 'Pdf' );
		$pdf = new Pdf( 'P', 'mm', 'A4', true, 'UTF-8', false );
		$pdf->SetCreator( PDF_CREATOR );
		$pdf->SetTitle( 'Drug-safe COC Form Details' );
		$pdf->SetAuthor( 'Drug-safe' );
		$pdf->SetSubject( 'COC Form PDF' );
		$pdf->SetMargins( PDF_MARGIN_LEFT - 10, PDF_MARGIN_TOP - 20, PDF_MARGIN_RIGHT - 10 );
		$pdf->SetAutoPageBreak( true, PDF_MARGIN_BOTTOM - 15 );
		$pdf->setImageScale( PDF_IMAGE_SCALE_RATIO );
		$pdf->SetDisplayMode( 'real', 'default' );
		$pdf->setPrintHeader( false );
		$pdf->setPrintFooter( false );
		$pdf->SetDefaultMonospacedFont( PDF_FONT_MONOSPACED );
		$pdf->SetFont( 'times', '', 8 );
		$pdf->AddPage( 'P' );
		$cocid          = $this->session->userdata( 'cocid' );
		$cocdetarr      = $this->Webservices_Model->getcocdatabycocid( $cocid );
		$sosdetarr      = $this->Webservices_Model->getsosdatabycocid( $cocid, 1, 1 );
		$sosuserdets    = $this->Webservices_Model->getuserhierarchybysiteid( $sosdetarr[0]['Clientid'] );
		$franchiseeDets = $this->Webservices_Model->getuserdetails( $sosuserdets[0]['franchiseeId'] );
		$ClientDets     = $this->Webservices_Model->getuserdetails( $sosuserdets[0]['clientType'] );
        $ClientBusinessDetArr = $this->Webservices_Model->getclientdetailsbyclientid($sosuserdets[0]['clientType']);
		$SiteDets       = $this->Webservices_Model->getuserdetails( $sosdetarr[0]['Clientid'] );
		$getState       = $this->Franchisee_Model->getStateByFranchiseeId( $sosuserdets[0]['franchiseeId'] );
		if ( ! empty( $cocdetarr[0]['drugtest'] ) ) {
			$drugtype = explode( ',', $cocdetarr[0]['drugtest'] );
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
    <td colspan="4">Collection/Screen Date: ' . date( 'd/m/Y', strtotime( $cocdetarr[0]['cocdate'] ) ) . '</td>
    <td colspan="4">Name: ' . $sosdetarr[0]['donerName'] . '</td>
</tr>
<tr>
    <td colspan="4">Nominated Representative: ' . $ClientDets[0]['szName'] . '</td>
    <td colspan="4"></td>
</tr>
<tr>
    <td colspan="4">Client: ' . $ClientBusinessDetArr[0]['szBusinessName'] . '</td>
    <td colspan="4">DOB: ' . date( 'd/m/Y', strtotime( $cocdetarr[0]['dob'] ) ) . '</td>
</tr>
<tr>
    <td colspan="4">Collection Site: ' . $SiteDets[0]['szName'] . '</td>
    <td colspan="4">' . ( $cocdetarr[0]['employeetype'] == '1' ? 'Employee' : ( $cocdetarr[0]['employeetype'] == '2' ? 'Contractor' : '' ) ) . '</td>
</tr>
<tr>
    <td colspan="4">Drug to be tested: ';
		if ( ! empty( $drugtype ) ) {
			$drugtestList = '';
			foreach ( $drugtype as $key => $val ) {
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
			$html .= substr(trim($drugtestList),0,-1);
		}
		$html .= '</td>
    <td colspan="4">Contractor Details: ' . ( ! empty( $cocdetarr[0]['contractor'] ) ? $cocdetarr[0]['contractor'] : '' ) . '</td>
</tr>
<tr>
    <td colspan="4">Please Note: NATA/RCPA accreditation does not cover the performance of breath test</td>
    <td colspan="2">Identity Verified</td>
    <td>ID Type: ' . ( $cocdetarr[0]['idtype'] == '1' ? 'Driving License' : ( $cocdetarr[0]['idtype'] == '2' ? 'Photo ID Card' : ( $cocdetarr[0]['idtype'] == '3' ? 'Passport' : '' ) ) ) . '</td>
    <td>ID No: ' . $cocdetarr[0]['idnumber'] . '</td>
</tr>
<tr>
    <td colspan="5">Have you taken any medication, drugs or other non-prescription agents in last week? ' . $cocdetarr[0]['lastweekq'] . '<br />I consent to the testing of my breath/urine/oral fluid sample for alcohol &/or drugs.</td>
    <td colspan="3"> Donor Signature: <img style="width:120px" src="' . __BASE_UPLOADED_SIGN_URL__ . $cocdetarr[0]['donorsign'] . '" /></td>
</tr>
<tr>
    <td rowspan="2" colspan="2"><b>Alcohol Breath Test</b></td>
    <td colspan="2">Device Serial#: ' . $cocdetarr[0]['devicesrno'] . '</td>
    <td colspan="2">Cut off Level: ' . $cocdetarr[0]['cutoff'] . '</td>
    <td colspan="2">Wait Time<sub>[Minutes]</sub>: ' . $this->formatcustomTime( $cocdetarr[0]['donwaittime'] ) . '</td>
</tr>
<tr>
    <td>Test 1: ' . $cocdetarr[0]['dontest1'] . '</td>
    <td colspan="2">Time: ' . $this->formatcustomTime( $cocdetarr[0]['dontesttime1'] ) . ' hours</td>
    <td>Test 2: ' . $cocdetarr[0]['dontest2'] . '</td>
    <td>Time: ' . $this->formatcustomTime( $cocdetarr[0]['dontesttime2'] ) . ' hours</td>
</tr>
<tr>
    <td colspan="8"><b>Collection of Sample/On-Site Drug Screening Results</b></td>
</tr>
<tr>
    <td colspan="2">Void Time: ' . $this->formatcustomTime( $cocdetarr[0]['voidtime'] ) . ' hours</td>
    <td colspan="2">Sample Temp C: ' . $cocdetarr[0]['sampletempc'] . '</td>
    <td colspan="4">Temp Read Time within 4 min: ' . $this->formatcustomTime( $cocdetarr[0]['tempreadtime'] ) . ' hours</td>
</tr>
<tr>
    <td colspan="2">Adulterant Test Lot No.: ' . $cocdetarr[0]['intect'] . '</td>
    <td colspan="2">Expiry: ' . ( ! empty( $cocdetarr[0]['intect'] ) ? date( 'd/m/Y', strtotime( $cocdetarr[0]['intectexpiry'] ) ) : '' ) . '</td>
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
    <td colspan="2">Expiry: ' . ( date( 'd/m/Y', strtotime( $cocdetarr[0]['lotexpiry'] ) ) != '01/01/1970' && date( 'd/m/Y', strtotime( $cocdetarr[0]['lotexpiry'] ) ) != '30/11/-0001' ? date( 'd/m/Y', strtotime( $cocdetarr[0]['lotexpiry'] ) ) : 'N/A' ) . '</td>
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
    <td>' . ( $cocdetarr[0]['cocain'] == 'U' ? 'Further Testing Required' : ( $cocdetarr[0]['cocain'] == 'N' ? 'Negative' : '' ) ) . '</td>
    <td>' . ( $cocdetarr[0]['amp'] == 'U' ? 'Further Testing Required' : ( $cocdetarr[0]['amp'] == 'N' ? 'Negative' : '' ) ) . '</td>
    <td>' . ( $cocdetarr[0]['mamp'] == 'U' ? 'Further Testing Required' : ( $cocdetarr[0]['mamp'] == 'N' ? 'Negative' : '' ) ) . '</td>
    <td>' . ( $cocdetarr[0]['thc'] == 'U' ? 'Further Testing Required' : ( $cocdetarr[0]['thc'] == 'N' ? 'Negative' : '' ) ) . '</td>
    <td>' . ( $cocdetarr[0]['opiates'] == 'U' ? 'Further Testing Required' : ( $cocdetarr[0]['opiates'] == 'N' ? 'Negative' : '' ) ) . '</td>
    <td>' . ( $cocdetarr[0]['benzo'] == 'U' ? 'Further Testing Required' : ( $cocdetarr[0]['benzo'] == 'N' ? 'Negative' : '' ) ) . '</td>
    <td>' . ( $cocdetarr[0]['otherdc'] == 'U' ? 'Further Testing Required' : ( $cocdetarr[0]['otherdc'] == 'N' ? 'Negative' : '' ) ) . '</td>
</tr>
<tr><td colspan="8"><b>Collection time of sample:</b> ' . $this->formatcustomTime($cocdetarr[0]['ctstime']) . ' hours</td> </tr>
<tr>
    <td colspan="8" align="center"><b>Donor Declaration</b></td>
</tr>
<tr>
    <td colspan="8">I certify that the specimen(s) accompanying this form is my own. Where on-site screening was performed, such screening was carried out in my presence. In the case of my specimen(s) being sent to the laboratory for testing, I certify that the specimen containers were sealed with tamper evident seals in my presence and the identifying information on the label is correct. I certify that the information provided on this form to be correct and I consent to the release of all test results together with any relevant details contained on this form to the nominated representative of the requesting authority.</td>
</tr>
<tr>
    <td colspan="7">Donor Signature: <img style="width:120px" src="' . __BASE_UPLOADED_SIGN_URL__ . $cocdetarr[0]['donordecsign'] . '"/></td>
    <td>Date: ' . date( 'd/m/Y', strtotime( $cocdetarr[0]['donordecdate'] ) ) . '</td>
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
    <td colspan="4">Signature: <img style="width:120px" src="' . __BASE_UPLOADED_SIGN_URL__ . $cocdetarr[0]['collectorsignone'] . '"/></td>
    <td colspan="4">Signature: <img style="width:120px" src="' . __BASE_UPLOADED_SIGN_URL__ . $cocdetarr[0]['collectorsigntwo'] . '"/></td>
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
		$pdf->writeHTML( $html, true, false, true, false, '' );
		ob_end_clean();
		$pdf->Output( 'view_coc_details.pdf', 'I' );
	}

	function formatcustomTime( $time ) {
		$timeArr = explode( ':', $time );
		$timeval = "";
		if ( trim( $timeArr[0] ) > 0 ) {
			$timeval = sprintf( "%02d", trim( $timeArr[0] ) ) . ' : ' . sprintf( "%02d", trim( $timeArr[1] ) );
		}

		return $timeval;
	}

	function view_form_for_client() {
		$is_user_login = is_user_login( $this );
		// redirect to dashboard if already logged in
		if ( ! $is_user_login ) {
			ob_end_clean();
			redirect( base_url( '/admin/admin_login' ) );
			die;
		}
		$count                 = $this->Admin_Model->getnotification();
		$commentReplyNotiCount = $this->Forum_Model->commentReplyNotifications();

		$idClient = $_SESSION['drugsafe_user']['id'];

		$clientDetailsAray = $this->Franchisee_Model->viewClientDetails( $idClient );

		$franchiseId = $clientDetailsAray['franchiseeId'];
		$sitesArr    = $this->Webservices_Model->getclientdetails( $franchiseId,0, $idClient );


		$search['dtStart']   = $this->input->post( 'dtStart' );
		$search['dtEnd']     = $this->input->post( 'dtEnd' );
		$search['szSearch1'] = $this->input->post( 'szSearch1' );

		if ( ! empty( $search['dtStart'] ) ) {
			$fromdate = $this->Webservices_Model->formatdate( $search['dtStart'] );
		}
		if ( ! empty( $search['dtEnd'] ) ) {
			$todate = $this->Webservices_Model->formatdate( $search['dtEnd'] );
		}


		$getTestList = $this->Form_Management_Model->getsosformdataForClient( $idClient, $fromdate, $todate, 1, $search['szSearch1'] );
        $getFranchisees = '';
        $clientAry = '';
		$data['TestList']            = $getTestList;
		$data['pageName']            = "Client_Record";
		$data['subpageName']         = "SOS_COC_Forms_Reports";
		$data['franchiseearr']       = $getFranchisees;
		$data['notification']        = $count;
		$data['sitesArr']            = $sitesArr;
		$data['clientarr']           = $clientAry;
		$data['commentnotification'] = $commentReplyNotiCount;
		$data['data']                = $data;
		$this->load->view( 'layout/admin_header', $data );
		$this->load->view( 'formManagement/view_form_for_client.php' );
		$this->load->view( 'layout/admin_footer' );
	}

}
?>