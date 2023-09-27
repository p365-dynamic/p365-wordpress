<?php


    class WPH_conflict_handle_wp_rocket
        {
                        
            static function init()
                {
                    if( !   self::is_plugin_active())
                        return FALSE;
                    
                    add_action('wp',        array('WPH_conflict_handle_wp_rocket', 'wpcache') , -1);    
                }                        
            
            static function is_plugin_active()
                {
                    
                    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
                    
                    if(is_plugin_active( 'wp-rocket/wp-rocket.php' ))
                        return TRUE;
                        else
                        return FALSE;
                }
            
            static public function wpcache()
                {   
                                        
                    //only on front side
                    if(is_admin() && ! defined( 'DOING_AJAX' ) )
                        return;
                    
                    if( defined( 'DOING_AJAX' ) && DOING_AJAX )
                        return;
                        
                    if ( ! isset( $_SERVER['REQUEST_METHOD'] ) || $_SERVER['REQUEST_METHOD'] != 'GET' )
                        return;

                    
                    global $wph;
                    
                    //if loged in and not using 'cache_logged_user' leave the default plugin ob callback
                    $wp_rocket_options = get_option( WP_ROCKET_SLUG );
                    $cache_logged_user  =   isset($wp_rocket_options['cache_logged_user'])  ?   $wp_rocket_options['cache_logged_user'] :   '';
                    if (is_user_logged_in() && empty( $cache_logged_user ) )
                        return;                         

                    $request_uri = explode( '?', $_SERVER['REQUEST_URI'] );
                    $request_uri = reset(( $request_uri ));

                    // Don't cache disallowed extensions
                    if ( strtolower( $_SERVER['REQUEST_URI'] ) != '/index.php' && in_array( pathinfo( $request_uri, PATHINFO_EXTENSION ), array( 'php', 'xml', 'xsl' ) ) ) 
                        return;
                    
                    //query GET
                    if ( ! empty( $_GET )
                        && ( ! isset( $_GET['utm_source'], $_GET['utm_medium'], $_GET['utm_campaign'] ) )
                        && ( ! isset( $_GET['utm_expid'] ) )
                        && ( ! isset( $_GET['fb_action_ids'], $_GET['fb_action_types'], $_GET['fb_source'] ) )
                        && ( ! isset( $_GET['gclid'] ) )
                        && ( ! isset( $_GET['permalink_name'] ) )
                        && ( ! isset( $_GET['lp-variation-id'] ) )
                        && ( ! isset( $_GET['lang'] ) )
                        && ( ! isset( $_GET['s'] ) )
                        && ( ! isset( $_GET['age-verified'] ) )
                        && ( ! isset( $rocket_cache_query_strings ) || ! array_intersect( array_keys( $_GET ), $rocket_cache_query_strings ) )
                    ) 
                        {
                            return;
                        }
                    
                    
                    
                    $rocket_cache_search = apply_filters( 'rocket_cache_search', false );
                    
                    if (    function_exists( 'is_404' ) && is_404()    )
                        return;
                    
                    if ( function_exists( 'is_search' ) && is_search() || $rocket_cache_search) // Don't cache search results
                        return;    
                        
                    if ( defined( 'DONOTCACHEPAGE' ) )    
                        return;
                    
                    
                    add_filter( 'rocket_buffer', array( 'WPH_conflict_handle_wp_rocket', 'set_cache_possible_write_marker'), 999 );
                    
                    
                               
                }
            
            /**
            * reenable the ob_start_Callback
            *     
            */
            static public function set_cache_possible_write_marker( $buffer )
                {
                    
                    global $wph;
                    
                    if ( apply_filters( 'do_rocket_generate_caching_files', true ) )
                        add_filter('wp-hide/ob_start_callback',        array('WPH_conflict_handle_wp_rocket', 'save_correct_cache') , 999);
                    
                    return $buffer;
                    
                }
       
       
            static public function save_correct_cache( $buffer )
                {
                    global $request_uri_path, $rocket_cache_filepath, $is_nginx;
                    
                    
                    // Create cache folders of the request uri.
                    rocket_mkdir_p( $request_uri_path );

                    $footprint  =   '';

                    // Save the cache file.
                    rocket_put_content( $rocket_cache_filepath, $buffer . $footprint );

                    if ( get_rocket_option( 'do_caching_mobile_files' ) ) {
                        if ( $is_nginx ) {
                            // Create a hidden empty file for mobile detection on NGINX with the Rocket NGINX configuration.
                            $nginx_mobile_detect_file = $request_uri_path . '/.mobile-active';

                            if ( ! rocket_direct_filesystem()->exists( $nginx_mobile_detect_file ) ) {
                                rocket_direct_filesystem()->touch( $nginx_mobile_detect_file );
                            }
                        }
                    }

                    if ( function_exists( 'gzencode' ) ) {
                        rocket_put_content( $rocket_cache_filepath . '_gzip', gzencode( $buffer . $footprint, apply_filters( 'rocket_gzencode_level_compression', 3 ) ) );
                    }

                    // Send headers with the last modified time of the cache file.
                    /*
                    if ( file_exists( $rocket_cache_filepath ) ) {
                        header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s', filemtime( $rocket_cache_filepath ) ) . ' GMT' );
                    }    
                    */
                    
                    return $buffer;
                       
                }
                            
        }


?>