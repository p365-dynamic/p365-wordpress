<?php
// For more information, visit: https://codex.wordpress.org/Child_Themes
function bone_child_theme_enqueue_scripts() {
	$current_theme = wp_get_theme();
    wp_enqueue_style( 'md-bone-child-style', get_stylesheet_directory_uri() . '/style.css', '', $current_theme->get( 'Version' ));
    wp_enqueue_script('md-bone-child-scripts', get_stylesheet_directory_uri() . '/js/bone-child-scripts.js', array('jquery'), $current_theme->get( 'Version' ), true);
}
add_action( 'wp_enqueue_scripts', 'bone_child_theme_enqueue_scripts', 999 );

/**
 * Setup My Child Theme's textdomain.
 *
 * Declare textdomain for this child theme.
 * Translations can be filed in the /languages/ directory.
 */
function bone_child_theme_setup() {
    load_child_theme_textdomain( 'bone-child', get_stylesheet_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'bone_child_theme_setup' );
