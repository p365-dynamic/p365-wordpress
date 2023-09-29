<?php 

/* Handles all routes related to the WP Live Chat Support API */


add_action('rest_api_init', 'wplc_pro_rest_routes_init');
function wplc_pro_rest_routes_init() {
	register_rest_route('wp_live_chat_support/v1','/typing', array(
						'methods' => 'GET, POST',
						'callback' => 'wplc_api_is_typing'
	));
	register_rest_route('wp_live_chat_support/v1','/new-chat', array(
						'methods' => 'GET, POST',
						'callback' => 'wplc_api_email_notification'
	));

	register_rest_route('wp_live_chat_support/v1', '/get_agent_unread_message_counts', array(
						'methods' => 'GET, POST',
						'callback' => 'wplc_api_get_agent_unread_message_counts'
	));
	register_rest_route('wp_live_chat_support/v1', '/send_agent_message', array(
						'methods' => 'GET, POST',
						'callback' => 'wplc_api_send_agent_message'
	));
	register_rest_route('wp_live_chat_support/v1', '/initiate_chat', array(
						'methods' => 'GET, POST',
						'callback' => 'wplc_api_initiate_chat'
	));
	do_action("wplc_api_route_hook");
}