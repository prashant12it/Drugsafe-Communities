<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Forum_Controller extends CI_Controller {
     
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
	public function addCategory() {
        $count = $this->Admin_Model->getnotification();
        $commentReplyNotiCount = $this->Forum_Model->commentReplyNotifications();
            $is_user_login = is_user_login($this);
            // redirect to dashboard if already logged in
            if (!$is_user_login) {
                ob_end_clean();
                redirect(base_url('/admin/admin_login'));
                die;
            }
            $this->load->library('form_validation');
            $this->form_validation->set_rules('forumData[szCategoryName]', 'Category Name', 'required');
            $this->form_validation->set_rules('forumData[szCategoryDiscription]', 'Category Description', 'required');
            $this->form_validation->set_message('required', '{field} is required.');
            if ($this->form_validation->run() == FALSE)
            { 
                $data['notification'] = $count;
                $data['commentnotification'] = $commentReplyNotiCount;
                $data['szMetaTagTitle'] = "Add Category";
                $data['is_user_login'] = $is_user_login;
                $data['pageName'] = "Forum";
                $data['subpageName'] = "Categories";
                $this->load->view('layout/admin_header', $data);
                $this->load->view('forum/addCategory');
                $this->load->view('layout/admin_footer');
            }
            else
            {
                if( $this->Forum_Model->insertCategory())
                {
                    $szMessage['type'] = "success";
                    $szMessage['content'] = "<strong><h3> Category added successfully.</h3></strong>";
                    $this->session->set_userdata('drugsafe_user_message', $szMessage); 
                  redirect(base_url('/forum/categoriesList'));
                    die;
                }
            }
        }
        function addTopicData()
        {
            $idForum = $this->input->post('idForum');
            $this->session->set_userdata('idForum',$idForum);
           
            echo "SUCCESS||||";
            echo "addTopic";
            
        }
        public function addTopic(){
              $count = $this->Admin_Model->getnotification();
              $commentReplyNotiCount = $this->Forum_Model->commentReplyNotifications();
              $is_user_login = is_user_login($this);
              $idForum = $this->session->userdata('idForum');
              $value = $this->input->post('forumData');
             
            // redirect to dashboard if already logged in
            if (!$is_user_login) {
                ob_end_clean();
              redirect(base_url('/admin/admin_login'));
                die;
            }
            $this->load->library('form_validation');
            $this->form_validation->set_rules('forumData[szTopicTitle]', 'Topic Title', 'required');
            $this->form_validation->set_rules('forumData[szTopicDiscription]', 'Topic Description', 'required');
            $this->form_validation->set_message('required', '{field} is required.');
            if ($this->form_validation->run() == FALSE)
            { 
                $data['notification'] = $count;
                $data['commentnotification'] = $commentReplyNotiCount;
                $data['szMetaTagTitle'] = "Add Topic";
                $data['is_user_login'] = $is_user_login;
                $data['pageName'] = "Forum";
                $data['idForum'] = $idForum;
                 $data['subpageName'] = "Categories";
                $this->load->view('layout/admin_header', $data);
                $this->load->view('forum/addTopic');
                $this->load->view('layout/admin_footer');
            }
            else
            {
                if( $this->Forum_Model->insertTopic($value,$idForum))
                {
                    $szMessage['type'] = "success";
                    $szMessage['content'] = "<strong><h3> Forum Topic added successfully.</h3></strong>";
                    $this->session->set_userdata('drugsafe_user_message', $szMessage); 
                     $this->session->unset_userdata('idForum');
                    redirect(base_url('/forum/forumList'));
                }
            }
        }
        function editCategoryData()
        {
            $idCategory = $this->input->post('idCategory');
            $this->session->set_userdata('idCategory',$idCategory);
           
            echo "SUCCESS||||";
            echo "editCategory";
            
        }
        
        public function editCategory() {
            $count = $this->Admin_Model->getnotification();
            $commentReplyNotiCount = $this->Forum_Model->commentReplyNotifications();
            $is_user_login = is_user_login($this);
            // redirect to dashboard if already logged in
            if (!$is_user_login) {
                ob_end_clean();
                redirect(base_url('/admin/admin_login'));
                die;
            }
           
            $idCategory = $this->session->userdata('idCategory');
            $CategoryDataAry = $this->Forum_Model->getCategoryDetailsById($idCategory);
         
            $this->load->library('form_validation');
            $this->form_validation->set_rules('forumData[szName]', 'Category Name', 'required');
            $this->form_validation->set_rules('forumData[szDiscription]', 'Category Description', 'required');
             $this->form_validation->set_message('required', '{field} is required.');
            
            if ($this->form_validation->run() == FALSE)
            {
                $data['szMetaTagTitle'] = "Edit Category";
                $data['is_user_login'] = $is_user_login;
                $data['pageName'] = "Forum";
                $data['subpageName'] = "Categories";
                $_POST['forumData']= $CategoryDataAry;
                $data['notification'] = $count;
                $data['commentnotification'] = $commentReplyNotiCount;
                $this->load->view('layout/admin_header', $data);
                $this->load->view('forum/editCategory');
                $this->load->view('layout/admin_footer');
            }
            else
            {
                if( $this->Forum_Model->UpdateCategory($idCategory))
                {
                   
                        $szMessage['type'] = "success";
                        $szMessage['content'] = "<strong><h3> Category updated successfully.</h3></strong>";
                        $this->session->set_userdata('drugsafe_user_message', $szMessage);
                        $this->session->unset_userdata('idCategory');
                        ob_end_clean();
                        redirect(base_url('/forum/categoriesList'));
                    die;
                }
            }
        }
       
        function categoriesList()
        {
           $is_user_login = is_user_login($this);
            // redirect to dashboard if already logged in
            if(!$is_user_login)
            {
                ob_end_clean();
                redirect(base_url('/admin/admin_login'));
                die;
            }
             $searchAry = $_POST['szSearchCtName'];
//             print_r($searchAry);die;
             
             $config['base_url'] = __BASE_URL__ . "/forum/categoriesList/";
             $config['total_rows'] = count($this->Forum_Model->viewCategoriesList($limit,$offset,$searchAry));
             $config['per_page'] = __PAGINATION_RECORD_LIMIT__;
             $this->pagination->initialize($config);
            
               $idfranchisee = $_SESSION['drugsafe_user']['id'];
               $categoriesAray =$this->Forum_Model->viewCategoriesList($config['per_page'],$this->uri->segment(3),$searchAry);
               $categoriesListAray =$this->Forum_Model->viewDistinctCategoriesList();
               $count = $this->Admin_Model->getnotification();
               $commentReplyNotiCount = $this->Forum_Model->commentReplyNotifications();
                    $data['categoriesAray'] = $categoriesAray;
                    $data['szMetaTagTitle'] = " Categories List";
                    $data['is_user_login'] = $is_user_login;
                    $data['pageName'] = "Forum";
                    $data['subpageName'] = "Forum_List";
                    $data['notification'] = $count;
                    $data['commentnotification'] = $commentReplyNotiCount;
                    $data['data'] = $data;
                    $data['categoriesListAray'] = $categoriesListAray;
 
            $this->load->view('layout/admin_header',$data);
            $this->load->view('forum/categoriesList');
            $this->load->view('layout/admin_footer');
        }
        public function deleteCategoryAlert()
        {
            $data['mode'] = '__DELETE_CATEGORY_POPUP__';
            $data['idCategory'] = $this->input->post('idCategory');
            $this->load->view('admin/admin_ajax_functions',$data);
        }
        public function deleteCategoryConfirmation()
        {
            $data['mode'] = '__DELETE_CATEGORY_POPUP_CONFIRM__';
            $data['idCategory'] = $this->input->post('idCategory');
            $this->Forum_Model->deleteCategory($data['idCategory']);
            $this->load->view('admin/admin_ajax_functions',$data);
        }   
         public function forumDeleteAlert()
        {
            $data['mode'] = '__DELETE_FORUM_POPUP__';
            $data['id'] = $this->input->post('id');
            $this->load->view('admin/admin_ajax_functions',$data);
        }
        public function deleteForumConfirmation()
        {
            $data['mode'] = '__DELETE_FORUM_POPUP_CONFIRM__';
            $data['id'] = $this->input->post('id');
            $this->Forum_Model->deleteForum($data['id']);
            $this->load->view('admin/admin_ajax_functions',$data);
        } 
         function viewForumData()
        {
            $idCategory = $this->input->post('idCategory');
            $this->session->set_userdata('idCategory',$idCategory);
           
            echo "SUCCESS||||";
            echo "forumList";
            
        }
        
         function forumList()
        {
           $is_user_login = is_user_login($this);
            // redirect to dashboard if already logged in
            if(!$is_user_login)
            {
                ob_end_clean();
                redirect(base_url('/admin/admin_login'));
                die;
            }
             $idCategory = $this->session->userdata('idCategory');
             $searchAry = $_POST['szSearchforumTitle'];
             
             $config['base_url'] = __BASE_URL__ . "/forum/forumList/";
             $config['total_rows'] = count($this->Forum_Model->viewForumDataList($limit,$offset,$searchAry,$idCategory));
             $config['per_page'] = __PAGINATION_RECORD_LIMIT__;
             $this->pagination->initialize($config);
            
             
          
               $forumDataAray =$this->Forum_Model->viewForumDataList($config['per_page'],$this->uri->segment(3),$searchAry,$idCategory);
               $forumDataSearchAray =$this->Forum_Model->viewForumDataList(false,false,false,$idCategory);
               $count = $this->Admin_Model->getnotification();
            $commentReplyNotiCount = $this->Forum_Model->commentReplyNotifications();
                    $data['forumDataAray'] = $forumDataAray;
                    $data['szMetaTagTitle'] = " Forum List";
                    $data['is_user_login'] = $is_user_login;
                    $data['idCategory'] = $idCategory;
                    $data['pageName'] = "Forum";
                    $data['subpageName'] = "Forum_List";
                    $data['notification'] = $count;
            $data['commentnotification'] = $commentReplyNotiCount;
                    $data['data'] = $data;
            $data['forumDataSearchAray'] = $forumDataSearchAray;
 
            $this->load->view('layout/admin_header',$data);
            $this->load->view('forum/forumList');
            $this->load->view('layout/admin_footer');
        }
         function addForumData()
        {
            $idCategory = $this->input->post('idCategory');
            $flag = $this->input->post('flag');
            $this->session->set_userdata('idCategory',$idCategory);
            $this->session->set_userdata('flag',$flag);
           
            echo "SUCCESS||||";
            echo "addforum";
            
        }
         public function addforum() 
        {
            $count = $this->Admin_Model->getnotification();
            $commentReplyNotiCount = $this->Forum_Model->commentReplyNotifications();
             $validate = $this->input->post('forumData');
             $idCategory = $this->session->userdata('idCategory');
             $flag = $this->session->userdata('flag');
            $is_user_login = is_user_login($this);
            // redirect to dashboard if already logged in
            if (!$is_user_login) {
                ob_end_clean();
                redirect(base_url('/admin/admin_login'));
                die;
            }
            $this->load->library('form_validation');
            $this->form_validation->set_rules('forumData[szForumTitle]', 'Forum Title', 'required');
            $this->form_validation->set_rules('forumData[szForumDiscription]', 'Forum Description', 'required');
            $this->form_validation->set_rules('forumData[szForumLongDiscription]', 'Forum Long Description', 'required');
            $this->form_validation->set_rules('forumData[idCategory]', 'category ', 'required');
            $this->form_validation->set_message('required', '{field} is required.');
            if ($this->form_validation->run() == FALSE)
            { 
                $data['notification'] = $count;
                $data['commentnotification'] = $commentReplyNotiCount;
                $data['idCategory'] = $idCategory;
                $data['flag'] = $flag;
                $data['szMetaTagTitle'] = "Add Forum Data";
                $data['is_user_login'] = $is_user_login;
                $data['pageName'] = "Forum";
                $data['subpageName'] = "Forum_List";
                $this->load->view('layout/admin_header', $data);
                $this->load->view('forum/addForum');
                $this->load->view('layout/admin_footer');
            }
            else
            {
                if( $this->Forum_Model->insertForumData($validate))
                {
                    $szMessage['type'] = "success";
                    $szMessage['content'] = "<strong><h3> Forum Data added successfully.</h3></strong>";
                    $this->session->set_userdata('drugsafe_user_message', $szMessage); 
                    redirect(base_url('/forum/forumList'));
                    die;
                }
            }
        }
         function editForumData()
        {
            $id = $this->input->post('id');
            $this->session->set_userdata('id',$id);
           
            echo "SUCCESS||||";
            echo "editForum";
            
        }
        
        public function editForum() {
            
              $is_user_login = is_user_login($this);
            // redirect to dashboard if already logged in
            if (!$is_user_login) {
                ob_end_clean();
                redirect(base_url('/admin/admin_login'));
                die;
            }
            $count = $this->Admin_Model->getnotification();
            $commentReplyNotiCount = $this->Forum_Model->commentReplyNotifications();
            $is_user_login = is_user_login($this);
            $validate = $this->input->post('forumData');
            $id = $this->session->userdata('id');
            $forumDataAry = $this->Forum_Model->getForumDetailsById($id);
            
           
         
            $this->load->library('form_validation');
            $this->form_validation->set_rules('forumData[szForumTitle]', 'Forum Title', 'required');
            $this->form_validation->set_rules('forumData[szForumDiscription]', 'Forum Description', 'required');
            $this->form_validation->set_rules('forumData[szForumLongDiscription]', 'Forum Long Description', 'required');
            $this->form_validation->set_message('required', '{field} is required.');
            
            if ($this->form_validation->run() == FALSE)
            {
                
                $data['szMetaTagTitle'] = "Edit Forum Data";
                $data['is_user_login'] = $is_user_login;
                $data['pageName'] = "Forum";
                $data['subpageName'] = "Forum_List";
                $_POST['forumData']= $forumDataAry;
                $data['notification'] = $count;
                $data['commentnotification'] = $commentReplyNotiCount;
                $this->load->view('layout/admin_header',$data);
                $this->load->view('forum/editForum');
                $this->load->view('layout/admin_footer');
            }
            else
            {
                if( $this->Forum_Model->UpdateForum($validate,$id))
                {
                   
                        $szMessage['type'] = "success";
                        $szMessage['content'] = "<strong><h3> Forum Data updated successfully.</h3></strong>";
                        $this->session->set_userdata('drugsafe_user_message', $szMessage);
                        $this->session->unset_userdata('id');
                        ob_end_clean();
                        redirect(base_url('/forum/forumList'));
                    die;
                }
            }
        }
         function viewForumListData()
        {
            $idForum = $this->input->post('idForum');
            
                $this->session->set_userdata('idForum',$idForum);
                
                echo "SUCCESS||||";
                echo "viewForum";
            
 
        }
        function viewForum()
    {
        $idForum = $this->session->userdata('idForum');
        $is_user_login = is_user_login($this);
        // redirect to dashboard if already logged in
        if (!$is_user_login) {
            ob_end_clean();
            redirect(base_url('/admin/admin_login'));
            die;
        }
         $searchAry = '';
         
         // handle pagination
      
        $config['base_url'] = __BASE_URL__ . "/forum/viewForum/";
        $config['total_rows'] = count($this->Forum_Model->viewTopicList($idForum,false,false,$limit,$offset));
        $config['per_page'] = __PAGINATION_RECORD_LIMIT__;
        $this->pagination->initialize($config);
      
       $forumDetailsAry = $this->Forum_Model->getForumDetailsByForumId($idForum);
//       $forumDataSearchAray =$this->Forum_Model->getForumDetailsByForumId($idForum);
       $count = $this->Admin_Model->getnotification();
            $commentReplyNotiCount = $this->Forum_Model->commentReplyNotifications();
       $forumTopicDataAry =$this->Forum_Model->viewTopicList($idForum,false,false,$config['per_page'],$this->uri->segment(3));
   
        $data['forumTopicDataAry'] = $forumTopicDataAry;
        $data['forumDetailsAry'] = $forumDetailsAry;
//        $data['forumDataSearchAray'] = $forumDataSearchAray;
        $data['pageName'] = "Forum";
        $data['subpageName'] = "Forum_List";
        $data['szMetaTagTitle'] = "Forum Details List";
        $data['is_user_login'] = $is_user_login;
        $data['notification'] = $count;
            $data['commentnotification'] = $commentReplyNotiCount;
        $this->load->view('layout/admin_header', $data);
        $this->load->view('forum/viewForum');
        $this->load->view('layout/admin_footer');
       
    }
     function viewTopicData()
        {
            $idTopic = $this->input->post('idTopic');
            $idForum = $this->input->post('idForum');
            $this->session->set_userdata('idTopic',$idTopic);
            $this->session->set_userdata('idForum',$idForum);
                
                echo "SUCCESS||||";
                echo "viewTopicDetails";
            
 
        }
        function viewTopicDetails()
    {
        $idTopic = $this->session->userdata('idTopic');
        $idForum = $this->session->userdata('idForum');
        $is_user_login = is_user_login($this);
        // redirect to dashboard if already logged in
        if (!$is_user_login) {
            ob_end_clean();
            redirect(base_url('/admin/admin_login'));
            die;
        }
  
        $forumTopicDataAry =$this->Forum_Model->viewTopicList($idForum,$idTopic,1);
        
            $this->load->library('form_validation');
            $this->form_validation->set_rules('replyData[szForumLongDiscription]', 'Comments', 'required');
            
            $this->form_validation->set_message('required', '{field} is required.');
            
            if ($this->form_validation->run() == FALSE)
            {
                $data['forumTopicDataAry'] = $forumTopicDataAry;
                $data['pageName'] = "Forum";
                 $data['idForum'] = $idForum;
                $data['subpageName'] = "Forum_List";
                $data['szMetaTagTitle'] = "Topic Details ";
                $data['is_user_login'] = $is_user_login;
                $data['notification'] = $count;
                $this->load->view('layout/admin_header', $data);
                $this->load->view('forum/viewTopicDetails');
                $this->load->view('layout/admin_footer');
            }
            else
            {
                if( $this->Forum_Model->insertComents($idTopic))
                {
                   
                        $szMessage['type'] = "success";
                        $szMessage['content'] = "<strong><h3> Comments Posted successfully.</h3></strong>";
                        $this->session->set_userdata('drugsafe_user_message', $szMessage);
                        ob_end_clean();
                       
                        redirect(base_url('/forum/viewTopicDetails'));
                    die;
                }
            }
    }
    public function replyToCmnt()
    {
        $data['mode'] = '__REPLY_POPUP__';
        $data['idCmnt'] = $this->input->post('idCmnt');
        $this->load->view('admin/admin_ajax_functions',$data);
    }
    public function replyToCmntConfirmation()
    {
        
        $data['mode'] = '__REPLY_CONFIRM_POPUP__';
        $data['idCmnt'] = $this->input->post('idCmnt');
        $data['val'] = $this->input->post('val');
        $this->Forum_Model->insertReply($data['idCmnt'],$data['val']);
        $this->load->view('admin/admin_ajax_functions', $data);
    }
    function approvallist()
    {
           $is_user_login = is_user_login($this);
            // redirect to dashboard if already logged in
            if(!$is_user_login)
            {
                ob_end_clean();
                redirect(base_url('/admin/admin_login'));
                die;
            }
//               $replyDataArr = $this->Forum_Model->getAllReply(false,2);
//               $cmntDataArr = $this->Forum_Model->getAllCommentsByTopicId(false,1); 
            $topicDataArr = $this->Forum_Model->viewUnapprovedTopicList();
            
               $count = $this->Admin_Model->getnotification();
              $commentReplyNotiCount = $this->Forum_Model->commentReplyNotifications();
                  
                    $data['szMetaTagTitle'] = "Topic Approval";
                    $data['topicDataArr'] = $topicDataArr; 
                    $data['is_user_login'] = $is_user_login;
                    $data['pageName'] = "Forum";
                    $data['subpageName'] = "Topic Approval";
                    $data['notification'] = $count;
                    $data['commentnotification'] = $commentReplyNotiCount;
                   
                    $data['data'] = $data;
           
 
            $this->load->view('layout/admin_header',$data);
            $this->load->view('forum/replyListForApproval');
            $this->load->view('layout/admin_footer');
        }
        public function showTopicData()
        {
            $data['mode'] = '__TOPIC_POPUP__';
            $data['idTopic'] = $this->input->post('idTopic');
         
            $this->load->view('admin/admin_ajax_functions',$data);
        }
        public function showReplyData()
        {
            $data['mode'] = '__SHOW_REPLY_POPUP__';
            $data['idReply'] = $this->input->post('idReply');
            $this->load->view('admin/admin_ajax_functions',$data);
        }
        public function approveReplyAlert()
        {
            $data['mode'] = '__APPROVE_REPLY_POPUP__';
            $data['idReply'] = $this->input->post('idReply');
            $this->load->view('admin/admin_ajax_functions',$data);
        }
         public function approveReplyConfirmation()
    {
        
        $data['mode'] = '__REPLY_APPROVE_CONFIRM_POPUP__';
        $data['idReply'] = $this->input->post('idReply');
        $this->Forum_Model->updateReplyApproval($data['idReply']);
        $this->load->view('admin/admin_ajax_functions', $data);
    }
      public function replyDeleteAlert()
        {
            $data['mode'] = '__DELETE_REPLY_POPUP__';
            $data['idReply'] = $this->input->post('idReply');
            $this->load->view('admin/admin_ajax_functions',$data);
        }
        public function replyDeleteConfirmation()
        {
            $data['mode'] = '__DELETE_REPLY_POPUP_CONFIRM__';
            $data['idReply'] = $this->input->post('idReply');
            $this->Forum_Model->deleteReply($data['idReply']);
            $this->load->view('admin/admin_ajax_functions',$data);
        }  
      public function unapproveReplyAlert()
        {
            $data['mode'] = '__UNAPPROVE_REPLY_POPUP__';
            $data['idReply'] = $this->input->post('idReply');
            $this->load->view('admin/admin_ajax_functions',$data);
        }
        public function unapproveReplyConfirmation()
        {
         
            $data['mode'] = '__REPLY_UNAPPROVE_CONFIRM_POPUP__';
            $data['idReply'] = $this->input->post('idReply');
            $this->Forum_Model->updateReplyUnapproval($data['idReply']);
            $this->load->view('admin/admin_ajax_functions', $data);
        }
        public function cmntDeleteAlert()
        {
            $data['mode'] = '__DELETE_COMMENT_POPUP__';
            $data['idCmnt'] = $this->input->post('idCmnt');
            $this->load->view('admin/admin_ajax_functions',$data);
        }
        public function cmntDeleteConfirmation()
        {
            $data['mode'] = '__DELETE_COMMENT_POPUP_CONFIRM__';
           $data['idCmnt'] = $this->input->post('idCmnt');
            $this->Forum_Model->deleteCmnt($data['idCmnt']);
            $this->load->view('admin/admin_ajax_functions',$data);
        } 
         public function closeTopicAlert()
        {
            $data['mode'] = '__TOPIC_CLOSE_POPUP__';
            $data['idTopic'] = $this->input->post('idTopic');
          
            $this->load->view('admin/admin_ajax_functions',$data);
        }
        public function closeTopicConfirmationData()
        {
            $data['mode'] = '__TOPIC_CLOSE_POPUP_CONFIRM__';
           $data['idTopic'] = $this->input->post('idTopic');
            $this->Forum_Model->closeTopic( $data['idTopic']);
            $this->load->view('admin/admin_ajax_functions',$data);
        } 
          public function replyEditData()
        {
            $data['mode'] = '__EDIT_REPLY_POPUP__';
            $data['idReply'] = $this->input->post('idReply');
            $replyArr = $this->Forum_Model->getAllReply($data['idReply'],1);
            $data['szReply'] = $replyArr['0']['szReply'];
            $this->load->view('admin/admin_ajax_functions',$data);
        }
        public function replyEditConfirmation()
        {
            $data['mode'] = '__EDIT_REPLY_POPUP_CONFIRM__';
            $data['idReply'] = $this->input->post('idReply');
            $data['val'] = $this->input->post('val');
            $this->Forum_Model->updateReply($data['idReply'],$data['val']);
            $this->load->view('admin/admin_ajax_functions',$data);
        }
         public function approveTopicAlert()
        {
            $data['mode'] = '__APPROVE_TOPIC_POPUP__';
            $data['idTopic'] = $this->input->post('idTopic');
            $this->load->view('admin/admin_ajax_functions',$data);
        }
         public function approveTopicConfirmation()
    {
        
        $data['mode'] = '__TOPIC_APPROVE_CONFIRM_POPUP__';
        $data['idTopic'] = $this->input->post('idTopic');
        $this->Forum_Model->updateTopicApproval($data['idTopic']);
        $this->load->view('admin/admin_ajax_functions', $data);
    }
     public function unapproveTopicAlert()
        {
            $data['mode'] = '__UNAPPROVE_TOPIC_POPUP__';
            $data['idTopic'] = $this->input->post('idTopic');
            $this->load->view('admin/admin_ajax_functions',$data);
        }
         public function unapproveTopicConfirmation()
    {
        
        $data['mode'] = '__TOPIC_UNAPPROVE_CONFIRM_POPUP__';
        $data['idTopic'] = $this->input->post('idTopic');
        $this->Forum_Model->updateTopicUnapproval($data['idTopic']);
        $this->load->view('admin/admin_ajax_functions', $data);
    }
    
     public function commentEditData()
        {
            $data['mode'] = '__EDIT_COMMENT_POPUP__';
            $data['idComment'] = $this->input->post('idComment');
            $commentArr = $this->Forum_Model->viewCmntListByCmntId($data['idComment']);
            $data['szComment'] = $commentArr['szCmnt'];
            $this->load->view('admin/admin_ajax_functions',$data);
        }
        public function commentEditConfirmation()
        {
            $data['mode'] = '__EDIT_COMMENT_POPUP_CONFIRM__';
            $data['idComment'] = $this->input->post('idComment');
            $data['val'] = $this->input->post('val');
            $this->Forum_Model->updateComment($data['idComment'],$data['val']);
            $this->load->view('admin/admin_ajax_functions',$data);
        }
            public function deleteTopicAlert()
        {
            $data['mode'] = '__DELETE_TOPIC_POPUP__';
            $data['idTopic'] = $this->input->post('idTopic');
            $this->load->view('admin/admin_ajax_functions',$data);
        }
        public function topicDeleteConfirmation()
        {
            $data['mode'] = '__DELETE_TOPIC_POPUP_CONFIRM__';
            $data['idTopic'] = $this->input->post('idTopic');
            $this->Forum_Model->deleteTopic($data['idTopic']);
            $this->load->view('admin/admin_ajax_functions',$data);
        }
          function sendEmail()
        {
           $is_user_login = is_user_login($this);
            // redirect to dashboard if already logged in
            if(!$is_user_login)
            {
                ob_end_clean();
                redirect(base_url('/admin/admin_login'));
                die;
            }
           
               $sendEmailAray =  $this->Forum_Model->sendEmail();
      
                if($sendEmailAray)
                {
                 
                        $szMessage['type'] = "success";
                        $szMessage['content'] = "<strong><h3> Email has been sent successfully.</h3></strong>";
                        $this->session->set_userdata('drugsafe_user_message', $szMessage);
                        ob_end_clean();
                        redirect(base_url('/admin/operationManagerList'));
                    die;
                    
                }
                   
        } 
    }      
?>