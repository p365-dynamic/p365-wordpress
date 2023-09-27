<?php 

add_filter("wplc_api_device_quick_response_filter", "wplc_api_device_pro_get_quick_responses", 10, 2);
/*
 * Returns quick responses for the app - Pro
*/
function wplc_api_device_pro_get_quick_responses($return_array, $request){
	$return_array = array();
	if(isset($request)){
		if(isset($request['token'])){
			$check_token = get_option('wplc_node_server_secret_token');
			if($check_token !== false && $request['token'] === $check_token){
				$args = array(
			        'posts_per_page' => -1,
			        'offset' => 0,
			        'category' => '',
			        'order' => 'DESC',
			        'orderby' => 'post_title',
			        'include' => '',
			        'exclude' => '',
			        'meta_key' => '',
			        'meta_value' => '',
			        'post_type' => 'wplc_quick_response',
			        'post_mime_type' => '',
			        'post_parent' => '',
			        'post_status' => 'publish',
			        'suppress_filters' => true);

				$posts_array = get_posts($args);


				$quick_responses = "";
			    foreach ($posts_array as $post) {
			        $quick_responses .= $post->post_content . "||||";
			    }

			    $return_array['response'] = $quick_responses;
				$return_array['code'] = "200";

		 	} else {
				$return_array['response'] = "Token is invalid";
				$return_array['code'] = "401";
			}
		}else{
			$return_array['response'] = "No secret 'token' found";
			$return_array['code'] = "401";
			$return_array['requirements'] = array("token" => "YOUR_SECRET_TOKEN",
										      "device_id"   => "Device ID",
										      "agent_id"   => "Agent ID");
		}
	}else{
		$return_array['response'] = "No request data found";
		$return_array['code'] = "400";
		$return_array['requirements'] = array("token" => "YOUR_SECRET_TOKEN",
										  "device_id"   => "Device ID",
										  "agent_id"   => "Agent ID");
	}
	
	return $return_array;
}

add_filter("wplc_api_device_limitation_filter", "wplc_api_device_limitation_pro", 10, 1);
/*
 * Filters the limitation variable to ensure the limitation is now pro
*/
function wplc_api_device_limitation_pro($limitation){
	return "pro";
}


add_filter("wplc_api_device_list_departments_filter", "wplc_api_device_pro_get_departments", 10, 2);
/*
 * Returns quick responses for the app - Pro
*/
function wplc_api_device_pro_get_departments($return_array, $request){
	$return_array = array();
	if(isset($request)){
		if(isset($request['token'])){
			$check_token = get_option('wplc_node_server_secret_token');
			if($check_token !== false && $request['token'] === $check_token){
				if(function_exists('wplc_get_all_deparments')){
					$departments = wplc_get_all_deparments();

					$json_array = array();

					foreach ($departments as $key => $dep) {
						$json_array[$dep->id] = $dep->name;
					}

                	$return_array['response'] = json_encode($json_array);
					$return_array['code'] = "200";
				} else {
					$return_array['response'] = "Get All Departments Function does not exist";
					$return_array['code'] = "401";
				}

		 	} else {
				$return_array['response'] = "Token is invalid";
				$return_array['code'] = "401";
			}
		}else{
			$return_array['response'] = "No secret 'token' found";
			$return_array['code'] = "401";
			$return_array['requirements'] = array("token" => "YOUR_SECRET_TOKEN",
										      "device_id"   => "Device ID",
										      "agent_id"   => "Agent ID");
		}
	}else{
		$return_array['response'] = "No request data found";
		$return_array['code'] = "400";
		$return_array['requirements'] = array("token" => "YOUR_SECRET_TOKEN",
										  "device_id"   => "Device ID",
										  "agent_id"   => "Agent ID");
	}
	
	return $return_array;
}

add_filter("wplc_api_device_remote_upload_filter", "wplc_api_device_remote_upload_handler", 10, 2);
/*
 * Processes remote uploads, from app or main agent files as an example
*/
function wplc_api_device_remote_upload_handler($return_array, $request){
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
		   
		   	if( file_exists($user_dirname . "/wp_live_chat/" . $request['cid'] . "/" .  $remote_files['file']['name'] ) ){
		       $file_name = rand(0, 10) . "-" . $remote_files['file']['name'];
		   	} else {
		       $file_name = $remote_files['file']['name'];
		   	}

		   	if(move_uploaded_file($remote_files['file']['tmp_name'], $user_dirname."/wp_live_chat/" . $request['cid'] . "/" . $file_name)){
		       //$response = $user_dirname."/wp_live_chat/" . $_POST['cid'] . "/" . $file_name;
		       $response = $upload_dir['baseurl']."/wp_live_chat/" . $request['cid'] . "/" . $file_name;
		       
		       $return_array['response'] = strip_tags($response);
		  	} else {
		      $return_array['response'] = '0';
		  	}

		} else {
			$return_array['response'] = '0';
		}
           
	} else {
		$return_array['response'] = '0';
	}

	return $return_array;
}

add_filter("wplc_api_device_online_agents_list_filter", "wplc_api_device_online_agents_list_handler", 10, 1);
/*
 * Returns list of agents
*/
function wplc_api_device_online_agents_list_handler($content){
	$user_array = get_users(array(
        'meta_key' => 'wplc_ma_agent',
    ));
	$a_array = array();
    if ($user_array) {
        foreach ($user_array as $user) {
        	$a_array[$user->ID] = array();
        	$a_array[$user->ID]['name'] = $user->display_name;
        	$a_array[$user->ID]['md5'] = md5( $user->user_email );
        }
    }

    return $a_array;
}