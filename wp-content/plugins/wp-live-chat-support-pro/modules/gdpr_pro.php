<?php

/**
 * Pro Add-on's GDPR Module
 * 
 * Extends the GDPR functionality where applicable in Pro
*/

add_action('wplc_gdpr_page_before_table_hook', 'wplc_gdpr_pro_page_before_table_notice');
/**
 * Adds a small notice stating that the pro is active, and ratings will also be removed as/where needed
*/
function wplc_gdpr_pro_page_before_table_notice(){
	?>
	<br><small><em>* <?php _e("Pro is active - Deleting a chat will resilt in user experience ratings being deleted along with chat data", 'wplivechat'); ?></em></small>
	<?php
}

add_filter('wplc_gdpr_retention_cron_notice_extender_hook', 'wplc_gdpr_pro_cron_notice_extender', 10, 1);
/**
 * Adds additional info to the cron notice about data being removed in the cron
*/
function wplc_gdpr_pro_cron_notice_extender($content){
	$content .= "<p>" . __('Pro data will also be removed as a part of this automatic process.', 'wplivechat') . "</p>";
	return $content;
}

add_action('wplc_cron_delete_chats_extender', 'wplc_gdpr_pro_cron_extended_delete', 10, 1);
/**
 * Extends the cron in the basic GDPR module, to delete ratings
*/
function wplc_gdpr_pro_cron_extended_delete($days_ago){
	global $wpdb, $wplc_tblname_chat_ratings;
	$results_ratings = $wpdb->get_results("DELETE FROM $wplc_tblname_chat_ratings WHERE `timestamp` < '$days_ago'", ARRAY_A);
}

add_action('wplc_gdpr_delete_chat_extend_hook', 'wplc_gdpr_pro_delete_chat_data', 10, 2);
/**
 * Handles manual deleting of chat data, specifically focused to the Pro add-on
*/
function wplc_gdpr_pro_delete_chat_data($filter_type, $cid){
	global $wpdb, $wplc_tblname_chat_ratings;
	if($filter_type === 'chat_session'){
		$wpdb->delete($wplc_tblname_chat_ratings, array('cid' => $cid));
	}
}

add_filter('wplc_gdpr_download_chat_extender_hook', 'wplc_gdpr_pro_download_chat_data', 10, 2);
/**
 * Handles added the rating data to the download JSON array
*/
function wplc_gdpr_pro_download_chat_data($chat_session, $cid){
	global $wpdb, $wplc_tblname_chat_ratings;

	if(is_array($chat_session)){
		$result_chat_rating = $wpdb->get_results("SELECT * FROM $wplc_tblname_chat_ratings WHERE `cid` = '$cid'", ARRAY_A);
		if(count($result_chat_rating) > 0){
		  $chat_session['rating'] = $result_chat_rating[0];
		}
	}

	return $chat_session;
}