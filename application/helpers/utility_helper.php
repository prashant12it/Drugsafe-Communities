<?php
function set_customer_cookie($obj, $data)
{
    //set data to cookie and keep for 1 month
    $encKey1 = "#12EQ#83#";$encKey2="#AR3UIL#452#";

        $cookieData = $data['id'] . "~$encKey1" . $data['szEmail'] . "~$encKey2";
    $encryptedC = base64_encode($cookieData);
    $cookie_time = 60*60*24*30;
    set_cookie(__FRONT_END_COOKIE__, $encryptedC, $cookie_time);
}

function logout($obj)
{
    $obj->session->unset_userdata('drugsafe_user');

    delete_cookie(__FRONT_END_COOKIE__);
}

function is_user_login($obj)
{
  
    return $obj->Admin_Model->checkUserExists();
	
}

function sanitize_all_html_input($value)
{
	if(!empty($value))
	{
		$value=strip_tags($value);
	
		if(strpos($value,"'>") !== false)
			$value=str_replace("'>","",$value);
		if(strpos($value,'">') !== false)
			$value=str_replace('">',"",$value);
	}
	
	return $value;
}

function sanitize_post_field_value($value)
{
	return htmlentities(trim($value));
}

function format_number($number,$seprator=false)
{
	if($seprator)
		return number_format((float)$number, 2, ".", ",");
	else
		return number_format((float)$number, 2, ".", "");
}

function setLastViewedPage($cookie_name, $cookie_value)
{
	$cookie_time = 60*60*24*30;
	set_cookie($cookie_name, $cookie_value, $cookie_time);
}

function checkCustomerLogin($obj)
{
	$login=0;
	$user_session = $obj->session->userdata('drugsafe_user');
	// check session variable
	if((int)$user_session['id']>0)
	{
		$login=1;
	}
	else
	{
            if(get_cookie(__FRONT_END_COOKIE__))
            {
       		$encKey1 = "#12EQ#83#";$encKey2="#AR3UIL#452#";
              
         	$decryptedC1 = base64_decode(get_cookie(__FRONT_END_COOKIE__));
         	$decryptedC2 = preg_replace("/$encKey1/", "", $decryptedC1);
          	$decryptedC3 = preg_replace("/$encKey2/", "", $decryptedC2);

        	list($user_arr['id'], $user_arr['szEmail']) = explode("~", $decryptedC3);
                
                
                if((int)$user_arr['id']>0)
                {
                  
                
                    $userDetails['id'] = $userDetailsARY['id'];
                    $userDetails['szName'] = $userDetailsARY['szName'];
                    $userDetails['szEmail'] = $userDetailsARY['szEmail'];

                    $obj->session->set_userdata('drugsafe_user', $userDetails);

                    $login = 1;
                }
            }
            
	}
	
	if($login==1)
	{
           
                 if($obj->session->userdata('drugsafe_user'))
                {
                        //set data to cookie and keep for 1 month
                    $encKey1 = "#12EQ#83#";$encKey2="#AR3UIL#452#";
                    $cookieData = $user_session['id'] . "~$encKey1" . $user_session['szEmail'] . "~$encKey2";

                    $encryptedC = base64_encode($cookieData);
                    $cookie_time = 60*60*24*30;
                    set_cookie(__FRONT_END_COOKIE__, $encryptedC, $cookie_time);
                }

                return true;
           
           
	}
	else
	{
		return false;
	}
}

function encrypt($string, $encrypt=true)
{
	if($encrypt)
	 	return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5(__ENCRYPT_KEY__), $string, MCRYPT_MODE_CBC, md5(md5(__ENCRYPT_KEY__))));
	else
	 	return $string;
}

function decrypt($encrypted, $decrypt=true)
{
	if($decrypt)
		return rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5(__ENCRYPT_KEY__), base64_decode($encrypted), MCRYPT_MODE_CBC, md5(md5(__ENCRYPT_KEY__))), "\0");
	else
		return $encrypted;
}

