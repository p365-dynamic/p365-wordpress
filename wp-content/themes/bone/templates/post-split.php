<?php
	$post_class = array(
		'postItem',
		'post--split'
	);
	$article_link =  get_permalink();
	$author_avatar = get_avatar( get_the_author_meta( 'ID' ), 50, '', esc_html__( 'avatar', 'bone' ) );
	$format = md_bone_get_post_format();
	$format_allowed = in_array($format, array( 'quote', 'audio', 'aside', 'link', 'video', 'gallery', 'image' ));
	$has_header = in_array($format, array( '', 'video', 'gallery', 'audio', 'image' ));
	$has_excerpt = in_array($format, array( '', 'video', 'gallery', 'audio', 'image', 'aside', 'status', 'chat', 'link' ));
?>
<article <?php post_class( $post_class ); ?>>
	
	<?php if ($has_header) { ?>
	<header class="postHeader">
		<?php md_bone_post_category(); ?>
		<h3 class="postTitle entry-title">
			<a href="<?php echo esc_url($article_link); ?>" rel="bookmark"><?php the_title(); ?></a>
			<?php md_bone_review_score_badge(); ?>
			<?php if ( is_sticky() ) echo '<span class="featuredBadge"><i class="fa fa-thumb-tack"></i>&nbsp;'.esc_html__('Sticky', 'bone').'</span>'; ?>
		</h3>
	</header>
	<?php } ?>
	
	<?php if ($format_allowed) { ?>
		<?php md_bone_post_format('md_bone_xl'); ?>
	<?php } else { ?>
		<?php if(has_post_thumbnail()) { ?>
		<div class="postFeaturedImg u-ratio3to1 o-imageCropper">
			<?php the_post_thumbnail('md_bone_xl' ); ?>
			<?php md_bone_format_icon(); ?>
			<a href="<?php echo esc_url($article_link); ?>" class="o-overlayLink"></a>
		</div>
		<?php } ?>
	<?php } ?>
	
	<div class="postInfo">
		<div class="u-floatLeft">
			<?php md_bone_post_meta_author('2', 30); ?>
		</div>
	
		<div class="o-media-body">
			<div class="postSummary entry-content">
				<p><?php md_bone_excerpt(40); ?></p>
			</div>
		</div>
	</div>

	<div class="postFooter">
		<?php md_bone_post_meta_btn('2'); ?>
	</div>

</article>