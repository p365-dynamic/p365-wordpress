<?php
	$ribbon_switch = md_bone_get_option('ribbon-switch', '0');
	if ($ribbon_switch !== '1')
		return;
	// create args base on method
	$posts_per_page = 4;
	$get_post_method = md_bone_get_option('ribbon-get-post-method', '');
	$orderby = md_bone_get_option('ribbon-order', 'date');
	switch ($get_post_method) {
		case 'by-manual':
			$post_in = md_bone_get_option('ribbon-post-select', '');
			if ($post_in !== '') {
				$args = array(
					'posts_per_page'      => $posts_per_page,
					'ignore_sticky_posts' => 1,
					'post__in'   => $post_in,
					'orderby'=> $orderby,
				);
			} else {
				$args = false;
			}
			break;

		case 'by-marked':
			$prefix = 'md_bone_';
			$args = array(
				'posts_per_page'      => $posts_per_page,
				'ignore_sticky_posts' => 1,
				'meta_key'   => $prefix.'post_featured',
				'meta_value' => '1',
				'orderby'=> $orderby,
			);
			break;

		case 'by-tag':
			$tag_in = md_bone_get_option('ribbon-tag-select', '');
			if ($tag_in !== '') {
				$args = array(
					'posts_per_page'      => $posts_per_page,
					'ignore_sticky_posts' => 1,
					'tag__in'   => $tag_in,
					'orderby'=> $orderby,
				);
			} else {
				$args = false;
			}
			break;

		default:
		case 'by-category':
			$category_in = md_bone_get_option('ribbon-cat-select', '');
			if ($category_in !== '') {
				$args = array(
					'posts_per_page'      => $posts_per_page,
					'ignore_sticky_posts' => 1,
					'category__in'   => $category_in,
					'orderby'=> $orderby,
				);
			} else {
				$args = false;
			}
			break;
	}
	$query_posts = new WP_Query( $args );

	if ($query_posts->have_posts()):
?>
<div class="postRibbon">
	<div class="container">
		<div class="postRibbon-inner">
		<?php while ($query_posts->have_posts()): $query_posts->the_post(); ?>
			<div class="postRibbon-item">
				<?php get_template_part('templates/post-list-micro' ); ?>
			</div>
		<?php endwhile; ?>
		</div>
	</div>
</div>
<?php endif;
wp_reset_postdata();