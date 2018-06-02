<?php
defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );
class Reporting_Controller extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model( 'Order_Model' );
		$this->load->model( 'StockMgt_Model' );
		$this->load->library( 'pagination' );
		$this->load->model( 'Ordering_Model' );
		$this->load->model( 'Reporting_Model' );
		$this->load->model( 'Forum_Model' );
		$this->load->model( 'Error_Model' );
		$this->load->model( 'Admin_Model' );
		$this->load->model( 'Franchisee_Model' );
		$this->load->model( 'Inventory_Model' );
		$this->load->model( 'Form_Management_Model' );
		$this->load->model( 'StockMgt_Model' );
		$this->load->model( 'Webservices_Model' );
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
	function allstockreqlistData() {
		$flag = $this->input->post( 'flag' );
		$this->session->set_userdata( 'flag', $flag );
		echo "SUCCESS||||";
		echo "allstockreqlist";
	}
	function allstockreqlist() {
		if ( ! empty( $_POST ) ) {
			$this->session->unset_userdata( 'searchterm' );
		}
		$flag = $this->session->userdata( 'flag' );
		if ( $flag == 1 ) {
			$this->session->unset_userdata( 'searchterm' );
		}
		$is_user_login = is_user_login( $this );
		// redirect to dashboard if already logged in
		if ( ! $is_user_login ) {
			ob_end_clean();
			redirect( base_url( '/admin/admin_login' ) );
			die;
		}
		$searchAry = '';
		if ( ! empty( $_POST['szSearch'] ) && ! empty( $_POST['szSearch2'] ) ) {
			$searchItemFr   = $_POST['szSearch'];
			$searchItemProd = $_POST['szSearch'];
		} else {
			if ( isset( $_POST['szSearch'] ) && ! empty( $_POST['szSearch'] ) ) {
				$searchItem = $_POST['szSearch'];
			}
			if ( isset( $_POST['szSearch2'] ) && ! empty( $_POST['szSearch2'] ) ) {
				$searchItem = $_POST['szSearch2'];
			}
			$searchItemData = $this->Reporting_Model->searchterm_handler( $searchItem );
		}
		$count                 = $this->Admin_Model->getnotification();
		$commentReplyNotiCount = $this->Forum_Model->commentReplyNotifications();
		$config['base_url']    = __BASE_URL__ . "/reporting/allstockreqlist/";
		if ( ! empty( $_POST['szSearch'] ) && ! empty( $_POST['szSearch2'] ) ) {
			$config['total_rows'] = count( $this->Reporting_Model->getAllQtyRequestDetails( $searchAry, $limit, $offset, $searchItemData, 3 ) );
		} else {
			$config['total_rows'] = count( $this->Reporting_Model->getAllQtyRequestDetails( $searchAry, $limit, $offset, $searchItemData ) );
		}
		$config['per_page'] = __PAGINATION_RECORD_LIMIT__;
		$this->pagination->initialize( $config );
		if ( ! empty( $_POST['szSearch'] ) && ! empty( $_POST['szSearch2'] ) ) {
			$allReqQtyAray = $this->Reporting_Model->getAllQtyRequestDetails( $searchAry, $config['per_page'], $this->uri->segment( 3 ), $searchItemData, 3 );
		} else {
			$allReqQtyAray = $this->Reporting_Model->getAllQtyRequestDetails( $searchAry, $config['per_page'], $this->uri->segment( 3 ), $searchItemData );
		}
		$allQtyRequestListAray        = $this->Reporting_Model->getAllQtyRequestDetails( false, false, false, false, 1 );
		$allQtyProductRequestListAray = $this->Reporting_Model->getAllQtyRequestDetails( false, false, false, false, 2 );
		$data['allReqQtyAray']                = $allReqQtyAray;
		$data['allQtyProductRequestListAray'] = $allQtyProductRequestListAray;
		$data['allQtyRequestListAray']        = $allQtyRequestListAray;
		$data['szMetaTagTitle']               = "All Stock Requests";
		$data['is_user_login']                = $is_user_login;
		$data['pageName']                     = "Reporting";
		$data['subpageName']                  = "All_Stock_Requests";
		$data['notification']                 = $count;
		$data['commentnotification']          = $commentReplyNotiCount;
		$data['data']                         = $data;
		$this->load->view( 'layout/admin_header', $data );
		$this->load->view( 'reporting/stockRequestList' );
		$this->load->view( 'layout/admin_footer' );
	}
	function stockassignlistData() {
		$flag = $this->input->post( 'flag' );
		$this->session->set_userdata( 'flag', $flag );
		echo "SUCCESS||||";
		echo "stockassignlist";
	}
	function stockassignlist() {
		if ( ! empty( $_POST ) ) {
			$this->session->unset_userdata( 'searchtermAssign' );
		}
		$flag = $this->session->userdata( 'flag' );
		if ( $flag == 1 ) {
			$this->session->unset_userdata( 'searchtermAssign' );
		}
		$is_user_login = is_user_login( $this );
		// redirect to dashboard if already logged in
		if ( ! $is_user_login ) {
			ob_end_clean();
			redirect( base_url( '/admin/admin_login' ) );
			die;
		}
		$count                 = $this->Admin_Model->getnotification();
		$commentReplyNotiCount = $this->Forum_Model->commentReplyNotifications();
		$searchAry = '';
		if ( ! empty( $_POST['szSearch'] ) && ! empty( $_POST['szSearch2'] ) ) {
			$searchItemFr   = $_POST['szSearch'];
			$searchItemProd = $_POST['szSearch'];
		} else {
			if ( isset( $_POST['szSearch'] ) && ! empty( $_POST['szSearch'] ) ) {
				$searchItem = $_POST['szSearch'];
			}
			if ( isset( $_POST['szSearch2'] ) && ! empty( $_POST['szSearch2'] ) ) {
				$searchItem = $_POST['szSearch2'];
			}
			$searchItemData = $this->Reporting_Model->searchtermAssign_handler( $searchItem );
		}
		$config['base_url'] = __BASE_URL__ . "/reporting/stockassignlist/";
		if ( ! empty( $_POST['szSearch'] ) && ! empty( $_POST['szSearch2'] ) ) {
			$config['total_rows'] = count( $this->Reporting_Model->getAllQtyAssignDetails( $searchAry, $limit, $offset, false, 3 ) );
		} else {
			$config['total_rows'] = count( $this->Reporting_Model->getAllQtyAssignDetails( $searchAry, $limit, $offset, $searchItemData ) );
		}
		$config['per_page'] = __PAGINATION_RECORD_LIMIT__;
		$this->pagination->initialize( $config );
		if ( ! empty( $_POST['szSearch'] ) && ! empty( $_POST['szSearch2'] ) ) {
			$allQtyAssignAray = $this->Reporting_Model->getAllQtyAssignDetails( $searchAry, $config['per_page'], $this->uri->segment( 3 ), false, 3 );
		} else {
			$allQtyAssignAray = $this->Reporting_Model->getAllQtyAssignDetails( $searchAry, $config['per_page'], $this->uri->segment( 3 ), $searchItemData );
		}
		$allQtyAssignListAray        = $this->Reporting_Model->getAllQtyAssignDetails( false, false, false, false, 1 );
		$allQtyProductAssignListAray = $this->Reporting_Model->getAllQtyAssignDetails( false, false, false, false, 2 );
		$data['allQtyAssignAray']            = $allQtyAssignAray;
		$data['allQtyAssignListAray']        = $allQtyAssignListAray;
		$data['allQtyProductAssignListAray'] = $allQtyProductAssignListAray;
		$data['szMetaTagTitle']              = "Stock Assignments";
		$data['is_user_login']               = $is_user_login;
		$data['pageName']                    = "Reporting";
		$data['subpageName']                 = "Stock_Assignments";
		$data['notification']                = $count;
		$data['commentnotification']         = $commentReplyNotiCount;
		$data['data']                        = $data;
		$this->load->view( 'layout/admin_header', $data );
		$this->load->view( 'reporting/stockAssignList' );
		$this->load->view( 'layout/admin_footer' );
	}
	function ViewReqReportingPdfData() {
		$franchiseeName = $this->input->post( 'franchiseeName' );
		$productCode    = $this->input->post( 'productCode' );
		$this->session->set_userdata( 'productCode', $productCode );
		$this->session->set_userdata( 'franchiseeName', $franchiseeName );
		echo "SUCCESS||||";
		echo "pdfstockreqlist";
	}
	public function pdfstockreqlist() {
		ob_start();
		$this->load->library( 'Pdf' );
		$pdf = new Pdf( 'P', 'mm', 'A4', true, 'UTF-8', false );
		$pdf->SetCreator( PDF_CREATOR );
		$pdf->SetTitle( 'Drug-safe stock request report' );
		$pdf->SetAuthor( 'Drug-safe' );
		$pdf->SetSubject( 'Stock Request Report PDF' );
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
		$franchiseeName = $this->session->userdata( 'franchiseeName' );
		$productCode    = $this->session->userdata( 'productCode' );
		$allReqQtyAray = $this->Reporting_Model->getAllQtyRequestDetailsForPdf( $franchiseeName, $productCode );
		$html = '<a style="text-align:center;  margin-bottom:5px;" href="' . __BASE_URL__ . '" ><img style="width:145px" src="' . __BASE_URL__ . '/images/logo.png" alt="logo" class="logo-default" /> </a>
            <div><p style="text-align:center; font-size:18px; margin-bottom:5px; color:black"><b>Stock Request Report</b></p></div>
            <div class= "table-responsive" >
                            <table border="1" cellpadding="5">
                                    <tr>
                                        <th style="width:80px"><b> Id</b> </th>
                                        <th> <b>Franchisee</b> </th>
                                        <th> <b>Product Code</b> </th>
                                        <th style="width:150px"><b> Quantity Requested</b> </th>
                                        <th style="width:170px"> <b>Requested On</b> </th>
                                   
                                    </tr>';
		if ( $allReqQtyAray ) {
			$i = 0;
			foreach ( $allReqQtyAray as $allReqQtyData ) {
				$productDataAry = $this->Inventory_Model->getProductDetailsById( $allReqQtyData['iProductId'] );
				$franchiseeArr  = $this->Admin_Model->getAdminDetailsByEmailOrId( '', $allReqQtyData['iFranchiseeId'] );
				$html           .= '<tr>
                                            <td> FR-' . $allReqQtyData['iFranchiseeId'] . ' </td>
                                            <td> ' . $franchiseeArr['szName'] . '</td>
                                            <td> ' . $productDataAry['szProductCode'] . ' </td>
                                            <td>' . $allReqQtyData['szQuantity'] . ' </td>
                                             <td>' . date( 'd/m/Y h:i:s A', strtotime( $allReqQtyData['dtRequestedOn'] ) ) . ' </td>
                                
                                        </tr>';
			}
		}
		$i ++;
		$html .= '
                            </table>
                        </div>
                      
                        ';
		$pdf->writeHTML( $html, true, false, true, false, '' );
//    $pdf->Write(5, 'CodeIgniter TCPDF Integration');
		error_reporting( E_ALL );
		$this->session->unset_userdata( 'productCode' );
		$this->session->unset_userdata( 'franchiseeName' );
		$pdf->Output( 'stock-request-report.pdf', 'I' );
	}
	function excelstockreqlistData() {
		$franchiseeName = $this->input->post( 'franchiseeName' );
		$productCode    = $this->input->post( 'productCode' );
		$this->session->set_userdata( 'productCode', $productCode );
		$this->session->set_userdata( 'franchiseeName', $franchiseeName );
		echo "SUCCESS||||";
		echo "excelstockreqlist";
	}
	public function excelstockreqlist() {
		$this->load->library( 'excel' );
		$filename = 'Report';
		$title    = 'Stock request list';
		$file     = $filename . '-' . $title; //save our workbook as this file name
		$this->excel->setActiveSheetIndex( 0 );
		$this->excel->getActiveSheet()->setTitle( $filename );
		$this->excel->getActiveSheet()->setCellValue( 'A1', 'Franchisee Id' );
		$this->excel->getActiveSheet()->getStyle( 'A1' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'A1' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'A1' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'B1', 'Franchisee' );
		$this->excel->getActiveSheet()->getStyle( 'B1' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'B1' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'B1' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'C1', 'Product Code' );
		$this->excel->getActiveSheet()->getStyle( 'C1' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'C1' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'C1' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'D1', 'Quantity Request' );
		$this->excel->getActiveSheet()->getStyle( 'D1' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'D1' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'D1' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'E1', 'Requested On' );
		$this->excel->getActiveSheet()->getStyle( 'E1' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'E1' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'E1' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$franchiseeName = $this->session->userdata( 'franchiseeName' );
		$productCode    = $this->session->userdata( 'productCode' );
		$allReqQtyAray  = $this->Reporting_Model->getAllQtyRequestDetailsForPdf( $franchiseeName, $productCode );
		if ( ! empty( $allReqQtyAray ) ) {
			$i = 2;
			foreach ( $allReqQtyAray as $item ) {
				$this->excel->getActiveSheet()->setCellValue( 'A' . $i, $item['iFranchiseeId'] );
				$this->excel->getActiveSheet()->setCellValue( 'B' . $i, $item['szName'] );
				$this->excel->getActiveSheet()->setCellValue( 'C' . $i, $item['szProductCode'] );
				$this->excel->getActiveSheet()->setCellValue( 'D' . $i, $item['szQuantity'] );
				$this->excel->getActiveSheet()->setCellValue( 'E' . $i, date( 'd/m/Y h:i:s A', strtotime( $item['dtRequestedOn'] ) ) );
				$this->excel->getActiveSheet()->getColumnDimension( 'A' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'B' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'C' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'D' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'E' )->setAutoSize( true );
				$i ++;
			}
		}
		header( 'Content-Type: application/vnd.ms-excel' ); //mime type
		header( 'Content-Disposition: attachment;filename="' . $file . '"' ); //tell browser what's the file name
		header( 'Cache-Control: max-age=0' ); //no cache
//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
//if you want to save it as .XLSX Excel 2007 format
		$objWriter = PHPExcel_IOFactory::createWriter( $this->excel, 'Excel5' );
		$this->session->unset_userdata( 'productCode' );
		$this->session->unset_userdata( 'franchiseeName' );
//force user to download the Excel file without writing it to server's HD
		$objWriter->save( 'php://output' );
	}
	function ViewAssignReportingPdfData() {
		$franchiseeName = $this->input->post( 'franchiseeName' );
		$productCode    = $this->input->post( 'productCode' );
		$flag           = $this->input->post( 'flag' );
		$this->session->set_userdata( 'productCode', $productCode );
		$this->session->set_userdata( 'franchiseeName', $franchiseeName );
		$this->session->set_userdata( 'flag', $flag );
		echo "SUCCESS||||";
		echo "pdfstockassignlist";
	}
	public function pdfstockassignlist() {
		$this->load->library( 'Pdf' );
		$pdf = new Pdf( 'P', 'mm', 'A4', true, 'UTF-8', false );
		$pdf->SetCreator( PDF_CREATOR );
		$pdf->SetTitle( 'Drug-safe stock assignment report' );
		$pdf->SetAuthor( 'Drug-safe' );
		$pdf->SetSubject( 'Stock Assignment Report PDF' );
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
		$flag           = $this->session->userdata( 'flag' );
		$franchiseeName = $this->session->userdata( 'franchiseeName' );
		$productCode    = $this->session->userdata( 'productCode' );
		if ( $flag == 1 ) {
			$allQtyAssignAray = $this->Reporting_Model->getAllQtyAssignDetailsForPdf( $franchiseeName, $productCode );
		}
		$html = '       
        <a style="text-align:center;  margin-bottom:5px;" href="' . __BASE_URL__ . '" ><img style="width:145px" src="' . __BASE_URL__ . '/images/logo.png" alt="logo" class="logo-default" /> </a>
            <div><p style="text-align:center; font-size:18px; margin-bottom:5px; color:black"><b>Stock Assignment Report</b></p></div>
            <div class= "table-responsive" >
                            <table border="1" cellpadding="5">
                                    <tr>
                                        
                                     
                                         <th style="width:60px"><b>Id</b> </th>
                                         <th style="width:85px"><b> Franchisee </b> </th>
                                         <th style="width:70px"><b> Product Code</b> </th>
                                         <th style="width:70px"><b>Cost Per Item</b> </th>
                                         <th style="width:90px"><b> Total Cost For Quantity Assign</b> </th>
                                        <th style="width:80px"><b> Quantity Assigned</b> </th>
                                        <th style="width:80px"><b> Quantity Adjusted</b> </th>
                                         <th style="width:80px"><b> Available Quantity</b> </th>
                                        <th style="width:100px"> <b>Assigned On</b> </th>
                                   
                                    </tr>';
		if ( $allQtyAssignAray ) {
			$i = 0;
			foreach ( $allQtyAssignAray as $allQtyAssignData ) {
				$productDataAry = $this->Inventory_Model->getProductDetailsById( $allQtyAssignData['iProductId'] );
				$franchiseeArr  = $this->Admin_Model->getAdminDetailsByEmailOrId( '', $allQtyAssignData['iFranchiseeId'] );
				if ( $allQtyAssignData['quantityDeducted'] != 0 ) {
					$Qty             = $allQtyAssignData['quantityDeducted'];
					$Cost            = $allQtyAssignData['szProductCost'];
					$TotalCostPerQty = "(-) $" . ( $Qty * $Cost );
				} else {
					$Qty             = $allQtyAssignData['szQuantityAssigned'];
					$Cost            = $allQtyAssignData['szProductCost'];
					$TotalCostPerQty = "(+) $" . ( $Qty * $Cost );
				}
				$html .= '<tr>
                                            <td> FR-' . $allQtyAssignData['iFranchiseeId'] . ' </td>
                                            <td> ' . $franchiseeArr['szName'] . '</td>
                                            <td> ' . $allQtyAssignData['szProductCode'] . ' </td>
                                            <td> $' . $allQtyAssignData['szProductCost'] . ' </td>
                                            <td> $' . $TotalCostPerQty . ' </td>
                                            <td>' . $allQtyAssignData['szQuantityAssigned'] . ' </td>
                                            <td>' . $allQtyAssignData['quantityDeducted'] . ' </td>
                                            <td>' . $allQtyAssignData['szTotalAvailableQty'] . ' </td>
                                            <td> ' . date( 'd/m/Y h:i:s A', strtotime( $allQtyAssignData['dtAssignedOn'] ) ) . '  </td>
                                        </tr>';
			}
		}
		$i ++;
		$html .= '
                            </table>
                        </div>
                      
                        ';
		$pdf->writeHTML( $html, true, false, true, false, '' );
		ob_end_clean();
		$this->session->unset_userdata( '$flag' );
		$this->session->unset_userdata( 'productCode' );
		$this->session->unset_userdata( 'franchiseeName' );
		$pdf->Output( 'stock-assignment-report.pdf', 'I' );
	}
	function excelstockassignlistData() {
		$franchiseeName = $this->input->post( 'franchiseeName' );
		$productCode    = $this->input->post( 'productCode' );
		$this->session->set_userdata( 'productCode', $productCode );
		$this->session->set_userdata( 'franchiseeName', $franchiseeName );
		echo "SUCCESS||||";
		echo "excelstockassignlist";
	}
	public function excelstockassignlist() {
		$this->load->library( 'excel' );
		$filename = 'Report';
		$title    = 'Stock assignment';
		$file     = $filename . '-' . $title; //save our workbook as this file name
		$this->excel->setActiveSheetIndex( 0 );
		$this->excel->getActiveSheet()->setTitle( $filename );
		$this->excel->getActiveSheet()->setCellValue( 'A1', 'Franchisee Id' );
		$this->excel->getActiveSheet()->getStyle( 'A1' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'A1' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'A1' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'B1', 'Franchisee' );
		$this->excel->getActiveSheet()->getStyle( 'B1' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'B1' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'B1' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'C1', 'Product Code' );
		$this->excel->getActiveSheet()->getStyle( 'C1' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'C1' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'C1' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'D1', 'Cost Per Item' );
		$this->excel->getActiveSheet()->getStyle( 'D1' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'D1' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'D1' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'E1', 'Total Cost For Quantity Assign' );
		$this->excel->getActiveSheet()->getStyle( 'E1' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'E1' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'E1' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'F1', 'Quantity Assigned' );
		$this->excel->getActiveSheet()->getStyle( 'F1' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'F1' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'F1' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'G1', 'Quantity Adjusted' );
		$this->excel->getActiveSheet()->getStyle( 'G1' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'G1' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'G1' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'H1', 'Total available quantity' );
		$this->excel->getActiveSheet()->getStyle( 'H1' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'H1' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'H1' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'I1', 'Assigned On' );
		$this->excel->getActiveSheet()->getStyle( 'I1' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'I1' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'I1' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$franchiseeName   = $this->session->userdata( 'franchiseeName' );
		$productCode      = $this->session->userdata( 'productCode' );
		$allQtyAssignAray = $this->Reporting_Model->getAllQtyAssignDetailsForPdf( $franchiseeName, $productCode );
		if ( ! empty( $allQtyAssignAray ) ) {
			$i = 2;
			foreach ( $allQtyAssignAray as $item ) {
				if ( $item['quantityDeducted'] != 0 ) {
					$Qty             = $item['quantityDeducted'];
					$Cost            = $item['szProductCost'];
					$TotalCostPerQty = "(-) $" . ( $Qty * $Cost );
				} else {
					$Qty             = $item['szQuantityAssigned'];
					$Cost            = $item['szProductCost'];
					$TotalCostPerQty = "(+) $" . ( $Qty * $Cost );
				}
				$this->excel->getActiveSheet()->setCellValue( 'A' . $i, $item['iFranchiseeId'] );
				$this->excel->getActiveSheet()->setCellValue( 'B' . $i, $item['szName'] );
				$this->excel->getActiveSheet()->setCellValue( 'C' . $i, $item['szProductCode'] );
				$this->excel->getActiveSheet()->setCellValue( 'D' . $i, $item['szProductCost'] );
				$this->excel->getActiveSheet()->setCellValue( 'E' . $i, $TotalCostPerQty );
				$this->excel->getActiveSheet()->setCellValue( 'F' . $i, $item['szQuantityAssigned'] );
				$this->excel->getActiveSheet()->setCellValue( 'G' . $i, $item['quantityDeducted'] );
				$this->excel->getActiveSheet()->setCellValue( 'H' . $i, $item['szTotalAvailableQty'] );
				$this->excel->getActiveSheet()->setCellValue( 'I' . $i, date( 'd/m/Y h:i:s A', strtotime( $item['dtAssignedOn'] ) ) );
				$this->excel->getActiveSheet()->getColumnDimension( 'A' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'B' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'C' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'D' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'E' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'F' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'G' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'H' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'I' )->setAutoSize( true );
				$i ++;
			}
		}
		header( 'Content-Type: application/vnd.ms-excel' ); //mime type
		header( 'Content-Disposition: attachment;filename="' . $file . '"' ); //tell browser what's the file name
		header( 'Cache-Control: max-age=0' ); //no cache
//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
//if you want to save it as .XLSX Excel 2007 format
		$objWriter = PHPExcel_IOFactory::createWriter( $this->excel, 'Excel5' );
//force user to download the Excel file without writing it to server's HD
		//Session Unset
		$this->session->unset_userdata( 'productCode' );
		$this->session->unset_userdata( 'franchiseeName' );
		//end session Unset
		$objWriter->save( 'php://output' );
	}
	function frstockreqlist() {
		if ( empty( $_POST ) || empty( $_POST['szSearchProdCode'] ) ) {
			$this->session->unset_userdata( 'searchterm' );
		}
		$is_user_login = is_user_login( $this );
		// redirect to dashboard if already logged in
		if ( ! $is_user_login ) {
			ob_end_clean();
			redirect( base_url( '/admin/admin_login' ) );
			die;
		}
		$searchAryData = $_POST['szSearchProdCode'];
		$searchAry     = $this->Reporting_Model->searchterm_handler( $searchAryData );
		$franchiseeId  = $_SESSION['drugsafe_user']['id'];
		$config['base_url']   = __BASE_URL__ . "/reporting/frstockreqlist/";
		$config['total_rows'] = count( $this->Reporting_Model->getFrAllQtyRequestDetails( $searchAry, $limit, $offset, $franchiseeId ) );
		$config['per_page']   = __PAGINATION_RECORD_LIMIT__;
		$this->pagination->initialize( $config );
		$frAllReqQtyAray         = $this->Reporting_Model->getFrAllQtyRequestDetails( $searchAry, $config['per_page'], $this->uri->segment( 3 ), $franchiseeId );
		$AllQtyReqListAry        = $this->Reporting_Model->getFrAllQtyRequestDetails( false, false, false, $franchiseeId );
		$data['frAllReqQtyAray'] = $frAllReqQtyAray;
		$data['szMetaTagTitle']  = " Stock Requests";
		$data['is_user_login']   = $is_user_login;
		$data['pageName']        = "Reporting";
		$data['AllQtyReqList']   = $AllQtyReqListAry;
		$data['subpageName']     = "Franchisee_Stock_Requests";
		$data['data']            = $data;
		$this->load->view( 'layout/admin_header', $data );
		$this->load->view( 'reporting/frStockRequestList' );
		$this->load->view( 'layout/admin_footer' );
	}
	function frstockassignlistData() {
		$flag = $this->input->post( 'flag' );
		$this->session->set_userdata( 'flag', $flag );
		echo "SUCCESS||||";
		echo "frstockassignlist";
	}
	function frstockassignlist() {
		if ( ! empty( $_POST ) ) {
			$this->session->unset_userdata( 'searchtermAssign' );
		}
		$flag = $this->session->userdata( 'flag' );
		if ( $flag == 1 ) {
			$this->session->unset_userdata( 'searchtermAssign' );
		}
		$is_user_login = is_user_login( $this );
		// redirect to dashboard if already logged in
		if ( ! $is_user_login ) {
			ob_end_clean();
			redirect( base_url( '/admin/admin_login' ) );
			die;
		}
		$searchAryData = $_POST['szSearchProdCode'];
		$searchAry     = $this->Reporting_Model->searchtermAssign_handler( $searchAryData );
		$franchiseeId  = $_SESSION['drugsafe_user']['id'];
		$config['base_url']   = __BASE_URL__ . "/reporting/frstockassignlist/";
		$config['total_rows'] = count( $this->Reporting_Model->getFrAllQtyAssignDetails( $searchAry, $limit, $offset, $franchiseeId ) );
		$config['per_page']   = __PAGINATION_RECORD_LIMIT__;
		$this->pagination->initialize( $config );
		$frAllQtyAssignAray   = $this->Reporting_Model->getFrAllQtyAssignDetails( $searchAry, $config['per_page'], $this->uri->segment( 3 ), $franchiseeId );
		$allQtyAssignListAray = $this->Reporting_Model->getFrAllQtyAssignDetails( false, false, false, $franchiseeId, 1 );
		$data['frAllQtyAssignAray']   = $frAllQtyAssignAray;
		$data['allQtyAssignListAray'] = $allQtyAssignListAray;
		$data['szMetaTagTitle']       = "Stock Assignments";
		$data['is_user_login']        = $is_user_login;
		$data['pageName']             = "Reporting";
		$data['subpageName']          = "Franchisee_Stock_Assignments";
		$data['data']                 = $data;
		$this->load->view( 'layout/admin_header', $data );
		$this->load->view( 'reporting/frStockAssignList' );
		$this->load->view( 'layout/admin_footer' );
	}
	function pdffrstockreqlistData() {
		$productCode = $this->input->post( 'productCode' );
		$this->session->set_userdata( 'productCode', $productCode );
		echo "SUCCESS||||";
		echo "pdffrstockreqlist";
	}
	public function pdffrstockreqlist() {
		$this->load->library( 'Pdf' );
		$pdf = new Pdf( 'P', 'mm', 'A4', true, 'UTF-8', false );
		$pdf->SetCreator( PDF_CREATOR );
		$pdf->SetTitle( 'Drug-safe stock request report' );
		$pdf->SetAuthor( 'Drug-safe' );
		$pdf->SetSubject( 'Stock Request Report PDF' );
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
		$franchiseeId    = $_SESSION['drugsafe_user']['id'];
		$productCode     = $this->session->userdata( 'productCode' );
		$frAllReqQtyAray = $this->Reporting_Model->getFrAllQtyRequestDetails( $productCode, false, false, $franchiseeId );
		$html            = '<a style="text-align:center;  margin-bottom:5px;" href="' . __BASE_URL__ . '" ><img style="width:145px" src="' . __BASE_URL__ . '/images/logo.png" alt="logo" class="logo-default" /> </a>
            <div><p style="text-align:center; font-size:18px; margin-bottom:5px; color:black"><b>Stock Request Report</b></p></div>
            <div class= "table-responsive" >
                            <table border="1" cellpadding="5">
                                    <tr>
                                        <th> <b>Product Code</b> </th>
                                        <th><b> Quantity Requested</b> </th>
                                        <th> <b>Requested On</b> </th>
                                   
                                    </tr>';
		if ( $frAllReqQtyAray ) {
			$i = 0;
			foreach ( $frAllReqQtyAray as $frAllReqQtyArayData ) {
				$html .= '<tr>
                                        
                                            <td> ' . $frAllReqQtyArayData['szProductCode'] . ' </td>
                                            <td>' . $frAllReqQtyArayData['szQuantity'] . ' </td>
                                             <td>' . date( 'd/m/Y h:i:s A', strtotime( $frAllReqQtyArayData['dtRequestedOn'] ) ) . ' </td>
                                
                                        </tr>';
			}
		}
		$i ++;
		$html .= '
                            </table>
                        </div>
                      
                        ';
		$pdf->writeHTML( $html, true, false, true, false, '' );
//    $pdf->Write(5, 'CodeIgniter TCPDF Integration');
		ob_end_clean();
		$this->session->unset_userdata( 'productCode' );
		$pdf->Output( 'stock-request-report.pdf', 'I' );
	}
	function excelfrstockreqlistData() {
		$productCode = $this->input->post( 'productCode' );
		$this->session->set_userdata( 'productCode', $productCode );
		echo "SUCCESS||||";
		echo "excelfrstockreqlist";
	}
	public function excelfrstockreqlist() {
		$franchiseeId    = $_SESSION['drugsafe_user']['id'];
		$productCode     = $this->session->userdata( 'productCode' );
		$frAllReqQtyAray = $this->Reporting_Model->getFrAllQtyRequestDetails( $productCode, false, false, $franchiseeId );
		$this->load->library( 'excel' );
		$filename = 'Report';
		$title    = 'Stock request';
		$file     = $filename . '-' . $title; //save our workbook as this file name
		$this->excel->setActiveSheetIndex( 0 );
		$this->excel->getActiveSheet()->setTitle( $filename );
		$this->excel->getActiveSheet()->setCellValue( 'A1', 'Product Code' );
		$this->excel->getActiveSheet()->getStyle( 'A1' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'A1' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'A1' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'B1', 'Quantity Requested' );
		$this->excel->getActiveSheet()->getStyle( 'B1' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'B1' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'B1' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'C1', 'Requested On' );
		$this->excel->getActiveSheet()->getStyle( 'C1' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'C1' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'C1' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		if ( ! empty( $frAllReqQtyAray ) ) {
			$i = 2;
			foreach ( $frAllReqQtyAray as $item ) {
				$this->excel->getActiveSheet()->setCellValue( 'A' . $i, $item['szProductCode'] );
				$this->excel->getActiveSheet()->setCellValue( 'B' . $i, $item['szQuantity'] );
				$this->excel->getActiveSheet()->setCellValue( 'C' . $i, date( 'd/m/Y h:i:s A', strtotime( $item['dtRequestedOn'] ) ) );
				$this->excel->getActiveSheet()->getColumnDimension( 'A' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'B' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'C' )->setAutoSize( true );
				$i ++;
			}
		}
		header( 'Content-Type: application/vnd.ms-excel' ); //mime type
		header( 'Content-Disposition: attachment;filename="' . $file . '"' ); //tell browser what's the file name
		header( 'Cache-Control: max-age=0' ); //no cache
//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
//if you want to save it as .XLSX Excel 2007 format
		$objWriter = PHPExcel_IOFactory::createWriter( $this->excel, 'Excel5' );
//force user to download the Excel file without writing it to server's HD
		$this->session->unset_userdata( 'productCode' );
		$objWriter->save( 'php://output' );
	}
	function pdf_fr_stockassignlist_Data() {
		$productCode = $this->input->post( 'productCode' );
		$this->session->set_userdata( 'productCode', $productCode );
		echo "SUCCESS||||";
		echo "pdf_fr_stockassignlist";
	}
	public function pdf_fr_stockassignlist() {
		$this->load->library( 'Pdf' );
		$pdf = new Pdf( 'P', 'mm', 'A4', true, 'UTF-8', false );
		$pdf->SetCreator( PDF_CREATOR );
		$pdf->SetTitle( 'Drug-safe stock assignment report' );
		$pdf->SetAuthor( 'Drug-safe' );
		$pdf->SetSubject( 'Stock Assignment Report PDF' );
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
		$franchiseeId = $_SESSION['drugsafe_user']['id'];
		$productCode  = $this->session->userdata( 'productCode' );
		$frAllQtyAssignAray = $this->Reporting_Model->getFrAllQtyAssignDetails( $productCode, false, false, $franchiseeId );
		$html               = '       
        <a style="text-align:center;  margin-bottom:5px;" href="' . __BASE_URL__ . '" ><img style="width:145px" src="' . __BASE_URL__ . '/images/logo.png" alt="logo" class="logo-default" /> </a>
            <div><p style="text-align:center; font-size:18px; margin-bottom:5px; color:black"><b>Stock Assignment Report</b></p></div>
            <div class= "table-responsive" >
                            <table border="1" cellpadding="5">
                                    <tr>
                                        <th> <b>Product Code</b> </th>
                                        <th><b>Cost Per Item</b> </th>
                                         <th><b> Total Cost For Quantity Assign</b> </th>
                                        <th><b> Quantity Assigned</b> </th>
                                        <th><b> Quantity Adjusted</b> </th>
                                        <th><b> Available Quantity</b> </th>
                                        <th> <b>Assigned On</b> </th>
                                   
                                    </tr>';
		if ( $frAllQtyAssignAray ) {
			$i = 0;
			foreach ( $frAllQtyAssignAray as $frAllQtyAssignArayData ) {
				if ( $frAllQtyAssignArayData['quantityDeducted'] != 0 ) {
					$Qty             = $frAllQtyAssignArayData['quantityDeducted'];
					$Cost            = $frAllQtyAssignArayData['szProductCost'];
					$TotalCostPerQty = "(-) $" . ( $Qty * $Cost );
				} else {
					$Qty             = $frAllQtyAssignArayData['szQuantityAssigned'];
					$Cost            = $frAllQtyAssignArayData['szProductCost'];
					$TotalCostPerQty = "(+) $" . ( $Qty * $Cost );
				}
				$html .= '<tr>
                                            <td> ' . $frAllQtyAssignArayData['szProductCode'] . ' </td>
                                            <td> $' . $frAllQtyAssignArayData['szProductCost'] . ' </td>
                                            <td> $' . $TotalCostPerQty . ' </td>
                                            <td>' . $frAllQtyAssignArayData['szQuantityAssigned'] . ' </td>
                                            <td>' . $frAllQtyAssignArayData['quantityDeducted'] . ' </td>
                                             <td>' . $frAllQtyAssignArayData['szTotalAvailableQty'] . ' </td>
                                            <td> ' . date( 'd/m/Y h:i:s A', strtotime( $frAllQtyAssignArayData['dtAssignedOn'] ) ) . '  </td>
                                        </tr>';
			}
		}
		$i ++;
		$html .= '
                            </table>
                        </div>
                      
                        ';
		$pdf->writeHTML( $html, true, false, true, false, '' );
		ob_end_clean();
		$this->session->unset_userdata( 'productCode' );
		$pdf->Output( 'stock-assignment-report.pdf', 'I' );
	}
	function excelfr_stockassignlist_Data() {
		$productCode = $this->input->post( 'productCode' );
		$this->session->set_userdata( 'productCode', $productCode );
		echo "SUCCESS||||";
		echo "excelfr_stockassignlist";
	}
	public function excelfr_stockassignlist() {
		$franchiseeId       = $_SESSION['drugsafe_user']['id'];
		$productCode        = $this->session->userdata( 'productCode' );
		$frAllQtyAssignAray = $this->Reporting_Model->getFrAllQtyAssignDetails( $productCode, false, false, $franchiseeId );
		$this->load->library( 'excel' );
		$filename = 'Report';
		$title    = 'Stock assignment';
		$file     = $filename . '-' . $title; //save our workbook as this file name
		$this->excel->setActiveSheetIndex( 0 );
		$this->excel->getActiveSheet()->setTitle( $filename );
		$this->excel->getActiveSheet()->setCellValue( 'A1', 'Product Code' );
		$this->excel->getActiveSheet()->getStyle( 'A1' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'A1' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'A1' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'B1', 'Cost Per Item' );
		$this->excel->getActiveSheet()->getStyle( 'B1' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'B1' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'B1' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'C1', 'Total Cost For Quantity Assign' );
		$this->excel->getActiveSheet()->getStyle( 'C1' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'C1' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'C1' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'D1', 'Quantity Assigned' );
		$this->excel->getActiveSheet()->getStyle( 'D1' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'D1' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'D1' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'E1', 'Quantity Adjusted' );
		$this->excel->getActiveSheet()->getStyle( 'E1' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'E1' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'E1' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'F1', 'Available Quantity' );
		$this->excel->getActiveSheet()->getStyle( 'F1' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'F1' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'F1' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'G1', 'Assigned On' );
		$this->excel->getActiveSheet()->getStyle( 'G1' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'G1' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'G1' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		if ( ! empty( $frAllQtyAssignAray ) ) {
			$i = 2;
			foreach ( $frAllQtyAssignAray as $item ) {
				if ( $item['quantityDeducted'] != 0 ) {
					$Qty             = $item['quantityDeducted'];
					$Cost            = $item['szProductCost'];
					$TotalCostPerQty = "(-) $" . ( $Qty * $Cost );
				} else {
					$Qty             = $item['szQuantityAssigned'];
					$Cost            = $item['szProductCost'];
					$TotalCostPerQty = "(+) $" . ( $Qty * $Cost );
				}
				$this->excel->getActiveSheet()->setCellValue( 'A' . $i, $item['szProductCode'] );
				$this->excel->getActiveSheet()->setCellValue( 'B' . $i, $Cost );
				$this->excel->getActiveSheet()->setCellValue( 'C' . $i, $TotalCostPerQty );
				$this->excel->getActiveSheet()->setCellValue( 'D' . $i, $item['szQuantityAssigned'] );
				$this->excel->getActiveSheet()->setCellValue( 'E' . $i, $item['quantityDeducted'] );
				$this->excel->getActiveSheet()->setCellValue( 'F' . $i, $item['szTotalAvailableQty'] );
				$this->excel->getActiveSheet()->setCellValue( 'G' . $i, date( 'd/m/Y h:i:s A', strtotime( $item['dtAssignedOn'] ) ) );
				$this->excel->getActiveSheet()->getColumnDimension( 'A' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'B' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'C' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'D' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'E' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'F' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'G' )->setAutoSize( true );
				$i ++;
			}
		}
		header( 'Content-Type: application/vnd.ms-excel' ); //mime type
		header( 'Content-Disposition: attachment;filename="' . $file . '"' ); //tell browser what's the file name
		header( 'Cache-Control: max-age=0' ); //no cache
//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
//if you want to save it as .XLSX Excel 2007 format
		$objWriter = PHPExcel_IOFactory::createWriter( $this->excel, 'Excel5' );
		$this->session->unset_userdata( 'productCode' );
//force user to download the Excel file without writing it to server's HD
		$objWriter->save( 'php://output' );
	}
	public function inventoryReport() {
		$is_user_login = is_user_login( $this );
		// redirect to dashboard if already logged in
		if ( ! $is_user_login ) {
			ob_end_clean();
			redirect( base_url( '/admin/admin_login' ) );
			die;
		}
		$count        = $this->Admin_Model->getnotification();
		$searchAry    = $_POST;
		$franchiseeid = $_POST['szSearch1'];
		$catid        = $_POST['szSearch2'];
		$prodcode     = $_POST['szSearch3'];
		//$validPendingOrdersDetailsAray = $this->Order_Model->getallValidPendingOrderDetails($searchAry);
		$allFrPendingDetailsSearchAray = $this->Order_Model->getallPendingValidOrderFrId();
		$validPendingOrdersDetailsAray = $this->Order_Model->getProductDetsByfranchiseeid( $franchiseeid, $catid, $prodcode );
		$this->load->library( 'form_validation' );
		$this->form_validation->set_rules( 'szSearch1', 'Franchisee Name ', 'required' );
		$this->form_validation->set_rules( 'szSearch2', 'Product Category', 'required' );
		if ( $_POST['szSearch2'] ) {
			$productAry = $this->Inventory_Model->getProductByCategory( trim( $catid ) );
		}
		$this->form_validation->set_message( 'required', '{field} is required.' );
		if ( $this->form_validation->run() == false ) {
			$data['validOrdersDetailsAray']        = $validOrdersDetailsAray;
			$data['validOrdersDetailsSearchAray']  = $validOrdersDetailsSearchAray;
			$data['allFrPendingDetailsSearchAray'] = $allFrPendingDetailsSearchAray;
			$data['szMetaTagTitle']                = "Inventory Report";
			$data['is_user_login']                 = $is_user_login;
			$data['pageName']                      = "Reporting";
			$data['subpageName']                   = "Inventory_Report";
			$data['notification']                  = $count;
			$data['data']                          = $data;
			$data['productAry']                    = $productAry;
			$data['arErrorMessages']               = $this->Order_Model->arErrorMessages;
			$this->load->view( 'layout/admin_header', $data );
			$this->load->view( 'reporting/inventoryReport' );
			$this->load->view( 'layout/admin_footer' );
		} else {
			$data['validPendingOrdersDetailsAray'] = $validPendingOrdersDetailsAray;
			$data['validOrdersDetailsSearchAray']  = $validOrdersDetailsSearchAray;
			$data['allFrPendingDetailsSearchAray'] = $allFrPendingDetailsSearchAray;
			$data['szMetaTagTitle']                = "Inventory Report";
			$data['is_user_login']                 = $is_user_login;
			$data['pageName']                      = "Reporting";
			$data['subpageName']                   = "Inventory_Report";
			$data['notification']                  = $count;
			$data['data']                          = $data;
			$data['productAry']                    = $productAry;
			$data['arErrorMessages']               = $this->Order_Model->arErrorMessages;
			$this->load->view( 'layout/admin_header', $data );
			$this->load->view( 'reporting/inventoryReport' );
			$this->load->view( 'layout/admin_footer' );
		}
	}
	public function viewOrderReport() {
		$is_user_login = is_user_login( $this );
		// redirect to dashboard if already logged in
		if ( ! $is_user_login ) {
			ob_end_clean();
			redirect( base_url( '/admin/admin_login' ) );
			die;
		}
		$searchAry = $_POST;
		$data['szMetaTagTitle']  = "Order Details";
		$data['is_user_login']   = $is_user_login;
		$data['pageName']        = "Orders";
		$data['notification']    = $count;
		$data['data']            = $data;
		$data['arErrorMessages'] = $this->Order_Model->arErrorMessages;
		$data['drugtestkitlist'] = $drugTestKitListAray;
		$this->load->view( 'layout/admin_header', $data );
		$this->load->view( 'reporting/View_Order_Report' );
		$this->load->view( 'layout/admin_footer' );
	}
	public function xero() {
		$is_user_login = is_user_login( $this );
		// redirect to dashboard if already logged in
		if ( ! $is_user_login ) {
			ob_end_clean();
			redirect( base_url( '/admin/admin_login' ) );
			die;
		}
		$searchAry = $_POST;
		$data['szMetaTagTitle']  = "Order Details";
		$data['is_user_login']   = $is_user_login;
		$data['pageName']        = "Orders";
		$data['notification']    = $count;
		$data['data']            = $data;
		$data['arErrorMessages'] = $this->Order_Model->arErrorMessages;
		$data['drugtestkitlist'] = $drugTestKitListAray;
		$this->load->view( 'layout/admin_header', $data );
		$this->load->view( 'reporting/xero' );
		$this->load->view( 'layout/admin_footer' );
	}
	function getProductCodeListByCategory( $szCategory = '' ) {
		if ( trim( $szCategory ) != '' ) {
			$_POST['szCategory'] = $szCategory;
		}
		$productAry = $this->Inventory_Model->getProductByCategory( trim( $_POST['szCategory'] ) );
		$result     = "<select class=\"form-control custom-select required\" id=\"szSearch3\" name=\"szSearch3\" placeholder=\"Product Code\" onfocus=\"remove_formError(this.id,'true')\">";
		if ( ! empty( $productAry ) ) {
			$result .= "<option value=''>Product Code</option>";
			foreach ( $productAry as $productDetails ) {
				$result .= "<option value='" . $productDetails['id'] . "'>" . $productDetails['szProductCode'] . "</option>";
			}
		} else {
			$result .= "<option value=''>Product Code</option>";
		}
		$result .= "</select>";
		echo $result;
	}
	public function frInventoryReport() {
		$is_user_login = is_user_login( $this );
		// redirect to dashboard if already logged in
		if ( ! $is_user_login ) {
			ob_end_clean();
			redirect( base_url( '/admin/admin_login' ) );
			die;
		}
		$count     = $this->Admin_Model->getnotification();
		$searchAry = $_POST;
		$catid     = $_POST['szSearch2'];
		$prodcode  = $_POST['szSearch3'];
		$validPendingOrderFrDetailsAray = $this->Order_Model->getallValidPendingOrderFrDetails( $searchAry );
		$productAry = $this->Inventory_Model->getProductByCategory( trim( $catid ) );
		$this->load->library( 'form_validation' );
		$this->form_validation->set_rules( 'szSearch2', 'Product Category', 'required' );
		$this->form_validation->set_message( 'required', '{field} is required.' );
		if ( $this->form_validation->run() == false ) {
			$data['validPendingOrderFrDetailsAray'] = $validPendingOrderFrDetailsAray;
			$data['szMetaTagTitle']                 = "Order Details";
			$data['is_user_login']                  = $is_user_login;
			$data['pageName']                       = "Reporting";
			$data['subpageName']                    = "Inventory_Report";
			$data['notification']                   = $count;
			$data['data']                           = $data;
			$data['arErrorMessages']                = $this->Order_Model->arErrorMessages;
			$data['drugtestkitlist']                = $drugTestKitListAray;
			$data['productAry']                     = $productAry;
			$this->load->view( 'layout/admin_header', $data );
			$this->load->view( 'reporting/frInventoryReport' );
			$this->load->view( 'layout/admin_footer' );
		} else {
			$searchAry                              = $_POST;
			$validPendingOrderFrDetailsAray         = $this->Order_Model->getallValidPendingOrderFrDetails( $searchAry );
			$data['validPendingOrderFrDetailsAray'] = $validPendingOrderFrDetailsAray;
			$data['szMetaTagTitle']                 = "Order Details";
			$data['is_user_login']                  = $is_user_login;
			$data['pageName']                       = "Reporting";
			$data['subpageName']                    = "Inventory_Report";
			$data['notification']                   = $count;
			$data['data']                           = $data;
			$data['productAry']                     = $productAry;
			$data['arErrorMessages']                = $this->Order_Model->arErrorMessages;
			$data['drugtestkitlist']                = $drugTestKitListAray;
			$this->load->view( 'layout/admin_header', $data );
			$this->load->view( 'reporting/frInventoryReport' );
			$this->load->view( 'layout/admin_footer' );
		}
	}
	function ViewpdfFrInventoryReportData() {
		$prodCategory = $this->input->post( 'prodCategory' );
		$productCode  = $this->input->post( 'productCode' );
		$this->session->set_userdata( 'prodCategory', $prodCategory );
		$this->session->set_userdata( 'productCode', $productCode );
		echo "SUCCESS||||";
		echo "ViewpdfFrInventoryReport";
	}
	public function ViewpdfFrInventoryReport() {
		ob_start();
		$this->load->library( 'Pdf' );
		$pdf = new Pdf( 'P', 'mm', 'A4', true, 'UTF-8', false );
		$pdf->SetCreator( PDF_CREATOR );
		$pdf->SetTitle( 'Drug-safe inventory report' );
		$pdf->SetAuthor( 'Drug-safe' );
		$pdf->SetSubject( 'Inventory Report PDF' );
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
		$productCode  = $this->session->userdata( 'productCode' );
		$prodCategory = $this->session->userdata( 'prodCategory' );
		$validPendingOrderFrDetailsAray = $this->Order_Model->getValidPendingOdrFrDetailsForPdf( $productCode, $prodCategory );
		$html = '<a style="text-align:center;  margin-bottom:5px;" href="' . __BASE_URL__ . '" ><img style="width:145px" src="' . __BASE_URL__ . '/images/logo.png" alt="logo" class="logo-default" /> </a>
            <div><p style="text-align:center; font-size:18px; margin-bottom:5px; color:black"><b>Stock Request Report</b></p></div>
            <div class= "table-responsive" >
                            <table border="1" cellpadding="5">
                                    <tr>
                                        <th style="width:80px"><b>  #</b> </th>
                                        <th> <b>Category</b> </th>
                                        <th> <b>Product Code </b> </th>
                                        <th style="width:150px"><b> In Stock  </b> </th>
                                        <th style="width:170px"> <b>Ordered</b> </th>
                                       
                                   
                                    </tr>';
		if ( $validPendingOrderFrDetailsAray ) {
                               $i = 0;
                                     $checkarr = array();
                                                foreach($validPendingOrderFrDetailsAray as $validPendingOrderFrDetailsData) {
                                                    if (!in_array($validPendingOrderFrDetailsData['productid'], $checkarr))
                                                    {
                                                        $i++;
                                                    $productcatAry = $this->Order_Model->getCategoryDetailsById(trim($validPendingOrderFrDetailsData['szProductCategory']));
                                                    $validPendingOrdersQtyDetailsAray = $this->Order_Model->getProductDetsByfranchiseeid($validPendingOrderFrDetailsData['franchiseeid'], $validPendingOrderFrDetailsData['szProductCategory'], $validPendingOrderFrDetailsData['productid']);
                                                
                                                    $prodqtyarr = $this->Order_Model->getTotalFrOrderdqty($validPendingOrderFrDetailsData['franchiseeid'], $validPendingOrderFrDetailsData['productid']);
                                                    $getAllDispatchedQtyAry = $this->Order_Model->getAllDispatchedQty($validPendingOrderFrDetailsData['franchiseeid'],$validPendingOrderFrDetailsData['productid']);
                                                     
                                                    $qty = $prodqtyarr[0]['quantity']- $getAllDispatchedQtyAry['0']['dispatch_qty'];
                                                    if($qty!='0'){
				$html  .= '<tr>
                                            <td> ' . $i . ' </td>
                                            <td> ' . $productcatAry['szName'] . '</td>
                                            <td> ' . $validPendingOrderFrDetailsData['szProductCode'] . ' </td>';
				if ( ! empty( $validPendingOrdersQtyDetailsAray ) ) {
					$printzero = true;
					foreach ( $validPendingOrdersQtyDetailsAray as $qtyData ) {
						$html      .= '<td>' . $qtyData['szQuantity'] . ' </td>';
						$printzero = false;
					}
					if ( $printzero ) {
						$html .= '<td>0</td>
                                               ';
					}
				} else {
					$html .= '<td>0</td>';
				}
                                 if(!empty($getAllDispatchedQtyAry))
                                {  
                                 $qty = $prodqtyarr[0]['quantity']- $getAllDispatchedQtyAry['0']['dispatch_qty'];  
                             $html .= '<td>' . $qty . ' </td>';
                                } else {
                                 $html .= '<td>' .  $prodqtyarr[0]['quantity'] . ' </td>';   
                                 }
				$html .=
                                     '</tr>';
                                             }
                                                    array_push($checkarr, $validPendingOrderFrDetailsData['productid']);
                                                }
                                              }
			}
		$html .= '
                            </table>
                        </div>
                      
                        ';
		$pdf->writeHTML( $html, true, false, true, false, '' );
//    $pdf->Write(5, 'CodeIgniter TCPDF Integration');
		error_reporting( E_ALL );
		$pdf->Output( 'stock-request-report.pdf', 'I' );
	}
	function ViewexcelFrInventoryReportData() {
		$prodCategory = $this->input->post( 'prodCategory' );
		$productCode  = $this->input->post( 'productCode' );
		$this->session->set_userdata( 'prodCategory', $prodCategory );
		$this->session->set_userdata( 'productCode', $productCode );
		echo "SUCCESS||||";
		echo "ViewexcelFrInventoryReport";
	}
	public function ViewexcelFrInventoryReport() {
		$this->load->library( 'excel' );
		$filename = 'Report';
		$title    = 'Inventory Report';
		$file     = $filename . '-' . $title; //save our workbook as this file name
		$this->excel->setActiveSheetIndex( 0 );
		$this->excel->getActiveSheet()->setTitle( $filename );
		$this->excel->getActiveSheet()->setCellValue( 'A1', '#' );
		$this->excel->getActiveSheet()->getStyle( 'A1' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'A1' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'A1' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'B1', 'Category' );
		$this->excel->getActiveSheet()->getStyle( 'B1' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'B1' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'B1' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'C1', 'Product Code' );
		$this->excel->getActiveSheet()->getStyle( 'C1' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'C1' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'C1' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'D1', ' In Stock ' );
		$this->excel->getActiveSheet()->getStyle( 'D1' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'D1' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'D1' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'E1', 'Ordered' );
		$this->excel->getActiveSheet()->getStyle( 'E1' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'E1' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'E1' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$productCode  = $this->session->userdata( 'productCode' );
		$prodCategory = $this->session->userdata( 'prodCategory' );
		$validPendingOrderFrDetailsAray = $this->Order_Model->getValidPendingOdrFrDetailsForPdf( $productCode, $prodCategory );
		if ( $validPendingOrderFrDetailsAray ) {
			$i = 2;
			$x = 0;
			 $checkarr = array();
                            foreach($validPendingOrderFrDetailsAray as $validPendingOrderFrDetailsData) {
                                if (!in_array($validPendingOrderFrDetailsData['productid'], $checkarr))
                                {
                                    $i++;
                                $productcatAry = $this->Order_Model->getCategoryDetailsById(trim($validPendingOrderFrDetailsData['szProductCategory']));
                                $validPendingOrdersQtyDetailsAray = $this->Order_Model->getProductDetsByfranchiseeid($validPendingOrderFrDetailsData['franchiseeid'], $validPendingOrderFrDetailsData['szProductCategory'], $validPendingOrderFrDetailsData['productid']);
                                $prodqtyarr = $this->Order_Model->getTotalFrOrderdqty($validPendingOrderFrDetailsData['franchiseeid'], $validPendingOrderFrDetailsData['productid']);
                                $getAllDispatchedQtyAry = $this->Order_Model->getAllDispatchedQty($validPendingOrderFrDetailsData['franchiseeid'],$validPendingOrderFrDetailsData['productid']);
                                $qty = $prodqtyarr[0]['quantity']- $getAllDispatchedQtyAry['0']['dispatch_qty'];
                                if($qty!='0'){
				if ( ! empty( $validPendingOrdersQtyDetailsAray ) ) {
					$printzero = true;
					foreach ( $validPendingOrdersQtyDetailsAray as $qtyData ) {
						$val       = $qtyData['szQuantity'];
						$printzero = false;
					}
					if ( $printzero ) {
						$val = '0';
					}
				} else {
					$val = '0';
				}
                             if(!empty($getAllDispatchedQtyAry))
                                {  
                                 $qty = $prodqtyarr[0]['quantity']- $getAllDispatchedQtyAry['0']['dispatch_qty'];  
                                $item =  $qty;
                                } else {
                                $item =  $prodqtyarr[0]['quantity'];    
                                }
				$x ++;
				$this->excel->getActiveSheet()->setCellValue( 'A' . $i, $x );
				$this->excel->getActiveSheet()->setCellValue( 'B' . $i, $productcatAry['szName'] );
				$this->excel->getActiveSheet()->setCellValue( 'C' . $i, $validPendingOrderFrDetailsData['szProductCode'] );
				$this->excel->getActiveSheet()->setCellValue( 'D' . $i, $val );
				$this->excel->getActiveSheet()->setCellValue( 'E' . $i, $item);
				$this->excel->getActiveSheet()->getColumnDimension( 'A' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'B' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'C' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'D' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'E' )->setAutoSize( true );
                                    }
                                                    array_push($checkarr, $validPendingOrderFrDetailsData['productid']);
                                                }
                                              }
			 }
		header( 'Content-Type: application/vnd.ms-excel' ); //mime type
		header( 'Content-Disposition: attachment;filename="' . $file . '"' ); //tell browser what's the file name
		header( 'Cache-Control: max-age=0' ); //no cache
//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
//if you want to save it as .XLSX Excel 2007 format
		$objWriter = PHPExcel_IOFactory::createWriter( $this->excel, 'Excel5' );
//force user to download the Excel file without writing it to server's HD
		$objWriter->save( 'php://output' );
	}
	function ViewpdfInventoryReportData() {
		$prodCategory = $this->input->post( 'prodCategory' );
		$productCode  = $this->input->post( 'productCode' );
		$franchiseeId = $this->input->post( 'franchiseeId' );
		$this->session->set_userdata( 'franchiseeId', $franchiseeId );
		$this->session->set_userdata( 'productCode', $productCode );
		$this->session->set_userdata( 'prodCategory', $prodCategory );
		echo "SUCCESS||||";
		echo "ViewpdfInventoryReport";
	}
	public function ViewpdfInventoryReport() {
		ob_start();
		$this->load->library( 'Pdf' );
		$pdf = new Pdf( 'P', 'mm', 'A4', true, 'UTF-8', false );
		$pdf->SetCreator( PDF_CREATOR );
		$pdf->SetTitle( 'Drug-safe inventory report' );
		$pdf->SetAuthor( 'Drug-safe' );
		$pdf->SetSubject( 'Inventory Report PDF' );
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
		$pdf->AddPage( 'L' );
		$franchiseeId = $this->session->userdata( 'franchiseeId' );
		$productCode  = $this->session->userdata( 'productCode' );
		$prodCategory = $this->session->userdata( 'prodCategory' );
		$reqOrderAray = $this->Order_Model->getProductDetsByfranchiseeid( $franchiseeId, $prodCategory, $productCode );
		$html = '<a style="text-align:center;  margin-bottom:5px;" href="' . __BASE_URL__ . '" ><img style="width:145px" src="' . __BASE_URL__ . '/images/logo.png" alt="logo" class="logo-default" /> </a>
            <div><p style="text-align:center; font-size:18px; margin-bottom:5px; color:black"><b>Inventory Report</b></p></div>
            <div class= "table-responsive" >
                            <table border="1" cellpadding="5">
                                    <tr> 
                                        <th width="9%"><b>  #</b> </th>
                                        <th width="18%"> <b>Category</b> </th>
                                        <th width="18%"> <b>Product Code </b> </th>
                                        <th width="18%"> <b> Model Stock Value </b> </th>
                                        <th width="18%"><b> In Stock  </b> </th>
                                        <th width="18%"> <b>Requested</b> </th>
                                       
                                   
                                    </tr>';
		if ( $reqOrderAray ) {
			$i = 0;
			foreach ( $reqOrderAray as $reqOrderData ) {
				$i ++;
				$productcatAry = $this->Order_Model->getCategoryDetailsById( trim( $reqOrderData['szProductCategory'] ) );
				$availprodqty  = $this->Order_Model->getorderdanddispatchval( $reqOrderData['iFranchiseeId'], $reqOrderData['id'] );
				$html          .= '<tr>
                                            <td> ' . $i . ' </td>
                                            <td> ' . $productcatAry['szName'] . '</td>
                                            <td> ' . $reqOrderData['szProductCode'] . ' </td>
                                            <td>' . $reqOrderData['model_stk_val'] . ' </td>
                                            <td>' . $reqOrderData['szAvailableQuantity'] . ' </td>';
				if ( ! empty( $availprodqty ) ) {
					$printzero = true;
                                  
					foreach ($availprodqty as $requestedqty) {
                                                             $getAllDispatchedQtyAry = $this->Order_Model->getAllDispatchedQty($requestedqty['franchiseeid'],$requestedqty['productid']);
                                                         
                                                            if ( $requestedqty['productid'] == $reqOrderData['id'] ) {
                                                              $qty = $requestedqty['quantity']- $getAllDispatchedQtyAry['0']['dispatch_qty'];  
                                                           
                                                               $html      .= '<td>' . $qty . '</td>
                                                   ';
							$printzero = false;
						}
                                                        }
					if ( $printzero ) {
						$html .= '<td>0</td>
                                               ';
					}
				} else {
					$html .= '<td>0</td>';
				}
				$html .= '</tr>';
			}
		}
		$html .= '
                            </table>
                        </div>
                      
                        ';
		$pdf->writeHTML( $html, true, false, true, false, '' );
//    $pdf->Write(5, 'CodeIgniter TCPDF Integration');
		error_reporting( E_ALL );
		$pdf->Output( 'stock-request-report.pdf', 'I' );
	}
	function ViewexcelInventoryReportData() {
		$prodCategory = $this->input->post( 'prodCategory' );
		$productCode  = $this->input->post( 'productCode' );
		$franchiseeId = $this->input->post( 'franchiseeId' );
		$this->session->set_userdata( 'franchiseeId', $franchiseeId );
		$this->session->set_userdata( 'productCode', $productCode );
		$this->session->set_userdata( 'prodCategory', $prodCategory );
		echo "SUCCESS||||";
		echo "ViewexcelInventoryReport";
	}
	public function ViewexcelInventoryReport() {
		$this->load->library( 'excel' );
		$filename = 'Report';
		$title    = 'Inventory Report';
		$file     = $filename . '-' . $title; //save our workbook as this file name
		$this->excel->setActiveSheetIndex( 0 );
		$this->excel->getActiveSheet()->setTitle( $filename );
		$this->excel->getActiveSheet()->setCellValue( 'A1', '#' );
		$this->excel->getActiveSheet()->getStyle( 'A1' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'A1' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'A1' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'B1', 'Category' );
		$this->excel->getActiveSheet()->getStyle( 'B1' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'B1' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'B1' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'C1', 'Product Code' );
		$this->excel->getActiveSheet()->getStyle( 'C1' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'C1' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'C1' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'D1', ' Model Stock Value ' );
		$this->excel->getActiveSheet()->getStyle( 'D1' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'D1' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'D1' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'E1', ' In Stock ' );
		$this->excel->getActiveSheet()->getStyle( 'E1' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'E1' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'E1' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'F1', 'Requested' );
		$this->excel->getActiveSheet()->getStyle( 'F1' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'F1' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'F1' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$productCode  = $this->session->userdata( 'productCode' );
		$prodCategory = $this->session->userdata( 'prodCategory' );
		$franchiseeId = $this->session->userdata( 'franchiseeId' );
		$reqOrderAray = $this->Order_Model->getProductDetsByfranchiseeid( $franchiseeId, $prodCategory, $productCode );
		if ( ! empty( $reqOrderAray ) ) {
			$i = 2;
			$x = 0;
			foreach ( $reqOrderAray as $item ) {
				$productcatAry = $this->Order_Model->getCategoryDetailsById( trim( $item['szProductCategory'] ) );
				$availprodqty  = $this->Order_Model->getorderdanddispatchval( $item['iFranchiseeId'], $item['id'] );
				$x ++;
				$this->excel->getActiveSheet()->setCellValue( 'A' . $i, $x );
				$this->excel->getActiveSheet()->setCellValue( 'B' . $i, $productcatAry['szName'] );
				$this->excel->getActiveSheet()->setCellValue( 'C' . $i, $item['szProductCode'] );
				$this->excel->getActiveSheet()->setCellValue( 'D' . $i, $item['model_stk_val'] );
				$this->excel->getActiveSheet()->setCellValue( 'E' . $i, $item['szAvailableQuantity'] );
				if ( ! empty( $availprodqty ) ) {
					$printzero = true;
                                        foreach ($availprodqty as $requestedqty) {
                                                             $getAllDispatchedQtyAry = $this->Order_Model->getAllDispatchedQty($requestedqty['franchiseeid'],$requestedqty['productid']);
                                                         
                                                           if ( $requestedqty['productid'] == $item['id'] ) {
                                                              $qty = $requestedqty['quantity']- $getAllDispatchedQtyAry['0']['dispatch_qty'];  
                                                       $this->excel->getActiveSheet()->setCellValue( 'F' . $i, $qty);
                                                        $printzero = false;
                                                                
                                                            }
                                                        }
                                      
					if ( $printzero ) {
						$this->excel->getActiveSheet()->setCellValue( 'F' . $i, 0 );
					}
				} else {
					$this->excel->getActiveSheet()->setCellValue( 'F' . $i, 0 );
				}
				$this->excel->getActiveSheet()->getColumnDimension( 'A' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'B' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'C' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'D' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'E' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'F' )->setAutoSize( true );
				$i ++;
			}
		}
		header( 'Content-Type: application/vnd.ms-excel' ); //mime type
		header( 'Content-Disposition: attachment;filename="' . $file . '"' ); //tell browser what's the file name
		header( 'Cache-Control: max-age=0' ); //no cache
//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
//if you want to save it as .XLSX Excel 2007 format
		$objWriter = PHPExcel_IOFactory::createWriter( $this->excel, 'Excel5' );
		$this->session->unset_userdata( 'franchiseeId' );
		$this->session->unset_userdata( 'productCode' );
		$this->session->unset_userdata( 'prodCategory' );
//force user to download the Excel file without writing it to server's HD
		$objWriter->save( 'php://output' );
	}
	function ViewpdfOrderReportData() {
		$szSearch1 = $this->input->post( 'szSearch1' );
		$szSearch2 = $this->input->post( 'szSearch2' );
		$szSearch4 = $this->input->post( 'szSearch4' );
		$szSearch5 = $this->input->post( 'szSearch5' );
		$this->session->set_userdata( 'szSearch1', $szSearch1 );
		$this->session->set_userdata( 'szSearch2', $szSearch2 );
		$this->session->set_userdata( 'szSearch4', $szSearch4 );
		$this->session->set_userdata( 'szSearch5', $szSearch5 );
		echo "SUCCESS||||";
		echo "ViewpdfOrderReport";
	}
	public function ViewpdfOrderReport() {
		ob_start();
		$this->load->library( 'Pdf' );
		$pdf = new Pdf( 'P', 'mm', 'A4', true, 'UTF-8', false );
		$pdf->SetCreator( PDF_CREATOR );
		$pdf->SetTitle( 'Drug-safe orders report' );
		$pdf->SetAuthor( 'Drug-safe' );
		$pdf->SetSubject( 'Orders Report PDF' );
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
		$pdf->AddPage( 'L' );
		$searchAry['szSearch1'] = $this->session->userdata( 'szSearch1' );
		$searchAry['szSearch2'] = $this->session->userdata( 'szSearch2' );
		$searchAry['szSearch4'] = $this->session->userdata( 'szSearch4' );
		$searchAry['szSearch5'] = $this->session->userdata( 'szSearch5' );
		$validOrdersDetailsAray = $this->Order_Model->getallValidOrderDetails( $searchAry );
		$html = '<a style="text-align:center;  margin-bottom:5px;" href="' . __BASE_URL__ . '" ><img style="width:145px" src="' . __BASE_URL__ . '/images/logo.png" alt="logo" class="logo-default" /> </a>
            <div><p style="text-align:center; font-size:18px; margin-bottom:5px; color:black"><b>Orders Report</b></p></div>
            <div class= "table-responsive" >
                            <table border="1" cellpadding="5">
                                    <tr>
                                        <th><b>  #</b> </th> ';
		if ( $_SESSION['drugsafe_user']['iRole'] == 1 ) {
			$html .= '<th> <b>Franchisee</b> </th>';
		}
		$html .= '<th> <b>Order Date </b> </th>
                                        <th><b> Order #  </b> </th>
                                        <th><b> Status  </b> </th>
                                        <th> <b>No. of Products</b> </th>
                                        <th><b> Order Cost EXL GST </b> </th>
                                    </tr>';
		if ( $validOrdersDetailsAray ) {
			$i = 0;
			foreach ( $validOrdersDetailsAray as $reqOrderData ) {
				$i ++;
				$franchiseeDetArr1 = $this->Admin_Model->getAdminDetailsByEmailOrId( '', $reqOrderData['franchiseeid'] );
				if ( $reqOrderData['status'] == 1 ) {
					$status = 'Ordered';
				}
				if ( $reqOrderData['status'] == 2 ) {
					$status = 'Dispatched';
				}
				if ( $reqOrderData['status'] == 3 ) {
					$status = 'Canceled';
				}
				$html .= '<tr>
                                            <td> ' . $i . ' </td>';
				if ( $_SESSION['drugsafe_user']['iRole'] == 1 ) {
					$html .= '  <td> ' . $franchiseeDetArr1['szName'] . '</td>';
				}
				$html .= '<td> ' . date( 'd M Y', strtotime( $reqOrderData['createdon'] ) ) . ' at '  .  date(' h:i A', strtotime( $reqOrderData['createdon'] ) ) . ' </td>
                                               <td>#' . sprintf( __FORMAT_NUMBER__, $reqOrderData['orderid'] ) . ' </td>
                                               <td>' . $status . ' </td>                                              
                                               <td>' . $reqOrderData['totalproducts'] . ' </td>
                                               <td>$' . ( $reqOrderData['price'] > 0 ? $reqOrderData['price'] : '0.00' ) . ' </td>
                                               </tr>';
			}
		}
		$html .= '
                            </table>
                        </div>
                      
                        ';
		$pdf->writeHTML( $html, true, false, true, false, '' );
//    $pdf->Write(5, 'CodeIgniter TCPDF Integration');
		error_reporting( E_ALL );
		$pdf->Output( 'orders-report.pdf', 'I' );
	}
	function ViewexcelOrderReportData() {
		$szSearch1 = $this->input->post( 'szSearch1' );
		$szSearch2 = $this->input->post( 'szSearch2' );
		$szSearch4 = $this->input->post( 'szSearch4' );
		$szSearch5 = $this->input->post( 'szSearch5' );
		$this->session->set_userdata( 'szSearch1', $szSearch1 );
		$this->session->set_userdata( 'szSearch2', $szSearch2 );
		$this->session->set_userdata( 'szSearch4', $szSearch4 );
		$this->session->set_userdata( 'szSearch5', $szSearch5 );
		echo "SUCCESS||||";
		echo "ViewexcelOrdersReport";
	}
	public function ViewexcelOrdersReport() {
		$this->load->library( 'excel' );
		$filename = 'DrugSafe';
		$title    = 'Orders Report';
		$file     = $filename . '-' . $title; //save our workbook as this file name
		$this->excel->setActiveSheetIndex( 0 );
		$this->excel->getActiveSheet()->setTitle( $title );
		$this->excel->getActiveSheet()->setCellValue( 'A1', '#' );
		$this->excel->getActiveSheet()->getStyle( 'A1' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'A1' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'A1' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		if ( $_SESSION['drugsafe_user']['iRole'] == 1 ) {
			$this->excel->getActiveSheet()->setCellValue( 'B1', 'Franchisee' );
			$this->excel->getActiveSheet()->getStyle( 'B1' )->getFont()->setSize( 13 );
			$this->excel->getActiveSheet()->getStyle( 'B1' )->getFont()->setBold( true );
			$this->excel->getActiveSheet()->getStyle( 'B1' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
			$this->excel->getActiveSheet()->setCellValue( 'C1', 'Order Date' );
			$this->excel->getActiveSheet()->getStyle( 'C1' )->getFont()->setSize( 13 );
			$this->excel->getActiveSheet()->getStyle( 'C1' )->getFont()->setBold( true );
			$this->excel->getActiveSheet()->getStyle( 'C1' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
			$this->excel->getActiveSheet()->setCellValue( 'D1', 'Order #' );
			$this->excel->getActiveSheet()->getStyle( 'D1' )->getFont()->setSize( 13 );
			$this->excel->getActiveSheet()->getStyle( 'D1' )->getFont()->setBold( true );
			$this->excel->getActiveSheet()->getStyle( 'D1' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
			$this->excel->getActiveSheet()->setCellValue( 'E1', 'Status' );
			$this->excel->getActiveSheet()->getStyle( 'E1' )->getFont()->setSize( 13 );
			$this->excel->getActiveSheet()->getStyle( 'E1' )->getFont()->setBold( true );
			$this->excel->getActiveSheet()->getStyle( 'E1' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
			$this->excel->getActiveSheet()->setCellValue( 'F1', ' No. of Products' );
			$this->excel->getActiveSheet()->getStyle( 'F1' )->getFont()->setSize( 13 );
			$this->excel->getActiveSheet()->getStyle( 'F1' )->getFont()->setBold( true );
			$this->excel->getActiveSheet()->getStyle( 'F1' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
			$this->excel->getActiveSheet()->setCellValue( 'G1', 'Order Cost EXL GST' );
			$this->excel->getActiveSheet()->getStyle( 'G1' )->getFont()->setSize( 13 );
			$this->excel->getActiveSheet()->getStyle( 'G1' )->getFont()->setBold( true );
			$this->excel->getActiveSheet()->getStyle( 'G1' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
			/*$this->excel->getActiveSheet()->setCellValue('H1', 'Xero Invoice No.');
            $this->excel->getActiveSheet()->getStyle('H1')->getFont()->setSize(13);
            $this->excel->getActiveSheet()->getStyle('H1')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('H1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);*/
			$searchAry['szSearch1'] = $this->session->userdata( 'szSearch1' );
			$searchAry['szSearch2'] = $this->session->userdata( 'szSearch2' );
			$searchAry['szSearch4'] = $this->session->userdata( 'szSearch4' );
			$searchAry['szSearch5'] = $this->session->userdata( 'szSearch5' );
			$validOrdersDetailsAray = $this->Order_Model->getallValidOrderDetails( $searchAry );
			if ( ! empty( $validOrdersDetailsAray ) ) {
				$i = 2;
				$x = 0;
				foreach ( $validOrdersDetailsAray as $item ) {
					$franchiseeDetArr1 = $this->Admin_Model->getAdminDetailsByEmailOrId( '', $item['franchiseeid'] );
					if ( $item['status'] == 1 ) {
						$status = Ordered;
					}
					if ( $item['status'] == 2 ) {
						$status = Dispatched;
					}
					if ( $item['status'] == 3 ) {
						$status = Canceled;
					}
					$x ++;
					$this->excel->getActiveSheet()->setCellValue( 'A' . $i, $x );
					$this->excel->getActiveSheet()->setCellValue( 'B' . $i, $franchiseeDetArr1['szName'] );
					$this->excel->getActiveSheet()->setCellValue( 'C' . $i, date( 'd M Y', strtotime( $item['createdon'] ) ) . ' at ' . date( 'h:i A', strtotime( $item['createdon'] ) ) );
					$this->excel->getActiveSheet()->setCellValue( 'D' . $i, '#' . sprintf( __FORMAT_NUMBER__, $item['orderid'] ) );
					$this->excel->getActiveSheet()->setCellValue( 'E' . $i, $status );
					$this->excel->getActiveSheet()->setCellValue( 'F' . $i, $item['totalproducts'] );
					$this->excel->getActiveSheet()->setCellValue( 'G' . $i, '$' . ( $item['price'] > 0 ? number_format( $item['price'], 2, '.', ',' ) : '0.00' ) );
					//$this->excel->getActiveSheet()->setCellValue('H' . $i, (!empty($item['XeroIDnumber']) ? $item['XeroIDnumber'] : 'N/A'));
					$this->excel->getActiveSheet()->getColumnDimension( 'A' )->setAutoSize( true );
					$this->excel->getActiveSheet()->getColumnDimension( 'B' )->setAutoSize( true );
					$this->excel->getActiveSheet()->getColumnDimension( 'C' )->setAutoSize( true );
					$this->excel->getActiveSheet()->getColumnDimension( 'D' )->setAutoSize( true );
					$this->excel->getActiveSheet()->getColumnDimension( 'E' )->setAutoSize( true );
					$this->excel->getActiveSheet()->getColumnDimension( 'F' )->setAutoSize( true );
					$this->excel->getActiveSheet()->getColumnDimension( 'G' )->setAutoSize( true );
					//$this->excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(TRUE);
					$i ++;
				}
			}
		} else {
			$this->excel->getActiveSheet()->setCellValue( 'B1', 'Order Date' );
			$this->excel->getActiveSheet()->getStyle( 'B1' )->getFont()->setSize( 13 );
			$this->excel->getActiveSheet()->getStyle( 'B1' )->getFont()->setBold( true );
			$this->excel->getActiveSheet()->getStyle( 'B1' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
			$this->excel->getActiveSheet()->setCellValue( 'C1', 'Order #' );
			$this->excel->getActiveSheet()->getStyle( 'C1' )->getFont()->setSize( 13 );
			$this->excel->getActiveSheet()->getStyle( 'C1' )->getFont()->setBold( true );
			$this->excel->getActiveSheet()->getStyle( 'C1' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
			$this->excel->getActiveSheet()->setCellValue( 'D1', 'Status' );
			$this->excel->getActiveSheet()->getStyle( 'D1' )->getFont()->setSize( 13 );
			$this->excel->getActiveSheet()->getStyle( 'D1' )->getFont()->setBold( true );
			$this->excel->getActiveSheet()->getStyle( 'D1' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
			$this->excel->getActiveSheet()->setCellValue( 'E1', 'No. of Products' );
			$this->excel->getActiveSheet()->getStyle( 'E1' )->getFont()->setSize( 13 );
			$this->excel->getActiveSheet()->getStyle( 'E1' )->getFont()->setBold( true );
			$this->excel->getActiveSheet()->getStyle( 'E1' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
			$this->excel->getActiveSheet()->setCellValue( 'F1', 'Order Cost' );
			$this->excel->getActiveSheet()->getStyle( 'F1' )->getFont()->setSize( 13 );
			$this->excel->getActiveSheet()->getStyle( 'F1' )->getFont()->setBold( true );
			$this->excel->getActiveSheet()->getStyle( 'F1' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
			/*$this->excel->getActiveSheet()->setCellValue('G1', 'Xero Invoice No.');
            $this->excel->getActiveSheet()->getStyle('G1')->getFont()->setSize(13);
            $this->excel->getActiveSheet()->getStyle('G1')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('G1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);*/
			$searchAry['szSearch1'] = $this->session->userdata( 'szSearch1' );
			$searchAry['szSearch2'] = $this->session->userdata( 'szSearch2' );
			$searchAry['szSearch4'] = $this->session->userdata( 'szSearch4' );
			$searchAry['szSearch5'] = $this->session->userdata( 'szSearch5' );
			$validOrdersDetailsAray = $this->Order_Model->getallValidOrderDetails( $searchAry );
			if ( ! empty( $validOrdersDetailsAray ) ) {
				$i = 2;
				$x = 0;
				foreach ( $validOrdersDetailsAray as $item ) {
					$franchiseeDetArr1 = $this->Admin_Model->getAdminDetailsByEmailOrId( '', $item['franchiseeid'] );
					$x ++;
					if ( $item['status'] == 1 ) {
						$status = 'Ordered';
					}
					if ( $item['status'] == 2 ) {
						$status = 'Dispatched';
					}
					if ( $item['status'] == 3 ) {
						$status = 'Canceled';
					}
					$this->excel->getActiveSheet()->setCellValue( 'A' . $i, $x );
					$this->excel->getActiveSheet()->setCellValue( 'B' . $i, date( 'd M Y', strtotime( $item['createdon'] ) ) . ' at ' . date( 'h:i A', strtotime( $item['createdon'] ) ) );
					$this->excel->getActiveSheet()->setCellValue( 'C' . $i, '#' . sprintf( __FORMAT_NUMBER__, $item['orderid'] ) );
					$this->excel->getActiveSheet()->setCellValue( 'D' . $i, $status );
					$this->excel->getActiveSheet()->setCellValue( 'E' . $i, $item['totalproducts'] );
					$this->excel->getActiveSheet()->setCellValue( 'F' . $i, '$' . ( $item['price'] > 0 ? number_format( $item['price'], 2, '.', ',' ) : '0.00' ) );
					//$this->excel->getActiveSheet()->setCellValue('G' . $i, (!empty($item['XeroIDnumber']) ? $item['XeroIDnumber'] : 'N/A'));
					$this->excel->getActiveSheet()->getColumnDimension( 'A' )->setAutoSize( true );
					$this->excel->getActiveSheet()->getColumnDimension( 'B' )->setAutoSize( true );
					$this->excel->getActiveSheet()->getColumnDimension( 'C' )->setAutoSize( true );
					$this->excel->getActiveSheet()->getColumnDimension( 'D' )->setAutoSize( true );
					$this->excel->getActiveSheet()->getColumnDimension( 'E' )->setAutoSize( true );
					$this->excel->getActiveSheet()->getColumnDimension( 'F' )->setAutoSize( true );
					//$this->excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(TRUE);
					$i ++;
				}
			}
		}
		header( 'Content-Type: application/vnd.ms-excel' ); //mime type
		header( 'Content-Disposition: attachment;filename="' . $file . '"' ); //tell browser what's the file name
		header( 'Cache-Control: max-age=0' ); //no cache
//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
//if you want to save it as .XLSX Excel 2007 format
		$objWriter = PHPExcel_IOFactory::createWriter( $this->excel, 'Excel5' );
//force user to download the Excel file without writing it to server's HD
		$objWriter->save( 'php://output' );
	}
	function ViewpdfofRevenueGenerate() {
		$dtStart      = $this->input->post( 'dtStart' );
		$dtEnd        = $this->input->post( 'dtEnd' );
		$szFranchisee = $this->input->post( 'szFranchisee' );
		$this->session->set_userdata( 'dtStart', $dtStart );
		$this->session->set_userdata( 'dtEnd', $dtEnd );
		$this->session->set_userdata( 'szFranchisee', $szFranchisee );
		echo "SUCCESS||||";
		echo "ViewpdfRevenueGenerate";
	}
	public function ViewpdfRevenueGenerate() {
		ob_start();
		$this->load->library( 'Pdf' );
		$pdf = new Pdf( 'P', 'mm', 'A4', true, 'UTF-8', false );
		$pdf->SetCreator( PDF_CREATOR );
		$pdf->SetTitle( 'Drug-safe Revenue Generate' );
		$pdf->SetAuthor( 'Drug-safe' );
		$pdf->SetSubject( 'Revenue Generate PDF' );
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
		$pdf->AddPage( 'L' );
		$searchAry['dtStart']        = $this->session->userdata( 'dtStart' );
		$searchAry['dtEnd']          = $this->session->userdata( 'dtEnd' );
		$searchAry['szFranchisee']   = $this->session->userdata( 'szFranchisee' );
		$getManualCalcStartToEndDate = $this->Reporting_Model->getAllRevenueManualalc( $searchAry, $searchAry['szFranchisee'] );
		$html = '<a style="text-align:center;  margin-bottom:5px;" href="' . __BASE_URL__ . '" ><img style="width:145px" src="' . __BASE_URL__ . '/images/logo.png" alt="logo" class="logo-default" /> </a>
            <div><p style="text-align:center; font-size:18px; margin-bottom:5px; color:black"><b>Revenue Generate</b></p></div>
            <div class= "table-responsive" >
                            <table border="1" cellpadding="5">
                                    <tr>
                                        <th width="5%"><b>  #</b> </th>
                                        <th width="13%"> <b>Proforma Invoice #</b> </th>
                                        <th width="14%"> <b>Proforma Invoice Date </b> </th>
                                        <th width="13%" ><b> Client Code  </b> </th>
                                        <th width="14%" > <b>Client Name</b> </th>
                                        <th width="13%"><b> Revenue EXL GST </b> </th>
                                        <th width="14%"> <b>Royalty Fees</b> </th>
                                        <th width="13%"> <b>Net Revenue EXL GST</b> </th>
                                    </tr>';
		if ( $getManualCalcStartToEndDate ) {
			$i                = 0;
			$totalRevenu      = '';
			$totalRoyaltyfees = '';
			$totalNetProfit   = '';
			foreach ( $getManualCalcStartToEndDate as $getManualCalcData ) {
				$getClientId          = $this->Form_Management_Model->getSosDetailBySosId( $getManualCalcData['sosid'] );
				$getClientDetails     = $this->Admin_Model->getAdminDetailsByEmailOrId( '', $getClientId['Clientid'] );
				$franchiseecode       = $this->Franchisee_Model->getusercodebyuserid( $getClientDetails['id'] );
				$ClirntDetailsDataAry = $this->Franchisee_Model->getParentClientDetailsId( $getClientId['Clientid'] );
				$userDataAry          = $this->Admin_Model->getUserDetailsByEmailOrId( '', $ClirntDetailsDataAry['clientType'] );
				$discount             = $this->Ordering_Model->getClientDiscountByClientId( $ClirntDetailsDataAry['clientType'] );
				$data                 = $this->Ordering_Model->getManualCalculationBySosId( $getManualCalcData['sosid'] );
				$DrugtestidArr        = array_map( 'intval', str_split( $getClientId['Drugtestid'] ) );
				if ( in_array( 1, $DrugtestidArr ) || in_array( 2, $DrugtestidArr ) || in_array( 3, $DrugtestidArr ) || in_array( 4, $DrugtestidArr ) ) {
					$countDoner = count( $this->Form_Management_Model->getDonarDetailBySosId( $getManualCalcData['sosid'] ) );
				}
				$ValTotal = 0;
				if ( in_array( 1, $DrugtestidArr ) ) {
					$ValTotal = number_format( $ValTotal + $countDoner * __RRP_1__, 2, '.', '' );
				}
				if ( in_array( 2, $DrugtestidArr ) ) {
					$ValTotal = number_format( $ValTotal + $countDoner * __RRP_2__, 2, '.', '' );
				}
				if ( in_array( 3, $DrugtestidArr ) ) {
					$ValTotal = number_format( $ValTotal + $countDoner * __RRP_3__, 2, '.', '' );
				}
				if ( in_array( 4, $DrugtestidArr ) ) {
					$ValTotal = number_format( $ValTotal + $countDoner * __RRP_4__, 2, '.', '' );
				}
				$GST                = $ValTotal * 0.1;
				$GST                = number_format( $GST, 2, '.', '' );
				$TotalbeforeRoyalty = $ValTotal + $GST;
				$TotalbeforeRoyalty = number_format( $TotalbeforeRoyalty, 2, '.', '' );
				$DcmobileScreen     = $data['mobileScreenBasePrice'] * ( $data['mobileScreenHr'] > 1 ? $data['mobileScreenHr'] : 1 );
				$mobileScreen       = $data['mcbp'] * ( $data['mchr'] > 1 ? $data['mchr'] : 1 );
				$calloutprice       = $data['cobp'] * ( $data['cohr'] > 3 ? $data['cohr'] : 3 );
				$fcoprice           = $data['fcobp'] * ( $data['fcohr'] > 2 ? $data['fcohr'] : 2 );
				$travel             = $data['travelBasePrice'] * ( $data['travelHr'] > 1 ? $data['travelHr'] : 1 );
				$TotalTrevenu = $data['urineNata'] + $data['labconf'] + $data['cancelfee'] + $data['nataLabCnfrm'] + $data['oralFluidNata'] + $data['SyntheticCannabinoids'] + $data['labScrenning'] + $data['RtwScrenning'] + $mobileScreen + $DcmobileScreen + $travel + $calloutprice + $fcoprice;
				$TotalTrevenu    = number_format( $TotalTrevenu, 2, '.', '' );
				$GSTmanual       = ( $TotalTrevenu * 0.1 );
				$GSTmanual       = number_format( $GSTmanual, 2, '.', '' );
				$Total1          = $TotalTrevenu + $GSTmanual;
				$Total1          = number_format( $Total1, 2, '.', '' );
				$totalinvoiceAmt = $ValTotal + $TotalTrevenu;
				if ( ! empty( $discount ) ) {
					$discountpercent = $discount['percentage'];
				} else {
					$discountpercent = 0;
				}
				if ( $discountpercent > 0 ) {
					$totaldiscount      = $totalinvoiceAmt * $discountpercent * 0.01;
					$totalafterdiscount = $totalinvoiceAmt - $totaldiscount;
					$totalGst           = $totalafterdiscount * 0.1;
					$totalRoyaltyBefore = $totalGst + $totalafterdiscount;
				} else {
					$totalGst           = $GST + $GSTmanual;
					$totalRoyaltyBefore = $Total1 + $TotalbeforeRoyalty;
					$totaldiscount      = 0;
					$totalafterdiscount = 0;
				}
				$Royaltyfees = ( $discountpercent > 0 ? number_format( $totalafterdiscount, 2, '.', '' ) : number_format( $totalinvoiceAmt, 2, '.', '' ) ) * 0.1;
				$Royaltyfees = number_format( $Royaltyfees, 2, '.', '' );
				$NetTotal = ( $discountpercent > 0 ? number_format( $totalafterdiscount, 2, '.', '' ) : number_format( $totalinvoiceAmt, 2, '.', '' ) ) - $Royaltyfees;
				$NetTotal = number_format( $NetTotal, 2, '.', '' );
				$totalRevenu      = $totalRevenu + ( $discountpercent > 0 ? number_format( $totalafterdiscount, 2, '.', '' ) : number_format( $totalinvoiceAmt, 2, '.', '' ) );
				$totalRoyaltyfees = $totalRoyaltyfees + $Royaltyfees;
				$totalNetProfit   = $totalNetProfit + $NetTotal;
				$i ++;
				$html .= '<tr>
                            <td> ' . $i . ' </td>
                            <td> #' . sprintf( __FORMAT_NUMBER__, $getManualCalcData['id'] ) . '</td>
                            <td> ' . date( "d-m-Y", strtotime( $getManualCalcData['dtCreatedOn'] ) ) . ' </td>
                            <td>' . ( ! empty( $franchiseecode['userCode'] ) ? $franchiseecode['userCode'] : 'N/A' ) . ' </td>
                            <td>' . $userDataAry['szName'] . ' </td>
                            <td>$' . ( $discountpercent > 0 ? number_format( $totalafterdiscount, 2, '.', ',' ) : number_format( $totalinvoiceAmt, 2, '.', ',' ) ) . ' </td>
                            <td>$' . number_format( $Royaltyfees, 2, '.', ',' ) . ' </td>
                            <td>$' . number_format( $NetTotal, 2, '.', ',' ) . '</td>
                        </tr>';
			}
			$html .= '<tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><b>Total</b></td>
                    <td>$' . $totalRevenu . '</td>
                    <td>$' . $totalRoyaltyfees . '</td>
                    <td>$' . $totalNetProfit . '</td>
                   </tr>';
		}
		$html .= '
                            </table>
                        </div>
                      
                        ';
		$pdf->writeHTML( $html, true, false, true, false, '' );
//    $pdf->Write(5, 'CodeIgniter TCPDF Integration');
		error_reporting( E_ALL );
		$pdf->Output( 'revenue-generate.pdf', 'I' );
	}
	function ViewexcelofRevenueGenerate() {
		$dtStart      = $this->input->post( 'dtStart' );
		$dtEnd        = $this->input->post( 'dtEnd' );
		$szFranchisee = $this->input->post( 'szFranchisee' );
		$this->session->set_userdata( 'dtStart', $dtStart );
		$this->session->set_userdata( 'dtEnd', $dtEnd );
		$this->session->set_userdata( 'szFranchisee', $szFranchisee );
		echo "SUCCESS||||";
		echo "ViewexcelRevenueGenerate";
	}
	public function ViewexcelRevenueGenerate() {
		$this->load->library( 'excel' );
		$filename = 'DrugSafe';
		$title    = 'Revenue Generate';
		$file     = $filename . '-' . $title; //save our workbook as this file name
		$this->excel->setActiveSheetIndex( 0 );
		$this->excel->getActiveSheet()->setTitle( $title );
		$this->excel->getActiveSheet()->setCellValue( 'A1', '#' );
		$this->excel->getActiveSheet()->getStyle( 'A1' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'A1' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'A1' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'B1', 'Proforma Invoice #' );
		$this->excel->getActiveSheet()->getStyle( 'B1' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'B1' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'B1' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'C1', 'Proforma Invoice Date' );
		$this->excel->getActiveSheet()->getStyle( 'C1' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'C1' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'C1' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'D1', 'Client Code' );
		$this->excel->getActiveSheet()->getStyle( 'D1' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'D1' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'D1' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'E1', 'Client Name' );
		$this->excel->getActiveSheet()->getStyle( 'E1' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'E1' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'E1' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'F1', ' Revenue EXL GST' );
		$this->excel->getActiveSheet()->getStyle( 'F1' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'F1' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'F1' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'G1', 'Royalty Fees' );
		$this->excel->getActiveSheet()->getStyle( 'G1' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'G1' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'G1' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'H1', 'Net Revenue EXL GST' );
		$this->excel->getActiveSheet()->getStyle( 'H1' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'H1' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'H1' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$searchAry['dtStart']      = $this->session->userdata( 'dtStart' );
		$searchAry['dtEnd']        = $this->session->userdata( 'dtEnd' );
		$searchAry['szFranchisee'] = $this->session->userdata( 'szFranchisee' );
		//$getClientDeatils=$this->Webservices_Model->getclientdetails($searchAry['szFranchisee']);
		$getClientDeatils = $this->Ordering_Model->getAllChClientDetails( '', '', $searchAry['szFranchisee'] );
		$id               = array();
		foreach ( $getClientDeatils as $getClientData ) {
			array_push( $id, $getClientData['clientId'] );
		}
		$getSosDetails = $this->Form_Management_Model->getsosFormDetailsByMultipleClientId( $id );
		$sosId         = array();
		foreach ( $getSosDetails as $getSosData ) {
			array_push( $sosId, $getSosData['id'] );
		}
		if ( ! empty( $sosId ) ) {
			$getManualCalcStartToEndDate = $this->Order_Model->getManualCalcStartToEndDate( $searchAry, $sosId );
		}
		if ( ! empty( $getManualCalcStartToEndDate ) ) {
			$i                = 2;
			$x                = 0;
			$totalRevenu      = '';
			$totalRoyaltyfees = '';
			$totalNetProfit   = '';
			foreach ( $getManualCalcStartToEndDate as $getManualCalcData ) {
				$getClientId          = $this->Form_Management_Model->getSosDetailBySosId( $getManualCalcData['sosid'] );
				$getClientDetails     = $this->Admin_Model->getAdminDetailsByEmailOrId( '', $getClientId['Clientid'] );
				$franchiseecode       = $this->Franchisee_Model->getusercodebyuserid( $getClientDetails['id'] );
				$ClirntDetailsDataAry = $this->Franchisee_Model->getParentClientDetailsId( $getClientId['Clientid'] );
				$userDataAry          = $this->Admin_Model->getUserDetailsByEmailOrId( '', $ClirntDetailsDataAry['clientType'] );
				$discount             = $this->Ordering_Model->getClientDiscountByClientId( $ClirntDetailsDataAry['clientType'] );
				$data                 = $this->Ordering_Model->getManualCalculationBySosId( $getManualCalcData['sosid'] );
				$DrugtestidArr        = array_map( 'intval', str_split( $getClientId['Drugtestid'] ) );
				if ( in_array( 1, $DrugtestidArr ) || in_array( 2, $DrugtestidArr ) || in_array( 3, $DrugtestidArr ) || in_array( 4, $DrugtestidArr ) ) {
					$countDoner = count( $this->Form_Management_Model->getDonarDetailBySosId( $getManualCalcData['sosid'] ) );
				}
				$ValTotal = 0;
				if ( in_array( 1, $DrugtestidArr ) ) {
					$ValTotal = number_format( $ValTotal + $countDoner * __RRP_1__, 2, '.', '' );
				}
				if ( in_array( 2, $DrugtestidArr ) ) {
					$ValTotal = number_format( $ValTotal + $countDoner * __RRP_2__, 2, '.', '' );
				}
				if ( in_array( 3, $DrugtestidArr ) ) {
					$ValTotal = number_format( $ValTotal + $countDoner * __RRP_3__, 2, '.', '' );
				}
				if ( in_array( 4, $DrugtestidArr ) ) {
					$ValTotal = number_format( $ValTotal + $countDoner * __RRP_4__, 2, '.', '' );
				}
				$GST                = $ValTotal * 0.1;
				$GST                = number_format( $GST, 2, '.', '' );
				$TotalbeforeRoyalty = $ValTotal + $GST;
				$TotalbeforeRoyalty = number_format( $TotalbeforeRoyalty, 2, '.', '' );
				$DcmobileScreen     = $data['mobileScreenBasePrice'] * ( $data['mobileScreenHr'] > 1 ? $data['mobileScreenHr'] : 1 );
				$mobileScreen       = $data['mcbp'] * ( $data['mchr'] > 1 ? $data['mchr'] : 1 );
				$calloutprice       = $data['cobp'] * ( $data['cohr'] > 3 ? $data['cohr'] : 3 );
				$fcoprice           = $data['fcobp'] * ( $data['fcohr'] > 2 ? $data['fcohr'] : 2 );
				$travel             = $data['travelBasePrice'] * ( $data['travelHr'] > 1 ? $data['travelHr'] : 1 );
				$TotalTrevenu = $data['urineNata'] + $data['labconf'] + $data['cancelfee'] + $data['nataLabCnfrm'] + $data['oralFluidNata'] + $data['SyntheticCannabinoids'] + $data['labScrenning'] + $data['RtwScrenning'] + $mobileScreen + $DcmobileScreen + $travel + $calloutprice + $fcoprice;
				$TotalTrevenu    = number_format( $TotalTrevenu, 2, '.', '' );
				$GSTmanual       = ( $TotalTrevenu * 0.1 );
				$GSTmanual       = number_format( $GSTmanual, 2, '.', '' );
				$Total1          = $TotalTrevenu + $GSTmanual;
				$Total1          = number_format( $Total1, 2, '.', '' );
				$totalinvoiceAmt = $ValTotal + $TotalTrevenu;
				if ( ! empty( $discount ) ) {
					$discountpercent = $discount['percentage'];
				} else {
					$discountpercent = 0;
				}
				if ( $discountpercent > 0 ) {
					$totaldiscount      = $totalinvoiceAmt * $discountpercent * 0.01;
					$totalafterdiscount = $totalinvoiceAmt - $totaldiscount;
					$totalGst           = $totalafterdiscount * 0.1;
					$totalRoyaltyBefore = $totalGst + $totalafterdiscount;
				} else {
					$totalGst           = $GST + $GSTmanual;
					$totalRoyaltyBefore = $Total1 + $TotalbeforeRoyalty;
					$totaldiscount      = 0;
					$totalafterdiscount = 0;
				}
				$Royaltyfees = ( $discountpercent > 0 ? number_format( $totalafterdiscount, 2, '.', '' ) : number_format( $totalinvoiceAmt, 2, '.', '' ) ) * 0.1;
				$Royaltyfees = number_format( $Royaltyfees, 2, '.', '' );
				$NetTotal = ( $discountpercent > 0 ? number_format( $totalafterdiscount, 2, '.', '' ) : number_format( $totalinvoiceAmt, 2, '.', '' ) ) - $Royaltyfees;
				$NetTotal = number_format( $NetTotal, 2, '.', '' );
				$totalRevenu      = $totalRevenu + ( $discountpercent > 0 ? number_format( $totalafterdiscount, 2, '.', '' ) : number_format( $totalinvoiceAmt, 2, '.', '' ) );
				$totalRoyaltyfees = $totalRoyaltyfees + $Royaltyfees;
				$totalNetProfit   = $totalNetProfit + $NetTotal;
				$x ++;
				$this->excel->getActiveSheet()->setCellValue( 'A' . $i, $x );
				$this->excel->getActiveSheet()->setCellValue( 'B' . $i, '#' . sprintf( __FORMAT_NUMBER__, $getManualCalcData['id'] ) );
				$this->excel->getActiveSheet()->setCellValue( 'C' . $i, date( "d-m-Y", strtotime( $getManualCalcData['dtCreatedOn'] ) ) );
				$this->excel->getActiveSheet()->setCellValue( 'D' . $i, ( ! empty( $franchiseecode['userCode'] ) ? $franchiseecode['userCode'] : 'N/A' ) );
				$this->excel->getActiveSheet()->setCellValue( 'E' . $i, $userDataAry['szName'] );
				$this->excel->getActiveSheet()->setCellValue( 'F' . $i, '$' . ( $discountpercent > 0 ? number_format( $totalafterdiscount, 2, '.', ',' ) : number_format( $totalinvoiceAmt, 2, '.', ',' ) ) );
				$this->excel->getActiveSheet()->setCellValue( 'G' . $i, '$' . number_format( $Royaltyfees, 2, '.', ',' ) );
				$this->excel->getActiveSheet()->setCellValue( 'H' . $i, '$' . number_format( $NetTotal, 2, '.', ',' ) );
				$this->excel->getActiveSheet()->getColumnDimension( 'A' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'B' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'C' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'D' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'E' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'F' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'G' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'H' )->setAutoSize( true );
				$i ++;
			}
			$this->excel->getActiveSheet()->setCellValue( 'E' . $i, Total );
			$this->excel->getActiveSheet()->getStyle( 'E' . $i )->getFont()->setSize( 13 );
			$this->excel->getActiveSheet()->getStyle( 'E' . $i )->getFont()->setBold( true );
			$this->excel->getActiveSheet()->getStyle( 'E' . $i )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
			$this->excel->getActiveSheet()->setCellValue( 'F' . $i, '$' . number_format( $totalRevenu, 2, '.', ',' ) );
			$this->excel->getActiveSheet()->setCellValue( 'G' . $i, '$' . number_format( $totalRoyaltyfees, 2, '.', ',' ) );
			$this->excel->getActiveSheet()->setCellValue( 'H' . $i, '$' . number_format( $totalNetProfit, 2, '.', ',' ) );
		}
		header( 'Content-Type: application/vnd.ms-excel' ); //mime type
		header( 'Content-Disposition: attachment;filename="' . $file . '"' ); //tell browser what's the file name
		header( 'Cache-Control: max-age=0' ); //no cache
//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
//if you want to save it as .XLSX Excel 2007 format
		$objWriter = PHPExcel_IOFactory::createWriter( $this->excel, 'Excel5' );
//force user to download the Excel file without writing it to server's HD
		$objWriter->save( 'php://output' );
	}
	public function view_revenue_generate() {
		$count         = $this->Admin_Model->getnotification();
		$is_user_login = is_user_login( $this );
		// redirect to dashboard if already logged in
		if ( ! $is_user_login ) {
			ob_end_clean();
			redirect( base_url( '/admin/admin_login' ) );
			die;
		}
		if ( $_SESSION['drugsafe_user']['iRole'] == '5' ) {
			$searchOptionArr = $this->Admin_Model->viewFranchiseeList( false, $_SESSION['drugsafe_user']['id'], false, false, false, false, false, false, 1 );
		} elseif ( $_SESSION['drugsafe_user']['iRole'] == '1' ) {
			$searchOptionArr = $this->Admin_Model->viewFranchiseeList( false, false, false, false, false, false, false, false, 1 );
		} else {
			$searchOptionArr = array();
		}
		$this->load->library( 'form_validation' );
		$this->form_validation->set_rules( 'szFranchisee', 'Franchisee ', 'required' );
		$this->form_validation->set_rules( 'dtStart', 'Start Revenue date ', 'required' );
                if(!empty($_POST['dtEnd'])){
                 $this->form_validation->set_rules('dtEnd', 'End Revenue date', 'required|callback_endRevenueDate_check');    
                }
                else{
                 $this->form_validation->set_rules( 'dtEnd', 'End Revenue date', 'required' );   
                }
		if ( $_POST['dtStart'] != '' && $_POST['dtEnd'] != '' && $_POST['szFranchisee'] != '' ) {
			$searchAry = $_POST;
			$getManualCalcStartToEndDate = $this->Reporting_Model->getAllRevenueManualalc( $searchAry, $_POST['szFranchisee'] );
		}
		$this->form_validation->set_message( 'required', '{field} is required.' );
		if ( $this->form_validation->run() == false ) {
			$data['getManualCalcStartToEndDate'] = $getManualCalcStartToEndDate;
			$data['szMetaTagTitle']              = "Revenue Generate";
			$data['is_user_login']               = $is_user_login;
			$data['pageName']                    = "Reporting";
			$data['subpageName']                 = "revenue_generate";
			$data['notification']                = $count;
			$data['data']                        = $data;
			$data['allfranchisee']               = $searchOptionArr;
			$data['arErrorMessages']             = $this->Order_Model->arErrorMessages;
			//$data['drugtestkitlist'] = $drugTestKitListAray;
			$this->load->view( 'layout/admin_header', $data );
			$this->load->view( 'reporting/viewRevenueGenerateReport' );
			$this->load->view( 'layout/admin_footer' );
		} else {
			$data['getManualCalcStartToEndDate'] = $getManualCalcStartToEndDate;
			$data['szMetaTagTitle']              = "Revenue Generate";
			$data['is_user_login']               = $is_user_login;
			$data['pageName']                    = "Reporting";
			$data['subpageName']                 = "revenue_generate";
			$data['notification']                = $count;
			$data['data']                        = $data;
			$data['allfranchisee']               = $searchOptionArr;
			$data['arErrorMessages']             = $this->Order_Model->arErrorMessages;
			//$data['drugtestkitlist'] = $drugTestKitListAray;
			$this->load->view( 'layout/admin_header', $data );
			$this->load->view( 'reporting/viewRevenueGenerateReport' );
			$this->load->view( 'layout/admin_footer' );
		}
	}
  function endRevenueDate_check()
        {
          $searchAry = $_POST;
          $dtStart = $this->Order_Model->getSqlFormattedDate($searchAry['dtStart']);
          $dtEnd = $this->Order_Model->getSqlFormattedDate($searchAry['dtEnd']);
          
          
          if(($dtStart)> ($dtEnd))
          {
              $this->form_validation->set_message('endRevenueDate_check', 'End Revenue date should be greater than Start Revenue date.');
               return false;
          }
          else{
               return true;
          }
          
       }
	public function franchisee_revenue_generate() {
		$count         = $this->Admin_Model->getnotification();
		$is_user_login = is_user_login( $this );
		// redirect to dashboard if already logged in
		if ( ! $is_user_login ) {
			ob_end_clean();
			redirect( base_url( '/admin/admin_login' ) );
			die;
		}
		$idfranchisee    = $_SESSION['drugsafe_user']['id'];
		$searchOptionArr = $this->Admin_Model->viewFranchiseeList();
		$this->load->library( 'form_validation' );
		$this->form_validation->set_rules( 'szFranchisee', 'Franchisee ', 'required' );
		$this->form_validation->set_rules( 'dtStart', 'Start Revenue date ', 'required' );
                if(!empty($_POST['dtEnd'])){
                 $this->form_validation->set_rules('dtEnd', 'End Revenue date', 'required|callback_endRevenueDate_check');    
                }
                else{
                 $this->form_validation->set_rules( 'dtEnd', 'End Revenue date', 'required' );   
                }
		
		if ( $_POST['dtStart'] != '' && $_POST['dtEnd'] != '' && $idfranchisee != '' ) {
			$searchAry                   = $_POST;
			$getManualCalcStartToEndDate = $this->Reporting_Model->getAllRevenueManualalc( $searchAry, $idfranchisee );
		}
		$this->form_validation->set_message( 'required', '{field} is required.' );
		if ( $this->form_validation->run() == false ) {
			$data['getManualCalcStartToEndDate'] = $getManualCalcStartToEndDate;
			$data['szMetaTagTitle']              = "Revenue Generate";
			$data['is_user_login']               = $is_user_login;
			$data['pageName']                    = "Reporting";
			$data['subpageName']                 = "revenue_generate";
			$data['notification']                = $count;
			$data['data']                        = $data;
			$data['idfranchisee']                = $idfranchisee;
			$data['allfranchisee']               = $searchOptionArr;
			$data['arErrorMessages']             = $this->Order_Model->arErrorMessages;
			//$data['drugtestkitlist'] = $drugTestKitListAray;
			$this->load->view( 'layout/admin_header', $data );
			$this->load->view( 'reporting/franchiseeRevenueGenerateReport' );
			$this->load->view( 'layout/admin_footer' );
		} else {
			$data['getManualCalcStartToEndDate'] = $getManualCalcStartToEndDate;
			$data['szMetaTagTitle']              = "Revenue Generate";
			$data['is_user_login']               = $is_user_login;
			$data['pageName']                    = "Reporting";
			$data['subpageName']                 = "revenue_generate";
			$data['notification']                = $count;
			$data['data']                        = $data;
			$data['allfranchisee']   = $searchOptionArr;
			$data['arErrorMessages'] = $this->Order_Model->arErrorMessages;
			//$data['drugtestkitlist'] = $drugTestKitListAray;
			$this->load->view( 'layout/admin_header', $data );
			$this->load->view( 'reporting/franchiseeRevenueGenerateReport' );
			$this->load->view( 'layout/admin_footer' );
		}
	}
	public function view_revenue_summery() {
		$count         = $this->Admin_Model->getnotification();
		$is_user_login = is_user_login( $this );
		// redirect to dashboard if already logged in
		if ( ! $is_user_login ) {
			ob_end_clean();
			redirect( base_url( '/admin/admin_login' ) );
			die;
		}
		if ( $_POST['dtStart'] != '' && $_POST['dtEnd'] != '' ) {
			$searchAry    = $_POST;
			$franchiseeId = $this->Form_Management_Model->getAllsosFormDetails( $searchAry );
		}
		$this->load->library( 'form_validation' );
		$this->form_validation->set_rules( 'dtStart', 'Start Revenue date ', 'required' );
		 if(!empty($_POST['dtEnd'])){
                 $this->form_validation->set_rules('dtEnd', 'End Revenue date', 'required|callback_endRevenueDate_check');    
                }
                else{
                 $this->form_validation->set_rules( 'dtEnd', 'End Revenue date', 'required' );   
                }
		$this->form_validation->set_message( 'required', '{field} is required.' );
		if ( $this->form_validation->run() == false ) {
			$data['getManualCalcStartToEndDate']        = $getManualCalcStartToEndDate;
			$data['szMetaTagTitle']                     = "Revenue Summary";
			$data['is_user_login']                      = $is_user_login;
			$data['pageName']                           = "Reporting";
			$data['subpageName']                        = "revenue_summery";
			$data['notification']                       = $count;
			$data['data']                               = $data;
			$data['getSummeryManualCalcStartToEndDate'] = $getSummeryManualCalcStartToEndDate;
			$data['searchAry']                          = $_POST;
			$data['allfranchisee']                      = $franchiseeId;
			$data['arErrorMessages']                    = $this->Reporting_Model->arErrorMessages;
			$this->load->view( 'layout/admin_header', $data );
			$this->load->view( 'reporting/viewRevenueSummery' );
			$this->load->view( 'layout/admin_footer' );
		} else {
			$data['getManualCalcStartToEndDate']        = $getManualCalcStartToEndDate;
			$data['szMetaTagTitle']                     = "Revenue Summary";
			$data['is_user_login']                      = $is_user_login;
			$data['pageName']                           = "Reporting";
			$data['subpageName']                        = "revenue_summery";
			$data['notification']                       = $count;
			$data['data']                               = $data;
			$data['getSummeryManualCalcStartToEndDate'] = $getSummeryManualCalcStartToEndDate;
			$data['searchAry']                          = $_POST;
			$data['allfranchisee']                      = $franchiseeId;
			$data['arErrorMessages']                    = $this->Reporting_Model->arErrorMessages;
			$this->load->view( 'layout/admin_header', $data );
			$this->load->view( 'reporting/viewRevenueSummery' );
			$this->load->view( 'layout/admin_footer' );
		}
	}
	function ViewpdfofRevenueSummery() {
		$dtStart = $this->input->post( 'dtStart' );
		$dtEnd   = $this->input->post( 'dtEnd' );
		$this->session->set_userdata( 'dtStart', $dtStart );
		$this->session->set_userdata( 'dtEnd', $dtEnd );
		echo "SUCCESS||||";
		echo "ViewpdfRevenueSummery";
	}
	public function ViewpdfRevenueSummery() {
		ob_start();
		$this->load->library( 'Pdf' );
		$pdf = new Pdf( 'L', 'mm', 'A4', true, 'UTF-8', false );
		$pdf->SetCreator( PDF_CREATOR );
		$pdf->SetTitle( 'Drug-safe Revenue Summary' );
		$pdf->SetAuthor( 'Drug-safe' );
		$pdf->SetSubject( 'Revenue Summary PDF' );
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
		$pdf->AddPage( 'L' );
		//$pdf->AddPage();
		$searchAry['dtStart'] = $this->session->userdata( 'dtStart' );
		$searchAry['dtEnd']   = $this->session->userdata( 'dtEnd' );
		$allfranchisee        = $this->Form_Management_Model->getAllsosFormDetails( $searchAry );
		$html                 = '<a style="text-align:center;  margin-bottom:5px;" href="' . __BASE_URL__ . '" ><img style="width:145px" src="' . __BASE_URL__ . '/images/logo.png" alt="logo" class="logo-default" /> </a>
            <div><p style="text-align:center; font-size:18px; margin-bottom:5px; color:black"><b>Revenue Summary</b></p></div>
            <div class= "table-responsive" >
                            <table align="center" border="1" cellpadding="5" >
                                    <tr>
                                        <th width="10%"><b>  #</b> </th>
                                        <th width="22%"> <b>Franchisee Name </b> </th>
                                        <th width="22%"> <b> Revenue EXL GST</b> </th>
                                        <th width="22%"><b> Royalty Fees </b> </th>
                                        <th width="23%"> <b>Net Revenue EXL GST</b> </th>
                                    </tr>';
		if ( $allfranchisee ) {
			$i                = 0;
			$totalRevenu      = '';
			$totalRoyaltyfees = '';
			$totalNetProfit   = '';
			$allfranchiseeTotalAfterDis    = '';
			$allfranchiseetotalRoyaltyfees = '';
			$allfranchiseetotalNetProfit   = '';
			foreach ( $allfranchisee as $allfranchiseeData ) {
				$getManualCalcStartToEndDate = $this->Reporting_Model->getAllRevenueManualalc( $searchAry, $allfranchiseeData['franchiseeId'] );
				$getAdmindetails             = $this->Admin_Model->getAdminDetailsByEmailOrId( '', $allfranchiseeData['franchiseeId'] );
				$totalRevenu        = '';
				$totalRoyaltyfees   = '';
				$totalNetProfit     = '';
				$totalAfterDiscount = '';
				foreach ( $getManualCalcStartToEndDate as $getManualCalcData ) {
					$getClientId          = $this->Form_Management_Model->getSosDetailBySosId( $getManualCalcData['sosid'] );
					$DrugtestidArr        = array_map( 'intval', str_split( $getClientId['Drugtestid'] ) );
					$getClientDetails     = $this->Admin_Model->getAdminDetailsByEmailOrId( '', $getClientId['Clientid'] );
					$ClirntDetailsDataAry = $this->Franchisee_Model->getParentClientDetailsId( $getClientId['Clientid'] );
					$userDataAry          = $this->Admin_Model->getUserDetailsByEmailOrId( '', $ClirntDetailsDataAry['clientType'] );
					$discount             = $this->Ordering_Model->getClientDiscountByClientId( $ClirntDetailsDataAry['clientType'] );
					$data                 = $this->Ordering_Model->getManualCalculationBySosId( $getManualCalcData['sosid'] );
					if ( in_array( 1, $DrugtestidArr ) || in_array( 2, $DrugtestidArr ) || in_array( 3, $DrugtestidArr ) || in_array( 4, $DrugtestidArr ) ) {
						$countDoner = count( $this->Form_Management_Model->getDonarDetailBySosId( $getManualCalcData['sosid'] ) );
					}
					$ValTotal = 0;
					if ( in_array( 1, $DrugtestidArr ) ) {
						$ValTotal = number_format( $ValTotal + $countDoner * __RRP_1__, 2, '.', '' );
					}
					if ( in_array( 2, $DrugtestidArr ) ) {
						$ValTotal = number_format( $ValTotal + $countDoner * __RRP_2__, 2, '.', '' );
					}
					if ( in_array( 3, $DrugtestidArr ) ) {
						$ValTotal = number_format( $ValTotal + $countDoner * __RRP_3__, 2, '.', '' );
					}
					if ( in_array( 4, $DrugtestidArr ) ) {
						$ValTotal = number_format( $ValTotal + $countDoner * __RRP_4__, 2, '.', '' );
					}
					$GST                = $ValTotal * 0.1;
					$GST                = number_format( $GST, 2, '.', '' );
					$TotalbeforeRoyalty = $ValTotal + $GST;
					$TotalbeforeRoyalty = number_format( $TotalbeforeRoyalty, 2, '.', '' );
					$DcmobileScreen     = $data['mobileScreenBasePrice'] * ( $data['mobileScreenHr'] > 1 ? $data['mobileScreenHr'] : 1 );
					$mobileScreen       = $data['mcbp'] * ( $data['mchr'] > 1 ? $data['mchr'] : 1 );
					$calloutprice       = $data['cobp'] * ( $data['cohr'] > 3 ? $data['cohr'] : 3 );
					$fcoprice           = $data['fcobp'] * ( $data['fcohr'] > 2 ? $data['fcohr'] : 2 );
					$travel             = $data['travelBasePrice'] * ( $data['travelHr'] > 1 ? $data['travelHr'] : 1 );
					$TotalTrevenu = $data['urineNata'] + $data['labconf'] + $data['cancelfee'] + $data['nataLabCnfrm'] + $data['oralFluidNata'] + $data['SyntheticCannabinoids'] + $data['labScrenning'] + $data['RtwScrenning'] + $mobileScreen + $DcmobileScreen + $travel + $calloutprice + $fcoprice;
					$TotalTrevenu    = number_format( $TotalTrevenu, 2, '.', '' );
					$GSTmanual       = ( $TotalTrevenu * 0.1 );
					$GSTmanual       = number_format( $GSTmanual, 2, '.', '' );
					$Total1          = $TotalTrevenu + $GSTmanual;
					$Total1          = number_format( $Total1, 2, '.', '' );
					$totalinvoiceAmt = $ValTotal + $TotalTrevenu;
					if ( ! empty( $discount ) ) {
						$discountpercent = $discount['percentage'];
					} else {
						$discountpercent = 0;
					}
					if ( $discountpercent > 0 ) {
						$totaldiscount      = $totalinvoiceAmt * $discountpercent * 0.01;
						$totalafterdiscount = $totalinvoiceAmt - $totaldiscount;
						$totalGst           = $totalafterdiscount * 0.1;
						$totalRoyaltyBefore = $totalGst + $totalafterdiscount;
					} else {
						$totalGst           = $GST + $GSTmanual;
						$totalRoyaltyBefore = $Total1 + $TotalbeforeRoyalty;
						$totaldiscount      = 0;
						$totalafterdiscount = 0;
					}
					$Royaltyfees = ( $discountpercent > 0 ? number_format( $totalafterdiscount, 2, '.', '' ) : number_format( $totalinvoiceAmt, 2, '.', '' ) ) * 0.1;
					$Royaltyfees = number_format( $Royaltyfees, 2, '.', '' );
					$NetTotal = ( $discountpercent > 0 ? number_format( $totalafterdiscount, 2, '.', '' ) : number_format( $totalinvoiceAmt, 2, '.', '' ) ) - $Royaltyfees;
					$NetTotal = number_format( $NetTotal, 2, '.', '' );
					$totalRoyaltyfees = $totalRoyaltyfees + $Royaltyfees;
					$totalRoyaltyfees = number_format( $totalRoyaltyfees, 2, '.', '' );
					$totalNetProfit     = $totalNetProfit + $NetTotal;
					$totalNetProfit     = number_format( $totalNetProfit, 2, '.', '' );
					$totalAfterDiscount = $totalAfterDiscount + ( $discountpercent > 0 ? number_format( $totalafterdiscount, 2, '.', '' ) : number_format( $totalinvoiceAmt, 2, '.', '' ) );
					$totalAfterDiscount = number_format( $totalAfterDiscount, 2, '.', '' );
				}
				$allfranchiseeTotalAfterDis = $allfranchiseeTotalAfterDis + $totalAfterDiscount;
				$allfranchiseeTotalAfterDis = number_format( $allfranchiseeTotalAfterDis, 2, '.', '' );
				$allfranchiseetotalRoyaltyfees = $allfranchiseetotalRoyaltyfees + $totalRoyaltyfees;
				$allfranchiseetotalRoyaltyfees = number_format( $allfranchiseetotalRoyaltyfees, 2, '.', '' );
				$allfranchiseetotalNetProfit = $allfranchiseetotalNetProfit + $totalNetProfit;
				$allfranchiseetotalNetProfit = number_format( $allfranchiseetotalNetProfit, 2, '.', '' );
				$i ++;
				$html .= '<tr>
                            <td>' . $i . '</td>
                            <td>' . $getAdmindetails['szName'] . '</td>
                            <td>$' . number_format( $totalAfterDiscount, 2, '.', ',' ) . '</td>
                            <td>$' . number_format( $totalRoyaltyfees, 2, '.', ',' ) . '</td>
                            <td>$' . number_format( $totalNetProfit, 2, '.', ',' ) . '</td>
                            
                        </tr>';
			}
			$html .= '<tr>
                    
                    <td></td>
                    <td><b>Total</b></td>
                    <td>$' . number_format( $allfranchiseeTotalAfterDis, 2, '.', ',' ) . '</td>
                    <td>$' . number_format( $allfranchiseetotalRoyaltyfees, 2, '.', ',' ) . '</td>
                    <td>$' . number_format( $allfranchiseetotalNetProfit, 2, '.', ',' ) . '</td>
                   </tr>';
		}
		$html .= '
                            </table>
                        </div>
                      
                        ';
		$pdf->writeHTML( $html, true, false, true, false, '' );
//    $pdf->Write(5, 'CodeIgniter TCPDF Integration');
		error_reporting( E_ALL );
		$pdf->Output( 'revenue-generate.pdf', 'I' );
	}
	function ViewexcelofRevenueSummery() {
		$dtStart = $this->input->post( 'dtStart' );
		$dtEnd   = $this->input->post( 'dtEnd' );
		$this->session->set_userdata( 'dtStart', $dtStart );
		$this->session->set_userdata( 'dtEnd', $dtEnd );
		echo "SUCCESS||||";
		echo "ViewexcelRevenueSummery";
	}
	public function ViewexcelRevenueSummery() {
		$this->load->library( 'excel' );
		$filename = 'DrugSafe';
		$title    = 'Revenue Summary';
		$file     = $filename . '-' . $title; //save our workbook as this file name
		$this->excel->setActiveSheetIndex( 0 );
		$this->excel->getActiveSheet()->setTitle( $title );
		$this->excel->getActiveSheet()->setCellValue( 'A1', '#' );
		$this->excel->getActiveSheet()->getStyle( 'A1' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'A1' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'A1' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'B1', 'Franchisee Name' );
		$this->excel->getActiveSheet()->getStyle( 'B1' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'B1' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'B1' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'C1', ' Revenue EXL GST' );
		$this->excel->getActiveSheet()->getStyle( 'C1' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'C1' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'C1' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'D1', 'Royalty Fees' );
		$this->excel->getActiveSheet()->getStyle( 'D1' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'D1' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'D1' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'E1', 'Net Revenue EXL GST' );
		$this->excel->getActiveSheet()->getStyle( 'E1' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'E1' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'E1' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$searchAry['dtStart'] = $this->session->userdata( 'dtStart' );
		$searchAry['dtEnd']   = $this->session->userdata( 'dtEnd' );
		$allfranchisee        = $this->Form_Management_Model->getAllsosFormDetails( $searchAry );
		if ( ! empty( $allfranchisee ) ) {
			$i                = 2;
			$x                = 0;
			$totalRevenu      = '';
			$totalRoyaltyfees = '';
			$totalNetProfit   = '';
			$allfranchiseeTotalAfterDis    = '';
			$allfranchiseetotalRoyaltyfees = '';
			$allfranchiseetotalNetProfit   = '';
			foreach ( $allfranchisee as $allfranchiseeData ) {
				$getManualCalcStartToEndDate = $this->Reporting_Model->getAllRevenueManualalc( $searchAry, $allfranchiseeData['franchiseeId'] );
				$getAdmindetails             = $this->Admin_Model->getAdminDetailsByEmailOrId( '', $allfranchiseeData['franchiseeId'] );
				$totalRevenu        = '';
				$totalRoyaltyfees   = '';
				$totalNetProfit     = '';
				$totalAfterDiscount = '';
				foreach ( $getManualCalcStartToEndDate as $getManualCalcData ) {
					$DrugtestidArr        = array_map( 'intval', str_split( $getManualCalcData['Drugtestid'] ) );
					$getClientId          = $this->Form_Management_Model->getSosDetailBySosId( $getManualCalcData['sosid'] );
					$getClientDetails     = $this->Admin_Model->getAdminDetailsByEmailOrId( '', $getClientId['Clientid'] );
					$franchiseecode       = $this->Franchisee_Model->getusercodebyuserid( $getClientDetails['id'] );
					$ClirntDetailsDataAry = $this->Franchisee_Model->getParentClientDetailsId( $getClientId['Clientid'] );
					$userDataAry          = $this->Admin_Model->getUserDetailsByEmailOrId( '', $ClirntDetailsDataAry['clientType'] );
					$discount             = $this->Ordering_Model->getClientDiscountByClientId( $ClirntDetailsDataAry['clientType'] );
					$data                 = $this->Ordering_Model->getManualCalculationBySosId( $getManualCalcData['sosid'] );
					if ( in_array( 1, $DrugtestidArr ) || in_array( 2, $DrugtestidArr ) || in_array( 3, $DrugtestidArr ) || in_array( 4, $DrugtestidArr ) ) {
						$countDoner = count( $this->Form_Management_Model->getDonarDetailBySosId( $getManualCalcData['sosid'] ) );
					}
					$ValTotal = 0;
					if ( in_array( 1, $DrugtestidArr ) ) {
						$ValTotal = number_format( $ValTotal + $countDoner * __RRP_1__, 2, '.', '' );
					}
					if ( in_array( 2, $DrugtestidArr ) ) {
						$ValTotal = number_format( $ValTotal + $countDoner * __RRP_2__, 2, '.', '' );
					}
					if ( in_array( 3, $DrugtestidArr ) ) {
						$ValTotal = number_format( $ValTotal + $countDoner * __RRP_3__, 2, '.', '' );
					}
					if ( in_array( 4, $DrugtestidArr ) ) {
						$ValTotal = number_format( $ValTotal + $countDoner * __RRP_4__, 2, '.', '' );
					}
					$GST                = $ValTotal * 0.1;
					$GST                = number_format( $GST, 2, '.', '' );
					$TotalbeforeRoyalty = $ValTotal + $GST;
					$TotalbeforeRoyalty = number_format( $TotalbeforeRoyalty, 2, '.', '' );
					$DcmobileScreen     = $data['mobileScreenBasePrice'] * ( $data['mobileScreenHr'] > 1 ? $data['mobileScreenHr'] : 1 );
					$mobileScreen       = $data['mcbp'] * ( $data['mchr'] > 1 ? $data['mchr'] : 1 );
					$calloutprice       = $data['cobp'] * ( $data['cohr'] > 3 ? $data['cohr'] : 3 );
					$fcoprice           = $data['fcobp'] * ( $data['fcohr'] > 2 ? $data['fcohr'] : 2 );
					$travel             = $data['travelBasePrice'] * ( $data['travelHr'] > 1 ? $data['travelHr'] : 1 );
					$TotalTrevenu = $data['urineNata'] + $data['labconf'] + $data['cancelfee'] + $data['nataLabCnfrm'] + $data['oralFluidNata'] + $data['SyntheticCannabinoids'] + $data['labScrenning'] + $data['RtwScrenning'] + $mobileScreen + $DcmobileScreen + $travel + $calloutprice + $fcoprice;
					$TotalTrevenu    = number_format( $TotalTrevenu, 2, '.', '' );
					$GSTmanual       = ( $TotalTrevenu * 0.1 );
					$GSTmanual       = number_format( $GSTmanual, 2, '.', '' );
					$Total1          = $TotalTrevenu + $GSTmanual;
					$Total1          = number_format( $Total1, 2, '.', '' );
					$totalinvoiceAmt = $ValTotal + $TotalTrevenu;
					if ( ! empty( $discount ) ) {
						$discountpercent = $discount['percentage'];
					} else {
						$discountpercent = 0;
					}
					if ( $discountpercent > 0 ) {
						$totaldiscount      = $totalinvoiceAmt * $discountpercent * 0.01;
						$totalafterdiscount = $totalinvoiceAmt - $totaldiscount;
						$totalGst           = $totalafterdiscount * 0.1;
						$totalRoyaltyBefore = $totalGst + $totalafterdiscount;
					} else {
						$totalGst           = $GST + $GSTmanual;
						$totalRoyaltyBefore = $Total1 + $TotalbeforeRoyalty;
						$totaldiscount      = 0;
						$totalafterdiscount = 0;
					}
					$Royaltyfees = ( $discountpercent > 0 ? number_format( $totalafterdiscount, 2, '.', '' ) : number_format( $totalinvoiceAmt, 2, '.', '' ) ) * 0.1;
					$Royaltyfees = number_format( $Royaltyfees, 2, '.', '' );
					$NetTotal = ( $discountpercent > 0 ? number_format( $totalafterdiscount, 2, '.', '' ) : number_format( $totalinvoiceAmt, 2, '.', '' ) ) - $Royaltyfees;
					$NetTotal = number_format( $NetTotal, 2, '.', '' );
					$totalRoyaltyfees = $totalRoyaltyfees + $Royaltyfees;
					$totalRoyaltyfees = number_format( $totalRoyaltyfees, 2, '.', '' );
					$totalNetProfit     = $totalNetProfit + $NetTotal;
					$totalNetProfit     = number_format( $totalNetProfit, 2, '.', '' );
					$totalAfterDiscount = $totalAfterDiscount + ( $discountpercent > 0 ? number_format( $totalafterdiscount, 2, '.', '' ) : number_format( $totalinvoiceAmt, 2, '.', '' ) );
					$totalAfterDiscount = number_format( $totalAfterDiscount, 2, '.', '' );
				}
				$allfranchiseeTotalAfterDis = $allfranchiseeTotalAfterDis + $totalAfterDiscount;
				$allfranchiseeTotalAfterDis = number_format( $allfranchiseeTotalAfterDis, 2, '.', '' );
				$allfranchiseetotalRoyaltyfees = $allfranchiseetotalRoyaltyfees + $totalRoyaltyfees;
				$allfranchiseetotalRoyaltyfees = number_format( $allfranchiseetotalRoyaltyfees, 2, '.', '' );
				$allfranchiseetotalNetProfit = $allfranchiseetotalNetProfit + $totalNetProfit;
				$allfranchiseetotalNetProfit = number_format( $allfranchiseetotalNetProfit, 2, '.', '' );
				$x ++;
				$this->excel->getActiveSheet()->setCellValue( 'A' . $i, $x );
				$this->excel->getActiveSheet()->setCellValue( 'B' . $i, $getAdmindetails['szName'] );
				$this->excel->getActiveSheet()->setCellValue( 'C' . $i, '$' . number_format( $totalAfterDiscount, 2, '.', ',' ) );
				$this->excel->getActiveSheet()->setCellValue( 'D' . $i, '$' . number_format( $totalRoyaltyfees, 2, '.', ',' ) );
				$this->excel->getActiveSheet()->setCellValue( 'E' . $i, '$' . number_format( $totalNetProfit, 2, '.', ',' ) );
				$this->excel->getActiveSheet()->getColumnDimension( 'A' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'B' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'C' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'D' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'E' )->setAutoSize( true );
				$i ++;
			}
			$this->excel->getActiveSheet()->setCellValue( 'B' . $i, Total );
			$this->excel->getActiveSheet()->getStyle( 'B' . $i )->getFont()->setSize( 13 );
			$this->excel->getActiveSheet()->getStyle( 'B' . $i )->getFont()->setBold( true );
			$this->excel->getActiveSheet()->getStyle( 'B' . $i )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
			$this->excel->getActiveSheet()->setCellValue( 'C' . $i, '$' . number_format( $allfranchiseeTotalAfterDis, 2, '.', ',' ) );
			$this->excel->getActiveSheet()->setCellValue( 'D' . $i, '$' . number_format( $allfranchiseetotalRoyaltyfees, 2, '.', ',' ) );
			$this->excel->getActiveSheet()->setCellValue( 'E' . $i, '$' . number_format( $allfranchiseetotalNetProfit, 2, '.', ',' ) );
		}
		header( 'Content-Type: application/vnd.ms-excel' ); //mime type
		header( 'Content-Disposition: attachment;filename="' . $file . '"' ); //tell browser what's the file name
		header( 'Cache-Control: max-age=0' ); //no cache
//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
//if you want to save it as .XLSX Excel 2007 format
		$objWriter = PHPExcel_IOFactory::createWriter( $this->excel, 'Excel5' );
//force user to download the Excel file without writing it to server's HD
		$objWriter->save( 'php://output' );
	}
	public function clientcomparisonReport() {
		$is_user_login = is_user_login( $this );
		// redirect to dashboard if already logged in
		if ( ! $is_user_login ) {
			ob_end_clean();
			redirect( base_url( '/admin/admin_login' ) );
			die;
		}
		if ( $_SESSION['drugsafe_user']['iRole'] == 2 ) {
			$_POST['szSearch1'] = $_SESSION['drugsafe_user']['id'];
		}
		$count        = $this->Admin_Model->getnotification();
		$clientarr    = array();
		$sitearr      = array();
		$franchiseeid = ( isset( $_POST['szSearch1'] ) ? $_POST['szSearch1'] : '' );
		$clientid     = ( isset( $_POST['szSearch2'] ) ? $_POST['szSearch2'] : '' );
		$siteid       = ( isset( $_POST['szSearch3'] ) ? $_POST['szSearch3'] : '' );
		$testtype     = ( isset( $_POST['szSearch4'] ) ? $_POST['szSearch4'] : '' );
		$drugtesttype = ( $testtype == 'A' ? '1' : ( $testtype == 'O' ? '2' : ( $testtype == 'U' ? '3' : ( $testtype == 'AZ' ? '4' : '5' ) ) ) );
		$comparetype  = ( isset( $_POST['szSearch5'] ) ? $_POST['szSearch5'] : '' );
		$clientarr    = $this->Webservices_Model->getclientdetails( $franchiseeid );
		$sitearr      = $this->Webservices_Model->getclientdetails( $franchiseeid, $clientid );
		$this->load->library( 'form_validation' );
		$this->form_validation->set_rules( 'szSearch1', 'Franchisee Name ', 'required' );
		$this->form_validation->set_rules( 'szSearch2', 'Client Name', 'required' );
		$this->form_validation->set_rules( 'szSearch3', 'Company Name/Site ', 'required' );
		$this->form_validation->set_rules( 'szSearch4', 'Test Type', 'required' );
		$this->form_validation->set_rules( 'szSearch5', 'Compare Data ', 'required' );
		$this->form_validation->set_message( 'required', '{field} is required.' );
		if ( $this->form_validation->run() == false ) {
			$data['szMetaTagTitle']  = "Client Comparison Report";
			$data['is_user_login']   = $is_user_login;
			$data['pageName']        = "Reporting";
			$data['subpageName']     = "Client_Comparison_Report";
			$data['notification']    = $count;
			$data['data']            = $data;
			$data['err']             = true;
			$data['clientarr']       = $clientarr;
			$data['sitearr']         = $sitearr;
			$data['arErrorMessages'] = $this->Reporting_Model->arErrorMessages;
			$this->load->view( 'layout/admin_header', $data );
			$this->load->view( 'reporting/clientCmpReport' );
			$this->load->view( 'layout/admin_footer' );
		} else {
			$comparisonResultArr      = $this->Reporting_Model->getcomparisonrecord( $siteid, $drugtesttype, $comparetype );
			$userdataarr              = $this->Webservices_Model->getfranchiseeclientsitebysiteid( $siteid );
			$data['szMetaTagTitle']   = "Client Comparison Report";
			$data['is_user_login']    = $is_user_login;
			$data['pageName']         = "Reporting";
			$data['subpageName']      = "Client_Comparison_Report";
			$data['notification']     = $count;
			$data['compareresultarr'] = $comparisonResultArr;
			$data['data']             = $data;
			$data['err']              = false;
			$data['userdataarr']      = $userdataarr;
			$data['drugtesttype']     = $drugtesttype;
			$data['clientarr']        = $clientarr;
			$data['sitearr']          = $sitearr;
			$data['testtype']         = $testtype;
			$data['comparetype']      = $comparetype;
			$data['arErrorMessages']  = $this->Reporting_Model->arErrorMessages;
			$this->load->view( 'layout/admin_header', $data );
			$this->load->view( 'reporting/clientCmpReport' );
			$this->load->view( 'layout/admin_footer' );
		}
	}
        //get Client list By Franchisee
	function getClientListByFrId( $idFranchisee = '' ) {
		if ( trim( $idFranchisee ) != '' ) {
			$_POST['idFranchisee'] = $idFranchisee;
		}
		//$clientAry = $this->Franchisee_Model->viewClientList(true, $_POST['idFranchisee']);
		$AllclientAry             = array();
		$AllclientAry             = $this->Webservices_Model->getclientdetails( $_POST['idFranchisee'] );
		$AssignCorpuserDetailsArr = $this->Webservices_Model->getcorpclientdetails( $_POST['idFranchisee'] );
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
		$clientid = $_POST['idclient'];
		$siteid   = $_POST['idsite'];
		$result   = '<select class="form-control abc custom-select" name="szSearch2" id="szSearch2" onfocus="remove_formError(this.id,\'true\')" onchange="getSiteListByClientIdData(this.value,\'\',\'' . $_POST['idFranchisee'] . '\')">';
		if ( ! empty( $clientAry ) ) {
			$result .= "<option value=''>Client Name</option>";
			foreach ( $clientAry as $clientDetails ) {
				$result .= "<option value='" . $clientDetails['id'] . "' " . ( $clientDetails['id'] == $clientid ? 'selected=\"selected\"' : '' ) . ">" . $clientDetails['szName'] . "</option>";
			}
		} else {
			$result .= "<option value=''>Client Name</option>";
		}
		$result .= "</select>";
		if ( $clientid > 0 ) {
			$result .= "<script type='text/javascript'>
                            setTimeout(function () {
                                getSiteListByClientIdData('" . $clientid . "','" . $siteid . "','" . $_POST['idFranchisee'] . "');
                            }, 300);
                        </script>";
		}
		echo $result;
	}
	function getSiteListByClientId( $idClient = '' ) {
		if ( trim( $idClient ) != '' ) {
			$_POST['idClient'] = $idClient;
		}
		$franchiseeid = $_POST['franchiseeid'];
		//$siteAry = $this->Franchisee_Model->viewChildClientDetails($_POST['idClient']);
		$loggedinFranchisee = $franchiseeid;
		$clientDetsArr      = $this->Webservices_Model->getclientdetailsbyclientid( $_POST['idClient'] );
		if ( ! empty( $clientDetsArr ) ) {
			$franchiseeid = $clientDetsArr[0]['franchiseeId'];
		}
		$siteAry                  = $this->Webservices_Model->getclientdetails( $franchiseeid, $_POST['idClient'] );
		$AssignCorpuserDetailsArr = $this->Webservices_Model->getcorpclientdetails( $loggedinFranchisee, $franchiseeid );
		if ( ! empty( $AssignCorpuserDetailsArr ) ) {
			$siteAry = array();
			foreach ( $AssignCorpuserDetailsArr as $assignCorpUser ) {
				$CorpuserDetailsArr = $this->Webservices_Model->getclientdetails( $assignCorpUser['corpfrid'], $_POST['idClient'], 0, $assignCorpUser['clientid'] );
				if ( ! empty( $CorpuserDetailsArr ) ) {
					foreach ( $CorpuserDetailsArr as $CorpUser ) {
						array_push( $siteAry, $CorpUser );
					}
				}
			}
		}
		$siteid = $_POST['idsite'];
		$result = '<select class="form-control custom-select" name="szSearch3" id="szSearch3" onfocus="remove_formError(this.id,\'true\')">';
		if ( ! empty( $siteAry ) ) {
			$result .= "<option value=''>Company Name/site</option>";
			foreach ( $siteAry as $siteDetails ) {
				$result .= "<option value='" . $siteDetails['id'] . "' " . ( $siteDetails['id'] == $siteid ? 'selected=\"selected\"' : '' ) . ">" . $siteDetails['szName'] . "</option>";
			}
		} else {
			$result .= "<option value=''>Company Name/site</option>";
		}
		$result .= "</select>";
		echo $result;
	}
	public function view_industry_report() { // something
		$count         = $this->Admin_Model->getnotification();
		$is_user_login = is_user_login( $this );
		// redirect to dashboard if already logged in
		if ( ! $is_user_login ) {
			ob_end_clean();
			redirect( base_url( '/admin/admin_login' ) );
			die;
		}
		if ( $_POST['dtStart'] != '' && $_POST['dtEnd'] != '' ) {
			$searchArray           = $_POST;
			$getSosAndClientDetils = $this->Reporting_Model->getSosAndClientDetils( $searchArray );
		}
		$allIndustry = $this->Admin_Model->viewAllIndustryList();
		$this->load->library( 'form_validation' );
		$this->form_validation->set_rules( 'dtStart', 'Start Industry date ', 'required' );
                if(!empty($_POST['dtEnd'])){
                $this->form_validation->set_rules( 'dtEnd', 'End Industry date', 'required|callback_endDate_check' );    
                }
                else{
                 $this->form_validation->set_rules( 'dtEnd', 'End Industry date', 'required' );   
                }
		
		$this->form_validation->set_message( 'required', '{field} is required.' );
		if ( $this->form_validation->run() == false ) {
			$data['getManualCalcStartToEndDate'] = $getManualCalcStartToEndDate;
			$data['szMetaTagTitle']              = "Industry Report";
			$data['is_user_login']               = $is_user_login;
			$data['pageName']                    = "Reporting";
			$data['subpageName']                 = "industry_report";
			$data['notification']                = $count;
			$data['data']                        = $data;
			$data['searchAry']                   = $_POST;
			$data['allIndustry']                 = $allIndustry;
			$data['getSosAndClientDetils']       = $getSosAndClientDetils;
			$data['arErrorMessages']             = $this->Reporting_Model->arErrorMessages;
			$this->load->view( 'layout/admin_header', $data );
			$this->load->view( 'reporting/viewIndustryReort' );
			$this->load->view( 'layout/admin_footer' );
		} else {
			$data['szMetaTagTitle']        = "Industry Report";
			$data['is_user_login']         = $is_user_login;
			$data['pageName']              = "Reporting";
			$data['subpageName']           = "industry_report";
			$data['notification']          = $count;
			$data['searchAry']             = $_POST;
			$data['allIndustry']           = $allIndustry;
			$data['getSosAndClientDetils'] = $getSosAndClientDetils;
			$data['arErrorMessages']       = $this->Reporting_Model->arErrorMessages;
			$this->load->view( 'layout/admin_header', $data );
			$this->load->view( 'reporting/viewIndustryReort' );
			$this->load->view( 'layout/admin_footer' );
		}
	}
      function endDate_check()
        {
          $searchAry = $_POST;
          $dtStart = $this->Order_Model->getSqlFormattedDate($searchAry['dtStart']);
          $dtEnd = $this->Order_Model->getSqlFormattedDate($searchAry['dtEnd']);
          
          
          if(($dtStart)> ($dtEnd))
          {
              $this->form_validation->set_message('endDate_check', 'End Industry date should be greater than Start Industry date.');
               return false;
          }
          else{
               return true;
          }
          
       }
	function industryReportPdf() {
		$dtStart    = $this->input->post( 'dtStart' );
		$dtEnd      = $this->input->post( 'dtEnd' );
		$szIndustry = $this->input->post( 'szIndustry' );
		$szTestType = $this->input->post( 'szTestType' );
		$this->session->set_userdata( 'dtStart', $dtStart );
		$this->session->set_userdata( 'dtEnd', $dtEnd );
		$this->session->set_userdata( 'szIndustry', $szIndustry );
		$this->session->set_userdata( 'szTestType', $szTestType );
		echo "SUCCESS||||";
		echo "industryReportOfPdf";
	}
	public function industryReportOfPdf() {
		ob_start();
		$this->load->library( 'Pdf' );
		$pdf = new Pdf( 'P', 'mm', 'A4', true, 'UTF-8', false );
		$pdf->SetCreator( PDF_CREATOR );
		$pdf->SetTitle( 'Drug-safe industry report' );
		$pdf->SetAuthor( 'Drug-safe' );
		$pdf->SetSubject( 'Industry Report PDF' );
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
		$pdf->AddPage( 'L' );
		$searchArray['dtStart']    = $this->session->userdata( 'dtStart' );
		$searchArray['dtEnd']      = $this->session->userdata( 'dtEnd' );
		$searchArray['szIndustry'] = $this->session->userdata( 'szIndustry' );
		$searchArray['szTestType'] = $this->session->userdata( 'szTestType' );
		$getSosAndClientDetils = $this->Reporting_Model->getSosAndClientDetils( $searchArray );
		$html = '<a style="text-align:center;  margin-bottom:5px;" href="' . __BASE_URL__ . '" ><img style="width:145px" src="' . __BASE_URL__ . '/images/logo.png" alt="logo" class="logo-default" /> </a>
            <div><p style="text-align:center; font-size:18px; margin-bottom:5px; color:black"><b>Industry Report</b></p></div>
            <div class= "table-responsive" >
                            <table border="1" cellpadding="5">
                            <thead>
                                    <tr>
                                        <th></th>
					<th></th>';
		foreach ( $getSosAndClientDetils as $getSosAndClientData ) {
			$industryname = $this->Admin_Model->getIndustryNameByid( $getSosAndClientData['industry'] );
			$html         .= '<th>' . $industryname['szName'] . '</th>';
		}
		$html .= '<th>Total</th></tr>
                            </thead>';
		if ( $searchArray['szTestType'] == '' || $searchArray['szTestType'] == 'A' ) {
			$html          .= '<tbody>
					<tr>
                                            <td>Alchohol</td>
                                            <td>Total Donors</td>';
			$FinalTotalAlc = 0;
			foreach ( $getSosAndClientDetils as $getSosAndClientData ) {
				$html          .= '<td>' . ( $getSosAndClientData['totalPositiveAlcohol'] + $getSosAndClientData['totalNegativeAlcohol'] ) . '</td>';
				$FinalTotalAlc += $getSosAndClientData['totalPositiveAlcohol'] + $getSosAndClientData['totalNegativeAlcohol'];
			}
			$html             .= '<td>' . $FinalTotalAlc . '</td></tr>
                                        <tr>
				            <td></td>
                                            <td>Positive Result</td>';
			$FinalTotalAlcPos = 0;
			foreach ( $getSosAndClientDetils as $getSosAndClientData ) {
				$html             .= '<td>' . $getSosAndClientData['totalPositiveAlcohol'] . '</td>';
				$FinalTotalAlcPos += $getSosAndClientData['totalPositiveAlcohol'];
			}
			$html             .= '<td>' . $FinalTotalAlcPos . '</td></tr>
			                <tr>
				            <td></td>
                                            <td>Negative Result</td>';
			$FinalTotalAlcNeg = 0;
			foreach ( $getSosAndClientDetils as $getSosAndClientData ) {
				$html             .= '<td>' . $getSosAndClientData['totalNegativeAlcohol'] . '</td>';
				$FinalTotalAlcNeg += $getSosAndClientData['totalNegativeAlcohol'];
			}
			$html .= '<td>' . $FinalTotalAlcNeg . '</td></tr>
                                    </tbody>';
		}
		if ( $searchArray['szTestType'] == '' || $searchArray['szTestType'] == 'U' ) {
			$html          .= '<tbody>
					<tr>
                                            <td>Urine AS/NZA 4308:2001 or As/NZA 4308:2008</td>
                                            <td>Total Donors</td>';
			$FinalTotalUri = 0;
			foreach ( $getSosAndClientDetils as $getSosAndClientData ) {
				$html          .= '<td>' . $getSosAndClientData['totalDonarUrine'] . '</td>';
				$FinalTotalUri += $getSosAndClientData['totalDonarUrine'];
			}
			$html             .= '<td>' . $FinalTotalUri . '</td></tr>
                                        <tr>
					    <td></td>
                                            <td>Positive Result</td>';
			$FinalTotalUriPos = 0;
			foreach ( $getSosAndClientDetils as $getSosAndClientData ) {
				$totalNegativeUrine = $getSosAndClientData['totalDonarUrine'] - $getSosAndClientData['totalNegativeUrine'];
				$html               .= '<td>' . ( $totalNegativeUrine > 0 ? $totalNegativeUrine : 0 ) . '</td>';
				$FinalTotalUriPos   += ( $totalNegativeUrine > 0 ? $totalNegativeUrine : 0 );
			}
			$html             .= '<td>' . ( $FinalTotalUriPos > 0 ? $FinalTotalUriPos : 0 ) . '</td></tr>
					<tr>
					    <td></td>
                                            <td>Negative Result</td>';
			$FinalTotalUriNeg = 0;
			foreach ( $getSosAndClientDetils as $getSosAndClientData ) {
				$html             .= '<td>' . $getSosAndClientData['totalNegativeUrine'] . '</td>';
				$FinalTotalUriNeg += $getSosAndClientData['totalNegativeUrine'];
			}
			$html .= '<td>' . ( $FinalTotalUriNeg > 0 ? $FinalTotalUriNeg : 0 ) . '</td></tr>
                                    </tbody>';
		}
		if ( $searchArray['szTestType'] == '' || $searchArray['szTestType'] == 'O' ) {
			$html          .= '<tbody>
					<tr>
                                            <td>Oral Fluid AS 4760:2006</td>
                                            <td>Total Donors</td>';
			$FinalTotalOrl = 0;
			foreach ( $getSosAndClientDetils as $getSosAndClientData ) {
				$html          .= '<td>' . $getSosAndClientData['totalDonarOral'] . '</td>';
				$FinalTotalOrl += $getSosAndClientData['totalDonarOral'];
			}
			$html             .= '<td>' . $FinalTotalOrl . '</td></tr>
                                        <tr>
					    <td></td>
                                            <td>Positive Result</td>';
			$FinalTotalOrlPos = 0;
			foreach ( $getSosAndClientDetils as $getSosAndClientData ) {
				$totalPositiveOral = $getSosAndClientData['totalDonarOral'] - $getSosAndClientData['totalNegativeOral'];
				$html              .= '<td>' . ( $totalPositiveOral > 0 ? $totalPositiveOral : 0 ) . '</td>';
				$FinalTotalOrlPos  += ( $totalPositiveOral > 0 ? $totalPositiveOral : 0 );
			}
			$html             .= '<td>' . ( $FinalTotalOrlPos > 0 ? $FinalTotalOrlPos : 0 ) . '</td></tr>
						<tr>
						   <td></td>
                                                    <td>Negative Result</td>';
			$FinalTotalOrlNeg = 0;
			foreach ( $getSosAndClientDetils as $getSosAndClientData ) {
				$html             .= '<td>' . $getSosAndClientData['totalNegativeOral'] . '</td>';
				$FinalTotalOrlNeg += $getSosAndClientData['totalNegativeOral'];
			}
			$html .= '<td>' . ( $FinalTotalOrlNeg > 0 ? $FinalTotalOrlNeg : 0 ) . '</td></tr>
                                    </tbody>';
		}
		$html .= '
                            </table>
                        </div>
                      
                        ';
		$pdf->writeHTML( $html, true, false, true, false, '' );
//    $pdf->Write(5, 'CodeIgniter TCPDF Integration');
		error_reporting( E_ALL );
		$this->session->unset_userdata( 'productCode' );
		$this->session->unset_userdata( 'franchiseeName' );
		$pdf->Output( 'stock-request-report.pdf', 'I' );
	}
	function industryReportOfXls() {
		$dtStart    = $this->input->post( 'dtStart' );
		$dtEnd      = $this->input->post( 'dtEnd' );
		$szIndustry = $this->input->post( 'szIndustry' );
		$szTestType = $this->input->post( 'szTestType' );
		$this->session->set_userdata( 'dtStart', $dtStart );
		$this->session->set_userdata( 'dtEnd', $dtEnd );
		$this->session->set_userdata( 'szIndustry', $szIndustry );
		$this->session->set_userdata( 'szTestType', $szTestType );
		echo "SUCCESS||||";
		echo "industryReportXls";
	}
	public function industryReportXls() {
		$this->load->library( 'excel' );
		$filename = 'DrugSafe';
		$title    = 'Industry Report';
		$file     = $filename . '-' . $title; //save our workbook as this file name
		$searchArray['dtStart']    = $this->session->userdata( 'dtStart' );
		$searchArray['dtEnd']      = $this->session->userdata( 'dtEnd' );
		$searchArray['szIndustry'] = $this->session->userdata( 'szIndustry' );
		$searchArray['szTestType'] = $this->session->userdata( 'szTestType' );
		$alphabet                  = array( 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O' );
		$getSosAndClientDetils     = $this->Reporting_Model->getSosAndClientDetils( $searchArray );
		$this->excel->setActiveSheetIndex( 0 );
		$this->excel->getActiveSheet()->setTitle( $title );
		$this->excel->getActiveSheet()->setCellValue( 'A1', '' );
		$this->excel->getActiveSheet()->getStyle( 'A1' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'A1' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'A1' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'B1', '' );
		$this->excel->getActiveSheet()->getStyle( 'B1' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'B1' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'B1' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$j = 1;
		$k = 1;
		foreach ( $getSosAndClientDetils as $getSosAndClientData ) {
			$industryname = $this->Admin_Model->getIndustryNameByid( $getSosAndClientData['industry'] );
			$alphaobj     = $alphabet[ $j ];
			$this->excel->getActiveSheet()->setCellValue( $alphaobj . $k, $industryname['szName'] );
			$this->excel->getActiveSheet()->getStyle( $alphaobj . $k )->getFont()->setSize( 13 );
			$this->excel->getActiveSheet()->getStyle( $alphaobj . $k )->getFont()->setBold( true );
			$this->excel->getActiveSheet()->getStyle( $alphaobj . $k )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
			$j ++;
		}
		$alphaobj = $alphabet[ $j ];
		$this->excel->getActiveSheet()->setCellValue( $alphaobj . $k, 'Total' );
		$this->excel->getActiveSheet()->getStyle( $alphaobj . $k )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( $alphaobj . $k )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( $alphaobj . $k )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		if ( ! empty( $getSosAndClientDetils ) ) {
			if ( $searchArray['szTestType'] == '' || $searchArray['szTestType'] == 'A' ) {
				$j = 1;
				$this->excel->getActiveSheet()->setCellValue( 'A2', 'Alchohol' );
				$this->excel->getActiveSheet()->setCellValue( 'B2', 'Total Donors' );
				$FinalTotalAlc = 0;
				foreach ( $getSosAndClientDetils as $getSosAndClientData ) {
					$k        = 2;
					$alphaobj = $alphabet[ $j ];
					$this->excel->getActiveSheet()->setCellValue( $alphaobj . $k, ( $getSosAndClientData['totalPositiveAlcohol'] + $getSosAndClientData['totalNegativeAlcohol'] ) );
					$FinalTotalAlc += $getSosAndClientData['totalPositiveAlcohol'] + $getSosAndClientData['totalNegativeAlcohol'];
					$j ++;
				}
				$alphaobj = $alphabet[ $j ];
				$this->excel->getActiveSheet()->setCellValue( $alphaobj . $k, $FinalTotalAlc );
				$this->excel->getActiveSheet()->setCellValue( 'A3', '' );
				$this->excel->getActiveSheet()->setCellValue( 'B3', 'Positive Result' );
				$j                = 1;
				$FinalTotalAlcPos = 0;
				foreach ( $getSosAndClientDetils as $getSosAndClientData ) {
					$k        = 3;
					$alphaobj = $alphabet[ $j ];
					$this->excel->getActiveSheet()->setCellValue( $alphaobj . $k, $getSosAndClientData['totalPositiveAlcohol'] );
					$FinalTotalAlcPos += $getSosAndClientData['totalPositiveAlcohol'];
					$j ++;
				}
				$alphaobj = $alphabet[ $j ];
				$this->excel->getActiveSheet()->setCellValue( $alphaobj . $k, $FinalTotalAlcPos );
				$this->excel->getActiveSheet()->setCellValue( 'A4', '' );
				$this->excel->getActiveSheet()->setCellValue( 'B4', 'Negative Result' );
				$j                = 1;
				$FinalTotalAlcNeg = 0;
				foreach ( $getSosAndClientDetils as $getSosAndClientData ) {
					$k        = 4;
					$alphaobj = $alphabet[ $j ];
					$this->excel->getActiveSheet()->setCellValue( $alphaobj . $k, $getSosAndClientData['totalNegativeAlcohol'] );
					$FinalTotalAlcNeg += $getSosAndClientData['totalNegativeAlcohol'];
					$j ++;
				}
				$alphaobj = $alphabet[ $j ];
				$this->excel->getActiveSheet()->setCellValue( $alphaobj . $k, $FinalTotalAlcNeg );
				$this->excel->getActiveSheet()->setCellValue( 'A5', '' );
				$this->excel->getActiveSheet()->setCellValue( 'B5', '' );
				$this->excel->getActiveSheet()->setCellValue( 'C5', '' );
				$this->excel->getActiveSheet()->setCellValue( 'D5', '' );
			}
			if ( $searchArray['szTestType'] == '' || $searchArray['szTestType'] == 'U' ) {
				$this->excel->getActiveSheet()->setCellValue( 'A6', 'Urine AS/NZA 4308:2001 or As/NZA 4308:2008' );
				$this->excel->getActiveSheet()->setCellValue( 'B6', 'Total Donors' );
				$j             = 1;
				$FinalTotalUri = 0;
				foreach ( $getSosAndClientDetils as $getSosAndClientData ) {
					$k        = 6;
					$alphaobj = $alphabet[ $j ];
					$this->excel->getActiveSheet()->setCellValue( $alphaobj . $k, $getSosAndClientData['totalDonarUrine'] );
					$FinalTotalUri += $getSosAndClientData['totalDonarUrine'];
					$j ++;
				}
				$alphaobj = $alphabet[ $j ];
				$this->excel->getActiveSheet()->setCellValue( $alphaobj . $k, $FinalTotalUri );
				$this->excel->getActiveSheet()->setCellValue( 'A7', '' );
				$this->excel->getActiveSheet()->setCellValue( 'B7', 'Positive Result' );
				$totalPositiveUrine = '';
				$j                  = 1;
				$FinalTotalUriPos   = 0;
				foreach ( $getSosAndClientDetils as $getSosAndClientData ) {
					$k                  = 7;
					$alphaobj           = $alphabet[ $j ];
					$totalPositiveUrine = $getSosAndClientData['totalDonarUrine'] - $getSosAndClientData['totalNegativeUrine'];
					$this->excel->getActiveSheet()->setCellValue( $alphaobj . $k, ( $totalPositiveUrine > 0 ? $totalPositiveUrine : 0 ) );
					$FinalTotalUriPos += ( $totalPositiveUrine > 0 ? $totalPositiveUrine : 0 );
					$j ++;
				}
				$alphaobj = $alphabet[ $j ];
				$this->excel->getActiveSheet()->setCellValue( $alphaobj . $k, ( $FinalTotalUriPos > 0 ? $FinalTotalUriPos : 0 ) );
				$this->excel->getActiveSheet()->setCellValue( 'A8', '' );
				$this->excel->getActiveSheet()->setCellValue( 'B8', 'Negative Result' );
				$j                = 1;
				$FinalTotalUriNeg = 0;
				foreach ( $getSosAndClientDetils as $getSosAndClientData ) {
					$k        = 8;
					$alphaobj = $alphabet[ $j ];
					$this->excel->getActiveSheet()->setCellValue( $alphaobj . $k, $getSosAndClientData['totalNegativeUrine'] );
					$FinalTotalUriNeg += $getSosAndClientData['totalNegativeUrine'];
					$j ++;
				}
				$alphaobj = $alphabet[ $j ];
				$this->excel->getActiveSheet()->setCellValue( $alphaobj . $k, ( $FinalTotalUriNeg > 0 ? $FinalTotalUriNeg : 0 ) );
				$this->excel->getActiveSheet()->setCellValue( 'A9', '' );
				$this->excel->getActiveSheet()->setCellValue( 'B9', '' );
				$this->excel->getActiveSheet()->setCellValue( 'C9', '' );
				$this->excel->getActiveSheet()->setCellValue( 'D9', '' );
			}
			if ( $searchArray['szTestType'] == '' || $searchArray['szTestType'] == 'O' ) {
				$this->excel->getActiveSheet()->setCellValue( 'A10', 'Oral Fluid AS 4760:2006' );
				$this->excel->getActiveSheet()->setCellValue( 'B10', 'Total Donors' );
				$j             = 1;
				$FinalTotalOrl = 0;
				foreach ( $getSosAndClientDetils as $getSosAndClientData ) {
					$k        = 10;
					$alphaobj = $alphabet[ $j ];
					$this->excel->getActiveSheet()->setCellValue( $alphaobj . $k, $getSosAndClientData['totalDonarOral'] );
					$FinalTotalOrl += $getSosAndClientData['totalDonarOral'];
					$j ++;
				}
				$alphaobj = $alphabet[ $j ];
				$this->excel->getActiveSheet()->setCellValue( $alphaobj . $k, $FinalTotalOrl );
				$this->excel->getActiveSheet()->setCellValue( 'A11', '' );
				$this->excel->getActiveSheet()->setCellValue( 'B11', 'Positive Result' );
				$j                 = 1;
				$FinalTotalOrlPos  = 0;
				$totalPositiveOral = '';
				foreach ( $getSosAndClientDetils as $getSosAndClientData ) {
					$k                 = 11;
					$alphaobj          = $alphabet[ $j ];
					$totalPositiveOral = $getSosAndClientData['totalDonarOral'] - $getSosAndClientData['totalNegativeOral'];
					$this->excel->getActiveSheet()->setCellValue( $alphaobj . $k, ( $totalPositiveOral > 0 ? $totalPositiveOral : 0 ) );
					$FinalTotalOrlPos += ( $totalPositiveOral > 0 ? $totalPositiveOral : 0 );
					$j ++;
				}
				$alphaobj = $alphabet[ $j ];
				$this->excel->getActiveSheet()->setCellValue( $alphaobj . $k, ( $FinalTotalOrlPos > 0 ? $FinalTotalOrlPos : 0 ) );
				$this->excel->getActiveSheet()->setCellValue( 'A12', '' );
				$this->excel->getActiveSheet()->setCellValue( 'B12', 'Negative Result' );
				$j                = 1;
				$FinalTotalOrlNeg = 0;
				foreach ( $getSosAndClientDetils as $getSosAndClientData ) {
					$k        = 12;
					$alphaobj = $alphabet[ $j ];
					$this->excel->getActiveSheet()->setCellValue( $alphaobj . $k, $getSosAndClientData['totalNegativeOral'] );
					$FinalTotalOrlNeg += $getSosAndClientData['totalNegativeOral'];
					$j ++;
				}
				$alphaobj = $alphabet[ $j ];
				$this->excel->getActiveSheet()->setCellValue( $alphaobj . $k, ( $FinalTotalOrlNeg > 0 ? $FinalTotalOrlNeg : 0 ) );
			}
			$this->excel->getActiveSheet()->getColumnDimension( 'A' )->setAutoSize( true );
			$this->excel->getActiveSheet()->getColumnDimension( 'B' )->setAutoSize( true );
			$j = 1;
			foreach ( $getSosAndClientDetils as $getSosAndClientData ) {
				$alphaobj = $alphabet[ $j ];
				$this->excel->getActiveSheet()->getColumnDimension( $alphaobj )->setAutoSize( true );
				$j ++;
			}
		}
		header( 'Content-Type: application/vnd.ms-excel' ); //mime type
		header( 'Content-Disposition: attachment;filename="' . $file . '"' ); //tell browser what's the file name
		header( 'Cache-Control: max-age=0' ); //no cache
//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
//if you want to save it as .XLSX Excel 2007 format
		$objWriter = PHPExcel_IOFactory::createWriter( $this->excel, 'Excel5' );
//force user to download the Excel file without writing it to server's HD
		$objWriter->save( 'php://output' );
	}
	function comparisonReportPdf() {
		$siteid      = $this->input->post( 'siteid' );
		$testtype    = $this->input->post( 'testtype' );
		$comparetype = $this->input->post( 'comparetype' );
		$this->session->set_userdata( 'siteid', $siteid );
		$this->session->set_userdata( 'testtype', $testtype );
		$this->session->set_userdata( 'comparetype', $comparetype );
		echo "SUCCESS||||";
		echo "comparisonReportOfPdf";
	}
	public function comparisonReportOfPdf() {
		ob_start();
		$this->load->library( 'Pdf' );
		$pdf = new Pdf( 'P', 'mm', 'A4', true, 'UTF-8', false );
		$pdf->SetCreator( PDF_CREATOR );
		$pdf->SetTitle( 'Drug-safe client comparison report' );
		$pdf->SetAuthor( 'Drug-safe' );
		$pdf->SetSubject( 'Stock Request Report PDF' );
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
		$pdf->AddPage( 'L' );
		$siteid      = $this->session->userdata( 'siteid' );
		$testtype    = $this->session->userdata( 'testtype' );
		$comparetype = $this->session->userdata( 'comparetype' );
		$compareresultarr = $this->Reporting_Model->getcomparisonrecord( $siteid, $testtype, $comparetype );
		$userdataarr      = $this->Webservices_Model->getfranchiseeclientsitebysiteid( $siteid );
		$html             = '<a style="text-align:center;  margin-bottom:5px;" href="' . __BASE_URL__ . '" ><img style="width:145px" src="' . __BASE_URL__ . '/images/logo.png" alt="logo" class="logo-default" /> </a>
            <div><p style="text-align:center; font-size:18px; margin-bottom:5px; color:black"><b>Client Comparison Report</b></p></div>';
		if ( ! empty( $userdataarr ) ) {
			$html .= '<div class= "table-responsive" >
                            <table border="1" cellpadding="5">
                            <tr>
                            <th><b>Franchisee Name:</b></th><td>' . ( ! empty( $userdataarr['franchiseename'] ) ? $userdataarr['franchiseename'] : '' ) . '</td>
                            <th><b>Client Name:</b></th><td>' . ( ! empty( $userdataarr['clientname'] ) ? $userdataarr['clientname'] : '' ) . '</td>
                            <th><b>Company Name/site:</b></th><td>' . ( ! empty( $userdataarr['sitename'] ) ? $userdataarr['sitename'] : '' ) . '</td>
                            </tr>
                            </table>
                            </div>';
		}
		$html .= '<div class= "table-responsive" >
                            <table border="1" cellpadding="5">';
		if ( ! empty( $compareresultarr ) ) {
			$html .= '<thead>
                                                <tr>
                                                    <th><b>' . ( $comparetype == 1 ? 'Month' : 'Year' ) . '</b></th>
                                                    <th><b>Test Type</b></th>
                                                    <th><b>Total Donors Screenings/Collection at Clients sites</b></th>
                                                    <th><b>Positive Test Result</b></th>
                                                    <th><b>Negative Test Result</b></th>
                                                </tr>
                                                </thead>
                                                <tbody>';
			foreach ( $compareresultarr as $comparisondata ) {
				$html .= '<tr>
                            <td>
                                ' . ( $comparetype == 1 ? $comparisondata['month'] . ' ' . $comparisondata['year'] : $comparisondata['year'] ) . '
                            </td>
                            <td>' . ( $testtype == '1' ? 'Alcohol' : ( $testtype == '3' ? 'Urine AS/NZA 4308:2001' : ( $testtype == '2' ? 'Oral Fluid AS 4760:2006' : ( $testtype == '4' ? 'As/NZA 4308:2008' : '' ) ) ) ) . '</td>
                            <td>' . ( $testtype == '1' ? $comparisondata['totalAlcohol'] : ( $testtype == '3' ? $comparisondata['totalDonarUrine'] : ( $testtype == '2' ? $comparisondata['totalDonarOral'] : ( $testtype == '4' ? $comparisondata['totalDonarUrine'] : '0' ) ) ) ) . '</td>
                            <td>' . ( $testtype == '1' ? $comparisondata['totalPositiveAlcohol'] : ( $testtype == '3' ? ( $comparisondata['totalDonarUrine'] - $comparisondata['totalNegativeUrine'] ) : ( $testtype == '2' ? ( $comparisondata['totalDonarOral'] - $comparisondata['totalNegativeOral'] ) : ( $testtype == '4' ? ( $comparisondata['totalDonarUrine'] - $comparisondata['totalNegativeUrine'] ) : '0' ) ) ) ) . '</td>
                            <td>' . ( $testtype == '1' ? $comparisondata['totalNegativeAlcohol'] : ( $testtype == '3' ? $comparisondata['totalNegativeUrine'] : ( $testtype == '2' ? $comparisondata['totalNegativeOral'] : ( $testtype == '4' ? $comparisondata['totalNegativeUrine'] : '0' ) ) ) ) . '</td>
                        </tr>';
			}
		} else {
			$html .= '<tr><td>No data found.</td></tr>';
		}
		$html .= '</table>
                        </div>
                      
                        ';
		$pdf->writeHTML( $html, true, false, true, false, '' );
//    $pdf->Write(5, 'CodeIgniter TCPDF Integration');
		error_reporting( E_ALL );
		$pdf->Output( 'client-comparison-report.pdf', 'I' );
	}
	function comparisonReportOfXls() {
		$siteid      = $this->input->post( 'siteid' );
		$testtype    = $this->input->post( 'testtype' );
		$comparetype = $this->input->post( 'comparetype' );
		$this->session->set_userdata( 'siteid', $siteid );
		$this->session->set_userdata( 'testtype', $testtype );
		$this->session->set_userdata( 'comparetype', $comparetype );
		echo "SUCCESS||||";
		echo "comparisonReportXls";
	}
	public function comparisonReportXls() {
		$this->load->library( 'excel' );
		$filename = 'DrugSafe';
		$title    = 'Client Comparison Report';
		$file     = $filename . '-' . $title; //save our workbook as this file name
		$siteid      = $this->session->userdata( 'siteid' );
		$testtype    = $this->session->userdata( 'testtype' );
		$comparetype = $this->session->userdata( 'comparetype' );
		$compareresultarr = $this->Reporting_Model->getcomparisonrecord( $siteid, $testtype, $comparetype );
		$userdataarr      = $this->Webservices_Model->getfranchiseeclientsitebysiteid( $siteid );
		$this->excel->setActiveSheetIndex( 0 );
		$this->excel->getActiveSheet()->setTitle( $title );
		if ( ! empty( $compareresultarr ) ) {
			$this->excel->getActiveSheet()->setCellValue( 'A1', 'Franchisee Name:' );
			$this->excel->getActiveSheet()->getStyle( 'A1' )->getFont()->setSize( 13 );
			$this->excel->getActiveSheet()->getStyle( 'A1' )->getFont()->setBold( true );
			$this->excel->getActiveSheet()->getStyle( 'A1' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
			$this->excel->getActiveSheet()->setCellValue( 'B1', ( ! empty( $userdataarr['franchiseename'] ) ? $userdataarr['franchiseename'] : '' ) );
			$this->excel->getActiveSheet()->getStyle( 'B1' )->getFont()->setSize( 13 );
			$this->excel->getActiveSheet()->getStyle( 'B1' )->getFont()->setBold( false );
			$this->excel->getActiveSheet()->getStyle( 'B1' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
			$this->excel->getActiveSheet()->setCellValue( 'C1', 'Client Name:' );
			$this->excel->getActiveSheet()->getStyle( 'C1' )->getFont()->setSize( 13 );
			$this->excel->getActiveSheet()->getStyle( 'C1' )->getFont()->setBold( true );
			$this->excel->getActiveSheet()->getStyle( 'C1' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
			$this->excel->getActiveSheet()->setCellValue( 'D1', ( ! empty( $userdataarr['clientname'] ) ? $userdataarr['clientname'] : '' ) );
			$this->excel->getActiveSheet()->getStyle( 'D1' )->getFont()->setSize( 13 );
			$this->excel->getActiveSheet()->getStyle( 'D1' )->getFont()->setBold( false );
			$this->excel->getActiveSheet()->getStyle( 'D1' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
			$this->excel->getActiveSheet()->setCellValue( 'E1', 'Company Name/site:' );
			$this->excel->getActiveSheet()->getStyle( 'E1' )->getFont()->setSize( 13 );
			$this->excel->getActiveSheet()->getStyle( 'E1' )->getFont()->setBold( true );
			$this->excel->getActiveSheet()->getStyle( 'E1' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
			$this->excel->getActiveSheet()->setCellValue( 'F1', ( ! empty( $userdataarr['sitename'] ) ? $userdataarr['sitename'] : '' ) );
			$this->excel->getActiveSheet()->getStyle( 'F1' )->getFont()->setSize( 13 );
			$this->excel->getActiveSheet()->getStyle( 'F1' )->getFont()->setBold( false );
			$this->excel->getActiveSheet()->getStyle( 'F1' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
			$this->excel->getActiveSheet()->mergeCells( 'A2:F2' );
			$this->excel->getActiveSheet()->setCellValue( 'A3', '#' );
			$this->excel->getActiveSheet()->getStyle( 'A3' )->getFont()->setSize( 13 );
			$this->excel->getActiveSheet()->getStyle( 'A3' )->getFont()->setBold( true );
			$this->excel->getActiveSheet()->getStyle( 'A3' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
			$this->excel->getActiveSheet()->setCellValue( 'B3', ( $comparetype == 1 ? 'Month' : 'Year' ) );
			$this->excel->getActiveSheet()->getStyle( 'B3' )->getFont()->setSize( 13 );
			$this->excel->getActiveSheet()->getStyle( 'B3' )->getFont()->setBold( true );
			$this->excel->getActiveSheet()->getStyle( 'B3' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
			$this->excel->getActiveSheet()->setCellValue( 'C3', 'Test Type' );
			$this->excel->getActiveSheet()->getStyle( 'C3' )->getFont()->setSize( 13 );
			$this->excel->getActiveSheet()->getStyle( 'C3' )->getFont()->setBold( true );
			$this->excel->getActiveSheet()->getStyle( 'C3' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
			$this->excel->getActiveSheet()->setCellValue( 'D3', 'Total Donors Screenings/Collection at Clients sites' );
			$this->excel->getActiveSheet()->getStyle( 'D3' )->getFont()->setSize( 13 );
			$this->excel->getActiveSheet()->getStyle( 'D3' )->getFont()->setBold( true );
			$this->excel->getActiveSheet()->getStyle( 'D3' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
			$this->excel->getActiveSheet()->setCellValue( 'E3', 'Positive Test Result' );
			$this->excel->getActiveSheet()->getStyle( 'E3' )->getFont()->setSize( 13 );
			$this->excel->getActiveSheet()->getStyle( 'E3' )->getFont()->setBold( true );
			$this->excel->getActiveSheet()->getStyle( 'E3' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
			$this->excel->getActiveSheet()->setCellValue( 'F3', 'Negative Test Result' );
			$this->excel->getActiveSheet()->getStyle( 'F3' )->getFont()->setSize( 13 );
			$this->excel->getActiveSheet()->getStyle( 'F3' )->getFont()->setBold( true );
			$this->excel->getActiveSheet()->getStyle( 'F3' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
			$x = 4;
			foreach ( $compareresultarr as $comparisondata ) {
				$this->excel->getActiveSheet()->setCellValue( 'A' . $x, $x - 3 );
				$this->excel->getActiveSheet()->setCellValue( 'B' . $x, ( $comparetype == 1 ? $comparisondata['month'] . ' ' . $comparisondata['year'] : $comparisondata['year'] ) );
				$this->excel->getActiveSheet()->setCellValue( 'C' . $x, ( $testtype == '1' ? 'Alcohol' : ( $testtype == '3' ? 'Urine AS/NZA 4308:2001' : ( $testtype == '2' ? 'Oral Fluid AS 4760:2006' : ( $testtype == '4' ? 'As/NZA 4308:2008' : '' ) ) ) ) );
				$this->excel->getActiveSheet()->setCellValue( 'D' . $x, ( $testtype == '1' ? $comparisondata['totalAlcohol'] : ( $testtype == '3' ? $comparisondata['totalDonarUrine'] : ( $testtype == '2' ? $comparisondata['totalDonarOral'] : ( $testtype == '4' ? $comparisondata['totalDonarUrine'] : '0' ) ) ) ) );
				$this->excel->getActiveSheet()->setCellValue( 'E' . $x, ( $testtype == '1' ? $comparisondata['totalPositiveAlcohol'] : ( $testtype == '3' ? ( $comparisondata['totalDonarUrine'] - $comparisondata['totalNegativeUrine'] ) : ( $testtype == '2' ? ( $comparisondata['totalDonarOral'] - $comparisondata['totalNegativeOral'] ) : ( $testtype == '4' ? ( $comparisondata['totalDonarUrine'] - $comparisondata['totalNegativeUrine'] ) : '0' ) ) ) ) );
				$this->excel->getActiveSheet()->setCellValue( 'F' . $x, ( $testtype == '1' ? $comparisondata['totalNegativeAlcohol'] : ( $testtype == '3' ? $comparisondata['totalNegativeUrine'] : ( $testtype == '2' ? $comparisondata['totalNegativeOral'] : ( $testtype == '4' ? $comparisondata['totalNegativeUrine'] : '0' ) ) ) ) );
				$this->excel->getActiveSheet()->getColumnDimension( 'A' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'B' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'C' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'D' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'E' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'F' )->setAutoSize( true );
				$x ++;
			}
		} else {
			$this->excel->getActiveSheet()->mergeCells( 'A2:F2' );
			$this->excel->getActiveSheet()->setCellValue( 'A2', 'No data found.' );
		}
		header( 'Content-Type: application/vnd.ms-excel' ); //mime type
		header( 'Content-Disposition: attachment;filename="' . $file . '"' ); //tell browser what's the file name
		header( 'Cache-Control: max-age=0' ); //no cache
//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
//if you want to save it as .XLSX Excel 2007 format
		$objWriter = PHPExcel_IOFactory::createWriter( $this->excel, 'Excel5' );
//force user to download the Excel file without writing it to server's HD
		$objWriter->save( 'php://output' );
	}
	public function view_revenue_summery_client() {
		$count         = $this->Admin_Model->getnotification();
		$is_user_login = is_user_login( $this );
		$clientId      = 0;
		// redirect to dashboard if already logged in
		if ( ! $is_user_login ) {
			ob_end_clean();
			redirect( base_url( '/admin/admin_login' ) );
			die;
		}
		$searchAry = ( isset( $_POST ) ? $_POST : array() );
		if ( $_SESSION['drugsafe_user']['iRole'] == 2 ) {
			$_POST['szSearchClRecord2'] = $_SESSION['drugsafe_user']['id'];
		}
		if ( $_POST['dtStart'] != '' && $_POST['dtEnd'] != '' && $_POST['szSearchClRecord2'] != '' && $_POST['szSearchClRecord1'] != '' ) {
			$clientId                    = $_POST['szSearchClRecord1'];
			$getManualCalcStartToEndDate = $this->Reporting_Model->getAllRevenueManualalc( $searchAry, $_POST['szSearchClRecord2'], $clientId );
		} else {
			$franchiseeId = $this->Form_Management_Model->getAllsosFormDetails( $searchAry );
		}
		if ( $_POST ) {
			$clientAray    = $this->Reporting_Model->getAllClientCodeDetails( true, $_POST['idFranchisee'] );
			$clientlistArr = $this->Reporting_Model->getAllClientCodeDetails( true, $_POST['szSearchClRecord2'] );
		}
		$this->load->library( 'form_validation' );
		$this->form_validation->set_rules( 'szSearchClRecord2', 'Franchisee ', 'required' );
		$this->form_validation->set_rules( 'dtStart', 'Start Revenue date ', 'required' );
		 if(!empty($_POST['dtEnd'])){
                 $this->form_validation->set_rules('dtEnd', 'End Revenue date', 'required|callback_endRevenueDate_check');    
                }
                else{
                 $this->form_validation->set_rules( 'dtEnd', 'End Revenue date', 'required' );   
                }
		$this->form_validation->set_message( 'required', '{field} is required.' );
		if ( $this->form_validation->run() == false ) {
			$data['szMetaTagTitle']  = "Revenue Summary Client";
			$data['is_user_login']   = $is_user_login;
			$data['pageName']        = "Reporting";
			$data['subpageName']     = "revenue_summery_client";
			$data['notification']    = $count;
			$data['data']            = $data;
			$data['clientlistArr']   = $clientlistArr;
			$data['allfranchisee']   = ( ! empty( $franchiseeId ) ? $franchiseeId : array() );
			$data['searchAry']       = $_POST;
			$data['arErrorMessages'] = $this->Reporting_Model->arErrorMessages;
			$this->load->view( 'layout/admin_header', $data );
			$this->load->view( 'reporting/viewRevenueSummeryClient' );
			$this->load->view( 'layout/admin_footer' );
		} else {
			$data['szMetaTagTitle']              = "Revenue Summary Client";
			$data['is_user_login']               = $is_user_login;
			$data['pageName']                    = "Reporting";
			$data['subpageName']                 = "revenue_summery_client";
			$data['notification']                = $count;
			$data['clientlistArr']               = $clientlistArr;
			$data['data']                        = $data;
			$data['searchAry']                   = $_POST;
			$data['getManualCalcStartToEndDate'] = $getManualCalcStartToEndDate;
			$data['allfranchisee']               = ( ! empty( $franchiseeId ) ? $franchiseeId : array() );
			$data['onlyfranchisee']              = ( $clientId == 0 ? 0 : $clientId );
			$data['arErrorMessages']             = $this->Reporting_Model->arErrorMessages;
			$this->load->view( 'layout/admin_header', $data );
			$this->load->view( 'reporting/viewRevenueSummeryClient' );
			$this->load->view( 'layout/admin_footer' );
		}
	}
	public function getClientCodeListByFrIdData( $idFranchisee = '' ) {
		if ( trim( $idFranchisee ) != '' ) {
			$_POST['idFranchisee'] = $idFranchisee;
		}
		$clientAray = $this->Reporting_Model->getAllClientCodeDetails( true, $_POST['idFranchisee'] );
		$result = "<select class=\"form-control custom-select required\" id=\"szSearchClientname\" name=\"szSearchClRecord1\" placeholder=\"Client Name\" onfocus=\"remove_formError(this.id,'true')\">";
		if ( ! empty( $clientAray ) ) {
			$result .= "<option value=''>Client Name</option>";
			foreach ( $clientAray as $clientDetails ) {
				$result .= "<option value='" . $clientDetails['id'] . "'>" . $clientDetails['userCode'] . "-" . $clientDetails['szName'] . "</option>";
			}
		} else {
			$result .= "<option value=''>Client Name</option>";
		}
		$result .= "</select>";
		echo $result;
	}
	function ViewpdfofRevenueSummaryClient() {
		$clientId     = $this->input->post( 'clientId' );
		$franchiseeId = $this->input->post( 'franchiseeId' );
		$dtStart      = $this->input->post( 'dtStart' );
		$dtEnd        = $this->input->post( 'dtEnd' );
		$singleline   = $this->input->post( 'singleline' );
		$this->session->set_userdata( 'franchiseeId', $franchiseeId );
		$this->session->set_userdata( 'clientId', $clientId );
		$this->session->set_userdata( 'dtStart', $dtStart );
		$this->session->set_userdata( 'dtEnd', $dtEnd );
		$this->session->set_userdata( 'singleline', $singleline );
		echo "SUCCESS||||";
		echo "ViewpdfRevenueSummaryClient";
	}
	public function ViewpdfRevenueSummaryClient() {
		ob_start();
		$this->load->library( 'Pdf' );
		$pdf = new Pdf( 'L', 'mm', 'A4', true, 'UTF-8', false );
		$pdf->SetCreator( PDF_CREATOR );
		$pdf->SetTitle( 'Drug-safe Revenue Summary Client' );
		$pdf->SetAuthor( 'Drug-safe' );
		$pdf->SetSubject( 'Revenue Summary Client PDF' );
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
		$pdf->AddPage( 'L' );
		//$pdf->AddPage();
		$searchAry['dtStart'] = $this->session->userdata( 'dtStart' );
		$searchAry['dtEnd']   = $this->session->userdata( 'dtEnd' );
		$franchiseeId         = $this->session->userdata( 'franchiseeId' );
		$clientId             = $this->session->userdata( 'clientId' );
		$singleline           = $this->session->userdata( 'singleline' );
		$searchAry['szSearchClRecord2'] = $franchiseeId;
		$getManualCalcStartToEndDate = $this->Reporting_Model->getAllRevenueManualalc( $searchAry, $franchiseeId, $clientId );
		if ( ( $_SESSION['drugsafe_user']['iRole'] == 1 ) || ( $_SESSION['drugsafe_user']['iRole'] == 5 ) ) {
			$html = '<a style="text-align:center;  margin-bottom:5px;" href="' . __BASE_URL__ . '" ><img style="width:145px" src="' . __BASE_URL__ . '/images/logo.png" alt="logo" class="logo-default" /> </a>
            <div><p style="text-align:center; font-size:18px; margin-bottom:5px; color:black"><b>Revenue Summary Client</b></p></div>
            <div class= "table-responsive" >
                            <table align="center" border="1" cellpadding="5" >
                                    <tr>
                                        <th><b>  #</b> </th>
                                        <th> <b>Franchisee Name </b> </th>
                                        <th> <b>Client Name  </b> </th>
                                         <th> <b>Client Code  </b> </th>
                                         <th><b> Proforma Invoice Date</b></th>
                                        <th> <b> Revenue EXL GST</b> </th> 
                                        <th><b> Royalty Fees </b> </th>
                                        <th> <b>Net Revenue EXL GST</b> </th>
                                    </tr>';
		} else {
			$html = '<a style="text-align:center;  margin-bottom:5px;" href="' . __BASE_URL__ . '" ><img style="width:145px" src="' . __BASE_URL__ . '/images/logo.png" alt="logo" class="logo-default" /> </a>
            <div><p style="text-align:center; font-size:18px; margin-bottom:5px; color:black"><b>Revenue Summary Client</b></p></div>
            <div class= "table-responsive" >
                            <table align="center" border="1" cellpadding="5" >
                                    <tr>
                                        <th><b>  #</b> </th>
                                        <th> <b>Client Name  </b> </th>
                                         <th> <b>Client Code  </b> </th>
                                         <th><b> Proforma Invoice Date</b></th>
                                        <th> <b> Revenue EXL GST</b> </th> 
                                        <th><b> Royalty Fees </b> </th>
                                        <th> <b>Net Revenue EXL GST</b> </th>
                                    </tr>';
		}
		if ( $singleline == 0 && ! empty( $getManualCalcStartToEndDate ) ) {
			$i                = 0;
			$totalRevenu      = '';
			$totalRoyaltyfees = '';
			$totalNetProfit   = '';
			foreach ( $getManualCalcStartToEndDate as $getManualCalcData ) {
				$getClientId          = $this->Form_Management_Model->getSosDetailBySosId( $getManualCalcData['sosid'] );
				$getClientDetails     = $this->Admin_Model->getAdminDetailsByEmailOrId( '', $getClientId['Clientid'] );
				$franchiseecode       = $this->Franchisee_Model->getusercodebyuserid( $getClientDetails['id'] );
				$ClirntDetailsDataAry = $this->Franchisee_Model->getParentClientDetailsId( $getClientId['Clientid'] );
				$userDataAry          = $this->Admin_Model->getUserDetailsByEmailOrId( '', $ClirntDetailsDataAry['clientType'] );
				$discount             = $this->Ordering_Model->getClientDiscountByClientId( $ClirntDetailsDataAry['clientType'] );
				$data                 = $this->Ordering_Model->getManualCalculationBySosId( $getManualCalcData['sosid'] );
				$DrugtestidArr        = array_map( 'intval', str_split( $getClientId['Drugtestid'] ) );
				$frDataAry            = $this->Admin_Model->getUserDetailsByEmailOrId( '', $getManualCalcData['franchiseeId'] );
				if ( in_array( 1, $DrugtestidArr ) || in_array( 2, $DrugtestidArr ) || in_array( 3, $DrugtestidArr ) || in_array( 4, $DrugtestidArr ) ) {
					$countDoner = count( $this->Form_Management_Model->getDonarDetailBySosId( $getManualCalcData['sosid'] ) );
				}
				$ValTotal = 0;
				if ( in_array( 1, $DrugtestidArr ) ) {
					$ValTotal = number_format( $ValTotal + $countDoner * __RRP_1__, 2, '.', '' );
				}
				if ( in_array( 2, $DrugtestidArr ) ) {
					$ValTotal = number_format( $ValTotal + $countDoner * __RRP_2__, 2, '.', '' );
				}
				if ( in_array( 3, $DrugtestidArr ) ) {
					$ValTotal = number_format( $ValTotal + $countDoner * __RRP_3__, 2, '.', '' );
				}
				if ( in_array( 4, $DrugtestidArr ) ) {
					$ValTotal = number_format( $ValTotal + $countDoner * __RRP_4__, 2, '.', '' );
				}
				$GST                = $ValTotal * 0.1;
				$GST                = number_format( $GST, 2, '.', '' );
				$TotalbeforeRoyalty = $ValTotal + $GST;
				$TotalbeforeRoyalty = number_format( $TotalbeforeRoyalty, 2, '.', '' );
				$DcmobileScreen     = $data['mobileScreenBasePrice'] * ( $data['mobileScreenHr'] > 1 ? $data['mobileScreenHr'] : 1 );
				$mobileScreen       = $data['mcbp'] * ( $data['mchr'] > 1 ? $data['mchr'] : 1 );
				$calloutprice       = $data['cobp'] * ( $data['cohr'] > 3 ? $data['cohr'] : 3 );
				$fcoprice           = $data['fcobp'] * ( $data['fcohr'] > 2 ? $data['fcohr'] : 2 );
				$travel             = $data['travelBasePrice'] * ( $data['travelHr'] > 1 ? $data['travelHr'] : 1 );
				$TotalTrevenu = $data['urineNata'] + $data['labconf'] + $data['cancelfee'] + $data['nataLabCnfrm'] + $data['oralFluidNata'] + $data['SyntheticCannabinoids'] + $data['labScrenning'] + $data['RtwScrenning'] + $mobileScreen + $DcmobileScreen + $travel + $calloutprice + $fcoprice;
				$TotalTrevenu    = number_format( $TotalTrevenu, 2, '.', '' );
				$GSTmanual       = ( $TotalTrevenu * 0.1 );
				$GSTmanual       = number_format( $GSTmanual, 2, '.', '' );
				$Total1          = $TotalTrevenu + $GSTmanual;
				$Total1          = number_format( $Total1, 2, '.', '' );
				$totalinvoiceAmt = $ValTotal + $TotalTrevenu;
				if ( ! empty( $discount ) ) {
					$discountpercent = $discount['percentage'];
				} else {
					$discountpercent = 0;
				}
				if ( $discountpercent > 0 ) {
					$totaldiscount      = $totalinvoiceAmt * $discountpercent * 0.01;
					$totalafterdiscount = $totalinvoiceAmt - $totaldiscount;
					$totalGst           = $totalafterdiscount * 0.1;
					$totalRoyaltyBefore = $totalGst + $totalafterdiscount;
				} else {
					$totalGst           = $GST + $GSTmanual;
					$totalRoyaltyBefore = $Total1 + $TotalbeforeRoyalty;
					$totaldiscount      = 0;
					$totalafterdiscount = 0;
				}
				$Royaltyfees = ( $discountpercent > 0 ? number_format( $totalafterdiscount, 2, '.', '' ) : number_format( $totalinvoiceAmt, 2, '.', '' ) ) * 0.1;
				$Royaltyfees = number_format( $Royaltyfees, 2, '.', '' );
				$NetTotal = ( $discountpercent > 0 ? number_format( $totalafterdiscount, 2, '.', '' ) : number_format( $totalinvoiceAmt, 2, '.', '' ) ) - $Royaltyfees;
				$NetTotal = number_format( $NetTotal, 2, '.', '' );
				$totalRevenu      = $totalRevenu + ( $discountpercent > 0 ? number_format( $totalafterdiscount, 2, '.', '' ) : number_format( $totalinvoiceAmt, 2, '.', '' ) );
				$totalRoyaltyfees = $totalRoyaltyfees + $Royaltyfees;
				$totalNetProfit   = $totalNetProfit + $NetTotal;
				$i ++;
				if ( ( $_SESSION['drugsafe_user']['iRole'] == 1 ) || ( $_SESSION['drugsafe_user']['iRole'] == 5 ) ) {
					$html .= '<tr>
                            <td>' . $i . '</td>
                            <td>' . $frDataAry['szName'] . '</td>
                            <td>' . $userDataAry['szName'] . '</td>
                            <td>' . $userDataAry['userCode'] . '</td>
                                 <td>'.((!empty($getManualCalcData['dtCreatedOn']) && $getManualCalcData['dtCreatedOn'] != '0000-00-00') ?date('d/m/Y',strtotime($getManualCalcData['dtCreatedOn'])):'N/A').' </td>
                            <td>$' . ( $discountpercent > 0 ? number_format( $totalafterdiscount, 2, '.', ',' ) : number_format( $totalinvoiceAmt, 2, '.', ',' ) ) . '</td>
                            <td>$' . number_format( $Royaltyfees, 2, '.', ',' ) . '</td>
                            <td>$' . number_format( $NetTotal, 2, '.', ',' ) . '</td>
                            
                        </tr>';
				} else {
					$html .= '<tr>
                            <td>' . $i . '</td>
                            <td>' . $userDataAry['szName'] . '</td>
                            <td>' . $userDataAry['userCode'] . '</td>
                            <td>'.((!empty($getManualCalcData['dtCreatedOn']) && $getManualCalcData['dtCreatedOn'] != '0000-00-00') ?date('d/m/Y',strtotime($getManualCalcData['dtCreatedOn'])):'N/A').' </td>
                            <td>$' . ( $discountpercent > 0 ? number_format( $totalafterdiscount, 2, '.', ',' ) : number_format( $totalinvoiceAmt, 2, '.', ',' ) ) . '</td>
                            <td>$' . number_format( $Royaltyfees, 2, '.', ',' ) . '</td>
                            <td>$' . number_format( $NetTotal, 2, '.', ',' ) . '</td>
                            
                        </tr>';
				}
			}
			$html .= '<tr>';
			if ( ( $_SESSION['drugsafe_user']['iRole'] == 1 ) || ( $_SESSION['drugsafe_user']['iRole'] == 5 ) ) {
				$html .= ' <td></td> ';
			}
			$html .= '<td></td> 
                    <td></td>
                    <td></td>
                    <td><b>Total</b></td>
                    <td><b>$' . number_format( $totalRevenu, 2, '.', ',' ) . '</b></td>
                    <td><b>$' . number_format( $totalRoyaltyfees, 2, '.', ',' ) . '</b></td>
                    <td><b>$' . number_format( $totalNetProfit, 2, '.', ',' ) . '</b></td>
                   </tr>';
		} elseif ( $singleline == 1 ) {
			$allfranchisee = $this->Form_Management_Model->getAllsosFormDetails($searchAry);
			if ( ! empty( $allfranchisee ) ) {
				$allfranchiseeTotalAfterDis    = '';
				$allfranchiseetotalRoyaltyfees = '';
				$allfranchiseetotalNetProfit   = '';
				$frDataAry                     = array();
				$userDataAry                   = array();
				$i                             = 1;
				foreach ( $allfranchisee as $allfranchiseeData ) {
					$clientArr = $this->Webservices_Model->getclientdetails( $allfranchiseeData['franchiseeId'] );
					if ( ! empty( $clientArr ) ) {
						foreach ( $clientArr as $clientData ) {
							$getManualCalcStartToEndDate = $this->Reporting_Model->getAllRevenueManualalc( array(), $allfranchiseeData['franchiseeId'], $clientData['id'] );
							if ( ! empty( $getManualCalcStartToEndDate ) ) {
								$totalRevenu      = '';
								$totalRoyaltyfees = '';
								$totalNetProfit   = '';
								foreach ( $getManualCalcStartToEndDate as $getManualCalcData ) {
									$getClientId      = $this->Form_Management_Model->getSosDetailBySosId( $getManualCalcData['sosid'] );
									$getClientDetails = $this->Admin_Model->getAdminDetailsByEmailOrId( '', $getClientId['Clientid'] );
									$franchiseecode   = $this->Franchisee_Model->getusercodebyuserid( $getClientDetails['id'] );
									$ClirntDetailsDataAry = $this->Franchisee_Model->getParentClientDetailsId( $getClientId['Clientid'] );
									$userDataAry          = $this->Admin_Model->getUserDetailsByEmailOrId( '', $ClirntDetailsDataAry['clientType'] );
									$discount             = $this->Ordering_Model->getClientDiscountByClientId( $ClirntDetailsDataAry['clientType'] );
									$data                 = $this->Ordering_Model->getManualCalculationBySosId( $getManualCalcData['sosid'] );
									$frDataAry            = $this->Admin_Model->getUserDetailsByEmailOrId( '', $getManualCalcData['franchiseeId'] );
									$DrugtestidArr        = array_map( 'intval', str_split( $getClientId['Drugtestid'] ) );
									if ( in_array( 1, $DrugtestidArr ) || in_array( 2, $DrugtestidArr ) || in_array( 3, $DrugtestidArr ) || in_array( 4, $DrugtestidArr ) ) {
										$countDoner = count( $this->Form_Management_Model->getDonarDetailBySosId( $getManualCalcData['sosid'] ) );
									}
									$ValTotal = 0;
									if ( in_array( 1, $DrugtestidArr ) ) {
										$ValTotal = number_format( $ValTotal + $countDoner * __RRP_1__, 2, '.', '' );
									}
									if ( in_array( 2, $DrugtestidArr ) ) {
										$ValTotal = number_format( $ValTotal + $countDoner * __RRP_2__, 2, '.', '' );
									}
									if ( in_array( 3, $DrugtestidArr ) ) {
										$ValTotal = number_format( $ValTotal + $countDoner * __RRP_3__, 2, '.', '' );
									}
									if ( in_array( 4, $DrugtestidArr ) ) {
										$ValTotal = number_format( $ValTotal + $countDoner * __RRP_4__, 2, '.', '' );
									}
									$GST                = $ValTotal * 0.1;
									$GST                = number_format( $GST, 2, '.', '' );
									$TotalbeforeRoyalty = $ValTotal + $GST;
									$TotalbeforeRoyalty = number_format( $TotalbeforeRoyalty, 2, '.', '' );
									$DcmobileScreen     = $data['mobileScreenBasePrice'] * ( $data['mobileScreenHr'] > 1 ? $data['mobileScreenHr'] : 1 );
									$mobileScreen       = $data['mcbp'] * ( $data['mchr'] > 1 ? $data['mchr'] : 1 );
									$calloutprice       = $data['cobp'] * ( $data['cohr'] > 3 ? $data['cohr'] : 3 );
									$fcoprice           = $data['fcobp'] * ( $data['fcohr'] > 2 ? $data['fcohr'] : 2 );
									$travel             = $data['travelBasePrice'] * ( $data['travelHr'] > 1 ? $data['travelHr'] : 1 );
									$TotalTrevenu = $data['urineNata'] + $data['labconf'] + $data['cancelfee'] + $data['nataLabCnfrm'] + $data['oralFluidNata'] + $data['SyntheticCannabinoids'] + $data['labScrenning'] + $data['RtwScrenning'] + $mobileScreen + $DcmobileScreen + $travel + $calloutprice + $fcoprice;
									$TotalTrevenu    = number_format( $TotalTrevenu, 2, '.', '' );
									$GSTmanual       = ( $TotalTrevenu * 0.1 );
									$GSTmanual       = number_format( $GSTmanual, 2, '.', '' );
									$Total1          = $TotalTrevenu + $GSTmanual;
									$Total1          = number_format( $Total1, 2, '.', '' );
									$totalinvoiceAmt = $ValTotal + $TotalTrevenu;
									if ( ! empty( $discount ) ) {
										$discountpercent = $discount['percentage'];
									} else {
										$discountpercent = 0;
									}
									if ( $discountpercent > 0 ) {
										$totaldiscount      = $totalinvoiceAmt * $discountpercent * 0.01;
										$totalafterdiscount = $totalinvoiceAmt - $totaldiscount;
										$totalGst           = $totalafterdiscount * 0.1;
										$totalRoyaltyBefore = $totalGst + $totalafterdiscount;
									} else {
										$totalGst           = $GST + $GSTmanual;
										$totalRoyaltyBefore = $Total1 + $TotalbeforeRoyalty;
										$totaldiscount      = 0;
										$totalafterdiscount = 0;
									}
									$Royaltyfees = ( $discountpercent > 0 ? number_format( $totalafterdiscount, 2, '.', '' ) : number_format( $totalinvoiceAmt, 2, '.', '' ) ) * 0.1;
									$Royaltyfees = number_format( $Royaltyfees, 2, '.', '' );
									$NetTotal = ( $discountpercent > 0 ? number_format( $totalafterdiscount, 2, '.', '' ) : number_format( $totalinvoiceAmt, 2, '.', '' ) ) - $Royaltyfees;
									$NetTotal = number_format( $NetTotal, 2, '.', '' );
									$totalRevenu      = $totalRevenu + ( $discountpercent > 0 ? number_format( $totalafterdiscount, 2, '.', '' ) : number_format( $totalinvoiceAmt, 2, '.', '' ) );
									$totalRoyaltyfees = $totalRoyaltyfees + $Royaltyfees;
									$totalNetProfit   = $totalNetProfit + $NetTotal;
								}
								$totalRevenu                   = number_format( $totalRevenu, 2, '.', '' );
								$totalRoyaltyfees              = number_format( $totalRoyaltyfees, 2, '.', '' );
								$totalNetProfit                = number_format( $totalNetProfit, 2, '.', '' );
								$html                          .= '<tr>
                            <td>' . $i . '</td>' .
								                                  ( ( $_SESSION['drugsafe_user']['iRole'] == 1 ) || ( $_SESSION['drugsafe_user']['iRole'] == 5 ) ? '
                            <td>' . $frDataAry['szName'] . '</td>' : '' ) . '
                            <td>' . $userDataAry['szName'] . '</td>
                            <td>' . $userDataAry['userCode'] . '</td>
                            <td>'.((!empty($getManualCalcData['dtCreatedOn']) && $getManualCalcData['dtCreatedOn'] != '0000-00-00') ?date('d/m/Y',strtotime($getManualCalcData['dtCreatedOn'])):'N/A').' </td>
                            <td>$' . number_format( $totalRevenu, 2, '.', ',' ) . '</td>
                            <td>$' . number_format( $totalRoyaltyfees, 2, '.', ',' ) . '</td>
                            <td>$' . number_format( $totalNetProfit, 2, '.', ',' ) . '</td>                            
                        </tr>';
								$allfranchiseeTotalAfterDis    += $totalRevenu;
								$allfranchiseetotalRoyaltyfees += $totalRoyaltyfees;
								$allfranchiseetotalNetProfit   += $totalNetProfit;
								$i ++;
							}
						}
					}
				}
				$html .= '<tr>' .
				( ( $_SESSION['drugsafe_user']['iRole'] == 1 ) || ( $_SESSION['drugsafe_user']['iRole'] == 5 ) ? '
                            <td colspan="4"></td>' : '<td colspan="3"></td>' ) . '
                            <td><b>Total</b></td>
                            <td><b>$' . number_format( $allfranchiseeTotalAfterDis, 2, '.', ',' ) . '</b></td>
                            <td><b>$' . number_format( $allfranchiseetotalRoyaltyfees, 2, '.', ',' ) . '</b></td>
                            <td><b>$' . number_format( $allfranchiseetotalNetProfit, 2, '.', ',' ) . '</b></td>
                            
                        </tr>';
			}
		}
		$html .= '</table>
                        </div>';
		$pdf->writeHTML( $html, true, false, true, false, '' );
//    $pdf->Write(5, 'CodeIgniter TCPDF Integration');
		error_reporting( E_ALL );
		$pdf->Output( 'revenue-generate.pdf', 'I' );
	}
	function ViewexcelofRevenueSummeryClient() {
		$clientId     = $this->input->post( 'clientId' );
		$franchiseeId = $this->input->post( 'franchiseeId' );
		$dtStart      = $this->input->post( 'dtStart' );
		$dtEnd        = $this->input->post( 'dtEnd' );
		$singleline   = $this->input->post( 'singleline' );
		$this->session->set_userdata( 'franchiseeId', $franchiseeId );
		$this->session->set_userdata( 'clientId', $clientId );
		$this->session->set_userdata( 'dtStart', $dtStart );
		$this->session->set_userdata( 'dtEnd', $dtEnd );
		$this->session->set_userdata( 'singleline', $singleline );
		echo "SUCCESS||||";
		echo "ViewexcelRevenueSummeryClient";
	}
	public function ViewexcelRevenueSummeryClient() {
		$this->load->library( 'excel' );
		$filename = 'DrugSafe';
		$title    = 'Revenue Summary';
		$file     = $filename . '-' . $title; //save our workbook as this file name
		if ( ( $_SESSION['drugsafe_user']['iRole'] == 1 ) || ( $_SESSION['drugsafe_user']['iRole'] == 5 ) ) {
			$this->excel->setActiveSheetIndex( 0 );
			$this->excel->getActiveSheet()->setTitle( $title );
			$this->excel->getActiveSheet()->setCellValue( 'A1', '#' );
			$this->excel->getActiveSheet()->getStyle( 'A1' )->getFont()->setSize( 13 );
			$this->excel->getActiveSheet()->getStyle( 'A1' )->getFont()->setBold( true );
			$this->excel->getActiveSheet()->getStyle( 'A1' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
			$this->excel->getActiveSheet()->setCellValue( 'B1', 'Franchisee Name' );
			$this->excel->getActiveSheet()->getStyle( 'B1' )->getFont()->setSize( 13 );
			$this->excel->getActiveSheet()->getStyle( 'B1' )->getFont()->setBold( true );
			$this->excel->getActiveSheet()->getStyle( 'B1' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
                        
                        
			$this->excel->getActiveSheet()->setCellValue( 'C1', 'Client Name' );
			$this->excel->getActiveSheet()->getStyle( 'C1' )->getFont()->setSize( 13 );
			$this->excel->getActiveSheet()->getStyle( 'C1' )->getFont()->setBold( true );
			$this->excel->getActiveSheet()->getStyle( 'C1' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
			$this->excel->getActiveSheet()->setCellValue( 'D1', ' Client Code' );
			$this->excel->getActiveSheet()->getStyle( 'D1' )->getFont()->setSize( 13 );
			$this->excel->getActiveSheet()->getStyle( 'D1' )->getFont()->setBold( true );
			$this->excel->getActiveSheet()->getStyle( 'D1' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
                        $this->excel->getActiveSheet()->setCellValue( 'E1', 'Proforma Invoice Date' );
			$this->excel->getActiveSheet()->getStyle( 'E1' )->getFont()->setSize( 13 );
			$this->excel->getActiveSheet()->getStyle( 'E1' )->getFont()->setBold( true );
			$this->excel->getActiveSheet()->getStyle( 'E1' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
                        
			$this->excel->getActiveSheet()->setCellValue( 'F1', ' Revenue EXL GST' );
			$this->excel->getActiveSheet()->getStyle( 'F1' )->getFont()->setSize( 13 );
			$this->excel->getActiveSheet()->getStyle( 'F1' )->getFont()->setBold( true );
			$this->excel->getActiveSheet()->getStyle( 'F1' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
			$this->excel->getActiveSheet()->setCellValue( 'G1', 'Royalty Fees' );
			$this->excel->getActiveSheet()->getStyle( 'G1' )->getFont()->setSize( 13 );
			$this->excel->getActiveSheet()->getStyle( 'G1' )->getFont()->setBold( true );
			$this->excel->getActiveSheet()->getStyle( 'G1' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
			$this->excel->getActiveSheet()->setCellValue( 'H1', 'Net Revenue EXL GST' );
			$this->excel->getActiveSheet()->getStyle( 'H1' )->getFont()->setSize( 13 );
			$this->excel->getActiveSheet()->getStyle( 'H1' )->getFont()->setBold( true );
			$this->excel->getActiveSheet()->getStyle( 'H1' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		} else {
			$this->excel->setActiveSheetIndex( 0 );
			$this->excel->getActiveSheet()->setTitle( $title );
			$this->excel->getActiveSheet()->setCellValue( 'A1', '#' );
			$this->excel->getActiveSheet()->getStyle( 'A1' )->getFont()->setSize( 13 );
			$this->excel->getActiveSheet()->getStyle( 'A1' )->getFont()->setBold( true );
			$this->excel->getActiveSheet()->getStyle( 'A1' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
			$this->excel->getActiveSheet()->setCellValue( 'B1', 'Client Name' );
			$this->excel->getActiveSheet()->getStyle( 'B1' )->getFont()->setSize( 13 );
			$this->excel->getActiveSheet()->getStyle( 'B1' )->getFont()->setBold( true );
			$this->excel->getActiveSheet()->getStyle( 'B1' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
			$this->excel->getActiveSheet()->setCellValue( 'C1', ' Client Code' );
			$this->excel->getActiveSheet()->getStyle( 'C1' )->getFont()->setSize( 13 );
			$this->excel->getActiveSheet()->getStyle( 'C1' )->getFont()->setBold( true );
			$this->excel->getActiveSheet()->getStyle( 'C1' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
			$this->excel->getActiveSheet()->setCellValue( 'D1', ' Revenue EXL GST' );
			$this->excel->getActiveSheet()->getStyle( 'D1' )->getFont()->setSize( 13 );
			$this->excel->getActiveSheet()->getStyle( 'D1' )->getFont()->setBold( true );
			$this->excel->getActiveSheet()->getStyle( 'D1' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
                        $this->excel->getActiveSheet()->setCellValue( 'E1', 'Proforma Invoice Date' );
			$this->excel->getActiveSheet()->getStyle( 'E1' )->getFont()->setSize( 13 );
			$this->excel->getActiveSheet()->getStyle( 'E1' )->getFont()->setBold( true );
			$this->excel->getActiveSheet()->getStyle( 'E1' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
                        
			$this->excel->getActiveSheet()->setCellValue( 'F1', 'Royalty Fees' );
			$this->excel->getActiveSheet()->getStyle( 'F1' )->getFont()->setSize( 13 );
			$this->excel->getActiveSheet()->getStyle( 'F1' )->getFont()->setBold( true );
			$this->excel->getActiveSheet()->getStyle( 'F1' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
			$this->excel->getActiveSheet()->setCellValue( 'G1', 'Net Revenue EXL GST' );
			$this->excel->getActiveSheet()->getStyle( 'G1' )->getFont()->setSize( 13 );
			$this->excel->getActiveSheet()->getStyle( 'G1' )->getFont()->setBold( true );
			$this->excel->getActiveSheet()->getStyle( 'G1' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		}
		$searchAry['dtStart'] = $this->session->userdata( 'dtStart' );
		$searchAry['dtEnd']   = $this->session->userdata( 'dtEnd' );
		$franchiseeId         = $this->session->userdata( 'franchiseeId' );
		$clientId             = $this->session->userdata( 'clientId' );
		$singleline           = $this->session->userdata( 'singleline' );
		$searchAry['szSearchClRecord2'] = $franchiseeId;
		$getManualCalcStartToEndDate = $this->Reporting_Model->getAllRevenueManualalc( $searchAry, $franchiseeId, $clientId );
		if ( $singleline == 0 && ! empty( $getManualCalcStartToEndDate ) ) {
			$i                = 2;
			$x                = 0;
			$totalRevenu      = '';
			$totalRoyaltyfees = '';
			$totalNetProfit   = '';
			foreach ( $getManualCalcStartToEndDate as $getManualCalcData ) {
				$frDataAry            = $this->Admin_Model->getUserDetailsByEmailOrId( '', $getManualCalcData['franchiseeId'] );
				$getClientId          = $this->Form_Management_Model->getSosDetailBySosId( $getManualCalcData['sosid'] );
				$getClientDetails     = $this->Admin_Model->getAdminDetailsByEmailOrId( '', $getClientId['Clientid'] );
				$franchiseecode       = $this->Franchisee_Model->getusercodebyuserid( $getClientDetails['id'] );
				$ClirntDetailsDataAry = $this->Franchisee_Model->getParentClientDetailsId( $getClientId['Clientid'] );
				$userDataAry          = $this->Admin_Model->getUserDetailsByEmailOrId( '', $ClirntDetailsDataAry['clientType'] );
				$discount             = $this->Ordering_Model->getClientDiscountByClientId( $ClirntDetailsDataAry['clientType'] );
				$data                 = $this->Ordering_Model->getManualCalculationBySosId( $getManualCalcData['sosid'] );
				$DrugtestidArr        = array_map( 'intval', str_split( $getClientId['Drugtestid'] ) );
				if ( in_array( 1, $DrugtestidArr ) || in_array( 2, $DrugtestidArr ) || in_array( 3, $DrugtestidArr ) || in_array( 4, $DrugtestidArr ) ) {
					$countDoner = count( $this->Form_Management_Model->getDonarDetailBySosId( $getManualCalcData['sosid'] ) );
				}
				$ValTotal = 0;
				if ( in_array( 1, $DrugtestidArr ) ) {
					$ValTotal = number_format( $ValTotal + $countDoner * __RRP_1__, 2, '.', '' );
				}
				if ( in_array( 2, $DrugtestidArr ) ) {
					$ValTotal = number_format( $ValTotal + $countDoner * __RRP_2__, 2, '.', '' );
				}
				if ( in_array( 3, $DrugtestidArr ) ) {
					$ValTotal = number_format( $ValTotal + $countDoner * __RRP_3__, 2, '.', '' );
				}
				if ( in_array( 4, $DrugtestidArr ) ) {
					$ValTotal = number_format( $ValTotal + $countDoner * __RRP_4__, 2, '.', '' );
				}
				$GST                = $ValTotal * 0.1;
				$GST                = number_format( $GST, 2, '.', '' );
				$TotalbeforeRoyalty = $ValTotal + $GST;
				$TotalbeforeRoyalty = number_format( $TotalbeforeRoyalty, 2, '.', '' );
				$DcmobileScreen     = $data['mobileScreenBasePrice'] * ( $data['mobileScreenHr'] > 1 ? $data['mobileScreenHr'] : 1 );
				$mobileScreen       = $data['mcbp'] * ( $data['mchr'] > 1 ? $data['mchr'] : 1 );
				$calloutprice       = $data['cobp'] * ( $data['cohr'] > 3 ? $data['cohr'] : 3 );
				$fcoprice           = $data['fcobp'] * ( $data['fcohr'] > 2 ? $data['fcohr'] : 2 );
				$travel             = $data['travelBasePrice'] * ( $data['travelHr'] > 1 ? $data['travelHr'] : 1 );
				$TotalTrevenu = $data['urineNata'] + $data['labconf'] + $data['cancelfee'] + $data['nataLabCnfrm'] + $data['oralFluidNata'] + $data['SyntheticCannabinoids'] + $data['labScrenning'] + $data['RtwScrenning'] + $mobileScreen + $DcmobileScreen + $travel + $calloutprice + $fcoprice;
				$TotalTrevenu    = number_format( $TotalTrevenu, 2, '.', '' );
				$GSTmanual       = ( $TotalTrevenu * 0.1 );
				$GSTmanual       = number_format( $GSTmanual, 2, '.', '' );
				$Total1          = $TotalTrevenu + $GSTmanual;
				$Total1          = number_format( $Total1, 2, '.', '' );
				$totalinvoiceAmt = $ValTotal + $TotalTrevenu;
				if ( ! empty( $discount ) ) {
					$discountpercent = $discount['percentage'];
				} else {
					$discountpercent = 0;
				}
				if ( $discountpercent > 0 ) {
					$totaldiscount      = $totalinvoiceAmt * $discountpercent * 0.01;
					$totalafterdiscount = $totalinvoiceAmt - $totaldiscount;
					$totalGst           = $totalafterdiscount * 0.1;
					$totalRoyaltyBefore = $totalGst + $totalafterdiscount;
				} else {
					$totalGst           = $GST + $GSTmanual;
					$totalRoyaltyBefore = $Total1 + $TotalbeforeRoyalty;
					$totaldiscount      = 0;
					$totalafterdiscount = 0;
				}
				$Royaltyfees = ( $discountpercent > 0 ? number_format( $totalafterdiscount, 2, '.', '' ) : number_format( $totalinvoiceAmt, 2, '.', '' ) ) * 0.1;
				$Royaltyfees = number_format( $Royaltyfees, 2, '.', '' );
				$NetTotal = ( $discountpercent > 0 ? number_format( $totalafterdiscount, 2, '.', '' ) : number_format( $totalinvoiceAmt, 2, '.', '' ) ) - $Royaltyfees;
				$NetTotal = number_format( $NetTotal, 2, '.', '' );
				$totalRevenu      = $totalRevenu + ( $discountpercent > 0 ? number_format( $totalafterdiscount, 2, '.', '' ) : number_format( $totalinvoiceAmt, 2, '.', '' ) );
				$totalRoyaltyfees = $totalRoyaltyfees + $Royaltyfees;
				$totalNetProfit   = $totalNetProfit + $NetTotal;
				$x ++;
				$value = number_format( $ValTotal, 2, '.', ',' );
                                if((!empty($getManualCalcData['dtCreatedOn']) && $getManualCalcData['dtCreatedOn'] != '0000-00-00'))
                                {
                                  $date_data = date('d/m/Y',strtotime($getManualCalcData['dtCreatedOn'])); 
                                }
                                else{
                                 $date_data = 'N/A';   
                                }
                                
				if ( ( $_SESSION['drugsafe_user']['iRole'] == 1 ) || ( $_SESSION['drugsafe_user']['iRole'] == 5 ) ) {
					$this->excel->getActiveSheet()->setCellValue( 'A' . $i, $x );
					$this->excel->getActiveSheet()->setCellValue( 'B' . $i, $frDataAry['szName'] );
					$this->excel->getActiveSheet()->setCellValue( 'C' . $i, $userDataAry['szName'] );
					$this->excel->getActiveSheet()->setCellValue( 'D' . $i, $userDataAry['userCode'] );
                                        $this->excel->getActiveSheet()->setCellValue( 'E' . $i, $date_data );
					$this->excel->getActiveSheet()->setCellValue( 'F' . $i, '$' . ( $discountpercent > 0 ? number_format( $totalafterdiscount, 2, '.', ',' ) : number_format( $totalinvoiceAmt, 2, '.', ',' ) ) );
					$this->excel->getActiveSheet()->setCellValue( 'G' . $i, '$' . number_format( $Royaltyfees, 2, '.', ',' ) );
					$this->excel->getActiveSheet()->setCellValue( 'H' . $i, '$' . number_format( $NetTotal, 2, '.', ',' ) );
					$this->excel->getActiveSheet()->getColumnDimension( 'A' )->setAutoSize( true );
					$this->excel->getActiveSheet()->getColumnDimension( 'B' )->setAutoSize( true );
					$this->excel->getActiveSheet()->getColumnDimension( 'C' )->setAutoSize( true );
					$this->excel->getActiveSheet()->getColumnDimension( 'D' )->setAutoSize( true );
					$this->excel->getActiveSheet()->getColumnDimension( 'E' )->setAutoSize( true );
					$this->excel->getActiveSheet()->getColumnDimension( 'F' )->setAutoSize( true );
					$this->excel->getActiveSheet()->getColumnDimension( 'G' )->setAutoSize( true );
                                        $this->excel->getActiveSheet()->getColumnDimension( 'H' )->setAutoSize( true );
				} else {
					$this->excel->getActiveSheet()->setCellValue( 'A' . $i, $x );
					$this->excel->getActiveSheet()->setCellValue( 'B' . $i, $userDataAry['szName'] );
					$this->excel->getActiveSheet()->setCellValue( 'C' . $i, $userDataAry['userCode'] );
                                        $this->excel->getActiveSheet()->setCellValue( 'D' . $i, $date_data );
					$this->excel->getActiveSheet()->setCellValue( 'E' . $i, '$' . ( $discountpercent > 0 ? number_format( $totalafterdiscount, 2, '.', ',' ) : number_format( $totalinvoiceAmt, 2, '.', ',' ) ) );
					$this->excel->getActiveSheet()->setCellValue( 'F' . $i, '$' . number_format( $Royaltyfees, 2, '.', ',' ) );
					$this->excel->getActiveSheet()->setCellValue( 'G' . $i, '$' . number_format( $NetTotal, 2, '.', ',' ) );
					$this->excel->getActiveSheet()->getColumnDimension( 'A' )->setAutoSize( true );
					$this->excel->getActiveSheet()->getColumnDimension( 'B' )->setAutoSize( true );
					$this->excel->getActiveSheet()->getColumnDimension( 'C' )->setAutoSize( true );
					$this->excel->getActiveSheet()->getColumnDimension( 'D' )->setAutoSize( true );
					$this->excel->getActiveSheet()->getColumnDimension( 'E' )->setAutoSize( true );
					$this->excel->getActiveSheet()->getColumnDimension( 'F' )->setAutoSize( true );
                                        $this->excel->getActiveSheet()->getColumnDimension( 'G' )->setAutoSize( true );
				}
				$i ++;
			}
			$totalRevenu      = number_format( $totalRevenu, 2, '.', '' );
			$totalRoyaltyfees = number_format( $totalRoyaltyfees, 2, '.', '' );
			$totalNetProfit   = number_format( $totalNetProfit, 2, '.', '' );
			if ( ( $_SESSION['drugsafe_user']['iRole'] == 1 ) || ( $_SESSION['drugsafe_user']['iRole'] == 5 ) ) {
				$this->excel->getActiveSheet()->setCellValue( 'E' . $i, Total );
				$this->excel->getActiveSheet()->setCellValue( 'F' . $i, '$' . number_format( $totalRevenu, 2, '.', ',' ) );
				$this->excel->getActiveSheet()->setCellValue( 'G' . $i, '$' . number_format( $totalRoyaltyfees, 2, '.', ',' ) );
				$this->excel->getActiveSheet()->setCellValue( 'H' . $i, '$' . number_format( $totalNetProfit, 2, '.', ',' ) );
			} else {
				$this->excel->getActiveSheet()->setCellValue( 'D' . $i, Total );
				$this->excel->getActiveSheet()->setCellValue( 'E' . $i, '$' . number_format( $totalRevenu, 2, '.', ',' ) );
				$this->excel->getActiveSheet()->setCellValue( 'F' . $i, '$' . number_format( $totalRoyaltyfees, 2, '.', ',' ) );
				$this->excel->getActiveSheet()->setCellValue( 'G' . $i, '$' . number_format( $totalNetProfit, 2, '.', ',' ) );
			}
			$this->excel->getActiveSheet()->getStyle( 'D' . $i )->getFont()->setSize( 13 );
			$this->excel->getActiveSheet()->getStyle( 'D' . $i )->getFont()->setBold( true );
			$this->excel->getActiveSheet()->getStyle( 'D' . $i )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_LEFT );
			$this->excel->getActiveSheet()->getStyle( 'E' . $i )->getFont()->setSize( 13 );
			$this->excel->getActiveSheet()->getStyle( 'E' . $i )->getFont()->setBold( true );
			$this->excel->getActiveSheet()->getStyle( 'E' . $i )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_LEFT );
			$this->excel->getActiveSheet()->getStyle( 'F' . $i )->getFont()->setSize( 13 );
			$this->excel->getActiveSheet()->getStyle( 'F' . $i )->getFont()->setBold( true );
			$this->excel->getActiveSheet()->getStyle( 'F' . $i )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_LEFT );
			$this->excel->getActiveSheet()->getStyle( 'G' . $i )->getFont()->setSize( 13 );
			$this->excel->getActiveSheet()->getStyle( 'G' . $i )->getFont()->setBold( true );
			$this->excel->getActiveSheet()->getStyle( 'G' . $i )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_LEFT );
			$this->excel->getActiveSheet()->getStyle( 'H' . $i )->getFont()->setSize( 13 );
			$this->excel->getActiveSheet()->getStyle( 'H' . $i )->getFont()->setBold( true );
			$this->excel->getActiveSheet()->getStyle( 'H' . $i )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_LEFT );
		} elseif ( $singleline == 1 ) {
			$allfranchisee = $this->Form_Management_Model->getAllsosFormDetails($searchAry);
			if ( ! empty( $allfranchisee ) ) {
				$allfranchiseeTotalAfterDis    = '';
				$allfranchiseetotalRoyaltyfees = '';
				$allfranchiseetotalNetProfit   = '';
				$frDataAry                     = array();
				$userDataAry                   = array();
				$i                             = 2;
				$x                             = 1;
				foreach ( $allfranchisee as $allfranchiseeData ) {
					$clientArr = $this->Webservices_Model->getclientdetails( $allfranchiseeData['franchiseeId'] );
					if ( ! empty( $clientArr ) ) {
						foreach ( $clientArr as $clientData ) {
							$getManualCalcStartToEndDate = $this->Reporting_Model->getAllRevenueManualalc( array(), $allfranchiseeData['franchiseeId'], $clientData['id'] );
							if ( ! empty( $getManualCalcStartToEndDate ) ) {
								$totalRevenu      = '';
								$totalRoyaltyfees = '';
								$totalNetProfit   = '';
								foreach ( $getManualCalcStartToEndDate as $getManualCalcData ) {
									$getClientId      = $this->Form_Management_Model->getSosDetailBySosId( $getManualCalcData['sosid'] );
									$getClientDetails = $this->Admin_Model->getAdminDetailsByEmailOrId( '', $getClientId['Clientid'] );
									$franchiseecode   = $this->Franchisee_Model->getusercodebyuserid( $getClientDetails['id'] );
									$ClirntDetailsDataAry = $this->Franchisee_Model->getParentClientDetailsId( $getClientId['Clientid'] );
									$userDataAry          = $this->Admin_Model->getUserDetailsByEmailOrId( '', $ClirntDetailsDataAry['clientType'] );
									$discount             = $this->Ordering_Model->getClientDiscountByClientId( $ClirntDetailsDataAry['clientType'] );
									$data                 = $this->Ordering_Model->getManualCalculationBySosId( $getManualCalcData['sosid'] );
									$frDataAry            = $this->Admin_Model->getUserDetailsByEmailOrId( '', $getManualCalcData['franchiseeId'] );
									$DrugtestidArr        = array_map( 'intval', str_split( $getClientId['Drugtestid'] ) );
									if ( in_array( 1, $DrugtestidArr ) || in_array( 2, $DrugtestidArr ) || in_array( 3, $DrugtestidArr ) || in_array( 4, $DrugtestidArr ) ) {
										$countDoner = count( $this->Form_Management_Model->getDonarDetailBySosId( $getManualCalcData['sosid'] ) );
									}
									$ValTotal = 0;
									if ( in_array( 1, $DrugtestidArr ) ) {
										$ValTotal = number_format( $ValTotal + $countDoner * __RRP_1__, 2, '.', '' );
									}
									if ( in_array( 2, $DrugtestidArr ) ) {
										$ValTotal = number_format( $ValTotal + $countDoner * __RRP_2__, 2, '.', '' );
									}
									if ( in_array( 3, $DrugtestidArr ) ) {
										$ValTotal = number_format( $ValTotal + $countDoner * __RRP_3__, 2, '.', '' );
									}
									if ( in_array( 4, $DrugtestidArr ) ) {
										$ValTotal = number_format( $ValTotal + $countDoner * __RRP_4__, 2, '.', '' );
									}
									$GST                = $ValTotal * 0.1;
									$GST                = number_format( $GST, 2, '.', '' );
									$TotalbeforeRoyalty = $ValTotal + $GST;
									$TotalbeforeRoyalty = number_format( $TotalbeforeRoyalty, 2, '.', '' );
									$DcmobileScreen     = $data['mobileScreenBasePrice'] * ( $data['mobileScreenHr'] > 1 ? $data['mobileScreenHr'] : 1 );
									$mobileScreen       = $data['mcbp'] * ( $data['mchr'] > 1 ? $data['mchr'] : 1 );
									$calloutprice       = $data['cobp'] * ( $data['cohr'] > 3 ? $data['cohr'] : 3 );
									$fcoprice           = $data['fcobp'] * ( $data['fcohr'] > 2 ? $data['fcohr'] : 2 );
									$travel             = $data['travelBasePrice'] * ( $data['travelHr'] > 1 ? $data['travelHr'] : 1 );
									$TotalTrevenu = $data['urineNata'] + $data['labconf'] + $data['cancelfee'] + $data['nataLabCnfrm'] + $data['oralFluidNata'] + $data['SyntheticCannabinoids'] + $data['labScrenning'] + $data['RtwScrenning'] + $mobileScreen + $DcmobileScreen + $travel + $calloutprice + $fcoprice;
									$TotalTrevenu    = number_format( $TotalTrevenu, 2, '.', '' );
									$GSTmanual       = ( $TotalTrevenu * 0.1 );
									$GSTmanual       = number_format( $GSTmanual, 2, '.', '' );
									$Total1          = $TotalTrevenu + $GSTmanual;
									$Total1          = number_format( $Total1, 2, '.', '' );
									$totalinvoiceAmt = $ValTotal + $TotalTrevenu;
									if ( ! empty( $discount ) ) {
										$discountpercent = $discount['percentage'];
									} else {
										$discountpercent = 0;
									}
									if ( $discountpercent > 0 ) {
										$totaldiscount      = $totalinvoiceAmt * $discountpercent * 0.01;
										$totalafterdiscount = $totalinvoiceAmt - $totaldiscount;
										$totalGst           = $totalafterdiscount * 0.1;
										$totalRoyaltyBefore = $totalGst + $totalafterdiscount;
									} else {
										$totalGst           = $GST + $GSTmanual;
										$totalRoyaltyBefore = $Total1 + $TotalbeforeRoyalty;
										$totaldiscount      = 0;
										$totalafterdiscount = 0;
									}
									$Royaltyfees = ( $discountpercent > 0 ? number_format( $totalafterdiscount, 2, '.', '' ) : number_format( $totalinvoiceAmt, 2, '.', '' ) ) * 0.1;
									$Royaltyfees = number_format( $Royaltyfees, 2, '.', '' );
									$NetTotal = ( $discountpercent > 0 ? number_format( $totalafterdiscount, 2, '.', '' ) : number_format( $totalinvoiceAmt, 2, '.', '' ) ) - $Royaltyfees;
									$NetTotal = number_format( $NetTotal, 2, '.', '' );
									$totalRevenu      = $totalRevenu + ( $discountpercent > 0 ? number_format( $totalafterdiscount, 2, '.', '' ) : number_format( $totalinvoiceAmt, 2, '.', '' ) );
									$totalRoyaltyfees = $totalRoyaltyfees + $Royaltyfees;
									$totalNetProfit   = $totalNetProfit + $NetTotal;
								}
								$totalRevenu      = number_format( $totalRevenu, 2, '.', '' );
								$totalRoyaltyfees = number_format( $totalRoyaltyfees, 2, '.', '' );
								$totalNetProfit   = number_format( $totalNetProfit, 2, '.', '' );
                                                                if((!empty($getManualCalcData['dtCreatedOn']) && $getManualCalcData['dtCreatedOn'] != '0000-00-00'))
                                                                    {
                                                                      $date_data = date('d/m/Y',strtotime($getManualCalcData['dtCreatedOn'])); 
                                                                    }
                                                                    else{
                                                                     $date_data = 'N/A';   
                                                                    }
								if ( ( $_SESSION['drugsafe_user']['iRole'] == 1 ) || ( $_SESSION['drugsafe_user']['iRole'] == 5 ) ) {
									$this->excel->getActiveSheet()->setCellValue( 'A' . $i, $x );
									$this->excel->getActiveSheet()->setCellValue( 'B' . $i, $frDataAry['szName'] );
									$this->excel->getActiveSheet()->setCellValue( 'C' . $i, $userDataAry['szName'] );
									$this->excel->getActiveSheet()->setCellValue( 'D' . $i, $userDataAry['userCode'] );
                                                                        $this->excel->getActiveSheet()->setCellValue( 'E' . $i, $date_data);
									$this->excel->getActiveSheet()->setCellValue( 'F' . $i, '$' . number_format( $totalRevenu, 2, '.', ',' ) );
									$this->excel->getActiveSheet()->setCellValue( 'G' . $i, '$' . number_format( $totalRoyaltyfees, 2, '.', ',' ) );
									$this->excel->getActiveSheet()->setCellValue( 'H' . $i, '$' . number_format( $totalNetProfit, 2, '.', ',' ) );
									$this->excel->getActiveSheet()->getColumnDimension( 'A' )->setAutoSize( true );
									$this->excel->getActiveSheet()->getColumnDimension( 'B' )->setAutoSize( true );
									$this->excel->getActiveSheet()->getColumnDimension( 'C' )->setAutoSize( true );
									$this->excel->getActiveSheet()->getColumnDimension( 'D' )->setAutoSize( true );
									$this->excel->getActiveSheet()->getColumnDimension( 'E' )->setAutoSize( true );
									$this->excel->getActiveSheet()->getColumnDimension( 'F' )->setAutoSize( true );
									$this->excel->getActiveSheet()->getColumnDimension( 'G' )->setAutoSize( true );
                                                                        $this->excel->getActiveSheet()->getColumnDimension( 'H' )->setAutoSize( true );
								} else {
									$this->excel->getActiveSheet()->setCellValue( 'A' . $i, $x );
									$this->excel->getActiveSheet()->setCellValue( 'B' . $i, $userDataAry['szName'] );
									$this->excel->getActiveSheet()->setCellValue( 'C' . $i, $userDataAry['userCode'] );
                                                                        $this->excel->getActiveSheet()->setCellValue( 'D' . $i, $date_data);
									$this->excel->getActiveSheet()->setCellValue( 'E' . $i, '$' . number_format( $totalRevenu, 2, '.', ',' ) );
									$this->excel->getActiveSheet()->setCellValue( 'F' . $i, '$' . number_format( $totalRoyaltyfees, 2, '.', ',' ) );
									$this->excel->getActiveSheet()->setCellValue( 'G' . $i, '$' . number_format( $totalNetProfit, 2, '.', ',' ) );
									$this->excel->getActiveSheet()->getColumnDimension( 'A' )->setAutoSize( true );
									$this->excel->getActiveSheet()->getColumnDimension( 'B' )->setAutoSize( true );
									$this->excel->getActiveSheet()->getColumnDimension( 'C' )->setAutoSize( true );
									$this->excel->getActiveSheet()->getColumnDimension( 'D' )->setAutoSize( true );
									$this->excel->getActiveSheet()->getColumnDimension( 'E' )->setAutoSize( true );
									$this->excel->getActiveSheet()->getColumnDimension( 'F' )->setAutoSize( true );
                                                                        $this->excel->getActiveSheet()->getColumnDimension( 'G' )->setAutoSize( true );
								}
								$allfranchiseeTotalAfterDis    += $totalRevenu;
								$allfranchiseetotalRoyaltyfees += $totalRoyaltyfees;
								$allfranchiseetotalNetProfit   += $totalNetProfit;
								$i ++;
								$x ++;
							}
						}
					}
					if ( ( $_SESSION['drugsafe_user']['iRole'] == 1 ) || ( $_SESSION['drugsafe_user']['iRole'] == 5 ) ) {
						$this->excel->getActiveSheet()->setCellValue( 'E' . $i, Total );
						$this->excel->getActiveSheet()->setCellValue( 'F' . $i, '$' . number_format( $allfranchiseeTotalAfterDis, 2, '.', ',' ) );
						$this->excel->getActiveSheet()->setCellValue( 'G' . $i, '$' . number_format( $allfranchiseetotalRoyaltyfees, 2, '.', ',' ) );
						$this->excel->getActiveSheet()->setCellValue( 'H' . $i, '$' . number_format( $allfranchiseetotalNetProfit, 2, '.', ',' ) );
					} else {
						$this->excel->getActiveSheet()->setCellValue( 'D' . $i, Total );
						$this->excel->getActiveSheet()->setCellValue( 'E' . $i, '$' . number_format( $allfranchiseeTotalAfterDis, 2, '.', ',' ) );
						$this->excel->getActiveSheet()->setCellValue( 'F' . $i, '$' . number_format( $allfranchiseetotalRoyaltyfees, 2, '.', ',' ) );
						$this->excel->getActiveSheet()->setCellValue( 'G' . $i, '$' . number_format( $allfranchiseetotalNetProfit, 2, '.', ',' ) );
					}
				}
				$this->excel->getActiveSheet()->getStyle( 'D' . $i )->getFont()->setSize( 13 );
				$this->excel->getActiveSheet()->getStyle( 'D' . $i )->getFont()->setBold( true );
				$this->excel->getActiveSheet()->getStyle( 'D' . $i )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_LEFT );
				$this->excel->getActiveSheet()->getStyle( 'E' . $i )->getFont()->setSize( 13 );
				$this->excel->getActiveSheet()->getStyle( 'E' . $i )->getFont()->setBold( true );
				$this->excel->getActiveSheet()->getStyle( 'E' . $i )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_LEFT );
				$this->excel->getActiveSheet()->getStyle( 'F' . $i )->getFont()->setSize( 13 );
				$this->excel->getActiveSheet()->getStyle( 'F' . $i )->getFont()->setBold( true );
				$this->excel->getActiveSheet()->getStyle( 'F' . $i )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_LEFT );
				$this->excel->getActiveSheet()->getStyle( 'G' . $i )->getFont()->setSize( 13 );
				$this->excel->getActiveSheet()->getStyle( 'G' . $i )->getFont()->setBold( true );
				$this->excel->getActiveSheet()->getStyle( 'G' . $i )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_LEFT );
				$this->excel->getActiveSheet()->getStyle( 'H' . $i )->getFont()->setSize( 13 );
				$this->excel->getActiveSheet()->getStyle( 'H' . $i )->getFont()->setBold( true );
				$this->excel->getActiveSheet()->getStyle( 'H' . $i )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_LEFT );
			}
		}
		header( 'Content-Type: application/vnd.ms-excel' ); //mime type
		header( 'Content-Disposition: attachment;filename="' . $file . '"' ); //tell browser what's the file name
		header( 'Cache-Control: max-age=0' ); //no cache
//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
//if you want to save it as .XLSX Excel 2007 format
		$objWriter = PHPExcel_IOFactory::createWriter( $this->excel, 'Excel5' );
//force user to download the Excel file without writing it to server's HD
		$objWriter->save( 'php://output' );
	}
	function industryReportChart() {
		$dtStart    = $this->input->post( 'dtStart' );
		$dtEnd      = $this->input->post( 'dtEnd' );
		$szIndustry = $this->input->post( 'szIndustry' );
		$szTestType = $this->input->post( 'szTestType' );
		$this->session->set_userdata( 'dtStart', $dtStart );
		$this->session->set_userdata( 'dtEnd', $dtEnd );
		$this->session->set_userdata( 'szIndustry', $szIndustry );
		$this->session->set_userdata( 'szTestType', $szTestType );
		echo "SUCCESS||||";
		echo "viewIndustryChart";
	}
	public function viewIndustryChart() { // something
		$count         = $this->Admin_Model->getnotification();
		$is_user_login = is_user_login( $this );
		// redirect to dashboard if already logged in
		if ( ! $is_user_login ) {
			ob_end_clean();
			redirect( base_url( '/admin/admin_login' ) );
			die;
		}
		$searchArray['dtStart']    = $this->session->userdata( 'dtStart' );
		$searchArray['dtEnd']      = $this->session->userdata( 'dtEnd' );
		$searchArray['szIndustry'] = $this->session->userdata( 'szIndustry' );
		$searchArray['szTestType'] = $this->session->userdata( 'szTestType' );
		$getSosAndClientDetils     = $this->Reporting_Model->getSosAndClientDetils( $searchArray );
		$data['szMetaTagTitle']        = "Industry Report Chart";
		$data['is_user_login']         = $is_user_login;
		$data['pageName']              = "Reporting";
		$data['subpageName']           = "industry_report";
		$data['getSosAndClientDetils'] = $getSosAndClientDetils;
		$data['szTestType']            = $searchArray['szTestType'];
		$data['arErrorMessages']       = $this->Reporting_Model->arErrorMessages;
		$this->load->view( 'layout/admin_header', $data );
		$this->load->view( 'reporting/viewIndustryReportChart.php' );
		$this->load->view( 'layout/admin_footer', $data );
	}
	function comparisonReportChart() {
		$siteid      = $this->input->post( 'siteid' );
		$testtype    = $this->input->post( 'testtype' );
		$comparetype = $this->input->post( 'comparetype' );
		$this->session->set_userdata( 'siteid', $siteid );
		$this->session->set_userdata( 'testtype', $testtype );
		$this->session->set_userdata( 'comparetype', $comparetype );
		echo "SUCCESS||||";
		echo "comparisonReportOfChart";
	}
	public function comparisonReportOfChart() {
		$is_user_login = is_user_login( $this );
		// redirect to dashboard if already logged in
		if ( ! $is_user_login ) {
			ob_end_clean();
			redirect( base_url( '/admin/admin_login' ) );
			die;
		}
		$siteid           = $this->session->userdata( 'siteid' );
		$testtype         = $this->session->userdata( 'testtype' );
		$comparetype      = $this->session->userdata( 'comparetype' );
		$compareresultarr = $this->Reporting_Model->getcomparisonrecord( $siteid, $testtype, $comparetype );
		$userdataarr      = $this->Webservices_Model->getfranchiseeclientsitebysiteid( $siteid );
		$data['szMetaTagTitle']   = "Client Comparison Chart";
		$data['is_user_login']    = $is_user_login;
		$data['pageName']         = "Reporting";
		$data['subpageName']      = "Client_Comparison_Report";
		$data['notification']     = $count;
		$data['compareresultarr'] = $compareresultarr;
		$data['data']             = $data;
		$data['err']              = false;
		$data['userdataarr']      = $userdataarr;
		$data['testtype']         = $testtype;
		$data['comparetype']      = $comparetype;
		$data['arErrorMessages']  = $this->Reporting_Model->arErrorMessages;
		$this->load->view( 'layout/admin_header', $data );
		$this->load->view( 'reporting/clientCmpChart' );
		$this->load->view( 'layout/admin_footer' );
	}
	function revenueGenerateOfChart() {
		$dtStart      = $this->input->post( 'dtStart' );
		$dtEnd        = $this->input->post( 'dtEnd' );
		$szFranchisee = $this->input->post( 'szFranchisee' );
		$this->session->set_userdata( 'dtStart', $dtStart );
		$this->session->set_userdata( 'dtEnd', $dtEnd );
		$this->session->set_userdata( 'szFranchisee', $szFranchisee );
		echo "SUCCESS||||";
		echo "revenueGenerateChart";
	}
	public function revenueGenerateChart() {
		$is_user_login = is_user_login( $this );
		// redirect to dashboard if already logged in
		if ( ! $is_user_login ) {
			ob_end_clean();
			redirect( base_url( '/admin/admin_login' ) );
			die;
		}
		$searchAry['dtStart']      = $this->session->userdata( 'dtStart' );
		$searchAry['dtEnd']        = $this->session->userdata( 'dtEnd' );
		$searchAry['szFranchisee'] = $this->session->userdata( 'szFranchisee' );
		$searchAry['dtStart']                = $this->session->userdata( 'dtStart' );
		$searchAry['dtEnd']                  = $this->session->userdata( 'dtEnd' );
		$searchAry['szFranchisee']           = $this->session->userdata( 'szFranchisee' );
		$getManualCalcStartToEndDate         = $this->Reporting_Model->getAllRevenueManualalc( $searchAry, $searchAry['szFranchisee'] );
		$data['getManualCalcStartToEndDate'] = $getManualCalcStartToEndDate;
		$data['szMetaTagTitle']              = "Revenue Generate Chart";
		$data['is_user_login']               = $is_user_login;
		$data['pageName']                    = "Reporting";
		$data['subpageName']                 = "revenue_generate";
		$data['notification']                = $count;
		$data['data']                        = $data;
		$data['szFranchisee']                = $searchAry['szFranchisee'];
		$data['allfranchisee']               = $searchOptionArr;
		$data['arErrorMessages']             = $this->Order_Model->arErrorMessages;
		//$data['drugtestkitlist'] = $drugTestKitListAray;
		$this->load->view( 'layout/admin_header', $data );
		$this->load->view( 'reporting/viewRevenueGenerateChart' );
		$this->load->view( 'layout/admin_footer' );
	}
	public function view_fr_stock_qty_report() {
		$is_user_login = is_user_login( $this );
		// redirect to dashboard if already logged in
		if ( ! $is_user_login ) {
			ob_end_clean();
			redirect( base_url( '/admin/admin_login' ) );
			die;
		}
		$count          = $this->Admin_Model->getnotification();
		$franchiseeName = $_POST['szSearch1'];
		$catid          = $_POST['szSearch2'];
		$viewFranchiseeInventoryListAry = $this->Reporting_Model->viewFranchiseeInventoryList( $franchiseeName, $catid );
		$this->load->library( 'form_validation' );
		$this->form_validation->set_rules( 'szSearch2', 'Product Category', 'required' );
		$this->form_validation->set_message( 'required', '{field} is required.' );
		if ( $this->form_validation->run() == false ) {
			$data['szMetaTagTitle']  = "Franchisee Stock Qty Report";
			$data['is_user_login']   = $is_user_login;
			$data['pageName']        = "Reporting";
			$data['subpageName']     = "fr_stock_qty_report";
			$data['notification']    = $count;
			$data['data']            = $data;
			$data['arErrorMessages'] = $this->Order_Model->arErrorMessages;
			$this->load->view( 'layout/admin_header', $data );
			$this->load->view( 'reporting/franchisee_stock_qty' );
			$this->load->view( 'layout/admin_footer' );
		} else {
			$data['viewFranchiseeInventoryListAry'] = $viewFranchiseeInventoryListAry;
			$data['szMetaTagTitle']                 = "Franchisee Stock Qty Report";
			$data['is_user_login']                  = $is_user_login;
			$data['pageName']                       = "Reporting";
			$data['subpageName']                    = "fr_stock_qty_report";
			$data['notification']                   = $count;
			$data['data']                           = $data;
			$data['arErrorMessages']                = $this->Order_Model->arErrorMessages;
			$this->load->view( 'layout/admin_header', $data );
			$this->load->view( 'reporting/franchisee_stock_qty' );
			$this->load->view( 'layout/admin_footer' );
		}
	}
	function ViewpdfFrStockQtyReportData() {
		$prodCategory   = $this->input->post( 'prodCategory' );
		$franchiseeName = $this->input->post( 'franchiseeName' );
		$this->session->set_userdata( 'franchiseeName', $franchiseeName );
		$this->session->set_userdata( 'prodCategory', $prodCategory );
		echo "SUCCESS||||";
		echo "ViewpdfFrStockQtyReport";
	}
	public function ViewpdfFrStockQtyReport() {
		ob_start();
		$this->load->library( 'Pdf' );
		$pdf = new Pdf( 'P', 'mm', 'A4', true, 'UTF-8', false );
		$pdf->SetCreator( PDF_CREATOR );
		$pdf->SetTitle( 'Drug-safe fr stock qty report' );
		$pdf->SetAuthor( 'Drug-safe' );
		$pdf->SetSubject( 'Fr Stock Qty Report PDF' );
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
		$pdf->AddPage( 'L' );
		$franchiseeName = $this->session->userdata( 'franchiseeName' );
		$prodCategory   = $this->session->userdata( 'prodCategory' );
		$viewFranchiseeInventoryListAry = $this->Reporting_Model->viewFranchiseeInventoryList( $franchiseeName, $prodCategory );
		$html = '<a style="text-align:center;  margin-bottom:5px;" href="' . __BASE_URL__ . '" ><img style="width:145px" src="' . __BASE_URL__ . '/images/logo.png" alt="logo" class="logo-default" /> </a>
            <div><p style="text-align:center; font-size:18px; margin-bottom:5px; color:black"><b>Franchisee Stock Quantity Report</b></p></div>
           
            <div class= "table-responsive" >
                            <table border="1" cellpadding="5">
                                    <tr>
                                        <th> <b>Product Code </b> </th>
                                        <th><b> Description  </b> </th>
                                        <th><b>  Franchisee Name </b></th>
                                        <th><b>  State</b> </th>
                                        <th> <b>Available Stock Quantity</b> </th>
                                       
                                   
                                    </tr>';
		if ( $viewFranchiseeInventoryListAry ) {
			$i = 0;
			foreach ( $viewFranchiseeInventoryListAry as $viewFranchiseeInventoryData ) {
                             $franchiseeArr = $this->Admin_Model->getAdminDetailsByEmailOrId( '', $viewFranchiseeInventoryData['iFranchiseeId'] );
                             $getState = $this->Franchisee_Model->getStateByFranchiseeId($viewFranchiseeInventoryData['iFranchiseeId']);
                                                
				$html .= '<tr>
                                            <td> ' . $viewFranchiseeInventoryData['szProductCode'] . '</td>
                                            <td> ' . $viewFranchiseeInventoryData['szProductDiscription'] . ' </td>
                                            <td> ' . $franchiseeArr['szName'] . '</td>
                                            <td> ' . $getState['name'] . ' </td>  
                                            <td>' . $viewFranchiseeInventoryData['szQuantity'] . ' </td>';
				$html .= '</tr>';
			}
			$i ++;
		}
		$html .= '
                            </table>
                        </div>
                      
                        ';
		$pdf->writeHTML( $html, true, false, true, false, '' );
//    $pdf->Write(5, 'CodeIgniter TCPDF Integration');
		error_reporting( E_ALL );
		$pdf->Output( 'stock-request-report.pdf', 'I' );
	}
	function ViewExcelFrStockQtyReportData() {
		$prodCategory   = $this->input->post( 'prodCategory' );
		$franchiseeName = $this->input->post( 'franchiseeName' );
		$this->session->set_userdata( 'franchiseeName', $franchiseeName );
		$this->session->set_userdata( 'prodCategory', $prodCategory );
		echo "SUCCESS||||";
		echo "ViewExcelFrStockQtyReportReport";
	}
	public function ViewExcelFrStockQtyReportReport() {
		$this->load->library( 'excel' );
		$filename = 'Report';
		$title    = 'Drug-safe fr stock qty report';
		$file     = $filename . '-' . $title; //save our workbook as this file name
		$this->excel->setActiveSheetIndex( 0 );
		$this->excel->getActiveSheet()->setTitle( $filename );
		$this->excel->getActiveSheet()->setCellValue( 'B1', 'Franchisee Stock Quantity Report' );
		$this->excel->getActiveSheet()->getStyle( 'B1' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'B1' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'B1' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'A3', 'Product Code' );
		$this->excel->getActiveSheet()->getStyle( 'A3' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'A3' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'A3' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'B3', 'Description' );
		$this->excel->getActiveSheet()->getStyle( 'B3' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'B3' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'B3' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'C3', 'Franchisee Name' );
		$this->excel->getActiveSheet()->getStyle( 'C3' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'C3' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'C3' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
                $this->excel->getActiveSheet()->setCellValue( 'D3', 'State' );
		$this->excel->getActiveSheet()->getStyle( 'D3' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'D3' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'D3' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
                $this->excel->getActiveSheet()->setCellValue( 'E3', 'Available Stock Quantity' );
		$this->excel->getActiveSheet()->getStyle( 'E3' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'E3' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'E3' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$franchiseeName = $this->session->userdata( 'franchiseeName' );
		$prodCategory   = $this->session->userdata( 'prodCategory' );
		$viewFranchiseeInventoryListAry = $this->Reporting_Model->viewFranchiseeInventoryList( $franchiseeName, $prodCategory );
		
		if ( ! empty( $viewFranchiseeInventoryListAry ) ) {
			$i = 4;
			$x = 0;
			foreach ( $viewFranchiseeInventoryListAry as $item ) {
                         $franchiseeArr = $this->Admin_Model->getAdminDetailsByEmailOrId( '', $item['iFranchiseeId'] );
                             $getState = $this->Franchisee_Model->getStateByFranchiseeId($item['iFranchiseeId']);
                              
				$x ++;
				$this->excel->getActiveSheet()->setCellValue( 'A' . $i, $item['szProductCode'] );
				$this->excel->getActiveSheet()->setCellValue( 'B' . $i, $item['szProductDiscription'] );
                                $this->excel->getActiveSheet()->setCellValue( 'C' . $i, $franchiseeArr['szName'] );
                                $this->excel->getActiveSheet()->setCellValue( 'D' . $i, $getState['name'] );
				$this->excel->getActiveSheet()->setCellValue( 'E' . $i, $item['szQuantity'] );
				$this->excel->getActiveSheet()->getColumnDimension( 'A' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'B' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'C' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'D' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'E' )->setAutoSize( true );
				$i ++;
			}
		}
		header( 'Content-Type: application/vnd.ms-excel' ); //mime type
		header( 'Content-Disposition: attachment;filename="' . $file . '"' ); //tell browser what's the file name
		header( 'Cache-Control: max-age=0' ); //no cache
//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
//if you want to save it as .XLSX Excel 2007 format
		$objWriter = PHPExcel_IOFactory::createWriter( $this->excel, 'Excel5' );
		$this->session->unset_userdata( 'franchiseeName' );
		$this->session->unset_userdata( 'prodCategory' );
//force user to download the Excel file without writing it to server's HD
		$objWriter->save( 'php://output' );
	}
	function ViewExcelClientReportData() {
		$frId     = $this->input->post( 'frId' );
		$clName   = $this->input->post( 'clName' );
		$fromDate = $this->input->post( 'fromDate' );
		$toDate   = $this->input->post( 'toDate' );
		$this->session->set_userdata( 'fromDate', $fromDate );
		$this->session->set_userdata( 'toDate', $toDate );
		$this->session->set_userdata( 'frId', $frId );
		$this->session->set_userdata( 'clName', $clName );
		echo "SUCCESS||||";
		echo "ViewExcelClientReport";
	}
	public function ViewExcelClientReport() {
		$this->load->library( 'excel' );
		$filename = 'Report';
		$title    = 'Client Details Report';
		$file     = $filename . '-' . $title; //save our workbook as this file name
		$this->excel->setActiveSheetIndex( 0 );
		$this->excel->getActiveSheet()->setTitle( $filename );
                $this->excel->getActiveSheet()->setCellValue( 'A1', 'Franchisee Name:' );
		$this->excel->getActiveSheet()->getStyle( 'A1' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'A1' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'A1' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
                $this->excel->getActiveSheet()->setCellValue( 'A3', 'Business Name' );
		$this->excel->getActiveSheet()->getStyle( 'A3' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'A3' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'A3' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		
		$this->excel->getActiveSheet()->setCellValue( 'B3', 'ABN' );
		$this->excel->getActiveSheet()->getStyle( 'B3' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'B3' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'B3' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'C3', 'Contact Name' );
		$this->excel->getActiveSheet()->getStyle( 'C3' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'C3' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'C3' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'D3', 'Primary Email' );
		$this->excel->getActiveSheet()->getStyle( 'D3' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'D3' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'D3' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'E3', 'Primary Phone' );
		$this->excel->getActiveSheet()->getStyle( 'E3' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'E3' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'E3' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'F3', 'No Of Sites' );
		$this->excel->getActiveSheet()->getStyle( 'F3' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'F3' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'F3' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'G3', 'Industry' );
		$this->excel->getActiveSheet()->getStyle( 'G3' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'G3' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'G3' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'H3', 'Discount' );
		$this->excel->getActiveSheet()->getStyle( 'H3' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'H3' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'H3' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'I3', 'Contact Email' );
		$this->excel->getActiveSheet()->getStyle( 'I3' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'I3' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'I3' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'J3', 'Contact Phone' );
		$this->excel->getActiveSheet()->getStyle( 'J3' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'J3' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'J3' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'K3', 'Contact Mobile' );
		$this->excel->getActiveSheet()->getStyle( 'K3' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'K3' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'K3' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'L3', 'Address' );
		$this->excel->getActiveSheet()->getStyle( 'L3' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'L3' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'L3' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'M3', 'Country' );
		$this->excel->getActiveSheet()->getStyle( 'M3' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'M3' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'M3' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'N3', 'State' );
		$this->excel->getActiveSheet()->getStyle( 'N3' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'N3' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'N3' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'O3', 'Region Name' );
		$this->excel->getActiveSheet()->getStyle( 'O3' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'O3' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'O3' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'P3', 'City' );
		$this->excel->getActiveSheet()->getStyle( 'P3' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'P3' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'P3' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'Q3', 'Zip Code' );
		$this->excel->getActiveSheet()->getStyle( 'Q3' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'Q3' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'Q3' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
              
		$frId         = $this->session->userdata( 'frId' );
		$clName       = $this->session->userdata( 'clName' );
		$fromDate     = $this->session->userdata( 'fromDate' );
		$toDate       = $this->session->userdata( 'toDate' );
		$fromdateData = $this->Webservices_Model->formatdate( $fromDate );
		$todateData   = $this->Webservices_Model->formatdate( $toDate );
		if ( ( $_SESSION['drugsafe_user']['iRole'] == 1 ) || ( $_SESSION['drugsafe_user']['iRole'] == 5 ) ) {
			if ( ! empty( $frId ) ) {
				$frId = $this->session->userdata( 'frId' );
			} else {
				$frId = $this->session->userdata( 'idFr' );
			}
		}
		$AssignCorpuserDetailsArr = $this->Webservices_Model->getcorpclientdetails( $frId );
		$AllclientAry             = $this->Franchisee_Model->getAllClientDetails( true, $frId, $clName, false, false, $fromdateData, $todateData );
		$CorpuserDetailsArr       = array();
		if ( ! empty( $AssignCorpuserDetailsArr ) ) {
			foreach ( $AssignCorpuserDetailsArr as $assignCorpUser ) {
				$CorpuserDetailsArr = $this->Webservices_Model->getclientdetails( $assignCorpUser['corpfrid'], 0, 0, 0, $fromdateData, $todateData );
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
			if ( ( $clName == $CorpclientData['szName'] ) ) {
				$clientAray = array_merge( $AllclientAry, $CorpuserDetailsArr );
			} else {
				$clientAray = $AllclientAry;
			}
		} elseif ( ! empty( $AllclientAry ) ) {
			$clientAray = $AllclientAry;
		} elseif ( ! empty( $CorpuserDetailsArr ) ) {
			$clientAray = $CorpuserDetailsArr;
		}
		if ( ( $_SESSION['drugsafe_user']['iRole'] == 2 ) ) {
			$frId = $_SESSION['drugsafe_user']['id'];
		}
                $franchiseeArr = $this->Admin_Model->getAdminDetailsByEmailOrId( '', $clientAray['0']['franchiseeId'] );
                $this->excel->getActiveSheet()->setCellValue( 'B1', $franchiseeArr['szName'] );
		if ( ! empty( $clientAray ) ) {
			$i = 4;
			foreach ( $clientAray as $item ) {
				if ( $item['regionId'] == 0 ) {
					$getState      = $this->Franchisee_Model->getStateByFranchiseeId( $item['franchiseeId'] );
					$franchiseeArr = $this->Admin_Model->getAdminDetailsByEmailOrId( '', $item['franchiseeId'] );
					$regionId      = $franchiseeArr['regionId'];
				} else {
					$getState = $this->Franchisee_Model->getStateByFranchiseeId( $item['id'] );
					$regionId = $clientData['regionId'];
				}
				$getRegionName               = $this->Admin_Model->getregionbyregionid( $regionId );
				$discount                    = $this->Franchisee_Model->getDiscountByDisId( $item['discountid'] );
				$countChildClientDetailsAray = $this->Franchisee_Model->viewChildClientDetails( $item['id'], false, false );
				$count                       = '0';
				if ( $countChildClientDetailsAray ) {
					$count = count( $countChildClientDetailsAray );
				}
				if ( $item['industry'] == 1 ) {
					$value = 'Agriculture, Forestry and Fishing';
				}
				if ( $item['industry'] == 2 ) {
					$value = 'Mining';
				}
				if ( $item['industry'] == 3 ) {
					$value = 'Manufacturing';
				}
				if ( $item['industry'] == 4 ) {
					$value = 'Electricity, Gas and Water Supply';
				}
				if ( $item['industry'] == 5 ) {
					$value = 'Construction';
				}
				if ( $item['industry'] == 6 ) {
					$value = 'Wholesale Trade';
				}
				if ( $item['industry'] == 7 ) {
					$value = 'Transport and Storage';
				}
				if ( $item['industry'] == 8 ) {
					$value = 'Communication Services';
				}
				if ( $item['industry'] == 9 ) {
					$value = 'Agriculture, Property and Business Services';
				}
				if ( $item['industry'] == 10 ) {
					$value = 'Agriculture, Government Administration and Defence';
				}
				if ( $item['industry'] == 11 ) {
					$value = 'Education';
				}
				if ( $item['industry'] == 12 ) {
					$value = 'Health and Community Services';
				}
				if ( $item['industry'] == 13 ) {
					$value = 'Other';
				}
				if ( ! empty( $discount['percentage'] ) ) {
					$discount = $discount['percentage'].'%';
				} else {
					$discount = "N/A";
				}
				$this->excel->getActiveSheet()->setCellValue( 'A' . $i, $item['szBusinessName'] );
				$this->excel->getActiveSheet()->setCellValue( 'B' . $i, $item['abn'] );
				$this->excel->getActiveSheet()->setCellValue( 'C' . $i, $item['szName'] );
				$this->excel->getActiveSheet()->setCellValue( 'D' . $i, $item['szEmail'] );
				$this->excel->getActiveSheet()->setCellValue( 'E' . $i, $item['szContactNumber'] );
				$this->excel->getActiveSheet()->setCellValue( 'F' . $i, $count );
				$this->excel->getActiveSheet()->setCellValue( 'G' . $i, $value );
				$this->excel->getActiveSheet()->setCellValue( 'H' . $i, $discount );
				$this->excel->getActiveSheet()->setCellValue( 'I' . $i, $item['szContactEmail'] );
				$this->excel->getActiveSheet()->setCellValue( 'J' . $i, $item['szContactPhone'] );
				$this->excel->getActiveSheet()->setCellValue( 'K' . $i, $item['szContactMobile'] );
				$this->excel->getActiveSheet()->setCellValue( 'L' . $i, $item['szAddress'] );
				$this->excel->getActiveSheet()->setCellValue( 'M' . $i, $item['szCountry'] );
				$this->excel->getActiveSheet()->setCellValue( 'N' . $i, $getState['name'] );
				$this->excel->getActiveSheet()->setCellValue( 'O' . $i, $getRegionName['regionName'] );
				$this->excel->getActiveSheet()->setCellValue( 'P' . $i, $item['szCity'] );
				$this->excel->getActiveSheet()->setCellValue( 'Q' . $i, $item['szZipCode'] );
				$this->excel->getActiveSheet()->getColumnDimension( 'A' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'B' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'C' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'D' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'E' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'F' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'G' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'H' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'I' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'J' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'K' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'L' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'M' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'N' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'O' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'P' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'Q' )->setAutoSize( true );
				$i ++;
			}
		}
		header( 'Content-Type: application/vnd.ms-excel' ); //mime type
		header( 'Content-Disposition: attachment;filename="' . $file . '"' ); //tell browser what's the file name
		header( 'Cache-Control: max-age=0' ); //no cache
//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
//if you want to save it as .XLSX Excel 2007 format
		$objWriter = PHPExcel_IOFactory::createWriter( $this->excel, 'Excel5' );
//force user to download the Excel file without writing it to server's HD
		$objWriter->save( 'php://output' );
	}
	function ViewPdfClientReportData() {
		$frId     = $this->input->post( 'frId' );
		$clName   = $this->input->post( 'clName' );
		$fromDate = $this->input->post( 'fromDate' );
		$toDate   = $this->input->post( 'toDate' );
		$this->session->set_userdata( 'fromDate', $fromDate );
		$this->session->set_userdata( 'toDate', $toDate );
		$this->session->set_userdata( 'frId', $frId );
		$this->session->set_userdata( 'clName', $clName );
		echo "SUCCESS||||";
		echo "ViewPdfClientReport";
	}
	public function ViewPdfClientReport() {
		ob_start();
		$this->load->library( 'Pdf' );
		$pdf = new Pdf( 'P', 'mm', 'A4', true, 'UTF-8', false );
		$pdf->SetCreator( PDF_CREATOR );
		$pdf->SetTitle( 'Drug-safe client details report' );
		$pdf->SetAuthor( 'Drug-safe' );
		$pdf->SetSubject( 'Client Details Report PDF' );
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
		$pdf->AddPage( 'L' );
		$frId         = $this->session->userdata( 'frId' );
		$clName       = $this->session->userdata( 'clName' );
		$fromDate     = $this->session->userdata( 'fromDate' );
		$toDate       = $this->session->userdata( 'toDate' );
		$fromdateData = $this->Webservices_Model->formatdate( $fromDate );
		$todateData   = $this->Webservices_Model->formatdate( $toDate );
		if ( ( $_SESSION['drugsafe_user']['iRole'] == 1 ) || ( $_SESSION['drugsafe_user']['iRole'] == 5 ) ) {
			if ( ! empty( $frId ) ) {
				$frId = $this->session->userdata( 'frId' );
			} else {
				$frId = $this->session->userdata( 'idFr' );
			}
		}
		$AssignCorpuserDetailsArr = $this->Webservices_Model->getcorpclientdetails( $frId );
		$AllclientAry             = $this->Franchisee_Model->getAllClientDetails( true, $frId, $clName, false, false, $fromdateData, $todateData );
		$CorpuserDetailsArr       = array();
		if ( ! empty( $AssignCorpuserDetailsArr ) ) {
			foreach ( $AssignCorpuserDetailsArr as $assignCorpUser ) {
				$CorpuserDetailsArr = $this->Webservices_Model->getclientdetails( $assignCorpUser['corpfrid'], 0, 0, 0, $fromdateData, $todateData );
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
			if ( ( $clName == $CorpclientData['szName'] ) ) {
				$clientAray = array_merge( $AllclientAry, $CorpuserDetailsArr );
			} else {
				$clientAray = $AllclientAry;
			}
		} elseif ( ! empty( $AllclientAry ) ) {
			$clientAray = $AllclientAry;
		} elseif ( ! empty( $CorpuserDetailsArr ) ) {
			$clientAray = $CorpuserDetailsArr;
		}
		if ( ( $_SESSION['drugsafe_user']['iRole'] == 2 ) ) {
			$frId = $_SESSION['drugsafe_user']['id'];
		}
$franchiseeArr = $this->Admin_Model->getAdminDetailsByEmailOrId( '', $clientAray['0']['franchiseeId'] );
		$html = '<a style="text-align:center;  margin-bottom:5px;" href="' . __BASE_URL__ . '" ><img style="width:145px" src="' . __BASE_URL__ . '/images/logo.png" alt="logo" class="logo-default" /> </a>
            <div><p style="text-align:center; font-size:18px; margin-bottom:5px; color:black"><b>Client Details Report</b></p></div>
          <p style="text-align:left; font-size:18px; margin-bottom:5px; color:black"><b>  Franchisee Name:</b> '.$franchiseeArr['szName'].' </p>     
<div class= "table-responsive" >
                            
                                  ';
		if ( $clientAray ) {
			$i = 0;
			foreach ( $clientAray as $clientData ) {
				if ( $clientData['industry'] == 1 ) {
					$value = 'Agriculture, Forestry and Fishing';
				}
				if ( $clientData['industry'] == 2 ) {
					$value = 'Mining';
				}
				if ( $clientData['industry'] == 3 ) {
					$value = 'Manufacturing';
				}
				if ( $clientData['industry'] == 4 ) {
					$value = 'Electricity, Gas and Water Supply';
				}
				if ( $clientData['industry'] == 5 ) {
					$value = 'Construction';
				}
				if ( $clientData['industry'] == 6 ) {
					$value = 'Wholesale Trade';
				}
				if ( $clientData['industry'] == 7 ) {
					$value = 'Transport and Storage';
				}
				if ( $clientData['industry'] == 8 ) {
					$value = 'Communication Services';
				}
				if ( $clientData['industry'] == 9 ) {
					$value = 'Agriculture, Property and Business Services';
				}
				if ( $clientData['industry'] == 10 ) {
					$value = 'Agriculture, Government Administration and Defence';
				}
				if ( $clientData['industry'] == 11 ) {
					$value = 'Education';
				}
				if ( $clientData['industry'] == 12 ) {
					$value = 'Health and Community Services';
				}
				if ( $clientData['industry'] == 13 ) {
					$value = 'Other';
				}
				$discount = $this->Franchisee_Model->getDiscountByDisId( $clientData['discountid'] );
				if ( $clientData['regionId'] == 0 ) {
					$getState      = $this->Franchisee_Model->getStateByFranchiseeId( $clientData['franchiseeId'] );
					$franchiseeArr = $this->Admin_Model->getAdminDetailsByEmailOrId( '', $clientData['franchiseeId'] );
					$regionId      = $franchiseeArr['regionId'];
				} else {
					$getState = $this->Franchisee_Model->getStateByFranchiseeId( $clientData['id'] );
					$regionId = $clientData['regionId'];
				}
				$getRegionName               = $this->Admin_Model->getregionbyregionid( $regionId );
				$countChildClientDetailsAray = $this->Franchisee_Model->viewChildClientDetails( $clientData['id'], false, false );
				$count                       = '0';
				if ( $countChildClientDetailsAray ) {
					$count = count( $countChildClientDetailsAray );
				}
				$html .= '  
              <table border="1" cellpadding="5"><tr nobr="true">
                                        <td ><b>Business Name</b> </td>
                                        <td> <b>ABN</b> </td>
                                        <td colspan="2"><b>Primary Email</b> </td>
                                        <td><b>Primary Phone</b></td>
                                        <td><b>No Of Sites</b> </td>
                                        <td> <b>Industry</b> </td>
                                        <td> <b>Discount</b> </td>
                                        <td><b>Contact Name</b> </td>
                                          <td ><b>Contact Phone</b> </td>
                                        <br>
                                        </tr>
                                        <tr nobr="true">
                                          <td>' . $clientData['szBusinessName'] . ' </td>
                                            <td> ' . $clientData['abn'] . '</td>
                                            <td colspan="2">' . $clientData['szEmail'] . ' </td>
                                            <td>' . $clientData['szContactNumber'] . ' </td>
                                            <td> ' . $count . '</td>
                                            <td> ' . $value . ' </td>
                                            <td>' . ( ! empty( $discount['percentage'] ) ? $discount['percentage']."%": 'N/A' ) . ' </td> 
                                            <td> ' . $clientData['szName'] . '</td>
                                            <td>' . $clientData['szContactPhone'] . ' </td>
                                        </tr>
                                      <tr nobr="true">
                                          
                                        <td> <b>Contact Mobile</b> </td>
                                        <td colspan="2"> <b>Contact Email</b> </td>
                                        <td colspan="2"> <b>Address</b> </td>
                                        <td><b>Country</b> </td>
                                        <td> <b>State</b> </td>
                                        <td><b>Region Name</b> </td>
                                        <td> <b>City</b> </td>
                                        <td><b>Zip/Postal Code</b> </td>
                                        <br>
                                        </tr>
                                         <tr nobr="true">
                                          
                                            <td> ' . $clientData['szContactMobile'] . '</td>
                                            <td colspan="2"> ' . $clientData['szContactEmail'] . '</td>
                                            <td colspan="2"> ' . $clientData['szAddress'] . ' </td>
                                            <td>' . $clientData['szCountry'] . ' </td>
                                            <td> ' . $getState['name'] . '</td>
                                            <td> ' . $getRegionName['regionName'] . '</td>
                                            <td>' . $clientData['szCity'] . ' </td> 
                                            <td> ' . $clientData['szZipCode'] . '</td>
                                        </tr></table>
                                         <br><br>
                                   ';
				$i ++;
			}
		}
		$html .= '
                            
                        </div>
                      
                        ';
		$pdf->writeHTML( $html, true, false, true, false, '' );
//    $pdf->Write(5, 'CodeIgniter TCPDF Integration');
		error_reporting( E_ALL );
		$this->session->unset_userdata( 'frId' );
		$this->session->unset_userdata( 'fromDate' );
		$this->session->unset_userdata( 'toDate' );
		$this->session->unset_userdata( 'clName' );
		ob_end_clean();
		$pdf->Output( 'client-details-report.pdf', 'I' );
	}
	function ViewPdfSiteReportData() {
		$siteName     = $this->input->post( 'siteName' );
		$clientId     = $this->input->post( 'clientId' );
		$fromDate     = $this->input->post( 'fromDate' );
		$toDate       = $this->input->post( 'toDate' );
		$corpclient   = $this->input->post( 'corpclient' );
		$idfranchisee = $this->input->post( 'idfranchisee' );
		$this->session->set_userdata( 'clientId', $clientId );
		$this->session->set_userdata( 'idfranchisee', $idfranchisee );
		$this->session->set_userdata( 'fromDate', $fromDate );
		$this->session->set_userdata( 'toDate', $toDate );
		$this->session->set_userdata( 'corpclient', $corpclient );
		$this->session->set_userdata( 'siteName', $siteName );
		echo "SUCCESS||||";
		echo "ViewPdfSiteReport";
	}
	public function ViewPdfSiteReport() {
		ob_start();
		$this->load->library( 'Pdf' );
		$pdf = new Pdf( 'P', 'mm', 'A4', true, 'UTF-8', false );
		$pdf->SetCreator( PDF_CREATOR );
		$pdf->SetTitle( 'Drug-safe site details report' );
		$pdf->SetAuthor( 'Drug-safe' );
		$pdf->SetSubject( 'Site Details Report PDF' );
		$pdf->SetMargins( PDF_MARGIN_LEFT - 10, PDF_MARGIN_TOP-18, PDF_MARGIN_RIGHT - 10 );
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
		$pdf->AddPage( 'L' );
		$corpclient = $this->session->userdata( 'corpclient' );
		$siteId     = $this->session->userdata( 'siteName' );
		$idClient   = $this->session->userdata( 'clientId' );
		$fromDate   = $this->session->userdata( 'fromDate' );
		$toDate     = $this->session->userdata( 'toDate' );
		$fromdateData = $this->Webservices_Model->formatdate( $fromDate );
		$todateData   = $this->Webservices_Model->formatdate( $toDate );
		$clientDetailsAray      = $this->Franchisee_Model->viewClientDetails( $idClient );
		$franchiseId            = $clientDetailsAray['franchiseeId'];
		$idfranchisee           = $this->session->userdata( 'idfranchisee' );
		$childClientDetailsAray = $this->Franchisee_Model->viewChildClientDetails( $idClient, false, flase, $searchAry, $siteId, $idfranchisee, $fromdateData, $todateData );
		$clientFranchiseeArr    = $this->Franchisee_Model->getClientFranchisee( $idClient );
		//$sitesArr = $this->Franchisee_Model->viewChildClientDetails($idClient,0,0,'',0,$idfranchisee);
		$loggedinFranchisee = $idfranchisee;
		$clientDetsArr      = $this->Webservices_Model->getclientdetailsbyclientid( $idClient );
		if ( ! empty( $clientDetsArr ) ) {
			$franchiseeid = $clientDetsArr[0]['franchiseeId'];
		}
		if ( $franchiseeid != $_SESSION['drugsafe_user']['id'] ) {
			$addEditClientDet = false;
		}
		$sitesArr                 = array();
		$sitesArr                 = $this->Webservices_Model->getclientdetails( $franchiseeid, $idClient );
		$AssignCorpuserDetailsArr = $this->Webservices_Model->getcorpclientdetails( $loggedinFranchisee, $franchiseeid );
		if ( ! empty( $AssignCorpuserDetailsArr ) ) {
			$addEditClientDet = false;
			$sitesArr         = array();
			foreach ( $AssignCorpuserDetailsArr as $assignCorpUser ) {
				$CorpuserDetailsArr = $this->Webservices_Model->getclientdetails( $assignCorpUser['corpfrid'], $idClient, 0, $assignCorpUser['clientid'], $fromdateData, $todateData );
				$CorpuserSearchArr  = $this->Webservices_Model->getclientdetails( $assignCorpUser['corpfrid'], $idClient, 0, $assignCorpUser['clientid'] );
				if ( ! empty( $CorpuserDetailsArr ) ) {
					foreach ( $CorpuserDetailsArr as $CorpUser ) {
						array_push( $sitesArr, $CorpUser );
					}
				}
			}
		}
		if ( $clientDetailsAray['clientType'] > 0 ) {
			$parentClientDetArr    = $this->Admin_Model->getAdminDetailsByEmailOrId( '', $clientDetailsAray['clientType'] );
			$data['ParentOfChild'] = $parentClientDetArr;
		}
		if ( ! empty( $clientFranchiseeArr ) ) {
			$franchiseeDetArr      = $this->Admin_Model->getAdminDetailsByEmailOrId( '', $clientFranchiseeArr[0]['franchiseeId'] );
			$data['franchiseeArr'] = $franchiseeDetArr;
		}
		if ( $franchiseeDetArr['franchiseetype'] == 1 ) {
			$getState      = $this->Franchisee_Model->getStateByFranchiseeId( $idClient );
			$getRegionName = $this->Admin_Model->getregionbyregionid( $clientDetailsAray['regionId'] );
		} else {
			$getState      = $this->Franchisee_Model->getStateByFranchiseeId( $franchiseId );
			$getRegionName = $this->Admin_Model->getregionbyregionid( $franchiseeDetArr['regionId'] );
		}
		$clientAray = $this->Webservices_Model->getFranchiseeWithClient( $idClient, $idfranchisee );
		/*if(!empty($clientAray)){
            if(($clientAray[0]['szNoOfSites'] == 0) && $clientAray[0]['clientType'] == 0){
                $addEditClientDet = false;
            }
        }*/
		$userDetailsArr = array();
		if ( $corpclient == '1' ) {
			$loggedinFranchisee = $idfranchisee;
			$clientDetsArr      = $this->Webservices_Model->getclientdetailsbyclientid( $idClient, 0, 0, 0, $fromdateData, $todateData );
			if ( ! empty( $clientDetsArr ) ) {
				$idfranchisee = $clientDetsArr[0]['franchiseeId'];
			}
			$AssignCorpuserDetailsArr = $this->Webservices_Model->getcorpclientdetails( $loggedinFranchisee, $idfranchisee );
			if ( ! empty( $AssignCorpuserDetailsArr ) ) {
				$addEditClientDet = false;
				$userDetailsArr   = array();
				foreach ( $AssignCorpuserDetailsArr as $assignCorpUser ) {
					$CorpuserDetailsArr = $this->Webservices_Model->getclientdetails( $assignCorpUser['corpfrid'], $idClient, 0, $assignCorpUser['clientid'], $fromdateData, $todateData );
					if ( ! empty( $CorpuserDetailsArr ) ) {
						foreach ( $CorpuserDetailsArr as $CorpUser ) {
							array_push( $userDetailsArr, $CorpUser );
						}
					}
				}
			}
		}
		if ( $corpclient == '1' ) {
			$childClientDetailsAray = $userDetailsArr;
		} else {
			$childClientDetailsAray = $childClientDetailsAray;
		}
		if ( $childClientDetailsAray ) {
			$html = '<div class="wraper">
             <table cellpadding="5px">
             <tr>
             <td rowspan="4" align="left"><a style="text-align:center;  margin-bottom:15px;" href="' . __BASE_URL__ . '" ><img style="width:145px" src="' . __BASE_URL__ . '/images/logo.png" alt="logo" class="logo-default" /> </a></td>
             </tr>
             </table>
             <br />
             <h1 style="text-align: center;">Site Details Report</h1>';
			$i    = 0;
			foreach ( $childClientDetailsAray as $siteData ) {
				$showrec = true;
				if ( isset( $siteId ) && ! empty( $siteId ) && ( $siteId != $siteData['id'] ) ) {
					$showrec = false;
				}
				if ( $showrec ) {
					$userDataAry    = $this->Franchisee_Model->getSiteDetailsById( $siteData['id'] );
					$franchiseecode = $this->Franchisee_Model->getusercodebyuserid( $siteData['id'] );
					if ( $siteData['regionId'] == 0 ) {
						$getState      = $this->Franchisee_Model->getStateByFranchiseeId( $siteData['franchiseeId'] );
						$franchiseeArr = $this->Admin_Model->getAdminDetailsByEmailOrId( '', $siteData['franchiseeId'] );
						$regionId      = $franchiseeArr['regionId'];
					} else {
						$getState = $this->Franchisee_Model->getStateByFranchiseeId( $siteData['id'] );
					}
					$getRegionName = $this->Admin_Model->getregionbyregionid( $regionId );
					if ( $userDataAry['onsite_service'] == 0 ) {
						$onsite_service_val = "Mobile Clinic ";
					} else {
						$onsite_service_val = "In-house";
					}
					if ( $userDataAry['risk_assessment'] == 0 ) {
						$raVal = "Yes";
					} else {
						$raVal = "No";
					}
					if ( $userDataAry['power_access'] == 0 ) {
						$paVal = "Yes";
					} else {
						$paVal = "No";
					}
					if ( $userDataAry['req_comp_induction'] == 0 ) {
						$rciVal = "Yes";
					} else {
						$rciVal = "No";
					}
					if ( $userDataAry['randomisation'] == 0 ) {
						$rpVal = "Marble selection (% split)-not accurate";
					} elseif ( $userDataAry['randomisation'] == 1 ) {
						$rpVal = "Drugsafe given names then select via algorythm";
					} else {
						$rpVal = "Client does randomization";
					}
					if ( $userDataAry['paperwork'] == 0 ) {
						$pwVal = "Leave onsite with site contact";
					}
					if ( $userDataAry['paperwork'] == 1 ) {
						$pwVal = "Return to Drugsafe for filing";
					}
					if ( $userDataAry['paperwork'] == 2 ) {
						$pwVal = "Return to Drugsafe and and emailed to specific contact";
					}
					if ( $userDataAry['ongoing_testing_req'] == 0 ) {
						$ogVal = "Random";
					} else {
						$ogVal = "Blanket";
					}
					if ( $userDataAry['initial_testing_req'] == 0 ) {
						$itrval = "Random";
					} else {
						$itrval = "Blanket";
					}
                             $str = '';
                            $req_ppe_ary = explode(",", $userDataAry['req_ppe']);
                             if(in_array("1", $req_ppe_ary)){
                             $val = "High Vis Work Wear" ;
                             $str .= $val.',';
                             } 
                             if(in_array("2", $req_ppe_ary)){
                             $val = "Head Protection" ;
                             $str .= $val.',';
                             }
                              if(in_array("3", $req_ppe_ary)){
                               $val = "Face/Eye Protection" ;
                                $str .= $val.',';}
                               if(in_array("4", $req_ppe_ary)){
                               $val = "Safety Boots" ;
                                $str .= $val.',';}
                               if(in_array("5", $req_ppe_ary)){
                                $val = "Long Sleev Clothing" ;
                                $str .= $val.',';}
                                $str = substr($str, 0, -1);
                            
					$html .= '<br><br>
<table cellpadding="5px">
    <tr>
        <td width="50%" align="left" font-size="20"><b>Site Code:</b> ' . ( ! empty( $franchiseecode['userCode'] ) ? $franchiseecode['userCode'] : 'N/A' ) . '</td><td width="50%" align="left"><b>Name of Person Completing Form:</b> ' . $userDataAry['per_form_complete'] . '</td>
    </tr>
    <tr>
        <td width="50%" align="left" font-size="20"><b>Company Name:</b> ' . $siteData['szName'] . '</td><td width="50%" align="left"><b>Address:</b> ' . $siteData['szAddress'] . '</td>
    </tr>
    <tr>
        <td width="50%" align="left"><b>Company Email:</b> ' . $siteData['szEmail'] . '</td><td width="50%" align="left"><b>State:</b> ' . $getState['name'] . '</td>
    </tr>
    <tr>
        <td width="50%" align="left"><b>Company Phone Number:</b> ' . $siteData['szContactNumber'] . '</td><td width="50%" align="left"><b>Region Name:</b> ' . $getRegionName['regionName'] . '</td>
    </tr>
     <tr>
        <td width="50%" align="left"><b>City:</b> ' . $siteData['szCity'] . '</td><td width="50%" align="left"><b>Zip/Postal Code:</b> ' . $siteData['szZipCode'] . '</td>
    </tr>
    <tr>
        <td width="50%" align="left"><b>Country:</b> ' . $siteData['szCountry'] . '</td>
    </tr>
</table>
<h3 style="color:black" align="center">Contact Details</h3>
<h3 style="color:black" align="left">Responsible for Scheduling.</h3>
<table border="1px" cellpadding="5px">
    <tr>
        <td width="50%" align="left"><b>Contact Name:</b></td><td width="50%" align="right">' . $userDataAry['sp_name'] . '</td>
    </tr>
    <tr>
        <td width="50%" align="left"><b>Contact Phone Number:</b></td><td width="50%" align="right">' . $userDataAry['sp_mobile'] . '</td>
    </tr>
    <tr>
        <td width="50%" align="left"><b>Contact Email:</b></td><td width="50%" align="right">' . $userDataAry['sp_email'] . '</td>
    </tr>
</table>
<h3 style="color:black" align="left">Receive the confirmatory lab results.</h3>
<table border="1px" cellpadding="5px">
    <tr>
        <td width="50%" align="left"><b>Contact Name:</b></td><td width="50%" align="right">' . $userDataAry['rlr_name'] . '</td>
    </tr>
    <tr>
        <td width="50%" align="left"><b>Contact Phone Number:</b></td><td width="50%" align="right">' . $userDataAry['rlr_mobile'] . '</td>
    </tr>
    <tr>
        <td width="50%" align="left"><b>Contact Email:</b></td><td width="50%" align="right">' . $userDataAry['rlr_email'] . '</td>
    </tr>
</table>
<h3 style="color:black" align="left">Involved in Scheduling.</h3>
<table border="1px" cellpadding="5px">
    <tr>
        <td width="50%" align="left"><b>Contact Name:</b></td><td width="50%" align="right">' . $userDataAry['iis_name'] . '</td>
    </tr>
    <tr>
        <td width="50%" align="left"><b>Contact Phone Number:</b></td><td width="50%" align="right">' . $userDataAry['iis_mobile'] . '</td>
    </tr>
    <tr>
        <td width="50%" align="left"><b>Contact Email:</b></td><td width="50%" align="right">' . $userDataAry['iis_email'] . '</td>
    </tr>
</table>
<h3 style="color:black" align="left">Other people  receive the confirmatory lab results.</h3>
<table border="1px" cellpadding="5px">
    <tr>
        <td width="50%" align="left"><b>Contact Name:</b></td><td width="50%" align="right">' . $userDataAry['orlr_name'] . '</td>
    </tr>
    <tr>
        <td width="50%" align="left"><b>Contact Phone Number:</b></td><td width="50%" align="right">' . $userDataAry['orlr_mobile'] . '</td>
    </tr>
    <tr>
        <td width="50%" align="left"><b>Contact Email:</b></td><td width="50%" align="right">' . $userDataAry['orlr_email'] . '</td>
    </tr>
</table>'.($i==0?'<!--<br pagebreak="true" />-->':'').'<h3 style="color:black"align="center">ONSITE SCREENING INFORMATION</h3>
<h3 style="color:black" align="left">Primary Site Contact.</h3>
<table border="1px" cellpadding="5px">
    <tr>
        <td width="50%" align="left"><b>Contact Name:</b></td><td width="50%" align="right">' . $userDataAry['psc_name'] . '</td>
    </tr>
    <tr>
        <td width="50%" align="left"><b>Landline Phone Number:</b></td><td width="50%" align="right">' . $userDataAry['psc_phone'] . '</td>
    </tr>
    <tr>
        <td width="50%" align="left"><b>Mobile Phone Number:</b></td><td width="50%" align="right">' . $userDataAry['psc_mobile'] . '</td>
    </tr>
</table>
<h3 style="color:black" align="left">Secondary Site Contact.</h3>
<table border="1px" cellpadding="5px">
    <tr>
        <td width="50%" align="left"><b>Contact Name:</b></td><td width="50%" align="right">' . $userDataAry['ssc_name'] . '</td>
    </tr>
    <tr>
        <td width="50%" align="left"><b>Landline Phone Number:</b></td><td width="50%" align="right">' . $userDataAry['ssc_phone'] . '</td>
    </tr>
    <tr>
        <td width="50%" align="left"><b>Mobile Phone Number:</b></td><td width="50%" align="right">' . $userDataAry['ssc_mobile'] . '</td>
    </tr>
</table>
<br /><br />'.($i>0?'<!--<br pagebreak="true" />-->':'').'
<table cellpadding="5px">
    <tr>
        <td width="50%" align="left" font-size="20"><b>People on site:</b> ' . $userDataAry['site_people'] . '</td><td width="50%" align="left"><b>Initial Testing Requirements:</b> ' . $itrval . '</td>
    </tr>
    <tr>
        <td width="50%" align="left" font-size="20"><b>Test Count:</b> ' . $userDataAry['test_count'] . '</td><td width="50%" align="left"><b>Ongoing Testing Requirements:</b> ' . $ogVal . '</td>
    </tr>
    <tr>
        <td width="50%" align="left"><b>Type of service preferred on-site:</b> ' . $onsite_service_val . '</td><td width="50%" align="left"><b>No of times Drugsafe visit your site:</b> ' . $userDataAry['site_visit'] . '</td>
    </tr>
    <tr>
        <td width="50%" align="left"><b>Access to power for our Mobile:</b> ' . $paVal . '</td><td width="50%" align="left"><b>Preferred start time:</b> ' . $userDataAry['start_time'] . '</td>
    </tr>
     <tr>
        <td width="50%" align="left"><b>Our people required to complete an induction:</b> ' . $rciVal . '</td><td width="50%" align="left"><b>Risk assessment required:</b> ' . $raVal . '</td>
    </tr>
    <tr>
        <td width="50%" align="left"><b>Randomization process:</b> ' . $rpVal . '</td><td width="50%" align="left"><b>Required PPE :</b> ' .$str. '</td>
    </tr>
    <tr>
        <td width="50%" align="left"><b>Paperwork at the time of testing:</b> ' . $pwVal . '</td>
    </tr>
    <tr>
        <td width="50%" align="left"><b>Special instruction for Drugsafe staff:</b> ' . $userDataAry['instructions'] . '</td>
    </tr>
    
</table>
        </div> <hr style="margin: 25px;"><!--<br pagebreak="true" />-->';
					$i ++;
				}
			}
		}
		$pdf->writeHTML( $html, true, false, true, false, '' );
//      $pdf->Write(5, 'CodeIgniter TCPDF Integration');
		error_reporting( E_ALL );
		$this->session->unset_userdata( 'frId' );
		$this->session->unset_userdata( 'fromDate' );
		$this->session->unset_userdata( 'toDate' );
		$this->session->unset_userdata( 'clName' );
		ob_end_clean();
		$pdf->Output( 'client-details-report.pdf', 'I' );
	}
	function ViewExcelSiteReportData() {
		$siteName     = $this->input->post( 'siteName' );
		$clientId     = $this->input->post( 'clientId' );
		$fromDate     = $this->input->post( 'fromDate' );
		$toDate       = $this->input->post( 'toDate' );
		$corpclient   = $this->input->post( 'corpclient' );
		$idfranchisee = $this->input->post( 'idfranchisee' );
		$this->session->set_userdata( 'clientId', $clientId );
		$this->session->set_userdata( 'idfranchisee', $idfranchisee );
		$this->session->set_userdata( 'fromDate', $fromDate );
		$this->session->set_userdata( 'toDate', $toDate );
		$this->session->set_userdata( 'corpclient', $corpclient );
		$this->session->set_userdata( 'siteName', $siteName );
		echo "SUCCESS||||";
		echo "ViewExcelSiteReport";
	}
	public function ViewExcelSiteReport() {
		$this->load->library( 'excel' );
		$filename = 'Report';
		$title    = 'Site Details Report';
		$file     = $filename . '-' . $title; //save our workbook as this file name
		$this->excel->setActiveSheetIndex( 0 );
		$this->excel->getActiveSheet()->setTitle( $filename );
		$this->excel->getActiveSheet()->mergeCells('A1:K2');
		$this->excel->getActiveSheet()
		            ->getStyle('A1:K2')
					->applyFromArray(
						array(
							'fill' => array(
								'type' => PHPExcel_Style_Fill::FILL_SOLID,
								'color' => array('rgb' => '40e1c0')
							)
						)
					);
		$this->excel->getActiveSheet()->setCellValue( 'A1', 'Site Details' );
		$this->excel->getActiveSheet()->getStyle( 'A1' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'A1' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'A1' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->getStyle( 'A1' )->getAlignment()->setVertical( PHPExcel_Style_Alignment::VERTICAL_CENTER );
		$this->excel->getActiveSheet()->mergeCells('L1:W1');
		$this->excel->getActiveSheet()
		            ->getStyle('L1:W1')
		            ->applyFromArray(
			            array(
				            'fill' => array(
					            'type' => PHPExcel_Style_Fill::FILL_SOLID,
					            'color' => array('rgb' => '80C8FF')
				            )
			            )
		            );
		$this->excel->getActiveSheet()->setCellValue( 'L1', 'Contact Details' );
		$this->excel->getActiveSheet()->getStyle( 'L1' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'L1' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'L1' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->mergeCells('X1:AQ1');
		$this->excel->getActiveSheet()
		            ->getStyle('X1:AQ1')
		            ->applyFromArray(
			            array(
				            'fill' => array(
					            'type' => PHPExcel_Style_Fill::FILL_SOLID,
					            'color' => array('rgb' => 'F0F0F0')
				            )
			            )
		            );
		$this->excel->getActiveSheet()->setCellValue( 'X1', 'ONSITE SCREENING INFORMATION' );
		$this->excel->getActiveSheet()->getStyle( 'X1' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'X1' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'X1' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->mergeCells('L2:N2');
		$this->excel->getActiveSheet()
		            ->getStyle('L2:N2')
		            ->applyFromArray(
			            array(
				            'fill' => array(
					            'type' => PHPExcel_Style_Fill::FILL_SOLID,
					            'color' => array('rgb' => 'F69923')
				            )
			            )
		            );
		$this->excel->getActiveSheet()->setCellValue( 'L2', 'Responsible for Scheduling' );
		$this->excel->getActiveSheet()->getStyle( 'L2' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'L2' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'L2' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->mergeCells('O2:Q2');
		$this->excel->getActiveSheet()
		            ->getStyle('O2:Q2')
		            ->applyFromArray(
			            array(
				            'fill' => array(
					            'type' => PHPExcel_Style_Fill::FILL_SOLID,
					            'color' => array('rgb' => 'E5E6AD')
				            )
			            )
		            );
		$this->excel->getActiveSheet()->setCellValue( 'O2', 'Receive the confirmatory lab results' );
		$this->excel->getActiveSheet()->getStyle( 'O2' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'O2' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'O2' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->mergeCells('R2:T2');
		$this->excel->getActiveSheet()
		            ->getStyle('R2:T2')
		            ->applyFromArray(
			            array(
				            'fill' => array(
					            'type' => PHPExcel_Style_Fill::FILL_SOLID,
					            'color' => array('rgb' => 'E9ECF3')
				            )
			            )
		            );
		$this->excel->getActiveSheet()->setCellValue( 'R2', 'Involved in Scheduling' );
		$this->excel->getActiveSheet()->getStyle( 'R2' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'R2' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'R2' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->mergeCells('U2:W2');
		$this->excel->getActiveSheet()
		            ->getStyle('U2:W2')
		            ->applyFromArray(
			            array(
				            'fill' => array(
					            'type' => PHPExcel_Style_Fill::FILL_SOLID,
					            'color' => array('rgb' => 'ED6B75')
				            )
			            )
		            );
		$this->excel->getActiveSheet()->setCellValue( 'U2', 'Other people receive the confirmatory lab results' );
		$this->excel->getActiveSheet()->getStyle( 'U2' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'U2' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'U2' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->mergeCells('X2:Z2');
		$this->excel->getActiveSheet()
		            ->getStyle('X2:Z2')
		            ->applyFromArray(
			            array(
				            'fill' => array(
					            'type' => PHPExcel_Style_Fill::FILL_SOLID,
					            'color' => array('rgb' => '91C300')
				            )
			            )
		            );
		$this->excel->getActiveSheet()->setCellValue( 'X2', 'Primary Site Contact' );
		$this->excel->getActiveSheet()->getStyle( 'X2' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'X2' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'X2' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->mergeCells('AA2:AC2');
		$this->excel->getActiveSheet()
		            ->getStyle('AA2:AC2')
		            ->applyFromArray(
			            array(
				            'fill' => array(
					            'type' => PHPExcel_Style_Fill::FILL_SOLID,
					            'color' => array('rgb' => 'EFC20F')
				            )
			            )
		            );
		$this->excel->getActiveSheet()->setCellValue( 'AA2', 'Secondary Site Contact' );
		$this->excel->getActiveSheet()->getStyle( 'AA2' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'AA2' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'AA2' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'A3', 'Site Code' );
		$this->excel->getActiveSheet()->getStyle( 'A3' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'A3' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'A3' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'B3', 'Company Name' );
		$this->excel->getActiveSheet()->getStyle( 'B3' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'B3' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'B3' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'C3', 'Company Email' );
		$this->excel->getActiveSheet()->getStyle( 'C3' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'C3' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'C3' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'D3', 'Company Phone Number' );
		$this->excel->getActiveSheet()->getStyle( 'D3' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'D3' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'D3' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'E3', 'Name of Person Completing Form' );
		$this->excel->getActiveSheet()->getStyle( 'E3' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'E3' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'E3' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'F3', 'Address' );
		$this->excel->getActiveSheet()->getStyle( 'F3' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'F3' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'F3' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'G3', 'City' );
		$this->excel->getActiveSheet()->getStyle( 'G3' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'G3' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'G3' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'H3', 'State' );
		$this->excel->getActiveSheet()->getStyle( 'H3' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'H3' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'H3' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'I3', 'Region Name' );
		$this->excel->getActiveSheet()->getStyle( 'I3' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'I3' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'I3' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'J3', 'ZIP/Postal Code' );
		$this->excel->getActiveSheet()->getStyle( 'J3' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'J3' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'J3' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'K3', 'Country' );
		$this->excel->getActiveSheet()->getStyle( 'K3' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'K3' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'K3' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'L3', 'Contact Name' );
		$this->excel->getActiveSheet()->getStyle( 'L3' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'L3' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'L3' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'M3', 'Contact Phone Number' );
		$this->excel->getActiveSheet()->getStyle( 'M3' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'M3' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'M3' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'N3', 'Contact Email' );
		$this->excel->getActiveSheet()->getStyle( 'N3' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'N3' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'N3' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'O3', 'Contact Name' );
		$this->excel->getActiveSheet()->getStyle( 'O3' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'O3' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'O3' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'P3', 'Contact Phone Numbe' );
		$this->excel->getActiveSheet()->getStyle( 'P3' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'P3' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'P3' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'Q3', 'Contact Email' );
		$this->excel->getActiveSheet()->getStyle( 'Q3' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'Q3' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'Q3' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'R3', 'Contact Name' );
		$this->excel->getActiveSheet()->getStyle( 'R3' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'R3' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'R3' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'S3', 'Contact Phone Number' );
		$this->excel->getActiveSheet()->getStyle( 'S3' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'S3' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'S3' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'T3', 'Contact Email' );
		$this->excel->getActiveSheet()->getStyle( 'T3' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'T3' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'T3' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'U3', 'Contact Name' );
		$this->excel->getActiveSheet()->getStyle( 'U3' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'U3' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'U3' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'V3', 'Contact Phone Number' );
		$this->excel->getActiveSheet()->getStyle( 'V3' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'V3' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'V3' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'W3', 'Contact Email' );
		$this->excel->getActiveSheet()->getStyle( 'W3' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'W3' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'W3' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'X3', 'Contact Name' );
		$this->excel->getActiveSheet()->getStyle( 'X3' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'X3' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'X3' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'Y3', 'Landline Phone Number' );
		$this->excel->getActiveSheet()->getStyle( 'Y3' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'Y3' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'Y3' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'Z3', 'Mobile Phone Number' );
		$this->excel->getActiveSheet()->getStyle( 'Z3' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'Z3' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'Z3' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'AA3', 'Contact Name' );
		$this->excel->getActiveSheet()->getStyle( 'AA3' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'AA3' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'AA3' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'AB3', 'Landline Phone Number' );
		$this->excel->getActiveSheet()->getStyle( 'AB3' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'AB3' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'AB3' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'AC3', 'Mobile Phone Number' );
		$this->excel->getActiveSheet()->getStyle( 'AC3' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'AC3' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'AC3' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'AD3', 'People on site' );
		$this->excel->getActiveSheet()->getStyle( 'AD3' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'AD3' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'AD3' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'AE3', 'Test Count' );
		$this->excel->getActiveSheet()->getStyle( 'AE3' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'AE3' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'AE3' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'AF3', 'Initial Testing Requirements' );
		$this->excel->getActiveSheet()->getStyle( 'AF3' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'AF3' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'AF3' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'AG3', 'Ongoing Testing Requirements' );
		$this->excel->getActiveSheet()->getStyle( 'AG3' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'AG3' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'AG3' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'AH3', 'Type of service preferred on-site' );
		$this->excel->getActiveSheet()->getStyle( 'AH3' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'AH3' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'AH3' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'AI3', 'No of times Drugsafe visit your site' );
		$this->excel->getActiveSheet()->getStyle( 'AI3' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'AI3' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'AI3' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'AJ3', 'Access to power for our Mobile' );
		$this->excel->getActiveSheet()->getStyle( 'AJ3' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'AJ3' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'AJ3' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'AK3', 'Preferred start time' );
		$this->excel->getActiveSheet()->getStyle( 'AK3' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'AK3' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'AK3' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'AL3', 'Our people required to complete an induction' );
		$this->excel->getActiveSheet()->getStyle( 'AL3' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'AL3' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'AL3' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'AM3', 'Risk assessment required' );
		$this->excel->getActiveSheet()->getStyle( 'AM3' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'AM3' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'AM3' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'AN3', 'Randomization process' );
		$this->excel->getActiveSheet()->getStyle( 'AN3' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'AN3' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'AN3' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'AO3', 'Required PPE' );
		$this->excel->getActiveSheet()->getStyle( 'AO3' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'AO3' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'AO3' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'AP3', 'Paperwork at the time of testing' );
		$this->excel->getActiveSheet()->getStyle( 'AP3' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'AP3' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'AP3' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$this->excel->getActiveSheet()->setCellValue( 'AQ3', 'Special instruction for Drugsafe staff' );
		$this->excel->getActiveSheet()->getStyle( 'AQ3' )->getFont()->setSize( 13 );
		$this->excel->getActiveSheet()->getStyle( 'AQ3' )->getFont()->setBold( true );
		$this->excel->getActiveSheet()->getStyle( 'AQ3' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$corpclient = $this->session->userdata( 'corpclient' );
		$siteId     = $this->session->userdata( 'siteName' );
		$idClient   = $this->session->userdata( 'clientId' );
		$fromDate   = $this->session->userdata( 'fromDate' );
		$toDate     = $this->session->userdata( 'toDate' );
		$fromdateData = $this->Webservices_Model->formatdate( $fromDate );
		$todateData   = $this->Webservices_Model->formatdate( $toDate );
		$clientDetailsAray      = $this->Franchisee_Model->viewClientDetails( $idClient );
		$franchiseId            = $clientDetailsAray['franchiseeId'];
		$idfranchisee           = $this->session->userdata( 'idfranchisee' );
		$childClientDetailsAray = $this->Franchisee_Model->viewChildClientDetails( $idClient, false, flase, $searchAry, $siteId, $idfranchisee, $fromdateData, $todateData );
		$clientFranchiseeArr    = $this->Franchisee_Model->getClientFranchisee( $idClient );
		//$sitesArr = $this->Franchisee_Model->viewChildClientDetails($idClient,0,0,'',0,$idfranchisee);
		$loggedinFranchisee = $idfranchisee;
		$clientDetsArr      = $this->Webservices_Model->getclientdetailsbyclientid( $idClient );
		if ( ! empty( $clientDetsArr ) ) {
			$franchiseeid = $clientDetsArr[0]['franchiseeId'];
		}
		if ( $franchiseeid != $_SESSION['drugsafe_user']['id'] ) {
			$addEditClientDet = false;
		}
		$sitesArr                 = array();
		$sitesArr                 = $this->Webservices_Model->getclientdetails( $franchiseeid, $idClient );
		$AssignCorpuserDetailsArr = $this->Webservices_Model->getcorpclientdetails( $loggedinFranchisee, $franchiseeid );
		if ( ! empty( $AssignCorpuserDetailsArr ) ) {
			$addEditClientDet = false;
			$sitesArr         = array();
			foreach ( $AssignCorpuserDetailsArr as $assignCorpUser ) {
				$CorpuserDetailsArr = $this->Webservices_Model->getclientdetails( $assignCorpUser['corpfrid'], $idClient, 0, $assignCorpUser['clientid'], $fromdateData, $todateData );
				$CorpuserSearchArr  = $this->Webservices_Model->getclientdetails( $assignCorpUser['corpfrid'], $idClient, 0, $assignCorpUser['clientid'] );
				if ( ! empty( $CorpuserDetailsArr ) ) {
					foreach ( $CorpuserDetailsArr as $CorpUser ) {
						array_push( $sitesArr, $CorpUser );
					}
				}
			}
		}
		if ( $clientDetailsAray['clientType'] > 0 ) {
			$parentClientDetArr    = $this->Admin_Model->getAdminDetailsByEmailOrId( '', $clientDetailsAray['clientType'] );
			$data['ParentOfChild'] = $parentClientDetArr;
		}
		if ( ! empty( $clientFranchiseeArr ) ) {
			$franchiseeDetArr      = $this->Admin_Model->getAdminDetailsByEmailOrId( '', $clientFranchiseeArr[0]['franchiseeId'] );
			$data['franchiseeArr'] = $franchiseeDetArr;
		}
		if ( $franchiseeDetArr['franchiseetype'] == 1 ) {
			$getState      = $this->Franchisee_Model->getStateByFranchiseeId( $idClient );
			$getRegionName = $this->Admin_Model->getregionbyregionid( $clientDetailsAray['regionId'] );
		} else {
			$getState      = $this->Franchisee_Model->getStateByFranchiseeId( $franchiseId );
			$getRegionName = $this->Admin_Model->getregionbyregionid( $franchiseeDetArr['regionId'] );
		}
		$clientAray = $this->Webservices_Model->getFranchiseeWithClient( $idClient, $idfranchisee );
		/*if(!empty($clientAray)){
            if(($clientAray[0]['szNoOfSites'] == 0) && $clientAray[0]['clientType'] == 0){
                $addEditClientDet = false;
            }
        }*/
		$userDetailsArr = array();
		if ( $corpclient == '1' ) {
			$loggedinFranchisee = $idfranchisee;
			$clientDetsArr      = $this->Webservices_Model->getclientdetailsbyclientid( $idClient, 0, 0, 0, $fromdateData, $todateData );
			if ( ! empty( $clientDetsArr ) ) {
				$idfranchisee = $clientDetsArr[0]['franchiseeId'];
			}
			$AssignCorpuserDetailsArr = $this->Webservices_Model->getcorpclientdetails( $loggedinFranchisee, $idfranchisee );
			if ( ! empty( $AssignCorpuserDetailsArr ) ) {
				$addEditClientDet = false;
				$userDetailsArr   = array();
				foreach ( $AssignCorpuserDetailsArr as $assignCorpUser ) {
					$CorpuserDetailsArr = $this->Webservices_Model->getclientdetails( $assignCorpUser['corpfrid'], $idClient, 0, $assignCorpUser['clientid'], $fromdateData, $todateData );
					if ( ! empty( $CorpuserDetailsArr ) ) {
						foreach ( $CorpuserDetailsArr as $CorpUser ) {
							array_push( $userDetailsArr, $CorpUser );
						}
					}
				}
			}
		}
		if ( $corpclient == '1' ) {
			$childClientDetailsAray = $userDetailsArr;
		} else {
			$childClientDetailsAray = $childClientDetailsAray;
		}
		if ( $childClientDetailsAray ) {
			$i = 4;
			foreach ( $childClientDetailsAray as $item ) {
				if ( $item['regionId'] == 0 ) {
					$getState      = $this->Franchisee_Model->getStateByFranchiseeId( $item['franchiseeId'] );
					$franchiseeArr = $this->Admin_Model->getAdminDetailsByEmailOrId( '', $item['franchiseeId'] );
					$regionId      = $franchiseeArr['regionId'];
				} else {
					$getState = $this->Franchisee_Model->getStateByFranchiseeId( $item['id'] );
					$regionId = $clientData['regionId'];
				}
				$getRegionName = $this->Admin_Model->getregionbyregionid( $regionId );
				$userDataAry    = $this->Franchisee_Model->getSiteDetailsById( $item['id'] );
				$franchiseecode = $this->Franchisee_Model->getusercodebyuserid( $item['id'] );
				if ( $userDataAry['onsite_service'] == 0 ) {
					$onsite_service_val = "Mobile Clinic ";
				} else {
					$onsite_service_val = "In-house";
				}
				if ( $userDataAry['risk_assessment'] == 0 ) {
					$raVal = "Yes";
				} else {
					$raVal = "No";
				}
				if ( $userDataAry['power_access'] == 0 ) {
					$paVal = "Yes";
				} else {
					$paVal = "No";
				}
				if ( $userDataAry['req_comp_induction'] == 0 ) {
					$rciVal = "Yes";
				} else {
					$rciVal = "No";
				}
				if ( $userDataAry['randomisation'] == 0 ) {
					$rpVal = "Marble selection (% split)-not accurate";
				} elseif ( $userDataAry['randomisation'] == 1 ) {
					$rpVal = "Drugsafe given names then select via algorythm";
				} else {
					$rpVal = "Client does randomization";
				}
				if ( $userDataAry['paperwork'] == 0 ) {
					$pwVal = "Leave onsite with site contact";
				}
				if ( $userDataAry['paperwork'] == 1 ) {
					$pwVal = "Return to Drugsafe for filing";
				}
				if ( $userDataAry['paperwork'] == 2 ) {
					$pwVal = "Return to Drugsafe and and emailed to specific contact";
				}
				if ( $userDataAry['ongoing_testing_req'] == 0 ) {
					$ogVal = "Random";
				} else {
					$ogVal = "Blanket";
				}
				if ( $userDataAry['initial_testing_req'] == 0 ) {
					$itrval = "Random";
				} else {
					$itrval = "Blanket";
				}
				 $str = '';
                            $req_ppe_ary = explode(",", $userDataAry['req_ppe']);
                             if(in_array("1", $req_ppe_ary)){
                             $val = "High Vis Work Wear" ;
                             $str .= $val.',';
                             } 
                             if(in_array("2", $req_ppe_ary)){
                             $val = "Head Protection" ;
                             $str .= $val.',';
                             }
                              if(in_array("3", $req_ppe_ary)){
                               $val = "Face/Eye Protection" ;
                                $str .= $val.',';}
                               if(in_array("4", $req_ppe_ary)){
                               $val = "Safety Boots" ;
                                $str .= $val.',';}
                               if(in_array("5", $req_ppe_ary)){
                                $val = "Long Sleev Clothing" ;
                                $str .= $val.',';}
                                $str = substr($str, 0, -1);
				$this->excel->getActiveSheet()->setCellValue( 'A' . $i, ( ! empty( $franchiseecode['userCode'] ) ? $franchiseecode['userCode'] : 'N/A' ) );
				$this->excel->getActiveSheet()->setCellValue( 'B' . $i, $item['szName'] );
				$this->excel->getActiveSheet()->setCellValue( 'C' . $i, $item['szEmail'] );
				$this->excel->getActiveSheet()->setCellValue( 'D' . $i, $item['szContactNumber'] );
				$this->excel->getActiveSheet()->setCellValue( 'E' . $i, $userDataAry['per_form_complete'] );
				$this->excel->getActiveSheet()->setCellValue( 'F' . $i, $item['szAddress'] );
				$this->excel->getActiveSheet()->setCellValue( 'G' . $i, $item['szCity'] );
				$this->excel->getActiveSheet()->setCellValue( 'H' . $i, $getState['name'] );
				$this->excel->getActiveSheet()->setCellValue( 'I' . $i, $getRegionName['regionName'] );
				$this->excel->getActiveSheet()->setCellValue( 'J' . $i, $item['szZipCode'] );
				$this->excel->getActiveSheet()->setCellValue( 'K' . $i, $item['szCountry'] );
				$this->excel->getActiveSheet()->setCellValue( 'L' . $i, $userDataAry['sp_name'] );
				$this->excel->getActiveSheet()->setCellValue( 'M' . $i, $userDataAry['sp_mobile'] );
				$this->excel->getActiveSheet()->setCellValue( 'N' . $i, $userDataAry['sp_email'] );
				$this->excel->getActiveSheet()->setCellValue( 'O' . $i, $userDataAry['rlr_name'] );
				$this->excel->getActiveSheet()->setCellValue( 'P' . $i, $userDataAry['rlr_mobile'] );
				$this->excel->getActiveSheet()->setCellValue( 'Q' . $i, $userDataAry['rlr_email'] );
				$this->excel->getActiveSheet()->setCellValue( 'R' . $i, $userDataAry['iis_name'] );
				$this->excel->getActiveSheet()->setCellValue( 'S' . $i, $userDataAry['iis_mobile'] );
				$this->excel->getActiveSheet()->setCellValue( 'T' . $i, $userDataAry['iis_email'] );
				$this->excel->getActiveSheet()->setCellValue( 'U' . $i, $userDataAry['orlr_name'] );
				$this->excel->getActiveSheet()->setCellValue( 'V' . $i, $userDataAry['orlr_mobile'] );
				$this->excel->getActiveSheet()->setCellValue( 'W' . $i, $userDataAry['orlr_email'] );
				$this->excel->getActiveSheet()->setCellValue( 'X' . $i, $userDataAry['psc_name'] );
				$this->excel->getActiveSheet()->setCellValue( 'Y' . $i, $userDataAry['psc_phone'] );
				$this->excel->getActiveSheet()->setCellValue( 'Z' . $i, $userDataAry['psc_mobile'] );
				$this->excel->getActiveSheet()->setCellValue( 'AA' . $i, $userDataAry['ssc_name'] );
				$this->excel->getActiveSheet()->setCellValue( 'AB' . $i, $userDataAry['ssc_phone'] );
				$this->excel->getActiveSheet()->setCellValue( 'AC' . $i, $userDataAry['ssc_mobile'] );
				$this->excel->getActiveSheet()->setCellValue( 'AD' . $i, $userDataAry['site_people'] );
				$this->excel->getActiveSheet()->setCellValue( 'AE' . $i, $userDataAry['test_count'] );
				$this->excel->getActiveSheet()->setCellValue( 'AF' . $i, $itrval );
				$this->excel->getActiveSheet()->setCellValue( 'AG' . $i, $ogVal );
				$this->excel->getActiveSheet()->setCellValue( 'AH' . $i, $onsite_service_val );
				$this->excel->getActiveSheet()->setCellValue( 'AI' . $i, $userDataAry['site_visit'] );
				$this->excel->getActiveSheet()->setCellValue( 'AJ' . $i, $paVal );
				$this->excel->getActiveSheet()->setCellValue( 'AK' . $i, $userDataAry['start_time'] );
				$this->excel->getActiveSheet()->setCellValue( 'AL' . $i, $rciVal );
				$this->excel->getActiveSheet()->setCellValue( 'AM' . $i, $raVal );
				$this->excel->getActiveSheet()->setCellValue( 'AN' . $i, $rpVal );
				$this->excel->getActiveSheet()->setCellValue( 'AO' . $i, $str );
				$this->excel->getActiveSheet()->setCellValue( 'AP' . $i, $pwVal );
				$this->excel->getActiveSheet()->setCellValue( 'AQ' . $i, $userDataAry['instructions'] );
				$this->excel->getActiveSheet()->getColumnDimension( 'A' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'B' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'C' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'D' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'E' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'F' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'G' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'H' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'I' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'J' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'K' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'L' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'M' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'N' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'O' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'P' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'Q' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'R' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'S' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'T' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'U' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'V' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'W' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'X' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'Y' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'Z' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'AA' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'AB' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'AC' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'AD' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'AE' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'AF' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'AG' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'AH' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'AH' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'AI' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'AJ' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'AK' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'AL' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'AM' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'AN' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'AO' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'AP' )->setAutoSize( true );
				$this->excel->getActiveSheet()->getColumnDimension( 'AQ' )->setAutoSize( true );
				$i ++;
			}
		}
		header( 'Content-Type: application/vnd.ms-excel' ); //mime type
		header( 'Content-Disposition: attachment;filename="' . $file . '"' ); //tell browser what's the file name
		header( 'Cache-Control: max-age=0' ); //no cache
//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
//if you want to save it as .XLSX Excel 2007 format
		$objWriter = PHPExcel_IOFactory::createWriter( $this->excel, 'Excel5' );
//force user to download the Excel file without writing it to server's HD
		$objWriter->save( 'php://output' );
	}
}
?>