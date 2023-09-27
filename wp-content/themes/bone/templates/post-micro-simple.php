<?php
	$classes = array(
		'postItem',
		'post--list--simple',
		'clearfix'
	);
	$article_link =  get_permalink();
?>
<article <?php post_class( $classes ); ?>>
	<?php md_bone_post_category(); ?>
	<h3 class="postTitle entry-title">
		<a href="<?php echo esc_url($article_link); ?>" rel="bookmark"><?php the_title(); ?></a>
	</h3>
	<span class="metaText metaDate"><abbr class="published updated" title="<?php the_time(get_option( 'date_format' )); ?>"><?php md_bone_human_datetime(); ?></abbr></span>
</article>