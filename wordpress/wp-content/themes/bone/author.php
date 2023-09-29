<?php
	$layout_opt = md_bone_get_layout_opt();
	if ( $author_id = get_query_var( 'author' ) ) { $user = get_user_by( 'id', $author_id ); } else { $user = null; }
?>
<?php get_header(); ?>
	<main id="main" class="layoutBody">
		
		<?php if ( $layout_opt['sidebar-position'] == 'none' ) { ?>
		<div class="container">
			<div class="layoutContent<?php echo esc_attr($layout_opt['main-class']); ?> clearfix">
				<div class="contentWrap">
					<?php get_template_part('templates/author-box-large'); ?>
					<?php minimaldog_user_most_popular_post(); ?>
				</div>
				
				<?php
				$paged1 = isset( $_GET['latest_paged'] ) ? (int) $_GET['latest_paged'] : 1;
				$args = array(
					'post_type' => array( 'post'),
					'post_status' => 'publish',
					'author' => $author_id,
					'ignore_sticky_posts' => 1,
					'orderby' => 'date',
					'order' => 'DESC',
					'posts_per_page' => 10,
					'paged' => $paged1,
				);
				$latest_posts = new WP_Query( $args );

				$paged2 = isset( $_GET['favorite_paged'] ) ? (int) $_GET['favorite_paged'] : 1;
				$user_likes = get_user_option( "minimaldog_liked_posts", $author_id );
				$args = array(
					'post_type' => array( 'post'),
					'post_status' => 'publish',
					'post__in' => $user_likes,
					'ignore_sticky_posts' => 1,
					'orderby' => 'date',
					'order' => 'DESC',
					'posts_per_page' => 10,
					'paged' => $paged2,
				);
				$liked_posts = new WP_Query( $args );
				?>

				<?php if( ($latest_posts->have_posts()) || (($liked_posts->have_posts()) && (get_current_user_id() == $author_id)) ) { ?>
				<div class="authorContent tabs">
					
					<ul class="tabs-nav metaFont mainContentWrap" role="tablist">
						<?php if (!in_array( 'subscriber', (array) $user->roles )) { ?>
						<li role="presentation" class="active"><a href="#author-latest-posts" aria-controls="author-latest-posts" role="tab" data-toggle="tab"><?php esc_html_e('Latest posts', 'bone'); ?></a></li>
						<?php } ?>
						<?php if( get_current_user_id() == $author_id ) { ?>
						<li role="presentation"><a href="#author-liked-posts" aria-controls="author-liked-posts" role="tab" data-toggle="tab"><?php esc_html_e('Favorite posts', 'bone'); ?></a></li>
						<?php } ?>
					</ul>

					<div class="tabs-content">

						<?php if (!in_array( 'subscriber', (array) $user->roles )) { ?>
						<div id="author-latest-posts" class="tabs-content-section active clearfix">
							<div class="<?php echo esc_attr($layout_opt['content-class']); ?>">
								<?php
								if ( $latest_posts->have_posts() ) {
									while ( $latest_posts->have_posts() ) { 
										$latest_posts->the_post();
										md_bone_get_template( $layout_opt['content-layout'] );
									}
								} else {
									echo '<div class="mainContentWrap">'. esc_html__("There's no post yet", 'bone').'</div>';
								}
								?>
							</div>

							<?php
							if ( $latest_posts->max_num_pages > 1 ) {
						    	echo '<div class="pagePagination metaFont clearfix">';
								$pagination = array(
						            'format' => '?latest_paged=%#%',
									'total' => $latest_posts->max_num_pages,
									'current' => $paged1,
									'prev_text' => esc_html__( 'Previous', 'bone' ),
									'next_text' => esc_html__( 'Next', 'bone' ),
									'type' => 'plain',
									'add_args' => array( 'favorite_paged' => $paged1 )
								);
								echo paginate_links( $pagination );
						    	echo '</div>';
							}

							wp_reset_postdata();
							?>
						</div>
						<?php } ?>
						
						<?php if( get_current_user_id() == $author_id ) { ?>
						<div id="author-liked-posts" class="tabs-content-section clearfix">
							
							<?php
				            
							if ( !empty( $user_likes ) && count( $user_likes ) > 0 ) { ?>
								<div class="<?php echo esc_attr($layout_opt['content-class']); ?>">
								<?php
								if ( $liked_posts->have_posts() ) {
									while ( $liked_posts->have_posts() ) { 
										$liked_posts->the_post();
										md_bone_get_template( $layout_opt['content-layout'] );
									}
								}
							?>
								</div>
								
							<?php
							if ( $liked_posts->max_num_pages > 1 ) {
						    	echo '<div class="pagePagination metaFont clearfix">';
								$pagination = array(
						            'format' => '?favorite_paged=%#%',
									'total' => $liked_posts->max_num_pages,
									'current' => $paged2,
									'prev_text' => esc_html__( 'Previous', 'bone' ),
									'next_text' => esc_html__( 'Next', 'bone' ),
									'type' => 'plain',
									'add_args' => array( 'latest_paged' => $paged2 )
								);
								echo paginate_links( $pagination );
						    	echo '</div>';
							}

								wp_reset_postdata();
							} else {
								echo '<div class="mainContentWrap">'. esc_html__("You haven't liked any posts yet", 'bone').'</div>';
							}
							?>
						</div>
						<?php } ?>

					</div>
				</div><!-- end authorContent -->
				<?php } //end if ?>

			</div>
		</div>
		<?php } else { ?>
		<div class="container">
			<div class="layoutContent clearfix">
				<div class="layoutContent-main<?php echo esc_attr($layout_opt['main-class']); ?>">

					<?php get_template_part('templates/author-box-large'); ?>
					<?php minimaldog_user_most_popular_post(); ?>

					<?php
					$paged1 = isset( $_GET['latest_paged'] ) ? (int) $_GET['latest_paged'] : 1;
					$args = array(
						'post_type' => array( 'post'),
						'post_status' => 'publish',
						'author' => $author_id,
						'ignore_sticky_posts' => 1,
						'orderby' => 'date',
						'order' => 'DESC',
						'posts_per_page' => 10,
						'paged' => $paged1,
					);
					$latest_posts = new WP_Query( $args );

					$paged2 = isset( $_GET['favorite_paged'] ) ? (int) $_GET['favorite_paged'] : 1;
					$user_likes = get_user_option( "minimaldog_liked_posts", $author_id );
					$args = array(
						'post_type' => array( 'post'),
						'post_status' => 'publish',
						'post__in' => $user_likes,
						'ignore_sticky_posts' => 1,
						'orderby' => 'date',
						'order' => 'DESC',
						'posts_per_page' => 10,
						'paged' => $paged2,
					);
					$liked_posts = new WP_Query( $args );
					?>

					<?php if( ($latest_posts->have_posts()) || (($liked_posts->have_posts()) && (get_current_user_id() == $author_id)) ) { ?>
					<div class="authorContent tabs">
						
						<ul class="tabs-nav metaFont" role="tablist">
							<?php if (!in_array( 'subscriber', (array) $user->roles )) { ?>
							<li role="presentation" class="active"><a href="#author-latest-posts" aria-controls="author-latest-posts" role="tab" data-toggle="tab"><?php esc_html_e('Latest posts', 'bone'); ?></a></li>
							<?php } ?>
							<?php if( get_current_user_id() == $author_id ) { ?>
							<li role="presentation"<?php if (in_array( 'subscriber', (array) $user->roles )) { echo ' class="active"'; } ?>><a href="#author-liked-posts" aria-controls="author-liked-posts" role="tab" data-toggle="tab"><?php esc_html_e('Favorite posts', 'bone'); ?></a></li>
							<?php } ?>
						</ul>

						<div class="tabs-content">

							<?php if (!in_array( 'subscriber', (array) $user->roles )) { ?>
							<div id="author-latest-posts" class="tabs-content-section active clearfix">
								<div class="<?php echo esc_attr($layout_opt['content-class']); ?>">
									<?php
									if ( $latest_posts->have_posts() ) {
										while ( $latest_posts->have_posts() ) { 
											$latest_posts->the_post();
											md_bone_get_template( $layout_opt['content-layout'] );
										}
									} else {
										echo '<div class="mainContentWrap">'. esc_html__("There's no post yet", 'bone').'</div>';
									}

									wp_reset_postdata();?>
								</div>
								
								<?php
								if ( $latest_posts->max_num_pages > 1 ) {
							    	echo '<div class="pagePagination metaFont clearfix">';
									$pagination = array(
							            'format' => '?latest_paged=%#%',
										'total' => $latest_posts->max_num_pages,
										'current' => $paged1,
										'prev_text' => esc_html__( 'Previous', 'bone' ),
										'next_text' => esc_html__( 'Next', 'bone' ),
										'type' => 'plain',
										'add_args' => array( 'favorite_paged' => $paged1 )
									);
									echo paginate_links( $pagination );
							    	echo '</div>';
								}
								?>
							</div>
							<?php } ?>
							
							<?php if( get_current_user_id() == $author_id ) { ?>
							<div id="author-liked-posts" class="tabs-content-section clearfix">
						
								<?php
					            
								if ( !empty( $user_likes ) && count( $user_likes ) > 0 ) { ?>
									<div class="<?php echo esc_attr($layout_opt['content-class']); ?>">
									<?php
									if ( $liked_posts->have_posts() ) {
										while ( $liked_posts->have_posts() ) { 
											$liked_posts->the_post();
											md_bone_get_template( $layout_opt['content-layout'] );
										}
									}
								?>
									</div>
									
								<?php
								if ( $liked_posts->max_num_pages > 1 ) {
							    	echo '<div class="pagePagination metaFont clearfix">';
									$pagination = array(
							            'format' => '?favorite_paged=%#%',
										'total' => $liked_posts->max_num_pages,
										'current' => $paged2,
										'prev_text' => esc_html__( 'Previous', 'bone' ),
										'next_text' => esc_html__( 'Next', 'bone' ),
										'type' => 'plain',
										'add_args' => array( 'latest_paged' => $paged2 )
									);
									echo paginate_links( $pagination );
							    	echo '</div>';
								}

									wp_reset_postdata();
								} else {
									echo '<div class="mainContentWrap">'. esc_html__("You haven't liked any posts yet", 'bone').'</div>';
								}
								?>
							</div>
							<?php } ?>

						</div>
					</div><!-- end authorContent -->
					<?php } //end if ?>

				</div><!-- end layoutContent-main -->

				<aside id="mdSidebar" class="layoutContent-sidebar sidebar<?php echo esc_attr($layout_opt['sidebar-class']); ?>">
					<?php get_sidebar(); ?>
				</aside>	
			</div>
		</div>
		
		<?php } ?>

	</main>

<?php if (is_active_sidebar('adsidebar-2')) { ?>
	<div class="adSidebar adSidebar--2">
		<div class="container">
			<?php dynamic_sidebar('adsidebar-2'); ?>
		</div>
	</div>
<?php } ?>

<?php get_footer(); ?>