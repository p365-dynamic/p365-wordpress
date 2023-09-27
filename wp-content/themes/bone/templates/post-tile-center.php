<?php
	$classes = array(
		'postItem',
		'post--tile',
		'post--tile--center',
		'u-hasBackgroundImg'
	);
	if (!isset($thumb_size)) {
		$thumb_size = 'md_bone_lg';
	}			
	$category_array = get_the_category();
	if ( $category_array ) {
		$category_id = $category_array[0]->term_id;
		$category_name = esc_attr( $category_array[0]->name );
		$category_link = esc_url( get_category_link( $category_id ) );
	}
	$article_link =  get_permalink();
?>
<article <?php post_class( $classes ); ?>>
	<div class="o-backgroundImg o-backgroundImg--dimmed" <?php md_bone_inline_css_background_img($thumb_size); ?>></div>
	<div class="postInfo overlayInfo">
		<?php md_bone_post_category(); ?>
		<h3 class="postTitle entry-title">
			<?php the_title(); ?>
		</h3>
		<?php md_bone_post_meta_author('1', 24); ?>
	</div>
	<a href="<?php echo esc_url($article_link); ?>" class="o-overlayLink"></a>
</article>