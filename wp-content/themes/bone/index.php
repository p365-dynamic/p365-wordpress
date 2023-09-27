<?php
	$layout_opt = md_bone_get_layout_opt();
	$feat_layout = md_bone_get_option('feat-layout','slider');
	$template = ( strpos($feat_layout, '-') ) ? substr($feat_layout, 0, strpos($feat_layout, '-')) : $feat_layout;
	$fw_feat = ( ($feat_layout == 'slider-cover') || ($feat_layout == 'slider-fw') || ($feat_layout == 'carousel') ) ? true : false;
	global $wp_query;
	$latest_post_ids = array();
?>

<?php get_header(); ?>

<main id="main" class="layoutBody">

	<?php if (is_home()) { ?>
	<div class="featuredBlockWrapper">
		<?php get_template_part('templates/featured-'.$template); ?>
	</div>
	<?php } ?>

	<?php if (is_active_sidebar('adsidebar-1')) { ?>
	<div class="adSidebar adSidebar--1">
		<div class="container">
			<?php dynamic_sidebar('adsidebar-1'); ?>	
		</div>
	</div>
	<?php } ?>

	<?php if ( $layout_opt['sidebar-position'] == 'none' ) { ?>
	<div class="contentBlockWrapper">
		<div class="container">
			<div class="layoutContent<?php echo esc_attr($layout_opt['main-class']); ?> clearfix">
				<?php if (is_home()) { ?>
				<div class="pageHeading pageHeading--sub">
					<h3 class="pageHeading-title metaFont"><?php esc_html_e('Latest stories', 'bone'); ?></h3>
				</div>
				<?php } ?>

				<?php if ( have_posts() ): ?>
				<div id="mdContent" class="<?php echo esc_attr($layout_opt['content-class']); ?> clearfix">
					<?php
					while ( have_posts() ) : the_post();
						md_bone_get_template( $layout_opt['content-layout'] );
						$latest_post_ids[] = get_the_id();
					endwhile;
					?>
				</div>
				<?php md_bone_get_pagination( $layout_opt['pagination-type'] );?>

				<?php else:
					get_template_part('templates/no-result' ); ?>
				<?php endif; ?>
			</div>
		</div>
	</div><!-- contentBlockWrapper -->
	<?php } else { ?>
	<div class="contentBlockWrapper">
		<div class="container">
			<div class="layoutContent clearfix">
				<div class="layoutContent-main<?php echo esc_attr($layout_opt['main-class']); ?>">
					<?php if (is_home()) { ?>
					<div class="pageHeading pageHeading--sub">
						<h3 class="pageHeading-title metaFont"><?php esc_html_e('Latest stories', 'bone'); ?></h3>
					</div>
					<?php } ?>

					<?php if ( have_posts() ): ?>
					<div id="mdContent" class="<?php echo esc_attr($layout_opt['content-class']); ?> clearfix">
						<?php
						while ( have_posts() ) : the_post();
							md_bone_get_template( $layout_opt['content-layout'] );
							$latest_post_ids[] = get_the_id();
						endwhile;
						?>
					</div>
					<?php md_bone_get_pagination( $layout_opt['pagination-type'] );?>

					<?php else:
						get_template_part('templates/no-result' ); ?>
					<?php endif; ?>
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

<?php
$more_reading = md_bone_get_option('more-reading-switch', '1');
if ( $more_reading ) {
	require(locate_template('templates/by-category-listing.php'));
}
?>

<?php
if (is_woocommerce_activated()) {
	$shop_section = md_bone_get_option('woocommerce-homepage-section-switch', '1');
	if ($shop_section) {
?>
<div class="container">
	<?php get_template_part('templates/shop-section'); ?>
</div>
<?php
	}
}
?>
	
<?php get_footer();
