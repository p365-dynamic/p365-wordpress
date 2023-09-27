<?php
	$classes = array(
		'postItem',
		'post--list--paper',
		'post--list--paper--micro',
		'clearfix'
	);			
	$category_array = get_the_category();
	if ( $category_array ) {
		$category_id = $category_array[0]->term_id;
		$category_name = esc_attr( $category_array[0]->name );
		$category_link = esc_url( get_category_link( $category_id ) );
	}
	$article_link =  get_permalink();
	if (!isset($title_limit)) {
		$title_limit = 120;
	}
?>
<article <?php post_class( $classes ); ?>>
	<div class="flexbox">
		<?php if ( has_post_thumbnail() ) { ?>
		<div class="flexbox-item">
			<div class="postFeaturedImg">
				<?php the_post_thumbnail('md_bone_xs'); ?>
			</div>
		</div>
		<?php } ?>
		<div class="flexbox-item">
			<h3 class="postTitle entry-title">
			<a href="<?php echo esc_url($article_link); ?>" rel="bookmark"><?php echo md_bone_truncate(get_the_title(), $title_limit); ?></a>
			</h3>
			<div class="metaText metaDate"><abbr class="published updated" title="<?php the_time(get_option( 'date_format' )); ?>"><?php md_bone_human_datetime(); ?></abbr></div>
		</div>
	</div>
	<a href="<?php echo esc_url($article_link); ?>" class="overlayLink u-stretched"></a>
</article>