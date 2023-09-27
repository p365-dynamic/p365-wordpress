<?php
/**
 * WooCommerce support
 */
add_action( 'after_setup_theme', 'woocommerce_support' );
if ( ! function_exists( 'woocommerce_support' ) ) {
	function woocommerce_support() {
	    add_theme_support( 'woocommerce' );
	}
}

/**
 * Query WooCommerce activation
 */
if ( ! function_exists( 'is_woocommerce_activated' ) ) {
	function is_woocommerce_activated() {
		return class_exists( 'woocommerce' ) ? true : false;
	}
}

/**
 * Call a shortcode function by tag name.
 *
 * @param string $tag     The shortcode whose function to call.
 * @param array  $atts    The attributes to pass to the shortcode function. Optional.
 * @param array  $content The shortcode's content. Default is null (none).
 *
 * @return string|bool False on failure, the result of the shortcode on success.
 */
if ( ! function_exists( 'minimaldog_do_shortcode' ) ) {
	function minimaldog_do_shortcode( $tag, array $atts = array(), $content = null ) {

		global $shortcode_tags;

		if ( ! isset( $shortcode_tags[ $tag ] ) ) {
			return false;
		}

		return call_user_func( $shortcode_tags[ $tag ], $atts, $content, $tag );
	}
}

if ( ! function_exists( 'minimaldog_product_categories' ) ) {
	/**
	 * Display Product Categories
	 */
	function minimaldog_product_categories( $args = array() ) {

		if ( is_woocommerce_activated() ) {

			if (empty($args)) {
				$args = array(
					'limit' 			=> 3,
					'columns' 			=> 3,
					'child_categories' 	=> 0,
					'orderby' 			=> 'name',
					'title'				=> esc_html__( 'Product Categories', 'bone' ),
					);
			};

			echo '<section class="minimaldog-productSection minimaldog-productCategories">';

				echo '<h2 class="sectionTitle metaFont">' . wp_kses_post( $args['title'] ) . '</h2>';

				echo minimaldog_do_shortcode( 'product_categories',
					array(
						'number' 	=> intval( $args['limit'] ),
						'columns'	=> intval( $args['columns'] ),
						'orderby'	=> esc_attr( $args['orderby'] ),
						'parent'	=> esc_attr( $args['child_categories'] ),
						) );

			echo '</section>';

		}
	}
}

if ( ! function_exists( 'minimaldog_recent_products' ) ) {
	/**
	 * Display Recent Products
	 */
	function minimaldog_recent_products( $args = array() ) {

		if ( is_woocommerce_activated() ) {

			if (empty($args)) {
				$args = array(
					'limit' 			=> 4,
					'columns' 			=> 4,
					'title'				=> esc_html__( 'Recent Products', 'bone' ),
					);
			}

			echo '<section class="minimaldog-productSection minimaldog-recentProducts">';

				echo '<h2 class="sectionTitle metaFont">' . wp_kses_post( $args['title'] ) . '</h2>';

				echo minimaldog_do_shortcode( 'recent_products',
					array(
						'per_page' 	=> intval( $args['limit'] ),
						'columns'	=> intval( $args['columns'] ),
						) );

			echo '</section>';
		}
	}
}

if ( ! function_exists( 'minimaldog_featured_products' ) ) {
	/**
	 * Display Featured Products
	 */
	function minimaldog_featured_products( $args = array() ) {

		if ( is_woocommerce_activated() ) {

			if (empty($args)) {
				$args = array(
					'limit' 			=> 4,
					'columns' 			=> 4,
					'orderby'			=> 'date',
					'order'				=> 'desc',
					'title'				=> esc_html__( 'Featured Products', 'bone' ),
					);
			}

			echo '<section class="minimaldog-productSection minimaldog-featuredProducts">';

				echo '<h2 class="sectionTitle metaFont">' . wp_kses_post( $args['title'] ) . '</h2>';

				echo minimaldog_do_shortcode( 'featured_products',
					array(
						'per_page' 	=> intval( $args['limit'] ),
						'columns'	=> intval( $args['columns'] ),
						'orderby'	=> esc_attr( $args['orderby'] ),
						'order'		=> esc_attr( $args['order'] ),
						) );

			echo '</section>';

		}
	}
}

if ( ! function_exists( 'minimaldog_popular_products' ) ) {
	/**
	 * Display Popular Products
	 */
	function minimaldog_popular_products( $args = array() ) {

		if ( is_woocommerce_activated() ) {

			if (empty($args)) {
				$args = array(
					'limit' 			=> 4,
					'columns' 			=> 4,
					'title'				=> esc_html__( 'Top Rated Products', 'bone' ),
					);
			}

			echo '<section class="minimaldog-productSection minimaldog-popularProducts">';

				echo '<h2 class="sectionTitle metaFont">' . wp_kses_post( $args['title'] ) . '</h2>';

				echo minimaldog_do_shortcode( 'top_rated_products',
					array(
						'per_page' 	=> intval( $args['limit'] ),
						'columns'	=> intval( $args['columns'] ),
						) );

			echo '</section>';

		}
	}
}

