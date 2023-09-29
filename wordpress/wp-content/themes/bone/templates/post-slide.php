<?php
	$classes = array(
		'postItem',
		'post--slide',
		'u-hasBackgroundImg'
	);
	if (!isset($thumb_size)) {
		$thumb_size = 'full';
	}
	$article_link =  get_permalink();
	$fw = false;
	if ( isset( $fw_feat ) ) {
		$fw = $fw_feat;
	}
	$hidpi = $fw;
?>
<article <?php post_class( $classes ); ?>>
	<div class="o-backgroundImg o-backgroundImg--dimmed" <?php md_bone_inline_css_background_img($thumb_size, $hidpi); ?>></div>
	<?php if ( $fw ) echo '<div class="container">'; ?>
	<div class="postInfo overlayInfo<?php if ( $fw ) echo ' container'; ?>">
		<?php md_bone_post_category(); ?>
		<h3 class="postTitle entry-title">
			<?php the_title(); ?>
		</h3>
		<?php md_bone_post_meta_author('1', 24); ?>
	</div>
	<a href="<?php echo esc_url($article_link); ?>" class="o-overlayLink"></a>
	<?php if ( $fw ) echo '</div>'; ?>
</article>