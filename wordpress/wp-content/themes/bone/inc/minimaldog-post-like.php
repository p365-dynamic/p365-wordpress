<?php
/*
Name:  WordPress Post Like System
Description:  A simple and efficient post like system for WordPress.
Version:      0.4
Author:       Jon Masterson
Author URI:   http://jonmasterson.com/

License:
Copyright (C) 2014 Jon Masterson
*/

/**
 * Save like data
 */
add_action( 'wp_ajax_nopriv_minimaldog_post_like', 'minimaldog_post_like' );
add_action( 'wp_ajax_minimaldog_post_like', 'minimaldog_post_like' );

if ( !function_exists('minimaldog_post_like') ){
	function minimaldog_post_like() {
		$nonce = $_POST['nonce'];
	    if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) )
	        die ();
		
		if ( isset( $_POST['minimaldog_post_like'] ) ) {
		
			$post_id = $_POST['post_id']; // post id
			$post_like_count = get_post_meta( $post_id, "minimaldog_post_like_count", true ); // post like count
			
			if ( function_exists ( 'wp_cache_post_change' ) ) { // invalidate WP Super Cache if exists
				$GLOBALS["super_cache_enabled"]=1;
				wp_cache_post_change( $post_id );
			}
			
			if ( is_user_logged_in() ) { // user is logged in
				$user_id = get_current_user_id(); // current user
				$meta_POSTS = get_user_option( "minimaldog_liked_posts", $user_id  ); // post ids from user meta
				$meta_USERS = get_post_meta( $post_id, "minimaldog_user_liked" ); // user ids from post meta
				$liked_POSTS = NULL; // setup array variable
				$liked_USERS = NULL; // setup array variable
				
				if ( count( $meta_POSTS ) != 0 ) { // meta exists, set up values
					$liked_POSTS = $meta_POSTS;
				}
				
				if ( !is_array( $liked_POSTS ) ) // make array just in case
					$liked_POSTS = array();
					
				if ( count( $meta_USERS ) != 0 ) { // meta exists, set up values
					$liked_USERS = $meta_USERS[0];
				}		

				if ( !is_array( $liked_USERS ) ) // make array just in case
					$liked_USERS = array();
					
				$liked_POSTS['post-'.$post_id] = $post_id; // Add post id to user meta array
				$liked_USERS['user-'.$user_id] = $user_id; // add user id to post meta array
				$user_likes = count( $liked_POSTS ); // count user likes
		
				if ( !minimaldog_already_liked( $post_id ) ) { // like the post
					update_post_meta( $post_id, "minimaldog_user_liked", $liked_USERS ); // Add user ID to post meta
					update_post_meta( $post_id, "minimaldog_post_like_count", ++$post_like_count ); // +1 count post meta
					update_user_option( $user_id, "minimaldog_liked_posts", $liked_POSTS ); // Add post ID to user meta
					update_user_option( $user_id, "minimaldog_user_like_count", $user_likes ); // +1 count user meta
					echo esc_html($post_like_count); // update count on front end

				} else { // unlike the post
					$pid_key = array_search( $post_id, $liked_POSTS ); // find the key
					$uid_key = array_search( $user_id, $liked_USERS ); // find the key
					unset( $liked_POSTS[$pid_key] ); // remove from array
					unset( $liked_USERS[$uid_key] ); // remove from array
					$user_likes = count( $liked_POSTS ); // recount user likes
					update_post_meta( $post_id, "minimaldog_user_liked", $liked_USERS ); // Remove user ID from post meta
					update_post_meta($post_id, "minimaldog_post_like_count", --$post_like_count ); // -1 count post meta
					update_user_option( $user_id, "minimaldog_liked_posts", $liked_POSTS ); // Remove post ID from user meta			
					update_user_option( $user_id, "minimaldog_user_like_count", $user_likes ); // -1 count user meta
					echo "already".esc_html($post_like_count); // update count on front end
					
				}
				
			} else { // user is not logged in (anonymous)
				$ip = $_SERVER['REMOTE_ADDR']; // user IP address
				$meta_IPS = get_post_meta( $post_id, "minimaldog_user_IP" ); // stored IP addresses
				$liked_IPS = NULL; // set up array variable
				
				if ( count( $meta_IPS ) != 0 ) { // meta exists, set up values
					$liked_IPS = $meta_IPS[0];
				}
		
				if ( !is_array( $liked_IPS ) ) // make array just in case
					$liked_IPS = array();
					
				if ( !in_array( $ip, $liked_IPS ) ) // if IP not in array
					$liked_IPS['ip-'.$ip] = $ip; // add IP to array
				
				if ( !minimaldog_already_liked( $post_id ) ) { // like the post
					update_post_meta( $post_id, "minimaldog_user_IP", $liked_IPS ); // Add user IP to post meta
					update_post_meta( $post_id, "minimaldog_post_like_count", ++$post_like_count ); // +1 count post meta
					echo esc_html($post_like_count); // update count on front end
					
				} else { // unlike the post
					$ip_key = array_search( $ip, $liked_IPS ); // find the key
					unset( $liked_IPS[$ip_key] ); // remove from array
					update_post_meta( $post_id, "minimaldog_user_IP", $liked_IPS ); // Remove user IP from post meta
					update_post_meta( $post_id, "minimaldog_post_like_count", --$post_like_count ); // -1 count post meta
					echo "already".esc_html($post_like_count); // update count on front end
					
				}
			}
		}
		
		exit;
	}
}