if ( ! function_exists( 'minimaldog_on_sale_products' ) ) {
	/**
	 * Display On Sale Products
	 */
	function minimaldog_on_sale_products( $args = array() ) {

		if ( is_woocommerce_activated() ) {

			if (empty($args)) {
				$args = array(
					'limit' 			=> 4,
					'columns' 			=> 4,
					'title'				=> esc_html__( 'On Sale', 'bone' ),
					);
			}

			echo '<section class="minimaldog-productSection minimaldog-onSaleProducts">';

				echo '<h2 class="sectionTitle metaFont">' . wp_kses_post( $args['title'] ) . '</h2>';

				echo minimaldog_do_shortcode( 'sale_products',
					array(
						'per_page' 	=> intval( $args['limit'] ),
						'columns'	=> intval( $args['columns'] ),
						) );

			echo '</section>';

		}
	}
}

/**
 * Display Cart Link
 * @uses  is_woocommerce_activated() check if WooCommerce is activated
 * @return void
 */
if ( ! function_exists( 'minimaldog_cart_link' ) ) {
	function minimaldog_cart_link() {
		if ( is_woocommerce_activated() ) {
			$count = wp_kses_data( WC()->cart->get_cart_contents_count() );
			if ($count !== '0') {
				$count = '<span class="count">'.$count.'<span class="count-text"> '.wp_kses_data( sprintf( _n( 'item', 'items', WC()->cart->get_cart_contents_count(), 'bone' ), WC()->cart->get_cart_contents_count() )).'</span></span>';
			} else {
				$count = '';
			}
			?>
			<a class="btn btn--pill cart-contents" href="<?php echo esc_url( WC()->cart->get_cart_url() ); ?>" title="<?php _e( 'View your shopping cart', 'bone' ); ?>">
				<i class="fa fa-shopping-cart"></i>
				<span class="amount"><?php echo wp_kses_data( WC()->cart->get_cart_subtotal() ); ?></span>
				<?php echo $count; ?>
			</a>
		<?php
		}
	}
}

/**
 * Display Header Cart
 * @uses  is_woocommerce_activated() check if WooCommerce is activated
 * @return void
 */
if ( ! function_exists( 'minimaldog_header_cart' ) ) {
	function minimaldog_header_cart() {
		if ( is_woocommerce_activated() ) {
		?>
		<div class="headerCart-wrapper">
			<?php minimaldog_cart_link(); ?>
			<?php if (!is_cart()) { ?>
			<div class="headerCart-popover popover popover--bottom popover--alignRight">
				<div class="popover-arrow"></div>
				<?php the_widget( 'WC_Widget_Cart', 'title=' ); ?>
			</div>
			<?php } ?>
		</div>
		<?php
		}
	}
}

/**
 * Display Offcanvas Cart
 * @uses  is_woocommerce_activated() check if WooCommerce is activated
 * @return void
 */
if ( ! function_exists( 'minimaldog_compact_cart' ) ) {
	function minimaldog_compact_cart() {
		if ( is_woocommerce_activated() ) {
		?>
		<div class="compactCart">
			<h4 class="compactCart-title metaFont"><?php esc_html_e('Your cart', 'bone'); ?></h4>
			<div class="compactCart-info">
				<?php minimaldog_cart_link(); ?>
			</div>
		</div>
		<?php
		}
	}
}

/**
 * woo_hide_page_title
 *
 * Removes the "shop" title on the main shop page
 *
 * @access      public
 * @since       1.0 
 * @return      void
*/
if ( ! function_exists( 'minimaldog_woocommerce_hide_page_title' ) ) {
	function minimaldog_woocommerce_hide_page_title() {
		return false;
	}
}

add_filter( 'woocommerce_show_page_title' , 'minimaldog_woocommerce_hide_page_title' );

/**
 * Cart Fragments
 * Ensure cart contents update when products are added to the cart via AJAX
 * @param  array $fragments Fragments to refresh via AJAX
 * @return array            Fragments to refresh via AJAX
 */
if ( ! function_exists( 'minimaldog_cart_link_fragment' ) ) {
	function minimaldog_cart_link_fragment( $fragments ) {
		global $woocommerce;

		ob_start();

		minimaldog_cart_link();

		$fragments['a.cart-contents'] = ob_get_clean();

		return $fragments;
	}
}

if ( defined( 'WC_VERSION' ) && version_compare( WC_VERSION, '2.3', '>=' ) ) {
	add_filter( 'woocommerce_add_to_cart_fragments', 'minimaldog_cart_link_fragment' );
} else {
	add_filter( 'add_to_cart_fragments', 'minimaldog_cart_link_fragment' );
}