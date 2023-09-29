<?php
	$classes = array(
		'postItem',
		'post--card',
		'post--card--paper',
		'post--card--paper--micro'
	);			
	$category_array = get_the_category();
	if ( $category_array ) {
		$category_id = $category_array[0]->term_id;
		$category_name = esc_attr( $category_array[0]->name );
		$category_link = esc_url( get_category_link( $category_id ) );
	}
	$article_link =  get_permalink();
	if (!isset($thumb_size)) {
		$thumb_size = 'md_bone_md';
	}
?>
<article <?php post_class( $classes ); ?>>
	<?php if ( has_post_thumbnail() ) { ?>
	<div class="postFeaturedImg u-ratio2to1 o-imageCropper">
		<?php the_post_thumbnail($thumb_size); ?>
		<?php md_bone_format_icon(); ?>
		<a href="<?php echo esc_url($article_link); ?>" class="o-overlayLink"></a>
	</div>
	<?php } ?>
	<h3 class="postTitle entry-title">
		<a href="<?php echo esc_url($article_link); ?>" rel="bookmark"><?php the_title(); ?></a>
	</h3>
	<div class="metaText metaDate"><abbr class="published updated" title="<?php the_time(get_option( 'date_format' )); ?>"><?php md_bone_human_datetime(); ?></abbr></div>
</article>