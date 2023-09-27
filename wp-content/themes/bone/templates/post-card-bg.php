<?php
	$classes = array(
		'postItem',
		'post--card--bg',
	);			
	$category_array = get_the_category();
	if ( $category_array ) {
		$category_id = $category_array[0]->term_id;
		$category_name = esc_attr( $category_array[0]->name );
		$category_link = esc_url( get_category_link( $category_id ) );
	}
	$article_link = get_permalink();
	if ( has_post_thumbnail() ) {
		$thumb_id = get_post_thumbnail_id();
		$thumb_url_array = wp_get_attachment_image_src( $thumb_id, 'md_bone_md', true );
		$thumb_url = $thumb_url_array[0];
	} else {
		$thumb_url = '';
		$classes[] = 'noThumb';
	}
?>
<article <?php post_class( $classes ); ?>>
	<?php if ( $thumb_url ) { ?>
	<div class="o-backgroundImg o-backgroundImg--dimmed" style="background-image: url('<?php echo esc_url($thumb_url); ?>');"></div>
	<?php } else { ?>
	<div class="o-backgroundImg"></div>
	<?php } ?>
	<div class="postInfo">
		<h3 class="postTitle entry-title">
			<a href="<?php echo esc_url($article_link); ?>" rel="bookmark"><?php the_title(); ?></a>
		</h3>
		<?php md_bone_post_meta_author('1', 24); ?>
	</div>
	<a href="<?php echo esc_url($article_link); ?>" rel="bookmark" class="u-stretched"></a>
</article>