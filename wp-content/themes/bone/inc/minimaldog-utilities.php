<?php
/**
 * Action callback: Add meta tags such as Google Authorship
 */
if ( !function_exists('md_bone_add_header_meta') ){
	function md_bone_add_header_meta(){
		if (is_single()) {
	        global $post;

	        // open graph meta
	        $excerpt = wp_trim_words( $post->post_content, 30, '...' );
	        echo '<meta property="og:site_name" content="' .  esc_attr(get_bloginfo('name')) . '" />';
	        echo '<meta property="og:title" content="' .  esc_attr($post->post_title) . '" />';
	        echo '<meta property="og:type" content="article" />';
	        echo '<meta property="og:description" content="' . esc_attr($excerpt) . '" />';
	        echo '<meta property="og:url" content="' .  esc_url(get_permalink( $post->ID )) . '" />';
	        if (has_post_thumbnail($post->ID)) {
	            $post_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'md_bone_xxl' );
	            if (!empty($post_image[0])) {
	                echo '<meta property="og:image" content="' .  esc_attr($post_image[0]) . '" />';
	                echo '<meta property="og:image:url" content="' .  esc_attr($post_image[0]) . '" />';
	            }
	        }

	        // Twitter card
	        $twitter_url = md_bone_get_option('twitter-url', '');
	        $twitter_id = explode("/", $twitter_url);
			$twitter_id = end($twitter_id);
	        echo '<meta name="twitter:card" content="summary_large_image" />';
			echo '<meta name="twitter:site" content="@' .  esc_attr($twitter_id) . '" />';
			echo '<meta name="twitter:title" content="' .  esc_attr($post->post_title) . '" />';
			echo '<meta name="twitter:description" content="' . esc_attr($excerpt) . '" />';
			echo '<meta name="twitter:url" content="' .  esc_url(get_permalink( $post->ID )) . '" />';
			if (has_post_thumbnail($post->ID)) {
	            $post_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'md_bone_xxl' );
	            if (!empty($post_image[0])) {
	                echo '<meta name="twitter:image" content="' .  esc_attr($post_image[0]) . '" />';
	            }
	        }

	        // show author meta tag on single pages
	        $post_author = get_the_author_meta('display_name', $post->post_author);
	        if ($post_author) {
	            echo '<meta name="author" content="'.esc_attr($post_author).'">'."\n";
	        }

	        // Google authorship
	        $gplus = get_the_author_meta('gplus', $post->post_author);
			
			if ($gplus) {
				echo '<link href="' . esc_url($gplus) .'" rel="author" />';
			}
	    }

	    // fav icon support
	    if ( ! function_exists( 'has_site_icon' ) || ! has_site_icon() ) {
		    $favicon = md_bone_get_option('favicon', NULL);
			if ( $favicon != NULL ) {
				if ( $favicon['url'] == '' ) { $favicon = NULL; }
			}
			if ( $favicon ) {
				echo '<link rel="shortcut icon" href="'.esc_url($favicon['url']).'" />';
			}
	    }
	}
}
add_filter('wp_head', 'md_bone_add_header_meta', 1);

/**
 * Add social links to user's profile
 */
if ( !function_exists('md_bone_contact_methods') ){
	function md_bone_contact_methods( $contactmethods ) {

		$contactmethods['twitter']   = 'Twitter Username';
		$contactmethods['facebook']  = 'Facebook Username';
		$contactmethods['google']    = 'Google Plus Username';
		$contactmethods['tumblr']    = 'Tumblr Username';
		$contactmethods['instagram'] = 'Instagram Username';
		$contactmethods['pinterest'] = 'Pinterest Username';

		return $contactmethods;
	}
}
add_filter('user_contactmethods','md_bone_contact_methods',10,1);

/**
 * Display date time in human readable format
 */
if ( !function_exists('md_bone_human_datetime') ) {
	function md_bone_human_datetime( $day_limit = 7 ){
		$post_time = get_the_time('U');
		$human_time = '';

		$time_now = date('U');

		// use human time if less than $day_limit days ago (14 days by default)
		// 60 seconds * 60 minutes * 24 hours * $day_limit days
		if ( $post_time > $time_now - ( 60 * 60 * 24 * $day_limit ) ) {
			$human_time = sprintf( esc_html__( '%s ago', 'bone'), human_time_diff( $post_time, current_time( 'timestamp' ) ) );
		} else {
			$human_time = get_the_date();
		}

		echo esc_html($human_time);
	}
}

