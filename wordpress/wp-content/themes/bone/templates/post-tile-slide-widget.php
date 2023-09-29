<?php
	$classes = array(
		'postItem',
		'post--tile',
		'u-hasBackgroundImg'
	);
	if (!isset($thumb_size)) {
		$thumb_size = 'md_bone_md';
	}
	if ( has_post_thumbnail() ) {
		$thumb_id = get_post_thumbnail_id();
		$thumb_url_array = wp_get_attachment_image_src( $thumb_id, $thumb_size, true );
		$thumb_url = $thumb_url_array[0];
	} else {
		$thumb_url = '';
	}
	$article_link =  get_permalink();
?>
<article <?php post_class( $classes ); ?> style="background-image: url('<?php echo esc_url($thumb_url); ?>');">
	<div class="o-overlay"></div>
	<div class="postInfo overlayInfo">
		<?php md_bone_post_category(); ?>
		<h3 class="postTitle entry-title">
			<?php the_title(); ?>
		</h3>
	</div>
	<a href="<?php echo esc_url($article_link); ?>" class="o-overlayLink"></a>
</article>