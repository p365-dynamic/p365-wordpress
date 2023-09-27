<?php
	$classes = array(
		'postItem',
		'post--tile',
		'post--tile--micro',
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
	$category_array = get_the_category();
	if ( $category_array ) {
		$category_id = $category_array[0]->term_id;
		$category_name = esc_attr( $category_array[0]->name );
		$category_link = esc_url( get_category_link( $category_id ) );
	}
	$article_link =  get_permalink();
?>
<article <?php post_class( $classes ); ?> style="background-image: url('<?php echo esc_url($thumb_url); ?>');">
	<div class="o-overlay"></div>
	<div class="postInfo overlayInfo">			
		<h3 class="postTitle entry-title">
			<?php the_title(); ?>
		</h3>
		<div class="metaText metaDate"><abbr class="published updated" title="<?php the_time(get_option( 'date_format' )); ?>"><?php md_bone_human_datetime(); ?></abbr></div>	
	</div>
	<a href="<?php echo esc_url($article_link); ?>" class="o-overlayLink"></a>
</article>