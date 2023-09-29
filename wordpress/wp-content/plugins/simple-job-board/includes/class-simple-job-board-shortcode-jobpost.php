<?php

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly
/**
 * Simple_Job_Board_Shortcode_Jobpost Class
 * 
 * This class lists the jobs on frontend for [jobpost] shortcode.
 * 
 * @link        https://wordpress.org/plugins/simple-job-board
 * @since       2.2.3
 * @since       2.4.0   Revised Inputs & Outputs Sanitization & Escaping
 *
 * @package     Simple_Job_Board
 * @subpackage  Simple_Job_Board/includes/shortcodes
 * @author      PressTigers <support@presstigers.com>
 */

class Simple_Job_Board_Shortcode_Jobpost {

    /**
     * Constructor
     */
    public function __construct() {
        
        // Hook -> Add Job Listing ShortCode
        add_shortcode('jobpost', array($this, 'jobpost_shortcode'));

//        add_action('init', array($this, 'gggb_init'));
    }

    public function gggb_init() {
        
        // Hook -> Add Job Listing ShortCode
//        add_shortcode('jobpost', array($this, 'jobpost_shortcode'));
        
//        register_block_type( 'simple-job-board/gutenberg-blocks', array(
//                'render_callback' => 'jobpost_shortcode',
//        ) );
    }

