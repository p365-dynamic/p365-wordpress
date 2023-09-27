<?php
	$header_layout = md_bone_get_option('header-layout', 'standard');
	$feat_layout = md_bone_get_option('feat-layout', 'slider');
	if ( ($feat_layout == 'slider-cover') && (is_front_page() && ($header_layout != 'minimal') ) ) {
		$header_layout = 'compact';
	}
	get_template_part( 'templates/header-'.$header_layout );

	if ((is_single()) && (get_post_type() == 'post')) get_template_part('templates/featured-ribbon' );
