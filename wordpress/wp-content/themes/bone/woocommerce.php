<?php
$article_schema = '';
$article_body_schema = '';
$title_style = md_bone_get_option('woocommerce-archive-title-style', 'default');
if ($title_style == 'cover') {
	$title_bg = md_bone_get_option('woocommerce-archive-title-background', NULL);
	if ( $title_bg != NULL ) {
		if ( $title_bg['url'] == '' ) { $title_bg = NULL; }
	}
} else {
	$title_bg = NULL;
}

$sidebar_position = md_bone_get_option('woocommerce-shop-sidebar-position', 'right');
if (is_product()) {
	$sidebar_position = md_bone_get_option('woocommerce-product-sidebar-position', 'right');
} elseif (is_product_category() || is_product_tag()) {
	$sidebar_position = md_bone_get_option('woocommerce-cat-sidebar-position', 'right');
}
$sticky_sidebar = md_bone_get_option('sticky-sidebar', '1');
$main_classes = '';
$sidebar_classes = '';
if($sidebar_position == 'right') {
	$main_classes .= ' hasRightSidebar';
	$sidebar_classes .= ' sidebar--right';
} else {
	$main_classes .= ' hasLeftSidebar';
	$sidebar_classes .= ' sidebar--left';
}
if($sticky_sidebar) {
	$sidebar_classes .= ' js-sticky-sidebar';
}
$post_classes = array(
	'pageTemplate',
);	

$page_subtitle = '';
if (is_product_category()) {
	$page_subtitle = __('Product category', 'bone');
	$page_title = single_term_title('', false);
} elseif (is_product_tag()) {
	$page_subtitle = __('Product tag', 'bone');
	$page_title = single_term_title('', false);
} elseif (is_search()) {
	$page_subtitle = __('Search result for', 'bone');
	$page_title = get_search_query();
} elseif (is_shop()) {
	$page_title = esc_html__( 'Shop', 'bone' );
} else {
	$page_title = get_the_archive_title();
} 

get_header(); ?>

<main class="layoutBody">
	<div <?php post_class($post_classes); ?>>

		<?php if (($title_style == 'cover') && (!is_product())) { ?>
			<div class="container">
				<div class="pageMasthead<?php if ($title_bg != '') { echo ' hasBgImg'; } ?>">
					<?php if ($title_bg) { ?>
					<div class="o-backgroundImg o-backgroundImg--dimmed" <?php echo 'style="background-image: url('.esc_url($title_bg['url']).')"'; ?>></div>
					<?php } ?>
					<?php if ($page_subtitle !== '') { ?>
					<div class="pageHeading-prefix metaFont"><?php echo esc_html($page_subtitle); ?></div>
					<?php } ?>
					<h1 itemprop="name" class="pageMasthead-title"><?php echo esc_html($page_title); ?></h1>
				</div>
			</div>
		<?php } ?>

	<?php if ( $sidebar_position === 'none' ) { ?>
		<div class="container">
			<div class="layoutContent clearfix">
					<?php if (($title_style != 'cover') && (!is_product())) { ?>
						<div class="pageHeading">
							<?php if ($page_subtitle !== '') { ?>
							<div class="pageHeading-prefix metaFont"><?php echo esc_html($page_subtitle); ?></div>
							<?php } ?>
							<h1 itemprop="name" class="pageHeading-title titleFont"><?php echo esc_html($page_title); ?></h1>
						</div>
					<?php } ?>
					
					<?php woocommerce_content(); ?>

			</div>
		</div>
	<?php } else { ?>
		<div class="container">
			<div class="layoutContent clearfix">

				<div class="layoutContent-main<?php echo esc_attr($main_classes); ?>">

					<?php if (($title_style != 'cover') && (!is_product())) { ?>
						<div class="pageHeading">
							<?php if ($page_subtitle !== '') { ?>
							<div class="pageHeading-prefix metaFont"><?php echo esc_html($page_subtitle); ?></div>
							<?php } ?>
							<h1 itemprop="name" class="pageHeading-title titleFont"><?php echo esc_html($page_title); ?></h1>
						</div>
					<?php } ?>
						
					<?php woocommerce_content(); ?>

				</div><!-- end layoutContent-main -->
				
				<aside id="mdSidebar" class="layoutContent-sidebar sidebar<?php echo esc_attr($sidebar_classes); ?>">
					<?php get_sidebar(); ?>
				</aside>

			</div><!-- end layoutContent -->
		</div><!-- end container -->
	<?php } ?>

	</div>
</main>

<?php if (is_active_sidebar('adsidebar-2')) { ?>
	<div class="adSidebar adSidebar--2">
		<div class="container">
			<?php dynamic_sidebar('adsidebar-2'); ?>
		</div>
	</div>
<?php } ?>

<?php get_footer();