    /**
     * List all Jobs.
     *
     * @since   1.0.0
     * 
     * @param   array   $atts    Shortcode attribute
     * @return  HTML    $html    Job Listing HTML Structure.
     */
    public function jobpost_shortcode( $atts, $content ) {

        /**
         * Enqueue Frontend Scripts.
         * 
         * @since   2.2.4
         */
        do_action('sjb_enqueue_scripts');

        ob_start();

        global $job_query;

        // Shortcode Default Array
        $shortcode_args = array(
            'posts' => '15',
            'category' => '',
            'type' => '',
            'location' => '',
            'keywords' => '',
            'order' => 'DESC',
            'search' => 'true',
        );

        $atts = is_array($atts) ? apply_filters('sjb_shortcode_atts', array_map('sanitize_text_field', $atts)) : '';

        // Combine User Defined Shortcode Attributes with Known Attributes
        $shortcode_args = shortcode_atts(apply_filters('sjb_output_jobs_defaults', $shortcode_args, $atts), $atts);

        // Get paged variable.
        if (get_query_var('paged')) {
            $paged = (int) get_query_var('paged');
        } elseif (get_query_var('page')) {
            $paged = (int) get_query_var('page');
        } else {
            $paged = 1;
        }

        // WP Query Default Arguments
        $args = apply_filters(
                'sjb_output_jobs_args', array(
            'post_status' => 'publish',
            'posts_per_page' => esc_attr($shortcode_args['posts']),
            'post_type' => 'jobpost',
            'paged' => $paged,
            'order' => esc_attr($shortcode_args['order']),
                ), $atts
        );

        // Merge $arg array on each $_GET element
        $args['jobpost_category'] = (!empty($_GET['selected_category']) && -1 != $_GET['selected_category'] ) ? esc_attr($_GET['selected_category']) : esc_attr($shortcode_args['category']);
        $args['jobpost_job_type'] = (!empty($_GET['selected_jobtype']) && -1 != $_GET['selected_jobtype'] ) ? esc_attr($_GET['selected_jobtype']) : esc_attr($shortcode_args['type']);
        $args['jobpost_location'] = (!empty($_GET['selected_location']) && -1 != $_GET['selected_location'] ) ? esc_attr($_GET['selected_location']) : esc_attr($shortcode_args['location']);

        $args['s'] = ( NULL != filter_input(INPUT_GET, 'search_keywords') ) ? sanitize_text_field($_GET['search_keywords']) : '';

        // Job Query
        $job_query = new WP_Query($args);

        /**
         * Fires before listing jobs on job listing page.
         * 
         * @since   2.2.0
         */
        do_action('sjb_job_filters_before');

        /**
         * Template -> Job Listing Wrapper Start:
         * 
         * - SJB Starting of Job Listing Wrapper
         */
        get_simple_job_board_template('listing/listing-wrapper-start.php');

        if ('false' != strtolower($shortcode_args['search']) && !empty($shortcode_args['search'])):

            /**
             * Template -> Job Filters:
             * 
             * - Keywords Search.
             * - Job Category Filter.
             * - Job Type Filter.
             * - Job Location Filter.
             * 
             * Search jobs by keywords, category, location & type.
             */
            //get_simple_job_board_template('job-filters.php', array('per_page' => $shortcode_args['posts'], 'order' => $shortcode_args['order'], 'categories' => $shortcode_args['category'], 'job_types' => $shortcode_args['type'], 'atts' => $atts, 'location' => $shortcode_args['location'], 'keywords' => $shortcode_args['keywords']));
        endif;

        /**
         * Template -> Job Listing Start:
         * 
         * - SJB Starting of Job List
         */
       get_simple_job_board_template('listing/job-listings-start.php');

        /**
         * Fires before listing jobs on job listing page.
         * 
         * @since   2.2.0
         */
        do_action('sjb_job_listing_before');

        if ($job_query->have_posts()):
            global $counter, $post_count;
            $counter = 1;
            $post_count = $job_query->post_count;
            $post_type = 'jobpost';
            wp_reset_postdata();
            ?>
            <div class="panel-group" id="accordionprime">
            
            <?php
            // Get all the taxonomies for this post type
            $taxonomies = get_object_taxonomies( array( 'post_type' => $post_type ) );
            // print_r($taxonomies);
            $terms = get_terms('jobpost_category');
            // print_r($terms);
            ?>
            
            <style type="text/css">
    .panel-title .glyphicon{
        font-size: 14px;
    }
    .panel-title .glyphicon {
    font-size: 14px;
	  border:2px solid;
		border-radius:50%;
	  padding:2px;
}
</style>
<script>
    $(document).ready(function(){
        // Add minus icon for collapse element which is open by default
        
        // Toggle plus minus icon on show hide of collapse element
        $(".collapsesign").on('show.bs.collapse', function(){
        	$(this).parent().find(".glyphicon").removeClass("glyphicon-plus").addClass("glyphicon-minus");
        }).on('hide.bs.collapse', function(){
        	$(this).parent().find(".glyphicon").removeClass("glyphicon-minus").addClass("glyphicon-plus");
        });
    });
</script>
            
            
            <?php
            foreach( $terms as $term ) :
            ?>
            <div class="panel panel-default">
                <div class="panel-heading cust-panel-head">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordionprime" href="#collapse<?php echo $term->slug?>"><?php echo $term->name; ?></a>
                    </h4>
                </div>
                <div id="collapse<?php echo $term->slug?>" class="panel-collapse collapse">
                    <div class="panel-body job-cat-body">
                    <div class="panel-group" id="accordion">
            
            <?php
            
              $args = array(
                      'post_type' => 'jobpost',
                      'posts_per_page' => -1,  //show all posts
                      'tax_query' => array(
                          array(
                              'taxonomy' => 'jobpost_category',
                              'field' => 'slug',
                              'terms' => $term->slug,
                          )
                      )
       
                  );
              $job_query = new WP_Query($args);

            while ($job_query->have_posts()): $job_query->the_post();

                /**
                 * Hook -> sjb_job_listing_view
                 * 
                 * @hooked sjb_job_listing_view - 10  
                 *              
                 * Display the user defined job listing view:
                 * 
                 * - Either job listing grid view or list view.
                 * 
                 * @since   2.2.3
                 */
                do_action('sjb_job_listing_view');
            endwhile;
        ?>
            </div>
            </div>
            </div>
        </div>
        <?php    
        endforeach;
            /**
             * Template -> Pagination:
             * 
             * - Add Pagination to Resulted Jobs.
             */
            //get_simple_job_board_template('listing/job-pagination.php', array('job_query' => $job_query));
        else:

            /**
             * Template -> No Job Found:
             * 
             * - Display Message on No Job Found.
             */
            get_simple_job_board_template_part('listing/content-no-jobs-found');
        ?>
        </div>
        <?php
        endif;

        wp_reset_postdata();

        /**
         * Fires after listing jobs on job listing page.
         * 
         * @since   2.2.0
         */
        do_action('sjb_job_listing_after');

        /**
         * Template -> Job Listing End:
         * 
         * - SJB Ending of Job List.
         */
        get_simple_job_board_template('listing/job-listings-end.php');

        /**
         * Template -> Job Listing Wrapper End:
         * 
         * - SJB Endding of Job Listing Wrapper
         */
        get_simple_job_board_template('listing/listing-wrapper-end.php');

        $html = ob_get_clean();

        /**
         * Filter -> Modify the Job Listing Shortcode
         * 
         * @since   2.2.0
         * 
         * @param   HTML    $html    Job Listing HTML Structure.
         */
        return apply_filters('sjb_job_listing_shortcode', $html . do_shortcode($content), $atts);
    }

}

new Simple_Job_Board_Shortcode_Jobpost();
