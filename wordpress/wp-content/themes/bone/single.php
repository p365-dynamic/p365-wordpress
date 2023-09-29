<?php
$article_schema_type = '';
$article_body_schema = '';

$single_layout = md_bone_get_single_layout();
$sidebar_position = md_bone_get_metabox( 'post-sidebar-position', 'default' );
if ($sidebar_position == 'default') {
	$sidebar_position = md_bone_get_option('single-sidebar-position', 'right');
}
$review_switch = md_bone_get_metabox( 'review_switch', '0' );
if ($review_switch == '1') {
    $article_schema_type = 'http://schema.org/Review';
    $article_body_schema = 'reviewBody';
} else {
    $article_schema_type = 'http://schema.org/BlogPosting';
    $article_body_schema = 'articleBody';
}
$sticky_sidebar = md_bone_get_option('sticky-sidebar', '1');
$main_classes = '';
$sidebar_classes = '';
if($sidebar_position == 'right') {
	$main_classes .= ' hasRightSidebar';
	$sidebar_classes .= ' sidebar--right';
} elseif($sidebar_position == 'left') {
	$main_classes .= ' hasLeftSidebar';
	$sidebar_classes .= ' sidebar--left';
}
if($sticky_sidebar) {
	$sidebar_classes .= ' js-sticky-sidebar';
}

if (locate_template('templates/single-'.$single_layout.'.php')) {
	require(locate_template('templates/single-'.$single_layout.'.php'));
} else {
	require(locate_template('templates/single-standard.php'));
}