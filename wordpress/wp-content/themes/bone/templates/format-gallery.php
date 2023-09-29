<?php
	if ( !isset($thumb_size) ) {
		$thumb_size = 'md_bone_md';
	}
			
	if ( !function_exists('rwmb_meta') ) {
		if ( has_post_thumbnail() ) {
			md_article_ftimg( $thumb_size );
		}
		return;
	}
	
	$gallery_files = md_bone_get_metabox( 'format_gallery_files', '', 'type=image&size=full' );
	$gallery_slider_opts = md_bone_get_metabox('gallery_slider_opts');
	$gallery_navthumb = '';
	$gallery_transition = '';
	if (is_array($gallery_slider_opts)) {
		if ( array_key_exists('gallery_navthumb', $gallery_slider_opts) ) {
			$gallery_navthumb = ( $gallery_slider_opts['gallery_navthumb'] == '1' ) ? 'thumbs' : '' ;
		}
		if ( array_key_exists('gallery_transition', $gallery_slider_opts) ) {
			$gallery_transition = ( $gallery_slider_opts['gallery_transition'] == 'fade' ) ? 'crossfade' : 'slide' ;
		}
	}
?>
<?php if ( !empty($gallery_files) ) { ?>
	<div class="fotorama postFormatMedia postFormatMedia--gallery" itemscope itemtype="http://schema.org/ImageGallery" data-width="100%" data-ratio="1.5" data-allowfullscreen="true" data-transition="<?php echo esc_attr($gallery_transition); ?>"<?php if ($gallery_navthumb) echo ' data-nav="'.esc_attr($gallery_navthumb).'"'; ?>>
		<?php
		foreach ( $gallery_files as $image ) {
			$thumb_id = $image['ID'];
			$thumb_src = wp_get_attachment_image_src( $thumb_id, 'md_bone_sm' );
			$thumb_url = $thumb_src[0];
		?>

    	<a href="<?php echo esc_url($image['url']); ?>" itemprop="contentUrl" data-size="<?php echo esc_attr($image['width']).'x'.esc_attr($image['height']); ?>">
        	<img src="<?php echo esc_url($thumb_url); ?>" itemprop="thumbnail" alt="<?php echo esc_attr($image['alt']); ?>" />
    	</a>

		<?php } ?>
	</div>
<?php } elseif ( has_post_thumbnail() ) {
	md_article_ftimg( $thumb_size );
}