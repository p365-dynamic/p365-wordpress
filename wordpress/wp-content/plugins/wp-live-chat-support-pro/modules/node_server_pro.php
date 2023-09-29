<?php

add_action("wplc_admin_remoter_dashboard_scripts_localizer", "wplc_admin_remote_dashboard_localize_pro_variables");
/*
 * Localizes all the admin pro variables
*/
function wplc_admin_remote_dashboard_localize_pro_variables(){
    global $wplc_pro_version;
	$wplc_pro_settings = get_option("WPLC_PRO_SETTINGS");

	$user_id = get_current_user_id();
	$user_department = get_user_meta($user_id ,"wplc_user_department", true);

	$department_array = array();
	$departments = wplc_get_all_deparments();
	if($departments){
		foreach($departments as $dep){
			$department_array[$dep->id] = $dep->name;
		}
	}  

	$departments['any'] = __("None", "wplivechat"); 
   	$default_department = isset($wplc_pro_settings['wplc_default_department']) ? $wplc_pro_settings['wplc_default_department'] : 0;

	

	if ( !empty( $department_array ) ) {   
        wp_localize_script( 'wplc-admin-js-agent', 'bleeper_departments', $department_array );

        if(intval($default_department) >= 0){
          wp_localize_script( 'wplc-admin-js-agent', 'bleeper_default_department_tag', $department_array[$default_department] );   
        } else {
          wp_localize_script( 'wplc-admin-js-agent', 'bleeper_default_department_tag', $departments['any'] );
        }
    } else {
        wp_localize_script( 'wplc-admin-js-agent', 'bleeper_departments', ' ' );
        wp_localize_script( 'wplc-admin-js-agent', 'bleeper_default_department_tag', 'any' );   
    }
	wp_localize_script( 'wplc-admin-js-agent', 'bleeper_integration_pro_active', "true");

    if ( !empty( $user_department ) ) {
	   wp_localize_script( 'wplc-admin-js-agent', 'bleeper_agent_department', $user_department);
    }

    if (isset($wplc_pro_settings['wplc_node_disable_typing_preview']) && $wplc_pro_settings['wplc_node_disable_typing_preview'] == '1') {
        wp_localize_script( 'wplc-admin-js-agent', 'bleeper_disable_typing_preview', 'true');
    }   
    if (isset($wplc_pro_settings['wplc_ringtone'])) {
        $wplc_ringtone_selected =  str_replace("http:", "", $wplc_pro_settings['wplc_ringtone'] );
    } else {
        $wplc_ringtone_selected = WPLC_BASIC_PLUGIN_URL.'ring.wav';
    }
	if (isset($wplc_pro_settings['wplc_messagetone'])) {
		$wplc_messagetone_selected =  str_replace("http:", "", $wplc_pro_settings['wplc_messagetone'] );
	} else {
		$wplc_messagetone_selected = WPLC_BASIC_PLUGIN_URL.'ding.mp3';
	}

    wp_localize_script( 'wplc-admin-js-agent', 'bleeper_ring_override', $wplc_ringtone_selected);
	wp_localize_script( 'wplc-admin-js-agent', 'bleeper_message_override', $wplc_messagetone_selected);

	wp_register_script('wplc-admin-chat-events-pro', WPLC_PRO_PLUGIN_URL . 'js/wplc_admin_pro_events.js', array("wplc-admin-js-agent", "wplc-admin-chat-events", "wplc-admin-chat-server"), $wplc_pro_version, false); //Added this for async storage calls
    wp_enqueue_script('wplc-admin-chat-events-pro');

	wp_register_script('wplc-admin-bleeper-event-tracking-pro', WPLC_PRO_PLUGIN_URL . 'js/wplc_bleeper_admin_events.js', array("wplc-admin-js-agent", "wplc-admin-chat-events", "wplc-admin-chat-server"), $wplc_pro_version, false); //Added this for async storage calls
    wp_enqueue_script('wplc-admin-bleeper-event-tracking-pro');




}

add_action("wplc_hook_beta_options_content_inside_table", "wplc_add_node_server_pro_settings_area");
/*
 * Hooks into the node server options, and adds a few Pro Only options
*/
function wplc_add_node_server_pro_settings_area(){
    $wplc_settings = get_option("WPLC_PRO_SETTINGS");
    ?>
    <tr>
       <td width="250" valign="top">
         <label for="wplc_node_disable_typing_preview"><?php _e("Disable Typing Previews","wplivechat"); ?> <i class="fa fa-question-circle wplc_light_grey wplc_settings_tooltip" title="<?php _e('This option disables the typing preview from showing up to agents, which means agents will not be able to see what the user is typing in realtime.', 'wplivechat'); ?>"></i></label>
       </td>
       <td valign="top">
         <input type="checkbox" value="1" name="wplc_node_disable_typing_preview" <?php if (isset($wplc_settings['wplc_node_disable_typing_preview']) && $wplc_settings['wplc_node_disable_typing_preview'] == '1') { echo "checked"; } ?>>
       </td>
    </tr>
    <?php
}

add_filter("wplc_pro_setting_save_filter", "wplc_node_server_pro_settings_save_hook", 12, 1);
/**
 * Save Pro Node Settings settings
*/
function wplc_node_server_pro_settings_save_hook($wplc_data){
    if (isset($_POST['wplc_node_disable_typing_preview'])) { 
        $wplc_data['wplc_node_disable_typing_preview'] = esc_attr($_POST['wplc_node_disable_typing_preview']); 
    } else {
        $wplc_data['wplc_node_disable_typing_preview'] = '0';
    }

    return $wplc_data;
}

