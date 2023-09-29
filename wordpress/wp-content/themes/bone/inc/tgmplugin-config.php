<?php
/**
 * TGM PLUGIN ACTIVATION
 */
require_once get_template_directory() . '/lib/vendor/tgm-plugin-activation/class-tgm-plugin-activation.php';
add_action( 'tgmpa_register', 'md_register_required_plugins' );

/**
 * Register required plugins
 * @return void
 */
function md_register_required_plugins(){
    $plugins = array(
        array(
            'name'               => 'Redux Framework',
            'slug'               => 'redux-framework',
            'required'           => true,
            'force_activation'   => false,
            'force_deactivation' => false,
        ),
        array(
            'name'               => 'Meta Box',
            'slug'               => 'meta-box',
            'required'           => true,
            'force_activation'   => false,
            'force_deactivation' => false,
        ),
        array(
            'name'               => 'Meta Box Group',
            'slug'               => 'meta-box-group',
            'source'             => get_template_directory_uri() . '/lib/vendor/tgm-plugin-activation/plugins/meta-box-group.zip',
            'required'           => true,
            'force_activation'   => false,
            'force_deactivation' => false,
        ),
        array(
            'name'               => 'WP Retina 2x',
            'slug'               => 'wp-retina-2x',
            'required'           => false,
            'force_activation'   => false,
            'force_deactivation' => false,
        ),
        // You can add more plugins here if you want
    );
    $config  = array(
        'id'           => 'tgmpa-minimaldog',      // Unique ID for hashing notices for multiple instances of TGMPA.
        'default_path' => '',                      // Default absolute path to bundled plugins.
        'menu'         => 'tgmpa-install-plugins', // Menu slug.
        'parent_slug'  => 'themes.php',            // Parent menu slug.
        'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
        'has_notices'      => true,
        'is_automatic'     => true,
        'message'          => '',
        'strings'          => array(
            'page_title'                      => esc_html__( 'Install Required Plugins', 'bone' ),
            'menu_title'                      => esc_html__( 'Install Plugins', 'bone' ),
            'installing'                      => esc_html__( 'Installing Plugin: %s', 'bone' ),
            'oops'                            => esc_html__( 'Something went wrong with the plugin API.', 'bone' ),
            'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'bone' ),
            'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'bone' ),
            'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'bone' ),
            'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'bone' ),
            'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'bone' ),
            'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'bone' ),
            'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'bone' ),
            'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'bone' ),
            'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'bone' ),
            'activate_link'                   => _n_noop( 'Activate installed plugin', 'Activate installed plugins', 'bone' ),
            'return'                          => esc_html__( 'Return to Required Plugins Installer', 'bone' ),
            'plugin_activated'                => esc_html__( 'Plugin activated successfully.', 'bone' ),
            'complete'                        => esc_html__( 'All plugins installed and activated successfully. %s', 'bone' ),
            'nag_type'                        => 'updated',
        )
    );

    tgmpa( $plugins, $config );
}