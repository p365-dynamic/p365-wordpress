<?php
function wplc_api_send_agent_message(WP_REST_Request $request){
	$return_array = array();
	if(isset($request)){
		if(isset($request['server_token'])){
			$check_token = get_option('wplc_api_secret_token');
			if($check_token !== false && $request['server_token'] === $check_token){
				if(isset($request['chat_id'])){
					if(isset($request['message'])){
						if(isset($request['relay_action'])){

								$chat_id = sanitize_text_field($request['chat_id']);
								$message = $request['message'];
								$action = $request['relay_action'];

								if (!empty($request['msg_id'])) {
									$other = new stdClass();
									$other->msgID = $request['msg_id'];
								} else {
									$other = false;
								}
								
								if ($action == "wplc_admin_send_msg"){
									$message = sanitize_text_field( $message );
									$ato = intval( $request['ato'] );
									wplc_api_record_agent_chat_msg(sanitize_text_field( $request['agent_id'] ), $chat_id, $message, true, $ato, $other);
									wplc_update_active_timestamp($chat_id);

					                $return_array['response'] = "Message sent successfully";
									$return_array['code'] = "200";
									$return_array['data'] = array("chat_id" => intval($request['chat_id']),
																  "agent_id" => intval($request['agent_id']));

									do_action("wplc_new_user_message_after_record_hook", $chat_id, $message);
								}


				           
				        } else {
							$return_array['request_information'] = __("Action not set", "wplivechat");
						}
					} else {
						$return_array['response'] = "No 'message' found";
						$return_array['code'] = "401";
						$return_array['requirements'] = array("server_token" => "YOUR_SECRET_TOKEN",
													      	  "chat_id"   => "Chat ID",
													      	  "message" => "Message");
					}
			 	} else {
					$return_array['response'] = "No 'chat_id' found";
					$return_array['code'] = "401";
					$return_array['requirements'] = array("server_token" => "YOUR_SECRET_TOKEN",
												      	  "chat_id"   => "Chat ID",
												      	  "message" => "Message");
				}
		 	} else {
				$return_array['response'] = "Secret server_token is invalid";
				$return_array['code'] = "401";
			}
		}else{
			$return_array['response'] = "No secret 'server_token' found";
			$return_array['code'] = "401";
			$return_array['requirements'] = array("server_token" => "YOUR_SECRET_TOKEN",
										      	  "chat_id"   => "Chat ID",
										      	  "message" => "Message");
		}
	}else{
		$return_array['response'] = "No request data found";
		$return_array['code'] = "400";
		$return_array['requirements'] = array("server_token" => "YOUR_SECRET_TOKEN",
									      	  "chat_id"   => "Chat ID",
									      	  "message" => "Message");
	}
	
	return $return_array;
}



function wplc_api_get_agent_unread_message_counts( WP_REST_Request $request ) {
	$return_array = array();
	if(isset($request)){
		if(isset($request['token'])){
			$check_token = get_option('wplc_api_secret_token');
			if($check_token !== false && $request['token'] === $check_token){
			    
				$current_agent = intval( sanitize_text_field( $request['agent_id'] ) );

			    /**
			     * Get all agents
			     * @var [type]
			     */
			    $user_array = get_users(array(
			        'meta_key' => 'wplc_ma_agent',
			    ));


			    $a_array = array();
			    if ($user_array) {
			        foreach ($user_array as $user) {
			        	$unread = wplc_return_unread_agent_messages( $current_agent, $user->ID );
			        	$a_array[$user->ID] = $unread;
			        	
			        }
			    }
			    $return_array['response'] = "Unread count agents"; /* needs to be exactly this for the JS to fire correctly */
				$return_array['code'] = "200";
				$return_array['data'] = $a_array;

		 	} else {
				$return_array['response'] = "Secret token is invalid";
				$return_array['code'] = "401";
			}
		}else{
			$return_array['response'] = "No secret 'token' found";
			$return_array['code'] = "401";
			$return_array['requirements'] = array("token" => "YOUR_SECRET_TOKEN");
		}
	}else{
		$return_array['response'] = "No request data found";
		$return_array['code'] = "400";
		$return_array['requirements'] = array("token" => "YOUR_SECRET_TOKEN");
	}
	
	return $return_array;
}