add_filter("wplc_admin_dashboard_layout_node_request_variable_filter", "wplc_admin_dashboard_layout_node_request_add_pro_variables", 10, 1);
/*
 * Adds the Pro request variables to our node request
*/
function wplc_admin_dashboard_layout_node_request_add_pro_variables($variables){
	if(is_array($variables)){
		$variables['pro'] = "true";
		$variables['include_filters'] = "true";
		$variables['include_transfers'] = "true";
		$variables['include_media_sharing'] = "true";
		$variables['include_quick_responses'] = "true";
		$variables['include_departments'] = "true";
        $variables['aid'] = get_current_user_id();

		$variables['agent_count'] = wplc_maa_total_agents_online();
	} 
	return $variables;
}



add_filter("wplc_admin_remote_dashboard_localize_tips_array", "wplc_admin_remote_dashboard_localize_tips_array_pro_handler", 1, 1);
/*
 * Overrides the tip array in the Pro add-on
*/
function wplc_admin_remote_dashboard_localize_tips_array_pro_handler($tip_array){
	$tip_array = array(
      "0" => "<p>" . __("You can transfer chats from within a chat by clicking on the in chat menu, and selecting Transfer Chat or Transfer Department", "wplivechat") . "</p>",
      "1" => "<p>" . __("You can share files quickly when in a chat, by simply dragging a file into the chat window!", "wplivechat") . "</p>",
  	  "2" => "<p>" . __("You can now move between chats without ending/closing an open chat", "wplivechat") . "</p>"
    );

    return $tip_array;

}


/**
 * Return a count of unread messages for a specific agent from a specific agent
 *
 * @param  [intval] $ato   Agent ID 
 * @param  [intval] $afrom Agent ID
 * @return [intval]        Count
 */
function wplc_return_unread_agent_messages( $ato = 0, $afrom = 0 ) {
    global $wpdb;
    global $wplc_tblname_msgs;
    $count = $wpdb->get_var( $wpdb->prepare("SELECT count(id) FROM $wplc_tblname_msgs WHERE ato = %d AND afrom = %d AND status = 0",$ato,$afrom) );
    return $count;
}

add_action("wplc_admin_remote_dashboard_above", "wplc_admin_remote_dashboard_quick_responses_container");
/*
 * Adds the quick response container
*/
function wplc_admin_remote_dashboard_quick_responses_container(){

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

    echo '<div id="quick_response_drawer_container" style="display:none;">';
    echo     '<h5>'.__("Quick Responses", "wplivechat").'</h5>';
    echo    '<hr>';         
     //Add quick responses
    if($posts_array){
        foreach ($posts_array as $post) {
            echo '<div class="quick_response_item">'.$post->post_content.'</div>';
        }
    } else {
        echo "<div style='position: absolute; top: 23px; bottom: 0; left: 10px; right: 0; margin: auto; height: 20px;'>";
        echo __("No quick responses found", "wplivechat") . " - <a target='_blank' href='" . admin_url('post-new.php?post_type=wplc_quick_response') . "'>" . __("Add New Quick Response", "wplivechat") . "</a>"; 
        echo "</div>";
    }

    echo '</div>';
}

add_action("wplc_hook_admin_menu_layout_display_top", "wplc_node_basic_compat_version_check", 1);
/*
 * Checks if current Pro is compatible with node basic, if not, show notice, and localize scripts needed for conflict free execution
*/
function wplc_node_basic_compat_version_check(){
    global $wplc_version;
    $wplc_ver = str_replace('.', '', $wplc_version);
    $checker = intval($wplc_ver); 
    if ($checker < 8000) { 
         ?>
            <div class='update-nag' style='margin-top:5px;margin-bottom:5px'>
                <p><strong><?php _e("WP Live Chat Support - Update Suggested", "wplivechat") ?></strong></p>
                <p><?php _e("We have detected that you are using a heavily out-dated version of WP Live Chat Support", "wplivechat") ?> (<?php echo $wplc_version; ?>)</p>
                <p><?php _e("It is highly recommended that you update to version 8 or above. ", "wplivechat"); ?></p>
            </div>
        <?php
    }
}

add_filter("wplc_agent_display_name_filter", "wplc_agent_display_name_filter_control", 10, 1);
/*
 * Filters the agent display name 
*/
function wplc_agent_display_name_filter_control($wplc_display_name){
    $settings = get_option("WPLC_ACBC_SETTINGS");
    
    if( isset( $settings['wplc_use_wp_name'] ) && $settings['wplc_use_wp_name'] == '1' ){
        return $wplc_display_name;
        
    } else {
        if (!empty($settings['wplc_chat_name'])) {
            $wplc_display_name = $settings['wplc_chat_name'];
        }
    }

    return $wplc_display_name;

}

add_action("wplc_admin_remote_dashboard_styles_hook", "wplc_admin_remote_dashboard_styles_pro");
/**
 * Loads remote dashboard styles
 *
 * @return void
*/
function wplc_admin_remote_dashboard_styles_pro(){
    $wplc_pro_settings = get_option("WPLC_PRO_SETTINGS");

    if (isset($wplc_pro_settings['wplc_disable_initiate_chat'])  && $wplc_pro_settings['wplc_disable_initiate_chat'] == '1' ) { 
        $initiate_chat_inline_styles = 
            "
            .init_chat {
                display:none !important;
            }
            ";

        wp_add_inline_style( 'wplc-admin-style', $initiate_chat_inline_styles );
    } 

    $wplc_choose_settings = get_option("WPLC_CHOOSE_SETTINGS");
    if(!isset($wplc_choose_settings['wplc_auto_online']) || $wplc_choose_settings['wplc_auto_online'] != 1) {
        //Hide the selectionator
        $choose_online_chat_inline_styles = 
            "
            #choose_online { display: none; }
            ";

        wp_add_inline_style( 'wplc-admin-style', $choose_online_chat_inline_styles );
    }

}