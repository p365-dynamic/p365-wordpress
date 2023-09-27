<?php
	$args = md_bone_create_ft_args();
	if ( !$args ) {
		return; // there's no post to show
	}
	$feat_query = new WP_Query( $args );
	
if ( $feat_query->have_posts() ) :
?>
<div class="featuredBlock featuredBlock--carousel js-iscroll">
	<div class="iscroll-wrapper">
		<ul>
		<?php while ( $feat_query->have_posts() ) : $feat_query->the_post(); ?>
			<li class="carousel-item">
			<?php get_template_part( 'templates/post-carousel'); ?>
			</li>
			<?php endwhile; ?>	
		</ul>	
	</div>
	<div id="iscroll-bg">
		<div class="iscroll-bg featuredBlockBackground"></div>
	</div>
</div>
<?php
endif;
wp_reset_postdata();