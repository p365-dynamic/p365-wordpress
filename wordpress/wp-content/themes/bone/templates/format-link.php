<?php
	if ( !isset($article_size) ) {
		$article_size = 'md_bone_md';
	}

	if ( !function_exists('rwmb_meta') ) {
		if ( has_post_thumbnail() )
			md_article_ftimg( $article_size );
		return;
	}
	
	$link_url = md_bone_get_metabox( 'format_link_url' );
	$link_title = md_bone_get_metabox( 'format_link_title' );
	if ( $link_title == '' ) {
		$link_title = get_the_title();
	}
	$link_desc = md_bone_get_metabox( 'format_link_desc' );
	if ( has_post_thumbnail() ) {
		$thumb_id = get_post_thumbnail_id();
		$thumb_url_array = wp_get_attachment_image_src( $thumb_id, 'full', true );
		$thumb_url = $thumb_url_array[0];
	} else {
		$thumb_url = '';
	}
?>
<?php if ( $link_url != '' ) { ?>
<div class="postFormatMedia postFormatMedia--link">
	<a target="_blank" href="<?php echo esc_url($link_url); ?>" class="postFormatLink">
		<div class="o-backgroundImg o-backgroundImg--dimmed" style="background-image: url('<?php echo esc_url($thumb_url); ?>');"></div>
		<div class="postFormatLink-content">
			<h3 class="postFormatLink-content-title titleFont"><?php if ( $link_title != '' ) { echo esc_html($link_title).' '; } else { echo esc_url($link_url).' '; } ?><i class="fa fa-external-link-square"></i></h3>
			<span class="postFormatLink-content-desc"><?php echo esc_html($link_desc); ?></span>
		</div>
	</a>
</div>
<?php }
