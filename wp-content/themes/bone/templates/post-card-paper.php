<?php
	$classes = array(
		'postItem',
		'post--card',
		'post--card--paper',
	);			
	$category_array = get_the_category();
	if ( $category_array ) {
		$category_id = $category_array[0]->term_id;
		$category_name = esc_attr( $category_array[0]->name );
		$category_link = esc_url( get_category_link( $category_id ) );
	}
	$article_link =  get_permalink();
	$format = md_bone_get_post_format();
	$format_allowed = in_array($format, array( 'image', 'quote', 'aside', 'link' ));
	$has_header = in_array($format, array( '', 'video', 'gallery', 'audio', 'image'));
	$has_summary = in_array($format, array( '', 'video', 'gallery', 'audio', 'image', 'aside', 'chat', 'status'));
	if (!isset($thumb_size)) {
		$thumb_size = 'md_bone_md';
	}
?>
<article <?php post_class( $classes ); ?>>
	<?php if ($has_header) { ?>
	<?php md_bone_post_meta_author('1', 24); ?>
	<h3 class="postTitle entry-title">
		<a href="<?php echo esc_url($article_link); ?>" rel="bookmark"><?php the_title(); ?></a>
		<?php md_bone_review_score_badge(); ?>
		<?php if ( is_sticky() ) echo '<span class="featuredBadge"><i class="fa fa-thumb-tack"></i>&nbsp;'.esc_html__('Sticky', 'bone').'</span>'; ?>
	</h3>
	<?php } ?>

	<?php
	if ($format_allowed) {
			md_bone_post_format($thumb_size);
	} elseif ( has_post_thumbnail() ) { ?>
	<div class="postFeaturedImg u-ratio2to1 o-imageCropper">
		<?php the_post_thumbnail($thumb_size); ?>
		<?php md_bone_format_icon(); ?>
		<a href="<?php echo esc_url($article_link); ?>" class="o-overlayLink"></a>
	</div>
	<?php } ?>
	
	<?php if ($has_summary) { ?>
	<div class="postSummary entry-content">
		<?php md_bone_post_category(); ?>
		<p><?php md_bone_excerpt(20); ?></p>
	</div>
	<?php } ?>
	
	<div class="postFooter">
		<?php md_bone_post_meta_btn('3'); ?>
	</div>

</article>