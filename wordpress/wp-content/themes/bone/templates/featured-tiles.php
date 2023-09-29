<?php
	$args = md_bone_create_ft_args();
	if ( !$args ) {
		return; // there's no post to show
	}
	$feat_query = new WP_Query( $args );

if ( $feat_query->have_posts() ) :
?>
<div class="featuredBlockBackground clearfix">
	<div class="container">
		<div class="featuredBlock featuredBlock--tiles block--tile block--tile--grid block--tile--colored clearfix">
		
		<?php
		 while ( $feat_query->have_posts() ) : $feat_query->the_post();
			switch ($feat_query->current_post) {
				case 0:
					echo '<div class="tile-item big-tile col-xs-12 col-sm-6">';
					break;

				case 1:
				case 2:
					echo '<div class="tile-item col-xs-12 col-sm-6 col-lg-3">';
					break;

				case 3:
				case 4:
					echo '<div class="tile-item col-xs-12 col-sm-6 col-lg-3">';
					break;

				case 5:
				default:
					echo '<div class="tile-item big-tile col-xs-12 col-sm-6">';
					break;
			}
			get_template_part( 'templates/post-tile-featured');
			echo '</div>';
		endwhile;
		?>
		</div>
	</div>
</div>
<?php
endif;
wp_reset_postdata();