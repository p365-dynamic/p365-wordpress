<?php
	/* Template Name: Authors List */

	$layout_opt = md_bone_get_layout_opt();

	// Pagination variables
	$number   = 10;
	$paged    = (get_query_var('paged')) ? get_query_var('paged') : 1;

	$args = array(
		'who'					=> 'authors',
		'has_published_posts'	=> true,
		'orderby'				=> 'display_name',
		'order'					=> 'ASC',
		'number'				=> $number,
		'paged'					=> $paged,
	);
	$user_query = new WP_User_Query( $args );
	$total_authors = $user_query->get_total();
	$total_pages = intval($total_authors / $number);
?>

<?php get_header(); ?>

<main id="main" class="layoutBody">

	<?php if ( $layout_opt['sidebar-position'] == 'none' ) { ?>
	<div class="contentBlockWrapper">

		<div class="container">
			<div class="layoutContent<?php echo esc_attr($layout_opt['main-class']); ?> clearfix">
				<div class="pageHeading">
					<h3 class="pageHeading-title titleFont"><?php esc_html_e('Authors', 'bone'); ?></h3>
				</div>

				
				<div id="mdContent" class="<?php echo esc_attr($layout_opt['content-class']); ?> clearfix">
					<?php
						if ( ! empty( $user_query->results ) ) {
							foreach ( $user_query->results as $user ) {
								$author_id = $user->ID;
								$author_email = get_the_author_meta('email', $author_id);
							    $author_name = get_the_author_meta('display_name', $author_id);
							    $author_tw = get_the_author_meta('twitter', $author_id);
							    $author_gp = get_the_author_meta('google', $author_id);
							    $author_fb = get_the_author_meta('facebook', $author_id);
							    $author_tb = get_the_author_meta('tumblr', $author_id);
							    $author_in = get_the_author_meta('instagram', $author_id);
							    $author_pt = get_the_author_meta('pinterest', $author_id);
							    $author_www = get_the_author_meta('url', $author_id);
							    $author_post_counts = count_user_posts( $author_id );
							?>
							<div itemscope itemtype="http://schema.org/Person" class="authorBox">
								<div class="authorBox-avatar"><?php echo get_avatar( $author_id, 100, '', esc_html__( 'avatar', 'bone' ), array('extra_attr' => 'itemprop="image"') ); ?></div>
								<div class="authorBox-text">
									<div class="authorBox-name authorName">
										<h4 itemprop="name" ><a href="<?php echo esc_url(get_author_posts_url( $author_id )); ?>"><?php esc_html_e($author_name); ?></a></h4>
									</div>
									<p class="authorBox-bio metaFont"><?php echo wp_kses_post(get_the_author_meta( 'description', $author_id)); ?></p>

									<ul class="authorBox-socials list-inline">
										<?php if ($author_email) { ?>
										<li>
											<a href="mailto:<?php echo esc_attr($author_email); ?>" target="_blank" title="Email"><i class="fa fa-envelope"></i></a>
										</li>
										<?php } ?>

										<?php if ($author_www) { ?>
										<li>
											<a href="<?php echo esc_url($author_www); ?>" target="_blank" title="Website"><i class="fa fa-globe"></i></a>
										</li>
										<?php } ?>

										<?php if ($author_tw) { ?>
										<li>
											<a href="//twitter.com/<?php echo esc_attr($author_tw); ?>" target="_blank" title="Twitter"><i class="fa fa-twitter"></i></a>
										</li>
										<?php } ?>

										<?php if ($author_fb) { ?>
										<li>
											<a href="//facebook.com/<?php echo esc_attr($author_fb); ?>" target="_blank" title="Facebook"><i class="fa fa-facebook"></i></a>
										</li>
										<?php } ?>

										<?php if ($author_gp) { ?>
										<li>
											<a href="//plus.google.com/<?php echo esc_attr($author_gp); ?>" target="_blank" title="Google+"><i class="fa fa-google-plus"></i></a>
										</li>
										<?php } ?>

										<?php if ($author_tb) { ?>
										<li>
											<a href="//<?php echo esc_attr($author_tb); ?>.tumblr.com" target="_blank" title="Tumblr"><i class="fa fa-tumblr"></i></a>
										</li>
										<?php } ?>

										<?php if ($author_in) { ?>
										<li>
											<a href="//instagram.com/<?php echo esc_attr($author_in); ?>" target="_blank" title="Instagram"><i class="fa fa-instagram"></i></a>
										</li>
										<?php } ?>

										<?php if ($author_pt) { ?>
										<li>
											<a href="//pinterest.com/<?php echo esc_attr($author_pt); ?>" target="_blank" title="Pinterest"><i class="fa fa-pinterest"></i></a>
										</li>
										<?php } ?>
									</ul>
									<div class="author-meta">
										<div class="author-meta__post-count">
											<h5 class="metaFont"><?php esc_html_e('Posts created', 'bone'); ?></h5>
											<span class="titleFont"><?php echo esc_html($author_post_counts); ?></span>
										</div><!--
										--><div class="author-meta__post-liked-count">
											<h5 class="metaFont"><?php esc_html_e('Posts liked', 'bone'); ?></h5>
											<span class="titleFont"><?php minimaldog_user_likes_count($author_id); ?></span>
										</div>
									</div>
								</div>
							</div>
							<?php
							} // end foreach

							if ( $total_pages > 1 ) {
						    	echo '<div class="pagePagination metaFont clearfix">';
						    	$current_page = max(1, $paged);
								$pagination = array(
									'base' => get_pagenum_link(1) . '%_%',
						            'format' => 'page/%#%/',
									'total' => $total_pages,
									'current' => $current_page,
									'prev_text' => esc_html__( 'Previous', 'bone' ),
									'next_text' => esc_html__( 'Next', 'bone' ),
									'type' => 'plain',
								);
								echo paginate_links( $pagination );
						    	echo '</div>';
							}
						} else {
							echo 'No users found.';
						}
						?>
				</div>
			</div>
		</div>

	</div><!-- contentBlockWrapper -->
	<?php } else { ?>
	<div class="contentBlockWrapper">

		<div class="container">
			<div class="layoutContent clearfix">
				<div class="layoutContent-main<?php echo esc_attr($layout_opt['main-class']); ?>">
					<div class="pageHeading">
						<h3 class="pageHeading-title titleFont"><?php esc_html_e('Authors', 'bone'); ?></h3>
					</div>

					<div id="mdContent" class="<?php echo esc_attr($layout_opt['content-class']); ?> clearfix">
						<?php
						if ( ! empty( $user_query->results ) ) {
							foreach ( $user_query->results as $user ) {
								$author_id = $user->ID;
								$author_email = get_the_author_meta('email', $author_id);
							    $author_name = get_the_author_meta('display_name', $author_id);
							    $author_tw = get_the_author_meta('twitter', $author_id);
							    $author_gp = get_the_author_meta('google', $author_id);
							    $author_fb = get_the_author_meta('facebook', $author_id);
							    $author_tb = get_the_author_meta('tumblr', $author_id);
							    $author_in = get_the_author_meta('instagram', $author_id);
							    $author_pt = get_the_author_meta('pinterest', $author_id);
							    $author_www = get_the_author_meta('url', $author_id);
							    $author_post_counts = count_user_posts( $author_id );
							?>
							<div itemscope itemtype="http://schema.org/Person" class="authorBox">
								<div class="authorBox-avatar"><?php echo get_avatar( $author_id, 100, '', esc_html__( 'avatar', 'bone' ), array('extra_attr' => 'itemprop="image"') ); ?></div>
								<div class="authorBox-text">
									<div class="authorBox-name authorName">
										<h4 itemprop="name" ><a href="<?php echo esc_url(get_author_posts_url( $author_id )); ?>"><?php esc_html_e($author_name); ?></a></h4>
									</div>
									<p class="authorBox-bio metaFont"><?php echo wp_kses_post(get_the_author_meta( 'description', $author_id)); ?></p>

									<ul class="authorBox-socials list-inline">
										<?php if ($author_email) { ?>
										<li>
											<a href="mailto:<?php echo esc_attr($author_email); ?>" target="_blank" title="Email"><i class="fa fa-envelope"></i></a>
										</li>
										<?php } ?>

										<?php if ($author_www) { ?>
										<li>
											<a href="<?php echo esc_url($author_www); ?>" target="_blank" title="Website"><i class="fa fa-globe"></i></a>
										</li>
										<?php } ?>

										<?php if ($author_tw) { ?>
										<li>
											<a href="//twitter.com/<?php echo esc_attr($author_tw); ?>" target="_blank" title="Twitter"><i class="fa fa-twitter"></i></a>
										</li>
										<?php } ?>

										<?php if ($author_fb) { ?>
										<li>
											<a href="//facebook.com/<?php echo esc_attr($author_fb); ?>" target="_blank" title="Facebook"><i class="fa fa-facebook"></i></a>
										</li>
										<?php } ?>

										<?php if ($author_gp) { ?>
										<li>
											<a href="//plus.google.com/<?php echo esc_attr($author_gp); ?>" target="_blank" title="Google+"><i class="fa fa-google-plus"></i></a>
										</li>
										<?php } ?>

										<?php if ($author_tb) { ?>
										<li>
											<a href="//<?php echo esc_attr($author_tb); ?>.tumblr.com" target="_blank" title="Tumblr"><i class="fa fa-tumblr"></i></a>
										</li>
										<?php } ?>

										<?php if ($author_in) { ?>
										<li>
											<a href="//instagram.com/<?php echo esc_attr($author_in); ?>" target="_blank" title="Instagram"><i class="fa fa-instagram"></i></a>
										</li>
										<?php } ?>

										<?php if ($author_pt) { ?>
										<li>
											<a href="//pinterest.com/<?php echo esc_attr($author_pt); ?>" target="_blank" title="Pinterest"><i class="fa fa-pinterest"></i></a>
										</li>
										<?php } ?>
									</ul>
									<div class="author-meta">
										<div class="author-meta__post-count">
											<h5 class="metaFont"><?php esc_html_e('Posts created', 'bone'); ?></h5>
											<span class="titleFont"><?php echo esc_html($author_post_counts); ?></span>
										</div><!--
										--><div class="author-meta__post-liked-count">
											<h5 class="metaFont"><?php esc_html_e('Posts liked', 'bone'); ?></h5>
											<span class="titleFont"><?php minimaldog_user_likes_count($author_id); ?></span>
										</div>
									</div>
								</div>
							</div>
							<?php
							} // end foreach

							if ( $total_pages > 1 ) {
						    	echo '<div class="pagePagination metaFont clearfix">';
						    	$current_page = max(1, $paged);
								$pagination = array(
									'base' => get_pagenum_link(1) . '%_%',
						            'format' => 'page/%#%/',
									'total' => $total_pages,
									'current' => $current_page,
									'prev_text' => esc_html__( 'Previous', 'bone' ),
									'next_text' => esc_html__( 'Next', 'bone' ),
									'type' => 'plain',
								);
								echo paginate_links( $pagination );
						    	echo '</div>';
							}
						} else {
							echo 'No users found.';
						}
						?>
					</div>
				</div>
			
				<aside class="layoutContent-sidebar sidebar<?php echo esc_attr($layout_opt['sidebar-class']); ?>">
					<?php get_sidebar(); ?>
				</aside>
			</div>
		</div>

	</div><!-- contentBlockWrapper -->
	<?php } ?>
	
</main>

<?php if (is_active_sidebar('adsidebar-2')) { ?>
	<div class="adSidebar adSidebar--2">
		<div class="container">
			<?php dynamic_sidebar('adsidebar-2'); ?>
		</div>
	</div>
<?php } ?>
	
<?php get_footer();