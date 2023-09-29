<?php
/*
 * This is the config function for the theme.
 */
if ( ! function_exists( 'minimaldog_set_global_var' ) ) {
    function minimaldog_set_global_var() {
        define("MINIMALDOG_THEME_NAME", "Bone");
        define("MINIMALDOG_THEME_VERSION", "2.2.2");
        define("MINIMALDOG_THEME_DEMO_URL", "http://" . strtolower(MINIMALDOG_THEME_NAME) . "minimaldog.net");

        /**
         * dev demo deploy
         */

        if (!defined('MINIMALDOG_DEPLOY_MODE')) {
            define("MINIMALDOG_DEPLOY_MODE", 'deploy');
        }

        /**
         * the js files that are used on frontend
         * @var array
         */
        global $md_bone_js_files;
        $md_bone_js_files = array(
            'bootstrap' => '/lib/vendor/bootstrap/bootstrap.min.js',
            'sticky-sidebar' => '/js/theia-sticky-sidebar.js',
            'owlcarousel' => '/lib/vendor/owlcarousel/owl.carousel.min.js',
            'fotorama' => '/lib/vendor/fotorama/fotorama.js',
            'iscroll' => '/lib/vendor/iscroll/iscroll.js',
            'zoom' => '/lib/vendor/zoomjs/js/zoom.js',
            'post-like' => '/js/post-like.js',
            'smoothscroll' => '/js/SmoothScroll.js',
            'raf-polyfill' => '/js/raf-polyfill.js',
            'md-bone-scripts' => '/js/md-scripts-dev.js',
        );
    }
}

add_action( 'init', 'minimaldog_set_global_var' );