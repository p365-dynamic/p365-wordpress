<?php
	$sticky_header = md_bone_get_option('sticky-header', '1');
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />	
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<!-- siteWrap -->
	<div class="siteWrap">
		<?php
		if(is_active_sidebar('header-sidebar')) { ?>
			<div class="siteHeader-widgetArea">
			<?php dynamic_sidebar('header-sidebar'); ?>
			</div>
		<?php } ?>

		<!-- siteHeader -->
		<header class="siteHeader siteHeader--standard siteHeader--standard--center">
			<div class="siteHeader-content hidden-xs hidden-sm">
				<div class="container">
					<div class="flexbox">
						<div class="siteHeader-content-component siteHeader-component--left flexbox-item">
							<?php get_template_part('templates/site-social-inline'); ?>
						</div>
						<div class="siteHeader-content-component siteHeader-component--center flexbox-item">
							<?php get_template_part('templates/logo'); ?>
						</div>
						<div class="siteHeader-content-component siteHeader-component--right flexbox-item">
							<?php
							$header_login = md_bone_get_option('header-login-switch', '1');
							if ($header_login === '1') {
								get_template_part('templates/user-actions');
							} else { ?>
								<div class="currentDate metaFont"><i class="fa fa-calendar"></i><?php echo date_i18n('l, F jS, Y'); ?></div>
							<?php } ?>
						</div>
					</div>						
				</div>
			</div>
			
			<div class="siteHeader-nav js-searchOuter">
				<div class="container">
					<div class="flexbox">
						<div class="siteHeader-component--left flexbox-item hidden-md hidden-lg">
							<div class="menuToggleBtn js-menu-toggle btn btn--circle hidden-sm hidden-md hidden-lg"><i class="fa fa-navicon"></i></div>
							<div class="menuToggleBtn js-menu-toggle btn btn--pill hidden-xs"><i class="fa fa-navicon"></i><span><?php esc_html_e('Menu', 'bone'); ?></span></div>
						</div>
						<div class="siteHeader-component--center flexbox-item hidden-md hidden-lg">
							<?php get_template_part('templates/logo-small'); ?>
						</div>
						
						<nav class="navigation navigation--main navigation--standard hidden-xs hidden-sm flexbox-item">
							<?php
							if ( has_nav_menu( 'main-menu' ) ) {
								wp_nav_menu( array(
									'container' => false,
									'theme_location' => 'main-menu',
									'fallback_cb' => false,
									'depth' => 4,
								) );
							} else {
								echo '<a href="'.admin_url( 'nav-menus.php' ).'" class="menuSettingLink">'.esc_html__('Set up main navigation', 'bone').'&nbsp;&raquo;</a>';
							}
							?>
						</nav>

						<div class="siteHeader-component--right flexbox-item">
							<div class="compactSearch">
								<?php get_search_form(); ?>
								<div class="searchToggleBtn btn btn--circle js-searchToggle hidden-sm"><i class="fa fa-search iconSearch"></i><i class="fa fa-times iconClose"></i></div>
								<div class="searchToggleBtn btn btn--pill js-searchToggle hidden-xs hidden-md hidden-lg"><i class="fa fa-search iconSearch"></i><i class="fa fa-times iconClose"></i><span><?php esc_html_e('Search', 'bone'); ?></span></div>
							</div>
							
							<?php if (is_woocommerce_activated()) { ?>
							<div class="headerCart hidden-xs hidden-sm">
								<?php minimaldog_header_cart(); ?>
							</div>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
			
			<?php if ($sticky_header === '1') { ?>
			<div class="siteHeader--fixed js-fixedHeader js-searchOuter">
				<div class="container">
					<div class="flexbox">
						<div class="flexbox-item">
							<nav class="navigation navigation--main navigation--standard hidden-xs hidden-sm">
								<?php
								if ( has_nav_menu( 'main-menu' ) ) {
									wp_nav_menu( array(
										'container' => false,
										'theme_location' => 'main-menu',
										'fallback_cb' => false,
										'depth' => 4,
									) );
								} else {
									echo '<a href="'.admin_url( 'nav-menus.php' ).'" class="menuSettingLink">'.esc_html__('Set up main navigation', 'bone').'&nbsp;&raquo;</a>';
								}
								?>
							</nav>
						</div>

						<div class="flexbox-item u-alignRight">
							<div class="compactSearch">
								<?php get_search_form(); ?>
								<div class="searchToggleBtn btn btn--circle js-searchToggle"><i class="fa fa-search iconSearch"></i><i class="fa fa-times iconClose"></i></div>
							</div>

							<?php if (is_woocommerce_activated()) { ?>
							<div class="headerCart hidden-xs hidden-sm">
								<?php minimaldog_header_cart(); ?>
							</div>
							<?php } ?>
						</div>
					</div>

				</div>
			</div>
			<?php } ?>

		</header>
		<!-- site-header -->