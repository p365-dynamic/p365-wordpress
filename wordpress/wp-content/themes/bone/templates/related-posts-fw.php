<?php
	$post_quantity = 6;
	$rel_query = md_bone_get_related_posts( get_the_ID(), $post_quantity );
	if ( $rel_query->have_posts() ) :
?>
	<div class="relatedPosts relatedPosts--card">
		<h5 class="blockHeading blockHeading--grey"><span><i class="fa fa-hand-o-right"></i><?php esc_html_e('You may also like', 'bone'); ?></span></h5>
		<div class="row">
		
			<?php if ( $rel_query->have_posts() ) : while ( $rel_query->have_posts() ) : $rel_query->the_post(); ?>
			
				<div class="col-xs-12 col-sm-6 col-md-4">
					<?php get_template_part( 'templates/post-card-bg' ); ?>
				</div>

				<?php if ( (($rel_query->current_post + 1) % 2) == 0 ): ?>
					<div class="clearfix hidden-md hidden-lg"></div>
				<?php endif; ?>

			<?php endwhile; endif; ?>
		</div>
	
	</div>
<?php 
	endif;
	wp_reset_postdata();