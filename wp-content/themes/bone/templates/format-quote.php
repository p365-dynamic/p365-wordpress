<?php
	if ( !isset($thumb_size) ) {
		$thumb_size = 'md_bone_md';
	}

	if ( !function_exists('rwmb_meta') ) {
		if ( has_post_thumbnail() )
			md_article_ftimg( $thumb_size );
		return;
	}
	
	$quote_content = md_bone_get_metabox( 'format_quote_content' );
	if ($quote_content == '') {
		if ( has_post_thumbnail() )
			md_article_ftimg( $thumb_size );
		return;
	}
	
	$quote_author = md_bone_get_metabox( 'format_quote_author' );
	if ( has_post_thumbnail() ) {
		$thumb_id = get_post_thumbnail_id();
		$thumb_url_array = wp_get_attachment_image_src( $thumb_id, 'full', true );
		$thumb_url = $thumb_url_array[0];
	} else {
		$thumb_url = '';
	}
?>
<div class="postFormatMedia postFormatMedia--quote">
	<?php if (!is_single()) { ?>
	<a href="<?php the_permalink(); ?>" class="o-blockLink">
	<?php } ?>
		
		<blockquote class="postFormatQuote">
			<div class="o-backgroundImg o-backgroundImg--dimmed" style="background-color: #fefefe;background-image: url('<?php echo esc_url($thumb_url); ?>');"></div>
			<p><?php echo esc_html($quote_content); ?></p>
			<cite>
				<span class="postFormatQuote-author"><span class="postFormatQuote-author-name metaFont"><strong><?php echo esc_html($quote_author); ?></strong></span></span>
			</cite>
		</blockquote>
	<?php if (!is_single()) { ?>
	</a>
	<?php } ?>
</div>

