<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home_Controller extends CI_Controller
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

    public function index()
    {
        $is_user_login = is_user_login($this);
       if($_SESSION['drugsafe_user']['id']>0){  
        if ($is_user_login) {
            if ($_SESSION['drugsafe_user']['iRole'] == '5') {
                ob_end_clean();
                redirect(base_url('/admin/franchiseeList'));
                die;
            } elseif ($_SESSION['drugsafe_user']['iRole'] == '1') {
                ob_end_clean();
                redirect(base_url('/admin/operationManagerList'));
                die;
            } elseif($_SESSION['drugsafe_user']['iRole'] == '2') {
                ob_end_clean();
                redirect(base_url('/franchisee/clientRecord'));
                die;
            }
             elseif($_SESSION['drugsafe_user']['iRole'] == '3') {
                ob_end_clean();
                redirect(base_url('/franchisee/view_form_for_client'));
                die;
            }
            else {
            ob_end_clean();
            redirect(base_url('/admin/admin_login'));
            die;
        }
       } } else {
            ob_end_clean();
            redirect(base_url('/admin/admin_login'));
            die;
        }
    }

	function sendemail(){
		$this->Forum_Model->sendEmail();
	}
}