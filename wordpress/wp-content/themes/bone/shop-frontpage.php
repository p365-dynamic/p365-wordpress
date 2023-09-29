<?php
/**
 * The template for displaying Woocommerce front page.
 *
 * Template Name: Woocommerce Front Page
 *
 * @package bone
 */

$title_style = md_bone_get_metabox('page-title-style', 'default');
$sidebar_position = md_bone_get_metabox( 'page-sidebar-position', 'default' );
if ($sidebar_position == 'default') {
	$sidebar_position = md_bone_get_option('woocommerce-shop-front-sidebar-position', 'right');
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
if ( has_post_thumbnail() ) {
	$thumb_id = get_post_thumbnail_id();
	$thumb_url_array = wp_get_attachment_image_src( $thumb_id, 'full', true );
	$thumb_url = $thumb_url_array[0];
} else {
	$thumb_url = '';
}

$default_order = array(
    'categories' => true,
    'recent' => true,
    'featured' => true,
);
$shop_layout = md_bone_get_option('woocommerce-frontpage-layout', $default_order);
$shop_page_url = get_permalink(woocommerce_get_page_id( 'shop' ));

get_header(); ?>

<main class="layoutBody">
	<article <?php post_class($post_classes); ?>>

		<?php if ($title_style == 'fullwidth') { ?>
			<div class="container">
				<div class="pageMasthead<?php if ($thumb_url != '') { echo ' hasBgImg'; } ?>">
					<?php if ($thumb_url != '') { ?>
					<div class="o-backgroundImg o-backgroundImg--dimmed" <?php echo 'style="background-image: url('.esc_url($thumb_url).')"'; ?>></div>
					<?php } ?>
					<h1 itemprop="name" class="pageMasthead-title"><?php esc_html_e('Shop', 'bone'); ?></h1>
				</div>
			</div>
		<?php } ?>

	<?php if ( $sidebar_position === 'none' ) { ?>
		<div class="container">
			<div class="layoutContent clearfix">
				<?php if ($title_style != 'fullwidth') { ?>
					<div class="pageHeading">
						<h1 itemprop="name" class="pageHeading-title titleFont"><?php esc_html_e('Shop', 'bone'); ?></h1>
					</div>
				<?php } ?>
				
				<?php
				foreach ($shop_layout as $key => $value) {
					if ($value) {
						switch ($key) {
							case 'recent':
							default:
								minimaldog_recent_products();
								break;

							case 'featured':
								minimaldog_featured_products();
								break;

							case 'popular':
								minimaldog_popular_products();
								break;

							case 'sale':
								minimaldog_on_sale_products();
								break;

							case 'categories':
								minimaldog_product_categories();
								break;
						}
					}
				}
				?>

				<div class="moreProducts">
					<a href="<?php echo esc_attr($shop_page_url); ?>" class="btn btn--pill"><span><?php esc_html_e( 'View all products', 'bone' ); ?></span><i class="fa fa-arrow-right"></i></a>
				</div>
			</div>
		</div>
	<?php } else { ?>
		<div class="container">
			<div class="layoutContent clearfix">

				<div class="layoutContent-main<?php echo esc_attr($main_classes); ?>">

					<?php if ($title_style != 'fullwidth') { ?>
						<div class="pageHeading">
							<h1 itemprop="name" class="pageHeading-title titleFont"><?php esc_html_e('Shop', 'bone'); ?></h1>
						</div>
					<?php } ?>
						
					<?php
					foreach ($shop_layout as $key => $value) {
						if ($value) {
							switch ($key) {
								case 'recent':
								default:
									minimaldog_recent_products();
									break;

								case 'featured':
									minimaldog_featured_products();
									break;

								case 'popular':
									minimaldog_popular_products();
									break;

								case 'sale':
									minimaldog_on_sale_products();
									break;

								case 'categories':
									minimaldog_product_categories();
									break;
							}
						}
					}
					?>

					<div class="moreProducts">
						<a href="<?php echo esc_attr($shop_page_url); ?>" class="btn btn--pill"><span><?php esc_html_e( 'View all products', 'bone' ); ?></span><i class="fa fa-arrow-right"></i></a>
					</div>

				</div><!-- end layoutContent-main -->
				
				<aside id="mdSidebar" class="layoutContent-sidebar sidebar<?php echo esc_attr($sidebar_classes); ?>">
					<?php get_sidebar(); ?>
				</aside>

			</div><!-- end layoutContent -->
		</div><!-- end container -->
	<?php } ?>

	</article>
</main>

<?php if (is_active_sidebar('adsidebar-2')) { ?>
	<div class="adSidebar adSidebar--2">
		<div class="container">
			<?php dynamic_sidebar('adsidebar-2'); ?>
		</div>
	</div>
<?php } ?>

<?php get_footer();