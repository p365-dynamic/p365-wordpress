<?php
	$no_duplicate_switch = md_bone_get_option('no-duplicate-posts-switch', '0');
	$categories = md_bone_get_option('more-reading-categories', array());
	$categories = array_slice($categories, 0, 4);
	if (!isset($latest_post_ids)) {
		$latest_post_ids = array();
	}
	if (!empty($categories)) { ?>
<div class="byCategoryListing">
	<div class="container">
		<h4 class="byCategoryListing-title metaFont"><span><?php esc_html_e('More reading', 'bone'); ?></span><i class="fa fa-book"></i></h4>
		<div class="row">

		<?php foreach ($categories as $category) { 
			$category_obj = get_category($category);
			$category_slug = $category_obj->slug; ?>
			<div class="col-sm-6 col-md-3">
				<div class="byCategoryListing-catSection category-<?php echo esc_attr($category_slug); ?>">
					<div class="byCategoryListing-catTitle primaryBgColor">
						<h4 class="metaFont"><?php echo get_cat_name($category); ?></h4>
						<span class="metaFont"><?php esc_html_e('View all', 'bone'); ?><i class="fa fa-angle-right"></i></span>
						<a href="<?php echo get_category_link( $category ); ?>" class="o-overlayLink"></a>
					</div>
					<ul class="u-noStyleList">
					<?php 
					if ($no_duplicate_switch === '1') {
						$args = array(
							'cat'				=> $category,
							'posts_per_page' 	=> 4,
							'status' 		 	=> 'publish',
							'ignore_sticky_posts'=> true,
						);
					} else {
						$args = array(
							'cat'				=> $category,
							'posts_per_page' 	=> 4,
							'status' 		 	=> 'publish',
							'ignore_sticky_posts'=> true,
							'post__not_in'		=> $latest_post_ids,
						);
					}

					$query_posts = new WP_Query( $args );
					while ($query_posts->have_posts()): $query_posts->the_post(); ?>
						<?php $article_link = get_permalink();?>
						<li>
							<h3 class="postTitle">
								<a href="<?php echo esc_url($article_link); ?>" rel="bookmark"><i class="fa fa-arrow-circle-right primaryColor"></i><?php the_title(); ?></a>
							</h3>
						</li>
						<?php endwhile; ?>
					</ul>
				</div>
			</div>
		<?php } ?>
			
		</div>
	</div>
</div>
<?php }