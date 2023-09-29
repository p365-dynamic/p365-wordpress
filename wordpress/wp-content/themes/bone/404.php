<?php
get_header('404');
$error_text = md_bone_get_option('404-text', esc_html__('Sorry, but nothing exists here.', 'bone'));
?>
<div class="errorPage">
	<div class="errorPage-body">
		<div class="errorPage-icon titleFont">404</div>
		<div class="errorPage-content">
			<div class="errorPage-message titleFont"><?php echo esc_html($error_text); ?></div>
			<div class="errorPage-message errorPage-message--small metaFont"><?php esc_html_e('Try some searching or', 'bone'); ?>&nbsp;<a href="<?php echo esc_url(get_home_url()); ?>"><?php esc_html_e('Go back Home.', 'bone'); ?></a></div>
			<div class="errorPage-search">
				<?php get_search_form(); ?>
			</div>
		</div>		
	</div>
</div>