/**
 * Add custom post class
 */
if ( !function_exists('md_bone_post_class_filter') ){
	function md_bone_post_class_filter( $classes ) {
		global $post;
		if ( !has_post_thumbnail( $post->ID ) ) {
			$classes[] = 'noThumb';
		}
		return $classes;
	}
}
add_filter( 'post_class', 'md_bone_post_class_filter' );

function truncate($string,$length=100,$append="&hellip;") {
  $string = trim($string);

  if(strlen($string) > $length) {
    $string = wordwrap($string, $length);
    $string = explode("\n", $string, 2);
    $string = $string[0] . $append;
  }

  return $string;
}

/**
 * Custom post title word limit
 */
if ( !function_exists('md_bone_title') ){
	function md_bone_title($limit = 20, $echo = true) {
		if ($echo) {
			echo wp_trim_words(get_the_title(), $limit);
		} else {
			return wp_trim_words(get_the_title(), $limit);	
		}
	    
	}
}

/**
 * Custom string character limit, truncate at word
 */
if ( !function_exists('md_bone_truncate') ){
	function md_bone_truncate( $string, $limit = 100) {
		if(mb_strlen($string, 'utf-8') >= $limit){
			$string = mb_substr($string, 0, $limit - 5, 'utf-8').'&hellip;';
		}
		return $string;
	}
}

/**
 * Custom post excerpt word limit
 */
if ( !function_exists('md_bone_excerpt') ){
	function md_bone_excerpt($limit = 20, $echo = true) {
		if ($echo) {
			echo wp_trim_words(get_the_excerpt(), $limit);
		} else {
			return wp_trim_words(get_the_excerpt(), $limit);
		}  
	}
}

/**
 * Custom post content word limit
 */
if ( !function_exists('md_bone_content') ){
	function md_bone_content($limit = 80, $echo = true) {
		$content = explode(' ', get_the_content(), $limit);
		if (count($content)>=$limit) {
			array_pop($content);
			$content = implode(" ",$content).'&#8230;';
		} else {
			$content = implode(" ",$content);
		}
		$content = preg_replace('/[.+]/','', $content);
		$content = apply_filters('the_content', $content);
		$content = str_replace(']]>', ']]&gt;', $content);

		if ($echo) {
			echo wp_kses_post($content);
		} else {
			return wp_kses_post($content);
		}
	}
}

/**
 * Read more link
 */
if ( !function_exists( 'md_bone_content_more_link' ) ) {
	function md_bone_content_more_link( $more ){
		$link = sprintf( '<div class="articleReadMore"><a href="%1$s" class="articleReadMore-link btn btn--pill">%2$s</a></div>',
			esc_url( get_permalink( get_the_ID() ) ),
			sprintf( esc_html__( 'Continue reading %s', 'bone' ), '<span class="sr-only">' . get_the_title( get_the_ID() ) . '</span>' )
			);
		return $link;
	}
}
add_filter( 'the_content_more_link', 'md_bone_content_more_link' );
	
/**
 * Prevent scroll on read more link
 */
if ( !function_exists( 'md_bone_remove_more_link_scroll' ) ) {
	function md_bone_remove_more_link_scroll( $link ){
		$link = preg_replace( '|#more-[0-9]+|', '', $link );
		return $link;
	}
}
add_filter( 'the_content_more_link', 'md_bone_remove_more_link_scroll' );

/**
 * Add responsive container to embeds video
 */
if ( !function_exists('md_bone_embed_html') ){
	function md_bone_embed_html( $embed, $url = '', $attr = '' ) {
		$accepted_providers = array(
			'youtube',
			'vimeo',
			'slideshare',
			'dailymotion',
			'viddler.com',
			'hulu.com',
			'blip.tv',
			'revision3.com',
			'funnyordie.com',
			'wordpress.tv',
		);
		$resize = false;

		// Check each provider
		foreach ( $accepted_providers as $provider ) {
			if ( strstr( $url, $provider ) ) {
				$resize = true;
				break;
			}
		}
		if ( $resize ) {
	    	return '<div class="responsiveEmbedVideo">' . $embed . '</div>';
	    } else {
	    	return $embed;
	    }
	}
}
add_filter( 'embed_oembed_html', 'md_bone_embed_html', 10, 3 );
add_filter( 'video_embed_html', 'md_bone_embed_html' ); // Jetpack

