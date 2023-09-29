<?php
    if ( ! class_exists( 'Redux' ) ) {
        return;
    }

    // This is your option name where all the Redux data is stored.
    $opt_name = "md_bone_opt";

    /**
     * ---> SET ARGUMENTS
     * All the possible arguments for Redux.
     * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
     * */

    $theme = wp_get_theme(); // For use with some settings. Not necessary.

    $args = array(
        // TYPICAL -> Change these values as you need/desire
        'opt_name'             => $opt_name,
        // This is where your data is stored in the database and also becomes your global variable name.
        'display_name'         => $theme->get( 'Name' ),
        // Name that appears at the top of your panel
        'display_version'      => $theme->get( 'Version' ),
        // Version that appears at the top of your panel
        'menu_type'            => 'menu',
        //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
        'allow_sub_menu'       => true,
        // Show the sections below the admin menu item or not
        'menu_title'           => esc_html__( 'Theme Options', 'bone' ),
        'page_title'           => esc_html__( 'Theme Options', 'bone' ),
        // You will need to generate a Google API key to use this feature.
        // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
        'google_api_key'       => 'AIzaSyBdxbxgVuwQcnN5xCZhFDSpouweO-yJtxw',
        // Set it you want google fonts to update weekly. A google_api_key value is required.
        'google_update_weekly' => true,
        // Must be defined to add google fonts to the typography module
        'async_typography'     => true,
        // Use a asynchronous font on the front end or font string
        'disable_google_fonts_link' => false,
        // Disable this in case you want to create your own google fonts loader
        'admin_bar'            => true,
        // Show the panel pages on the admin bar
        'admin_bar_icon'       => 'dashicons-admin-generic',
        // Choose an icon for the admin bar menu
        'admin_bar_priority'   => 50,
        // Choose an priority for the admin bar menu
        'global_variable'      => '',
        // Set a different name for your global variable other than the opt_name
        'dev_mode'             => false,
        // Show the time the page took to load, etc
        'update_notice'        => true,
        // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
        'customizer'           => true,
        // Enable basic customizer support
        //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
        //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

        // OPTIONAL -> Give you extra features
        'page_priority'        => null,
        // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
        'page_parent'          => 'themes.php',
        // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
        'page_permissions'     => 'manage_options',
        // Permissions needed to access the options panel.
        'menu_icon'            => '',
        // Specify a custom URL to an icon
        'last_tab'             => '',
        // Force your panel to always open to a specific tab (by id)
        'page_icon'            => 'icon-themes',
        // Icon displayed in the admin panel next to your menu_title
        'page_slug'            => '',
        // Page slug used to denote the panel, will be based off page title then menu title then opt_name if not provided
        'save_defaults'        => true,
        // On load save the defaults to DB before user clicks save or not
        'default_show'         => false,
        // If true, shows the default value next to each field that is not the default value.
        'default_mark'         => '',
        // What to print by the field's title if the value shown is default. Suggested: *
        'show_import_export'   => true,
        // Shows the Import/Export panel when not used as a field.

        // CAREFUL -> These options are for advanced use only
        'transient_time'       => '3600',
        'output'               => true,
        // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
        'output_tag'           => true,
        // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
        'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

        // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
        // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
        'use_cdn'              => true,
        // If you prefer not to use the CDN for Select2, Ace Editor, and others, you may download the Redux Vendor Support plugin yourself and run locally or embed it in your code.

        // HINTS
        'hints'                => array(
            'icon'          => 'el el-question-sign',
            'icon_position' => 'right',
            'icon_color'    => 'lightgray',
            'icon_size'     => 'normal',
            'tip_style'     => array(
                'color'   => 'red',
                'shadow'  => true,
                'rounded' => false,
                'style'   => '',
            ),
            'tip_position'  => array(
                'my' => 'top left',
                'at' => 'bottom right',
            ),
            'tip_effect'    => array(
                'show' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'mouseover',
                ),
                'hide' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'click mouseleave',
                ),
            ),
        )
    );

    // ADMIN BAR LINKS -> Setup custom links in the admin bar menu as external items.
    $args['admin_bar_links'][] = array(
        'id'    => 'bone-docs',
        'href'  => 'http://bone.minimaldog.net/documentation/index.htm',
        'title' => esc_html__( 'Documentation', 'bone' ),
    );

    $args['admin_bar_links'][] = array(
        'id'    => 'bone-support',
        'href'  => 'https://minimaldog.ticksy.com/',
        'title' => esc_html__( 'Support', 'bone' ),
    );

    // SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
    $args['share_icons'][] = array(
        'url'   => 'http://minimaldog.net',
        'title' => 'Visit us on GitHub',
        'icon'  => 'el el-globe'
        //'img'   => '', // You can use icon OR img. IMG needs to be a full URL.
    );
    $args['share_icons'][] = array(
        'url'   => 'https://www.facebook.com/minimaldog.net',
        'title' => 'Like us on Facebook',
        'icon'  => 'el el-facebook'
    );
    $args['share_icons'][] = array(
        'url'   => 'https://twitter.com/_minimalDog_',
        'title' => 'Follow us on Twitter',
        'icon'  => 'el el-twitter'
    );
    
    // Add content after the form.
    $args['footer_text'] = '<p><a href="http://bone.minimaldog.net/documentation/index.htm" target="_blank">'.esc_html__('Documentation', 'bone').'</a>&nbsp;&middot;&nbsp;<a href="https://minimaldog.ticksy.com/" target="_blank">'.esc_html__('Support', 'bone' ).'</a></p>';

    Redux::setArgs( $opt_name, $args );

    /*
     * ---> END ARGUMENTS
     */

    /*
     *
     * ---> START SECTIONS
     *
     */

    /*

        As of Redux 3.5+, there is an extensive API. This API can be used in a mix/match mode allowing for


     */

    /*
     * ---> CSS selectors outputs
     */
    $primary_color_output_bg = ''; $primary_color_output = '';

    // Content color
    $primary_color_output_bg .= '.primaryBgColor,input[type="submit"],.postCategory,.progressContainer-bar,.reviewMeter-item-score,.reviewBox-summary-totalScore-wrap,.postTitle .featuredBadge,.btn.btn--solid,.postFormatLink .o-backgroundImg,.featuredBlock--slider article.noThumb,.post--review-meter-bar,.post--review-score, .post--tile.noThumb,.commentCountBox,.byCategoryListing-title i,';
    // Widget color
    $primary_color_output_bg .= '.categoryTile .o-backgroundImg,.mdPostsListWidget .list-index,.widget_archive li:hover:after,.widget_calendar caption,.widget_calendar #today,.block-title span:after,.widget_mc4wp_form_widget input[type="submit"],';
    // Navigation color
    $primary_color_output_bg .= '.md-pagination .page-numbers.current,.offCanvasClose,.siteFooter-top-wrap,';
    // Woocommerce
    $primary_color_output_bg .= ' .woocommerce span.onsale, .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt, .woocommerce #respond input#submit.alt:hover, .woocommerce a.button.alt:hover, .woocommerce button.button.alt:hover, .woocommerce input.button.alt:hover, .woocommerce #respond input#submit:hover, .woocommerce a.button:hover, .woocommerce button.button:hover, .woocommerce input.button:hover, .woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button, .woocommerce #respond input#submit.alt.disabled, .woocommerce #respond input#submit.alt.disabled:hover, .woocommerce #respond input#submit.alt:disabled, .woocommerce #respond input#submit.alt:disabled:hover, .woocommerce #respond input#submit.alt:disabled[disabled], .woocommerce #respond input#submit.alt:disabled[disabled]:hover, .woocommerce a.button.alt.disabled, .woocommerce a.button.alt.disabled:hover, .woocommerce a.button.alt:disabled, .woocommerce a.button.alt:disabled:hover, .woocommerce a.button.alt:disabled[disabled], .woocommerce a.button.alt:disabled[disabled]:hover, .woocommerce button.button.alt.disabled, .woocommerce button.button.alt.disabled:hover, .woocommerce button.button.alt:disabled, .woocommerce button.button.alt:disabled:hover, .woocommerce button.button.alt:disabled[disabled], .woocommerce button.button.alt:disabled[disabled]:hover, .woocommerce input.button.alt.disabled, .woocommerce input.button.alt.disabled:hover, .woocommerce input.button.alt:disabled, .woocommerce input.button.alt:disabled:hover, .woocommerce input.button.alt:disabled[disabled], .woocommerce input.button.alt:disabled[disabled]:hover, .headerCart .cart-contents .count, .woocommerce .widget_price_filter .ui-slider .ui-slider-range, .woocommerce .widget_price_filter .ui-slider .ui-slider-handle';

    $primary_color_output .= '.primaryColor, .primaryColor:hover, .primaryColor:focus, .primaryColor:active, .authorName, .authorName a, .articleMeta-author a, .siteLogo-name,.articleTags-list > a:hover,.articleVia-list > a:hover,.articleSource-list > a:hover,.comment-author:hover,.bodyCopy a:hover,.post--card--bg.noThumb .postInfo .postMeta--author-author a,.loginFormWrapper .modal-close i,.navigation--offCanvas li > a:hover,.navigation--offCanvas li.current-menu-item > a,.postTitle .postFormatBadge,';
    // Widget color
    $primary_color_output .=    '.widget_pages ul.children > li:before,.widget_categories ul.children > li:before,.widget_nav_menu .submenu-toggle,.widget_calendar td a,.tagcloud a:hover,.postTags-list > a:hover,.postVia-list > a:hover,.postSource-list > a:hover,.widget_recent_comments .comment-author-link,.widget_recent_comments .comment-author-link a,.tabs-nav li.active a,.widget_pages li > a:before,';
    // Article color
    $primary_color_output .=    '.postFormatBadge,.comment-author, .postMeta--author-author a,.postFormatQuote:before,.logged-in-as a:first-child,.menu--offCanvas li.current-menu-item > a,.siteFooter-copyright a, .woocommerce .star-rating, .woocommerce div.product p.price, .woocommerce div.product span.price';

    $text_body_font = array('body, .bodyCopy');

    $title_font = array('.titleFont,.postTitle,h1,h2,h3,h4,h5,h6,.widget_recent_comments .comment-author-link,.widget_recent_comments li > a,.widget_recent_entries a,.widget_rss a.rsswidget,.widget_rss .rss-date');

    $meta_font = array('label,input[type=submit],.metaText,.metaFont,.metaBtn,.postMeta,.postCategory,.blockHeading,.comment-reply-title,.wp-caption,.gallery-caption,.widget-title,.btn,.navigation,.logged-in-as,.widget_calendar table,.tagcloud a,.widget_nav_menu .menu,.widget_categories li,.widget_meta li > a,.widget_pages li,.widget_archive a,.comment-reply-title small, .woocommerce div.product .woocommerce-tabs .panel h2, .woocommerce h2, .woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button, .woocommerce .page-title, .woocommerce nav.woocommerce-pagination ul li a, .woocommerce nav.woocommerce-pagination ul li span, .woocommerce div.product form.cart .reset_variations');

    /*
     * ---> END CSS selectors outputs
     */

    // General Fields
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'General', 'bone' ),
        'id'               => 'general',
        'icon'             => 'el el-cog-alt',
        'fields'           => array(
            array(
                'id'       => 'logo',
                'type'     => 'media', 
                'url'      => true,
                'title'    => esc_html__('Site logo', 'bone'),
                'subtitle' => esc_html__('Upload a logo for your site', 'bone'),
                'desc'     => esc_html__('Any size would fit, but we recommend logo\'s resolution should be smaller than 500px x 100px', 'bone'),
                'default'  => array(),
            ),
            array(
                'id'       => 'logo-2x',
                'type'     => 'media', 
                'url'      => true,
                'title'    => esc_html__('Site logo Retina (2x)', 'bone'),
                'subtitle' => esc_html__('Retina version of your site logo', 'bone'),
                'desc'     => esc_html__('Should have double resolution of the normal logo.This will be used for high DPI devices.', 'bone'),
                'default'  => array(),
            ),
            array(
                'id'             => 'logo-padding',
                'type'           => 'spacing',
                'output'         => array('.siteTitle--default'),
                'mode'           => 'padding',
                'units'          => array('px'),
                'units_extended' => 'false',
                'title'          => esc_html__('Logo padding', 'bone'),
                'required'       => array('logo','!=',''),
                'default'            => array(
                    'padding-top'     => '0px', 
                    'padding-right'   => '0px', 
                    'padding-bottom'  => '0px', 
                    'padding-left'    => '0px',
                    'units'          => 'px', 
                )
            ),
            array(
                'id'       => 'logo-small',
                'type'     => 'media', 
                'url'      => true,
                'title'    => esc_html__('Site small logo', 'bone'),
                'desc'     => esc_html__('The logo\'s resolution should be smaller than 180px x 65px', 'bone'),
                'subtitle' => esc_html__('Upload a small version of your site logo (optional)', 'bone'),
                'default'  => array(),
            ),
            array(
                'id'       => 'logo-small-2x',
                'type'     => 'media', 
                'url'      => true,
                'title'    => esc_html__('Site small logo Retina (2x)', 'bone'),
                'subtitle' => esc_html__('Retina version of your site small logo', 'bone'),
                'desc'     => esc_html__('Should have double resolution of the normal logo.This will be used for high DPI devices.', 'bone'),
                'default'  => array(),
            ),
            array(
                'id'             => 'logo-small-padding',
                'type'           => 'spacing',
                'output'         => array('.siteTitle--small'),
                'mode'           => 'padding',
                'units'          => array('px'),
                'units_extended' => 'false',
                'title'          => esc_html__('Small logo padding', 'bone'),
                'required'       => array('logo','!=',''),
                'default'            => array(
                    'padding-top'     => '0px', 
                    'padding-right'   => '0px', 
                    'padding-bottom'  => '0px', 
                    'padding-left'    => '0px',
                    'units'          => 'px', 
                )
            ),
            array(
                'id'       => 'favicon',
                'type'     => 'media', 
                'url'      => true,
                'title'    => esc_html__('Site favicon', 'bone'),
                'subtitle' => esc_html__('For WordPress 4.2 and earlier only. If you\'re using WordPress 4.3 and later, go to Appearance &rarr; Customize &rarr; Site Identity &rarr; Site Icon', 'bone'),
                'default'  => array(),
            ),
            array(
                'id'       => 'primary-color',
                'type'     => 'color',
                'title'    => esc_html__('Primary Color', 'bone'), 
                'subtitle' => esc_html__('Pick a primary color for the theme (default: #81c483).', 'bone'),
                'default'  => '#81c483',
                'validate' => 'color',
                'output'   => array(
                    'background-color' =>   $primary_color_output_bg, 
                    'color'            =>   $primary_color_output
                )
            ),
            array(
                'id'       => 'copyright-text',
                'type'     => 'textarea',
                'title'    => esc_html__( 'Copyright text in footer', 'bone' ),
                'subtitle' => esc_html__( 'HTML Allowed (wp_kses)', 'bone' ),
                'validate' => 'html', //see http://codex.wordpress.org/Function_Reference/wp_kses_post
                'default'  => '2017 &copy; <a href="http://minimaldog.net">minimaldog theme</a>'
            ),
        )
    ) );
    
    // Typography Fields
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Typography', 'bone' ),
        'id'               => 'typography',
        'icon'             => 'el el-font',
        'fields'           => array(
            array(
                'id'          => 'title-typography',
                'type'        => 'typography',
                'title'       => esc_html__( 'Title', 'bone' ),
                'google'      => true,
                // Disable google fonts. Won't work if you haven't defined your google api key
                'font-backup' => true,
                // Select a backup non-google font in addition to a google font
                'font-style'    => false, // Includes font-style and weight. Can use font-style or font-weight to declare
                'font-weight'    => false,
                'subsets'       => true, // Only appears if google is true and subsets not set to false
                'font-size'     => false,
                'line-height'   => false,
                'text-align'    => false,
                //'word-spacing'  => true,  // Defaults to false
                'letter-spacing'=> true,  // Defaults to false
                'color'         => false,
                'preview'       => true, // Disable the previewer
                'all_styles'  => true,
                // Enable all Google Font style/weight variations to be added to the page
                'output'      => $title_font,
                // An array of CSS selectors to apply this font style to dynamically
                'units'       => 'px',
                // Defaults to px
                'subtitle'    => esc_html__( 'Typography option for title and heading.', 'bone' ),
                'default'     => array(
                    'font-family' => 'Open Sans',
                    'font-backup' => 'Arial, Helvetica, sans-serif'
                ),
            ),
            array(
                'id'          => 'body-typography',
                'type'        => 'typography',
                'title'       => esc_html__( 'Text body', 'bone' ),
                'google'      => true,
                // Disable google fonts. Won't work if you haven't defined your google api key
                'font-backup' => true,
                // Select a backup non-google font in addition to a google font
                'font-style'    => false, // Includes font-style and weight. Can use font-style or font-weight to declare
                'font-weight'    => false,
                'text-align'    => false,
                'subsets'       => true, // Only appears if google is true and subsets not set to false
                'font-size'     => false,
                'line-height'   => false,
                'word-spacing'  => true,  // Defaults to false
                'letter-spacing'=> true,  // Defaults to false
                'color'         => false,
                //'preview'       => false, // Disable the previewer
                'all_styles'  => true,
                // Enable all Google Font style/weight variations to be added to the page
                'output'      => $text_body_font,
                // An array of CSS selectors to apply this font style to dynamically
                'units'       => 'px',
                // Defaults to px
                'subtitle'    => esc_html__( 'Typography option for text body.', 'bone' ),
                'default'     => array(
                    'font-family' => 'PT Serif',
                    'font-backup' => 'Georgia, serif',
                ),
            ),
            array(
                'id'          => 'meta-typography',
                'type'        => 'typography',
                'title'       => esc_html__( 'Meta', 'bone' ),
                'google'      => true,
                // Disable google fonts. Won't work if you haven't defined your google api key
                'font-backup' => true,
                // Select a backup non-google font in addition to a google font
                'font-style'    => false, // Includes font-style and weight. Can use font-style or font-weight to declare
                'font-weight'    => false,
                'subsets'       => true, // Only appears if google is true and subsets not set to false
                'font-size'     => false,
                'line-height'   => false,
                'text-align'    => false,
                //'word-spacing'  => true,  // Defaults to false
                'letter-spacing'=> true,  // Defaults to false
                'color'         => false,
                //'preview'       => false, // Disable the previewer
                'all_styles'  => true,
                // Enable all Google Font style/weight variations to be added to the page
                'output'      => $meta_font,
                // An array of CSS selectors to apply this font style to dynamically
                'units'       => 'px',
                // Defaults to px
                'subtitle'    => esc_html__( 'Typography option for meta text, navigation, ...', 'bone' ),
                'default'     => array(
                    'font-family' => 'Open Sans',
                    'font-backup' => 'Arial, Helvetica, sans-serif'
                ),
            ),
        )
    ) );
    
    // Header Fields
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Header', 'bone' ),
        'id'               => 'header',
        'icon'             => 'el el-th-large',
        'fields'           => array(
            array(
                'id'       => 'header-layout',
                'type'     => 'image_select',
                'title'    => esc_html__( 'Header Layout', 'bone' ),
                'subtitle' => esc_html__( 'Select header layout.', 'bone' ),
                'options'  => array(
                    'standard' => array(
                        'alt' => 'Standard',
                        'img' => get_template_directory_uri() . '/img/header-1.png'
                    ),
                    'standard-center' => array(
                        'alt' => 'Standard Center',
                        'img' => get_template_directory_uri() . '/img/header-2.png'
                    ),
                    'compact' => array(
                        'alt' => 'Compact',
                        'img' => get_template_directory_uri() . '/img/header-3.png'
                    ),
                    'minimal' => array(
                        'alt' => 'Minimal',
                        'img' => get_template_directory_uri() . '/img/header-4.png'
                    )
                ),
                'default'  => 'standard'
            ),
            
            array(         
                'id'       => 'header-background',
                'type'     => 'background',
                'output'   => array('.siteHeader-content'),
                'title'    => esc_html__('Header Background', 'bone'),
                'required' => array('header-layout', '=', array('standard', 'standard-center')),
                'default'  => array(
                    'background-color' => '#ffffff',
                )
            ),
            array(
                'id'       => 'sticky-header',
                'type'     => 'switch', 
                'title'    => esc_html__('Sticky header', 'bone'),
                'default'  => true,
            ),
            array(
                'id'       => 'header-login-switch',
                'type'     => 'switch', 
                'title'    => esc_html__('Display login button in site header', 'bone'),
                'default'  => true,
            ),
        )
    ) );
    
    // Layout Fields
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Layout', 'bone' ),
        'heading'            => '',
        'id'               => 'layout',
        'icon'             => 'el el-website',
        'fields'           => array(
            array(
                'id' => 'feat-section-start',
                'type' => 'section',
                'title' => esc_html__('Featured block', 'bone'),
                'indent' => true,
            ),
            array(
                'id'       => 'feat-layout',
                'type'     => 'image_select',
                'title'    => esc_html__( 'Featured block layout', 'bone' ),
                'options'  => array(
                    'slider' => array(
                        'alt' => 'Slider',
                        'img' => get_template_directory_uri() . '/img/feat-1.png'
                    ),
                    'slider-fw' => array(
                        'alt' => 'Fullwidth Slider',
                        'img' => get_template_directory_uri() . '/img/feat-2.png'
                    ),
                    'slider-cover' => array(
                        'alt' => 'Cover Slider',
                        'img' => get_template_directory_uri() . '/img/feat-3.png'
                    ),
                    'carousel' => array(
                        'alt' => 'Parallax Carousel',
                        'img' => get_template_directory_uri() . '/img/feat-4.png'
                    ),
                    'tiles' => array(
                        'alt' => 'Tiles',
                        'img' => get_template_directory_uri() . '/img/feat-5.png'
                    ),
                    'alt' => array(
                        'alt' => 'Alternate grid',
                        'img' => get_template_directory_uri() . '/img/feat-6.png'
                    ),
                ),
                'default'  => 'slider'
            ),
            array(
                'id'       => 'slider-autoplay',
                'type'     => 'switch', 
                'title'    => esc_html__('Enable slider autoplay', 'bone'),
                'default'  => false,
                'required' => array( 'feat-layout', '=', array('slider','slider-fw','slider-cover') ),
            ),
            array(
                'id'       => 'slider-autoplay-timeout',
                'type'     => 'text',
                'title'    => esc_html__( 'Slider autoplay timeout', 'bone' ),
                'subtitle'    => esc_html__( 'Time in milisecond', 'bone' ),
                'validate' => 'numeric',
                'default'  => '5000',
                'required' => array( 'slider-autoplay', 'equals', '1' ),
            ),
            array(         
                'id'       => 'feat-background',
                'type'     => 'background',
                'title'    => esc_html__('Featured block background', 'bone'),
                'default'  => array(
                    'background-color' => '#f5f5f5',
                ),
                'output'   => array('.featuredBlockBackground'),
                'required' => array(
                    array( 'feat-layout', 'not', 'slider-fw' ),
                    array( 'feat-layout', 'not', 'slider-cover' )
                )
            ),
             array(
                'id'       => 'feat-get-post-method',
                'type'     => 'button_set',
                'title'    => esc_html__('Featured posts source', 'bone'),
                'subtitle' => esc_html__('Define how to get posts for featured block', 'bone'),
                'options'  => array(
                    'by-manual'     => esc_html__('Select manually', 'bone'),
                    'by-marked'     => esc_html__('Marked as featured', 'bone'),
                    'by-tag'        => esc_html__('By tags', 'bone'),
                    'by-category'   => esc_html__('By categories', 'bone'),
                    'by-latest'     => esc_html__('Latest', 'bone'),
                ),
                'default'  => 'by-latest',
            ),
            array(
                'id'       => 'feat-post-quantity',
                'type'     => 'spinner', 
                'title'    => esc_html__('Number of articles', 'bone'),
                'default'  => '5',
                'min'      => '0',
                'step'     => '1',
                'max'      => '50',
                'required' => array(
                    array( 'feat-layout', '!=', 'tiles' ),
                    array( 'feat-layout', '!=', 'alt' ),
                    array( 'feat-get-post-method', '!=', 'by-manual' ),
                ),
            ),
            array(
                'id'       => 'feat-post-select',
                'type'     => 'select',
                'data'     => 'post',
                'args' => array(
                    'posts_per_page' => 100
                ),
                'multi'    => true,
                'sortable' => true,
                'title'    => esc_html__( 'Posts Select', 'bone' ),
                'desc'     => esc_html__( 'Drag post item to change its order.', 'bone' ),
                'required' => array( 'feat-get-post-method', 'equals', 'by-manual' )
            ),
            array(
                'id'       => 'feat-tag-select',
                'type'     => 'select',
                'data'     => 'tag',
                'args' => array(
                    'posts_per_page' => 100
                ),
                'multi'    => true,
                'title'    => esc_html__( 'Tags Select', 'bone' ),
                'required' => array( 'feat-get-post-method', 'equals', 'by-tag' )
            ),
            array(
                'id'       => 'feat-cat-select',
                'type'     => 'select',
                'data'     => 'category',
                'args' => array(
                    'posts_per_page' => 100
                ),
                'multi'    => true,
                'title'    => esc_html__( 'Categories Select', 'bone' ),
                'required' => array( 'feat-get-post-method', 'equals', 'by-category' )
            ),
            array(
                'id' => 'feat-section-end',
                'type' => 'section',
                'indent' => false 
            ),
            array(
                'id' => 'layout-section-start',
                'type' => 'section',
                'title' => esc_html__('Content layout', 'bone'),
                'indent' => true 
            ),
            array(
                'id'       => 'sidebar-position',
                'type'     => 'image_select',
                'title'    => esc_html__( 'Sidebar position', 'bone' ),
                'options'  => array(
                    'right' => array(
                        'alt' => 'Right Sidebar',
                        'img' => get_template_directory_uri() . '/img/sidebar-right.png'
                    ),
                    'left' => array(
                        'alt' => 'Left Sidebar',
                        'img' => get_template_directory_uri() . '/img/sidebar-left.png'
                    ),
                    'none' => array(
                        'alt' => 'None',
                        'img' => get_template_directory_uri() . '/img/sidebar-none.png'
                    ),
                ),
                'default'  => 'right'
            ),
            array(
                'id'       => 'content-layout',
                'type'     => 'image_select',
                'title'    => esc_html__( 'Content Layout', 'bone' ),
                'subtitle' => esc_html__( 'Select content layout.', 'bone' ),
                'options'  => array(
                    'list' => array(
                        'alt' => 'List',
                        'img' => get_template_directory_uri() . '/img/content-1.png'
                    ),
                    'split' => array(
                        'alt' => 'Split',
                        'img' => get_template_directory_uri() . '/img/content-2.png'
                    ),
                    'masonry' => array(
                        'alt' => 'Masonry',
                        'img' => get_template_directory_uri() . '/img/content-3.png'
                    ),
                    'tiles' => array(
                        'alt' => 'Tiles',
                        'img' => get_template_directory_uri() . '/img/content-4.png'
                    ),
                    'classic' => array(
                        'alt' => 'Classic',
                        'img' => get_template_directory_uri() . '/img/content-5.png'
                    ),
                    'alt--1' => array(
                        'alt' => 'Altenative 1',
                        'img' => get_template_directory_uri() . '/img/content-6.png'
                    ),
                    'alt--2' => array(
                        'alt' => 'Altenative 2',
                        'img' => get_template_directory_uri() . '/img/content-7.png'
                    ),
                    'alt--3' => array(
                        'alt' => 'Altenative 3',
                        'img' => get_template_directory_uri() . '/img/content-8.png'
                    ),
                ),
                'default'  => 'list'
            ),
            array(
                'id'       => 'mixed-cycle',
                'type'     => 'spinner', 
                'title'    => esc_html__('Display 1 big post for each selected number of posts', 'bone'),
                'default'  => '4',
                'min'      => '1',
                'step'     => '1',
                'max'      => '50',
                'required' => array( 'content-layout', '=', array('alt--1','alt--2','alt--3') ),
            ),
            array(
                'id'       => 'pagination-type',
                'type'     => 'select',
                'title'    => esc_html__( 'Pagination type', 'bone' ),
                'options'  => array(
                    '1' => 'Standard',
                    '2' => 'Next and Previous',
                    '3' => 'Ajax load more button',
                    '4' => 'Infinity scroll'
                ),
                'default'  => '1'
            ),
            array(
                'id'       => 'sticky-sidebar',
                'type'     => 'switch', 
                'title'    => esc_html__('Smart sticky sidebar', 'bone'),
                'subtitle' => esc_html__('Keep sidebar in view', 'bone'),
                'default'  => true,
            ),
            array(
                'id' => 'layout-section-end',
                'type' => 'section',
                'indent' => false 
            ),
            array(
                'id' => 'more-reading-section-start',
                'type' => 'section',
                'title' => esc_html__('More reading section', 'bone'),
                'indent' => true 
            ),
            array(
                'id'       => 'more-reading-switch',
                'type'     => 'switch', 
                'title'    => esc_html__('Display More Reading section', 'bone'),
                'default'  => false,
            ),
            array(
                'id'       => 'more-reading-categories',
                'type'     => 'select',
                'data'     => 'categories',
                'multi'    => true,
                'sortable' => true,
                'title'    => esc_html__( 'More Reading categories select', 'bone' ),
                'desc'     => esc_html__( 'Drag item to change its order. Please select exact 4 categories.', 'bone' ),
                'required' => array( 'more-reading-switch', 'equals', '1' )
            ),
            array(         
                'id'       => 'more-reading-background',
                'type'     => 'background',
                'title'    => esc_html__('More Reading section background', 'bone'),
                'default'  => array(
                    'background-color' => '#f5f5f5',
                ),
                'output'   => array('.byCategoryListing'),
                'required' => array( 'more-reading-switch', 'equals', '1' )
            ),
            array(
                'id' => 'more-reading-section-end',
                'type' => 'section',
                'indent' => false 
            ),
            array(
                'id'       => 'no-duplicate-posts-switch',
                'type'     => 'switch', 
                'title'    => esc_html__('Avoid duplicate posts on homepage', 'bone'),
                'subtitle' => esc_html__('Only enable this when you have sufficient number of posts', 'bone'),
                'default'  => false,
            ),
        )
    ) );
    
    // Single Fields
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Single', 'bone' ),
        'id'               => 'single',
        'icon'             => 'el el-file',
        'fields'           => array(
            array(
                'id'       => 'single-layout',
                'type'     => 'image_select',
                'title'    => esc_html__( 'Single layout', 'bone' ),
                'options'  => array(
                    'standard' => array(
                        'alt' => 'Standard',
                        'img' => get_template_directory_uri() . '/img/single-1.png'
                    ),
                    'standard-top' => array(
                        'alt' => 'Standard Title Top',
                        'img' => get_template_directory_uri() . '/img/single-2.png'
                    ),
                    'standard-top-wide' => array(
                        'alt' => 'Standard Wide Title Top',
                        'img' => get_template_directory_uri() . '/img/single-3.png'
                    ),
                    'cover' => array(
                        'alt' => 'Cover',
                        'img' => get_template_directory_uri() . '/img/single-4.png'
                    ),
                    'billboard' => array(
                        'alt' => 'Billboard',
                        'img' => get_template_directory_uri() . '/img/single-5.png'
                    ),
                    'billboard-fw' => array(
                        'alt' => 'Billboard Fullwidth',
                        'img' => get_template_directory_uri() . '/img/single-6.png'
                    ),
                    'top-wide-fw' => array(
                        'alt' => 'Title Top Fullwidth',
                        'img' => get_template_directory_uri() . '/img/single-7.png'
                    ),
                ),
                'default'  => 'standard'
            ),
            array(
                'id'       => 'single-sidebar-position',
                'type'     => 'image_select',
                'title'    => esc_html__( 'Single sidebar position', 'bone' ),
                'options' => array(
                    'right' => array(
                        'alt' => 'Right Sidebar',
                        'img' => get_template_directory_uri() . '/img/sidebar-right.png'
                    ),
                    'left' => array(
                        'alt' => 'Left Sidebar',
                        'img' => get_template_directory_uri() . '/img/sidebar-left.png'
                    ),
                ),
                'required' => array( 'single-layout', '=', array('standard', 'standard-top', 'standard-top-wide', 'cover', 'billboard') ),
                'default'  => 'right',
            ),
            array(
                'id'       => 'postnav-switch',
                'type'     => 'switch', 
                'title'    => esc_html__('Post navigation', 'bone'),
                'default'  => true,
            ),
            array(
                'id'       => 'authorbox-switch',
                'type'     => 'switch', 
                'title'    => esc_html__('Author box', 'bone'),
                'default'  => true,
            ),
            array(
                'id'       => 'related-post-switch',
                'type'     => 'switch', 
                'title'    => esc_html__('Related articles', 'bone'),
                'default'  => true,
            ),
            array(
                'id'       => 'related-post-order',
                'type'     => 'button_set', 
                'title'    => esc_html__('Related articles order', 'bone'),
                'options' => array(
                    'rand'  => 'Random', 
                    'date' => 'Latest', 
                 ),
                'default'  => 'rand',
                'required' => array( 'related-post-switch', 'equals', '1' )
            ),
            array(
                'id'       => 'parallax-switch',
                'type'     => 'switch', 
                'title'    => esc_html__('Enable parallax on single billboard cover', 'bone'),
                'default'  => true,
            ),
            array(
                'id' => 'ribbon-section-start',
                'type' => 'section',
                'title' => esc_html__('Single featured block', 'bone'),
                'subtitle' => 'Row of posts display above single post',
                'indent' => true,
            ),
            array(
                'id'       => 'ribbon-switch',
                'type'     => 'switch', 
                'title'    => esc_html__('Enable single featured block', 'bone'),
                'default'  => true,
            ),
            array(
                'id'       => 'ribbon-get-post-method',
                'type'     => 'button_set',
                'title'    => 'Featured posts source',
                'subtitle' => 'Define how to get posts for single featured block',
                'options'  => array(
                    'by-manual'      => 'Select manually',
                    'by-marked'     => 'Marked as featured',
                    'by-tag' => 'By tags',
                    'by-category'   => 'By categories',
                ),
                'default'  => 'by-manual',
                'required' => array( 'ribbon-switch', 'equals', '1' )
            ),
            array(
                'id'       => 'ribbon-post-select',
                'type'     => 'select',
                'data'     => 'post',
                'args' => array(
                    'posts_per_page' => 100
                ),
                'multi'    => true,
                'sortable' => true,
                'title'    => esc_html__( 'Posts Select', 'bone' ),
                'desc'     => esc_html__( 'Drag post item to change its order. Maximum number of post is 4.', 'bone' ),
                'required' => array( 'ribbon-get-post-method', 'equals', 'by-manual' )
            ),
            array(
                'id'       => 'ribbon-tag-select',
                'type'     => 'select',
                'data'     => 'tag',
                'args' => array(
                    'posts_per_page' => 100
                ),
                'multi'    => true,
                'title'    => esc_html__( 'Tags Select', 'bone' ),
                'required' => array( 'ribbon-get-post-method', 'equals', 'by-tag' )
            ),
            array(
                'id'       => 'ribbon-cat-select',
                'type'     => 'select',
                'data'     => 'category',
                'args' => array(
                    'posts_per_page' => 100
                ),
                'multi'    => true,
                'title'    => esc_html__( 'Categories Select', 'bone' ),
                'required' => array( 'ribbon-get-post-method', 'equals', 'by-category' )
            ),
            array(
                'id'       => 'ribbon-order',
                'type'     => 'button_set',
                'title'    => 'Order by',
                'options'  => array(
                    'date'      => 'By date',
                    'rand' => 'Random',
                ),
                'default'  => 'date',
                'required' => array( 'ribbon-get-post-method', 'not', 'by-manual' )
            ),
            array(
                'id' => 'ribbon-section-end',
                'type' => 'section',
                'indent' => false 
            ),
        )
    ) );
    
    // Templates Fields
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Templates', 'bone' ),
        'id'               => 'templates',
        'icon'             => 'el el-folder',
        'fields'           => array(
            array(
                'id' => '404-section-start',
                'type' => 'section',
                'title' => esc_html__('404 page', 'bone'),
                'indent' => true 
            ),
            array(
                'id'       => '404-text',
                'type'     => 'text',
                'title'    => esc_html__( '404 text', 'bone' ),
                'default'  => 'Sorry, but nothing exists here.',
            ),
            array(
                'id' => '404-section-end',
                'type' => 'section',
                'indent' => false 
            ),

            array(
                'id' => 'archive-section-start',
                'type' => 'section',
                'title' => esc_html__('Archive', 'bone'),
                'indent' => true 
            ),
            array(
                'id'       => 'archive-sidebar-position',
                'type'     => 'image_select',
                'title'    => esc_html__( 'Sidebar position', 'bone' ),
                'options'  => array(
                    'right' => array(
                        'alt' => 'Right Sidebar',
                        'img' => get_template_directory_uri() . '/img/sidebar-right.png'
                    ),
                    'left' => array(
                        'alt' => 'Left Sidebar',
                        'img' => get_template_directory_uri() . '/img/sidebar-left.png'
                    ),
                    'none' => array(
                        'alt' => 'None',
                        'img' => get_template_directory_uri() . '/img/sidebar-none.png'
                    ),
                ),
                'default'  => 'right'
            ),
            array(
                'id'       => 'archive-content-layout',
                'type'     => 'image_select',
                'title'    => esc_html__( 'Archive Layout', 'bone' ),
                'title'    => esc_html__( 'Content layout for archive and tag page template', 'bone' ),
                'options'  => array(
                    'list' => array(
                        'alt' => 'List',
                        'img' => get_template_directory_uri() . '/img/content-1.png'
                    ),
                    'split' => array(
                        'alt' => 'Split',
                        'img' => get_template_directory_uri() . '/img/content-2.png'
                    ),
                    'masonry' => array(
                        'alt' => 'Masonry',
                        'img' => get_template_directory_uri() . '/img/content-3.png'
                    ),
                    'tiles' => array(
                        'alt' => 'Tiles',
                        'img' => get_template_directory_uri() . '/img/content-4.png'
                    ),
                    'classic' => array(
                        'alt' => 'Classic',
                        'img' => get_template_directory_uri() . '/img/content-5.png'
                    ),
                    'alt--1' => array(
                        'alt' => 'Altenative 1',
                        'img' => get_template_directory_uri() . '/img/content-6.png'
                    ),
                    'alt--2' => array(
                        'alt' => 'Altenative 2',
                        'img' => get_template_directory_uri() . '/img/content-7.png'
                    ),
                    'alt--3' => array(
                        'alt' => 'Altenative 3',
                        'img' => get_template_directory_uri() . '/img/content-8.png'
                    ),
                ),
                'default'  => 'list'
            ),
            array(
                'id'       => 'archive-mixed-cycle',
                'type'     => 'spinner', 
                'title'    => esc_html__('Display 1 big post for each selected number of posts', 'bone'),
                'default'  => '4',
                'min'      => '1',
                'step'     => '1',
                'max'      => '50',
                'required' => array( 'archive-content-layout', '=', array('alt--1','alt--2', 'alt--3') ),
            ),
            array(
                'id' => 'archive-section-end',
                'type' => 'section',
                'indent' => false 
            ),

            array(
                'id' => 'author-section-start',
                'type' => 'section',
                'title' => esc_html__('Author', 'bone'),
                'indent' => true 
            ),
            array(
                'id'       => 'author-sidebar-position',
                'type'     => 'image_select',
                'title'    => esc_html__( 'Sidebar position', 'bone' ),
                'options'  => array(
                    'right' => array(
                        'alt' => 'Right Sidebar',
                        'img' => get_template_directory_uri() . '/img/sidebar-right.png'
                    ),
                    'left' => array(
                        'alt' => 'Left Sidebar',
                        'img' => get_template_directory_uri() . '/img/sidebar-left.png'
                    ),
                    'none' => array(
                        'alt' => 'None',
                        'img' => get_template_directory_uri() . '/img/sidebar-none.png'
                    ),
                ),
                'default'  => 'right'
            ),
            array(
                'id'       => 'author-content-layout',
                'type'     => 'image_select',
                'title'    => esc_html__( 'Author Layout', 'bone' ),
                'title'    => esc_html__( 'Content layout author page template', 'bone' ),
                'options'  => array(
                    'list' => array(
                        'alt' => 'List',
                        'img' => get_template_directory_uri() . '/img/content-1.png'
                    ),
                    'split' => array(
                        'alt' => 'Split',
                        'img' => get_template_directory_uri() . '/img/content-2.png'
                    ),
                    'masonry' => array(
                        'alt' => 'Masonry',
                        'img' => get_template_directory_uri() . '/img/content-3.png'
                    ),
                    'tiles' => array(
                        'alt' => 'Tiles',
                        'img' => get_template_directory_uri() . '/img/content-4.png'
                    ),
                    'classic' => array(
                        'alt' => 'Classic',
                        'img' => get_template_directory_uri() . '/img/content-5.png'
                    ),
                ),
                'default'  => 'list'
            ),
            array(
                'id' => 'author-section-end',
                'type' => 'section',
                'indent' => false 
            ),

            array(
                'id' => 'category-section-start',
                'type' => 'section',
                'title' => esc_html__('Category', 'bone'),
                'indent' => true 
            ),
            array(
                'id'       => 'category-sidebar-position',
                'type'     => 'image_select',
                'title'    => esc_html__( 'Sidebar position', 'bone' ),
                'options'  => array(
                    'right' => array(
                        'alt' => 'Right Sidebar',
                        'img' => get_template_directory_uri() . '/img/sidebar-right.png'
                    ),
                    'left' => array(
                        'alt' => 'Left Sidebar',
                        'img' => get_template_directory_uri() . '/img/sidebar-left.png'
                    ),
                    'none' => array(
                        'alt' => 'None',
                        'img' => get_template_directory_uri() . '/img/sidebar-none.png'
                    ),
                ),
                'default'  => 'right'
            ),
            array(
                'id'       => 'category-content-layout',
                'type'     => 'image_select',
                'title'    => esc_html__( 'Category content layout', 'bone' ),
                'options'  => array(
                    'list' => array(
                        'alt' => 'List',
                        'img' => get_template_directory_uri() . '/img/content-1.png'
                    ),
                    'split' => array(
                        'alt' => 'Split',
                        'img' => get_template_directory_uri() . '/img/content-2.png'
                    ),
                    'masonry' => array(
                        'alt' => 'Masonry',
                        'img' => get_template_directory_uri() . '/img/content-3.png'
                    ),
                    'tiles' => array(
                        'alt' => 'Tiles',
                        'img' => get_template_directory_uri() . '/img/content-4.png'
                    ),
                    'classic' => array(
                        'alt' => 'Classic',
                        'img' => get_template_directory_uri() . '/img/content-5.png'
                    ),
                    'alt--1' => array(
                        'alt' => 'Altenative 1',
                        'img' => get_template_directory_uri() . '/img/content-6.png'
                    ),
                    'alt--2' => array(
                        'alt' => 'Altenative 2',
                        'img' => get_template_directory_uri() . '/img/content-7.png'
                    ),
                    'alt--3' => array(
                        'alt' => 'Altenative 3',
                        'img' => get_template_directory_uri() . '/img/content-8.png'
                    ),
                ),
                'default'  => 'list'
            ),
            array(
                'id'       => 'category-mixed-cycle',
                'type'     => 'spinner', 
                'title'    => esc_html__('Display 1 big post for each selected number of posts', 'bone'),
                'default'  => '4',
                'min'      => '1',
                'step'     => '1',
                'max'      => '50',
                'required' => array( 'category-content-layout', '=', array('alt--1','alt--2', 'alt--3') ),
            ),
            array(
                'id' => 'category-section-end',
                'type' => 'section',
                'indent' => false 
            ),

            array(
                'id' => 'search-section-start',
                'type' => 'section',
                'title' => esc_html__('Search', 'bone'),
                'indent' => true 
            ),
            array(
                'id'       => 'search-sidebar-position',
                'type'     => 'image_select',
                'title'    => esc_html__( 'Sidebar position', 'bone' ),
                'options'  => array(
                    'right' => array(
                        'alt' => 'Right Sidebar',
                        'img' => get_template_directory_uri() . '/img/sidebar-right.png'
                    ),
                    'left' => array(
                        'alt' => 'Left Sidebar',
                        'img' => get_template_directory_uri() . '/img/sidebar-left.png'
                    ),
                    'none' => array(
                        'alt' => 'None',
                        'img' => get_template_directory_uri() . '/img/sidebar-none.png'
                    ),
                ),
                'default'  => 'right'
            ),
            array(
                'id'       => 'search-content-layout',
                'type'     => 'image_select',
                'title'    => esc_html__( 'Search content layout', 'bone' ),
                'options'  => array(
                    'list' => array(
                        'alt' => 'List',
                        'img' => get_template_directory_uri() . '/img/content-1.png'
                    ),
                    'split' => array(
                        'alt' => 'Split',
                        'img' => get_template_directory_uri() . '/img/content-2.png'
                    ),
                    'masonry' => array(
                        'alt' => 'Masonry',
                        'img' => get_template_directory_uri() . '/img/content-3.png'
                    ),
                    'tiles' => array(
                        'alt' => 'Tiles',
                        'img' => get_template_directory_uri() . '/img/content-4.png'
                    ),
                    'classic' => array(
                        'alt' => 'Classic',
                        'img' => get_template_directory_uri() . '/img/content-5.png'
                    ),
                    'alt--1' => array(
                        'alt' => 'Altenative 1',
                        'img' => get_template_directory_uri() . '/img/content-6.png'
                    ),
                    'alt--2' => array(
                        'alt' => 'Altenative 2',
                        'img' => get_template_directory_uri() . '/img/content-7.png'
                    ),
                    'alt--3' => array(
                        'alt' => 'Altenative 3',
                        'img' => get_template_directory_uri() . '/img/content-8.png'
                    ),
                ),
                'default'  => 'list'
            ),
            array(
                'id'       => 'search-mixed-cycle',
                'type'     => 'spinner', 
                'title'    => esc_html__('Display 1 big post for each selected number of posts', 'bone'),
                'default'  => '4',
                'min'      => '1',
                'step'     => '1',
                'max'      => '50',
                'required' => array( 'search-content-layout', '=', array('alt--1','alt--2','alt--3') ),
            ),
            array(
                'id' => 'search-section-end',
                'type' => 'section',
                'indent' => false
            ),
        )
    ) );

    if ( class_exists( 'WooCommerce' ) ) {
        Redux::setSection( $opt_name, array(
            'title'            => esc_html__( 'WooCommerce', 'bone' ),
            'id'               => 'woocommerce',
            'icon'             => 'el el-shopping-cart',
            'fields'           => array(
                array(
                    'id'       => 'woocommerce-frontpage-layout',
                    'type'     => 'sortable',
                    'mode'     => 'checkbox', // checkbox or text
                    'title'    => esc_html__( 'Shop frontpage layout', 'bone' ),
                    'subtitle' => esc_html__( 'Reorder and enable/disable page sections.', 'bone' ),
                    'options'  => array(
                        'categories' => esc_html__( 'Product categories', 'bone' ),
                        'recent' => esc_html__( 'Recent products', 'bone' ),
                        'featured' => esc_html__( 'Featured products', 'bone' ),
                        'popular' => esc_html__( 'Top rated products', 'bone' ),
                        'sale' => esc_html__( 'On sale products', 'bone' ),
                    ),
                    'default'  => array(
                        'categories' => true,
                        'recent' => true,
                        'featured' => false,
                        'popular' => true,
                        'sale' => true,
                    ),
                ),
                array(
                    'id'       => 'woocommerce-shop-front-sidebar-position',
                    'type'     => 'image_select',
                    'title'    => esc_html__( 'Shop frontpage sidebar position', 'bone' ),
                    'options'  => array(
                        'right' => array(
                            'alt' => 'Right Sidebar',
                            'img' => get_template_directory_uri() . '/img/sidebar-right.png'
                        ),
                        'left' => array(
                            'alt' => 'Left Sidebar',
                            'img' => get_template_directory_uri() . '/img/sidebar-left.png'
                        ),
                        'none' => array(
                            'alt' => 'None',
                            'img' => get_template_directory_uri() . '/img/sidebar-none.png'
                        ),
                    ),
                    'default'  => 'right'
                ),
                array(
                    'id'       => 'woocommerce-archive-title-style',
                    'type'     => 'select',
                    'title'    => esc_html__( 'Shop archive page title style', 'bone' ),
                    'options'  => array(
                        'default' => 'Default',
                        'cover' => 'With background',
                    ),
                    'default'  => 'default'
                ),
                array(
                    'id'       => 'woocommerce-archive-title-background',
                    'type'     => 'media', 
                    'url'      => true,
                    'title'    => esc_html__('Shop archive page title background', 'bone'),
                    'default'  => array(),
                    'required' => array( 'woocommerce-archive-title-style', 'equals', 'cover' )
                ),
                array(
                    'id'       => 'woocommerce-shop-sidebar-position',
                    'type'     => 'image_select',
                    'title'    => esc_html__( 'Shop archive page sidebar position', 'bone' ),
                    'options'  => array(
                        'right' => array(
                            'alt' => 'Right Sidebar',
                            'img' => get_template_directory_uri() . '/img/sidebar-right.png'
                        ),
                        'left' => array(
                            'alt' => 'Left Sidebar',
                            'img' => get_template_directory_uri() . '/img/sidebar-left.png'
                        ),
                        'none' => array(
                            'alt' => 'None',
                            'img' => get_template_directory_uri() . '/img/sidebar-none.png'
                        ),
                    ),
                    'default'  => 'right'
                ),
                array(
                    'id'       => 'woocommerce-cat-sidebar-position',
                    'type'     => 'image_select',
                    'title'    => esc_html__( 'Product category and tag page sidebar position', 'bone' ),
                    'options'  => array(
                        'right' => array(
                            'alt' => 'Right Sidebar',
                            'img' => get_template_directory_uri() . '/img/sidebar-right.png'
                        ),
                        'left' => array(
                            'alt' => 'Left Sidebar',
                            'img' => get_template_directory_uri() . '/img/sidebar-left.png'
                        ),
                        'none' => array(
                            'alt' => 'None',
                            'img' => get_template_directory_uri() . '/img/sidebar-none.png'
                        ),
                    ),
                    'default'  => 'right'
                ),
                array(
                    'id'       => 'woocommerce-product-sidebar-position',
                    'type'     => 'image_select',
                    'title'    => esc_html__( 'Product page sidebar position', 'bone' ),
                    'options'  => array(
                        'right' => array(
                            'alt' => 'Right Sidebar',
                            'img' => get_template_directory_uri() . '/img/sidebar-right.png'
                        ),
                        'left' => array(
                            'alt' => 'Left Sidebar',
                            'img' => get_template_directory_uri() . '/img/sidebar-left.png'
                        ),
                        'none' => array(
                            'alt' => 'None',
                            'img' => get_template_directory_uri() . '/img/sidebar-none.png'
                        ),
                    ),
                    'default'  => 'right'
                ),
                array(
                    'id'       => 'woocommerce-homepage-section-switch',
                    'type'     => 'switch', 
                    'title'    => esc_html__('Display shop section on homepage', 'bone'),
                    'default'  => true,
                ),
                array(
                    'id'       => 'woocommerce-homepage-section',
                    'type'     => 'select',
                    'title'    => 'Products to display on homepage section',
                    'options'  => array(
                        'recent'      => 'Recent',
                        'featured' => 'Featured',
                        'popular' => 'Top rated',
                        'sale' => 'On sale',
                    ),
                    'default'  => 'recent',
                    'required' => array( 'woocommerce-homepage-section-switch', 'equals', '1' ),
                ),
            )
        ) );
    };

    // Miscellaneous Fields
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Miscellaneous', 'bone' ),
        'id'               => 'miscellaneous',
        'icon'             => 'el el-adjust-alt',
        'fields'           => array(
            array(
                'id'       => 'high-resolution-switch',
                'type'     => 'switch', 
                'title'    => esc_html__('High resolution', 'bone'),
                'subtitle' => esc_html__('Enable compatibility with HiDPI devices like a laptops with Retina display. Requires WP Retina 2x plugin.', 'bone'),
                'default'  => true,
            ),
            array(
                'id'       => 'smooth-scroll-switch',
                'type'     => 'switch', 
                'title'    => esc_html__('Smoothscroll', 'bone'),
                'default'  => true,
            ),
            array(
                'id'       => 'facdn-switch',
                'type'     => 'switch', 
                'title'    => esc_html__('Use Font Awesome CDN', 'bone'),
                'subtitle' => esc_html__('If disabled, local Font Awesome files will be loaded instead', 'bone'),
                'default'  => true,
            ),
            array(
                'id'       => 'addthis-id',
                'type'     => 'text', 
                'title'    => esc_html__('AddThis ID', 'bone'),
                'subtitle' => esc_html__('Your AddThis Profile ID for this site. To get your AddThis Profile ID, go to', 'bone').' <a href="https://www.addthis.com/settings/publisher">https://www.addthis.com/settings/publisher</a>',
                'default'  => '',
            ),
        )
    ) );

    // Social Fields
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Social', 'bone' ),
        'desc'         => esc_html__( 'Enter full URLs to your social networks', 'bone' ),
        'id'               => 'social',
        'icon'             => 'el el-globe',
        'fields'           => array(
            array(
                'id'       => 'facebook-url',
                'type'     => 'text',
                'title'    => esc_html__( 'Facebook', 'bone' ),
                'validate' => 'url',
                'default'  => '',
            ),
            array(
                'id'       => 'twitter-url',
                'type'     => 'text',
                'title'    => esc_html__( 'Twitter', 'bone' ),
                'validate' => 'url',
                'default'  => '',
            ),
            array(
                'id'       => 'google-url',
                'type'     => 'text',
                'title'    => esc_html__( 'Google+', 'bone' ),
                'validate' => 'url',
                'default'  => '',
            ),
            array(
                'id'       => 'instagram-url',
                'type'     => 'text',
                'title'    => esc_html__( 'Instagram', 'bone' ),
                'validate' => 'url',
                'default'  => '',
            ),
            array(
                'id'       => 'pinterest-url',
                'type'     => 'text',
                'title'    => esc_html__( 'Pinterest', 'bone' ),
                'validate' => 'url',
                'default'  => '',
            ),
            array(
                'id'       => 'tumblr-url',
                'type'     => 'text',
                'title'    => esc_html__( 'Tumblr', 'bone' ),
                'validate' => 'url',
                'default'  => '',
            ),
            array(
                'id'       => 'linkedin-url',
                'type'     => 'text',
                'title'    => esc_html__( 'Linkedin', 'bone' ),
                'validate' => 'url',
                'default'  => '',
            ),
            array(
                'id'       => 'youtube-url',
                'type'     => 'text',
                'title'    => esc_html__( 'Youtube', 'bone' ),
                'validate' => 'url',
                'default'  => '',
            ),
            array(
                'id'       => 'vk-url',
                'type'     => 'text',
                'title'    => esc_html__( 'VK', 'bone' ),
                'validate' => 'url',
                'default'  => '',
            ),
            array(
                'id'       => 'social-sortable',
                'type'     => 'sortable',
                'mode'     => 'checkbox', // checkbox or text
                'title'    => esc_html__( 'Order of your social networks', 'bone' ),
                'subtitle' => esc_html__( 'Reorder and enable/disable your social networks.', 'bone' ),
                'options'  => array(
                    'fb' => 'Facebook',
                    'tw' => 'Twitter',
                    'gp' => 'Google+',
                    'in' => 'Instagram',
                    'pi' => 'Pinterest',
                    'tu' => 'Tumblr',
                    'li' => 'Linkedin',
                    'yt' => 'Youtube',
                    'vk' => 'VK',
                ),
                'default'  => array(
                    'fb' => true,
                    'tw' => true,
                    'gp' => true,
                    'in' => true,
                    'pi' => true,
                    'tu' => true,
                    'li' => true,
                    'yt' => true,
                    'vk' => true,
                )
            ),
        )
    ) );
    
    // Custom Code Fields
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Custom code', 'bone' ),
        'id'               => 'custom-code',
        'icon'             => 'el el-glasses',
        'fields'           => array(
            array(
                'id'       => 'custom-css',
                'type'     => 'ace_editor',
                'title'    => esc_html__( 'CSS Code', 'bone' ),
                'subtitle' => esc_html__( 'Paste your CSS code here.', 'bone' ),
                'mode'     => 'css',
                'theme'    => 'chrome',
                'default'  => ""
            ),
            array(
                'id'       => 'custom-js-header',
                'type'     => 'ace_editor',
                'title'    => esc_html__( 'Custom JS/Analytics Code in header', 'bone' ),
                'subtitle' => esc_html__( 'Paste here your JS/Analytics code which will appear in the header of your site.', 'bone' ),
                'desc' => esc_html__( 'DO NOT include opening and closing script tags.', 'bone' ),
                'mode'     => 'javascript',
                'theme'    => 'chrome',
                'default'  => ""
            ),
            array(
                'id'       => 'custom-js-footer',
                'type'     => 'ace_editor',
                'title'    => esc_html__( 'Custom JS/Analytics Code in footer', 'bone' ),
                'subtitle' => esc_html__( 'Paste here your JS/Analytics code which will appear in the footer of your site.', 'bone' ),
                'desc' => esc_html__( 'DO NOT include opening and closing script tags.', 'bone' ),
                'mode'     => 'javascript',
                'theme'    => 'chrome',
                'default'  => ""
            ),
        )
    ) );


    /*
     * <--- END SECTIONS
     */


    /*
     *
     * YOU MUST PREFIX THE FUNCTIONS BELOW AND ACTION FUNCTION CALLS OR ANY OTHER CONFIG MAY OVERRIDE YOUR CODE.
     *
     */

    /*
    *
    * --> Action hook examples
    *
    */

    // If Redux is running as a plugin, this will remove the demo notice and links
    add_action( 'redux/loaded', 'remove_demo' );


    /**
     * Removes the demo link and the notice of integrated demo from the redux-framework plugin
     */
    if ( ! function_exists( 'remove_demo' ) ) {
        function remove_demo() {
            // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
            if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
                remove_filter( 'plugin_row_meta', array(
                    ReduxFrameworkPlugin::instance(),
                    'plugin_metalinks'
                ), null, 2 );

                // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
                remove_action( 'admin_notices', array( ReduxFrameworkPlugin::instance(), 'admin_notices' ) );
            }
        }
    }

