<?php
	$post_class = array(
		'postItem',
		'post--list',
		'clearfix'
	);
	
	$article_link =  get_permalink();
	$author_avatar = get_avatar( get_the_author_meta( 'ID' ), 50, '', esc_html__( 'avatar', 'bone' ) );
	$format = md_bone_get_post_format();
	$format_allowed = in_array($format, array( 'quote', 'aside', 'link' ));
	$has_header = in_array($format, array( '', 'video', 'gallery', 'audio', 'image' ));
	$has_excerpt = in_array($format, array( '', 'video', 'gallery', 'audio', 'image', 'aside', 'status', 'chat' ));
?>
<article <?php post_class( $post_class ); ?>>
	
		<?php
			if ($format_allowed) {
				md_bone_post_format('md_bone_sm');
			} else {
				md_bone_featured_img('md_bone_sm', '', true);
			}
		?>

		<div class="postInfo">
			<?php if ($has_header) { ?>
				<?php md_bone_post_category(); ?>
				<h3 class="postTitle entry-title">
					<a href="<?php echo esc_url($article_link); ?>" rel="bookmark"><?php the_title(); ?></a>
					<?php md_bone_review_score_badge(); ?>
					<?php if ( is_sticky() ) echo '<span class="featuredBadge"><i class="fa fa-thumb-tack"></i>&nbsp;'.esc_html__('Sticky', 'bone').'</span>'; ?>
				</h3>
			<?php } ?>

			<?php md_bone_post_meta_author('1', 24); ?>

			<?php if (!$format_allowed) { ?>
				<div class="visible-xs">
				<?php md_bone_featured_img('md_bone_sm', '', true); ?>
				</div>
			<?php } ?>
			
			<?php if (get_the_excerpt()) { ?>
			<div class="postSummary entry-content">
				<p><?php md_bone_excerpt(24); ?></p>
			</div>
			<?php } ?>

			<div class="postFooter">
				<?php md_bone_post_meta_btn('2'); ?>
			</div>
		</div>
	
</article>