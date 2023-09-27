<?php
	if ( function_exists('rwmb_meta') ) {
		if ( !isset($thumb_size) ) {
			$thumb_size = 'md_bone_md';
		}
		$images = md_bone_get_metabox( 'format_image_file', '', 'type=image&size=full' );
		if (!empty($images)) {
			$image = reset($images);
			$image_alt = $image['alt'];
			$image_title = $image['title'];
			$image_caption = $image['caption'];
			$image_description = $image['description'];
			$image_url = $image['full_url'];
			$image_width = $image['width'];
			$image_height = $image['height'];

			$thumbs = md_bone_get_metabox( 'format_image_file', '', 'type=image&size=full' );
			if (!empty($thumbs)) {
				$thumb = reset($thumbs);
				$thumb_url = $thumb['url'];
			}
			
		} else if ( has_post_thumbnail() ) {
			$thumb_id = get_post_thumbnail_id();
			$args = array(
				'p' => $thumb_id,
				'post_type' => 'attachment'
			);
			$thumb_image = get_posts($args);
			if ($thumb_image && isset($thumb_image[0])) {
				$image_alt = get_post_meta($thumb_id, '_wp_attachment_image_alt', true);
				$image_title = $thumb_image[0]->post_title;
				$image_caption = $thumb_image[0]->post_excerpt;
				$image_description = $thumb_image[0]->post_content;
			}
			
			$image_src = wp_get_attachment_image_src( $thumb_id, 'full' );
			$image_url = $image_src[0];
			$image_width = $image_src[1];
			$image_height = $image_src[2];
			
			if ( !isset($thumb_size) ) {
				$thumb_size = 'md_bone_md';
			}
			$thumb_src = wp_get_attachment_image_src( $thumb_id, $thumb_size );
			$thumb_url = $thumb_src[0];
			$thumb_width = $thumb_src[1];
			$thumb_height = $thumb_src[2];
		} else {
			return;
		}
	} else {
		if ( has_post_thumbnail() ) {
			$thumb_id = get_post_thumbnail_id();
			$args = array(
				'p' => $thumb_id,
				'post_type' => 'attachment'
			);
			$thumb_image = get_posts($args);
			if ($thumb_image && isset($thumb_image[0])) {
				$image_alt = get_post_meta($thumb_id, '_wp_attachment_image_alt', true);
				$image_title = $thumb_image[0]->post_title;
				$image_caption = $thumb_image[0]->post_excerpt;
				$image_description = $thumb_image[0]->post_content;
			}
			
			$image_src = wp_get_attachment_image_src( $thumb_id, 'full' );
			$image_url = $image_src[0];
			$image_width = $image_src[1];
			$image_height = $image_src[2];
			
			if ( !isset($thumb_size) ) {
				$thumb_size = 'md_bone_md';
			}
			$thumb_src = wp_get_attachment_image_src( $thumb_id, $thumb_size );
			$thumb_url = $thumb_src[0];
			$thumb_width = $thumb_src[1];
			$thumb_height = $thumb_src[2];
		} else {
			return;
		}
	}
	
?>
<div class="postFormatMedia postFormatMedia--image postFormatImage" itemscope itemtype="http://schema.org/ImageGallery">
    <figure itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
          <img src="<?php echo esc_url($thumb_url); ?>" itemprop="thumbnail" alt="<?php echo esc_attr($image_alt); ?>" class="js-imageZoom"/>
      <?php if ($image_caption !== '') { ?>
      <figcaption itemprop="caption description" class="metaFont"><?php echo esc_html($image_caption); ?></figcaption>
      <?php } ?>
    </figure>
</div>