function wplc_api_initiate_chat(WP_REST_REQUEST $request) {

	$return_array = array();
	if(isset($request)) {
		if(isset($request['security'])) {
			$check_token = get_option('wplc_api_secret_token');
			if($check_token !== false && $request['token'] === $check_token) {
					if(isset($request['rel']) || isset($request['cid'])) {
						if(isset($request['aid'])) {


							$aid = intval( $request['aid'] );

				            if (isset($request['rel'])) {
				            	$cid = $request['rel'];
				            } else {
				            	$cid = $request['cid'];
				            }

							
							global $wplc_tblname_chats;
							global $wpdb;
						    $results = $wpdb->get_results("SELECT * FROM $wplc_tblname_chats WHERE `rel` = '".$cid."' OR `id` = '".$cid."' LIMIT 1");
						    if (!$results) {
						        /* it doesnt exist, lets put it in the table */
						        print_r($cid);
						        $wpdb->insert( 
						            $wplc_tblname_chats, 
						            array( 
						                'status' => 3, 
						                'timestamp' => current_time('mysql'),
						                'name' => 'Guest',
						                'email' => 'none',
						                'session' => '1',
						                'ip' => '0',
						                'url' => '',
						                'last_active_timestamp' => current_time('mysql'),
						                'other' => '',
						                'agent_id' => $aid,
										'rel' => $cid,
										'leadmsgid' => 'agentinit',
						            ), 
						            array( 
						                '%s', 
						                '%s',
						                '%s',
						                '%s',
						                '%s',
						                '%s',
						                '%s',
						                '%s',
						                '%s',
						                '%d',
										'%s',
										'%s'
						            ) 
						        );
						        
						        
						        $cid = $wpdb->insert_id;
						        do_action("wplc_hook_update_agent_id",$cid,$aid);  
						        //var_dump("DONE!!");  
						    }


				        
						} else {
							$return_array['response'] = "No 'AID' found (base64 encoded)";
							$return_array['code'] = "401";
							$return_array['requirements'] = array(
															"security" => "YOUR_SECRET_TOKEN",
													      	"cid"   => "Chat ID",
													      	"aid"   => "agent ID");
						}				        

					} else {
						$return_array['response'] = "No 'REL' or 'CID' found (base64 encoded)";
						$return_array['code'] = "401";
						$return_array['requirements'] = array(
														"security" => "YOUR_SECRET_TOKEN",
												      	"cid"   => "Chat ID",
												      	"rel/cid"   => "related ID or Chat ID");
					}


					
			 	
		 	} else {
				$return_array['response'] = "Nonce is invalid";
				$return_array['code'] = "401";
			}
		} else {
			$return_array['response'] = "No 'security' found";
			$return_array['code'] = "401";
			$return_array['requirements'] = array(
												"security" => "YOUR_SECRET_TOKEN",
										      	"cid"   => "Chat ID",
										      	"wplc_extra_data"   => "Data array");
		}
	} else {
		$return_array['response'] = "No request data found";
		$return_array['code'] = "400";
		$return_array['requirements'] = array(
											"security" => "YOUR_SECRET_TOKEN",
									      	"cid"   => "Chat ID",
									      	"wplc_extra_data"   => "Data array");
	}
	
	return $return_array;


            

}

function wplc_api_email_notification(WP_REST_Request $request) {
	$return_array = array();
	if(isset($request)){
		if(isset($request['security'])){
			$check_token = get_option('wplc_api_secret_token');
			if($check_token !== false && $request['security'] === $check_token){
				if(isset($request['cid'])){
					if(isset($request['wplc_extra_data'])){
						
						$data = $request['wplc_extra_data'];

						$wplc_acbc_data = get_option("WPLC_ACBC_SETTINGS");
					    if (isset($wplc_acbc_data['wplc_pro_chat_notification']) && $wplc_acbc_data['wplc_pro_chat_notification'] == "yes") {
					    	if (isset($wplc_acbc_data['wplc_pro_chat_email_address'])) { $email_address = $wplc_acbc_data['wplc_pro_chat_email_address']; } else { $email_address = ""; }
					    	if (!$email_address || $email_address == "") { $email_address = get_option('admin_email'); }

					        $subject = sprintf( __( 'Incoming chat from %s (%s) on %s', 'wplivechat' ),
					                $data['name'],
					                $data['email'],
					                get_option('blogname')
					        );

					        $msg = sprintf( __( '%s (%s) wants to chat with you. <br /><br />Log in: %s', 'wplivechat' ),
					                $data['name'],
					                $data['email'],
					                get_option('home')."/wp-login.php"
					        );

					        wplcmail($email_address,"WP Live Chat Support", $subject, $msg);
					    }
					    return true;


					} else {
						$return_array['response'] = "No 'Data' array found (base64 encoded)";
						$return_array['code'] = "401";
						$return_array['requirements'] = array(
														"security" => "YOUR_SECRET_TOKEN",
												      	"cid"   => "Chat ID",
												      	"wplc_extra_data"   => "Data array");
					}


					
			 	} else {
					$return_array['response'] = "No 'CID' found";
					$return_array['code'] = "401";
					$return_array['requirements'] = array(
														"security" => "YOUR_SECRET_TOKEN",
												      	"cid"   => "Chat ID",
												      	"wplc_extra_data"   => "Data array");
				}
		 	} else {
				$return_array['response'] = "Nonce is invalid";
				$return_array['code'] = "401";
			}
		} else{
			$return_array['response'] = "No 'security' found";
			$return_array['code'] = "401";
			$return_array['requirements'] = array(
												"security" => "YOUR_SECRET_TOKEN",
										      	"cid"   => "Chat ID",
										      	"wplc_extra_data"   => "Data array");
		}
	}else{
		$return_array['response'] = "No request data found";
		$return_array['code'] = "400";
		$return_array['requirements'] = array(
											"security" => "YOUR_SECRET_TOKEN",
									      	"cid"   => "Chat ID",
									      	"wplc_extra_data"   => "Data array");
	}
	
	return $return_array;


}


