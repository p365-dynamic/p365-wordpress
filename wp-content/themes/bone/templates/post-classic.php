<?php
	$post_class = array(
		'postItem',
		'post--classic'
	);		
	$category_array = get_the_category();
	if ( $category_array ) {
		$category_id = $category_array[0]->term_id;
		$category_name = esc_attr( $category_array[0]->name );
		$category_link = esc_url( get_category_link( $category_id ) );
	}
	$article_link =  get_permalink();
	$author_avatar = get_avatar( get_the_author_meta( 'ID' ), 50, '', esc_html__( 'avatar', 'bone' ) );
	$format = md_bone_get_post_format();
	$has_title = in_array($format, array( '', 'video', 'gallery', 'audio', 'image', 'quote', 'link'));
?>
<article <?php post_class( $post_class ); ?>>
		
		<?php
		if ($format == '') {
			md_bone_featured_img('md_bone_xl');
		} else {
			md_bone_post_format('md_bone_xl');
		} ?>
		
		<header class="postHeader">
			<?php md_bone_post_categories(); ?>
			<?php if ($has_title) { ?>
			<h3 class="postTitle entry-title">
				<a href="<?php echo esc_url($article_link); ?>" rel="bookmark"><?php the_title(); ?></a>
				<?php md_bone_review_score_badge(); ?>
				<?php if ( is_sticky() ) echo '<span class="featuredBadge"><i class="fa fa-thumb-tack"></i>&nbsp;'.esc_html__('Sticky', 'bone').'</span>'; ?>
			</h3>
			<?php } ?>
			<?php md_bone_post_meta('3'); ?>
		</header>

		<?php if (get_the_content() !== '') { ?>
		<div class="postContent bodyCopy entry-content">
			<?php the_content(); ?>
		</div>

		<?php md_bone_post_pagination(); ?>

		<?php } ?>

		<?php md_bone_single_footer(); ?>
	
</article>