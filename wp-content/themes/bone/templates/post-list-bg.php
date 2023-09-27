<?php
	$classes = array(
		'postItem',
		'post--listBg'
	);
	if ( has_post_thumbnail() ) {
		$thumb_id = get_post_thumbnail_id();
		$thumb_url_array = wp_get_attachment_image_src( $thumb_id, 'md_bone_md', true );
		$thumb_url = $thumb_url_array[0];
	} else {
		$thumb_url = '';
	}	
	$category_array = get_the_category();
	if ( $category_array ) {
		$category_id = $category_array[0]->term_id;
		$category_name = esc_attr( $category_array[0]->name );
		$category_link = esc_url( get_category_link( $category_id ) );
	}
	$article_link =  get_permalink();
	if (!isset($orderby)) {
		$orderby = '';
	}
?>
<article <?php post_class( $classes ); ?>>
	<div class="o-backgroundImg o-backgroundImg--dimmed" style="background-image: url('<?php echo esc_url($thumb_url); ?>');"></div>
	<div class="postInfo flexbox">
		<?php if (isset($nth)) { ?>
		<div class="flexbox-item">
			<span class="listIndex metaFont"><?php echo esc_html($nth); ?></span>
		</div>
		<?php } ?>
		<div class="flexbox-item">
			<h3 class="postTitle entry-title"><?php the_title(); ?></h3>
			<?php if ($orderby == 'comment_count') { ?>
			<div class="metaText">
				<i class="fa fa-comment-o"></i>
				<?php
				if ( get_comments_number() != '0' ) {
					printf( _nx( '<span class="hidden-xs"> '.esc_html__('%1$s comment', 'bone').'</span>', '<span class="hidden-xs"> '.esc_html__('%1$s comments', 'bone').'</span>', get_comments_number(), 'comments title', 'bone' ),
			number_format_i18n( get_comments_number() ) );
				} else {
					echo '<span class="hidden-xs"> '.esc_html__('Comment', 'bone').'</span>';
				} ?>
			</div>
			<?php } elseif ($orderby == 'meta_value_num') { ?>
				<?php echo minimaldog_post_like_count( get_the_ID() ); ?>
			<?php } else { ?>
			<div class="metaText metaDate"><abbr class="published updated" title="<?php the_time(get_option( 'date_format' )); ?>"><?php md_bone_human_datetime(); ?></abbr></div>	
			<?php } ?>
		</div>
	</div>
	<a href="<?php echo esc_url($article_link); ?>" rel="bookmark" class="o-overlayLink"></a>
</article>