/**
 * Limit number of tags in widget tag cloud
 */
if ( !function_exists('md_bone_tag_widget_limit') ) {
	function md_bone_tag_widget_limit($args){

		//Check if taxonomy option inside widget is set to tags
		if(isset($args['taxonomy']) && $args['taxonomy'] == 'post_tag'){
			$args['number'] = 16; //Limit number of tags
			$args['smallest'] = 12; //Size of lowest count tags
			$args['largest'] = 12; //Size of largest count tags
			$args['unit'] = 'px'; //Unit of font size
			$args['orderby'] = 'count'; //Order by counts
			$args['order'] = 'DESC';
		}

		return $args;
	}
}
add_filter('widget_tag_cloud_args', 'md_bone_tag_widget_limit');

/**
 * Edit default category widget html
 */
if ( !function_exists('md_bone_add_span_cat_count') ) {
	function md_bone_add_span_cat_count($links){
		$links = str_replace('</a> (', '<span>', $links);
		$links = str_replace(')', '</span></a>', $links);
		return $links;
	}
}
add_filter('wp_list_categories', 'md_bone_add_span_cat_count');

/**
 * Generate data-hidpi attribute
 */
if ( !function_exists('md_bone_inline_css_background_img') ) {
	function md_bone_inline_css_background_img($thumb_size = '', $hidpi = true){
		$thumb_url = '';
		$thumb_2x_url = '';
		if ( has_post_thumbnail() ) {
			$thumb_id = get_post_thumbnail_id();
			$thumb_url_array = wp_get_attachment_image_src( $thumb_id, $thumb_size, true );
			$thumb_url = $thumb_url_array[0];
			$high_resolution = md_bone_get_option('high-resolution-switch', '0');
			if (($high_resolution === '1') && $hidpi) {
				$thumb_2x_url = pathinfo($thumb_url, PATHINFO_DIRNAME).'/'.pathinfo($thumb_url, PATHINFO_FILENAME).'@2x.'.pathinfo($thumb_url, PATHINFO_EXTENSION);
			}
		}
		echo ' style="background-image: url('.esc_url($thumb_url).');"';
		if (($thumb_2x_url !== '') && (md_bone_URL_exists($thumb_2x_url))) {
			echo ' data-hidpi="'.esc_url($thumb_2x_url).'"';
		}
	}
}

/**
 * Check if an URL exists
 */
if ( !function_exists('md_bone_URL_exists') ) {
	function md_bone_URL_exists($url){
		$accepted_status_codes = array(200, 301, 302);
		$response = wp_remote_get("{$url}");
			$response_code = wp_remote_retrieve_response_code($response);
			if (in_array($response_code, $accepted_status_codes)) {
			return true;
		} else {
			return false;
		}
	}
}

/**
 * Only use 'hentry' on single post
 */
if ( !function_exists('md_bone_remove_hentry') ) {
	function md_bone_remove_hentry( $classes, $class, $post_id ) {
	 	$classes = array_diff( $classes, array( 'hentry' ) );
	    return $classes;
	}
}
add_filter( 'post_class', 'md_bone_remove_hentry', 10, 3 );

/**
 * Add custom classes to post
 */
if ( !function_exists('md_bone_post_class') ) {
	function md_bone_post_class( $class = '', $post_id = null  ) {
		$post_class = get_post_class( '', $post_id );
		$post_class = array_merge($class, $post_class);
		echo 'class="' . join( ' ', $post_class ) . '"';
	}
}

/**
 * Disqus comments link
 */
if ( function_exists('dsq_comment') ) {
	add_filter( 'get_comments_link', 'md_bone_disqus_comments_link', 10, 3 );
}

if ( !function_exists('md_bone_disqus_comments_link') ) {
	function md_bone_disqus_comments_link( $link) {
		$link = substr($link, 0, strpos($link, '#'));
	    $link .= '#disqus_thread';
	    return $link;
	}
}