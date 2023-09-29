<?php
	$classes = array(
		'postItem',
	);
	if ( has_post_thumbnail() ) {
		$thumb_id = get_post_thumbnail_id();
		$thumb_url_array = wp_get_attachment_image_src( $thumb_id, 'md_bone_md', true );
		$thumb_url = $thumb_url_array[0];
	} else {
		$thumb_url = '';
	}
	$article_link =  get_permalink();
?>
<article <?php post_class( $classes ); ?>>
	<div class="o-backgroundImg o-backgroundImg--dimmed" style="background-image: url('<?php echo esc_url($thumb_url); ?>');">
	</div>
	<div class="postInfo overlayInfo">
		<?php md_bone_post_category(); ?>
		<h3 class="postTitle entry-title">
			<a href="<?php echo esc_url($article_link); ?>"><?php the_title(); ?></a>
		</h3>
		<span class="metaText metaDate"><abbr class="published updated" title="<?php the_time(get_option( 'date_format' )); ?>"><?php md_bone_human_datetime(); ?></abbr></span>
	</div>
	<a href="<?php echo esc_url($article_link); ?>" class="o-overlayLink"></a>
</article>