/**
 * Test if user already liked post
 */
if ( !function_exists('minimaldog_already_liked') ){
	function minimaldog_already_liked( $post_id ) { // test if user liked before
		if ( is_user_logged_in() ) { // user is logged in
			$user_id = get_current_user_id(); // current user
			$meta_USERS = get_post_meta( $post_id, "minimaldog_user_liked" ); // user ids from post meta
			$liked_USERS = ""; // set up array variable
			
			if ( count( $meta_USERS ) != 0 ) { // meta exists, set up values
				$liked_USERS = $meta_USERS[0];
			}
			
			if( !is_array( $liked_USERS ) ) // make array just in case
				$liked_USERS = array();
				
			if ( in_array( $user_id, $liked_USERS ) ) { // True if User ID in array
				return true;
			}
			return false;
			
		} else { // user is anonymous, use IP address for voting
		
			$meta_IPS = get_post_meta( $post_id, "minimaldog_user_IP" ); // get previously voted IP address
			$ip = $_SERVER["REMOTE_ADDR"]; // Retrieve current user IP
			$liked_IPS = ""; // set up array variable
			
			if ( count( $meta_IPS ) != 0 ) { // meta exists, set up values
				$liked_IPS = $meta_IPS[0];
			}
			
			if ( !is_array( $liked_IPS ) ) // make array just in case
				$liked_IPS = array();
			
			if ( in_array( $ip, $liked_IPS ) ) { // True is IP in array
				return true;
			}
			return false;
		}
	}
}

/**
 * Front end button
 */
if ( !function_exists('minimaldog_post_like_btn') ){
	function minimaldog_post_like_btn( $post_id ) {
		$like_count = get_post_meta( $post_id, "minimaldog_post_like_count", true ); // get post likes
		if ( empty( $like_count ) || $like_count == "0" ) {
			$count = '<span class="hidden-xs">&nbsp;'.esc_html__('Like', 'bone').'</span>';
		} elseif ($like_count == "1") {
			$count = '&nbsp;'.esc_attr( $like_count ).'<span class="hidden-xs">&nbsp;'.esc_html__('like', 'bone').'</span>';
		} else {
			$count = '&nbsp;'.esc_attr( $like_count ).'<span class="hidden-xs">&nbsp;'.esc_html__('likes', 'bone').'</span>';
		}
		if ( minimaldog_already_liked( $post_id ) ) {
			$class = esc_attr( ' liked' );
			$title = esc_attr( esc_html__('Unlike', 'bone') );
			$heart = '<i class="fa fa-heart"></i>';
		} else {
			$class = esc_attr( '' );
			$title = esc_attr( esc_html__('Like', 'bone') );
			$heart = '<i class="fa fa-heart-o"></i>';
		}
		$output = '<a href="#" class="metaLink metaFont mdPostLike js-mdPostLike'.$class.'" data-post_id="'.$post_id.'" title="'.$title.'">'.$heart.$count.'</a>';
		return $output;
	}
}

/**
 * Front end button compact
 */
if ( !function_exists('minimaldog_post_like_btn_compact') ){
	function minimaldog_post_like_btn_compact( $post_id ) {
		$like_count = get_post_meta( $post_id, "minimaldog_post_like_count", true ); // get post likes
		$count = ( empty( $like_count ) || $like_count == "0" ) ? '' : '&nbsp;'.esc_attr( $like_count );
		if ( minimaldog_already_liked( $post_id ) ) {
			$class = esc_attr( ' liked' );
			$title = esc_attr( esc_html__('Unlike', 'bone') );
			$heart = '<i class="fa fa-heart"></i>';
		} else {
			$class = esc_attr( '' );
			$title = esc_attr( esc_html__('Like', 'bone') );
			$heart = '<i class="fa fa-heart-o"></i>';
		}
		$output = '<a href="#" class="metaLink metaFont mdPostLike mdPostLike--compact js-mdPostLike'.$class.'" data-post_id="'.$post_id.'" title="'.$title.'">'.$heart.$count.'</a>';
		return $output;
	}
}

/**
 * Front end button single
 */
if ( !function_exists('minimaldog_post_like_btn_single') ){
	function minimaldog_post_like_btn_single( $post_id ) {
		$like_count = get_post_meta( $post_id, "minimaldog_post_like_count", true ); // get post likes
		$count = ( empty( $like_count ) || $like_count == "0" ) ? '<span>&nbsp;'.esc_html__('Like', 'bone').'</span>' : '&nbsp;'.esc_attr( $like_count );
		if ( minimaldog_already_liked( $post_id ) ) {
			$class = esc_attr( ' liked' );
			$title = esc_attr( esc_html__('Unlike', 'bone') );
			$heart = '<i class="fa fa-heart"></i>';
		} else {
			$class = esc_attr( '' );
			$title = esc_attr( esc_html__('Like', 'bone') );
			$heart = '<i class="fa fa-heart-o"></i>';
		}
		$output = '<a href="#" class="metaLink metaFont mdPostLike mdPostLike--compact js-mdPostLike'.$class.'" data-post_id="'.$post_id.'" title="'.$title.'">'.$heart.$count.'</a>';
		return $output;
	}
}

