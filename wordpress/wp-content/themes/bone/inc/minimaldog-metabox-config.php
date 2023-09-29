<?php
/**
 * Register Meta Box fields
 */
if ( class_exists('RW_Meta_Box') ) {
	add_filter( 'rwmb_meta_boxes', 'md_register_meta_boxes' );
}

function md_register_meta_boxes( $meta_boxes ){
    $prefix = 'md_bone_';

    // Format image meta box
    $meta_boxes[] = array(
        'id'       => $prefix . 'format_image',
        'title'    => esc_html__('Post format: Image', 'bone'),
        'pages'    => array( 'post' ),
        'context'  => 'normal',
        'priority' => 'high',

        'fields' => array(
            array(
                'name'  => esc_html__('Choose image', 'bone'),
                'desc'  => esc_html__('Choose an image to be assigned to this post', 'bone'),
                'id'    => $prefix . 'format_image_file',
                'type'  => 'image_advanced',
                'max_file_uploads' => 1,
            ),
        )
    );

    // Format gallery meta box
    $meta_boxes[] = array(
        'id'       => $prefix . 'format_gallery',
        'title'    => esc_html__('Post format: Gallery', 'bone'),
        'pages'    => array( 'post' ),
        'context'  => 'normal',
        'priority' => 'high',

        'fields' => array(
            array(
                'name'  => esc_html__('Choose gallery images', 'bone'),
                'desc'  => esc_html__('Choose images to be added to the gallery', 'bone'),
                'id'    => $prefix . 'format_gallery_files',
                'type'  => 'image_advanced',
            ),
            // Slider gallery options
            array(
                'id' => $prefix.'gallery_slider_opts',
                'name'    => esc_html__('Slider gallery options', 'bone'),
                'type'   => 'group', // Group type
                // List of sub-fields
                'fields' => array(
                    array(
                        'name' => esc_html__('Display thumbnails', 'bone'),
                        'id'   => 'gallery_navthumb',
                        'type' => 'checkbox',
                    ),
                    array(
                        'name' => esc_html__('Slider transition', 'bone'),
                        'id'   => 'gallery_transition',
                        'type' => 'select',
                        'options' => array(
                            'slide' => esc_html__('Slide', 'bone') ,
                            'fade' => esc_html__('Fade', 'bone') ,
                        )
                    ),
                ),
            ),
        )
    );

    // Format audio meta box
    $meta_boxes[] = array(
        'id'       => $prefix . 'format_audio',
        'title'    => esc_html__('Post format: Audio', 'bone'),
        'pages'    => array( 'post' ),
        'context'  => 'normal',
        'priority' => 'high',

        'fields' => array(
            array(
                'name' => esc_html__('Audio full URL: Soundcloud, Mixcloud, Spotify, ... See all supported site ', 'bone').'<a href="https://codex.wordpress.org/Embeds" target="_blank">'.esc_html__('here', 'bone').'</a>',
                'id'   => $prefix . 'format_audio_url',
                'type' => 'url',
            ),
            array(
                'name' => esc_html__('Or upload your own audio', 'bone'),
                'id'   => $prefix . 'format_audio_file',
                'type' => 'file_advanced',
                'max_file_uploads' => 1,
            ),
            array(
                'name' => esc_html__('Audio title:', 'bone'),
                'desc' => esc_html__('Use for self-hosted audio', 'bone'),
                'id'   => $prefix . 'format_audio_title',
                'type' => 'text',
            ),
            array(
                'name' => esc_html__('Audio artist:', 'bone'),
                'desc' => esc_html__('Use for self-hosted audio', 'bone'),
                'id'   => $prefix . 'format_audio_artist',
                'type' => 'text',
            ),
        )
    );

    // Format video meta box
    $meta_boxes[] = array(
        'id'       => $prefix . 'format_video',
        'title'    => esc_html__('Post format: Video', 'bone'),
        'pages'    => array( 'post' ),
        'context'  => 'normal',
        'priority' => 'high',

        'fields' => array(
            array(
                'name' => esc_html__('Video full URL: Youtube, Vimeo, Dailymotion, TED, ... See all supported site ', 'bone').'<a href="https://codex.wordpress.org/Embeds" target="_blank">'.esc_html__('here', 'bone').'</a>',
                'id'   => $prefix . 'format_video_url',
                'type' => 'url',
            ),
        )
    );

    // Format quote meta box
    $meta_boxes[] = array(
        'id'       => $prefix . 'format_quote',
        'title'    => esc_html__('Post format: Quote', 'bone'),
        'pages'    => array( 'post' ),
        'context'  => 'normal',
        'priority' => 'high',

        'fields' => array(
            array(
                'name' => esc_html__('Quote content:', 'bone'),
                'id'   => $prefix . 'format_quote_content',
                'type' => 'textarea',
            ),
            array(
                'name' => esc_html__('Quote author:', 'bone'),
                'id'   => $prefix . 'format_quote_author',
                'type' => 'text',
            ),
        )
    );

    // Format link meta box
    $meta_boxes[] = array(
        'id'       => $prefix . 'format_link',
        'title'    => esc_html__('Post format: Link', 'bone'),
        'pages'    => array( 'post' ),
        'context'  => 'normal',
        'priority' => 'high',

        'fields' => array(
            array(
                'name' => esc_html__('Link URL:', 'bone'),
                'id'   => $prefix . 'format_link_url',
                'type' => 'url',
            ),
            array(
                'name' => esc_html__('Link title:', 'bone'),
                'id'   => $prefix . 'format_link_title',
                'type' => 'text',
            ),
            array(
                'name' => esc_html__('Link description:', 'bone'),
                'id'   => $prefix . 'format_link_desc',
                'type' => 'text',
            ),
        )
    );

    // Post options
    $meta_boxes[] = array(
        'id'       => $prefix . 'post_options',
        'title'    => esc_html__('Post options', 'bone'),
        'pages'    => array( 'post' ),
        'context'  => 'normal',
        'priority' => 'high',

        'fields' => array(
            array(
                'name'  => esc_html__('Post layout', 'bone'),
                'id'    => $prefix . 'post-layout',
                'type'  => 'image_select',
                'options' => array(
                	'default' => get_template_directory_uri() . '/img/default.png',
                    'standard' => get_template_directory_uri() . '/img/single-1.png',
                	'standard-top' => get_template_directory_uri() . '/img/single-2.png',
                	'standard-top-wide' => get_template_directory_uri() . '/img/single-3.png',
                    'cover' => get_template_directory_uri() . '/img/single-4.png',
                	'billboard' => get_template_directory_uri() . '/img/single-5.png',
                    'billboard-fw' => get_template_directory_uri() . '/img/single-6.png',
                    'top-wide-fw' => get_template_directory_uri() . '/img/single-7.png',
                	),
            ),
            array(
                'name'  => esc_html__('Sidebar position', 'bone'),
                'id'    => $prefix . 'post-sidebar-position',
                'type'  => 'image_select',
                'options' => array(
                    'default' => get_template_directory_uri() . '/img/default.png',
                    'right' => get_template_directory_uri() . '/img/sidebar-right.png',
                    'left' => get_template_directory_uri() . '/img/sidebar-left.png',
                    ),
            ),
            array(
                'name'  => esc_html__('Make this post featured', 'bone'),
                'id'    => $prefix . 'post_featured',
                'desc'  => esc_html__('Check to make this post display in featured block (if Featured Post Source is set to Marked as Featured)', 'bone'),
                'type'  => 'checkbox',
            ),
            array(
                'name'  => esc_html__('Featured image caption', 'bone'),
                'id'    => $prefix . 'featured_img_caption',
                'type'  => 'text',
            ),
            array(
                'name'  => esc_html__('Hide featured image', 'bone'),
                'id'    => $prefix . 'hide_featured_img',
                'desc'  => esc_html__('Hide featured image on single page (only on certain layout)', 'bone'),
                'type'  => 'checkbox',
            ),
            // Post source
            array(
                'name'  => esc_html__('Post source', 'bone'),
                'type'  => 'heading',
            ),
            array(
                'name'  => esc_html__('Via URL', 'bone'),
                'id'    => $prefix . 'post_via_url',
                'type'  => 'url',
            ),
            array(
                'name'  => esc_html__('Via Title', 'bone'),
                'id'    => $prefix . 'post_via_title',
                'type'  => 'text',
            ),
            array(
                'name'  => esc_html__('Source URL', 'bone'),
                'id'    => $prefix . 'post_source_url',
                'type'  => 'url',
            ),
            array(
                'name'  => esc_html__('Source Title', 'bone'),
                'id'    => $prefix . 'post_source_title',
                'type'  => 'text',
            ),
            // Post review
            array(
                'name'  => esc_html__('Post review', 'bone'),
                'type'  => 'heading',
            ),
            array(
                'name' => esc_html__('Show review score', 'bone'),
                'id'   => $prefix . 'review_switch',
                'type' => 'checkbox',
            ),
            // Group
            array(
                'id' => $prefix.'review_score',
                'type'   => 'group', // Group type
                'clone'  => true,    // Can be cloned?
                // List of sub-fields
                'fields' => array(
                    array(
                        'name' => esc_html__('Criteria name', 'bone'),
                        'id'   => 'criteria_name',
                        'type' => 'text',
                    ),
                    array(
                        'name' => esc_html__( 'Criteria score', 'bone' ),
                        'id'   => 'criteria_score',
                        'type' => 'slider',
                        // Text labels displayed before and after value
                        'suffix' => '/10',
                        // jQuery UI slider options. See here http://api.jqueryui.com/slider/
                        'js_options' => array(
                            'min'   => 0,
                            'max'   => 10,
                            'step'  => 1,
                        ),
                    ),
                    // Other sub-fields here
                ),
            ),
            array(
                'name' => esc_html__('Review total score', 'bone'),
                'id'   => $prefix . 'review_totalscore',
                'desc' => esc_html__('Type in total score to overwrite computed total score', 'bone'),
                'type' => 'text',
            ),
            array(
                'name' => esc_html__('Review summary (optional)', 'bone'),
                'id'   => $prefix . 'review_summary',
                'type' => 'textarea',
            ),
            array(
                'name' => esc_html__('Review pros (optional)', 'bone'),
                'id'   => $prefix . 'review_pros',
                'type' => 'text',
                'clone'  => true,
            ),
            array(
                'name' => esc_html__('Review cons (optional)', 'bone'),
                'id'   => $prefix . 'review_cons',
                'type' => 'text',
                'clone'  => true,
            ),
        )
    );

    // Page options
    $meta_boxes[] = array(
        'id'       => $prefix . 'page_options',
        'title'    => esc_html__('Page options', 'bone'),
        'pages'    => array( 'page' ),
        'context'  => 'normal',
        'priority' => 'high',

        'fields' => array(
            array(
                'name'  => esc_html__('Sidebar position', 'bone'),
                'id'    => $prefix . 'page-sidebar-position',
                'type'  => 'image_select',
                'options' => array(
                    'default' => get_template_directory_uri() . '/img/default.png',
                    'right' => get_template_directory_uri() . '/img/sidebar-right.png',
                    'left' => get_template_directory_uri() . '/img/sidebar-left.png',
                    'none' => get_template_directory_uri() . '/img/sidebar-none.png',
                    ),
            ),
            array(
                'name' => esc_html__('Page title style', 'bone'),
                'id'   => $prefix . 'page-title-style',
                'type' => 'select',
                'options' => array(
                    'default' => esc_html__('Default', 'bone') ,
                    'fullwidth' => esc_html__('Fullwidth', 'bone') ,
                ),
            ),
        )
    );

    return $meta_boxes;
}