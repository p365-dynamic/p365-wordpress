<?php
$sticky_sidebar = md_bone_get_option('sticky-sidebar', '1');
if ($sticky_sidebar == '1') {
	echo '<div class="theiaStickySidebar">';
}

if (is_woocommerce_activated()) {
	if (is_woocommerce() || is_checkout() || is_cart() || is_page_template( 'shop-front.php' )) {
		if (is_active_sidebar('woocommerce-sidebar')) {
			dynamic_sidebar('woocommerce-sidebar');
		} elseif (is_active_sidebar('single-sidebar')) {
			dynamic_sidebar('single-sidebar');
		} elseif (is_active_sidebar('default-sidebar')) {
			dynamic_sidebar('default-sidebar');
		} else {
			echo '<p style="padding: 20px;background-color:#f5f5f5;">'.esc_html__('Place widgets on WooCommerce Sidebar to make them appear here', 'bone').'</p>';
		}
	} elseif (is_front_page()) {
		if (is_active_sidebar('home-sidebar')) {
			dynamic_sidebar('home-sidebar');
		} elseif (is_active_sidebar('default-sidebar')) {
			dynamic_sidebar('default-sidebar');
		} else {
			echo '<p style="padding: 20px;background-color:#f5f5f5;">'.esc_html__('Place widgets on Home Sidebar to make them appear here', 'bone').'</p>';
		}
	} elseif (is_single()) {
		if (is_active_sidebar('single-sidebar')) {
			dynamic_sidebar('single-sidebar');
		} elseif (is_active_sidebar('default-sidebar')) {
			dynamic_sidebar('default-sidebar');
		} else {
			echo '<p style="padding: 20px;background-color:#f5f5f5;">'.esc_html__('Place widgets on Single Sidebar to make them appear here', 'bone').'</p>';
		}
	} else {
		if (is_active_sidebar('default-sidebar')) {
			dynamic_sidebar('default-sidebar');
		} else {
			echo '<p style="padding: 20px;background-color:#f5f5f5;">'.esc_html__('Place widgets on Default Sidebar to make them appear here', 'bone').'</p>';
		}
	}
} elseif (is_front_page()) {
	if (is_active_sidebar('home-sidebar')) {
		dynamic_sidebar('home-sidebar');
	} elseif (is_active_sidebar('default-sidebar')) {
		dynamic_sidebar('default-sidebar');
	} else {
		echo '<p style="padding: 20px;background-color:#f5f5f5;">'.esc_html__('Place widgets on Home Sidebar to make them appear here', 'bone').'</p>';
	}
} elseif (is_single()) {
	if (is_active_sidebar('single-sidebar')) {
		dynamic_sidebar('single-sidebar');
	} elseif (is_active_sidebar('default-sidebar')) {
		dynamic_sidebar('default-sidebar');
	} else {
		echo '<p style="padding: 20px;background-color:#f5f5f5;">'.esc_html__('Place widgets on Single Sidebar to make them appear here', 'bone').'</p>';
	}
} else {
	if (is_active_sidebar('default-sidebar')) {
		dynamic_sidebar('default-sidebar');
	} else {
		echo '<p style="padding: 20px;background-color:#f5f5f5;">'.esc_html__('Place widgets on Default Sidebar to make them appear here', 'bone').'</p>';
	}
}

if ($sticky_sidebar == '1') {
	echo '</div>';
}