/**
 * Front end count
 */
if ( !function_exists('minimaldog_post_like_count') ){
	function minimaldog_post_like_count( $post_id, $icon_style = 'line' ) {
		$like_count = get_post_meta( $post_id, "minimaldog_post_like_count", true ); // get post likes
		if ( empty( $like_count ) || $like_count == "0" ) {
			return;
		} elseif ($like_count == "1") {
			$count = '&nbsp;'.esc_attr( $like_count ).'<span class="hidden-xs">&nbsp;'.esc_html__('like', 'bone').'</span>';
		} else {
			$count = '&nbsp;'.esc_attr( $like_count ).'<span class="hidden-xs">&nbsp;'.esc_html__('likes', 'bone').'</span>';
		}
		if ( $icon_style == 'line' ) {
			$heart = '<i class="fa fa-heart-o"></i>';
		} else {
			$heart = '<i class="fa fa-heart"></i>';
		}
		$output = '<span class="metaLink metaFont mdPostLike">'.$heart.$count.'</span>';
		return $output;
	}
}

/**
 * Retrieve User Likes and Show on Profile
 */
add_action( 'show_user_profile', 'minimaldog_show_user_likes' );
add_action( 'edit_user_profile', 'minimaldog_show_user_likes' );

if ( !function_exists('minimaldog_show_user_likes') ){
	function minimaldog_show_user_likes( $user ) { ?>        
	    <table class="form-table">
	        <tr>
				<th><label for="user_likes"><?php esc_html_e( 'Posts You Like:', 'bone' ); ?></label></th>
				<td>
	            <?php
				$user_likes = get_user_option( "minimaldog_liked_posts", $user->ID );
				if ( !empty( $user_likes ) && count( $user_likes ) > 0 ) {
					$the_likes = $user_likes;
				} else {
					$the_likes = '';
				}
				if ( !is_array( $the_likes ) )
				$the_likes = array();
				$count = count( $the_likes ); 
				$i=0;
				if ( $count > 0 ) {
					$like_list = '';
					echo "<ul>\n";
					foreach ( $the_likes as $the_like ) {
						$i++;
						$like_list .= "<li><a href=\"" . esc_url( get_permalink( $the_like ) ) . "\" title=\"" . esc_attr( get_the_title( $the_like ) ) . "\">" . get_the_title( $the_like ) . "</a></li>\n";
						if ($count != $i) $like_list .= "\n";
						else $like_list .= "</ul>\n";
					}
					echo wp_kses_post($like_list);
				} else {
					echo "<p>" . esc_html_e( 'You haven\'t liked anything yet.', 'bone' ) . "</p>\n";
				} ?>
	            </td>
			</tr>
	    </table>
	<?php }
}

/**
 * Output number of posts a user has liked
 */
if ( !function_exists('minimaldog_user_likes_count') ){
	function minimaldog_user_likes_count($user_id = null) {
		$like_list = '';
		if ($user_id === null) $user_id = get_query_var( 'author' );
		if ( $user_id ) { $user = get_user_by( 'id', $user_id ); }
		$user_likes = get_user_option( "minimaldog_liked_posts", $user_id );
		if ( !empty( $user_likes ) && count( $user_likes ) > 0 ) {
			$the_likes = $user_likes;
		} else {
			$the_likes = '';
		}
		if ( !is_array( $the_likes ) )
			$the_likes = array();
		$count = count( $the_likes );
		echo esc_html($count);
	}
}

/**
 * Outputs a list of the 4 posts with the most user likes for ALL TIME of a specific user
 */
if ( !function_exists('minimaldog_user_most_popular_post') ){
	function minimaldog_user_most_popular_post() {
		global $post;
		$user_id = get_query_var( 'author' );
		$args = array(
			 'post_type' => array( 'post'),
			 'author' => $user_id,
			 'meta_key' => 'minimaldog_post_like_count',
			 'orderby' => 'meta_value_num',
			 'order' => 'DESC',
			 'posts_per_page' => 4
			 );
		$pop_posts = new WP_Query( $args );
		if ( $pop_posts->have_posts() ) {?>
		<div class="authorMostLikedPosts">
			<div class="blockDivider metaFont"><span><?php esc_html_e( 'Most Popular Posts', 'bone' ); ?></span></div>
			<ul class="u-noStyleList">
		<?php
			$nth = 1;
			$orderby = 'meta_value_num';
			while ( $pop_posts->have_posts() ) {	
				$pop_posts->the_post();
				echo '<li>';
				require(locate_template('templates/post-list-bg.php'));
				echo "</li>";
				$nth++;
			}?>
			</ul>
		</div>
		<?php
		}
		wp_reset_postdata();
	}
}