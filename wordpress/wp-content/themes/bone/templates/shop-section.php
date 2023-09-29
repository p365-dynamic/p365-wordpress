<?php
$shop_page_url = get_permalink( woocommerce_get_page_id( 'shop' ) );
$products = md_bone_get_option('woocommerce-homepage-section', 'recent');
?>
<div class="shopSection">
	<div class="pageHeading pageHeading--sub">
		<h3 class="pageHeading-title metaFont"><?php esc_html_e( 'Shop', 'bone' ); ?></h3>
	</div>
<?php
switch ($products) {
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
}
?>
	<div class="moreProducts">
		<a href="<?php echo esc_attr($shop_page_url); ?>" class="btn btn--pill"><span><?php esc_html_e( 'View more products', 'bone' ); ?></span><i class="fa fa-arrow-right"></i></a>
	</div>
</div>