<?php
	$classes = array(
		'postItem',
		'post--tile',
		'post--tile--large',
		'u-hasBackgroundImg'
	);
	if (!isset($thumb_size)) {
		$thumb_size = 'md_bone_xl';
	}
	$category_array = get_the_category();
	if ( $category_array ) {
		$category_id = $category_array[0]->term_id;
		$category_name = esc_attr( $category_array[0]->name );
		$category_link = esc_url( get_category_link( $category_id ) );
	}
	$article_link =  get_permalink();
	$format = get_post_format();
	$has_header = in_array($format, array( '', 'video', 'gallery', 'audio', 'image', 'status' ));
	if (!isset($title_limit)) {
		$title_limit = 120;
	}
?>
<article <?php post_class( $classes ); md_bone_inline_css_background_img($thumb_size); ?>>
	
	<div class="postInfo overlayInfo u-floorFade">
		<?php md_bone_post_category(); ?>

		<h3 class="postTitle entry-title">
			<?php echo md_bone_truncate(get_the_title(), $title_limit); ?>
			<?php
			md_bone_review_score_badge();
			if ( is_sticky() ) echo '<span class="featuredBadge"><i class="fa fa-thumb-tack"></i>&nbsp;'.esc_html__('Sticky', 'bone').'</span>';
			?>
		</h3>

		<?php md_bone_post_meta_author('1', 24); ?>

		<div class="postSummary entry-content hidden-xs">
			<p><?php md_bone_excerpt(32, true); ?></p>
		</div>

		<div class="postFooter">
			<?php md_bone_post_meta_btn('2'); ?>
		</div>
	</div>
	
	<?php md_bone_format_icon(); ?>
	
	<a href="<?php echo esc_url($article_link); ?>" class="o-overlayLink"></a>
</article>