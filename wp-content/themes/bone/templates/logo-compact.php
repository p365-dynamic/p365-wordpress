<?php
	$header_logo = md_bone_get_option('logo', NULL);
	if ( $header_logo != NULL ) {
		if ( $header_logo['url'] == '' ) { $header_logo = NULL; }
	}
	$header_logo_2x = md_bone_get_option('logo-2x', NULL);
	if ( $header_logo_2x != NULL ) {
		if ( $header_logo_2x['url'] == '' ) { $header_logo_2x = NULL; }
	}
	$logo_style = '';
	$logo_padding = md_bone_get_option('logo-padding', array());
	if (!empty($logo_padding)) {
		$logo_max_height = (string)(65 - (int)$logo_padding['padding-top'] - (int)$logo_padding['padding-bottom']).'px';
		$logo_style .= 'max-height:'.$logo_max_height.';';
	}
?>
<?php if ( $header_logo ) { ?>
	<a class="siteLogo siteLogo--image" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php bloginfo( 'name'); ?>" rel="home">
		<img src="<?php echo esc_url($header_logo['url']); ?>" width="<?php echo esc_attr($header_logo['width']); ?>" height="<?php echo esc_attr($header_logo['height']); ?>"<?php if($header_logo_2x) { echo ' data-hidpi="'.$header_logo_2x['url'].'"'; } ?> rel="logo" alt="<?php bloginfo( 'name'); ?>"<?php if ($logo_style) echo ' style="'.esc_attr($logo_style).'"'; ?>>
	</a>
<?php } else { ?>
	<a class="siteLogo siteLogo--text" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php bloginfo( 'name'); ?>" rel="home">
		<div class="siteLogo-name"><?php bloginfo('name'); ?></div>
	</a>
<?php } ?>