function wplc_api_is_typing(WP_REST_Request $request){
	$return_array = array();
	if(isset($request)){
		if(isset($request['security'])){
			$check_token = get_option('wplc_api_secret_token');
			if($check_token !== false && $request['security'] === $check_token){
				if(isset($request['cid'])){
					if(isset($request['user'])){
						if(isset($request['type'])){
							if (wplc_typing($request['user'],sanitize_text_field($request['cid']),sanitize_text_field($request['type']))) {
								
								$return_array['response'] = "Successful";
								$return_array['code'] = "200";
								$return_array['data'] = array("cid" => intval($request['cid']),
															  "user" => intval($request['user']),
															  "type" => intval($request['type']));
							} else {
								$return_array['response'] = "Failed to send typing indicaator";
								$return_array['code'] = "401";
								$return_array['requirements'] = array("security" => "YOUR_SECRET_TOKEN",
															      "cid"   => "Chat ID",
															      "user"   => "User type",
															      'type' => "TYPE");

							}
						} else {

						$return_array['response'] = "No 'type' found";
						$return_array['code'] = "401";
						$return_array['requirements'] = array("security" => "YOUR_SECRET_TOKEN",
													      "cid"   => "Chat ID",
													      "user"   => "User type",
													      'type' => "TYPE");
						}

				 	} else {
						$return_array['response'] = "No 'user' found";
						$return_array['code'] = "401";
						$return_array['requirements'] = array("security" => "YOUR_SECRET_TOKEN",
													      "cid"   => "Chat ID",
													      "user"   => "User type",
													      'type' => "TYPE");
					}
			 	} else {
					$return_array['response'] = "No 'cid' found";
					$return_array['code'] = "401";
					$return_array['requirements'] = array("security" => "YOUR_SECRET_TOKEN",
												      "cid"   => "Chat ID",
												      "user"   => "User type",
												      'type' => "TYPE");
				}
		 	} else {
				$return_array['response'] = "Nonce is invalid";
				$return_array['code'] = "401";
			}
		} else{
			$return_array['response'] = "No 'security' found";
			$return_array['code'] = "401";
			$return_array['requirements'] = array("security" => "YOUR_SECRET_TOKEN",
										      "cid"   => "Chat ID",
										      "user"   => "User type",
										      'type' => "TYPE");
		}
	}else{
		$return_array['response'] = "No request data found";
		$return_array['code'] = "400";
		$return_array['requirements'] = array("security" => "YOUR_SECRET_TOKEN",
									      "cid"   => "Chat ID",
									      "user"   => "User type",
									      'type' => "TYPE");
	}
	
	return $return_array;
}


