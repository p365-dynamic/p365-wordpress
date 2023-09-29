<?php
	$feat_layout = md_bone_get_option('feat-layout', 'slider');
	if (( $feat_layout == 'slider-cover' ) || ( $feat_layout == 'slider-fw' )) {
		$fw_feat = true;
		$js_class = ' owl-carousel js-feat-slider';
	} else {
		$fw_feat = false;
		$js_class = ' owl-carousel js-feat-slider-peek';
	}
	$slider_type = ( $feat_layout == 'slider-cover' )? ' featuredBlock--slider--cover': '';

	$args = md_bone_create_ft_args();
	if ( !$args ) {
		return; // there's no post to show
	}
	$feat_query = new WP_Query( $args );

if ( $feat_query->have_posts() ) :
?>
<?php if ($feat_layout == 'slider') { ?>
<div class="featuredBlockBackground clearfix">
<?php } ?>

<?php if (!$fw_feat) { ?>
<div class="featuredSliderWrap container">
<?php } ?>

	<div class="featuredBlock featuredBlock--slider md-theme<?php if ( $feat_query->post_count > 1 ) { echo esc_attr($js_class); }?><?php echo esc_attr($slider_type); ?>">
		<?php while ( $feat_query->have_posts() ) : $feat_query->the_post(); ?>
			<div class="slide-content">
			<?php require( locate_template('templates/post-slide.php') ); ?>
			</div>
		<?php endwhile; ?>
	</div>

<?php if (!$fw_feat) { ?>
</div>
<?php } ?>

<?php if ($feat_layout == 'slider') { ?>
</div>
<?php } ?>

<?php
endif;
wp_reset_postdata();