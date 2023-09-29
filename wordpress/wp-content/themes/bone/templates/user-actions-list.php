<?php
$current_user = wp_get_current_user(); 
if ( !is_user_logged_in() ) { ?>
	<div class="signin-btn btn btn--pill btn--solid" data-toggle="modal" data-target="#js-login-wrapper"><i class="fa fa-user"></i><span><?php esc_html_e('Sign in / Join', 'bone'); ?></span></div>
<?php } else { ?>
<div class="userActions metaFont">
	<div class="userActions-btn btn btn--pill js-popover-toggle"><span class="name"><?php echo esc_html($current_user->display_name); ?></span><?php echo get_avatar( get_current_user_id(), 36, '', esc_html__('Avatar', 'bone') ); ?></div>
		<ul class="userActions-links">
			<li><a href="<?php echo esc_url(get_author_posts_url( get_current_user_id() )); ?>"><?php esc_html_e('Profile', 'bone') ?></a></li><!--
			--><li><a href="<?php echo esc_url(get_edit_user_link()); ?> "><?php esc_html_e('Settings', 'bone') ?></a></li><!--
			--><li><a href="<?php echo esc_url(wp_logout_url( add_query_arg( NULL, NULL ) )); ?>"><?php esc_html_e('Logout', 'bone') ?></a></li>
		</ul>
</div>
<?php }