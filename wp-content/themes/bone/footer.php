<?php
	$single_layout = md_bone_get_single_layout();
	$backtop = md_bone_get_option('back-top-switch', '1');
	$header_login = md_bone_get_option('header-login-switch', '1');

	// addThis script load condition
	$loadAddThis = false;
	if (is_single()) {
		$loadAddThis = true;
	} elseif (is_category()) {
		$content_layout = md_bone_get_option('category-content-layout', '');
		if ($content_layout === 'classic') {
			$loadAddThis = true;
		}
	} elseif (is_search()) {
		$content_layout = md_bone_get_option('search-content-layout', '');
		if ($content_layout === 'classic') {
			$loadAddThis = true;
		}
	} elseif (is_archive()) {
		$content_layout = md_bone_get_option('archive-content-layout', '');
		if ($content_layout === 'classic') {
			$loadAddThis = true;
		}
	}  elseif (is_home()) {
		$content_layout = md_bone_get_option('content-layout', '');
		if ($content_layout === 'classic') {
			$loadAddThis = true;
		}
	}
?>

		<footer id="footer" class="siteFooter">
			<?php if ( has_nav_menu( 'footer-menu' ) ) { ?>
			<div class="siteFooter-top">
				<div class="container">
					<nav class="siteFooter-menu navigation navigation--footer">
						<?php
						wp_nav_menu(array(
							'theme_location' => 'footer-menu',
							'container' => false,
							'depth' => 1,
							'fallback_cb' => false,
						));
						?>
					</nav>
				</div>
			</div>
			<?php } ?>

			<?php if(is_active_sidebar('footer-sidebar-1') || is_active_sidebar('footer-sidebar-2') || is_active_sidebar('footer-sidebar-3')) { ?>
			<div class="siteFooter-middle">
				<div class="container">
					<div class="siteFooter-middle-inner clearfix">
						<?php if(is_active_sidebar('footer-sidebar-1')) { ?>
						<div class="siteFooter-widgetArea siteFooter-widgetArea--1">
						<?php dynamic_sidebar('footer-sidebar-1'); ?>	
						</div>
						<?php } ?>

						<?php if(is_active_sidebar('footer-sidebar-2')) { ?>
						<div class="siteFooter-widgetArea siteFooter-widgetArea--2">
						<?php dynamic_sidebar('footer-sidebar-2'); ?>	
						</div>
						<?php } ?>

						<?php if(is_active_sidebar('footer-sidebar-3')) { ?>
						<div class="siteFooter-widgetArea siteFooter-widgetArea--3">
						<?php dynamic_sidebar('footer-sidebar-3'); ?>	
						</div>
						<?php } ?>
					</div>
				</div>
			</div>
			<?php } ?>
			
			<div class="siteFooter-bottom">
				<div class="container">
					<div class="siteFooter-bottom-inner clearfix">
						<div class="siteFooter-copyright u-floatLeft metaFont">
							<?php echo md_bone_get_option('copyright-text','2016 &copy; <a href="http://minimaldog.net">minimaldog</a>'); ?>
						</div>
						<div class="siteFooter-backTop u-floatRight">
							<!-- Back top button -->
							<div class="backTopBtn metaFont js-scrolltop-btn"><?Php esc_html_e('Back to top', 'bone'); ?>&nbsp;<i class="fa fa-arrow-up"></i></div>
						</div>
					</div>
				</div>
			</div>
			
		</footer>
	</div>
	<!-- siteWrap -->
	
	<!-- Offcanvas menu -->
	<div id="md_offCanvasMenu" class="md_offCanvasMenu md_offCanvas md_offCanvas--left">
		<div class="offCanvasClose metaFont js-offCanvasClose"><i class="fa fa-times-circle"></i><?php esc_html_e('Close', 'bone') ?></div>
		<div class="md_offCanvasMenu-social">
			<?php get_template_part('templates/site-social-inline'); ?>
		</div>
		<nav class="navigation navigation--offCanvas md_offCanvasMenu-navigation">
			<?php
			if ( has_nav_menu( 'main-menu' ) ) {
				wp_nav_menu( array(
					'container' => false,
					'theme_location' => 'main-menu',
					'fallback_cb' => false,
					'depth' => 3,
				) );
			} else {
				echo '<a href="'.admin_url( 'nav-menus.php' ).'" class="menuSettingLink">'.esc_html__('Set up main navigation', 'bone').'&nbsp;&raquo;</a>';
			}
			?>
		</nav>

		<?php if (is_woocommerce_activated()) { ?>
		<div class="md_offCanvasMenu-cart">
			<?php minimaldog_compact_cart(); ?>
		</div>
		<?php } ?>

		<?php if ($header_login === '1') { ?>
		<div class="md_offCanvasMenu-userActions">
			<?php get_template_part('templates/user-actions-list'); ?>
		</div>
		<?php } ?>
	</div>
	
	<?php
	if ($header_login === '1') {
	?>
	<!-- Login form modal -->					
	<div id="js-login-wrapper" class="loginFormWrapper modal fade" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-close" data-dismiss="modal" aria-label="Close"><i class="fa fa-times-circle"></i></div>
			<?php wp_login_form(); ?>
			<a href="<?php echo wp_registration_url( get_permalink() ); ?>" title="<?php esc_html__('Register', 'bone'); ?>" class="btn btn--pill login-register"><?php esc_html_e('Register', 'bone'); ?></a>
			<a href="<?php echo wp_lostpassword_url( get_permalink() ); ?>" title="<?php esc_html__('Lost Password', 'bone'); ?>" class="login-lostPwd metaFont"><?php esc_html_e('Forgot Password ?', 'bone'); ?></a>
		</div>
	</div>
	<?php } ?>

	<?php if ( $loadAddThis ) {?>
	<?php $AddThisID = md_bone_get_option('addthis-id', ''); ?>
	<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js<?php if ($AddThisID) echo '#pubid='.esc_attr($AddThisID); ?>" async="async"></script>
	<?php } ?>

	<?php wp_footer(); ?>
</body>
</html>