function generateRandomString($characters = "0123456789", $length = 6) 
{
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function jsonDecode($json, $assoc = FALSE){ 
    $json = str_replace(array("\n","\r"),"",$json); 
    $json = preg_replace('/([{,]+)(\s*)([^"]+?)\s*:/','$1"$3":',$json);
    $json = preg_replace('/(,)\s*}$/','}',$json);
    return json_decode($json,$assoc); 
}

function xml2Array($xml_string)
{
	$xmlObj = simplexml_load_string($xml_string);
	$arr = json_decode(json_encode((array) $xmlObj),1);
	
	if(!empty($arr['questions']['question']['imageChoice']))
	{
		foreach($arr['questions']['question']['imageChoice'] as $key=>$value)
		{
			$attr = $xmlObj->questions->question->imageChoice[$key]->attributes();
			$attr = json_decode(json_encode((array) $attr),1);
			
			$arr['questions']['question']['imageChoice'][$key] = array();
			$arr['questions']['question']['imageChoice'][$key]['value'] = $value;
			$arr['questions']['question']['imageChoice'][$key]['id'] = $attr['@attributes']['value'];
		}
	}
	
	if(!empty($arr['questions']['question']['choice']))
	{
		foreach($arr['questions']['question']['choice'] as $key=>$value)
		{
			$attr = $xmlObj->questions->question->choice[$key]->attributes();
			$attr = json_decode(json_encode((array) $attr),1);
			
			$arr['questions']['question']['choice'][$key] = array();
			$arr['questions']['question']['choice'][$key]['value'] = $value;
			$arr['questions']['question']['choice'][$key]['id'] = $attr['@attributes']['value'];
		}
	}
	
	return $arr;
}

function sortArray($arrData, $p_sort_field, $p_sort_type = false ,$secondory_sort=false, $secondory_sort_type=false)
{
	if( !empty($arrData) )
	{
		foreach($arrData as $data)
		{
			$newData [] = $data;
		}
		for($i=0; $i<count($newData); $i++)
		{		                   	 
		 	$ar_sort_field[$i]=strtolower($newData[$i][$p_sort_field]);
		 	if($secondory_sort)
		 	{
		 		$ar_secondory_sort[$i] = strtolower($newData[$i][$secondory_sort]);
		 	}
		}
		if($secondory_sort)
		{
			array_multisort($ar_sort_field, ($p_sort_type ? SORT_DESC : SORT_ASC), $ar_secondory_sort, ($secondory_sort_type ? SORT_DESC : SORT_ASC), $newData);
		}
		else
		{
			array_multisort($ar_sort_field, ($p_sort_type ? SORT_DESC : SORT_ASC), $newData);	
		}		
		return $newData;
	}
}
function createEmail($obj,$email_template, $replace_ary, $to, $subject, $reply_to, $id_player=0, $from=__CUSTOMER_SUPPORT_EMAIL__,$pdf='',$flag='')
{ 
    
    $emailCMSAry = $obj->Admin_Model->getEmailTemplateDetailsByTitle($email_template);
    //print_r($emailCMSAry);
    ob_start();  
    $obj->load->view('layout/email_header');
    $message = ob_get_clean();
    
    if(empty($emailCMSAry))
    {
       return false; 
    }
    else
    {
        if($flag==1){
      
         $subject = $emailCMSAry['subject'];
         
        
        $topicList = $obj->Forum_Model->getTodayTopicList();
        $commentList = $obj->Forum_Model->getTodayCommentList();
        $ReplyList = $obj->Forum_Model->getTodayReplyList();
          $message .= '
            <div><p style="text-align:left; font-size:18px; margin-bottom:5px; color:#1bbc9b"><b> Dear Fawada, </b></p></div>
            <div><p style="text-align:left; font-size:18px; margin-bottom:5px; color:#1bbc9b">Today\'s Forum Activities</p></div>';
       if (!empty($topicList)|| !empty($commentList) || !empty($ReplyList) ) {
          if (!empty($topicList)) {
          $message .= '
            <div><p style="text-align:left; font-size:18px; margin-bottom:5px; color:red"><b> Topics</b></p></div>
            
            <div class= "table-responsive" >
                            <table border="1" cellpadding="5">
                                    <tr>
                                        <th style="width:80px"><b>#</b> </th>
                                        <th> <b>Topic</b> </th>
                                        <th> <b>Forum</b> </th>
                                        <th style="width:150px"><b>Franchisee</b> </th>
                                       
                                    </tr>';
       
            $i = 0;
            foreach ($topicList as $topicData) {
                 $i++;
                $franchiseeArr = $obj->Admin_Model->getAdminDetailsByEmailOrId('', $topicData['idUser']);
                 $forumList = $obj->Forum_Model->getForumDetailsByForumId($topicData['idForum']);
                 
               $message .= '<tr>
                                             <td> ' . $i . ' </td>
                                            <td> ' . $topicData['szTopicTitle'] . '</td>
                                            <td> ' . $forumList['0']['szForumTitle'] . ' </td>
                                            <td>' . $franchiseeArr['szName'] . ' </td>
                                           
                                            
                                
                                        </tr>';
            }
        
       
       $message .= '
                         </table>
                        </div>
                      
                       <hr style=" margin-top:25px; "> ';
          }
          if (!empty($commentList)) {
          $message .= '
            <div><p style="text-align:left; font-size:18px; margin-bottom:5px; color:red"><b> Comments</b></p></div>
            
            <div class= "table-responsive" >
                            <table border="1" cellpadding="5">
                                    <tr>
                                        <th style="width:80px"><b>#</b> </th>
                                        <th> <b>Comment</b> </th>
                                        <th> <b>Topic</b> </th>
                                        <th style="width:150px"><b>Forum</b> </th>
                                        <th style="width:150px"><b>Commenter</b> </th>
                                       
                                    </tr>';
      
             
            $i = 0;
            foreach ($commentList as $commentData) {
          
        
                 $i++;
                $franchiseeArr = $obj->Admin_Model->getAdminDetailsByEmailOrId('', $commentData['idCmnters']);
                
                 $TopicDetails = $obj->Forum_Model->getTopicDetailsbyTopicId($commentData['idTopic']);
                  $forumList = $obj->Forum_Model->getForumDetailsByForumId($TopicDetails['idForum']);
               $message .= '<tr>
                                            <td> ' . $i . ' </td>
                                            <td> ' . $commentData['szCmnt'] . '</td>
                                            <td> ' . $TopicDetails['szTopicTitle'] . '</td>
                                            <td> ' . $forumList['0']['szForumTitle'] . ' </td>
                                            <td>' . $franchiseeArr['szName'] . ' </td>
                                            
                                
                                        </tr>';
            }
       
       
       $message .= '
                            </table>
                        </div>
                      
                       <hr style=" margin-top:25px; "> ';
        }
         
             if (!empty($ReplyList)) {
       $message .= '
            <div><p style="text-align:left; font-size:18px; margin-bottom:5px; color:red"><b> Reply</b></p></div>
            
            <div class= "table-responsive" >
                            <table border="1" cellpadding="5">
                                    <tr>
                                        <th style="width:80px"><b>#</b> </th>
                                        <th> <b>Reply</b> </th>
                                        <th> <b>Comment</b> </th>
                                        <th style="width:150px"><b>Topic</b> </th>
                                        <th style="width:150px"><b>Forum</b> </th>
                                        <th style="width:150px"><b>Replier</b> </th>
                                       
                                    </tr>';
       
            $i = 0;
            foreach ($ReplyList as $ReplyData) {
          
        
                 $i++;
                 $commentDetails = $obj->Forum_Model->getAllCommentsByCmntId($ReplyData['idCmnt']);
                $franchiseeArr = $obj->Admin_Model->getAdminDetailsByEmailOrId('', $ReplyData['idReplier']);
                
                 $TopicDetailsData = $obj->Forum_Model->getTopicDetailsbyTopicId($commentDetails['idTopic']);
                 $forumListData = $obj->Forum_Model->getForumDetailsByForumId($TopicDetailsData['idForum']);
                 
               $message .= '<tr>
                                            <td> ' . $i . ' </td>
                                            <td> ' . $ReplyData['szReply'] . '</td>
                                            <td> ' . $commentDetails['szCmnt'] . '</td>
                                            <td> ' . $TopicDetailsData['szTopicTitle'] . '</td>
                                            <td> ' . $forumListData['0']['szForumTitle'] . ' </td>
                                            <td>' . $franchiseeArr['szName'] . ' </td>
                                            
                                
                                        </tr>';
            }
       
     
       $message .= '
                            </table>
                        </div>
                      
                       <hr style=" margin-top:25px; "> ';
   }
       }
       else{ 
        $message .= ' <div><p style="text-align:left; font-size:12px; margin-bottom:5px; color:Black">No Activities.</p></div>';
       }
         $message .= $emailCMSAry['sectionDescription'];  
       
        }
         elseif($flag==2)    {
         $subject = $emailCMSAry['subject'];
         $orderDetails = $obj->Order_Model->getOrderDetailsByOrderId($id_player);
        $orderDetailsOfOrderTbl= $obj->Order_Model->getOrderByOrderId($id_player);
         $franchiseeDetArr1 = $obj->Admin_Model->getAdminDetailsByEmailOrId('', $orderDetailsOfOrderTbl['franchiseeid']);
          $message .= '
            <div><p style="text-align:left; font-size:18px; margin-bottom:5px;" ><b> Dear Franchisee, </b></p></div>
            <div><p style="text-align:left; font-size:18px; margin-bottom:5px;" >Below are the order details,</p></div>';
          
    $message .= ' 
        <table cellpadding="5px"><tr>
        <td width="50%" align="left" font-size="20"><b>Order #:</b> ' .sprintf(__FORMAT_NUMBER__, $id_player). '</td>
    </tr>
    <tr>
        <td width="50%" align="left" font-size="20"><b>Order Date & Time:</b> ' .date('d M Y', strtotime($orderDetailsOfOrderTbl['createdon'])) . ' at ' . date('h:i A', strtotime($orderDetailsOfOrderTbl['createdon'])). '</td>
    </tr>
    <tr>
        <td width="50%" align="left"><b>Total EXL GST:</b> $' .number_format($orderDetailsOfOrderTbl['price'], 2, '.', ','). '</td>
    </tr>
    <tr>
        <td width="50%" align="left"><b>Franchisee:</b> ' . $franchiseeDetArr1['szName'] . '</td>
    </tr>
   
</table> ';
          if ($orderDetails) {
          $message .= '
            <h2><font color="black">Product Info</font></h2>
            
            <div class= "table-responsive" >
                            <table border="1" cellpadding="5">
                                    <tr>
                                        <th style="width:200px"><b> Product Code</b> </th>
                                        <th> <b>Product Cost</b> </th>
                                        <th> <b>Ordered Qty</b> </th>
                                        <th style="width:150px"><b>Total Price EXL GST</b> </th>
                                       
                                    </tr>';
       
            $i = 0;
            foreach ($orderDetails as $orderData) {
                 $i++;
                 $productDataArr = $obj->Inventory_Model->getProductDetailsById($orderData['productid']);
                 $TotalDispatched = $obj->Order_Model->getTotalDispatchedByOrderDetailId($orderData['id']); 
               $message .= '<tr>
                                            <td> ' . $productDataArr['szProductCode'] . ' </td>
                                            <td> $'. $productDataArr['szProductCost'] . '</td>
                                            <td> ' . $orderData['quantity'] . ' </td>
                                            <td>$' . number_format(($orderData['quantity']) * ($productDataArr['szProductCost']), 2, '.', ',') . ' </td>
                                           
                                            
                                
                                        </tr>';
            }
             $message .= '<tr>

                                                     <td colspan="3"><b>Total EXL GST</b></td>

                                                     <td>
                                                        $'.number_format($orderDetailsOfOrderTbl['price'], 2, '.', ','). '
                                                     </td>
       
                       </tr>
                         </table>
                        </div>
                      
                       <hr style=" margin-top:25px; "> ';
          }
          if ($commentList) {
          $message .= '
            <div><p style="text-align:left; font-size:18px; margin-bottom:5px; color:red"><b> Comments</b></p></div>
            
            <div class= "table-responsive" >
                            <table border="1" cellpadding="5">
                                    <tr>
                                        <th style="width:80px"><b>#</b> </th>
                                        <th> <b>Comment</b> </th>
                                        <th> <b>Topic</b> </th>
                                        <th style="width:150px"><b>Forum</b> </th>
                                        <th style="width:150px"><b>Commenter</b> </th>
                                       
                                    </tr>';
      
             
            $i = 0;
            foreach ($commentList as $commentData) {
          
        
                 $i++;
                $franchiseeArr = $obj->Admin_Model->getAdminDetailsByEmailOrId('', $commentData['idCmnters']);
                
                 $TopicDetails = $obj->Order_Model->getTopicDetailsbyTopicId($commentData['idTopic']);
                  $forumList = $obj->Order_Model->getForumDetailsByForumId($TopicDetails['idForum']);
               $message .= '<tr>
                                            <td> ' . $i . ' </td>
                                            <td> ' . $commentData['szCmnt'] . '</td>
                                            <td> ' . $TopicDetails['szTopicTitle'] . '</td>
                                            <td> ' . $forumList['0']['szForumTitle'] . ' </td>
                                            <td>' . $franchiseeArr['szName'] . ' </td>
                                            
                                
                                        </tr>';
            }
       
       
       $message .= '
                            </table>
                        </div>
                      
                       <hr style=" margin-top:25px; "> ';
        }
         $ReplyList = $obj->Forum_Model->getTodayReplyList();
             if ($ReplyList) {
       $message .= '
            <div><p style="text-align:left; font-size:18px; margin-bottom:5px; color:red"><b> Reply</b></p></div>
            
            <div class= "table-responsive" >
                            <table border="1" cellpadding="5">
                                    <tr>
                                        <th style="width:80px"><b>#</b> </th>
                                        <th> <b>Reply</b> </th>
                                        <th> <b>Comment</b> </th>
                                        <th style="width:150px"><b>Topic</b> </th>
                                        <th style="width:150px"><b>Forum</b> </th>
                                        <th style="width:150px"><b>Replier</b> </th>
                                       
                                    </tr>';
       
            $i = 0;
            foreach ($ReplyList as $ReplyData) {
          
        
                 $i++;
                 $commentDetails = $obj->Forum_Model->getAllCommentsByCmntId($ReplyData['idCmnt']);
                $franchiseeArr = $obj->Admin_Model->getAdminDetailsByEmailOrId('', $ReplyData['idReplier']);
                
                 $TopicDetailsData = $obj->Forum_Model->getTopicDetailsbyTopicId($commentDetails['idTopic']);
                 $forumListData = $obj->Forum_Model->getForumDetailsByForumId($TopicDetailsData['idForum']);
                 
               $message .= '<tr>
                                            <td> ' . $i . ' </td>
                                            <td> ' . $ReplyData['szReply'] . '</td>
                                            <td> ' . $commentDetails['szCmnt'] . '</td>
                                            <td> ' . $TopicDetailsData['szTopicTitle'] . '</td>
                                            <td> ' . $forumListData['0']['szForumTitle'] . ' </td>
                                            <td>' . $franchiseeArr['szName'] . ' </td>
                                            
                                
                                        </tr>';
            }
       
       
       $message .= '
                            </table>
                        </div>
                      
                       <hr style=" margin-top:25px; "> ';
   }
         $message .= $emailCMSAry['sectionDescription'];  
       
          
         }
        else{
          $subject = $emailCMSAry['subject'];
          $message .= $emailCMSAry['sectionDescription'];  
        }
        
    }
    

    if(count($replace_ary) > 0)
    {
        foreach ($replace_ary as $replace_key => $replace_value)
        {
            $message = str_replace($replace_key, $replace_value, $message);
            $subject= str_replace($replace_key, $replace_value, $subject);
        }
    }
    ob_start();
    $obj->load->view('layout/email_footer');
    $message .= ob_get_clean();
    
    if($flag==1){
         sendEmail($obj,$to,$from,$subject,$message,$pdf,$id_player,__NOTIFICATION2_EMAIL__);
    }
    else{
       sendEmail($obj,$to,$from,$subject,$message,$pdf,$id_player,$from);
    }
  
}

function sendEmail($obj,$to,$from,$subject,$message,$attach_file='',$id_player,$cc='',$bcc='')
{
	// Get a reference to the controller object
   
    $CI = get_instance();

    $CI->load->library('CI_PHPMailer');

	$mail = new PHPMailer();
	//$mail->isSMTP();
	try
	{
		// Set SMTP Server
		/*$mail->SMTPDebug  = 0;                     	// enables SMTP debug information (for testing)
		if(__SMTP_AUTH__ === true)
		{
			$mail->SMTPAuth   = true;             	// enable SMTP authentication
			$mail->SMTPSecure = "ssl";         		// sets the prefix to the servier
		}
		$mail->Host = __SMTP_HOST__;      			// SMTP server host
		$mail->Port = __SMTP_PORT__;       			// SMTP server port
		if(__SMTP_USERNAME__ != '')
		{
			$mail->Username   = __SMTP_USERNAME__;	// SMTP Server Username
		}
		if(__SMTP_PASSWORD__ != '')
		{
			$mail->Password   = __SMTP_PASSWORD__;	// SMTP Server Password
		}*/
		
		// Manage Sender Address
		$from_name = "";
		$from_email = trim($from);
		if($from_email != "")
		{
			$arFrom = explode("<",$from_email);
			if(count($arFrom) > 1)
			{
				if(strlen(trim($arFrom[0])) > 0)
				{
					$from_name = trim($arFrom[0]);
				}
				$from_email = str_replace(">","",$arFrom[1]);
				//$from_email = "tyagi6931@gmail.com";
			}
		}
		
		// Manage receiver addresses
		$to_addresses = array();
		if($to != '')
		{
			$ar_addresses = explode(",", $to);
			if(!empty($ar_addresses))
			{
				$ctr = 0;
				foreach($ar_addresses as $address)
				{
					$address_name = "";
					$address_email = trim($address);
					$ar_address = explode("<",$address_email);
					if(count($ar_address) > 1)
					{
						if(strlen(trim($ar_address[0])) > 0)
						{
							$address_name = trim($ar_address[0]);
						}
						$address_email = str_replace(">","",$ar_address[1]);
					}
					//$address_email = "lalit@whiz-solutions.com";
					$to_addresses[$ctr]['NAME'] = $address_name;
					$to_addresses[$ctr]['EMAIL'] = $address_email;
					$ctr++;
				}
			}
		}
		
		// Manage Carbon-Copy Addresses
		$cc_addresses = array();
		if($cc != '')
		{
			$ar_addresses = explode(",", $cc);
			if(!empty($ar_addresses))
			{
				$ctr = 0;
				foreach($ar_addresses as $address)
				{
					$address_name = "";
					$address_email = trim($address);
					$ar_address = explode("<",$address_email);
					if(count($ar_address) > 1)
					{
						if(strlen(trim($ar_address[0])) > 0)
						{
							$address_name = trim($ar_address[0]);
						}
						$address_email = str_replace(">","",$ar_address[1]);
					}
					//$address_email = "ltyagi33@yahoo.com";
					$cc_addresses[$ctr]['NAME'] = $address_name;
					$cc_addresses[$ctr]['EMAIL'] = $address_email;
					$ctr++;
				}
			}
		}
		
		// Manage Blind-Carbon-Copy Addresses
		$bcc_addresses = array();
		if($bcc != '')
		{
			$ar_addresses = explode(",", $bcc);
			if(!empty($ar_addresses))
			{
				$ctr = 0;
				foreach($ar_addresses as $address)
				{
					$address_name = "";
					$address_email = trim($address);
					$ar_address = explode("<",$address_email);
					if(count($ar_address) > 1)
					{
						if(strlen(trim($ar_address[0])) > 0)
						{
							$address_name = trim($ar_address[0]);
						}
						$address_email = str_replace(">","",$ar_address[1]);
					}
					//$address_email = "tyagi6931@outlook.com";
					$bcc_addresses[$ctr]['NAME'] = $address_name;
					$bcc_addresses[$ctr]['EMAIL'] = $address_email;
					$ctr++;
				}
			}
		}
		
		//echo "Hello $from_name : $from_email" . " | " . print_r($to_addresses, true) . " | " . print_r($cc_addresses, true) . " | " . print_r($bcc_addresses, true);die; 
		
		$mail->Sender = $from_email;
		$mail->addReplyTo($from_email, $from_name);
		foreach($to_addresses as $address)$mail->addAddress($address['EMAIL'], $address['NAME']);
		if(!empty($cc_addresses)){foreach($cc_addresses as $address){$mail->addCC($address['EMAIL'], $address['NAME']);}}
		if(!empty($bcc_addresses)){foreach($bcc_addresses as $address){$mail->addBCC($address['EMAIL'], $address['NAME']);}}
		$mail->setFrom($from_email, "Customer Support");
		$mail->Subject = $subject;
		$mail->CharSet = 'utf-8';
		$body = str_replace('\\r', '', trim($message));
		
		$mail->MsgHTML($body);
		if($attach_file != '' && file_exists($attach_file))
		{
			$mail->AddAttachment($attach_file); // attachment
		}
		
		$mail_sent = $mail->Send();
	}
	catch (phpmailerException $e) {
		$status = 0;
		$szStatusMsg = $e->errorMessage(); //Pretty error messages from PHPMailer
	} catch (Exception $e) {
		$status = 0;
		$szStatusMsg = $e->getMessage(); //Boring error messages from anything else!
	}
	
	//$szStatusMsg .= print_r($mail, true);
	unset($mail);
	
    if($mail_sent)
    {
        $success = 1;
    }
    else
    {
    	$success = 0;
    }
    
    /*$handle = fopen(__APP_PATH_LOGS__."/email.log", "a+");
	fwrite($handle, "#################################".$subject."################################\n\nTo: ".$to."\n$from_name : $from_email\r\n" . print_r($to_addresses, true) . "\r\nMessage:".$body."\n\nStatus = $szStatusMsg");
	fclose($handle);*/
    $logDataAry = array(

                            'szEmailBody' => $message,
                            'szEmailSubject' => $subject,
                            'szToAddress' => $to,
                            'dtSent' => date('Y-m-d H:i:s'),
                            'iSuccess' => $success
    );
    
    $obj->Admin_Model->logEmails($logDataAry);
    return $success;
}

function create_login_password()
{
	$chars = "234567890abcdefghijkmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
	$i = 0;
	$login_key = "";
	while ($i <= 8)
	{
		$login_key .= $chars{mt_rand(0,strlen($chars)-1)};
		$i++;
	}
	return $login_key;
}

function curl_get_file_contents($URL,$bGeoplugin=false) 
{
    $c = curl_init();
    curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($c, CURLOPT_URL, $URL);
    curl_setopt($c, CURLOPT_SSL_VERIFYPEER, FALSE);
    if($bGeoplugin)
    { 
        curl_setopt($c, CURLOPT_TIMEOUT_MS, '5000');
    }

    $contents = curl_exec($c);
    $err  = curl_getinfo($c,CURLINFO_HTTP_CODE);
    curl_close($c);
    if ($contents) return $contents;
    else return FALSE;
 }
function chekDuplicatehelper($data)
{
    $ci =& get_instance();
    $ci->load->database();
    $ci->db->select('*');
    $ci->db->where($data['field'], $data['str']);
    $ci->db->where('isDeleted', '0');
    $query=$ci->db->get($data['table']);
   if ($query->num_rows() > 0) {
            $row = $query->result_array();
            return true;
    }
    else {
           
            return false;
        }
	
}

 ?>