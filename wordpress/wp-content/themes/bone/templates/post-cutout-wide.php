<?php
	$classes = array(
		'postItem',
		'post--cutout',
		'post--cutout--wide',
		'u-hasBackgroundImg',
		'u-wideBlock--content'
	);
	if (!isset($thumb_size)) {
		$thumb_size = 'md_bone_xxl';
	}

	$category_array = get_the_category();
	if ( $category_array ) {
		$category_id = $category_array[0]->term_id;
		$category_name = esc_attr( $category_array[0]->name );
		$category_link = esc_url( get_category_link( $category_id ) );
	}
	$article_link =  get_permalink();
?>
<article <?php post_class( $classes ); md_bone_inline_css_background_img($thumb_size); ?>>
	<div class="u-contentAlign">
		<div class="postInfo">
		
			<?php md_bone_post_category(); ?>

			<h3 class="postTitle entry-title">
				<a href="<?php echo esc_url($article_link); ?>"><?php echo md_bone_truncate(get_the_title(), 100); ?></a>
				<?php
				md_bone_format_badge();
				md_bone_review_score_badge();
				if ( is_sticky() ) echo '<span class="featuredBadge"><i class="fa fa-thumb-tack"></i>&nbsp;'.esc_html__('Sticky', 'bone').'</span>';
				?>
			</h3>

			<?php md_bone_post_meta_author('1', 24); ?>

			<div class="postFooter">
				<?php md_bone_post_meta_btn('3'); ?>
			</div>
		</div>
	</div>
</article>