function wplc_api_record_agent_chat_msg($from, $cid, $msg, $rest_check = false, $ato = false, $other = false) {
    global $wpdb;
    global $wplc_tblname_msgs;


    
    if( ! filter_var($cid, FILTER_VALIDATE_INT) ) {
        
        /**
         * We need to identify if this CID is a node CID, and if so, return the WP CID from the wplc_chat_msgs table
         */
        $cid = wplc_return_chat_id_by_rel($cid);
    }

    /**
     * check if this CID even exists, if not, create it
     *
     * If it doesnt exist, it most likely is an agent-to-agent chat that we now need to save.
     */
        
    global $wplc_tblname_chats;
    $results = $wpdb->get_results("SELECT * FROM $wplc_tblname_chats WHERE `rel` = '".$cid."' OR `id` = '".$cid."' LIMIT 1");
    if (!$results) {
        /* it doesnt exist, lets put it in the table */
        
        //var_dump("WRITING TO TABLE");
        $wpdb->insert( 
            $wplc_tblname_chats, 
            array( 
                'status' => 3, 
                'timestamp' => current_time('mysql'),
                'name' => 'agent-to-agent chat',
                'email' => 'none',
                'session' => '1',
                'ip' => '0',
                'url' => '',
                'last_active_timestamp' => current_time('mysql'),
                'other' => '',
                'rel' => $cid,
            ), 
            array( 
                '%s', 
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s'
            ) 
        );
        
        
        $cid = $wpdb->insert_id;        
    }

    $msg_id = '';
    if ($other !== false) {
        if (!empty($other->msgID)) {
            $msg_id = $other->msgID;
        } else {
            $msg_id = '';
        }
    }

    $user_info = get_userdata( $from );
	if( $user_info ){
    	$fromname = $user_info->display_name;
    } else {
    	$fromname = 'agent';
    }
    $orig = '1';

    
    $orig_msg = $msg;

    $msg = apply_filters("wplc_filter_message_control",$msg);


    $wpdb->insert( 
    	$wplc_tblname_msgs, 
    	array( 
                'chat_sess_id' => $cid, 
                'timestamp' => current_time('mysql'),
                'msgfrom' => $fromname,
                'msg' => $msg,
                'status' => 0,
                'originates' => $orig,
                'other' => '',
                'rel' => $msg_id,
                'ato' => $ato,
                'afrom' => $from
    	), 
    	array( 
                '%s', 
                '%s',
                '%s',
                '%s',
                '%d',
                '%s',
                '%s',
                '%s',
                '%d',
                '%d'
    	) 
    );
    
    $data = array(
        'cid' => $cid,
        'from' => $from,
        'msg' => $orig_msg,
        'orig' => $orig
    );
    do_action("wplc_hook_message_sent",$data);

    wplc_update_active_timestamp(sanitize_text_field($cid));
    
    
    return true;

}

add_filter("wplc_api_remote_upload_filter", "wplc_api_remote_upload_handler", 10, 2);
/*
 * Processes remote uploads, from app or main agent files as an example
*/
function wplc_api_remote_upload_handler($return_array, $request){
	$remote_files = $request->get_file_params();
	if(is_array($remote_files)){
		$upload_dir = wp_upload_dir();
		$user_dirname = $upload_dir['basedir'];

		if( !file_exists( $user_dirname."/wp_live_chat/" ) ){
			    @mkdir($user_dirname.'/wp_live_chat/');
		}  

		if( !file_exists( $user_dirname."/wp_live_chat/" . $request['cid'] ) ){
			@mkdir($user_dirname.'/wp_live_chat/'.$request['cid']);
		}              

		if (isset($remote_files['file'])) {

			$file_name = strtolower($remote_files['file']['name']);
            $file_name = basename($file_name); //This prevents traversal
		   	
		   	if(!wplc_pro_check_file_name_for_unsafe_extension($file_name)){
           	   if(wplc_pro_check_file_name_for_safe_extension($file_name)){
				   	if( file_exists($user_dirname . "/wp_live_chat/" . $request['cid'] . "/" .  $remote_files['file']['name'] ) ){
				       $file_name = rand(0, 10) . "-" . $file_name;
				   	} 

				   	$file_name = str_replace(" ", "_", $file_name);

				   	if(move_uploaded_file($remote_files['file']['tmp_name'], $user_dirname."/wp_live_chat/" . $request['cid'] . "/" . $file_name)){
				       //$response = $user_dirname."/wp_live_chat/" . $_POST['cid'] . "/" . $file_name;

				   		if(wplc_pro_check_file_mime_type($user_dirname. "/wp_live_chat/" . $request['cid'] . "/" . $file_name)){
					       $response = $upload_dir['baseurl']."/wp_live_chat/" . $request['cid'] . "/" . $file_name;
					      
					       $return_array['response'] = strip_tags($response);
					    } else {
					    	@unlink($user_dirname. "/wp_live_chat/" . $request['cid'] . "/" . $file_name);
					    	 $return_array['response'] = __('Security Violation - MIME Type not allowed', 'wplivechat');
					    }
				  	} else {
				      $return_array['response'] = __('File could not be uploaded', 'wplivechat');
				  	}
			   } else {
			   	 $return_array['response'] = __('Security Violation - Does not match allowed file types', 'wplivechat');
			   }
			} else {
				$return_array['response'] = __('Security Violation - File unsafe', 'wplivechat');
			}

		} else {
			$return_array['response'] = '0';
		}
           
	} else {
		$return_array['response'] = '0';
	}

	return $return_array;
}