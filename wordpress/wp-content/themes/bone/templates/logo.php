<?php
	$header_logo = md_bone_get_option('logo', NULL);
	if ( $header_logo != NULL ) {
		if ( $header_logo['url'] == '' ) { $header_logo = NULL; }
	}
	$header_logo_2x = md_bone_get_option('logo-2x', NULL);
	if ( $header_logo_2x != NULL ) {
		if ( $header_logo_2x['url'] == '' ) { $header_logo_2x = NULL; }
	}
?>
<div class="siteTitle siteTitle--default metaFont">
<?php if ( $header_logo ) { ?>
	<a class="siteLogo siteLogo--image" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php bloginfo( 'name'); ?>" rel="home">
		<img src="<?php echo esc_url($header_logo['url']); ?>" width="<?php echo esc_attr($header_logo['width']); ?>" height="<?php echo esc_attr($header_logo['height']); ?>"<?php if($header_logo_2x) { echo ' data-hidpi="'.$header_logo_2x['url'].'"'; } ?> rel="logo" alt="<?php bloginfo( 'name'); ?>">
	</a>
<?php } else { ?>
	<a class="siteLogo siteLogo--text" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php bloginfo( 'name'); ?>" rel="home">
		<div class="siteLogo-name"><?php bloginfo('name'); ?></div>
		<div class="siteLogo-description"><?php bloginfo('description'); ?></div>
	</a>
<?php } ?>
</div>